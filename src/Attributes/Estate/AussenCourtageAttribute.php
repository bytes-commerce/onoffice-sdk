<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AussenCourtageAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'aussen_courtage',
            label: 'Außen-Provision',
            type: 'text',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
