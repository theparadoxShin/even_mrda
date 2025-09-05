<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Parfait Tedom Tedom">
    <meta name="developer" content="Parfait Tedom Tedom - https://parfaittedomtedom.com">
    <meta name="description" content="@yield('meta-description', 'Chorale MRDA - Ensemble vocal dédié à la musique sacrée à Montreal, QC Canada')">
    <title>@yield('title', 'Chorale MRDA')</title>

    <!-- Favicon et icônes -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/music-theme.css') }}" rel="stylesheet">

    <!-- Global Styles -->
    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #dbeafe;
            --dark-blue: #1e40af;
            --gold: #f59e0b;
            --white: #ffffff;
            --light-gray: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, var(--light-blue) 0%, var(--white) 100%);
            font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.65;
            padding-top: 80px; /* Space for fixed navbar */
            font-weight: 400;
            font-size: 16px;
            color: #2d3748;
        }


        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Main content wrapper */
        .main-content {
            min-height: calc(100vh - 80px);
            position: relative;
        }

        /* Page section styling */
        .page-section {
            padding: 4rem 0;
            position: relative;
        }

        .section-title {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--dark-blue);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-blue), var(--gold));
            border-radius: 2px;
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                transform: translateX(-50%) scaleX(1);
                opacity: 0.8;
            }
            50% {
                transform: translateX(-50%) scaleX(1.2);
                opacity: 1;
                box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
            }
        }

        /* Button styles */
        .btn-musical {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
        }

        .btn-musical::before {
            content: '→';
            position: absolute;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            transition: all 0.4s ease;
            font-weight: 600;
        }

        .btn-musical:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.4);
            color: white;
        }

        .btn-musical:hover::before {
            left: 12px;
        }

        /* Card animations */
        .card-animate {
            transition: all 0.3s ease;
        }

        .card-animate:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        /* Loading animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-blue);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: opacity 0.5s ease;
        }

        .loading-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loading-musical-icon {
            font-size: 6rem;
            color: var(--gold);
            animation: musicBounce 1.5s ease-in-out infinite;
            margin-bottom: 1rem;
        }

        @keyframes musicBounce {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            25% {
                transform: translateY(-20px) rotate(-10deg);
                opacity: 0.8;
            }
            50% {
                transform: translateY(-30px) rotate(0deg);
                opacity: 0.9;
            }
            75% {
                transform: translateY(-20px) rotate(10deg);
                opacity: 0.8;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }

            .section-title {
                font-size: 2rem;
            }

            .page-section {
                padding: 2rem 0;
            }
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
            transform: translateY(-2px);
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

        /* Styles spécifiques pour les pages register et payment */
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><path d="M0,50 Q250,100 500,50 T1000,50 V100 H0 Z"/></svg>');
            background-size: cover;
            background-position: bottom;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .hero-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        /* Animation pour les éléments du formulaire */
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            transform: translateY(-2px);
        }

        .form-label i {
            color: var(--primary-blue);
            margin-right: 5px;
        }

        /* Styles pour les icônes d'information */
        .info-icon {
            background: var(--light-blue);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: var(--primary-blue);
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .info-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }

        /* Styles pour la section paiement */
        .payment-section {
            transition: all 0.3s ease;
        }

        .payment-method i {
            color: var(--primary-blue);
            transition: all 0.3s ease;
        }

        .payment-method:hover i,
        .payment-method.selected i {
            color: var(--white);
        }

        /* Styles pour les éléments Stripe */
        .StripeElement {
            box-sizing: border-box;
            height: 45px;
            padding: 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .StripeElement--invalid {
            border-color: #dc3545;
        }

        /* Animation de chargement pour le bouton de paiement */
        .btn-primary-custom:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Styles pour les alertes de succès */
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 1px solid #b8daff;
            border-radius: 10px;
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border: 1px solid #f5c6cb;
            border-radius: 10px;
            color: #721c24;
        }

        /* Styles pour les modales */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .modal-body {
            padding: 3rem;
        }

        /* Animation pour les icônes de succès */
        .fa-check-circle {
            animation: successPulse 1.5s ease-in-out;
        }

        @keyframes successPulse {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive pour les pages register et payment */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .hero-section {
                padding: 40px 0;
            }

            .price-highlight {
                font-size: 1.5rem;
            }

            .payment-methods {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .payment-method {
                width: 100%;
                max-width: 200px;
            }
        }


    </style>

    @stack('styles')
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center text-white">
            <i class="fas fa-music loading-musical-icon" style="font-size: 5rem"></i>
            <p class="mt-3 h4">Chargement...</p>
        </div>
    </div>

    <!-- Header Component -->
    @include('components.header')

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Global JavaScript -->
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });

            // Hide loading overlay
            setTimeout(function() {
                const loadingOverlay = document.getElementById('loadingOverlay');
                loadingOverlay.classList.add('hidden');
                setTimeout(() => loadingOverlay.remove(), 500);
            }, 1000);

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offsetTop = target.offsetTop - 100;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Auto-hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    if (alert && typeof bootstrap !== 'undefined') {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                });
            }, 5000);

        });

    </script>

    @stack('scripts')
</body>
</html>
