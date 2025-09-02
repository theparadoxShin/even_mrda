@extends('layouts.admin')

@section('title', 'Gestion des Pistes Musicales')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pistes Musicales</h3>
                    <a href="{{ route('admin.music.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter une piste
                    </a>
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
                                                    <a href="{{ route('admin.music.edit', $track) }}"
                                                       class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
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
                                                    <form action="{{ route('admin.music.destroy', $track) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette piste ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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
                            <a href="{{ route('admin.music.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter une piste
                            </a>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Fonction pour jouer une piste
function playTrack(url, title) {
    document.getElementById('audioPlayerTitle').textContent = title;
    const audioPlayer = document.getElementById('audioPlayer');
    audioPlayer.src = url;

    const modal = new bootstrap.Modal(document.getElementById('audioPlayerModal'));
    modal.show();
}

// Tri par glisser-déposer
document.addEventListener('DOMContentLoaded', function() {
    const sortable = new Sortable(document.getElementById('sortable-tracks'), {
        animation: 150,
        handle: '.fa-grip-vertical',
        onEnd: function (evt) {
            const orders = {};
            const rows = document.querySelectorAll('#sortable-tracks tr');

            rows.forEach((row, index) => {
                const id = row.dataset.id;
                orders[id] = index + 1;
            });

            // Envoyer la nouvelle ordre au serveur
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
                    // Mettre à jour les badges d'ordre
                    rows.forEach((row, index) => {
                        const badge = row.querySelector('.badge');
                        badge.textContent = index + 1;
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                // Recharger la page en cas d'erreur
                location.reload();
            });
        }
    });
});
</script>
@endpush
