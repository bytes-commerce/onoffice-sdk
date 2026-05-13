<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\InternetAccessTypeEnum;

final readonly class InternetAccessTypeAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'internetAccessType',
            label: 'Internetanschluss',
            type: 'multiselect',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }

    public function getEnumClass(): string
    {
        return InternetAccessTypeEnum::class;
    }
}
