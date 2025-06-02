@extends('layouts.app')

@section('title', 'Pasien Dashboard - E-Klinik')

@section('page-title', 'Pasien Dashboard')

@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jadwal Berikutnya</div>
                            @if ($nextAppointment)
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $nextAppointment->appointment_date->format('d M Y') }}
                                </div>
                                <div class="text-xs">
                                    {{ $nextAppointment->doctor->user->name }}
                                    ({{ $nextAppointment->doctor->specialization }})
                                </div>
                            @else
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Tidak ada jadwal</div>
                            @endif
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Kunjungan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalVisits }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hospital fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Resep Aktif
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activePrescriptions }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-prescription fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Kunjungan</h6>
                </div>
                <div class="card-body">
                    <div class="timeline-container">
                        @forelse($recentVisits as $visit)
                            <div class="timeline-item">
                                <div class="timeline-date">{{ $visit->record_date->format('d F Y') }}</div>
                                <div class="timeline-content">
                                    <h6>{{ $visit->complaint }}</h6>
                                    <p>{{ $visit->doctor->user->name }} ({{ $visit->doctor->specialization }})</p>
                                    <p><strong>Diagnosa:</strong> {{ $visit->diagnosis }}</p>
                                    <p><strong>Tindakan:</strong> {{ $visit->treatment }}</p>
                                    <a href="{{ route('pasien.medical-records.show', $visit->id) }}"
                                        class="btn btn-sm btn-primary">Lihat Detail</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <p class="text-muted">Belum ada riwayat kunjungan</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resep Aktif</h6>
                </div>
                <div class="card-body">
                    @forelse($activePrescriptionList as $prescription)
                        <div class="prescription-item mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Resep #{{ $prescription->id }}</h6>
                                <span class="badge bg-success">Aktif</span>
                            </div>
                            <p><strong>Dokter:</strong> {{ $prescription->medicalRecord->doctor->user->name }}</p>
                            <p><strong>Tanggal:</strong> {{ $prescription->issue_date->format('d M Y') }}</p>
                            <p><strong>Obat:</strong></p>
                            <ul>
                                @foreach ($prescription->prescriptionItems as $item)
                                    <li>{{ $item->medicine->name }} ({{ $item->dosage }}) - {{ $item->frequency }}</li>
                                @endforeach
                            </ul>
                            <p><small class="text-muted">Berlaku hingga:
                                    {{ $prescription->valid_until->format('d M Y') }}</small></p>
                            <a href="{{ route('pasien.prescriptions.show', $prescription->id) }}"
                                class="btn btn-sm btn-primary">Download Resep</a>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <p class="text-muted">Tidak ada resep aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buat Janji Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('pasien.appointments.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="doctor_id" class="form-label">Pilih Dokter</label>
                                <select class="form-select @error('doctor_id') is-invalid @enderror" id="doctor_id"
                                    name="doctor_id">
                                    <option selected disabled>-- Pilih Dokter --</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->user->name }}
                                            ({{ $doctor->specialization }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">Pilih Tanggal</label>
                                <input type="date" class="form-control @error('appointment_date') is-invalid @enderror"
                                    id="appointment_date" name="appointment_date" min="{{ date('Y-m-d') }}">
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">Pilih Waktu</label>
                                <select class="form-select @error('appointment_time') is-invalid @enderror"
                                    id="appointment_time" name="appointment_time">
                                    <option selected disabled>-- Pilih Waktu --</option>
                                    <option value="08:00">08:00</option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="11:00">11:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="15:00">15:00</option>
                                </select>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="reason" class="form-label">Alasan Kunjungan</label>
                                <input type="text" class="form-control @error('reason') is-invalid @enderror"
                                    id="reason" name="reason"
                                    placeholder="Contoh: Sakit kepala, konsultasi rutin, dll.">
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan Tambahan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Buat Janji</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .timeline-container {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #e3e6f0;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-date {
            font-weight: bold;
            margin-bottom: 10px;
            color: #4e73df;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #4e73df;
        }

        .timeline-container:before {
            content: '';
            position: absolute;
            left: -23px;
            top: 0;
            width: 2px;
            height: 100%;
            background-color: #e3e6f0;
        }

        .prescription-item {
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            padding: 15px;
        }
    </style>
@endsection
