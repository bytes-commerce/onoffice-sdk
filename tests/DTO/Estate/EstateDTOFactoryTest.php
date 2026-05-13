<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Estate;

use BytesCommerce\OnOffice\DTO\Estate\EstateDTO;
use BytesCommerce\OnOffice\DTO\Estate\EstateDTOFactory;
use BytesCommerce\OnOffice\DTO\Estate\EstateImageDTO;
use PHPUnit\Framework\TestCase;

final class EstateDTOFactoryTest extends TestCase
{
    private EstateDTOFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new EstateDTOFactory();
    }

    public function testFromRecordCreatesEstateDTO(): void
    {
        $record = [
            'id' => 123,
            'type' => 'estate',
            'elements' => [
                'objekttitel' => 'Test Estate',
                'kaufpreis' => '250000.00',
                'ort' => 'Berlin',
                'plz' => '10115',
                'vermarktungsart' => 'kauf',
                'objektart' => 'haus',
                'verkauft' => '0',
                'reserviert' => '0',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertInstanceOf(EstateDTO::class, $dto);
        $this->assertSame(123, $dto->id);
        $this->assertSame('Test Estate', $dto->objekttitel);
        $this->assertSame(250_000.0, $dto->kaufpreis);
        $this->assertSame('Berlin', $dto->ort);
        $this->assertSame('10115', $dto->plz);
    }

    public function testFromRecordHandlesBooleanConversion(): void
    {
        $record = [
            'id' => 123,
            'type' => 'estate',
            'elements' => [
                'verkauft' => '1',
                'reserviert' => '0',
                'balkon' => '1',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertTrue($dto->verkauft);
        $this->assertFalse($dto->reserviert);
        $this->assertTrue($dto->balkon);
    }

    public function testFromRecordHandlesFloatConversion(): void
    {
        $record = [
            'id' => 123,
            'type' => 'estate',
            'elements' => [
                'kaufpreis' => '250000.50',
                'wohnflaeche' => '120.75',
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertSame(250_000.50, $dto->kaufpreis);
        $this->assertSame(120.75, $dto->wohnflaeche);
    }

    public function testFromRecordHandlesNullValues(): void
    {
        $record = [
            'id' => 123,
            'type' => 'estate',
            'elements' => [
                'kaufpreis' => null,
                'ort' => null,
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertNull($dto->kaufpreis);
        $this->assertNull($dto->ort);
    }

    public function testFromRecordHandlesArrayValuesAsString(): void
    {
        $record = [
            'id' => 123,
            'type' => 'estate',
            'elements' => [
                'fahrstuhl' => ['Aufzug', 'Personenaufzug'],
                'befeuerung' => ['Gas', 'Solar'],
            ],
        ];

        $dto = $this->factory->fromRecord($record);

        $this->assertSame('Aufzug, Personenaufzug', $dto->fahrstuhl);
        $this->assertSame('Gas, Solar', $dto->befeuerung);
    }

    public function testFromRecordsCreatesMultipleDTOs(): void
    {
        $records = [
            [
                'id' => 123,
                'type' => 'estate',
                'elements' => ['objekttitel' => 'Estate 1'],
            ],
            [
                'id' => 456,
                'type' => 'estate',
                'elements' => ['objekttitel' => 'Estate 2'],
            ],
        ];

        $dtos = $this->factory->fromRecords($records);

        $this->assertCount(2, $dtos);
        $this->assertSame(123, $dtos[0]->id);
        $this->assertSame(456, $dtos[1]->id);
    }

    public function testFromRecordWithImagesLoaderSetsLoader(): void
    {
        $record = [
            'id' => 123,
            'type' => 'estate',
            'elements' => ['objekttitel' => 'Test'],
        ];

        $imageDto = new EstateImageDTO(
            id: 1,
            title: 'Test Image',
            url: 'https://example.com/image.jpg',
            thumbnailUrl: 'https://example.com/thumb.jpg',
            type: 'Foto',
        );

        $loaderCalled = false;
        $loader = static function () use (&$loaderCalled, $imageDto) {
            $loaderCalled = true;

            return [$imageDto];
        };

        $dto = $this->factory->fromRecordWithImagesLoader($record, $loader);

        $this->assertFalse($loaderCalled);
        $this->assertFalse($dto->hasImagesLoaded());

        $images = $dto->getImages();
        // @phpstan-ignore method.impossibleType
        $this->assertTrue($loaderCalled);
        $this->assertCount(1, $images);
        $this->assertSame('Test Image', $images[0]->title);
    }

    public function testFromRecordsWithImagesLoaderSetsLoaderForEachEstate(): void
    {
        $records = [
            [
                'id' => 123,
                'type' => 'estate',
                'elements' => ['objekttitel' => 'Estate 1'],
            ],
            [
                'id' => 456,
                'type' => 'estate',
                'elements' => ['objekttitel' => 'Estate 2'],
            ],
        ];

        $loadedEstateIds = [];
        $imagesLoader = static function (int|string $estateId) use (&$loadedEstateIds) {
            $loadedEstateIds[] = $estateId;

            return [
                new EstateImageDTO(
                    id: 1,
                    title: 'Image for ' . $estateId,
                    url: 'https://example.com/' . $estateId . '.jpg',
                    thumbnailUrl: 'https://example.com/' . $estateId . '_thumb.jpg',
                    type: 'Foto',
                ),
            ];
        };

        $dtos = $this->factory->fromRecordsWithImagesLoader($records, $imagesLoader);

        $this->assertCount(2, $dtos);

        // First estate - loader not called yet
        $this->assertFalse($dtos[0]->hasImagesLoaded());

        // Second estate - loader not called yet
        $this->assertFalse($dtos[1]->hasImagesLoaded());

        // Access first estate images
        $images1 = $dtos[0]->getImages();
        $this->assertCount(1, $images1);
        $this->assertSame('Image for 123', $images1[0]->title);

        // Second estate images not loaded yet
        $this->assertFalse($dtos[1]->hasImagesLoaded());
    }
}
