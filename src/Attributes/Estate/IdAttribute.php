<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class IdAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'Id',
            label: 'Datensatznr',
            type: 'integer',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
