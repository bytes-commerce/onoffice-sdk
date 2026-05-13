<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MlsProvisionsAbgabeBeschreibungAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'mls_provisionsAbgabe_beschreibung',
            label: 'MLS Abgabe Beschreibung',
            type: 'text',
            tablename: 'ObjPreise',
            content: 'Preise',
        );
    }
}
