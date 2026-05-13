<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Address;

use BytesCommerce\OnOffice\DTO\Address\PhoneNumberDTO;
use PHPUnit\Framework\TestCase;

final class PhoneNumberDTOTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dto = new PhoneNumberDTO(
            number: '+49 123 456789',
            comment: 'Büro',
            type: 'business',
        );

        $this->assertSame('+49 123 456789', $dto->number);
        $this->assertSame('Büro', $dto->comment);
        $this->assertSame('business', $dto->type);
    }

    public function testGetNumber(): void
    {
        $dto = new PhoneNumberDTO(number: '+49 123 456789');
        $this->assertSame('+49 123 456789', $dto->getNumber());
    }

    public function testGetComment(): void
    {
        $dto = new PhoneNumberDTO(comment: 'Private');
        $this->assertSame('Private', $dto->getComment());
    }

    public function testGetType(): void
    {
        $dto = new PhoneNumberDTO(type: 'mobile');
        $this->assertSame('mobile', $dto->getType());
    }

    public function testIsValidReturnsTrue(): void
    {
        $dto = new PhoneNumberDTO(number: '+49 123 456789');
        $this->assertTrue($dto->isValid());
    }

    public function testIsValidReturnsFalseWhenNumberIsNull(): void
    {
        $dto = new PhoneNumberDTO();
        $this->assertFalse($dto->isValid());
    }

    public function testIsValidReturnsFalseWhenNumberIsEmpty(): void
    {
        $dto = new PhoneNumberDTO(number: '');
        $this->assertFalse($dto->isValid());
    }
}
