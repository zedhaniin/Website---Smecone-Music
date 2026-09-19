@extends('layouts.app')

@section('title', 'Struktur Kepengurusan - Smecone Music')

@section('content')
    <div class="bg-gradient-to-b from-gray-900 via-brand-950 to-brand-900 py-20 text-white sm:py-28">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-block rounded-full border border-brand-400/40 bg-brand-900/60 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-brand-200 backdrop-blur-md shadow-md">Organisasi</span>
                <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">Struktur Kepengurusan</h1>
                <p class="mt-4 text-base sm:text-lg text-brand-200/90 font-medium">Pengurus Smecone Music SMKN 1 Purwokerto yang menjalankan roda organisasi.</p>
            </div>
        </div>
    </div>

    <section class="py-16 sm:py-24 bg-gray-50/70">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if($members->count() > 0)
                @php
                    $divisionOrder = ['Pengurus Harian', 'Humas', 'Alat Musik', 'Vocal', 'Kegiatan', 'PDD', 'Perkap', 'Wirausaha'];
                    $grouped = $members->groupBy(function($member) {
                        return $member->division_group;
                    });
                @endphp

                <div class="space-y-16">
                    @foreach($divisionOrder as $divisionName)
                        @if(isset($grouped[$divisionName]) && $grouped[$divisionName]->count() > 0)
                            <div>
                                {{-- Division Header --}}
                                <div class="mb-8 flex items-center gap-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-white shadow-md shadow-brand-600/30">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">
                                            {{ $divisionName === 'Pengurus Harian' ? 'Pengurus Harian' : 'Divisi ' . $divisionName }}
                                        </h2>
                                        <p class="text-xs font-semibold text-brand-600 uppercase tracking-wider">{{ $grouped[$divisionName]->count() }} Anggota</p>
                                    </div>
                                    <div class="ml-2 flex-1 border-b border-gray-200"></div>
                                </div>

                                {{-- Division Grid --}}
                                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                                    @foreach($grouped[$divisionName] as $member)
                                        <div class="group relative overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-brand-500/20">
                                            {{-- Portrait Image --}}
                                            <div class="aspect-[3/4] w-full overflow-hidden bg-brand-50">
                                                @if($member->image_path)
                                                    <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-200 via-brand-100 to-brand-50 text-5xl font-extrabold text-brand-400">
                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Overlay Info --}}
                                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-brand-950/90 via-brand-950/60 to-transparent px-3 pb-3.5 pt-10">
                                                <h3 class="text-sm font-extrabold tracking-tight text-white drop-shadow-sm line-clamp-1">{{ $member->name }}</h3>
                                                <span class="mt-1 inline-block rounded-full bg-white/20 px-2.5 py-0.5 text-[11px] font-bold text-white/90 backdrop-blur-sm line-clamp-1">
                                                    {{ $member->display_position }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{-- Ungrouped / Extra members if any --}}
                    @php
                        $otherMembers = $members->reject(function($m) use ($divisionOrder) {
                            return in_array($m->division_group, $divisionOrder);
                        });
                    @endphp
                    @if($otherMembers->count() > 0)
                        <div>
                            <div class="mb-8 flex items-center gap-4">
                                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Anggota Lainnya</h2>
                                <div class="flex-1 border-b border-gray-200"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                                @foreach($otherMembers as $member)
                                    <div class="group relative overflow-hidden rounded-2xl bg-white shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-brand-500/20">
                                        <div class="aspect-[3/4] w-full overflow-hidden bg-brand-50">
                                            @if($member->image_path)
                                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-200 via-brand-100 to-brand-50 text-5xl font-extrabold text-brand-400">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-brand-950/90 via-brand-950/60 to-transparent px-3 pb-3.5 pt-10">
                                            <h3 class="text-sm font-extrabold tracking-tight text-white drop-shadow-sm line-clamp-1">{{ $member->name }}</h3>
                                            <span class="mt-1 inline-block rounded-full bg-white/20 px-2.5 py-0.5 text-[11px] font-bold text-white/90 backdrop-blur-sm line-clamp-1">
                                                {{ $member->display_position }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="py-16 text-center text-gray-500 font-medium">
                    <p>Struktur kepengurusan belum ditambahkan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
