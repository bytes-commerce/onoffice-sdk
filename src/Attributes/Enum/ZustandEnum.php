<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum ZustandEnum: string
{
    case ABRISOBJEKT = 'abrissobjekt';
    case BAUFAELLIG = 'baufaellig';
    case ENTKERN = 'entkernt';
    case PROJEKTIERT = 'projektiert';
    case NEUWERTIG = 'neuwertig';
    case VOLLSTAENDIG_RENOVIERT = 'vollstaendig_renoviert';
    case RENOVIERUNGSBEDUERFTIG = 'renovierungsbeduerftig';
    case MODERNISIERT = 'modernisiert';
    case ROHBAU = 'rohbau';
    case ERSTBEZUG = 'erstbezug';
    case GEPFLEGT = 'gepflegt';
    case SANIERT = 'saniert';
    case NACH_VEREINBARUNG = 'nach_vereinbarung';
    case ERSTBEZUG_NACH_SANIERUNG = 'erstbezug_nach_sanierung';

    public function label(): string
    {
        return match ($this) {
            self::ABRISOBJEKT => 'Abrissobjekt',
            self::BAUFAELLIG => 'baufällig',
            self::ENTKERN => 'entkernt',
            self::PROJEKTIERT => 'projektiert',
            self::NEUWERTIG => 'Neuwertig',
            self::VOLLSTAENDIG_RENOVIERT => 'Vollständig renoviert',
            self::RENOVIERUNGSBEDUERFTIG => 'Renovierungsbedürftig',
            self::MODERNISIERT => 'Modernisiert',
            self::ROHBAU => 'Rohbau',
            self::ERSTBEZUG => 'Erstbezug',
            self::GEPFLEGT => 'Gepflegt',
            self::SANIERT => 'Saniert',
            self::NACH_VEREINBARUNG => 'Nach Vereinbarung',
            self::ERSTBEZUG_NACH_SANIERUNG => 'Erstbezug nach Sanierung',
        };
    }
}
