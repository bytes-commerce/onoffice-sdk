<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AnzahlTerrassenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'anzahl_terrassen',
            label: 'Anzahl Terrassen',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
