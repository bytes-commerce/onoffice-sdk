<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MieteinnahmenProJahrSollAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'mieteinnahmen_pro_jahr_soll',
            label: 'Jahresmiete (Soll)',
            type: 'float',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
