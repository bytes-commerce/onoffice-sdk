<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum HaustiereEnum: string
{
    case JA = '1';
    case NEIN = '0';
    case NACH_VEREINBARUNG = '2';

    public function label(): string
    {
        return match ($this) {
            self::JA => 'Ja',
            self::NEIN => 'Nein',
            self::NACH_VEREINBARUNG => 'nach Vereinbarung',
        };
    }
}
