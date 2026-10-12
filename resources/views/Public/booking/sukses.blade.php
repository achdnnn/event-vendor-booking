{{-- resources/views/public/booking/sukses.blade.php --}}
<x-public-layout title="Booking Berhasil">
    <div class="max-w-lg mx-auto px-6 py-16 text-center">
        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto text-2xl">
            &check;
        </div>
        <h1 class="text-2xl font-bold mt-6">Booking Berhasil!</h1>
        <p class="text-gray-500 mt-2">Terima kasih, {{ $booking->nama_pelanggan }}. Kami akan segera menghubungi Anda.</p>

        <div class="border rounded-xl p-6 mt-8 text-left space-y-3 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Kode Booking</span><span class="font-semibold">{{ $booking->kode_booking }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Paket</span><span class="font-semibold">{{ $booking->pricelist->nama_pricelist }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-semibold">{{ $booking->tanggal_acara->format('d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Waktu</span><span class="font-semibold">{{ $booking->waktu_acara }}</span></div>
            <hr>
            <div class="flex justify-between"><span class="text-gray-500">Total Harga</span><x-money :amount="$booking->total_harga" class="font-semibold" /></div>
            <div class="flex justify-between"><span class="text-gray-500">DP (30%)</span><x-money :amount="$booking->dp" class="font-semibold text-gray-900" /></div>
        </div>

        <a href="{{ route('booking.hasil', ['kode_booking' => $booking->kode_booking]) }}"
           class="inline-block mt-6 bg-gray-900 text-white px-6 py-3 rounded-lg font-semibold">
            Cek Status Booking
        </a>
    </div>
</x-public-layout>