@extends('layouts.app')

@section('title', 'Edit Rekam Medis')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Rekam Medis</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Rekam Medis</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dokter.medical-records.update', $medicalRecord->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">Pasien</label>
                                <select class="form-select" id="patient_id" name="patient_id" required>
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id', $medicalRecord->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="record_date" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="record_date" name="record_date"
                                    value="{{ old('record_date', $medicalRecord->record_date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="complaint" class="form-label">Keluhan</label>
                                <textarea class="form-control" id="complaint" name="complaint" rows="3" required>{{ old('complaint', $medicalRecord->complaint) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3" required>{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $medicalRecord->notes) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending"
                                        {{ old('status', $medicalRecord->status) == 'pending' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="completed"
                                        {{ old('status', $medicalRecord->status) == 'completed' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="cancelled"
                                        {{ old('status', $medicalRecord->status) == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                            </div>

                            <!-- Treatment Section -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Penanganan</h6>
                                </div>
                                <div class="card-body">
                                    <div id="treatments-container">
                                        @foreach ($medicalRecord->treatments as $index => $treatment)
                                            <div class="treatment-item mb-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nama Penanganan</label>
                                                        <input type="text" class="form-control"
                                                            name="treatments[{{ $index }}][name]"
                                                            value="{{ old("treatments.{$index}.name", $treatment->name) }}"
                                                            required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Biaya</label>
                                                        <input type="number" class="form-control"
                                                            name="treatments[{{ $index }}][cost]"
                                                            value="{{ old("treatments.{$index}.cost", $treatment->cost) }}"
                                                            required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button"
                                                            class="btn btn-danger btn-block remove-treatment">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <label class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" name="treatments[{{ $index }}][description]" rows="2">{{ old("treatments.{$index}.description", $treatment->description) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-success" id="add-treatment">
                                        <i class="fas fa-plus"></i> Tambah Penanganan
                                    </button>
                                </div>
                            </div>

                            <!-- Prescription Section -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="has_prescription"
                                            name="has_prescription" value="1"
                                            {{ $medicalRecord->prescription ? 'checked' : '' }}>
                                        <label class="form-check-label" for="has_prescription">
                                            <h6 class="m-0 font-weight-bold text-primary">Resep Obat</h6>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body" id="prescription-section"
                                    style="display: {{ $medicalRecord->prescription ? 'block' : 'none' }};">
                                    <div class="mb-3">
                                        <label for="issue_date" class="form-label">Tanggal Terbit</label>
                                        <input type="date" class="form-control" id="issue_date"
                                            name="prescription[issue_date]"
                                            value="{{ old('prescription.issue_date', $medicalRecord->prescription ? $medicalRecord->prescription->issue_date->format('Y-m-d') : date('Y-m-d')) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="valid_until" class="form-label">Berlaku Sampai</label>
                                        <input type="date" class="form-control" id="valid_until"
                                            name="prescription[valid_until]"
                                            value="{{ old('prescription.valid_until', $medicalRecord->prescription ? $medicalRecord->prescription->valid_until?->format('Y-m-d') : '') }}">
                                    </div>

                                    <div id="prescription-items-container">
                                        @if ($medicalRecord->prescription)
                                            @foreach ($medicalRecord->prescription->prescriptionItems as $index => $item)
                                                <div class="prescription-item mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Obat</label>
                                                            <select class="form-select"
                                                                name="prescription_items[{{ $index }}][medicine_id]"
                                                                required>
                                                                <option value="">Pilih Obat</option>
                                                                @foreach ($medicines as $medicine)
                                                                    <option value="{{ $medicine->id }}"
                                                                        {{ old("prescription_items.{$index}.medicine_id", $item->medicine_id) == $medicine->id ? 'selected' : '' }}>
                                                                        {{ $medicine->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Jumlah</label>
                                                            <input type="number" class="form-control"
                                                                name="prescription_items[{{ $index }}][quantity]"
                                                                value="{{ old("prescription_items.{$index}.quantity", $item->quantity) }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">&nbsp;</label>
                                                            <button type="button"
                                                                class="btn btn-danger btn-block remove-prescription-item">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Dosis</label>
                                                            <input type="text" class="form-control"
                                                                name="prescription_items[{{ $index }}][dosage]"
                                                                value="{{ old("prescription_items.{$index}.dosage", $item->dosage) }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Frekuensi</label>
                                                            <input type="text" class="form-control"
                                                                name="prescription_items[{{ $index }}][frequency]"
                                                                value="{{ old("prescription_items.{$index}.frequency", $item->frequency) }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Petunjuk Penggunaan</label>
                                                            <textarea class="form-control" name="prescription_items[{{ $index }}][instructions]" rows="2">{{ old("prescription_items.{$index}.instructions", $item->instructions) }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-success" id="add-prescription-item">
                                        <i class="fas fa-plus"></i> Tambah Obat
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dokter.medical-records.show', $medicalRecord->id) }}"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Treatment Management
            let treatmentIndex = {{ $medicalRecord->treatments->count() }};

            $('#add-treatment').click(function() {
                const template = `
                <div class="treatment-item mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nama Penanganan</label>
                            <input type="text" class="form-control" name="treatments[${treatmentIndex}][name]" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Biaya</label>
                            <input type="number" class="form-control" name="treatments[${treatmentIndex}][cost]" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block remove-treatment">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="treatments[${treatmentIndex}][description]" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            `;
                $('#treatments-container').append(template);
                treatmentIndex++;
            });

            $(document).on('click', '.remove-treatment', function() {
                $(this).closest('.treatment-item').remove();
            });

            // Prescription Management
            let prescriptionItemIndex =
                {{ $medicalRecord->prescription ? $medicalRecord->prescription->prescriptionItems->count() : 0 }};

            $('#has_prescription').change(function() {
                $('#prescription-section').toggle(this.checked);
                $('input[name^="prescription_items"], select[name^="prescription_items"]').prop('required',
                    this.checked);
            });

            $('#add-prescription-item').click(function() {
                const template = `
                <div class="prescription-item mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Obat</label>
                            <select class="form-select" name="prescription_items[${prescriptionItemIndex}][medicine_id]" required>
                                <option value="">Pilih Obat</option>
                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="prescription_items[${prescriptionItemIndex}][quantity]" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-block remove-prescription-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Dosis</label>
                            <input type="text" class="form-control" name="prescription_items[${prescriptionItemIndex}][dosage]" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Frekuensi</label>
                            <input type="text" class="form-control" name="prescription_items[${prescriptionItemIndex}][frequency]" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="form-label">Petunjuk Penggunaan</label>
                            <textarea class="form-control" name="prescription_items[${prescriptionItemIndex}][instructions]" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            `;
                $('#prescription-items-container').append(template);
                prescriptionItemIndex++;
            });

            $(document).on('click', '.remove-prescription-item', function() {
                $(this).closest('.prescription-item').remove();
            });
        });
    </script>
@endpush
