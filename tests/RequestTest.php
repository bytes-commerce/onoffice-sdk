<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests;

use BytesCommerce\OnOffice\Internal\ApiAction;
use BytesCommerce\OnOffice\Internal\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testGetApiAction(): void
    {
        $apiAction = new ApiAction(
            'someActionId',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );
        $request = new Request($apiAction);

        $result = $request->getApiAction();

        $this->assertSame($apiAction, $result);
    }

    public function testCreateRequest(): void
    {
        $secret = 'yOJobbhGLXdp90XxvxedFhH7073L9U';
        $token = 'mgjIQkNRnaqggVzy9cZW';

        $apiAction = new ApiAction(
            'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
            'estateCategories',
            [],
            'someResourceId',
            'someIdentifier',
            123_456_789,
        );

        $request = new Request($apiAction);
        $result = $request->createRequest($token, $secret);

        $this->assertSame(123_456_789, $result['timestamp']);
        $this->assertSame('someResourceId', $result['resourceid']);
        $this->assertSame('someIdentifier', $result['identifier']);
        $this->assertSame([], $result['parameters']);
        $this->assertSame('urn:onoffice-de-ns:smart:2.5:smartml:action:get', $result['actionid']);
        $this->assertSame('estateCategories', $result['resourcetype']);
        $this->assertGreaterThanOrEqual(2, $result['hmac_version']);
        $this->assertSame('dsvg3r4AFcQXges0MZ+3auzQVfnEB39pLkKSgmm9Wvg=', $result['hmac']);
    }

    public function testCreateRequestNoTimestamp(): void
    {
        $secret = 'yOJobbhGLXdp90XxvxedFhH7073L9U';
        $token = 'mgjIQkNRnaqggVzy9cZW';

        $apiAction = new ApiAction(
            'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
            'estateCategories',
            [],
            'someResourceId',
            'someIdentifier',
        );

        $request = new Request($apiAction);
        $result = $request->createRequest($token, $secret);

        $this->assertGreaterThan(0, $result['timestamp']);
        $this->assertSame('someResourceId', $result['resourceid']);
        $this->assertSame('someIdentifier', $result['identifier']);
        $this->assertSame([], $result['parameters']);
        $this->assertSame('urn:onoffice-de-ns:smart:2.5:smartml:action:get', $result['actionid']);
        $this->assertSame('estateCategories', $result['resourcetype']);
        $this->assertGreaterThanOrEqual(2, $result['hmac_version']);
        $this->assertNotEmpty($result['hmac']);
    }

    public function testGetRequestId(): void
    {
        $apiAction1 = new ApiAction(
            'someActionId1',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );
        $request1 = new Request($apiAction1);

        $apiAction2 = new ApiAction(
            'someActionId2',
            'someResourceType',
            [],
            'someResourceId',
            'someIdentifier',
        );
        $request2 = new Request($apiAction2);

        $this->assertSame(0, $request1->getRequestId());
        $this->assertSame(1, $request2->getRequestId());
    }
}
