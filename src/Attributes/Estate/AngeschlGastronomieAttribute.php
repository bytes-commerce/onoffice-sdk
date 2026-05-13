<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\AngeschlGastronomieEnum;

final readonly class AngeschlGastronomieAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'angeschl_gastronomie',
            label: 'Angeschl. Gastronomie',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return AngeschlGastronomieEnum::class;
    }
}
