@extends('layouts.app')

@section('title', 'Detail Jadwal Kunjungan - E-Klinik')

@section('page-title', 'Detail Jadwal Kunjungan')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Kunjungan</h6>
            <a href="{{ route('pasien.appointments.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="appointment-details p-4 border rounded">
                        <div class="mb-4 d-flex justify-content-between align-items-start">
                            <h5 class="text-primary">Jadwal Kunjungan #{{ $appointment->id }}</h5>
                            <span class="ms-2">
                                @if ($appointment->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($appointment->status == 'dikonfirmasi')
                                    <span class="badge bg-success">Dikonfirmasi</span>
                                @elseif ($appointment->status == 'selesai')
                                    <span class="badge bg-primary">Selesai</span>
                                @elseif ($appointment->status == 'dibatalkan')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">{{ $appointment->status }}</span>
                                @endif
                            </span>
                        </div>

                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-calendar-day text-primary me-2"></i>
                                <strong>Tanggal:</strong> {{ $appointment->appointment_date->format('d M Y') }}</p>
                            <p class="mb-1"><i class="fas fa-clock text-primary me-2"></i> <strong>Waktu:</strong>
                                {{ $appointment->appointment_time }}</p>
                        </div>

                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-user-md text-primary me-2"></i> <strong>Dokter:</strong>
                                {{ $appointment->doctor->name }}</p>
                            <p class="mb-1"><i class="fas fa-stethoscope text-primary me-2"></i>
                                <strong>Spesialisasi:</strong> {{ $appointment->doctor->specialization }}</p>
                        </div>

                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-comment-medical text-primary me-2"></i> <strong>Alasan
                                    Kunjungan:</strong></p>
                            <p class="mb-1 ps-4">{{ $appointment->reason }}</p>
                        </div>

                        @if ($appointment->notes)
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-clipboard text-primary me-2"></i> <strong>Catatan
                                        Tambahan:</strong></p>
                                <p class="mb-1 ps-4">{{ $appointment->notes }}</p>
                            </div>
                        @endif

                        <div class="mt-4">
                            @if ($appointment->status == 'menunggu')
                                <form action="{{ route('pasien.appointments.cancel', $appointment) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')">
                                        <i class="fas fa-times me-1"></i> Batalkan Jadwal
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="p-4 border rounded h-100">
                        <h5 class="text-primary mb-4">Informasi Klinik</h5>
                        <div class="mb-3">
                            <p class="mb-1"><i class="fas fa-hospital text-primary me-2"></i> <strong>Nama
                                    Klinik:</strong> E-Klinik</p>
                            <p class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i>
                                <strong>Alamat:</strong> Jl. Kesehatan No. 123, Jakarta</p>
                            <p class="mb-1"><i class="fas fa-phone text-primary me-2"></i> <strong>Telepon:</strong> (021)
                                123-4567</p>
                        </div>

                        <div class="alert alert-info mt-4">
                            <h6 class="alert-heading">Petunjuk Kunjungan:</h6>
                            <ul class="mb-0">
                                <li>Datang 15 menit sebelum waktu yang dijadwalkan</li>
                                <li>Bawa kartu identitas dan kartu pasien Anda</li>
                                <li>Jika perlu membatalkan, lakukan minimal 24 jam sebelumnya</li>
                                <li>Gunakan masker dan ikuti protokol kesehatan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
