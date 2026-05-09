<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\ApiInterface;

final readonly class SearchCriteriaAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_SEARCHCRITERIA;
    }

    /**
     * Read search criteria.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function read(array $parameters = []): array
    {
        $handle = $this->callRead($parameters);

        return $this->execute($handle);
    }

    /**
     * Create search criteria.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Create search criteria for a buyer:
     * ```php
     * $searchAction->create([
     *     'addressid' => '153',
     *     'data' => [
     *         'advisor' => 21,
     *         'objektart' => 'haus',
     *         'vermarktungsart' => 'kauf',
     *         'range_plz' => '52068',
     *         'range_ort' => 'Aachen',
     *         'range_strasse' => 'Charlottenburger Allee',
     *         'range_hausnummer' => '5',
     *         'range' => '100', // radius in km
     *         'kaufpreis__von' => '50000',
     *         'kaufpreis__bis' => '500000',
     *         'krit_bemerkung' => 'Interested in quiet neighborhoods',
     *     ],
     * ]);
     * ```
     */
    public function create(array $parameters = []): array
    {
        $handle = $this->callCreate($parameters);

        return $this->execute($handle);
    }

    /**
     * Modify search criteria.
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
     * Delete search criteria.
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
}
