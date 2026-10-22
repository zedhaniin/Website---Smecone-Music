@extends('layouts.app')

@section('title', $gallery->title . ' - Dokumentasi Event Smecone Music')

@section('content')
    @php
        $coverPhotoUrl = asset('storage/' . $gallery->image_path);
        $totalPhotos = $gallery->photos->count() > 0 ? $gallery->photos->count() : 1;
    @endphp

    {{-- Hero Section (Theme matching Photo 1) --}}
    <section class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-slate-950 pt-28 pb-20 text-white sm:pt-36 sm:pb-28">
        {{-- Glow Accents matching Photo 1 --}}
        <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-24 -bottom-24 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Single Clean Back Navigation Button --}}
            <div class="mb-8">
                <a href="{{ route('gallery') }}" 
                   class="group inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold text-white backdrop-blur-md transition-all duration-300 hover:bg-white/20 hover:-translate-x-1 shadow-sm">
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Galeri</span>
                </a>
            </div>

            <div class="grid grid-cols-1 items-center gap-10 lg:grid-cols-12 lg:gap-12">
                {{-- Left Column: Event Title & Description --}}
                <div class="lg:col-span-7">
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-[1.12]">
                        {{ $gallery->title }}
                    </h1>

                    <p class="mt-5 text-sm sm:text-base lg:text-lg text-brand-100/90 font-medium leading-relaxed max-w-xl">
                        {{ $gallery->description ?: 'Dokumentasi visual panggung musik, konser festival, dan momen kolaborasi personil Smecone Music.' }}
                    </p>
                </div>

                {{-- Right Column: Exactly 1 Clean Photo Beside Title (Clear without text or icons) --}}
                <div class="relative lg:col-span-5 flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-md cursor-pointer group"
                         data-lightbox-src="{{ $coverPhotoUrl }}" 
                         data-lightbox-title="{{ $gallery->title }} (Foto Utama)">
                        <div class="relative aspect-[4/3] w-full overflow-hidden rounded-[2.5rem] bg-slate-900 border-4 border-white/20 shadow-2xl shadow-black/40 transition-transform duration-500 group-hover:scale-[1.02]">
                            <img src="{{ $coverPhotoUrl }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Section (Pure White with Floating Stats Capsule) --}}
    <section class="relative bg-white pb-24 min-h-screen" id="gallery-photos">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            {{-- Floating Info Capsule & Circular Arrow Button (Centered Exactly on Seam Between Purple & White) --}}
            <div class="relative z-30 -translate-y-1/2 mb-4 sm:mb-6">
                <div class="flex items-center gap-2.5 sm:gap-4">
                    {{-- 3-Column Info Capsule --}}
                    <div class="flex-1 overflow-hidden rounded-2xl sm:rounded-[2.5rem] border border-slate-200/90 bg-white p-3.5 sm:p-7 shadow-xl shadow-brand-950/5">
                        <div class="grid grid-cols-3 divide-x divide-slate-100 text-center">
                            {{-- 1. Tanggal Pelaksanaan --}}
                            <div class="flex flex-col items-center justify-center px-1 sm:px-4">
                                <span class="text-xs sm:text-2xl lg:text-3xl font-black text-brand-600 tracking-tight">
                                    {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : 'Resmi' }}
                                </span>
                                <span class="text-[9px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-slate-800 mt-0.5 sm:mt-1">
                                    Tanggal Pelaksanaan
                                </span>
                                <span class="hidden sm:block text-[11px] font-semibold text-slate-400 mt-0.5">Waktu Event</span>
                            </div>

                            {{-- 2. Jumlah Foto Dokumentasi --}}
                            <div class="flex flex-col items-center justify-center px-1 sm:px-4">
                                <span class="text-xs sm:text-2xl lg:text-3xl font-black text-slate-900 tracking-tight">
                                    {{ sprintf('%02d', $totalPhotos) }} Foto
                                </span>
                                <span class="text-[9px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-slate-800 mt-0.5 sm:mt-1">
                                    Dokumentasi
                                </span>
                                <span class="hidden sm:block text-[11px] font-semibold text-slate-400 mt-0.5">Foto Tersedia</span>
                            </div>

                            {{-- 3. Lokasi Kegiatan --}}
                            <div class="flex flex-col items-center justify-center px-1 sm:px-4">
                                <span class="text-xs sm:text-base lg:text-lg font-black text-slate-900 tracking-tight line-clamp-1">
                                    {{ $gallery->location ?: 'SMK Negeri 1 Purwokerto' }}
                                </span>
                                <span class="text-[9px] sm:text-xs lg:text-sm font-bold uppercase tracking-wider text-slate-800 mt-0.5 sm:mt-1">
                                    Lokasi Kegiatan
                                </span>
                                <span class="hidden sm:block text-[11px] font-semibold text-slate-400 mt-0.5">Tempat Acara</span>
                            </div>
                        </div>
                    </div>

                    {{-- Panah Ungu di Luar Container --}}
                    <a href="#photo-grid" 
                       class="flex h-10 w-10 sm:h-14 sm:w-14 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white shadow-xl shadow-brand-600/35 transition-all duration-300 hover:bg-brand-700 hover:scale-110 active:scale-95" 
                       title="Lihat Foto Dokumentasi">
                        <svg class="h-4 w-4 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </a>
                </div>
            </div>

            {{-- Section Title & Header --}}
            <div id="photo-grid" class="mb-10 sm:mb-14 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200/80 pb-5">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                        <svg class="h-6 w-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Foto-Foto Dokumentasi Event</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Klik pada foto untuk melihat preview resolusi penuh.</p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 border border-brand-200/80 px-4 py-1.5 text-xs font-bold text-brand-700 shadow-xs">
                        <span class="h-2 w-2 rounded-full bg-brand-500 animate-pulse"></span>
                        <span>{{ $totalPhotos }} Foto Dokumentasi</span>
                    </span>
                </div>
            </div>

            {{-- Photos Grid (Clear Cards Layout without text or icons) --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-24">
                {{-- Foto Cover Utama (Clear) --}}
                <div class="group relative overflow-hidden rounded-[2.2rem] bg-slate-900 shadow-lg border border-slate-200/80 cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-950/20"
                     data-lightbox-src="{{ $coverPhotoUrl }}" 
                     data-lightbox-title="{{ $gallery->title }} (Foto Utama)">
                    <div class="aspect-[4/5] w-full overflow-hidden">
                        <img src="{{ $coverPhotoUrl }}" alt="{{ $gallery->title }}" 
                             class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-108" 
                             loading="lazy">
                    </div>
                </div>

                {{-- Additional Photos in the Event (Clear) --}}
                @foreach($gallery->photos as $photo)
                    @if($photo->image_path !== $gallery->image_path)
                        <div class="group relative overflow-hidden rounded-[2.2rem] bg-slate-900 shadow-lg border border-slate-200/80 cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-950/20"
                             data-lightbox-src="{{ asset('storage/' . $photo->image_path) }}" 
                             data-lightbox-title="{{ $photo->caption ?: $gallery->title }}">
                            <div class="aspect-[4/5] w-full overflow-hidden">
                                <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption ?: $gallery->title }}" 
                                     class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-108" 
                                     loading="lazy">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Other Events Section --}}
            @if($otherGalleries->count() > 0)
                <div class="pt-12 border-t border-slate-200/80">
                    <div class="mx-auto max-w-3xl text-center mb-12">
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Dokumentasi & Event Musik Lainnya
                        </h2>
                        <p class="mt-2 text-xs sm:text-sm text-slate-500">
                            Lihat konser, pentas seni, dan penampilan panggung dari divisi Smecone Music lainnya.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($otherGalleries as $other)
                            <a href="{{ route('gallery.detail', $other->slug) }}" 
                               class="group flex flex-col overflow-hidden rounded-[2rem] bg-white border border-slate-200/80 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-brand-600/15 hover:border-brand-300">
                                
                                <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-900">
                                    <img src="{{ asset('storage/' . $other->image_path) }}" 
                                         alt="{{ $other->title }}" 
                                         class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                         loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent pointer-events-none"></div>

                                    @if($other->event_date)
                                        <div class="absolute top-3 left-3 rounded-full bg-slate-900/80 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold text-white border border-white/15">
                                            {{ $other->event_date->format('d M Y') }}
                                        </div>
                                    @endif

                                    <div class="absolute top-3 right-3 rounded-full bg-brand-950/80 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold text-brand-300 border border-brand-500/30">
                                        {{ ($other->photos_count ?? 0) > 0 ? $other->photos_count : 1 }} Foto
                                    </div>
                                </div>

                                <div class="p-6 flex flex-col justify-between flex-1">
                                    <div>
                                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-brand-700 transition-colors line-clamp-2 leading-snug">
                                            {{ $other->title }}
                                        </h3>
                                        <p class="mt-2 text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                            {{ $other->description ?: 'Dokumentasi momen kegiatan dan panggung musik Smecone Music.' }}
                                        </p>
                                    </div>

                                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-brand-600 group-hover:text-brand-700">
                                        <span>Buka Album Lengkap</span>
                                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-50 group-hover:bg-brand-600 group-hover:text-white transition-all">
                                            <svg class="h-3.5 w-3.5 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection
