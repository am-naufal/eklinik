<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan role seeder terlebih dahulu
        $this->call(RoleSeeder::class);

        // Buat admin user
        $adminRole = Role::where('name', 'admin')->first();
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // Buat dokter user
        $dokterRole = Role::where('name', 'dokter')->first();
        User::factory()->create([
            'name' => 'Dokter User',
            'email' => 'dokter@example.com',
            'password' => Hash::make('password'),
            'role_id' => $dokterRole->id,
        ]);

        // Buat pasien user
        $pasienRole = Role::where('name', 'pasien')->first();
        User::factory()->create([
            'name' => 'Pasien User',
            'email' => 'pasien@example.com',
            'password' => Hash::make('password'),
            'role_id' => $pasienRole->id,
        ]);
    }
}
