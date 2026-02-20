<?PHP

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



define('COL_MARK', "FF6619");
define('COL_HEADER', "BFBFBF");
define('COL_FOOTER', "FF002B");
define('COL_INPUT', "FFFF00");
define('COL_RESULT', "FF9200");

class ExcelInquiryController extends BaseController {

    var $objPHPExcel;
    var $activeSheet;
    var $revsheetname;
    var $tableConfig  = array();
    var $filebasename = 'Inquiry_';
    var $inquiryfilename;
    var $filebaseext  = '.xlsx';
    var $inquirydir   = 'data/Inquiries/';
    var $templatedir  = 'data/Inquiries/templates/';
    var $InquiryId;
    var $version;

    public function __construct() {

    }

    private function setActiveSheetByName($sheetname) {

        $this->activeSheet = $this->objPHPExcel->getSheetByName($sheetname);
    }

    private function readCell($sheet, $row, $col) {

//echo($row. "  ". $col. " ". $value."<br>");
        return $this->objPHPExcel->getSheetByName($sheet)->getCellByColumnAndRow($col, $row)->getValue();
    }

    private function translate($item) {

        $wb = PPDictionary::where("PPDictionary_Language", "=", "EN")->where("PPDictionary_Eintrag", "like", trim($item))->get()->first();
        if ($wb) {
            return $wb->PPDictionary_Uebersetzung;
        }
        return "NNNNN_" . $item;
    }

    private function GetMaxDiffVersion($id) {

        cpcDebug::cpc_debug("getMaxDiffVersion Id: $id");
        $dVersion = PPInquiryDiff::where("PPInquiryDiff_PPProduktpass_Id", "=", $id)
                ->orderBy('PPInquiryDiff_Version', 'DESC')
                ->get()
                ->first();

// cpcDebug::cpc_debug(print_r($dVersion, true));

        if ($dVersion) {
            cpcDebug::cpc_debug("getDiffVersion: >" . $dVersion->PPInquiryDiff_Version . "<");
            return $dVersion->PPInquiryDiff_Version;
        }
        return 0;
    }

    private function InsertDiffHeader($value, $row) {

        $iD                                 = new PPInquiryDiff;
        $iD->PPInquiryDiff_PPProduktpass_Id = $this->InquiryId;
        $iD->PPInquiryDiff_Version          = $this->version;
        $iD->PPInquiryDiff_Header           = $value;
        $iD->PPInquiryDiff_Row              = $row;
        $iD->save();
    }

    private function InsertDiffValue($value, $col, $row) {

        $iD = PPInquiryDiff::where("PPInquiryDiff_PPProduktpass_Id", "=", $this->InquiryId)
                        ->where("PPInquiryDiff_Row", "=", $row)
                        ->where("PPInquiryDiff_Version", "=", $this->version)
                        ->get()->first();

        If (!$iD) {
            return;
        }

        if ($col > 10 or $col < 1) {
            return;
        }
        $att      = "PPInquiryDiff_Value_" . $col;
        $iD->$att = $value;
        $iD->save();
    }

    private function mergeCells($sheetname, $range) {
//$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $this->objPHPExcel->getSheetByName($sheetname)->mergeCells($range);
    }

    private function setColWidth($sheetname, $colname, $width) {
        $this->objPHPExcel->getSheetByName($sheetname)->getColumnDimension($colname)->setWidth($width);
    }

    private function writeCell($sheetname, $col, $row, $value) {

        if ($col == 0) {
//$this->InsertDiffHeader($value, $row);
            cpcDebug::cpc_debug("Insert Header: $row : $value");
        }
        else {
//$this->InsertDiffValue($value, $col, $row);
            cpcDebug::cpc_debug("Insert Value: $row : $value");
        }

        if (isset($this->revsheetname) and strlen($this->revsheetname) > 1) {
            $oldval = $this->readCell($this->revsheetname, $row, $col);
            if ($oldval != $value) {
                $this->setCellColor($col, $row, "FFD700");
                cpcDebug::cpc_debug("Found Diff in " . $this->revsheetname);
            }
        }
        $this->setCellAlign($col, $row, "left");

        if (isset($value) and!is_null($value) and strlen($value) > 0) {

            if (is_numeric(trim($value))) {
                if (doubleval($value) > 0) {
                    $this->objPHPExcel->getSheetByName($sheetname)->setCellValueByColumnAndRow($col, $row, $value);
                }
            }
            else {
                $this->objPHPExcel->getSheetByName($sheetname)->setCellValueByColumnAndRow($col, $row, $value);
            }
        }
    }

    private function saveExcel($filename) {

        $objWriter = new PHPExcel_Writer_Excel2007($this->objPHPExcel);
        $objWriter->save($filename);
    }

    private function download($fn) {

//header("Content-Type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=\"$file\"");
//readfile($dir.$file);
// 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
//return Response::download(public_path().'/'.$dir.'/'.$file, $file,   array("content-type:application/vnd.ms-excel"));
//echo(public_path()."$dir/$file");exit;
//$response = Response::make($contents, $statusCode);

        return Response::download($fn);
    }

