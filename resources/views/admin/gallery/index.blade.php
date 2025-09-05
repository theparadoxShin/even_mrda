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
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createGalleryModal">
                            <i class="fas fa-plus"></i> Ajouter une image
                        </button>
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
                                @foreach($categories as $cat)
                                    <option value="{{ strtolower($cat) }}">{{ ucfirst($cat) }}</option>
                                @endforeach
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
                                     data-category="{{ strtolower($image->category) }}"
                                     data-title="{{ strtolower($image->title) }}">
                                    <div class="card gallery-card">
                                        <div class="card-img-container">
                                            <img src="{{ $image->image_url }}"
                                                 class="card-img-top" alt="{{ $image->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                            <div class="img-overlay">
                                                <div class="img-actions">
                                                    <button class="btn btn-sm btn-light" onclick="viewImage('{{ $image->image_url }}', '{{ $image->title }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                            onclick="editImage({{ $image->id }}, {{ json_encode($image->title) }}, {{ json_encode($image->description) }}, {{ json_encode($image->category) }}, '{{ $image->event_date ? $image->event_date->format('Y-m-d') : '' }}', {{ $image->is_featured ? 'true' : 'false' }}, {{ $image->is_active ? 'true' : 'false' }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="deleteImage({{ $image->id }}, {{ json_encode($image->title) }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $image->title }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit($image->description, 60) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-info">{{ ucfirst($image->category ?? 'Général') }}</span>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGalleryModal">
                                <i class="fas fa-plus"></i> Ajouter une image
                            </button>
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
                            <select class="form-select" id="bulk_category" name="category">
                                <option value="Général">Général</option>
                                <option value="Concerts">Concerts</option>
                                <option value="Répétitions">Répétitions</option>
                                <option value="Événements">Événements</option>
                                <option value="Membres">Membres</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bulk_event_date" class="form-label">Date de l'événement</label>
                                <input type="date" class="form-control" id="bulk_event_date" name="event_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="bulk_is_active" name="is_active" checked>
                        <label class="form-check-label" for="bulk_is_active">
                            Images actives
                        </label>
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

<!-- Modal de création d'image galerie -->
<div class="modal fade" id="createGalleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image text-primary me-2"></i>Nouvelle image galerie
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createGalleryForm" action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Catégorie</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Sélectionner...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                    @endforeach
                                    <option value="Général">Général</option>
                                    <option value="Concerts">Concerts</option>
                                    <option value="Répétitions">Répétitions</option>
                                    <option value="Événements">Événements</option>
                                    <option value="Membres">Membres</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="event_date" class="form-label">Date de l'événement</label>
                        <input type="date" class="form-control" id="event_date" name="event_date">
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image *</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <div class="form-text">Formats acceptés : JPEG, PNG, JPG, GIF (max 10MB)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    Image mise en avant
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Actif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'édition d'image galerie -->
<div class="modal fade" id="editGalleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit text-warning me-2"></i>Modifier l'image galerie
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Titre *</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_category" class="form-label">Catégorie</label>
                                <select class="form-select" id="edit_category" name="category">
                                    <option value="">Sélectionner...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                    @endforeach
                                    <option value="Général">Général</option>
                                    <option value="Concerts">Concerts</option>
                                    <option value="Répétitions">Répétitions</option>
                                    <option value="Événements">Événements</option>
                                    <option value="Membres">Membres</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_event_date" class="form-label">Date de l'événement</label>
                        <input type="date" class="form-control" id="edit_event_date" name="event_date">
                    </div>

                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Nouvelle image (optionnelle)</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div class="form-text">Laissez vide pour conserver l'image actuelle. Formats acceptés : JPEG, PNG, JPG, GIF (max 10MB)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_featured" name="is_featured">
                                <label class="form-check-label" for="edit_is_featured">
                                    Image mise en avant
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                                <label class="form-check-label" for="edit_is_active">
                                    Actif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-2"></i>Mettre à jour
                    </button>
                </div>
            </form>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aperçu image
    window.viewImage = function(src, title) {
        document.getElementById('imageViewSrc').src = src;
        document.getElementById('imageViewTitle').textContent = title;
        new bootstrap.Modal(document.getElementById('imageViewModal')).show();
    };

    // Filtres
    document.getElementById('categoryFilter').addEventListener('change', filterImages);
    document.getElementById('searchInput').addEventListener('input', filterImages);

    function filterImages() {
        const category = document.getElementById('categoryFilter').value.toLowerCase();
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
                } else {
                    this.checked = !isActive;
                    console.error('Erreur toggle:', data);
                }
            })
            .catch(error => {
                console.error('Erreur toggle:', error);
                this.checked = !isActive;
            });
        });
    });

    // Fonction pour éditer une image
    window.editImage = function(id, title, description, category, eventDate, isFeatured, isActive) {
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_description').value = description || '';
        document.getElementById('edit_category').value = category || '';
        document.getElementById('edit_event_date').value = eventDate || '';

        document.getElementById('edit_is_featured').checked = isFeatured;
        document.getElementById('edit_is_active').checked = isActive;

        document.getElementById('editGalleryForm').dataset.imageId = id;

        new bootstrap.Modal(document.getElementById('editGalleryModal')).show();
    };

    // Fonction pour supprimer une image avec SweetAlert et AJAX
    window.deleteImage = function(id, title) {
        Swal.fire({
            title: 'Supprimer l\'image ?',
            text: `Voulez-vous vraiment supprimer l'image "${title}" ? Cette action est irréversible.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Suppression en cours...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => Swal.showLoading()
                });

                fetch(`/admin/gallery/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Supprimé !',
                            text: data.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Erreur !', data.message || 'Une erreur est survenue.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Erreur !', 'Une erreur de connexion est survenue.', 'error');
                });
            }
        });
    };

    // Gestionnaire AJAX pour le formulaire de création
    const createForm = document.getElementById('createGalleryForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...';

            fetch('{{ route("admin.gallery.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('createGalleryModal')).hide();

                    Swal.fire({
                        title: 'Succès !',
                        text: data.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });

                    this.reset();
                } else {
                    Swal.fire('Erreur !', data.message || 'Une erreur est survenue.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Erreur !', 'Une erreur de connexion est survenue.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }

    // Gestionnaire AJAX pour le formulaire d'édition
    const editForm = document.getElementById('editGalleryForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const imageId = this.dataset.imageId;
            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mise à jour...';

            fetch(`/admin/gallery/${imageId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editGalleryModal')).hide();

                    Swal.fire({
                        title: 'Succès !',
                        text: data.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Erreur !', data.message || 'Une erreur est survenue.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Erreur !', 'Une erreur de connexion est survenue.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});
</script>
@endpush
