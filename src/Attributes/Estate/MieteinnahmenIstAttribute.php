<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MieteinnahmenIstAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'mieteinnahmen_ist',
            label: 'mtl. Mieteinnahmen (Ist)',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
