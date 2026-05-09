<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

interface RequestInterface
{
    /** @return array<string, mixed> */
    public function createRequest(string $token, string $secret): array;

    public function getRequestId(): int;

    public function getApiAction(): ApiAction;
}
