<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Estate;

use BytesCommerce\OnOffice\DTO\Estate\EstateDTO;
use BytesCommerce\OnOffice\DTO\Estate\EstateImageDTO;
use PHPUnit\Framework\TestCase;

final class EstateDTOTest extends TestCase
{
    public function testBasicProperties(): void
    {
        $dto = new EstateDTO(
            id: 123,
            objekttitel: 'Test Estate',
            kaufpreis: 250_000.0,
            wohnflaeche: 120.5,
            anzahlZimmer: 4.0,
            verkauft: false,
            reserviert: false,
            plz: '10115',
            ort: 'Berlin',
        );

        $this->assertSame(123, $dto->id);
        $this->assertSame('Test Estate', $dto->objekttitel);
        $this->assertSame(250_000.0, $dto->kaufpreis);
        $this->assertSame('Berlin', $dto->ort);
        $this->assertSame('10115', $dto->plz);
        $this->assertSame(120.5, $dto->wohnflaeche);
        $this->assertSame(4.0, $dto->anzahlZimmer);
    }

    public function testGetId(): void
    {
        $dto = new EstateDTO(id: 456);
        $this->assertSame(456, $dto->getId());
    }

    public function testHasCoordinatesReturnsTrue(): void
    {
        $dto = new EstateDTO(
            id: 1,
            breitengrad: 52.520_0,
            laengengrad: 13.405_0,
        );

        $this->assertTrue($dto->hasCoordinates());
    }

    public function testHasCoordinatesReturnsFalse(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertFalse($dto->hasCoordinates());
    }

    public function testHasCoordinatesReturnsFalseWithOnlyBreitengrad(): void
    {
        $dto = new EstateDTO(
            id: 1,
            breitengrad: 52.520_0,
        );
        $this->assertFalse($dto->hasCoordinates());
    }

    public function testGetCoordinates(): void
    {
        $dto = new EstateDTO(
            id: 1,
            breitengrad: 52.520_0,
            laengengrad: 13.405_0,
        );

        $coords = $dto->getCoordinates();
        $this->assertNotNull($coords);
        $this->assertSame(52.520_0, $coords['latitude']);
        $this->assertSame(13.405_0, $coords['longitude']);
    }

    public function testGetCoordinatesReturnsNullWithoutCoordinates(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertNull($dto->getCoordinates());
    }

    public function testGetFormattedAddress(): void
    {
        $dto = new EstateDTO(
            id: 1,
            strasse: 'Hauptstrasse',
            hausnummer: '42',
            plz: '10115',
            ort: 'Berlin',
        );

        $this->assertSame('Hauptstrasse 42 10115 Berlin', $dto->getFormattedAddress());
    }

    public function testGetFormattedAddressReturnsNullWithNoParts(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertNull($dto->getFormattedAddress());
    }

    public function testIsForSaleReturnsTrue(): void
    {
        $dto = new EstateDTO(id: 1, kaufpreis: 250_000.0);
        $this->assertTrue($dto->isForSale());
    }

    public function testIsForSaleReturnsFalseWithZeroPrice(): void
    {
        $dto = new EstateDTO(id: 1, kaufpreis: 0.0);
        $this->assertFalse($dto->isForSale());
    }

    public function testIsForSaleReturnsFalseWithNullPrice(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertFalse($dto->isForSale());
    }

    public function testIsForRentReturnsTrue(): void
    {
        $dto = new EstateDTO(id: 1, mietpreis: 1_000.0);
        $this->assertTrue($dto->isForRent());
    }

