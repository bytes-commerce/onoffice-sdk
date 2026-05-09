<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Action\FileAction;
use PHPUnit\Framework\TestCase;

final class FileActionTest extends TestCase
{
    use ActionTestTrait;

    public function testGetResourceType(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('file'));

        $action = new FileAction('testtoken', 'testsecret', $sdk);

        $this->assertSame('file', $action->getResourceType());
    }

    public function testGetToken(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('file'));

        $action = new FileAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mytoken', $action->getToken());
    }

    public function testGetSecret(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('file'));

        $action = new FileAction('mytoken', 'mysecret', $sdk);

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
                        'resourcetype' => 'file',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 456,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new FileAction('testtoken', 'testsecret', $sdk);

        $result = $action->create(['data' => ['title' => 'Document']]);

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
                        'resourcetype' => 'file',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 123,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new FileAction('testtoken', 'testsecret', $sdk);

        $result = $action->modify('123', ['data' => ['title' => 'Updated Title']]);

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
                        'resourcetype' => 'file',
                        'status' => ['errorcode' => 0],
                        'data' => [],
                    ],
                ],
            ],
        ]);

        $action = new FileAction('testtoken', 'testsecret', $sdk);

        $result = $action->delete('123');

        $this->assertIsArray($result);
    }

    public function testUploadReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:do',
                        'resourceid' => '',
                        'resourcetype' => 'file',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'uploaded' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new FileAction('testtoken', 'testsecret', $sdk);

        $result = $action->upload(['filename' => 'test.pdf']);

        $this->assertIsArray($result);
    }
}
