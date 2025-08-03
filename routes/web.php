<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\WelcomeController;

// Routes publiques
Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/success', [WelcomeController::class, 'success'])->name('success');


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
