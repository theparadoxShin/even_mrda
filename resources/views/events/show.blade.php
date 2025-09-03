@extends('layouts.public')

@section('title', $event->name . ' - Chorale MRDA')
@section('meta-description', 'Détails de l\'événement: ' . $event->name)

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    .event-hero {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        padding: 120px 0 80px;
        position: relative;
        overflow: hidden;
    }

    .event-hero::before {
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

    .event-date-badge {
        background: var(--gold);
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.1rem;
        display: inline-block;
        margin-bottom: 20px;
    }

    .event-title {
        font-size: 3.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .event-details-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        margin: -80px auto 60px;
        max-width: 900px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        position: relative;
        z-index: 10;
    }

    .detail-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 10px;
        border-left: 4px solid var(--primary-blue);
    }

    .detail-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .detail-content h6 {
        margin: 0;
        color: var(--dark-blue);
        font-weight: 600;
    }

    .detail-content p {
        margin: 5px 0 0;
        color: #6b7280;
    }

    .price-section {
        background: linear-gradient(135deg, var(--gold), #f59e0b);
        color: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        margin: 30px 0;
    }

    .price-amount {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .registration-section {
        background: #f8fafc;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        margin-top: 40px;
    }

    .btn-register-large {
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        color: white;
        border: none;
        padding: 20px 50px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1.2rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-register-large::before {
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

    .btn-register-large:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-register-large:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.4);
        color: white;
    }

    .btn-back {
        background: transparent;
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        padding: 12px 24px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
    }

    .description-section {
        margin: 40px 0;
    }

    .description-section h3 {
        color: var(--dark-blue);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--primary-blue);
        padding-bottom: 10px;
    }

    .qr-section {
        text-align: center;
        margin: 40px 0;
        padding: 30px;
        background: #f8fafc;
        border-radius: 15px;
    }

    .qr-code {
        max-width: 200px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    @keyframes musicNote {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .event-title {
            font-size: 2.5rem;
        }

        .event-details-card {
            margin: -50px 20px 40px;
            padding: 30px 20px;
        }

        .detail-item {
            flex-direction: column;
            text-align: center;
        }

        .detail-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .price-amount {
            font-size: 2.5rem;
        }

        .btn-register-large {
            padding: 15px 30px;
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- En-tête de l'événement -->
    <div class="event-hero">
        <div class="container text-center">
            <div class="event-date-badge" data-aos="fade-down">
                {{ $event->event_date->format('d M Y à H:i') }}
            </div>
            <h1 class="event-title" data-aos="fade-up">{{ $event->name }}</h1>
            <p class="lead" data-aos="fade-up" data-aos-delay="100">
                {{ $event->location ?? 'Lieu à confirmer' }}
            </p>
        </div>
    </div>

    <div class="container">
        <!-- Bouton retour -->
        <a href="{{ route('events.index') }}" class="btn-back" data-aos="fade-right">
            <i class="fas fa-arrow-left"></i>
            Retour aux événements
        </a>

        <!-- Détails de l'événement -->
        <div class="event-details-card" data-aos="fade-up">
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="detail-content">
                            <h6>Date et Heure</h6>
                            <p>{{ $event->event_date->format('l d F Y à H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <h6>Lieu</h6>
                            <p>{{ $event->location ?? 'À confirmer' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="detail-content">
                            <h6>Durée estimée</h6>
                            <p>{{ $event->duration ?? '2 heures' }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="detail-content">
                            <h6>Places disponibles</h6>
                            <p>{{ $event->max_attendees ?? 'Illimitées' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prix -->
            <div class="price-section" data-aos="zoom-in">
                <div class="price-amount">
                    @if($event->price > 0)
                        ${{ number_format($event->price, 2) }}
                    @else
                        Gratuit
                    @endif
                </div>
                <p class="mb-0">
                    @if($event->price > 0)
                        Par personne
                    @else
                        Entrée libre
                    @endif
                </p>
            </div>
        </div>

        <!-- Description -->
        @if($event->description)
        <div class="description-section" data-aos="fade-up">
            <h3>À propos de cet événement</h3>
            <div class="row">
                <div class="col-lg-8">
                    <p class="lead">{{ $event->description }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- QR Code -->
        @if($event->qr_code)
        <div class="qr-section" data-aos="fade-up">
            <h4 class="mb-3">Code QR de l'événement</h4>
            <img src="{{ asset('storage/qrcodes/' . $event->qr_code) }}" 
                 alt="QR Code pour {{ $event->name }}" 
                 class="qr-code">
            <p class="mt-3 text-muted">Scannez ce code pour accéder rapidement à cet événement</p>
        </div>
        @endif

        <!-- Section d'inscription -->
        @if($event->event_date >= now())
        <div class="registration-section" data-aos="fade-up">
            <h3 class="mb-4">Prêt à participer ?</h3>
            <p class="lead mb-4">
                Rejoignez-nous pour cet événement exceptionnel de la Chorale MRDA.
                Votre inscription est {{ $event->price > 0 ? 'payante' : 'gratuite' }} et confirmée immédiatement.
            </p>
            <a href="{{ route('event.register', $event) }}" class="btn-register-large">
                <i class="fas fa-ticket-alt me-2"></i>
                S'inscrire maintenant
            </a>
        </div>
        @else
        <div class="registration-section" data-aos="fade-up">
            <h3 class="mb-4">Événement passé</h3>
            <p class="lead">
                Cet événement s'est déjà déroulé. Consultez notre section 
                <a href="{{ route('events.index') }}">événements</a> pour découvrir nos prochaines dates.
            </p>
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
});
</script>
@endpush