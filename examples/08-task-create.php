<?php

/**
 * Task (To-Do) Examples
 *
 * Demonstrates how to create and manage tasks in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-anlegen/aufgaben/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$taskAction = $sdk->getTaskAction();

// Example 1: Create a task linked to address and estate
echo "=== Create task with related records ===\n";

$response = $taskAction->create([
    'data' => [
        // Task details
        'Betreff' => 'Follow-up call with prospect',
        'Aktion' => 'Call',
        'Verantwortung' => 'robert',
        'Bearbeiter' => 'robert',

        // Description
        'Aufgabe' => 'Call Max Mustermann to discuss the property viewing.',
        'notiz' => 'Customer is interested in the Berlin property (ID: 1234). Preferred contact time: afternoon.',

        // Timing
        'Deadline' => '2024-07-01 00:00:00',
        'Prio' => 2, // 1-5, where 1 is highest priority
        'Art' => 1, // Task type ID from enterprise
        'Status' => 1, // 1-8 status values (1=Open)

        // Visibility
        'private' => false,
    ],

    // Link to related records
    'relatedAddressId' => 247,
    'relatedEstateId' => 459,
]);

echo "Task created successfully!\n";
echo "New Task ID: " . ($response['data']['id'] ?? 'unknown') . "\n";
print_r($response);

// Example 2: Create a simple reminder
echo "\n=== Create simple reminder ===\n";

$response = $taskAction->create([
    'data' => [
        'Betreff' => 'Property viewing reminder',
        'Aktion' => 'Besichtigung',
        'Verantwortung' => 'admin',
        'Deadline' => '2024-06-15 14:00:00',
        'Prio' => 1,
        'Status' => 1,
    ],
    'relatedEstateId' => 608,
]);

print_r($response);
