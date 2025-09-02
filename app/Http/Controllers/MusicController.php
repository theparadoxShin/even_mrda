<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MusicTrack;

class MusicController extends Controller
{
    public function index()
    {
        // Récupérer les pistes mises en avant
        $featuredTracks = MusicTrack::active()->featured()->ordered()->get();

        // Récupérer toutes les pistes actives
        $allTracks = MusicTrack::active()->ordered()->get();

        // Statistiques pour l'affichage
        $totalTracks = $allTracks->count();
        $totalDuration = $allTracks->sum('duration');

        return view('music.index', compact('featuredTracks', 'allTracks', 'totalTracks', 'totalDuration'));
    }

    public function play($id)
    {
        $track = MusicTrack::active()->findOrFail($id);
        return response()->json([
            'success' => true,
            'track' => [
                'id' => $track->id,
                'title' => $track->title,
                'composer' => $track->composer,
                'file_url' => $track->file_url,
                'duration' => $track->formatted_duration
            ]
        ]);
    }

    public function playlist()
    {
        $tracks = MusicTrack::active()->ordered()->get();
        return response()->json([
            'playlist' => $tracks->map(function($track) {
                return [
                    'id' => $track->id,
                    'title' => $track->title,
                    'composer' => $track->composer,
                    'file_url' => $track->file_url,
                    'duration' => $track->formatted_duration
                ];
            })
        ]);
    }
}
