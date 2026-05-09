<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\ApiInterface;

final readonly class EmailAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_SENDMAIL;
    }

    /**
     * Send an email.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Send email with template and estate:
     * ```php
     * $emailAction->send([
     *     'emailidentity' => 'sender@myonoffice.de',
     *     'receiver' => ['marie.musterfrau@onoffice.de'],
     *     'cc' => ['copy@example.com'],
     *     'subject' => 'Property Viewing Confirmation',
     *     'templateid' => 1211, // Use template instead of body
     *     'replyto' => 'reply@example.com',
     *     'estateids' => [12, 23],
     *     'useHtml' => true,
     *     'signatureid' => 1,
     * ]);
     * ```
     * @example Send email with PDF expose:
     * ```php
     * $emailAction->send([
     *     'emailidentity' => 'sender@myonoffice.de',
     *     'receiver' => ['client@example.de'],
     *     'subject' => 'Your Property Exposé',
     *     'body' => 'Please find attached the requested exposé.',
     *     'estateids' => [123],
     *     'pdfexposeidentifiers' => ['urn:onoffice-de-ns:smart:2.5:pdf:expose:lang:Exposé'],
     *     'webexposeids' => [53],
     * ]);
     * ```
     */
    public function send(array $parameters = []): array
    {
        $handle = $this->callDo($parameters);

        return $this->execute($handle);
    }
}
