<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'composer',
        'file_path',
        'genre',
        'duration',
        'description',
        'order',
        'is_featured',
        'is_background',
        'is_active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_background' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Scope pour récupérer les pistes actives
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope pour les pistes mises en avant
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope pour la musique de fond
    public function scopeBackground($query)
    {
        return $query->where('is_background', true);
    }

    // Scope pour ordonner par ordre d'affichage
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accesseur pour l'URL complète du fichier audio
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Accesseur pour la durée formatée
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return '';

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
