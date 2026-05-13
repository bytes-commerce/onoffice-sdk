<?php

declare(strict_types=1);

namespace BytesCommerce\OnOffice\Attributes\Enum;

enum Status2Enum: string
{
    case MITBEWERB_IM_AUFTRAG = 'hat_mitbewerb_im_auftrag_imp';
    case IN_VERMARKT_AKTIV = 'in_vermarkt_aktiv_imp';
    case IN_BEARB_AKTIV = 'in_bearb_aktiv_imp';
    case DURCH_MITBEWERB_VERMIT = 'durch_mitbewerb_verm_imp';
    case DURCH_EIGEN_VERMAR_INAKTIV = 'durch_eigen_vermar_inaktiv_imp';
    case VERMARKT_EINGES_INAKTIV = 'vermarkt_einges_inaktiv_imp';
    case ABGEWICKELT = 'abgewickelt_imp';
    case STORNO_GESP = 'storno_gesp_imp';
    case DURCH_UNS_VERMARKT_ABG = 'durch_uns_vermarkt_abg_imp';

    public function label(): string
    {
        return match ($this) {
            self::MITBEWERB_IM_AUFTRAG => 'Hat Mitbewerb im Auftrag',
            self::IN_VERMARKT_AKTIV => 'In Vermarktung aktiv',
            self::IN_BEARB_AKTIV => 'In Bearbeitung aktiv',
            self::DURCH_MITBEWERB_VERMIT => 'Durch Mitbewerb vermittelt',
            self::DURCH_EIGEN_VERMAR_INAKTIV => 'Durch Eigenvermarktung inaktiv',
            self::VERMARKT_EINGES_INAKTIV => 'Vermarktung eingestellt inaktiv',
            self::ABGEWICKELT => 'Abgewickelt',
            self::STORNO_GESP => 'Storno/gesperrt',
            self::DURCH_UNS_VERMARKT_ABG => 'Durch uns vermarktet/abgeschlossen',
        };
    }
}
