<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

use Closure;

final class EstateDTO
{
    /**
     * @param Closure|null $imagesLoader Optional closure to lazy-load images: fn(): EstateImageDTO[]
     * @param array<EstateImageDTO> $images
     * @param array<string, mixed> $rawData Original API response elements
     */
    public function __construct(
        public readonly int|string $id,
        public readonly ?int $mainLangId = null,
        public readonly ?string $language = null,
        public readonly ?string $objekttitel = null,
        public readonly ?string $objektbeschreibung = null,
        public readonly ?string $lage = null,
        public readonly ?string $ausstattBeschr = null,
        public readonly ?string $sonstigeAngaben = null,
        public readonly ?float $kaufpreis = null,
        public readonly ?float $mietpreis = null,
        public readonly ?float $nettokaltmiete = null,
        public readonly ?float $kaltmiete = null,
        public readonly ?float $warmmiete = null,
        public readonly ?float $nebenkosten = null,
        public readonly ?float $heizkosten = null,
        public readonly ?float $hausgeld = null,
        public readonly ?float $erbpacht = null,
        public readonly ?float $pacht = null,
        public readonly ?float $kaution = null,
        public readonly ?string $waehrung = null,
        public readonly ?string $aussenCourtage = null,
        public readonly ?string $innenCourtage = null,
        public readonly ?string $provisionsAbgabe = null,
        public readonly ?string $vermarktungsart = null,
        public readonly ?string $nutzungsart = null,
        public readonly ?string $objektart = null,
        public readonly ?string $objekttyp = null,
        public readonly ?string $zustand = null,
        public readonly ?string $baujahr = null,
        public readonly ?string $baubjahr = null,
        public readonly ?string $erstelltAm = null,
        public readonly ?string $geaendertAm = null,
        public readonly ?string $letzteAktion = null,
        public readonly ?string $verfuegbarAb = null,
        public readonly ?string $abdatum = null,
        public readonly ?bool $vermietet = null,
        public readonly ?bool $denkmalgeschuetzt = null,
        public readonly ?bool $gewerblicheNutzung = null,
        public readonly ?bool $haustiere = null,
        public readonly ?float $wohnflaeche = null,
        public readonly ?float $nutzflaeche = null,
        public readonly ?float $gesamtflaeche = null,
        public readonly ?float $grundstuecksflaeche = null,
        public readonly ?float $anzahlZimmer = null,
        public readonly ?float $anzahlSchlafzimmer = null,
        public readonly ?float $anzahlBadezimmer = null,
        public readonly ?float $anzahlBalkone = null,
        public readonly ?float $anzahlTerrassen = null,
        public readonly ?float $etagenZahl = null,
        public readonly ?int $etage = null,
        public readonly ?float $balkonTerrasseFlaeche = null,
        public readonly ?bool $balkon = null,
        public readonly ?bool $terrasse = null,
        public readonly ?bool $wintergarten = null,
        public readonly ?bool $kamin = null,
        public readonly ?bool $sauna = null,
        public readonly ?bool $kabelSatTv = null,
        public readonly ?bool $einliegerwohnung = null,
        public readonly ?bool $stammobjekt = null,
        public readonly ?bool $verkauft = null,
        public readonly ?bool $reserviert = null,
        public readonly ?string $strasse = null,
        public readonly ?string $hausnummer = null,
        public readonly ?string $plz = null,
        public readonly ?string $ort = null,
        public readonly ?string $land = null,
        public readonly ?string $bundesland = null,
        public readonly ?float $breitengrad = null,
        public readonly ?float $laengengrad = null,
        public readonly ?string $flur = null,
        public readonly ?string $flurstueck = null,
        public readonly ?string $gemarkung = null,
        public readonly ?string $scoutRegion = null,
        public readonly ?string $wohnungsnr = null,
        public readonly ?string $regionalerZusatz = null,
        public readonly ?string $heizungsart = null,
        public readonly ?string $befeuerung = null,
        public readonly ?string $boden = null,
        public readonly ?string $fahrstuhl = null,
        public readonly ?string $fenster = null,
        public readonly ?string $unterkellert = null,
        public readonly ?string $energietraeger = null,
        public readonly ?string $energieausweistyp = null,
        public readonly ?string $energyClass = null,
        public readonly ?int $energieausweisBaujahr = null,
        public readonly ?string $energieausweisGueltigBis = null,
        public readonly ?float $endenergiebedarf = null,
        public readonly ?float $energieverbrauchskennwert = null,
        public readonly ?float $endenergiebedarfWaerme = null,
        public readonly ?float $endenergieverbrauchWaerme = null,
        public readonly ?float $endenergiebedarfStrom = null,
        public readonly ?float $endenergieverbrauchStrom = null,
        public readonly ?bool $warmwasserEnthalten = null,
        public readonly ?string $heizkostenInNebenkosten = null,
        public readonly ?ParkingLotDTO $parkingLot = null,
        private ?Closure $imagesLoader = null,
        private array $images = [],
        private bool $imagesLoaderCalled = false,
        public readonly array $rawData = [],
    ) {}

