<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smecone Music - Ekstrakurikuler Musik SMKN 1 Purwokerto. When the world fall, music speaks.">
    <title>@yield('title', 'Smecone Music')</title>
    
    {{-- Favicon Smecone Music --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    {{-- Google Fonts: Plus Jakarta Sans & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700;1,800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50/80 font-sans text-gray-800 antialiased selection:bg-brand-500 selection:text-white">
    {{-- Floating Pill Navbar (overlaps content, truly floating) --}}
    <header id="site-header" class="fixed top-4 inset-x-4 z-50 max-w-5xl mx-auto pointer-events-none transition-opacity duration-300">
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

            {{-- Center Navigation Links with Smooth Animated Sliding Pill Indicator --}}
            <div class="relative hidden items-center gap-1 md:flex p-1 bg-slate-100/70 rounded-full border border-slate-200/60" id="nav-container">
                {{-- Animated Sliding Pill Background --}}
                <div id="nav-sliding-pill" 
                     class="absolute rounded-full bg-brand-950 shadow-md shadow-brand-950/20 transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] pointer-events-none z-0"
                     style="top: 4px; bottom: 4px; left: 0; width: 0; opacity: 0;"></div>

                <a href="{{ route('landing') }}" 
                   class="nav-item relative z-10 rounded-full px-4 py-1.5 text-xs font-bold transition-colors duration-200 {{ request()->routeIs('landing') ? 'text-white is-active' : 'text-slate-600' }}">
                   Beranda
                </a>
                <a href="{{ route('about') }}" 
                   class="nav-item relative z-10 rounded-full px-4 py-1.5 text-xs font-bold transition-colors duration-200 {{ request()->routeIs('about*') ? 'text-white is-active' : 'text-slate-600' }}">
                   Tentang
                </a>
                <a href="{{ route('gallery') }}" 
                   class="nav-item relative z-10 rounded-full px-4 py-1.5 text-xs font-bold transition-colors duration-200 {{ request()->routeIs('gallery*') ? 'text-white is-active' : 'text-slate-600' }}">
                   Galeri
                </a>
                <a href="{{ route('showcase') }}" 
                   class="nav-item relative z-10 rounded-full px-4 py-1.5 text-xs font-bold transition-colors duration-200 {{ request()->routeIs('showcase*') ? 'text-white is-active' : 'text-slate-600' }}">
                   Prestasi
                </a>
                <a href="{{ route('struktur') }}" 
                   class="nav-item relative z-10 rounded-full px-4 py-1.5 text-xs font-bold transition-colors duration-200 {{ request()->routeIs('struktur*') ? 'text-white is-active' : 'text-slate-600' }}">
                   Kepengurusan
                </a>
            </div>

            {{-- Right CTA Button --}}
            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" 
                       class="inline-flex items-center justify-center rounded-full bg-brand-950 px-5 py-2 text-xs font-extrabold text-white shadow-md shadow-brand-950/20 transition-all duration-300 hover:bg-brand-900 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center rounded-full bg-brand-950 px-5 py-2 text-xs font-extrabold text-white shadow-md shadow-brand-950/20 transition-all duration-300 hover:bg-brand-900 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                        Login
                    </a>
                @endauth
            </div>

            {{-- Mobile menu button with animated icon --}}
            <button type="button" 
                    id="mobile-menu-btn"
                    aria-label="Buka Menu"
                    aria-expanded="false"
                    class="tap-press relative flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-700 transition-colors hover:bg-slate-200 md:hidden">
                <span class="sr-only">Menu</span>
                <div class="relative h-4 w-4">
                    <span id="hamburger-line-1" class="absolute left-0 top-0.5 h-0.5 w-4 rounded-full bg-slate-800 transition-all duration-300"></span>
                    <span id="hamburger-line-2" class="absolute left-0 top-2 h-0.5 w-4 rounded-full bg-slate-800 transition-all duration-300"></span>
                    <span id="hamburger-line-3" class="absolute left-0 top-3.5 h-0.5 w-4 rounded-full bg-slate-800 transition-all duration-300"></span>
                </div>
            </button>
        </nav>

        {{-- Mobile dropdown menu with backdrop & smooth animation --}}
        <div id="mobile-menu" 
             class="pointer-events-auto mt-2 hidden origin-top rounded-3xl border border-slate-200/90 bg-white/95 p-4 backdrop-blur-2xl shadow-2xl shadow-slate-900/10 md:hidden transition-all duration-300 opacity-0 -translate-y-2 scale-98">
            <div class="flex flex-col gap-1.5">
                <a href="{{ route('landing') }}" class="tap-press flex items-center justify-between rounded-2xl px-4 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('landing') ? 'bg-brand-950 text-white shadow-md shadow-brand-950/20' : 'text-slate-700 hover:bg-slate-100' }}">
                    <span>Beranda</span>
                    @if(request()->routeIs('landing'))
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    @endif
                </a>
                <a href="{{ route('about') }}" class="tap-press flex items-center justify-between rounded-2xl px-4 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('about*') ? 'bg-brand-950 text-white shadow-md shadow-brand-950/20' : 'text-slate-700 hover:bg-slate-100' }}">
                    <span>Tentang</span>
                    @if(request()->routeIs('about*'))
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    @endif
                </a>
                <a href="{{ route('gallery') }}" class="tap-press flex items-center justify-between rounded-2xl px-4 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('gallery*') ? 'bg-brand-950 text-white shadow-md shadow-brand-950/20' : 'text-slate-700 hover:bg-slate-100' }}">
                    <span>Galeri</span>
                    @if(request()->routeIs('gallery*'))
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    @endif
                </a>
                <a href="{{ route('showcase') }}" class="tap-press flex items-center justify-between rounded-2xl px-4 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('showcase*') ? 'bg-brand-950 text-white shadow-md shadow-brand-950/20' : 'text-slate-700 hover:bg-slate-100' }}">
                    <span>Prestasi</span>
                    @if(request()->routeIs('showcase*'))
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    @endif
                </a>
                <a href="{{ route('struktur') }}" class="tap-press flex items-center justify-between rounded-2xl px-4 py-2.5 text-xs font-bold transition-all {{ request()->routeIs('struktur*') ? 'bg-brand-950 text-white shadow-md shadow-brand-950/20' : 'text-slate-700 hover:bg-slate-100' }}">
                    <span>Kepengurusan</span>
                    @if(request()->routeIs('struktur*'))
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    @endif
                </a>
                <div class="mt-1.5 border-t border-slate-100 pt-3">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="tap-press block rounded-2xl bg-brand-950 px-4 py-2.5 text-center text-xs font-extrabold text-white shadow-md shadow-brand-950/20">
                            Dashboard ({{ auth()->user()->role }})
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="tap-press block rounded-2xl bg-brand-950 px-4 py-2.5 text-center text-xs font-extrabold text-white shadow-md shadow-brand-950/20">
                            Login Anggota
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- Mobile Menu Backdrop Blur --}}
    <div id="mobile-menu-backdrop" class="fixed inset-0 z-40 bg-slate-950/40 backdrop-blur-xs transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"></div>

    {{-- Floating Scroll-To-Top Button --}}
    <button type="button" 
            id="scroll-to-top-btn" 
            aria-label="Kembali ke atas"
            title="Kembali ke atas"
            class="tap-press fixed bottom-6 right-6 z-40 flex h-11 w-11 items-center justify-center rounded-full bg-white/95 text-slate-800 shadow-xl shadow-slate-950/15 border border-slate-200/80 backdrop-blur-md transition-all duration-300 opacity-0 translate-y-4 pointer-events-none hover:bg-brand-950 hover:text-white hover:border-brand-900">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
        </svg>
    </button>


    {{-- No padding-top on main: content goes BEHIND the floating navbar --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-brand-900/40 bg-gradient-to-b from-brand-950 to-gray-950 text-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-10 md:grid-cols-3">
                {{-- Column 1: Brand Info --}}
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

                {{-- Column 2: Navigation Links (Retained Interactive Hover) --}}
                <div>
                    <h4 class="mb-4 text-xs font-bold uppercase tracking-widest text-gray-400">Navigasi</h4>
                    <ul class="flex flex-col gap-2.5">
                        @php
                            $navLinks = [
                                ['route' => 'landing', 'label' => 'Beranda'],
                                ['route' => 'about', 'label' => 'Tentang Kami'],
                                ['route' => 'gallery', 'label' => 'Galeri Kegiatan'],
                                ['route' => 'showcase', 'label' => 'Prestasi'],
                                ['route' => 'struktur', 'label' => 'Struktur Organisasi'],
                            ];
                        @endphp
                        @foreach($navLinks as $link)
                            <li>
                                <a href="{{ route($link['route']) }}" class="group inline-flex items-center gap-2 text-sm font-medium text-gray-300 transition-all duration-300 hover:text-white hover:translate-x-1.5">
                                    <svg class="h-3.5 w-3.5 text-brand-400 opacity-0 -translate-x-2 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    <span class="transition-colors group-hover:text-white">{{ $link['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Column 3: Social Media --}}
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

    {{-- Lightbox Image Preview Modal (Clean & Image-focused) --}}
    <div id="gallery-lightbox" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center p-4 sm:p-8 transition-all duration-300 opacity-0 pointer-events-none" role="dialog" aria-modal="true">
        {{-- Backdrop Overlay --}}
        <div id="lightbox-backdrop" class="absolute inset-0 bg-slate-950/95 backdrop-blur-xl transition-opacity duration-300"></div>

        {{-- Close / Back Button with 'x' --}}
        <button type="button" id="lightbox-close" class="absolute top-5 right-5 sm:top-7 sm:right-7 z-30 flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-full bg-white/10 text-white/90 border border-white/20 backdrop-blur-md transition-all duration-300 hover:bg-white/25 hover:text-white hover:scale-110 active:scale-95 shadow-xl cursor-pointer" aria-label="Tutup Galeri" title="Tutup (Esc)">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        {{-- Main Image Display Area with Navigation Arrows --}}
        <div class="relative z-10 flex my-auto w-full max-w-6xl items-center justify-between gap-3 sm:gap-6">
            {{-- Prev Button --}}
            <button type="button" id="lightbox-prev" class="group shrink-0 flex h-11 w-11 sm:h-13 sm:w-13 items-center justify-center rounded-full bg-white/10 text-white border border-white/20 backdrop-blur-md transition-all duration-300 hover:bg-white/20 hover:scale-110 active:scale-95 shadow-xl">
                <svg class="h-6 w-6 transition-transform duration-300 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>

            {{-- Image Container --}}
            <div class="relative flex max-h-[70vh] sm:max-h-[75vh] max-w-[85vw] items-center justify-center overflow-hidden rounded-2xl sm:rounded-3xl shadow-2xl">
                <img id="lightbox-img" src="" alt="Gallery Preview" class="max-h-[70vh] sm:max-h-[75vh] max-w-[85vw] object-contain rounded-2xl sm:rounded-3xl transition-all duration-300 transform scale-95 opacity-0">
            </div>

            {{-- Next Button --}}
            <button type="button" id="lightbox-next" class="group shrink-0 flex h-11 w-11 sm:h-13 sm:w-13 items-center justify-center rounded-full bg-white/10 text-white border border-white/20 backdrop-blur-md transition-all duration-300 hover:bg-white/20 hover:scale-110 active:scale-95 shadow-xl">
                <svg class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Floating Pill Navbar Logic
            const container = document.getElementById('nav-container');
            const pill = document.getElementById('nav-sliding-pill');
            if (container && pill) {
                const items = container.querySelectorAll('.nav-item');
                let activeItem = container.querySelector('.is-active');

                function setPillPosition(targetEl, animate = true) {
                    if (!targetEl) {
                        pill.style.opacity = '0';
                        items.forEach(item => {
                            item.classList.remove('text-white');
                            item.classList.add('text-slate-600');
                        });
                        return;
                    }
                    const containerRect = container.getBoundingClientRect();
                    const targetRect = targetEl.getBoundingClientRect();

                    const left = targetRect.left - containerRect.left;
                    const width = targetRect.width;

                    if (!animate) {
                        pill.style.transition = 'none';
                    } else {
                        pill.style.transition = 'all 350ms cubic-bezier(0.16, 1, 0.3, 1)';
                    }

                    pill.style.left = `${left}px`;
                    pill.style.width = `${width}px`;
                    pill.style.opacity = '1';

                    if (!animate) {
                        void pill.offsetHeight;
                        pill.style.transition = 'all 350ms cubic-bezier(0.16, 1, 0.3, 1)';
                    }

                    items.forEach(item => {
                        if (item === targetEl) {
                            item.classList.remove('text-slate-600', 'text-slate-700');
                            item.classList.add('text-white');
                        } else {
                            item.classList.remove('text-white');
                            item.classList.add('text-slate-600');
                        }
                    });
                }

                setPillPosition(activeItem, false);

                items.forEach(item => {
                    item.addEventListener('mouseenter', () => setPillPosition(item, true));
                });

                container.addEventListener('mouseleave', () => {
                    setPillPosition(activeItem, true);
                });

                window.addEventListener('resize', () => setPillPosition(activeItem, false));
            }

            // Global Lightbox Preview Modal Logic
            const siteHeader = document.getElementById('site-header');
            const lightbox = document.getElementById('gallery-lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxClose = document.getElementById('lightbox-close');
            const lightboxPrev = document.getElementById('lightbox-prev');
            const lightboxNext = document.getElementById('lightbox-next');
            const lightboxBackdrop = document.getElementById('lightbox-backdrop');

            if (!lightbox) return;

            let items = [];
            let currentIndex = 0;

            function updateLightboxItems() {
                items = Array.from(document.querySelectorAll('[data-lightbox-src]'));
            }

            function openLightbox(index) {
                updateLightboxItems();
                if (items.length === 0) return;

                currentIndex = (index + items.length) % items.length;
                const el = items[currentIndex];
                const src = el.getAttribute('data-lightbox-src');

                lightboxImg.classList.remove('scale-100', 'opacity-100');
                lightboxImg.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    lightboxImg.src = src;

                    lightboxImg.onload = () => {
                        lightboxImg.classList.remove('scale-95', 'opacity-0');
                        lightboxImg.classList.add('scale-100', 'opacity-100');
                    };
                }, 50);

                if (siteHeader) {
                    siteHeader.classList.add('opacity-0', 'pointer-events-none');
                }

                lightbox.classList.remove('hidden');
                setTimeout(() => {
                    lightbox.classList.remove('opacity-0', 'pointer-events-none');
                    lightbox.classList.add('opacity-100', 'pointer-events-auto', 'flex');
                }, 10);

                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.classList.remove('opacity-100', 'pointer-events-auto');
                lightbox.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    lightbox.classList.add('hidden');
                    lightbox.classList.remove('flex');
                    lightboxImg.src = '';
                    document.body.style.overflow = '';
                    if (siteHeader) {
                        siteHeader.classList.remove('opacity-0', 'pointer-events-none');
                    }
                }, 300);
            }

            function prevImage() {
                openLightbox(currentIndex - 1);
            }

            function nextImage() {
                openLightbox(currentIndex + 1);
            }

            // Event Delegation for clicking lightbox elements
            document.addEventListener('click', function(e) {
                const trigger = e.target.closest('[data-lightbox-src]');
                if (trigger) {
                    e.preventDefault();
                    updateLightboxItems();
                    const index = items.indexOf(trigger);
                    openLightbox(index !== -1 ? index : 0);
                }
            });

            if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
            if (lightboxBackdrop) lightboxBackdrop.addEventListener('click', closeLightbox);
            if (lightboxPrev) lightboxPrev.addEventListener('click', prevImage);
            if (lightboxNext) lightboxNext.addEventListener('click', nextImage);

            // Keyboard Navigation
            document.addEventListener('keydown', function(e) {
                if (lightbox.classList.contains('hidden') || lightbox.classList.contains('opacity-0')) return;

                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    prevImage();
                } else if (e.key === 'ArrowRight') {
                    nextImage();
                }
            });

            // Mobile Menu Toggle with Animated Hamburger Icon
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
            const hamLine1 = document.getElementById('hamburger-line-1');
            const hamLine2 = document.getElementById('hamburger-line-2');
            const hamLine3 = document.getElementById('hamburger-line-3');

            let isMobileMenuOpen = false;

            function openMobileMenu() {
                if (!mobileMenu) return;
                isMobileMenuOpen = true;
                mobileMenuBtn?.setAttribute('aria-expanded', 'true');
                
                // Animate hamburger to X
                if (hamLine1 && hamLine2 && hamLine3) {
                    hamLine1.style.transform = 'translateY(6px) rotate(45deg)';
                    hamLine2.style.opacity = '0';
                    hamLine3.style.transform = 'translateY(-6px) rotate(-45deg)';
                }

                // Show backdrop
                if (mobileMenuBackdrop) {
                    mobileMenuBackdrop.classList.remove('hidden', 'pointer-events-none');
                    void mobileMenuBackdrop.offsetWidth;
                    mobileMenuBackdrop.classList.remove('opacity-0');
                    mobileMenuBackdrop.classList.add('opacity-100', 'pointer-events-auto');
                }

                // Show menu with smooth scale & slide
                mobileMenu.classList.remove('hidden');
                void mobileMenu.offsetWidth;
                mobileMenu.classList.remove('opacity-0', '-translate-y-2', 'scale-98');
                mobileMenu.classList.add('opacity-100', 'translate-y-0', 'scale-100');
            }

            function closeMobileMenu() {
                if (!mobileMenu) return;
                isMobileMenuOpen = false;
                mobileMenuBtn?.setAttribute('aria-expanded', 'false');

                // Animate X back to hamburger
                if (hamLine1 && hamLine2 && hamLine3) {
                    hamLine1.style.transform = 'none';
                    hamLine2.style.opacity = '1';
                    hamLine3.style.transform = 'none';
                }

                // Fade out backdrop
                if (mobileMenuBackdrop) {
                    mobileMenuBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
                    mobileMenuBackdrop.classList.add('opacity-0', 'pointer-events-none');
                }

                // Fade & slide up menu
                mobileMenu.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
                mobileMenu.classList.add('opacity-0', '-translate-y-2', 'scale-98');

                setTimeout(() => {
                    if (!isMobileMenuOpen) {
                        mobileMenu.classList.add('hidden');
                        if (mobileMenuBackdrop) {
                            mobileMenuBackdrop.classList.add('hidden');
                        }
                    }
                }, 300);
            }

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (isMobileMenuOpen) {
                        closeMobileMenu();
                    } else {
                        openMobileMenu();
                    }
                });
            }

            if (mobileMenuBackdrop) {
                mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
            }

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMobileMenuOpen) {
                    closeMobileMenu();
                }
            });

            // Smooth Scroll-To-Top Button Logic
            const scrollToTopBtn = document.getElementById('scroll-to-top-btn');
            if (scrollToTopBtn) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 300) {
                        scrollToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                        scrollToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                    } else {
                        scrollToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                        scrollToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                    }
                }, { passive: true });

                scrollToTopBtn.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>
</html>

