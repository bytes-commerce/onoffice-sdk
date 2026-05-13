<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class BenutzerAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'benutzer',
            label: 'Betreuer',
            type: 'user',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
