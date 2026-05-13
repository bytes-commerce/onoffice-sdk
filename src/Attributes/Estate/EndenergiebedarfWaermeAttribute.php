<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EndenergiebedarfWaermeAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'endenergiebedarfWaerme',
            label: 'Endenergiebedarf (Wärme)',
            type: 'float',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
