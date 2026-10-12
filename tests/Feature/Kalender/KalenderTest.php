<?php


test('data kalender publik tidak membocorkan nama pelanggan', function () {
    buatBooking();

    $response = $this->getJson(route('kalender.data', ['year' => now()->year, 'month' => now()->month]));

    $response->assertOk();
    expect($response->json('events.0'))->not->toHaveKey('nama_pelanggan');
});