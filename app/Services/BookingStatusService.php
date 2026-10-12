<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Exceptions\TransisiStatusTidakValidException;
use App\Models\Booking;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\DB;

class BookingStatusService
{
    public function ubah(Booking $booking, BookingStatus $tujuan): void
    {
        $asal = $booking->status_booking;

        if (! $asal->bisaBerubahKe($tujuan)) {
            throw TransisiStatusTidakValidException::dari($asal, $tujuan);
        }
    

        DB::transaction(function () use ($booking, $tujuan) {
            $booking->update(['status_booking'  => $tujuan]);

            if ($tujuan === BookingStatus::Selesai){
                $booking->bukaTestimoni();
            }

            Notifikasi::create([
                'pesan' => sprintf(
                    'Booking %s (%s) berstatus "%s".',
                    $booking->kode_booking,
                    $booking->nama_pelanggan,
                    $tujuan->label(),
                ),
            ]);
        });
    }
}