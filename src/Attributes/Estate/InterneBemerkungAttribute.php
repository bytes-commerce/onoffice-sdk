<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class InterneBemerkungAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'InterneBemerkung',
            label: 'Diese Bemerkung wird nicht veröffentlicht',
            type: 'text',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
