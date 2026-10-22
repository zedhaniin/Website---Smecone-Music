<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class RolePermissionController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('manage_roles');

        $roles = Role::whereNotIn('slug', ['user'])
            ->orderBy('id')
            ->get();

        // Target role from query or default to 'ketua'
        $selectedSlug = $request->query('role', 'ketua');
        $selectedRole = Role::where('slug', $selectedSlug)->first() ?? $roles->first();

        // Load permissions grouped by module
        $allPermissions = Permission::orderBy('id')->get()->groupBy('group');

        // Current assigned permission IDs
        $assignedPermissionIds = $selectedRole->isSuperAdmin()
            ? Permission::pluck('id')->all()
            : $selectedRole->permissions()->pluck('permissions.id')->all();

        return view('admin.roles.index', [
            'roles' => $roles,
            'selectedRole' => $selectedRole,
            'allPermissions' => $allPermissions,
            'assignedPermissionIds' => $assignedPermissionIds,
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse|JsonResponse
    {
        Gate::authorize('manage_roles');

        if ($role->isSuperAdmin()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role Super Admin (Ketua / Wakil) memiliki hak akses penuh permanen.',
                ], 422);
            }
            return back()->with('error', 'Role Super Admin (Ketua / Wakil) memiliki hak akses penuh permanen.');
        }

        $validated = $request->validate([
            'permission_ids' => ['nullable', 'array'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
        ]);

        $permissionIds = $validated['permission_ids'] ?? [];
        $role->permissions()->sync($permissionIds);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Hak akses role {$role->name} berhasil diperbarui.",
                'assigned_count' => count($permissionIds),
            ]);
        }

        return back()->with('success', "Hak akses role {$role->name} berhasil diperbarui.");
    }

    public function addPermission(Request $request, Role $role): RedirectResponse|JsonResponse
    {
        Gate::authorize('manage_roles');

        if ($role->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Role Super Admin sudah memiliki semua akses.',
            ], 422);
        }

        $validated = $request->validate([
            'permission_id' => ['required', 'integer', 'exists:permissions,id'],
        ]);

        $role->permissions()->syncWithoutDetaching([$validated['permission_id']]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hak akses berhasil ditambahkan ke role ini.',
            ]);
        }

        return back()->with('success', 'Hak akses berhasil ditambahkan.');
    }

    public function removePermission(Request $request, Role $role): RedirectResponse|JsonResponse
    {
        Gate::authorize('manage_roles');

        if ($role->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mencabut hak akses dari Super Admin.',
            ], 422);
        }

        $validated = $request->validate([
            'permission_id' => ['required', 'integer', 'exists:permissions,id'],
        ]);

        $role->permissions()->detach($validated['permission_id']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Hak akses berhasil dicabut dari role ini.',
            ]);
        }

        return back()->with('success', 'Hak akses berhasil dicabut.');
    }

    public function resetDefault(Request $request, Role $role): RedirectResponse
    {
        Gate::authorize('manage_roles');

        if ($role->isSuperAdmin()) {
            return back()->with('error', 'Role Super Admin tidak perlu direset.');
        }

        $allViews = Permission::where('name', 'like', 'view_%')->pluck('id')->all();

        $defaultPermissionNames = match ($role->slug) {
            'sekretaris', 'bendahara' => [
                'approve_users', 'edit_users',
                'create_members', 'edit_members', 'delete_members',
                'approve_borrowings', 'approve_bookings',
            ],
            'pengurus_perkap' => [
                'create_instruments', 'edit_instruments', 'delete_instruments',
                'approve_borrowings', 'approve_bookings',
            ],
            'pengurus_pdd' => [
                'create_members', 'edit_members', 'delete_members',
                'create_galleries', 'edit_galleries', 'delete_galleries',
                'create_showcases', 'delete_showcases',
            ],
            'pengurus_alat_musik' => [
                'create_instruments', 'edit_instruments', 'delete_instruments',
            ],
            default => [],
        };

        $specificIds = Permission::whereIn('name', $defaultPermissionNames)->pluck('id')->all();
        $targetIds = array_unique(array_merge($allViews, $specificIds));

        $role->permissions()->sync($targetIds);

        return back()->with('success', "Hak akses role {$role->name} berhasil direset ke pengaturan bawaan.");
    }
}
