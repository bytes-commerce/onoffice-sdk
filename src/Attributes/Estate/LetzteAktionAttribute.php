<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class LetzteAktionAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'letzte_aktion',
            label: 'Letzte Aktion',
            type: 'date',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
