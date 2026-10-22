<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.galleries.index', [
            'galleries' => Gallery::withCount('photos')->latest()->paginate(12),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('create_galleries'), 403, 'Anda tidak memiliki hak akses untuk membuat galeri event.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:5120'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        $coverPath = $request->file('image')->store('galleries', 'public');

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'location' => $validated['location'] ?? null,
            'image_path' => $coverPath,
        ]);

        // Automatically add cover photo into gallery_photos
        $gallery->photos()->create([
            'image_path' => $coverPath,
            'caption' => 'Foto Utama',
            'order' => 1,
        ]);

        // Add additional photos if provided
        if ($request->hasFile('photos')) {
            $order = 2;
            foreach ($request->file('photos') as $photoFile) {
                $photoPath = $photoFile->store('galleries', 'public');
                $gallery->photos()->create([
                    'image_path' => $photoPath,
                    'order' => $order++,
                ]);
            }
        }

        return back()->with('success', 'Event galeri dan foto dokumentasi berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        abort_unless(auth()->user()->can('edit_galleries'), 403, 'Anda tidak memiliki hak akses untuk mengedit galeri.');

        $gallery->load('photos');

        return view('admin.galleries.edit', [
            'gallery' => $gallery,
        ]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        abort_unless(auth()->user()->can('edit_galleries'), 403, 'Anda tidak memiliki hak akses untuk mengedit galeri.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $gallery->image_path = $request->file('image')->store('galleries', 'public');
        }

        $gallery->title = $validated['title'];
        $gallery->description = $validated['description'] ?? null;
        $gallery->event_date = $validated['event_date'] ?? null;
        $gallery->location = $validated['location'] ?? null;
        $gallery->save();

        // Add new additional photos if uploaded
        if ($request->hasFile('photos')) {
            $maxOrder = $gallery->photos()->max('order') ?? 0;
            foreach ($request->file('photos') as $photoFile) {
                $photoPath = $photoFile->store('galleries', 'public');
                $gallery->photos()->create([
                    'image_path' => $photoPath,
                    'order' => ++$maxOrder,
                ]);
            }
        }

        return redirect()->route('admin.galleries.edit', $gallery)->with('success', 'Event galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        abort_unless(auth()->user()->can('delete_galleries'), 403, 'Anda tidak memiliki hak akses untuk menghapus galeri.');

        // Delete all additional photos from disk
        foreach ($gallery->photos as $photo) {
            if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
                Storage::disk('public')->delete($photo->image_path);
            }
        }

        // Delete cover
        if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return back()->with('success', 'Event galeri dan seluruh foto dokumentasi berhasil dihapus.');
    }

    public function destroyPhoto(GalleryPhoto $photo): RedirectResponse
    {
        abort_unless(auth()->user()->can('edit_galleries'), 403, 'Anda tidak memiliki hak akses untuk menghapus foto galeri.');

        if ($photo->image_path && Storage::disk('public')->exists($photo->image_path)) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return back()->with('success', 'Foto dokumentasi berhasil dihapus dari event.');
    }
}
