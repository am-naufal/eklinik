<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat roles
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator dengan akses penuh'
            ],
            [
                'name' => 'dokter',
                'description' => 'Dokter dengan akses ke pasien'
            ],
            [
                'name' => 'pasien',
                'description' => 'Pasien dengan akses terbatas'
            ],
            [
                'name' => 'pemilik_klinik',
                'description' => 'Pemilik klinik dengan akses ke laporan'
            ],
            [
                'name' => 'resepsionis',
                'description' => 'Resepsionis yang menangani pasien dan administrasi'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
