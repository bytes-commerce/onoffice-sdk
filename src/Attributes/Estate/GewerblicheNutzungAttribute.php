<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class GewerblicheNutzungAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'gewerbliche_nutzung',
            label: 'Gewerbliche Nutzung',
            type: 'boolean',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
