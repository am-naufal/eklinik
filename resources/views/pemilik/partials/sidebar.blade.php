<li class="nav-item {{ Request::is('pemilik/dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pemilik.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Laporan
</div>

<!-- Nav Item - Reports Menu -->
<li class="nav-item {{ Request::is('pemilik/reports*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pemilik.reports.index') }}">
        <i class="fas fa-fw fa-chart-bar me-2"></i>
        Laporan
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
