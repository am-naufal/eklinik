<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date) : Carbon::today();
        $status = $request->status ?? 'all';

        $query = Appointment::with(['patient.user', 'doctor.user']);

        // Filter berdasarkan tanggal
        $query->whereDate('appointment_date', $date);

        // Filter berdasarkan status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $appointments = $query->orderBy('appointment_time')->paginate(15);

        return view('resepsionis.appointments.index', compact('appointments', 'date', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();

        return view('resepsionis.appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Periksa ketersediaan dokter
        $appointmentDateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
        $appointmentEndTime = (clone $appointmentDateTime)->addMinutes(30);

        $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->whereTime('appointment_time', '<=', $appointmentEndTime->format('H:i:s'))
            ->whereTime('appointment_time', '>=', $appointmentDateTime->format('H:i:s'))
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingAppointment) {
            return redirect()->back()
                ->with('error', 'Dokter sudah memiliki jadwal pada waktu tersebut')
                ->withInput();
        }

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('resepsionis.appointments.index')
            ->with('success', 'Jadwal kunjungan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::with(['patient.user', 'doctor.user'])->findOrFail($id);
        // dd($appointment);
        return view('resepsionis.appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::with(['patient.user', 'doctor.user'])->findOrFail($id);
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();

        return view('resepsionis.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
            'status' => 'required|in:Dijadwalkan,Menunggu,Selesai,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Periksa konflik jadwal (hanya jika mengubah dokter, tanggal, atau waktu)
        if (
            $appointment->doctor_id != $request->doctor_id ||
            Carbon::parse($appointment->appointment_date)->format('Y-m-d') != $request->appointment_date ||
            Carbon::parse($appointment->appointment_time)->format('H:i:s') != $request->appointment_time
        ) {

            $appointmentDateTime = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);
            $appointmentEndTime = (clone $appointmentDateTime)->addMinutes(30);

            $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->whereTime('appointment_time', '<=', $appointmentEndTime->format('H:i:s'))
                ->whereTime('appointment_time', '>=', $appointmentDateTime->format('H:i:s'))
                ->where('status', '!=', 'cancelled')
                ->where('id', '!=', $id)
                ->first();

            if ($existingAppointment) {
                return redirect()->back()
                    ->with('error', 'Dokter sudah memiliki jadwal pada waktu tersebut')
                    ->withInput();
            }
        }

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('resepsionis.appointments.index')
            ->with('success', 'Jadwal kunjungan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->update(['status' => 'cancelled']);

            return redirect()->route('resepsionis.appointments.index')
                ->with('success', 'Jadwal kunjungan berhasil dibatalkan');
        } catch (\Exception $e) {
            return redirect()->route('resepsionis.appointments.index')
                ->with('error', 'Jadwal kunjungan tidak dapat dibatalkan');
        }
    }

    /**
     * Check doctor availability
     */
    public function checkAvailability(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->date;

        if (!$doctorId || !$date) {
            return response()->json(['available_times' => []]);
        }

        // Jam praktek (misalnya dari 08:00 sampai 16:00)
        $startTime = Carbon::parse($date . ' 08:00');
        $endTime = Carbon::parse($date . ' 16:00');
        $interval = 30; // menit

        // Daftar semua slot waktu yang mungkin
        $availableTimes = [];
        $current = clone $startTime;

        while ($current <= $endTime) {
            $availableTimes[] = $current->format('H:i');
            $current->addMinutes($interval);
        }

        // Dapatkan semua jadwal yang sudah ada
        $bookedAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->get(['appointment_time']);

        // Hapus slot waktu yang sudah terisi
        foreach ($bookedAppointments as $appointment) {
            $time = Carbon::parse($appointment->appointment_time)->format('H:i');
            $key = array_search($time, $availableTimes);
            if ($key !== false) {
                unset($availableTimes[$key]);
            }
        }

        return response()->json(['available_times' => array_values($availableTimes)]);
    }
}
