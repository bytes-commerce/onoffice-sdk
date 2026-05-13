<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class KabelSatTvAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'kabel_sat_tv',
            label: 'Kabel Sat TV',
            type: 'boolean',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }
}
