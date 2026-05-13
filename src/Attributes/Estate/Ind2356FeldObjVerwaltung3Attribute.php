<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class Ind2356FeldObjVerwaltung3Attribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ind_2356_Feld_ObjVerwaltung3',
            label: 'Link zur virtuellen Besichtigung',
            type: 'text',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
