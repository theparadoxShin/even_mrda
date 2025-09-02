@extends('layouts.admin')

@section('title', 'Gestion de la Galerie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Images de la Galerie</h3>
                    <div>
                        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Ajouter une image
                        </a>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkUploadModal">
                            <i class="fas fa-upload"></i> Upload en masse
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filtres -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <select id="categoryFilter" class="form-select">
                                <option value="">Toutes les catégories</option>
                                <option value="concerts">Concerts</option>
                                <option value="repetitions">Répétitions</option>
                                <option value="evenements">Événements</option>
                                <option value="membres">Membres</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par titre...">
                        </div>
                    </div>

                    @if($galleryImages->count() > 0)
                        <div class="row gallery-grid">
                            @foreach($galleryImages as $image)
                                <div class="col-md-6 col-lg-3 mb-4 gallery-item"
                                     data-category="{{ $image->category }}"
                                     data-title="{{ strtolower($image->title) }}">
                                    <div class="card gallery-card">
                                        <div class="card-img-container">
                                            <img src="{{ asset('images/' . basename($image->image_path)) }}"
                                                 class="card-img-top" alt="{{ $image->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                            <div class="img-overlay">
                                                <div class="img-actions">
                                                    <button class="btn btn-sm btn-light" onclick="viewImage('{{ asset('images/' . basename($image->image_path)) }}', '{{ $image->title }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="{{ route('admin.gallery.edit', $image) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.gallery.destroy', $image) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $image->title }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit($image->description, 60) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-info">{{ ucfirst($image->category) }}</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                           data-id="{{ $image->id }}"
                                                           {{ $image->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label small">
                                                        {{ $image->is_active ? 'Actif' : 'Inactif' }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $galleryImages->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-photo-video fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune image dans la galerie</h5>
                            <p class="text-muted">Commencez par ajouter votre première image à la galerie.</p>
                            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter une image
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload en masse -->
<div class="modal fade" id="bulkUploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload en masse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.gallery.bulk-upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulk_images" class="form-label">Sélectionnez plusieurs images</label>
                        <input type="file" class="form-control" id="bulk_images" name="images[]" multiple accept="image/*" required>
                        <div class="form-text">Vous pouvez sélectionner plusieurs images à la fois.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="bulk_category" class="form-label">Catégorie</label>
                            <select class="form-select" id="bulk_category" name="category" required>
                                <option value="concerts">Concerts</option>
                                <option value="repetitions">Répétitions</option>
                                <option value="evenements">Événements</option>
                                <option value="membres">Membres</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="bulk_is_active" name="is_active" checked>
                                <label class="form-check-label" for="bulk_is_active">
                                    Images actives
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload"></i> Uploader les images
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Aperçu Image -->
<div class="modal fade" id="imageViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageViewTitle">Aperçu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imageViewSrc" src="" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.gallery-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.card-img-container {
    position: relative;
    overflow: hidden;
}

.img-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-img-container:hover .img-overlay {
    opacity: 1;
}

.img-actions .btn {
    margin: 0 3px;
}

.status-toggle {
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
// Aperçu image
function viewImage(src, title) {
    document.getElementById('imageViewSrc').src = src;
    document.getElementById('imageViewTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('imageViewModal')).show();
}

// Filtres
document.getElementById('categoryFilter').addEventListener('change', filterImages);
document.getElementById('searchInput').addEventListener('input', filterImages);

function filterImages() {
    const category = document.getElementById('categoryFilter').value;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.gallery-item');

    items.forEach(item => {
        const itemCategory = item.dataset.category;
        const itemTitle = item.dataset.title;

        const categoryMatch = !category || itemCategory === category;
        const searchMatch = !search || itemTitle.includes(search);

        if (categoryMatch && searchMatch) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

// Toggle status
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const id = this.dataset.id;
        const isActive = this.checked;

        fetch(`/admin/gallery/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ is_active: isActive })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const label = this.nextElementSibling;
                label.textContent = isActive ? 'Actif' : 'Inactif';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            this.checked = !isActive;
        });
    });
});
</script>
@endpush
