<?php

declare(strict_types=1);

/**
 * Estate Modification Example
 *
 * Demonstrates how to update an existing estate in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-bearbeiten/objekte/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$estateAction = $sdk->getEstateAction();

// Update the price and status of an estate
$response = $estateAction->modify('123', [
    'data' => [
        // Update price
        'kaufpreis' => 375_000,

        // Update status (1=Active, 2=Pending, 0=Archived)
        'status' => 2,

        // Update description
        'beschreibung' => 'Updated description - price reduced!',
    ],
]);

echo "Estate updated successfully!\n";
echo "Estate ID: 123\n";
print_r($response);

// Example: Mark property as sold
echo "\n=== Mark estate as sold/archived ===\n";

$response = $estateAction->modify('456', [
    'data' => [
        'status' => 0, // Archived
        'vermarktungsart' => 'verkauft',
    ],
]);

print_r($response);
