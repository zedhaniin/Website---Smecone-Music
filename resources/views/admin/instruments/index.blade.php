@extends('layouts.admin')

@section('page-title', 'Inventaris Alat Musik')
@section('page-description', 'Kelola daftar alat musik yang tersedia.')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div></div>
        <a href="{{ route('admin.instruments.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Alat
        </a>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($instruments as $instrument)
            <div class="group overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:shadow-md">
                <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                    @if($instrument->image_path)
                        <img src="{{ asset('storage/' . $instrument->image_path) }}" alt="{{ $instrument->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                            <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="mb-3 flex items-start justify-between">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">{{ $instrument->name }}</h3>
                            @if($instrument->description)
                                <p class="mt-1 line-clamp-2 text-sm text-gray-500">{{ $instrument->description }}</p>
                            @endif
                        </div>
                        <span class="ml-2 shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $instrument->is_available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ $instrument->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">Jumlah: <strong>{{ $instrument->quantity }}</strong> unit</p>
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('admin.instruments.edit', $instrument) }}" class="flex-1 rounded-lg bg-brand-50 px-3 py-2 text-center text-xs font-semibold text-brand-700 transition-colors hover:bg-brand-100">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.instruments.destroy', $instrument) }}" onsubmit="return confirm('Yakin ingin menghapus alat ini?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition-colors hover:bg-red-100">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border border-gray-100 bg-white py-16 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                <p class="mt-3 text-sm text-gray-400">Belum ada alat musik. Tambahkan alat pertama Anda.</p>
            </div>
        @endforelse
    </div>

    @if($instruments->hasPages())
        <div class="mt-6">
            {{ $instruments->links() }}
        </div>
    @endif
@endsection
