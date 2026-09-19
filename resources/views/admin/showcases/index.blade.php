@extends('layouts.admin')

@section('page-title', 'Showcase')
@section('page-description', 'Kelola video YouTube dan post Instagram showcase.')

@section('content')
    {{-- Add Form --}}
    <div class="mb-8 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-bold text-gray-900">Tambah Showcase Baru</h3>
        <form method="POST" action="{{ route('admin.showcases.store') }}" class="flex flex-col gap-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700">Judul</label>
                    <input type="text" name="title" id="title" required placeholder="Judul showcase"
                           class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                </div>
                <div>
                    <label for="embed_type" class="mb-1.5 block text-sm font-medium text-gray-700">Tipe</label>
                    <select name="embed_type" id="embed_type" required
                            class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                        <option value="youtube">YouTube</option>
                        <option value="instagram">Instagram</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="embed_url" class="mb-1.5 block text-sm font-medium text-gray-700">URL</label>
                <input type="url" name="embed_url" id="embed_url" required placeholder="https://youtube.com/watch?v=... atau https://instagram.com/p/..."
                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
            </div>
            <div>
                <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                <textarea name="description" id="description" rows="2" placeholder="Deskripsi singkat"
                          class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none"></textarea>
            </div>
            <div>
                <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                    Tambah Showcase
                </button>
            </div>
        </form>
    </div>

    {{-- Showcase List --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($showcases as $showcase)
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="p-5">
                    <div class="mb-2 flex items-start justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">{{ $showcase->title }}</h3>
                            @if($showcase->description)
                                <p class="mt-1 text-xs text-gray-500">{{ $showcase->description }}</p>
                            @endif
                        </div>
                        <span class="ml-2 shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $showcase->embed_type === 'youtube' ? 'bg-red-50 text-red-700' : 'bg-pink-50 text-pink-700' }}">
                            {{ ucfirst($showcase->embed_type) }}
                        </span>
                    </div>
                    <p class="mb-3 truncate text-xs text-gray-400">{{ $showcase->embed_url }}</p>
                    <form method="POST" action="{{ route('admin.showcases.destroy', $showcase) }}" onsubmit="return confirm('Hapus showcase ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition-colors hover:bg-red-100">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-gray-100 bg-white py-16 text-center">
                <p class="text-sm text-gray-400">Belum ada showcase.</p>
            </div>
        @endforelse
    </div>

    @if($showcases->hasPages())
        <div class="mt-6">{{ $showcases->links() }}</div>
    @endif
@endsection
