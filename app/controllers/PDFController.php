<?php
class PDFController extends BaseController {
    var $fpdf;
    var $leftmargin  = 15;
    var $rightmargin = 20;
    var $lh          = 4;
    var $logo;
    var $page        = 0;
    var $font        = 'Arial';
    var $pc;
    var $ItemId      = 1;
    var $PPId;
    var $POId;
    var $Revision    = 0;
    var $FinalVersion;
    var $isNewPage;
    var $arrayOsLaender;
    var $variante;
    var $osES;
    private $chapter = 0;
    private $subChapter = 1;
    public function __construct() {
        $this->fpdf = new myPDF();
        $this->logo = storage_path() . "/images/logo.jpg";
        $this->fpdf->Open();
        $this->fpdf->AddFont('dejavusans', '', 'DejaVuSans.ttf', true);
        $this->fpdf->AddFont('dejavusans', 'I', 'DejaVuSans-Oblique.ttf', true);
        $this->fpdf->AddFont('dejavusans', 'B', 'DejaVuSans-Bold.ttf', true);
        $this->fpdf->AddFont('dejavusans', 'BI', 'DejaVuSans-BoldOblique.ttf', true);
        $this->fpdf->AddFont('dejavuserif', '', 'DejaVuSerif.ttf', true);
        $this->fpdf->AddFont('dejavuserif', 'B', 'DejaVuSerif-Bold.ttf', true);
        $this->fpdf->AddFont('dejavuserif', 'BI', 'DejaVuSerif-BoldItalic.ttf', true);
        $this->fpdf->SetFont('dejavusans', '', 11);
        $this->fpdf->SetTextColor(200, 10, 10);
        $this->fpdf->SetFillColor(254, 255, 245);
        $this->fpdf->SetAutoPageBreak(true, 8);
        $this->fpdf->SetMargins(15, 40, 10);
        $this->fpdf->AliasNbPages();
        $this->pc = new ProjectsController();
    }
    function ddx($var, $exit = true) {
        if (Auth::User()->username == "fkeppel") {
            //print_r(debug_backtrace());
            echo('<pre>');
            print_r($var);
            echo('<pre>');
            if ($exit) {
                exit;
            }
        }
    }
    function setPreRelase($poid) {
    }
    function getPreRelase() {
    }
    public function getVE_OSLand($ppid, $osLand) {
        //echo("$ppid  -  $osLand => VE: ");
        $ve = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', "=", $ppid)->where('PPProduktpass_Menge_Country', "=", $osLand)->get()->first();
        if ($ve) {
            // echo ( $ve->PPProduktpass_Menge_Kolli . "<br>");
            return round($ve->PPProduktpass_Menge_Kolli, 0);
        }
        return 0;
    }
    function save($txt) {
        return true;
        // Div ganz abgeklemmt 2017-05-30
        /* $diff = new PPDiff();
          $diff->PPDiff_Art = "PO";
          $diff->PPDiff_ObjectId = $this->POId;
          $diff->PPDiff_ItemId = $this->ItemId;
          $diff->PPDiff_Rev = $this->Revision;
          $this->ItemId ++;
          $diff->PPDiff_Value = utf8_encode($txt);
          $diff->save(); */
    }
    function hasDiff($itemid, $txt) {
        if ($this->Revision == 1) {
            return False;
        }
        $diffc = PPDiff::where("PPDiff_ObjectId", "=", $this->POId)
                ->where("PPDiff_ItemId", "=", $itemid)
                ->where("PPDiff_Rev", "=", $this->Revision - 1)
                ->count();
        if ($diffc < 1)
            return FALSE;
        $diff = PPDiff::where("PPDiff_ObjectId", "=", $this->POId)
                ->where("PPDiff_ItemId", "=", $itemid)
                ->where("PPDiff_Rev", "=", $this->Revision - 1)
                ->first();
        //echo(" $diff->PPDiff_Value == $txt ? <br>");
        $dbval = utf8_decode($diff->PPDiff_Value);
        if (strlen($txt) == 0 and strlen($dbval) == 0) {
            return false;
        }
        if (strlen($txt) == 0 and strlen($dbval) != 0) {
            return True;
        }
        if (strpos($dbval, $txt) !== False)
            return false;
        return TRUE;
    }
    function CellSave($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '') {
        /*
         */
        //$saveFillColor = $this->fpdf->FillColor;
        //if ($this->FinalVersion){
        //	if ($this->hasDiff($this->ItemId, $txt)){
        //		$this->fpdf->SetFillColor(255,255,0);
        //mail BW: 21.02.2017 keine Markierung der Unterschiede mehr
        //$fill=False;
        //echo("DIFF $this->ItemId $txt <br>");
        //	}
        //$this->save($txt);
        //}
        //$this->fpdf->FillColor = $saveFillColor;
        $this->fpdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        //$this->fpdf->FillColor = $saveFillColor;
        $this->isNewPage = false;
    }
    function MultiCellSave($w, $h, $txt, $border = 0, $align = 'J', $fill = false) {
        //cpcDebug::dd("Multi".$txt);
        //var_dump($saveFillColor);exit;
        //$saveFillColor = $this->fpdf->FillColor;
        //if ($this->FinalVersion){
        //	if ($this->hasDiff($this->ItemId, $txt)){
        //		$this->fpdf->SetFillColor(255,255,0);
        //mail BW: 21.02.2017 keine Markierung der Unterschiede mehr
        //$fill=False;
        //echo("DIFF $this->ItemId $txt <br>");
        //		}
        //$this->save($txt);
        //	}
        //$fill = false;
        //$this->fpdf->FillColor = $saveFillColor;
        $this->fpdf->MultiCell($w, $h, $txt, $border, $align, $fill);
        //$this->fpdf->FillColor = $saveFillColor;
        $this->isNewPage = false;
    }
    private function _NewPage() {
        if ($this->isNewPage) {
            return;
        }
        $this->page++;
        $this->isNewPage = true;
        $this->fpdf->AddPage('P', 'A4');
        $this->fpdf->SetLeftMargin($this->leftmargin);
        $this->fpdf->SetRightMargin($this->rightmargin);
        $this->fpdf->SetTextColor(1, 1, 1);
        $this->fpdf->SetFont($this->font, '', 10);
        $this->fpdf->SetXY($this->leftmargin, 30);
    }
    private function _header1($header, $isChapter=true) {
        if (strlen($header) <= 0){
            return false;
        }
        $this->fpdf->SetFont($this->font, 'B', 10);
        if ($isChapter) {
            $this->chapter ++;
            $posChapText = strpos($header, ".");
            $header = trim(substr($header, $posChapText+1));
            $this->CellSave(0, $this->lh, "".$this->chapter.". ".$header, 'B', 0, 'L');
            $this->subChapter=1;
        }
        else {
            $this->CellSave(0, $this->lh, $header, 'B', 0, 'L');
        }
        $this->fpdf->SetFont($this->font, '', 10);
        $this->fpdf->Ln(2 * $this->lh);
        return true;
    }   
    private function _header2($header, $isSubChapter=true) {
        if (strlen($header) <= 0){
            return;
        }
        $this->fpdf->setY($this->fpdf->getY() - $this->lh);
        $this->fpdf->setX($this->leftmargin + 4);
        $this->fpdf->SetFont($this->font, 'B', 10);
        if ($isSubChapter){
            $posChapText = strpos($header, " ");
            $header = trim(substr($header, $posChapText+1));
            $this->CellSave(0, $this->lh, "".$this->chapter.".".$this->subChapter." ". $header, '', 0, 'L');
            $this->subChapter ++;
        } else {
            $this->CellSave(0, $this->lh, $header, '', 0, 'L');
        }
        $this->fpdf->SetFont($this->font, '', 10);
        $this->fpdf->Ln(1.5 * $this->lh);
    }
    private function _header3($header) {
        $this->fpdf->setY($this->fpdf->getY() - $this->lh / 2);
        $this->fpdf->setX($this->leftmargin + 4);
        $this->fpdf->SetFont($this->font, 'BI', 10);
        $this->CellSave(0, $this->lh, $header, '', 0, 'L');
        $this->fpdf->SetFont($this->font, '', 10);
        $this->fpdf->Ln($this->lh);
    }
    private function _text($text, $standard = true) {
        if ($standard) {
            $this->fpdf->SetFont($this->font, '', 10);
        }
        else {
            $this->fpdf->SetFont($this->font, 'B', 10);
        }
        $this->fpdf->setX($this->leftmargin + 4);
        $this->MultiCellSave(0, $this->lh, $text, '', '');
        $this->fpdf->SetFont($this->font, '', 1);
        $this->fpdf->Ln(2 * $this->lh);
        $this->fpdf->SetFont($this->font, '', 10);
    }
    private function _PDFImprovedTable($header, $data, $w = array(40, 35, 40, 45,
                45)) {
        //Column widths
        //Header
        for ($i = 0; $i < count($header); $i++)
            $this->CellSave($w[$i], 7, $header[$i], 1, 0, 'C');
        $this->fpdf->Ln();
        //Data
        foreach ($data as $row) {
            $this->CellSave($w[0], 6, $row[0], 'LR');
            $this->CellSave($w[1], 6, $row[1], 'LR');
            $this->CellSave($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->CellSave($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->fpdf->Ln();
        }
        //Closure line
        $this->CellSave(array_sum($w), 0, '', 'T');
    }
    function outputPDFP($id, $bw = false) {
        //echo("Hier ID: $id");exit;
        $this->_outputPDF($id, True, false, $bw);
    }
    function outputPDFP_Final($id, $bw = false) {
        $this->_outputPDF($id, True, True, $bw);
    }
    function getManufacturer($id) {
        $mf = "N.N.";
        $adr = PPAdressen::find($id);
        if ($adr) {
            $mf = $adr->Firma1 . " / " . $adr->Land;
        }
        return $mf;
    }
    function getUZ($id, $project) {
        // id = PPProduktpass_PPProjekte_Projekt
        if (is_null($project)) {
            $pps = PPProduktpass::where('PPProduktpass_Id', '=', $id)->get();
        }
        else {
            $pps = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', $project)->get();
        }
        $res         = array();
        $res['UZ']   = "Nein";
        $res['UZRS'] = "Nein";
        foreach ($pps as $pp) {
            $dbres = PPAB::where('PPAB_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->first();
            if ($dbres) {
                if ($dbres->PPAB_UZ != "Nein") {
                    $res['UZ'] = $dbres->PPAB_UZ;
                }
                if ($dbres->PPAB_UZRS != "Nein") {
                    $res['UZRS'] = $dbres->PPAB_UZRS;
                }
            }
        }
        return $res;
    }
    function updateTermineUnterschrift($ppid) {
        $termin = PPTermine::where("PPTermine_PPProduktpass_Id", "=", $ppid)->where("PPTermine_PPBoardSpalte_id", "=", 81)->get()->first();
        if ($termin) {
            $termin->PPTermine_Status = 'Neu';
            $termin->save();
        }
    }
    function getTOP($topid) {
        if ($top = PPTerms::where('PPTerms_Id', '=', $topid)->get()->first()) {
            return $top->PPTerms_Text;
        }
        return "";
    }
    function isPoorOSSort($lb) {
        $isPoorOS = False;
        if (strpos($lb, "CB8") !== false) {
            if (strpos($lb, "CB1") !== false) {
                return false;
            }
            if (strpos($lb, "CB2") !== false) {
                return false;
            }
            if (strpos($lb, "CB3") !== false) {
                return false;
            }
            if (strpos($lb, "CB4") !== false) {
                return false;
            }
            if (strpos($lb, "CB6") !== false) {
                return false;
            }
            if (strpos($lb, "CB7") !== false) {
                return false;
            }
            if (strpos($lb, "CB9") !== false) {
                return false;
            }
            return true;
        }
        if ($lb == "CB5-OSES") {
            return true;
        }
        for ($i = 1; $i <= 7; $i++) {
            if (strpos($lb, "CB" . $i) !== false) {
                $isPoorOS = false;
            }
        }
        return $isPoorOS;
    }
    function getOSTotal($sort) {
        $aOSsort = $sort['aOSMenge'];
        $t       = 0;
        foreach ($aOSsort as $l) {
            foreach ($l as $m) {
                if (isset($m) and is_null($m) and is_numeric($m)) {
                    $t += $m;
                }
            }
        }
        return $t;
    }
    function _outputPDF($id, $bP = False, $final = false, $bw = false) {
        $this->FinalVersion = $final;
        $this->arrayOsLaender = array('OSDE', 'OSBE', 'OSNL', 'OSCZ', 'OSES', 'OSGB',
            'OSFR', 'OSPL', 'OSSK', 'OSAT');
        $pp         = PPProduktpass::find($id);
        $this->PPId = $id;
        $apps = array();
        if ($bP) {
            if (strlen($pp->PPProduktpass_PPProjekte_Projekt) > 0) {
                $pps = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', trim($pp->PPProduktpass_PPProjekte_Projekt))
                                ->where(DB::Raw('length(PPProduktpass_IAN)'), '<=', '6')
                                ->orderBy('PPProduktpass_IAN')->get();
            }
            else {
                $pps = PPProduktpass::where('PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->orderBy('PPProduktpass_IAN')->get();
            }
            foreach ($pps as $pp1) {
                //echo "$pp1->PPProduktpass_Id $pp1->PPProduktpass_IAN <br>";
                $apps[$pp1->PPProduktpass_Id]['PPProduktpass_Id']  = $pp1->PPProduktpass_Id;
                $apps[$pp1->PPProduktpass_Id]['PPProduktpass_IAN'] = $pp1->PPProduktpass_IAN;
                $tpurchase                                                               = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $pp1->PPProduktpass_Id)->first();
                //dd($tpurchase);
                $apps[$pp1->PPProduktpass_Id]['PPPurchase_Translate_Projectdescription'] = $tpurchase->PPPurchase_Translate_Projectdescription;
            }
        }
        //echo "<pre>";var_dump($app);echo "</pre>"; exit;
        $purchase   = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->get()->first();
        $this->POId = $purchase->PPPurchase_Id;
        $this->Revision = PPDiff::getMaxRev($this->POId);
        $this->Revision++;
        $supplier = PPAdressen::where('Matchcode', "=", $purchase->PPPurchase_Supplier)->get()->first();
        if ($supplier) {
            $LtMinus = $supplier->PPAdressen_LT;
            if (is_null($LtMinus)) {
                $LtMinus = 9;
            }
        }
        else {
            echo("<div style='margin:0 auto;padding:50px;border:4px solid orange;width:500px;'>");
            echo("Noch kein Lieferant ausgewählt!<br>");
            echo('<a href = "/show/' . $pp->PPProduktpass_Id . '#tabs-9" style="">zurück zu IAN: ' . $pp->PPProduktpass_IAN . '</a>');
            echo("</div >");
            exit;
        }
        $menge = PPProduktpass_Menge::where('PPProduktpass_Menge_Id', '=', $id)->get()->first();
        $qual  = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_Id', '=', $id)->get()->first();
        $sort  = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_Id', '=', $id)->get()->first();
        $ppab = PPAB::where('PPAB_PPProduktpass_Id', "=", $pp->PPProduktpass_Id)->first();
        if (isset($ppab->PPAB_Abgangshafen)) {
            $PoD = PPAbgangshafen::find($ppab->PPAB_Abgangshafen)->PPAbgangshafen_Hafen;
        }
        else {
            $PoD = "N.N.";
        }
        //$delKw = $pp->PPProduktpass_Liefertermin - $LtMinus;
        //$delJahr = $pp->PPProduktpass_LieferterminJahr;
        //If ($delKw < 1 ) {
        //$delKw += 52;
        //(($delJahr--;
        //}
        $delKw   = $purchase->PPPurchase_FOBWeek;
        $delJahr = $purchase->PPPurchase_FOBYear;
        $DeliveryDate = $delKw . '/' . $delJahr;
        $tod          = PPTerms::find($purchase->PPPurchase_TermsOfDelivery);
        $ians  = '';
        $descr = '';
        if ($bP) {
            foreach ($apps as $tmp_pp) {
                $ians  .= $tmp_pp['PPProduktpass_IAN'] . " + ";
                $descr .= utf8_decode($tmp_pp['PPPurchase_Translate_Projectdescription']) . '
';
            }
            $ians  = substr($ians, 0, -3);
            $descr = substr($descr, 0, -2);
        }
        else {
            $ians = $pp->PPProduktpass_IAN;
        }
        $port                = isset($PoD) ? $PoD : "N.N.";
        $sToD                = isset($tod) ? str_replace('%PORT%', $port, $tod->PPTerms_Text)
                    : '';
        //dd( $sToD );
        //Seite 1
        $this->fpdf->sFooter = 'Purchase Order ' . $pp->PPProduktpass_Einkaeufer . " - " . $ians;
        $this->_NewPage();
        $this->fpdf->SetXY($this->leftmargin, 50);
        $this->CellSave(0, 10, utf8_decode($supplier->Firma1));
        $this->fpdf->Ln($this->lh);
        $this->CellSave(0, 10, utf8_decode($supplier->Adresse1));
        $this->fpdf->Ln($this->lh);
        $PLZ_Ort = utf8_decode((strlen($supplier->PLZ) > 0) ? $supplier->PLZ . " " . $supplier->Ort
                    : $supplier->Ort);
        $this->CellSave(0, 10, $PLZ_Ort);
        $this->fpdf->Ln($this->lh);
        $this->fpdf->SetFont($this->font, 'B', 10);
        $this->CellSave(0, 10, utf8_decode($supplier->Land));
        $this->fpdf->Ln($this->lh);
        $this->fpdf->SetFont($this->font, '', 10);
        $this->fpdf->SetXY($this->leftmargin, 80);
        $this->fpdf->SetFont($this->font, 'B', 11);
        $str1 = $ians;
        $str2 = "";
        if (strlen($str1) > 50) {
            $trennpos = strpos($str1, "+", 40);
            if ($trennpos !== false) {
                $trennpos++;
            }
            else {
                $trennpos = 50;
            }
            if ($trennpos > 50) {
                $trennpos = 50;
            }
            $str2 = substr($str1, $trennpos, 140);
            $str1 = substr($str1, 0, $trennpos);
        }
        $lineoffset = 0;
        $this->CellSave(0, 10, 'Purchase Order ' . $pp->PPProduktpass_Einkaeufer . " - " . $str1);
        if (strlen($str2) > 0) {
            $lineoffset = 10;
            $this->fpdf->Ln(5);
            $this->CellSave(0, 10, '                                    ' . $str2);
        }
        //$oDate = isset($purchase->PPPurchase_Orderdate)?$purchase->PPPurchase_Orderdate:date('Y-m-d h:i:s');
        $oDate = date('Y-m-d h:i:s');
        if ($final) {
            $purchase->PPPurchase_Orderdate = $oDate;
            $this->updateTermineUnterschrift($pp->PPProduktpass_Id);
            $purchase->save();
        }
        $this->fpdf->SetXY(175, 80);
        $this->CellSave(0, 10, date('Y-m-d'));
        $this->fpdf->SetXY($this->leftmargin, 90 + $lineoffset);
        $txtStatus = PPStatiX::find($purchase->PPPurchase_Status);
        $this->CellSave(52, $this->lh, 'Batch: ');
        $this->CellSave(0, $this->lh, substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4));
        $this->fpdf->Ln(2 * $this->lh);
        $this->CellSave(52, $this->lh, 'Status: ');
        $this->CellSave(0, $this->lh, $txtStatus->PPStati_Status);
        $this->fpdf->Ln(2 * $this->lh);
        $this->CellSave(52, $this->lh, 'Changes: ');
        $this->MultiCellSave(0, $this->lh, utf8_decode($purchase->PPPurchase_BemerkungAenderungen));
        $this->fpdf->Ln(2 * $this->lh);
        $this->CellSave(52, $this->lh, 'PROJECT - NO.: ');
        $this->CellSave(0, $this->lh, $pp->PPProduktpass_Einkaeufer . " - " . $str1);
        if (strlen($str2) > 0) {
            $this->fpdf->Ln(5);
            $this->CellSave(52, $this->lh, '');
            $this->CellSave(0, $this->lh, trim($str2));
        }
        $this->fpdf->Ln(2 * $this->lh);
        $this->CellSave(52, $this->lh, 'PROJECT - DESCRIPTION: ');
        $this->MultiCellSave(0, $this->lh, $descr);
        $this->fpdf->Ln($this->lh);
        $this->fpdf->SetFont($this->font, '', 10);
        $this->fpdf->SetTextColor(255, 0, 0);
        $this->MultiCellSave(0, $this->lh, "Additional Clause for OS (Online Shop) - Packing Instruction");
        $this->fpdf->Ln($this->lh);
        $this->fpdf->SetTextColor(1, 1, 1);
        $this->MultiCellSave(0, $this->lh, $this->_getText('TextManufacture', '%PLANT%', strtoupper($this->getManufacturer($purchase->PPPurchase_ManufacturingPlant))));
        $this->MultiCellSave(0, $this->lh, $this->_getText("TextContractual1"));
        $this->fpdf->Ln($this->lh);
        //$this->MultiCellSave(0,$this->lh,utf8_decode($this->_getText('TextContractual')));
        //$this->fpdf->Ln($this->lh);
        $this->fpdf->SetFont($this->font, 'B', 10);
        $this->MultiCellSave(0, $this->lh, utf8_decode($this->_getText('TextContractual2')));
        $this->fpdf->SetFont($this->font, '', 10);
        $this->_NewPage(); //Seite 2
        $this->_header1($this->_getText('HeaderK1'));
        $this->fpdf->Ln($this->lh);
        $this->_header2($this->_getText('TextK1_1'));
        $packing = $this->pc->getProjectPacking($pp->PPProduktpass_PPProjekte_Projekt);
        $this->_text(utf8_decode("Packaging unit:  " . $packing));
        //Triman
        // fke:21.11.2017  $this->_text(utf8_decode($this->_getText("TextK1_2")));
        $this->_absatz($this->_getTextA("TextK1_2"));
        //$this->fpdf->Image(storage_path() . "/images/PO/triman.jpg", $this->fpdf->getX() + 90, $this->fpdf->getY() - 33, 0, 9);
        $this->fpdf->Ln($this->lh);
        //$this->fpdf->SetFont($this->font,'B',10);
        //$this->fpdf->Image(storage_path() . "/images/PO/PackLogoTriman.jpg", $this->fpdf->getX() + 10, $this->fpdf->getY() - 10);
        //$this->fpdf->Ln($this->lh);
        // fke:21.11.2017  $this->_text(utf8_decode($this->_getText("TextK1_3")));
        $this->_absatz($this->_getTextA("TextK1_3"));
        $this->fpdf->Ln($this->lh);
        //$this->fpdf->Image(storage_path() . "/images/PO/PackLogo.jpg", $this->fpdf->getX() + 10, $this->fpdf->getY() - 10);
        //$this->fpdf->Ln($this->lh);
        // fke:21.11.2017  $this->_text(utf8_decode($this->_getText("TextK1_4")));
        $this->_text($this->_getText("TextK1_4"));
        $this->fpdf->SetTextColor(255, 0, 0);
        $this->_text($this->_getText("TextK1_5"));
        $this->fpdf->SetTextColor(1, 1, 1);
        $this->_text($this->_getText("TextK1_6"), false);
        $this->fpdf->SetTextColor(255, 0, 0);
        $this->_text($this->_getText("TextK1_7"));
        $this->fpdf->SetTextColor(1, 1, 1);
        $this->fpdf->Ln($this->lh);
        //Seite 2
        //ab hier pro Projekt wiederholen
//*****************************************************************************************************************************************
        $total_array = array();
        foreach ($apps as $app) {
            $ian_id      = $app['PPProduktpass_Id'];
            $pp          = PPProduktpass::find($ian_id);
            $purchase    = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $ian_id)->get()->first();
            $incoterm_id = $purchase['PPPurchase_TermsOfDelivery'];
            $incoterm    = PPTerms::find($incoterm_id);
            if (substr($pp->PPProduktpass_Ausmusterungnummer, 0, 2) >= "19") {
                $this->variante = "NEU";
            }
            else {
                $this->variante = "ALT";
            }
            $isFCA = False;
            if (strpos($incoterm['PPTerms_MC'], "FCA") !== False) {
                $isFCA = True;
            }
            $total_array[$ian_id]['IAN'] = $pp->PPProduktpass_IAN;
            $this->_NewPage(); //Seite 2
            $this->fpdf->SetXY($this->leftmargin, 30);
            $this->fpdf->SetFont($this->font, 'B', 10);
            $this->CellSave(0, $this->lh, utf8_decode("Project No.: " . $pp->PPProduktpass_Einkaeufer . " - " . $pp->PPProduktpass_IAN));
            $this->fpdf->Ln($this->lh + 2);
            $this->fpdf->SetFont($this->font, '', 10);
            $this->MultiCellSave(0, $this->lh, utf8_decode($purchase->PPPurchase_Translate_Quality));
            $this->fpdf->Ln($this->lh);
            $l_pro_b = $this->pc->getLaenderProBlock($pp->PPProduktpass_Id);
            $lb      = $this->pc->getLaenderBloecke($pp->PPProduktpass_Id);
            $this->fpdf->SetFont($this->font, '', 8);
            if ($bw) {
                $this->_NewPage(); //Seite 2
                $this->CellSave(0, $this->lh, utf8_decode("PJN: " . $pp->PPProduktpass_IAN . " in the following countrysize + per price set:"));
                $this->fpdf->Ln($this->lh);
                $this->fpdf->SetFillColor(247, 182, 76);
                if (!$isFCA) {
                    $tblsizes = array(18, 32, 20, 20, 20, 17, 17, 17, 17);
                }
                else {
                    $tblsizes = array(18, 32, 20, 20, 20, 27, 12, 12, 12);
                }
                $this->CellSave($tblsizes[0], 5, '', 1, 0, 'L', 1);
                $this->CellSave($tblsizes[1], 5, $pp->PPProduktpass_IAN, 1, 0, 'L', 1);
                $this->CellSave($tblsizes[2], 5, '', 1, 0, 'R', 1);
                $this->CellSave($tblsizes[3], 5, 'price per', 1, 0, 'R', 1);
                $this->CellSave($tblsizes[4], 5, '', 1, 0, 'R', 1);
                if (!$isFCA) {
                    $this->CellSave($tblsizes[5] + $tblsizes[6] + $tblsizes[7] + $tblsizes[8], 5, 'Quantity per destination port', 1, 0, 'L', 1);
                }
                else {
                    $this->CellSave($tblsizes[5] + $tblsizes[6] + $tblsizes[7] + $tblsizes[8], 5, 'Carton Information', 1, 0, 'L', 1);
                }
                $this->fpdf->Ln();
                $this->CellSave($tblsizes[0], 5, 'Country', 1, 0, 'L', 1);
                $this->CellSave($tblsizes[1], 5, 'Size', 1, 0, 'L', 1);
                $this->CellSave($tblsizes[2], 5, 'Quantity', 1, 0, 'R', 1);
                $this->CellSave($tblsizes[3], 5, 'Unit [' . $purchase->PPPurchase_Currency . "]", 1, 0, 'R', 1);
                $this->CellSave($tblsizes[4], 5, 'Total [' . $purchase->PPPurchase_Currency . "]", 1, 0, 'R', 1);
                if (!$isFCA) {
                    $this->CellSave($tblsizes[5], 5, 'Rotterdam', 1, 0, 'R', 1);
                    $this->CellSave($tblsizes[6], 5, 'Barcelona', 1, 0, 'R', 1);
                    $this->CellSave($tblsizes[7], 5, 'Koper', 1, 0, 'R', 1);
                    $this->CellSave($tblsizes[8], 5, 'USA', 1, 0, 'R', 1);
                }
                else {
                    $this->CellSave($tblsizes[5], 5, 'cnt-size', 1, 0, 'R', 1);
                    $this->CellSave($tblsizes[6], 5, 'psc/cnt', 1, 0, 'R', 1);
                    $this->CellSave($tblsizes[7], 5, 'cnt/pal', 1, 0, 'R', 1);
                    $this->CellSave($tblsizes[8], 5, 'trucks', 1, 0, 'R', 1);
                }
                $this->fpdf->Ln();
                $sMenge = 0;
                $sPrice = 0;
                $this->fpdf->SetFillColor(255, 255, 255);
                $lls    = $this->pc->getLieferlaender($pp->PPProduktpass_Id);
                //echo("<pre>");var_dump($lls);exit;
                $cbsize = array();
                foreach ($lls as $ll) {
                    //echo('Block: '.$ll['CB'].'    Gr�sse:'. $ll['Size'].'  l:'.strlen($ll['Size']).'<br>');
                    if (strlen($ll['Size']) > 0) {
                        $cbsize[$ll['Country']] = $ll['Size'];
                    }
                }
                $aufteilung = $this->pc->gethafenAufteilung($pp->PPProduktpass_Id);
                //echo('<pre>');var_dump($aufteilung);echo('</pre>');exit;
                //echo('<pre>');var_dump($hafenmengen);echo('</pre>');exit;
                $this->fpdf->SetFont($this->font, '', 8);
                $mRotterdam = 0;
                $mBarcelona = 0;
                $mKoper     = 0;
                $mUSA       = 0;
                $ekFOB = $purchase->PPPurchase_EK;
                //Mengen, Preise, Hafenmengen
                foreach ($lls as $land) {
                    //echo(" Block: ".$block."  L�nder: ".$l_pro_b[$block]." Size: ". $block_data['CBEK']. "<br>");
                    $ek = $land['EK'];
                    if ($ekFOB > 0)
                        $ek = $ekFOB;
                    if ($land['sumCountry'] > 0) {
                        $zielhaefen              = $this->pc->getZielhafen($land['Country'], $pp->PPProduktpass_Id);
                        $sMenge                  += $land['sumCountry'];
                        $sPrice                  += $land['sumCountry'] * $ek;
                        //$out = $l_pro_b[$block];$out .= " Quantity: ".number_format($block_data['sumCountryBlock'],0,',','.');$out .= " Price:" . number_format($block_data['CBEK'],2,',','.');
                        //$out .= " Total: ".number_format($block_data['sumCountryBlock'] * $block_data['CBEK'],2,',','.');echo($out.'<br>');
                        //echo('Block:'.$land['Country'].' EK:'.$land['CBEK'].' <br>');
                        //exit;
                        $mengeHafen['Rotterdam'] = 0;
                        $mengeHafen['Barcelona'] = 0;
                        $mengeHafen['Koper']     = 0;
                        $mengeHafen['USA']       = 0;
                        $mengeHafen[$zielhaefen['Hafen1']] = $land['sumCountry'] * $zielhaefen['ProzH1'];
                        if ($zielhaefen['ProzH2'] > 0) {
                            $mengeHafen[$zielhaefen['Hafen2']] = $land['sumCountry'] * $zielhaefen['ProzH2'];
                        }
                        //Teilbar durch Kolli?
                        $kolli = $land['Kolli'];
                        if ($kolli != 0) {
                            if (($mengeHafen[$zielhaefen['Hafen1']] % $kolli) != 0) {
                                $rest                              = $mengeHafen[$zielhaefen['Hafen1']] % $kolli;
                                $diff                              = $kolli - $rest;
                                $mengeHafen[$zielhaefen['Hafen1']] = $mengeHafen[$zielhaefen['Hafen1']] + $diff;
                                if ($zielhaefen['ProzH2'] > 0) {
                                    $mengeHafen[$zielhaefen['Hafen2']] = $mengeHafen[$zielhaefen['Hafen2']] - $diff;
                                }
                            }
                        }
                        //echo("<pre>");var_dump($zielhaefen);echo('<br>');var_dump($land);echo('</pre><br>');
                        $mRotterdam += $mengeHafen['Rotterdam'];
                        $mBarcelona += $mengeHafen['Barcelona'];
                        $mKoper     += $mengeHafen['Koper'];
                        $mUSA       += $mengeHafen['USA'];
                        $str1 = $land['Size'] . " [" . $land['gsm'] . " g/set]";
                        $str2 = "";
                        $maxZeile = 15;
                        $trennpos = $maxZeile;
                        if (strlen($str1) > $maxZeile) {
                            $trennpos = strpos($str1, "+", $maxZeile);
                            if ($trennpos !== false) {
                                $trennpos++;
                            }
                            else {
                                $trennpos = $maxZeile;
                            }
                            $str2 = substr($str1, $trennpos, 100);
                            $str1 = substr($str1, 0, $trennpos);
                        }
                        $this->CellSave($tblsizes[0], 6, $land['Country'], 'LR');
                        $this->CellSave($tblsizes[1], 6, $str1, 'LR');
                        $this->CellSave($tblsizes[2], 6, number_format($land['sumCountry'], 0, ',', '.'), 'LR', 0, 'R');
                        $this->CellSave($tblsizes[3], 6, number_format($ek, 2, ',', '.'), 'LR', 0, 'R');
                        $this->CellSave($tblsizes[4], 6, number_format($land['sumCountry'] * $ek, 2, ',', '.'), 'LR', 0, 'R');
                        if (!$isFCA) {
                            $this->CellSave($tblsizes[5], 6, number_format($mengeHafen['Rotterdam'], 0, ',', '.'), 'LR', 0, 'R');
                            $this->CellSave($tblsizes[6], 6, number_format($mengeHafen['Barcelona'], 0, ',', '.'), 'LR', 0, 'R');
                            $this->CellSave($tblsizes[7], 6, number_format($mengeHafen['Koper'], 0, ',', '.'), 'LR', 0, 'R');
                            $this->CellSave($tblsizes[8], 6, number_format($mengeHafen['USA'], 0, ',', '.'), 'LR', 0, 'R');
                        }
                        else {
                            $this->CellSave($tblsizes[5], 6, $land['CartonSize'], 'LR', 0, 'R');
                            $this->CellSave($tblsizes[6], 6, number_format($land['PcsPerCarton'], 0, ',', '.'), 'LR', 0, 'R');
                            $this->CellSave($tblsizes[7], 6, number_format($land['CartonPerPal'], 0, ',', '.'), 'LR', 0, 'R');
                            $this->CellSave($tblsizes[8], 6, number_format($land['Trucks'], 0, ',', '.'), 'LR', 0, 'R');
                        }
                        if (strlen($str1) >= $maxZeile) {
                            $h2 = 4;
                            $this->fpdf->Ln($h2);
                            $this->CellSave($tblsizes[0], $h2, "", 'LR');
                            $this->CellSave($tblsizes[1], $h2, $str2, 'LR');
                            $this->CellSave($tblsizes[2], $h2, "", 'LR', 0, 'R');
                            $this->CellSave($tblsizes[3], $h2, "", 'LR', 0, 'R');
                            $this->CellSave($tblsizes[4], $h2, "", 'LR', 0, 'R');
                            $this->CellSave($tblsizes[5], $h2, "", 'LR', 0, 'R');
                            $this->CellSave($tblsizes[6], $h2, "", 'LR', 0, 'R');
                            $this->CellSave($tblsizes[7], $h2, "", 'LR', 0, 'R');
                            $this->CellSave($tblsizes[8], $h2, "", 'LR', 0, 'R');
                        }
                        $this->fpdf->Ln();
                    }
                }
                $total_array[$ian_id]['Total'] = $sMenge;
                $this->fpdf->SetFillColor(255, 75, 0);
                $this->CellSave($tblsizes[0], 6, '', 'LTRB', 0, 'L', 1);
                $this->CellSave($tblsizes[1], 6, '', 'LTRB', 0, 'L', 1);
                $this->CellSave($tblsizes[2], 6, number_format($sMenge, 0, ',', '.'), 'LTRB', 0, 'R', 1);
                $this->CellSave($tblsizes[3], 6, '', 'LTRB', 0, 'R', 1);
                $this->CellSave($tblsizes[4], 6, number_format($sPrice, 2, ',', '.'), 'LTRB', 0, 'R', 1);
                if (!$isFCA) {
                    $this->CellSave($tblsizes[5], 6, number_format($mRotterdam, 0, ',', '.'), 'LTRB', 0, 'R', 1);
                    $this->CellSave($tblsizes[6], 6, number_format($mBarcelona, 0, ',', '.'), 'LTRB', 0, 'R', 1);
                    $this->CellSave($tblsizes[7], 6, number_format($mKoper, 0, ',', '.'), 'LTRB', 0, 'R', 1);
                    $this->CellSave($tblsizes[8], 6, number_format($mUSA, 0, ',', '.'), 'LTRB', 0, 'R', 1);
                }
                else {
                    $this->CellSave($tblsizes[5], 6, "", 'LTRB', 0, 'R', 1);
                    $this->CellSave($tblsizes[6], 6, "", 'LTRB', 0, 'R', 1);
                    $this->CellSave($tblsizes[7], 6, "", 'LTRB', 0, 'R', 1);
                    $this->CellSave($tblsizes[8], 6, "", 'LTRB', 0, 'R', 1);
                }
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(255, 255, 255);
                $this->_NewPage();
            }
            else {
                $sMenge = 0;
                $sPrice = 0;
                $lls    = $this->pc->getLieferlaender($pp->PPProduktpass_Id);
                $cbsize = array();
                $aufteilung = $this->pc->gethafenAufteilung($pp->PPProduktpass_Id);
                $mRotterdam = 0;
                $mBarcelona = 0;
                $mKoper     = 0;
                $ekFOB = $purchase->PPPurchase_EK;
                //Mengen, Preise, Hafenmengen
                foreach ($lls as $land) {
                    $cbsize[$land['Country']] = 'XXX';
                    $ek                       = $land['CBEK'];
                    if ($ekFOB > 0)
                        $ek                       = $ekFOB;
                    if ($land['sumCountry'] > 0) {
                        $zielhaefen = $this->pc->getZielhafen($land['Country'], $pp->PPProduktpass_Id);
                        $sMenge     += $land['sumCountry'];
                        $sPrice     += $land['sumCountry'] * $ek;
                        $mengeHafen['Rotterdam'] = 0;
                        $mengeHafen['Barcelona'] = 0;
                        $mengeHafen['Koper']     = 0;
                        $mengeHafen[$zielhaefen['Hafen1']] = $land['sumCountry'] * $zielhaefen['ProzH1'];
                        if ($zielhaefen['ProzH2'] > 0) {
                            $mengeHafen[$zielhaefen['Hafen2']] = $land['sumCountry'] * $zielhaefen['ProzH2'];
                        }
                        $mRotterdam += $mengeHafen['Rotterdam'];
                        $mBarcelona += $mengeHafen['Barcelona'];
                        $mKoper     += $mengeHafen['Koper'];
                    }
                }
                $total_array[$ian_id]['Total'] = $sMenge;
                //$this->_NewPage();
            }
            $testY = $this->fpdf->getY();
            if ($testY > 170) {
                $this->_NewPage();
            }
            //  Seite 3
            //Sortierung und EAN
            $this->_header1('Assortment for PJN: ' . $pp->PPProduktpass_IAN, false);
            $sorts = $this->pc->getSortierung($pp->PPProduktpass_Id);
            $this->fpdf->SetFont($this->font, '', 10);
            $this->fpdf->SetTextColor(1, 1, 1);
            if ($bw) {
                $this->fpdf->SetXY($this->leftmargin, 40);
            }
            //Gesamtbreite = 170
            $w[0] = 30;
            $w[1] = 60;
            $w[2] = 46;
            $w[3] = 24;
            $startcellheight = 4.5;
            $lb              = "X";
            $test_array      = array();
            /* echo("<pre>");
              print_r($sorts);
              exit; */
            foreach ($sorts as $sort) {
                //echo("<pre>"); var_dump($sort['Laenderblock']);
                if (isset($sort['Laenderblock'])) {
                    if (!isset($test_array[$sort['Laenderblock']]))
                        $test_array[$sort['Laenderblock']] = $sort['menge'];
                    else
                        $test_array[$sort['Laenderblock']] += $sort['menge'];
                }
            }
            $sUnit = 0;
            $sizeTotal = false;
            foreach ($sorts as $key => $sort) {
                cpcDebug::cpc_debug($sort, "TESTOS");
                $print  = false;
                $max    = $sort['max'];
                $eans   = $sort['AEAN'];
                $amenge = $sort['amenge'];
                $sizes  = $sort['SIZE'];
                if ($this->isPoorOSSort($sort['Laenderblock'])) {
                    $id = $key;
                    continue;
                }
                if (isset($test_array[$sort['Laenderblock']]) and $test_array[$sort['Laenderblock']] >= 0) {
                    //echo('Ja2:'.$sort['Laenderblock']."<br>");
                    $print = true;
                    if ($sort['Laenderblock'] != $lb) {
                        //Neue Sortierung
                        if ($lb != "X") {
                            $this->fpdf->SetFillColor(255, 75, 0);
                            $this->CellSave($w[0], $cellheight, 'Total units per carton', 'LTRB', 0, 'L', 1);
                            $this->CellSave($w[1], $cellheight, '', 'LTRB', 0, 'L', 1);
                            $this->CellSave($w[2], $cellheight, number_format($sUnit, 0, ',', '.'), 'LTRB', 0, 'C', 1);
                            $this->CellSave($w[3], $cellheight, '', 'LTRB', 0, 'R', 1);
                            $this->fpdf->SetFillColor(255, 255, 255);
                            $this->fpdf->Ln(10);
                            //$this->_NewPage();
                            if ($this->fpdf->getY() > 200) {
                                $this->_NewPage();
                                $this->fpdf->SetFont($this->font, '', 7);
                            }
                        }
                        $this->fpdf->SetFont($this->font, '', 7);
                        $laenderblock = strlen($sort['Laenderblock']) > 0 ? $sort['Laenderblock']
                                    : "all countries";
                        $this->MultiCellSave($w[0] + $w[1] + $w[2] + $w[3], $startcellheight, 'Assortment for ' . str_replace('CB', 'LB', $laenderblock), 'LBTR', 'L');
                        //$this->fpdf->Ln();
                        $cellheight   = 6;
                        $this->fpdf->SetFillColor(247, 182, 76);
                        $this->CellSave($w[0], $cellheight, 'Styles', 1, 0, 'L', 1);
                        $this->CellSave($w[1], $cellheight, 'Colors', 1, 0, 'L', 1);
                        $this->CellSave($w[2], $cellheight, 'Unit', 1, 0, 'C', 1);
                        $this->CellSave($w[3], $cellheight, 'EAN', 1, 0, 'L', 1);
                        $this->fpdf->Ln();
                        $this->fpdf->SetFillColor(255, 255, 255);
                        $sUnit        = 0;
                        $this->fpdf->SetFont($this->font, '', 7);
                        $lb           = $sort['Laenderblock'];
                    }
                    //Start
                    //Zeile in Tabelle
                    $OST = $this->getOSTotal($sort);
                    if ($sort['menge'] > 0 or ( $sort['hasOSSizeSort'] and $OST)) {
                        //if ($sort['menge'] > 0) {
                        // echo("<pre>OSTotal: $OST");
                        // var_dump($sort);
                        $startx      = $this->fpdf->getX();
                        $starty      = $this->fpdf->getY();
                        $xcellheight = $startcellheight;
                        $x           = $startx;
                        $this->fpdf->setXY($x, $starty);
                        $header = strlen($sort['header']) > 0 ? $sort['header'] : "";
                        $header = strlen($header) >= 18 ? substr($header, 0, 18) . "##"
                                    : $header;
                        $this->MultiCellSave($w[0], $startcellheight, utf8_decode($header), 'LTBR');
                        $x      += $w[0];
                        $this->fpdf->setXY($x, $starty);
                        $design = strlen($sort['translate_design']) > 0 ? $sort['translate_design']
                                    : $sort['design'];
                        $saveX = $x;
                        $saveY = $starty;
                        $this->fpdf->SetTextColor(1);
                        $this->MultiCellSave($w[1], $startcellheight, utf8_decode($design), '');
                        $this->fpdf->setXY($saveX, $saveY);
                        $this->fpdf->SetTextColor(255);
                        $this->MultiCellSave($w[1], $startcellheight, utf8_decode($header), 'LTBR');
                        $this->fpdf->SetTextColor(1);
                        $xcellheight = $this->fpdf->getY() - $starty;
                        $this->fpdf->setXY($saveX, $saveY);
                        $this->MultiCellSave($w[1], $startcellheight, utf8_decode($design), '');
                        $x += $w[1];
                        $this->fpdf->setXY($x, $starty);
                        if (!$sort['hasOSSizeSort']) {
                            //echo('Ja4a');
                            //echo($sort['Laenderblock']."Ohne<br>");
                            $this->MultiCellSave($w[2], $xcellheight, number_format($sort['menge'], 0) . "", 'LBTR', 'C');
                            $x     += $w[2];
                            $this->fpdf->setXY($x, $starty);
                            $ean   = "";
                            //EAN im Ausdruck unterdrücken
                            //$ean = $sort['EAN'];
                            $this->MultiCellSave($w[3], $xcellheight, $ean, 'LBTR');
                            $this->fpdf->Ln(0);
                            $sUnit += $sort['menge'];
                        }
                        else {
                            $this->fpdf->Ln(0);
                            //$sUnit += $sort['menge'];
                            $startx     = $this->fpdf->getX();
                            $starty     = $this->fpdf->getY();
                            $amenge[-1] = $sort['menge'];
                            //echo($sort['Laenderblock']."<br>");
                            //echo("<pre>");
                            //var_dump($amenge);
                            for ($i = 0; $i <= $max; $i++) {
                                $sizeTotal = true;
                                if ($amenge[$i] != 0) {
                                    $j           = $i + 1;
                                    $x           = $startx;
                                    $this->fpdf->setXY($x, $starty);
                                    $this->MultiCellSave($w[0], $startcellheight, "", 'LTBR');
                                    $x           += $w[0];
                                    $this->fpdf->setXY($x, $starty);
                                    $this->MultiCellSave($w[1], $startcellheight, "", 'LTBR');
                                    $xcellheight = $this->fpdf->getY() - $starty;
                                    $x           += $w[1];
                                    $this->fpdf->setXY($x, $starty);
                                    $s           = utf8_decode($sizes[$j]);
                                    //  echo($s."<br>");
                                    if (strpos($s, "tyle") !== false) {
                                        $s = "";
                                    }
                                    $this->MultiCellSave($w[2] / 4 * 3, $xcellheight, $s, 'LBTR', 'L');
                                    $x   += $w[2] / 4 * 3;
                                    $this->fpdf->setXY($x, $starty);
                                    //if ($i == 0) $mengex = $sort['menge']; else $mengex = $amenge[$i-1];
                                    $this->MultiCellSave($w[2] / 4, $xcellheight, number_format($amenge[$i], 0) . " ", 'LBTR', 'R');
                                    $x   += $w[2] / 4;
                                    $this->fpdf->setXY($x, $starty);
                                    $ean = "";
                                    //$ean = $eans[$j];
                                    $this->MultiCellSave($w[3], $xcellheight, $ean, 'LBTR');
                                    $this->fpdf->Ln(0);
                                    $startx = $this->fpdf->getX();
                                    $starty = $this->fpdf->getY();
                                    $sUnit += $amenge[$i];
                                }
                            }
                        }
                    }
                }
                if (false and $print and $sort['hasOSSizeSort']) {
                    $this->fpdf->SetFillColor(255, 75, 0);
                    $this->CellSave($w[0], $cellheight, '', 'LTRB', 0, 'L', 1);
                    $this->CellSave($w[1], $cellheight, '', 'LTRB', 0, 'L', 1);
                    $this->CellSave($w[2], $cellheight, "" . number_format($sUnit, 0, ',', '.') . " ", 'LTRB', 0, 'C', 1);
                    $this->CellSave($w[3], $cellheight, '', 'LTRB', 0, 'R', 1);
                    $this->fpdf->Ln(10);
                    $sUnit = 0;
                    $this->fpdf->SetFont($this->font, '', 10);
                }
            }
            $cellheight = 6;
            if (True) {
                $this->fpdf->SetFillColor(255, 75, 0);
                $this->CellSave($w[0], $cellheight, 'Total units per carton', 'LTRB', 0, 'L', 1);
                $this->CellSave($w[1], $cellheight, '', 'LTRB', 0, 'L', 1);
                if ($sizeTotal) {
                    $this->CellSave($w[2] / 4 * 3, $cellheight, "", 'LTRB', 0, 'C', 1);
                    $this->CellSave($w[2] / 4, $cellheight, "" . number_format($sUnit, 0, ',', '.') . " ", 'LTRB', 0, 'R', 1);
                }
                else {
                    $this->CellSave($w[2], $cellheight, "" . number_format($sUnit, 0, ',', '.') . " ", 'LTRB', 0, 'R', 1);
                }
                $this->CellSave($w[3], $cellheight, '', 'LTRB', 0, 'R', 1);
                $this->fpdf->Ln(10);
                $this->fpdf->SetFont($this->font, '', 10);
            }
            if ($this->fpdf->getY() > 240) {
                $this->_NewPage();
                $this->fpdf->SetFont($this->font, '', 7);
            }
            if (isset($sorts[$id])) {
                $sort = $sorts[$id];
            }
            if ($sort['hasOSSizeSort']) {
                //echo("A");
                //print_r($sort['Laenderblock']);
                if (strpos($sort['Laenderblock'], "OS") !== false) {
                    //echo('AB');
                    //$osmengen   = $this->pc->getMengeOS($pp->PPProduktpass_Id, $sort['Laenderblock']);
                    //print_r($sort['Laenderblock'] . "  -> " . $pp->PPProduktpass_Id);
                    //$this->ddx($osmengen);
                    //if ($osmengen[0]['Status'] == 1) {
                    //echo('AC');
                    $this->osES = true;
                    include ("incOSSizeSortierungNeu.php");
                    $this->osES = false;
                    include ("incOSSizeSortierungNeu.php");
                    //}
                } //include ("incOSSortierung.php");
            }
            else {
                //echo("B");
                //include ("incOSSortierung.php");
                $this->osES = true;
                include ("incOSSizeSortierungNeu.php");
                $this->osES = false;
                include ("incOSSizeSortierungNeu.php");
            }
            //exit;
            $this->fpdf->Ln();
            //Ende OS Sortierungen
            //Nur andere als BW
            $cMengen = $this->pc->getLieferlaender($pp->PPProduktpass_Id);
            foreach ($cMengen as $menge) {
                $cMenge[$menge['Country']] = number_format($menge['sumCountry'], 0, ',', '.');
            }
            $filla = 1;
            $fillb = 0;
            if (!$bw) {
                $this->_NewPage();
                $this->fpdf->SetFont($this->font, 'B', 10);
                $this->CellSave(0, $this->lh, 'Quantities/Countries  for PJN: ' . $pp->PPProduktpass_IAN, 'B', 0, 'L');
                $this->fpdf->Ln(5);
                $w1 = 20;
                $w2 = 15;
                $this->fpdf->SetFont($this->font, '', 7);
                $this->fpdf->SetTextColor(1, 1, 1);
                $this->CellSave(5 * ($w1 + $w2), 7, 'Quantity/Country in SU (sales unit)', 1, 0, 'L', 1);
                $this->fpdf->Ln();
                /* $countries1[0] = array('DE','GB','ES','HR');
                  $countries1[1] = array('AT','IE','IT','RO');
                  $countries1[2] = array('CH','FI','MT','BG');
                  $countries1[3] = array('','SE','PT','GR');
                  $countries1[4] = array('',  'DK','',  'CY');
                  $countries1[5] = array('',  'BE','',  '');
                  $countries1[6] = array('',  'NL','',  '');
                  LB 1: DE, AT, CH
                  LB 3: FI, SE, PL, LT
                  LB 5: ES, IT, PT
                  LB 7: HR, RO, BG, GR, CY
                 */
                $countries1[0] = array('DE', 'FI', 'ES', 'HR', 'US');
                $countries1[1] = array('AT', 'SE', 'IT', 'RO', '');
                $countries1[2] = array('CH', 'PL', 'PT', 'BG', '');
                $countries1[3] = array('', 'LT', 'OSES', 'GR', '');
                $countries1[4] = array('', 'EE', 'MT', 'CY', '');
                $countries1[5] = array('', 'LV', '', 'RS', '');
                //$countries1[5] = array('',  '','',  '');
                //$countries1[6] = array('',  '','',  '');
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(($w1 + $w2), 7, 'LB1', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB3', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB5', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB7', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB9', 1, 0, 'C', 1);
                $this->fpdf->Ln();
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->fpdf->Ln();
                $cMengen = $this->pc->getLieferlaender($pp->PPProduktpass_Id);
                foreach ($cMengen as $menge) {
                    $cMenge[$menge['Country']] = number_format($menge['sumCountry'], 0, ',', '.');
                }
                //var_dump($cMenge);exit;
                $this->fpdf->SetFillColor(235, 235, 235);
                foreach ($countries1 as $row) {
                    $this->CellSave($w1, 5, $row[0], 1, 0, 'C', $filla);
                    if (isset($cMenge[$row[0]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[0]], 1, 0, 'R', $filla);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $filla);
                    }
                    $this->CellSave($w1, 5, $row[1], 1, 0, 'C', $fillb);
                    if (isset($cMenge[$row[1]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[1]], 1, 0, 'R', $fillb);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $fillb);
                    }
                    $this->CellSave($w1, 5, $row[2], 1, 0, 'C', $filla);
                    if (isset($cMenge[$row[2]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[2]], 1, 0, 'R', $filla);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $filla);
                    }
                    $this->CellSave($w1, 5, $row[3], 1, 0, 'C', $fillb);
                    if (isset($cMenge[$row[3]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[3]], 1, 0, 'R', $fillb);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $fillb);
                    }
                    $this->CellSave($w1, 5, $row[4], 1, 0, 'C', $filla);
                    if (isset($cMenge[$row[4]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[4]], 1, 0, 'R', $filla);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $filla);
                    }
                    $this->fpdf->Ln();
                }
                $this->CellSave($w1 + $w2, 5, 'Country-block-symbol', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'Country-block-symbol', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'Country-block-symbol', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'Country-block-symbol', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'Country-block-symbol', 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->CellSave($w1 + $w2, 5, 'Square', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'L-shape', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'Star', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'Parallelogram', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'Hexagon', 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Square.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_L-shape.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Star.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Parallelogram.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Hexagon.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->fpdf->Ln();
                //$this->fpdf->Ln(12);
                /*
                  LB 2: FR
                  LB 4: HU, SI, CZ, SK
                  LB 6: GB, IE, DK, BE, NL
                  LB 8: OS DE, OS BE, OS NL
                 */
                // CB10-KDE,CB10-KPL,CB10-KCZ,CB10-KRO,CB10-KSK,CB10-KHR,CB10-KBG,CB10-KODE
                $countries2[0] = array('FR', 'CZ', 'GB', 'OSDE', 'KDE');
                $countries2[1] = array('', 'SK', 'BE', 'OSBE', 'KPL');
                $countries2[2] = array('', 'HU', 'IE', 'OSNL', 'KCZ');
                $countries2[3] = array('', 'SI', 'DK', 'OSCZ', 'KRO');
                $countries2[4] = array('', '', 'NL', 'OSGB', 'KSK');
                $countries2[5] = array('', '', 'NI', 'OSFR', 'KHR');
                $countries2[6] = array('', '', '', 'OSPL', 'KBG');
                $countries2[7] = array('', '', '', 'OSSK', 'KODE');
                $countries2[8] = array('', '', '', 'OSAT', '');
                $countries2[9] = array('', '', '', 'OSDK', '');
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(($w1 + $w2), 7, 'LB2', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB4', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB6', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB8', 1, 0, 'C', 1);
                $this->CellSave(($w1 + $w2), 7, 'LB10', 1, 0, 'C', 1);
                $this->fpdf->Ln();
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->CellSave($w1, 5, 'Country', 1, 0, 'C', $filla);
                $this->CellSave($w2, 5, 'Quantity', 1, 0, 'R', $filla);
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(235, 235, 235);
                foreach ($countries2 as $row) {
                    $this->CellSave($w1, 5, $row[0], 1, 0, 'C', $filla);
                    if (isset($cMenge[$row[0]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[0]], 1, 0, 'R', $filla);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $filla);
                    }
                    $this->CellSave($w1, 5, $row[1], 1, 0, 'C', $fillb);
                    if (isset($cMenge[$row[1]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[1]], 1, 0, 'R', $fillb);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $fillb);
                    }
                    $this->CellSave($w1, 5, $row[2], 1, 0, 'C', $filla);
                    if (isset($cMenge[$row[2]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[2]], 1, 0, 'R', $filla);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $filla);
                    }
                    $this->CellSave($w1, 5, $row[3], 1, 0, 'C', $fillb);
                    if (isset($cMenge[$row[3]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[3]], 1, 0, 'R', $fillb);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $fillb);
                    }
                    $this->CellSave($w1, 5, $row[4], 1, 0, 'C', $filla);
                    if (isset($cMenge[$row[4]])) {
                        $this->CellSave($w2, 5, $cMenge[$row[4]], 1, 0, 'R', $filla);
                    }
                    else {
                        $this->CellSave($w2, 5, '', 1, 0, 'R', $filla);
                    }
                    $this->fpdf->Ln();
                }
                $this->CellSave($w1 + $w2, 5, 'country-block-symbol', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'country-block-symbol', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'country-block-symbol', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'country-block-symbol', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'country-block-symbol', 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->CellSave($w1 + $w2, 5, 'Circle', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'Triangle', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, 'Semi-circle', 1, 0, 'C', $filla);
                $this->CellSave($w1 + $w2, 5, 'Double bar', 1, 0, 'C', $fillb);
                $this->CellSave($w1 + $w2, 5, '', 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Circle.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Triangle.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Semi-circle.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/new_Double-bar.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->CellSave($w1 + $w2, 12, '', 1, 0, 'C', $fillb);
                $this->fpdf->Image(storage_path() . "/images/PO/empty.jpg", $this->fpdf->getX() - 25, $this->fpdf->getY() + 2, 0, 8);
                $this->fpdf->Ln(15);
                //*************  Hafenmengen
                //$this->_NewPage();
                $this->fpdf->SetFont($this->font, 'B', 10);
                $this->fpdf->SetTextColor(1, 1, 1);
                // $this->fpdf->Ln();
                //$this->fpdf->SetXY($this->leftmargin,30);
                $this->CellSave(0, $this->lh, 'Quantity / POD', 'B', 0, 'L');
                $this->fpdf->Ln(5);
                $width[1] = 25;
                $width[2] = 16;
                $width[3] = 25;
                $width[4] = 25;
                $width[5] = 25;
                $width[6] = 25;
                $width[7] = 25;
                $sign[1]  = array('cb' => 'LB 1', 'sign' => 'new_Square.jpg');
                $sign[2]  = array('cb' => 'LB 2', 'sign' => 'new_Circle.jpg');
                $sign[3]  = array('cb' => 'LB 3', 'sign' => 'new_L-shape.jpg');
                $sign[4]  = array('cb' => 'LB 4', 'sign' => 'new_Triangle.jpg');
                $sign[5]  = array('cb' => 'LB 5', 'sign' => 'new_Star.jpg');
                $sign[6]  = array('cb' => 'LB 6', 'sign' => 'new_Semi-circle.jpg');
                $sign[7]  = array('cb' => 'LB 7', 'sign' => 'new_Parallelogram.jpg');
                $sign[8]  = array('cb' => 'LB 8', 'sign' => 'new_Double-bar.jpg');
                $sign[9]  = array('cb' => 'LB 9', 'sign' => 'new_Hexagon.jpg');
                $sign[10] = array('cb' => 'LB 10', 'sign' => 'new_Hexagon.jpg');
                $hmlb = $this->pc->getHafenMengenLB($pp->PPProduktpass_Id);
                if (count($hmlb) > 0) {
                    $this->fpdf->SetFont($this->font, '', 8);
                    $this->fpdf->SetTextColor(1, 1, 1);
                    $this->fpdf->SetFillColor(220, 180, 0);
                    $this->CellSave($width[1] + $width[2] + $width[3] + $width[4] + $width[5] + $width[6] + $width[6], 5, 'Quantity / POD in SU (sales unit)         PU:' . number_format($hmlb[1]['Kolli'], 0), 1, 0, 'L', $filla);
                    $this->fpdf->Ln();
                    $this->CellSave($width[1], 5, 'Country block', 1, 0, 'L', $filla);
                    $this->CellSave($width[2], 5, 'Symbol', 1, 0, 'C', $filla);
                    $this->CellSave($width[3], 5, 'Qty. Rotterdam ', 1, 0, 'R', $filla);
                    $this->CellSave($width[4], 5, 'Qty. Barcelona ', 1, 0, 'R', $filla);
                    $this->CellSave($width[5], 5, 'Qty. Koper ', 1, 0, 'R', $filla);
                    $this->CellSave($width[7], 5, 'Qty. USA ', 1, 0, 'R', $filla);
                    $this->CellSave($width[6], 5, 'Total ', 1, 0, 'R', $filla);
                    $this->fpdf->Ln();
                    $this->fpdf->SetFont($this->font, '', 10);
                    $this->fpdf->SetFillColor(255, 255, 255);
                    ksort($hmlb);
                    $totalcb  = 0;
                    $totalR   = 0;
                    $totalB   = 0;
                    $totalK   = 0;
                    $totalUSA = 0;
                    $hafenAuftreilung = $this->pc->getHafenaufteilung($pp->PPProduktpass_Id);
                    //echo ("<pre>");
                    //var_dump($hafenAuftreilung);
                    //exit;
                    foreach ($hmlb as $key => $value) {
                        $vRotterdam = isset($value['Rotterdam']) ? $value['Rotterdam']
                                    : 0;
                        $vBarcelona = isset($value['Barcelona']) ? $value['Barcelona']
                                    : 0;
                        $vKoper     = isset($value['Koper']) ? $value['Koper'] : 0;
                        $vUSA       = isset($value['USA']) ? $value['USA'] : 0;
                        $totalR   += $vRotterdam;
                        $totalB   += $vBarcelona;
                        $totalK   += $vKoper;
                        $totalUSA += $vUSA;
                        $totalcb  = $vRotterdam + $vBarcelona + $vKoper + $vUSA;
                        $lml = $this->pc->getMengeLand($pp->PPProduktpass_Id, "IT");
                        //echo("<pre>");var_dump($lml); exit;
                        if ($totalcb > 0) {
                            if ($value['LB'] == 2) {
                                $this->CellSave($width[1], 6, $sign[$value['LB']]['cb'] . " FR", 1, 0, 'L', $filla);
                                $this->CellSave($width[2], 6, '', 1, 0, 'C', $filla);
                                $this->fpdf->Image(storage_path() . "/images/PO/" . $sign[$value['LB']]['sign'], $this->fpdf->getX() - 14, $this->fpdf->getY() + 1, 0, 4);
                                $this->CellSave($width[3] - 15, 6, $hafenAuftreilung['FRRTD'] . "%", 1, 0, 'R', $filla);
                                $this->CellSave($width[3] - 10, 6, number_format($vRotterdam, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[4] - 15, 6, $hafenAuftreilung['FRBAR'] . "%", 1, 0, 'R', $filla);
                                $this->CellSave($width[4] - 10, 6, number_format($vBarcelona, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[5], 6, number_format($vKoper, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[7], 6, "0", 1, 0, 'R', $filla);
                                $this->CellSave($width[6], 6, number_format($totalcb, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->fpdf->Ln();
                            }
                            if ($value['LB'] == 5) {
                                //$this->CellSave($width[1],6,$sign[$value['LB']]['cb']."IT",1,0,'L',$filla);
                                $mengenESPT = $this->pc->getMengeLand($pp->PPProduktpass_Id, "ES")['Menge'];
                                $mengenESPT += $this->pc->getMengeLand($pp->PPProduktpass_Id, "OSES")['Menge'];
                                $mengenESPT += $this->pc->getMengeLand($pp->PPProduktpass_Id, "PT")['Menge'];
                                $mengenIT   = $this->pc->getMengeLand($pp->PPProduktpass_Id, "IT")['Menge'];
                                /*                                 * ************ */
                                $iMengeKoper     = round($hafenAuftreilung['ITKOP'] / 100 * $mengenIT);
                                $iMengeBarcelona = $mengenIT - $iMengeKoper;
                                $ikolli          = $this->pc->getMengeLand($pp->PPProduktpass_Id, "IT")['VE'];
                                if ($iMengeKoper % $ikolli) {
                                    $irest           = $iMengeKoper % $ikolli;
                                    $diff            = $ikolli - $irest;
                                    //$diff = $rest;
                                    $iMengeKoper     = $iMengeKoper + $diff;
                                    $iMengeBarcelona = $iMengeBarcelona - $diff;
                                }
                                /*                                 * ************ */
                                $this->CellSave($width[1] - 12, 6, $sign[$value['LB']]['cb'], 1, 0, 'L', $filla);
                                $this->CellSave($width[1] - 13, 6, "ES/PT", 1, 0, 'L', $filla);
                                $this->CellSave($width[2], 6, '', 1, 0, 'C', $filla);
                                $this->fpdf->Image(storage_path() . "/images/PO/" . $sign[$value['LB']]['sign'], $this->fpdf->getX() - 14, $this->fpdf->getY() + 1, 0, 4);
                                $this->CellSave($width[3], 6, number_format(0, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[4], 6, number_format($mengenESPT, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[5], 6, number_format(0, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[7], 6, number_format(0, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[6], 6, number_format($mengenESPT, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->fpdf->Ln();
                                $this->CellSave($width[1] - 12, 6, "0", "LRB", 0, 'L', $filla);
                                $this->CellSave($width[1] - 13, 6, "IT", 1, 0, 'L', $filla);
                                //$this->fpdf->Image(storage_path()."/images/PO/".$sign[$value['LB']]['sign'], $this->fpdf->getX()-14,$this->fpdf->getY()+1,0,4);
                                $this->CellSave($width[2], 6, "", 1, 0, 'R', $filla);
                                $this->CellSave($width[3], 6, number_format(0, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[4] - 15, 6, $hafenAuftreilung['ITBAR'] . "%", 1, 0, 'R', $filla);
                                $this->CellSave($width[4] - 10, 6, number_format($iMengeBarcelona, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[5] - 15, 6, $hafenAuftreilung['ITKOP'] . "%", 1, 0, 'R', $filla);
                                $this->CellSave($width[5] - 10, 6, number_format($iMengeKoper, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[7], 6, "0", 1, 0, 'R', $filla);
                                $this->CellSave($width[6], 6, number_format($mengenIT, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->fpdf->Ln();
                            }
                            if ($value['LB'] != 5 and $value['LB'] != 2) {
                                //var_dump($value);
                                //exit;
                                $this->CellSave($width[1], 6, $sign[$value['LB']]['cb'], 1, 0, 'L', $filla);
                                $this->CellSave($width[2], 6, '', 1, 0, 'C', $filla);
                                $this->fpdf->Image(storage_path() . "/images/PO/" . $sign[$value['LB']]['sign'], $this->fpdf->getX() - 14, $this->fpdf->getY() + 1, 0, 4);
                                $this->CellSave($width[3], 6, number_format($vRotterdam, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[4], 6, number_format($vBarcelona, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[5], 6, number_format($vKoper, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[7], 6, number_format($vUSA, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->CellSave($width[6], 6, number_format($totalcb, 0, ',', '.'), 1, 0, 'R', $filla);
                                $this->fpdf->Ln();
                            }
                        }
                    }
                    $this->fpdf->SetFillColor(220, 180, 0);
                    $this->CellSave($width[1], 6, 'Overall Total', 1, 0, 'L', $filla);
                    $this->CellSave($width[2], 6, '', 1, 0, 'C', $filla);
                    $this->CellSave($width[3], 6, number_format($totalR, 0, ',', '.'), 1, 0, 'R', $filla);
                    $this->CellSave($width[4], 6, number_format($totalB, 0, ',', '.'), 1, 0, 'R', $filla);
                    $this->CellSave($width[5], 6, number_format($totalK, 0, ',', '.'), 1, 0, 'R', $filla);
                    $this->CellSave($width[7], 6, number_format($totalUSA, 0, ',', '.'), 1, 0, 'R', $filla);
                    $this->CellSave($width[6], 6, number_format($totalR + $totalB + $totalK + $totalUSA, 0, ',', '.'), 1, 0, 'R', $filla);
                    $this->fpdf->Ln();
                }
                $this->fpdf->Ln(20);
                $this->fpdf->SetFillColor(255, 255, 255);
            }
            if ($this->fpdf->getY() > 180) {
                $this->_NewPage();
            }
            if (isset($cMenge['CH']) and $cMenge['CH'] > 0) {
                $lwhd = $this->pc->getWarehouseLaenderaufteilung($pp->PPProduktpass_Id);
                $this->fpdf->SetFont($this->font, 'B', 10);
                $this->fpdf->SetTextColor(1, 1, 1);
                $this->CellSave(0, $this->lh, 'Special Distribution (Kolli per Warehouse)', 'B', 0, 'L');
                $this->fpdf->Ln(10);
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(30, 6, 'Country', 1, 0, 'C', $filla);
                $this->CellSave(40, 6, 'Warehouse', 1, 0, 'L', $filla);
                $this->CellSave(40, 6, 'Quantity', 1, 0, 'R', $filla);
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(255);
                $this->fpdf->SetFont($this->font, '', 10);
                foreach ($lwhd as $lhd) {
                    $this->CellSave(30, 6, $lhd->PPLaenderaufteilung_Land, 1, 0, 'C', $filla);
                    $this->CellSave(40, 6, $lhd->PPLaenderaufteilung_Warehouse, 1, 0, 'L', $filla);
                    $this->CellSave(40, 6, $lhd->PPLaenderaufteilung_Menge_Kollies, 1, 0, 'R', $filla);
                    $this->fpdf->Ln();
                }
                $this->fpdf->Ln(20);
            }
            $container = PPAB::where("PPAB_PPProduktpass_Id", "=", $pp->PPProduktpass_Id)->get()->first();
            if ($container) {
                if ($this->fpdf->getY() > 200) {
                    $this->_NewPage();
                }
                $this->_header1("Container", false);
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(30, 6, "", 1, 0, 'C', $filla);
                $this->CellSave(30, 6, "HC", 1, 0, 'C', $filla);
                $this->CellSave(30, 6, "40''", 1, 0, 'C', $filla);
                $this->CellSave(30, 6, "20''", 1, 0, 'C', $filla);
                $this->CellSave(30, 6, "Total Cts.", 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(30, 6, 'Rotterdam', 1, 0, 'C', $filla);
                $this->fpdf->SetFillColor(255);
                $this->CellSave(30, 6, number_format($container->PPAB_CD11, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD12, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD13, 0), 1, 0, 'C', $filla);
                $summe = $container->PPAB_CD11 + $container->PPAB_CD12 + $container->PPAB_CD13;
                $hm    = $this->pc->getMengeHafen($pp->PPProduktpass_Id, "Rotterdam");
                $this->CellSave(30, 6, number_format($hm["VE"], 0), 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(30, 6, 'Barcelona', 1, 0, 'C', $filla);
                $this->fpdf->SetFillColor(255);
                $this->CellSave(30, 6, number_format($container->PPAB_CD21, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD22, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD23, 0), 1, 0, 'C', $filla);
                $summe = $container->PPAB_CD21 + $container->PPAB_CD22 + $container->PPAB_CD23;
                $hm    = $this->pc->getMengeHafen($pp->PPProduktpass_Id, "Barcelona");
                $this->CellSave(30, 6, number_format($hm["VE"], 0), 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(30, 6, 'Koper', 1, 0, 'C', $filla);
                $this->fpdf->SetFillColor(255);
                $this->CellSave(30, 6, number_format($container->PPAB_CD31, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD32, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD33, 0), 1, 0, 'C', $filla);
                $summe = $container->PPAB_CD31 + $container->PPAB_CD32 + $container->PPAB_CD33;
                $hm    = $this->pc->getMengeHafen($pp->PPProduktpass_Id, "Koper");
                $this->CellSave(30, 6, number_format($hm["VE"], 0), 1, 0, 'C', $filla);
                $this->fpdf->Ln();
                $this->fpdf->SetFillColor(220, 180, 0);
                $this->CellSave(30, 6, 'Richmond', 1, 0, 'C', $filla);
                $this->fpdf->SetFillColor(255);
                $this->CellSave(30, 6, number_format($container->PPAB_CD41, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD42, 0), 1, 0, 'C', $filla);
                $this->CellSave(30, 6, number_format($container->PPAB_CD43, 0), 1, 0, 'C', $filla);
                $summe = $container->PPAB_CD41 + $container->PPAB_CD42 + $container->PPAB_CD43;
                $hm    = $this->pc->getMengeHafen($pp->PPProduktpass_Id, "Richmond");
                $this->CellSave(30, 6, number_format($hm["VE"], 0), 1, 0, 'C', $filla);
                $this->fpdf->Ln(20);
            }
            $sis = $this->pc->getStyles($pp->PPProduktpass_Id);
            if (count($sis) > 1) {
                $this->_NewPage();
                $this->_header1("Annexe", false);
                $this->fpdf->Ln(5);
                $imageHeight = 35;
                foreach ($sis as $si) {
                    if (strlen($si['Image']) > 3) {
                        $image_file = public_path() . "/data/uploads/" . $si['Image'];
                        $this->fpdf->Image($image_file, $this->fpdf->getX() + 5, $this->fpdf->getY(), 0, $imageHeight);
                        $this->fpdf->Ln($imageHeight + 5);
                        $this->_header2($si['Style']);
                        $this->fpdf->Ln(5);
                    }
                }
                $this->_NewPage();
            }
        }
// bis hier wiederholen
//************************************************************************************************
        if ($purchase->PPPurchase_TermsOfDelivery != 3) {
            if ($this->fpdf->getY() > 180) {
                $this->_NewPage();
            }
            $this->fpdf->SetFont($this->font, 'B', 10);
            $str = $this->_getText('TextNotifyer');
            $this->MultiCellSave(0, $this->lh, $str, 0, 'L');
        }
        $this->_NewPage();
        $this->fpdf->SetFont($this->font, 'B', 12);
        $this->fpdf->SetTextColor(1, 1, 1);
        $this->fpdf->SetXY($this->leftmargin, 30);
        $this->fpdf->SetFont($this->font, 'B', 10);
        $str = "Only for below named countries you have to follow the below given instructions.";
        $this->MultiCellSave(0, $this->lh, $str, 0, 'L');
        $this->fpdf->Ln($this->lh);
        $auz  = $this->getUZ($pp->PPProduktpass_Id, $pp->PPProduktpass_PPProjekte_Projekt);
        $uz   = $auz['UZ'];
        $uzrs = $auz['UZRS'];
        $strconsignee = " invoice, packing list ";
        if (strtoupper($uz) != 'NEIN') {
            $str          = "General Clause: For Switzerland we need an extra " . $uz . " + packing list + invoice document.";
            $strconsignee .= " and  " . $uz;
            $this->MultiCellSave(0, $this->lh, $str, 0, 'L');
            $this->fpdf->Ln();
        }
        if (strtoupper($uzrs) != 'NEIN') {
            $str          = "General Clause: For Republic of Serbia we need an extra " . $uzrs . " + packing list + invoice document.";
            $strconsignee .= " and  " . $uzrs;
            $this->MultiCellSave(0, $this->lh, $str, 0, 'L');
            $this->fpdf->Ln();
        }
        $this->fpdf->SetFont($this->font, '', 10);
        $transportdok1 = $purchase->PPPurchase_Transportdokumente;
        $transportdok2 = $purchase->PPPurchase_Transportdokumente2;
        $str = $this->_getText('TextConsignee', "%UZ%", $strconsignee);
        $str = str_replace("%TRANSPORT1%", $transportdok1, $str);
        $str = str_replace("%TRANSPORT2%", $transportdok2, $str);
        $this->MultiCellSave(0, $this->lh, $str, 0, 'L');
        //$this->fpdf->Ln($this->lh);
        $this->fpdf->SetFont($this->font, 'B', 10);
        $this->fpdf->SetTextColor(244, 0, 0);
        $str = "In case of not following this instruction Targa has the right - independently of the right to claim compensation - to charge a penalty fee of 500 EUR per false issued document, except the breach of duty was not culpably. The contractual penalty paid will be credited to any potential compensation claim.";
        $this->MultiCellSave(0, $this->lh, $str, 0, 'L');
        //$this->fpdf->Ln($this->lh);
        //Mengen text einf�gen
        $quantities_to_deliver = '';
        $i                     = 1;
        foreach ($total_array as $q) {
            $quantities_to_deliver .= '     ' . $i . '.  ' . $q['IAN'] . '   TOTAL: ' . number_format($q['Total'], 0, ',', '.') . ' Units
';
            $i++;
        }
        //$this->_NewPage();
        $this->fpdf->Ln(5);
        $this->_kapitel($this->_getText('HeaderK2'), $this->_getText('TextK2', '%MengenText%', $quantities_to_deliver));
        if ($this->fpdf->GetY() > 180) {
            $this->_NewPage();
        }
        $this->_kapitel($this->_getText('HeaderK3'), $this->_getText('TextK3', '%TOD%', $sToD));
        //$this->_NewPage();
        $this->fpdf->Ln($this->lh);
        $deltext = "" . $sToD . "
";
        if (strlen($purchase->PPPurchase_FOBSpecial) > 4) {
            $deltext .= $purchase->PPPurchase_FOBSpecial;
            $deltext .= "
";
        }
        $delport = "";
        if (strpos($PoD, "Bitte") === false) {
            $delport = 'Delivery to Port ' . $PoD . ' ';
        }
        $t4 = 'TextK4';
        if ($purchase->PPPurchase_DeliveryFrom != 'N.N.') {
            $t4 .= $purchase->PPPurchase_DeliveryFrom;
        }
        $deltext            .= $this->_getText($t4, '%FixDates%', $delport . 'Calenderweek ' . $DeliveryDate);
        $temp_textA         = $this->_getTextA($t4);
        $temp_textA['text'] = $deltext;
        $this->_kapitel($this->_getText('HeaderK4'), $deltext, $temp_textA);
        $this->fpdf->Ln($this->lh);
        //$this->_kapitel($this->_getText('HeaderK5'), $this->_getText('TextK5'));
        if ($this->fpdf->GetY() > 180) {
            $this->_NewPage();
        }
        if ($this->_header1($this->_getText('HeaderK5'))) {
            $this->fpdf->Ln();
            $oTable = new PdfTable($this->fpdf);
            $oTable->initialize(array(30, 40, 40, 40));
            $tab_bg_color = array(220, 220, 220);
            $tab_color    = array(80, 80, 80);
            $iCol                                 = 0;
            $aHeader [$iCol] ['TEXT']             = "Articlenumber";
            $aHeader [$iCol] ['TEXT_COLOR']       = $tab_color;
            $aHeader [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            $aHeader [$iCol] ['PADDING_RIGHT']    = 2;
            $iCol++;
            $aHeader [$iCol] ['TEXT']             = "Quantity per Unit";
            $aHeader [$iCol] ['TEXT_COLOR']       = $tab_color;
            $aHeader [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            $aHeader [$iCol] ['PADDING_RIGHT']    = 2;
            $aHeader [$iCol] ['TEXT_ALIGN']       = 'R';
            if (!$bw) {
                $iCol++;
                $aHeader [$iCol] ['TEXT']             = "Price per Unit (" . $purchase->PPPurchase_Currency . ")";
                $aHeader [$iCol] ['TEXT_COLOR']       = $tab_color;
                $aHeader [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
                $aHeader [$iCol] ['PADDING_RIGHT']    = 2;
                $aHeader [$iCol] ['TEXT_ALIGN']       = 'R';
            }
            $iCol++;
            $aHeader [$iCol] ['TEXT']             = "Total amount (" . $purchase->PPPurchase_Currency . ")";
            $aHeader [$iCol] ['TEXT_COLOR']       = $tab_color;
            $aHeader [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            $aHeader [$iCol] ['PADDING_RIGHT']    = 2;
            $aHeader [$iCol] ['TEXT_ALIGN']       = 'R';
            $oTable->addHeader($aHeader); //mehrfach f�r meherer Kopfzeilen
            $aRow = array();
            $tot_total_quantity = 0;
            $tot_total_price    = 0;
            foreach ($apps as $app1) {
            //'PPProduktpass_Menge_Country as Country, PPProduktpass_Menge_CountryBlock as CountryBlock,PPProduktpass_Menge_Quantity as Menge, PPProduktpass_Menge_CBEK as CBEK, PPProduktpass_Menge_EKUSD as EK'
                $prices = $this->pc->getPrices($app1['PPProduktpass_Id']);
                $total_quantity = 0;
                $total_price    = 0;
                foreach ($prices['LaenderEK'] as $country) {
                    //var_dump($country);
                    $total_quantity += $country['Menge'];
                    $total_price    += $country['Menge'] * $country['EK'];
                }
                $middle_EK = 0;
                if ($total_quantity != 0) {
                    $middle_EK = $total_price / $total_quantity;
                }
                if ($prices['EK'] != 0) {
                    $EK          = $prices['EK'];
                    $mixedPrices = "";
                } else {
                    $EK          = $middle_EK;
                    $mixedPrices = "*";
                }
                $iCol                        = 0;
                $aRow [$iCol] ['TEXT']       = $app1['PPProduktpass_IAN'];
                $aRow [$iCol] ['TEXT_SIZE']  = 9;
                $aRow [$iCol] ['TEXT_ALIGN'] = 'C';
                $iCol++;
                $tot_total_quantity             += $total_quantity;
                $aRow [$iCol] ['TEXT']          = number_format($total_quantity, 0, ',', '.');
                $aRow [$iCol] ['TEXT_SIZE']     = 9;
                $aRow [$iCol] ['TEXT_ALIGN']    = 'R';
                $aRow [$iCol] ['PADDING_RIGHT'] = 2;
                if (!$bw) {
                    $iCol++;
                    $aRow [$iCol] ['TEXT']          = $mixedPrices . " " . number_format($EK, 2, ',', '.');
                    $aRow [$iCol] ['TEXT_SIZE']     = 9;
                    $aRow [$iCol] ['TEXT_ALIGN']    = 'R';
                    $aRow [$iCol] ['PADDING_RIGHT'] = 2;
                }
                $iCol++;
                $tot_total_price                += $total_quantity * $EK;
                $aRow [$iCol] ['TEXT']          = number_format($total_quantity * $EK, 2, ',', '.');
                $aRow [$iCol] ['TEXT_SIZE']     = 9;
                $aRow [$iCol] ['TEXT_ALIGN']    = 'R';
                $aRow [$iCol] ['PADDING_RIGHT'] = 2;
                $oTable->addRow($aRow);
            }
            $iCol                              = 0;
            $aRow [$iCol] ['TEXT']             = 'Totals';
            $aRow [$iCol] ['TEXT_SIZE']        = 9;
            $aRow [$iCol] ['TEXT_ALIGN']       = 'C';
            $aRow [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            $iCol++;
            $aRow [$iCol] ['TEXT']             = number_format($tot_total_quantity, 0, ',', '.');
            $aRow [$iCol] ['TEXT_SIZE']        = 9;
            $aRow [$iCol] ['TEXT_ALIGN']       = 'R';
            $aRow [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            //$aRow [2] ['TEXT'] = '* = mixed Prices';
            if (!$bw) {
                $iCol++;
                $aRow [$iCol] ['TEXT']             = '';
                $aRow [$iCol] ['TEXT_SIZE']        = 7;
                $aRow [$iCol] ['TEXT_ALIGN']       = 'R';
                $aRow [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            }
            $iCol++;
            $aRow [$iCol] ['TEXT']             = number_format($tot_total_price, 2, ',', '.');
            $aRow [$iCol] ['TEXT_SIZE']        = 9;
            $aRow [$iCol] ['TEXT_ALIGN']       = 'R';
            $aRow [$iCol] ['BACKGROUND_COLOR'] = $tab_bg_color;
            $oTable->addRow($aRow);
            $oTable->close();
            $this->fpdf->Ln($this->lh * 1.5);
        }
        $repl = "";
        if ($purchase->PPPurchase_IsCommission == 1) {
            $repl = "
    - Commission";
        }
        $this->_absatz($this->_getTextA('TextK5', "%Commission%", $repl));
        $this->_NewPage();
        $top = $this->getTOP($purchase->PPPurchase_TermsOfPayment);
        if ($top == "L/C") {
            $text = "L/C Payment ";
            if (strlen($purchase->PPPurchase_LC_TOP) <= 1 or substr(trim($purchase->PPPurchase_LC_TOP), 0, 1) == 0) {
                $text .= " at sight
after ";
            }
            else {
                $text .= "
" . $purchase->PPPurchase_LC_TOP . " after complete delivery and ";
            }
        }
        else {
            $text = $top;
            $text .= "
" . $purchase->PPPurchase_LC_TOP . " after complete delivery and ";
        }
        $text .= $this->_getText('TextK6');
        $this->_kapitel($this->_getText('HeaderK6'), $text);
        $this->_NewPage();
        $this->_header1($this->_getText('HeaderK7_0'));
        //$this->fpdf->Ln($this->lh);
        $oTable = new PdfTable($this->fpdf);
        $oTable->initialize(array(30, 68, 68));
        $tab_bg_color = array(220, 220, 220);
        $tab_color    = array(80, 80, 80);
        $aHeader [0] ['TEXT']             = "Articlenumber";
        //$aHeader [2] ['COLSPAN'] = 2;
        //$aHeader [2] ['ROWSPAN'] = 2;
        $aHeader [0] ['TEXT_COLOR']       = $tab_color;
        $aHeader [0] ['BACKGROUND_COLOR'] = $tab_bg_color;
        $aHeader [1] ['TEXT']             = "First sampling";
        //$aHeader [2] COLSPAN'] = 2;
        //$aHeader [2] ['ROWSPAN'] = 2;
        $aHeader [1] ['TEXT_COLOR']       = $tab_color;
        $aHeader [1] ['BACKGROUND_COLOR'] = $tab_bg_color;
        $aHeader [2] ['TEXT']             = "Second sampling";
        //$aHeader [2] ['COLSPAN'] = 2;
        //$aHeader [2] ['ROWSPAN'] = 2;
        $aHeader [2] ['TEXT_COLOR']       = $tab_color;
        $aHeader [2] ['BACKGROUND_COLOR'] = $tab_bg_color;
        $oTable->addHeader($aHeader); //mehrfach f�r meherer Kopfzeilen
        $aRow = Array();
        $aRow [0] ['TEXT']      = $ians;
        $aRow [0] ['TEXT_SIZE'] = 9;
        $aRow [1] ['TEXT'] = "Samples for
    1. Creating inlay
    2. Creating flysheet
    3. Production approval
    4. Targa keep samples";
        $aRow [1] ['TEXT_SIZE']  = 9;
        $aRow [1] ['TEXT_ALIGN'] = 'L';
        $aRow [2] ['TEXT']       = "During Production Quality assurance samples
Original cartons with carton marking, inlay, care label, Hang tag, PP-bag and right assortment. Exactly the same as the once which will be delivered to Lidl.";
        $aRow [2] ['TEXT_SIZE']  = 9;
        $aRow [2] ['TEXT_ALIGN'] = 'L';
        $oTable->addRow($aRow);
        //2. Zeile
        $aRow [0] ['TEXT']      = '';
        $aRow [0] ['TEXT_SIZE'] = 9;
        $aRow [1] ['TEXT']       = "12 pcs per design and colour";
        $aRow [1] ['TEXT_SIZE']  = 9;
        $aRow [1] ['TEXT_ALIGN'] = 'L';
        $aRow [2] ['TEXT']       = "Min. 6 complete original cartons.";
        $aRow [2] ['TEXT_SIZE']  = 9;
        $aRow [2] ['TEXT_ALIGN'] = 'L';
        $oTable->addRow($aRow);
        //3. Zeile
        $aRow [0] ['TEXT']      = '';
        $aRow [0] ['TEXT_SIZE'] = 9;
        $aRow [1] ['TEXT']      = "";
        $aRow [1] ['TEXT_SIZE'] = 9;
        $aRow [2] ['TEXT']       = "Exact quantities will be mentioned latest 10 weeks before delivery";
        $aRow [2] ['TEXT_SIZE']  = 9;
        $aRow [2] ['TEXT_ALIGN'] = 'L';
        $oTable->addRow($aRow);
        //4. Zeile
        $aRow [0] ['TEXT']       = 'Delivery time ';
        $aRow [0] ['TEXT_SIZE']  = 9;
        $aRow [1] ['TEXT_ALIGN'] = 'L';
        $firstSampling  = is_null($purchase->PPPurchase_FirstSampling) ? '4 weeks after agreed order (date of Purchase order)'
                    : $purchase->PPPurchase_FirstSampling;
        $secondSampling = is_null($purchase->PPPurchase_SecondSampling) ? '8 weeks before Date of delivery'
                    : $purchase->PPPurchase_SecondSampling;
        // $aRow [1] ['TEXT'] = "4 weeks after agreed order (date of Purchase order)";
        $aRow [1] ['TEXT']       = $firstSampling;
        $aRow [1] ['TEXT_SIZE']  = 9;
        $aRow [1] ['TEXT_ALIGN'] = 'L';
        //$aRow [2] ['TEXT'] = "8 weeks before Date of delivery";
        $aRow [2] ['TEXT']       = $secondSampling;
        $aRow [2] ['TEXT_SIZE']  = 9;
        $aRow [2] ['TEXT_ALIGN'] = 'L';
        $oTable->addRow($aRow);
        $oTable->close();
        $this->fpdf->Ln($this->lh * 1.5);
        $this->fpdf->SetTextColor(244, 0, 0);
        $this->_absatz($this->_getTextA('TextK7_0'));
        $this->fpdf->Ln($this->lh);
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->_header2($this->_getText('HeaderK7_1'));
        $this->_absatz($this->_getTextA('TextK7_1'));
        $this->fpdf->Ln($this->lh);
        $this->_header2($this->_getText('HeaderK7_2'));
        $this->_absatz($this->_getTextA('TextK7_2'));
        $this->fpdf->Ln($this->lh);
        $this->_header2($this->_getText('HeaderK7_3'));
        $this->_absatz($this->_getTextA('TextK7_3_1'));
        $this->fpdf->SetFont($this->font, 'B', 10);
        $this->_absatz($this->_getTextA('TextK7_3_2'));
        $this->fpdf->SetFont($this->font, '', 10);
        $this->_absatz($this->_getTextA('TextK7_3_3'));
        $this->_NewPage();
        $this->_header1($this->_getText('HeaderK8_0'));
        $this->fpdf->Ln($this->lh);
        $this->_header2($this->_getText('HeaderK8_1'));
        $this->_text($this->_getText('TextK8_1'));
        $this->_header2($this->_getText('HeaderK8_2'));
        $pruefinst        = utf8_decode($purchase->PPPurchase_Pruefinstitut);
        $inspectionCenter = utf8_decode($purchase->PPPurchase_InspectionCenter);
        try {
            $dt = new DateTime();
            //echo("Year: $purchase->PPPurchase_FOBYear Week: $purchase->PPPurchase_FOBWeek <br>");
            $dt->setISODate($purchase->PPPurchase_FOBYear, $purchase->PPPurchase_FOBWeek);
            $dt->modify('-21 Days');
            $fobMinus3W = $dt->format("W/Y");
        }
        catch (Exception $ex) {
            $fobMinus3W = "Three weeks before Deleiverydate FOB";
        }
        //echo($pi) ; exit;
        $threePartInsp = "The three partial-inspections of are on account of Targa. If any inspection of fails, the
costs of the re-inspection will be on account of the Seller.";
        $textInspCenter = "For this article 100% PSI/FRI inspections at the factory will no longer be required as the final inspection will take place at
one of the Inspection Centers, where the goods will be delivered by the producer. Depending on the result of the anticipated reception control, the goods will either be released for shipment or be declined. Please see Factory Manual Inspection Center %InspectionCenter%. The costs of the inspection/ logistic costs will be on account of the Seller.";
        $text1 = $this->_getText('TextK8_2');
        //echo("0  " . $text1 . "<br>");
        $text1 = str_replace("%TESTER%", $pruefinst, $text1);
        $text1 = str_replace("%FOB3%", $fobMinus3W, $text1);
        //echo("1  " . $text1 . "<br>");
        if (trim($inspectionCenter) != "") {
            $text1 = str_replace("%ThreePart%", "", $text1);
            //     echo("A  " . $text1 . "<br>");
            $text1 .= $textInspCenter;
            //echo("B  " . $text1 . "<br>");
            $text1 = str_replace("%InspectionCenter%", $inspectionCenter, $text1);
            //echo("C  " . $text1 . "<br>");
        }
        else {
            $text1 = str_replace("%ThreePart%", $threePartInsp, $text1);
            //echo("D  " . $text1 . "<br>");
            $text1 = str_replace("%InspectionCenter%", "", $text1);
            //echo("E  " . $text1 . "<br>");
        }
        //echo($text1);
        //exit;
        $this->_text($text1);
        $this->_header2($this->_getText('HeaderK8_3'));
        $this->_text($this->_getText('TextK8_3'));
        $this->_NewPage();
        $this->_header2($this->_getText('HeaderK8_4'));
        $this->_text($this->_getText('TextK8_4'));
        $this->_header2($this->_getText('HeaderK8_5'));
        $this->_text($this->_getText('TextK8_5'));
        $this->_header2($this->_getText('HeaderK8_6'));
        $this->_text($this->_getText('TextK8_6'));
        $this->_header2($this->_getText('HeaderK8_7'));
        $this->_text($this->_getText('TextK8_7'));
        /* $this->_header2($this->_getText('HeaderK8_8'));
          $this->_text($this->_getText('TextK8_8'));
          $this->_header2($this->_getText('HeaderK8_9'));
          $this->_text($this->_getText('TextK8_9')); */
        $this->_header1($this->_getText('HeaderK9_0'));
        $this->_text($this->_getText('TextK9_0'));
        $this->_NewPage();
        $this->_header1($this->_getText('HeaderK10_0'));
        $this->_text($this->_getText('TextK10_0'));
        $this->_header1($this->_getText('HeaderK11_0'));
        $this->_text($this->_getText('TextK11_0'));
        $this->_NewPage();
        $this->_header1($this->_getText('HeaderK12_0'));
        $this->_text($this->_getText('TextK12_0'));
        $this->_header1($this->_getText('HeaderK13_0'));
        $this->_text($this->_getText('TextK13_0'));
        $this->fpdf->setY($this->fpdf->getY() - $this->lh);
        /* $this->_text($this->_getText('TextK13_2'));
          $this->fpdf->setY($this->fpdf->getY()-$this->lh);
          $this->_text($this->_getText('TextK13_3'));
          $this->fpdf->setY($this->fpdf->getY()-$this->lh); */
        $this->_header1($this->_getText('HeaderK14'));
        $this->_text($this->_getText('TextK14'));
        $this->_header1($this->_getText('HeaderK15'));
        $this->_text($this->_getText('TextK15'));
        $this->_NewPage();
        $this->_header1($this->_getText('HeaderK16'));
        $this->_text($this->_getText('TextK16'));
        $this->_header1($this->_getText('HeaderK17'));
        $this->_text($this->_getText('TextK17'));
        $this->_header1($this->_getText('HeaderK18'));
        $this->_text($this->_getText('TextK18'));
        $this->_header1($this->_getText('HeaderK19'));
        $this->_text($this->_getText('TextK19'));
        $this->_header1($this->_getText('HeaderK20'));
        $this->_text($this->_getText('TextK20'));
        $this->_text($this->_getText('TextUnterschriften', '%DATE%', date('d.m.Y')));
        $this->fpdf->Image(storage_path() . "/images/PO/Unterschrift.png", $this->fpdf->getX() + 10, $this->fpdf->getY() - 60, 0, 11);
        $path = public_path() . '/data/Dokumente/';
        $fn   = 'PO_' . date('Y-m-d') . '_' . $pp->PPProduktpass_IAN . '.pdf';
        if ($final) {
            //var_dump($id);exit;
            //echo($path.$fn);exit;
            $po                       = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->get()->first();
            $po->PPPurchase_Orderdate = date('Y-m-d h:i:s');
            //  In jedes projekt eintragen
            $pp_project               = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', $pp->PPProduktpass_PPProjekte_Projekt)->get();
            $includedPOs              = array();
            foreach ($pp_project as $project) {
                if (strlen($project->PPProduktpass_IAN) <= 6) {
                    $uc  = new UploadController ();
                    $uc->moveFilesToArchive($project->PPProduktpass_Id, "Purchaseorder");
                    $uc->newFilesEntry($fn, $project->PPProduktpass_Id, 'Dokumente', 'PO vom ' . date('d.m.Y'), 'Dokumente', 'Purchaseorder');
                    $pp1 = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $project->PPProduktpass_Id)->get()->first();
                    if ($pp1) {
                        $includedPOs[] = $pp1->PPPurchase_Id;
                    }
                }
            }
            $this->updatePOUploadDate($includedPOs);
            $this->fpdf->Output($path . $fn, 'F');
        }
        $this->fpdf->Output($path . $fn, 'D');
        //return Response::download($path.$fn); // $name, $headers);
    }
    private function updatePOUploadDate($poids) {
        foreach ($poids as $poid) {
            $po                       = PPPurchase::where('PPPurchase_Id', '=', $poid)->get()->first();
            $po->PPPurchase_OrderDate = date('Y-m-d h:i:s');
            $po->save();
        }
    }
    private function AppendixImages($id) {
    }
    private function _getText($art, $search = '', $replace = '') {
        $aText = $this->_getTextA($art, $search, $replace);
        if ($aText['hasData']) {
            return $aText['text'];
        }
        return "";
    }
    private function _getTextA($art, $search = '', $replace = '') {
        $aReturn = array("hasData"    => false, "text"       => "", "picture"    => "",
            "pictuerPos" => 0,
            "hasPicture" => false);
        if (PPTextbausteine::where("PPTextbausteine_Art", "=", $art)->exists()) {
            $textbausteine         = PPTextbausteine::where("PPTextbausteine_Art", "=", $art)->first();
            $text = $textbausteine->PPTextbausteine_Text;
            $tbp = PPTextbausteineProjekte::where("PPTextbausteineProjekte_PPID", $this->PPId)->where('PPTextbausteineProjekte_Textbausteine_Id', $textbausteine->PPTextbausteine_Id)->get()->first();
            if ($tbp){
                $text = $tbp->PPTextbausteineProjekte_Text;
            }
            if (substr($text,0,1) == '@'){
                return $aReturn;
            }
            $aReturn["hasData"]    = True;
            $aReturn["picture"]    = $textbausteine->PPTextbausteine_Picture;
            $aReturn["hasPicture"] = false;
            if (strlen(trim($textbausteine->PPTextbausteine_Picture)) > 1) {
                $aReturn["hasPicture"] = true;
            }
            $aReturn["picturePos"] = $textbausteine->PPTextbausteine_PicturePos;
            if (strlen($search) > 0) {
                $aReturn["text"] = utf8_decode(str_replace($search, $replace, ($text)));
            }
            else {
                $aReturn["text"] = utf8_decode($text);
            }
        }
        return $aReturn;
    }
    private function _absatz($textA) {
        if (!$textA['hasData']) {
            $this->fpdf->SetX($this->leftmargin + 4);
            $this->MultiCellSave(0, $this->lh, $textA['text'], 0, 'L');
            $this->fpdf->Ln($this->lh);
            return;
        }
        $image = "";
        $ih    = 30;
        if ($textA['hasPicture']) {
            $image   = public_path() . "/data/uploads/BilderTextbausteine/" . $textA['picture'];
            $is      = getimagesize($image);
            //var_dump($is);exit;
            $ih300cm = $is[1] / 300 * 2.54; //Bildh�he bei 300dpi in cm
            $ih = ceil($ih300cm) * 10;
        }
        if ($textA['hasPicture'] and $textA['picturePos'] == 1) {
            $this->fpdf->Image($image, $this->leftmargin + 4, $this->fpdf->getY(), -300);
            $this->fpdf->Ln($ih);
        }
        $this->fpdf->SetX($this->leftmargin + 4);
        $this->MultiCellSave(0, $this->lh, $textA['text'], 0, 'L');
        $this->fpdf->Ln($this->lh);
        if ($textA['hasPicture'] and $textA['picturePos'] == 0) {
            $this->fpdf->Image(public_path() . "/data/uploads/BilderTextbausteine/" . $textA['picture'], $this->leftmargin + 4, $this->fpdf->getY(), -300);
            $this->fpdf->Ln($ih);
        }
    }
    private function _kapitel($header, $kapitel, $ptextA = null) {  //***************Neue Seite
        $this->fpdf->SetTextColor(1, 1, 1);
        /* $this->fpdf->SetFont($this->font,'B',10);
          $this->CellSave(0,$this->lh,$header);
          $this->fpdf->Ln($this->lh+3);
          $this->fpdf->SetFont($this->font,'',10); */
        $this->_header1($header);
        $this->fpdf->SetX($this->leftmargin + 4);
        $textA = ($ptextA == null) ? array('hasData'    => True, 'text'       => $kapitel,
            'hasPicture' => False, 'picture'    => "", 'picturePos' => "") : $ptextA;
        $this->_absatz($textA);
        //$this->fpdf->Write($this->lh,$kapitel);
    }
    private function getHeaderFromSizeSort($sizesort) {
        $h = array();
        if (!isset($sizesort['SIZES']) or $sizesort['SIZES'] == "") {
            return null;
        }
        foreach ($sizesort['SIZES'] as $size => $mengen) {
            foreach ($mengen as $land => $mng) {
                $l = "CB8-" . strlen($land) > 4 ? substr($land, 4) : $land;
                if (strpos($land, "ES") !== false) {
                    $l = "CB5-OSES";
                }
                if (strlen($l) > 0) {
                    $h[$l] = $mng['mengen']['VE'];
                }
            }
        }
        ksort($h);
        //print_r($h);
        return $h;
    }
    private function setStdFont($size = 11, $bold = '') {
        $this->fpdf->SetFont($this->font, $bold, $size);
    }
    private function printRowLC($lable, $value) {
        $colWidth1       = $this->leftmargin + 65;
        $lineHeight      = 5;
        $lineHeightEmpty = 4;
        $y       = $this->fpdf->getY();
        $this->setStdFont(11, 'B');
        $this->fpdf->setX($this->leftmargin);
        $this->MultiCellSave(0, $lineHeight, utf8_decode($lable));
        $this->fpdf->Ln($lineHeightEmpty);
        $test_y1 = $this->fpdf->getY();
        $this->fpdf->setXY($colWidth1, $y);
        $this->setStdFont(11, '');
        $this->MultiCellSave(0, $lineHeight, utf8_decode($value));
        $this->fpdf->Ln($lineHeightEmpty);
        $test_y2 = $this->fpdf->getY();
        if ($test_y1 > $test_y2) {
            $this->fpdf->setXY($this->leftmargin, $test_y1);
        }
        if ($this->fpdf->getY() > 250) {
            $this->_NewPage();
        }
    }
    public function outputLC($ppid, $final = 0) {
        $tm = 55;  //Oberer Rand
        $pp = PPProduktpass::where('PPProduktpass_Id', '=', $ppid)->get()->first();
        if (!$pp) {
            return false;
        }
        $pc = new ProjectsController();
        $purchase = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $ppid)->get()->first();
        $ab       = PPAB::where("PPAB_PPProduktpass_Id", "=", $ppid)->get()->first();
        $hafen = "N.N.";
        if ($ab) {
            $hafen = $pc->getAbgangshafenText($ab->PPAB_Abgangshafen);
        }
        $LC1 = $pc->getLC($ppid);
        $lc  = $LC1['LC'];
        /* echo("<pre>");
          print_r($LC1);
          exit; */
        $this->fpdf->sFooter = ' ';
        $this->_NewPage();
        $this->fpdf->SetXY($this->leftmargin, $tm);
        $this->setStdFont(12, 'B');
        $this->CellSave(0, 10, utf8_decode("L/C-Opening for PJN: " . $LC1['ProjektIANS']));
        $this->fpdf->Ln();
        $this->setStdFont(12);
        $this->CellSave(0, 10, date('d.m.Y'), 0, 0, 'R');
        $this->fpdf->Ln();
        $this->printRowLC("Description:", $purchase->PPPurchase_Translate_Projectdescription);
        $this->printRowLC("Applicant:", $lc['PPLC_Applicant']);
        $this->printRowLC("Beneficiary:", $lc['PPLC_Beneficiary']);
        $this->printRowLC("Advising Bank:", $lc['PPLC_AdvisingBank']);
        $this->printRowLC("Form of Documentary Credit:", $lc['PPLC_FormOfDocumentaryCredit']);
        $this->printRowLC("Applicable Rules:", $lc['PPLC_ApplicableRules']);
        $this->printRowLC("Date and Place of Expiry:", $lc['PPLC_DateAndPlaceOfExpiry']);
        $this->printRowLC("Currency Code and Amount:", $lc['PPLC_Amount']);
        $this->printRowLC("Available with ___ By:", $lc['PPLC_AvailableWith']);
        $this->printRowLC("Negotiation /
Deferred Payment Details:", $lc['PPLC_TOP']);
        $this->printRowLC("Partial Shipment:", $lc['PPLC_PartitialShipment']);
        $this->printRowLC("Transshipment:", $lc['PPLC_TransShipment']);
        $this->printRowLC("Port of Loading /
Airport of Departure:", $lc['PPLC_POL']);
        $this->printRowLC("For Transportation to:", $lc['PPLC_ForTransportationTo']);
        $w    = $purchase->PPPurchase_FOBWeek;
        $y    = 2000 + $purchase->PPPurchase_FOBYear;
        $dto  = new DateTime();
        $date = $dto->setISODate($y, $w);
        $this->printRowLC("Latest Date of Shipment:", $lc['PPLC_LDOS']);
        if ($this->fpdf->getY() > 200) {
            $this->_NewPage();
        }
        $this->printRowLC("Description of Goods:", $lc['PPLC_DOTG']);
        //  $this->printRowLC("xxx:", xxx);
        if ($this->fpdf->getY() > 200) {
            $this->_NewPage();
        }
        $this->printRowLC("Over Shipment:", $lc['PPLC_OverShipment']);
        $this->printRowLC("Other Specification:", $lc['PPLC_OtherSpec']);
        $this->printRowLC("Documents Required:", $lc['PPLC_DocumentsRequired']);
        $this->printRowLC("Additional Conditions:", $lc['PPLC_AdditionalConditions']);
        $this->printRowLC("Deduction:", $lc['PPLC_Deduction']);
        $this->printRowLC("Charges:", $lc['PPLC_Charges']);
        $this->printRowLC("Periode for Presentation:", $lc['PPLC_PeriodeForPresentation']);
        $this->printRowLC("Confirmation Instructions:", $lc['PPLC_ConfirmationInstructions']);
        $this->printRowLC("Inst/Paying/Accept/
Negotiate Bank:", $lc['PPLC_IPAN']);
        $this->fpdf->Ln(8);
        $this->setStdFont(11, 'B');
        $this->CellSave(0, 0, "- END -", 0, 0, "C");
        $path = public_path() . '/data/Dokumente/';
        $fn   = 'LC_' . date('Y-m-d') . '_' . $pp->PPProduktpass_IAN . '.pdf';
        if ($final == 1) {
            $uc = new UploadController ();
            $uc->moveFilesToArchive($pp->PPProduktpass_Id, "LC");
            $uc->newFilesEntry($fn, $pp->PPProduktpass_Id, 'Dokumente', 'LC vom ' . date('d.m.Y'), 'Dokumente', 'LC');
            $lc = PPLC::where("PPLC_PPProduktpass_id", "=", $pp->PPProduktpass_Id)->get()->first();
            if ($lc) {
                $lc->PPLC_FinalDate = date('Y.m.d');
                $lc->save();
            }
            $this->fpdf->Output($path . $fn, 'F');
        }
        $this->fpdf->Output($path . $fn, 'D');
    }
    function defineCol(&$tab, $size, $text, $align = 'L', $textsize = 8, $linesize = 4.5) {
        $tab['colsize'][] = $size;
        $tab['header'][]  = array('TEXT_SIZE' => $textsize, 'TEXT'      => $text,
            "ALIGN"     => $align,
            'LINE_SIZE' => $linesize);
    }
    function getCell($str, $border = '1', $align = 'L', $padding_left = '1', $padding_right = '1', $colspan = 1, $padding = -1) {
        if ($str == "0000-00-00")
            $str = " - ";
        if (!mb_detect_encoding($str, 'UTF-8', true)) {
            $str = utf8_encode($str);
        }
        $str = str_replace("!*", "<b>", $str);
        $str = str_replace("*!", "</b>", $str);
        if ($padding == -1) {
            $res_arr = array('TEXT'          => $str,
                'ALIGN'         => $align,
                'PADDING_LEFT'  => $padding_left,
                'PADDING_RIGHT' => $padding_right,
                'BORDER_TYPE'   => $border,
                'COLSPAN'       => $colspan,
                'COLOR'         => 'black',
                'LINE_SIZE'     => 3.5);
        }
        else {
            $res_arr = array('TEXT'           => $str,
                'ALIGN'          => $align,
                'PADDING_TOP'    => $padding_left,
                'PADDING_BOTTOM' => $padding_right,
                'PADDING_LEFT'   => $padding_left,
                'PADDING_RIGHT'  => $padding_right,
                'BORDER_TYPE'    => $border,
                'COLSPAN'        => $colspan,
                'COLOR'          => 'black',
                'LINE_SIZE'      => 3.5);
        }
        return $res_arr;
    }
    function output8W($ppid, $final = false) {
        $pc  = new ProjectsController();
        $pis = $pc->getProjectInfo8W($ppid);
        $ian = $pis[$ppid]['IAN'];
        $tm = 55;  //Oberer Rand
        $this->fpdf->sFooter = ' ';
        $this->_NewPage();
        $this->fpdf->SetXY($this->leftmargin, $tm);
        $this->setStdFont(11);
        $this->CellSave(0, 10, "Soest," . date('d.m.Y'), 0, 0, 'R');
        $this->fpdf->Ln();
        $this->setStdFont(14, 'B');
        $this->CellSave(0, 10, utf8_decode("8-Wochen Muster "));
        $this->fpdf->Ln(20);
        foreach ($pis as $pi) {
            $this->setStdFont(10, 'B');
            $this->CellSave(25, 5, utf8_decode("IAN " . $pi['IAN']));
            $this->setStdFont(10);
            $this->MultiCellSave(150, 5, utf8_decode($pi['Description']), 0, 'L');
            $this->fpdf->Ln(1);
        }
        $this->fpdf->Ln(10);
        $anrede = "Sehr geherter Herr .....
anbei erhalten sie folgende 8-Wochen-Muster:";
        $this->setStdFont(10);
        $this->MultiCellSave(0, 5, utf8_decode($anrede), 0, 'L');
        $cw = array(15, 70, 20, 30, 15);
        $c      = 1;
        $border = 1;
        $lineH  = 5;
        foreach ($pis as $pi) {
            $this->CellSave($cw[0], $lineH, utf8_decode('IAN'), $border, 'L');
            $this->CellSave($cw[1], $lineH, utf8_decode('Artikelbezeichnung'), $border, 'L');
            $this->CellSave($cw[2], $lineH, utf8_decode('Style'), $border, 'L');
            $this->CellSave($cw[3], $lineH, utf8_decode('Style-Bezeichung'), $border, 'L');
            $this->CellSave($cw[4], $lineH, utf8_decode('Anzahl'), $border, 'C');
            $this->fpdf->Ln(5);
            $nl = "\r\n";
            $this->MultiCellSave($cw[0], 20, utf8_decode($pi['IAN']), 1, 'L');
            $this->MultiCellSave($cw[1], 20, utf8_decode($pi['Description']), 1, 'L');
            $this->CellSave($cw[2], 5, utf8_decode("Style A"), 1, 'L');
            $this->CellSave($cw[3], 5, utf8_decode("Grün"), 1, 'L');
            $this->CellSave($cw[4], 5, utf8_decode("2"), 1, 'L');
            $this->fpdf->Ln(20);
            /* $aRow = array();
              $aRow[0] = getCell($pi['IAN'], 1, "L");
              $aRow[1] = getCell($pi['Description'], 1, "L");
              $aRow[2] = getCell('Style', 1, "L");
              $aRow[3] = getCell('Style-Bezeichnung', 1, "L");
              $aRow[4] = getCell('2 Stück', 1, "C");
              $oTable->addRow($aRow); */
        }
        $path = public_path() . '/data/Dokumente/';
        $fn   = '8W_' . date('Y-m-d') . '_' . $ian . '.pdf';
        if ($final == 1) {
            $uc = new UploadController ();
            $uc->moveFilesToArchive($ppid, "8-Wochen-Muster");
            $uc->newFilesEntry($fn, $ppid, 'Dokumente', '8W-Muster vom ' . date('d.m.Y'), 'Dokumente', '8 Wochen');
            $this->fpdf->Output($path . $fn, 'F');
        }
        $this->fpdf->Output($path . $fn, 'D');
    }
    public function ablageMeetigProtokoll ($data){
        $meeting = $data['Meeting'];
        $mas = $data['Mitarbeiter'];
        //echo('<br><br><br><pre>');       print_r($meeting);        echo('</pre><br><br><br><pre>');        print_r($mas);        echo('</pre><br><br><br>');        exit;
        $tns = $data['Teilnehmer'];
        $pp = $data['Produktpass'];
        $ppid = $pp->PPProduktpass_Id;
        $teilnehmer = '';
        foreach($tns as $tn){
            $teilnehmer .= utf8_decode($mas[$tn]['Name']).  PHP_EOL;
        }
        //$teilnehmer = substr($teilnehmer,0,strlen($teilnehmer)-3);
        $ian = $pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $tm = 25;  
        $this->fpdf->sFooter = ' ';
        $this->_NewPage();
        $width = 180;
        $wLabel = $width*1/4;
        $wValue = $width*3/4;
        $border = 0;
        $ord = 'Meeting-Protokoll';
        if ($meeting['PPMeetingprotokoll_Art'] == 'Review'){
            $ord = 'Review-Meeting-Protokoll';
        }
        $this->fpdf->SetXY($this->leftmargin, $tm);
        $this->setStdFont(14);
        $this->CellSave($width, 14, $ord, 1,2,'C');
        $this->setStdFont(12);
        $d = new DateTime($meeting->PPMeetingprotokoll_DateFinal);
        $this->CellSave($wLabel, 10, 'Datum', $border,0,'L');
        $this->CellSave($wValue, 10, $d->format('d.m.Y') , $border,0,'L');
        $this->fpdf->Ln(10);
        $this->CellSave($wLabel, 6, utf8_decode('Protokollführer'), $border,0,'L');
        $this->MultiCellSave($wValue, 6, utf8_decode($mas[$meeting['PPMeetingprotokoll_Schriftfuehrer']]['Name']), $border,'L');
        $this->CellSave($wLabel, 6, 'Teilnehmer', $border,0,'L');
        $this->MultiCellSave($wValue, 6, $teilnehmer , $border,'L');
        $this->CellSave($wLabel, 10, 'IAN', $border,0,'L');
        $this->CellSave($wValue, 10, $ian .' '.utf8_decode($pp->PPProduktpass_Artikelbezeichnung), $border,0,'L');
        $this->fpdf->Ln(10);
        $this->CellSave($wLabel, 10, 'Thema', $border,0, 'L');
        $this->CellSave($wValue, 10, utf8_decode($meeting->PPMeetingprotokoll_Thema), $border,0, 'L');
        $this->fpdf->Ln(10);
        $this->CellSave($wLabel, 6, 'Agenda',$border,0,'L');
        $this->MultiCellSave($wValue, 6,utf8_decode( $meeting->PPMeetingprotokoll_Agenda),$border,'L');
        $this->fpdf->Ln(10);
        $this->setStdFont(10);
        $this->MultiCellSave($width, 6, utf8_decode($meeting->PPMeetingprotokoll_Text),$border,'L');
        $path = public_path() . '/data/uploads/Dokumente/';
        $fn = str_random(6).'_'.$ian.'_Meetingprotokoll_'.$d->format('Y-m-d_His').'.pdf';
        $uc = new UploadController ();
        //$uc->moveFilesToArchive($ppid, "8-Wochen-Muster");
        $uc->newFilesEntry($fn, $ppid, 'EKPM', '', 'uploads/Dokumente','Protokoll', $ord);  /*'Dokumente', 'Bem', 'Dokumente', '8 Wochen');*/
        $this->fpdf->Output($path . $fn, 'F');
    }
}