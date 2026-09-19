<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(15),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update(['is_approved' => true]);

        return back()->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject(User $user): RedirectResponse
    {
        $user->update(['is_approved' => false]);

        return back()->with('success', "Akun {$user->name} berhasil ditolak.");
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', "Akun {$user->name} berhasil dihapus.");
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,perkap,user'],
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$validated['role']}.");
    }
}
