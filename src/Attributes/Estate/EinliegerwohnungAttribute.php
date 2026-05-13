<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EinliegerwohnungAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'einliegerwohnung',
            label: 'Einliegerwohnung',
            type: 'boolean',
            tablename: 'ObjFlaeche',
            content: 'Flächen',
        );
    }
}
