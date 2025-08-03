<?php
// app/Http/Controllers/WelcomeController.php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Récupérer les 3 prochains événements actifs
        $upcomingEvents = Event::where('is_active', true)
            ->where('event_date', '>', now())
            ->orderBy('event_date')
            ->limit(3)
            ->get();

        // Récupérer quelques statistiques
        $stats = [
            'total_events' => Event::count(),
            'total_participants' => \App\Models\Registration::where('payment_status', 'paye')->count(),
            'years_experience' => date('Y') - 2017,
        ];

        return view('welcome', compact('upcomingEvents', 'stats'));
    }

    public function success()
    {
        return view('success');
    }
}
