@extends('layouts.public')

@section('title', 'Contact - Chorale MRDA')

@section('content')
<div class="contact-page">
    <!-- Hero Section -->
    <section class="hero-contact">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 text-white mb-4">
                        <i class="fas fa-envelope-open-text me-3"></i>
                        Contactez-nous
                    </h1>
                    <p class="lead text-white-75 mb-4">
                        Nous serions ravis d'entendre de vous ! Que ce soit pour rejoindre notre chorale,
                        organiser un événement ou simplement poser une question.
                    </p>
                    <div class="contact-info">
                        <div class="info-item mb-3" data-aos="fade-up" data-aos-delay="100">
                            <i class="fas fa-map-marker-alt text-warning me-3"></i>
                            <span class="text-white">123 Rue de la Musique, Kinshasa, RDC</span>
                        </div>
                        <div class="info-item mb-3" data-aos="fade-up" data-aos-delay="200">
                            <i class="fas fa-phone text-warning me-3"></i>
                            <span class="text-white">+243 123 456 789</span>
                        </div>
                        <div class="info-item mb-3" data-aos="fade-up" data-aos-delay="300">
                            <i class="fas fa-envelope text-warning me-3"></i>
                            <span class="text-white">contact@chorale-mrda.com</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="400">
                    <div class="musical-animation">
                        <i class="fas fa-music note-1"></i>
                        <i class="fas fa-music note-2"></i>
                        <i class="fas fa-music note-3"></i>
                        <i class="fas fa-music note-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="contact-content py-5">
        <div class="container">
            <div class="row">
                <!-- Formulaire de contact -->
                <div class="col-lg-6 mb-5" data-aos="fade-up">
                    <div class="contact-form-wrapper">
                        <h3 class="mb-4">
                            <i class="fas fa-paper-plane text-primary me-2"></i>
                            Envoyez-nous un message
                        </h3>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="zoom-in">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="zoom-in">
                                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nom complet *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Sujet *</label>
                                <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                    <option value="">Choisissez un sujet</option>
                                    <option value="Rejoindre la chorale" {{ old('subject') == 'Rejoindre la chorale' ? 'selected' : '' }}>
                                        Rejoindre la chorale
                                    </option>
                                    <option value="Organisation d'événement" {{ old('subject') == 'Organisation d\'événement' ? 'selected' : '' }}>
                                        Organisation d'événement
                                    </option>
                                    <option value="Collaboration musicale" {{ old('subject') == 'Collaboration musicale' ? 'selected' : '' }}>
                                        Collaboration musicale
                                    </option>
                                    <option value="Question générale" {{ old('subject') == 'Question générale' ? 'selected' : '' }}>
                                        Question générale
                                    </option>
                                    <option value="Autre" {{ old('subject') == 'Autre' ? 'selected' : '' }}>
                                        Autre
                                    </option>
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message" name="message" rows="6" required
                                          placeholder="Écrivez votre message ici...">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100 submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>
                                Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="map-wrapper">
                        <h3 class="mb-4">
                            <i class="fas fa-map-marked-alt text-primary me-2"></i>
                            Où nous trouver
                        </h3>
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.8158108983567!2d15.2663156!3d-4.3276274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a314897e4c533%3A0x8c42cefaa3b37c9!2sKinshasa%2C%20Democratic%20Republic%20of%20the%20Congo!5e0!3m2!1sen!2sus!4v1699123456789!5m2!1sen!2sus"
                                width="100%"
                                height="400"
                                style="border:0; border-radius: 15px;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                        <!-- Informations de contact supplémentaires -->
                        <div class="contact-details mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-card" data-aos="zoom-in" data-aos-delay="300">
                                        <i class="fas fa-clock text-primary mb-2"></i>
                                        <h6>Horaires de répétition</h6>
                                        <p class="text-muted mb-0">
                                            Mardi & Jeudi<br>
                                            18h00 - 20h00
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card" data-aos="zoom-in" data-aos-delay="400">
                                        <i class="fas fa-calendar text-primary mb-2"></i>
                                        <h6>Services dominicaux</h6>
                                        <p class="text-muted mb-0">
                                            Dimanche<br>
                                            9h00 & 11h00
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rejoignez-nous Section -->
    <section class="join-us-section py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <h3 class="mb-4">
                        <i class="fas fa-users text-primary me-2"></i>
                        Rejoignez notre communauté musicale
                    </h3>
                    <p class="lead text-muted mb-4">
                        La Chorale MRDA accueille tous ceux qui partagent la passion de la musique sacrée.
                        Aucune expérience préalable n'est requise, juste l'amour du chant et de la louange.
                    </p>
                    <div class="row">
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="feature-item">
                                <i class="fas fa-microphone-alt text-primary mb-3"></i>
                                <h6>Formation vocale</h6>
                                <p class="text-muted">Développez votre voix avec nos formateurs expérimentés</p>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-item">
                                <i class="fas fa-heart text-primary mb-3"></i>
                                <h6>Communauté unie</h6>
                                <p class="text-muted">Rejoignez une famille musicale chaleureuse et bienveillante</p>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-item">
                                <i class="fas fa-star text-primary mb-3"></i>
                                <h6>Performances</h6>
                                <p class="text-muted">Participez à des concerts et événements spirituels</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
.hero-contact {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    position: relative;
    overflow: hidden;
}

.hero-contact::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="90" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    animation: float 20s infinite linear;
}

@keyframes float {
    0% { transform: translateY(0px) rotate(0deg); }
    100% { transform: translateY(-20px) rotate(360deg); }
}

.musical-animation {
    position: relative;
    height: 300px;
}

.musical-animation i {
    position: absolute;
    font-size: 2rem;
    color: rgba(255, 255, 255, 0.3);
    animation: musicFloat 4s infinite ease-in-out;
}

.note-1 { top: 20%; left: 20%; animation-delay: 0s; }
.note-2 { top: 60%; left: 60%; animation-delay: 1s; }
.note-3 { top: 40%; left: 80%; animation-delay: 2s; }
.note-4 { top: 80%; left: 30%; animation-delay: 3s; }

@keyframes musicFloat {
    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
    50% { transform: translateY(-30px) rotate(180deg); opacity: 0.8; }
}

.contact-form-wrapper,
.map-wrapper {
    background: white;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    height: 100%;
}

.form-control,
.form-select {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 12px 16px;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    transform: translateY(-2px);
}

.submit-btn {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    border: none;
    border-radius: 15px;
    padding: 15px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
}

.map-container {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.map-container:hover {
    transform: scale(1.02);
}

.detail-card {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 15px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
}

.detail-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.detail-card i {
    font-size: 2rem;
}

.feature-item {
    padding: 2rem 1rem;
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-10px);
}

.feature-item i {
    font-size: 3rem;
}

.info-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    transition: transform 0.3s ease;
}

.info-item:hover {
    transform: translateX(10px);
}

/* Animations de texte */
.text-white-75 {
    color: rgba(255, 255, 255, 0.85);
}

/* Responsive */
@media (max-width: 768px) {
    .musical-animation {
        height: 200px;
    }

    .hero-contact {
        text-align: center;
    }

    .contact-form-wrapper,
    .map-wrapper {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
}
</style>
@endpush

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

    // Animation du formulaire
    const form = document.querySelector('.contact-form');
    const inputs = form.querySelectorAll('.form-control, .form-select');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentNode.classList.remove('focused');
            }
        });
    });

    // Animation du bouton de soumission
    const submitBtn = document.querySelector('.submit-btn');
    submitBtn.addEventListener('click', function(e) {
        if (form.checkValidity()) {
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
            this.disabled = true;
        }
    });

    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush
