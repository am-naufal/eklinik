<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Klinik - Solusi Kesehatan Modern</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary: #10b981;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 1px solid var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Hero Section */
        .hero {
            padding: 6rem 0 4rem;
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('https://images.unsplash.com/photo-1631815588090-d4bfec5b7e2e?q=80&w=1200');
            background-size: cover;
            background-position: center;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: var(--dark);
        }

        .hero-text p {
            font-size: 1.125rem;
            color: var(--gray);
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
        }

        .hero-image img {
            width: 100%;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.25rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .section-title p {
            font-size: 1.125rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--gray);
        }

        /* Services Section */
        .services {
            padding: 5rem 0;
            background-color: #f1f5f9;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .service-card {
            background-color: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-image {
            height: 200px;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .service-card:hover .service-image img {
            transform: scale(1.05);
        }

        .service-content {
            padding: 1.5rem;
        }

        .service-content h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .service-content p {
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        /* Testimonials */
        .testimonials {
            padding: 5rem 0;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .testimonial-text {
            font-style: italic;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-info h4 {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .author-info p {
            font-size: 0.875rem;
            color: var(--gray);
        }

        /* CTA Section */
        .cta {
            padding: 5rem 0;
            background-color: var(--primary);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.25rem;
            margin-bottom: 1.5rem;
        }

        .cta p {
            font-size: 1.125rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-light {
            background-color: white;
            color: var(--primary);
            border: 1px solid white;
        }

        .btn-light:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-column h3 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -0.5rem;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 0.75rem;
        }

        .footer-column ul li a {
            color: var(--gray-light);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transition: background-color 0.3s;
        }

        .social-links a:hover {
            background-color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.875rem;
            color: var(--gray-light);
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
        }

        @media (max-width: 992px) {

            .nav-links,
            .auth-buttons {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }
        }

        /* Mobile Nav (Hidden by default) */
        .mobile-nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            z-index: 200;
            padding: 2rem;
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .mobile-nav.active {
            transform: translateX(0);
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .close-menu {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-nav-links {
            list-style: none;
        }

        .mobile-nav-links li {
            margin-bottom: 1.5rem;
        }

        .mobile-nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-size: 1.25rem;
            font-weight: 500;
        }

        .mobile-auth-buttons {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">
                    <i class="fas fa-heartbeat"></i> E-Klinik
                </a>
                <ul class="nav-links">
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#services">Layanan</a></li>
                    <li><a href="#testimonials">Testimoni</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
                <div class="auth-buttons">
                    @if (Route::has('login'))
                        @auth
                            @if (Auth::user()->hasRole('dokter'))
                                <a href="{{ route('dokter.dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @elseif (Auth::user()->hasRole('pasien'))
                                <a href="{{ route('pasien.dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @elseif (Auth::user()->hasRole('resepsionis'))
                                <a href="{{ route('resepsionis.dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @elseif (Auth::user()->hasRole('pemilik_klinik'))
                                <a href="{{ route('pemilik.dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>
        </div>
    </header>

    <!-- Mobile Nav -->
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <a href="#" class="logo">
                <i class="fas fa-heartbeat"></i> E-Klinik
            </a>
            <button class="close-menu" id="closeMenu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="#">Beranda</a></li>
            <li><a href="#features">Fitur</a></li>
            <li><a href="#services">Layanan</a></li>
            <li><a href="#testimonials">Testimoni</a></li>
            <li><a href="#contact">Kontak</a></li>
        </ul>
        <div class="mobile-auth-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Solusi Kesehatan Modern untuk Keluarga Anda</h1>
                    <p>E-Klinik menyediakan layanan kesehatan digital terpadu dengan dokter terbaik dan teknologi
                        canggih untuk memberikan pelayanan kesehatan terbaik bagi Anda.</p>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Mulai Sekarang</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
                    @endif
                </div>
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=880&auto=format&fit=crop"
                        alt="E-Klinik">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Fitur Unggulan Kami</h2>
                <p>E-Klinik dilengkapi dengan berbagai fitur canggih untuk memudahkan Anda mendapatkan layanan kesehatan
                    terbaik.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Jadwal Konsultasi Online</h3>
                    <p>Buat janji dengan dokter pilihan Anda kapan saja dan di mana saja tanpa perlu antre di klinik.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-comment-medical"></i>
                    </div>
                    <h3>Konsultasi Digital</h3>
                    <p>Konsultasikan masalah kesehatan Anda dengan dokter ahli melalui chat, panggilan suara, atau
                        video.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-pills"></i>
                    </div>
                    <h3>Riwayat Medis Digital</h3>
                    <p>Akses riwayat medis, resep obat, dan hasil lab Anda kapan saja melalui aplikasi E-Klinik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Kami</h2>
                <p>E-Klinik menyediakan berbagai layanan kesehatan untuk memenuhi kebutuhan Anda dan keluarga.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1631815588090-d4bfec5b7e2e?q=80&w=720&auto=format&fit=crop"
                            alt="Pemeriksaan Umum">
                    </div>
                    <div class="service-content">
                        <h3>Pemeriksaan Umum</h3>
                        <p>Layanan pemeriksaan kesehatan umum untuk mendiagnosis dan menangani masalah kesehatan dasar.
                        </p>
                        <a href="#" class="btn btn-outline">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1579684453377-12daf42fd104?q=80&w=720&auto=format&fit=crop"
                            alt="Kesehatan Anak">
                    </div>
                    <div class="service-content">
                        <h3>Kesehatan Anak</h3>
                        <p>Layanan kesehatan khusus untuk anak, termasuk imunisasi, pemeriksaan tumbuh kembang, dan
                            pengobatan.</p>
                        <a href="#" class="btn btn-outline">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-image">
                        <img src="https://images.unsplash.com/photo-1616434221434-df1062b87d13?q=80&w=720&auto=format&fit=crop"
                            alt="Dokter Spesialis">
                    </div>
                    <div class="service-content">
                        <h3>Dokter Spesialis</h3>
                        <p>Konsultasi dengan dokter spesialis berpengalaman untuk kondisi kesehatan khusus yang Anda
                            alami.</p>
                        <a href="#" class="btn btn-outline">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Kata Mereka Tentang Kami</h2>
                <p>Apa kata pasien kami tentang pengalaman menggunakan layanan E-Klinik.</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "E-Klinik sangat membantu saya dalam berkonsultasi dengan dokter tanpa perlu keluar rumah.
                        Aplikasi yang mudah digunakan dan dokter yang profesional."
                    </div>
                    <div class="testimonial-author">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Siti Nurhaliza">
                        <div class="author-info">
                            <h4>Siti Nurhaliza</h4>
                            <p>Ibu Rumah Tangga</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Sebagai seorang yang sibuk, E-Klinik adalah solusi terbaik untuk tetap menjaga kesehatan. Fitur
                        reservasi online sangat efisien dan menghemat waktu."
                    </div>
                    <div class="testimonial-author">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Andi Firmansyah">
                        <div class="author-info">
                            <h4>Andi Firmansyah</h4>
                            <p>Pengusaha</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Sistem rekam medis digital di E-Klinik sangat membantu. Saya bisa dengan mudah mengakses
                        riwayat kesehatan anak-anak saya kapan saja."
                    </div>
                    <div class="testimonial-author">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Dewi Lestari">
                        <div class="author-info">
                            <h4>Dewi Lestari</h4>
                            <p>Guru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Mulai Jaga Kesehatan Anda Sekarang</h2>
            <p>Daftar dan nikmati kemudahan mendapatkan layanan kesehatan terbaik untuk Anda dan keluarga.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-light">Daftar Sekarang</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light">Masuk Sekarang</a>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>E-Klinik</h3>
                    <p>Solusi kesehatan modern untuk keluarga Indonesia. Memberikan layanan kesehatan terbaik dengan
                        teknologi digital terdepan.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Layanan</h3>
                    <ul>
                        <li><a href="#">Pemeriksaan Umum</a></li>
                        <li><a href="#">Kesehatan Anak</a></li>
                        <li><a href="#">Dokter Spesialis</a></li>
                        <li><a href="#">Laboratorium</a></li>
                        <li><a href="#">Farmasi</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Tautan</h3>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#services">Layanan</a></li>
                        <li><a href="#testimonials">Testimoni</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Kontak</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Jl. Kesehatan No. 123, Jakarta</li>
                        <li><i class="fas fa-phone"></i> (021) 1234-5678</li>
                        <li><i class="fas fa-envelope"></i> info@eklinik.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} E-Klinik. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile Menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMenu = document.getElementById('closeMenu');
        const mobileNav = document.getElementById('mobileNav');

        mobileMenuBtn.addEventListener('click', function() {
            mobileNav.classList.add('active');
        });

        closeMenu.addEventListener('click', function() {
            mobileNav.classList.remove('active');
        });

        // Close mobile menu when clicking on links
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-links a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileNav.classList.remove('active');
            });
        });
    </script>
</body>

</html>
