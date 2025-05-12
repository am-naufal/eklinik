@extends('layouts.app')

@section('title', 'Edit Dokter - E-Klinik')

@section('page-title', 'Edit Dokter')

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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Dokter</h6>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Akun</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $doctor->user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $doctor->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(Kosongkan jika
                                    tidak ingin mengubah)</small></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor Telepon <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                id="phone_number" name="phone_number"
                                value="{{ old('phone_number', $doctor->user->phone_number) }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                required>{{ old('address', $doctor->user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender"
                                required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="laki-laki"
                                    {{ old('gender', $doctor->user->gender) == 'laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="perempuan"
                                    {{ old('gender', $doctor->user->gender) == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Foto Profil</label>
                            @if ($doctor->user->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $doctor->user->photo) }}"
                                        alt="{{ $doctor->user->name }}" class="img-thumbnail" style="height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                id="photo" name="photo">
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Informasi Dokter</h5>

                        <div class="mb-3">
                            <label for="specialization" class="form-label">Spesialisasi <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('specialization') is-invalid @enderror"
                                id="specialization" name="specialization"
                                value="{{ old('specialization', $doctor->specialization) }}" required>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="license_number" class="form-label">Nomor SIP <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('license_number') is-invalid @enderror"
                                id="license_number" name="license_number"
                                value="{{ old('license_number', $doctor->license_number) }}" required>
                            @error('license_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">Pendidikan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('education') is-invalid @enderror" id="education" name="education"
                                rows="3" required>{{ old('education', $doctor->education) }}</textarea>
                            <small class="text-muted">Contoh: S1 Kedokteran Universitas Indonesia (2010), Spesialis Jantung
                                FKUI (2015)</small>
                            @error('education')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biografi</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $doctor->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience_years" class="form-label">Pengalaman (Tahun) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                                id="experience_years" name="experience_years"
                                value="{{ old('experience_years', $doctor->experience_years) }}" min="0" required>
                            @error('experience_years')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="consultation_fee" class="form-label">Biaya Konsultasi (Rp) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('consultation_fee') is-invalid @enderror"
                                id="consultation_fee" name="consultation_fee"
                                value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0" required>
                            @error('consultation_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $doctor->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection
