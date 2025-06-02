@extends('layouts.app')

@section('title', 'Detail Jadwal Kunjungan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Kunjungan</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Jadwal Kunjungan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th style="width: 200px">Pasien</th>
                                <td>
                                    <a href="{{ route('resepsionis.patients.show', $appointment->patient_id) }}">
                                        {{ $appointment->patient->user->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Dokter</th>
                                <td>{{ $appointment->doctor->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Kunjungan</th>
                                <td>{{ $appointment->appointment_date->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Waktu Kunjungan</th>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($appointment->status == 'Dijadwalkan')
                                        <span class="badge bg-primary text-white">Dijadwalkan</span>
                                    @elseif($appointment->status == 'Menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($appointment->status == 'Selesai')
                                        <span class="badge bg-success text-white">Selesai</span>
                                    @elseif($appointment->status == 'Dibatalkan')
                                        <span class="badge bg-danger text-white">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $appointment->notes ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('resepsionis.appointments.edit', $appointment->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('resepsionis.appointments.destroy', $appointment->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')">
                            <i class="fas fa-trash"></i> Batalkan
                        </button>
                    </form>
                    <a href="{{ route('resepsionis.appointments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
