@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Obat</h1>
            <a href="{{ route('dokter.medicines.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Obat Baru
            </a>
        </div>

        <!-- Filter Box -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Filter & Pencarian</h6>
            </div>
            <div class="card-body">
                <form id="searchForm" action="{{ route('dokter.medicines.index') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label for="search" class="form-label">Cari</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    placeholder="Cari nama, kode, atau deskripsi..." value="{{ $search }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                                <a href="{{ route('dokter.medicines.index') }}" class="btn btn-secondary" id="resetButton">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Medicines Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Daftar Obat</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $medicine)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $medicine->code }}</td>
                                    <td>{{ $medicine->name }}</td>
                                    <td>{{ $medicine->category ?? '-' }}</td>
                                    <td>
                                        @if ($medicine->stock <= 10)
                                            <span class="badge bg-danger">{{ $medicine->stock }}</span>
                                        @elseif($medicine->stock <= 20)
                                            <span class="badge bg-warning">{{ $medicine->stock }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $medicine->stock }}</span>
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('dokter.medicines.show', $medicine->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dokter.medicines.edit', $medicine->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('dokter.medicines.destroy', $medicine->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            var table = $('#dataTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
                paging: true,
                ordering: true,
                info: true,
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                },
                // Jika ada pencarian atau filter dari server
                search: {
                    return: true // Aktifkan pencarian saat tekan enter
                }
            });

            // Aplikasikan pencarian server ke datatable jika ada
            if ("{{ $search }}") {
                table.search("{{ $search }}").draw();
            }

            // Menangani reset pencarian dan kategori
            $('#resetButton').on('click', function(e) {
                e.preventDefault();
                // Reset form
                $('#search').val('');
                $('#category').val('');
                // Reset DataTables
                table.search('').columns().search('').draw();
                // Redirect ke halaman tanpa filter
                window.location.href = "{{ route('dokter.medicines.index') }}";
            });

            // Otomatis reset filter server setelah pengguna menggunakan filter client
            $('#dataTable_filter input').on('keyup', function(e) {
                // Jika pencarian server aktif dan ada input di pencarian client
                if ("{{ $search }}" && this.value) {
                    // Hapus URL filter dari query string
                    if (window.history && window.history.pushState) {
                        var newUrl = window.location.protocol + "//" + window.location.host +
                            window.location.pathname;
                        window.history.pushState({
                            path: newUrl
                        }, '', newUrl);
                    }
                }
            });

            // Jika masih ada filter dari server, tampilkan tombol reset
            if ("{{ $search }}" || "{{ $category }}") {
                // Tambahkan tombol reset di atas tabel
                $('.card-header:contains("Daftar Obat")').append(
                    '<button type="button" id="resetTableButton" class="btn btn-sm btn-outline-secondary float-end">' +
                    '<i class="fas fa-sync-alt me-1"></i> Reset Filter Server</button>'
                );

                // Event handler untuk tombol reset tabel
                $('#resetTableButton').on('click', function() {
                    window.location.href = "{{ route('dokter.medicines.index') }}";
                });
            }
        });
    </script>
@endpush
