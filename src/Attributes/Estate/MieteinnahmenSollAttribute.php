<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MieteinnahmenSollAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'mieteinnahmen_soll',
            label: 'mtl. Mieteinnahmen (Soll)',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
