<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\EnergyClassEnum;

final readonly class EnergyClassAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'energyClass',
            label: 'Energieeffizienzklasse',
            type: 'singleselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return EnergyClassEnum::class;
    }
}
