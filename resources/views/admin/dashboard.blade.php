@extends('layouts.app')

@section('title', 'Admin Dashboard - E-Klinik')

@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Dokter</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pasien</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">215</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-procedures fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Appointment Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendapatan Bulan Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 25.000.000</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Appointment Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Pasien</th>
                                    <th>Dokter</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ahmad Gunawan</td>
                                    <td>dr. Budi Santoso</td>
                                    <td>2023-06-15 09:00</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>Siti Rahayu</td>
                                    <td>dr. Diana Putri</td>
                                    <td>2023-06-15 10:30</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td>Rudi Hermawan</td>
                                    <td>dr. Eko Prasetyo</td>
                                    <td>2023-06-15 13:15</td>
                                    <td><span class="badge bg-primary">Dijadwalkan</span></td>
                                </tr>
                                <tr>
                                    <td>Dewi Lestari</td>
                                    <td>dr. Farida Amir</td>
                                    <td>2023-06-15 15:45</td>
                                    <td><span class="badge bg-primary">Dijadwalkan</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Pasien baru terdaftar</h6>
                                <small>3 jam yang lalu</small>
                            </div>
                            <p class="mb-1">Dewi Lestari telah mendaftar sebagai pasien baru.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Pembayaran diterima</h6>
                                <small>5 jam yang lalu</small>
                            </div>
                            <p class="mb-1">Pembayaran dari Ahmad Gunawan sebesar Rp 500.000 telah diterima.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Jadwal dokter diperbarui</h6>
                                <small>1 hari yang lalu</small>
                            </div>
                            <p class="mb-1">dr. Budi Santoso telah memperbarui jadwal praktiknya.</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Stok obat menipis</h6>
                                <small>2 hari yang lalu</small>
                            </div>
                            <p class="mb-1">Beberapa item obat telah mencapai batas minimum stok.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
