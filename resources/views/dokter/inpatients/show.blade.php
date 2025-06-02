@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pasien Rawat Inap</h1>
            <a href="{{ route('dokter.inpatients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <!-- Patient Info Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Informasi Pasien</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">No. Rekam Medis</th>
                                <td>{{ $inpatient->patient->medical_record_number }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pasien</th>
                                <td>{{ $inpatient->patient->name }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $inpatient->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <td>{{ $inpatient->patient->birth_date->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Ruangan</th>
                                <td>{{ $inpatient->room->name }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>{{ $inpatient->admission_date->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($inpatient->status === 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif ($inpatient->status === 'discharged')
                                        <span class="badge bg-info">Pulang</span>
                                    @else
                                        <span class="badge bg-warning">Ditransfer</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($inpatient->status !== 'active')
                                <tr>
                                    <th>Tanggal Keluar</th>
                                    <td>{{ $inpatient->discharge_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{{ $inpatient->discharge_note }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Records Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Rekam Medis</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Diagnosa</th>
                                <th>Tindakan</th>
                                <th>Obat</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inpatient->medicalRecords as $record)
                                <tr>
                                    <td>{{ $record->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $record->diagnosis }}</td>
                                    <td>{{ $record->treatment }}</td>
                                    <td>{{ $record->medicines }}</td>
                                    <td>{{ $record->notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada rekam medis</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($inpatient->status === 'active')
            <!-- Update Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('dokter.inpatients.update', $inpatient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="discharged">Pulang</option>
                                        <option value="transferred">Ditransfer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discharge_note" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="discharge_note" name="discharge_note" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
