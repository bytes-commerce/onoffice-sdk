<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class Ind2392FeldObjZusatz5Attribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ind_2392_Feld_ObjZusatz5',
            label: 'Notar',
            type: 'varchar',
            tablename: 'ObjZusatz',
            content: 'Notardaten',
            length: 80,
        );
    }
}
