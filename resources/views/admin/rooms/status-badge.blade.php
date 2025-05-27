@php
    $statusClasses = [
        'available' => 'success',
        'occupied' => 'danger',
        'maintenance' => 'warning',
    ];

    $statusLabels = [
        'available' => 'Tersedia',
        'occupied' => 'Terisi',
        'maintenance' => 'Maintenance',
    ];
@endphp

<span class="badge badge-{{ $statusClasses[$room->status] }}">
    {{ $statusLabels[$room->status] }}
</span>
