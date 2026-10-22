@extends('layouts.admin')

@section('title', 'Katalog Inventaris Alat Musik')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Katalog Inventaris Alat Musik</h1>
            <p class="text-xs text-slate-500 mt-0.5">Lihat seluruh alat musik milik Smecone Music, pantau ketersediaan stok, dan ajukan peminjaman secara langsung.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('user.borrowings.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                <span>Tracking Peminjaman Saya</span>
            </a>
            <a href="{{ route('user.borrowing.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-4 py-2.5 text-xs font-extrabold text-white shadow-md shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Ajukan Pinjam Alat</span>
            </a>
        </div>
    </div>

    {{-- Summary Statistics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-8">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Macam Alat</p>
                <p class="text-2xl font-extrabold text-slate-900 tracking-tight mt-0.5">{{ $totalCount }} Item</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Siap Dipinjam</p>
                <p class="text-2xl font-extrabold text-emerald-600 tracking-tight mt-0.5">{{ $availableCount }} Item</p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Sedang Dipinjam</p>
                <p class="text-2xl font-extrabold text-amber-600 tracking-tight mt-0.5">{{ $borrowedCount }} Item</p>
            </div>
        </div>
    </div>

    {{-- Filter & Search Bar --}}
    <div class="mb-8 rounded-3xl border border-slate-200/80 bg-white p-4 sm:p-5 shadow-sm">
        <form method="GET" action="{{ route('user.instruments.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            {{-- Search Box --}}
            <div class="relative w-full sm:w-80">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama alat musik atau merk..." 
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-xs font-semibold text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-brand-500 focus:outline-none transition-all">
            </div>

            {{-- Filter Pills --}}
            <div class="flex items-center gap-2 w-full sm:w-auto overflow-x-auto no-scrollbar">
                <a href="{{ route('user.instruments.index', ['search' => $search, 'status' => 'all']) }}" 
                   class="rounded-xl px-3.5 py-2 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'all' ? 'bg-brand-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua ({{ $totalCount }})
                </a>
                <a href="{{ route('user.instruments.index', ['search' => $search, 'status' => 'available']) }}" 
                   class="rounded-xl px-3.5 py-2 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'available' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Tersedia ({{ $availableCount }})
                </a>
                <a href="{{ route('user.instruments.index', ['search' => $search, 'status' => 'borrowed']) }}" 
                   class="rounded-xl px-3.5 py-2 text-xs font-extrabold transition-all whitespace-nowrap {{ $selectedStatus === 'borrowed' ? 'bg-amber-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Sedang Dipakai ({{ $borrowedCount }})
                </a>
            </div>
        </form>
    </div>

    {{-- Instrument Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($instruments as $instrument)
            @php
                $availableStock = max(0, $instrument->quantity - ($instrument->active_borrowings_count ?? 0));
                $isReady = $instrument->is_available && $availableStock > 0;
            @endphp
            <div class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:border-brand-300">
                {{-- Instrument Image Header --}}
                <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-900">
                    @if($instrument->image_path)
                        <img src="{{ asset('storage/' . $instrument->image_path) }}" alt="{{ $instrument->name }}" 
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-brand-950 via-slate-900 to-brand-900 text-slate-400 p-4 text-center">
                            <svg class="h-10 w-10 text-brand-400/50 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            <span class="text-[11px] font-bold text-slate-300">Foto Tidak Tersedia</span>
                        </div>
                    @endif

                    {{-- Status Badge Overlay --}}
                    <div class="absolute top-3 right-3">
                        @if($isReady)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-950/80 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold text-emerald-300 border border-emerald-500/30 shadow-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Tersedia: {{ $availableStock }}/{{ $instrument->quantity }}</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-950/80 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold text-amber-300 border border-amber-500/30 shadow-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                <span>Habis Dipinjam (0/{{ $instrument->quantity }})</span>
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Card Content --}}
                <div class="p-5 flex flex-col justify-between flex-1">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-brand-600 transition-colors line-clamp-1" title="{{ $instrument->name }}">
                            {{ $instrument->name }}
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                            {{ $instrument->description ?: 'Instrumen musik resmi inventaris Smecone Music.' }}
                        </p>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div class="text-[11px] font-semibold text-slate-500">
                            Stok: <span class="font-extrabold text-slate-900">{{ $instrument->quantity }} unit</span>
                        </div>

                        @if($isReady)
                            <a href="{{ route('user.borrowing.create', ['instrument_id' => $instrument->id]) }}" 
                               class="inline-flex items-center gap-1.5 rounded-2xl bg-brand-600 px-4 py-2 text-xs font-extrabold text-white shadow-md shadow-brand-600/20 transition-all hover:bg-brand-700 hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Pinjam Ini</span>
                            </a>
                        @else
                            <button type="button" disabled 
                                    class="cursor-not-allowed inline-flex items-center gap-1.5 rounded-2xl bg-slate-100 px-3 py-2 text-xs font-bold text-slate-400">
                                <span>Sedang Dipakai</span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center rounded-3xl border border-dashed border-slate-200 bg-white p-8">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 mb-3">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h4 class="text-sm font-extrabold text-slate-800">Tidak Ada Alat Musik Ditemukan</h4>
                <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian lain atau ganti filter status di atas.</p>
                <a href="{{ route('user.instruments.index') }}" class="mt-4 inline-flex items-center gap-2 rounded-2xl bg-slate-100 px-4 py-2 text-xs font-extrabold text-slate-700 hover:bg-slate-200">
                    Reset Filter Pencarian
                </a>
            </div>
        @endforelse
    </div>
@endsection
