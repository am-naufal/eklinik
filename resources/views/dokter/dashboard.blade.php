@extends('layouts.app')

@section('title', 'Dokter Dashboard - E-Klinik')

@section('page-title', 'Dokter Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pasien Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayAppointments->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pasien</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatients }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jadwal Minggu Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $weeklyAppointments }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pasien Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingAppointments }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Hari Ini</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($todayAppointments->count() > 0)
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Nama Pasien</th>
                                        <th>Keluhan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayAppointments as $appointment)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="font-weight-bold">
                                                            {{ $appointment->patient->user->name }}</div>
                                                        <small
                                                            class="text-muted">{{ $appointment->patient->medical_record_number }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $appointment->reason }}</td>
                                            <td>
                                                @switch($appointment->status)
                                                    @case('Selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @break

                                                    @case('Menunggu')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @break

                                                    @case('Dibatalkan')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @break

                                                    @default
                                                        <span class="badge bg-primary">Dijadwalkan</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if ($appointment->status == 'Selesai')
                                                    @elseif($appointment->status == 'Menunggu')
                                                        <a href="{{ route('dokter.appointments.examine', $appointment->id) }}"
                                                            class="btn btn-sm btn-primary" data-toggle="tooltip"
                                                            title="Mulai Pemeriksaan">
                                                            <i class="fas fa-stethoscope"></i> Periksa
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            <i class="fas fa-clock"></i> Belum Waktunya
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                                <p class="text-gray-500 mb-0">Tidak ada jadwal kunjungan untuk hari ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pasien Terakhir Diperiksa</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse ($recentMedicalRecords as $record)
                            <a href="{{ route('dokter.medical-records.show', $record->id) }}"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $record->patient->name }}
                                        ({{ $record->patient->age ?? '--' }} tahun)
                                    </h6>
                                    <small>{{ $record->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1"><strong>Diagnosa:</strong> {{ $record->diagnosis }}</p>
                                <small><strong>Tindakan:</strong> {{ Str::limit($record->notes, 100) }}</small>
                            </a>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-user-md fa-3x text-gray-300 mb-3"></i>
                                <p class="text-gray-500 mb-0">Belum ada riwayat pemeriksaan pasien</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
