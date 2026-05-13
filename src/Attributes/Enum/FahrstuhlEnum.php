<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum FahrstuhlEnum: string
{
    case PERSONEN = 'personen';
    case LASTEN = 'lasten';
    case KEIN = 'kein_fahrstuhl';

    public function label(): string
    {
        return match ($this) {
            self::PERSONEN => 'Personenaufzug',
            self::LASTEN => 'Lastenfahrstuhl',
            self::KEIN => 'Kein Fahrstuhl',
        };
    }
}
