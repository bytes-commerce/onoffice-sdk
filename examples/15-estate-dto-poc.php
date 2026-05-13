<?php

declare(strict_types=1);

/**
 * Estate DTO - Working Example
 *
 * This script demonstrates how to fetch estates using EstateAction::read().
 * - Uses EstateAction::read() instead of callGeneric
 * - Uses filter parameter instead of recordids
 * - Uses additional parameters: estatelanguage, outputlanguage, addMainLangId
 *
 * API Reference: https://apidoc.onoffice.de/actions/datensatz-lesen/objekte/
 *
 * Usage:
 *   php examples/15-estate-dto-poc.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\DTO\Estate\EstateDTO;
use BytesCommerce\OnOffice\DTO\Estate\EstateDTOFactory;

$apiToken = getenv('ONOFFICE_API_TOKEN') ?: throw new RuntimeException('ONOFFICE_API_TOKEN environment variable not set');
$apiSecret = getenv('ONOFFICE_API_SECRET') ?: throw new RuntimeException('ONOFFICE_API_SECRET environment variable not set');

$sdk = new Api($apiToken, $apiSecret);

$estateAction = $sdk->getEstateAction();

// ============================================================================
// Key fields to fetch
// ============================================================================

$keyFields = [
    'Id', 'objekttitel', 'objektbeschreibung', 'lage', 'ausstatt_beschr', 'sonstige_angaben',
    'kaufpreis', 'mietpreis', 'nettokaltmiete', 'kaltmiete', 'warmmiete', 'nebenkosten',
    'heizkosten', 'hausgeld', 'erbpacht', 'pacht', 'kaution',
    'waehrung', 'aussen_courtage', 'innen_courtage', 'provisionsAbgabe',
    'vermarktungsart', 'nutzungsart', 'objektart', 'objekttyp', 'zustand',
    'baujahr', 'baujahrBem', 'erstellt_am', 'geaendert_am', 'letzte_aktion',
    'verfuegbar_ab', 'abdatum',
    'vermietet', 'denkmalgeschuetzt', 'gewerbliche_nutzung', 'haustiere',
    'wohnflaeche', 'nutzflaeche', 'gesamtflaeche', 'grundstuecksflaeche',
    'anzahl_zimmer', 'anzahl_schlafzimmer', 'anzahl_badezimmer',
    'anzahl_balkone', 'anzahl_terrassen', 'etagen_zahl', 'etage',
    'balkon', 'terrasse', 'wintergarten', 'kamin', 'sauna', 'kabel_sat_tv',
    'einliegerwohnung', 'stammobjekt',
    'strasse', 'hausnummer', 'plz', 'ort', 'land', 'bundesland',
    'breitengrad', 'laengengrad', 'flur', 'flurstueck', 'gemarkung',
    'scout_region', 'wohnungsnr', 'regionaler_zusatz',
    'heizungsart', 'befeuerung', 'boden', 'fahrstuhl', 'fenster', 'unterkellert',
    'energietraeger', 'energieausweistyp', 'energyClass', 'energieausweisBaujahr',
    'energieausweis_gueltig_bis',
    'endenergiebedarf', 'energieverbrauchskennwert',
    'endenergiebedarfWaerme', 'endenergieverbrauchWaerme',
    'endenergiebedarfStrom', 'endenergieverbrauchStrom',
    'warmwasserEnthalten', 'heizkosten_in_nebenkosten',
];

// ============================================================================
// Make the API call - using filter instead of recordids
// ============================================================================

echo "Fetching estates using EstateAction::read()...\n";
echo "Parameters:\n";
echo '  - data: ' . count($keyFields) . " fields\n";
echo "  - filter: empty (gets all estates)\n";
echo "  - sortby: geaendert_am DESC\n";
echo "  - listlimit: 10\n";
echo "  - formatoutput: true\n";
echo "  - estatelanguage: DEU\n";
echo "  - outputlanguage: DEU\n";
echo "  - addMainLangId: true\n\n";

$response = $estateAction->read([
    'data' => $keyFields,
    'filter' => [], // Empty filter - get all estates
    'sortby' => ['geaendert_am' => 'DESC'],
    'listlimit' => 10,
    'formatoutput' => true,
    'estatelanguage' => 'DEU',
    'outputlanguage' => 'DEU',
    'addMainLangId' => true,
]);

echo "Raw API Response:\n";
echo '  status code: ' . ($response['status']['code'] ?? 'N/A') . "\n";
echo '  status errorcode: ' . ($response['status']['errorcode'] ?? 'N/A') . "\n";
echo '  status message: ' . ($response['status']['message'] ?? 'N/A') . "\n";

$records = $response['data']['records'] ?? [];
$totalCount = $response['data']['meta']['cntabsolute'] ?? 0;

echo "\nResults:\n";
echo "  Total estates: {$totalCount}\n";
echo '  Retrieved: ' . count($records) . " records\n\n";

// ============================================================================
// Step 2: Convert raw API response to typed DTOs
// ============================================================================

if (empty($records)) {
    echo "ERROR: No records returned! Check your API credentials and server URL.\n";
    echo "\nDebug info:\n";
    echo '  Full response: ' . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    exit(1);
}

echo "Converting to DTOs...\n";

$factory = new EstateDTOFactory();
$estates = $factory->fromRecords($records);

// ============================================================================
// Step 3: Demonstrate DTO usage
// ============================================================================

echo "\n";
echo "=================================================================\n";
echo " ESTATE DTO - WORKING EXAMPLE\n";
echo "=================================================================\n\n";

/** @var EstateDTO $estate */
foreach ($estates as $index => $estate) {
    echo "--- Estate #{$index} ---\n";
    echo 'ID: ' . $estate->getId() . "\n";
    echo 'Title: ' . ($estate->objekttitel ?? 'N/A') . "\n";
    echo 'Modified: ' . ($estate->geaendertAm ?? 'N/A') . "\n";

    // Address
    $address = $estate->getFormattedAddress();
    echo 'Address: ' . ($address ?? 'N/A') . "\n";

    // Coordinates
    if ($estate->hasCoordinates()) {
        $coords = $estate->getCoordinates();
        echo "Coordinates: {$coords['latitude']}, {$coords['longitude']}\n";
    }

    // Pricing
    if ($estate->isForSale()) {
        echo 'For SALE: ' . number_format($estate->kaufpreis, 2) . ' ' . ($estate->waehrung ?? 'EUR') . "\n";
    }
    if ($estate->isForRent()) {
        echo 'For RENT: ' . number_format($estate->mietpreis, 2) . ' ' . ($estate->waehrung ?? 'EUR') . "\n";
        if ($estate->warmmiete !== null) {
            echo '  (Warm rent: ' . number_format($estate->warmmiete, 2) . ")\n";
        }
    }

    // Key metrics
    if ($estate->wohnflaeche !== null) {
        echo "Living Area: {$estate->wohnflaeche} m²\n";
    }
    if ($estate->anzahlZimmer !== null) {
        echo "Rooms: {$estate->anzahlZimmer}\n";
    }
    if ($estate->grundstuecksflaeche !== null) {
        echo "Plot Size: {$estate->grundstuecksflaeche} m²\n";
    }

    // Energy
    if ($estate->energieausweistyp !== null) {
        echo "Energy Certificate: {$estate->energieausweistyp}\n";
    }
    if ($estate->energyClass !== null) {
        echo "Energy Class: {$estate->energyClass}\n";
    }

    // Features
    $features = [];
    if ($estate->balkon) { $features[] = 'Balcony'; }
    if ($estate->terrasse) { $features[] = 'Terrace'; }
    if ($estate->kamin) { $features[] = 'Fireplace'; }
    if ($estate->sauna) { $features[] = 'Sauna'; }
    if ($estate->fahrstuhl) { $features[] = 'Elevator'; }
    if ($estate->einliegerwohnung) { $features[] = 'Guest Apartment'; }
    if (!empty($features)) {
        echo 'Features: ' . implode(', ', $features) . "\n";
    }

    // Parking
    if ($estate->parkingLot !== null) {
        echo "Parking: {$estate->parkingLot->getTotalCount()} spots (Total: {$estate->parkingLot->getTotalPrice()} EUR)\n";
    }

    echo "\n";
}

