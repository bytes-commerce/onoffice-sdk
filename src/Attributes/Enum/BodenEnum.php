<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum BodenEnum: string
{
    case BETON = 'beton';
    case DIELEN = 'dielen';
    case DOPPELBODEN = 'doppelboden';
    case EPOXIDHARZBODEN = 'epoxidharzboden';
    case ESTRICH = 'estrich';
    case FERTIGPARKETT = 'fertigparkett';
    case FLIESEN = 'fliesen';
    case LAMINAT = 'laminat';
    case MARMOR = 'marmor';
    case NACH_MIETERWUNSCH = 'nach_mieterwunsch';
    case PARKETT = 'parkett';
    case PVC = 'pvc';
    case STEIN = 'stein';
    case TEPPICHBODEN = 'teppichboden';
    case TERRKOTTA = 'terrakotta';

    public function label(): string
    {
        return match ($this) {
            self::BETON => 'Beton',
            self::DIELEN => 'Dielen',
            self::DOPPELBODEN => 'Doppelboden',
            self::EPOXIDHARZBODEN => 'Epoxidharzboden',
            self::ESTRICH => 'Estrich',
            self::FERTIGPARKETT => 'Fertigparkett',
            self::FLIESEN => 'Fliesen',
            self::LAMINAT => 'Laminat',
            self::MARMOR => 'Marmor',
            self::NACH_MIETERWUNSCH => 'Nach Mieterwunsch',
            self::PARKETT => 'Parkett',
            self::PVC => 'PVC',
            self::STEIN => 'Stein',
            self::TEPPICHBODEN => 'Teppichboden',
            self::TERRKOTTA => 'Terrakotta',
        };
    }
}
