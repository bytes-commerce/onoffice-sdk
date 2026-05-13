<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum EnergyClassEnum: string
{
    case A = 'A';
    case A_PLUS = 'A+';
    case B = 'B';
    case C = 'C';
    case D = 'D';
    case E = 'E';
    case F = 'F';
    case G = 'G';
    case H = 'H';

    public function label(): string
    {
        return match ($this) {
            self::A => 'A',
            self::A_PLUS => 'A+',
            self::B => 'B',
            self::C => 'C',
            self::D => 'D',
            self::E => 'E',
            self::F => 'F',
            self::G => 'G',
            self::H => 'H',
        };
    }
}
