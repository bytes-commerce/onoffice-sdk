<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests;

use BytesCommerce\OnOffice\Internal\ApiAction;
use BytesCommerce\OnOffice\Internal\Request;
use BytesCommerce\OnOffice\Internal\Response;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testIsValid(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, [
            'actionid' => 'someActionId',
            'resourcetype' => 'someResourceType',
            'data' => 'someData',
        ]);

        $result = $response->isValid();

        $this->assertTrue($result);
    }

    public function testIsInvalid(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, []);

        $result = $response->isValid();

        $this->assertFalse($result);
    }

    public function testIsNotCacheable(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, [
            'actionid' => 'someActionId',
            'resourcetype' => 'someResourceType',
            'data' => 'someData',
            'cacheable' => true,
        ]);

        $result = $response->isCacheable();

        $this->assertTrue($result);
    }

    public function testIsNotCacheableBecauseResponseHasBooleanFlag(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, [
            'actionid' => 'someActionId',
            'resourcetype' => 'someResourceType',
            'data' => 'someData',
            'cacheable' => false,
        ]);

        $result = $response->isCacheable();

        $this->assertFalse($result);
    }

    public function testIsNotCacheableBecauseResponseIsInvalid(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, [
            'cacheable' => true,
        ]);

        $result = $response->isCacheable();

        $this->assertFalse($result);
    }

    public function testIsNotCacheableBecauseResponseBooleanFlagIsMissing(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, [
            'actionid' => 'someActionId',
            'resourcetype' => 'someResourceType',
            'data' => 'someData',
        ]);

        $result = $response->isCacheable();

        $this->assertFalse($result);
    }

    public function testGetRequest(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $response = new Response($request, [
            'actionid' => 'someActionId',
            'resourcetype' => 'someResourceType',
            'data' => 'someData',
        ]);

        $result = $response->getRequest();

        $this->assertSame($request, $result);
    }

    public function testGetResponseData(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);

        $responseData = [
            'actionid' => 'someActionId',
            'resourcetype' => 'someResourceType',
            'data' => 'someData',
        ];

        $response = new Response(
            $request,
            $responseData,
        );

        $result = $response->getResponseData();

        $this->assertSame($responseData, $result);
    }
}
