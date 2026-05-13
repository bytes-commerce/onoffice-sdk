<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum AngeschlGastronomieEnum: string
{
    case BAR = 'bar';
    case HOTELRESTAURANT = 'hotelrestaurant';

    public function label(): string
    {
        return match ($this) {
            self::BAR => 'Bar',
            self::HOTELRESTAURANT => 'Hotel/Restaurant',
        };
    }
}
