<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        // Récupérer toutes les images actives
        $allImages = GalleryImage::active()->orderBy('created_at', 'desc')->paginate(12);

        return view('gallery.index', compact('allImages'));
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
