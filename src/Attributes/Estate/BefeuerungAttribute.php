<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\BefeuerungEnum;

final readonly class BefeuerungAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'befeuerung',
            label: 'Befeuerung',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return BefeuerungEnum::class;
    }
}
