<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class PachtAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'pacht',
            label: 'Pacht',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
