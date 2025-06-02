@extends('layouts.app')

@section('title', 'Detail Rekam Medis - E-Klinik')

@section('page-title', 'Detail Rekam Medis')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Rekam Medis</h6>
                    <a href="{{ route('pasien.medical-records.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-weight-bold text-primary mb-3">Informasi Kunjungan</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Tanggal</th>
                                        <td>{{ $medicalRecord->created_at->format('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dokter</th>
                                        <td>dr. {{ $medicalRecord->doctor->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kunjungan</th>
                                        <td>{{ $medicalRecord->appointment->type ?? 'Pemeriksaan Umum' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="mb-4">
                                <h5 class="font-weight-bold text-primary mb-3">Diagnosa & Tindakan</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Diagnosa</h6>
                                        <p>{{ $medicalRecord->diagnosis }}</p>

                                        <h6 class="font-weight-bold mt-3">Tindakan</h6>
                                        <p>{{ $medicalRecord->treatment }}</p>

                                        @if ($medicalRecord->notes)
                                            <h6 class="font-weight-bold mt-3">Catatan Tambahan</h6>
                                            <p>{{ $medicalRecord->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="font-weight-bold text-primary mb-3">Resep Obat</h5>
                                @if ($medicalRecord->medicines->isEmpty())
                                    <div class="alert alert-info">
                                        Tidak ada resep obat
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Aturan Pakai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($medicalRecord->medicines as $medicine)
                                                    <tr>
                                                        <td>{{ $medicine->name }}</td>
                                                        <td>{{ $medicine->pivot->dosage }}</td>
                                                        <td>{{ $medicine->pivot->instructions }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            @if ($medicalRecord->next_appointment)
                                <div class="mb-4">
                                    <h5 class="font-weight-bold text-primary mb-3">Jadwal Kontrol</h5>
                                    <div class="alert alert-info">
                                        <i class="fas fa-calendar-alt"></i>
                                        Jadwal kontrol berikutnya: {{ $medicalRecord->next_appointment->format('d F Y') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
