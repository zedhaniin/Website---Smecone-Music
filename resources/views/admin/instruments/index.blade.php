@extends('layouts.admin')

@section('title', 'Inventaris Alat Musik')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Inventaris Alat Musik</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola koleksi alat musik Smecone Music dan status ketersediaannya.</p>
        </div>
        <a href="{{ route('admin.instruments.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 w-fit">
            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Alat Musik</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($instruments as $instrument)
            <div class="group overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 flex flex-col justify-between">
                <div>
                    <div class="aspect-[4/3] overflow-hidden bg-slate-100 relative">
                        @if($instrument->image_path)
                            <img src="{{ asset('storage/' . $instrument->image_path) }}" alt="{{ $instrument->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-300">
                                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md shadow-sm {{ $instrument->is_available ? 'bg-emerald-100/90 text-emerald-900 border border-emerald-200' : 'bg-rose-100/90 text-rose-900 border border-rose-200' }}">
                                {{ $instrument->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-base font-extrabold text-slate-900">{{ $instrument->name }}</h3>
                        @if($instrument->description)
                            <p class="mt-1 line-clamp-2 text-xs text-slate-500 font-medium leading-relaxed">{{ $instrument->description }}</p>
                        @endif
                        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3 text-xs font-semibold text-slate-600">
                            <span>Jumlah Stok</span>
                            <span class="font-extrabold text-slate-900 bg-slate-100 px-2.5 py-0.5 rounded-lg">{{ $instrument->quantity }} Unit</span>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-0 flex items-center gap-2">
                    <a href="{{ route('admin.instruments.edit', $instrument) }}" class="flex-1 rounded-xl bg-slate-100 px-3 py-2 text-center text-xs font-extrabold text-slate-800 transition-colors hover:bg-slate-200">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.instruments.destroy', $instrument) }}" onsubmit="return confirm('Yakin ingin menghapus alat ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-xl bg-rose-100 px-3 py-2 text-xs font-extrabold text-rose-900 transition-colors hover:bg-rose-200">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-slate-200/60 bg-white py-16 text-center shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <p class="mt-3 text-xs font-semibold text-slate-400">Belum ada data alat musik. Silakan tambahkan alat baru.</p>
            </div>
        @endforelse
    </div>

    @if($instruments->hasPages())
        <div class="mt-6">
            {{ $instruments->links() }}
        </div>
    @endif
@endsection
