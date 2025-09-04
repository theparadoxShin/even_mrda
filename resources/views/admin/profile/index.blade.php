@extends('layouts.admin')

@section('title', 'Configuration & Profil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog me-2"></i>Configuration & Profil Administrateur
                    </h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Profil Administrateur -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-user-shield me-2"></i>Mon Profil Administrateur
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.profile.update') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nom complet</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <hr>
                                        <h6 class="text-muted mb-3">Changer le mot de passe (optionnel)</h6>

                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                                   id="current_password" name="current_password">
                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                                   id="new_password" name="new_password">
                                            @error('new_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                            <input type="password" class="form-control"
                                                   id="new_password_confirmation" name="new_password_confirmation">
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-save me-2"></i>Mettre à jour mon profil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration du Site -->
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-globe me-2"></i>Configuration du Site
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.profile.update-site-config') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">Nom du site</label>
                                            <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                                                   id="site_name" name="site_name"
                                                   value="{{ old('site_name', $siteConfig['site_name']) }}" required>
                                            @error('site_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="contact_email" class="form-label">Email de contact</label>
                                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror"
                                                           id="contact_email" name="contact_email"
                                                           value="{{ old('contact_email', $siteConfig['contact_email']) }}" required>
                                                    @error('contact_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="contact_phone" class="form-label">Téléphone</label>
                                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror"
                                                           id="contact_phone" name="contact_phone"
                                                           value="{{ old('contact_phone', $siteConfig['contact_phone']) }}" required>
                                                    @error('contact_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Adresse</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                      id="address" name="address" rows="2" required>{{ old('address', $siteConfig['address']) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <h6 class="text-muted mb-3">Réseaux sociaux</h6>

                                        <div class="mb-3">
                                            <label for="facebook_url" class="form-label">
                                                <i class="fab fa-facebook text-primary me-2"></i>Facebook
                                            </label>
                                            <input type="url" class="form-control @error('facebook_url') is-invalid @enderror"
                                                   id="facebook_url" name="facebook_url"
                                                   value="{{ old('facebook_url', $siteConfig['facebook_url']) }}">
                                            @error('facebook_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="instagram_url" class="form-label">
                                                <i class="fab fa-instagram text-danger me-2"></i>Instagram
                                            </label>
                                            <input type="url" class="form-control @error('instagram_url') is-invalid @enderror"
                                                   id="instagram_url" name="instagram_url"
                                                   value="{{ old('instagram_url', $siteConfig['instagram_url']) }}">
                                            @error('instagram_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="youtube_url" class="form-label">
                                                <i class="fab fa-youtube text-danger me-2"></i>YouTube
                                            </label>
                                            <input type="url" class="form-control @error('youtube_url') is-invalid @enderror"
                                                   id="youtube_url" name="youtube_url"
                                                   value="{{ old('youtube_url', $siteConfig['youtube_url']) }}">
                                            @error('youtube_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-save me-2"></i>Mettre à jour la configuration
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>Informations du système
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="stat-item text-center">
                                                <i class="fas fa-images fa-2x text-primary mb-2"></i>
                                                <h6>Images Slider</h6>
                                                <span class="badge bg-primary">{{ \App\Models\SliderImage::count() }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-item text-center">
                                                <i class="fas fa-photo-video fa-2x text-success mb-2"></i>
                                                <h6>Images Galerie</h6>
                                                <span class="badge bg-success">{{ \App\Models\GalleryImage::count() }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-item text-center">
                                                <i class="fas fa-music fa-2x text-warning mb-2"></i>
                                                <h6>Pistes Musicales</h6>
                                                <span class="badge bg-warning">{{ \App\Models\MusicTrack::count() }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-item text-center">
                                                <i class="fas fa-calendar fa-2x text-danger mb-2"></i>
                                                <h6>Événements</h6>
                                                <span class="badge bg-danger">{{ \App\Models\Event::count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Note importante -->
                    <div class="alert alert-warning mt-4">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Information importante :</h6>
                        <p class="mb-0">
                            Les modifications de configuration (email, téléphone, adresse) seront automatiquement
                            répercutées sur tout le site web (footer, page contact, etc.).
                            Assurez-vous que les informations sont correctes avant de sauvegarder.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.stat-item {
    padding: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.card-header h5 {
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.btn {
    font-weight: 600;
}
</style>
@endpush
