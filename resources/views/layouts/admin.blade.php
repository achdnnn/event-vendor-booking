<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r flex flex-col shrink-0">
        <div class="p-6 border-b">
            <a href="{{ route('home') }}" class="font-bold text-lg">{{ config('app.name') }}</a>
        </div>
        <nav class="flex-1 p-4 space-y-1 text-sm">
            @php
                $navItems = [
                    ['route' => 'admin.dashboard',            'label' => 'Dashboard'],
                    ['route' => 'admin.kalender.index',       'label' => 'Kalender'],
                    ['route' => 'admin.booking.index',        'label' => 'Booking'],
                    ['route' => 'admin.layanan-kategori.index','label' => 'Kategori Layanan'],
                    ['route' => 'admin.layanan.index',        'label' => 'Paket / Pricelist'],
                    ['route' => 'admin.galeri.index',         'label' => 'Galeri'],
                    ['route' => 'admin.testimoni.index',      'label' => 'Testimoni'],
                    ['route' => 'admin.notifikasi.index',     'label' => 'Notifikasi'],
                    ['route' => 'admin.laporan.index',        'label' => 'Laporan'],
                ];
            @endphp
            @foreach($navItems as $item)
                @php $aktif = request()->routeIs($item['route'].'*'); @endphp
                <a href="{{ route($item['route']) }}"
                   class="block px-3 py-2 rounded-lg {{ $aktif ? 'bg-gray-900 text-white' : 'hover:bg-gray-100' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <div class="p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 text-sm">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 px-6 flex items-center justify-between bg-white border-b shrink-0">
            <h1 class="font-semibold text-lg">{{ $title ?? 'Dashboard' }}</h1>
            <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>