@extends('layouts.admin')

@section('title', 'Connexion Admin')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%) !important;
        }
        .navbar-custom, .sidebar {
            display: none;
        }
        .main-content {
            padding: 0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center"
         style="background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);">
        <div class="card card-custom" style="max-width: 400px; width: 100%;">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="icon-wrapper">
                        <img src="{{ asset('logo.png') }}" alt="MRDA Logo" class="img-fluid mb-3"
                             style="width: 80px; height: 80px;">
                    </div>
                    <h3 class="fw-bold text-primary">MRDA Admin</h3>
                    <p class="text-muted">Connectez-vous à votre compte</p>
                </div>

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
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
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection
