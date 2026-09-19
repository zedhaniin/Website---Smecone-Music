@extends('layouts.admin')

@section('page-title', 'Struktur Organisasi')
@section('page-description', 'Kelola data pengurus yang ditampilkan di Landing Page dan Halaman Struktur.')

@section('content')
<div x-data="{ 
    editModalOpen: false, 
    editMember: { id: '', name: '', position: '', image_url: '', updateUrl: '' },
    openEdit(id, name, position, imageUrl, updateUrl) {
        this.editMember = { id: id, name: name, position: position, image_url: imageUrl, updateUrl: updateUrl };
        this.editModalOpen = true;
        this.$nextTick(() => {
            if (this.$refs.editForm) {
                this.$refs.editForm.action = updateUrl;
            }
        });
    }
}">
    {{-- Add Form Card (1 Single Horizontal Row) --}}
    <div class="mb-8 rounded-3xl border border-gray-100 bg-white p-6 sm:p-8 shadow-sm">
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-gray-900">Tambah Anggota Pengurus Baru</h3>
                <p class="text-xs text-gray-500 font-medium">Isi nama dan pilih jabatan pengurus. Urutan hirarki akan disesuaikan otomatis.</p>
            </div>
        </div>
        
        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 p-4 text-sm text-green-700 ring-1 ring-green-200">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700 ring-1 ring-red-200">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data" class="flex flex-row flex-wrap lg:flex-nowrap items-end gap-4">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label for="name" class="mb-1.5 block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" id="name" required placeholder="Contoh: Sheren Olivia"
                       class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm font-medium focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none">
            </div>
            
            <div class="flex-1 min-w-[220px] w-full">
                <label for="position" class="mb-1.5 block text-xs font-bold text-gray-700 uppercase tracking-wider">Jabatan / Divisi</label>
                <select name="position" id="position" required class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm font-medium focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none bg-white">
                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                    @foreach(App\Models\MemberStructure::$positions as $group => $items)
                        <optgroup label="{{ $group }}">
                            @foreach($items as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label for="image" class="mb-1.5 block text-xs font-bold text-gray-700 uppercase tracking-wider">Foto (Opsional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm font-medium file:mr-3 file:rounded-xl file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700 hover:file:bg-brand-100">
            </div>

            <div class="shrink-0">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-6 py-3.5 text-sm font-extrabold text-white shadow-lg shadow-brand-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-500/30 active:translate-y-0 whitespace-nowrap">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Members Grid --}}
    <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @forelse($members as $member)
            <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:shadow-brand-500/10">
                {{-- Portrait Image --}}
                <div class="aspect-[3/4] relative w-full overflow-hidden bg-brand-50">
                    @if($member->image_path)
                        <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-200 via-brand-100 to-brand-50 text-5xl font-extrabold text-brand-400">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                    @endif

                    {{-- Badge overlay --}}
                    <div class="absolute top-3 left-3 right-3">
                        <span class="inline-block rounded-full bg-white/90 px-3 py-1 text-[11px] font-extrabold text-brand-800 backdrop-blur-md shadow-sm border border-white/50">
                            {{ $member->display_position }}
                        </span>
                    </div>
                </div>

                {{-- Info & Action Buttons --}}
                <div class="flex flex-1 flex-col justify-between p-4">
                    <div>
                        <h3 class="text-sm font-extrabold text-gray-900 line-clamp-1" title="{{ $member->name }}">{{ $member->name }}</h3>
                    </div>
                    
                    <div class="mt-4 flex items-center gap-2">
                        <button type="button" 
                                @click="openEdit({{ $member->id }}, {{ Js::from($member->name) }}, {{ Js::from($member->position) }}, '{{ $member->image_path ? asset('storage/' . $member->image_path) : '' }}', '{{ route('admin.members.update', $member) }}')" 
                                class="flex-1 rounded-xl bg-gray-100 px-3 py-2 text-xs font-extrabold text-gray-700 transition-colors hover:bg-brand-50 hover:text-brand-700">
                            Edit
                        </button>
                        
                        <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm('Hapus anggota {{ addslashes($member->name) }}?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full rounded-xl bg-red-50 px-3 py-2 text-xs font-extrabold text-red-600 transition-colors hover:bg-red-100">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-3xl border border-gray-100 bg-white py-16 text-center">
                <p class="text-sm text-gray-400 font-medium">Belum ada data struktur kepengurusan.</p>
            </div>
        @endforelse
    </div>

    {{-- Edit Pop-Up Modal --}}
    <div x-show="editModalOpen" x-cloak style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-950/60 backdrop-blur-sm transition-opacity"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div @click.away="editModalOpen = false" class="relative w-full max-w-lg overflow-hidden rounded-3xl bg-white p-6 sm:p-8 shadow-2xl transition-all transform"
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900">Edit Data Pengurus</h3>
                    <p class="text-xs text-gray-500 font-medium mt-0.5">Perbarui nama, jabatan, atau foto anggota.</p>
                </div>
                <button type="button" @click="editModalOpen = false" class="rounded-xl p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Body Form --}}
            <form x-ref="editForm" :action="editMember.updateUrl" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="mb-1.5 block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="name" x-model="editMember.name" required
                           class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm font-medium focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-gray-700 uppercase tracking-wider">Jabatan / Divisi</label>
                    <select name="position" x-model="editMember.position" required
                            class="w-full rounded-2xl border border-gray-300 px-4 py-3 text-sm font-medium focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none bg-white">
                        @foreach(App\Models\MemberStructure::$positions as $group => $items)
                            <optgroup label="{{ $group }}">
                                @foreach($items as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-bold text-gray-700 uppercase tracking-wider">Ganti Foto (Opsional)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full rounded-2xl border border-gray-300 px-4 py-2 text-sm font-medium file:mr-3 file:rounded-xl file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                </div>

                {{-- Action buttons --}}
                <div class="mt-8 flex items-center gap-3 pt-2">
                    <button type="button" @click="editModalOpen = false" class="flex-1 rounded-2xl bg-gray-100 px-5 py-3 text-sm font-bold text-gray-700 hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-brand-500/25 hover:bg-brand-700 transition-all hover:shadow-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
