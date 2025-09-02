@extends('layouts.public')

@section('title', 'Lecteur Musical')
@section('meta-description', 'Lecteur Musical de la Chorale MRDA - Découvrez notre répertoire sacré')

@push('styles')
<style>
    .music-player {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        border-radius: 20px;
        padding: 40px;
        margin: 40px 0;
        box-shadow: 0 20px 60px rgba(37, 99, 235, 0.3);
        position: relative;
        overflow: hidden;
    }

    .music-player::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="40" r="1.5" fill="white" opacity="0.1"/><circle cx="40" cy="80" r="1" fill="white" opacity="0.1"/></svg>');
        background-size: 100px 100px;
        animation: musicNote 4s ease-in-out infinite;
    }

    .current-track {
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        z-index: 2;
    }

    .track-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .track-composer {
        font-size: 1.2rem;
        opacity: 0.8;
        margin-bottom: 20px;
    }

    .progress-container {
        margin: 20px 0;
        position: relative;
        z-index: 2;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255,255,255,0.3);
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
    }

    .progress-fill {
        height: 100%;
        background: var(--gold);
        width: 0%;
        transition: width 0.3s ease;
        border-radius: 4px;
    }

    .time-display {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .player-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin: 30px 0;
        position: relative;
        z-index: 2;
    }

    .control-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .control-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
        color: white;
    }

    .play-btn {
        width: 80px;
        height: 80px;
        font-size: 2rem;
        background: var(--gold);
    }

    .play-btn:hover {
        background: #e19e0a;
        transform: scale(1.1);
    }

    .volume-control {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 20px 0;
        position: relative;
        z-index: 2;
    }

    .volume-slider {
        flex: 1;
        height: 6px;
        background: rgba(255,255,255,0.3);
        border-radius: 3px;
        outline: none;
        cursor: pointer;
    }

    .playlist {
        background: white;
        border-radius: 15px;
        padding: 30px;
        margin: 40px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .playlist-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .playlist-title {
        font-size: 2rem;
        color: var(--dark-blue);
        margin-bottom: 10px;
        position: relative;
    }

    .playlist-title::after {
        content: '🎵';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
    }

    .track-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .track-item:hover {
        background: var(--light-blue);
        transform: translateX(10px);
    }

    .track-item.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--gold);
    }

    .track-number {
        width: 40px;
        height: 40px;
        background: var(--gold);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
    }

    .track-info {
        flex: 1;
    }

    .track-name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .track-meta {
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .track-duration {
        color: var(--primary-blue);
        font-weight: 500;
    }

    .track-item.active .track-duration {
        color: var(--gold);
    }

    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
        margin: 40px 0;
    }

    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-blue);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 20px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 10px;
    }

    .equalizer {
        display: flex;
        justify-content: center;
        gap: 3px;
        margin: 20px 0;
    }

    .eq-bar {
        width: 4px;
        background: var(--gold);
        border-radius: 2px;
        animation: equalizer 1s ease-in-out infinite;
    }

    .eq-bar:nth-child(1) { height: 20px; animation-delay: 0s; }
    .eq-bar:nth-child(2) { height: 35px; animation-delay: 0.1s; }
    .eq-bar:nth-child(3) { height: 25px; animation-delay: 0.2s; }
    .eq-bar:nth-child(4) { height: 40px; animation-delay: 0.3s; }
    .eq-bar:nth-child(5) { height: 30px; animation-delay: 0.4s; }

    @keyframes equalizer {
        0%, 100% { transform: scaleY(1); }
        50% { transform: scaleY(0.3); }
    }

    .visualizer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--gold) 0%, transparent 100%);
        animation: visualizer 2s ease-in-out infinite;
    }

    @keyframes visualizer {
        0%, 100% { transform: scaleX(0.3); }
        50% { transform: scaleX(1); }
    }
</style>
@endpush

@section('content')
    <div class="container">
        <!-- Lecteur principal -->
        <div class="music-player animate-fadeInUp">
            <div class="current-track">
                <h2 class="track-title" id="currentTitle">Sélectionnez une musique</h2>
                <p class="track-composer" id="currentComposer">Chorale MRDA</p>

                <!-- Égaliseur visuel -->
                <div class="equalizer" id="equalizer" style="display: none;">
                    <div class="eq-bar"></div>
                    <div class="eq-bar"></div>
                    <div class="eq-bar"></div>
                    <div class="eq-bar"></div>
                    <div class="eq-bar"></div>
                </div>
            </div>

            <!-- Contrôles principaux -->
            <div class="player-controls">
                <button class="control-btn" id="prevBtn" onclick="previousTrack()">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="control-btn play-btn" id="playBtn" onclick="togglePlay()">
                    <i class="fas fa-play" id="playIcon"></i>
                </button>
                <button class="control-btn" id="nextBtn" onclick="nextTrack()">
                    <i class="fas fa-step-forward"></i>
                </button>
            </div>

            <!-- Barre de progression -->
            <div class="progress-container">
                <div class="progress-bar" onclick="seekTo(event)">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="time-display">
                    <span id="currentTime">0:00</span>
                    <span id="totalTime">0:00</span>
                </div>
            </div>

            <!-- Contrôle du volume -->
            <div class="volume-control">
                <i class="fas fa-volume-down"></i>
                <input type="range" class="volume-slider" id="volumeSlider" min="0" max="100" value="70">
                <i class="fas fa-volume-up"></i>
            </div>

            <!-- Visualiseur -->
            <div class="visualizer"></div>
        </div>

        <!-- Statistiques -->
        <div class="stats-section">
            <div class="stat-card animate-fadeInLeft">
                <div class="stat-icon">
                    <i class="fas fa-music"></i>
                </div>
                <div class="stat-number">{{ $totalTracks }}</div>
                <p class="text-muted">Pistes Disponibles</p>
            </div>
            <div class="stat-card animate-fadeInUp">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">{{ floor($totalDuration / 60) }}</div>
                <p class="text-muted">Minutes de Musique</p>
            </div>
            <div class="stat-card animate-fadeInRight">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-number">{{ $featuredTracks->count() }}</div>
                <p class="text-muted">Œuvres Phares</p>
            </div>
        </div>

        <!-- Playlist -->
        <div class="playlist animate-fadeInUp">
            <div class="playlist-header">
                <h2 class="playlist-title">Notre Répertoire Sacré</h2>
                <p class="text-muted">Découvrez nos plus belles interprétations</p>
            </div>

            @forelse($allTracks as $index => $track)
            <div class="track-item" data-track-id="{{ $track->id }}" data-track-index="{{ $index }}" onclick="selectTrack({{ $index }})">
                <div class="track-number">{{ $index + 1 }}</div>
                <div class="track-info">
                    <div class="track-name">{{ $track->title }}</div>
                    <div class="track-meta">
                        @if($track->composer)
                            <i class="fas fa-user me-1"></i>{{ $track->composer }} •
                        @endif
                        <i class="fas fa-tag me-1"></i>{{ $track->genre }}
                        @if($track->is_featured)
                            <i class="fas fa-star text-warning ms-2"></i>
                        @endif
                    </div>
                </div>
                <div class="track-duration">{{ $track->formatted_duration }}</div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-music fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Aucune musique disponible</h4>
                <p class="text-muted">Notre répertoire sera bientôt disponible !</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Audio caché -->
    <audio id="audioPlayer" preload="metadata">
        <source id="audioSource" src="" type="audio/mpeg">
    </audio>
