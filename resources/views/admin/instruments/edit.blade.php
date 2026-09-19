@extends('layouts.admin')

@section('page-title', 'Edit Alat Musik')
@section('page-description', 'Perbarui informasi alat musik.')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
            <form method="POST" action="{{ route('admin.instruments.update', $instrument) }}" enctype="multipart/form-data" class="flex flex-col gap-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Alat</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $instrument->name) }}" required
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('description', $instrument->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="mb-1.5 block text-sm font-medium text-gray-700">Foto Alat</label>
                    @if($instrument->image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $instrument->image_path) }}" alt="{{ $instrument->name }}" class="h-32 w-32 rounded-xl object-cover">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-brand-50 file:px-4 file:py-1.5 file:text-sm file:font-semibold file:text-brand-700 hover:file:bg-brand-100">
                    <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto.</p>
                    @error('image')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="quantity" class="mb-1.5 block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $instrument->quantity) }}" min="1" required
                               class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                        @error('quantity')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Status</label>
                        <div class="flex h-[46px] items-center">
                            <label class="flex cursor-pointer items-center gap-2">
                                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $instrument->is_available) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                                <span class="text-sm text-gray-700">Tersedia untuk dipinjam</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                        Perbarui
                    </button>
                    <a href="{{ route('admin.instruments.index') }}" class="rounded-xl border border-gray-300 px-6 py-3 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
