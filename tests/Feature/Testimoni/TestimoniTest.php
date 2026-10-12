<?php


use App\Enums\BookingStatus;

test('testimoni bisa dikirim dengan token yang valid', function () {
     $booking = buatBooking();
    // $booking->update(['status_booking' => BookingStatus::Konfirmasi]);
    // $booking->update(['status_booking' => BookingStatus::Selesai]);
    // $booking->refresh();
    $service = app(\App\Services\BookingStatusService::class);

    $service->ubah($booking, BookingStatus::Konfirmasi);
    $service->ubah($booking, BookingStatus::Selesai);

    $booking->refresh();

   

    $this->post(route('testimoni.store', $booking->token_testimoni), [
        'rating' => 5,
        'ulasan' => 'Sangat memuaskan',
    ])->assertRedirect(route('home'));

    expect($booking->sudahTestimoni())->toBeTrue();
});

test('testimoni kedua dengan token sama ditolak', function () {
     $booking = buatBooking();
    // $booking->update(['status_booking' => BookingStatus::Konfirmasi]);
    // $booking->update(['status_booking' => BookingStatus::Selesai]);
    // $booking->refresh();
    $service = app(\App\Services\BookingStatusService::class);

    $service->ubah($booking, BookingStatus::Konfirmasi);
    $service->ubah($booking, BookingStatus::Selesai);

    $booking->refresh();

    $this->post(route('testimoni.store',  $booking->token_testimoni), ['rating' => 5, 'ulasan' => 'Bagus']);

    $this->post(route('testimoni.store',  $booking->token_testimoni), ['rating' => 4, 'ulasan' => 'Lagi'])
        ->assertForbidden();
});

test('token testimoni yang kadaluarsa ditolak', function () {
     $booking = buatBooking();
    // $booking->update(['status_booking' => BookingStatus::Konfirmasi]);
    // $booking->update(['status_booking' => BookingStatus::Selesai]);
    // $booking->refresh()->update(['expired_testimoni' => now()->subHour()]);
    $service = app(\App\Services\BookingStatusService::class);

    $service->ubah($booking, BookingStatus::Konfirmasi);
    $service->ubah($booking, BookingStatus::Selesai);

    $booking->refresh()->update(['expired_testimoni' => now()->subHour()]);
    $this->get(route('testimoni.create', $booking->token_testimoni))->assertForbidden();
});