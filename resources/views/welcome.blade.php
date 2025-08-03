<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Chorale MRDA</title>
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
            padding: 100px 0;
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

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--white) !important;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
            color: var(--white) !important;
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            background: transparent;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: var(--white) !important;
            transform: scale(1.05);
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background: var(--white);
        }

        .card-custom:hover {
            transform: translateY(-10px);
        }

        .icon-wrapper {
            background: var(--primary-blue);
            color: var(--white);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
        }

        .stats-section {
            background: var(--white);
            padding: 80px 0;
        }

        .feature-card {
            text-align: center;
            padding: 40px 20px;
            height: 100%;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--primary-blue) !important;
        }

        .nav-link {
            color: var(--primary-blue) !important;
            font-weight: 500;
            margin: 0 10px;
        }

        .nav-link:hover {
            color: var(--dark-blue) !important;
        }

        .event-card {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .price-tag {
            background: var(--primary-blue);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }

            .hero-section h1 {
                font-size: 2rem;
            }
        }

        .developer-section {
            border-left: 3px solid #ffc107;
        }

        .developer-section a:hover {
            color: #ffc107 !important;
            transform: scale(1.02);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: #ffc107 !important;
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }

    </style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" alt="Chorale MRDA" class="d-inline-block align-text-top" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#events">Événements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary-custom ms-2" href="{{ route('admin.login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <div class="icon-wrapper" style="width: 120px; height: 120px; font-size: 3rem; margin-bottom: 30px;">
                <i class="fas fa-music"></i>
            </div>
            <h1 class="display-3 fw-bold mb-4">Chorale Marie Reine des Apôtres</h1>
            <p class="lead mb-5">
                Découvrez la passion du chant choral et participez à nos événements exceptionnels.
                Une communauté musicale qui vous attend !
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="#events" class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-calendar-alt me-2"></i>Voir les événements
                </a>
                <a href="#about" class="btn btn-outline-custom btn-lg">
                    <i class="fas fa-info-circle me-2"></i>En savoir plus
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="icon-wrapper">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h3 class="fw-bold text-primary">{{ $stats['total_events'] }}+</h3>
                <p class="text-muted">Événements organisés</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="icon-wrapper">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="fw-bold text-primary">{{ $stats['total_participants'] }}+</h3>
                <p class="text-muted">Participants satisfaits</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="icon-wrapper">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="fw-bold text-primary">{{ $stats['years_experience'] }}+</h3>
                <p class="text-muted">Années d'expérience</p>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section id="events" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary">Prochains Événements</h2>
            <p class="lead text-muted">Découvrez nos événements à venir et inscrivez-vous dès maintenant</p>
        </div>

        @if($upcomingEvents->count() > 0)
            <div class="row">
                @foreach($upcomingEvents as $event)
                    <div class="col-lg-4 mb-4">
                        <div class="event-card">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="fw-bold text-primary">{{ $event->name }}</h4>
                                <span class="price-tag">${{ number_format($event->price, 2) }}</span>
                            </div>

                            <p class="text-muted mb-3">{{ Str::limit($event->description, 100) }}</p>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar text-primary me-2"></i>
                                    <span>{{ $event->event_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <span>{{ $event->event_date->format('H:i') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('event.register', $event) }}"
                               class="btn btn-primary-custom w-100">
                                <i class="fas fa-ticket-alt me-2"></i>S'inscrire maintenant
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="icon-wrapper" style="margin-bottom: 30px;">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h4 class="text-muted">Aucun événement programmé</h4>
                <p class="text-muted">De nouveaux événements seront bientôt annoncés !</p>
            </div>
        @endif
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold text-primary mb-4">À propos de notre Chorale</h2>
                <p class="lead mb-4">
                    Depuis {{ 2017 }}, notre chorale rassemble des passionnés de musique de tous niveaux.
                    Nous organisons régulièrement des concerts, des spectacles et des événements musicaux.
                </p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Tous niveaux acceptés</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Événements réguliers</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Ambiance conviviale</span>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <span>Répertoire varié</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="icon-wrapper" style="width: 200px; height: 200px; font-size: 5rem; margin-bottom: 30px;">
                        <i class="fas fa-microphone-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary">Pourquoi nous choisir ?</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card-custom feature-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4 class="fw-bold text-primary">Inscription facile</h4>
                    <p class="text-muted">
                        Inscrivez-vous en ligne facilement avec notre système de QR codes
                        pour une expérience fluide et moderne.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card-custom feature-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="fw-bold text-primary">Paiement sécurisé</h4>
                    <p class="text-muted">
                        Payez en toute sécurité avec Stripe. Cartes bancaires et
                        virements Interac acceptés.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card-custom feature-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h4 class="fw-bold text-primary">Notifications</h4>
                    <p class="text-muted">
                        Recevez vos confirmations par email avec QR code et
                        rappels automatiques avant les événements.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Nous contacter</h2>
        <p class="lead mb-4">Une question ? N'hésitez pas à nous contacter !</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <i class="fas fa-envelope fa-2x mb-2"></i>
                        <div>contact@chorale.com</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fas fa-phone fa-2x mb-2"></i>
                        <div>(514) 123-4567</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                        <div>Montréal, QC</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 text-center">
                <h5 class="fw-bold mb-3">
                    <img src="{{ asset('logo.png') }}" alt="Chorale MRDA" class="d-inline-block align-text-top" style="height: 100px;">
                </h5>
                <p class="text-muted">
                    Plateforme moderne de gestion d'événements chorals avec
                    paiements sécurisés et QR codes.
                </p>
                <div class="social-links">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <div class="col-lg-4 mb-4 ">
                <h5 class="fw-bold mb-3">Contact</h5>
                <div class="contact-info">
                    <p class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        contact@chorale.com
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        (514) 123-4567
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Montréal, QC, Canada
                    </p>
                </div>
            </div>

            <div class="col-lg-4 mb-4 text-center">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-code me-2"></i>Développement
                </h5>
                <div class="developer-section p-3 rounded" style="background: rgba(255, 255, 255, 0.05);">
                    <p class="text-muted mb-2">Application créée par :</p>
                    <a href="https://parfaittedomtedom.com" target="_blank"
                       class="text-white text-decoration-none d-block mb-2">
                        <strong class="fs-5">Parfait Tedom Tedom ( Développeur Web Senior , Baryton Basse à MRDA )</strong>
                    </a>
                    <a href="https://parfaittedomtedom.com" target="_blank"
                       class="btn btn-outline-light btn-sm">
                        <i class="fas fa-globe me-1"></i>
                        parfaittedomtedom.com
                    </a>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Développement professionnel & sécurisé
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4 opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; {{ date('Y') }} Chorale App. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-muted">
                    Développé avec ❤️ par
                    <a href="https://parfaittedomtedom.com" target="_blank" class="text-white">
                        Parfait Tedom Tedom
                    </a>
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Smooth scrolling pour les liens d'ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Navbar transparence au scroll
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar-custom');
        if (window.scrollY > 50) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
        }
    });
</script>
</body>
</html>
