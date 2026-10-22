<?php

namespace Tests\Feature;

use App\Models\Borrowing;
use App\Models\Instrument;
use App\Models\StudioBooking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudioBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_view_instruments_catalog(): void
    {
        $user = User::factory()->create([
            'is_approved' => true,
            'role' => 'user',
        ]);

        $inst = Instrument::create([
            'name' => 'Drum Tama Imperialstar',
            'quantity' => 1,
            'is_available' => true,
        ]);

        $response = $this->actingAs($user)->get(route('user.instruments.index'));

        $response->assertStatus(200);
        $response->assertSee('Katalog Inventaris Alat Musik');
        $response->assertSee('Drum Tama Imperialstar');
        $response->assertSee('Alat Musik Tersedia');
        // Search bar should be removed from top navbar
        $response->assertDontSee('Cari kegiatan, alat, booking...');
    }

    public function test_member_can_view_borrowings_tracking(): void
    {
        $user = User::factory()->create([
            'is_approved' => true,
            'role' => 'user',
        ]);

        $inst = Instrument::create([
            'name' => 'Gitar Gibson Les Paul',
            'quantity' => 1,
            'is_available' => true,
        ]);

        Borrowing::create([
            'user_id' => $user->id,
            'instrument_id' => $inst->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
            'permission_letter_path' => 'permission-letters/surat_izin.pdf',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('user.borrowings.index'));

        $response->assertStatus(200);
        $response->assertSee('Peminjaman Inven Barang Musik');
        $response->assertSee('Gitar Gibson Les Paul');
        $response->assertSee('Menunggu Persetujuan');
        $response->assertSee('Lihat Surat Izin');
    }

    public function test_member_can_view_studio_bookings_tracking(): void
    {
        $user = User::factory()->create([
            'is_approved' => true,
            'role' => 'user',
        ]);

        StudioBooking::create([
            'user_id' => $user->id,
            'start_time' => now()->addDays(2)->setTime(14, 0),
            'end_time' => now()->addDays(2)->setTime(16, 0),
            'purpose' => 'Latihan Band Persiapan Lomba',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($user)->get(route('user.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee('Peminjaman Ruang Studio STM');
        $response->assertSee('Latihan Band Persiapan Lomba');
        $response->assertSee('Disetujui / Jadwal Aktif');
    }

    public function test_admin_editing_gallery_stays_on_edit_page(): void
    {
        $admin = User::factory()->create([
            'is_approved' => true,
            'role' => 'admin',
        ]);

        $gallery = \App\Models\Gallery::create([
            'title' => 'Konser Musik 2026',
            'slug' => 'konser-musik-2026',
            'event_date' => '2026-10-10',
            'location' => 'GOR',
            'image_path' => 'galleries/cover.jpg',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.galleries.update', $gallery), [
            'title' => 'Konser Musik 2026 Updated',
            'event_date' => '2026-10-10',
            'location' => 'GOR SMECO',
        ]);

        // Verifies redirect stays on the edit page
        $response->assertRedirect(route('admin.galleries.edit', $gallery));
        $response->assertSessionHas('success');
    }

    public function test_admin_editing_division_stays_on_division_edit_page(): void
    {
        $admin = User::factory()->create([
            'is_approved' => true,
            'role' => 'admin',
        ]);

        $division = \App\Models\Division::create([
            'name' => 'Divisi Sound System',
            'slug' => 'divisi-sound-system',
            'description' => 'Bagian sound',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.divisions.update', $division), [
            'name' => 'Divisi Sound System & Audio',
            'description' => 'Bagian audio dan mixing',
        ]);

        // Verifies redirect stays on the division edit page
        $response->assertRedirect(route('admin.divisions.edit', $division->slug));
        $response->assertSessionHas('success');
    }

    public function test_admin_navbar_shows_only_date(): void
    {
        $admin = User::factory()->create([
            'is_approved' => true,
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee(now()->locale('id')->translatedFormat('l, d M Y'));
        $response->assertDontSee('Studio Siap Pakai');
        $response->assertDontSee('Alat Musik Tersedia');
    }
}

