<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class MPPhDossierUrlAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'MPPhDossierUrl',
            label: 'PriceHubble-Marktwertbericht',
            type: 'text',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
        );
    }
}
