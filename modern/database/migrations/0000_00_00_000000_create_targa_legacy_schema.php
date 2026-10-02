<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            throw new RuntimeException('The Targa baseline migration requires MySQL.');
        }

        $existingObjects = (int) DB::scalar(<<<'SQL'
SELECT COUNT(*)
FROM information_schema.tables
WHERE table_schema = DATABASE()
  AND table_name <> 'migrations'
SQL);

        if ($existingObjects !== 0) {
            throw new RuntimeException(
                'The Targa baseline migration may only run against an empty database.'
            );
        }

        DB::unprepared('SET FOREIGN_KEY_CHECKS = 0');

        try {
            foreach ($this->tableStatements() as $statement) {
                DB::unprepared($statement);
            }

            // Temporary views make dependencies between legacy views resolvable.
            foreach ($this->placeholderViewStatements() as $statement) {
                DB::unprepared($statement);
            }

            foreach ($this->finalViewStatements() as $statement) {
                DB::unprepared($statement);
            }
        } finally {
            DB::unprepared('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            throw new RuntimeException('The Targa baseline migration requires MySQL.');
        }

        DB::unprepared('SET FOREIGN_KEY_CHECKS = 0');

        try {
            foreach ($this->viewNames() as $view) {
                $quoted = str_replace('`', '``', $view);
                DB::unprepared("DROP VIEW IF EXISTS `{$quoted}`");
            }

            foreach ($this->tableNames() as $table) {
                $quoted = str_replace('`', '``', $table);
                DB::unprepared("DROP TABLE IF EXISTS `{$quoted}`");
            }
        } finally {
            DB::unprepared('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    /** @return list<string> */
    private function tableStatements(): array
    {
        return [
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `AusmusterungStamm` (
  `AusmusterungStamm_Id` bigint NOT NULL AUTO_INCREMENT,
  `AusmusterungStamm_ausmusterung` char(4) DEFAULT NULL,
  `AusmusterungStamm_kurs` decimal(10,4) DEFAULT NULL,
  `AusmusterungStamm_kosten_nachlauf` decimal(10,2) DEFAULT NULL,
  `AusmusterungStamm_kosten_entladung` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `AusmusterungStamm_kosten_finanzierung` decimal(10,2) DEFAULT NULL,
  `AusmusterungStamm_kosten_sonstigeVK` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`AusmusterungStamm_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COMMENT='				';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `AvisKopf` (
  `AvisKopf_Id` int NOT NULL AUTO_INCREMENT,
  `AvisKopf_IAN` varchar(10) DEFAULT NULL,
  `AvisKopf_Date` date DEFAULT NULL,
  `AvisKopf_Voyage` varchar(50) DEFAULT NULL,
  `AvisKopf_CountryOfOrigin` varchar(50) DEFAULT NULL,
  `AvisKopf_OceanVessel` date DEFAULT NULL,
  `AvisKopf_POL` varchar(50) DEFAULT NULL,
  `AvisKopf_ATD` date DEFAULT NULL,
  `AvisKopf_POD` varchar(50) DEFAULT NULL,
  `AvisKopf_ETA` date DEFAULT NULL,
  `AvisKopf_ShippingWeek` varchar(50) DEFAULT NULL,
  `AvisKopf_TarifCode` varchar(5500) DEFAULT NULL,
  `AvisKopf_Remarks` varchar(500) DEFAULT NULL,
  `AvisKopf_IstAktiv` int DEFAULT NULL,
  `AvisKopf_ImportDate` date DEFAULT NULL,
  `AvisKopf_File` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`AvisKopf_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=447 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `AvisPositionen` (
  `AvisPositionen_Id` int NOT NULL AUTO_INCREMENT,
  `AvisPositionen_AvisKopfId` int DEFAULT NULL,
  `AvisPositionen_ContainerSize` varchar(50) DEFAULT NULL,
  `AvisPositionen_ContainerNo` varchar(50) DEFAULT NULL,
  `AvisPositionen_ContainerSealNo` varchar(50) DEFAULT NULL,
  `AvisPositionen_CB` varchar(50) DEFAULT NULL,
  `AvisPositionen_ParcelCount` int DEFAULT NULL,
  `AvisPositionen_VE` varchar(50) DEFAULT NULL,
  `AvisPositionen_ParcelGross` decimal(10,2) DEFAULT NULL,
  `AvisPositionen_ParcelNet` decimal(10,2) DEFAULT NULL,
  `AvisPositionen_ParcelDepth` int DEFAULT NULL,
  `AvisPositionen_ParcelWidth` int DEFAULT NULL,
  `AvisPositionen_ParcelHeight` int DEFAULT NULL,
  `AvisPositionen_SubInfo` varchar(500) DEFAULT NULL,
  `AvisPositionen_IAN` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`AvisPositionen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3961 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `BISUser` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `BISUser_Name` varchar(100) DEFAULT NULL,
  `BISUser_Vorname` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `BISUser_email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `remember_token` varchar(500) DEFAULT NULL,
  `BISUser_group` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `BISUser_username_UNIQUE` (`username`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `EAN_Basisnummern` (
  `EAN_Basisnummern_Id` bigint NOT NULL AUTO_INCREMENT,
  `EAN_Basisnummern_Kd` varchar(100) DEFAULT NULL,
  `EAN_Basisnummern_Nummer` varchar(100) DEFAULT NULL,
  `EAN_Basisnummern_Max` bigint DEFAULT NULL,
  PRIMARY KEY (`EAN_Basisnummern_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `EAN_Nummern` (
  `EAN_Nummern_Id` bigint NOT NULL AUTO_INCREMENT,
  `EAN_Nummern_lfd_EAN` int DEFAULT NULL,
  `EAN_Nummern_IAN` varchar(20) DEFAULT NULL,
  `EAN_Nummern_EAN_Basisnummern_Id` bigint DEFAULT NULL,
  `EAN_Nummern_Status` varchar(100) DEFAULT NULL,
  `EAN_Nummern_MA` bigint DEFAULT NULL,
  `EAN_Nummern_LetzteAenderung` datetime DEFAULT NULL,
  `EAN_Nummern_EAN` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`EAN_Nummern_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5119 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Files` (
  `Files_Id` int NOT NULL AUTO_INCREMENT,
  `Files_Kategorie` varchar(50) DEFAULT NULL,
  `Files_Name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Files_SubKategorie` varchar(50) DEFAULT NULL,
  `DatumUpload` date DEFAULT NULL,
  PRIMARY KEY (`Files_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `ISOLaender` (
  `ISOLaender_Land` varchar(250) NOT NULL,
  `ISOLaender_ISO2` char(2) NOT NULL,
  `ISOLaender_ISO3` char(3) DEFAULT NULL,
  `ISOLaender_ISOZ` char(3) DEFAULT NULL,
  `ISOLaender_TLD` char(5) DEFAULT NULL,
  `ISOLaender_IOS` char(3) DEFAULT NULL,
  `ISOLaender_UN` char(5) DEFAULT NULL,
  PRIMARY KEY (`ISOLaender_ISO2`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Länder mit ISO Codes Quelle Wikipedia	';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Inquiry_Rechenmenge` (
  `ID` varchar(45) NOT NULL,
  `IAN` varchar(45) DEFAULT NULL,
  `LOAD40'HCfuerInq.` varchar(45) DEFAULT NULL,
  `Datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Kalkulationskurs` (
  `id` varchar(250) NOT NULL,
  `Musterung` varchar(4) DEFAULT NULL,
  `Kurs` varchar(10) DEFAULT NULL,
  `Eingabe` datetime DEFAULT NULL,
  `Ersteller` varchar(100) DEFAULT NULL,
  `Finanzierungskosten` varchar(45) DEFAULT NULL,
  `SonstigeKosten` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `KostenContainer` (
  `KostenContainer_Id` bigint NOT NULL AUTO_INCREMENT,
  `KostenContainer_Ausmusterung` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `KostenContainer_Art` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `KostenContainer_Gruppe` int DEFAULT NULL,
  `KostenContainer_Preis` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`KostenContainer_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Kostenarten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Kostenart` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Kundengruppen` (
  `Kundengruppen_Id` int NOT NULL AUTO_INCREMENT,
  `Kundengruppen_Bezeichnung` varchar(50) DEFAULT NULL,
  `Erlöskonto` varchar(50) DEFAULT NULL,
  `BU` int DEFAULT NULL,
  `Hauptkundengruppe` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Kundengruppen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Lagerbewegungsarten` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Bewegungsart` varchar(2) DEFAULT NULL,
  `Bezeichnung` varchar(50) DEFAULT NULL,
  `IstManuell` smallint DEFAULT NULL,
  `Bestandswirkung` smallint DEFAULT NULL,
  `IstInventurBuchung` smallint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Lagerplatzbuchungen` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `belegepositionen_id` int DEFAULT NULL,
  `Jobnummer` int DEFAULT NULL,
  `Artikelnummer` varchar(50) DEFAULT NULL,
  `HerkunftsLagerplatz` int DEFAULT NULL,
  `ZielLagerplatz` int DEFAULT NULL,
  `Bewegungsart` varchar(2) DEFAULT NULL,
  `Bestandswirkung` smallint DEFAULT NULL,
  `MengeBasis` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Load` (
  `ID` varchar(250) NOT NULL,
  `KTILoad` varchar(45) DEFAULT NULL,
  `AfrozeLoad` varchar(45) DEFAULT NULL,
  `EastVisionLoad` varchar(45) DEFAULT NULL,
  `ErteksLoad` varchar(45) DEFAULT NULL,
  `KAMLoad` varchar(45) DEFAULT NULL,
  `KimilLoad` varchar(45) DEFAULT NULL,
  `KocaerLoad` varchar(45) DEFAULT NULL,
  `LALLoad` varchar(45) DEFAULT NULL,
  `LibertyMillsLoad` varchar(45) DEFAULT NULL,
  `BariMillsLoad` varchar(45) DEFAULT NULL,
  `MacCarpetLoad` varchar(45) DEFAULT NULL,
  `MartinelliLoad` varchar(45) DEFAULT NULL,
  `MomtexLoad` varchar(45) DEFAULT NULL,
  `MustaquimLoad` varchar(45) DEFAULT NULL,
  `OzanLoad` varchar(45) DEFAULT NULL,
  `PremLoad` varchar(45) DEFAULT NULL,
  `Datetime` datetime DEFAULT NULL,
  `RugsCreationLoad` varchar(45) DEFAULT NULL,
  `TCTTerrytaksLoad` varchar(45) DEFAULT NULL,
  `IAN` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `LoadJeProduzent` (
  `ID` varchar(45) NOT NULL,
  `IAN` varchar(45) DEFAULT NULL,
  `Load40'HC` varchar(45) DEFAULT NULL,
  `Produzent` varchar(45) DEFAULT NULL,
  `DateTime` datetime DEFAULT NULL,
  `Preis` varchar(45) DEFAULT NULL,
  `Währung` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `MPPlan` (
  `MPPlan_Id` int NOT NULL AUTO_INCREMENT,
  `MPPlan_PPBoardSpalte_Id` int NOT NULL,
  `MPPlan_IsKMS` tinyint(1) NOT NULL DEFAULT '0',
  `MPPlan_KMS` int NOT NULL,
  `MPPlan_Gruppe` int NOT NULL,
  `MPPlan_ValidFromAusm` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `MPPlan_ValidToAusm` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`MPPlan_Id`),
  KEY `idx_ppboard` (`MPPlan_PPBoardSpalte_Id`),
  KEY `idx_kms` (`MPPlan_KMS`),
  KEY `idx_gruppe` (`MPPlan_Gruppe`),
  KEY `idx_valid` (`MPPlan_ValidFromAusm`,`MPPlan_ValidToAusm`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=540 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `MoeglicheLieferanten` (
  `UUID` varchar(90) NOT NULL,
  `Datetime` datetime DEFAULT NULL,
  `Storno` varchar(45) DEFAULT NULL,
  `KTI` varchar(45) DEFAULT NULL,
  `Afroze` varchar(45) DEFAULT NULL,
  `EastVision` varchar(45) DEFAULT NULL,
  `Erteks` varchar(45) DEFAULT NULL,
  `KAM` varchar(45) DEFAULT NULL,
  `Kimil` varchar(45) DEFAULT NULL,
  `Kocaer` varchar(45) DEFAULT NULL,
  `LAL` varchar(45) DEFAULT NULL,
  `LibertyMIlls` varchar(45) DEFAULT NULL,
  `BariMills` varchar(45) DEFAULT NULL,
  `MacCarpet` varchar(45) DEFAULT NULL,
  `Martinelli` varchar(45) DEFAULT NULL,
  `Momtex` varchar(45) DEFAULT NULL,
  `Mustaquim` varchar(45) DEFAULT NULL,
  `Ozan` varchar(45) DEFAULT NULL,
  `Prem` varchar(45) DEFAULT NULL,
  `Rainbow` varchar(45) DEFAULT NULL,
  `RugsCreation` varchar(45) DEFAULT NULL,
  `TCTerryteks` varchar(45) DEFAULT NULL,
  `IAN` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`UUID`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Nummernkreise` (
  `Nummernkreise_Id` int NOT NULL AUTO_INCREMENT,
  `Nummernkreise_Bezeichnung` varchar(250) DEFAULT NULL,
  `Nummernkreise_LetzteNummer` int DEFAULT NULL,
  `Nummernkreise_Jahr` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `createed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Nummernkreise_Id`),
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PP8WMuster` (
  `PP8WMuster_Id` bigint NOT NULL AUTO_INCREMENT,
  `PP8WMuster_Empfaenger` bigint DEFAULT NULL,
  `PP8WMuster_Remark` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PP8WMuster_Art` char(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PP8WMuster_PPProduktpass_Id` bigint DEFAULT NULL,
  PRIMARY KEY (`PP8WMuster_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb3 COMMENT='		';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPAB` (
  `PPAB_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPAB_VKEUR` decimal(10,4) DEFAULT '0.0000',
  `PPAB_CD11` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD12` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD13` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD21` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD22` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD23` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD31` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD32` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD33` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD41` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD42` decimal(10,2) DEFAULT '0.00',
  `PPAB_CD43` decimal(10,2) DEFAULT '0.00',
  `PPAB_UZ` varchar(200) DEFAULT NULL,
  `PPAB_Produktionsstaette_Id` varchar(100) DEFAULT NULL,
  `PPAB_Produktionsstaette` varchar(500) DEFAULT NULL,
  `PPAB_Herkunftsland` varchar(100) DEFAULT NULL,
  `PPAB_Masse` varchar(100) DEFAULT NULL,
  `PPAB_Abgangshafen` varchar(100) DEFAULT NULL,
  `PPAB_LB1Proz` int DEFAULT '0',
  `PPAB_LB2Proz` int DEFAULT '0',
  `PPAB_LB3Proz` int DEFAULT '0',
  `PPAB_LB4Proz` int DEFAULT '0',
  `PPAB_LBloecke` datetime DEFAULT NULL,
  `PPAB_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPAB_KatonMasse` varchar(200) DEFAULT NULL,
  `PPAB_Palettenfaktor` varchar(200) DEFAULT NULL,
  `PPAB_Aufteilung_Rotterdam_FR` bigint DEFAULT '60',
  `PPAB_Aufteilung_Barcelona_FR` bigint DEFAULT NULL,
  `PPAB_Aufteilung_Barcelona_IT` bigint DEFAULT '45',
  `PPAB_Aufteilung_Koper_IT` bigint DEFAULT NULL,
  `PPAB_Produktionsstaette_LidlId` varchar(100) DEFAULT NULL,
  `PPAB_Anmerkung` varchar(500) DEFAULT NULL,
  `PPAB_IsBWAuftrag` bigint DEFAULT NULL COMMENT 'Grösse: Einzelbett, Doppelbett, King \n\nSize, Sondergröse Kissen\n',
  `PPAB_BWGroesse` varchar(100) DEFAULT NULL,
  `PPAB_UZRS` varchar(75) DEFAULT NULL,
  `PPAB_VKQMEUR` decimal(10,4) DEFAULT NULL,
  `PPAB_VKDAT` decimal(10,4) DEFAULT NULL,
  `PPAB_Lieferbedingung` int DEFAULT NULL,
  PRIMARY KEY (`PPAB_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7149 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPAbgangshafen` (
  `PPAbgangshafen_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPAbgangshafen_Hafen` varchar(250) NOT NULL,
  PRIMARY KEY (`PPAbgangshafen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1049 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPAdressarten` (
  `PPAdressarten_Id` int NOT NULL AUTO_INCREMENT,
  `PPAdressarten_Art` varchar(50) NOT NULL,
  `PPAdressarten_Bezeichnung` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`PPAdressarten_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPAdressen` (
  `Id` bigint NOT NULL AUTO_INCREMENT,
  `Art` int NOT NULL DEFAULT '4',
  `Firma1` varchar(250) DEFAULT NULL,
  `Firma2` varchar(250) DEFAULT NULL,
  `Ansprechpartner` varchar(250) DEFAULT NULL,
  `Adresse1` varchar(250) DEFAULT NULL,
  `Adresse2` varchar(250) DEFAULT NULL,
  `Matchcode` varchar(250) DEFAULT NULL,
  `PLZ` varchar(50) DEFAULT NULL,
  `Ort` varchar(250) DEFAULT NULL,
  `Postfach` varchar(250) DEFAULT NULL,
  `Land` varchar(250) DEFAULT NULL,
  `Telefon` varchar(250) DEFAULT NULL,
  `Fax` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `web` varchar(250) DEFAULT NULL,
  `delcredere` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `EORI` varchar(100) DEFAULT NULL,
  `Steuernummer` varchar(100) DEFAULT NULL,
  `USt_Id` varchar(100) DEFAULT NULL,
  `PPAdressen_LidlId` bigint DEFAULT NULL,
  `PPAdressen_Abgangshafen` varchar(200) DEFAULT NULL,
  `PPAdressen_Agent` varchar(200) DEFAULT NULL,
  `PPAdressen_Mobil` varchar(100) DEFAULT NULL,
  `PPAdressen_LT` bigint DEFAULT NULL,
  `PPAdressen_ZertStep` int DEFAULT NULL,
  `PPAdressen_ZertStepValid` datetime DEFAULT NULL,
  `PPAdressen_ZertBSCI` int DEFAULT NULL,
  `PPAdressen_ZertBSCIValid` datetime DEFAULT NULL,
  `PPAdressen_DefaultProvision` decimal(10,3) DEFAULT NULL,
  `PPAdressen_DefaultWsym` char(3) DEFAULT NULL,
  `PPAdressen_DefaultHafengruppe` varchar(50) DEFAULT NULL,
  `PPAdressen_AgentId` int DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=472 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPAssortmentStyles` (
  `PPAssortmentStyles_Id` int NOT NULL AUTO_INCREMENT,
  `PPAssortmentStyles_PPAssortments_Id` int DEFAULT NULL,
  `PPAssortmentStyles_styleNo` varchar(150) DEFAULT NULL,
  `PPAssortmentStyles_Size` varchar(45) DEFAULT NULL,
  `PPAssortmentStyles_Value` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PPAssortmentStyles_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPAssortments` (
  `PPAssortments_Id` int NOT NULL AUTO_INCREMENT,
  `PPAssortments_PPProduktpass_Id` int DEFAULT NULL,
  `PPAssortments_styleNo` varchar(45) DEFAULT NULL,
  `PPAssortments_vendorUniqueSeqNo` varchar(45) DEFAULT NULL,
  `PPAssortments_packingMethod` varchar(45) DEFAULT NULL,
  `PPAssortments_countryCodes` varchar(400) DEFAULT NULL,
  `PPAssortments_totalPackRatio` int DEFAULT NULL,
  `PPAssortments_sizecode` varchar(45) DEFAULT NULL,
  `PPAssortments_sizevalue` int DEFAULT NULL,
  `PPAssortments_productName` varchar(100) DEFAULT NULL,
  `PPAssortments_delMarker` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`PPAssortments_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=171654 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBW_Laendergroessen` (
  `PPBW_Laendergroessen_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPBW_Laendergroessen_Land` varchar(100) DEFAULT NULL,
  `PPBW_Laendergroessen_Groesse` varchar(100) DEFAULT NULL,
  `PPBW_Laendergroessen_Bett_Breite` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Bett_Laenge` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Anz_Kissen` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Kissen_Breite` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Kissen_Laenge` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Einheit` varchar(10) DEFAULT 'cm',
  `PPBW_Laendergroessen_Bett_SaumBreite` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Bett_SaumLaenge` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Kissen_SaumBreite` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Kissen_SaumLaenge` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Duvet_Laenge` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Duvet_Breite` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Duvet_SaumLaenge` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Duvet_SaumBreite` bigint DEFAULT NULL,
  `PPBW_Laendergroessen_Bett_Verdoppeln` char(1) NOT NULL DEFAULT 'B',
  `PPBW_Laendergroessen_Kissen_Verdoppeln` char(1) NOT NULL DEFAULT 'B',
  `PPBW_Laendergroessen_Duvet_Verdoppeln` char(1) NOT NULL DEFAULT 'B',
  PRIMARY KEY (`PPBW_Laendergroessen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=416 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBatchtermine` (
  `PPBatchtermine_Id` int NOT NULL AUTO_INCREMENT,
  `PPBatchtermine_PPBoardSpalte_Id` int NOT NULL,
  `PPBatchtermine_Termin` datetime DEFAULT NULL,
  `PPBatchtermine_Ausmusterung` char(4) DEFAULT NULL,
  PRIMARY KEY (`PPBatchtermine_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBoard` (
  `PPBoard_Id` int NOT NULL AUTO_INCREMENT,
  `PPBoard_Bezeichnung` varchar(45) DEFAULT NULL,
  `PPBoard_IsActive` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`PPBoard_Id`),
  UNIQUE KEY `PPBoard_Id_UNIQUE` (`PPBoard_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1012 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBoardSpalteData` (
  `PPBoardSpalte_Id` int NOT NULL AUTO_INCREMENT,
  `PPBoardSpalte_Bezeichnung` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_Oberbez` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_Stati` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_Orange` int DEFAULT NULL,
  `PPBoardSpalte_Rot` int DEFAULT NULL,
  `PPBoardSpalte_DefaultMA` bigint DEFAULT NULL,
  `PPBoardSpalte_DFTable` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_DFField` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_Remark` varchar(250) NOT NULL,
  `PPBoardSpalteData_Kind` varchar(20) NOT NULL,
  `PPBoardSpalte_IsMilestone` int NOT NULL DEFAULT '0',
  `PPBoardSpalte_IsUSA` int NOT NULL DEFAULT '0',
  `PPBoardSpalteData_Nachbestellung` int DEFAULT NULL,
  `PPBoardSpalteData_Child_nB` int DEFAULT NULL,
  `PPBoardSpalteData_HilfeStatusOK` text,
  `PPBoardSpalteData_HifeStatusInArbeit` text,
  `PPBoardSpalteData_HilfeStatusNOK` text,
  `PPBoardSpalteData_IsKMS` int NOT NULL DEFAULT '0' COMMENT 'Ist das ein Key Milestone',
  `PPBoardSpalteData_W2KMS` int DEFAULT NULL COMMENT 'Wochen differenz (+/-( zum Key Milestone',
  `PPBoardSpalteData_KMS` int DEFAULT NULL,
  `PPBoardSpalteData_Gruppe` int DEFAULT NULL,
  `PPBoardSpalteData_IsExternDate` tinyint NOT NULL DEFAULT '0',
  `PPBoardSpalteData_IdAlt` int DEFAULT NULL,
  `PPBoardSpalteData_ValidFromAusm` varchar(4) DEFAULT NULL,
  `PPBoardSpalteData_ValidToAusm` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`PPBoardSpalte_Id`),
  KEY `PPBSD_Id` (`PPBoardSpalte_Id`) INVISIBLE ,
  KEY `stat` (`PPBoardSpalte_Stati`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11402 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBoardSpalteData_DEV` (
  `PPBoardSpalte_Id` int NOT NULL AUTO_INCREMENT,
  `PPBoardSpalte_Bezeichnung` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PPBoardSpalte_Oberbez` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PPBoardSpalte_Stati` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PPBoardSpalte_Orange` int DEFAULT NULL,
  `PPBoardSpalte_Rot` int DEFAULT NULL,
  `PPBoardSpalte_DefaultMA` bigint DEFAULT NULL,
  `PPBoardSpalte_DFTable` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PPBoardSpalte_DFField` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `PPBoardSpalte_Remark` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `PPBoardSpalteData_Kind` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `PPBoardSpalte_IsMilestone` int NOT NULL DEFAULT '0',
  `PPBoardSpalte_IsUSA` int NOT NULL DEFAULT '0',
  `PPBoardSpalteData_Nachbestellung` int DEFAULT NULL,
  `PPBoardSpalteData_Child_nB` int DEFAULT NULL,
  PRIMARY KEY (`PPBoardSpalte_Id`),
  KEY `PPBSD_Id` (`PPBoardSpalte_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBoardSpalteX` (
  `PPBoardSpalteX_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPBoardSpalte_PPBoard_Id` bigint NOT NULL,
  `PPBoardSpalteX_PPBoardSpalte_Id` bigint NOT NULL,
  `PPBoardSpalteX_Sort` int DEFAULT NULL,
  PRIMARY KEY (`PPBoardSpalteX_Id`),
  KEY `Spalte` (`PPBoardSpalteX_PPBoardSpalte_Id`),
  KEY `bid` (`PPBoardSpalte_PPBoard_Id`) INVISIBLE ,
  KEY `sort` (`PPBoardSpalteX_Sort`),
  KEY `s2` (`PPBoardSpalteX_PPBoardSpalte_Id`,`PPBoardSpalte_PPBoard_Id`) INVISIBLE,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1381 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPBoardSpalte_SAVE` (
  `PPBoardSpalte_Id` int NOT NULL AUTO_INCREMENT,
  `PPBoardSpalte_Bezeichnung` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_PPBoard_Id` bigint DEFAULT NULL,
  `PPBoardSpalte_Oberbez` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_Stati` varchar(100) DEFAULT NULL,
  `PPBoardSpalte_Orange` int DEFAULT NULL,
  `PPBoardSpalte_Rot` int DEFAULT NULL,
  `PPBoardSpalte_DefaultMA` bigint DEFAULT NULL,
  PRIMARY KEY (`PPBoardSpalte_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPCalculation` (
  `PPCalculation_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPCalculation_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPCalculation_SupplierId` bigint DEFAULT NULL,
  `PPCalculation_SupplierLoadHQ` decimal(10,4) DEFAULT NULL,
  `PPCalculation_Currency` varchar(3) DEFAULT NULL,
  `PPCalculation_ExcR_Calc` decimal(10,5) DEFAULT '0.00000',
  `PPCalculation_DutyPercentage` decimal(6,2) DEFAULT NULL,
  `PPCalculation_EK` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Fracht` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Zoll` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_EKProvision` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Ausgangsfrachten` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Finanzierungskosten` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Pruefkosten` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Lizenzgebuehren` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Kosten` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_KostenProz` decimal(10,4) DEFAULT NULL,
  `PPCalculation_VK` decimal(10,4) DEFAULT '0.0000',
  `PPCalculation_Remark` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `PPCalculation_selected` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`PPCalculation_Id`),
  KEY `PPID` (`PPCalculation_PPProduktpass_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPContainerVerschiffungen` (
  `PPContainerVerschiffungen_Id` int NOT NULL AUTO_INCREMENT,
  `PPContainerVerschiffungen_PPInputManuell_Id` int NOT NULL,
  `PPContainerVerschiffungen_Hafen` varchar(45) DEFAULT NULL,
  `PPContainerVerschiffungen_Menge` int DEFAULT NULL,
  `PPContainerVerschiffungen_40` decimal(10,4) DEFAULT NULL,
  `PPContainerVerschiffungen_20` decimal(10,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PPContainerVerschiffungen_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5361 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPCountrySizes` (
  `PPCountrySizes_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPCountrySizes_Country` char(2) DEFAULT NULL,
  `PPCountrySizes_Size` varchar(100) DEFAULT NULL,
  `PPCountrySizes_QM1` decimal(10,4) DEFAULT NULL,
  `PPCountrySizes_QM2` decimal(10,4) DEFAULT NULL,
  `PPCountrySizes_Art` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PPCountrySizes_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPDevisenTerminKaeufe` (
  `PPDevisenTerminKaeufe_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPDevisenTerminKaeufe_Referenz` varchar(50) DEFAULT NULL,
  `PPDevisenTerminKaeufe_Termin` datetime DEFAULT NULL,
  `PPDevisenTerminKaeufe_Betrag` decimal(20,4) DEFAULT NULL,
  `PPDevisenTerminKaeufe_Kurs` decimal(10,4) DEFAULT NULL,
  `PPDevisenTerminKaeufe_Bank` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `PPDevisenTerminKaeufe_Status` char(10) NOT NULL DEFAULT 'offen',
  `PPDevisenTerminKaeufe_Bemerkung` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`PPDevisenTerminKaeufe_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPDictionary` (
  `PPDictionary_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPDictionary_Language` varchar(2) NOT NULL DEFAULT 'EN',
  `PPDictionary_Eintrag` varchar(500) NOT NULL,
  `PPDictionary_Uebersetzung` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`PPDictionary_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPDiff` (
  `PPDiff_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPDiff_Art` varchar(100) DEFAULT NULL,
  `PPDiff_ObjectId` bigint DEFAULT NULL,
  `PPDiff_ItemId` bigint DEFAULT NULL,
  `PPDiff_Value` varchar(5000) DEFAULT NULL,
  `PPDiff_Rev` bigint DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`PPDiff_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=423796 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPFileTypes` (
  `PPFileTypes_Id` int NOT NULL AUTO_INCREMENT,
  `PPFileTypes_Type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPFileTypes_SKR03_Id` int DEFAULT NULL,
  `PPFileTypes_ParentId` int DEFAULT NULL,
  `PPFileTypes_sort` int DEFAULT NULL,
  `PPFileTypes_iframe` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPFileTypes_Kategorien` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPFileTypes_Safety` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'restricted',
  `PPFileTypes_Role` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`PPFileTypes_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPHaefen` (
  `PPHaefen_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPHaefen_Nr` varchar(10) DEFAULT NULL,
  `PPHaefen_Name` varchar(100) DEFAULT NULL,
  `PPHaefen_PreisGruppe` int DEFAULT NULL,
  PRIMARY KEY (`PPHaefen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb3 COMMENT='						';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPHerkunftslaender` (
  `PPHerkunftslaender_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPHerkunftslaender_Land` varchar(250) NOT NULL,
  PRIMARY KEY (`PPHerkunftslaender_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1260 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPImport_Definition_Fields` (
  `PPImport_Definition_Id2` bigint NOT NULL,
  `PPImport_Definition_Fields_Field` varchar(100) NOT NULL,
  `PPImport_Definition_Fields_Sheet` varchar(100) NOT NULL,
  `PPImport_Definition_Fields_Row` bigint NOT NULL,
  `PPImport_Definition_Fields_Col` varchar(4) NOT NULL,
  `PPImport_Definition_Fields_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPImport_Definition_Fields_OSHeader` bigint DEFAULT NULL,
  `PPImport_Definition_Fields_Header` bigint DEFAULT NULL,
  PRIMARY KEY (`PPImport_Definition_Fields_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12682 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPImport_Definition_Rows` (
  `PPImport_Definition_Id1` bigint NOT NULL,
  `PPImport_Definition_Rows_Field` varchar(100) NOT NULL,
  `PPImport_Definition_Rows_Col` varchar(4) NOT NULL,
  `PPImport_Definition_Rows_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPImport_Definition_Rows_Type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`PPImport_Definition_Rows_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPImport_Definitions` (
  `PPImport_Definition_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPImport_Definition_Table` varchar(255) NOT NULL,
  `PPImport_Definition_Mode` varchar(50) NOT NULL,
  `PPImport_Definition_Startrow` bigint NOT NULL,
  `PPImport_Definition_Endrow` bigint NOT NULL,
  `PPImport_Definition_Sheetname` varchar(250) NOT NULL,
  PRIMARY KEY (`PPImport_Definition_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPImport_Excel` (
  `PPImort__Excel_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPImport_Excel_Datum` datetime NOT NULL,
  `PPImport_Excel_Dateiname` varchar(255) NOT NULL,
  PRIMARY KEY (`PPImort__Excel_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPImport_Excel_Data` (
  `PPImport_Excel_Data_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPImport_Excel_Data_Filename` varchar(250) NOT NULL,
  `PPImport_Excel_Data_Sheet` varchar(250) NOT NULL,
  `PPImport_Excel_Data_Row` bigint NOT NULL,
  `PPImport_Excel_Data_Col` varchar(4) NOT NULL,
  `PPImport_Excel_Data_Value` varchar(2500) NOT NULL,
  PRIMARY KEY (`PPImport_Excel_Data_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5746 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPInputManuell` (
  `PPInputManuell_Id` int NOT NULL AUTO_INCREMENT,
  `PPInputManuell_PPProduktpass_Id` int NOT NULL,
  `PPInputManuell_Projektname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_Lieferant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPInputManuell_GeplanterEKUSD` decimal(10,4) NOT NULL,
  `PPInputManuell_GeplanterVK` decimal(10,4) NOT NULL,
  `PPInputManuell_LaufzeitGarantie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_GarantieLieferant` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_AbwicklungGarantie` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_SonderleistungLieferant` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_MaxAusfallrate` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_ServiceVetrag` tinyint NOT NULL,
  `PPInputManuell_Verschiffungshafen` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_MengeDE` int NOT NULL,
  `PPInputManuell_MengeEU` int NOT NULL,
  `PPInputManuell_VE` int NOT NULL,
  `PPInputManuell_Masse` int DEFAULT NULL,
  `PPInputManuell_Laenge` int NOT NULL,
  `PPInputManuell_Breite` int NOT NULL,
  `PPInputManuell_Hoehe` int NOT NULL,
  `PPInputManuell_Onlinekartonage` tinyint NOT NULL,
  `PPInputManuell_Ausfallrate` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_ZukaufServiceWare` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_Servicekostensatz` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_Preisblatt` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PPInputManuell_EingangsfrachtZFRD` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_LogistikZLGK` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_AusgangsfrachtZRF2` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_ContHCStk` int DEFAULT NULL,
  `PPInputManuell_ContHCRot` int DEFAULT NULL,
  `PPInputManuell_ContHCBar` int DEFAULT NULL,
  `PPInputManuell_ContHCKop` int DEFAULT NULL,
  `PPInputManuell_ContHCUSA` int DEFAULT NULL,
  `PPInputManuell_Cont40Stk` int DEFAULT NULL,
  `PPInputManuell_Cont40Rot` int DEFAULT NULL,
  `PPInputManuell_Cont40Bar` int DEFAULT NULL,
  `PPInputManuell_Cont40Kop` int DEFAULT NULL,
  `PPInputManuell_Cont40USA` int DEFAULT NULL,
  `PPInputManuell_Cont20Stk` int DEFAULT NULL,
  `PPInputManuell_Cont20Rot` int DEFAULT NULL,
  `PPInputManuell_Cont20Bar` int DEFAULT NULL,
  `PPInputManuell_Cont20Kop` int DEFAULT NULL,
  `PPInputManuell_Cont20USA` int DEFAULT NULL,
  `PPInputManuell_ContPlan20` int NOT NULL,
  `PPInputManuell_ContPlan40` int NOT NULL,
  `PPInputManuell_ContPlan40HC` int NOT NULL,
  `PPInputManuell_Exportkarton_VE_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_Exportkarton_Masse_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_Exportkarton_Laenge_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_Exportkarton_Breite_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_Exportkarton_Hoehe_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_Exportkarton_VE` int DEFAULT NULL,
  `PPInputManuell_Exportkarton_Masse` int DEFAULT NULL,
  `PPInputManuell_Exportkarton_Laenge` int DEFAULT NULL,
  `PPInputManuell_Exportkarton_Breite` int DEFAULT NULL,
  `PPInputManuell_Exportkarton_Hoehe` int DEFAULT NULL,
  `PPInputManuell_GutschriftenbetragKunde` decimal(10,4) NOT NULL,
  `PPInputManuell_StkProPalette` int NOT NULL,
  `PPInputManuell_DeckelAusfallrate` decimal(10,4) NOT NULL,
  `PPInputManuell_IsLatest` int NOT NULL DEFAULT '1',
  `PPInputManuell_Date` datetime DEFAULT CURRENT_TIMESTAMP,
  `PPInputManuell_Bemerkungen` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_StatusPM` int NOT NULL DEFAULT '0',
  `PPInputManuell_StatusMaWi` int NOT NULL DEFAULT '0',
  `PPInputManuell_TextGroesse` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Default Text rausgenommen:\\nBitte bei Vorab und konkreten Anfragen den Produktpass als HTML anfügen Bei Bemusterungsanfragen, ohne konkrete Mengen, bitte wie gehabt nur den DE und EU Anteil eintragen. Bitte jeder Anfrage ein Produktbild und die wesentlichen technischen Eigenschaften listen.',
  `PPInputManuell_UAWGB` date NOT NULL,
  `PPInputManuell_KLContPlan20` int NOT NULL,
  `PPInputManuell_KLContPlan40` int NOT NULL,
  `PPInputManuell_KLContPlan40HC` int NOT NULL,
  `PPInputManuell_EKWSYM` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPInputManuell_KLExportkarton_VE` int NOT NULL,
  `PPInputManuell_KLExportkarton_Masse` int NOT NULL,
  `PPInputManuell_KLExportkarton_Laenge` int NOT NULL,
  `PPInputManuell_KLExportkarton_Breite` int NOT NULL,
  `PPInputManuell_KLExportkarton_Hoehe` int NOT NULL,
  `PPInputManuell_KLExportkarton_VE_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_KLExportkarton_Masse_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_KLExportkarton_Laenge_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_KLExportkarton_Breite_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_KLExportkarton_Hoehe_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_VE` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Masse` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Laenge` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Breite` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Hoehe` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_VE_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Masse_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Laenge_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Breite_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_OSExportkarton_Hoehe_V2` int NOT NULL DEFAULT '0',
  `PPInputManuell_MengeIAN` bigint NOT NULL DEFAULT '0',
  `PPInputManuell_VersionRemark` text COLLATE utf8mb4_unicode_ci,
  `PPInputManuell_IsFinal` tinyint NOT NULL DEFAULT '0',
  `PPInputManuell_Masse2` int DEFAULT NULL,
  `PPInputManuell_Laenge2` int NOT NULL,
  `PPInputManuell_Breite2` int NOT NULL,
  `PPInputManuell_Hoehe2` int NOT NULL,
  `PPInputManuell_PlanmengePM` int DEFAULT NULL,
  `PPInputManuell_ZWEEWert` decimal(10,4) DEFAULT NULL,
  `PPInputManuell_VEGB1` int DEFAULT NULL,
  `PPInputManuell_VEGB2` int DEFAULT NULL,
  PRIMARY KEY (`PPInputManuell_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3690 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPInquiryDiff` (
  `PPInquiryDiff_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPInquiryDiff_Version` bigint DEFAULT NULL,
  `PPInquiryDiff_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPInquiryDiff_Header` varchar(2000) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPInquiryDiff_Row` bigint DEFAULT NULL,
  `PPInquiryDiff_Value_1` blob,
  `PPInquiryDiff_Value_2` blob,
  `PPInquiryDiff_Value_3` blob,
  `PPInquiryDiff_Value_4` blob,
  `PPInquiryDiff_Value_5` blob,
  `PPInquiryDiff_Value_6` blob,
  `PPInquiryDiff_Value_7` blob,
  `PPInquiryDiff_Value_8` blob,
  `PPInquiryDiff_Value_9` blob,
  `PPInquiryDiff_Value_10` blob,
  PRIMARY KEY (`PPInquiryDiff_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='		';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPKategorien` (
  `PPKategorien_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPKategorien_Parent` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPKategorien_Kategorie` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PPKategorien_Sort` int DEFAULT '1',
  PRIMARY KEY (`PPKategorien_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLC` (
  `PPLC_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLC_PPProduktpass_Id` bigint NOT NULL,
  `PPLC_Applicant` varchar(500) DEFAULT NULL,
  `PPLC_Beneficiary` varchar(500) DEFAULT NULL,
  `PPLC_AdvisingBank` varchar(500) DEFAULT NULL,
  `PPLC_AdvisingBankLand` varchar(100) DEFAULT NULL,
  `PPLC_FormOfDocumentaryCredit` varchar(100) DEFAULT NULL,
  `PPLC_ApplicableRules` varchar(100) DEFAULT NULL,
  `PPLC_DateAndPlaceOfExpiry` varchar(100) DEFAULT NULL,
  `PPLC_AvailableWith` varchar(150) DEFAULT NULL,
  `PPLC_PartitialShipment` varchar(50) DEFAULT NULL,
  `PPLC_TransShipment` varchar(50) DEFAULT NULL,
  `PPLC_ForTransportationTo` varchar(250) DEFAULT NULL,
  `PPLC_OverShipment` varchar(350) DEFAULT NULL,
  `PPLC_OtherSpec` varchar(1200) DEFAULT NULL,
  `PPLC_DocumentsRequired` varchar(3000) DEFAULT NULL,
  `PPLC_AdditionalConditions` varchar(1500) DEFAULT NULL,
  `PPLC_Charges` varchar(1500) DEFAULT NULL,
  `PPLC_Deduction` varchar(1500) DEFAULT NULL,
  `PPLC_TextPort` varchar(50) DEFAULT NULL,
  `PPLC_Amount` varchar(50) DEFAULT NULL,
  `PPLC_TOP` varchar(150) DEFAULT NULL,
  `PPLC_POL` varchar(150) DEFAULT NULL,
  `PPLC_LDOS` varchar(150) DEFAULT NULL,
  `PPLC_DOTG` blob,
  `PPLC_PeriodeForPresentation` varchar(1250) DEFAULT NULL,
  `PPLC_ConfirmationInstructions` varchar(1250) DEFAULT NULL,
  `PPLC_IPAN` varchar(1250) DEFAULT NULL,
  `PPLC_FinalDate` datetime DEFAULT NULL,
  `PPLC_LCNo` varchar(50) DEFAULT NULL,
  `PPLC_Eroeffnung` date DEFAULT NULL,
  `PPLC_EroeffnungAlternativ` date DEFAULT NULL,
  `PPLC_Andienung` date DEFAULT NULL,
  `PPLC_Bemerkung` varchar(500) DEFAULT NULL,
  `PPLC_StatusId` bigint NOT NULL DEFAULT '0',
  `PPLC_DebitNote` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`PPLC_Id`),
  KEY `PPID` (`PPLC_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4395 DEFAULT CHARSET=utf8mb3 COMMENT='	';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLaenderaufteilung` (
  `PPLaenderaufteilung_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLaenderaufteilung_Land` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPLaenderaufteilung_Warehouse` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPLaenderaufteilung_Menge_Kollies` bigint DEFAULT NULL,
  `PPLaenderaufteilung_PPProduktpass_Id` bigint DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`PPLaenderaufteilung_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11509 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLaenderbloeckeMitVersion` (
  `PPLaenderbloecke_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLaenderbloecke_Land` varchar(100) DEFAULT NULL,
  `PPLaenderbloecke_Block` varchar(100) DEFAULT NULL,
  `PPLaenderbloecke_Hafen1` varchar(100) DEFAULT NULL,
  `PPLaenderbloecke_Hafen2` varchar(100) DEFAULT NULL,
  `PPLaenderbloecke_Sort` varchar(45) DEFAULT NULL,
  `PPLaenderbloecke_Version` varchar(4) DEFAULT '0000',
  `PPLaenderbloecke_IsOS` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`PPLaenderbloecke_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLidlQualitaetsarten` (
  `PPLidlQualitaetsarten_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLidlQualitaetsarten_Art` varchar(100) DEFAULT '',
  PRIMARY KEY (`PPLidlQualitaetsarten_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLieferavis` (
  `PPLieferavis_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLieferavis_ETD` date DEFAULT NULL,
  `PPLieferavis_ETA` date DEFAULT NULL,
  `PPLieferavis_POL` varchar(100) DEFAULT NULL,
  `PPLieferavis_POD` varchar(100) DEFAULT NULL,
  `PPLieferavis_SupplierId` varchar(100) DEFAULT NULL,
  `PPLieferavis_FrachtfuehrerId` varchar(100) DEFAULT NULL,
  `PPLieferavis_SpediteurId` varchar(100) DEFAULT NULL,
  `PPLieferavis_SeaAir` varchar(100) DEFAULT NULL,
  `PPLieferavis_AvisNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Incoterm` varchar(100) DEFAULT NULL,
  `PPLieferavis_Incoterm2` varchar(100) DEFAULT NULL,
  `PPLieferavis_Abgangsland` varchar(100) DEFAULT NULL,
  `PPLieferavis_Remark` varchar(500) DEFAULT NULL,
  `PPLieferavis_IMO` varchar(100) DEFAULT NULL,
  `PPLieferavis_PPProduktpass_Id` bigint DEFAULT NULL,
  PRIMARY KEY (`PPLieferavis_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLieferavis_BOL` (
  `PPLieferavis_BOL_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLieferavis_BOL_BOLNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_BOL_Brutto` decimal(10,2) DEFAULT NULL,
  `PPLieferavis_BOL_Netto` decimal(10,2) DEFAULT NULL,
  `PPLieferavis_BOL_PPLieferavis_Id` bigint DEFAULT NULL,
  PRIMARY KEY (`PPLieferavis_BOL_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLieferavis_Container` (
  `PPLieferavis_Container_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLieferavis_Container_PPLieferavis_Id` bigint DEFAULT NULL,
  `PPLieferavis_Container_ContainerId` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_Art` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_PalCon` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_BOLNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_PPLieferavis_BOL_Id` bigint DEFAULT NULL,
  PRIMARY KEY (`PPLieferavis_Container_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLieferavis_Container_Content` (
  `PPLieferavis_Container_Content_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLieferavis_Container_Content_VEPos` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_Content_POSNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_Content_Menge` decimal(10,2) DEFAULT NULL,
  `PPLieferavis_Container_Content_MaterialNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_Content_PPOSNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Container_Content_PPLieferavis_Container_Id` bigint DEFAULT NULL,
  PRIMARY KEY (`PPLieferavis_Container_Content_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLieferavis_MARM` (
  `PPLieferavis_MARM_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLieferavis_MARM_SATNR` varchar(100) DEFAULT NULL,
  `PPLieferavis_MARM_Laenge` bigint DEFAULT NULL,
  `PPLieferavis_MARM_Breite` bigint DEFAULT NULL,
  `PPLieferavis_MARM_Hoehe` bigint DEFAULT NULL,
  `PPLieferavis_MARM_Brutto` decimal(10,2) DEFAULT NULL,
  `PPLieferavis_MARM_Netto` decimal(10,2) DEFAULT NULL,
  `PPLieferavis_MARM_PPLieferavis_Id` bigint DEFAULT NULL,
  PRIMARY KEY (`PPLieferavis_MARM_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLieferavis_Material` (
  `PPLieferavis_Material_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLieferavis_Material_PPLieferavis_Id` bigint DEFAULT NULL,
  `PPLieferavis_Material_Materialnr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Material_Menge` decimal(10,2) DEFAULT '0.00',
  `PPLieferavis_Material_OrderNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Material_OrderPosNr` varchar(100) DEFAULT NULL,
  `PPLieferavis_Material_OrderGTIN` varchar(100) DEFAULT NULL,
  `PPLieferavis_Material_AvisPosNr` int DEFAULT NULL,
  PRIMARY KEY (`PPLieferavis_Material_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPListBoxes` (
  `PPListBoxes_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPListBoxes_Type` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPListBoxes_Ident` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPListBoxes_Value` varchar(250) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`PPListBoxes_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='	';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLog` (
  `PPLog_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPLog_User` varchar(50) NOT NULL,
  `PPLog_Date` datetime NOT NULL,
  `PPLog_Typ` varchar(150) NOT NULL,
  `PPLog_Old` text,
  `PPLog_New` text,
  PRIMARY KEY (`PPLog_Id`),
  KEY `idx_pplog_typ_date_id` (`PPLog_Typ`,`PPLog_Date`,`PPLog_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=76423 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLsv` (
  `PPLsv_Id` int NOT NULL AUTO_INCREMENT,
  `PPLsv_PPProduktpass_Id` int DEFAULT NULL,
  `PPLsv_code` varchar(500) DEFAULT NULL,
  `PPLsv_name` varchar(500) DEFAULT NULL,
  `PPLsv_countryCodes` varchar(750) DEFAULT NULL,
  `PPLsv_countryNames` varchar(750) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `PPLsv_countryCodesXML` varchar(750) DEFAULT NULL,
  `PPLsv_countryNamesXML` varchar(750) DEFAULT NULL,
  PRIMARY KEY (`PPLsv_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=42214 DEFAULT CHARSET=utf8mb3 COMMENT='			';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPLsvORG` (
  `PPLsv_Id` int NOT NULL AUTO_INCREMENT,
  `PPLsv_PPProduktpass_Id` int DEFAULT NULL,
  `PPLsv_code` varchar(100) DEFAULT NULL,
  `PPLsv_name` varchar(100) DEFAULT NULL,
  `PPLsv_countryCodes` varchar(300) DEFAULT NULL,
  `PPLsv_countryNames` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PPLsv_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=893 DEFAULT CHARSET=utf8mb3 COMMENT='			';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPMeetingprotokoll` (
  `PPMeetingprotokoll_Id` int NOT NULL AUTO_INCREMENT,
  `PPMeetingprotokoll_Thema` varchar(250) NOT NULL DEFAULT 'Neues Meeting',
  `PPMeetingprotokoll_Agenda` text,
  `PPMeetingprotokoll_Text` text,
  `PPMeetingprotokoll_TeilnehmerListe` int DEFAULT NULL,
  `PPMeetingprotokoll_PPProduktpass_Id` int NOT NULL,
  `PPMeetingprotokoll_Date` datetime DEFAULT NULL,
  `PPMeetingprotokoll_DateModified` datetime DEFAULT NULL,
  `PPMeetingprotokoll_Mode` char(1) DEFAULT NULL,
  `PPMeetingprotokoll_Schriftfuehrer` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `PPMeetingprotokoll_Status` int NOT NULL DEFAULT '0',
  `PPMeetingprotokoll_DateFinal` datetime DEFAULT NULL,
  `PPMeetingprotokoll_Art` varchar(25) DEFAULT 'Kickoff',
  PRIMARY KEY (`PPMeetingprotokoll_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=1898 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPMeetingprotokollTeilnehmer` (
  `PPMeetingprotokollTeilnehmer_Id` int NOT NULL AUTO_INCREMENT,
  `PPMeetingprotokollTeilnehmer_Meetingprotokoll_Id` int NOT NULL,
  `PPMeetingprotokollTeilnehmer_PPMitarbeiter_Id` int NOT NULL,
  PRIMARY KEY (`PPMeetingprotokollTeilnehmer_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1222 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='	';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPMengenUebersichtLaender` (
  `PPMengenUebersichtLaender_Id` int NOT NULL AUTO_INCREMENT,
  `PPMengenUebersichtLaender_Art` varchar(45) DEFAULT NULL,
  `PPMengenUebersichtLaender_Land` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`PPMengenUebersichtLaender_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPMitarbeiter` (
  `PPMitarbeiter_Id` int unsigned NOT NULL AUTO_INCREMENT,
  `PPMitarbeiter_Name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPMitarbeiter_Vorname` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPMitarbeiter_Kuerzel` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'password',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id` int DEFAULT NULL,
  `PPMitarbeiter_Gruppe` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPMitarbeiter_Status` int DEFAULT '1',
  `PPMitarbeiter_Taetigkeit` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPMitarbeiter_email` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `Berufsbezeichnung` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Abteilung` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Bemerkung` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `isMaster` int DEFAULT '0',
  `PPMitarbeiter_isDefault` int DEFAULT NULL,
  `PPMitarbeiter_Language` varchar(2) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'DE',
  `PPMitarbeiter_SaveMail` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPMitarbeiter_Role` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'PUB',
  PRIMARY KEY (`PPMitarbeiter_Id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `PPMitarbeiter_Kuerzel_UNIQUE` (`PPMitarbeiter_Kuerzel`)
) ENGINE=InnoDB AUTO_INCREMENT=1422 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPOrder` (
  `PPOrder_Id` int NOT NULL AUTO_INCREMENT,
  `PPOrder_IntrastatNumber` varchar(45) DEFAULT NULL,
  `PPOrder_IntrastatAlternativeUnit` varchar(15) DEFAULT NULL,
  `PPOrder_IntrastatAlternativeUnitAmount` decimal(10,4) DEFAULT NULL,
  `PPOrder_PPProduktpass_Id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `PPOrder_EUDR` varchar(100) DEFAULT NULL,
  `PPOrder_euDataAct` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`PPOrder_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13074 DEFAULT CHARSET=utf8mb3 COMMENT='		';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPOrderWeights` (
  `PPOrderWeights_Id` int NOT NULL AUTO_INCREMENT,
  `PPOrderWeights_gtin` varchar(45) DEFAULT NULL,
  `PPOrderWeights_gtinKL` varchar(45) DEFAULT NULL,
  `PPOrderWeights_productName` varchar(45) DEFAULT NULL,
  `PPOrderWeights_styleNo` varchar(45) DEFAULT NULL,
  `PPOrderWeights_unit` varchar(45) DEFAULT NULL,
  `PPOrderWeights_weight` varchar(45) DEFAULT NULL,
  `PPOrderWeights_lsv` varchar(45) DEFAULT NULL,
  `PPOrderWeights_size` varchar(45) DEFAULT NULL,
  `PPOrderWeights_PPProduktpass_Id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PPOrderWeights_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=26422 DEFAULT CHARSET=utf8mb3 COMMENT='	';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPPPFiles` (
  `PPPPFiles_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPPPFiles_PPProduktpass_Id` bigint NOT NULL,
  `PPPPFiles_Name` varchar(500) NOT NULL,
  `PPPPFiles_Type` varchar(25) DEFAULT NULL,
  `PPPPFiles_Date` datetime DEFAULT NULL,
  `PPPPFiles_Description` varchar(500) DEFAULT NULL,
  `PPPPFiles_Pfad` varchar(300) NOT NULL DEFAULT 'uploads',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `PPPPFiles_SubKat` varchar(200) DEFAULT NULL,
  `PPPPFiles_Ordnung` varchar(50) DEFAULT NULL,
  `PPPPFiles_Link` varchar(500) NOT NULL,
  `PPPPFiles_LinkName` varchar(500) NOT NULL,
  `PPPPFiles_UserCreate` int DEFAULT NULL,
  `PPPPFiles_UserDelete` int DEFAULT NULL,
  `PPPPFiles_Status` int NOT NULL DEFAULT '1',
  `PPPPFiles_SharePointLink` varchar(500) DEFAULT NULL,
  `PPPPFiles_TPTFilenameOld` varchar(500) DEFAULT NULL,
  `PPPPFiles_LocalUpload` int NOT NULL DEFAULT '0',
  `PPPPFiles_Size` float DEFAULT NULL,
  `PPPPFiles_UserLastModified` int DEFAULT NULL,
  `PPPPFiles_DateLastModiefied` datetime DEFAULT NULL,
  `PPPPFiles_UploadException` text,
  `PPPPFiles_NoPPID` tinyint DEFAULT '0',
  `PPPPFiles_IsExtern` tinyint NOT NULL DEFAULT '0',
  `PPPPFiles_StartUpload` datetime DEFAULT NULL,
  `PPPPFiles_FinishUpload` datetime DEFAULT NULL,
  PRIMARY KEY (`PPPPFiles_Id`),
  UNIQUE KEY `PPPPFiles_Id_UNIQUE` (`PPPPFiles_Id`),
  KEY `PPID` (`PPPPFiles_PPProduktpass_Id`),
  KEY `SPOLink` (`PPPPFiles_SharePointLink`(333)),
  KEY `Name` (`PPPPFiles_Name`(333)),
  KEY `NoPPID` (`PPPPFiles_NoPPID`)
) ENGINE=MyISAM AUTO_INCREMENT=787534 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPPerioden` (
  `PPPerioden_Jahr` int DEFAULT NULL,
  `PPPerioden_Monat` int DEFAULT NULL,
  `PPPerioden_Id` bigint NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`PPPerioden_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_Intern` (
  `PPProduktpass_Intern_Id` bigint NOT NULL,
  `PPProduktpass_Intern_Lizenz` varchar(250) DEFAULT NULL,
  `PPProduktpass_Intern_Material` varchar(250) DEFAULT NULL,
  `PPProduktpass_Intern_PPProduktpass_Id` bigint NOT NULL,
  PRIMARY KEY (`PPProduktpass_Intern_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_KLLink` (
  `PPProduktpass_KLLink_Id` int NOT NULL AUTO_INCREMENT,
  `PPProduktpass_KLLink_IAN` varchar(45) DEFAULT NULL,
  `PPProduktpass_KLLink_refNo` varchar(15) DEFAULT NULL,
  `PPProduktpass_KLLink_lotNo` varchar(15) DEFAULT NULL,
  `PPProduktpass_KLLink_PPProduktpass_Id` int NOT NULL,
  PRIMARY KEY (`PPProduktpass_KLLink_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14502 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_Menge` (
  `PPProduktpass_Menge_PPProduktpass_Id` bigint NOT NULL,
  `PPProduktpass_Menge_CountryBlock` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_Country` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_TotalSalePerUnit` decimal(10,4) DEFAULT '0.0000',
  `PPProduktpass_Menge_Quantity` decimal(18,4) DEFAULT '0.0000',
  `PPProduktpass_Menge_PackingMethod` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_DeliveryWeek` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_Menge_Row` int DEFAULT NULL,
  `PPProduktpass_Menge_Rotterdam` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_Barcelona` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_Koper` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_EKUSD` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_VKFOBEUR` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Menge_CBEK` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Menge_Countrysizes` varchar(300) DEFAULT NULL,
  `PPProduktpass_Menge_CBVK` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Menge_LT1` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_LT1Menge` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_LT2` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_LT2Menge` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_LT3` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_LT3Menge` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_ArtikelInfo` varchar(200) DEFAULT NULL,
  `PPProduktpass_Menge_Kolli` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_CountryGSM` bigint DEFAULT '0',
  `PPProduktpass_Menge_FOBPriice` decimal(10,2) DEFAULT '0.00',
  `PPProduktpass_Menge_8WMuster` int NOT NULL DEFAULT '0',
  `PPProduktpass_Menge_CartonSize` varchar(45) DEFAULT '',
  `PPProduktpass_Menge_PcsPerCarton` bigint DEFAULT '0',
  `PPProduktpass_Menge_CartonPerPal` bigint DEFAULT NULL,
  `PPProduktpass_Menge_Trucks` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_countryRemarks` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`PPProduktpass_Menge_Id`),
  KEY `PPID` (`PPProduktpass_Menge_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1074930 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_Menge_Final` (
  `PPProduktpass_Menge_PPProduktpass_Id` bigint NOT NULL,
  `PPProduktpass_Menge_CountryBlock` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_Country` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_TotalSalePerUnit` decimal(10,4) DEFAULT '0.0000',
  `PPProduktpass_Menge_Quantity` decimal(18,4) DEFAULT '0.0000',
  `PPProduktpass_Menge_PackingMethod` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_DeliveryWeek` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_Menge_Row` int DEFAULT NULL,
  `PPProduktpass_Menge_Rotterdam` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_Barcelona` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_Koper` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_EKUSD` decimal(18,4) DEFAULT NULL,
  `PPProduktpass_Menge_VKFOBEUR` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Menge_CBEK` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Menge_Countrysizes` varchar(300) DEFAULT NULL,
  `PPProduktpass_Menge_CBVK` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Menge_LT1` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_LT1Menge` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_LT2` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_LT2Menge` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_LT3` varchar(20) DEFAULT NULL,
  `PPProduktpass_Menge_LT3Menge` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_ArtikelInfo` varchar(200) DEFAULT NULL,
  `PPProduktpass_Menge_Kolli` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_Menge_CountryGSM` bigint DEFAULT '0',
  `PPProduktpass_Menge_FOBPriice` decimal(10,2) DEFAULT '0.00',
  `PPProduktpass_Menge_8WMuster` int NOT NULL DEFAULT '0',
  `PPProduktpass_Menge_CartonSize` varchar(45) DEFAULT '',
  `PPProduktpass_Menge_PcsPerCarton` bigint DEFAULT '0',
  `PPProduktpass_Menge_CartonPerPal` bigint DEFAULT NULL,
  `PPProduktpass_Menge_Trucks` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`PPProduktpass_Menge_Id`),
  KEY `PPID` (`PPProduktpass_Menge_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_OSSortMengen` (
  `PPProduktpass_OSSortMengen_id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_OSSortMengen_OSLand` varchar(3) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize01` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize02` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize03` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize04` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize05` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize06` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize07` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize08` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize09` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_OSMengeSize10` decimal(10,2) DEFAULT NULL,
  `PPProduktpass_OSSortMengen_Sortierung_id` bigint NOT NULL,
  PRIMARY KEY (`PPProduktpass_OSSortMengen_id`),
  KEY `OSSortIOD` (`PPProduktpass_OSSortMengen_Sortierung_id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=136622 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_Qualitaet` (
  `PPProduktpass_Qualitaet_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_Qualitaet_Header` varchar(100) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Row` int DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value01` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_PPProduktpass_Id` bigint NOT NULL,
  `PPProduktpass_Qualitaet_Value02` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value03` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value04` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value05` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value06` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value07` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value08` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value09` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value10` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value11` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value12` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value13` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value14` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_Value15` varchar(1350) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo01` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo02` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo03` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo04` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo05` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo06` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo07` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo08` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo09` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo10` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo11` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo12` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo13` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo14` varchar(50) DEFAULT NULL,
  `PPProduktpass_Qualitaet_StyleNo15` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PPProduktpass_Qualitaet_Id`),
  UNIQUE KEY `PPProduktpass_Qualitaet_Id_UNIQUE` (`PPProduktpass_Qualitaet_Id`),
  KEY `PPID` (`PPProduktpass_Qualitaet_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=332108 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_Sortierung` (
  `PPProduktpass_Sortierung_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_Sortierung_Header` varchar(800) DEFAULT NULL,
  `PPProduktpass_Sortierung_Row` int DEFAULT NULL,
  `PPProduktpass_Sortierung_Value01` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_PPProduktpass_Id` bigint NOT NULL,
  `PPProduktpass_Sortierung_Value02` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value03` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value04` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value05` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value06` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value07` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value08` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value09` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_Value10` varchar(350) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeDE` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_Translate_Design` varchar(300) DEFAULT NULL,
  `PPProduktpass_Sortierung_EANOS` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_Laenderblock` varchar(500) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeBE` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeNL` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_Version` int NOT NULL DEFAULT '0',
  `PPProduktpass_Sortierung_OSMengeCZ` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeES` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeGB` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeFR` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN02` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN03` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN04` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN05` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN06` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN07` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN08` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN09` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_EAN10` varchar(30) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size01` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size02` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size03` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size04` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size05` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size06` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size07` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size08` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size09` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_Size10` varchar(100) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengePL` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeSK` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Sortierung_OSMengeAT` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`PPProduktpass_Sortierung_Id`),
  UNIQUE KEY `PPProduktpass_Sortierung_Id_UNIQUE` (`PPProduktpass_Sortierung_Id`),
  KEY `PPID` (`PPProduktpass_Sortierung_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=726098 DEFAULT CHARSET=utf8mb3 COMMENT='dsdg';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProduktpass_Style` (
  `PPProduktpass_Style_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_Style_Header` varchar(200) DEFAULT NULL,
  `PPProduktpass_Style_Value01` varchar(1500) DEFAULT NULL,
  `PPProduktpass_Style_Value02` varchar(1500) DEFAULT NULL,
  `PPProduktpass_Style_Value03` varchar(200) DEFAULT NULL,
  `PPProduktpass_Style_Value04` varchar(200) DEFAULT NULL,
  `PPProduktpass_Style_Value05` varchar(200) DEFAULT NULL,
  `PPProduktpass_Style_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPProduktpass_Style_PPPPFiles_Id` bigint NOT NULL DEFAULT '0',
  `PPProduktpass_Style_LidlID` int DEFAULT NULL,
  `PPProduktpass_Style_Zolltarifnummer` varchar(100) DEFAULT NULL,
  `PPProduktpass_Style_Value01_Translation` varchar(1500) DEFAULT NULL,
  `PPProduktpass_Style_Value02_Translation` varchar(1500) DEFAULT NULL,
  `PPProduktpass_Style_Value03_Translation` varchar(200) DEFAULT NULL,
  `PPProduktpass_Style_Value04_Translation` varchar(200) DEFAULT NULL,
  `PPProduktpass_Style_Value05_Translation` varchar(200) DEFAULT NULL,
  `productName` varchar(50) NOT NULL,
  `styleNo` varchar(50) NOT NULL,
  `uniqueId` varchar(50) NOT NULL,
  `vendorUniqueId` varchar(50) NOT NULL,
  `color` varchar(1500) NOT NULL,
  `internalSeqNo` int NOT NULL,
  `material` text NOT NULL,
  `notOrderable` int NOT NULL,
  `qualityTechnicalData` text NOT NULL,
  `sizeWithoutPackaging` text NOT NULL,
  `weightWithoutPackaging` text NOT NULL,
  `additionalQualityInformation` text NOT NULL,
  `changesFromPredecessor` text NOT NULL,
  `brandReference` varchar(1500) NOT NULL,
  `materialThickness` varchar(1500) NOT NULL,
  PRIMARY KEY (`PPProduktpass_Style_Id`),
  KEY `PPID` (`PPProduktpass_Style_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72385 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProjekte` (
  `PPProjekte_Id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `PPProjekte_Bezeichnung` varchar(100) DEFAULT NULL,
  `PPProjekte_AnlageDatum` datetime DEFAULT NULL,
  `PPProjekte_Verantwortlich` varchar(100) DEFAULT NULL,
  `PPProjekte_Status` varchar(45) NOT NULL DEFAULT 'offen',
  PRIMARY KEY (`PPProjekte_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPProtokoll` (
  `PPProtokoll_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProtokoll_Table` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPProtokoll_TableId` bigint NOT NULL,
  `PPProtokoll_Benutzer` varchar(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPProtokoll_Feld` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPProtokoll_OldContent` varchar(1500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPProtokoll_NewContent` varchar(1500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPProtokoll_DateTime` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPProtokoll_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPProtokoll_isActive` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`PPProtokoll_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=465203 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPPurchase` (
  `PPPurchase_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPPurchase_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPPurchase_LcNumber` varchar(100) DEFAULT NULL,
  `PPPurchase_ScNumber` varchar(100) DEFAULT NULL,
  `PPPurchase_Inquiry` varchar(100) DEFAULT NULL,
  `PPPurchase_Supplier` varchar(100) NOT NULL DEFAULT 'N.N.',
  `PPPurchase_Currency` varchar(3) DEFAULT NULL,
  `PPPurchase_ExcR_Save` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `PPPurchase_ExcR_Save_Date` datetime DEFAULT NULL,
  `PPPurchase_ExcR_Calc` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `PPPurchase_ExcR_Remark` varchar(100) DEFAULT NULL,
  `PPPurchase_CustomsCode` varchar(100) DEFAULT NULL,
  `PPPurchase_DutyPercentage` decimal(6,2) DEFAULT NULL,
  `PPPurchase_DeliveryDate` varchar(25) DEFAULT NULL,
  `PPPurchase_ResOffice` varchar(25) NOT NULL DEFAULT 'N.N.',
  `PPPurchase_Description` blob,
  `PPPurchase_Material` blob,
  `PPPurchase_Remark` blob,
  `PPPurchase_TermsOfDelivery` int DEFAULT NULL,
  `PPPurchase_TermsOfPayment` int DEFAULT NULL,
  `PPPurchase_Status` varchar(10) DEFAULT '0',
  `PPPurchase_PortOfDischarge` varchar(50) DEFAULT NULL,
  `PPPurchase_Country` varchar(20) DEFAULT NULL,
  `PPPurchase_OrderDate` datetime DEFAULT NULL,
  `PPPurchase_SupplierDelDate` varchar(200) DEFAULT NULL,
  `PPPurchase_Factory` varchar(50) DEFAULT NULL,
  `PPPurchase_EK_Calc` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_EK` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Fracht` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Zoll` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_EKProvision` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Ausgangsfrachten` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Finanzierungskosten` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Pruefkosten` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `PPPurchase_Lizenzgebuehren` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Kosten` decimal(10,4) DEFAULT '0.0000',
  `PPPurchase_Translate_Quality` varchar(2500) DEFAULT NULL,
  `PPPurchase_Translate_Projectdescription` varchar(2500) DEFAULT NULL,
  `PPPurchase_Translate_ManufacturingPlant` varchar(2500) DEFAULT NULL,
  `PPPurchase_Translate_Packaging` varchar(2500) DEFAULT NULL,
  `PPPurchase_SonstKostenProz` decimal(10,4) DEFAULT NULL,
  `PPPurchase_BemerkungAenderungen` blob,
  `PPPurchase_ManufacturingPlant` bigint DEFAULT NULL,
  `PPPurchase_LC_TOP` varchar(100) DEFAULT NULL,
  `PPPurchase_Pruefinstitut` varchar(250) DEFAULT NULL,
  `PPPurchase_Transportdokumente` varchar(100) DEFAULT NULL,
  `PPPurchase_Transportdokumente2` varchar(100) DEFAULT NULL,
  `PPPurchase_BWGroesse` varchar(100) DEFAULT NULL,
  `PPPurchase_FOBWeek` varchar(10) DEFAULT NULL,
  `PPPurchase_FOBYear` varchar(10) DEFAULT NULL,
  `PPPurchase_FOBSpecial` varchar(500) DEFAULT NULL,
  `PPPurchase_ExcR` decimal(10,4) DEFAULT NULL,
  `PPPurchase_ExcR_Date` varchar(45) DEFAULT NULL,
  `PPPurchase_UploadDate` datetime DEFAULT NULL,
  `PPPurchase_FOBQm` decimal(10,4) DEFAULT NULL,
  `PPPurchase_InspectionCenter` varchar(50) DEFAULT NULL,
  `PPPurchase_IsCommission` int NOT NULL DEFAULT '0',
  `PPPurchase_DeliveryFrom` varchar(50) NOT NULL DEFAULT 'N.N.' COMMENT 'N.N. Asia, Mediteranean',
  `PPPurchase_FirstSampling` date DEFAULT NULL,
  `PPPurchase_SecondSampling` date DEFAULT NULL,
  `PPPurchase_ManCheckOK` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`PPPurchase_Id`),
  UNIQUE KEY `ID` (`PPPurchase_Id`),
  KEY `PPID` (`PPPurchase_PPProduktpass_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=19686 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPPurchaseDTK` (
  `PPPurchaseDTK_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPPurchaseDTK_PPProduktpass_id` bigint NOT NULL,
  `PPPurchaseDTK_PPDevisenTerminKaeufe_Id` bigint DEFAULT NULL,
  `PPPurchaseDTK_Betrag` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`PPPurchaseDTK_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPRetail` (
  `PPRetail_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPRetail_Code` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PPRetail_CustMemoText1` blob,
  `PPRetail_CustMemoText3` blob,
  `PPRetail_Name` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`PPRetail_Id`,`PPRetail_Code`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPShipment` (
  `PPShipment_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPShipment_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPShipment_Forwarder` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_Carrier` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_Lot` int DEFAULT NULL,
  `PPShipment_Vessel` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_Voyage` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_ENS` datetime DEFAULT NULL,
  `PPShipment_CYClosing` datetime DEFAULT NULL,
  `PPShipment_ETD` datetime DEFAULT NULL,
  `PPShipment_ETA` datetime DEFAULT NULL,
  `PPShipment_ShipReleaseGiven` datetime DEFAULT NULL,
  `PPShipment_ShipReleaseCalc` datetime DEFAULT NULL,
  `PPShipment_CRDGiven` datetime DEFAULT NULL,
  `PPShipment_CRDOpeningCalc` datetime DEFAULT NULL,
  `PPShipment_CRDClosingCalc` datetime DEFAULT NULL,
  `PPShipment_UnloadingReportDate` datetime DEFAULT NULL,
  `PPShipment_20ftGP` int DEFAULT NULL,
  `PPShipment_40ftGP` int DEFAULT NULL,
  `PPShipment_40ftHQ` int DEFAULT NULL,
  `PPShipment_LCLCBM` int DEFAULT NULL,
  `PPShipment_20ftGPCalc` int DEFAULT NULL,
  `PPShipment_40ftGPCalc` int DEFAULT NULL,
  `PPShipment_40ftHQCalc` int DEFAULT NULL,
  `PPShipment_CurrentStatus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_BLForm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_LCOA` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_ProducerBooking` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_ShipRelease` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_SO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_BL` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_Invoce` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_PL` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_CoO` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_DeclarationFumigation` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_OceanFreight` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_PL2MaWi` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_CLPSent` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_SeaFreightInvoice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_TransportInvoice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_UnloadingInvoice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_OtherLogisticalCosts` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_CCCsent` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_CustomsInvoice` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_CustomsDeclared` datetime DEFAULT NULL,
  `PPShipment_HSCode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPShipment_ProjektCount` int DEFAULT NULL,
  `PPShipment_TEU` int DEFAULT NULL,
  `PPShipment_VKStk` decimal(10,2) DEFAULT NULL,
  `PPShipment_VKSumme` decimal(10,2) DEFAULT NULL,
  `PPShipment_DistancePort2Port` decimal(10,2) DEFAULT NULL,
  `PPShipment_Incoterm` varchar(45) DEFAULT NULL,
  `PPShipment_LT` datetime DEFAULT NULL,
  `PPShipment_MS_30PSI` datetime DEFAULT NULL,
  `PPShipment_MS_EUG` datetime DEFAULT NULL,
  `PPShipment_MS_PSI` datetime DEFAULT NULL,
  `PPShipment_POA` varchar(45) DEFAULT NULL,
  `PPShipment_POD` varchar(45) DEFAULT NULL,
  `PPShipment_SaleUnit` varchar(45) DEFAULT NULL,
  `PPShipment_Supplier` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `PPShipment_Status` varchar(45) DEFAULT '1',
  `PPShipment_Quantity` bigint DEFAULT NULL,
  `PPShipment_Flag_Producer_booking` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Shipment_Release` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_SO` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_BL` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Inv` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_PL` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_CoO` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Declaration_of_Fumigation` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Ocean_Freight` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_PL_sent_to_MaWi` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_CLP_sent` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Sea_freight_invoice` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Transport_invoice` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Unloading_invoice` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Other_logistical_costs` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_CCC_sent` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_customs_invoice` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_OS` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_EUService` tinyint NOT NULL DEFAULT '0',
  `PPShipment_Flag_Critical` tinyint NOT NULL DEFAULT '0',
  `PPShipment_BatteryType` varchar(100) DEFAULT NULL,
  `PPShipment_MasterCartonContents` int DEFAULT NULL,
  `PPShipment_IAN` varchar(10) DEFAULT NULL,
  `PPShipment_Ausmusterungnummer` varchar(10) DEFAULT NULL,
  `PPShipment_ATAInlandsterminal` datetime DEFAULT NULL,
  `PPShipment_ShipmentStatus` varchar(45) DEFAULT NULL,
  `PPShipment_ZipCodeFactory` varchar(45) DEFAULT NULL,
  `PPShipment_Sortierung` int DEFAULT NULL,
  PRIMARY KEY (`PPShipment_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3911 DEFAULT CHARSET=utf8mb3 COMMENT='PPShipment_INCOTERM\nPPShipment_LT\nPPShipment_LT';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPStati` (
  `PPStati_Id` int NOT NULL AUTO_INCREMENT,
  `PPStati_Status` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPStati_Color` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPStati_Background` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPStati_OKStatus` smallint DEFAULT '0',
  PRIMARY KEY (`PPStati_Id`),
  UNIQUE KEY `PPStati_Id` (`PPStati_Id`) INVISIBLE ,
  UNIQUE KEY `PPStati_ST` (`PPStati_Status`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='			';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPStatiX` (
  `PPStati_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPStati_Art` varchar(30) NOT NULL,
  `PPStati_Status` varchar(100) NOT NULL,
  PRIMARY KEY (`PPStati_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTCKosten` (
  `PPTCKosten_Id` int NOT NULL AUTO_INCREMENT,
  `PPTCKosten_Number` int DEFAULT NULL,
  `PPTCKosten_PPProduktpass_Id` int DEFAULT NULL,
  `PPTCKosten_PPKostenTypen_Id` int DEFAULT NULL,
  `PPTCKosten_PrototypeAnzahl` bigint DEFAULT NULL,
  `PPTCKosten_TrialRunAnzahl` bigint DEFAULT NULL,
  `PPTCKosten_MPAnzahl` bigint DEFAULT NULL,
  `PPTCKosten_Einzelkosten` decimal(10,4) DEFAULT NULL,
  `PPTCKosten_Bemerkung` blob,
  `PPTCKosten_Bezeichnung` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PPTCKosten_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTCKostenTypen` (
  `PPTCKostenTypen_Id` int NOT NULL AUTO_INCREMENT,
  `PPTCKostenTypen_Bezeichnung` varchar(100) DEFAULT NULL,
  `PPTCKostenTypen_StandardKosten` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`PPTCKostenTypen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='				';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTaetigkeiten` (
  `PPTaetigkeiten_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPTaetigkeiten_Taetigkeit` varchar(5) DEFAULT NULL,
  `PPTaetigkeiten_Description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`PPTaetigkeiten_Id`),
  UNIQUE KEY `PPTaetigkeiten_Taetigkeit_UNIQUE` (`PPTaetigkeiten_Taetigkeit`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTempQualitaet` (
  `PPTempQualitaet_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPTempQualitaet_PPQualitaet_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPTempQualitaet_Style` varchar(100) DEFAULT NULL,
  `PPTempQualitaet_Value` blob,
  PRIMARY KEY (`PPTempQualitaet_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTermine` (
  `PPTermine_Id` int unsigned NOT NULL AUTO_INCREMENT,
  `PPTermine_PPProduktpass_Id` bigint NOT NULL,
  `PPTermine_DatumStart` datetime DEFAULT NULL,
  `PPTermine_DatumEnde` datetime DEFAULT NULL,
  `PPTermine_Header` varchar(100) DEFAULT NULL,
  `PPTermine_Art` varchar(100) DEFAULT NULL,
  `PPTermine_Typ` varchar(100) DEFAULT NULL,
  `PPTermine_MAAnlage` int NOT NULL DEFAULT '0',
  `PPTermine_MAZustaendigkeit` int NOT NULL DEFAULT '0',
  `PPTermine_Status` varchar(100) NOT NULL DEFAULT 'neu',
  `PPTermine_Bemerkungen` longtext,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `PPTermine_PPBoardSpalte_id` bigint DEFAULT NULL,
  `PPTermine_History` longtext,
  `PPTermine_Label` varchar(500) DEFAULT NULL,
  `PPTermine_ManSoll` int NOT NULL,
  `PPTermine_ManSollDate` datetime DEFAULT NULL,
  `PPTermine_ManSollDateX` datetime DEFAULT NULL,
  `PPTermine_SimDate` datetime DEFAULT NULL,
  `PPTermine_BemerkungenBearbeiter` longtext,
  `PPTermine_BemerkungenBearbeiterEN` longtext,
  `PPTermine_BemerkungenEN` longtext,
  `PPTermine_LabelEN` varchar(500) DEFAULT NULL,
  `PPTermine_HistoryEN` longtext,
  `PPTermine_IsMPlan` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`PPTermine_Id`),
  KEY `PPTermine_Id` (`PPTermine_Id`),
  KEY `PPTermine_Id2` (`PPTermine_Id`) INVISIBLE ,
  KEY `BoardSpalte` (`PPTermine_PPBoardSpalte_id`),
  KEY `TermineMA` (`PPTermine_MAZustaendigkeit`),
  KEY `TermineMAAnl` (`PPTermine_MAAnlage`),
  KEY `TermineTyp` (`PPTermine_Typ`),
  KEY `TermineStart` (`PPTermine_DatumStart`),
  KEY `TermineEnde` (`PPTermine_DatumEnde`),
  KEY `PPID` (`PPTermine_PPProduktpass_Id`),
  KEY `Status` (`PPTermine_Status`)
) ENGINE=InnoDB AUTO_INCREMENT=954995 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTermineAnhaenge` (
  `PPTermineAnhaenge_Id` int unsigned NOT NULL AUTO_INCREMENT,
  `PPTermineAnhaenge_PPTermine_Id` bigint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `PPTermineAnhaenge_Datei` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPTermineAnhaenge_Bemerkung` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPTermineAnhaenge_UploadeDatum` datetime NOT NULL,
  `PPTermineAnhaenge_UploadMA` int NOT NULL,
  PRIMARY KEY (`PPTermineAnhaenge_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTermineChanges` (
  `PPTermineChanges_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPTermineChanges_PPTermine_Id` bigint DEFAULT NULL,
  `PPTermineChanges_Date` datetime DEFAULT NULL,
  `PPTermineChanges_Remark` varchar(500) DEFAULT NULL,
  `PPTermineChanges_Categorie` varchar(150) DEFAULT NULL,
  `PPTermineChanges_oldStatus` varchar(100) DEFAULT NULL,
  `PPTermineChanges_newStatus` varchar(100) DEFAULT NULL,
  `PPTermineChanges_PPProduktpass_Id` bigint DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `PPTermineChanges_Mitarbeiter_Id` int DEFAULT NULL,
  `PPTermineChanges_DoUntil` datetime DEFAULT NULL,
  `PPTermineChanges_DoneAt` datetime DEFAULT NULL,
  `PPTermineChanges_Receiver` bigint DEFAULT NULL,
  `PPTermineChanges_PPPPFilesId` bigint DEFAULT NULL,
  `PPTermineChanges_ParentId` bigint DEFAULT NULL,
  `PPTermineChanges_IsActive` int NOT NULL DEFAULT '1',
  `PPTermineChanges_DoUntilOld` datetime DEFAULT NULL,
  `PPTermineChanges_Mitarbeiter_Id_Old` int NOT NULL,
  `PPTermineChanges_Reporter` int NOT NULL,
  `PPTermineChanges_RemarkReceiver` varchar(500) DEFAULT NULL,
  `PPTermineChanges_RemarkEN` varchar(500) DEFAULT NULL,
  `PPTermineChanges_CategorieEN` varchar(150) DEFAULT NULL,
  `PPTermineChanges_RemarkReceiverEN` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`PPTermineChanges_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=70335 DEFAULT CHARSET=utf8mb3 COMMENT='Logtable um die Statusänderungen der Termine zu protokollieren	';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTermineHistory` (
  `PPTermineHistory_Id` int unsigned NOT NULL AUTO_INCREMENT,
  `PPTermineHistory_PPTermine_Id` bigint NOT NULL,
  `PPTermineHistory_Datum` datetime NOT NULL,
  `PPTermineHistory_MA` int NOT NULL,
  `PPTermineHistory_DatumStart` datetime NOT NULL,
  `PPTermineHistory_DatumEnde` datetime NOT NULL,
  `PPTermineHistory_Header` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPTermineHistory_Art` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPTermineHistory_Typ` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPTermineHistory_MAAnlage` int NOT NULL,
  `PPTermineHistory_MAZustaendigkeit` int NOT NULL,
  `PPTermineHistory_Status` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPTermineHistory_Bemerkungen` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  PRIMARY KEY (`PPTermineHistory_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTermineMusterung` (
  `PPTermineMusterung_Id` int NOT NULL AUTO_INCREMENT,
  `PPTermineMusterung_PPBoardSpalte_Id` int NOT NULL,
  `PPTermineMusterung_DateTime` date NOT NULL,
  `PPTermineMusterung_Ausmusterung` varchar(20) NOT NULL,
  `PPTermineMusterung_Spalte` varchar(100) NOT NULL,
  PRIMARY KEY (`PPTermineMusterung_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTermineSave` (
  `PPTermine_Id` int unsigned NOT NULL AUTO_INCREMENT,
  `PPTermine_PPProduktpass_Id` bigint NOT NULL,
  `PPTermine_DatumStart` datetime DEFAULT NULL,
  `PPTermine_DatumEnde` datetime DEFAULT NULL,
  `PPTermine_Header` varchar(100) DEFAULT NULL,
  `PPTermine_Art` varchar(100) DEFAULT NULL,
  `PPTermine_Typ` varchar(100) DEFAULT NULL,
  `PPTermine_MAAnlage` int NOT NULL DEFAULT '0',
  `PPTermine_MAZustaendigkeit` int NOT NULL DEFAULT '0',
  `PPTermine_Status` varchar(100) NOT NULL DEFAULT 'neu',
  `PPTermine_Bemerkungen` longtext,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `PPTermine_PPBoardSpalte_id` bigint DEFAULT NULL,
  `PPTermine_History` text,
  `PPTermine_Label` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`PPTermine_Id`),
  KEY `PPTermine_Id` (`PPTermine_Id`),
  KEY `PPTermine_Id2` (`PPTermine_Id`),
  KEY `BoardSpalte` (`PPTermine_PPBoardSpalte_id`),
  KEY `TermineMA` (`PPTermine_MAZustaendigkeit`),
  KEY `TermineMAAnl` (`PPTermine_MAAnlage`),
  KEY `TermineTyp` (`PPTermine_Typ`),
  KEY `TermineStart` (`PPTermine_DatumStart`),
  KEY `TermineEnde` (`PPTermine_DatumEnde`),
  KEY `PPID` (`PPTermine_PPProduktpass_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=156777 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTerms` (
  `PPTerms_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPTerms_Art` varchar(100) DEFAULT NULL COMMENT 'Art des terms ''D'' = delivery P = Payment etc..',
  `PPTerms_MC` varchar(100) DEFAULT NULL,
  `PPTerms_Text` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PPTerms_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTextbausteine` (
  `PPTextbausteine_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPTextbausteine_Art` varchar(100) DEFAULT NULL,
  `PPTextbausteine_Text` blob,
  `PPTextbausteine_Picture` varchar(100) DEFAULT NULL,
  `PPTextbausteine_PicturePos` int NOT NULL DEFAULT '0' COMMENT '1=Vor dem Text, 0=Nach dem Text\n',
  `PPTextbausteine_Verwendung` varchar(50) DEFAULT NULL,
  `PPTextbausteine_Type` varchar(50) DEFAULT NULL,
  `PPTextbausteine_SortOrder` int DEFAULT NULL,
  PRIMARY KEY (`PPTextbausteine_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTextbausteineProjekte` (
  `PPTextbausteineProjekte_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPTextbausteineProjekte_PPID` bigint DEFAULT NULL,
  `PPTextbausteineProjekte_Textbausteine_Id` bigint DEFAULT NULL,
  `PPTextbausteineProjekte_Text` blob,
  `PPTextbausteineProjekte_IsActive` int DEFAULT NULL,
  PRIMARY KEY (`PPTextbausteineProjekte_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=977 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPThema` (
  `PPThema_Id` int NOT NULL AUTO_INCREMENT,
  `PPThema_PPProduktpass_Id` int DEFAULT NULL,
  `PPThema_requierdSamples` varchar(45) DEFAULT NULL,
  `PPThema_kolli` varchar(45) DEFAULT NULL,
  `PPThema_assortment` varchar(500) DEFAULT NULL,
  `PPThema_warranty` varchar(500) DEFAULT NULL,
  `PPThema_cerificates` varchar(500) DEFAULT NULL,
  `PPThema_themerange` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaRequierdSamples` varchar(45) DEFAULT NULL,
  `PPProduktpass_ThemaKolli` varchar(45) DEFAULT NULL,
  `PPProduktpass_ThemaAssortment` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaWarranty` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaRisc` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaCerificates` varchar(250) DEFAULT NULL,
  `PPProduktpass_ThemaScope` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PPThema_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='- Zertifizierung (Spalte O)\n- Themenbereich (';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPTranslateGUI` (
  `PPTranslateGUI_Id` int NOT NULL AUTO_INCREMENT,
  `PPTranslateGUI_TextDE` text NOT NULL,
  `PPTranslateGUI_TextEN` text,
  `PPTranslateGUI_TextNL` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`PPTranslateGUI_Id`),
  KEY `DE` (`PPTranslateGUI_TextDE`(500))
) ENGINE=InnoDB AUTO_INCREMENT=30925 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPUserSettings` (
  `PPUserSettings_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPUserSettings_Setting` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPUserSettings_Type` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPUserSettings_Value` varchar(300) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPUserSettings_User` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPUserSettings_UserId` int DEFAULT NULL,
  PRIMARY KEY (`PPUserSettings_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci COMMENT='					';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPWarengruppeNotice` (
  `PPWarengruppeNotice_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPWarengruppeNotice_WGRP` varchar(100) DEFAULT NULL,
  `PPWarengruppeNotice_Notice` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`PPWarengruppeNotice_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPXMLNodes` (
  `PPXMLNodes_Id` int NOT NULL AUTO_INCREMENT,
  `PPXMLNodes_Node` varchar(100) NOT NULL DEFAULT '',
  `PPXMLNodes_Path` varchar(500) NOT NULL DEFAULT '',
  `PPXMLNodes_Customname` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`PPXMLNodes_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='					';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPXML_Mengen` (
  `PPXML_Mengen_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPXML_Mengen_lsv` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_styleNo` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_productName` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_country` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPXML_Mengen_sizeName` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_sizeCode` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_GTIN` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_Mengen_GTINKL` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PPXML_Mengen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=847567 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPXML_OSMengen` (
  `PPXML_OSMengen_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPXML_OSMengen_lsv` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_styleNo` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_productName` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_country` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPXML_OSMengen_sizeName` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_GTIN` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `PPXML_OSMengen_GTINKL` varchar(50) DEFAULT NULL,
  `PPXML_OSMengen_DeliveryNo` int DEFAULT NULL,
  PRIMARY KEY (`PPXML_OSMengen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=233618 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PPZahlungen` (
  `PPZahlungen_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPZahlungen_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPZahlungen_LC` varchar(50) DEFAULT NULL,
  `PPZahlungen_Nummer` varchar(50) DEFAULT NULL,
  `PPZahlungen_BezahltAm` date DEFAULT NULL,
  `PPZahlungen_Bemerkung` varchar(50) DEFAULT NULL,
  `PPZahlungen_LCEroeffnung` date DEFAULT NULL,
  `PPZahlungen_LCEroeffnungAlternativ` varchar(50) DEFAULT NULL,
  `PPZahlungen_Andienung` date DEFAULT NULL,
  `PPZahlungen_Faelligkeit` date DEFAULT NULL,
  `PPZahlungen_ZahlungKunde` date DEFAULT NULL,
  `PPZahlungen_BezahltBemerkung` varchar(50) DEFAULT NULL,
  `PPZahlungen_Betrag` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`PPZahlungen_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Parameter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) DEFAULT NULL,
  `Bezeichnung` varchar(50) DEFAULT NULL,
  `value` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `PreisblattFracht` (
  `ID` varchar(250) NOT NULL,
  `Musterung` varchar(45) DEFAULT NULL,
  `20FussGRP1` varchar(45) DEFAULT NULL,
  `20FussGRP2` varchar(45) DEFAULT NULL,
  `20FussGRP3` varchar(45) DEFAULT NULL,
  `20FussGRP4` varchar(45) DEFAULT NULL,
  `20FussGRP5` varchar(45) DEFAULT NULL,
  `20FussGRP6` varchar(45) DEFAULT NULL,
  `40FussGRP1` varchar(45) DEFAULT NULL,
  `40FussGRP2` varchar(45) DEFAULT NULL,
  `40FussGRP3` varchar(45) DEFAULT NULL,
  `40FussGRP4` varchar(45) DEFAULT NULL,
  `40FussGRP5` varchar(45) DEFAULT NULL,
  `40FussGRP6` varchar(45) DEFAULT NULL,
  `Nachlauf` varchar(45) DEFAULT NULL,
  `Erstellt` datetime DEFAULT NULL,
  `Ersteller` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Rechnungsprüfung` (
  `aktiv` enum('1','0') NOT NULL DEFAULT '1',
  `PPFileTypes_Id` int DEFAULT NULL,
  `Eingangsdatum` date DEFAULT NULL,
  `Kreditor` varchar(50) DEFAULT NULL,
  `Rechnungsdatum` date DEFAULT NULL,
  `Rechnungsnummer` varchar(50) DEFAULT NULL,
  `Währung` varchar(3) DEFAULT NULL,
  `Kurs` varchar(50) NOT NULL DEFAULT '1',
  `Betrag_netto` float DEFAULT NULL,
  `IAN` mediumtext,
  `Menge` int DEFAULT NULL,
  `Rabatt_absolut` decimal(10,2) DEFAULT NULL,
  `Kostenart` mediumtext,
  `Bemerkung` mediumtext,
  `Erstellt` datetime DEFAULT NULL,
  `Ersteller` mediumtext,
  `UploadDokument` varchar(1000) DEFAULT NULL,
  `Nummer_Id` varchar(250) NOT NULL,
  `Mwst` varchar(45) DEFAULT NULL,
  `Gruppe` varchar(45) DEFAULT NULL,
  `LC_Nummer` varchar(200) DEFAULT NULL,
  `Bezahlt_am` date DEFAULT NULL,
  `Fallig` date DEFAULT NULL,
  `Inhalt` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Nummer_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Reports` (
  `Reports_Id` int NOT NULL AUTO_INCREMENT,
  `Reports_Name` varchar(50) DEFAULT NULL,
  `Reports_Description` text,
  `Reports_Link` varchar(500) DEFAULT NULL,
  `Reports_UseERP` int DEFAULT NULL,
  `Reports_UseLisi` int DEFAULT NULL,
  PRIMARY KEY (`Reports_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `RestrictedZolltarif` (
  `RestrictedZolltarif_Id` bigint NOT NULL AUTO_INCREMENT,
  `RestrictedZolltarif_Zolltarifnummer` varchar(45) DEFAULT NULL,
  `RestrictedZolltarif_Bezeichnug` varchar(1000) DEFAULT NULL,
  `RestrictedZolltarif_Restriction` varchar(50) DEFAULT NULL,
  `RestrictedZolltarif_IsActiv` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`RestrictedZolltarif_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=885 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `SKR03` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Konto` varchar(50) DEFAULT NULL,
  `S_H` varchar(50) DEFAULT NULL,
  `Konten_Zeilenbeschriftung` varchar(50) DEFAULT NULL,
  `Zeile` int DEFAULT NULL,
  `Bezeichnung_Sammelkonto` varchar(50) DEFAULT NULL,
  `Folge` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `SammelkontenSKR03` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Sammelkonto` int DEFAULT NULL,
  `Konten-/Zeilenbeschriftung` varchar(50) DEFAULT NULL,
  `Zeile` int DEFAULT NULL,
  `Sammelkonten Folge` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Steuersatz` (
  `Steuersatz_Id` int NOT NULL AUTO_INCREMENT,
  `Matchcode` varchar(50) DEFAULT NULL,
  `Bezeichnung` varchar(50) DEFAULT NULL,
  `Steuersatz` decimal(10,2) DEFAULT NULL,
  `Lieferland` char(3) DEFAULT NULL,
  `GueltigVon` datetime DEFAULT NULL,
  `GueltigBis` datetime DEFAULT NULL,
  `Steuercode` int DEFAULT NULL COMMENT '1 = Steuerfrei\\n2 = Normalsatz\\n3 = Ermässigter Satz',
  PRIMARY KEY (`Steuersatz_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Steuerschluessel` (
  `Steuerschluessel_Id` int NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(50) DEFAULT NULL,
  `SteuerAusweisen` int DEFAULT NULL,
  PRIMARY KEY (`Steuerschluessel_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `StrukturSKR03` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Zeile` int DEFAULT NULL,
  `Bezeichung` varchar(50) DEFAULT NULL,
  `Folge` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Thema` (
  `Thema_Id` int NOT NULL AUTO_INCREMENT,
  `Thema_Referenznummer` varchar(45) DEFAULT NULL,
  `Thema_Themennummer` varchar(45) DEFAULT NULL,
  `Thema_Thema` varchar(45) DEFAULT NULL,
  `Thema_Produktvorschlag` varchar(45) DEFAULT NULL,
  `Thema_Projektbezeichnung` varchar(45) DEFAULT NULL,
  `Thema_ListeZeritifizierung` varchar(45) DEFAULT NULL,
  `Thema_ListeLaender` varchar(150) DEFAULT NULL,
  `Thema_VE` int DEFAULT NULL,
  `Thema_Angebotspreis` decimal(10,4) DEFAULT NULL,
  `Thema_Incoterm` varchar(45) DEFAULT NULL,
  `Thema_PrdSt_Name` varchar(45) DEFAULT NULL,
  `Thema_PrdSt_Adresse` varchar(500) DEFAULT NULL,
  `Thema_PrdSt_LidlId` varchar(45) DEFAULT NULL,
  `Thema_PrdSt_Status` varchar(45) DEFAULT NULL,
  `Thema_PrdStA_Name` varchar(45) DEFAULT NULL,
  `Thema_PrdStA_Adresse` varchar(500) DEFAULT NULL,
  `Thema_PrdStA_LidlId` varchar(45) DEFAULT NULL,
  `Thema_PrdStA_Status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Thema_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='				';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `ThemaArtikel` (
  `ThemaArtikel_Id` int NOT NULL AUTO_INCREMENT,
  `ThemaArtikel_Thema_Id` int DEFAULT NULL,
  `ThemaArtikel_Bezeichnung` varchar(150) DEFAULT NULL,
  `ThemaArtikel_Referenz` varchar(45) DEFAULT NULL,
  `ThemaArtikel_EK` decimal(10,4) DEFAULT NULL,
  `ThemaArtikel_UVP` decimal(10,4) DEFAULT NULL,
  `ThemaArtikel_Gewicht` decimal(10,4) DEFAULT NULL,
  `ThemaArtikel_Groesse` varchar(45) DEFAULT NULL,
  `ThemaArtikel_Laenge` decimal(10,4) DEFAULT NULL,
  `ThemaArtikel_Breite` decimal(10,4) DEFAULT NULL,
  `ThemaArtikel_Hoehe` decimal(10,4) DEFAULT NULL,
  `ThemaArtikel_Qualitaet` text,
  `ThemaArtikel_Gewichtung` int DEFAULT NULL,
  PRIMARY KEY (`ThemaArtikel_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Translations` (
  `Translations_Id` int NOT NULL AUTO_INCREMENT,
  `Translations_DE` text,
  `Translations_EN` text,
  `Translations_Table` varchar(100) DEFAULT NULL,
  `Translations_Column` varchar(100) DEFAULT NULL,
  `Translations_Type` varchar(10) DEFAULT NULL,
  `Translations_TableId` int DEFAULT NULL,
  `Translations_Origin` char(3) NOT NULL DEFAULT 'DE',
  PRIMARY KEY (`Translations_Id`),
  KEY `tableColumn` (`Translations_TableId`,`Translations_Table`,`Translations_Column`),
  KEY `deWert` (`Translations_DE`(150)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=158969 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `Vorlauf_Musterung` (
  `ID` varchar(150) NOT NULL,
  `Musterung` varchar(45) DEFAULT NULL,
  `BriefingLidl` varchar(45) DEFAULT NULL,
  `Lieferantenauswahl` varchar(45) DEFAULT NULL,
  `Designs` varchar(45) DEFAULT NULL,
  `Musterbestellungen` varchar(45) DEFAULT NULL,
  `AIDaten` varchar(45) DEFAULT NULL,
  `Techpack` varchar(45) DEFAULT NULL,
  `3D` varchar(45) DEFAULT NULL,
  `MusterImHaus` varchar(45) DEFAULT NULL,
  `QSProtokoll` varchar(45) DEFAULT NULL,
  `Qualitätscheck` varchar(45) DEFAULT NULL,
  `FotosEK` varchar(45) DEFAULT NULL,
  `Musterversand` varchar(45) DEFAULT NULL,
  `QSVersand` varchar(45) DEFAULT NULL,
  `FotoversandEK` varchar(45) DEFAULT NULL,
  `QSvonLidl` varchar(45) DEFAULT NULL,
  `SonstigeInfos` varchar(45) DEFAULT NULL,
  `Datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `XMLConverterMitVersion` (
  `XMLConverter_Id` bigint NOT NULL AUTO_INCREMENT,
  `XMLConverter_DBTable` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `XMLConverter_DBColumn` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `XMLConverter_XMLNode` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `XMLConverter_Version` varchar(50) NOT NULL DEFAULT '2021.01',
  `XMLConverter_ColType` varchar(45) DEFAULT NULL,
  `XMLConverter_Translate` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`XMLConverter_Id`),
  UNIQUE KEY `XMLConverter_Id_UNIQUE` (`XMLConverter_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=974 DEFAULT CHARSET=utf8mb3 COMMENT='				';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `XPPProduktpass` (
  `PPProduktpass_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_IAN` varchar(200) NOT NULL DEFAULT 'IAN_VERGEBEN',
  `PPProduktpass_Artikelbezeichnung` varchar(500) DEFAULT NULL,
  `PPProduktpass_Ausmusterung` varchar(50) NOT NULL DEFAULT ' ',
  `PPProduktpass_Ausmusterungnummer` varchar(50) NOT NULL DEFAULT ' ',
  `PPProduktpass_AltIAN` varchar(200) DEFAULT NULL,
  `PPProduktpass_AltArtikelbezeichnung` varchar(250) DEFAULT NULL,
  `PPProduktpass_Warengruppe` varchar(250) DEFAULT NULL,
  `PPProduktpass_Neu_Warengruppe` varchar(250) DEFAULT NULL,
  `PPProduktpass_Verpackungseinheit` varchar(250) DEFAULT NULL,
  `PPProduktpass_Thema` varchar(250) DEFAULT NULL,
  `PPProduktpass_Liefertermin` varchar(250) DEFAULT NULL,
  `PPProduktpass_Einkaeufer` varchar(250) DEFAULT NULL,
  `PPProduktpass_Marke` varchar(250) DEFAULT NULL,
  `PPProduktpass_Gesamtmenge` decimal(14,4) DEFAULT NULL,
  `PPProduktpass_Pruefinstitut` varchar(250) DEFAULT NULL,
  `PPProduktpass_Andere_Kriterien` varchar(250) DEFAULT NULL,
  `PPProduktpass_Zertifizierungen` varchar(250) DEFAULT NULL,
  `PPProduktpass_Logos` blob,
  `PPProduktpass_Verkaufsverpackung` blob,
  `PPProduktpass_Materialstaerke_der_Verkaufsverpackung` blob,
  `PPProduktpass_Agentur` varchar(250) DEFAULT NULL,
  `PPProduktpass_PPProjekte_Id` bigint DEFAULT NULL,
  `PPProduktpass_Material` varchar(250) DEFAULT NULL,
  `PPProduktpass_Lizenz` varchar(250) DEFAULT NULL,
  `PPProduktpass_Status` varchar(30) NOT NULL DEFAULT 'Neu',
  `PPProduktpass_PPProjekte_Projekt` varchar(100) DEFAULT NULL,
  `PPProduktpass_AktExcel` varchar(200) DEFAULT NULL,
  `PPProduktpass_VorExcel` varchar(200) DEFAULT NULL,
  `PPProduktpass_Importart` bigint DEFAULT '0',
  `PPProduktpass_LieferterminJahr` int DEFAULT '0',
  `PPProduktpass_VorIAN` varchar(100) DEFAULT NULL,
  `PPProduktpass_Konstruktion` varchar(500) DEFAULT NULL,
  `PPProduktpass_Verarbeitung` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV1_Name` varchar(100) DEFAULT 'Freifeld 1',
  `PPProduktpass_ZBV1_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV2_Name` varchar(100) DEFAULT 'Freifeld 2',
  `PPProduktpass_ZBV2_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV3_Name` varchar(100) DEFAULT 'Freifeld 3',
  `PPProduktpass_ZBV3_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV4_Name` varchar(100) DEFAULT 'Freifeld 4',
  `PPProduktpass_ZBV4_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV5_Name` varchar(100) DEFAULT 'Freifeld 5',
  `PPProduktpass_ZBV5_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_Produkt_ZusatzGSM` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_Laenge` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_Breite` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_Hoehe` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_GSM` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_WAWIArtikelnummer` varchar(100) NOT NULL DEFAULT 'Neu',
  `PPProduktpass_IsRevision` tinyint DEFAULT NULL,
  `PPProduktpass_RevisionArt` varchar(5) DEFAULT NULL,
  `PPProduktpass_Revisionsnummer` int DEFAULT '0',
  `PPProduktpass_RevisionAktuell` int DEFAULT '0',
  `PPProduktpass_RevisionVon_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPProduktpass_RevisionDatum` datetime DEFAULT NULL,
  `PPProduktpass_ProjektBild` varchar(200) DEFAULT NULL,
  `PPProduktpass_VersandfaehigeUmverpackung` varchar(20) DEFAULT NULL,
  `PPProduktpass_RFSicherung` varchar(200) DEFAULT NULL,
  `PPProduktpass_Passformlabel` varchar(200) DEFAULT NULL,
  `PPProduktpass_AndereTestkriterien` varchar(200) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften2` varchar(200) DEFAULT NULL,
  `PPProduktpass_GarantiezeitDauer` text,
  `PPProduktpass_GarentieArt` varchar(200) DEFAULT NULL,
  `PPProduktpass_LogoDruckverfahren` varchar(200) DEFAULT NULL,
  `PPProduktpass_Import_BISUser_Id` bigint DEFAULT NULL,
  `PPProduktpass_Import_Datum` datetime DEFAULT NULL,
  `PPProduktpass_Logos2` varchar(250) DEFAULT NULL,
  `PPProduktpass_Logos3` varchar(250) DEFAULT NULL,
  `PPProduktpass_Positionierung` varchar(100) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften3` varchar(200) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften4` varchar(200) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften5` varchar(200) DEFAULT NULL,
  `PPProduktpass_Logos4` varchar(250) DEFAULT NULL,
  `PPProduktpass_Logos5` varchar(250) DEFAULT NULL,
  `PPProduktpass_Bemerkung` varchar(250) DEFAULT NULL,
  `PPProduktpass_Charge` varchar(50) DEFAULT NULL,
  `PPProduktpass_AltCharge` varchar(50) CHARACTER SET big5 COLLATE big5_chinese_ci DEFAULT NULL,
  `PPProduktpass_KAT` varchar(50) DEFAULT NULL,
  `PPProduktpass_BZP` varchar(50) DEFAULT NULL,
  `PPProduktpass_MOQ` varchar(50) DEFAULT NULL,
  `PPProduktpass_InitialeCharge` varchar(50) DEFAULT NULL,
  `PPProduktpass_Erstbestellung` varchar(50) DEFAULT NULL,
  `PPProduktpass_IsInquiry` int NOT NULL DEFAULT '0',
  `PPProduktpass_InquiryArt` int DEFAULT '0',
  `PPProduktpass_StepNeeded` int DEFAULT '0',
  `PPProduktpass_BSCINeeded` int DEFAULT '0',
  `PPProduktpass_IsMusterung` int NOT NULL DEFAULT '0',
  `PPProduktpass_GreenLevel` int DEFAULT NULL,
  `PPProduktpass_KauflandMarke` varchar(250) DEFAULT NULL,
  `rfqNo` varchar(50) NOT NULL,
  `isLatest` varchar(10) NOT NULL,
  `statusDoc` varchar(50) NOT NULL,
  `updateUserName` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `vendorNo` varchar(50) NOT NULL,
  `createdOn` datetime NOT NULL,
  `updatedOn` datetime NOT NULL,
  `expiryDate` datetime NOT NULL,
  `versionDoc` varchar(50) NOT NULL,
  `angebotsnummerPraefix` varchar(50) NOT NULL,
  `createUserName` varchar(50) NOT NULL,
  `version` int NOT NULL,
  `retailPackagingComment` text NOT NULL,
  `Garantie` varchar(100) NOT NULL,
  `rfSafety` varchar(50) NOT NULL,
  `packagingKL_materialThickness` text NOT NULL,
  `packagingKL_retailPackagingComment` varchar(250) NOT NULL,
  `packagingKL_trayRemarks` varchar(250) NOT NULL,
  `packagingKL_rt_name` varchar(250) NOT NULL,
  `packagingKL_tray_name` varchar(250) NOT NULL,
  `isCatalogue` tinyint(1) NOT NULL,
  `initialOrder` varchar(50) NOT NULL,
  `brandKL` varchar(50) NOT NULL,
  `sampleNumberKL` varchar(50) NOT NULL,
  `buyerShortCodeKL` varchar(10) NOT NULL,
  `buyerNameKL` varchar(50) NOT NULL,
  `themeNoKL` varchar(50) NOT NULL,
  `noLIDLItem` varchar(10) NOT NULL,
  `Abwicklungsart` varchar(50) NOT NULL,
  `InternerStatus` varchar(20) NOT NULL,
  `LinkedItemIAN` varchar(100) NOT NULL,
  `PPProduktpass_PMAdmin` int DEFAULT NULL,
  `PPProduktpass_TCAdmin` int DEFAULT NULL,
  `PPProduktpass_IsParent` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_IsChild` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_IsKaufland` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_TargaTNr` varchar(15) DEFAULT NULL,
  `Garantie_Art` varchar(255) DEFAULT NULL,
  `Garantie_typ` varchar(255) DEFAULT NULL,
  `PPProduktpass_Kommentar` text,
  `PPProduktpass_AdminRemark` text,
  `PPProduktpass_DelDatePlan` varchar(45) DEFAULT NULL,
  `packagingKL_trayType` text NOT NULL,
  `packagingKL_trayFacingLayer` text NOT NULL,
  `packagingKL_trayColor` text NOT NULL,
  `packagingKL_trayMaxCartonLength` text NOT NULL,
  `packagingKL_trayMaxCartonWidth` text NOT NULL,
  `packagingKL_trayMaxCartonHeight` text NOT NULL,
  `itemTypeKL` varchar(15) DEFAULT NULL,
  `ekNote` varchar(150) DEFAULT NULL,
  `catalogue_contractRenewalConfirmation` varchar(30) DEFAULT NULL,
  `catalogue_initialCharge` char(4) DEFAULT NULL,
  `catalogue_isCatalogue` char(10) DEFAULT NULL,
  `catalogue_lotNumber` char(4) DEFAULT NULL,
  `catalogue_minOrderQuantity` varchar(10) DEFAULT NULL,
  `catalogue_initialOrder` char(10) DEFAULT NULL,
  `catalogue_timeOfOrder1` char(2) DEFAULT NULL,
  `catalogue_timeOfOrder2` char(2) DEFAULT NULL,
  `catalogue_timeOfOrder3` char(2) DEFAULT NULL,
  `catalogue_timeOfOrder4` char(2) DEFAULT NULL,
  `PPProduktpass_TCAdminVTR` int DEFAULT NULL,
  `PPProduktpass_PMAdminVTR` int DEFAULT NULL,
  `PPProduktpass_IsUSA` int NOT NULL DEFAULT '0',
  `PPProduktpass_CRDJahr` int NOT NULL DEFAULT '0',
  `PPProduktpass_CRDWoche` int NOT NULL DEFAULT '0',
  `PPProduktpass_deadlineMustereingang` varchar(45) DEFAULT NULL,
  `PPProduktpass_trackNoMuster` varchar(45) DEFAULT NULL,
  `PPProduktpass_musterKLHHZ` varchar(45) DEFAULT NULL,
  `PPProduktpass_ZertifizierungenBemerkungen` varchar(45) DEFAULT NULL,
  `PPProduktpass_ZertifizierungenRestlaufzeit` varchar(45) DEFAULT NULL,
  `LFGB` varchar(10) DEFAULT NULL,
  `resultsFromPredecessor` varchar(10) DEFAULT NULL,
  `referenceCheck` varchar(10) DEFAULT NULL,
  `ngoTest` varchar(10) DEFAULT NULL,
  `lithiumIonBatteryAbove10Wh` varchar(10) DEFAULT NULL,
  `medProduct` varchar(10) DEFAULT NULL,
  `ppe` varchar(10) DEFAULT NULL,
  `sampleTrackingNumber` varchar(45) DEFAULT NULL,
  `ngoTestNote` varchar(300) DEFAULT NULL,
  `childSuitable` varchar(150) DEFAULT NULL,
  `sampleDeadlineKL` varchar(85) DEFAULT NULL,
  `PPProduktpass_ArtikelTarga` varchar(500) DEFAULT NULL,
  `PPProduktpass_Transferd2Sharepoint` tinyint DEFAULT NULL,
  `PPProduktpass_ZertifizierungenTXT` varchar(200) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT2` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT3` varchar(200) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT4` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT5` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `remarkSupplier` varchar(200) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `themeNo` varchar(200) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_earliestDDCountry1` varchar(5) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_earliestDDCountry2` varchar(5) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_earliestDDCountry3` varchar(5) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_LCL` varchar(10) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_legalSpareparts` varchar(10) CHARACTER SET keybcs2 COLLATE keybcs2_general_ci DEFAULT NULL,
  `PPProduktpass_incoterm` varchar(100) CHARACTER SET koi8u COLLATE koi8u_general_ci DEFAULT NULL,
  `PPProduktpass_shelfLife` varchar(45) CHARACTER SET koi8u COLLATE koi8u_general_ci DEFAULT NULL,
  `PPProduktpass_weeeCategory` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPProduktpass_SimNeu` tinyint NOT NULL DEFAULT '1',
  `PPProduktpass_ThemaRequierdSamples` varchar(45) DEFAULT NULL,
  `PPProduktpass_ThemaKolli` varchar(45) DEFAULT NULL,
  `PPProduktpass_ThemaAssortment` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaWarranty` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaRisc` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaCerificates` varchar(250) DEFAULT NULL,
  `PPProduktpass_ThemaScope` varchar(100) DEFAULT NULL,
  `PPProduktpass_linkedItemIan` varchar(10) DEFAULT NULL,
  `PPProduktpass_linkedItemLotNo` varchar(10) DEFAULT NULL,
  `PPProduktpass_continentType` varchar(10) DEFAULT NULL,
  `PPProduktpass_Zolltarif` varchar(100) DEFAULT NULL,
  `PPProduktpass_Zollsatz` varchar(100) DEFAULT NULL,
  `PPProduktpass_IsCriticalProject` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_PJMAdmin` int DEFAULT NULL,
  `PPProduktpass_PJMAdminVTR` int DEFAULT NULL,
  `PPProduktpass_Absagegrund` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`PPProduktpass_Id`),
  UNIQUE KEY `PPID` (`PPProduktpass_Id`),
  UNIQUE KEY `IANAusm` (`PPProduktpass_IAN`,`PPProduktpass_Ausmusterungnummer`),
  KEY `Project` (`PPProduktpass_PPProjekte_Projekt`),
  KEY `IAN` (`PPProduktpass_IAN`),
  KEY `Aus` (`PPProduktpass_Ausmusterungnummer`) INVISIBLE ,
  KEY `AUS2` (`PPProduktpass_Ausmusterungnummer`(4)),
  KEY `InternerStatus` (`InternerStatus`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13110 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC COMMENT='		';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `adressen` (
  `Adressen_Id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Mandant` smallint NOT NULL,
  `Kategorie` smallint DEFAULT NULL,
  `Matchcode` varchar(100) NOT NULL DEFAULT 'Neue Adrsse',
  `Name1` varchar(100) DEFAULT NULL,
  `Name2` varchar(100) DEFAULT NULL,
  `PostZusatz` varchar(100) DEFAULT NULL,
  `Anrede` varchar(100) DEFAULT NULL,
  `PostStrasse` varchar(100) DEFAULT NULL,
  `PostLand` varchar(100) DEFAULT NULL,
  `PostPLZ` varchar(25) DEFAULT NULL,
  `PostOrt` varchar(100) DEFAULT NULL,
  `Telefon` varchar(50) DEFAULT NULL,
  `Telefax` varchar(50) DEFAULT NULL,
  `Mobilfunk` varchar(50) DEFAULT NULL,
  `EMail` varchar(100) DEFAULT NULL,
  `Homepage` varchar(100) DEFAULT NULL,
  `Memo` text,
  `Sprache` varchar(25) DEFAULT NULL,
  `Erstkontakt` datetime DEFAULT CURRENT_TIMESTAMP,
  `Kennzeichen` varchar(10) DEFAULT NULL,
  `Status` varchar(10) DEFAULT NULL,
  `Kundengruppen_Id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Hauptadresse_Id` int DEFAULT NULL,
  `Belegtext` text,
  `Kundennummer` varchar(50) DEFAULT '',
  `MwStSchluesselKunde` int DEFAULT NULL,
  `Lieferantennummer` varchar(50) DEFAULT '',
  `MwStSchluesselLieferant` int DEFAULT NULL,
  `Umsatzsteuer_Id` varchar(50) DEFAULT NULL,
  `Kunden_ZKD` int DEFAULT NULL,
  `Lieferanten_ZKD` int DEFAULT NULL,
  PRIMARY KEY (`Adressen_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `artikelstamm` (
  `artikelstamm_id` int unsigned NOT NULL AUTO_INCREMENT,
  `artikelnummer` varchar(50) DEFAULT NULL,
  `Matchcode` varchar(250) NOT NULL DEFAULT 'Neuer Artikel',
  `Bezeichnung1` varchar(500) DEFAULT NULL,
  `Bezeichnung2` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `IstAktiv` tinyint(1) NOT NULL DEFAULT '1',
  `MengeneinheitVK` varchar(10) NOT NULL DEFAULT 'Stk',
  `MengeneinheitEK` varchar(10) NOT NULL DEFAULT 'Stk',
  `MengeneinheitLager` varchar(10) NOT NULL DEFAULT 'Stk',
  `Langtext` blob,
  `Hauptgruppe` varchar(25) DEFAULT NULL,
  `Untergruppe` int DEFAULT NULL,
  `MengeneinheitBasis` varchar(10) NOT NULL DEFAULT 'Stk',
  `EKMeenthaeltBMe` decimal(10,2) DEFAULT NULL,
  `VKMeenthaeltBMe` decimal(10,2) DEFAULT NULL,
  `LMeenthaeltBMe` decimal(10,2) DEFAULT NULL,
  `PreisEinstand` decimal(18,4) DEFAULT NULL,
  `PreisEKStandard` decimal(18,4) DEFAULT NULL,
  `PreisDurchschnittEK` decimal(18,4) DEFAULT NULL,
  `PreisLEK` decimal(18,4) DEFAULT NULL,
  `IstBestandsgefuehrt` tinyint(1) DEFAULT NULL,
  `IstChargengefuehrt` tinyint(1) DEFAULT NULL,
  `PreisVK` decimal(18,4) DEFAULT NULL,
  `PreisVKAlt` decimal(18,4) DEFAULT NULL,
  `BerechnungDB` int DEFAULT NULL,
  `IstProvisionsfaehig` tinyint(1) DEFAULT NULL,
  `IstBonusfaehig` tinyint(1) DEFAULT NULL,
  `ErloesKonto` tinyint(1) DEFAULT NULL,
  `Steuercode` tinyint(1) DEFAULT NULL,
  `Kostenstelle` tinyint(1) DEFAULT NULL,
  `Kostentraeger` tinyint(1) DEFAULT NULL,
  `MasseBMeLaenge` decimal(10,2) DEFAULT NULL,
  `MasseBMeBreite` decimal(10,2) DEFAULT NULL,
  `MasseBMeHoehe` decimal(10,2) DEFAULT NULL,
  `MasseEkMeLaenge` decimal(10,2) DEFAULT NULL,
  `MasseEkMeBreite` decimal(10,2) DEFAULT NULL,
  `MasseEkMeHoehe` decimal(10,2) DEFAULT NULL,
  `MasseVkMeLaenge` decimal(10,2) DEFAULT NULL,
  `MasseVkMeBreite` decimal(10,2) DEFAULT NULL,
  `MasseVkMeHoehe` decimal(10,2) DEFAULT NULL,
  `MasseLMeLaenge` decimal(10,2) DEFAULT NULL,
  `MasseLMeBreite` decimal(10,2) DEFAULT NULL,
  `MasseLMeHoehe` decimal(10,2) DEFAULT NULL,
  `Warennummer` varchar(50) DEFAULT NULL,
  `Warenbezeichnung` varchar(50) DEFAULT NULL,
  `BesondereMasseinheit` varchar(50) DEFAULT NULL,
  `Umrechnungsfaktor` decimal(10,2) DEFAULT NULL,
  `EigenmasseIn` varchar(50) DEFAULT NULL,
  `Eigenmassefaktor` decimal(10,2) DEFAULT NULL,
  `Ursprungsland` varchar(50) DEFAULT NULL,
  `Steuerschluessel` varchar(50) DEFAULT NULL,
  `ZollTarif` varchar(50) DEFAULT NULL,
  `ZollProzent` decimal(10,2) DEFAULT NULL,
  `ZollImport` varchar(50) DEFAULT NULL,
  `ZollLand` varchar(50) DEFAULT NULL,
  `Warenzusammensetzung` varchar(50) DEFAULT NULL,
  `ABCKlasse` tinyint(1) DEFAULT NULL,
  `Qual_Qualitaet` varchar(50) DEFAULT NULL,
  `Qual_Material1` varchar(50) DEFAULT NULL,
  `Qual_Material2` varchar(50) DEFAULT NULL,
  `Qual_Farbe` varchar(50) DEFAULT NULL,
  `Qual_Groesse` varchar(50) DEFAULT NULL,
  `Qual_Design` varchar(50) DEFAULT NULL,
  `Qual_gsm` varchar(50) DEFAULT NULL,
  `KnzLizenz` varchar(50) DEFAULT NULL,
  `EAN_Code` varchar(50) DEFAULT NULL,
  `Statistiknummer` varchar(50) DEFAULT NULL,
  `MasseBMeGewichtBrutto` decimal(10,2) DEFAULT NULL,
  `MasseEkMeGewichtBrutto` decimal(10,2) DEFAULT NULL,
  `MasseVkMeGewichtBrutto` decimal(10,2) DEFAULT NULL,
  `MasseLMeGewichtBrutto` decimal(10,2) DEFAULT NULL,
  `MasseBMeGewichtNetto` decimal(10,2) DEFAULT NULL,
  `MasseEkMeGewichtNetto` decimal(10,2) DEFAULT NULL,
  `MasseVkMeGewichtNetto` decimal(10,2) DEFAULT NULL,
  `MasseLMeGewichtNetto` decimal(10,2) DEFAULT NULL,
  `Zollnummer` varchar(50) DEFAULT NULL,
  `TextUebernahme` text,
  `PreisLEK_Wsym` varchar(3) DEFAULT NULL,
  `PreisSK` decimal(18,4) DEFAULT NULL,
  `Qual_Ausstattung` varchar(50) DEFAULT NULL,
  `Qual_Verpackung` varchar(50) DEFAULT NULL,
  `Qual_VE` varchar(50) DEFAULT NULL,
  `LangtextSave` blob,
  `LagerartikelArt` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`artikelstamm_id`),
  KEY `artikelnummer` (`artikelnummer`)
) ENGINE=InnoDB AUTO_INCREMENT=52517 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `artikeltexte` (
  `Id` bigint NOT NULL AUTO_INCREMENT,
  `Artikelnummer` varchar(50) DEFAULT NULL,
  `Bezeichnung` varchar(50) DEFAULT NULL,
  `Text` text,
  `Position` int DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `TextType` text,
  `istUebernommen` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `artikelnummer` (`Artikelnummer`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2555 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `belegarten` (
  `Belegarten_Id` int NOT NULL,
  `Belegart` varchar(50) NOT NULL,
  `Art` varchar(50) NOT NULL DEFAULT 'VK',
  `Lagerwirkung` int DEFAULT '0',
  `Lagerbewegung` char(2) DEFAULT NULL,
  `Nummernkreise_Id` int NOT NULL DEFAULT '1',
  `IstrBuchhaltungsbeleg` int DEFAULT '1',
  `S_H` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`Belegarten_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='			';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `belege` (
  `Belege_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Mandant` smallint NOT NULL DEFAULT '1',
  `Belegart` varchar(50) NOT NULL DEFAULT 'Auftrag',
  `Belegjahr` smallint DEFAULT NULL,
  `Belegnummer` int DEFAULT NULL,
  `Matchcode` varchar(50) DEFAULT NULL,
  `Periode` int DEFAULT NULL,
  `Belegstatus` smallint DEFAULT NULL,
  `BelegAdresse_Adresse_Id` int DEFAULT NULL,
  `Konten_Id` int DEFAULT NULL,
  `BelegAdresse_Anrede` varchar(100) DEFAULT NULL,
  `BelegAdresse_Name1` varchar(100) DEFAULT NULL,
  `BelegAdresse_Name2` varchar(100) DEFAULT NULL,
  `BelegAdresse_Zusatz` varchar(100) DEFAULT NULL,
  `BelegAdresse_Ansprechpartner_Id` int DEFAULT NULL,
  `BelegAdresse_Matchcode` varchar(100) DEFAULT NULL,
  `BelegAdresse_Strasse` varchar(100) DEFAULT NULL,
  `BelegAdresse_Land` varchar(100) DEFAULT NULL,
  `BelegAdresse_PLZ` varchar(100) DEFAULT NULL,
  `BelegAdresse_Ort` varchar(100) DEFAULT NULL,
  `Lieferadresse_Adress_Id` int DEFAULT NULL,
  `Lieferadresse_Anrede` varchar(100) DEFAULT NULL,
  `Lieferadresse_Name1` varchar(100) DEFAULT NULL,
  `Lieferadresse_Name2` varchar(100) DEFAULT NULL,
  `Lieferadresse_Zusatz` varchar(100) DEFAULT NULL,
  `Lieferadresse_Ansprechpartner_Id` int DEFAULT NULL,
  `Lieferadresse_Strasse` varchar(100) DEFAULT NULL,
  `Lieferadresse_Land` varchar(100) DEFAULT NULL,
  `Lieferadresse_PLZ` varchar(100) DEFAULT NULL,
  `Lieferadresse_Ort` varchar(100) DEFAULT NULL,
  `Kundengruppe` varchar(10) DEFAULT NULL,
  `Rechnungsempfaenger` varchar(20) DEFAULT NULL,
  `Rechnung_Ansprechpartner_Id` int DEFAULT NULL,
  `Lieferwoche` int DEFAULT NULL,
  `Liefertermin` date DEFAULT NULL,
  `Wsym` varchar(3) DEFAULT NULL,
  `KursFw` double(8,2) DEFAULT NULL,
  `Belegdatum` date DEFAULT NULL,
  `Bearbeiter` varchar(150) DEFAULT NULL,
  `Rabatt1` varchar(10) DEFAULT NULL,
  `Rabattbetrag1` decimal(8,2) DEFAULT NULL,
  `Rabattbasis1` decimal(8,2) DEFAULT NULL,
  `RabattAbsolut1` decimal(8,2) DEFAULT NULL,
  `Rabatttext1` smallint DEFAULT NULL,
  `Rabatt2` varchar(40) DEFAULT NULL,
  `Rabattbetrag2` decimal(8,2) DEFAULT NULL,
  `Rabattbasis2` decimal(8,2) DEFAULT NULL,
  `RabattAbsolut2` decimal(8,2) DEFAULT NULL,
  `Rabatttext2` smallint DEFAULT NULL,
  `Rabatt3` varchar(40) DEFAULT NULL,
  `Rabattbetrag3` decimal(8,2) DEFAULT NULL,
  `Rabattbasis3` decimal(8,2) DEFAULT NULL,
  `RabattAbsolut3` decimal(8,2) DEFAULT NULL,
  `Rabatttext3` smallint DEFAULT NULL,
  `Kopftext` text,
  `Fusstext` text,
  `Vertreter` text,
  `Provisionsfaehig` varchar(10) DEFAULT NULL,
  `Provision` smallint DEFAULT NULL,
  `Provisionssatz` decimal(8,2) DEFAULT NULL,
  `Kostenstelle` decimal(8,2) DEFAULT NULL,
  `Kostentraeger` smallint DEFAULT NULL,
  `Rechnungskreis` varchar(10) DEFAULT NULL,
  `Sprache` varchar(20) DEFAULT NULL,
  `Erloescode` varchar(10) DEFAULT NULL,
  `Auswertungskennzeichen` varchar(10) DEFAULT NULL,
  `Vorgaenger_Belege_Id` smallint DEFAULT NULL,
  `Status` text,
  `StatusBearbeiter` int DEFAULT NULL,
  `StatusDatum` datetime DEFAULT NULL,
  `Lieferbedingung` varchar(50) DEFAULT NULL,
  `Verkehrszweig` smallint DEFAULT NULL,
  `Geschaeftsart` smallint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `PKto` varchar(50) NOT NULL DEFAULT '',
  `Projekt` varchar(50) DEFAULT '',
  `IhreBelegnummer` varchar(50) DEFAULT NULL,
  `IhrBelegdatum` varchar(50) DEFAULT NULL,
  `IhrMitarbeiter` varchar(50) DEFAULT NULL,
  `Versandart` varchar(50) DEFAULT NULL,
  `LieferbedingungOrt` varchar(50) DEFAULT NULL,
  `Zahlungskonditionen` varchar(50) DEFAULT NULL,
  `Valuta` date DEFAULT NULL,
  `Steuercode` int NOT NULL DEFAULT '1',
  `BelegtextKunde` text,
  `IstLagerauftrag` int DEFAULT NULL,
  `BelegTyp` varchar(2) DEFAULT 'VK' COMMENT 'Ek und VK',
  `Kontonummer` varchar(50) DEFAULT NULL,
  `Zahlungsart` varchar(50) DEFAULT NULL,
  `IstAktiv` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`Belege_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3150 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `belegepositionen` (
  `belegepositionen_id` int unsigned NOT NULL AUTO_INCREMENT,
  `Belege_id` int NOT NULL,
  `posnummer` int NOT NULL,
  `artikelstamm_id` int NOT NULL,
  `artikelnummer` varchar(25) DEFAULT NULL,
  `Bezeichnung1` varchar(500) DEFAULT NULL,
  `Bezeichnung2` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Preis` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `menge` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `MengeneinheitVK` varchar(10) DEFAULT NULL,
  `MengeneinheitEK` varchar(10) DEFAULT NULL,
  `MengeneinheitLager` varchar(10) DEFAULT NULL,
  `rabatt1betrag` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rabatt2betrag` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rabatt1` decimal(10,2) NOT NULL DEFAULT '0.00',
  `rabatt2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `mek` decimal(10,2) NOT NULL DEFAULT '0.00',
  `gewicht` decimal(10,2) NOT NULL DEFAULT '0.00',
  `steuercode` int NOT NULL DEFAULT '1',
  `kostentraeger` int DEFAULT '0',
  `kostenstelle` int DEFAULT '0',
  `warengruppe` int NOT NULL DEFAULT '0',
  `langtext` text,
  `IstAktiv` int NOT NULL DEFAULT '1',
  `pagebreak_after` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`belegepositionen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6332 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `belegnummern` (
  `belegnummern_Id` int NOT NULL AUTO_INCREMENT,
  `Jahr` int NOT NULL,
  `Belegart` int NOT NULL,
  `LastBelegnummer` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `Belegnummernkreise_Id` int DEFAULT NULL,
  PRIMARY KEY (`belegnummern_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `cpcincoterms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Incoterm` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `job_progress` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_key` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `current_step` int NOT NULL DEFAULT '0',
  `total_steps` int NOT NULL DEFAULT '0',
  `message` text,
  `percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_key` (`job_key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved` int unsigned DEFAULT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`),
  KEY `jobs_reserved_index` (`reserved`),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `konten` (
  `Konten_Id` int NOT NULL AUTO_INCREMENT,
  `Kontonummer` varchar(50) DEFAULT NULL,
  `Kontoart` varchar(50) DEFAULT NULL,
  `Adresse_Id` int NOT NULL,
  `Matchcode` varchar(100) DEFAULT NULL,
  `MWSTSchluessel` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Konten_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `kundenartikeldaten` (
  `id` int NOT NULL AUTO_INCREMENT,
  `artikelstamm_id` int NOT NULL,
  `KdArtikelnummer` varchar(50) DEFAULT NULL,
  `KdArtikelBez1` text,
  `KdArtikelBez2` text,
  `Adressen_Id` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=469 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `lagerbewegungen` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Bewegungsart` char(2) NOT NULL DEFAULT 'NN',
  `artikel_id` int NOT NULL,
  `belPos_id` int DEFAULT NULL,
  `Menge` decimal(10,2) NOT NULL,
  `Bewegungsdatum` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Bewegungsgrund` varchar(50) DEFAULT NULL,
  `Preis` decimal(10,4) DEFAULT NULL,
  `IstAktiv` smallint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6343 DEFAULT CHARSET=utf8mb3 COMMENT='		';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `login_attempt` (
  `login_attempt_Id` bigint NOT NULL AUTO_INCREMENT,
  `login_attempt_user` varchar(45) DEFAULT NULL,
  `login_attempt_count` int DEFAULT NULL,
  `login_attempt_last` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`login_attempt_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`token`),
  KEY `password_resets_email_index` (`email`),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `protokoll` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(100) NOT NULL,
  `field` varchar(100) NOT NULL,
  `oldVal` blob,
  `newVal` blob,
  `change_at` datetime NOT NULL,
  `user_id` int NOT NULL,
  `row_id` int NOT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28249 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `retailPackaging` (
  `retailPackaging_Id` int NOT NULL AUTO_INCREMENT,
  `retailPackaging_PPProduktpass_Id` int NOT NULL,
  `retailPackaging_Art` varchar(5) NOT NULL DEFAULT 'LIDL' COMMENT 'LIDL / Kaufland = KL',
  `retailPackaging_styleNo` varchar(45) NOT NULL,
  `retailPackaging_productName` varchar(45) DEFAULT NULL,
  `retailPackaging_height` varchar(45) DEFAULT NULL,
  `retailPackaging_width` varchar(45) DEFAULT NULL,
  `retailPackaging_length` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`retailPackaging_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13762 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `tPPProduktpass` (
  `PPProduktpass_Id` bigint NOT NULL AUTO_INCREMENT,
  `PPProduktpass_IAN` varchar(200) NOT NULL DEFAULT 'IAN_VERGEBEN',
  `PPProduktpass_Artikelbezeichnung` varchar(500) DEFAULT NULL,
  `PPProduktpass_Ausmusterung` varchar(50) NOT NULL DEFAULT ' ',
  `PPProduktpass_Ausmusterungnummer` varchar(50) NOT NULL DEFAULT ' ',
  `PPProduktpass_AltIAN` varchar(200) DEFAULT NULL,
  `PPProduktpass_AltArtikelbezeichnung` varchar(250) DEFAULT NULL,
  `PPProduktpass_Warengruppe` varchar(250) DEFAULT NULL,
  `PPProduktpass_Neu_Warengruppe` varchar(250) DEFAULT NULL,
  `PPProduktpass_Verpackungseinheit` varchar(250) DEFAULT NULL,
  `PPProduktpass_Thema` varchar(250) DEFAULT NULL,
  `PPProduktpass_Liefertermin` varchar(250) DEFAULT NULL,
  `PPProduktpass_Einkaeufer` varchar(250) DEFAULT NULL,
  `PPProduktpass_Marke` varchar(250) DEFAULT NULL,
  `PPProduktpass_Gesamtmenge` decimal(14,4) DEFAULT NULL,
  `PPProduktpass_Pruefinstitut` varchar(250) DEFAULT NULL,
  `PPProduktpass_Andere_Kriterien` varchar(250) DEFAULT NULL,
  `PPProduktpass_Zertifizierungen` varchar(250) DEFAULT NULL,
  `PPProduktpass_Logos` blob,
  `PPProduktpass_Verkaufsverpackung` blob,
  `PPProduktpass_Materialstaerke_der_Verkaufsverpackung` blob,
  `PPProduktpass_Agentur` varchar(250) DEFAULT NULL,
  `PPProduktpass_PPProjekte_Id` bigint DEFAULT NULL,
  `PPProduktpass_Material` varchar(250) DEFAULT NULL,
  `PPProduktpass_Lizenz` varchar(250) DEFAULT NULL,
  `PPProduktpass_Status` varchar(30) NOT NULL DEFAULT 'Neu',
  `PPProduktpass_PPProjekte_Projekt` varchar(100) DEFAULT NULL,
  `PPProduktpass_AktExcel` varchar(200) DEFAULT NULL,
  `PPProduktpass_VorExcel` varchar(200) DEFAULT NULL,
  `PPProduktpass_Importart` bigint DEFAULT '0',
  `PPProduktpass_LieferterminJahr` int DEFAULT '0',
  `PPProduktpass_VorIAN` varchar(100) DEFAULT NULL,
  `PPProduktpass_Konstruktion` varchar(500) DEFAULT NULL,
  `PPProduktpass_Verarbeitung` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV1_Name` varchar(100) DEFAULT 'Freifeld 1',
  `PPProduktpass_ZBV1_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV2_Name` varchar(100) DEFAULT 'Freifeld 2',
  `PPProduktpass_ZBV2_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV3_Name` varchar(100) DEFAULT 'Freifeld 3',
  `PPProduktpass_ZBV3_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV4_Name` varchar(100) DEFAULT 'Freifeld 4',
  `PPProduktpass_ZBV4_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_ZBV5_Name` varchar(100) DEFAULT 'Freifeld 5',
  `PPProduktpass_ZBV5_Wert` varchar(500) DEFAULT NULL,
  `PPProduktpass_Produkt_ZusatzGSM` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_Laenge` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_Breite` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_Hoehe` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_Produkt_GSM` decimal(10,4) DEFAULT NULL,
  `PPProduktpass_WAWIArtikelnummer` varchar(100) NOT NULL DEFAULT 'Neu',
  `PPProduktpass_IsRevision` tinyint DEFAULT NULL,
  `PPProduktpass_RevisionArt` varchar(5) DEFAULT NULL,
  `PPProduktpass_Revisionsnummer` int DEFAULT '0',
  `PPProduktpass_RevisionAktuell` int DEFAULT '0',
  `PPProduktpass_RevisionVon_PPProduktpass_Id` bigint DEFAULT NULL,
  `PPProduktpass_RevisionDatum` datetime DEFAULT NULL,
  `PPProduktpass_ProjektBild` varchar(200) DEFAULT NULL,
  `PPProduktpass_VersandfaehigeUmverpackung` varchar(20) DEFAULT NULL,
  `PPProduktpass_RFSicherung` varchar(200) DEFAULT NULL,
  `PPProduktpass_Passformlabel` varchar(200) DEFAULT NULL,
  `PPProduktpass_AndereTestkriterien` varchar(200) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften2` varchar(200) DEFAULT NULL,
  `PPProduktpass_GarantiezeitDauer` text,
  `PPProduktpass_GarentieArt` varchar(200) DEFAULT NULL,
  `PPProduktpass_LogoDruckverfahren` varchar(200) DEFAULT NULL,
  `PPProduktpass_Import_BISUser_Id` bigint DEFAULT NULL,
  `PPProduktpass_Import_Datum` datetime DEFAULT NULL,
  `PPProduktpass_Logos2` varchar(250) DEFAULT NULL,
  `PPProduktpass_Logos3` varchar(250) DEFAULT NULL,
  `PPProduktpass_Positionierung` varchar(100) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften3` varchar(200) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften4` varchar(200) DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaften5` varchar(200) DEFAULT NULL,
  `PPProduktpass_Logos4` varchar(250) DEFAULT NULL,
  `PPProduktpass_Logos5` varchar(250) DEFAULT NULL,
  `PPProduktpass_Bemerkung` varchar(250) DEFAULT NULL,
  `PPProduktpass_Charge` varchar(50) DEFAULT NULL,
  `PPProduktpass_AltCharge` varchar(50) CHARACTER SET big5 COLLATE big5_chinese_ci DEFAULT NULL,
  `PPProduktpass_KAT` varchar(50) DEFAULT NULL,
  `PPProduktpass_BZP` varchar(50) DEFAULT NULL,
  `PPProduktpass_MOQ` varchar(50) DEFAULT NULL,
  `PPProduktpass_InitialeCharge` varchar(50) DEFAULT NULL,
  `PPProduktpass_Erstbestellung` varchar(50) DEFAULT NULL,
  `PPProduktpass_IsInquiry` int NOT NULL DEFAULT '0',
  `PPProduktpass_InquiryArt` int DEFAULT '0',
  `PPProduktpass_StepNeeded` int DEFAULT '0',
  `PPProduktpass_BSCINeeded` int DEFAULT '0',
  `PPProduktpass_IsMusterung` int NOT NULL DEFAULT '0',
  `PPProduktpass_GreenLevel` int DEFAULT NULL,
  `PPProduktpass_KauflandMarke` varchar(250) DEFAULT NULL,
  `rfqNo` varchar(50) NOT NULL,
  `isLatest` varchar(10) NOT NULL,
  `statusDoc` varchar(50) NOT NULL,
  `updateUserName` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `vendorNo` varchar(50) NOT NULL,
  `createdOn` datetime NOT NULL,
  `updatedOn` datetime NOT NULL,
  `expiryDate` datetime NOT NULL,
  `versionDoc` varchar(50) NOT NULL,
  `angebotsnummerPraefix` varchar(50) NOT NULL,
  `createUserName` varchar(50) NOT NULL,
  `version` int NOT NULL,
  `retailPackagingComment` text NOT NULL,
  `Garantie` varchar(100) NOT NULL,
  `rfSafety` varchar(50) NOT NULL,
  `packagingKL_materialThickness` text NOT NULL,
  `packagingKL_retailPackagingComment` varchar(250) NOT NULL,
  `packagingKL_trayRemarks` varchar(250) NOT NULL,
  `packagingKL_rt_name` varchar(250) NOT NULL,
  `packagingKL_tray_name` varchar(250) NOT NULL,
  `isCatalogue` tinyint(1) NOT NULL,
  `initialOrder` varchar(50) NOT NULL,
  `brandKL` varchar(50) NOT NULL,
  `sampleNumberKL` varchar(50) NOT NULL,
  `buyerShortCodeKL` varchar(10) NOT NULL,
  `buyerNameKL` varchar(50) NOT NULL,
  `themeNoKL` varchar(50) NOT NULL,
  `noLIDLItem` varchar(10) NOT NULL,
  `Abwicklungsart` varchar(50) NOT NULL,
  `InternerStatus` varchar(20) NOT NULL,
  `LinkedItemIAN` varchar(100) NOT NULL,
  `PPProduktpass_PMAdmin` int DEFAULT NULL,
  `PPProduktpass_TCAdmin` int DEFAULT NULL,
  `PPProduktpass_IsParent` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_IsChild` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_IsKaufland` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_TargaTNr` varchar(15) DEFAULT NULL,
  `Garantie_Art` varchar(255) DEFAULT NULL,
  `Garantie_typ` varchar(255) DEFAULT NULL,
  `PPProduktpass_Kommentar` text,
  `PPProduktpass_AdminRemark` text,
  `PPProduktpass_DelDatePlan` varchar(45) DEFAULT NULL,
  `packagingKL_trayType` text NOT NULL,
  `packagingKL_trayFacingLayer` text NOT NULL,
  `packagingKL_trayColor` text NOT NULL,
  `packagingKL_trayMaxCartonLength` text NOT NULL,
  `packagingKL_trayMaxCartonWidth` text NOT NULL,
  `packagingKL_trayMaxCartonHeight` text NOT NULL,
  `itemTypeKL` varchar(15) DEFAULT NULL,
  `ekNote` varchar(150) DEFAULT NULL,
  `catalogue_contractRenewalConfirmation` varchar(30) DEFAULT NULL,
  `catalogue_initialCharge` char(4) DEFAULT NULL,
  `catalogue_isCatalogue` char(10) DEFAULT NULL,
  `catalogue_lotNumber` char(4) DEFAULT NULL,
  `catalogue_minOrderQuantity` varchar(10) DEFAULT NULL,
  `catalogue_initialOrder` char(10) DEFAULT NULL,
  `catalogue_timeOfOrder1` char(2) DEFAULT NULL,
  `catalogue_timeOfOrder2` char(2) DEFAULT NULL,
  `catalogue_timeOfOrder3` char(2) DEFAULT NULL,
  `catalogue_timeOfOrder4` char(2) DEFAULT NULL,
  `PPProduktpass_TCAdminVTR` int DEFAULT NULL,
  `PPProduktpass_PMAdminVTR` int DEFAULT NULL,
  `PPProduktpass_IsUSA` int NOT NULL DEFAULT '0',
  `PPProduktpass_CRDJahr` int NOT NULL DEFAULT '0',
  `PPProduktpass_CRDWoche` int NOT NULL DEFAULT '0',
  `PPProduktpass_deadlineMustereingang` varchar(45) DEFAULT NULL,
  `PPProduktpass_trackNoMuster` varchar(45) DEFAULT NULL,
  `PPProduktpass_musterKLHHZ` varchar(45) DEFAULT NULL,
  `PPProduktpass_ZertifizierungenBemerkungen` varchar(45) DEFAULT NULL,
  `PPProduktpass_ZertifizierungenRestlaufzeit` varchar(45) DEFAULT NULL,
  `LFGB` varchar(10) DEFAULT NULL,
  `resultsFromPredecessor` varchar(10) DEFAULT NULL,
  `referenceCheck` varchar(10) DEFAULT NULL,
  `ngoTest` varchar(10) DEFAULT NULL,
  `lithiumIonBatteryAbove10Wh` varchar(10) DEFAULT NULL,
  `medProduct` varchar(10) DEFAULT NULL,
  `ppe` varchar(10) DEFAULT NULL,
  `sampleTrackingNumber` varchar(45) DEFAULT NULL,
  `ngoTestNote` varchar(300) DEFAULT NULL,
  `childSuitable` varchar(150) DEFAULT NULL,
  `sampleDeadlineKL` varchar(85) DEFAULT NULL,
  `PPProduktpass_ArtikelTarga` varchar(500) DEFAULT NULL,
  `PPProduktpass_Transferd2Sharepoint` tinyint DEFAULT NULL,
  `PPProduktpass_ZertifizierungenTXT` varchar(200) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT2` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT3` varchar(200) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT4` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `PPProduktpass_ZertifizierungEigenschaftenTXT5` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `remarkSupplier` text CHARACTER SET keybcs2 COLLATE keybcs2_general_ci,
  `themeNo` varchar(200) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_earliestDDCountry1` varchar(5) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_earliestDDCountry2` varchar(5) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_earliestDDCountry3` varchar(5) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_LCL` varchar(10) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_legalSpareparts` varchar(10) CHARACTER SET keybcs2 DEFAULT NULL,
  `PPProduktpass_incoterm` varchar(100) CHARACTER SET koi8u DEFAULT NULL,
  `PPProduktpass_shelfLife` varchar(45) CHARACTER SET koi8u DEFAULT NULL,
  `PPProduktpass_weeeCategory` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `PPProduktpass_SimNeu` tinyint NOT NULL DEFAULT '1',
  `PPProduktpass_ThemaRequierdSamples` varchar(45) DEFAULT NULL,
  `PPProduktpass_ThemaKolli` varchar(45) DEFAULT NULL,
  `PPProduktpass_ThemaAssortment` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaWarranty` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaRisc` varchar(500) DEFAULT NULL,
  `PPProduktpass_ThemaCerificates` varchar(250) DEFAULT NULL,
  `PPProduktpass_ThemaScope` varchar(100) DEFAULT NULL,
  `PPProduktpass_linkedItemIan` varchar(10) DEFAULT NULL,
  `PPProduktpass_linkedItemLotNo` varchar(10) DEFAULT NULL,
  `PPProduktpass_continentType` varchar(10) DEFAULT NULL,
  `PPProduktpass_Zolltarif` varchar(100) DEFAULT NULL,
  `PPProduktpass_Zollsatz` varchar(100) DEFAULT NULL,
  `PPProduktpass_IsCriticalProject` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_PJMAdmin` int DEFAULT NULL,
  `PPProduktpass_PJMAdminVTR` int DEFAULT NULL,
  `PPProduktpass_Absagegrund` varchar(150) DEFAULT NULL,
  `PPProduktpass_BudgetFix` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_MitarbeiterEK` int DEFAULT NULL,
  `PPProduktpass_MitarbeiterMD` int DEFAULT NULL,
  `PPProduktpass_MitarbeiterQS` int DEFAULT NULL,
  `PPProduktpass_Planmenge` int NOT NULL DEFAULT '0',
  `PPProduktpass_ARTAdmin` int DEFAULT NULL,
  `PPProduktpass_ARTAdminVTR` int DEFAULT NULL,
  `PPProduktpass_LogAdmin` int DEFAULT NULL,
  `PPProduktpass_LogAdminVTR` int DEFAULT NULL,
  `PPProduktpass_ShipmentComplete` tinyint NOT NULL DEFAULT '0',
  `PPProduktpass_ShipmentArchived` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`PPProduktpass_Id`),
  UNIQUE KEY `PPID` (`PPProduktpass_Id`),
  UNIQUE KEY `IANAusm` (`PPProduktpass_IAN`,`PPProduktpass_Ausmusterungnummer`),
  KEY `Project` (`PPProduktpass_PPProjekte_Projekt`),
  KEY `IAN` (`PPProduktpass_IAN`),
  KEY `Aus` (`PPProduktpass_Ausmusterungnummer`) INVISIBLE ,
  KEY `AUS2` (`PPProduktpass_Ausmusterungnummer`(4)),
  KEY `InternerStatus` (`InternerStatus`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17272 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC COMMENT='		';
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `test_tabelle_keine_view` (
  ` test_tabelle_keine_view_Id` int NOT NULL AUTO_INCREMENT,
  ` test_tabelle_keine_view_Name` varchar(45) DEFAULT NULL,
  ` test_tabelle_keine_view_Vorname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (` test_tabelle_keine_view_Id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `tmpPPLsv` (
  `xPPLsv_IAN` varchar(30) DEFAULT NULL,
  `xPPLsv_Ausnusterungnummer` varchar(45) DEFAULT NULL,
  `xPPLsv_Id` int NOT NULL AUTO_INCREMENT,
  `xPPLsv_PPProduktpass_Id` int DEFAULT NULL,
  `xPPLsv_code` varchar(100) DEFAULT NULL,
  `xPPLsv_name` varchar(100) DEFAULT NULL,
  `xPPLsv_countryCodes` varchar(300) DEFAULT NULL,
  `xPPLsv_countryNames` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ppid` int DEFAULT NULL,
  PRIMARY KEY (`xPPLsv_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=776 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `users` (
  `PPMitarbeiter_Id` int unsigned NOT NULL AUTO_INCREMENT,
  `PPMitarbeiter_Name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `PPMitarbeiter_Vorname` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `PPMitarbeiter_Kuerzel` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `id` int DEFAULT NULL,
  `PPMitarbeiter_Gruppe` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Abteilung` varchar(45) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`PPMitarbeiter_Id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `PPMitarbeiter_Kuerzel_UNIQUE` (`PPMitarbeiter_Kuerzel`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `usersX` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE TABLE `zkd` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(250) DEFAULT NULL,
  `Tage1` int DEFAULT NULL,
  `Prozent1` decimal(10,2) DEFAULT NULL,
  `Tage2` int DEFAULT NULL,
  `Prozent2` decimal(10,2) DEFAULT NULL,
  `TageNetto` int DEFAULT NULL,
  `Matchcode` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
TARGA_BASELINE_SQL
        ];
    }

    /** @return list<string> */
    private function placeholderViewStatements(): array
    {
        return [
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `8WMuster` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_Country`,
 1 AS `PPProduktpass_Menge_8WMuster`,
 1 AS `PPProduktpass_Menge_Quantity`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `ArtikelMitBestand` AS SELECT
 1 AS `artikelstamm_id`,
 1 AS `artikelnummer`,
 1 AS `Matchcode`,
 1 AS `Bezeichnung1`,
 1 AS `Bezeichnung2`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `IstAktiv`,
 1 AS `MengeneinheitVK`,
 1 AS `MengeneinheitEK`,
 1 AS `MengeneinheitLager`,
 1 AS `Langtext`,
 1 AS `Hauptgruppe`,
 1 AS `Untergruppe`,
 1 AS `MengeneinheitBasis`,
 1 AS `EKMeenthaeltBMe`,
 1 AS `VKMeenthaeltBMe`,
 1 AS `LMeenthaeltBMe`,
 1 AS `PreisEinstand`,
 1 AS `PreisEKStandard`,
 1 AS `PreisDurchschnittEK`,
 1 AS `PreisLEK`,
 1 AS `IstBestandsgefuehrt`,
 1 AS `IstChargengefuehrt`,
 1 AS `PreisVK`,
 1 AS `PreisVKAlt`,
 1 AS `BerechnungDB`,
 1 AS `IstProvisionsfaehig`,
 1 AS `IstBonusfaehig`,
 1 AS `ErloesKonto`,
 1 AS `Steuercode`,
 1 AS `Kostenstelle`,
 1 AS `Kostentraeger`,
 1 AS `MasseBMeLaenge`,
 1 AS `MasseBMeBreite`,
 1 AS `MasseBMeHoehe`,
 1 AS `MasseEkMeLaenge`,
 1 AS `MasseEkMeBreite`,
 1 AS `MasseEkMeHoehe`,
 1 AS `MasseVkMeLaenge`,
 1 AS `MasseVkMeBreite`,
 1 AS `MasseVkMeHoehe`,
 1 AS `MasseLMeLaenge`,
 1 AS `MasseLMeBreite`,
 1 AS `MasseLMeHoehe`,
 1 AS `Warennummer`,
 1 AS `Warenbezeichnung`,
 1 AS `BesondereMasseinheit`,
 1 AS `Umrechnungsfaktor`,
 1 AS `EigenmasseIn`,
 1 AS `Eigenmassefaktor`,
 1 AS `Ursprungsland`,
 1 AS `Steuerschluessel`,
 1 AS `ZollTarif`,
 1 AS `ZollProzent`,
 1 AS `ZollImport`,
 1 AS `ZollLand`,
 1 AS `Warenzusammensetzung`,
 1 AS `ABCKlasse`,
 1 AS `Qual_Qualitaet`,
 1 AS `Qual_Material1`,
 1 AS `Qual_Material2`,
 1 AS `Qual_Farbe`,
 1 AS `Qual_Groesse`,
 1 AS `Qual_Design`,
 1 AS `Qual_gsm`,
 1 AS `KnzLizenz`,
 1 AS `EAN_Code`,
 1 AS `Statistiknummer`,
 1 AS `MasseBMeGewichtBrutto`,
 1 AS `MasseEkMeGewichtBrutto`,
 1 AS `MasseVkMeGewichtBrutto`,
 1 AS `MasseLMeGewichtBrutto`,
 1 AS `MasseBMeGewichtNetto`,
 1 AS `MasseEkMeGewichtNetto`,
 1 AS `MasseVkMeGewichtNetto`,
 1 AS `MasseLMeGewichtNetto`,
 1 AS `Zollnummer`,
 1 AS `TextUebernahme`,
 1 AS `artikel_id`,
 1 AS `bestand`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHaWareneinsatz` AS SELECT
 1 AS `LTKunde`,
 1 AS `IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `Ausmusterung`,
 1 AS `Menge`,
 1 AS `Artikel`,
 1 AS `LiefLTJahr`,
 1 AS `LiefLTWoche`,
 1 AS `LTMenge`,
 1 AS `WSYM`,
 1 AS `TotalEKFW`,
 1 AS `EKBWFW`,
 1 AS `EKFW`,
 1 AS `EKKalk`,
 1 AS `Ausgangsfrachten`,
 1 AS `ZollProz`,
 1 AS `Fracht`,
 1 AS `Kosten`,
 1 AS `EKProvision`,
 1 AS `Pruefkosten`,
 1 AS `SonstKostenProz`,
 1 AS `KursKalk`,
 1 AS `KursGesichert`,
 1 AS `LieferantenLT`,
 1 AS `Periode`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_AusgangsfrachtRP` AS SELECT
 1 AS `IAN`,
 1 AS `Gruppe`,
 1 AS `Menge`,
 1 AS `BetragEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_Belege` AS SELECT
 1 AS `Belege_Id`,
 1 AS `Belegnummer`,
 1 AS `Belegart`,
 1 AS `Belegjahr`,
 1 AS `Belegdatum`,
 1 AS `Periode`,
 1 AS `Kundenname`,
 1 AS `Kundengruppen_Id`,
 1 AS `Kundengruppe`,
 1 AS `Lieferadresse_Adress_Id`,
 1 AS `Kundennummer`,
 1 AS `Steuercode`,
 1 AS `SteuerLand`,
 1 AS `SH`,
 1 AS `BU`,
 1 AS `Erlöskonto`,
 1 AS `Währung`,
 1 AS `Zahlungsart`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_BestandAbgang` AS SELECT
 1 AS `Belegart`,
 1 AS `Belegjahr`,
 1 AS `Belegdatum`,
 1 AS `Periode`,
 1 AS `Belegnummer`,
 1 AS `Kundengruppen_Id`,
 1 AS `Matchcode`,
 1 AS `Kundennummer`,
 1 AS `artikelnummer`,
 1 AS `Bezeichnung1`,
 1 AS `Menge`,
 1 AS `VK`,
 1 AS `Wsym`,
 1 AS `VKTotal`,
 1 AS `S_H`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_EingangsfrachtRP` AS SELECT
 1 AS `IAN`,
 1 AS `Gruppe`,
 1 AS `Menge`,
 1 AS `BetragEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_PosTotal` AS SELECT
 1 AS `Belege_Id`,
 1 AS `PosTotalNetto`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_RP` AS SELECT
 1 AS `IAN`,
 1 AS `Gruppe`,
 1 AS `Menge`,
 1 AS `BetragEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_Uebergabe` AS SELECT
 1 AS `Belege_Id`,
 1 AS `Belegjahr`,
 1 AS `Periode`,
 1 AS `Belegdatum`,
 1 AS `Steuerland`,
 1 AS `Steuercode`,
 1 AS `Steuersatz`,
 1 AS `Steuerfaktor`,
 1 AS `Datum`,
 1 AS `Kundenname`,
 1 AS `Belegnummer`,
 1 AS `NettoSumme`,
 1 AS `BruttoSumme`,
 1 AS `Kundennummer`,
 1 AS `BU`,
 1 AS `Erlöskonto`,
 1 AS `SH`,
 1 AS `Zahlungsart`,
 1 AS `Kundengruppe`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_UebergabeCSV` AS SELECT
 1 AS `Datum`,
 1 AS `Kundenname`,
 1 AS `Belege_Id`,
 1 AS `Belegnummer`,
 1 AS `BetragBrutto`,
 1 AS `Kundennummer`,
 1 AS `BU`,
 1 AS `Erloeskonto`,
 1 AS `SH`,
 1 AS `Zahlungsart`,
 1 AS `Kundengruppe`,
 1 AS `Belegdatum`,
 1 AS `Periode`,
 1 AS `Jahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `BuHa_ZollRP` AS SELECT
 1 AS `IAN`,
 1 AS `Gruppe`,
 1 AS `Menge`,
 1 AS `BetragEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `KDGR` AS SELECT
 1 AS `Kundengruppen_Id`,
 1 AS `Kundengruppen_Bezeichnung`,
 1 AS `Erlöskonto`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPBoardSpalte` AS SELECT
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Stati`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_DefaultMA`,
 1 AS `PPBoardSpalte_DFTable`,
 1 AS `PPBoardSpalte_DFField`,
 1 AS `PPBoardSpalteData_Kind`,
 1 AS `PPBoardSpalteX_Id`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalteX_PPBoardSpalte_Id`,
 1 AS `PPBoardSpalteX_Sort`,
 1 AS `PPBoard_Id`,
 1 AS `PPBoard_Bezeichnung`,
 1 AS `PPBoardSpalte_IsMilestone`,
 1 AS `PPBoardSpalteData_IsKMS`,
 1 AS `PPBoardSpalteData_KMS`,
 1 AS `PPBoardSpalte_IsUSA`,
 1 AS `PPBoardSpalteData_HilfeStatusOK`,
 1 AS `PPBoardSpalteData_HifeStatusInArbeit`,
 1 AS `PPBoardSpalteData_HilfeStatusNOK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPHerkunftslaenderPPAB` AS SELECT
 1 AS `PPAB_Id`,
 1 AS `PPAB_PPProduktpass_Id`,
 1 AS `PPHerkunftslaender_Id`,
 1 AS `PPHerkunftslaender_Land`,
 1 AS `PPAB_Produktionsstaette`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPInquiry` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `PPProduktpass_GreenLevel`,
 1 AS `PPProduktpass_KauflandMarke`,
 1 AS `rfqNo`,
 1 AS `isLatest`,
 1 AS `statusDoc`,
 1 AS `updateUserName`,
 1 AS `category`,
 1 AS `vendorNo`,
 1 AS `createdOn`,
 1 AS `updatedOn`,
 1 AS `expiryDate`,
 1 AS `versionDoc`,
 1 AS `angebotsnummerPraefix`,
 1 AS `createUserName`,
 1 AS `version`,
 1 AS `retailPackagingComment`,
 1 AS `Garantie`,
 1 AS `rfSafety`,
 1 AS `packagingKL_materialThickness`,
 1 AS `packagingKL_retailPackagingComment`,
 1 AS `packagingKL_trayRemarks`,
 1 AS `packagingKL_rt_name`,
 1 AS `packagingKL_tray_name`,
 1 AS `isCatalogue`,
 1 AS `initialOrder`,
 1 AS `brandKL`,
 1 AS `sampleNumberKL`,
 1 AS `buyerShortCodeKL`,
 1 AS `buyerNameKL`,
 1 AS `themeNoKL`,
 1 AS `noLIDLItem`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPLaenderbloecke` AS SELECT
 1 AS `PPLaenderbloecke_Id`,
 1 AS `PPLaenderbloecke_Land`,
 1 AS `PPLaenderbloecke_Block`,
 1 AS `PPLaenderbloecke_Hafen1`,
 1 AS `PPLaenderbloecke_Hafen2`,
 1 AS `PPLaenderbloecke_Sort`,
 1 AS `PPLaenderbloecke_Version`,
 1 AS `PPLaenderbloecke_IsOS`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPMusterung` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `PPProduktpass_GreenLevel`,
 1 AS `PPProduktpass_KauflandMarke`,
 1 AS `rfqNo`,
 1 AS `isLatest`,
 1 AS `statusDoc`,
 1 AS `updateUserName`,
 1 AS `category`,
 1 AS `vendorNo`,
 1 AS `createdOn`,
 1 AS `updatedOn`,
 1 AS `expiryDate`,
 1 AS `versionDoc`,
 1 AS `angebotsnummerPraefix`,
 1 AS `createUserName`,
 1 AS `version`,
 1 AS `retailPackagingComment`,
 1 AS `Garantie`,
 1 AS `rfSafety`,
 1 AS `packagingKL_materialThickness`,
 1 AS `packagingKL_retailPackagingComment`,
 1 AS `packagingKL_trayRemarks`,
 1 AS `packagingKL_rt_name`,
 1 AS `packagingKL_tray_name`,
 1 AS `isCatalogue`,
 1 AS `initialOrder`,
 1 AS `brandKL`,
 1 AS `sampleNumberKL`,
 1 AS `buyerShortCodeKL`,
 1 AS `buyerNameKL`,
 1 AS `themeNoKL`,
 1 AS `noLIDLItem`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPProduktpass` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `PPProduktpass_GreenLevel`,
 1 AS `PPProduktpass_KauflandMarke`,
 1 AS `rfqNo`,
 1 AS `isLatest`,
 1 AS `statusDoc`,
 1 AS `updateUserName`,
 1 AS `category`,
 1 AS `vendorNo`,
 1 AS `createdOn`,
 1 AS `updatedOn`,
 1 AS `expiryDate`,
 1 AS `versionDoc`,
 1 AS `angebotsnummerPraefix`,
 1 AS `createUserName`,
 1 AS `version`,
 1 AS `retailPackagingComment`,
 1 AS `Garantie`,
 1 AS `rfSafety`,
 1 AS `packagingKL_materialThickness`,
 1 AS `packagingKL_retailPackagingComment`,
 1 AS `packagingKL_trayRemarks`,
 1 AS `packagingKL_rt_name`,
 1 AS `packagingKL_tray_name`,
 1 AS `isCatalogue`,
 1 AS `initialOrder`,
 1 AS `brandKL`,
 1 AS `sampleNumberKL`,
 1 AS `buyerShortCodeKL`,
 1 AS `buyerNameKL`,
 1 AS `themeNoKL`,
 1 AS `noLIDLItem`,
 1 AS `Abwicklungsart`,
 1 AS `InternerStatus`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `PPProduktpassOrg` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_GreenLevel`,
 1 AS `PPProduktpass_KauflandMarke`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `XMLConverter` AS SELECT
 1 AS `XMLConverter_Id`,
 1 AS `XMLConverter_DBTable`,
 1 AS `XMLConverter_DBColumn`,
 1 AS `XMLConverter_XMLNode`,
 1 AS `XMLConverter_Version`,
 1 AS `XMLConverter_Translate`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `cSortierungDistinct` AS SELECT
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPProduktpass_Sortierung_Value01`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `PPProduktpass_Sortierung_Value03`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_CountryGTIN` AS SELECT
 1 AS `PPXML_Mengen_lsv`,
 1 AS `PPXML_Mengen_styleNo`,
 1 AS `PPXML_Mengen_productName`,
 1 AS `PPXML_Mengen_country`,
 1 AS `PPXML_Mengen_PPProduktpass_Id`,
 1 AS `PPXML_Mengen_sizeName`,
 1 AS `PPXML_Mengen_sizeCode`,
 1 AS `PPXML_Mengen_GTIN`,
 1 AS `PPXML_Mengen_GTINKL`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_GTINWeightsLSV` AS SELECT
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_size`,
 1 AS `PPLsv_name`,
 1 AS `PPLsv_countryNames`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_IANMengen` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_CountryBlock`,
 1 AS `PPProduktpass_Menge_Country`,
 1 AS `PPProduktpass_Menge_TotalSalePerUnit`,
 1 AS `PPProduktpass_Menge_Quantity`,
 1 AS `PPProduktpass_Menge_PackingMethod`,
 1 AS `PPProduktpass_Menge_DeliveryWeek`,
 1 AS `PPProduktpass_Menge_Id`,
 1 AS `PPProduktpass_Menge_Row`,
 1 AS `PPProduktpass_Menge_Rotterdam`,
 1 AS `PPProduktpass_Menge_Barcelona`,
 1 AS `PPProduktpass_Menge_Koper`,
 1 AS `PPProduktpass_Menge_EKUSD`,
 1 AS `PPProduktpass_Menge_VKFOBEUR`,
 1 AS `PPProduktpass_Menge_CBEK`,
 1 AS `PPProduktpass_Menge_Countrysizes`,
 1 AS `PPProduktpass_Menge_CBVK`,
 1 AS `PPProduktpass_Menge_LT1`,
 1 AS `PPProduktpass_Menge_LT1Menge`,
 1 AS `PPProduktpass_Menge_LT2`,
 1 AS `PPProduktpass_Menge_LT2Menge`,
 1 AS `PPProduktpass_Menge_LT3`,
 1 AS `PPProduktpass_Menge_LT3Menge`,
 1 AS `PPProduktpass_Menge_ArtikelInfo`,
 1 AS `PPProduktpass_Menge_Kolli`,
 1 AS `PPProduktpass_Menge_CountryGSM`,
 1 AS `PPProduktpass_Menge_FOBPriice`,
 1 AS `PPProduktpass_Menge_8WMuster`,
 1 AS `PPProduktpass_Menge_CartonSize`,
 1 AS `PPProduktpass_Menge_PcsPerCarton`,
 1 AS `PPProduktpass_Menge_CartonPerPal`,
 1 AS `PPProduktpass_Menge_Trucks`,
 1 AS `PPProduktpass_Menge_countryRemarks`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_OrderWeights` AS SELECT
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_lsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_asortment` AS SELECT
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPLsv_countryNames`,
 1 AS `PPLsv_name`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_assortment` AS SELECT
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPLsv_countryNames`,
 1 AS `PPLsv_name`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `hv_hasBattery` AS SELECT
 1 AS `PPPPFiles_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `lagerbestand` AS SELECT
 1 AS `artikel_id`,
 1 AS `bestand`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `lageruebersicht` AS SELECT
 1 AS `artikel_id`,
 1 AS `bestand`,
 1 AS `artikelstamm_id`,
 1 AS `artikelnummer`,
 1 AS `Matchcode`,
 1 AS `Bezeichnung1`,
 1 AS `Bezeichnung2`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `IstAktiv`,
 1 AS `MengeneinheitVK`,
 1 AS `MengeneinheitEK`,
 1 AS `MengeneinheitLager`,
 1 AS `Langtext`,
 1 AS `Hauptgruppe`,
 1 AS `Untergruppe`,
 1 AS `MengeneinheitBasis`,
 1 AS `EKMeenthaeltBMe`,
 1 AS `VKMeenthaeltBMe`,
 1 AS `LMeenthaeltBMe`,
 1 AS `PreisEinstand`,
 1 AS `PreisEKStandard`,
 1 AS `PreisDurchschnittEK`,
 1 AS `PreisLEK`,
 1 AS `IstBestandsgefuehrt`,
 1 AS `IstChargengefuehrt`,
 1 AS `PreisVK`,
 1 AS `PreisVKAlt`,
 1 AS `BerechnungDB`,
 1 AS `IstProvisionsfaehig`,
 1 AS `IstBonusfaehig`,
 1 AS `ErloesKonto`,
 1 AS `Steuercode`,
 1 AS `Kostenstelle`,
 1 AS `Kostentraeger`,
 1 AS `MasseBMeLaenge`,
 1 AS `MasseBMeBreite`,
 1 AS `MasseBMeHoehe`,
 1 AS `MasseEkMeLaenge`,
 1 AS `MasseEkMeBreite`,
 1 AS `MasseEkMeHoehe`,
 1 AS `MasseVkMeLaenge`,
 1 AS `MasseVkMeBreite`,
 1 AS `MasseVkMeHoehe`,
 1 AS `MasseLMeLaenge`,
 1 AS `MasseLMeBreite`,
 1 AS `MasseLMeHoehe`,
 1 AS `Warennummer`,
 1 AS `Warenbezeichnung`,
 1 AS `BesondereMasseinheit`,
 1 AS `Umrechnungsfaktor`,
 1 AS `EigenmasseIn`,
 1 AS `Eigenmassefaktor`,
 1 AS `Ursprungsland`,
 1 AS `Steuerschluessel`,
 1 AS `ZollTarif`,
 1 AS `ZollProzent`,
 1 AS `ZollImport`,
 1 AS `ZollLand`,
 1 AS `Warenzusammensetzung`,
 1 AS `ABCKlasse`,
 1 AS `Qual_Qualitaet`,
 1 AS `Qual_Material1`,
 1 AS `Qual_Material2`,
 1 AS `Qual_Farbe`,
 1 AS `Qual_Groesse`,
 1 AS `Qual_Design`,
 1 AS `KnzLizenz`,
 1 AS `EAN_Code`,
 1 AS `Statistiknummer`,
 1 AS `MasseBMeGewichtBrutto`,
 1 AS `MasseEkMeGewichtBrutto`,
 1 AS `MasseVkMeGewichtBrutto`,
 1 AS `MasseLMeGewichtBrutto`,
 1 AS `MasseBMeGewichtNetto`,
 1 AS `MasseEkMeGewichtNetto`,
 1 AS `MasseVkMeGewichtNetto`,
 1 AS `MasseLMeGewichtNetto`,
 1 AS `Zollnummer`,
 1 AS `TextUebernahme`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `new_view` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_PPProjekte_Projekt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Co2Thumbprint` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `Status`,
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Artikel`,
 1 AS `Liefertermin`,
 1 AS `GesamtMenge`,
 1 AS `Zolltarif`,
 1 AS `Zollsatz`,
 1 AS `TargaNr`,
 1 AS `PM`,
 1 AS `PMJ`,
 1 AS `TC`,
 1 AS `Land`,
 1 AS `LT1`,
 1 AS `MengeLT1`,
 1 AS `LT2`,
 1 AS `MengeLT2`,
 1 AS `LT3`,
 1 AS `MengeLT3`,
 1 AS `MengeLTGesamt`,
 1 AS `DDP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Laendergewichte` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Laenderblock`,
 1 AS `Land`,
 1 AS `Landesgesamtmenge`,
 1 AS `Style`,
 1 AS `AssortmentMenge`,
 1 AS `KITotal`,
 1 AS `Aufteilungsart`,
 1 AS `Anteil`,
 1 AS `NettoStückgewicht`,
 1 AS `Gewichtseinheit`,
 1 AS `Gesamtgewicht`,
 1 AS `LBSort`,
 1 AS `GTINKL`,
 1 AS `GTIN`,
 1 AS `LSV`,
 1 AS `Laendernamen`,
 1 AS `LSVName`,
 1 AS `OWIMLT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_LaendergewichteFKE` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Laenderblock`,
 1 AS `Land`,
 1 AS `Landesgesamtmenge`,
 1 AS `Style`,
 1 AS `AssortmentMenge`,
 1 AS `KITotal`,
 1 AS `Aufteilungsart`,
 1 AS `Anteil`,
 1 AS `NettoStückgewicht`,
 1 AS `Gewichtseinheit`,
 1 AS `Gesamtgewicht`,
 1 AS `LBSort`,
 1 AS `GTINKL`,
 1 AS `GTIN`,
 1 AS `LSV`,
 1 AS `Laendernamen`,
 1 AS `LSVName`,
 1 AS `OWIMLT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Laendergewichte_Alternativ` AS SELECT
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_Id`,
 1 AS `PPProduktpass_Menge_CountryBlock`,
 1 AS `PPProduktpass_Menge_Country`,
 1 AS `Landesgesamtmenge`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `Value02_Summe`,
 1 AS `Anteil_Menge_Exakt`,
 1 AS `Anteil_Menge_Gerundet`,
 1 AS `Gewicht_Je_Einheit`,
 1 AS `GewichtsEinheit`,
 1 AS `Gesamtgewicht_Exakt`,
 1 AS `Gesamtgewicht_Gerundet`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPLsv_countryNames`,
 1 AS `PPLsv_name`,
 1 AS `PPProduktpass_Menge_TotalSalePerUnit`,
 1 AS `PPProduktpass_Menge_DeliveryWeek`,
 1 AS `PPProduktpass_Menge_countryRemarks`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Laendergewichte_II` AS SELECT
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_Id`,
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_CountryBlock`,
 1 AS `PPProduktpass_Menge_Country`,
 1 AS `Landesgesamtmenge`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `Value02_Summe`,
 1 AS `Aufteilungsart`,
 1 AS `Anteil_Menge_Exakt`,
 1 AS `Anteil_Menge_Gerundet`,
 1 AS `Gewicht_Je_Einheit`,
 1 AS `Gewichtseinheit`,
 1 AS `Gesamtgewicht_Exakt`,
 1 AS `Gesamtgewicht_Gerundet`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPLsv_countryNames`,
 1 AS `PPLsv_name`,
 1 AS `PPProduktpass_Menge_TotalSalePerUnit`,
 1 AS `PPProduktpass_Menge_DeliveryWeek`,
 1 AS `PPProduktpass_Menge_countryRemarks`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_LaendermengenUebersicht` AS SELECT
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Menge_DeliveryWeek`,
 1 AS `PPProduktpass_Menge_LT1`,
 1 AS `PPProduktpass_Menge_LT1Menge`,
 1 AS `PPProduktpass_Menge_LT2`,
 1 AS `PPProduktpass_Menge_LT2Menge`,
 1 AS `PPProduktpass_Menge_LT3`,
 1 AS `PPProduktpass_Menge_LT3Menge`,
 1 AS `PPProduktpass_Menge_Country`,
 1 AS `PPProduktpass_Menge_CountryBlock`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_ProduktMenge` AS SELECT
 1 AS `Produkt`,
 1 AS `Land`,
 1 AS `Gesamtmenge`,
 1 AS `DELIVERY`,
 1 AS `LT1Menge`,
 1 AS `LT1`,
 1 AS `LT2Menge`,
 1 AS `LT2`,
 1 AS `LT3Menge`,
 1 AS `LT3`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Produktpass` AS SELECT
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `Ausmusterungnummer`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `Warengruppe`,
 1 AS `Thema`,
 1 AS `Gesamtmenge`,
 1 AS `Liefertermin`,
 1 AS `PM`,
 1 AS `PJM`,
 1 AS `TC`,
 1 AS `CRD`,
 1 AS `PJM_VTR`,
 1 AS `PM_VTR`,
 1 AS `TC_VTR`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `UmsetzbarkeitAnzeigetext`,
 1 AS `catalogue_initialOrder`,
 1 AS `catalogue_isCatalogue`,
 1 AS `catalogue_initialCharge`,
 1 AS `catalogue_lotNumber`,
 1 AS `EigenmarkeLidl`,
 1 AS `EigenmarkeKaufland`,
 1 AS `Bereich`,
 1 AS `Restlaufzeit`,
 1 AS `DatumStatusAenderung`,
 1 AS `Alter_Status`,
 1 AS `Neuer_Status`,
 1 AS `MitarbeiterStatusAenderung`,
 1 AS `Zolltarif`,
 1 AS `Zollsatz`,
 1 AS `XMLImportDatum`,
 1 AS `Absagegrund`,
 1 AS `LIDL_Status`,
 1 AS `NGO_Pruefung`,
 1 AS `NGO_Pruefung_Bem`,
 1 AS `LFGB`,
 1 AS `Referenztest`,
 1 AS `Pruefplan`,
 1 AS `EUDataAct`,
 1 AS `ExternalID`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_ProduktpassMMI` AS SELECT
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `Ausmusterungnummer`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `Warengruppe`,
 1 AS `Thema`,
 1 AS `Gesamtmenge`,
 1 AS `Liefertermin`,
 1 AS `PM`,
 1 AS `PJM`,
 1 AS `TC`,
 1 AS `CRD`,
 1 AS `PJM_VTR`,
 1 AS `PM_VTR`,
 1 AS `TC_VTR`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `UmsetzbarkeitAnzeigetext`,
 1 AS `catalogue_initialOrder`,
 1 AS `catalogue_isCatalogue`,
 1 AS `catalogue_initialCharge`,
 1 AS `catalogue_lotNumber`,
 1 AS `EigenmarkeLidl`,
 1 AS `EigenmarkeKaufland`,
 1 AS `Bereich`,
 1 AS `Restlaufzeit`,
 1 AS `GarantiezeitDauer`,
 1 AS `GarantieArt`,
 1 AS `DatumStatusAenderung`,
 1 AS `Alter_Status`,
 1 AS `Neuer_Status`,
 1 AS `MitarbeiterStatusAenderung`,
 1 AS `Zolltarif`,
 1 AS `Zollsatz`,
 1 AS `XMLImportDatum`,
 1 AS `Absagegrund`,
 1 AS `LIDL_Status`,
 1 AS `NGO_Pruefung`,
 1 AS `NGO_Pruefung_Bem`,
 1 AS `LFGB`,
 1 AS `Referenztest`,
 1 AS `Pruefplan`,
 1 AS `EUDataAct`,
 1 AS `RowHash`,
 1 AS `ExternalID`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_ProduktpassPruefplan` AS SELECT
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `Ausmusterungnummer`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `Warengruppe`,
 1 AS `Thema`,
 1 AS `Gesamtmenge`,
 1 AS `Liefertermin`,
 1 AS `PM`,
 1 AS `PJM`,
 1 AS `TC`,
 1 AS `CRD`,
 1 AS `PJM_VTR`,
 1 AS `PM_VTR`,
 1 AS `TC_VTR`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `UmsetzbarkeitAnzeigetext`,
 1 AS `catalogue_initialOrder`,
 1 AS `catalogue_isCatalogue`,
 1 AS `catalogue_initialCharge`,
 1 AS `catalogue_lotNumber`,
 1 AS `EigenmarkeLidl`,
 1 AS `EigenmarkeKaufland`,
 1 AS `Bereich`,
 1 AS `Restlaufzeit`,
 1 AS `DatumStatusAenderung`,
 1 AS `Alter_Status`,
 1 AS `Neuer_Status`,
 1 AS `MitarbeiterStatusAenderung`,
 1 AS `Zolltarif`,
 1 AS `Zollsatz`,
 1 AS `XMLImportDatum`,
 1 AS `Absagegrund`,
 1 AS `LIDL_Status`,
 1 AS `NGO_Pruefung`,
 1 AS `NGO_Pruefung_Bem`,
 1 AS `LFGB`,
 1 AS `Referenztest`,
 1 AS `PruefplanAnzahl`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Produktpass_Save` AS SELECT
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `Ausmusterungnummer`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `Warengruppe`,
 1 AS `Thema`,
 1 AS `Gesamtmenge`,
 1 AS `Liefertermin`,
 1 AS `PM`,
 1 AS `PJM`,
 1 AS `TC`,
 1 AS `CRD`,
 1 AS `PJM_VTR`,
 1 AS `PM_VTR`,
 1 AS `TC_VTR`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `UmsetzbarkeitAnzeigetext`,
 1 AS `catalogue_initialOrder`,
 1 AS `catalogue_isCatalogue`,
 1 AS `catalogue_initialCharge`,
 1 AS `catalogue_lotNumber`,
 1 AS `EigenmarkeLidl`,
 1 AS `EigenmarkeKaufland`,
 1 AS `Bereich`,
 1 AS `Restlaufzeit`,
 1 AS `DatumStatusAenderung`,
 1 AS `Alter_Status`,
 1 AS `Neuer_Status`,
 1 AS `MitarbeiterStatusAenderung`,
 1 AS `Zolltarif`,
 1 AS `Zollsatz`,
 1 AS `XMLImportDatum`,
 1 AS `Absagegrund`,
 1 AS `LIDL_Status`,
 1 AS `NGO_Pruefung`,
 1 AS `NGO_Pruefung_Bem`,
 1 AS `LFGB`,
 1 AS `Referenztest`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_ProjektMitBattrien` AS SELECT
 1 AS `PPproduktpass_Id`,
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Artikel`,
 1 AS `InternerStatus`,
 1 AS `BatterieAnlage`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_PruefplanVorhanden` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PruefplanAnzahl`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_Shipments` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `Ausmusterung`,
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `TotalQuantity`,
 1 AS `TargaStatus`,
 1 AS `LidlStatus`,
 1 AS `TCAdmin`,
 1 AS `PMAdmin`,
 1 AS `PJMAdmin`,
 1 AS `LogAdmin`,
 1 AS `Supplier`,
 1 AS `POD`,
 1 AS `INCOTERM`,
 1 AS `HSCode`,
 1 AS `MS_EUG`,
 1 AS `MS_30PSI`,
 1 AS `MS_PSI`,
 1 AS `Complete`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPShipment_Id`,
 1 AS `PPShipment_Forwarder`,
 1 AS `PPShipment_Carrier`,
 1 AS `PPShipment_Lot`,
 1 AS `PPShipment_Vessel`,
 1 AS `PPShipment_Voyage`,
 1 AS `PPShipment_ENS`,
 1 AS `PPShipment_CYClosing`,
 1 AS `PPShipment_ETD`,
 1 AS `PPShipment_ETA`,
 1 AS `PPShipment_ShipReleaseGiven`,
 1 AS `PPShipment_ShipReleaseCalc`,
 1 AS `PPShipment_CRDGiven`,
 1 AS `PPShipment_CRDOpeningCalc`,
 1 AS `PPShipment_CRDClosingCalc`,
 1 AS `PPShipment_UnloadingReportDate`,
 1 AS `PPShipment_20ftGP`,
 1 AS `PPShipment_40ftGP`,
 1 AS `PPShipment_40ftHQ`,
 1 AS `PPShipment_LCLCBM`,
 1 AS `PPShipment_20ftGPCalc`,
 1 AS `PPShipment_40ftGPCalc`,
 1 AS `PPShipment_40ftHQCalc`,
 1 AS `PPShipment_CurrentStatus`,
 1 AS `PPShipment_BLForm`,
 1 AS `PPShipment_LCOA`,
 1 AS `PPShipment_ProducerBooking`,
 1 AS `PPShipment_ShipRelease`,
 1 AS `PPShipment_SO`,
 1 AS `PPShipment_BL`,
 1 AS `PPShipment_Invoce`,
 1 AS `PPShipment_PL`,
 1 AS `PPShipment_CoO`,
 1 AS `PPShipment_DeclarationFumigation`,
 1 AS `PPShipment_OceanFreight`,
 1 AS `PPShipment_PL2MaWi`,
 1 AS `PPShipment_CLPSent`,
 1 AS `PPShipment_SeaFreightInvoice`,
 1 AS `PPShipment_TransportInvoice`,
 1 AS `PPShipment_UnloadingInvoice`,
 1 AS `PPShipment_OtherLogisticalCosts`,
 1 AS `PPShipment_CCCsent`,
 1 AS `PPShipment_CustomsInvoice`,
 1 AS `PPShipment_CustomsDeclared`,
 1 AS `PPShipment_HSCode`,
 1 AS `PPShipment_ProjektCount`,
 1 AS `PPShipment_TEU`,
 1 AS `PPShipment_VKStk`,
 1 AS `PPShipment_VKSumme`,
 1 AS `PPShipment_DistancePort2Port`,
 1 AS `PPShipment_Incoterm`,
 1 AS `PPShipment_LT`,
 1 AS `PPShipment_MS_30PSI`,
 1 AS `PPShipment_MS_EUG`,
 1 AS `PPShipment_MS_PSI`,
 1 AS `PPShipment_POA`,
 1 AS `PPShipment_POD`,
 1 AS `PPShipment_SaleUnit`,
 1 AS `PPShipment_Supplier`,
 1 AS `PPShipment_Status`,
 1 AS `PPShipment_Quantity`,
 1 AS `PPShipment_Flag_Producer_booking`,
 1 AS `PPShipment_Flag_Shipment_Release`,
 1 AS `PPShipment_Flag_SO`,
 1 AS `PPShipment_Flag_BL`,
 1 AS `PPShipment_Flag_Inv`,
 1 AS `PPShipment_Flag_PL`,
 1 AS `PPShipment_Flag_CoO`,
 1 AS `PPShipment_Flag_Declaration_of_Fumigation`,
 1 AS `PPShipment_Flag_Ocean_Freight`,
 1 AS `PPShipment_Flag_PL_sent_to_MaWi`,
 1 AS `PPShipment_Flag_CLP_sent`,
 1 AS `PPShipment_Flag_Sea_freight_invoice`,
 1 AS `PPShipment_Flag_Transport_invoice`,
 1 AS `PPShipment_Flag_Unloading_invoice`,
 1 AS `PPShipment_Flag_Other_logistical_costs`,
 1 AS `PPShipment_Flag_CCC_sent`,
 1 AS `PPShipment_Flag_customs_invoice`,
 1 AS `PPShipment_Flag_OS`,
 1 AS `PPShipment_Flag_EUService`,
 1 AS `PPShipment_Flag_Critical`,
 1 AS `PPShipment_BatteryType`,
 1 AS `PPShipment_MasterCartonContents`,
 1 AS `PPShipment_ATAInlandsterminal`,
 1 AS `PPShipment_ZipCodeFactory`,
 1 AS `ExternalID`,
 1 AS `RowHash`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_StatSPOUpload` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Dateiname`,
 1 AS `Type`,
 1 AS `SubType`,
 1 AS `Kategorie`,
 1 AS `UploadLocal`,
 1 AS `StartTransfer2SPO`,
 1 AS `EndTransfer2SPO`,
 1 AS `ZeitBisSPOUploadInSek`,
 1 AS `DauerUploadInSek`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_UserLogin` AS SELECT
 1 AS `User`,
 1 AS `LoginDate`,
 1 AS `Type`,
 1 AS `Name`,
 1 AS `Vorname`,
 1 AS `Taetigkeit`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_UserLoginCount` AS SELECT
 1 AS `PPLog_User`,
 1 AS `AnzahlLogins`,
 1 AS `PPMitarbeiter_Taetigkeit`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_ZolltarifRegeln` AS SELECT
 1 AS `Id`,
 1 AS `Status`,
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Artikel`,
 1 AS `Zolltarifnummer_TPT`,
 1 AS `Zolltarifnummer_Restricted`,
 1 AS `Warenbezeichnung`,
 1 AS `Grund`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_check_PM_TC_Assignment` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Status`,
 1 AS `Artikel`,
 1 AS `PMAdminId`,
 1 AS `PMAdmin`,
 1 AS `TCAdminId`,
 1 AS `TCAdmin`,
 1 AS `PJMAdminId`,
 1 AS `PJMAdmin`,
 1 AS `MilestoneTaetigkeit`,
 1 AS `Milestone`,
 1 AS `Dashboard_Id`,
 1 AS `Zustaendige_rMAId`,
 1 AS `TerminStatus`,
 1 AS `Zustaendige_rMA`,
 1 AS `Zustaendige_rTaetigkeit`,
 1 AS `StatusZuordnung`,
 1 AS `PPTermine_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_check_PM_TC_Assignment_Error` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Status`,
 1 AS `Artikel`,
 1 AS `PMAdminId`,
 1 AS `PMAdmin`,
 1 AS `TCAdminId`,
 1 AS `TCAdmin`,
 1 AS `PJMAdminId`,
 1 AS `PJMAdmin`,
 1 AS `MilestoneTaetigkeit`,
 1 AS `Milestone`,
 1 AS `Zustaendige_rMAId`,
 1 AS `Zustaendige_rMA`,
 1 AS `Zustaendige_rTaetigkeit`,
 1 AS `PPTermine_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_check_PM_TC_PJM_Assignment_Error` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Status`,
 1 AS `Artikel`,
 1 AS `PMAdminId`,
 1 AS `PMAdmin`,
 1 AS `TCAdminId`,
 1 AS `TCAdmin`,
 1 AS `PJMAdminId`,
 1 AS `PJMAdmin`,
 1 AS `MilestoneTaetigkeit`,
 1 AS `Milestone`,
 1 AS `Zustaendige_rMAId`,
 1 AS `TerminStatus`,
 1 AS `Zustaendige_rMA`,
 1 AS `Zustaendige_rTaetigkeit`,
 1 AS `StatusZuordnung`,
 1 AS `PPTermine_Id`,
 1 AS `Dashboard_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_hvBestelluebersichtOnlineshops` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPXML_OSMengen_styleNo`,
 1 AS `PPXML_OSMengen_productName`,
 1 AS `PPXML_OSMengen_country`,
 1 AS `PPXML_OSMengen_lsv`,
 1 AS `PPXML_OSMengen_value`,
 1 AS `PPXML_OSMengen_DeliveryNo`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_hvBestelluebersichtStationaer` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPXML_Mengen_styleNo`,
 1 AS `PPXML_Mengen_productName`,
 1 AS `PPXML_Mengen_country`,
 1 AS `PPXML_Mengen_lsv`,
 1 AS `PPXML_Mengen_value`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_hvLSVs` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPLsv_countryCodes`,
 1 AS `PPLsv_countryNames`,
 1 AS `PPLsv_name`,
 1 AS `PPLsv_code`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_hvLaendermengen` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Menge_CountryBlock`,
 1 AS `PPProduktpass_Menge_Country`,
 1 AS `PPProduktpass_Menge_Quantity`,
 1 AS `PPProduktpass_Menge_TotalSalePerUnit`,
 1 AS `PPProduktpass_Menge_PackingMethod`,
 1 AS `PPProduktpass_Menge_DeliveryWeek`,
 1 AS `PPProduktpass_Menge_LT1`,
 1 AS `PPProduktpass_Menge_LT1Menge`,
 1 AS `PPProduktpass_Menge_LT2`,
 1 AS `PPProduktpass_Menge_LT2Menge`,
 1 AS `PPProduktpass_Menge_LT3`,
 1 AS `PPProduktpass_Menge_LT3Menge`,
 1 AS `PPProduktpass_Menge_Kolli`,
 1 AS `PPProduktpass_Menge_ArtikelInfo`,
 1 AS `InternerStatus`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_hvMengenStationaer` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Artikel`,
 1 AS `StyleNo`,
 1 AS `Style`,
 1 AS `Country`,
 1 AS `LSV`,
 1 AS `KolliContent`,
 1 AS `PcsInKollie`,
 1 AS `LT1`,
 1 AS `LT1Menge`,
 1 AS `LT2`,
 1 AS `LT2Menge`,
 1 AS `LT3`,
 1 AS `LT3Menge`,
 1 AS `TotalQty`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `rpt_hvZollGewichteGTIN` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_productName`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_size`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `tFiles1` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `AnzahlDateien1`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `tFiles2` AS SELECT
 1 AS `REVIan`,
 1 AS `AnzahlDateien2`,
 1 AS `PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `tMaxFiles` AS SELECT
 1 AS `RevIAN`,
 1 AS `Max`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `test_IAN_ohne_ServiceAnfrage` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `InternerStatus`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `test_ServiceAnfrage_IAN` AS SELECT
 1 AS `IAN`,
 1 AS `PPId`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `tmp_testLastCahnge` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Aenderung`,
 1 AS `DatumStatusAenderung`,
 1 AS `Alter_Status`,
 1 AS `Neuer_Status`,
 1 AS `Mitarbeiter`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `vAktRev` AS SELECT
 1 AS `PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `vLagerliste` AS SELECT
 1 AS `Artikelnummer`,
 1 AS `Matchcode`,
 1 AS `Bezeichnung1`,
 1 AS `Bezeichnung2`,
 1 AS `EP`,
 1 AS `LEK`,
 1 AS `MEK`,
 1 AS `Einh`,
 1 AS `IstAktiv`,
 1 AS `IstBestandsgefuehrt`,
 1 AS `LagerartikelArt`,
 1 AS `Bestand`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `vLastRevPP` AS SELECT
 1 AS `lastRevPPId`,
 1 AS `IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `vMehrwertsteuer` AS SELECT
 1 AS `Belegart`,
 1 AS `Lieferadresse_Land`,
 1 AS `Belegdatum`,
 1 AS `Belegnummer`,
 1 AS `menge`,
 1 AS `Preis`,
 1 AS `Steuercode`,
 1 AS `Liefertermin`,
 1 AS `Steuersatz`,
 1 AS `SteuerAusweisen`,
 1 AS `Belegposition_id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `vPPwithDiffrentKolli` AS SELECT
 1 AS `Name_exp_1`,
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `vXML_Converter` AS SELECT
 1 AS `XMLConverter_Id`,
 1 AS `XMLConverter_DBTable`,
 1 AS `XMLConverter_DBColumn`,
 1 AS `XMLConverter_XMLNode`,
 1 AS `XMLConverter_Version`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_AbgangEK` AS SELECT
 1 AS `Abgang`,
 1 AS `EKWaehrung`,
 1 AS `AbgangJahr`,
 1 AS `AbgangMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_AltgeraeteES` AS SELECT
 1 AS `Status`,
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `Ausmusterungnummer`,
 1 AS `Liefertermin`,
 1 AS `Land`,
 1 AS `Menge`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_AssortOWLsv` AS SELECT
 1 AS `PPAssortments_Id`,
 1 AS `PPAssortments_PPProduktpass_Id`,
 1 AS `PPAssortments_styleNo`,
 1 AS `PPAssortments_vendorUniqueSeqNo`,
 1 AS `PPAssortments_packingMethod`,
 1 AS `PPAssortments_countryCodes`,
 1 AS `PPAssortments_totalPackRatio`,
 1 AS `PPAssortments_sizecode`,
 1 AS `PPAssortments_sizevalue`,
 1 AS `PPAssortments_productName`,
 1 AS `PPAssortments_delMarker`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPLsv_name`,
 1 AS `PPLsv_countryCodes`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_AssortOWLsvOLsv` AS SELECT
 1 AS `PPAssortments_Id`,
 1 AS `PPAssortments_PPProduktpass_Id`,
 1 AS `PPAssortments_styleNo`,
 1 AS `PPAssortments_vendorUniqueSeqNo`,
 1 AS `PPAssortments_packingMethod`,
 1 AS `PPAssortments_countryCodes`,
 1 AS `PPAssortments_totalPackRatio`,
 1 AS `PPAssortments_sizecode`,
 1 AS `PPAssortments_sizevalue`,
 1 AS `PPAssortments_productName`,
 1 AS `PPAssortments_delMarker`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPLsv_name`,
 1 AS `PPLsv_countryCodes`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Assortment` AS SELECT
 1 AS `PPAssortments_Id`,
 1 AS `PPAssortments_PPProduktpass_Id`,
 1 AS `PPAssortments_styleNo`,
 1 AS `PPAssortments_vendorUniqueSeqNo`,
 1 AS `PPAssortments_packingMethod`,
 1 AS `PPAssortments_countryCodes`,
 1 AS `PPAssortments_totalPackRatio`,
 1 AS `PPAssortments_sizecode`,
 1 AS `PPAssortments_sizevalue`,
 1 AS `PPAssortments_productName`,
 1 AS `PPProduktpass_Artikelbezeichnung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_AuftragsUebersicht` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PM`,
 1 AS `PMVTR`,
 1 AS `TC`,
 1 AS `TCVTR`,
 1 AS `PJM`,
 1 AS `PJMVTR`,
 1 AS `SORTSTATUS`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_BuHaWareneinsatz` AS SELECT
 1 AS `LTKunde`,
 1 AS `IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `Ausmusterung`,
 1 AS `Menge`,
 1 AS `Artikel`,
 1 AS `LiefLTJahr`,
 1 AS `LiefLTWoche`,
 1 AS `LTMenge`,
 1 AS `TotalEKFW`,
 1 AS `EKBWFW`,
 1 AS `EKFW`,
 1 AS `WSYM`,
 1 AS `EKKalk`,
 1 AS `KursKalk`,
 1 AS `LieferantenLT`,
 1 AS `Periode`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_CRD` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `PPProduktpass_Status`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `DDP`,
 1 AS `CRDausDDP`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `CRDausDaten`,
 1 AS `CRD`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_CountLocalFiles` AS SELECT
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `NoLocalFiles`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_CountSharepointFiles` AS SELECT
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `NoLocalFiles`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DBUebersicht` AS SELECT
 1 AS `PPPurchase_PPProduktpass_Id`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPPurchase_Currency`,
 1 AS `PPPurchase_ExcR_Calc`,
 1 AS `PPPurchase_EK`,
 1 AS `PPPurchase_LC_TOP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKAssign` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPPurchaseDTK_Id`,
 1 AS `PPPurchaseDTK_PPProduktpass_id`,
 1 AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`,
 1 AS `PPPurchaseDTK_Betrag`,
 1 AS `KursKalk`,
 1 AS `PO_Wert`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKGebunden` AS SELECT
 1 AS `BetragGebunden`,
 1 AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKNachMonaten` AS SELECT
 1 AS `DTK_Betrag`,
 1 AS `DTK_Monat`,
 1 AS `DTK_Jahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKUebersicht` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `Gedeckt`,
 1 AS `PO_Wert`,
 1 AS `KursKalk`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPProduktpass_Ausmusterungnummer`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKUngedeckt` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPPurchase_Supplier`,
 1 AS `LT`,
 1 AS `PO_Wert`,
 1 AS `Ungedeckt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKmitWerten` AS SELECT
 1 AS `PPDevisenTerminKaeufe_Id`,
 1 AS `PPDevisenTerminKaeufe_Referenz`,
 1 AS `PPDevisenTerminKaeufe_Termin`,
 1 AS `PPDevisenTerminKaeufe_Betrag`,
 1 AS `PPDevisenTerminKaeufe_Kurs`,
 1 AS `PPDevisenTerminKaeufe_Bank`,
 1 AS `updated_at`,
 1 AS `create or Replace d_at`,
 1 AS `PPDevisenTerminKaeufe_Status`,
 1 AS `PPDevisenTerminKaeufe_Bemerkung`,
 1 AS `BetragGebunden`,
 1 AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`,
 1 AS `Offen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_DTKmitZuordung` AS SELECT
 1 AS `PPDevisenTerminKaeufe_Id`,
 1 AS `PPDevisenTerminKaeufe_Referenz`,
 1 AS `PPDevisenTerminKaeufe_Termin`,
 1 AS `PPDevisenTerminKaeufe_Betrag`,
 1 AS `PPDevisenTerminKaeufe_Kurs`,
 1 AS `PPDevisenTerminKaeufe_Bank`,
 1 AS `updated_at`,
 1 AS `create or Replace d_at`,
 1 AS `PPDevisenTerminKaeufe_Status`,
 1 AS `PPDevisenTerminKaeufe_Bemerkung`,
 1 AS `PPPurchaseDTK_Id`,
 1 AS `PPPurchaseDTK_PPProduktpass_id`,
 1 AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`,
 1 AS `PPPurchaseDTK_Betrag`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_EANTest` AS SELECT
 1 AS `PPProduktpass_Sortierung_EAN`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Sortierung_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_EANTest1` AS SELECT
 1 AS `EANPOS`,
 1 AS `PPProduktpass_Sortierung_Id`,
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_EAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ESSortierungKI` AS SELECT
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `KI`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ESSortierungOrderWeights` AS SELECT
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Value01`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_unit`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_FileDoubletten` AS SELECT
 1 AS `AnzahlDateien`,
 1 AS `PPProduktpass_IAN`,
 1 AS `Charge`,
 1 AS `PPPPFiles_Name`,
 1 AS `Reiter`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_FileProtokoll` AS SELECT
 1 AS `PPPPFiles_Status`,
 1 AS `PPPPFiles_PPProduktpass_Id`,
 1 AS `PPPPFiles_Name`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `PPPPFiles_UserCreate`,
 1 AS `PPPPFiles_UserDelete`,
 1 AS `PPPPFiles_Type`,
 1 AS `PPPPFiles_SubKat`,
 1 AS `PPPPFiles_Ordnung`,
 1 AS `CreateUser`,
 1 AS `DeleteUser`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_FilesAll` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `InternerStatus`,
 1 AS `PPPPFiles_Name`,
 1 AS `PPPPFiles_Type`,
 1 AS `FileDate`,
 1 AS `PPPPFiles_Pfad`,
 1 AS `PPPPFiles_SubKat`,
 1 AS `PPPPFiles_Ordnung`,
 1 AS `PPPPFiles_LinkName`,
 1 AS `PPPPFiles_Link`,
 1 AS `PPPPFiles_SharePointLink`,
 1 AS `FId`,
 1 AS `PPPPFiles_IsExtern`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_FilesDistinct` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `InternerStatus`,
 1 AS `Filename`,
 1 AS `FId`,
 1 AS `PPPPFiles_Id`,
 1 AS `PPPPFiles_PPProduktpass_Id`,
 1 AS `PPPPFiles_Name`,
 1 AS `PPPPFiles_Type`,
 1 AS `PPPPFiles_Date`,
 1 AS `PPPPFiles_Description`,
 1 AS `PPPPFiles_Pfad`,
 1 AS `created_at`,
 1 AS `updated_at`,
 1 AS `PPPPFiles_SubKat`,
 1 AS `PPPPFiles_Ordnung`,
 1 AS `PPPPFiles_Link`,
 1 AS `PPPPFiles_LinkName`,
 1 AS `PPPPFiles_UserCreate`,
 1 AS `PPPPFiles_UserDelete`,
 1 AS `PPPPFiles_Status`,
 1 AS `PPPPFiles_SharePointLink`,
 1 AS `PPPPFiles_TPTFilenameOld`,
 1 AS `PPPPFiles_LocalUpload`,
 1 AS `PPPPFiles_Size`,
 1 AS `PPPPFiles_UserLastModified`,
 1 AS `PPPPFiles_DateLastModiefied`,
 1 AS `PPPPFiles_UploadException`,
 1 AS `PPPPFiles_NoPPID`,
 1 AS `TypeRestricted`,
 1 AS `KatRestricted`,
 1 AS `PPPPFiles_IsExtern`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_FilesSub` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `InternerStatus`,
 1 AS `Filename`,
 1 AS `FId`,
 1 AS `File_Type`,
 1 AS `File_SubKat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_GTINWeightsPerStyle` AS SELECT
 1 AS `v_GTINWeightsPerStyle_PPProduktpass_Id`,
 1 AS `vPPOrderWeights_gtin`,
 1 AS `vPPOrderWeights_gtinKL`,
 1 AS `vPPOrderWeights_styleNo`,
 1 AS `vPPOrderWeights_unit`,
 1 AS `vPPOrderWeights_weight`,
 1 AS `vPPOrderWeights_lsv`,
 1 AS `vPPLsv_countryCodes`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_GedecktePO` AS SELECT
 1 AS `Gedeckt`,
 1 AS `PPPurchaseDTK_PPProduktpass_id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_IANReal` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_IAN`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Artikelbezeichnung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_IsUSOrder` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_IsUSOrderPP` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IsUSA`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_KursReal` AS SELECT
 1 AS `PPPurchase_PPProduktpass_Id`,
 1 AS `PPPurchase_ExcR_Save_Date`,
 1 AS `PPPurchase_Currency`,
 1 AS `Kurs`,
 1 AS `PPPurchase_ExcR_Calc`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LCEroeffnungenPeriode` AS SELECT
 1 AS `LCEroeffnungJahr`,
 1 AS `LCEroeffnungMonat`,
 1 AS `EKGesamt`,
 1 AS `PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LCEroeffnungenPeriodeKUM` AS SELECT
 1 AS `LCEroeffnungSummeEK`,
 1 AS `LCEroeffnungJahr`,
 1 AS `LCEroeffnungMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LTMengenJeHafen` AS SELECT
 1 AS `PPLaenderbloecke_Hafen1`,
 1 AS `PPLaenderbloecke_Hafen2`,
 1 AS `PPAB_Aufteilung_Rotterdam_FR`,
 1 AS `PPAB_Aufteilung_Barcelona_IT`,
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_LT1`,
 1 AS `MengeLT1`,
 1 AS `PPProduktpass_Menge_LT2`,
 1 AS `MengeLT2`,
 1 AS `PPProduktpass_Menge_LT3`,
 1 AS `MengeLT3`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Laendergesamtmengen` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `InternerStatus`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `LaenderGesamtmenge`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Laendermengen` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `PPProduktpass_Menge_Quantity`,
 1 AS `PPProduktpass_Menge_Country`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LatestServiceAnfrage` AS SELECT
 1 AS `PPInputManuell_Id`,
 1 AS `PPInputManuell_PPProduktpass_Id`,
 1 AS `PPInputManuell_Projektname`,
 1 AS `PPInputManuell_Lieferant`,
 1 AS `PPInputManuell_GeplanterEKUSD`,
 1 AS `PPInputManuell_GeplanterVK`,
 1 AS `PPInputManuell_LaufzeitGarantie`,
 1 AS `PPInputManuell_GarantieLieferant`,
 1 AS `PPInputManuell_AbwicklungGarantie`,
 1 AS `PPInputManuell_SonderleistungLieferant`,
 1 AS `PPInputManuell_MaxAusfallrate`,
 1 AS `PPInputManuell_ServiceVetrag`,
 1 AS `PPInputManuell_Verschiffungshafen`,
 1 AS `PPInputManuell_MengeDE`,
 1 AS `PPInputManuell_MengeEU`,
 1 AS `PPInputManuell_VE`,
 1 AS `PPInputManuell_Masse`,
 1 AS `PPInputManuell_Laenge`,
 1 AS `PPInputManuell_Breite`,
 1 AS `PPInputManuell_Hoehe`,
 1 AS `PPInputManuell_Onlinekartonage`,
 1 AS `PPInputManuell_Ausfallrate`,
 1 AS `PPInputManuell_ZukaufServiceWare`,
 1 AS `PPInputManuell_Servicekostensatz`,
 1 AS `PPInputManuell_Preisblatt`,
 1 AS `PPInputManuell_EingangsfrachtZFRD`,
 1 AS `PPInputManuell_LogistikZLGK`,
 1 AS `PPInputManuell_AusgangsfrachtZRF2`,
 1 AS `PPInputManuell_ContHCStk`,
 1 AS `PPInputManuell_ContHCRot`,
 1 AS `PPInputManuell_ContHCBar`,
 1 AS `PPInputManuell_ContHCKop`,
 1 AS `PPInputManuell_ContHCUSA`,
 1 AS `PPInputManuell_Cont40Stk`,
 1 AS `PPInputManuell_Cont40Rot`,
 1 AS `PPInputManuell_Cont40Bar`,
 1 AS `PPInputManuell_Cont40Kop`,
 1 AS `PPInputManuell_Cont40USA`,
 1 AS `PPInputManuell_Cont20Stk`,
 1 AS `PPInputManuell_Cont20Rot`,
 1 AS `PPInputManuell_Cont20Bar`,
 1 AS `PPInputManuell_Cont20Kop`,
 1 AS `PPInputManuell_Cont20USA`,
 1 AS `PPInputManuell_ContPlan20`,
 1 AS `PPInputManuell_ContPlan40`,
 1 AS `PPInputManuell_ContPlan40HC`,
 1 AS `PPInputManuell_Exportkarton_VE_V2`,
 1 AS `PPInputManuell_Exportkarton_Masse_V2`,
 1 AS `PPInputManuell_Exportkarton_Laenge_V2`,
 1 AS `PPInputManuell_Exportkarton_Breite_V2`,
 1 AS `PPInputManuell_Exportkarton_Hoehe_V2`,
 1 AS `PPInputManuell_Exportkarton_VE`,
 1 AS `PPInputManuell_Exportkarton_Masse`,
 1 AS `PPInputManuell_Exportkarton_Laenge`,
 1 AS `PPInputManuell_Exportkarton_Breite`,
 1 AS `PPInputManuell_Exportkarton_Hoehe`,
 1 AS `PPInputManuell_GutschriftenbetragKunde`,
 1 AS `PPInputManuell_StkProPalette`,
 1 AS `PPInputManuell_DeckelAusfallrate`,
 1 AS `PPInputManuell_IsLatest`,
 1 AS `PPInputManuell_Date`,
 1 AS `PPInputManuell_Bemerkungen`,
 1 AS `PPInputManuell_StatusPM`,
 1 AS `PPInputManuell_StatusMaWi`,
 1 AS `PPInputManuell_TextGroesse`,
 1 AS `PPInputManuell_UAWGB`,
 1 AS `PPInputManuell_KLContPlan20`,
 1 AS `PPInputManuell_KLContPlan40`,
 1 AS `PPInputManuell_KLContPlan40HC`,
 1 AS `PPInputManuell_EKWSYM`,
 1 AS `PPInputManuell_KLExportkarton_VE`,
 1 AS `PPInputManuell_KLExportkarton_Masse`,
 1 AS `PPInputManuell_KLExportkarton_Laenge`,
 1 AS `PPInputManuell_KLExportkarton_Breite`,
 1 AS `PPInputManuell_KLExportkarton_Hoehe`,
 1 AS `PPInputManuell_KLExportkarton_VE_V2`,
 1 AS `PPInputManuell_KLExportkarton_Masse_V2`,
 1 AS `PPInputManuell_KLExportkarton_Laenge_V2`,
 1 AS `PPInputManuell_KLExportkarton_Breite_V2`,
 1 AS `PPInputManuell_KLExportkarton_Hoehe_V2`,
 1 AS `PPInputManuell_OSExportkarton_VE`,
 1 AS `PPInputManuell_OSExportkarton_Masse`,
 1 AS `PPInputManuell_OSExportkarton_Laenge`,
 1 AS `PPInputManuell_OSExportkarton_Breite`,
 1 AS `PPInputManuell_OSExportkarton_Hoehe`,
 1 AS `PPInputManuell_OSExportkarton_VE_V2`,
 1 AS `PPInputManuell_OSExportkarton_Masse_V2`,
 1 AS `PPInputManuell_OSExportkarton_Laenge_V2`,
 1 AS `PPInputManuell_OSExportkarton_Breite_V2`,
 1 AS `PPInputManuell_OSExportkarton_Hoehe_V2`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Lieferlaender` AS SELECT
 1 AS `PPProduktpass_Menge_Country`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LinkedItems` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_KLLink_PPProduktpass_Id`,
 1 AS `PPProduktpass_KLLink_IAN`,
 1 AS `PPProduktpass_KLLink_lotNo`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `itemTypeKL`,
 1 AS `PPProduktpass_continentType`,
 1 AS `PPProduktpass_linkedItemIan`,
 1 AS `PPProduktpass_linkedItemLotNo`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqAbflussPeriode` AS SELECT
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `USD`,
 1 AS `EUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqAblussPeriodeEUR` AS SELECT
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `Abfluss`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqAblussPeriodeUSD` AS SELECT
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `Abfluss`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqLCE` AS SELECT
 1 AS `EKSumme`,
 1 AS `EKWaehrung`,
 1 AS `LCJahr`,
 1 AS `LCMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqLCNNE` AS SELECT
 1 AS `EKSumme`,
 1 AS `EKWaehrung`,
 1 AS `YearLCNNE`,
 1 AS `MonthLCNNE`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqLCuebersichtPeriodenEUR` AS SELECT
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `EKSummeE`,
 1 AS `EKSummeNNE`,
 1 AS `Waehrung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqLCuebersichtPeriodenUSD` AS SELECT
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `EKSummeE`,
 1 AS `EKSummeNNE`,
 1 AS `Waehrung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqLaenderEK` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `LaenderMenge`,
 1 AS `LaenderEK`,
 1 AS `LaenderVK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqLaenderEKVK` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `LaenderMenge`,
 1 AS `LaenderEK`,
 1 AS `LaenderVK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LiqZuflussPeriodeEUR` AS SELECT
 1 AS `PJahr`,
 1 AS `PMonat`,
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `Zufluss`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Liquiditaet` AS SELECT
 1 AS `Ausmusterung`,
 1 AS `TOP`,
 1 AS `ZId`,
 1 AS `LC`,
 1 AS `Bemerkung`,
 1 AS `Betrag`,
 1 AS `BezahltAm`,
 1 AS `Nummer`,
 1 AS `Produzent`,
 1 AS `Land`,
 1 AS `IAN`,
 1 AS `Projektbild`,
 1 AS `PPId`,
 1 AS `Artikelbezeichnung`,
 1 AS `EK`,
 1 AS `EKWaehrung`,
 1 AS `MengeGesamt`,
 1 AS `EKGesamt`,
 1 AS `LaenderEKGesamt`,
 1 AS `LaenderVKGesamt`,
 1 AS `LT`,
 1 AS `LTDate`,
 1 AS `PPProduktpass_Id`,
 1 AS `KursKalkuliert`,
 1 AS `KursGesichert`,
 1 AS `KursGesichertAm`,
 1 AS `Zahlungsziel`,
 1 AS `BezahltBemerkung`,
 1 AS `LCEroeffnung`,
 1 AS `LCEroeffnungAlternativ`,
 1 AS `Andienung`,
 1 AS `FaelligkeitLieferant`,
 1 AS `VKinEUR`,
 1 AS `VKGesamt`,
 1 AS `Rohertrag`,
 1 AS `ZahlungKunde`,
 1 AS `Faelligkeit`,
 1 AS `TTTage`,
 1 AS `Projekt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LotHafenmengen` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `Lot`,
 1 AS `Port`,
 1 AS `SaleUnit`,
 1 AS `LotQuantity`,
 1 AS `LT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_LotLaendermengen` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `Country`,
 1 AS `Port`,
 1 AS `SaleUnit`,
 1 AS `LT`,
 1 AS `Quantity`,
 1 AS `Lot`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MES` AS SELECT
 1 AS `MES_PPID`,
 1 AS `MES_Total`,
 1 AS `MES_StyleMenge`,
 1 AS `MES_StyleGewicht`,
 1 AS `MES_StyleNo`,
 1 AS `MES_KI`,
 1 AS `MES_StyleBezeichung`,
 1 AS `MES_SortMenge`,
 1 AS `MES_GTINLidl`,
 1 AS `MES_GTINKL`,
 1 AS `MES_Gewicht`,
 1 AS `MES_Einheit`,
 1 AS `MES_LSVCode`,
 1 AS `MES_LSVName`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MESOLsv` AS SELECT
 1 AS `MES_PPID`,
 1 AS `MES_Total`,
 1 AS `MES_StyleMenge`,
 1 AS `MES_StyleGewicht`,
 1 AS `MES_StyleNo`,
 1 AS `MES_KI`,
 1 AS `MES_StyleBezeichung`,
 1 AS `MES_SortMenge`,
 1 AS `MES_GTINLidl`,
 1 AS `MES_GTINKL`,
 1 AS `MES_Gewicht`,
 1 AS `MES_Einheit`,
 1 AS `MES_LSVCode`,
 1 AS `MES_LSVName`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MESPP` AS SELECT
 1 AS `MES_Status`,
 1 AS `MES_IAN`,
 1 AS `MES_Charge`,
 1 AS `MES_Artikel`,
 1 AS `MES_KI`,
 1 AS `MES_StyleNo`,
 1 AS `MES_StyleBezeichung`,
 1 AS `MES_StyleMenge`,
 1 AS `MES_StyleGewicht`,
 1 AS `MES_SortMenge`,
 1 AS `MES_GTINLidl`,
 1 AS `MES_GTINKL`,
 1 AS `MES_Gewicht`,
 1 AS `MES_Einheit`,
 1 AS `MES_LSVCode`,
 1 AS `MES_LSVName`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MESTotal` AS SELECT
 1 AS `MES_PPID`,
 1 AS `MES_Total`,
 1 AS `MES_StyleMenge`,
 1 AS `MES_StyleGewicht`,
 1 AS `MES_StyleNo`,
 1 AS `MES_KI`,
 1 AS `MES_StyleBezeichung`,
 1 AS `MES_SortMenge`,
 1 AS `MES_GTINLidl`,
 1 AS `MES_GTINKL`,
 1 AS `MES_Gewicht`,
 1 AS `MES_Einheit`,
 1 AS `MES_LSVCode`,
 1 AS `MES_LSVName`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MengenSpanien` AS SELECT
 1 AS `PPProduktpass_Menge_PPProduktpass_Id`,
 1 AS `ES`,
 1 AS `Menge`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Milestones` AS SELECT
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_SimDate`,
 1 AS `PPBoardSpalteData_IsExternDate`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `PPTermine_Status`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MilestonesShipmentoverview` AS SELECT
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `MS_EUG`,
 1 AS `MS_30PSI`,
 1 AS `MS_PSI`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_MitarbeiterProjekt` AS SELECT
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPBoardSpalte_PPBoard_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_OSLieferlaender` AS SELECT
 1 AS `PPProduktpass_Menge_Country`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_OSSortierung` AS SELECT
 1 AS `OSLaenderblock`,
 1 AS `PPProduktpass_Sortierung_Id`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Row`,
 1 AS `PPProduktpass_Sortierung_Value01`,
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `PPProduktpass_Sortierung_Value03`,
 1 AS `PPProduktpass_Sortierung_Value04`,
 1 AS `PPProduktpass_Sortierung_Value05`,
 1 AS `PPProduktpass_Sortierung_Value06`,
 1 AS `PPProduktpass_Sortierung_Value07`,
 1 AS `PPProduktpass_Sortierung_Value08`,
 1 AS `PPProduktpass_Sortierung_Value09`,
 1 AS `PPProduktpass_Sortierung_Value10`,
 1 AS `PPProduktpass_Sortierung_EAN`,
 1 AS `PPProduktpass_Sortierung_OSMengeDE`,
 1 AS `PPProduktpass_Sortierung_Translate_Design`,
 1 AS `PPProduktpass_Sortierung_EANOS`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPProduktpass_Sortierung_OSMengeBE`,
 1 AS `PPProduktpass_Sortierung_OSMengeNL`,
 1 AS `PPProduktpass_Sortierung_OSMengeCZ`,
 1 AS `PPProduktpass_Sortierung_OSMengeES`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_OWLsv` AS SELECT
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPLsv_name`,
 1 AS `PPLsv_countryCodes`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_OWLsvOLsv` AS SELECT
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_styleNo`,
 1 AS `PPOrderWeights_unit`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_PPProduktpass_Id`,
 1 AS `PPLsv_name`,
 1 AS `PPLsv_countryCodes`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PO` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPPurchase_Currency`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPPurchase_EK`,
 1 AS `PPPurchase_LC_TOP`,
 1 AS `PO_Wert`,
 1 AS `PPPurchase_ExcR_Calc`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_POWertNachMonaten` AS SELECT
 1 AS `Monat`,
 1 AS `Jahr`,
 1 AS `PO_Wert`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_POWertNachMonatenKummuliert` AS SELECT
 1 AS `EKUsdKum`,
 1 AS `Monat`,
 1 AS `Jahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_POinFW` AS SELECT
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPPurchase_Currency`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPPurchase_EK`,
 1 AS `PO_Wert`,
 1 AS `PPPurchase_ExcR_Calc`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPMengen` AS SELECT
 1 AS `v_PPMengen_PPProduktpass_Id`,
 1 AS `v_PPMengen_Menge`,
 1 AS `v_PPMengen_EKUSD`,
 1 AS `v_PPMengen_FOB_EK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPPU` AS SELECT
 1 AS `PPPurchase_Id`,
 1 AS `PPPurchase_PPProduktpass_Id`,
 1 AS `PPPurchase_LcNumber`,
 1 AS `PPPurchase_ScNumber`,
 1 AS `PPPurchase_Inquiry`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPPurchase_Currency`,
 1 AS `PPPurchase_ExcR`,
 1 AS `PPPurchase_ExcR_Date`,
 1 AS `PPPurchase_ExcR_Calc`,
 1 AS `PPPurchase_ExcR_Remark`,
 1 AS `PPPurchase_CustomsCode`,
 1 AS `PPPurchase_DutyPercentage`,
 1 AS `PPPurchase_DeliveryDate`,
 1 AS `PPPurchase_ResOffice`,
 1 AS `PPPurchase_Description`,
 1 AS `PPPurchase_Material`,
 1 AS `PPPurchase_Remark`,
 1 AS `PPPurchase_TermsOfDelivery`,
 1 AS `PPPurchase_TermsOfPayment`,
 1 AS `PPPurchase_Status`,
 1 AS `PPPurchase_PortOfDischarge`,
 1 AS `PPPurchase_Country`,
 1 AS `PPPurchase_OrderDate`,
 1 AS `PPPurchase_SupplierDelDate`,
 1 AS `PPPurchase_Factory`,
 1 AS `PPPurchase_EK_Calc`,
 1 AS `PPPurchase_EK`,
 1 AS `PPPurchase_Fracht`,
 1 AS `PPPurchase_Zoll`,
 1 AS `PPPurchase_EKProvision`,
 1 AS `PPPurchase_Ausgangsfrachten`,
 1 AS `PPPurchase_Finanzierungskosten`,
 1 AS `PPPurchase_Lizenzgebuehren`,
 1 AS `PPPurchase_Kosten`,
 1 AS `PPPurchase_Translate_Quality`,
 1 AS `PPPurchase_Translate_Projectdescription`,
 1 AS `PPPurchase_Translate_ManufacturingPlant`,
 1 AS `PPPurchase_Translate_Packaging`,
 1 AS `PPPurchase_SonstKostenProz`,
 1 AS `PPPurchase_BemerkungAenderungen`,
 1 AS `PPPurchase_ManufacturingPlant`,
 1 AS `PPPurchase_LC_TOP`,
 1 AS `PPPurchase_Pruefinstitut`,
 1 AS `PPPurchase_Transportdokumente`,
 1 AS `PPPurchase_Transportdokumente2`,
 1 AS `PPPurchase_BWGroesse`,
 1 AS `PPPurchase_FOBWeek`,
 1 AS `PPPurchase_FOBYear`,
 1 AS `PPPurchase_FOBSpecial`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPProduktpassReal` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `category`,
 1 AS `statusDoc`,
 1 AS `InternerStatus`,
 1 AS `updatedOn`,
 1 AS `createdOn`,
 1 AS `PPProduktpass_IsParent`,
 1 AS `PPProduktpass_IsChild`,
 1 AS `PPProduktpass_IsKaufland`,
 1 AS `PPProduktpass_IsUSA`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `PPProduktpass_Transferd2Sharepoint`,
 1 AS `PPProduktpass_SimNeu`,
 1 AS `PPProduktpass_ThemaScope`,
 1 AS `PPProduktpass_IsCriticalProject`,
 1 AS `PPProduktpass_linkedItemIan`,
 1 AS `PPProduktpass_linkedItemLotNo`,
 1 AS `PPProduktpass_PJMAdmin`,
 1 AS `PPProduktpass_PJMAdminVTR`,
 1 AS `PPProduktpass_ARTAdmin`,
 1 AS `PPProduktpass_ARTAdminVTR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPProduktpass_PPTermine` AS SELECT
 1 AS `Datesort`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `createdOn`,
 1 AS `updatedOn`,
 1 AS `category`,
 1 AS `statusDoc`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Art`,
 1 AS `PPTermine_Typ`,
 1 AS `PPTermine_MAAnlage`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `PPTermine_History`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `PPStati_Id`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_Color`,
 1 AS `PPStati_Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_IsUSA`,
 1 AS `PPPurchase_FOBYear`,
 1 AS `PPPurchase_FOBWeek`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalte_IsMilestone`,
 1 AS `PPProduktpass_IsParent`,
 1 AS `PPProduktpass_IsChild`,
 1 AS `PPProduktpass_IsKaufland`,
 1 AS `PPProduktpass_IsUSA`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPProduktpass_Transferd2Sharepoint`,
 1 AS `PPProduktpass_PJMAdmin`,
 1 AS `PPProduktpass_PJMAdminVTR`,
 1 AS `PPBoardspalteData_Kind`,
 1 AS `PPTermine_HistoryEN`,
 1 AS `PPTermine_BemerkungenEN`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_IsMPlan`,
 1 AS `PPProduktpass_ARTAdmin`,
 1 AS `PPProduktpass_ARTAdminVTR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPProduktpass_PPTermine2` AS SELECT
 1 AS `Datesort`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `createdOn`,
 1 AS `updatedOn`,
 1 AS `category`,
 1 AS `statusDoc`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Art`,
 1 AS `PPTermine_Typ`,
 1 AS `PPTermine_MAAnlage`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `PPTermine_History`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `PPStati_Id`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_Color`,
 1 AS `PPStati_Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_IsUSA`,
 1 AS `PPPurchase_FOBYear`,
 1 AS `PPPurchase_FOBWeek`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalte_IsMilestone`,
 1 AS `PPProduktpass_IsParent`,
 1 AS `PPProduktpass_IsChild`,
 1 AS `PPProduktpass_IsKaufland`,
 1 AS `PPProduktpass_IsUSA`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPProduktpass_Transferd2Sharepoint`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPProduktpass_PPTermineZ1` AS SELECT
 1 AS `Datesort`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPProduktpass_StepNeeded`,
 1 AS `PPProduktpass_BSCINeeded`,
 1 AS `PPProduktpass_IsMusterung`,
 1 AS `updatedOn`,
 1 AS `category`,
 1 AS `statusDoc`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Art`,
 1 AS `PPTermine_Typ`,
 1 AS `PPTermine_MAAnlage`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `PPTermine_History`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `PPStati_Id`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_Color`,
 1 AS `PPStati_Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_IsUSA`,
 1 AS `PPPurchase_FOBYear`,
 1 AS `PPPurchase_FOBWeek`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalte_IsMilestone`,
 1 AS `PPProduktpass_IsParent`,
 1 AS `PPProduktpass_IsChild`,
 1 AS `PPProduktpass_IsKaufland`,
 1 AS `PPProduktpass_IsUSA`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_ArtikelTarga`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPProduktpass_Transferd2Sharepoint`,
 1 AS `PPProduktpass_SimNeu`,
 1 AS `PPProduktpass_ThemaScope`,
 1 AS `PPProduktpass_IsCriticalProject`,
 1 AS `PPProduktpass_linkedItemIAN`,
 1 AS `PPProduktpass_linkedItemLotNo`,
 1 AS `PPProduktpass_PJMAdmin`,
 1 AS `PPProduktpass_PJMAdminVTR`,
 1 AS `PPTermine_BemerkungenEN`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_HistoryEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPStyleHeader` AS SELECT
 1 AS `PPProduktpass_Style_PPProduktpass_Id`,
 1 AS `Header`,
 1 AS `Style`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPTCKosten` AS SELECT
 1 AS `PPTCKosten_Id`,
 1 AS `PPTCKosten_Number`,
 1 AS `PPTCKosten_PPProduktpass_Id`,
 1 AS `PPTCKosten_PPKostenTypen_Id`,
 1 AS `PPTCKosten_PrototypeAnzahl`,
 1 AS `PPTCKosten_TrialRunAnzahl`,
 1 AS `PPTCKosten_MPAnzahl`,
 1 AS `PPTCKosten_Einzelkosten`,
 1 AS `PPTCKosten_Bemerkung`,
 1 AS `PPTCKosten_Bezeichnung`,
 1 AS `PPTCKostenTypen_Id`,
 1 AS `PPTCKostenTypen_Bezeichnung`,
 1 AS `PPTCKostenTypen_StandardKosten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPTerminePopUp` AS SELECT
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalteX_Sort`,
 1 AS `PPBoardSpalteData_Kind`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PPUebersicht` AS SELECT
 1 AS `Ausmusterungnummer`,
 1 AS `IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `Artikelbezeichnung`,
 1 AS `LieferterminWoche`,
 1 AS `LieferterminJahr`,
 1 AS `EKWaehrung`,
 1 AS `Supplier`,
 1 AS `EK`,
 1 AS `PO_Wert`,
 1 AS `ProjektBild`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PreisgruppenHafen` AS SELECT
 1 AS `PPHaefen_Id`,
 1 AS `PPHaefen_Nr`,
 1 AS `PPHaefen_Name`,
 1 AS `PPHaefen_PreisGruppe`,
 1 AS `PPAbgangshafen_Id`,
 1 AS `PPAbgangshafen_Hafen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ProjekteIan` AS SELECT
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_PPProjekte_Projekt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PurchaseDistinct` AS SELECT
 1 AS `PPPurchase_PPProduktpass_Id`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPPurchase_Currency`,
 1 AS `PPPurchase_ExcR_Calc`,
 1 AS `PPPurchase_EK`,
 1 AS `PPPurchase_LC_TOP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PurchaseLast` AS SELECT
 1 AS `PPPurchase_Id`,
 1 AS `PPPurchase_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_PurchaseWerte` AS SELECT
 1 AS `v_PPMengen_PPProduktpass_Id`,
 1 AS `PO_Wert`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_QM4Inquiry` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_Ausmusterung`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_AltIAN`,
 1 AS `PPProduktpass_AltArtikelbezeichnung`,
 1 AS `PPProduktpass_Warengruppe`,
 1 AS `PPProduktpass_Neu_Warengruppe`,
 1 AS `PPProduktpass_Verpackungseinheit`,
 1 AS `PPProduktpass_Thema`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_Einkaeufer`,
 1 AS `PPProduktpass_Marke`,
 1 AS `PPProduktpass_Gesamtmenge`,
 1 AS `PPProduktpass_Pruefinstitut`,
 1 AS `PPProduktpass_Andere_Kriterien`,
 1 AS `PPProduktpass_Zertifizierungen`,
 1 AS `PPProduktpass_Logos`,
 1 AS `PPProduktpass_Verkaufsverpackung`,
 1 AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,
 1 AS `PPProduktpass_Agentur`,
 1 AS `PPProduktpass_PPProjekte_Id`,
 1 AS `PPProduktpass_Material`,
 1 AS `PPProduktpass_Lizenz`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_AktExcel`,
 1 AS `PPProduktpass_VorExcel`,
 1 AS `PPProduktpass_Importart`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_VorIAN`,
 1 AS `PPProduktpass_Konstruktion`,
 1 AS `PPProduktpass_Verarbeitung`,
 1 AS `PPProduktpass_ZBV1_Name`,
 1 AS `PPProduktpass_ZBV1_Wert`,
 1 AS `PPProduktpass_ZBV2_Name`,
 1 AS `PPProduktpass_ZBV2_Wert`,
 1 AS `PPProduktpass_ZBV3_Name`,
 1 AS `PPProduktpass_ZBV3_Wert`,
 1 AS `PPProduktpass_ZBV4_Name`,
 1 AS `PPProduktpass_ZBV4_Wert`,
 1 AS `PPProduktpass_ZBV5_Name`,
 1 AS `PPProduktpass_ZBV5_Wert`,
 1 AS `PPProduktpass_Produkt_ZusatzGSM`,
 1 AS `PPProduktpass_Produkt_Laenge`,
 1 AS `PPProduktpass_Produkt_Breite`,
 1 AS `PPProduktpass_Produkt_Hoehe`,
 1 AS `PPProduktpass_Produkt_GSM`,
 1 AS `PPProduktpass_WAWIArtikelnummer`,
 1 AS `PPProduktpass_IsRevision`,
 1 AS `PPProduktpass_RevisionArt`,
 1 AS `PPProduktpass_Revisionsnummer`,
 1 AS `PPProduktpass_RevisionAktuell`,
 1 AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,
 1 AS `PPProduktpass_RevisionDatum`,
 1 AS `PPProduktpass_ProjektBild`,
 1 AS `PPProduktpass_VersandfaehigeUmverpackung`,
 1 AS `PPProduktpass_RFSicherung`,
 1 AS `PPProduktpass_Passformlabel`,
 1 AS `PPProduktpass_AndereTestkriterien`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften2`,
 1 AS `PPProduktpass_GarantiezeitDauer`,
 1 AS `PPProduktpass_GarentieArt`,
 1 AS `PPProduktpass_LogoDruckverfahren`,
 1 AS `PPProduktpass_Import_BISUser_Id`,
 1 AS `PPProduktpass_Import_Datum`,
 1 AS `PPProduktpass_Logos2`,
 1 AS `PPProduktpass_Logos3`,
 1 AS `PPProduktpass_Positionierung`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften3`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften4`,
 1 AS `PPProduktpass_ZertifizierungEigenschaften5`,
 1 AS `PPProduktpass_Logos4`,
 1 AS `PPProduktpass_Logos5`,
 1 AS `PPProduktpass_Bemerkung`,
 1 AS `PPProduktpass_Charge`,
 1 AS `PPProduktpass_AltCharge`,
 1 AS `PPProduktpass_KAT`,
 1 AS `PPProduktpass_BZP`,
 1 AS `PPProduktpass_MOQ`,
 1 AS `PPProduktpass_InitialeCharge`,
 1 AS `PPProduktpass_Erstbestellung`,
 1 AS `PPProduktpass_IsInquiry`,
 1 AS `PPProduktpass_InquiryArt`,
 1 AS `PPPurchase_Id`,
 1 AS `PPPurchase_PPProduktpass_Id`,
 1 AS `PPPurchase_LcNumber`,
 1 AS `PPPurchase_ScNumber`,
 1 AS `PPPurchase_Inquiry`,
 1 AS `PPPurchase_Supplier`,
 1 AS `PPPurchase_Currency`,
 1 AS `PPPurchase_ExcR_Save`,
 1 AS `PPPurchase_ExcR_Save_Date`,
 1 AS `PPPurchase_ExcR_Calc`,
 1 AS `PPPurchase_ExcR_Remark`,
 1 AS `PPPurchase_CustomsCode`,
 1 AS `PPPurchase_DutyPercentage`,
 1 AS `PPPurchase_DeliveryDate`,
 1 AS `PPPurchase_ResOffice`,
 1 AS `PPPurchase_Description`,
 1 AS `PPPurchase_Material`,
 1 AS `PPPurchase_Remark`,
 1 AS `PPPurchase_TermsOfDelivery`,
 1 AS `PPPurchase_TermsOfPayment`,
 1 AS `PPPurchase_Status`,
 1 AS `PPPurchase_PortOfDischarge`,
 1 AS `PPPurchase_Country`,
 1 AS `PPPurchase_OrderDate`,
 1 AS `PPPurchase_SupplierDelDate`,
 1 AS `PPPurchase_Factory`,
 1 AS `PPPurchase_EK_Calc`,
 1 AS `PPPurchase_EK`,
 1 AS `PPPurchase_Fracht`,
 1 AS `PPPurchase_Zoll`,
 1 AS `PPPurchase_EKProvision`,
 1 AS `PPPurchase_Ausgangsfrachten`,
 1 AS `PPPurchase_Finanzierungskosten`,
 1 AS `PPPurchase_Lizenzgebuehren`,
 1 AS `PPPurchase_Kosten`,
 1 AS `PPPurchase_Translate_Quality`,
 1 AS `PPPurchase_Translate_Projectdescription`,
 1 AS `PPPurchase_Translate_ManufacturingPlant`,
 1 AS `PPPurchase_Translate_Packaging`,
 1 AS `PPPurchase_SonstKostenProz`,
 1 AS `PPPurchase_BemerkungAenderungen`,
 1 AS `PPPurchase_ManufacturingPlant`,
 1 AS `PPPurchase_LC_TOP`,
 1 AS `PPPurchase_Pruefinstitut`,
 1 AS `PPPurchase_Transportdokumente`,
 1 AS `PPPurchase_Transportdokumente2`,
 1 AS `PPPurchase_BWGroesse`,
 1 AS `PPPurchase_FOBWeek`,
 1 AS `PPPurchase_FOBYear`,
 1 AS `PPPurchase_FOBSpecial`,
 1 AS `PPPurchase_ExcR`,
 1 AS `PPPurchase_ExcR_Date`,
 1 AS `QMBerechnung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_QMBerechnung` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `QMBerechnung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_QualitaetAnlage` AS SELECT
 1 AS `Style`,
 1 AS `Value`,
 1 AS `ValueNo`,
 1 AS `PPProduktpass_Qualitaet_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_QualitaetDistinct` AS SELECT
 1 AS `Value`,
 1 AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,
 1 AS `Style`,
 1 AS `ValueArt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ServiceAnfrage` AS SELECT
 1 AS `PPInputManuell_Id`,
 1 AS `PPInputManuell_PPProduktpass_Id`,
 1 AS `Supplier`,
 1 AS `POD`,
 1 AS `Final`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Shipmentoverview` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `Ausmusterung`,
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `TotalQuantity`,
 1 AS `TargaStatus`,
 1 AS `LidlStatus`,
 1 AS `TCAdmin`,
 1 AS `PMAdmin`,
 1 AS `PJMAdmin`,
 1 AS `Lot`,
 1 AS `POA`,
 1 AS `SaleUnit`,
 1 AS `LotQuantity`,
 1 AS `LT`,
 1 AS `Supplier`,
 1 AS `POD`,
 1 AS `INCOTERM`,
 1 AS `HSCode`,
 1 AS `MS_EUG`,
 1 AS `MS_30PSI`,
 1 AS `MS_PSI`,
 1 AS `PPShipment_Id`,
 1 AS `PPShipment_Forwarder`,
 1 AS `PPShipment_Carrier`,
 1 AS `PPShipment_Lot`,
 1 AS `PPShipment_Vessel`,
 1 AS `PPShipment_Voyage`,
 1 AS `PPShipment_ENS`,
 1 AS `PPShipment_CYClosing`,
 1 AS `PPShipment_ETD`,
 1 AS `PPShipment_ETA`,
 1 AS `PPShipment_ShipReleaseGiven`,
 1 AS `PPShipment_ShipReleaseCalc`,
 1 AS `PPShipment_CRDGiven`,
 1 AS `PPShipment_CRDOpeningCalc`,
 1 AS `PPShipment_CRDClosingCalc`,
 1 AS `PPShipment_UnloadingReportDate`,
 1 AS `PPShipment_20ftGP`,
 1 AS `PPShipment_40ftGP`,
 1 AS `PPShipment_40ftHQ`,
 1 AS `PPShipment_LCLCBM`,
 1 AS `PPShipment_20ftGPCalc`,
 1 AS `PPShipment_40ftGPCalc`,
 1 AS `PPShipment_40ftHQCalc`,
 1 AS `PPShipment_CurrentStatus`,
 1 AS `PPShipment_BLForm`,
 1 AS `PPShipment_LCOA`,
 1 AS `PPShipment_ProducerBooking`,
 1 AS `PPShipment_ShipRelease`,
 1 AS `PPShipment_SO`,
 1 AS `PPShipment_BL`,
 1 AS `PPShipment_Invoce`,
 1 AS `PPShipment_PL`,
 1 AS `PPShipment_CoO`,
 1 AS `PPShipment_DeclarationFumigation`,
 1 AS `PPShipment_OceanFreight`,
 1 AS `PPShipment_PL2MaWi`,
 1 AS `PPShipment_CLPSent`,
 1 AS `PPShipment_SeaFreightInvoice`,
 1 AS `PPShipment_TransportInvoice`,
 1 AS `PPShipment_UnloadingInvoice`,
 1 AS `PPShipment_OtherLogisticalCosts`,
 1 AS `PPShipment_CCCsent`,
 1 AS `PPShipment_CustomsInvoice`,
 1 AS `PPShipment_CustomsDeclared`,
 1 AS `PPShipment_HSCode`,
 1 AS `PPShipment_ProjektCount`,
 1 AS `PPShipment_TEU`,
 1 AS `PPShipment_VKStk`,
 1 AS `PPShipment_VKSumme`,
 1 AS `PPShipment_DistancePort2Port`,
 1 AS `PPShipment_INCOTERM`,
 1 AS `PPShipment_LT`,
 1 AS `PPShipment_MS_30PSI`,
 1 AS `PPShipment_MS_EUG`,
 1 AS `PPShipment_MS_PSI`,
 1 AS `PPShipment_POA`,
 1 AS `PPShipment_POD`,
 1 AS `PPShipment_SaleUnit`,
 1 AS `PPShipment_Supplier`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ShipmentoverviewKopf` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `Ausmusterung`,
 1 AS `IAN`,
 1 AS `Artikelbezeichnung`,
 1 AS `TotalQuantity`,
 1 AS `TargaStatus`,
 1 AS `LidlStatus`,
 1 AS `TCAdmin`,
 1 AS `PMAdmin`,
 1 AS `PJMAdmin`,
 1 AS `LogAdmin`,
 1 AS `Supplier`,
 1 AS `POD`,
 1 AS `INCOTERM`,
 1 AS `HSCode`,
 1 AS `MS_EUG`,
 1 AS `MS_30PSI`,
 1 AS `MS_PSI`,
 1 AS `Archived`,
 1 AS `Complete`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ShipmentoverviewShipments` AS SELECT
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPShipment_Id`,
 1 AS `PPShipment_Forwarder`,
 1 AS `PPShipment_Carrier`,
 1 AS `PPShipment_Lot`,
 1 AS `PPShipment_Vessel`,
 1 AS `PPShipment_Voyage`,
 1 AS `PPShipment_ENS`,
 1 AS `PPShipment_CYClosing`,
 1 AS `PPShipment_ETD`,
 1 AS `PPShipment_ETA`,
 1 AS `PPShipment_ShipReleaseGiven`,
 1 AS `PPShipment_ShipReleaseCalc`,
 1 AS `PPShipment_CRDGiven`,
 1 AS `PPShipment_CRDOpeningCalc`,
 1 AS `PPShipment_CRDClosingCalc`,
 1 AS `PPShipment_UnloadingReportDate`,
 1 AS `PPShipment_20ftGP`,
 1 AS `PPShipment_40ftGP`,
 1 AS `PPShipment_40ftHQ`,
 1 AS `PPShipment_LCLCBM`,
 1 AS `PPShipment_20ftGPCalc`,
 1 AS `PPShipment_40ftGPCalc`,
 1 AS `PPShipment_40ftHQCalc`,
 1 AS `PPShipment_CurrentStatus`,
 1 AS `PPShipment_BLForm`,
 1 AS `PPShipment_LCOA`,
 1 AS `PPShipment_ProducerBooking`,
 1 AS `PPShipment_ShipRelease`,
 1 AS `PPShipment_SO`,
 1 AS `PPShipment_BL`,
 1 AS `PPShipment_Invoce`,
 1 AS `PPShipment_PL`,
 1 AS `PPShipment_CoO`,
 1 AS `PPShipment_DeclarationFumigation`,
 1 AS `PPShipment_OceanFreight`,
 1 AS `PPShipment_PL2MaWi`,
 1 AS `PPShipment_CLPSent`,
 1 AS `PPShipment_SeaFreightInvoice`,
 1 AS `PPShipment_TransportInvoice`,
 1 AS `PPShipment_UnloadingInvoice`,
 1 AS `PPShipment_OtherLogisticalCosts`,
 1 AS `PPShipment_CCCsent`,
 1 AS `PPShipment_CustomsInvoice`,
 1 AS `PPShipment_CustomsDeclared`,
 1 AS `PPShipment_HSCode`,
 1 AS `PPShipment_ProjektCount`,
 1 AS `PPShipment_TEU`,
 1 AS `PPShipment_VKStk`,
 1 AS `PPShipment_VKSumme`,
 1 AS `PPShipment_DistancePort2Port`,
 1 AS `PPShipment_Incoterm`,
 1 AS `PPShipment_LT`,
 1 AS `PPShipment_MS_30PSI`,
 1 AS `PPShipment_MS_EUG`,
 1 AS `PPShipment_MS_PSI`,
 1 AS `PPShipment_POA`,
 1 AS `PPShipment_POD`,
 1 AS `PPShipment_SaleUnit`,
 1 AS `PPShipment_Supplier`,
 1 AS `PPShipment_Status`,
 1 AS `PPShipment_Quantity`,
 1 AS `PPShipment_Flag_Producer_booking`,
 1 AS `PPShipment_Flag_Shipment_Release`,
 1 AS `PPShipment_Flag_SO`,
 1 AS `PPShipment_Flag_BL`,
 1 AS `PPShipment_Flag_Inv`,
 1 AS `PPShipment_Flag_PL`,
 1 AS `PPShipment_Flag_CoO`,
 1 AS `PPShipment_Flag_Declaration_of_Fumigation`,
 1 AS `PPShipment_Flag_Ocean_Freight`,
 1 AS `PPShipment_Flag_PL_sent_to_MaWi`,
 1 AS `PPShipment_Flag_CLP_sent`,
 1 AS `PPShipment_Flag_Sea_freight_invoice`,
 1 AS `PPShipment_Flag_Transport_invoice`,
 1 AS `PPShipment_Flag_Unloading_invoice`,
 1 AS `PPShipment_Flag_Other_logistical_costs`,
 1 AS `PPShipment_Flag_CCC_sent`,
 1 AS `PPShipment_Flag_customs_invoice`,
 1 AS `PPShipment_Flag_OS`,
 1 AS `PPShipment_Flag_EUService`,
 1 AS `PPShipment_Flag_Critical`,
 1 AS `PPShipment_BatteryType`,
 1 AS `PPShipment_MasterCartonContents`,
 1 AS `PPShipment_ATAInlandsterminal`,
 1 AS `PPShipment_ZipCodeFactory`,
 1 AS `PPShipment_Sortierung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_SortierungOrderWeights` AS SELECT
 1 AS `PPProduktpass_Sortierung_PPProduktpass_Id`,
 1 AS `PPProduktpass_Sortierung_Header`,
 1 AS `PPProduktpass_Sortierung_Value01`,
 1 AS `PPProduktpass_Sortierung_Value02`,
 1 AS `PPProduktpass_Sortierung_Laenderblock`,
 1 AS `PPOrderWeights_gtin`,
 1 AS `PPOrderWeights_gtinKL`,
 1 AS `PPOrderWeights_lsv`,
 1 AS `PPOrderWeights_weight`,
 1 AS `PPOrderWeights_unit`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_StyleSizeAndWeight` AS SELECT
 1 AS `PPProduktpass_Style_PPProduktpass_Id`,
 1 AS `sizeWithoutPackaging`,
 1 AS `weightWithoutPackaging`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TempPPLiefertermine` AS SELECT
 1 AS `PPId`,
 1 AS `StatusDocLIDL`,
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `LWausThema`,
 1 AS `LaenderLT`,
 1 AS `PPLTWoche`,
 1 AS `PPLTJahr`,
 1 AS `CRDWoche`,
 1 AS `CRDJahr`,
 1 AS `PPProduktpass_Thema`,
 1 AS `InternerStatus`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminSpalten` AS SELECT
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Stati`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_DefaultMA`,
 1 AS `PPBoardSpalte_DFTable`,
 1 AS `PPBoardSpalte_DFField`,
 1 AS `PPBoardSpalte_Remark`,
 1 AS `PPBoardSpalteData_Kind`,
 1 AS `PPBoardSpalte_IsMilestone`,
 1 AS `PPBoardSpalte_IsUSA`,
 1 AS `PPBoardSpalteData_Nachbestellung`,
 1 AS `PPBoardSpalteData_Child_nB`,
 1 AS `PPBoardSpalteData_HilfeStatusOK`,
 1 AS `PPBoardSpalteData_HifeStatusInArbeit`,
 1 AS `PPBoardSpalteData_HilfeStatusNOK`,
 1 AS `PPBoardSpalteX_Id`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalteX_PPBoardSpalte_Id`,
 1 AS `PPBoardSpalteX_Sort`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Termine` AS SELECT
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Typ`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPStati_Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TermineAll` AS SELECT
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Art`,
 1 AS `PPTermine_Typ`,
 1 AS `PPTermine_MAAnlage`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `PPTermine_History`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `PPStati_Id`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_Color`,
 1 AS `PPStati_Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Id`,
 1 AS `PPBoardSpalte_IsUSA`,
 1 AS `PPBoardSpalte_PPBoard_Id`,
 1 AS `PPBoardSpalte_IsMilestone`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TermineII` AS SELECT
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Typ`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPStati_Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `CRD`,
 1 AS `ErlBisDefault`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TermineMitChanges` AS SELECT
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPBoard_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPTermine_Header`,
 1 AS `PPTermine_Status`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermineChanges_Date`,
 1 AS `PPTermineChanges_Remark`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_oldStatus`,
 1 AS `PPTermineChanges_newStatus`,
 1 AS `PPTermineChanges_Mitarbeiter_Id`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPTermineChanges_Receiver`,
 1 AS `PPTermineChanges_PPPPFilesId`,
 1 AS `PPTermineChanges_ParentId`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_Terminliste` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermineChanges_PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `Status`,
 1 AS `Background`,
 1 AS `OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermineChanges_RemarkReceiver`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteC` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermineChanges_PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `Status`,
 1 AS `OKStatus`,
 1 AS `Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermineChanges_RemarkReceiver`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteFIX` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermineChanges_PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `Status`,
 1 AS `Background`,
 1 AS `OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteII` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermineChanges_PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `Status`,
 1 AS `Background`,
 1 AS `OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `ErlBis`,
 1 AS `ErlBisDefault`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteInq` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPTermine_Status`,
 1 AS `Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteMU` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_Status`,
 1 AS `PPTermine_Status`,
 1 AS `Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_CRDJahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlistePLAN` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermineChanges_PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `Status`,
 1 AS `Background`,
 1 AS `OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlistePP` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PM_Vtr`,
 1 AS `PM`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `TC_Vtr`,
 1 AS `TC`,
 1 AS `PPProduktpass_Status`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Status`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `DateMilestone1`,
 1 AS `DateMilestone`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlistePP_2` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PM_Vtr`,
 1 AS `PM`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `TC_Vtr`,
 1 AS `TC`,
 1 AS `PPProduktpass_Status`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Status`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `DateMilestone`,
 1 AS `DateMilestone1`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `CRD`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermineChanges_RemarkReceiver`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlistePP_2FIX` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PM_Vtr`,
 1 AS `PM`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `TC_Vtr`,
 1 AS `TC`,
 1 AS `PPProduktpass_Status`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Status`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `DateMilestone`,
 1 AS `DateMilestone1`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `CRD`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlistePP_2PLAN` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermineChanges_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `PPMitarbeiter_Taetigkeit`,
 1 AS `PPTermineChanges_Categorie`,
 1 AS `PPTermineChanges_DoUntil`,
 1 AS `PPTermineChanges_DoneAt`,
 1 AS `PPProduktpass_Id`,
 1 AS `PPProduktpass_IAN`,
 1 AS `PPProduktpass_Ausmusterungnummer`,
 1 AS `PPProduktpass_Liefertermin`,
 1 AS `PPProduktpass_LieferterminJahr`,
 1 AS `PPProduktpass_Artikelbezeichnung`,
 1 AS `PPProduktpass_PPProjekte_Projekt`,
 1 AS `PPProduktpass_PMAdmin`,
 1 AS `PPProduktpass_PMAdminVTR`,
 1 AS `PM_Vtr`,
 1 AS `PM`,
 1 AS `PPProduktpass_TCAdmin`,
 1 AS `PPProduktpass_TCAdminVTR`,
 1 AS `TC_Vtr`,
 1 AS `TC`,
 1 AS `PPProduktpass_Status`,
 1 AS `InternerStatus`,
 1 AS `PPTermine_Status`,
 1 AS `PPProduktpass_CRDWoche`,
 1 AS `PPProduktpass_CRDJahr`,
 1 AS `Background`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `DateMilestone`,
 1 AS `DateMilestone1`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `CRD`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteT` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `Hauptaufgabe`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPStati_Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteTFIX` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `Hauptaufgabe`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPStati_Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteTII` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `Hauptaufgabe`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPStati_Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `ErlBis`,
 1 AS `CRD`,
 1 AS `ErlBisDefault`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_TerminlisteTPLAN` AS SELECT
 1 AS `Type`,
 1 AS `PPBoardSpalte_Bezeichnung`,
 1 AS `PPTermineChanges_Id`,
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_PPProduktpass_Id`,
 1 AS `PPMitarbeiter_Kuerzel`,
 1 AS `Hauptaufgabe`,
 1 AS `PPTermine_DatumStart`,
 1 AS `PPTermine_DatumEnde`,
 1 AS `PPStati_Status`,
 1 AS `PPStati_OKStatus`,
 1 AS `PPStati_Background`,
 1 AS `PPBoardSpalte_Orange`,
 1 AS `PPBoardSpalte_Rot`,
 1 AS `PPBoardSpalte_Oberbez`,
 1 AS `PPTermine_ManSoll`,
 1 AS `PPTermine_PPBoardSpalte_id`,
 1 AS `Bemerkung`,
 1 AS `PPTermine_ManSollDate`,
 1 AS `ErlBis`,
 1 AS `PPTermine_Label`,
 1 AS `PPTermine_Bemerkungen`,
 1 AS `PPTermine_LabelEN`,
 1 AS `PPTermine_BemerkungenEN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_USDBedarfnachMonaten` AS SELECT
 1 AS `UsdKum`,
 1 AS `Monat`,
 1 AS `Jahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_USDUngedeckt` AS SELECT
 1 AS `USDUngedeckt`,
 1 AS `Monat`,
 1 AS `Jahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ZuAbgang` AS SELECT
 1 AS `IAN`,
 1 AS `PPProduktpass_Id`,
 1 AS `TOP`,
 1 AS `ZugangJahr`,
 1 AS `ZugangMonat`,
 1 AS `ZahlungKunde`,
 1 AS `VKGesamt`,
 1 AS `AbgangJahr`,
 1 AS `AbgangMonat`,
 1 AS `Faelligkeit`,
 1 AS `EKGesamt`,
 1 AS `EKWaehrung`,
 1 AS `AbgangLCJahr`,
 1 AS `AbgangLCMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ZuAbgangDTK` AS SELECT
 1 AS `Jahr`,
 1 AS `Monat`,
 1 AS `ZugangUSD`,
 1 AS `AbgangEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_ZugangVK` AS SELECT
 1 AS `Zugang`,
 1 AS `ZugangJahr`,
 1 AS `ZugangMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_lastStatusChange` AS SELECT
 1 AS `IAN`,
 1 AS `Charge`,
 1 AS `Aenderung`,
 1 AS `DatumStatusAenderung`,
 1 AS `Alter_Status`,
 1 AS `Neuer_Status`,
 1 AS `Mitarbeiter`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE VIEW `v_offeneTermineMitMa` AS SELECT
 1 AS `PPTermine_Id`,
 1 AS `PPTermine_MAZustaendigkeit`,
 1 AS `PPBoardSpalteData_Kind`;
TARGA_BASELINE_SQL
        ];
    }

    /** @return list<string> */
    private function finalViewStatements(): array
    {
        return [
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `8WMuster`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `8WMuster` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`PPProduktpass_Menge`.`PPProduktpass_Menge_8WMuster` AS `PPProduktpass_Menge_8WMuster`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity` from `PPProduktpass_Menge` where (`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity` > 0);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `ArtikelMitBestand`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `ArtikelMitBestand` AS select `artikelstamm`.`artikelstamm_id` AS `artikelstamm_id`,`artikelstamm`.`artikelnummer` AS `artikelnummer`,`artikelstamm`.`Matchcode` AS `Matchcode`,`artikelstamm`.`Bezeichnung1` AS `Bezeichnung1`,`artikelstamm`.`Bezeichnung2` AS `Bezeichnung2`,`artikelstamm`.`created_at` AS `created_at`,`artikelstamm`.`updated_at` AS `updated_at`,`artikelstamm`.`IstAktiv` AS `IstAktiv`,`artikelstamm`.`MengeneinheitVK` AS `MengeneinheitVK`,`artikelstamm`.`MengeneinheitEK` AS `MengeneinheitEK`,`artikelstamm`.`MengeneinheitLager` AS `MengeneinheitLager`,`artikelstamm`.`Langtext` AS `Langtext`,`artikelstamm`.`Hauptgruppe` AS `Hauptgruppe`,`artikelstamm`.`Untergruppe` AS `Untergruppe`,`artikelstamm`.`MengeneinheitBasis` AS `MengeneinheitBasis`,`artikelstamm`.`EKMeenthaeltBMe` AS `EKMeenthaeltBMe`,`artikelstamm`.`VKMeenthaeltBMe` AS `VKMeenthaeltBMe`,`artikelstamm`.`LMeenthaeltBMe` AS `LMeenthaeltBMe`,`artikelstamm`.`PreisEinstand` AS `PreisEinstand`,`artikelstamm`.`PreisEKStandard` AS `PreisEKStandard`,`artikelstamm`.`PreisDurchschnittEK` AS `PreisDurchschnittEK`,`artikelstamm`.`PreisLEK` AS `PreisLEK`,`artikelstamm`.`IstBestandsgefuehrt` AS `IstBestandsgefuehrt`,`artikelstamm`.`IstChargengefuehrt` AS `IstChargengefuehrt`,`artikelstamm`.`PreisVK` AS `PreisVK`,`artikelstamm`.`PreisVKAlt` AS `PreisVKAlt`,`artikelstamm`.`BerechnungDB` AS `BerechnungDB`,`artikelstamm`.`IstProvisionsfaehig` AS `IstProvisionsfaehig`,`artikelstamm`.`IstBonusfaehig` AS `IstBonusfaehig`,`artikelstamm`.`ErloesKonto` AS `ErloesKonto`,`artikelstamm`.`Steuercode` AS `Steuercode`,`artikelstamm`.`Kostenstelle` AS `Kostenstelle`,`artikelstamm`.`Kostentraeger` AS `Kostentraeger`,`artikelstamm`.`MasseBMeLaenge` AS `MasseBMeLaenge`,`artikelstamm`.`MasseBMeBreite` AS `MasseBMeBreite`,`artikelstamm`.`MasseBMeHoehe` AS `MasseBMeHoehe`,`artikelstamm`.`MasseEkMeLaenge` AS `MasseEkMeLaenge`,`artikelstamm`.`MasseEkMeBreite` AS `MasseEkMeBreite`,`artikelstamm`.`MasseEkMeHoehe` AS `MasseEkMeHoehe`,`artikelstamm`.`MasseVkMeLaenge` AS `MasseVkMeLaenge`,`artikelstamm`.`MasseVkMeBreite` AS `MasseVkMeBreite`,`artikelstamm`.`MasseVkMeHoehe` AS `MasseVkMeHoehe`,`artikelstamm`.`MasseLMeLaenge` AS `MasseLMeLaenge`,`artikelstamm`.`MasseLMeBreite` AS `MasseLMeBreite`,`artikelstamm`.`MasseLMeHoehe` AS `MasseLMeHoehe`,`artikelstamm`.`Warennummer` AS `Warennummer`,`artikelstamm`.`Warenbezeichnung` AS `Warenbezeichnung`,`artikelstamm`.`BesondereMasseinheit` AS `BesondereMasseinheit`,`artikelstamm`.`Umrechnungsfaktor` AS `Umrechnungsfaktor`,`artikelstamm`.`EigenmasseIn` AS `EigenmasseIn`,`artikelstamm`.`Eigenmassefaktor` AS `Eigenmassefaktor`,`artikelstamm`.`Ursprungsland` AS `Ursprungsland`,`artikelstamm`.`Steuerschluessel` AS `Steuerschluessel`,`artikelstamm`.`ZollTarif` AS `ZollTarif`,`artikelstamm`.`ZollProzent` AS `ZollProzent`,`artikelstamm`.`ZollImport` AS `ZollImport`,`artikelstamm`.`ZollLand` AS `ZollLand`,`artikelstamm`.`Warenzusammensetzung` AS `Warenzusammensetzung`,`artikelstamm`.`ABCKlasse` AS `ABCKlasse`,`artikelstamm`.`Qual_Qualitaet` AS `Qual_Qualitaet`,`artikelstamm`.`Qual_Material1` AS `Qual_Material1`,`artikelstamm`.`Qual_Material2` AS `Qual_Material2`,`artikelstamm`.`Qual_Farbe` AS `Qual_Farbe`,`artikelstamm`.`Qual_Groesse` AS `Qual_Groesse`,`artikelstamm`.`Qual_Design` AS `Qual_Design`,`artikelstamm`.`Qual_gsm` AS `Qual_gsm`,`artikelstamm`.`KnzLizenz` AS `KnzLizenz`,`artikelstamm`.`EAN_Code` AS `EAN_Code`,`artikelstamm`.`Statistiknummer` AS `Statistiknummer`,`artikelstamm`.`MasseBMeGewichtBrutto` AS `MasseBMeGewichtBrutto`,`artikelstamm`.`MasseEkMeGewichtBrutto` AS `MasseEkMeGewichtBrutto`,`artikelstamm`.`MasseVkMeGewichtBrutto` AS `MasseVkMeGewichtBrutto`,`artikelstamm`.`MasseLMeGewichtBrutto` AS `MasseLMeGewichtBrutto`,`artikelstamm`.`MasseBMeGewichtNetto` AS `MasseBMeGewichtNetto`,`artikelstamm`.`MasseEkMeGewichtNetto` AS `MasseEkMeGewichtNetto`,`artikelstamm`.`MasseVkMeGewichtNetto` AS `MasseVkMeGewichtNetto`,`artikelstamm`.`MasseLMeGewichtNetto` AS `MasseLMeGewichtNetto`,`artikelstamm`.`Zollnummer` AS `Zollnummer`,`artikelstamm`.`TextUebernahme` AS `TextUebernahme`,`lagerbestand`.`artikel_id` AS `artikel_id`,`lagerbestand`.`bestand` AS `bestand` from (`artikelstamm` left join `lagerbestand` on((`artikelstamm`.`artikelstamm_id` = `lagerbestand`.`artikel_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHaWareneinsatz`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHaWareneinsatz` AS select concat(`PP`.`PPProduktpass_Liefertermin`,'/',`PP`.`PPProduktpass_LieferterminJahr`) AS `LTKunde`,`PP`.`PPProduktpass_IAN` AS `IAN`,`PP`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PP`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterung`,`PP`.`PPProduktpass_Gesamtmenge` AS `Menge`,`PP`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,`PO`.`PPPurchase_FOBYear` AS `LiefLTJahr`,`PO`.`PPPurchase_FOBWeek` AS `LiefLTWoche`,sum(`PPM`.`PPProduktpass_Menge_LT1Menge`) AS `LTMenge`,`PO`.`PPPurchase_Currency` AS `WSYM`,sum((`PPM`.`PPProduktpass_Menge_LT1Menge` * `PPM`.`PPProduktpass_Menge_EKUSD`)) AS `TotalEKFW`,(sum((`PPM`.`PPProduktpass_Menge_LT1Menge` * `PPM`.`PPProduktpass_Menge_EKUSD`)) / sum(`PPM`.`PPProduktpass_Menge_LT1Menge`)) AS `EKBWFW`,`PO`.`PPPurchase_EK` AS `EKFW`,`PO`.`PPPurchase_EK_Calc` AS `EKKalk`,`PO`.`PPPurchase_Ausgangsfrachten` AS `Ausgangsfrachten`,`PO`.`PPPurchase_Zoll` AS `ZollProz`,`PO`.`PPPurchase_Fracht` AS `Fracht`,`PO`.`PPPurchase_Kosten` AS `Kosten`,`PO`.`PPPurchase_EKProvision` AS `EKProvision`,`PO`.`PPPurchase_Pruefkosten` AS `Pruefkosten`,`PO`.`PPPurchase_SonstKostenProz` AS `SonstKostenProz`,`PO`.`PPPurchase_ExcR_Calc` AS `KursKalk`,`PO`.`PPPurchase_ExcR_Save` AS `KursGesichert`,ifnull(`PO`.`PPPurchase_DeliveryDate`,((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week) - interval (weekday((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week)) - 1) day)) AS `LieferantenLT`,date_format(((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week) - interval (weekday((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week)) - 1) day),'%m') AS `Periode` from ((`PPProduktpass_Menge` `PPM` join `tPPProduktpass` `PP` on((`PPM`.`PPProduktpass_Menge_PPProduktpass_Id` = `PP`.`PPProduktpass_Id`))) join `PPPurchase` `PO` on((`PO`.`PPPurchase_PPProduktpass_Id` = `PPM`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((length(`PP`.`PPProduktpass_IAN`) = 6) and (not((`PP`.`PPProduktpass_IAN` like 'M%'))) and (not((`PP`.`PPProduktpass_IAN` like 'I%'))) and (0 <> `PP`.`PPProduktpass_LieferterminJahr`) and (`PP`.`PPProduktpass_IsInquiry` = 0) and (`PP`.`PPProduktpass_IsMusterung` = 0) and (`PO`.`PPPurchase_FOBYear` = 2021)) group by `PPM`.`PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_AusgangsfrachtRP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_AusgangsfrachtRP` AS select `BuHa_RP`.`IAN` AS `IAN`,`BuHa_RP`.`Gruppe` AS `Gruppe`,`BuHa_RP`.`Menge` AS `Menge`,`BuHa_RP`.`BetragEUR` AS `BetragEUR` from `BuHa_RP` where (`BuHa_RP`.`Gruppe` = 'Ausgangsfracht');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_Belege`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_Belege` AS select `B`.`Belege_id` AS `Belege_Id`,`B`.`Belegnummer` AS `Belegnummer`,`B`.`Belegart` AS `Belegart`,`B`.`Belegjahr` AS `Belegjahr`,`B`.`Belegdatum` AS `Belegdatum`,`B`.`Periode` AS `Periode`,`B`.`BelegAdresse_Name1` AS `Kundenname`,`A`.`Kundengruppen_Id` AS `Kundengruppen_Id`,`K`.`Kundengruppen_Bezeichnung` AS `Kundengruppe`,`B`.`Lieferadresse_Adress_Id` AS `Lieferadresse_Adress_Id`,`A`.`Kundennummer` AS `Kundennummer`,`B`.`Steuercode` AS `Steuercode`,ifnull(`LA`.`PostLand`,`A`.`PostLand`) AS `SteuerLand`,`BA`.`S_H` AS `SH`,`KL`.`BU` AS `BU`,ifnull(`KL`.`Erlöskonto`,`K`.`Erlöskonto`) AS `Erlöskonto`,`B`.`Wsym` AS `Währung`,`B`.`Zahlungsart` AS `Zahlungsart` from (((((`belege` `B` join `adressen` `A` on((`A`.`Adressen_Id` = `B`.`Konten_Id`))) join `belegarten` `BA` on((`BA`.`Belegart` = `B`.`Belegart`))) left join `adressen` `LA` on((`LA`.`Adressen_Id` = `B`.`Lieferadresse_Adress_Id`))) left join `Kundengruppen` `K` on((`K`.`Kundengruppen_Id` = `A`.`Kundengruppen_Id`))) left join `Kundengruppen` `KL` on((`KL`.`Kundengruppen_Id` = `LA`.`Kundengruppen_Id`))) where ((`B`.`IstAktiv` = 1) and (`BA`.`IstrBuchhaltungsbeleg` = 1)) order by `B`.`Belege_id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_BestandAbgang`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_BestandAbgang` AS select `B`.`Belegart` AS `Belegart`,`B`.`Belegjahr` AS `Belegjahr`,`B`.`Belegdatum` AS `Belegdatum`,date_format(`B`.`Belegdatum`,'%m') AS `Periode`,`B`.`Belegnummer` AS `Belegnummer`,`A`.`Kundengruppen_Id` AS `Kundengruppen_Id`,`A`.`Matchcode` AS `Matchcode`,`A`.`Kundennummer` AS `Kundennummer`,`BP`.`artikelnummer` AS `artikelnummer`,`BP`.`Bezeichnung1` AS `Bezeichnung1`,`BP`.`menge` AS `Menge`,`BP`.`Preis` AS `VK`,ifnull(`B`.`Wsym`,'EUR') AS `Wsym`,(`BP`.`menge` * `BP`.`Preis`) AS `VKTotal`,`BA`.`S_H` AS `S_H` from (((`belege` `B` join `adressen` `A` on((`A`.`Adressen_Id` = `B`.`BelegAdresse_Adresse_Id`))) join `belegepositionen` `BP` on((`B`.`Belege_id` = `BP`.`Belege_id`))) join `belegarten` `BA` on((`BA`.`Belegart` = `B`.`Belegart`))) where ((`BA`.`IstrBuchhaltungsbeleg` = 1) and (`B`.`IstAktiv` = 1) and (`BP`.`IstAktiv` = 1));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_EingangsfrachtRP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_EingangsfrachtRP` AS select `BuHa_RP`.`IAN` AS `IAN`,`BuHa_RP`.`Gruppe` AS `Gruppe`,`BuHa_RP`.`Menge` AS `Menge`,`BuHa_RP`.`BetragEUR` AS `BetragEUR` from `BuHa_RP` where (`BuHa_RP`.`Gruppe` = 'Eingangsfracht');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_PosTotal`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_PosTotal` AS select `belegepositionen`.`Belege_id` AS `Belege_Id`,sum((((`belegepositionen`.`menge` * `belegepositionen`.`Preis`) - ifnull(`belegepositionen`.`rabatt1betrag`,0)) - ifnull(`belegepositionen`.`rabatt2betrag`,0))) AS `PosTotalNetto` from `belegepositionen` where (`belegepositionen`.`IstAktiv` = 1) group by `belegepositionen`.`Belege_id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_RP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_RP` AS select `Rechnungsprüfung`.`IAN` AS `IAN`,`Rechnungsprüfung`.`Gruppe` AS `Gruppe`,sum(`Rechnungsprüfung`.`Menge`) AS `Menge`,sum((`Rechnungsprüfung`.`Betrag_netto` / `Rechnungsprüfung`.`Kurs`)) AS `BetragEUR` from `Rechnungsprüfung` where ((`Rechnungsprüfung`.`Gruppe` like '%%') and (`Rechnungsprüfung`.`aktiv` = 1)) group by `Rechnungsprüfung`.`IAN`,`Rechnungsprüfung`.`Gruppe`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_Uebergabe`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_Uebergabe` AS select `B`.`Belege_Id` AS `Belege_Id`,`B`.`Belegjahr` AS `Belegjahr`,`B`.`Periode` AS `Periode`,`B`.`Belegdatum` AS `Belegdatum`,`B`.`SteuerLand` AS `Steuerland`,`B`.`Steuercode` AS `Steuercode`,`StS`.`Steuersatz` AS `Steuersatz`,(case when (`B`.`Steuercode` = 1) then (1 + (`StS`.`Steuersatz` / 100)) when (`B`.`Steuercode` = 4) then 1 when (`B`.`Steuercode` = 5) then (1 + (`StS`.`Steuersatz` / 100)) end) AS `Steuerfaktor`,date_format(`B`.`Belegdatum`,'%d%m') AS `Datum`,`B`.`Kundenname` AS `Kundenname`,`B`.`Belegnummer` AS `Belegnummer`,`P`.`PosTotalNetto` AS `NettoSumme`,(`P`.`PosTotalNetto` * (case when (`B`.`Steuercode` = 1) then (1 + (`StS`.`Steuersatz` / 100)) when (`B`.`Steuercode` = 4) then 1 when (`B`.`Steuercode` = 5) then (1 + (`StS`.`Steuersatz` / 100)) end)) AS `BruttoSumme`,`B`.`Kundennummer` AS `Kundennummer`,`B`.`BU` AS `BU`,`B`.`Erlöskonto` AS `Erlöskonto`,`B`.`SH` AS `SH`,`B`.`Zahlungsart` AS `Zahlungsart`,`B`.`Kundengruppe` AS `Kundengruppe` from ((`BuHa_Belege` `B` join `BuHa_PosTotal` `P` on((`B`.`Belege_Id` = `P`.`Belege_Id`))) left join `Steuersatz` `StS` on(((`StS`.`Lieferland` = `B`.`SteuerLand`) and (`StS`.`Steuercode` = 1) and (`StS`.`GueltigBis` >= '2021-01-01'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_UebergabeCSV`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_UebergabeCSV` AS select `BuHa_Uebergabe`.`Datum` AS `Datum`,`BuHa_Uebergabe`.`Kundenname` AS `Kundenname`,`BuHa_Uebergabe`.`Belege_Id` AS `Belege_Id`,`BuHa_Uebergabe`.`Belegnummer` AS `Belegnummer`,replace(format(`BuHa_Uebergabe`.`BruttoSumme`,2,'de_DE'),'.','') AS `BetragBrutto`,`BuHa_Uebergabe`.`Kundennummer` AS `Kundennummer`,`BuHa_Uebergabe`.`BU` AS `BU`,`BuHa_Uebergabe`.`Erlöskonto` AS `Erloeskonto`,`BuHa_Uebergabe`.`SH` AS `SH`,`BuHa_Uebergabe`.`Zahlungsart` AS `Zahlungsart`,`BuHa_Uebergabe`.`Kundengruppe` AS `Kundengruppe`,`BuHa_Uebergabe`.`Belegdatum` AS `Belegdatum`,date_format(`BuHa_Uebergabe`.`Belegdatum`,'%m') AS `Periode`,date_format(`BuHa_Uebergabe`.`Belegdatum`,'%Y') AS `Jahr` from `BuHa_Uebergabe` order by `BuHa_Uebergabe`.`Belegnummer`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `BuHa_ZollRP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `BuHa_ZollRP` AS select `BuHa_RP`.`IAN` AS `IAN`,`BuHa_RP`.`Gruppe` AS `Gruppe`,`BuHa_RP`.`Menge` AS `Menge`,`BuHa_RP`.`BetragEUR` AS `BetragEUR` from `BuHa_RP` where (`BuHa_RP`.`Gruppe` = 'Zoll');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `KDGR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `KDGR` AS select `Kundengruppen`.`Kundengruppen_Id` AS `Kundengruppen_Id`,`Kundengruppen`.`Kundengruppen_Bezeichnung` AS `Kundengruppen_Bezeichnung`,`Kundengruppen`.`Erlöskonto` AS `Erlöskonto` from `Kundengruppen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPBoardSpalte`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPBoardSpalte` AS select `PPBoardSpalteData`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`PPBoardSpalteData`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`PPBoardSpalteData`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`PPBoardSpalteData`.`PPBoardSpalte_Stati` AS `PPBoardSpalte_Stati`,`PPBoardSpalteData`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`PPBoardSpalteData`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`PPBoardSpalteData`.`PPBoardSpalte_DefaultMA` AS `PPBoardSpalte_DefaultMA`,`PPBoardSpalteData`.`PPBoardSpalte_DFTable` AS `PPBoardSpalte_DFTable`,`PPBoardSpalteData`.`PPBoardSpalte_DFField` AS `PPBoardSpalte_DFField`,`PPBoardSpalteData`.`PPBoardSpalteData_Kind` AS `PPBoardSpalteData_Kind`,`PPBoardSpalteX`.`PPBoardSpalteX_Id` AS `PPBoardSpalteX_Id`,`PPBoardSpalteX`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`PPBoardSpalteX`.`PPBoardSpalteX_PPBoardSpalte_Id` AS `PPBoardSpalteX_PPBoardSpalte_Id`,`PPBoardSpalteX`.`PPBoardSpalteX_Sort` AS `PPBoardSpalteX_Sort`,`PPBoard`.`PPBoard_Id` AS `PPBoard_Id`,`PPBoard`.`PPBoard_Bezeichnung` AS `PPBoard_Bezeichnung`,`PPBoardSpalteData`.`PPBoardSpalte_IsMilestone` AS `PPBoardSpalte_IsMilestone`,`PPBoardSpalteData`.`PPBoardSpalteData_IsKMS` AS `PPBoardSpalteData_IsKMS`,`PPBoardSpalteData`.`PPBoardSpalteData_KMS` AS `PPBoardSpalteData_KMS`,`PPBoardSpalteData`.`PPBoardSpalte_IsUSA` AS `PPBoardSpalte_IsUSA`,`PPBoardSpalteData`.`PPBoardSpalteData_HilfeStatusOK` AS `PPBoardSpalteData_HilfeStatusOK`,`PPBoardSpalteData`.`PPBoardSpalteData_HifeStatusInArbeit` AS `PPBoardSpalteData_HifeStatusInArbeit`,`PPBoardSpalteData`.`PPBoardSpalteData_HilfeStatusNOK` AS `PPBoardSpalteData_HilfeStatusNOK` from ((`PPBoardSpalteData` join `PPBoardSpalteX` on((`PPBoardSpalteData`.`PPBoardSpalte_Id` = `PPBoardSpalteX`.`PPBoardSpalteX_PPBoardSpalte_Id`))) join `PPBoard` on((`PPBoard`.`PPBoard_Id` = `PPBoardSpalteX`.`PPBoardSpalte_PPBoard_Id`))) where (`PPBoardSpalteData`.`PPBoardSpalte_Id` >= 1000) order by `PPBoardSpalteX`.`PPBoardSpalteX_Sort`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPHerkunftslaenderPPAB`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPHerkunftslaenderPPAB` AS select `PPAB`.`PPAB_Id` AS `PPAB_Id`,`PPAB`.`PPAB_PPProduktpass_Id` AS `PPAB_PPProduktpass_Id`,`PPHerkunftslaender`.`PPHerkunftslaender_Id` AS `PPHerkunftslaender_Id`,`PPHerkunftslaender`.`PPHerkunftslaender_Land` AS `PPHerkunftslaender_Land`,`PPAB`.`PPAB_Produktionsstaette` AS `PPAB_Produktionsstaette` from (`PPAB` left join `PPHerkunftslaender` on((`PPAB`.`PPAB_Herkunftsland` = `PPHerkunftslaender`.`PPHerkunftslaender_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPInquiry`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPInquiry` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`tPPProduktpass`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`tPPProduktpass`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`tPPProduktpass`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`tPPProduktpass`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`tPPProduktpass`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`tPPProduktpass`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`tPPProduktpass`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`tPPProduktpass`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`tPPProduktpass`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`tPPProduktpass`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`tPPProduktpass`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`tPPProduktpass`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`tPPProduktpass`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`tPPProduktpass`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`tPPProduktpass`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`tPPProduktpass`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`tPPProduktpass`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`tPPProduktpass`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`tPPProduktpass`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`tPPProduktpass`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`tPPProduktpass`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`tPPProduktpass`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`tPPProduktpass`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`tPPProduktpass`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`tPPProduktpass`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`tPPProduktpass`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`tPPProduktpass`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`tPPProduktpass`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`tPPProduktpass`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`tPPProduktpass`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`tPPProduktpass`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`tPPProduktpass`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`tPPProduktpass`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`tPPProduktpass`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`tPPProduktpass`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`tPPProduktpass`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`tPPProduktpass`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`tPPProduktpass`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`tPPProduktpass`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`tPPProduktpass`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`tPPProduktpass`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`tPPProduktpass`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`tPPProduktpass`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`tPPProduktpass`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`tPPProduktpass`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`tPPProduktpass`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`tPPProduktpass`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`tPPProduktpass`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`tPPProduktpass`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`tPPProduktpass`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`tPPProduktpass`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`tPPProduktpass`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`tPPProduktpass`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`tPPProduktpass`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`tPPProduktpass`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`tPPProduktpass`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`tPPProduktpass`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`tPPProduktpass`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`tPPProduktpass`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`tPPProduktpass`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`tPPProduktpass`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`tPPProduktpass`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`tPPProduktpass`.`PPProduktpass_GreenLevel` AS `PPProduktpass_GreenLevel`,`tPPProduktpass`.`PPProduktpass_KauflandMarke` AS `PPProduktpass_KauflandMarke`,`tPPProduktpass`.`rfqNo` AS `rfqNo`,`tPPProduktpass`.`isLatest` AS `isLatest`,`tPPProduktpass`.`statusDoc` AS `statusDoc`,`tPPProduktpass`.`updateUserName` AS `updateUserName`,`tPPProduktpass`.`category` AS `category`,`tPPProduktpass`.`vendorNo` AS `vendorNo`,`tPPProduktpass`.`createdOn` AS `createdOn`,`tPPProduktpass`.`updatedOn` AS `updatedOn`,`tPPProduktpass`.`expiryDate` AS `expiryDate`,`tPPProduktpass`.`versionDoc` AS `versionDoc`,`tPPProduktpass`.`angebotsnummerPraefix` AS `angebotsnummerPraefix`,`tPPProduktpass`.`createUserName` AS `createUserName`,`tPPProduktpass`.`version` AS `version`,`tPPProduktpass`.`retailPackagingComment` AS `retailPackagingComment`,`tPPProduktpass`.`Garantie` AS `Garantie`,`tPPProduktpass`.`rfSafety` AS `rfSafety`,`tPPProduktpass`.`packagingKL_materialThickness` AS `packagingKL_materialThickness`,`tPPProduktpass`.`packagingKL_retailPackagingComment` AS `packagingKL_retailPackagingComment`,`tPPProduktpass`.`packagingKL_trayRemarks` AS `packagingKL_trayRemarks`,`tPPProduktpass`.`packagingKL_rt_name` AS `packagingKL_rt_name`,`tPPProduktpass`.`packagingKL_tray_name` AS `packagingKL_tray_name`,`tPPProduktpass`.`isCatalogue` AS `isCatalogue`,`tPPProduktpass`.`initialOrder` AS `initialOrder`,`tPPProduktpass`.`brandKL` AS `brandKL`,`tPPProduktpass`.`sampleNumberKL` AS `sampleNumberKL`,`tPPProduktpass`.`buyerShortCodeKL` AS `buyerShortCodeKL`,`tPPProduktpass`.`buyerNameKL` AS `buyerNameKL`,`tPPProduktpass`.`themeNoKL` AS `themeNoKL`,`tPPProduktpass`.`noLIDLItem` AS `noLIDLItem` from `tPPProduktpass` where (`tPPProduktpass`.`PPProduktpass_IsInquiry` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPLaenderbloecke`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPLaenderbloecke` AS select `PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Id` AS `PPLaenderbloecke_Id`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Land` AS `PPLaenderbloecke_Land`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Block` AS `PPLaenderbloecke_Block`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Hafen1` AS `PPLaenderbloecke_Hafen1`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Hafen2` AS `PPLaenderbloecke_Hafen2`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Sort` AS `PPLaenderbloecke_Sort`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Version` AS `PPLaenderbloecke_Version`,`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_IsOS` AS `PPLaenderbloecke_IsOS` from `PPLaenderbloeckeMitVersion` where (`PPLaenderbloeckeMitVersion`.`PPLaenderbloecke_Version` = '0000');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPMusterung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPMusterung` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`tPPProduktpass`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`tPPProduktpass`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`tPPProduktpass`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`tPPProduktpass`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`tPPProduktpass`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`tPPProduktpass`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`tPPProduktpass`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`tPPProduktpass`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`tPPProduktpass`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`tPPProduktpass`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`tPPProduktpass`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`tPPProduktpass`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`tPPProduktpass`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`tPPProduktpass`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`tPPProduktpass`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`tPPProduktpass`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`tPPProduktpass`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`tPPProduktpass`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`tPPProduktpass`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`tPPProduktpass`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`tPPProduktpass`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`tPPProduktpass`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`tPPProduktpass`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`tPPProduktpass`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`tPPProduktpass`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`tPPProduktpass`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`tPPProduktpass`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`tPPProduktpass`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`tPPProduktpass`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`tPPProduktpass`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`tPPProduktpass`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`tPPProduktpass`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`tPPProduktpass`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`tPPProduktpass`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`tPPProduktpass`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`tPPProduktpass`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`tPPProduktpass`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`tPPProduktpass`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`tPPProduktpass`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`tPPProduktpass`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`tPPProduktpass`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`tPPProduktpass`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`tPPProduktpass`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`tPPProduktpass`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`tPPProduktpass`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`tPPProduktpass`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`tPPProduktpass`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`tPPProduktpass`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`tPPProduktpass`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`tPPProduktpass`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`tPPProduktpass`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`tPPProduktpass`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`tPPProduktpass`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`tPPProduktpass`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`tPPProduktpass`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`tPPProduktpass`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`tPPProduktpass`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`tPPProduktpass`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`tPPProduktpass`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`tPPProduktpass`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`tPPProduktpass`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`tPPProduktpass`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`tPPProduktpass`.`PPProduktpass_GreenLevel` AS `PPProduktpass_GreenLevel`,`tPPProduktpass`.`PPProduktpass_KauflandMarke` AS `PPProduktpass_KauflandMarke`,`tPPProduktpass`.`rfqNo` AS `rfqNo`,`tPPProduktpass`.`isLatest` AS `isLatest`,`tPPProduktpass`.`statusDoc` AS `statusDoc`,`tPPProduktpass`.`updateUserName` AS `updateUserName`,`tPPProduktpass`.`category` AS `category`,`tPPProduktpass`.`vendorNo` AS `vendorNo`,`tPPProduktpass`.`createdOn` AS `createdOn`,`tPPProduktpass`.`updatedOn` AS `updatedOn`,`tPPProduktpass`.`expiryDate` AS `expiryDate`,`tPPProduktpass`.`versionDoc` AS `versionDoc`,`tPPProduktpass`.`angebotsnummerPraefix` AS `angebotsnummerPraefix`,`tPPProduktpass`.`createUserName` AS `createUserName`,`tPPProduktpass`.`version` AS `version`,`tPPProduktpass`.`retailPackagingComment` AS `retailPackagingComment`,`tPPProduktpass`.`Garantie` AS `Garantie`,`tPPProduktpass`.`rfSafety` AS `rfSafety`,`tPPProduktpass`.`packagingKL_materialThickness` AS `packagingKL_materialThickness`,`tPPProduktpass`.`packagingKL_retailPackagingComment` AS `packagingKL_retailPackagingComment`,`tPPProduktpass`.`packagingKL_trayRemarks` AS `packagingKL_trayRemarks`,`tPPProduktpass`.`packagingKL_rt_name` AS `packagingKL_rt_name`,`tPPProduktpass`.`packagingKL_tray_name` AS `packagingKL_tray_name`,`tPPProduktpass`.`isCatalogue` AS `isCatalogue`,`tPPProduktpass`.`initialOrder` AS `initialOrder`,`tPPProduktpass`.`brandKL` AS `brandKL`,`tPPProduktpass`.`sampleNumberKL` AS `sampleNumberKL`,`tPPProduktpass`.`buyerShortCodeKL` AS `buyerShortCodeKL`,`tPPProduktpass`.`buyerNameKL` AS `buyerNameKL`,`tPPProduktpass`.`themeNoKL` AS `themeNoKL`,`tPPProduktpass`.`noLIDLItem` AS `noLIDLItem` from `tPPProduktpass` where (`tPPProduktpass`.`PPProduktpass_IsMusterung` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPProduktpass`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPProduktpass` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`tPPProduktpass`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`tPPProduktpass`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`tPPProduktpass`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`tPPProduktpass`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`tPPProduktpass`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`tPPProduktpass`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`tPPProduktpass`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`tPPProduktpass`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`tPPProduktpass`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`tPPProduktpass`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`tPPProduktpass`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`tPPProduktpass`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`tPPProduktpass`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`tPPProduktpass`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`tPPProduktpass`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`tPPProduktpass`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`tPPProduktpass`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`tPPProduktpass`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`tPPProduktpass`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`tPPProduktpass`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`tPPProduktpass`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`tPPProduktpass`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`tPPProduktpass`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`tPPProduktpass`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`tPPProduktpass`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`tPPProduktpass`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`tPPProduktpass`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`tPPProduktpass`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`tPPProduktpass`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`tPPProduktpass`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`tPPProduktpass`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`tPPProduktpass`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`tPPProduktpass`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`tPPProduktpass`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`tPPProduktpass`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`tPPProduktpass`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`tPPProduktpass`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`tPPProduktpass`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`tPPProduktpass`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`tPPProduktpass`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`tPPProduktpass`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`tPPProduktpass`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`tPPProduktpass`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`tPPProduktpass`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`tPPProduktpass`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`tPPProduktpass`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`tPPProduktpass`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`tPPProduktpass`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`tPPProduktpass`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`tPPProduktpass`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`tPPProduktpass`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`tPPProduktpass`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`tPPProduktpass`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`tPPProduktpass`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`tPPProduktpass`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`tPPProduktpass`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`tPPProduktpass`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`tPPProduktpass`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`tPPProduktpass`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`tPPProduktpass`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`tPPProduktpass`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`tPPProduktpass`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`tPPProduktpass`.`PPProduktpass_GreenLevel` AS `PPProduktpass_GreenLevel`,`tPPProduktpass`.`PPProduktpass_KauflandMarke` AS `PPProduktpass_KauflandMarke`,`tPPProduktpass`.`rfqNo` AS `rfqNo`,`tPPProduktpass`.`isLatest` AS `isLatest`,`tPPProduktpass`.`statusDoc` AS `statusDoc`,`tPPProduktpass`.`updateUserName` AS `updateUserName`,`tPPProduktpass`.`category` AS `category`,`tPPProduktpass`.`vendorNo` AS `vendorNo`,`tPPProduktpass`.`createdOn` AS `createdOn`,`tPPProduktpass`.`updatedOn` AS `updatedOn`,`tPPProduktpass`.`expiryDate` AS `expiryDate`,`tPPProduktpass`.`versionDoc` AS `versionDoc`,`tPPProduktpass`.`angebotsnummerPraefix` AS `angebotsnummerPraefix`,`tPPProduktpass`.`createUserName` AS `createUserName`,`tPPProduktpass`.`version` AS `version`,`tPPProduktpass`.`retailPackagingComment` AS `retailPackagingComment`,`tPPProduktpass`.`Garantie` AS `Garantie`,`tPPProduktpass`.`rfSafety` AS `rfSafety`,`tPPProduktpass`.`packagingKL_materialThickness` AS `packagingKL_materialThickness`,`tPPProduktpass`.`packagingKL_retailPackagingComment` AS `packagingKL_retailPackagingComment`,`tPPProduktpass`.`packagingKL_trayRemarks` AS `packagingKL_trayRemarks`,`tPPProduktpass`.`packagingKL_rt_name` AS `packagingKL_rt_name`,`tPPProduktpass`.`packagingKL_tray_name` AS `packagingKL_tray_name`,`tPPProduktpass`.`isCatalogue` AS `isCatalogue`,`tPPProduktpass`.`initialOrder` AS `initialOrder`,`tPPProduktpass`.`brandKL` AS `brandKL`,`tPPProduktpass`.`sampleNumberKL` AS `sampleNumberKL`,`tPPProduktpass`.`buyerShortCodeKL` AS `buyerShortCodeKL`,`tPPProduktpass`.`buyerNameKL` AS `buyerNameKL`,`tPPProduktpass`.`themeNoKL` AS `themeNoKL`,`tPPProduktpass`.`noLIDLItem` AS `noLIDLItem`,`tPPProduktpass`.`Abwicklungsart` AS `Abwicklungsart`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus` from `tPPProduktpass` where ((`tPPProduktpass`.`PPProduktpass_IsInquiry` = 0) and (`tPPProduktpass`.`PPProduktpass_IsMusterung` = 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `PPProduktpassOrg`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `PPProduktpassOrg` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`tPPProduktpass`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`tPPProduktpass`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`tPPProduktpass`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`tPPProduktpass`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`tPPProduktpass`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`tPPProduktpass`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`tPPProduktpass`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`tPPProduktpass`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`tPPProduktpass`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`tPPProduktpass`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`tPPProduktpass`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`tPPProduktpass`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`tPPProduktpass`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`tPPProduktpass`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`tPPProduktpass`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`tPPProduktpass`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`tPPProduktpass`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`tPPProduktpass`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`tPPProduktpass`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`tPPProduktpass`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`tPPProduktpass`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`tPPProduktpass`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`tPPProduktpass`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`tPPProduktpass`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`tPPProduktpass`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`tPPProduktpass`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`tPPProduktpass`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`tPPProduktpass`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`tPPProduktpass`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`tPPProduktpass`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`tPPProduktpass`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`tPPProduktpass`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`tPPProduktpass`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`tPPProduktpass`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`tPPProduktpass`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`tPPProduktpass`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`tPPProduktpass`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`tPPProduktpass`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`tPPProduktpass`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`tPPProduktpass`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`tPPProduktpass`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`tPPProduktpass`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`tPPProduktpass`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`tPPProduktpass`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`tPPProduktpass`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`tPPProduktpass`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`tPPProduktpass`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`tPPProduktpass`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`tPPProduktpass`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`tPPProduktpass`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`tPPProduktpass`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`tPPProduktpass`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`tPPProduktpass`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`tPPProduktpass`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`tPPProduktpass`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`tPPProduktpass`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`tPPProduktpass`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`tPPProduktpass`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`tPPProduktpass`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`tPPProduktpass`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`tPPProduktpass`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`tPPProduktpass`.`PPProduktpass_GreenLevel` AS `PPProduktpass_GreenLevel`,`tPPProduktpass`.`PPProduktpass_KauflandMarke` AS `PPProduktpass_KauflandMarke` from `tPPProduktpass` where ((`tPPProduktpass`.`PPProduktpass_IsInquiry` = 0) and (`tPPProduktpass`.`PPProduktpass_IsMusterung` = 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `XMLConverter`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `XMLConverter` AS select `XMLConverterMitVersion`.`XMLConverter_Id` AS `XMLConverter_Id`,`XMLConverterMitVersion`.`XMLConverter_DBTable` AS `XMLConverter_DBTable`,`XMLConverterMitVersion`.`XMLConverter_DBColumn` AS `XMLConverter_DBColumn`,`XMLConverterMitVersion`.`XMLConverter_XMLNode` AS `XMLConverter_XMLNode`,`XMLConverterMitVersion`.`XMLConverter_Version` AS `XMLConverter_Version`,`XMLConverterMitVersion`.`XMLConverter_Translate` AS `XMLConverter_Translate` from `XMLConverterMitVersion` where (`XMLConverterMitVersion`.`XMLConverter_Version` = '2021.01');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `cSortierungDistinct`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `cSortierungDistinct` AS select distinct `PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value03` AS `PPProduktpass_Sortierung_Value03` from `PPProduktpass_Sortierung` where (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02`) <> '');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_CountryGTIN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_CountryGTIN` AS select `PPXML_Mengen`.`PPXML_Mengen_lsv` AS `PPXML_Mengen_lsv`,`PPXML_Mengen`.`PPXML_Mengen_styleNo` AS `PPXML_Mengen_styleNo`,`PPXML_Mengen`.`PPXML_Mengen_productName` AS `PPXML_Mengen_productName`,`PPXML_Mengen`.`PPXML_Mengen_country` AS `PPXML_Mengen_country`,`PPXML_Mengen`.`PPXML_Mengen_PPProduktpass_Id` AS `PPXML_Mengen_PPProduktpass_Id`,`PPXML_Mengen`.`PPXML_Mengen_sizeName` AS `PPXML_Mengen_sizeName`,`PPXML_Mengen`.`PPXML_Mengen_sizeCode` AS `PPXML_Mengen_sizeCode`,`PPXML_Mengen`.`PPXML_Mengen_GTIN` AS `PPXML_Mengen_GTIN`,`PPXML_Mengen`.`PPXML_Mengen_GTINKL` AS `PPXML_Mengen_GTINKL` from `PPXML_Mengen` where (`PPXML_Mengen`.`PPXML_Mengen_value` > 0) union select distinct `PPXML_OSMengen`.`PPXML_OSMengen_lsv` AS `PPXML_OSMengen_lsv`,`PPXML_OSMengen`.`PPXML_OSMengen_styleNo` AS `PPXML_OSMengen_styleNo`,`PPXML_OSMengen`.`PPXML_OSMengen_productName` AS `PPXML_OSMengen_productName`,`PPXML_OSMengen`.`PPXML_OSMengen_country` AS `PPXML_OSMengen_country`,`PPXML_OSMengen`.`PPXML_OSMengen_PPProduktpass_Id` AS `PPXML_OSMengen_PPProduktpass_Id`,`PPXML_OSMengen`.`PPXML_OSMengen_sizeName` AS `PPXML_OSMengen_sizeName`,'' AS `Name_exp_16`,`PPXML_OSMengen`.`PPXML_OSMengen_GTIN` AS `PPXML_OSMengen_GTIN`,`PPXML_OSMengen`.`PPXML_OSMengen_GTINKL` AS `PPXML_OSMengen_GTINKL` from `PPXML_OSMengen` where (`PPXML_OSMengen`.`PPXML_OSMengen_value` > 0);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_GTINWeightsLSV`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_GTINWeightsLSV` AS select `ow`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`ow`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`ow`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`ow`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`ow`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`ow`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`ow`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`ow`.`PPOrderWeights_size` AS `PPOrderWeights_size`,`lsv`.`PPLsv_name` AS `PPLsv_name`,`lsv`.`PPLsv_countryNames` AS `PPLsv_countryNames` from (`PPOrderWeights` `ow` left join `PPLsv` `lsv` on(((`lsv`.`PPLsv_PPProduktpass_Id` = `ow`.`PPOrderWeights_PPProduktpass_Id`) and (`lsv`.`PPLsv_code` = `ow`.`PPOrderWeights_lsv`))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_IANMengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_IANMengen` AS select `tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`PPProduktpass_Menge`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`PPProduktpass_Menge`.`PPProduktpass_Menge_PackingMethod` AS `PPProduktpass_Menge_PackingMethod`,`PPProduktpass_Menge`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Row` AS `PPProduktpass_Menge_Row`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Rotterdam` AS `PPProduktpass_Menge_Rotterdam`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Barcelona` AS `PPProduktpass_Menge_Barcelona`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Koper` AS `PPProduktpass_Menge_Koper`,`PPProduktpass_Menge`.`PPProduktpass_Menge_EKUSD` AS `PPProduktpass_Menge_EKUSD`,`PPProduktpass_Menge`.`PPProduktpass_Menge_VKFOBEUR` AS `PPProduktpass_Menge_VKFOBEUR`,`PPProduktpass_Menge`.`PPProduktpass_Menge_CBEK` AS `PPProduktpass_Menge_CBEK`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Countrysizes` AS `PPProduktpass_Menge_Countrysizes`,`PPProduktpass_Menge`.`PPProduktpass_Menge_CBVK` AS `PPProduktpass_Menge_CBVK`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1` AS `PPProduktpass_Menge_LT1`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` AS `PPProduktpass_Menge_LT1Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2` AS `PPProduktpass_Menge_LT2`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2Menge` AS `PPProduktpass_Menge_LT2Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3` AS `PPProduktpass_Menge_LT3`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3Menge` AS `PPProduktpass_Menge_LT3Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_ArtikelInfo` AS `PPProduktpass_Menge_ArtikelInfo`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Kolli` AS `PPProduktpass_Menge_Kolli`,`PPProduktpass_Menge`.`PPProduktpass_Menge_CountryGSM` AS `PPProduktpass_Menge_CountryGSM`,`PPProduktpass_Menge`.`PPProduktpass_Menge_FOBPriice` AS `PPProduktpass_Menge_FOBPriice`,`PPProduktpass_Menge`.`PPProduktpass_Menge_8WMuster` AS `PPProduktpass_Menge_8WMuster`,`PPProduktpass_Menge`.`PPProduktpass_Menge_CartonSize` AS `PPProduktpass_Menge_CartonSize`,`PPProduktpass_Menge`.`PPProduktpass_Menge_PcsPerCarton` AS `PPProduktpass_Menge_PcsPerCarton`,`PPProduktpass_Menge`.`PPProduktpass_Menge_CartonPerPal` AS `PPProduktpass_Menge_CartonPerPal`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Trucks` AS `PPProduktpass_Menge_Trucks`,`PPProduktpass_Menge`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks` from (`PPProduktpass_Menge` join `tPPProduktpass` on((`tPPProduktpass`.`PPProduktpass_Id` = `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%'))) and (`tPPProduktpass`.`InternerStatus` like 'FIX'));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_OrderWeights`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_OrderWeights` AS select distinct `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`PPOrderWeights`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`PPOrderWeights`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`PPOrderWeights`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv` from `PPOrderWeights`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_asortment`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_asortment` AS select distinct `l`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`s`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`s`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`s`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`s`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`l`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`l`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`l`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`l`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`l`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`l`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`l`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`l`.`PPLsv_name` AS `PPLsv_name` from (`PPProduktpass_Sortierung` `s` join `hv_GTINWeightsLSV` `l` on(((`l`.`PPOrderWeights_PPProduktpass_Id` = `s`.`PPProduktpass_Sortierung_PPProduktpass_Id`) and regexp_like(replace(`l`.`PPLsv_countryNames`,' ',''),concat('(^|,)(',replace(regexp_replace(replace(`s`.`PPProduktpass_Sortierung_Laenderblock`,' ',''),'CB[0-9]+-',''),',','|'),')($|,)')))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_assortment`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_assortment` AS select distinct `l`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`s`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`s`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`s`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`s`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`l`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`l`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`l`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`l`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`l`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`l`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`l`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`l`.`PPLsv_name` AS `PPLsv_name` from (`PPProduktpass_Sortierung` `s` join `hv_GTINWeightsLSV` `l` on(((`l`.`PPOrderWeights_PPProduktpass_Id` = `s`.`PPProduktpass_Sortierung_PPProduktpass_Id`) and (`s`.`PPProduktpass_Sortierung_Header` = `l`.`PPOrderWeights_styleNo`) and regexp_like(replace(`l`.`PPLsv_countryNames`,' ',''),concat('(^|,)(',replace(regexp_replace(replace(`s`.`PPProduktpass_Sortierung_Laenderblock`,' ',''),'CB[0-9]+-',''),',','|'),')($|,)')))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `hv_hasBattery`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `hv_hasBattery` AS select distinct `PPPPFiles`.`PPPPFiles_PPProduktpass_Id` AS `PPPPFiles_PPProduktpass_Id` from `PPPPFiles` where (`PPPPFiles`.`PPPPFiles_Name` like '%anl%batt%');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `lagerbestand`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `lagerbestand` AS select `lagerbewegungen`.`artikel_id` AS `artikel_id`,sum(`lagerbewegungen`.`Menge`) AS `bestand` from `lagerbewegungen` where (`lagerbewegungen`.`IstAktiv` = 1) group by `lagerbewegungen`.`artikel_id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `lageruebersicht`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `lageruebersicht` AS select `lagerbestand`.`artikel_id` AS `artikel_id`,ifnull(`lagerbestand`.`bestand`,0) AS `bestand`,`artikelstamm`.`artikelstamm_id` AS `artikelstamm_id`,`artikelstamm`.`artikelnummer` AS `artikelnummer`,`artikelstamm`.`Matchcode` AS `Matchcode`,`artikelstamm`.`Bezeichnung1` AS `Bezeichnung1`,`artikelstamm`.`Bezeichnung2` AS `Bezeichnung2`,`artikelstamm`.`created_at` AS `created_at`,`artikelstamm`.`updated_at` AS `updated_at`,`artikelstamm`.`IstAktiv` AS `IstAktiv`,`artikelstamm`.`MengeneinheitVK` AS `MengeneinheitVK`,`artikelstamm`.`MengeneinheitEK` AS `MengeneinheitEK`,`artikelstamm`.`MengeneinheitLager` AS `MengeneinheitLager`,`artikelstamm`.`Langtext` AS `Langtext`,`artikelstamm`.`Hauptgruppe` AS `Hauptgruppe`,`artikelstamm`.`Untergruppe` AS `Untergruppe`,`artikelstamm`.`MengeneinheitBasis` AS `MengeneinheitBasis`,`artikelstamm`.`EKMeenthaeltBMe` AS `EKMeenthaeltBMe`,`artikelstamm`.`VKMeenthaeltBMe` AS `VKMeenthaeltBMe`,`artikelstamm`.`LMeenthaeltBMe` AS `LMeenthaeltBMe`,`artikelstamm`.`PreisEinstand` AS `PreisEinstand`,`artikelstamm`.`PreisEKStandard` AS `PreisEKStandard`,`artikelstamm`.`PreisDurchschnittEK` AS `PreisDurchschnittEK`,`artikelstamm`.`PreisLEK` AS `PreisLEK`,`artikelstamm`.`IstBestandsgefuehrt` AS `IstBestandsgefuehrt`,`artikelstamm`.`IstChargengefuehrt` AS `IstChargengefuehrt`,`artikelstamm`.`PreisVK` AS `PreisVK`,`artikelstamm`.`PreisVKAlt` AS `PreisVKAlt`,`artikelstamm`.`BerechnungDB` AS `BerechnungDB`,`artikelstamm`.`IstProvisionsfaehig` AS `IstProvisionsfaehig`,`artikelstamm`.`IstBonusfaehig` AS `IstBonusfaehig`,`artikelstamm`.`ErloesKonto` AS `ErloesKonto`,`artikelstamm`.`Steuercode` AS `Steuercode`,`artikelstamm`.`Kostenstelle` AS `Kostenstelle`,`artikelstamm`.`Kostentraeger` AS `Kostentraeger`,`artikelstamm`.`MasseBMeLaenge` AS `MasseBMeLaenge`,`artikelstamm`.`MasseBMeBreite` AS `MasseBMeBreite`,`artikelstamm`.`MasseBMeHoehe` AS `MasseBMeHoehe`,`artikelstamm`.`MasseEkMeLaenge` AS `MasseEkMeLaenge`,`artikelstamm`.`MasseEkMeBreite` AS `MasseEkMeBreite`,`artikelstamm`.`MasseEkMeHoehe` AS `MasseEkMeHoehe`,`artikelstamm`.`MasseVkMeLaenge` AS `MasseVkMeLaenge`,`artikelstamm`.`MasseVkMeBreite` AS `MasseVkMeBreite`,`artikelstamm`.`MasseVkMeHoehe` AS `MasseVkMeHoehe`,`artikelstamm`.`MasseLMeLaenge` AS `MasseLMeLaenge`,`artikelstamm`.`MasseLMeBreite` AS `MasseLMeBreite`,`artikelstamm`.`MasseLMeHoehe` AS `MasseLMeHoehe`,`artikelstamm`.`Warennummer` AS `Warennummer`,`artikelstamm`.`Warenbezeichnung` AS `Warenbezeichnung`,`artikelstamm`.`BesondereMasseinheit` AS `BesondereMasseinheit`,`artikelstamm`.`Umrechnungsfaktor` AS `Umrechnungsfaktor`,`artikelstamm`.`EigenmasseIn` AS `EigenmasseIn`,`artikelstamm`.`Eigenmassefaktor` AS `Eigenmassefaktor`,`artikelstamm`.`Ursprungsland` AS `Ursprungsland`,`artikelstamm`.`Steuerschluessel` AS `Steuerschluessel`,`artikelstamm`.`ZollTarif` AS `ZollTarif`,`artikelstamm`.`ZollProzent` AS `ZollProzent`,`artikelstamm`.`ZollImport` AS `ZollImport`,`artikelstamm`.`ZollLand` AS `ZollLand`,`artikelstamm`.`Warenzusammensetzung` AS `Warenzusammensetzung`,`artikelstamm`.`ABCKlasse` AS `ABCKlasse`,`artikelstamm`.`Qual_Qualitaet` AS `Qual_Qualitaet`,`artikelstamm`.`Qual_Material1` AS `Qual_Material1`,`artikelstamm`.`Qual_Material2` AS `Qual_Material2`,`artikelstamm`.`Qual_Farbe` AS `Qual_Farbe`,`artikelstamm`.`Qual_Groesse` AS `Qual_Groesse`,`artikelstamm`.`Qual_Design` AS `Qual_Design`,`artikelstamm`.`KnzLizenz` AS `KnzLizenz`,`artikelstamm`.`EAN_Code` AS `EAN_Code`,`artikelstamm`.`Statistiknummer` AS `Statistiknummer`,`artikelstamm`.`MasseBMeGewichtBrutto` AS `MasseBMeGewichtBrutto`,`artikelstamm`.`MasseEkMeGewichtBrutto` AS `MasseEkMeGewichtBrutto`,`artikelstamm`.`MasseVkMeGewichtBrutto` AS `MasseVkMeGewichtBrutto`,`artikelstamm`.`MasseLMeGewichtBrutto` AS `MasseLMeGewichtBrutto`,`artikelstamm`.`MasseBMeGewichtNetto` AS `MasseBMeGewichtNetto`,`artikelstamm`.`MasseEkMeGewichtNetto` AS `MasseEkMeGewichtNetto`,`artikelstamm`.`MasseVkMeGewichtNetto` AS `MasseVkMeGewichtNetto`,`artikelstamm`.`MasseLMeGewichtNetto` AS `MasseLMeGewichtNetto`,`artikelstamm`.`Zollnummer` AS `Zollnummer`,`artikelstamm`.`TextUebernahme` AS `TextUebernahme` from (`artikelstamm` left join `lagerbestand` on((`lagerbestand`.`artikel_id` = `artikelstamm`.`artikelstamm_id`))) where (`artikelstamm`.`IstBestandsgefuehrt` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `new_view`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `new_view` AS select `tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt` from `tPPProduktpass`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Co2Thumbprint`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Co2Thumbprint` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`InternerStatus` AS `Status`,`tPPProduktpass`.`PPProduktpass_IAN` AS `IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,concat(`tPPProduktpass`.`PPProduktpass_Liefertermin`,'/',`tPPProduktpass`.`PPProduktpass_LieferterminJahr`) AS `Liefertermin`,format(`tPPProduktpass`.`PPProduktpass_Gesamtmenge`,0,'de_DE') AS `GesamtMenge`,`tPPProduktpass`.`PPProduktpass_Zolltarif` AS `Zolltarif`,`tPPProduktpass`.`PPProduktpass_Zollsatz` AS `Zollsatz`,`tPPProduktpass`.`PPProduktpass_TargaTNr` AS `TargaNr`,`PM`.`PPMitarbeiter_Kuerzel` AS `PM`,`PJM`.`PPMitarbeiter_Kuerzel` AS `PMJ`,`TC`.`PPMitarbeiter_Kuerzel` AS `TC`,`M`.`PPProduktpass_Menge_Country` AS `Land`,`M`.`PPProduktpass_Menge_LT1` AS `LT1`,format(`M`.`PPProduktpass_Menge_LT1Menge`,0,'de_DE') AS `MengeLT1`,`M`.`PPProduktpass_Menge_LT2` AS `LT2`,format(`M`.`PPProduktpass_Menge_LT2Menge`,0,'de_DE') AS `MengeLT2`,`M`.`PPProduktpass_Menge_LT3` AS `LT3`,format(`M`.`PPProduktpass_Menge_LT3Menge`,0,'de_DE') AS `MengeLT3`,format(`M`.`PPProduktpass_Menge_Quantity`,0,'de_DE') AS `MengeLTGesamt`,`M`.`PPProduktpass_Menge_DeliveryWeek` AS `DDP` from ((((`tPPProduktpass` join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_PMAdmin`))) join `PPMitarbeiter` `PJM` on((`PJM`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_PJMAdmin`))) join `PPMitarbeiter` `TC` on((`TC`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_TCAdmin`))) join `PPProduktpass_Menge` `M` on((`tPPProduktpass`.`PPProduktpass_Id` = `M`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((`tPPProduktpass`.`InternerStatus` in ('FIX','GELIEFERT')) and (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%'))) and (not((`tPPProduktpass`.`PPProduktpass_IAN` like '99%'))) and (`M`.`PPProduktpass_Menge_Quantity` > 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Laendergewichte`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Laendergewichte` AS with `daten` as (select `h`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`h`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`h`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`h`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`h`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`h`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`h`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`h`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`h`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`h`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`h`.`PPLsv_name` AS `PPLsv_name`,`m`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`m`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`m`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`m`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`m`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`m`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`m`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`m`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`m`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`m`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,coalesce(cast(nullif(trim(`h`.`PPProduktpass_Sortierung_Value02`),'') as decimal(18,4)),0) AS `Value02_Numerisch` from (`hv_assortment` `h` join `hv_IANMengen` `m` on(((`m`.`PPProduktpass_Menge_PPProduktpass_Id` = `h`.`PPOrderWeights_PPProduktpass_Id`) and (find_in_set(concat(trim(`m`.`PPProduktpass_Menge_CountryBlock`),'-',trim(`m`.`PPProduktpass_Menge_Country`)),replace(`h`.`PPProduktpass_Sortierung_Laenderblock`,' ','')) > 0)))) where ((`h`.`PPProduktpass_Sortierung_Value02` > 0) and (`h`.`PPProduktpass_Sortierung_Value02` < 10))), `berechnung` as (select `daten`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`daten`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`daten`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`daten`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`daten`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`daten`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`daten`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`daten`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`daten`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`daten`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`daten`.`PPLsv_name` AS `PPLsv_name`,`daten`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`daten`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`daten`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`daten`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`daten`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`daten`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`daten`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`daten`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`daten`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`daten`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`daten`.`Value02_Numerisch` AS `Value02_Numerisch`,sum(`daten`.`Value02_Numerisch`) OVER (PARTITION BY `daten`.`PPProduktpass_Menge_Id` )  AS `Value02_Summe` from `daten`), `mengenberechnung` as (select `berechnung`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`berechnung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`berechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`berechnung`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`berechnung`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`berechnung`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`berechnung`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`berechnung`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`berechnung`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`berechnung`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`berechnung`.`PPLsv_name` AS `PPLsv_name`,`berechnung`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`berechnung`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`berechnung`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`berechnung`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`berechnung`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`berechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`berechnung`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`berechnung`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`berechnung`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`berechnung`.`Value02_Numerisch` AS `Value02_Numerisch`,`berechnung`.`Value02_Summe` AS `Value02_Summe`,(case when ((upper(trim(`berechnung`.`PPProduktpass_Menge_Country`)) like 'OS%') or (upper(trim(`berechnung`.`PPProduktpass_Menge_Country`)) like 'KO%')) then `berechnung`.`PPProduktpass_Menge_Quantity` when (`berechnung`.`Value02_Summe` > 0) then ((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`) else 0 end) AS `Anteil_Menge_Exakt` from `berechnung`) select `mengenberechnung`.`PPProduktpass_IAN` AS `IAN`,`mengenberechnung`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`mengenberechnung`.`PPProduktpass_Menge_CountryBlock` AS `Laenderblock`,`mengenberechnung`.`PPProduktpass_Menge_Country` AS `Land`,format(`mengenberechnung`.`PPProduktpass_Menge_Quantity`,0,'de_DE') AS `Landesgesamtmenge`,`mengenberechnung`.`PPProduktpass_Sortierung_Header` AS `Style`,format(`mengenberechnung`.`PPProduktpass_Sortierung_Value02`,0,'de_DE') AS `AssortmentMenge`,format(`mengenberechnung`.`Value02_Summe`,0,'de_DE') AS `KITotal`,(case when ((upper(trim(`mengenberechnung`.`PPProduktpass_Menge_Country`)) like 'OS%') or (upper(trim(`mengenberechnung`.`PPProduktpass_Menge_Country`)) like 'KO%')) then 'Sortenrein' else 'Aufteilung nach Assortment' end) AS `Aufteilungsart`,format(`mengenberechnung`.`Anteil_Menge_Exakt`,0,'de_DE') AS `Anteil`,format(`mengenberechnung`.`PPOrderWeights_weight`,2,'de_DE') AS `NettoStückgewicht`,`mengenberechnung`.`PPOrderWeights_unit` AS `Gewichtseinheit`,format((`mengenberechnung`.`Anteil_Menge_Exakt` * `mengenberechnung`.`PPOrderWeights_weight`),2,'de_DE') AS `Gesamtgewicht`,`mengenberechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `LBSort`,`mengenberechnung`.`PPOrderWeights_gtinKL` AS `GTINKL`,`mengenberechnung`.`PPOrderWeights_gtin` AS `GTIN`,`mengenberechnung`.`PPOrderWeights_lsv` AS `LSV`,`mengenberechnung`.`PPLsv_countryNames` AS `Laendernamen`,`mengenberechnung`.`PPLsv_name` AS `LSVName`,`mengenberechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `OWIMLT` from `mengenberechnung` order by `mengenberechnung`.`PPProduktpass_IAN`,`mengenberechnung`.`PPProduktpass_Ausmusterungnummer`,`mengenberechnung`.`PPProduktpass_Menge_Country`,`mengenberechnung`.`PPProduktpass_Sortierung_Header`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_LaendergewichteFKE`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_LaendergewichteFKE` AS with `daten` as (select `h`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`h`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`h`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`h`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`h`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`h`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`h`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`h`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`h`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`h`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`h`.`PPLsv_name` AS `PPLsv_name`,`m`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`m`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`m`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`m`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`m`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`m`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`m`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`m`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`m`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`m`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,coalesce(cast(nullif(trim(`h`.`PPProduktpass_Sortierung_Value02`),'') as decimal(18,4)),0) AS `Value02_Numerisch` from (`hv_assortment` `h` join `hv_IANMengen` `m` on(((`m`.`PPProduktpass_Menge_PPProduktpass_Id` = `h`.`PPOrderWeights_PPProduktpass_Id`) and (find_in_set(concat(trim(`m`.`PPProduktpass_Menge_CountryBlock`),'-',trim(`m`.`PPProduktpass_Menge_Country`)),replace(`h`.`PPProduktpass_Sortierung_Laenderblock`,' ','')) > 0))))), `berechnung` as (select `daten`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`daten`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`daten`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`daten`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`daten`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`daten`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`daten`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`daten`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`daten`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`daten`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`daten`.`PPLsv_name` AS `PPLsv_name`,`daten`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`daten`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`daten`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`daten`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`daten`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`daten`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`daten`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`daten`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`daten`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`daten`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`daten`.`Value02_Numerisch` AS `Value02_Numerisch`,sum(`daten`.`Value02_Numerisch`) OVER (PARTITION BY `daten`.`PPProduktpass_Menge_Id` )  AS `Value02_Summe` from `daten`), `mengenberechnung` as (select `berechnung`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`berechnung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`berechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`berechnung`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`berechnung`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`berechnung`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`berechnung`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`berechnung`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`berechnung`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`berechnung`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`berechnung`.`PPLsv_name` AS `PPLsv_name`,`berechnung`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`berechnung`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`berechnung`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`berechnung`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`berechnung`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`berechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`berechnung`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`berechnung`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`berechnung`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`berechnung`.`Value02_Numerisch` AS `Value02_Numerisch`,`berechnung`.`Value02_Summe` AS `Value02_Summe`,(case when ((upper(trim(`berechnung`.`PPProduktpass_Menge_Country`)) like 'OS%') or (upper(trim(`berechnung`.`PPProduktpass_Menge_Country`)) like 'KO%')) then `berechnung`.`PPProduktpass_Menge_Quantity` when (`berechnung`.`Value02_Summe` > 0) then ((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`) else 0 end) AS `Anteil_Menge_Exakt` from `berechnung`) select `mengenberechnung`.`PPProduktpass_IAN` AS `IAN`,`mengenberechnung`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`mengenberechnung`.`PPProduktpass_Menge_CountryBlock` AS `Laenderblock`,`mengenberechnung`.`PPProduktpass_Menge_Country` AS `Land`,format(`mengenberechnung`.`PPProduktpass_Menge_Quantity`,0,'de_DE') AS `Landesgesamtmenge`,`mengenberechnung`.`PPProduktpass_Sortierung_Header` AS `Style`,format(`mengenberechnung`.`PPProduktpass_Sortierung_Value02`,0,'de_DE') AS `AssortmentMenge`,format(`mengenberechnung`.`Value02_Summe`,0,'de_DE') AS `KITotal`,(case when ((upper(trim(`mengenberechnung`.`PPProduktpass_Menge_Country`)) like 'OS%') or (upper(trim(`mengenberechnung`.`PPProduktpass_Menge_Country`)) like 'KO%')) then 'Sortenrein' else 'Aufteilung nach Assortment' end) AS `Aufteilungsart`,format(`mengenberechnung`.`Anteil_Menge_Exakt`,0,'de_DE') AS `Anteil`,format(`mengenberechnung`.`PPOrderWeights_weight`,2,'de_DE') AS `NettoStückgewicht`,`mengenberechnung`.`PPOrderWeights_unit` AS `Gewichtseinheit`,format((`mengenberechnung`.`Anteil_Menge_Exakt` * `mengenberechnung`.`PPOrderWeights_weight`),2,'de_DE') AS `Gesamtgewicht`,`mengenberechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `LBSort`,`mengenberechnung`.`PPOrderWeights_gtinKL` AS `GTINKL`,`mengenberechnung`.`PPOrderWeights_gtin` AS `GTIN`,`mengenberechnung`.`PPOrderWeights_lsv` AS `LSV`,`mengenberechnung`.`PPLsv_countryNames` AS `Laendernamen`,`mengenberechnung`.`PPLsv_name` AS `LSVName`,`mengenberechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `OWIMLT` from `mengenberechnung` order by `mengenberechnung`.`PPProduktpass_IAN`,`mengenberechnung`.`PPProduktpass_Ausmusterungnummer`,`mengenberechnung`.`PPProduktpass_Menge_Country`,`mengenberechnung`.`PPProduktpass_Sortierung_Header`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Laendergewichte_Alternativ`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Laendergewichte_Alternativ` AS with `daten` as (select `h`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`h`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`h`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`h`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`h`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`h`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`h`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`h`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`h`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`h`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`h`.`PPLsv_name` AS `PPLsv_name`,`m`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`m`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`m`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`m`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`m`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`m`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`m`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,coalesce(cast(nullif(trim(`h`.`PPProduktpass_Sortierung_Value02`),'') as decimal(18,4)),0) AS `Value02_Numerisch` from (`hv_assortment` `h` join `PPProduktpass_Menge` `m` on(((`m`.`PPProduktpass_Menge_PPProduktpass_Id` = `h`.`PPOrderWeights_PPProduktpass_Id`) and regexp_like(concat(',',replace(`h`.`PPProduktpass_Sortierung_Laenderblock`,' ',''),','),concat(',CB[0-9]+-',`m`.`PPProduktpass_Menge_Country`,'(,|$)')))))), `berechnung` as (select `daten`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`daten`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`daten`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`daten`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`daten`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`daten`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`daten`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`daten`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`daten`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`daten`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`daten`.`PPLsv_name` AS `PPLsv_name`,`daten`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`daten`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`daten`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`daten`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`daten`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`daten`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`daten`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`daten`.`Value02_Numerisch` AS `Value02_Numerisch`,sum(`daten`.`Value02_Numerisch`) OVER (PARTITION BY `daten`.`PPProduktpass_Menge_Id` )  AS `Value02_Summe` from `daten`) select `berechnung`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`berechnung`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`berechnung`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`berechnung`.`PPProduktpass_Menge_Quantity` AS `Landesgesamtmenge`,`berechnung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`berechnung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`berechnung`.`Value02_Summe` AS `Value02_Summe`,(case when (`berechnung`.`Value02_Summe` > 0) then ((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`) else 0 end) AS `Anteil_Menge_Exakt`,(case when (`berechnung`.`Value02_Summe` > 0) then round(((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`),0) else 0 end) AS `Anteil_Menge_Gerundet`,`berechnung`.`PPOrderWeights_weight` AS `Gewicht_Je_Einheit`,`berechnung`.`PPOrderWeights_unit` AS `GewichtsEinheit`,(case when (`berechnung`.`Value02_Summe` > 0) then (((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`) * `berechnung`.`PPOrderWeights_weight`) else 0 end) AS `Gesamtgewicht_Exakt`,(case when (`berechnung`.`Value02_Summe` > 0) then (round(((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`),0) * `berechnung`.`PPOrderWeights_weight`) else 0 end) AS `Gesamtgewicht_Gerundet`,`berechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`berechnung`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`berechnung`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`berechnung`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`berechnung`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`berechnung`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`berechnung`.`PPLsv_name` AS `PPLsv_name`,`berechnung`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`berechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`berechnung`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks` from `berechnung` where ((`berechnung`.`PPProduktpass_Sortierung_Value02` < 10) and (`berechnung`.`PPProduktpass_Sortierung_Value02` > 0)) order by `berechnung`.`PPOrderWeights_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Menge_Country`,`berechnung`.`PPProduktpass_Sortierung_Header`,`berechnung`.`PPOrderWeights_lsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Laendergewichte_II`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Laendergewichte_II` AS with `daten` as (select `h`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`h`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`h`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`h`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`h`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`h`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`h`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`h`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`h`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`h`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`h`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`h`.`PPLsv_name` AS `PPLsv_name`,`m`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`m`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`m`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`m`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`m`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`m`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`m`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`m`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,coalesce(cast(nullif(trim(`h`.`PPProduktpass_Sortierung_Value02`),'') as decimal(18,4)),0) AS `Value02_Numerisch` from (`hv_assortment` `h` join `PPProduktpass_Menge` `m` on(((`m`.`PPProduktpass_Menge_PPProduktpass_Id` = `h`.`PPOrderWeights_PPProduktpass_Id`) and regexp_like(concat(',',replace(`h`.`PPProduktpass_Sortierung_Laenderblock`,' ',''),','),concat(',CB[0-9]+-',`m`.`PPProduktpass_Menge_Country`,'(,|$)')))))), `berechnung` as (select `daten`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`daten`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`daten`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`daten`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`daten`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`daten`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`daten`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`daten`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`daten`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`daten`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`daten`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`daten`.`PPLsv_name` AS `PPLsv_name`,`daten`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`daten`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`daten`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`daten`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`daten`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`daten`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`daten`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`daten`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`daten`.`Value02_Numerisch` AS `Value02_Numerisch`,sum(`daten`.`Value02_Numerisch`) OVER (PARTITION BY `daten`.`PPProduktpass_Menge_Id` )  AS `Value02_Summe` from `daten`), `mengenberechnung` as (select `berechnung`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`berechnung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`berechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`berechnung`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`berechnung`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`berechnung`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`berechnung`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`berechnung`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`berechnung`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`berechnung`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`berechnung`.`PPLsv_name` AS `PPLsv_name`,`berechnung`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`berechnung`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`berechnung`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`berechnung`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`berechnung`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`berechnung`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`berechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`berechnung`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks`,`berechnung`.`Value02_Numerisch` AS `Value02_Numerisch`,`berechnung`.`Value02_Summe` AS `Value02_Summe`,(case when ((upper(trim(`berechnung`.`PPProduktpass_Menge_Country`)) like 'OS%') or (upper(trim(`berechnung`.`PPProduktpass_Menge_Country`)) like 'KO%')) then `berechnung`.`PPProduktpass_Menge_Quantity` when (`berechnung`.`Value02_Summe` > 0) then ((`berechnung`.`PPProduktpass_Menge_Quantity` * `berechnung`.`Value02_Numerisch`) / `berechnung`.`Value02_Summe`) else 0 end) AS `Anteil_Menge_Exakt` from `berechnung`) select `mengenberechnung`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`mengenberechnung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`mengenberechnung`.`PPProduktpass_Menge_Id` AS `PPProduktpass_Menge_Id`,`mengenberechnung`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`mengenberechnung`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock`,`mengenberechnung`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`mengenberechnung`.`PPProduktpass_Menge_Quantity` AS `Landesgesamtmenge`,`mengenberechnung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`mengenberechnung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`mengenberechnung`.`Value02_Summe` AS `Value02_Summe`,(case when ((upper(trim(`mengenberechnung`.`PPProduktpass_Menge_Country`)) like 'OS%') or (upper(trim(`mengenberechnung`.`PPProduktpass_Menge_Country`)) like 'KO%')) then 'Keine Aufteilung' else 'Aufteilung nach Value02' end) AS `Aufteilungsart`,`mengenberechnung`.`Anteil_Menge_Exakt` AS `Anteil_Menge_Exakt`,round(`mengenberechnung`.`Anteil_Menge_Exakt`,0) AS `Anteil_Menge_Gerundet`,`mengenberechnung`.`PPOrderWeights_weight` AS `Gewicht_Je_Einheit`,`mengenberechnung`.`PPOrderWeights_unit` AS `Gewichtseinheit`,(`mengenberechnung`.`Anteil_Menge_Exakt` * `mengenberechnung`.`PPOrderWeights_weight`) AS `Gesamtgewicht_Exakt`,(round(`mengenberechnung`.`Anteil_Menge_Exakt`,0) * `mengenberechnung`.`PPOrderWeights_weight`) AS `Gesamtgewicht_Gerundet`,`mengenberechnung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`mengenberechnung`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`mengenberechnung`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`mengenberechnung`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`mengenberechnung`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`mengenberechnung`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`mengenberechnung`.`PPLsv_name` AS `PPLsv_name`,`mengenberechnung`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`mengenberechnung`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`mengenberechnung`.`PPProduktpass_Menge_countryRemarks` AS `PPProduktpass_Menge_countryRemarks` from `mengenberechnung` where ((`mengenberechnung`.`PPProduktpass_Sortierung_Value02` < 10) and (`mengenberechnung`.`PPProduktpass_Sortierung_Value02` > 0)) order by `mengenberechnung`.`PPOrderWeights_PPProduktpass_Id`,`mengenberechnung`.`PPProduktpass_Menge_Country`,`mengenberechnung`.`PPProduktpass_Sortierung_Header`,`mengenberechnung`.`PPOrderWeights_lsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_LaendermengenUebersicht`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_LaendermengenUebersicht` AS select `P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`M`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`M`.`PPProduktpass_Menge_LT1` AS `PPProduktpass_Menge_LT1`,`M`.`PPProduktpass_Menge_LT1Menge` AS `PPProduktpass_Menge_LT1Menge`,`M`.`PPProduktpass_Menge_LT2` AS `PPProduktpass_Menge_LT2`,`M`.`PPProduktpass_Menge_LT2Menge` AS `PPProduktpass_Menge_LT2Menge`,`M`.`PPProduktpass_Menge_LT3` AS `PPProduktpass_Menge_LT3`,`M`.`PPProduktpass_Menge_LT3Menge` AS `PPProduktpass_Menge_LT3Menge`,`M`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`M`.`PPProduktpass_Menge_CountryBlock` AS `PPProduktpass_Menge_CountryBlock` from (`tPPProduktpass` `P` join `PPProduktpass_Menge` `M` on((`P`.`PPProduktpass_Id` = `M`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (`M`.`PPProduktpass_Menge_LT1Menge` is not null) and (`M`.`PPProduktpass_Menge_LT1Menge` > 0) and (not((`P`.`PPProduktpass_IAN` like '99%')))) order by `P`.`InternerStatus`,`P`.`PPProduktpass_Ausmusterungnummer` desc,`P`.`PPProduktpass_IAN` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_ProduktMenge`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_ProduktMenge` AS select concat(`P`.`PPProduktpass_IAN`,'_',substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4)) AS `Produkt`,`M`.`PPProduktpass_Menge_Country` AS `Land`,format(`M`.`PPProduktpass_Menge_Quantity`,0,'de_DE') AS `Gesamtmenge`,`M`.`PPProduktpass_Menge_DeliveryWeek` AS `DELIVERY`,format(ifnull(`M`.`PPProduktpass_Menge_LT1Menge`,0),0,'de_DE') AS `LT1Menge`,ifnull(`M`.`PPProduktpass_Menge_LT1`,'') AS `LT1`,format(ifnull(`M`.`PPProduktpass_Menge_LT2Menge`,0),0,'de_DE') AS `LT2Menge`,ifnull(`M`.`PPProduktpass_Menge_LT2`,'') AS `LT2`,format(ifnull(`M`.`PPProduktpass_Menge_LT3Menge`,0),0,'de_DE') AS `LT3Menge`,ifnull(`M`.`PPProduktpass_Menge_LT3`,'') AS `LT3` from (`PPProduktpass_Menge` `M` join `tPPProduktpass` `P` on((`P`.`PPProduktpass_Id` = `M`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))) and (`P`.`InternerStatus` in ('FIX','GELIEFERT')) and (ifnull(`M`.`PPProduktpass_Menge_LT1Menge`,0) > 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Produktpass`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Produktpass` AS select `P`.`PPProduktpass_IAN` AS `IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterungnummer`,`P`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`P`.`PPProduktpass_Warengruppe` AS `Warengruppe`,`P`.`PPProduktpass_Thema` AS `Thema`,`P`.`PPProduktpass_Gesamtmenge` AS `Gesamtmenge`,concat(`P`.`PPProduktpass_Liefertermin`,'/',`P`.`PPProduktpass_LieferterminJahr`) AS `Liefertermin`,`MPM`.`PPMitarbeiter_Kuerzel` AS `PM`,`MPJM`.`PPMitarbeiter_Kuerzel` AS `PJM`,`MTC`.`PPMitarbeiter_Kuerzel` AS `TC`,concat(`P`.`PPProduktpass_CRDWoche`,'/',`P`.`PPProduktpass_CRDJahr`) AS `CRD`,`MPJMV`.`PPMitarbeiter_Kuerzel` AS `PJM_VTR`,`MPMV`.`PPMitarbeiter_Kuerzel` AS `PM_VTR`,`MTCV`.`PPMitarbeiter_Kuerzel` AS `TC_VTR`,`P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`T`.`PPTermine_Label` AS `UmsetzbarkeitAnzeigetext`,`P`.`catalogue_initialOrder` AS `catalogue_initialOrder`,`P`.`catalogue_isCatalogue` AS `catalogue_isCatalogue`,`P`.`catalogue_initialCharge` AS `catalogue_initialCharge`,`P`.`catalogue_lotNumber` AS `catalogue_lotNumber`,`P`.`PPProduktpass_Marke` AS `EigenmarkeLidl`,`P`.`PPProduktpass_KauflandMarke` AS `EigenmarkeKaufland`,`P`.`PPProduktpass_ThemaScope` AS `Bereich`,`P`.`PPProduktpass_shelfLife` AS `Restlaufzeit`,`v_lastStatusChange`.`DatumStatusAenderung` AS `DatumStatusAenderung`,`v_lastStatusChange`.`Alter_Status` AS `Alter_Status`,`v_lastStatusChange`.`Neuer_Status` AS `Neuer_Status`,`v_lastStatusChange`.`Mitarbeiter` AS `MitarbeiterStatusAenderung`,`P`.`PPProduktpass_Zolltarif` AS `Zolltarif`,`P`.`PPProduktpass_Zollsatz` AS `Zollsatz`,`P`.`PPProduktpass_Import_Datum` AS `XMLImportDatum`,`P`.`PPProduktpass_Absagegrund` AS `Absagegrund`,`P`.`statusDoc` AS `LIDL_Status`,`P`.`ngoTest` AS `NGO_Pruefung`,`P`.`ngoTestNote` AS `NGO_Pruefung_Bem`,`P`.`LFGB` AS `LFGB`,`P`.`referenceCheck` AS `Referenztest`,if((`PV`.`PruefplanAnzahl` > 0),'true','false') AS `Pruefplan`,`PORD`.`PPOrder_euDataAct` AS `EUDataAct`,concat(trim(upper(`P`.`PPProduktpass_IAN`)),'_',left(trim(upper(ifnull(`P`.`PPProduktpass_Ausmusterungnummer`,''))),4)) AS `ExternalID` from ((((((((((`tPPProduktpass` `P` left join `PPMitarbeiter` `MPM` on((`MPM`.`id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `MPJM` on((`MPJM`.`id` = `P`.`PPProduktpass_PJMAdmin`))) left join `PPMitarbeiter` `MTC` on((`MTC`.`id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MPMV` on((`MPMV`.`id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `MPJMV` on((`MPJMV`.`id` = `P`.`PPProduktpass_PJMAdminVTR`))) left join `PPMitarbeiter` `MTCV` on((`MTCV`.`id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) left join `v_lastStatusChange` on(((`P`.`PPProduktpass_IAN` = `v_lastStatusChange`.`IAN`) and (left(`P`.`PPProduktpass_Ausmusterungnummer`,4) = `v_lastStatusChange`.`Charge`)))) left join `rpt_PruefplanVorhanden` `PV` on((`P`.`PPProduktpass_Id` = `PV`.`PPProduktpass_Id`))) left join `PPOrder` `PORD` on((`PORD`.`PPOrder_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) where ((`T`.`PPTermine_PPBoardSpalte_id` = 1069) and (not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_ProduktpassMMI`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_ProduktpassMMI` AS select `src`.`IAN` AS `IAN`,`src`.`Artikelbezeichnung` AS `Artikelbezeichnung`,`src`.`Ausmusterungnummer` AS `Ausmusterungnummer`,`src`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`src`.`Warengruppe` AS `Warengruppe`,`src`.`Thema` AS `Thema`,`src`.`Gesamtmenge` AS `Gesamtmenge`,`src`.`Liefertermin` AS `Liefertermin`,`src`.`PM` AS `PM`,`src`.`PJM` AS `PJM`,`src`.`TC` AS `TC`,`src`.`CRD` AS `CRD`,`src`.`PJM_VTR` AS `PJM_VTR`,`src`.`PM_VTR` AS `PM_VTR`,`src`.`TC_VTR` AS `TC_VTR`,`src`.`InternerStatus` AS `InternerStatus`,`src`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`src`.`UmsetzbarkeitAnzeigetext` AS `UmsetzbarkeitAnzeigetext`,`src`.`catalogue_initialOrder` AS `catalogue_initialOrder`,`src`.`catalogue_isCatalogue` AS `catalogue_isCatalogue`,`src`.`catalogue_initialCharge` AS `catalogue_initialCharge`,`src`.`catalogue_lotNumber` AS `catalogue_lotNumber`,`src`.`EigenmarkeLidl` AS `EigenmarkeLidl`,`src`.`EigenmarkeKaufland` AS `EigenmarkeKaufland`,`src`.`Bereich` AS `Bereich`,`src`.`Restlaufzeit` AS `Restlaufzeit`,`src`.`GarantiezeitDauer` AS `GarantiezeitDauer`,`src`.`GarantieArt` AS `GarantieArt`,`src`.`DatumStatusAenderung` AS `DatumStatusAenderung`,`src`.`Alter_Status` AS `Alter_Status`,`src`.`Neuer_Status` AS `Neuer_Status`,`src`.`MitarbeiterStatusAenderung` AS `MitarbeiterStatusAenderung`,`src`.`Zolltarif` AS `Zolltarif`,`src`.`Zollsatz` AS `Zollsatz`,`src`.`XMLImportDatum` AS `XMLImportDatum`,`src`.`Absagegrund` AS `Absagegrund`,`src`.`LIDL_Status` AS `LIDL_Status`,`src`.`NGO_Pruefung` AS `NGO_Pruefung`,`src`.`NGO_Pruefung_Bem` AS `NGO_Pruefung_Bem`,`src`.`LFGB` AS `LFGB`,`src`.`Referenztest` AS `Referenztest`,`src`.`Pruefplan` AS `Pruefplan`,`src`.`EUDataAct` AS `EUDataAct`,md5(concat(convert(ifnull(`src`.`IAN`,'') using utf8mb4),'|',convert(ifnull(`src`.`Artikelbezeichnung`,'') using utf8mb4),'|',convert(ifnull(`src`.`Ausmusterungnummer`,'') using utf8mb4),'|',convert(ifnull(`src`.`PPProduktpass_Einkaeufer`,'') using utf8mb4),'|',convert(ifnull(`src`.`Warengruppe`,'') using utf8mb4),'|',convert(ifnull(`src`.`Thema`,'') using utf8mb4),'|',ifnull(cast(`src`.`Gesamtmenge` as char charset utf8mb4),''),'|',ifnull(`src`.`Liefertermin`,''),'|',convert(ifnull(`src`.`PM`,'') using utf8mb4),'|',convert(ifnull(`src`.`PJM`,'') using utf8mb4),'|',convert(ifnull(`src`.`TC`,'') using utf8mb4),'|',ifnull(`src`.`CRD`,''),'|',convert(ifnull(`src`.`PJM_VTR`,'') using utf8mb4),'|',convert(ifnull(`src`.`PM_VTR`,'') using utf8mb4),'|',convert(ifnull(`src`.`TC_VTR`,'') using utf8mb4),'|',convert(ifnull(`src`.`InternerStatus`,'') using utf8mb4),'|',convert(ifnull(`src`.`PPProduktpass_Pruefinstitut`,'') using utf8mb4),'|',convert(ifnull(`src`.`UmsetzbarkeitAnzeigetext`,'') using utf8mb4),'|',ifnull(`src`.`catalogue_initialOrder`,''),'|',ifnull(`src`.`catalogue_isCatalogue`,''),'|',ifnull(`src`.`catalogue_initialCharge`,''),'|',ifnull(`src`.`catalogue_lotNumber`,''),'|',convert(ifnull(`src`.`EigenmarkeLidl`,'') using utf8mb4),'|',convert(ifnull(`src`.`EigenmarkeKaufland`,'') using utf8mb4),'|',convert(ifnull(`src`.`Bereich`,'') using utf8mb4),'|',ifnull(`src`.`Restlaufzeit`,''),'|',ifnull(`src`.`GarantiezeitDauer`,''),'|',convert(ifnull(`src`.`GarantieArt`,'') using utf8mb4),'|',ifnull(`src`.`DatumStatusAenderung`,''),'|',convert(ifnull(`src`.`Alter_Status`,'') using utf8mb4),'|',convert(ifnull(`src`.`Neuer_Status`,'') using utf8mb4),'|',convert(ifnull(`src`.`MitarbeiterStatusAenderung`,'') using utf8mb4),'|',ifnull(`src`.`Zolltarif`,''),'|',ifnull(`src`.`Zollsatz`,''),'|',ifnull(`src`.`XMLImportDatum`,''),'|',convert(ifnull(`src`.`Absagegrund`,'') using utf8mb4),'|',convert(ifnull(`src`.`LIDL_Status`,'') using utf8mb4),'|',ifnull(`src`.`NGO_Pruefung`,''),'|',convert(ifnull(`src`.`NGO_Pruefung_Bem`,'') using utf8mb4),'|',ifnull(`src`.`LFGB`,''),'|',ifnull(`src`.`Referenztest`,''),'|',ifnull(`src`.`Pruefplan`,''),'|',ifnull(`src`.`EUDataAct`,''))) AS `RowHash`,concat(ifnull(`src`.`IAN`,''),'_',left(trim(upper(ifnull(`src`.`Ausmusterungnummer`,''))),4)) AS `ExternalID` from (select trim(upper(ifnull(`P`.`PPProduktpass_IAN`,''))) AS `IAN`,ifnull(nullif(trim(replace(replace(replace(`P`.`PPProduktpass_Artikelbezeichnung`,char(13),' '),char(10),' '),';',',')),''),'') AS `Artikelbezeichnung`,left(trim(ifnull(`P`.`PPProduktpass_Ausmusterungnummer`,'')),4) AS `Ausmusterungnummer`,ifnull(nullif(trim(`P`.`PPProduktpass_Einkaeufer`),''),'') AS `PPProduktpass_Einkaeufer`,ifnull(nullif(trim(`P`.`PPProduktpass_Warengruppe`),''),'') AS `Warengruppe`,ifnull(nullif(trim(replace(replace(replace(`P`.`PPProduktpass_Thema`,char(13),' '),char(10),' '),';',',')),''),'') AS `Thema`,ifnull(`P`.`PPProduktpass_Gesamtmenge`,0) AS `Gesamtmenge`,(case when ((ifnull(trim(cast(`P`.`PPProduktpass_Liefertermin` as char charset utf8mb4)),'') = '') and (ifnull(trim(cast(`P`.`PPProduktpass_LieferterminJahr` as char charset utf8mb4)),'') = '')) then '' else concat(ifnull(trim(cast(`P`.`PPProduktpass_Liefertermin` as char charset utf8mb4)),''),'/',ifnull(trim(cast(`P`.`PPProduktpass_LieferterminJahr` as char charset utf8mb4)),'')) end) AS `Liefertermin`,ifnull(nullif(trim(`MPM`.`PPMitarbeiter_Kuerzel`),''),'') AS `PM`,ifnull(nullif(trim(`MPJM`.`PPMitarbeiter_Kuerzel`),''),'') AS `PJM`,ifnull(nullif(trim(`MTC`.`PPMitarbeiter_Kuerzel`),''),'') AS `TC`,(case when ((ifnull(trim(cast(`P`.`PPProduktpass_CRDWoche` as char charset utf8mb4)),'') = '') and (ifnull(trim(cast(`P`.`PPProduktpass_CRDJahr` as char charset utf8mb4)),'') = '')) then '' else concat(ifnull(trim(cast(`P`.`PPProduktpass_CRDWoche` as char charset utf8mb4)),''),'/',ifnull(trim(cast(`P`.`PPProduktpass_CRDJahr` as char charset utf8mb4)),'')) end) AS `CRD`,ifnull(nullif(trim(`MPJMV`.`PPMitarbeiter_Kuerzel`),''),'') AS `PJM_VTR`,ifnull(nullif(trim(`MPMV`.`PPMitarbeiter_Kuerzel`),''),'') AS `PM_VTR`,ifnull(nullif(trim(`MTCV`.`PPMitarbeiter_Kuerzel`),''),'') AS `TC_VTR`,ifnull(nullif(trim(`P`.`InternerStatus`),''),'') AS `InternerStatus`,ifnull(nullif(trim(replace(replace(replace(`P`.`PPProduktpass_Pruefinstitut`,char(13),' '),char(10),' '),';',',')),''),'') AS `PPProduktpass_Pruefinstitut`,ifnull(nullif(trim(replace(replace(replace(`T`.`PPTermine_Label`,char(13),' '),char(10),' '),';',',')),''),'') AS `UmsetzbarkeitAnzeigetext`,(case when ((`P`.`catalogue_initialOrder` is null) or (trim(cast(`P`.`catalogue_initialOrder` as char charset utf8mb4)) = '')) then '' when (lower(trim(cast(`P`.`catalogue_initialOrder` as char charset utf8mb4))) in ('1','true','ja','yes')) then 'ja' else 'nein' end) AS `catalogue_initialOrder`,(case when ((`P`.`catalogue_isCatalogue` is null) or (trim(cast(`P`.`catalogue_isCatalogue` as char charset utf8mb4)) = '')) then '' when (lower(trim(cast(`P`.`catalogue_isCatalogue` as char charset utf8mb4))) in ('1','true','ja','yes')) then 'ja' else 'nein' end) AS `catalogue_isCatalogue`,ifnull(nullif(trim(cast(`P`.`catalogue_initialCharge` as char charset utf8mb4)),''),'') AS `catalogue_initialCharge`,ifnull(nullif(trim(cast(`P`.`catalogue_lotNumber` as char charset utf8mb4)),''),'') AS `catalogue_lotNumber`,ifnull(nullif(trim(`P`.`PPProduktpass_Marke`),''),'') AS `EigenmarkeLidl`,ifnull(nullif(trim(`P`.`PPProduktpass_KauflandMarke`),''),'') AS `EigenmarkeKaufland`,ifnull(nullif(trim(`P`.`PPProduktpass_ThemaScope`),''),'') AS `Bereich`,ifnull(nullif(trim(cast(`P`.`PPProduktpass_shelfLife` as char charset utf8mb4)),''),'') AS `Restlaufzeit`,ifnull(nullif(trim(cast(`P`.`PPProduktpass_GarantiezeitDauer` as char charset utf8mb4)),''),'') AS `GarantiezeitDauer`,ifnull(nullif(trim(`P`.`Garantie_Art`),''),'') AS `GarantieArt`,(case when ((`v_lastStatusChange`.`DatumStatusAenderung` is null) or (trim(cast(`v_lastStatusChange`.`DatumStatusAenderung` as char charset utf8mb4)) in ('','0000-00-00','0000-00-00 00:00:00'))) then '1999-01-01 00:00:00' else date_format(`v_lastStatusChange`.`DatumStatusAenderung`,'%Y-%m-%d %H:%i:%s') end) AS `DatumStatusAenderung`,ifnull(nullif(trim(`v_lastStatusChange`.`Alter_Status`),''),'') AS `Alter_Status`,ifnull(nullif(trim(`v_lastStatusChange`.`Neuer_Status`),''),'') AS `Neuer_Status`,ifnull(nullif(trim(`v_lastStatusChange`.`Mitarbeiter`),''),'') AS `MitarbeiterStatusAenderung`,ifnull(nullif(trim(cast(`P`.`PPProduktpass_Zolltarif` as char charset utf8mb4)),''),'') AS `Zolltarif`,ifnull(nullif(trim(cast(`P`.`PPProduktpass_Zollsatz` as char charset utf8mb4)),''),'') AS `Zollsatz`,(case when ((`P`.`PPProduktpass_Import_Datum` is null) or (trim(cast(`P`.`PPProduktpass_Import_Datum` as char charset utf8mb4)) in ('','0000-00-00','0000-00-00 00:00:00'))) then '1999-01-01 00:00:00' else date_format(`P`.`PPProduktpass_Import_Datum`,'%Y-%m-%d %H:%i:%s') end) AS `XMLImportDatum`,ifnull(nullif(trim(replace(replace(replace(`P`.`PPProduktpass_Absagegrund`,char(13),' '),char(10),' '),';',',')),''),'') AS `Absagegrund`,ifnull(nullif(trim(`P`.`statusDoc`),''),'') AS `LIDL_Status`,(case when (lower(trim(cast(`P`.`ngoTest` as char charset utf8mb4))) in ('1','true','ja','yes')) then 'ja' else 'nein' end) AS `NGO_Pruefung`,ifnull(nullif(trim(replace(replace(replace(`P`.`ngoTestNote`,char(13),' '),char(10),' '),';',',')),''),'') AS `NGO_Pruefung_Bem`,(case when (lower(trim(cast(`P`.`LFGB` as char charset utf8mb4))) in ('1','true','ja','yes')) then 'ja' else 'nein' end) AS `LFGB`,(case when (lower(trim(cast(`P`.`referenceCheck` as char charset utf8mb4))) in ('1','true','ja','yes')) then 'ja' else 'nein' end) AS `Referenztest`,(case when (ifnull(`PV`.`PruefplanAnzahl`,0) > 0) then 'ja' else 'nein' end) AS `Pruefplan`,(case when ((`PORD`.`PPOrder_euDataAct` is null) or (trim(cast(`PORD`.`PPOrder_euDataAct` as char charset utf8mb4)) = '')) then '' when (lower(trim(cast(`PORD`.`PPOrder_euDataAct` as char charset utf8mb4))) in ('1','true','ja','yes')) then 'ja' else 'nein' end) AS `EUDataAct` from ((((((((((`tPPProduktpass` `P` left join `PPMitarbeiter` `MPM` on((`MPM`.`id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `MPJM` on((`MPJM`.`id` = `P`.`PPProduktpass_PJMAdmin`))) left join `PPMitarbeiter` `MTC` on((`MTC`.`id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MPMV` on((`MPMV`.`id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `MPJMV` on((`MPJMV`.`id` = `P`.`PPProduktpass_PJMAdminVTR`))) left join `PPMitarbeiter` `MTCV` on((`MTCV`.`id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) left join `v_lastStatusChange` on(((`P`.`PPProduktpass_IAN` = `v_lastStatusChange`.`IAN`) and (left(`P`.`PPProduktpass_Ausmusterungnummer`,4) = `v_lastStatusChange`.`Charge`)))) left join `rpt_PruefplanVorhanden` `PV` on((`P`.`PPProduktpass_Id` = `PV`.`PPProduktpass_Id`))) left join `PPOrder` `PORD` on((`PORD`.`PPOrder_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) where ((`T`.`PPTermine_PPBoardSpalte_id` = 1069) and (not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))))) `src`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_ProduktpassPruefplan`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_ProduktpassPruefplan` AS select `P`.`PPProduktpass_IAN` AS `IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterungnummer`,`P`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`P`.`PPProduktpass_Warengruppe` AS `Warengruppe`,`P`.`PPProduktpass_Thema` AS `Thema`,`P`.`PPProduktpass_Gesamtmenge` AS `Gesamtmenge`,concat(`P`.`PPProduktpass_Liefertermin`,'/',`P`.`PPProduktpass_LieferterminJahr`) AS `Liefertermin`,`MPM`.`PPMitarbeiter_Kuerzel` AS `PM`,`MPJM`.`PPMitarbeiter_Kuerzel` AS `PJM`,`MTC`.`PPMitarbeiter_Kuerzel` AS `TC`,concat(`P`.`PPProduktpass_CRDWoche`,'/',`P`.`PPProduktpass_CRDJahr`) AS `CRD`,`MPJMV`.`PPMitarbeiter_Kuerzel` AS `PJM_VTR`,`MPMV`.`PPMitarbeiter_Kuerzel` AS `PM_VTR`,`MTCV`.`PPMitarbeiter_Kuerzel` AS `TC_VTR`,`P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`T`.`PPTermine_Label` AS `UmsetzbarkeitAnzeigetext`,`P`.`catalogue_initialOrder` AS `catalogue_initialOrder`,`P`.`catalogue_isCatalogue` AS `catalogue_isCatalogue`,`P`.`catalogue_initialCharge` AS `catalogue_initialCharge`,`P`.`catalogue_lotNumber` AS `catalogue_lotNumber`,`P`.`PPProduktpass_Marke` AS `EigenmarkeLidl`,`P`.`PPProduktpass_KauflandMarke` AS `EigenmarkeKaufland`,`P`.`PPProduktpass_ThemaScope` AS `Bereich`,`P`.`PPProduktpass_shelfLife` AS `Restlaufzeit`,`v_lastStatusChange`.`DatumStatusAenderung` AS `DatumStatusAenderung`,`v_lastStatusChange`.`Alter_Status` AS `Alter_Status`,`v_lastStatusChange`.`Neuer_Status` AS `Neuer_Status`,`v_lastStatusChange`.`Mitarbeiter` AS `MitarbeiterStatusAenderung`,`P`.`PPProduktpass_Zolltarif` AS `Zolltarif`,`P`.`PPProduktpass_Zollsatz` AS `Zollsatz`,`P`.`PPProduktpass_Import_Datum` AS `XMLImportDatum`,`P`.`PPProduktpass_Absagegrund` AS `Absagegrund`,`P`.`statusDoc` AS `LIDL_Status`,`P`.`ngoTest` AS `NGO_Pruefung`,`P`.`ngoTestNote` AS `NGO_Pruefung_Bem`,`P`.`LFGB` AS `LFGB`,`P`.`referenceCheck` AS `Referenztest`,(`PV`.`PruefplanAnzahl` > 0) AS `PruefplanAnzahl` from (((((((((`tPPProduktpass` `P` left join `PPMitarbeiter` `MPM` on((`MPM`.`id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `MPJM` on((`MPJM`.`id` = `P`.`PPProduktpass_PJMAdmin`))) left join `PPMitarbeiter` `MTC` on((`MTC`.`id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MPMV` on((`MPMV`.`id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `MPJMV` on((`MPJMV`.`id` = `P`.`PPProduktpass_PJMAdminVTR`))) left join `PPMitarbeiter` `MTCV` on((`MTCV`.`id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) left join `v_lastStatusChange` on(((`P`.`PPProduktpass_IAN` = `v_lastStatusChange`.`IAN`) and (`P`.`PPProduktpass_Ausmusterungnummer` = `v_lastStatusChange`.`Charge`)))) left join `rpt_PruefplanVorhanden` `PV` on((`P`.`PPProduktpass_Id` = `PV`.`PPProduktpass_Id`))) where ((`T`.`PPTermine_PPBoardSpalte_id` = 1069) and (not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Produktpass_Save`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Produktpass_Save` AS select `P`.`PPProduktpass_IAN` AS `IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterungnummer`,`P`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`P`.`PPProduktpass_Warengruppe` AS `Warengruppe`,`P`.`PPProduktpass_Thema` AS `Thema`,`P`.`PPProduktpass_Gesamtmenge` AS `Gesamtmenge`,concat(`P`.`PPProduktpass_Liefertermin`,'/',`P`.`PPProduktpass_LieferterminJahr`) AS `Liefertermin`,`MPM`.`PPMitarbeiter_Kuerzel` AS `PM`,`MPJM`.`PPMitarbeiter_Kuerzel` AS `PJM`,`MTC`.`PPMitarbeiter_Kuerzel` AS `TC`,concat(`P`.`PPProduktpass_CRDWoche`,'/',`P`.`PPProduktpass_CRDJahr`) AS `CRD`,`MPJMV`.`PPMitarbeiter_Kuerzel` AS `PJM_VTR`,`MPMV`.`PPMitarbeiter_Kuerzel` AS `PM_VTR`,`MTCV`.`PPMitarbeiter_Kuerzel` AS `TC_VTR`,`P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`T`.`PPTermine_Label` AS `UmsetzbarkeitAnzeigetext`,`P`.`catalogue_initialOrder` AS `catalogue_initialOrder`,`P`.`catalogue_isCatalogue` AS `catalogue_isCatalogue`,`P`.`catalogue_initialCharge` AS `catalogue_initialCharge`,`P`.`catalogue_lotNumber` AS `catalogue_lotNumber`,`P`.`PPProduktpass_Marke` AS `EigenmarkeLidl`,`P`.`PPProduktpass_KauflandMarke` AS `EigenmarkeKaufland`,`P`.`PPProduktpass_ThemaScope` AS `Bereich`,`P`.`PPProduktpass_shelfLife` AS `Restlaufzeit`,`v_lastStatusChange`.`DatumStatusAenderung` AS `DatumStatusAenderung`,`v_lastStatusChange`.`Alter_Status` AS `Alter_Status`,`v_lastStatusChange`.`Neuer_Status` AS `Neuer_Status`,`v_lastStatusChange`.`Mitarbeiter` AS `MitarbeiterStatusAenderung`,`P`.`PPProduktpass_Zolltarif` AS `Zolltarif`,`P`.`PPProduktpass_Zollsatz` AS `Zollsatz`,`P`.`PPProduktpass_Import_Datum` AS `XMLImportDatum`,`P`.`PPProduktpass_Absagegrund` AS `Absagegrund`,`P`.`statusDoc` AS `LIDL_Status`,`P`.`ngoTest` AS `NGO_Pruefung`,`P`.`ngoTestNote` AS `NGO_Pruefung_Bem`,`P`.`LFGB` AS `LFGB`,`P`.`referenceCheck` AS `Referenztest` from ((((((((`tPPProduktpass` `P` left join `PPMitarbeiter` `MPM` on((`MPM`.`id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `MPJM` on((`MPJM`.`id` = `P`.`PPProduktpass_PJMAdmin`))) left join `PPMitarbeiter` `MTC` on((`MTC`.`id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MPMV` on((`MPMV`.`id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `MPJMV` on((`MPJMV`.`id` = `P`.`PPProduktpass_PJMAdminVTR`))) left join `PPMitarbeiter` `MTCV` on((`MTCV`.`id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) left join `v_lastStatusChange` on(((`P`.`PPProduktpass_IAN` = `v_lastStatusChange`.`IAN`) and (`P`.`PPProduktpass_Ausmusterungnummer` = `v_lastStatusChange`.`Charge`)))) where ((`T`.`PPTermine_PPBoardSpalte_id` = 1069) and (not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_ProjektMitBattrien`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_ProjektMitBattrien` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPproduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,if((`hv_hasBattery`.`PPPPFiles_PPProduktpass_Id` is null),'keine Battery Anlage','mit Batterie Anlage') AS `BatterieAnlage` from (`tPPProduktpass` left join `hv_hasBattery` on((`hv_hasBattery`.`PPPPFiles_PPProduktpass_Id` = `tPPProduktpass`.`PPProduktpass_Id`))) where (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_PruefplanVorhanden`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_PruefplanVorhanden` AS select `P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,count(distinct `F`.`PPPPFiles_Name`) AS `PruefplanAnzahl` from (`tPPProduktpass` `P` left join `PPPPFiles` `F` on(((`F`.`PPPPFiles_Status` = 1) and (`F`.`PPPPFiles_PPProduktpass_Id` = `P`.`PPProduktpass_Id`) and ((`F`.`PPPPFiles_Name` like '%Test_Plan%') or (`F`.`PPPPFiles_Name` like '%Testplan%') or (`F`.`PPPPFiles_Name` like '%Prüfplan%') or (`F`.`PPPPFiles_Name` like '%Pruefplan%') or (`F`.`PPPPFiles_Name` like '%Prüfkatalog%') or (`F`.`PPPPFiles_Name` like '%Pruefkatalog%'))))) where (not((`P`.`PPProduktpass_IAN` like '%ev%'))) group by `P`.`PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_Shipments`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_Shipments` AS select `k`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`k`.`Ausmusterung` AS `Ausmusterung`,`k`.`IAN` AS `IAN`,`k`.`Artikelbezeichnung` AS `Artikelbezeichnung`,`k`.`TotalQuantity` AS `TotalQuantity`,`k`.`TargaStatus` AS `TargaStatus`,`k`.`LidlStatus` AS `LidlStatus`,`k`.`TCAdmin` AS `TCAdmin`,`k`.`PMAdmin` AS `PMAdmin`,`k`.`PJMAdmin` AS `PJMAdmin`,`k`.`LogAdmin` AS `LogAdmin`,`k`.`Supplier` AS `Supplier`,`k`.`POD` AS `POD`,`k`.`INCOTERM` AS `INCOTERM`,`k`.`HSCode` AS `HSCode`,`k`.`MS_EUG` AS `MS_EUG`,`k`.`MS_30PSI` AS `MS_30PSI`,`k`.`MS_PSI` AS `MS_PSI`,`k`.`Complete` AS `Complete`,`s`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`s`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`s`.`PPShipment_Id` AS `PPShipment_Id`,`s`.`PPShipment_Forwarder` AS `PPShipment_Forwarder`,`s`.`PPShipment_Carrier` AS `PPShipment_Carrier`,`s`.`PPShipment_Lot` AS `PPShipment_Lot`,`s`.`PPShipment_Vessel` AS `PPShipment_Vessel`,`s`.`PPShipment_Voyage` AS `PPShipment_Voyage`,`s`.`PPShipment_ENS` AS `PPShipment_ENS`,`s`.`PPShipment_CYClosing` AS `PPShipment_CYClosing`,`s`.`PPShipment_ETD` AS `PPShipment_ETD`,`s`.`PPShipment_ETA` AS `PPShipment_ETA`,`s`.`PPShipment_ShipReleaseGiven` AS `PPShipment_ShipReleaseGiven`,`s`.`PPShipment_ShipReleaseCalc` AS `PPShipment_ShipReleaseCalc`,`s`.`PPShipment_CRDGiven` AS `PPShipment_CRDGiven`,`s`.`PPShipment_CRDOpeningCalc` AS `PPShipment_CRDOpeningCalc`,`s`.`PPShipment_CRDClosingCalc` AS `PPShipment_CRDClosingCalc`,`s`.`PPShipment_UnloadingReportDate` AS `PPShipment_UnloadingReportDate`,`s`.`PPShipment_20ftGP` AS `PPShipment_20ftGP`,`s`.`PPShipment_40ftGP` AS `PPShipment_40ftGP`,`s`.`PPShipment_40ftHQ` AS `PPShipment_40ftHQ`,`s`.`PPShipment_LCLCBM` AS `PPShipment_LCLCBM`,`s`.`PPShipment_20ftGPCalc` AS `PPShipment_20ftGPCalc`,`s`.`PPShipment_40ftGPCalc` AS `PPShipment_40ftGPCalc`,`s`.`PPShipment_40ftHQCalc` AS `PPShipment_40ftHQCalc`,`s`.`PPShipment_CurrentStatus` AS `PPShipment_CurrentStatus`,`s`.`PPShipment_BLForm` AS `PPShipment_BLForm`,`s`.`PPShipment_LCOA` AS `PPShipment_LCOA`,`s`.`PPShipment_ProducerBooking` AS `PPShipment_ProducerBooking`,`s`.`PPShipment_ShipRelease` AS `PPShipment_ShipRelease`,`s`.`PPShipment_SO` AS `PPShipment_SO`,`s`.`PPShipment_BL` AS `PPShipment_BL`,`s`.`PPShipment_Invoce` AS `PPShipment_Invoce`,`s`.`PPShipment_PL` AS `PPShipment_PL`,`s`.`PPShipment_CoO` AS `PPShipment_CoO`,`s`.`PPShipment_DeclarationFumigation` AS `PPShipment_DeclarationFumigation`,`s`.`PPShipment_OceanFreight` AS `PPShipment_OceanFreight`,`s`.`PPShipment_PL2MaWi` AS `PPShipment_PL2MaWi`,`s`.`PPShipment_CLPSent` AS `PPShipment_CLPSent`,`s`.`PPShipment_SeaFreightInvoice` AS `PPShipment_SeaFreightInvoice`,`s`.`PPShipment_TransportInvoice` AS `PPShipment_TransportInvoice`,`s`.`PPShipment_UnloadingInvoice` AS `PPShipment_UnloadingInvoice`,`s`.`PPShipment_OtherLogisticalCosts` AS `PPShipment_OtherLogisticalCosts`,`s`.`PPShipment_CCCsent` AS `PPShipment_CCCsent`,`s`.`PPShipment_CustomsInvoice` AS `PPShipment_CustomsInvoice`,`s`.`PPShipment_CustomsDeclared` AS `PPShipment_CustomsDeclared`,`s`.`PPShipment_HSCode` AS `PPShipment_HSCode`,`s`.`PPShipment_ProjektCount` AS `PPShipment_ProjektCount`,`s`.`PPShipment_TEU` AS `PPShipment_TEU`,`s`.`PPShipment_VKStk` AS `PPShipment_VKStk`,`s`.`PPShipment_VKSumme` AS `PPShipment_VKSumme`,`s`.`PPShipment_DistancePort2Port` AS `PPShipment_DistancePort2Port`,`s`.`PPShipment_Incoterm` AS `PPShipment_Incoterm`,`s`.`PPShipment_LT` AS `PPShipment_LT`,`s`.`PPShipment_MS_30PSI` AS `PPShipment_MS_30PSI`,`s`.`PPShipment_MS_EUG` AS `PPShipment_MS_EUG`,`s`.`PPShipment_MS_PSI` AS `PPShipment_MS_PSI`,`s`.`PPShipment_POA` AS `PPShipment_POA`,`s`.`PPShipment_POD` AS `PPShipment_POD`,`s`.`PPShipment_SaleUnit` AS `PPShipment_SaleUnit`,`s`.`PPShipment_Supplier` AS `PPShipment_Supplier`,`s`.`PPShipment_Status` AS `PPShipment_Status`,`s`.`PPShipment_Quantity` AS `PPShipment_Quantity`,`s`.`PPShipment_Flag_Producer_booking` AS `PPShipment_Flag_Producer_booking`,`s`.`PPShipment_Flag_Shipment_Release` AS `PPShipment_Flag_Shipment_Release`,`s`.`PPShipment_Flag_SO` AS `PPShipment_Flag_SO`,`s`.`PPShipment_Flag_BL` AS `PPShipment_Flag_BL`,`s`.`PPShipment_Flag_Inv` AS `PPShipment_Flag_Inv`,`s`.`PPShipment_Flag_PL` AS `PPShipment_Flag_PL`,`s`.`PPShipment_Flag_CoO` AS `PPShipment_Flag_CoO`,`s`.`PPShipment_Flag_Declaration_of_Fumigation` AS `PPShipment_Flag_Declaration_of_Fumigation`,`s`.`PPShipment_Flag_Ocean_Freight` AS `PPShipment_Flag_Ocean_Freight`,`s`.`PPShipment_Flag_PL_sent_to_MaWi` AS `PPShipment_Flag_PL_sent_to_MaWi`,`s`.`PPShipment_Flag_CLP_sent` AS `PPShipment_Flag_CLP_sent`,`s`.`PPShipment_Flag_Sea_freight_invoice` AS `PPShipment_Flag_Sea_freight_invoice`,`s`.`PPShipment_Flag_Transport_invoice` AS `PPShipment_Flag_Transport_invoice`,`s`.`PPShipment_Flag_Unloading_invoice` AS `PPShipment_Flag_Unloading_invoice`,`s`.`PPShipment_Flag_Other_logistical_costs` AS `PPShipment_Flag_Other_logistical_costs`,`s`.`PPShipment_Flag_CCC_sent` AS `PPShipment_Flag_CCC_sent`,`s`.`PPShipment_Flag_customs_invoice` AS `PPShipment_Flag_customs_invoice`,`s`.`PPShipment_Flag_OS` AS `PPShipment_Flag_OS`,`s`.`PPShipment_Flag_EUService` AS `PPShipment_Flag_EUService`,`s`.`PPShipment_Flag_Critical` AS `PPShipment_Flag_Critical`,`s`.`PPShipment_BatteryType` AS `PPShipment_BatteryType`,`s`.`PPShipment_MasterCartonContents` AS `PPShipment_MasterCartonContents`,`s`.`PPShipment_ATAInlandsterminal` AS `PPShipment_ATAInlandsterminal`,`s`.`PPShipment_ZipCodeFactory` AS `PPShipment_ZipCodeFactory`,cast(`s`.`PPShipment_Id` as char charset utf8mb4) AS `ExternalID`,md5(concat_ws('|',ifnull(cast(`k`.`PPProduktpass_Id` as char charset utf8mb4),''),ifnull(cast(`k`.`Ausmusterung` as char charset utf8mb4),''),ifnull(cast(`k`.`IAN` as char charset utf8mb4),''),ifnull(cast(`k`.`Artikelbezeichnung` as char charset utf8mb4),''),ifnull(cast(`k`.`TotalQuantity` as char charset utf8mb4),''),ifnull(cast(`k`.`TargaStatus` as char charset utf8mb4),''),ifnull(cast(`k`.`LidlStatus` as char charset utf8mb4),''),ifnull(cast(`k`.`TCAdmin` as char charset utf8mb4),''),ifnull(cast(`k`.`PMAdmin` as char charset utf8mb4),''),ifnull(cast(`k`.`PJMAdmin` as char charset utf8mb4),''),ifnull(cast(`k`.`LogAdmin` as char charset utf8mb4),''),ifnull(cast(`k`.`Supplier` as char charset utf8mb4),''),ifnull(cast(`k`.`POD` as char charset utf8mb4),''),ifnull(cast(`k`.`INCOTERM` as char charset utf8mb4),''),ifnull(cast(`k`.`HSCode` as char charset utf8mb4),''),ifnull(cast(`k`.`MS_EUG` as char charset utf8mb4),''),ifnull(cast(`k`.`MS_30PSI` as char charset utf8mb4),''),ifnull(cast(`k`.`MS_PSI` as char charset utf8mb4),''),ifnull(cast(`k`.`Complete` as char charset utf8mb4),''),ifnull(cast(`s`.`PPProduktpass_IAN` as char charset utf8mb4),''),ifnull(cast(`s`.`PPProduktpass_Ausmusterungnummer` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Id` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Forwarder` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Carrier` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Lot` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Vessel` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Voyage` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ENS` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CYClosing` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ETD` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ETA` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ShipReleaseGiven` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ShipReleaseCalc` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CRDGiven` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CRDOpeningCalc` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CRDClosingCalc` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_UnloadingReportDate` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_20ftGP` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_40ftGP` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_40ftHQ` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_LCLCBM` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_20ftGPCalc` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_40ftGPCalc` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_40ftHQCalc` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_BLForm` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_LCOA` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ProducerBooking` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ShipRelease` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_SO` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_BL` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Invoce` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_PL` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CoO` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_DeclarationFumigation` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_OceanFreight` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_PL2MaWi` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CLPSent` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_SeaFreightInvoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_TransportInvoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_UnloadingInvoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_OtherLogisticalCosts` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CCCsent` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CustomsInvoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_CustomsDeclared` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_HSCode` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ProjektCount` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_TEU` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_VKStk` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_VKSumme` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_DistancePort2Port` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Incoterm` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_LT` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_MS_30PSI` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_MS_EUG` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_MS_PSI` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_POA` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_POD` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_SaleUnit` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Supplier` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Status` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Quantity` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Producer_booking` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Shipment_Release` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_SO` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_BL` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Inv` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_PL` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_CoO` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Declaration_of_Fumigation` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Ocean_Freight` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_PL_sent_to_MaWi` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_CLP_sent` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Sea_freight_invoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Transport_invoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Unloading_invoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Other_logistical_costs` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_CCC_sent` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_customs_invoice` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_OS` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_EUService` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_Flag_Critical` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_BatteryType` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_MasterCartonContents` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ATAInlandsterminal` as char charset utf8mb4),''),ifnull(cast(`s`.`PPShipment_ZipCodeFactory` as char charset utf8mb4),''))) AS `RowHash` from (`v_ShipmentoverviewKopf` `k` join `v_ShipmentoverviewShipments` `s` on(((`k`.`IAN` = `s`.`PPProduktpass_IAN`) and (`k`.`Ausmusterung` = substr(`s`.`PPProduktpass_Ausmusterungnummer`,1,4)))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_StatSPOUpload`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_StatSPOUpload` AS select `p`.`PPProduktpass_IAN` AS `IAN`,`p`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`f`.`PPPPFiles_Name` AS `Dateiname`,`f`.`PPPPFiles_Type` AS `Type`,`f`.`PPPPFiles_SubKat` AS `SubType`,`f`.`PPPPFiles_Ordnung` AS `Kategorie`,`f`.`PPPPFiles_Date` AS `UploadLocal`,`f`.`PPPPFiles_StartUpload` AS `StartTransfer2SPO`,`f`.`PPPPFiles_FinishUpload` AS `EndTransfer2SPO`,timestampdiff(SECOND,`f`.`PPPPFiles_Date`,`f`.`PPPPFiles_StartUpload`) AS `ZeitBisSPOUploadInSek`,timestampdiff(SECOND,`f`.`PPPPFiles_StartUpload`,`f`.`PPPPFiles_FinishUpload`) AS `DauerUploadInSek` from (`PPPPFiles` `f` join `tPPProduktpass` `p` on((`p`.`PPProduktpass_Id` = `f`.`PPPPFiles_PPProduktpass_Id`))) where ((`f`.`PPPPFiles_Status` = 1) and (not((`p`.`PPProduktpass_IAN` like '%ev%'))) and (`f`.`PPPPFiles_StartUpload` is not null));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_UserLogin`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_UserLogin` AS select `PPLog`.`PPLog_User` AS `User`,`PPLog`.`PPLog_Date` AS `LoginDate`,`PPLog`.`PPLog_Typ` AS `Type`,`PPMitarbeiter`.`PPMitarbeiter_Name` AS `Name`,`PPMitarbeiter`.`PPMitarbeiter_Vorname` AS `Vorname`,`PPMitarbeiter`.`PPMitarbeiter_Taetigkeit` AS `Taetigkeit` from (`PPLog` left join `PPMitarbeiter` on((cast(trim(`PPMitarbeiter`.`PPMitarbeiter_Kuerzel`) as char(6) charset utf8mb4) = cast(trim(`PPLog`.`PPLog_User`) as char(6) charset utf8mb4)))) where (`PPLog`.`PPLog_Typ` like 'Login%') order by `PPLog`.`PPLog_User` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_UserLoginCount`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_UserLoginCount` AS select `PPLog`.`PPLog_User` AS `PPLog_User`,count(0) AS `AnzahlLogins`,`PPMitarbeiter`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit` from (`PPLog` join `PPMitarbeiter` on((cast(`PPMitarbeiter`.`PPMitarbeiter_Kuerzel` as char(50) charset utf8mb4) = cast(`PPLog`.`PPLog_User` as char(50) charset utf8mb4)))) where (`PPLog`.`PPLog_Typ` = 'Login') group by `PPLog`.`PPLog_User`,`PPMitarbeiter`.`PPMitarbeiter_Taetigkeit` order by count(0) desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_ZolltarifRegeln`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_ZolltarifRegeln` AS select `P`.`PPProduktpass_Id` AS `Id`,`P`.`InternerStatus` AS `Status`,`P`.`PPProduktpass_IAN` AS `IAN`,`P`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,`P`.`PPProduktpass_Zolltarif` AS `Zolltarifnummer_TPT`,`Z`.`RestrictedZolltarif_Zolltarifnummer` AS `Zolltarifnummer_Restricted`,`Z`.`RestrictedZolltarif_Bezeichnug` AS `Warenbezeichnung`,`Z`.`RestrictedZolltarif_Restriction` AS `Grund` from (`tPPProduktpass` `P` join `RestrictedZolltarif` `Z` on((`P`.`PPProduktpass_Zolltarif` like concat(`Z`.`RestrictedZolltarif_Zolltarifnummer`,'%')))) where ((not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_check_PM_TC_Assignment`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_check_PM_TC_Assignment` AS select distinct `tPPProduktpass`.`PPProduktpass_IAN` AS `IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `Charge`,`tPPProduktpass`.`InternerStatus` AS `Status`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,`tPPProduktpass`.`PPProduktpass_PMAdmin` AS `PMAdminId`,`PM`.`PPMitarbeiter_Kuerzel` AS `PMAdmin`,`tPPProduktpass`.`PPProduktpass_TCAdmin` AS `TCAdminId`,`TC`.`PPMitarbeiter_Kuerzel` AS `TCAdmin`,`tPPProduktpass`.`PPProduktpass_PJMAdmin` AS `PJMAdminId`,`PJM`.`PPMitarbeiter_Kuerzel` AS `PJMAdmin`,if((substr(`BS`.`PPBoardSpalteData_Kind`,1,2) = 'PM'),'PM',if((locate('TC',`BS`.`PPBoardSpalteData_Kind`) = 1),'TC','PJM')) AS `MilestoneTaetigkeit`,`BS`.`PPBoardSpalte_Bezeichnung` AS `Milestone`,`BS`.`PPBoard_Id` AS `Dashboard_Id`,`T`.`PPTermine_MAZustaendigkeit` AS `Zustaendige_rMAId`,`T`.`PPTermine_Status` AS `TerminStatus`,`TM`.`PPMitarbeiter_Kuerzel` AS `Zustaendige_rMA`,`TM`.`PPMitarbeiter_Taetigkeit` AS `Zustaendige_rTaetigkeit`,(`TM`.`PPMitarbeiter_Taetigkeit` = if((substr(`BS`.`PPBoardSpalteData_Kind`,1,2) = 'PM'),'PM',if((locate('TC',`BS`.`PPBoardSpalteData_Kind`) = 1),'TC','PJM'))) AS `StatusZuordnung`,`T`.`PPTermine_Id` AS `PPTermine_Id` from ((((((`tPPProduktpass` join `PPMitarbeiter` `PM` on((`tPPProduktpass`.`PPProduktpass_PMAdmin` = `PM`.`PPMitarbeiter_Id`))) join `PPMitarbeiter` `TC` on((`tPPProduktpass`.`PPProduktpass_TCAdmin` = `TC`.`PPMitarbeiter_Id`))) join `PPMitarbeiter` `PJM` on((`tPPProduktpass`.`PPProduktpass_PJMAdmin` = `PJM`.`PPMitarbeiter_Id`))) join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `tPPProduktpass`.`PPProduktpass_Id`))) join `PPMitarbeiter` `TM` on((`T`.`PPTermine_MAZustaendigkeit` = `TM`.`PPMitarbeiter_Id`))) join `PPBoardSpalte` `BS` on((`BS`.`PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%'))) and (`tPPProduktpass`.`InternerStatus` in ('FIX','MUSTERUNG','PLAN')) and (`BS`.`PPBoard_Id` < 1003)) order by `tPPProduktpass`.`PPProduktpass_IAN` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_check_PM_TC_Assignment_Error`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_check_PM_TC_Assignment_Error` AS select `rpt_check_PM_TC_Assignment`.`IAN` AS `IAN`,`rpt_check_PM_TC_Assignment`.`Charge` AS `Charge`,`rpt_check_PM_TC_Assignment`.`Status` AS `Status`,`rpt_check_PM_TC_Assignment`.`Artikel` AS `Artikel`,`rpt_check_PM_TC_Assignment`.`PMAdminId` AS `PMAdminId`,`rpt_check_PM_TC_Assignment`.`PMAdmin` AS `PMAdmin`,`rpt_check_PM_TC_Assignment`.`TCAdminId` AS `TCAdminId`,`rpt_check_PM_TC_Assignment`.`TCAdmin` AS `TCAdmin`,`rpt_check_PM_TC_Assignment`.`PJMAdminId` AS `PJMAdminId`,`rpt_check_PM_TC_Assignment`.`PJMAdmin` AS `PJMAdmin`,`rpt_check_PM_TC_Assignment`.`MilestoneTaetigkeit` AS `MilestoneTaetigkeit`,`rpt_check_PM_TC_Assignment`.`Milestone` AS `Milestone`,`rpt_check_PM_TC_Assignment`.`Zustaendige_rMAId` AS `Zustaendige_rMAId`,`rpt_check_PM_TC_Assignment`.`Zustaendige_rMA` AS `Zustaendige_rMA`,`rpt_check_PM_TC_Assignment`.`Zustaendige_rTaetigkeit` AS `Zustaendige_rTaetigkeit`,`rpt_check_PM_TC_Assignment`.`PPTermine_Id` AS `PPTermine_Id` from `rpt_check_PM_TC_Assignment` where ((`rpt_check_PM_TC_Assignment`.`MilestoneTaetigkeit` <> `rpt_check_PM_TC_Assignment`.`Zustaendige_rTaetigkeit`) and (not((`rpt_check_PM_TC_Assignment`.`MilestoneTaetigkeit` like 'XX'))) and (`rpt_check_PM_TC_Assignment`.`MilestoneTaetigkeit` <> `rpt_check_PM_TC_Assignment`.`Zustaendige_rTaetigkeit`));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_check_PM_TC_PJM_Assignment_Error`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_check_PM_TC_PJM_Assignment_Error` AS select `rpt_check_PM_TC_Assignment`.`IAN` AS `IAN`,`rpt_check_PM_TC_Assignment`.`Charge` AS `Charge`,`rpt_check_PM_TC_Assignment`.`Status` AS `Status`,`rpt_check_PM_TC_Assignment`.`Artikel` AS `Artikel`,`rpt_check_PM_TC_Assignment`.`PMAdminId` AS `PMAdminId`,`rpt_check_PM_TC_Assignment`.`PMAdmin` AS `PMAdmin`,`rpt_check_PM_TC_Assignment`.`TCAdminId` AS `TCAdminId`,`rpt_check_PM_TC_Assignment`.`TCAdmin` AS `TCAdmin`,`rpt_check_PM_TC_Assignment`.`PJMAdminId` AS `PJMAdminId`,`rpt_check_PM_TC_Assignment`.`PJMAdmin` AS `PJMAdmin`,`rpt_check_PM_TC_Assignment`.`MilestoneTaetigkeit` AS `MilestoneTaetigkeit`,`rpt_check_PM_TC_Assignment`.`Milestone` AS `Milestone`,`rpt_check_PM_TC_Assignment`.`Zustaendige_rMAId` AS `Zustaendige_rMAId`,`rpt_check_PM_TC_Assignment`.`TerminStatus` AS `TerminStatus`,`rpt_check_PM_TC_Assignment`.`Zustaendige_rMA` AS `Zustaendige_rMA`,`rpt_check_PM_TC_Assignment`.`Zustaendige_rTaetigkeit` AS `Zustaendige_rTaetigkeit`,`rpt_check_PM_TC_Assignment`.`StatusZuordnung` AS `StatusZuordnung`,`rpt_check_PM_TC_Assignment`.`PPTermine_Id` AS `PPTermine_Id`,`rpt_check_PM_TC_Assignment`.`Dashboard_Id` AS `Dashboard_Id` from `rpt_check_PM_TC_Assignment` where ((not((`rpt_check_PM_TC_Assignment`.`IAN` like '99%'))) and (`rpt_check_PM_TC_Assignment`.`StatusZuordnung` = 0) and (`rpt_check_PM_TC_Assignment`.`TerminStatus` in ('Neu','in Arbeit')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_hvBestelluebersichtOnlineshops`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_hvBestelluebersichtOnlineshops` AS select `p`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`p`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`p`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,`p`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`m`.`PPXML_OSMengen_styleNo` AS `PPXML_OSMengen_styleNo`,`m`.`PPXML_OSMengen_productName` AS `PPXML_OSMengen_productName`,`m`.`PPXML_OSMengen_country` AS `PPXML_OSMengen_country`,`m`.`PPXML_OSMengen_lsv` AS `PPXML_OSMengen_lsv`,`m`.`PPXML_OSMengen_value` AS `PPXML_OSMengen_value`,`m`.`PPXML_OSMengen_DeliveryNo` AS `PPXML_OSMengen_DeliveryNo` from (`tPPProduktpass` `p` join `PPXML_OSMengen` `m` on((`m`.`PPXML_OSMengen_PPProduktpass_Id` = `p`.`PPProduktpass_Id`))) where ((not((`p`.`PPProduktpass_IAN` like '%ev%'))) and (`m`.`PPXML_OSMengen_value` > 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_hvBestelluebersichtStationaer`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_hvBestelluebersichtStationaer` AS select `p`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`p`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`p`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,`p`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`m`.`PPXML_Mengen_styleNo` AS `PPXML_Mengen_styleNo`,`m`.`PPXML_Mengen_productName` AS `PPXML_Mengen_productName`,`m`.`PPXML_Mengen_country` AS `PPXML_Mengen_country`,`m`.`PPXML_Mengen_lsv` AS `PPXML_Mengen_lsv`,`m`.`PPXML_Mengen_value` AS `PPXML_Mengen_value` from (`tPPProduktpass` `p` join `PPXML_Mengen` `m` on((`m`.`PPXML_Mengen_PPProduktpass_Id` = `p`.`PPProduktpass_Id`))) where ((not((`p`.`PPProduktpass_IAN` like '%ev%'))) and (`m`.`PPXML_Mengen_value` > 0) and (not((`m`.`PPXML_Mengen_country` like 'OS%'))) and (not((`m`.`PPXML_Mengen_country` like 'KO%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_hvLSVs`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_hvLSVs` AS select `p`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`p`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`p`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,`p`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`lsv`.`PPLsv_countryCodes` AS `PPLsv_countryCodes`,`lsv`.`PPLsv_countryNames` AS `PPLsv_countryNames`,`lsv`.`PPLsv_name` AS `PPLsv_name`,`lsv`.`PPLsv_code` AS `PPLsv_code` from (`tPPProduktpass` `p` join `PPLsv` `lsv` on((`lsv`.`PPLsv_PPProduktpass_Id` = `p`.`PPProduktpass_Id`))) where (not((`p`.`PPProduktpass_IAN` like '%ev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_hvLaendermengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_hvLaendermengen` AS select `p`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`p`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`p`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,`p`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`lb`.`PPLaenderbloecke_Block` AS `PPProduktpass_Menge_CountryBlock`,`m`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`m`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`m`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`m`.`PPProduktpass_Menge_PackingMethod` AS `PPProduktpass_Menge_PackingMethod`,`m`.`PPProduktpass_Menge_DeliveryWeek` AS `PPProduktpass_Menge_DeliveryWeek`,`m`.`PPProduktpass_Menge_LT1` AS `PPProduktpass_Menge_LT1`,`m`.`PPProduktpass_Menge_LT1Menge` AS `PPProduktpass_Menge_LT1Menge`,`m`.`PPProduktpass_Menge_LT2` AS `PPProduktpass_Menge_LT2`,`m`.`PPProduktpass_Menge_LT2Menge` AS `PPProduktpass_Menge_LT2Menge`,`m`.`PPProduktpass_Menge_LT3` AS `PPProduktpass_Menge_LT3`,`m`.`PPProduktpass_Menge_LT3Menge` AS `PPProduktpass_Menge_LT3Menge`,`m`.`PPProduktpass_Menge_Kolli` AS `PPProduktpass_Menge_Kolli`,`m`.`PPProduktpass_Menge_ArtikelInfo` AS `PPProduktpass_Menge_ArtikelInfo`,`p`.`InternerStatus` AS `InternerStatus` from ((`PPProduktpass_Menge` `m` join `tPPProduktpass` `p` on((`p`.`PPProduktpass_Id` = `m`.`PPProduktpass_Menge_PPProduktpass_Id`))) left join `PPLaenderbloeckeMitVersion` `lb` on(((`lb`.`PPLaenderbloecke_Land` = `m`.`PPProduktpass_Menge_Country`) and (`lb`.`PPLaenderbloecke_Version` = (case when (cast(substr(`p`.`PPProduktpass_Ausmusterungnummer`,1,4) as unsigned) >= 2504) then '2507' else '0000' end))))) where ((not((`p`.`PPProduktpass_IAN` like '%ev%'))) and ((`m`.`PPProduktpass_Menge_LT1Menge` > 0) or (`m`.`PPProduktpass_Menge_LT2Menge` > 0) or (`m`.`PPProduktpass_Menge_LT3Menge` > 0)) and (`p`.`InternerStatus` in ('FIX','GELIEFERT')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_hvMengenStationaer`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_hvMengenStationaer` AS select `rpt_hvBestelluebersichtStationaer`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`rpt_hvBestelluebersichtStationaer`.`PPProduktpass_IAN` AS `IAN`,`rpt_hvBestelluebersichtStationaer`.`Charge` AS `Charge`,`rpt_hvBestelluebersichtStationaer`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_styleNo` AS `StyleNo`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_productName` AS `Style`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_country` AS `Country`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_lsv` AS `LSV`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Kolli` AS `KolliContent`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_value` AS `PcsInKollie`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1` AS `LT1`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` AS `LT1Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2` AS `LT2`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2Menge` AS `LT2Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3` AS `LT3`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3Menge` AS `LT3Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity` AS `TotalQty` from (`rpt_hvBestelluebersichtStationaer` join `PPProduktpass_Menge` on(((`PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` = `rpt_hvBestelluebersichtStationaer`.`PPProduktpass_Id`) and (`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_country` = `PPProduktpass_Menge`.`PPProduktpass_Menge_Country`)))) where (`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` > 0) order by `rpt_hvBestelluebersichtStationaer`.`PPProduktpass_Id`,`rpt_hvBestelluebersichtStationaer`.`Charge`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_country`,`rpt_hvBestelluebersichtStationaer`.`PPXML_Mengen_styleNo`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `rpt_hvZollGewichteGTIN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `rpt_hvZollGewichteGTIN` AS select `p`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`p`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`p`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,`p`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`w`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`w`.`PPOrderWeights_productName` AS `PPOrderWeights_productName`,`w`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`w`.`PPOrderWeights_size` AS `PPOrderWeights_size`,`w`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`w`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`w`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`w`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL` from (`tPPProduktpass` `p` join `PPOrderWeights` `w` on((`w`.`PPOrderWeights_PPProduktpass_Id` = `p`.`PPProduktpass_Id`))) where (not((`p`.`PPProduktpass_IAN` like '%ev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `tFiles1`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `tFiles1` AS select `tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,count(`tPPProduktpass`.`PPProduktpass_IAN`) AS `AnzahlDateien1` from (`PPPPFiles` join `tPPProduktpass` on((`PPPPFiles`.`PPPPFiles_PPProduktpass_Id` = `tPPProduktpass`.`PPProduktpass_Id`))) where (length(`tPPProduktpass`.`PPProduktpass_IAN`) = 6) group by `tPPProduktpass`.`PPProduktpass_IAN` order by `tPPProduktpass`.`PPProduktpass_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `tFiles2`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `tFiles2` AS select substr(`tPPProduktpass`.`PPProduktpass_IAN`,1,6) AS `REVIan`,count(`tPPProduktpass`.`PPProduktpass_IAN`) AS `AnzahlDateien2`,`tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id` from (`PPPPFiles` join `tPPProduktpass` on((`PPPPFiles`.`PPPPFiles_PPProduktpass_Id` = `tPPProduktpass`.`PPProduktpass_Id`))) where (length(`tPPProduktpass`.`PPProduktpass_IAN`) > 6) group by `tPPProduktpass`.`PPProduktpass_IAN` order by substr(`tPPProduktpass`.`PPProduktpass_IAN`,1,6);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `tMaxFiles`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `tMaxFiles` AS select `tFiles2`.`REVIan` AS `RevIAN`,max(`tFiles2`.`AnzahlDateien2`) AS `Max` from `tFiles2` group by `tFiles2`.`REVIan`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `test_IAN_ohne_ServiceAnfrage`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `test_IAN_ohne_ServiceAnfrage` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus` from `tPPProduktpass` where ((`tPPProduktpass`.`InternerStatus` in ('PLAN','MUSTERUNG','FIX')) and (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%'))) and `tPPProduktpass`.`PPProduktpass_Id` in (select `PPPPFiles`.`PPPPFiles_PPProduktpass_Id` from `PPPPFiles` where (`PPPPFiles`.`PPPPFiles_Name` like 'ServiceAn%')) is false and `tPPProduktpass`.`PPProduktpass_Id` in (select distinct `F`.`PPPPFiles_PPProduktpass_Id` from (`PPPPFiles` `F` join `tPPProduktpass` `P` on((`P`.`PPProduktpass_Id` = `F`.`PPPPFiles_PPProduktpass_Id`))) where ((`F`.`PPPPFiles_Name` like 'ServiceAn%') and (not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (substr(`F`.`PPPPFiles_Name`,21,1) <> 'T') and (substr(`F`.`PPPPFiles_Name`,20,1) not in ('T','9')))) is false);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `test_ServiceAnfrage_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `test_ServiceAnfrage_IAN` AS select distinct substr(`PPPPFiles`.`PPPPFiles_Name`,20,6) AS `IAN`,`PPPPFiles`.`PPPPFiles_PPProduktpass_Id` AS `PPId` from `PPPPFiles` where (`PPPPFiles`.`PPPPFiles_Name` like 'ServiceAn%');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `tmp_testLastCahnge`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `tmp_testLastCahnge` AS select `x`.`IAN` AS `IAN`,`x`.`Charge` AS `Charge`,`x`.`Aenderung` AS `Aenderung`,`x`.`DatumStatusAenderung` AS `DatumStatusAenderung`,`x`.`Alter_Status` AS `Alter_Status`,`x`.`Neuer_Status` AS `Neuer_Status`,`x`.`Mitarbeiter` AS `Mitarbeiter` from (select right(`PPLog`.`PPLog_Typ`,6) AS `IAN`,substr(`PPLog`.`PPLog_Typ`,23,4) AS `Charge`,`PPLog`.`PPLog_Typ` AS `Aenderung`,`PPLog`.`PPLog_Date` AS `DatumStatusAenderung`,`PPLog`.`PPLog_Old` AS `Alter_Status`,`PPLog`.`PPLog_New` AS `Neuer_Status`,`PPLog`.`PPLog_User` AS `Mitarbeiter`,row_number() OVER (PARTITION BY right(`PPLog`.`PPLog_Typ`,6),substr(`PPLog`.`PPLog_Typ`,23,4) ORDER BY `PPLog`.`PPLog_Date` desc,`PPLog`.`PPLog_Id` desc )  AS `rn` from `PPLog` where (`PPLog`.`PPLog_Typ` like '%[%')) `x` where (`x`.`rn` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `vAktRev`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `vAktRev` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id` from `tPPProduktpass` where (length(`tPPProduktpass`.`PPProduktpass_IAN`) = 6);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `vLagerliste`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `vLagerliste` AS select `A`.`artikelnummer` AS `Artikelnummer`,`A`.`Matchcode` AS `Matchcode`,`A`.`Bezeichnung1` AS `Bezeichnung1`,`A`.`Bezeichnung2` AS `Bezeichnung2`,replace(format(`A`.`PreisEinstand`,2,'de_DE'),'.','') AS `EP`,replace(format(`A`.`PreisLEK`,2,'de_DE'),'.','') AS `LEK`,replace(format(`A`.`PreisDurchschnittEK`,2,'de_DE'),'.','') AS `MEK`,`A`.`MengeneinheitLager` AS `Einh`,`A`.`IstAktiv` AS `IstAktiv`,`A`.`IstBestandsgefuehrt` AS `IstBestandsgefuehrt`,`A`.`LagerartikelArt` AS `LagerartikelArt`,replace(format(`L`.`bestand`,2,'de_DE'),'.','') AS `Bestand` from (`artikelstamm` `A` join `lagerbestand` `L` on((`L`.`artikel_id` = `A`.`artikelstamm_id`))) where ((`A`.`IstAktiv` = 1) and (`A`.`IstBestandsgefuehrt` = 1) and (`A`.`Hauptgruppe` is not null)) order by `A`.`artikelstamm_id` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `vLastRevPP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `vLastRevPP` AS select max(`tPPProduktpass`.`PPProduktpass_Id`) AS `lastRevPPId`,substr(`tPPProduktpass`.`PPProduktpass_IAN`,1,6) AS `IAN` from `tPPProduktpass` where (length(`tPPProduktpass`.`PPProduktpass_IAN`) > 6) group by `IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `vMehrwertsteuer`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `vMehrwertsteuer` AS select `b`.`Belegart` AS `Belegart`,`b`.`Lieferadresse_Land` AS `Lieferadresse_Land`,`b`.`Belegdatum` AS `Belegdatum`,`b`.`Belegnummer` AS `Belegnummer`,`bp`.`menge` AS `menge`,`bp`.`Preis` AS `Preis`,`bp`.`steuercode` AS `Steuercode`,`b`.`Liefertermin` AS `Liefertermin`,`sz`.`Steuersatz` AS `Steuersatz`,`sts`.`SteuerAusweisen` AS `SteuerAusweisen`,`bp`.`belegepositionen_id` AS `Belegposition_id` from ((((`belege` `b` join `belegepositionen` `bp` on((`b`.`Belege_id` = `bp`.`Belege_id`))) join `belegarten` `ba` on((`ba`.`Belegart` = `b`.`Belegart`))) join `Steuersatz` `sz` on(((`sz`.`Steuercode` = `bp`.`steuercode`) and (`sz`.`Lieferland` = `b`.`Lieferadresse_Land`) and (`b`.`Liefertermin` >= `sz`.`GueltigVon`) and (`b`.`Liefertermin` <= `sz`.`GueltigBis`)))) join `Steuerschluessel` `sts` on((`sts`.`Steuerschluessel_Id` = `b`.`Steuercode`))) where (`ba`.`IstrBuchhaltungsbeleg` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `vPPwithDiffrentKolli`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `vPPwithDiffrentKolli` AS select count(distinct `PPProduktpass_Menge`.`PPProduktpass_Menge_Kolli`,`PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`) AS `Name_exp_1`,`PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id` from `PPProduktpass_Menge` group by `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` order by count(distinct `PPProduktpass_Menge`.`PPProduktpass_Menge_Kolli`,`PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`) desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `vXML_Converter`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `vXML_Converter` AS select `XMLConverter`.`XMLConverter_Id` AS `XMLConverter_Id`,`XMLConverter`.`XMLConverter_DBTable` AS `XMLConverter_DBTable`,`XMLConverter`.`XMLConverter_DBColumn` AS `XMLConverter_DBColumn`,`XMLConverter`.`XMLConverter_XMLNode` AS `XMLConverter_XMLNode`,`XMLConverter`.`XMLConverter_Version` AS `XMLConverter_Version` from `XMLConverter` where (`XMLConverter`.`XMLConverter_Version` = '2021.01');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_AbgangEK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_AbgangEK` AS select sum(`v_ZuAbgang`.`EKGesamt`) AS `Abgang`,`v_ZuAbgang`.`EKWaehrung` AS `EKWaehrung`,`v_ZuAbgang`.`AbgangJahr` AS `AbgangJahr`,`v_ZuAbgang`.`AbgangMonat` AS `AbgangMonat` from `v_ZuAbgang` group by `v_ZuAbgang`.`ZugangJahr`,`v_ZuAbgang`.`ZugangMonat`,`v_ZuAbgang`.`AbgangJahr`,`v_ZuAbgang`.`AbgangMonat`,`v_ZuAbgang`.`EKWaehrung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_AltgeraeteES`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_AltgeraeteES` AS select `P`.`InternerStatus` AS `Status`,`P`.`PPProduktpass_IAN` AS `IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterungnummer`,concat(`P`.`PPProduktpass_LieferterminJahr`,'/',`P`.`PPProduktpass_Liefertermin`) AS `Liefertermin`,`M`.`PPProduktpass_Menge_Country` AS `Land`,format(`M`.`PPProduktpass_Menge_Quantity`,0,'de_DE') AS `Menge` from (`tPPProduktpass` `P` join `PPProduktpass_Menge` `M` on((`M`.`PPProduktpass_Menge_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) where ((`P`.`InternerStatus` in ('FIX','GELIEFERT')) and (`M`.`PPProduktpass_Menge_Country` like '%ES%') and (`M`.`PPProduktpass_Menge_Quantity` > 0) and (not((`P`.`PPProduktpass_IAN` like '%rev%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_AssortOWLsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_AssortOWLsv` AS select `PPAssortments`.`PPAssortments_Id` AS `PPAssortments_Id`,`PPAssortments`.`PPAssortments_PPProduktpass_Id` AS `PPAssortments_PPProduktpass_Id`,`PPAssortments`.`PPAssortments_styleNo` AS `PPAssortments_styleNo`,`PPAssortments`.`PPAssortments_vendorUniqueSeqNo` AS `PPAssortments_vendorUniqueSeqNo`,`PPAssortments`.`PPAssortments_packingMethod` AS `PPAssortments_packingMethod`,`PPAssortments`.`PPAssortments_countryCodes` AS `PPAssortments_countryCodes`,`PPAssortments`.`PPAssortments_totalPackRatio` AS `PPAssortments_totalPackRatio`,`PPAssortments`.`PPAssortments_sizecode` AS `PPAssortments_sizecode`,`PPAssortments`.`PPAssortments_sizevalue` AS `PPAssortments_sizevalue`,`PPAssortments`.`PPAssortments_productName` AS `PPAssortments_productName`,`PPAssortments`.`PPAssortments_delMarker` AS `PPAssortments_delMarker`,`v_OWLsv`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`v_OWLsv`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`v_OWLsv`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`v_OWLsv`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`v_OWLsv`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`v_OWLsv`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`v_OWLsv`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`v_OWLsv`.`PPLsv_name` AS `PPLsv_name`,`v_OWLsv`.`PPLsv_countryCodes` AS `PPLsv_countryCodes` from (`PPAssortments` join `v_OWLsv` on(((`v_OWLsv`.`PPOrderWeights_PPProduktpass_Id` = `PPAssortments`.`PPAssortments_PPProduktpass_Id`) and (`PPAssortments`.`PPAssortments_styleNo` = `v_OWLsv`.`PPOrderWeights_styleNo`) and (`PPAssortments`.`PPAssortments_countryCodes` like '%ES%') and (`v_OWLsv`.`PPLsv_countryCodes` like '%ES%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_AssortOWLsvOLsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_AssortOWLsvOLsv` AS select `PPAssortments`.`PPAssortments_Id` AS `PPAssortments_Id`,`PPAssortments`.`PPAssortments_PPProduktpass_Id` AS `PPAssortments_PPProduktpass_Id`,`PPAssortments`.`PPAssortments_styleNo` AS `PPAssortments_styleNo`,`PPAssortments`.`PPAssortments_vendorUniqueSeqNo` AS `PPAssortments_vendorUniqueSeqNo`,`PPAssortments`.`PPAssortments_packingMethod` AS `PPAssortments_packingMethod`,`PPAssortments`.`PPAssortments_countryCodes` AS `PPAssortments_countryCodes`,`PPAssortments`.`PPAssortments_totalPackRatio` AS `PPAssortments_totalPackRatio`,`PPAssortments`.`PPAssortments_sizecode` AS `PPAssortments_sizecode`,`PPAssortments`.`PPAssortments_sizevalue` AS `PPAssortments_sizevalue`,`PPAssortments`.`PPAssortments_productName` AS `PPAssortments_productName`,`PPAssortments`.`PPAssortments_delMarker` AS `PPAssortments_delMarker`,`v_OWLsvOLsv`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`v_OWLsvOLsv`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`v_OWLsvOLsv`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`v_OWLsvOLsv`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`v_OWLsvOLsv`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`v_OWLsvOLsv`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`v_OWLsvOLsv`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`v_OWLsvOLsv`.`PPLsv_name` AS `PPLsv_name`,`v_OWLsvOLsv`.`PPLsv_countryCodes` AS `PPLsv_countryCodes` from (`PPAssortments` join `v_OWLsvOLsv` on(((`v_OWLsvOLsv`.`PPOrderWeights_PPProduktpass_Id` = `PPAssortments`.`PPAssortments_PPProduktpass_Id`) and (`PPAssortments`.`PPAssortments_styleNo` = `v_OWLsvOLsv`.`PPOrderWeights_styleNo`)))) where (`PPAssortments`.`PPAssortments_countryCodes` like '%ES%');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Assortment`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Assortment` AS select `PPAssortments`.`PPAssortments_Id` AS `PPAssortments_Id`,`PPAssortments`.`PPAssortments_PPProduktpass_Id` AS `PPAssortments_PPProduktpass_Id`,`PPAssortments`.`PPAssortments_styleNo` AS `PPAssortments_styleNo`,`PPAssortments`.`PPAssortments_vendorUniqueSeqNo` AS `PPAssortments_vendorUniqueSeqNo`,`PPAssortments`.`PPAssortments_packingMethod` AS `PPAssortments_packingMethod`,`PPAssortments`.`PPAssortments_countryCodes` AS `PPAssortments_countryCodes`,`PPAssortments`.`PPAssortments_totalPackRatio` AS `PPAssortments_totalPackRatio`,`PPAssortments`.`PPAssortments_sizecode` AS `PPAssortments_sizecode`,`PPAssortments`.`PPAssortments_sizevalue` AS `PPAssortments_sizevalue`,`PPAssortments`.`PPAssortments_productName` AS `PPAssortments_productName`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung` from (`PPAssortments` join `tPPProduktpass` on((`tPPProduktpass`.`PPProduktpass_Id` = `PPAssortments`.`PPAssortments_PPProduktpass_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_AuftragsUebersicht`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_AuftragsUebersicht` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`PM`.`PPMitarbeiter_Kuerzel` AS `PM`,`PMVTR`.`PPMitarbeiter_Kuerzel` AS `PMVTR`,`TC`.`PPMitarbeiter_Kuerzel` AS `TC`,`TCVTR`.`PPMitarbeiter_Kuerzel` AS `TCVTR`,`PJM`.`PPMitarbeiter_Kuerzel` AS `PJM`,`PJMVTR`.`PPMitarbeiter_Kuerzel` AS `PJMVTR`,(case when (`tPPProduktpass`.`InternerStatus` = 'FIX') then 1 when (`tPPProduktpass`.`InternerStatus` = 'Plan') then 2 when (`tPPProduktpass`.`InternerStatus` = 'MUSTERUNG') then 3 when (`tPPProduktpass`.`InternerStatus` = 'GELIEFERT') then 4 when (`tPPProduktpass`.`InternerStatus` = 'ABSAGE') then 5 else 6 end) AS `SORTSTATUS` from ((((((`tPPProduktpass` left join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `PMVTR` on((`PMVTR`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `TC` on((`TC`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `TCVTR` on((`TCVTR`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_TCAdminVTR`))) left join `PPMitarbeiter` `PJM` on((`PJM`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_PJMAdmin`))) left join `PPMitarbeiter` `PJMVTR` on((`PJMVTR`.`PPMitarbeiter_Id` = `tPPProduktpass`.`PPProduktpass_PJMAdminVTR`))) where (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_BuHaWareneinsatz`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_BuHaWareneinsatz` AS select concat(`PP`.`PPProduktpass_Liefertermin`,'/',`PP`.`PPProduktpass_LieferterminJahr`) AS `LTKunde`,`PP`.`PPProduktpass_IAN` AS `IAN`,`PP`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PP`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterung`,`PP`.`PPProduktpass_Gesamtmenge` AS `Menge`,`PP`.`PPProduktpass_Artikelbezeichnung` AS `Artikel`,`PO`.`PPPurchase_FOBYear` AS `LiefLTJahr`,`PO`.`PPPurchase_FOBWeek` AS `LiefLTWoche`,sum(`PPM`.`PPProduktpass_Menge_LT1Menge`) AS `LTMenge`,sum((`PPM`.`PPProduktpass_Menge_LT1Menge` * `PPM`.`PPProduktpass_Menge_EKUSD`)) AS `TotalEKFW`,(sum((`PPM`.`PPProduktpass_Menge_LT1Menge` * `PPM`.`PPProduktpass_Menge_EKUSD`)) / sum(`PPM`.`PPProduktpass_Menge_LT1Menge`)) AS `EKBWFW`,`PO`.`PPPurchase_EK` AS `EKFW`,`PO`.`PPPurchase_Currency` AS `WSYM`,`PO`.`PPPurchase_EK_Calc` AS `EKKalk`,`PO`.`PPPurchase_ExcR_Calc` AS `KursKalk`,ifnull(`PO`.`PPPurchase_DeliveryDate`,((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week) - interval (weekday((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week)) - 1) day)) AS `LieferantenLT`,date_format(((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week) - interval (weekday((makedate(`PO`.`PPPurchase_FOBYear`,1) + interval `PO`.`PPPurchase_FOBWeek` week)) - 1) day),'%m') AS `Periode` from ((`PPProduktpass_Menge` `PPM` join `tPPProduktpass` `PP` on((`PPM`.`PPProduktpass_Menge_PPProduktpass_Id` = `PP`.`PPProduktpass_Id`))) join `PPPurchase` `PO` on((`PO`.`PPPurchase_PPProduktpass_Id` = `PPM`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((length(`PP`.`PPProduktpass_IAN`) = 6) and (not((`PP`.`PPProduktpass_IAN` like 'M%'))) and (not((`PP`.`PPProduktpass_IAN` like 'I%'))) and (0 <> `PP`.`PPProduktpass_LieferterminJahr`) and (`PP`.`PPProduktpass_IsInquiry` = 0) and (`PP`.`PPProduktpass_IsMusterung` = 0) and (`PO`.`PPPurchase_FOBYear` = 2021)) group by `PPM`.`PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_CRD`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_CRD` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`tPPProduktpass`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`tPPProduktpass`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`tPPProduktpass`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`tPPProduktpass`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,left(`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,(makedate(`tPPProduktpass`.`PPProduktpass_LieferterminJahr`,(`tPPProduktpass`.`PPProduktpass_Liefertermin` * 7)) + interval -(2) day) AS `DDP`,((makedate(`tPPProduktpass`.`PPProduktpass_LieferterminJahr`,(`tPPProduktpass`.`PPProduktpass_Liefertermin` * 7)) + interval -(2) day) + interval -(10) week) AS `CRDausDDP`,`tPPProduktpass`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`tPPProduktpass`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,(makedate(`tPPProduktpass`.`PPProduktpass_CRDJahr`,(`tPPProduktpass`.`PPProduktpass_CRDWoche` * 7)) + interval -(2) day) AS `CRDausDaten`,(case `tPPProduktpass`.`PPProduktpass_CRDJahr` when 0 then ((makedate(`tPPProduktpass`.`PPProduktpass_LieferterminJahr`,(`tPPProduktpass`.`PPProduktpass_Liefertermin` * 7)) + interval -(2) day) + interval -(10) week) else (makedate(`tPPProduktpass`.`PPProduktpass_CRDJahr`,(`tPPProduktpass`.`PPProduktpass_CRDWoche` * 7)) + interval -(2) day) end) AS `CRD` from `tPPProduktpass` where (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_CountLocalFiles`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_CountLocalFiles` AS select `P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,count(`F`.`PPPPFiles_Id`) AS `NoLocalFiles` from (`tPPProduktpass` `P` join `PPPPFiles` `F` on((`P`.`PPProduktpass_Id` = `F`.`PPPPFiles_PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (`P`.`PPProduktpass_Id` > 0) and (`P`.`InternerStatus` like '%') and (`F`.`PPPPFiles_Status` = 1) and (`F`.`PPPPFiles_SharePointLink` is null)) group by `P`.`InternerStatus`,`P`.`PPProduktpass_Id`,`P`.`PPProduktpass_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_CountSharepointFiles`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_CountSharepointFiles` AS select `P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,count(`F`.`PPPPFiles_Id`) AS `NoLocalFiles` from (`tPPProduktpass` `P` join `PPPPFiles` `F` on((`P`.`PPProduktpass_Id` = `F`.`PPPPFiles_PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (`P`.`PPProduktpass_Id` > 0) and (`P`.`InternerStatus` like '%') and (`F`.`PPPPFiles_Status` = 1) and (`F`.`PPPPFiles_SharePointLink` is not null)) group by `P`.`InternerStatus`,`P`.`PPProduktpass_Id`,`P`.`PPProduktpass_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DBUebersicht`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DBUebersicht` AS select distinct `PO`.`PPPurchase_PPProduktpass_Id` AS `PPPurchase_PPProduktpass_Id`,`PO`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`PO`.`PPPurchase_Currency` AS `PPPurchase_Currency`,`PO`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc`,`PO`.`PPPurchase_EK` AS `PPPurchase_EK`,`PO`.`PPPurchase_LC_TOP` AS `PPPurchase_LC_TOP` from (`PPPurchase` `PO` join `v_PurchaseLast` `PL` on((`PO`.`PPPurchase_Id` = `PL`.`PPPurchase_Id`))) where ((`PO`.`PPPurchase_Supplier` <> '') and (`PO`.`PPPurchase_EK` <> 0)) order by `PO`.`PPPurchase_PPProduktpass_Id` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKAssign`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKAssign` AS select `PO`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`PO`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`PO`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`PO`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`DTK`.`PPPurchaseDTK_Id` AS `PPPurchaseDTK_Id`,`DTK`.`PPPurchaseDTK_PPProduktpass_id` AS `PPPurchaseDTK_PPProduktpass_id`,`DTK`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id` AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`,`DTK`.`PPPurchaseDTK_Betrag` AS `PPPurchaseDTK_Betrag`,`PO`.`PPPurchase_ExcR_Calc` AS `KursKalk`,`PO`.`PO_Wert` AS `PO_Wert` from (`PPPurchaseDTK` `DTK` left join `v_POinFW` `PO` on((`PO`.`PPProduktpass_Id` = `DTK`.`PPPurchaseDTK_PPProduktpass_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKGebunden`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKGebunden` AS select sum(`v_DTKAssign`.`PPPurchaseDTK_Betrag`) AS `BetragGebunden`,`v_DTKAssign`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id` AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id` from `v_DTKAssign` group by `v_DTKAssign`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKNachMonaten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKNachMonaten` AS select sum(`v_DTKmitWerten`.`PPDevisenTerminKaeufe_Betrag`) AS `DTK_Betrag`,month(`v_DTKmitWerten`.`PPDevisenTerminKaeufe_Termin`) AS `DTK_Monat`,year(`v_DTKmitWerten`.`PPDevisenTerminKaeufe_Termin`) AS `DTK_Jahr` from `v_DTKmitWerten` group by month(`v_DTKmitWerten`.`PPDevisenTerminKaeufe_Termin`),year(`v_DTKmitWerten`.`PPDevisenTerminKaeufe_Termin`);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKUebersicht`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKUebersicht` AS select `P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`G`.`Gedeckt` AS `Gedeckt`,`P`.`PO_Wert` AS `PO_Wert`,`P`.`PPPurchase_ExcR_Calc` AS `KursKalk`,`P`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer` from (`v_POinFW` `P` left join `v_GedecktePO` `G` on((`P`.`PPProduktpass_Id` = `G`.`PPPurchaseDTK_PPProduktpass_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKUngedeckt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKUngedeckt` AS select `v_DTKUebersicht`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`v_DTKUebersicht`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`v_DTKUebersicht`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,concat(`v_DTKUebersicht`.`PPProduktpass_LieferterminJahr`,'/',`v_DTKUebersicht`.`PPProduktpass_Liefertermin`) AS `LT`,`v_DTKUebersicht`.`PO_Wert` AS `PO_Wert`,(`v_DTKUebersicht`.`PO_Wert` - ifnull(`v_DTKUebersicht`.`Gedeckt`,0)) AS `Ungedeckt` from `v_DTKUebersicht` where ((`v_DTKUebersicht`.`PO_Wert` - ifnull(`v_DTKUebersicht`.`Gedeckt`,0)) > 0);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKmitWerten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKmitWerten` AS select `DTK`.`PPDevisenTerminKaeufe_Id` AS `PPDevisenTerminKaeufe_Id`,`DTK`.`PPDevisenTerminKaeufe_Referenz` AS `PPDevisenTerminKaeufe_Referenz`,`DTK`.`PPDevisenTerminKaeufe_Termin` AS `PPDevisenTerminKaeufe_Termin`,`DTK`.`PPDevisenTerminKaeufe_Betrag` AS `PPDevisenTerminKaeufe_Betrag`,`DTK`.`PPDevisenTerminKaeufe_Kurs` AS `PPDevisenTerminKaeufe_Kurs`,`DTK`.`PPDevisenTerminKaeufe_Bank` AS `PPDevisenTerminKaeufe_Bank`,`DTK`.`updated_at` AS `updated_at`,`DTK`.`created_at` AS `create or Replace d_at`,`DTK`.`PPDevisenTerminKaeufe_Status` AS `PPDevisenTerminKaeufe_Status`,`DTK`.`PPDevisenTerminKaeufe_Bemerkung` AS `PPDevisenTerminKaeufe_Bemerkung`,`G`.`BetragGebunden` AS `BetragGebunden`,`G`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id` AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`,(`DTK`.`PPDevisenTerminKaeufe_Betrag` - ifnull(`G`.`BetragGebunden`,0)) AS `Offen` from (`PPDevisenTerminKaeufe` `DTK` left join `v_DTKGebunden` `G` on((`DTK`.`PPDevisenTerminKaeufe_Id` = `G`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_DTKmitZuordung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_DTKmitZuordung` AS select `DTK`.`PPDevisenTerminKaeufe_Id` AS `PPDevisenTerminKaeufe_Id`,`DTK`.`PPDevisenTerminKaeufe_Referenz` AS `PPDevisenTerminKaeufe_Referenz`,`DTK`.`PPDevisenTerminKaeufe_Termin` AS `PPDevisenTerminKaeufe_Termin`,`DTK`.`PPDevisenTerminKaeufe_Betrag` AS `PPDevisenTerminKaeufe_Betrag`,`DTK`.`PPDevisenTerminKaeufe_Kurs` AS `PPDevisenTerminKaeufe_Kurs`,`DTK`.`PPDevisenTerminKaeufe_Bank` AS `PPDevisenTerminKaeufe_Bank`,`DTK`.`updated_at` AS `updated_at`,`DTK`.`created_at` AS `create or Replace d_at`,`DTK`.`PPDevisenTerminKaeufe_Status` AS `PPDevisenTerminKaeufe_Status`,`DTK`.`PPDevisenTerminKaeufe_Bemerkung` AS `PPDevisenTerminKaeufe_Bemerkung`,`Ass`.`PPPurchaseDTK_Id` AS `PPPurchaseDTK_Id`,`Ass`.`PPPurchaseDTK_PPProduktpass_id` AS `PPPurchaseDTK_PPProduktpass_id`,`Ass`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id` AS `PPPurchaseDTK_PPDevisenTerminKaeufe_Id`,`Ass`.`PPPurchaseDTK_Betrag` AS `PPPurchaseDTK_Betrag` from (`PPDevisenTerminKaeufe` `DTK` join `PPPurchaseDTK` `Ass` on((`DTK`.`PPDevisenTerminKaeufe_Id` = `Ass`.`PPPurchaseDTK_PPDevisenTerminKaeufe_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_EANTest`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_EANTest` AS select `test`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`test`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id` from (`v_EANTest1` `test` join `PPProduktpass` `P` on((`P`.`PPProduktpass_Id` = `test`.`PPProduktpass_Sortierung_PPProduktpass_Id`))) where (`P`.`PPProduktpass_RevisionVon_PPProduktpass_Id` is null);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_EANTest1`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_EANTest1` AS select '1' AS `EANPOS`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN`) <> '')) union select '2' AS `2`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN02` AS `PPProduktpass_Sortierung_EAN02` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN02` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN02`) <> '')) union select '3' AS `3`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN03` AS `PPProduktpass_Sortierung_EAN03` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN03` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN03`) <> '')) union select '4' AS `4`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN04` AS `PPProduktpass_Sortierung_EAN04` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN04` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN04`) <> '')) union select '5' AS `5`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN05` AS `PPProduktpass_Sortierung_EAN05` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN05` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN05`) <> '')) union select '6' AS `6`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN06` AS `PPProduktpass_Sortierung_EAN06` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN06` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN06`) <> '')) union select '7' AS `7`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN07` AS `PPProduktpass_Sortierung_EAN07` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN07` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN07`) <> '')) union select '8' AS `8`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN08` AS `PPProduktpass_Sortierung_EAN08` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN08` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN08`) <> '')) union select '9' AS `9`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN09` AS `PPProduktpass_Sortierung_EAN09` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN09` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN09`) <> '')) union select '10' AS `10`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN10` AS `PPProduktpass_Sortierung_EAN10` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN10` is not null) and (trim(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN10`) <> ''));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ESSortierungKI`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ESSortierungKI` AS select `PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,sum(`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02`) AS `KI` from `PPProduktpass_Sortierung` group by `PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ESSortierungOrderWeights`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ESSortierungOrderWeights` AS select `PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPOrderWeights`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`PPOrderWeights`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`PPOrderWeights`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`PPOrderWeights`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`PPOrderWeights`.`PPOrderWeights_unit` AS `PPOrderWeights_unit` from (`PPProduktpass_Sortierung` join `PPOrderWeights` on(((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` = `PPOrderWeights`.`PPOrderWeights_styleNo`) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` = `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id`))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_FileDoubletten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_FileDoubletten` AS select count(0) AS `AnzahlDateien`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,`F`.`PPPPFiles_Name` AS `PPPPFiles_Name`,concat(`F`.`PPPPFiles_Type`,'@',`F`.`PPPPFiles_SubKat`) AS `Reiter` from (`PPPPFiles` `F` join `tPPProduktpass` `P` on((`P`.`PPProduktpass_Id` = `F`.`PPPPFiles_PPProduktpass_Id`))) where ((`F`.`PPPPFiles_SharePointLink` is not null) and (`F`.`PPPPFiles_Status` = 1) and (not((`P`.`PPProduktpass_IAN` like '%rev%')))) group by `P`.`PPProduktpass_IAN`,substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4),`F`.`PPPPFiles_Name`,`F`.`PPPPFiles_Type`,`F`.`PPPPFiles_SubKat`,`F`.`PPPPFiles_Ordnung` order by `F`.`PPPPFiles_Name` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_FileProtokoll`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_FileProtokoll` AS select `F`.`PPPPFiles_Status` AS `PPPPFiles_Status`,`F`.`PPPPFiles_PPProduktpass_Id` AS `PPPPFiles_PPProduktpass_Id`,`F`.`PPPPFiles_Name` AS `PPPPFiles_Name`,`F`.`created_at` AS `created_at`,`F`.`updated_at` AS `updated_at`,`F`.`PPPPFiles_UserCreate` AS `PPPPFiles_UserCreate`,`F`.`PPPPFiles_UserDelete` AS `PPPPFiles_UserDelete`,`F`.`PPPPFiles_Type` AS `PPPPFiles_Type`,`F`.`PPPPFiles_SubKat` AS `PPPPFiles_SubKat`,`F`.`PPPPFiles_Ordnung` AS `PPPPFiles_Ordnung`,`MC`.`PPMitarbeiter_Kuerzel` AS `CreateUser`,`MD`.`PPMitarbeiter_Kuerzel` AS `DeleteUser` from ((`PPPPFiles` `F` left join `PPMitarbeiter` `MC` on((`MC`.`PPMitarbeiter_Id` = `F`.`PPPPFiles_UserCreate`))) left join `PPMitarbeiter` `MD` on((`MD`.`PPMitarbeiter_Id` = `F`.`PPPPFiles_UserDelete`))) order by `F`.`updated_at` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_FilesAll`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_FilesAll` AS select `tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,`PPPPFiles`.`PPPPFiles_Name` AS `PPPPFiles_Name`,`PPPPFiles`.`PPPPFiles_Type` AS `PPPPFiles_Type`,max(`PPPPFiles`.`PPPPFiles_Date`) AS `FileDate`,`PPPPFiles`.`PPPPFiles_Pfad` AS `PPPPFiles_Pfad`,`PPPPFiles`.`PPPPFiles_SubKat` AS `PPPPFiles_SubKat`,ifnull(`PPPPFiles`.`PPPPFiles_Ordnung`,'') AS `PPPPFiles_Ordnung`,`PPPPFiles`.`PPPPFiles_LinkName` AS `PPPPFiles_LinkName`,`PPPPFiles`.`PPPPFiles_Link` AS `PPPPFiles_Link`,`PPPPFiles`.`PPPPFiles_SharePointLink` AS `PPPPFiles_SharePointLink`,max(`PPPPFiles`.`PPPPFiles_Id`) AS `FId`,`PPPPFiles`.`PPPPFiles_IsExtern` AS `PPPPFiles_IsExtern` from (`tPPProduktpass` join `PPPPFiles` on((`PPPPFiles`.`PPPPFiles_PPProduktpass_Id` = `tPPProduktpass`.`PPProduktpass_Id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))) and (`PPPPFiles`.`PPPPFiles_Status` >= 1) and (`PPPPFiles`.`PPPPFiles_NoPPID` = 0)) group by `tPPProduktpass`.`PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_ArtikelTarga`,`tPPProduktpass`.`InternerStatus`,`PPPPFiles`.`PPPPFiles_Name`,`PPPPFiles`.`PPPPFiles_Type`,`PPPPFiles`.`PPPPFiles_Pfad`,`PPPPFiles`.`PPPPFiles_SubKat`,`PPPPFiles`.`PPPPFiles_Ordnung`,`PPPPFiles`.`PPPPFiles_LinkName`,`PPPPFiles`.`PPPPFiles_Link`,`PPPPFiles`.`PPPPFiles_SharePointLink`,`PPPPFiles`.`PPPPFiles_IsExtern`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_FilesDistinct`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_FilesDistinct` AS select distinct `v_FilesSub`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`v_FilesSub`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`v_FilesSub`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`v_FilesSub`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`v_FilesSub`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`v_FilesSub`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`v_FilesSub`.`InternerStatus` AS `InternerStatus`,`v_FilesSub`.`Filename` AS `Filename`,`v_FilesSub`.`FId` AS `FId`,`PPPPFiles`.`PPPPFiles_Id` AS `PPPPFiles_Id`,`PPPPFiles`.`PPPPFiles_PPProduktpass_Id` AS `PPPPFiles_PPProduktpass_Id`,`PPPPFiles`.`PPPPFiles_Name` AS `PPPPFiles_Name`,`PPPPFiles`.`PPPPFiles_Type` AS `PPPPFiles_Type`,`PPPPFiles`.`PPPPFiles_Date` AS `PPPPFiles_Date`,`PPPPFiles`.`PPPPFiles_Description` AS `PPPPFiles_Description`,`PPPPFiles`.`PPPPFiles_Pfad` AS `PPPPFiles_Pfad`,`PPPPFiles`.`created_at` AS `created_at`,`PPPPFiles`.`updated_at` AS `updated_at`,`PPPPFiles`.`PPPPFiles_SubKat` AS `PPPPFiles_SubKat`,`PPPPFiles`.`PPPPFiles_Ordnung` AS `PPPPFiles_Ordnung`,`PPPPFiles`.`PPPPFiles_Link` AS `PPPPFiles_Link`,`PPPPFiles`.`PPPPFiles_LinkName` AS `PPPPFiles_LinkName`,`PPPPFiles`.`PPPPFiles_UserCreate` AS `PPPPFiles_UserCreate`,`PPPPFiles`.`PPPPFiles_UserDelete` AS `PPPPFiles_UserDelete`,`PPPPFiles`.`PPPPFiles_Status` AS `PPPPFiles_Status`,`PPPPFiles`.`PPPPFiles_SharePointLink` AS `PPPPFiles_SharePointLink`,`PPPPFiles`.`PPPPFiles_TPTFilenameOld` AS `PPPPFiles_TPTFilenameOld`,`PPPPFiles`.`PPPPFiles_LocalUpload` AS `PPPPFiles_LocalUpload`,`PPPPFiles`.`PPPPFiles_Size` AS `PPPPFiles_Size`,`PPPPFiles`.`PPPPFiles_UserLastModified` AS `PPPPFiles_UserLastModified`,`PPPPFiles`.`PPPPFiles_DateLastModiefied` AS `PPPPFiles_DateLastModiefied`,`PPPPFiles`.`PPPPFiles_UploadException` AS `PPPPFiles_UploadException`,`PPPPFiles`.`PPPPFiles_NoPPID` AS `PPPPFiles_NoPPID`,`PFT1`.`PPFileTypes_Safety` AS `TypeRestricted`,`PFT2`.`PPFileTypes_Safety` AS `KatRestricted`,`PPPPFiles`.`PPPPFiles_IsExtern` AS `PPPPFiles_IsExtern` from (((`v_FilesSub` join `PPPPFiles` on((`PPPPFiles`.`PPPPFiles_Id` = `v_FilesSub`.`FId`))) left join `PPFileTypes` `PFT1` on((`PFT1`.`PPFileTypes_Type` = `v_FilesSub`.`File_Type`))) left join `PPFileTypes` `PFT2` on((`PFT2`.`PPFileTypes_Type` = `v_FilesSub`.`File_SubKat`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_FilesSub`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_FilesSub` AS select `tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,`PPPPFiles`.`PPPPFiles_Name` AS `Filename`,max(`PPPPFiles`.`PPPPFiles_Id`) AS `FId`,max(`PPPPFiles`.`PPPPFiles_Type`) AS `File_Type`,max(`PPPPFiles`.`PPPPFiles_SubKat`) AS `File_SubKat` from (`tPPProduktpass` join `PPPPFiles` on((`PPPPFiles`.`PPPPFiles_PPProduktpass_Id` = `tPPProduktpass`.`PPProduktpass_Id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))) and (`PPPPFiles`.`PPPPFiles_Status` >= 1) and (`PPPPFiles`.`PPPPFiles_NoPPID` = 0)) group by `tPPProduktpass`.`PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_ArtikelTarga`,`tPPProduktpass`.`InternerStatus`,`PPPPFiles`.`PPPPFiles_Name`,`PPPPFiles`.`PPPPFiles_SubKat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_GTINWeightsPerStyle`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_GTINWeightsPerStyle` AS select `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id` AS `v_GTINWeightsPerStyle_PPProduktpass_Id`,`PPOrderWeights`.`PPOrderWeights_gtin` AS `vPPOrderWeights_gtin`,`PPOrderWeights`.`PPOrderWeights_gtinKL` AS `vPPOrderWeights_gtinKL`,`PPOrderWeights`.`PPOrderWeights_styleNo` AS `vPPOrderWeights_styleNo`,`PPOrderWeights`.`PPOrderWeights_unit` AS `vPPOrderWeights_unit`,`PPOrderWeights`.`PPOrderWeights_weight` AS `vPPOrderWeights_weight`,`PPOrderWeights`.`PPOrderWeights_lsv` AS `vPPOrderWeights_lsv`,`PPLsv`.`PPLsv_countryCodes` AS `vPPLsv_countryCodes` from (`PPOrderWeights` join `PPLsv` on((`PPLsv`.`PPLsv_PPProduktpass_Id` = `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_GedecktePO`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_GedecktePO` AS select sum(`PPPurchaseDTK`.`PPPurchaseDTK_Betrag`) AS `Gedeckt`,`PPPurchaseDTK`.`PPPurchaseDTK_PPProduktpass_id` AS `PPPurchaseDTK_PPProduktpass_id` from `PPPurchaseDTK` group by `PPPurchaseDTK`.`PPPurchaseDTK_PPProduktpass_id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_IANReal`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_IANReal` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,left(`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung` from `tPPProduktpass` where (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%Rev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_IsUSOrder`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_IsUSOrder` AS select `v_Laendermengen`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id` from `v_Laendermengen` where (`v_Laendermengen`.`PPProduktpass_Menge_Country` like '%US%');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_IsUSOrderPP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_IsUSOrderPP` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IsUSA` AS `PPProduktpass_IsUSA` from `tPPProduktpass` where ((`tPPProduktpass`.`PPProduktpass_IsUSA` = 1) and (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_KursReal`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_KursReal` AS select distinct `PPPurchase`.`PPPurchase_PPProduktpass_Id` AS `PPPurchase_PPProduktpass_Id`,`PPPurchase`.`PPPurchase_ExcR_Save_Date` AS `PPPurchase_ExcR_Save_Date`,`PPPurchase`.`PPPurchase_Currency` AS `PPPurchase_Currency`,if((`PPPurchase`.`PPPurchase_Currency` = 'EUR'),1,if((ifnull(`PPPurchase`.`PPPurchase_ExcR_Save`,0) <> 0),`PPPurchase`.`PPPurchase_ExcR_Save`,ifnull(`PPPurchase`.`PPPurchase_ExcR_Calc`,0))) AS `Kurs`,`PPPurchase`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc` from `PPPurchase` where (`PPPurchase`.`PPPurchase_Currency` is not null) order by `PPPurchase`.`PPPurchase_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LCEroeffnungenPeriode`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LCEroeffnungenPeriode` AS select year(`v_Liquiditaet`.`LCEroeffnung`) AS `LCEroeffnungJahr`,month(`v_Liquiditaet`.`LCEroeffnung`) AS `LCEroeffnungMonat`,`v_Liquiditaet`.`EKGesamt` AS `EKGesamt`,`v_Liquiditaet`.`PPProduktpass_Id` AS `PPProduktpass_Id` from `v_Liquiditaet`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LCEroeffnungenPeriodeKUM`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LCEroeffnungenPeriodeKUM` AS select sum(`v_LCEroeffnungenPeriode`.`EKGesamt`) AS `LCEroeffnungSummeEK`,`v_LCEroeffnungenPeriode`.`LCEroeffnungJahr` AS `LCEroeffnungJahr`,`v_LCEroeffnungenPeriode`.`LCEroeffnungMonat` AS `LCEroeffnungMonat` from `v_LCEroeffnungenPeriode` group by `v_LCEroeffnungenPeriode`.`LCEroeffnungJahr`,`v_LCEroeffnungenPeriode`.`LCEroeffnungMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LTMengenJeHafen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LTMengenJeHafen` AS select `LB`.`PPLaenderbloecke_Hafen1` AS `PPLaenderbloecke_Hafen1`,`LB`.`PPLaenderbloecke_Hafen2` AS `PPLaenderbloecke_Hafen2`,`AB`.`PPAB_Aufteilung_Rotterdam_FR` AS `PPAB_Aufteilung_Rotterdam_FR`,`AB`.`PPAB_Aufteilung_Barcelona_IT` AS `PPAB_Aufteilung_Barcelona_IT`,`M`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`M`.`PPProduktpass_Menge_LT1` AS `PPProduktpass_Menge_LT1`,sum(`M`.`PPProduktpass_Menge_LT1Menge`) AS `MengeLT1`,`M`.`PPProduktpass_Menge_LT2` AS `PPProduktpass_Menge_LT2`,sum(`M`.`PPProduktpass_Menge_LT2Menge`) AS `MengeLT2`,`M`.`PPProduktpass_Menge_LT3` AS `PPProduktpass_Menge_LT3`,sum(`M`.`PPProduktpass_Menge_LT3Menge`) AS `MengeLT3` from ((`PPProduktpass_Menge` `M` left join `PPLaenderbloecke` `LB` on((`M`.`PPProduktpass_Menge_Country` = `LB`.`PPLaenderbloecke_Land`))) left join `PPAB` `AB` on((`AB`.`PPAB_PPProduktpass_Id` = `M`.`PPProduktpass_Menge_PPProduktpass_Id`))) group by `LB`.`PPLaenderbloecke_Hafen1`,`LB`.`PPLaenderbloecke_Hafen2`,`M`.`PPProduktpass_Menge_PPProduktpass_Id`,`M`.`PPProduktpass_Menge_LT1`,`M`.`PPProduktpass_Menge_LT2`,`M`.`PPProduktpass_Menge_LT3`,`AB`.`PPAB_Aufteilung_Rotterdam_FR`,`AB`.`PPAB_Aufteilung_Barcelona_IT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Laendergesamtmengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Laendergesamtmengen` AS select `P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`P`.`InternerStatus` AS `InternerStatus`,`P`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`P`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,sum(`M`.`PPProduktpass_Menge_Quantity`) AS `LaenderGesamtmenge` from (`tPPProduktpass` `P` join `PPProduktpass_Menge` `M` on((`P`.`PPProduktpass_Id` = `M`.`PPProduktpass_Menge_PPProduktpass_Id`))) where (not((`P`.`PPProduktpass_IAN` like '%ev%'))) group by `P`.`PPProduktpass_Id`,`P`.`PPProduktpass_IAN`,`P`.`PPProduktpass_Gesamtmenge`,`P`.`PPProduktpass_Ausmusterungnummer`,`P`.`InternerStatus`,`P`.`PPProduktpass_RevisionVon_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Laendermengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Laendermengen` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity` AS `PPProduktpass_Menge_Quantity`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country` from `PPProduktpass_Menge` where (`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity` <> 0);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LatestServiceAnfrage`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LatestServiceAnfrage` AS select `PPInputManuell`.`PPInputManuell_Id` AS `PPInputManuell_Id`,`PPInputManuell`.`PPInputManuell_PPProduktpass_Id` AS `PPInputManuell_PPProduktpass_Id`,`PPInputManuell`.`PPInputManuell_Projektname` AS `PPInputManuell_Projektname`,`PPInputManuell`.`PPInputManuell_Lieferant` AS `PPInputManuell_Lieferant`,`PPInputManuell`.`PPInputManuell_GeplanterEKUSD` AS `PPInputManuell_GeplanterEKUSD`,`PPInputManuell`.`PPInputManuell_GeplanterVK` AS `PPInputManuell_GeplanterVK`,`PPInputManuell`.`PPInputManuell_LaufzeitGarantie` AS `PPInputManuell_LaufzeitGarantie`,`PPInputManuell`.`PPInputManuell_GarantieLieferant` AS `PPInputManuell_GarantieLieferant`,`PPInputManuell`.`PPInputManuell_AbwicklungGarantie` AS `PPInputManuell_AbwicklungGarantie`,`PPInputManuell`.`PPInputManuell_SonderleistungLieferant` AS `PPInputManuell_SonderleistungLieferant`,`PPInputManuell`.`PPInputManuell_MaxAusfallrate` AS `PPInputManuell_MaxAusfallrate`,`PPInputManuell`.`PPInputManuell_ServiceVetrag` AS `PPInputManuell_ServiceVetrag`,`PPInputManuell`.`PPInputManuell_Verschiffungshafen` AS `PPInputManuell_Verschiffungshafen`,`PPInputManuell`.`PPInputManuell_MengeDE` AS `PPInputManuell_MengeDE`,`PPInputManuell`.`PPInputManuell_MengeEU` AS `PPInputManuell_MengeEU`,`PPInputManuell`.`PPInputManuell_VE` AS `PPInputManuell_VE`,`PPInputManuell`.`PPInputManuell_Masse` AS `PPInputManuell_Masse`,`PPInputManuell`.`PPInputManuell_Laenge` AS `PPInputManuell_Laenge`,`PPInputManuell`.`PPInputManuell_Breite` AS `PPInputManuell_Breite`,`PPInputManuell`.`PPInputManuell_Hoehe` AS `PPInputManuell_Hoehe`,`PPInputManuell`.`PPInputManuell_Onlinekartonage` AS `PPInputManuell_Onlinekartonage`,`PPInputManuell`.`PPInputManuell_Ausfallrate` AS `PPInputManuell_Ausfallrate`,`PPInputManuell`.`PPInputManuell_ZukaufServiceWare` AS `PPInputManuell_ZukaufServiceWare`,`PPInputManuell`.`PPInputManuell_Servicekostensatz` AS `PPInputManuell_Servicekostensatz`,`PPInputManuell`.`PPInputManuell_Preisblatt` AS `PPInputManuell_Preisblatt`,`PPInputManuell`.`PPInputManuell_EingangsfrachtZFRD` AS `PPInputManuell_EingangsfrachtZFRD`,`PPInputManuell`.`PPInputManuell_LogistikZLGK` AS `PPInputManuell_LogistikZLGK`,`PPInputManuell`.`PPInputManuell_AusgangsfrachtZRF2` AS `PPInputManuell_AusgangsfrachtZRF2`,`PPInputManuell`.`PPInputManuell_ContHCStk` AS `PPInputManuell_ContHCStk`,`PPInputManuell`.`PPInputManuell_ContHCRot` AS `PPInputManuell_ContHCRot`,`PPInputManuell`.`PPInputManuell_ContHCBar` AS `PPInputManuell_ContHCBar`,`PPInputManuell`.`PPInputManuell_ContHCKop` AS `PPInputManuell_ContHCKop`,`PPInputManuell`.`PPInputManuell_ContHCUSA` AS `PPInputManuell_ContHCUSA`,`PPInputManuell`.`PPInputManuell_Cont40Stk` AS `PPInputManuell_Cont40Stk`,`PPInputManuell`.`PPInputManuell_Cont40Rot` AS `PPInputManuell_Cont40Rot`,`PPInputManuell`.`PPInputManuell_Cont40Bar` AS `PPInputManuell_Cont40Bar`,`PPInputManuell`.`PPInputManuell_Cont40Kop` AS `PPInputManuell_Cont40Kop`,`PPInputManuell`.`PPInputManuell_Cont40USA` AS `PPInputManuell_Cont40USA`,`PPInputManuell`.`PPInputManuell_Cont20Stk` AS `PPInputManuell_Cont20Stk`,`PPInputManuell`.`PPInputManuell_Cont20Rot` AS `PPInputManuell_Cont20Rot`,`PPInputManuell`.`PPInputManuell_Cont20Bar` AS `PPInputManuell_Cont20Bar`,`PPInputManuell`.`PPInputManuell_Cont20Kop` AS `PPInputManuell_Cont20Kop`,`PPInputManuell`.`PPInputManuell_Cont20USA` AS `PPInputManuell_Cont20USA`,`PPInputManuell`.`PPInputManuell_ContPlan20` AS `PPInputManuell_ContPlan20`,`PPInputManuell`.`PPInputManuell_ContPlan40` AS `PPInputManuell_ContPlan40`,`PPInputManuell`.`PPInputManuell_ContPlan40HC` AS `PPInputManuell_ContPlan40HC`,`PPInputManuell`.`PPInputManuell_Exportkarton_VE_V2` AS `PPInputManuell_Exportkarton_VE_V2`,`PPInputManuell`.`PPInputManuell_Exportkarton_Masse_V2` AS `PPInputManuell_Exportkarton_Masse_V2`,`PPInputManuell`.`PPInputManuell_Exportkarton_Laenge_V2` AS `PPInputManuell_Exportkarton_Laenge_V2`,`PPInputManuell`.`PPInputManuell_Exportkarton_Breite_V2` AS `PPInputManuell_Exportkarton_Breite_V2`,`PPInputManuell`.`PPInputManuell_Exportkarton_Hoehe_V2` AS `PPInputManuell_Exportkarton_Hoehe_V2`,`PPInputManuell`.`PPInputManuell_Exportkarton_VE` AS `PPInputManuell_Exportkarton_VE`,`PPInputManuell`.`PPInputManuell_Exportkarton_Masse` AS `PPInputManuell_Exportkarton_Masse`,`PPInputManuell`.`PPInputManuell_Exportkarton_Laenge` AS `PPInputManuell_Exportkarton_Laenge`,`PPInputManuell`.`PPInputManuell_Exportkarton_Breite` AS `PPInputManuell_Exportkarton_Breite`,`PPInputManuell`.`PPInputManuell_Exportkarton_Hoehe` AS `PPInputManuell_Exportkarton_Hoehe`,`PPInputManuell`.`PPInputManuell_GutschriftenbetragKunde` AS `PPInputManuell_GutschriftenbetragKunde`,`PPInputManuell`.`PPInputManuell_StkProPalette` AS `PPInputManuell_StkProPalette`,`PPInputManuell`.`PPInputManuell_DeckelAusfallrate` AS `PPInputManuell_DeckelAusfallrate`,`PPInputManuell`.`PPInputManuell_IsLatest` AS `PPInputManuell_IsLatest`,`PPInputManuell`.`PPInputManuell_Date` AS `PPInputManuell_Date`,`PPInputManuell`.`PPInputManuell_Bemerkungen` AS `PPInputManuell_Bemerkungen`,`PPInputManuell`.`PPInputManuell_StatusPM` AS `PPInputManuell_StatusPM`,`PPInputManuell`.`PPInputManuell_StatusMaWi` AS `PPInputManuell_StatusMaWi`,`PPInputManuell`.`PPInputManuell_TextGroesse` AS `PPInputManuell_TextGroesse`,`PPInputManuell`.`PPInputManuell_UAWGB` AS `PPInputManuell_UAWGB`,`PPInputManuell`.`PPInputManuell_KLContPlan20` AS `PPInputManuell_KLContPlan20`,`PPInputManuell`.`PPInputManuell_KLContPlan40` AS `PPInputManuell_KLContPlan40`,`PPInputManuell`.`PPInputManuell_KLContPlan40HC` AS `PPInputManuell_KLContPlan40HC`,`PPInputManuell`.`PPInputManuell_EKWSYM` AS `PPInputManuell_EKWSYM`,`PPInputManuell`.`PPInputManuell_KLExportkarton_VE` AS `PPInputManuell_KLExportkarton_VE`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Masse` AS `PPInputManuell_KLExportkarton_Masse`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Laenge` AS `PPInputManuell_KLExportkarton_Laenge`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Breite` AS `PPInputManuell_KLExportkarton_Breite`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Hoehe` AS `PPInputManuell_KLExportkarton_Hoehe`,`PPInputManuell`.`PPInputManuell_KLExportkarton_VE_V2` AS `PPInputManuell_KLExportkarton_VE_V2`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Masse_V2` AS `PPInputManuell_KLExportkarton_Masse_V2`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Laenge_V2` AS `PPInputManuell_KLExportkarton_Laenge_V2`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Breite_V2` AS `PPInputManuell_KLExportkarton_Breite_V2`,`PPInputManuell`.`PPInputManuell_KLExportkarton_Hoehe_V2` AS `PPInputManuell_KLExportkarton_Hoehe_V2`,`PPInputManuell`.`PPInputManuell_OSExportkarton_VE` AS `PPInputManuell_OSExportkarton_VE`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Masse` AS `PPInputManuell_OSExportkarton_Masse`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Laenge` AS `PPInputManuell_OSExportkarton_Laenge`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Breite` AS `PPInputManuell_OSExportkarton_Breite`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Hoehe` AS `PPInputManuell_OSExportkarton_Hoehe`,`PPInputManuell`.`PPInputManuell_OSExportkarton_VE_V2` AS `PPInputManuell_OSExportkarton_VE_V2`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Masse_V2` AS `PPInputManuell_OSExportkarton_Masse_V2`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Laenge_V2` AS `PPInputManuell_OSExportkarton_Laenge_V2`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Breite_V2` AS `PPInputManuell_OSExportkarton_Breite_V2`,`PPInputManuell`.`PPInputManuell_OSExportkarton_Hoehe_V2` AS `PPInputManuell_OSExportkarton_Hoehe_V2` from `PPInputManuell` where (`PPInputManuell`.`PPInputManuell_IsLatest` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Lieferlaender`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Lieferlaender` AS select distinct `PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country` from `PPProduktpass_Menge` where (`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` is not null);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LinkedItems`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LinkedItems` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PPProduktpass_KLLink`.`PPProduktpass_KLLink_PPProduktpass_Id` AS `PPProduktpass_KLLink_PPProduktpass_Id`,`PPProduktpass_KLLink`.`PPProduktpass_KLLink_IAN` AS `PPProduktpass_KLLink_IAN`,`PPProduktpass_KLLink`.`PPProduktpass_KLLink_lotNo` AS `PPProduktpass_KLLink_lotNo`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`itemTypeKL` AS `itemTypeKL`,`tPPProduktpass`.`PPProduktpass_continentType` AS `PPProduktpass_continentType`,`tPPProduktpass`.`PPProduktpass_linkedItemIan` AS `PPProduktpass_linkedItemIan`,`tPPProduktpass`.`PPProduktpass_linkedItemLotNo` AS `PPProduktpass_linkedItemLotNo` from (`tPPProduktpass` left join `PPProduktpass_KLLink` on((`tPPProduktpass`.`PPProduktpass_Id` = `PPProduktpass_KLLink`.`PPProduktpass_KLLink_PPProduktpass_Id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%'))) and ((`PPProduktpass_KLLink`.`PPProduktpass_KLLink_IAN` is null) or (not((trim(`PPProduktpass_KLLink`.`PPProduktpass_KLLink_IAN`) like '0'))))) union select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PPProduktpass_KLLink`.`PPProduktpass_KLLink_PPProduktpass_Id` AS `PPProduktpass_KLLink_PPProduktpass_Id`,`PPProduktpass_KLLink`.`PPProduktpass_KLLink_IAN` AS `PPProduktpass_KLLink_IAN`,`PPProduktpass_KLLink`.`PPProduktpass_KLLink_lotNo` AS `PPProduktpass_KLLink_lotNo`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`itemTypeKL` AS `itemTypeKL`,`tPPProduktpass`.`PPProduktpass_continentType` AS `PPProduktpass_continentType`,`tPPProduktpass`.`PPProduktpass_linkedItemIan` AS `PPProduktpass_linkedItemIan`,`tPPProduktpass`.`PPProduktpass_linkedItemLotNo` AS `PPProduktpass_linkedItemLotNo` from (`tPPProduktpass` left join `PPProduktpass_KLLink` on((`tPPProduktpass`.`PPProduktpass_Id` = `PPProduktpass_KLLink`.`PPProduktpass_KLLink_PPProduktpass_Id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%'))) and ((`PPProduktpass_KLLink`.`PPProduktpass_KLLink_IAN` is null) or (not((trim(`PPProduktpass_KLLink`.`PPProduktpass_KLLink_IAN`) like '0'))))) order by `PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqAbflussPeriode`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqAbflussPeriode` AS select `P`.`PPPerioden_Jahr` AS `Jahr`,`P`.`PPPerioden_Monat` AS `Monat`,`USD`.`Abfluss` AS `USD`,`EUR`.`Abfluss` AS `EUR` from ((`PPPerioden` `P` left join `v_LiqAblussPeriodeEUR` `EUR` on(((`EUR`.`Jahr` = `P`.`PPPerioden_Jahr`) and (`EUR`.`Monat` = `P`.`PPPerioden_Monat`)))) left join `v_LiqAblussPeriodeUSD` `USD` on(((`USD`.`Jahr` = `P`.`PPPerioden_Jahr`) and (`USD`.`Monat` = `P`.`PPPerioden_Monat`))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqAblussPeriodeEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqAblussPeriodeEUR` AS select year((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)) AS `Jahr`,month((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)) AS `Monat`,sum(`v_Liquiditaet`.`EKGesamt`) AS `Abfluss` from `v_Liquiditaet` where (`v_Liquiditaet`.`EKWaehrung` = 'EUR') group by year((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)),month((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)),`v_Liquiditaet`.`EKWaehrung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqAblussPeriodeUSD`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqAblussPeriodeUSD` AS select year((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)) AS `Jahr`,month((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)) AS `Monat`,sum(`v_Liquiditaet`.`EKGesamt`) AS `Abfluss` from `v_Liquiditaet` where (`v_Liquiditaet`.`EKWaehrung` = 'USD') group by year((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)),month((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)),`v_Liquiditaet`.`EKWaehrung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqLCE`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqLCE` AS select sum(`v_Liquiditaet`.`EKGesamt`) AS `EKSumme`,`v_Liquiditaet`.`EKWaehrung` AS `EKWaehrung`,year(`v_Liquiditaet`.`LCEroeffnung`) AS `LCJahr`,month(`v_Liquiditaet`.`LCEroeffnung`) AS `LCMonat` from `v_Liquiditaet` where ((`v_Liquiditaet`.`LC` is not null) and (trim(`v_Liquiditaet`.`LC`) <> '')) group by `v_Liquiditaet`.`EKWaehrung`,year(`v_Liquiditaet`.`LCEroeffnung`),month(`v_Liquiditaet`.`LCEroeffnung`);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqLCNNE`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqLCNNE` AS select sum(`v_Liquiditaet`.`EKGesamt`) AS `EKSumme`,`v_Liquiditaet`.`EKWaehrung` AS `EKWaehrung`,year((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)) AS `YearLCNNE`,month((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)) AS `MonthLCNNE` from `v_Liquiditaet` where ((`v_Liquiditaet`.`LC` is null) or (trim(`v_Liquiditaet`.`LC`) = '')) group by `v_Liquiditaet`.`EKWaehrung`,year((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day)),month((`v_Liquiditaet`.`LTDate` + interval `v_Liquiditaet`.`TTTage` day));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqLCuebersichtPeriodenEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqLCuebersichtPeriodenEUR` AS select `P`.`PPPerioden_Jahr` AS `Jahr`,`P`.`PPPerioden_Monat` AS `Monat`,`LCE`.`EKSumme` AS `EKSummeE`,`LCNNE`.`EKSumme` AS `EKSummeNNE`,'EUR' AS `Waehrung` from ((`PPPerioden` `P` left join `v_LiqLCE` `LCE` on(((`LCE`.`LCJahr` = `P`.`PPPerioden_Jahr`) and (`LCE`.`LCMonat` = `P`.`PPPerioden_Monat`) and (`LCE`.`EKWaehrung` = 'EUR')))) left join `v_LiqLCNNE` `LCNNE` on(((`LCNNE`.`YearLCNNE` = `P`.`PPPerioden_Jahr`) and (`LCNNE`.`MonthLCNNE` = `P`.`PPPerioden_Monat`) and (`LCNNE`.`EKWaehrung` = 'EUR'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqLCuebersichtPeriodenUSD`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqLCuebersichtPeriodenUSD` AS select `P`.`PPPerioden_Jahr` AS `Jahr`,`P`.`PPPerioden_Monat` AS `Monat`,`LCE`.`EKSumme` AS `EKSummeE`,`LCNNE`.`EKSumme` AS `EKSummeNNE`,'USD' AS `Waehrung` from ((`PPPerioden` `P` left join `v_LiqLCE` `LCE` on(((`LCE`.`LCJahr` = `P`.`PPPerioden_Jahr`) and (`LCE`.`LCMonat` = `P`.`PPPerioden_Monat`) and (`LCE`.`EKWaehrung` = 'USD')))) left join `v_LiqLCNNE` `LCNNE` on(((`LCNNE`.`YearLCNNE` = `P`.`PPPerioden_Jahr`) and (`LCNNE`.`MonthLCNNE` = `P`.`PPPerioden_Monat`) and (`LCNNE`.`EKWaehrung` = 'USD'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqLaenderEK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqLaenderEK` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,sum(ifnull(`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`,0)) AS `LaenderMenge`,sum((`PPProduktpass_Menge`.`PPProduktpass_Menge_EKUSD` * `PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`)) AS `LaenderEK`,sum((`PPProduktpass_Menge`.`PPProduktpass_Menge_VKFOBEUR` * `PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`)) AS `LaenderVK` from `PPProduktpass_Menge` group by `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqLaenderEKVK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqLaenderEKVK` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,sum(ifnull(`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`,0)) AS `LaenderMenge`,sum((`PPProduktpass_Menge`.`PPProduktpass_Menge_EKUSD` * `PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`)) AS `LaenderEK`,sum((`PPProduktpass_Menge`.`PPProduktpass_Menge_VKFOBEUR` * `PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`)) AS `LaenderVK` from `PPProduktpass_Menge` group by `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LiqZuflussPeriodeEUR`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LiqZuflussPeriodeEUR` AS select `P`.`PPPerioden_Jahr` AS `PJahr`,`P`.`PPPerioden_Monat` AS `PMonat`,year((`L`.`LTDate` + interval 100 day)) AS `Jahr`,month((`L`.`LTDate` + interval 100 day)) AS `Monat`,sum(`L`.`VKGesamt`) AS `Zufluss` from (`PPPerioden` `P` left join `v_Liquiditaet` `L` on(((`P`.`PPPerioden_Monat` = month((`L`.`LTDate` + interval 100 day))) and (`P`.`PPPerioden_Jahr` = year((`L`.`LTDate` + interval 100 day)))))) group by `P`.`PPPerioden_Jahr`,`P`.`PPPerioden_Monat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Liquiditaet`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Liquiditaet` AS select distinct `PP`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterung`,`PT`.`PPTerms_MC` AS `TOP`,ifnull(`Z`.`PPZahlungen_Id`,'-1') AS `ZId`,ifnull(`Z`.`PPZahlungen_LC`,'') AS `LC`,`Z`.`PPZahlungen_Bemerkung` AS `Bemerkung`,`Z`.`PPZahlungen_Betrag` AS `Betrag`,((`Z`.`PPZahlungen_BezahltAm` + interval 1 day) - interval 1 day) AS `BezahltAm`,`Z`.`PPZahlungen_Nummer` AS `Nummer`,`PO`.`PPPurchase_Supplier` AS `Produzent`,`AD`.`Land` AS `Land`,`PP`.`PPProduktpass_IAN` AS `IAN`,`PP`.`PPProduktpass_ProjektBild` AS `Projektbild`,`PP`.`PPProduktpass_Id` AS `PPId`,`PP`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`PO`.`PPPurchase_EK` AS `EK`,`PO`.`PPPurchase_Currency` AS `EKWaehrung`,`PP`.`PPProduktpass_Gesamtmenge` AS `MengeGesamt`,(`PO`.`PPPurchase_EK` * `PP`.`PPProduktpass_Gesamtmenge`) AS `EKGesamt`,`LEKVK`.`LaenderEK` AS `LaenderEKGesamt`,`LEKVK`.`LaenderVK` AS `LaenderVKGesamt`,concat(`PO`.`PPPurchase_FOBYear`,`PO`.`PPPurchase_FOBWeek`) AS `LT`,str_to_date(concat(concat(`PO`.`PPPurchase_FOBYear`,`PO`.`PPPurchase_FOBWeek`),' Monday'),'%Y%u %W') AS `LTDate`,`PO`.`PPPurchase_PPProduktpass_Id` AS `PPProduktpass_Id`,`PO`.`PPPurchase_ExcR_Calc` AS `KursKalkuliert`,`PO`.`PPPurchase_ExcR_Save` AS `KursGesichert`,`PO`.`PPPurchase_ExcR_Save_Date` AS `KursGesichertAm`,`PO`.`PPPurchase_LC_TOP` AS `Zahlungsziel`,`Z`.`PPZahlungen_BezahltBemerkung` AS `BezahltBemerkung`,`Z`.`PPZahlungen_LCEroeffnung` AS `LCEroeffnung`,`Z`.`PPZahlungen_LCEroeffnungAlternativ` AS `LCEroeffnungAlternativ`,`Z`.`PPZahlungen_Andienung` AS `Andienung`,`Z`.`PPZahlungen_Faelligkeit` AS `FaelligkeitLieferant`,`AB`.`PPAB_VKEUR` AS `VKinEUR`,(`AB`.`PPAB_VKEUR` * `PP`.`PPProduktpass_Gesamtmenge`) AS `VKGesamt`,((`AB`.`PPAB_VKEUR` * `PP`.`PPProduktpass_Gesamtmenge`) - (`PO`.`PPPurchase_EK` * `PP`.`PPProduktpass_Gesamtmenge`)) AS `Rohertrag`,(`Z`.`PPZahlungen_Andienung` + interval 100 day) AS `ZahlungKunde`,(`Z`.`PPZahlungen_Andienung` + interval substr(`PO`.`PPPurchase_LC_TOP`,1,3) day) AS `Faelligkeit`,substr(`PO`.`PPPurchase_LC_TOP`,1,3) AS `TTTage`,`PP`.`PPProduktpass_PPProjekte_Projekt` AS `Projekt` from (((((((`PPProduktpass` `PP` join `PPPurchase` `PO` on((`PP`.`PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) join `v_PurchaseLast` `PL` on((`PO`.`PPPurchase_Id` = `PL`.`PPPurchase_Id`))) left join `PPAdressen` `AD` on((convert(`PO`.`PPPurchase_Supplier` using utf8mb3) = `AD`.`Matchcode`))) join `PPAB` `AB` on((`AB`.`PPAB_PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) left join `PPZahlungen` `Z` on((`Z`.`PPZahlungen_PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) left join `PPTerms` `PT` on((`PO`.`PPPurchase_TermsOfPayment` = `PT`.`PPTerms_Id`))) left join `v_LiqLaenderEKVK` `LEKVK` on((`LEKVK`.`PPProduktpass_Menge_PPProduktpass_Id` = `PP`.`PPProduktpass_Id`))) where (length(`PP`.`PPProduktpass_IAN`) = 6) order by `PO`.`PPPurchase_PPProduktpass_Id` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LotHafenmengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LotHafenmengen` AS select `v_LotLaendermengen`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`v_LotLaendermengen`.`Lot` AS `Lot`,`v_LotLaendermengen`.`Port` AS `Port`,`v_LotLaendermengen`.`SaleUnit` AS `SaleUnit`,sum(`v_LotLaendermengen`.`Quantity`) AS `LotQuantity`,`v_LotLaendermengen`.`LT` AS `LT` from `v_LotLaendermengen` group by `v_LotLaendermengen`.`PPProduktpass_Menge_PPProduktpass_Id`,`v_LotLaendermengen`.`Lot`,`v_LotLaendermengen`.`Port`,`v_LotLaendermengen`.`SaleUnit`,`v_LotLaendermengen`.`LT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_LotLaendermengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_LotLaendermengen` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `Country`,`PPLaenderbloecke`.`PPLaenderbloecke_Hafen1` AS `Port`,`PPProduktpass_Menge`.`PPProduktpass_Menge_TotalSalePerUnit` AS `SaleUnit`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1` AS `LT`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` AS `Quantity`,1 AS `Lot` from (`PPProduktpass_Menge` left join `PPLaenderbloecke` on((`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` = `PPLaenderbloecke`.`PPLaenderbloecke_Land`))) where ((`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` is not null) and (`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` > 0)) union select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`PPLaenderbloecke`.`PPLaenderbloecke_Hafen1` AS `PPLaenderbloecke_Hafen1`,`PPProduktpass_Menge`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2` AS `PPProduktpass_Menge_LT2`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2Menge` AS `PPProduktpass_Menge_LT2Menge`,2 AS `2` from (`PPProduktpass_Menge` left join `PPLaenderbloecke` on((`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` = `PPLaenderbloecke`.`PPLaenderbloecke_Land`))) where ((`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2Menge` is not null) and (`PPProduktpass_Menge`.`PPProduktpass_Menge_LT2Menge` > 0)) union select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country`,`PPLaenderbloecke`.`PPLaenderbloecke_Hafen1` AS `PPLaenderbloecke_Hafen1`,`PPProduktpass_Menge`.`PPProduktpass_Menge_TotalSalePerUnit` AS `PPProduktpass_Menge_TotalSalePerUnit`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3` AS `PPProduktpass_Menge_LT3`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3Menge` AS `PPProduktpass_Menge_LT3Menge`,3 AS `3` from (`PPProduktpass_Menge` left join `PPLaenderbloecke` on((`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` = `PPLaenderbloecke`.`PPLaenderbloecke_Land`))) where ((`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3Menge` is not null) and (`PPProduktpass_Menge`.`PPProduktpass_Menge_LT3Menge` > 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MES`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MES` AS select `v_MengenSpanien`.`PPProduktpass_Menge_PPProduktpass_Id` AS `MES_PPID`,format(`v_MengenSpanien`.`Menge`,0,'de_DE') AS `MES_Total`,format(((`v_MengenSpanien`.`Menge` / `v_AssortOWLsv`.`PPAssortments_totalPackRatio`) * `v_AssortOWLsv`.`PPAssortments_sizevalue`),0,'de_DE') AS `MES_StyleMenge`,format((((`v_MengenSpanien`.`Menge` / `v_AssortOWLsv`.`PPAssortments_totalPackRatio`) * `v_AssortOWLsv`.`PPAssortments_sizevalue`) * `v_AssortOWLsv`.`PPOrderWeights_weight`),2,'de_DE') AS `MES_StyleGewicht`,`v_AssortOWLsv`.`PPAssortments_styleNo` AS `MES_StyleNo`,`v_AssortOWLsv`.`PPAssortments_totalPackRatio` AS `MES_KI`,replace(`v_AssortOWLsv`.`PPAssortments_productName`,'\n','') AS `MES_StyleBezeichung`,`v_AssortOWLsv`.`PPAssortments_sizevalue` AS `MES_SortMenge`,`v_AssortOWLsv`.`PPOrderWeights_gtin` AS `MES_GTINLidl`,`v_AssortOWLsv`.`PPOrderWeights_gtinKL` AS `MES_GTINKL`,format(`v_AssortOWLsv`.`PPOrderWeights_weight`,3,'de_DE') AS `MES_Gewicht`,`v_AssortOWLsv`.`PPOrderWeights_unit` AS `MES_Einheit`,`v_AssortOWLsv`.`PPOrderWeights_lsv` AS `MES_LSVCode`,`v_AssortOWLsv`.`PPLsv_name` AS `MES_LSVName` from (`v_MengenSpanien` join `v_AssortOWLsv` on((`v_MengenSpanien`.`PPProduktpass_Menge_PPProduktpass_Id` = `v_AssortOWLsv`.`PPOrderWeights_PPProduktpass_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MESOLsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MESOLsv` AS select `v_MengenSpanien`.`PPProduktpass_Menge_PPProduktpass_Id` AS `MES_PPID`,format(`v_MengenSpanien`.`Menge`,0,'de_DE') AS `MES_Total`,format(((`v_MengenSpanien`.`Menge` / `v_AssortOWLsvOLsv`.`PPAssortments_totalPackRatio`) * `v_AssortOWLsvOLsv`.`PPAssortments_sizevalue`),0,'de_DE') AS `MES_StyleMenge`,format((((`v_MengenSpanien`.`Menge` / `v_AssortOWLsvOLsv`.`PPAssortments_totalPackRatio`) * `v_AssortOWLsvOLsv`.`PPAssortments_sizevalue`) * `v_AssortOWLsvOLsv`.`PPOrderWeights_weight`),2,'de_DE') AS `MES_StyleGewicht`,`v_AssortOWLsvOLsv`.`PPAssortments_styleNo` AS `MES_StyleNo`,`v_AssortOWLsvOLsv`.`PPAssortments_totalPackRatio` AS `MES_KI`,replace(`v_AssortOWLsvOLsv`.`PPAssortments_productName`,'\n','') AS `MES_StyleBezeichung`,`v_AssortOWLsvOLsv`.`PPAssortments_sizevalue` AS `MES_SortMenge`,`v_AssortOWLsvOLsv`.`PPOrderWeights_gtin` AS `MES_GTINLidl`,`v_AssortOWLsvOLsv`.`PPOrderWeights_gtinKL` AS `MES_GTINKL`,format(`v_AssortOWLsvOLsv`.`PPOrderWeights_weight`,3,'de_DE') AS `MES_Gewicht`,`v_AssortOWLsvOLsv`.`PPOrderWeights_unit` AS `MES_Einheit`,`v_AssortOWLsvOLsv`.`PPOrderWeights_lsv` AS `MES_LSVCode`,`v_AssortOWLsvOLsv`.`PPLsv_name` AS `MES_LSVName` from (`v_MengenSpanien` join `v_AssortOWLsvOLsv` on((`v_MengenSpanien`.`PPProduktpass_Menge_PPProduktpass_Id` = `v_AssortOWLsvOLsv`.`PPOrderWeights_PPProduktpass_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MESPP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MESPP` AS select `tPPProduktpass`.`InternerStatus` AS `MES_Status`,`tPPProduktpass`.`PPProduktpass_IAN` AS `MES_IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `MES_Charge`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `MES_Artikel`,`v_MESTotal`.`MES_KI` AS `MES_KI`,`v_MESTotal`.`MES_StyleNo` AS `MES_StyleNo`,`v_MESTotal`.`MES_StyleBezeichung` AS `MES_StyleBezeichung`,`v_MESTotal`.`MES_StyleMenge` AS `MES_StyleMenge`,`v_MESTotal`.`MES_StyleGewicht` AS `MES_StyleGewicht`,`v_MESTotal`.`MES_SortMenge` AS `MES_SortMenge`,`v_MESTotal`.`MES_GTINLidl` AS `MES_GTINLidl`,`v_MESTotal`.`MES_GTINKL` AS `MES_GTINKL`,`v_MESTotal`.`MES_Gewicht` AS `MES_Gewicht`,`v_MESTotal`.`MES_Einheit` AS `MES_Einheit`,`v_MESTotal`.`MES_LSVCode` AS `MES_LSVCode`,`v_MESTotal`.`MES_LSVName` AS `MES_LSVName` from (`tPPProduktpass` left join `v_MESTotal` on((`v_MESTotal`.`MES_PPID` = `tPPProduktpass`.`PPProduktpass_Id`))) where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))) and (`tPPProduktpass`.`InternerStatus` in ('FIX','GELIEFERT')) and (not((`tPPProduktpass`.`PPProduktpass_IAN` like '999%'))) and (`v_MESTotal`.`MES_StyleNo` is not null)) order by `tPPProduktpass`.`InternerStatus`,`tPPProduktpass`.`PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer`,`v_MESTotal`.`MES_StyleNo`,`v_MESTotal`.`MES_LSVCode`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MESTotal`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MESTotal` AS select `v_MES`.`MES_PPID` AS `MES_PPID`,`v_MES`.`MES_Total` AS `MES_Total`,`v_MES`.`MES_StyleMenge` AS `MES_StyleMenge`,`v_MES`.`MES_StyleGewicht` AS `MES_StyleGewicht`,`v_MES`.`MES_StyleNo` AS `MES_StyleNo`,`v_MES`.`MES_KI` AS `MES_KI`,`v_MES`.`MES_StyleBezeichung` AS `MES_StyleBezeichung`,`v_MES`.`MES_SortMenge` AS `MES_SortMenge`,`v_MES`.`MES_GTINLidl` AS `MES_GTINLidl`,`v_MES`.`MES_GTINKL` AS `MES_GTINKL`,`v_MES`.`MES_Gewicht` AS `MES_Gewicht`,`v_MES`.`MES_Einheit` AS `MES_Einheit`,`v_MES`.`MES_LSVCode` AS `MES_LSVCode`,`v_MES`.`MES_LSVName` AS `MES_LSVName` from `v_MES` where (`v_MES`.`MES_Total` > 0) union select `v_MESOLsv`.`MES_PPID` AS `MES_PPID`,`v_MESOLsv`.`MES_Total` AS `MES_Total`,`v_MESOLsv`.`MES_StyleMenge` AS `MES_StyleMenge`,`v_MESOLsv`.`MES_StyleGewicht` AS `MES_StyleGewicht`,`v_MESOLsv`.`MES_StyleNo` AS `MES_StyleNo`,`v_MESOLsv`.`MES_KI` AS `MES_KI`,`v_MESOLsv`.`MES_StyleBezeichung` AS `MES_StyleBezeichung`,`v_MESOLsv`.`MES_SortMenge` AS `MES_SortMenge`,`v_MESOLsv`.`MES_GTINLidl` AS `MES_GTINLidl`,`v_MESOLsv`.`MES_GTINKL` AS `MES_GTINKL`,`v_MESOLsv`.`MES_Gewicht` AS `MES_Gewicht`,`v_MESOLsv`.`MES_Einheit` AS `MES_Einheit`,`v_MESOLsv`.`MES_LSVCode` AS `MES_LSVCode`,`v_MESOLsv`.`MES_LSVName` AS `MES_LSVName` from `v_MESOLsv` where (`v_MESOLsv`.`MES_Total` > 0);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MengenSpanien`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MengenSpanien` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPProduktpass_Menge_PPProduktpass_Id`,'ES' AS `ES`,sum(`PPProduktpass_Menge`.`PPProduktpass_Menge_Quantity`) AS `Menge` from `PPProduktpass_Menge` where (`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` like '%ES%') group by `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Milestones`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Milestones` AS select `PPTermine`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`PPBoardSpalteData`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`PPBoardSpalteData`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`PPTermine`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`PPTermine`.`PPTermine_SimDate` AS `PPTermine_SimDate`,`PPBoardSpalteData`.`PPBoardSpalteData_IsExternDate` AS `PPBoardSpalteData_IsExternDate`,`PPTermine`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`PPTermine`.`PPTermine_Status` AS `PPTermine_Status` from (`PPTermine` join `PPBoardSpalteData` on((`PPBoardSpalteData`.`PPBoardSpalte_Id` = `PPTermine`.`PPTermine_PPBoardSpalte_id`))) where (`PPBoardSpalteData`.`PPBoardSpalteData_KMS` > 0);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MilestonesShipmentoverview`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MilestonesShipmentoverview` AS select `PPTermine`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,max((case when (`PPTermine`.`PPTermine_PPBoardSpalte_id` = 1039) then `PPTermine`.`PPTermine_DatumStart` end)) AS `MS_EUG`,max((case when (`PPTermine`.`PPTermine_PPBoardSpalte_id` = 1121) then `PPTermine`.`PPTermine_DatumStart` end)) AS `MS_30PSI`,max((case when (`PPTermine`.`PPTermine_PPBoardSpalte_id` = 1057) then `PPTermine`.`PPTermine_DatumStart` end)) AS `MS_PSI` from `PPTermine` group by `PPTermine`.`PPTermine_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_MitarbeiterProjekt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_MitarbeiterProjekt` AS select distinct `PPTermine`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`PPMitarbeiter`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`PPMitarbeiter`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`PPBoardSpalteX`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id` from ((`PPTermine` join `PPMitarbeiter` on((`PPTermine`.`PPTermine_MAZustaendigkeit` = `PPMitarbeiter`.`PPMitarbeiter_Id`))) join `PPBoardSpalteX` on((`PPBoardSpalteX`.`PPBoardSpalteX_PPBoardSpalte_Id` = `PPTermine`.`PPTermine_PPBoardSpalte_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_OSLieferlaender`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_OSLieferlaender` AS select distinct `PPProduktpass_Menge`.`PPProduktpass_Menge_Country` AS `PPProduktpass_Menge_Country` from `PPProduktpass_Menge` where (`PPProduktpass_Menge`.`PPProduktpass_Menge_Country` like 'OS%');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_OSSortierung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_OSSortierung` AS select 'OSDE' AS `OSLaenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Row` AS `PPProduktpass_Sortierung_Row`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value03` AS `PPProduktpass_Sortierung_Value03`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value04` AS `PPProduktpass_Sortierung_Value04`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value05` AS `PPProduktpass_Sortierung_Value05`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value06` AS `PPProduktpass_Sortierung_Value06`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value07` AS `PPProduktpass_Sortierung_Value07`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value08` AS `PPProduktpass_Sortierung_Value08`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value09` AS `PPProduktpass_Sortierung_Value09`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value10` AS `PPProduktpass_Sortierung_Value10`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeDE` AS `PPProduktpass_Sortierung_OSMengeDE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Translate_Design` AS `PPProduktpass_Sortierung_Translate_Design`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EANOS` AS `PPProduktpass_Sortierung_EANOS`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeBE` AS `PPProduktpass_Sortierung_OSMengeBE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeNL` AS `PPProduktpass_Sortierung_OSMengeNL`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeCZ` AS `PPProduktpass_Sortierung_OSMengeCZ`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeES` AS `PPProduktpass_Sortierung_OSMengeES` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` like '%OSDE%') and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` is not null) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeDE` > 0)) union select 'OSBE' AS `OSLaenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Row` AS `PPProduktpass_Sortierung_Row`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value03` AS `PPProduktpass_Sortierung_Value03`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value04` AS `PPProduktpass_Sortierung_Value04`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value05` AS `PPProduktpass_Sortierung_Value05`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value06` AS `PPProduktpass_Sortierung_Value06`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value07` AS `PPProduktpass_Sortierung_Value07`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value08` AS `PPProduktpass_Sortierung_Value08`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value09` AS `PPProduktpass_Sortierung_Value09`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value10` AS `PPProduktpass_Sortierung_Value10`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeDE` AS `PPProduktpass_Sortierung_OSMengeDE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Translate_Design` AS `PPProduktpass_Sortierung_Translate_Design`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EANOS` AS `PPProduktpass_Sortierung_EANOS`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeBE` AS `PPProduktpass_Sortierung_OSMengeBE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeNL` AS `PPProduktpass_Sortierung_OSMengeNL`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeCZ` AS `PPProduktpass_Sortierung_OSMengeCZ`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeES` AS `PPProduktpass_Sortierung_OSMengeES` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` like '%OSBE%') and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` is not null) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeBE` > 0)) union select 'OSNL' AS `OSLaenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Row` AS `PPProduktpass_Sortierung_Row`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value03` AS `PPProduktpass_Sortierung_Value03`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value04` AS `PPProduktpass_Sortierung_Value04`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value05` AS `PPProduktpass_Sortierung_Value05`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value06` AS `PPProduktpass_Sortierung_Value06`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value07` AS `PPProduktpass_Sortierung_Value07`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value08` AS `PPProduktpass_Sortierung_Value08`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value09` AS `PPProduktpass_Sortierung_Value09`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value10` AS `PPProduktpass_Sortierung_Value10`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeDE` AS `PPProduktpass_Sortierung_OSMengeDE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Translate_Design` AS `PPProduktpass_Sortierung_Translate_Design`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EANOS` AS `PPProduktpass_Sortierung_EANOS`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeBE` AS `PPProduktpass_Sortierung_OSMengeBE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeNL` AS `PPProduktpass_Sortierung_OSMengeNL`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeCZ` AS `PPProduktpass_Sortierung_OSMengeCZ`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeES` AS `PPProduktpass_Sortierung_OSMengeES` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` like '%OSNL%') and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` is not null) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeNL` > 0)) union select 'OSCZ' AS `OSLaenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Row` AS `PPProduktpass_Sortierung_Row`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value03` AS `PPProduktpass_Sortierung_Value03`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value04` AS `PPProduktpass_Sortierung_Value04`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value05` AS `PPProduktpass_Sortierung_Value05`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value06` AS `PPProduktpass_Sortierung_Value06`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value07` AS `PPProduktpass_Sortierung_Value07`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value08` AS `PPProduktpass_Sortierung_Value08`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value09` AS `PPProduktpass_Sortierung_Value09`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value10` AS `PPProduktpass_Sortierung_Value10`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeDE` AS `PPProduktpass_Sortierung_OSMengeDE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Translate_Design` AS `PPProduktpass_Sortierung_Translate_Design`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EANOS` AS `PPProduktpass_Sortierung_EANOS`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeBE` AS `PPProduktpass_Sortierung_OSMengeBE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeNL` AS `PPProduktpass_Sortierung_OSMengeNL`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeCZ` AS `PPProduktpass_Sortierung_OSMengeCZ`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeES` AS `PPProduktpass_Sortierung_OSMengeES` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` like '%OSCZ%') and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` is not null) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeCZ` > 0)) union select 'OSES' AS `OSLaenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Id` AS `PPProduktpass_Sortierung_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Row` AS `PPProduktpass_Sortierung_Row`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value03` AS `PPProduktpass_Sortierung_Value03`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value04` AS `PPProduktpass_Sortierung_Value04`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value05` AS `PPProduktpass_Sortierung_Value05`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value06` AS `PPProduktpass_Sortierung_Value06`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value07` AS `PPProduktpass_Sortierung_Value07`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value08` AS `PPProduktpass_Sortierung_Value08`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value09` AS `PPProduktpass_Sortierung_Value09`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value10` AS `PPProduktpass_Sortierung_Value10`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EAN` AS `PPProduktpass_Sortierung_EAN`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeDE` AS `PPProduktpass_Sortierung_OSMengeDE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Translate_Design` AS `PPProduktpass_Sortierung_Translate_Design`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_EANOS` AS `PPProduktpass_Sortierung_EANOS`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeBE` AS `PPProduktpass_Sortierung_OSMengeBE`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeNL` AS `PPProduktpass_Sortierung_OSMengeNL`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeCZ` AS `PPProduktpass_Sortierung_OSMengeCZ`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeES` AS `PPProduktpass_Sortierung_OSMengeES` from `PPProduktpass_Sortierung` where ((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` like '%OSES%') and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` is not null) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_OSMengeES` > 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_OWLsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_OWLsv` AS select `PPOrderWeights`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`PPOrderWeights`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`PPOrderWeights`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`PPOrderWeights`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`PPOrderWeights`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`PPOrderWeights`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`PPLsv`.`PPLsv_name` AS `PPLsv_name`,`PPLsv`.`PPLsv_countryCodes` AS `PPLsv_countryCodes` from (`PPOrderWeights` join `PPLsv` on(((`PPLsv`.`PPLsv_PPProduktpass_Id` = `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id`) and (`PPLsv`.`PPLsv_code` = `PPOrderWeights`.`PPOrderWeights_lsv`))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_OWLsvOLsv`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_OWLsvOLsv` AS select `PPOrderWeights`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`PPOrderWeights`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`PPOrderWeights`.`PPOrderWeights_styleNo` AS `PPOrderWeights_styleNo`,`PPOrderWeights`.`PPOrderWeights_unit` AS `PPOrderWeights_unit`,`PPOrderWeights`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`PPOrderWeights`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id` AS `PPOrderWeights_PPProduktpass_Id`,`PPLsv`.`PPLsv_name` AS `PPLsv_name`,`PPLsv`.`PPLsv_countryCodes` AS `PPLsv_countryCodes` from (`PPOrderWeights` join `PPLsv` on(((`PPLsv`.`PPLsv_PPProduktpass_Id` = `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id`) and (`PPLsv`.`PPLsv_name` is null))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PO`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PO` AS select `PP`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`PP`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PP`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`PP`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`PO`.`PPPurchase_Currency` AS `PPPurchase_Currency`,`PO`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`PO`.`PPPurchase_EK` AS `PPPurchase_EK`,`PO`.`PPPurchase_LC_TOP` AS `PPPurchase_LC_TOP`,`POVal`.`PO_Wert` AS `PO_Wert`,`PO`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc` from ((`v_PPProduktpassReal` `PP` join `v_PurchaseDistinct` `PO` on((`PP`.`PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) join `v_PurchaseWerte` `POVal` on((`POVal`.`v_PPMengen_PPProduktpass_Id` = `PP`.`PPProduktpass_Id`))) order by `PP`.`PPProduktpass_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_POWertNachMonaten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_POWertNachMonaten` AS select month(str_to_date(concat(`v_POinFW`.`PPProduktpass_LieferterminJahr`,' ',`v_POinFW`.`PPProduktpass_Liefertermin`,'  Monday'),'%x %v %W')) AS `Monat`,`v_POinFW`.`PPProduktpass_LieferterminJahr` AS `Jahr`,`v_POinFW`.`PO_Wert` AS `PO_Wert` from `v_POinFW`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_POWertNachMonatenKummuliert`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_POWertNachMonatenKummuliert` AS select sum(`v_POWertNachMonaten`.`PO_Wert`) AS `EKUsdKum`,`v_POWertNachMonaten`.`Monat` AS `Monat`,`v_POWertNachMonaten`.`Jahr` AS `Jahr` from `v_POWertNachMonaten` group by `v_POWertNachMonaten`.`Monat`,`v_POWertNachMonaten`.`Jahr`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_POinFW`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_POinFW` AS select `PP`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`PP`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`PP`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PP`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`PP`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`PP`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`PO`.`PPPurchase_Currency` AS `PPPurchase_Currency`,`PO`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`PO`.`PPPurchase_EK` AS `PPPurchase_EK`,`POVal`.`PO_Wert` AS `PO_Wert`,`PO`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc` from ((`v_PPProduktpassReal` `PP` join `v_PurchaseDistinct` `PO` on((`PP`.`PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) join `v_PurchaseWerte` `POVal` on((`POVal`.`v_PPMengen_PPProduktpass_Id` = `PP`.`PPProduktpass_Id`))) where (`PO`.`PPPurchase_Currency` <> 'EUR') order by `PP`.`PPProduktpass_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPMengen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPMengen` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `v_PPMengen_PPProduktpass_Id`,`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` AS `v_PPMengen_Menge`,`PPProduktpass_Menge`.`PPProduktpass_Menge_EKUSD` AS `v_PPMengen_EKUSD`,`v_PurchaseDistinct`.`PPPurchase_EK` AS `v_PPMengen_FOB_EK` from (`PPProduktpass_Menge` left join `v_PurchaseDistinct` on((`PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` = `v_PurchaseDistinct`.`PPPurchase_PPProduktpass_Id`))) where ((`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` is not null) and (`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1Menge` > 0));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPPU`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPPU` AS select `PU`.`PPPurchase_Id` AS `PPPurchase_Id`,`PU`.`PPPurchase_PPProduktpass_Id` AS `PPPurchase_PPProduktpass_Id`,`PU`.`PPPurchase_LcNumber` AS `PPPurchase_LcNumber`,`PU`.`PPPurchase_ScNumber` AS `PPPurchase_ScNumber`,`PU`.`PPPurchase_Inquiry` AS `PPPurchase_Inquiry`,`PU`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`PU`.`PPPurchase_Currency` AS `PPPurchase_Currency`,`PU`.`PPPurchase_ExcR` AS `PPPurchase_ExcR`,`PU`.`PPPurchase_ExcR_Date` AS `PPPurchase_ExcR_Date`,`PU`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc`,`PU`.`PPPurchase_ExcR_Remark` AS `PPPurchase_ExcR_Remark`,`PU`.`PPPurchase_CustomsCode` AS `PPPurchase_CustomsCode`,`PU`.`PPPurchase_DutyPercentage` AS `PPPurchase_DutyPercentage`,`PU`.`PPPurchase_DeliveryDate` AS `PPPurchase_DeliveryDate`,`PU`.`PPPurchase_ResOffice` AS `PPPurchase_ResOffice`,`PU`.`PPPurchase_Description` AS `PPPurchase_Description`,`PU`.`PPPurchase_Material` AS `PPPurchase_Material`,`PU`.`PPPurchase_Remark` AS `PPPurchase_Remark`,`PU`.`PPPurchase_TermsOfDelivery` AS `PPPurchase_TermsOfDelivery`,`PU`.`PPPurchase_TermsOfPayment` AS `PPPurchase_TermsOfPayment`,`PU`.`PPPurchase_Status` AS `PPPurchase_Status`,`PU`.`PPPurchase_PortOfDischarge` AS `PPPurchase_PortOfDischarge`,`PU`.`PPPurchase_Country` AS `PPPurchase_Country`,`PU`.`PPPurchase_OrderDate` AS `PPPurchase_OrderDate`,`PU`.`PPPurchase_SupplierDelDate` AS `PPPurchase_SupplierDelDate`,`PU`.`PPPurchase_Factory` AS `PPPurchase_Factory`,`PU`.`PPPurchase_EK_Calc` AS `PPPurchase_EK_Calc`,`PU`.`PPPurchase_EK` AS `PPPurchase_EK`,`PU`.`PPPurchase_Fracht` AS `PPPurchase_Fracht`,`PU`.`PPPurchase_Zoll` AS `PPPurchase_Zoll`,`PU`.`PPPurchase_EKProvision` AS `PPPurchase_EKProvision`,`PU`.`PPPurchase_Ausgangsfrachten` AS `PPPurchase_Ausgangsfrachten`,`PU`.`PPPurchase_Finanzierungskosten` AS `PPPurchase_Finanzierungskosten`,`PU`.`PPPurchase_Lizenzgebuehren` AS `PPPurchase_Lizenzgebuehren`,`PU`.`PPPurchase_Kosten` AS `PPPurchase_Kosten`,`PU`.`PPPurchase_Translate_Quality` AS `PPPurchase_Translate_Quality`,`PU`.`PPPurchase_Translate_Projectdescription` AS `PPPurchase_Translate_Projectdescription`,`PU`.`PPPurchase_Translate_ManufacturingPlant` AS `PPPurchase_Translate_ManufacturingPlant`,`PU`.`PPPurchase_Translate_Packaging` AS `PPPurchase_Translate_Packaging`,`PU`.`PPPurchase_SonstKostenProz` AS `PPPurchase_SonstKostenProz`,`PU`.`PPPurchase_BemerkungAenderungen` AS `PPPurchase_BemerkungAenderungen`,`PU`.`PPPurchase_ManufacturingPlant` AS `PPPurchase_ManufacturingPlant`,`PU`.`PPPurchase_LC_TOP` AS `PPPurchase_LC_TOP`,`PU`.`PPPurchase_Pruefinstitut` AS `PPPurchase_Pruefinstitut`,`PU`.`PPPurchase_Transportdokumente` AS `PPPurchase_Transportdokumente`,`PU`.`PPPurchase_Transportdokumente2` AS `PPPurchase_Transportdokumente2`,`PU`.`PPPurchase_BWGroesse` AS `PPPurchase_BWGroesse`,`PU`.`PPPurchase_FOBWeek` AS `PPPurchase_FOBWeek`,`PU`.`PPPurchase_FOBYear` AS `PPPurchase_FOBYear`,`PU`.`PPPurchase_FOBSpecial` AS `PPPurchase_FOBSpecial`,`PP`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PP`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`PP`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`PP`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`PP`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`PP`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`PP`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`PP`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`PP`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`PP`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`PP`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`PP`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`PP`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`PP`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`PP`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`PP`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`PP`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`PP`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`PP`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`PP`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`PP`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`PP`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`PP`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`PP`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`PP`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`PP`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`PP`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`PP`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`PP`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`PP`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`PP`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`PP`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`PP`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`PP`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`PP`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`PP`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`PP`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`PP`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`PP`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`PP`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`PP`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`PP`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`PP`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`PP`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`PP`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`PP`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`PP`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`PP`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`PP`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`PP`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`PP`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`PP`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`PP`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`PP`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`PP`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`PP`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`PP`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`PP`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`PP`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`PP`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`PP`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`PP`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`PP`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`PP`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`PP`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`PP`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`PP`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`PP`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`PP`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`PP`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`PP`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`PP`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`PP`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`PP`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`PP`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`PP`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`PP`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`PP`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge` from (`PPPurchase` `PU` join `PPProduktpass` `PP` on((`PP`.`PPProduktpass_Id` = `PU`.`PPPurchase_PPProduktpass_Id`))) where ((`PP`.`PPProduktpass_RevisionVon_PPProduktpass_Id` is null) and (`PP`.`PPProduktpass_Ausmusterungnummer` like '%') and (not((`PU`.`PPPurchase_Supplier` like 'N.N.'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPProduktpassReal`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPProduktpassReal` AS select `tPPProduktpass`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`tPPProduktpass`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`tPPProduktpass`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`tPPProduktpass`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`tPPProduktpass`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`tPPProduktpass`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`tPPProduktpass`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`tPPProduktpass`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`tPPProduktpass`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`tPPProduktpass`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`tPPProduktpass`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`tPPProduktpass`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`tPPProduktpass`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`tPPProduktpass`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`tPPProduktpass`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`tPPProduktpass`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`tPPProduktpass`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`tPPProduktpass`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`tPPProduktpass`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`tPPProduktpass`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`tPPProduktpass`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`tPPProduktpass`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`tPPProduktpass`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`tPPProduktpass`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`tPPProduktpass`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`tPPProduktpass`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`tPPProduktpass`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`tPPProduktpass`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`tPPProduktpass`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`tPPProduktpass`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`tPPProduktpass`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`tPPProduktpass`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`tPPProduktpass`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`tPPProduktpass`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`tPPProduktpass`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`tPPProduktpass`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`tPPProduktpass`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`tPPProduktpass`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`tPPProduktpass`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`tPPProduktpass`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`tPPProduktpass`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`tPPProduktpass`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`tPPProduktpass`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`tPPProduktpass`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`tPPProduktpass`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`tPPProduktpass`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`tPPProduktpass`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`tPPProduktpass`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`tPPProduktpass`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`tPPProduktpass`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`tPPProduktpass`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`tPPProduktpass`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`tPPProduktpass`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`tPPProduktpass`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`tPPProduktpass`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`tPPProduktpass`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`tPPProduktpass`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`tPPProduktpass`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`tPPProduktpass`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`tPPProduktpass`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`tPPProduktpass`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`tPPProduktpass`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`tPPProduktpass`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`tPPProduktpass`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`tPPProduktpass`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`tPPProduktpass`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`tPPProduktpass`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`tPPProduktpass`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`tPPProduktpass`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`tPPProduktpass`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`tPPProduktpass`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`tPPProduktpass`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`tPPProduktpass`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`tPPProduktpass`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`tPPProduktpass`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`tPPProduktpass`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`tPPProduktpass`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`tPPProduktpass`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`tPPProduktpass`.`category` AS `category`,`tPPProduktpass`.`statusDoc` AS `statusDoc`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus`,`tPPProduktpass`.`updatedOn` AS `updatedOn`,`tPPProduktpass`.`createdOn` AS `createdOn`,`tPPProduktpass`.`PPProduktpass_IsParent` AS `PPProduktpass_IsParent`,`tPPProduktpass`.`PPProduktpass_IsChild` AS `PPProduktpass_IsChild`,`tPPProduktpass`.`PPProduktpass_IsKaufland` AS `PPProduktpass_IsKaufland`,`tPPProduktpass`.`PPProduktpass_IsUSA` AS `PPProduktpass_IsUSA`,`tPPProduktpass`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`tPPProduktpass`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`tPPProduktpass`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`tPPProduktpass`.`PPProduktpass_Transferd2Sharepoint` AS `PPProduktpass_Transferd2Sharepoint`,`tPPProduktpass`.`PPProduktpass_SimNeu` AS `PPProduktpass_SimNeu`,`tPPProduktpass`.`PPProduktpass_ThemaScope` AS `PPProduktpass_ThemaScope`,`tPPProduktpass`.`PPProduktpass_IsCriticalProject` AS `PPProduktpass_IsCriticalProject`,`tPPProduktpass`.`PPProduktpass_linkedItemIan` AS `PPProduktpass_linkedItemIan`,`tPPProduktpass`.`PPProduktpass_linkedItemLotNo` AS `PPProduktpass_linkedItemLotNo`,`tPPProduktpass`.`PPProduktpass_PJMAdmin` AS `PPProduktpass_PJMAdmin`,`tPPProduktpass`.`PPProduktpass_PJMAdminVTR` AS `PPProduktpass_PJMAdminVTR`,`tPPProduktpass`.`PPProduktpass_ARTAdmin` AS `PPProduktpass_ARTAdmin`,`tPPProduktpass`.`PPProduktpass_ARTAdminVTR` AS `PPProduktpass_ARTAdminVTR` from `tPPProduktpass` where (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPProduktpass_PPTermine`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPProduktpass_PPTermine` AS select distinct if((`T`.`PPTermine_DatumStart` = '0000-00-00'),if((if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0) = 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval `SD`.`PPBoardSpalte_Rot` week),'%Y-%m-%d'),if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0)),`T`.`PPTermine_DatumStart`) AS `Datesort`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`P`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`P`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`P`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`P`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`P`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`P`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`P`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`P`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`P`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`P`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`P`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`P`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`P`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`P`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`P`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`P`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`P`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`P`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`P`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`P`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`P`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`P`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`P`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`P`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`P`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`P`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`P`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`P`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`P`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`P`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`P`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`P`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`P`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`P`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`P`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`P`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`P`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`P`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`P`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`P`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`P`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`P`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`P`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`P`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`P`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`P`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`P`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`P`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`P`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`P`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`P`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`P`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`P`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`P`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`P`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`P`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`P`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`P`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`P`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`P`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`P`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`P`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`P`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`P`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`P`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`P`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`P`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`P`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`P`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`P`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`P`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`P`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`P`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`P`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`P`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`P`.`createdOn` AS `createdOn`,`P`.`updatedOn` AS `updatedOn`,`P`.`category` AS `category`,`P`.`statusDoc` AS `statusDoc`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPTermine_Header` AS `PPTermine_Header`,`T`.`PPTermine_Art` AS `PPTermine_Art`,`T`.`PPTermine_Typ` AS `PPTermine_Typ`,`T`.`PPTermine_MAAnlage` AS `PPTermine_MAAnlage`,`T`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`T`.`PPTermine_Status` AS `PPTermine_Status`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`PPTermine_History` AS `PPTermine_History`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`PPStati`.`PPStati_Id` AS `PPStati_Id`,`PPStati`.`PPStati_Status` AS `PPStati_Status`,`PPStati`.`PPStati_Color` AS `PPStati_Color`,`PPStati`.`PPStati_Background` AS `PPStati_Background`,`PPStati`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`PM`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`SD`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`SD`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`SD`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`SD`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`SD`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`SD`.`PPBoardSpalte_IsUSA` AS `PPBoardSpalte_IsUSA`,`PO`.`PPPurchase_FOBYear` AS `PPPurchase_FOBYear`,`PO`.`PPPurchase_FOBWeek` AS `PPPurchase_FOBWeek`,`PO`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`BSX`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`SD`.`PPBoardSpalte_IsMilestone` AS `PPBoardSpalte_IsMilestone`,`P`.`PPProduktpass_IsParent` AS `PPProduktpass_IsParent`,`P`.`PPProduktpass_IsChild` AS `PPProduktpass_IsChild`,`P`.`PPProduktpass_IsKaufland` AS `PPProduktpass_IsKaufland`,`P`.`PPProduktpass_IsUSA` AS `PPProduktpass_IsUSA`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`PM`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`P`.`PPProduktpass_Transferd2Sharepoint` AS `PPProduktpass_Transferd2Sharepoint`,`P`.`PPProduktpass_PJMAdmin` AS `PPProduktpass_PJMAdmin`,`P`.`PPProduktpass_PJMAdminVTR` AS `PPProduktpass_PJMAdminVTR`,`SD`.`PPBoardSpalteData_Kind` AS `PPBoardspalteData_Kind`,`T`.`PPTermine_HistoryEN` AS `PPTermine_HistoryEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_IsMPlan` AS `PPTermine_IsMPlan`,`P`.`PPProduktpass_ARTAdmin` AS `PPProduktpass_ARTAdmin`,`P`.`PPProduktpass_ARTAdminVTR` AS `PPProduktpass_ARTAdminVTR` from ((((((`v_PPProduktpassReal` `P` join `PPPurchase` `PO` on((`P`.`PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `T`.`PPTermine_MAZustaendigkeit`))) join `PPStati` on((`T`.`PPTermine_Status` = `PPStati`.`PPStati_Status`))) join `PPBoardSpalteData` `SD` on((`SD`.`PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`))) join `PPBoardSpalteX` `BSX` on((`BSX`.`PPBoardSpalteX_PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPProduktpass_PPTermine2`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPProduktpass_PPTermine2` AS select distinct if((`T`.`PPTermine_DatumStart` = '0000-00-00'),if((if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0) = 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval `T`.`PPBoardSpalte_Rot` week),'%Y-%m-%d'),if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0)),`T`.`PPTermine_DatumStart`) AS `Datesort`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`P`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`P`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`P`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`P`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`P`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`P`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`P`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`P`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`P`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`P`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`P`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`P`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`P`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`P`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`P`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`P`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`P`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`P`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`P`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`P`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`P`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`P`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`P`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`P`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`P`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`P`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`P`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`P`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`P`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`P`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`P`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`P`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`P`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`P`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`P`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`P`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`P`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`P`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`P`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`P`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`P`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`P`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`P`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`P`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`P`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`P`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`P`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`P`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`P`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`P`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`P`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`P`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`P`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`P`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`P`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`P`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`P`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`P`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`P`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`P`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`P`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`P`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`P`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`P`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`P`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`P`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`P`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`P`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`P`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`P`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`P`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`P`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`P`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`P`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`P`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`P`.`createdOn` AS `createdOn`,`P`.`updatedOn` AS `updatedOn`,`P`.`category` AS `category`,`P`.`statusDoc` AS `statusDoc`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPTermine_Header` AS `PPTermine_Header`,`T`.`PPTermine_Art` AS `PPTermine_Art`,`T`.`PPTermine_Typ` AS `PPTermine_Typ`,`T`.`PPTermine_MAAnlage` AS `PPTermine_MAAnlage`,`T`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`T`.`PPTermine_Status` AS `PPTermine_Status`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`PPTermine_History` AS `PPTermine_History`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`T`.`PPStati_Id` AS `PPStati_Id`,`T`.`PPStati_Status` AS `PPStati_Status`,`T`.`PPStati_Color` AS `PPStati_Color`,`T`.`PPStati_Background` AS `PPStati_Background`,`T`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`T`.`PPBoardSpalte_IsUSA` AS `PPBoardSpalte_IsUSA`,`PO`.`PPPurchase_FOBYear` AS `PPPurchase_FOBYear`,`PO`.`PPPurchase_FOBWeek` AS `PPPurchase_FOBWeek`,`PO`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`T`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`T`.`PPBoardSpalte_IsMilestone` AS `PPBoardSpalte_IsMilestone`,`P`.`PPProduktpass_IsParent` AS `PPProduktpass_IsParent`,`P`.`PPProduktpass_IsChild` AS `PPProduktpass_IsChild`,`P`.`PPProduktpass_IsKaufland` AS `PPProduktpass_IsKaufland`,`P`.`PPProduktpass_IsUSA` AS `PPProduktpass_IsUSA`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`T`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`P`.`PPProduktpass_Transferd2Sharepoint` AS `PPProduktpass_Transferd2Sharepoint` from ((`tPPProduktpass` `P` join `PPPurchase` `PO` on((`P`.`PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) join `v_TermineAll` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%rev%'))) and (`T`.`PPBoardSpalte_PPBoard_Id` >= 1000));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPProduktpass_PPTermineZ1`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPProduktpass_PPTermineZ1` AS select distinct if((`T`.`PPTermine_DatumStart` = '0000-00-00'),if((if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0) = 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval `SD`.`PPBoardSpalte_Rot` week),'%Y-%m-%d'),if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%V %X %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0)),`T`.`PPTermine_DatumStart`) AS `Datesort`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`P`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`P`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`P`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`P`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`P`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`P`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`P`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`P`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`P`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`P`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`P`.`PPProduktpass_StepNeeded` AS `PPProduktpass_StepNeeded`,`P`.`PPProduktpass_BSCINeeded` AS `PPProduktpass_BSCINeeded`,`P`.`PPProduktpass_IsMusterung` AS `PPProduktpass_IsMusterung`,`P`.`updatedOn` AS `updatedOn`,`P`.`category` AS `category`,`P`.`statusDoc` AS `statusDoc`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPTermine_Header` AS `PPTermine_Header`,`T`.`PPTermine_Art` AS `PPTermine_Art`,`T`.`PPTermine_Typ` AS `PPTermine_Typ`,`T`.`PPTermine_MAAnlage` AS `PPTermine_MAAnlage`,`T`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`T`.`PPTermine_Status` AS `PPTermine_Status`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`PPTermine_History` AS `PPTermine_History`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`PPStati`.`PPStati_Id` AS `PPStati_Id`,`PPStati`.`PPStati_Status` AS `PPStati_Status`,`PPStati`.`PPStati_Color` AS `PPStati_Color`,`PPStati`.`PPStati_Background` AS `PPStati_Background`,`PPStati`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`PM`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`SD`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`SD`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`SD`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`SD`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`SD`.`PPBoardSpalte_IsUSA` AS `PPBoardSpalte_IsUSA`,0 AS `PPPurchase_FOBYear`,0 AS `PPPurchase_FOBWeek`,0 AS `PPPurchase_Supplier`,`SD`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`SD`.`PPBoardSpalte_IsMilestone` AS `PPBoardSpalte_IsMilestone`,`P`.`PPProduktpass_IsParent` AS `PPProduktpass_IsParent`,`P`.`PPProduktpass_IsChild` AS `PPProduktpass_IsChild`,`P`.`PPProduktpass_IsKaufland` AS `PPProduktpass_IsKaufland`,`P`.`PPProduktpass_IsUSA` AS `PPProduktpass_IsUSA`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_ArtikelTarga` AS `PPProduktpass_ArtikelTarga`,`PM`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`P`.`PPProduktpass_Transferd2Sharepoint` AS `PPProduktpass_Transferd2Sharepoint`,`P`.`PPProduktpass_SimNeu` AS `PPProduktpass_SimNeu`,`P`.`PPProduktpass_ThemaScope` AS `PPProduktpass_ThemaScope`,`P`.`PPProduktpass_IsCriticalProject` AS `PPProduktpass_IsCriticalProject`,`P`.`PPProduktpass_linkedItemIan` AS `PPProduktpass_linkedItemIAN`,`P`.`PPProduktpass_linkedItemLotNo` AS `PPProduktpass_linkedItemLotNo`,`P`.`PPProduktpass_PJMAdmin` AS `PPProduktpass_PJMAdmin`,`P`.`PPProduktpass_PJMAdminVTR` AS `PPProduktpass_PJMAdminVTR`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_HistoryEN` AS `PPTermine_HistoryEN` from ((((`v_PPProduktpassReal` `P` join `PPTermine` `T` on((`T`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `T`.`PPTermine_MAZustaendigkeit`))) join `PPStati` on((`T`.`PPTermine_Status` = `PPStati`.`PPStati_Status`))) join `v_TerminSpalten` `SD` on((`SD`.`PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPStyleHeader`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPStyleHeader` AS select `PPProduktpass_Style`.`PPProduktpass_Style_PPProduktpass_Id` AS `PPProduktpass_Style_PPProduktpass_Id`,group_concat(`PPProduktpass_Style`.`PPProduktpass_Style_Header` order by `PPProduktpass_Style`.`PPProduktpass_Style_Header` ASC separator ',') AS `Header`,`PPProduktpass_Style`.`PPProduktpass_Style_Value02` AS `Style` from `PPProduktpass_Style` where (`PPProduktpass_Style`.`PPProduktpass_Style_Header` is not null) group by `PPProduktpass_Style`.`PPProduktpass_Style_PPProduktpass_Id`,`PPProduktpass_Style`.`PPProduktpass_Style_Value02`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPTCKosten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPTCKosten` AS select `K`.`PPTCKosten_Id` AS `PPTCKosten_Id`,`K`.`PPTCKosten_Number` AS `PPTCKosten_Number`,`K`.`PPTCKosten_PPProduktpass_Id` AS `PPTCKosten_PPProduktpass_Id`,`K`.`PPTCKosten_PPKostenTypen_Id` AS `PPTCKosten_PPKostenTypen_Id`,`K`.`PPTCKosten_PrototypeAnzahl` AS `PPTCKosten_PrototypeAnzahl`,`K`.`PPTCKosten_TrialRunAnzahl` AS `PPTCKosten_TrialRunAnzahl`,`K`.`PPTCKosten_MPAnzahl` AS `PPTCKosten_MPAnzahl`,`K`.`PPTCKosten_Einzelkosten` AS `PPTCKosten_Einzelkosten`,`K`.`PPTCKosten_Bemerkung` AS `PPTCKosten_Bemerkung`,`K`.`PPTCKosten_Bezeichnung` AS `PPTCKosten_Bezeichnung`,`T`.`PPTCKostenTypen_Id` AS `PPTCKostenTypen_Id`,`T`.`PPTCKostenTypen_Bezeichnung` AS `PPTCKostenTypen_Bezeichnung`,`T`.`PPTCKostenTypen_StandardKosten` AS `PPTCKostenTypen_StandardKosten` from (`PPTCKosten` `K` join `PPTCKostenTypen` `T` on((`T`.`PPTCKostenTypen_Id` = `K`.`PPTCKosten_PPKostenTypen_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPTerminePopUp`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPTerminePopUp` AS select `A`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`A`.`PPTermine_Id` AS `PPTermine_Id`,`B`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`B`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`B`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`B`.`PPBoardSpalteX_Sort` AS `PPBoardSpalteX_Sort`,`B`.`PPBoardSpalteData_Kind` AS `PPBoardSpalteData_Kind` from (`PPTermine` `A` join `PPBoardSpalte` `B` on((`A`.`PPTermine_PPBoardSpalte_id` = `B`.`PPBoardSpalte_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PPUebersicht`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PPUebersicht` AS select `PP`.`PPProduktpass_Ausmusterungnummer` AS `Ausmusterungnummer`,`PP`.`PPProduktpass_IAN` AS `IAN`,`PP`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PP`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`PP`.`PPProduktpass_Liefertermin` AS `LieferterminWoche`,`PP`.`PPProduktpass_LieferterminJahr` AS `LieferterminJahr`,`PO`.`PPPurchase_Currency` AS `EKWaehrung`,`PO`.`PPPurchase_Supplier` AS `Supplier`,`PO`.`PPPurchase_EK` AS `EK`,`POVal`.`PO_Wert` AS `PO_Wert`,`PP`.`PPProduktpass_ProjektBild` AS `ProjektBild` from ((`v_PPProduktpassReal` `PP` left join `v_PurchaseDistinct` `PO` on((`PP`.`PPProduktpass_Id` = `PO`.`PPPurchase_PPProduktpass_Id`))) left join `v_PurchaseWerte` `POVal` on((`POVal`.`v_PPMengen_PPProduktpass_Id` = `PP`.`PPProduktpass_Id`))) order by `PP`.`PPProduktpass_IAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PreisgruppenHafen`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PreisgruppenHafen` AS select `PPHaefen`.`PPHaefen_Id` AS `PPHaefen_Id`,`PPHaefen`.`PPHaefen_Nr` AS `PPHaefen_Nr`,`PPHaefen`.`PPHaefen_Name` AS `PPHaefen_Name`,`PPHaefen`.`PPHaefen_PreisGruppe` AS `PPHaefen_PreisGruppe`,`PPAbgangshafen`.`PPAbgangshafen_Id` AS `PPAbgangshafen_Id`,`PPAbgangshafen`.`PPAbgangshafen_Hafen` AS `PPAbgangshafen_Hafen` from (`PPAbgangshafen` left join `PPHaefen` on((`PPHaefen`.`PPHaefen_Name` = `PPAbgangshafen`.`PPAbgangshafen_Hafen`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ProjekteIan`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ProjekteIan` AS select `tPPProduktpass`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`tPPProduktpass`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt` from `tPPProduktpass`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PurchaseDistinct`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PurchaseDistinct` AS select distinct `PPPurchase`.`PPPurchase_PPProduktpass_Id` AS `PPPurchase_PPProduktpass_Id`,`PPPurchase`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`PPPurchase`.`PPPurchase_Currency` AS `PPPurchase_Currency`,`PPPurchase`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc`,`PPPurchase`.`PPPurchase_EK` AS `PPPurchase_EK`,`PPPurchase`.`PPPurchase_LC_TOP` AS `PPPurchase_LC_TOP` from `PPPurchase` where ((`PPPurchase`.`PPPurchase_Supplier` <> '') and (`PPPurchase`.`PPPurchase_EK` <> 0)) order by `PPPurchase`.`PPPurchase_PPProduktpass_Id` desc;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PurchaseLast`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PurchaseLast` AS select max(`PPPurchase`.`PPPurchase_Id`) AS `PPPurchase_Id`,`PPPurchase`.`PPPurchase_PPProduktpass_Id` AS `PPPurchase_PPProduktpass_Id` from `PPPurchase` group by `PPPurchase`.`PPPurchase_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_PurchaseWerte`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_PurchaseWerte` AS select `v_PPMengen`.`v_PPMengen_PPProduktpass_Id` AS `v_PPMengen_PPProduktpass_Id`,sum((`v_PPMengen`.`v_PPMengen_Menge` * `v_PPMengen`.`v_PPMengen_FOB_EK`)) AS `PO_Wert` from `v_PPMengen` group by `v_PPMengen`.`v_PPMengen_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_QM4Inquiry`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_QM4Inquiry` AS select `PPInquiry`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`PPInquiry`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`PPInquiry`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`PPInquiry`.`PPProduktpass_Ausmusterung` AS `PPProduktpass_Ausmusterung`,`PPInquiry`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`PPInquiry`.`PPProduktpass_AltIAN` AS `PPProduktpass_AltIAN`,`PPInquiry`.`PPProduktpass_AltArtikelbezeichnung` AS `PPProduktpass_AltArtikelbezeichnung`,`PPInquiry`.`PPProduktpass_Warengruppe` AS `PPProduktpass_Warengruppe`,`PPInquiry`.`PPProduktpass_Neu_Warengruppe` AS `PPProduktpass_Neu_Warengruppe`,`PPInquiry`.`PPProduktpass_Verpackungseinheit` AS `PPProduktpass_Verpackungseinheit`,`PPInquiry`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`PPInquiry`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`PPInquiry`.`PPProduktpass_Einkaeufer` AS `PPProduktpass_Einkaeufer`,`PPInquiry`.`PPProduktpass_Marke` AS `PPProduktpass_Marke`,`PPInquiry`.`PPProduktpass_Gesamtmenge` AS `PPProduktpass_Gesamtmenge`,`PPInquiry`.`PPProduktpass_Pruefinstitut` AS `PPProduktpass_Pruefinstitut`,`PPInquiry`.`PPProduktpass_Andere_Kriterien` AS `PPProduktpass_Andere_Kriterien`,`PPInquiry`.`PPProduktpass_Zertifizierungen` AS `PPProduktpass_Zertifizierungen`,`PPInquiry`.`PPProduktpass_Logos` AS `PPProduktpass_Logos`,`PPInquiry`.`PPProduktpass_Verkaufsverpackung` AS `PPProduktpass_Verkaufsverpackung`,`PPInquiry`.`PPProduktpass_Materialstaerke_der_Verkaufsverpackung` AS `PPProduktpass_Materialstaerke_der_Verkaufsverpackung`,`PPInquiry`.`PPProduktpass_Agentur` AS `PPProduktpass_Agentur`,`PPInquiry`.`PPProduktpass_PPProjekte_Id` AS `PPProduktpass_PPProjekte_Id`,`PPInquiry`.`PPProduktpass_Material` AS `PPProduktpass_Material`,`PPInquiry`.`PPProduktpass_Lizenz` AS `PPProduktpass_Lizenz`,`PPInquiry`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`PPInquiry`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`PPInquiry`.`PPProduktpass_AktExcel` AS `PPProduktpass_AktExcel`,`PPInquiry`.`PPProduktpass_VorExcel` AS `PPProduktpass_VorExcel`,`PPInquiry`.`PPProduktpass_Importart` AS `PPProduktpass_Importart`,`PPInquiry`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`PPInquiry`.`PPProduktpass_VorIAN` AS `PPProduktpass_VorIAN`,`PPInquiry`.`PPProduktpass_Konstruktion` AS `PPProduktpass_Konstruktion`,`PPInquiry`.`PPProduktpass_Verarbeitung` AS `PPProduktpass_Verarbeitung`,`PPInquiry`.`PPProduktpass_ZBV1_Name` AS `PPProduktpass_ZBV1_Name`,`PPInquiry`.`PPProduktpass_ZBV1_Wert` AS `PPProduktpass_ZBV1_Wert`,`PPInquiry`.`PPProduktpass_ZBV2_Name` AS `PPProduktpass_ZBV2_Name`,`PPInquiry`.`PPProduktpass_ZBV2_Wert` AS `PPProduktpass_ZBV2_Wert`,`PPInquiry`.`PPProduktpass_ZBV3_Name` AS `PPProduktpass_ZBV3_Name`,`PPInquiry`.`PPProduktpass_ZBV3_Wert` AS `PPProduktpass_ZBV3_Wert`,`PPInquiry`.`PPProduktpass_ZBV4_Name` AS `PPProduktpass_ZBV4_Name`,`PPInquiry`.`PPProduktpass_ZBV4_Wert` AS `PPProduktpass_ZBV4_Wert`,`PPInquiry`.`PPProduktpass_ZBV5_Name` AS `PPProduktpass_ZBV5_Name`,`PPInquiry`.`PPProduktpass_ZBV5_Wert` AS `PPProduktpass_ZBV5_Wert`,`PPInquiry`.`PPProduktpass_Produkt_ZusatzGSM` AS `PPProduktpass_Produkt_ZusatzGSM`,`PPInquiry`.`PPProduktpass_Produkt_Laenge` AS `PPProduktpass_Produkt_Laenge`,`PPInquiry`.`PPProduktpass_Produkt_Breite` AS `PPProduktpass_Produkt_Breite`,`PPInquiry`.`PPProduktpass_Produkt_Hoehe` AS `PPProduktpass_Produkt_Hoehe`,`PPInquiry`.`PPProduktpass_Produkt_GSM` AS `PPProduktpass_Produkt_GSM`,`PPInquiry`.`PPProduktpass_WAWIArtikelnummer` AS `PPProduktpass_WAWIArtikelnummer`,`PPInquiry`.`PPProduktpass_IsRevision` AS `PPProduktpass_IsRevision`,`PPInquiry`.`PPProduktpass_RevisionArt` AS `PPProduktpass_RevisionArt`,`PPInquiry`.`PPProduktpass_Revisionsnummer` AS `PPProduktpass_Revisionsnummer`,`PPInquiry`.`PPProduktpass_RevisionAktuell` AS `PPProduktpass_RevisionAktuell`,`PPInquiry`.`PPProduktpass_RevisionVon_PPProduktpass_Id` AS `PPProduktpass_RevisionVon_PPProduktpass_Id`,`PPInquiry`.`PPProduktpass_RevisionDatum` AS `PPProduktpass_RevisionDatum`,`PPInquiry`.`PPProduktpass_ProjektBild` AS `PPProduktpass_ProjektBild`,`PPInquiry`.`PPProduktpass_VersandfaehigeUmverpackung` AS `PPProduktpass_VersandfaehigeUmverpackung`,`PPInquiry`.`PPProduktpass_RFSicherung` AS `PPProduktpass_RFSicherung`,`PPInquiry`.`PPProduktpass_Passformlabel` AS `PPProduktpass_Passformlabel`,`PPInquiry`.`PPProduktpass_AndereTestkriterien` AS `PPProduktpass_AndereTestkriterien`,`PPInquiry`.`PPProduktpass_ZertifizierungEigenschaften2` AS `PPProduktpass_ZertifizierungEigenschaften2`,`PPInquiry`.`PPProduktpass_GarantiezeitDauer` AS `PPProduktpass_GarantiezeitDauer`,`PPInquiry`.`PPProduktpass_GarentieArt` AS `PPProduktpass_GarentieArt`,`PPInquiry`.`PPProduktpass_LogoDruckverfahren` AS `PPProduktpass_LogoDruckverfahren`,`PPInquiry`.`PPProduktpass_Import_BISUser_Id` AS `PPProduktpass_Import_BISUser_Id`,`PPInquiry`.`PPProduktpass_Import_Datum` AS `PPProduktpass_Import_Datum`,`PPInquiry`.`PPProduktpass_Logos2` AS `PPProduktpass_Logos2`,`PPInquiry`.`PPProduktpass_Logos3` AS `PPProduktpass_Logos3`,`PPInquiry`.`PPProduktpass_Positionierung` AS `PPProduktpass_Positionierung`,`PPInquiry`.`PPProduktpass_ZertifizierungEigenschaften3` AS `PPProduktpass_ZertifizierungEigenschaften3`,`PPInquiry`.`PPProduktpass_ZertifizierungEigenschaften4` AS `PPProduktpass_ZertifizierungEigenschaften4`,`PPInquiry`.`PPProduktpass_ZertifizierungEigenschaften5` AS `PPProduktpass_ZertifizierungEigenschaften5`,`PPInquiry`.`PPProduktpass_Logos4` AS `PPProduktpass_Logos4`,`PPInquiry`.`PPProduktpass_Logos5` AS `PPProduktpass_Logos5`,`PPInquiry`.`PPProduktpass_Bemerkung` AS `PPProduktpass_Bemerkung`,`PPInquiry`.`PPProduktpass_Charge` AS `PPProduktpass_Charge`,`PPInquiry`.`PPProduktpass_AltCharge` AS `PPProduktpass_AltCharge`,`PPInquiry`.`PPProduktpass_KAT` AS `PPProduktpass_KAT`,`PPInquiry`.`PPProduktpass_BZP` AS `PPProduktpass_BZP`,`PPInquiry`.`PPProduktpass_MOQ` AS `PPProduktpass_MOQ`,`PPInquiry`.`PPProduktpass_InitialeCharge` AS `PPProduktpass_InitialeCharge`,`PPInquiry`.`PPProduktpass_Erstbestellung` AS `PPProduktpass_Erstbestellung`,`PPInquiry`.`PPProduktpass_IsInquiry` AS `PPProduktpass_IsInquiry`,`PPInquiry`.`PPProduktpass_InquiryArt` AS `PPProduktpass_InquiryArt`,`P`.`PPPurchase_Id` AS `PPPurchase_Id`,`P`.`PPPurchase_PPProduktpass_Id` AS `PPPurchase_PPProduktpass_Id`,`P`.`PPPurchase_LcNumber` AS `PPPurchase_LcNumber`,`P`.`PPPurchase_ScNumber` AS `PPPurchase_ScNumber`,`P`.`PPPurchase_Inquiry` AS `PPPurchase_Inquiry`,`P`.`PPPurchase_Supplier` AS `PPPurchase_Supplier`,`P`.`PPPurchase_Currency` AS `PPPurchase_Currency`,`P`.`PPPurchase_ExcR_Save` AS `PPPurchase_ExcR_Save`,`P`.`PPPurchase_ExcR_Save_Date` AS `PPPurchase_ExcR_Save_Date`,`P`.`PPPurchase_ExcR_Calc` AS `PPPurchase_ExcR_Calc`,`P`.`PPPurchase_ExcR_Remark` AS `PPPurchase_ExcR_Remark`,`P`.`PPPurchase_CustomsCode` AS `PPPurchase_CustomsCode`,`P`.`PPPurchase_DutyPercentage` AS `PPPurchase_DutyPercentage`,`P`.`PPPurchase_DeliveryDate` AS `PPPurchase_DeliveryDate`,`P`.`PPPurchase_ResOffice` AS `PPPurchase_ResOffice`,`P`.`PPPurchase_Description` AS `PPPurchase_Description`,`P`.`PPPurchase_Material` AS `PPPurchase_Material`,`P`.`PPPurchase_Remark` AS `PPPurchase_Remark`,`P`.`PPPurchase_TermsOfDelivery` AS `PPPurchase_TermsOfDelivery`,`P`.`PPPurchase_TermsOfPayment` AS `PPPurchase_TermsOfPayment`,`P`.`PPPurchase_Status` AS `PPPurchase_Status`,`P`.`PPPurchase_PortOfDischarge` AS `PPPurchase_PortOfDischarge`,`P`.`PPPurchase_Country` AS `PPPurchase_Country`,`P`.`PPPurchase_OrderDate` AS `PPPurchase_OrderDate`,`P`.`PPPurchase_SupplierDelDate` AS `PPPurchase_SupplierDelDate`,`P`.`PPPurchase_Factory` AS `PPPurchase_Factory`,`P`.`PPPurchase_EK_Calc` AS `PPPurchase_EK_Calc`,`P`.`PPPurchase_EK` AS `PPPurchase_EK`,`P`.`PPPurchase_Fracht` AS `PPPurchase_Fracht`,`P`.`PPPurchase_Zoll` AS `PPPurchase_Zoll`,`P`.`PPPurchase_EKProvision` AS `PPPurchase_EKProvision`,`P`.`PPPurchase_Ausgangsfrachten` AS `PPPurchase_Ausgangsfrachten`,`P`.`PPPurchase_Finanzierungskosten` AS `PPPurchase_Finanzierungskosten`,`P`.`PPPurchase_Lizenzgebuehren` AS `PPPurchase_Lizenzgebuehren`,`P`.`PPPurchase_Kosten` AS `PPPurchase_Kosten`,`P`.`PPPurchase_Translate_Quality` AS `PPPurchase_Translate_Quality`,`P`.`PPPurchase_Translate_Projectdescription` AS `PPPurchase_Translate_Projectdescription`,`P`.`PPPurchase_Translate_ManufacturingPlant` AS `PPPurchase_Translate_ManufacturingPlant`,`P`.`PPPurchase_Translate_Packaging` AS `PPPurchase_Translate_Packaging`,`P`.`PPPurchase_SonstKostenProz` AS `PPPurchase_SonstKostenProz`,`P`.`PPPurchase_BemerkungAenderungen` AS `PPPurchase_BemerkungAenderungen`,`P`.`PPPurchase_ManufacturingPlant` AS `PPPurchase_ManufacturingPlant`,`P`.`PPPurchase_LC_TOP` AS `PPPurchase_LC_TOP`,`P`.`PPPurchase_Pruefinstitut` AS `PPPurchase_Pruefinstitut`,`P`.`PPPurchase_Transportdokumente` AS `PPPurchase_Transportdokumente`,`P`.`PPPurchase_Transportdokumente2` AS `PPPurchase_Transportdokumente2`,`P`.`PPPurchase_BWGroesse` AS `PPPurchase_BWGroesse`,`P`.`PPPurchase_FOBWeek` AS `PPPurchase_FOBWeek`,`P`.`PPPurchase_FOBYear` AS `PPPurchase_FOBYear`,`P`.`PPPurchase_FOBSpecial` AS `PPPurchase_FOBSpecial`,`P`.`PPPurchase_ExcR` AS `PPPurchase_ExcR`,`P`.`PPPurchase_ExcR_Date` AS `PPPurchase_ExcR_Date`,if((`P`.`PPPurchase_BWGroesse` = 'Einzelbett'),1,if((`P`.`PPPurchase_BWGroesse` = 'Doppelbett'),1,if((`P`.`PPPurchase_BWGroesse` = 'King Size'),1,0))) AS `QMBerechnung` from (`PPInquiry` join `PPPurchase` `P` on(((`P`.`PPPurchase_PPProduktpass_Id` = `PPInquiry`.`PPProduktpass_Id`) and `P`.`PPPurchase_Id` in (select `v_PurchaseLast`.`PPPurchase_Id` from `v_PurchaseLast`)))) where (length(`PPInquiry`.`PPProduktpass_IAN`) <= 8);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_QMBerechnung`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_QMBerechnung` AS select `PPInquiry`.`PPProduktpass_Id` AS `PPProduktpass_Id`,if((`PPPurchase`.`PPPurchase_BWGroesse` = 'Einzelbett'),1,if((`PPPurchase`.`PPPurchase_BWGroesse` = 'Doppelbett'),1,if((`PPPurchase`.`PPPurchase_BWGroesse` = 'King Size'),1,0))) AS `QMBerechnung` from (`PPInquiry` join `PPPurchase` on((`PPPurchase`.`PPPurchase_PPProduktpass_Id` = `PPInquiry`.`PPProduktpass_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_QualitaetAnlage`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_QualitaetAnlage` AS select group_concat(distinct `v_QualitaetDistinct`.`Style` order by `v_QualitaetDistinct`.`Style` ASC separator ',') AS `Style`,`v_QualitaetDistinct`.`Value` AS `Value`,group_concat(distinct `v_QualitaetDistinct`.`ValueArt` order by `v_QualitaetDistinct`.`ValueArt` ASC separator ',') AS `ValueNo`,`v_QualitaetDistinct`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id` from `v_QualitaetDistinct` where (`v_QualitaetDistinct`.`Value` is not null) group by `v_QualitaetDistinct`.`Value` order by group_concat(distinct `v_QualitaetDistinct`.`Style` order by `v_QualitaetDistinct`.`Style` ASC separator ',');
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_QualitaetDistinct`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_QualitaetDistinct` AS select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value01` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'A' AS `Style`,'01' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value02` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'B' AS `Style`,'02' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value03` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'C' AS `Style`,'03' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value04` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'D' AS `Style`,'04' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value05` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'E' AS `Style`,'05' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value06` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'F' AS `Style`,'06' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value07` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'G' AS `Style`,'07' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value08` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'H' AS `Style`,'08' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value09` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'I' AS `Style`,'09' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value10` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'J' AS `Style`,'10' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value11` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'K' AS `Style`,'11' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value12` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'L' AS `Style`,'12' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value13` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'M' AS `Style`,'13' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value14` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'N' AS `Style`,'14' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` union select group_concat(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Value15` separator '') AS `Value`,`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id` AS `PPProduktpass_Qualitaet_PPProduktpass_Id`,'O' AS `Style`,'15' AS `ValueArt` from `PPProduktpass_Qualitaet` where ((`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header` is not null) and (length(`PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_Header`) > 0)) group by `PPProduktpass_Qualitaet`.`PPProduktpass_Qualitaet_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ServiceAnfrage`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ServiceAnfrage` AS select `PPInputManuell`.`PPInputManuell_Id` AS `PPInputManuell_Id`,`PPInputManuell`.`PPInputManuell_PPProduktpass_Id` AS `PPInputManuell_PPProduktpass_Id`,`PPInputManuell`.`PPInputManuell_Lieferant` AS `Supplier`,`PPInputManuell`.`PPInputManuell_Verschiffungshafen` AS `POD`,`PPInputManuell`.`PPInputManuell_IsFinal` AS `Final` from `PPInputManuell` where ((`PPInputManuell`.`PPInputManuell_IsFinal` = 1) or ((`PPInputManuell`.`PPInputManuell_IsFinal` = 0) and (`PPInputManuell`.`PPInputManuell_IsLatest` = 1)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Shipmentoverview`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Shipmentoverview` AS select `P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Ausmusterung`,concat(`P`.`PPProduktpass_IAN`,'_',substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4)) AS `IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`P`.`PPProduktpass_Gesamtmenge` AS `TotalQuantity`,`P`.`InternerStatus` AS `TargaStatus`,`P`.`statusDoc` AS `LidlStatus`,`TC`.`PPMitarbeiter_Kuerzel` AS `TCAdmin`,`PM`.`PPMitarbeiter_Kuerzel` AS `PMAdmin`,`PJM`.`PPMitarbeiter_Kuerzel` AS `PJMAdmin`,`HM`.`Lot` AS `Lot`,`HM`.`Port` AS `POA`,`HM`.`SaleUnit` AS `SaleUnit`,`HM`.`LotQuantity` AS `LotQuantity`,`HM`.`LT` AS `LT`,`S`.`Supplier` AS `Supplier`,`S`.`POD` AS `POD`,`P`.`PPProduktpass_incoterm` AS `INCOTERM`,`P`.`PPProduktpass_Zolltarif` AS `HSCode`,`MS`.`MS_EUG` AS `MS_EUG`,`MS`.`MS_30PSI` AS `MS_30PSI`,`MS`.`MS_PSI` AS `MS_PSI`,`SH`.`PPShipment_Id` AS `PPShipment_Id`,`SH`.`PPShipment_Forwarder` AS `PPShipment_Forwarder`,`SH`.`PPShipment_Carrier` AS `PPShipment_Carrier`,`SH`.`PPShipment_Lot` AS `PPShipment_Lot`,`SH`.`PPShipment_Vessel` AS `PPShipment_Vessel`,`SH`.`PPShipment_Voyage` AS `PPShipment_Voyage`,`SH`.`PPShipment_ENS` AS `PPShipment_ENS`,`SH`.`PPShipment_CYClosing` AS `PPShipment_CYClosing`,`SH`.`PPShipment_ETD` AS `PPShipment_ETD`,`SH`.`PPShipment_ETA` AS `PPShipment_ETA`,`SH`.`PPShipment_ShipReleaseGiven` AS `PPShipment_ShipReleaseGiven`,`SH`.`PPShipment_ShipReleaseCalc` AS `PPShipment_ShipReleaseCalc`,`SH`.`PPShipment_CRDGiven` AS `PPShipment_CRDGiven`,`SH`.`PPShipment_CRDOpeningCalc` AS `PPShipment_CRDOpeningCalc`,`SH`.`PPShipment_CRDClosingCalc` AS `PPShipment_CRDClosingCalc`,`SH`.`PPShipment_UnloadingReportDate` AS `PPShipment_UnloadingReportDate`,`SH`.`PPShipment_20ftGP` AS `PPShipment_20ftGP`,`SH`.`PPShipment_40ftGP` AS `PPShipment_40ftGP`,`SH`.`PPShipment_40ftHQ` AS `PPShipment_40ftHQ`,`SH`.`PPShipment_LCLCBM` AS `PPShipment_LCLCBM`,`SH`.`PPShipment_20ftGPCalc` AS `PPShipment_20ftGPCalc`,`SH`.`PPShipment_40ftGPCalc` AS `PPShipment_40ftGPCalc`,`SH`.`PPShipment_40ftHQCalc` AS `PPShipment_40ftHQCalc`,`SH`.`PPShipment_CurrentStatus` AS `PPShipment_CurrentStatus`,`SH`.`PPShipment_BLForm` AS `PPShipment_BLForm`,`SH`.`PPShipment_LCOA` AS `PPShipment_LCOA`,`SH`.`PPShipment_ProducerBooking` AS `PPShipment_ProducerBooking`,`SH`.`PPShipment_ShipRelease` AS `PPShipment_ShipRelease`,`SH`.`PPShipment_SO` AS `PPShipment_SO`,`SH`.`PPShipment_BL` AS `PPShipment_BL`,`SH`.`PPShipment_Invoce` AS `PPShipment_Invoce`,`SH`.`PPShipment_PL` AS `PPShipment_PL`,`SH`.`PPShipment_CoO` AS `PPShipment_CoO`,`SH`.`PPShipment_DeclarationFumigation` AS `PPShipment_DeclarationFumigation`,`SH`.`PPShipment_OceanFreight` AS `PPShipment_OceanFreight`,`SH`.`PPShipment_PL2MaWi` AS `PPShipment_PL2MaWi`,`SH`.`PPShipment_CLPSent` AS `PPShipment_CLPSent`,`SH`.`PPShipment_SeaFreightInvoice` AS `PPShipment_SeaFreightInvoice`,`SH`.`PPShipment_TransportInvoice` AS `PPShipment_TransportInvoice`,`SH`.`PPShipment_UnloadingInvoice` AS `PPShipment_UnloadingInvoice`,`SH`.`PPShipment_OtherLogisticalCosts` AS `PPShipment_OtherLogisticalCosts`,`SH`.`PPShipment_CCCsent` AS `PPShipment_CCCsent`,`SH`.`PPShipment_CustomsInvoice` AS `PPShipment_CustomsInvoice`,`SH`.`PPShipment_CustomsDeclared` AS `PPShipment_CustomsDeclared`,`SH`.`PPShipment_HSCode` AS `PPShipment_HSCode`,`SH`.`PPShipment_ProjektCount` AS `PPShipment_ProjektCount`,`SH`.`PPShipment_TEU` AS `PPShipment_TEU`,`SH`.`PPShipment_VKStk` AS `PPShipment_VKStk`,`SH`.`PPShipment_VKSumme` AS `PPShipment_VKSumme`,`SH`.`PPShipment_DistancePort2Port` AS `PPShipment_DistancePort2Port`,`SH`.`PPShipment_Incoterm` AS `PPShipment_INCOTERM`,`SH`.`PPShipment_LT` AS `PPShipment_LT`,`SH`.`PPShipment_MS_30PSI` AS `PPShipment_MS_30PSI`,`SH`.`PPShipment_MS_EUG` AS `PPShipment_MS_EUG`,`SH`.`PPShipment_MS_PSI` AS `PPShipment_MS_PSI`,`SH`.`PPShipment_POA` AS `PPShipment_POA`,`SH`.`PPShipment_POD` AS `PPShipment_POD`,`SH`.`PPShipment_SaleUnit` AS `PPShipment_SaleUnit`,`SH`.`PPShipment_Supplier` AS `PPShipment_Supplier` from (((((((`tPPProduktpass` `P` left join `v_LotHafenmengen` `HM` on((`HM`.`PPProduktpass_Menge_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdmin`))) join `PPMitarbeiter` `TC` on((`TC`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdmin`))) join `PPMitarbeiter` `PJM` on((`PJM`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PJMAdmin`))) left join `v_ServiceAnfrage` `S` on((`S`.`PPInputManuell_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) left join `v_MilestonesShipmentoverview` `MS` on((`MS`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) left join `PPShipment` `SH` on((`SH`.`PPShipment_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ShipmentoverviewKopf`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ShipmentoverviewKopf` AS select `P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Ausmusterung`,`P`.`PPProduktpass_IAN` AS `IAN`,`P`.`PPProduktpass_Artikelbezeichnung` AS `Artikelbezeichnung`,`P`.`PPProduktpass_Gesamtmenge` AS `TotalQuantity`,`P`.`InternerStatus` AS `TargaStatus`,`P`.`statusDoc` AS `LidlStatus`,`TC`.`PPMitarbeiter_Kuerzel` AS `TCAdmin`,`PM`.`PPMitarbeiter_Kuerzel` AS `PMAdmin`,`PJM`.`PPMitarbeiter_Kuerzel` AS `PJMAdmin`,`Log`.`PPMitarbeiter_Kuerzel` AS `LogAdmin`,`S`.`Supplier` AS `Supplier`,`S`.`POD` AS `POD`,`P`.`PPProduktpass_incoterm` AS `INCOTERM`,`P`.`PPProduktpass_Zolltarif` AS `HSCode`,`MS`.`MS_EUG` AS `MS_EUG`,`MS`.`MS_30PSI` AS `MS_30PSI`,`MS`.`MS_PSI` AS `MS_PSI`,`P`.`PPProduktpass_ShipmentArchived` AS `Archived`,`P`.`PPProduktpass_ShipmentComplete` AS `Complete` from ((((((`tPPProduktpass` `P` left join `PPMitarbeiter` `Log` on((`Log`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_LogAdmin`))) left join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `TC` on((`TC`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `PJM` on((`PJM`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PJMAdmin`))) left join `v_ServiceAnfrage` `S` on(((`S`.`PPInputManuell_PPProduktpass_Id` = `P`.`PPProduktpass_Id`) and (`S`.`Final` = 1)))) left join `v_MilestonesShipmentoverview` `MS` on((`MS`.`PPTermine_PPProduktpass_Id` = `P`.`PPProduktpass_Id`))) where ((not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))) and (`P`.`PPProduktpass_Ausmusterungnummer` > '2000') and (`P`.`InternerStatus` in ('PLAN','FIX','INTERN','GELIEFERT')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ShipmentoverviewShipments`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ShipmentoverviewShipments` AS select `P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,`P`.`PPProduktpass_Ausmusterungnummer` AS `PPProduktpass_Ausmusterungnummer`,`SH`.`PPShipment_Id` AS `PPShipment_Id`,`SH`.`PPShipment_Forwarder` AS `PPShipment_Forwarder`,`SH`.`PPShipment_Carrier` AS `PPShipment_Carrier`,`SH`.`PPShipment_Lot` AS `PPShipment_Lot`,`SH`.`PPShipment_Vessel` AS `PPShipment_Vessel`,`SH`.`PPShipment_Voyage` AS `PPShipment_Voyage`,`SH`.`PPShipment_ENS` AS `PPShipment_ENS`,`SH`.`PPShipment_CYClosing` AS `PPShipment_CYClosing`,`SH`.`PPShipment_ETD` AS `PPShipment_ETD`,`SH`.`PPShipment_ETA` AS `PPShipment_ETA`,`SH`.`PPShipment_ShipReleaseGiven` AS `PPShipment_ShipReleaseGiven`,`SH`.`PPShipment_ShipReleaseCalc` AS `PPShipment_ShipReleaseCalc`,`SH`.`PPShipment_CRDGiven` AS `PPShipment_CRDGiven`,`SH`.`PPShipment_CRDOpeningCalc` AS `PPShipment_CRDOpeningCalc`,`SH`.`PPShipment_CRDClosingCalc` AS `PPShipment_CRDClosingCalc`,`SH`.`PPShipment_UnloadingReportDate` AS `PPShipment_UnloadingReportDate`,`SH`.`PPShipment_20ftGP` AS `PPShipment_20ftGP`,`SH`.`PPShipment_40ftGP` AS `PPShipment_40ftGP`,`SH`.`PPShipment_40ftHQ` AS `PPShipment_40ftHQ`,`SH`.`PPShipment_LCLCBM` AS `PPShipment_LCLCBM`,`SH`.`PPShipment_20ftGPCalc` AS `PPShipment_20ftGPCalc`,`SH`.`PPShipment_40ftGPCalc` AS `PPShipment_40ftGPCalc`,`SH`.`PPShipment_40ftHQCalc` AS `PPShipment_40ftHQCalc`,`SH`.`PPShipment_CurrentStatus` AS `PPShipment_CurrentStatus`,`SH`.`PPShipment_BLForm` AS `PPShipment_BLForm`,`SH`.`PPShipment_LCOA` AS `PPShipment_LCOA`,`SH`.`PPShipment_ProducerBooking` AS `PPShipment_ProducerBooking`,`SH`.`PPShipment_ShipRelease` AS `PPShipment_ShipRelease`,`SH`.`PPShipment_SO` AS `PPShipment_SO`,`SH`.`PPShipment_BL` AS `PPShipment_BL`,`SH`.`PPShipment_Invoce` AS `PPShipment_Invoce`,`SH`.`PPShipment_PL` AS `PPShipment_PL`,`SH`.`PPShipment_CoO` AS `PPShipment_CoO`,`SH`.`PPShipment_DeclarationFumigation` AS `PPShipment_DeclarationFumigation`,`SH`.`PPShipment_OceanFreight` AS `PPShipment_OceanFreight`,`SH`.`PPShipment_PL2MaWi` AS `PPShipment_PL2MaWi`,`SH`.`PPShipment_CLPSent` AS `PPShipment_CLPSent`,`SH`.`PPShipment_SeaFreightInvoice` AS `PPShipment_SeaFreightInvoice`,`SH`.`PPShipment_TransportInvoice` AS `PPShipment_TransportInvoice`,`SH`.`PPShipment_UnloadingInvoice` AS `PPShipment_UnloadingInvoice`,`SH`.`PPShipment_OtherLogisticalCosts` AS `PPShipment_OtherLogisticalCosts`,`SH`.`PPShipment_CCCsent` AS `PPShipment_CCCsent`,`SH`.`PPShipment_CustomsInvoice` AS `PPShipment_CustomsInvoice`,`SH`.`PPShipment_CustomsDeclared` AS `PPShipment_CustomsDeclared`,`SH`.`PPShipment_HSCode` AS `PPShipment_HSCode`,`SH`.`PPShipment_ProjektCount` AS `PPShipment_ProjektCount`,`SH`.`PPShipment_TEU` AS `PPShipment_TEU`,`SH`.`PPShipment_VKStk` AS `PPShipment_VKStk`,`SH`.`PPShipment_VKSumme` AS `PPShipment_VKSumme`,`SH`.`PPShipment_DistancePort2Port` AS `PPShipment_DistancePort2Port`,`SH`.`PPShipment_Incoterm` AS `PPShipment_Incoterm`,`SH`.`PPShipment_LT` AS `PPShipment_LT`,`SH`.`PPShipment_MS_30PSI` AS `PPShipment_MS_30PSI`,`SH`.`PPShipment_MS_EUG` AS `PPShipment_MS_EUG`,`SH`.`PPShipment_MS_PSI` AS `PPShipment_MS_PSI`,`SH`.`PPShipment_POA` AS `PPShipment_POA`,`SH`.`PPShipment_POD` AS `PPShipment_POD`,`SH`.`PPShipment_SaleUnit` AS `PPShipment_SaleUnit`,`SH`.`PPShipment_Supplier` AS `PPShipment_Supplier`,`SH`.`PPShipment_Status` AS `PPShipment_Status`,`SH`.`PPShipment_Quantity` AS `PPShipment_Quantity`,`SH`.`PPShipment_Flag_Producer_booking` AS `PPShipment_Flag_Producer_booking`,`SH`.`PPShipment_Flag_Shipment_Release` AS `PPShipment_Flag_Shipment_Release`,`SH`.`PPShipment_Flag_SO` AS `PPShipment_Flag_SO`,`SH`.`PPShipment_Flag_BL` AS `PPShipment_Flag_BL`,`SH`.`PPShipment_Flag_Inv` AS `PPShipment_Flag_Inv`,`SH`.`PPShipment_Flag_PL` AS `PPShipment_Flag_PL`,`SH`.`PPShipment_Flag_CoO` AS `PPShipment_Flag_CoO`,`SH`.`PPShipment_Flag_Declaration_of_Fumigation` AS `PPShipment_Flag_Declaration_of_Fumigation`,`SH`.`PPShipment_Flag_Ocean_Freight` AS `PPShipment_Flag_Ocean_Freight`,`SH`.`PPShipment_Flag_PL_sent_to_MaWi` AS `PPShipment_Flag_PL_sent_to_MaWi`,`SH`.`PPShipment_Flag_CLP_sent` AS `PPShipment_Flag_CLP_sent`,`SH`.`PPShipment_Flag_Sea_freight_invoice` AS `PPShipment_Flag_Sea_freight_invoice`,`SH`.`PPShipment_Flag_Transport_invoice` AS `PPShipment_Flag_Transport_invoice`,`SH`.`PPShipment_Flag_Unloading_invoice` AS `PPShipment_Flag_Unloading_invoice`,`SH`.`PPShipment_Flag_Other_logistical_costs` AS `PPShipment_Flag_Other_logistical_costs`,`SH`.`PPShipment_Flag_CCC_sent` AS `PPShipment_Flag_CCC_sent`,`SH`.`PPShipment_Flag_customs_invoice` AS `PPShipment_Flag_customs_invoice`,`SH`.`PPShipment_Flag_OS` AS `PPShipment_Flag_OS`,`SH`.`PPShipment_Flag_EUService` AS `PPShipment_Flag_EUService`,`SH`.`PPShipment_Flag_Critical` AS `PPShipment_Flag_Critical`,`SH`.`PPShipment_BatteryType` AS `PPShipment_BatteryType`,`SH`.`PPShipment_MasterCartonContents` AS `PPShipment_MasterCartonContents`,`SH`.`PPShipment_ATAInlandsterminal` AS `PPShipment_ATAInlandsterminal`,`SH`.`PPShipment_ZipCodeFactory` AS `PPShipment_ZipCodeFactory`,`SH`.`PPShipment_Sortierung` AS `PPShipment_Sortierung` from (`tPPProduktpass` `P` join `PPShipment` `SH` on(((`SH`.`PPShipment_IAN` = `P`.`PPProduktpass_IAN`) and (`SH`.`PPShipment_Ausmusterungnummer` = substr(`P`.`PPProduktpass_Ausmusterungnummer`,1,4))))) where ((not((`P`.`PPProduktpass_IAN` like '%ev%'))) and (not((`P`.`PPProduktpass_IAN` like '99%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_SortierungOrderWeights`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_SortierungOrderWeights` AS select `PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` AS `PPProduktpass_Sortierung_PPProduktpass_Id`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` AS `PPProduktpass_Sortierung_Header`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value01` AS `PPProduktpass_Sortierung_Value01`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Value02` AS `PPProduktpass_Sortierung_Value02`,`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Laenderblock` AS `PPProduktpass_Sortierung_Laenderblock`,`PPOrderWeights`.`PPOrderWeights_gtin` AS `PPOrderWeights_gtin`,`PPOrderWeights`.`PPOrderWeights_gtinKL` AS `PPOrderWeights_gtinKL`,`PPOrderWeights`.`PPOrderWeights_lsv` AS `PPOrderWeights_lsv`,`PPOrderWeights`.`PPOrderWeights_weight` AS `PPOrderWeights_weight`,`PPOrderWeights`.`PPOrderWeights_unit` AS `PPOrderWeights_unit` from (`PPProduktpass_Sortierung` join `PPOrderWeights` on(((`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_Header` = `PPOrderWeights`.`PPOrderWeights_styleNo`) and (`PPProduktpass_Sortierung`.`PPProduktpass_Sortierung_PPProduktpass_Id` = `PPOrderWeights`.`PPOrderWeights_PPProduktpass_Id`))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_StyleSizeAndWeight`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_StyleSizeAndWeight` AS select distinct `PPProduktpass_Style`.`PPProduktpass_Style_PPProduktpass_Id` AS `PPProduktpass_Style_PPProduktpass_Id`,`PPProduktpass_Style`.`sizeWithoutPackaging` AS `sizeWithoutPackaging`,`PPProduktpass_Style`.`weightWithoutPackaging` AS `weightWithoutPackaging` from `PPProduktpass_Style` where `PPProduktpass_Style`.`PPProduktpass_Style_PPProduktpass_Id` in (select `tPPProduktpass`.`PPProduktpass_Id` from `tPPProduktpass` where (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TempPPLiefertermine`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TempPPLiefertermine` AS select `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id` AS `PPId`,`tPPProduktpass`.`statusDoc` AS `StatusDocLIDL`,`tPPProduktpass`.`PPProduktpass_IAN` AS `IAN`,substr(`tPPProduktpass`.`PPProduktpass_Ausmusterungnummer`,1,4) AS `Charge`,(substr(`tPPProduktpass`.`PPProduktpass_Thema`,1,2) * 1) AS `LWausThema`,min(`PPProduktpass_Menge`.`PPProduktpass_Menge_LT1`) AS `LaenderLT`,(`tPPProduktpass`.`PPProduktpass_Liefertermin` * 1) AS `PPLTWoche`,(`tPPProduktpass`.`PPProduktpass_LieferterminJahr` * 1) AS `PPLTJahr`,`tPPProduktpass`.`PPProduktpass_CRDWoche` AS `CRDWoche`,`tPPProduktpass`.`PPProduktpass_CRDJahr` AS `CRDJahr`,`tPPProduktpass`.`PPProduktpass_Thema` AS `PPProduktpass_Thema`,`tPPProduktpass`.`InternerStatus` AS `InternerStatus` from (`PPProduktpass_Menge` join `tPPProduktpass` on((`tPPProduktpass`.`PPProduktpass_Id` = `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`))) where ((`tPPProduktpass`.`statusDoc` like 'TEMP%') and (not((`tPPProduktpass`.`PPProduktpass_IAN` like '%ev%')))) group by `PPProduktpass_Menge`.`PPProduktpass_Menge_PPProduktpass_Id`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminSpalten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminSpalten` AS select `SD`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`SD`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`SD`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`SD`.`PPBoardSpalte_Stati` AS `PPBoardSpalte_Stati`,`SD`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`SD`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`SD`.`PPBoardSpalte_DefaultMA` AS `PPBoardSpalte_DefaultMA`,`SD`.`PPBoardSpalte_DFTable` AS `PPBoardSpalte_DFTable`,`SD`.`PPBoardSpalte_DFField` AS `PPBoardSpalte_DFField`,`SD`.`PPBoardSpalte_Remark` AS `PPBoardSpalte_Remark`,`SD`.`PPBoardSpalteData_Kind` AS `PPBoardSpalteData_Kind`,`SD`.`PPBoardSpalte_IsMilestone` AS `PPBoardSpalte_IsMilestone`,`SD`.`PPBoardSpalte_IsUSA` AS `PPBoardSpalte_IsUSA`,`SD`.`PPBoardSpalteData_Nachbestellung` AS `PPBoardSpalteData_Nachbestellung`,`SD`.`PPBoardSpalteData_Child_nB` AS `PPBoardSpalteData_Child_nB`,`SD`.`PPBoardSpalteData_HilfeStatusOK` AS `PPBoardSpalteData_HilfeStatusOK`,`SD`.`PPBoardSpalteData_HifeStatusInArbeit` AS `PPBoardSpalteData_HifeStatusInArbeit`,`SD`.`PPBoardSpalteData_HilfeStatusNOK` AS `PPBoardSpalteData_HilfeStatusNOK`,`SDX`.`PPBoardSpalteX_Id` AS `PPBoardSpalteX_Id`,`SDX`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`SDX`.`PPBoardSpalteX_PPBoardSpalte_Id` AS `PPBoardSpalteX_PPBoardSpalte_Id`,`SDX`.`PPBoardSpalteX_Sort` AS `PPBoardSpalteX_Sort` from (`PPBoardSpalteData` `SD` join `PPBoardSpalteX` `SDX` on((`SDX`.`PPBoardSpalteX_PPBoardSpalte_Id` = `SD`.`PPBoardSpalte_Id`))) where (`SDX`.`PPBoardSpalte_PPBoard_Id` >= 1000);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Termine`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Termine` AS select `T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPTermine_Header` AS `PPTermine_Header`,`T`.`PPTermine_Typ` AS `PPTermine_Typ`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`Ma`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`T`.`PPTermine_Status` AS `PPTermine_Status`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`BS`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`St`.`PPStati_Status` AS `PPStati_Status`,`St`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`St`.`PPStati_Background` AS `PPStati_Background`,`BS`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`BS`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`BS`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from (((`PPTermine` `T` left join `PPMitarbeiter` `Ma` on((`Ma`.`PPMitarbeiter_Id` = `T`.`PPTermine_MAZustaendigkeit`))) left join `PPBoardSpalteData` `BS` on((`BS`.`PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`))) left join `PPStati` `St` on((`St`.`PPStati_Status` = `T`.`PPTermine_Status`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TermineAll`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TermineAll` AS select `T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPTermine_Header` AS `PPTermine_Header`,`T`.`PPTermine_Art` AS `PPTermine_Art`,`T`.`PPTermine_Typ` AS `PPTermine_Typ`,`T`.`PPTermine_MAAnlage` AS `PPTermine_MAAnlage`,`T`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`T`.`PPTermine_Status` AS `PPTermine_Status`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`PPTermine_History` AS `PPTermine_History`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`PPStati`.`PPStati_Id` AS `PPStati_Id`,`PPStati`.`PPStati_Status` AS `PPStati_Status`,`PPStati`.`PPStati_Color` AS `PPStati_Color`,`PPStati`.`PPStati_Background` AS `PPStati_Background`,`PPStati`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`PM`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`PM`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`SD`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`SD`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`SD`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`SD`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`SD`.`PPBoardSpalte_Id` AS `PPBoardSpalte_Id`,`SD`.`PPBoardSpalte_IsUSA` AS `PPBoardSpalte_IsUSA`,`BSX`.`PPBoardSpalte_PPBoard_Id` AS `PPBoardSpalte_PPBoard_Id`,`SD`.`PPBoardSpalte_IsMilestone` AS `PPBoardSpalte_IsMilestone` from ((((`PPTermine` `T` join `PPStati` on((`T`.`PPTermine_Status` = `PPStati`.`PPStati_Status`))) join `PPMitarbeiter` `PM` on((`PM`.`PPMitarbeiter_Id` = `T`.`PPTermine_MAZustaendigkeit`))) join `PPBoardSpalteData` `SD` on((`SD`.`PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`))) join `PPBoardSpalteX` `BSX` on((`BSX`.`PPBoardSpalteX_PPBoardSpalte_Id` = `T`.`PPTermine_PPBoardSpalte_id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TermineII`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TermineII` AS select `T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPTermine_Header` AS `PPTermine_Header`,`T`.`PPTermine_Typ` AS `PPTermine_Typ`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`Ma`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`T`.`PPTermine_Status` AS `PPTermine_Status`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`PPBoardSpalteData`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`St`.`PPStati_Status` AS `PPStati_Status`,`St`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`St`.`PPStati_Background` AS `PPStati_Background`,`PPBoardSpalteData`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`PPBoardSpalteData`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`PPBoardSpalteData`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,(case `T`.`PPTermine_DatumStart` when '0000-00-00 00:00:00' then `T`.`PPTermine_ManSollDate` else `T`.`PPTermine_DatumStart` end) AS `ErlBis`,`CRD`.`CRD` AS `CRD`,((`CRD`.`CRD` + interval (`PPBoardSpalteData`.`PPBoardSpalte_Rot` + 10) week) + interval -(2) day) AS `ErlBisDefault` from (((((`PPTermine` `T` left join `v_CRD` `CRD` on((`T`.`PPTermine_PPProduktpass_Id` = `CRD`.`PPProduktpass_Id`))) left join `PPBoardSpalteData` on((`T`.`PPTermine_PPBoardSpalte_id` = `PPBoardSpalteData`.`PPBoardSpalte_Id`))) join `tPPProduktpass` `PP` on((`PP`.`PPProduktpass_Id` = `T`.`PPTermine_PPProduktpass_Id`))) left join `PPMitarbeiter` `Ma` on((`Ma`.`PPMitarbeiter_Id` = `T`.`PPTermine_MAZustaendigkeit`))) left join `PPStati` `St` on((`St`.`PPStati_Status` = `T`.`PPTermine_Status`))) where (`PPBoardSpalteData`.`PPBoardSpalte_Id` >= 1000);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TermineMitChanges`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TermineMitChanges` AS select `PPBoardSpalte`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`PPBoardSpalte`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`PPBoardSpalte`.`PPBoard_Id` AS `PPBoard_Id`,`PPTermine`.`PPTermine_Id` AS `PPTermine_Id`,`PPTermine`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`PPTermine`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`PPTermine`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`PPTermine`.`PPTermine_Header` AS `PPTermine_Header`,`PPTermine`.`PPTermine_Status` AS `PPTermine_Status`,`PPTermine`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`PPTermine`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`PPTermine`.`PPTermine_Label` AS `PPTermine_Label`,`PPTermineChanges`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`PPTermineChanges`.`PPTermineChanges_Date` AS `PPTermineChanges_Date`,`PPTermineChanges`.`PPTermineChanges_Remark` AS `PPTermineChanges_Remark`,`PPTermineChanges`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`PPTermineChanges`.`PPTermineChanges_oldStatus` AS `PPTermineChanges_oldStatus`,`PPTermineChanges`.`PPTermineChanges_newStatus` AS `PPTermineChanges_newStatus`,`PPTermineChanges`.`PPTermineChanges_Mitarbeiter_Id` AS `PPTermineChanges_Mitarbeiter_Id`,`PPTermineChanges`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`PPTermineChanges`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`PPTermineChanges`.`PPTermineChanges_Receiver` AS `PPTermineChanges_Receiver`,`PPTermineChanges`.`PPTermineChanges_PPPPFilesId` AS `PPTermineChanges_PPPPFilesId`,`PPTermineChanges`.`PPTermineChanges_ParentId` AS `PPTermineChanges_ParentId` from ((`PPTermine` join `PPBoardSpalte` on((`PPBoardSpalte`.`PPBoardSpalte_Id` = `PPTermine`.`PPTermine_PPBoardSpalte_id`))) left join `PPTermineChanges` on((`PPTermine`.`PPTermine_Id` = `PPTermineChanges`.`PPTermineChanges_PPTermine_Id`)));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_Terminliste`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_Terminliste` AS select `v_TerminlisteC`.`Type` AS `Type`,`v_TerminlisteC`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteC`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteC`.`PPTermineChanges_PPTermine_Id` AS `PPTermineChanges_PPTermine_Id`,`v_TerminlisteC`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`v_TerminlisteC`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteC`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`v_TerminlisteC`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`v_TerminlisteC`.`Status` AS `Status`,`v_TerminlisteC`.`Background` AS `Background`,`v_TerminlisteC`.`OKStatus` AS `OKStatus`,`v_TerminlisteC`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteC`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteC`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteC`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteC`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteC`.`Bemerkung` AS `Bemerkung`,'0000-00-00 00:00:00' AS `PPTermine_ManSollDate`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `ErlBis`,`v_TerminlisteC`.`PPTermine_Label` AS `PPTermine_Label`,`v_TerminlisteC`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`v_TerminlisteC`.`PPTermineChanges_RemarkReceiver` AS `PPTermineChanges_RemarkReceiver`,`v_TerminlisteC`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`v_TerminlisteC`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_TerminlisteC` union select `v_TerminlisteT`.`Type` AS `Type`,`v_TerminlisteT`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteT`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteT`.`PPTermine_Id` AS `PPTermine_Id`,`v_TerminlisteT`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`v_TerminlisteT`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteT`.`Hauptaufgabe` AS `Hauptaufgabe`,`v_TerminlisteT`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`v_TerminlisteT`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`v_TerminlisteT`.`PPStati_Status` AS `PPStati_Status`,`v_TerminlisteT`.`PPStati_Background` AS `PPStati_Background`,`v_TerminlisteT`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`v_TerminlisteT`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteT`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteT`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteT`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteT`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteT`.`Bemerkung` AS `Bemerkung`,`v_TerminlisteT`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`v_TerminlisteT`.`ErlBis` AS `ErlBis`,`v_TerminlisteT`.`PPTermine_Label` AS `PPTermine_Label`,`v_TerminlisteT`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,'' AS `PPTermineChanges_RemarkReceiver`,`v_TerminlisteT`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`v_TerminlisteT`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_TerminlisteT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteC`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteC` AS select 'C' AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`Ch`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`Ch`.`PPTermineChanges_PPTermine_Id` AS `PPTermineChanges_PPTermine_Id`,`Ch`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`MA`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`Ch`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`Ch`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`Ch`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,(case when (`Ch`.`PPTermineChanges_DoneAt` is null) then 'offen' else 'erledigt' end) AS `Status`,(case when (`Ch`.`PPTermineChanges_DoneAt` is null) then 0 else 1 end) AS `OKStatus`,(case when (`Ch`.`PPTermineChanges_DoneAt` is null) then '0,255,0' else '255,255,255' end) AS `Background`,NULL AS `PPBoardSpalte_Orange`,NULL AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`Ch`.`PPTermineChanges_Remark` AS `Bemerkung`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`Ch`.`PPTermineChanges_RemarkReceiver` AS `PPTermineChanges_RemarkReceiver`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from ((`PPTermineChanges` `Ch` join `v_Termine` `T` on((`T`.`PPTermine_Id` = `Ch`.`PPTermineChanges_PPTermine_Id`))) left join `PPMitarbeiter` `MA` on((`MA`.`PPMitarbeiter_Id` = `Ch`.`PPTermineChanges_Receiver`))) where ((`Ch`.`PPTermineChanges_IsActive` = 1) and (`Ch`.`PPTermineChanges_newStatus` is null));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteFIX`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteFIX` AS select `v_TerminlisteC`.`Type` AS `Type`,`v_TerminlisteC`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteC`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteC`.`PPTermineChanges_PPTermine_Id` AS `PPTermineChanges_PPTermine_Id`,`v_TerminlisteC`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`v_TerminlisteC`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteC`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`v_TerminlisteC`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`v_TerminlisteC`.`Status` AS `Status`,`v_TerminlisteC`.`Background` AS `Background`,`v_TerminlisteC`.`OKStatus` AS `OKStatus`,`v_TerminlisteC`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteC`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteC`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteC`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteC`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteC`.`Bemerkung` AS `Bemerkung`,'0000-00-00 00:00:00' AS `PPTermine_ManSollDate`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `ErlBis`,`v_TerminlisteC`.`PPTermine_Label` AS `PPTermine_Label`,`v_TerminlisteC`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`v_TerminlisteC`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`v_TerminlisteC`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_TerminlisteC` union select `v_TerminlisteTFIX`.`Type` AS `Type`,`v_TerminlisteTFIX`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteTFIX`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteTFIX`.`PPTermine_Id` AS `PPTermine_Id`,`v_TerminlisteTFIX`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`v_TerminlisteTFIX`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteTFIX`.`Hauptaufgabe` AS `Hauptaufgabe`,`v_TerminlisteTFIX`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`v_TerminlisteTFIX`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`v_TerminlisteTFIX`.`PPStati_Status` AS `PPStati_Status`,`v_TerminlisteTFIX`.`PPStati_Background` AS `PPStati_Background`,`v_TerminlisteTFIX`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`v_TerminlisteTFIX`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteTFIX`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteTFIX`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteTFIX`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteTFIX`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteTFIX`.`Bemerkung` AS `Bemerkung`,`v_TerminlisteTFIX`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`v_TerminlisteTFIX`.`ErlBis` AS `ErlBis`,`v_TerminlisteTFIX`.`PPTermine_Label` AS `PPTermine_Label`,`v_TerminlisteTFIX`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`v_TerminlisteTFIX`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`v_TerminlisteTFIX`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_TerminlisteTFIX`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteII`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteII` AS select `v_TerminlisteC`.`Type` AS `Type`,`v_TerminlisteC`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteC`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteC`.`PPTermineChanges_PPTermine_Id` AS `PPTermineChanges_PPTermine_Id`,`v_TerminlisteC`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`v_TerminlisteC`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteC`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`v_TerminlisteC`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`v_TerminlisteC`.`Status` AS `Status`,`v_TerminlisteC`.`Background` AS `Background`,`v_TerminlisteC`.`OKStatus` AS `OKStatus`,`v_TerminlisteC`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteC`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteC`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteC`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteC`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteC`.`Bemerkung` AS `Bemerkung`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `ErlBis`,'0000-00-00 00:00:00' AS `ErlBisDefault` from `v_TerminlisteC` union select `v_TerminlisteTII`.`Type` AS `Type`,`v_TerminlisteTII`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteTII`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteTII`.`PPTermine_Id` AS `PPTermine_Id`,`v_TerminlisteTII`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`v_TerminlisteTII`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteTII`.`Hauptaufgabe` AS `Hauptaufgabe`,`v_TerminlisteTII`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`v_TerminlisteTII`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`v_TerminlisteTII`.`PPStati_Status` AS `PPStati_Status`,`v_TerminlisteTII`.`PPStati_Background` AS `PPStati_Background`,`v_TerminlisteTII`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`v_TerminlisteTII`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteTII`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteTII`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteTII`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteTII`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteTII`.`Bemerkung` AS `Bemerkung`,`v_TerminlisteTII`.`ErlBis` AS `ErlBis`,`v_TerminlisteTII`.`ErlBisDefault` AS `ErlBisDefault` from `v_TerminlisteTII`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteInq`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteInq` AS select `T`.`Type` AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`T`.`PPTermineChanges_PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`T`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`T`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`T`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,left(`P`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`T`.`Status` AS `PPTermine_Status`,`T`.`Background` AS `Background`,`T`.`OKStatus` AS `PPStati_OKStatus`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez` from (`v_Terminliste` `T` join `PPProduktpass` `P` on((`P`.`PPProduktpass_Id` = `T`.`PPTermineChanges_PPProduktpass_Id`))) where ((length(`P`.`PPProduktpass_IAN`) = 8) and (`P`.`PPProduktpass_IAN` like 'I-%'));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteMU`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteMU` AS select `T`.`Type` AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`T`.`PPTermineChanges_PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`T`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`T`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`T`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,left(`P`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`T`.`Status` AS `PPTermine_Status`,`T`.`Background` AS `Background`,`T`.`OKStatus` AS `PPStati_OKStatus`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr` from (`v_Terminliste` `T` join `tPPProduktpass` `P` on((`P`.`PPProduktpass_Id` = `T`.`PPTermineChanges_PPProduktpass_Id`))) where ((length(`P`.`PPProduktpass_IAN`) = 8) and (`P`.`PPProduktpass_IAN` like 'M-%'));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlistePLAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlistePLAN` AS select `v_TerminlisteC`.`Type` AS `Type`,`v_TerminlisteC`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteC`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteC`.`PPTermineChanges_PPTermine_Id` AS `PPTermineChanges_PPTermine_Id`,`v_TerminlisteC`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`v_TerminlisteC`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteC`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`v_TerminlisteC`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`v_TerminlisteC`.`Status` AS `Status`,`v_TerminlisteC`.`Background` AS `Background`,`v_TerminlisteC`.`OKStatus` AS `OKStatus`,`v_TerminlisteC`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteC`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteC`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteC`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteC`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteC`.`Bemerkung` AS `Bemerkung`,'0000-00-00 00:00:00' AS `PPTermine_ManSollDate`,`v_TerminlisteC`.`PPTermineChanges_DoUntil` AS `ErlBis`,`v_TerminlisteC`.`PPTermine_Label` AS `PPTermine_Label`,`v_TerminlisteC`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`v_TerminlisteC`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`v_TerminlisteC`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_TerminlisteC` union select `v_TerminlisteTPLAN`.`Type` AS `Type`,`v_TerminlisteTPLAN`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`v_TerminlisteTPLAN`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`v_TerminlisteTPLAN`.`PPTermine_Id` AS `PPTermine_Id`,`v_TerminlisteTPLAN`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`v_TerminlisteTPLAN`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`v_TerminlisteTPLAN`.`Hauptaufgabe` AS `Hauptaufgabe`,`v_TerminlisteTPLAN`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`v_TerminlisteTPLAN`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`v_TerminlisteTPLAN`.`PPStati_Status` AS `PPStati_Status`,`v_TerminlisteTPLAN`.`PPStati_Background` AS `PPStati_Background`,`v_TerminlisteTPLAN`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`v_TerminlisteTPLAN`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`v_TerminlisteTPLAN`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`v_TerminlisteTPLAN`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`v_TerminlisteTPLAN`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`v_TerminlisteTPLAN`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`v_TerminlisteTPLAN`.`Bemerkung` AS `Bemerkung`,`v_TerminlisteTPLAN`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,`v_TerminlisteTPLAN`.`ErlBis` AS `ErlBis`,`v_TerminlisteTPLAN`.`PPTermine_Label` AS `PPTermine_Label`,`v_TerminlisteTPLAN`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`v_TerminlisteTPLAN`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`v_TerminlisteTPLAN`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_TerminlisteTPLAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlistePP`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlistePP` AS select `T`.`Type` AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`T`.`PPTermineChanges_PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`MA`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`T`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`T`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`T`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,left(`P`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`PM1`.`PPMitarbeiter_Kuerzel` AS `PM_Vtr`,`PM3`.`PPMitarbeiter_Kuerzel` AS `PM`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`PM2`.`PPMitarbeiter_Kuerzel` AS `TC_Vtr`,`PM4`.`PPMitarbeiter_Kuerzel` AS `TC`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`Status` AS `PPTermine_Status`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`T`.`Background` AS `Background`,`T`.`OKStatus` AS `PPStati_OKStatus`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,if((`T`.`PPTermineChanges_DoUntil` = '000-00-00 00:00:00'),(str_to_date(concat(`P`.`PPProduktpass_LieferterminJahr`,' ',`P`.`PPProduktpass_Liefertermin`,' Friday'),'%X %V %W') + interval ifnull(`T`.`PPBoardSpalte_Rot`,0) week),`T`.`PPTermineChanges_DoUntil`) AS `DateMilestone1`,if((`T`.`PPTermineChanges_DoUntil` = '0000-00-00 00:00:00'),if((if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%v %x %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0) = 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%v %x %W') + interval `T`.`PPBoardSpalte_Rot` week),'%Y-%m-%d'),if((`T`.`PPTermine_ManSoll` <> 0),date_format((str_to_date(concat(`P`.`PPProduktpass_Liefertermin`,' ',`P`.`PPProduktpass_LieferterminJahr`,' ','Friday'),'%v %x %W') + interval ((-(1) * `T`.`PPTermine_ManSoll`) - 10) week),'%Y-%m-%d'),0)),`T`.`PPTermineChanges_DoUntil`) AS `DateMilestone`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`Bemerkung` AS `Bemerkung` from ((((((`tPPProduktpass` `P` join `v_Terminliste` `T` on((`P`.`PPProduktpass_Id` = `T`.`PPTermineChanges_PPProduktpass_Id`))) left join `PPMitarbeiter` `PM1` on((`PM1`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `PM2` on((`PM2`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPMitarbeiter` `PM3` on((`PM3`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `PM4` on((`PM4`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MA` on((`T`.`PPMitarbeiter_Kuerzel` = `MA`.`PPMitarbeiter_Kuerzel`))) where (length(`P`.`PPProduktpass_IAN`) = 6);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlistePP_2`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlistePP_2` AS select `T`.`Type` AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`T`.`PPTermineChanges_PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`MA`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`T`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`T`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`T`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,left(`P`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`PM1`.`PPMitarbeiter_Kuerzel` AS `PM_Vtr`,`PM3`.`PPMitarbeiter_Kuerzel` AS `PM`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`PM2`.`PPMitarbeiter_Kuerzel` AS `TC_Vtr`,`PM4`.`PPMitarbeiter_Kuerzel` AS `TC`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`Status` AS `PPTermine_Status`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`T`.`Background` AS `Background`,`T`.`OKStatus` AS `PPStati_OKStatus`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,(case `T`.`ErlBis` when '0000-00-00 00:00:00' then ((`P`.`CRD` + interval (`T`.`PPBoardSpalte_Rot` + 10) week) + interval -(2) day) else `T`.`ErlBis` end) AS `DateMilestone`,'0000-00-00 00:00:00' AS `DateMilestone1`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`Bemerkung` AS `Bemerkung`,`P`.`CRD` AS `CRD`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermineChanges_RemarkReceiver` AS `PPTermineChanges_RemarkReceiver`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from ((((((`v_CRD` `P` join `v_Terminliste` `T` on((`P`.`PPProduktpass_Id` = `T`.`PPTermineChanges_PPProduktpass_Id`))) left join `PPMitarbeiter` `PM1` on((`PM1`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `PM2` on((`PM2`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPMitarbeiter` `PM3` on((`PM3`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `PM4` on((`PM4`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MA` on((`T`.`PPMitarbeiter_Kuerzel` = `MA`.`PPMitarbeiter_Kuerzel`))) where (length(`P`.`PPProduktpass_IAN`) = 6);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlistePP_2FIX`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlistePP_2FIX` AS select `T`.`Type` AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`T`.`PPTermineChanges_PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`MA`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`T`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`T`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`T`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,left(`P`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`PM1`.`PPMitarbeiter_Kuerzel` AS `PM_Vtr`,`PM3`.`PPMitarbeiter_Kuerzel` AS `PM`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`PM2`.`PPMitarbeiter_Kuerzel` AS `TC_Vtr`,`PM4`.`PPMitarbeiter_Kuerzel` AS `TC`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`Status` AS `PPTermine_Status`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`T`.`Background` AS `Background`,`T`.`OKStatus` AS `PPStati_OKStatus`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,(case `T`.`ErlBis` when '0000-00-00 00:00:00' then ((`P`.`CRD` + interval (`T`.`PPBoardSpalte_Rot` + 10) week) + interval -(2) day) else `T`.`ErlBis` end) AS `DateMilestone`,'0000-00-00 00:00:00' AS `DateMilestone1`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`Bemerkung` AS `Bemerkung`,`P`.`CRD` AS `CRD`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from ((((((`v_CRD` `P` join `v_TerminlisteFIX` `T` on((`P`.`PPProduktpass_Id` = `T`.`PPTermineChanges_PPProduktpass_Id`))) left join `PPMitarbeiter` `PM1` on((`PM1`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `PM2` on((`PM2`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPMitarbeiter` `PM3` on((`PM3`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `PM4` on((`PM4`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MA` on((`T`.`PPMitarbeiter_Kuerzel` = `MA`.`PPMitarbeiter_Kuerzel`))) where (length(`P`.`PPProduktpass_IAN`) = 6);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlistePP_2PLAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlistePP_2PLAN` AS select `T`.`Type` AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,`T`.`PPTermineChanges_Id` AS `PPTermineChanges_Id`,`T`.`PPTermineChanges_PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermineChanges_PPProduktpass_Id` AS `PPTermineChanges_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,`MA`.`PPMitarbeiter_Taetigkeit` AS `PPMitarbeiter_Taetigkeit`,`T`.`PPTermineChanges_Categorie` AS `PPTermineChanges_Categorie`,`T`.`PPTermineChanges_DoUntil` AS `PPTermineChanges_DoUntil`,`T`.`PPTermineChanges_DoneAt` AS `PPTermineChanges_DoneAt`,`P`.`PPProduktpass_Id` AS `PPProduktpass_Id`,`P`.`PPProduktpass_IAN` AS `PPProduktpass_IAN`,left(`P`.`PPProduktpass_Ausmusterungnummer`,4) AS `PPProduktpass_Ausmusterungnummer`,`P`.`PPProduktpass_Liefertermin` AS `PPProduktpass_Liefertermin`,`P`.`PPProduktpass_LieferterminJahr` AS `PPProduktpass_LieferterminJahr`,`P`.`PPProduktpass_Artikelbezeichnung` AS `PPProduktpass_Artikelbezeichnung`,`P`.`PPProduktpass_PPProjekte_Projekt` AS `PPProduktpass_PPProjekte_Projekt`,`P`.`PPProduktpass_PMAdmin` AS `PPProduktpass_PMAdmin`,`P`.`PPProduktpass_PMAdminVTR` AS `PPProduktpass_PMAdminVTR`,`PM1`.`PPMitarbeiter_Kuerzel` AS `PM_Vtr`,`PM3`.`PPMitarbeiter_Kuerzel` AS `PM`,`P`.`PPProduktpass_TCAdmin` AS `PPProduktpass_TCAdmin`,`P`.`PPProduktpass_TCAdminVTR` AS `PPProduktpass_TCAdminVTR`,`PM2`.`PPMitarbeiter_Kuerzel` AS `TC_Vtr`,`PM4`.`PPMitarbeiter_Kuerzel` AS `TC`,`P`.`PPProduktpass_Status` AS `PPProduktpass_Status`,`P`.`InternerStatus` AS `InternerStatus`,`T`.`Status` AS `PPTermine_Status`,`P`.`PPProduktpass_CRDWoche` AS `PPProduktpass_CRDWoche`,`P`.`PPProduktpass_CRDJahr` AS `PPProduktpass_CRDJahr`,`T`.`Background` AS `Background`,`T`.`OKStatus` AS `PPStati_OKStatus`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,(case `T`.`ErlBis` when '0000-00-00 00:00:00' then ((`P`.`CRD` + interval (`T`.`PPBoardSpalte_Rot` + 10) week) + interval -(2) day) else `T`.`ErlBis` end) AS `DateMilestone`,'0000-00-00 00:00:00' AS `DateMilestone1`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,`T`.`Bemerkung` AS `Bemerkung`,`P`.`CRD` AS `CRD`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from ((((((`v_CRD` `P` join `v_TerminlistePLAN` `T` on((`P`.`PPProduktpass_Id` = `T`.`PPTermineChanges_PPProduktpass_Id`))) left join `PPMitarbeiter` `PM1` on((`PM1`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdminVTR`))) left join `PPMitarbeiter` `PM2` on((`PM2`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdminVTR`))) left join `PPMitarbeiter` `PM3` on((`PM3`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_PMAdmin`))) left join `PPMitarbeiter` `PM4` on((`PM4`.`PPMitarbeiter_Id` = `P`.`PPProduktpass_TCAdmin`))) left join `PPMitarbeiter` `MA` on((`T`.`PPMitarbeiter_Kuerzel` = `MA`.`PPMitarbeiter_Kuerzel`))) where (length(`P`.`PPProduktpass_IAN`) = 6);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteT`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteT` AS select 'T' AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,0 AS `PPTermineChanges_Id`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,'Hauptaufgabe' AS `Hauptaufgabe`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPStati_Status` AS `PPStati_Status`,`T`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`T`.`PPStati_Background` AS `PPStati_Background`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,'' AS `Bemerkung`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,(case `T`.`PPTermine_DatumStart` when '0000-00-00 00:00:00' then `T`.`PPTermine_ManSollDate` else `T`.`PPTermine_DatumStart` end) AS `ErlBis`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_Termine` `T`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteTFIX`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteTFIX` AS select 'T' AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,0 AS `PPTermineChanges_Id`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,'Hauptaufgabe' AS `Hauptaufgabe`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPStati_Status` AS `PPStati_Status`,`T`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`T`.`PPStati_Background` AS `PPStati_Background`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,'' AS `Bemerkung`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,(case `T`.`PPTermine_DatumStart` when '0000-00-00 00:00:00' then `T`.`PPTermine_ManSollDate` else `T`.`PPTermine_DatumStart` end) AS `ErlBis`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_Termine` `T` where `T`.`PPTermine_PPProduktpass_Id` in (select `tPPProduktpass`.`PPProduktpass_Id` from `tPPProduktpass` where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))) and (`tPPProduktpass`.`InternerStatus` = 'FIX')));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteTII`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteTII` AS select 'T' AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,0 AS `PPTermineChanges_Id`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,'Hauptaufgabe' AS `Hauptaufgabe`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPStati_Status` AS `PPStati_Status`,`T`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`T`.`PPStati_Background` AS `PPStati_Background`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,'' AS `Bemerkung`,`T`.`ErlBis` AS `ErlBis`,`T`.`CRD` AS `CRD`,`T`.`ErlBisDefault` AS `ErlBisDefault` from `v_TermineII` `T`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_TerminlisteTPLAN`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_TerminlisteTPLAN` AS select 'T' AS `Type`,`T`.`PPBoardSpalte_Bezeichnung` AS `PPBoardSpalte_Bezeichnung`,0 AS `PPTermineChanges_Id`,`T`.`PPTermine_Id` AS `PPTermine_Id`,`T`.`PPTermine_PPProduktpass_Id` AS `PPTermine_PPProduktpass_Id`,`T`.`PPMitarbeiter_Kuerzel` AS `PPMitarbeiter_Kuerzel`,'Hauptaufgabe' AS `Hauptaufgabe`,`T`.`PPTermine_DatumStart` AS `PPTermine_DatumStart`,`T`.`PPTermine_DatumEnde` AS `PPTermine_DatumEnde`,`T`.`PPStati_Status` AS `PPStati_Status`,`T`.`PPStati_OKStatus` AS `PPStati_OKStatus`,`T`.`PPStati_Background` AS `PPStati_Background`,`T`.`PPBoardSpalte_Orange` AS `PPBoardSpalte_Orange`,`T`.`PPBoardSpalte_Rot` AS `PPBoardSpalte_Rot`,`T`.`PPBoardSpalte_Oberbez` AS `PPBoardSpalte_Oberbez`,`T`.`PPTermine_ManSoll` AS `PPTermine_ManSoll`,`T`.`PPTermine_PPBoardSpalte_id` AS `PPTermine_PPBoardSpalte_id`,'' AS `Bemerkung`,`T`.`PPTermine_ManSollDate` AS `PPTermine_ManSollDate`,(case `T`.`PPTermine_DatumStart` when '0000-00-00 00:00:00' then `T`.`PPTermine_ManSollDate` else `T`.`PPTermine_DatumStart` end) AS `ErlBis`,`T`.`PPTermine_Label` AS `PPTermine_Label`,`T`.`PPTermine_Bemerkungen` AS `PPTermine_Bemerkungen`,`T`.`PPTermine_LabelEN` AS `PPTermine_LabelEN`,`T`.`PPTermine_BemerkungenEN` AS `PPTermine_BemerkungenEN` from `v_Termine` `T` where `T`.`PPTermine_PPProduktpass_Id` in (select `tPPProduktpass`.`PPProduktpass_Id` from `tPPProduktpass` where ((not((`tPPProduktpass`.`PPProduktpass_IAN` like '%rev%'))) and ((`tPPProduktpass`.`InternerStatus` = 'MUSTERUNG') or (`tPPProduktpass`.`InternerStatus` = 'PLAN'))));
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_USDBedarfnachMonaten`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_USDBedarfnachMonaten` AS select (`PO`.`EKUsdKum` * -(1)) AS `UsdKum`,`PO`.`Monat` AS `Monat`,`PO`.`Jahr` AS `Jahr` from `v_POWertNachMonatenKummuliert` `PO` union select `DTK`.`DTK_Betrag` AS `DTK_Betrag`,`DTK`.`DTK_Monat` AS `DTK_Monat`,`DTK`.`DTK_Jahr` AS `DTK_Jahr` from `v_DTKNachMonaten` `DTK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_USDUngedeckt`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_USDUngedeckt` AS select sum(`v_USDBedarfnachMonaten`.`UsdKum`) AS `USDUngedeckt`,`v_USDBedarfnachMonaten`.`Monat` AS `Monat`,`v_USDBedarfnachMonaten`.`Jahr` AS `Jahr` from `v_USDBedarfnachMonaten` group by `v_USDBedarfnachMonaten`.`Jahr`,`v_USDBedarfnachMonaten`.`Monat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ZuAbgang`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ZuAbgang` AS select `v_Liquiditaet`.`IAN` AS `IAN`,`v_Liquiditaet`.`PPId` AS `PPProduktpass_Id`,`v_Liquiditaet`.`TOP` AS `TOP`,year(`v_Liquiditaet`.`ZahlungKunde`) AS `ZugangJahr`,month(`v_Liquiditaet`.`ZahlungKunde`) AS `ZugangMonat`,`v_Liquiditaet`.`ZahlungKunde` AS `ZahlungKunde`,`v_Liquiditaet`.`VKGesamt` AS `VKGesamt`,year(`v_Liquiditaet`.`Faelligkeit`) AS `AbgangJahr`,month(`v_Liquiditaet`.`Faelligkeit`) AS `AbgangMonat`,`v_Liquiditaet`.`Faelligkeit` AS `Faelligkeit`,`v_Liquiditaet`.`EKGesamt` AS `EKGesamt`,`v_Liquiditaet`.`EKWaehrung` AS `EKWaehrung`,year(`v_Liquiditaet`.`LCEroeffnung`) AS `AbgangLCJahr`,month(`v_Liquiditaet`.`LCEroeffnung`) AS `AbgangLCMonat` from `v_Liquiditaet`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ZuAbgangDTK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ZuAbgangDTK` AS select `P`.`PPPerioden_Jahr` AS `Jahr`,`P`.`PPPerioden_Monat` AS `Monat`,sum(`PPDevisenTerminKaeufe`.`PPDevisenTerminKaeufe_Betrag`) AS `ZugangUSD`,sum((`PPDevisenTerminKaeufe`.`PPDevisenTerminKaeufe_Betrag` / `PPDevisenTerminKaeufe`.`PPDevisenTerminKaeufe_Kurs`)) AS `AbgangEUR` from (`PPPerioden` `P` left join `PPDevisenTerminKaeufe` on(((`P`.`PPPerioden_Jahr` = year(`PPDevisenTerminKaeufe`.`PPDevisenTerminKaeufe_Termin`)) and (`P`.`PPPerioden_Monat` = month(`PPDevisenTerminKaeufe`.`PPDevisenTerminKaeufe_Termin`))))) group by `P`.`PPPerioden_Jahr`,`P`.`PPPerioden_Monat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_ZugangVK`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_ZugangVK` AS select sum(`v_ZuAbgang`.`VKGesamt`) AS `Zugang`,`v_ZuAbgang`.`ZugangJahr` AS `ZugangJahr`,`v_ZuAbgang`.`ZugangMonat` AS `ZugangMonat` from `v_ZuAbgang` group by `v_ZuAbgang`.`ZugangJahr`,`v_ZuAbgang`.`ZugangMonat`,`v_ZuAbgang`.`AbgangJahr`,`v_ZuAbgang`.`AbgangMonat`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_lastStatusChange`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_lastStatusChange` AS select `x`.`IAN` AS `IAN`,`x`.`Charge` AS `Charge`,`x`.`Aenderung` AS `Aenderung`,`x`.`DatumStatusAenderung` AS `DatumStatusAenderung`,`x`.`Alter_Status` AS `Alter_Status`,`x`.`Neuer_Status` AS `Neuer_Status`,`x`.`Mitarbeiter` AS `Mitarbeiter` from (select right(`PPLog`.`PPLog_Typ`,6) AS `IAN`,substr(`PPLog`.`PPLog_Typ`,23,4) AS `Charge`,`PPLog`.`PPLog_Typ` AS `Aenderung`,`PPLog`.`PPLog_Date` AS `DatumStatusAenderung`,`PPLog`.`PPLog_Old` AS `Alter_Status`,`PPLog`.`PPLog_New` AS `Neuer_Status`,`PPLog`.`PPLog_User` AS `Mitarbeiter`,row_number() OVER (PARTITION BY right(`PPLog`.`PPLog_Typ`,6),substr(`PPLog`.`PPLog_Typ`,23,4) ORDER BY `PPLog`.`PPLog_Date` desc,`PPLog`.`PPLog_Id` desc )  AS `rn` from `PPLog` where (`PPLog`.`PPLog_Typ` like '%[%')) `x` where (`x`.`rn` = 1);
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
DROP VIEW IF EXISTS `v_offeneTermineMitMa`;
TARGA_BASELINE_SQL,
            <<<'TARGA_BASELINE_SQL'
CREATE ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `v_offeneTermineMitMa` AS select `PPTermine`.`PPTermine_Id` AS `PPTermine_Id`,`PPTermine`.`PPTermine_MAZustaendigkeit` AS `PPTermine_MAZustaendigkeit`,`PPBoardSpalteData`.`PPBoardSpalteData_Kind` AS `PPBoardSpalteData_Kind` from ((`PPTermine` join `PPStati` on((`PPTermine`.`PPTermine_Status` = `PPStati`.`PPStati_Status`))) join `PPBoardSpalteData` on((`PPBoardSpalteData`.`PPBoardSpalte_Id` = `PPTermine`.`PPTermine_PPBoardSpalte_id`))) where (`PPStati`.`PPStati_OKStatus` <> 1);
TARGA_BASELINE_SQL
        ];
    }

    /** @return list<string> */
    private function viewNames(): array
    {
        return [
            'v_offeneTermineMitMa',
            'v_lastStatusChange',
            'v_ZugangVK',
            'v_ZuAbgangDTK',
            'v_ZuAbgang',
            'v_USDUngedeckt',
            'v_USDBedarfnachMonaten',
            'v_TerminlisteTPLAN',
            'v_TerminlisteTII',
            'v_TerminlisteTFIX',
            'v_TerminlisteT',
            'v_TerminlistePP_2PLAN',
            'v_TerminlistePP_2FIX',
            'v_TerminlistePP_2',
            'v_TerminlistePP',
            'v_TerminlistePLAN',
            'v_TerminlisteMU',
            'v_TerminlisteInq',
            'v_TerminlisteII',
            'v_TerminlisteFIX',
            'v_TerminlisteC',
            'v_Terminliste',
            'v_TermineMitChanges',
            'v_TermineII',
            'v_TermineAll',
            'v_Termine',
            'v_TerminSpalten',
            'v_TempPPLiefertermine',
            'v_StyleSizeAndWeight',
            'v_SortierungOrderWeights',
            'v_ShipmentoverviewShipments',
            'v_ShipmentoverviewKopf',
            'v_Shipmentoverview',
            'v_ServiceAnfrage',
            'v_QualitaetDistinct',
            'v_QualitaetAnlage',
            'v_QMBerechnung',
            'v_QM4Inquiry',
            'v_PurchaseWerte',
            'v_PurchaseLast',
            'v_PurchaseDistinct',
            'v_ProjekteIan',
            'v_PreisgruppenHafen',
            'v_PPUebersicht',
            'v_PPTerminePopUp',
            'v_PPTCKosten',
            'v_PPStyleHeader',
            'v_PPProduktpass_PPTermineZ1',
            'v_PPProduktpass_PPTermine2',
            'v_PPProduktpass_PPTermine',
            'v_PPProduktpassReal',
            'v_PPPU',
            'v_PPMengen',
            'v_POinFW',
            'v_POWertNachMonatenKummuliert',
            'v_POWertNachMonaten',
            'v_PO',
            'v_OWLsvOLsv',
            'v_OWLsv',
            'v_OSSortierung',
            'v_OSLieferlaender',
            'v_MitarbeiterProjekt',
            'v_MilestonesShipmentoverview',
            'v_Milestones',
            'v_MengenSpanien',
            'v_MESTotal',
            'v_MESPP',
            'v_MESOLsv',
            'v_MES',
            'v_LotLaendermengen',
            'v_LotHafenmengen',
            'v_Liquiditaet',
            'v_LiqZuflussPeriodeEUR',
            'v_LiqLaenderEKVK',
            'v_LiqLaenderEK',
            'v_LiqLCuebersichtPeriodenUSD',
            'v_LiqLCuebersichtPeriodenEUR',
            'v_LiqLCNNE',
            'v_LiqLCE',
            'v_LiqAblussPeriodeUSD',
            'v_LiqAblussPeriodeEUR',
            'v_LiqAbflussPeriode',
            'v_LinkedItems',
            'v_Lieferlaender',
            'v_LatestServiceAnfrage',
            'v_Laendermengen',
            'v_Laendergesamtmengen',
            'v_LTMengenJeHafen',
            'v_LCEroeffnungenPeriodeKUM',
            'v_LCEroeffnungenPeriode',
            'v_KursReal',
            'v_IsUSOrderPP',
            'v_IsUSOrder',
            'v_IANReal',
            'v_GedecktePO',
            'v_GTINWeightsPerStyle',
            'v_FilesSub',
            'v_FilesDistinct',
            'v_FilesAll',
            'v_FileProtokoll',
            'v_FileDoubletten',
            'v_ESSortierungOrderWeights',
            'v_ESSortierungKI',
            'v_EANTest1',
            'v_EANTest',
            'v_DTKmitZuordung',
            'v_DTKmitWerten',
            'v_DTKUngedeckt',
            'v_DTKUebersicht',
            'v_DTKNachMonaten',
            'v_DTKGebunden',
            'v_DTKAssign',
            'v_DBUebersicht',
            'v_CountSharepointFiles',
            'v_CountLocalFiles',
            'v_CRD',
            'v_BuHaWareneinsatz',
            'v_AuftragsUebersicht',
            'v_Assortment',
            'v_AssortOWLsvOLsv',
            'v_AssortOWLsv',
            'v_AltgeraeteES',
            'v_AbgangEK',
            'vXML_Converter',
            'vPPwithDiffrentKolli',
            'vMehrwertsteuer',
            'vLastRevPP',
            'vLagerliste',
            'vAktRev',
            'tmp_testLastCahnge',
            'test_ServiceAnfrage_IAN',
            'test_IAN_ohne_ServiceAnfrage',
            'tMaxFiles',
            'tFiles2',
            'tFiles1',
            'rpt_hvZollGewichteGTIN',
            'rpt_hvMengenStationaer',
            'rpt_hvLaendermengen',
            'rpt_hvLSVs',
            'rpt_hvBestelluebersichtStationaer',
            'rpt_hvBestelluebersichtOnlineshops',
            'rpt_check_PM_TC_PJM_Assignment_Error',
            'rpt_check_PM_TC_Assignment_Error',
            'rpt_check_PM_TC_Assignment',
            'rpt_ZolltarifRegeln',
            'rpt_UserLoginCount',
            'rpt_UserLogin',
            'rpt_StatSPOUpload',
            'rpt_Shipments',
            'rpt_PruefplanVorhanden',
            'rpt_ProjektMitBattrien',
            'rpt_Produktpass_Save',
            'rpt_ProduktpassPruefplan',
            'rpt_ProduktpassMMI',
            'rpt_Produktpass',
            'rpt_ProduktMenge',
            'rpt_LaendermengenUebersicht',
            'rpt_Laendergewichte_II',
            'rpt_Laendergewichte_Alternativ',
            'rpt_LaendergewichteFKE',
            'rpt_Laendergewichte',
            'rpt_Co2Thumbprint',
            'new_view',
            'lageruebersicht',
            'lagerbestand',
            'hv_hasBattery',
            'hv_assortment',
            'hv_asortment',
            'hv_OrderWeights',
            'hv_IANMengen',
            'hv_GTINWeightsLSV',
            'hv_CountryGTIN',
            'cSortierungDistinct',
            'XMLConverter',
            'PPProduktpassOrg',
            'PPProduktpass',
            'PPMusterung',
            'PPLaenderbloecke',
            'PPInquiry',
            'PPHerkunftslaenderPPAB',
            'PPBoardSpalte',
            'KDGR',
            'BuHa_ZollRP',
            'BuHa_UebergabeCSV',
            'BuHa_Uebergabe',
            'BuHa_RP',
            'BuHa_PosTotal',
            'BuHa_EingangsfrachtRP',
            'BuHa_BestandAbgang',
            'BuHa_Belege',
            'BuHa_AusgangsfrachtRP',
            'BuHaWareneinsatz',
            'ArtikelMitBestand',
            '8WMuster'
        ];
    }

    /** @return list<string> */
    private function tableNames(): array
    {
        return [
            'zkd',
            'usersX',
            'users',
            'tmpPPLsv',
            'test_tabelle_keine_view',
            'tPPProduktpass',
            'retailPackaging',
            'protokoll',
            'password_resets',
            'login_attempt',
            'lagerbewegungen',
            'kundenartikeldaten',
            'konten',
            'jobs',
            'job_progress',
            'cpcincoterms',
            'belegnummern',
            'belegepositionen',
            'belege',
            'belegarten',
            'artikeltexte',
            'artikelstamm',
            'adressen',
            'XPPProduktpass',
            'XMLConverterMitVersion',
            'Vorlauf_Musterung',
            'Translations',
            'ThemaArtikel',
            'Thema',
            'StrukturSKR03',
            'Steuerschluessel',
            'Steuersatz',
            'SammelkontenSKR03',
            'SKR03',
            'RestrictedZolltarif',
            'Reports',
            'Rechnungsprüfung',
            'PreisblattFracht',
            'Parameter',
            'PPZahlungen',
            'PPXML_OSMengen',
            'PPXML_Mengen',
            'PPXMLNodes',
            'PPWarengruppeNotice',
            'PPUserSettings',
            'PPTranslateGUI',
            'PPThema',
            'PPTextbausteineProjekte',
            'PPTextbausteine',
            'PPTerms',
            'PPTermineSave',
            'PPTermineMusterung',
            'PPTermineHistory',
            'PPTermineChanges',
            'PPTermineAnhaenge',
            'PPTermine',
            'PPTempQualitaet',
            'PPTaetigkeiten',
            'PPTCKostenTypen',
            'PPTCKosten',
            'PPStatiX',
            'PPStati',
            'PPShipment',
            'PPRetail',
            'PPPurchaseDTK',
            'PPPurchase',
            'PPProtokoll',
            'PPProjekte',
            'PPProduktpass_Style',
            'PPProduktpass_Sortierung',
            'PPProduktpass_Qualitaet',
            'PPProduktpass_OSSortMengen',
            'PPProduktpass_Menge_Final',
            'PPProduktpass_Menge',
            'PPProduktpass_KLLink',
            'PPProduktpass_Intern',
            'PPPerioden',
            'PPPPFiles',
            'PPOrderWeights',
            'PPOrder',
            'PPMitarbeiter',
            'PPMengenUebersichtLaender',
            'PPMeetingprotokollTeilnehmer',
            'PPMeetingprotokoll',
            'PPLsvORG',
            'PPLsv',
            'PPLog',
            'PPListBoxes',
            'PPLieferavis_Material',
            'PPLieferavis_MARM',
            'PPLieferavis_Container_Content',
            'PPLieferavis_Container',
            'PPLieferavis_BOL',
            'PPLieferavis',
            'PPLidlQualitaetsarten',
            'PPLaenderbloeckeMitVersion',
            'PPLaenderaufteilung',
            'PPLC',
            'PPKategorien',
            'PPInquiryDiff',
            'PPInputManuell',
            'PPImport_Excel_Data',
            'PPImport_Excel',
            'PPImport_Definitions',
            'PPImport_Definition_Rows',
            'PPImport_Definition_Fields',
            'PPHerkunftslaender',
            'PPHaefen',
            'PPFileTypes',
            'PPDiff',
            'PPDictionary',
            'PPDevisenTerminKaeufe',
            'PPCountrySizes',
            'PPContainerVerschiffungen',
            'PPCalculation',
            'PPBoardSpalte_SAVE',
            'PPBoardSpalteX',
            'PPBoardSpalteData_DEV',
            'PPBoardSpalteData',
            'PPBoard',
            'PPBatchtermine',
            'PPBW_Laendergroessen',
            'PPAssortments',
            'PPAssortmentStyles',
            'PPAdressen',
            'PPAdressarten',
            'PPAbgangshafen',
            'PPAB',
            'PP8WMuster',
            'Nummernkreise',
            'MoeglicheLieferanten',
            'MPPlan',
            'LoadJeProduzent',
            'Load',
            'Lagerplatzbuchungen',
            'Lagerbewegungsarten',
            'Kundengruppen',
            'Kostenarten',
            'KostenContainer',
            'Kalkulationskurs',
            'Inquiry_Rechenmenge',
            'ISOLaender',
            'Files',
            'EAN_Nummern',
            'EAN_Basisnummern',
            'BISUser',
            'AvisPositionen',
            'AvisKopf',
            'AusmusterungStamm'
        ];
    }
};
