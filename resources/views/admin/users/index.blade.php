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
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Email</th>
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
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-950 text-xs font-extrabold text-brand-300">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-extrabold text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()"
                                            class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-extrabold text-slate-800 transition-all focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User (Anggota)</option>
                                        <option value="perkap" {{ $user->role === 'perkap' ? 'selected' : '' }}>Perkap</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
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
                                    @if(!$user->is_approved)
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-xl bg-emerald-100 px-3.5 py-1.5 text-xs font-extrabold text-emerald-900 transition-all hover:bg-emerald-200">
                                                Setujui
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-xl bg-amber-100 px-3.5 py-1.5 text-xs font-extrabold text-amber-900 transition-all hover:bg-amber-200">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-xl bg-rose-100 px-3.5 py-1.5 text-xs font-extrabold text-rose-900 transition-all hover:bg-rose-200">
                                            Hapus
                                        </button>
                                    </form>
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
@endsection
