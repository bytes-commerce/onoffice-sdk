<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class GeaendertAmAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'geaendert_am',
            label: 'Geändert am',
            type: 'datetime',
            tablename: 'Objekt',
            content: 'Allgemein',
        );
    }
}
