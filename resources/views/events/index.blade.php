@extends('layouts.public')

@section('title', 'Événements - Chorale MRDA')
@section('meta-description', 'Découvrez tous nos événements et concerts de la Chorale MRDA')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        padding: 100px 0 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
        background-size: 50px 50px;
        animation: musicNote 3s ease-in-out infinite;
    }

    .page-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    @keyframes musicNote {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .stats-section {
        background: white;
        border-radius: 20px;
        padding: 40px;
        margin: -50px auto 60px;
        max-width: 800px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        position: relative;
        z-index: 10;
    }

    .stat-item {
        text-align: center;
        padding: 20px;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--primary-blue);
        margin-bottom: 10px;
    }

    .stat-label {
        color: var(--dark-blue);
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
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

    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .event-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
        border-left: 5px solid var(--primary-blue);
    }

    .event-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .event-card.past {
        opacity: 0.8;
        border-left-color: #6b7280;
    }

    .event-date {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        text-align: center;
        padding: 20px;
        position: relative;
    }

    .event-card.past .event-date {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .event-day {
        font-size: 2rem;
        font-weight: bold;
        line-height: 1;
    }

    .event-month {
        font-size: 0.9rem;
        text-transform: uppercase;
        margin-top: 5px;
    }

    .event-content {
        padding: 25px;
    }

    .event-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 15px;
    }

    .event-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .event-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .event-description {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .event-price {
        background: var(--gold);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 20px;
    }

    .event-actions {
        display: flex;
        gap: 10px;
    }

    .btn-register {
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

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        color: white;
    }

    .btn-register:disabled,
    .btn-register.disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    .btn-details {
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

    .btn-details:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
    }

    .no-events {
        text-align: center;
        padding: 80px 20px;
        color: #6b7280;
    }

    .no-events i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #d1d5db;
    }

    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .filter-tab {
        background: white;
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .filter-tab.active,
    .filter-tab:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.5rem;
        }

        .events-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .event-actions {
            flex-direction: column;
        }

        .stats-section {
            margin: -30px 20px 40px;
            padding: 30px 20px;
        }

        .stat-number {
            font-size: 2rem;
        }
    }

    /* Animation */
    .animate-fadeInUp {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title animate-fadeInUp">
                <i class="fas fa-calendar-alt me-3"></i>Nos Événements
            </h1>
            <p class="lead animate-fadeInUp">Découvrez tous nos concerts et événements à venir</p>
        </div>
    </div>

    <div class="container">
        <!-- Statistiques -->
        <div class="stats-section">
            <div class="row">
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['total_events'] }}</div>
                        <div class="stat-label">Total Événements</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['upcoming_count'] }}</div>
                        <div class="stat-label">À Venir</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['past_count'] }}</div>
                        <div class="stat-label">Passés</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">
                <i class="fas fa-th me-2"></i>Tous les événements
            </button>
            <button class="filter-tab" data-filter="upcoming">
                <i class="fas fa-calendar-plus me-2"></i>À venir
            </button>
            <button class="filter-tab" data-filter="past">
                <i class="fas fa-history me-2"></i>Passés
            </button>
        </div>

        <!-- Événements à venir -->
        @if($upcomingEvents->count() > 0)
        <section id="upcoming-events" class="mb-5">
            <h2 class="section-title" data-aos="fade-up">Événements à Venir</h2>
            <div class="events-grid">
                @foreach($upcomingEvents as $event)
                <div class="event-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="event-date">
                        <div class="event-day">{{ $event->event_date->format('d') }}</div>
                        <div class="event-month">{{ $event->event_date->format('M Y') }}</div>
                    </div>
                    <div class="event-content">
                        <h3 class="event-title">{{ $event->name }}</h3>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $event->event_date->format('H:i') }}
                            </div>
                            <div class="event-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $event->location ?? 'À définir' }}
                            </div>
                        </div>
                        <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                        @if($event->price > 0)
                            <div class="event-price">${{ number_format($event->price, 2) }}</div>
                        @else
                            <div class="event-price">Gratuit</div>
                        @endif
                        <div class="event-actions">
                            <a href="{{ route('event.register', $event) }}" class="btn-register">
                                <i class="fas fa-ticket-alt me-2"></i>S'inscrire
                            </a>
                            <a href="{{ route('events.show', $event) }}" class="btn-details">
                                <i class="fas fa-info-circle me-2"></i>Détails
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination pour événements à venir -->
            @if($upcomingEvents->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $upcomingEvents->withQueryString()->links() }}
            </div>
            @endif
        </section>
        @endif

        <!-- Événements passés -->
        @if($pastEvents->count() > 0)
        <section id="past-events">
            <h2 class="section-title" data-aos="fade-up">Événements Passés</h2>
            <div class="events-grid">
                @foreach($pastEvents as $event)
                <div class="event-card past" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="event-date">
                        <div class="event-day">{{ $event->event_date->format('d') }}</div>
                        <div class="event-month">{{ $event->event_date->format('M Y') }}</div>
                    </div>
                    <div class="event-content">
                        <h3 class="event-title">{{ $event->name }}</h3>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $event->event_date->format('H:i') }}
                            </div>
                            <div class="event-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $event->location ?? 'À définir' }}
                            </div>
                        </div>
                        <p class="event-description">{{ Str::limit($event->description, 120) }}</p>
                        <div class="event-actions">
                            <a href="{{ route('events.show', $event) }}" class="btn-details">
                                <i class="fas fa-info-circle me-2"></i>Voir les détails
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination pour événements passés -->
            @if($pastEvents->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $pastEvents->withQueryString()->links() }}
            </div>
            @endif
        </section>
        @endif

        <!-- Aucun événement -->
        @if($upcomingEvents->count() == 0 && $pastEvents->count() == 0)
        <div class="no-events">
            <i class="fas fa-calendar-times"></i>
            <h3>Aucun événement programmé</h3>
            <p>De nouveaux événements seront bientôt annoncés. Restez à l'écoute !</p>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });

    // Filtrage des événements
    const filterTabs = document.querySelectorAll('.filter-tab');
    const upcomingSection = document.getElementById('upcoming-events');
    const pastSection = document.getElementById('past-events');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Retirer la classe active de tous les onglets
            filterTabs.forEach(t => t.classList.remove('active'));
            // Ajouter la classe active à l'onglet cliqué
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            // Gérer l'affichage des sections
            if (filter === 'all') {
                if (upcomingSection) upcomingSection.style.display = 'block';
                if (pastSection) pastSection.style.display = 'block';
            } else if (filter === 'upcoming') {
                if (upcomingSection) upcomingSection.style.display = 'block';
                if (pastSection) pastSection.style.display = 'none';
            } else if (filter === 'past') {
                if (upcomingSection) upcomingSection.style.display = 'none';
                if (pastSection) pastSection.style.display = 'block';
            }
        });
    });

    // Animation au scroll pour les éléments sans AOS
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.animate-fadeInUp').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.8s ease';
        observer.observe(el);
    });
});
</script>
@endpush