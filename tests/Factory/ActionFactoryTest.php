<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\Factory;

use BytesCommerce\OnOffice\Action\AddressAction;
use BytesCommerce\OnOffice\Action\CalendarAction;
use BytesCommerce\OnOffice\Action\EmailAction;
use BytesCommerce\OnOffice\Action\EstateAction;
use BytesCommerce\OnOffice\Action\FileAction;
use BytesCommerce\OnOffice\Action\RelationAction;
use BytesCommerce\OnOffice\Action\SearchCriteriaAction;
use BytesCommerce\OnOffice\Action\TaskAction;
use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\Factory\ActionFactory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ActionFactoryTest extends TestCase
{
    private ActionFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ActionFactory();
    }

    public function testCreateEstateAction(): void
    {
        $action = $this->factory->create(EstateAction::class, 'token', 'secret');

        $this->assertInstanceOf(EstateAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateAddressAction(): void
    {
        $action = $this->factory->create(AddressAction::class, 'token', 'secret');

        $this->assertInstanceOf(AddressAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateCalendarAction(): void
    {
        $action = $this->factory->create(CalendarAction::class, 'token', 'secret');

        $this->assertInstanceOf(CalendarAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateTaskAction(): void
    {
        $action = $this->factory->create(TaskAction::class, 'token', 'secret');

        $this->assertInstanceOf(TaskAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateSearchCriteriaAction(): void
    {
        $action = $this->factory->create(SearchCriteriaAction::class, 'token', 'secret');

        $this->assertInstanceOf(SearchCriteriaAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateFileAction(): void
    {
        $action = $this->factory->create(FileAction::class, 'token', 'secret');

        $this->assertInstanceOf(FileAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateRelationAction(): void
    {
        $action = $this->factory->create(RelationAction::class, 'token', 'secret');

        $this->assertInstanceOf(RelationAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateEmailAction(): void
    {
        $action = $this->factory->create(EmailAction::class, 'token', 'secret');

        $this->assertInstanceOf(EmailAction::class, $action);
        $this->assertSame('token', $action->getToken());
        $this->assertSame('secret', $action->getSecret());
    }

    public function testCreateWithSdk(): void
    {
        $sdk = new Api('token', 'secret');
        $action = $this->factory->create(EstateAction::class, 'token', 'secret', $sdk);

        $this->assertInstanceOf(EstateAction::class, $action);
    }

    public function testCreateWithInvalidClassThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('must be a subclass of');

        $this->factory->create('SomeInvalidClass', 'token', 'secret');
    }
}
