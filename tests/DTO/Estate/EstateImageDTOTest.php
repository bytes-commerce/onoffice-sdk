<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Estate;

use BytesCommerce\OnOffice\DTO\Estate\EstateImageDTO;
use PHPUnit\Framework\TestCase;

final class EstateImageDTOTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dto = new EstateImageDTO(
            id: 123,
            title: 'Test Image',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
            rank: 1,
            width: 1_920,
            height: 1_080,
        );

        $this->assertSame(123, $dto->id);
        $this->assertSame('Test Image', $dto->title);
        $this->assertSame('https://example.com/image.jpg', $dto->url);
        $this->assertSame('https://example.com/thumb.jpg', $dto->thumbnailUrl);
        $this->assertSame('Foto', $dto->type);
        $this->assertSame(1, $dto->rank);
        $this->assertSame(1_920, $dto->width);
        $this->assertSame(1_080, $dto->height);
    }

    public function testGetId(): void
    {
        $dto = new EstateImageDTO(
            id: 456,
            title: 'Test',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $this->assertSame(456, $dto->getId());
    }

    public function testIsPhotoReturnsTrueForFoto(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Photo',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $this->assertTrue($dto->isPhoto());
    }

    public function testIsPhotoReturnsFalseForOtherTypes(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Floor Plan',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Grundriss',
        );

        $this->assertFalse($dto->isPhoto());
    }

    public function testIsFloorPlanReturnsTrue(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Floor Plan',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Grundriss',
        );

        $this->assertTrue($dto->isFloorPlan());
    }

    public function testIsFloorPlanReturnsFalseForOtherTypes(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Photo',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $this->assertFalse($dto->isFloorPlan());
    }

    public function testIsPanoramaReturnsTrue(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Panorama',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Panorama',
        );

        $this->assertTrue($dto->isPanorama());
    }

    public function testIsPanoramaReturnsFalseForOtherTypes(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Photo',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $this->assertFalse($dto->isPanorama());
    }

    public function testIsTitleImageReturnsTrue(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Title Image',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Titelbild',
        );

        $this->assertTrue($dto->isTitleImage());
    }

    public function testIsTitleImageReturnsFalseForOtherTypes(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Photo',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $this->assertFalse($dto->isTitleImage());
    }

    public function testGetModifiedDateReturnsNullWhenModifiedIsNull(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Test',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $this->assertNull($dto->getModifiedDate());
    }

    public function testGetModifiedDateReturnsDateTimeImmutable(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Test',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
            modified: 1_749_193_590,
        );

        $date = $dto->getModifiedDate();
        $this->assertNotNull($date);
        $this->assertSame('2025-06-06', $date->format('Y-m-d'));
    }

    public function testRawData(): void
    {
        $rawData = ['customField' => 'value'];
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Test',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
            rawData: $rawData,
        );

        $this->assertSame($rawData, $dto->rawData);
    }

    public function testEstateIdAndEstateMainId(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Test',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
            estateId: 37,
            estateMainId: 37,
        );

        $this->assertSame(37, $dto->estateId);
        $this->assertSame(37, $dto->estateMainId);
    }

    public function testOriginalNameAndText(): void
    {
        $dto = new EstateImageDTO(
            id: 1,
            title: 'Test',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
            originalName: 'original_file.jpg',
            text: 'Image description',
        );

        $this->assertSame('original_file.jpg', $dto->originalName);
        $this->assertSame('Image description', $dto->text);
    }
}