    private function setCellAlign($col, $row, $align) {

        if ($align == 'left') {
            $this->activeSheet->getStyle($this->getCoord($col, $row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        }
        if ($align == 'right') {
            $this->activeSheet->getStyle($this->getCoord($col, $row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }
        if ($align == 'center') {
            $this->activeSheet->getStyle($this->getCoord($col, $row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
    }

    private function setCellFontSize($col, $row, $size) {
        $this->activeSheet->getStyle($this->getCoord($col, $row))->getFont()->setSize($size);
    }

    private function setFormatBold($coord) {

        $this->activeSheet->getStyle($coord)->getFont()->setBold(true);
    }

    private function setCellColor($col, $row, $color = "aabbcc") {

        $colChar = 65 + $col;
        $coord   = chr($colChar) . $row;

        $this->activeSheet->getStyle($coord)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $this->activeSheet->getStyle($coord)->getFill()->getStartColor()->SetARGB($color);
    }

    private function getCoord($col, $row) {
        $colChar = 65 + $col;
        return(chr($colChar) . $row);
    }

    private function setCellBold($col, $row) {
        $this->activeSheet->getStyle($this->getCoord($col, $row))->getFont()->setBold(true);
    }

    private function setRowHeight($row, $height) {
        $this->activeSheet->getRowDimension($row)->setRowHeight($height);
    }

    private function setCellTextColor($col, $row, $color) {

        $phpColor = new PHPExcel_Style_Color();
        $phpColor->setRGB($color);
        $this->activeSheet->getStyle($this->getCoord($col, $row))->getFont()->setColor($phpColor);
    }

    private function setCellNumberFormat($col, $row, $format = "#,##0") {
        $this->activeSheet->getStyle($this->getCoord($col, $row))->getNumberFormat()->setFormatCode($format);
        $this->setCellAlign($col, $row, "right");
    }

    public function getExcelInquiry($ian, $art) {


        //echo("getExcelInquiry art: $ian " . $art);
        //exit;

        cpcDebug::cpc_debug("getExcelInquiry art:" . $art);

        switch ($art) {
            case 1:
                $fn = $this->_getExcelInquiryBW($ian);
                break;
            case 2:
                $fn = $this->_getExcelInquiryQM($ian);
                break;

            default:
                $fn = $this->_getExcelInquiry($ian);
                break;
        }
        return Response::download($fn);
    }

    private function getDownloadFilename($ian, $bez) {

        return $ian . "_" . preg_replace('/[^a-z0-9A-Z]+/', '-', $bez) . ".xlsx";
    }

    public function _getExcelInquiry($ian) {


        $filename = $this->writeInquiry($ian);

        /* $filename = str_replace("/", "_", $filename);
          $filename = str_replace(".", "_", $filename);
          $filename = str_replace(" ", "_", $filename);
          $filename = str_replace(":", "_", $filename); */



        $dir              = public_path() . "/data/Inquiries/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $fn               = $dir . "Inquiry_" . $ian . ".xlsx";
        //$this->saveExcel($fn);
        //$downloaddir = public_path() . "/data/Inquiries/downloads/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        //$downloadfile = $downloaddir . $filename;
        $ret_downloadfile = "data/Inquiries/downloads/" . $filename;

        copy($fn, $ret_downloadfile);

        return $ret_downloadfile;
//header('/showInquiryAll');
    }

    public function _getExcelInquiryBW($ian) {


        $filename = $this->writeInquiryBW($ian);

        /* $filename = str_replace("/", "_", $filename);
          $filename = str_replace(".", "_", $filename);
          $filename = str_replace(" ", "_", $filename);
          $filename = str_replace(":", "_", $filename); */



        $dir              = public_path() . "/data/Inquiries/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $fn               = $dir . "InquiryBW_" . $ian . ".xlsx";
        $this->saveExcel($fn);
        $downloaddir      = public_path() . "/data/Inquiries/downloads/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $downloadfile     = $downloaddir . $filename;
        $ret_downloadfile = "data/Inquiries/downloads/BW_" . $filename;

        copy($fn, $ret_downloadfile);

        return $ret_downloadfile;
//header('/showInquiryAll');
    }

    public function _getExcelInquiryQM($ian) {


        $filename = $this->writeInquiryQM($ian);

        /* $filename = str_replace("/", "_", $filename);
          $filename = str_replace(".", "_", $filename);
          $filename = str_replace(" ", "_", $filename);
          $filename = str_replace(":", "_", $filename); */



        $dir              = public_path() . "/data/Inquiries/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $fn               = $dir . "QM_BW_" . $ian . ".xlsx";
        $this->saveExcel($fn);
        $downloaddir      = public_path() . "/data/Inquiries/downloads/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $downloadfile     = $downloaddir . $filename;
        $ret_downloadfile = "data/Inquiries/downloads/QM_BW_" . $filename;

        copy($fn, $ret_downloadfile);

        return $ret_downloadfile;
//header('/showInquiryAll');
    }

    public function ExcelInquiry() {

        $ian = Input::get("inpIAN");
        $fn  = $this->_getExcelInquiry($ian);

        return Response::download($fn);
    }

    private function openInquiryFile($ian, $art = "") {



        $this->inquiryfilename = public_path() . "/" . $this->inquirydir . $this->filebasename . $ian . $this->filebaseext;
        $inquiryfilenameBackup = public_path() . "/" . $this->inquirydir . "backup/" . $this->filebasename . $ian . "_" . date('YmdHis') . $this->filebaseext;

        if (false) {
            //if (file_exists($this->inquiryfilename)) {
            //$this->hier($this->inquiryfilename);
            cpcDebug::cpc_debug("Open existing Inq File");

//Sicherheitskopie:
            copy($this->inquiryfilename, $inquiryfilenameBackup);
//
//echo("Hier:  $this->inquiryfilename");
//exit;


            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(false);

            $this->objPHPExcel = $objReader->load($this->inquiryfilename);

            $this->objPHPExcel->getSheetByName('Template')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VISIBLE);

            $this->setActiveSheetByName('Template');

            $tmpsheet = $this->activeSheet->copy();
            $tmpsheet->SetTitle($ian . "Neu");
            $this->objPHPExcel->addSheet($tmpsheet);

            $this->setActiveSheetByName($ian);
            $this->revsheetname = $ian . "_Rev_" . date("Ymd_His");
            $this->activeSheet->setTitle($this->revsheetname);
            $this->setActiveSheetByName($ian . "Neu");
            $this->activeSheet->setTitle($ian);
            $this->setActiveSheetByName($ian);

            $this->objPHPExcel->getSheetByName('Template')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
            $this->objPHPExcel->getSheetByName($this->revsheetname)->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        }
        else {
            cpcDebug::cpc_debug("Create new Inq File");
            $templatefilename  = public_path() . "/" . $this->templatedir . "Inquiry_Template$art.xlsx";
//echo("Da: $templatefilename");
            $objReader         = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(false);
            $this->objPHPExcel = $objReader->load($templatefilename);
            $this->setActiveSheetByName('Template');
            $tmpsheet          = $this->objPHPExcel->getActiveSheet()->copy();
            $tmpsheet->setTitle($ian);
            $this->objPHPExcel->addSheet($tmpsheet);
            $this->setActiveSheetByName($ian);
            $this->objPHPExcel->getSheetByName('Template')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        }

        $this->activeSheet->getStyle('A1:O200')->getAlignment()->setWrapText(true);
        $this->activeSheet->getStyle('A1:O200')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    }

    private function getQM($size) {

        cpcDebug::cpc_debug("Enter getQM ( $size )");

        if (strlen($size) < 6) {
            return 0;
        }

        $f          = explode("+", $size);
        $sizeLaken  = trim($f[0]);
        $sizeKissen = trim($f[1]);

        $qm  = explode('x', $sizeLaken);
        $qmL = intval(trim($qm[0])) * intval(trim($qm[1]));

        if (strpos($sizeKissen, "*") !== false) {
            $anz_qm = explode("*", $sizeKissen);
            $anz    = $anz_qm[0];
            $qm     = explode("x", $anz_qm[1]);
            $qmK    = intval(trim($qm[0])) * intval(trim($qm[1]));
            $qmK    = $anz * $qmK;
        }
        else {
            $qm  = explode($sizeKissen);
            $qmK = intval(trim($qm[0])) * intval(trim($qm[1]));
            $qmK = $anz * $qmK;
        }
        return ($qmL + $qmK);
    }

    private function getCountrySize($country, $sizebez) {

        if (strlen($country) >= 4 and strpos($country, "OS") !== false) {
            $country = substr($country, 2, 2);
        }
        $sizes = PPBW_Laendergroessen::where('PPBW_Laendergroessen_Land', '=', $country)
                        ->where('PPBW_Laendergroessen_Groesse', '=', $sizebez)->get()->first();

        $res = "";
        if ($sizes) {
            $res = $sizes->PPBW_Laendergroessen_Bett_Laenge . "x" . $sizes->PPBW_Laendergroessen_Bett_Breite . " ";
            $res .= $sizes->PPBW_Laendergroessen_Anz_Kissen . "* " . $sizes->PPBW_Laendergroessen_Kissen_Laenge . "x" . $sizes->PPBW_Laendergroessen_Kissen_Breite . " ";
            $res .= $sizes->PPBW_Laendergroessen_Einheit;
        }
        return $res;
    }

    public function writeInquiryQM($ian) {


        cpcDebug::cpc_debug("Enter WriteInq QM");

        $this->openInquiryFile($ian, "QM");

        $ppMain = PPInquiry::where('PPProduktpass_IAN', "=", $ian)->get()->first();

        if (!$ppMain) {
            return;
        }

        cpcDebug::cpc_debug("Inquiry found: $ppMain->PPProdutpass_IAN");

        if (strlen($ppMain->PPProduktpass_PPProjekte_Projekt) > 0) {
            //$pps = PPInquiry::where('PPProduktpass_PPProjekte_Projekt', '=', trim($ppMain->PPProduktpass_PPProjekte_Projekt))
            //                ->where(DB::Raw('length(PPProduktpass_IAN)'), '<=', '8')
            //                ->orderBy('PPProduktpass_IAN')->get();

            $pps = DB::select(DB::raw("Select * from v_QM4Inquiry where PPProduktpass_PPProjekte_Projekt = '" . trim($ppMain->PPProduktpass_PPProjekte_Projekt) . "' order by QMBerechnung desc, PPProduktpass_IAN "));
        }
        else {
            $pps = PPInquiry::where('PPProduktpass_Id', '=', $ppMain->PPProduktpass_Id)->orderBy('PPProduktpass_IAN')->get();
        }



        $ppid            = $ppMain->PPProduktpass_Id;
        $this->InquiryId = $ppid;
        $this->version   = $this->GetMaxDiffVersion($this->InquiryId);
        $this->version++;

        $po = PPPurchase::where('PPPurchase_PPProduktpass_Id', "=", $ppid)->get()->first();

        $top       = PPTerms::find($po->PPPurchase_TermsOfPayment);
        $top_text1 = !is_null($po->PPPurchase_TermsOfPayment) ? $top : "";
        $top_text2 = !is_null($po->PPPurchase_LC_TOP) ? $po->PPPurchase_LC_TOP : "";

        $this->setColWidth($ian, "A", 8);
        $this->setColWidth($ian, "B", 14);
        $this->setColWidth($ian, "C", 30);
        $this->setColWidth($ian, "D", 12);
        $this->setColWidth($ian, "E", 12);
        $this->setColWidth($ian, "F", 12);
        $this->setColWidth($ian, "G", 12);
        $this->setColWidth($ian, "H", 12);
        $this->setColWidth($ian, "I", 12);
        $this->setColWidth($ian, "J", 12);
        $this->setColWidth($ian, "K", 12);
        $this->setColWidth($ian, "L", 12);
        $this->setColWidth($ian, "M", 12);

        $row = 1;
        $col = 1;
        $this->writeCell($ian, 1, $row, "Lomotex GmbH&Co.KG");
        $this->mergeCells($ian, "B$row:C$row");
        $this->setCellBold($col, $row);

        $col = 3;
        $this->setCellBold($col, $row);
        $this->mergeCells($ian, "D$row:G$row");
        $this->setCellColor($col, $row, COL_MARK);
        $this->writeCell($ian, $col, $row, "Neue BW-Maße Stand: 17.07.2018 gültig ab Juli Musterung 2018");

        $row += 2;
        $col = 1;
        $this->writeCell($ian, $col, $row, date("d.m.y"));

        $lineHeight = 17;

        $row++;

        $this->writeCell($ian, $col, $row, "Terms of Delivery:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, trim($po->PPPurchase_TermsOfDelivery));
        $row++;

        $this->writeCell($ian, $col, $row, "Fabrik:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, trim($po->PPPurchase_Supplier));
        $row++;

        $this->writeCell($ian, $col, $row, "Material:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, $po->PPPurchase_Translate_Quality);
        $this->mergeCells($ian, "C$row:F$row");

        $anzNewLine = 1 + substr_count($po->PPPurchase_Translate_Quality, "\n");
        $this->setRowHeight($row, $anzNewLine * $lineHeight);
        $row++;

        $this->writeCell($ian, $col, $row, "GSM:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, $ppMain->PPProduktpass_Produkt_GSM);
        $row++;
        $kurs = $po->PPPurchase_ExcR_Calc;

        if (!is_null($po->PPPurchase_ExcR_Save) and $po->PPPurchase_ExcR_Save != 0) {
            $kurs = $po->PPPurchase_ExcR_Save;
        }

        if ($kurs == 0) {
            $kurs = 1;
        }

        //Bis Hier OK


        $kurs = 1 / $kurs;

        $this->writeCell($ian, $col, $row, "Dollar-Kurs:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, number_format($kurs, 5, ',', '.'));
        $this->setCellNumberFormat($col + 1, $row, "0.0000");
        $this->setCellColor($col + 1, $row, COL_INPUT);
        $row++;

        $aufschlag = 14 / 100;

        $this->writeCell($ian, $col, $row, "Aufschlag:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, number_format($aufschlag, '2', ',', '.'));
        $this->setCellNumberFormat($col + 1, $row, "#,##0.00 %");
        $this->setCellColor($col + 1, $row, COL_INPUT);
        $row++;

        $this->writeCell($ian, $col + 1, $row, "Übersicht Bettwäsche");
        $this->setCellBold($col + 1, $row);
        //$this->mergeCells($ian, $this->getCoord($col + 1, $row) . ":" . $this->getCoord($col + 2, $row));

        $this->writeCell($ian, $col + 2, $row, "Übersicht Sondergrösse I");
        $this->setCellBold($col + 2, $row);
        $this->mergeCells($ian, $this->getCoord($col + 2, $row) . ":" . $this->getCoord($col + 3, $row));
        $this->mergeCells($ian, $this->getCoord($col + 2, $row + 1) . ":" . $this->getCoord($col + 3, $row + 1));
        $this->mergeCells($ian, $this->getCoord($col + 2, $row + 2) . ":" . $this->getCoord($col + 3, $row + 2));
        $this->mergeCells($ian, $this->getCoord($col + 2, $row + 3) . ":" . $this->getCoord($col + 3, $row + 3));
        $this->mergeCells($ian, $this->getCoord($col + 2, $row + 4) . ":" . $this->getCoord($col + 3, $row + 4));
        $this->mergeCells($ian, $this->getCoord($col + 2, $row + 5) . ":" . $this->getCoord($col + 3, $row + 5));

        $this->writeCell($ian, $col + 4, $row, "Übersicht Sondergrösse II");
        $this->setCellBold($col + 4, $row);
        $this->mergeCells($ian, $this->getCoord($col + 4, $row) . ":" . $this->getCoord($col + 5, $row));
        $this->mergeCells($ian, $this->getCoord($col + 4, $row + 1) . ":" . $this->getCoord($col + 5, $row + 1));
        $this->mergeCells($ian, $this->getCoord($col + 4, $row + 2) . ":" . $this->getCoord($col + 5, $row + 2));
        $this->mergeCells($ian, $this->getCoord($col + 4, $row + 3) . ":" . $this->getCoord($col + 5, $row + 3));
        $this->mergeCells($ian, $this->getCoord($col + 4, $row + 4) . ":" . $this->getCoord($col + 5, $row + 4));
        $this->mergeCells($ian, $this->getCoord($col + 4, $row + 5) . ":" . $this->getCoord($col + 5, $row + 5));

        $this->writeCell($ian, $col + 6, $row, "Summen");
        $this->setCellBold($col + 6, $row);
        $this->setCellAlign($col + 6, $row, "right");

        $row++;

        //Bis Hier OK
        //Gesamt QM

        $this->writeCell($ian, $col, $row, "Gesamt QM:");
        $this->setCellBold($col, $row);
        //$this->writeCell($ian, $col + 1, $row, $aufschlag);
        $this->setCellNumberFormat($col + 1, $row, "#,##0");
        $CellTotalQM    = $this->getCoord($col + 1, $row);
        $CellTotalQMCol = $col + 1;
        $CellTotalQMRow = $row;
        $row++;

        //Gesamt EK

        $this->writeCell($ian, $col, $row, "Gesamt EK:");
        $this->setCellBold($col, $row);
        //$this->writeCell($ian, $col + 1, $row, $aufschlag);
        $this->setCellNumberFormat($col + 1, $row, "#,##0.00 €");
        $CellTotalEK    = $this->getCoord($col + 1, $row);
        $CellTotalEKCol = $col + 1;
        $CellTotalEKRow = $row;
        $row++;

        //Gesamt VK

        $this->writeCell($ian, $col, $row, "Gesamt VK:");
        $this->setCellBold($col, $row);
        //$this->writeCell($ian, $col + 1, $row, $aufschlag);
        $this->setCellNumberFormat($col + 1, $row, "#,##0.00 €");
        $CellTotalVK    = $this->getCoord($col + 1, $row);
        $CellTotalVKCol = $col + 1;
        $CellTotalVKRow = $row;
        $row++;

        //ø EK/m²
        //Bis hier OK

        $this->writeCell($ian, $col, $row, "ø EK/m²:");

        $this->setCellBold($col, $row);

        $this->writeCell($ian, $col + 1, $row, "= $CellTotalEK / $CellTotalQM");

        $this->setCellNumberFormat($col + 1, $row, "##0.00 €");

        $ek = $this->getCoord($CellTotalEKCol + 1, $CellTotalEKRow);
        $qm = $this->getCoord($CellTotalQMCol + 1, $CellTotalQMRow);
        $this->writeCell($ian, $col + 2, $row, "=  $ek / $qm");
        $this->setCellNumberFormat($col + 2, $row, "##0.00 €");

        $ek = $this->getCoord($CellTotalEKCol + 3, $CellTotalEKRow);
        $qm = $this->getCoord($CellTotalQMCol + 3, $CellTotalQMRow);
        if ($qm <> 0) {
            $this->writeCell($ian, $col + 4, $row, "=  $ek / $qm");
        }
        $this->setCellNumberFormat($col + 4, $row, "##0.00 €");

        $CellTotalEKD    = $this->getCoord($col + 1, $row);
        $CellTotalEKDCol = $col + 1;
        $CellTotalEKDRow = $row;
        $row++;

        // ø VK/m²



        $this->writeCell($ian, $col, $row, "ø VK/m²:");
        $this->setCellBold($col, $row);

        if ($CellTotalQM <> 0) {
            $this->writeCell($ian, $col + 1, $row, "=  $CellTotalVK / $CellTotalQM");
        }
        $this->setCellNumberFormat($col + 1, $row, "##0.00 €");

        $vk = $this->getCoord($CellTotalVKCol + 1, $CellTotalVKRow);
        $qm = $this->getCoord($CellTotalQMCol + 1, $CellTotalQMRow);
        if ($qm <> 0) {
            $this->writeCell($ian, $col + 2, $row, "=  $vk / $qm");
        }$this->setCellNumberFormat($col + 2, $row, "##0.00 €");

        $vk = $this->getCoord($CellTotalVKCol + 3, $CellTotalVKRow);
        $qm = $this->getCoord($CellTotalQMCol + 3, $CellTotalQMRow);
        if ($qm <> 0) {
            $this->writeCell($ian, $col + 4, $row, "=  $vk / $qm");
        }$this->setCellNumberFormat($col + 4, $row, "##0.00 €");

        $row++;

        ////Ende


        $row += 4;

        $TotalQMCells       = array();
        $TotalEKCells       = array();
        $TotalVKCells       = array();
        $TotalQuantityCells = array();

        foreach ($pps as $pp) {
            $col = 1;

            //$QMBerechnung = $pp["QMBerechnung"];
            $ppid   = $pp->PPProduktpass_Id;
            $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', "=", $ppid)->orderBy('PPProduktpass_Menge_Country')->get();
            //$po1 = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $ppid)->orderby('PPPurchase_PPProduktpass_Id', desc)->get()->first();

            $this->writeCell($ian, $col, $row, "IAN:");
            $this->setCellBold($col, $row);

            $this->writeCell($ian, $col + 1, $row, $pp->PPProduktpass_IAN);
//$this->setCellColor($col, $row, COL_MARK);
            $this->setCellBold($col, $row);
            $row++;

            $this->writeCell($ian, $col, $row, "Size:");
            $this->setCellBold($col, $row);
            $this->writeCell($ian, $col + 1, $row, $pp->PPPurchase_BWGroesse);
            $this->setCellBold($col, $row);
            $row++;

            $colorHeader = COL_HEADER;
            $this->writeCell($ian, $col, $row, "Country");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "Size");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "Quantity");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "EK Price USD");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "EK Price EUR");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "qm");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "Total qm");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "ø EK/qm");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "ø EK/Einheit");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "VK/Einheit");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "EK-Total");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "VK-Total");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "Rohertrag");
            $this->setCellColor($col, $row, $colorHeader);
            $this->setCellBold($col, $row);
            $col++;

            $row++;

            $total           = 0;
            $summe_qmTotal   = 0;
            $summe_EKWertEUR = 0;
            $summe_Menge     = 0;

            $start_row = $row;

            foreach ($mengen as $menge) {

                $col         = 1;
                $this->writeCell($ian, $col++, $row, $menge->PPProduktpass_Menge_Country);
                $this->writeCell($ian, $col++, $row, $this->getCountrySize($menge->PPProduktpass_Menge_Country, $pp->PPPurchase_BWGroesse));
                $this->writeCell($ian, $col, $row, $menge->PPProduktpass_Menge_Quantity);
                $summe_Menge += $menge->PPProduktpass_Menge_Quantity;
                $this->setCellNumberFormat($col++, $row);
                $this->writeCell($ian, $col, $row, $menge->PPProduktpass_Menge_EKUSD);
                $this->setCellNumberFormat($col, $row, "0.00 $");
                if ($menge->PPProduktpass_Menge_Quantity > 0) {
                    $this->setCellColor($col, $row, COL_INPUT);
                }
                $col++;

                $summe_EKWertEUR = $summe_EKWertEUR + ($menge->PPProduktpass_Menge_EKUSD * $menge->PPProduktpass_Menge_Quantity * $kurs);

                $this->writeCell($ian, $col, $row, ' + E' . $row . ' / $C$8');
                $this->setCellNumberFormat($col++, $row, "#,##0.00 €");

                $qm = $this->getQM($menge->PPProduktpass_Menge_Countrysizes) / 10000;
                $this->writeCell($ian, $col, $row, $qm);
                $this->setCellNumberFormat($col++, $row, "#,##0.00");

                $qmTotal       = $qm * $menge->PPProduktpass_Menge_Quantity;
                $summe_qmTotal += $qmTotal;
                $this->writeCell($ian, $col, $row, $qmTotal);
                $this->setCellNumberFormat($col++, $row, "0,000");

                $col_durschnittEKQM = $col;
                $this->writeCell($ian, $col++, $row, "X");
                $this->writeCell($ian, $col++, $row, "DEK/Einheit");
                $this->writeCell($ian, $col++, $row, "DVK-Total");
                $this->writeCell($ian, $col++, $row, "EK-Total");
                $this->writeCell($ian, $col++, $row, "=  E" . $row . "*F" . $row);
                $this->writeCell($ian, 14, $row, $summe_EKWertEUR);

                $this->setCellNumberFormat($col - 1, $row);
                $total += $menge->PPProduktpass_Menge_Quantity;
                $row++;
            }

            $last_row           = $row - 1;
            $durschnitt_ekProQM = 0;
            if ($summe_qmTotal <> 0) {
                $durschnitt_ekProQM = $summe_EKWertEUR / $summe_qmTotal;  // [USD / qm]
            }
            for ($i = $start_row; $i <= $last_row; $i++) {
//DEK / QM Spalte:H
                //$this->writeCell($ian, $col_durschnittEKQM, $i, "= $CellTotalEKD");
                if ($pp->QMBerechnung == 1) {
                    $this->writeCell($ian, $col_durschnittEKQM, $i, "=  $CellTotalEKD");
                }
                else {
                    $c = $this->getCoord($CellTotalEKDCol + 1, $CellTotalEKDRow);
                    $this->writeCell($ian, $col_durschnittEKQM, $i, "=  $c");
                }

//$this->writeCell($ian, $col_durschnittEKQM, $i, "DEKFK");
                $this->setCellNumberFormat($col_durschnittEKQM, $i, "#,##0.00");

//Spalte J * Spalte E   DEK / Einheit
                $this->writeCell($ian, $col_durschnittEKQM + 1, $i, "= I" . $i . "* G" . $i);
                $this->setCellNumberFormat($col_durschnittEKQM + 1, $i, "#,##0.00");

//Spalte J => Spalte E + (Spalte E * Aufschlag ($C$9))  =>  VK /Einheit
                $this->writeCell($ian, $col_durschnittEKQM + 2, $i, "= J" . $i . '+(J' . $i . '* $C$9)');
                $this->setCellNumberFormat($col_durschnittEKQM + 2, $i, "#,##0.00");

//Spalte K => Gesamt_EK  Spalte E * Menge C
                $this->writeCell($ian, $col_durschnittEKQM + 3, $i, "= D" . $i . '*F' . $i);
                $this->setCellNumberFormat($col_durschnittEKQM + 3, $i, "#,##0.00");

//Spalte L: VK  Spalte J * Menge C
                $this->writeCell($ian, $col_durschnittEKQM + 4, $i, "= K" . $i . '*D' . $i);
                $this->setCellNumberFormat($col_durschnittEKQM + 4, $i, "#,##0.00");

//Spalte M: Rohertrag  Spalte J - Spalte K
                $this->writeCell($ian, $col_durschnittEKQM + 5, $i, "= M" . $i . '-L' . $i);
                $this->setCellNumberFormat($col_durschnittEKQM + 5, $i, "#,##0.00");
            }


            $col = 1;

            $colfooter = COL_FOOTER;

            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellColor($col, $row, $colfooter);
            $this->setCellTextColor($col, $row, 'FFFFFF');
            $this->setCellBold($col, $row);
            $this->writeCell($ian, $col, $row, "Total ( $pp->PPPurchase_BWGroesse )");
            $col++;

            //echo($pp->PPProduktpass_IAN . " " . $pp->QMBerechnung . " " . $pp->PPPurchase_BWGroesse . "<br>");
            //Mengen
            if ($pp->QMBerechnung == 1) {
                $TotalQuantityCells['QM'][$pp->PPPurchase_BWGroesse] = array("col" => $col,
                    "row" => $row);
            }
            else {
                $TotalQuantityCells['Sonder'][$pp->PPPurchase_BWGroesse] = array(
                    "col" => $col, "row" => $row);
            }
            $this->setCellNumberFormat($col, $row, "#,##0,00");
            $this->writeCell($ian, $col, $row, "=Sum(D" . $start_row . ":D" . $last_row . ")");
            $this->setCellColor($col, $row, $colfooter);
            $this->setCellTextColor($col, $row, 'FFFFFF');
            $this->setCellBold($col, $row);
            $this->setCellAlign($col, $row, "right");
            $col++;

            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellBold($col, $row);
            $this->setCellNumberFormat($col, $row);
            $this->setCellColor($col, $row, $colfooter);
            $col++;

            //QM
            if ($pp->QMBerechnung == 1) {
                $TotalQMCells['QM'][] = array("size" => $pp->PPPurchase_BWGroesse,
                    "col"  => $col, "row"  => $row);
            }
            else {
                $TotalQMCells['Sonder'][] = array("size" => $pp->PPPurchase_BWGroesse,
                    "col"  => $col, "row"  => $row);
            }

            $this->setCellNumberFormat($col, $row, "#,##0,00");
            $this->writeCell($ian, $col, $row, "=Sum(H" . $start_row . ":H" . $last_row . ")");
            $this->setCellColor($col, $row, $colfooter);
            $this->setCellTextColor($col, $row, 'FFFFFF');
            $this->setCellBold($col, $row);
            $this->setCellAlign($col, $row, "right");
            $col++;

            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellColor($col, $row, $colfooter);
            $col++;

            //EK
            if ($pp->QMBerechnung == 1) {
                //echo($pp->PPProduktpass_IAN . " " . $pp->QMBerechnung . " " . $pp->PPPurchase_BWGroesse . "<br>");
                $TotalEKCells['QM'][] = array("size" => $pp->PPPurchase_BWGroesse,
                    "col"  => $col, "row"  => $row);
            }
            else {
                $TotalEKCells['Sonder'][] = array("size" => $pp->PPPurchase_BWGroesse,
                    "col"  => $col, "row"  => $row);
            }

            $this->setCellNumberFormat($col, $row, "#,##0,00");
            $this->writeCell($ian, $col, $row, "=Sum(L" . $start_row . ":L" . $last_row . ")");
            $this->setCellColor($col, $row, $colfooter);
            $this->setCellTextColor($col, $row, 'FFFFFF');
            $this->setCellBold($col, $row);
            $this->setCellAlign($col, $row, "right");
            $col++;

            if ($pp->QMBerechnung == 1) {
                $TotalVKCells['QM'][] = array("size" => $pp->PPPurchase_BWGroesse,
                    "col"  => $col, "row"  => $row);
            }
            else {
                $TotalVKCells['Sonder'][] = array("size" => $pp->PPPurchase_BWGroesse,
                    "col"  => $col, "row"  => $row);
            }
            $this->setCellNumberFormat($col, $row, "#,##0,00");
            $this->writeCell($ian, $col, $row, "=Sum(M" . $start_row . ":M" . $last_row . ")");
            $this->setCellColor($col, $row, $colfooter);
            $this->setCellTextColor($col, $row, 'FFFFFF');
            $this->setCellBold($col, $row);
            $this->setCellAlign($col, $row, "right");
            $col++;

            $this->setCellNumberFormat($col, $row, "#,##0,00");
            $this->writeCell($ian, $col, $row, "=Sum(N" . $start_row . ":N" . $last_row . ")");
            $this->setCellColor($col, $row, $colfooter);
            $this->setCellTextColor($col, $row, 'FFFFFF');
            $this->setCellBold($col, $row);
            $this->setCellAlign($col, $row, "right");
            $col++;

            $row += 2;
        }



        //Bettwäsche Zusammenfassung
        //Formel GesamtEK
        $formel = "=";
        if (isset($TotalQMCells['QM']) and count($TotalQMCells['QM']) > 1) {

            foreach ($TotalEKCells['QM'] as $cell) {

                $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            }
        }
        $this->writeCell($ian, $CellTotalEKCol, $CellTotalEKRow, $formel);
        $this->setCellNumberFormat($CellTotalEKCol, $CellTotalEKRow, "0,000.00 €");

        //Formel GesamtQM
        $formel = "=";

        if (isset($TotalQMCells['QM']) and count($TotalQMCells['QM']) > 1) {
            foreach ($TotalQMCells['QM'] as $cell) {
                $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            }
        }
        $this->writeCell($ian, $CellTotalQMCol, $CellTotalQMRow, $formel);
        $this->setCellNumberFormat($CellTotalQMCol, $CellTotalQMRow, "0,000");

        //Formel GesamtVK
        $formel = "=";
        if (isset($TotalQMCells['QM']) and count($TotalQMCells['QM']) > 1) {

            foreach ($TotalVKCells['QM'] as $cell) {
                $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            }
        }
        $this->writeCell($ian, $CellTotalVKCol, $CellTotalVKRow, $formel);
        $this->setCellNumberFormat($CellTotalVKCol, $CellTotalVKRow, "#,##0.00 €");

        if (isset($TotalEKCells['Sonder'][0])) {

            //Sondergrösse I
            $formel = "=";
            $cell   = $TotalEKCells['Sonder'][0];
            $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            $this->writeCell($ian, $CellTotalEKCol + 1, $CellTotalEKRow, $formel);
            $this->setCellNumberFormat($CellTotalEKCol + 1, $CellTotalEKRow, "0,000.00 €");

            $formel = "=";
            $cell   = $TotalQMCells['Sonder'][0];
            $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            $this->writeCell($ian, $CellTotalQMCol + 1, $CellTotalQMRow, $formel);
            $this->setCellNumberFormat($CellTotalQMCol + 1, $CellTotalQMRow, "0,000");

            $formel = "=";
            $cell   = $TotalVKCells['Sonder'][0];
            $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            $this->writeCell($ian, $CellTotalVKCol + 1, $CellTotalVKRow, $formel);
            $this->setCellNumberFormat($CellTotalVKCol + 1, $CellTotalVKRow, "0,000.00 €");
        }
        else {
            $this->writeCell($ian, $CellTotalEKCol + 1, $CellTotalEKRow, 0);
            $this->setCellNumberFormat($CellTotalEKCol + 1, $CellTotalEKRow, "0,000.00 €");
            $this->writeCell($ian, $CellTotalQMCol + 1, $CellTotalQMRow, 0);
            $this->setCellNumberFormat($CellTotalQMCol + 1, $CellTotalQMRow, "0,000.00 €");
            $this->writeCell($ian, $CellTotalVKCol + 1, $CellTotalEKRow, 0);
            $this->setCellNumberFormat($CellTotalVKCol + 1, $CellTotalVKRow, "0,000.00 €");
        }



        if (isset($TotalEKCells['Sonder'][1])) {

            //Sondergrösse I
            $formel = "=";
            $cell   = $TotalEKCells['Sonder'][1];
            $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            $this->writeCell($ian, $CellTotalEKCol + 3, $CellTotalEKRow, $formel);
            $this->setCellNumberFormat($CellTotalEKCol + 3, $CellTotalEKRow, "0,000.00 €");

            $formel = "=";
            $cell   = $TotalQMCells['Sonder'][1];
            $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            $this->writeCell($ian, $CellTotalQMCol + 3, $CellTotalQMRow, $formel);
            $this->setCellNumberFormat($CellTotalQMCol + 3, $CellTotalQMRow, "0,000");

            $formel = "=";
            $cell   = $TotalVKCells['Sonder'][1];
            $formel .= "+" . $this->getCoord($cell['col'], $cell['row']);
            $this->writeCell($ian, $CellTotalVKCol + 3, $CellTotalVKRow, $formel);
            $this->setCellNumberFormat($CellTotalVKCol + 3, $CellTotalVKRow, "0,000.00 €");
        }
        else {
            $this->writeCell($ian, $CellTotalEKCol + 3, $CellTotalEKRow, "= 0");
            $this->setCellNumberFormat($CellTotalEKCol + 3, $CellTotalEKRow, "0,000.00 €");
            $this->writeCell($ian, $CellTotalQMCol + 3, $CellTotalQMRow, "= 0");
            $this->setCellNumberFormat($CellTotalQMCol + 3, $CellTotalQMRow, "0,000.00 €");
            $this->writeCell($ian, $CellTotalVKCol + 3, $CellTotalVKRow, "= 0");
            $this->setCellNumberFormat($CellTotalVKCol + 3, $CellTotalVKRow, "0,000.00 €");
        }



        //GesamtSumme
        $ek1 = $this->getCoord($CellTotalEKCol, $CellTotalEKRow);
        $ek2 = $this->getCoord($CellTotalEKCol + 1, $CellTotalEKRow);
        $ek3 = $this->getCoord($CellTotalEKCol + 3, $CellTotalEKRow);

        $formel      = "= +$ek1 +$ek2 +$ek3";
        $this->writeCell($ian, $CellTotalEKCol + 5, $CellTotalEKRow, $formel);
        $this->setCellNumberFormat($CellTotalEKCol + 5, $CellTotalEKRow, "0,000.00 €");
        $EKTotalCell = $this->getCoord($CellTotalEKCol + 5, $CellTotalEKRow);

        $vk1 = $this->getCoord($CellTotalVKCol, $CellTotalVKRow);
        $vk2 = $this->getCoord($CellTotalVKCol + 1, $CellTotalVKRow);
        $vk3 = $this->getCoord($CellTotalVKCol + 3, $CellTotalVKRow);

        $formel      = "= +$vk1 +$vk2 +$vk3";
        $this->writeCell($ian, $CellTotalVKCol + 5, $CellTotalVKRow, $formel);
        $this->setCellNumberFormat($CellTotalVKCol + 5, $CellTotalVKRow, "0,000.00 €");
        $VKTotalCell = $this->getCoord($CellTotalVKCol + 5, $CellTotalVKRow);

        $qm1 = $this->getCoord($CellTotalQMCol, $CellTotalQMRow);
        $qm2 = $this->getCoord($CellTotalQMCol + 1, $CellTotalQMRow);
        $qm3 = $this->getCoord($CellTotalQMCol + 3, $CellTotalQMRow);

        $formel = "= +$qm1 +$qm2 +$qm3";
        $this->writeCell($ian, $CellTotalQMCol + 5, $CellTotalQMRow, $formel);
        $this->setCellNumberFormat($CellTotalQMCol + 5, $CellTotalQMRow, "0,000");

        $formel = "= +$VKTotalCell -$EKTotalCell";
        $this->writeCell($ian, $CellTotalQMCol + 3, $CellTotalVKRow + 3, "Rohertrag");

        //$this->setCellBold($ian, $CellTotalQMCol + 3, $CellTotalVKRow + 3);
        $this->mergeCells($ian, $this->getCoord($CellTotalQMCol + 3, $CellTotalVKRow + 3) . ":" . $this->getCoord($CellTotalQMCol + 4, $CellTotalVKRow + 3));
        $this->writeCell($ian, $CellTotalQMCol + 5, $CellTotalVKRow + 3, $formel);
        $this->setCellNumberFormat($CellTotalQMCol + 5, $CellTotalVKRow + 3, "0,000.00 €");
        $this->setCellColor($CellTotalQMCol + 3, $CellTotalVKRow + 3, COL_RESULT);
        $this->setCellColor($CellTotalQMCol + 5, $CellTotalVKRow + 3, COL_RESULT);

        $dirX = public_path() . "/data/Inquiries/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $fnX  = $dirX . "QM_BW_" . $ian . ".xlsx";
        $this->saveExcel($fnX);

        cpcDebug::cpc_debug("Fertig InquiriyQM: $ian !");

        return $this->getDownloadFilename($ppMain->PPProduktpass_IAN, $ppMain->PPProduktpass_Artikelbezeichnung);
    }

