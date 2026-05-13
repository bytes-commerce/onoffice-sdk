<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class DenkmalgeschuetztAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'denkmalgeschuetzt',
            label: 'Denkmalgeschützt',
            type: 'boolean',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