echo "=================================================================\n";
echo "DTO METHODS DEMONSTRATION\n";
echo "=================================================================\n\n";

/** @var EstateDTO $sampleEstate */
$sampleEstate = $estates[0] ?? null;

if ($sampleEstate !== null) {
    echo "Sample Estate ID: {$sampleEstate->getId()}\n";
    echo '  isForSale(): ' . ($sampleEstate->isForSale() ? 'true' : 'false') . "\n";
    echo '  isForRent(): ' . ($sampleEstate->isForRent() ? 'true' : 'false') . "\n";
    echo '  hasCoordinates(): ' . ($sampleEstate->hasCoordinates() ? 'true' : 'false') . "\n";
    echo '  getPrice(): ' . ($sampleEstate->getPrice() ?? 'null') . "\n";
    echo '  getRentPrice(): ' . ($sampleEstate->getRentPrice() ?? 'null') . "\n";
    echo '  getFormattedAddress(): ' . ($sampleEstate->getFormattedAddress() ?? 'null') . "\n";
    echo '  rawData keys: ' . implode(', ', array_keys($sampleEstate->rawData)) . "\n";
}

echo "\n";
echo "=================================================================\n";
echo "RAW API ELEMENTS (for reference)\n";
echo "=================================================================\n\n";

if ($sampleEstate !== null) {
    $keys = array_keys($sampleEstate->rawData);
    echo 'Available fields in rawData (' . count($keys) . "):\n";
    foreach ($keys as $key) {
        $value = $sampleEstate->rawData[$key];
        $displayValue = is_scalar($value) ? (string) $value : json_encode($value);
        if (strlen($displayValue) > 50) {
            $displayValue = substr($displayValue, 0, 50) . '...';
        }
        echo "  {$key}: {$displayValue}\n";
    }
}

