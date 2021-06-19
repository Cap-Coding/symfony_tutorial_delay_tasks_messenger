<?php

declare(strict_types=1);

namespace App\Dto\Transformer\Request;

use App\Dto\Transformer\AbstractDtoTransformer;
use App\Entity\Reservation;

class ReservationRequestDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param Reservation $reservation
     *
     * @return array
     */
    public function transformFromObject($reservation): array
    {
        return [
            'name' => $reservation->getName(),
            'price' => $reservation->getPrice(),
        ];
    }
}