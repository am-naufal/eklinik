@extends('layouts.app')

@section('title', 'Jadwal Kunjungan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Kunjungan</h1>
            <a href="{{ route('resepsionis.appointments.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jadwal Baru
            </a>
        </div>

        <!-- Filter Box -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Jadwal</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('resepsionis.appointments.index') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Tanggal</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua
                                        Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group pt-4 mt-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter fa-sm"></i> Filter
                                </button>
                                <a href="{{ route('resepsionis.appointments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt fa-sm"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Date Navigation -->
        <div class="mb-4">
            <div class="btn-group">
                <a href="{{ route('resepsionis.appointments.index', ['date' => \Carbon\Carbon::yesterday()->format('Y-m-d'), 'status' => request('status', 'all')]) }}"
                    class="btn btn-outline-primary">
                    <i class="fas fa-chevron-left"></i> Kemarin
                </a>
                <a href="{{ route('resepsionis.appointments.index', ['date' => \Carbon\Carbon::today()->format('Y-m-d'), 'status' => request('status', 'all')]) }}"
                    class="btn btn-outline-primary {{ request('date', \Carbon\Carbon::today()->format('Y-m-d')) == \Carbon\Carbon::today()->format('Y-m-d') ? 'active' : '' }}">
                    Hari Ini
                </a>
                <a href="{{ route('resepsionis.appointments.index', ['date' => \Carbon\Carbon::tomorrow()->format('Y-m-d'), 'status' => request('status', 'all')]) }}"
                    class="btn btn-outline-primary">
                    Besok <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <!-- Date Display -->
        <div class="alert alert-info">
            <h5 class="mb-0">
                <i class="fas fa-calendar-day"></i>
                Jadwal Kunjungan untuk:
                <strong>{{ \Carbon\Carbon::parse(request('date', \Carbon\Carbon::today()->format('Y-m-d')))->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>
            </h5>
        </div>

        <!-- Appointments Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Kunjungan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                                    <td>
                                        <a href="{{ route('resepsionis.patients.show', $appointment->patient_id) }}">
                                            {{ $appointment->patient->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $appointment->doctor->user->name }}</td>
                                    <td>
                                        @if ($appointment->status == 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($appointment->status == 'completed')
                                            <span class="badge badge-success">Selesai</span>
                                        @elseif($appointment->status == 'cancelled')
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $appointment->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $appointment->notes ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('resepsionis.appointments.show', $appointment->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('resepsionis.appointments.edit', $appointment->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('resepsionis.appointments.destroy', $appointment->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada jadwal kunjungan untuk tanggal ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $appointments->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": false,
                "ordering": true,
                "info": false,
                "searching": false
            });
        });
    </script>
@endsection
