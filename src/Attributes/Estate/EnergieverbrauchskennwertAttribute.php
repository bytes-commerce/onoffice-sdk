<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EnergieverbrauchskennwertAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'energieverbrauchskennwert',
            label: 'Endenergieverbrauch',
            type: 'float',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
