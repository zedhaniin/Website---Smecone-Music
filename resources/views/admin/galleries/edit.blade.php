@extends('layouts.admin')

@section('title', 'Kelola Album: ' . $gallery->title)

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors mb-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar Galeri</span>
            </a>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Kelola Album: {{ $gallery->title }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Edit detail event dan kelola foto-foto dokumentasi dalam album ini.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('gallery.detail', $gallery->slug) }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-white border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Lihat Tampilan Publik</span>
            </a>
        </div>
    </div>

    {{-- Edit Event Information Form --}}
    <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 flex items-center gap-3.5 border-b border-slate-100 pb-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Perbarui Informasi Event</h3>
                <p class="text-xs text-slate-500">Ubah judul, tanggal, tempat, deskripsi, atau ganti foto sampul utama.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                {{-- Judul Event --}}
                <div class="sm:col-span-3">
                    <label for="title" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Judul Event / Dokumentasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $gallery->title) }}" 
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('title') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Tanggal Event --}}
                <div>
                    <label for="event_date" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Kegiatan</label>
                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date', optional($gallery->event_date)->format('Y-m-d')) }}"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('event_date') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Lokasi Event --}}
                <div class="sm:col-span-2">
                    <label for="location" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Lokasi / Tempat Acara</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $gallery->location) }}" 
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('location') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Deskripsi Event --}}
            <div>
                <label for="description" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Deskripsi / Cerita Event</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs font-medium text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">{{ old('description', $gallery->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            {{-- Cover Foto Saat Ini & Opsi Penggantian --}}
            <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4 sm:p-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <div class="relative h-24 w-36 shrink-0 overflow-hidden rounded-xl bg-slate-900 border border-slate-200 shadow-sm">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover">
                        <span class="absolute bottom-1 right-1 rounded-md bg-slate-900/80 px-1.5 py-0.5 text-[9px] font-bold text-white">Cover Saat Ini</span>
                    </div>

                    <div class="flex-1 w-full">
                        <label for="image" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Ganti Foto Sampul Utama (Cover)
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
                        <p class="mt-1 text-[11px] text-slate-400">Biarkan kosong jika tidak ingin mengganti cover utama. Maks. 5MB.</p>
                        @error('image') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Tambah Foto Baru ke Album Ini --}}
            <div class="rounded-2xl border border-brand-200/60 bg-brand-50/30 p-4 sm:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <label for="photos" class="block text-xs font-bold uppercase tracking-wider text-brand-900">
                        Tambah Foto-Foto Dokumentasi Baru ke Album
                    </label>
                </div>
                <input type="file" name="photos[]" id="photos" accept="image/*" multiple
                       class="w-full rounded-2xl border border-brand-200 bg-white px-4 py-2 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3.5 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
                <p class="mt-1 text-[11px] text-brand-700/80">Pilih beberapa file foto sekaligus untuk menambahkan dokumentasi baru ke album ini.</p>
                @error('photos.*') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <a href="{{ route('admin.galleries.index') }}" class="rounded-2xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-6 py-2.5 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Existing Photos Management Section --}}
    <div class="rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-100 pb-5">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Foto-Foto Dokumentasi Dalam Album Ini ({{ $gallery->photos->count() }})</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola foto yang sudah terunggah. Anda dapat menghapus foto individual jika diperlukan.</p>
            </div>
        </div>

        @if($gallery->photos->count() > 0)
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                @foreach($gallery->photos as $photo)
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm transition-all duration-200 hover:shadow-md">
                        <div class="aspect-square w-full overflow-hidden bg-slate-900">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" alt="{{ $photo->caption ?: $gallery->title }}" class="h-full w-full object-cover">
                        </div>

                        {{-- Badges & Actions Overlay --}}
                        <div class="p-2.5 bg-white border-t border-slate-100 flex items-center justify-between">
                            <div class="min-w-0 pr-1">
                                @if($photo->image_path === $gallery->image_path)
                                    <span class="inline-block rounded-md bg-brand-50 text-brand-700 px-1.5 py-0.5 text-[9px] font-extrabold border border-brand-200 truncate">
                                        Foto Cover
                                    </span>
                                @else
                                    <span class="text-[10px] font-semibold text-slate-500 truncate block">
                                        {{ $photo->caption ?: 'Dokumentasi #' . $photo->order }}
                                    </span>
                                @endif
                            </div>

                            {{-- Delete Photo Button (except if it is the only photo / cover, or allow deleting non-cover) --}}
                            @if($gallery->photos->count() > 1)
                                <form method="POST" action="{{ route('admin.galleries.photos.destroy', $photo) }}" onsubmit="return confirm('Hapus foto dokumentasi ini dari album?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-colors" title="Hapus foto ini">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center">
                <p class="text-xs font-semibold text-slate-400">Belum ada foto dalam album ini.</p>
            </div>
        @endif
    </div>
@endsection
