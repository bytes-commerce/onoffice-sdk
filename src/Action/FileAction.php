<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Action;

use BytesCommerce\OnOffice\ApiInterface;

final readonly class FileAction extends ActionBase
{
    public function getResourceType(): string
    {
        return ApiInterface::MODULE_FILE;
    }

    /**
     * Create a file.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function create(array $parameters = []): array
    {
        $handle = $this->callCreate($parameters);

        return $this->execute($handle);
    }

    /**
     * Modify a file.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     *
     * @example Modify file metadata:
     * ```php
     * $fileAction->modify('2983', [
     *     'relationtype' => 'estate',
     *     'parentid' => 1685,
     *     'Art' => 'Foto',
     *     'title' => 'Updated Title',
     *     'freetext' => 'Description of the file',
     * ]);
     * ```
     */
    public function modify(string $resourceId, array $parameters = []): array
    {
        $handle = $this->callModify($resourceId, $parameters);

        return $this->execute($handle);
    }

    /**
     * Delete a file.
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
     * Upload a file.
     *
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    public function upload(array $parameters = []): array
    {
        $handle = $this->callDo($parameters);

        return $this->execute($handle);
    }
}
