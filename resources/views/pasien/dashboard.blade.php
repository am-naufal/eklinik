@extends('layouts.app')

@section('title', 'Pasien Dashboard - E-Klinik')

@section('page-title', 'Pasien Dashboard')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('pasien.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-alt me-2"></i>
            Jadwal Kunjungan
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user-md me-2"></i>
            Dokter
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-clipboard-list me-2"></i>
            Rekam Medis Saya
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-credit-card me-2"></i>
            Pembayaran
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
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jadwal Berikutnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">25 Jun 2023</div>
                            <div class="text-xs">dr. Budi Santoso (Dokter Umum)</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">6</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hospital fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Resep Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription fa-2x text-gray-300"></i>
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
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Kunjungan</h6>
                </div>
                <div class="card-body">
                    <div class="timeline-container">
                        <div class="timeline-item">
                            <div class="timeline-date">15 Juni 2023</div>
                            <div class="timeline-content">
                                <h6>Pemeriksaan Rutin</h6>
                                <p>dr. Budi Santoso (Dokter Umum)</p>
                                <p><strong>Diagnosa:</strong> Batuk, Pilek</p>
                                <p><strong>Tindakan:</strong> Pemberian resep obat batuk dan multivitamin</p>
                                <a href="#" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">28 April 2023</div>
                            <div class="timeline-content">
                                <h6>Konsultasi Gizi</h6>
                                <p>dr. Diana Putri (Spesialis Gizi)</p>
                                <p><strong>Diagnosa:</strong> Kekurangan nutrisi</p>
                                <p><strong>Tindakan:</strong> Pemberian panduan diet dan suplemen</p>
                                <a href="#" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-date">12 Maret 2023</div>
                            <div class="timeline-content">
                                <h6>Cek Tekanan Darah</h6>
                                <p>dr. Eko Prasetyo (Spesialis Jantung)</p>
                                <p><strong>Diagnosa:</strong> Tekanan darah normal</p>
                                <p><strong>Tindakan:</strong> Rekomendasi pola hidup sehat</p>
                                <a href="#" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resep Aktif</h6>
                </div>
                <div class="card-body">
                    <div class="prescription-item mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Resep #12345</h6>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <p><strong>Dokter:</strong> dr. Budi Santoso</p>
                        <p><strong>Tanggal:</strong> 15 Juni 2023</p>
                        <p><strong>Obat:</strong></p>
                        <ul>
                            <li>Paracetamol 500mg (3x1)</li>
                            <li>Amoxicillin 500mg (3x1)</li>
                            <li>Vitamin C 500mg (1x1)</li>
                        </ul>
                        <p><small class="text-muted">Berlaku hingga: 22 Juni 2023</small></p>
                        <a href="#" class="btn btn-sm btn-primary">Download Resep</a>
                    </div>

                    <div class="prescription-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Resep #12300</h6>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <p><strong>Dokter:</strong> dr. Diana Putri</p>
                        <p><strong>Tanggal:</strong> 28 April 2023</p>
                        <p><strong>Obat:</strong></p>
                        <ul>
                            <li>Multivitamin (1x1)</li>
                            <li>Suplemen Kalsium (1x1)</li>
                        </ul>
                        <p><small class="text-muted">Berlaku hingga: 28 Juli 2023</small></p>
                        <a href="#" class="btn btn-sm btn-primary">Download Resep</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buat Janji Baru</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="doctor" class="form-label">Pilih Dokter</label>
                                <select class="form-select" id="doctor">
                                    <option selected disabled>-- Pilih Dokter --</option>
                                    <option>dr. Budi Santoso (Dokter Umum)</option>
                                    <option>dr. Diana Putri (Spesialis Gizi)</option>
                                    <option>dr. Eko Prasetyo (Spesialis Jantung)</option>
                                    <option>dr. Farida Amir (Spesialis Penyakit Dalam)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Pilih Tanggal</label>
                                <input type="date" class="form-control" id="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Pilih Waktu</label>
                                <select class="form-select" id="time">
                                    <option selected disabled>-- Pilih Waktu --</option>
                                    <option>08:00</option>
                                    <option>09:00</option>
                                    <option>10:00</option>
                                    <option>11:00</option>
                                    <option>13:00</option>
                                    <option>14:00</option>
                                    <option>15:00</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="reason" class="form-label">Alasan Kunjungan</label>
                                <input type="text" class="form-control" id="reason"
                                    placeholder="Contoh: Sakit kepala, konsultasi rutin, dll.">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control" id="notes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Buat Janji</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .timeline-container {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e3e6f0;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-date {
            font-weight: bold;
            margin-bottom: 10px;
            color: #4e73df;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #4e73df;
        }

        .timeline-container:before {
            content: '';
            position: absolute;
            left: -23px;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: #e3e6f0;
        }

        .prescription-item {
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 15px;
        }
    </style>
@endsection
