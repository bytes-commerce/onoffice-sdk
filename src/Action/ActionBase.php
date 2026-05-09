<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\Api;

abstract readonly class ActionBase implements ActionInterface
{
    protected Api $sdk;

    public function __construct(
        private string $token,
        private string $secret,
        ?Api $sdk = null,
    ) {
        $this->sdk = $sdk ?? new Api('', '');
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    /** @param array<string, mixed> $parameters */
    protected function callRead(array $parameters = []): int
    {
        return $this->sdk->callGeneric(
            Api::ACTION_ID_READ,
            $this->getResourceType(),
            $parameters,
        );
    }

    /** @param array<string, mixed> $parameters */
    protected function callCreate(array $parameters = []): int
    {
        return $this->sdk->callGeneric(
            Api::ACTION_ID_CREATE,
            $this->getResourceType(),
            $parameters,
        );
    }

    /** @param array<string, mixed> $parameters */
    protected function callModify(string $resourceId, array $parameters = []): int
    {
        return $this->sdk->call(
            Api::ACTION_ID_MODIFY,
            $resourceId,
            '',
            $this->getResourceType(),
            $parameters,
        );
    }

    /** @param array<string, mixed> $parameters */
    protected function callDelete(string $resourceId, array $parameters = []): int
    {
        return $this->sdk->call(
            Api::ACTION_ID_DELETE,
            $resourceId,
            '',
            $this->getResourceType(),
            $parameters,
        );
    }

    /** @param array<string, mixed> $parameters */
    protected function callGet(string $resourceId, array $parameters = []): int
    {
        return $this->sdk->call(
            Api::ACTION_ID_GET,
            $resourceId,
            '',
            $this->getResourceType(),
            $parameters,
        );
    }

    /** @param array<string, mixed> $parameters */
    protected function callDo(array $parameters = []): int
    {
        return $this->sdk->callGeneric(
            Api::ACTION_ID_DO,
            $this->getResourceType(),
            $parameters,
        );
    }

    /** @return array<string, mixed> */
    protected function execute(int $handle): array
    {
        $this->sdk->sendRequests($this->token, $this->secret);

        return $this->sdk->getResponseArray($handle);
    }
}
