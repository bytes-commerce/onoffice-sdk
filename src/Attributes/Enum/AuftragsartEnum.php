<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum AuftragsartEnum: string
{
    case EXKLUSIV = 'exklusiv';
    case NORMAL = 'normal';
    case MUENDLICHER_AUFTRAG = 'muendlicher_auftrag_imp';
    case KEIN_AUFTRAG = 'kein_auftrag';
    case GEM_GESCHAEFT = 'gem_geschaeft_imp';
    case EIGENOBJekt = 'eigenobjekt_imp';
    case ALLG_ERMITTLUNGSAUFTRAG = 'allg_ermittlungsauftrag_imp';
    case QUALIFIZIERTER_ALLEINAUFTRAG = 'qualifizierter_alleinauftrag_imp';
    case ALLEINAUFTRAG = 'alleinauftrag_imp';

    public function label(): string
    {
        return match ($this) {
            self::EXKLUSIV => 'Exklusiv',
            self::NORMAL => 'Normal',
            self::MUENDLICHER_AUFTRAG => 'Mündlicher Auftrag',
            self::KEIN_AUFTRAG => 'Kein Auftrag',
            self::GEM_GESCHAEFT => 'gem. Geschäft',
            self::EIGENOBJekt => 'Eigenobjekt',
            self::ALLG_ERMITTLUNGSAUFTRAG => 'Allg. Ermittlungsauftrag',
            self::QUALIFIZIERTER_ALLEINAUFTRAG => 'Qualifizierter Alleinauftrag',
            self::ALLEINAUFTRAG => 'Alleinauftrag',
        };
    }
}
