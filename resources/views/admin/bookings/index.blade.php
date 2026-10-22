@extends('layouts.admin')

@section('title', 'Booking Studio Musik')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Booking Studio Musik (STM)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola dan verifikasi jadwal latihan band dari anggota.</p>
        </div>
    </div>

    {{-- Mobile Card List for Admin (< md) --}}
    <div class="block md:hidden space-y-3.5 mb-6">
        @forelse($bookings as $booking)
            <div class="rounded-3xl border border-slate-200/80 bg-white p-4 shadow-sm space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-950 text-xs font-extrabold text-brand-300">
                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-extrabold text-slate-900 text-sm truncate">{{ $booking->user->name }}</p>
                            <p class="text-[11px] text-slate-400 truncate">{{ $booking->user->email }}</p>
                        </div>
                    </div>
                    
                    <span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider shrink-0
                        {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                        {{ $booking->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                        {{ $booking->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <div class="rounded-2xl bg-slate-50 p-3 text-xs space-y-1.5 border border-slate-100">
                    <div>
                        <span class="text-slate-400 font-medium text-[11px]">Keperluan Latihan:</span>
                        <p class="font-bold text-slate-800 mt-0.5 leading-snug">{{ $booking->purpose }}</p>
                    </div>
                    <div class="flex items-center justify-between text-slate-700 pt-1 border-t border-slate-200/60">
                        <span class="text-slate-400 font-medium">Jadwal:</span>
                        <div class="text-right">
                            <span class="font-bold text-slate-900">{{ $booking->start_time->format('d M Y') }}</span>
                            <span class="text-brand-700 font-semibold text-[11px]">({{ $booking->start_time->format('H:i') }}-{{ $booking->end_time->format('H:i') }})</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-slate-700 pt-1 border-t border-slate-200/60">
                        <span class="text-slate-400 font-medium">Surat Izin:</span>
                        <div>
                            @if($booking->permission_letter_path)
                                <a href="{{ asset('storage/' . $booking->permission_letter_path) }}" target="_blank" 
                                   class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-brand-50 px-2.5 py-1 text-[11px] font-bold text-brand-700 hover:bg-brand-100 transition-colors">
                                    <svg class="h-3.5 w-3.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Lihat Berkas</span>
                                </a>
                            @else
                                <span class="text-[11px] text-slate-400 italic">Tanpa surat</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($booking->status === 'pending')
                    <div class="flex items-center justify-end gap-2 pt-1">
                        @can('approve_bookings')
                            <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="tap-press rounded-xl bg-emerald-100 px-3.5 py-1.5 text-xs font-extrabold text-emerald-900 transition-all hover:bg-emerald-200">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="tap-press rounded-xl bg-rose-100 px-3.5 py-1.5 text-xs font-extrabold text-rose-900 transition-all hover:bg-rose-200">Tolak</button>
                            </form>
                        @else
                            <span class="text-xs text-slate-400 font-semibold italic">View-Only</span>
                        @endcan
                    </div>
                @endif
            </div>
        @empty
            <div class="rounded-3xl border border-slate-200/80 bg-white p-8 text-center text-xs font-semibold text-slate-400">
                Belum ada permohonan booking studio.
            </div>
        @endforelse
    </div>

    {{-- Desktop Table (>= md) --}}
    <div class="hidden md:block rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Pemohon</th>
                        <th class="px-6 py-4">Keperluan Latihan</th>
                        <th class="px-6 py-4">Waktu Booking</th>
                        <th class="px-6 py-4">Surat Izin</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="transition-colors hover:bg-slate-50/70">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-950 text-xs font-extrabold text-brand-300">
                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-extrabold text-slate-900">{{ $booking->user->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $booking->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-xs truncate px-6 py-4 font-semibold text-slate-800">{{ $booking->purpose }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="font-bold text-slate-900">{{ $booking->start_time->format('d M Y') }}</div>
                                <div class="text-[11px] text-slate-500 font-semibold">{{ $booking->start_time->format('H:i') }} — {{ $booking->end_time->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->permission_letter_path)
                                    <a href="{{ asset('storage/' . $booking->permission_letter_path) }}" target="_blank" 
                                       class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-brand-50 px-3 py-1.5 text-xs font-bold text-brand-700 transition-colors hover:bg-brand-100">
                                        <svg class="h-3.5 w-3.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Lihat Surat</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tanpa surat</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider
                                    {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                                    {{ $booking->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                                    {{ $booking->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @can('approve_bookings')
                                        @if($booking->status === 'pending')
                                            <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="tap-press rounded-xl bg-emerald-100 px-3.5 py-1.5 text-xs font-extrabold text-emerald-900 transition-all hover:bg-emerald-200">Setujui</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="tap-press rounded-xl bg-rose-100 px-3.5 py-1.5 text-xs font-extrabold text-rose-900 transition-all hover:bg-rose-200">Tolak</button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400 font-semibold">—</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-slate-400 font-semibold italic">View-Only</span>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-xs font-semibold text-slate-400">Belum ada permohonan booking studio.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
            <div class="border-t border-slate-100 px-6 py-4">{{ $bookings->links() }}</div>
        @endif
    </div>
@endsection
