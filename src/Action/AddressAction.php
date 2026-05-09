<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\Api;
use BytesCommerce\OnOffice\ApiInterface;

final readonly class AddressAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_ADDRESS;
    }

    /**
     * Read addresses with optional filters, fields, limits, and sorting.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Read specific addresses with filters:
     * ```php
     * $addressAction->read([
     *     'data' => ['Vorname', 'Name', 'Email', 'Telefon', 'Ort', 'Plz'],
     *     'recordids' => [10505, 10509],
     *     'filter' => [
     *         'Name' => [['op' => 'LIKE', 'val' => 'M%']],
     *     ],
     *     'listlimit' => 100,
     *     'sortby' => 'Name',
     *     'sortorder' => 'ASC',
     *     'formatoutput' => true,
     * ]);
     * ```
     */
    public function read(array $parameters = []): array
    {
        $handle = $this->callRead($parameters);

        return $this->execute($handle);
    }

    /**
     * Create a new address.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Create a new contact:
     * ```php
     * $addressAction->create([
     *     'data' => [
     *         'Vorname' => 'Max',
     *         'Name' => 'Mustermann',
     *         'Email' => 'max.mustermann@example.de',
     *         'Telefon' => '+49 241 123456',
     *         'Strasse' => 'Hauptstrasse 123',
     *         'Plz' => '52068',
     *         'Ort' => 'Aachen',
     *         'Land' => 'DEU',
     *     ],
     * ]);
     * ```
     */
    public function create(array $parameters = []): array
    {
        $handle = $this->callCreate($parameters);

        return $this->execute($handle);
    }

    /**
     * Modify an existing address.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Update phone and email:
     * ```php
     * $addressAction->modify('123', [
     *     'data' => [
     *         'Telefon' => '+49 241 654321',
     *         'Email' => 'new.email@example.de',
     *     ],
     * ]);
     * ```
     */
    public function modify(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callModify($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Delete an address.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function delete(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callDelete($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Get address autocomplete suggestions.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Get address suggestions:
     * ```php
     * $addressAction->autocomplete([
     *     'input' => 'Max',
     *     'filter' => [
     *         'Name' => [['op' => 'LIKE', 'val' => 'M%']],
     *     ],
     * ]);
     * ```
     */
    public function autocomplete(array $parameters = []): array
    {
        $handle = $this->sdk->callGeneric(
            Api::ACTION_ID_GET,
            Api::MODULE_ADDRESS,
            $parameters,
        );

        return $this->execute($handle);
    }
}
