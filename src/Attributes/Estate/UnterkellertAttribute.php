<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\UnterkellertEnum;

final readonly class UnterkellertAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'unterkellert',
            label: 'Unterkellert',
            type: 'singleselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return UnterkellertEnum::class;
    }
}
