@extends('layouts.app')

@section('title', 'Nota Penanganan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Nota Penanganan</h1>
            <a href="{{ route('resepsionis.invoices.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Nota Baru
            </a>
        </div>

        <!-- Filter Box -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter Nota</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('resepsionis.invoices.index') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status Pembayaran</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Semua
                                        Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas
                                    </option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group pt-4 mt-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter fa-sm"></i> Filter
                                </button>
                                <a href="{{ route('resepsionis.invoices.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt fa-sm"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Nota Penanganan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. Nota</th>
                                <th>Pasien</th>
                                <th>Dokter</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>
                                        <a href="{{ route('resepsionis.patients.show', $invoice->patient_id) }}">
                                            {{ $invoice->patient->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $invoice->doctor->user->name }}</td>
                                    <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                    <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($invoice->payment_status == 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($invoice->payment_status == 'paid')
                                            <span class="badge badge-success">Lunas</span>
                                        @elseif($invoice->payment_status == 'cancelled')
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $invoice->payment_status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('resepsionis.invoices.show', $invoice->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('resepsionis.invoices.edit', $invoice->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('resepsionis.invoices.print', $invoice->id) }}"
                                            class="btn btn-secondary btn-sm" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <form action="{{ route('resepsionis.invoices.destroy', $invoice->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus nota ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data nota penanganan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $invoices->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": false,
                "ordering": true,
                "info": false,
                "searching": false
            });
        });
    </script>
@endsection
