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

        /* Global animations */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
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
    </style>

    @stack('styles')
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center text-white">
            <i class="fas fa-music loading-musical-icon" style="font-size: 155px"></i>
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

            // Add fade-in class to body for smooth page transitions
            document.body.classList.add('fade-in');
        });

        // Page transition effects
        window.addEventListener('beforeunload', function() {
            document.body.style.opacity = '0.7';
            document.body.style.transform = 'scale(0.98)';
        });
    </script>

    @stack('scripts')
</body>
</html>
