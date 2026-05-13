<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Exception\ApiCallFaultyResponseException;
use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use Location\Coordinate;
use Location\Distance\Vincenty;
use SensitiveParameter;
use Webmozart\Assert\Assert;

class ApiCall
{
    public const string BASE_API_URL = 'https://api.onoffice.de/api/';

    public const string BASE_API_VERSION = 'latest';

    /** @var array<int, Request> */
    private array $requestQueue = [];

    /** @var array<int, Response> */
    private array $responses = [];

    /** @var array<int, mixed> */
    private array $errors = [];

    private string $apiVersion = self::BASE_API_VERSION;

    /** @var array<int, cacheInterface> */
    private array $caches = [];

    private ?string $server = self::BASE_API_URL;

    /** @var array<int, mixed> */
    private array $curlOptions = [];

    private ?HttpFetch $httpFetch = null;

    public function __construct(
        private readonly TimeProviderInterface $timeProvider = new SystemTimeProvider(),
    ) {}

    /** @param array<string, mixed> $parameters */
    public function callByRawData(
        string $actionId,
        string $resourceId,
        string $identifier,
        string $resourceType,
        array $parameters = [],
    ): int {
        $pApiAction = new ApiAction($actionId, $resourceType, $parameters, $resourceId, $identifier);

        $pRequest = new Request($pApiAction, $this->timeProvider);
        $requestId = $pRequest->getRequestId();
        $this->requestQueue[$requestId] = $pRequest;

        return $requestId;
    }

    /**
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>|null
     */
    public function callByRawDataFromCache(
        string $actionId,
        string $resourceId,
        string $identifier,
        string $resourceType,
        array $parameters = [],
    ): ?array {
        $pApiAction = new ApiAction($actionId, $resourceType, $parameters, $resourceId, $identifier);
        $pRequest = new Request($pApiAction, $this->timeProvider);

        $usedParameters = $pRequest->getApiAction()->getActionParameters();

        return $this->getFromCache($usedParameters);
    }

    /**
     * @throws HttpFetchNoResultException
     */
    public function sendRequests(
        #[SensitiveParameter]
        string $token,
        #[SensitiveParameter]
        string $secret,
        ?HttpFetch $httpFetch = null,
        bool $saveToCache = true,
        ?string $claim = null,
    ): void {
        Assert::notEmpty($token, 'Token must not be empty');
        Assert::notEmpty($secret, 'Secret must not be empty');

        $httpFetch ??= $this->httpFetch;
        $this->collectOrGatherRequests($token, $secret, $httpFetch, $saveToCache, $claim);
    }

    /** @param array<int, mixed> $curlOptions */
    public function setCurlOptions(array $curlOptions): void
    {
        $this->curlOptions = $curlOptions;
    }

    /**
     * @throws ApiCallFaultyResponseException
     *
     * @return array<string, mixed>
     */
    public function getResponse(int $handle): array
    {
        if (!\array_key_exists($handle, $this->responses)) {
            return [];
        }

        $pResponse = $this->responses[$handle];

        if (!$pResponse->isValid()) {
            throw new ApiCallFaultyResponseException('Handle: ' . $handle);
        }

        unset($this->responses[$handle]);

        return $pResponse->getResponseData();
    }

    public function setApiVersion(string $apiVersion): void
    {
        $this->apiVersion = $apiVersion;
    }

    public function setServer(string $server): void
    {
        $this->server = $server;
    }

    /** @return array<int, mixed> */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function addCache(cacheInterface $pCache): void
    {
        $this->caches[] = $pCache;
    }

    public function removeCacheInstances(): void
    {
        $this->caches = [];
    }

