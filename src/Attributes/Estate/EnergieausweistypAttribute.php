<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\EnergieausweistypEnum;

final readonly class EnergieausweistypAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'energieausweistyp',
            label: 'Energieausweis',
            type: 'singleselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return EnergieausweistypEnum::class;
    }
}
