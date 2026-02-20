<?php

class NewExcelController extends BaseController {

    var $objPHPExcel;
    var $activeSheet;
    var $pp_lbl       = array('PPProduktpass_Id', 'PPProduktpass_IAN', 'PPProduktpass_Artikelbezeichnung',
        'PPProduktpass_Ausmusterung', 'PPProduktpass_Ausmusterungnummer', 'PPProduktpass_AltIAN',
        'PPProduktpass_AltArtikelbezeichnung', 'PPProduktpass_Warengruppe', 'PPProduktpass_Neu_Warengruppe',
        'PPProduktpass_Verpackungseinheit', 'PPProduktpass_Thema', 'PPProduktpass_Liefertermin',
        'PPProduktpass_Einkaeufer', 'PPProduktpass_Marke', 'PPProduktpass_Gesamtmenge',
        'PPProduktpass_Pruefinstitut', 'PPProduktpass_Andere_Kriterien', 'PPProduktpass_Zertifizierungen',
        'PPProduktpass_Logos', 'PPProduktpass_Verkaufsverpackung', 'PPProduktpass_Materialstaerke_der_Verkaufsverpackung',
        'PPProduktpass_Agentur', 'PPProduktpass_PPProjekte_Id', 'PPProduktpass_Material',
        'PPProduktpass_Lizenz', 'PPProduktpass_Status', 'PPProduktpass_PPProjekte_Projekt',
        'PPProduktpass_AktExcel', 'PPProduktpass_VorExcel', 'PPProduktpass_Importart',
        'PPProduktpass_LieferterminJahr', 'PPProduktpass_VorIAN', 'PPProduktpass_Konstruktion',
        'PPProduktpass_Verarbeitung', 'PPProduktpass_ZBV1_Name', 'PPProduktpass_ZBV1_Wert',
        'PPProduktpass_ZBV2_Name', 'PPProduktpass_ZBV2_Wert', 'PPProduktpass_ZBV3_Name',
        'PPProduktpass_ZBV3_Wert', 'PPProduktpass_ZBV4_Name', 'PPProduktpass_ZBV4_Wert',
        'PPProduktpass_ZBV5_Name', 'PPProduktpass_ZBV5_Wert', 'PPProduktpass_Produkt_ZusatzGSM',
        'PPProduktpass_Produkt_Laenge', 'PPProduktpass_Produkt_Breite', 'PPProduktpass_Produkt_Hoehe',
        'PPProduktpass_Produkt_GSM', 'PPProduktpass_WAWIArtikelnummer', 'PPProduktpass_IsRevision',
        'PPProduktpass_RevisionArt', 'PPProduktpass_Revisionsnummer', 'PPProduktpass_RevisionAktuell',
        'PPProduktpass_RevisionVon_PPProduktpass_Id', 'PPProduktpass_RevisionDatum',
        'PPProduktpass_ProjektBild', 'PPProduktpass_VersandfaehigeUmverpackung',
        'PPProduktpass_RFSicherung', 'PPProduktpass_Passformlabel', 'PPProduktpass_AndereTestkriterien',
        'PPProduktpass_ZertifizierungEigenschaften2', 'PPProduktpass_GarantiezeitDauer',
        'PPProduktpass_GarentieArt', 'PPProduktpass_LogoDruckverfahren', 'PPProduktpass_Import_BISUser_Id',
        'PPProduktpass_Import_Datum', 'PPProduktpass_Logos2', 'PPProduktpass_Logos3',
        'PPProduktpass_Positionierung', 'PPProduktpass_ZertifizierungEigenschaften3',
        'PPProduktpass_ZertifizierungEigenschaften4', 'PPProduktpass_ZertifizierungEigenschaften5',
        'PPProduktpass_Logos4', 'PPProduktpass_Logos5', 'PPProduktpass_Bemerkung');
    var $laender_lbl  = array('AT', 'CH', 'DE', 'FR', 'FI', 'LT', 'PL', 'SE', 'CZ',
        'HU', 'SI', 'SK', 'ES', 'IT', 'PT', 'BE', 'DK', 'GB', 'IE', 'NI', 'NL', 'BG',
        'CY', 'GR', 'HR', 'RO', 'RS', 'OSBE', 'OSCZ', 'OSDE', 'OSES', 'OSFR', 'OSGB',
        'OSNL', 'OSPL', 'US');
    var $purchase_lbl = array('PPPurchase_LcNumber', 'PPPurchase_ScNumber', 'PPPurchase_Inquiry',
        'PPPurchase_Supplier', 'PPPurchase_Currency', 'PPPurchase_ExcR_Save', 'PPPurchase_ExcR_Save_Date',
        'PPPurchase_ExcR_Calc', 'PPPurchase_ExcR_Remark', 'PPPurchase_CustomsCode',
        'PPPurchase_DutyPercentage', 'PPPurchase_DeliveryDate', 'PPPurchase_ResOffice',
        'PPPurchase_Description', 'PPPurchase_Material', 'PPPurchase_Remark', 'PPPurchase_TermsOfDelivery',
        'PPPurchase_TermsOfPayment', 'PPPurchase_Status', 'PPPurchase_PortOfDischarge',
        'PPPurchase_Country', 'PPPurchase_OrderDate', 'PPPurchase_SupplierDelDate',
        'PPPurchase_Factory', 'PPPurchase_EK_Calc', 'PPPurchase_EK', 'PPPurchase_Fracht',
        'PPPurchase_Zoll', 'PPPurchase_EKProvision', 'PPPurchase_Ausgangsfrachten',
        'PPPurchase_Finanzierungskosten', 'PPPurchase_Lizenzgebuehren', 'PPPurchase_Kosten',
        'PPPurchase_Translate_Quality', 'PPPurchase_Translate_Projectdescription',
        'PPPurchase_Translate_ManufacturingPlant', 'PPPurchase_Translate_Packaging',
        'PPPurchase_SonstKostenProz', 'PPPurchase_BemerkungAenderungen', 'PPPurchase_ManufacturingPlant',
        'PPPurchase_LC_TOP', 'PPPurchase_Pruefinstitut', 'PPPurchase_Transportdokumente',
        'PPPurchase_Transportdokumente2', 'PPPurchase_BWGroesse', 'PPPurchase_FOBWeek',
        'PPPurchase_FOBYear', 'PPPurchase_FOBSpecial');
    var $ab_lbl       = array('PPAB_VKEUR', 'PPAB_CD11', 'PPAB_CD12', 'PPAB_CD13',
        'PPAB_CD21', 'PPAB_CD22', 'PPAB_CD23', 'PPAB_CD31', 'PPAB_CD32', 'PPAB_CD33',
        'PPAB_CD41', 'PPAB_CD42', 'PPAB_CD43', 'PPAB_UZ', 'PPAB_Produktionsstaette_Id',
        'PPAB_Produktionsstaette', 'PPAB_Herkunftsland', 'PPAB_Masse', 'PPAB_Abgangshafen',
        'PPAB_LB1Proz', 'PPAB_LB2Proz', 'PPAB_LB3Proz', 'PPAB_LB4Proz', 'PPAB_LBloecke',
        'PPAB_KatonMasse', 'PPAB_Palettenfaktor', 'PPAB_Aufteilung_Rotterdam_FR',
        'PPAB_Aufteilung_Barcelona_FR', 'PPAB_Aufteilung_Barcelona_IT', 'PPAB_Aufteilung_Koper_IT',
        'PPAB_Produktionsstaette_LidlId', 'PPAB_Anmerkung', 'PPAB_IsBWAuftrag', 'PPAB_BWGroesse');
    var $tableConfig  = array();
    var $pc;