    /**
     * @param array<int, array<string, mixed>> $actionParameters
     * @param array<int, Request> $actionParametersOrder
     *
     * @throws HttpFetchNoResultException
     */
    private function sendHttpRequests(
        string $token,
        array $actionParameters,
        array $actionParametersOrder,
        ?HttpFetch $httpFetch = null,
        bool $saveToCache = true,
    ): void {
        if (\count($actionParameters) === 0) {
            return;
        }

        $responseHttp = $this->getFromHttp($token, $actionParameters, $httpFetch);

        /** @var array<string, mixed> $result */
        $result = json_decode($responseHttp, true);
        Assert::keyExists($result, 'response');

        $responseData = $result['response'];
        Assert::isArray($responseData);

        if (!isset($responseData['results'])) {
            throw new HttpFetchNoResultException();
        }

        /** @var mixed $results */
        $results = $responseData['results'];
        Assert::isArray($results);

        $idsForCache = [];

        /** @var int $requestNumber */
        foreach ($results as $requestNumber => $resultHttp) {
            Assert::isArray($resultHttp);
            Assert::keyExists($resultHttp, 'status');

            /** @var mixed $status */
            $status = $resultHttp['status'];
            Assert::isArray($status);

            /** @var Request $pRequest */
            $pRequest = $actionParametersOrder[$requestNumber];
            $requestId = $pRequest->getRequestId();

            /** @var int $errorcode */
            $errorcode = $status['errorcode'];
            if ($errorcode === 0) {
                /** @var array<string, mixed> $resultHttp */
                $this->responses[$requestId] = new Response($pRequest, $resultHttp);
                $idsForCache[] = $requestId;
            } else {
                $this->errors[$requestId] = $resultHttp;
            }
        }
        if ($saveToCache) {
            $this->writeCacheForResponses($idsForCache);
        }
    }

    /**
     * @throws HttpFetchNoResultException
     */
    private function collectOrGatherRequests(
        string $token,
        string $secret,
        ?HttpFetch $httpFetch = null,
        bool $saveToCache = true,
        ?string $claim = null,
    ): void {
        /** @var array<int, array<string, mixed>> $actionParameters */
        $actionParameters = [];
        /** @var array<int, Request> $actionParametersOrder */
        $actionParametersOrder = [];

        foreach ($this->requestQueue as $requestId => $pRequest) {
            $usedParameters = $pRequest->getApiAction()->getActionParameters();
            $cachedResponse = $this->getFromCache($usedParameters);
            $params = $usedParameters['parameters'] ?? [];

            if ($cachedResponse === null) {
                $parametersThisAction = $pRequest->createRequest($token, $secret);

                if ($claim !== null) {
                    if (!isset($parametersThisAction['parameters'])) {
                        $parametersThisAction['parameters'] = [];
                    }
                    Assert::isArray($parametersThisAction['parameters']);
                    $parametersThisAction['parameters']['extendedclaim'] = $claim;
                }

                $actionParameters[] = $parametersThisAction;
                $actionParametersOrder[] = $pRequest;
            } else {
                Assert::isArray($params);
                if (isset($params['listname']) && ($params['formatoutput'] ?? false) === true) {
                    Assert::keyExists($cachedResponse, 'data');
                    Assert::isArray($cachedResponse['data']);
                    Assert::keyExists($cachedResponse['data'], 'records');
                    $filter = $params['filter'] ?? [];
                    Assert::isArray($filter);
                    $this->filterRecords($cachedResponse, $filter);
                    if (isset($params['sortby'])) {
                        Assert::keyExists($cachedResponse['data'], 'records');
                        $sortorder = $params['sortorder'] ?? 'ASC';
                        Assert::string($sortorder);
                        $cachedResponse['data']['records'] = $this->sortRecords(
                            $cachedResponse,
                            $filter,
                            $params['sortby'],
                            $sortorder,
                        );
                    }
                    Assert::keyExists($cachedResponse['data'], 'records');
                    $records = $cachedResponse['data']['records'];
                    Assert::isArray($records);
                    $cachedResponse['data']['meta']['cntabsolute'] = \count($records);
                    $listlimit = (int) ($params['listlimit'] ?? 20);
                    $listoffset = (int) ($params['listoffset'] ?? 0);
                    $cachedResponse['data']['records'] = $this->recordsPerPage(
                        $records,
                        $listlimit,
                        $listoffset,
                    );
                }

                $this->responses[$requestId] = new Response($pRequest, $cachedResponse);
                $saveToCache = false;
            }
        }

        $this->sendHttpRequests($token, $actionParameters, $actionParametersOrder, $httpFetch, $saveToCache);
        $this->requestQueue = [];
    }

