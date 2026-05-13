<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\HeizungsartEnum;

final readonly class HeizungsartAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'heizungsart',
            label: 'Heizungsart',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return HeizungsartEnum::class;
    }
}
