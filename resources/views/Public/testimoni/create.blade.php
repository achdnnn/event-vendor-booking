{{-- resources/views/public/testimoni/create.blade.php --}}
<x-public-layout title="Berikan Testimoni">
    <div class="max-w-lg mx-auto px-6 py-16">
        <h1 class="text-2xl font-bold mb-2">Berikan Testimoni</h1>
        <p class="text-gray-500 text-sm mb-6">
            Untuk booking <strong>{{ $booking->kode_booking }}</strong> — {{ $booking->nama_pelanggan }}
        </p>

        <form action="{{ route('testimoni.store', $booking->token_testimoni) }}" method="POST"
              enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Rating</label>
                <select name="rating" required class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">-- Pilih Rating --</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} / 5</option>
                    @endfor
                </select>
                @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Ulasan</label>
                <textarea name="ulasan" rows="5" required maxlength="500"
                          class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('ulasan') }}</textarea>
                @error('ulasan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Foto (opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full text-sm">
                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold">
                Kirim Testimoni
            </button>
        </form>
    </div>
</x-public-layout>