<?php

declare(strict_types=1);

/**
 * Address Reading Examples
 *
 * Demonstrates various ways to read addresses from onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-lesen/adressen/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$addressAction = $sdk->getAddressAction();

// Example 1: Read specific addresses by ID
echo "=== Read specific addresses by ID ===\n";

$response = $addressAction->read([
    'data' => ['Id', 'Vorname', 'Name', 'Email', 'Telefon'],
    'recordids' => [10_505, 10_509],
]);

print_r($response);

// Example 2: Search addresses by name
echo "\n=== Search addresses by name (LIKE) ===\n";

$response = $addressAction->read([
    'data' => ['Id', 'Vorname', 'Name', 'Email', 'Telefon', 'Ort', 'Plz'],
    'filter' => [
        'Name' => [
            ['op' => 'LIKE', 'val' => 'M%'], // Names starting with M
        ],
    ],
    'sortby' => 'Name',
    'sortorder' => 'ASC',
    'listlimit' => 100,
]);

print_r($response);

// Example 3: Read addresses with all fields
echo "\n=== Read with format output ===\n";

$response = $addressAction->read([
    'data' => ['Id', 'Vorname', 'Name', 'Email', 'Telefon', 'Strasse', 'Plz', 'Ort', 'Land'],
    'formatoutput' => true,
    'listlimit' => 10,
]);

print_r($response);
