@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Buat Password Baru</h2>
        <p class="mt-2 text-xs sm:text-sm font-medium text-slate-500 leading-relaxed">
            Silakan masukkan kata sandi baru untuk akun Anda (minimal 8 karakter).
        </p>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-xs font-semibold text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email Akun (Readonly display) --}}
        <div>
            <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">Email Akun</label>
            <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required readonly
                   class="w-full rounded-2xl border border-slate-200 bg-slate-100/80 px-4 py-3.5 text-sm font-semibold text-slate-600 focus:outline-none cursor-not-allowed">
            @error('email')
                <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                Password Baru (Minimal 8 Karakter) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input type="password" name="password" id="password" required autofocus minlength="8"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3.5 pr-11 text-sm font-medium transition-all duration-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none"
                       placeholder="Minimal 8 karakter unik">
                <button type="button" onclick="togglePassVisibility('password', this)"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="icon-eye h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="icon-eye-off hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div>
            <label for="password_confirmation" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-700">
                Konfirmasi Password Baru <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                       class="w-full rounded-2xl border border-slate-300 px-4 py-3.5 pr-11 text-sm font-medium transition-all duration-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 focus:outline-none"
                       placeholder="Ketik ulang password baru">
                <button type="button" onclick="togglePassVisibility('password_confirmation', this)"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 cursor-pointer">
                    <svg class="icon-eye h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg class="icon-eye-off hidden h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>

        <button type="submit" class="tap-press mt-2 w-full rounded-2xl bg-brand-600 px-6 py-4 text-sm font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/40 active:translate-y-0 cursor-pointer">
            Simpan Password Baru & Masuk
        </button>
    </form>

    <script>
        function togglePassVisibility(fieldId, btn) {
            const input = document.getElementById(fieldId);
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            const open = btn.querySelector('.icon-eye');
            const off = btn.querySelector('.icon-eye-off');
            if (open && off) {
                if (isPass) {
                    open.classList.add('hidden');
                    off.classList.remove('hidden');
                } else {
                    open.classList.remove('hidden');
                    off.classList.add('hidden');
                }
            }
        }
    </script>
@endsection
