<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum VermarktungsartEnum: string
{
    case KAUF = 'kauf';
    case MIETE = 'miete';
    case PACHT = 'pacht';
    case ERBPACHT = 'erbpacht';

    public function label(): string
    {
        return match ($this) {
            self::KAUF => 'Kauf',
            self::MIETE => 'Miete',
            self::PACHT => 'Pacht',
            self::ERBPACHT => 'Erbpacht',
        };
    }
}
