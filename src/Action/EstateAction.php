<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\ApiInterface;

final readonly class EstateAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_ESTATE;
    }

    /**
     * Read estates with optional filters, fields, limits, and sorting.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Read with filters and geo search:
     * ```php
     * $estateAction->read([
     *     'data' => ['Id', 'kaufpreis', 'ort', 'plz'],
     *     'filter' => [
     *         'kaufpreis' => [['op' => '<', 'val' => 500000]],
     *         'status' => [['op' => '=', 'val' => 1]],
     *     ],
     *     'georangesearch' => [
     *         'country' => 'DEU',
     *         'zip' => '52068',
     *         'radius' => '25',
     *     ],
     *     'listlimit' => 50,
     *     'sortby' => 'kaufpreis',
     *     'sortorder' => 'ASC',
     * ]);
     * ```
     */
    public function read(array $parameters = []): array
    {
        $handle = $this->callRead($parameters);

        return $this->execute($handle);
    }

    /**
     * Create a new estate.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Create a house for sale:
     * ```php
     * $estateAction->create([
     *     'data' => [
     *         'objektart' => 'haus',
     *         'nutzungsart' => 'wohnen',
     *         'vermarktungsart' => 'kauf',
     *         'objekttyp' => 'einfamilienhaus',
     *         'plz' => 52068,
     *         'ort' => 'Aachen',
     *         'land' => 'DEU',
     *         'kaufpreis' => 350000,
     *         'wohnflaeche' => 120,
     *         'anzahl_zimmer' => 5,
     *         'baujahr' => 2015,
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
     * Modify an existing estate.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Update price and status:
     * ```php
     * $estateAction->modify('123', [
     *     'data' => [
     *         'kaufpreis' => 375000,
     *         'status' => 2, // 1=Active, 2=Pending, 0=Archived
     *     ],
     * ]);
     * ```
     */
    public function modify(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callModify($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Delete an estate.
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
     * Quick search for estates by input string.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Search estates by city or address:
     * ```php
     * $estateAction->quickSearch([
     *     'input' => 'Berlin',
     *     'sortby' => 'ort',
     *     'sortorder' => 'ASC',
     *     'includeThumbnail' => 'medium',
     *     'filter' => [
     *         'vermarktungsart' => [['op' => '=', 'val' => 'kauf']],
     *     ],
     * ]);
     * ```
     */
    public function quickSearch(array $parameters = []): array
    {
        $handle = $this->sdk->callGeneric(
            Api::ACTION_ID_GET,
            Api::MODULE_SEARCH,
            $parameters,
        );

        return $this->execute($handle);
    }
}
