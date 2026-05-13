<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ErschliessungEnum;

final readonly class ErschliessungAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'erschliessung',
            label: 'Erschliessung',
            type: 'singleselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return ErschliessungEnum::class;
    }
}
