<?php

declare(strict_types=1);

/**
 * Address DTO Proof of Concept
 *
 * This script demonstrates how to convert raw API address data into typed DTOs.
 *
 * API Reference: https://apidoc.onoffice.de/actions/datensatz-lesen/adressen/
 *
 * Usage:
 *   php examples/16-address-dto-poc.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\ApiInterface;
use BytesCommerce\OnOffice\DTO\Address\AddressDTO;
use BytesCommerce\OnOffice\DTO\Address\AddressDTOFactory;

$apiToken = getenv('ONOFFICE_API_TOKEN') ?: throw new RuntimeException('ONOFFICE_API_TOKEN environment variable not set');
$apiSecret = getenv('ONOFFICE_API_SECRET') ?: throw new RuntimeException('ONOFFICE_API_SECRET environment variable not set');

$sdk = new Api($apiToken, $apiSecret);
$sdk->setApiServer('https://api.onoffice.de/api/');
$sdk->setApiVersion('stable');

// ============================================================================
// Step 1: Fetch sample addresses
// ============================================================================

echo "Fetching sample addresses...\n";

$sampleFields = [
    'Id', 'Anrede', 'Titel', 'Vorname', 'Name', 'Firma',
    'Strasse', 'Plz', 'Ort', 'Land', 'Bundesland',
    'Telefon', 'Telefon2', 'Telefon3', 'Mobil', 'Telefax',
    'Email', 'Homepage', 'Geburtsdatum',
    'ErstelltAm', 'GeaendertAm',
    'Freitext1', 'Freitext2', 'Freitext3', 'Freitext4', 'Freitext5',
    'Aktiv', 'Newsletter',
    'Strasse2', 'Plz2', 'Ort2', 'Land2',
];

$handle = $sdk->callGeneric(ApiInterface::ACTION_ID_READ, ApiInterface::MODULE_ADDRESS, [
    'data' => $sampleFields,
    'sortby' => ['Name' => 'ASC'],
    'listlimit' => 10,
    'formatoutput' => true,
]);

$sdk->sendRequestsWithCredentials();
$response = $sdk->getResponseArray($handle);

$records = $response['data']['records'] ?? [];
$totalCount = $response['data']['meta']['cntabsolute'] ?? 0;

echo "Total addresses: {$totalCount}\n";
echo 'Retrieved: ' . count($records) . " records\n\n";

// ============================================================================
// Step 2: Convert raw API response to typed DTOs
// ============================================================================

echo "Converting to DTOs...\n";

$factory = new AddressDTOFactory();
$addresses = $factory->fromRecords($records);

// ============================================================================
// Step 3: Demonstrate DTO usage
// ============================================================================

echo "\n";
echo "=================================================================\n";
echo " ADDRESS DTO PROOF OF CONCEPT\n";
echo "=================================================================\n\n";

/** @var AddressDTO $address */
foreach ($addresses as $index => $address) {
    echo "--- Address #{$index} ---\n";
    echo 'ID: ' . $address->getId() . "\n";

    // Name and company
    $fullName = $address->getFullName();
    if ($fullName !== null) {
        echo "Name: {$fullName}\n";
    }
    if ($address->firma !== null) {
        echo "Company: {$address->firma}\n";
    }

    // Address
    $formattedAddress = $address->getFormattedAddress();
    if ($formattedAddress !== null) {
        echo "Address: {$formattedAddress}\n";
    }

    // Contact
    if ($address->email !== null) {
        echo "Email: {$address->email}\n";
    }
    if ($address->telefon !== null) {
        echo "Phone: {$address->telefon}\n";
    }
    if ($address->mobil !== null) {
        echo "Mobile: {$address->mobil}\n";
    }

    // Status
    if ($address->aktiv !== null) {
        echo 'Active: ' . ($address->aktiv ? 'Yes' : 'No') . "\n";
    }
    if ($address->newsletter !== null) {
        echo 'Newsletter: ' . ($address->newsletter ? 'Yes' : 'No') . "\n";
    }

    echo "\n";
}

echo "=================================================================\n";
echo "DTO METHODS DEMONSTRATION\n";
echo "=================================================================\n\n";

/** @var AddressDTO $sampleAddress */
$sampleAddress = $addresses[0] ?? null;

if ($sampleAddress !== null) {
    echo "Sample Address ID: {$sampleAddress->getId()}\n";
    echo '  getFullName(): ' . ($sampleAddress->getFullName() ?? 'null') . "\n";
    echo '  getFormattedAddress(): ' . ($sampleAddress->getFormattedAddress() ?? 'null') . "\n";
    echo "  getFormattedFullAddress():\n" . ($sampleAddress->getFormattedFullAddress() ?? 'null') . "\n";
    echo '  getPrimaryEmail(): ' . ($sampleAddress->getPrimaryEmail() ?? 'null') . "\n";
    echo '  getPrimaryPhone(): ' . ($sampleAddress->getPrimaryPhone() ?? 'null') . "\n";
    echo '  hasAddress(): ' . ($sampleAddress->hasAddress() ? 'true' : 'false') . "\n";
    echo '  isActive(): ' . ($sampleAddress->isActive() ?? 'null') . "\n";
    echo '  hasNewsletter(): ' . ($sampleAddress->hasNewsletter() ?? 'null') . "\n";
}

echo "\n";
echo "=================================================================\n";
echo "RAW API ELEMENTS (for reference)\n";
echo "=================================================================\n\n";

if ($sampleAddress !== null) {
    $keys = array_keys($sampleAddress->rawData);
    echo 'Available fields in rawData (' . count($keys) . "):\n";
    foreach ($keys as $key) {
        $value = $sampleAddress->rawData[$key];
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
        'total_addresses' => $totalCount,
        'retrieved' => count($records),
    ],
    'addresses' => array_map(static fn (AddressDTO $a) => [
        'id' => $a->getId(),
        'full_name' => $a->getFullName(),
        'company' => $a->firma,
        'formatted_address' => $a->getFormattedAddress(),
        'email' => $a->email,
        'phone' => $a->telefon,
        'mobile' => $a->mobil,
        'land' => $a->land,
        'aktiv' => $a->aktiv,
        'newsletter' => $a->newsletter,
    ], $addresses),
];

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
