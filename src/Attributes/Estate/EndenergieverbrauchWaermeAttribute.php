<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EndenergieverbrauchWaermeAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'endenergieverbrauchWaerme',
            label: 'Endenergieverbrauch (Wärme)',
            type: 'float',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
