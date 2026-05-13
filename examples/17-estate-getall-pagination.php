<?php

declare(strict_types=1);

/**
 * Example: Get All Estates with Automatic Pagination
 *
 * This example demonstrates the new getAllEstates() and getLimitedEstates()
 * methods which handle pagination automatically.
 *
 * Usage:
 *   php examples/17-estate-getall-pagination.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$apiToken = getenv('ONOFFICE_API_TOKEN') ?: throw new RuntimeException('ONOFFICE_API_TOKEN environment variable not set');
$apiSecret = getenv('ONOFFICE_API_SECRET') ?: throw new RuntimeException('ONOFFICE_API_SECRET environment variable not set');

$sdk = new Api($apiToken, $apiSecret);
$sdk->setApiServer('https://api.onoffice.de/api/');
$sdk->setApiVersion('latest');

$estateAction = $sdk->getEstateAction();

// ============================================================================
// Example 1: Get ALL estates (automatic pagination)
// ============================================================================

echo "=================================================================\n";
echo " Example 1: Get ALL Estates\n";
echo "=================================================================\n\n";

echo "Fetching ALL estates with automatic pagination...\n";
echo "This may take a while if there are many estates.\n\n";

$startTime = microtime(true);

$result = $estateAction->getAllEstates(
    fields: ['Id', 'kaufpreis', 'lage', 'ort', 'plz', 'wohnflaeche', 'anzahl_zimmer'],
    sortBy: ['geaendert_am' => 'DESC'],
);

$endTime = microtime(true);
$duration = round($endTime - $startTime, 2);

$estates = $result['data']['records'] ?? [];
$meta = $result['data']['meta'] ?? [];

echo "Results:\n";
echo '  - Total estates: ' . count($estates) . "\n";
echo '  - Pages fetched: ' . ($meta['pages'] ?? 'N/A') . "\n";
echo "  - Duration: {$duration}s\n\n";

// Show preview
echo "Preview (first 5 estates):\n\n";
$preview = array_slice($estates, 0, 5);
foreach ($preview as $index => $estate) {
    $e = $estate['elements'] ?? [];
    echo "--- Estate #{$index} ---\n";
    echo 'ID: ' . ($e['Id'] ?? 'N/A') . "\n";
    echo 'Location: ' . ($e['plz'] ?? '') . ' ' . ($e['ort'] ?? '') . "\n";
    echo 'Price: ' . number_format($e['kaufpreis'] ?? 0) . " EUR\n";
    echo 'Living Area: ' . ($e['wohnflaeche'] ?? 'N/A') . " m²\n";
    echo 'Rooms: ' . ($e['anzahl_zimmer'] ?? 'N/A') . "\n";
    echo "\n";
}

// ============================================================================
// Example 2: Get LIMITED estates (first N records)
// ============================================================================

echo "\n";
echo "=================================================================\n";
echo " Example 2: Get LIMITED Estates (first 50)\n";
echo "=================================================================\n\n";

echo "Fetching first 50 estates...\n\n";

$startTime2 = microtime(true);

$result2 = $estateAction->getLimitedEstates(
    maxRecords: 50,
    fields: ['Id', 'kaufpreis', 'ort', 'plz'],
    sortBy: ['kaufpreis' => 'ASC'],
);

$endTime2 = microtime(true);
$duration2 = round($endTime2 - $startTime2, 2);

$estates2 = $result2['data']['records'] ?? [];
$meta2 = $result2['data']['meta'] ?? [];

echo "Results:\n";
echo '  - Requested: ' . ($meta2['requested'] ?? 50) . "\n";
echo '  - Received: ' . count($estates2) . "\n";
echo '  - Pages fetched: ' . ($meta2['pages'] ?? 'N/A') . "\n";
echo "  - Duration: {$duration2}s\n\n";

// Show preview
echo "Preview (first 5 estates):\n\n";
$preview2 = array_slice($estates2, 0, 5);
foreach ($preview2 as $index => $estate) {
    $e = $estate['elements'] ?? [];
    echo "--- Estate #{$index} ---\n";
    echo 'ID: ' . ($e['Id'] ?? 'N/A') . "\n";
    echo 'Location: ' . ($e['plz'] ?? '') . ' ' . ($e['ort'] ?? '') . "\n";
    echo 'Price: ' . number_format($e['kaufpreis'] ?? 0) . " EUR\n";
    echo "\n";
}

// ============================================================================
// Example 3: Get filtered estates
// ============================================================================

echo "\n";
echo "=================================================================\n";
echo " Example 3: Get FILTERED Estates\n";
echo "=================================================================\n\n";

echo "Fetching all estates with status=1 and kaufpreis < 300000...\n\n";

$startTime3 = microtime(true);

$result3 = $estateAction->getAllEstates(
    fields: ['Id', 'kaufpreis', 'ort', 'plz', 'status'],
    sortBy: ['kaufpreis' => 'ASC'],
    filter: [
        'status' => [['op' => '=', 'val' => 1]],
        'kaufpreis' => [['op' => '<', 'val' => 300_000]],
    ],
);

$endTime3 = microtime(true);
$duration3 = round($endTime3 - $startTime3, 2);

$estates3 = $result3['data']['records'] ?? [];
$meta3 = $result3['data']['meta'] ?? [];

echo "Results:\n";
echo '  - Total filtered estates: ' . count($estates3) . "\n";
echo '  - Pages fetched: ' . ($meta3['pages'] ?? 'N/A') . "\n";
echo "  - Duration: {$duration3}s\n\n";

// Show preview
$preview3 = array_slice($estates3, 0, 5);
foreach ($preview3 as $index => $estate) {
    $e = $estate['elements'] ?? [];
    echo "--- Estate #{$index} ---\n";
    echo 'ID: ' . ($e['Id'] ?? 'N/A') . "\n";
    echo 'Location: ' . ($e['plz'] ?? '') . ' ' . ($e['ort'] ?? '') . "\n";
    echo 'Price: ' . number_format($e['kaufpreis'] ?? 0) . " EUR\n";
    echo 'Status: ' . ($e['status'] ?? 'N/A') . "\n";
    echo "\n";
}

// ============================================================================
// Output JSON
// ============================================================================

echo "\n";
echo "=================================================================\n";
echo " JSON OUTPUT\n";
echo "=================================================================\n\n";

$output = [
    'example1_all_estates' => [
        'meta' => $meta,
        'total' => count($estates),
        'preview' => $preview,
    ],
    'example2_limited_estates' => [
        'meta' => $meta2,
        'total' => count($estates2),
        'preview' => $preview2,
    ],
    'example3_filtered_estates' => [
        'meta' => $meta3,
        'total' => count($estates3),
        'preview' => $preview3,
    ],
];

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
