<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class Ind2394FeldObjZusatz6Attribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ind_2394_Feld_ObjZusatz6',
            label: 'Notartermin',
            type: 'date',
            tablename: 'ObjZusatz',
            content: 'Notardaten',
        );
    }
}
