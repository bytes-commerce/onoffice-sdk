<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum FensterEnum: string
{
    case KUNSTSTOFF_ISO = 'indMulti2310Select5708';
    case HOLZ_ISO = 'indMulti2310Select5706';
    case VERSCHIEDENE = 'indMulti2310Select5702';
    case SPROSSEN = 'indMulti2310Select5700';
    case HOLZ_FENSTER = 'indMulti2310Select5698';
    case KUNSTSTOFF_FENSTER = 'indMulti2310Select5696';
    case ALUMINIUM = 'indMulti2310Select5694';

    public function label(): string
    {
        return match ($this) {
            self::KUNSTSTOFF_ISO => 'Kunststoff-Iso-Fenster',
            self::HOLZ_ISO => 'Holz-Iso-Fenster',
            self::VERSCHIEDENE => 'Verschiedene Fensterarten',
            self::SPROSSEN => 'Sprossenfenster',
            self::HOLZ_FENSTER => 'Holzfenster',
            self::KUNSTSTOFF_FENSTER => 'Kunststofffenster',
            self::ALUMINIUM => 'Aluminiumfenster',
        };
    }
}
