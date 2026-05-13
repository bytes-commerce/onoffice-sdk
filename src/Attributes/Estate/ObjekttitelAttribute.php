<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class ObjekttitelAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'objekttitel',
            label: 'Objekttitel',
            type: 'text',
            tablename: 'ObjFreitexte',
            content: 'Freitexte',
        );
    }
}
