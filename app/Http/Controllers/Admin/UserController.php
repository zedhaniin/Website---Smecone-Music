<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::withCount(['borrowings', 'studioBookings'])->latest()->paginate(15),
            'rolesByGroup' => Role::orderBy('id')->get()->groupBy('group'),
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        abort_unless(auth()->user()->can('approve_users'), 403, 'Anda tidak memiliki hak akses untuk menyetujui akun.');

        $user->update(['is_approved' => true]);

        return back()->with('success', "Akun {$user->name} berhasil disetujui.");
    }

    public function reject(User $user): RedirectResponse
    {
        abort_unless(auth()->user()->can('approve_users'), 403, 'Anda tidak memiliki hak akses untuk menonaktifkan akun.');

        $user->update(['is_approved' => false]);

        return back()->with('success', "Akun {$user->name} berhasil ditolak/dinonaktifkan.");
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless(auth()->user()->can('delete_users'), 403, 'Anda tidak memiliki hak akses untuk menghapus user.');

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if (in_array($user->role, ['ketua', 'wakil']) && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Hanya Ketua atau Wakil (Super Admin) yang dapat menghapus akun pengurus inti.');
        }

        $user->delete();

        return back()->with('success', "Akun {$user->name} berhasil dihapus.");
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        abort_unless(auth()->user()->can('edit_users'), 403, 'Anda tidak memiliki hak akses untuk mengubah role.');

        // Protect Ketua/Wakil role changes if updater is not Super Admin
        if (in_array($user->role, ['ketua', 'wakil']) && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Hanya Super Admin yang dapat mengubah role Ketua atau Wakil.');
        }

        $validRoles = Role::pluck('slug')->all();
        // Allow legacy 'admin' as alias if needed
        $validRoles[] = 'admin';

        $validated = $request->validate([
            'role' => ['required', 'string', 'in:' . implode(',', $validRoles)],
        ]);

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$user->role_label}.");
    }
}
