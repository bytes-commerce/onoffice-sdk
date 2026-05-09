<?php

/**
 * File Management Examples
 *
 * Demonstrates how to upload and manage files in onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/informationen-abfragen/objektdateien/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$fileAction = $sdk->getFileAction();

// Example 1: Upload a file for an estate
echo "=== Upload file to estate ===\n";

$response = $fileAction->upload([
    'filename' => '/path/to/property_image.jpg',
    'parentid' => 123, // Estate ID
    'relationtype' => 'estate',
    'title' => 'Front View',
    'art' => 'Foto',
    'freitext' => 'Main exterior photo of the property',
]);

echo "File uploaded successfully!\n";
print_r($response);

// Example 2: Modify file metadata
echo "\n=== Modify file metadata ===\n";

$response = $fileAction->modify('2983', [
    'relationtype' => 'estate',
    'parentid' => 1685,
    'Art' => 'Foto',
    'title' => 'Updated Title',
    'freitext' => 'Updated description for the image',
    'sortierung' => 1, // Display order
]);

print_r($response);

// Example 3: Upload document
echo "\n=== Upload document to estate ===\n";

$response = $fileAction->upload([
    'filename' => '/path/to/epc_certificate.pdf',
    'parentid' => 123,
    'relationtype' => 'estate',
    'title' => 'Energy Performance Certificate',
    'art' => 'Energieausweis',
]);

print_r($response);
