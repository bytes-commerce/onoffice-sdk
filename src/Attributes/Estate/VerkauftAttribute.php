<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class VerkauftAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'verkauft',
            label: 'Verkauft',
            type: 'boolean',
            tablename: 'Objekt',
            content: 'Marketing',
        );
    }
}
