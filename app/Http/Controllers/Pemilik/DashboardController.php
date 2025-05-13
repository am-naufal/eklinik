<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard pemilik klinik
     */
    public function index()
    {
        // Ambil data untuk ringkasan dashboard
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $totalMedicalRecords = MedicalRecord::count();

        // Kunjungan dalam 7 hari terakhir
        $recentAppointments = Appointment::whereDate('appointment_date', '>=', Carbon::now()->subDays(7))
            ->count();

        // Laporan terbaru
        $recentReports = Report::latest()->take(5)->get();

        return view('pemilik.dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalAppointments',
            'totalMedicalRecords',
            'recentAppointments',
            'recentReports'
        ));
    }
}
