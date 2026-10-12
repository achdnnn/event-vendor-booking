{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800">

    <nav class="border-b sticky top-0 bg-white/90 backdrop-blur z-20">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-lg">{{ config('app.name') }}</a>
            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'font-semibold' : '' }}">Beranda</a>
                <a href="{{ route('layanan.index') }}" class="{{ request()->routeIs('layanan.*') ? 'font-semibold' : '' }}">Layanan</a>
                <a href="{{ route('galeri.index') }}" class="{{ request()->routeIs('galeri.*') ? 'font-semibold' : '' }}">Galeri</a>
                <a href="{{ route('kalender.index') }}" class="{{ request()->routeIs('kalender.*') ? 'font-semibold' : '' }}">Kalender</a>
            </div>
            <a href="{{ route('layanan.index') }}"
               class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                Pesan Sekarang
            </a>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="max-w-6xl mx-auto px-6 mt-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="bg-gray-900 text-gray-400 mt-20">
        <div class="max-w-6xl mx-auto px-6 py-10 text-sm flex justify-between">
            <span>{{ config('app.name') }}</span>
            <span>&copy; {{ date('Y') }}</span>
        </div>
    </footer>
</body>
</html>