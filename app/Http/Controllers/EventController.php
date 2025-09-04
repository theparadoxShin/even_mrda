<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        // Récupérer tous les événements avec pagination
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->paginate(6);

        $pastEvents = Event::where('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->paginate(6);

        // Statistiques pour la page
        $stats = [
            'total_events' => Event::count(),
            'upcoming_count' => Event::where('event_date', '>=', now())->count(),
            'past_count' => Event::where('event_date', '<', now())->count(),
        ];

        return view('events.index', compact('upcomingEvents', 'pastEvents', 'stats'));
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
}