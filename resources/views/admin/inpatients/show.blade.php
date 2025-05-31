@extends('layouts.app')

@section('title', 'Detail Rawat Inap')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Rawat Inap</h1>
            <div>
                <a href="{{ route('admin.inpatients.edit', $inpatient->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.inpatients.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Pasien</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">No. Rekam Medis</th>
                                <td>{{ $inpatient->patient->medical_record_number }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pasien</th>
                                <td>{{ $inpatient->patient->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ \Carbon\Carbon::parse($inpatient->patient->date_of_birth)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $inpatient->patient->gender }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $inpatient->patient->address }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $inpatient->patient->phone_number }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Rawat Inap</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th width="200">No. Ruangan</th>
                                <td>{{ $inpatient->room->room_number }}</td>
                            </tr>
                            <tr>
                                <th>Dokter Penanggung Jawab</th>
                                <td>{{ $inpatient->doctor->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>{{ \Carbon\Carbon::parse($inpatient->check_in_date)->format('d-m-Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Keluar</th>
                                <td>{{ $inpatient->check_out_date ? \Carbon\Carbon::parse($inpatient->check_out_date)->format('d-m-Y H:i') : 'Belum Keluar' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'active' => 'primary',
                                            'discharged' => 'success',
                                            'transferred' => 'warning',
                                        ];
                                        $statusLabels = [
                                            'active' => 'Aktif',
                                            'discharged' => 'Pulang',
                                            'transferred' => 'Dipindahkan',
                                        ];
                                    @endphp
                                    <span class="badge badge-{{ $statusClasses[$inpatient->status] }}">
                                        {{ $statusLabels[$inpatient->status] }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Medis</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Diagnosis</h6>
                                <p>{{ $inpatient->diagnosis }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">Rencana Perawatan</h6>
                                <p>{{ $inpatient->treatment_plan }}</p>
                            </div>
                        </div>
                        @if ($inpatient->notes)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="font-weight-bold">Catatan Tambahan</h6>
                                    <p>{{ $inpatient->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
