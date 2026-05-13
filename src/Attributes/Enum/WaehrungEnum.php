<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum WaehrungEnum: string
{
    case EUR = 'EUR';

    public function label(): string
    {
        return match ($this) {
            self::EUR => '€',
        };
    }
}
