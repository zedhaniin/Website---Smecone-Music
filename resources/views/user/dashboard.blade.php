@extends('layouts.admin')

@section('title', 'Dashboard Anggota')

@section('content')
    @php
        $activeBorrowingsCount = $borrowings->whereIn('status', ['pending', 'approved'])->count();
        $activeBookingsCount = $bookings->whereIn('status', ['pending', 'approved'])->count();
    @endphp

    {{-- Hero Greeting Banner for Anggota --}}
    <div class="relative mb-6 overflow-hidden rounded-3xl bg-brand-950 p-6 sm:p-8 text-white shadow-xl shadow-brand-950/20">
        <div class="absolute -right-12 -top-12 h-64 w-64 rounded-full bg-brand-500/20 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-brand-400/30 bg-brand-900/90 px-3.5 py-1 text-xs font-bold text-brand-300 backdrop-blur-md mb-3">
                    <span class="h-2 w-2 rounded-full bg-brand-400 animate-pulse"></span>
                    <span>Anggota Music</span>
                </div>

                {{-- Greeting with Clean Sparkle Icon --}}
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight flex items-center gap-3">
                    <span>Selamat Datang, {{ auth()->user()->name }}</span>
                    <svg class="h-7 w-7 text-brand-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </h1>

                <p class="mt-2 text-xs sm:text-sm text-slate-300 font-medium max-w-xl leading-relaxed">
                    Cek jadwal pemakaian studio & alat musik hari ini langsung di kalender interaktif di bawah.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('user.borrowing.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-xs font-extrabold text-brand-950 shadow-md transition-all duration-200 hover:-translate-y-0.5 hover:bg-slate-50">
                    <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Pinjam Alat Musik</span>
                </a>
                <a href="{{ route('user.booking.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Booking Studio STM</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Metric Summary Cards for Anggota --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-6">
        <div class="rounded-3xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Peminjaman Aktif Saya</p>
                <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-0.5">{{ $activeBorrowingsCount }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Booking Studio Aktif Saya</p>
                <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-0.5">{{ $activeBookingsCount }}</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/60 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Permohonan Saya</p>
                <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-0.5">{{ $borrowings->count() + $bookings->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Interactive Schedule Calendar Card (Embedded Directly on Dashboard) --}}
    <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Kalender Jadwal Studio & Peminjaman Alat</h3>
                <p class="text-xs text-slate-500 mt-0.5">Lihat ketersediaan slot waktu latihan studio dan peminjaman alat secara *real-time*.</p>
            </div>
            
            {{-- Calendar Legend --}}
            <div class="flex items-center gap-4 text-xs font-semibold text-slate-600">
                <span class="flex items-center gap-1.5 bg-brand-50 text-brand-700 px-3 py-1 rounded-full border border-brand-200">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#6C5CE7]"></span> [Studio] Booking STM
                </span>
                <span class="flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full border border-emerald-200">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#10B981]"></span> [Alat] Peminjaman
                </span>
            </div>
        </div>

        {{-- Calendar Element --}}
        <div id="calendar-dashboard" class="my-2"></div>
    </div>

    {{-- Preview Lists Row: Riwayat Peminjaman & Riwayat Booking --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Preview: Riwayat Peminjaman --}}
        <div class="rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Riwayat Peminjaman Saya</h3>
                    <p class="text-[11px] text-slate-400 font-semibold">{{ $borrowings->count() }} Permohonan</p>
                </div>
                <a href="{{ route('user.borrowing.create') }}" class="inline-flex items-center gap-1 rounded-xl bg-brand-50 px-3 py-1.5 text-xs font-extrabold text-brand-700 hover:bg-brand-100 transition-colors">
                    + Ajukan Pinjam
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($borrowings->take(4) as $borrowing)
                    <div class="flex items-center justify-between px-6 py-4 transition-colors hover:bg-slate-50/70">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-extrabold text-slate-900">{{ $borrowing->instrument->name }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-0.5">{{ $borrowing->start_date->format('d M Y') }} — {{ $borrowing->end_date->format('d M Y') }}</p>
                        </div>
                        <span class="ml-3 shrink-0 rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider
                            {{ $borrowing->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                            {{ $borrowing->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                            {{ $borrowing->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}
                            {{ $borrowing->status === 'returned' ? 'bg-slate-100 text-slate-700 border border-slate-200/80' : '' }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-xs font-semibold text-slate-400">Belum ada riwayat peminjaman alat.</div>
                @endforelse
            </div>
        </div>

        {{-- Preview: Riwayat Booking Studio --}}
        <div class="rounded-3xl border border-slate-200/60 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900">Riwayat Booking Studio Saya</h3>
                    <p class="text-[11px] text-slate-400 font-semibold">{{ $bookings->count() }} Permohonan</p>
                </div>
                <a href="{{ route('user.booking.create') }}" class="inline-flex items-center gap-1 rounded-xl bg-brand-50 px-3 py-1.5 text-xs font-extrabold text-brand-700 hover:bg-brand-100 transition-colors">
                    + Ajukan Booking
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($bookings->take(4) as $booking)
                    <div class="flex items-center justify-between px-6 py-4 transition-colors hover:bg-slate-50/70">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-xs font-extrabold text-slate-900">{{ $booking->purpose }}</p>
                            <p class="text-[11px] font-semibold text-slate-500 mt-0.5">{{ $booking->start_time->format('d M Y H:i') }} — {{ $booking->end_time->format('H:i') }}</p>
                        </div>
                        <span class="ml-3 shrink-0 rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider
                            {{ $booking->status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-200/80' : '' }}
                            {{ $booking->status === 'approved' ? 'bg-emerald-100 text-emerald-900 border border-emerald-200' : '' }}
                            {{ $booking->status === 'rejected' ? 'bg-rose-100 text-rose-900 border border-rose-200/80' : '' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-xs font-semibold text-slate-400">Belum ada riwayat booking studio.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <style>
        .fc-toolbar-title { font-size: 1.05rem !important; font-weight: 800 !important; color: #0f172a; }
        .fc-button-primary { background-color: #6C5CE7 !important; border-color: #5b4cc4 !important; font-size: 0.75rem !important; font-weight: 700 !important; border-radius: 12px !important; }
        .fc-button-primary:hover { background-color: #5b4cc4 !important; }
        .fc-event { border-radius: 8px !important; padding: 3px 6px !important; font-size: 0.75rem !important; font-weight: 700 !important; border: 0 !important; }
        .fc-daygrid-day-number { font-size: 0.8rem; font-weight: 600; color: #334155; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar-dashboard');
            if (!calendarEl) return;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: @json($events),
                height: 'auto',
            });
            calendar.render();
        });
    </script>
@endpush
