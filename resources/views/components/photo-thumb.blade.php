{{-- resources/views/components/photo-thumb.blade.php --}}
@props(['path', 'alt' => '', 'size' => 'w-16 h-16'])

@if($path)
    <img src="{{ Storage::url($path) }}" alt="{{ $alt }}" class="{{ $size }} rounded-lg object-cover">
@else
    <div class="{{ $size }} rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
        No Photo
    </div>
@endif