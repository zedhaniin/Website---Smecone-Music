@extends('layouts.auth')

@section('title', 'Verifikasi Kode OTP')

@section('content')
    <div class="mb-6">
        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 mb-4">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Verifikasi Email Anda</h2>
        <p class="mt-1.5 text-xs text-slate-500 leading-relaxed">
            Kami telah mengirimkan 6 digit kode OTP verifikasi ke alamat email:
        </p>
        <div class="mt-2 inline-flex items-center gap-2 rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-800 border border-slate-200">
            <svg class="h-3.5 w-3.5 text-brand-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
            <span class="font-mono text-brand-700">{{ $user->email }}</span>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-bold text-emerald-900 shadow-sm flex items-center gap-2.5">
            <svg class="h-4 w-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('warning'))
        <div class="mb-5 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-xs font-bold text-amber-900 shadow-sm flex items-start gap-2.5">
            <svg class="h-4 w-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>{{ session('warning') }}</span>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-xs font-bold text-rose-900 shadow-sm flex items-center gap-2.5">
            <svg class="h-4 w-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            <span>{{ session('error') ?: $errors->first() }}</span>
        </div>
    @endif

    {{-- Form Submit OTP --}}
    <form method="POST" action="{{ route('otp.submit') }}" id="otp-form" class="space-y-6">
        @csrf

        {{-- Hidden input storing full 6-digit OTP --}}
        <input type="hidden" name="otp" id="otp-hidden" required>

        <div>
            <label class="mb-3 block text-center text-xs font-extrabold uppercase tracking-wider text-slate-600">
                Masukkan 6 Digit Kode OTP
            </label>

            {{-- 6 Interlocking Interactive Digit Boxes --}}
            <div class="flex items-center justify-center gap-2 sm:gap-3" id="otp-inputs">
                @for($i = 0; $i < 6; $i++)
                    <input type="text" 
                           maxlength="1" 
                           inputmode="numeric" 
                           pattern="[0-9]*"
                           autocomplete="one-time-code"
                           data-index="{{ $i }}"
                           class="otp-digit h-14 w-12 sm:w-14 rounded-2xl border-2 border-slate-200 bg-slate-50 text-center text-2xl font-black text-brand-950 transition-all focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/15 focus:outline-none shadow-2xs"
                           autofocus="{{ $i === 0 ? 'true' : 'false' }}">
                @endfor
            </div>
            <p class="mt-2 text-center text-[11px] text-slate-400">Kode hanya berlaku selama 10 menit.</p>
        </div>

        <button type="submit" 
                id="btn-verify" 
                class="tap-press w-full rounded-2xl bg-brand-600 py-3.5 text-xs font-extrabold text-white shadow-lg shadow-brand-600/30 transition-all duration-200 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-xl hover:shadow-brand-600/40">
            Verifikasi & Masuk ke Dashboard
        </button>
    </form>

    {{-- Resend OTP Section with Cooldown Timer --}}
    <div class="mt-6 border-t border-slate-100 pt-5 text-center">
        <p class="text-xs text-slate-500 font-medium">Tidak menerima kode di email?</p>
        
        <form method="POST" action="{{ route('otp.resend') }}" id="resend-form" class="mt-2">
            @csrf
            <button type="submit" 
                    id="btn-resend" 
                    class="tap-press inline-flex items-center gap-1.5 text-xs font-extrabold text-brand-600 hover:text-brand-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span id="resend-label">Kirim Ulang Kode OTP</span>
                <span id="countdown" class="text-slate-400 font-semibold hidden">(<span id="timer">60</span>s)</span>
            </button>
        </form>

        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400">
            <span>Salah memasukkan email?</span>
            <a href="{{ route('register') }}" class="font-bold text-slate-700 hover:text-brand-600 underline transition-colors">
                Daftar Ulang
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const digitInputs = document.querySelectorAll('.otp-digit');
            const hiddenInput = document.getElementById('otp-hidden');
            const form = document.getElementById('otp-form');
            const btnResend = document.getElementById('btn-resend');
            const countdownEl = document.getElementById('countdown');
            const timerEl = document.getElementById('timer');

            // Auto-focus first input
            if (digitInputs.length > 0) {
                digitInputs[0].focus();
            }

            function updateHiddenInput() {
                let code = '';
                digitInputs.forEach(input => code += input.value);
                hiddenInput.value = code;
            }

            digitInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const value = e.target.value;
                    
                    // If multiple characters pasted in single input
                    if (value.length > 1) {
                        const cleanDigits = value.replace(/[^0-9]/g, '');
                        cleanDigits.split('').forEach((char, i) => {
                            if (index + i < digitInputs.length) {
                                digitInputs[index + i].value = char;
                            }
                        });
                        const nextFocus = Math.min(index + cleanDigits.length, digitInputs.length - 1);
                        digitInputs[nextFocus].focus();
                        updateHiddenInput();
                        return;
                    }

                    // Only digits allowed
                    input.value = value.replace(/[^0-9]/g, '');

                    if (input.value && index < digitInputs.length - 1) {
                        digitInputs[index + 1].focus();
                    }

                    updateHiddenInput();

                    // Auto-submit if all 6 filled
                    if (hiddenInput.value.length === 6) {
                        form.submit();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        digitInputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pastedData = (e.clipboardData || window.clipboardData).getData('text');
                    const cleanDigits = pastedData.replace(/[^0-9]/g, '');
                    cleanDigits.split('').slice(0, 6).forEach((char, i) => {
                        if (digitInputs[i]) {
                            digitInputs[i].value = char;
                        }
                    });
                    updateHiddenInput();
                    if (digitInputs[Math.min(cleanDigits.length, 5)]) {
                        digitInputs[Math.min(cleanDigits.length, 5)].focus();
                    }
                    if (hiddenInput.value.length === 6) {
                        form.submit();
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                updateHiddenInput();
                if (hiddenInput.value.length !== 6) {
                    e.preventDefault();
                    alert('Silakan masukkan 6 digit kode OTP secara lengkap.');
                    const firstEmpty = Array.from(digitInputs).find(i => !i.value);
                    if (firstEmpty) firstEmpty.focus();
                }
            });

            // Resend Countdown Timer (60s cooldown)
            let remainingTime = 60;
            let timerInterval = null;

            function startTimer() {
                btnResend.disabled = true;
                countdownEl.classList.remove('hidden');
                timerEl.textContent = remainingTime;

                timerInterval = setInterval(() => {
                    remainingTime--;
                    timerEl.textContent = remainingTime;

                    if (remainingTime <= 0) {
                        clearInterval(timerInterval);
                        btnResend.disabled = false;
                        countdownEl.classList.add('hidden');
                        remainingTime = 60;
                    }
                }, 1000);
            }

            // Start initial timer
            startTimer();
        });
    </script>
@endsection
