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

        $inpatients = Inpatient::with(['patient', 'room', 'doctor'])->get();

        if (Auth::user()->role->name == 'resepsionis') {
            return view('resepsionis.inpatients.index', compact('inpatients'));
        } elseif (Auth::user()->role->name == 'admin') {
            return view('admin.inpatients.index', compact('inpatients'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inpatient $inpatient)
    {
        $inpatient->load(['patient.user', 'room', 'doctor.user']);
        if (Auth::user()->role->name == 'resepsionis') {
            return view('resepsionis.inpatients.show', compact('inpatient'));
        } elseif (Auth::user()->role->name == 'admin') {
            return view('admin.inpatients.show', compact('inpatient'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $rooms = Room::where('status', 'tersedia')->get();
        if (Auth::user()->role->name == 'resepsionis') {
            return view('resepsionis.inpatients.create', compact('patients', 'doctors', 'rooms'));
        } elseif (Auth::user()->role->name == 'admin') {
            return view('admin.inpatients.create', compact('patients', 'doctors', 'rooms'));
        }
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
        $room->update(['status' => 'terisi']);

        if (Auth::user()->role->name == 'resepsionis') {
            return redirect()->route('resepsionis.inpatients.index')
                ->with('success', 'Data rawat inap berhasil ditambahkan');
        } elseif (Auth::user()->role->name == 'admin') {
            return redirect()->route('admin.inpatients.index')
                ->with('success', 'Data rawat inap berhasil ditambahkan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inpatient $inpatient)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $rooms = Room::where('status', 'tersedia')
            ->orWhere('id', $inpatient->room_id)
            ->get();

        if (Auth::user()->role->name == 'resepsionis') {
            return view('resepsionis.inpatients.edit', compact('inpatient', 'patients', 'doctors', 'rooms'));
        } elseif (Auth::user()->role->name == 'admin') {
            return view('admin.inpatients.edit', compact('inpatient', 'patients', 'doctors', 'rooms'));
        }
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
            $oldRoom->update(['status' => 'tersedia']);

            // Occupy the new room
            $newRoom = Room::find($validated['room_id']);
            $newRoom->update(['status' => 'terisi']);
        }

        // If status is changed to discharged
        if ($validated['status'] === 'discharged' && !$inpatient->check_out_date) {
            $validated['check_out_date'] = now();
            $room = Room::find($validated['room_id']);
            $room->update(['status' => 'tersedia']);
        }

        $inpatient->update($validated);

        if (Auth::user()->role->name == 'resepsionis') {
            return redirect()->route('resepsionis.inpatients.index')
                ->with('success', 'Data rawat inap berhasil diperbarui');
        } elseif (Auth::user()->role->name == 'admin') {
            return redirect()->route('admin.inpatients.index')
                ->with('success', 'Data rawat inap berhasil diperbarui');
        }
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
