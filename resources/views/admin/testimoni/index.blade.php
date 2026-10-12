{{-- resources/views/admin/testimoni/index.blade.php --}}
<x-admin-layout title="Moderasi Testimoni">
    <div class="bg-white border rounded-xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-xs text-gray-500 border-b">
                <tr><th class="p-4">Pelanggan</th><th class="p-4">Rating</th><th class="p-4 w-1/3">Ulasan</th><th class="p-4">Status</th><th class="p-4">Aksi</th></tr>
            </thead>
            <tbody class="divide-y">
                @forelse($testimonis as $t)
                <tr>
                    <td class="p-4 font-medium">
                        {{ $t->nama_pelanggan }}<br>
                        <span class="text-xs text-gray-400">{{ $t->booking?->pricelist?->layanan?->nama_layanan }}</span>
                    </td>
                    <td class="p-4">{{ $t->rating }}/5</td>
                    <td class="p-4 text-gray-600">{{ $t->ulasan }}</td>
                    <td class="p-4"><x-status-badge :status="$t->status" /></td>
                    <td class="p-4">
                        <div class="flex gap-2 flex-wrap">
                            @if($t->status !== App\Enums\TestimoniStatus::Ditampilkan)
                            <form action="{{ route('admin.testimoni.updateStatus', $t) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditampilkan">
                                <button class="text-xs font-semibold text-green-600">Tampilkan</button>
                            </form>
                            @endif
                            @if($t->status !== App\Enums\TestimoniStatus::Disembunyikan)
                            <form action="{{ route('admin.testimoni.updateStatus', $t) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="disembunyikan">
                                <button class="text-xs font-semibold text-gray-500">Sembunyikan</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.testimoni.destroy', $t) }}" method="POST"
                                  onsubmit="return confirm('Hapus testimoni?')">
                                @csrf @method('DELETE')
                                <button class="text-xs font-semibold text-red-500">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada testimoni.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $testimonis->links() }}</div>
</x-admin-layout>