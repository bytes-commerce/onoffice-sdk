<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class DistanzAutobahnAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'distanz_autobahn',
            label: 'Dist. Autobahn (km)',
            type: 'float',
            tablename: 'ObjInfra',
            content: 'Infrastruktur',
        );
    }
}
