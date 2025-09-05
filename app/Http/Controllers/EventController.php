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

    public function getEventData(Event $event)
    {
        return response()->json([
            'id' => $event->id,
            'name' => $event->name,
            'description' => $event->description,
            'event_date' => $event->event_date,
            'location' => $event->location ?? 'À définir',
            'price' => $event->price,
            'duration' => $event->duration ?? '2 heures',
            'max_attendees' => $event->max_attendees ?? 'Illimitées',
            'formatted_date' => $event->event_date->format('l d F Y'),
            'formatted_time' => $event->event_date->format('H:i'),
            'formatted_datetime' => $event->event_date->format('d M Y, H:i'),
            'day' => $event->event_date->format('d'),
            'month' => $event->event_date->format('M Y'),
            'is_upcoming' => $event->event_date >= now(),
            'price_formatted' => $event->price > 0 ? '$' . number_format($event->price, 2) : 'Gratuit',
            'register_url' => route('event.register', $event)
        ]);
    }
}
