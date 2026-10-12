{{-- resources/views/admin/dashboard.blade.php --}}
<x-admin-layout title="Dashboard">

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Total Booking', 'value' => $total],
            ['label' => 'Booking Hari Ini', 'value' => $hariIni],
            ['label' => 'Pending', 'value' => $pending],
            ['label' => 'Selesai', 'value' => $selesai],
        ] as $stat)
            <div class="bg-white border rounded-xl p-4">
                <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold mt-1">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white border rounded-xl p-4 mb-8 max-w-xs">
        <p class="text-xs text-gray-500">Pendapatan Bulan Ini</p>
        <x-money :amount="$pendapatanBulanIni" class="text-xl font-bold mt-1 block" />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white border rounded-xl overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-sm">Booking Terbaru</h3>
                <a href="{{ route('admin.booking.index') }}" class="text-xs text-gray-500">Lihat Semua</a>
            </div>
            <div class="divide-y">
                @forelse($bookingTerbaru as $b)
                    <a href="{{ route('admin.booking.show', $b) }}" class="p-4 flex justify-between items-center text-sm hover:bg-gray-50">
                        <div>
                            <p class="font-medium">{{ $b->nama_pelanggan }}</p>
                            <p class="text-xs text-gray-400">{{ $b->pricelist?->nama_pricelist }}</p>
                        </div>
                        <x-status-badge :status="$b->status_booking" />
                    </a>
                @empty
                    <p class="p-4 text-sm text-gray-400">Belum ada booking.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white border rounded-xl overflow-hidden">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-sm">Jadwal Mendatang</h3>
            </div>
            <div class="divide-y">
                @forelse($bookingMendatang as $b)
                    <a href="{{ route('admin.booking.show', $b) }}" class="p-4 flex justify-between items-center text-sm hover:bg-gray-50">
                        <div>
                            <p class="font-medium">{{ $b->nama_pelanggan }}</p>
                            <p class="text-xs text-gray-400">{{ $b->tanggal_acara->format('d M Y') }} &middot; {{ $b->waktu_acara }}</p>
                        </div>
                        <x-status-badge :status="$b->status_booking" />
                    </a>
                @empty
                    <p class="p-4 text-sm text-gray-400">Tidak ada jadwal mendatang.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-admin-layout>