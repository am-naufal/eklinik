<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/dashboard') ? 'active' : '' }}" href="{{ route('dokter.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/appointments*') ? 'active' : '' }}"
        href="{{ route('dokter.appointments.index') }}">
        <i class="fas fa-fw fa-calendar-alt me-2"></i>
        Jadwal Praktik
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/medicines*') ? 'active' : '' }}"
        href="{{ route('dokter.medicines.index') }}">
        <i class="fas fa-fw fa-pills me-2"></i>
        Obat
    </a>
</li>
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ Request::is('dokter/medical-records*') ? 'active' : '' }}"
        href="#rekamMedisSubmenu" data-bs-toggle="collapse" role="button"
        aria-expanded="{{ Request::is('dokter/medical-records*') ? 'true' : 'false' }}"
        aria-controls="rekamMedisSubmenu">
        <span><i class="fas fa-fw fa-clipboard-list me-2"></i>Rekam Medis</span>
        <i class="fas fa-fw fa-chevron-down small"></i>
    </a>
    <div class="collapse {{ Request::is('dokter/medical-records*') ? 'show' : '' }}" id="rekamMedisSubmenu">
        <ul class="nav flex-column mt-1">
            <li class="nav-item">
                <a href="{{ route('dokter.medical-records.index') }}"
                    class="nav-link {{ Request::is('dokter/medical-records*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-list me-2"></i>Rekam Medis saya
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dokter/medical-records/all') ? 'active' : '' }}"
                    href="{{ route('dokter.medical-records.semua') }}">
                    <i class="fas fa-fw fa-file-medical me-2"></i>
                    Semua Rekam Medis
                </a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/inpatients*') ? 'active' : '' }}"
        href="{{ route('dokter.inpatients.index') }}">
        <i class="fas fa-fw fa-procedures me-2"></i>
        Rawat Inap
    </a>
</li>
