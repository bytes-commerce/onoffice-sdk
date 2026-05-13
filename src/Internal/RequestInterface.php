<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

use SensitiveParameter;

interface RequestInterface
{
    /** @return array<string, mixed> */
    public function createRequest(#[SensitiveParameter] string $token, #[SensitiveParameter] string $secret): array;

    public function getRequestId(): int;

    public function getApiAction(): ApiAction;
}
