@extends('layouts.public')

@section('title', 'Galerie')
@section('meta-description', 'Galerie photos de la Chorale MRDA - Découvrez nos moments précieux en images')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">

<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
        background-size: 50px 50px;
        animation: musicNote 3s ease-in-out infinite;
    }

    .page-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .category-filters {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin: 40px 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .filter-btn {
        background: transparent;
        border: 2px solid var(--primary-blue);
        color: var(--primary-blue);
        padding: 10px 20px;
        border-radius: 25px;
        margin: 5px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .filter-btn:hover, .filter-btn.active {
        background: var(--primary-blue);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .gallery-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        background: white;
    }

    .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }

    .gallery-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .gallery-item:hover .gallery-image {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 250px;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        align-items: end;
        padding: 20px;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-info {
        padding: 20px;
    }

    .gallery-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: var(--dark-blue);
        margin-bottom: 10px;
    }

    .gallery-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .category-badge {
        background: var(--gold);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .date-badge {
        color: var(--primary-blue);
        font-size: 0.9rem;
    }

    .featured-section {
        margin-bottom: 60px;
    }

    .featured-title {
        text-align: center;
        font-size: 2.5rem;
        color: var(--dark-blue);
        margin-bottom: 40px;
        position: relative;
    }

    .featured-title::after {
        content: '📸';
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 2rem;
    }
</style>
@endpush

@section('content')
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title animate-fadeInUp">Notre Galerie</h1>
            <p class="lead animate-fadeInUp">Découvrez nos moments précieux en images</p>
        </div>
    </div>

    <div class="container">
        <!-- Images mises en avant -->
        @if($featuredImages->count() > 0)
        <section class="featured-section">
            <h2 class="featured-title animate-fadeInUp">Images à la Une</h2>
            <div class="gallery-grid">
                @foreach($featuredImages as $image)
                <div class="gallery-item animate-fadeInUp">
                    <a href="{{ $image->image_url }}" data-lightbox="featured" data-title="{{ $image->title }}">
                        <img src="{{ $image->image_url }}" alt="{{ $image->title }}" class="gallery-image">
                        <div class="gallery-overlay">
                            <div class="text-white">
                                <h5>{{ $image->title }}</h5>
                                <p class="mb-0">{{ Str::limit($image->description, 60) }}</p>
                            </div>
                        </div>
                    </a>
                    <div class="gallery-info">
                        <h4 class="gallery-title">{{ $image->title }}</h4>
                        <div class="gallery-meta">
                            @if($image->category)
                                <span class="category-badge">{{ $image->category }}</span>
                            @endif
                            @if($image->event_date)
                                <span class="date-badge">
                                    <i class="fas fa-calendar me-1"></i>{{ $image->formatted_date }}
                                </span>
                            @endif
                        </div>
                        @if($image->description)
                            <p class="text-muted">{{ Str::limit($image->description, 100) }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Filtres par catégorie -->
        @if($categories->count() > 0)
        <div class="category-filters animate-fadeInUp">
            <div class="text-center">
                <h4 class="mb-3">Filtrer par catégorie</h4>
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-th me-1"></i>Toutes
                </button>
                @foreach($categories as $category)
                    <button class="filter-btn" data-filter="{{ $category }}">
                        <i class="fas fa-tag me-1"></i>{{ $category }}
                    </button>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Galerie complète -->
        <section>
            <h2 class="featured-title animate-fadeInUp">Toutes nos Photos</h2>
            <div class="gallery-grid" id="galleryContainer">
                @forelse($allImages as $image)
                <div class="gallery-item animate-fadeInUp" data-category="{{ $image->category ?? 'other' }}">
                    <a href="{{ $image->image_url }}" data-lightbox="gallery" data-title="{{ $image->title }}">
                        <img src="{{ $image->image_url }}" alt="{{ $image->title }}" class="gallery-image">
                        <div class="gallery-overlay">
                            <div class="text-white">
                                <h5>{{ $image->title }}</h5>
                                <p class="mb-0">{{ Str::limit($image->description, 60) }}</p>
                            </div>
                        </div>
                    </a>
                    <div class="gallery-info">
                        <h4 class="gallery-title">{{ $image->title }}</h4>
                        <div class="gallery-meta">
                            @if($image->category)
                                <span class="category-badge">{{ $image->category }}</span>
                            @endif
                            @if($image->event_date)
                                <span class="date-badge">
                                    <i class="fas fa-calendar me-1"></i>{{ $image->formatted_date }}
                                </span>
                            @endif
                        </div>
                        @if($image->description)
                            <p class="text-muted">{{ Str::limit($image->description, 100) }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune image pour le moment</h4>
                    <p class="text-muted">Les photos de nos concerts et répétitions arriveront bientôt !</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($allImages->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $allImages->links() }}
            </div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<script>
    // Configuration Lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'fadeDuration': 300,
        'imageFadeDuration': 300
    });

    // Filtrage par catégorie
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            const items = document.querySelectorAll('.gallery-item');

            items.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.opacity = '1';
                    }, 100);
                } else {
                    item.style.opacity = '0';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Animations au scroll
    document.addEventListener('DOMContentLoaded', function() {
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

        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });
    });

    // Lazy loading pour les images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
</script>
@endpush