<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

final readonly class Response implements ResponseInterface
{
    /** @var array<string, mixed> */
    private array $responseData;

    /**
     * @param array<string, mixed> $responseData
     */
    public function __construct(
        private Request $pRequest,
        array $responseData,
    ) {
        $this->responseData = $responseData;
    }

    public function isValid(): bool
    {
        return isset($this->responseData['actionid'])
            && isset($this->responseData['resourcetype'], $this->responseData['data']);
    }

    public function isCacheable(): bool
    {
        return $this->isValid() && isset($this->responseData['cacheable'])
            && $this->responseData['cacheable'];
    }

    public function getRequest(): Request
    {
        return $this->pRequest;
    }

    /** @return array<string, mixed> */
    public function getResponseData(): array
    {
        return $this->responseData;
    }
}
