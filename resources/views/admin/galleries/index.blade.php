@extends('layouts.admin')

@section('title', 'Galeri & Dokumentasi Event')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Galeri & Album Event</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola album kegiatan, konser, event, dan foto dokumentasi Smecone Music.</p>
        </div>
        <div>
            <a href="{{ route('gallery') }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-white border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Halaman Publik Galeri</span>
            </a>
        </div>
    </div>

    {{-- Form Tambah Event Baru --}}
    @can('create_galleries')
    <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-7 shadow-sm">
        <div class="mb-5 flex items-center gap-3 border-b border-slate-100 pb-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 font-bold shrink-0">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider">Tambah Event & Album Galeri Baru</h3>
                <p class="text-xs text-slate-400">Buat album kegiatan baru dan unggah foto dokumentasinya.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Judul Event --}}
                <div class="sm:col-span-3">
                    <label for="title" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Judul Event / Dokumentasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                           placeholder="Contoh: Pentas Seni SMA 1 Purwokerto 2026"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('title') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Event --}}
                <div>
                    <label for="event_date" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Kegiatan</label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('event_date') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Lokasi Event --}}
                <div class="sm:col-span-2">
                    <label for="location" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Lokasi / Tempat Acara</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           placeholder="Contoh: Lapangan Utama SMECO / GOR Satria"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('location') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Deskripsi Event --}}
            <div>
                <label for="description" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Deskripsi / Cerita Event</label>
                <textarea name="description" id="description" rows="3" 
                          placeholder="Jelaskan mengenai kegiatan, penampilan band, kemeriahan, atau momen penting dalam event ini..."
                          class="w-full rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            {{-- Upload Foto Utama & Foto Tambahan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Foto Utama / Cover Album <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[10px] font-semibold text-slate-400">Maks. 5MB</span>
                    </div>
                    <input type="file" name="image" id="image" accept="image/*" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
                    @error('image') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="photos" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Foto-Foto Tambahan Dokumentasi (Bisa Sekaligus Banyak)
                        </label>
                        <span class="text-[10px] font-semibold text-brand-600">Opsional</span>
                    </div>
                    <input type="file" name="photos[]" id="photos" accept="image/*" multiple
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-800 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white">
                    <p class="mt-1 text-[11px] text-slate-400">Pilih beberapa foto sekaligus untuk dimasukkan ke album event ini.</p>
                    @error('photos.*') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end pt-3">
                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-6 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Simpan & Terbitkan Album Galeri</span>
                </button>
            </div>
        </form>
    </div>
    @endcan

    {{-- Gallery Event Cards Grid --}}
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-sm font-extrabold text-slate-800 uppercase tracking-wider">Daftar Album & Dokumentasi ({{ $galleries->total() }})</h2>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($galleries as $gallery)
            <div class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div>
                    {{-- Cover & Badges --}}
                    <div class="relative aspect-[16/10] overflow-hidden bg-slate-900">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        
                        {{-- Top Floating Badges --}}
                        <div class="absolute top-3 inset-x-3 flex items-center justify-between pointer-events-none">
                            @if($gallery->event_date)
                                <span class="rounded-full bg-slate-950/80 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold text-white border border-white/20 shadow-sm">
                                    {{ $gallery->event_date->format('d M Y') }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            <span class="rounded-full bg-brand-950/85 backdrop-blur-md px-3 py-1 text-[10px] font-extrabold text-brand-300 border border-brand-500/30 shadow-sm">
                                {{ ($gallery->photos_count ?? 0) > 0 ? $gallery->photos_count : 1 }} Foto
                            </span>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-5">
                        @if($gallery->location)
                            <div class="flex items-center gap-1.5 text-[11px] font-bold text-brand-600 mb-1.5">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="truncate">{{ $gallery->location }}</span>
                            </div>
                        @endif

                        <h3 class="text-base font-extrabold text-slate-900 line-clamp-1" title="{{ $gallery->title }}">
                            {{ $gallery->title }}
                        </h3>

                        <p class="mt-2 text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $gallery->description ?: 'Tidak ada deskripsi event.' }}
                        </p>
                    </div>
                </div>

                {{-- Card Actions --}}
                <div class="border-t border-slate-100 bg-slate-50/60 p-4 flex items-center justify-between gap-2">
                    <a href="{{ route('gallery.detail', $gallery->slug) }}" target="_blank" 
                       class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-600 hover:text-brand-600 transition-colors">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat Publik</span>
                    </a>

                    <div class="flex items-center gap-2">
                        @can('edit_galleries')
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" 
                           class="inline-flex items-center gap-1 rounded-xl bg-brand-50 border border-brand-200 px-3 py-1.5 text-xs font-bold text-brand-700 hover:bg-brand-100 transition-colors">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Kelola Album</span>
                        </a>
                        @endcan

                        @can('delete_galleries')
                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" onsubmit="return confirm('Hapus album event ini beserta seluruh foto di dalamnya?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 p-1.5 text-rose-600 hover:bg-rose-100 transition-colors" title="Hapus Event">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endcan

                        @if(!auth()->user()->can('edit_galleries') && !auth()->user()->can('delete_galleries'))
                            <span class="text-xs text-slate-400 font-semibold italic">View-Only</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-slate-200/60 bg-white py-16 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="mt-3 text-xs font-semibold text-slate-400">Belum ada album atau foto di galeri.</p>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="mt-8">{{ $galleries->links() }}</div>
    @endif
@endsection
