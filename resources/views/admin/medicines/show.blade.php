@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Obat</h1>
            <div>
                <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Edit Obat
                </a>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Detail Obat Card -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Obat</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th style="width: 25%">Kode Obat</th>
                                        <td>{{ $medicine->code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <td>{{ $medicine->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>{{ $medicine->category ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stok</th>
                                        <td>
                                            @if ($medicine->stock <= 10)
                                                <span class="badge badge-danger">{{ $medicine->stock }}</span>
                                            @elseif($medicine->stock <= 20)
                                                <span class="badge badge-warning">{{ $medicine->stock }}</span>
                                            @else
                                                <span class="badge badge-success">{{ $medicine->stock }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Harga</th>
                                        <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $medicine->description ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td>{{ $medicine->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Diupdate</th>
                                        <td>{{ $medicine->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Penggunaan Obat -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik Penggunaan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    Total Penggunaan
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usageCount }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-pills fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Jumlah Nota
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $invoiceCount }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Adjustment Form Card -->
            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Penyesuaian Stok</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.medicines.update-stock', $medicine->id) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="adjustment_type">Jenis Penyesuaian</label>
                                <select class="form-control @error('adjustment_type') is-invalid @enderror"
                                    id="adjustment_type" name="adjustment_type" required>
                                    <option value="add" {{ old('adjustment_type') == 'add' ? 'selected' : '' }}>Tambah
                                        Stok</option>
                                    <option value="subtract" {{ old('adjustment_type') == 'subtract' ? 'selected' : '' }}>
                                        Kurangi Stok</option>
                                </select>
                                @error('adjustment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="adjustment_amount">Jumlah</label>
                                <input type="number" class="form-control @error('adjustment_amount') is-invalid @enderror"
                                    id="adjustment_amount" name="adjustment_amount"
                                    value="{{ old('adjustment_amount', 1) }}" min="1" required>
                                @error('adjustment_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="notes">Catatan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                <small class="form-text text-muted">Opsional: Catatan mengapa stok disesuaikan</small>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save"></i> Simpan Penyesuaian
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
