<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryAndBorrowingTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_gallery_page_is_accessible(): void
    {
        $gallery = Gallery::create([
            'title' => 'Festival Musik Tahunan',
            'slug' => 'festival-musik-tahunan',
            'description' => 'Dokumentasi festival tahunan SMECO.',
            'event_date' => '2026-08-15',
            'location' => 'GOR Satria',
            'image_path' => 'galleries/test.jpg',
        ]);

        $response = $this->get(route('gallery'));
        $response->assertStatus(200);
        $response->assertSee('Festival Musik Tahunan');
        $response->assertSee('GOR Satria');
    }

    public function test_public_gallery_detail_page_is_accessible_with_photos(): void
    {
        $gallery = Gallery::create([
            'title' => 'Konser Amal 2026',
            'slug' => 'konser-amal-2026',
            'description' => 'Konser penggalangan dana kemanusiaan.',
            'event_date' => '2026-09-10',
            'location' => 'Aula SMECO',
            'image_path' => 'galleries/cover.jpg',
        ]);

        GalleryPhoto::create([
            'gallery_id' => $gallery->id,
            'image_path' => 'galleries/photo1.jpg',
            'caption' => 'Penampilan Akustik',
            'order' => 1,
        ]);

        $response = $this->get(route('gallery.detail', $gallery->slug));
        $response->assertStatus(200);
        $response->assertSee('Konser Amal 2026');
        $response->assertSee('Aula SMECO');
        $response->assertSee('Penampilan Akustik');
        // Verify navbar marks Galeri as active
        $response->assertSee('class="nav-item relative z-10 rounded-full px-4 py-1.5 text-xs font-bold transition-colors duration-200 text-white is-active"', false);
    }

    public function test_user_can_borrow_multiple_instruments_simultaneously(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'is_approved' => true,
            'role' => 'user',
        ]);

        $inst1 = Instrument::create([
            'name' => 'Gitar Fender Stratocaster',
            'quantity' => 2,
            'is_available' => true,
        ]);

        $inst2 = Instrument::create([
            'name' => 'Keyboard Yamaha PSR',
            'quantity' => 1,
            'is_available' => true,
        ]);

        $file = UploadedFile::fake()->create('surat_izin.pdf', 100, 'application/pdf');

        $response = $this->actingAs($user)->post(route('user.borrowing.store'), [
            'instrument_ids' => [$inst1->id, $inst2->id],
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'permission_letter' => $file,
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('borrowings', [
            'user_id' => $user->id,
            'instrument_id' => $inst1->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('borrowings', [
            'user_id' => $user->id,
            'instrument_id' => $inst2->id,
            'status' => 'pending',
        ]);
    }
}
