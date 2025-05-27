<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the patient's appointments.
     */
    public function index()
    {
        $patient = Patient::where('user_id', Auth::id())->first();
        // $patientall = Patient::all();

        // dd($patientall);
        if (!$patient) {
            return redirect()->route('pasien.dashboard')
                ->with('error', 'Data pasien tidak ditemukan');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->with('doctor')
            ->paginate(10);

        return view('pasien.appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('pasien.appointments.create', compact('doctors'));
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'required|string|max:255',
        ]);

        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return redirect()->route('pasien.dashboard')
                ->with('error', 'Data pasien tidak ditemukan');
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'selesai',
            'notes' => $request->notes ?? null,
        ]);

        $appointment = Appointment::where('patient_id', $patient->id)
            ->where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->first();

        $appointment->update(['status' => 'selesai']);

        return redirect()->route('pasien.appointments.index')
            ->with('success', 'Jadwal kunjungan berhasil dibuat');
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient || $appointment->patient_id != $patient->id) {
            return redirect()->route('pasien.appointments.index')
                ->with('error', 'Anda tidak memiliki akses ke jadwal kunjungan ini');
        }

        return view('pasien.appointments.show', compact('appointment'));
    }

    /**
     * Cancel the appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient || $appointment->patient_id != $patient->id) {
            return redirect()->route('pasien.appointments.index')
                ->with('error', 'Anda tidak memiliki akses ke jadwal kunjungan ini');
        }

        if ($appointment->status != 'menunggu') {
            return redirect()->route('pasien.appointments.show', $appointment)
                ->with('error', 'Jadwal yang sudah dikonfirmasi atau selesai tidak dapat dibatalkan');
        }

        $appointment->update(['status' => 'dibatalkan']);

        return redirect()->route('pasien.appointments.index')
            ->with('success', 'Jadwal kunjungan berhasil dibatalkan');
    }
}
