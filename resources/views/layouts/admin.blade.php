<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Chorale App')</title>

    <!-- Favicon et icônes -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #dbeafe;
            --dark-blue: #1e40af;
            --white: #ffffff;
            --light-gray: #f8fafc;
        }

        body {
            background-color: var(--light-gray);
            font-family: 'Arial', sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.2);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--white) !important;
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            color: var(--white) !important;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
            color: var(--white) !important;
        }

        .badge-custom {
            border-radius: 15px;
            padding: 5px 12px;
            font-weight: 600;
        }

        .badge-paid {
            background-color: #10b981;
            color: white;
        }

        .badge-unpaid {
            background-color: #ef4444;
            color: white;
        }

        .qr-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--white) 0%, var(--light-blue) 100%);
            border-left: 4px solid var(--primary-blue);
        }

        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-custom th {
            background-color: var(--primary-blue);
            color: var(--white);
            border: none;
            font-weight: 600;
        }

        .modal-header-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: var(--white);
            border-radius: 15px 15px 0 0;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: var(--white);
            padding: 15px 20px;
            margin: 5px 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: var(--white);
            transform: translateX(5px);
        }

        .main-content {
            padding: 30px;
        }

        @media (max-width: 768px) {
            .qr-actions {
                justify-content: center;
            }

            .main-content {
                padding: 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
           <img src="{{ asset('logo.png') }}" alt="Chorale MRDA Logo" class="d-inline-block align-text-top img-fluid" style="height: 40px; background: white">
            <i class="fas fa-music me-2"></i>Admin MRDA
        </a>
        <div class="navbar-nav ms-auto">
            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light">
                    <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@stack('scripts')
</body>
</html>
