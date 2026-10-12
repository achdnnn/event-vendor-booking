{{-- resources/views/public/pricelist/show.blade.php --}}
<x-public-layout :title="$pricelist->nama_pricelist">
    <div class="max-w-4xl mx-auto px-6 py-12">
        <a href="{{ route('layanan.show', $pricelist->layanan) }}" class="text-sm text-gray-500">&larr; Kembali</a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-6">
            <x-photo-thumb :path="$pricelist->foto" :alt="$pricelist->nama_pricelist" size="w-full h-72" />

            <div>
                <p class="text-xs uppercase tracking-widest text-gray-400">{{ $pricelist->layanan->nama_layanan }}</p>
                <h1 class="text-2xl font-bold mt-1">{{ $pricelist->nama_pricelist }}</h1>
                <x-money :amount="$pricelist->harga" class="text-2xl font-bold text-gray-900 mt-3 block" />
                <p class="text-gray-600 mt-4">{{ $pricelist->deskripsi }}</p>

                @if(!empty($pricelist->isi_paket))
                    <h3 class="font-semibold mt-6 mb-2">Isi Paket</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        @foreach($pricelist->isi_paket as $item)
                            <li>&check; {{ $item }}</li>
                        @endforeach
                    </ul>
                @endif

                @if(!empty($pricelist->syarat_ketentuan))
                    <h3 class="font-semibold mt-6 mb-2">Syarat & Ketentuan</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        @foreach($pricelist->syarat_ketentuan as $item)
                            <li>&bull; {{ $item }}</li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('booking.create', ['pricelist' => $pricelist->id]) }}"
                   class="inline-block mt-8 bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold">
                    Pesan Paket Ini
                </a>
            </div>
        </div>
    </div>
</x-public-layout>