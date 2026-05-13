<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class ErstelltAmAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'erstellt_am',
            label: 'erstellt am',
            type: 'date',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
