<!-- Footer Component -->
<footer class="bg-dark text-white py-4 footer-custom">
    <div class="container">
        <div class="row">
            <!-- Logo et description -->
            <div class="col-lg-4 mb-4 text-center" data-aos="fade-up">
                <h5 class="fw-bold mb-3">
                    <img src="{{ asset('logo.png') }}" alt="Chorale MRDA" class="footer-logo">
                </h5>
                <p class="mb-4">
                    La Chorale MRDA - Ensemble vocal dédié à la musique sacrée,
                    touchant les cœurs et élevant les âmes par la beauté du chant choral.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" target="_blank" aria-label="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="social-link" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link" target="_blank" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-link" target="_blank" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Liens rapides -->
            <div class="col-lg-4 col-md-6 mb-4 text-center" data-aos="fade-up" data-aos-delay="100">
                <h6 class="fw-bold mb-3 text-uppercase text-warning">
                    <i class="fas fa-link me-2"></i>Navigation
                </h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('about.index') }}">À Propos</a></li>
                    <li><a href="{{ route('gallery.index') }}">Galerie</a></li>
                    <li><a href="{{ route('music.index') }}">Musique</a></li>
                    <li><a href="{{ route('contact.index') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <h6 class="fw-bold mb-3 text-uppercase text-warning">
                    <i class="fas fa-address-book me-2"></i>Contact
                </h6>
                <div class="contact-info">
                    <div class="contact-item mb-2">
                        <i class="fas fa-envelope me-2 text-warning"></i>
                        <a href="mailto:contact@chorale-mrda.com">contact@chorale-mrda.com</a>
                    </div>
                    <div class="contact-item mb-2">
                        <i class="fas fa-phone me-2 text-warning"></i>
                        <a href="tel:+243123456789">+243 123 456 789</a>
                    </div>
                    <div class="contact-item mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-warning"></i>
                        <span>123 Rue de la Musique<br>Kinshasa, RDC</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock me-2 text-warning"></i>
                        <span>Répétitions: Mar & Jeu 18h-20h</span>
                    </div>
                </div>
            </div>

        </div>

        <hr class="my-3 opacity-25">

        <!-- Copyright -->
        <div class="text-center py-2" data-aos="fade-up" data-aos-delay="400">
            <small class="opacity-75" style="font-size: 0.75rem;">
                &copy; {{ date('Y') }} Chorale MRDA •
                Développé par <a href="https://parfaittedomtedom.com" target="_blank" class="text-warning text-decoration-none opacity-75">Parfait Tedom Tedom</a>
            </small>
        </div>
    </div>

    <!-- Floating music notes -->
    <div class="musical-notes-footer">
        <div class="note note-1">♪</div>
        <div class="note note-2">♫</div>
        <div class="note note-3">♪</div>
        <div class="note note-4">♫</div>
    </div>
</footer>

<style>
/* Footer Styles */
.footer-custom {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    position: relative;
    overflow: hidden;
}

.footer-custom::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.03)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.03)"/><circle cx="40" cy="70" r="0.5" fill="rgba(255,255,255,0.03)"/></svg>');
    animation: float 30s infinite linear;
}

.footer-logo {
    height: 80px;
    width: auto;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    transition: transform 0.3s ease;
}

.footer-logo:hover {
    transform: scale(1.05) rotate(5deg);
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.social-link:hover {
    background: var(--gold, #f59e0b);
    color: white;
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-links a:hover {
    color: var(--gold, #f59e0b);
    transform: translateX(5px);
}

.contact-info .contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 0.8rem;
}

.contact-info a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-info a:hover {
    color: var(--gold, #f59e0b);
}

.developer-section {
    background: rgba(0, 0, 0, 0.3) !important;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.developer-section:hover {
    background: rgba(0, 0, 0, 0.5) !important;
    border-color: var(--gold, #f59e0b);
    transform: translateY(-2px);
}

.developer-btn {
    transition: all 0.3s ease;
    border-color: var(--gold, #f59e0b);
    color: var(--gold, #f59e0b);
}

.developer-btn:hover {
    background: var(--gold, #f59e0b);
    color: #000;
    transform: scale(1.05);
}

/* Musical notes animation */
.musical-notes-footer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}

.musical-notes-footer .note {
    position: absolute;
    color: rgba(245, 158, 11, 0.1);
    font-size: 1.5rem;
    animation: floatFooter 15s infinite linear;
}

.note-1 { left: 10%; animation-delay: 0s; }
.note-2 { left: 30%; animation-delay: 3s; }
.note-3 { left: 70%; animation-delay: 6s; }
.note-4 { left: 90%; animation-delay: 9s; }

@keyframes floatFooter {
    0% {
        transform: translateY(100%) rotate(0deg);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-50px) rotate(360deg);
        opacity: 0;
    }
}

@keyframes float {
    0% { transform: translateY(0px); }
    100% { transform: translateY(-20px); }
}

/* Responsive */
@media (max-width: 768px) {
    .footer-custom {
        text-align: center;
    }

    .social-links {
        justify-content: center;
    }

    .footer-links {
        text-align: center;
    }

    .contact-info .contact-item {
        justify-content: center;
    }
}
</style>
