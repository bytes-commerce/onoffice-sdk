<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\VermarktungsartEnum;

final readonly class VermarktungsartAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'vermarktungsart',
            label: 'Vermarktungsart',
            type: 'singleselect',
            tablename: 'ObjKategorie',
            content: 'Kategorie',
        );
    }

    public function getEnumClass(): string
    {
        return VermarktungsartEnum::class;
    }
}
