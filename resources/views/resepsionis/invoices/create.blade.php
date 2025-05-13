@extends('layouts.app')

@section('title', 'Buat Nota Penanganan')

@section('styles')
    <style>
        .medical-record-card {
            cursor: pointer;
        }

        .medical-record-card.selected {
            border: 2px solid #4e73df;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Buat Nota Penanganan</h1>
            <a href="{{ route('resepsionis.invoices.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <form action="{{ route('resepsionis.invoices.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pilih Rekam Medis</h6>
                        </div>
                        <div class="card-body">
                            @if (count($medicalRecords) > 0)
                                <div class="row">
                                    @foreach ($medicalRecords as $record)
                                        <div class="col-md-6 mb-4">
                                            <div class="card medical-record-card h-100" data-id="{{ $record->id }}"
                                                data-patient-id="{{ $record->patient_id }}"
                                                data-doctor-id="{{ $record->doctor_id }}"
                                                data-treatment-cost="{{ $record->treatments->first() ? $record->treatments->first()->cost : 0 }}">
                                                <div class="card-body">
                                                    <h5 class="card-title font-weight-bold text-primary">
                                                        {{ $record->patient->user->name }}
                                                        <small
                                                            class="text-muted">({{ $record->created_at->format('d M Y') }})</small>
                                                    </h5>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">Dokter</div>
                                                        <div class="col-md-7">: {{ $record->doctor->user->name }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">Diagnosis</div>
                                                        <div class="col-md-7">: {{ $record->diagnosis }}</div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">Penanganan</div>
                                                        <div class="col-md-7">:
                                                            {{ $record->treatments->first() ? $record->treatments->first()->name : '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5">Biaya Penanganan</div>
                                                        <div class="col-md-7">: Rp
                                                            {{ $record->treatments->first() ? number_format($record->treatments->first()->cost, 0, ',', '.') : 0 }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Klik pada salah satu rekam medis di atas untuk
                                    membuatkan nota.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Tidak ada rekam medis yang tersedia untuk
                                    dibuatkan nota.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pembelian Obat</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="medicineTable">
                                    <thead>
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Satuan</th>
                                            <th>Subtotal</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="medicinePlaceholder">
                                            <td colspan="6" class="text-center">Belum ada obat dipilih</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right font-weight-bold">Total Obat:</td>
                                            <td id="totalMedicineAmount" class="font-weight-bold">Rp 0</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <button type="button" class="btn btn-success mt-2" id="addMedicineBtn">
                                <i class="fas fa-plus"></i> Tambah Obat
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Nota Penanganan</h6>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="medical_record_id" id="medical_record_id"
                                value="{{ old('medical_record_id') }}">
                            <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id') }}">
                            <input type="hidden" name="doctor_id" id="doctor_id" value="{{ old('doctor_id') }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_amount">Total Biaya <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number"
                                                class="form-control @error('total_amount') is-invalid @enderror"
                                                id="total_amount" name="total_amount" value="{{ old('total_amount') }}"
                                                required>
                                            @error('total_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_status">Status Pembayaran <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('payment_status') is-invalid @enderror"
                                            id="payment_status" name="payment_status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="pending"
                                                {{ old('payment_status') == 'pending' ? 'selected' : '' }}>
                                                Menunggu Pembayaran</option>
                                            <option value="paid"
                                                {{ old('payment_status') == 'paid' ? 'selected' : '' }}>
                                                Sudah Dibayar</option>
                                            <option value="cancelled"
                                                {{ old('payment_status') == 'cancelled' ? 'selected' : '' }}>
                                                Dibatalkan</option>
                                        </select>
                                        @error('payment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Catatan</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-save"></i> Simpan Nota
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="addMedicineModal" tabindex="-1" role="dialog" aria-labelledby="addMedicineModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicineModalLabel">Tambah Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selectMedicine">Pilih Obat</label>
                        <select class="form-control" id="selectMedicine">
                            <option value="">-- Pilih Obat --</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-name="{{ $medicine->name }}"
                                    data-price="{{ $medicine->price }}" data-stock="{{ $medicine->stock }}">
                                    {{ $medicine->name }} (Stok: {{ $medicine->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="medicineDetails" style="display: none;">
                        <div class="alert alert-info">
                            <p><strong>Nama:</strong> <span id="medicineName"></span></p>
                            <p><strong>Harga:</strong> Rp <span id="medicinePrice"></span></p>
                            <p><strong>Stok Tersedia:</strong> <span id="medicineStock"></span></p>
                        </div>

                        <div class="form-group">
                            <label for="medicineQuantity">Kuantitas</label>
                            <input type="number" class="form-control" id="medicineQuantity" min="1"
                                value="1">
                            <div id="quantityError" class="text-danger" style="display: none;">
                                Kuantitas tidak boleh melebihi stok yang tersedia
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="medicineNotes">Catatan</label>
                            <textarea class="form-control" id="medicineNotes" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="saveMedicineBtn" disabled>Tambahkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle medical record selection
            $('.medical-record-card').click(function() {
                // Remove selected class from all cards
                $('.medical-record-card').removeClass('selected');

                // Add selected class to clicked card
                $(this).addClass('selected');

                // Get data from selected card
                const medicalRecordId = $(this).data('id');
                const patientId = $(this).data('patient-id');
                const doctorId = $(this).data('doctor-id');
                const treatmentCost = $(this).data('treatment-cost');

                // Set values to hidden inputs
                $('#medical_record_id').val(medicalRecordId);
                $('#patient_id').val(patientId);
                $('#doctor_id').val(doctorId);
                $('#total_amount').val(treatmentCost);

                // Enable submit button
                $('#submitBtn').prop('disabled', false);
                updateTotalAmount();
            });

            // Medicine management
            let medicineIndex = 0;
            let selectedMedicine = null;

            // Show medicine modal
            $('#addMedicineBtn').click(function() {
                $('#addMedicineModal').modal('show');
            });

            // Handle medicine selection
            $('#selectMedicine').change(function() {
                const medicineId = $(this).val();

                if (medicineId) {
                    const option = $(this).find('option:selected');
                    selectedMedicine = {
                        id: medicineId,
                        name: option.data('name'),
                        price: option.data('price'),
                        stock: option.data('stock')
                    };

                    $('#medicineName').text(selectedMedicine.name);
                    $('#medicinePrice').text(selectedMedicine.price.toLocaleString('id-ID'));
                    $('#medicineStock').text(selectedMedicine.stock);
                    $('#medicineQuantity').attr('max', selectedMedicine.stock);
                    $('#medicineQuantity').val(1);
                    $('#medicineDetails').show();
                    $('#saveMedicineBtn').prop('disabled', false);
                    $('#quantityError').hide();
                } else {
                    selectedMedicine = null;
                    $('#medicineDetails').hide();
                    $('#saveMedicineBtn').prop('disabled', true);
                }
            });

            // Validate quantity
            $('#medicineQuantity').on('input', function() {
                const quantity = parseInt($(this).val());

                if (selectedMedicine && quantity > selectedMedicine.stock) {
                    $('#quantityError').show();
                    $('#saveMedicineBtn').prop('disabled', true);
                } else if (quantity <= 0) {
                    $('#quantityError').show();
                    $('#saveMedicineBtn').prop('disabled', true);
                } else {
                    $('#quantityError').hide();
                    $('#saveMedicineBtn').prop('disabled', false);
                }
            });

            // Add medicine to table
            $('#saveMedicineBtn').click(function() {
                if (!selectedMedicine) return;

                const quantity = parseInt($('#medicineQuantity').val());
                const notes = $('#medicineNotes').val();
                const subtotal = selectedMedicine.price * quantity;

                // Remove placeholder if it exists
                $('#medicinePlaceholder').remove();

                // Add medicine to table
                const row = `
                    <tr id="medicineRow${medicineIndex}">
                        <td>
                            ${selectedMedicine.name}
                            <input type="hidden" name="medicine_id[${medicineIndex}]" value="${selectedMedicine.id}">
                        </td>
                        <td>
                            ${quantity}
                            <input type="hidden" name="quantity[${medicineIndex}]" value="${quantity}">
                        </td>
                        <td>
                            Rp ${selectedMedicine.price.toLocaleString('id-ID')}
                            <input type="hidden" name="medicine_price[${medicineIndex}]" value="${selectedMedicine.price}">
                        </td>
                        <td>
                            Rp ${subtotal.toLocaleString('id-ID')}
                            <input type="hidden" class="medicine-subtotal" value="${subtotal}">
                        </td>
                        <td>
                            ${notes || '-'}
                            <input type="hidden" name="medicine_notes[${medicineIndex}]" value="${notes}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-medicine" data-index="${medicineIndex}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $('#medicineTable tbody').append(row);
                medicineIndex++;

                // Reset form
                $('#selectMedicine').val('').trigger('change');
                $('#medicineDetails').hide();
                $('#medicineNotes').val('');

                // Close modal
                $('#addMedicineModal').modal('hide');

                // Update total
                updateTotalAmount();
            });

            // Remove medicine from table
            $(document).on('click', '.remove-medicine', function() {
                const index = $(this).data('index');
                $(`#medicineRow${index}`).remove();

                // If no medicines left, add placeholder
                if ($('#medicineTable tbody tr').length === 0) {
                    $('#medicineTable tbody').append(`
                        <tr id="medicinePlaceholder">
                            <td colspan="6" class="text-center">Belum ada obat dipilih</td>
                        </tr>
                    `);
                }

                // Update total
                updateTotalAmount();
            });

            // Update total amount
            function updateTotalAmount() {
                let totalMedicine = 0;
                $('.medicine-subtotal').each(function() {
                    totalMedicine += parseFloat($(this).val());
                });

                $('#totalMedicineAmount').text(`Rp ${totalMedicine.toLocaleString('id-ID')}`);
            }

            // Initialize Select2
            $('#selectMedicine').select2({
                width: '100%',
                dropdownParent: $('#addMedicineModal')
            });
        });
    </script>
@endsection
