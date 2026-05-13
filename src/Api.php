<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice;

use BytesCommerce\OnOffice\Action\ActionInterface;
use BytesCommerce\OnOffice\Action\AddressAction;
use BytesCommerce\OnOffice\Action\CalendarAction;
use BytesCommerce\OnOffice\Action\EmailAction;
use BytesCommerce\OnOffice\Action\EstateAction;
use BytesCommerce\OnOffice\Action\FileAction;
use BytesCommerce\OnOffice\Action\RelationAction;
use BytesCommerce\OnOffice\Action\SearchCriteriaAction;
use BytesCommerce\OnOffice\Action\TaskAction;
use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Factory\ActionFactory;
use BytesCommerce\OnOffice\Internal\ApiCall;
use BytesCommerce\OnOffice\Internal\HttpFetch;
use SensitiveParameter;

class Api implements ApiInterface
{
    private ApiCall $apiCall;

    private string $token;

    private string $secret;

    private ActionFactory $actionFactory;

    /** @var array<string, ActionInterface> */
    private array $actionCache = [];

    public function __construct(
        #[SensitiveParameter]
        string $token,
        #[SensitiveParameter]
        string $secret,
        ?ApiCall $apiCall = null,
    ) {
        $this->token = $token;
        $this->secret = $secret;

        if (!$apiCall instanceof ApiCall) {
            $apiCall = new ApiCall();
            $apiCall->setServer('https://api.onoffice.de/api/');
        }
        $this->apiCall = $apiCall;
        $this->actionFactory = new ActionFactory();
    }

    public function setApiVersion(string $apiVersion): void
    {
        $this->apiCall->setApiVersion($apiVersion);
    }

    public function setApiServer(string $server): void
    {
        $this->apiCall->setServer($server);
    }

    /** @param array<int, mixed> $curlOptions */
    public function setApiCurlOptions(array $curlOptions): void
    {
        $this->apiCall->setCurlOptions($curlOptions);
    }

    /** @param array<string, mixed> $parameters */
    public function callGeneric(string $actionId, string $resourceType, array $parameters): int
    {
        return $this->apiCall->callByRawData($actionId, '', '', $resourceType, $parameters);
    }

    /** @param array<string, mixed> $parameters */
    public function call(string $actionId, string $resourceId, string $identifier, string $resourceType, array $parameters): int
    {
        return $this->apiCall->callByRawData($actionId, $resourceId, $identifier, $resourceType, $parameters);
    }

    /**
     * @throws Exception\HttpFetchNoResultException
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
        $this->apiCall->sendRequests($token, $secret, $httpFetch, $saveToCache, $claim);
    }

    /**
     * @throws Exception\HttpFetchNoResultException
     */
    public function sendRequestsWithCredentials(
        bool $saveToCache = true,
        ?string $claim = null,
    ): void {
        $this->apiCall->sendRequests($this->token, $this->secret, null, $saveToCache, $claim);
    }

    /**
     * @throws Exception\ApiCallFaultyResponseException
     *
     * @return array<string, mixed>
     */
    public function getResponseArray(int $number): array
    {
        return $this->apiCall->getResponse($number);
    }

    public function addCache(cacheInterface $pCache): void
    {
        $this->apiCall->addCache($pCache);
    }

    /** @param array<int, cacheInterface> $cacheInstances */
    public function setCaches(array $cacheInstances): void
    {
        array_map([$this->apiCall, 'addCache'], $cacheInstances);
    }

    public function removeCacheInstances(): void
    {
        $this->apiCall->removeCacheInstances();
    }

    /** @return array<int, mixed> */
    public function getErrors(): array
    {
        return $this->apiCall->getErrors();
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getEstateAction(): EstateAction
    {
        return $this->getAction(EstateAction::class);
    }

    public function getAddressAction(): AddressAction
    {
        return $this->getAction(AddressAction::class);
    }

    public function getTaskAction(): TaskAction
    {
        return $this->getAction(TaskAction::class);
    }

    public function getCalendarAction(): CalendarAction
    {
        return $this->getAction(CalendarAction::class);
    }

    public function getSearchCriteriaAction(): SearchCriteriaAction
    {
        return $this->getAction(SearchCriteriaAction::class);
    }

    public function getFileAction(): FileAction
    {
        return $this->getAction(FileAction::class);
    }

    public function getRelationAction(): RelationAction
    {
        return $this->getAction(RelationAction::class);
    }

    public function getEmailAction(): EmailAction
    {
        return $this->getAction(EmailAction::class);
    }

    /**
     * @template T of ActionInterface
     *
     * @param class-string<T> $actionClass
     *
     * @return T
     */
    private function getAction(string $actionClass): ActionInterface
    {
        if (!isset($this->actionCache[$actionClass])) {
            $sdk = new self($this->token, $this->secret, $this->apiCall);
            /** @var T */
            $action = $this->actionFactory->create(
                $actionClass,
                $this->token,
                $this->secret,
                $sdk,
            );
            $this->actionCache[$actionClass] = $action;
        }

        return $this->actionCache[$actionClass];
    }
}