    const YELLOW = "E0E0E0";

    public function __construct() {

        $this->objPHPExcel = new PHPExcel();

        $this->setActiveSheetByIndex(0);
    }

    private function setActiveSheetByIndex($index) {

        $this->activeSheet = $this->objPHPExcel->getSheet($index);
    }

    private function setActiveSheetByName($sheetname) {

        $this->activeSheet = $this->objPHPExcel->getSheetByName($sheetname);
    }

    private function createSheet($sheetname) {

        $newSheet = new PHPExcel_Worksheet($this->objPHPExcel, $this->$sheetname);

        $this->objPHPExcel->addSheet($newSheet);
    }

    private function writeCell($col, $row, $value) {

        //echo($row. "  ". $col. " ". $value."<br>");
        $this->activeSheet->setCellValueByColumnAndRow($col, $row, strval($value));
    }

    private function saveExcel($file) {

        $objWriter = new PHPExcel_Writer_Excel2007($this->objPHPExcel);
        $objWriter->save($file);
    }

    private function download($dir, $file) {

        //header("Content-Type: application/vnd.ms-excel");
        //header("Content-Disposition: attachment; filename=\"$file\"");
        //readfile($dir.$file);
        // 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        //return Response::download(public_path().'/'.$dir.'/'.$file, $file,   array("content-type:application/vnd.ms-excel"));
        //echo(public_path()."$dir/$file");exit;
        //$response = Response::make($contents, $statusCode);

        return Response::download(public_path() . '/' . $dir . '/' . $file);
    }

