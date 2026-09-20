@extends('layouts.admin')

@section('title', 'Form Booking Studio Musik')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors mb-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Dashboard Saya</span>
            </a>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Form Booking Studio Musik (STM)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pilih jadwal waktu latihan band yang tidak bentrok dengan jadwal lain.</p>
        </div>
    </div>

    <div class="w-full max-w-5xl rounded-3xl border border-slate-200/60 bg-white p-6 sm:p-8 shadow-sm">
        <div class="mb-6 flex items-center gap-3.5 border-b border-slate-100 pb-5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 font-bold shrink-0">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
            </div>
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Reservasi Jadwal Studio STM</h3>
                <p class="text-xs text-slate-500">Cek kalender di dashboard utama untuk memastikan slot waktu kosong</p>
            </div>
        </div>

        <form method="POST" action="{{ route('user.booking.store') }}" class="flex flex-col gap-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Waktu Mulai Latihan</label>
                    <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('start_time') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="end_time" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Waktu Selesai Latihan</label>
                    <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">
                    @error('end_time') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="purpose" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Keperluan & Agenda Latihan</label>
                <textarea name="purpose" id="purpose" rows="4" required placeholder="Contoh: Latihan band rutin persiapan event festival musik sekolah Smecone"
                          class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs font-semibold text-slate-800 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none transition-all">{{ old('purpose') }}</textarea>
                @error('purpose') <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4 flex items-center gap-3 pt-2">
                <a href="{{ route('user.dashboard') }}" class="flex-1 rounded-2xl bg-slate-100 py-3.5 text-center text-xs font-extrabold text-slate-700 hover:bg-slate-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="flex-1 rounded-2xl bg-brand-600 py-3.5 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                    Kirim Permohonan Booking Studio
                </button>
            </div>
        </form>
    </div>
@endsection
