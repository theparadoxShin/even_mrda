@extends('layouts.public')

@section('title', 'À Propos')
@section('meta-description', 'À Propos de la Chorale MRDA - Découvrez notre histoire, nos membres et notre mission')

@push('styles')
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

    .choir-info-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        margin: 40px 0;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-left: 5px solid var(--gold);
    }

    .info-stat {
        text-align: center;
        margin: 20px 0;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: bold;
        color: var(--primary-blue);
        display: block;
    }

    .stat-label {
        color: var(--dark-blue);
        font-weight: 500;
    }

    .member-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .member-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue), var(--gold));
    }

    .member-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .member-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        margin: 0 auto 20px;
        position: relative;
    }

    .voice-badge {
        position: absolute;
        bottom: -10px;
        right: -5px;
        background: var(--gold);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .member-name {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 10px;
    }

    .member-role {
        color: var(--primary-blue);
        font-weight: 500;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .member-years {
        color: var(--gold);
        font-weight: bold;
        margin-bottom: 15px;
    }

    .member-bio {
        color: #666;
        font-style: italic;
        line-height: 1.6;
    }

    .achievement-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-left: 4px solid var(--primary-blue);
        transition: all 0.3s ease;
    }

    .achievement-card:hover {
        transform: translateX(10px);
        border-left-color: var(--gold);
    }

    .achievement-year {
        background: var(--primary-blue);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 15px;
    }

    .achievement-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 10px;
    }

    .mission-section {
        background: var(--light-blue);
        border-radius: 20px;
        padding: 50px;
        margin: 40px 0;
        text-align: center;
    }

    .mission-icon {
        width: 80px;
        height: 80px;
        background: var(--gold);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 30px;
    }

    .voice-icons {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin: 40px 0;
    }

    .voice-icon {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .voice-icon:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .voice-symbol {
        font-size: 2rem;
        color: var(--primary-blue);
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title animate-fadeInUp">
                <i class="fas fa-calendar-alt me-3"></i>{{ $choirInfo['name'] }}
            </h1>
            <p class="lead animate-fadeInUp">{{ $choirInfo['description'] }}</p>
        </div>
    </div>

    <!-- Section principale -->
    <div class="container">
        <!-- Informations sur la chorale -->
        <section class="section">
            <div class="choir-info-card animate-fadeInUp">
                <div class="row">
                    <div class="col-lg-8">
                        <h3 class="fw-bold text-primary mb-4">Notre Histoire</h3>
                        <p class="lead">{{ $choirInfo['description'] }}</p>

                        <div class="mission-section">
                            <div class="mission-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h4 class="fw-bold text-primary mb-3">Notre Mission</h4>
                            <p class="lead">{{ $choirInfo['mission'] }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="info-stat">
                            <span class="stat-number">{{ $choirInfo['founded'] }}</span>
                            <div class="stat-label">Année de Fondation</div>
                        </div>
                        <div class="info-stat">
                            <span class="stat-number">{{ $choirInfo['members_count'] }}</span>
                            <div class="stat-label">Membres Actifs</div>
                        </div>
                        <div class="info-stat">
                            <span class="stat-number">{{ count($achievements) }}</span>
                            <div class="stat-label">Réalisations Marquantes</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Membres de la chorale -->
        <section class="section">
            <h2 class="section-title animate-fadeInUp">Nos Membres</h2>
            <div class="row">
                @foreach($members as $member)
                <div class="col-lg-4 col-md-6 animate-fadeInUp">
                    <div class="member-card">
                        <div class="member-avatar">
                            @switch($member['voice'])
                                @case('Direction')
                                    <i class="fas fa-crown"></i>
                                    @break
                                @case('Soprano')
                                    <i class="fas fa-female"></i>
                                    @break
                                @case('Alto')
                                    <i class="fas fa-female"></i>
                                    @break
                                @case('Ténor')
                                    <i class="fas fa-male"></i>
                                    @break
                                @case('Basse')
                                    <i class="fas fa-male"></i>
                                    @break
                                @default
                                    <i class="fas fa-user"></i>
                            @endswitch
                            <div class="voice-badge">{{ $member['voice'] }}</div>
                        </div>
                        <h4 class="member-name">{{ $member['name'] }}</h4>
                        <div class="member-role">{{ $member['role'] }}</div>
                        <div class="member-years">
                            <i class="fas fa-calendar me-1"></i>{{ $member['years'] }} ans d'expérience
                        </div>
                        <p class="member-bio">{{ $member['bio'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Réalisations -->
        <section class="section bg-light">
            <div class="container">
                <h2 class="section-title animate-fadeInUp">Nos Réalisations</h2>
                <div class="row">
                    @foreach($achievements as $achievement)
                    <div class="col-lg-4 animate-fadeInUp">
                        <div class="achievement-card">
                            <div class="achievement-year">{{ $achievement['year'] }}</div>
                            <h4 class="achievement-title">{{ $achievement['title'] }}</h4>
                            <p class="text-muted">{{ $achievement['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Section de contact -->
        <section class="section">
            <div class="choir-info-card text-center">
                <h3 class="fw-bold text-primary mb-4">Rejoignez Notre Chorale</h3>
                <p class="lead mb-4">
                    Passionné(e) de musique sacrée ? Notre chorale accueille de nouveaux talents !
                    Que vous soyez débutant ou expérimenté, venez partager votre amour du chant avec nous.
                </p>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                <div><strong>Email</strong></div>
                                <div>contact@chorale-mrda.com</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                                <div><strong>Téléphone</strong></div>
                                <div>+1 (514) 123-4567</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                                <div><strong>Adresse</strong></div>
                                <div>5366 Chem. de la côte des neiges,Montréal, QC, Canada</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-musical btn-lg me-3">
                        <i class="fas fa-calendar me-2"></i>Voir nos Événements
                    </a>
                    <a href="{{ route('music.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-music me-2"></i>Écouter nos Œuvres
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    // Animations au scroll
    document.addEventListener('DOMContentLoaded', function() {
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

        // Observer tous les éléments avec animation
        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });

        // Animation des cartes membres au hover
        document.querySelectorAll('.member-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.querySelector('.member-avatar').style.transform = 'scale(1.1) rotate(5deg)';
            });

            card.addEventListener('mouseleave', function() {
                this.querySelector('.member-avatar').style.transform = 'scale(1) rotate(0deg)';
            });
        });

        // Animation des statistiques
        const stats = document.querySelectorAll('.stat-number');
        stats.forEach(stat => {
            const finalNumber = parseInt(stat.textContent);
            let currentNumber = 0;
            const increment = finalNumber / 50;

            const timer = setInterval(() => {
                currentNumber += increment;
                if (currentNumber >= finalNumber) {
                    stat.textContent = finalNumber;
                    clearInterval(timer);
                } else {
                    stat.textContent = Math.floor(currentNumber);
                }
            }, 50);
        });
    });
</script>
@endpush