    private function setFormatBold($coord) {

        $this->activeSheet->getStyle($coord)->getFont()->setBold(true);
    }

    private function setCellColor($coord, $color = "aabbcc") {

        $this->activeSheet->getStyle($coord)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->activeSheet->getStyle($coord)->getFill()->getStartColor()->SetARGB($color);
    }

    public function ExcelAuswertung() {

        $ausmusterung = Input::get("iAusmusterung");
        $Inq          = Input::get("iInquiries");

        $this->writePPAusmusterung($ausmusterung . "%", $Inq);

        //echo("nach write");exit;

        $file = "Uebersicht_Ausmusterung_" . $ausmusterung . ".xlsx";
        $dir  = "tmp";

        $this->saveExcel($dir . "/" . $file);

        return ($this->download($dir, $file));
    }

    private function getMengen($id) {




        $mengen = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $id)->get();

        $ret = array();
        foreach ($mengen as $menge) {
            $ret[$menge->PPProduktpass_Menge_Country]['PPProduktpass_Menge_Country']      = $menge->PPProduktpass_Menge_Country;
            $ret[$menge->PPProduktpass_Menge_Country]['PPProduktpass_Menge_CountryBlock'] = $menge->PPProduktpass_Menge_CountryBlock;
            $ret[$menge->PPProduktpass_Menge_Country]['PPProduktpass_Menge_Quantity']     = $menge->PPProduktpass_Menge_Quantity;
            $ret[$menge->PPProduktpass_Menge_Country]['PPProduktpass_Menge_DeliveryWeek'] = $menge->PPProduktpass_Menge_DeliveryWeek;
            $ret[$menge->PPProduktpass_Menge_Country]['PPProduktpass_Menge_LT1']          = $menge->PPProduktpass_Menge_LT1;
        }



