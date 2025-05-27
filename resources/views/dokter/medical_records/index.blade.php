@extends('layouts.app')

@section('title', 'Daftar Rekam Medis - E-Klinik')

@section('page-title', 'Daftar Rekam Medis')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Rekam Medis</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Content Row -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Rekam Medis</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pasien</th>
                                <th>No. Rekam Medis</th>
                                <th>Diagnosis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicalRecords as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->record_date)->format('d-m-Y') }}</td>
                                    <td>{{ $record->patient->user->name }}</td>
                                    <td>{{ $record->patient->medical_record_number ?? '-' }}</td>
                                    <td>{{ $record->diagnosis }}</td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('dokter.medical-records.show', $record->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('dokter.medical-records.edit', $record->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data rekam medis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $medicalRecords->links() }}
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
                "searching": true
            });
        });
    </script>
@endsection
