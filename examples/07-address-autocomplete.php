<?php

declare(strict_types=1);

/**
 * Address Autocomplete Example
 *
 * Demonstrates how to use the autocomplete functionality for addresses.
 *
 * @see https://apidoc.onoffice.de/actions/adressen-autocomplete/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$addressAction = $sdk->getAddressAction();

// Autocomplete by name
echo "=== Autocomplete by name ===\n";

$response = $addressAction->autocomplete([
    'input' => 'Max',
]);

print_r($response);

// Autocomplete with filter
echo "\n=== Autocomplete with filter ===\n";

$response = $addressAction->autocomplete([
    'input' => 'Muster',
    'filter' => [
        'Name' => [
            ['op' => 'LIKE', 'val' => 'M%'],
        ],
    ],
]);

print_r($response);