    private function translate_bwgroesse($size) {

        // echo("Grösee: " . $size . " wird zu: ");
        $return = $size;

        switch ($size) {
            case "Einzelbett":
                $return = "normal size";
                break;

            case "Doppelbett":
                $return = "over size";
                break;

            case "Sondergrösse Kissen":
                $return = "special size cushion";
                break;

            case "Kinder":
                $return = "children";
                break;

            case "Babybettwäsche":
                $return = "Babysheets";
                break;

            default:
                $return = $size;
                break;
        }
        return $return;
    }

    private function hier($message) {
        echo($message);
        exit;
    }

    private function writeInquiryBW($ian) {


        cpcDebug::cpc_debug("Enter WriteInq BW");

        $this->openInquiryFile($ian, "BW");

        $ppMain = PPInquiry::where('PPProduktpass_IAN', "=", $ian)->get()->first();

        if (!$ppMain) {
            return;
        }


        cpcDebug::cpc_debug("Inquiry found: $ppMain->PPProdutpass_IAN");

        $ppid            = $ppMain->PPProduktpass_Id;
        $this->InquiryId = $ppid;
        $this->version   = $this->GetMaxDiffVersion($this->InquiryId);
        $this->version++;

        $po = PPPurchase::where('PPPurchase_PPProduktpass_Id', "=", $ppid)->get()->first();

        $top       = PPTerms::find($po->PPPurchase_TermsOfPayment);
        $top_text1 = !is_null($po->PPPurchase_TermsOfPayment) ? $top : "";
        $top_text2 = !is_null($po->PPPurchase_LC_TOP) ? $po->PPPurchase_LC_TOP : "";

        $this->setColWidth($ian, "A", 8);
        $this->setColWidth($ian, "B", 14);
        $this->setColWidth($ian, "C", 25);
        $this->setColWidth($ian, "D", 15);
        $this->setColWidth($ian, "E", 20);
        $this->setColWidth($ian, "F", 30);
        $this->setColWidth($ian, "G", 30);
        $this->setColWidth($ian, "H", 30);

        $row = 1;
        $col = 1;
        $this->writeCell($ian, $col, $row, "Supplier:");
        $this->setCellBold($col, $row);
        $row++;

        $lineHeight = 17;

        $this->writeCell($ian, $col, $row, "Inquiry:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, trim($po->PPPurchase_Translate_Projectdescription));
        $anzNewLine = 1 + substr_count(trim($po->PPPurchase_Translate_Projektdescription), "\n");
//$this->writeCell($ian, $col + 7, $row, $anzNewLine * $lineHeight);
        $this->setRowHeight($row, $anzNewLine * $lineHeight);
        $this->mergeCells($ian, "C$row:F$row");
        $row++;

        $this->writeCell($ian, $col, $row, "Material:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, $po->PPPurchase_Translate_Quality);
        $this->mergeCells($ian, "C$row:F$row");

        $anzNewLine = 1 + substr_count($po->PPPurchase_Translate_Quality, "\n");
//$this->writeCell($ian, $col + 7, $row, $anzNewLine * $lineHeight);
        $this->setRowHeight($row, $anzNewLine * $lineHeight);
        $row++;

        $this->writeCell($ian, $col, $row, "Packaging:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, $po->PPPurchase_Translate_Packaging);
        $this->mergeCells($ian, "C$row:E$row");
        $anzNewLine = 1 + substr_count($po->PPPurchase_Translate_Packaging, "\n");
//$this->writeCell($ian, $col + 7, $row, $anzNewLine * $lineHeight);
        $this->setRowHeight($row, $anzNewLine * $lineHeight);
        $row++;

        $this->writeCell($ian, $col, $row, "FOB:");
        $this->setCellBold($col, $row);
        $this->writeCell($ian, $col + 1, $row, $po->PPPurchase_FOBWeek . "/" . $po->PPPurchase_FOBYear);
        $row++;

        cpcDebug::cpc_debug("Projekt: $ppMain->PPProduktpass_PPProjekte_Projekt  Id: $ppMain->PPProduktpass_Id");

        if (strlen($ppMain->PPProduktpass_PPProjekte_Projekt) > 0) {
            /*   $pps = tPPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', trim($ppMain->PPProduktpass_PPProjekte_Projekt))
              ->where(DB::Raw('length(PPProduktpass_IAN)'), '<=', '6')
              ->orderBy('PPProduktpass_IAN')->get(); */
            $pps = PPInquiry::where('PPProduktpass_PPProjekte_Projekt', '=', trim($ppMain->PPProduktpass_PPProjekte_Projekt))
                            ->where(DB::Raw('length(PPProduktpass_IAN)'), '<=', '8')
                            ->orderBy('PPProduktpass_IAN')->get();

            cpcDebug::cpc_debug("Projekte");
        }
        else {
            $pps = tPPProduktpass::where('PPProduktpass_Id', '=', $ppMain->PPProduktpass_Id)->orderBy('PPProduktpass_IAN')->get();
            cpcDebug::cpc_debug("Einzeln");
        }

        $pics_inserted = false;

        foreach ($pps as $pp) {


            $ppid = $pp->PPProduktpass_Id;
            cpcDebug::cpc_debug($pp->PPProduktpass_Id);
            $col  = 1;
//***   Sortierung
            $s    = DB::table('cSortierungDistinct')->where('PPProduktpass_Sortierung_PPProduktpass_Id', "=", $ppid)
                    ->orderBy('PPProduktpass_Sortierung_Laenderblock')
                    ->orderBy('PPProduktpass_Sortierung_Header')
                    ->get();
            $lb   = "start";
            $row++;

            $this->writeCell($ian, $col, $row, "Assortment");
            $this->setCellBold($col, $row);

            $row++;
            $lineHeight = 17;
            foreach ($s as $srow) {
                if ($lb != $srow->PPProduktpass_Sortierung_Laenderblock) {
                    $lb         = $srow->PPProduktpass_Sortierung_Laenderblock;
                    $this->mergeCells($ian, "B$row:E$row");
                    $this->writeCell($ian, $col, $row, $lb);
                    $this->setCellColor($col, $row, "EEEEEE");
                    $anzNewLine = 1 + substr_count($srow->PPProduktpass_Sortierung_Laenderblock, "\n");
                    $this->setRowHeight($row, $anzNewLine * $lineHeight);
                    $row++;
                }
                $this->writeCell($ian, $col, $row, $srow->PPProduktpass_Sortierung_Header . " " . $srow->PPProduktpass_Sortierung_Value01);
                $this->mergeCells($ian, "B$row:C$row");

                $j = 3;
                for ($i = 2; $i < 3; $i++) {
                    $val = "PPProduktpass_Sortierung_Value0" . $i;
//$size = "PPProduktpass_Sortierung_Size0" . ($i - 1);
                    if (isset($srow->$val) and!is_null($srow->$val)) {
//$this->writeCell($ian, $col + $j - 2, $row, $srow->$size);
                        $this->writeCell($ian, $col + $j - 1, $row, $srow->$val);
                        $this->setCellAlign($col + $j - 2, $row, "left");
                        $this->setCellAlign($col + $j - 1, $row, "left");
                        $j += 2;
                    }
                }
                $row++;
            }


//*** Ende Sortierung


            $row_pic = $row;
            $po1     = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $ppid)->get()->first();

//Menge
            $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', "=", $ppid)->orderBy('PPProduktpass_Menge_Country')->get();

            $row += 3;
            $col = 1;
            $this->writeCell($ian, $col, $row, "IAN:");
            $this->setCellBold($col, $row);
            $this->writeCell($ian, $col + 1, $row, $pp->PPProduktpass_IAN);
            $this->setCellBold($col, $row);
            $row++;
            $this->writeCell($ian, $col, $row, "Size:");
            $this->setCellBold($col++, $row);
            $this->writeCell($ian, $col, $row, $this->translate_bwgroesse($po1->PPPurchase_BWGroesse));
            $this->setCellBold($col, $row);

            $row++;

            $col         = 1;
            $colorHeader = "DDDDDD";

            $this->writeCell($ian, $col, $row, "Country");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $this->setCellAlign($col, $row, "center");

            $col++;

            $this->writeCell($ian, $col, $row, "Size");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $col++;

            $this->writeCell($ian, $col, $row, "Quantity");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $this->setCellAlign($col, $row, "right");
            $col++;

            $this->writeCell($ian, $col, $row, "Price");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colorHeader);
            $this->setCellAlign($col, $row, "right");
            $col++;

            $row++;

            $total = 0;
            foreach ($mengen as $menge) {

                $col   = 1;
                $this->writeCell($ian, $col++, $row, $menge->PPProduktpass_Menge_Country);
                $this->setCellAlign($col - 1, $row, "center");
                $this->writeCell($ian, $col++, $row, $this->getCountrySize($menge->PPProduktpass_Menge_Country, $po1->PPPurchase_BWGroesse));
                $this->writeCell($ian, $col++, $row, $menge->PPProduktpass_Menge_Quantity);
                $this->setCellNumberFormat($col - 1, $row);
                $total += $menge->PPProduktpass_Menge_Quantity;
                $row++;
            }

            $col = 1;

            $colfooter = COL_FOOTER;

            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $range = "B" . $row . ":" . "C:" . $row;

//$this->mergeCells($ian, $range);
            //$this->hier("$ian, $col, $row, " . "Total (" . $this->translate_bwgroesse($po1->PPPurchase_BWGroesse) . ")");
            $this->writeCell($ian, $col, $row, "Total (" . $this->translate_bwgroesse($po1->PPPurchase_BWGroesse) . ")");
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colfooter);
            $col++;
            //$this->hier("$ian, $col, $row, $total");
            $this->writeCell($ian, $col, $row, number_format($total, 2, ",", "."));

            $this->setCellNumberFormat($col, $row);
            $this->setCellBold($col, $row);
            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $this->setCellColor($col, $row, $colfooter);
            $col++;

            $col_pic    = 6;
            $style_pics = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', "=", $ppid)
                            ->where('PPPPFiles_SubKat', "=", 'Styles')->get();

            if (!$pics_inserted) {
                $this->writeCell($ian, $col_pic, $row_pic, "Pictures with design discription");
                $row_pic += 2;

                foreach ($style_pics as $pic) {
                    $name     = "Style";
                    $filename = public_path() . '/data/uploads/' . $pic->PPPPFiles_Name;

                    $this->insertImage($col_pic, $row_pic, $filename, $name, 250);
                    $row_pic       += 15;
                    $pics_inserted = true;
                }

                if ($row_pic > $row) {
                    $row = $row_pic;
                }
            }

            $name     = "ProjectPicture";
            $filename = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;

            $this->insertImage($col_pic, $row_pic + 20, $filename, $name, 250);
        }


        $dirX = public_path() . "/data/Inquiries/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $fnX  = $dirX . "InquiryBW_" . $ian . ".xlsx";
        $this->saveExcel($fnX);

        cpcDebug::cpc_debug("Fertig Inquiriy: $ian !");
        return $this->getDownloadFilename($ppMain->PPProduktpass_IAN, $ppMain->PPProduktpass_Artikelbezeichnung);
    }

