<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  use App\Models\MusicTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicController extends Controller
{
    public function index()
    {
        $musicTracks = MusicTrack::orderBy('order', 'asc')->paginate(15);
        return view('admin.music.index', compact('musicTracks'));
    }

    public function create()
    {
        return view('admin.music.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'genre' => 'string|max:100',
            'description' => 'nullable|string',
            'audio_file' => 'required|mimes:mp3,wav,m4a,aac|max:20480', // 20MB max
            'order' => 'integer|min:0',
            'is_featured' => 'boolean',
            'is_background' => 'boolean',
            'is_active' => 'boolean'
        ]);

        // Upload du fichier audio
        if ($request->hasFile('audio_file')) {
            $audioFile = $request->file('audio_file');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('music', $filename, 'public');

            // Calculer la durée si possible (optionnel)
            $duration = $this->getAudioDuration($audioFile);

            MusicTrack::create([
                'title' => $request->title,
                'composer' => $request->composer,
                'genre' => $request->genre ?? 'Religieux',
                'description' => $request->description,
                'file_path' => $path,
                'duration' => $duration,
                'order' => $request->order ?? 0,
                'is_featured' => $request->has('is_featured'),
                'is_background' => $request->has('is_background'),
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.music.index')
                ->with('success', 'Piste musicale ajoutée avec succès !');
        }

        return back()->with('error', 'Erreur lors de l\'upload du fichier audio.');
    }

    public function edit(MusicTrack $musicTrack)
    {
        return view('admin.music.edit', compact('musicTrack'));
    }

    public function update(Request $request, MusicTrack $musicTrack)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'composer' => 'nullable|string|max:255',
            'genre' => 'string|max:100',
            'description' => 'nullable|string',
            'audio_file' => 'nullable|mimes:mp3,wav,m4a,aac|max:20480',
            'order' => 'integer|min:0',
            'is_featured' => 'boolean',
            'is_background' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = [
            'title' => $request->title,
            'composer' => $request->composer,
            'genre' => $request->genre ?? 'Religieux',
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_featured' => $request->has('is_featured'),
            'is_background' => $request->has('is_background'),
            'is_active' => $request->has('is_active')
        ];

        // Si nouveau fichier audio uploadé
        if ($request->hasFile('audio_file')) {
            // Supprimer l'ancien fichier
            if ($musicTrack->file_path && Storage::disk('public')->exists($musicTrack->file_path)) {
                Storage::disk('public')->delete($musicTrack->file_path);
            }

            // Upload nouveau fichier
            $audioFile = $request->file('audio_file');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('music', $filename, 'public');

            $data['file_path'] = $path;
            $data['duration'] = $this->getAudioDuration($audioFile);
        }

        $musicTrack->update($data);

        return redirect()->route('admin.music.index')
            ->with('success', 'Piste musicale mise à jour avec succès !');
    }

    public function destroy(MusicTrack $musicTrack)
    {
        // Supprimer le fichier audio
        if ($musicTrack->file_path && Storage::disk('public')->exists($musicTrack->file_path)) {
            Storage::disk('public')->delete($musicTrack->file_path);
        }

        $musicTrack->delete();

        return redirect()->route('admin.music.index')
            ->with('success', 'Piste musicale supprimée avec succès !');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer|min:0'
        ]);

        foreach ($request->orders as $id => $order) {
            MusicTrack::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }

    public function setBackground(MusicTrack $musicTrack)
    {
        // Retirer le statut de musique de fond des autres pistes
        MusicTrack::where('is_background', true)->update(['is_background' => false]);

        // Définir cette piste comme musique de fond
        $musicTrack->update(['is_background' => true]);

        return redirect()->route('admin.music.index')
            ->with('success', 'Musique de fond définie avec succès !');
    }

    private function getAudioDuration($audioFile)
    {
        // Cette fonction nécessiterait une librairie comme getID3 pour fonctionner pleinement
        // Pour l'instant, on retourne null et la durée sera mise à jour manuellement
        try {
            // Ici vous pourriez utiliser getID3 ou une autre librairie pour lire les métadonnées
            // $getID3 = new \getID3;
            // $fileInfo = $getID3->analyze($audioFile->getRealPath());
            // return isset($fileInfo['playtime_seconds']) ? (int) $fileInfo['playtime_seconds'] : null;

            return null; // Temporaire
        } catch (\Exception $e) {
            return null;
        }
    }
}
