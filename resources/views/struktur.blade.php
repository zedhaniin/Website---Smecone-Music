@extends('layouts.app')

@section('title', 'Struktur Kepengurusan - Smecone Music')

@section('content')
    {{-- Hero Header Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-slate-950 pt-28 pb-16 text-white sm:pt-36 sm:pb-20">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Struktur Kepengurusan</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-300 font-medium leading-relaxed">
                    Pengurus Smecone Music SMKN 1 Purwokerto yang menjalankan roda organisasi.
                </p>
            </div>
        </div>
    </div>

    {{-- Main Category Cards Section (Light Theme Image 4 Style Layout) --}}
    <section class="py-16 sm:py-24 bg-gray-50/80 text-slate-800 relative">
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pilih Divisi Untuk Melihat Detail Anggota</h2>
            </div>

            @if(count($divisions) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10">
                    @foreach($divisions as $division)
                        <div class="flex flex-col">
                            {{-- Reference Image 4: Top Floating Pill Button --}}
                            <div class="flex justify-center -mb-4 relative z-20">
                                <a href="{{ route('struktur.detail', $division['slug']) }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-2.5 text-xs font-black uppercase tracking-wider text-white shadow-lg shadow-slate-900/30 hover:bg-brand-950 hover:scale-105 transition-all duration-300 border border-slate-800">
                                    <span>{{ $division['name'] }}</span>
                                </a>
                            </div>

                            {{-- White Card Container --}}
                            <div class="group relative overflow-hidden rounded-3xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-xl shadow-slate-200/60 transition-all duration-500 hover:-translate-y-2 hover:border-brand-400 hover:shadow-2xl hover:shadow-brand-500/20 flex flex-col justify-between h-full pt-8">
                                {{-- Card Image Section --}}
                                <a href="{{ route('struktur.detail', $division['slug']) }}" class="block relative aspect-[4/3] w-full overflow-hidden rounded-2xl bg-slate-100 shadow-inner">
                                    @php
                                        $coverImg = $division->cover_image_path ? asset('storage/' . $division->cover_image_path) : ($division->members->first(fn($m) => !empty($m->image_path)) ? asset('storage/' . $division->members->first(fn($m) => !empty($m->image_path))->image_path) : null);
                                    @endphp
                                    @if($coverImg)
                                        <img src="{{ $coverImg }}" alt="{{ $division->name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-100 via-brand-50 to-slate-100 text-4xl font-black text-brand-400">
                                            {{ strtoupper(substr($division->name, 0, 2)) }}
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-70"></div>

                                    {{-- Member Count Badge --}}
                                    <span class="absolute bottom-3 left-3 rounded-full bg-slate-900/90 px-3.5 py-1 text-[11px] font-extrabold text-white backdrop-blur-md border border-white/20 shadow-md">
                                        {{ count($division['members']) }} Anggota
                                    </span>
                                </a>

                                {{-- Card Details --}}
                                <div class="mt-5 flex flex-col justify-between flex-1 px-1">
                                    <div>
                                        <h3 class="text-lg font-extrabold text-slate-900 group-hover:text-brand-600 transition-colors">
                                            {{ $division['name'] }}
                                        </h3>
                                        <p class="text-xs text-slate-500 font-medium line-clamp-2 mt-1.5 leading-relaxed">
                                            {{ $division['description'] }}
                                        </p>

                                        {{-- Member Preview Chips --}}
                                        <div class="mt-4 flex flex-wrap gap-1.5 mb-5">
                                            @foreach($division['members']->take(3) as $member)
                                                <span class="rounded-xl bg-slate-100/90 px-3 py-1.5 text-[11px] font-bold text-slate-700 border border-slate-200/80 shadow-xs hover:bg-brand-50 hover:text-brand-700 hover:border-brand-200 transition-colors">
                                                    {{ $member->name }}
                                                </span>
                                            @endforeach
                                            @if(count($division['members']) > 3)
                                                <span class="rounded-xl bg-brand-50 px-3 py-1.5 text-[11px] font-bold text-brand-700 border border-brand-200/80 shadow-xs">
                                                    +{{ count($division['members']) - 3 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- CTA Button --}}
                                    <a href="{{ route('struktur.detail', $division['slug']) }}" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-950 px-5 py-3.5 text-xs font-extrabold text-white shadow-lg shadow-brand-950/20 transition-all duration-300 hover:bg-brand-900 hover:shadow-xl hover:-translate-y-0.5">
                                        <span>Lihat Detail Anggota</span>
                                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 text-center text-slate-400 font-medium">
                    <p>Struktur kepengurusan belum ditambahkan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

