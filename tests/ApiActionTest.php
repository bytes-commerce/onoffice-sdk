<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests;

use BytesCommerce\OnOffice\Internal\ApiAction;
use PHPUnit\Framework\TestCase;

final class ApiActionTest extends TestCase
{
    public function testDefaultCreationOfActionParameters(): void
    {
        $parameters = [
            'param1' => 'value1',
            [
                'param2' => 'value2',
                'param3' => 'value3',
            ],
        ];

        $apiAction = new ApiAction(
            'someId',
            'someResource',
            $parameters,
        );

        $result = $apiAction->getActionParameters();

        $expectation = [
            'actionid' => 'someId',
            'identifier' => '',
            'parameters' => [
                0 => [
                    'param2' => 'value2',
                    'param3' => 'value3',
                ],
                'param1' => 'value1',
            ],
            'resourceid' => '',
            'resourcetype' => 'someResource',
            'timestamp' => null,
        ];

        $this->assertSame($expectation, $result);
    }

    public function testDefaultIdentifier(): void
    {
        $parameters = [
            'param1' => 'value1',
            [
                'param2' => 'value2',
                'param3' => 'value3',
            ],
        ];

        $apiAction = new ApiAction(
            'someId',
            'someResource',
            $parameters,
        );

        $result = $apiAction->getIdentifier();

        $this->assertSame('8c8a08db3ca981db988963cd0bdf8006', $result);
    }

    public function testCustomCreationOfActionParameters(): void
    {
        $parameters = [
            'param1' => 'value1',
            [
                'param2' => 'value2',
                'param3' => 'value3',
            ],
        ];

        $apiAction = new ApiAction(
            'someId',
            'someResource',
            $parameters,
            'someResourceId',
            'someIdentifier',
        );

        $result = $apiAction->getActionParameters();

        $expectation = [
            'actionid' => 'someId',
            'identifier' => 'someIdentifier',
            'parameters' => [
                0 => [
                    'param2' => 'value2',
                    'param3' => 'value3',
                ],
                'param1' => 'value1',
            ],
            'resourceid' => 'someResourceId',
            'resourcetype' => 'someResource',
            'timestamp' => null,
        ];

        $this->assertSame($expectation, $result);
    }

    public function testCustomIdentifier(): void
    {
        $parameters = [
            'param1' => 'value1',
            [
                'param2' => 'value2',
                'param3' => 'value3',
            ],
        ];

        $apiAction = new ApiAction(
            'someId',
            'someResource',
            $parameters,
            'someResourceId',
            'someIdentifier',
            123,
        );

        $result = $apiAction->getIdentifier();

        $this->assertSame('792d0a7688b6cc242cab01ed52f2f949', $result);
    }
}
