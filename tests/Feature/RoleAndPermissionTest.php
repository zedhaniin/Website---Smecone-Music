<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAndPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_ketua_as_super_admin_can_access_roles_management(): void
    {
        $ketua = User::factory()->create([
            'role' => 'ketua',
            'is_approved' => true,
        ]);

        // Default route lands on 'ketua'
        $response = $this->actingAs($ketua)->get(route('admin.roles.index'));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Role');
        $response->assertSee('Hak Akses Pengurus');
        $response->assertSee('Role Ketua adalah Super Admin');

        // Accessing role query parameter (e.g. sekretaris) shows permissions matrix
        $responseSekre = $this->actingAs($ketua)->get(route('admin.roles.index', ['role' => 'sekretaris']));
        $responseSekre->assertStatus(200);
        $responseSekre->assertSee('Katalog Hak Akses Tersedia');
        $responseSekre->assertSee('Hak Akses Aktif Role Sekretaris');
    }

    public function test_non_super_admin_cannot_access_roles_management(): void
    {
        $sekretaris = User::factory()->create([
            'role' => 'sekretaris',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($sekretaris)->get(route('admin.roles.index'));
        $response->assertStatus(403);

        $pengurus = User::factory()->create([
            'role' => 'pengurus',
            'is_approved' => true,
        ]);

        $response2 = $this->actingAs($pengurus)->get(route('admin.roles.index'));
        $response2->assertStatus(403);
    }

    public function test_super_admin_can_update_role_permissions(): void
    {
        $ketua = User::factory()->create([
            'role' => 'ketua',
            'is_approved' => true,
        ]);

        $targetRole = Role::where('slug', 'pengurus')->firstOrFail();
        $perm1 = Permission::where('name', 'view_instruments')->firstOrFail();
        $perm2 = Permission::where('name', 'create_instruments')->firstOrFail();

        $response = $this->actingAs($ketua)->put(route('admin.roles.update', $targetRole), [
            'permission_ids' => [$perm1->id, $perm2->id],
        ]);

        $response->assertRedirect();
        $this->assertTrue($targetRole->fresh()->hasPermission('create_instruments'));
    }

    public function test_super_admin_cannot_demote_or_strip_ketua_permissions(): void
    {
        $ketua = User::factory()->create([
            'role' => 'ketua',
            'is_approved' => true,
        ]);

        $ketuaRole = Role::where('slug', 'ketua')->firstOrFail();

        $response = $this->actingAs($ketua)->put(route('admin.roles.update', $ketuaRole), [
            'permission_ids' => [],
        ]);

        $response->assertSessionHas('error');
    }

    public function test_pengurus_divisi_lain_is_view_only_for_instruments(): void
    {
        $pengurus = User::factory()->create([
            'role' => 'pengurus',
            'is_approved' => true,
        ]);

        // Can view listing
        $response = $this->actingAs($pengurus)->get(route('admin.instruments.index'));
        $response->assertStatus(200);
        $response->assertSee('Inventaris Alat Musik');

        // Cannot create
        $createResponse = $this->actingAs($pengurus)->get(route('admin.instruments.create'));
        $createResponse->assertStatus(403);

        $postResponse = $this->actingAs($pengurus)->post(route('admin.instruments.store'), [
            'name' => 'Gitar Fender Baru',
            'quantity' => 1,
        ]);
        $postResponse->assertStatus(403);
    }

    public function test_pengurus_perkap_can_create_instruments(): void
    {
        $perkap = User::factory()->create([
            'role' => 'pengurus_perkap',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($perkap)->get(route('admin.instruments.create'));
        $response->assertStatus(200);

        $postResponse = $this->actingAs($perkap)->post(route('admin.instruments.store'), [
            'name' => 'Kabel Jack Mogami 5m',
            'quantity' => 4,
            'is_available' => true,
        ]);
        $postResponse->assertRedirect(route('admin.instruments.index'));
        $this->assertDatabaseHas('instruments', ['name' => 'Kabel Jack Mogami 5m']);
    }

    public function test_add_and_remove_permission_via_ajax_buttons(): void
    {
        $ketua = User::factory()->create([
            'role' => 'ketua',
            'is_approved' => true,
        ]);

        $role = Role::where('slug', 'pengurus_pdd')->firstOrFail();
        $perm = Permission::where('name', 'create_instruments')->firstOrFail();

        // 1. Add permission
        $addResponse = $this->actingAs($ketua)->postJson(route('admin.roles.addPermission', $role), [
            'permission_id' => $perm->id,
        ]);
        $addResponse->assertJson(['success' => true]);
        $this->assertTrue($role->fresh()->hasPermission('create_instruments'));

        // 2. Remove permission
        $removeResponse = $this->actingAs($ketua)->postJson(route('admin.roles.removePermission', $role), [
            'permission_id' => $perm->id,
        ]);
        $removeResponse->assertJson(['success' => true]);
        $this->assertFalse($role->fresh()->hasPermission('create_instruments'));
    }
}
