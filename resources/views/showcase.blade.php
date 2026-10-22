@extends('layouts.app')

@section('title', 'Prestasi & Karya - Smecone Music')

@section('content')
    {{-- Hero Header Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-slate-950 pt-28 pb-16 text-white sm:pt-36 sm:pb-20">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Prestasi & Karya</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-300 font-medium leading-relaxed">Koleksi lengkap penampilan video YouTube dan postingan Instagram FLS3N Smecone Music.</p>
            </div>
        </div>
    </div>

    <section class="py-20 sm:py-28 bg-slate-50/70">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($showcases->count() > 0)
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($showcases as $showcase)
                        <div class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/90 bg-white p-3 shadow-lg shadow-slate-200/60 transition-all duration-300 hover:-translate-y-2 hover:border-brand-400 hover:shadow-2xl hover:shadow-brand-500/15">
                            {{-- Media Top Container --}}
                            <div class="relative w-full aspect-[16/9] bg-slate-950 overflow-hidden rounded-2xl shadow-sm">
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
                            <div class="flex flex-1 flex-col justify-between p-4 pt-5">
                                <div>
                                    <h3 class="text-lg font-extrabold leading-snug tracking-tight text-slate-900 group-hover:text-brand-600 transition-colors duration-200">{{ $showcase->title }}</h3>
                                    @if($showcase->description)
                                        <p class="mt-2 text-sm leading-relaxed text-slate-600 font-medium line-clamp-2">{{ $showcase->description }}</p>
                                    @endif
                                </div>

                                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-extrabold uppercase tracking-wider {{ $showcase->embed_type === 'youtube' ? 'bg-red-50 text-red-600 border border-red-200/60' : 'bg-pink-50 text-pink-600 border border-pink-200/60' }}">
                                        @if($showcase->embed_type === 'youtube')
                                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                            YouTube
                                        @else
                                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                            Instagram
                                        @endif
                                    </span>

                                    <a href="{{ $showcase->embed_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3.5 py-1.5 text-xs font-extrabold text-slate-700 transition-all duration-200 hover:bg-brand-600 hover:text-white hover:shadow-md">
                                        <span>Buka Post</span>
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $showcases->links() }}
                </div>
            @else
                <div class="text-center text-gray-500 py-12 font-medium">
                    <p>Belum ada karya atau prestasi yang ditambahkan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
