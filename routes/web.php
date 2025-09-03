<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventController;

// Language routes
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, array_keys(config('app.available_locales')))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

// Routes publiques principales
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/success', [HomeController::class, 'success'])->name('success');

// Routes pour la galerie
Route::get('/galerie', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galerie/categorie/{category}', [GalleryController::class, 'category'])->name('gallery.category');

// Routes pour le lecteur musical
Route::get('/musique', [MusicController::class, 'index'])->name('music.index');
Route::get('/api/music/play/{id}', [MusicController::class, 'play'])->name('music.play');
Route::get('/api/music/playlist', [MusicController::class, 'playlist'])->name('music.playlist');

// Route pour la page À propos
Route::get('/a-propos', [AboutController::class, 'index'])->name('about.index');

// Route pour la page Contact
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.index');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

// Routes pour la page des événements
Route::get('/evenements', [EventController::class, 'index'])->name('events.index');
Route::get('/evenement/{event}', [EventController::class, 'show'])->name('events.show');

// Routes pour les événements
Route::get('/event/{event}/register', [PublicController::class, 'showRegistrationForm'])->name('event.register');
Route::post('/event/{event}/register', [PublicController::class, 'register'])->name('event.register.store');
Route::get('/payment/{registration}', [PublicController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/payment/{registration}', [PublicController::class, 'processPayment'])->name('payment.process');

// Routes admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/events', [DashboardController::class, 'createEvent'])->name('admin.events.create');
        Route::get('/events/{event}/qr/download', [DashboardController::class, 'downloadQR'])->name('admin.events.qr.download');
        Route::get('/events/{event}/whatsapp', [DashboardController::class, 'getWhatsAppLink'])->name('admin.events.whatsapp');
        Route::get('/events/{event}/registrations', [DashboardController::class, 'eventRegistrations'])->name('admin.events.registrations');
        Route::patch('/registrations/{registration}/payment', [DashboardController::class, 'updatePaymentStatus'])->name('admin.registrations.payment');

        // Routes pour la gestion du slider
        Route::resource('slider', App\Http\Controllers\Admin\SliderController::class, ['as' => 'admin']);
        Route::post('/slider/update-order', [App\Http\Controllers\Admin\SliderController::class, 'updateOrder'])->name('admin.slider.update-order');

        // Routes pour la gestion de la galerie
        Route::resource('gallery', App\Http\Controllers\Admin\GalleryController::class, ['as' => 'admin']);
        Route::post('/gallery/bulk-upload', [App\Http\Controllers\Admin\GalleryController::class, 'bulkUpload'])->name('admin.gallery.bulk-upload');

        // Routes pour la gestion de la musique
        Route::resource('music', App\Http\Controllers\Admin\MusicController::class, ['as' => 'admin']);
        Route::post('/music/update-order', [App\Http\Controllers\Admin\MusicController::class, 'updateOrder'])->name('admin.music.update-order');
        Route::patch('/music/{musicTrack}/set-background', [App\Http\Controllers\Admin\MusicController::class, 'setBackground'])->name('admin.music.set-background');

        // Routes pour la configuration du profil admin
        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile.index');
        Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('admin.profile.update');
        Route::put('/profile/site-config', [App\Http\Controllers\Admin\ProfileController::class, 'updateSiteConfig'])->name('admin.profile.update-site-config');

        // Routes pour les toggles de statut
        Route::post('/slider/{sliderImage}/toggle-status', [App\Http\Controllers\Admin\SliderController::class, 'toggleStatus'])->name('admin.slider.toggle-status');
        Route::post('/gallery/{galleryImage}/toggle-status', [App\Http\Controllers\Admin\GalleryController::class, 'toggleStatus'])->name('admin.gallery.toggle-status');
    });
});


// Dans routes/web.php - Ajouter temporairement pour débugger

Route::get('/debug-qr', function () {
    $event = \App\Models\Event::first();
    if (!$event || !$event->qr_code) {
        return "Aucun événement avec QR trouvé";
    }

    $qrPath = storage_path('app/public/qrcodes/' . $event->qr_code);
    $publicUrl = asset('storage/qrcodes/' . $event->qr_code);

    return [
        'event_id' => $event->id,
        'qr_filename' => $event->qr_code,
        'storage_path' => $qrPath,
        'storage_exists' => file_exists($qrPath),
        'public_url' => $publicUrl,
        'storage_link_exists' => is_link(public_path('storage')),
        'file_content_preview' => file_exists($qrPath) ? substr(file_get_contents($qrPath), 0, 200) . '...' : 'Fichier non trouvé'
    ];
});
