@extends('layouts.app')

@section('title', 'Manajemen Rawat Inap')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Rawat Inap</h1>
            <a href="{{ route('admin.inpatients.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Rawat Inap
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="inpatients-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>No. Ruangan</th>
                                <th>Dokter</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inpatients as $inpatient)
                                <tr>
                                    <td>{{ $inpatient->patient->medical_record_number }}</td>
                                    <td>{{ $inpatient->patient->user->name }}</td>
                                    <td>{{ $inpatient->room->room_number }}</td>
                                    <td>{{ $inpatient->doctor->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inpatient->admission_date)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inpatient->discharge_date)->format('d-m-Y') ?? 'Belum Keluar' }}
                                    </td>
                                    <td>{{ $inpatient->status }}</td>
                                    <td>
                                        <a href="{{ route('admin.inpatients.show', $inpatient->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('admin.inpatients.edit', $inpatient->id) }}"
                                            class="btn btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.inpatients.destroy', $inpatient->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus rawat inap ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
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

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inpatients-table').DataTable({
                // Aktifkan tombol export dan fitur lainnya
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print',
                ],
                ordering: true,
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari _MAX_ total entri)",
                    zeroRecords: "Tidak ditemukan data ",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
        // $(function() {
        //     $('#inpatients-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('admin.inpatients.index') }}",
        //         columns: [{
        //                 data: 'patient.medical_record_number',
        //                 name: 'patient.medical_record_number'
        //             },
        //             {
        //                 data: 'patient_name',
        //                 name: 'patient_name'
        //             },
        //             {
        //                 data: 'room_number',
        //                 name: 'room_number'
        //             },
        //             {
        //                 data: 'doctor_name',
        //                 name: 'doctor_name'
        //             },
        //             {
        //                 data: 'check_in_date',
        //                 name: 'check_in_date',
        //                 render: function(data) {
        //                     return moment(data).format('DD/MM/YYYY HH:mm');
        //                 }
        //             },
        //             {
        //                 data: 'check_out_date',
        //                 name: 'check_out_date',
        //                 render: function(data) {
        //                     return data ? moment(data).format('DD/MM/YYYY HH:mm') : '-';
        //                 }
        //             },
        //             {
        //                 data: 'status_badge',
        //                 name: 'status',
        //                 orderable: false,
        //                 searchable: false
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: false,
        //                 searchable: false
        //             }
        //         ],
        //         language: {
        //             url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        //         }
        //     });
        // });
    </script>
@endpush
