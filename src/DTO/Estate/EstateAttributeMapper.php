<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

use BytesCommerce\OnOffice\Attributes\AbstractAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\AnzahlZimmerAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\AusstattBeschrAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\BalkonAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\BaujahrAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\BreitengradAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\EinliegerwohnungAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\EnergieausweistypAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\EnergyClassAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ErstelltAmAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\FahrstuhlAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\GeaendertAmAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\GrundstuecksflaecheAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\IdAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\KaltmieteAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\KaminAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\KaufpreisAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\LaengengradAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\LageAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\LandAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\MultiParkingLotAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\NebenkostenAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ObjektartAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ObjektbeschreibungAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ObjekttitelAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ObjekttypAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\OrtAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\PlzAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ReserviertAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\SaunaAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\SonstigeAngabenAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\StrasseAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\TerrasseAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\VerkauftAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\VermarktungsartAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\WarmmieteAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\WohnflaecheAttribute;
use BytesCommerce\OnOffice\Attributes\Estate\ZustandAttribute;

/**
 * Maps API field names to their corresponding Attribute classes and provides
 * utility methods for attribute-based operations.
 *
 * IMPORTANT: Field names must match the API's expected format (e.g., 'Id' not 'id').
 */
final class EstateAttributeMapper
{
    /**
     * Mapping of API field names to their Attribute classes.
     * Field names MUST match exactly what the onOffice API expects.
     *
     * @var array<string, class-string<AbstractAttribute>>
     */
    private const array FIELD_TO_ATTRIBUTE = [
        'Id' => IdAttribute::class,
        'kaufpreis' => KaufpreisAttribute::class,
        'wohnflaeche' => WohnflaecheAttribute::class,
        'strasse' => StrasseAttribute::class,
        'plz' => PlzAttribute::class,
        'ort' => OrtAttribute::class,
        'land' => LandAttribute::class,
        'breitengrad' => BreitengradAttribute::class,
        'laengengrad' => LaengengradAttribute::class,
        'balkon' => BalkonAttribute::class,
        'terrasse' => TerrasseAttribute::class,
        'sauna' => SaunaAttribute::class,
        'kamin' => KaminAttribute::class,
        'fahrstuhl' => FahrstuhlAttribute::class,
        'objektart' => ObjektartAttribute::class,
        'vermarktungsart' => VermarktungsartAttribute::class,
        'zustand' => ZustandAttribute::class,
        'energieausweistyp' => EnergieausweistypAttribute::class,
        'energyClass' => EnergyClassAttribute::class,
        'erstellt_am' => ErstelltAmAttribute::class,
        'geaendert_am' => GeaendertAmAttribute::class,
        'verkauft' => VerkauftAttribute::class,
        'reserviert' => ReserviertAttribute::class,
        'objekttitel' => ObjekttitelAttribute::class,
        'objekttyp' => ObjekttypAttribute::class,
        'grundstuecksflaeche' => GrundstuecksflaecheAttribute::class,
        'anzahl_zimmer' => AnzahlZimmerAttribute::class,
        'baujahr' => BaujahrAttribute::class,
        'lage' => LageAttribute::class,
        'objektbeschreibung' => ObjektbeschreibungAttribute::class,
        'ausstatt_beschr' => AusstattBeschrAttribute::class,
        'sonstige_angaben' => SonstigeAngabenAttribute::class,
        'warmmiete' => WarmmieteAttribute::class,
        'kaltmiete' => KaltmieteAttribute::class,
        'nebenkosten' => NebenkostenAttribute::class,
        'multiParkingLot' => MultiParkingLotAttribute::class,
        'einliegerwohnung' => EinliegerwohnungAttribute::class,
    ];

    /**
     * Get the attribute class for a given API field name.
     *
     * @param string $fieldName The snake_case field name from API
     *
     * @return class-string<AbstractAttribute>|null
     */
    public function getAttributeClass(string $fieldName): ?string
    {
        return self::FIELD_TO_ATTRIBUTE[$fieldName] ?? null;
    }

    /**
     * Get all field name to attribute class mappings.
     *
     * @return array<string, class-string<AbstractAttribute>>
     */
    public function getFieldToAttributeMap(): array
    {
        return self::FIELD_TO_ATTRIBUTE;
    }

    /**
     * Check if a field has an associated attribute class.
     */
    public function hasAttribute(string $fieldName): bool
    {
        return isset(self::FIELD_TO_ATTRIBUTE[$fieldName]);
    }

    /**
     * Get a list of all mapped field names.
     *
     * @return string[]
     */
    public function getMappedFields(): array
    {
        return array_keys(self::FIELD_TO_ATTRIBUTE);
    }

    /**
     * Get attribute instances for a list of field names.
     *
     * @param string[] $fieldNames
     *
     * @return AbstractAttribute[]
     */
    public function getAttributesForFields(array $fieldNames): array
    {
        $attributes = [];

        foreach ($fieldNames as $fieldName) {
            $class = $this->getAttributeClass($fieldName);
            if ($class !== null) {
                $attributes[$fieldName] = new $class();
            }
        }

        return $attributes;
    }

    /**
     * Validate that a field exists in the attribute system.
     */
    public function isKnownField(string $fieldName): bool
    {
        return $this->hasAttribute($fieldName);
    }

    /**
     * Get the type of a field based on its attribute.
     */
    public function getFieldType(string $fieldName): ?string
    {
        $class = $this->getAttributeClass($fieldName);
        if ($class === null) {
            return null;
        }

        $attribute = new $class();

        return $attribute->getType();
    }

    /**
     * Check if a field is numeric (integer or float).
     */
    public function isNumericField(string $fieldName): bool
    {
        $class = $this->getAttributeClass($fieldName);
        if ($class === null) {
            return false;
        }

        $attribute = new $class();

        return $attribute->isNumeric();
    }

    /**
     * Check if a field is a select type (singleselect or multiselect).
     */
    public function isSelectField(string $fieldName): bool
    {
        $class = $this->getAttributeClass($fieldName);
        if ($class === null) {
            return false;
        }

        $attribute = new $class();

        return $attribute->isSelect() || $attribute->isMultiSelect();
    }

    /**
     * Get permitted values for a select field.
     *
     * @return array<string, string>|null
     */
    public function getPermittedValues(string $fieldName): ?array
    {
        $class = $this->getAttributeClass($fieldName);
        if ($class === null) {
            return null;
        }

        $attribute = new $class();

        return $attribute->getPermittedValues();
    }
}
