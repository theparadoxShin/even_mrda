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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'order' => 'integer|min:0',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title ?: 'slider') . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('slider', $filename, 'public');

            SliderImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $path,
                'order' => $request->order ?? 0,
                'is_active' => $request->boolean('is_active')
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Image du slider ajoutée avec succès !',
                    'reload' => true
                ]);
            }

            return redirect()->route('admin.slider.index')
                ->with('success', 'Image du slider ajoutée avec succès !');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'upload de l\'image.'
            ], 400);
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
            'is_active' => 'nullable|boolean'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active')
        ];

        if ($request->hasFile('image')) {
            if ($sliderImage->image_path && Storage::disk('public')->exists($sliderImage->image_path)) {
                Storage::disk('public')->delete($sliderImage->image_path);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->title ?: 'slider') . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('slider', $filename, 'public');
            $data['image_path'] = $path;
        }

        $sliderImage->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Image du slider mise à jour avec succès !',
                'reload' => true
            ]);
        }

        return redirect()->route('admin.slider.index')
            ->with('success', 'Image du slider mise à jour avec succès !');
    }

    public function destroy(SliderImage $sliderImage)
    {
        if ($sliderImage->image_path && Storage::disk('public')->exists($sliderImage->image_path)) {
            Storage::disk('public')->delete($sliderImage->image_path);
        }

        $sliderImage->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Image du slider supprimée avec succès !',
                'reload' => true
            ]);
        }

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

    public function toggleStatus(Request $request, SliderImage $sliderImage)
    {
        $sliderImage->update([
            'is_active' => (bool) $request->input('is_active')
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $sliderImage->is_active,
        ]);
    }
}
