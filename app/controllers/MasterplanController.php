<?php
use Symfony\Component\Translation\Interval;
define('COL_SUNDAY', 'B4C6E7');
define('COL_CRDTARGET', '92D050');
define('COL_CRDNEED', '00B0F0');
define('COL_CRDPLUS', 'FFFF00');
define('COL_CRDPENALTY', 'FF0000');
define('COL_DDP', '33FF46');
class MasterplanController extends BaseController
{
    var $objReader =  null;
    var $objPHPExcel = null;
    var $worksheet = null;
    var $internalCalendar = array();
    private function p($var, $exit = false)
    {
        echo ('<pre>');
        print_r($var);
        echo ('</pre>');
        if ($exit) {
            exit;
        }
    }
    public function GetMpForm($id)
    {
        $pp = tPPProduktpass::find($id);
        $this->protokoll($pp->PPProduktpass_Id, '', '', 'USE MP FUNC', '0', '1');
        if (! $pp->PPProduktpass_SimNeu){
            $this->setSimDates($pp);
        }
        $KeyMilestones = $this->getKeyMilestones();
        $Milestones = $this->getMilestones();
        $crd = $this->getCRD($pp);
        $termine = $this->getTermineKMS($id);
        //$this->p($crd, 1);
        $data = array(
            'Header' => 'Masterplan Milestones',
            'HeaderData' => array(
                'IAN' => $pp->PPProduktpass_IAN,
                'Charge' => substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4),
                'Artikel' => $pp->PPProduktpass_Artikelbezeichnung,
                'DDP' => $pp->PPProduktpass_Liefertermin . '/' . $pp->PPProduktpass_LieferterminJahr,
                'CRD' => $crd->format('W') . '/' . $crd->format('Y'),
                'CRD Datum' => $crd->format('d.m.Y'),
                'Menge' => number_format($pp->PPProduktpass_Gesamtmenge, 0),
            ),
            'KeyMilestones' => $KeyMilestones,
            'Milestones' => $Milestones,
            'Termine' => $termine,
            'ppid' => $pp->PPProduktpass_Id,
            'SimNeu' => $pp->PPProduktpass_SimNeu,
        );
        //echo('<pre>');        print_r($data);        exit;
        cpcDebug::cpc_debug("GetMpForm: Lade Masterplan Formular für PPID: ".$pp->PPProduktpass_Id, '@SimMplan');
        $data['content'] = View::make('Masterplan.mpForm')->with('data', $data);
        return View::make('main', $data);
    }
    private function setSimDates($pp)
    {
        //PPTermine_SimDate
        $KeyMilestones = PPBoardSpalteData::where('PPBoardSpalteData_IsKMS', 1)->orderBy('PPBoardSpalteData_Gruppe')->get();
        //$this->p($crd);
        $crd = $this->getCRD($pp);
        cpcDebug::cpc_debug("setSimDates aufgerufen für PPID: ".$pp->PPProduktpass_Id." mit CRD: ".$crd->format('Y-m-d'), '@SimMplan');
        foreach ($KeyMilestones as $ms) {
            //$this->p('CRD: '. $ms->PPBoardSpalte_Bezeichnung. ' -> '. $crd->format('Y-m-d') );
            //$this->p($ms->PPBoardSpalte_Bezeichnung .' ->'.$ms->PPBoardSpalteData_W2KMS);
            $t = PPTermine::where('PPTermine_PPProduktpass_Id', $pp->PPProduktpass_Id)->where('PPTermine_PPBoardSpalte_Id', $ms->PPBoardSpalte_Id)->get()->first();
            if ($t) {
                //$this->p("Termin gefunden!");
                $simd = clone $crd;
                if ($t->PPTermine_SimDate == '0000-00-00 00:00:00') {
                    $diff = $ms->PPBoardSpalte_Rot + 10;
                    //$this->p('DIFF: '.$diff);
                    if ($diff > 0) {
                        $mod = "+" . abs($diff) . ' Weeks';
                        $simd->modify($mod);
                    }
                    if ($diff < 0) {
                        $mod = "-" . abs($diff) . ' Weeks';
                        $simd->modify($mod);
                    }
                    //$this->p('Update: '.$simd->format('Y-m-d'));
                    cpcDebug::cpc_debug(" setSimDates: Setze SimDate für TerminID: ".$t->PPTermine_Id." auf ".$simd->format('Y-m-d') ."  Diff CW: $diff", '@SimMplan');
                    $t->PPTermine_SimDate = $simd->format('Y-m-d');
                    $t->save();
                }
            }
        }
        //exit;
    }
    private function getKeyMilestones()
    {
        $KeyMilestones = PPBoardSpalteData::where('PPBoardSpalteData_IsKMS', 1)->orderBy('PPBoardSpalteData_Gruppe')->get();
        if ($KeyMilestones) {
            return $KeyMilestones;
        }
        return null;
    }
    private function date2MySql($date)
    {
        if (strlen(trim($date)) == 0 or is_null($date)) {
            return '0000-00-00 00:00:00';
        }
        /* try{
            $d = new DateTimeImmutable($date);
            $d2f = 5-intval($d->format('w'));
            if ($d2f > 0){
                $d= $d->modify('+'.$d2f.' days');
            }
            if ($d2f < 0){
                $d = $d->modify('-'.abs($d2f).' days');
            }
            $res = $d->format('Y-m-d H:i:s');
        } catch(Exception $ex){
            $res = '0000-00-00 00:00:00';
        } */
        $d = new DateTimeImmutable($date);
        $res = $d->format('Y-m-d H:i:s');
        return $res;
    }
    private function updateHistory ($t){
        if ($t){
            $hist = $t->PPTermine_History;
        }
    }
    private function update($art, $ppid, $id, $date = null)
    {
        if (is_null($date)) {
            $date = '0000-00-00 00:00:00';  
        }
        $t = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $id)->get()->first();
        if ($t) {
            if ($art == 'date') {
                if (!$this->setFirstSollDate($ppid, $t, $date)){
                    $change = "\n--- " . Auth::user()->PPMitarbeiter_Kuerzel . " - " . date('d.m.Y') . " --- ";
                    $change .= "\n Terminupdate über Masterplan: " . $t->PPTermine_DatumStart . " -> " . $date;
                    $t->PPTermine_DatumStart = $this->date2MySql($date);
                    $t->PPTermine_History = $t->PPTermine_History . $change ;
                    $t->save();
                }
            }
            if ($art == 'sim') {
                $t->PPTermine_SimDate = $this->date2MySql($date);
                $t->save();
            }
        }
    }
    private function setFirstSollDate($ppid, $termin, $msDate){
        cpcDebug::cpc_debug("setFirstSollDate aufgerufen für PPID: $ppid mit TerminID: ".$termin->PPTermine_Id." und Datum: $msDate", '@SimMplan');
        //$termin = PPTermine::where('PPTermine_Id', $tid)->get()->first();
        if ($termin){
            if($termin->PPTermine_ManSollDate != '0000-00-00 00:00:00'){
                // Termin wurde bereits gesetzt
                return false;
            }
        }
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        $crdW =  $pp->PPProduktpass_Liefertermin;
        $crdY =  $pp->PPProduktpass_LieferterminJahr;
        $crd = new DateTime();
        $crd->setIsoDate($crdY, $crdW,5);
        $manSollDate = DateTime::createFromFormat('d.m.Y',$msDate);
        $diffManSoll =  $crd->diff($manSollDate, true);
        $w2ManSoll = floor($diffManSoll->format('%R%a')/7);
        $termin->PPTermine_ManSollDate = $manSollDate->format('Y-m-d');;
        $termin->PPTermine_ManSoll = $w2ManSoll;
        $termin->save();
        return true;
    }
    public function setKeyMilestones()
    {
        $ppid = Input::get('ppid');
        $type = Input::get('submit');
        //$ts = $this->getTermineKMS($ppid);
        $dateKMS = Input::get('dateKMS');
        $dateSimKMS = Input::get('dateSimKMS');
        $dateMS = Input::get('dateMS');
        $dateSimMS = Input::get('dateSimMS');
        $pp = tPPProduktpass::where ('PPProduktpass_Id',$ppid)->get()->first();;
        if ($type == 'Download Soll') {
            return $this->writeMasterplan($ppid, 1);
        }
        if ($type == 'Download Ist') {
            return $this->writeMasterplan($ppid,0);
        }
        if ($type == 'Simulieren') {
            $pp->PPProduktpass_SimNeu = 0;
            $pp->save();
            foreach ($dateSimKMS as $id => $kms) {
                $this->update('sim', $ppid, $id, $kms);
            }
            foreach ($dateSimMS as $id => $ms) {
                $this->update('sim', $ppid, $id, $ms);
            }
        }
        if ($type == 'Übernehmen') {
            $pp->PPProduktpass_SimNeu = 0;
            $pp->save();
            foreach ($dateSimKMS as $id => $kms) {
                $this->update('date', $ppid, $id, $kms);
            }
            foreach ($dateSimMS as $id => $ms) {
                $this->update('date', $ppid, $id, $ms);
            }
        }
        if ($type == 'Zurücksetzen') {
            foreach ($dateSimKMS as $id => $kms) {
                $this->update('date', $ppid, $id);
            }
            foreach ($dateSimMS as $id => $ms) {
                $this->update('date', $ppid, $id);
            }
            foreach ($dateSimKMS as $id => $kms) {
                $this->update('sim', $ppid, $id);
            }
            foreach ($dateSimMS as $id => $ms) {
                $this->update('sim', $ppid, $id);
            }
        }
        cpcDebug::cpc_debug("setKeyMilestones: Fertig für PPID: $ppid mit Typ: $type  SimNeu: ".$pp->PPProduktpass_SimNeu , '@SimMplan');
        return $this->GetMpForm($ppid);
    }
    private function getMilestones()
    {
        $mss = PPBoardSpalteData::where('PPBoardSpalteData_IsKMS', 0)->orderBy('PPBoardSpalteData_Gruppe')->orderByRaw('PPBoardSpalteData_W2KMS')->get();
        $milestones = array();
        foreach ($mss as $ms) {
            $milestones[$ms->PPBoardSpalteData_KMS][] = $ms;
        }
        //echo('<pre>');        print_r($milestones);        exit;
        return $milestones;
    }
    private function isMilestone($id)
    {
        $bs = PPBoardSpalteData::where('PPBoardSpalte_id', $id)->get()->first();
        if ($bs) {
            if (!is_null($bs->PPBoardSpalteData_KMS)) {
                return true;
            }
        }
        return false;
    }
    private function getTermineKMS($ppid)
    {
        $ta = array();
        $termines = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
        if ($termines) {
            foreach ($termines as $t) {
                if ($this->isMilestone($t->PPTermine_PPBoardSpalte_id)) {
                    $ta[$t->PPTermine_PPBoardSpalte_id] = $t;
                }
            }
        }
        return $ta;
    }
    public static function dadd($date, $w2kms)
    {
        if ($date == '') {
            return '';
        }
        try {
            $d = new DateTimeImmutable($date);
            if ($w2kms > 0) {
                $d = $d->modify('+' . $w2kms . ' weeks');
            }
            if ($w2kms < 0) {
                $d = $d->modify('-' . abs($w2kms) . ' weeks');
            }
            $res = $d->format('d.m.Y');
        } catch (Exception $ex) {
            $res = '';
        }
        return $res;
    }
    private function getFirstYear($pp)
    {
        return $pp->PPProduktpass_LieferterminJahr - 1;
    }
    private function writeMileStones($ppid, $simValues, $extern = true)
    {
        $att = 'PPTermine_DatumStart';
        if ($simValues){
            $att = 'PPTermine_SimDate';
        }
        if ($extern){
            $milestones = DB::table('v_Milestones')->where("PPTermine_PPProduktpass_Id", $ppid)->where("PPBoardSpalteData_IsExternDate", 1)->orderBy('PPTermine_DatumStart')->get();
        } else {
            $milestones = DB::table('v_Milestones')->where("PPTermine_PPProduktpass_Id", $ppid)->orderBy('PPTermine_DatumStart')->get();
        }
        foreach ($milestones as $ms) {
            if (strpos($ms->PPTermine_Status, 'nicht benötigt') === false ) {
                $date = new DateTimeImmutable($ms->{$att});
                if ($att == 'PPTermine_DatumStart' ){
                    if ($ms->PPTermine_DatumStart == '0000-00-00 00:00:00'){
                        $date = new DateTimeImmutable($ms->PPTermine_ManSollDate);
                    }
                }
                $col = 8; // H
                if (isset($this->internalCalendar[$date->format('Ymd')])) {
                    $row = $this->internalCalendar[$date->format('Ymd')];
                    $cell = $this->getCell(8, $row);
                    $this->setCellValueKeep($cell, $ms->PPBoardSpalte_Bezeichnung);
                }
            }
        }
    }
    private function getCRD($pp)
    {
        if ($pp->PPProduktpass_CRDWoche > 0) {
            $week = $pp->PPProduktpass_CRDWoche;
            $year = $pp->PPProduktpass_CRDJahr;
            $crd = $this->getDateFromWeek($year, $week, 5);
        } else {
            $year = $pp->PPProduktpass_LieferterminJahr;
            $week = $pp->PPProduktpass_Liefertermin;
            $crd = $this->getCRDFromDDP($year, $week);
        }
        return $crd;
    }
    private function marcCRDTarget($pp)
    {
        return;
        $col = 1;
        $crd = $this->getCRD($pp);
        $year = $pp->PPProduktpass_LieferterminJahr;
        $week = $pp->PPProduktpass_Liefertermin;
        $ddp = $this->getDateFromWeek($year, $week, 5);
        $rowCRD = $this->internalCalendar[$crd->format('Ymd')] - 4;
        //Freitag der Woche
        $rowDDP = $this->internalCalendar[$ddp->format('Ymd')] - 4;
        //Freitag der Woche
        $this->cellColor($this->getCell($col, $rowDDP), COL_DDP);
        $row = $rowCRD;
        $this->cellColor($this->getCell($col, $row), COL_CRDTARGET);
        $row -= 7;
        $this->cellColor($this->getCell($col, $row), COL_CRDNEED);
        $row -= 7;
        $this->cellColor($this->getCell($col, $row), COL_CRDNEED);
        $row -= 7;
        $this->cellColor($this->getCell($col, $row), COL_CRDNEED);
        $row = $rowCRD + 7;
        $this->cellColor($this->getCell($col, $row), COL_CRDPLUS);
        $row += 7;
        $this->cellColor($this->getCell($col, $row), COL_CRDPLUS);
        $row += 7;
        $this->cellColor($this->getCell($col, $row), COL_CRDPENALTY);
        //Montag in der CRD Woche
    }
    private function getCRDFromDDP($year, $week)
    {
        $ddp = $this->getDateFromWeek($year, $week, 5);
        $ddp->modify('-9 Weeks');
        return ($ddp);
    }
    private function getDateFromWeek($year, $week, $day = 1)
    {
        $date = new DateTime();
        $date->setISODate($year, $week, $day);
        return $date;
    }
    private function writeCalendar($pp)
    {
        $styleArraySunday = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '1e90ff'),
                'size'  => 10,
                'name'  => 'Arial'
            )
        );
        /*$this->worksheet->setCellValue($coord[$key]['Cell'],$textEN);
        $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setWrapText(true);
        $this->worksheet->getStyle($coord[$key]['Cell'])->getAlignment()->setHorizontal('left');
        $this->setRowHeightText($coord[$key]['Row'], $textEN) ;
        $this->worksheet->getStyle($cell)->applyFromArray($styleArray);*/
        $row = 5;
        $col = 2;
        $year = $this->getFirstYear($pp);
        $startDate = new DateTimeImmutable($year . '-01-01');
        $cell1 = $this->getCell(1, $row);
        $week1 = $startDate->format('W');
        $this->worksheet->setCellValue($cell1, $week1);
        $nWeekday = $startDate->format('N');
        $row = 5 + $nWeekday - 1;
        $this->internalCalendar = array();
        for ($i = 0; $i < 2 * 365 + 1; $i++) {
            $periodeDays = new DateInterval('P' . $i . 'D');
            $date = $startDate->add($periodeDays);
            $this->internalCalendar[$date->format('Ymd')] = $row;
            $weekday = $date->format('l');
            if ($i < 6 and $date->format('W') > 2) {
                continue;
            }
            if ($weekday == 'Monday') {
                $cell = $this->getCell(1, $row);
                $week = $date->format('W');
                $this->worksheet->setCellValue($cell, $week);
            }
            if ($weekday == 'Sunday') {
                $cell1 = $this->getCell(2, $row);
                $cell2 = $this->getCell(26, $row);
                $this->cellColor($cell1 . ':' . $cell2, COL_SUNDAY);
            }
            $germanDate = $date->format('d.m.Y');
            $cell = $this->getCell($col, $row);
            $this->worksheet->setCellValue($cell, $weekday);
            $cell = $this->getCell($col + 1, $row);
            $this->worksheet->setCellValue($cell, $germanDate);
            $row++;
        }
        //$this->p($this->internalCalendar);
    }
    private function writePPDaten($pp)
    {
        $cell = $this->getCell(1, 1);
        $value = $pp->PPProduktpass_IAN . '_' . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        //echo($value.' # ');
        $this->worksheet->setCellValue($cell, $value);
        $cell = $this->getCell(2, 2);
        $value = $pp->PPProduktpass_Gesamtmenge;
        //echo($value.' # ');
        $this->worksheet->setCellValue($cell, $value);
        $cell = $this->getCell(8, 1);
        $value = $pp->PPProduktpass_Artikelbezeichnung;
        //echo($value.' # ');
        $this->worksheet->setCellValue($cell, $value);
        $ddp = new DateTime();
        $ddp->setISODate($pp->PPProduktpass_LieferterminJahr, $pp->PPProduktpass_Liefertermin, 5);
        $row = $this->internalCalendar[$ddp->format('Ymd')];
        $cell = $this->getCell(2, $row);
        //$this->cellColor($cell, COL_DDP);
        $cell = $this->getCell(8, $row);
        $this->setCellValueKeep($cell, 'Deliverydate');
    }
    private function writeMasterplan($ppid, $simValues=false, $isExtern = true)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (!$pp) {
            die("Produktpass: $ppid nicht gefunden!");
        }
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $heute = date('Ymd');
        $path = public_path('data/MPlan') . '/';
        /******************************************************************* */
        $fileName = storage_path() . '/data/templates/MPlan_Template.xlsx';
        /******************************************************************* */
        $this->objReader =  new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $this->objPHPExcel = $this->objReader->load($fileName);
        //$worksheet = $objPHPExcel->getActiveSheet();
        $this->worksheet = $this->objPHPExcel->getActiveSheet();
        $this->writeCalendar($pp);
        $this->writePPDaten($pp);
        $this->writeMileStones($ppid, $simValues, $isExtern);
        $this->marcCRDTarget($pp);
        $this->worksheet->setSelectedCell('A1');
        //$this->setTopLeftCell(9, 317);
        $dl_file = str_random(6) . '-' . $ian . '-' . $ausm . '-MPlan-Ist-' . $heute . '.xlsx';
        $dl = $ian . '-' . $ausm . '-MPlan-Ist-' . $heute . '.xlsx';
        if ($simValues){
            $dl_file = str_random(6) . '-' . $ian . '-' . $ausm . '-MPlan-Soll-' . $heute . '.xlsx';
            $dl = $ian . '-' . $ausm . '-MPlan-Soll-' . $heute . '.xlsx';
        }
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->objPHPExcel, 'Xlsx');
        $objWriter->save($path . $dl_file);
        $this->makeDownload($dl_file, $path, 'application/vnd.ms-excel', $dl);
        return Redirect::to('/getMPForm/' . $ppid);
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
            readfile($dir . $file);
            exit;
        }
    }
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
    function cellColor($cells, $color)
    {
        $this->worksheet->getStyle($cells)->getFill()->getStartColor()->SetARGB($color);
    }
    private function setCellValueKeep($cell, $value)
    {
        $cellValue = $this->worksheet->getCell($cell)->getValue();
        if (strlen($cellValue) > 0) {
            $cellValue .= '&' . $value;
        } else {
            $cellValue = $value;
        }
        $this->worksheet->setCellValue($cell, $cellValue);
    }
    private function protokoll($ppid, $table, $id, $att, $oldVal, $newVal)
    {
        if ($newVal == $oldVal) {
            return;
        }
        $prot = new PPProtokoll();
        $prot->PPProtokoll_Table = $table;
        $prot->PPProtokoll_TableId = $id;
        $prot->PPProtokoll_PPProduktpass_Id = $ppid;
        $prot->PPProtokoll_Benutzer = Auth::user()->id;
        $prot->PPProtokoll_Feld = $att;
        $prot->PPProtokoll_OldContent = $oldVal;
        $prot->PPProtokoll_NewContent = $newVal;
        $prot->PPProtokoll_DateTime = date('Y-m-d H:i:s');
        $prot->save();
    }
    public static function testDate2CRD($date, $crdDate)
    {
        $colTrans = 'background-color:transparent;';
        $colWarn = 'background-color:orange;';
        if ($date == '' or is_null($date)){
            return $colTrans;
        }
        try {
            $d = new DateTimeImmutable($date);
            $crd = new DateTimeImmutable($crdDate);
            if ($d > $crd){
                return $colWarn;
            }
            return $colTrans;
        } catch (Exception $ex) {
            return $colTrans;
        }
    }
    private function setTopLeftCell($col, $row){
        $cell = $this->getCell($col, $row);
        $value =  $this->worksheet->getCell($cell)->getCalculatedValue();
        $this->setCellValueKeep($cell, $value.'!');
    }
}
