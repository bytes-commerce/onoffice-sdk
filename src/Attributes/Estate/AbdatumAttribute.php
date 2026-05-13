<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AbdatumAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'abdatum',
            label: 'verfügbar ab (Datum)',
            type: 'date',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
