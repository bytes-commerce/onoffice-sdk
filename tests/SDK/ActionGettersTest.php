<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\SDK;

use BytesCommerce\OnOffice\Action\AddressAction;
use BytesCommerce\OnOffice\Action\CalendarAction;
use BytesCommerce\OnOffice\Action\EmailAction;
use BytesCommerce\OnOffice\Action\EstateAction;
use BytesCommerce\OnOffice\Action\FileAction;
use BytesCommerce\OnOffice\Action\RelationAction;
use BytesCommerce\OnOffice\Action\SearchCriteriaAction;
use BytesCommerce\OnOffice\Action\TaskAction;
use BytesCommerce\OnOffice\Api;
use PHPUnit\Framework\TestCase;

final class ActionGettersTest extends TestCase
{
    public function testGetEstateAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getEstateAction();

        $this->assertInstanceOf(EstateAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetAddressAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getAddressAction();

        $this->assertInstanceOf(AddressAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetCalendarAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getCalendarAction();

        $this->assertInstanceOf(CalendarAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetTaskAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getTaskAction();

        $this->assertInstanceOf(TaskAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetSearchCriteriaAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getSearchCriteriaAction();

        $this->assertInstanceOf(SearchCriteriaAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetFileAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getFileAction();

        $this->assertInstanceOf(FileAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetRelationAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getRelationAction();

        $this->assertInstanceOf(RelationAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testGetEmailAction(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $sdk->getEmailAction();

        $this->assertInstanceOf(EmailAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testActionCaching(): void
    {
        $sdk = new Api('token', 'secret');

        $estateAction1 = $sdk->getEstateAction();
        $estateAction2 = $sdk->getEstateAction();

        $this->assertSame($estateAction1, $estateAction2);
    }

    public function testDifferentActionsAreDifferent(): void
    {
        $sdk = new Api('token', 'secret');

        $estateAction = $sdk->getEstateAction();
        $addressAction = $sdk->getAddressAction();

        $this->assertNotSame($estateAction, $addressAction);
    }

    public function testGetTokenAndSecret(): void
    {
        $sdk = new Api('mytoken', 'mysecret');

        $this->assertSame('mytoken', $sdk->getToken());
        $this->assertSame('mysecret', $sdk->getSecret());
    }
}
