<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum BebaubarNachEnum: string
{
    case AUSSENGEBIET = 'aussengebiet';
    case B_PLAN = 'b_plan';
    case BAUERWARTUNGSLAND = 'bauerwartungsland';
    case BAULAND_OHNE_B_PLAN = 'bauland_ohne_b_plan';
    case BEBAUUNGSPLAN = 'bebauungsplan';
    case KEIN_BAULAND = 'kein_bauland';
    case LAENDERSPECIFISCH = 'laenderspezifisch';
    case NACHBARBEBBAUUNG = 'nachbarbebauung';

    public function label(): string
    {
        return match ($this) {
            self::AUSSENGEBIET => 'Aussengebiet (§35BauGB)',
            self::B_PLAN => 'B Plan',
            self::BAUERWARTUNGSLAND => 'Bauerwartungsland',
            self::BAULAND_OHNE_B_PLAN => 'Bauland ohne B Plan',
            self::BEBAUUNGSPLAN => 'Bebauungsplan (§30BauGB)',
            self::KEIN_BAULAND => 'kein Bauland',
            self::LAENDERSPECIFISCH => 'länderspezifisch',
            self::NACHBARBEBBAUUNG => 'Nachbarbebauung (§34BauGB)',
        };
    }
}
