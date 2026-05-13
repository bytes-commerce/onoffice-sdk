<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\EnergietraegerEnum;

final readonly class EnergietraegerAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'energietraeger',
            label: 'wesentlicher Energieträger',
            type: 'singleselect',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }

    public function getEnumClass(): string
    {
        return EnergietraegerEnum::class;
    }
}
