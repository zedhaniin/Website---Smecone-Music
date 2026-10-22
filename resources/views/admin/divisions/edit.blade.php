@extends('layouts.admin')

@section('title', 'Kelola Divisi: ' . $division->name)

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
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <a href="{{ route('admin.members.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors mb-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Struktur Organisasi</span>
                </a>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Kelola Divisi: {{ $division->name }}</h1>
                <p class="text-xs text-slate-500 mt-0.5">Atur informasi, foto cover sampul divisi, dan kelola anggota ("orang-orangan") dalam divisi ini.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('struktur.detail', $division->slug) }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-white border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                    <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Tampilan Publik</span>
                </a>
            </div>
        </div>

        {{-- Form Edit Informasi & Cover Divisi --}}
        @can('edit_members')
        <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
            <div class="mb-6 flex items-center gap-3.5 border-b border-slate-100 pb-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Perbarui Informasi & Foto Cover Divisi</h3>
                    <p class="text-xs text-slate-500">Ubah nama, deskripsi tugas divisi, atau ganti foto cover sampul utama.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-xs font-semibold text-emerald-800 border border-emerald-200 flex items-center gap-2">
                    <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-700 border border-rose-200">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.divisions.update', $division) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nama Divisi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $division->name) }}" 
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('name') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi Divisi --}}
                <div>
                    <label for="description" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Deskripsi / Tugas Divisi</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs font-medium text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">{{ old('description', $division->description) }}</textarea>
                    @error('description') <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>

                {{-- Cover Foto Saat Ini & Opsi Penggantian (Sesuai Screenshot User) --}}
                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4 sm:p-5">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                        <div class="relative h-24 w-36 shrink-0 overflow-hidden rounded-xl bg-slate-900 border border-slate-200 shadow-sm flex items-center justify-center">
                            @if($division->cover_image_path)
                                <img src="{{ asset('storage/' . $division->cover_image_path) }}" alt="{{ $division->name }}" class="h-full w-full object-cover">
                                <span class="absolute bottom-1 right-1 rounded-md bg-slate-900/80 px-1.5 py-0.5 text-[9px] font-bold text-white">Cover Saat Ini</span>
                            @else
                                <div class="flex flex-col items-center justify-center text-slate-400 p-2 text-center">
                                    <svg class="h-6 w-6 text-slate-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-bold">Belum Ada Cover</span>
                                </div>
                            @endif
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

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <a href="{{ route('admin.members.index') }}" class="rounded-2xl bg-slate-100 px-5 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-6 py-2.5 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
        @endcan

        {{-- Form Tambah Orang-orangan / Anggota Baru ke Divisi Ini --}}
        @can('create_members')
        <div class="mb-8 rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3.5 mb-6 border-b border-slate-100 pb-5">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold shrink-0">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">+ Tambah Anggota Pengurus ke {{ $division->name }}</h3>
                    <p class="text-xs text-slate-500">Masukkan nama pengurus, jabatan di divisi ini, serta foto anggota.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.divisions.members.store', $division) }}" enctype="multipart/form-data" 
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                @csrf
                <div class="min-w-0 sm:col-span-1 lg:col-span-4">
                    <label for="member_name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Anggota <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="member_name" required placeholder="Contoh: Muhammad Haidar"
                           class="w-full h-11 rounded-2xl border border-slate-200 bg-slate-50 px-4 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                </div>

                <div class="min-w-0 sm:col-span-1 lg:col-span-3">
                    <label for="member_position" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Jabatan di Divisi <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" id="member_position" required placeholder="Contoh: Koordinator / Anggota"
                           list="suggested-positions"
                           class="w-full h-11 rounded-2xl border border-slate-200 bg-slate-50 px-4 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    <datalist id="suggested-positions">
                        @if($division->slug === 'pengurus-inti')
                            <option value="Ketua">Ketua</option>
                            <option value="Wakil">Wakil</option>
                            <option value="Sekretaris 1">Sekretaris 1</option>
                            <option value="Sekretaris 2">Sekretaris 2</option>
                            <option value="Bendahara 1">Bendahara 1</option>
                            <option value="Bendahara 2">Bendahara 2</option>
                        @else
                            <option value="{{ $division->name }} (Koordinator)">Koordinator</option>
                            <option value="Anggota {{ $division->name }}">Anggota</option>
                        @endif
                    </datalist>
                </div>

                <div class="min-w-0 sm:col-span-1 lg:col-span-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="member_image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 truncate">Foto Anggota (Opsional)</label>
                        <span class="text-[10px] font-semibold text-slate-400 shrink-0">Maks. 5MB</span>
                    </div>
                    <input type="file" name="image" id="member_image" accept="image/*"
                           class="w-full h-11 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs text-slate-600 file:mr-2.5 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3 file:py-1 file:text-xs file:font-bold file:text-brand-300 focus:outline-none transition-all">
                </div>

                <div class="min-w-0 sm:col-span-1 lg:col-span-2">
                    <button type="submit"
                            class="w-full h-11 inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-4 text-xs font-extrabold text-white shadow-md shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-lg whitespace-nowrap">
                        <svg class="h-4 w-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                        <span>+ Tambah</span>
                    </button>
                </div>
            </form>
        </div>
        @endcan

        {{-- Daftar Anggota Dalam Divisi Ini --}}
        <div class="rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-100 pb-5">
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>Daftar Anggota Dalam Divisi Ini ({{ $division->members->count() }})</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola data seluruh personil pengurus yang tergabung di divisi {{ $division->name }}.</p>
                </div>
            </div>

            @if($division->members->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($division->members as $member)
                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 shadow-sm transition-all duration-300 hover:shadow-md hover:border-brand-300 flex flex-col justify-between">
                            <div class="flex items-center gap-3.5">
                                <div class="relative h-14 w-14 shrink-0 overflow-hidden rounded-2xl bg-brand-100 border border-slate-200 shadow-inner flex items-center justify-center">
                                    @if($member->image_path)
                                        <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-base font-black text-brand-600">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-slate-900 truncate" title="{{ $member->name }}">{{ $member->name }}</h4>
                                    <span class="inline-block mt-1 rounded-md bg-brand-50 px-2 py-0.5 text-[10px] font-extrabold text-brand-700 border border-brand-200/60 truncate max-w-full">
                                        {{ $member->position }}
                                    </span>
                                </div>
                            </div>

                            @if(auth()->user()->can('edit_members') || auth()->user()->can('delete_members'))
                            <div class="mt-4 pt-3 border-t border-slate-200/60 flex items-center justify-end gap-2">
                                @can('edit_members')
                                <button type="button" 
                                        @click="openEdit('{{ $member->id }}', '{{ addslashes($member->name) }}', '{{ addslashes($member->position) }}', '{{ $member->image_path ? asset('storage/' . $member->image_path) : '' }}', '{{ route('admin.members.update', $member) }}')"
                                        class="inline-flex items-center gap-1 rounded-xl bg-white border border-slate-200 px-2.5 py-1 text-[11px] font-bold text-slate-600 hover:text-brand-600 hover:border-brand-300 transition-colors shadow-xs">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    <span>Edit</span>
                                </button>
                                @endcan

                                @can('delete_members')
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota {{ $member->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-xl bg-white border border-rose-200 px-2.5 py-1 text-[11px] font-bold text-rose-600 hover:bg-rose-50 transition-colors shadow-xs">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                                @endcan
                            </div>
                            @else
                            <div class="mt-4 pt-3 border-t border-slate-200/60 text-right">
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-xl border border-slate-100">
                                    Mode View-Only
                                </span>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center text-slate-400">
                    <p class="text-xs font-semibold">Belum ada anggota yang terdaftar di divisi {{ $division->name }}.</p>
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan form di atas untuk menambahkan anggota baru.</p>
                </div>
            @endif
        </div>

        {{-- Modal Edit Anggota --}}
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="editModalOpen = false"></div>

                <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6 sm:p-8">
                    
                    <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
                        <h3 class="text-base font-extrabold text-slate-900">Edit Data Anggota</h3>
                        <button type="button" @click="editModalOpen = false" class="rounded-xl p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form method="POST" x-ref="editForm" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Lengkap</label>
                            <input type="text" name="name" x-model="editMember.name" required 
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-700">Jabatan di Divisi</label>
                            <input type="text" name="position" x-model="editMember.position" required 
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:outline-none">
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-700">Ganti Foto (Opsional)</label>
                            <input type="file" name="image" accept="image/*" 
                                   class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
                        </div>

                        <div class="mt-6 flex justify-end gap-2 pt-3 border-t border-slate-100">
                            <button type="button" @click="editModalOpen = false" class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-200">Batal</button>
                            <button type="submit" class="rounded-2xl bg-brand-600 px-5 py-2 text-xs font-extrabold text-white shadow-md hover:bg-brand-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
