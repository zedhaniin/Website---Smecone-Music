<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Smecone Music</title>
    
    {{-- Favicon Smecone Music --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    {{-- Google Fonts: Plus Jakarta Sans & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100/90 font-sans text-slate-800 antialiased min-h-screen">
    @php
        $divisionsList = \Illuminate\Support\Facades\Schema::hasTable('divisions') ? \App\Models\Division::orderBy('order')->get() : collect();
    @endphp
    <div class="min-h-screen relative">
        
        {{-- Floating Dark Sidebar (Smecone Music Purple Theme) --}}
        <aside class="fixed top-3 bottom-3 left-3 z-50 flex w-64 lg:w-72 flex-col justify-between rounded-3xl bg-brand-950 p-5 text-slate-300 shadow-2xl shadow-brand-950/30 transition-transform duration-300 max-lg:-translate-x-full border border-brand-900/50" id="sidebar">
            <div class="flex flex-col h-full justify-between overflow-y-auto no-scrollbar">
                <div>
                    {{-- Brand Header --}}
                    <div class="flex items-center justify-between px-2 py-1 mb-6">
                        <div class="flex items-center gap-3.5">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-brand-900 p-0.5 ring-2 ring-brand-500/40">
                                <img src="{{ asset('images/logo.png') }}" alt="Smecone Music" class="h-full w-full rounded-xl object-cover">
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-base font-extrabold tracking-wide text-white">Smecone Music</h2>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="h-2 w-2 rounded-full bg-brand-400"></span>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-brand-300">
                                        {{ auth()->user()->isAdmin() ? 'Admin Panel' : 'Member Panel' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Close Drawer Button --}}
                        <button type="button" 
                                id="sidebar-close-btn"
                                aria-label="Tutup Menu"
                                class="tap-press lg:hidden flex h-8 w-8 items-center justify-center rounded-xl bg-brand-900 text-brand-300 hover:text-white hover:bg-brand-850 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Dynamic Navigation Links --}}
                    <nav class="space-y-1.5">
                        {{-- Role Scoping --}}
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ route('admin.borrowings.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.borrowings.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.borrowings.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                <span>Peminjaman Alat</span>
                            </a>

                            <a href="{{ route('admin.bookings.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.bookings.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Booking Studio</span>
                            </a>

                            <div class="pt-4 pb-1 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Manajemen App</div>

                            <a href="{{ route('admin.users.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                                <span>Kelola User</span>
                            </a>

                            @can('manage_roles')
                            <a href="{{ route('admin.roles.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.roles.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Role & Hak Akses</span>
                            </a>
                            @endcan

                            <a href="{{ route('admin.instruments.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.instruments.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.instruments.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                <span>Inventaris Alat</span>
                            </a>

                            <div class="pt-4 pb-1 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Konten Web</div>

                            <a href="{{ route('admin.galleries.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.galleries.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.galleries.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Galeri Foto</span>
                            </a>

                            <a href="{{ route('admin.showcases.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.showcases.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.showcases.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>Showcase Prestasi</span>
                            </a>

                            <a href="{{ route('admin.members.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.members.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.members.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span>Struktur Pengurus</span>
                            </a>
                        @else
                            {{-- User / Anggota Only --}}
                            <a href="{{ route('user.dashboard') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard Saya</span>
                            </a>

                            <div class="pt-4 pb-1 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Peminjaman & Ruangan</div>

                            <a href="{{ route('user.borrowings.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.borrowing*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.borrowing*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                <span>Inven Barang Musik</span>
                            </a>

                            <a href="{{ route('user.bookings.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.booking*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.booking*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Ruang Studio STM</span>
                            </a>

                            <a href="{{ route('user.instruments.index') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.instruments.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.instruments.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                <span>Katalog Alat Musik</span>
                            </a>
                        @endif
                    </nav>
                </div>

                {{-- Sidebar Bottom: Return to Public Site --}}
                <div class="mt-8 pt-4 border-t border-brand-900/60">
                    {{-- Return to Public Website Button --}}
                    <a href="{{ route('landing') }}" class="group flex items-center justify-center gap-2.5 rounded-2xl bg-brand-900/80 hover:bg-brand-800 text-white font-bold text-xs py-3 px-4 transition-all duration-200 border border-brand-800/80 shadow-md hover:shadow-lg">
                        <svg class="h-4 w-4 text-brand-300 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Lihat Website Utama</span>
                    </a>
                </div>
            </div>
        </aside>

        {{-- Mobile Sidebar Backdrop with smooth fade --}}
        <div id="sidebar-backdrop" 
             class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden hidden opacity-0 transition-opacity duration-300"></div>

        {{-- Main Content Area with Left Margin for Sidebar and Bottom Margin for Mobile Bar --}}
        <div class="lg:ml-80 p-3 sm:p-5 lg:p-6 pb-28 lg:pb-6 min-h-screen flex flex-col justify-between">
            <div>
                {{-- Top Navbar Header --}}
                <header class="mb-6 flex items-center justify-between rounded-3xl bg-white p-3.5 sm:p-4 shadow-sm border border-slate-200/60">
                    <div class="flex items-center gap-3.5">
                        {{-- Mobile menu button --}}
                        <button type="button" 
                                id="sidebar-open-btn"
                                aria-label="Buka Menu"
                                class="tap-press flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-700 transition-colors hover:bg-slate-200 lg:hidden">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>

                        {{-- Left Header Info: Tanggal untuk Admin, Status + Tanggal untuk Member --}}
                        <div class="flex items-center gap-3">
                            @if(auth()->user()->isAdmin())
                                {{-- Admin Panel: Hanya Tanggal Hari Ini --}}
                                <div class="flex items-center gap-2 rounded-2xl bg-slate-50 border border-slate-200/80 px-3.5 py-1.5 text-xs font-semibold text-slate-600 shadow-2xs">
                                    <svg class="h-4 w-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-bold text-slate-800">{{ now()->locale('id')->translatedFormat('l, d M Y') }}</span>
                                </div>
                            @else
                                {{-- Member Panel: Live Contextual Status Pill --}}
                                @if(request()->routeIs(['*instruments*', '*borrowing*']))
                                    <div class="inline-flex items-center gap-2 rounded-2xl bg-emerald-50 border border-emerald-200/80 px-3.5 py-1.5 text-xs font-bold text-emerald-800 shadow-2xs">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                        <span>Alat Musik Tersedia</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-2 rounded-2xl bg-brand-50 border border-brand-200/80 px-3.5 py-1.5 text-xs font-bold text-brand-800 shadow-2xs">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-600"></span>
                                        </span>
                                        <span>Studio Siap Pakai</span>
                                    </div>
                                @endif

                                {{-- Divider & Tanggal Hari Ini --}}
                                <div class="hidden sm:flex items-center gap-3">
                                    <span class="h-4 w-px bg-slate-200"></span>
                                    <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-500">
                                        <svg class="h-4 w-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ now()->locale('id')->translatedFormat('l, d M Y') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Right Navigation Items (User Profile Pill only) --}}
                    <div class="flex items-center gap-3">
                        {{-- User Profile Pill Dropdown --}}
                        <div class="flex items-center gap-2 sm:gap-3 rounded-2xl bg-slate-100 p-1.5 pr-2.5 sm:pr-3 border border-slate-200/60 shadow-2xs">
                            {{-- Clickable Avatar & Name to open Settings Modal --}}
                            <button type="button" 
                                    id="btn-open-profile-avatar"
                                    onclick="openProfileModal('info')" 
                                    title="Klik untuk membuka Pengaturan Akun"
                                    class="group flex items-center gap-2.5 sm:gap-3 text-left focus:outline-none cursor-pointer">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-950 text-xs font-bold text-brand-300 shadow-sm transition-transform duration-200 group-hover:scale-105">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden md:block min-w-0">
                                    <p class="truncate text-xs font-bold text-slate-900 leading-tight group-hover:text-brand-600 transition-colors">{{ auth()->user()->name }}</p>
                                    <p class="truncate text-[10px] font-semibold text-slate-500 uppercase tracking-wider">{{ auth()->user()->role_label }}</p>
                                </div>
                            </button>

                            <div class="flex items-center gap-1.5 ml-1">
                                {{-- Settings / Gear Button --}}
                                <button type="button" 
                                        id="btn-open-profile-settings"
                                        onclick="openProfileModal('info')" 
                                        title="Pengaturan Akun & Password" 
                                        class="tap-press flex h-8 w-8 items-center justify-center rounded-xl bg-white text-slate-600 border border-slate-200/80 shadow-xs transition-all hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>

                                {{-- Logout Button --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" title="Logout" class="tap-press flex h-8 w-8 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition-colors hover:bg-rose-100">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-5 flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-xs font-bold text-emerald-900 shadow-sm animate-slide-down" id="flash-success">
                        <div class="flex items-center gap-3">
                            <div class="flex h-7 w-7 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shrink-0">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-5 flex items-center justify-between rounded-2xl border border-rose-200 bg-rose-50 px-5 py-3.5 text-xs font-bold text-rose-900 shadow-sm animate-slide-down" id="flash-error">
                        <div class="flex items-center gap-3">
                            <div class="flex h-7 w-7 items-center justify-center rounded-xl bg-rose-100 text-rose-600 shrink-0">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{-- Dynamic Page Body Content --}}
                <div class="flex-1">
                    @yield('content')
                </div>
            </div>
        </div>

        {{-- Fixed Mobile Bottom Navigation Bar (Modern Ergonomic UX) --}}
        <div class="fixed bottom-3 inset-x-3 z-40 lg:hidden">
            <nav class="max-w-md mx-auto rounded-3xl bg-brand-950/95 backdrop-blur-2xl border border-brand-800/80 shadow-2xl shadow-brand-950/40 p-1.5 flex items-center justify-around text-slate-400">
                @if(auth()->user()->isAdmin())
                    {{-- Admin Mobile Nav Items --}}
                    <a href="{{ route('admin.dashboard') }}" 
                       class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl transition-all {{ request()->routeIs('admin.dashboard') ? 'text-white bg-brand-600/90 shadow-md font-bold' : 'hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span class="text-[10px] font-semibold">Home</span>
                    </a>

                    <a href="{{ route('admin.borrowings.index') }}" 
                       class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl transition-all {{ request()->routeIs('admin.borrowings.*') ? 'text-white bg-brand-600/90 shadow-md font-bold' : 'hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <span class="text-[10px] font-semibold">Pinjam</span>
                    </a>

                    <a href="{{ route('admin.bookings.index') }}" 
                       class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl transition-all {{ request()->routeIs('admin.bookings.*') ? 'text-white bg-brand-600/90 shadow-md font-bold' : 'hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[10px] font-semibold">Booking</span>
                    </a>

                    <button type="button" 
                            id="mobile-menu-trigger-admin"
                            class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl hover:text-white transition-all">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <span class="text-[10px] font-semibold">Kelola</span>
                    </button>
                @else
                    {{-- Member Mobile Nav Items --}}
                    <a href="{{ route('user.dashboard') }}" 
                       class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl transition-all {{ request()->routeIs('user.dashboard') ? 'text-white bg-brand-600/90 shadow-md font-bold' : 'hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="text-[10px] font-semibold">Home</span>
                    </a>

                    <a href="{{ route('user.borrowings.index') }}" 
                       class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl transition-all {{ request()->routeIs('user.borrowing*') ? 'text-white bg-brand-600/90 shadow-md font-bold' : 'hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <span class="text-[10px] font-semibold">Inven</span>
                    </a>

                    <a href="{{ route('user.bookings.index') }}" 
                       class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl transition-all {{ request()->routeIs('user.booking*') ? 'text-white bg-brand-600/90 shadow-md font-bold' : 'hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="text-[10px] font-semibold">Studio</span>
                    </a>

                    <button type="button" 
                            id="mobile-menu-trigger-user"
                            class="tap-press flex flex-col items-center gap-1 py-1.5 px-3 rounded-2xl hover:text-white transition-all">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <span class="text-[10px] font-semibold">Menu</span>
                    </button>
                @endif
            </nav>
        </div>

        {{-- Modern Profile Settings & Password Modal Popup (Positioned at root container, visible on both desktop & mobile) --}}
        <div id="profile-settings-modal"
             class="fixed inset-0 z-50 overflow-y-auto hidden" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div onclick="closeProfileModal()"
                 id="profile-modal-backdrop"
                 class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"></div>

            <div class="flex min-h-full items-center justify-center p-3 sm:p-4 text-center">
                <div onclick="event.stopPropagation()"
                     id="profile-modal-card"
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-xl border border-slate-200/80 z-10">
                    
                    {{-- Modal Header Banner --}}
                    <div class="relative bg-gradient-to-br from-brand-950 via-brand-900 to-slate-900 p-5 sm:p-6 text-white overflow-hidden">
                        {{-- Background Glow --}}
                        <div class="absolute -right-10 -top-10 h-44 w-44 rounded-full bg-brand-500/20 blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 text-brand-300 text-lg font-black shadow-inner">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base sm:text-lg font-extrabold text-white tracking-tight leading-snug truncate">Pengaturan Akun & Keamanan</h3>
                                    <p class="text-xs text-brand-200/80 mt-0.5 truncate">Kelola data profil, divisi spesialisasi, dan ganti kata sandi.</p>
                                </div>
                            </div>
                            <button type="button" 
                                    onclick="closeProfileModal()" 
                                    id="btn-close-profile-modal"
                                    class="shrink-0 rounded-xl bg-white/10 p-2 text-white/70 hover:bg-white/20 hover:text-white transition-colors cursor-pointer"
                                    title="Tutup Modal">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        {{-- Tab Switcher --}}
                        <div class="relative z-10 mt-5 flex rounded-2xl bg-white/10 p-1 backdrop-blur-md border border-white/10">
                            <button type="button" 
                                    onclick="switchProfileTab('info')" 
                                    id="tab-btn-info"
                                    class="flex-1 rounded-xl py-2 text-xs transition-all flex items-center justify-center gap-2 cursor-pointer bg-white text-brand-950 font-extrabold shadow-sm">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Informasi Profil</span>
                            </button>
                            <button type="button" 
                                    onclick="switchProfileTab('password')" 
                                    id="tab-btn-password"
                                    class="flex-1 rounded-xl py-2 text-xs transition-all flex items-center justify-center gap-2 cursor-pointer text-white/80 hover:text-white font-semibold">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Ganti Password</span>
                            </button>
                        </div>
                    </div>

                    {{-- Modal Body Tabs --}}
                    <div class="p-5 sm:p-6 max-h-[68vh] overflow-y-auto no-scrollbar">
                        {{-- Tab 1: Profile Information --}}
                        <div id="tab-pane-info" class="space-y-4">
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                {{-- Nama Lengkap --}}
                                <div>
                                    <label for="profile_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                        Nama Lengkap <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="profile_name" 
                                           value="{{ old('name', auth()->user()->name) }}" required
                                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                    @error('name') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Email (Read-only) --}}
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">Email Akun</label>
                                        <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2 py-0.5 text-[10px] font-extrabold text-emerald-700 border border-emerald-200">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Terverifikasi via OTP
                                        </span>
                                    </div>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                           class="w-full rounded-2xl border border-slate-200 bg-slate-100/80 px-4 py-2.5 sm:py-3 text-xs font-semibold text-slate-500 cursor-not-allowed select-none">
                                    <p class="mt-1 text-[11px] text-slate-400">Email terhubung dengan sistem login dan pengiriman kode OTP.</p>
                                </div>

                                {{-- Grid No HP & Kelas --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    {{-- No WhatsApp / HP --}}
                                    <div>
                                        <label for="profile_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                            Nomor WhatsApp / HP
                                        </label>
                                        <input type="tel" name="phone" id="profile_phone" placeholder="08xxxxxxxxxx"
                                               value="{{ old('phone', auth()->user()->phone) }}"
                                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                        @error('phone') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Kelas --}}
                                    <div>
                                        <label for="profile_class_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                            Kelas (SMKN 1 Purwokerto)
                                        </label>
                                        <input type="text" name="class_name" id="profile_class_name" placeholder="Contoh: XII PPLG 1, XI TJKT 2"
                                               value="{{ old('class_name', auth()->user()->class_name) }}"
                                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                        @error('class_name') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                {{-- Divisi Alat Musik / Vokal (General - Anggota & Pengurus) --}}
                                <div>
                                    <label for="profile_instrument_division" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                        Divisi Alat Musik / Vokal <span class="text-slate-400 text-[11px] font-normal">(Anggota & Pengurus)</span>
                                    </label>
                                    @php
                                        $instrumentOptions = [
                                            'Divisi Alat Musik',
                                            'Divisi Vokal',
                                        ];
                                        $currentInst = old('instrument_division', auth()->user()->instrument_division);
                                    @endphp
                                    <select name="instrument_division" id="profile_instrument_division"
                                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                        <option value="">-- Pilih Divisi (Alat Musik / Vokal) --</option>
                                        @foreach($instrumentOptions as $opt)
                                            <option value="{{ $opt }}" {{ $currentInst === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('instrument_division') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Divisi Pengurus (Khusus Pengurus / Admin) --}}
                                @if(auth()->user()->isAdmin())
                                    <div class="rounded-2xl border border-brand-200 bg-brand-50/40 p-4">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="flex h-5 w-5 items-center justify-center rounded-lg bg-brand-600 text-white text-[10px] font-bold">★</span>
                                            <label for="profile_management_division" class="block text-xs font-bold uppercase tracking-wider text-brand-950">
                                                Divisi Kepengurusan <span class="text-brand-600 font-normal text-[11px]">(Khusus Pengurus)</span>
                                            </label>
                                        </div>
                                        @php
                                            $currentMgmt = old('management_division', auth()->user()->management_division);
                                        @endphp
                                        <select name="management_division" id="profile_management_division"
                                                class="w-full rounded-xl border border-brand-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-800 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                            <option value="">-- Pilih Divisi Kepengurusan --</option>
                                            @foreach($divisionsList as $div)
                                                <option value="{{ $div->name }}" {{ $currentMgmt === $div->name ? 'selected' : '' }}>
                                                    {{ $div->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-[11px] text-slate-500">Jabatan Role Anda saat ini: <span class="font-bold text-brand-700">{{ auth()->user()->role_label }}</span></p>
                                    </div>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="mt-6 pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                                    <button type="button" onclick="closeProfileModal()"
                                            class="btn-cancel-profile rounded-2xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="tap-press rounded-2xl bg-gradient-to-r from-brand-600 to-brand-700 px-5 py-2.5 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 hover:from-brand-700 hover:to-brand-800 transition-all cursor-pointer">
                                        Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Tab 2: Change Password --}}
                        <div id="tab-pane-password" class="space-y-4 hidden">
                            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                                @csrf
                                @method('PATCH')

                                {{-- Password Saat Ini --}}
                                <div>
                                    <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                        Password Saat Ini <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="current_password" id="current_password" required
                                               placeholder="Masukkan kata sandi saat ini"
                                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 pr-10 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                        <button type="button" onclick="togglePasswordVisibility('current_password', this)" 
                                                class="toggle-password-btn absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 cursor-pointer"
                                                data-target="current_password">
                                            <svg class="icon-eye h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="icon-eye-off hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        </button>
                                    </div>
                                    @error('current_password') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Password Baru --}}
                                <div>
                                    <label for="new_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                        Password Baru (Minimal 8 Karakter) <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="password" id="new_password" required minlength="8"
                                               placeholder="Minimal 8 karakter unik"
                                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 pr-10 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                        <button type="button" onclick="togglePasswordVisibility('new_password', this)" 
                                                class="toggle-password-btn absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 cursor-pointer"
                                                data-target="new_password">
                                            <svg class="icon-eye h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="icon-eye-off hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        </button>
                                    </div>
                                    @error('password') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Konfirmasi Password Baru --}}
                                <div>
                                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                        Konfirmasi Password Baru <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="password_confirmation" id="password_confirmation" required minlength="8"
                                               placeholder="Ketik ulang password baru Anda"
                                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 sm:py-3 pr-10 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" 
                                                class="toggle-password-btn absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 cursor-pointer"
                                                data-target="password_confirmation">
                                            <svg class="icon-eye h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <svg class="icon-eye-off hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-6 pt-3 flex items-center justify-end gap-3 border-t border-slate-100">
                                    <button type="button" onclick="closeProfileModal()"
                                            class="btn-cancel-profile rounded-2xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-200 transition-colors cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="tap-press rounded-2xl bg-gradient-to-r from-rose-600 to-rose-700 px-5 py-2.5 text-xs font-extrabold text-white shadow-lg shadow-rose-600/30 hover:from-rose-700 hover:to-rose-800 transition-all cursor-pointer">
                                        Perbarui Password Akun
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script>
        // Global Profile Settings Modal Handlers
        window.openProfileModal = function(tab) {
            tab = tab || 'info';
            const modal = document.getElementById('profile-settings-modal');
            if (!modal) return;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            window.switchProfileTab(tab);
        };

        window.closeProfileModal = function() {
            const modal = document.getElementById('profile-settings-modal');
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        };

        window.switchProfileTab = function(tab) {
            const paneInfo = document.getElementById('tab-pane-info');
            const panePass = document.getElementById('tab-pane-password');
            const btnInfo = document.getElementById('tab-btn-info');
            const btnPass = document.getElementById('tab-btn-password');

            if (tab === 'password') {
                if (paneInfo) paneInfo.classList.add('hidden');
                if (panePass) panePass.classList.remove('hidden');
                if (btnInfo) {
                    btnInfo.className = 'flex-1 rounded-xl py-2 text-xs transition-all flex items-center justify-center gap-2 cursor-pointer text-white/80 hover:text-white font-semibold';
                }
                if (btnPass) {
                    btnPass.className = 'flex-1 rounded-xl py-2 text-xs transition-all flex items-center justify-center gap-2 cursor-pointer bg-white text-brand-950 font-extrabold shadow-sm';
                }
            } else {
                if (paneInfo) paneInfo.classList.remove('hidden');
                if (panePass) panePass.classList.add('hidden');
                if (btnPass) {
                    btnPass.className = 'flex-1 rounded-xl py-2 text-xs transition-all flex items-center justify-center gap-2 cursor-pointer text-white/80 hover:text-white font-semibold';
                }
                if (btnInfo) {
                    btnInfo.className = 'flex-1 rounded-xl py-2 text-xs transition-all flex items-center justify-center gap-2 cursor-pointer bg-white text-brand-950 font-extrabold shadow-sm';
                }
            }
        };

        window.togglePasswordVisibility = function(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            const iconEye = btn.querySelector('.icon-eye');
            const iconEyeOff = btn.querySelector('.icon-eye-off');
            if (iconEye && iconEyeOff) {
                if (isPass) {
                    iconEye.classList.add('hidden');
                    iconEyeOff.classList.remove('hidden');
                } else {
                    iconEye.classList.remove('hidden');
                    iconEyeOff.classList.add('hidden');
                }
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Drawer Open/Close with Smooth Animations
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const openBtn = document.getElementById('sidebar-open-btn');
            const closeBtn = document.getElementById('sidebar-close-btn');
            const triggerAdmin = document.getElementById('mobile-menu-trigger-admin');
            const triggerUser = document.getElementById('mobile-menu-trigger-user');

            function openSidebar() {
                if (!sidebar) return;
                sidebar.classList.remove('max-lg:-translate-x-full');
                if (backdrop) {
                    backdrop.classList.remove('hidden');
                    void backdrop.offsetWidth;
                    backdrop.classList.remove('opacity-0', 'pointer-events-none');
                    backdrop.classList.add('opacity-100', 'pointer-events-auto');
                }
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('max-lg:-translate-x-full');
                if (backdrop) {
                    backdrop.classList.remove('opacity-100', 'pointer-events-auto');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                    setTimeout(() => {
                        backdrop.classList.add('hidden');
                    }, 300);
                }
                document.body.style.overflow = '';
            }

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
            if (triggerAdmin) triggerAdmin.addEventListener('click', openSidebar);
            if (triggerUser) triggerUser.addEventListener('click', openSidebar);

            // Close sidebar when clicking links inside on mobile
            if (sidebar) {
                sidebar.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 1024) {
                            closeSidebar();
                        }
                    });
                });
            }

            // Close drawer & modal on Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSidebar();
                    closeProfileModal();
                }
            });

            // Auto-open modal if validation errors exist on redirect back
            @if($errors->has('current_password') || $errors->has('password') || $errors->has('name') || $errors->has('phone') || $errors->has('class_name'))
                openProfileModal('{{ ($errors->has('current_password') || $errors->has('password')) ? 'password' : 'info' }}');
            @endif

            // Auto-hide flash messages after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                    el.style.transition = 'opacity 0.5s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                });
            }, 5000);
        });
    </script>
</body>
</html>
