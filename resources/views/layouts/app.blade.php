<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smecone Music - Ekstrakurikuler Musik SMKN 1 Purwokerto. When the world fall, music speaks.">
    <title>@yield('title', 'Smecone Music')</title>
    
    {{-- Google Fonts: Plus Jakarta Sans & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700;1,800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50/80 font-sans text-gray-800 antialiased selection:bg-brand-500 selection:text-white">
    {{-- Floating Pill Navbar (overlaps content, truly floating) --}}
    <header class="fixed top-4 inset-x-4 z-50 max-w-5xl mx-auto pointer-events-none">
        <nav class="pointer-events-auto rounded-full bg-white/90 backdrop-blur-xl border border-slate-200/80 shadow-xl shadow-slate-900/5 px-5 py-2.5 flex items-center justify-between transition-all duration-300" id="main-navbar">
            {{-- Left: Brand Logo & Title --}}
            <a href="{{ route('landing') }}" class="group flex items-center gap-3 transition-transform duration-300 hover:scale-[1.02]">
                <div class="relative flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white shadow-sm ring-1 ring-slate-200">
                    <img src="{{ asset('images/logo.png') }}" alt="Smecone Music Logo" class="h-full w-full rounded-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="text-base font-extrabold tracking-tight text-slate-900 transition-colors duration-200 group-hover:text-brand-600">Smecone Music</span>
                </div>
            </a>

            {{-- Center Navigation Links (pill hover/active) --}}
            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('landing') }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition-all duration-200 {{ request()->routeIs('landing') ? 'bg-brand-950 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Beranda</a>
                <a href="{{ route('about') }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition-all duration-200 {{ request()->routeIs('about') ? 'bg-brand-950 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Tentang</a>
                <a href="{{ route('gallery') }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition-all duration-200 {{ request()->routeIs('gallery') ? 'bg-brand-950 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Galeri</a>
                <a href="{{ route('showcase') }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition-all duration-200 {{ request()->routeIs('showcase') ? 'bg-brand-950 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Prestasi</a>
                <a href="{{ route('struktur') }}" class="rounded-full px-4 py-1.5 text-xs font-bold transition-all duration-200 {{ request()->routeIs('struktur*') ? 'bg-brand-950 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Kepengurusan</a>
            </div>

            {{-- Right CTA Button --}}
            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <a href="{{ auth()->user()->hasRole('admin', 'perkap') ? route('admin.dashboard') : route('user.dashboard') }}" 
                       class="inline-flex items-center justify-center rounded-full bg-brand-950 px-5 py-2 text-xs font-extrabold text-white shadow-md shadow-brand-950/20 transition-all duration-300 hover:bg-brand-900 hover:shadow-lg hover:-translate-y-0.5">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center rounded-full bg-brand-950 px-5 py-2 text-xs font-extrabold text-white shadow-md shadow-brand-950/20 transition-all duration-300 hover:bg-brand-900 hover:shadow-lg hover:-translate-y-0.5">
                        Login
                    </a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button type="button" class="rounded-full p-2 text-slate-700 transition-colors hover:bg-slate-100 md:hidden" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </nav>

        {{-- Mobile dropdown menu --}}
        <div class="pointer-events-auto mt-2 hidden rounded-3xl border border-slate-200/80 bg-white/95 p-4 backdrop-blur-xl shadow-xl md:hidden" id="mobile-menu">
            <div class="flex flex-col gap-1">
                <a href="{{ route('landing') }}" class="rounded-full px-4 py-2 text-xs font-bold {{ request()->routeIs('landing') ? 'bg-brand-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Beranda</a>
                <a href="{{ route('about') }}" class="rounded-full px-4 py-2 text-xs font-bold {{ request()->routeIs('about') ? 'bg-brand-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Tentang</a>
                <a href="{{ route('gallery') }}" class="rounded-full px-4 py-2 text-xs font-bold {{ request()->routeIs('gallery') ? 'bg-brand-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Galeri</a>
                <a href="{{ route('showcase') }}" class="rounded-full px-4 py-2 text-xs font-bold {{ request()->routeIs('showcase') ? 'bg-brand-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Prestasi</a>
                <a href="{{ route('struktur') }}" class="rounded-full px-4 py-2 text-xs font-bold {{ request()->routeIs('struktur*') ? 'bg-brand-950 text-white' : 'text-slate-700 hover:bg-slate-100' }}">Kepengurusan</a>
                <div class="mt-1 border-t border-slate-100 pt-3">
                    @auth
                        <a href="{{ auth()->user()->hasRole('admin', 'perkap') ? route('admin.dashboard') : route('user.dashboard') }}" class="block rounded-full bg-brand-950 px-4 py-2.5 text-center text-xs font-bold text-white shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-full bg-brand-950 px-4 py-2.5 text-center text-xs font-bold text-white shadow-md">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- No padding-top on main: content goes BEHIND the floating navbar --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-brand-900/40 bg-gradient-to-b from-brand-950 to-gray-950 text-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-3">
                <div>
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white shadow-sm">
                            <img src="{{ asset('images/logo.png') }}" alt="Smecone Music" class="h-full w-full rounded-full object-cover">
                        </div>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight text-white">Smecone Music</span>
                            <p class="text-[11px] font-semibold text-gray-300">SMK Negeri 1 Purwokerto</p>
                        </div>
                    </div>
                    <p class="text-sm italic leading-relaxed text-gray-300">"When the world fall, music speaks."</p>
                </div>
                <div>
                    <h4 class="mb-4 text-xs font-bold uppercase tracking-widest text-gray-400">Navigasi</h4>
                    <ul class="flex flex-col gap-2.5">
                        <li><a href="{{ route('landing') }}" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Tentang Kami</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Galeri Kegiatan</a></li>
                        <li><a href="{{ route('showcase') }}" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Prestasi</a></li>
                        <li><a href="{{ route('struktur') }}" class="text-sm font-medium text-gray-300 transition-colors hover:text-white">Struktur Organisasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 text-xs font-bold uppercase tracking-widest text-brand-300">Media Sosial</h4>
                    <a href="https://www.instagram.com/smeconemusic/" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-3 rounded-2xl border border-brand-800/80 bg-brand-900/40 px-4 py-3 text-sm font-semibold text-brand-100 backdrop-blur-sm transition-all duration-300 hover:border-brand-500 hover:bg-brand-800/60 hover:text-white">
                        <svg class="h-5 w-5 text-pink-400 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span>@smeconemusic</span>
                    </a>
                </div>
            </div>
            <div class="mt-12 border-t border-brand-900/60 pt-8 text-center text-xs font-medium text-brand-300/70">
                &copy; {{ date('Y') }} Smecone Music SMKN 1 Purwokerto. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