        return $ret;
    }

    private function getVK($id) {

        $schnitt_total_value    = 0;
        $schnitt_total_quantity = 0;

        //echo("<br> ID: $id <br>");

        cpcDebug::cpc_debug($id);

        $mengen = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $id)->get();

        foreach ($mengen as $menge) {
            $schnitt_total_value    += $menge->PPProduktpass_Menge_Quantity * $menge->PPProduktpass_Menge_VKFOBEUR;
            $schnitt_total_quantity += $menge->PPProduktpass_Menge_Quantity;
        }


        if ($schnitt_total_quantity != 0) {

            cpcDebug::cpc_debug($schnitt_total_value / $schnitt_total_quantity);

            return $schnitt_total_value / $schnitt_total_quantity;
        }
        else {

            //echo(0);
            return 0;
        }


        return $ret;
    }

    private function getDurchschnittspreis($id) {

        $schnitt_total_value    = 0;
        $schnitt_total_quantity = 0;

        //echo("<br> ID: $id <br>");

        $mengen = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $id)->get();

        foreach ($mengen as $menge) {
            $schnitt_total_value    += $menge->PPProduktpass_Menge_Quantity * $menge->PPProduktpass_Menge_EKUSD;
            $schnitt_total_quantity += $menge->PPProduktpass_Menge_Quantity;
        }


        if ($schnitt_total_quantity != 0) {

            //echo ($schnitt_total_value / $schnitt_total_quantity);

            return $schnitt_total_value / $schnitt_total_quantity;
        }
        else {

            //echo(0);
            return 0;
        }


        return $ret;
    }

    private function getAB($id) {

        $ab = PPAB::where("PPAB_PPProduktpass_Id", "=", $id)->first();

        return $ab;
    }

    private function getStyles($id) {

        $styles = PPProduktpass_Style::where("PPProduktpass_Style_PPProduktpass_Id", "=", $id)->get();

        $ret = array();
        $i   = 0;
        foreach ($styles as $style) {
            $i++;

            $ret[$i]['PPProduktpass_Style_Header']  = $style->PPProduktpass_Style_Header;
            $ret[$i]['PPProduktpass_Style_Value01'] = $style->PPProduktpass_Style_Value01;

            $sorts_count = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $id)->where("PPProduktpass_Sortierung_Header", "=", $style->PPProduktpass_Style_Header)->count();
            if ($sorts_count > 0) {
                $sorts = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $id)->where("PPProduktpass_Sortierung_Header", "=", $style->PPProduktpass_Style_Header)->first();

                $ret[$i]['PPProduktpass_Sortierung_Size01']  = $sorts->PPProduktpass_Sortierung_Size01;
                $ret[$i]['PPProduktpass_Sortierung_Value02'] = $sorts->PPProduktpass_Sortierung_Value02;

                $ret[$i]['PPProduktpass_Sortierung_Size02']  = $sorts->PPProduktpass_Sortierung_Size02;
                $ret[$i]['PPProduktpass_Sortierung_Value03'] = $sorts->PPProduktpass_Sortierung_Value03;

                $ret[$i]['PPProduktpass_Sortierung_Size03']  = $sorts->PPProduktpass_Sortierung_Size03;
                $ret[$i]['PPProduktpass_Sortierung_Value04'] = $sorts->PPProduktpass_Sortierung_Value04;

                $ret[$i]['PPProduktpass_Sortierung_Size04']  = $sorts->PPProduktpass_Sortierung_Size04;
                $ret[$i]['PPProduktpass_Sortierung_Value05'] = $sorts->PPProduktpass_Sortierung_Value05;

                $ret[$i]['PPProduktpass_Sortierung_Size05']  = $sorts->PPProduktpass_Sortierung_Size05;
                $ret[$i]['PPProduktpass_Sortierung_Value06'] = $sorts->PPProduktpass_Sortierung_Value06;

                $ret[$i]['PPProduktpass_Sortierung_Size06']  = $sorts->PPProduktpass_Sortierung_Size06;
                $ret[$i]['PPProduktpass_Sortierung_Value07'] = $sorts->PPProduktpass_Sortierung_Value07;

                $ret[$i]['PPProduktpass_Sortierung_Size07']  = $sorts->PPProduktpass_Sortierung_Size07;
                $ret[$i]['PPProduktpass_Sortierung_Value08'] = $sorts->PPProduktpass_Sortierung_Value08;

                $ret[$i]['PPProduktpass_Sortierung_Size08']  = $sorts->PPProduktpass_Sortierung_Size08;
                $ret[$i]['PPProduktpass_Sortierung_Value09'] = $sorts->PPProduktpass_Sortierung_Value09;
            }
            else {
                for ($k = 1; $k <= 9; $k++) {
                    $att1           = "PPProduktpass_Sortierung_Size0" . $k;
                    $att2           = "PPProduktpass_Sortierung_Value0" . $k;
                    $ret[$i][$att1] = "";
                    $ret[$i][$att2] = "";
                }
            }
        }

        return $ret;
    }

    private function getPurchase($id) {

        $purchase = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $id)->first();

        $purchase['EK_average'] = $this->getDurchschnittspreis($id);

        //var_dump( $this->getDurchschnittspreis($id)." EK_average");
        //exit;
        return $purchase;
    }

    private function writePPAusmusterung($ausmusterung, $inq = 0) {

        $row = 3;
        $col = 0;

        $this->readExcel_Ini();

        //Header Zeile
        //echo("<pre>");var_dump($this->tableConfig);echo("</pre>"); exit;

        $this->writeCell($col, $row - 2, "PPProdktpass");

        foreach ($this->tableConfig['PPProduktpass'] as $lable) {
            if ($lable['IsUsed'] == "x") {
                $this->writeCell($col, $row - 1, $lable['Header_Name']);
                $col++;
            }
        }

        $this->writeCell($col, $row - 2, "PPProduktpass_Menge");

        foreach ($this->tableConfig["PPProduktpass_Menge"] as $lable) {
            if ($lable['IsUsed'] == "x") {
                $this->writeCell($col, $row - 1, $lable['Header_Name']);
                $col++;
            }
        }

        $this->writeCell($col, $row - 2, "PPProduktpass_Style");
        foreach ($this->tableConfig["PPProduktpass_Style"] as $lable) {
            if ($lable['IsUsed'] == "x") {
                $this->writeCell($col, $row - 1, $lable["Header_Name"]);
                $col++;
            }
        }

        $this->writeCell($col, $row - 2, "PPPurchase");
        foreach ($this->tableConfig["PPPurchase"] as $lable) {
            if ($lable['IsUsed'] == "x") {
                $this->writeCell($col, $row - 1, $lable["Header_Name"]);
                $col++;
            }
        }

        $this->writeCell($col, $row - 2, "PPAB");
        foreach ($this->tableConfig["PPAB"] as $lable) {
            if ($lable['IsUsed'] == "x") {
                $this->writeCell($col, $row - 1, $lable['Header_Name']);
                $col++;
            }
        }

        //Datenzeilen

        if (True) {
            if (!$inq) {
                $pps = PPProduktpass::where("PPProduktpass_Ausmusterungnummer", "like", $ausmusterung)->whereRaw('LENGTH(PPProduktpass_IAN) = ?', [
                            6])->orderBy("PPProduktpass_IAN")->get();
            }
            else {
                $pps = PPInquiry::where("PPProduktpass_Ausmusterungnummer", "like", $ausmusterung)->where("PPProduktpass_RevisionAktuell", "=", 0)->orderBy("PPProduktpass_IAN")->get();
            }


            foreach ($pps as $pp) {
                $row++;
                $col = 0;

                foreach ($this->tableConfig ['PPProduktpass'] as $lable) {
                    if ($lable['IsUsed'] == "x") {

                        $this->writeCell($col, $row, $pp->{$lable['DB_Attribut']});

                        $col++;
                    }
                }



                $m = $this->getMengen($pp->PPProduktpass_Id);

                //echo("Vor Menge: $col  <br>");
                foreach ($this->tableConfig['PPProduktpass_Menge'] as $lable) {

                    if (strlen($lable['Header_Name']) == 2 or strlen($lable['Header_Name']) == 4) {
                        $land = $lable['Header_Name'];
                    }

                    if ($lable['IsUsed'] == "x") {
                        if (isset($m[$land])) {
                            $this->writeCell($col, $row, $m[$land][$lable['DB_Attribut']]);
                        }
                        $col++;
                    }
                }

                //echo("Vor Styles: $col  <br>");
                $styles = $this->getStyles($pp->PPProduktpass_Id);

                $count = 1;
                foreach ($this->tableConfig['PPProduktpass_Style'] as $lable) {
                    if ($lable['IsUsed'] == "x") {
                        $count++;
                    }
                }

                $i = 1;
                $j = 0;
                foreach ($this->tableConfig['PPProduktpass_Style'] as $lable) {
                    $j++;
                    if ($j == 18) {
                        $i++;
                        $j = 1;
                    }
                    if (isset($styles[$i])) {

                        if ($lable['IsUsed'] == "x") {
                            $this->writeCell($col, $row, $styles[$i][$lable['DB_Attribut']]);
                            $col++;
                        }
                    }
                    else {
                        if ($lable['IsUsed'] == "x") {
                            $col++;
                        }
                    }
                }

                //echo("Vor Purchase: $col  <br>");
                $p = $this->getPurchase($pp->PPProduktpass_Id);

                foreach ($this->tableConfig['PPPurchase'] as $lable) {

                    if ($lable['IsUsed'] == "x") {
                        if (isset($p->{$lable['DB_Attribut']})) {
                            $this->writeCell($col, $row, strval($p->{$lable['DB_Attribut']}));
                            //echo($col . " " . $row . " " . $p->{$lable['DB_Attribut']} . "<br>");
                        }
                        //echo("$col $row ".$lable['DB_Attribut']."<br>" );
                        $col++;
                    }
                }



                $ab = $this->getAB($pp->PPProduktpass_Id);

                foreach ($this->tableConfig['PPAB'] as $lable) {
                    if ($lable['IsUsed'] == "x") {
                        if (isset($ab->{$lable['DB_Attribut']})) {
                            $this->writeCell($col, $row, strval($ab->{$lable['DB_Attribut']}));
                        }
                        $col++;
                    }
                }
            }
        }
    }

    public function ExcelForm() {

        $data['content'] = View::make('listen.ExcelForm');
        $data['SALs']    = $this->getSALs();
        return View::make('main', $data);
    }

    public function readExcel_Ini() {

        //echo("Start Lese Excel Konfiguration!<br>");

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $objPHPExcel  = $objReader->load("/var/www/lis/public/data/config/PPUebersicht.xlsx");
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $highestRow    = $objWorksheet->getHighestRow();
        $highestCol    = $objWorksheet->getHighestColumn();
        $highestColumn = PHPExcel_Cell::columnIndexFromString($highestCol);

        //echo("<h1>Konfiguration<h1> <br><br>Anzahl Reihen: $highestRow Anzahl Spalten: $highestColumn  <br> ");

        $Cell = array();

        $table = "Start";

        for ($col = 0; $col <= $highestColumn; $col++) {

            if (strlen($objWorksheet->getCellByColumnAndRow($col, 1)->getValue()) > 0) {
                $table = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            }
            //echo("$table <br>");

            $Cell = array('DB_Attribut' => $objWorksheet->getCellByColumnAndRow($col, 2)->getValue(),
                'Header_Name' => $objWorksheet->getCellByColumnAndRow($col, 3)->getValue(),
                'IsUsed'      => $objWorksheet->getCellByColumnAndRow($col, 4)->getValue());

            $this->tableConfig[$table][$col] = $Cell;
        }
    }

    private function setRowHeight($row, $height = -1) {

        $this->activeSheet->getRowDimension($row)->setRowHeight($height);
    }

    private function setCellWidth($cell, $width = -1) {

        $this->activeSheet->getColumnDimension($cell)->setWidth($width);
    }

    private function getRange($coord1, $coord2) {

        return $coord1 . ":" . $coord2;
    }

    private function getcoord($colno, $rowno) {

        if ($colno < 66 and $colno >= 0) {

            return chr(65 + $colno) . $rowno;
        }
        return "#";
    }

    private function getCol($colno) {

        if ($colno < 66 and $colno >= 0) {

            return chr(65 + $colno);
        }
        return "#";
    }

    private function setAlign($range, $align = "L", $vertical = "C") {

        switch ($align) {
            case "C":
                $cellalign = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                break;
            case "R":
                $cellalign = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                break;

            default:
                $cellalign = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                break;
        }
        switch ($vertical) {
            case "B":
                $verticalalign = PHPExcel_Style_Alignment::VERTICAL_BOTTOM;
                break;
            case "T":
                $verticalalign = PHPExcel_Style_Alignment::VERTICAL_TOP;
                break;

            default:
                $verticalalign = PHPExcel_Style_Alignment::VERTICAL_CENTER;
                break;
        }

        $style = array(
            'alignment' => array(
                'horizontal' => $cellalign,
                'vertical'   => $verticalalign
            )
        );
        $this->activeSheet->getStyle($range)->applyFromArray($style);
        $this->activeSheet->getStyle($range)->getAlignment()->setIndent(1);
    }

    private function setBorder($range) {
        $border = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('rgb' => '000000')
                )
            )
        );

        $this->activeSheet->getStyle($range)->applyFromArray($border);
    }

    private function getPurchaseData($ppid) {

        $whereraw = "PPPurchase_PPProduktpass_Id = $ppid";
        $purchase = PPPurchase::whereRaw($whereraw)->get()->first();
        if ($purchase) {
            return $purchase;
        }
        return false;
    }

    public function writeEK_VK_Rohertrag($ausmusterung = "2001", $kurs = 1.18) {


        //cpcDebug::dd("$ausmusterung  Kurs: $kurs", 1);


        $Headers = array(
            array('content' => 'Produktionsstaette', 'width' => 70, 'align' => 'L'),
            array('content' => 'Produktionsland', 'width' => 10, 'align' => 'L'),
            array('content' => 'PJN', 'width' => 10, 'align' => 'L'),
            array('content' => 'Artikelbezeichnung', 'width' => 60, 'align' => 'L'),
            array('content' => 'Thema', 'width' => 40, 'align' => 'L'),
            array('content' => 'Gesamtmenge', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0'),
            array('content' => 'EK Wsym', 'width' => 10, 'align' => 'C'),
            array('content' => 'EK-USD', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0.00'),
            array('content' => 'EK-EUR', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0.00'),
            array('content' => 'EK-Gesamt', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0.00'),
            array('content' => 'FOB-Latest date of shipment (CW)', 'width'   => 10,
                'align'   => 'C'),
            array('content' => 'VK-EUR', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0.00'),
            array('content' => 'VK-Gesamt', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0.00'),
            array('content' => 'Rohertrag', 'width' => 15, 'align' => 'R', 'NumberFormat' => '#,##0.00')
        );

        $col    = 0;
        $row    = 1;
        $maxRow = 500;

        $this->writeCell($col, $row, "Kurs:");
        $this->writeCell($col + 1, $row, $kurs);
        $this->setFormatBold($this->getcoord($col + 1, $row));

        $row++;

        foreach ($Headers as $header) {
            $coord  = $this->getcoord($col, $row);
            $coord1 = $this->getcoord($col, $maxRow);

            $this->writeCell($col, $row, $header['content']);
            $this->setFormatBold($this->getcoord($col, $row));
            $this->setCellColor($coord, self::YELLOW);
            $this->setCellWidth($this->getCol($col), $header['width']);
            $range = $this->getRange($coord, $coord1);
            $this->setAlign($range, $header['align']);
            if (isset($header['NumberFormat'])) {
                $this->setNumberFormat($range, $header['NumberFormat']);
            }
            $col++;
        }
        $maxCol = $col - 1;

        $this->setRowHeight($row, 40);
        $this->setBorder($this->getRange($this->getcoord(0, 1), $this->getcoord($maxCol, 1)));

        $whereraw = "length(PPProduktpass_IAN) <= 6 and PPProduktpass_Ausmusterungnummer like '$ausmusterung%'";
        $pps      = PPProduktpass::whereRaw($whereraw)->get();

        $col = 0;
        $row++;
        foreach ($pps as $pp) {

            $ppid = $pp->PPProduktpass_Id;

            $ab = $this->getAB($ppid);

            if ($ab) {
                $this->writeCell($col, $row, $ab->PPAB_Produktionsstaette);

                if (!is_null($ab->PPAB_Herkunftsland)) {
                    // cpcDebug::dd($ab->PPAB_Herkunfstland);
                    $land = PPHerkunftslaender::where("PPHerkunftslaender_Id", "=", $ab->PPAB_Herkunftsland)->get()->first();
                    $this->writeCell($col + 1, $row, $land->PPHerkunftslaender_Land);
                }
                else {
                    //cpcDebug::dd("null:" . $ab->PPAB_Herkunfstland);
                }

                if ($ab->PPAB_VKEUR > 0) {
                    $vk = $ab->PPAB_VKEUR;
                }
                else {
                    $vk = $this->getVK($ppid);
                }
            }


            $this->writeCell($col + 2, $row, $pp->PPProduktpass_IAN);
            $this->writeCell($col + 3, $row, $pp->PPProduktpass_Artikelbezeichnung);
            $this->writeCell($col + 4, $row, $pp->PPProduktpass_Thema);
            $this->writeCell($col + 5, $row, $pp->PPProduktpass_Gesamtmenge);
            //$this->writeCell($col + 4, $row, $pp->PPProduktpass_Ausmusterungnummer);
            $purchase = $this->getPurchaseData($ppid);
            if ($purchase) {
                if (!is_null($purchase->PPPurchase_EK) and $purchase->PPPurchase_EK > 0) {
                    $ek = $purchase->PPPurchase_EK;
                }
                else {
                    $ek = $this->getDurchschnittspreis($ppid);
                }

                $this->writeCell($col + 6, $row, $purchase->PPPurchase_Currency);

                if ($purchase->PPPurchase_Currency == "USD") {
                    $this->writeCell($col + 7, $row, $ek);
                    $this->writeCell($col + 8, $row, $ek / $kurs);
                }
                else {
                    $this->writeCell($col + 8, $row, $ek);
                }

                $cellEK    = $this->getcoord($col + 8, $row);
                $cellVK    = $this->getcoord($col + 11, $row);
                $cellMenge = $this->getcoord($col + 5, $row);

                $this->writeCell($col + 9, $row, "=" . $cellEK . "*" . $cellMenge);

                $this->writeCell($col + 11, $row, $vk);

                $this->writeCell($col + 12, $row, "=" . $cellVK . "*" . $cellMenge);

                $cellEKGesamt = $this->getcoord($col + 9, $row);
                $cellVKGesamt = $this->getcoord($col + 12, $row);

                $this->writeCell($col + 13, $row, "=" . $cellVKGesamt . "-" . $cellEKGesamt);
            }
            else {
                $this->writeCell($col + 6, $row, "ERROR");
            }
            $row++;
        }

        $coordFirst = $this->getcoord($col + 9, 2);
        $coordLast  = $this->getcoord($col + 9, $row - 1);
        $rangeSumme = $this->getRange($coordFirst, $coordLast);
        $this->writeCell($col + 9, $row, "=Sum($rangeSumme)");
        $coordCell  = $this->getcoord($col + 9, $row);
        $this->setCellColor($coordCell, 'FF4500');

        $coordFirst = $this->getcoord($col + 12, 2);
        $coordLast  = $this->getcoord($col + 12, $row - 1);
        $rangeSumme = $this->getRange($coordFirst, $coordLast);
        $this->writeCell($col + 12, $row, "=Sum($rangeSumme)");
        $coordCell  = $this->getcoord($col + 12, $row);
        $this->setCellColor($coordCell, 'FF4500');

        $coordFirst = $this->getcoord($col + 13, 2);
        $coordLast  = $this->getcoord($col + 13, $row - 1);
        $rangeSumme = $this->getRange($coordFirst, $coordLast);
        $this->writeCell($col + 13, $row, "=Sum($rangeSumme)");
        $coordCell  = $this->getcoord($col + 13, $row);
        $this->setCellColor($coordCell, 'FF4500');

        $this->saveExcel("EK_VK_Rohertrag.xlsx");
    }

    public function ExcelAuswertungEKVKRohertrag() {

        $ausmusterung = Input::get("iAusmusterungEKVKRohertrag");
        $kurs         = Input::get("iKurs");

        $this->writeEK_VK_Rohertrag($ausmusterung, $kurs);

        //echo("nach write");exit;

        $file = "Uebersicht_EK_VK_Rohertrag_" . $ausmusterung . ".xlsx";
        $dir  = "tmp";

        $this->saveExcel($dir . "/" . $file);

        return ($this->download($dir, $file));
    }

    private function setNumberFormat($range, $fmt = "#,###.00") {


        $this->activeSheet->getStyle($range)->getNumberFormat()->setFormatCode($fmt);
    }

}
