<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Estate;

use BytesCommerce\OnOffice\DTO\Estate\ParkingLotDTO;
use BytesCommerce\OnOffice\DTO\Estate\ParkingSpotDTO;
use PHPUnit\Framework\TestCase;

final class ParkingLotDTOTest extends TestCase
{
    public function testEmptyParkingLot(): void
    {
        $dto = new ParkingLotDTO();

        $this->assertSame(0, $dto->getTotalCount());
        $this->assertSame(0.0, $dto->getTotalPrice());
    }

    public function testGetTotalCountWithSingleType(): void
    {
        $dto = new ParkingLotDTO(
            garage: [
                new ParkingSpotDTO(count: 2, price: 15_000.00),
            ],
        );

        $this->assertSame(1, $dto->getTotalCount());
    }

    public function testGetTotalCountWithMultipleTypes(): void
    {
        $dto = new ParkingLotDTO(
            carport: [new ParkingSpotDTO(count: 1, price: 5_000.00)],
            garage: [new ParkingSpotDTO(count: 1, price: 15_000.00)],
            undergroundGarage: [new ParkingSpotDTO(count: 1, price: 20_000.00)],
        );

        $this->assertSame(3, $dto->getTotalCount());
    }

    public function testGetTotalPriceWithSingleSpot(): void
    {
        $dto = new ParkingLotDTO(
            garage: [
                new ParkingSpotDTO(price: 15_000.00),
            ],
        );

        $this->assertSame(15_000.00, $dto->getTotalPrice());
    }

    public function testGetTotalPriceWithMultipleSpots(): void
    {
        $dto = new ParkingLotDTO(
            carport: [new ParkingSpotDTO(price: 5_000.00)],
            duplex: [new ParkingSpotDTO(price: 8_000.00)],
            parkingSpace: [new ParkingSpotDTO(price: 3_000.00)],
            garage: [new ParkingSpotDTO(price: 15_000.00)],
            multiStoryGarage: [new ParkingSpotDTO(price: 18_000.00)],
            undergroundGarage: [new ParkingSpotDTO(price: 20_000.00)],
            otherParkingLot: [new ParkingSpotDTO(price: 6_000.00)],
        );

        $this->assertSame(75_000.00, $dto->getTotalPrice());
    }

    public function testGetTotalPriceHandlesNullPrices(): void
    {
        $dto = new ParkingLotDTO(
            garage: [
                new ParkingSpotDTO(price: null),
                new ParkingSpotDTO(price: 10_000.00),
            ],
        );

        $this->assertSame(10_000.00, $dto->getTotalPrice());
    }

    public function testAllParkingTypes(): void
    {
        $dto = new ParkingLotDTO(
            carport: [new ParkingSpotDTO(count: 1, price: 5_000.00)],
            duplex: [new ParkingSpotDTO(count: 1, price: 8_000.00)],
            parkingSpace: [new ParkingSpotDTO(count: 1, price: 3_000.00)],
            garage: [new ParkingSpotDTO(count: 1, price: 15_000.00)],
            multiStoryGarage: [new ParkingSpotDTO(count: 1, price: 18_000.00)],
            undergroundGarage: [new ParkingSpotDTO(count: 1, price: 20_000.00)],
            otherParkingLot: [new ParkingSpotDTO(count: 1, price: 6_000.00)],
        );

        $this->assertSame(7, $dto->getTotalCount());
        $this->assertSame(75_000.00, $dto->getTotalPrice());
    }
}
