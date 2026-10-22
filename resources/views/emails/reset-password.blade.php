<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Smecone Music</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 540px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">
                    {{-- Header Brand Banner --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e0b4b 0%, #2e1065 50%, #4c1d95 100%); padding: 36px 30px; text-align: center;">
                            <div style="display: inline-block; width: 48px; height: 48px; line-height: 48px; border-radius: 16px; background-color: rgba(255, 255, 255, 0.12); margin-bottom: 12px; font-size: 24px;">
                                🔐
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: 0.5px;">Smecone Music</h1>
                            <p style="margin: 4px 0 0 0; color: #ddd6fe; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;">Atur Ulang Kata Sandi Akun</p>
                        </td>
                    </tr>

                    {{-- Main Content Body --}}
                    <tr>
                        <td style="padding: 36px 32px 28px 32px;">
                            <h2 style="margin: 0 0 12px 0; color: #0f172a; font-size: 18px; font-weight: 800;">Halo, {{ $user->name }}! 👋</h2>
                            <p style="margin: 0 0 20px 0; font-size: 14px; color: #475569; line-height: 1.6;">
                                Kami menerima permintaan untuk mengatur ulang kata sandi (password) akun <strong>Smecone Music</strong> yang terdaftar dengan alamat email ini.
                            </p>
                            <p style="margin: 0 0 28px 0; font-size: 14px; color: #475569; line-height: 1.6;">
                                Silakan klik tombol di bawah ini untuk membuat kata sandi baru:
                            </p>

                            {{-- CTA Button --}}
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ $resetUrl }}" 
                                   target="_blank"
                                   style="display: inline-block; background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 800; padding: 14px 32px; border-radius: 16px; box-shadow: 0 10px 20px -5px rgba(109, 40, 217, 0.4); letter-spacing: 0.3px;">
                                    Atur Ulang Kata Sandi Saya →
                                </a>
                            </div>

                            {{-- Expiration Notice --}}
                            <div style="background-color: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 14px; padding: 14px 18px; margin-bottom: 24px; text-align: center;">
                                <p style="margin: 0; font-size: 12px; color: #6d28d9; font-weight: 600;">
                                    ⏳ Tautan ini berlaku selama <strong>{{ $expireMinutes }} menit</strong> sejak email ini dikirimkan.
                                </p>
                            </div>

                            {{-- Security Notice --}}
                            <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 14px; padding: 14px 18px; margin-bottom: 24px;">
                                <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.5;">
                                    <strong>Keamanan:</strong> Jika Anda tidak pernah meminta perubahan kata sandi ini, abaikan email ini. Akun Anda tetap aman dan kata sandi Anda tidak akan berubah.
                                </p>
                            </div>

                            {{-- Plaintext link fallback --}}
                            <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                <p style="margin: 0 0 8px 0; font-size: 11px; color: #64748b;">
                                    Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:
                                </p>
                                <p style="margin: 0; font-size: 11px; color: #7c3aed; word-break: break-all; line-height: 1.4;">
                                    <a href="{{ $resetUrl }}" style="color: #7c3aed; text-decoration: underline;">{{ $resetUrl }}</a>
                                </p>
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 32px; text-align: center; border-top: 1px solid #f1f5f9;">
                            <p style="margin: 0; font-size: 11px; color: #94a3b8; font-weight: 500;">
                                © {{ date('Y') }} Smecone Music — SMK Negeri 1 Purwokerto. Seluruh hak cipta dilindungi.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
