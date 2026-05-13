<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class LagerflaecheAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'lagerflaeche',
            label: 'Lagerfläche',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
