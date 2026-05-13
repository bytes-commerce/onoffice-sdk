<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;

final readonly class ObjektnrExternAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'objektnr_extern',
            label: 'ImmoNR',
            type: 'varchar',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
            length: 20,
        );
    }
}
