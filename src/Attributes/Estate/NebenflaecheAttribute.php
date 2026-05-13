<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class NebenflaecheAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'nebenflaeche',
            label: 'Nebenfläche',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
