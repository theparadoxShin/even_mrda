<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        $sliderImages = SliderImage::orderBy('order', 'asc')->get();
        return view('admin.slider.index', compact('sliderImages'));
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Upload de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title ?: 'slider') . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('slider', $filename, 'public');

            SliderImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $path,
                'order' => $request->order ?? 0,
                'is_active' => $request->has('is_active')
            ]);

            return redirect()->route('admin.slider.index')
                ->with('success', 'Image du slider ajoutée avec succès !');
        }

        return back()->with('error', 'Erreur lors de l\'upload de l\'image.');
    }

    public function edit(SliderImage $sliderImage)
    {
        return view('admin.slider.edit', compact('sliderImage'));
    }

    public function update(Request $request, SliderImage $sliderImage)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ];

        // Si nouvelle image uploadée
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($sliderImage->image_path && Storage::disk('public')->exists($sliderImage->image_path)) {
                Storage::disk('public')->delete($sliderImage->image_path);
            }

            // Upload nouvelle image
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title ?: 'slider') . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('slider', $filename, 'public');
            $data['image_path'] = $path;
        }

        $sliderImage->update($data);

        return redirect()->route('admin.slider.index')
            ->with('success', 'Image du slider mise à jour avec succès !');
    }

    public function destroy(SliderImage $sliderImage)
    {
        // Supprimer le fichier
        if ($sliderImage->image_path && Storage::disk('public')->exists($sliderImage->image_path)) {
            Storage::disk('public')->delete($sliderImage->image_path);
        }

        $sliderImage->delete();

        return redirect()->route('admin.slider.index')
            ->with('success', 'Image du slider supprimée avec succès !');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer|min:0'
        ]);

        foreach ($request->orders as $id => $order) {
            SliderImage::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true]);
    }
}
