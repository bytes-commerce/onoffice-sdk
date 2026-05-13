<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class GastroflaecheAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'gastroflaeche',
            label: 'Gastrofläche',
            type: 'float',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
