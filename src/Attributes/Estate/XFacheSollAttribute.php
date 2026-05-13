<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class XFacheSollAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'x_fache_soll',
            label: 'x fache (Soll)',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
