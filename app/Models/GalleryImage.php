<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GalleryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'description',
        'category',
        'event_date',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'event_date' => 'date',
    ];

    // Scope pour récupérer les images actives
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope pour les images mises en avant
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope par catégorie
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accesseur pour l'URL complète de l'image
    public function getImageUrlAttribute()
    {
        // Si l'image est dans public/images (chemin commence par 'images/')
        if (str_starts_with($this->image_path, 'images/')) {
            return asset($this->image_path);
        }
        
        // Sinon, c'est une image uploadée dans storage
        return asset('storage/' . $this->image_path);
    }

    // Accesseur pour la date formatée
    public function getFormattedDateAttribute()
    {
        return $this->event_date ? $this->event_date->format('d/m/Y') : '';
    }
}
