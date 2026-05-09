<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\ApiInterface;

final readonly class CalendarAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_CALENDAR;
    }

    /**
     * Read appointments.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function read(array $parameters = []): array
    {
        $handle = $this->callRead($parameters);

        return $this->execute($handle);
    }

    /**
     * Create an appointment.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Create an appointment with related estate and address:
     * ```php
     * $calendarAction->create([
     *     'data' => [
     *         'description' => 'Property viewing',
     *         'start_dt' => '2024-06-15 14:00:00',
     *         'end_dt' => '2024-06-15 15:00:00',
     *         'art' => 'Besichtigung',
     *         'ganztags' => false,
     *         'note' => 'Prospect is interested in the Berlin property',
     *         'private' => false,
     *         'ressources' => ['Company Car'],
     *     ],
     *     'relatedAddressIds' => [1935, 1931],
     *     'relatedEstateId' => 608,
     *     'location' => ['estate' => 608],
     *     'subscribers' => [
     *         'users' => [14],
     *         'groups' => [168, 172],
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
     * Modify an appointment.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function modify(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callModify($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Delete an appointment.
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
}
