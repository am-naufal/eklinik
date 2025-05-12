<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa data pasien contoh
        $patientsData = [
            [
                'name' => 'Ahmad Gunawan',
                'email' => 'ahmad.gunawan@gmail.com',
                'password' => 'password123',
                'role_id' => 3, // Role pasien
                'medical_record_number' => 'RM-2023-001',
                'date_of_birth' => '1985-05-15',
                'gender' => 'Laki-laki',
                'blood_type' => 'O',
                'address' => 'Jl. Mawar No. 10, Jakarta Selatan',
                'phone_number' => '081234567890',
                'emergency_contact' => 'Siti Gunawan (Istri)',
                'emergency_phone' => '081234567891',
                'insurance_number' => 'BPJS-1234567890',
                'insurance_provider' => 'BPJS Kesehatan'
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@gmail.com',
                'password' => 'password123',
                'role_id' => 3, // Role pasien
                'medical_record_number' => 'RM-2023-002',
                'date_of_birth' => '1990-08-23',
                'gender' => 'Perempuan',
                'blood_type' => 'A',
                'address' => 'Jl. Anggrek No. 5, Jakarta Timur',
                'phone_number' => '081345678901',
                'emergency_contact' => 'Budi Rahayu (Suami)',
                'emergency_phone' => '081345678902',
                'insurance_number' => 'ASR-9876543210',
                'insurance_provider' => 'Asuransi Kesehatan Swasta'
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@gmail.com',
                'password' => 'password123',
                'role_id' => 3, // Role pasien
                'medical_record_number' => 'RM-2023-003',
                'date_of_birth' => '1978-12-10',
                'gender' => 'Laki-laki',
                'blood_type' => 'B',
                'address' => 'Jl. Melati No. 15, Jakarta Utara',
                'phone_number' => '081456789012',
                'emergency_contact' => 'Rina Hermawan (Istri)',
                'emergency_phone' => '081456789013',
                'insurance_number' => 'BPJS-2345678901',
                'insurance_provider' => 'BPJS Kesehatan'
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@gmail.com',
                'password' => 'password123',
                'role_id' => 3, // Role pasien
                'medical_record_number' => 'RM-2023-004',
                'date_of_birth' => '1995-03-28',
                'gender' => 'Perempuan',
                'blood_type' => 'AB',
                'address' => 'Jl. Kenanga No. 8, Jakarta Barat',
                'phone_number' => '081567890123',
                'emergency_contact' => 'Agus Lestari (Ayah)',
                'emergency_phone' => '081567890124',
                'insurance_number' => 'MND-8765432109',
                'insurance_provider' => 'Mandiri Inhealth'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'password' => 'password123',
                'role_id' => 3, // Role pasien
                'medical_record_number' => 'RM-2023-005',
                'date_of_birth' => '1980-11-05',
                'gender' => 'Laki-laki',
                'blood_type' => 'O',
                'address' => 'Jl. Dahlia No. 12, Jakarta Pusat',
                'phone_number' => '081678901234',
                'emergency_contact' => 'Rina Santoso (Istri)',
                'emergency_phone' => '081678901235',
                'insurance_number' => 'BPJS-3456789012',
                'insurance_provider' => 'BPJS Kesehatan'
            ]
        ];

        // Masukkan data pasien ke database
        foreach ($patientsData as $patientData) {
            // Buat user untuk pasien
            $user = User::create([
                'name' => $patientData['name'],
                'email' => $patientData['email'],
                'password' => Hash::make($patientData['password']),
                'role_id' => $patientData['role_id'],
            ]);

            // Buat data pasien
            Patient::create([
                'user_id' => $user->id,
                'medical_record_number' => $patientData['medical_record_number'],
                'date_of_birth' => $patientData['date_of_birth'],
                'gender' => $patientData['gender'],
                'blood_type' => $patientData['blood_type'],
                'address' => $patientData['address'],
                'phone_number' => $patientData['phone_number'],
                'emergency_contact' => $patientData['emergency_contact'],
                'emergency_phone' => $patientData['emergency_phone'],
                'insurance_number' => $patientData['insurance_number'],
                'insurance_provider' => $patientData['insurance_provider'],
                'is_active' => true,
            ]);
        }
    }
}
