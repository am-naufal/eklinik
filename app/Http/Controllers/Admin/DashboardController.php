<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\TreatmentInvoice;
use App\Models\Medicine;
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
     * Show the admin dashboard.
     */
    public function index()
    {
        // Mengambil jumlah total dokter
        $totalDoctors = Doctor::count();

        // Mengambil jumlah total pasien
        $totalPatients = Patient::count();

        // Mengambil jumlah appointment hari ini
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();

        // Mengambil pendapatan bulan ini
        $currentMonthIncome = TreatmentInvoice::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount');

        // Mengambil appointment terbaru dengan data pasien dan dokter
        $latestAppointments = Appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date', 'desc')
            ->limit(4)
            ->get();

        // Mengambil obat dengan stok menipis
        $lowStockMedicines = Medicine::where('stock', '<=', 10)->count();

        return view('admin.dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'todayAppointments',
            'currentMonthIncome',
            'latestAppointments',
            'lowStockMedicines'
        ));
    }
}