    public function testIsSoldReturnsTrue(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: true);
        $this->assertTrue($dto->isSold());
    }

    public function testIsSoldReturnsTrueWithIntegerOne(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: true);
        $this->assertTrue($dto->isSold());
    }

    public function testIsSoldReturnsTrueWithStringOne(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: true);
        $this->assertTrue($dto->isSold());
    }

    public function testIsSoldReturnsFalse(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: false);
        $this->assertFalse($dto->isSold());
    }

    public function testIsReservedReturnsTrue(): void
    {
        $dto = new EstateDTO(id: 1, reserviert: true);
        $this->assertTrue($dto->isReserved());
    }

    public function testIsReservedReturnsFalse(): void
    {
        $dto = new EstateDTO(id: 1, reserviert: false);
        $this->assertFalse($dto->isReserved());
    }

    public function testIsActiveReturnsTrue(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: false, reserviert: false);
        $this->assertTrue($dto->isActive());
    }

    public function testIsActiveReturnsFalseWhenSold(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: true, reserviert: false);
        $this->assertFalse($dto->isActive());
    }

    public function testIsActiveReturnsFalseWhenReserved(): void
    {
        $dto = new EstateDTO(id: 1, verkauft: false, reserviert: true);
        $this->assertFalse($dto->isActive());
    }

    public function testGetPriceReturnsKaufpreis(): void
    {
        $dto = new EstateDTO(id: 1, kaufpreis: 250_000.0, mietpreis: 1_000.0);
        $this->assertSame(250_000.0, $dto->getPrice());
    }

    public function testGetPriceReturnsMietpreisWhenKaufpreisIsNull(): void
    {
        $dto = new EstateDTO(id: 1, mietpreis: 1_000.0);
        $this->assertSame(1_000.0, $dto->getPrice());
    }

    public function testGetRentPriceReturnsWarmmiete(): void
    {
        $dto = new EstateDTO(id: 1, kaltmiete: 1_000.0, warmmiete: 1_200.0);
        $this->assertSame(1_200.0, $dto->getRentPrice());
    }

    public function testGetRentPriceReturnsKaltmieteWhenWarmmieteIsNull(): void
    {
        $dto = new EstateDTO(id: 1, kaltmiete: 1_000.0);
        $this->assertSame(1_000.0, $dto->getRentPrice());
    }

    public function testHasImagesLoadedReturnsFalseWhenNoLoader(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertFalse($dto->hasImagesLoaded());
    }

    public function testHasImagesLoadedReturnsTrueWhenImagesLoaded(): void
    {
        $dto = new EstateDTO(id: 1);
        $dto->setImagesLoader(static fn () => []);

        // Call getImages which should trigger the loader
        $images = $dto->getImages();
        $this->assertSame([], $images);
        $this->assertTrue($dto->hasImagesLoaded());
    }

    public function testGetImagesReturnsEmptyArrayByDefault(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertSame([], $dto->getImages());
    }

    public function testGetImagesLoadsFromLoader(): void
    {
        $dto = new EstateDTO(id: 1);

        $imageDto = new EstateImageDTO(
            id: 1,
            title: 'Test Image',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $dto->setImagesLoader(static fn () => [$imageDto]);

        $images = $dto->getImages();
        $this->assertCount(1, $images);
        $this->assertSame('Test Image', $images[0]->title);
    }

    public function testGetImagesCachesAfterFirstLoad(): void
    {
        $dto = new EstateDTO(id: 1);
        $callCount = 0;

        $dto->setImagesLoader(static function () use (&$callCount) {
            ++$callCount;

            return [
                new EstateImageDTO(
                    id: 1,
                    title: 'Image ' . $callCount,
                    url: 'https://example.com/image.jpg',
                    thumbnailUrl: 'https://example.com/thumb.jpg',
                    type: 'Foto',
                ),
            ];
        });

        // First call
        $images1 = $dto->getImages();
        $this->assertSame('Image 1', $images1[0]->title);

        // Second call should return cached
        $images2 = $dto->getImages();
        $this->assertSame('Image 1', $images2[0]->title);
        $this->assertSame(1, $callCount);
    }

    public function testGetTitleImageReturnsFirstTitleImage(): void
    {
        $dto = new EstateDTO(id: 1);

        $images = [
            new EstateImageDTO(
                id: 1,
                title: 'Photo 1',
                url: 'https://example.com/1.jpg',
                thumbnailUrl: 'https://example.com/1_thumb.jpg',
                type: 'Foto',
            ),
            new EstateImageDTO(
                id: 2,
                title: 'Title Image',
                url: 'https://example.com/2.jpg',
                thumbnailUrl: 'https://example.com/2_thumb.jpg',
                type: 'Titelbild',
            ),
        ];

        $dto->setImagesLoader(static fn () => $images);

        $titleImage = $dto->getTitleImage();
        $this->assertNotNull($titleImage);
        $this->assertSame('Title Image', $titleImage->title);
    }

    public function testGetTitleImageReturnsFirstImageWhenNoTitleImage(): void
    {
        $dto = new EstateDTO(id: 1);

        $images = [
            new EstateImageDTO(
                id: 1,
                title: 'Photo 1',
                url: 'https://example.com/1.jpg',
                thumbnailUrl: 'https://example.com/1_thumb.jpg',
                type: 'Foto',
            ),
        ];

        $dto->setImagesLoader(static fn () => $images);

        $titleImage = $dto->getTitleImage();
        $this->assertNotNull($titleImage);
        $this->assertSame('Photo 1', $titleImage->title);
    }

    public function testGetTitleImageReturnsNullWhenNoImages(): void
    {
        $dto = new EstateDTO(id: 1);
        $this->assertNull($dto->getTitleImage());
    }

    public function testGetPhotosReturnsOnlyPhotos(): void
    {
        $dto = new EstateDTO(id: 1);

        $images = [
            new EstateImageDTO(
                id: 1,
                title: 'Photo 1',
                url: 'https://example.com/1.jpg',
                thumbnailUrl: 'https://example.com/1_thumb.jpg',
                type: 'Foto',
            ),
            new EstateImageDTO(
                id: 2,
                title: 'Floor Plan',
                url: 'https://example.com/2.jpg',
                thumbnailUrl: 'https://example.com/2_thumb.jpg',
                type: 'Grundriss',
            ),
            new EstateImageDTO(
                id: 3,
                title: 'Photo 2',
                url: 'https://example.com/3.jpg',
                thumbnailUrl: 'https://example.com/3_thumb.jpg',
                type: 'Foto',
            ),
        ];

        $dto->setImagesLoader(static fn () => $images);

        $photos = $dto->getPhotos();
        $this->assertCount(2, $photos);
        $this->assertSame('Photo 1', $photos[0]->title);
        $this->assertSame('Photo 2', $photos[1]->title);
    }

    public function testRawData(): void
    {
        $rawData = ['customField' => 'value'];
        $dto = new EstateDTO(id: 1, rawData: $rawData);
        $this->assertSame($rawData, $dto->rawData);
    }
}
