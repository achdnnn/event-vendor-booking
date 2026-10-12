{{-- resources/views/admin/kalender/index.blade.php --}}
<x-admin-layout title="Kalender Booking">
    <div class="bg-white border rounded-xl overflow-hidden max-w-3xl">
        <div class="flex items-center justify-between p-4 border-b">
            <button id="prevMonth" class="px-3 py-1 rounded-lg hover:bg-gray-100">&larr;</button>
            <h2 id="monthLabel" class="font-semibold"></h2>
            <button id="nextMonth" class="px-3 py-1 rounded-lg hover:bg-gray-100">&rarr;</button>
        </div>
        <div class="grid grid-cols-7 text-center text-xs text-gray-400 border-b">
            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $hari)
                <div class="py-2">{{ $hari }}</div>
            @endforeach
        </div>
        <div id="grid" class="grid grid-cols-7"></div>
    </div>

    <div id="modal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-xl w-full max-w-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Detail Booking</h3>
                <button onclick="document.getElementById('modal').classList.add('hidden')">&times;</button>
            </div>
            <div id="modalBody" class="space-y-2 text-sm"></div>
        </div>
    </div>

    @push('scripts')
    <script>
        const namaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        let tahun = {{ now()->year }};
        let bulan = {{ now()->month }};
        let eventsByDate = {};

        async function muatKalender() {
            const res = await fetch(`{{ route('admin.kalender.data') }}?year=${tahun}&month=${bulan}`);
            const { events } = await res.json();

            eventsByDate = {};
            events.forEach(e => {
                (eventsByDate[e.tanggal_acara] ??= []).push(e);
            });

            document.getElementById('monthLabel').textContent = `${namaBulan[bulan - 1]} ${tahun}`;

            const hariPertama = new Date(tahun, bulan - 1, 1).getDay();
            const jumlahHari = new Date(tahun, bulan, 0).getDate();
            const grid = document.getElementById('grid');
            let html = '';

            for (let i = 0; i < hariPertama; i++) html += '<div class="h-20 border-b border-r"></div>';

            for (let hari = 1; hari <= jumlahHari; hari++) {
                const tanggal = `${tahun}-${String(bulan).padStart(2,'0')}-${String(hari).padStart(2,'0')}`;
                const daftar = eventsByDate[tanggal] || [];
                html += `<div class="h-20 border-b border-r p-1.5 ${daftar.length ? 'cursor-pointer hover:bg-gray-50' : ''}"
                              ${daftar.length ? `onclick="bukaModal('${tanggal}')"` : ''}>
                    <span class="text-sm">${hari}</span>
                    ${daftar.length ? `<span class="block text-[10px] font-semibold text-amber-700 mt-1">${daftar.length} booking</span>` : ''}
                </div>`;
            }

            grid.innerHTML = html;
        }

        function bukaModal(tanggal) {
            const daftar = eventsByDate[tanggal] || [];
            document.getElementById('modalBody').innerHTML = daftar.map(e => `
                <div class="border rounded-lg p-3 mb-2">
                    <p class="font-semibold">${e.nama_pelanggan}</p>
                    <p class="text-xs text-gray-500">${e.nama_pricelist} &middot; ${e.waktu_acara}</p>
                    <p class="text-xs text-gray-500">${e.lokasi_acara}</p>
                    <a href="${e.manage_url}" class="text-xs underline mt-1 inline-block">Kelola booking &rarr;</a>
                </div>
            `).join('');
            document.getElementById('modal').classList.remove('hidden');
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            bulan--; if (bulan < 1) { bulan = 12; tahun--; }
            muatKalender();
        });
        document.getElementById('nextMonth').addEventListener('click', () => {
            bulan++; if (bulan > 12) { bulan = 1; tahun++; }
            muatKalender();
        });

        muatKalender();
    </script>
    @endpush
</x-admin-layout>