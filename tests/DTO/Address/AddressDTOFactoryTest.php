<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Address;

use BytesCommerce\OnOffice\DTO\Address\AddressDTO;
use BytesCommerce\OnOffice\DTO\Address\AddressDTOFactory;
use PHPUnit\Framework\TestCase;

final class AddressDTOFactoryTest extends TestCase
{
    private AddressDTOFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new AddressDTOFactory();
    }

    public function testFromRecordCreatesAddressDTO(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Vorname' => 'Max',
                'Name' => 'Mustermann',
                'Firma' => 'Musterfirma',
                'Email' => 'max@example.com',
                'Telefon' => '+49 123 456789',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertInstanceOf(AddressDTO::class, $dto);
        $this->assertSame(123, $dto->id);
        $this->assertSame('Max', $dto->vorname);
        $this->assertSame('Mustermann', $dto->name);
        $this->assertSame('Musterfirma', $dto->firma);
        $this->assertSame('max@example.com', $dto->email);
        $this->assertSame('+49 123 456789', $dto->telefon);
    }

    public function testFromRecordHandlesBooleanConversion(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Aktiv' => '1',
                'Newsletter' => '0',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertTrue($dto->aktiv);
        $this->assertFalse($dto->newsletter);
    }

    public function testFromRecordHandlesNullValues(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Email' => null,
                'Telefon' => null,
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertNull($dto->email);
        $this->assertNull($dto->telefon);
    }

    public function testFromRecordWithFullAddress(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Strasse' => 'Hauptstrasse 42',
                'Plz' => '10115',
                'Ort' => 'Berlin',
                'Land' => 'DEU',
                'Bundesland' => 'Berlin',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertSame('Hauptstrasse 42', $dto->strasse);
        $this->assertSame('10115', $dto->plz);
        $this->assertSame('Berlin', $dto->ort);
        $this->assertSame('DEU', $dto->land);
        $this->assertSame('Berlin', $dto->bundesland);
    }

    public function testFromRecordsCreatesMultipleDTOs(): void
    {
        $records = [
            [
                'id' => 123,
                'type' => 'address',
                'elements' => ['Name' => 'Mustermann'],
            ],
            [
                'id' => 456,
                'type' => 'address',
                'elements' => ['Name' => 'Schmidt'],
            ],
        ];

        $dtos = $this->factory->fromRecords($records);

        $this->assertCount(2, $dtos);
        $this->assertSame(123, $dtos[0]->id);
        $this->assertSame(456, $dtos[1]->id);
    }

    public function testFromRecordWithPhoneNumbers(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Name' => 'Mustermann',
                'phone__13021' => '+49 123 456789',
                'phone__13021__Comment' => 'Büro',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertCount(1, $dto->phoneNumbers);
        $this->assertSame('+49 123 456789', $dto->phoneNumbers[0]->number);
        $this->assertSame('Büro', $dto->phoneNumbers[0]->comment);
    }

    public function testFromRecordWithMultiplePhoneNumbers(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Name' => 'Mustermann',
                'phone__13021' => '+49 123 456789',
                'phone__13022' => '+49 987 654321',
                'phone__13023' => '+49 111 222333',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertCount(3, $dto->phoneNumbers);
    }

    public function testFromRecordWithFreitextFields(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Freitext1' => 'Custom value 1',
                'Freitext2' => 'Custom value 2',
                'Freitext3' => 'Custom value 3',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertSame('Custom value 1', $dto->freitext1);
        $this->assertSame('Custom value 2', $dto->freitext2);
        $this->assertSame('Custom value 3', $dto->freitext3);
    }

    public function testFromRecordSetsRawData(): void
    {
        $record = [
            'id' => 123,
            'type' => 'address',
            'elements' => [
                'Name' => 'Mustermann',
                'customField' => 'customValue',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertArrayHasKey('Name', $dto->rawData);
        $this->assertArrayHasKey('customField', $dto->rawData);
    }
}
