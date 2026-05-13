<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\BebaubarNachEnum;

final readonly class BebaubarNachAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'bebaubar_nach',
            label: 'Bebaubar nach',
            type: 'singleselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return BebaubarNachEnum::class;
    }
}
