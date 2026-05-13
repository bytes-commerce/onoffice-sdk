<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

use DateTimeImmutable;

final readonly class EstateImageDTO
{
    /**
     * @param int|string $id Image ID
     * @param string $title Image title
     * @param string $url Full-size image URL
     * @param string $thumbnailUrl Thumbnail image URL
     * @param string $type Image type (e.g., 'Foto', 'Grundriss', 'Panorama')
     * @param int $rank Sort order rank
     * @param int|null $width Image width in pixels
     * @param int|null $height Image height in pixels
     * @param int|string|null $estateId Estate ID this image belongs to
     * @param int|string|null $estateMainId Main estate ID (for multilingual setups)
     * @param string|null $originalName Original filename
     * @param string|null $text Image description text
     * @param int|null $modified Last modification Unix timestamp
     * @param array<string, mixed> $rawData Original API response elements
     */
    public function __construct(
        public int|string $id,
        public string $title,
        public string $url,
        public string $thumbnailUrl,
        public string $type,
        public int $rank = 0,
        public ?int $width = null,
        public ?int $height = null,
        public int|string|null $estateId = null,
        public int|string|null $estateMainId = null,
        public ?string $originalName = null,
        public ?string $text = null,
        public ?int $modified = null,
        public array $rawData = [],
    ) {}

    public function getId(): int|string
    {
        return $this->id;
    }

    public function isPanorama(): bool
    {
        return strtolower($this->type) === 'panorama';
    }

    public function isPhoto(): bool
    {
        return strtolower($this->type) === 'foto';
    }

    public function isFloorPlan(): bool
    {
        return strtolower($this->type) === 'grundriss';
    }

    public function isTitleImage(): bool
    {
        return strtolower($this->type) === 'titelbild';
    }

    public function getModifiedDate(): ?DateTimeImmutable
    {
        if ($this->modified === null) {
            return null;
        }

        return new DateTimeImmutable('@' . $this->modified);
    }
}
