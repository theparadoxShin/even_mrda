@extends('layouts.public')

@section('title', 'Paiement - ' . $registration->event->name)
@section('hero-title', 'Finaliser votre inscription')
@section('hero-subtitle', 'Dernière étape pour confirmer votre participation')

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
                    <div class="event-info">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="fw-bold text-primary mb-2">
                                    <i class="fas fa-ticket-alt me-2"></i>{{ $registration->event->name }}
                                </h5>
                                <p class="mb-1">
                                    <i class="fas fa-user me-2"></i>{{ $registration->full_name }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-envelope me-2"></i>{{ $registration->email }}
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-calendar me-2"></i>{{ $registration->event->event_date->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="price-highlight">
                                    ${{ number_format($registration->event->price, 2) }} CAD
                                </div>
                                <small class="text-muted">Prix de l'inscription</small>
                            </div>
                        </div>
                    </div>

                    <!-- Formulaire de paiement -->
                    <div class="card-form">
                        <h4 class="text-center mb-4 text-primary fw-bold">
                            <i class="fas fa-credit-card me-2"></i>Informations de paiement
                        </h4>

                        <!-- Méthodes de paiement -->
                        <div class="payment-methods mb-4">
                            <div class="payment-method selected" data-method="card">
                                <i class="fas fa-credit-card fa-2x mb-2"></i>
                                <span>Carte bancaire</span>
                            </div>
                            <div class="payment-method" data-method="interac">
                                <i class="fas fa-university fa-2x mb-2"></i>
                                <span>Interac</span>
                            </div>
                        </div>

                        <form id="payment-form">
                            @csrf
                            <div id="card-payment" class="payment-section">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-credit-card me-1"></i>Numéro de carte
                                    </label>
                                    <div id="card-number" class="form-control" style="height: 45px; padding: 10px;"></div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date d'expiration</label>
                                        <div id="card-expiry" class="form-control" style="height: 45px; padding: 10px;"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Code CVC</label>
                                        <div id="card-cvc" class="form-control" style="height: 45px; padding: 10px;"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="interac-payment" class="payment-section" style="display: none;">
                                <div class="text-center p-4">
                                    <i class="fas fa-university fa-3x text-primary mb-3"></i>
                                    <h5>Paiement par virement Interac</h5>
                                    <p class="text-muted">
                                        Vous serez redirigé vers votre banque pour effectuer le paiement sécurisé.
                                    </p>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" id="submit-payment" class="btn btn-primary-custom">
                                <span id="payment-text">
                                    <i class="fas fa-lock me-2"></i>Payer ${{ number_format($registration->event->price, 2) }} CAD
                                </span>
                                    <span id="payment-loading" style="display: none;">
                                    <span class="spinner-border spinner-border-sm me-2"></span>Traitement...
                                </span>
                                </button>
                            </div>
                        </form>

                        <!-- Sécurité -->
                        <div class="text-center mt-4">
                            <div class="d-flex justify-content-center align-items-center flex-wrap gap-3">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1 text-success"></i>
                                    Paiement sécurisé SSL
                                </small>
                                <small class="text-muted">
                                    <i class="fab fa-cc-visa me-1"></i>
                                    <i class="fab fa-cc-mastercard me-1"></i>
                                    Cartes acceptées
                                </small>
                                <small class="text-muted">
                                    Par <a href="https://parfaittedomtedom.com" target="_blank" class="text-primary">
                                        Parfait Tedom Tedom
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de succès -->
            <div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center p-5">
                            <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                            <h4 class="fw-bold text-success mb-3">Paiement réussi !</h4>
                            <p class="text-muted mb-4">
                                Votre inscription a été confirmée. Vous recevrez un email de confirmation avec votre QR code d'entrée.
                            </p>
                            <button type="button" class="btn btn-primary-custom" onclick="finish()">
                                <i class="fas fa-home me-2"></i>Vers l'accueil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();

        // Style pour les éléments Stripe
        const style = {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        };

        // Créer les éléments de carte
        const cardNumber = elements.create('cardNumber', {style});
        const cardExpiry = elements.create('cardExpiry', {style});
        const cardCvc = elements.create('cardCvc', {style});

        // Monter les éléments
        cardNumber.mount('#card-number');
        cardExpiry.mount('#card-expiry');
        cardCvc.mount('#card-cvc');

        // Gestion des méthodes de paiement
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                this.classList.add('selected');

                const methodType = this.getAttribute('data-method');
                if (methodType === 'card') {
                    document.getElementById('card-payment').style.display = 'block';
                    document.getElementById('interac-payment').style.display = 'none';
                } else {
                    document.getElementById('card-payment').style.display = 'none';
                    document.getElementById('interac-payment').style.display = 'block';
                }
            });
        });

        // Traitement du paiement
        document.getElementById('payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = document.getElementById('submit-payment');
            const paymentText = document.getElementById('payment-text');
            const paymentLoading = document.getElementById('payment-loading');

            // Désactiver le bouton et afficher le loading
            submitButton.disabled = true;
            paymentText.style.display = 'none';
            paymentLoading.style.display = 'inline-block';

            const selectedMethod = document.querySelector('.payment-method.selected').getAttribute('data-method');

            if (selectedMethod === 'card') {
                const {token, error} = await stripe.createToken(cardNumber);

                if (error) {
                    showError(error.message);
                    resetButton();
                } else {
                    processPayment(token.id);
                }
            } else {
                // Pour Interac, rediriger vers une page de paiement bancaire
                processInteracPayment();
            }
        });

        async function processPayment(paymentMethod) {
            try {
                const response = await fetch('{{ route('payment.process', $registration) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        payment_method: paymentMethod
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showSuccess();
                } else {
                    showError(result.error || 'Erreur lors du paiement');
                    resetButton();
                }
            } catch (error) {
                showError('Erreur de connexion');
                resetButton();
            }
        }

        function processInteracPayment() {
            // Simulation d'un paiement Interac - en réalité, vous devrez intégrer avec votre banque
            setTimeout(() => {
                showSuccess();
            }, 2000);
        }

        function showError(message) {
            alert('Erreur: ' + message);
        }

        function showSuccess() {
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();
        }

        function resetButton() {
            const submitButton = document.getElementById('submit-payment');
            const paymentText = document.getElementById('payment-text');
            const paymentLoading = document.getElementById('payment-loading');

            submitButton.disabled = false;
            paymentText.style.display = 'inline-block';
            paymentLoading.style.display = 'none';
        }

        function finish() {
            window.location.href = '{{ route("success") }}';
        }
    </script>
@endpush
