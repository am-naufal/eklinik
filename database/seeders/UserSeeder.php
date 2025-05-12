<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin user
        $adminRole = Role::where('name', 'admin')->first();
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@eklinik.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
        ]);
    }
}
