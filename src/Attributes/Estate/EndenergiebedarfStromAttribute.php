<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EndenergiebedarfStromAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'endenergiebedarfStrom',
            label: 'Endenergiebedarf (Strom)',
            type: 'float',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
