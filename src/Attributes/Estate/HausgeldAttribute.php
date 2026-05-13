<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class HausgeldAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'hausgeld',
            label: 'Hausgeld',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
