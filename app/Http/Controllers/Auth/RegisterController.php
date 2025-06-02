<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'gender' => ['nullable', 'in:laki-laki,perempuan'],
        ]);

        // Set role_id untuk pasien (default role untuk user baru)
        $pasienRole = Role::where('name', 'pasien')->first();

        if (!$pasienRole) {
            return back()->withErrors(['error' => 'Role pasien tidak ditemukan. Silakan hubungi administrator.']);
        }

        DB::beginTransaction();
        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $pasienRole->id,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'age' => $request->age,
                'gender' => $request->gender,
            ]);

            // Generate nomor rekam medis
            $medicalRecordNumber = 'RM-' . date('Ymd') . '-' . mt_rand(1000, 9999);

            // Buat data pasien
            Patient::create([
                'user_id' => $user->id,
                'medical_record_number' => $medicalRecordNumber,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'is_active' => true
            ]);

            DB::commit();

            // Login setelah registrasi berhasil
            Auth::login($user);

            // Redirect ke dashboard pasien
            return redirect()->route('pasien.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang di E-Klinik.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                ->withInput();
        }
    }
}
