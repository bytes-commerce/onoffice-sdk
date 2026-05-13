<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class TransferStreetWithoutHouseNumberAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'transferStreetWithoutHouseNumber',
            label: 'Straße ohne Hausnummer übertragen',
            type: 'boolean',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
        );
    }
}
