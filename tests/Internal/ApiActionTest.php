<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Internal;

use BytesCommerce\OnOffice\Internal\ApiAction;
use PHPUnit\Framework\TestCase;

final class ApiActionTest extends TestCase
{
    public function testBasicConstruction(): void
    {
        $action = new ApiAction(
            'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
            'estate',
            ['param1' => 'value1'],
            'resource123',
            'identifier1',
        );

        $params = $action->getActionParameters();

        $this->assertSame('urn:onoffice-de-ns:smart:2.5:smartml:action:get', $params['actionid']);
        $this->assertSame('estate', $params['resourcetype']);
        $this->assertSame('resource123', $params['resourceid']);
        $this->assertSame('identifier1', $params['identifier']);
        $this->assertSame('value1', $params['parameters']['param1']);
    }

    public function testParametersAreSorted(): void
    {
        $action = new ApiAction(
            'actionId',
            'resourceType',
            ['z' => 1, 'a' => 2, 'm' => 3],
        );

        $params = $action->getActionParameters();
        $keys = array_keys($params['parameters']);

        $this->assertSame(['a', 'm', 'z'], $keys);
    }

    public function testGetIdentifierReturnsMd5(): void
    {
        $action = new ApiAction(
            'actionId',
            'resourceType',
            ['key' => 'value'],
        );

        $identifier = $action->getIdentifier();

        $this->assertNotEmpty($identifier);
        $this->assertSame(32, \strlen($identifier)); // MD5 hash length
    }

    public function testGetIdentifierIsConsistent(): void
    {
        $action = new ApiAction(
            'actionId',
            'resourceType',
            ['key' => 'value'],
        );

        $identifier1 = $action->getIdentifier();
        $identifier2 = $action->getIdentifier();

        $this->assertSame($identifier1, $identifier2);
    }

    public function testDifferentParametersProduceDifferentIdentifiers(): void
    {
        $action1 = new ApiAction(
            'actionId',
            'resourceType',
            ['key' => 'value1'],
        );

        $action2 = new ApiAction(
            'actionId',
            'resourceType',
            ['key' => 'value2'],
        );

        $this->assertNotSame($action1->getIdentifier(), $action2->getIdentifier());
    }

    public function testEmptyParameters(): void
    {
        $action = new ApiAction(
            'actionId',
            'resourceType',
            [],
        );

        $params = $action->getActionParameters();

        $this->assertSame([], $params['parameters']);
    }

    public function testTimestampIsStored(): void
    {
        $timestamp = 1_234_567_890;
        $action = new ApiAction(
            'actionId',
            'resourceType',
            [],
            '',
            '',
            $timestamp,
        );

        $params = $action->getActionParameters();

        $this->assertSame($timestamp, $params['timestamp']);
    }
}
