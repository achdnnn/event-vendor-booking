{{-- resources/views/public/galeri.blade.php --}}
<x-public-layout title="Galeri">
    <div class="max-w-6xl mx-auto px-6 py-12">
        <h1 class="text-2xl font-bold mb-8">Galeri Hasil Kerja</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($galeris as $foto)
                <div class="rounded-xl overflow-hidden border">
                    <x-photo-thumb :path="$foto->foto" :alt="$foto->judul" size="w-full h-48" />
                    <div class="p-3">
                        <p class="font-semibold text-sm">{{ $foto->judul }}</p>
                        <p class="text-xs text-gray-400">{{ $foto->kategori }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 col-span-full">Belum ada foto galeri.</p>
            @endforelse
        </div>
    </div>
</x-public-layout>