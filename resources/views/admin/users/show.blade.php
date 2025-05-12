@extends('layouts.app')

@section('title', 'Detail User - E-Klinik')

@section('page-title', 'Detail User')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users me-2"></i>
            Manajemen User
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
            <i class="fas fa-fw fa-procedures me-2"></i>
            Pasien
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-check me-2"></i>
            Jadwal
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cog me-2"></i>
            Pengaturan
        </a>
    </li>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail User: {{ $user->name }}</h6>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning me-1">
                    <i class="fas fa-edit fa-sm"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left fa-sm"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    @if ($user->photo)
                        <img src="{{ asset('storage/user_photos/' . $user->photo) }}" alt="{{ $user->name }}"
                            class="img-fluid rounded shadow" style="max-height: 300px;">
                    @else
                        <div class="border rounded p-3 mb-3 bg-light">
                            <i class="fas fa-user-circle fa-7x text-gray-400"></i>
                            <p class="mt-2 text-muted">Belum ada foto</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%">Nama Lengkap</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <span
                                        class="badge {{ $user->role->name === 'admin' ? 'bg-danger' : ($user->role->name === 'dokter' ? 'bg-primary' : 'bg-success') }}">
                                        {{ ucfirst($user->role->name) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Nomor Telepon</th>
                                <td>{{ $user->phone_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Umur</th>
                                <td>{{ $user->age ? $user->age . ' tahun' : '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    @if ($user->gender === 'laki-laki')
                                        Laki-laki
                                    @elseif ($user->gender === 'perempuan')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $user->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Update Terakhir</th>
                                <td>{{ $user->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
