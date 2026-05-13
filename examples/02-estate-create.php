<?php

declare(strict_types=1);

/**
 * Estate Creation Example
 *
 * Demonstrates how to create a new estate in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/datensatz-anlegen/objekte/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$estateAction = $sdk->getEstateAction();

// Create a new house listing
$response = $estateAction->create([
    'data' => [
        // Property type and usage
        'objektart' => 'haus',
        'nutzungsart' => 'wohnen',
        'vermarktungsart' => 'kauf',
        'objekttyp' => 'einfamilienhaus',

        // Location
        'plz' => 52_068,
        'ort' => 'Aachen',
        'land' => 'DEU',
        'strasse' => 'Hauptstrasse 123',
        'hausnummer' => '123',

        // Price
        'kaufpreis' => 350_000,
        'kaufpreis_pro_flaeche' => 0,
        'mietpreis' => 0,
        'nebenkosten' => 0,
        'kaution' => 0,

        // Property details
        'wohnflaeche' => 120,
        'grundstuecksflaeche' => 400,
        'anzahl_zimmer' => 5,
        'anzahl_schlafzimmer' => 3,
        'anzahl_badezimmer' => 2,
        'baujahr' => 2_015,
        'zustand' => 'neuwertig',
        'barrierefrei' => true,
        'wg_geeignet' => false,

        // Energy
        'energie_ausweis_art' => 'VERBRAUCH',
        'energiekennwert' => 85,
        'energieeffizienzklasse' => 'C',
        'warmwasser_enthaltend' => true,

        // Description
        'beschreibung' => 'Schönes Einfamilienhaus in guter Lage von Aachen...',
        'lage' => 'Das Haus befindet sich in einem ruhigen Wohngebiet...',
        'ausstattung' => 'Moderne Einbauküche, hochwertige Böden, Smart Home...',

        // Media
        'freitext01' => 'Besonderheit: Großer Garten mit Südausrichtung...',

        // Contact
        'anbieter' => 1, // Reference to address ID
    ],
]);

echo "Estate created successfully!\n";
echo 'New Estate ID: ' . ($response['data']['id'] ?? 'unknown') . "\n";
print_r($response);
