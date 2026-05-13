<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class ObjektbeschreibungStvAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'objektbeschreibung_STV',
            label: 'STV Objektbeschreibung',
            type: 'text',
            tablename: 'ObjFreitexte',
            content: 'Freitexte',
        );
    }
}
