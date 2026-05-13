<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AdditionalHeaderAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'additionalHeader',
            label: 'Warnhinweis',
            type: 'varchar',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
            length: 255,
        );
    }
}
