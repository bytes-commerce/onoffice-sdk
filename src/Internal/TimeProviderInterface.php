<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

interface TimeProviderInterface
{
    public function time(): int;
}
