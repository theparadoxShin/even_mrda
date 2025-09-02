<!-- Navigation Header Component -->
<nav class="navbar navbar-expand-lg fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}" data-aos="fade-right">
            <i class="fas fa-music me-2"></i>Chorale MRDA
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}" href="{{ route('about.index') }}">
                        <i class="fas fa-users me-1"></i>À Propos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">
                        <i class="fas fa-images me-1"></i>Galerie
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('music.*') ? 'active' : '' }}" href="{{ route('music.index') }}">
                        <i class="fas fa-play-circle me-1"></i>Musique
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                        <i class="fas fa-envelope me-1"></i>Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#events" onclick="scrollToEvents()">
                        <i class="fas fa-calendar me-1"></i>Événements
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* Navigation Styles */
.navbar-custom {
    background: rgba(37, 99, 235, 0.95) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    padding: 1rem 0;
}

.navbar-custom.scrolled {
    background: rgba(37, 99, 235, 0.98) !important;
    box-shadow: 0 5px 30px rgba(0,0,0,0.2);
    padding: 0.5rem 0;
}

.navbar-brand {
    font-size: 1.8rem;
    font-weight: bold;
    color: white !important;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    transform: scale(1.05);
    color: var(--gold, #f59e0b) !important;
}

.nav-link {
    color: rgba(255,255,255,0.9) !important;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    margin: 0 0.2rem;
    border-radius: 8px;
    padding: 0.5rem 1rem !important;
    display: flex;
    align-items: center;
}

.nav-link i {
    font-size: 0.9rem;
    margin-right: 0.5rem;
    width: 1rem;
    height: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.nav-link::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: var(--gold, #f59e0b);
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover,
.nav-link.active {
    color: var(--gold, #f59e0b) !important;
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.nav-link:hover::before,
.nav-link.active::before {
    width: 80%;
}

.navbar-toggler {
    border: 2px solid rgba(255, 255, 255, 0.3);
    padding: 0.25rem 0.5rem;
}

.navbar-toggler:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .navbar-nav {
        text-align: center;
        padding: 1rem 0;
    }

    .nav-item {
        margin: 0.2rem 0;
    }

    .navbar-brand {
        font-size: 1.5rem;
    }
}
</style>

<script>
// Navigation scroll effects
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar-custom');

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scrolling for events link
    window.scrollToEvents = function() {
        // Check if we're on the home page
        if (window.location.pathname === '/' || window.location.pathname === '/home') {
            const eventsSection = document.getElementById('events');
            if (eventsSection) {
                eventsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        } else {
            // Redirect to home page with events anchor
            window.location.href = '{{ route("home") }}#events';
        }
    };

    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-link');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (navbarCollapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                bsCollapse.hide();
            }
        });
    });
});
</script>
