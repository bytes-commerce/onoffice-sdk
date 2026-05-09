<?php

/**
 * Estate Quick Search Example
 *
 * Demonstrates the quick search functionality for finding estates.
 *
 * @see https://apidoc.onoffice.de/actions/schnellsuche/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$estateAction = $sdk->getEstateAction();

// Simple search by city
echo "=== Search by city name ===\n";

$response = $estateAction->quickSearch([
    'input' => 'Berlin',
]);

print_r($response);

// Search with filters
echo "\n=== Search with filters ===\n";

$response = $estateAction->quickSearch([
    'input' => 'Berlin',
    'filter' => [
        'vermarktungsart' => [
            ['op' => '=', 'val' => 'kauf'],
        ],
    ],
    'sortby' => 'kaufpreis',
    'sortorder' => 'ASC',
    'listlimit' => 20,
    'includeThumbnail' => 'medium',
]);

print_r($response);

// Search for rent properties
echo "\n=== Search for rent properties ===\n";

$response = $estateAction->quickSearch([
    'input' => 'Aachen',
    'filter' => [
        'vermarktungsart' => [
            ['op' => '=', 'val' => 'miete'],
        ],
        'mietpreis__bis' => [
            ['op' => '<=', 'val' => 1000],
        ],
    ],
    'sortby' => 'mietpreis',
    'sortorder' => 'ASC',
]);

print_r($response);
