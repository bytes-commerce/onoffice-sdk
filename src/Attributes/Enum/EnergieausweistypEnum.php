<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum EnergieausweistypEnum: string
{
    case ENDENERGIEBEDARF = 'Endenergiebedarf';
    case ENERGIEVERBRAUSCHSKENNWERT = 'Energieverbrauchskennwert';
    case BEDARFSAUSWEIS_GEWERBE = 'Bedarfsausweis Gewerbe';
    case VERBRAUCHSAUSWEIS_GEWERBE = 'Verbrauchsausweis Gewerbe';
    case KEINE_PFLICHT = 'es besteht keine Pflicht!';
    case OHNE = 'ohne Energieausweis';

    public function label(): string
    {
        return match ($this) {
            self::ENDENERGIEBEDARF => 'Bedarfsausweis',
            self::ENERGIEVERBRAUSCHSKENNWERT => 'Verbrauchsausweis',
            self::BEDARFSAUSWEIS_GEWERBE => 'Bedarfsausweis Gewerbe',
            self::VERBRAUCHSAUSWEIS_GEWERBE => 'Verbrauchsausweis Gewerbe',
            self::KEINE_PFLICHT => 'es besteht keine Pflicht!',
            self::OHNE => 'ohne Energieausweis',
        };
    }
}
