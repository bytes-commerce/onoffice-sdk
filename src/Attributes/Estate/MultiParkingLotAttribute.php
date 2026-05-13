<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MultiParkingLotAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'multiParkingLot',
            label: 'Stellplätze',
            type: 'text',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }
}
