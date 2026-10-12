{{-- resources/views/admin/laporan/index.blade.php --}}
<x-admin-layout title="Laporan">

    <form method="GET" class="flex gap-3 mb-6">
        <select name="bulan" class="border rounded-lg px-3 py-2 text-sm">
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" @selected($bulan == $m)>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
            @endfor
        </select>
        <select name="tahun" class="border rounded-lg px-3 py-2 text-sm">
            @for($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}" @selected($tahun == $y)>{{ $y }}</option>
            @endfor
        </select>
        <button class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold">Filter</button>
    </form>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border rounded-xl p-4"><p class="text-xs text-gray-500">Total Booking</p><p class="text-xl font-bold mt-1">{{ $total }}</p></div>
        <div class="bg-white border rounded-xl p-4"><p class="text-xs text-gray-500">Pendapatan</p><x-money :amount="$pendapatan" class="text-xl font-bold mt-1 block" /></div>
        @foreach($perStatus as $statusValue => $jumlah)
            <div class="bg-white border rounded-xl p-4">
                <p class="text-xs text-gray-500">{{ App\Enums\BookingStatus::from($statusValue)->label() }}</p>
                <p class="text-xl font-bold mt-1">{{ $jumlah }}</p>
            </div>
        @endforeach
    </div>

    @if($perPaket->isNotEmpty())
    <div class="mb-8">
        <h3 class="font-semibold mb-3">Per Paket (Status Selesai)</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($perPaket as $p)
                <div class="bg-white border rounded-xl p-4">
                    <p class="font-semibold text-sm">{{ $p->pricelist?->nama_pricelist ?? '-' }}</p>
                    <div class="flex justify-between text-xs text-gray-500 mt-2">
                        <span>Total: <strong class="text-gray-900">{{ $p->total }}</strong></span>
                        <span>Omset: <strong class="text-gray-900">Rp {{ number_format($p->omset, 0, ',', '.') }}</strong></span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 border-b">
                <tr><th class="p-4">Customer</th><th class="p-4">Paket</th><th class="p-4">Tanggal</th><th class="p-4">Total</th><th class="p-4">Status</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($bookings as $b)
                <tr>
                    <td class="p-4 font-medium">{{ $b->nama_pelanggan }}</td>
                    <td class="p-4">{{ $b->pricelist?->nama_pricelist }}</td>
                    <td class="p-4">{{ $b->tanggal_acara->format('d M Y') }}</td>
                    <td class="p-4"><x-money :amount="$b->total_harga" /></td>
                    <td class="p-4"><x-status-badge :status="$b->status_booking" /></td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-400">Tidak ada data untuk periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-admin-layout>