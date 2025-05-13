@extends('layouts.app')

@section('title', 'Buat Jadwal Kunjungan - E-Klinik')

@section('page-title', 'Buat Jadwal Kunjungan Baru')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Jadwal Kunjungan</h6>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('pasien.appointments.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="doctor_id" class="form-label">Pilih Dokter</label>
                        <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id" name="doctor_id"
                            required>
                            <option value="" selected disabled>-- Pilih Dokter --</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="appointment_date" class="form-label">Tanggal Kunjungan</label>
                        <input type="date" class="form-control @error('appointment_date') is-invalid @enderror"
                            id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}"
                            min="{{ date('Y-m-d') }}" required>
                        @error('appointment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="appointment_time" class="form-label">Waktu Kunjungan</label>
                        <select class="form-select @error('appointment_time') is-invalid @enderror" id="appointment_time"
                            name="appointment_time" required>
                            <option value="" selected disabled>-- Pilih Waktu --</option>
                            <option value="08:00" {{ old('appointment_time') == '08:00' ? 'selected' : '' }}>08:00
                            </option>
                            <option value="09:00" {{ old('appointment_time') == '09:00' ? 'selected' : '' }}>09:00
                            </option>
                            <option value="10:00" {{ old('appointment_time') == '10:00' ? 'selected' : '' }}>10:00
                            </option>
                            <option value="11:00" {{ old('appointment_time') == '11:00' ? 'selected' : '' }}>11:00
                            </option>
                            <option value="13:00" {{ old('appointment_time') == '13:00' ? 'selected' : '' }}>13:00
                            </option>
                            <option value="14:00" {{ old('appointment_time') == '14:00' ? 'selected' : '' }}>14:00
                            </option>
                            <option value="15:00" {{ old('appointment_time') == '15:00' ? 'selected' : '' }}>15:00
                            </option>
                            <option value="16:00" {{ old('appointment_time') == '16:00' ? 'selected' : '' }}>16:00
                            </option>
                        </select>
                        @error('appointment_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="reason" class="form-label">Alasan Kunjungan</label>
                        <input type="text" class="form-control @error('reason') is-invalid @enderror" id="reason"
                            name="reason" placeholder="Contoh: Sakit kepala, konsultasi rutin, dll."
                            value="{{ old('reason') }}" required>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Catatan Tambahan (opsional)</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pasien.appointments.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
