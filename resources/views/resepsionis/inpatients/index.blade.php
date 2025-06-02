@extends('layouts.app')
@section('title', 'Data Rawat Inap')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Data Rawat Inap</h1>
            <a href="{{ route('resepsionis.inpatients.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Rawat Inap
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="min-height: 300px;">
                    <table class="table table-bordered table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Kamar</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inpatients as $inpatient)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $inpatient->patient->user->name }}</td>
                                    <td>{{ $inpatient->doctor->user->name }}</td>
                                    <td>{{ $inpatient->room->name }}</td>
                                    <td>{{ $inpatient->check_in_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($inpatient->status === 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($inpatient->status === 'pulang')
                                            <span class="badge bg-info">Pulang</span>
                                        @else
                                            <span class="badge bg-warning">Dipindahkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('resepsionis.inpatients.show', $inpatient) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('resepsionis.inpatients.edit', $inpatient) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
