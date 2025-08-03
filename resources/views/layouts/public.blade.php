<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Parfait Tedom Tedom">
    <meta name="developer" content="Parfait Tedom Tedom - https://parfaittedomtedom.com">
    <meta name="description" content="Application de gestion d'événements de chorales développées par Parfait Tedom Tedom">
    <title>@yield('title', 'Chorale App')</title>

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
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--white) 100%);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: var(--white);
            padding: 60px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
            background-size: 50px 50px;
        }

        .card-form {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            background: var(--white);
            position: relative;
            z-index: 2;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            color: var(--white) !important;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            color: var(--white) !important;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 8px;
        }

        .event-info {
            background: var(--light-blue);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: 2px solid var(--primary-blue);
        }

        .price-highlight {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-blue);
        }

        .icon-wrapper {
            background: var(--primary-blue);
            color: var(--white);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.5rem;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .payment-method {
            background: var(--white);
            border: 2px solid var(--primary-blue);
            border-radius: 10px;
            padding: 15px 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            min-width: 120px;
        }

        .payment-method:hover,
        .payment-method.selected {
            background: var(--primary-blue);
            color: var(--white);
            transform: translateY(-5px);
        }

        .spinner-border-custom {
            color: var(--primary-blue);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 0;
            }

            .card-form {
                padding: 25px;
                margin: 15px;
            }

            .payment-methods {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="hero-section">
    <div class="container">
        <div class="icon-wrapper" style="background: white;">
            <img src="{{ asset('logo.png') }}" alt="Chorale App Logo" class="img-fluid" style="width: 40px; height: 40px;">
        </div>
        <h1 class="display-4 fw-bold mb-3">@yield('hero-title', 'Chorale App')</h1>
        <p class="lead">@yield('hero-subtitle', 'Inscription aux événements')</p>
    </div>
</div>

<div class="container my-5">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
