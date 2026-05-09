<?php

/**
 * Estate Reading Examples
 *
 * Demonstrates various ways to read estates with filters, sorting, and pagination.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-lesen/objekte/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$estateAction = $sdk->getEstateAction();

// Example 1: Read specific estates by ID
echo "=== Read specific estates by ID ===\n";

$response = $estateAction->read([
    'data' => ['Id', 'kaufpreis', 'ort', 'plz'],
    'recordids' => [123, 456, 789],
]);

print_r($response);

// Example 2: Read with price filter (only active listings over 300k)
echo "\n=== Read with price filter ===\n";

$response = $estateAction->read([
    'data' => ['Id', 'kaufpreis', 'ort', 'plz', 'status'],
    'filter' => [
        'kaufpreis' => [
            ['op' => '>', 'val' => 300000],
        ],
        'status' => [
            ['op' => '=', 'val' => 1], // 1 = Active
        ],
    ],
    'listlimit' => 50,
    'sortby' => 'kaufpreis',
    'sortorder' => 'ASC',
]);

print_r($response);

// Example 3: Geo search for properties in a specific area
echo "\n=== Geo search ===\n";

$response = $estateAction->read([
    'data' => ['Id', 'kaufpreis', 'ort', 'plz'],
    'georangesearch' => [
        'country' => 'DEU',
        'zip' => '52068',
        'radius' => '25', // 25km radius
    ],
]);

print_r($response);

// Example 4: Read with multiple filter conditions
echo "\n=== Read with multiple filter conditions ===\n";

$response = $estateAction->read([
    'data' => ['Id', 'kaufpreis', 'wohnflaeche', 'anzahl_zimmer', 'ort'],
    'filter' => [
        'vermarktungsart' => [
            ['op' => '=', 'val' => 'kauf'],
        ],
        'objektart' => [
            ['op' => '=', 'val' => 'haus'],
        ],
        'kaufpreis__von' => [
            ['op' => '>=', 'val' => 200000],
        ],
        'kaufpreis__bis' => [
            ['op' => '<=', 'val' => 500000],
        ],
        'wohnflaeche__von' => [
            ['op' => '>=', 'val' => 100],
        ],
    ],
    'sortby' => 'kaufpreis',
    'sortorder' => 'ASC',
]);

print_r($response);
