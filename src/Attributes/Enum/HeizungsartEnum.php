<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum HeizungsartEnum: string
{
    case NACHTSPEICHER = 'nachtspeicherheizung';
    case BLOCK = 'block';
    case KEINE_ANGABE = 'keineAngabe';
    case ETAGE = 'etage';
    case OFEN = 'ofen';
    case ZENTRAL = 'zentral';
    case FUSSBODEN = 'fussboden';
    case FERN = 'fern';
    case WAERMEPUPE = 'waermepumpe';
    case GAS = 'gas';
    case ZENTRAL_OEL = 'zentral_oel';
    case ELECTRIC = 'electricHeating';
    case WOOD_PELLET = 'woodPelletHeating';
    case SOLAR = 'solarHeating';

    public function label(): string
    {
        return match ($this) {
            self::NACHTSPEICHER => 'Nachtspeicherheizung',
            self::BLOCK => 'Blockheizkraftwerk',
            self::KEINE_ANGABE => 'keine Angabe',
            self::ETAGE => 'Etagenheizung',
            self::OFEN => 'Ofenheizung',
            self::ZENTRAL => 'Zentralheizung',
            self::FUSSBODEN => 'Fußbodenheizung',
            self::FERN => 'Fernwärme',
            self::WAERMEPUPE => 'Wärmepumpe',
            self::GAS => 'Gasheizung',
            self::ZENTRAL_OEL => 'Zentralheizung (Öl)',
            self::ELECTRIC => 'Elektro-Heizung',
            self::WOOD_PELLET => 'Holz-Pelletheizung',
            self::SOLAR => 'Solar-Heizung',
        };
    }
}
