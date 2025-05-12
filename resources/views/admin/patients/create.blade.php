@extends('layouts.app')

@section('title', 'Tambah Pasien Baru - E-Klinik')

@section('page-title', 'Tambah Pasien Baru')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Pasien Baru</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.patients.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="h5 mb-3">Informasi Akun</h4>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="h5 mb-3">Informasi Pasien</h4>

                        <div class="mb-3">
                            <label for="medical_record_number" class="form-label">Nomor Rekam Medis <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="medical_record_number"
                                name="medical_record_number" value="{{ old('medical_record_number') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                value="{{ old('date_of_birth') }}">
                            <small class="form-text text-muted">Digunakan untuk menghitung umur pasien secara
                                otomatis</small>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="h5 mb-3">Informasi Kontak</h4>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="{{ old('phone_number') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="h5 mb-3">Informasi Darurat</h4>

                        <div class="mb-3">
                            <label for="emergency_contact" class="form-label">Kontak Darurat</label>
                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"
                                value="{{ old('emergency_contact') }}">
                        </div>

                        <div class="mb-3">
                            <label for="emergency_phone" class="form-label">Telepon Darurat</label>
                            <input type="text" class="form-control" id="emergency_phone" name="emergency_phone"
                                value="{{ old('emergency_phone') }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="h5 mb-3">Informasi Kesehatan</h4>

                        <div class="mb-3">
                            <label for="blood_type" class="form-label">Golongan Darah</label>
                            <select class="form-select" id="blood_type" name="blood_type">
                                <option value="">-- Pilih Golongan Darah --</option>
                                <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4 class="h5 mb-3">Informasi Asuransi</h4>

                        <div class="mb-3">
                            <label for="insurance_number" class="form-label">Nomor Asuransi</label>
                            <input type="text" class="form-control" id="insurance_number" name="insurance_number"
                                value="{{ old('insurance_number') }}">
                        </div>

                        <div class="mb-3">
                            <label for="insurance_provider" class="form-label">Penyedia Asuransi</label>
                            <input type="text" class="form-control" id="insurance_provider" name="insurance_provider"
                                value="{{ old('insurance_provider') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
