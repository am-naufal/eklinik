<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
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

        $medicines = $query->orderBy('name')->paginate(10);
        $categories = Medicine::distinct('category')->pluck('category')->filter()->toArray();

        return view('dokter.medicines.index', compact('medicines', 'categories', 'search', 'category'));
    }

    public function create()
    {
        return view('dokter.medicines.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
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

        return redirect()->route('dokter.medicines.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(Medicine $medicine)
    {
        return view('dokter.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:50', Rule::unique('medicines')->ignore($medicine->id)],
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

        return redirect()->route('dokter.medicines.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('dokter.medicines.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}
