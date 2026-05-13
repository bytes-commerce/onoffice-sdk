<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class LaengengradAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'laengengrad',
            label: 'Längengrad',
            type: 'float',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }
}
