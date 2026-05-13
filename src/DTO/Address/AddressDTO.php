<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Address;

final readonly class AddressDTO
{
    /**
     * @param array<PhoneNumberDTO> $phoneNumbers
     * @param array<string, mixed> $rawData Original API response elements
     */
    public function __construct(
        public int|string $id,
        public ?string $vorname = null,
        public ?string $name = null,
        public ?string $firma = null,
        public ?string $email = null,
        public ?string $telefon = null,
        public ?string $telefax = null,
        public ?string $strasse = null,
        public ?string $plz = null,
        public ?string $ort = null,
        public ?string $land = null,
        public ?string $bundesland = null,
        public ?string $telefon2 = null,
        public ?string $telefon3 = null,
        public ?string $mobil = null,
        public ?string $homepage = null,
        public ?string $anrede = null,
        public ?string $titel = null,
        public ?string $geburtsdatum = null,
        public ?string $freitext1 = null,
        public ?string $freitext2 = null,
        public ?string $freitext3 = null,
        public ?string $freitext4 = null,
        public ?string $freitext5 = null,
        public ?string $imageUrl = null,
        public ?bool $aktiv = null,
        public ?bool $newsletter = null,
        public ?string $strasse2 = null,
        public ?string $plz2 = null,
        public ?string $ort2 = null,
        public ?string $land2 = null,
        public ?string $ansprechpartnerId = null,
        public ?string $erstelltAm = null,
        public ?string $geaendertAm = null,
        public array $phoneNumbers = [],
        public array $rawData = [],
    ) {}

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        $parts = array_filter([$this->vorname, $this->name]);

        return $parts === [] ? null : implode(' ', $parts);
    }

    public function getFormattedAddress(): ?string
    {
        $parts = array_filter([
            $this->strasse,
            $this->plz,
            $this->ort,
        ]);

        if ($parts === []) {
            return null;
        }

        return implode(' ', $parts);
    }

    public function getFormattedFullAddress(): string
    {
        $parts = array_filter([
            $this->firma,
            $this->getFullName(),
            $this->strasse,
            $this->plz . ' ' . $this->ort,
        ]);

        return implode("\n", $parts);
    }

    public function getPrimaryEmail(): ?string
    {
        return $this->email;
    }

    public function getPrimaryPhone(): ?string
    {
        return $this->telefon ?? $this->mobil;
    }

    public function hasAddress(): bool
    {
        return $this->strasse !== null && $this->plz !== null && $this->ort !== null;
    }

    public function getCompany(): ?string
    {
        return $this->firma;
    }

    public function isActive(): ?bool
    {
        return $this->aktiv;
    }

    public function hasNewsletter(): ?bool
    {
        return $this->newsletter;
    }
}
