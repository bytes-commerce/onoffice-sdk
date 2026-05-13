<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class InnenCourtageAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'innen_courtage',
            label: 'Innen-Provision',
            type: 'text',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
