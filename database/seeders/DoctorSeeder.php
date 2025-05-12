<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa data dokter contoh
        $doctorsData = [
            [
                'name' => 'dr. Budi Santoso, Sp.PD',
                'email' => 'budi.santoso@eklinik.com',
                'password' => 'password123',
                'role_id' => 2, // Role dokter
                'specialization' => 'Spesialis Penyakit Dalam',
                'license_number' => 'IDN-12345',
                'education' => 'Universitas Indonesia, Fakultas Kedokteran (2005-2011)',
                'bio' => 'Dokter spesialis penyakit dalam dengan pengalaman lebih dari 10 tahun',
                'experience_years' => 10,
                'consultation_fee' => 150000
            ],
            [
                'name' => 'dr. Diana Putri, Sp.A',
                'email' => 'diana.putri@eklinik.com',
                'password' => 'password123',
                'role_id' => 2, // Role dokter
                'specialization' => 'Spesialis Anak',
                'license_number' => 'IDN-23456',
                'education' => 'Universitas Gadjah Mada, Fakultas Kedokteran (2007-2013)',
                'bio' => 'Dokter spesialis anak dengan pendekatan ramah anak dan keluarga',
                'experience_years' => 8,
                'consultation_fee' => 120000
            ],
            [
                'name' => 'dr. Eko Prasetyo, Sp.OG',
                'email' => 'eko.prasetyo@eklinik.com',
                'password' => 'password123',
                'role_id' => 2, // Role dokter
                'specialization' => 'Spesialis Obstetri & Ginekologi',
                'license_number' => 'IDN-34567',
                'education' => 'Universitas Airlangga, Fakultas Kedokteran (2006-2012)',
                'bio' => 'Dokter spesialis kebidanan dan kandungan dengan spesialisasi dalam perawatan prenatal',
                'experience_years' => 9,
                'consultation_fee' => 175000
            ],
            [
                'name' => 'dr. Farida Amir, Sp.KJ',
                'email' => 'farida.amir@eklinik.com',
                'password' => 'password123',
                'role_id' => 2, // Role dokter
                'specialization' => 'Spesialis Kesehatan Jiwa',
                'license_number' => 'IDN-45678',
                'education' => 'Universitas Padjadjaran, Fakultas Kedokteran (2008-2014)',
                'bio' => 'Dokter spesialis kesehatan mental dengan fokus pada terapi kognitif perilaku',
                'experience_years' => 7,
                'consultation_fee' => 160000
            ],
            [
                'name' => 'dr. Gunawan Wijaya, Sp.THT',
                'email' => 'gunawan.wijaya@eklinik.com',
                'password' => 'password123',
                'role_id' => 2, // Role dokter
                'specialization' => 'Spesialis THT',
                'license_number' => 'IDN-56789',
                'education' => 'Universitas Diponegoro, Fakultas Kedokteran (2005-2011)',
                'bio' => 'Dokter spesialis telinga, hidung, dan tenggorokan dengan keahlian dalam bedah THT',
                'experience_years' => 10,
                'consultation_fee' => 145000
            ]
        ];

        // Masukkan data dokter ke database
        foreach ($doctorsData as $doctorData) {
            // Buat user untuk dokter
            $user = User::create([
                'name' => $doctorData['name'],
                'email' => $doctorData['email'],
                'password' => Hash::make($doctorData['password']),
                'role_id' => $doctorData['role_id'],
            ]);

            // Buat data dokter
            Doctor::create([
                'user_id' => $user->id,
                'specialization' => $doctorData['specialization'],
                'license_number' => $doctorData['license_number'],
                'education' => $doctorData['education'],
                'bio' => $doctorData['bio'],
                'experience_years' => $doctorData['experience_years'],
                'consultation_fee' => $doctorData['consultation_fee'],
                'is_active' => true,
            ]);
        }
    }
}
