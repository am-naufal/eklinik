@extends('layouts.app')

@section('title', 'Manajemen Ruang Rawat Inap')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Manajemen Ruang Rawat Inap</h1>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Ruangan
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="rooms-table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. Ruangan</th>
                                <th>Nama Kamar</th>
                                <th>Tipe Ruangan</th>
                                <th>Lantai</th>
                                <th>Kapasitas</th>
                                <th>Harga/Hari</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td>{{ $room->room_number }}</td>
                                    <td>{{ $room->name }}</td>
                                    <td>{{ $room->room_type }}</td>
                                    <td>{{ $room->floor }}</td>
                                    <td>{{ $room->capacity }}</td>
                                    <td>Rp {{ number_format($room->price_per_day, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($room->status == 'tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @elseif ($room->status == 'terisi')
                                            <span class="badge bg-danger">Terisi</span>
                                        @else
                                            <span class="badge bg-warning">Perbaikan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ route('admin.rooms.destroy', $room->id) }}"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
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
        $('#rooms-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ordering: true,
            responsive: true,
        });
        // $(function() {
        //     $('#rooms-table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('admin.rooms.index') }}",
        //         columns: [{
        //                 data: 'room_number',
        //                 name: 'room_number'
        //             },
        //             {
        //                 data: 'name',
        //                 name: 'name'
        //             },
        //             {
        //                 data: 'room_type',
        //                 name: 'room_type'
        //             },
        //             {
        //                 data: 'floor',
        //                 name: 'floor'
        //             },
        //             {
        //                 data: 'capacity',
        //                 name: 'capacity'
        //             },
        //             {
        //                 data: 'price_per_day',
        //                 name: 'price_per_day',
        //                 render: function(data) {
        //                     return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
        //                 }
        //             },
        //             {
        //                 data: 'status',
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