@endsection

@push('scripts')
<script>
    // Variables globales
    let currentTrackIndex = 0;
    let isPlaying = false;
    let playlist = [];
    const audio = document.getElementById('audioPlayer');
    const playIcon = document.getElementById('playIcon');
    const progressFill = document.getElementById('progressFill');
    const currentTimeDisplay = document.getElementById('currentTime');
    const totalTimeDisplay = document.getElementById('totalTime');
    const equalizer = document.getElementById('equalizer');

    // Charger la playlist depuis Laravel
    @if($allTracks->count() > 0)
    playlist = [
        @foreach($allTracks as $track)
        {
            id: {{ $track->id }},
            title: "{{ $track->title }}",
            composer: "{{ $track->composer }}",
            file_url: "{{ $track->file_url }}",
            duration: "{{ $track->formatted_duration }}"
        }@if(!$loop->last),@endif
        @endforeach
    ];
    @endif

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        if (playlist.length > 0) {
            loadTrack(0);
        }

        // Contrôle du volume
        document.getElementById('volumeSlider').addEventListener('input', function() {
            audio.volume = this.value / 100;
        });

        // Événements audio
        audio.addEventListener('timeupdate', updateProgress);
        audio.addEventListener('ended', nextTrack);
        audio.addEventListener('loadedmetadata', function() {
            totalTimeDisplay.textContent = formatTime(audio.duration);
        });

        // Animations
        setupAnimations();
    });

    function loadTrack(index) {
        if (index >= 0 && index < playlist.length) {
            currentTrackIndex = index;
            const track = playlist[index];

            // Mettre à jour l'interface
            document.getElementById('currentTitle').textContent = track.title;
            document.getElementById('currentComposer').textContent = track.composer || 'Chorale MRDA';

            // Charger l'audio
            document.getElementById('audioSource').src = track.file_url;
            audio.load();

            // Mettre à jour la playlist visuelle
            updatePlaylistDisplay();
        }
    }

    function selectTrack(index) {
        loadTrack(index);
        if (isPlaying) {
            play();
        }
    }

    function togglePlay() {
        if (isPlaying) {
            pause();
        } else {
            play();
        }
    }

    function play() {
        audio.play().then(() => {
            isPlaying = true;
            playIcon.className = 'fas fa-pause';
            equalizer.style.display = 'flex';
        }).catch(error => {
            console.log('Erreur de lecture:', error);
        });
    }

    function pause() {
        audio.pause();
        isPlaying = false;
        playIcon.className = 'fas fa-play';
        equalizer.style.display = 'none';
    }

    function nextTrack() {
        const nextIndex = (currentTrackIndex + 1) % playlist.length;
        loadTrack(nextIndex);
        if (isPlaying) {
            play();
        }
    }

    function previousTrack() {
        const prevIndex = currentTrackIndex === 0 ? playlist.length - 1 : currentTrackIndex - 1;
        loadTrack(prevIndex);
        if (isPlaying) {
            play();
        }
    }

    function seekTo(event) {
        const progressBar = event.currentTarget;
        const clickX = event.offsetX;
        const width = progressBar.offsetWidth;
        const duration = audio.duration;

        if (duration) {
            const newTime = (clickX / width) * duration;
            audio.currentTime = newTime;
        }
    }

    function updateProgress() {
        if (audio.duration) {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressFill.style.width = progress + '%';
            currentTimeDisplay.textContent = formatTime(audio.currentTime);
        }
    }

    function updatePlaylistDisplay() {
        document.querySelectorAll('.track-item').forEach((item, index) => {
            if (index === currentTrackIndex) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    function setupAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fadeInUp, .animate-fadeInLeft, .animate-fadeInRight').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });
    }

    // Raccourcis clavier
    document.addEventListener('keydown', function(e) {
        switch(e.code) {
            case 'Space':
                e.preventDefault();
                togglePlay();
                break;
            case 'ArrowRight':
                nextTrack();
                break;
            case 'ArrowLeft':
                previousTrack();
                break;
        }
    });
</script>
@endpush