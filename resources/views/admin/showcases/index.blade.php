@extends('layouts.admin')

@section('title', 'Showcase Karya & Prestasi')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Showcase Prestasi & Karya</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola video YouTube dan tautan media sosial showcase Smecone Music.</p>
        </div>
    </div>

    {{-- Add Form Card --}}
    <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-xs font-extrabold uppercase tracking-wider text-slate-900">Tambah Showcase Baru</h3>
        <form method="POST" action="{{ route('admin.showcases.store') }}" class="flex flex-col gap-4">
            @csrf
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="title" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Judul Showcase</label>
                    <input type="text" name="title" id="title" required placeholder="Judul karya / penampilan"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                </div>
                <div>
                    <label for="embed_type" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Platform Video</label>
                    <select name="embed_type" id="embed_type" required
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                        <option value="youtube">YouTube Video</option>
                        <option value="instagram">Instagram Post / Reel</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="embed_url" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">URL Tautan</label>
                <input type="url" name="embed_url" id="embed_url" required placeholder="https://youtube.com/watch?v=... atau https://instagram.com/p/..."
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
            </div>
            <div>
                <label for="description" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Deskripsi Singkat (Opsional)</label>
                <textarea name="description" id="description" rows="2" placeholder="Catatan atau keterangan mengenai penampilan"
                          class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all"></textarea>
            </div>
            <div>
                <button type="submit" class="rounded-2xl bg-brand-600 px-6 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
                    Simpan Showcase
                </button>
            </div>
        </form>
    </div>

    {{-- Showcase List --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($showcases as $showcase)
            <div class="overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl flex flex-col justify-between">
                <div class="p-6">
                    <div class="mb-3 flex items-start justify-between">
                        <div>
                            <h3 class="text-sm font-extrabold text-slate-900">{{ $showcase->title }}</h3>
                            @if($showcase->description)
                                <p class="mt-1 text-xs text-slate-500 font-medium leading-relaxed">{{ $showcase->description }}</p>
                            @endif
                        </div>
                        <span class="ml-2 shrink-0 rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider {{ $showcase->embed_type === 'youtube' ? 'bg-rose-100 text-rose-900 border border-rose-200' : 'bg-pink-100 text-pink-900 border border-pink-200' }}">
                            {{ ucfirst($showcase->embed_type) }}
                        </span>
                    </div>
                    <p class="mb-4 truncate text-xs text-slate-400 font-medium bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">{{ $showcase->embed_url }}</p>
                </div>

                <div class="px-6 pb-6 pt-0">
                    <form method="POST" action="{{ route('admin.showcases.destroy', $showcase) }}" onsubmit="return confirm('Hapus showcase ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full rounded-xl bg-rose-100 px-3 py-2 text-xs font-extrabold text-rose-900 transition-colors hover:bg-rose-200">
                            Hapus Showcase
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-slate-200/60 bg-white py-16 text-center shadow-sm">
                <p class="text-xs font-semibold text-slate-400">Belum ada item showcase.</p>
            </div>
        @endforelse
    </div>

    @if($showcases->hasPages())
        <div class="mt-6">{{ $showcases->links() }}</div>
    @endif
@endsection
