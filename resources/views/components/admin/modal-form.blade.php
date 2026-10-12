{{-- resources/views/components/admin/modal-form.blade.php --}}
@props(['id', 'title', 'action', 'method' => 'POST'])

<div id="{{ $id }}" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-md rounded-2xl p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold">{{ $title }}</h3>
            <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden')">&times;</button>
        </div>
        <form id="{{ $id }}-form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($method !== 'POST') @method($method) @endif

            {{ $slot }}

            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="document.getElementById('{{ $id }}').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg text-xs font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>