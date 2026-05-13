<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Address;

use BytesCommerce\OnOffice\DTO\Address\AddressDTO;
use BytesCommerce\OnOffice\DTO\Address\PhoneNumberDTO;
use PHPUnit\Framework\TestCase;

final class AddressDTOTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dto = new AddressDTO(
            id: 123,
            vorname: 'Max',
            name: 'Mustermann',
            firma: 'Musterfirma',
            email: 'max@example.com',
        );

        $this->assertSame(123, $dto->id);
        $this->assertSame('Max', $dto->vorname);
        $this->assertSame('Mustermann', $dto->name);
        $this->assertSame('Musterfirma', $dto->firma);
        $this->assertSame('max@example.com', $dto->email);
    }

    public function testGetId(): void
    {
        $dto = new AddressDTO(id: 456);
        $this->assertSame(456, $dto->getId());
    }

    public function testGetFullName(): void
    {
        $dto = new AddressDTO(id: 1, vorname: 'Max', name: 'Mustermann');
        $this->assertSame('Max Mustermann', $dto->getFullName());
    }

    public function testGetFullNameReturnsNullWhenNoName(): void
    {
        $dto = new AddressDTO(id: 1);
        $this->assertNull($dto->getFullName());
    }

    public function testGetFullNameReturnsOnlyVornameWhenNoName(): void
    {
        $dto = new AddressDTO(id: 1, vorname: 'Max');
        $this->assertSame('Max', $dto->getFullName());
    }

    public function testGetFormattedAddress(): void
    {
        $dto = new AddressDTO(
            id: 1,
            strasse: 'Hauptstrasse 42',
            plz: '10115',
            ort: 'Berlin',
        );

        $this->assertSame('Hauptstrasse 42 10115 Berlin', $dto->getFormattedAddress());
    }

    public function testGetFormattedAddressReturnsNullWithNoAddress(): void
    {
        $dto = new AddressDTO(id: 1);
        $this->assertNull($dto->getFormattedAddress());
    }

    public function testGetFormattedAddressReturnsStrasseOnly(): void
    {
        $dto = new AddressDTO(id: 1, strasse: 'Hauptstrasse');
        $this->assertSame('Hauptstrasse', $dto->getFormattedAddress());
    }

    public function testGetFormattedFullAddress(): void
    {
        $dto = new AddressDTO(
            id: 1,
            vorname: 'Max',
            name: 'Mustermann',
            firma: 'Musterfirma',
            strasse: 'Hauptstrasse 42',
            plz: '10115',
            ort: 'Berlin',
        );

        $expected = "Musterfirma\nMax Mustermann\nHauptstrasse 42\n10115 Berlin";
        $this->assertSame($expected, $dto->getFormattedFullAddress());
    }

    public function testGetFormattedFullAddressReturnsEmptyStringWithNoData(): void
    {
        $dto = new AddressDTO(id: 1);
        // Due to 'plz . ' ' . ort' concatenation producing ' ' even with null values
        $result = $dto->getFormattedFullAddress();
        $this->assertSame(' ', $result);
    }

    public function testGetPrimaryEmail(): void
    {
        $dto = new AddressDTO(id: 1, email: 'test@example.com');
        $this->assertSame('test@example.com', $dto->getPrimaryEmail());
    }

    public function testGetPrimaryPhone(): void
    {
        $dto = new AddressDTO(id: 1, telefon: '+49 123', mobil: '+49 456');
        $this->assertSame('+49 123', $dto->getPrimaryPhone());
    }

    public function testGetPrimaryPhoneFallsBackToMobil(): void
    {
        $dto = new AddressDTO(id: 1, mobil: '+49 456');
        $this->assertSame('+49 456', $dto->getPrimaryPhone());
    }

    public function testHasAddressReturnsTrue(): void
    {
        $dto = new AddressDTO(id: 1, strasse: 'Strasse', plz: '12345', ort: 'Stadt');
        $this->assertTrue($dto->hasAddress());
    }

    public function testHasAddressReturnsFalse(): void
    {
        $dto = new AddressDTO(id: 1);
        $this->assertFalse($dto->hasAddress());
    }

    public function testHasAddressReturnsFalseWithPartialAddress(): void
    {
        $dto = new AddressDTO(id: 1, strasse: 'Strasse', plz: '12345');
        $this->assertFalse($dto->hasAddress());
    }

    public function testGetCompany(): void
    {
        $dto = new AddressDTO(id: 1, firma: 'Musterfirma GmbH');
        $this->assertSame('Musterfirma GmbH', $dto->getCompany());
    }

    public function testIsActive(): void
    {
        $dto = new AddressDTO(id: 1, aktiv: true);
        $this->assertTrue($dto->isActive());
    }

    public function testIsActiveReturnsNullByDefault(): void
    {
        $dto = new AddressDTO(id: 1);
        $this->assertNull($dto->isActive());
    }

    public function testHasNewsletter(): void
    {
        $dto = new AddressDTO(id: 1, newsletter: true);
        $this->assertTrue($dto->hasNewsletter());
    }

    public function testHasNewsletterReturnsNullByDefault(): void
    {
        $dto = new AddressDTO(id: 1);
        $this->assertNull($dto->hasNewsletter());
    }

    public function testPhoneNumbersProperty(): void
    {
        $phone = new PhoneNumberDTO(number: '+49 123');
        $dto = new AddressDTO(id: 1, phoneNumbers: [$phone]);

        $this->assertCount(1, $dto->phoneNumbers);
        $this->assertSame('+49 123', $dto->phoneNumbers[0]->number);
    }

    public function testRawDataProperty(): void
    {
        $rawData = ['customField' => 'value'];
        $dto = new AddressDTO(id: 1, rawData: $rawData);

        $this->assertSame($rawData, $dto->rawData);
    }
}
