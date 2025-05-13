@extends('layouts.app')

@section('title', 'Edit Nota Penanganan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Nota Penanganan</h1>
            <a href="{{ route('resepsionis.invoices.show', $invoice->id) }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Nota</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('resepsionis.invoices.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Nota</label>
                                        <input type="text" class="form-control" value="{{ $invoice->invoice_number }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="text" class="form-control"
                                            value="{{ $invoice->created_at->format('d M Y H:i') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pasien</label>
                                        <input type="text" class="form-control"
                                            value="{{ $invoice->patient->user->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dokter</label>
                                        <input type="text" class="form-control"
                                            value="{{ $invoice->doctor->user->name }}" readonly>
                                    </div>
                                </div>
                            </div>

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
                                                id="total_amount" name="total_amount"
                                                value="{{ old('total_amount', $invoice->total_amount) }}" required>
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
                                            <option value="pending"
                                                {{ old('payment_status', $invoice->payment_status) == 'pending' ? 'selected' : '' }}>
                                                Menunggu Pembayaran</option>
                                            <option value="paid"
                                                {{ old('payment_status', $invoice->payment_status) == 'paid' ? 'selected' : '' }}>
                                                Sudah Dibayar</option>
                                            <option value="cancelled"
                                                {{ old('payment_status', $invoice->payment_status) == 'cancelled' ? 'selected' : '' }}>
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
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $invoice->notes) }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Rekam Medis Terkait</h6>
                    </div>
                    <div class="card-body">
                        @if ($invoice->medicalRecord)
                            <div class="alert alert-info">
                                <strong>Tanggal:</strong> {{ $invoice->medicalRecord->created_at->format('d M Y') }}<br>
                                <strong>Diagnosis:</strong> {{ $invoice->medicalRecord->diagnosis }}<br>
                                <strong>Penanganan:</strong>
                                {{ $invoice->medicalRecord->treatments->first() ? $invoice->medicalRecord->treatments->first()->name : '-' }}<br>
                                <strong>Biaya Penanganan:</strong> Rp
                                {{ $invoice->medicalRecord->treatments->first() ? number_format($invoice->medicalRecord->treatments->first()->cost, 0, ',', '.') : 0 }}
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Rekam medis tidak ditemukan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
