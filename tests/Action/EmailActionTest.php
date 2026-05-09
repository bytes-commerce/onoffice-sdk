<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Action;

use BytesCommerce\OnOffice\Action\EmailAction;
use PHPUnit\Framework\TestCase;

final class EmailActionTest extends TestCase
{
    use ActionTestTrait;

    public function testGetResourceType(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('sendmail'));

        $action = new EmailAction('testtoken', 'testsecret', $sdk);

        $this->assertSame('sendmail', $action->getResourceType());
    }

    public function testGetToken(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('sendmail'));

        $action = new EmailAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mytoken', $action->getToken());
    }

    public function testGetSecret(): void
    {
        $sdk = $this->createSdkWithMockedHttp($this->createSuccessResponse('sendmail'));

        $action = new EmailAction('mytoken', 'mysecret', $sdk);

        $this->assertSame('mysecret', $action->getSecret());
    }

    public function testSendReturnsArray(): void
    {
        $sdk = $this->createSdkWithMockedHttp([
            'response' => [
                'results' => [
                    0 => [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:do',
                        'resourceid' => '',
                        'resourcetype' => 'sendmail',
                        'status' => ['errorcode' => 0],
                        'data' => [
                            'sent' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $action = new EmailAction('testtoken', 'testsecret', $sdk);

        $result = $action->send([
            'emailidentity' => 'default',
            'receiver' => ['info@example.com'],
            'subject' => 'Test',
            'body' => 'Hello',
        ]);

        $this->assertIsArray($result);
    }
}
