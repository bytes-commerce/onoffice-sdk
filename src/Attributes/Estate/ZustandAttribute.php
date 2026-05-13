<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ZustandEnum;

final readonly class ZustandAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'zustand',
            label: 'Zustand',
            type: 'singleselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return ZustandEnum::class;
    }
}
