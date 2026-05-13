<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum BaustilImpEnum: string
{
    case KONVENTIONELL = 'ind_Schl_3011';
    case HISTORISCH = 'ind_Schl_3009';
    case MODERN = 'ind_Schl_3007';

    public function label(): string
    {
        return match ($this) {
            self::KONVENTIONELL => 'konventionell',
            self::HISTORISCH => 'historisch',
            self::MODERN => 'modern',
        };
    }
}
