<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\TreatmentInvoice;
use App\Models\InvoiceItem;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'all';
        $query = TreatmentInvoice::with(['patient.user', 'doctor.user', 'medicalRecord']);

        if ($status !== 'all') {
            $query->where('payment_status', $status);
        }

        $invoices = $query->latest()->paginate(10);

        return view('resepsionis.invoices.index', compact('invoices', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Daftar rekam medis yang belum memiliki invoice
        $medicalRecords = MedicalRecord::whereDoesntHave('invoice')
            ->with(['patient.user', 'doctor.user'])
            ->where('status', 'completed')
            ->latest()
            ->get();

        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name')->get();

        return view('resepsionis.invoices.create', compact('medicalRecords', 'patients', 'doctors', 'medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medical_record_id' => 'required|exists:medical_records,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,cancelled',
            'medicine_id' => 'nullable|array',
            'medicine_id.*' => 'exists:medicines,id',
            'quantity' => 'nullable|array',
            'quantity.*' => 'integer|min:1',
            'medicine_price' => 'nullable|array',
            'medicine_price.*' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Periksa apakah rekam medis sudah memiliki invoice
        $existingInvoice = TreatmentInvoice::where('medical_record_id', $request->medical_record_id)->first();
        if ($existingInvoice) {
            return redirect()->back()
                ->with('error', 'Rekam medis ini sudah memiliki nota penanganan')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Generate invoice number
            $invoiceNumber = TreatmentInvoice::generateInvoiceNumber();

            // Atur paid_at jika status 'paid'
            $paidAt = null;
            if ($request->payment_status === 'paid') {
                $paidAt = Carbon::now();
            }

            // Hitung total biaya obat
            $medicineTotalAmount = 0;
            if ($request->has('medicine_id')) {
                foreach ($request->medicine_id as $index => $medicineId) {
                    if (isset($request->quantity[$index]) && isset($request->medicine_price[$index])) {
                        $quantity = (int) $request->quantity[$index];
                        $price = (float) $request->medicine_price[$index];
                        $medicineTotalAmount += $quantity * $price;
                    }
                }
            }

            // Buat invoice
            $invoice = TreatmentInvoice::create([
                'medical_record_id' => $request->medical_record_id,
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'created_by' => Auth::id(),
                'invoice_number' => $invoiceNumber,
                'total_amount' => $request->total_amount + $medicineTotalAmount,
                'notes' => $request->notes,
                'payment_status' => $request->payment_status,
                'paid_at' => $paidAt,
            ]);

            // Simpan item obat
            if ($request->has('medicine_id')) {
                foreach ($request->medicine_id as $index => $medicineId) {
                    if (isset($request->quantity[$index]) && isset($request->medicine_price[$index])) {
                        $medicine = Medicine::find($medicineId);
                        if ($medicine) {
                            $quantity = (int) $request->quantity[$index];
                            $price = (float) $request->medicine_price[$index];
                            $subtotal = $quantity * $price;

                            // Buat item invoice
                            InvoiceItem::create([
                                'treatment_invoice_id' => $invoice->id,
                                'medicine_id' => $medicineId,
                                'quantity' => $quantity,
                                'price' => $price,
                                'subtotal' => $subtotal,
                                'notes' => $request->medicine_notes[$index] ?? null
                            ]);

                            // Kurangi stok obat
                            $medicine->stock -= $quantity;
                            $medicine->save();
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('resepsionis.invoices.index')
                ->with('success', 'Nota penanganan berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = TreatmentInvoice::with([
            'patient.user',
            'doctor.user',
            'medicalRecord',
            'creator',
            'items.medicine'
        ])->findOrFail($id);

        return view('resepsionis.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = TreatmentInvoice::with([
            'patient.user',
            'doctor.user',
            'medicalRecord',
            'items.medicine'
        ])->findOrFail($id);

        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $medicines = Medicine::where('stock', '>', 0)->orderBy('name')->get();

        return view('resepsionis.invoices.edit', compact('invoice', 'patients', 'doctors', 'medicines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = TreatmentInvoice::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,cancelled',
            'medicine_id' => 'nullable|array',
            'medicine_id.*' => 'exists:medicines,id',
            'quantity' => 'nullable|array',
            'quantity.*' => 'integer|min:1',
            'medicine_price' => 'nullable|array',
            'medicine_price.*' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Update paid_at jika status pembayaran berubah menjadi 'paid'
            $paidAt = $invoice->paid_at;
            if ($request->payment_status === 'paid' && $invoice->payment_status !== 'paid') {
                $paidAt = Carbon::now();
            } elseif ($request->payment_status !== 'paid') {
                $paidAt = null;
            }

            // Kembalikan stok obat untuk item yang ada sebelumnya
            foreach ($invoice->items as $item) {
                $medicine = $item->medicine;
                if ($medicine) {
                    $medicine->stock += $item->quantity;
                    $medicine->save();
                }
            }

            // Hapus semua item lama
            $invoice->items()->delete();

            // Hitung total biaya obat
            $medicineTotalAmount = 0;
            if ($request->has('medicine_id')) {
                foreach ($request->medicine_id as $index => $medicineId) {
                    if (isset($request->quantity[$index]) && isset($request->medicine_price[$index])) {
                        $quantity = (int) $request->quantity[$index];
                        $price = (float) $request->medicine_price[$index];
                        $medicineTotalAmount += $quantity * $price;
                    }
                }
            }

            // Update invoice
            $invoice->update([
                'total_amount' => $request->total_amount + $medicineTotalAmount,
                'notes' => $request->notes,
                'payment_status' => $request->payment_status,
                'paid_at' => $paidAt,
            ]);

            // Simpan item obat baru
            if ($request->has('medicine_id')) {
                foreach ($request->medicine_id as $index => $medicineId) {
                    if (isset($request->quantity[$index]) && isset($request->medicine_price[$index])) {
                        $medicine = Medicine::find($medicineId);
                        if ($medicine) {
                            $quantity = (int) $request->quantity[$index];
                            $price = (float) $request->medicine_price[$index];
                            $subtotal = $quantity * $price;

                            // Buat item invoice
                            InvoiceItem::create([
                                'treatment_invoice_id' => $invoice->id,
                                'medicine_id' => $medicineId,
                                'quantity' => $quantity,
                                'price' => $price,
                                'subtotal' => $subtotal,
                                'notes' => $request->medicine_notes[$index] ?? null
                            ]);

                            // Kurangi stok obat
                            $medicine->stock -= $quantity;
                            $medicine->save();
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('resepsionis.invoices.index')
                ->with('success', 'Nota penanganan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $invoice = TreatmentInvoice::with('items.medicine')->findOrFail($id);

            DB::beginTransaction();

            // Kembalikan stok obat untuk semua item
            foreach ($invoice->items as $item) {
                $medicine = $item->medicine;
                if ($medicine) {
                    $medicine->stock += $item->quantity;
                    $medicine->save();
                }
            }

            // Hapus invoice dan semua itemnya (cascade)
            $invoice->delete();

            DB::commit();

            return redirect()->route('resepsionis.invoices.index')
                ->with('success', 'Nota penanganan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('resepsionis.invoices.index')
                ->with('error', 'Nota penanganan tidak dapat dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Print invoice
     */
    public function print(string $id)
    {
        $invoice = TreatmentInvoice::with([
            'patient.user',
            'doctor.user',
            'medicalRecord',
            'creator',
            'items.medicine'
        ])->findOrFail($id);

        return view('resepsionis.invoices.print', compact('invoice'));
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(string $id)
    {
        try {
            $invoice = TreatmentInvoice::findOrFail($id);

            if ($invoice->payment_status === 'paid') {
                return redirect()->route('resepsionis.invoices.show', $id)
                    ->with('info', 'Nota penanganan sudah dibayar sebelumnya');
            }

            $invoice->update([
                'payment_status' => 'paid',
                'paid_at' => Carbon::now(),
            ]);

            return redirect()->route('resepsionis.invoices.show', $id)
                ->with('success', 'Nota penanganan berhasil ditandai sebagai dibayar');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.invoices.index')
                ->with('error', 'Nota penanganan tidak dapat diperbarui');
        }
    }
}
