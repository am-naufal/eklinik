<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $category = $request->category ?? '';

        $query = Medicine::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        $medicines = $query->orderBy('name')->get();
        $categories = Medicine::distinct('category')->pluck('category')->filter()->toArray();

        return view('admin.medicines.index', compact('medicines', 'categories', 'search', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:medicines',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Medicine::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $usageCount = InvoiceItem::where('medicine_id', $id)->sum('quantity');
        $invoiceCount = InvoiceItem::where('medicine_id', $id)->distinct('treatment_invoice_id')->count();

        return view('admin.medicines.show', compact('medicine', 'usageCount', 'invoiceCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('admin.medicines.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('medicines')->ignore($medicine->id),
            ],
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $medicine->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicine = Medicine::findOrFail($id);

        // Periksa apakah obat sudah digunakan dalam invoice
        $usageCount = InvoiceItem::where('medicine_id', $id)->count();
        if ($usageCount > 0) {
            return redirect()->route('admin.medicines.index')
                ->with('error', 'Obat tidak dapat dihapus karena sudah digunakan dalam nota penanganan');
        }

        $medicine->delete();

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    /**
     * Update stock of medicine.
     */
    public function updateStock(Request $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'adjustment_type' => 'required|in:add,subtract',
            'adjustment_amount' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $adjustmentAmount = (int) $request->adjustment_amount;

        if ($request->adjustment_type === 'add') {
            $medicine->stock += $adjustmentAmount;
        } else {
            if ($medicine->stock < $adjustmentAmount) {
                return redirect()->back()
                    ->with('error', 'Jumlah pengurangan tidak boleh melebihi stok yang ada')
                    ->withInput();
            }
            $medicine->stock -= $adjustmentAmount;
        }

        $medicine->save();

        $actionText = $request->adjustment_type === 'add' ? 'ditambahkan' : 'dikurangi';

        return redirect()->route('admin.medicines.show', $medicine->id)
            ->with('success', "Stok obat berhasil {$actionText} sebanyak {$adjustmentAmount}");
    }
}
