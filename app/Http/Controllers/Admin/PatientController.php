<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'medical_record_number' => 'required|string|unique:patients',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'blood_type' => 'nullable|string|max:3',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:15',
            'insurance_number' => 'nullable|string|max:255',
            'insurance_provider' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Buat user baru
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => 3, // Pasien role
            ]);

            // Buat data pasien
            $patient = Patient::create([
                'user_id' => $user->id,
                'medical_record_number' => $validatedData['medical_record_number'],
                'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'blood_type' => $validatedData['blood_type'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'phone_number' => $validatedData['phone_number'] ?? null,
                'emergency_contact' => $validatedData['emergency_contact'] ?? null,
                'emergency_phone' => $validatedData['emergency_phone'] ?? null,
                'insurance_number' => $validatedData['insurance_number'] ?? null,
                'insurance_provider' => $validatedData['insurance_provider'] ?? null,
                'is_active' => true,
            ]);

            DB::commit();
            return redirect()->route('admin.patients.index')
                ->with('success', 'Data pasien berhasil ditambahkan.');
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
    public function show(Patient $patient)
    {
        $patient->load('user', 'medicalRecords');
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'medical_record_number' => 'required|string|unique:patients,medical_record_number,' . $patient->id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'blood_type' => 'nullable|string|max:3',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:15',
            'insurance_number' => 'nullable|string|max:255',
            'insurance_provider' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $patient->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);

            // Update password jika diisi
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'string|min:8',
                ]);
                $patient->user->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }

            // Update data pasien
            $patient->update([
                'medical_record_number' => $validatedData['medical_record_number'],
                'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                'gender' => $validatedData['gender'] ?? null,
                'blood_type' => $validatedData['blood_type'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'phone_number' => $validatedData['phone_number'] ?? null,
                'emergency_contact' => $validatedData['emergency_contact'] ?? null,
                'emergency_phone' => $validatedData['emergency_phone'] ?? null,
                'insurance_number' => $validatedData['insurance_number'] ?? null,
                'insurance_provider' => $validatedData['insurance_provider'] ?? null,
                'is_active' => $validatedData['is_active'] ?? true,
            ]);

            DB::commit();
            return redirect()->route('admin.patients.index')
                ->with('success', 'Data pasien berhasil diperbarui.');
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
    public function destroy(Patient $patient)
    {
        DB::beginTransaction();
        try {
            // Hapus user terlebih dahulu
            $patient->user->delete();
            DB::commit();
            return redirect()->route('admin.patients.index')
                ->with('success', 'Data pasien berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.patients.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
