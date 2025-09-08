@extends('layouts.public')

@section('title', app()->getLocale() == 'fr' ? 'Accueil - Chorale MRDA' : 'Home - MRDA Choir')
@section('meta-description', 'Chorale MRDA - Accueil - Ensemble vocal dédié à la musique sacrée à Montreal, QC Canada')

@push('styles')

<style>
    /* Corrections pour éliminer l'espace blanc mobile */
    * {
        box-sizing: border-box;
    }

    html, body {
        overflow-x: hidden;
        max-width: 100vw;
    }

    /* Additional container constraints */
    .row {
        margin-left: 0;
        margin-right: 0;
        max-width: 100%;
    }

    .col, [class*="col-"] {
        padding-left: 12px;
        padding-right: 12px;
        max-width: 100%;
    }

    /* Prevent any element from exceeding viewport */
    .container, .container-fluid, .row, .col {
        max-width: 100vw;
    }

    /* Carrousel héro avec animations musicales */
    .hero-carousel {
        height: 80vh;
        position: relative;
        overflow: hidden;
        margin-top: -80px; /* Compensate for navbar padding */
        max-width: 100vw;
    }

    .carousel-item {
        height: 80vh;
        position: relative;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        max-width: 100vw;
        overflow: hidden;
    }

    .carousel-item.active {
        opacity: 1;
    }

    .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .carousel-item.active img {
        animation: kenBurns 4s ease-in-out;
    }

    @keyframes kenBurns {
        0% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .carousel-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(37, 99, 235, 0.7), rgba(30, 64, 175, 0.5));
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-content {
        text-align: center;
        color: white;
        z-index: 2;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.8s ease-out;
        max-width: 100%;
        padding: 0 20px;
    }

    .carousel-item.active .carousel-content {
        transform: translateY(0);
        opacity: 1;
        transition-delay: 0.3s;
    }

    .carousel-content h1 {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.6s ease-out;
    }

    .carousel-item.active .carousel-content h1 {
        transform: translateY(0);
        opacity: 1;
        transition-delay: 0.5s;
        animation: textGlow 3s ease-in-out infinite alternate;
    }

    @keyframes textGlow {
        0% { text-shadow: 2px 2px 4px rgba(0,0,0,0.5), 0 0 10px rgba(245, 158, 11, 0.3); }
        100% { text-shadow: 2px 2px 4px rgba(0,0,0,0.5), 0 0 20px rgba(245, 158, 11, 0.6); }
    }

    .carousel-content p {
        font-size: 1.3rem;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.6s ease-out;
    }

    .carousel-item.active .carousel-content p {
        transform: translateY(0);
        opacity: 1;
        transition-delay: 0.7s;
    }

    /* Animation pour les boutons du slider */
    .slide-btn {
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.6s ease-out;
    }

    .carousel-item.active .slide-btn {
        transform: translateY(0);
        opacity: 1;
        transition-delay: 0.9s;
    }

    /* Cartes d'événements avec animations */
    .event-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        border-left: 5px solid var(--gold);
        position: relative;
        overflow: hidden;
    }

    .event-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(245, 158, 11, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .event-card:hover {
        transform: translateY(-15px) rotateX(5deg);
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    }

    .event-card:hover::before {
        left: 100%;
    }

    /* Statistiques animées */
    .stats-section {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        padding: 60px 0;
        position: relative;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float 20s infinite linear;
    }

    /* Icon wrappers and feature cards */
    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .icon-wrapper:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }

    .icon-wrapper i {
        position: relative;
        z-index: 2;
        width: 1.5rem;
        height: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .feature-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    /* Centered sections */
    .stats-section .container,
    .page-section .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-section .row,
    .page-section .row {
        align-items: center;
        justify-content: center;
    }

    .text-center {
        text-align: center !important;
    }

    .mx-auto {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .carousel-content h1 {
            font-size: 2rem;
        }

        .carousel-content p {
            font-size: 1.1rem;
        }

        .slide-btn {
            font-size: 0.9rem;
            padding: 10px 20px;
        }

        .hero-carousel, .carousel-item {
            height: 60vh;
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .carousel-content h1 {
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .carousel-content p {
            font-size: 1rem;
            margin-bottom: 25px;
            padding: 0 10px;
        }

        .slide-btn {
            font-size: 0.85rem;
            padding: 8px 16px;
        }

        .hero-carousel, .carousel-item {
            height: 50vh;
        }

    }

    /* Gallery Scroll Styles */
    .gallery-scroll-section {
        background: linear-gradient(135deg, var(--light-blue) 0%, var(--white) 100%);
        border-radius: 20px;
        margin: 2rem 0;
        padding: 3rem 0;
        overflow: hidden;
        width: 100%;
        max-width: 100vw;
    }

    .gallery-scroll-container {
        width: 100%;
        overflow: hidden;
        position: relative;
        margin: 2rem 0;
        max-width: 100vw;
    }

    .gallery-scroll-track {
        display: flex;
        gap: 20px;
        animation: scrollLeft 30s linear infinite;
        width: fit-content;
    }

    .gallery-scroll-image {
        width: 280px;
        height: 200px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        flex-shrink: 0;
    }

    .gallery-scroll-image:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 12px 35px rgba(0,0,0,0.25);
    }

    @keyframes scrollLeft {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .gallery-scroll-container:hover .gallery-scroll-track {
        animation-play-state: paused;
    }

    /* Responsive Gallery Scroll */
    @media (max-width: 768px) {
        .gallery-scroll-image {
            width: 220px;
            height: 160px;
        }

        .gallery-scroll-track {
            gap: 15px;
        }
    }

    @media (max-width: 480px) {
        .gallery-scroll-image {
            width: 180px;
            height: 130px;
        }

        .gallery-scroll-track {
            gap: 10px;
        }

        .gallery-scroll-section {
            padding: 2rem 0;
        }

        .events-grid-home {
            grid-template-columns: 1fr;
            gap: 20px;
            max-width: 100%;
            padding: 0 15px;
        }

        .events-grid-home.two-events {
            grid-template-columns: 1fr;
            max-width: 100%;
        }

        .event-actions-home {
            flex-direction: column;
        }

        .hero-carousel, .carousel-item {
            max-width: 100vw;
        }

        .carousel-content {
            padding: 0 15px;
        }

        .gallery-scroll-section {
            padding: 2rem 10px;
            margin: 1rem 0;
        }

        /* Modal fixes for mobile */
        .modal-dialog {
            max-width: 95vw;
            margin: 10px;
        }

        .modal-content {
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Container fixes */
        .container, .container-fluid {
            max-width: 100vw;
            overflow-x: hidden;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Image constraints */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Text and heading constraints */
        h1, h2, h3, h4, h5, h6, p {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    }

    /* Events Section Styles - Modern Design */
    .events-grid-home {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 30px;
        max-width: 1100px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
    }

    .events-grid-home.single-event {
        grid-template-columns: 1fr;
        max-width: 450px;
        justify-items: center;
    }

    .events-grid-home.two-events {
        grid-template-columns: repeat(2, 1fr);
        max-width: 750px;
    }

    .event-card-home {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        border-left: 4px solid var(--primary-blue);
        cursor: pointer;
        width: 100%;
        max-width: 350px;
    }

    .event-card-home:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .event-status-home {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 3;
    }

    .event-status-home.upcoming {
        background: #10b981;
        color: white;
    }

    .event-date-home {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        text-align: center;
        padding: 15px;
        position: relative;
    }

    .event-day-home {
        font-size: 1.6rem;
        font-weight: bold;
        line-height: 1;
    }

    .event-month-home {
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-top: 5px;
    }

    .event-content-home {
        padding: 20px;
    }

    .event-title-home {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 12px;
    }

    .event-meta-home {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .event-meta-item-home {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .event-description-home {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .event-price-home {
        background: var(--gold);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 20px;
    }

    .event-actions-home {
        display: flex;
        gap: 10px;
    }

    .btn-register-home {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        flex: 1;
        text-align: center;
    }

    .btn-register-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        color: white;
    }

    .btn-details-home {
        background: transparent;
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-details-home:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .modal-body {
        padding: 2rem;
    }

    .event-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .event-description {
        font-size: 1rem;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
    }

    .event-details {
        font-size: 0.9rem;
        color: var(--text-gray);
        margin-bottom: 1rem;
    }

    .close-modal {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0,0,0,0.7);
        color: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Modal styles */
    .event-modal .modal-dialog {
        max-width: 750px;
    }

    .event-modal .modal-content {
        border-radius: 15px;
        border: none;
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        padding: 20px;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .modal-header-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
        background-size: 30px 30px;
        animation: musicNote 3s ease-in-out infinite;
    }

    .modal-date-badge {
        background: var(--gold);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: 10px;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .modal-subtitle {
        opacity: 0.9;
        margin: 8px 0 0;
        position: relative;
        z-index: 2;
        font-size: 0.9rem;
    }

    .modal-body-custom {
        padding: 0;
    }

    .event-details-section {
        padding: 25px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
        width: 100%;
        max-width: 100%;
    }

    .modal-detail-item {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 3px solid var(--primary-blue);
        transition: all 0.3s ease;
    }

    .modal-detail-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .modal-detail-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    .modal-detail-content h6 {
        margin: 0 0 3px;
        color: var(--dark-blue);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .modal-detail-content p {
        margin: 0;
        color: #6b7280;
        font-size: 0.85rem;
    }

    .modal-price-section {
        background: linear-gradient(135deg, var(--gold), #f59e0b);
        color: white;
        padding: 20px;
        text-align: center;
        margin: 20px 0;
        border-radius: 12px;
    }

    .modal-price-amount {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .modal-description {
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        margin: 20px 0;
    }

    .modal-description h5 {
        color: var(--dark-blue);
        margin-bottom: 15px;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .modal-actions {
        padding: 20px 25px;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-modal-register {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-modal-register::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.5s ease;
        transform: translate(-50%, -50%);
    }

    .btn-modal-register:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-modal-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        color: white;
    }

    .btn-modal-close {
        background: transparent;
        border: 2px solid #6b7280;
        color: #6b7280;
        padding: 12px 25px;
        border-radius: 40px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-modal-close:hover {
        background: #6b7280;
        color: white;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
    <!-- Carrousel d'images héro -->
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-indicators">
            @foreach($sliderImages as $index => $image)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @forelse($sliderImages as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('images/' . basename($image->image_path)) }}" alt="{{ $image->title }}">
                    <div class="carousel-overlay">
                        <div class="carousel-content" data-aos="fade-up">
                            <h1>{{ $image->title ?? 'Chorale MRDA' }}</h1>
                            <p>{{ $image->description ?? 'Ensemble vocal dédié à la musique sacrée' }}</p>
                            <a href="{{ route('about.index') }}" class="btn btn-musical btn-lg slide-btn">
                                Découvrir notre histoire
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="carousel-item active">
                    <img src="{{ asset('images/img_choir_02.jpg') }}" alt="Chorale MRDA">
                    <div class="carousel-overlay">
                        <div class="carousel-content" data-aos="fade-up">
                            <h1>Chorale MRDA</h1>
                            <p>Ensemble vocal dédié à la musique sacrée</p>
                            <a href="{{ route('about.index') }}" class="btn btn-musical btn-lg slide-btn">
                                Découvrir notre histoire
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/img_choir_03.jpg') }}" alt="Concert de la Chorale">
                    <div class="carousel-overlay">
                        <div class="carousel-content" data-aos="fade-up">
                            <h1>Nos Concerts</h1>
                            <p>Des performances qui touchent le cœur et l'âme</p>
                            <a href="{{ route('gallery.index') }}" class="btn btn-musical btn-lg slide-btn">
                                Voir la galerie
                            </a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/img_choir_008.jpg') }}" alt="Répétitions">
                    <div class="carousel-overlay">
                        <div class="carousel-content" data-aos="fade-up">
                            <h1>Rejoignez-Nous</h1>
                            <p>Partagez votre passion pour la musique sacrée</p>
                            <a href="{{ route('music.index') }}" class="btn btn-musical btn-lg slide-btn">
                                Écouter nos œuvres
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <button class="carousel-control-prev" type="button" id="prevBtn">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" id="nextBtn">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <div class="icon-wrapper">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="fw-bold">{{ $stats['total_events'] }}+</h3>
                    <p>Événements</p>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="fw-bold">{{ $stats['member'] }}+</h3>
                    <p>Membres</p>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="fw-bold">{{ $stats['years_experience'] }}+</h3>
                    <p>Années d'expérience</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Scroll Section -->
    <section class="gallery-scroll-section page-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Des voix gracieuses</h2>

            <div class="gallery-scroll-container" data-aos="fade-up">
                <div class="gallery-scroll-track">
                    <img src="{{ asset('images/img_choir_01.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_02.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_03.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_04.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_05.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_06.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_07.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                    <img src="{{ asset('images/img_choir_008.jpg') }}" alt="Voix gracieuses" class="gallery-scroll-image">
                </div>
            </div>

            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('gallery.index') }}" class="btn btn-musical btn-lg">
                    <i class="fas fa-images me-2"></i>Voir toute la galerie
                </a>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="page-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Événements à venir</h2>

            @if($upcomingEvents->count() > 0)
                <div class="events-grid-home @if($upcomingEvents->count() == 1) single-event @elseif($upcomingEvents->count() == 2) two-events @endif">
                    @foreach($upcomingEvents as $index => $event)
                        <div class="event-card-home" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" data-event-id="{{ $event->id }}" onclick="openEventModal({{ $event->id }})">
                            <div class="event-status-home upcoming">À venir</div>
                            <div class="event-date-home">
                                <div class="event-day-home">{{ $event->event_date->format('d') }}</div>
                                <div class="event-month-home">{{ $event->event_date->format('M Y') }}</div>
                            </div>
                            <div class="event-content-home">
                                <h3 class="event-title-home">{{ $event->name }}</h3>
                                <div class="event-meta-home">
                                    <div class="event-meta-item-home">
                                        <i class="fas fa-clock"></i>
                                        {{ $event->event_date->format('H:i') }}
                                    </div>
                                    <div class="event-meta-item-home">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $event->location ?? 'À définir' }}
                                    </div>
                                </div>
                                <p class="event-description-home">{{ Str::limit($event->description, 120) }}</p>
                                @if($event->price > 0)
                                    <div class="event-price-home">${{ number_format($event->price, 2) }}</div>
                                @else
                                    <div class="event-price-home">Gratuit</div>
                                @endif
                                <div class="event-actions-home">
                                    <a href="{{ route('event.register', $event) }}" class="btn-register-home" onclick="event.stopPropagation()">
                                        <i class="fas fa-ticket-alt me-2"></i>S'inscrire
                                    </a>
                                    <button type="button" class="btn-details-home" onclick="event.stopPropagation(); openEventModal({{ $event->id }})">
                                        <i class="fas fa-info-circle me-2"></i>Détails
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Lien vers tous les événements -->
                <div class="text-center mt-4" data-aos="fade-up">
                    <a href="{{ route('events.index') }}" class="btn btn-musical">
                        <i class="fas fa-calendar-alt me-2"></i>Voir tous les événements
                    </a>
                </div>
            @else
                <div class="text-center py-5" data-aos="fade-up">
                    <div class="icon-wrapper mx-auto mb-4">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h4 class="text-muted">Aucun événement programmé</h4>
                    <p class="text-muted">De nouveaux événements seront bientôt annoncés.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section class="page-section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="section-title text-start">À propos de notre chorale</h2>
                    <p class="lead mb-4">
                        La Chorale MRDA est un ensemble vocal passionné, dédié à la beauté et à la spiritualité de la musique sacrée.
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
                                <span>Ambiance chaleureuse</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Répertoire varié</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('about.index') }}" class="btn btn-musical">En savoir plus</a>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="text-center">
                        <div class="icon-wrapper mx-auto" style="width: 200px; height: 200px; font-size: 5rem;">
                            <i class="fas fa-microphone-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="page-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">En quoi nous sommes intéréssants ?</h2>
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up">
                    <div class="feature-card">
                        <div class="icon-wrapper mx-auto">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4 class="fw-bold text-primary">Inscription facile</h4>
                        <p class="text-muted">
                            Vous pouvez nous rejoindre quand vous le souhaitez.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon-wrapper mx-auto">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold text-primary">Evolution musicale</h4>
                        <p class="text-muted">
                            Chez nous , on apprend et on progresse ensemble.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon-wrapper mx-auto">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4 class="fw-bold text-primary">Famille</h4>
                        <p class="text-muted">
                            Nous sommes une grande famille unie par la louage et l'adoration.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section page-section">
        <div class="container text-center">
            <h2 class="section-title" data-aos="fade-up">Contactez-nous</h2>
            <p class="lead mb-4 text-dark" data-aos="fade-up" data-aos-delay="100">
                Une question ? Envie de nous rejoindre ? N'hésitez pas à nous contacter !
            </p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                            <i class="fas fa-envelope fa-2x mb-2 text-primary"></i>
                            <div class="text-dark">choralemrda2025@gmail.com</div>
                        </div>
                        <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="300">
                            <i class="fas fa-phone fa-2x mb-2 text-primary"></i>
                            <div class="text-dark">+1 (438) 491-8227</div>
                        </div>
                        <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="400">
                            <i class="fas fa-map-marker-alt fa-2x mb-2 text-primary"></i>
                            <div class="text-dark">4550, rue d’Orléans, Montréal, QC, Canada</div>
                        </div>
                    </div>
                    <a href="{{ route('contact.index') }}" class="btn btn-musical mt-4" data-aos="fade-up" data-aos-delay="500">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Détails Événement -->
    <div class="modal fade event-modal" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <div style="position: relative; z-index: 2;">
                        <div class="modal-date-badge" id="modalDateBadge">Chargement...</div>
                        <h4 class="modal-title" id="modalEventTitle">Détails de l'Événement</h4>
                        <p class="modal-subtitle" id="modalEventSubtitle">Chargement...</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: relative; z-index: 3;"></button>
                </div>
                <div class="modal-body modal-body-custom">
                    <div class="event-details-section">
                        <div class="detail-grid">
                            <div class="modal-detail-item">
                                <div class="modal-detail-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="modal-detail-content">
                                    <h6>Date et Heure</h6>
                                    <p id="modalEventDateTime">--</p>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="modal-detail-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="modal-detail-content">
                                    <h6>Lieu</h6>
                                    <p id="modalEventLocation">--</p>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="modal-detail-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="modal-detail-content">
                                    <h6>Durée estimée</h6>
                                    <p id="modalEventDuration">--</p>
                                </div>
                            </div>
                            <div class="modal-detail-item">
                                <div class="modal-detail-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="modal-detail-content">
                                    <h6>Places disponibles</h6>
                                    <p id="modalEventAttendees">--</p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-price-section">
                            <div class="modal-price-amount" id="modalEventPrice">
                                Chargement...
                            </div>
                            <p class="mb-0" id="modalPriceLabel">
                                Chargement...
                            </p>
                        </div>

                        <div class="modal-description">
                            <h5>À propos de cet événement</h5>
                            <p id="modalEventDescription">Chargement de la description...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-actions">
                    <a href="#" id="modalRegisterBtn" class="btn-modal-register">
                        <i class="fas fa-ticket-alt me-2"></i>S'inscrire maintenant
                    </a>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Initialiser AOS (Animate On Scroll)
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
        });

        // Carousel JavaScript custom (sans dépendance Bootstrap)
        let currentSlide = 0;
        let autoSlideInterval;

        const carousel = document.querySelector('#heroCarousel');
        const slides = carousel.querySelectorAll('.carousel-item');
        const indicators = carousel.querySelectorAll('.carousel-indicators button');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        console.log(`Found ${slides.length} slides`);

        function showSlide(index) {
            // Animation de sortie pour le slide actuel
            const currentActiveSlide = carousel.querySelector('.carousel-item.active');
            if (currentActiveSlide && currentActiveSlide !== slides[index]) {
                currentActiveSlide.style.opacity = '0';
            }

            // Petite pause pour la transition
            setTimeout(() => {
                // Retirer les classes active de tous les slides
                slides.forEach(slide => {
                    slide.classList.remove('active');
                    slide.style.opacity = '0';
                });
                indicators.forEach(indicator => indicator.classList.remove('active'));

                // Ajouter active au slide courant
                slides[index].classList.add('active');
                slides[index].style.opacity = '1';

                if (indicators[index]) {
                    indicators[index].classList.add('active');
                }

                console.log(`Showing slide ${index}`);
            }, 100);
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function startAutoSlide() {
            autoSlideInterval = setInterval(nextSlide, 4000); // 4 secondes
            console.log('Auto-slide started');
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        // Event listeners pour les boutons
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                stopAutoSlide();
                nextSlide();
                startAutoSlide(); // Redémarrer l'auto-slide
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                stopAutoSlide();
                prevSlide();
                startAutoSlide(); // Redémarrer l'auto-slide
            });
        }

        // Event listeners pour les indicateurs
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                stopAutoSlide();
                currentSlide = index;
                showSlide(currentSlide);
                startAutoSlide(); // Redémarrer l'auto-slide
            });
        });

        // Démarrer l'auto-slide si on a des slides
        if (slides.length > 1) {
            startAutoSlide();
        }

        // Pause au hover
        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);

        console.log('Custom carousel initialized successfully');
    });


    // Event Modal Script
    function openEventModal(eventId) {
        // Afficher un état de chargement
        showLoadingState();

        // Ouvrir le modal immédiatement avec l'état de chargement
        const eventModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
        eventModal.show();

        // Récupérer les données de l'événement via AJAX
        fetch(`/api/evenement/${eventId}`)
            .then(response => response.json())
            .then(data => {
                updateModalContent(data);
            })
            .catch(error => {
                console.error('Erreur lors du chargement de l\'événement:', error);
                showErrorState();
            });
    }

    // Fonction pour afficher l'état de chargement
    function showLoadingState() {
        document.getElementById('modalDateBadge').textContent = 'Chargement...';
        document.getElementById('modalEventTitle').textContent = 'Chargement des détails...';
        document.getElementById('modalEventSubtitle').textContent = 'Veuillez patienter...';
        document.getElementById('modalEventDateTime').textContent = 'Chargement...';
        document.getElementById('modalEventLocation').textContent = 'Chargement...';
        document.getElementById('modalEventDuration').textContent = 'Chargement...';
        document.getElementById('modalEventAttendees').textContent = 'Chargement...';
        document.getElementById('modalEventPrice').textContent = 'Chargement...';
        document.getElementById('modalPriceLabel').textContent = 'Chargement...';
        document.getElementById('modalEventDescription').textContent = 'Chargement de la description...';
        document.getElementById('modalRegisterBtn').href = '#';
        document.getElementById('modalRegisterBtn').style.opacity = '0.5';
    }

    // Fonction pour afficher l'état d'erreur
    function showErrorState() {
        document.getElementById('modalEventTitle').textContent = 'Erreur de chargement';
        document.getElementById('modalEventSubtitle').textContent = 'Impossible de charger les détails de l\'événement';
        document.getElementById('modalEventDescription').textContent = 'Une erreur est survenue lors du chargement des données. Veuillez réessayer.';
    }

    // Fonction pour mettre à jour le contenu du modal avec les données reçues
    function updateModalContent(event) {
        // Mettre à jour le titre et les informations principales
        document.getElementById('modalEventTitle').textContent = event.name;
        document.getElementById('modalEventSubtitle').textContent = event.formatted_datetime;

        // Mettre à jour le badge de prix
        const dateBadge = document.getElementById('modalDateBadge');
        dateBadge.textContent = event.price_formatted;
        if (event.price > 0) {
            dateBadge.style.background = 'var(--gold)';
        } else {
            dateBadge.style.background = '#10b981';
        }

        // Mettre à jour les détails
        document.getElementById('modalEventDateTime').textContent = event.formatted_date + ' à ' + event.formatted_time;
        document.getElementById('modalEventLocation').textContent = event.location;
        document.getElementById('modalEventDuration').textContent = event.duration;
        document.getElementById('modalEventAttendees').textContent = event.max_attendees;

        // Mettre à jour la section prix
        document.getElementById('modalEventPrice').textContent = event.price_formatted;
        const priceLabel = document.getElementById('modalPriceLabel');
        if (event.price > 0) {
            priceLabel.textContent = 'Par personne';
        } else {
            priceLabel.textContent = 'Entrée libre';
        }

        // Mettre à jour la description
        document.getElementById('modalEventDescription').textContent = event.description || 'Aucune description disponible pour cet événement.';

        // Mettre à jour le bouton d'inscription
        const registerBtn = document.getElementById('modalRegisterBtn');
        registerBtn.href = event.register_url;
        registerBtn.style.opacity = '1';

        // Cacher le bouton d'inscription si l'événement est passé
        if (!event.is_upcoming) {
            registerBtn.style.display = 'none';
        } else {
            registerBtn.style.display = 'inline-block';
        }

        // Ajouter une animation de fondu pour indiquer que le contenu est chargé
        const modalContent = document.querySelector('.modal-content');
        modalContent.style.opacity = '0.8';
        setTimeout(() => {
            modalContent.style.opacity = '1';
        }, 200);
    }
</script>
@endpush
