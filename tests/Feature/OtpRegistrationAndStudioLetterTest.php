<?php

namespace Tests\Feature;

use App\Mail\OtpVerificationMail;
use App\Models\StudioBooking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OtpRegistrationAndStudioLetterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_receives_otp_email(): void
    {
        Mail::fake();

        $response = $this->post(route('register'), [
            'name' => 'Budi Santoso',
            'email' => 'budisantoso@example.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
            'phone' => '081234567890',
            'class_or_division' => 'XI TJKT 2',
        ]);

        $response->assertRedirect(route('otp.verify'));

        $this->assertDatabaseHas('users', [
            'email' => 'budisantoso@example.com',
            'role' => 'user',
            'is_approved' => false,
        ]);

        $user = User::where('email', 'budisantoso@example.com')->first();
        $this->assertEquals($user->id, session('otp_user_id'));
        $this->assertNotNull($user->otp_code);
        $this->assertEquals(6, strlen($user->otp_code));
        $this->assertNotNull($user->otp_expires_at);

        Mail::assertSent(OtpVerificationMail::class, function ($mail) use ($user) {
            return $mail->hasTo('budisantoso@example.com') && $mail->otp === $user->otp_code;
        });
    }

    public function test_user_can_verify_valid_otp_and_gets_auto_logged_in(): void
    {
        $user = User::factory()->create([
            'email' => 'budisantoso@example.com',
            'role' => 'user',
            'is_approved' => false,
            'email_verified_at' => null,
            'otp_code' => '654321',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->withSession(['otp_user_id' => $user->id])
            ->post(route('otp.submit'), [
                'otp' => '654321',
            ]);

        $response->assertRedirect(route('user.dashboard'));
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertTrue((bool) $user->is_approved);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->otp_code);
    }

    public function test_invalid_otp_fails_verification(): void
    {
        $user = User::factory()->create([
            'email' => 'budisantoso@example.com',
            'role' => 'user',
            'is_approved' => false,
            'otp_code' => '654321',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->withSession(['otp_user_id' => $user->id])
            ->from(route('otp.verify'))
            ->post(route('otp.submit'), [
                'otp' => '000000',
            ]);

        $response->assertRedirect(route('otp.verify'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_expired_otp_fails_verification(): void
    {
        $user = User::factory()->create([
            'email' => 'budisantoso@example.com',
            'role' => 'user',
            'is_approved' => false,
            'otp_code' => '654321',
            'otp_expires_at' => now()->subMinute(),
        ]);

        $response = $this->withSession(['otp_user_id' => $user->id])
            ->from(route('otp.verify'))
            ->post(route('otp.submit'), [
                'otp' => '654321',
            ]);

        $response->assertRedirect(route('otp.verify'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_user_can_resend_otp(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'budisantoso@example.com',
            'role' => 'user',
            'is_approved' => false,
            'otp_code' => '111111',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->withSession([
            'otp_user_id' => $user->id,
            'otp_last_sent' => now()->subMinutes(2),
        ])->from(route('otp.verify'))->post(route('otp.resend'));

        $response->assertRedirect(route('otp.verify'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertNotEquals('111111', $user->otp_code);

        Mail::assertSent(OtpVerificationMail::class, function ($mail) use ($user) {
            return $mail->hasTo('budisantoso@example.com') && $mail->otp === $user->otp_code;
        });
    }

    public function test_unverified_user_logging_in_is_redirected_to_otp_verify(): void
    {
        $user = User::factory()->create([
            'email' => 'unverified@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'is_approved' => false,
            'email_verified_at' => null,
            'otp_code' => '999888',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'unverified@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('otp.verify'));
        $this->assertEquals($user->id, session('otp_user_id'));
        $this->assertGuest();
    }

    public function test_member_can_book_studio_with_permission_letter_upload(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'is_approved' => true,
            'role' => 'user',
        ]);

        $file = UploadedFile::fake()->create('surat_izin_studio.pdf', 300, 'application/pdf');

        $startTime = now()->addDays(3)->setTime(10, 0)->format('Y-m-d\TH:i');
        $endTime = now()->addDays(3)->setTime(12, 0)->format('Y-m-d\TH:i');

        $response = $this->actingAs($user)->post(route('user.booking.store'), [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'purpose' => 'Latihan Band Class Meeting',
            'permission_letter' => $file,
        ]);

        $response->assertRedirect(route('user.dashboard'));
        $response->assertSessionHas('success');

        $booking = StudioBooking::where('user_id', $user->id)->first();
        $this->assertNotNull($booking);
        $this->assertNotNull($booking->permission_letter_path);
        Storage::disk('public')->assertExists($booking->permission_letter_path);
    }

    public function test_admin_can_view_permission_letter_in_studio_bookings_index(): void
    {
        $admin = User::factory()->create([
            'is_approved' => true,
            'role' => 'admin',
        ]);

        $member = User::factory()->create([
            'name' => 'Rian Hidayat',
            'is_approved' => true,
            'role' => 'user',
        ]);

        StudioBooking::create([
            'user_id' => $member->id,
            'start_time' => now()->addDays(2)->setTime(13, 0),
            'end_time' => now()->addDays(2)->setTime(15, 0),
            'purpose' => 'Gladi Bersih Festival',
            'permission_letter_path' => 'permission-letters-studio/surat_rian.pdf',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee('Rian Hidayat');
        $response->assertSee('Gladi Bersih Festival');
        $response->assertSee('Lihat Surat');
        $response->assertSee('permission-letters-studio/surat_rian.pdf');
    }
}
