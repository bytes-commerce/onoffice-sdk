<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\LandEnum;

final readonly class LandAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'land',
            label: 'Land',
            type: 'singleselect',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }

    public function getEnumClass(): string
    {
        return LandEnum::class;
    }
}
