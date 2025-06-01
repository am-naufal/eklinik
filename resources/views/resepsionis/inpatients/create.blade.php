@extends('layouts.app')
@section('title', 'Tambah Rawat Inap')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Tambah Rawat Inap</h1>
            <a href="{{ route('resepsionis.inpatients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('resepsionis.inpatients.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">Pasien</label>
                                <select name="patient_id" id="patient_id"
                                    class="form-select @error('patient_id') is-invalid @enderror" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="doctor_id" class="form-label">Dokter</label>
                                <select name="doctor_id" id="doctor_id"
                                    class="form-select @error('doctor_id') is-invalid @enderror" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="room_id" class="form-label">Kamar</label>
                                <select name="room_id" id="room_id"
                                    class="form-select @error('room_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kamar</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="check_in_date" class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control @error('check_in_date') is-invalid @enderror"
                                    id="check_in_date" name="check_in_date" value="{{ old('check_in_date') }}" required>
                                @error('check_in_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="3"
                                    required>{{ old('diagnosis') }}</textarea>
                                @error('diagnosis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="treatment_plan" class="form-label">Rencana Perawatan</label>
                                <textarea class="form-control @error('treatment_plan') is-invalid @enderror" id="treatment_plan" name="treatment_plan"
                                    rows="3" required>{{ old('treatment_plan') }}</textarea>
                                @error('treatment_plan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
