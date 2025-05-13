<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserResepsionisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan role resepsionis
        $resepsionisRole = Role::where('name', 'resepsionis')->first();

        if (!$resepsionisRole) {
            $this->command->error('Role resepsionis tidak ditemukan. Pastikan untuk menjalankan RoleSeeder terlebih dahulu.');
            return;
        }

        // Data resepsionis contoh
        $resepsionisData = [
            [
                'name' => 'Dewi Resepsionis',
                'email' => 'dewi.resepsionis@eklinik.com',
                'password' => 'password123',
                'phone_number' => '081234567890',
                'address' => 'Jl. Mawar No. 10, Jakarta Selatan',
                'age' => 28,
                'gender' => 'perempuan',
            ],
            [
                'name' => 'Budi Resepsionis',
                'email' => 'budi.resepsionis@eklinik.com',
                'password' => 'password123',
                'phone_number' => '082345678901',
                'address' => 'Jl. Kenanga No. 15, Jakarta Timur',
                'age' => 32,
                'gender' => 'laki-laki',
            ],
            [
                'name' => 'Siti Resepsionis',
                'email' => 'siti.resepsionis@eklinik.com',
                'password' => 'password123',
                'phone_number' => '083456789012',
                'address' => 'Jl. Anggrek No. 7, Jakarta Barat',
                'age' => 25,
                'gender' => 'perempuan',
            ],
        ];

        // Buat user resepsionis
        foreach ($resepsionisData as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $resepsionisRole->id,
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'age' => $data['age'],
                'gender' => $data['gender'],
            ]);
        }

        $this->command->info('Data user resepsionis berhasil dibuat!');
    }
}
