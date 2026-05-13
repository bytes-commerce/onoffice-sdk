<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum NutzungsartEnum: string
{
    case WOHNEN = 'wohnen';
    case GEWERBE = 'gewerbe';
    case ANLAGE = 'anlage';
    case WAZ = 'waz';

    public function label(): string
    {
        return match ($this) {
            self::WOHNEN => 'Wohnen',
            self::GEWERBE => 'Gewerbe',
            self::ANLAGE => 'Anlage',
            self::WAZ => 'WAZ (Wohnen auf Zeit)',
        };
    }
}
