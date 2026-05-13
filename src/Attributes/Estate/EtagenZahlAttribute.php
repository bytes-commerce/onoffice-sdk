<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class EtagenZahlAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'etagen_zahl',
            label: 'Etagenzahl',
            type: 'float',
            tablename: 'ObjAusstattung',
            content: 'Ausstattung',
        );
    }
}
