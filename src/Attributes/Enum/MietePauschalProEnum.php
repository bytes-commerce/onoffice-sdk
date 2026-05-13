<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum MietePauschalProEnum: string
{
    case TAG = 'T';
    case WOCHE = 'W';
    case MONAT = 'M';

    public function label(): string
    {
        return match ($this) {
            self::TAG => 'Tag',
            self::WOCHE => 'Woche',
            self::MONAT => 'Monat',
        };
    }
}
