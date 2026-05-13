<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AuftragbisAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'auftragbis',
            label: 'Auftrag bis',
            type: 'date',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
