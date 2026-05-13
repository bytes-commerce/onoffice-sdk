<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class TeilbarAbAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'teilbar_ab',
            label: 'teilbar ab',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
