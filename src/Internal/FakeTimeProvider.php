<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

final class FakeTimeProvider implements TimeProviderInterface
{
    public function __construct(
        private int $timestamp,
    ) {}

    public function time(): int
    {
        return $this->timestamp;
    }
}
