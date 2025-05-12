@extends('layouts.app')

@section('title', 'Detail Dokter - E-Klinik')

@section('page-title', 'Detail Dokter')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt me-2"></i>
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users me-2"></i>
            Manajemen User
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('admin.doctors.index') }}">
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
            <h6 class="m-0 font-weight-bold text-primary">Informasi Dokter</h6>
            <div>
                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    @if ($doctor->user->photo)
                        <img src="{{ asset('storage/' . $doctor->user->photo) }}" alt="{{ $doctor->user->name }}"
                            class="img-profile rounded-circle img-thumbnail"
                            style="width: 200px; height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('img/undraw_profile.svg') }}" alt="{{ $doctor->user->name }}"
                            class="img-profile rounded-circle img-thumbnail"
                            style="width: 200px; height: 200px; object-fit: cover;">
                    @endif
                    <h4 class="mt-3">{{ $doctor->user->name }}</h4>
                    <p class="text-muted">{{ $doctor->specialization }}</p>
                    <p>
                        @if ($doctor->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2">Informasi Pribadi</h5>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Email:</strong></p>
                                <p>{{ $doctor->user->email }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Telepon:</strong></p>
                                <p>{{ $doctor->user->phone_number ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Jenis Kelamin:</strong></p>
                                <p>
                                    @if ($doctor->user->gender == 'laki-laki')
                                        Laki-laki
                                    @elseif($doctor->user->gender == 'perempuan')
                                        Perempuan
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Alamat:</strong></p>
                                <p>{{ $doctor->user->address ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="border-bottom pb-2">Informasi Profesional</h5>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Nomor SIP:</strong></p>
                                <p>{{ $doctor->license_number }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Pendidikan:</strong></p>
                                <p>{{ $doctor->education }}</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Pengalaman:</strong></p>
                                <p>{{ $doctor->experience_years }} tahun</p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Biaya Konsultasi:</strong></p>
                                <p>Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h5 class="border-bottom pb-2">Biografi</h5>
                        <p>{{ $doctor->bio ?? 'Tidak ada biografi' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
