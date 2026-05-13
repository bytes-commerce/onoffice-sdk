<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

final readonly class ParkingLotDTO
{
    /**
     * @param ParkingSpotDTO[] $carport
     * @param ParkingSpotDTO[] $duplex
     * @param ParkingSpotDTO[] $parkingSpace
     * @param ParkingSpotDTO[] $garage
     * @param ParkingSpotDTO[] $multiStoryGarage
     * @param ParkingSpotDTO[] $undergroundGarage
     * @param ParkingSpotDTO[] $otherParkingLot
     */
    public function __construct(
        public array $carport = [],
        public array $duplex = [],
        public array $parkingSpace = [],
        public array $garage = [],
        public array $multiStoryGarage = [],
        public array $undergroundGarage = [],
        public array $otherParkingLot = [],
    ) {}

    public function getTotalCount(): int
    {
        return \count($this->carport)
            + \count($this->duplex)
            + \count($this->parkingSpace)
            + \count($this->garage)
            + \count($this->multiStoryGarage)
            + \count($this->undergroundGarage)
            + \count($this->otherParkingLot);
    }

    public function getTotalPrice(): float
    {
        $total = 0.0;

        foreach ($this->carport as $spot) {
            $total += (float) ($spot->price ?? 0);
        }
        foreach ($this->duplex as $spot) {
            $total += (float) ($spot->price ?? 0);
        }
        foreach ($this->parkingSpace as $spot) {
            $total += (float) ($spot->price ?? 0);
        }
        foreach ($this->garage as $spot) {
            $total += (float) ($spot->price ?? 0);
        }
        foreach ($this->multiStoryGarage as $spot) {
            $total += (float) ($spot->price ?? 0);
        }
        foreach ($this->undergroundGarage as $spot) {
            $total += (float) ($spot->price ?? 0);
        }
        foreach ($this->otherParkingLot as $spot) {
            $total += (float) ($spot->price ?? 0);
        }

        return $total;
    }
}
