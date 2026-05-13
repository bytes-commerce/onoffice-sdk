<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class WohnflaecheAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'wohnflaeche',
            label: 'Wohnfläche',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
