@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Selamat Datang Kembali</h2>
        <p class="mt-2 text-sm font-medium text-gray-500">Silakan login ke akun Smecone Music Anda untuk melanjutkan.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3.5 text-sm font-semibold text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm font-semibold text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700">Alamat Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-2xl border border-gray-300 px-4 py-3.5 text-sm font-medium transition-all duration-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none"
                   placeholder="contoh@email.com">
            @error('email')
                <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full rounded-2xl border border-gray-300 px-4 py-3.5 text-sm font-medium transition-all duration-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2.5">
            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded-md border-gray-300 text-brand-600 focus:ring-brand-500">
            <label for="remember" class="text-sm font-medium text-gray-600 select-none">Ingat saya</label>
        </div>

        <button type="submit" class="mt-2 w-full rounded-2xl bg-brand-600 px-6 py-4 text-sm font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/40 active:translate-y-0">
            Masuk ke Dasbor
        </button>
    </form>

    <p class="mt-8 text-center text-sm font-medium text-gray-500">
        Belum memiliki akun?
        <a href="{{ route('register') }}" class="font-extrabold text-brand-600 transition-colors hover:text-brand-700 hover:underline">Daftar Sekarang</a>
    </p>
@endsection
