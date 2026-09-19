@extends('layouts.admin')

@section('page-title', 'Kelola User')
@section('page-description', 'Kelola akun pengguna dan persetujuan pendaftaran.')

@section('content')
    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600">Nama</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Email</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Role</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Terdaftar</th>
                        <th class="px-6 py-4 text-right font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()"
                                            class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 transition-colors focus:border-brand-500 focus:ring-1 focus:ring-brand-500 focus:outline-none">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                        <option value="perkap" {{ $user->role === 'perkap' ? 'selected' : '' }}>Perkap</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_approved)
                                    <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$user->is_approved)
                                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 transition-colors hover:bg-green-100">
                                                Setujui
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 transition-colors hover:bg-amber-100">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition-colors hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada user terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
