<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class BaujahrAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'baujahr',
            label: 'Baujahr',
            type: 'integer',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
