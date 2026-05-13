<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\DTO\Estate;

use Closure;
use Webmozart\Assert\Assert;

final class EstateDTOFactory
{
    /**
     * Build a single EstateDTO from raw API response record.
     *
     * @param array<string, mixed> $record
     */
    public function fromRecord(array $record): EstateDTO
    {
        Assert::keyExists($record, 'id');
        $id = $record['id'];

        Assert::keyExists($record, 'elements');
        $elementsRaw = $record['elements'];
        Assert::isArray($elementsRaw);
        /** @var array<string, mixed> $elements */
        $elements = $elementsRaw;

        $parkingLot = null;
        if (isset($elements['multiParkingLot']) && \is_array($elements['multiParkingLot'])) {
            $parkingLot = $this->buildParkingLotDTO($elements['multiParkingLot']);
        }

        return new EstateDTO(
            id: $id,
            mainLangId: isset($elements['mainLangId']) ? (int) $elements['mainLangId'] : null,
            language: $elements['language'] ?? null,
            objekttitel: $elements['objekttitel'] ?? null,
            objektbeschreibung: $elements['objektbeschreibung'] ?? null,
            lage: $elements['lage'] ?? null,
            ausstattBeschr: $elements['ausstatt_beschr'] ?? null,
            sonstigeAngaben: $elements['sonstige_angaben'] ?? null,
            kaufpreis: $this->toFloat($elements['kaufpreis'] ?? null),
            mietpreis: $this->toFloat($elements['mietpreis'] ?? null),
            nettokaltmiete: $this->toFloat($elements['nettokaltmiete'] ?? null),
            kaltmiete: $this->toFloat($elements['kaltmiete'] ?? null),
            warmmiete: $this->toFloat($elements['warmmiete'] ?? null),
            nebenkosten: $this->toFloat($elements['nebenkosten'] ?? null),
            heizkosten: $this->toFloat($elements['heizkosten'] ?? null),
            hausgeld: $this->toFloat($elements['hausgeld'] ?? null),
            erbpacht: $this->toFloat($elements['erbpacht'] ?? null),
            pacht: $this->toFloat($elements['pacht'] ?? null),
            kaution: $this->toFloat($elements['kaution'] ?? null),
            waehrung: $elements['waehrung'] ?? null,
            aussenCourtage: $elements['aussen_courtage'] ?? null,
            innenCourtage: $elements['innen_courtage'] ?? null,
            provisionsAbgabe: $elements['provisionsAbgabe'] ?? null,
            vermarktungsart: $elements['vermarktungsart'] ?? null,
            nutzungsart: $elements['nutzungsart'] ?? null,
            objektart: $elements['objektart'] ?? null,
            objekttyp: $elements['objekttyp'] ?? null,
            zustand: $elements['zustand'] ?? null,
            baujahr: $elements['baujahr'] ?? null,
            baubjahr: $elements['baujahrBem'] ?? null,
            erstelltAm: $elements['erstellt_am'] ?? null,
            geaendertAm: $elements['geaendert_am'] ?? null,
            letzteAktion: $elements['letzte_aktion'] ?? null,
            verfuegbarAb: $elements['verfuegbar_ab'] ?? null,
            abdatum: $elements['abdatum'] ?? null,
            vermietet: $this->toBool($elements['vermietet'] ?? null),
            denkmalgeschuetzt: $this->toBool($elements['denkmalgeschuetzt'] ?? null),
            gewerblicheNutzung: $this->toBool($elements['gewerbliche_nutzung'] ?? null),
            haustiere: $this->toBool($elements['haustiere'] ?? null),
            wohnflaeche: $this->toFloat($elements['wohnflaeche'] ?? null),
            nutzflaeche: $this->toFloat($elements['nutzflaeche'] ?? null),
            gesamtflaeche: $this->toFloat($elements['gesamtflaeche'] ?? null),
            grundstuecksflaeche: $this->toFloat($elements['grundstuecksflaeche'] ?? null),
            anzahlZimmer: $this->toFloat($elements['anzahl_zimmer'] ?? null),
            anzahlSchlafzimmer: $this->toFloat($elements['anzahl_schlafzimmer'] ?? null),
            anzahlBadezimmer: $this->toFloat($elements['anzahl_badezimmer'] ?? null),
            anzahlBalkone: $this->toFloat($elements['anzahl_balkone'] ?? null),
            anzahlTerrassen: $this->toFloat($elements['anzahl_terrassen'] ?? null),
            etagenZahl: $this->toFloat($elements['etagen_zahl'] ?? null),
            etage: isset($elements['etage']) ? (int) $elements['etage'] : null,
            balkon: $this->toBool($elements['balkon'] ?? null),
            terrasse: $this->toBool($elements['terrasse'] ?? null),
            wintergarten: $this->toBool($elements['wintergarten'] ?? null),
            kamin: $this->toBool($elements['kamin'] ?? null),
            sauna: $this->toBool($elements['sauna'] ?? null),
            kabelSatTv: $this->toBool($elements['kabel_sat_tv'] ?? null),
            einliegerwohnung: $this->toBool($elements['einliegerwohnung'] ?? null),
            stammobjekt: $this->toBool($elements['stammobjekt'] ?? null),
            verkauft: $this->toBool($elements['verkauft'] ?? null),
            reserviert: $this->toBool($elements['reserviert'] ?? null),
            strasse: $elements['strasse'] ?? null,
            hausnummer: $elements['hausnummer'] ?? null,
            plz: $elements['plz'] ?? null,
            ort: $elements['ort'] ?? null,
            land: $elements['land'] ?? null,
            bundesland: $elements['bundesland'] ?? null,
            breitengrad: $this->toFloat($elements['breitengrad'] ?? null),
            laengengrad: $this->toFloat($elements['laengengrad'] ?? null),
            flur: $elements['flur'] ?? null,
            flurstueck: $elements['flurstueck'] ?? null,
            gemarkung: $elements['gemarkung'] ?? null,
            scoutRegion: $elements['scout_region'] ?? null,
            wohnungsnr: $elements['wohnungsnr'] ?? null,
            regionalerZusatz: $elements['regionaler_zusatz'] ?? null,
            heizungsart: $this->toString($elements['heizungsart'] ?? null),
            befeuerung: $this->toString($elements['befeuerung'] ?? null),
            boden: $this->toString($elements['boden'] ?? null),
            fahrstuhl: $this->toString($elements['fahrstuhl'] ?? null),
            fenster: $this->toString($elements['fenster'] ?? null),
            unterkellert: $this->toString($elements['unterkellert'] ?? null),
            energietraeger: $this->toString($elements['energietraeger'] ?? null),
            energieausweistyp: $elements['energieausweistyp'] ?? null,
            energyClass: $elements['energyClass'] ?? null,
            energieausweisBaujahr: isset($elements['energieausweisBaujahr']) ? (int) $elements['energieausweisBaujahr'] : null,
            energieausweisGueltigBis: $elements['energieausweis_gueltig_bis'] ?? null,
            endenergiebedarf: $this->toFloat($elements['endenergiebedarf'] ?? null),
            energieverbrauchskennwert: $this->toFloat($elements['energieverbrauchskennwert'] ?? null),
            endenergiebedarfWaerme: $this->toFloat($elements['endenergiebedarfWaerme'] ?? null),
            endenergieverbrauchWaerme: $this->toFloat($elements['endenergieverbrauchWaerme'] ?? null),
            endenergiebedarfStrom: $this->toFloat($elements['endenergiebedarfStrom'] ?? null),
            endenergieverbrauchStrom: $this->toFloat($elements['endenergieverbrauchStrom'] ?? null),
            warmwasserEnthalten: $this->toBool($elements['warmwasserEnthalten'] ?? null),
            heizkostenInNebenkosten: $elements['heizkosten_in_nebenkosten'] ?? null,
            parkingLot: $parkingLot,
            rawData: $elements,
        );
    }

