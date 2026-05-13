<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EtageAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'etage',
            label: 'Etage',
            type: 'integer',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }
}
