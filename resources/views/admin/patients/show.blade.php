@extends('layouts.app')

@section('title', 'Detail Pasien - E-Klinik')

@section('page-title', 'Detail Pasien')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Pasien</h6>
            <div>
                <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                </a>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <img src="https://via.placeholder.com/150" class="rounded-circle" alt="Profile Picture">
                            </div>
                            <h5 class="text-center">{{ $patient->user->name }}</h5>
                            <p class="text-center text-muted">
                                <span class="badge {{ $patient->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $patient->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </p>
                            <div class="text-center">
                                <p class="mb-1"><strong>No. Rekam Medis:</strong> {{ $patient->medical_record_number }}
                                </p>
                                <p class="mb-1"><strong>Email:</strong> {{ $patient->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <ul class="nav nav-tabs" id="patientTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                type="button" role="tab" aria-controls="info" aria-selected="true">Informasi
                                Umum</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="medical-tab" data-bs-toggle="tab" data-bs-target="#medical"
                                type="button" role="tab" aria-controls="medical" aria-selected="false">Rekam
                                Medis</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="appointments-tab" data-bs-toggle="tab"
                                data-bs-target="#appointments" type="button" role="tab" aria-controls="appointments"
                                aria-selected="false">Janji Temu</button>
                        </li>
                    </ul>

                    <div class="tab-content py-3" id="patientTabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Informasi Pribadi</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Jenis Kelamin</th>
                                            <td>{{ $patient->gender ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Lahir</th>
                                            <td>{{ $patient->date_of_birth ? date('d/m/Y', strtotime($patient->date_of_birth)) : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Umur</th>
                                            <td>{{ $patient->age ?? '-' }} tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Golongan Darah</th>
                                            <td>{{ $patient->blood_type ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $patient->address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $patient->phone_number ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h5>Informasi Tambahan</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Kontak Darurat</th>
                                            <td>{{ $patient->emergency_contact ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon Darurat</th>
                                            <td>{{ $patient->emergency_phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Asuransi</th>
                                            <td>{{ $patient->insurance_provider ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Asuransi</th>
                                            <td>{{ $patient->insurance_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Terdaftar Pada</th>
                                            <td>{{ date('d/m/Y', strtotime($patient->created_at)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="medical" role="tabpanel" aria-labelledby="medical-tab">
                            <h5>Riwayat Rekam Medis</h5>

                            @if ($patient->medicalRecords->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Dokter</th>
                                                <th>Diagnosis</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($patient->medicalRecords as $record)
                                                <tr>
                                                    <td>{{ date('d/m/Y', strtotime($record->created_at)) }}</td>
                                                    <td>{{ $record->doctor->user->name }}</td>
                                                    <td>{{ $record->diagnosis }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Belum ada riwayat rekam medis.
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Janji Temu</h5>
                                <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Buat Janji Temu
                                </a>
                            </div>

                            <div class="alert alert-info">
                                Belum ada janji temu yang terdaftar.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
