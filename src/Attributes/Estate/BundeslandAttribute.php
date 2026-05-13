<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\BundeslandEnum;

final readonly class BundeslandAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'bundesland',
            label: 'Bundesland',
            type: 'singleselect',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }

    public function getEnumClass(): string
    {
        return BundeslandEnum::class;
    }
}
