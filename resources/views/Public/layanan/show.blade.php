{{-- resources/views/public/layanan/show.blade.php --}}
<x-public-layout :title="$layanan->nama_layanan">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <a href="{{ route('layanan.index') }}" class="text-sm text-gray-500">&larr; Kembali</a>

        <h1 class="text-2xl font-bold mt-4">{{ $layanan->nama_layanan }}</h1>
        @if($layanan->deskripsi)
            <p class="text-gray-600 mt-2 max-w-2xl">{{ $layanan->deskripsi }}</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-8">
            @foreach($layanan->pricelists as $paket)
                <div class="border rounded-xl p-5">
                    <x-photo-thumb :path="$paket->foto" :alt="$paket->nama_pricelist" size="w-full h-36" />
                    <h3 class="font-semibold mt-3">{{ $paket->nama_pricelist }}</h3>
                    <x-money :amount="$paket->harga" class="text-lg font-bold mt-1 block" />
                    <a href="{{ route('pricelist.show', $paket) }}"
                       class="inline-block mt-3 text-sm font-semibold bg-gray-900 text-white px-4 py-2 rounded-lg">
                        Lihat Detail
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-public-layout>