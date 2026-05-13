<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class GrzAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'grz',
            label: 'GRZ',
            type: 'varchar',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
            length: 80,
        );
    }
}
