@extends('layouts.app')

@section('title', 'Detail Rekam Medis - E-Klinik')

@section('page-title', 'Detail Rekam Medis')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Rekam Medis</h1>
            <a href="{{ route('dokter.medical-records.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <!-- Data Pasien -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Nama Pasien</th>
                                        <td width="5%">:</td>
                                        <td>{{ $medicalRecord->patient->user->name }}</td>
                                    </tr>
                                    <tr>

                                        <th>No. Rekam Medis</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->patient->medical_record_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>:</td>
                                        <td>{{ \Carbon\Carbon::parse($medicalRecord->patient->birth_date ?? null)->format('d-m-Y') ?? '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Jenis Kelamin</th>
                                        <td width="5%">:</td>
                                        <td>{{ $medicalRecord->patient->gender == 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->patient->phone_number ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->patient->address ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Rekam Medis -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Rekam Medis</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Tanggal Periksa</th>
                                        <td width="5%">:</td>
                                        <td>{{ \Carbon\Carbon::parse($medicalRecord->record_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dokter</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->doctor->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keluhan</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->complaint }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Diagnosis</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->diagnosis }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>:</td>
                                        <td>{{ $medicalRecord->notes ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="font-weight-bold">Tindakan</h5>
                                @if ($medicalRecord->treatments->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Tindakan</th>
                                                    <th>Deskripsi</th>
                                                    <th>Biaya</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medicalRecord->treatments as $treatment)
                                                    <tr>
                                                        <td>{{ $treatment->name }}</td>
                                                        <td>{{ $treatment->description ?? '-' }}</td>
                                                        <td>Rp {{ number_format($treatment->cost, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada tindakan yang dilakukan.</p>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="font-weight-bold">Resep Obat</h5>
                                @if ($medicalRecord->prescription)
                                    <div class="mb-3">
                                        <strong>Tanggal Resep:</strong>
                                        {{ \Carbon\Carbon::parse($medicalRecord->prescription->issue_date)->format('d-m-Y') }}<br>
                                        <strong>Berlaku Sampai:</strong>
                                        {{ $medicalRecord->prescription->valid_until ? \Carbon\Carbon::parse($medicalRecord->prescription->valid_until)->format('d-m-Y') : 'Tidak ada batasan' }}
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Jumlah</th>
                                                    <th>Dosis</th>
                                                    <th>Frekuensi</th>
                                                    <th>Instruksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medicalRecord->prescription->prescriptionItems as $item)
                                                    <tr>
                                                        <td>{{ $item->medicine->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->dosage }}</td>
                                                        <td>{{ $item->frequency }}</td>
                                                        <td>{{ $item->instructions ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada resep obat yang diberikan.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
