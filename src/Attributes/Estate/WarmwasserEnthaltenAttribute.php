<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class WarmwasserEnthaltenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'warmwasserEnthalten',
            label: 'Warmwasser enthalten',
            type: 'boolean',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
