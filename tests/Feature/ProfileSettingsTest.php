<?php

namespace Tests\Feature;

use App\Models\Division;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_info(): void
    {
        $user = User::factory()->create([
            'name' => 'Budi Lama',
            'phone' => '0811111111',
            'class_name' => 'X RPL 1',
            'instrument_division' => null,
            'is_approved' => true,
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Budi Baru Pratama',
            'phone' => '089988776655',
            'class_name' => 'XI PPLG 2',
            'instrument_division' => 'Divisi Alat Musik',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Budi Baru Pratama', $user->name);
        $this->assertEquals('089988776655', $user->phone);
        $this->assertEquals('XI PPLG 2', $user->class_name);
        $this->assertEquals('Divisi Alat Musik', $user->instrument_division);
    }

    public function test_admin_can_update_management_division(): void
    {
        $division = Division::firstOrCreate(
            ['slug' => 'divisi-custom-test'],
            ['name' => 'Divisi Custom Test', 'category' => 'Pengurus Harian']
        );

        $admin = User::factory()->create([
            'name' => 'Pengurus Zed',
            'is_approved' => true,
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->patch(route('profile.update'), [
            'name' => 'Pengurus Zed Updated',
            'phone' => '081234567890',
            'class_name' => 'XII TJKT 1',
            'instrument_division' => 'Divisi Vokal',
            'management_division' => $division->name,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $admin->refresh();
        $this->assertEquals('Pengurus Zed Updated', $admin->name);
        $this->assertEquals('Divisi Vokal', $admin->instrument_division);
        $this->assertEquals($division->name, $admin->management_division);
    }

    public function test_regular_user_cannot_update_management_division(): void
    {
        $user = User::factory()->create([
            'name' => 'Siswa Biasa',
            'is_approved' => true,
            'role' => 'user',
            'management_division' => null,
        ]);

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name' => 'Siswa Biasa Updated',
            'management_division' => 'Pengurus Inti',
        ]);

        $response->assertRedirect();

        $user->refresh();
        $this->assertEquals('Siswa Biasa Updated', $user->name);
        $this->assertNull($user->management_division);
    }

    public function test_user_can_update_password_with_correct_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password-123'),
            'is_approved' => true,
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->patch(route('profile.password'), [
            'current_password' => 'old-password-123',
            'password' => 'new-secure-password-456',
            'password_confirmation' => 'new-secure-password-456',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('new-secure-password-456', $user->password));
    }

    public function test_user_cannot_update_password_with_incorrect_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('correct-old-password'),
            'is_approved' => true,
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->patch(route('profile.password'), [
            'current_password' => 'wrong-old-password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertSessionHasErrors('current_password');

        $user->refresh();
        $this->assertTrue(Hash::check('correct-old-password', $user->password));
    }

    public function test_admin_and_user_layouts_display_favicon_and_settings_trigger(): void
    {
        $admin = User::factory()->create([
            'is_approved' => true,
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('images/logo.png');
        $response->assertSee('favicon.ico');
        $response->assertSee('Pengaturan Akun');
        $response->assertSee('openProfileModal');
    }
}