    public function getId(): int|string
    {
        return $this->id;
    }

    public function hasCoordinates(): bool
    {
        return $this->breitengrad !== null && $this->laengengrad !== null;
    }

    /**
     * @return array{latitude: float|null, longitude: float|null}|null
     */
    public function getCoordinates(): ?array
    {
        if (!$this->hasCoordinates()) {
            return null;
        }

        return [
            'latitude' => $this->breitengrad,
            'longitude' => $this->laengengrad,
        ];
    }

    public function getFormattedAddress(): ?string
    {
        $parts = array_filter([
            $this->strasse,
            $this->hausnummer,
            $this->plz,
            $this->ort,
        ]);

        if ($parts === []) {
            return null;
        }

        return implode(' ', $parts);
    }

    public function isForSale(): bool
    {
        return $this->kaufpreis !== null && $this->kaufpreis > 0;
    }

    public function isForRent(): bool
    {
        return $this->mietpreis !== null && $this->mietpreis > 0;
    }

    public function isSold(): bool
    {
        return \in_array($this->verkauft, [true, 1, '1'], true);
    }

    public function isReserved(): bool
    {
        return \in_array($this->reserviert, [true, 1, '1'], true);
    }

    public function isActive(): bool
    {
        return !$this->isSold() && !$this->isReserved();
    }

    public function getPrice(): ?float
    {
        return $this->kaufpreis ?? $this->mietpreis;
    }

    public function getRentPrice(): ?float
    {
        return $this->warmmiete ?? $this->kaltmiete ?? $this->mietpreis;
    }

    /**
     * Set the images loader closure (used by factory for lazy loading).
     *
     * @internal This method is for framework use only.
     */
    public function setImagesLoader(Closure $loader): void
    {
        $this->imagesLoader = $loader;
    }

    /**
     * Get images for this estate (lazy loaded).
     *
     * Images are fetched from the API only when this method is called,
     * and only once per estate instance.
     *
     * @return EstateImageDTO[]
     */
    public function getImages(): array
    {
        if ($this->imagesLoader instanceof Closure && !$this->imagesLoaderCalled) {
            $this->imagesLoaderCalled = true;
            $this->images = ($this->imagesLoader)();
        }

        return $this->images;
    }

    /**
     * Check if images have been loaded for this estate.
     */
    public function hasImagesLoaded(): bool
    {
        return $this->imagesLoaderCalled;
    }

    /**
     * Get only the title image (lazy loaded).
     */
    public function getTitleImage(): ?EstateImageDTO
    {
        $images = $this->getImages();

        foreach ($images as $image) {
            if ($image->isTitleImage()) {
                return $image;
            }
        }

        return $images[0] ?? null;
    }

    /**
     * Get only photos (lazy loaded).
     *
     * @return EstateImageDTO[]
     */
    public function getPhotos(): array
    {
        return array_values(
            array_filter(
                $this->getImages(),
                static fn (EstateImageDTO $image) => $image->isPhoto(),
            ),
        );
    }
}