echo "\n";
echo "=================================================================\n";
echo "FULL JSON OUTPUT\n";
echo "=================================================================\n\n";

$output = [
    'meta' => [
        'enumerated_at' => date('Y-m-d H:i:s'),
        'total_estates' => $totalCount,
        'retrieved' => count($records),
    ],
    'estates' => array_map(static fn (EstateDTO $e) => [
        'id' => $e->getId(),
        'title' => $e->objekttitel,
        'address' => $e->getFormattedAddress(),
        'coordinates' => $e->getCoordinates(),
        'is_for_sale' => $e->isForSale(),
        'is_for_rent' => $e->isForRent(),
        'kaufpreis' => $e->kaufpreis,
        'mietpreis' => $e->mietpreis,
        'warmmiete' => $e->warmmiete,
        'kaltmiete' => $e->kaltmiete,
        'nebenkosten' => $e->nebenkosten,
        'wohnflaeche' => $e->wohnflaeche,
        'grundstuecksflaeche' => $e->grundstuecksflaeche,
        'anzahl_zimmer' => $e->anzahlZimmer,
        'vermarktungsart' => $e->vermarktungsart,
        'objektart' => $e->objektart,
        'objekttyp' => $e->objekttyp,
        'zustand' => $e->zustand,
        'energy_class' => $e->energyClass,
        'features' => [
            'balkon' => $e->balkon,
            'terrasse' => $e->terrasse,
            'kamin' => $e->kamin,
            'sauna' => $e->sauna,
            'fahrstuhl' => $e->fahrstuhl,
            'einliegerwohnung' => $e->einliegerwohnung,
        ],
    ], $estates),
];

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
