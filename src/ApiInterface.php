<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice;

use BytesCommerce\OnOffice\Action\AddressAction;
use BytesCommerce\OnOffice\Action\CalendarAction;
use BytesCommerce\OnOffice\Action\EmailAction;
use BytesCommerce\OnOffice\Action\EstateAction;
use BytesCommerce\OnOffice\Action\FileAction;
use BytesCommerce\OnOffice\Action\RelationAction;
use BytesCommerce\OnOffice\Action\SearchCriteriaAction;
use BytesCommerce\OnOffice\Action\TaskAction;
use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Internal\HttpFetch;

interface ApiInterface
{
    public const string ACTION_ID_READ = 'urn:onoffice-de-ns:smart:2.5:smartml:action:read';

    public const string ACTION_ID_CREATE = 'urn:onoffice-de-ns:smart:2.5:smartml:action:create';

    public const string ACTION_ID_MODIFY = 'urn:onoffice-de-ns:smart:2.5:smartml:action:modify';

    public const string ACTION_ID_GET = 'urn:onoffice-de-ns:smart:2.5:smartml:action:get';

    public const string ACTION_ID_DO = 'urn:onoffice-de-ns:smart:2.5:smartml:action:do';

    public const string ACTION_ID_DELETE = 'urn:onoffice-de-ns:smart:2.5:smartml:action:delete';

    public const string RELATION_TYPE_BUYER = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:buyer';

    public const string RELATION_TYPE_TENANT = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:renter';

    public const string RELATION_TYPE_OWNER = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:owner';

    public const string RELATION_TYPE_CONTACT_BROKER = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:contactPerson';

    public const string RELATION_TYPE_CONTACT_PERSON = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:contactPersonAll';

    public const string RELATION_TYPE_COMPLEX_ESTATE_UNITS = 'urn:onoffice-de-ns:smart:2.5:relationTypes:complex:estate:units';

    public const string RELATION_TYPE_ESTATE_ADDRESS_OWNER = 'urn:onoffice-de-ns:smart:2.5:relationTypes:estate:address:owner';

    public const string MODULE_ADDRESS = 'address';

    public const string MODULE_ESTATE = 'estate';

    public const string MODULE_ESTATE_PICTURES = 'estatepictures';

    public const string MODULE_SEARCHCRITERIA = 'searchcriteria';

    public const string MODULE_CALENDAR = 'calendar';

    public const string MODULE_TASK = 'task';

    public const string MODULE_USER = 'user';

    public const string MODULE_AGENTS_LOG = 'agentsLog';

    public const string MODULE_BASIC_SETTINGS = 'basicSettings';

    public const string MODULE_IMPRINT = 'imprint';

    public const string MODULE_USER_RIGHTS = 'userRights';

    public const string MODULE_USER_PHOTO = 'userPhoto';

    public const string MODULE_RECORDS_LAST_SEEN = 'recordsLastSeen';

    public const string MODULE_LOG_ENTRIES = 'logEntries';

    public const string MODULE_ACTIVITY = 'activity';

    public const string MODULE_FILE = 'file';

    public const string MODULE_FILES = 'files';

    public const string MODULE_RELATION = 'relation';

    public const string MODULE_RELATIONS = 'relations';

    public const string MODULE_WORKINGLIST = 'workinglist';

    public const string MODULE_SEARCH = 'search';

    public const string MODULE_FIELDS = 'fields';

    public const string MODULE_TEMPLATE = 'template';

    public const string MODULE_TEMPLATES = 'templates';

    public const string MODULE_EMAIL = 'email';

    public const string MODULE_ATTACHMENT = 'attachment';

    public const string MODULE_ATTACHMENTS = 'attachments';

    public const string MODULE_REGION = 'region';

    public const string MODULE_REGIONS = 'regions';

    public const string MODULE_FILTER = 'filter';

    public const string MODULE_CATEGORY = 'category';

    public const string MODULE_CATEGORIES = 'categories';

    public const string MODULE_RESOURCE = 'resource';

    public const string MODULE_RESOURCES = 'resources';

    public const string MODULE_MAIL_SIGNATURE = 'mailSignature';

    public const string MODULE_EMAIL_TEMPLATE_FOLDER = 'emailTemplateFolder';

    public const string MODULE_SURVEY = 'survey';

    public const string MODULE_MACRO = 'macro';

    public const string MODULE_LINK = 'link';

    public const string MODULE_DOCUMENT = 'document';

    public const string MODULE_DOCUMENTS = 'documents';

    public const string MODULE_SENDMAIL = 'sendmail';

    public const string MODULE_WEBHOOK = 'webhook';

    public const string MODULE_NEWSLETTER = 'newsletter';

    public const string MODULE_PDF = 'pdf';

    public const string MODULE_ACCESS_CONTROL = 'accessControl';

    public const string MODULE_MARKETPLACE = 'marketplace';

    public function setApiVersion(string $apiVersion): void;

    public function setApiServer(string $server): void;

    /** @param array<int, mixed> $curlOptions */
    public function setApiCurlOptions(array $curlOptions): void;

    /** @param array<string, mixed> $parameters */
    public function callGeneric(string $actionId, string $resourceType, array $parameters): int;

    /** @param array<string, mixed> $parameters */
    public function call(
        string $actionId,
        string $resourceId,
        string $identifier,
        string $resourceType,
        array $parameters,
    ): int;

    /**
     * @throws Exception\HttpFetchNoResultException
     */
    public function sendRequests(
        string $token,
        string $secret,
        ?HttpFetch $httpFetch = null,
        bool $saveToCache = true,
        ?string $claim = null,
    ): void;

    /**
     * @throws Exception\HttpFetchNoResultException
     */
    public function sendRequestsWithCredentials(
        bool $saveToCache = true,
        ?string $claim = null,
    ): void;

    /**
     * @throws Exception\ApiCallFaultyResponseException
     *
     * @return array<string, mixed>
     */
    public function getResponseArray(int $number): array;

    public function addCache(cacheInterface $pCache): void;

    /** @param array<int, cacheInterface> $cacheInstances */
    public function setCaches(array $cacheInstances): void;

    public function removeCacheInstances(): void;

    /** @return array<int, mixed> */
    public function getErrors(): array;

    public function getToken(): string;

    public function getSecret(): string;

    public function getEstateAction(): EstateAction;

    public function getAddressAction(): AddressAction;

    public function getTaskAction(): TaskAction;

    public function getCalendarAction(): CalendarAction;

    public function getSearchCriteriaAction(): SearchCriteriaAction;

    public function getFileAction(): FileAction;

    public function getRelationAction(): RelationAction;

    public function getEmailAction(): EmailAction;
}
