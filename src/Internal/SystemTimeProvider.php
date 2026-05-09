<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

final class SystemTimeProvider implements TimeProviderInterface
{
    public function time(): int
    {
        return time();
    }
}
