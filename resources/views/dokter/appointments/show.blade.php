@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Kunjungan</h1>
            <div>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#updateStatusModal">
                    <i class="fas fa-edit"></i> Update Status
                </button>
                <a href="{{ route('dokter.appointments.index') }}" class="btn btn-sm btn-secondary ml-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Detail Kunjungan -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Kunjungan</h6>
                        <span
                            class="badge badge-pill
                        @if ($appointment->status == 'Dijadwalkan') badge-primary
                        @elseif($appointment->status == 'Menunggu') badge-warning
                        @elseif($appointment->status == 'Selesai') badge-success
                        @elseif($appointment->status == 'Dibatalkan') badge-danger @endif px-3 py-2">
                            {{ $appointment->status }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle fa-2x mr-3"></i>
                                        <div>
                                            <h5 class="alert-heading">Aksi yang tersedia:</h5>
                                            <ul class="mb-0">
                                                <li>Ubah status kunjungan ke "Menunggu" saat pasien telah tiba</li>
                                                <li>Ubah status kunjungan ke "Selesai" setelah pemeriksaan selesai</li>
                                                <li>Tambahkan catatan untuk informasi tambahan tentang kunjungan</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold text-dark">Informasi Pasien</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="30%" class="bg-light">Nama Pasien</td>
                                            <td width="70%">{{ $appointment->patient->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">No. Rekam Medis</td>
                                            <td>{{ $appointment->patient->no_rekam_medis }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Email</td>
                                            <td>{{ $appointment->patient->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">No. Telepon</td>
                                            <td>{{ $appointment->patient->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Jenis Kelamin</td>
                                            <td>{{ $appointment->patient->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Tanggal Lahir</td>
                                            <td>{{ $appointment->patient->birth_date ? $appointment->patient->birth_date->format('d F Y') : '-' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="font-weight-bold text-dark mb-3">Detail Kunjungan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="30%" class="bg-light">Tanggal Kunjungan</td>
                                            <td width="70%">{{ $appointment->appointment_date->format('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Waktu Kunjungan</td>
                                            <td>{{ $appointment->appointment_time }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Status</td>
                                            <td>
                                                <span
                                                    class="badge badge-pill
                                                @if ($appointment->status == 'Dijadwalkan') badge-primary
                                                @elseif($appointment->status == 'Menunggu') badge-warning
                                                @elseif($appointment->status == 'Selesai') badge-success
                                                @elseif($appointment->status == 'Dibatalkan') badge-danger @endif px-3 py-2">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Alasan Kunjungan</td>
                                            <td>{{ $appointment->reason }}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light">Catatan</td>
                                            <td>{{ $appointment->notes ?? 'Tidak ada catatan' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        @if ($appointment->status == 'Selesai')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="alert alert-success">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="font-weight-bold">Kunjungan Selesai</h5>
                                                <p class="mb-0">Kunjungan ini telah selesai. Apakah Anda ingin membuat
                                                    rekam medis untuk pasien ini?</p>
                                            </div>
                                            <a href="{{ route('dokter.medical-records.create', ['patient_id' => $appointment->patient_id]) }}"
                                                class="btn btn-success">
                                                <i class="fas fa-file-medical"></i> Buat Rekam Medis
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Status Kunjungan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dokter.appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Dijadwalkan" {{ $appointment->status == 'Dijadwalkan' ? 'selected' : '' }}>
                                    Dijadwalkan</option>
                                <option value="Menunggu" {{ $appointment->status == 'Menunggu' ? 'selected' : '' }}>
                                    Menunggu</option>
                                <option value="Selesai" {{ $appointment->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="Dibatalkan" {{ $appointment->status == 'Dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $appointment->notes }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
