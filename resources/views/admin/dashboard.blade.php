@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Hero Greeting Banner (Brand Purple Palette) --}}
    <div class="relative mb-6 overflow-hidden rounded-3xl bg-brand-950 p-6 sm:p-8 text-white shadow-xl shadow-brand-950/20">
        {{-- Background Glow Accent --}}
        <div class="absolute -right-12 -top-12 h-64 w-64 rounded-full bg-brand-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-brand-400/30 bg-brand-900/90 px-3.5 py-1 text-xs font-bold text-brand-300 backdrop-blur-md mb-3">
                    <span class="h-2 w-2 rounded-full bg-brand-400 animate-pulse"></span>
                    <span>{{ auth()->user()->isAdmin() ? 'Admin Music' : 'Perkap Music' }}</span>
                </div>
                
                {{-- Greeting Title with Clean Sparkle Icon --}}
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                    <span>Selamat Datang, {{ auth()->user()->name }}</span>
                    <svg class="h-7 w-7 text-brand-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </h1>

                <p class="mt-2 text-xs sm:text-sm text-slate-300 font-medium max-w-xl leading-relaxed">
                    Kelola permohonan peminjaman alat, reservasi Studio STM, serta pemantauan data anggota Smecone Music secara fleksibel dan terpadu.
                </p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.members.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Kelola Pengurus</span>
                    </a>
                @else
                    <a href="{{ route('admin.borrowings.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Verifikasi Peminjaman</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Metric Stat Cards Grid --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        {{-- Card 1: Total Users --}}
        <div class="group rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total User</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalUsers }}</p>
                </div>
                <div class="flex h-13 w-13 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
            </div>
            @if($pendingUsers > 0)
                <div class="mt-4 flex items-center gap-1.5 text-xs font-bold text-amber-700 bg-amber-50 rounded-xl px-3 py-1.5 w-fit border border-amber-200/60">
                    <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $pendingUsers }} perlu persetujuan
                </div>
            @else
                <p class="mt-4 text-xs font-medium text-slate-400 flex items-center gap-1">
                    <svg class="h-3.5 w-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Semua user telah aktif
                </p>
            @endif
        </div>

        {{-- Card 2: Inventaris Alat --}}
        <div class="group rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Inventaris Alat</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalInstruments }}</p>
                </div>
                <div class="flex h-13 w-13 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-slate-400">Alat musik terdaftar & aktif</p>
        </div>

        {{-- Card 3: Peminjaman Pending --}}
        <div class="group rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Peminjaman Pending</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">{{ $pendingBorrowings }}</p>
                </div>
                <div class="flex h-13 w-13 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-slate-400">Permohonan pinjam alat</p>
        </div>

        {{-- Card 4: Booking Studio Pending --}}
        <div class="group rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Booking Pending</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">{{ $pendingBookings }}</p>
                </div>
                <div class="flex h-13 w-13 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-slate-400">Reservasi studio musik</p>
        </div>
    </div>

    {{-- Activity & Status Widget Row --}}
    <div class="mb-8">
        {{-- Ringkasan Sistem & Konten --}}
        <div class="rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Aktivitas & Status Operasional</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ auth()->user()->isAdmin() ? 'Statistik konten dan inventaris Smecone Music' : 'Statistik operasional inventaris alat & booking studio' }}
                    </p>
                </div>
                <span class="rounded-full bg-emerald-50 px-3.5 py-1 text-xs font-bold text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Aktif
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @if(auth()->user()->isAdmin())
                    <div class="flex items-center gap-4 rounded-2xl bg-amber-50/60 p-4 border border-amber-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700 shrink-0 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $totalGalleries }}</p>
                            <p class="text-[11px] font-semibold text-slate-500">Foto Galeri</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 rounded-2xl bg-blue-50/60 p-4 border border-blue-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700 shrink-0 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $totalShowcases }}</p>
                            <p class="text-[11px] font-semibold text-slate-500">Showcase Karya</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 rounded-2xl bg-brand-50/60 p-4 border border-brand-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-100 text-brand-700 shrink-0 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $totalMembers }}</p>
                            <p class="text-[11px] font-semibold text-slate-500">Pengurus Aktif</p>
                        </div>
                    </div>
                @else
                    {{-- Perkap Specific Activity Summary --}}
                    <div class="flex items-center gap-4 rounded-2xl bg-emerald-50/60 p-4 border border-emerald-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 shrink-0 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $availableInstruments }}</p>
                            <p class="text-[11px] font-semibold text-slate-500">Alat Siap Pinjam</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 rounded-2xl bg-brand-50/60 p-4 border border-brand-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-100 text-brand-700 shrink-0 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $approvedBorrowings }}</p>
                            <p class="text-[11px] font-semibold text-slate-500">Peminjaman Disetujui</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 rounded-2xl bg-blue-50/60 p-4 border border-blue-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700 shrink-0 font-bold">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $approvedBookings }}</p>
                            <p class="text-[11px] font-semibold text-slate-500">Booking Studio Disetujui</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Decorative Bar Chart --}}
            <div class="mt-6 pt-5 border-t border-slate-100">
                <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-3">
                    <span>Intensitas Peminjaman & Booking Mingguan</span>
                    <span class="text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">+12% aktivitas pekan ini</span>
                </div>
                <div class="flex items-end gap-3 h-24 pt-4">
                    <div class="flex-1 bg-slate-100 rounded-xl h-[40%] hover:bg-brand-600 transition-colors relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 text-[10px] font-bold bg-slate-900 text-white px-1.5 py-0.5 rounded transition-opacity">Sen</span>
                    </div>
                    <div class="flex-1 bg-slate-100 rounded-xl h-[65%] hover:bg-brand-600 transition-colors relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 text-[10px] font-bold bg-slate-900 text-white px-1.5 py-0.5 rounded transition-opacity">Sel</span>
                    </div>
                    <div class="flex-1 bg-slate-100 rounded-xl h-[45%] hover:bg-brand-600 transition-colors relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 text-[10px] font-bold bg-slate-900 text-white px-1.5 py-0.5 rounded transition-opacity">Rab</span>
                    </div>
                    <div class="flex-1 bg-brand-950 rounded-xl h-[90%] relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 text-[10px] font-bold bg-brand-950 text-brand-300 px-1.5 py-0.5 rounded">Kam</span>
                    </div>
                    <div class="flex-1 bg-slate-100 rounded-xl h-[70%] hover:bg-brand-600 transition-colors relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 text-[10px] font-bold bg-slate-900 text-white px-1.5 py-0.5 rounded transition-opacity">Jum</span>
                    </div>
                    <div class="flex-1 bg-slate-100 rounded-xl h-[30%] hover:bg-brand-600 transition-colors relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 text-[10px] font-bold bg-slate-900 text-white px-1.5 py-0.5 rounded transition-opacity">Sab</span>
                    </div>
                    <div class="flex-1 bg-slate-100 rounded-xl h-[20%] hover:bg-brand-600 transition-colors relative group">
                        <span class="absolute -top-7 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 text-[10px] font-bold bg-slate-900 text-white px-1.5 py-0.5 rounded transition-opacity">Min</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity Tables Row --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Recent Borrowings --}}
        <div class="rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-sm font-extrabold text-slate-900">Peminjaman Terbaru</h3>
                <a href="{{ route('admin.borrowings.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentBorrowings as $borrowing)
                    <div class="flex items-center justify-between px-6 py-4 transition-colors hover:bg-slate-50/70">
                        <div class="flex items-center gap-3.5 min-w-0 flex-1">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-950 text-xs font-extrabold text-brand-300">
                                {{ strtoupper(substr($borrowing->user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-xs font-extrabold text-slate-900">{{ $borrowing->user->name }}</p>
                                <p class="text-[11px] font-semibold text-slate-500 mt-0.5">{{ $borrowing->instrument->name }} · {{ $borrowing->start_date->format('d M Y') }}</p>
                            </div>
                        </div>

                        <span class="ml-3 inline-flex shrink-0 rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider
                            {{ $borrowing->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                            {{ $borrowing->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                            {{ $borrowing->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}
                            {{ $borrowing->status === 'returned' ? 'bg-slate-100 text-slate-700 border border-slate-200/80' : '' }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-xs font-semibold text-slate-400">Belum ada aktivitas peminjaman.</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Bookings --}}
        <div class="rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="text-sm font-extrabold text-slate-900">Booking Studio Terbaru</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between px-6 py-4 transition-colors hover:bg-slate-50/70">
                        <div class="flex items-center gap-3.5 min-w-0 flex-1">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-950 text-xs font-extrabold text-brand-300">
                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-xs font-extrabold text-slate-900">{{ $booking->user->name }}</p>
                                <p class="text-[11px] font-semibold text-slate-500 mt-0.5 truncate">{{ $booking->purpose }} · {{ $booking->start_time->format('d M H:i') }}</p>
                            </div>
                        </div>

                        <span class="ml-3 inline-flex shrink-0 rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider
                            {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                            {{ $booking->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                            {{ $booking->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-xs font-semibold text-slate-400">Belum ada aktivitas booking studio.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
