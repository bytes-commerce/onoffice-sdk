<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

interface ApiActionInterface
{
    /** @return array<string, mixed> */
    public function getActionParameters(): array;

    public function getIdentifier(): string;
}
