@extends('layouts.app')

@section('title', 'Galeri Kegiatan - Smecone Music')

@section('content')
    <div class="bg-gradient-to-b from-gray-900 to-brand-950 py-20 text-white sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-block rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-200 backdrop-blur-md">Dokumentasi</span>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Galeri Kegiatan</h1>
                <p class="mt-4 text-lg text-brand-200/90 font-medium">Dokumentasi momen berharga, latihan rutin, dan performa Smecone Music.</p>
            </div>
        </div>
    </div>

    <section class="py-20 sm:py-28 bg-gray-50/50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($galleries->count() > 0)
                <div class="columns-1 gap-6 sm:columns-2 lg:columns-3">
                    @foreach($galleries as $gallery)
                        <div class="group relative mb-6 break-inside-avoid overflow-hidden rounded-3xl bg-white shadow-md transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-brand-500/20">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-950/90 via-brand-950/30 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            <div class="absolute bottom-0 left-0 right-0 translate-y-4 p-6 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                <p class="text-lg font-extrabold text-white tracking-tight">{{ $gallery->title }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>
            @else
                <div class="text-center text-gray-500 py-12 font-medium">
                    <p>Belum ada foto galeri yang diunggah.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
