<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum ProvisionsAbgabeInnenEnum: string
{
    case P0 = '0';
    case P5 = '5';
    case P10 = '10';
    case P15 = '15';
    case P20 = '20';
    case P25 = '25';
    case P30 = '30';
    case P35 = '35';
    case P40 = '40';
    case P45 = '45';
    case P50 = '50';
    case P55 = '55';
    case P60 = '60';
    case P65 = '65';
    case P70 = '70';
    case P75 = '75';
    case P80 = '80';
    case P85 = '85';
    case P90 = '90';
    case P95 = '95';
    case P100 = '100';

    public function label(): string
    {
        return match ($this) {
            self::P0 => '0%',
            self::P5 => '5%',
            self::P10 => '10%',
            self::P15 => '15%',
            self::P20 => '20%',
            self::P25 => '25%',
            self::P30 => '30%',
            self::P35 => '35%',
            self::P40 => '40%',
            self::P45 => '45%',
            self::P50 => '50%',
            self::P55 => '55%',
            self::P60 => '60%',
            self::P65 => '65%',
            self::P70 => '70%',
            self::P75 => '75%',
            self::P80 => '80%',
            self::P85 => '85%',
            self::P90 => '90%',
            self::P95 => '95%',
            self::P100 => '100%',
        };
    }
}
