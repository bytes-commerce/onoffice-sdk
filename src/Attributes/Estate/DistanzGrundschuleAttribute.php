<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class DistanzGrundschuleAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'distanz_grundschule',
            label: 'Dist. Grundschule (km)',
            type: 'float',
            tablename: 'ObjInfra',
            content: 'Infrastruktur',
        );
    }
}
