<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Tests\DTO\Estate;

use BytesCommerce\OnOffice\DTO\Estate\EstateAttributeMapper;
use PHPUnit\Framework\TestCase;

final class EstateAttributeMapperTest extends TestCase
{
    private EstateAttributeMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new EstateAttributeMapper();
    }

    public function testGetMappedFieldsReturnsArray(): void
    {
        $fields = $this->mapper->getMappedFields();

        $this->assertContains('Id', $fields);
        $this->assertContains('kaufpreis', $fields);
        $this->assertContains('ort', $fields);
        $this->assertContains('vermarktungsart', $fields);
    }

    public function testGetMappedFieldsContainsExpectedFields(): void
    {
        $fields = $this->mapper->getMappedFields();

        // Core identification
        $this->assertContains('Id', $fields);

        // Price fields
        $this->assertContains('kaufpreis', $fields);
        $this->assertContains('warmmiete', $fields);
        $this->assertContains('kaltmiete', $fields);
        $this->assertContains('nebenkosten', $fields);

        // Location fields
        $this->assertContains('ort', $fields);
        $this->assertContains('plz', $fields);
        $this->assertContains('strasse', $fields);
        $this->assertContains('land', $fields);

        // Coordinates
        $this->assertContains('breitengrad', $fields);
        $this->assertContains('laengengrad', $fields);

        // Marketing status
        $this->assertContains('verkauft', $fields);
        $this->assertContains('reserviert', $fields);

        // Object properties
        $this->assertContains('objekttitel', $fields);
        $this->assertContains('objektart', $fields);
        $this->assertContains('vermarktungsart', $fields);
        $this->assertContains('wohnflaeche', $fields);
        $this->assertContains('anzahl_zimmer', $fields);
        $this->assertContains('baujahr', $fields);

        // Amenities
        $this->assertContains('balkon', $fields);
        $this->assertContains('terrasse', $fields);
        $this->assertContains('sauna', $fields);
        $this->assertContains('kamin', $fields);
        $this->assertContains('fahrstuhl', $fields);

        // Parking
        $this->assertContains('multiParkingLot', $fields);
    }

    public function testGetAttributeClassReturnsClassForKnownField(): void
    {
        $class = $this->mapper->getAttributeClass('kaufpreis');

        $this->assertNotNull($class);
        $this->assertStringContainsString('KaufpreisAttribute', $class);
    }

    public function testGetAttributeClassReturnsNullForUnknownField(): void
    {
        $class = $this->mapper->getAttributeClass('unknownField');

        $this->assertNull($class);
    }

    public function testHasAttributeReturnsTrueForKnownField(): void
    {
        $this->assertTrue($this->mapper->hasAttribute('kaufpreis'));
        $this->assertTrue($this->mapper->hasAttribute('ort'));
        $this->assertTrue($this->mapper->hasAttribute('Id'));
    }

    public function testHasAttributeReturnsFalseForUnknownField(): void
    {
        $this->assertFalse($this->mapper->hasAttribute('unknownField'));
    }

    public function testIsKnownField(): void
    {
        $this->assertTrue($this->mapper->isKnownField('kaufpreis'));
        $this->assertFalse($this->mapper->isKnownField('unknown'));
    }

    public function testGetFieldToAttributeMap(): void
    {
        $map = $this->mapper->getFieldToAttributeMap();

        $this->assertArrayHasKey('kaufpreis', $map);
        $this->assertArrayHasKey('ort', $map);
    }

    public function testGetAttributesForFields(): void
    {
        $fields = ['kaufpreis', 'ort'];
        $attributes = $this->mapper->getAttributesForFields($fields);

        $this->assertCount(2, $attributes);
        $this->assertArrayHasKey('kaufpreis', $attributes);
        $this->assertArrayHasKey('ort', $attributes);
    }

    public function testGetAttributesForFieldsSkipsUnknownFields(): void
    {
        $fields = ['kaufpreis', 'unknownField'];
        $attributes = $this->mapper->getAttributesForFields($fields);

        $this->assertCount(1, $attributes);
        $this->assertArrayHasKey('kaufpreis', $attributes);
        $this->assertArrayNotHasKey('unknownField', $attributes);
    }

    public function testGetFieldType(): void
    {
        $type = $this->mapper->getFieldType('kaufpreis');

        // This test depends on the actual attribute implementation
        $this->assertNotNull($type);
    }

    public function testGetFieldTypeReturnsNullForUnknownField(): void
    {
        $type = $this->mapper->getFieldType('unknownField');

        $this->assertNull($type);
    }
}
