<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class NettokaltmieteAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'nettokaltmiete',
            label: 'Netto Kaltmiete',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
