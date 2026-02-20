-- MySQL dump 10.13  Distrib 5.6.17, for Linux (x86_64)
--
-- Host: localhost    Database: BelotexMain
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Adress`
--

DROP TABLE IF EXISTS `Adress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Artikel`
--

DROP TABLE IF EXISTS `Artikel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPAddon`
--

DROP TABLE IF EXISTS `PPAddon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPAdressen`
--

DROP TABLE IF EXISTS `PPAdressen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=227 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPChangesConfirm`
--

DROP TABLE IF EXISTS `PPChangesConfirm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPChangesConfirm` (
  `AdressIdent` bigint(20) NOT NULL,
  `ProtokollIdent` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPEmail`
--

DROP TABLE IF EXISTS `PPEmail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPEmail` (
  `EmailIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(10) DEFAULT NULL,
  `AdressIdent` int(11) DEFAULT NULL,
  PRIMARY KEY (`EmailIdent`)
) ENGINE=MyISAM AUTO_INCREMENT=22655 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPGroup`
--

DROP TABLE IF EXISTS `PPGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPGroup` (
  `GroupName` varchar(50) NOT NULL,
  `GroupMember` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPImport_Definition`
--

DROP TABLE IF EXISTS `PPImport_Definition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPImport_Definition` (
  `PPImport_Definition_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPImport_Definition_Table` varchar(255) NOT NULL,
  `PPImport_Definition_Mode` varchar(50) NOT NULL,
  `PPImport_Definition_Startrow` bigint(20) NOT NULL,
  `PPImport_Definition_Endrow` bigint(20) NOT NULL,
  `PPImport_Definition_Sheetname` varchar(250) NOT NULL,
  PRIMARY KEY (`PPImport_Definition_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPImport_Definition_Fields`
--

DROP TABLE IF EXISTS `PPImport_Definition_Fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPImport_Definition_Fields` (
  `PPImport_Definition_Id2` bigint(20) NOT NULL,
  `PPImport_Definition_Fields_Field` varchar(100) NOT NULL,
  `PPImport_Definition_Fields_Sheet` varchar(100) NOT NULL,
  `PPImport_Definition_Fields_Row` bigint(20) NOT NULL,
  `PPImport_Definition_Fields_Col` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPImport_Definition_Row`
--

DROP TABLE IF EXISTS `PPImport_Definition_Row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPImport_Definition_Row` (
  `PPImport_Definition_Id1` bigint(20) NOT NULL,
  `PPImport_Definition_Row_Field` varchar(100) NOT NULL,
  `PPImport_Definition_Row_Col` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPImport_Excel`
--

DROP TABLE IF EXISTS `PPImport_Excel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPImport_Excel` (
  `PPImort__Excel_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPImport_Excel_Datum` datetime NOT NULL,
  `PPImport_Excel_Dateiname` varchar(255) NOT NULL,
  PRIMARY KEY (`PPImort__Excel_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPImport_Excel_Data`
--

DROP TABLE IF EXISTS `PPImport_Excel_Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPImport_Excel_Data` (
  `PPImport_Excel_Data_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `PPImport_Excel_Data_Filename` varchar(250) NOT NULL,
  `PPImport_Excel_Data_Sheet` varchar(250) NOT NULL,
  `PPImport_Excel_Data_Row` bigint(20) NOT NULL,
  `PPImport_Excel_Data_Col` varchar(4) NOT NULL,
  `PPImport_Excel_Data_Value` varchar(2500) NOT NULL,
  PRIMARY KEY (`PPImport_Excel_Data_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5746 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPKopf`
--

DROP TABLE IF EXISTS `PPKopf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=6296 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPKopfArchiv`
--

DROP TABLE IF EXISTS `PPKopfArchiv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=6082 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPLog`
--

DROP TABLE IF EXISTS `PPLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPLog` (
  `Log_Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Log_User` varchar(50) NOT NULL,
  `Log_Date` datetime NOT NULL,
  `Log_Typ` varchar(150) NOT NULL,
  PRIMARY KEY (`Log_Id`)
) ENGINE=MyISAM AUTO_INCREMENT=932 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPLot`
--

DROP TABLE IF EXISTS `PPLot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=10994 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPOrderTotal`
--

DROP TABLE IF EXISTS `PPOrderTotal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPOrderTotal` (
  `OrderTotal` decimal(51,3) DEFAULT NULL,
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPPosLot`
--

DROP TABLE IF EXISTS `PPPosLot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPPosLot` (
  `PositionIdent` bigint(20) NOT NULL,
  `LotIdent` bigint(20) NOT NULL,
  `Menge` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPPosLotQuantity`
--

DROP TABLE IF EXISTS `PPPosLotQuantity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPPosLotQuantity` (
  `Lot` bigint(20) DEFAULT NULL,
  `Quantity` decimal(41,0) DEFAULT NULL,
  `Value` decimal(51,3) DEFAULT NULL,
  `PPKopf_RefNumber` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPPosition`
--

DROP TABLE IF EXISTS `PPPosition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=30020 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPProduktpass`
--

DROP TABLE IF EXISTS `PPProduktpass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPProduktpass_Menge`
--

DROP TABLE IF EXISTS `PPProduktpass_Menge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPProduktpass_Menge` (
  `PPProduktpass_Menge_PPProduktpass_Id` bigint(20) NOT NULL,
  `PPProduktpass_Menge_CountryBlock` varchar(20) NOT NULL,
  `PPProduktpass_Menge_Country` varchar(20) NOT NULL,
  `PPProduktpass_Menge_TotalSalePerUnit` decimal(10,4) NOT NULL,
  `PPProduktpass_Menge_Quantity` decimal(10,4) NOT NULL,
  `PPProduktpass_Menge_PackingMethod` varchar(20) NOT NULL,
  `PPProduktpass_Menge_DeliveryWeek` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPProtokoll`
--

DROP TABLE IF EXISTS `PPProtokoll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPProtokoll` (
  `ProtokollIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(10) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(1500) DEFAULT NULL,
  `NewContent` varchar(1500) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ProtokollIdent`)
) ENGINE=MyISAM AUTO_INCREMENT=461584 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPProtokollSave`
--

DROP TABLE IF EXISTS `PPProtokollSave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPProtokollSave` (
  `ProtokollIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(10) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(250) DEFAULT NULL,
  `NewContent` varchar(250) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ProtokollIdent`)
) ENGINE=MyISAM AUTO_INCREMENT=400343 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPProtokollSic`
--

DROP TABLE IF EXISTS `PPProtokollSic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPProtokollSic` (
  `ProtokollIdent` int(11) NOT NULL AUTO_INCREMENT,
  `RefNumber` varchar(12) DEFAULT NULL,
  `Benutzer` varchar(80) DEFAULT NULL,
  `Feld` varchar(30) DEFAULT NULL,
  `OldContent` varchar(250) DEFAULT NULL,
  `NewContent` varchar(250) DEFAULT NULL,
  `DateTime` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ProtokollIdent`)
) ENGINE=MyISAM AUTO_INCREMENT=262345 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPQS`
--

DROP TABLE IF EXISTS `PPQS`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=235 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `PPQSFiles`
--

DROP TABLE IF EXISTS `PPQSFiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PPQSFiles` (
  `PPQSFiles_PPQS_Id` bigint(20) NOT NULL,
  `Anfragenummer` varchar(20) NOT NULL,
  `FileName` varchar(100) NOT NULL,
  `FileType` varchar(25) NOT NULL,
  `FileDate` datetime NOT NULL,
  `FileDescription` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tPosLot`
--

DROP TABLE IF EXISTS `tPosLot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `temp`
--

DROP TABLE IF EXISTS `temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `temp` (
  `refnumber` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vPosLots`
--

DROP TABLE IF EXISTS `vPosLots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vPosLots` (
  `PPKopf_Refnumber` varchar(10) DEFAULT NULL,
  `LotIdent` int(11) DEFAULT NULL,
  `LotDelete` char(1) DEFAULT NULL,
  `LotStatus` varchar(50) DEFAULT NULL,
  `PositionIdent` int(11) DEFAULT NULL,
  `PositionDelete` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-02-04 17:06:11
