<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ObjekttypEnum;

final readonly class ObjekttypAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'objekttyp',
            label: 'Objekttyp',
            type: 'singleselect',
            tablename: 'ObjKategorie',
            content: 'Kategorie',
        );
    }

    public function getEnumClass(): string
    {
        return ObjekttypEnum::class;
    }
}
