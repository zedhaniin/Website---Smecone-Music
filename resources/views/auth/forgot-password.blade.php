@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <div class="mb-8">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-brand-600 transition-colors mb-4">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Login</span>
        </a>
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Lupa Kata Sandi?</h2>
        <p class="mt-2 text-xs sm:text-sm font-medium text-slate-500 leading-relaxed">
            Masukkan alamat email akun Anda. Kami akan mengirimkan tautan konfirmasi untuk mereset kata sandi langsung ke email Gmail Anda.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50/90 p-5 shadow-sm">
            <div class="flex items-start gap-3.5">
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-900">Email Berhasil Dikirim!</h3>
                    <p class="mt-1 text-xs font-medium text-emerald-800 leading-relaxed">{{ session('success') }}</p>
                    
                    {{-- Quick Action: Direct Link to Gmail --}}
                    @php
                        $targetEmail = session('reset_email', '');
                        $gmailUrl = $targetEmail ? "https://mail.google.com/mail/u/?authuser=" . urlencode($targetEmail) : "https://mail.google.com";
                    @endphp
                    <div class="mt-3.5 flex flex-wrap items-center gap-2.5">
                        <a href="{{ $gmailUrl }}" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-extrabold text-white shadow-sm transition-all">
                            <span>Buka Gmail Sekarang</span>
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-xs font-semibold text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                Alamat Email Gmail / Akun Anda
            </label>
            <div class="relative">
                <input type="email" name="email" id="email" value="{{ old('email', session('reset_email')) }}" required autofocus
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3.5 pl-11 text-sm font-medium transition-all duration-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none"
                       placeholder="contoh@gmail.com">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                </div>
            </div>
            @error('email')
                <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="tap-press mt-2 w-full rounded-2xl bg-brand-600 px-6 py-4 text-sm font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/40 active:translate-y-0 cursor-pointer">
            Kirim Tautan Reset Password
        </button>
    </form>

    <p class="mt-8 text-center text-xs sm:text-sm font-medium text-slate-500">
        Ingat kata sandi Anda?
        <a href="{{ route('login') }}" class="font-extrabold text-brand-600 transition-colors hover:text-brand-700 hover:underline">Masuk di Sini</a>
    </p>
@endsection
