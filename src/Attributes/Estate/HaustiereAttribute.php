<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\HaustiereEnum;

final readonly class HaustiereAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'haustiere',
            label: 'Haustiere',
            type: 'singleselect',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }

    public function getEnumClass(): string
    {
        return HaustiereEnum::class;
    }
}
