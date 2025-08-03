@extends('layouts.admin')

@section('title', 'Inscriptions - ' . $event->name)

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Inscriptions</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-primary">
                <i class="fas fa-users me-2"></i>Inscriptions - {{ $event->name }}
            </h1>
            <p class="text-muted">{{ $event->description }}</p>
        </div>
    </div>

    <!-- Informations de l'événement -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h4 class="fw-bold">{{ $registrations->count() }}</h4>
                    <small class="text-muted">Total inscriptions</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h4 class="fw-bold text-success">{{ $registrations->where('payment_status', 'paye')->count() }}</h4>
                    <small class="text-muted">Payés</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h4 class="fw-bold text-warning">{{ $registrations->where('payment_status', 'non_paye')->count() }}</h4>
                    <small class="text-muted">En attente</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body text-center">
                    <i class="fas fa-dollar-sign fa-2x text-info mb-2"></i>
                    <h4 class="fw-bold text-info">${{ number_format($event->price * $registrations->where('payment_status', 'paye')->count(), 2) }}</h4>
                    <small class="text-muted">Revenus CAD</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Table des inscriptions -->
    <div class="card card-custom">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Liste des inscriptions
            </h5>
        </div>
        <div class="card-body p-0">
            @if($registrations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                        <tr>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Statut</th>
                            <th>Date inscription</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($registrations as $registration)
                            <tr>
                                <td class="fw-bold">{{ $registration->full_name }}</td>
                                <td>{{ $registration->email }}</td>
                                <td>{{ $registration->phone }}</td>
                                <td>
                                    @if($registration->payment_status === 'paye')
                                        <span class="badge badge-custom badge-paid">
                                            <i class="fas fa-check me-1"></i>Payé
                                        </span>
                                    @else
                                        <span class="badge badge-custom badge-unpaid">
                                            <i class="fas fa-clock me-1"></i>Non payé
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($registration->payment_status === 'non_paye')
                                        <form method="POST"
                                              action="{{ route('admin.registrations.payment', $registration) }}"
                                              class="d-inline"
                                              onsubmit="return confirm('Confirmer le changement de statut à Payé?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check me-1"></i>Marquer payé
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>Confirmé
                                        </span>
                                        @if($registration->confirmation_qr)
                                            <a href="/storage/confirmations/{{ $registration->confirmation_qr }}"
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm ms-2">
                                                <i class="fas fa-qrcode me-1"></i>QR
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune inscription</h4>
                    <p class="text-muted">Les inscriptions apparaîtront ici une fois que les participants s'inscriront.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
