<?php

//
// NOTE Migration Created: 2015-02-04 16:24:20
// --------------------------------------------------

class CreateBelotexmainDatabase {//
// NOTE - Make changes to the database.
// --------------------------------------------------

    public function up() {

//
// NOTE -- Adress
// --------------------------------------------------

        Schema::create('Adress', function($table) {
            $table->increments('AdressIdent');
            $table->string('Besitzer', 40)->nullable();
            $table->string('Name', 40)->nullable();
            $table->string('Vorname', 40)->nullable();
            $table->string('PrivartStrasse', 60)->nullable();
            $table->string('PrivatLand', 3)->nullable();
            $table->string('PrivatPLZ', 8)->nullable();
            $table->string('PrivatOrt', 40)->nullable();
            $table->string('PrivatTelefon', 25)->nullable();
            $table->string('PrivatTelefax', 25)->nullable();
            $table->string('PrivatMobile', 25)->nullable();
            $table->string('PrivatEmail', 80)->nullable();
            $table->string('DienstFirma1', 40)->nullable();
            $table->string('DienstFirma2', 40)->nullable();
            $table->string('DienstStrasse', 60)->nullable();
            $table->string('DienstLand', 3)->nullable();
            $table->string('DienstPLZ', 8)->nullable();
            $table->string('DienstOrt', 40)->nullable();
            $table->string('DienstPostfach', 10)->nullable();
            $table->string('DienstPostfachPLZ', 8)->nullable();
            $table->string('DienstTelefon', 25)->nullable();
            $table->string('DienstTelefax', 25)->nullable();
            $table->string('DienstMobile', 25)->nullable();
            $table->string('DienstEmail', 80)->nullable();
            $table->string('DienstWeb', 40)->nullable();
            $table->string('Bemerkung', 250)->nullable();
            $table->string('Kategorie', 20)->nullable();
            $table->string('ZopeUser', 30)->default("NO ZOPE USER");
            $table->boolean('SafetyCat');
            $table->unsignedInteger('AktivStatus')->default("1")->unsigned();
            $table->string('password', 50);
            $table->unsignedInteger('PW_Periode');
            $table->date('PW_Lastchange');
        });


//
// NOTE -- Artikel
// --------------------------------------------------

        Schema::create('Artikel', function($table) {
            $table->string('Artikelnummer', 20)->nullable();
            $table->string('Verkaufsmengeneinheit', 4)->nullable();
            $table->string('Bezeichnung1', 40)->nullable();
            $table->string('Bezeichnung2', 40)->nullable();
            $table->unsignedInteger('Lagerbestand')->nullable();
            $table->decimal('KalkulatorischerEK', 10, 2)->nullable();
            $table->string('Artikelgruppe', 80)->nullable();
            $table->string('EANNummer', 20)->nullable();
            $table->string('USER_PHLagercode', 80)->nullable();
            $table->string('USER_Stellplatz', 10)->nullable();
            $table->unsignedInteger('BilderAnzahl')->nullable();
        });


//
// NOTE -- PPAddon
// --------------------------------------------------

        Schema::create('PPAddon', function($table) {
            $table->increments('PPKopf_Refnumber', 20);
            $table->string('pic1', 200)->default("leer");
            $table->string('picDesc1', 200);
            $table->string('pic2', 200)->default("leer");
            $table->string('picDesc2', 200);
            $table->string('pic3', 200)->default("leer");
            $table->string('picDesc3', 200);
            $table->string('pic4', 200)->default("leer");
            $table->string('picDesc4', 200);
            $table->string('pic5', 200)->default("leer");
            $table->string('picDesc5', 200);
            $table->string('pic6', 200)->default("leer");
            $table->string('picDesc6', 200);
            $table->string('ReqText1', 250)->default("Minimum requirements according to Ökotex");
            $table->string('ReqText2', 250)->default("shrinkage line drying max 4%, Tumbler drying max 4%");
            $table->string('Req1', 50)->default("4-5");
            $table->string('Req2', 50)->default("3-4");
            $table->string('Req3', 50)->default("3-4");
            $table->string('Req4', 50)->default("4");
            $table->string('Req5', 50)->default("4");
            $table->string('Req6', 50)->default("3-4");
            $table->string('Req7', 50)->default("3-4");
            $table->string('Req8', 50)->default("2-3");
            $table->string('Req9', 50);
            $table->string('Req10', 50);
            $table->string('AddCostLabel1', 100);
            $table->string('AddCostValue1', 200);
            $table->string('AddCostLabel2', 100);
            $table->string('AddCostValue2', 200);
            $table->string('AddCostLabel3', 100);
            $table->string('AddCostValue3', 200);
            $table->string('AddCostLabel4', 100);
            $table->string('AddCostValue4', 200);
            $table->string('ShipmentInformation');
            $table->string('Orderremark');
            $table->string('CartonWeightSize');
            $table->string('Req1Text', 100);
            $table->string('Req2Text', 100);
            $table->string('Req3Text', 100);
            $table->string('Req4Text', 100);
            $table->string('Req5Text', 100);
            $table->string('Req6Text', 100);
            $table->string('Req7Text', 100);
            $table->string('Req8Text', 100);
            $table->string('Req9Text', 100);
            $table->string('Req10Text', 100);
        });


//
// NOTE -- PPAdressen
// --------------------------------------------------

        Schema::create('PPAdressen', function($table) {
            $table->increments('Id');
            $table->string('Art', 3)->default("S");
            $table->string('Firma1', 250);
            $table->string('Firma2', 250)->default(" ");
            $table->string('Ansprechpartner', 250)->default(" ");
            $table->string('Adresse1', 250);
            $table->string('Adresse2', 250)->default(" ");
            $table->string('Matchcode', 250);
            $table->string('PLZ', 50);
            $table->string('Ort', 250);
            $table->string('Postfach', 250)->default(" ");
            $table->string('Land', 250)->default(" ");
            $table->string('Telefon', 250)->default(" ");
            $table->string('Fax', 250)->default(" ");
            $table->string('email', 250)->default(" ");
            $table->string('web', 250)->default(" ");
            $table->decimal('delcredere', 10, 2);
        });


//
// NOTE -- PPChangesConfirm
// --------------------------------------------------

        Schema::create('PPChangesConfirm', function($table) {
            //// FAIL $table->('AdressIdent');
            //// FAIL $table->('ProtokollIdent');
        });


//
// NOTE -- PPEmail
// --------------------------------------------------

        Schema::create('PPEmail', function($table) {
            $table->increments('EmailIdent');
            $table->string('RefNumber', 10)->nullable();
            $table->unsignedInteger('AdressIdent')->nullable();
        });


//
// NOTE -- PPGroup
// --------------------------------------------------

        Schema::create('PPGroup', function($table) {
            $table->string('GroupName', 50);
            $table->string('GroupMember', 50);
        });


//
// NOTE -- PPImport_Definition
// --------------------------------------------------

        Schema::create('PPImport_Definition', function($table) {
            $table->increments('PPImport_Definition_Id');
            $table->string('PPImport_Definition_Table', 255);
            $table->string('PPImport_Definition_Mode', 50);
            //// FAIL $table->('PPImport_Definition_Startrow');
            //// FAIL $table->('PPImport_Definition_Endrow');
            $table->string('PPImport_Definition_Sheetname', 250);
        });


//
// NOTE -- PPImport_Definition_Fields
// --------------------------------------------------

        Schema::create('PPImport_Definition_Fields', function($table) {
            //// FAIL $table->('PPImport_Definition_Id2');
            $table->string('PPImport_Definition_Fields_Field', 100);
            $table->string('PPImport_Definition_Fields_Sheet', 100);
            //// FAIL $table->('PPImport_Definition_Fields_Row');
            $table->string('PPImport_Definition_Fields_Col', 4);
        });


//
// NOTE -- PPImport_Definition_Row
// --------------------------------------------------

        Schema::create('PPImport_Definition_Row', function($table) {
            // // FAIL $table->('PPImport_Definition_Id1');
            $table->string('PPImport_Definition_Row_Field', 100);
            $table->string('PPImport_Definition_Row_Col', 4);
        });


//
// NOTE -- PPImport_Excel
// --------------------------------------------------

        Schema::create('PPImport_Excel', function($table) {
            $table->increments('PPImort__Excel_Id');
            $table->dateTime('PPImport_Excel_Datum');
            $table->string('PPImport_Excel_Dateiname', 255);
        });


//
// NOTE -- PPImport_Excel_Data
// --------------------------------------------------

        Schema::create('PPImport_Excel_Data', function($table) {
            $table->increments('PPImport_Excel_Data_Id');
            $table->string('PPImport_Excel_Data_Filename', 250);
            $table->string('PPImport_Excel_Data_Sheet', 250);
            // // FAIL $table->('PPImport_Excel_Data_Row');
            $table->string('PPImport_Excel_Data_Col', 4);
            $table->string('PPImport_Excel_Data_Value', 2500);
        });


//
// NOTE -- PPKopf
// --------------------------------------------------

        Schema::create('PPKopf', function($table) {
            $table->string('RefNumber', 10)->nullable()->unique();
            $table->string('LcNumber', 40)->nullable();
            $table->string('ScNumber', 20)->nullable();
            $table->string('FormerInquiry', 10)->nullable();
            $table->string('Supplier', 25)->nullable();
            $table->string('Category', 20)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('exch_save', 20)->nullable();
            $table->string('exch_save_art', 5)->nullable();
            $table->string('CustomsCode', 30)->nullable();
            $table->string('Customer', 50)->nullable();
            $table->decimal('DutyPercentage', 6, 2)->nullable();
            $table->string('DeliveryDate', 25)->nullable();
            $table->string('ResOffice', 25)->default("N.N.");
            $table->string('QuotaNecessarily', 3)->nullable();
            $table->string('QuotaCategory', 20)->nullable();
            //  // FAIL $table->('Description')->nullable();
            //// FAIL $table->('Material')->nullable();
            //// FAIL $table->('Remark')->nullable();
            $table->string('TermsOfDelivery', 70)->nullable();
            $table->string('TermsOfPayment', 70);
            $table->string('PackType', 25)->nullable();
            // FAIL $table->('PackDescription')->nullable();
            $table->string('PackText', 250)->nullable();
            $table->string('SamplesRequired', 3)->nullable();
            $table->string('SamplesEta', 10)->nullable();
            // FAIL $table->('SamplesRemark')->nullable();
            $table->string('Photoinlet', 25)->nullable();
            $table->string('Polybag', 25)->nullable();
            $table->string('WovenLabel', 25)->nullable();
            $table->string('Stickers', 25)->nullable();
            $table->string('WashingSymbols', 80)->nullable();
            $table->string('Temperature', 50)->nullable();
            $table->string('Triangle', 25)->nullable();
            $table->string('Iron', 25)->nullable();
            $table->string('Circle', 25)->nullable();
            $table->string('Tumbler', 25)->nullable();
            // FAIL $table->('CartonMarks')->nullable();
            // FAIL $table->('CartonMarks2')->nullable();
            // FAIL $table->('CartonMarks3')->nullable();
            $table->unsignedInteger('Archive');
            $table->string('PPStatus', 10)->nullable();
            $table->string('License', 40)->nullable();
            $table->string('PortOfDischarge', 50);
            $table->string('Country', 20);
            $table->increments('pk');
            $table->string('OrderDate', 50);
            $table->string('SupplierDelDate', 200);
            $table->string('Inquiry', 50);
            $table->string('Factory', 50);
            $table->unsignedInteger('KopfDelete');
            $table->string('cust_delterm', 50);
            $table->string('QuantityTolerance', 50);
            // FAIL $table->('DeliveryAddress');
            $table->boolean('QSneeded');
        });


//
// NOTE -- PPKopfArchiv
// --------------------------------------------------

        Schema::create('PPKopfArchiv', function($table) {
            $table->string('RefNumber', 10)->nullable()->unique();
            $table->string('LcNumber', 40)->nullable();
            $table->string('ScNumber', 20)->nullable();
            $table->string('FormerInquiry', 10)->nullable();
            $table->string('Supplier', 25)->nullable();
            $table->string('Category', 20)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('exch_save', 20)->nullable();
            $table->string('exch_save_art', 5)->nullable();
            $table->string('CustomsCode', 30)->nullable();
            $table->string('Customer', 50)->nullable();
            $table->decimal('DutyPercentage', 6, 2)->nullable();
            $table->string('DeliveryDate', 25)->nullable();
            $table->string('ResOffice', 25)->default("N.N.");
            $table->string('QuotaNecessarily', 3)->nullable();
            $table->string('QuotaCategory', 20)->nullable();
            // FAIL $table->('Description')->nullable();
            // FAIL $table->('Material')->nullable();
            // FAIL $table->('Remark')->nullable();
            $table->string('TermsOfDelivery', 70)->nullable();
            $table->string('TermsOfPayment', 70);
            $table->string('PackType', 25)->nullable();
            // FAIL $table->('PackDescription')->nullable();
            $table->string('PackText', 250)->nullable();
            $table->string('SamplesRequired', 3)->nullable();
            $table->string('SamplesEta', 10)->nullable();
            // FAIL $table->('SamplesRemark')->nullable();
            $table->string('Photoinlet', 25)->nullable();
            $table->string('Polybag', 25)->nullable();
            $table->string('WovenLabel', 25)->nullable();
            $table->string('Stickers', 25)->nullable();
            $table->string('WashingSymbols', 80)->nullable();
            $table->string('Temperature', 50)->nullable();
            $table->string('Triangle', 25)->nullable();
            $table->string('Iron', 25)->nullable();
            $table->string('Circle', 25)->nullable();
            $table->string('Tumbler', 25)->nullable();
            // FAIL $table->('CartonMarks')->nullable();
            // FAIL $table->('CartonMarks2')->nullable();
            // FAIL $table->('CartonMarks3')->nullable();
            $table->unsignedInteger('Archive');
            $table->string('PPStatus', 10)->nullable();
            $table->string('License', 40)->nullable();
            $table->string('PortOfDischarge', 50);
            $table->string('Country', 20);
            $table->increments('pk');
            $table->string('OrderDate', 50);
            $table->string('SupplierDelDate', 200);
            $table->string('Inquiry', 50);
            $table->string('Factory', 50);
            $table->unsignedInteger('KopfDelete');
            $table->string('cust_delterm', 50);
            $table->string('QuantityTolerance', 50);
            // FAIL $table->('DeliveryAddress');
        });


//
// NOTE -- PPLog
// --------------------------------------------------

        Schema::create('PPLog', function($table) {
            $table->increments('Log_Id');
            $table->string('Log_User', 50);
            $table->dateTime('Log_Date');
            $table->string('Log_Typ', 150);
        });


//
// NOTE -- PPLot
// --------------------------------------------------

        Schema::create('PPLot', function($table) {
            $table->increments('LotIdent');
            $table->string('PPKopf_RefNumber', 10)->nullable();
            $table->string('BlNumber', 25)->nullable();
            $table->string('PlannedShipmentDate', 10)->nullable();
            $table->string('LatestShipmentDate', 20)->nullable();
            $table->string('PlannedShipmentType', 20)->nullable();
            $table->string('ShippingDetails', 20)->nullable();
            $table->string('OceanVessel', 50)->nullable();
            $table->string('Eta', 10)->nullable();
            $table->string('City', 25)->nullable();
            $table->string('ForwardAgent', 50)->nullable();
            $table->string('LotDelete', 1)->nullable();
            $table->string('LotRemark', 50)->nullable();
            $table->string('LotStatus', 50);
            $table->string('LotSupplierDelDate', 50);
            $table->string('Carrier', 20);
            $table->unsignedInteger('LotNum');
            // FAIL $table->('DeliveryAddress');
            $table->string('Warehouse', 250);
        });


//
// NOTE -- PPOrderTotal
// --------------------------------------------------

        Schema::create('PPOrderTotal', function($table) {
            $table->decimal('OrderTotal', 51, 3)->nullable();
            $table->string('PPKopf_RefNumber', 10)->nullable();
        });


//
// NOTE -- PPPosLot
// --------------------------------------------------

        Schema::create('PPPosLot', function($table) {
            // FAIL $table->('PositionIdent');
            // FAIL $table->('LotIdent');
            $table->decimal('Menge', 10, 2);
        });


//
// NOTE -- PPPosLotQuantity
// --------------------------------------------------

        Schema::create('PPPosLotQuantity', function($table) {
            // FAIL $table->('Lot')->nullable();
            $table->decimal('Quantity', 41, 0)->nullable();
            $table->decimal('Value', 51, 3)->nullable();
            $table->string('PPKopf_RefNumber', 10)->nullable();
        });


//
// NOTE -- PPPosition
// --------------------------------------------------

        Schema::create('PPPosition', function($table) {
            $table->increments('PositionIdent');
            $table->string('PPKopf_RefNumber', 10)->nullable();
            $table->string('Article', 50)->nullable();
            $table->string('CustName', 25)->nullable();
            $table->string('CustNumber', 10)->nullable();
            $table->unsignedInteger('VE_OLD')->nullable();
            $table->string('Size', 25)->nullable();
            $table->string('Description', 25)->nullable();
            $table->string('Material', 25)->nullable();
            $table->decimal('DutyPercentage', 10, 2)->nullable();
            $table->decimal('Price', 10, 3)->nullable();
            $table->string('Currency', 3)->nullable();
            $table->unsignedInteger('Quantity1Lot')->nullable();
            $table->unsignedInteger('Quantity2Lot')->nullable();
            $table->unsignedInteger('Quantity3Lot')->nullable();
            $table->unsignedInteger('Quantity4Lot')->nullable();
            $table->unsignedInteger('Quantity5Lot')->nullable();
            $table->unsignedInteger('Quantity6Lot')->nullable();
            $table->unsignedInteger('Quantity7Lot')->nullable();
            $table->unsignedInteger('Quantity8Lot')->nullable();
            $table->unsignedInteger('Quantity9Lot')->nullable();
            $table->string('PositionDelete', 1)->nullable();
            $table->string('VE', 15)->nullable();
            $table->string('Bezeichnung', 50)->nullable();
            $table->string('Unit', 25);
            // FAIL $table->('QuantityOrder');
            // FAIL $table->('Quantity10Lot');
            // FAIL $table->('Quantity11Lot');
            // FAIL $table->('Quantity12Lot');
            // FAIL $table->('Quantity13Lot');
            // FAIL $table->('Quantity14Lot');
            // FAIL $table->('Quantity15Lot');
            // FAIL $table->('Quantity16Lot');
            // FAIL $table->('Quantity17Lot');
            // FAIL $table->('Quantity18Lot');
            // FAIL $table->('Quantity19Lot');
            // FAIL $table->('Quantity20Lot');
            // FAIL $table->('Quantity21Lot');
            // FAIL $table->('Quantity22Lot');
            // FAIL $table->('Quantity23Lot');
            // FAIL $table->('Quantity24Lot');
            // FAIL $table->('Quantity25Lot');
            // FAIL $table->('Quantity26Lot');
            // FAIL $table->('Quantity27Lot');
            // FAIL $table->('Quantity28Lot');
            // FAIL $table->('Quantity29Lot');
            // FAIL $table->('Quantity30Lot');
            // FAIL $table->('LotIdent_Lot1');
            // FAIL $table->('LotIdent_Lot2');
            // FAIL $table->('LotIdent_Lot3');
            // FAIL $table->('LotIdent_Lot4');
            // FAIL $table->('LotIdent_Lot5');
            // FAIL $table->('LotIdent_Lot6');
            // FAIL $table->('LotIdent_Lot7');
            // FAIL $table->('LotIdent_Lot8');
            // FAIL $table->('LotIdent_Lot9');
            // FAIL $table->('LotIdent_Lot10');
            // FAIL $table->('LotIdent_Lot11');
            // FAIL $table->('LotIdent_Lot12');
            // FAIL $table->('LotIdent_Lot13');
            // FAIL $table->('LotIdent_Lot14');
            // FAIL $table->('LotIdent_Lot15');
            // FAIL $table->('LotIdent_Lot16');
            // FAIL $table->('LotIdent_Lot17');
            // FAIL $table->('LotIdent_Lot18');
            // FAIL $table->('LotIdent_Lot19');
            // FAIL $table->('LotIdent_Lot20');
            // FAIL $table->('LotIdent_Lot21');
            // FAIL $table->('LotIdent_Lot22');
            // FAIL $table->('LotIdent_Lot23');
            // FAIL $table->('LotIdent_Lot24');
            // FAIL $table->('LotIdent_Lot25');
            // FAIL $table->('LotIdent_Lot26');
            // FAIL $table->('LotIdent_Lot27');
            // FAIL $table->('LotIdent_Lot28');
            // FAIL $table->('LotIdent_Lot29');
            // FAIL $table->('LotIdent_Lot30');
        });


//
// NOTE -- PPProduktpass
// --------------------------------------------------

        Schema::create('PPProduktpass', function($table) {
            $table->increments('PPProduktpass_Id');
            $table->string('PPProduktpass_IAN', 200);
            $table->string('PPProduktpass_Artikelbezeichnung', 50);
            $table->string('PPProduktpass_Ausmusterung', 50);
            $table->string('PPProduktpass_Ausmusterungnummer', 50);
            $table->string('PPProduktpass_AltIAN', 200);
            $table->string('PPProduktpass_AltArtikelbezeichnung', 250);
            $table->string('PPProduktpass_Warengruppe', 250);
            $table->string('PPProduktpass_Neu_Warengruppe', 250);
            $table->string('PPProduktpass_Verpackungseinheit', 250);
            $table->string('PPProduktpass_Thema', 250);
            $table->string('PPProduktpass_Liefertermin', 250);
            $table->string('PPProduktpass_Einkaeufer', 250);
            $table->string('PPProduktpass_Marke', 250);
            $table->decimal('PPProduktpass_Gesamtmenge', 10, 4);
            $table->string('PPProduktpass_Pruefinstitut', 250);
            $table->string('PPProduktpass_Andere_Kriterien', 250);
            $table->string('PPProduktpass_Zertifizierungen', 250);
            $table->string('PPProduktpass_Logos', 250);
            $table->string('PPProduktpass_Verkaufsverpackung', 250);
            $table->string('PPProduktpass_Materialstaerke_der_Verkaufsverpackung', 250);
            $table->string('PPProduktpass_Agentur', 250);
        });


//
// NOTE -- PPProduktpass_Menge
// --------------------------------------------------

        Schema::create('PPProduktpass_Menge', function($table) {
            // FAIL $table->('PPProduktpass_Menge_PPProduktpass_Id');
            $table->string('PPProduktpass_Menge_CountryBlock', 20);
            $table->string('PPProduktpass_Menge_Country', 20);
            $table->decimal('PPProduktpass_Menge_TotalSalePerUnit', 10, 4);
            $table->decimal('PPProduktpass_Menge_Quantity', 10, 4);
            $table->string('PPProduktpass_Menge_PackingMethod', 20);
            $table->string('PPProduktpass_Menge_DeliveryWeek', 4);
        });


//
// NOTE -- PPProtokoll
// --------------------------------------------------

        Schema::create('PPProtokoll', function($table) {
            $table->increments('ProtokollIdent');
            $table->string('RefNumber', 10)->nullable();
            $table->string('Benutzer', 80)->nullable();
            $table->string('Feld', 30)->nullable();
            $table->string('OldContent', 1500)->nullable();
            $table->string('NewContent', 1500)->nullable();
            $table->string('DateTime', 25)->nullable();
        });


//
// NOTE -- PPProtokollSave
// --------------------------------------------------

        Schema::create('PPProtokollSave', function($table) {
            $table->increments('ProtokollIdent');
            $table->string('RefNumber', 10)->nullable();
            $table->string('Benutzer', 80)->nullable();
            $table->string('Feld', 30)->nullable();
            $table->string('OldContent', 250)->nullable();
            $table->string('NewContent', 250)->nullable();
            $table->string('DateTime', 25)->nullable();
        });


//
// NOTE -- PPProtokollSic
// --------------------------------------------------

        Schema::create('PPProtokollSic', function($table) {
            $table->increments('ProtokollIdent');
            $table->string('RefNumber', 12)->nullable();
            $table->string('Benutzer', 80)->nullable();
            $table->string('Feld', 30)->nullable();
            $table->string('OldContent', 250)->nullable();
            $table->string('NewContent', 250)->nullable();
            $table->string('DateTime', 25)->nullable();
        });


//
// NOTE -- PPQS
// --------------------------------------------------

        Schema::create('PPQS', function($table) {
            $table->increments('PPQS_Id');
            $table->string('PPKopf_Refnumber', 20);
            $table->date('Kundentermin');
            $table->string('Fachnummer', 20);
            $table->string('Anfragenummer', 20);
            $table->string('Musterpruefung_Anzahl', 400);
            // FAIL $table->('Musterpruefung_Labor');
            $table->string('Musterpruefung_fuer', 50);
            $table->string('Waschpruefung_Kommentar', 1000);
            $table->date('Waschpruefung_Datum');
            $table->string('Waschpruefung_Status', 25)->default("nicht gefordert");
            $table->date('Prueftermin1_Datum');
            $table->string('Prueftermin1_Kommentar', 1000);
            $table->string('Prueftermin1_Status', 25)->default("offen");
            // FAIL $table->('Prueftermin1_Labor');
            $table->string('Prueftermin1_Bezeichnung', 50);
            $table->date('Prueftermin2_Datum');
            $table->string('Prueftermin2_Kommentar', 1000);
            $table->string('Prueftermin2_Status', 25)->default("nicht gefordert");
            // FAIL $table->('Prueftermin2_Labor');
            $table->string('Prueftermin2_Bezeichnung', 50);
            $table->date('Prueftermin3_Datum');
            $table->string('Prueftermin3_Kommentar', 1000);
            $table->string('Prueftermin3_Status', 25)->default("nicht gefordert");
            // FAIL $table->('Prueftermin3_Labor');
            $table->string('Prueftermin3_Bezeichnung', 50);
            $table->date('Inspektion_Datum');
            $table->string('Inspektion_Status', 25)->default("nicht gefordert");
            $table->string('Inspektion_Kommentar', 1000);
            $table->date('Produktionsmuster_Datum');
            $table->string('Produktionsmuster_Kommentar', 1000)->nullable();
            $table->string('Produktionsmuster_Status', 25)->default("offen");
            $table->string('Produktionsmuster_Bezeichnung', 50);
            $table->date('Produktionsmuster2_Datum');
            $table->string('Produktionsmuster2_Kommentar', 1000);
            $table->string('Produktionsmuster2_Status', 50)->default("offen");
            $table->string('Produktionsmuster2_Bezeichnung', 50)->default("C+K push");
            $table->date('Produktionsmuster3_Datum');
            $table->string('Produktionsmuster3_Kommentar', 1000);
            $table->string('Produktionsmuster3_Status', 50)->default("offen");
            $table->string('Produktionsmuster3_Bezeichnung', 50)->default("Produzent");
            $table->date('Produktionsmuster4_Datum');
            $table->string('Produktionsmuster4_Kommentar', 1000);
            $table->string('Produktionsmuster4_Status', 50)->default("offen");
            $table->string('Produktionsmuster4_Bezeichnung', 50)->default("Claim");
            $table->date('Produktionsmuster5_Datum');
            $table->string('Produktionsmuster5_Kommentar', 1000);
            $table->string('Produktionsmuster5_Status', 50)->default("offen");
            $table->string('Produktionsmuster5_Bezeichnung', 50)->default("Kundentermin");
            $table->string('Bemerkungen', 1000)->nullable();
            $table->string('QS_Status', 30)->default("offen");
            $table->string('QS_Material', 400);
            $table->string('QS_Artikel', 400);
            $table->string('Oekotex_Nummer', 50);
            $table->date('Oekotex_Datum');
            $table->string('Oekotex_Zertifikat', 50);
            $table->string('Oekotex_Status', 25)->default("offen");
            $table->string('AP_ECO_Status', 25)->default("offen");
            $table->date('AP_ECO_Datum');
        });


//
// NOTE -- PPQSFiles
// --------------------------------------------------

        Schema::create('PPQSFiles', function($table) {
            // FAIL $table->('PPQSFiles_PPQS_Id');
            $table->string('Anfragenummer', 20);
            $table->string('FileName', 100);
            $table->string('FileType', 25);
            $table->dateTime('FileDate');
            $table->string('FileDescription', 30);
        });


//
// NOTE -- tPosLot
// --------------------------------------------------

        Schema::create('tPosLot', function($table) {
            $table->string('PPKopf_RefNumber', 10)->nullable();
            $table->unsignedInteger('PositionIdent')->nullable();
            $table->unsignedInteger('LotIdent')->nullable();
            $table->unsignedInteger('Quantity1Lot')->nullable();
            $table->unsignedInteger('Quantity2Lot')->nullable();
            $table->unsignedInteger('Quantity3Lot')->nullable();
            $table->unsignedInteger('Quantity4Lot')->nullable();
            $table->unsignedInteger('Quantity5Lot')->nullable();
            $table->unsignedInteger('Quantity6Lot')->nullable();
            $table->unsignedInteger('Quantity7Lot')->nullable();
            $table->unsignedInteger('Quantity8Lot')->nullable();
            $table->unsignedInteger('Quantity9Lot')->nullable();
        });


//
// NOTE -- temp
// --------------------------------------------------

        Schema::create('temp', function($table) {
            $table->string('refnumber', 10);
        });


//
// NOTE -- users
// --------------------------------------------------

        Schema::create('users', function($table) {
            $table->increments('id')->unsigned();
            $table->string('email', 255)->unique();
            $table->string('name', 255);
            $table->timestamp('created_at')->default("0000-00-00 00:00:00");
            $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
        });


//
// NOTE -- vPosLots
// --------------------------------------------------

        Schema::create('vPosLots', function($table) {
            $table->string('PPKopf_Refnumber', 10)->nullable();
            $table->unsignedInteger('LotIdent')->nullable();
            $table->string('LotDelete', 1)->nullable();
            $table->string('LotStatus', 50)->nullable();
            $table->unsignedInteger('PositionIdent')->nullable();
            $table->string('PositionDelete', 1)->nullable();
        });
    }

//
// NOTE - Revert the changes to the database.
// --------------------------------------------------

