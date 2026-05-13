<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class VerkauftAmAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'verkauft_am',
            label: 'Verkauft am',
            type: 'date',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
