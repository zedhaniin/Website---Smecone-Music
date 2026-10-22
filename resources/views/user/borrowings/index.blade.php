@extends('layouts.admin')

@section('title', 'Peminjaman Inven Barang')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Peminjaman Inven Barang Musik</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar barang dan alat musik yang dipinjam, surat izin peminjaman, serta status persetujuannya.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('user.borrowing.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-2.5 text-xs font-extrabold text-white shadow-md shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Pinjam Alat Musik</span>
            </a>
        </div>
    </div>

    {{-- Ringkasan Status --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 mb-8">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Permohonan</p>
            <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $counts['all'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-amber-600">Menunggu Review</p>
            <p class="text-2xl font-extrabold text-amber-600 tracking-tight mt-1">{{ $counts['pending'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-600">Disetujui / Aktif</p>
            <p class="text-2xl font-extrabold text-emerald-600 tracking-tight mt-1">{{ $counts['approved'] }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Sudah Dikembalikan</p>
            <p class="text-2xl font-extrabold text-slate-700 tracking-tight mt-1">{{ $counts['returned'] }}</p>
        </div>
    </div>

    {{-- Filter Status Tabs --}}
    <div class="mb-5 flex items-center gap-2 overflow-x-auto no-scrollbar">
        <a href="{{ route('user.borrowings.index', ['status' => 'all']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'all' ? 'bg-brand-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('user.borrowings.index', ['status' => 'pending']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Menunggu Persetujuan ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('user.borrowings.index', ['status' => 'approved']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('user.borrowings.index', ['status' => 'returned']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'returned' ? 'bg-slate-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Dikembalikan ({{ $counts['returned'] }})
        </a>
        <a href="{{ route('user.borrowings.index', ['status' => 'rejected']) }}" 
           class="rounded-xl px-3.5 py-1.5 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Ditolak ({{ $counts['rejected'] }})
        </a>
    </div>

    {{-- Mobile Cards View (< md) --}}
    <div class="block md:hidden space-y-3.5">
        @forelse($borrowings as $borrowing)
            @php
                $durationDays = $borrowing->start_date->diffInDays($borrowing->end_date) + 1;
            @endphp
            <div class="rounded-3xl border border-slate-200/80 bg-white p-4 shadow-sm space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-2xl bg-slate-900 border border-slate-200 flex items-center justify-center">
                            @if($borrowing->instrument->image_path)
                                <img src="{{ asset('storage/' . $borrowing->instrument->image_path) }}" alt="{{ $borrowing->instrument->name }}" class="h-full w-full object-cover">
                            @else
                                <svg class="h-6 w-6 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-slate-900 text-sm truncate">{{ $borrowing->instrument->name }}</h4>
                            <p class="text-[11px] text-slate-400 font-medium">ID #{{ $borrowing->id }}</p>
                        </div>
                    </div>
                    
                    {{-- Status Badge --}}
                    <div class="shrink-0">
                        @if($borrowing->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-extrabold text-amber-800 border border-amber-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Menunggu</span>
                            </span>
                        @elseif($borrowing->status === 'approved')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-extrabold text-emerald-800 border border-emerald-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                <span>Disetujui</span>
                            </span>
                        @elseif($borrowing->status === 'returned')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-extrabold text-slate-700 border border-slate-200">
                                <svg class="h-3 w-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Kembali</span>
                            </span>
                        @elseif($borrowing->status === 'rejected')
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-extrabold text-rose-800 border border-rose-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                <span>Ditolak</span>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Schedule Details --}}
                <div class="rounded-2xl bg-slate-50 p-3 text-xs space-y-1.5 border border-slate-100">
                    <div class="flex items-center justify-between text-slate-700">
                        <span class="text-slate-400 font-medium">Jadwal Pinjam:</span>
                        <span class="font-bold">{{ $borrowing->start_date->format('d M') }} — {{ $borrowing->end_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-700">
                        <span class="text-slate-400 font-medium">Durasi:</span>
                        <span class="font-extrabold text-brand-700">{{ $durationDays }} Hari</span>
                    </div>
                </div>

                {{-- Footer: Surat Izin & Date --}}
                <div class="flex items-center justify-between pt-1 text-xs">
                    <div>
                        @if($borrowing->permission_letter_path)
                            <a href="{{ asset('storage/' . $borrowing->permission_letter_path) }}" target="_blank" 
                               class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-brand-700 transition-colors">
                                <svg class="h-3.5 w-3.5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                <span>Surat Izin</span>
                            </a>
                        @else
                            <span class="text-[11px] text-slate-400 italic">Tanpa surat izin</span>
                        @endif
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium">
                        Diajukan {{ $borrowing->created_at->format('d M Y') }}
                    </span>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-slate-200/80 bg-white p-8 text-center text-slate-400">
                <p class="text-sm font-semibold">Belum ada riwayat peminjaman barang musik.</p>
                <a href="{{ route('user.borrowing.create') }}" class="tap-press mt-3 inline-flex items-center gap-1.5 rounded-2xl bg-brand-600 px-4 py-2 text-xs font-extrabold text-white shadow-sm hover:bg-brand-700">
                    + Pinjam Barang Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- Tabel Peminjaman Inven Barang (Desktop / Tablet >= md) --}}
    <div class="hidden md:block overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/75 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">
                        <th class="py-4 px-6">Barang / Alat yang Dipinjam</th>
                        <th class="py-4 px-6">Tanggal Peminjaman</th>
                        <th class="py-4 px-6">Surat Ijin Peminjaman</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Diajukan Pada</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($borrowings as $borrowing)
                        @php
                            $durationDays = $borrowing->start_date->diffInDays($borrowing->end_date) + 1;
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- Barang yang Dipinjam --}}
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3.5">
                                    <div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-2xl bg-slate-900 border border-slate-200 flex items-center justify-center">
                                        @if($borrowing->instrument->image_path)
                                            <img src="{{ asset('storage/' . $borrowing->instrument->image_path) }}" alt="{{ $borrowing->instrument->name }}" class="h-full w-full object-cover">
                                        @else
                                            <svg class="h-6 w-6 text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-extrabold text-slate-900 text-xs sm:text-sm">{{ $borrowing->instrument->name }}</p>
                                        <p class="text-[11px] text-slate-400 font-medium">ID Peminjaman #{{ $borrowing->id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tanggal Peminjaman --}}
                            <td class="py-4 px-6">
                                <p class="font-extrabold text-slate-800">{{ $borrowing->start_date->format('d M Y') }} s/d {{ $borrowing->end_date->format('d M Y') }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Durasi: <strong class="text-slate-600">{{ $durationDays }} Hari</strong></p>
                            </td>

                            {{-- Surat Ijin Peminjaman --}}
                            <td class="py-4 px-6">
                                @if($borrowing->permission_letter_path)
                                    <a href="{{ asset('storage/' . $borrowing->permission_letter_path) }}" target="_blank" 
                                       class="tap-press inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-brand-50 border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-brand-700 hover:border-brand-300 transition-colors">
                                        <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <span>Lihat Surat Izin</span>
                                    </a>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Tidak ada file</span>
                                @endif
                            </td>

                            {{-- Status Barang --}}
                            <td class="py-4 px-6">
                                @if($borrowing->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-extrabold text-amber-800 border border-amber-200">
                                        <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Menunggu Persetujuan</span>
                                    </span>
                                @elseif($borrowing->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-800 border border-emerald-200">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        <span>Disetujui / Sedang Dipinjam</span>
                                    </span>
                                @elseif($borrowing->status === 'returned')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-extrabold text-slate-700 border border-slate-200">
                                        <svg class="h-3.5 w-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>Sudah Dikembalikan</span>
                                    </span>
                                @elseif($borrowing->status === 'rejected')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-extrabold text-rose-800 border border-rose-200">
                                        <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                                        <span>Pengajuan Ditolak</span>
                                    </span>
                                @endif
                            </td>

                            {{-- Diajukan Pada --}}
                            <td class="py-4 px-6 text-right text-slate-500 font-medium">
                                {{ $borrowing->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <p class="text-sm font-semibold">Belum ada riwayat peminjaman barang musik.</p>
                                <a href="{{ route('user.borrowing.create') }}" class="tap-press mt-3 inline-flex items-center gap-1.5 rounded-2xl bg-brand-600 px-4 py-2 text-xs font-extrabold text-white shadow-sm hover:bg-brand-700">
                                    + Pinjam Barang Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
