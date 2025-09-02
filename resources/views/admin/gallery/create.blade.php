@extends('layouts.admin')

@section('title', 'Ajouter une image à la galerie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ajouter une nouvelle image à la galerie</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
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

                    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                        <option value="">Choisir une catégorie</option>
                                        <option value="concerts" {{ old('category') == 'concerts' ? 'selected' : '' }}>Concerts</option>
                                        <option value="repetitions" {{ old('category') == 'repetitions' ? 'selected' : '' }}>Répétitions</option>
                                        <option value="evenements" {{ old('category') == 'evenements' ? 'selected' : '' }}>Événements</option>
                                        <option value="membres" {{ old('category') == 'membres' ? 'selected' : '' }}>Membres</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Décrivez cette image...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*" required>
                            <div class="form-text">
                                Formats acceptés : JPG, JPEG, PNG, GIF. Taille recommandée : 1200x800px minimum.
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Aperçu de l'image -->
                        <div class="mb-3" id="image-preview" style="display: none;">
                            <label class="form-label">Aperçu</label>
                            <div class="border rounded p-3 text-center">
                                <img id="preview-img" src="" alt="Aperçu" class="img-fluid" style="max-height: 300px;">
                                <div class="mt-2">
                                    <small class="text-muted" id="image-info"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alt_text" class="form-label">Texte alternatif</label>
                                    <input type="text" class="form-control @error('alt_text') is-invalid @enderror"
                                           id="alt_text" name="alt_text" value="{{ old('alt_text') }}"
                                           placeholder="Description pour l'accessibilité">
                                    <div class="form-text">Texte affiché si l'image ne peut pas être chargée (SEO).</div>
                                    @error('alt_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Ordre d'affichage</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                           id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active"
                                       name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Image active
                                </label>
                                <div class="form-text">Les images inactives ne seront pas affichées dans la galerie publique.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer l'image
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
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Vérifier la taille du fichier (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('Le fichier est trop volumineux. Taille maximum : 5MB.');
            this.value = '';
            document.getElementById('image-preview').style.display = 'none';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';

            // Afficher les informations du fichier
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            document.getElementById('image-info').textContent =
                `Nom: ${file.name} | Taille: ${fileSize} MB | Type: ${file.type}`;

            // Auto-remplir le texte alternatif si vide
            const altTextInput = document.getElementById('alt_text');
            if (!altTextInput.value) {
                altTextInput.value = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, ' ');
            }
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('image-preview').style.display = 'none';
    }
});

// Auto-générer le titre à partir du nom de fichier si le titre est vide
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const titleInput = document.getElementById('title');

    if (file && !titleInput.value) {
        const fileName = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, ' ');
        titleInput.value = fileName.charAt(0).toUpperCase() + fileName.slice(1);
    }
});
</script>
@endpush
