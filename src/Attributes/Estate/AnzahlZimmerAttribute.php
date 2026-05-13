<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AnzahlZimmerAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'anzahl_zimmer',
            label: 'Anzahl Zimmer',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
