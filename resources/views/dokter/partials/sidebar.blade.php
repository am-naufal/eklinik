<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/dashboard') ? 'active' : '' }}" href="{{ route('dokter.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/jadwal*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-calendar-alt me-2"></i>
        Jadwal Praktik
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/pasien*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-procedures me-2"></i>
        Pasien Saya
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/rekam-medis*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-clipboard-list me-2"></i>
        Rekam Medis
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/resep*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-pills me-2"></i>
        Resep Obat
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('dokter/profil*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-user me-2"></i>
        Profil Saya
    </a>
</li>
