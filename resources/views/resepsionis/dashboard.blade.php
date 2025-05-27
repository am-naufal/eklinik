@extends('layouts.app')

@section('title', 'Dashboard Resepsionis')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard Resepsionis</h1>
            <div>
                <a href="{{ route('resepsionis.appointments.create') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Jadwal Baru
                </a>
                <a href="{{ route('resepsionis.patients.create') }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ml-2">
                    <i class="fas fa-user-plus fa-sm text-white-50"></i> Pasien Baru
                </a>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Total Pasien Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Pasien</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatients }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Dokter Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Dokter</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDoctors }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-md fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pembayaran Tertunda Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pembayaran Tertunda</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingInvoices }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pembayaran Hari Ini Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Pembayaran Hari Ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                    {{ number_format($totalPaidToday, 0, ',', '.') }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Kunjungan Hari Ini -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Kunjungan Hari Ini</h6>
                        <a href="{{ route('resepsionis.appointments.index') }}" class="btn btn-sm btn-primary">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        @if (count($todayAppointments) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Jam</th>
                                            <th>Pasien</th>
                                            <th>Dokter</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($todayAppointments as $appointment)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}
                                                </td>
                                                <td>{{ $appointment->patient->user->name }}</td>
                                                <td>{{ $appointment->doctor->user->name }}</td>
                                                <td>
                                                    @if ($appointment->status == 'Dijadwalkan')
                                                        <span class="badge badge-primary">Dijadwalkan</span>
                                                    @elseif($appointment->status == 'Menunggu')
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    @elseif($appointment->status == 'Selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif($appointment->status == 'Dibatalkan')
                                                        <span class="badge badge-danger">Dibatalkan</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $appointment->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('resepsionis.appointments.show', $appointment->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('resepsionis.appointments.edit', $appointment->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center py-3">Tidak ada jadwal kunjungan untuk hari ini</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Ringkasan -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Informasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kunjungan Besok
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tomorrowAppointments }}</div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="font-weight-bold">Menu Cepat:</h6>
                            <div class="mt-2">
                                <a href="{{ route('resepsionis.invoices.index') }}" class="btn btn-block btn-info mb-2">
                                    <i class="fas fa-file-invoice-dollar mr-1"></i> Manajemen Nota
                                </a>
                                <a href="{{ route('resepsionis.patients.search') }}?query="
                                    class="btn btn-block btn-primary mb-2">
                                    <i class="fas fa-search mr-1"></i> Cari Pasien
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tanggal dan Waktu -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tanggal & Waktu</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div id="current-date" class="h5 mb-1 font-weight-bold text-gray-800"></div>
                            <div id="current-time" class="h3 mb-0 font-weight-bold text-primary"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Tampilkan tanggal dan waktu saat ini
        function updateDateTime() {
            var now = new Date();

            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var date = now.toLocaleDateString('id-ID', options);

            var time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });

            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }

        // Panggil fungsi pertama kali
        updateDateTime();

        // Update setiap detik
        setInterval(updateDateTime, 1000);
    </script>
@endsection
