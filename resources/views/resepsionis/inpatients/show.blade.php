@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detail Rawat Inap</h1>
            <div>
                <a href="{{ route('resepsionis.inpatients.edit', $inpatient) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('resepsionis.inpatients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Pasien</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">Nama Pasien</th>
                                <td>{{ $inpatient->patient->user->name }}</td>
                            </tr>
                            <tr>
                                <th>No. Rekam Medis</th>
                                <td>{{ $inpatient->patient->medical_record_number }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $inpatient->patient->address }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $inpatient->patient->phone }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Dokter</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">Nama Dokter</th>
                                <td>{{ $inpatient->doctor->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Spesialisasi</th>
                                <td>{{ $inpatient->doctor->specialization }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Rawat Inap</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">No. Kamar</th>
                                <td>{{ $inpatient->room->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>{{ $inpatient->check_in_date->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Keluar</th>
                                <td>{{ $inpatient->check_out_date ? $inpatient->check_out_date->format('d/m/Y') : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($inpatient->status === 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($inpatient->status === 'discharged')
                                        <span class="badge bg-info">Pulang</span>
                                    @else
                                        <span class="badge bg-warning">Ditransfer</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Medis</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Diagnosis</label>
                            <p>{{ $inpatient->diagnosis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Rencana Perawatan</label>
                            <p>{{ $inpatient->treatment_plan }}</p>
                        </div>
                        @if ($inpatient->notes)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan</label>
                                <p>{{ $inpatient->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
