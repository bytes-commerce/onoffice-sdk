<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum ObjektartEnum: string
{
    case ZIMMER = 'zimmer';
    case HAUS = 'haus';
    case WOHNUNG = 'wohnung';
    case GRUNDSTUECK = 'grundstueck';
    case BUERO_PRAXEN = 'buero_praxen';
    case EINZELHANDEL = 'einzelhandel';
    case GASTRGEWERBE = 'gastgewerbe';
    case HALLEN_LAGER_PROD = 'hallen_lager_prod';
    case LAND_UND_FORSTWIRTSCHAFT = 'land_und_forstwirtschaft';
    case FREIZEITIMMOBILIEN_GEWERBLICH = 'freizeitimmbilien_gewerblich';
    case SONSTIGE = 'sonstige';
    case ZINSHAUS_RENDITE = 'zinshaus_renditeobjekt';

    public function label(): string
    {
        return match ($this) {
            self::ZIMMER => 'Zimmer',
            self::HAUS => 'Haus',
            self::WOHNUNG => 'Wohnung',
            self::GRUNDSTUECK => 'Grundstück',
            self::BUERO_PRAXEN => 'Büro/Praxen',
            self::EINZELHANDEL => 'Laden/Einzelhandel',
            self::GASTRGEWERBE => 'Gastgewerbe',
            self::HALLEN_LAGER_PROD => 'Hallen/Lager/Produktion',
            self::LAND_UND_FORSTWIRTSCHAFT => 'Land/Forstwirtschaft',
            self::FREIZEITIMMOBILIEN_GEWERBLICH => 'Freizeitimmobilie (gewerblich)',
            self::SONSTIGE => 'Sonstige',
            self::ZINSHAUS_RENDITE => 'Zins und Renditeobjekt',
        };
    }
}
