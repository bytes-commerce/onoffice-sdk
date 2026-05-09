<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Action\SearchCriteriaAction;
use PHPUnit\Framework\TestCase;

final class SearchCriteriaActionTest extends TestCase
{
    use ActionTestTrait;

    public function testGetResourceType(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('searchcriteria'));

        $action = new SearchCriteriaAction('testtoken', 'testsecret', $sdk);

        $this->assertSame('searchcriteria', $action->getResourceType());
    }

    public function testGetToken(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('searchcriteria'));

        $action = new SearchCriteriaAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mytoken', $action->getToken());
    }

    public function testGetSecret(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('searchcriteria'));

        $action = new SearchCriteriaAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mysecret', $action->getSecret());
    }

    public function testReadReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp(
            $this->createSuccessResponse('searchcriteria', 123),
        );

        $action = new SearchCriteriaAction('testtoken', 'testsecret', $sdk);

        $result = $action->read(['data' => ['Id', 'objektart']]);

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
                        'resourcetype' => 'searchcriteria',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 456,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new SearchCriteriaAction('testtoken', 'testsecret', $sdk);

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
                        'resourcetype' => 'searchcriteria',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'id' => 123,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new SearchCriteriaAction('testtoken', 'testsecret', $sdk);

        $result = $action->modify('123', ['data' => ['objektart' => 'wohnung']]);

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
                        'resourcetype' => 'searchcriteria',
                        'status' => ['errorcode' => 0],
                        'data' => [],
                    ],
                ],
            ],
        ]);

        $action = new SearchCriteriaAction('testtoken', 'testsecret', $sdk);

        $result = $action->delete('123');

        $this->assertIsArray($result);
    }
}
