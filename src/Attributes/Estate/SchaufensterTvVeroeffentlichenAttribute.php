<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class SchaufensterTvVeroeffentlichenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'schaufensterTv_veroeffentlichen',
            label: 'veröffentlichen',
            type: 'boolean',
            tablename: 'ObjHomepage',
            content: 'Vermarktung',
        );
    }
}
