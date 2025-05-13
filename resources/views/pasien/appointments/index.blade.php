@extends('layouts.app')

@section('title', 'Jadwal Kunjungan - E-Klinik')

@section('page-title', 'Jadwal Kunjungan')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Kunjungan</h6>
            <a href="{{ route('pasien.appointments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus fa-sm"></i> Buat Jadwal Baru
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

            @if ($appointments->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                    <p>Anda belum memiliki jadwal kunjungan.</p>
                    <a href="{{ route('pasien.appointments.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus fa-sm"></i> Buat Jadwal Baru
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $index => $appointment)
                                <tr>
                                    <td>{{ $appointments->firstItem() + $index }}</td>
                                    <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('pasien.appointments.show', $appointment) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if ($appointment->status == 'menunggu')
                                            <form action="{{ route('pasien.appointments.cancel', $appointment) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
