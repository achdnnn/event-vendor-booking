<?php

namespace App\Services;

use App\Exceptions\BookingTidakDapatDibuatException;
use App\Models\Booking;
use App\Enums\BookingStatus;
use App\Models\Notifikasi;
use App\Models\Pricelist;
use Illuminate\Support\Facades\DB;


class BookingService
{

    public function buat(array $data): Booking
    {
        return DB::transaction(function () use ($data) {
            $pricelist = Pricelist::with('layanan')->findOrFail($data['pricelist_id']); 
            
            $this->pastikanPaketTersedia($pricelist);
            $this->pastikanJadwalKosong($data['tanggal_acara'], $data['waktu_acara']);

            $booking = Booking::create([
                ...$data,
                'status_booking'=> BookingStatus::Pending,
                'total_harga'   => $pricelist->harga,
                'dp'            => $pricelist->hitungDp(),
            ]);

            Notifikasi::create([
                'pesan' => "{$booking->nama_pelanggan} membuat booking {$pricelist->nama_pricelist} ({$booking->kode_booking}).", 
            ]);
            return $booking;

        });
    }


    private function pastikanPaketTersedia(Pricelist $pricelist): void
    {
        if (! $pricelist->isTersedia()) {
            throw BookingTidakDapatDibuatException::paketTidakTersedia();
        }
    }

    private function pastikanJadwalKosong(string $tanggal, string $waktu): void
    {
        $bentrok = Booking::menempatiJadwal()
            ->padaJadwal($tanggal, $waktu)
            ->exists();

        if ($bentrok) {
            throw BookingTidakDapatDibuatException::jadwalBentrok();
        }
    }
}
