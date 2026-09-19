@extends('layouts.admin')

@section('page-title', 'Peminjaman Alat')
@section('page-description', 'Kelola permohonan peminjaman alat musik.')

@section('content')
    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-gray-100 bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600">Pemohon</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Alat</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Surat Izin</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-4 text-right font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($borrowings as $borrowing)
                        <tr class="transition-colors hover:bg-gray-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">
                                        {{ strtoupper(substr($borrowing->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $borrowing->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $borrowing->instrument->name }}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="text-xs">{{ $borrowing->start_date->format('d M Y') }} — {{ $borrowing->end_date->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ asset('storage/' . $borrowing->permission_letter_path) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-600 transition-colors hover:text-brand-700">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Lihat
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                    {{ $borrowing->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                    {{ $borrowing->status === 'approved' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $borrowing->status === 'rejected' ? 'bg-red-50 text-red-700' : '' }}
                                    {{ $borrowing->status === 'returned' ? 'bg-gray-100 text-gray-600' : '' }}">
                                    {{ ucfirst($borrowing->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if($borrowing->status === 'pending')
                                        <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 transition-colors hover:bg-green-100">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition-colors hover:bg-red-100">Tolak</button>
                                        </form>
                                    @elseif($borrowing->status === 'approved')
                                        <form method="POST" action="{{ route('admin.borrowings.returned', $borrowing) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition-colors hover:bg-blue-100">Dikembalikan</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">Belum ada permohonan peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($borrowings->hasPages())
            <div class="border-t border-gray-100 px-6 py-4">{{ $borrowings->links() }}</div>
        @endif
    </div>
@endsection
