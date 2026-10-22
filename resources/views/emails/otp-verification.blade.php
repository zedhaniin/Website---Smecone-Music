<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi OTP - Smecone Music</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #334155; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; padding: 40px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); border: 1px solid #e2e8f0;">
                    {{-- Header Brand Banner --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e0b4b 0%, #2e1065 50%, #4c1d95 100%); padding: 36px 30px; text-align: center;">
                            <div style="display: inline-block; width: 48px; height: 48px; line-height: 48px; border-radius: 16px; background-color: rgba(255, 255, 255, 0.12); margin-bottom: 12px; font-size: 24px;">
                                🎵
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: 0.5px;">Smecone Music</h1>
                            <p style="margin: 4px 0 0 0; color: #ddd6fe; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;">Verifikasi Akun Pengguna</p>
                        </td>
                    </tr>

                    {{-- Main Content Body --}}
                    <tr>
                        <td style="padding: 36px 32px 28px 32px;">
                            <h2 style="margin: 0 0 12px 0; color: #0f172a; font-size: 18px; font-weight: 800;">Halo, {{ $user->name }}! 👋</h2>
                            <p style="margin: 0 0 24px 0; font-size: 14px; color: #475569; line-height: 1.6;">
                                Terima kasih telah mendaftar di <strong>Smecone Music</strong>. Masukkan kode OTP (One-Time Password) berikut pada halaman verifikasi untuk mengaktifkan akun Anda:
                            </p>

                            {{-- Large OTP Display Box --}}
                            <div style="background: #f5f3ff; border: 2px dashed #8b5cf6; border-radius: 20px; padding: 24px 16px; text-align: center; margin-bottom: 24px;">
                                <div style="font-size: 11px; font-weight: 700; color: #6d28d9; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px;">Kode Verifikasi OTP Anda</div>
                                <div style="font-family: 'Courier New', Courier, monospace; font-size: 38px; font-weight: 800; color: #4c1d95; letter-spacing: 10px; margin: 0; padding-left: 10px;">
                                    {{ $otp }}
                                </div>
                                <div style="margin-top: 10px; font-size: 12px; color: #7c3aed; font-weight: 600;">
                                    ⏳ Berlaku selama <strong>10 menit</strong>
                                </div>
                            </div>

                            {{-- Security Notice --}}
                            <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 14px; padding: 14px 16px; margin-bottom: 20px;">
                                <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.5;">
                                    <strong>Perhatian:</strong> Jangan pernah membagikan kode OTP ini kepada siapa pun demi keamanan akun Anda. Pengurus Smecone Music tidak akan pernah meminta kode OTP Anda.
                                </p>
                            </div>

                            <p style="margin: 0; font-size: 13px; color: #64748b;">
                                Jika Anda tidak merasa melakukan pendaftaran akun ini, silakan abaikan email ini.
                            </p>
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
