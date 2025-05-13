<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TreatmentInvoice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard resepsionis
     */
    public function index()
    {
        // Data untuk ringkasan dashboard
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();

        // Kunjungan hari ini
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->with(['patient.user', 'doctor.user'])
            ->get();

        // Kunjungan besok
        $tomorrowAppointments = Appointment::whereDate('appointment_date', Carbon::tomorrow())
            ->orderBy('appointment_time')
            ->with(['patient.user', 'doctor.user'])
            ->count();

        // Ringkasan pembayaran
        $pendingInvoices = TreatmentInvoice::where('payment_status', 'pending')->count();
        $totalPaidToday = TreatmentInvoice::whereDate('paid_at', Carbon::today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        return view('resepsionis.dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'todayAppointments',
            'tomorrowAppointments',
            'pendingInvoices',
            'totalPaidToday'
        ));
    }
}
