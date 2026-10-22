@extends('layouts.admin')

@section('title', 'Form Peminjaman Alat Musik')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors mb-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Dashboard Saya</span>
            </a>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Form Peminjaman Alat Musik</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pilih satu atau beberapa alat musik sekaligus, tentukan tanggal, dan sertakan surat izin yang valid.</p>
        </div>
    </div>

    <div class="w-full max-w-5xl rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 flex items-center gap-3.5 border-b border-slate-100 pb-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Pengajuan Peminjaman Alat Musik</h3>
                <p class="text-xs text-slate-500">Anda dapat meminjam beberapa instrumen sekaligus dalam 1 pengajuan surat izin</p>
            </div>
        </div>

        @php
            $instrumentsData = $instruments->map(function ($instrument) {
                $available = max(0, $instrument->quantity - ($instrument->active_borrowings_count ?? 0));
                return [
                    'id' => (int) $instrument->id,
                    'name' => $instrument->name,
                    'quantity' => (int) $instrument->quantity,
                    'available' => (int) $available,
                    'image_url' => $instrument->image_path ? asset('storage/' . $instrument->image_path) : null,
                ];
            });
            $oldSelectedIds = array_map('intval', (array) old('instrument_ids', request()->filled('instrument_id') ? [request()->input('instrument_id')] : []));
        @endphp

        <form method="POST" action="{{ route('user.borrowing.store') }}" enctype="multipart/form-data" 
              x-data="{
                  open: false,
                  search: '',
                  hasSubmitted: false,
                  selectedIds: {{ Js::from($oldSelectedIds) }},
                  instruments: {{ Js::from($instrumentsData) }},
                  get selectedList() {
                      return this.instruments.filter(i => this.selectedIds.includes(i.id));
                  },
                  get filteredInstruments() {
                      if (!this.search.trim()) return this.instruments;
                      const q = this.search.toLowerCase();
                      return this.instruments.filter(i => i.name.toLowerCase().includes(q));
                  },
                  isSelected(id) {
                      return this.selectedIds.includes(id);
                  },
                  toggle(id) {
                      if (this.isSelected(id)) {
                          this.selectedIds = this.selectedIds.filter(i => i !== id);
                      } else {
                          this.selectedIds.push(id);
                      }
                      this.hasSubmitted = false;
                  },
                  remove(id) {
                      this.selectedIds = this.selectedIds.filter(i => i !== id);
                  },
                  clearAll() {
                      this.selectedIds = [];
                  }
              }"
              @submit="hasSubmitted = true; if(selectedIds.length === 0) { $event.preventDefault(); open = true; }"
              class="flex flex-col gap-6">
            @csrf

            {{-- Multi-Instrument Selector Section --}}
            <div class="relative">
                {{-- Hidden Inputs for Form Submission --}}
                <template x-for="id in selectedIds" :key="id">
                    <input type="hidden" name="instrument_ids[]" :value="id">
                </template>

                {{-- Header with Label, Counter & Reset --}}
                <div class="flex items-center justify-between mb-2.5">
                    <div class="flex items-center gap-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Pilih Alat Musik <span class="text-rose-500">*</span>
                        </label>
                        <span x-show="selectedIds.length > 0" x-cloak 
                              class="inline-flex items-center rounded-full bg-brand-100 px-2.5 py-0.5 text-[11px] font-extrabold text-brand-800">
                            <span x-text="selectedIds.length"></span> Alat Dipilih
                        </span>
                    </div>

                    <button type="button" 
                            x-show="selectedIds.length > 0" 
                            x-cloak
                            @click="clearAll()" 
                            class="text-[11px] font-bold text-rose-600 hover:text-rose-700 hover:underline transition-colors flex items-center gap-1">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Semua Pilihan</span>
                    </button>
                </div>

                {{-- Selected Instruments Cards Display --}}
                <div class="mb-3">
                    {{-- State 1: Ada Alat Musik yang Dipilih --}}
                    <div x-show="selectedIds.length > 0" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <template x-for="item in selectedList" :key="item.id">
                            <div class="relative flex items-center justify-between rounded-2xl border border-brand-200/90 bg-brand-50/40 p-2.5 sm:p-3 shadow-sm hover:border-brand-300 transition-all">
                                <div class="flex items-center gap-3 min-w-0">
                                    {{-- Image --}}
                                    <div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-xl bg-slate-900 border border-brand-200 shadow-sm">
                                        <template x-if="item.image_url">
                                            <img :src="item.image_url" :alt="item.name" class="h-full w-full object-cover">
                                        </template>
                                        <template x-if="!item.image_url">
                                            <div class="flex h-full w-full items-center justify-center bg-brand-950 text-brand-300">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Instrument Info --}}
                                    <div class="min-w-0">
                                        <p class="truncate text-xs sm:text-sm font-extrabold text-slate-900" x-text="item.name"></p>
                                        <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-1.5 py-0.5 text-[10px] font-extrabold text-emerald-700 border border-emerald-200/80 mt-1">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Stok: <span x-text="item.available"></span> unit
                                        </span>
                                    </div>
                                </div>

                                {{-- Remove Button --}}
                                <button type="button" 
                                        @click="remove(item.id)" 
                                        class="ml-2 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-slate-400 hover:bg-rose-50 hover:text-rose-600 border border-slate-200 transition-colors shadow-sm"
                                        title="Hapus dari daftar">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- State 2: Belum Ada Alat Musik yang Dipilih --}}
                    <div x-show="selectedIds.length === 0" 
                         @click="open = true; $nextTick(() => $refs.searchInput.focus())"
                         class="cursor-pointer rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/70 p-6 text-center hover:border-brand-400 hover:bg-brand-50/20 transition-all select-none"
                         :class="hasSubmitted && selectedIds.length === 0 ? 'border-rose-400 bg-rose-50/30' : ''">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-100 text-brand-700 mb-2.5">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <p class="text-xs sm:text-sm font-bold text-slate-700">Belum ada alat musik yang dipilih</p>
                        <p class="text-[11px] text-slate-400 mt-1">Klik di sini untuk membuka katalog alat dan memilih satu atau beberapa instrumen.</p>
                    </div>
                </div>

                {{-- Action Trigger Button to Open Dropdown Catalog --}}
                <button type="button" 
                        @click="open = !open; if(open) { $nextTick(() => $refs.searchInput.focus()) }"
                        class="w-full flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-bold text-slate-700 hover:bg-white hover:border-brand-400 hover:text-brand-700 focus:outline-none transition-all shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        <span x-text="selectedIds.length > 0 ? '+ Tambah / Ubah Pilihan Alat Musik' : 'Buka Katalog & Pilih Alat Musik'"></span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                        <span x-text="open ? 'Tutup Katalog' : 'Lihat Katalog'"></span>
                        <svg class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180 text-brand-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </button>

                {{-- Validation Error Alert --}}
                <p x-show="hasSubmitted && selectedIds.length === 0" x-cloak class="mt-2 text-xs font-bold text-rose-600 flex items-center gap-1.5">
                    <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Silakan pilih minimal 1 alat musik yang ingin dipinjam.</span>
                </p>
                @error('instrument_ids') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror

                {{-- Dropdown Modal / Popover Catalog Picker --}}
                <div x-show="open" 
                     x-cloak
                     @click.outside="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-98"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-98"
                     class="absolute left-0 right-0 top-full mt-2.5 z-50 rounded-3xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-2xl shadow-brand-950/20 backdrop-blur-xl">
                    
                    {{-- Search Input with Clear Button --}}
                    <div class="relative mb-3">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input x-ref="searchInput" 
                               x-model="search" 
                               type="text" 
                               placeholder="Cari alat musik (misal: Yamaha, Gitar, Drum, Bass)..." 
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-9 text-xs font-semibold text-slate-800 placeholder-slate-400 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                        <button type="button" 
                                x-show="search.length > 0" 
                                x-cloak
                                @click="search = ''" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Quick Tip --}}
                    <p class="text-[11px] font-semibold text-slate-400 mb-2 px-1 flex items-center justify-between">
                        <span>Klik instrumen untuk memilih atau membatalkan pilihan.</span>
                        <span class="text-brand-600 font-bold" x-text="selectedIds.length + ' dipilih'"></span>
                    </p>

                    {{-- Scrollable List of Instruments --}}
                    <div class="max-h-72 overflow-y-auto space-y-2 pr-1">
                        <template x-for="item in filteredInstruments" :key="item.id">
                            <div @click="toggle(item.id)"
                                 class="group flex items-center justify-between rounded-2xl p-2.5 border transition-all duration-150 cursor-pointer select-none"
                                 :class="isSelected(item.id) 
                                    ? 'bg-brand-50/90 border-brand-500/70 ring-2 ring-brand-500/20 shadow-sm' 
                                    : 'border-slate-100 hover:border-brand-200 hover:bg-slate-50/80'">
                                
                                <div class="flex items-center gap-3.5 min-w-0">
                                    {{-- Foto Thumbnail --}}
                                    <div class="relative h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-slate-900 border border-slate-200 shadow-sm">
                                        <template x-if="item.image_url">
                                            <img :src="item.image_url" :alt="item.name" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-108">
                                        </template>
                                        <template x-if="!item.image_url">
                                            <div class="flex h-full w-full items-center justify-center bg-brand-950 text-brand-300">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Detail Alat --}}
                                    <div class="min-w-0">
                                        <p class="truncate text-xs sm:text-sm font-bold text-slate-900 group-hover:text-brand-900 transition-colors" x-text="item.name"></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2 py-0.5 text-[10px] font-extrabold text-emerald-700 border border-emerald-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Tersedia: <span x-text="item.available"></span> / <span x-text="item.quantity"></span> unit
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Checkbox / Toggle Indicator --}}
                                <div class="ml-3 shrink-0">
                                    <div class="flex h-7 w-7 items-center justify-center rounded-xl border transition-all"
                                         :class="isSelected(item.id) 
                                            ? 'bg-brand-600 border-brand-600 text-white shadow-sm scale-105' 
                                            : 'border-slate-300 bg-white text-transparent group-hover:border-brand-400'">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Search Not Found State --}}
                        <template x-if="filteredInstruments.length === 0">
                            <div class="py-8 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <p class="text-xs font-bold text-slate-700">Alat musik tidak ditemukan</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Coba gunakan kata kunci pencarian yang lain.</p>
                            </div>
                        </template>
                    </div>

                    {{-- Catalog Bottom Bar --}}
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-600">
                            Total Dipilih: <span class="text-brand-600 font-extrabold" x-text="selectedIds.length"></span> alat musik
                        </span>
                        <button type="button" 
                                @click="open = false" 
                                class="rounded-xl bg-brand-600 px-4 py-2 text-xs font-bold text-white hover:bg-brand-700 transition-colors shadow-sm">
                            Selesai Memilih
                        </button>
                    </div>
                </div>
            </div>

            {{-- Date Range Inputs --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Mulai Peminjaman</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('start_date') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Selesai Peminjaman</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('end_date') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Permission Letter Upload --}}
            <div>
                <label for="permission_letter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Upload Berkas Surat Izin (PDF/Gambar, max 5MB) <span class="text-rose-500">*</span>
                </label>
                <input type="file" name="permission_letter" id="permission_letter" accept=".pdf,.jpg,.jpeg,.png" required
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3.5 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
                <p class="mt-1 text-[11px] text-slate-400">Satu berkas surat izin ini akan digunakan untuk seluruh alat musik yang Anda ajukan.</p>
                @error('permission_letter') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            {{-- Form Action Buttons --}}
            <div class="mt-4 flex items-center gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('user.dashboard') }}" class="flex-1 rounded-2xl bg-slate-100 py-3.5 text-center text-xs font-extrabold text-slate-700 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 rounded-2xl bg-brand-600 py-3.5 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                    Kirim Permohonan Peminjaman
                </button>
            </div>
        </form>
    </div>
@endsection
