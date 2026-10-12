{{-- resources/views/public/layanan/index.blade.php --}}
<x-public-layout title="Layanan">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <h1 class="text-2xl font-bold mb-8">Pilihan Layanan</h1>

        <div class="space-y-12">
            @forelse($layanans as $layanan)
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold">{{ $layanan->nama_layanan }}</h2>
                        <a href="{{ route('layanan.show', $layanan) }}" class="text-sm underline">Lihat detail</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($layanan->pricelists as $paket)
                            <div class="border rounded-xl p-5">
                                <x-photo-thumb :path="$paket->foto" :alt="$paket->nama_pricelist" size="w-full h-36" />
                                <h3 class="font-semibold mt-3">{{ $paket->nama_pricelist }}</h3>
                                <x-money :amount="$paket->harga" class="text-lg font-bold text-gray-900 mt-1 block" />
                                <a href="{{ route('pricelist.show', $paket) }}"
                                   class="inline-block mt-3 text-sm font-semibold bg-gray-900 text-white px-4 py-2 rounded-lg">
                                    Lihat Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-400">Belum ada layanan aktif.</p>
            @endforelse
        </div>
    </div>
</x-public-layout>