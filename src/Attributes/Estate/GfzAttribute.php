<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class GfzAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'gfz',
            label: 'GFZ',
            type: 'varchar',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
            length: 80,
        );
    }
}
