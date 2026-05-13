<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EnergieausweisBaujahrAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'energieausweisBaujahr',
            label: 'Baujahr lt. Energieausweis',
            type: 'integer',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
