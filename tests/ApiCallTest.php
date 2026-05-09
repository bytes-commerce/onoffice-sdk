<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests;

use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Exception\HttpFetchNoResultException;
use BytesCommerce\OnOffice\Internal\ApiCall;
use BytesCommerce\OnOffice\Internal\HttpFetch;
use PHPUnit\Framework\TestCase;

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

    public function testSendRequestsWithoutProperresponse(): void
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

    /**
     * @doesNotPerformAssertions
     */
    public function testSetApiVersion(): void
    {
        $apiCall = new ApiCall();
        $apiCall->setApiVersion('v1');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testAddCache(): void
    {
        $cache = $this->getMockBuilder(cacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiCall = new ApiCall();
        $apiCall->addCache($cache);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testRemoveCacheInstances(): void
    {
        $cache = $this->getMockBuilder(cacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiCall = new ApiCall();
        $apiCall->addCache($cache);
        $apiCall->removeCacheInstances();
    }

    public function testGetErrors(): void
    {
        $apiCall = new ApiCall();
        $result = $apiCall->getErrors();

        $this->assertSame([], $result);
    }
}
