<?php

declare(strict_types=1);

/**
 * Email Examples
 *
 * Demonstrates how to send emails through onOffice.
 *
 * @see https://apidoc.onoffice.de/actions/e-mails-versenden/
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BytesCommerce\OnOffice\Api;

$sdk = new Api('YOUR_API_TOKEN', 'YOUR_API_SECRET');
$emailAction = $sdk->getEmailAction();

// Example 1: Send email with template
echo "=== Send email with template ===\n";

$response = $emailAction->send([
    // Sender identity (configured in onOffice)
    'emailidentity' => 'sender@myonoffice.de',

    // Recipients
    'receiver' => ['marie.musterfrau@onoffice.de'],
    'cc' => ['manager@example.com'],
    'bcc' => ['archive@example.com'],

    // Email content
    'subject' => 'Property Viewing Confirmation',
    'templateid' => 1_211, // Use a saved template instead of body
    'replyto' => 'reply@example.com',

    // Related records
    'estateids' => [12, 23],
    'addressids' => [247],

    // Options
    'useHtml' => true,
    'signatureid' => 1,
]);

echo "Email sent successfully!\n";
print_r($response);

// Example 2: Send email with PDF expose
echo "\n=== Send email with PDF expose ===\n";

$response = $emailAction->send([
    'emailidentity' => 'sender@myonoffice.de',
    'receiver' => ['client@example.de'],
    'subject' => 'Your Property Exposé',

    // Body text
    'body' => 'Dear Sir/Madam,

Please find attached the requested exposé for the property at [ADDRESS].

Best regards,
Your Real Estate Team',

    // Attachments
    'estateids' => [123],
    'pdfexposeidentifiers' => ['urn:onoffice-de-ns:smart:2.5:pdf:expose:lang:Exposé'],
    'webexposeids' => [53],
]);

print_r($response);

// Example 3: Send simple email without attachments
echo "\n=== Send simple email ===\n";

$response = $emailAction->send([
    'emailidentity' => 'default',
    'receiver' => ['info@example.com'],
    'subject' => 'Quick Question',
    'body' => 'Hello, I have a question about property #123.',
]);

print_r($response);
