@extends('layouts.app')

@section('title', 'Smecone Music - When The World Fall, Music Speaks')

@section('content')
    {{-- Hero Section --}}
    <section class="relative flex min-h-screen items-center overflow-hidden" id="hero">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Smecone Music Members" class="h-full w-full object-cover">
        </div>
        
        {{-- Gradient Overlay (Left to Right) --}}
        <div class="absolute inset-0 z-10 bg-gradient-to-r from-brand-950/95 via-brand-950/80 to-transparent sm:w-3/4 md:w-2/3 lg:w-1/2">
            <div class="h-full w-full backdrop-blur-[2px]"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-20 mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex max-w-2xl flex-col items-start text-left">
                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-brand-400/40 bg-brand-900/60 px-4 py-2 text-xs sm:text-sm font-bold tracking-wide text-brand-200 backdrop-blur-md shadow-lg shadow-brand-950/50">
                    <svg class="h-4 w-4 text-brand-400" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0013 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg>
                    <span>Ekstrakurikuler Musik SMKN 1 Purwokerto</span>
                </div>
                
                <h1 class="text-4xl font-extrabold leading-[1.1] tracking-tight text-white sm:text-5xl lg:text-7xl">
                    <span class="text-brand-200 drop-shadow-sm">When the world fall,</span><br>
                    <span class="mt-2 block bg-gradient-to-r from-white via-brand-100 to-brand-300 bg-clip-text text-transparent">music speaks.</span>
                </h1>
                
                <p class="mt-6 text-base sm:text-lg leading-relaxed text-brand-100/90 font-medium">
                    Smecone Music adalah wadah bagi siswa-siswi SMKN 1 Purwokerto yang memiliki passion di bidang musik.
                    Dari latihan rutin hingga kompetisi nasional — kami berkarya bersama.
                </p>
                
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('about') }}" class="group relative rounded-xl bg-white px-8 py-3.5 text-sm font-extrabold text-brand-950 shadow-xl shadow-white/10 transition-all duration-300 hover:-translate-y-1.5 hover:scale-[1.03] hover:shadow-2xl hover:shadow-brand-400/30 active:translate-y-0 active:scale-100">
                        Kenali Lebih Jauh
                    </a>
                    <a href="#recruitment" class="group flex items-center gap-2.5 rounded-xl border-2 border-white/30 bg-white/10 px-8 py-3.5 text-sm font-extrabold text-white backdrop-blur-md transition-all duration-300 hover:-translate-y-1.5 hover:scale-[1.03] hover:border-white/60 hover:bg-white/20 hover:shadow-lg hover:shadow-white/10 active:translate-y-0 active:scale-100">
                        <span>Gabung Sekarang</span>
                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- About Section Preview --}}
    <section class="py-20 sm:py-24 bg-white" id="about">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-block rounded-full bg-brand-100/80 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-700 ring-1 ring-brand-300/40">Tentang Kami</span>
                <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Tentang Smecone Music</h2>
                <p class="mt-5 text-base sm:text-lg leading-relaxed text-gray-600 font-medium">
                    Smecone Music merupakan ekstrakurikuler musik di SMKN 1 Purwokerto yang berdedikasi untuk mengembangkan bakat dan minat siswa di bidang seni musik.
                </p>
            </div>

            <div class="mt-14 grid grid-cols-1 gap-8 sm:grid-cols-3">
                <div class="group rounded-3xl border border-gray-100 bg-gray-50/50 p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-500/10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-1 ring-brand-200/50 transition-transform duration-300 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    </div>
                    <h3 class="text-xl font-extrabold tracking-tight text-gray-900 group-hover:text-brand-700 transition-colors">Latihan Rutin</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 font-medium">Jadwal latihan terstruktur dengan pembimbing berpengalaman di Studio Musik (STM).</p>
                </div>
                <div class="group rounded-3xl border border-gray-100 bg-gray-50/50 p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-500/10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-1 ring-brand-200/50 transition-transform duration-300 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-extrabold tracking-tight text-gray-900 group-hover:text-brand-700 transition-colors">Kompetisi FLS3N</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 font-medium">Aktif mengikuti FLS3N dan berbagai kompetisi musik tingkat regional hingga nasional.</p>
                </div>
                <div class="group rounded-3xl border border-gray-100 bg-gray-50/50 p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-500/10">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-1 ring-brand-200/50 transition-transform duration-300 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-extrabold tracking-tight text-gray-900 group-hover:text-brand-700 transition-colors">Komunitas Solid</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 font-medium">Bergabung dengan puluhan siswa yang berbagi passion yang sama terhadap musik.</p>
                </div>
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('about') }}" class="group inline-flex items-center gap-2 rounded-xl bg-gray-900 px-6 py-3 text-sm font-extrabold text-white transition-all duration-300 hover:-translate-y-1 hover:scale-[1.03] hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/25 active:translate-y-0 active:scale-100">
                    <span>Selengkapnya Tentang Kami</span>
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Gallery Section Slider Preview --}}
    @if($galleries->count() > 0)
    <section class="bg-gradient-to-b from-gray-100/70 to-white py-20 sm:py-24" id="gallery">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <span class="inline-block rounded-full bg-brand-100/80 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-700 ring-1 ring-brand-300/40">Dokumentasi</span>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Galeri Kegiatan</h2>
                    <p class="mt-2 text-gray-600 font-medium">Momen berharga dan aktivitas seru anggota Smecone Music.</p>
                </div>

                <a href="{{ route('gallery') }}" class="group inline-flex items-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-extrabold text-white transition-all duration-300 hover:-translate-y-1 hover:scale-[1.03] hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/25 active:translate-y-0 active:scale-100">
                    <span>Lihat Semua</span>
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            {{-- Infinite Marquee Track --}}
            <div class="mt-10 overflow-hidden py-4 marquee-fade-edge">
                <div class="flex w-max animate-marquee gap-6 hover:[animation-play-state:paused]">
                    @for($i = 0; $i < 4; $i++)
                        @foreach($galleries as $gallery)
                            <div class="group relative w-[280px] sm:w-[320px] md:w-[360px] shrink-0 overflow-hidden rounded-3xl bg-white shadow-md transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-500/20">
                                <div class="aspect-[4/3] w-full overflow-hidden">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                <div class="absolute bottom-0 left-0 right-0 translate-y-4 p-6 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                    <p class="text-lg font-extrabold text-white tracking-tight">{{ $gallery->title }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Prestasi Section Preview --}}
    @if($showcases->count())
    <section class="py-20 sm:py-24 bg-white" id="showcase">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <span class="inline-block rounded-full bg-brand-100/80 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-700 ring-1 ring-brand-300/40">Prestasi & Karya</span>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Portofolio & Prestasi</h2>
                    <p class="mt-2 text-gray-600 font-medium">Koleksi penampilan terbaik FLS3N Smecone Music di YouTube dan Instagram.</p>
                </div>

                <a href="{{ route('showcase') }}" class="group inline-flex items-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-extrabold text-white transition-all duration-300 hover:-translate-y-1 hover:scale-[1.03] hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/25 active:translate-y-0 active:scale-100">
                    <span>Lihat Semua Prestasi</span>
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($showcases as $showcase)
                    <div class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-md shadow-gray-200/50 transition-all duration-300 hover:-translate-y-2 hover:border-brand-300 hover:shadow-2xl hover:shadow-brand-500/15">
                        {{-- Media Top Container --}}
                        <div class="relative w-full aspect-[16/9] bg-gray-950 overflow-hidden">
                            @if($showcase->embed_type === 'youtube')
                                @php
                                    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $showcase->embed_url, $matches);
                                    $videoId = $matches[1] ?? '';
                                @endphp
                                @if($videoId)
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}" class="absolute inset-0 h-full w-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                                @endif
                            @elseif($showcase->embed_type === 'instagram')
                                @php
                                    preg_match('/instagram\.com\/(p|reel)\/([a-zA-Z0-9_-]+)/', $showcase->embed_url, $matches);
                                    $postPath = ($matches[1] ?? 'p') . '/' . ($matches[2] ?? '');
                                @endphp
                                <iframe src="https://www.instagram.com/{{ $postPath }}/embed" class="absolute -top-[52px] left-0 h-[calc(100%+56px)] w-full border-0" scrolling="no" allowtransparency="true" allowfullscreen loading="lazy"></iframe>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div>
                                <h3 class="text-lg font-extrabold leading-snug tracking-tight text-gray-900 group-hover:text-brand-700 transition-colors duration-200">{{ $showcase->title }}</h3>
                                @if($showcase->description)
                                    <p class="mt-2.5 text-sm leading-relaxed text-gray-600 font-medium">{{ $showcase->description }}</p>
                                @endif
                            </div>

                            <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider {{ $showcase->embed_type === 'youtube' ? 'bg-red-50 text-red-600 ring-1 ring-red-200/60' : 'bg-pink-50 text-pink-600 ring-1 ring-pink-200/60' }}">
                                    @if($showcase->embed_type === 'youtube')
                                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        YouTube
                                    @else
                                        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        Instagram
                                    @endif
                                </span>

                                <a href="{{ $showcase->embed_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-xs font-bold text-gray-500 transition-colors duration-200 hover:text-brand-600">
                                    <span>Buka</span>
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Structure Section Slider Preview --}}
    <section class="bg-gradient-to-b from-gray-50/70 via-brand-50/30 to-gray-50/70 py-20 sm:py-24" id="struktur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <span class="inline-block rounded-full bg-brand-100/80 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-700 ring-1 ring-brand-300/40">Organisasi</span>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Struktur Kepengurusan</h2>
                    <p class="mt-2 text-gray-600 font-medium">Pengurus Smecone Music yang menjalankan roda organisasi.</p>
                </div>

                <a href="{{ route('struktur') }}" class="group inline-flex items-center gap-2 rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-extrabold text-white transition-all duration-300 hover:-translate-y-1 hover:scale-[1.03] hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/25 active:translate-y-0 active:scale-100">
                    <span>Lihat Lengkap</span>
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

            @if($members->count() > 0)
                {{-- Infinite Marquee Track --}}
                <div class="mt-10 overflow-hidden py-4 marquee-fade-edge">
                    <div class="flex w-max animate-marquee-slow gap-6 hover:[animation-play-state:paused]">
                        @for($i = 0; $i < 2; $i++)
                            @foreach($members as $member)
                                <div class="group relative w-[200px] sm:w-[230px] shrink-0 overflow-hidden rounded-2xl shadow-lg transition-all duration-400 hover:-translate-y-3 hover:shadow-2xl hover:shadow-brand-500/25">
                                    {{-- Portrait Photo --}}
                                    <div class="aspect-[3/4] w-full overflow-hidden bg-brand-100">
                                        @if($member->image_path)
                                            <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-200 via-brand-100 to-brand-50 text-6xl font-extrabold text-brand-400">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Bottom Overlay --}}
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-brand-950/90 via-brand-950/60 to-transparent px-4 pb-4 pt-12">
                                        <h3 class="text-sm font-extrabold tracking-tight text-white drop-shadow-sm line-clamp-1">{{ $member->name }}</h3>
                                        <span class="mt-1 inline-block rounded-full bg-white/20 px-3 py-0.5 text-[11px] font-bold text-white/90 backdrop-blur-sm">{{ $member->position }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endfor
                    </div>
                </div>
            @else
                <div class="mt-12 text-center text-gray-500 font-medium">
                    <p>Struktur kepengurusan belum ditambahkan.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Recruitment Section --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-brand-950 via-brand-900 to-gray-950 py-24 text-white sm:py-32" id="recruitment">
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute top-0 left-1/2 h-[500px] w-[500px] -translate-x-1/2 rounded-full bg-brand-400 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 h-[300px] w-[300px] rounded-full bg-brand-600 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-block rounded-full border border-brand-400/40 bg-brand-900/60 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-200 shadow-md">Open Recruitment</span>
                <h2 class="mt-6 text-3xl font-extrabold tracking-tight text-white sm:text-5xl">Bergabung dengan Kami!</h2>
                <p class="mx-auto mt-5 max-w-xl text-base sm:text-lg leading-relaxed text-brand-200/90 font-medium">
                    Tertarik untuk menjadi bagian dari Smecone Music? Daftarkan dirimu sekarang dan mulai perjalanan musikmu bersama kami.
                </p>
                <div class="mt-10">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSd6EX9_EjRQIhdPoRQ57NJLBPKjvXj3He-Oz_ADtZwaxJ2b8Q/viewform" target="_blank" rel="noopener noreferrer" class="group relative inline-flex items-center gap-3 rounded-2xl bg-white px-10 py-5 text-base font-extrabold text-brand-950 shadow-2xl shadow-white/15 transition-all duration-300 hover:-translate-y-2 hover:scale-[1.04] hover:shadow-[0_20px_50px_-10px_rgba(255,255,255,0.3)] active:translate-y-0 active:scale-100">
                        <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Isi Formulir Pendaftaran</span>
                        <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
                <p class="mt-6 text-sm font-medium text-brand-300/70">
                    Formulir akan terbuka di Google Forms
                </p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
