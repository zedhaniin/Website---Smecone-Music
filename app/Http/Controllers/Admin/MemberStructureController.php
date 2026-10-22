<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
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
            'divisions' => Division::withCount('members')->orderBy('order')->orderBy('id')->get(),
            'members' => MemberStructure::with('division')->orderBy('order')->orderBy('id')->get(),
        ]);
    }

    public function editDivision(Division $division): View
    {
        abort_unless(auth()->user()->can('edit_members'), 403, 'Anda tidak memiliki hak akses untuk mengelola divisi.');

        $division->load('members');

        return view('admin.divisions.edit', compact('division'));
    }

    public function updateDivision(Request $request, Division $division): RedirectResponse
    {
        abort_unless(auth()->user()->can('edit_members'), 403, 'Anda tidak memiliki hak akses untuk mengubah informasi divisi.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            if ($division->cover_image_path) {
                Storage::disk('public')->delete($division->cover_image_path);
            }
            $validated['cover_image_path'] = $request->file('image')->store('divisions', 'public');
        }

        $division->update($validated);

        return redirect()->route('admin.divisions.edit', $division->slug)->with('success', 'Informasi dan foto cover divisi berhasil diperbarui.');
    }

    public function storeDivisionMember(Request $request, Division $division): RedirectResponse
    {
        abort_unless(auth()->user()->can('create_members'), 403, 'Anda tidak memiliki hak akses untuk menambah anggota pengurus.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('members', 'public');
        }

        $validated['division_id'] = $division->id;

        MemberStructure::create($validated);

        return redirect()->route('admin.divisions.edit', $division->slug)->with('success', 'Anggota berhasil ditambahkan ke ' . $division->name . '.');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(auth()->user()->can('create_members'), 403, 'Anda tidak memiliki hak akses untuk menambah anggota pengurus.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('members', 'public');
        }

        MemberStructure::create($validated);

        return back()->with('success', 'Anggota struktur berhasil ditambahkan.');
    }

    public function update(Request $request, MemberStructure $member): RedirectResponse
    {
        abort_unless(auth()->user()->can('edit_members'), 403, 'Anda tidak memiliki hak akses untuk mengubah data anggota pengurus.');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'image' => ['nullable', 'image', 'max:5120'],
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
        abort_unless(auth()->user()->can('delete_members'), 403, 'Anda tidak memiliki hak akses untuk menghapus anggota pengurus.');

        if ($member->image_path) {
            Storage::disk('public')->delete($member->image_path);
        }

        $member->delete();

        return back()->with('success', 'Anggota struktur berhasil dihapus.');
    }
}
