<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MieteinnahmenProMonatAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'mieteinnahmen_pro_monat',
            label: 'Mieteinnahmen pro Monat',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
