<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class VerfuegbarAbAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'verfuegbar_ab',
            label: 'Verfügbar ab',
            type: 'varchar',
            tablename: 'ObjVerwaltung',
            content: 'Verwaltung',
            length: 20,
        );
    }
}
