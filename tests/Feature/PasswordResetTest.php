<?php

namespace Tests\Feature;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi?');
    }

    public function test_password_reset_link_can_be_requested(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'member@smecone.music',
            'is_approved' => true,
        ]);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);

        Mail::assertSent(ResetPasswordMail::class, function (ResetPasswordMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_cannot_request_reset_for_nonexistent_email(): void
    {
        Mail::fake();

        $response = $this->post(route('password.email'), [
            'email' => 'nonexistent@smecone.music',
        ]);

        $response->assertSessionHasErrors('email');
        Mail::assertNothingSent();
    }

    public function test_reset_password_screen_can_be_rendered_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'resetuser@smecone.music',
            'is_approved' => true,
        ]);

        $token = 'test-valid-token-123456';
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $response = $this->get(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Buat Password Baru');
        $response->assertSee($user->email);
    }

    public function test_reset_password_screen_redirects_if_token_invalid(): void
    {
        $response = $this->get(route('password.reset', [
            'token' => 'invalid-token',
            'email' => 'unknown@smecone.music',
        ]));

        $response->assertRedirect(route('password.request'));
        $response->assertSessionHas('error');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'user_reset@smecone.music',
            'password' => Hash::make('old-password-123'),
            'is_approved' => true,
        ]);

        $token = 'secure-token-abcdef123456';
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-secret-password-456',
            'password_confirmation' => 'new-secret-password-456',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('new-secret-password-456', $user->password));

        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }
}
