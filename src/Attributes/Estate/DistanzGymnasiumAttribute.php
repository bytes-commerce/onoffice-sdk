<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class DistanzGymnasiumAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'distanz_gymnasium',
            label: 'Dist. Gymnasium (km)',
            type: 'float',
            tablename: 'ObjInfra',
            content: 'Infrastruktur',
        );
    }
}
