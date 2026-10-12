{{-- resources/views/public/home.blade.php --}}
<x-public-layout title="Beranda">

    <section class="bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto px-6 py-24">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight max-w-xl">
                Percayakan riasan hari spesial Anda kepada kami
            </h1>
            <p class="mt-4 text-gray-300 max-w-lg">
                Make up profesional untuk wedding, wisuda, dan berbagai acara Anda.
            </p>
            <a href="{{ route('layanan.index') }}"
               class="inline-block mt-8 bg-white text-gray-900 px-6 py-3 rounded-lg font-semibold">
                Lihat Layanan
            </a>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold mb-8">Kategori Layanan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($layanans as $layanan)
                <a href="{{ route('layanan.show', $layanan) }}"
                   class="border rounded-xl p-5 hover:shadow-lg transition block">
                    <x-photo-thumb :path="$layanan->foto" :alt="$layanan->nama_layanan" size="w-full h-40" />
                    <h3 class="font-semibold mt-4">{{ $layanan->nama_layanan }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $layanan->pricelists->count() }} paket tersedia</p>
                </a>
            @empty
                <p class="text-gray-400 col-span-full">Belum ada layanan aktif.</p>
            @endforelse
        </div>
    </section>

    @if($galeris->isNotEmpty())
    <section class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl font-bold mb-8">Portofolio</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($galeris as $foto)
                    <x-photo-thumb :path="$foto->foto" :alt="$foto->judul" size="w-full h-48" />
                @endforeach
            </div>
            <a href="{{ route('galeri.index') }}" class="inline-block mt-6 text-sm font-semibold underline">
                Lihat semua galeri
            </a>
        </div>
    </section>
    @endif

    @if($testimonis->isNotEmpty())
    <section class="max-w-6xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold mb-8">Kata Mereka</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($testimonis as $t)
                <div class="border rounded-xl p-5">
                    <p class="text-sm text-gray-600 italic">&ldquo;{{ $t->ulasan }}&rdquo;</p>
                    <p class="mt-4 font-semibold text-sm">{{ $t->nama_pelanggan }}</p>
                    <p class="text-xs text-gray-400">Rating: {{ $t->rating }}/5</p>
                </div>
            @endforeach
        </div>
    </section>
    @endif

</x-public-layout>