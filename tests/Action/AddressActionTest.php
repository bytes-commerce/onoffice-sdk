<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Action\AddressAction;
use PHPUnit\Framework\TestCase;

final class AddressActionTest extends TestCase
{
    use ActionTestTrait;

    public function testGetResourceType(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('address'));

        $action = new AddressAction('testtoken', 'testsecret', $sdk);

        $this->assertSame('address', $action->getResourceType());
    }

    public function testGetToken(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('address'));

        $action = new AddressAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mytoken', $action->getToken());
    }

    public function testGetSecret(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('address'));

        $action = new AddressAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mysecret', $action->getSecret());
    }

    public function testReadReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp(
            $this->createSuccessResponse('address', 123),
        );

        $action = new AddressAction('testtoken', 'testsecret', $sdk);

        $result = $action->read(['data' => ['Id', 'Name']]);

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
                        'resourcetype' => 'address',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 456,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new AddressAction('testtoken', 'testsecret', $sdk);

        $result = $action->create(['data' => ['Vorname' => 'Max', 'Name' => 'Mustermann']]);

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
                        'resourcetype' => 'address',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 123,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new AddressAction('testtoken', 'testsecret', $sdk);

        $result = $action->modify('123', ['data' => ['Name' => 'Mueller']]);

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
                        'resourcetype' => 'address',
                        'status' => ['errorcode' => 0],
                        'data' => [],
                    ],
                ],
            ],
        ]);

        $action = new AddressAction('testtoken', 'testsecret', $sdk);

        $result = $action->delete('123');

        $this->assertIsArray($result);
    }

    public function testAutocompleteReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:get',
                        'resourceid' => '',
                        'resourcetype' => 'address',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'records' => [
                                ['id' => 1, 'elements' => ['Vorname' => 'Max', 'Name' => 'Mustermann']],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $action = new AddressAction('testtoken', 'testsecret', $sdk);

        $result = $action->autocomplete(['input' => 'Max']);

        $this->assertIsArray($result);
    }
}
