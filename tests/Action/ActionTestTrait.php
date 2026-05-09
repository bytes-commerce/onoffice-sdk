<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\Internal\ApiCall;
use BytesCommerce\OnOffice\Internal\HttpFetch;
use ReflectionClass;

trait ActionTestTrait
{
    /**
     * @param array<string, mixed> $response
     */
    protected function createSdkWithMockedHttp(array $response): Api
    {
        $apiCall = new ApiCall();
        $apiCall->setServer('https://api.onoffice.de/api/');

        /** @var array<string, mixed> $responseData */
        $responseData = $response;

        $httpFetch = new class($responseData) extends HttpFetch {
            /**
             * @param array<string, mixed> $response
             */
            public function __construct(
                /** @var array<string, mixed> */
                private readonly array $response,
            ) {
                parent::__construct('https://example.com/api', '');
            }

            public function send(): string
            {
                $encoded = json_encode($this->response);
                \assert($encoded !== false);

                return $encoded;
            }
        };

        $reflection = new ReflectionClass($apiCall);
        $httpFetchProperty = $reflection->getProperty('httpFetch');
        $httpFetchProperty->setAccessible(true);
        $httpFetchProperty->setValue($apiCall, $httpFetch);

        return new Api('testtoken', 'testsecret', $apiCall);
    }

    /**
     * @return array<string, mixed>
     */
    protected function createSuccessResponse(string $resourceType, int $id = 123): array
    {
        return [
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:read',
                        'resourceid' => (string) $id,
                        'resourcetype' => $resourceType,
                        'status' => [
                            'errorcode' => 0,
                        ],
                        'data' => [
                            'meta' => ['cntabsolute' => 1],
                            'records' => [
                                [
                                    'id' => $id,
                                    'type' => $resourceType,
                                    'elements' => ['id' => $id, 'name' => 'Test'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
