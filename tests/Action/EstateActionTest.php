<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Action\EstateAction;
use PHPUnit\Framework\TestCase;

final class EstateActionTest extends TestCase
{
    use ActionTestTrait;

    public function testReadReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp(
            $this->createSuccessResponse('estate', 123),
        );

        $action = new EstateAction('testtoken', 'testsecret', $sdk);

        $result = $action->read(['data' => ['Id', 'kaufpreis']]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('data', $result);
    }

    public function testCreateReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:create',
                        'resourceid' => '456',
                        'resourcetype' => 'estate',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 456,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new EstateAction('testtoken', 'testsecret', $sdk);

        $result = $action->create(['data' => ['objektart' => 'haus']]);

        $this->assertIsArray($result);
    }

    public function testModifyReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:modify',
                        'resourceid' => '123',
                        'resourcetype' => 'estate',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 123,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new EstateAction('testtoken', 'testsecret', $sdk);

        $result = $action->modify('123', ['data' => ['kaufpreis' => 300_000]]);

        $this->assertIsArray($result);
    }

    public function testDeleteReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:delete',
                        'resourceid' => '123',
                        'resourcetype' => 'estate',
                        'status' => ['errorcode' => 0],
                        'data' => [],
                    ],
                ],
            ],
        ]);

        $action = new EstateAction('testtoken', 'testsecret', $sdk);

        $result = $action->delete('123');

        $this->assertIsArray($result);
    }

    public function testQuickSearchReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
                        'resourceid' => '',
                        'resourcetype' => 'search',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'records' => [
                                ['id' => 1, 'elements' => ['ort' => 'Berlin']],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $action = new EstateAction('testtoken', 'testsecret', $sdk);

        $result = $action->quickSearch(['input' => 'Berlin']);

        $this->assertIsArray($result);
    }

    public function testGetResourceType(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('estate'));

        $action = new EstateAction('testtoken', 'testsecret', $sdk);

        $this->assertSame('estate', $action->getResourceType());
    }

    public function testGetToken(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('estate'));

        $action = new EstateAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mytoken', $action->getToken());
    }

    public function testGetSecret(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('estate'));

        $action = new EstateAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mysecret', $action->getSecret());
    }
}
