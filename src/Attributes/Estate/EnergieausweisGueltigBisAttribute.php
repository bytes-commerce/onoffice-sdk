<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EnergieausweisGueltigBisAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'energieausweis_gueltig_bis',
            label: 'Energieausweis gültig bis',
            type: 'date',
            tablename: 'ObjZustand',
            content: 'Zustand',
        );
    }
}
