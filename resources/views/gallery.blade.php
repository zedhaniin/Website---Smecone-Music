@extends('layouts.app')

@section('title', 'Galeri & Dokumentasi Event - Smecone Music')

@section('content')
    {{-- Hero Section --}}
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-slate-950 pt-28 pb-16 text-white sm:pt-36 sm:pb-20">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Galeri Kegiatan</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-300 font-medium leading-relaxed">
                    Dokumentasi momen berharga, penampilan panggung, konser, sesi latihan, dan kegiatan seru Smecone Music.
                </p>
            </div>
        </div>
    </div>

    {{-- Main Gallery Content --}}
    <section class="py-16 sm:py-24 bg-slate-50/70 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($galleries->count() > 0)
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($galleries as $gallery)
                        <a href="{{ route('gallery.detail', $gallery->slug) }}" 
                           class="group flex flex-col overflow-hidden rounded-3xl bg-white border border-slate-200/70 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-brand-600/15 hover:border-brand-300">
                            
                            {{-- Cover Image Container with Floating Badges --}}
                            <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-900">
                                <img src="{{ asset('storage/' . $gallery->image_path) }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-108" 
                                     loading="lazy">
                                
                                {{-- Subtle Gradient for Badge Legibility --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/30 pointer-events-none"></div>

                                {{-- Top Left: Event Date Badge --}}
                                @if($gallery->event_date)
                                    <div class="absolute top-3.5 left-3.5 flex items-center gap-1.5 rounded-full bg-slate-900/80 backdrop-blur-md px-3 py-1 text-[11px] font-extrabold text-white border border-white/15 shadow-sm">
                                        <svg class="h-3.5 w-3.5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>{{ $gallery->event_date->format('d M Y') }}</span>
                                    </div>
                                @endif

                                {{-- Top Right: Total Photos Badge --}}
                                <div class="absolute top-3.5 right-3.5 flex items-center gap-1.5 rounded-full bg-brand-950/85 backdrop-blur-md px-3 py-1 text-[11px] font-extrabold text-brand-300 border border-brand-500/30 shadow-sm">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ ($gallery->photos_count ?? 0) > 0 ? $gallery->photos_count : 1 }} Foto</span>
                                </div>
                            </div>

                            {{-- Card Content --}}
                            <div class="flex flex-1 flex-col justify-between p-6">
                                <div>
                                    @if($gallery->location)
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold text-brand-600 mb-2">
                                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span class="truncate">{{ $gallery->location }}</span>
                                        </div>
                                    @endif

                                    <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 group-hover:text-brand-700 transition-colors tracking-tight line-clamp-2 leading-snug">
                                        {{ $gallery->title }}
                                    </h3>

                                    <p class="mt-2.5 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed line-clamp-3">
                                        {{ $gallery->description ?: 'Dokumentasi kegiatan dan penampilan musik Smecone Music.' }}
                                    </p>
                                </div>

                                {{-- Card Footer / Action Link --}}
                                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-xs font-extrabold text-brand-600 group-hover:text-brand-700 transition-colors">
                                        Lihat Detail Event & Foto
                                    </span>
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition-all duration-300 group-hover:bg-brand-600 group-hover:text-white group-hover:translate-x-1 shadow-sm">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($galleries->hasPages())
                    <div class="mt-14 flex justify-center">
                        {{ $galleries->links() }}
                    </div>
                @endif
            @else
                <div class="rounded-3xl border border-dashed border-slate-200 bg-white p-14 text-center shadow-sm">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 mb-3">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-800">Belum Ada Dokumentasi Galeri</h3>
                    <p class="mt-1 text-xs text-slate-500">Foto dokumentasi event akan segera diperbarui oleh pengurus.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