    private function writeInquiry($ian) {


        cpcDebug::cpc_debug("Enter WriteInq");

        $this->openInquiryFile($ian);

        $pp = PPInquiry::where('PPProduktpass_IAN', "=", $ian)->get()->first();

        if (!$pp) {
            return;
        }



        $ppid            = $pp->PPProduktpass_Id;
        $this->InquiryId = $ppid;
        $this->version   = $this->GetMaxDiffVersion($this->InquiryId);
        $this->version++;

        $po = PPPurchase::where('PPPurchase_PPProduktpass_Id', "=", $ppid)->get()->first();

        $top       = PPTerms::find($po->PPPurchase_TermsOfPayment);
        $top_text1 = !is_null($po->PPPurchase_TermsOfPayment) ? $top : "";
        $top_text2 = !is_null($po->PPPurchase_LC_TOP) ? $po->PPPurchase_LC_TOP : "";

        $col = 1;

        $this->writeCell($ian, $col - 1, 4, "Lidl sampling");
        $this->writeCell($ian, $col, 4, substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4));
        $this->setCellBold($col, 4);
        $this->setCellAlign($col, 4, "left");

        $this->writeCell($ian, $col - 1, 5, "IAN");
        $this->setCellBold($col - 1, 5);
        $this->setCellFontSize($col - 1, 5, 18);
        $this->writeCell($ian, $col, 5, $pp->PPProduktpass_IAN);
        $this->setCellBold($col, 5);
        $this->setCellFontSize($col, 5, 18);

