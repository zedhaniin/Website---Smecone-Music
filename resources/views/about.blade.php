@extends('layouts.app')

@section('title', 'Tentang Kami - Smecone Music')

@section('content')
    <div class="bg-gradient-to-b from-gray-900 to-brand-950 pt-28 pb-20 text-white sm:pt-36 sm:pb-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-block rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-200 backdrop-blur-md">Profil Organization</span>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Tentang Smecone Music</h1>
                <p class="mt-4 text-lg text-brand-200/90 font-medium">"When the world fall, music speaks."</p>
            </div>
        </div>
    </div>

    <section class="py-20 sm:py-28 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="inline-block rounded-full bg-gray-100 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-gray-900">Visi & Misi</span>
                    <h2 class="mt-4 text-3xl font-extrabold text-gray-900 sm:text-4xl">Wadah Seni & Kreativitas Musik SMKN 1 Purwokerto</h2>
                    <p class="mt-6 text-base leading-relaxed text-gray-600 font-medium">
                        Smecone Music merupakan ekstrakurikuler musik resmi di SMKN 1 Purwokerto. Kami berkomitmen untuk menjadi ruang berekspresi, mengasah bakat bermusik, serta membangun karakter kepemimpinan dan kekeluargaan di antara para anggotanya.
                    </p>
                    <p class="mt-4 text-base leading-relaxed text-gray-600 font-medium">
                        Melalui latihan rutin di Studio Musik (STM), workshop internal, dan keikutsertaan aktif dalam ajang bergengsi seperti Festival Lomba Seni Siswa Nasional (FLS3N), Smecone Music terus mencetak prestasi dan melahirkan karya-karya terbaik.
                    </p>
                </div>
                <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                    <img src="{{ asset('images/hero-bg.png') }}" alt="Smecone Music Group" class="w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <p class="text-sm font-extrabold uppercase tracking-wider">Ekstrakurikuler Musik</p>
                        <p class="text-xl font-black">SMK Negeri 1 Purwokerto</p>
                    </div>
                </div>
            </div>

            <div class="mt-24 grid grid-cols-1 gap-8 sm:grid-cols-3">
                <div class="group rounded-3xl border border-gray-100 bg-gray-50/50 p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-500/10">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-1 ring-brand-200/50 transition-transform duration-300 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-brand-700 transition-colors">Studio & Fasilitas</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 font-medium">Dilengkapi studio musik (STM) ber-AC, alat musik lengkap (gitar, bass, drum, keyboard, sound system), dan ruang diskusi.</p>
                </div>
                <div class="group rounded-3xl border border-gray-100 bg-gray-50/50 p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-500/10">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-1 ring-brand-200/50 transition-transform duration-300 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-brand-700 transition-colors">Prestasi FLS3N</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 font-medium">Rutin meraih juara pada ajang FLS3N tingkat kab/kota hingga Jawa Tengah dalam cabang cipta lagu & solo vocal.</p>
                </div>
                <div class="group rounded-3xl border border-gray-100 bg-gray-50/50 p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-500/10">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 ring-1 ring-brand-200/50 transition-transform duration-300 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-extrabold text-gray-900 group-hover:text-brand-700 transition-colors">Keluargaan & Solidaritas</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600 font-medium">Bukan sekadar latihan, tetapi juga tempat menjalin persahabatan erat dan jaringan alumni musik yang solid.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
