<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $galleryImages = GalleryImage::orderBy('created_at', 'desc')->paginate(12);
        $categories = GalleryImage::select('category')->distinct()->whereNotNull('category')->pluck('category');

        return view('admin.gallery.index', compact('galleryImages', 'categories'));
    }

    public function create()
    {
        $categories = GalleryImage::select('category')->distinct()->whereNotNull('category')->pluck('category');
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'event_date' => 'nullable|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max pour galerie
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);

        // Upload de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('gallery', $filename, 'public');

            GalleryImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'event_date' => $request->event_date,
                'image_path' => $path,
                'is_featured' => $request->has('is_featured'),
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Image ajoutée à la galerie avec succès !');
        }

        return back()->with('error', 'Erreur lors de l\'upload de l\'image.');
    }

    public function edit(GalleryImage $galleryImage)
    {
        $categories = GalleryImage::select('category')->distinct()->whereNotNull('category')->pluck('category');
        return view('admin.gallery.edit', compact('galleryImage', 'categories'));
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'event_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'event_date' => $request->event_date,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active')
        ];

        // Si nouvelle image uploadée
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image (seulement si ce n'est pas une image de public/images)
            if ($galleryImage->image_path && 
                !str_starts_with($galleryImage->image_path, 'images/') && 
                Storage::disk('public')->exists($galleryImage->image_path)) {
                Storage::disk('public')->delete($galleryImage->image_path);
            }

            // Upload nouvelle image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('gallery', $filename, 'public');
            $data['image_path'] = $path;
        }

        $galleryImage->update($data);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image de la galerie mise à jour avec succès !');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        // Supprimer le fichier (seulement si ce n'est pas une image de public/images)
        if ($galleryImage->image_path && 
            !str_starts_with($galleryImage->image_path, 'images/') && 
            Storage::disk('public')->exists($galleryImage->image_path)) {
            Storage::disk('public')->delete($galleryImage->image_path);
        }

        $galleryImage->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image supprimée de la galerie avec succès !');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'category' => 'nullable|string|max:100',
            'event_date' => 'nullable|date'
        ]);

        $uploadedCount = 0;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $uploadedCount . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('gallery', $filename, 'public');

                GalleryImage::create([
                    'title' => 'Image ' . ($uploadedCount + 1),
                    'category' => $request->category,
                    'event_date' => $request->event_date,
                    'image_path' => $path,
                    'is_active' => true
                ]);

                $uploadedCount++;
            }
        }

        return redirect()->route('admin.gallery.index')
            ->with('success', $uploadedCount . ' images uploadées avec succès !');
    }
}
