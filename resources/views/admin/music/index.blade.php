@extends('layouts.admin')

@section('title', 'Gestion des Pistes Musicales')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pistes Musicales</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMusicModal">
                        <i class="fas fa-plus"></i> Ajouter une piste
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($musicTracks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped" id="musicTable">
                                <thead>
                                    <tr>
                                        <th>Ordre</th>
                                        <th>Titre</th>
                                        <th>Compositeur</th>
                                        <th>Genre</th>
                                        <th>Durée</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable-tracks">
                                    @foreach($musicTracks as $track)
                                        <tr data-id="{{ $track->id }}">
                                            <td>
                                                <span class="badge bg-secondary">{{ $track->order }}</span>
                                                <i class="fas fa-grip-vertical ms-2 text-muted" style="cursor: move;"></i>
                                            </td>
                                            <td>
                                                <strong>{{ $track->title }}</strong>
                                                @if($track->is_featured)
                                                    <span class="badge bg-warning ms-1">Vedette</span>
                                                @endif
                                                @if($track->is_background)
                                                    <span class="badge bg-info ms-1">Fond</span>
                                                @endif
                                            </td>
                                            <td>{{ $track->composer ?? 'Non spécifié' }}</td>
                                            <td>{{ $track->genre }}</td>
                                            <td>
                                                @if($track->duration)
                                                    {{ gmdate('i:s', $track->duration) }}
                                                @else
                                                    <span class="text-muted">Non calculée</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($track->is_active)
                                                    <span class="badge bg-success">Actif</span>
                                                @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if($track->file_path)
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                                onclick="playTrack('{{ asset('storage/' . $track->file_path) }}', '{{ $track->title }}')">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="editTrack({{ $track->id }}, {{ json_encode($track->title) }}, {{ json_encode($track->composer) }}, {{ json_encode($track->genre) }}, {{ json_encode($track->description) }}, {{ $track->order }}, {{ $track->is_featured ? 'true' : 'false' }}, {{ $track->is_background ? 'true' : 'false' }}, {{ $track->is_active ? 'true' : 'false' }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if(!$track->is_background)
                                                        <form action="{{ route('admin.music.set-background', $track) }}"
                                                              method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-info"
                                                                    title="Définir comme musique de fond">
                                                                <i class="fas fa-volume-up"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                            onclick="deleteTrack({{ $track->id }}, {{ json_encode($track->title) }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $musicTracks->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-music fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune piste musicale</h5>
                            <p class="text-muted">Commencez par ajouter votre première piste musicale.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMusicModal">
                                <i class="fas fa-plus"></i> Ajouter une piste
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Audio Player Modal -->
<div class="modal fade" id="audioPlayerModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="audioPlayerTitle">Lecture audio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <audio id="audioPlayer" controls style="width: 100%;">
                    Votre navigateur ne supporte pas l'élément audio.
                </audio>
            </div>
        </div>
    </div>
</div>

<!-- Modal de création de piste musicale -->
<div class="modal fade" id="createMusicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-music text-primary me-2"></i>Nouvelle piste musicale
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createMusicForm" action="{{ route('admin.music.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre *</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="composer" class="form-label">Compositeur</label>
                                <input type="text" class="form-control" id="composer" name="composer">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre</label>
                                <input type="text" class="form-control" id="genre" name="genre" value="Religieux">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <label for="audio_file" class="form-label">Fichier audio *</label>
                        <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio/*" required>
                        <div class="form-text">Formats acceptés : MP3, WAV, M4A, AAC (max 20MB)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    Mise en avant
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_background" name="is_background">
                                <label class="form-check-label" for="is_background">
                                    Musique de fond
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
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

<!-- Modal d'édition de piste musicale -->
<div class="modal fade" id="editMusicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit text-warning me-2"></i>Modifier la piste musicale
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editMusicForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_title" class="form-label">Titre *</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_composer" class="form-label">Compositeur</label>
                                <input type="text" class="form-control" id="edit_composer" name="composer">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_genre" class="form-label">Genre</label>
                                <input type="text" class="form-control" id="edit_genre" name="genre">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <label for="edit_audio_file" class="form-label">Nouveau fichier audio (optionnel)</label>
                        <input type="file" class="form-control" id="edit_audio_file" name="audio_file" accept="audio/*">
                        <div class="form-text">Laissez vide pour conserver le fichier actuel. Formats acceptés : MP3, WAV, M4A, AAC (max 20MB)</div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_featured" name="is_featured">
                                <label class="form-check-label" for="edit_is_featured">
                                    Mise en avant
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_background" name="is_background">
                                <label class="form-check-label" for="edit_is_background">
                                    Musique de fond
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour jouer une piste
    window.playTrack = function(url, title) {
        document.getElementById('audioPlayerTitle').textContent = title;
        const audioPlayer = document.getElementById('audioPlayer');
        audioPlayer.src = url;

        new bootstrap.Modal(document.getElementById('audioPlayerModal')).show();
    };

    // Tri par glisser-déposer
    new Sortable(document.getElementById('sortable-tracks'), {
        animation: 150,
        handle: '.fa-grip-vertical',
        onEnd: function () {
            const orders = {};
            const rows = document.querySelectorAll('#sortable-tracks tr');

            rows.forEach((row, index) => {
                const id = row.dataset.id;
                orders[id] = index + 1;
            });

            fetch('{{ route("admin.music.update-order") }}', {
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
                    rows.forEach((row, index) => {
                        const badge = row.querySelector('.badge');
                        badge.textContent = index + 1;
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                location.reload();
            });
        }
    });

    // Fonction pour éditer une piste
    window.editTrack = function(id, title, composer, genre, description, order, isFeatured, isBackground, isActive) {
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_composer').value = composer || '';
        document.getElementById('edit_genre').value = genre || '';
        document.getElementById('edit_description').value = description || '';
        document.getElementById('edit_order').value = order;

        document.getElementById('edit_is_featured').checked = isFeatured;
        document.getElementById('edit_is_background').checked = isBackground;
        document.getElementById('edit_is_active').checked = isActive;

        document.getElementById('editMusicForm').dataset.musicId = id;

        new bootstrap.Modal(document.getElementById('editMusicModal')).show();
    };

    // Fonction pour supprimer une piste avec SweetAlert et AJAX
    window.deleteTrack = function(id, title) {
        Swal.fire({
            title: 'Supprimer la piste ?',
            text: `Voulez-vous vraiment supprimer la piste "${title}" ? Cette action est irréversible.`,
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

                fetch(`/admin/music/${id}`, {
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
    const createForm = document.getElementById('createMusicForm');
    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...';

            fetch('{{ route("admin.music.store") }}', {
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
                    bootstrap.Modal.getInstance(document.getElementById('createMusicModal')).hide();

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
    const editForm = document.getElementById('editMusicForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const musicId = this.dataset.musicId;
            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mise à jour...';

            fetch(`/admin/music/${musicId}`, {
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
                    bootstrap.Modal.getInstance(document.getElementById('editMusicModal')).hide();

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

<style>
/* Animation pour les rangées du tableau */
tbody tr {
    transition: all 0.3s ease;
}

tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* Style pour les badges */
.badge {
    font-size: 0.75em;
    font-weight: 500;
}

/* Style pour le drag handle */
.fa-grip-vertical:hover {
    color: #0d6efd !important;
    cursor: move;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-sm {
    padding: 0.375rem 0.5rem;
}
</style>
@endpush
