<?php
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
class ExcelController extends BaseController
{
    private $worksheet = null;
    private $_lbez = array(
        'DE' => 'Deutschland (ohne OnlineShop) (ohne Kaufland)',
        'FR' => 'Frankreich (ohne OnlineShop)',
        'IT' => 'Italien (ohne OnlineShop)',
        'ES' => 'Spanien',
        'GB' => 'England (ohne OnlineShop)',
        'BE' => 'Belgien (ohne OnlineShop)',
        'PT' => 'Portugal',
        'NL' => 'Holland (ohne OnlineShop)',
        'AT' => 'Österreich (ohne Online Shop)',
        'GR' => 'Griechenland',
        'IE' => 'Irland',
        'NI' => 'Nord-Irland',
        'PL' => 'Polen (ohne Online Shop) (ohne Kaufland)',
        'FI' => 'Finnland',
        'CZ' => 'Tschechei (ohne OnlineShop)   (ohne Kaufland)',
        'SE' => 'Schweden',
        'SK' => 'Slowakei (ohne Online Shop) (ohne Kaufland)',
        'HU' => 'Ungarn (ohne OnlineShop)',
        'DK' => 'Dänemark (ohne  Online Shop)',
        'HR' => 'Kroatien (ohne Kaufland)',
        'SI' => 'Slowenien',
        'CH' => 'Schweiz',
        'CY' => 'Zypern',
        'BG' => 'Bulgarien (ohne Kaufland)',
        'RO' => 'Rumänien (ohne Kaufland)',
        'LT' => 'Litauen',
        'US' => 'USA',
        'RS' => 'Serbien',
        'EE' => 'Estland',
        'LV' => 'Lettland',
        'MK' => 'Mazedonien',
        'BA' => 'Bosnien-Herzegowina',
        'OSDE' => 'OnlineShop DE',
        'OSBE' => 'OnlineShop BE',
        'OSNL' => 'OnlineShop NL',
        'OSCZ' => 'OnlineShop CZ',
        'OSES' => 'OnlineShop ES',
        'OSGB' => 'OnlineShop GB',
        'OSFR' => 'OnlineShop FR',
        'OSPL' => 'OnlineShop PL',
        'OSSK' => 'OnlineShop SK',
        'OSAT' => 'OnlineShop AT',
        'OSDK' => 'OnlineShop DK',
        'OSHU' => 'OnlineShop HU',
        'OSIT' => 'OnlineShop IT',
        'OSPT' => 'OnlineShop PT',
        'OSSI' => 'OnlineShop SI',
        'OSFI' => 'OnlineShop FI',
        'OSSE' => 'OnlineShop SE',
        'OSRO' => 'OnlineShop RO',
        'OSHR' => 'OnlineShop HR',
        'OSBG' => 'OnlineShop BG',
        'KDE' => 'Kaufland DE',
        'KPL' => 'Kaufland PL',
        'KCZ' => 'Kaufland CZ',
        'KRO' => 'Kaufland RO',
        'KSK' => 'Kaufland SK',
        'KHR' => 'Kaufland HR',
        'KBG' => 'Kaufland BG',
        'KODE' => 'Kaufland OSDE',
        'KOSK' => 'Kaufland OSSK',
        'KOCZ' => 'Kaufland OSCZ'
    );
    private function getCell($colNo, $row)
    {
        $pre = '';
        if ($colNo > 65) {
            $colNo = $colNo - 65;
            $pre = 'A';
        }
        $cell = $pre . chr($colNo + 64) . $row;
        //echo($cell."<br>"); 
        return $pre . chr($colNo + 64) . $row;
    }
    private function getCellA($colNo, $row)
    {
        return array('Cell' => $this->getCell($colNo, $row), 'Row' => $row, 'Col' => $colNo);
    }
    public function writeExcel_postNeu()
    {
        return $this->writeExcel_post(true);
    }
    public function writeExcel_post($neu = false)
    {
        //cpcDebug::cpc_debug(Input::all(),'@MailDL');
        if (Input::has('ppid')) {
            $id = Input::get('ppid');
        } else {
            echo ('No Input');
            exit;
        }
        $send = false;
        if (Input::has('sendmail')) {
            $send = true;
        }
        $to = '';
        if (Input::has('mailto')) {
            $to = Input::get('mailto');
        } else {
            $send = false;
        }
        $cc = array();
        if (Input::has('mailcc')) {
            $cc[] = Input::get('mailcc');
        }
        $cc2 = '';
        if (Input::has('mailcc2')) {
            $cc[] = Input::get('mailcc2');
        }
        $cc4 = '';
        if (Input::has('mailccPJM')) {
            $cc[] = Input::get('mailccPJM');
        }
        $download = false;
        if (Input::has('download')) {
            $download = true;
        }
        $body = '';
        if (Input::has('mailbody')) {
            $body = Input::get('mailbody');
        }
        //cpcDebug::cpc_debug($cc, '@MailDL');
        //echo( "ID: $id  Send: $send To: $to CC: $cc Body: $body Download: $download <br>");exit;
        return $this->writeExcel_Anfrage($id, $send, $to, $cc, $body, $download, $neu);
    }
    private function setCellValueCompare($cell, $man, $comp, $att)
    {
        $styleArray = array(
            /*'borders' => array(
				'outline' => array(
					'borderStyle' => 'thick',
					'color' => array('rgb' => 'FF0000'),
				),
			),*/
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '1e90ff'),
                'size'  => 10,
                'name'  => 'Arial'
            )
        );
        //echo($att."<br>");
        //echo('<pre>');print_r($comp);exit;
        //$this->worksheet->getStyle($cell)->getFont()->setColor( new PhpOffice\PhpSpreadsheet\Style\Color(PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED) );
        if (strpos($att, 'PM_PlanMenge') === 0) {
            if ($att == 'PM_PlanMengeDE') {
                $val = round($man->PPInputManuell_PlanmengePM * 0.22, 0);
                //$val = 15;
            } else if ($att == 'PM_PlanMengeEU') {
                $val = round($man->PPInputManuell_PlanmengePM * 0.78, 0);
                //$val=85;
            } else {
                $val = $man->PPInputManuell_PlanmengePM;
            }
            $this->worksheet->setCellValue($cell, $val);
            return;
        }
        if ($comp[$att]['Diff']) {
            $this->worksheet->getStyle($cell)->applyFromArray($styleArray);
        }
        $this->worksheet->setCellValue($cell, $man->{$att});
        if (strpos('PPInputManuell_Onlinekartonage PPInputManuell_ServiceVetrag', $att) !== false) {
            $JaNein = "Nein";
            if ($man->{$att} == 1) {
                $JaNein = 'Ja';
            }
            $this->worksheet->setCellValue($cell, $JaNein);
        }
        if (strpos('PPInputManuell_UAWGB', $att) !== false) {
            $uawgb = new DateTime($man->{$att});
            $this->worksheet->setCellValue($cell, $uawgb->format('d.m.Y'));
        }
        if (strpos('PPInputManuell_GeplanterEKUSD', $att) !== false) {
            $ek  = number_format($man->PPInputManuell_GeplanterEKUSD, 2, ',', '.') . " " . $man->PPInputManuell_EKWSYM;
            $this->worksheet->setCellValue($cell, $ek);
        }
        if (strpos('PPInputManuell_SonderleistungLieferant', $att) !== false) {
            $val1 = $man->PPInputManuell_SonderleistungLieferant;
            if (is_numeric($val1)) {
                $val1  = $man->PPInputManuell_SonderleistungLieferant / 100;
            }
            $this->worksheet->setCellValue($cell, $val1);
            //$this->worksheet->getStyle($cell)->getNumberFormat()>applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
        }
        if (strpos('PPInputManuell_MaxAusfallrate', $att) !== false) {
            $val1 =  $man->PPInputManuell_MaxAusfallrate;
            if (is_numeric($val1)) {
                $val1  = $man->PPInputManuell_MaxAusfallrate / 100;
            }
            $this->worksheet->setCellValue($cell, $val1);
            //$this->worksheet->getStyle($cell)->getNumberFormat()>applyFromArray(["code" => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE]);
        }
    }
    private function getCRDDate($lt)
    {
        if (strlen($lt) <> 5) {
            return '';
        }
        $ddp = explode('/', $lt);
        $w = $ddp[0];
        $y = 2000 + $ddp[1];
        $date = (new DateTimeImmutable())->setISODate($y, $w)->modify('-12 weeks');
        $isoYearShort = substr($date->format('o'), -2);
        $weekNumber = $date->format('W');
        return $weekNumber . '/' . $isoYearShort;
        /*$crd = new DateTime();
		$crd->setISODate($y,$w);
		//Stand: 2026-04-16
		//$crd->modify('-12 week');
		//Neu 
		$crd->modify('-13 week');
		return $crd->format('W/o'); */
    }
    private function replace0d($text)
    {
        //$ret = str_replace("\n","\r\n", $text);
        return $text;
    }
    private function writeImage($image, $coord, $name = "Iamge", $desc = "")
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName($name);
        $drawing->setDescription($desc);
        $drawing->setPath($image); /* put your path and image here */
        $drawing->setCoordinates($coord);
        //$drawing->setOffsetX(110);
        //$drawing->setRotation(25);
        //$drawing->getShadow()->setVisible(true);
        //$drawing->getShadow()->setDirection(45);
        $drawing->setHeight(400);
        $drawing->setResizeProportional(true);
        $drawing->setWorksheet($this->worksheet); //Active Sheet
    }
    private function setRowHeightText($row, $text)
    {
        $height = 20 * (substr_count($text, "\n") + 2);
        $this->worksheet->getRowDimension($row)->setRowHeight($height);
    }
    private function getSelection($ausm)
    {
        $y = substr($ausm, 0, 2);
        $m = substr($ausm, 2, 2);
        $y = '20' . $y;
        switch ($m) {
            case '01':
                $month = 'January ';
                break;
            case '04':
                $month = 'April ';
                break;
            case '07':
                $month = 'July ';
                break;
            case '10':
                $month = 'October ';
                break;
            default:
                $month = 'unknown';
                break;
        }
        return $month . $y;
    }
    private function  getDatefromCW($y, $w)
    {
        $date = new DateTime();
        try {
            $date->setISODate($y, $w);
        } catch (Exception $ex) {
        }
        return $date;
    }
    private function getCRDString($crd)
    {
        if ($crd == '') {
            return '';
        }
        try {
            $date = DateTime::createFromFormat('Y-m-d', $crd);
        } catch (Exception $ex) {
            return '';
        }
        return 'CW ' . $date->format('W/o') . ' CRD';
    }
    private function getShipmentreleaseString($crd)
    {
        if ($crd == '') {
            return '';
        }
        try {
            $date = DateTime::createFromFormat('Y-m-d', $crd);
            $date->sub(new DateInterval('P2W'));
        } catch (Exception $ex) {
            return '';
        }
        return 'CW ' . $date->format('W/o') . ' Shipment Release';
    }
    private function getPSIString($crd)
    {
        if ($crd == '') {
            return '';
        }
        try {
            $date = DateTime::createFromFormat('Y-m-d', $crd);
            $date->sub(new DateInterval('P3W'));
        } catch (Exception $ex) {
            return 'XXX';
        }
        return 'CW ' . $date->format('W/o') . ' 100% PSI';
    }
    private function getCRD_Alt($y, $w)
    {
        $crd = $this->getDateFromCW($y, $w);
        $crd->sub(new DateInterval('P9W'));
        //echo($crd->format('Y-m-d'));exit;
        return $crd->format('Y-m-d');
        /* $month = $crd->format('F');
		$year =  $crd->format('Y');*/
    }
    private function getCRD($y, $w)
    {
        if ($y == 0) {
            return '';
        }
        $crd = $this->getDateFromCW($y, $w);
        return $crd->format('Y-m-d');
    }
    private function getRend($y, $w)
    {
        $crd = $this->getDateFromCW($y, $w);
        //$crd = $crd->sub(new DateInterval('P10W'));
        $rend = $crd->sub(new DateInterval('P2W'));
        return $rend->format('Y-m-d');
        /* $month = $crd->format('F');
		$year =  $crd->format('Y');*/
    }
    private function writeNote($note, $cell,  $top = 700, $left = 2050, $w = 200, $h = 100)
    {
        $xlsComment = $this->worksheet->getComment($cell)->getText()->createTextRun($note);
        $this->worksheet->getComment($cell)->setAuthor('Targa GmbH');
        $this->worksheet->getComment($cell)->setHeight("$h px");
        $this->worksheet->getComment($cell)->setWidth("$w px");
        $this->worksheet->getComment($cell)->setVisible(true);
        $this->worksheet->getComment($cell)->setMarginTop("$top px");
        $this->worksheet->getComment($cell)->setMarginLeft("$left px");
        $xlsComment->getFont()->setBold(true);
        $xlsComment->getFont()->setSize(11);
    }
    public function writeRFQ($ppid, $type)
    {
        $newVersion = array(
            'FKE'             => 1,
            'AB_admin'         => 0,
            'CSP_admin'        => 1,
            'CST_admin'        => 0,
            'JA_admin'        => 1,
            'KTST_admin'    => 0,
            'MM_admin'        => 1,
            'SOS_admin'     => 0
        );
        /* if (array_key_exists(Auth::user()->PPMitarbeiter_Kuerzel, $newVersion)){
				$this->_writeRFQ2546($ppid,$type);
		} else {
			$this->_writeRFQ2541($ppid,$type);
		} */
        //$this->_writeRFQ2546($ppid,$type);
        $this->_writeRFQ2603($ppid, $type);
        //}
    }
    private function _writeRFQ($ppid, $type)
    {
        $pp = PPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (! $pp) {
            return;
        }
        $pc = new ProjectsController();
        $trans = $pc->getTranslation($ppid);
        $coord = array();
        $coord['PPProduktpass_Artikelbezeichnung'] =  $this->getCellA(2, 1);
        $coord['PPProduktpass_IAN'] = $this->getCellA(2, 2);
        $coord['weightWithoutPackaging'] =  $this->getCellA(2, 30);
        $coord['sizeWithoutPackaging'] =  $this->getCellA(2, 31);
        $coord['qualityTechnicalData'] =  $this->getCellA(2, 32);
        $coord['additionalQualityInformation'] =  $this->getCellA(2, 34);
        $coord['changesFromPredecessor'] =  $this->getCellA(2, 35);
        $coord['brandReference'] =  $this->getCellA(2, 36);
        $coord['material'] =  $this->getCellA(2, 37);
        $coord['materialThickness'] =  $this->getCellA(2, 38);
        $coord['color'] =  $this->getCellA(2, 39);
        $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  $this->getCellA(2, 64);
        $coord['retailPackagingComment'] =  $this->getCellA(2, 65);
        $coord['Selection'] = $this->getCellA(2, 5);
        $coord['CRD'] = $this->getCellA(2, 6);
        $coord['RenderingPriceOfferDeadline'] = $this->getCellA(2, 7);
        $coord['MOCKupDeadline'] = $this->getCellA(2, 8);
        $coord['EPCtill'] = $this->getCellA(2, 9);
        $coord['Qty'] = $this->getCellA(2, 10);
        $coord['Kolliinhalt'] =  $this->getCellA(4, 63);
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/RFQ_Template.xlsx';
        /******************************************************************* */
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        foreach ($trans as $key => $value) {
            $textEN = $this->replace0d($value['EN']);
            $this->worksheet->setCellValue($coord[$key]['Cell'], $textEN);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $this->setRowHeightText($coord[$key]['Row'], $textEN);
        }
        $selection = $this->getSelection($pp->PPProduktpass_Ausmusterungnummer);
        $this->worksheet->setCellValue($coord['Selection']['Cell'], $selection);
        $crd = $this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->worksheet->setCellValue($coord['CRD']['Cell'], $crd);
        $renderingDeadline = $this->getRend($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->worksheet->setCellValue($coord['RenderingPriceOfferDeadline']['Cell'], $renderingDeadline);
        $this->worksheet->setCellValue($coord['MOCKupDeadline']['Cell'], '???');
        $this->worksheet->setCellValue($coord['EPCtill']['Cell'], $selection);
        $qty = $pp->PPProduktpass_Gesamtmenge;
        $this->worksheet->setCellValue($coord['Qty']['Cell'], $qty);
        $sort = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Sortierung_Id')->get()->first();
        $kolli = 0;
        if ($sort) {
            $kolli = $sort->PPProduktpass_Sortierung_Value02;
        }
        $this->worksheet->setCellValue($coord['Kolliinhalt']['Cell'], $kolli);
        //$comment = "Targa GmbH:\nAll blue fields are mandatory fields and have to be filled out.";
        $note = "TARGA GmbH:\nAll blue fields are mandatory fields and have to be filled out.";
        $this->writeNote($note, "F19", 720, 2030, 200, 100);
        $note = "Please also enter the BSCI No. If no BSCI is available, this must be done as soon as possible, otherwise no offer can be made.";
        $this->writeNote($note, "B17", 730, 1350, 150, 200);
        $note = "If no BEPI or ISO 14001 is available, we need a proof (with date) that it is in progress.";
        $this->writeNote($note, "B18", 940, 1320, 160, 100);
        $note = "TARGA GmbH:\nAll yellow fields must be confirmed.";
        $this->writeNote($note, "F78", 4150, 2030, 160, 100);
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 29), 'Projektbild', 'Projektb ild IAN' . $pp->PPProduktpass_IAN);
        }
        //$this->worksheet->setCellValue( $this->getCell(2,29),'ProjektBild');
        if ($type == 'R') {
            $path = public_path() . '/data/uploads/RFQ/';
        } else {
            $path = public_path() . '/data/tmp';
        }
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = str_random(6) . '-' . $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        if ($type == 'R') {
            $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'RFQ', 'Service', 'Haupt', 'Servicekalkulation', 'Anfrage Kalkulation Service und Fracht ');
        }
        $dl = substr($dl_file, 7);
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        if ($type == "E") {
            if (file_exists($path . $dl_file)) {
                unlink($path . $dl_file);
            }
        }
        return Redirect::to('/show/' . $pp->PPProduktpass_Id . "/RFQ");
    }
    private function _writeRFQ202403($ppid, $type)
    {
        $pp = PPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (! $pp) {
            return;
        }
        $pc = new ProjectsController();
        $trans = $pc->getTranslation($ppid);
        $coord = array();
        $coord['PPProduktpass_Artikelbezeichnung'] =  $this->getCellA(2, 1);
        $coord['PPProduktpass_IAN'] = $this->getCellA(2, 2);
        $coord['weightWithoutPackaging'] =  $this->getCellA(2, 30);
        $coord['sizeWithoutPackaging'] =  $this->getCellA(2, 31);
        $coord['qualityTechnicalData'] =  $this->getCellA(2, 32);
        $coord['additionalQualityInformation'] =  $this->getCellA(2, 34);
        $coord['changesFromPredecessor'] =  $this->getCellA(2, 35);
        $coord['brandReference'] =  $this->getCellA(2, 36);
        $coord['material'] =  $this->getCellA(2, 37);
        $coord['materialThickness'] =  $this->getCellA(2, 38);
        $coord['color'] =  $this->getCellA(2, 39);
        $coord['colorA'] =  $this->getCellA(2, 40);
        $coord['colorB'] =  $this->getCellA(2, 41);
        $coord['colorC'] =  $this->getCellA(2, 42);
        $coord['colorD'] =  $this->getCellA(2, 43);
        $coord['colorE'] =  $this->getCellA(2, 44);
        $coord['colorF'] =  $this->getCellA(2, 45);
        $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  $this->getCellA(2, 64);
        $coord['retailPackagingComment'] =  $this->getCellA(2, 65);
        $coord['Selection'] = $this->getCellA(2, 5);
        $coord['CRD'] = $this->getCellA(2, 6);
        $coord['RenderingPriceOfferDeadline'] = $this->getCellA(2, 7);
        $coord['MOCKupDeadline'] = $this->getCellA(2, 8);
        $coord['EPCtill'] = $this->getCellA(2, 9);
        $coord['Qty'] = $this->getCellA(2, 10);
        $coord['Kolliinhalt'] =  $this->getCellA(4, 63);
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/RFQ_Template_202403.xlsx';
        /******************************************************************* */
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $objPHPExcel->setActiveSheetIndexByName("RFQ");
        $this->worksheet = $objPHPExcel->getActiveSheet();
        foreach ($trans['Main'] as $key => $value) {
            $textEN = $this->replace0d($value['EN']);
            $this->worksheet->setCellValue($coord[$key]['Cell'], $textEN);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $this->setRowHeightText($coord[$key]['Row'], $textEN);
        }
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->get();
        $colorFrist = 40;
        $countZ = 1;
        foreach ($styles as $style) {
            if ($countZ > 1) {
                $this->worksheet->setCellValue($coord['color']['Cell'], '');
            }
            $styleCharNo = 40 + ord(substr($style->PPProduktpass_Style_Header, -1)) - ord('A');
            //$colCoord = $this->getCellA(2,$colorFrist++);
            $colCoord = $this->getCellA(2, $styleCharNo);
            $this->worksheet->setCellValue($colCoord['Cell'], $trans['Styles'][$style->PPProduktpass_Style_Header]['color']['EN']);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $colCoord = $this->getCellA(1, $styleCharNo);
            $this->worksheet->setCellValue($colCoord['Cell'], "(Color)-Style " . $style->PPProduktpass_Style_Header);
            $countZ++;
        }
        $selection = $this->getSelection($pp->PPProduktpass_Ausmusterungnummer);
        $this->worksheet->setCellValue($coord['Selection']['Cell'], $selection);
        $crd = $this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->worksheet->setCellValue($coord['CRD']['Cell'], $crd);
        $renderingDeadline = $this->getRend($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->worksheet->setCellValue($coord['RenderingPriceOfferDeadline']['Cell'], $renderingDeadline);
        $this->worksheet->setCellValue($coord['MOCKupDeadline']['Cell'], '???');
        $this->worksheet->setCellValue($coord['EPCtill']['Cell'], $selection);
        $qty = $pp->PPProduktpass_Gesamtmenge;
        $this->worksheet->setCellValue($coord['Qty']['Cell'], $qty);
        $sort = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Sortierung_Id')->get()->first();
        $kolli = 0;
        if ($sort) {
            $kolli = $sort->PPProduktpass_Sortierung_Value02;
        }
        $this->worksheet->setCellValue($coord['Kolliinhalt']['Cell'], $kolli);
        //$comment = "Targa GmbH:\nAll blue fields are mandatory fields and have to be filled out.";
        $note = "TARGA GmbH:\nAll blue fields are mandatory fields and have to be filled out.";
        $this->writeNote($note, "F19", 720, 2030, 200, 100);
        $note = "Please also enter the BSCI No. If no BSCI is available, this must be done as soon as possible, otherwise no offer can be made.";
        $this->writeNote($note, "B17", 730, 1350, 150, 200);
        $note = "If no BEPI or ISO 14001 is available, we need a proof (with date) that it is in progress.";
        $this->writeNote($note, "B18", 940, 1320, 160, 100);
        $note = "TARGA GmbH:\nAll yellow fields must be confirmed.";
        $this->writeNote($note, "F78", 4150, 2030, 160, 100);
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 29), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
        //$this->worksheet->setCellValue( $this->getCell(2,29),'ProjektBild');
        if ($type == 'R') {
            $path = public_path() . '/data/uploads/RFQ/';
        } else {
            $path = public_path() . '/data/tmp';
        }
        //$dl_file = str_random(6).'_RFQ_IAN_'.$pp->PPProduktpass_IAN.'.xlsx'; 
        /* Änderunegn Tenplatwe RFQ_202403.xlsx */
        $stylesArray = array('B', 'C', 'D', 'E', 'F');
        foreach ($stylesArray as $styleChar) {
            $this->writeStyle($pp->PPProduktpass_Id, $styleChar, $objPHPExcel, $trans);
        }
        $objPHPExcel->setActiveSheetIndexByName("RFQ");
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $this->worksheet->setSelectedCells('A1');
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['Main']['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = str_random(6) . '-' . $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        if ($type == 'R') {
            $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'RFQ', 'EKPM', 'Produktdetails', 'Quote', 'RFQ');
        }
        $dl = substr($dl_file, 7);
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        if ($type == "E") {
            if (file_exists($path . $dl_file)) {
                unlink($path . $dl_file);
            }
        }
        $redirectLink = '/show/' . $ppid . "/RFQ";
        return Redirect::to($redirectLink);
        //return Redirect::to('/show/' . $pp->PPProduktpass_Id . "/RFQ");
    }
    private function normalizeTextForExcel($text)
    {
        $text = html_entity_decode($text ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // Absatz-Tags zu doppeltem Umbruch
        $text = preg_replace('/<\/p\s*>/i', "\n\n", $text);
        $text = preg_replace('/<p[^>]*>/i', '', $text);
        // br-Tags zu einfachem Umbruch
        $text = preg_replace('/<br\s*\/?>/i', "\n", $text);
        // Restliche HTML-Tags entfernen
        $text = strip_tags($text);
        // Zeilenumbrüche vereinheitlichen
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        // Mehr als 2 Leerzeilen reduzieren
        $text = preg_replace("/\n{3,}/", "\n\n", $text);
        return trim($text);
    }
    private function setCellValueAndHight($coord, $text)
    {
        //$n1 =   str_replace(["\n"], "[0A]", $text);
        cpcDebug::cpc_debug('    setCellValueAndHeight:' . json_encode([$coord]) . ' ### ' . substr($text, 0, 10), '-RFQ603_A');
        $normalized = html_entity_decode($text ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $normalized = str_replace(["\r\n", "\r"], "\n", $normalized);
        $lineCountText = explode("\n", $normalized);
        $lines = count($lineCountText);
        $addLines = 0;
        foreach ($lineCountText as $value) {
            if (mb_strlen($value, 'UTF-8') > 100) {
                $addLines++;
            }
        }
        $row = preg_replace('/[^0-9]/', '', $coord);
        $lines1 = $lines + $addLines;
        cpcDebug::cpc_debug('        Koordinaten: ' . json_encode($coord), '-RFQ603_A');
        $this->worksheet->setCellValueExplicit(
            $coord,
            $normalized,
            \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
        );
        cpcDebug::cpc_debug('        normalized: ' . substr($normalized, 0, 10), '-RFQ603_A');
        $this->worksheet->getStyle($coord)
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $this->worksheet->getRowDimension($row)->setRowHeight(max(24, $lines1 * 24));
    }
    private function _writeRFQ2533($ppid, $type)
    {
        $mainSheet = 'RFQ_Style A';
        $pp = PPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (! $pp) {
            return;
        }
        $pc = new ProjectsController();
        $trans = $pc->getTranslation($ppid);
        $coord = array();
        $coord['PPProduktpass_Artikelbezeichnung'] =  $this->getCellA(2, 1);
        $coord['PPProduktpass_IAN'] = $this->getCellA(2, 2);
        $coord['weightWithoutPackaging'] =  $this->getCellA(2, 31);
        $coord['sizeWithoutPackaging'] =  $this->getCellA(2, 32);
        $coord['qualityTechnicalData'] =  $this->getCellA(2, 33);
        $coord['additionalQualityInformation'] =  $this->getCellA(2, 35);
        $coord['changesFromPredecessor'] =  $this->getCellA(2, 36);
        $coord['brandReference'] =  $this->getCellA(2, 37);
        $coord['material'] =  $this->getCellA(2, 38);
        $coord['materialThickness'] =  $this->getCellA(2, 39);
        $coord['color'] =  $this->getCellA(2, 40);
        $coord['colorA'] =  $this->getCellA(2, 41);
        $coord['colorB'] =  $this->getCellA(2, 42);
        $coord['colorC'] =  $this->getCellA(2, 43);
        $coord['colorD'] =  $this->getCellA(2, 44);
        $coord['colorE'] =  $this->getCellA(2, 45);
        $coord['colorF'] =  $this->getCellA(2, 46);
        $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  $this->getCellA(6, 77);
        $coord['retailPackagingComment'] =  $this->getCellA(2, 77);
        $coord['Selection'] = $this->getCellA(2, 5);
        $coord['CRD'] = $this->getCellA(2, 6);
        $coord['RenderingPriceOfferDeadline'] = $this->getCellA(2, 7);
        $coord['MOCKupDeadline'] = $this->getCellA(2, 8);
        $coord['EPCtill'] = $this->getCellA(2, 9);
        $coord['Qty'] = $this->getCellA(2, 10);
        $coord['Kolliinhalt'] =  $this->getCellA(4, 63);
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/RFQ_Template_2533.xlsx';
        /******************************************************************* */
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        foreach ($trans['Main'] as $key => $value) {
            $textEN = $this->replace0d($value['EN']);
            $this->setCellValueAndHight($coord[$key]['Cell'], $textEN);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            //$this->setRowHeightText($coord[$key]['Row'], $textEN) ;
        }
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Style_Header')->get();
        $colorFrist = 40;
        $countZ = 1;
        foreach ($styles as $style) {
            if ($countZ > 1) {
                $this->setCellValueAndHight($coord['color']['Cell'], '');
            }
            $styleCharNo = 41 + ord(substr($style->PPProduktpass_Style_Header, -1)) - ord('A');
            //$colCoord = $this->getCellA(2,$colorFrist++);
            $colCoord = $this->getCellA(1, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], "(Color)-Style " . $style->PPProduktpass_Style_Header);
            $colCoord = $this->getCellA(2, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], $trans['Styles'][$style->PPProduktpass_Style_Header]['color']['EN']);
            //$this->setCellValueAndHight($colCoord['Cell'],$style->PPProduktpass_Style_Header);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $countZ++;
        }
        $selection = $this->getSelection($pp->PPProduktpass_Ausmusterungnummer);
        $this->setCellValueAndHight($coord['Selection']['Cell'], $selection);
        $crd = $this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->setCellValueAndHight($coord['CRD']['Cell'], $crd);
        $renderingDeadline = $this->getRend($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->setCellValueAndHight($coord['RenderingPriceOfferDeadline']['Cell'], $renderingDeadline);
        $this->setCellValueAndHight($coord['MOCKupDeadline']['Cell'], '???');
        $this->setCellValueAndHight($coord['EPCtill']['Cell'], $selection);
        $qty = $pp->PPProduktpass_Gesamtmenge;
        $this->setCellValueAndHight($coord['Qty']['Cell'], $qty);
        $sort = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Sortierung_Id')->get()->first();
        $kolli = 0;
        if ($sort) {
            $kolli = $sort->PPProduktpass_Sortierung_Value02;
        }
        $this->setCellValueAndHight($coord['Kolliinhalt']['Cell'], $kolli);
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 30), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
        if ($type == 'R') {
            $path = public_path() . '/data/uploads/RFQ/';
        } else {
            $path = public_path() . '/data/tmp';
        }
        $stylesArray = array('B', 'C', 'D', 'E', 'F');
        foreach ($stylesArray as $styleChar) {
            $this->writeStyle2533($pp->PPProduktpass_Id, $styleChar, $objPHPExcel, $trans);
        }
        //schreibe Mengen#
        $objPHPExcel->setActiveSheetIndexByName('Quantity overview');
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $laenderMengen = $this->getLaenderMengenX($pp->PPProduktpass_Id);
        //cpcDebug::cpc_debug($laenderMengen['US']['Quantity'], '@RFQ2533');
        //cpcDebug::cpc_debug($laenderMengen['US']['Kolli'], '@RFQ2533');
        for ($i = 4; $i <= 56; $i++) {
            //$cell = 'B'.$i;
            $country = $this->worksheet->getCell("B$i")->getValue();
            //cpcDebug::cpc_debug($country, '@RFQ2533');
            //cpcDebug::cpc_debug('OK:'. $laenderMengen[$country]['Quantity'], '@RFQ2533');
            try {
                $m = $laenderMengen[$country]['Quantity'];
                $k = $laenderMengen[$country]['Kolli'];
                //cpcDebug::cpc_debug('OK' . $m , '@RFQ2533');
                if (isset($laenderMengen[$country])) {
                    $this->worksheet->setCellValue("D$i", $k);
                    $this->worksheet->setCellValue("E$i", $m);
                }
            } catch (Exception $ex) {
                cpcDebug::cpc_debug('Exc:' . $country, '@RFQ2533');
            }
        }
        $coord['stationary']['LT'][1] =  $this->getCellA(4, 69);
        $coord['stationary']['LT'][2] =  $this->getCellA(4, 78);
        $coord['stationary']['LT'][3] =  $this->getCellA(4, 87);
        $coord['OS']['LT'][1] =  $this->getCellA(4, 70);
        $coord['OS']['LT'][2] =  $this->getCellA(4, 79);
        $coord['OS']['LT'][3] =  $this->getCellA(4, 88);
        $coord['UKPlug']['LT'][1] =  $this->getCellA(4, 71);
        $coord['UKPlug']['LT'][2] =  $this->getCellA(4, 80);
        $coord['UKPlug']['LT'][3] =  $this->getCellA(4, 89);
        $coord['CHPlug']['LT'][1] =  $this->getCellA(4, 72);
        $coord['CHPlug']['LT'][2] =  $this->getCellA(4, 81);
        $coord['CHPlug']['LT'][3] =  $this->getCellA(4, 90);
        $coord['es']['LT'][1] =  $this->getCellA(4, 73);
        $coord['es']['LT'][2] =  $this->getCellA(4, 82);
        $coord['es']['LT'][3] =  $this->getCellA(4, 91);
        $coord['stationary']['Menge'][1] =  $this->getCellA(4, 69);
        $coord['stationary']['Menge'][2] =  $this->getCellA(4, 78);
        $coord['stationary']['Menge'][3] =  $this->getCellA(4, 87);
        $coord['OS']['Menge'][1] =  $this->getCellA(5, 70);
        $coord['OS']['Menge'][2] =  $this->getCellA(5, 79);
        $coord['OS']['Menge'][3] =  $this->getCellA(5, 88);
        $coord['UKPlug']['Menge'][1] =  $this->getCellA(5, 71);
        $coord['UKPlug']['Menge'][2] =  $this->getCellA(5, 80);
        $coord['UKPlug']['Menge'][3] =  $this->getCellA(5, 89);
        $coord['CHPlug']['Menge'][1] =  $this->getCellA(5, 72);
        $coord['CHPlug']['Menge'][2] =  $this->getCellA(5, 81);
        $coord['CHPlug']['Menge'][3] =  $this->getCellA(5, 90);
        $coord['es']['Menge'][1] =  $this->getCellA(5, 73);
        $coord['es']['Menge'][2] =  $this->getCellA(5, 82);
        $coord['es']['Menge'][3] =  $this->getCellA(5, 91);
        $mengeNachArt = $this->getMengenUebersichtNachLT($$pp->PPProduktpass_Id);
        $D69 = 'stationary';
        //$this->AndHightsetCellValue($coord['RenderingPriceOfferDeadline']['Cell'],$renderingDeadline);
        //Ende Schreibe Mengen
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $this->worksheet->setSelectedCells('A1');
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['Main']['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = str_random(6) . '-' . $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        if ($type == 'R') {
            $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'RFQ', 'EKPM', 'Produktdetails', 'Quote', 'RFQ');
        }
        $dl = substr($dl_file, 7);
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        if ($type == "E") {
            if (file_exists($path . $dl_file)) {
                unlink($path . $dl_file);
            }
        }
        $redirectLink = '/show/' . $ppid . "/RFQ";
        return Redirect::to($redirectLink);
    }
    private function _writeRFQ2541($ppid, $type)
    {
        $mainSheet = 'RFQ_Style A';
        $pp = PPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (! $pp) {
            return;
        }
        $pc = new ProjectsController();
        $trans = $pc->getTranslation($ppid);
        $coord = array();
        $coord['PPProduktpass_Artikelbezeichnung'] =  $this->getCellA(2, 1);
        $coord['PPProduktpass_IAN'] = $this->getCellA(2, 2);
        $coord['weightWithoutPackaging'] =  $this->getCellA(2, 31);
        $coord['sizeWithoutPackaging'] =  $this->getCellA(2, 32);
        $coord['qualityTechnicalData'] =  $this->getCellA(2, 33);
        $coord['additionalQualityInformation'] =  $this->getCellA(2, 35);
        $coord['changesFromPredecessor'] =  $this->getCellA(2, 36);
        $coord['brandReference'] =  $this->getCellA(2, 37);
        $coord['material'] =  $this->getCellA(2, 38);
        $coord['materialThickness'] =  $this->getCellA(2, 39);
        $coord['color'] =  $this->getCellA(2, 40);
        $coord['colorA'] =  $this->getCellA(2, 41);
        $coord['colorB'] =  $this->getCellA(2, 42);
        $coord['colorC'] =  $this->getCellA(2, 43);
        $coord['colorD'] =  $this->getCellA(2, 44);
        $coord['colorE'] =  $this->getCellA(2, 45);
        $coord['colorF'] =  $this->getCellA(2, 46);
        $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  $this->getCellA(6, 77);
        $coord['retailPackagingComment'] =  $this->getCellA(2, 77);
        $coord['Selection'] = $this->getCellA(2, 5);
        $coord['CRD'] = $this->getCellA(2, 6);
        $coord['RenderingPriceOfferDeadline'] = $this->getCellA(2, 7);
        $coord['MOCKupDeadline'] = $this->getCellA(2, 8);
        $coord['EPCtill'] = $this->getCellA(2, 9);
        $coord['Qty'] = $this->getCellA(2, 10);
        $coord['Kolliinhalt'] =  $this->getCellA(4, 63);
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/RFQ_Template_2541.xlsx';
        /******************************************************************* */
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        foreach ($trans['Main'] as $key => $value) {
            $textEN = $this->replace0d($value['EN']);
            $this->setCellValueAndHight($coord[$key]['Cell'], $textEN);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            //$this->setRowHeightText($coord[$key]['Row'], $textEN) ;
        }
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Style_Header')->get();
        $colorFrist = 40;
        $countZ = 1;
        foreach ($styles as $style) {
            if ($countZ > 1) {
                $this->setCellValueAndHight($coord['color']['Cell'], '');
            }
            $styleCharNo = 41 + ord(substr($style->PPProduktpass_Style_Header, -1)) - ord('A');
            //$colCoord = $this->getCellA(2,$colorFrist++);
            $colCoord = $this->getCellA(1, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], "(Color)-Style " . $style->PPProduktpass_Style_Header);
            $colCoord = $this->getCellA(2, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], $trans['Styles'][$style->PPProduktpass_Style_Header]['color']['EN']);
            //$this->setCellValueAndHight($colCoord['Cell'],$style->PPProduktpass_Style_Header);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $countZ++;
        }
        $selection = $this->getSelection($pp->PPProduktpass_Ausmusterungnummer);
        $this->setCellValueAndHight($coord['Selection']['Cell'], $selection);
        $crd = $this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->setCellValueAndHight($coord['CRD']['Cell'], $crd);
        $renderingDeadline = $this->getRend($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
        $this->setCellValueAndHight($coord['RenderingPriceOfferDeadline']['Cell'], $renderingDeadline);
        $this->setCellValueAndHight($coord['MOCKupDeadline']['Cell'], '???');
        $this->setCellValueAndHight($coord['EPCtill']['Cell'], $selection);
        $qty = $pp->PPProduktpass_Gesamtmenge;
        $this->setCellValueAndHight($coord['Qty']['Cell'], $qty);
        $sort = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Sortierung_Id')->get()->first();
        $kolli = 0;
        if ($sort) {
            $kolli = $sort->PPProduktpass_Sortierung_Value02;
        }
        $this->setCellValueAndHight($coord['Kolliinhalt']['Cell'], $kolli);
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 30), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
        if ($type == 'R') {
            $path = public_path() . '/data/uploads/RFQ/';
        } else {
            $path = public_path() . '/data/tmp';
        }
        $stylesArray = array('B', 'C', 'D', 'E', 'F');
        foreach ($stylesArray as $styleChar) {
            $this->writeStyle2533($pp->PPProduktpass_Id, $styleChar, $objPHPExcel, $trans);
        }
        //schreibe Mengen#
        $objPHPExcel->setActiveSheetIndexByName('Quantity overview');
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $laenderMengen = $this->getLaenderMengenX($pp->PPProduktpass_Id);
        //cpcDebug::cpc_debug($laenderMengen['US']['Quantity'], '@RFQ2533');
        //cpcDebug::cpc_debug($laenderMengen['US']['Kolli'], '@RFQ2533');
        for ($i = 5; $i <= 58; $i++) {
            //$cell = 'B'.$i;
            $country = $this->worksheet->getCell("A$i")->getValue();
            //cpcDebug::cpc_debug($country, '@RFQ2533');
            //cpcDebug::cpc_debug('OK:'. $laenderMengen[$country]['Quantity'], '@RFQ2533');
            try {
                $m = $laenderMengen[$country]['Quantity'];
                $k = $laenderMengen[$country]['Kolli'];
                //cpcDebug::cpc_debug('OK' . $m , '@RFQ2533');
                if (isset($laenderMengen[$country])) {
                    //$this->worksheet->setCellValue("D$i",$k);
                    //$this->worksheet->setCellValue("E$i",$m);
                    $this->worksheet->setCellValue("B$i", $laenderMengen[$country]['Kolli']);
                    $this->worksheet->setCellValue("C$i", $laenderMengen[$country]['Quantity']);
                    $this->worksheet->setCellValue("D$i", $laenderMengen[$country]['LT1']);
                    $this->worksheet->setCellValue("E$i", $laenderMengen[$country]['LT1Kolli']);
                    $this->worksheet->setCellValue("F$i", $laenderMengen[$country]['LT2']);
                    $this->worksheet->setCellValue("G$i", $laenderMengen[$country]['LT2Kolli']);
                    $this->worksheet->setCellValue("H$i", $laenderMengen[$country]['LT3']);
                    $this->worksheet->setCellValue("I$i", $laenderMengen[$country]['LT3Kolli']);
                }
            } catch (Exception $ex) {
                cpcDebug::cpc_debug('Exc:' . $country, '@RFQ2533');
            }
        }
        $this->worksheet->setCellValue("B2", $pp->PPProduktpass_Gesamtmenge);
        //$this->AndHightsetCellValue($coord['RenderingPriceOfferDeadline']['Cell'],$renderingDeadline);
        //Ende Schreibe Mengen
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $this->worksheet->setSelectedCells('A1');
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['Main']['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = /* str_random(6).'-'. */ $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        if ($type == 'R') {
            $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'RFQ', 'EKPM', 'Produktdetails', 'Quote', 'RFQ');
        }
        //$dl = substr($dl_file,7);
        $dl = $dl_file;
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        if ($type == "E") {
            if (file_exists($path . $dl_file)) {
                unlink($path . $dl_file);
            }
        }
        $redirectLink = '/show/' . $ppid . "/RFQ";
        return Redirect::to($redirectLink);
    }
    private function _writeRFQ2603($ppid, $type)
    {
        cpcDebug::cpc_debug('Start _writeRFQ2603: ' . $ppid, '-RFQ603_A');
        $mainSheet = 'RFQ_Style A';
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (! $pp) {
            return;
        }
        $pc = new ProjectsController();
        $trans = $pc->getTranslation($ppid);
        $coord = array();
        $anchor = 38;
        $coord['PPProduktpass_Artikelbezeichnung'] =  $this->getCellA(2, 1);
        $coord['PPProduktpass_IAN'] = $this->getCellA(2, 2);
        $coord['weightWithoutPackaging'] =  $this->getCellA(2, $anchor); // 34 wird 38 $anchor  (+4)
        $coord['sizeWithoutPackaging'] =  $this->getCellA(2, $anchor + 1);
        $coord['qualityTechnicalData'] =  $this->getCellA(2, $anchor + 2);
        $coord['additionalQualityInformation'] =  $this->getCellA(2, $anchor + 7);
        $coord['changesFromPredecessor'] =  $this->getCellA(2, $anchor + 9);
        $coord['brandReference'] =  $this->getCellA(2, $anchor + 10);
        $coord['material'] =  $this->getCellA(2, $anchor + 11);
        $coord['materialThickness'] =  $this->getCellA(2, $anchor + 12);
        $coord['color'] =  $this->getCellA(2, $anchor + 13); //Zeile 51
        $coord['colorA'] =  $this->getCellA(2, $anchor + 14);
        $coord['colorB'] =  $this->getCellA(2, $anchor + 15);
        $coord['colorC'] =  $this->getCellA(2, $anchor + 16);
        $coord['colorD'] =  $this->getCellA(2, $anchor + 17);
        $coord['colorE'] =  $this->getCellA(2, $anchor + 18);
        $coord['colorF'] =  $this->getCellA(2, $anchor + 19);
        $coord['colorG'] =  $this->getCellA(2, $anchor + 20);
        $coord['colorH'] =  $this->getCellA(2, $anchor + 21);
        $coord['colorI'] =  $this->getCellA(2, $anchor + 22);
        $coord['colorJ'] =  $this->getCellA(2, $anchor + 23);
        $coord['colorK'] =  $this->getCellA(2, $anchor + 24);
        $coord['colorL'] =  $this->getCellA(2, $anchor + 25);
        $coord['colorM'] =  $this->getCellA(2, $anchor + 26);
        $coord['colorN'] =  $this->getCellA(2, $anchor + 27);
        $coord['colorO'] =  $this->getCellA(2, $anchor + 28);
        $coord['colorX'] =  $this->getCellA(2, $anchor + 14);
        $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  $this->getCellA(2, $anchor + 65);
        $coord['retailPackagingComment'] =  $this->getCellA(2, $anchor + 66);
        $coord['Selection'] = $this->getCellA(2, 3);
        $coord['ChildIAN'] = $this->getCellA(2, 4);
        $coord['KAT'] = $this->getCellA(2, 5);
        $coord['Qty'] = $this->getCellA(2, 6);
        $coord['CRD'] = $this->getCellA(2, 7);
        $coord['Shipmentrelease'] = $this->getCellA(2, 8);
        $coord['PSI'] = $this->getCellA(2, 9);
        $coord['RenderingPriceOfferDeadline'] = $this->getCellA(2, 7);
        $coord['MOCKupDeadline'] = $this->getCellA(2, 8);
        $coord['EPCtill'] = $this->getCellA(2, 9);
        $coord['Kolliinhalt'] =  $this->getCellA(4, 63);
        $coord['ProjectPicture'] =  $this->getCellA(2, $anchor - 1);
        $coord['versandfertigeUmverpackung']  =  $this->getCellA(5, $anchor + 42);
        $coord['Verkaufsverpackung']  =  $this->getCellA(2, $anchor + 101);
        /* ********************************************
			- Zelle C102: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Verkaufsverpackung Kaufland“ - Beispiel „Banderole“.
			- Zelle C103: Checkbox: Haken setzten, wenn im PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland“ „Ja“ hinterlegt ist.
			- Zelle E103: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Art“ - Beispiel „U-Tray“
			- Zelle C104: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Farbiges Tray“ - Beispiel „Bedruckt (4C)“
			- Zelle E104: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland Höhe (cm)“
			- Zelle C105: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland Breite (cm)“
			- Zelle E105: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland Länge (cm)“
			- Zelle C106: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Bemerkung Verpackung Kaufland“
			- Zelle C107: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Bemerkung Tray“
		***********************************************/
        $coord['VerkaufsverpackungKL']  =  $this->getCellA(3, $anchor + 68);
        $coord['TrayKL']                  =  $this->getCellA(3, $anchor + 69);
        $coord['TrayArtKL']              =  $this->getCellA(5, $anchor + 69);
        $coord['FarbigesTrayKL']          =  $this->getCellA(3, $anchor + 70);
        $coord['TrayHoeheKL']              =  $this->getCellA(5, $anchor + 70);
        $coord['TrayBreiteKL']          =  $this->getCellA(3, $anchor + 71);
        $coord['TrayLaengeKL']          =  $this->getCellA(5, $anchor + 72);
        $coord['VerpackungBemerkungKL'] =  $this->getCellA(3, $anchor + 73);
        $coord['TrayBemerkungKL']          =  $this->getCellA(3, $anchor + 74);
        /* ******************************************************
			- Zelle B141: Übertrag aus PP Bereich „Kennzeichnung“, genauer „Zertifikate“
		*  ********************************************************/
        $coord['Zertifikate']              =  $this->getCellA(2, $anchor + 107);
        /* ********************************************************
		Risikokategorie:
		- Zelle D182: Übertrag aus PP Bereich „Risikiokategorie“, genauer „Geeignet für Kinder“
		- Zelle D183: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „LFGB“ ein Haken gesetzt ist
		- Zelle D184: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „NGO Prüfung“ ein Haken gesetzt ist
		- Zelle D185: Übertrag aus PP Bereich „Risikiokategorie“, genauer „NGO Prüfung Bem.“
		- Zelle D186: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „PSA“ ein Haken gesetzt ist
		- Zelle D187: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „Medizinprodukt“ ein Haken gesetzt ist
		- Zelle D188: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „Referenztest“ ein Haken gesetzt ist
		* *************************************************/
        $coord['GeeignetfürKinder']         =  $this->getCellA(4, $anchor + 148);
        $coord['LFGB']                      =  $this->getCellA(4, $anchor + 149);
        $coord['NGOPruefung']                  =  $this->getCellA(4, $anchor + 150);
        $coord['NGOPruefungBemerkung']      =  $this->getCellA(4, $anchor + 151);
        $coord['PSA']                          =  $this->getCellA(4, $anchor + 152);
        $coord['Medizinprodukt']              =  $this->getCellA(4, $anchor + 153);
        $coord['Referenztest']              =  $this->getCellA(4, 188);
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/RFQ_Template_2603.xlsx';
        /******************************************************************* */
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        foreach ($trans['Main'] as $key => $value) {
            //cpcDebug::cpc_debug($key, '-RFQ2603');
            //cpcDebug::cpc_debug($value, '-RFQ2603');
            $textEN = $value['EN']; //$this->replace0d($value['EN']);
            //$textEN = $value['EN'];
            //cpcDebug::cpc_debug('AAAA'.$textEN, '-TEXT');
            //cpcDebug::cpc_debug(substr_count($textEN, "\n"), '-TEXT');
            //cpcDebug::cpc_debug(substr_count($textEN, "\r"), '-TEXT');
            // cpcDebug::cpc_debug('BBBB'.json_encode($textEN), '-TEXT');
            cpcDebug::cpc_debug('Schleife: ' . $key, '-RFQ603_A');
            cpcDebug::cpc_debug('Value: ' . substr($value['EN'], 0, 20), '-RFQ603_A');
            $this->setCellValueAndHight($coord[$key]['Cell'], $textEN);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            //$this->setRowHeightText($coord[$key]['Row'], $textEN) ;
        }
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Style_Header')->get();
        $colorFirst = $anchor + 14;
        $countZ = 1;
        foreach ($styles as $style) {
            if ($countZ > 1) {
                $this->setCellValueAndHight($coord['color']['Cell'], '');
            }
            $styleCharNo = $colorFirst + ord(substr($style->PPProduktpass_Style_Header, -1)) - ord('A');
            if (strpos($style->PPProduktpass_Style_Header, 'X') !== false) {
                $styleCharNo = $colorFirst;
            }
            //$colCoord = $this->getCellA(2,$colorFrist++);
            $colCoord = $this->getCellA(1, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], "(Color)-Style " . $style->PPProduktpass_Style_Header);
            $colCoord = $this->getCellA(2, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], $trans['Styles'][$style->PPProduktpass_Style_Header]['color']['EN']);
            //$this->setCellValueAndHight($colCoord['Cell'],$style->PPProduktpass_Style_Header);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $countZ++;
        }
        //$path = public_path('/data/tmp');
        //$this->createFileDownload($pp, $trans, $objPHPExcel, $path, $type);
        //exit;
        $selection =  substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $this->setCellValueAndHight($coord['Selection']['Cell'], $selection . '!');
        $crd = $this->getCRDString($this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche));
        $this->setCellValueAndHight($coord['CRD']['Cell'], $crd);
        $shipmentrelease =  $this->getShipmentreleaseString($this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche));
        $this->setCellValueAndHight($coord['Shipmentrelease']['Cell'], $shipmentrelease);
        $PSI =  $this->getPSIString($this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche));
        $this->setCellValueAndHight($coord['PSI']['Cell'], $PSI);
        //$renderingDeadline = $this->getRend($pp->PPProduktpass_LieferterminJahr, $pp->PPProduktpass_Liefertermin);
        //$this->setCellValueAndHight($coord['RenderingPriceOfferDeadline']['Cell'],$renderingDeadline);
        //$this->setCellValueAndHight($coord['MOCKupDeadline']['Cell'],'???');
        //$this->setCellValueAndHight($coord['EPCtill']['Cell'],$selection);
        $qty = $pp->PPProduktpass_Gesamtmenge;
        $this->setCellValueAndHight($coord['Qty']['Cell'], $qty);
        // packagingKL_materialThickness, packagingKL_retailPackagingComment, packagingKL_trayRemarks, packagingKL_rt_name, packagingKL_tray_name,
        // packagingKL_trayType, packagingKL_trayFacingLayer, packagingKL_trayColor, packagingKL_trayMaxCartonLength, packagingKL_trayMaxCartonWidth, packagingKL_trayMaxCartonHeight
        $this->setCellValueAndHight($coord['Verkaufsverpackung']['Cell'],   ServiceProvider::tl('EN', $pp->PPProduktpass_Verkaufsverpackung));
        $this->setCellValueAndHight($coord['VerkaufsverpackungKL']['Cell'], ServiceProvider::tl('EN', $pp->packagingKL_rt_name));
        $this->setCellValueAndHight($coord['TrayKL']['Cell'],               ServiceProvider::tl('EN', $pp->packagingKL_tray_name));
        $this->setCellValueAndHight($coord['TrayArtKL']['Cell'],            ServiceProvider::tl('EN', $pp->packagingKL_trayType));
        $this->setCellValueAndHight($coord['FarbigesTrayKL']['Cell'],        ServiceProvider::tl('EN', $pp->packagingKL_trayColor));
        $this->setCellValueAndHight($coord['TrayHoeheKL']['Cell'],            $pp->packagingKL_trayMaxCartonHeight);
        $this->setCellValueAndHight($coord['TrayBreiteKL']['Cell'],            $pp->packagingKL_trayMaxCartonWidth);
        $this->setCellValueAndHight($coord['TrayLaengeKL']['Cell'],            $pp->packagingKL_trayMaxCartonLength);
        //$this->setCellValueAndHight($coord['VerpackungBemerkungKL']['Cell'],ServiceProvider::tl('EN',$pp->packagingKL_retailPackagingComment));
         $this->setCellValueAndHight($coord['VerpackungBemerkungKL']['Cell'], ServiceProvider::tl('EN', $pp->packagingKL_retailPackagingComment));
        //$this->setCellValueAndHight($coord['TrayBemerkungKL']['Cell'], 		ServiceProvider::tl('EN',$pp->packagingKL_trayRemarks) );
         $this->setCellValueAndHight($coord['TrayBemerkungKL']['Cell'],         ServiceProvider::tl('EN', $pp->packagingKL_trayRemarks));
        //cpcDebug::cpc_debug('TrayBemerkungKL:'.ServiceProvider::tl('EN',$pp->packagingKL_trayRemarks), 'RFQ2603');
        $this->setCellValueAndHight($coord['versandfertigeUmverpackung']['Cell'], $this->trueFalseToJaNein($pp->PPProduktpass_VersandfaehigeUmverpackung));
        //cpcDebug::cpc_debug('versandfertigeUmverpackung:'.$pp->PPProduktpass_VersandfaehigeUmverpackung, 'RFQ2603');
        $zert =      $pp->PPProduktpass_Zertifizierungen . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften2 . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften3 . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften4 . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften5;
        $this->setCellValueAndHight($coord['Zertifikate']['Cell'],         $zert);
        $this->setCellValueAndHight($coord['GeeignetfürKinder']['Cell'], $this->trueFalseToJaNein($pp->childSuitable));
        $this->setCellValueAndHight($coord['LFGB']['Cell'], $this->trueFalseToJaNein($pp->LFGB));
        $this->setCellValueAndHight($coord['NGOPruefung']['Cell'], $this->trueFalseToJaNein($pp->ngoTest));
        $this->setCellValueAndHight($coord['NGOPruefungBemerkung']['Cell'], ServiceProvider::tl('EN', $pp->ngoTestNote));
        $this->setCellValueAndHight($coord['PSA']['Cell'], $this->trueFalseToJaNein($pp->ppe));
        $this->setCellValueAndHight($coord['Medizinprodukt']['Cell'], $this->trueFalseToJaNein($pp->medProduct));
        $this->setCellValueAndHight($coord['Referenztest']['Cell'], $this->trueFalseToJaNein($pp->referenceCheck));
        $this->setCellValueAndHight($coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung']['Cell'], ServiceProvider::tl('EN', $pp->PPProduktpass_Materialstaerke_der_Verkaufsverpackung));
        $this->setCellValueAndHight($coord['retailPackagingComment']['Cell'], ServiceProvider::tl('EN', $pp->retailPackagingComment));
        $this->writeFirstStyle($coord, $pp->PPProduktpass_Id, $trans['Styles']);
        $child = 'n.A.';
        if ($pp->isChild) {
            $child = 'Ja';
        }
        $this->setCellValueAndHight($coord['ChildIAN']['Cell'], $child);
        $kat = '';
        if (strpos($pp->PPProduktpass_Artikelbezeichnung, 'KAT') !== false) {
            $kat = 'Ja';
        }
        $this->setCellValueAndHight($coord['KAT']['Cell'], $kat);
        $sort = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Sortierung_Id')->get()->first();
        $kolli = 0;
        if ($sort) {
            $kolli = $sort->PPProduktpass_Sortierung_Value02;
        }
        $this->setCellValueAndHight($coord['Kolliinhalt']['Cell'], $kolli);
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $coord['ProjectPicture']['Cell'], 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
        if ($type == 'R') {
            $path = public_path('/data/uploads/RFQ/');
        } else {
            $path = public_path('/data/tmp');
        }
        $stylesArray = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T','U', 'X');
        foreach ($stylesArray as $styleChar) {
            $this->writeStyle2603($pp->PPProduktpass_Id, $styleChar, $objPHPExcel, $trans);
        }
        //schreibe Mengen#
        $objPHPExcel->setActiveSheetIndexByName('Quantity overview');
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $laenderMengen = $this->getLaenderMengenX($pp->PPProduktpass_Id);
        //cpcDebug::cpc_debug($laenderMengen['US']['Quantity'], '@RFQ2533');
        //cpcDebug::cpc_debug('Ländermengen eintragen', '-RFQ2603');
        for ($i = 2; $i <= 63; $i++) {
            //$cell = 'B'.$i;
            $country = $this->worksheet->getCell("A$i")->getValue();
            //cpcDebug::cpc_debug($country, '@RFQ2533');
            //cpcDebug::cpc_debug('OK:'. $laenderMengen[$country]['Quantity'], '@RFQ2533');
            try {
                //$m = $laenderMengen[$country]['Quantity'];
                //$k = $laenderMengen[$country]['Kolli'];
                //cpcDebug::cpc_debug('OK' . $m , '@RFQ2533');
                if (isset($laenderMengen[$country])) {
                    //$this->worksheet->setCellValue("D$i",$k);
                    //$this->worksheet->setCellValue("E$i",$m);
                    $this->worksheet->setCellValue("B$i", $laenderMengen[$country]['Kolli']);
                    //$this->worksheet->setCellValue("C$i",$laenderMengen[$country]['Quantity']);
                    $this->worksheet->setCellValue("D$i", $laenderMengen[$country]['LT1']);
                    $this->worksheet->setCellValue("E$i", $laenderMengen[$country]['LT1Kolli']);
                    $this->worksheet->setCellValue("F$i", $laenderMengen[$country]['LT2']);
                    $this->worksheet->setCellValue("G$i", $laenderMengen[$country]['LT2Kolli']);
                    $this->worksheet->setCellValue("H$i", $laenderMengen[$country]['LT3']);
                    $this->worksheet->setCellValue("I$i", $laenderMengen[$country]['LT3Kolli']);
                }
            } catch (Exception $ex) {
                cpcDebug::cpc_debug('Exc:' . $ex->getMessage(), '-RFQ2603');
                cpcDebug::cpc_debug('Exc:' . $country, '-RFQ2546');
            }
        }
        $startRow = 68;
        $dist = 9;
        for ($i = 1; $i <= 3; $i++) {
            $rowIndex = $startRow + ($i - 1) * $dist;
            $mTotalLT = $this->getLTMengen($pp->PPProduktpass_Id, $i);
            foreach ($mTotalLT as $mx) {
                $coordLT = $this->getCellA(3, $rowIndex);
                $coordMenge = $this->getCellA(6, $rowIndex);
                $rowIndex++;
                $this->setCellValueAndHight($coordLT['Cell'], $this->getCRDDate($mx['LT']));
                $this->setCellValueAndHight($coordMenge['Cell'], $mx['Menge']);
            }
        }
        $startRowIndex = 98;
        $colIndex = 2;
        for ($i = 2; $i <= 3; $i++) {
            $osMengen = $this->getLTMengenByArt($pp->PPProduktpass_Id, $i);
            $rowIndex = $startRowIndex;
            foreach ($osMengen as $om) {
                $coordLT = $this->getCellA($colIndex, $rowIndex);
                $coordMenge = $this->getCellA($colIndex + 1, $rowIndex);
                $this->setCellValueAndHight($coordLT['Cell'], $this->getCRDDate($om['LT']));
                $this->setCellValueAndHight($coordMenge['Cell'], $om['Menge']);
                $rowIndex++;
            }
            $colIndex += 6;
        }
        //Bedingungs SPALTEN
        $this->setCellValueAndHight($this->getCellA(1, 67)['Cell'], false);
        $this->setCellValueAndHight($this->getCellA(1, 76)['Cell'], false);
        $this->setCellValueAndHight($this->getCellA(1, 85)['Cell'], false);
        $this->hidedInternSheets($objPHPExcel);
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $this->worksheet->setSelectedCells('A1');
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['Main']['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = /* str_random(6).'-'. */ $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->setPreCalculateFormulas(false);
        $objWriter->save($path . $dl_file);
        if ($type == 'R') {
            $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'RFQ', 'EKPM', 'Produktdetails', 'Quote', 'RFQ');
        }
        //$dl = substr($dl_file,7);
        $dl = $dl_file;
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        if ($type == "E") {
            if (file_exists($path . $dl_file)) {
                unlink($path . $dl_file);
            }
        }
        $redirectLink = '/show/' . $ppid . "/RFQ";
        return Redirect::to($redirectLink);
    }
    private function createFileDownload($pp, $trans, $objPHPExcel, $path, $type){
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['Main']['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = /* str_random(6).'-'. */ $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->setPreCalculateFormulas(false);
        $objWriter->save($path . $dl_file);
        $dl = $dl_file;
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
    }
    private function _writeRFQ2546($ppid, $type)
    {
        $mainSheet = 'RFQ_Style A';
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        //cpcDebug::cpc_debug($pp, '-RFQ2546');
        if (! $pp) {
            return;
        }
        $pc = new ProjectsController();
        $trans = $pc->getTranslation($ppid);
        $coord = array();
        $coord['PPProduktpass_Artikelbezeichnung'] =  $this->getCellA(2, 1);
        $coord['PPProduktpass_IAN'] = $this->getCellA(2, 2);
        $coord['weightWithoutPackaging'] =  $this->getCellA(2, 34);
        $coord['sizeWithoutPackaging'] =  $this->getCellA(2, 35);
        $coord['qualityTechnicalData'] =  $this->getCellA(2, 36);
        $coord['additionalQualityInformation'] =  $this->getCellA(2, 41);
        $coord['changesFromPredecessor'] =  $this->getCellA(2, 43);
        $coord['brandReference'] =  $this->getCellA(2, 44);
        $coord['material'] =  $this->getCellA(2, 45);
        $coord['materialThickness'] =  $this->getCellA(2, 46);
        $coord['color'] =  $this->getCellA(2, 47);
        $coord['colorA'] =  $this->getCellA(2, 48);
        $coord['colorB'] =  $this->getCellA(2, 49);
        $coord['colorC'] =  $this->getCellA(2, 50);
        $coord['colorD'] =  $this->getCellA(2, 51);
        $coord['colorE'] =  $this->getCellA(2, 52);
        $coord['colorF'] =  $this->getCellA(2, 53);
        $coord['colorG'] =  $this->getCellA(2, 54);
        $coord['colorH'] =  $this->getCellA(2, 55);
        $coord['colorI'] =  $this->getCellA(2, 56);
        $coord['colorJ'] =  $this->getCellA(2, 57);
        $coord['colorK'] =  $this->getCellA(2, 58);
        $coord['colorL'] =  $this->getCellA(2, 59);
        $coord['colorM'] =  $this->getCellA(2, 60);
        $coord['colorN'] =  $this->getCellA(2, 61);
        $coord['colorO'] =  $this->getCellA(2, 62);
        $coord['colorX'] =  $this->getCellA(2, 48);
        $coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] =  $this->getCellA(2, 99);
        $coord['retailPackagingComment'] =  $this->getCellA(2, 100);
        $coord['Selection'] = $this->getCellA(2, 3);
        $coord['ChildIAN'] = $this->getCellA(2, 4);
        $coord['KAT'] = $this->getCellA(2, 5);
        $coord['Qty'] = $this->getCellA(2, 6);
        $coord['CRD'] = $this->getCellA(2, 7);
        $coord['Shipmentrelease'] = $this->getCellA(2, 8);
        $coord['PSI'] = $this->getCellA(2, 9);
        $coord['RenderingPriceOfferDeadline'] = $this->getCellA(2, 7);
        $coord['MOCKupDeadline'] = $this->getCellA(2, 8);
        $coord['EPCtill'] = $this->getCellA(2, 9);
        $coord['Kolliinhalt'] =  $this->getCellA(4, 63);
        $coord['ProjectPicture'] =  $this->getCellA(2, 33);
        $coord['versandfertigeUmverpackung']  =  $this->getCellA(5, 76);
        $coord['Verkaufsverpackung']  =  $this->getCellA(2, 101);
        /* ********************************************
			- Zelle C102: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Verkaufsverpackung Kaufland“ - Beispiel „Banderole“.
			- Zelle C103: Checkbox: Haken setzten, wenn im PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland“ „Ja“ hinterlegt ist.
			- Zelle E103: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Art“ - Beispiel „U-Tray“
			- Zelle C104: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Farbiges Tray“ - Beispiel „Bedruckt (4C)“
			- Zelle E104: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland Höhe (cm)“
			- Zelle C105: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland Breite (cm)“
			- Zelle E105: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Tray Kaufland Länge (cm)“
			- Zelle C106: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Bemerkung Verpackung Kaufland“
			- Zelle C107: Übertrag aus PP Bereich „Verpackung Kaufland“, genauer „Bemerkung Tray“
		***********************************************/
        $coord['VerkaufsverpackungKL']  =  $this->getCellA(3, 102);
        $coord['TrayKL']                  =  $this->getCellA(3, 103);
        $coord['TrayArtKL']              =  $this->getCellA(5, 103);
        $coord['FarbigesTrayKL']          =  $this->getCellA(3, 104);
        $coord['TrayHoeheKL']              =  $this->getCellA(5, 104);
        $coord['TrayBreiteKL']          =  $this->getCellA(3, 105);
        $coord['TrayLaengeKL']          =  $this->getCellA(5, 105);
        $coord['VerpackungBemerkungKL'] =  $this->getCellA(3, 106);
        $coord['TrayBemerkungKL']          =  $this->getCellA(3, 107);
        /* ******************************************************
			- Zelle B141: Übertrag aus PP Bereich „Kennzeichnung“, genauer „Zertifikate“
		*  ********************************************************/
        $coord['Zertifikate']              =  $this->getCellA(2, 141);
        /* ********************************************************
		Risikokategorie:
		- Zelle D182: Übertrag aus PP Bereich „Risikiokategorie“, genauer „Geeignet für Kinder“
		- Zelle D183: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „LFGB“ ein Haken gesetzt ist
		- Zelle D184: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „NGO Prüfung“ ein Haken gesetzt ist
		- Zelle D185: Übertrag aus PP Bereich „Risikiokategorie“, genauer „NGO Prüfung Bem.“
		- Zelle D186: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „PSA“ ein Haken gesetzt ist
		- Zelle D187: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „Medizinprodukt“ ein Haken gesetzt ist
		- Zelle D188: Checkbox: Haken setzten, wenn im PP Bereich „Risikiokategorie“, genauer „Referenztest“ ein Haken gesetzt ist
		* *************************************************/
        $coord['GeeignetfürKinder']         =  $this->getCellA(4, 182);
        $coord['LFGB']                      =  $this->getCellA(4, 183);
        $coord['NGOPruefung']                  =  $this->getCellA(4, 184);
        $coord['NGOPruefungBemerkung']      =  $this->getCellA(4, 185);
        $coord['PSA']                          =  $this->getCellA(4, 186);
        $coord['Medizinprodukt']              =  $this->getCellA(4, 187);
        $coord['Referenztest']              =  $this->getCellA(4, 188);
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/RFQ_Template_2546.xlsx';
        /******************************************************************* */
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        foreach ($trans['Main'] as $key => $value) {
            cpcDebug::cpc_debug($key, '-RFQ2546');
            cpcDebug::cpc_debug($value, '-RFQ2546');
            $textEN = $value['EN']; //$this->replace0d($value['EN']);
            $this->setCellValueAndHight($coord[$key]['Cell'], $textEN);
            $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            //$this->setRowHeightText($coord[$key]['Row'], $textEN) ;
        }
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Style_Header')->get();
        $colorFirst = 48;
        $countZ = 1;
        foreach ($styles as $style) {
            if ($countZ > 1) {
                $this->setCellValueAndHight($coord['color']['Cell'], '');
            }
            $styleCharNo = $colorFirst + ord(substr($style->PPProduktpass_Style_Header, -1)) - ord('A');
            if (strpos($style->PPProduktpass_Style_Header, 'X') !== false) {
                $styleCharNo = $colorFirst;
            }
            //$colCoord = $this->getCellA(2,$colorFrist++);
            $colCoord = $this->getCellA(1, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], "(Color)-Style " . $style->PPProduktpass_Style_Header);
            $colCoord = $this->getCellA(2, $styleCharNo);
            $this->setCellValueAndHight($colCoord['Cell'], $trans['Styles'][$style->PPProduktpass_Style_Header]['color']['EN']);
            //$this->setCellValueAndHight($colCoord['Cell'],$style->PPProduktpass_Style_Header);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
            //$this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
            $countZ++;
        }
        $selection =  substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $this->setCellValueAndHight($coord['Selection']['Cell'], $selection);
        $crd = $this->getCRDString($this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche));
        $this->setCellValueAndHight($coord['CRD']['Cell'], $crd);
        $shipmentrelease =  $this->getShipmentreleaseString($this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche));
        $this->setCellValueAndHight($coord['Shipmentrelease']['Cell'], $shipmentrelease);
        $PSI =  $this->getPSIString($this->getCRD($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche));
        $this->setCellValueAndHight($coord['PSI']['Cell'], $PSI);
        //$renderingDeadline = $this->getRend($pp->PPProduktpass_LieferterminJahr, $pp->PPProduktpass_Liefertermin);
        //$this->setCellValueAndHight($coord['RenderingPriceOfferDeadline']['Cell'],$renderingDeadline);
        //$this->setCellValueAndHight($coord['MOCKupDeadline']['Cell'],'???');
        //$this->setCellValueAndHight($coord['EPCtill']['Cell'],$selection);
        $qty = $pp->PPProduktpass_Gesamtmenge;
        $this->setCellValueAndHight($coord['Qty']['Cell'], $qty);
        // packagingKL_materialThickness, packagingKL_retailPackagingComment, packagingKL_trayRemarks, packagingKL_rt_name, packagingKL_tray_name,
        // packagingKL_trayType, packagingKL_trayFacingLayer, packagingKL_trayColor, packagingKL_trayMaxCartonLength, packagingKL_trayMaxCartonWidth, packagingKL_trayMaxCartonHeight
        $this->setCellValueAndHight($coord['Verkaufsverpackung']['Cell'],   ServiceProvider::tl('EN', $pp->PPProduktpass_Verkaufsverpackung));
        $this->setCellValueAndHight($coord['VerkaufsverpackungKL']['Cell'], ServiceProvider::tl('EN', $pp->packagingKL_rt_name));
        $this->setCellValueAndHight($coord['TrayKL']['Cell'],               ServiceProvider::tl('EN', $pp->packagingKL_tray_name));
        $this->setCellValueAndHight($coord['TrayArtKL']['Cell'],            ServiceProvider::tl('EN', $pp->packagingKL_trayType));
        $this->setCellValueAndHight($coord['FarbigesTrayKL']['Cell'],        ServiceProvider::tl('EN', $pp->packagingKL_trayColor));
        $this->setCellValueAndHight($coord['TrayHoeheKL']['Cell'],            $pp->packagingKL_trayMaxCartonHeight);
        $this->setCellValueAndHight($coord['TrayBreiteKL']['Cell'],            $pp->packagingKL_trayMaxCartonWidth);
        $this->setCellValueAndHight($coord['TrayLaengeKL']['Cell'],            $pp->packagingKL_trayMaxCartonLength);
        //$this->setCellValueAndHight($coord['VerpackungBemerkungKL']['Cell'],ServiceProvider::tl('EN',$pp->packagingKL_retailPackagingComment));
        $this->worksheet->setCellValue($coord['VerpackungBemerkungKL']['Cell'], ServiceProvider::tl('EN', $pp->packagingKL_retailPackagingComment));
        //$this->setCellValueAndHight($coord['TrayBemerkungKL']['Cell'], 		ServiceProvider::tl('EN',$pp->packagingKL_trayRemarks) );
        $this->worksheet->setCellValue($coord['TrayBemerkungKL']['Cell'],         ServiceProvider::tl('EN', $pp->packagingKL_trayRemarks));
        $this->setCellValueAndHight($coord['versandfertigeUmverpackung']['Cell'], $this->trueFalseToJaNein($pp->PPProduktpass_versandfertigeUmverpackung));
        $zert =      $pp->PPProduktpass_Zertifizierungen . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften2 . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften3 . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften4 . ' ' .
            $pp->PPProduktpass_ZertifizierungEigenschaften5;
        $this->setCellValueAndHight($coord['Zertifikate']['Cell'],         $zert);
        $this->setCellValueAndHight($coord['GeeignetfürKinder']['Cell'], $this->trueFalseToJaNein($pp->childSuitable));
        $this->setCellValueAndHight($coord['LFGB']['Cell'], $this->trueFalseToJaNein($pp->LFGB));
        $this->setCellValueAndHight($coord['NGOPruefung']['Cell'], $this->trueFalseToJaNein($pp->ngoTest));
        $this->setCellValueAndHight($coord['NGOPruefungBemerkung']['Cell'], ServiceProvider::tl('EN', $pp->ngoTestNote));
        $this->setCellValueAndHight($coord['PSA']['Cell'], $this->trueFalseToJaNein($pp->ppe));
        $this->setCellValueAndHight($coord['Medizinprodukt']['Cell'], $this->trueFalseToJaNein($pp->medProduct));
        $this->setCellValueAndHight($coord['Referenztest']['Cell'], $this->trueFalseToJaNein($pp->referenceCheck));
        $this->worksheet->setCellValue($coord['PPProduktpass_Materialstaerke_der_Verkaufsverpackung']['Cell'], ServiceProvider::tl('EN', $pp->PPProduktpass_Materialstaerke_der_Verkaufsverpackung));
        $this->worksheet->setCellValue($coord['retailPackagingComment']['Cell'], ServiceProvider::tl('EN', $pp->retailPackagingComment));
        $this->writeFirstStyle($coord, $pp->PPProduktpass_Id);
        $child = 'n.A.';
        if ($pp->isChild) {
            $child = 'Ja';
        }
        $this->setCellValueAndHight($coord['ChildIAN']['Cell'], $child);
        $kat = '';
        if (strpos($pp->PPProduktpass_Artikelbezeichnung, 'KAT') !== false) {
            $kat = 'Ja';
        }
        $this->setCellValueAndHight($coord['KAT']['Cell'], $kat);
        $sort = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Sortierung_Id')->get()->first();
        $kolli = 0;
        if ($sort) {
            $kolli = $sort->PPProduktpass_Sortierung_Value02;
        }
        $this->setCellValueAndHight($coord['Kolliinhalt']['Cell'], $kolli);
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $coord['ProjectPicture']['Cell'], 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
        if ($type == 'R') {
            $path = public_path() . '/data/uploads/RFQ/';
        } else {
            $path = public_path() . '/data/tmp';
        }
        $stylesArray = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',    'U', 'X');
        //$stylesArray = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',	'U');
        foreach ($stylesArray as $styleChar) {
            $this->writeStyle2546($pp->PPProduktpass_Id, $styleChar, $objPHPExcel, $trans);
        }
        //schreibe Mengen#
        $objPHPExcel->setActiveSheetIndexByName('Quantity overview');
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $laenderMengen = $this->getLaenderMengenX($pp->PPProduktpass_Id);
        //cpcDebug::cpc_debug($laenderMengen['US']['Quantity'], '@RFQ2533');
        //cpcDebug::cpc_debug('Ländermengen eintragen', '-RFQ2546');
        for ($i = 5; $i <= 58; $i++) {
            //$cell = 'B'.$i;
            $country = $this->worksheet->getCell("A$i")->getValue();
            //cpcDebug::cpc_debug($country, '@RFQ2533');
            //cpcDebug::cpc_debug('OK:'. $laenderMengen[$country]['Quantity'], '@RFQ2533');
            try {
                //$m = $laenderMengen[$country]['Quantity'];
                //$k = $laenderMengen[$country]['Kolli'];
                //cpcDebug::cpc_debug('OK' . $m , '@RFQ2533');
                if (isset($laenderMengen[$country])) {
                    //$this->worksheet->setCellValue("D$i",$k);
                    //$this->worksheet->setCellValue("E$i",$m);
                    $this->worksheet->setCellValue("B$i", $laenderMengen[$country]['Kolli']);
                    $this->worksheet->setCellValue("C$i", $laenderMengen[$country]['Quantity']);
                    $this->worksheet->setCellValue("D$i", $laenderMengen[$country]['LT1']);
                    $this->worksheet->setCellValue("E$i", $laenderMengen[$country]['LT1Kolli']);
                    $this->worksheet->setCellValue("F$i", $laenderMengen[$country]['LT2']);
                    $this->worksheet->setCellValue("G$i", $laenderMengen[$country]['LT2Kolli']);
                    $this->worksheet->setCellValue("H$i", $laenderMengen[$country]['LT3']);
                    $this->worksheet->setCellValue("I$i", $laenderMengen[$country]['LT3Kolli']);
                }
            } catch (Exception $ex) {
                cpcDebug::cpc_debug('Exc:' . $ex->getMessage(), '-RFQ2546');
                cpcDebug::cpc_debug('Exc:' . $country, '-RFQ2546');
            }
        }
        $this->worksheet->setCellValue("B2", $pp->PPProduktpass_Gesamtmenge);
        //$this->AndHightsetCellValue($coord['RenderingPriceOfferDeadline']['Cell'],$renderingDeadline);
        //Ende Schreibe Mengen
        $objPHPExcel->setActiveSheetIndexByName($mainSheet);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $this->worksheet->setSelectedCells('A1');
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $bad = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
        $article = str_replace($bad, "_", $trans['Main']['PPProduktpass_Artikelbezeichnung']['EN']);    //
        $heute = date('Ymd');
        $dl_file = /* str_random(6).'-'. */ $ian . '-' . $ausm . '-RFQ-' . $article . '-' . $heute . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        if ($type == 'R') {
            $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'RFQ', 'EKPM', 'Produktdetails', 'Quote', 'RFQ');
        }
        //$dl = substr($dl_file,7);
        $dl = $dl_file;
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        if ($type == "E") {
            if (file_exists($path . $dl_file)) {
                unlink($path . $dl_file);
            }
        }
        $redirectLink = '/show/' . $ppid . "/RFQ";
        return Redirect::to($redirectLink);
    }
    private function getLaendermengenX($id)
    {
        $laenderMengen = array();
        $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', $id)->get();
        $total = 0;
        try {
            if ($mengen) {
                foreach ($mengen as $menge) {
                    $crd = $this->getCRDDate($menge->PPProduktpass_Menge_DeliveryWeek);
                    $crd1 = $this->getCRDDate($menge->PPProduktpass_Menge_LT1);
                    $crd2 = $this->getCRDDate($menge->PPProduktpass_Menge_LT2);
                    $crd3 = $this->getCRDDate($menge->PPProduktpass_Menge_LT3);
                    //echo($menge->PPProduktpass_Menge_Country." => LT: ".$menge->PPProduktpass_Menge_DeliveryWeek."  CRD => ".$crd."<br>");
                    $laenderMengen[$menge->PPProduktpass_Menge_Country] =
                        array(
                            'Quantity' => $menge->PPProduktpass_Menge_Quantity,
                            "LT" => $crd,
                            "Kolli" => $menge->PPProduktpass_Menge_TotalSalePerUnit,
                            "LT1" => $crd1,
                            "LT1Kolli" => $menge->PPProduktpass_Menge_LT1Menge,
                            "LT2" => $crd2,
                            "LT2Kolli" => $menge->PPProduktpass_Menge_LT2Menge,
                            "LT3" => $crd3,
                            "LT3Kolli" => $menge->PPProduktpass_Menge_LT3Menge
                        );
                    $total += $menge->PPProduktpass_Menge_Quantity;
                }
            }
        } catch (Exception $ex) {
            cpcDebug::cpc_debug('getLaendermengenX: ' . $ex->getMessage(), '-RFQ2546');
            foreach ($this->_lbez as $land => $bez) {
                $laenderMengen[$land] = array(
                    'Quantity' => 0,
                    "LT" => '',
                    "Kolli" => 0,
                    "LT1" => '',
                    "LT1Kolli" => 0,
                    "LT2" => '',
                    "LT2Kolli" => 0,
                    "LT3" => '',
                    "LT3Kolli" => 0
                );
            }
        }
        return $laenderMengen;
    }
    private  function writeExcel_Anfrage($id, $send, $to, $cc, $body, $download, $neu)
    {
        $redirectLink = '/show/' . $id . "/ServiceAnfrage";
        if ($neu) {
            $redirectLink = '/show/' . $id . '/ServiceAnfrage';
        }
        cpcDebug::cpc_debug('writeExcel_Anfrage: Start PPID: ' . $id, '-AnfrageExcel');
        cpcDebug::cpc_debug(Input::all(), '-AnfrageExcel');
        //$fileType = 'Excel2007';
        //$fileName = storage_path().'/data/templates/TemplateAnfrage2023.xlsx';
        $fileName = storage_path() . '/data/templates/ServiceAnfrage_26_02_2026_TPT.xlsx';
        //$objReader = PHPExcel_IOFactory::createReader($fileType);
        //$inputFileType = "Xls"; //\PhpOffice\PhpSpreadsheet\IOFactory::identify($fileName); //::identify($fileName);
        //$objReader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        //$objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objPHPExcel = $objReader->load($fileName);
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $pp = tPPProduktpass::find($id);
        if (!$pp) {
            echo ("PP [$id] not found!");
            exit;
        }
        $laenderMengen = $this->getLaendermengenX($id);
        //$this->worksheet->setCellValue($this->getCell(3,8)," ".substr($pp->PPProduktpass_Ausmusterungnummer,0,4));
        //$man = PPInputManuell::where('PPInputManuell_PPProduktpass_Id', $id)->get()->first();
        $man = PPInputManuell::where('PPInputManuell_IsLatest', 1)->where('PPInputManuell_PPProduktpass_Id', $id)->orderBy('PPInputManuell_Date', 'desc')->get()->first();
        if ($man) {
            $man->PPInputManuell_StatusPM = 1;
            $isFinal = 0;
            if (Input::has('isFinal')) {
                $isFinal = 1;
            }
            $man->PPInputManuell_IsFinal = $isFinal;
            //cpcDebug::cpc_debug('writeExcel_Anfrage: PPID: '. $man->PPInputManuell_PPProduktpass_Id .'  MaId:'. $man->PPInputManuell_Id .' switch StatusPM 0 => 1');
            $man->save();
            $pc = new ProjectsController();
            $comp = $pc->compareManuellInput($man->PPInputManuell_Id);
            //dd($man->PPInputManuell_UAWGB);			exit;
            try {
                $uawg = new DateTime($man->PPInputManuell_UAWGB);
                $uawg = $uawg->format('d.m.Y');
            } catch (Exception $ex) {
                $uawg = "????";
            }
            //dd($uawg);			exit;
            $mailSubject = $pp->PPProduktpass_IAN . "_" . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4) . "_" . $man->PPInputManuell_Projektname . " / Kalkulation / Service, Fracht und Logistik / spätestens bis $uawg";
            $this->worksheet->setCellValue($this->getCell(9, 5), $pp->InternerStatus);
            $this->worksheet->setCellValue($this->getCell(3, 5), $pp->PPProduktpass_IAN . "_" . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4));
            $this->worksheet->setCellValue($this->getCell(3, 8), substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4));
            $this->setCellValueCompare($this->getCell(3, 1), $man, $comp, 'PPInputManuell_UAWGB');
            $this->setCellValueCompare($this->getCell(3, 2), $man, $comp, 'PPInputManuell_Projektname');
            $this->setCellValueCompare($this->getCell(3, 7), $man, $comp, 'PPInputManuell_Lieferant');
            $this->setCellValueCompare($this->getCell(3, 9), $man, $comp, 'PPInputManuell_GeplanterEKUSD');
            $this->setCellValueCompare($this->getCell(3, 10), $man, $comp, 'PPInputManuell_GeplanterVK');
            $this->setCellValueCompare($this->getCell(3, 12), $man, $comp, 'PPInputManuell_LaufzeitGarantie');
            $this->setCellValueCompare($this->getCell(3, 14), $man, $comp, 'PPInputManuell_GarantieLieferant');
            $this->setCellValueCompare($this->getCell(3, 15), $man, $comp, 'PPInputManuell_AbwicklungGarantie');
            $this->setCellValueCompare($this->getCell(3, 16), $man, $comp, 'PPInputManuell_SonderleistungLieferant');
            $this->setCellValueCompare($this->getCell(3, 17), $man, $comp, 'PPInputManuell_MaxAusfallrate');
            $this->setCellValueCompare($this->getCell(3, 18), $man, $comp, 'PPInputManuell_ServiceVetrag');
            $this->setCellValueCompare($this->getCell(9, 15), $man, $comp, 'PPInputManuell_TextGroesse');
            $this->worksheet->setCellValue($this->getCell(2, 25), '1');
            $this->setCellValueCompare($this->getCell(4, 20), $man, $comp, 'PPInputManuell_ContPlan20');
            $this->setCellValueCompare($this->getCell(5, 20), $man, $comp, 'PPInputManuell_ContPlan40');
            $this->setCellValueCompare($this->getCell(6, 20), $man, $comp, 'PPInputManuell_ContPlan40HC');
            $this->setCellValueCompare($this->getCell(4, 21), $man, $comp, 'PPInputManuell_KLContPlan20');
            $this->setCellValueCompare($this->getCell(5, 21), $man, $comp, 'PPInputManuell_KLContPlan40');
            $this->setCellValueCompare($this->getCell(6, 21), $man, $comp, 'PPInputManuell_KLContPlan40HC');
            $this->setCellValueCompare($this->getCell(3, 23), $man, $comp, 'PPInputManuell_Verschiffungshafen');
            $row = 26;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_VEGB1');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_Masse');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_Laenge');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_Breite');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_Hoehe');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_VEGB2');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_Masse2');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_Laenge2');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_Breite2');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_Hoehe2');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_Exportkarton_VE');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_Exportkarton_Masse');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_Exportkarton_Laenge');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_Exportkarton_Breite');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_Exportkarton_Hoehe');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_Exportkarton_VE_V2');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_Exportkarton_Masse_V2');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_Exportkarton_Laenge_V2');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_Exportkarton_Breite_V2');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_Exportkarton_Hoehe_V2');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_OSExportkarton_VE');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Masse');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Laenge');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Breite');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Hoehe');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_OSExportkarton_VE_V2');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Masse_V2');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Laenge_V2');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Breite_V2');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_OSExportkarton_Hoehe_V2');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_KLExportkarton_VE');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Masse');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Laenge');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Breite');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Hoehe');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_KLExportkarton_VE_V2');
            $this->setCellValueCompare($this->getCell(3, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Masse_V2');
            $this->setCellValueCompare($this->getCell(4, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Laenge_V2');
            $this->setCellValueCompare($this->getCell(5, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Breite_V2');
            $this->setCellValueCompare($this->getCell(6, $row), $man, $comp, 'PPInputManuell_KLExportkarton_Hoehe_V2');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_Onlinekartonage');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_MengeDE');
            $row++;
            $this->setCellValueCompare($this->getCell(2, $row), $man, $comp, 'PPInputManuell_MengeEU');
        }
        /*$laenderMengen = array();
		foreach($mengen as $menge){
			$laenderMengen[$menge->PPProduktpass_Menge_Country] = array('Quantity' => $menge->PPProduktpass_Menge_Quantity, "LT" => $menge->PPProduktpass_Menge_DeliveryWeek);
		}*/
        $col = 23;
        $row = 33;
        /* if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
			$row = 33;
		} */
        foreach ($this->_lbez as $land => $bez) {
            if (isset($laenderMengen[$land])) {
                //$this->worksheet->setCellValue($this->getCell($col,$row),$bez);
                //$this->worksheet->setCellValue($this->getCell($col-2,$row), $land);
                $this->worksheet->setCellValue($this->getCell($col - 1, $row), $laenderMengen[$land]['Kolli']);
                $this->worksheet->setCellValue($this->getCell($col, $row), $laenderMengen[$land]['Quantity']);
                $this->worksheet->setCellValue($this->getCell($col + 1, $row), $laenderMengen[$land]['LT1']);
                $this->worksheet->setCellValue($this->getCell($col + 2, $row), $laenderMengen[$land]['LT1Kolli']);
                $this->worksheet->setCellValue($this->getCell($col + 3, $row), $laenderMengen[$land]['LT2']);
                $this->worksheet->setCellValue('AA' . $row, $laenderMengen[$land]['LT2Kolli']);
                $this->worksheet->setCellValue('AB' . $row, $laenderMengen[$land]['LT3']);
                $this->worksheet->setCellValue('AC' . $row, $laenderMengen[$land]['LT3Kolli']);
                $this->worksheet->setCellValue('AD' . $row, $land);
            }
            $row++;
        }
        $path = public_path() . '/data/uploads/AnfragenService/';
        /*$pc = new ProjectsController();
		$trans = $pc->getTranslation($pp->PPProduktpass_Id);
		$ian = $pp->PPProduktpass_IAN;
		$ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
		$bad = array_merge(array_map('chr', range(0,31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*", " "));
		$article = str_replace($bad, "_",$trans['PPProduktpass_Artikelbezeichnung']['EN'] );	//
		$heute = date('Ymd');
		$dl_file = str_random(6).'-'.$ian.'-'.$ausm.'-RFQ-'.$article.'-'.$heute.'.xlsx'; */
        $dl_file = str_random(6) . '_ServiceAnfrage_IAN_' . $pp->PPProduktpass_IAN . '.xlsx';
        $mailFilename = 'ServiceAnfrage_IAN_' . $pp->PPProduktpass_IAN . '.xlsx';
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        $this->saveFile($pp->PPProduktpass_Id, $dl_file, 'AnfragenService', 'Service', 'Haupt', 'Servicekalkulation', 'Anfrage Kalkulation Service und Fracht ');
        $man->PPInputManuell_Date = date('Y-m-d H:i:s');
        $man->save();
        //echo($path.$dl_file);exit;
        if ($send) {
            $subject = $mailSubject;
            $server = "https://" . $_SERVER['SERVER_NAME'];
            $xbody = 'Im Anhang unsere Serviceanfrage zur IAN ' . $pp->PPProduktpass_IAN . '<br><br>' . "<a href='" . $server . "/show/" . $pp->PPProduktpass_Id . "/ServiceAnfrage'>Link zur Serviceanfrage IAN-" . $pp->PPProduktpass_IAN . "</a><br><br>";
            $body = $xbody . $body;
            //echo("Send mail to: $to $cc $subject $body <br>");
            //exit;
            /*$to = 'f.keppel@compecon.de';
			$cc = 'info@compecon.de';*/
            $this->sendFile($path . $dl_file, $subject, $body, $to, $cc, $mailFilename);
        }
        if ($download) {
            $dl = substr($dl_file, 7);
            $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        }
        return Redirect::to($redirectLink);
        //header('Content-Type: application/vnd.ms-excel');
        //header('Content-Disposition: attachment;filename="'.$pp['PPProduktpass_IAN']."_NEUII.xlsx".'"');
        //header('Cache-Control: max-age=0');						
    }
    private function sendFile($file, $subject, $body, $to, $cc, $fname)
    {
        $mail = new MailController();
        /*if (strtoupper(Auth::user()->PPMitarbeiter_Kuerzel) == 'FKE'){
			echo(" File: $file $subject  $to<br> <pre>");
			print_r($cc);
			echo("</pre>");
			exit;
		}*/
        if (! $mail->sendMail($to, $cc, $subject, $body, $file, $fname)) {
            echo ("Mail an: $to Betreff: $subject konnte nicht gesendet werden!");
            exit;
        }
        //echo("Mail send complete<br>");		exit;
    }
    private function saveFile($ppid, $f, $path, $cat, $subcat, $ordnung = 'Sonstiges', $remark = "")
    {
        $files                             = new PPPPFiles();
        $files->PPPPFiles_Name             = $f;
        $files->PPPPFiles_PPProduktpass_Id = $ppid;
        $files->PPPPFiles_Type             = $cat;
        $files->PPPPFiles_Pfad             = "uploads/$path";
        $files->PPPPFiles_SubKat           = $subcat;
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_Ordnung          = $ordnung;
        $files->PPPPFiles_Description      = $remark . date("Y-m-d H:i:s");
        $files->PPPPFiles_LocalUpload      = 1;
        $files->PPPPFiles_UserCreate       = Auth::user()->PPMitarbeiter_Id;
        $files->PPPPFiles_IsExtern            =  0;
        if (ServiceProvider::AuthUserHasRole('EXTERN')) {
            $files->PPPPFiles_IsExtern     =  1;
        }
        $files->save();
    }
    private function  getDrawing($drawing)
    {
        $zipReader = fopen($drawing->getPath(), 'r');
        $imageContents = '';
        while (!feof($zipReader)) {
            $imageContents .= fread($zipReader, 1024);
        }
        fclose($zipReader);
        return $imageContents;
    }
    public function getExcelPics($id)
    {
        echo ($id . date('d.m.Y H:i:s') . '<br>');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('data') . "/ExcelTest.xlsx");
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheetArray = $worksheet->toArray();
        //array_shift($worksheetArray);
        foreach ($worksheetArray as $key => $value) {
            $worksheet = $spreadsheet->getActiveSheet();
            $drawings = $worksheet->getDrawingCollection();
            foreach ($drawings as $drawing) {
                $imageContents = $this->getDrawing($drawing);
                echo ($drawing->getName());
                echo '<img  height="150px" width="150px"   src="data:image/jpeg;base64,' . base64_encode($imageContents) . '"/><br />';
            }
            //$extension = $drawing->getExtension();
        }
    }
    function makeDownload($file, $dir, $type, $dlname = '')
    {
        $download = $dir . $file;
        if (file_exists($download)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $dlname . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($download));
            //header("location: http://targa-test.twoffice.de/data/uploads/AnfragenService/$file");
            readfile($dir . $file);
            exit;
        }
    }
    private function setValue($table, $att, $data)
    {
        if (isset($data[$att]) and !is_null($data[$att])) {
            return  $this->convertValue($table, $att, $data[$att]);
        } else {
            //echo("$table $att <br>");
        }
        return '';
    }
    private function convertValue($table, $field, $value)
    {
        switch ($table) {
            case 'tPPProduktpass':
                switch ($field) {
                    case 'PPProduktpass_Ausmusterungnummer':
                        $result = str_replace('AM 20', '', $value);
                        $result = str_replace('/', '', $result);
                        break;
                    case 'isCatalogue':
                        $result = 0;
                        if ($value == 'Ja') {
                            $result = 1;
                        }
                        break;
                    case 'PPProduktpass_Gesamtmenge':
                        $result = str_replace(',', '', $value);
                        $result = str_replace('.', '', $result);
                        break;
                    case 'PPProduktpass_PMAdmin':
                        $kuerzel = strtoupper($value);
                        $pm = PPMitarbeiter::whereRAW('UPPER(PPMitarbeiter_Kuerzel) = (?)', [$value])->get();
                        $result = 0;
                        if ($pm) {
                            if (isset($pm[0])) {
                                $result = $pm[0]->PPMitarbeiter_Id;
                            }
                        }
                        break;
                    default:
                        $result = $value;
                }
                break;
            case 'PPProduktpass_Style':
                switch ($field) {
                    case 'X':
                        break;
                    default:
                        $result = $value;
                }
                break;
            default:
                $result = $value;
        }
        return $result;
    }
    private function importStyle($ppid, $data)
    {
        $style = new PPProduktpass_Style();
        $table = 'PPProduktpass_Style';
        $style->PPProduktpass_Style_Header = $this->setValue($table, 'PPProduktpass_Style_Header', $data);
        $style->PPProduktpass_Style_Value01 = $this->setValue($table, 'PPProduktpass_Style_Value01', $data);
        $style->PPProduktpass_Style_Value02 = $this->setValue($table, 'PPProduktpass_Style_Value02', $data);
        $style->PPProduktpass_Style_Value03 = $this->setValue($table, 'PPProduktpass_Style_Value03', $data);
        $style->PPProduktpass_Style_Value04 = $this->setValue($table, 'PPProduktpass_Style_Value04', $data);
        $style->PPProduktpass_Style_Value05 = $this->setValue($table, 'PPProduktpass_Style_Value05', $data);
        $style->PPProduktpass_Style_PPProduktpass_Id = $ppid;
        $style->PPProduktpass_Style_PPPPFiles_Id = $this->setValue($table, 'PPProduktpass_Style_PPPPFiles_Id', $data);
        $style->PPProduktpass_Style_LidlID = $this->setValue($table, 'PPProduktpass_Style_LidlID', $data);
        $style->PPProduktpass_Style_Zolltarifnummer = $this->setValue($table, 'PPProduktpass_Style_Zolltarifnummer', $data);
        $style->PPProduktpass_Style_Value01_Translation = $this->setValue($table, 'PPProduktpass_Style_Value01_Translation', $data);
        $style->PPProduktpass_Style_Value02_Translation = $this->setValue($table, 'PPProduktpass_Style_Value02_Translation', $data);
        $style->PPProduktpass_Style_Value03_Translation = $this->setValue($table, 'PPProduktpass_Style_Value03_Translation', $data);
        $style->PPProduktpass_Style_Value04_Translation = $this->setValue($table, 'PPProduktpass_Style_Value04_Translation', $data);
        $style->PPProduktpass_Style_Value05_Translation = $this->setValue($table, 'PPProduktpass_Style_Value05_Translation', $data);
        $style->productName = $this->setValue($table, 'productName', $data);
        $style->styleNo = $this->setValue($table, 'styleNo', $data);
        $style->uniqueId = $this->setValue($table, 'uniqueId', $data);
        $style->vendorUniqueId = $this->setValue($table, 'vendorUniqueId', $data);
        $style->color = $this->setValue($table, 'color', $data);
        $style->internalSeqNo = $this->setValue($table, 'internalSeqNo', $data);
        $style->material = $this->setValue($table, 'material', $data);
        $style->notOrderable = $this->setValue($table, 'notOrderable', $data);
        $style->qualityTechnicalData = $this->setValue($table, 'qualityTechnicalData', $data);
        $style->sizeWithoutPackaging = $this->setValue($table, 'sizeWithoutPackaging', $data);
        $style->weightWithoutPackaging = $this->setValue($table, 'weightWithoutPackaging', $data);
        $style->additionalQualityInformation = $this->setValue($table, 'additionalQualityInformation', $data);
        $style->changesFromPredecessor = $this->setValue($table, 'changesFromPredecessor', $data);
        $style->brandReference = $this->setValue($table, 'brandReference', $data);
        $style->materialThickness = $this->setValue($table, 'materialThickness', $data);
        $style->save();
    }
    private function newPProduktpass($data)
    {
        $pprevid = 0;
        $prev_revno = 0;
        $ausm = $this->setValue('tPPProduktpass', 'PPProduktpass_Ausmusterungnummer', $data);
        $pps = tPPProduktpass::where('PPProduktpass_IAN', $data['PPProduktpass_IAN'])->where('PPProduktpass_Ausmusterungnummer', 'like', $ausm . '%')->get()->first();
        $ppThemenplanungEx = false;
        if ($pps) {
            if (strlen($pps->PPProduktpass_Ausmusterungnummer) > 4) {
                // Echter Produktpass existiert => nicht überschreiben
                //echo('Produktpass: '.$pps->PPProduktpass_IAN.' Charge: '.$pps->PPProduktpass_Ausmusterungnummer.' existiert schon!<br>');
                return array('result' => false, 'ppid' => $pps->PPProduktpass_Id);
            }
            $ppThemenplanungEx = true;
        }
        if ($ppThemenplanungEx) {
            $ppold = tPPProduktpass::where('PPProduktpass_IAN', 'like', $data['PPProduktpass_IAN'])->where('PPProduktpass_Ausmusterungnummer', '=', $ausm)->orderBy('PPProduktpass_Id', 'DESC')->get()->first();
            $pprevid = $ppold->PPProduktpass_Id;
            $prev_revno = $ppold->PPProduktpass_Revisionsnummer;
            $ppold->PPProduktpass_IAN = $ppold->PPProduktpass_IAN . " (Rev. $prev_revno)";
            $ppold->save();
        }
        $prev_revno++;
        //echo('Prev Id: '. $pprevid. ' Prev RevNo: '. $prev_revno); exit;
        $pp = new tPPProduktpass();
        $table = 'tPPProduktpass';
        $pp->PPProduktpass_IAN =  $this->setValue($table, 'PPProduktpass_IAN', $data);
        $pp->PPProduktpass_TargaTNr =  $this->setValue($table, 'PPProduktpass_TargaTNr', $data);
        $pp->PPProduktpass_Artikelbezeichnung = $this->setValue($table, 'PPProduktpass_Artikelbezeichnung', $data);
        $pp->PPProduktpass_Ausmusterung = $this->setValue($table, 'PPProduktpass_Ausmusterung', $data);
        $pp->PPProduktpass_Ausmusterungnummer = $this->setValue($table, 'PPProduktpass_Ausmusterungnummer', $data);
        $pp->PPProduktpass_AltIAN = $this->setValue($table, 'PPProduktpass_AltIAN', $data);
        $pp->PPProduktpass_AltArtikelbezeichnung = $this->setValue($table, 'PPProduktpass_AltArtikelbezeichnung', $data);
        $pp->PPProduktpass_Warengruppe = $this->setValue($table, 'PPProduktpass_Warengruppe', $data);
        $pp->PPProduktpass_Neu_Warengruppe = $this->setValue($table, 'PPProduktpass_Neu_Warengruppe', $data);
        $pp->PPProduktpass_Verpackungseinheit = $this->setValue($table, 'PPProduktpass_Verpackungseinheit', $data);
        $pp->PPProduktpass_Thema = $this->setValue($table, 'PPProduktpass_Thema', $data);
        $pp->PPProduktpass_Liefertermin = $this->setValue($table, 'PPProduktpass_Liefertermin', $data);
        $pp->PPProduktpass_Einkaeufer = $this->setValue($table, 'PPProduktpass_Einkaeufer', $data);
        $pp->PPProduktpass_Marke = $this->setValue($table, 'PPProduktpass_Marke', $data);
        $pp->PPProduktpass_Gesamtmenge = $this->setValue($table, 'PPProduktpass_Gesamtmenge', $data);
        $pp->PPProduktpass_Planmenge = $this->setValue($table, 'PPProduktpass_Gesamtmenge', $data);
        $pp->PPProduktpass_Pruefinstitut = $this->setValue($table, 'PPProduktpass_Pruefinstitut', $data);
        $pp->PPProduktpass_Andere_Kriterien = $this->setValue($table, 'PPProduktpass_Andere_Kriterien', $data);
        $pp->PPProduktpass_Zertifizierungen = $this->setValue($table, 'PPProduktpass_Zertifizierungen', $data);
        $pp->PPProduktpass_Logos = $this->setValue($table, 'PPProduktpass_Logos', $data);
        $pp->PPProduktpass_Verkaufsverpackung = $this->setValue($table, 'PPProduktpass_Verkaufsverpackung', $data);
        $pp->PPProduktpass_Materialstaerke_der_Verkaufsverpackung = $this->setValue($table, 'PPProduktpass_Materialstaerke_der_Verkaufsverpackung', $data);
        $pp->PPProduktpass_Agentur = $this->setValue($table, 'PPProduktpass_Agentur', $data);
        $pp->PPProduktpass_PPProjekte_Id = $this->setValue($table, 'PPProduktpass_PPProjekte_Id', $data);
        $pp->PPProduktpass_Material = $this->setValue($table, 'PPProduktpass_Material', $data);
        $pp->PPProduktpass_Lizenz = $this->setValue($table, 'PPProduktpass_Lizenz', $data);
        $pp->PPProduktpass_Status = $this->setValue($table, 'PPProduktpass_Status', $data);
        $pp->PPProduktpass_PPProjekte_Projekt = $this->setValue($table, 'PPProduktpass_PPProjekte_Projekt', $data);
        $pp->PPProduktpass_AktExcel = $this->setValue($table, 'PPProduktpass_AktExcel', $data);
        $pp->PPProduktpass_VorExcel = $this->setValue($table, 'PPProduktpass_VorExcel', $data);
        $pp->PPProduktpass_Importart = $this->setValue($table, 'PPProduktpass_Importart', $data);
        $pp->PPProduktpass_LieferterminJahr = $this->setValue($table, 'PPProduktpass_LieferterminJahr', $data);
        $pp->PPProduktpass_VorIAN = $this->setValue($table, 'PPProduktpass_VorIAN', $data);
        $pp->PPProduktpass_Konstruktion = $this->setValue($table, 'PPProduktpass_Konstruktion', $data);
        $pp->PPProduktpass_Verarbeitung = $this->setValue($table, 'PPProduktpass_Verarbeitung', $data);
        $pp->PPProduktpass_ZBV1_Name = $this->setValue($table, 'PPProduktpass_ZBV1_Name', $data);
        $pp->PPProduktpass_ZBV1_Wert = $this->setValue($table, 'PPProduktpass_ZBV1_Wert', $data);
        $pp->PPProduktpass_ZBV2_Name = $this->setValue($table, 'PPProduktpass_ZBV2_Name', $data);
        $pp->PPProduktpass_ZBV2_Wert = $this->setValue($table, 'PPProduktpass_ZBV2_Wert', $data);
        $pp->PPProduktpass_ZBV3_Name = $this->setValue($table, 'PPProduktpass_ZBV3_Name', $data);
        $pp->PPProduktpass_ZBV3_Wert = $this->setValue($table, 'PPProduktpass_ZBV3_Wert', $data);
        $pp->PPProduktpass_ZBV4_Name = $this->setValue($table, 'PPProduktpass_ZBV4_Name', $data);
        $pp->PPProduktpass_ZBV4_Wert = $this->setValue($table, 'PPProduktpass_ZBV4_Wert', $data);
        $pp->PPProduktpass_ZBV5_Name = $this->setValue($table, 'PPProduktpass_ZBV5_Name', $data);
        $pp->PPProduktpass_ZBV5_Wert = $this->setValue($table, 'PPProduktpass_ZBV5_Wert', $data);
        $pp->PPProduktpass_Produkt_ZusatzGSM = $this->setValue($table, 'PPProduktpass_Produkt_ZusatzGSM', $data);
        $pp->PPProduktpass_Produkt_Laenge = $this->setValue($table, 'PPProduktpass_Produkt_Laenge', $data);
        $pp->PPProduktpass_Produkt_Breite = $this->setValue($table, 'PPProduktpass_Produkt_Breite', $data);
        $pp->PPProduktpass_Produkt_Hoehe = $this->setValue($table, 'PPProduktpass_Produkt_Hoehe', $data);
        $pp->PPProduktpass_Produkt_GSM = $this->setValue($table, 'PPProduktpass_Produkt_GSM', $data);
        $pp->PPProduktpass_WAWIArtikelnummer = $this->setValue($table, 'PPProduktpass_WAWIArtikelnummer', $data);
        $pp->PPProduktpass_Kommentar = $this->setValue($table, 'PPProduktpass_Kommentar', $data);
        $pp->PPProduktpass_PMAdmin = $this->setValue($table, 'PPProduktpass_PMAdmin', $data);
        $pp->PPProduktpass_RevisionVon_PPProduktpass_Id = $pprevid;
        $pp->PPProduktpass_Revisionsnummer = $prev_revno;
        $pp->PPProduktpass_IsRevision = 1;
        //$pp->PPProduktpass_IsRevision = $this->setValue($table, 'PPProduktpass_IsRevision', $data); 
        //$pp->PPProduktpass_RevisionArt = $this->setValue($table, 'PPProduktpass_RevisionArt', $data); 
        //$pp->PPProduktpass_Revisionsnummer = $this->setValue($table, 'PPProduktpass_Revisionsnummer', $data); 
        //$pp->PPProduktpass_RevisionAktuell = $this->setValue($table, 'PPProduktpass_RevisionAktuell', $data); 
        //$pp->PPProduktpass_RevisionVon_PPProduktpass_Id = $this->setValue($table, 'PPProduktpass_RevisionVon_PPProduktpass_Id', $data); 
        $pp->PPProduktpass_RevisionDatum = $this->setValue($table, 'PPProduktpass_RevisionDatum', $data);
        $pp->PPProduktpass_ProjektBild = $this->setValue($table, 'PPProduktpass_ProjektBild', $data);
        $pp->PPProduktpass_VersandfaehigeUmverpackung = $this->setValue($table, 'PPProduktpass_VersandfaehigeUmverpackung', $data);
        $pp->PPProduktpass_RFSicherung = $this->setValue($table, 'PPProduktpass_RFSicherung', $data);
        $pp->PPProduktpass_Passformlabel = $this->setValue($table, 'PPProduktpass_Passformlabel', $data);
        $pp->PPProduktpass_AndereTestkriterien = $this->setValue($table, 'PPProduktpass_AndereTestkriterien', $data);
        $pp->PPProduktpass_ZertifizierungEigenschaften2 = $this->setValue($table, 'PPProduktpass_ZertifizierungEigenschaften2', $data);
        $pp->PPProduktpass_GarantiezeitDauer = $this->setValue($table, 'PPProduktpass_GarantiezeitDauer', $data);
        $pp->PPProduktpass_GarentieArt = $this->setValue($table, 'PPProduktpass_GarentieArt', $data);
        $pp->PPProduktpass_LogoDruckverfahren = $this->setValue($table, 'PPProduktpass_LogoDruckverfahren', $data);
        $pp->PPProduktpass_Import_BISUser_Id = $this->setValue($table, 'PPProduktpass_Import_BISUser_Id', $data);
        $pp->PPProduktpass_Import_Datum = $this->setValue($table, 'PPProduktpass_Import_Datum', $data);
        $pp->PPProduktpass_Logos2 = $this->setValue($table, 'PPProduktpass_Logos2', $data);
        $pp->PPProduktpass_Logos3 = $this->setValue($table, 'PPProduktpass_Logos3', $data);
        $pp->PPProduktpass_Positionierung = $this->setValue($table, 'PPProduktpass_Positionierung', $data);
        $pp->PPProduktpass_ZertifizierungEigenschaften3 = $this->setValue($table, 'PPProduktpass_ZertifizierungEigenschaften3', $data);
        $pp->PPProduktpass_ZertifizierungEigenschaften4 = $this->setValue($table, 'PPProduktpass_ZertifizierungEigenschaften4', $data);
        $pp->PPProduktpass_ZertifizierungEigenschaften5 = $this->setValue($table, 'PPProduktpass_ZertifizierungEigenschaften5', $data);
        $pp->PPProduktpass_Logos4 = $this->setValue($table, 'PPProduktpass_Logos4', $data);
        $pp->PPProduktpass_Logos5 = $this->setValue($table, 'PPProduktpass_Logos5', $data);
        $pp->PPProduktpass_Bemerkung = $this->setValue($table, 'PPProduktpass_Bemerkung', $data);
        $pp->PPProduktpass_Charge = $this->setValue($table, 'PPProduktpass_Charge', $data);
        $pp->PPProduktpass_AltCharge = $this->setValue($table, 'PPProduktpass_AltCharge', $data);
        $pp->PPProduktpass_KAT = $this->setValue($table, 'PPProduktpass_KAT', $data);
        $pp->PPProduktpass_BZP = $this->setValue($table, 'PPProduktpass_BZP', $data);
        $pp->PPProduktpass_MOQ = $this->setValue($table, 'PPProduktpass_MOQ', $data);
        $pp->PPProduktpass_InitialeCharge = $this->setValue($table, 'PPProduktpass_InitialeCharge', $data);
        $pp->PPProduktpass_Erstbestellung = $this->setValue($table, 'PPProduktpass_Erstbestellung', $data);
        $pp->PPProduktpass_IsInquiry = $this->setValue($table, 'PPProduktpass_IsInquiry', $data);
        $pp->PPProduktpass_InquiryArt = $this->setValue($table, 'PPProduktpass_InquiryArt', $data);
        $pp->PPProduktpass_StepNeeded = $this->setValue($table, 'PPProduktpass_StepNeeded', $data);
        $pp->PPProduktpass_BSCINeeded = $this->setValue($table, 'PPProduktpass_BSCINeeded', $data);
        $pp->PPProduktpass_IsMusterung = $this->setValue($table, 'PPProduktpass_IsMusterung', $data);
        $pp->PPProduktpass_GreenLevel = $this->setValue($table, 'PPProduktpass_GreenLevel', $data);
        $pp->PPProduktpass_KauflandMarke = $this->setValue($table, 'PPProduktpass_KauflandMarke', $data);
        $pp->rfqNo = $this->setValue($table, 'rfqNo', $data);
        $pp->isLatest = $this->setValue($table, 'isLatest', $data);
        $pp->statusDoc = $this->setValue($table, 'statusDoc', $data);
        $pp->updateUserName = $this->setValue($table, 'updateUserName', $data);
        $pp->category = $this->setValue($table, 'category', $data);
        $pp->vendorNo = $this->setValue($table, 'vendorNo', $data);
        //$pp->createdOn = $this->setValue($table, 'createdOn', $data); 
        //$pp->updatedOn = $this->setValue($table, 'updatedOn', $data); 
        $pp->expiryDate = $this->setValue($table, 'expiryDate', $data);
        $pp->versionDoc = $this->setValue($table, 'versionDoc', $data);
        $pp->angebotsnummerPraefix = $this->setValue($table, 'angebotsnummerPraefix', $data);
        $pp->createUserName = $this->setValue($table, 'createUserName', $data);
        $pp->version = $this->setValue($table, 'version', $data);
        $pp->retailPackagingComment = $this->setValue($table, 'retailPackagingComment', $data);
        $pp->Garantie = $this->setValue($table, 'Garantie', $data);
        $pp->rfSafety = $this->setValue($table, 'rfSafety', $data);
        $pp->packagingKL_materialThickness = $this->setValue($table, 'packagingKL_materialThickness', $data);
        $pp->packagingKL_retailPackagingComment = $this->setValue($table, 'packagingKL_retailPackagingComment', $data);
        $pp->packagingKL_trayRemarks = $this->setValue($table, 'packagingKL_trayRemarks', $data);
        $pp->packagingKL_rt_name = $this->setValue($table, 'packagingKL_rt_name', $data);
        $pp->packagingKL_tray_name = $this->setValue($table, 'packagingKL_tray_name', $data);
        $pp->isCatalogue = $this->setValue($table, 'isCatalogue', $data);
        $pp->initialOrder = $this->setValue($table, 'initialOrder', $data);
        $pp->brandKL = $this->setValue($table, 'brandKL', $data);
        $pp->sampleNumberKL = $this->setValue($table, 'sampleNumberKL', $data);
        $pp->buyerShortCodeKL = $this->setValue($table, 'buyerShortCodeKL', $data);
        $pp->buyerNameKL = $this->setValue($table, 'buyerNameKL', $data);
        $pp->themeNoKL = $this->setValue($table, 'themeNoKL', $data);
        $pp->noLIDLItem = $this->setValue($table, 'noLIDLItem', $data);
        $pp->Abwicklungsart = $this->setValue($table, 'Abwicklungsart', $data);
        $pp->InternerStatus = $this->setValue($table, 'InternerStatus', $data);
        $pp->LinkedItemIAN = $this->setValue($table, 'LinkedItemIAN', $data);
        $pp->PPProduktpass_PMAdmin = $this->getAdmin('PM');
        $pp->PPProduktpass_PJMAdmin = $this->getAdmin('PJM');
        $pp->PPProduktpass_TCAdmin = $this->getAdmin('TC');
        $pp->PPProduktpass_ThemaRequierdSamples = $this->setValue($table, 'PPProduktpass_ThemaRequierdSamples', $data);
        $pp->PPProduktpass_ThemaKolli = $this->setValue($table, 'PPProduktpass_ThemaKolli', $data);
        $pp->PPProduktpass_ThemaAssortment = $this->setValue($table, 'PPProduktpass_ThemaAssortment', $data);
        $pp->PPProduktpass_ThemaWarranty = $this->setValue($table, 'PPProduktpass_ThemaWarranty', $data);
        $pp->PPProduktpass_ThemaRisc = $this->setValue($table, 'PPProduktpass_ThemaRisc', $data);
        $pp->PPProduktpass_ThemaCerificates = $this->setValue($table, 'PPProduktpass_ThemaCerificates', $data);
        $pp->PPProduktpass_ThemaScope = $this->setValue($table, 'PPProduktpass_ThemaScope', $data);
        //$pp->PPProduktpass_PMAdmin = $this->setValue($table, 'PPProduktpass_PMAdmin', $data); 
        //$pp->PPProduktpass_TCAdmin = $this->setValue($table, 'PPProduktpass_TCAdmin', $data);
        $pp->save();
        $this->handleOldData($pp->PPProduktpass_Id, $pprevid);
        return array('result' => true, 'ppid' => $pp->PPProduktpass_Id);
    }
    private function getAdmin($art)
    {
        $ma = PPMitarbeiter::where('PPMitarbeiter_Role', 'like', '%Thmenplan%')->where('PPMitarbeiter_Taetigkeit', $art)->where('PPMitarbeiter_isDefault', 1)->where('isMaster', 1)->orderby('PPMitarbeiter_Id', 'desc')->get()->first();
        if ($ma) {
            return $ma->PPMitarbeiter_Id;
        }
        if ($art == 'PM') {
            return 1275;
        }
        if ($art == 'PJM') {
            return 1353;
        }
        if ($art == 'TC') {
            return 1003;
        }
    }
    private function handleOldData($ppid, $pprevid)
    {
        if (PPInputManuell::where('PPInputmanuell_PPProduktpass_Id', $pprevid)->exists()) {
            $ppis = PPInputManuell::where('PPInputmanuell_PPProduktpass_Id', $pprevid)->get();
            foreach ($ppis as $ppi) {
                $ppi->PPInputManuell_PPProduktpass_Id = $ppid;
                $ppi->save();
            }
        }
        if (PPTermine::where('PPTermine_PPProduktpass_Id', $pprevid)->exists()) {
            $values = PPTermine::where('PPTermine_PPProduktpass_Id', $pprevid)->get();
            foreach ($values as $value) {
                $value->PPTermine_PPProduktpass_Id = $ppid;
                $value->save();
            }
        }
        if (PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $pprevid)->exists()) {
            $values = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $pprevid)->get();
            foreach ($values as $value) {
                $value->PPPPFiles_PPProduktpass_Id = $ppid;
                $value->save();
            }
        }
    }
    private function newPPProduktpass_Sortierung($id)
    {
        PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $id)->delete();
        $new_record = new PPProduktpass_Sortierung();
        $new_record->PPProduktpass_Sortierung_PPProduktpass_Id = $id;
        $new_record->save();
    }
    private function newPPProduktpass_Qualitaet($id)
    {
        PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', $id)->delete();
        $new_record = new PPProduktpass_Qualitaet();
        $new_record->PPProduktpass_Qualitaet_PPProduktpass_Id = $id;
        $new_record->save();
    }
    private function newPPProduktpass_Menge($id)
    {
        PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', $id)->delete();
        $new_record = new PPProduktpass_Menge();
        $new_record->PPProduktpass_Menge_PPProduktpass_Id = $id;
        $new_record->save();
    }
    private function newPPProduktpass_Style($id)
    {
        PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $id)->delete();
        $new_record = new PPProduktpass_Style();
        $new_record->PPProduktpass_Style_PPProduktpass_Id = $id;
        $new_record->save();
    }
    private function newPPProduktpass_Style_PP($id, $pp)
    {
        PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $id)->delete();
        $style = new PPProduktpass_Style();
        $style->PPProduktpass_Style_PPProduktpass_Id = $id;
        $style->PPProduktpass_Style_Header = $pp['PPProduktpass_IAN'] . '_X';
        $style->PPProduktpass_Style_Value01 = '';
        $style->PPProduktpass_Style_Value02 = '';
        $style->PPProduktpass_Style_Value03 = '';
        $style->PPProduktpass_Style_Value04 = '';
        $style->PPProduktpass_Style_Value05 = '';
        $style->PPProduktpass_Style_PPPPFiles_Id = '';
        $style->PPProduktpass_Style_LidlID = '';
        $style->PPProduktpass_Style_Zolltarifnummer = '';
        $style->PPProduktpass_Style_Value01_Translation = '';
        $style->PPProduktpass_Style_Value02_Translation = '';
        $style->PPProduktpass_Style_Value03_Translation = '';
        $style->PPProduktpass_Style_Value04_Translation = '';
        $style->PPProduktpass_Style_Value05_Translation = '';
        $style->productName = '';
        $style->styleNo = $pp['PPProduktpass_IAN'] . '_X';
        $style->uniqueId = '';
        $style->vendorUniqueId = '';
        $style->color = $pp['style@color'];
        $style->internalSeqNo = '';
        $style->material = '';
        $style->notOrderable = '';
        $style->qualityTechnicalData = $pp['style@Qualität'];
        $style->sizeWithoutPackaging = '';
        $style->weightWithoutPackaging = '';
        $style->additionalQualityInformation = '';
        $style->changesFromPredecessor = $pp['style@changesFromPredecessor'];
        $style->brandReference = $pp['style@Markenreferenz'];
        $style->materialThickness = '';
        $style->save();
    }
    private function newPPPurchase($id)
    {
        PPPurchase::where('PPPurchase_PPProduktpass_Id', $id)->delete();
        $new_record = new PPPurchase();
        $new_record->PPPurchase_PPProduktpass_Id = $id;
        $new_record->save();
    }
    public function newTermine($id, $setPMAdmin = true)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', $id)->get()->first();
        if ($pp) {
            $prev_ppid = $pp->PPProduktpass_RevisionVon_PPProduktpass_Id;
            if ($prev_ppid > 0) {
                $this->copyTermine($prev_ppid, $pp->PPProduktpass_Id);
                return true;
            }
        } else {
            //echo("Produktpass mit Id: $id nicht gefunden!");
            return false;
        }
        $spalten = PPBoardSpalteData::where("PPBoardSpalte_Id", ">=", 1000)->get();
        $pm = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'PM')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
        $tc = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'TC')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $vorgaben = PPBatchtermine::where('PPBatchtermine_Ausmusterung', $ausm)->get();
        $aVorgaben = array();
        if ($vorgaben) {
            foreach ($vorgaben as $vorgabe) {
                $aVorgaben[$vorgabe->PPBatchtermine_PPBoardSpalte_Id] = $vorgabe->PPBatchtermine_Termin;
            }
        }
        //cpcDebug::cpc_debug($vorgaben,"TERMINE");
        if ($pp) {
            if ($setPMAdmin) {
                $pp->PPProduktpass_PMAdmin = $pm->PPMitarbeiter_Id;
            } else {
                $pm = $pp->PPProduktpass_PMAdmin;
            }
            $pp->PPProduktpass_TCAdmin = $tc->PPMitarbeiter_Id;
            $pp->save();
        }
        foreach ($spalten as $spalte) {
            $termin                             = new PPTermine();
            $termin->PPTermine_PPProduktpass_Id = $id;
            //$termin->PPTermine_Header = "H".$i;
            $termin->PPTermine_Status           = "Neu";
            $termin->PPTermine_PPBoardSpalte_id = $spalte->PPBoardSpalte_Id;
            if (strpos($spalte->PPBoardSpalteData_Kind, "PM") !== false && ! $setPMAdmin) {
                $termin->PPTermine_MAZustaendigkeit = $pp->PPProduktpass_PMAdmin;
            } else {
                $termin->PPTermine_MAZustaendigkeit = $spalte->PPBoardSpalte_DefaultMA;
            }
            //$termin->PPTermine_DatumStart = '2024-05-26';
            if (isset($aVorgaben[$spalte->PPBoardSpalte_Id]) and ! is_null($aVorgaben[$spalte->PPBoardSpalte_Id])) {
                $termin->PPTermine_DatumStart = $aVorgaben[$spalte->PPBoardSpalte_Id];
            }
            $termin->save();
        }
        return true;
    }
    private function getCoordPictures($kind, $header)
    {
        $ret = false;
        try {
            $ret = chr(ord("A") + ($header[$kind]));
        } catch (Exception $ex) {
            //echo("<br>EX: ".$ex->getMessage()."<br>");
        }
        return $ret;
    }
    private function readPictures($row, $id, $ian, $drawings, $header)
    {
        // Moodboard	
        // Themenfarben	
        // Artikel_Farben	
        // Bild	
        // Vertragsfoto
        //var_dump($header); exit;
        $Moodboard =  $this->getCoordPictures('Moodboard', $header);
        $Themenfarben =  $this->getCoordPictures('Themenfarben', $header);
        $Artikel_Farben =  $this->getCoordPictures('Artikel_Farben', $header);
        $Bild = $this->getCoordPictures('Bild', $header);
        $Vertragsfoto =  $this->getCoordPictures('Vertragsfoto', $header);
        //echo(" $Moodboard, $Themenfarben, $Artikel_Farben, $Bild, $Vertragsfoto, "); exit;
        $row++;
        $i = 0;
        $inserted = "";
        foreach ($drawings as $drawing) {
            $i++;
            $coord = $drawing->getCoordinates();
            if (strpos($inserted, $coord) === false) {
                //$inserted .= $coord;
                //Moodboard
                if ($Moodboard and ($coord == $Moodboard . $row)) {
                    //Save Moodboard
                    $imageContents = $this->getDrawing($drawing);
                    $path = public_path() . '/data/uploads/Themenplanung/Bilder/';
                    $myFileName = str_random(6) . '_' . $ian . "_" . $i . '_Moodboard.jpg';
                    file_put_contents($path . $myFileName, $imageContents);
                    $this->saveFile($id, $myFileName, 'Themenplanung/Bilder', 'Artwork', 'CGI');
                }
                //Themenfarben
                if ($Themenfarben and ($coord == $Themenfarben . $row)) {
                    //Save Themenfarben
                    $imageContents = $this->getDrawing($drawing);
                    $path = public_path() . '/data/uploads/Themenplanung/Bilder/';
                    $myFileName = str_random(6) . '_' . $ian . "_" . $i . '_Themenfarben.jpg';
                    file_put_contents($path . $myFileName, $imageContents);
                    $this->saveFile($id, $myFileName, 'Themenplanung/Bilder', 'Artwork', 'CGI');
                }
                //Projektbild
                if ($Vertragsfoto and ($coord == $Vertragsfoto . $row)) {
                    //Save Projektbild
                    $imageContents = $this->getDrawing($drawing);
                    $path = public_path() . '/data/uploads/Themenplanung/Bilder/';
                    $myFileName = str_random(6) . '_' . $ian . "_" . $i . '_Projektbild.jpg';
                    file_put_contents($path . $myFileName, $imageContents);
                    $this->saveFile($id, $myFileName, 'Themenplanung/Bilder', 'Artwork', 'CGI');
                    $pp = tPPProduktpass::find($id);
                    if ($pp) {
                        $pp->PPProduktpass_ProjektBild = '/Themenplanung/Bilder/' . $myFileName;
                        $pp->save();
                    }
                }
                //Zusatzfoto
                if ($Bild and ($coord == $Bild . $row)) {
                    //Save Projektbild
                    $imageContents = $this->getDrawing($drawing);
                    $path = public_path() . '/data/uploads/Themenplanung/Bilder/';
                    $myFileName = str_random(6) . '_' . $ian . "_" . $i . '_Zusatzfoto.jpg';
                    file_put_contents($path . $myFileName, $imageContents);
                    $this->saveFile($id, $myFileName, 'Themenplanung/Bilder', 'Artwork', 'CGI');
                    $pp = tPPProduktpass::find($id);
                    if ($pp) {
                        $pp->PPProduktpass_ProjektBild = '/Themenplanung/Bilder/' . $myFileName;
                        $pp->save();
                    }
                }
                //Artikelfarben
                if ($Artikel_Farben and ($coord == $Artikel_Farben . $row)) {
                    //Save Projektbild
                    $imageContents = $this->getDrawing($drawing);
                    $path = public_path() . '/data/uploads/Themenplanung/Bilder/';
                    $myFileName = str_random(6) . '_' . $ian . "_" . $i . '_Artikelfarben.jpg';
                    file_put_contents($path . $myFileName, $imageContents);
                    $this->saveFile($id, $myFileName, 'Themenplanung/Bilder', 'Artwork', 'CGI');
                    $pp = tPPProduktpass::find($id);
                    if ($pp) {
                        $pp->PPProduktpass_ProjektBild = '/Themenplanung/Bilder/' . $myFileName;
                        $pp->save();
                    }
                }
                //Vertragsfoto
                if ($Vertragsfoto and ($coord == $Vertragsfoto . $row)) {
                    //Save Vertragsbild
                    $imageContents = $this->getDrawing($drawing);
                    $path = public_path() . '/data/uploads/Themenplanung/Bilder/';
                    $myFileName = str_random(6) . '_' . $ian . "_" . $i . '_Vertragsfoto.jpg';
                    file_put_contents($path . $myFileName, $imageContents);
                    $this->saveFile($id, $myFileName, 'Themenplanung/Bilder', 'Artwork', 'CGI');
                }
            }
        }
    }
    public function  showImportThemenplanung()
    {
        $data['content'] = View::make('UploadThemenplanung');
        return View::make('main', $data);
    }
    public function importThemenplanung()
    {
        $fileName = $_FILES['themenplanung']['name'];
        $tmpFileName = $_FILES['themenplanung']['tmp_name'];
        $uploaddir  = public_path() . "/data/uploads/Themenplanung/";
        $uploadfile = str_random(6) . '_' . $fileName;
        if (move_uploaded_file($tmpFileName, $uploaddir . $uploadfile)) {
            echo ($this->readThemenplanung($uploadfile));
            //return Redirect::to('/termine/projekt/U/1001/1');
        } else {
            echo ("Nicht hochgeladen!");
        }
        exit;
    }
    private function normalizeHeader($header)
    {
        $test = trim($header);
        $test = str_replace("\n", " ", $test);
        return $test;
    }
    private function getEndOfWeek($week, $year)
    {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $dto->modify('+6 days');
        return $dto->format('Y-m-d');
    }
    private function getStartOfWeek($week, $year)
    {
        try {
            $dto = new DateTime();
            $dto->setISODate($year, $week);
            $ret = $dto->format('Y-m-d');
        } catch (Exception $ex) {
            echo ("getStartOfWeek: $week $year");
            exit;
        }
        //echo("W: $week Y: $year => $ret <br>");
        return $ret;
    }
    private function DDP2CRD($_ddp)
    {
        //var_dump($ddp);exit;
        try {
            $ddp = new  DateTime($_ddp);
            $ddp->modify('-9 weeks');
            $crd = $ddp->format("Y-m-d");
        } catch (Exception $ex) {
        }
        $week =  $ddp->format('W');
        $year =  $ddp->format('Y');
        //echo( "W: $week Y: $year       DDP: $_ddp => CRD: $crd <br>");
        return array('week' => $week, 'year' => $year);
    }
    private function readThemenplanung($filename)
    {
        $inputFileName = public_path() . '/data/uploads/Themenplanung/' . $filename;
        if (!file_exists($inputFileName)) {
            echo ("Datei $inputFileName nicht gefunden!");
            exit;
        }
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $worksheet =  $spreadsheet->getSheet(0); // $spreadsheet->getActiveSheet();
        $worksheetArray = $worksheet->toArray();
        /*$data_pp_mapping = array(
			1 => 'PPProduktpass_TargaTNr',
			2 => 'PPProduktpass_IAN',
			3 => 'PPProduktpass_Artikelbezeichnung',
			//4 => 'PPProduktpass_Ausmusterungnummer',
			//5 => 'Sortimentsberech',
			//6 => 'PPProduktpass_AltIAN',
			7 => 'Markenreferenz',
			7 => 'isCatalogue',
			8 => 'PPProduktpass_Gesamtmenge',
			4 => 'PPProduktpass_Thema',
			5 => 'PPProduktpass_Einkaeufer',
			6 => 'PPProduktpass_Marke',
			13 => 'PPProduktpass_Bemerkung',
			//14 => 'LinkExtrerneReferenz',
			//15 => 'Moodboard (Bild)',
			//16 => 'Themenfarben (Bild)',
			//17 => 'Themenfarben (Text)',
			//18 => 'Artikelfarben',
			//19 => 'CBX Farbspezifikation',
			//20 => 'Projektbild (Bild)',
			//21 => 'Vetragsbild (Bild)',
			//22 => 'Umsetzung (Ja/Nein)',
			//23 => 'Umsetzung Begründung',
			//24 => 'Vetragsbild (Bild)'
		); */
        $data_pp_mapping = array(
            'TARGA T-Nr.' => 'PPProduktpass_TargaTNr',
            'IAN' => 'PPProduktpass_IAN',
            'Artikel' => 'PPProduktpass_Artikelbezeichnung',
            'Gruppierung' => 'PPProduktpass_Ausmusterungnummer',
            //5 => 'Sortimentsberech',
            'Vorgänger Artikel IAN' => 'PPProduktpass_AltIAN',
            //7 => 'Markenreferenz',
            'Marken' => 'PPProduktpass_Marke',
            'Katalog' => 'isCatalogue',
            'Bestellmenge Plan (in Stk.)' => 'PPProduktpass_Gesamtmenge',
            'Themenbezeichnung' => 'PPProduktpass_Thema',
            'Einkaufsleiter Kürzel' => 'PPProduktpass_Einkaeufer',
            'Bermerkung' => 'PPProduktpass_Bemerkung',
            //14 => 'LinkExtrerneReferenz',
            //15 => 'Moodboard (Bild)',
            //16 => 'Themenfarben (Bild)',
            //17 => 'Themenfarben (Text)',
            //18 => 'Artikelfarben',
            //19 => 'CBX Farbspezifikation',
            //20 => 'Projektbild (Bild)',
            //21 => 'Vetragsbild (Bild)',
            //22 => 'Umsetzung (Ja/Nein)',
            //23 => 'Umsetzung Begründung',
            //24 => 'Vetragsbild (Bild)',
            'Markenreferenz' => 'style@Markenreferenz',
            'Qualitäten' => 'style@Qualität',
            'PM' => 'PPProduktpass_PMAdmin',
            'Kommentar' => 'PPProduktpass_Kommentar',
            'Muster benötigt' => 'PPProduktpass_ThemaRequierdSamples',
            'Kolliinhalt' => 'PPProduktpass_ThemaKolli',
            'Sortierung' => 'PPProduktpass_ThemaAssortment',
            'Garantie' => 'PPProduktpass_ThemaWarranty',
            'Risiko' => 'PPProduktpass_ThemaRisc',
            'Zertifizierung' => 'PPProduktpass_ThemaCerificates',
            'Bereich' => 'PPProduktpass_ThemaScope',
            'Anpassungen zum VG' => 'style@changesFromPredecessor',
            'CBX Farbspezifikation' => 'style@color'
        );
        $headers =  $worksheetArray[0];
        $a = array();
        $a_reverse = array();
        foreach ($headers as  $col => $value) {
            $value = $this->normalizeHeader($value);
            $a[$col] = $value;
            $a_reverse[$value] = $col;
        }
        //echo("<pre>");print_r($a_reverse);exit;
        foreach ($worksheetArray as $row => $cols) {
            if ($row > 0) {
                $data_pp_values[$row] = array();
                foreach ($cols as $col => $value) {
                    //echo ("<div style='border:1px solid blue;height:30px;'>[$row , $col]</div><div style='height:30px;overflow:hidden;border:1px solid dodgerblue;'>".print_r($value,true)."</div>");
                    if (isset($data_pp_mapping[$a[$col]])) {
                        $data_pp_values[$row][$data_pp_mapping[$a[$col]]] = "$value";
                    }
                }
                //Felder die vom System aus benötigt werden
                $data_pp_values[$row]['InternerStatus'] = "MUSTERUNG";
                $data_pp_values[$row]['PPProduktpass_Status'] = "Neu";
                $data_pp_values[$row]['PPProduktpass_PPProjekte_Projekt'] = $data_pp_values[$row]['PPProduktpass_IAN'];
                $pm = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'PM')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
                $pjm = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'PJM')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
                $tc = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'TC')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
                $data_pp_values[$row]['PPProduktpass_PMAdmin'] =  $pm->PPMitarbeiter_Id;
                $data_pp_values[$row]['PPProduktpass_PJMAdmin'] = $pjm->PPMitarbeiter_Id;
                $data_pp_values[$row]['PPProduktpass_TCAdmin'] =  $tc->PPMitarbeiter_Id;
                $data_pp_values[$row]['PPProduktpass_Import_Datum'] = date('Y-m-d H:i:s');
                $data_pp_values[$row]['PPProduktpass_RevisionDatum'] = date('Y-m-d H:i:s');
                $year = 2999;
                $am = $data_pp_values[$row]['PPProduktpass_Ausmusterungnummer'];
                $year = substr($am, 3, 4);
                if (substr($am, 8, 2) != '01') {
                    $year++;
                }
                $cw = 99;
                //echo($data_pp_values[$row]['PPProduktpass_Thema']." =>  ");
                if (isset($data_pp_values[$row]['PPProduktpass_Thema'])) {
                    if (strlen($data_pp_values[$row]['PPProduktpass_Thema']) >= 2) {
                        $cw = substr($data_pp_values[$row]['PPProduktpass_Thema'], 0, 2);
                    }
                }
                $ddp = $this->getStartOfWeek($cw, $year);
                $crd = $this->DDP2CRD($ddp);
                //var_dump($crd); exit;
                //echo(" KW: $cw / $year <br>");
                $data_pp_values[$row]['PPProduktpass_Liefertermin'] = $crd['week'];
                $data_pp_values[$row]['PPProduktpass_LieferterminJahr'] = $crd['year'];
                $data_pp_values[$row]['PPProduktpass_Verpackungseinheit'] = 1;
                $data_pp_values[$row]['PPProduktpass_Import_BISUser_Id'] = Auth::getUser()->id;
            }
        }
        //echo("<pre>");		print_r($data_pp_values);		exit;
        $ianArray = array();
        $message = "<div style='height:800px;overflow:auto;text-align:left;font-family:Arial;font-size:0.9em;margin:50px;padding:20px;border:1px solid darkblue;'><a href='https://tpt-dev.ad.targa.de/termine/projekt/U/1001/1'>zum Dashboard Musterung</a><br><br><table style='font-size:12px;border-collapse:collapse;'><tr style='background-color:lightgray;'><th  style='border:1px solid gray;padding:5px;'>IAN</th><th  style='border:1px solid gray;padding:5px;'>Charge</th><th  style='border:1px solid gray;padding:5px;'>Status</th></tr>";
        foreach ($data_pp_values as $row => $pp) {
            if (isset($pp['PPProduktpass_IAN']) and  (strlen(trim($pp['PPProduktpass_IAN'])) == 6)) {
                $new =  $this->newPProduktpass($pp);
                if ($new['result']) {
                    $ppid = $new['ppid'];
                } else {
                    $ppid = 0;
                }
                $message .= '<tr>';
                $message .= '<td style="border:1px solid lightgray;padding:8px;"><a href="https://' .  $_SERVER['SERVER_NAME'] . '/show/' . $new['ppid'] . '" target="_blank">' . $pp['PPProduktpass_IAN'] . '</a></td>';
                $message .= '<td style="border:1px solid lightgray;padding:8px;">' . $data_pp_values[$row]['PPProduktpass_Ausmusterungnummer'] . '</td>';
                if ($ppid > 0) {
                    $ianArray[$pp['PPProduktpass_IAN']] = $ppid;
                    $this->newPPProduktpass_Sortierung($ppid);
                    $this->newPPProduktpass_Qualitaet($ppid);
                    //Änderung Qualitäten aus Spalte J
                    //$this->newPPProduktpass_Style($ppid);
                    $this->newPPProduktpass_Style_PP($ppid, $pp);
                    $this->newPPProduktpass_Menge($ppid);
                    $this->newPPPurchase($ppid);
                    $projektbild = $this->readPictures($row, $ppid, $pp['PPProduktpass_IAN'], $worksheet->getDrawingCollection(), $a_reverse);
                    if (!$this->newTermine($ppid, false)) {
                        $message .= '<td style="border:1px solid lightgray;padding:8px;color:red;">' . 'Termine nicht angelegt' . '</td>';
                    };
                    //Bilder einlesen
                    $message .= "<td  style='border:1px solid lightgray;padding:8px;color:green;'>" . 'angelegt' . '</td>';
                } else {
                    $message .= '<td style="border:1px solid lightgray;padding:8px;color:red;">' . 'nicht angelegt. (IAN existiert!)' . '</td>';
                }
                $message .= '</tr>';
            }
        }
        $message .= '</table></div>';
        return $message;
    }
    function importExcel($file, $def = 1, $id)
    {
        //READER
        //cpcDebug::cpc_debug("Start");
        //cpcDebug::cpc_debug("	file: ".$file);
        //cpcDebug::cpc_debug("	def: ".$def);
        //cpcDebug::cpc_debug("	id: ".$id);
        $inputFileName = storage_path() . "/data/" . $file;
        //if (!file_exists($inputFileName) )	cpcDebug::cpc_debug("	ERROR: ".$inputFileName." existiert nicht!");		
        $inputFileType = 'Excel2007';
        //$inputFileType = 'Excel5';
        //	$inputFileType = 'Excel2003XML';
        //	$inputFileType = 'OOCalc';
        //	$inputFileType = 'Gnumeric';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        //$objReader -> setReadDataOnly(false);
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetNames = $objPHPExcel->getSheetNames();
        //echo("</pre>");var_dump($sheetNames);echo("</pre>"); 
        //foreach($sheetNames as $sheetIndex => $sheetName) {
        //	echo("</pre>");var_dump($objPHPExcel->getSheetByName($sheetName)->getMergeCells());echo("</pre>"); 
        //}
        //exit;
        $def = new ExcelDefinitions($def);
        $def->doPrint();
        $sheetName = $def->getSheetname();
        $table = $def->getTable();
        $startrow = $def->getStartrow();
        $endrow = $def->getEndrow();
        //cpcDebug::cpc_debug("Sheetname = ".$sheetName." table = ".$table." Startrow = ".$startrow." Endrow = ".$endrow);
        //echo("</pre>");var_dump($def);echo("</pre>");exit; 
        //foreach ($def->getRowDef() as $cell => $field) {
        //	echo("  Field: $field  Cell: $cell <br>");
        //}
        $sheet = $objPHPExcel->getSheetByName($sheetName);
        $sheeta = $sheet->toArray(null, true, true, true);
        //if ($sheetName == "Menge") {echo("AUSGABE:<br><pre>");var_dump($sheet);echo("</pre>");exit;}
        //$db = new cpcDB();
        if ($def->isRowMode()) {
            $cmds = array();
            foreach ($sheeta as $row => $cols) {
                $sql = array();
                $hasValues = false;
                foreach ($cols as $col => $value) {
                    if ($row >= $startrow && $row <= $endrow) {
                        $cellxy = $col . $row;
                        $cell = $sheet->getCell($cellxy);
                        //echo("Type: ".$cell->getDataType()."<br>");
                        $attr = $def->getField($col);
                        if ($attr) {
                            //echo (" $cellxy ".$attr." Value: ".$value."<br>");
                            if (!isset($value)) {
                                $value = $def->getMergedCellValue($cell, $sheet, $cellxy);
                            }
                            if ($cell->getDataType() == "n") $value = str_replace(",", "", $value);
                            //echo("value: ".$value."<br>");
                            //	if ($value != '') $sql[] = $attr ." = '".$value."' ";
                            if ($value != '') {
                                $sql[$attr] = $value;
                            }
                        }
                        if (isset($value)) {
                            $hasValues = True;
                        }
                    }
                }
                //cpcDebug::cpc_debug("SQL:".print_r($sql,true));
                if ($hasValues)    $cmds[] = $sql;
            }
            /*				$id_str = "";
						if ($id != 0) $id_str = "PPProduktpass_Menge_PPProduktpass_Id = ".$id. ", ";
						$s = "";
						foreach ($cmds as $cmd) {
							for ($i=0; $i < count($cmd); $i++) {
									if ($i==0) {
										$s = " INSERT INTO ".$table. " SET " .$id_str .$cmd[$i];
									} else {
										$s .= ", ".$cmd[$i];
									}
							}
							//echo ($s."<br>");
							//$db->query($s);	
							DB::select( DB::raw($s) );
							$ppMenge = PPProduktpass_Menge::create ();
							//cpcDebug::cpc_debug("	**** cmd ".$s);
						}
		*/
            foreach ($cmds as $cmd) {
                if ($id != 0) $cmd['PPProduktpass_Menge_PPProduktpass_Id']  = $id;
                //cpcDebug::cpc_debug("cmd: ".print_r($cmd,true));
                $ppMenge = PPProduktpass_Menge::create($cmd);
            }
        }
        if ($def->isFieldsMode()) {
            $table = $def->getTable();
            //cpcDebug::cpc_debug("  Fieldmode");
            $cmd = array();
            foreach ($def->getFieldDef() as $fielddef) {
                //echo("<br>*************************<br>");print_r($def);echo("<br>*************************<br>");
                $sheet = $objPHPExcel->getSheetByName($fielddef['sheet']);
                $sheeta = $sheet->toArray(null, true, true, true);
                $cellxy = $fielddef['col'] . $fielddef['row'];
                $cell = $sheet->getCell($cellxy)->getCalculatedValue();
                //echo("Type: ".$cell->getDataType()."<br>");
                if ($cell != '') $cmd[trim($fielddef['field'])] = "$cell";
            }
            $s = "";
            /*for ($i=0; $i < count($cmds); $i++) {
					if ($i==0) {
						$s = " INSERT INTO ".$table. " SET "  .$cmds[$i];
					} else {
						$s .= ", ".$cmds[$i];
					}
				}*/
            //$id = $db->query($s);
            //DB::select( DB::raw($s) );
            $pp = PPProduktpass::create($cmd);
            //$pp = PPProduktpass::find ($pp->PPProduktpass_Id);
            //$pp->fillPP($cmd);
            //$pp->save();
            return ($pp->PPProduktpass_Id);
        }
    }
    function fromXLS()
    {
        $file = Session::get('xFile');
        echo ('<pre>');
        var_dump(Session::all());
        echo ('</pre>');
        exit;
        $id = $this->importExcel($file, 3, 0);
        $this->importExcel($file, 1, $id);
        $data['content'] = "Erfolgreich importiert!";
        return View::make('main', $data);
    }
    /*function getRecordSet($cmd="") {
			$db = new cpcDB();
			return $db->getRow($cmd);
		}*/
    private function copyTermine($altid, $neuid)
    {
        $termine = PPTermine::where('PPTermine_PPProduktpass_Id', $altid)->get();
        foreach ($termine as $termin) {
            $termin->PPTermine_PPProduktpass_Id = $neuid;
            $termin->save();
        }
    }
    private function writeStyle($ppid, $styleChar, $objPHPExcel, $transAll)
    {
        //cpcDebug::pe(DB::getQueryLog());
        $styleSearch = '%' . $styleChar;
        $styleDataExists = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->exists();
        if ($styleDataExists === false) {
            //cpcDebug::cpc_debug("Style $styleChar ausgeblendet",'@DBExcel');
            $objPHPExcel->getSheetByName("Style $styleChar")->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
            return;
        }
        //cpcDebug::cpc_debug("Style $styleChar eingeblendet",'@DBExcel');
        $styleData = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->get()->first();
        $trans = $transAll['Styles'];
        $objPHPExcel->setActiveSheetIndexByName("Style $styleChar");
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $coord['weightWithoutPackaging'] = $this->getCellA(2, 4);
        $coord['sizeWithoutPackaging'] = $this->getCellA(2, 5);
        $coord['qualityTechnicalData'] = $this->getCellA(2, 6);
        /// DoppleZeile
        $coord['additionalQualityInformation'] = $this->getCellA(2, 8);
        $coord['changesFromPredecessor'] = $this->getCellA(2, 9);
        $coord['brandReference'] = $this->getCellA(2, 10);
        $coord['material'] = $this->getCellA(2, 11);
        $coord['materialThickness'] = $this->getCellA(2, 12);
        $coord['color'] = $this->getCellA(2, 13);
        foreach ($coord as $att => $cell) {
            $this->worksheet->setCellValue($cell['Cell'], $trans[$styleData->PPProduktpass_Style_Header][$att]['EN']);
        }
        /*$this->worksheet->setCellValue($coord['StyleSize']['Cell'],$styleData->sizeWithoutPackaging);
		$this->worksheet->setCellValue($coord['StyleQuality']['Cell'],$styleData->qualityTechnicalData);
		$this->worksheet->setCellValue($coord['StyleQualityAdd']['Cell'],$styleData->additionalQualityInformation);
		$this->worksheet->setCellValue($coord['StyleChanges']['Cell'],$styleData->changesFromPredecessor);
		$this->worksheet->setCellValue($coord['StyleBrandRef']['Cell'],$styleData->brandReference);
		$this->worksheet->setCellValue($coord['StyleMaterial']['Cell'],$styleData->material);
		$this->worksheet->setCellValue($coord['StyleMaterialThickness']['Cell'],$styleData->materialThickness);
		$this->worksheet->setCellValue($coord['StyleColor']['Cell'],$styleData->color);*/
        $pp = tPPProduktpass::find($ppid);
        if ($pp === null) {
            //cpcDebug::p('Keine Daten '." P: $ppid Style: $styleChar <br> ");
            //cpcDebug::p(DB::getQueryLog());
            return;
        }
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 3), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
    }
    private function writeStyle2533($ppid, $styleChar, $objPHPExcel, $transAll)
    {
        //cpcDebug::pe(DB::getQueryLog());
        $styleSearch = '%' . $styleChar;
        $styleDataExists = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->exists();
        if ($styleDataExists === false) {
            //cpcDebug::cpc_debug("Style $styleChar ausgeblendet",'@DBExcel');
            $objPHPExcel->getSheetByName("Style $styleChar")->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
            return;
        }
        //cpcDebug::cpc_debug("Style $styleChar eingeblendet",'@DBExcel');
        $styleData = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->get()->first();
        $trans = $transAll['Styles'];
        $objPHPExcel->setActiveSheetIndexByName("Style $styleChar");
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $coord['weightWithoutPackaging'] = $this->getCellA(2, 4);
        $coord['sizeWithoutPackaging'] = $this->getCellA(2, 5);
        $coord['qualityTechnicalData'] = $this->getCellA(2, 6);
        /// DoppleZeile
        $coord['additionalQualityInformation'] = $this->getCellA(2, 8);
        $coord['changesFromPredecessor'] = $this->getCellA(2, 9);
        $coord['brandReference'] = $this->getCellA(2, 10);
        $coord['material'] = $this->getCellA(2, 11);
        $coord['materialThickness'] = $this->getCellA(2, 12);
        $coord['color'] = $this->getCellA(2, 13);
        foreach ($coord as $att => $cell) {
            $this->setCellValueAndHight($cell['Cell'], $trans[$styleData->PPProduktpass_Style_Header][$att]['EN']);
        }
        /*$this->worksheet->setCellValue($coord['StyleSize']['Cell'],$styleData->sizeWithoutPackaging);
		$this->worksheet->setCellValue($coord['StyleQuality']['Cell'],$styleData->qualityTechnicalData);
		$this->worksheet->setCellValue($coord['StyleQualityAdd']['Cell'],$styleData->additionalQualityInformation);
		$this->worksheet->setCellValue($coord['StyleChanges']['Cell'],$styleData->changesFromPredecessor);
		$this->worksheet->setCellValue($coord['StyleBrandRef']['Cell'],$styleData->brandReference);
		$this->worksheet->setCellValue($coord['StyleMaterial']['Cell'],$styleData->material);
		$this->worksheet->setCellValue($coord['StyleMaterialThickness']['Cell'],$styleData->materialThickness);
		$this->worksheet->setCellValue($coord['StyleColor']['Cell'],$styleData->color);*/
        $pp = tPPProduktpass::find($ppid);
        if ($pp === null) {
            //cpcDebug::p('Keine Daten '." P: $ppid Style: $styleChar <br> ");
            //cpcDebug::p(DB::getQueryLog());
            return;
        }
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 3), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
    }
    private function writeStyle2546($ppid, $styleChar, $objPHPExcel, $transAll)
    {
        //cpcDebug::pe(DB::getQueryLog());
        $styleSearch = '%' . $styleChar;
        $styleDataExists = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->exists();
        if ($styleDataExists === false) {
            //cpcDebug::cpc_debug("Style $styleChar ausgeblendet",'@DBExcel');
            $objPHPExcel->getSheetByName("Style $styleChar")->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
            return;
        }
        //cpcDebug::cpc_debug("Style $styleChar eingeblendet",'@DBExcel');
        $styleData = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->get()->first();
        $trans = $transAll['Styles'];
        $objPHPExcel->setActiveSheetIndexByName("Style $styleChar");
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $coord['weightWithoutPackaging'] = $this->getCellA(2, 4);
        $coord['sizeWithoutPackaging'] = $this->getCellA(2, 5);
        $coord['qualityTechnicalData'] = $this->getCellA(2, 6);
        /// DoppleZeile
        $coord['additionalQualityInformation'] = $this->getCellA(2, 8);
        $coord['changesFromPredecessor'] = $this->getCellA(2, 9);
        $coord['brandReference'] = $this->getCellA(2, 10);
        $coord['material'] = $this->getCellA(2, 11);
        $coord['materialThickness'] = $this->getCellA(2, 12);
        $coord['color'] = $this->getCellA(2, 13);
        foreach ($coord as $att => $cell) {
            $this->setCellValueAndHight($cell['Cell'], $trans[$styleData->PPProduktpass_Style_Header][$att]['EN']);
        }
        /*$this->worksheet->setCellValue($coord['StyleSize']['Cell'],$styleData->sizeWithoutPackaging);
		$this->worksheet->setCellValue($coord['StyleQuality']['Cell'],$styleData->qualityTechnicalData);
		$this->worksheet->setCellValue($coord['StyleQualityAdd']['Cell'],$styleData->additionalQualityInformation);
		$this->worksheet->setCellValue($coord['StyleChanges']['Cell'],$styleData->changesFromPredecessor);
		$this->worksheet->setCellValue($coord['StyleBrandRef']['Cell'],$styleData->brandReference);
		$this->worksheet->setCellValue($coord['StyleMaterial']['Cell'],$styleData->material);
		$this->worksheet->setCellValue($coord['StyleMaterialThickness']['Cell'],$styleData->materialThickness);
		$this->worksheet->setCellValue($coord['StyleColor']['Cell'],$styleData->color);*/
        $pp = tPPProduktpass::find($ppid);
        if ($pp === null) {
            //cpcDebug::p('Keine Daten '." P: $ppid Style: $styleChar <br> ");
            //cpcDebug::p(DB::getQueryLog());
            return;
        }
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, 3), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
    }
    private function writeStyle2603($ppid, $styleChar, $objPHPExcel, $transAll)
    {
        //cpcDebug::pe(DB::getQueryLog());
        $styleSearch = '%' . $styleChar;
        $styleDataExists = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->exists();
        if ($styleDataExists === false) {
            //cpcDebug::cpc_debug("Style $styleChar ausgeblendet",'@DBExcel');
            $objPHPExcel->getSheetByName("Style $styleChar")->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
            return;
        }
        //cpcDebug::cpc_debug("Style $styleChar eingeblendet",'@DBExcel');
        $styleData = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', trim($styleSearch))->get()->first();
        $trans = $transAll['Styles'];
        $objPHPExcel->setActiveSheetIndexByName("Style $styleChar");
        $this->worksheet = $objPHPExcel->getActiveSheet();
        $anchor = 3;
        $coord['weightWithoutPackaging'] = $this->getCellA(2, $anchor + 1);
        $coord['sizeWithoutPackaging'] = $this->getCellA(2, $anchor + 2);
        $coord['qualityTechnicalData'] = $this->getCellA(2, $anchor + 3);
        /// DoppleZeile
        $coord['additionalQualityInformation'] = $this->getCellA(2, $anchor + 6);
        $coord['changesFromPredecessor'] = $this->getCellA(2, $anchor + 7);
        $coord['brandReference'] = $this->getCellA(2, $anchor + 8);
        $coord['material'] = $this->getCellA(2, $anchor + 9);
        $coord['materialThickness'] = $this->getCellA(2, $anchor + 10);
        $coord['color'] = $this->getCellA(2, $anchor + 11);
        cpcDebug::cpc_debug('                writeStyle: '.json_encode($coord),'-RFQ603_A');
        foreach ($coord as $att => $cell) {
            cpcDebug::cpc_debug('                        Att:' . $att . ': ' . substr($trans[$styleData->PPProduktpass_Style_Header][$att]['EN'],0,15), '-RFQ603_A');
            $this->setCellValueAndHight($cell['Cell'], $trans[$styleData->PPProduktpass_Style_Header][$att]['EN']);
        }
        /*$this->worksheet->setCellValue($coord['StyleSize']['Cell'],$styleData->sizeWithoutPackaging);
		$this->worksheet->setCellValue($coord['StyleQuality']['Cell'],$styleData->qualityTechnicalData);
		$this->worksheet->setCellValue($coord['StyleQualityAdd']['Cell'],$styleData->additionalQualityInformation);
		$this->worksheet->setCellValue($coord['StyleChanges']['Cell'],$styleData->changesFromPredecessor);
		$this->worksheet->setCellValue($coord['StyleBrandRef']['Cell'],$styleData->brandReference);
		$this->worksheet->setCellValue($coord['StyleMaterial']['Cell'],$styleData->material);
		$this->worksheet->setCellValue($coord['StyleMaterialThickness']['Cell'],$styleData->materialThickness);
		$this->worksheet->setCellValue($coord['StyleColor']['Cell'],$styleData->color);*/
        $pp = tPPProduktpass::find($ppid);
        if ($pp === null) {
            //cpcDebug::p('Keine Daten '." P: $ppid Style: $styleChar <br> ");
            //cpcDebug::p(DB::getQueryLog());
            return;
        }
        $image = public_path() . '/data/uploads/' . $pp->PPProduktpass_ProjektBild;
        if (file_exists($image) and !is_dir($image)) {
            $this->writeImage($image, $this->getCell(2, $anchor), 'Projektbild', 'Projektbild IAN' . $pp->PPProduktpass_IAN);
        }
    }
    private function writeFirstStyle($coord, $ppid, $trans)
    {
        $firstStyle = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->where('PPProduktpass_Style_Header', 'like', '%A%')->get()->first();
        if (!$firstStyle) {
            return;
        }
        $this->setCellValueAndHight($coord['weightWithoutPackaging']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['weightWithoutPackaging']['EN']);
        $this->setCellValueAndHight($coord['sizeWithoutPackaging']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['sizeWithoutPackaging']['EN']);
        $this->setCellValueAndHight($coord['qualityTechnicalData']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['qualityTechnicalData']['EN']);
        $this->setCellValueAndHight($coord['additionalQualityInformation']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['additionalQualityInformation']['EN']);
        $this->setCellValueAndHight($coord['changesFromPredecessor']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['changesFromPredecessor']['EN']);
        $this->setCellValueAndHight($coord['brandReference']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['brandReference']['EN']);
        $this->setCellValueAndHight($coord['material']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['material']['EN']);
        $this->setCellValueAndHight($coord['materialThickness']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['materialThickness']['EN']);
        $this->setCellValueAndHight($coord['color']['Cell'], $trans[$firstStyle->PPProduktpass_Style_Header]['color']['EN']);
    }
    private function trueFalseToJaNein($value): string
    {
        cpcDebug::cpc_debug('TrueFalseConvert Wert: [' . $value . 'X]', 'RFQ2603');
        if ($value === null) {
            cpcDebug::cpc_debug('NULL', 'RFQ2603');
            return 'No';
        }
        if (strpos($value, '[jmsintegrati') !== false) {
            cpcDebug::cpc_debug('Lidl-Fehler', 'RFQ2603');
            return $value;
        }
        $trueValues = ['true', 'wahr', 'ja', 'yes', '1', 1, true];
        $ret = in_array(
            is_string($value) ? strtolower(trim($value)) : $value,
            $trueValues,
            true
        ) ? 'Yes' : 'No';
        cpcDebug::cpc_debug('Return: ' . $ret, 'RFQ2603');
        return $ret;
    }
    private function getMengenUebersichtNachLT($ppid)
    {
        $arts = array('stationary', 'OS', 'UKPlug', 'CHPlug', 'ES');
        $m = array();
        foreach ($arts as $art) {
            for ($i = 1; $i < 4; $i++) {
                $m[$art][$i] = $this->getMengenNachArt($art, $i, $ppid);
            }
        }
        //echo('<pre>');
        //print_r($m);
        return $m;
    }
    private function getMengenNachArt($art, $lt, $ppid)
    {
        //echo(" $art $lt $ppid <br>");
        if ($art == 'stationary') {
            $table = 'v_QtyStationary';
        }
        if ($art == 'OS') {
            $table = 'v_QtyOS';
        }
        if ($art == 'UKPlug') {
            $table = 'v_QtyUKPlug';
        }
        if ($art == 'CHPlug') {
            $table = 'v_QtyCHPlug';
        }
        if ($art == 'ES') {
            $table = 'v_QtyES';
        }
        $ltAttribute = 'PPProduktpass_Menge_LT' . $lt;
        $ltMengeAttribute = 'PPProduktpass_Menge_LT' . $lt . 'Menge';
        $result = DB::table($table)->select($ltAttribute, DB::raw("SUM(IFNULL($ltMengeAttribute,0)) as Menge"))
            ->where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)
            ->groupBy($ltAttribute)
            ->get();
        $a = array();
        if ($result) {
            foreach ($result as $m) {
                if ($m->Menge > 0) {
                    $a[$m->{$ltAttribute}] = $m->Menge;
                }
            }
        }
        //echo('Hier schauen<pre>');
        //print_r($a);
        //echo('</pre>');
        return $a;
    }
    public function testQty()
    {
        $ms = $this->getMengenUebersichtNachLT(11578);
        echo ('<pre>');
        print_r($ms);
        echo ('</pre>');
        $coord['stationary'][1]['LT'] =  $this->getCellA(4, 69);
        $coord['stationary'][2]['LT'] =  $this->getCellA(4, 78);
        $coord['stationary'][3]['LT'] =  $this->getCellA(4, 87);
        $coord['OS'][1]['LT'] =  $this->getCellA(4, 70);
        $coord['OS'][2]['LT'] =  $this->getCellA(4, 79);
        $coord['OS'][3]['LT'] =  $this->getCellA(4, 88);
        $coord['UKPlug'][1]['LT'] =  $this->getCellA(4, 71);
        $coord['UKPlug'][2]['LT'] =  $this->getCellA(4, 80);
        $coord['UKPlug'][3]['LT'] =  $this->getCellA(4, 89);
        $coord['CHPlug'][1]['LT'] =  $this->getCellA(4, 72);
        $coord['CHPlug'][2]['LT'] =  $this->getCellA(4, 81);
        $coord['CHPlug'][3]['LT'] =  $this->getCellA(4, 90);
        $coord['ES'][1]['LT'] =  $this->getCellA(4, 73);
        $coord['ES'][2]['LT'] =  $this->getCellA(4, 82);
        $coord['ES'][3]['LT'] =  $this->getCellA(4, 91);
        $coord['stationary'][1]['Menge'] =  $this->getCellA(5, 69);
        $coord['stationary'][2]['Menge'] =  $this->getCellA(5, 78);
        $coord['stationary'][3]['Menge'] =  $this->getCellA(5, 87);
        $coord['OS'][1]['Menge'] =  $this->getCellA(5, 70);
        $coord['OS'][2]['Menge'] =  $this->getCellA(5, 79);
        $coord['OS'][3]['Menge'] =  $this->getCellA(5, 88);
        $coord['UKPlug'][1]['Menge'] =  $this->getCellA(5, 71);
        $coord['UKPlug'][2]['Menge'] =  $this->getCellA(5, 80);
        $coord['UKPlug'][3]['Menge'] =  $this->getCellA(5, 89);
        $coord['CHPlug'][1]['Menge'] =  $this->getCellA(5, 72);
        $coord['CHPlug'][2]['Menge'] =  $this->getCellA(5, 81);
        $coord['CHPlug'][3]['Menge'] =  $this->getCellA(5, 90);
        $coord['ES'][1]['Menge'] =  $this->getCellA(5, 73);
        $coord['ES'][2]['Menge'] =  $this->getCellA(5, 82);
        $coord['ES'][3]['Menge'] =  $this->getCellA(5, 91);
        foreach ($coord as $art =>  $mlts) {
            echo ("  Art: $art <br>");
            foreach ($mlts as $lt => $m) {
                echo ("  Liefertermin:   $lt <br>");
                foreach ($ms[$art][$lt] as $cw => $qty) {
                    echo ("     CW: $cw Menge: $qty <br>");
                }
            }
        }
    }
    private function getLTMengen($ppid, $lt)
    {
        $lt = (int) $lt;
        if ($lt < 1 || $lt > 3) return [];
        $attribLT    = "PPProduktpass_Menge_LT{$lt}";
        $attribMenge = "PPProduktpass_Menge_LT{$lt}Menge";
        $rows = PPProduktpass_Menge::query()
            ->select(DB::raw("
				PPProduktpass_Menge_PPProduktpass_Id as ppid,
				{$attribLT} as LT,
				SUM({$attribMenge}) as Menge
			"))
            ->where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)
            ->whereNotNull($attribMenge)
            ->where($attribMenge, '>', 0)
            ->groupBy('ppid')                 // alias geht in MySQL i.d.R.
            ->groupBy(DB::raw($attribLT))     // raw, weil dynamische Spalte
            ->orderBy('LT')
            ->get();
        $a = [];
        foreach ($rows as $row) {
            $a[] = ['LT' => $row->LT, 'Menge' => $row->Menge];
        }
        return $a;
    }
    private function getLTMengenByArt($ppid, $lt, $art = 'OS')
    {
        //echo("$ppid $lt $art <br>");
        $lt = (int) $lt;
        if ($lt < 1 || $lt > 3) return [];
        $attribLT    = "PPProduktpass_Menge_LT{$lt}";
        $attribMenge = "PPProduktpass_Menge_LT{$lt}Menge";
        $rows = PPProduktpass_Menge::query()
            ->join('PPMengenUebersichtLaender', 'PPMengenUebersichtLaender_Land', '=', 'PPProduktpass_Menge_Country')
            ->select(DB::raw("
				PPProduktpass_Menge_PPProduktpass_Id as ppid,
				{$attribLT} as LT,
				PPMengenUebersichtLaender_Art as Art,
				SUM({$attribMenge}) as Menge
			"))
            ->where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)
            ->whereNotNull($attribMenge)
            ->where($attribMenge, '>', 0)
            ->where('PPMengenUebersichtLaender_Art', $art)
            ->groupBy('PPProduktpass_Menge_PPProduktpass_Id')
            ->groupBy(DB::raw($attribLT))
            ->groupBy('PPMengenUebersichtLaender_Art')
            ->orderBy('LT')
            ->get();
        $a = [];
        foreach ($rows as $row) {
            $a[] = [
                'LT'    => $row->LT,
                'Menge' => $row->Menge,
                'Art'   => $row->Art,
            ];
        }
        return $a;
    }
    private function hidedInternSheets($objPHPExcel)
    {
        //$objPHPExcel->getSheetByName('Quantity overview')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('Manual Overview (final QTY)')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('Manual Overview (est. QTY)')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
        $objPHPExcel->getSheetByName('Länderverteilung')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);
    }
}
