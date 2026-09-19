@extends('layouts.admin')

@section('page-title', 'Dashboard Anggota')
@section('page-description', 'Ajukan peminjaman alat dan booking Studio Musik (STM).')

@section('content')
    <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">
        {{-- Peminjaman Alat Section --}}
        <div>
            <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center gap-2">
                    <svg class="h-5 w-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h3 class="text-base font-bold text-gray-900">Ajukan Peminjaman Alat</h3>
                </div>
                <form method="POST" action="{{ route('user.borrowing.store') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label for="instrument_id" class="mb-1.5 block text-sm font-medium text-gray-700">Pilih Alat Musik</label>
                        <select name="instrument_id" id="instrument_id" required
                                class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                            <option value="">-- Pilih Alat --</option>
                            @foreach($instruments as $instrument)
                                <option value="{{ $instrument->id }}" {{ old('instrument_id') == $instrument->id ? 'selected' : '' }}>
                                    {{ $instrument->name }} ({{ $instrument->quantity }} unit)
                                </option>
                            @endforeach
                        </select>
                        @error('instrument_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="mb-1.5 block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                            @error('start_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_date" class="mb-1.5 block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                            @error('end_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="permission_letter" class="mb-1.5 block text-sm font-medium text-gray-700">Upload Surat Izin (PDF/Gambar)</label>
                        <input type="file" name="permission_letter" id="permission_letter" accept=".pdf,.jpg,.jpeg,.png" required
                               class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-brand-700">
                        @error('permission_letter') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                        Ajukan Peminjaman
                    </button>
                </form>
            </div>

            {{-- Riwayat Peminjaman --}}
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-sm font-bold text-gray-900">Riwayat Peminjaman Anda</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($borrowings as $borrowing)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $borrowing->instrument->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->start_date->format('d M Y') }} — {{ $borrowing->end_date->format('d M Y') }}</p>
                            </div>
                            <span class="ml-3 shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $borrowing->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                {{ $borrowing->status === 'approved' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $borrowing->status === 'rejected' ? 'bg-red-50 text-red-700' : '' }}
                                {{ $borrowing->status === 'returned' ? 'bg-gray-100 text-gray-600' : '' }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-sm text-gray-400">Belum ada riwayat peminjaman.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Booking Studio Section --}}
        <div>
            <div class="mb-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="mb-5 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        <h3 class="text-base font-bold text-gray-900">Booking Studio Musik (STM)</h3>
                    </div>
                    <a href="{{ route('user.calendar') }}" class="text-xs font-semibold text-brand-600 transition-colors hover:text-brand-700">
                        Lihat Kalender →
                    </a>
                </div>
                <form method="POST" action="{{ route('user.booking.store') }}" class="flex flex-col gap-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="mb-1.5 block text-sm font-medium text-gray-700">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" required
                                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                            @error('start_time') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="mb-1.5 block text-sm font-medium text-gray-700">Waktu Selesai</label>
                            <input type="datetime-local" name="end_time" id="end_time" value="{{ old('end_time') }}" required
                                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">
                            @error('end_time') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="purpose" class="mb-1.5 block text-sm font-medium text-gray-700">Keperluan</label>
                        <textarea name="purpose" id="purpose" rows="2" required placeholder="Contoh: Latihan band untuk lomba FLS3N"
                                  class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none">{{ old('purpose') }}</textarea>
                        @error('purpose') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                        Ajukan Booking
                    </button>
                </form>
            </div>

            {{-- Riwayat Booking --}}
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-sm font-bold text-gray-900">Riwayat Booking Studio Anda</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($bookings as $booking)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-gray-900">{{ $booking->purpose }}</p>
                                <p class="text-xs text-gray-500">{{ $booking->start_time->format('d M Y H:i') }} — {{ $booking->end_time->format('H:i') }}</p>
                            </div>
                            <span class="ml-3 shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $booking->status === 'pending' ? 'bg-amber-50 text-amber-700' : '' }}
                                {{ $booking->status === 'approved' ? 'bg-green-50 text-green-700' : '' }}
                                {{ $booking->status === 'rejected' ? 'bg-red-50 text-red-700' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-sm text-gray-400">Belum ada riwayat booking.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
