@php
    $statusClasses = [
        'tersedia' => 'success',
        'terisi' => 'danger',
        'perbaikan' => 'warning',
    ];

    $statusLabels = [
        'tersedia' => 'Tersedia',
        'terisi' => 'Terisi',
        'perbaikan' => 'Perbaikan',
    ];
@endphp

<span class="badge badge-{{ $statusClasses[$room->status] ?? 'secondary' }}">
    {{ $statusLabels[$room->status] ?? 'Tidak Diketahui' }}
</span>
