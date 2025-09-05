@extends('layouts.public')

@section('title', 'Événements - Chorale MRDA')
@section('meta-description', 'Découvrez tous nos événements et concerts de la Chorale MRDA')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        padding: 60px 0 50px; /* Réduit de 100px 0 80px */
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
        font-size: 2.5rem; /* Réduit de 3rem */
        font-weight: bold;
        margin-bottom: 15px; /* Réduit de 20px */
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    @keyframes musicNote {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .stats-section {
        background: white;
        border-radius: 15px; /* Réduit de 20px */
        padding: 30px; /* Réduit de 40px */
        margin: -30px auto 40px; /* Réduit de -50px auto 60px */
        max-width: 700px; /* Réduit de 800px */
        box-shadow: 0 10px 25px rgba(0,0,0,0.08); /* Réduit l'ombre */
        position: relative;
        z-index: 10;
    }

    .stat-item {
        text-align: center;
        padding: 15px; /* Réduit de 20px */
    }

    .stat-number {
        font-size: 2rem; /* Réduit de 2.5rem */
        font-weight: bold;
        color: var(--primary-blue);
        margin-bottom: 8px; /* Réduit de 10px */
    }

    .stat-label {
        color: var(--dark-blue);
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .section-title {
        font-size: 2rem; /* Réduit de 2.5rem */
        text-align: center;
        margin-bottom: 2rem; /* Réduit de 3rem */
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
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); /* Réduit de 350px */
        gap: 25px; /* Réduit de 30px */
        margin-top: 30px; /* Réduit de 40px */
        max-width: 1100px; /* Réduit de 1200px */
        margin-left: auto;
        margin-right: auto;
    }

    /* Amélioration pour un seul événement */
    .events-grid.single-event {
        grid-template-columns: 1fr;
        max-width: 450px; /* Réduit de 500px */
        justify-items: center;
    }

    /* Amélioration pour deux événements */
    .events-grid.two-events {
        grid-template-columns: repeat(2, 1fr);
        max-width: 750px; /* Réduit de 800px */
    }

    .event-card {
        background: white;
        border-radius: 15px; /* Réduit de 20px */
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08); /* Réduit l'ombre */
        transition: all 0.3s ease;
        position: relative;
        border-left: 4px solid var(--primary-blue); /* Réduit de 5px */
        cursor: pointer;
        width: 100%;
        max-width: 350px; /* Réduit de 380px */
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
        padding: 15px; /* Réduit de 20px */
        position: relative;
    }

    .event-card.past .event-date {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    .event-day {
        font-size: 1.6rem; /* Réduit de 2rem */
        font-weight: bold;
        line-height: 1;
    }

    .event-month {
        font-size: 0.8rem; /* Réduit de 0.9rem */
        text-transform: uppercase;
        margin-top: 5px;
    }

    .event-content {
        padding: 20px; /* Réduit de 25px */
    }

    .event-title {
        font-size: 1.2rem; /* Réduit de 1.4rem */
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 12px; /* Réduit de 15px */
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

        /* Responsive pour le modal */
        .event-modal .modal-dialog {
            margin: 10px;
        }

        .events-grid.two-events {
            grid-template-columns: 1fr;
            max-width: 500px;
        }

        .modal-title {
            font-size: 1.5rem;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .modal-actions {
            flex-direction: column;
            align-items: center;
        }

        .btn-modal-register,
        .btn-modal-close {
            width: 100%;
            max-width: 300px;
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

    /* Modal styles */
    .event-modal .modal-dialog {
        max-width: 750px; /* Réduit de 900px */
    }

    .event-modal .modal-content {
        border-radius: 15px; /* Réduit de 20px */
        border: none;
        overflow: hidden;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        padding: 20px; /* Réduit de 30px */
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
        padding: 6px 12px; /* Réduit de 10px 20px */
        border-radius: 20px; /* Réduit de 25px */
        font-weight: bold;
        font-size: 0.8rem; /* Réduit de 0.9rem */
        display: inline-block;
        margin-bottom: 10px; /* Réduit de 15px */
    }

    .modal-title {
        font-size: 1.5rem; /* Réduit de 2rem */
        font-weight: bold;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .modal-subtitle {
        opacity: 0.9;
        margin: 8px 0 0; /* Réduit de 10px */
        position: relative;
        z-index: 2;
        font-size: 0.9rem;
    }

    .modal-body-custom {
        padding: 0;
    }

    .event-details-section {
        padding: 25px; /* Réduit de 40px */
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Réduit de 250px */
        gap: 15px; /* Réduit de 20px */
        margin-bottom: 20px; /* Réduit de 30px */
    }

    .modal-detail-item {
        display: flex;
        align-items: center;
        padding: 15px; /* Réduit de 20px */
        background: #f8fafc;
        border-radius: 12px; /* Réduit de 15px */
        border-left: 3px solid var(--primary-blue); /* Réduit de 4px */
        transition: all 0.3s ease;
    }

    .modal-detail-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .modal-detail-icon {
        width: 40px; /* Réduit de 50px */
        height: 40px; /* Réduit de 50px */
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px; /* Réduit de 15px */
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    .modal-detail-content h6 {
        margin: 0 0 3px; /* Réduit de 5px */
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
        padding: 20px; /* Réduit de 30px */
        text-align: center;
        margin: 20px 0; /* Réduit de 30px */
        border-radius: 12px; /* Réduit de 15px */
    }

    .modal-price-amount {
        font-size: 2rem; /* Réduit de 2.5rem */
        font-weight: bold;
        margin-bottom: 8px; /* Réduit de 10px */
    }

    .modal-description {
        background: #f8fafc;
        padding: 20px; /* Réduit de 30px */
        border-radius: 12px; /* Réduit de 15px */
        margin: 20px 0; /* Réduit de 30px */
    }

    .modal-description h5 {
        color: var(--dark-blue);
        margin-bottom: 15px; /* Réduit de 20px */
        font-weight: 600;
        font-size: 1.1rem;
    }

    .modal-actions {
        padding: 20px 25px; /* Réduit de 30px 40px */
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 12px; /* Réduit de 15px */
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-modal-register {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border: none;
        padding: 12px 30px; /* Réduit de 15px 40px */
        border-radius: 40px; /* Réduit de 50px */
        font-weight: 600;
        font-size: 1rem; /* Réduit de 1.1rem */
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
        padding: 12px 25px; /* Réduit de 15px 30px */
        border-radius: 40px; /* Réduit de 50px */
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-modal-close:hover {
        background: #6b7280;
        color: white;
        transform: translateY(-2px);
    }

    .event-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 3;
    }

    .event-status.upcoming {
        background: #10b981;
        color: white;
    }

    .event-status.past {
        background: #6b7280;
        color: white;
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
            <div class="events-grid @if($upcomingEvents->count() == 1) single-event @elseif($upcomingEvents->count() == 2) two-events @endif">
                @foreach($upcomingEvents as $event)
                <div class="event-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" data-event-id="{{ $event->id }}" onclick="openEventModal({{ $event->id }})">
                    <div class="event-status upcoming">À venir</div>
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
                            <a href="{{ route('event.register', $event) }}" class="btn-register" onclick="event.stopPropagation()">
                                <i class="fas fa-ticket-alt me-2"></i>S'inscrire
                            </a>
                            <button type="button" class="btn-details" onclick="event.stopPropagation(); openEventModal({{ $event->id }})">
                                <i class="fas fa-info-circle me-2"></i>Détails
                            </button>
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
            <div class="events-grid @if($pastEvents->count() == 1) single-event @elseif($pastEvents->count() == 2) two-events @endif">
                @foreach($pastEvents as $event)
                <div class="event-card past" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" data-event-id="{{ $event->id }}" onclick="openEventModal({{ $event->id }})">
                    <div class="event-status past">Passé</div>
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
                            <button type="button" class="btn-details" onclick="event.stopPropagation(); openEventModal({{ $event->id }})">
                                <i class="fas fa-info-circle me-2"></i>Voir les détails
                            </button>
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

// Fonction pour ouvrir le modal de l'événement avec données AJAX
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
