@php
    $statusClasses = [
        'active' => 'primary',
        'discharged' => 'success',
        'transferred' => 'warning',
    ];

    $statusLabels = [
        'active' => 'Aktif',
        'discharged' => 'Pulang',
        'transferred' => 'Dipindahkan',
    ];
@endphp

<span class="badge badge-{{ $statusClasses[$inpatient->status] }}">
    {{ $statusLabels[$inpatient->status] }}
</span>
