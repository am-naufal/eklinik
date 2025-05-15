<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the medical records.
     */
    public function index()
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();
        $medicalRecords = MedicalRecord::with(['patient', 'prescription'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('record_date', 'desc')
            ->paginate(10);

        return view('dokter.medical_records.index', compact('medicalRecords'));
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        $patients = User::whereHas('role', function ($query) {
            $query->where('name', 'pasien');
        })->get();
        $medicines = Medicine::where('stock', '>', 0)->get();

        return view('dokter.medical_records.create', compact('patients', 'medicines'));
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            // Validate medical record data
            $validated = $request->validate([
                'patient_id' => ['required', 'exists:users,id'],
                'record_date' => ['required', 'date'],
                'complaint' => ['required', 'string'],
                'diagnosis' => ['required', 'string'],
                'notes' => ['nullable', 'string'],

                // Treatment data
                'treatments' => ['nullable', 'array'],
                'treatments.*.name' => ['required', 'string'],
                'treatments.*.description' => ['nullable', 'string'],
                'treatments.*.cost' => ['required', 'numeric', 'min:0'],

                // Prescription data
                'has_prescription' => ['nullable', 'boolean'],
                'prescription.issue_date' => ['required_if:has_prescription,1', 'date'],
                'prescription.valid_until' => ['nullable', 'date', 'after_or_equal:prescription.issue_date'],

                // Prescription items data
                'prescription_items' => ['required_if:has_prescription,1', 'array'],
                'prescription_items.*.medicine_id' => ['required', 'exists:medicines,id'],
                'prescription_items.*.quantity' => ['required', 'integer', 'min:1'],
                'prescription_items.*.dosage' => ['required', 'string'],
                'prescription_items.*.frequency' => ['required', 'string'],
                'prescription_items.*.instructions' => ['nullable', 'string'],
            ]);

            // Get doctor id
            $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

            // Create medical record
            $medicalRecord = MedicalRecord::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $doctor->id,
                'record_date' => $validated['record_date'],
                'complaint' => $validated['complaint'],
                'diagnosis' => $validated['diagnosis'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Add treatments if provided
            if (!empty($validated['treatments'])) {
                foreach ($validated['treatments'] as $treatment) {
                    Treatment::create([
                        'medical_record_id' => $medicalRecord->id,
                        'name' => $treatment['name'],
                        'description' => $treatment['description'] ?? null,
                        'cost' => $treatment['cost'],
                    ]);
                }
            }

            // Add prescription if has_prescription is true
            if ($request->has('has_prescription') && $validated['has_prescription']) {
                $prescription = Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'issue_date' => $validated['prescription']['issue_date'],
                    'valid_until' => $validated['prescription']['valid_until'] ?? null,
                ]);

                // Add prescription items
                foreach ($validated['prescription_items'] as $item) {
                    // Get medicine
                    $medicine = Medicine::findOrFail($item['medicine_id']);

                    // Check stock
                    if ($medicine->stock < $item['quantity']) {
                        throw new \Exception("Stok obat {$medicine->name} tidak mencukupi");
                    }

                    // Reduce medicine stock
                    $medicine->update([
                        'stock' => $medicine->stock - $item['quantity']
                    ]);

                    // Create prescription item
                    PrescriptionItem::create([
                        'prescription_id' => $prescription->id,
                        'medicine_id' => $item['medicine_id'],
                        'quantity' => $item['quantity'],
                        'dosage' => $item['dosage'],
                        'frequency' => $item['frequency'],
                        'instructions' => $item['instructions'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dokter.medical-records.index')
                ->with('success', 'Rekam medis berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        // Ensure the doctor can only view their own medical records
        if ($medicalRecord->doctor_id !== $doctor->id) {
            abort(403, 'Tidak memiliki akses ke rekam medis ini');
        }

        $medicalRecord->load(['patient', 'doctor.user', 'treatments', 'prescription.prescriptionItems.medicine']);

        // Debugging - melihat struktur data pasien
        \Log::info('Patient data structure:', [
            'patient' => $medicalRecord->patient,
            'patient_class' => get_class($medicalRecord->patient),
            'patient_attributes' => $medicalRecord->patient->getAttributes()
        ]);

        return view('dokter.medical_records.show', compact('medicalRecord'));
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        // Ensure the doctor can only edit their own medical records
        if ($medicalRecord->doctor_id !== $doctor->id) {
            abort(403, 'Tidak memiliki akses ke rekam medis ini');
        }

        $medicalRecord->load(['patient', 'treatments', 'prescription.prescriptionItems.medicine']);
        $patients = User::whereHas('role', function ($query) {
            $query->where('name', 'pasien');
        })->get();
        $medicines = Medicine::where('stock', '>', 0)->get();

        return view('dokter.medical_records.edit', compact('medicalRecord', 'patients', 'medicines'));
    }

    /**
     * Update the specified medical record in storage.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        // Ensure the doctor can only update their own medical records
        if ($medicalRecord->doctor_id !== $doctor->id) {
            abort(403, 'Tidak memiliki akses ke rekam medis ini');
        }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Validate medical record data
            $validated = $request->validate([
                'patient_id' => ['required', 'exists:users,id'],
                'record_date' => ['required', 'date'],
                'complaint' => ['required', 'string'],
                'diagnosis' => ['required', 'string'],
                'notes' => ['nullable', 'string'],
            ]);

            // Update medical record
            $medicalRecord->update([
                'patient_id' => $validated['patient_id'],
                'record_date' => $validated['record_date'],
                'complaint' => $validated['complaint'],
                'diagnosis' => $validated['diagnosis'],
                'notes' => $validated['notes'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('dokter.medical-records.show', $medicalRecord)
                ->with('success', 'Rekam medis berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $doctor = Doctor::where('user_id', Auth::id())->firstOrFail();

        // Ensure the doctor can only delete their own medical records
        if ($medicalRecord->doctor_id !== $doctor->id) {
            abort(403, 'Tidak memiliki akses ke rekam medis ini');
        }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Delete medical record (will cascade delete all related records)
            $medicalRecord->delete();

            DB::commit();

            return redirect()->route('dokter.medical-records.index')
                ->with('success', 'Rekam medis berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
