<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Enum\ProvisionsAbgabeInnenEnum;

final readonly class ProvisionsAbgabeInnenAttribute extends AbstractAttribute
{
    public function __construct()
    {
        parent::__construct(
            name: 'provisionsAbgabe_innen',
            label: 'MLS Abgabe Innenprovision',
            type: 'singleselect',
            tablename: 'ObjPreise',
            content: 'Preise',
            default: '50',
        );
    }

    public function getEnumClass(): string
    {
        return ProvisionsAbgabeInnenEnum::class;
    }
}
