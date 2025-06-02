<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Dapatkan ID dokter yang sedang login
        $doctorId = Doctor::where('user_id', Auth::id())->first()->id;

        // Ambil semua janji temu untuk dokter ini
        $appointments = Appointment::with(['patient.user'])
            ->where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('dokter.appointments.index', compact('appointments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        // Dapatkan ID dokter yang sedang login
        $doctorId = Doctor::where('user_id', Auth::id())->first()->id;

        // Pastikan dokter hanya dapat melihat janji temu miliknya
        if ($appointment->doctor_id != $doctorId) {
            return redirect()->route('dokter.appointments.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat kunjungan ini.');
        }
        $appointment->load(['patient.user', 'doctor.user']);
        return view('dokter.appointments.show', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        // Dapatkan ID dokter yang sedang login
        $doctorId = Doctor::where('user_id', Auth::id())->first()->id;

        // Pastikan dokter hanya dapat memperbarui janji temu miliknya
        if ($appointment->doctor_id != $doctorId) {
            return redirect()->route('dokter.appointments.index')
                ->with('error', 'Anda tidak memiliki akses untuk memperbarui kunjungan ini.');
        }

        $validatedData = $request->validate([
            'status' => 'required|in:Dijadwalkan,Menunggu,Selesai,Dibatalkan',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validatedData);

        return redirect()->route('dokter.appointments.index')
            ->with('success', 'Status kunjungan berhasil diperbarui.');
    }

    /**
     * Show form to examine a patient.
     */
    public function examine(Appointment $appointment)
    {
        // Dapatkan ID dokter yang sedang login
        $doctorId = Doctor::where('user_id', Auth::id())->first()->id;

        // Pastikan dokter hanya dapat memeriksa pasien janji temu miliknya
        if ($appointment->doctor_id != $doctorId) {
            return redirect()->route('dokter.appointments.index')
                ->with('error', 'Anda tidak memiliki akses untuk memeriksa pasien ini.');
        }

        // Pastikan hanya janji temu dengan status Menunggu yang dapat diperiksa
        if ($appointment->status != 'Menunggu') {
            return redirect()->route('dokter.appointments.show', $appointment)
                ->with('error', 'Hanya janji temu dengan status Menunggu yang dapat diperiksa.');
        }

        $appointment->load(['patient.user', 'doctor.user']);

        // Ambil daftar obat yang tersedia
        $medicines = Medicine::where('stock', '>', 0)->get();

        // Ambil riwayat rekam medis pasien sebelumnya
        $previousRecords = MedicalRecord::where('patient_id', $appointment->patient_id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dokter.appointments.examine', compact('appointment', 'medicines', 'previousRecords'));
    }
}
