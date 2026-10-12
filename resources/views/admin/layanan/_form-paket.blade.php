{{-- resources/views/admin/layanan/_form-paket.blade.php --}}
<div class="space-y-3 text-sm max-h-[70vh] overflow-y-auto">
    <div>
        <label class="block text-xs font-semibold mb-1">Kategori</label>
        <select name="layanan_id" required class="w-full border rounded-lg p-2">
            @foreach($layanans as $l)
                <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Nama Paket</label>
        <input type="text" name="nama_pricelist" required class="w-full border rounded-lg p-2">
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Harga (Rp)</label>
        <input type="number" name="harga" min="0" required class="w-full border rounded-lg p-2">
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="2" required class="w-full border rounded-lg p-2"></textarea>
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Isi Paket (satu per baris)</label>
        <textarea name="isi_paket" rows="4" class="w-full border rounded-lg p-2" placeholder="Make up&#10;Hair do"></textarea>
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Syarat & Ketentuan (satu per baris)</label>
        <textarea name="syarat_ketentuan" rows="4" class="w-full border rounded-lg p-2"></textarea>
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Foto</label>
        <input type="file" name="foto" accept="image/*" class="w-full text-xs">
    </div>
</div>