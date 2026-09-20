@extends('layouts.admin')

@section('title', 'Galeri Foto')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Galeri Foto Dokumentasi</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola koleksi foto dokumentasi kegiatan Smecone Music.</p>
        </div>
    </div>

    {{-- Upload Form Card --}}
    <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-xs font-extrabold uppercase tracking-wider text-slate-900">Tambah Foto Baru</h3>
        <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-4">
            @csrf
            <div class="flex-1">
                <label for="title" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Judul Foto</label>
                <input type="text" name="title" id="title" required placeholder="Judul foto dokumentasi"
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
            </div>
            <div class="flex-1">
                <label for="image" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">File Foto</label>
                <input type="file" name="image" id="image" accept="image/*" required
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
            </div>
            <button type="submit" class="rounded-2xl bg-brand-600 px-6 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 shrink-0">
                Upload Foto
            </button>
        </form>
        @error('title') <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
        @error('image') <p class="mt-2 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
    </div>

    {{-- Gallery Grid --}}
    <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
        @forelse($galleries as $gallery)
            <div class="group relative overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                <div class="aspect-square overflow-hidden bg-slate-100">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                </div>
                <div class="absolute inset-0 flex items-end bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <div class="flex w-full items-center justify-between p-4">
                        <p class="truncate text-xs font-bold text-white">{{ $gallery->title }}</p>
                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-xl bg-rose-600/90 p-2 text-white transition-all hover:bg-rose-700 shadow-md">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-slate-200/60 bg-white py-16 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="mt-3 text-xs font-semibold text-slate-400">Belum ada foto di galeri.</p>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="mt-6">{{ $galleries->links() }}</div>
    @endif
@endsection
