@extends('layouts.app')

@section('title', $division['name'] . ' - Smecone Music')

@section('content')
    {{-- Header Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-slate-950 pt-28 pb-16 text-white sm:pt-36 sm:pb-20">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('struktur') }}" class="group inline-flex items-center gap-2.5 rounded-full bg-white/10 backdrop-blur-md px-5 py-2.5 text-xs sm:text-sm font-bold text-white border border-white/20 shadow-md shadow-slate-950/20 transition-all duration-300 hover:bg-white/20 hover:border-white/40 hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:-translate-x-1 text-brand-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Semua Divisi</span>
                </a>
            </div>

            <div class="grid grid-cols-1 items-center gap-8 lg:grid-cols-12">
                <div class="{{ $division->cover_image_path ? 'lg:col-span-7' : 'lg:col-span-9' }}">
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-5xl uppercase">{{ $division->name }}</h1>
                    <p class="mt-3 text-sm sm:text-base text-slate-300 font-medium max-w-2xl leading-relaxed">
                        {{ $division->description }}
                    </p>
                </div>

                @if($division->cover_image_path)
                    <div class="relative lg:col-span-5 flex justify-center lg:justify-end">
                        <div class="relative w-full max-w-sm overflow-hidden rounded-[2rem] bg-slate-900 border-4 border-white/20 shadow-2xl shadow-black/40">
                            <img src="{{ asset('storage/' . $division->cover_image_path) }}" alt="{{ $division->name }}" class="h-full w-full object-cover aspect-[4/3]">
                        </div>
                    </div>
                @else
                    <div class="hidden lg:flex lg:col-span-3 justify-end">
                        <div class="rounded-2xl bg-brand-900/80 px-6 py-4 border border-brand-800 text-center shrink-0">
                            <span class="text-3xl font-extrabold text-white block">{{ $members->count() }}</span>
                            <span class="text-xs font-extrabold uppercase tracking-wider text-brand-300 mt-1 block">Total Anggota</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Individual Members Grid --}}
    <section class="py-16 sm:py-24 bg-gray-50/80">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($members->count() > 0)
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($members as $member)
                        <div class="group relative overflow-hidden rounded-2xl shadow-lg transition-all duration-400 hover:-translate-y-3 hover:shadow-2xl hover:shadow-brand-500/25">
                            {{-- Portrait Photo --}}
                            <div class="aspect-[3/4] w-full overflow-hidden bg-brand-100 relative">
                                @if($member->image_path)
                                    <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-200 via-brand-100 to-brand-50 text-5xl font-extrabold text-brand-400">
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
                </div>
            @else
                <div class="rounded-3xl border border-slate-200 bg-white p-12 text-center text-slate-500">
                    <p class="text-sm font-semibold">Belum ada anggota terdaftar di divisi {{ $division['name'] }}.</p>
                    <a href="{{ route('struktur') }}" class="group mt-5 inline-flex items-center gap-2.5 rounded-full bg-brand-950 px-6 py-3 text-xs sm:text-sm font-bold text-white shadow-md transition-all duration-300 hover:bg-brand-900 hover:shadow-lg hover:-translate-y-0.5">
                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:-translate-x-1 text-brand-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Kembali ke Semua Divisi</span>
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
