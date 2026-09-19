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
}
