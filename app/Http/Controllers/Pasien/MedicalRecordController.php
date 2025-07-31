<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {

        $patient = Patient::where('user_id', Auth::user()->id)->first();


        // Eksekusi jika ada rekam medis
        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->with(['doctor', 'appointment'])
            ->latest()
            ->paginate(10);
        return view('pasien.medical-records.index', compact('medicalRecords'));
    }

    public function show(MedicalRecord $medicalRecord)
    {
        // Memastikan pasien hanya bisa melihat rekam medis mereka sendiri
        $patient = Patient::where('user_id', Auth::user()->id)->first();
        if ($medicalRecord->patient_id !== $patient->id) {
            abort(403, 'Unauthorized action.');
        }

        // Load relasi yang diperlukan
        $medicalRecord->load(['doctor', 'appointment']);

        return view('pasien.medical-records.show', compact('medicalRecord'));
    }
}
