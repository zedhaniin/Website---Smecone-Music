<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - Smecone Music</title>
    
    {{-- Google Fonts: Plus Jakarta Sans & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700;1,800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 font-sans antialiased text-gray-800">
    <div class="flex min-h-screen w-full">
        {{-- Left Side (Brand Purple Panel) --}}
        <div class="relative hidden lg:flex lg:w-1/2 flex-col justify-between overflow-hidden bg-gradient-to-br from-brand-600 via-brand-700 to-brand-800 p-10 lg:p-14 text-white">
            {{-- Background subtle glow overlay --}}
            <div class="absolute -right-20 -bottom-20 h-96 w-96 rounded-full bg-brand-400/20 blur-3xl pointer-events-none"></div>

            {{-- Top-Left Logo & Title --}}
            <div class="relative z-10 flex items-center gap-3.5">
                <a href="{{ route('landing') }}" class="group flex items-center gap-3.5 transition-transform duration-300 hover:scale-[1.02]">
                    <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl bg-white shadow-lg p-1">
                        <img src="{{ asset('images/logo.png') }}" alt="Smecone Music Logo" class="h-full w-full rounded-xl object-cover">
                    </div>
                    <span class="text-2xl font-black tracking-tight text-white">Smecone Music</span>
                </a>
            </div>

            {{-- Center Headline & Quote --}}
            <div class="relative z-10 max-w-lg my-auto py-12">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white leading-[1.15] tracking-tight">
                    When the world fall, <br>
                    music speaks.
                </h1>
                <p class="mt-6 text-base text-brand-100/90 font-medium leading-relaxed">
                    Platform sistem informasi dan e-layanan ekstrakurikuler musik SMKN 1 Purwokerto yang modern, kreatif, dan nyaman digunakan.
                </p>
            </div>

            {{-- Bottom Left Copyright --}}
            <div class="relative z-10 text-xs font-semibold text-brand-200/80">
                &copy; {{ date('Y') }} Smecone Music SMKN 1 Purwokerto. Hak Cipta Dilindungi.
            </div>
        </div>

        {{-- Right Side (Clean Login Panel - No Logo) --}}
        <div class="flex w-full lg:w-1/2 flex-col justify-between bg-white px-8 sm:px-16 lg:px-20 py-12">
            {{-- Mobile Only Top Header --}}
            <div class="flex items-center gap-3 lg:hidden mb-8">
                <a href="{{ route('landing') }}" class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-white shadow-md border border-gray-100 p-0.5">
                        <img src="{{ asset('images/logo.png') }}" alt="Smecone Music" class="h-full w-full rounded-lg object-cover">
                    </div>
                    <span class="text-xl font-black tracking-tight text-gray-900">Smecone Music</span>
                </a>
            </div>

            {{-- Form Content Area --}}
            <div class="my-auto mx-auto w-full max-w-md">
                @yield('content')
            </div>

            {{-- Bottom Back to Home --}}
            <div class="mt-8 text-center text-xs font-semibold text-gray-400">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-600 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
