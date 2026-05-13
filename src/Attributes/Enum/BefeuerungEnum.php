<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum BefeuerungEnum: string
{
    case ALTERNATIV = 'alternativ';
    case ELEKTRO = 'elektro';
    case ERDWAERME = 'erdwaerme';
    case FERNWAERME = 'fernwaerme';
    case GAS = 'gas';
    case HOLZ = 'holz';
    case LUFTWP = 'luftwp';
    case OEL = 'oel';
    case PELLET = 'pellet';
    case SOLAR = 'solar';

    public function label(): string
    {
        return match ($this) {
            self::ALTERNATIV => 'Alternativ',
            self::ELEKTRO => 'Elektro',
            self::ERDWAERME => 'Erdwärme',
            self::FERNWAERME => 'Fernwärme',
            self::GAS => 'Gas',
            self::HOLZ => 'Holz',
            self::LUFTWP => 'Luft/Wasser Wärmepumpe',
            self::OEL => 'Öl',
            self::PELLET => 'Pellet',
            self::SOLAR => 'Solar',
        };
    }
}
