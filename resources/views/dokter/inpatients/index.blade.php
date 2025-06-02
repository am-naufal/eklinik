@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Pasien Rawat Inap</h1>
        </div>

        <!-- Filter Box -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Filter & Pencarian</h6>
            </div>
            <div class="card-body">
                <form id="searchForm" action="{{ route('dokter.inpatients.index') }}" method="GET" class="mb-0">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label for="search" class="form-label">Cari</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    placeholder="Cari nama atau nomor rekam medis..." value="{{ $search }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    @foreach ($statuses as $key => $value)
                                        <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                            {{ $value }}
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
                                <a href="{{ route('dokter.inpatients.index') }}" class="btn btn-secondary" id="resetButton">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Inpatients Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold">Daftar Pasien</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Ruangan</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inpatients as $inpatient)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $inpatient->patient->medical_record_number }}</td>
                                    <td>{{ $inpatient->patient->name }}</td>
                                    <td>{{ $inpatient->room->name }}</td>
                                    <td>{{ $inpatient->admission_date->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if ($inpatient->status === 'active')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif ($inpatient->status === 'discharged')
                                            <span class="badge bg-info">Pulang</span>
                                        @else
                                            <span class="badge bg-warning">Ditransfer</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('dokter.inpatients.show', $inpatient->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($inpatient->status === 'active')
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#updateStatusModal{{ $inpatient->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Update Status Modal -->
                                        <div class="modal fade" id="updateStatusModal{{ $inpatient->id }}" tabindex="-1"
                                            aria-labelledby="updateStatusModalLabel{{ $inpatient->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('dokter.inpatients.update', $inpatient->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="updateStatusModalLabel{{ $inpatient->id }}">
                                                                Update Status Pasien
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select class="form-select" id="status" name="status"
                                                                    required>
                                                                    <option value="discharged">Pulang</option>
                                                                    <option value="transferred">Ditransfer</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="discharge_note"
                                                                    class="form-label">Catatan</label>
                                                                <textarea class="form-control" id="discharge_note" name="discharge_note" rows="3" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $inpatients->links() }}
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
                }
            });

            // Aplikasikan pencarian server ke datatable jika ada
            if ("{{ $search }}") {
                table.search("{{ $search }}").draw();
            }

            // Menangani reset pencarian dan status
            $('#resetButton').on('click', function(e) {
                e.preventDefault();
                $('#search').val('');
                $('#status').val('');
                table.search('').columns().search('').draw();
                window.location.href = "{{ route('dokter.inpatients.index') }}";
            });
        });
    </script>
@endpush
