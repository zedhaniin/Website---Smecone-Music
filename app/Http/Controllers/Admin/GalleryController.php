<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.galleries.index', [
            'galleries' => Gallery::latest()->paginate(15),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $validated['image_path'] = $request->file('image')->store('galleries', 'public');

        Gallery::create($validated);

        return back()->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
