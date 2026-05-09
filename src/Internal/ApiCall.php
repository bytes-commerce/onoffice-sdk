<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Internal;

use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Exception\ApiCallFaultyResponseException;
use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use Webmozart\Assert\Assert;

class ApiCall
{
    /** @var array<int, Request> */
    private array $requestQueue = [];

    /** @var array<int, Response> */
    private array $responses = [];

    /** @var array<int, mixed> */
    private array $errors = [];

    private string $apiVersion = 'stable';

    /** @var array<int, cacheInterface> */
    private array $caches = [];

    private ?string $server = null;

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
     * @throws HttpFetchNoResultException
     */
    public function sendRequests(string $token, string $secret, ?HttpFetch $httpFetch = null): void
    {
        Assert::notEmpty($token, 'Token must not be empty');
        Assert::notEmpty($secret, 'Secret must not be empty');

        // Use injected HttpFetch or fall back to stored instance (for testing)
        $httpFetch ??= $this->httpFetch;
        $this->collectOrGatherRequests($token, $secret, $httpFetch);
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
        $this->writeCacheForResponses($idsForCache);
    }

    /**
     * @throws HttpFetchNoResultException
     */
    private function collectOrGatherRequests(string $token, string $secret, ?HttpFetch $httpFetch = null): void
    {
        /** @var array<int, array<string, mixed>> $actionParameters */
        $actionParameters = [];
        /** @var array<int, Request> $actionParametersOrder */
        $actionParametersOrder = [];

        foreach ($this->requestQueue as $requestId => $pRequest) {
            /** @var Request $pRequest */
            $usedParameters = $pRequest->getApiAction()->getActionParameters();
            $cachedResponse = $this->getFromCache($usedParameters);

            if ($cachedResponse === null) {
                $parametersThisAction = $pRequest->createRequest($token, $secret);

                $actionParameters[] = $parametersThisAction;
                $actionParametersOrder[] = $pRequest;
            } else {
                $this->responses[$requestId] = new Response($pRequest, $cachedResponse);
            }
        }

        $this->sendHttpRequests($token, $actionParameters, $actionParametersOrder, $httpFetch);
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
}