    /** @param array<int> $responses */
    private function writeCacheForResponses(array $responses): void
    {
        if (\count($this->caches) === 0) {
            return;
        }

        $responseObjects = array_intersect_key($this->responses, array_flip($responses));

        foreach ($responseObjects as $pResponse) {
            /** @var Response $pResponse */
            if ($pResponse->isCacheable()) {
                $responseData = $pResponse->getResponseData();
                $requestParameters = $pResponse->getRequest()->getApiAction()->getActionParameters();
                $this->writeCache(serialize($responseData), $requestParameters);
            }
        }
    }

    /**
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>|null
     */
    private function getFromCache(array $parameters): ?array
    {
        foreach ($this->caches as $pCache) {
            $resultCache = $pCache->getHttpResponseByParameterArray($parameters);

            if ($resultCache !== null) {
                /** @var array<string, mixed>|false $unserialized */
                $unserialized = unserialize($resultCache);
                if ($unserialized !== false) {
                    return $unserialized;
                }
            }
        }

        return null;
    }

    /** @param array<string, mixed> $actionParameters */
    private function writeCache(string $result, array $actionParameters): void
    {
        foreach ($this->caches as $pCache) {
            $pCache->write($actionParameters, $result);
        }
    }

    /**
     * @param array<int, array<string, mixed>> $actionParameters
     *
     * @throws HttpFetchNoResultException
     */
    private function getFromHttp(
        string $token,
        array $actionParameters,
        ?HttpFetch $httpFetch = null,
    ): string {
        $request = [
            'token' => $token,
            'request' => ['actions' => $actionParameters],
        ];

        if (!$httpFetch instanceof HttpFetch) {
            $encoded = json_encode($request);
            Assert::string($encoded);
            $httpFetch = new HttpFetch($this->getApiUrl(), $encoded);
            $httpFetch->setCurlOptions($this->curlOptions);
        }

        $this->httpFetch = $httpFetch;

        return $httpFetch->send();
    }

    private function getApiUrl(): string
    {
        return $this->server . urlencode($this->apiVersion) . '/api.php';
    }

    private function tofloat(string $num): float
    {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos
            : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return (float) (preg_replace('/[^0-9]/', '', $num));
        }

