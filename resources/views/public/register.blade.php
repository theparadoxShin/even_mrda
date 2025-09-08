@extends('layouts.public')

@section('title', 'Inscription - ' . $event->name)
@section('hero-title', $event->name)
@section('hero-subtitle', 'Inscrivez-vous à cet événement')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>@yield('hero-title')</h1>
            <p>@yield('hero-subtitle')</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Informations de l'événement -->
                    <div class="event-info text-center">
                        <h3 class="fw-bold text-primary mb-3">
                            <i class="fas fa-calendar-alt me-2"></i>{{ $event->name }}
                        </h3>
                        <p class="mb-3">{{ $event->description }}</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-clock me-2 text-primary"></i>
                                    <span>{{ $event->event_date->format('d/m/Y à H:i') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-dollar-sign me-2 text-primary"></i>
                                    <span class="price-highlight">
                                        @if($event->price > 0)
                                            ${{ number_format($event->price, 2) }} CAD
                                        @else
                                            Gratuit
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <i class="fas fa-music me-2 text-primary"></i>
                                    <span>Événement musical</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire d'inscription -->
                    <div class="card-form">
                        <h4 class="text-center mb-4 text-primary fw-bold">
                            <i class="fas fa-user-plus me-2"></i>Formulaire d'inscription
                        </h4>

                        <form method="POST" action="{{ route('event.register.store', $event) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>Prénom
                                    </label>
                                    <input type="text"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name"
                                           name="first_name"
                                           value="{{ old('first_name') }}"
                                           required>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>Nom
                                    </label>
                                    <input type="text"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name"
                                           name="last_name"
                                           value="{{ old('last_name') }}"
                                           required>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Adresse email
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Numéro de téléphone
                                </label>
                                <input type="tel"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="(514) 123-4567"
                                       required>
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" id="submit-register" class="btn btn-primary-custom">
                                    <span id="register-text">
                                        <i class="fas fa-check me-2"></i>Valider l'inscription et payer
                                    </span>
                                    <span id="register-loading" style="display: none;">
                                        <span class="spinner-border spinner-border-sm me-2"></span>Traitement...
                                    </span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- Informations complémentaires -->
                    <div class="text-center mt-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">Inscription sécurisée</h6>
                                <small class="text-muted">Vos données sont protégées</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-credit-card fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">Moyens de paiement</h6>
                                <small class="text-muted">Interac pour le moment</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-envelope-open fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold">Confirmation</h6>
                                <small class="text-muted">Confirmation par email</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitButton = document.getElementById('submit-register');
        const registerText = document.getElementById('register-text');
        const registerLoading = document.getElementById('register-loading');

        if (form && submitButton && registerText && registerLoading) {
            form.addEventListener('submit', function(e) {
                // Use native validation UI
                if (!form.reportValidity()) {
                    return;
                }

                // Prevent immediate navigation to let the spinner render
                e.preventDefault();

                // Show loading state
                registerText.style.display = 'none';
                registerLoading.style.display = 'inline-flex';
                submitButton.disabled = true;
                submitButton.style.opacity = '0.7';

                // Defer actual submit to next tick so browser paints the spinner
                setTimeout(() => form.submit(), 50);
            }, { once: false });
        }

        // Reset button state if user navigates back with bfcache
        window.addEventListener('pageshow', function(e) {
            if (e.persisted && submitButton && registerText && registerLoading) {
                registerText.style.display = 'inline';
                registerLoading.style.display = 'none';
                submitButton.disabled = false;
                submitButton.style.opacity = '1';
            }
        });
    });
</script>
@endpush
