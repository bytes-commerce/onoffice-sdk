<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\FensterEnum;

final readonly class FensterAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'fenster',
            label: 'Fenster',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return FensterEnum::class;
    }
}
