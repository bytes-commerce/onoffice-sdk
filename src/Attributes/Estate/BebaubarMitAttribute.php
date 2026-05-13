<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\BebaubarMitEnum;

final readonly class BebaubarMitAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'bebaubar_mit',
            label: 'Bebaubar mit',
            type: 'multiselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return BebaubarMitEnum::class;
    }
}