        $this->writeCell($ian, $col - 1, 6, "Price");
        $this->setCellColor($col, 6, "F89406");
        $this->setCellBold($col, 6);
        $this->setCellBold($col - 1, 6);
        $this->setCellFontSize($col, 6, 18);
        $this->setCellFontSize($col - 1, 6, 18);
        $this->setCellNumberFormat($col, 6, "#.##0,00");
        $this->setCellAlign($col, 6, "left");

        $this->writeCell($ian, $col - 1, 7, "Article discription");
        $this->writeCell($ian, $col, 7, $pp->PPProduktpass_Artikelbezeichnung);

        $this->writeCell($ian, $col - 1, 8, "Terms of payment");
        $this->writeCell($ian, $col, 8, $top_text1 . " " . $top_text2);

        $this->writeCell($ian, $col - 1, 10, "Phase");
        $this->writeCell($ian, $col, 10, $pp->PPProduktpass_Thema);

        $this->writeCell($ian, $col, 11, "Packing");
        $this->writeCell($ian, $col, 11, $pp->PPProduktpass_Verkaufsverpackung);
        $this->writeCell($ian, $col, 12, $pp->PPProduktpass_Materialstaerke_der_Verkaufsverpackung);

        $row = 13;
        $this->writeCell($ian, $col - 1, $row, "Required Certificates");
        $this->setCellBold($col - 1, $row);
        $this->setCellFontSize($col, $row, 14);

