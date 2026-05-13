<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

final readonly class ParkingSpotDTO
{
    public function __construct(
        public ?int $count = null,
        public ?float $price = null,
        public ?string $marketingType = null,
    ) {}
}
