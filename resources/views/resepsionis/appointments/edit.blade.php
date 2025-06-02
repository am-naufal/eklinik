@extends('layouts.app')

@section('title', 'Edit Jadwal Kunjungan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Jadwal Kunjungan</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Jadwal Kunjungan</h6>
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

                <form action="{{ route('resepsionis.appointments.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="patient_id">Pasien</label>
                                <select class="form-control @error('patient_id') is-invalid @enderror" id="patient_id"
                                    name="patient_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->user->name }}
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
                                <label for="doctor_id">Dokter</label>
                                <select class="form-control @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                    name="doctor_id" required>
                                    <option value="">Pilih Dokter</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->user->name }}
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
                                <label for="appointment_date">Tanggal Kunjungan</label>
                                <input type="date" class="form-control @error('appointment_date') is-invalid @enderror"
                                    id="appointment_date" name="appointment_date"
                                    value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
                                    required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="appointment_time">Waktu Kunjungan</label>
                                <input type="time" class="form-control @error('appointment_time') is-invalid @enderror"
                                    id="appointment_time" name="appointment_time"
                                    value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                                </select>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="Dijadwalkan"
                                        {{ old('status', $appointment->status) == 'Dijadwalkan' ? 'selected' : '' }}>
                                        Dijadwalkan</option>
                                    <option value="Menunggu"
                                        {{ old('status', $appointment->status) == 'Menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="Selesai"
                                        {{ old('status', $appointment->status) == 'Selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="Dibatalkan"
                                        {{ old('status', $appointment->status) == 'Dibatalkan' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $appointment->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('resepsionis.appointments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function checkAvailability() {
                const doctorId = $('#doctor_id').val();
                const date = $('#appointment_date').val();
                const currentTime = '{{ $appointment->appointment_time }}';

                if (doctorId && date) {
                    $.get(`{{ route('resepsionis.appointments.check-availability') }}`, {
                        doctor_id: doctorId,
                        date: date
                    }, function(response) {
                        const timeSelect = $('#appointment_time');
                        timeSelect.empty();
                        timeSelect.append('<option value="">Pilih Waktu</option>');

                        response.available_times.forEach(function(time) {
                            const selected = time === currentTime ? 'selected' : '';
                            timeSelect.append(
                                `<option value="${time}" ${selected}>${time}</option>`);
                        });
                    });
                }
            }

            $('#doctor_id, #appointment_date').change(checkAvailability);
            checkAvailability(); // Check availability on page load
        });
    </script>
@endsection
