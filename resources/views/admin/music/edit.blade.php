@extends('layouts.admin')

@section('title', 'Modifier la Piste Musicale')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier : {{ $musicTrack->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.music.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Aperçu du fichier audio actuel -->
                    @if($musicTrack->file_path && Storage::disk('public')->exists($musicTrack->file_path))
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-music"></i>
                                    <strong>Fichier audio actuel :</strong>
                                    {{ basename($musicTrack->file_path) }}
                                    @if($musicTrack->duration)
                                        <span class="badge bg-secondary ms-2">{{ gmdate('i:s', $musicTrack->duration) }}</span>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                        onclick="playCurrentTrack()">
                                    <i class="fas fa-play"></i> Écouter
                                </button>
                            </div>
                            <audio id="currentTrackPlayer" style="width: 100%; margin-top: 10px;" controls>
                                <source src="{{ asset('storage/' . $musicTrack->file_path) }}" type="audio/mpeg">
                                Votre navigateur ne supporte pas l'élément audio.
                            </audio>
                        </div>
                    @endif

                    <form action="{{ route('admin.music.update', $musicTrack) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $musicTrack->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="composer" class="form-label">Compositeur</label>
                                    <input type="text" class="form-control @error('composer') is-invalid @enderror"
                                           id="composer" name="composer" value="{{ old('composer', $musicTrack->composer) }}">
                                    @error('composer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre</label>
                                    <select class="form-select @error('genre') is-invalid @enderror" id="genre" name="genre">
                                        <option value="Religieux" {{ old('genre', $musicTrack->genre) == 'Religieux' ? 'selected' : '' }}>Religieux</option>
                                        <option value="Gospel" {{ old('genre', $musicTrack->genre) == 'Gospel' ? 'selected' : '' }}>Gospel</option>
                                        <option value="Spiritual" {{ old('genre', $musicTrack->genre) == 'Spiritual' ? 'selected' : '' }}>Spiritual</option>
                                        <option value="Hymne" {{ old('genre', $musicTrack->genre) == 'Hymne' ? 'selected' : '' }}>Hymne</option>
                                        <option value="Psaume" {{ old('genre', $musicTrack->genre) == 'Psaume' ? 'selected' : '' }}>Psaume</option>
                                        <option value="Cantique" {{ old('genre', $musicTrack->genre) == 'Cantique' ? 'selected' : '' }}>Cantique</option>
                                        <option value="Autre" {{ old('genre', $musicTrack->genre) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('genre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Ordre d'affichage</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                           id="order" name="order" value="{{ old('order', $musicTrack->order) }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4">{{ old('description', $musicTrack->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="audio_file" class="form-label">Nouveau fichier Audio (optionnel)</label>
                            <input type="file" class="form-control @error('audio_file') is-invalid @enderror"
                                   id="audio_file" name="audio_file" accept=".mp3,.wav,.m4a,.aac">
                            <div class="form-text">
                                Laissez vide pour conserver le fichier actuel. Formats acceptés : MP3, WAV, M4A, AAC. Taille maximum : 20 MB.
                            </div>
                            @error('audio_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active"
                                               name="is_active" {{ old('is_active', $musicTrack->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Piste active
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_featured"
                                               name="is_featured" {{ old('is_featured', $musicTrack->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Piste vedette
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_background"
                                               name="is_background" {{ old('is_background', $musicTrack->is_background) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_background">
                                            Musique de fond
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        Sera jouée automatiquement en arrière-plan sur le site.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.music.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour la piste
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function playCurrentTrack() {
    const player = document.getElementById('currentTrackPlayer');
    if (player.paused) {
        player.play();
    } else {
        player.pause();
    }
}

document.getElementById('audio_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileSize = file.size / (1024 * 1024); // en MB
        if (fileSize > 20) {
            alert('Le fichier est trop volumineux. La taille maximum est de 20 MB.');
            e.target.value = '';
        }
    }
});
</script>
@endpush
