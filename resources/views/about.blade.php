@extends('layouts.app')

@section('title', 'Tentang Kami - Smecone Music')

@section('content')
    {{-- Hero Header Banner --}}
    <div class="relative overflow-hidden bg-gradient-to-b from-brand-950 via-brand-900 to-slate-950 pt-28 pb-16 text-white sm:pt-36 sm:pb-20">
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-indigo-500/15 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Tentang Smecone Music</h1>
                <p class="mt-4 text-base sm:text-lg text-slate-300 font-medium leading-relaxed">"When the world fall, music speaks."</p>
            </div>
        </div>
    </div>

    <section class="py-20 sm:py-28 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Wadah Seni & Kreativitas Musik SMKN 1 Purwokerto</h2>
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

            <div class="mt-16 flex flex-col lg:flex-row h-auto lg:h-[340px] gap-4 w-full">
                <!-- Card 1 -->
                <div class="group relative flex flex-col lg:flex-row lg:flex-1 w-full overflow-hidden rounded-[2rem] bg-brand-50 border border-brand-100/50 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:lg:flex-[2.5] cursor-default">
                    <!-- Left Info -->
                    <div class="flex w-full lg:w-[260px] shrink-0 flex-col justify-between p-8 z-10">
                        <div>
                            <h3 class="text-2xl font-black text-brand-950 leading-tight">Latihan<br>Rutin</h3>
                        </div>
                        <div class="mt-8 flex items-center gap-2">
                            <span class="text-sm font-bold text-brand-800">Baca Detail</span>
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-200/50 text-brand-800 transition-colors group-hover:bg-brand-600 group-hover:text-white">
                                <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Content -->
                    <div class="relative flex flex-1 items-center overflow-hidden">
                        <div class="flex w-full items-center gap-6 p-8 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:-translate-x-8 lg:group-hover:translate-x-0 transition-all duration-700 delay-100 min-w-[300px]">
                            <div class="flex-1">
                                <p class="text-brand-900 font-semibold leading-relaxed">Jadwal latihan terstruktur dengan pembimbing berpengalaman di Studio Musik (STM).</p>
                            </div>
                            <div class="hidden md:flex h-24 w-24 shrink-0 rounded-2xl bg-brand-100/80 items-center justify-center text-brand-600 shadow-sm border border-brand-200/50">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group relative flex flex-col lg:flex-row lg:flex-1 w-full overflow-hidden rounded-[2rem] bg-brand-50 border border-brand-100/50 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:lg:flex-[2.5] cursor-default">
                    <!-- Left Info -->
                    <div class="flex w-full lg:w-[260px] shrink-0 flex-col justify-between p-8 z-10">
                        <div>
                            <h3 class="text-2xl font-black text-brand-950 leading-tight">Kompetisi<br>FLS3N</h3>
                        </div>
                        <div class="mt-8 flex items-center gap-2">
                            <span class="text-sm font-bold text-brand-800">Baca Detail</span>
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-200/50 text-brand-800 transition-colors group-hover:bg-brand-600 group-hover:text-white">
                                <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Content -->
                    <div class="relative flex flex-1 items-center overflow-hidden">
                        <div class="flex w-full items-center gap-6 p-8 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:-translate-x-8 lg:group-hover:translate-x-0 transition-all duration-700 delay-100 min-w-[300px]">
                            <div class="flex-1">
                                <p class="text-brand-900 font-semibold leading-relaxed">Aktif mengikuti FLS3N dan berbagai kompetisi musik tingkat regional hingga nasional.</p>
                            </div>
                            <div class="hidden md:flex h-24 w-24 shrink-0 rounded-2xl bg-brand-100/80 items-center justify-center text-brand-600 shadow-sm border border-brand-200/50">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group relative flex flex-col lg:flex-row lg:flex-1 w-full overflow-hidden rounded-[2rem] bg-brand-50 border border-brand-100/50 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:lg:flex-[2.5] cursor-default">
                    <!-- Left Info -->
                    <div class="flex w-full lg:w-[260px] shrink-0 flex-col justify-between p-8 z-10">
                        <div>
                            <h3 class="text-2xl font-black text-brand-950 leading-tight">Komunitas<br>Solid</h3>
                        </div>
                        <div class="mt-8 flex items-center gap-2">
                            <span class="text-sm font-bold text-brand-800">Baca Detail</span>
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-200/50 text-brand-800 transition-colors group-hover:bg-brand-600 group-hover:text-white">
                                <svg class="h-4 w-4 -rotate-45 transition-transform duration-500 group-hover:rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Content -->
                    <div class="relative flex flex-1 items-center overflow-hidden">
                        <div class="flex w-full items-center gap-6 p-8 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 lg:-translate-x-8 lg:group-hover:translate-x-0 transition-all duration-700 delay-100 min-w-[300px]">
                            <div class="flex-1">
                                <p class="text-brand-900 font-semibold leading-relaxed">Bergabung dengan puluhan siswa yang berbagi passion yang sama terhadap musik.</p>
                            </div>
                            <div class="hidden md:flex h-24 w-24 shrink-0 rounded-2xl bg-brand-100/80 items-center justify-center text-brand-600 shadow-sm border border-brand-200/50">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
