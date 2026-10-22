@extends('layouts.admin')

@section('title', 'Peminjaman Ruang STM')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Peminjaman Ruang Studio STM</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar peminjaman ruang latihan musik STM, jadwal pemakaian, serta status persetujuannya.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('user.booking.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-2.5 text-xs font-extrabold text-white shadow-md shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Booking Ruang Studio</span>
            </a>
        </div>
    </div>

    {{-- Ringkasan Status --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-8">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Booking</p>
            <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $counts['all'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-amber-600">Menunggu Review</p>
            <p class="text-2xl font-extrabold text-amber-600 tracking-tight mt-1">{{ $counts['pending'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">Disetujui / Siap Pakai</p>
            <p class="text-2xl font-extrabold text-emerald-600 tracking-tight mt-1">{{ $counts['approved'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-rose-600">Ditolak / Bentrok</p>
            <p class="text-2xl font-extrabold text-rose-600 tracking-tight mt-1">{{ $counts['rejected'] }}</p>
        </div>
    </div>

    {{-- Filter Status Tabs --}}
    <div class="mb-5 flex items-center gap-2 overflow-x-auto no-scrollbar">
        <a href="{{ route('user.bookings.index', ['status' => 'all']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'all' ? 'bg-brand-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('user.bookings.index', ['status' => 'pending']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Menunggu Persetujuan ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('user.bookings.index', ['status' => 'approved']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('user.bookings.index', ['status' => 'rejected']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Ditolak ({{ $counts['rejected'] }})
        </a>
    </div>

    {{-- Mobile Cards View (< md) --}}
    <div class="block md:hidden space-y-3.5">
        @forelse($bookings as $booking)
            <div class="rounded-3xl border border-slate-200/80 bg-white p-4 shadow-sm space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-slate-900 text-sm truncate">Studio Musik Utama STM</h4>
                            <p class="text-[11px] text-slate-400 font-medium">ID Booking #{{ $booking->id }}</p>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="shrink-0">
                        @if($booking->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-extrabold text-amber-800 border border-amber-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Menunggu</span>
                            </span>
                        @elseif($booking->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-extrabold text-emerald-800 border border-emerald-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                <span>Disetujui</span>
                            </span>
                        @elseif($booking->status === 'rejected')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-extrabold text-rose-800 border border-rose-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                <span>Ditolak</span>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Purpose / Agenda --}}
                <div class="rounded-2xl bg-slate-50 p-3 text-xs space-y-1.5 border border-slate-100">
                    <p class="text-slate-400 font-medium text-[11px]">Keperluan / Agenda:</p>
                    <p class="font-bold text-slate-800 leading-snug">{{ $booking->purpose }}</p>
                </div>

                {{-- Schedule Info --}}
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-1.5 text-slate-700">
                        <svg class="h-4 w-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="font-bold">{{ $booking->start_time->format('d M Y') }}</span>
                        <span class="text-slate-400">({{ $booking->start_time->format('H:i') }}-{{ $booking->end_time->format('H:i') }})</span>
                    </div>
                </div>

                {{-- Footer: Surat Izin & Date --}}
                <div class="flex items-center justify-between pt-2 text-xs border-t border-slate-100">
                    <div>
                        @if($booking->permission_letter_path)
                            <a href="{{ asset('storage/' . $booking->permission_letter_path) }}" target="_blank" 
                               class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-brand-700 transition-colors">
                                <svg class="h-3.5 w-3.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                <span>Surat Izin</span>
                            </a>
                        @else
                            <span class="text-[11px] text-slate-400 italic">Tanpa surat izin</span>
                        @endif
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium">
                        Diajukan {{ $booking->created_at->format('d M Y') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-slate-200/80 bg-white p-8 text-center text-slate-400">
                <p class="text-sm font-semibold">Belum ada riwayat booking ruang studio musik STM.</p>
                <a href="{{ route('user.booking.create') }}" class="tap-press mt-3 inline-flex items-center gap-1.5 rounded-2xl bg-brand-600 px-4 py-2 text-xs font-extrabold text-white shadow-sm hover:bg-brand-700">
                    + Booking Ruangan Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- Tabel Booking Ruang STM (Desktop / Tablet >= md) --}}
    <div class="hidden md:block overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                        <th class="py-4 px-6">Ruangan yang Dipinjam</th>
                        <th class="py-4 px-6">Keperluan / Agenda</th>
                        <th class="py-4 px-6">Jadwal Pemakaian Ruang</th>
                        <th class="py-4 px-6">Surat Ijin Peminjaman</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Diajukan Pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- Ruangan yang Dipinjam --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold shrink-0">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-900 text-xs sm:text-sm">Studio Musik Utama STM</p>
                                        <p class="text-[11px] text-slate-400 font-medium">ID Booking #{{ $booking->id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Keperluan / Agenda --}}
                            <td class="py-4 px-6">
                                <p class="font-extrabold text-slate-800 line-clamp-2 max-w-xs">{{ $booking->purpose }}</p>
                            </td>

                            {{-- Jadwal Pemakaian Ruang --}}
                            <td class="py-4 px-6">
                                <p class="font-extrabold text-slate-800">{{ $booking->start_time->format('l, d M Y') }}</p>
                                <p class="text-[11px] text-brand-700 font-bold mt-0.5">Pukul {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }} WIB</p>
                            </td>

                            {{-- Surat Ijin Peminjaman --}}
                            <td class="py-4 px-6">
                                @if($booking->permission_letter_path)
                                    <a href="{{ asset('storage/' . $booking->permission_letter_path) }}" target="_blank" 
                                       class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-brand-700 transition-colors">
                                        <svg class="h-3.5 w-3.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span>Lihat Surat</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tanpa surat izin</span>
                                @endif
                            </td>

                            {{-- Status Ruang --}}
                            <td class="py-4 px-6">
                                @if($booking->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-extrabold text-amber-800 border border-amber-200">
                                        <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Menunggu Persetujuan</span>
                                    </span>
                                @elseif($booking->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-800 border border-emerald-200">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        <span>Disetujui / Jadwal Aktif</span>
                                    </span>
                                @elseif($booking->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-extrabold text-rose-800 border border-rose-200">
                                        <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                        <span>Pengajuan Ditolak</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Diajukan Pada --}}
                            <td class="py-4 px-6 text-right text-slate-500 font-medium">
                                {{ $booking->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <p class="text-sm font-semibold">Belum ada riwayat booking ruang studio musik STM.</p>
                                <a href="{{ route('user.booking.create') }}" class="tap-press mt-3 inline-flex items-center gap-1.5 rounded-2xl bg-brand-600 px-4 py-2 text-xs font-extrabold text-white shadow-sm hover:bg-brand-700">
                                    + Booking Ruangan Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
