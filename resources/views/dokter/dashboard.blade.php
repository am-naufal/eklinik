@extends('layouts.app')

@section('title', 'Dokter Dashboard - E-Klinik')

@section('page-title', 'Dokter Dashboard')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('dokter.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-alt me-2"></i>
            Jadwal Praktik
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-procedures me-2"></i>
            Pasien Saya
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-clipboard-list me-2"></i>
            Rekam Medis
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-pills me-2"></i>
            Resep Obat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user me-2"></i>
            Profil Saya
        </a>
    </li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pasien Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">64</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-injured fa-2x text-gray-300"></i>
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
                                Jadwal Minggu Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">24</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
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
                                Pasien Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Hari Ini</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>Nama Pasien</th>
                                    <th>Keluhan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:00</td>
                                    <td>Siti Rahayu</td>
                                    <td>Demam, Batuk</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                                </tr>
                                <tr>
                                    <td>09:30</td>
                                    <td>Budi Hartono</td>
                                    <td>Sakit Kepala</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary">Detail</a></td>
                                </tr>
                                <tr>
                                    <td>11:00</td>
                                    <td>Dewi Lestari</td>
                                    <td>Konsultasi Gizi</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary">Panggil</a></td>
                                </tr>
                                <tr>
                                    <td>13:30</td>
                                    <td>Rudi Hermawan</td>
                                    <td>Cek Tekanan Darah</td>
                                    <td><span class="badge bg-primary">Terjadwal</span></td>
                                    <td><a href="#" class="btn btn-sm btn-secondary">Belum Waktunya</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pasien Terakhir Diperiksa</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Budi Hartono (35 tahun)</h6>
                                <small>1 jam yang lalu</small>
                            </div>
                            <p class="mb-1"><strong>Diagnosa:</strong> Migrain, Kelelahan</p>
                            <small><strong>Tindakan:</strong> Pemberian resep obat pereda nyeri dan multivitamin</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Siti Rahayu (42 tahun)</h6>
                                <small>2 jam yang lalu</small>
                            </div>
                            <p class="mb-1"><strong>Diagnosa:</strong> ISPA ringan</p>
                            <small><strong>Tindakan:</strong> Pemberian antibiotik dan obat batuk</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Ahmad Gunawan (28 tahun)</h6>
                                <small>Kemarin, 16:45</small>
                            </div>
                            <p class="mb-1"><strong>Diagnosa:</strong> Dermatitis kontak</p>
                            <small><strong>Tindakan:</strong> Pemberian salep kortikosteroid dan antihistamin</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Rina Wijaya (50 tahun)</h6>
                                <small>Kemarin, 14:30</small>
                            </div>
                            <p class="mb-1"><strong>Diagnosa:</strong> Hipertensi</p>
                            <small><strong>Tindakan:</strong> Penyesuaian dosis obat antihipertensi dan edukasi gaya
                                hidup</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
