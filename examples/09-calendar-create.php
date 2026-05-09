<?php

/**
 * Calendar (Appointment) Examples
 *
 * Demonstrates how to create and manage calendar appointments in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-anlegen/kalender/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$calendarAction = $sdk->getCalendarAction();

// Example 1: Create an appointment with related estate and address
echo "=== Create appointment with related records ===\n";

$response = $calendarAction->create([
    'data' => [
        // Appointment details
        'description' => 'Property viewing with prospective buyer',
        'start_dt' => '2024-06-15 14:00:00',
        'end_dt' => '2024-06-15 15:00:00',
        'art' => 'Besichtigung',
        'ganztags' => false,

        // Notes
        'note' => 'Prospect is interested in the Berlin property (ID: 608). ' .
                  'Show them the garden and the newly renovated kitchen.',

        // Visibility
        'private' => false,
        'ressources' => ['Company Car'],
    ],

    // Related records
    'relatedAddressIds' => [1935, 1931], // Multiple contacts
    'relatedEstateId' => 608,

    // Location
    'location' => ['estate' => 608],

    // Participants
    'subscribers' => [
        'users' => [14], // User IDs
        'groups' => [168, 172], // Group IDs
    ],
]);

echo "Appointment created successfully!\n";
echo "New Calendar ID: " . ($response['data']['id'] ?? 'unknown') . "\n";
print_r($response);

// Example 2: Create an all-day event
echo "\n=== Create all-day event ===\n";

$response = $calendarAction->create([
    'data' => [
        'description' => 'Company holiday - Office closed',
        'start_dt' => '2024-12-25 00:00:00',
        'end_dt' => '2024-12-26 00:00:00',
        'art' => 'Feiertag',
        'ganztags' => true,
        'private' => true,
    ],
]);

print_r($response);
