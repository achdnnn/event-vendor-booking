{{-- resources/views/admin/notifikasi/index.blade.php --}}
<x-admin-layout title="Notifikasi">

    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold">Daftar Notifikasi</h2>
        <form action="{{ route('admin.notifikasi.bacaSemua') }}" method="POST">
            @csrf
            <button class="text-sm bg-gray-100 px-4 py-2 rounded-lg font-semibold">Tandai Semua Dibaca</button>
        </form>
    </div>

    <div class="bg-white border rounded-xl divide-y">
        @forelse($notifikasis as $n)
            <div class="p-4 flex justify-between items-center text-sm {{ $n->sudah_dibaca ? '' : 'bg-amber-50/40' }}">
                <div>
                    <p>{{ $n->pesan }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $n->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="flex gap-2 shrink-0 ml-4">
                    @unless($n->sudah_dibaca)
                    <form action="{{ route('admin.notifikasi.baca', $n) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="text-xs font-semibold text-blue-600">Tandai Dibaca</button>
                    </form>
                    @endunless
                    <form action="{{ route('admin.notifikasi.destroy', $n) }}" method="POST"
                          onsubmit="return confirm('Hapus notifikasi?')">
                        @csrf @method('DELETE')
                        <button class="text-xs font-semibold text-red-500">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="p-8 text-center text-gray-400 text-sm">Belum ada notifikasi.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $notifikasis->links() }}</div>

</x-admin-layout>