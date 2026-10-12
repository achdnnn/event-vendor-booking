{{-- resources/views/public/booking/cek.blade.php --}}
<x-public-layout title="Cek Booking">
    <div class="max-w-md mx-auto px-6 py-16">
        <h1 class="text-2xl font-bold mb-2">Cek Status Booking</h1>
        <p class="text-gray-500 text-sm mb-6">Masukkan kode booking yang Anda terima.</p>

        <form action="{{ route('booking.hasil') }}" method="GET" class="space-y-4">
            <div>
                <input type="text" name="kode_booking" placeholder="Contoh: MUA-AB12C" required
                       class="w-full border rounded-lg px-3 py-2 text-sm">
                @error('kode_booking') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold">
                Cek Status
            </button>
        </form>
    </div>
</x-public-layout>