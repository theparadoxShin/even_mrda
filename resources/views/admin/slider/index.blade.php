@extends('layouts.admin')

@section('title', 'Gestion du Slider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Images du Slider</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSliderModal">
                        <i class="fas fa-plus"></i> Ajouter une image
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($sliderImages->count() > 0)
                        <div class="row" id="sortable-slider">
                            @foreach($sliderImages as $image)
                                <div class="col-md-6 col-lg-4 mb-4" data-id="{{ $image->id }}">
                                    <div class="card slider-card">
                                        <div class="card-img-container">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                 class="card-img-top" alt="{{ $image->title }}"
                                                 style="height: 200px; object-fit: cover;">
                                            <div class="img-overlay">
                                                <div class="img-actions">
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                            onclick="editSlider({{ $image->id }}, {{ json_encode($image->title) }}, {{ json_encode($image->description) }}, {{ $image->order }}, {{ $image->is_active ? 'true' : 'false' }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="deleteSlider({{ $image->id }}, {{ json_encode($image->title) }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $image->title ?? 'Sans titre' }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit($image->description, 60) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-secondary">Ordre: {{ $image->order }}</span>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input status-toggle" type="checkbox"
                                                           data-id="{{ $image->id }}"
                                                           {{ $image->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label">
                                                        {{ $image->is_active ? 'Actif' : 'Inactif' }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
                                                <small class="text-muted">Glisser pour réorganiser</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune image dans le slider</h5>
                            <p class="text-muted">Commencez par ajouter votre première image au slider.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSliderModal">
                                <i class="fas fa-plus"></i> Ajouter une image
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de création d'image slider -->
<div class="modal fade" id="createSliderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-images text-primary me-2"></i>Nouvelle image slider
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createSliderForm" action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="order" class="form-label">Ordre</label>
                                <input type="number" class="form-control" id="order" name="order" value="0" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image *</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        <div class="form-text">Formats acceptés : JPEG, PNG, JPG, GIF (max 5MB)</div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Actif
                        </label>
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

<!-- Modal d'édition d'image slider -->
<div class="modal fade" id="editSliderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit text-warning me-2"></i>Modifier l'image slider
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSliderForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="edit_title" name="title">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_order" class="form-label">Ordre</label>
                                <input type="number" class="form-control" id="edit_order" name="order" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Nouvelle image (optionnelle)</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div class="form-text">Laissez vide pour conserver l'image actuelle. Formats acceptés : JPEG, PNG, JPG, GIF (max 5MB)</div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">
                            Actif
                        </label>
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
.slider-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.slider-card:hover {
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
    margin: 0 5px;
}

.status-toggle {
    cursor: pointer;
}

#sortable-slider .col-md-6 {
    cursor: move;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tri par glisser-déposer
    new Sortable(document.getElementById('sortable-slider'), {
        animation: 150,
        onEnd: function () {
            const orders = {};
            const items = document.querySelectorAll('#sortable-slider > div[data-id]');

            items.forEach((item, index) => {
                const id = item.dataset.id;
                orders[id] = index + 1;
            });

            fetch('{{ route("admin.slider.update-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ orders: orders })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    items.forEach((item, index) => {
                        const badge = item.querySelector('.badge');
                        badge.textContent = 'Ordre: ' + (index + 1);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                location.reload();
            });
        }
    });

    // Toggle status
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            const isActive = this.checked;

            fetch(`/admin/slider/${id}/toggle-status`, {
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

    // Fonction pour éditer un slider
    window.editSlider = function(id, title, description, order, isActive) {
        document.getElementById('edit_title').value = title || '';
        document.getElementById('edit_description').value = description || '';
        document.getElementById('edit_order').value = order;
        document.getElementById('edit_is_active').checked = isActive;

        document.getElementById('editSliderForm').dataset.sliderId = id;

        new bootstrap.Modal(document.getElementById('editSliderModal')).show();
    };

    // Fonction pour supprimer un slider avec SweetAlert et AJAX
    window.deleteSlider = function(id, title) {
        Swal.fire({
            title: 'Supprimer l\'image ?',
            text: `Voulez-vous vraiment supprimer l'image "${title || 'cette image'}" ? Cette action est irréversible.`,
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

                fetch(`/admin/slider/${id}`, {
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
    const createForm = document.getElementById('createSliderForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...';

            fetch('{{ route("admin.slider.store") }}', {
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
                    bootstrap.Modal.getInstance(document.getElementById('createSliderModal')).hide();

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
    const editForm = document.getElementById('editSliderForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const sliderId = this.dataset.sliderId;
            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mise à jour...';

            fetch(`/admin/slider/${sliderId}`, {
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
                    bootstrap.Modal.getInstance(document.getElementById('editSliderModal')).hide();

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
