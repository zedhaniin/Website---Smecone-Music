<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            /** @var User $user */
            $user = Auth::user();

            if (! $user->is_approved) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // If user has pending OTP, allow them to verify
                if ($user->otp_code) {
                    session(['otp_user_id' => $user->id, 'otp_last_sent' => now()]);

                    return redirect()->route('otp.verify')
                        ->with('info', 'Akun Anda belum diverifikasi. Silakan masukkan kode OTP yang telah dikirimkan ke email Anda.');
                }

                return back()->with('error', 'Akun Anda saat ini dinonaktifkan atau belum disetujui oleh Pengurus.');
            }

            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $otp = (string) random_int(100000, 999999);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user',
            'is_approved' => false,
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        session([
            'otp_user_id' => $user->id,
            'otp_last_sent' => now(),
        ]);

        // Send OTP via Gmail SMTP
        try {
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email OTP: ' . $e->getMessage());

            // Dev fallback helper if email delivery experiences temporary local connectivity issues
            session()->flash('otp_dev_hint', $otp);

            return redirect()->route('otp.verify')
                ->with('warning', "Pendaftaran berhasil. Namun pengiriman email mengalami kendala ({$e->getMessage()}). Untuk testing, gunakan kode OTP: {$otp}");
        }

        return redirect()->route('otp.verify')
            ->with('success', "Kode OTP 6 digit telah dikirimkan ke email {$user->email}. Silakan periksa inbox atau folder spam Anda.");
    }

    public function showVerifyOtp(Request $request): View|RedirectResponse
    {
        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan mendaftar terlebih dahulu.');
        }

        $user = User::find($userId);

        if (! $user) {
            session()->forget('otp_user_id');
            return redirect()->route('register');
        }

        if ($user->is_approved) {
            session()->forget('otp_user_id');
            return redirect()->route('login')->with('info', 'Akun Anda sudah terverifikasi dan aktif. Silakan login.');
        }

        return view('auth.verify-otp', compact('user'));
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus terdiri dari 6 angka.',
        ]);

        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('login')->with('error', 'Sesi verifikasi telah berakhir. Silakan login kembali.');
        }

        $user = User::find($userId);

        if (! $user || ! $user->otp_code) {
            return redirect()->route('login')->with('error', 'Data verifikasi tidak valid.');
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            return back()->with('error', 'Kode OTP telah kadaluarsa. Silakan klik "Kirim Ulang OTP".');
        }

        if ($user->otp_code !== trim($request->otp)) {
            return back()->with('error', 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali email Anda.');
        }

        // Successfully verified
        $user->update([
            'is_approved' => true,
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);

        session()->forget(['otp_user_id', 'otp_last_sent']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')
            ->with('success', "Selamat datang di Smecone Music, {$user->name}! Akun Anda telah aktif dan terverifikasi.");
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi telah berakhir.');
        }

        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('register');
        }

        // Cooldown 60s
        $lastSent = session('otp_last_sent');
        if ($lastSent) {
            $lastSentCarbon = $lastSent instanceof \Carbon\CarbonInterface ? $lastSent : \Carbon\Carbon::parse($lastSent);
            $cooldownUntil = $lastSentCarbon->copy()->addSeconds(60);
            if ($cooldownUntil->isFuture()) {
                $remaining = max(1, (int) ceil(now()->diffInSeconds($cooldownUntil, false)));
                return back()->with('error', "Mohon tunggu {$remaining} detik sebelum meminta kode OTP baru.");
            }
        }

        $otp = (string) random_int(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        session(['otp_last_sent' => now()]);

        try {
            Mail::to($user->email)->send(new OtpVerificationMail($user, $otp));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim ulang email OTP: ' . $e->getMessage());
            session()->flash('otp_dev_hint', $otp);

            return back()->with('warning', "Pengiriman email mengalami kendala ({$e->getMessage()}). Untuk testing, gunakan kode OTP: {$otp}");
        }

        return back()->with('success', "Kode OTP baru telah berhasil dikirimkan ke {$user->email}.");
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Kami tidak menemukan akun dengan alamat email tersebut.',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );

        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user, $resetUrl, 60));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email reset password: ' . $e->getMessage());

            // Dev hint for testing if local SMTP experiences issues
            session()->flash('reset_dev_url', $resetUrl);

            return back()
                ->withInput()
                ->with('warning', "Pengiriman email mengalami kendala ({$e->getMessage()}). Untuk keperluan testing, silakan gunakan tautan: {$resetUrl}");
        }

        session(['reset_email' => $user->email]);

        return back()->with('success', "Tautan reset kata sandi telah dikirimkan ke email Gmail Anda ({$user->email}). Silakan periksa inbox atau folder spam di akun Gmail Anda.");
    }

    public function showResetPassword(Request $request, string $token): View|RedirectResponse
    {
        $email = $request->query('email');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Tautan reset kata sandi tidak valid. Alamat email tidak disertakan.');
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record || $record->token !== $token) {
            return redirect()->route('password.request')
                ->with('error', 'Tautan reset kata sandi tidak valid atau sudah tidak berlaku.');
        }

        $createdAt = \Carbon\Carbon::parse($record->created_at);
        if (now()->diffInMinutes($createdAt) > 60) {
            return redirect()->route('password.request')
                ->with('error', 'Tautan reset kata sandi telah kadaluarsa (berlaku 60 menit). Silakan minta tautan baru.');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record || $record->token !== $request->token) {
            return redirect()->route('password.request')
                ->with('error', 'Tautan reset kata sandi tidak valid atau sudah pernah digunakan.');
        }

        $createdAt = \Carbon\Carbon::parse($record->created_at);
        if (now()->diffInMinutes($createdAt) > 60) {
            return redirect()->route('password.request')
                ->with('error', 'Tautan reset kata sandi telah kadaluarsa. Silakan ajukan permohonan baru.');
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        // Remove token from table
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Kata sandi berhasil diperbarui! Silakan masuk dengan kata sandi baru Anda.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
