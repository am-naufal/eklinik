@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pasien</h1>
            <div>
                <a href="{{ route('resepsionis.patients.edit', $patient->id) }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit Data
                </a>
                <a href="{{ route('resepsionis.patients.index') }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Informasi Pasien -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Pasien</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%">Nama Lengkap</th>
                                <td>{{ $patient->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $patient->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $patient->phone_number ?? $patient->user->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $patient->address ?? $patient->user->address }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ ucfirst($patient->gender ?? $patient->user->gender) }}</td>
                            </tr>
                            <tr>
                                <th>Umur</th>
                                <td>{{ $patient->user->age }} tahun</td>
                            </tr>
                            <tr>
                                <th>Golongan Darah</th>
                                <td>{{ $patient->blood_type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Alergi</th>
                                <td>{{ $patient->allergies ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Riwayat Kesehatan</th>
                                <td>{{ $patient->medical_history ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Informasi Asuransi & Kontak Darurat -->
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Tambahan</h6>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold text-primary">Asuransi Kesehatan</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%">Nomor Asuransi</th>
                                <td>{{ $patient->insurance_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Penyedia Asuransi</th>
                                <td>{{ $patient->insurance_provider ?? '-' }}</td>
                            </tr>
                        </table>

                        <hr>

                        <h5 class="font-weight-bold text-primary">Kontak Darurat</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%">Nama Kontak</th>
                                <td>{{ $patient->emergency_contact ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $patient->emergency_phone ?? '-' }}</td>
                            </tr>
                        </table>

                        <hr>

                        <h5 class="font-weight-bold text-primary">Data Pasien</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%">Nomor Rekam Medis</th>
                                <td>{{ $patient->medical_record_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Registrasi</th>
                                <td>{{ $patient->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($patient->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Kunjungan -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Kunjungan</h6>
                <a href="{{ route('resepsionis.appointments.create', ['patient_id' => $patient->id]) }}"
                    class="btn btn-sm btn-primary">
                    <i class="fas fa-plus fa-sm"></i> Buat Jadwal Baru
                </a>
            </div>
            <div class="card-body">
                @if (count($patient->appointments) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Dokter</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
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
                                                <span class="badge badge-secondary">{{ $appointment->status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $appointment->notes ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('resepsionis.appointments.show', $appointment->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center py-3">Pasien belum memiliki riwayat kunjungan</p>
                @endif
            </div>
        </div>

        <!-- Riwayat Penanganan -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Nota Penanganan</h6>
                @if (isset($patient->medicalRecords) && count($patient->medicalRecords) > 0)
                    <a href="{{ route('resepsionis.invoices.create', ['patient_id' => $patient->id]) }}"
                        class="btn btn-sm btn-primary">
                        <i class="fas fa-plus fa-sm"></i> Buat Nota Baru
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if (isset($invoices) && count($invoices) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No. Nota</th>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                        <td>{{ $invoice->doctor->user->name }}</td>
                                        <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($invoice->payment_status == 'pending')
                                                <span class="badge badge-warning">Menunggu</span>
                                            @elseif($invoice->payment_status == 'paid')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($invoice->payment_status == 'cancelled')
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $invoice->payment_status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('resepsionis.invoices.show', $invoice->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('resepsionis.invoices.print', $invoice->id) }}"
                                                class="btn btn-primary btn-sm" target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center py-3">Pasien belum memiliki riwayat nota penanganan</p>
                @endif
            </div>
        </div>
    </div>
@endsection
