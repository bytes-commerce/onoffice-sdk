<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AusstattBeschrAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ausstatt_beschr',
            label: 'Ausstattung',
            type: 'text',
            tablename: 'ObjFreitexte',
            content: 'Freitexte',
        );
    }
}
