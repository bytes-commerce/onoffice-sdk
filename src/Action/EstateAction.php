<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\ApiInterface;
use BytesCommerce\OnOffice\DTO\Estate\EstateAttributeMapper;
use BytesCommerce\OnOffice\DTO\Estate\EstateDTO;
use BytesCommerce\OnOffice\DTO\Estate\EstateDTOFactory;
use BytesCommerce\OnOffice\DTO\Estate\EstateImageDTO;
use BytesCommerce\OnOffice\DTO\Estate\EstateImageDTOFactory;
use BytesCommerce\OnOffice\Exception\ApiCallFaultyResponseException;
use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use Webmozart\Assert\Assert;

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
     * @example Read with filters and sorting:
     * ```php
     * $estateAction->read([
     *     'data' => ['Id', 'kaufpreis', 'ort', 'plz'],
     *     'filter' => [
     *         'kaufpreis' => [['op' => '<', 'val' => 500000]],
     *         'status' => [['op' => '=', 'val' => 1]],
     *     ],
     *     'listlimit' => 50,
     *     'sortby' => ['kaufpreis' => 'ASC'],  // Object format: {"field": "ASC|DESC"}
     * ]);
     * ```
     * @example Read with multi-field sorting:
     * ```php
     * $estateAction->read([
     *     'data' => ['Id', 'kaufpreis', 'ort'],
     *     'sortby' => ['kaufpreis' => 'ASC', 'ort' => 'DESC'],
     *     'listlimit' => 50,
     * ]);
     * ```
     * @example Geo search:
     * ```php
     * $estateAction->read([
     *     'data' => ['Id', 'kaufpreis', 'ort'],
     *     'georangesearch' => [
     *         'country' => 'DEU',
     *         'zip' => '52068',
     *         'radius' => '25',
     *     ],
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
            ApiInterface::ACTION_ID_GET,
            ApiInterface::MODULE_SEARCH,
            $parameters,
        );

        return $this->execute($handle);
    }

    /**
     * Get images published on the homepage for a specific estate.
     *
     * This retrieves all images that are marked as "published on homepage" for the estate.
     *
     * @param int|string $estateId The estate ID
     * @param array<string> $categories File type categories to fetch (e.g., ['Foto', 'Grundriss', 'Panorama'])
     *   Common categories: 'Titelbild', 'Foto', 'Foto_gross', 'Grundriss', 'Lageplan', 'Panorama'
     * @param string $size Image size ('original' or WxH format like '500x500')
     *
     * @throws ApiCallFaultyResponseException
     * @throws HttpFetchNoResultException
     *
     * @return EstateImageDTO[]
     *
     * @example Get all images for estate ID 123:
     * ```php
     * $images = $estateAction->getEstateImages(123);
     * foreach ($images as $image) {
     *     echo $image->title . ': ' . $image->url . "\n";
     * }
     * ```
     * @example Get only photos and floor plans:
     * ```php
     * $images = $estateAction->getEstateImages(123, ['Foto', 'Grundriss']);
     * ```
     */
    public function getEstateImages(
        int|string $estateId,
        array $categories = ['Foto'],
        string $size = 'original',
    ): array {
        $token = $this->getToken();
        $secret = $this->getSecret();

        $sdk = new Api($token, $secret);
        $sdk->setApiServer('https://api.onoffice.de/api/');
        $sdk->setApiVersion('latest');
        $sdk->removeCacheInstances();

        $handle = $sdk->callGeneric(
            ApiInterface::ACTION_ID_GET,
            ApiInterface::MODULE_ESTATE_PICTURES,
            [
                'estateids' => [(int) $estateId],
                'categories' => $categories,
                'size' => $size,
            ],
        );

        $sdk->sendRequestsWithCredentials(false);
        $response = $sdk->getResponseArray($handle);

        Assert::keyExists($response, 'data');
        Assert::isArray($response['data']);
        Assert::keyExists($response['data'], 'records');
        Assert::isArray($response['data']['records']);
        $records = $response['data']['records'];

        return new EstateImageDTOFactory()->fromRecords($records);
    }

    /**
     * Get ALL estates with automatic pagination.
     *
     * This method fetches all matching estates by automatically paginating through
     * results until a dead end is reached (empty or partial page).
     *
     * NOTE: Due to SDK internal state issues, this method creates a fresh SDK
     * instance for each page to ensure correct pagination.
     *
     * @param array<string> $fields Fields to fetch (default: all valid fields from EstateAttributeMapper)
     * @param array<string, string>|null $sortBy Sort field and direction, e.g. ['geaendert_am' => 'DESC']
     *   Object format: ['field' => 'ASC'|'DESC']
     * @param array<string, array<int, array<string, mixed>>> $filter Filter conditions
     * @param int $pageSize Records per page (max 500, default 500)
     * @param bool $withImages Whether to lazy-load images for each estate (default: false)
     *
     * @throws ApiCallFaultyResponseException
     * @throws HttpFetchNoResultException
     *
     * @return EstateDTO[]
     *
     * @example Get all estates sorted by modification date:
     * ```php
     * $estates = $estateAction->getAllEstates(
     *     sortBy: ['geaendert_am' => 'DESC']
     * );
     * foreach ($estates as $estate) {
     *     echo $estate->objekttitel . ' - ' . $estate->ort . "\n";
     * }
     * ```
     * @example Get all active (not sold) estates for sale:
     * ```php
     * $estates = $estateAction->getAllEstates(
     *     sortBy: ['kaufpreis' => 'ASC'],
     *     filter: [
     *         'vermarktungsart' => [['op' => '=', 'val' => 'kauf']],
     *         'verkauft' => [['op' => '=', 'val' => 0]],
     *         'reserviert' => [['op' => '=', 'val' => 0]],
     *     ]
     * );
     * ```
     * @example Get all estates with lazy-loaded images:
     * ```php
     * $estates = $estateAction->getAllEstates(withImages: true);
     * foreach ($estates as $estate) {
     *     // Images are fetched only when getImages() is called
     *     $images = $estate->getImages();
     *     echo $estate->objekttitel . ' has ' . count($images) . " images\n";
     * }
     * ```
     */
    public function getAllEstates(
        ?array $fields = null,
        ?array $sortBy = ['geaendert_am' => 'DESC'],
        array $filter = [],
        int $pageSize = 500,
        bool $withImages = false,
    ): array {
        $fields ??= new EstateAttributeMapper()->getMappedFields();

        $token = $this->getToken();
        $secret = $this->getSecret();

        $allRecords = [];
        $offset = 0;
        $pageNumber = 0;

        while (true) {
            ++$pageNumber;

            $sdk = new Api($token, $secret);
            $sdk->setApiServer('https://api.onoffice.de/api/');
            $sdk->setApiVersion('latest');
            $sdk->removeCacheInstances();

            $handle = $sdk->callGeneric(
                ApiInterface::ACTION_ID_READ,
                ApiInterface::MODULE_ESTATE,
                [
                    'data' => $fields,
                    'listlimit' => $pageSize,
                    'listoffset' => $offset,
                    'sortby' => $sortBy,
                    'filter' => $filter,
                ],
            );

            $sdk->sendRequestsWithCredentials(false);
            $response = $sdk->getResponseArray($handle);

            if (!isset($response['data']['records']) || !\is_array($response['data']['records'])) {
                break;
            }
            $records = $response['data']['records'];
            $recordCount = \count($records);

            if ($recordCount === 0 || $recordCount < $pageSize) {
                $allRecords = array_merge($allRecords, $records);

                break;
            }

            $allRecords = array_merge($allRecords, $records);
            $offset += $pageSize;

            if ($pageNumber > 10_000) {
                break;
            }
        }

        if ($withImages) {
            $estateAction = $this;
            $imagesLoader = static fn (int|string $estateId): array => $estateAction->getEstateImages($estateId);

            return new EstateDTOFactory()->fromRecordsWithImagesLoader($allRecords, $imagesLoader);
        }

        return new EstateDTOFactory()->fromRecords($allRecords);
    }

    /**
     * Get a limited number of estates with pagination.
     *
     * This method fetches up to $maxRecords estates, automatically determining
     * how many pages to fetch based on pageSize.
     *
     * @param int $maxRecords Maximum number of records to fetch
     * @param array<string> $fields Fields to fetch
     * @param array<string, string>|null $sortBy Sort field and direction, e.g. ['geaendert_am' => 'DESC']
     * @param array<string, array<int, array<string, mixed>>> $filter Filter conditions
     * @param int $pageSize Records per page (max 500, default 500)
     * @param bool $withImages Whether to lazy-load images for each estate (default: false)
     *
     * @return EstateDTO[]
     *
     * @example Get first 100 estates:
     * ```php
     * $estates = $estateAction->getLimitedEstates(
     *     maxRecords: 100,
     *     sortBy: ['geaendert_am' => 'DESC']
     * );
     * ```
     * @example Get estates with lazy-loaded images:
     * ```php
     * $estates = $estateAction->getLimitedEstates(maxRecords: 10, withImages: true);
     * foreach ($estates as $estate) {
     *     $images = $estate->getImages(); // Images fetched only when called
     * }
     * ```
     */
    public function getLimitedEstates(
        int $maxRecords = 100,
        ?array $fields = null,
        ?array $sortBy = ['geaendert_am' => 'DESC'],
        array $filter = [],
        int $pageSize = 500,
        bool $withImages = false,
    ): array {
        $fields ??= new EstateAttributeMapper()->getMappedFields();

        $token = $this->getToken();
        $secret = $this->getSecret();

        $allRecords = [];
        $offset = 0;
        $pageNumber = 0;
        $remainingRecords = $maxRecords;

        while ($remainingRecords > 0) {
            ++$pageNumber;

            $currentPageSize = min($pageSize, $remainingRecords);

            $sdk = new Api($token, $secret);
            $sdk->setApiServer('https://api.onoffice.de/api/');
            $sdk->setApiVersion('latest');
            $sdk->removeCacheInstances();

            $handle = $sdk->callGeneric(
                ApiInterface::ACTION_ID_READ,
                ApiInterface::MODULE_ESTATE,
                [
                    'data' => $fields,
                    'listlimit' => $currentPageSize,
                    'listoffset' => $offset,
                    'sortby' => $sortBy,
                    'filter' => $filter,
                ],
            );

            $sdk->sendRequestsWithCredentials(false);
            $response = $sdk->getResponseArray($handle);

            if (!isset($response['data']['records']) || !\is_array($response['data']['records'])) {
                break;
            }
            $records = $response['data']['records'];
            $recordCount = \count($records);

            if ($recordCount === 0) {
                break;
            }

            $allRecords = array_merge($allRecords, $records);
            $remainingRecords -= $recordCount;
            $offset += $recordCount;

            if ($recordCount < $currentPageSize) {
                break;
            }

            if ($pageNumber > 10_000) {
                break;
            }
        }

        if ($withImages) {
            $estateAction = $this;
            $imagesLoader = static fn (int|string $estateId): array => $estateAction->getEstateImages($estateId);

            return new EstateDTOFactory()->fromRecordsWithImagesLoader($allRecords, $imagesLoader);
        }

        return new EstateDTOFactory()->fromRecords($allRecords);
    }
}
