<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\MietePauschalProEnum;

final readonly class MietePauschalProAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'miete_pauschal_pro',
            label: 'Pauschalmiete pro',
            type: 'singleselect',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }

    public function getEnumClass(): string
    {
        return MietePauschalProEnum::class;
    }
}
