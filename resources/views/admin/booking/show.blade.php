{{-- resources/views/admin/booking/show.blade.php --}}
<x-admin-layout title="Detail Booking">
    <a href="{{ route('admin.booking.index') }}" class="text-sm text-gray-500">&larr; Kembali</a>

    <div class="max-w-2xl mt-4 space-y-6">

        <div class="bg-white border rounded-xl p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-xl font-bold">{{ $booking->nama_pelanggan }}</h2>
                    <p class="text-sm text-gray-400">{{ $booking->kode_booking }}</p>
                </div>
                <x-status-badge :status="$booking->status_booking" />
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><p class="text-xs text-gray-400">Paket</p><p class="font-medium">{{ $booking->pricelist?->nama_pricelist }}</p></div>
                <div><p class="text-xs text-gray-400">Total Harga</p><x-money :amount="$booking->total_harga" class="font-medium" /></div>
                <div><p class="text-xs text-gray-400">WhatsApp</p><p class="font-medium">{{ $booking->no_hp }}</p></div>
                <div><p class="text-xs text-gray-400">Email</p><p class="font-medium">{{ $booking->email }}</p></div>
                <div><p class="text-xs text-gray-400">Tanggal</p><p class="font-medium">{{ $booking->tanggal_acara->format('d M Y') }}</p></div>
                <div><p class="text-xs text-gray-400">Waktu</p><p class="font-medium">{{ $booking->waktu_acara }}</p></div>
                <div><p class="text-xs text-gray-400">DP</p><x-money :amount="$booking->dp" class="font-medium" /></div>
                <div><p class="text-xs text-gray-400">Pembayaran</p><x-status-badge :status="$booking->status_pembayaran" /></div>
                <div class="col-span-2"><p class="text-xs text-gray-400">Lokasi</p><p class="font-medium">{{ $booking->lokasi_acara }}</p></div>
                @if($booking->catatan_tambahan)
                    <div class="col-span-2"><p class="text-xs text-gray-400">Catatan</p><p class="font-medium">{{ $booking->catatan_tambahan }}</p></div>
                @endif
            </div>
        </div>

        {{-- Ubah status: pilihan hanya dari statusBerikutnya() enum --}}
        @php $pilihanStatus = $booking->status_booking->statusBerikutnya(); @endphp
        <div class="bg-white border rounded-xl p-6">
            <h3 class="font-semibold mb-4">Ubah Status</h3>

            @if(empty($pilihanStatus))
                <p class="text-sm text-gray-400">Status "{{ $booking->status_booking->label() }}" adalah status akhir, tidak bisa diubah lagi.</p>
            @else
                <form action="{{ route('admin.booking.status', $booking) }}" method="POST" class="flex gap-3 flex-wrap">
                    @csrf @method('PATCH')
                    <select name="status_booking" class="border rounded-lg px-3 py-2 text-sm">
                        @foreach($pilihanStatus as $status)
                            <option value="{{ $status->value }}">{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Simpan</button>
                </form>
            @endif
            @error('status_booking') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        {{-- Pembayaran: tampil kalau sudah dikonfirmasi --}}
        @if($booking->status_booking === App\Enums\BookingStatus::Konfirmasi)
        <div class="bg-white border rounded-xl p-6">
            <h3 class="font-semibold mb-4">Pembayaran DP</h3>
            <form action="{{ route('admin.booking.pembayaran', $booking) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-xs font-semibold mb-1">QR Code Pembayaran</label>
                    @if($booking->payment_qr)
                        <img src="{{ Storage::url($booking->payment_qr) }}" class="w-32 h-32 object-cover rounded-lg border mb-2">
                    @endif
                    <input type="file" name="payment_qr" accept="image/*" class="w-full text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Metode Pembayaran</label>
                    <input type="text" name="metode_pembayaran" value="{{ $booking->metode_pembayaran }}"
                           class="w-full border rounded-lg px-3 py-2 text-sm" placeholder="Contoh: QRIS BCA">
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Status Pembayaran</label>
                    <select name="status_pembayaran" class="w-full border rounded-lg px-3 py-2 text-sm">
                        @foreach(App\Enums\PaymentStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($booking->status_pembayaran === $status)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">Simpan Pembayaran</button>
            </form>
        </div>
        @endif

        {{-- Link testimoni: tampil kalau sudah selesai --}}
        @if($booking->status_booking === App\Enums\BookingStatus::Selesai)
        <div class="bg-white border rounded-xl p-6">
            <h3 class="font-semibold mb-4">Link Testimoni</h3>
            @if($booking->tokenTestimoniValid())
                <div class="flex gap-2">
                    <input type="text" readonly value="{{ route('testimoni.create', $booking->token_testimoni) }}"
                           class="flex-1 border rounded-lg px-3 py-2 text-xs">
                </div>
                <p class="text-xs text-gray-400 mt-2">Kirim link ini ke pelanggan. Berlaku 24 jam sejak status diubah menjadi Selesai.</p>
            @elseif($booking->sudahTestimoni())
                <p class="text-sm text-gray-400">Pelanggan sudah memberikan testimoni.</p>
            @else
                <p class="text-sm text-yellow-600">Link testimoni sudah kadaluarsa.</p>
            @endif
        </div>
        @endif

    </div>
</x-admin-layout>