<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\FahrstuhlEnum;

final readonly class FahrstuhlAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'fahrstuhl',
            label: 'Fahrstuhl',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return FahrstuhlEnum::class;
    }
}
