<?php

declare(strict_types=1);

/**
 * Relation Examples
 *
 * Demonstrates how to create and manage relations between records in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-anlegen/relations/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$relationAction = $sdk->getRelationAction();

// Example 1: Link an address to an estate (prospect/buyer relation)
echo "=== Create address-estate relation ===\n";

$response = $relationAction->create([
    'data' => [
        'addressid' => 247,
        'estateid' => 123,
        'type' => 'Anbieter_Sonstige',
        'stage' => 'active',
    ],
]);

echo "Relation created successfully!\n";
print_r($response);

// Example 2: Create owner relation
echo "\n=== Create owner relation ===\n";

$response = $relationAction->create([
    'data' => [
        'addressid' => 500,
        'estateid' => 123,
        'type' => 'Eigentuemer',
        'stage' => 'active',
        'vertriebsart' => 'Alleinauftrag',
    ],
]);

print_r($response);

// Example 3: Get all relations for an estate
echo "\n=== Get all relations for an estate ===\n";

$response = $relationAction->getRelations([
    'addressid' => 247, // Get relations involving this address
]);

print_r($response);

// Example 4: Get relations filtered by type
echo "\n=== Get buyer relations ===\n";

$response = $relationAction->getRelations([
    'estateid' => 123,
    'filter' => [
        'type' => [
            ['op' => 'LIKE', 'val' => '%Kaufinteressent%'],
        ],
    ],
]);

print_r($response);
