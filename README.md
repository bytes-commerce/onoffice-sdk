# onOffice SDK

[![PHP Composer](https://github.com/onOfficeGmbH/sdk/actions/workflows/php.yml/badge.svg)](https://github.com/onOfficeGmbH/sdk/actions/workflows/php.yml)
[![PHP Version](https://img.shields.io/badge/PHP-8.4+-blue)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

Official PHP API client library for [onOffice](https://www.onoffice.de/) - the all-in-one CRM solution for the real estate industry.

**Developed and maintained by [bytes-commerce.de](https://www.bytes-commerce.de)**

---

## Installation

```bash
composer require bytes-commerce/onoffice-sdk
```

---

## Overview

The onOffice SDK provides a lightweight, easy-to-use PHP library for interacting with the onOffice API. It enables you to:

- **Manage Estates** - Create, read, update, and delete property listings
- **Manage Addresses** - Handle contacts, leads, and customers
- **Manage Tasks** - Create and track tasks and to-dos
- **Manage Calendar** - Schedule appointments and viewings
- **Manage Search Criteria** - Create and manage saved searches for buyers
- **Manage Files** - Upload and organize property documents and images
- **Manage Relations** - Link addresses to estates (owners, prospects, etc.)
- **Send Emails** - Send templated emails with attachments

---

## Requirements

- **PHP 8.4+**
- **ext-json** (JSON encoding/decoding)
- **ext-curl** (HTTP requests)

---

## Quick Start

```php
<?php

require_once 'vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

// Initialize SDK with your API credentials
$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');

// Get an action - no need to pass credentials to individual actions
$response = $sdk->getEstateAction()->read([
    'data' => ['Id', 'kaufpreis', 'ort', 'plz'],
    'listlimit' => 10,
]);

print_r($response);
```

---

## Usage Pattern

The SDK uses a factory pattern for action classes. Initialize the SDK once with your credentials, then get action instances as needed:

```php
$sdk = new onOfficeSDK('token', 'secret');

// Get action instances - credentials are already set
$estateAction = $sdk->getEstateAction();
$addressAction = $sdk->getAddressAction();
$taskAction = $sdk->getTaskAction();
// ... and more
```

---

## Usage Examples

### Estate Operations

```php
use BytesCommerce\OnOffice\Api;

$sdk = new Api($token, $secret);

// Read estates
$response = $sdk->getEstateAction()->read([
    'data' => ['Id', 'kaufpreis', 'ort'],
    'filter' => [
        'kaufpreis' => [['op' => '>', 'val' => 300000]],
    ],
]);

// Create estate
$response = $sdk->getEstateAction()->create([
    'data' => [
        'objektart' => 'haus',
        'vermarktungsart' => 'kauf',
        'kaufpreis' => 450000,
        'ort' => 'Aachen',
    ],
]);

// Update estate
$response = $sdk->getEstateAction()->modify('123', [
    'data' => ['kaufpreis' => 425000],
]);

// Quick search
$response = $sdk->getEstateAction()->quickSearch(['input' => 'Berlin']);
```

### Address Operations

```php
// Read addresses
$response = $sdk->getAddressAction()->read([
    'data' => ['Id', 'Name', 'Email'],
    'filter' => ['Name' => [['op' => 'LIKE', 'val' => 'M%']]],
]);

// Create address
$response = $sdk->getAddressAction()->create([
    'data' => [
        'Vorname' => 'Max',
        'Name' => 'Mustermann',
        'Email' => 'max@example.de',
    ],
]);

// Autocomplete
$response = $sdk->getAddressAction()->autocomplete(['input' => 'Max']);
```

### Task Operations

```php
$response = $sdk->getTaskAction()->create([
    'data' => [
        'Betreff' => 'Follow-up call',
        'Deadline' => '2024-07-01 00:00:00',
        'Prio' => 2,
    ],
    'relatedAddressId' => 247,
    'relatedEstateId' => 459,
]);
```

### Email Operations

```php
$response = $sdk->getEmailAction()->send([
    'emailidentity' => 'default',
    'receiver' => ['info@example.com'],
    'subject' => 'Property Viewing',
    'body' => 'I would like to schedule a viewing.',
    'estateids' => [123],
]);
```

---

## Batch Operations

The SDK supports batching multiple requests for optimal performance:

```php
use BytesCommerce\OnOffice\Api;

$sdk = new Api($token, $secret);

// Queue multiple requests
$handle1 = $sdk->callGeneric(
    Api::ACTION_ID_READ,
    Api::MODULE_ESTATE,
    ['data' => ['Id', 'kaufpreis']]
);

$handle2 = $sdk->callGeneric(
    Api::ACTION_ID_READ,
    Api::MODULE_ADDRESS,
    ['data' => ['Id', 'Name']]
);

// Send all requests in ONE HTTP call
$sdk->sendRequestsWithCredentials();

// Get individual responses
$estates = $sdk->getResponseArray($handle1);
$addresses = $sdk->getResponseArray($handle2);
```

---

## Action Classes

The SDK provides getter methods for each resource type:

| Method | Module | Description |
|--------|--------|-------------|
| `getEstateAction()` | `estate` | read, create, modify, delete, quickSearch |
| `getAddressAction()` | `address` | read, create, modify, delete, autocomplete |
| `getTaskAction()` | `task` | read, create, modify, delete |
| `getCalendarAction()` | `calendar` | read, create, modify, delete |
| `getSearchCriteriaAction()` | `searchcriteria` | read, create, modify, delete |
| `getFileAction()` | `file` | create, modify, delete, upload |
| `getRelationAction()` | `relations` | create, modify, delete, getRelations |
| `getEmailAction()` | `sendmail` | send |

---

## API Documentation

For detailed API documentation, visit:
- [Official API Documentation](https://apidoc.onoffice.de/)
- [API Reference](https://apidoc.onoffice.de/api-reference/)

---

## Examples

The `examples/` directory contains comprehensive examples:

- `00-quickstart.php` - Getting started
- `01-estate-read.php` - Reading estates with filters
- `02-estate-create.php` - Creating estates
- `03-estate-modify.php` - Updating estates
- `04-estate-quicksearch.php` - Quick search
- `05-address-read.php` - Reading addresses
- `06-address-create.php` - Creating addresses
- `07-address-autocomplete.php` - Address autocomplete
- `08-task-create.php` - Creating tasks
- `09-calendar-create.php` - Creating appointments
- `10-searchcriteria-create.php` - Creating saved searches
- `11-file-upload.php` - Uploading files
- `12-relation-create.php` - Managing relations
- `13-email-send.php` - Sending emails
- `14-batch-operations.php` - Batch operations

---

## Contributing

Contributions are welcome! Please read our contributing guidelines before submitting pull requests.

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Credits

**Developed and maintained by [bytes-commerce.de](https://www.bytes-commerce.de)**

Special thanks to [onOffice GmbH](https://www.onoffice.de/) for providing the API infrastructure.
