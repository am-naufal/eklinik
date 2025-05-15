@extends('layouts.app')

@section('title', 'Pemeriksaan Pasien')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pemeriksaan Pasien</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Data Pasien</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Nama Pasien</th>
                                        <td width="5%">:</td>
                                        <td>{{ $appointment->patient->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Rekam Medis</th>
                                        <td>:</td>
                                        <td>{{ $appointment->patient->medical_record_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>:</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->patient->birth_date)->format('d-m-Y') }}
                                            ({{ \Carbon\Carbon::parse($appointment->patient->birth_date)->age }} Tahun)</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>:</td>
                                        <td>{{ $appointment->patient->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Alamat</th>
                                        <td width="5%">:</td>
                                        <td>{{ $appointment->patient->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Telepon</th>
                                        <td>:</td>
                                        <td>{{ $appointment->patient->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Keluhan</th>
                                        <td>:</td>
                                        <td>{{ $appointment->reason }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>:</td>
                                        <td>{{ $appointment->notes ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Rekam Medis -->
                @if ($previousRecords->count() > 0)
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Riwayat Rekam Medis Pasien</h6>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="medicalRecordHistory">
                                @foreach ($previousRecords as $index => $record)
                                    <div class="card">
                                        <div class="card-header" id="headingRecord{{ $index }}">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapseRecord{{ $index }}"
                                                    aria-expanded="false"
                                                    aria-controls="collapseRecord{{ $index }}">
                                                    <strong>{{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y') }}</strong>
                                                    -
                                                    {{ $record->diagnosis ?? 'Belum ada diagnosis' }}
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="collapseRecord{{ $index }}" class="collapse"
                                            aria-labelledby="headingRecord{{ $index }}"
                                            data-parent="#medicalRecordHistory">
                                            <div class="card-body">
                                                <dl class="row">
                                                    <dt class="col-sm-3">Tanggal Periksa</dt>
                                                    <dd class="col-sm-9">
                                                        {{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y H:i') }}
                                                    </dd>

                                                    <dt class="col-sm-3">Dokter</dt>
                                                    <dd class="col-sm-9">{{ $record->doctor->user->name }}</dd>

                                                    <dt class="col-sm-3">Anamnesa</dt>
                                                    <dd class="col-sm-9">{{ $record->anamnesis ?? '-' }}</dd>

                                                    <dt class="col-sm-3">Pemeriksaan Fisik</dt>
                                                    <dd class="col-sm-9">{{ $record->physical_examination ?? '-' }}</dd>

                                                    <dt class="col-sm-3">Diagnosis</dt>
                                                    <dd class="col-sm-9">{{ $record->diagnosis ?? '-' }}</dd>

                                                    <dt class="col-sm-3">Pengobatan</dt>
                                                    <dd class="col-sm-9">{{ $record->treatment ?? '-' }}</dd>

                                                    <dt class="col-sm-3">Catatan</dt>
                                                    <dd class="col-sm-9">{{ $record->notes ?? '-' }}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Pemeriksaan Pasien -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Form Pemeriksaan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dokter.medical-records.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                            <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                            <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                            <input type="hidden" name="record_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">

                            <div class="form-group row">
                                <label for="complaint" class="col-sm-2 col-form-label">Keluhan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="complaint" name="complaint" rows="3" required>{{ $appointment->reason }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="anamnesis" class="col-sm-2 col-form-label">Anamnesa</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="anamnesis" name="anamnesis" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="physical_examination" class="col-sm-2 col-form-label">Pemeriksaan Fisik</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="physical_examination" name="physical_examination" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="diagnosis" class="col-sm-2 col-form-label">Diagnosis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="diagnosis" name="diagnosis" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="treatment" class="col-sm-2 col-form-label">Tindakan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="treatment" name="treatment" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="notes" class="col-sm-2 col-form-label">Catatan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                                </div>
                            </div>

                            <!-- Resep Obat -->
                            <h5 class="mt-4 mb-3">Resep Obat</h5>
                            <div id="medicine-list">
                                <div class="form-group row medicine-row">
                                    <div class="col-sm-5">
                                        <select class="form-control medicine-select" name="medicines[]">
                                            <option value="">Pilih Obat</option>
                                            @foreach ($medicines as $medicine)
                                                <option value="{{ $medicine->id }}" data-price="{{ $medicine->price }}"
                                                    data-stock="{{ $medicine->stock }}">
                                                    {{ $medicine->name }} (Stok: {{ $medicine->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control medicine-qty" name="quantities[]"
                                            min="1" max="100" placeholder="Jumlah" value="1">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control medicine-instruction"
                                            name="instructions[]" placeholder="Aturan Pakai">
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-danger remove-medicine">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-2">
                                <button type="button" id="add-medicine" class="btn btn-info btn-sm">
                                    <i class="fas fa-plus"></i> Tambah Obat
                                </button>
                            </div>

                            <div class="form-group text-right mt-4">
                                <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Rekam Medis</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Tambah baris obat
            $('#add-medicine').click(function() {
                var newRow = $('.medicine-row:first').clone();
                newRow.find('select, input').val('');
                $('#medicine-list').append(newRow);
            });

            // Hapus baris obat
            $(document).on('click', '.remove-medicine', function() {
                if ($('.medicine-row').length > 1) {
                    $(this).closest('.medicine-row').remove();
                } else {
                    alert('Minimal satu obat harus ada di resep');
                }
            });
        });
    </script>
@endsection
