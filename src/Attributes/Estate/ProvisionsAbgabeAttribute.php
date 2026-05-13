<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ProvisionsAbgabeEnum;

final readonly class ProvisionsAbgabeAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'provisionsAbgabe',
            label: 'MLS Abgabe Außenprovision',
            type: 'singleselect',
            tablename: 'ObjPreise',
            content: 'Preise',
            default: '50',
        );
    }

    public function getEnumClass(): string
    {
        return ProvisionsAbgabeEnum::class;
    }
}
