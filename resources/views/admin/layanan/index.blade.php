{{-- resources/views/admin/layanan/index.blade.php --}}
<x-admin-layout title="Paket / Pricelist">

    <div class="flex justify-end mb-6">
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-gray-900 text-white px-4 py-2.5 rounded-lg text-sm font-semibold">
            + Tambah Paket
        </button>
    </div>

    @forelse($pricelists as $namaKategori => $items)
        <div class="mb-8">
            <h3 class="font-semibold mb-3">{{ $namaKategori }}</h3>
            <div class="bg-white border rounded-xl overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-xs text-gray-500 border-b">
                        <tr><th class="p-3">Foto</th><th class="p-3">Nama</th><th class="p-3">Harga</th><th class="p-3 text-center">Aksi</th></tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($items as $item)
                        <tr>
                            <td class="p-3"><x-photo-thumb :path="$item->foto" size="w-10 h-10" /></td>
                            <td class="p-3 font-medium">{{ $item->nama_pricelist }}</td>
                            <td class="p-3"><x-money :amount="$item->harga" /></td>
                            <td class="p-3 text-center">
                                <button
                                    data-id="{{ $item->id }}"
                                    data-layanan="{{ $item->layanan_id }}"
                                    data-nama="{{ $item->nama_pricelist }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-harga="{{ $item->harga }}"
                                    data-isi="{{ implode("\n", $item->isi_paket ?? []) }}"
                                    data-syarat="{{ implode("\n", $item->syarat_ketentuan ?? []) }}"
                                    onclick="bukaEditPaket(this)"
                                    class="text-xs font-semibold underline mr-2">Edit</button>
                                <form action="{{ route('admin.layanan.destroy', $item) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs font-semibold text-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <p class="text-gray-400">Belum ada paket.</p>
    @endforelse

    <x-admin.modal-form id="modalTambah" title="Tambah Paket" :action="route('admin.layanan.store')">
        @include('admin.layanan._form-paket')
    </x-admin.modal-form>

    <x-admin.modal-form id="modalEdit" title="Edit Paket" action="" method="PUT">
        @include('admin.layanan._form-paket', ['edit' => true])
    </x-admin.modal-form>

    @push('scripts')
    <script>
        function bukaEditPaket(btn) {
            const form = document.getElementById('modalEdit-form');
            form.action = `/admin/layanan/${btn.dataset.id}`;
            form.querySelector('[name=layanan_id]').value = btn.dataset.layanan;
            form.querySelector('[name=nama_pricelist]').value = btn.dataset.nama;
            form.querySelector('[name=deskripsi]').value = btn.dataset.deskripsi;
            form.querySelector('[name=harga]').value = btn.dataset.harga;
            form.querySelector('[name=isi_paket]').value = btn.dataset.isi;
            form.querySelector('[name=syarat_ketentuan]').value = btn.dataset.syarat;
            document.getElementById('modalEdit').classList.remove('hidden');
        }
    </script>
    @endpush

</x-admin-layout>