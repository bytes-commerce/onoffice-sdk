<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Address;

use Webmozart\Assert\Assert;

final class AddressDTOFactory
{
    /**
     * Build a single AddressDTO from raw API response record.
     *
     * @param array<string, mixed> $record
     */
    public function fromRecord(array $record): AddressDTO
    {
        Assert::keyExists($record, 'id');
        $id = $record['id'];

        Assert::keyExists($record, 'elements');
        $elementsRaw = $record['elements'];
        Assert::isArray($elementsRaw);
        /** @var array<string, mixed> $elements */
        $elements = $elementsRaw;

        $phoneNumbers = $this->extractPhoneNumbers($elements);

        return new AddressDTO(
            id: $id,
            vorname: $elements['Vorname'] ?? null,
            name: $elements['Name'] ?? null,
            firma: $elements['Firma'] ?? null,
            email: $elements['Email'] ?? null,
            telefon: $elements['Telefon'] ?? null,
            telefax: $elements['Telefax'] ?? null,
            strasse: $elements['Strasse'] ?? null,
            plz: $elements['Plz'] ?? null,
            ort: $elements['Ort'] ?? null,
            land: $elements['Land'] ?? null,
            bundesland: $elements['Bundesland'] ?? null,
            telefon2: $elements['Telefon2'] ?? null,
            telefon3: $elements['Telefon3'] ?? null,
            mobil: $elements['Mobil'] ?? null,
            homepage: $elements['Homepage'] ?? null,
            anrede: $elements['Anrede'] ?? null,
            titel: $elements['Titel'] ?? null,
            geburtsdatum: $elements['Geburtsdatum'] ?? null,
            freitext1: $elements['Freitext1'] ?? null,
            freitext2: $elements['Freitext2'] ?? null,
            freitext3: $elements['Freitext3'] ?? null,
            freitext4: $elements['Freitext4'] ?? null,
            freitext5: $elements['Freitext5'] ?? null,
            imageUrl: $elements['imageUrl'] ?? null,
            aktiv: $this->toBool($elements['Aktiv'] ?? null),
            newsletter: $this->toBool($elements['Newsletter'] ?? null),
            strasse2: $elements['Strasse2'] ?? null,
            plz2: $elements['Plz2'] ?? null,
            ort2: $elements['Ort2'] ?? null,
            land2: $elements['Land2'] ?? null,
            ansprechpartnerId: $elements['AnsprechpartnerId'] ?? null,
            erstelltAm: $elements['ErstelltAm'] ?? null,
            geaendertAm: $elements['GeaendertAm'] ?? null,
            phoneNumbers: $phoneNumbers,
            rawData: $elements,
        );
    }

    /**
     * Build multiple AddressDTOs from API response.
     *
     * @param array<array<string, mixed>> $records
     *
     * @return AddressDTO[]
     */
    public function fromRecords(array $records): array
    {
        $dtos = [];
        foreach ($records as $record) {
            $dtos[] = $this->fromRecord($record);
        }

        return $dtos;
    }

    /**
     * Extract phone numbers from elements.
     * Phone fields are in format: phone__XXXXX or phone__XXXXX__Comment
     *
     * @param array<string, mixed> $elements
     *
     * @return PhoneNumberDTO[]
     */
    private function extractPhoneNumbers(array $elements): array
    {
        $phoneNumbers = [];

        foreach ($elements as $key => $value) {
            if (!str_starts_with($key, 'phone__')) {
                continue;
            }

            if (str_contains($key, '__Comment')) {
                continue;
            }

            $parts = explode('__', $key);
            if (\count($parts) < 2) {
                continue;
            }

            $phoneId = $parts[1];
            $commentKey = "phone__{$phoneId}__Comment";
            $comment = $elements[$commentKey] ?? null;

            $phoneNumbers[] = new PhoneNumberDTO(
                number: \is_string($value) ? $value : null,
                comment: \is_string($comment) ? $comment : null,
            );
        }

        return $phoneNumbers;
    }

    private function toBool(mixed $value): ?bool
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (\is_bool($value)) {
            return $value;
        }

        return (bool) $value;
    }
}
