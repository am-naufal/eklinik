<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user')->paginate(10);
        return view('resepsionis.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resepsionis.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:laki-laki,perempuan',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cari role untuk pasien
        $patientRole = Role::where('name', 'pasien')->first();

        if (!$patientRole) {
            return redirect()->back()
                ->with('error', 'Role pasien tidak ditemukan')
                ->withInput();
        }

        // Generate password acak
        $password = Str::random(8);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => $patientRole->id,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
        ]);

        // Buat data pasien
        Patient::create([
            'user_id' => $user->id,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history,
        ]);

        return redirect()->route('resepsionis.patients.index')
            ->with('success', "Pasien berhasil ditambahkan. Password: $password");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::with(['user', 'appointments.doctor.user', 'appointments.medicalRecord'])->findOrFail($id);
        return view('resepsionis.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('resepsionis.patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:laki-laki,perempuan',
            'blood_type' => 'nullable|in:A,B,AB,O',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user data
        $patient->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'age' => $request->age,
            'gender' => $request->gender,
        ]);

        // Update patient data
        $patient->update([
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'medical_history' => $request->medical_history,
        ]);

        return redirect()->route('resepsionis.patients.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $userId = $patient->user_id;

            // Hapus data pasien
            $patient->delete();

            // Hapus user jika diperlukan
            User::destroy($userId);

            return redirect()->route('resepsionis.patients.index')
                ->with('success', 'Pasien berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.patients.index')
                ->with('error', 'Pasien tidak dapat dihapus karena masih memiliki data terkait');
        }
    }

    /**
     * Search patients
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $patients = Patient::whereHas('user', function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('phone_number', 'like', "%{$query}%");
        })->with('user')->paginate(10);

        return view('resepsionis.patients.index', compact('patients', 'query'));
    }
}
