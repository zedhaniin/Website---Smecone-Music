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
            <p class="text-xs text-slate-500 mt-0.5">Isi detail tanggal peminjaman dan sertakan surat izin yang valid.</p>
        </div>
    </div>

    <div class="w-full max-w-5xl rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 flex items-center gap-3.5 border-b border-slate-100 pb-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-50 text-brand-700 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Pengajuan Peminjaman Baru</h3>
                <p class="text-xs text-slate-500">Pastikan alat musik yang dipilih memiliki stok tersedia</p>
            </div>
        </div>

        <form method="POST" action="{{ route('user.borrowing.store') }}" enctype="multipart/form-data" class="flex flex-col gap-5">
            @csrf
            <div>
                <label for="instrument_id" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Pilih Alat Musik</label>
                <select name="instrument_id" id="instrument_id" required
                        class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    <option value="">-- Pilih Alat Musik --</option>
                    @foreach($instruments as $instrument)
                        <option value="{{ $instrument->id }}" {{ old('instrument_id') == $instrument->id ? 'selected' : '' }}>
                            {{ $instrument->name }} (Stok Tersedia: {{ $instrument->quantity }} unit)
                        </option>
                    @endforeach
                </select>
                @error('instrument_id') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Mulai Peminjaman</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('start_date') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Tanggal Selesai Peminjaman</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('end_date') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="permission_letter" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Upload Berkas Surat Izin (PDF/Gambar, max 5MB)</label>
                <input type="file" name="permission_letter" id="permission_letter" accept=".pdf,.jpg,.jpeg,.png" required
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs text-slate-600 file:mr-3 file:rounded-xl file:border-0 file:bg-brand-950 file:px-3.5 file:py-1.5 file:text-xs file:font-bold file:text-brand-300">
                @error('permission_letter') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4 flex items-center gap-3 pt-2">
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
