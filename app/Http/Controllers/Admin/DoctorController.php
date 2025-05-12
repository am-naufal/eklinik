<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     */
    public function index()
    {
        if (request()->ajax()) {
            $doctors = Doctor::with('user')->get();

            return response()->json([
                'data' => $doctors->map(function ($doctor) {
                    return [
                        'id' => $doctor->id,
                        'name' => $doctor->user->name,
                        'specialization' => $doctor->specialization,
                        'license_number' => $doctor->license_number,
                        'email' => $doctor->user->email,
                        'phone' => $doctor->user->phone_number,
                        'status' => $doctor->is_active ? 'Aktif' : 'Tidak Aktif',
                        'actions' => '
                            <a href="' . route('admin.doctors.show', $doctor) . '" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="' . route('admin.doctors.edit', $doctor) . '" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form class="d-inline" action="' . route('admin.doctors.destroy', $doctor) . '" method="POST" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus dokter ini?\');">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        '
                    ];
                })
            ]);
        }

        return view('admin.doctors.index');
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created doctor in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'specialization' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:50', 'unique:doctors,license_number'],
            'education' => ['required', 'string'],
            'bio' => ['nullable', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'consultation_fee' => ['required', 'numeric', 'min:0']
        ]);

        // Find role for doctor
        $doctorRole = Role::where('name', 'dokter')->first();
        if (!$doctorRole) {
            return back()->with('error', 'Role dokter tidak ditemukan')->withInput();
        }

        // Upload photo if provided
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/doctors', 'public');
        }

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $doctorRole->id,
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'photo' => $photoPath,
        ]);

        // Create doctor profile
        Doctor::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'],
            'education' => $validated['education'],
            'bio' => $validated['bio'] ?? null,
            'experience_years' => $validated['experience_years'],
            'consultation_fee' => $validated['consultation_fee'],
            'is_active' => true
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil ditambahkan');
    }

    /**
     * Display the specified doctor.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load('user');
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified doctor.
     */
    public function edit(Doctor $doctor)
    {
        $doctor->load('user');
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified doctor in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($doctor->user_id)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:laki-laki,perempuan'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'specialization' => ['required', 'string', 'max:255'],
            'license_number' => ['required', 'string', 'max:50', Rule::unique('doctors')->ignore($doctor->id)],
            'education' => ['required', 'string'],
            'bio' => ['nullable', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean']
        ]);

        // Upload photo if provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($doctor->user->photo) {
                Storage::disk('public')->delete($doctor->user->photo);
            }
            $photoPath = $request->file('photo')->store('photos/doctors', 'public');
        }

        // Update user
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
        ];

        if (isset($photoPath)) {
            $userData['photo'] = $photoPath;
        }

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $doctor->user->update($userData);

        // Update doctor profile
        $doctor->update([
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'],
            'education' => $validated['education'],
            'bio' => $validated['bio'] ?? null,
            'experience_years' => $validated['experience_years'],
            'consultation_fee' => $validated['consultation_fee'],
            'is_active' => $validated['is_active']
        ]);

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil diperbarui');
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // Delete photo if exists
        if ($doctor->user->photo) {
            Storage::disk('public')->delete($doctor->user->photo);
        }

        // Delete user (will cascade delete the doctor profile)
        $doctor->user->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success', 'Data dokter berhasil dihapus');
    }
}
