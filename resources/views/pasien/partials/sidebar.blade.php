<li class="nav-item">
    <a class="nav-link {{ Request::is('pasien/dashboard') ? 'active' : '' }}" href="{{ route('pasien.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt me-2"></i>
        Dashboard
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('pasien/jadwal*') ? 'active' : '' }}"
        href="{{ route('pasien.appointments.index') }}">
        <i class="fas fa-fw fa-calendar-alt me-2"></i>
        Jadwal Kunjungan
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('pasien/dokter*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-user-md me-2"></i>
        Dokter
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('pasien/rekam-medis*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-clipboard-list me-2"></i>
        Rekam Medis Saya
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('pasien/pembayaran*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-credit-card me-2"></i>
        Pembayaran
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('pasien/profil*') ? 'active' : '' }}" href="#">
        <i class="fas fa-fw fa-user me-2"></i>
        Profil Saya
    </a>
</li>
