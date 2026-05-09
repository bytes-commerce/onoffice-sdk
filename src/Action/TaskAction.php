<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\ApiInterface;

final readonly class TaskAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_TASK;
    }

    /**
     * Read tasks.
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
     * Create a task.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Create a task linked to address and estate:
     * ```php
     * $taskAction->create([
     *     'data' => [
     *         'Betreff' => 'Follow-up call with prospect',
     *         'Verantwortung' => 'robert',
     *         'Bearbeiter' => 'robert',
     *         'Aufgabe' => 'Call Max Mustermann to discuss the property viewing.',
     *         'Deadline' => '2024-07-01 00:00:00',
     *         'Prio' => 2, // 1-5, 1=highest
     *         'Art' => 1, // Task type ID from enterprise
     *         'Status' => 1, // 1-8 status values
     *     ],
     *     'relatedAddressId' => 247,
     *     'relatedEstateId' => 459,
     * ]);
     * ```
     */
    public function create(array $parameters = []): array
    {
        $handle = $this->callCreate($parameters);

        return $this->execute($handle);
    }

    /**
     * Modify a task.
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
     * Delete a task.
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
