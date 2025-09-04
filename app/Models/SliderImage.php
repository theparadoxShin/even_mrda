<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope pour récupérer les images actives
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope pour ordonner par ordre d'affichage
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accesseur pour l'URL complète de l'image
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
