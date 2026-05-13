<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum UnterkellertEnum: string
{
    case JA = 'JA';
    case NEIN = 'NEIN';
    case TEIL = 'TEIL';

    public function label(): string
    {
        return match ($this) {
            self::JA => 'Ja',
            self::NEIN => 'Nein',
            self::TEIL => 'Teil',
        };
    }
}
