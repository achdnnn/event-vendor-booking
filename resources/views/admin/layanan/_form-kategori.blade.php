{{-- resources/views/admin/layanan/_form-kategori.blade.php --}}
<div class="space-y-3 text-sm">
    <div>
        <label class="block text-xs font-semibold mb-1">Nama Layanan</label>
        <input type="text" name="nama_layanan" required class="w-full border rounded-lg p-2">
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="3" class="w-full border rounded-lg p-2"></textarea>
    </div>
    <div>
        <label class="block text-xs font-semibold mb-1">Foto {{ ($edit ?? false) ? '(kosongkan jika tidak diganti)' : '' }}</label>
        <input type="file" name="foto" accept="image/*" class="w-full text-xs">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="aktif" value="1" checked id="aktif-{{ ($edit ?? false) ? 'edit' : 'tambah' }}">
        <label for="aktif-{{ ($edit ?? false) ? 'edit' : 'tambah' }}" class="text-xs">Aktif / Tampilkan</label>
    </div>
</div>