<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

interface ResponseInterface
{
    public function isValid(): bool;

    public function isCacheable(): bool;

    public function getRequest(): Request;

    /** @return array<string, mixed> */
    public function getResponseData(): array;
}
