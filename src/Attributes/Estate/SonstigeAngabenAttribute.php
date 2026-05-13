<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class SonstigeAngabenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'sonstige_angaben',
            label: 'Sonstige Angaben',
            type: 'text',
            tablename: 'ObjFreitexte',
            content: 'Freitexte',
        );
    }
}
