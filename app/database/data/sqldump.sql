

 Server: 127.0.0.3 -  Datenbank: db300310_30 

-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.3
-- Erstellungszeit: 04. Februar 2015 um 16:49
-- Server Version: 5.6.19
-- PHP-Version: 4.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `db300310_30`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Adress`
--

CREATE TABLE `Adress` (
  `AdressIdent` int(11) NOT NULL AUTO_INCREMENT,
  `Besitzer` varchar(40) DEFAULT NULL,
  `Name` varchar(40) DEFAULT NULL,
  `Vorname` varchar(40) DEFAULT NULL,
  `PrivartStrasse` varchar(60) DEFAULT NULL,
  `PrivatLand` char(3) DEFAULT NULL,
  `PrivatPLZ` varchar(8) DEFAULT NULL,
  `PrivatOrt` varchar(40) DEFAULT NULL,
  `PrivatTelefon` varchar(25) DEFAULT NULL,
  `PrivatTelefax` varchar(25) DEFAULT NULL,
  `PrivatMobile` varchar(25) DEFAULT NULL,
  `PrivatEmail` varchar(80) DEFAULT NULL,
  `DienstFirma1` varchar(40) DEFAULT NULL,
  `DienstFirma2` varchar(40) DEFAULT NULL,
  `DienstStrasse` varchar(60) DEFAULT NULL,
  `DienstLand` char(3) DEFAULT NULL,
  `DienstPLZ` varchar(8) DEFAULT NULL,
  `DienstOrt` varchar(40) DEFAULT NULL,
  `DienstPostfach` varchar(10) DEFAULT NULL,
  `DienstPostfachPLZ` varchar(8) DEFAULT NULL,
  `DienstTelefon` varchar(25) DEFAULT NULL,
  `DienstTelefax` varchar(25) DEFAULT NULL,
  `DienstMobile` varchar(25) DEFAULT NULL,
  `DienstEmail` varchar(80) DEFAULT NULL,
  `DienstWeb` varchar(40) DEFAULT NULL,
  `Bemerkung` varchar(250) DEFAULT NULL,
  `Kategorie` varchar(20) DEFAULT NULL,
  `ZopeUser` varchar(30) NOT NULL DEFAULT 'NO ZOPE USER',
  `SafetyCat` tinyint(4) NOT NULL DEFAULT '0',
  `AktivStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `password` varchar(50) NOT NULL,
  `PW_Periode` int(11) NOT NULL,
  `PW_Lastchange` date NOT NULL,
  PRIMARY KEY (`AdressIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Artikel`
--

CREATE TABLE `Artikel` (
  `Artikelnummer` varchar(20) DEFAULT NULL,
  `Verkaufsmengeneinheit` varchar(4) DEFAULT NULL,
  `Bezeichnung1` varchar(40) DEFAULT NULL,
  `Bezeichnung2` varchar(40) DEFAULT NULL,
  `Lagerbestand` int(11) DEFAULT NULL,
  `KalkulatorischerEK` decimal(10,2) DEFAULT NULL,
  `Artikelgruppe` varchar(80) DEFAULT NULL,
  `EANNummer` varchar(20) DEFAULT NULL,
  `USER_PHLagercode` varchar(80) DEFAULT NULL,
  `USER_Stellplatz` varchar(10) DEFAULT NULL,
  `BilderAnzahl` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPAddon`
--

CREATE TABLE `PPAddon` (
  `PPKopf_Refnumber` varchar(20) NOT NULL,
  `pic1` varchar(200) NOT NULL DEFAULT 'leer',
  `picDesc1` varchar(200) NOT NULL,
  `pic2` varchar(200) NOT NULL DEFAULT 'leer',
  `picDesc2` varchar(200) NOT NULL,
  `pic3` varchar(200) NOT NULL DEFAULT 'leer',
  `picDesc3` varchar(200) NOT NULL,
  `pic4` varchar(200) NOT NULL DEFAULT 'leer',
  `picDesc4` varchar(200) NOT NULL,
  `pic5` varchar(200) NOT NULL DEFAULT 'leer',
  `picDesc5` varchar(200) NOT NULL,
  `pic6` varchar(200) NOT NULL DEFAULT 'leer',
  `picDesc6` varchar(200) NOT NULL,
  `ReqText1` varchar(250) NOT NULL DEFAULT 'Minimum requirements according to Ökotex',
  `ReqText2` varchar(250) NOT NULL DEFAULT 'shrinkage line drying max 4%, Tumbler drying max 4%',
  `Req1` varchar(50) NOT NULL DEFAULT '4-5',
  `Req2` varchar(50) NOT NULL DEFAULT '3-4',
  `Req3` varchar(50) NOT NULL DEFAULT '3-4',
  `Req4` varchar(50) NOT NULL DEFAULT '4',
  `Req5` varchar(50) NOT NULL DEFAULT '4',
  `Req6` varchar(50) NOT NULL DEFAULT '3-4',
  `Req7` varchar(50) NOT NULL DEFAULT '3-4',
  `Req8` varchar(50) NOT NULL DEFAULT '2-3',
  `Req9` varchar(50) NOT NULL,
  `Req10` varchar(50) NOT NULL,
  `AddCostLabel1` varchar(100) NOT NULL,
  `AddCostValue1` varchar(200) NOT NULL,
  `AddCostLabel2` varchar(100) NOT NULL,
  `AddCostValue2` varchar(200) NOT NULL,
  `AddCostLabel3` varchar(100) NOT NULL,
  `AddCostValue3` varchar(200) NOT NULL,
  `AddCostLabel4` varchar(100) NOT NULL,
  `AddCostValue4` varchar(200) NOT NULL,
  `ShipmentInformation` blob NOT NULL,
  `Orderremark` blob NOT NULL,
  `CartonWeightSize` blob NOT NULL,
  `Req1Text` varchar(100) NOT NULL,
  `Req2Text` varchar(100) NOT NULL,
  `Req3Text` varchar(100) NOT NULL,
  `Req4Text` varchar(100) NOT NULL,
  `Req5Text` varchar(100) NOT NULL,
  `Req6Text` varchar(100) NOT NULL,
  `Req7Text` varchar(100) NOT NULL,
  `Req8Text` varchar(100) NOT NULL,
  `Req9Text` varchar(100) NOT NULL,
  `Req10Text` varchar(100) NOT NULL,
  UNIQUE KEY `PPKopf_Refnumber` (`PPKopf_Refnumber`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPAdressen`
--

CREATE TABLE `PPAdressen` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Art` char(3) NOT NULL DEFAULT 'S',
  `Firma1` varchar(250) NOT NULL,
  `Firma2` varchar(250) NOT NULL DEFAULT ' ',
  `Ansprechpartner` varchar(250) NOT NULL DEFAULT ' ',
  `Adresse1` varchar(250) NOT NULL,
  `Adresse2` varchar(250) NOT NULL DEFAULT ' ',
  `Matchcode` varchar(250) NOT NULL,
  `PLZ` varchar(50) NOT NULL,
  `Ort` varchar(250) NOT NULL,
  `Postfach` varchar(250) NOT NULL DEFAULT ' ',
  `Land` varchar(250) NOT NULL DEFAULT ' ',
  `Telefon` varchar(250) NOT NULL DEFAULT ' ',
  `Fax` varchar(250) NOT NULL DEFAULT ' ',
  `email` varchar(250) NOT NULL DEFAULT ' ',
  `web` varchar(250) NOT NULL DEFAULT ' ',
  `delcredere` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=227 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPChangesConfirm`
--

CREATE TABLE `PPChangesConfirm` (
  `AdressIdent` bigint(20) NOT NULL,
  `ProtokollIdent` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPEmail`
--

CREATE TABLE `PPEmail` (
  `EmailIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(10) DEFAULT NULL,
  `AdressIdent` int(11) DEFAULT NULL,
  PRIMARY KEY (`EmailIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22655 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPGroup`
--

CREATE TABLE `PPGroup` (
  `GroupName` varchar(50) NOT NULL,
  `GroupMember` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPImport_Definition`
--

CREATE TABLE `PPImport_Definition` (
  `PPImport_Definition_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPImport_Definition_Table` varchar(255) NOT NULL,
  `PPImport_Definition_Mode` varchar(50) NOT NULL,
  `PPImport_Definition_Startrow` bigint(20) NOT NULL,
  `PPImport_Definition_Endrow` bigint(20) NOT NULL,
  `PPImport_Definition_Sheetname` varchar(250) NOT NULL,
  PRIMARY KEY (`PPImport_Definition_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPImport_Definition_Fields`
--

CREATE TABLE `PPImport_Definition_Fields` (
  `PPImport_Definition_Id2` bigint(20) NOT NULL,
  `PPImport_Definition_Fields_Field` varchar(100) NOT NULL,
  `PPImport_Definition_Fields_Sheet` varchar(100) NOT NULL,
  `PPImport_Definition_Fields_Row` bigint(20) NOT NULL,
  `PPImport_Definition_Fields_Col` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPImport_Definition_Row`
--

CREATE TABLE `PPImport_Definition_Row` (
  `PPImport_Definition_Id1` bigint(20) NOT NULL,
  `PPImport_Definition_Row_Field` varchar(100) NOT NULL,
  `PPImport_Definition_Row_Col` varchar(4) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPImport_Excel`
--

CREATE TABLE `PPImport_Excel` (
  `PPImort__Excel_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPImport_Excel_Datum` datetime NOT NULL,
  `PPImport_Excel_Dateiname` varchar(255) NOT NULL,
  PRIMARY KEY (`PPImort__Excel_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPImport_Excel_Data`
--

CREATE TABLE `PPImport_Excel_Data` (
  `PPImport_Excel_Data_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPImport_Excel_Data_Filename` varchar(250) NOT NULL,
  `PPImport_Excel_Data_Sheet` varchar(250) NOT NULL,
  `PPImport_Excel_Data_Row` bigint(20) NOT NULL,
  `PPImport_Excel_Data_Col` varchar(4) NOT NULL,
  `PPImport_Excel_Data_Value` varchar(2500) NOT NULL,
  PRIMARY KEY (`PPImport_Excel_Data_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5746 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPKopf`
--

CREATE TABLE `PPKopf` (
  `RefNumber` varchar(10) DEFAULT NULL,
  `LcNumber` varchar(40) DEFAULT NULL,
  `ScNumber` varchar(20) DEFAULT NULL,
  `FormerInquiry` varchar(10) DEFAULT NULL,
  `Supplier` varchar(25) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `exch_save` varchar(20) DEFAULT NULL,
  `exch_save_art` varchar(5) DEFAULT NULL,
  `CustomsCode` varchar(30) DEFAULT NULL,
  `Customer` varchar(50) DEFAULT NULL,
  `DutyPercentage` decimal(6,2) DEFAULT NULL,
  `DeliveryDate` varchar(25) DEFAULT NULL,
  `ResOffice` varchar(25) NOT NULL DEFAULT 'N.N.',
  `QuotaNecessarily` char(3) DEFAULT NULL,
  `QuotaCategory` varchar(20) DEFAULT '',
  `Description` blob,
  `Material` blob,
  `Remark` blob,
  `TermsOfDelivery` varchar(70) DEFAULT NULL,
  `TermsOfPayment` varchar(70) NOT NULL,
  `PackType` varchar(25) DEFAULT NULL,
  `PackDescription` blob,
  `PackText` varchar(250) DEFAULT NULL,
  `SamplesRequired` char(3) DEFAULT NULL,
  `SamplesEta` varchar(10) DEFAULT NULL,
  `SamplesRemark` blob,
  `Photoinlet` varchar(25) DEFAULT NULL,
  `Polybag` varchar(25) DEFAULT NULL,
  `WovenLabel` varchar(25) DEFAULT NULL,
  `Stickers` varchar(25) DEFAULT NULL,
  `WashingSymbols` varchar(80) DEFAULT NULL,
  `Temperature` varchar(50) DEFAULT NULL,
  `Triangle` varchar(25) DEFAULT NULL,
  `Iron` varchar(25) DEFAULT NULL,
  `Circle` varchar(25) DEFAULT NULL,
  `Tumbler` varchar(25) DEFAULT NULL,
  `CartonMarks` blob,
  `CartonMarks2` blob,
  `CartonMarks3` blob,
  `Archive` int(11) NOT NULL DEFAULT '0',
  `PPStatus` varchar(10) DEFAULT '0',
  `License` varchar(40) DEFAULT NULL,
  `PortOfDischarge` varchar(50) NOT NULL DEFAULT '',
  `Country` varchar(20) NOT NULL DEFAULT '',
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `OrderDate` varchar(50) NOT NULL,
  `SupplierDelDate` varchar(200) NOT NULL,
  `Inquiry` varchar(50) NOT NULL,
  `Factory` varchar(50) NOT NULL,
  `KopfDelete` int(11) NOT NULL DEFAULT '0',
  `cust_delterm` varchar(50) NOT NULL,
  `QuantityTolerance` varchar(50) NOT NULL,
  `DeliveryAddress` bigint(20) NOT NULL,
  `QSneeded` tinyint(4) NOT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `RefNumber` (`RefNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6296 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPKopfArchiv`
--

CREATE TABLE `PPKopfArchiv` (
  `RefNumber` varchar(10) DEFAULT NULL,
  `LcNumber` varchar(40) DEFAULT NULL,
  `ScNumber` varchar(20) DEFAULT NULL,
  `FormerInquiry` varchar(10) DEFAULT NULL,
  `Supplier` varchar(25) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `exch_save` varchar(20) DEFAULT NULL,
  `exch_save_art` varchar(5) DEFAULT NULL,
  `CustomsCode` varchar(30) DEFAULT NULL,
  `Customer` varchar(50) DEFAULT NULL,
  `DutyPercentage` decimal(6,2) DEFAULT NULL,
  `DeliveryDate` varchar(25) DEFAULT NULL,
  `ResOffice` varchar(25) NOT NULL DEFAULT 'N.N.',
  `QuotaNecessarily` char(3) DEFAULT NULL,
  `QuotaCategory` varchar(20) DEFAULT '',
  `Description` blob,
  `Material` blob,
  `Remark` blob,
  `TermsOfDelivery` varchar(70) DEFAULT NULL,
  `TermsOfPayment` varchar(70) NOT NULL,
  `PackType` varchar(25) DEFAULT NULL,
  `PackDescription` blob,
  `PackText` varchar(250) DEFAULT NULL,
  `SamplesRequired` char(3) DEFAULT NULL,
  `SamplesEta` varchar(10) DEFAULT NULL,
  `SamplesRemark` blob,
  `Photoinlet` varchar(25) DEFAULT NULL,
  `Polybag` varchar(25) DEFAULT NULL,
  `WovenLabel` varchar(25) DEFAULT NULL,
  `Stickers` varchar(25) DEFAULT NULL,
  `WashingSymbols` varchar(80) DEFAULT NULL,
  `Temperature` varchar(50) DEFAULT NULL,
  `Triangle` varchar(25) DEFAULT NULL,
  `Iron` varchar(25) DEFAULT NULL,
  `Circle` varchar(25) DEFAULT NULL,
  `Tumbler` varchar(25) DEFAULT NULL,
  `CartonMarks` blob,
  `CartonMarks2` blob,
  `CartonMarks3` blob,
  `Archive` int(11) NOT NULL DEFAULT '0',
  `PPStatus` varchar(10) DEFAULT '0',
  `License` varchar(40) DEFAULT NULL,
  `PortOfDischarge` varchar(50) NOT NULL DEFAULT '',
  `Country` varchar(20) NOT NULL DEFAULT '',
  `pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `OrderDate` varchar(50) NOT NULL,
  `SupplierDelDate` varchar(200) NOT NULL,
  `Inquiry` varchar(50) NOT NULL,
  `Factory` varchar(50) NOT NULL,
  `KopfDelete` int(11) NOT NULL DEFAULT '0',
  `cust_delterm` varchar(50) NOT NULL,
  `QuantityTolerance` varchar(50) NOT NULL,
  `DeliveryAddress` bigint(20) NOT NULL,
  PRIMARY KEY (`pk`),
  UNIQUE KEY `RefNumber` (`RefNumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6082 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPLog`
--

CREATE TABLE `PPLog` (
  `Log_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Log_User` varchar(50) NOT NULL,
  `Log_Date` datetime NOT NULL,
  `Log_Typ` varchar(150) NOT NULL,
  PRIMARY KEY (`Log_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=932 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPLot`
--

CREATE TABLE `PPLot` (
  `LotIdent` int(11) NOT NULL AUTO_INCREMENT,
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL,
  `BlNumber` varchar(25) DEFAULT NULL,
  `PlannedShipmentDate` varchar(10) DEFAULT NULL,
  `LatestShipmentDate` varchar(20) DEFAULT NULL,
  `PlannedShipmentType` varchar(20) DEFAULT NULL,
  `ShippingDetails` varchar(20) DEFAULT NULL,
  `OceanVessel` varchar(50) DEFAULT NULL,
  `Eta` varchar(10) DEFAULT NULL,
  `City` varchar(25) DEFAULT NULL,
  `ForwardAgent` varchar(50) DEFAULT NULL,
  `LotDelete` char(1) DEFAULT '0',
  `LotRemark` varchar(50) DEFAULT NULL,
  `LotStatus` varchar(50) NOT NULL DEFAULT '0',
  `LotSupplierDelDate` varchar(50) NOT NULL,
  `Carrier` varchar(20) NOT NULL,
  `LotNum` int(11) NOT NULL DEFAULT '0',
  `DeliveryAddress` bigint(4) NOT NULL,
  `Warehouse` varchar(250) NOT NULL,
  PRIMARY KEY (`LotIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10994 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPOrderTotal`
--

CREATE TABLE `PPOrderTotal` (
  `OrderTotal` decimal(51,3) DEFAULT NULL,
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPPosition`
--

CREATE TABLE `PPPosition` (
  `PositionIdent` int(11) NOT NULL AUTO_INCREMENT,
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL,
  `Article` varchar(50) DEFAULT NULL,
  `CustName` varchar(25) DEFAULT NULL,
  `CustNumber` varchar(10) DEFAULT NULL,
  `VE_OLD` int(11) DEFAULT NULL,
  `Size` varchar(25) DEFAULT NULL,
  `Description` varchar(25) DEFAULT NULL,
  `Material` varchar(25) DEFAULT NULL,
  `DutyPercentage` decimal(10,2) DEFAULT NULL,
  `Price` decimal(10,3) DEFAULT NULL,
  `Currency` char(3) DEFAULT NULL,
  `Quantity1Lot` int(11) DEFAULT NULL,
  `Quantity2Lot` int(11) DEFAULT NULL,
  `Quantity3Lot` int(11) DEFAULT NULL,
  `Quantity4Lot` int(11) DEFAULT NULL,
  `Quantity5Lot` int(11) DEFAULT NULL,
  `Quantity6Lot` int(11) DEFAULT NULL,
  `Quantity7Lot` int(11) DEFAULT NULL,
  `Quantity8Lot` int(11) DEFAULT NULL,
  `Quantity9Lot` int(11) DEFAULT NULL,
  `PositionDelete` char(1) DEFAULT '0',
  `VE` varchar(15) DEFAULT NULL,
  `Bezeichnung` varchar(50) DEFAULT NULL,
  `Unit` varchar(25) NOT NULL,
  `QuantityOrder` bigint(20) NOT NULL,
  `Quantity10Lot` bigint(20) NOT NULL,
  `Quantity11Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity12Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity13Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity14Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity15Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity16Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity17Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity18Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity19Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity20Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity21Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity22Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity23Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity24Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity25Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity26Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity27Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity28Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity29Lot` bigint(20) NOT NULL DEFAULT '0',
  `Quantity30Lot` bigint(20) NOT NULL DEFAULT '0',
  `LotIdent_Lot1` smallint(6) NOT NULL,
  `LotIdent_Lot2` smallint(6) NOT NULL,
  `LotIdent_Lot3` smallint(6) NOT NULL,
  `LotIdent_Lot4` smallint(6) NOT NULL,
  `LotIdent_Lot5` smallint(6) NOT NULL,
  `LotIdent_Lot6` smallint(6) NOT NULL,
  `LotIdent_Lot7` smallint(6) NOT NULL,
  `LotIdent_Lot8` smallint(6) NOT NULL,
  `LotIdent_Lot9` smallint(6) NOT NULL,
  `LotIdent_Lot10` smallint(6) NOT NULL,
  `LotIdent_Lot11` smallint(6) NOT NULL,
  `LotIdent_Lot12` smallint(6) NOT NULL,
  `LotIdent_Lot13` smallint(6) NOT NULL,
  `LotIdent_Lot14` smallint(6) NOT NULL,
  `LotIdent_Lot15` smallint(6) NOT NULL,
  `LotIdent_Lot16` smallint(6) NOT NULL,
  `LotIdent_Lot17` smallint(6) NOT NULL,
  `LotIdent_Lot18` smallint(6) NOT NULL,
  `LotIdent_Lot19` smallint(6) NOT NULL,
  `LotIdent_Lot20` smallint(6) NOT NULL,
  `LotIdent_Lot21` smallint(6) NOT NULL,
  `LotIdent_Lot22` smallint(6) NOT NULL,
  `LotIdent_Lot23` smallint(6) NOT NULL,
  `LotIdent_Lot24` smallint(6) NOT NULL,
  `LotIdent_Lot25` smallint(6) NOT NULL,
  `LotIdent_Lot26` smallint(6) NOT NULL,
  `LotIdent_Lot27` smallint(6) NOT NULL,
  `LotIdent_Lot28` smallint(6) NOT NULL,
  `LotIdent_Lot29` smallint(6) NOT NULL,
  `LotIdent_Lot30` smallint(6) NOT NULL,
  PRIMARY KEY (`PositionIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30020 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPPosLot`
--

CREATE TABLE `PPPosLot` (
  `PositionIdent` bigint(20) NOT NULL,
  `LotIdent` bigint(20) NOT NULL,
  `Menge` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPPosLotQuantity`
--

CREATE TABLE `PPPosLotQuantity` (
  `Lot` bigint(20) DEFAULT NULL,
  `Quantity` decimal(41,0) DEFAULT NULL,
  `Value` decimal(51,3) DEFAULT NULL,
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPProduktpass`
--

CREATE TABLE `PPProduktpass` (
  `PPProduktpass_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPProduktpass_IAN` varchar(200) NOT NULL,
  `PPProduktpass_Artikelbezeichnung` varchar(50) NOT NULL,
  `PPProduktpass_Ausmusterung` varchar(50) NOT NULL,
  `PPProduktpass_Ausmusterungnummer` varchar(50) NOT NULL,
  `PPProduktpass_AltIAN` varchar(200) NOT NULL,
  `PPProduktpass_AltArtikelbezeichnung` varchar(250) NOT NULL,
  `PPProduktpass_Warengruppe` varchar(250) NOT NULL,
  `PPProduktpass_Neu_Warengruppe` varchar(250) NOT NULL,
  `PPProduktpass_Verpackungseinheit` varchar(250) NOT NULL,
  `PPProduktpass_Thema` varchar(250) NOT NULL,
  `PPProduktpass_Liefertermin` varchar(250) NOT NULL,
  `PPProduktpass_Einkaeufer` varchar(250) NOT NULL,
  `PPProduktpass_Marke` varchar(250) NOT NULL,
  `PPProduktpass_Gesamtmenge` decimal(10,4) NOT NULL,
  `PPProduktpass_Pruefinstitut` varchar(250) NOT NULL,
  `PPProduktpass_Andere_Kriterien` varchar(250) NOT NULL,
  `PPProduktpass_Zertifizierungen` varchar(250) NOT NULL,
  `PPProduktpass_Logos` varchar(250) NOT NULL,
  `PPProduktpass_Verkaufsverpackung` varchar(250) NOT NULL,
  `PPProduktpass_Materialstaerke_der_Verkaufsverpackung` varchar(250) NOT NULL,
  `PPProduktpass_Agentur` varchar(250) NOT NULL,
  PRIMARY KEY (`PPProduktpass_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPProduktpass_Menge`
--

CREATE TABLE `PPProduktpass_Menge` (
  `PPProduktpass_Menge_PPProduktpass_Id` bigint(20) NOT NULL,
  `PPProduktpass_Menge_CountryBlock` varchar(20) NOT NULL,
  `PPProduktpass_Menge_Country` varchar(20) NOT NULL,
  `PPProduktpass_Menge_TotalSalePerUnit` decimal(10,4) NOT NULL,
  `PPProduktpass_Menge_Quantity` decimal(10,4) NOT NULL,
  `PPProduktpass_Menge_PackingMethod` varchar(20) NOT NULL,
  `PPProduktpass_Menge_DeliveryWeek` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPProtokoll`
--

CREATE TABLE `PPProtokoll` (
  `ProtokollIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(10) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(1500) DEFAULT NULL,
  `NewContent` varchar(1500) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ProtokollIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=461584 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPProtokollSave`
--

CREATE TABLE `PPProtokollSave` (
  `ProtokollIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(10) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(250) DEFAULT NULL,
  `NewContent` varchar(250) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ProtokollIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=400343 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPProtokollSic`
--

CREATE TABLE `PPProtokollSic` (
  `ProtokollIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(12) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(250) DEFAULT NULL,
  `NewContent` varchar(250) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ProtokollIdent`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=262345 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPQS`
--

CREATE TABLE `PPQS` (
  `PPQS_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPKopf_Refnumber` varchar(20) NOT NULL,
  `Kundentermin` date NOT NULL,
  `Fachnummer` varchar(20) NOT NULL,
  `Anfragenummer` varchar(20) NOT NULL,
  `Musterpruefung_Anzahl` varchar(400) NOT NULL,
  `Musterpruefung_Labor` bigint(20) NOT NULL,
  `Musterpruefung_fuer` varchar(50) NOT NULL,
  `Waschpruefung_Kommentar` varchar(1000) NOT NULL,
  `Waschpruefung_Datum` date NOT NULL,
  `Waschpruefung_Status` varchar(25) NOT NULL DEFAULT 'nicht gefordert',
  `Prueftermin1_Datum` date NOT NULL,
  `Prueftermin1_Kommentar` varchar(1000) NOT NULL,
  `Prueftermin1_Status` varchar(25) NOT NULL DEFAULT 'offen',
  `Prueftermin1_Labor` bigint(20) NOT NULL,
  `Prueftermin1_Bezeichnung` varchar(50) NOT NULL,
  `Prueftermin2_Datum` date NOT NULL,
  `Prueftermin2_Kommentar` varchar(1000) NOT NULL,
  `Prueftermin2_Status` varchar(25) NOT NULL DEFAULT 'nicht gefordert',
  `Prueftermin2_Labor` bigint(20) NOT NULL,
  `Prueftermin2_Bezeichnung` varchar(50) NOT NULL,
  `Prueftermin3_Datum` date NOT NULL,
  `Prueftermin3_Kommentar` varchar(1000) NOT NULL,
  `Prueftermin3_Status` varchar(25) NOT NULL DEFAULT 'nicht gefordert',
  `Prueftermin3_Labor` bigint(20) NOT NULL,
  `Prueftermin3_Bezeichnung` varchar(50) NOT NULL,
  `Inspektion_Datum` date NOT NULL,
  `Inspektion_Status` varchar(25) NOT NULL DEFAULT 'nicht gefordert',
  `Inspektion_Kommentar` varchar(1000) NOT NULL,
  `Produktionsmuster_Datum` date NOT NULL,
  `Produktionsmuster_Kommentar` varchar(1000) DEFAULT NULL,
  `Produktionsmuster_Status` varchar(25) NOT NULL DEFAULT 'offen',
  `Produktionsmuster_Bezeichnung` varchar(50) NOT NULL,
  `Produktionsmuster2_Datum` date NOT NULL,
  `Produktionsmuster2_Kommentar` varchar(1000) NOT NULL,
  `Produktionsmuster2_Status` varchar(50) NOT NULL DEFAULT 'offen',
  `Produktionsmuster2_Bezeichnung` varchar(50) NOT NULL DEFAULT 'C+K push',
  `Produktionsmuster3_Datum` date NOT NULL,
  `Produktionsmuster3_Kommentar` varchar(1000) NOT NULL,
  `Produktionsmuster3_Status` varchar(50) NOT NULL DEFAULT 'offen',
  `Produktionsmuster3_Bezeichnung` varchar(50) NOT NULL DEFAULT 'Produzent',
  `Produktionsmuster4_Datum` date NOT NULL,
  `Produktionsmuster4_Kommentar` varchar(1000) NOT NULL,
  `Produktionsmuster4_Status` varchar(50) NOT NULL DEFAULT 'offen',
  `Produktionsmuster4_Bezeichnung` varchar(50) NOT NULL DEFAULT 'Claim',
  `Produktionsmuster5_Datum` date NOT NULL,
  `Produktionsmuster5_Kommentar` varchar(1000) NOT NULL,
  `Produktionsmuster5_Status` varchar(50) NOT NULL DEFAULT 'offen',
  `Produktionsmuster5_Bezeichnung` varchar(50) NOT NULL DEFAULT 'Kundentermin',
  `Bemerkungen` varchar(1000) DEFAULT NULL,
  `QS_Status` varchar(30) NOT NULL DEFAULT 'offen',
  `QS_Material` varchar(400) NOT NULL,
  `QS_Artikel` varchar(400) NOT NULL,
  `Oekotex_Nummer` varchar(50) NOT NULL,
  `Oekotex_Datum` date NOT NULL,
  `Oekotex_Zertifikat` varchar(50) NOT NULL,
  `Oekotex_Status` varchar(25) NOT NULL DEFAULT 'offen',
  `AP_ECO_Status` varchar(25) NOT NULL DEFAULT 'offen',
  `AP_ECO_Datum` date NOT NULL,
  PRIMARY KEY (`PPQS_Id`),
  KEY `Produktionsmuster2_Datum` (`Produktionsmuster2_Datum`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=235 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `PPQSFiles`
--

CREATE TABLE `PPQSFiles` (
  `PPQSFiles_PPQS_Id` bigint(20) NOT NULL,
  `Anfragenummer` varchar(20) NOT NULL,
  `FileName` varchar(100) NOT NULL,
  `FileType` varchar(25) NOT NULL,
  `FileDate` datetime NOT NULL,
  `FileDescription` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `temp`
--

CREATE TABLE `temp` (
  `refnumber` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tPosLot`
--

CREATE TABLE `tPosLot` (
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL,
  `PositionIdent` int(11) DEFAULT NULL,
  `LotIdent` int(11) DEFAULT NULL,
  `Quantity1Lot` int(11) DEFAULT NULL,
  `Quantity2Lot` int(11) DEFAULT NULL,
  `Quantity3Lot` int(11) DEFAULT NULL,
  `Quantity4Lot` int(11) DEFAULT NULL,
  `Quantity5Lot` int(11) DEFAULT NULL,
  `Quantity6Lot` int(11) DEFAULT NULL,
  `Quantity7Lot` int(11) DEFAULT NULL,
  `Quantity8Lot` int(11) DEFAULT NULL,
  `Quantity9Lot` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vPosLots`
--

CREATE TABLE `vPosLots` (
  `PPKopf_Refnumber` varchar(10) DEFAULT NULL,
  `LotIdent` int(11) DEFAULT NULL,
  `LotDelete` char(1) DEFAULT NULL,
  `LotStatus` varchar(50) DEFAULT NULL,
  `PositionIdent` int(11) DEFAULT NULL,
  `PositionDelete` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `vPPImportDefinition`
--
CREATE TABLE `vPPImportDefinition` (
);
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vPPLotTotalValue`
--

CREATE TABLE `vPPLotTotalValue` (
  `ValLot1` decimal(42,3) DEFAULT NULL,
  `ValLot2` decimal(42,3) DEFAULT NULL,
  `ValLot3` decimal(42,3) DEFAULT NULL,
  `ValLot4` decimal(42,3) DEFAULT NULL,
  `ValLot5` decimal(42,3) DEFAULT NULL,
  `ValLot6` decimal(42,3) DEFAULT NULL,
  `ValLot7` decimal(42,3) DEFAULT NULL,
  `ValLot8` decimal(42,3) DEFAULT NULL,
  `ValLot9` decimal(42,3) DEFAULT NULL,
  `ValLot10` decimal(51,3) DEFAULT NULL,
  `ValLot11` decimal(51,3) DEFAULT NULL,
  `ValLot12` decimal(51,3) DEFAULT NULL,
  `ValLot13` decimal(51,3) DEFAULT NULL,
  `ValLot14` decimal(51,3) DEFAULT NULL,
  `ValLot15` decimal(51,3) DEFAULT NULL,
  `ValLot16` decimal(51,3) DEFAULT NULL,
  `ValLot17` decimal(51,3) DEFAULT NULL,
  `ValLot18` decimal(51,3) DEFAULT NULL,
  `ValLot19` decimal(51,3) DEFAULT NULL,
  `ValLot20` decimal(51,3) DEFAULT NULL,
  `ValLot21` decimal(51,3) DEFAULT NULL,
  `ValLot22` decimal(51,3) DEFAULT NULL,
  `ValLot23` decimal(51,3) DEFAULT NULL,
  `ValLot24` decimal(51,3) DEFAULT NULL,
  `ValLot25` decimal(51,3) DEFAULT NULL,
  `ValLot26` decimal(51,3) DEFAULT NULL,
  `ValLot27` decimal(51,3) DEFAULT NULL,
  `ValLot28` decimal(51,3) DEFAULT NULL,
  `ValLot29` decimal(51,3) DEFAULT NULL,
  `ValLot30` decimal(51,3) DEFAULT NULL,
  `PPKopf_Refnumber` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vPPQS_overview`
--

CREATE TABLE `vPPQS_overview` (
  `PPKopf_Refnumber` varchar(20) DEFAULT NULL,
  `Kundentermin` date DEFAULT NULL,
  `Fachnummer` varchar(20) DEFAULT NULL,
  `Anfragenummer` varchar(20) DEFAULT NULL,
  `Musterpruefung_Anzahl` varchar(400) DEFAULT NULL,
  `Musterpruefung_Labor` bigint(20) DEFAULT NULL,
  `Musterpruefung_fuer` varchar(50) DEFAULT NULL,
  `Waschpruefung_Kommentar` varchar(1000) DEFAULT NULL,
  `Waschpruefung_Datum` date DEFAULT NULL,
  `Waschpruefung_Status` varchar(25) DEFAULT NULL,
  `Prueftermin1_Datum` date DEFAULT NULL,
  `Prueftermin1_Kommentar` varchar(1000) DEFAULT NULL,
  `Prueftermin1_Status` varchar(25) DEFAULT NULL,
  `Prueftermin1_Labor` bigint(20) DEFAULT NULL,
  `Prueftermin2_Datum` date DEFAULT NULL,
  `Prueftermin2_Kommentar` varchar(1000) DEFAULT NULL,
  `Prueftermin2_Status` varchar(25) DEFAULT NULL,
  `Prueftermin2_Labor` bigint(20) DEFAULT NULL,
  `Prueftermin3_Datum` date DEFAULT NULL,
  `Prueftermin3_Kommentar` varchar(1000) DEFAULT NULL,
  `Prueftermin3_Status` varchar(25) DEFAULT NULL,
  `Prueftermin3_Labor` bigint(20) DEFAULT NULL,
  `Inspektion_Datum` date DEFAULT NULL,
  `Inspektion_Status` varchar(25) DEFAULT NULL,
  `Inspektion_Kommentar` varchar(1000) DEFAULT NULL,
  `Produktionsmuster_Datum` date DEFAULT NULL,
  `Produktionsmuster_Kommentar` varchar(1000) DEFAULT NULL,
  `Produktionsmuster_Status` varchar(25) DEFAULT NULL,
  `Bemerkungen` varchar(1000) DEFAULT NULL,
  `QS_Status` varchar(30) DEFAULT NULL,
  `QS_Material` varchar(400) DEFAULT NULL,
  `QS_Artikel` varchar(400) DEFAULT NULL,
  `PT1_Labor` varchar(250) DEFAULT NULL,
  `PT2_Labor` varchar(250) DEFAULT NULL,
  `PT3_Labor` varchar(250) DEFAULT NULL,
  `RefNumber` varchar(10) DEFAULT NULL,
  `LcNumber` varchar(40) DEFAULT NULL,
  `ScNumber` varchar(20) DEFAULT NULL,
  `FormerInquiry` varchar(10) DEFAULT NULL,
  `Supplier` varchar(25) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `exch_save` varchar(20) DEFAULT NULL,
  `exch_save_art` varchar(5) DEFAULT NULL,
  `CustomsCode` varchar(30) DEFAULT NULL,
  `Customer` varchar(50) DEFAULT NULL,
  `DutyPercentage` decimal(6,2) DEFAULT NULL,
  `DeliveryDate` varchar(25) DEFAULT NULL,
  `ResOffice` varchar(25) DEFAULT NULL,
  `QuotaNecessarily` char(3) DEFAULT NULL,
  `QuotaCategory` varchar(20) DEFAULT NULL,
  `Description` blob,
  `Material` blob,
  `Remark` blob,
  `TermsOfDelivery` varchar(70) DEFAULT NULL,
  `TermsOfPayment` varchar(70) DEFAULT NULL,
  `PackType` varchar(25) DEFAULT NULL,
  `PackDescription` blob,
  `PackText` varchar(250) DEFAULT NULL,
  `SamplesRequired` char(3) DEFAULT NULL,
  `SamplesEta` varchar(10) DEFAULT NULL,
  `SamplesRemark` blob,
  `Photoinlet` varchar(25) DEFAULT NULL,
  `Polybag` varchar(25) DEFAULT NULL,
  `WovenLabel` varchar(25) DEFAULT NULL,
  `Stickers` varchar(25) DEFAULT NULL,
  `WashingSymbols` varchar(80) DEFAULT NULL,
  `Temperature` varchar(50) DEFAULT NULL,
  `Triangle` varchar(25) DEFAULT NULL,
  `Iron` varchar(25) DEFAULT NULL,
  `Circle` varchar(25) DEFAULT NULL,
  `Tumbler` varchar(25) DEFAULT NULL,
  `CartonMarks` blob,
  `CartonMarks2` blob,
  `CartonMarks3` blob,
  `Archive` int(11) DEFAULT NULL,
  `PPStatus` varchar(10) DEFAULT NULL,
  `License` varchar(40) DEFAULT NULL,
  `PortOfDischarge` varchar(50) DEFAULT NULL,
  `Country` varchar(20) DEFAULT NULL,
  `pk` bigint(20) DEFAULT NULL,
  `OrderDate` varchar(50) DEFAULT NULL,
  `SupplierDelDate` varchar(200) DEFAULT NULL,
  `Inquiry` varchar(50) DEFAULT NULL,
  `Factory` varchar(50) DEFAULT NULL,
  `KopfDelete` int(11) DEFAULT NULL,
  `cust_delterm` varchar(50) DEFAULT NULL,
  `QuantityTolerance` varchar(50) DEFAULT NULL,
  `DeliveryAddress` bigint(20) DEFAULT NULL,
  `QSneeded` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vPPQS_overview2`
--

CREATE TABLE `vPPQS_overview2` (
  `PPKopf_Refnumber` varchar(20) DEFAULT NULL,
  `Kundentermin` date DEFAULT NULL,
  `Fachnummer` varchar(20) DEFAULT NULL,
  `Anfragenummer` varchar(20) DEFAULT NULL,
  `Musterpruefung_Anzahl` varchar(400) DEFAULT NULL,
  `Musterpruefung_Labor` bigint(20) DEFAULT NULL,
  `Musterpruefung_fuer` varchar(50) DEFAULT NULL,
  `Waschpruefung_Kommentar` varchar(1000) DEFAULT NULL,
  `Waschpruefung_Datum` date DEFAULT NULL,
  `Waschpruefung_Status` varchar(25) DEFAULT NULL,
  `Prueftermin1_Datum` date DEFAULT NULL,
  `Prueftermin1_Kommentar` varchar(1000) DEFAULT NULL,
  `Prueftermin1_Status` varchar(25) DEFAULT NULL,
  `Prueftermin1_Labor` bigint(20) DEFAULT NULL,
  `Prueftermin2_Datum` date DEFAULT NULL,
  `Prueftermin2_Kommentar` varchar(1000) DEFAULT NULL,
  `Prueftermin2_Status` varchar(25) DEFAULT NULL,
  `Prueftermin2_Labor` bigint(20) DEFAULT NULL,
  `Prueftermin3_Datum` date DEFAULT NULL,
  `Prueftermin3_Kommentar` varchar(1000) DEFAULT NULL,
  `Prueftermin3_Status` varchar(25) DEFAULT NULL,
  `Prueftermin3_Labor` bigint(20) DEFAULT NULL,
  `Inspektion_Datum` date DEFAULT NULL,
  `Inspektion_Status` varchar(25) DEFAULT NULL,
  `Inspektion_Kommentar` varchar(1000) DEFAULT NULL,
  `Produktionsmuster_Datum` date DEFAULT NULL,
  `Produktionsmuster_Kommentar` varchar(1000) DEFAULT NULL,
  `Produktionsmuster_Status` varchar(25) DEFAULT NULL,
  `Bemerkungen` varchar(1000) DEFAULT NULL,
  `QS_Status` varchar(30) DEFAULT NULL,
  `QS_Material` varchar(400) DEFAULT NULL,
  `QS_Artikel` varchar(400) DEFAULT NULL,
  `PT1_Labor` varchar(250) DEFAULT NULL,
  `PT2_Labor` varchar(250) DEFAULT NULL,
  `PT3_Labor` varchar(250) DEFAULT NULL,
  `RefNumber` varchar(10) DEFAULT NULL,
  `LcNumber` varchar(40) DEFAULT NULL,
  `ScNumber` varchar(20) DEFAULT NULL,
  `FormerInquiry` varchar(10) DEFAULT NULL,
  `Supplier` varchar(25) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `exch_save` varchar(20) DEFAULT NULL,
  `exch_save_art` varchar(5) DEFAULT NULL,
  `CustomsCode` varchar(30) DEFAULT NULL,
  `Customer` varchar(50) DEFAULT NULL,
  `DutyPercentage` decimal(6,2) DEFAULT NULL,
  `DeliveryDate` varchar(25) DEFAULT NULL,
  `ResOffice` varchar(25) DEFAULT NULL,
  `QuotaNecessarily` char(3) DEFAULT NULL,
  `QuotaCategory` varchar(20) DEFAULT NULL,
  `Description` blob,
  `Material` blob,
  `Remark` blob,
  `TermsOfDelivery` varchar(70) DEFAULT NULL,
  `TermsOfPayment` varchar(70) DEFAULT NULL,
  `PackType` varchar(25) DEFAULT NULL,
  `PackDescription` blob,
  `PackText` varchar(250) DEFAULT NULL,
  `SamplesRequired` char(3) DEFAULT NULL,
  `SamplesEta` varchar(10) DEFAULT NULL,
  `SamplesRemark` blob,
  `Photoinlet` varchar(25) DEFAULT NULL,
  `Polybag` varchar(25) DEFAULT NULL,
  `WovenLabel` varchar(25) DEFAULT NULL,
  `Stickers` varchar(25) DEFAULT NULL,
  `WashingSymbols` varchar(80) DEFAULT NULL,
  `Temperature` varchar(50) DEFAULT NULL,
  `Triangle` varchar(25) DEFAULT NULL,
  `Iron` varchar(25) DEFAULT NULL,
  `Circle` varchar(25) DEFAULT NULL,
  `Tumbler` varchar(25) DEFAULT NULL,
  `CartonMarks` blob,
  `CartonMarks2` blob,
  `CartonMarks3` blob,
  `Archive` int(11) DEFAULT NULL,
  `PPStatus` varchar(10) DEFAULT NULL,
  `License` varchar(40) DEFAULT NULL,
  `PortOfDischarge` varchar(50) DEFAULT NULL,
  `Country` varchar(20) DEFAULT NULL,
  `pk` bigint(20) DEFAULT NULL,
  `OrderDate` varchar(50) DEFAULT NULL,
  `SupplierDelDate` varchar(200) DEFAULT NULL,
  `Inquiry` varchar(50) DEFAULT NULL,
  `Factory` varchar(50) DEFAULT NULL,
  `KopfDelete` int(11) DEFAULT NULL,
  `cust_delterm` varchar(50) DEFAULT NULL,
  `QuantityTolerance` varchar(50) DEFAULT NULL,
  `DeliveryAddress` bigint(20) DEFAULT NULL,
  `QSneeded` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `vPPQS_overview3`
--
CREATE TABLE `vPPQS_overview3` (
`Oekotex_Datum` date
,`Oekotex_Zertifikat` varchar(50)
,`Oekotex_Nummer` varchar(50)
,`Oekotex_Status` varchar(25)
,`AP_ECO_Status` varchar(25)
,`AP_ECO_Datum` date
,`PPKopf_Refnumber` varchar(20)
,`Kundentermin` date
,`Fachnummer` varchar(20)
,`Anfragenummer` varchar(20)
,`Musterpruefung_Anzahl` varchar(400)
,`Musterpruefung_Labor` bigint(20)
,`Musterpruefung_fuer` varchar(50)
,`Waschpruefung_Kommentar` varchar(1000)
,`Waschpruefung_Datum` date
,`Waschpruefung_Status` varchar(25)
,`Prueftermin1_Datum` date
,`Prueftermin1_Kommentar` varchar(1000)
,`Prueftermin1_Status` varchar(25)
,`Prueftermin1_Labor` bigint(20)
,`Prueftermin2_Datum` date
,`Prueftermin2_Kommentar` varchar(1000)
,`Prueftermin2_Status` varchar(25)
,`Prueftermin2_Labor` bigint(20)
,`Prueftermin3_Datum` date
,`Prueftermin3_Kommentar` varchar(1000)
,`Prueftermin3_Status` varchar(25)
,`Prueftermin3_Labor` bigint(20)
,`Inspektion_Datum` date
,`Inspektion_Status` varchar(25)
,`Inspektion_Kommentar` varchar(1000)
,`Produktionsmuster_Datum` date
,`Produktionsmuster_Kommentar` varchar(1000)
,`Produktionsmuster_Status` varchar(25)
,`Produktionsmuster_Bezeichung` varchar(50)
,`Produktionsmuster2_Datum` date
,`Produktionsmuster2_Kommentar` varchar(1000)
,`Produktionsmuster2_Status` varchar(50)
,`Produktionsmuster2_Bezeichung` varchar(50)
,`Produktionsmuster3_Datum` date
,`Produktionsmuster3_Kommentar` varchar(1000)
,`Produktionsmuster3_Status` varchar(50)
,`Produktionsmuster3_Bezeichung` varchar(50)
,`Produktionsmuster4_Datum` date
,`Produktionsmuster4_Kommentar` varchar(1000)
,`Produktionsmuster4_Status` varchar(50)
,`Produktionsmuster4_Bezeichung` varchar(50)
,`Produktionsmuster5_Datum` date
,`Produktionsmuster5_Kommentar` varchar(1000)
,`Produktionsmuster5_Status` varchar(50)
,`Produktionsmuster5_Bezeichung` varchar(50)
,`Bemerkungen` varchar(1000)
,`QS_Status` varchar(30)
,`QS_Material` varchar(400)
,`QS_Artikel` varchar(400)
,`PT1_Labor` varchar(250)
,`PT2_Labor` varchar(250)
,`PT3_Labor` varchar(250)
,`RefNumber` varchar(10)
,`LcNumber` varchar(40)
,`ScNumber` varchar(20)
,`FormerInquiry` varchar(10)
,`Supplier` varchar(25)
,`Category` varchar(20)
,`currency` varchar(3)
,`exch_save` varchar(20)
,`exch_save_art` varchar(5)
,`CustomsCode` varchar(30)
,`Customer` varchar(50)
,`DutyPercentage` decimal(6,2)
,`DeliveryDate` varchar(25)
,`ResOffice` varchar(25)
,`QuotaNecessarily` char(3)
,`QuotaCategory` varchar(20)
,`Description` blob
,`Material` blob
,`Remark` blob
,`TermsOfDelivery` varchar(70)
,`TermsOfPayment` varchar(70)
,`PackType` varchar(25)
,`PackDescription` blob
,`PackText` varchar(250)
,`SamplesRequired` char(3)
,`SamplesEta` varchar(10)
,`SamplesRemark` blob
,`Photoinlet` varchar(25)
,`Polybag` varchar(25)
,`WovenLabel` varchar(25)
,`Stickers` varchar(25)
,`WashingSymbols` varchar(80)
,`Temperature` varchar(50)
,`Triangle` varchar(25)
,`Iron` varchar(25)
,`Circle` varchar(25)
,`Tumbler` varchar(25)
,`CartonMarks` blob
,`CartonMarks2` blob
,`CartonMarks3` blob
,`Archive` int(11)
,`PPStatus` varchar(10)
,`License` varchar(40)
,`PortOfDischarge` varchar(50)
,`Country` varchar(20)
,`pk` bigint(20)
,`OrderDate` varchar(50)
,`SupplierDelDate` varchar(200)
,`Inquiry` varchar(50)
,`Factory` varchar(50)
,`KopfDelete` int(11)
,`cust_delterm` varchar(50)
,`QuantityTolerance` varchar(50)
,`DeliveryAddress` bigint(20)
,`QSneeded` tinyint(4)
);
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vPPTermine`
--

CREATE TABLE `vPPTermine` (
  `Datum` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `Type` varchar(3) DEFAULT NULL,
  `PPKopf_Refnumber` varchar(20) DEFAULT NULL,
  `Anfragenummer` varchar(20) DEFAULT NULL,
  `PPQS_Id` bigint(20) DEFAULT NULL,
  `QS_Status` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vProtokoll`
--

CREATE TABLE `vProtokoll` (
  `ProtokollIdent` int(11) DEFAULT NULL,
  `RefNumber` varchar(10) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(1500) DEFAULT NULL,
  `NewContent` varchar(1500) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  `Adressident` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur des Views `vPPImportDefinition`
--
DROP TABLE IF EXISTS `vPPImportDefinition`;
-- in Benutzung(#1356 - View 'db300310_30.vPPImportDefinition' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

-- --------------------------------------------------------

--
-- Struktur des Views `vPPQS_overview3`
--
DROP TABLE IF EXISTS `vPPQS_overview3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`db300310_30`@`127.0.0.%` SQL SECURITY DEFINER VIEW `db300310_30`.`vPPQS_overview3` AS select `db300310_30`.`PPQS`.`Oekotex_Datum` AS `Oekotex_Datum`,`db300310_30`.`PPQS`.`Oekotex_Zertifikat` AS `Oekotex_Zertifikat`,`db300310_30`.`PPQS`.`Oekotex_Nummer` AS `Oekotex_Nummer`,`db300310_30`.`PPQS`.`Oekotex_Status` AS `Oekotex_Status`,`db300310_30`.`PPQS`.`AP_ECO_Status` AS `AP_ECO_Status`,`db300310_30`.`PPQS`.`AP_ECO_Datum` AS `AP_ECO_Datum`,`db300310_30`.`PPQS`.`PPKopf_Refnumber` AS `PPKopf_Refnumber`,`db300310_30`.`PPQS`.`Kundentermin` AS `Kundentermin`,`db300310_30`.`PPQS`.`Fachnummer` AS `Fachnummer`,`db300310_30`.`PPQS`.`Anfragenummer` AS `Anfragenummer`,`db300310_30`.`PPQS`.`Musterpruefung_Anzahl` AS `Musterpruefung_Anzahl`,`db300310_30`.`PPQS`.`Musterpruefung_Labor` AS `Musterpruefung_Labor`,`db300310_30`.`PPQS`.`Musterpruefung_fuer` AS `Musterpruefung_fuer`,`db300310_30`.`PPQS`.`Waschpruefung_Kommentar` AS `Waschpruefung_Kommentar`,`db300310_30`.`PPQS`.`Waschpruefung_Datum` AS `Waschpruefung_Datum`,`db300310_30`.`PPQS`.`Waschpruefung_Status` AS `Waschpruefung_Status`,`db300310_30`.`PPQS`.`Prueftermin1_Datum` AS `Prueftermin1_Datum`,`db300310_30`.`PPQS`.`Prueftermin1_Kommentar` AS `Prueftermin1_Kommentar`,`db300310_30`.`PPQS`.`Prueftermin1_Status` AS `Prueftermin1_Status`,`db300310_30`.`PPQS`.`Prueftermin1_Labor` AS `Prueftermin1_Labor`,`db300310_30`.`PPQS`.`Prueftermin2_Datum` AS `Prueftermin2_Datum`,`db300310_30`.`PPQS`.`Prueftermin2_Kommentar` AS `Prueftermin2_Kommentar`,`db300310_30`.`PPQS`.`Prueftermin2_Status` AS `Prueftermin2_Status`,`db300310_30`.`PPQS`.`Prueftermin2_Labor` AS `Prueftermin2_Labor`,`db300310_30`.`PPQS`.`Prueftermin3_Datum` AS `Prueftermin3_Datum`,`db300310_30`.`PPQS`.`Prueftermin3_Kommentar` AS `Prueftermin3_Kommentar`,`db300310_30`.`PPQS`.`Prueftermin3_Status` AS `Prueftermin3_Status`,`db300310_30`.`PPQS`.`Prueftermin3_Labor` AS `Prueftermin3_Labor`,`db300310_30`.`PPQS`.`Inspektion_Datum` AS `Inspektion_Datum`,`db300310_30`.`PPQS`.`Inspektion_Status` AS `Inspektion_Status`,`db300310_30`.`PPQS`.`Inspektion_Kommentar` AS `Inspektion_Kommentar`,`db300310_30`.`PPQS`.`Produktionsmuster_Datum` AS `Produktionsmuster_Datum`,`db300310_30`.`PPQS`.`Produktionsmuster_Kommentar` AS `Produktionsmuster_Kommentar`,`db300310_30`.`PPQS`.`Produktionsmuster_Status` AS `Produktionsmuster_Status`,`db300310_30`.`PPQS`.`Produktionsmuster_Bezeichnung` AS `Produktionsmuster_Bezeichung`,`db300310_30`.`PPQS`.`Produktionsmuster2_Datum` AS `Produktionsmuster2_Datum`,`db300310_30`.`PPQS`.`Produktionsmuster2_Kommentar` AS `Produktionsmuster2_Kommentar`,`db300310_30`.`PPQS`.`Produktionsmuster2_Status` AS `Produktionsmuster2_Status`,`db300310_30`.`PPQS`.`Produktionsmuster2_Bezeichnung` AS `Produktionsmuster2_Bezeichung`,`db300310_30`.`PPQS`.`Produktionsmuster3_Datum` AS `Produktionsmuster3_Datum`,`db300310_30`.`PPQS`.`Produktionsmuster3_Kommentar` AS `Produktionsmuster3_Kommentar`,`db300310_30`.`PPQS`.`Produktionsmuster3_Status` AS `Produktionsmuster3_Status`,`db300310_30`.`PPQS`.`Produktionsmuster3_Bezeichnung` AS `Produktionsmuster3_Bezeichung`,`db300310_30`.`PPQS`.`Produktionsmuster4_Datum` AS `Produktionsmuster4_Datum`,`db300310_30`.`PPQS`.`Produktionsmuster4_Kommentar` AS `Produktionsmuster4_Kommentar`,`db300310_30`.`PPQS`.`Produktionsmuster4_Status` AS `Produktionsmuster4_Status`,`db300310_30`.`PPQS`.`Produktionsmuster4_Bezeichnung` AS `Produktionsmuster4_Bezeichung`,`db300310_30`.`PPQS`.`Produktionsmuster5_Datum` AS `Produktionsmuster5_Datum`,`db300310_30`.`PPQS`.`Produktionsmuster5_Kommentar` AS `Produktionsmuster5_Kommentar`,`db300310_30`.`PPQS`.`Produktionsmuster5_Status` AS `Produktionsmuster5_Status`,`db300310_30`.`PPQS`.`Produktionsmuster5_Bezeichnung` AS `Produktionsmuster5_Bezeichung`,`db300310_30`.`PPQS`.`Bemerkungen` AS `Bemerkungen`,`db300310_30`.`PPQS`.`QS_Status` AS `QS_Status`,`db300310_30`.`PPQS`.`QS_Material` AS `QS_Material`,`db300310_30`.`PPQS`.`QS_Artikel` AS `QS_Artikel`,`adress1`.`Matchcode` AS `PT1_Labor`,`adress2`.`Matchcode` AS `PT2_Labor`,`adress3`.`Matchcode` AS `PT3_Labor`,`db300310_30`.`PPKopf`.`RefNumber` AS `RefNumber`,`db300310_30`.`PPKopf`.`LcNumber` AS `LcNumber`,`db300310_30`.`PPKopf`.`ScNumber` AS `ScNumber`,`db300310_30`.`PPKopf`.`FormerInquiry` AS `FormerInquiry`,`db300310_30`.`PPKopf`.`Supplier` AS `Supplier`,`db300310_30`.`PPKopf`.`Category` AS `Category`,`db300310_30`.`PPKopf`.`currency` AS `currency`,`db300310_30`.`PPKopf`.`exch_save` AS `exch_save`,`db300310_30`.`PPKopf`.`exch_save_art` AS `exch_save_art`,`db300310_30`.`PPKopf`.`CustomsCode` AS `CustomsCode`,`db300310_30`.`PPKopf`.`Customer` AS `Customer`,`db300310_30`.`PPKopf`.`DutyPercentage` AS `DutyPercentage`,`db300310_30`.`PPKopf`.`DeliveryDate` AS `DeliveryDate`,`db300310_30`.`PPKopf`.`ResOffice` AS `ResOffice`,`db300310_30`.`PPKopf`.`QuotaNecessarily` AS `QuotaNecessarily`,`db300310_30`.`PPKopf`.`QuotaCategory` AS `QuotaCategory`,`db300310_30`.`PPKopf`.`Description` AS `Description`,`db300310_30`.`PPKopf`.`Material` AS `Material`,`db300310_30`.`PPKopf`.`Remark` AS `Remark`,`db300310_30`.`PPKopf`.`TermsOfDelivery` AS `TermsOfDelivery`,`db300310_30`.`PPKopf`.`TermsOfPayment` AS `TermsOfPayment`,`db300310_30`.`PPKopf`.`PackType` AS `PackType`,`db300310_30`.`PPKopf`.`PackDescription` AS `PackDescription`,`db300310_30`.`PPKopf`.`PackText` AS `PackText`,`db300310_30`.`PPKopf`.`SamplesRequired` AS `SamplesRequired`,`db300310_30`.`PPKopf`.`SamplesEta` AS `SamplesEta`,`db300310_30`.`PPKopf`.`SamplesRemark` AS `SamplesRemark`,`db300310_30`.`PPKopf`.`Photoinlet` AS `Photoinlet`,`db300310_30`.`PPKopf`.`Polybag` AS `Polybag`,`db300310_30`.`PPKopf`.`WovenLabel` AS `WovenLabel`,`db300310_30`.`PPKopf`.`Stickers` AS `Stickers`,`db300310_30`.`PPKopf`.`WashingSymbols` AS `WashingSymbols`,`db300310_30`.`PPKopf`.`Temperature` AS `Temperature`,`db300310_30`.`PPKopf`.`Triangle` AS `Triangle`,`db300310_30`.`PPKopf`.`Iron` AS `Iron`,`db300310_30`.`PPKopf`.`Circle` AS `Circle`,`db300310_30`.`PPKopf`.`Tumbler` AS `Tumbler`,`db300310_30`.`PPKopf`.`CartonMarks` AS `CartonMarks`,`db300310_30`.`PPKopf`.`CartonMarks2` AS `CartonMarks2`,`db300310_30`.`PPKopf`.`CartonMarks3` AS `CartonMarks3`,`db300310_30`.`PPKopf`.`Archive` AS `Archive`,`db300310_30`.`PPKopf`.`PPStatus` AS `PPStatus`,`db300310_30`.`PPKopf`.`License` AS `License`,`db300310_30`.`PPKopf`.`PortOfDischarge` AS `PortOfDischarge`,`db300310_30`.`PPKopf`.`Country` AS `Country`,`db300310_30`.`PPKopf`.`pk` AS `pk`,`db300310_30`.`PPKopf`.`OrderDate` AS `OrderDate`,`db300310_30`.`PPKopf`.`SupplierDelDate` AS `SupplierDelDate`,`db300310_30`.`PPKopf`.`Inquiry` AS `Inquiry`,`db300310_30`.`PPKopf`.`Factory` AS `Factory`,`db300310_30`.`PPKopf`.`KopfDelete` AS `KopfDelete`,`db300310_30`.`PPKopf`.`cust_delterm` AS `cust_delterm`,`db300310_30`.`PPKopf`.`QuantityTolerance` AS `QuantityTolerance`,`db300310_30`.`PPKopf`.`DeliveryAddress` AS `DeliveryAddress`,`db300310_30`.`PPKopf`.`QSneeded` AS `QSneeded` from ((((`db300310_30`.`PPQS` left join `db300310_30`.`PPKopf` on((`db300310_30`.`PPQS`.`PPKopf_Refnumber` = convert(`db300310_30`.`PPKopf`.`RefNumber` using utf8)))) left join `db300310_30`.`PPAdressen` `adress1` on((`db300310_30`.`PPQS`.`Prueftermin1_Labor` = `adress1`.`Id`))) left join `db300310_30`.`PPAdressen` `adress2` on((`db300310_30`.`PPQS`.`Prueftermin2_Labor` = `adress2`.`Id`))) left join `db300310_30`.`PPAdressen` `adress3` on((`db300310_30`.`PPQS`.`Prueftermin3_Labor` = `adress3`.`Id`)));
  
  