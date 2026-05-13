<?php

declare(strict_types=1);

/**
 * Address Creation Example
 *
 * Demonstrates how to create a new address (contact) in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-anlegen/adressen/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$addressAction = $sdk->getAddressAction();

// Create a new contact
$response = $addressAction->create([
    'data' => [
        // Personal info
        'Anrede' => 'Frau',
        'Titel' => 'Dr.',
        'Vorname' => 'Maxine',
        'Name' => 'Mustermann',
        'Namenszusatz' => 'von Haustadt',

        // Contact details
        'Email' => 'maxine.mustermann@example.de',
        'Telefon' => '+49 241 123456',
        'Telefon2' => '+49 170 987654',
        'Mobilruf' => '+49 160 1234567',

        // Address
        'Strasse' => 'Hauptstrasse',
        'Hausnummer' => '123',
        'Plz' => '52068',
        'Ort' => 'Aachen',
        'Bundesland' => 'Nordrhein-Westfalen',
        'Land' => 'DEU',

        // Company
        'Firma' => 'Musterbau GmbH',
        'Abteilung' => 'Vertrieb',

        // Additional
        'Geburtstag' => '1985-06-15',
        'Freitext' => 'VIP-Kunde, bevorzugt kontaktieren',
    ],
]);

echo "Address created successfully!\n";
echo 'New Address ID: ' . ($response['data']['id'] ?? 'unknown') . "\n";
print_r($response);
