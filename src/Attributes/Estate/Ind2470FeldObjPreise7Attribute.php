<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class Ind2470FeldObjPreise7Attribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ind_2470_Feld_ObjPreise7',
            label: 'beurkundeter Kaufpreis',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
