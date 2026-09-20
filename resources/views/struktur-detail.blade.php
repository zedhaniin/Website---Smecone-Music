@extends('layouts.app')

@section('title', $division['name'] . ' - Smecone Music')

@section('content')
    {{-- Header Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-gray-900 pt-28 pb-14 text-white sm:pt-36 sm:pb-20">
        <div class="absolute -top-24 -right-24 h-80 w-80 rounded-full bg-brand-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('struktur') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-300 hover:text-white transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Semua Divisi</span>
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-brand-400/30 bg-brand-900/80 px-3.5 py-1 text-xs font-extrabold uppercase tracking-widest text-brand-300 backdrop-blur-md mb-3">
                        <span class="h-2 w-2 rounded-full bg-brand-400 animate-pulse"></span>
                        <span>{{ $division['category'] }}</span>
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-5xl uppercase">{{ $division['name'] }}</h1>
                    <p class="mt-3 text-sm sm:text-base text-slate-300 font-medium max-w-2xl leading-relaxed">
                        {{ $division['description'] }}
                    </p>
                </div>

                <div class="rounded-2xl bg-brand-900/80 px-5 py-3 border border-brand-800 text-center shrink-0">
                    <span class="text-2xl font-extrabold text-white block">{{ $members->count() }}</span>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-brand-300">Total Anggota</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Individual Members Grid --}}
    <section class="py-16 sm:py-24 bg-gray-50/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($members->count() > 0)
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($members as $member)
                        <div class="group relative overflow-hidden rounded-3xl bg-brand-950 text-white shadow-xl shadow-brand-950/15 border border-brand-900 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-brand-500/50">
                            {{-- Member Portrait Photo --}}
                            <div class="aspect-[3/4] w-full overflow-hidden bg-brand-900 relative">
                                @if($member->image_path)
                                    <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 p-4 text-center">
                                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-700/50 text-3xl font-extrabold text-brand-300 border border-brand-600/40 mb-2">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                        <span class="text-[10px] font-bold text-brand-300/80 uppercase">No Photo</span>
                                    </div>
                                @endif

                                {{-- Position Badge Floating Top Right --}}
                                <div class="absolute top-3 right-3">
                                    <span class="rounded-full bg-brand-950/90 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-brand-300 border border-brand-700/60 shadow-md">
                                        {{ $member->display_position }}
                                    </span>
                                </div>
                            </div>

                            {{-- Member Info Footer --}}
                            <div class="p-4 bg-gradient-to-t from-brand-950 via-brand-950 to-brand-900/90 border-t border-brand-900">
                                <h3 class="text-sm font-extrabold tracking-tight text-white line-clamp-1 group-hover:text-brand-300 transition-colors">
                                    {{ $member->name }}
                                </h3>
                                <p class="text-[11px] font-semibold text-slate-400 mt-0.5 line-clamp-1">
                                    {{ $member->position }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-3xl border border-slate-200 bg-white p-12 text-center text-slate-500">
                    <p class="text-sm font-semibold">Belum ada anggota terdaftar di divisi {{ $division['name'] }}.</p>
                    <a href="{{ route('struktur') }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-xs font-bold text-white shadow-md hover:bg-brand-700 transition-all">
                        ← Kembali ke Semua Divisi
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
