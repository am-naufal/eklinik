<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        // Atur timezone untuk Carbon
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Show the dokter dashboard.
     */
    public function index()
    {
        // Get the doctor's ID
        $doctorId = Doctor::where('user_id', Auth::id())->first()->id;
        Log::info('Doctor ID: ' . $doctorId);

        // Get today's appointments for this doctor
        $todayAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->with(['patient.user'])
            ->get();

        Log::info('Today Appointments:', ['count' => $todayAppointments->count(), 'data' => $todayAppointments->toArray()]);

        // Get statistics
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::where('doctor_id', $doctorId)->count();
        $weeklyAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();
        $pendingAppointments = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'Menunggu')
            ->count();

        // Get recently examined patients
        $recentMedicalRecords = MedicalRecord::where('doctor_id', $doctorId)
            ->orderBy('created_at', 'desc')
            ->with('patient')
            ->limit(4)
            ->get();

        return view('dokter.dashboard', compact(
            'todayAppointments',
            'totalPatients',
            'totalAppointments',
            'weeklyAppointments',
            'pendingAppointments',
            'recentMedicalRecords'
        ));
    }
}
