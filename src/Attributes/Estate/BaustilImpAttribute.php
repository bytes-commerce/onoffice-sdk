<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\BaustilImpEnum;

final readonly class BaustilImpAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'baustil_imp',
            label: 'Baustil',
            type: 'singleselect',
            tablename: 'ObjKategorie',
            content: 'Kategorie',
        );
    }

    public function getEnumClass(): string
    {
        return BaustilImpEnum::class;
    }
}
