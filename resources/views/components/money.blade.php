{{-- resources/views/components/money.blade.php --}}
@props(['amount'])

<span {{ $attributes }}>Rp {{ number_format($amount, 0, ',', '.') }}</span>