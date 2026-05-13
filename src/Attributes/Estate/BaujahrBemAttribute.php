<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class BaujahrBemAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'baujahrBem',
            label: 'Bemerkung Baujahr',
            type: 'varchar',
            tablename: 'ObjZustand',
            content: 'Zustand',
            length: 80,
        );
    }
}
