<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class XFacheAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'x_fache',
            label: 'x fache (Ist)',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
