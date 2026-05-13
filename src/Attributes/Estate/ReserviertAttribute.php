<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class ReserviertAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'reserviert',
            label: 'Reserviert',
            type: 'boolean',
            tablename: 'Objekt',
            content: 'Marketing',
        );
    }
}
