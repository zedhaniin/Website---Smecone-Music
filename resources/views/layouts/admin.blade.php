<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Smecone Music</title>
    
    {{-- Google Fonts: Plus Jakarta Sans & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- AlpineJS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="fixed top-0 left-0 z-40 flex h-screen w-64 flex-col border-r border-gray-200 bg-white shadow-sm transition-transform max-lg:-translate-x-full" id="sidebar">
            <div class="flex items-center gap-3 border-b border-gray-100 px-6 py-5">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-white shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Smecone Music" class="h-full w-full rounded-full object-cover">
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-brand-900">Smecone Music</h2>
                    <span class="text-xs font-semibold text-brand-600">{{ ucfirst(auth()->user()->role) }} Panel</span>
                </div>
            </div>


            <nav class="flex-1 overflow-y-auto px-4 py-5">
                <ul class="flex flex-col gap-1">
                    @if(auth()->user()->hasRole('admin', 'perkap'))
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.borrowings.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.borrowings.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                Peminjaman
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Booking Studio
                            </a>
                        </li>

                        @if(auth()->user()->isAdmin())
                            <li class="mt-4 mb-2 px-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Manajemen</li>

                            <li>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                                    Kelola User
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.instruments.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.instruments.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    Inventaris Alat
                                </a>
                            </li>

                            <li class="mt-4 mb-2 px-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Konten</li>

                            <li>
                                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.galleries.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Galeri Foto
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.showcases.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.showcases.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    Showcase
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.members.*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    Struktur Organisasi
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </nav>

            <div class="border-t border-gray-100 px-4 py-4">
                <div class="mb-3 flex items-center gap-3 px-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium text-red-600 transition-all duration-200 hover:bg-red-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Mobile sidebar toggle --}}
        <button type="button" class="fixed bottom-4 left-4 z-50 rounded-full bg-brand-600 p-3 text-white shadow-lg lg:hidden" onclick="document.getElementById('sidebar').classList.toggle('max-lg:-translate-x-full')">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        {{-- Main Content --}}
        <main class="flex-1 lg:ml-64">
            <div class="border-b border-gray-100 bg-white px-6 py-4 shadow-sm lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="mt-0.5 text-sm text-gray-500">@yield('page-description', '')</p>
                    </div>
                    <a href="{{ route('landing') }}" class="text-sm font-medium text-brand-600 transition-colors hover:text-brand-700">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            <div class="px-6 py-6 lg:px-8">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800" id="flash-success">
                        <svg class="h-5 w-5 shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800" id="flash-error">
                        <svg class="h-5 w-5 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('#flash-success, #flash-error').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
