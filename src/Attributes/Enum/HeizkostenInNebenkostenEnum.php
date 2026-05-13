<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum HeizkostenInNebenkostenEnum: string
{
    case JA = 'J';
    case NEIN = 'N';

    public function label(): string
    {
        return match ($this) {
            self::JA => 'Ja',
            self::NEIN => 'Nein',
        };
    }
}
