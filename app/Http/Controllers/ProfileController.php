<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Update user profile information (Name, Phone, Class, Instrument/Vocal Division, Management Division).
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:25'],
            'class_name' => ['nullable', 'string', 'max:50'],
            'instrument_division' => ['nullable', 'string', 'max:100'],
            'management_division' => ['nullable', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'phone.max' => 'Nomor WhatsApp / HP maksimal 25 karakter.',
            'class_name.max' => 'Kelas maksimal 50 karakter.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'class_name' => $validated['class_name'] ?? null,
            'instrument_division' => $validated['instrument_division'] ?? null,
        ];

        // Only allow management division update if the user is an admin / pengurus
        if ($user->isAdmin() && isset($validated['management_division'])) {
            $updateData['management_division'] = $validated['management_division'];
        }

        $user->update($updateData);

        return back()->with('success', 'Pengaturan profil akun berhasil disimpan.');
    }

    /**
     * Update user account password with current password verification.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini yang Anda masukkan tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password akun berhasil diperbarui.');
    }
}
