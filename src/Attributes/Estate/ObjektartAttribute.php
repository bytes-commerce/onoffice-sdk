<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ObjektartEnum;

final readonly class ObjektartAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'objektart',
            label: 'Objektart',
            type: 'singleselect',
            tablename: 'ObjKategorie',
            content: 'Kategorie',
        );
    }

    public function getEnumClass(): string
    {
        return ObjektartEnum::class;
    }
}