        if (strlen($pp->PPProduktpass_Zertifizierungen) > 1) {
            $this->writeCell($ian, $col, $row, $pp->PPProduktpass_Zertifizierungen);
            $row++;
        }
        if (strlen($pp->PPProduktpass_ZertifizierungEigenschaften2) > 1) {
            $this->writeCell($ian, $col, $row, $pp->PPProduktpass_ZertifizierungEigenschaften2);
            $row++;
        }
        if (strlen($pp->PPProduktpass_ZertifizierungEigenschaften3) > 1) {
            $this->writeCell($ian, $col, $row, $pp->PPProduktpass_ZertifizierungEigenschaften3);
            $row++;
        }
        if (strlen($pp->PPProduktpass_ZertifizierungEigenschaften4) > 1) {
            $this->writeCell($ian, $col, $row, $pp->PPProduktpass_ZertifizierungEigenschaften4);
            $row++;
        }
        if (strlen($pp->PPProduktpass_ZertifizierungEigenschaften5) > 1) {
            $this->writeCell($ian, $col, $row, $pp->PPProduktpass_ZertifizierungEigenschaften5);
            $row++;
        }
        $row++;
        $q = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', "=", $ppid)->get();

// Qualitaet Output
        $this->writeCell($ian, $col - 1, $row, "Quantity pcs or sets"); //`PPProduktpass_Gesamtmenge`

