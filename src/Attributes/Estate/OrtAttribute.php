<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class OrtAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'ort',
            label: 'Ort',
            type: 'varchar',
            tablename: 'ObjGeo',
            content: 'Geografische-Angaben',
            length: 50,
        );
    }
}
