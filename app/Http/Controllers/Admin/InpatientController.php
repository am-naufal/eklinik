<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Inpatient;
use App\Models\Patient;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InpatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $inpatients = Inpatient::with(['patient.user', 'room', 'doctor.user'])->get();
            $data = [];

            foreach ($inpatients as $inpatient) {
                $data[] = [
                    'patient' => [
                        'medical_record_number' => $inpatient->patient->medical_record_number,
                    ],
                    'patient_name' => $inpatient->patient->user->name,
                    'room_number' => $inpatient->room->room_number,
                    'doctor_name' => $inpatient->doctor->user->name,
                    'check_in_date' => $inpatient->check_in_date,
                    'check_out_date' => $inpatient->check_out_date,
                    'status' => $inpatient->status,
                    'status_badge' => view('admin.inpatients.status-badge', compact('inpatient'))->render(),
                    'action' => view('admin.inpatients.action', compact('inpatient'))->render(),
                ];
            }

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
                'data' => $data
            ]);
        }

        return view('admin.inpatients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $rooms = Room::where('status', 'available')->get();

        return view('admin.inpatients.create', compact('patients', 'doctors', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'doctor_id' => 'required|exists:doctors,id',
            'check_in_date' => 'required|date',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'active';

        $inpatient = Inpatient::create($validated);

        // Update room status
        $room = Room::find($validated['room_id']);
        $room->update(['status' => 'occupied']);

        return redirect()->route('admin.inpatients.index')
            ->with('success', 'Data rawat inap berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inpatient $inpatient)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $rooms = Room::where('status', 'available')
            ->orWhere('id', $inpatient->room_id)
            ->get();

        return view('admin.inpatients.edit', compact('inpatient', 'patients', 'doctors', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inpatient $inpatient)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_id' => 'required|exists:rooms,id',
            'doctor_id' => 'required|exists:doctors,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'diagnosis' => 'required|string',
            'treatment_plan' => 'required|string',
            'status' => 'required|in:active,discharged,transferred',
            'notes' => 'nullable|string'
        ]);

        $validated['updated_by'] = Auth::id();

        // If room is changed
        if ($inpatient->room_id !== $validated['room_id']) {
            // Free up the old room
            $oldRoom = Room::find($inpatient->room_id);
            $oldRoom->update(['status' => 'available']);

            // Occupy the new room
            $newRoom = Room::find($validated['room_id']);
            $newRoom->update(['status' => 'occupied']);
        }

        // If status is changed to discharged
        if ($validated['status'] === 'discharged' && !$inpatient->check_out_date) {
            $validated['check_out_date'] = now();
            $room = Room::find($validated['room_id']);
            $room->update(['status' => 'available']);
        }

        $inpatient->update($validated);

        return redirect()->route('admin.inpatients.index')
            ->with('success', 'Data rawat inap berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inpatient $inpatient)
    {
        if ($inpatient->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus data rawat inap yang masih aktif'
            ], 422);
        }

        $inpatient->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data rawat inap berhasil dihapus'
        ]);
    }
}
