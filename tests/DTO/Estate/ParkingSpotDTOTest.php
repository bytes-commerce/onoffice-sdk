<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Estate;

use BytesCommerce\OnOffice\DTO\Estate\ParkingSpotDTO;
use PHPUnit\Framework\TestCase;

final class ParkingSpotDTOTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dto = new ParkingSpotDTO(
            count: 2,
            price: 15_000.00,
            marketingType: 'buy',
        );

        $this->assertSame(2, $dto->count);
        $this->assertSame(15_000.00, $dto->price);
        $this->assertSame('buy', $dto->marketingType);
    }

    public function testCountCanBeNull(): void
    {
        $dto = new ParkingSpotDTO(price: 10_000.00);
        $this->assertNull($dto->count);
    }

    public function testPriceCanBeNull(): void
    {
        $dto = new ParkingSpotDTO(count: 1);
        $this->assertNull($dto->price);
    }
}