    public function down() {

        Schema::drop('Adress');
        Schema::drop('Artikel');
        Schema::drop('PPAddon');
        Schema::drop('PPAdressen');
        Schema::drop('PPChangesConfirm');
        Schema::drop('PPEmail');
        Schema::drop('PPGroup');
        Schema::drop('PPImport_Definition');
        Schema::drop('PPImport_Definition_Fields');
        Schema::drop('PPImport_Definition_Row');
        Schema::drop('PPImport_Excel');
        Schema::drop('PPImport_Excel_Data');
        Schema::drop('PPKopf');
        Schema::drop('PPKopfArchiv');
        Schema::drop('PPLog');
        Schema::drop('PPLot');
        Schema::drop('PPOrderTotal');
        Schema::drop('PPPosLot');
        Schema::drop('PPPosLotQuantity');
        Schema::drop('PPPosition');
        Schema::drop('PPProduktpass');
        Schema::drop('PPProduktpass_Menge');
        Schema::drop('PPProtokoll');
        Schema::drop('PPProtokollSave');
        Schema::drop('PPProtokollSic');
        Schema::drop('PPQS');
        Schema::drop('PPQSFiles');
        Schema::drop('tPosLot');
        Schema::drop('temp');
        Schema::drop('users');
        Schema::drop('vPosLots');
    }

}
