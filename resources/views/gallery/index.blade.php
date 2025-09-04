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


    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
        margin-bottom: 70px;
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


    .section-title {
        text-align: center;
        font-size: 2.5rem;
        color: var(--dark-blue);
        margin-bottom: 3rem;
        position: relative;
        font-weight: 600;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(135deg, var(--primary-blue), var(--gold));
        border-radius: 2px;
        animation: shimmer 2s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% {
            transform: translateX(-50%) scaleX(1);
            opacity: 0.8;
        }
        50% {
            transform: translateX(-50%) scaleX(1.2);
            opacity: 1;
            box-shadow: 0 0 15px rgba(37, 99, 235, 0.4);
        }
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
        <!-- Galerie -->
        <section>
            <div class="gallery-grid" id="galleryContainer">
                @forelse($allImages as $image)
                <div class="gallery-item animate-fadeInUp" >
                    <a href="{{ $image->image_url }}" data-lightbox="gallery">
                        <img src="{{ $image->image_url }}" alt="Image de la chorale" class="gallery-image">
                    </a>
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
