@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 fw-bold text-primary">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </h1>
            <p class="text-muted">Gérez vos événements et inscriptions</p>
        </div>
    </div>

    <!-- Bouton Créer un événement -->
    <div class="row mb-4">
        <div class="col-12">
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createEventModal">
                <i class="fas fa-plus me-2"></i>Créer un nouvel événement
            </button>
        </div>
    </div>

    <!-- Liste des événements -->
    <div class="row">
        @forelse($events as $event)
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card card-custom h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>{{ $event->name }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-dollar-sign me-1"></i>Prix:</span>
                                <span class="fw-bold text-primary">${{ number_format($event->price, 2) }} CAD</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span><i class="fas fa-clock me-1"></i>Date:</span>
                                <span>{{ $event->event_date->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <!-- Statistiques -->
                        <div class="row text-center mb-3">
                            <div class="col-6">
                                <div class="stats-card p-3 rounded">
                                    <div class="fw-bold text-success fs-4">{{ $event->paid_registrations }}</div>
                                    <small class="text-muted">Payés</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stats-card p-3 rounded">
                                    <div class="fw-bold text-danger fs-4">{{ $event->unpaid_registrations }}</div>
                                    <small class="text-muted">Non payés</small>
                                </div>
                            </div>
                        </div>

                        <!-- Actions QR -->
                        <div class="qr-actions mb-3">
                            @if($event->qr_code)
                                <a href="{{ route('admin.events.qr.download', $event) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-download me-1"></i>Télécharger QR
                                </a>
                                <button type="button"
                                        class="btn btn-outline-success btn-sm"
                                        onclick="shareWhatsApp({{ $event->id }})">
                                    <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                </button>
                                <button type="button"
                                        class="btn btn-outline-info btn-sm"
                                        onclick="printQR('{{ $event->qr_code }}')">
                                    <i class="fas fa-print me-1"></i>Imprimer
                                </button>
                            @endif
                        </div>

                        <!-- Lien vers les inscriptions -->
                        <a href="{{ route('admin.events.registrations', $event) }}"
                           class="btn btn-primary-custom w-100">
                            <i class="fas fa-users me-2"></i>Voir les inscriptions
                        </a>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <small>
                            <i class="fas fa-link me-1"></i>
                            <a href="{{ route('event.register', $event) }}" target="_blank" class="text-decoration-none">
                                Lien d'inscription
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-custom text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Aucun événement créé</h4>
                        <p class="text-muted">Commencez par créer votre premier événement</p>
                        <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createEventModal">
                            <i class="fas fa-plus me-2"></i>Créer un événement
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Modal Créer Événement -->
    <div class="modal fade" id="createEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Créer un nouvel événement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.events.create') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de l'événement</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix (CAD)</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="event_date" class="form-label">Date et heure</label>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-save me-2"></i>Créer l'événement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function shareWhatsApp(eventId) {
            fetch(`/admin/events/${eventId}/whatsapp`)
                .then(response => response.json())
                .then(data => {
                    window.open(data.url, '_blank');
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la génération du lien WhatsApp');
                });
        }

        function printQR(qrCode) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
        <html lang="fr">
            <head>
                <title>QR Code - Chorale</title>
                <style>
                    body {
                        text-align: center;
                        padding: 20px;
                        font-family: Arial, sans-serif;
                    }
                    img {
                        max-width: 300px;
                        margin: 20px 0;
                    }
                    h1 {
                        color: #2563eb;
                        margin-bottom: 30px;
                    }
                </style>
            </head>
            <body>
                <h1>Code QR - Inscription Chorale</h1>
                <img src="/storage/qrcodes/${qrCode}" alt="QR Code">
                <p>Scannez ce code pour vous inscrire à l'événement</p>
            </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endpush
