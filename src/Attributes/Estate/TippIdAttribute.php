<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class TippIdAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'Tipp_ID',
            label: 'Tippgeber',
            type: 'integer',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
