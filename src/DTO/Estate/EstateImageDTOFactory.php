<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

use Webmozart\Assert\Assert;

final class EstateImageDTOFactory
{
    /**
     * Build EstateImageDTOs from raw API response records.
     *
     * The API response has this structure:
     * records = [
     *   {
     *     id: 431,
     *     type: "files",
     *     elements: [
     *       { estateid, type, url, title, text, originalname, modified, estateMainId },
     *       ...
     *     ]
     *   }
     * ]
     *
     * @param array<array<string, mixed>> $records
     *
     * @return EstateImageDTO[]
     */
    public function fromRecords(array $records): array
    {
        $dtos = [];

        foreach ($records as $record) {
            Assert::keyExists($record, 'id');
            Assert::keyExists($record, 'elements');
            Assert::isArray($record['elements']);

            $id = $record['id'];
            $elements = $record['elements'];

            // elements is an array of image objects
            foreach ($elements as $element) {
                $dtos[] = new EstateImageDTO(
                    id: $element['estateid'] ?? $id,
                    title: $element['title'] ?? '',
                    url: $element['url'] ?? '',
                    thumbnailUrl: $element['url'] ?? '', // API returns same URL
                    type: $element['type'] ?? 'Foto',
                    rank: 0,
                    width: null,
                    height: null,
                    estateId: $element['estateid'] ?? null,
                    estateMainId: $element['estateMainId'] ?? null,
                    originalName: $element['originalname'] ?? null,
                    text: $element['text'] ?? null,
                    modified: isset($element['modified']) ? (int) $element['modified'] : null,
                    rawData: $element,
                );
            }
        }

        return $dtos;
    }
}
