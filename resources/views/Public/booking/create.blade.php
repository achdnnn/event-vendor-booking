{{-- resources/views/public/booking/create.blade.php --}}
<x-public-layout title="Form Booking">
    <div class="max-w-2xl mx-auto px-6 py-12">
        <h1 class="text-2xl font-bold mb-6">Form Pemesanan</h1>

        <form action="{{ route('booking.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Pilih Paket</label>
                <select name="pricelist_id" id="pricelist_id" required
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($layanans as $layanan)
                        <optgroup label="{{ $layanan->nama_layanan }}">
                            @foreach($layanan->pricelists as $paket)
                                <option value="{{ $paket->id }}"
                                    data-harga="{{ $paket->harga }}"
                                    @selected(old('pricelist_id', $paketDipilih?->id) == $paket->id)>
                                    {{ $paket->nama_pricelist }} &mdash; Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @error('pricelist_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="hargaPreview" class="hidden bg-gray-50 border rounded-lg p-4 text-sm">
                Harga paket: <span id="hargaPreviewNilai" class="font-semibold"></span>
                <p class="text-gray-400 text-xs mt-1">DP dan kode booking akan ditampilkan setelah pesanan dikonfirmasi.</p>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required
                       class="w-full border rounded-lg px-3 py-2 text-sm">
                @error('nama_pelanggan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">No. WhatsApp</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required
                           class="w-full border rounded-lg px-3 py-2 text-sm">
                    @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border rounded-lg px-3 py-2 text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Tanggal Acara</label>
                    <input type="date" name="tanggal_acara" value="{{ old('tanggal_acara') }}" required
                           min="{{ now()->addDay()->toDateString() }}"
                           class="w-full border rounded-lg px-3 py-2 text-sm">
                    @error('tanggal_acara') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Waktu Acara</label>
                    <input type="time" name="waktu_acara" value="{{ old('waktu_acara') }}" required
                           class="w-full border rounded-lg px-3 py-2 text-sm">
                    @error('waktu_acara') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Lokasi Acara</label>
                <input type="text" name="lokasi_acara" value="{{ old('lokasi_acara') }}" required
                       class="w-full border rounded-lg px-3 py-2 text-sm">
                @error('lokasi_acara') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Catatan (opsional)</label>
                <textarea name="catatan_tambahan" rows="3"
                          class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('catatan_tambahan') }}</textarea>
                @error('catatan_tambahan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <p class="text-xs text-gray-400">
                Cek <a href="{{ route('kalender.index') }}" class="underline">kalender ketersediaan</a> sebelum memilih jadwal.
            </p>

            <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold">
                Kirim Pemesanan
            </button>
        </form>
    </div>

    @push('scripts')
    <script>
        const select = document.getElementById('pricelist_id');
        const preview = document.getElementById('hargaPreview');
        const nilai = document.getElementById('hargaPreviewNilai');

        function tampilkanHarga() {
            const opsi = select.options[select.selectedIndex];
            const harga = opsi?.dataset?.harga;

            if (!harga) {
                preview.classList.add('hidden');
                return;
            }

            nilai.textContent = 'Rp ' + Number(harga).toLocaleString('id-ID');
            preview.classList.remove('hidden');
        }

        select.addEventListener('change', tampilkanHarga);
        tampilkanHarga();
    </script>
    @endpush
</x-public-layout>