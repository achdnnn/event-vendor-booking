{{-- resources/views/admin/layanan/kategori.blade.php --}}
<x-admin-layout title="Kategori Layanan">

    <div class="flex justify-end mb-6">
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-gray-900 text-white px-4 py-2.5 rounded-lg text-sm font-semibold">
            + Tambah Kategori
        </button>
    </div>

    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 border-b">
                <tr><th class="p-3">Foto</th><th class="p-3">Nama</th><th class="p-3">Paket</th><th class="p-3">Status</th><th class="p-3 text-center">Aksi</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($layanans as $item)
                <tr>
                    <td class="p-3"><x-photo-thumb :path="$item->foto_layanan" size="w-10 h-10" /></td>
                    <td class="p-3 font-medium">{{ $item->nama_layanan }}</td>
                    <td class="p-3">
                        <a href="{{ route('admin.layanan.index') }}" class="underline">{{ $item->pricelists_count }} paket</a>
                    </td>
                    <td class="p-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $item->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <button
                            data-id="{{ $item->id }}"
                            data-nama="{{ $item->nama_layanan }}"
                            data-deskripsi="{{ $item->deskripsi }}"
                            onclick="bukaEditKategori(this)"
                            class="text-xs font-semibold underline">Edit</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-3 text-gray-400">Belum ada kategori layanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-admin.modal-form id="modalTambah" title="Tambah Kategori" :action="route('admin.layanan-kategori.store')">
        @include('admin.layanan._form-kategori')
    </x-admin.modal-form>

    <x-admin.modal-form id="modalEdit" title="Edit Kategori" action="" method="PUT">
        @include('admin.layanan._form-kategori', ['edit' => true])
    </x-admin.modal-form>

    @push('scripts')
    <script>
        function bukaEditKategori(btn) {
            const form = document.getElementById('modalEdit-form');
            form.action = `/admin/layanan-kategori/${btn.dataset.id}`;
            form.querySelector('[name=nama_layanan]').value = btn.dataset.nama;
            form.querySelector('[name=deskripsi]').value = btn.dataset.deskripsi;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>
    @endpush

</x-admin-layout>
