<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum BebaubarMitEnum: string
{
    case ACKERLAND = 'ackerland';
    case BAUERWARTUNGSLAND = 'bauerwartungsland';
    case BOOTSTAENDE = 'bootsstaende';
    case BUERO = 'buero';
    case CAMPING = 'camping';
    case DOPPELHAUS = 'doppelhaus';
    case EINFAMILIENHAUS = 'einfamilienhaus';
    case EINZELHANDELGROSS = 'einzelhandelgross';
    case EINZELHANDELKLEIN = 'einzelhandelklein';
    case GARAGEN = 'garagen';
    case GARTEN = 'garten';
    case GASTRONOMIE = 'gastronomie';
    case GEWERBE = 'gewerbe';
    case HOTEL = 'hotel';
    case INDUSTRIE = 'industrie';
    case KEINE_BEBauUNG = 'keinebebauung';
    case KLEINGEWERBE = 'kleingewerbe';
    case LAGER = 'lager';
    case MEHRFAMILIENHAUS = 'mehrfamilienhaus';
    case OBSTPFLANZUNG = 'obstpflanzung';
    case PARKHAUS = 'parkhaus';
    case PRODUKTION = 'produktion';
    case REIHENHAUS = 'reihenhaus';
    case STELLPLAETZE = 'stellplaetze';
    case VILLA = 'villa';
    case WALD = 'wald';

    public function label(): string
    {
        return match ($this) {
            self::ACKERLAND => 'Ackerland',
            self::BAUERWARTUNGSLAND => 'Bauerwartungsland',
            self::BOOTSTAENDE => 'Bootsstände',
            self::BUERO => 'Büro',
            self::CAMPING => 'Camping',
            self::DOPPELHAUS => 'Doppelhaus',
            self::EINFAMILIENHAUS => 'Einfamilienhaus',
            self::EINZELHANDELGROSS => 'Einzelhandel (groß)',
            self::EINZELHANDELKLEIN => 'Einzelhandel (klein)',
            self::GARAGEN => 'Garagen',
            self::GARTEN => 'Garten',
            self::GASTRONOMIE => 'Gastronomie',
            self::GEWERBE => 'Gewerbe',
            self::HOTEL => 'Hotel',
            self::INDUSTRIE => 'Industrie',
            self::KEINE_BEBauUNG => 'Keine Bebauung',
            self::KLEINGEWERBE => 'Kleingewerbe',
            self::LAGER => 'Lager',
            self::MEHRFAMILIENHAUS => 'Mehrfamilienhaus',
            self::OBSTPFLANZUNG => 'Obstpflanzung',
            self::PARKHAUS => 'Parkhaus',
            self::PRODUKTION => 'Produktion',
            self::REIHENHAUS => 'Reihenhaus',
            self::STELLPLAETZE => 'Stellplätze',
            self::VILLA => 'Villa',
            self::WALD => 'Wald',
        };
    }
}
