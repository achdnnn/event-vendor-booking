{{-- resources/views/admin/booking/index.blade.php --}}
<x-admin-layout title="Kelola Booking">

    <div class="flex gap-2 border-b mb-6 text-sm overflow-x-auto">
        <a href="{{ route('admin.booking.index') }}"
           class="px-4 py-2 border-b-2 {{ !request('status') ? 'border-gray-900 font-semibold' : 'border-transparent text-gray-500' }}">
            Semua
        </a>
        @foreach(App\Enums\BookingStatus::cases() as $status)
            <a href="{{ route('admin.booking.index', array_merge(request()->query(), ['status' => $status->value])) }}"
               class="px-4 py-2 border-b-2 whitespace-nowrap {{ request('status') === $status->value ? 'border-gray-900 font-semibold' : 'border-transparent text-gray-500' }}">
                {{ $status->label() }}
            </a>
        @endforeach
    </div>

    <form method="GET" class="mb-4">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kode, atau WhatsApp..."
               class="border rounded-lg px-3 py-2 text-sm w-full max-w-sm">
    </form>

    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b text-xs text-gray-500">
                <tr>
                    <th class="p-4">Customer</th>
                    <th class="p-4">Paket</th>
                    <th class="p-4">Jadwal</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Pembayaran</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4">
                            <p class="font-medium">{{ $booking->nama_pelanggan }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->kode_booking }}</p>
                        </td>
                        <td class="p-4">{{ $booking->pricelist?->nama_pricelist }}</td>
                        <td class="p-4">{{ $booking->tanggal_acara->format('d M Y') }}<br><span class="text-xs text-gray-400">{{ $booking->waktu_acara }}</span></td>
                        <td class="p-4"><x-status-badge :status="$booking->status_booking" /></td>
                        <td class="p-4"><x-status-badge :status="$booking->status_pembayaran" /></td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.booking.show', $booking) }}" class="text-xs font-semibold underline mr-2">Detail</a>
                            <form action="{{ route('admin.booking.destroy', $booking) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus booking ini?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-semibold text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-8 text-center text-gray-400">Belum ada booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $bookings->links() }}</div>

</x-admin-layout>