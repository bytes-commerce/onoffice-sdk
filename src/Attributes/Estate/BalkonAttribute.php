<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class BalkonAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'balkon',
            label: 'Balkon',
            type: 'boolean',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }
}
