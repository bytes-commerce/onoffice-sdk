<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum ErschliessungEnum: string
{
    case ERSCHLOSSEN = 'erschlossen';
    case TEILERSCHLOSSEN = 'teilerschlossen';
    case UNERSCHLOSSEN = 'unerschlossen';

    public function label(): string
    {
        return match ($this) {
            self::ERSCHLOSSEN => 'Erschlossen',
            self::TEILERSCHLOSSEN => 'Teilerschlossen',
            self::UNERSCHLOSSEN => 'Unerschlossen',
        };
    }
}
