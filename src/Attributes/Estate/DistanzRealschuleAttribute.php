<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class DistanzRealschuleAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'distanz_realschule',
            label: 'Dist. Realschule (km)',
            type: 'float',
            tablename: 'ObjInfra',
            content: 'Infrastruktur',
        );
    }
}
