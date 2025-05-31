@extends('layouts.app')

@section('title', 'Edit Rawat Inap')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Rawat Inap</h1>
            <a href="{{ route('admin.inpatients.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('admin.inpatients.update', $inpatient->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Pasien <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('patient_id') is-invalid @enderror"
                                    id="patient_id" name="patient_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id', $inpatient->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->user->name }} - {{ $patient->medical_record_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor_id">Dokter <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                    name="doctor_id" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            {{ old('doctor_id', $inpatient->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->name }} - {{ $doctor->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="room_id">Ruangan <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('room_id') is-invalid @enderror" id="room_id"
                                    name="room_id" required>
                                    <option value="">Pilih Ruangan</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id', $inpatient->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_number }} - {{ $room->room_type }} (Rp
                                            {{ number_format($room->price_per_day, 0, ',', '.') }}/hari)
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="active"
                                        {{ old('status', $inpatient->status) == 'active' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="pulang"
                                        {{ old('status', $inpatient->status) == 'pulang' ? 'selected' : '' }}>
                                        Pulang
                                    </option>
                                    <option value="dipindahkan"
                                        {{ old('status', $inpatient->status) == 'dipindahkan' ? 'selected' : '' }}>
                                        Dipindahkan
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="check_in_date">Tanggal Masuk <span class="text-danger">*</span></label>
                                <input type="datetime-local"
                                    class="form-control @error('check_in_date') is-invalid @enderror" id="check_in_date"
                                    name="check_in_date"
                                    value="{{ old('check_in_date', \Carbon\Carbon::parse($inpatient->check_in_date)->format('Y-m-d\TH:i')) }}"
                                    required>
                                @error('check_in_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="check_out_date">Tanggal Keluar</label>
                                <input type="datetime-local"
                                    class="form-control @error('check_out_date') is-invalid @enderror" id="check_out_date"
                                    name="check_out_date"
                                    value="{{ old('check_out_date', $inpatient->check_out_date ? \Carbon\Carbon::parse($inpatient->check_out_date)->format('Y-m-d\TH:i') : '') }}">
                                @error('check_out_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="diagnosis">Diagnosis <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" id="diagnosis" name="diagnosis" rows="3"
                            required>{{ old('diagnosis', $inpatient->diagnosis) }}</textarea>
                        @error('diagnosis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="treatment_plan">Rencana Perawatan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('treatment_plan') is-invalid @enderror" id="treatment_plan" name="treatment_plan"
                            rows="3" required>{{ old('treatment_plan', $inpatient->treatment_plan) }}</textarea>
                        @error('treatment_plan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $inpatient->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Menampilkan/menyembunyikan field tanggal keluar berdasarkan status
            $('#status').change(function() {
                if ($(this).val() === 'discharged') {
                    $('#check_out_date').prop('required', true);
                } else {
                    $('#check_out_date').prop('required', false);
                }
            });
        });
    </script>
@endpush
