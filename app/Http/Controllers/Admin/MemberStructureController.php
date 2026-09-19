<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberStructure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MemberStructureController extends Controller
{
    public function index(): View
    {
        return view('admin.members.index', [
            'members' => MemberStructure::orderBy('order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('members', 'public');
        }

        MemberStructure::create($validated);

        return back()->with('success', 'Anggota struktur berhasil ditambahkan.');
    }

    public function update(Request $request, MemberStructure $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($member->image_path) {
                Storage::disk('public')->delete($member->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('members', 'public');
        }

        $member->update($validated);

        return back()->with('success', 'Anggota struktur berhasil diperbarui.');
    }

    public function destroy(MemberStructure $member): RedirectResponse
    {
        if ($member->image_path) {
            Storage::disk('public')->delete($member->image_path);
        }

        $member->delete();

        return back()->with('success', 'Anggota struktur berhasil dihapus.');
    }
}
