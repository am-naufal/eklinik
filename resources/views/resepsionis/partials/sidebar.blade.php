<li class="nav-item {{ Request::is('resepsionis/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('resepsionis.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">


<!-- Nav Item - Pasien -->
<li class="nav-item {{ Request::is('resepsionis/patients*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('resepsionis.patients.index') }}">
        <i class="fas fa-fw fa-users"></i>
        <span>Manajemen Pasien</span>
    </a>
</li>

<!-- Nav Item - Kunjungan -->
<li class="nav-item {{ Request::is('resepsionis/appointments*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('resepsionis.appointments.index') }}">
        <i class="fas fa-fw fa-calendar-check"></i>
        <span>Jadwal Kunjungan</span>
    </a>
</li>

<!-- Nav Item - Nota Penanganan -->
<li class="nav-item {{ Request::is('resepsionis/invoices*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('resepsionis.invoices.index') }}">
        <i class="fas fa-fw fa-file-invoice-dollar"></i>
        <span>Nota Penanganan</span>
    </a>
</li>

<!-- Nav Item - Rawat Inap -->
<li class="nav-item {{ Request::is('resepsionis/inpatients*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('resepsionis.inpatients.index') }}">
        <i class="fas fa-fw fa-bed"></i>
        <span>Manajemen Rawat Inap</span>
    </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
