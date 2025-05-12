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
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
