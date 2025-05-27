<li class="nav-item mb-1">
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i>Dashboard
    </a>
</li>
<li class="nav-item mb-1">
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
        <i class="fas fa-fw fa-users me-2"></i>Manajemen User
    </a>
</li>
<li class="nav-item mb-1">
    <a href="{{ route('admin.doctors.index') }}" class="nav-link {{ Request::is('admin/doctors*') ? 'active' : '' }}">
        <i class="fas fa-fw fa-user-md me-2"></i>Dokter
    </a>
</li>
<li class="nav-item mb-1">
    <a href="{{ route('admin.patients.index') }}" class="nav-link {{ Request::is('admin/patients*') ? 'active' : '' }}">
        <i class="fas fa-fw fa-procedures me-2"></i>Pasien
    </a>
</li>
<li class="nav-item mb-1">
    <a href="{{ route('admin.medicines.index') }}"
        class="nav-link {{ Request::is('admin/medicines*') ? 'active' : '' }}">
        <i class="fas fa-fw fa-pills me-2"></i>Manajemen Obat
    </a>
</li>
<li class="nav-item mb-1">
    <a href="{{ route('admin.appointments.index') }}"
        class="nav-link {{ Request::is('admin/appointments*') ? 'active' : '' }}">
        <i class="fas fa-fw fa-calendar-check me-2"></i>Jadwal Kunjungan
    </a>
</li>

<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ Request::is('admin/rooms*') || Request::is('admin/inpatients*') ? '' : 'collapsed' }}"
        href="#rawatInapSubmenu" data-bs-toggle="collapse" role="button"
        aria-expanded="{{ Request::is('admin/rooms*') || Request::is('admin/inpatients*') ? 'true' : 'false' }}"
        aria-controls="rawatInapSubmenu">
        <span><i class="fas fa-fw fa-hospital me-2"></i>Rawat Inap</span>
        <i class="fas fa-fw fa-chevron-down small"></i>
    </a>
    <div class="collapse {{ Request::is('admin/rooms*') || Request::is('admin/inpatients*') ? 'show' : '' }}"
        id="rawatInapSubmenu">
        <ul class="nav flex-column mt-1">
            <li class="nav-item">
                <a href="{{ route('admin.rooms.index') }}"
                    class="nav-link {{ Request::is('admin/rooms*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-bed me-2"></i>Ruang Rawat Inap
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.inpatients.index') }}"
                    class="nav-link {{ Request::is('admin/inpatients*') ? 'active' : '' }}">
                    <i class="fas fa-fw fa-procedures me-2"></i>Manajemen Rawat Inap
                </a>
            </li>
        </ul>
    </div>
</li>

<style>
    .nav-link {
        color: #adb5bd;
        font-weight: 500;
        font-size: 0.95rem;
        transition: background-color 0.2s, color 0.2s;
        padding: 0.5rem 1rem;
    }

    .nav-link:hover,
    .nav-link:focus {
        background-color: #343a40;
        color: #fff;
        border-radius: 0.375rem;
    }

    .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
        border-radius: 0.375rem;
    }

    .nav-link .fa-fw {
        width: 1.25em;
    }

    .nav-item>.collapse .nav-link {
        padding-left: 2.5rem;
        font-size: 0.9rem;
    }

    .sidebar-heading {
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 0 1rem;
        margin-bottom: 0.75rem;
        color: #6c757d;
        letter-spacing: 0.05em;
    }

    .main-content {
        margin-left: 260px;
        padding: 20px;
    }
</style>
