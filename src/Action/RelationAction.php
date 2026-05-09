<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\ApiInterface;

final readonly class RelationAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_RELATIONS;
    }

    /**
     * Create a relation.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function create(array $parameters = []): array
    {
        $handle = $this->callCreate($parameters);

        return $this->execute($handle);
    }

    /**
     * Modify a relation.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function modify(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callModify($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Delete a relation.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function delete(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callDelete($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Get relations.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function getRelations(array $parameters = []): array
    {
        $handle = $this->sdk->callGeneric(
            Api::ACTION_ID_GET,
            Api::MODULE_RELATIONS,
            $parameters,
        );

        return $this->execute($handle);
    }
}
