<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum EnergietraegerEnum: string
{
    case WASSER_ELEKTRO = 'wasser-elektro';
    case SOLAR = 'solar';
    case PELLETHEIZUNG = 'pelletheizung';
    case PELLET = 'pellet';
    case OEL = 'oel';
    case LUFTWP = 'luftwp';
    case KOHLE = 'kohle';
    case GAS = 'gas';
    case FERNWAERME = 'fernwaerme';
    case ERDWAERME = 'erdwaerme';
    case ELEKTRO = 'elektro';
    case BLOCK = 'block';
    case ALTERNATIV = 'alternativ';
    case WOOD_CHIPS = 'woodChips';
    case SOUR_GAS = 'sourGas';
    case FLUESSIGGAS = 'fluessiggas';
    case STEAM_DISTRICT_HEATING = 'steamDistrictHeating';
    case HOLZ = 'holz';
    case LOCAL_HEATING = 'localHeating';
    case HEAT_SUPPLY = 'heatSupply';
    case BIO_ENERGY = 'bioEnergy';
    case WIND_ENERGY = 'windEnergy';
    case WATER_ENERGY = 'waterEnergy';
    case ENVIRONMENTAL_THERMAL_ENERGY = 'environmentalThermalEnergy';
    case COMBINED_HEAT_AND_POWER_FOSSIL_FUELS = 'combinedHeatAndPowerFossilFuels';
    case COMBINED_HEAT_AND_POWER_RENEWABLE_ENERGY = 'combinedHeatAndPowerRenewableEnergy';
    case COMBINED_HEAT_AND_POWER_REGENERATIVE_ENERGY = 'combinedHeatAndPowerRegenerativeEnergy';
    case COMBINED_HEAT_AND_POWER_BIO_ENERGY = 'combinedHeatAndPowerBioEnergy';

    public function label(): string
    {
        return match ($this) {
            self::WASSER_ELEKTRO => 'Ergänzendes dezentrales Warmwasser',
            self::SOLAR => 'Solar',
            self::PELLETHEIZUNG => 'Pelletheizung',
            self::PELLET => 'Pellet',
            self::OEL => 'Öl',
            self::LUFTWP => 'Luft/Wasser Wärmepumpe',
            self::KOHLE => 'Kohle',
            self::GAS => 'Gas',
            self::FERNWAERME => 'Fernwärme',
            self::ERDWAERME => 'Erdwärme',
            self::ELEKTRO => 'Elektro',
            self::BLOCK => 'Blockheizkraftwerk',
            self::ALTERNATIV => 'Alternativ',
            self::WOOD_CHIPS => 'Holz/Holz-Hackschnitzel',
            self::SOUR_GAS => 'Erdgas',
            self::FLUESSIGGAS => 'Flüssiggas',
            self::STEAM_DISTRICT_HEATING => 'Fernwärme Dampf',
            self::HOLZ => 'Holz',
            self::LOCAL_HEATING => 'Nahwärme',
            self::HEAT_SUPPLY => 'Wärmelieferung',
            self::BIO_ENERGY => 'Bioenergie',
            self::WIND_ENERGY => 'Windenergie',
            self::WATER_ENERGY => 'Wasserenergie',
            self::ENVIRONMENTAL_THERMAL_ENERGY => 'Umweltwärme',
            self::COMBINED_HEAT_AND_POWER_FOSSIL_FUELS => 'KWK fossil',
            self::COMBINED_HEAT_AND_POWER_RENEWABLE_ENERGY => 'KWK erneuerbar',
            self::COMBINED_HEAT_AND_POWER_REGENERATIVE_ENERGY => 'KWK regenerativ',
            self::COMBINED_HEAT_AND_POWER_BIO_ENERGY => 'KWK Bio',
        };
    }
}
