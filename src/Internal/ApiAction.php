<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

final class ApiAction implements ApiActionInterface
{
    /** @var array<string, mixed> */
    private array $actionParameters;

    /**
     * @param array<string|int, mixed> $parameters
     */
    public function __construct(
        private readonly string $actionid,
        private readonly string $resourceType,
        array $parameters,
        private readonly string $resourceId = '',
        private readonly string $identifier = '',
        private readonly ?int $timestamp = null,
    ) {
        ksort($parameters);
        $this->actionParameters = [
            'actionid' => $this->actionid,
            'identifier' => $this->identifier,
            'parameters' => $parameters,
            'resourceid' => $this->resourceId,
            'resourcetype' => $this->resourceType,
            'timestamp' => $this->timestamp,
        ];
    }

    /** @return array<string, mixed> */
    public function getActionParameters(): array
    {
        return $this->actionParameters;
    }

    public function getIdentifier(): string
    {
        return md5(serialize($this->actionParameters));
    }
}
