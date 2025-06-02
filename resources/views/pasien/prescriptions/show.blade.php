@extends('layouts.app')

@section('title', 'Detail Resep - E-Klinik')

@section('page-title', 'Detail Resep')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Detail Resep</h6>
            <a href="{{ route('pasien.medical-records.show', $prescription->medicalRecord->id) }}"
                class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Rekam Medis
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Informasi Pasien</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nama</th>
                            <td>{{ $prescription->medicalRecord->patient->user->name }}</td>
                        </tr>
                        <tr>
                            <th>No. Rekam Medis</th>
                            <td>{{ $prescription->medicalRecord->patient->medical_record_number }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="font-weight-bold">Informasi Resep</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Tanggal</th>
                            <td>{{ $prescription->issue_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Berlaku Hingga</th>
                            <td>{{ $prescription->valid_until->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Dokter</th>
                            <td>{{ $prescription->medicalRecord->doctor->user->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Dosis</th>
                            <th>Frekuensi</th>
                            <th>Petunjuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescription->prescriptionItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->medicine->name }}</td>
                                <td>{{ $item->dosage }}</td>
                                <td>{{ $item->frequency }}</td>
                                <td>{{ $item->instructions ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Cetak Resep
                </button>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        @media print {

            .btn,
            .navbar,
            .sidebar {
                display: none !important;
            }

            .card {
                border: none !important;
            }

            .card-body {
                padding: 0 !important;
            }
        }
    </style>
@endsection
