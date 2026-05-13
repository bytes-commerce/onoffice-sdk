<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ZzglMehrwertsteuerEnum;

final readonly class ZzglMehrwertsteuerAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'zzgl_mehrwertsteuer',
            label: 'zzgl. MwSt. auf Provision',
            type: 'singleselect',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }

    public function getEnumClass(): string
    {
        return ZzglMehrwertsteuerEnum::class;
    }
}
