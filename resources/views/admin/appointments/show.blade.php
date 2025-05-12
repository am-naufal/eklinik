@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Kunjungan</h1>
            <div>
                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-sm btn-warning shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Detail Kunjungan -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kunjungan</h6>
                        <div>
                            <span
                                class="badge badge-pill
                            @if ($appointment->status == 'Dijadwalkan') badge-primary
                            @elseif($appointment->status == 'Menunggu') badge-warning
                            @elseif($appointment->status == 'Selesai') badge-success
                            @elseif($appointment->status == 'Dibatalkan') badge-danger @endif px-3 py-2">
                                {{ $appointment->status }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="font-weight-bold text-dark">Informasi Pasien</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%">Nama Pasien</td>
                                                <td width="60%">:
                                                    <strong>{{ $appointment->patient->user->name }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No. Rekam Medis</td>
                                                <td>: <strong>{{ $appointment->patient->no_rekam_medis }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>: {{ $appointment->patient->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>No. Telepon</td>
                                                <td>: {{ $appointment->patient->phone ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="font-weight-bold text-dark">Informasi Dokter</h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%">Nama Dokter</td>
                                                <td width="60%">: <strong>{{ $appointment->doctor->user->name }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Spesialisasi</td>
                                                <td>: <strong>{{ $appointment->doctor->specialization }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>: {{ $appointment->doctor->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>No. Telepon</td>
                                                <td>: {{ $appointment->doctor->phone ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold text-dark mb-3">Detail Kunjungan</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="20%">Tanggal Kunjungan</td>
                                            <td width="80%">:
                                                <strong>{{ $appointment->appointment_date->format('d F Y') }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Waktu Kunjungan</td>
                                            <td>: <strong>{{ $appointment->appointment_time }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:
                                                <span
                                                    class="badge badge-pill
                                                @if ($appointment->status == 'Dijadwalkan') badge-primary
                                                @elseif($appointment->status == 'Menunggu') badge-warning
                                                @elseif($appointment->status == 'Selesai') badge-success
                                                @elseif($appointment->status == 'Dibatalkan') badge-danger @endif px-3 py-2">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Dibuat</td>
                                            <td>: {{ $appointment->created_at->format('d F Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Terakhir Diperbarui</td>
                                            <td>: {{ $appointment->updated_at->format('d F Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="font-weight-bold text-dark">Alasan Kunjungan</h5>
                                    <div class="p-3 bg-light rounded">
                                        {{ $appointment->reason }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="font-weight-bold text-dark">Catatan</h5>
                                    <div class="p-3 bg-light rounded">
                                        {{ $appointment->notes ?? 'Tidak ada catatan' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
