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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::latest()->paginate(10);
        return view('pemilik.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pemilik.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:keuangan,kunjungan,medis',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate report data based on type
        $data = $this->generateReportData(
            $request->type,
            $request->start_date,
            $request->end_date
        );

        Report::create([
            'title' => $request->title,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'data' => $data,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('pemilik.reports.index')
            ->with('success', 'Laporan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::findOrFail($id);
        return view('pemilik.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = Report::findOrFail($id);
        return view('pemilik.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:keuangan,kunjungan,medis',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $report = Report::findOrFail($id);

        // Regenerate report data if type or dates changed
        if (
            $report->type != $request->type ||
            $report->start_date->format('Y-m-d') != $request->start_date ||
            $report->end_date->format('Y-m-d') != $request->end_date
        ) {

            $data = $this->generateReportData(
                $request->type,
                $request->start_date,
                $request->end_date
            );

            $report->data = $data;
        }

        $report->title = $request->title;
        $report->type = $request->type;
        $report->start_date = $request->start_date;
        $report->end_date = $request->end_date;
        $report->description = $request->description;
        $report->save();

        return redirect()->route('pemilik.reports.index')
            ->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('pemilik.reports.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Generate report data based on type and date range
     */
    private function generateReportData(string $type, string $startDate, string $endDate): array
    {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        switch ($type) {
            case 'kunjungan':
                return $this->generateVisitReport($startDate, $endDate);

            case 'medis':
                return $this->generateMedicalReport($startDate, $endDate);

            case 'keuangan':
                return $this->generateFinancialReport($startDate, $endDate);

            default:
                return [];
        }
    }

    /**
     * Generate visit report data
     */
    private function generateVisitReport(Carbon $startDate, Carbon $endDate): array
    {
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->get();

        $totalAppointments = $appointments->count();
        $completedAppointments = $appointments->where('status', 'completed')->count();
        $cancelledAppointments = $appointments->where('status', 'cancelled')->count();
        $pendingAppointments = $appointments->where('status', 'pending')->count();

        // Group by date
        $appointmentsByDate = $appointments->groupBy(function ($item) {
            return Carbon::parse($item->appointment_date)->format('Y-m-d');
        })->map(function ($group) {
            return $group->count();
        });

        // Group by doctor
        $appointmentsByDoctor = $appointments->groupBy('doctor_id')
            ->map(function ($group) {
                $doctor = Doctor::find($group->first()->doctor_id);
                return [
                    'name' => $doctor ? $doctor->user->name : 'Unknown',
                    'count' => $group->count()
                ];
            });

        return [
            'total' => $totalAppointments,
            'completed' => $completedAppointments,
            'cancelled' => $cancelledAppointments,
            'pending' => $pendingAppointments,
            'by_date' => $appointmentsByDate,
            'by_doctor' => $appointmentsByDoctor
        ];
    }

    /**
     * Generate medical report data
     */
    private function generateMedicalReport(Carbon $startDate, Carbon $endDate): array
    {
        $records = MedicalRecord::whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalRecords = $records->count();

        // Common treatments
        $commonTreatments = $records->map(function ($record) {
            return optional($record->treatment)->name ?? 'No treatment';
        })->countBy();

        // Records by doctor
        $recordsByDoctor = $records->groupBy('doctor_id')
            ->map(function ($group) {
                $doctor = Doctor::find($group->first()->doctor_id);
                return [
                    'name' => $doctor ? $doctor->user->name : 'Unknown',
                    'count' => $group->count()
                ];
            });

        return [
            'total_records' => $totalRecords,
            'common_treatments' => $commonTreatments,
            'by_doctor' => $recordsByDoctor
        ];
    }

    /**
     * Generate financial report data (contoh sederhana)
     */
    private function generateFinancialReport(Carbon $startDate, Carbon $endDate): array
    {
        // Dalam contoh ini kita anggap setiap kunjungan memiliki biaya Rp 100.000
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->get();

        $totalIncome = $appointments->count() * 100000;

        // Pendapatan per hari
        $incomeByDate = $appointments->groupBy(function ($item) {
            return Carbon::parse($item->appointment_date)->format('Y-m-d');
        })->map(function ($group) {
            return $group->count() * 100000;
        });

        return [
            'total_income' => $totalIncome,
            'appointment_count' => $appointments->count(),
            'income_by_date' => $incomeByDate
        ];
    }
}
