<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum ZzglMehrwertsteuerEnum: string
{
    case JA = '1';
    case NEIN = '0';

    public function label(): string
    {
        return match ($this) {
            self::JA => 'Ja',
            self::NEIN => 'Nein',
        };
    }
}
