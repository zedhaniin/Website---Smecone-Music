@extends('layouts.admin')

@section('title', 'Struktur Organisasi')

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
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Struktur Organisasi Kepengurusan</h1>
                <p class="text-xs text-slate-500 mt-0.5">Kelola divisi, foto cover sampul divisi, dan seluruh anggota pengurus per divisi.</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('struktur') }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-white border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 shadow-sm hover:bg-slate-50 transition-all">
                    <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Halaman Publik</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl bg-emerald-50 p-4 text-xs font-semibold text-emerald-800 border border-emerald-200 flex items-center gap-2">
                <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Section 1: Form Tambah Anggota Pengurus Baru (Ditaruh Paling Atas Sesuai Permintaan) --}}
        @can('create_members')
        <div class="mb-10 rounded-3xl border border-slate-200/80 bg-white p-6 sm:p-8 shadow-sm">
            <div class="flex items-center gap-3.5 mb-6">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 font-bold shrink-0">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-900">Tambah Anggota Pengurus Baru</h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Bisa menambahkan anggota secara langsung atau melalui menu kelola divisi di bawah.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data" 
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                @csrf
                <div class="min-w-0 sm:col-span-1 lg:col-span-4">
                    <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required placeholder="Contoh: Sheren Olivia"
                        class="w-full h-11 rounded-2xl border border-slate-200 bg-slate-50 px-4 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                </div>

                <div class="min-w-0 sm:col-span-1 lg:col-span-3">
                    <label for="position" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">Jabatan / Divisi</label>
                    <select name="position" id="position" required
                        class="w-full h-11 rounded-2xl border border-slate-200 bg-slate-50 px-3.5 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
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

                <div class="min-w-0 sm:col-span-1 lg:col-span-3">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 truncate">Foto (Opsional)</label>
                        <span class="text-[10px] font-semibold text-slate-400 shrink-0">Maks. 5MB</span>
                    </div>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full h-11 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs text-slate-600 file:mr-2.5 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3 file:py-1 file:text-xs file:font-bold file:text-brand-300 focus:outline-none transition-all">
                </div>

                <div class="min-w-0 sm:col-span-1 lg:col-span-2">
                    <button type="submit"
                        class="w-full h-11 inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-4 text-xs font-extrabold text-white shadow-md shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-lg whitespace-nowrap">
                        <svg class="h-4 w-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>+ Tambah</span>
                    </button>
                </div>
            </form>
        </div>
        @endcan

        {{-- Section 2: Daftar Divisi & Pengaturan Foto Cover Per Divisi --}}
        <div class="mb-10">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                        <svg class="h-5 w-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>Daftar Divisi & Foto Cover ({{ $divisions->count() }} Divisi)</span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih divisi untuk mengganti foto cover sampul utama dan menambah anggota ("orang-orangan") divisi tersebut.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($divisions as $division)
                    <div class="group flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:border-brand-300">
                        {{-- Cover Image Container --}}
                        <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-900">
                            @if($division->cover_image_path)
                                <img src="{{ asset('storage/' . $division->cover_image_path) }}" alt="{{ $division->name }}" 
                                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent pointer-events-none"></div>
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-brand-950 via-slate-900 to-brand-900 text-slate-400 p-4 text-center">
                                    <svg class="h-8 w-8 text-brand-400/60 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[11px] font-bold text-slate-300">Belum ada cover</span>
                                </div>
                            @endif

                            {{-- Total Members Pill --}}
                            <div class="absolute top-3 right-3 rounded-full bg-slate-900/85 backdrop-blur-md px-3 py-1 text-[11px] font-extrabold text-white border border-white/20 shadow-sm">
                                {{ $division->members_count }} Anggota
                            </div>
                        </div>

                        {{-- Division Info & Action --}}
                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900 group-hover:text-brand-600 transition-colors line-clamp-1">
                                    {{ $division->name }}
                                </h3>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $division->description ?: 'Belum ada deskripsi divisi.' }}
                                </p>
                            </div>

                            <div class="mt-5 pt-4 border-t border-slate-100">
                                @can('edit_members')
                                <a href="{{ route('admin.divisions.edit', $division->slug) }}" 
                                   class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-4 py-2.5 text-xs font-extrabold text-white shadow-md shadow-brand-600/20 transition-all hover:bg-brand-700 hover:shadow-lg hover:-translate-y-0.5">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Kelola Cover & Anggota</span>
                                </a>
                                @else
                                <a href="{{ route('struktur.detail', $division->slug) }}" target="_blank"
                                   class="w-full inline-flex items-center justify-center gap-1.5 rounded-2xl bg-slate-100 px-4 py-2.5 text-xs font-extrabold text-slate-700 hover:bg-slate-200 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Lihat Publik</span>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Section 3: Semua Anggota Pengurus --}}
        <div>
            <div class="mb-5">
                <h3 class="text-base font-extrabold text-slate-900">Seluruh Anggota Pengurus ({{ $members->count() }})</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar lengkap seluruh anggota dari semua divisi.</p>
            </div>

            <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @forelse($members as $member)
                    <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-slate-200/60 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl">
                        {{-- Portrait Image --}}
                        <div class="aspect-[3/4] relative w-full overflow-hidden bg-slate-100">
                            @if($member->image_path)
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-brand-950 text-4xl font-extrabold text-brand-300">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif

                            {{-- Badge overlay --}}
                            <div class="absolute top-3 left-3 right-3">
                                <span class="inline-block rounded-full bg-brand-950/80 px-3 py-1 text-[10px] font-extrabold text-brand-300 backdrop-blur-md shadow-sm border border-white/10 truncate max-w-full">
                                    {{ $member->display_position }}
                                </span>
                            </div>
                        </div>

                        {{-- Info & Action Buttons --}}
                        <div class="flex flex-1 flex-col justify-between p-4">
                            <div>
                                <h3 class="text-xs font-extrabold text-slate-900 line-clamp-1" title="{{ $member->name }}">{{ $member->name }}</h3>
                                <p class="text-[10px] text-slate-400 mt-0.5">{{ $member->division?->name ?? $member->division_group }}</p>
                            </div>

                            @if(auth()->user()->can('edit_members') || auth()->user()->can('delete_members'))
                            <div class="mt-4 flex items-center gap-2">
                                @can('edit_members')
                                <button type="button"
                                    @click="openEdit({{ $member->id }}, {{ Js::from($member->name) }}, {{ Js::from($member->position) }}, '{{ $member->image_path ? asset('storage/' . $member->image_path) : '' }}', '{{ route('admin.members.update', $member) }}')"
                                    class="flex-1 rounded-xl bg-slate-100 px-3 py-2 text-xs font-extrabold text-slate-800 transition-colors hover:bg-slate-200">
                                    Edit
                                </button>
                                @endcan

                                @can('delete_members')
                                <form method="POST" action="{{ route('admin.members.destroy', $member) }}"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')" class="flex-none">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-xl border border-rose-200 bg-rose-50 p-2 text-rose-600 transition-colors hover:bg-rose-100">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endcan
                            </div>
                            @else
                            <div class="mt-4">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-xl border border-slate-100 w-full justify-center">
                                    Mode View-Only
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400">
                        <p class="text-sm font-semibold">Belum ada anggota struktur pengurus yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Edit Modal --}}
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="editModalOpen = false"></div>

                <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6 sm:p-8">
                    
                    <div class="mb-5 flex items-center justify-between border-b border-slate-100 pb-4">
                        <h3 class="text-base font-extrabold text-slate-900">Edit Anggota Pengurus</h3>
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
                            <label class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-700">Jabatan / Divisi</label>
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