@extends('layouts.admin')

@section('title', 'Booking Studio Musik')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Booking Studio Musik (STM)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola dan verifikasi jadwal latihan band dari anggota.</p>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Pemohon</th>
                        <th class="px-6 py-4">Keperluan Latihan</th>
                        <th class="px-6 py-4">Waktu Booking</th>
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
                                <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider
                                    {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                                    {{ $booking->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                                    {{ $booking->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if($booking->status === 'pending')
                                        <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-xl bg-emerald-100 px-3.5 py-1.5 text-xs font-extrabold text-emerald-900 transition-all hover:bg-emerald-200">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="rounded-xl bg-rose-100 px-3.5 py-1.5 text-xs font-extrabold text-rose-900 transition-all hover:bg-rose-200">Tolak</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 font-semibold">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-xs font-semibold text-slate-400">Belum ada permohonan booking studio.</td>
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
