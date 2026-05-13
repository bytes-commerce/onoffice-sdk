<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class PlaceholderEnergyAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'placeholderEnergy',
            label: 'Gewerbe',
            type: 'blackhint',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
