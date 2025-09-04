@extends('layouts.public')

@section('title', 'Contact - Chorale MRDA')

@section('content')
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title animate-fadeInUp">
                <i class="fas fa-envelope me-3"></i>Contactez-nous
            </h1>
            <p class="lead animate-fadeInUp">Nous serions ravis d'entendre de vous !</p>
        </div>
    </div>

<div class="contact-page">

    <!-- Contact Form & Map Section -->
    <section class="contact-content py-5">
        <div class="container">
            <!-- Informations de contact -->
            <div class="contact-info-section mb-5">
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-3" data-aos="fade-up">
                        <div class="info-card text-center">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h5>Notre Adresse</h5>
                            <p class="text-muted">5366 Chem. de la côte des neiges<br>Montréal, QC, Canada</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="info-card text-center">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5>Téléphone</h5>
                            <p class="text-muted">+1 (438) 491-8227</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="info-card text-center">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5>Email</h5>
                            <p class="text-muted">choralemrda2025@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

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
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2794.8234056738347!2d-73.63079892415827!3d45.50196547107634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cc91a4c8c3b52e3%3A0x8b9b4b3e4b3e4b3e!2s5366%20Chem.%20de%20la%20C%C3%B4te-des-Neiges%2C%20Montr%C3%A9al%2C%20QC%20H3T%201Y8%2C%20Canada!5e0!3m2!1sfr!2sca!4v1699123456789!5m2!1sfr!2sca"
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
                                            Mardi & Vendredi<br>
                                            19h00 - 21h00
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-card" data-aos="zoom-in" data-aos-delay="400">
                                        <i class="fas fa-calendar text-primary mb-2"></i>
                                        <h6>Services dominicaux</h6>
                                        <p class="text-muted mb-0">
                                            Dimanche<br>
                                            10h00 & 17h00
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
                        La Chorale MRDA accueille tous ceux qui partagent la passion de la musique Réligieuse.
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

.contact-info-section {
    margin: 60px 0;
}

.info-card {
    background: white;
    border-radius: 15px;
    padding: 30px 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 2px solid transparent;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
    border-color: var(--primary-blue);
}

.icon-wrapper {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.info-card:hover .icon-wrapper {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
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
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
    transform: translateY(-1px);
}

.form-label {
    font-weight: 600;
    color: var(--dark-blue);
    margin-bottom: 8px;
}

.submit-btn {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 40px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.submit-btn::before {
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

.submit-btn:hover::before {
    width: 300px;
    height: 300px;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);
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
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}

.feature-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.feature-item i {
    font-size: 2.5rem;
    color: var(--primary-blue);
    margin-bottom: 15px;
}

.feature-item h6 {
    color: var(--dark-blue);
    font-weight: 600;
    margin-bottom: 15px;
}


/* Animations */
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
