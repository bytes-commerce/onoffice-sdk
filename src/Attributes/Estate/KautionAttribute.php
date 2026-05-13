<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class KautionAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'kaution',
            label: 'Kaution',
            type: 'varchar',
            tablename: 'ObjPreise',
            content: 'Preise',
            length: 80,
        );
    }
}
