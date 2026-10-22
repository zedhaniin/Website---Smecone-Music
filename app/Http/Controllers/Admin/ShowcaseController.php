<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showcase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShowcaseController extends Controller
{
    public function index(): View
    {
        return view('admin.showcases.index', [
            'showcases' => Showcase::latest()->paginate(15),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('create_showcases'), 403, 'Anda tidak memiliki hak akses untuk menambah showcase prestasi.');

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'embed_type' => ['required', 'in:youtube,instagram'],
            'embed_url' => ['required', 'url'],
        ]);

        Showcase::create($request->only(['title', 'description', 'embed_type', 'embed_url']));

        return back()->with('success', 'Showcase berhasil ditambahkan.');
    }

    public function destroy(Showcase $showcase): RedirectResponse
    {
        abort_unless(auth()->user()->can('delete_showcases'), 403, 'Anda tidak memiliki hak akses untuk menghapus showcase.');

        $showcase->delete();

        return back()->with('success', 'Showcase berhasil dihapus.');
    }
}
