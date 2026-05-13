<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EndenergiebedarfAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'endenergiebedarf',
            label: 'Endenergiebedarf',
            type: 'float',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
