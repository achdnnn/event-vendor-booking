{{-- resources/views/public/booking/hasil.blade.php --}}
<x-public-layout title="Status Booking">
    <div class="max-w-lg mx-auto px-6 py-16">
        <h1 class="text-2xl font-bold mb-6">Status Booking</h1>

        <div class="border rounded-xl p-6 space-y-4">
            <div class="flex justify-between items-center">
                <span class="font-semibold">{{ $booking->kode_booking }}</span>
                <x-status-badge :status="$booking->status_booking" />
            </div>

            <div class="text-sm space-y-2 text-gray-600">
                <p><span class="text-gray-400">Paket:</span> {{ $booking->pricelist->nama_pricelist }}</p>
                <p><span class="text-gray-400">Tanggal:</span> {{ $booking->tanggal_acara->format('d M Y') }} &middot; {{ $booking->waktu_acara }}</p>
                <p><span class="text-gray-400">Lokasi:</span> {{ $booking->lokasi_acara }}</p>
            </div>

            <hr>

            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Pembayaran</span>
                <x-status-badge :status="$booking->status_pembayaran" />
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">DP</span>
                <x-money :amount="$booking->dp" class="font-semibold" />
            </div>

            @if($booking->payment_qr)
                <div class="pt-2">
                    <p class="text-xs text-gray-400 mb-2">Scan untuk pembayaran DP:</p>
                    <img src="{{ Storage::url($booking->payment_qr) }}" class="w-40 h-40 object-cover rounded-lg border">
                </div>
            @endif

            @if($booking->tokenTestimoniValid())
                <a href="{{ route('testimoni.create', $booking->token_testimoni) }}"
                   class="block text-center mt-4 bg-gray-900 text-white py-2.5 rounded-lg text-sm font-semibold">
                    Berikan Testimoni
                </a>
            @endif
        </div>
    </div>
</x-public-layout>