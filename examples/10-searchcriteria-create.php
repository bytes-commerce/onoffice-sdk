<?php

/**
 * Search Criteria Examples
 *
 * Demonstrates how to create and manage search criteria (saved searches) in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-anlegen/suchkriterien/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$searchAction = $sdk->getSearchCriteriaAction();

// Example 1: Create search criteria for a buyer
echo "=== Create buyer search criteria ===\n";

$response = $searchAction->create([
    // Link to address (the buyer)
    'addressid' => '153',

    'data' => [
        // Advisor
        'advisor' => 21,

        // Property type
        'objektart' => 'haus',
        'vermarktungsart' => 'kauf',

        // Location (postal code and city)
        'range_plz' => '52068',
        'range_ort' => 'Aachen',
        'range_strasse' => 'Charlottenburger Allee',
        'range_hausnummer' => '5',
        'range' => '100', // Radius in km

        // Price range
        'kaufpreis__von' => '50000',
        'kaufpreis__bis' => '500000',

        // Property features
        'wohnflaeche__von' => '80',
        'anzahl_zimmer__von' => '3',

        // Additional notes
        'krit_bemerkung' => 'Interested in quiet neighborhoods with good public transport connection. ' .
                           'Garden is a must. No basement preferred.',
    ],
]);

echo "Search criteria created successfully!\n";
echo "New Search Criteria ID: " . ($response['data']['id'] ?? 'unknown') . "\n";
print_r($response);

// Example 2: Create search criteria for rentals
echo "\n=== Create rental search criteria ===\n";

$response = $searchAction->create([
    'addressid' => '154',

    'data' => [
        'advisor' => 21,
        'objektart' => 'wohnung',
        'vermarktungsart' => 'miete',

        // Location
        'range_plz' => '52062',
        'range_ort' => 'Aachen',
        'range' => '10',

        // Price range (rent)
        'mietpreis__von' => '500',
        'mietpreis__bis' => '1200',

        // Size
        'wohnflaeche__von' => '50',
        'wohnflaeche__bis' => '100',

        // Features
        'kategorie' => '2 Zi.-Wohnung',
    ],
]);

print_r($response);
