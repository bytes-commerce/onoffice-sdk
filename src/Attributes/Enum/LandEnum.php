<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum LandEnum: string
{
    case AUT = 'AUT';
    case BEL = 'BEL';
    case DEU = 'DEU';
    case FRA = 'FRA';
    case HUN = 'HUN';

    public function label(): string
    {
        return match ($this) {
            self::AUT => 'Österreich',
            self::BEL => 'Belgien',
            self::DEU => 'Deutschland',
            self::FRA => 'Frankreich',
            self::HUN => 'Ungarn (Rep.)',
        };
    }
}
