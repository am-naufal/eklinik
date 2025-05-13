<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserPemilikKlinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan role pemilik klinik
        $pemilikRole = Role::where('name', 'pemilik_klinik')->first();

        if (!$pemilikRole) {
            $this->command->error('Role pemilik_klinik tidak ditemukan. Pastikan untuk menjalankan RoleSeeder terlebih dahulu.');
            return;
        }

        // Data pemilik klinik contoh
        $pemilikData = [
            [
                'name' => 'Joko Pemilik',
                'email' => 'joko.pemilik@eklinik.com',
                'password' => 'password123',
                'phone_number' => '081234567891',
                'address' => 'Jl. Utama No. 1, Jakarta Pusat',
                'age' => 45,
                'gender' => 'laki-laki',
            ],
            [
                'name' => 'Ratna Pemilik',
                'email' => 'ratna.pemilik@eklinik.com',
                'password' => 'password123',
                'phone_number' => '082345678912',
                'address' => 'Jl. Primadona No. 8, Jakarta Selatan',
                'age' => 40,
                'gender' => 'perempuan',
            ],
        ];

        // Buat user pemilik klinik
        foreach ($pemilikData as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $pemilikRole->id,
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'age' => $data['age'],
                'gender' => $data['gender'],
            ]);
        }

        $this->command->info('Data user pemilik klinik berhasil dibuat!');
    }
}
