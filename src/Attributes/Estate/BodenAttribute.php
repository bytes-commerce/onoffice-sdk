<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\BodenEnum;

final readonly class BodenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'boden',
            label: 'Boden',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return BodenEnum::class;
    }
}
