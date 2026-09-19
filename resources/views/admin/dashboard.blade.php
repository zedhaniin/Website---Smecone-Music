@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan data dan aktivitas terbaru Smecone Music.')

@section('content')
    {{-- Hero Greeting Banner --}}
    <div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-r from-brand-950 via-brand-900 to-gray-950 p-6 sm:p-8 text-white shadow-xl shadow-brand-950/20">
        <div class="absolute -right-10 -bottom-10 h-64 w-64 rounded-full bg-brand-500/20 blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-brand-400/30 bg-brand-900/60 px-3.5 py-1 text-xs font-bold text-brand-200 backdrop-blur-md mb-3">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Admin Workspace</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="mt-2 text-sm text-brand-200/90 font-medium max-w-xl">
                    Kelola data anggota, inventaris alat musik, pengajuan peminjaman, dan konten website Smecone Music dalam satu panel terpadu.
                </p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.members.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-xs font-extrabold text-brand-950 shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-50">
                    <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Kelola Pengurus</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="group rounded-3xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Total User</p>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalUsers }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
            </div>
            @if($pendingUsers > 0)
                <div class="mt-4 flex items-center gap-1.5 text-xs font-bold text-amber-600 bg-amber-50 rounded-xl px-3 py-1.5 w-fit">
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                    {{ $pendingUsers }} menunggu persetujuan
                </div>
            @else
                <p class="mt-4 text-xs font-medium text-gray-400">Semua user aktif</p>
            @endif
        </div>

        <div class="group rounded-3xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Inventaris Alat</p>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">{{ $totalInstruments }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-gray-400">Alat musik terdaftar</p>
        </div>

        <div class="group rounded-3xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Peminjaman Pending</p>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">{{ $pendingBorrowings }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-gray-400">Permohonan pinjam alat</p>
        </div>

        <div class="group rounded-3xl border border-gray-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-brand-500/10">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Booking Pending</p>
                    <p class="mt-2 text-3xl font-extrabold text-gray-900 tracking-tight">{{ $pendingBookings }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-gray-400">Reservasi studio musik</p>
        </div>
    </div>

    {{-- Content Quick Stats --}}
    <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="flex items-center gap-4 rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pink-50 text-pink-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ $totalGalleries }}</p>
                <p class="text-xs font-medium text-gray-500">Dokumentasi Galeri Foto</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ $totalShowcases }}</p>
                <p class="text-xs font-medium text-gray-500">Showcase Prestasi & Karya</p>
            </div>
        </div>

        <div class="flex items-center gap-4 rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ $totalMembers }}</p>
                <p class="text-xs font-medium text-gray-500">Anggota Pengurus Aktif</p>
            </div>
        </div>
    </div>

    {{-- Recent Activity Tables --}}
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Recent Borrowings --}}
        <div class="rounded-3xl border border-gray-100 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-base font-extrabold text-gray-900">Peminjaman Terbaru</h3>
                <a href="{{ route('admin.borrowings.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentBorrowings as $borrowing)
                    <div class="flex items-center justify-between px-6 py-4 transition-colors hover:bg-gray-50/50">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-extrabold text-gray-900">{{ $borrowing->user->name }}</p>
                            <p class="text-xs font-medium text-gray-500 mt-0.5">{{ $borrowing->instrument->name }} · {{ $borrowing->start_date->format('d M Y') }}</p>
                        </div>
                        <span class="ml-3 inline-flex shrink-0 rounded-full px-3 py-1 text-xs font-extrabold uppercase tracking-wider
                            {{ $borrowing->status === 'pending' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60' : '' }}
                            {{ $borrowing->status === 'approved' ? 'bg-green-50 text-green-700 ring-1 ring-green-200/60' : '' }}
                            {{ $borrowing->status === 'rejected' ? 'bg-red-50 text-red-700 ring-1 ring-red-200/60' : '' }}
                            {{ $borrowing->status === 'returned' ? 'bg-gray-100 text-gray-600 ring-1 ring-gray-200/60' : '' }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm font-medium text-gray-400">Belum ada aktivitas peminjaman.</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Bookings --}}
        <div class="rounded-3xl border border-gray-100 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-base font-extrabold text-gray-900">Booking Studio Terbaru</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">Lihat Semua →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between px-6 py-4 transition-colors hover:bg-gray-50/50">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-extrabold text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-xs font-medium text-gray-500 mt-0.5">{{ $booking->purpose }} · {{ $booking->start_time->format('d M Y H:i') }}</p>
                        </div>
                        <span class="ml-3 inline-flex shrink-0 rounded-full px-3 py-1 text-xs font-extrabold uppercase tracking-wider
                            {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/60' : '' }}
                            {{ $booking->status === 'approved' ? 'bg-green-50 text-green-700 ring-1 ring-green-200/60' : '' }}
                            {{ $booking->status === 'rejected' ? 'bg-red-50 text-red-700 ring-1 ring-red-200/60' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm font-medium text-gray-400">Belum ada aktivitas booking studio.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
