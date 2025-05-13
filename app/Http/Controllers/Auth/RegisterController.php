<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'gender' => ['nullable', 'in:laki-laki,perempuan'],
        ]);

        // Set role_id untuk pasien (default role untuk user baru)
        $pasienRole = Role::where('name', 'pasien')->first();

        if (!$pasienRole) {
            return back()->withErrors(['error' => 'Role pasien tidak ditemukan. Silakan hubungi administrator.']);
        }

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

        // Login setelah registrasi berhasil
        Auth::login($user);

        // Redirect ke dashboard pasien
        return redirect()->route('pasien.dashboard');
    }
}
