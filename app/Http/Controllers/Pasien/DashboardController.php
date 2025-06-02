<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Controller tidak perlu middleware di sini
        // Middleware sudah diterapkan di route
    }

    /**
     * Show the pasien dashboard.
     */
    public function index()
    {

        // Dapatkan data pasien yang sedang login
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return redirect()->route('login')
                ->with('error', 'Data pasien tidak ditemukan');
        }

        // Ambil jadwal berikutnya
        $nextAppointment = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', Carbon::today())
            ->where('status', '!=', 'dibatalkan')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->with('doctor.user')
            ->first();

        // Hitung total kunjungan
        $totalVisits = Appointment::where('patient_id', $patient->id)
            ->where('status', 'selesai')
            ->count();

        // Hitung resep aktif
        $activePrescriptions = Prescription::whereHas('medicalRecord', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })
            ->where('valid_until', '>=', Carbon::today())
            ->count();

        // Ambil riwayat kunjungan terakhir
        $recentVisits = MedicalRecord::where('patient_id', $patient->id)
            ->with(['doctor.user', 'prescription'])
            ->orderBy('record_date', 'desc')
            ->limit(3)
            ->get();

        // Ambil resep aktif
        $activePrescriptionList = Prescription::whereHas('medicalRecord', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })
            ->where('valid_until', '>=', Carbon::today())
            ->with(['medicalRecord.doctor.user', 'prescriptionItems.medicine'])
            ->get();

        // Ambil daftar dokter untuk form buat janji
        $doctors = \App\Models\Doctor::with('user')
            ->where('is_active', true)
            ->get();

        return view('pasien.dashboard', compact(
            'nextAppointment',
            'totalVisits',
            'activePrescriptions',
            'recentVisits',
            'activePrescriptionList',
            'doctors'
        ));
    }
}
