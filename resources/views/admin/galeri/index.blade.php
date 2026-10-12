{{-- resources/views/admin/galeri/index.blade.php --}}
<x-admin-layout title="Kelola Galeri">

    <div class="flex justify-end mb-6">
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-gray-900 text-white px-4 py-2.5 rounded-lg text-sm font-semibold">
            + Tambah Foto
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($galeris as $foto)
            <div class="border rounded-xl overflow-hidden bg-white">
                <x-photo-thumb :path="$foto->foto" :alt="$foto->judul" size="w-full h-40" />
                <div class="p-3">
                    <p class="font-semibold text-sm truncate">{{ $foto->judul }}</p>
                    <p class="text-xs text-gray-400">{{ $foto->kategori }}</p>
                    <div class="flex gap-2 mt-2">
                        <button
                            data-id="{{ $foto->id }}" data-judul="{{ $foto->judul }}"
                            data-deskripsi="{{ $foto->deskripsi }}" data-kategori="{{ $foto->kategori }}"
                            data-aktif="{{ $foto->aktif ? '1' : '0' }}"
                            onclick="bukaEditGaleri(this)"
                            class="flex-1 text-xs font-semibold bg-gray-100 rounded-lg py-1.5">Edit</button>
                        <form action="{{ route('admin.galeri.destroy', $foto) }}" method="POST"
                              onsubmit="return confirm('Hapus foto ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs font-semibold text-red-500 px-3 py-1.5">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400 col-span-full">Belum ada foto.</p>
        @endforelse
    </div>

    <x-admin.modal-form id="modalTambah" title="Tambah Foto" :action="route('admin.galeri.store')">
        @include('admin.galeri._form')
    </x-admin.modal-form>

    <x-admin.modal-form id="modalEdit" title="Edit Foto" action="" method="PUT">
        @include('admin.galeri._form', ['edit' => true])
    </x-admin.modal-form>

    @push('scripts')
    <script>
        function bukaEditGaleri(btn) {
            const form = document.getElementById('modalEdit-form');
            form.action = `/admin/galeri/${btn.dataset.id}`;
            form.querySelector('[name=judul]').value = btn.dataset.judul;
            form.querySelector('[name=deskripsi]').value = btn.dataset.deskripsi;
            form.querySelector('[name=kategori]').value = btn.dataset.kategori;
            form.querySelector('[name=aktif]').checked = btn.dataset.aktif === '1';
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>
    @endpush

</x-admin-layout>