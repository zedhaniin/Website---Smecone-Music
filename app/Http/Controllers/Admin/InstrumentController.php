<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instrument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InstrumentController extends Controller
{
    public function index(): View
    {
        return view('admin.instruments.index', [
            'instruments' => Instrument::latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        abort_unless(auth()->user()->can('create_instruments'), 403, 'Anda tidak memiliki hak akses untuk menambah alat musik.');

        return view('admin.instruments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('create_instruments'), 403, 'Anda tidak memiliki hak akses untuk menambah alat musik.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'quantity' => ['required', 'integer', 'min:1'],
            'is_available' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('instruments', 'public');
        }

        $validated['is_available'] = $request->boolean('is_available', true);

        Instrument::create($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Alat musik berhasil ditambahkan.');
    }

    public function edit(Instrument $instrument): View
    {
        abort_unless(auth()->user()->can('edit_instruments'), 403, 'Anda tidak memiliki hak akses untuk mengubah alat musik.');

        return view('admin.instruments.edit', compact('instrument'));
    }

    public function update(Request $request, Instrument $instrument): RedirectResponse
    {
        abort_unless(auth()->user()->can('edit_instruments'), 403, 'Anda tidak memiliki hak akses untuk mengubah alat musik.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'quantity' => ['required', 'integer', 'min:1'],
            'is_available' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($instrument->image_path) {
                Storage::disk('public')->delete($instrument->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('instruments', 'public');
        }

        $validated['is_available'] = $request->boolean('is_available', true);

        $instrument->update($validated);

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Alat musik berhasil diperbarui.');
    }

    public function destroy(Instrument $instrument): RedirectResponse
    {
        abort_unless(auth()->user()->can('delete_instruments'), 403, 'Anda tidak memiliki hak akses untuk menghapus alat musik.');

        if ($instrument->image_path) {
            Storage::disk('public')->delete($instrument->image_path);
        }

        $instrument->delete();

        return redirect()->route('admin.instruments.index')
            ->with('success', 'Alat musik berhasil dihapus.');
    }
}
