@extends('layouts.public')

@section('title', app()->getLocale() == 'fr' ? 'Accueil' : 'Home')
@section('meta-description', 'Chorale MRDA - Accueil - Ensemble vocal dédié à la musique sacrée à Montreal, QC Canada')

@push('styles')
@livewireStyles

<style>
    /* Carrousel héro avec animations musicales */
    .hero-carousel {
        height: 80vh;
        position: relative;
        overflow: hidden;
        margin-top: -80px; /* Compensate for navbar padding */
    }

    .carousel-item {
        height: 80vh;
        position: relative;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
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

    <!-- Events Section -->
    <section id="events" class="page-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Événements à venir</h2>

            @if($upcomingEvents->count() > 0)
                <div class="row">
                    @foreach($upcomingEvents as $index => $event)
                        <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="event-card card-animate">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h4 class="fw-bold text-primary">{{ $event->name }}</h4>
                                    <span class="badge bg-warning text-dark">${{ number_format($event->price, 2) }}</span>
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
                                <a href="{{ route('event.register', $event) }}" class="btn btn-musical w-100">
                                    <i class="fas fa-ticket-alt me-2"></i>S'inscrire maintenant
                                </a>
                            </div>
                        </div>
                    @endforeach
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
                            <div class="text-dark">5366 Chem. de la côte des neiges Montréal, QC, Canada</div>
                        </div>
                    </div>
                    <a href="{{ route('contact.index') }}" class="btn btn-musical mt-4" data-aos="fade-up" data-aos-delay="500">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@livewireScripts
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
</script>
@endpush
