<?php

declare(strict_types=1);

namespace App\Messenger;

class ReservationMessage
{
    private int $reservationId;

    public function __construct(int $reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function getReservationId(): int
    {
        return $this->reservationId;
    }
}