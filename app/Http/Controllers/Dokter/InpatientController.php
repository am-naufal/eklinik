<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Inpatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InpatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $status = $request->status ?? '';
        $doctor = Doctor::where('user_id', Auth::user()->id)->first();
        $query = Inpatient::with(['patient', 'room', 'doctor'])
            ->whereHas('patient')
            ->whereHas('room')
            ->where('doctor_id', $doctor->id);

        if (!empty($search)) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('medical_record_number', 'like', "%{$search}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $inpatients = $query->latest()->paginate(10);
        $statuses = ['active' => 'Aktif', 'pulang' => 'Pulang', 'dipindahkan' => 'Dipindahkan'];

        return view('dokter.inpatients.index', compact('inpatients', 'statuses', 'search', 'status'));
    }

    public function show(Inpatient $inpatient)
    {
        if ($inpatient->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Unauthorized action.');
        }

        $inpatient->load(['patient.user', 'room', 'doctor.user', 'medicalRecords']);
        return view('dokter.inpatients.show', compact('inpatient'));
    }

    public function update(Request $request, Inpatient $inpatient)
    {
        if ($inpatient->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:active,discharged,transferred',
            'discharge_note' => 'required_if:status,discharged,transferred|nullable|string',
        ]);

        $inpatient->update([
            'status' => $request->status,
            'discharge_note' => $request->discharge_note,
            'discharge_date' => $request->status !== 'active' ? now() : null,
        ]);

        if ($request->status !== 'active') {
            $inpatient->room->update(['status' => 'tersedia']);
        }

        return redirect()->route('dokter.inpatients.index')
            ->with('success', 'Status pasien rawat inap berhasil diperbarui');
    }
}
