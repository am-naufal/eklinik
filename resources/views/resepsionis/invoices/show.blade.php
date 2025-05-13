@extends('layouts.app')

@section('title', 'Detail Nota Penanganan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Nota Penanganan</h1>
            <div>
                @if ($invoice->payment_status == 'pending')
                    <form action="{{ route('resepsionis.invoices.markAsPaid', $invoice->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-success shadow-sm"
                            onclick="return confirm('Apakah Anda yakin ingin menandai nota ini sebagai sudah dibayar?')">
                            <i class="fas fa-check fa-sm text-white-50"></i> Tandai Sudah Dibayar
                        </button>
                    </form>
                @endif
                <a href="{{ route('resepsionis.invoices.edit', $invoice->id) }}"
                    class="btn btn-sm btn-primary shadow-sm ml-1">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                </a>
                <a href="{{ route('resepsionis.invoices.print', $invoice->id) }}" class="btn btn-sm btn-info shadow-sm ml-1"
                    target="_blank">
                    <i class="fas fa-print fa-sm text-white-50"></i> Cetak
                </a>
                <a href="{{ route('resepsionis.invoices.index') }}" class="btn btn-sm btn-secondary shadow-sm ml-1">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Invoice Details -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Nota</h6>
                        <div>
                            @if ($invoice->payment_status == 'pending')
                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                            @elseif($invoice->payment_status == 'paid')
                                <span class="badge badge-success">Lunas</span>
                            @elseif($invoice->payment_status == 'cancelled')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 40%">Nomor Nota</th>
                                        <td>{{ $invoice->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>{{ $invoice->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pasien</th>
                                        <td>
                                            <a href="{{ route('resepsionis.patients.show', $invoice->patient_id) }}">
                                                {{ $invoice->patient->user->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dokter</th>
                                        <td>{{ $invoice->doctor->user->name }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 40%">Status</th>
                                        <td>
                                            @if ($invoice->payment_status == 'pending')
                                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                                            @elseif($invoice->payment_status == 'paid')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($invoice->payment_status == 'cancelled')
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Bayar</th>
                                        <td>{{ $invoice->paid_at ? $invoice->paid_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td class="font-weight-bold">Rp
                                            {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Oleh</th>
                                        <td>{{ $invoice->creator->name }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold">Catatan:</h6>
                                        <p>{{ $invoice->notes ?? 'Tidak ada catatan' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patient Info -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Pasien</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th style="width: 40%">Nama</th>
                                <td>{{ $invoice->patient->user->name }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $invoice->patient->phone_number ?? $invoice->patient->user->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $invoice->patient->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $invoice->patient->address ?? $invoice->patient->user->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Record Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekam Medis Terkait</h6>
            </div>
            <div class="card-body">
                @if ($invoice->medicalRecord)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">Informasi Penanganan</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">Tanggal Kunjungan</th>
                                            <td>{{ $invoice->medicalRecord->created_at->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Diagnosis</th>
                                            <td>{{ $invoice->medicalRecord->diagnosis }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Penanganan</th>
                                            <td>{{ $invoice->medicalRecord->treatments->first() ? $invoice->medicalRecord->treatments->first()->name : '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Penanganan</th>
                                            <td>
                                                Rp
                                                {{ $invoice->medicalRecord->treatments->first() ? number_format($invoice->medicalRecord->treatments->first()->cost, 0, ',', '.') : 0 }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">Catatan Dokter</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $invoice->medicalRecord->notes ?? 'Tidak ada catatan' }}</p>
                                </div>
                            </div>
                            @if ($invoice->medicalRecord->prescription)
                                <div class="card mt-3">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Resep Obat</h6>
                                    </div>
                                    <div class="card-body">
                                        @if (count($invoice->medicalRecord->prescription->items) > 0)
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Obat</th>
                                                        <th>Dosis</th>
                                                        <th>Aturan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($invoice->medicalRecord->prescription->items as $item)
                                                        <tr>
                                                            <td>{{ $item->medicine->name }}</td>
                                                            <td>{{ $item->dosage }}</td>
                                                            <td>{{ $item->instruction }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <p>Tidak ada obat yang diresepkan</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Rekam medis tidak ditemukan.
                    </div>
                @endif
            </div>
        </div>

        <!-- Daftar Obat -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Obat</h6>
            </div>
            <div class="card-body">
                @if (count($invoice->items) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $item)
                                    <tr>
                                        <td>{{ $item->medicine->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td>{{ $item->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right font-weight-bold">Total Obat:</td>
                                    <td colspan="2" class="font-weight-bold">
                                        Rp {{ number_format($invoice->items->sum('subtotal'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Tidak ada obat dalam nota ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
