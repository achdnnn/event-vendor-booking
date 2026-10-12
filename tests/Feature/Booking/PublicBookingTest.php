<?php
// tests/Feature/Booking/PublicBookingTest.php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Notifikasi;

test('booking berhasil dibuat dengan total, dp, dan kode otomatis', function () {
    $paket = buatPaket();

    $this->post(route('booking.store'), dataBooking($paket))
        ->assertSessionHasNoErrors();

    $booking = Booking::firstOrFail();

    expect($booking->kode_booking)->toMatch('/^MUA-[A-Z0-9]{5}$/')
        ->and($booking->total_harga)->toBe(1500000)
        ->and($booking->dp)->toBe(450000)
        ->and($booking->refresh()->status_booking)->toBe(BookingStatus::Pending)
        ->and(Notifikasi::count())->toBe(1);
});

test('kode booking tidak bisa ditentukan oleh pengguna', function () {
    $paket = buatPaket();

    $this->post(route('booking.store'), dataBooking($paket, ['kode_booking' => 'HACK1']));

    expect(Booking::firstOrFail()->kode_booking)->not->toBe('HACK1');
});

test('jadwal yang sama tidak bisa dibooking dua kali', function () {
    $paket = buatPaket();
    $data = dataBooking($paket);

    $this->post(route('booking.store'), $data);
    $this->post(route('booking.store'), $data)->assertSessionHasErrors('waktu_acara');

    expect(Booking::count())->toBe(1);
});


test('jadwal kembali tersedia setelah booking ditolak', function () {
    $paket = buatPaket();
    $data = dataBooking($paket);

    $this->post(route('booking.store'), $data);
    Booking::firstOrFail()->update(['status_booking' => BookingStatus::Ditolak]);

    $this->post(route('booking.store'), $data)->assertSessionHasNoErrors();

    expect(Booking::count())->toBe(2);
});

test('paket dari layanan nonaktif ditolak', function () {
    $paket = buatPaket(['aktif' => false]);

    $this->post(route('booking.store'), dataBooking($paket))
        ->assertSessionHasErrors('pricelist_id');

    expect(Booking::count())->toBe(0);
});

test('tanggal acara harus setelah hari ini', function () {
    $paket = buatPaket();

    $this->post(route('booking.store'), dataBooking($paket, [
        'tanggal_acara' => now()->toDateString(),
    ]))->assertSessionHasErrors('tanggal_acara');
});

test('cek booking mengembalikan status dalam json', function () {
    $booking = buatBooking();

    $this->getJson(route('booking.hasil', ['kode_booking' => strtolower($booking->kode_booking)]))
        ->assertOk()
        ->assertJson(['status_booking' => 'pending', 'status_pembayaran' => 'belum_dp']);

    $this->getJson(route('booking.hasil', ['kode_booking' => 'MUA-XXXXX']))
        ->assertNotFound();
});