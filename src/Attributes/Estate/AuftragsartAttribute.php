<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\AuftragsartEnum;

final readonly class AuftragsartAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'auftragsart',
            label: 'Auftragsart',
            type: 'singleselect',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }

    public function getEnumClass(): string
    {
        return AuftragsartEnum::class;
    }
}
