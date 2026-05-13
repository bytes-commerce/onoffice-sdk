<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\HeizkostenInNebenkostenEnum;

final readonly class HeizkostenInNebenkostenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'heizkosten_in_nebenkosten',
            label: 'Heizkosten in Nebenkosten enthalten',
            type: 'singleselect',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }

    public function getEnumClass(): string
    {
        return HeizkostenInNebenkostenEnum::class;
    }
}
