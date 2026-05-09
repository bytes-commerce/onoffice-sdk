<?php

/**
 * Batch Operations Example
 *
 * Demonstrates how to batch multiple API calls for better performance.
 * This reduces HTTP overhead by combining multiple requests.
 *
 * @see https://apidoc.onoffice.de/api-reference/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');

// Queue multiple requests using low-level callGeneric/call
$handle1 = $sdk->callGeneric(
    Api::ACTION_ID_READ,
    Api::MODULE_ESTATE,
    ['data' => ['Id', 'kaufpreis'], 'recordids' => [1, 2, 3]]
);

$handle2 = $sdk->callGeneric(
    Api::ACTION_ID_READ,
    Api::MODULE_ADDRESS,
    ['data' => ['Id', 'Name', 'Email'], 'recordids' => [100, 101]]
);

$handle3 = $sdk->call(
    Api::ACTION_ID_MODIFY,
    '123',
    '',
    Api::MODULE_ESTATE,
    ['data' => ['kaufpreis' => 350000]]
);

// Send all requests in a single HTTP call
$sdk->sendRequestsWithCredentials();

// Get all responses
$estates = $sdk->getResponseArray($handle1);
$addresses = $sdk->getResponseArray($handle2);
$modifyResult = $sdk->getResponseArray($handle3);

echo "Batch operation completed!\n";
echo "Estates retrieved: " . count($estates['data']['records'] ?? []) . "\n";
echo "Addresses retrieved: " . count($addresses['data']['records'] ?? []) . "\n";
print_r($estates);
print_r($addresses);
print_r($modifyResult);
