<?php

namespace Tests\Feature;

use App\Models\MemberStructure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_and_structure_page_return_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $responseStruktur = $this->get('/struktur');
        $responseStruktur->assertStatus(200);
    }

    public function test_members_are_automatically_ordered_by_position_hierarchy(): void
    {
        MemberStructure::create(['name' => 'Anggota Test', 'position' => 'Anggota Humas']);
        MemberStructure::create(['name' => 'Ketua Test', 'position' => 'Ketua']);
        MemberStructure::create(['name' => 'Wakil Test', 'position' => 'Wakil']);

        $orderedMembers = MemberStructure::orderBy('order')->orderBy('id')->get();

        $this->assertEquals('Ketua Test', $orderedMembers[0]->name);
        $this->assertEquals('Wakil Test', $orderedMembers[1]->name);
        $this->assertEquals('Anggota Test', $orderedMembers[2]->name);
    }

    public function test_division_detail_page_returns_successful_response(): void
    {
        MemberStructure::create(['name' => 'Ketua Test', 'position' => 'Ketua']);

        $responseInti = $this->get('/struktur/pengurus-inti');
        $responseInti->assertStatus(200);
        $responseInti->assertSee('Ketua Test');

        $responseHumas = $this->get('/struktur/humas');
        $responseHumas->assertStatus(200);

        $responseInvalid = $this->get('/struktur/divisi-tidak-ada');
        $responseInvalid->assertStatus(404);
    }

    public function test_admin_can_update_division_cover_photo(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $admin = \App\Models\User::factory()->create([
            'role' => 'admin',
            'is_approved' => true,
        ]);

        $division = \App\Models\Division::where('slug', 'humas')->first();

        $file = \Illuminate\Http\UploadedFile::fake()->image('cover-humas.jpg', 800, 600);

        $response = $this->actingAs($admin)->put(route('admin.divisions.update', $division), [
            'name' => 'Divisi Humas & Eksternal',
            'description' => 'Deskripsi baru divisi humas',
            'image' => $file,
        ]);

        $response->assertSessionHas('success');
        $division->refresh();

        $this->assertEquals('Divisi Humas & Eksternal', $division->name);
        $this->assertEquals('Deskripsi baru divisi humas', $division->description);
        $this->assertNotNull($division->cover_image_path);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($division->cover_image_path);

        // Verify public page displays updated cover
        $responsePublic = $this->get('/struktur');
        $responsePublic->assertStatus(200);
        $responsePublic->assertSee(asset('storage/' . $division->cover_image_path), false);
    }

    public function test_admin_can_add_member_to_specific_division(): void
    {
        $admin = \App\Models\User::factory()->create([
            'role' => 'admin',
            'is_approved' => true,
        ]);

        $division = \App\Models\Division::where('slug', 'vocal')->first();

        $response = $this->actingAs($admin)->post(route('admin.divisions.members.store', $division), [
            'name' => 'Vocalist Bintang',
            'position' => 'Koordinator Vocal',
        ]);

        $response->assertSessionHas('success');

        $member = MemberStructure::where('name', 'Vocalist Bintang')->first();
        $this->assertNotNull($member);
        $this->assertEquals($division->id, $member->division_id);

        // Check division detail page
        $responseDetail = $this->get('/struktur/vocal');
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee('Vocalist Bintang');
    }
}
