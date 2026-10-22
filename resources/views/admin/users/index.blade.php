@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Manajemen Akun User</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola hak akses pengguna, persetujuan pendaftaran, dan penetapan role.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Pengguna & Identitas</th>
                        <th class="px-6 py-4">Email & Verifikasi</th>
                        <th class="px-6 py-4">Role Hak Akses</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4">Tanggal Daftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="transition-colors hover:bg-slate-50/70">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-950 text-xs font-extrabold text-brand-300 shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-extrabold text-slate-900 block text-xs">{{ $user->name }}</span>
                                        <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                            @if($user->class_name)
                                                <span class="inline-flex items-center gap-1 rounded-md bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-700 border border-slate-200/70">
                                                    <svg class="h-2.5 w-2.5 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a10.99 10.99 0 010 3.898l-2.644 1.133a1 1 0 000 1.84l7 3a1 1 0 00.788 0l7-3a1 1 0 000-1.84l-2.644-1.133a10.99 10.99 0 010-3.898l2.644-1.133a1 1 0 000-1.84l-7-3z"/></svg>
                                                    {{ $user->class_name }}
                                                </span>
                                            @endif
                                            @if($user->instrument_division)
                                                <span class="inline-flex items-center gap-1 rounded-md bg-brand-50 px-2 py-0.5 text-[10px] font-bold text-brand-700 border border-brand-200/70">
                                                    <svg class="h-2.5 w-2.5 text-brand-600" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>
                                                    {{ $user->instrument_division }}
                                                </span>
                                            @endif
                                            @if(!$user->class_name && !$user->instrument_division)
                                                <span class="text-[10px] text-slate-400 italic">Profil belum lengkap</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-700">{{ $user->email }}</div>
                                <div class="mt-0.5">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700">
                                            <svg class="h-3 w-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            OTP Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-700">
                                            <svg class="h-3 w-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            Belum OTP
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @can('edit_users')
                                    @if(in_array($user->role, ['ketua', 'wakil']) && !auth()->user()->isSuperAdmin())
                                        {{-- Non-superadmin cannot alter Ketua/Wakil --}}
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-[11px] font-extrabold text-amber-900 border border-amber-200 shadow-2xs">
                                            {{ $user->role_label }}
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()"
                                                    class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-extrabold text-slate-800 transition-all focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none cursor-pointer">
                                                @if(isset($rolesByGroup))
                                                    @foreach($rolesByGroup as $groupName => $roles)
                                                        <optgroup label="{{ $groupName }}">
                                                            @foreach($roles as $r)
                                                                <option value="{{ $r->slug }}" {{ $user->role === $r->slug ? 'selected' : '' }}>
                                                                    {{ $r->name }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                @else
                                                    <option value="ketua" {{ $user->role === 'ketua' ? 'selected' : '' }}>Ketua</option>
                                                    <option value="wakil" {{ $user->role === 'wakil' ? 'selected' : '' }}>Wakil Ketua</option>
                                                    <option value="sekretaris" {{ $user->role === 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                                    <option value="bendahara" {{ $user->role === 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                                    <option value="pengurus_perkap" {{ $user->role === 'pengurus_perkap' ? 'selected' : '' }}>Pengurus (Perkap)</option>
                                                    <option value="pengurus_pdd" {{ $user->role === 'pengurus_pdd' ? 'selected' : '' }}>Pengurus (PDD)</option>
                                                    <option value="pengurus_alat_musik" {{ $user->role === 'pengurus_alat_musik' ? 'selected' : '' }}>Pengurus (Alat Musik)</option>
                                                    <option value="pengurus" {{ $user->role === 'pengurus' ? 'selected' : '' }}>Pengurus (Divisi Lain)</option>
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Anggota (User)</option>
                                                @endif
                                            </select>
                                        </form>
                                    @endif
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-[11px] font-extrabold text-slate-700 border border-slate-200">
                                        {{ $user->role_label }}
                                    </span>
                                @endcan
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_approved)
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-emerald-900 border border-emerald-200">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-amber-900 border border-amber-200/80">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-semibold">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Tombol Detail Profil User --}}
                                    <button type="button" 
                                            onclick="openUserDetail({{ json_encode([
                                                'id' => $user->id,
                                                'name' => $user->name,
                                                'email' => $user->email,
                                                'email_verified' => !is_null($user->email_verified_at),
                                                'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->format('d M Y, H:i') : null,
                                                'phone' => $user->phone,
                                                'wa_link' => $user->phone ? 'https://wa.me/' . preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $user->phone)) : null,
                                                'class_name' => $user->class_name,
                                                'instrument_division' => $user->instrument_division,
                                                'management_division' => $user->management_division,
                                                'role_label' => $user->role_label,
                                                'is_approved' => (bool)$user->is_approved,
                                                'created_at' => $user->created_at->format('d M Y, H:i'),
                                                'borrowings_count' => $user->borrowings_count ?? 0,
                                                'studio_bookings_count' => $user->studio_bookings_count ?? 0,
                                            ]) }})"
                                            class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 hover:text-brand-700 px-3 py-1.5 text-xs font-extrabold text-slate-700 transition-all border border-slate-200/80 shadow-2xs">
                                        <svg class="h-3.5 w-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>Detail</span>
                                    </button>

                                    @can('approve_users')
                                        @if(!$user->is_approved)
                                            <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="tap-press rounded-xl bg-emerald-100 px-3.5 py-1.5 text-xs font-extrabold text-emerald-900 transition-all hover:bg-emerald-200">
                                                    Setujui
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="tap-press rounded-xl bg-amber-100 px-3.5 py-1.5 text-xs font-extrabold text-amber-900 transition-all hover:bg-amber-200">
                                                    Nonaktifkan
                                                </button>
                                            </form>
                                        @endif
                                    @endcan

                                    @can('delete_users')
                                        @if($user->id !== auth()->id() && (!in_array($user->role, ['ketua', 'wakil']) || auth()->user()->isSuperAdmin()))
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="tap-press rounded-xl bg-rose-100 px-3.5 py-1.5 text-xs font-extrabold text-rose-900 transition-all hover:bg-rose-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    @endcan

                                    @if(!auth()->user()->can('approve_users') && !auth()->user()->can('delete_users'))
                                        <span class="text-xs text-slate-400 font-semibold italic">View-Only</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs font-semibold text-slate-400">Belum ada user terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Detail User --}}
    <div id="userDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/60 backdrop-blur-sm p-4 flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl border border-slate-100 animate-in fade-in zoom-in-95 duration-200">
            {{-- Header Modal --}}
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div id="detailAvatar" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-950 text-base font-extrabold text-brand-300 shadow-md shadow-brand-950/20">
                        U
                    </div>
                    <div>
                        <h3 id="detailName" class="text-base font-extrabold text-slate-900 leading-tight">Nama Pengguna</h3>
                        <p id="detailEmail" class="text-xs font-medium text-slate-500 mt-0.5">user@example.com</p>
                    </div>
                </div>
                <button type="button" onclick="closeUserDetail()" class="tap-press rounded-xl p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Body Info --}}
            <div class="mt-4 space-y-4">
                {{-- Badges Status Ringkas --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span id="detailOtpBadge" class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-extrabold"></span>
                    <span id="detailAccountStatusBadge" class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-extrabold"></span>
                    <span id="detailRoleBadge" class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-800 border border-slate-200 px-2.5 py-1 text-[11px] font-extrabold"></span>
                </div>

                {{-- Kotak Verifikasi Siswa & Musik --}}
                <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4 space-y-3">
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Data Verifikasi Siswa & Ekskul Musik</p>
                    
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        {{-- Kelas --}}
                        <div class="rounded-xl bg-white p-3 border border-slate-200/60 shadow-2xs">
                            <span class="text-[11px] font-semibold text-slate-400 block">Kelas / Jurusan</span>
                            <span id="detailClass" class="text-xs font-extrabold text-slate-900 mt-0.5 block">-</span>
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Siswa SMKN 1 Purwokerto</span>
                        </div>

                        {{-- Divisi Musik --}}
                        <div class="rounded-xl bg-white p-3 border border-slate-200/60 shadow-2xs">
                            <span class="text-[11px] font-semibold text-slate-400 block">Pilihan Divisi Musik</span>
                            <span id="detailInstrumentDiv" class="text-xs font-extrabold text-brand-700 mt-0.5 block">-</span>
                            <span class="text-[10px] text-slate-400 mt-0.5 block">Alat Musik / Vokal</span>
                        </div>
                    </div>

                    {{-- Posisi Kepengurusan --}}
                    <div class="rounded-xl bg-white p-3 border border-slate-200/60 shadow-2xs flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400 block">Posisi / Status Kepengurusan</span>
                            <span id="detailManagementDiv" class="text-xs font-extrabold text-slate-800 mt-0.5 block">-</span>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">Smecone Music</span>
                    </div>

                    {{-- No Telepon / WhatsApp --}}
                    <div class="rounded-xl bg-white p-3 border border-slate-200/60 shadow-2xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <span class="text-[11px] font-semibold text-slate-400 block">No. Telepon / WhatsApp</span>
                            <span id="detailPhone" class="text-xs font-extrabold text-slate-900 mt-0.5 block">-</span>
                        </div>
                        <a id="detailWaBtn" href="#" target="_blank" rel="noopener noreferrer" 
                           class="hidden tap-press inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-xs font-extrabold transition-all shadow-sm shadow-emerald-600/20">
                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Chat WhatsApp</span>
                        </a>
                    </div>
                </div>

                {{-- Riwayat Aktivitas & Registrasi --}}
                <div class="grid grid-cols-3 gap-2.5 text-center">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-2.5">
                        <span class="text-[10px] font-bold text-slate-400 block uppercase">Pinjam Alat</span>
                        <span id="detailBorrowingsCount" class="text-sm font-extrabold text-slate-900 mt-0.5 block">0</span>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-2.5">
                        <span class="text-[10px] font-bold text-slate-400 block uppercase">Booking STM</span>
                        <span id="detailStudioCount" class="text-sm font-extrabold text-slate-900 mt-0.5 block">0</span>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50/50 p-2.5">
                        <span class="text-[10px] font-bold text-slate-400 block uppercase">Terdaftar Sejak</span>
                        <span id="detailCreatedAt" class="text-[11px] font-extrabold text-slate-800 mt-0.5 block">-</span>
                    </div>
                </div>
            </div>

            {{-- Footer Modal --}}
            <div class="mt-6 flex items-center justify-end border-t border-slate-100 pt-4">
                <button type="button" onclick="closeUserDetail()" class="tap-press rounded-xl bg-slate-100 hover:bg-slate-200 px-4 py-2 text-xs font-extrabold text-slate-700 transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Script Modal Detail User --}}
    <script>
        function openUserDetail(user) {
            const modal = document.getElementById('userDetailModal');
            document.getElementById('detailAvatar').textContent = (user.name || 'U').charAt(0).toUpperCase();
            document.getElementById('detailName').textContent = user.name || '-';
            document.getElementById('detailEmail').textContent = user.email || '-';

            // OTP Badge
            const otpBadge = document.getElementById('detailOtpBadge');
            if (user.email_verified) {
                otpBadge.className = 'inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-200 px-2.5 py-1 text-[11px] font-extrabold';
                otpBadge.innerHTML = '<svg class="h-3 w-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Terverifikasi OTP (' + (user.email_verified_at || '') + ')';
            } else {
                otpBadge.className = 'inline-flex items-center gap-1 rounded-full bg-amber-100 text-amber-900 border border-amber-200 px-2.5 py-1 text-[11px] font-extrabold';
                otpBadge.innerHTML = '<svg class="h-3 w-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg> Belum Verifikasi OTP';
            }

            // Status Akun Badge
            const accBadge = document.getElementById('detailAccountStatusBadge');
            if (user.is_approved) {
                accBadge.className = 'inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 px-2.5 py-1 text-[11px] font-extrabold';
                accBadge.textContent = 'Akun Aktif';
            } else {
                accBadge.className = 'inline-flex items-center gap-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 text-[11px] font-extrabold';
                accBadge.textContent = 'Menunggu Persetujuan';
            }

            // Role Badge
            document.getElementById('detailRoleBadge').textContent = 'Role: ' + (user.role_label || 'Anggota');

            // Data Sekolah & Ekskul
            document.getElementById('detailClass').textContent = user.class_name ? user.class_name : 'Belum diisi';
            document.getElementById('detailInstrumentDiv').textContent = user.instrument_division ? user.instrument_division : 'Belum memilih';
            document.getElementById('detailManagementDiv').textContent = user.management_division ? user.management_division : 'Anggota Musik (Bukan Pengurus)';

            // Phone & WhatsApp
            const phoneEl = document.getElementById('detailPhone');
            const waBtn = document.getElementById('detailWaBtn');
            if (user.phone) {
                phoneEl.textContent = user.phone;
                if (user.wa_link) {
                    waBtn.href = user.wa_link;
                    waBtn.classList.remove('hidden');
                } else {
                    waBtn.classList.add('hidden');
                }
            } else {
                phoneEl.textContent = 'Belum mencantumkan nomor';
                waBtn.classList.add('hidden');
            }

            // Aktivitas & Register date
            document.getElementById('detailBorrowingsCount').textContent = user.borrowings_count + ' Kali';
            document.getElementById('detailStudioCount').textContent = user.studio_bookings_count + ' Kali';
            document.getElementById('detailCreatedAt').textContent = user.created_at || '-';

            modal.classList.remove('hidden');
        }

        function closeUserDetail() {
            document.getElementById('userDetailModal').classList.add('hidden');
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeUserDetail();
            }
        });

        // Close on backdrop click
        document.getElementById('userDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserDetail();
            }
        });
    </script>
@endsection
