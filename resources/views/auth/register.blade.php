@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <h2 class="mb-6 text-lg font-bold text-gray-900">Buat Akun Baru</h2>

    <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
        <strong>Perhatian:</strong> Setelah mendaftar, akun Anda harus disetujui oleh Admin sebelum bisa login.
    </div>

    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all duration-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none"
                   placeholder="Nama lengkap Anda">
            @error('name')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all duration-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none"
                   placeholder="nama@email.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all duration-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none"
                   placeholder="Minimal 8 karakter">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm transition-all duration-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 focus:outline-none"
                   placeholder="Ulangi password">
        </div>

        <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-500/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-500/30">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-brand-600 transition-colors hover:text-brand-700">Login di sini</a>
    </p>
@endsection