    /**
     * Build multiple EstateDTOs from API response.
     *
     * @param array<array<string, mixed>> $records
     *
     * @return EstateDTO[]
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
     * Build a single EstateDTO with lazy-loading images callback.
     *
     * @param array<string, mixed> $record
     * @param Closure $imagesLoader Closure that returns EstateImageDTO[] when called
     */
    public function fromRecordWithImagesLoader(array $record, Closure $imagesLoader): EstateDTO
    {
        $dto = $this->fromRecord($record);
        $dto->setImagesLoader($imagesLoader);

        return $dto;
    }

    /**
     * Build multiple EstateDTOs with lazy-loading images callback.
     *
     * @param array<array<string, mixed>> $records
     * @param Closure $imagesLoader Closure that receives estateId and returns EstateImageDTO[]
     *
     * @return EstateDTO[]
     */
    public function fromRecordsWithImagesLoader(array $records, Closure $imagesLoader): array
    {
        $dtos = [];
        foreach ($records as $record) {
            $estateId = $record['id'];
            $loader = static fn (): array => $imagesLoader($estateId);
            $dtos[] = $this->fromRecordWithImagesLoader($record, $loader);
        }

        return $dtos;
    }

    /**
     * Build ParkingLotDTO from raw parking lot data.
     *
     * @param array<string, array{
     *     Count: string|int,
     *     Price: string|float,
     *     MarketingType: string
     * }> $data
     */
    private function buildParkingLotDTO(array $data): ParkingLotDTO
    {
        return new ParkingLotDTO(
            carport: $this->buildParkingSpots($data['carport'] ?? []),
            duplex: $this->buildParkingSpots($data['duplex'] ?? []),
            parkingSpace: $this->buildParkingSpots($data['parkingSpace'] ?? []),
            garage: $this->buildParkingSpots($data['garage'] ?? []),
            multiStoryGarage: $this->buildParkingSpots($data['multiStoryGarage'] ?? []),
            undergroundGarage: $this->buildParkingSpots($data['undergroundGarage'] ?? []),
            otherParkingLot: $this->buildParkingSpots($data['otherParkingLot'] ?? []),
        );
    }

    /**
     * @param array{Count?: string|int, Price?: string|float, MarketingType?: string} $spotData
     *
     * @return ParkingSpotDTO[]
     */
    private function buildParkingSpots(array $spotData): array
    {
        if ($spotData === []) {
            return [];
        }

        return [
            new ParkingSpotDTO(
                count: isset($spotData['Count']) ? (int) $spotData['Count'] : null,
                price: isset($spotData['Price']) ? $this->toFloat($spotData['Price']) : null,
                marketingType: $spotData['MarketingType'] ?? null,
            ),
        ];
    }

    private function toFloat(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) $value;
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

    private function toString(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (\is_string($value)) {
            return $value;
        }

        if (\is_array($value)) {
            return implode(', ', $value);
        }

        return (string) $value;
    }
}
