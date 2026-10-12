<?php

namespace App\Exceptions;

use DomainException;

class BookingTidakDapatDibuatException extends DomainException
{
    private function __construct(string $message, public readonly string $field)
    {
        parent::__construct($message);
    }

    public static function paketTidakTersedia(): self
    {
        return new self('paket ini sudah tidak tersedia.', 'pricelist_id');
    }

    public static function jadwalBentrok(): self
    {
        return new self('jadwal tersebut sudah terisi. Silahkan pilih tanggal atau waktu lainya.', 'waktu_acara');
    }

}