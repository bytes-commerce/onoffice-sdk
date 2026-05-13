<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AnzahlTagungsraeumeAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'anzahl_tagungsraeume',
            label: 'Anzahl Tagungsräume',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
