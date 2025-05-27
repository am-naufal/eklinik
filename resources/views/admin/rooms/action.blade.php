<div class="btn-group" role="group">
    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger delete-room" data-id="{{ $room->id }}" title="Hapus">
        <i class="fas fa-trash"></i>
    </button>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-room').click(function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/rooms/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Berhasil!',
                                        response.message,
                                        'success'
                                    ).then(() => {
                                        $('#rooms-table').DataTable().ajax
                                            .reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON.message ||
                                    'Terjadi kesalahan!',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
