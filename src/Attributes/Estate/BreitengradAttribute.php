<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class BreitengradAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'breitengrad',
            label: 'Breitengrad',
            type: 'float',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }
}
