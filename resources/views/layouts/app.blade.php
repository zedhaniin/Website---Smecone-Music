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
    {{-- Navbar --}}
    <nav class="fixed top-0 right-0 left-0 z-50 border-b border-gray-200/60 bg-white/85 backdrop-blur-xl transition-all duration-300 shadow-sm/5" id="main-navbar">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('landing') }}" class="group flex items-center gap-3 transition-transform duration-300 hover:scale-[1.02]">
                <div class="relative flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white shadow-sm transition-transform duration-300 group-hover:scale-105">
                    <img src="{{ asset('images/logo.png') }}" alt="Smecone Music Logo" class="h-full w-full rounded-full object-cover">
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight text-gray-900 transition-colors duration-200 group-hover:text-black">Smecone Music</span>
                    <span class="text-[10px] font-bold tracking-wider text-gray-700 uppercase -mt-1 hidden sm:block">SMKN 1 PURWOKERTO</span>
                </div>
            </a>

            <div class="hidden items-center gap-7 md:flex">
                <a href="{{ route('landing') }}" class="relative py-2 text-sm font-bold text-gray-900 transition-colors duration-200 hover:text-black after:absolute after:bottom-0 after:left-0 after:h-[2.5px] after:w-0 after:bg-gray-900 after:transition-all after:duration-300 hover:after:w-full {{ request()->routeIs('landing') ? 'after:w-full' : '' }}">Beranda</a>
                <a href="{{ route('about') }}" class="relative py-2 text-sm font-bold text-gray-900 transition-colors duration-200 hover:text-black after:absolute after:bottom-0 after:left-0 after:h-[2.5px] after:w-0 after:bg-gray-900 after:transition-all after:duration-300 hover:after:w-full {{ request()->routeIs('about') ? 'after:w-full' : '' }}">Tentang</a>
                <a href="{{ route('gallery') }}" class="relative py-2 text-sm font-bold text-gray-900 transition-colors duration-200 hover:text-black after:absolute after:bottom-0 after:left-0 after:h-[2.5px] after:w-0 after:bg-gray-900 after:transition-all after:duration-300 hover:after:w-full {{ request()->routeIs('gallery') ? 'after:w-full' : '' }}">Galeri</a>
                <a href="{{ route('showcase') }}" class="relative py-2 text-sm font-bold text-gray-900 transition-colors duration-200 hover:text-black after:absolute after:bottom-0 after:left-0 after:h-[2.5px] after:w-0 after:bg-gray-900 after:transition-all after:duration-300 hover:after:w-full {{ request()->routeIs('showcase') ? 'after:w-full' : '' }}">Prestasi</a>
                <a href="{{ route('struktur') }}" class="relative py-2 text-sm font-bold text-gray-900 transition-colors duration-200 hover:text-black after:absolute after:bottom-0 after:left-0 after:h-[2.5px] after:w-0 after:bg-gray-900 after:transition-all after:duration-300 hover:after:w-full {{ request()->routeIs('struktur') ? 'after:w-full' : '' }}">Struktur</a>
                
                <div class="h-5 w-px bg-gray-200"></div>

                @auth
                    @if(auth()->user()->hasRole('admin', 'perkap'))
                        <a href="{{ route('admin.dashboard') }}" class="relative inline-flex items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-brand-600 to-brand-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-600/25 transition-all duration-300 hover:-translate-y-0.5 hover:from-brand-700 hover:to-brand-800 hover:shadow-lg hover:shadow-brand-600/35 active:translate-y-0">Dashboard</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="relative inline-flex items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-brand-600 to-brand-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-600/25 transition-all duration-300 hover:-translate-y-0.5 hover:from-brand-700 hover:to-brand-800 hover:shadow-lg hover:shadow-brand-600/35 active:translate-y-0">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="relative inline-flex items-center justify-center overflow-hidden rounded-xl bg-gradient-to-r from-brand-600 to-brand-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-600/25 transition-all duration-300 hover:-translate-y-0.5 hover:from-brand-700 hover:to-brand-800 hover:shadow-lg hover:shadow-brand-600/35 active:translate-y-0">Login</a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button type="button" class="rounded-xl p-2 text-gray-600 transition-colors hover:bg-brand-50 hover:text-brand-700 md:hidden" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div class="hidden border-t border-gray-100 bg-white/95 px-4 py-4 backdrop-blur-md md:hidden" id="mobile-menu">
            <div class="flex flex-col gap-2">
                <a href="{{ route('about') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 transition-colors hover:bg-brand-50 hover:text-brand-700">Tentang</a>
                <a href="{{ route('gallery') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 transition-colors hover:bg-brand-50 hover:text-brand-700">Galeri</a>
                <a href="{{ route('showcase') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 transition-colors hover:bg-brand-50 hover:text-brand-700">Prestasi</a>
                <a href="{{ route('struktur') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 transition-colors hover:bg-brand-50 hover:text-brand-700">Struktur</a>
                <a href="{{ route('landing') }}#recruitment" class="rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 transition-colors hover:bg-brand-50 hover:text-brand-700">Recruitment</a>
                <div class="mt-2 border-t border-gray-100 pt-2">
                    @auth
                        <a href="{{ auth()->user()->hasRole('admin', 'perkap') ? route('admin.dashboard') : route('user.dashboard') }}" class="block rounded-xl bg-brand-600 px-4 py-3 text-center text-sm font-bold text-white shadow-md shadow-brand-600/20">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-xl bg-brand-600 px-4 py-3 text-center text-sm font-bold text-white shadow-md shadow-brand-600/20">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-16">
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

