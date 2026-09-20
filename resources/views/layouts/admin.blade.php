<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Smecone Music</title>
    
    {{-- Google Fonts: Plus Jakarta Sans & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- AlpineJS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100/90 font-sans text-slate-800 antialiased min-h-screen">
    <div class="min-h-screen relative">
        
        {{-- Floating Dark Sidebar (Smecone Music Purple Theme) --}}
        <aside class="fixed top-3 bottom-3 left-3 z-50 flex w-64 lg:w-72 flex-col justify-between rounded-3xl bg-brand-950 p-5 text-slate-300 shadow-2xl shadow-brand-950/30 transition-transform duration-300 max-lg:-translate-x-full border border-brand-900/50" id="sidebar">
            <div class="flex flex-col h-full justify-between overflow-y-auto no-scrollbar">
                <div>
                    {{-- Brand Header --}}
                    <div class="flex items-center gap-3.5 px-2 py-1 mb-6">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-brand-900 p-0.5 ring-2 ring-brand-500/40">
                            <img src="{{ asset('images/logo.png') }}" alt="Smecone Music" class="h-full w-full rounded-xl object-cover">
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base font-extrabold tracking-wide text-white">Smecone Music</h2>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="h-2 w-2 rounded-full bg-brand-400"></span>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-brand-300">
                                    {{ auth()->user()->role === 'admin' ? 'Admin Panel' : (auth()->user()->role === 'perkap' ? 'Perkap Panel' : 'Member Panel') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Navigation Links --}}
                    <nav class="space-y-1.5">
                        {{-- Role Scoping --}}
                        @if(auth()->user()->hasRole('admin', 'perkap'))
                            {{-- Admin & Perkap Shared --}}
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

                            @if(auth()->user()->isAdmin())
                                <div class="pt-4 pb-1 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Manajemen App</div>

                                <a href="{{ route('admin.users.index') }}" 
                                   class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                    <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                                    <span>Kelola User</span>
                                </a>

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
                            @endif
                        @else
                            {{-- User / Anggota Only --}}
                            <a href="{{ route('user.dashboard') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard Saya</span>
                            </a>

                            <a href="{{ route('user.borrowing.create') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.borrowing.create') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.borrowing.create') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                <span>Pinjam Alat Musik</span>
                            </a>

                            <a href="{{ route('user.booking.create') }}" 
                               class="group flex items-center gap-3.5 rounded-2xl px-4 py-3 text-sm font-semibold transition-all duration-200 {{ request()->routeIs('user.booking.create') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30 font-bold' : 'text-slate-400 hover:bg-brand-900/60 hover:text-white' }}">
                                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('user.booking.create') ? 'text-white' : 'text-slate-400 group-hover:text-brand-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Booking Studio</span>
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

        {{-- Mobile Sidebar Backdrop --}}
        <div class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden hidden" id="sidebar-backdrop" onclick="document.getElementById('sidebar').classList.add('max-lg:-translate-x-full'); this.classList.add('hidden')"></div>

        {{-- Main Content Area with Left Margin for Sidebar --}}
        <div class="lg:ml-80 p-3 sm:p-5 lg:p-6 min-h-screen flex flex-col justify-between">
            <div>
                {{-- Top Navbar Header --}}
                <header class="mb-6 flex items-center justify-between rounded-3xl bg-white p-4 shadow-sm border border-slate-200/60">
                    <div class="flex items-center gap-3">
                        {{-- Mobile menu button --}}
                        <button type="button" class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-slate-700 transition-colors hover:bg-slate-200 lg:hidden" 
                                onclick="document.getElementById('sidebar').classList.remove('max-lg:-translate-x-full'); document.getElementById('sidebar-backdrop').classList.remove('hidden')">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>

                        {{-- Search Input --}}
                        <div class="relative hidden sm:block">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" placeholder="Cari kegiatan, alat, booking..." 
                                   class="w-64 lg:w-80 rounded-full border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-xs font-medium text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none transition-all">
                        </div>
                    </div>

                    {{-- Right Navigation Items (User Profile Pill only, Notification Bell removed as requested) --}}
                    <div class="flex items-center gap-3">
                        {{-- User Profile Pill Dropdown --}}
                        <div class="flex items-center gap-3 rounded-2xl bg-slate-100 p-1.5 pr-4 border border-slate-200/60">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-950 text-xs font-bold text-brand-300 shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block min-w-0">
                                <p class="truncate text-xs font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="truncate text-[10px] font-semibold text-slate-500 uppercase tracking-wider">{{ auth()->user()->role }}</p>
                            </div>

                            {{-- Logout Button --}}
                            <form method="POST" action="{{ route('logout') }}" class="ml-1">
                                @csrf
                                <button type="submit" title="Logout" class="flex h-8 w-8 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition-colors hover:bg-rose-100">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-5 flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-xs font-bold text-emerald-900 shadow-sm" id="flash-success">
                        <div class="flex items-center gap-3">
                            <div class="flex h-7 w-7 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shrink-0">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-5 flex items-center justify-between rounded-2xl border border-rose-200 bg-rose-50 px-5 py-3.5 text-xs font-bold text-rose-900 shadow-sm" id="flash-error">
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
    </div>

    @stack('scripts')
    <script>
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
