<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        // Récupérer toutes les catégories disponibles
        $categories = GalleryImage::active()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        // Récupérer les images mises en avant
        $featuredImages = GalleryImage::active()->featured()->take(6)->get();

        // Récupérer toutes les images actives
        $allImages = GalleryImage::active()->orderBy('event_date', 'desc')->paginate(12);

        return view('gallery.index', compact('categories', 'featuredImages', 'allImages'));
    }

    public function category($category)
    {
        $images = GalleryImage::active()
            ->byCategory($category)
            ->orderBy('event_date', 'desc')
            ->paginate(12);

        return view('gallery.category', compact('images', 'category'));
    }
}
