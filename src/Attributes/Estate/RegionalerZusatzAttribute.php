<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class RegionalerZusatzAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'regionaler_zusatz',
            label: 'Regionaler Zusatz',
            type: 'multiselect',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }
}
