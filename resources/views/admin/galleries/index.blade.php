@extends('layouts.admin')

@section('page-title', 'Galeri Foto')
@section('page-description', 'Kelola foto-foto kegiatan yang ditampilkan di Landing Page.')

@section('content')
    {{-- Upload Form --}}
    <div class="mb-8 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-bold text-gray-900">Tambah Foto Baru</h3>
        <form method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data" class="flex flex-wrap items-end gap-4">
            @csrf
            <div class="flex-1">
                <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" name="title" id="title" required placeholder="Judul foto"
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div class="flex-1">
                <label for="image" class="mb-1.5 block text-sm font-medium text-gray-700">File Foto</label>
                <input type="file" name="image" id="image" accept="image/*" required
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-brand-700">
            </div>
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                Upload
            </button>
        </form>
        @error('title') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        @error('image') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Gallery Grid --}}
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
        @forelse($galleries as $gallery)
            <div class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    <div class="flex w-full items-center justify-between p-4">
                        <p class="truncate text-sm font-medium text-white">{{ $gallery->title }}</p>
                        <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="rounded-lg bg-red-500/80 p-1.5 text-white transition-colors hover:bg-red-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-gray-100 bg-white py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="mt-3 text-sm text-gray-400">Belum ada foto di galeri.</p>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="mt-6">{{ $galleries->links() }}</div>
    @endif
@endsection
