<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class Ind2388FeldObjZusatz4Attribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ind_2388_Feld_ObjZusatz4',
            label: 'beurkundeter Kaufpreis',
            type: 'float',
            tablename: 'ObjZusatz',
            content: 'Notardaten',
        );
    }
}