        $gsm = number_format($pp->PPProduktpass_Gesamtmenge, 0, ".", ",");

        $gsm = str_replace(',', '', $gsm);
        $gsm = str_replace('.', '', $gsm);

        $this->setCellFontSize($col, $row, 30);
        $this->setCellAlign($col, $row, "right");
        $this->setCellNumberFormat($col, $row, "#,##0");

        $this->writeCell($ian, $col, $row, $gsm);
        $this->setCellBold($col - 1, $row);
        $this->setCellBold($col, $row);

        $row++;

        $this->writeCell($ian, $col - 1, $row, "Delivery FOB"); //`PPProduktpass_Gesamtmenge`
        $this->writeCell($ian, $col, $row, $pp->PPProduktpass_Liefertermin);
        $row++;

        foreach ($q as $qrow) {
            $title      = $this->translate($qrow->PPProduktpass_Qualitaet_Header);
            $printTitle = false;
            if (is_null($title) or strlen(trim($title)) < 1) {
                $title      = "H" . $row;
                $printTitle = true;
            }

            for ($i = 1; $i < 15; $i++) {
                if ($i < 10) {
                    $valueBez = 'PPProduktpass_Qualitaet_Value0' . $i;
                }
                else {
                    $valueBez = 'PPProduktpass_Qualitaet_Value' . $i;
                }
                if (!is_null($qrow->$valueBez) and strlen(trim($qrow->$valueBez)) > 1) {
                    $printTitle = true;
                }
            }
            if ($printTitle) {
                $this->writeCell($ian, $col - 1, $row, $title);
            }

            for ($i = 1; $i < 15; $i++) {
                if ($i < 10) {
                    $valueBez = 'PPProduktpass_Qualitaet_Value0' . $i;
                }
                else {
                    $valueBez = 'PPProduktpass_Qualitaet_Value' . $i;
                }
                if (!is_null($qrow->$valueBez) and strlen(trim($qrow->$valueBez)) > 1) {
                    $this->writeCell($ian, $col - 1 + $i, $row, $qrow->$valueBez);
                    $this->setCellAlign($col - 1 + $i, $row, "left");
                }
            }
            if ($printTitle) {
                $row++;
            }
        }


