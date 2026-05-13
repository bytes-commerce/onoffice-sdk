<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class HeizkostenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'heizkosten',
            label: 'Heizkosten',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
