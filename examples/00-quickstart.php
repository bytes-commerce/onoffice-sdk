<?php

declare(strict_types=1);

/**
 * Quickstart Example - Read Estates
 *
 * This example demonstrates the simplest way to read estates from the onOffice API
 * using the SDK's EstateAction getter.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-lesen/objekte/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

// Initialize SDK with your API credentials (token and secret)
$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');

// Get the EstateAction - no need to pass credentials to individual actions
$response = $sdk->getEstateAction()->read([
    'data' => [
        'Id',
        'kaufpreis',
        'objektart',
        'objekttyp',
        'ort',
        'plz',
        'wohnflaeche',
        'anzahl_zimmer',
    ],
    'listlimit' => 10,
]);

echo "Estates retrieved successfully!\n";
echo 'Number of records: ' . count($response['data']['records'] ?? []) . "\n";
