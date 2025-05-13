<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Klinik')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #4e73df;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 16px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            font-weight: bold;
            color: white;
        }

        .sidebar .sidebar-brand {
            padding: 20px;
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .topbar {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4>E-Klinik</h4>
        </div>

        <ul class="nav flex-column">
            @if (Auth::user()->hasRole('admin'))
                @include('admin.partials.sidebar')
            @elseif(Auth::user()->hasRole('dokter'))
                @include('dokter.partials.sidebar')
            @elseif(Auth::user()->hasRole('pasien'))
                @include('pasien.partials.sidebar')
            @elseif(Auth::user()->hasRole('resepsionis'))
                @include('resepsionis.partials.sidebar')
            @elseif(Auth::user()->hasRole('pemilik_klinik'))
                @include('pemilik.partials.sidebar')
            @endif
        </ul>
    </div>

    <div class="content">
        <div class="topbar">
            <div>
                <h4>@yield('page-title', 'Dashboard')</h4>
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a class="text-dark dropdown-toggle text-decoration-none" href="#" role="button"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-fw fa-2x me-2"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid py-4">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
