<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class PreventAutomaticPortalResponseAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'preventAutomaticPortalResponse',
            label: 'Anfragen nicht automatisch beantworten',
            type: 'boolean',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
        );
    }
}
