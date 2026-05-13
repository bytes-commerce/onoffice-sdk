<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\Status2Enum;

final readonly class Status2Attribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'status2',
            label: 'Status',
            type: 'singleselect',
            tablename: 'ObjTech',
            content: 'Technische-Angaben',
            default: 'status2obj_aktiv',
        );
    }

    public function getEnumClass(): string
    {
        return Status2Enum::class;
    }
}
