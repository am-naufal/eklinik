<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
        <i class="fas fa-fw fa-users me-2"></i>
        Manajemen User
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/doctors*') ? 'active' : '' }}" href="{{ route('admin.doctors.index') }}">
        <i class="fas fa-fw fa-user-md me-2"></i>
        Dokter
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/patients*') ? 'active' : '' }}" href="{{ route('admin.patients.index') }}">
        <i class="fas fa-fw fa-procedures me-2"></i>
        Pasien
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('admin/appointments*') ? 'active' : '' }}"
        href="{{ route('admin.appointments.index') }}">
        <i class="fas fa-fw fa-calendar-check me-2"></i>
        Jadwal Kunjungan
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-cog me-2"></i>
        Pengaturan
    </a>
</li>
