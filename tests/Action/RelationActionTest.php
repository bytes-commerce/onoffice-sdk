<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Action\RelationAction;
use PHPUnit\Framework\TestCase;

final class RelationActionTest extends TestCase
{
    use ActionTestTrait;

    public function testGetResourceType(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('relations'));

        $action = new RelationAction('testtoken', 'testsecret', $sdk);

        $this->assertSame('relations', $action->getResourceType());
    }

    public function testGetToken(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('relations'));

        $action = new RelationAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mytoken', $action->getToken());
    }

    public function testGetSecret(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('relations'));

        $action = new RelationAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mysecret', $action->getSecret());
    }

    public function testCreateReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:create',
                        'resourceid' => '456',
                        'resourcetype' => 'relations',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 456,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new RelationAction('testtoken', 'testsecret', $sdk);

        $result = $action->create(['data' => ['type' => 'address_estate']]);

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
                        'resourcetype' => 'relations',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 123,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new RelationAction('testtoken', 'testsecret', $sdk);

        $result = $action->modify('123', ['data' => ['type' => 'updated']]);

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
                        'resourcetype' => 'relations',
                        'status' => ['errorcode' => 0],
                        'data' => [],
                    ],
                ],
            ],
        ]);

        $action = new RelationAction('testtoken', 'testsecret', $sdk);

        $result = $action->delete('123');

        $this->assertIsArray($result);
    }

    public function testGetRelationsReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
                        'resourceid' => '',
                        'resourcetype' => 'relations',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'records' => [
                                ['id' => 1, 'elements' => ['type' => 'address_estate']],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $action = new RelationAction('testtoken', 'testsecret', $sdk);

        $result = $action->getRelations(['addressid' => 123]);

        $this->assertIsArray($result);
    }
}
