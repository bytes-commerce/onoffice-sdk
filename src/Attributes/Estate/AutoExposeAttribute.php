<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class AutoExposeAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'autoExpose',
            label: 'Autom. Exposéversand',
            type: 'boolean',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
