<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests;

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\Cache\cacheInterface;
use BytesCommerce\OnOffice\Internal\ApiCall;
use PHPUnit\Framework\TestCase;

final class OnOfficeSDKTest extends TestCase
{
    public function testCreationOfClient(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        new Api('token', 'secret', $apiCall);
    }

    public function testSetApiVerision(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer', 'setApiVersion'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        $apiCall->expects($this->once())
            ->method('setApiVersion')
            ->with('v1');

        $onOfficeSdk = new Api('token', 'secret', $apiCall);
        $onOfficeSdk->setApiVersion('v1');
    }

    public function testSetApiCurlOptions(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer', 'setCurlOptions'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        $apiCall->expects($this->once())
            ->method('setCurlOptions')
            ->with(['some', 'actions']);

        $onOfficeSdk = new Api('token', 'secret', $apiCall);
        $onOfficeSdk->setApiCurlOptions(['some', 'actions']);
    }

    public function testCallGeneric(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer', 'callByRawData'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        $apiCall->expects($this->once())
            ->method('callByRawData')
            ->with(
                'someActionId',
                '',
                '',
                'someResourceType',
                ['key' => 'value'],
            );

        $onOfficeSdk = new Api('token', 'secret', $apiCall);
        $onOfficeSdk->callGeneric(
            'someActionId',
            'someResourceType',
            ['key' => 'value'],
        );
    }

    public function testSendRequests(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer', 'sendRequests'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        $apiCall->expects($this->once())
            ->method('sendRequests')
            ->with(
                'someToken',
                'someSecret',
            );

        $onOfficeSdk = new Api('token', 'secret', $apiCall);
        $onOfficeSdk->sendRequests(
            'someToken',
            'someSecret',
        );
    }

    public function testGetResponseArray(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer', 'getResponse'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        $apiCall->expects($this->once())
            ->method('getResponse')
            ->with(1)
            ->willReturn(['some', 'response']);

        $onOfficeSdk = new Api('token', 'secret', $apiCall);
        $result = $onOfficeSdk->getResponseArray(1);

        $this->assertSame(['some', 'response'], $result);
    }

    public function testAddCache(): void
    {
        $apiCall = $this->getMockBuilder(ApiCall::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['setServer', 'addCache'])
            ->getMock();

        $apiCall->expects($this->never())
            ->method('setServer');

        $cache = $this->getMockBuilder(cacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiCall->expects($this->once())
            ->method('addCache')
            ->with($cache);

        $onOfficeSdk = new Api('token', 'secret', $apiCall);

        $onOfficeSdk->addCache($cache);
    }
}
