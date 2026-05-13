<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class ScoutRegionAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'scout_region',
            label: 'Scout Region',
            type: 'varchar',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
            length: 100,
        );
    }
}
