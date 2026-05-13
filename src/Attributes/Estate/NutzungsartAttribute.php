<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\NutzungsartEnum;

final readonly class NutzungsartAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'nutzungsart',
            label: 'Nutzungsart',
            type: 'singleselect',
            tablename: 'ObjKategorie',
            content: 'Kategorie',
        );
    }

    public function getEnumClass(): string
    {
        return NutzungsartEnum::class;
    }
}
