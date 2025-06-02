@extends('layouts.app')

@section('title', 'Jadwal Kunjungan Saya')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Jadwal Kunjungan Saya</h1>
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



        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Kunjungan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Alasan Kunjungan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appointment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $appointment->patient->user->name }}</td>
                                    <td>{{ $appointment->appointment_date->format('d/m/Y') }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
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
                                    <td>{{ \Illuminate\Support\Str::limit($appointment->reason, 30) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dokter.appointments.show', $appointment->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#updateStatusModal{{ $appointment->id }}">
                                                <i class="fas fa-edit"></i> Update
                                            </button>
                                            <a href="{{ route('dokter.appointments.examine', $appointment->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-stethoscope"></i> Pemeriksaan
                                            </a>
                                        </div>
                                        <!-- Modal Update Status -->
                                        <div class="modal fade" id="updateStatusModal{{ $appointment->id }}" tabindex="-1"
                                            aria-labelledby="updateStatusModalLabel{{ $appointment->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="updateStatusModalLabel{{ $appointment->id }}">Update Status
                                                            Kunjungan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('dokter.appointments.update', $appointment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status{{ $appointment->id }}"
                                                                    class="form-label">Status</label>
                                                                <select class="form-select"
                                                                    id="status{{ $appointment->id }}" name="status"
                                                                    required>
                                                                    <option value="Dijadwalkan"
                                                                        {{ $appointment->status == 'Dijadwalkan' ? 'selected' : '' }}>
                                                                        Dijadwalkan</option>
                                                                    <option value="Menunggu"
                                                                        {{ $appointment->status == 'Menunggu' ? 'selected' : '' }}>
                                                                        Menunggu</option>
                                                                    <option value="Selesai"
                                                                        {{ $appointment->status == 'Selesai' ? 'selected' : '' }}>
                                                                        Selesai</option>
                                                                    <option value="Dibatalkan"
                                                                        {{ $appointment->status == 'Dibatalkan' ? 'selected' : '' }}>
                                                                        Dibatalkan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="notes{{ $appointment->id }}"
                                                                    class="form-label">Catatan</label>
                                                                <textarea class="form-control" id="notes{{ $appointment->id }}" name="notes" rows="3">{{ $appointment->notes }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada jadwal kunjungan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });
        });

        // Pastikan modal berfungsi dengan baik
        document.addEventListener('DOMContentLoaded', function() {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.addEventListener('shown.bs.modal', function() {
                    // Fokus ke elemen pertama dalam modal
                    var firstInput = this.querySelector('input, select, textarea');
                    if (firstInput) {
                        firstInput.focus();
                    }
                });
            });
        });
    </script>
@endpush
