<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
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
}
