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
        $(function() {
            $('#rooms-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.rooms.index') }}",
                columns: [{
                        data: 'room_number',
                        name: 'room_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'room_type',
                        name: 'room_type'
                    },
                    {
                        data: 'floor',
                        name: 'floor'
                    },
                    {
                        data: 'capacity',
                        name: 'capacity'
                    },
                    {
                        data: 'price_per_day',
                        name: 'price_per_day',
                        render: function(data) {
                            return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });
        });
    </script>
@endpush
