<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Internal;

use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Exception\ApiCallFaultyResponseException;
use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use BytesCommerce\OnOffice\Internal\ApiAction;
use BytesCommerce\OnOffice\Internal\ApiCall;
use BytesCommerce\OnOffice\Internal\HttpFetch;
use BytesCommerce\OnOffice\Internal\Request;
use BytesCommerce\OnOffice\Internal\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class ApiCallTest extends TestCase
{
    public function testCallByRawData(): void
    {
        $apiCall = new ApiCall();

        $result = $apiCall->callByRawData(
            'someActionId',
            'someResourceId',
            'someIdentifier',
            'someResourceType',
            [],
        );

        $this->assertSame(0, $result);
    }

    public function testCallByRawDataIncrementsRequestId(): void
    {
        $apiCall = new ApiCall();

        $result1 = $apiCall->callByRawData('action1', '', '', 'type1', []);
        $result2 = $apiCall->callByRawData('action2', '', '', 'type2', []);
        $result3 = $apiCall->callByRawData('action3', '', '', 'type3', []);

        $this->assertSame(0, $result1);
        $this->assertSame(1, $result2);
        $this->assertSame(2, $result3);
    }

    public function testCallByRawDataFromCache(): void
    {
        $apiCall = new ApiCall();

        $result = $apiCall->callByRawDataFromCache(
            'someActionId',
            'someResourceId',
            'someIdentifier',
            'someResourceType',
            ['key' => 'value'],
        );

        $this->assertNull($result);
    }

    public function testSendRequests(): void
    {
        $apiCall = new ApiCall();

        $httpFetch = $this->getMockBuilder(HttpFetch::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['send'])
            ->getMock();

        $apiCall->callByRawData(
            'someActionId',
            'someResourceId',
            'someIdentifier',
            'someResourceType',
            [],
        );

        $array = [
            'response' => [
                'results' => [
                    0 => [
                        'status' => [
                            'errorcode' => 0,
                        ],
                    ],
                ],
            ],
        ];

        $httpFetch
            ->expects($this->once())
            ->method('send')
            ->willReturn(json_encode($array));

        $apiCall->sendRequests(
            'someToken',
            'someSecret',
            $httpFetch,
        );
    }

    public function testSendRequestsWithErrorResponse(): void
    {
        $apiCall = new ApiCall();

        $httpFetch = $this->getMockBuilder(HttpFetch::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['send'])
            ->getMock();

        $apiCall->callByRawData(
            'someActionId',
            'someResourceId',
            'someIdentifier',
            'someResourceType',
            [],
        );

        $array = [
            'response' => [
                'results' => [
                    0 => [
                        'status' => [
                            'errorcode' => 141,
                            'message' => 'Unknown field',
                        ],
                    ],
                ],
            ],
        ];

        $httpFetch
            ->expects($this->once())
            ->method('send')
            ->willReturn(json_encode($array));

        $apiCall->sendRequests(
            'someToken',
            'someSecret',
            $httpFetch,
        );

        $errors = $apiCall->getErrors();
        $this->assertNotEmpty($errors);
        $this->assertArrayHasKey(0, $errors);
    }

    public function testSendRequestsWithoutCallByRawData(): void
    {
        $apiCall = new ApiCall();

        $httpFetch = $this->getMockBuilder(HttpFetch::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['send'])
            ->getMock();

        $httpFetch
            ->expects($this->never())
            ->method('send');

        $apiCall->sendRequests(
            'someToken',
            'someSecret',
            $httpFetch,
        );
    }

    public function testSendRequestsWithoutProperResponse(): void
    {
        $this->expectException(HttpFetchNoResultException::class);

        $apiCall = new ApiCall();

        $httpFetch = $this->getMockBuilder(HttpFetch::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['send'])
            ->getMock();

        $apiCall->callByRawData(
            'someActionId',
            'someResourceId',
            'someIdentifier',
            'someResourceType',
            [],
        );

        $array = [
            'response' => [],
        ];

        $httpFetch
            ->expects($this->once())
            ->method('send')
            ->willReturn(json_encode($array));

        $apiCall->sendRequests(
            'someToken',
            'someSecret',
            $httpFetch,
        );
    }

    public function testGetResponseReturnsEmptyArrayForUnknownHandle(): void
    {
        $apiCall = new ApiCall();

        $result = $apiCall->getResponse(999);

        $this->assertSame([], $result);
    }

    public function testGetResponseReturnsData(): void
    {
        $apiCall = new ApiCall();

        $apiAction = new ApiAction('actionId', 'resourceType', [], 'resourceId', 'identifier');
        $request = new Request($apiAction);
        $response = new Response($request, [
            'actionid' => 'actionId',
            'resourcetype' => 'resourceType',
            'data' => ['key' => 'value'],
        ]);

        // Use reflection to set the responses array
        $reflection = new ReflectionClass($apiCall);
        $responsesProperty = $reflection->getProperty('responses');
        $responsesProperty->setAccessible(true);
        $responsesProperty->setValue($apiCall, [0 => $response]);

        $result = $apiCall->getResponse(0);

        $this->assertArrayHasKey('data', $result);
        $this->assertSame(['key' => 'value'], $result['data']);
    }

    public function testGetResponseRemovesResponseAfterRetrieval(): void
    {
        $apiCall = new ApiCall();

        $apiAction = new ApiAction('actionId', 'resourceType', [], 'resourceId', 'identifier');
        $request = new Request($apiAction);
        $response = new Response($request, [
            'actionid' => 'actionId',
            'resourcetype' => 'resourceType',
            'data' => ['key' => 'value'],
        ]);

        $reflection = new ReflectionClass($apiCall);
        $responsesProperty = $reflection->getProperty('responses');
        $responsesProperty->setAccessible(true);
        $responsesProperty->setValue($apiCall, [0 => $response]);

        $apiCall->getResponse(0);

        $responses = $responsesProperty->getValue($apiCall);
        $this->assertArrayNotHasKey(0, $responses);
    }

    public function testGetResponseThrowsExceptionForInvalidResponse(): void
    {
        $this->expectException(ApiCallFaultyResponseException::class);

        $apiCall = new ApiCall();

        $apiAction = new ApiAction('actionId', 'resourceType', [], 'resourceId', 'identifier');
        $request = new Request($apiAction);
        $response = new Response($request, []); // Invalid - missing actionid, resourcetype, data

        $reflection = new ReflectionClass($apiCall);
        $responsesProperty = $reflection->getProperty('responses');
        $responsesProperty->setAccessible(true);
        $responsesProperty->setValue($apiCall, [0 => $response]);

        $apiCall->getResponse(0);
    }

    public function testSetApiVersion(): void
    {
        $apiCall = new ApiCall();
        $apiCall->setApiVersion('v1');

        $reflection = new ReflectionClass($apiCall);
        $apiVersionProperty = $reflection->getProperty('apiVersion');
        $apiVersionProperty->setAccessible(true);

        $this->assertSame('v1', $apiVersionProperty->getValue($apiCall));
    }

    public function testSetServer(): void
    {
        $apiCall = new ApiCall();
        $apiCall->setServer('https://api.example.com/');

        $reflection = new ReflectionClass($apiCall);
        $serverProperty = $reflection->getProperty('server');
        $serverProperty->setAccessible(true);

        $this->assertSame('https://api.example.com/', $serverProperty->getValue($apiCall));
    }

    public function testAddCache(): void
    {
        $apiCall = new ApiCall();

        $cache = $this->getMockBuilder(cacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiCall->addCache($cache);

        $reflection = new ReflectionClass($apiCall);
        $cachesProperty = $reflection->getProperty('caches');
        $cachesProperty->setAccessible(true);

        $caches = $cachesProperty->getValue($apiCall);
        $this->assertCount(1, $caches);
    }

    public function testRemoveCacheInstances(): void
    {
        $apiCall = new ApiCall();

        $cache = $this->getMockBuilder(cacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiCall->addCache($cache);
        $apiCall->removeCacheInstances();

        $reflection = new ReflectionClass($apiCall);
        $cachesProperty = $reflection->getProperty('caches');
        $cachesProperty->setAccessible(true);

        $caches = $cachesProperty->getValue($apiCall);
        $this->assertCount(0, $caches);
    }

    public function testGetErrorsReturnsEmptyArrayInitially(): void
    {
        $apiCall = new ApiCall();
        $result = $apiCall->getErrors();

        $this->assertSame([], $result);
    }

    public function testGetErrorsReturnsErrorsAfterFailedRequest(): void
    {
        $apiCall = new ApiCall();

        $httpFetch = $this->getMockBuilder(HttpFetch::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['send'])
            ->getMock();

        $apiCall->callByRawData('actionId', '', '', 'resourceType', []);

        $array = [
            'response' => [
                'results' => [
                    0 => [
                        'status' => [
                            'errorcode' => 141,
                            'message' => 'Error occurred',
                        ],
                    ],
                ],
            ],
        ];

        $httpFetch
            ->expects($this->once())
            ->method('send')
            ->willReturn(json_encode($array));

        $apiCall->sendRequests('token', 'secret', $httpFetch);

        $errors = $apiCall->getErrors();
        $this->assertNotEmpty($errors);
    }
}