        $style = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', "=", $pp->PPProduktpass_Id)->get();

        $this->writeCell($ian, $col - 1, $row, "Style and Product Information");
        $this->setCellBold($col - 1, $row);
        $this->setCellFontSize($col, $row, 14);
        $row++;

        foreach ($style as $s) {

            $this->writeCell($ian, $col - 1, $row, $s->PPProduktpass_Style_Header);
            $this->writeCell($ian, $col, $row, $s->PPProduktpass_Style_Value01);
            $this->writeCell($ian, $col + 1, $row, $s->PPProduktpass_Style_Value02);
            $row++;
        }

        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', "=", $pp->PPProduktpass_Id)
                        ->where('PPPPFiles_SubKat', "=", 'Carelabel')->get()->first();
        if ($files) {
            $this->writeCell($ian, $col - 1, $row, "Carelabel");
            $name     = "Carelabel";
            $filename = public_path() . '/data/uploads/' . $files->PPPPFiles_Name;
            $this->insertImage($col, $row, $filename, $name);
            $row      += 3;
        }

        $s  = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', "=", $ppid)
                ->orderBy('PPProduktpass_Sortierung_Laenderblock')
                ->orderBy('PPProduktpass_Sortierung_Header')
                ->get();
        $lb = "start";
        $this->writeCell($ian, $col, $row, "Assortment");
        $row++;
        $this->writeCell($ian, $col + 1, $row, "Style Breakdown");
        $this->setCellBold($col, $row);

        $row++;
        foreach ($s as $srow) {
            if ($lb != $srow->PPProduktpass_Sortierung_Laenderblock) {
                $lb = $srow->PPProduktpass_Sortierung_Laenderblock;
                $this->writeCell($ian, $col, $row, $lb);
                $this->mergeCells($ian, "B" . $row . ":D$row");
                $this->setCellColor($col, $row, "EEEEEE");
                $this->setCellColor($col + 1, $row, "EEEEEE");
                $row++;
            }
            $this->writeCell($ian, $col, $row, $srow->PPProduktpass_Sortierung_Header . " " . $srow->PPProduktpass_Sortierung_Value01);
            $this->mergeCells($ian, "B" . $row . ":D$row");

//$this->writeCell($ian, $col - 1 + 1, $row,$srow->PPProduktpass_Sortierung_Value01 );
            $j = 3;
            for ($i = 2; $i < 10; $i++) {
                $val  = "PPProduktpass_Sortierung_Value0" . $i;
                $size = "PPProduktpass_Sortierung_Size0" . ($i - 1);
                if (isset($srow->$val) and!is_null($srow->$val)) {
                    $this->writeCell($ian, $col + $j - 2, $row, $srow->$size);
                    $this->writeCell($ian, $col + $j - 1, $row, $srow->$val);
                    $this->setCellAlign($col + $j - 2, $row, "left");
                    $this->setCellAlign($col + $j - 1, $row, "left");
                    $j++;
                }
            }
            $row++;
        }



        $row++;
        $style_pics = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', "=", $pp->PPProduktpass_Id)
                        ->where('PPPPFiles_SubKat', "=", 'Styles')->get();
        $this->writeCell($ian, $col - 1, $row, "Pictures with design discription");
        $row++;
        foreach ($style_pics as $pic) {
            $name     = "Style";
            $filename = public_path() . '/data/uploads/' . $pic->PPPPFiles_Name;

            $this->insertImage($col, $row, $filename, $name, 250);
            $row = $row + 15;
        }

        $this->writeCell($ian, $col - 1, $row, "Projectpicture");
        $name     = "Projectpicture";
        $filename = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;

        /* if (!$this->insertImage($col, $row, $filename, $name, 250)) {
          $this->writeCell($ian, $col, $row, "Error: " . $filename);
          } */



        $dirX = public_path() . "/data/Inquiries/"; ///var/www/html/lomotex/bis/public/data/Inquiries
        $fnX  = $dirX . "Inquiry_" . $ian . ".xlsx";
        $this->saveExcel($fnX);

        return $this->getDownloadFilename($pp->PPProduktpass_IAN, $pp->PPProduktpass_Artikelbezeichnung);
    }

    private function insertImage($col, $row, $filename, $name, $height = 50) {

        if (!file_exists($filename)) {
            return false;
        }
        try {
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName($name);
            $objDrawing->setDescription($name);
            $objDrawing->setPath($filename);
            $objDrawing->setCoordinates($this->getCoord($col, $row));
//setOffsetX works properly
            $objDrawing->setOffsetX(5);
            $objDrawing->setOffsetY(5);
//set width, height
//$objDrawing->setWidth(400);
            $objDrawing->setHeight($height);
            $objDrawing->setWorksheet($this->activeSheet);
        }
        catch (Exception $e) {
            //cpcDebug::cpc_debug(print_r($e, true));
            return false;
        }
        return true;
    }

    public function ExcelForm() {

        $data['content'] = View::make('listen.ExcelInquiryForm');

        return View::make('main', $data);
    }

    public function readExcel_Ini() {

//echo("Start Lese Excel Konfiguration!<br>");

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $objPHPExcel  = $objReader->load("/var/www/html/lomotex/bis/public/data/config/PPUebersicht.xlsx");
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

}