        return (float) (
            preg_replace('/[^0-9]/', '', substr($num, 0, $sep)) . '.'
            . preg_replace('/[^0-9]/', '', substr($num, $sep + 1, \strlen($num)))
        );
    }

    /**
     * @param array<int, mixed> $records
     *
     * @return array<int, mixed>
     */
    private function recordsPerPage(array $records, int $limit, int $offset): array
    {
        return \array_slice($records, $offset, $limit);
    }

    /**
     * @param array<string, mixed> $cachedResponse
     * @param array<string, mixed> $filter
     *
     * @return array<int, mixed>
     */
    private function sortRecords(
        array $cachedResponse,
        array $filter,
        mixed $sortby,
        string $sortorder = 'ASC',
    ): array {
        $newRecords = $cachedResponse['data']['records'];
        $newRecordsRaw = $cachedResponse['raw']['data']['records'] ?? null;

        foreach ($newRecords as $index => &$record) {
            $record['elementsRaw'] = $newRecordsRaw !== null && isset($newRecordsRaw[$index]['elements'])
                ? $newRecordsRaw[$index]['elements']
                : null;
        }

        $fieldTypes = $cachedResponse['types'] ?? [];
        $sortBy = (isset($filter['geo'], $filter['geo'][0]['loc']))
            ? 'geo_distance'
            : $sortby;
        $sortOrder = (isset($filter['geo'], $filter['geo'][0]['loc']))
            ? 'ASC'
            : $sortorder;

        if (isset($sortby)) {
            $compareRecords = function ($a, $b, $sortBy, $sortOrder, $fieldTypes) {
                $fieldType = $fieldTypes[$sortBy] ?? null;

                if (\in_array($fieldType, ['boolean', 'date', 'datetime', 'float', 'integer'], true)) {
                    $sortA = $a['elementsRaw'][$sortBy]
                        ?? ($a['elements'][$sortBy] ?? '');
                    $sortB = $b['elementsRaw'][$sortBy]
                        ?? ($b['elements'][$sortBy] ?? '');
                } else {
                    $sortA = $a['elements'][$sortBy] ?? '';
                    $sortB = $b['elements'][$sortBy] ?? '';
                }

                if ($fieldType === 'integer' || $fieldType === 'float') {
                    $sortA = $this->tofloat((string) $sortA);
                    $sortB = $this->tofloat((string) $sortB);
                }

                if ($fieldType === 'date') {
                    $sortA = strtotime((string) $sortA);
                    $sortB = strtotime((string) $sortB);
                }

                if ($fieldType === 'boolean') {
                    $sortA = $sortA === '' ? '0' : $sortA;
                    $sortB = $sortB === '' ? '0' : $sortB;
                }

                if ($sortA === $sortB) {
                    return 0;
                }

                if ($sortOrder === 'ASC') {
                    return $sortA > $sortB ? 1 : -1;
                }

                return $sortA > $sortB ? -1 : 1;
            };

            if (\is_string($sortBy)) {
                usort($newRecords, static fn ($a, $b) => $compareRecords($a, $b, $sortBy, $sortOrder, $fieldTypes));
            } elseif (\is_array($sortBy)) {
                usort($newRecords, static function ($a, $b) use ($compareRecords, $sortBy, $fieldTypes) {
                    foreach ($sortBy as $field => $order) {
                        $result = $compareRecords($a, $b, $field, $order, $fieldTypes);
                        if ($result !== 0) {
                            return $result;
                        }
                    }

                    return 0;
                });
            }
        }

        return $newRecords;
    }

    /**
     * @param array<string, mixed> &$cachedResponse
     * @param array<string, array<int, array<string, mixed>>> $filter
     */
    private function filterRecords(array &$cachedResponse, array $filter): void
    {
        $records = $cachedResponse['data']['records'];
        $filteredArray = $records;
        $filteredArrayRaw = $cachedResponse['raw']['data']['records'] ?? [];
        $fieldTypes = $cachedResponse['types'] ?? [];

        $calculator = new Vincenty();
        $isGeoAndMin = 0;
        $isGeoAndMax = 0;

        foreach ($filteredArray as $index => $item) {
            $k = $filteredArrayRaw !== [] ? array_search($item['id'], array_column($filteredArrayRaw, 'id'), true) : false;
            $itemRaw = $k !== false && isset($filteredArrayRaw[$k]) ? $filteredArrayRaw[$k] : null;

            if ($itemRaw === null) {
                continue;
            }

            foreach ($filter as $fieldName => $value) {
                if (\in_array($fieldName, ['veroeffentlichen', 'referenz', 'homepage_veroeffentlichen'], true)) {
                    continue;
                }

                foreach ($value as $fieldValue) {
                    $op = $fieldValue['op'];
                    $val = $fieldValue['val'];

                    if ($val === null || (\is_string($val) && trim($val) === '')) {
                        continue;
                    }

                    if (strtolower($op) === '=') {
                        if (!\array_key_exists($fieldName, $item['elements'])) {
                            unset($filteredArray[$index]);

                            break 2;
                        }

                        if (\is_array($val)) {
                            if (!\in_array($item['elements'][$fieldName], $val, true)) {
                                unset($filteredArray[$index]);

                                break 2;
                            }
                        } else {
                            // int compare
                            if ($fieldTypes[$fieldName] === 'integer'
                                && (int) ($itemRaw['elements'][$fieldName] ?? '') !== (int) $val) {
                                unset($filteredArray[$index]);

                                break 2;
                            }

                            // float compare
                            if ($fieldTypes[$fieldName] === 'float'
                                && (float) ($itemRaw['elements'][$fieldName] ?? '') !== (float) $val) {
                                unset($filteredArray[$index]);

                                break 2;
                            }

                            // boolean compare
                            if ($fieldTypes[$fieldName] === 'boolean'
                                && (int) ($itemRaw['elements'][$fieldName] ?? '') !== (int) $val) {
                                unset($filteredArray[$index]);

                                break 2;
                            }

                            // string compare
                            if (($fieldTypes[$fieldName] ?? '') === 'varchar'
                                && mb_strtolower((string) ($item['elements'][$fieldName] ?? '')) !== mb_strtolower((string) $val)) {
                                unset($filteredArray[$index]);

                                break 2;
                            }
                        }
                    } elseif (strtolower($op) === '!=') {
                        if (\is_array($val)) {
                            if (!\in_array($item['elements'][$fieldName] ?? '', $val, true)) {
                                unset($filteredArray[$index]);

                                break 2;
                            }
                        } else {
                            // int compare
                            if ($fieldTypes[$fieldName] === 'integer'
                                && (int) ($itemRaw['elements'][$fieldName] ?? '') === (int) $val) {
                                unset($filteredArray[$index]);

                                break 2;
                            }

                            // float compare
                            if ($fieldTypes[$fieldName] === 'float'
                                && (float) ($itemRaw['elements'][$fieldName] ?? '') === (float) $val) {
                                unset($filteredArray[$index]);

                                break 2;
                            }

                            // boolean compare
                            if ($fieldTypes[$fieldName] === 'boolean'
                                && (bool) ($itemRaw['elements'][$fieldName] ?? '') === (bool) $val) {
                                unset($filteredArray[$index]);

                                break 2;
                            }

                            // string compare
                            if (mb_strtolower((string) ($item['elements'][$fieldName] ?? '')) === mb_strtolower((string) $val)) {
                                unset($filteredArray[$index]);

                                break 2;
                            }
                        }
                    } elseif (strtolower($op) === 'like') {
                        $val = str_replace('%', '', (string) $val);

                        if ($fieldName === 'multiParkingLot') {
                            $parkingLots = $itemRaw['elements'][$fieldName] ?? [];

                            $hasValidParkingLot = array_filter($parkingLots, static fn ($lot) => !\in_array(null, $lot, true)
                                    && !\in_array(0, $lot, true)
                                    && !\in_array(0.0, $lot, true)
                                    && !\in_array('', $lot, true));

                            if ($hasValidParkingLot === []) {
                                unset($filteredArray[$index]);

                                break 2;
                            }
                        } elseif (
                            !isset($itemRaw['elements'][$fieldName])
                            || stripos((string) $itemRaw['elements'][$fieldName], $val) === false
                        ) {
                            unset($filteredArray[$index]);

                            break 2;
                        }
                    } elseif (strtolower($op) === 'in') {
                        $elVal = $itemRaw['elements'][$fieldName] ?? '';

                        if ($fieldName === 'Id') {
                            $elVal = str_replace(',', '', (string) $elVal);
                            $elVal = str_replace('.', '', $elVal);
                        }

                        if (!\is_array($val)) {
                            $val = [$val];
                        }

                        $lowerVal = array_map('mb_strtolower', $val);

                        if (\is_array($elVal)) {
                            if ($elVal === [] || \count(array_intersect(array_map('strtolower', $elVal), $lowerVal)) === 0) {
                                unset($filteredArray[$index]);

                                break 2;
                            }
                        } elseif (!\in_array(mb_strtolower((string) $elVal), $lowerVal, true)) {
                            unset($filteredArray[$index]);

                            break 2;
                        }
                    } elseif ($op === '<=') {
                        if (!\array_key_exists($fieldName, $itemRaw['elements'])
                            || $this->isBigger($val, $itemRaw['elements'][$fieldName] ?? '', $fieldTypes[$fieldName] ?? '')) {
                            unset($filteredArray[$index]);

                            break 2;
                        }
                    } elseif ($op === '>=') {
                        if (!\array_key_exists($fieldName, $itemRaw['elements'])
                            || $this->isSmaller($val, $itemRaw['elements'][$fieldName] ?? '', $fieldTypes[$fieldName] ?? '')) {
                            unset($filteredArray[$index]);

                            break 2;
                        }
                    } elseif (strtolower($op) === 'geo') {
                        $km = (int) $val;
                        $min = $value[0]['min'] ?? null;
                        $max = $value[0]['max'] ?? null;
                        $loc = $value[0]['loc'] ?? '';

                        if (str_starts_with($loc, '0-')) {
                            $loc = substr($loc, 2);
                        }

                        if ($loc !== '' && $min !== null && (int) $min > 0) {
                            $isGeoAndMin = (int) $min;
                        }

                        if ($loc !== '' && $max !== null && (int) $max > 0) {
                            $isGeoAndMax = (int) $max;
                        }

                        $selectedCoordinates = explode(',', $loc);

                        if (
                            !isset($item['elements']['laengengrad']) || !isset($item['elements']['breitengrad'])
                            || \count($selectedCoordinates) !== 2
                        ) {
                            continue;
                        }

                        $longitude = (float) ($selectedCoordinates[0]);
                        $latitude = (float) ($selectedCoordinates[1]);

                        $coordinate1 = new Coordinate($item['elements']['laengengrad'], $item['elements']['breitengrad']);
                        $coordinate2 = new Coordinate($longitude, $latitude);
                        $distance = $calculator->getDistance($coordinate1, $coordinate2);

                        if ((int) ($distance / 1_000) > $km) {
                            unset($filteredArray[$index]);

                            break;
                        }

                        $filteredArray[$index]['elements']['geo_distance'] = (int) $distance;
                        if (isset($filteredArrayRaw[$k])) {
                            $filteredArrayRaw[$k]['elements']['geo_distance'] = (int) $distance;
                        }
                    }
                }
            }
        }

        if ($isGeoAndMin > 0 && \count($filteredArray) < $isGeoAndMin) {
            $newFilter = $filter;
            $newFilter['geo'][0]['val'] = 1_000;
            $newFilter['geo'][0]['min'] = 0;
            $cachedResponse['data']['records'] = $filteredArray;
            $cachedResponse['raw']['data']['records'] = $filteredArrayRaw;
            $this->filterRecords($cachedResponse, $newFilter);
            $filteredArray = $this->sortRecords($cachedResponse, $newFilter, 'geo_distance', 'ASC');

            if (\count($filteredArray) > $isGeoAndMin) {
                $filteredArray = \array_slice($filteredArray, 0, $isGeoAndMin);
            }
        } elseif ($isGeoAndMax > 0 && \count($filteredArray) > $isGeoAndMax) {
            $cachedResponse['data']['records'] = $filteredArray;
            $cachedResponse['raw']['data']['records'] = $filteredArrayRaw;
            $filteredArray = $this->sortRecords($cachedResponse, $filter, 'geo_distance', 'ASC');
            $filteredArray = \array_slice($filteredArray, 0, $isGeoAndMax);
        }

        $cachedResponse['data']['records'] = $filteredArray;
        $cachedResponse['raw']['data']['records'] = $filteredArrayRaw;
    }

    /**
     * @param mixed $filterVal
     * @param mixed $rawValue
     */
    private function isBigger($filterVal, $rawValue, string $type): bool
    {
        return $this->isSmaller($filterVal, $rawValue, $type, false);
    }

    /**
     * @param mixed $filterVal
     * @param mixed $rawValue
     */
    private function isSmaller($filterVal, $rawValue, string $type, bool $isSmaller = true): bool
    {
        if ($type === 'float' || $type === 'integer') {
            if ($isSmaller) {
                return (float) $rawValue < (float) $filterVal;
            }

            return (float) $rawValue > (float) $filterVal;
        }

        if ($type === 'date') {
            $dateVal = date_create_from_format('Y-m-d H:i:s', (string) $filterVal);
            $compare = date_create_from_format('Y-m-d', (string) $rawValue);

            if ($isSmaller) {
                return $compare !== false && $compare < $dateVal;
            }

            return $compare !== false && $compare > $dateVal;
        }

        return false;
    }
}
