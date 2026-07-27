<?php
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
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
            //$this->setSimDates($pp);
        }
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $KeyMilestones = $this->getKeyMilestones($ausm);
        $Milestones = $this->getMilestones($ausm);
        //echo('Keymilestones: <br><pre>');     print_r($KeyMilestones);        echo('</pre>');     
        //echo('Milestones: <br><pre>');        print_r($Milestones);        echo('</pre>');        exit;
        $crd = $this->getCRD($pp);
        $termine = $this->getTermineKMS($id);
        //$this->p($crd, 1);
        $data = array(
            'Header' => 'Masterplan Milestones',
            'HeaderData' => array(
                'IAN' => $pp->PPProduktpass_IAN,
                'Charge' => $ausm,
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
            'BudgetFix' => $pp->PPProduktpass_BudgetFix,
        );
        //echo('<pre>');        print_r($data);        exit;
        ////cpcDebug::cpc_debug("GetMpForm: Lade Masterplan Formular für PPID: ".$pp->PPProduktpass_Id, '@SimMplan');
        $data['content'] = View::make('Masterplan.mpForm')->with('data', $data);
        return View::make('main', $data);
    }
    private function setSimDates($pp)
    {
        //PPTermine_SimDate
        $KeyMilestones = PPBoardSpalteData::where('PPBoardSpalteData_IsKMS', 1)->orderBy('PPBoardSpalteData_Gruppe')->get();
        //$this->p($crd);
        $crd = $this->getCRD($pp);
        //cpcDebug::cpc_debug("setSimDates aufgerufen für PPID: ".$pp->PPProduktpass_Id." mit CRD: ".$crd->format('Y-m-d'), '@SimMplan');
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
                    //cpcDebug::cpc_debug(" setSimDates: Setze SimDate für TerminID: ".$t->PPTermine_Id." auf ".$simd->format('Y-m-d') ."  Diff CW: $diff", '@SimMplan');
                    $t->PPTermine_SimDate = $simd->format('Y-m-d');
                    $t->save();
                }
            }
        }
        //exit;
    }
    private function getKeyMilestones($ausm = '2201')
    {
        $kmsids =$this->getValidMileStones($ausm, 1);
        //echo('KMSIDs: '.$ausm.'<br><pre>');        print_r($kmsids);        echo('</pre>');        exit;
        $KeyMilestones = PPBoardSpalteData::whereIn('PPBoardSpalte_Id', $kmsids)
        ->orderBy('PPBoardSpalteData_Gruppe')->get();
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
    private function updateHistory ($t)
    {
        if ($t){
            $hist = $t->PPTermine_History;
        }
    }
    private function _saveBudget($ppid, $id, $date)
    {
        try{
            $dDate = $this->date2MySql($date);
            //cpcDebug::cpc_debug(" _saveBudget: Aufruf für PPID: $ppid mit BSID: $id und Datum: $date => $dDate ", '@SimMplan1');
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
            $crd = $this->getCRD($pp);
            $t = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $id)->get()->first();
            if ($t) {
                $manSollDate = DateTimeImmutable::createFromFormat('Y-m-d H:i:s',$dDate);
                $diffManSoll =  $crd->diff($manSollDate, true);
                $w2ManSoll = floor($diffManSoll->format('%R%a')/7);
                $t->PPTermine_ManSoll = $w2ManSoll;
                $t->PPTermine_ManSollDate = $dDate;
                $t->save();
            }   
        }
        catch(Exception $ex){
            //cpcDebug::cpc_debug(" _saveBudget: Fehler beim Speichern des Budget Termins für PPID: $ppid mit BSID: $id und Datum: $date ".$ex->getMessage(), '@SimMplan1');
        }
    } 
    private function _resetBudget($ppid, $id)
    {
        try{
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
            $crd = $this->getCRD($pp);
            $t = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $id)->get()->first();
            if ($t) {
                $t->PPTermine_ManSoll = 0;
                $t->PPTermine_ManSollDate = '000-00-00 00:00:00';
                $t->save();
                //cpcDebug::cpc_debug(" _resetBudget: Zurückgesetzt Budget für PPID: $ppid mit BSID: $id ", '-ResetBudget');
            }   
        }
        catch(Exception $ex){
            //cpcDebug::cpc_debug(" _saveBudget: Fehler beim Speichern des Budget Termins für PPID: $ppid mit BSID: $id und Datum:  ".$ex->getMessage(), '@SimMplan1');
        }
    }
    private function _update($att, $ppid, $id, $date = null)
    {
        $valid_att = array('PPTermine_DatumStart', 'PPTermine_SimDate', 'PPTermine_ManSollDate');
        if (in_array($att, $valid_att) == false) {
            return;         
        }
        $t = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $id)->get()->first();
        if ($t) {
            if (is_null($date)) {
                $date = '0000-00-00 00:00:00';  
            }
            $t->{$att} = $this->date2MySql($date);
            $t->save();
        }
    }
    private function update($art, $ppid, $id, $date = null)
    {
        //cpcDebug::cpc_debug("update aufgerufen für PPID: $ppid mit TerminID: $id Art: $art und Datum: $date", '@SimMplan');
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
                    $t->PPTermine_IsMPlan = 1;
                    $t->save();
                }
            }
            if ($art == 'sim') {
                $t->PPTermine_SimDate = $this->date2MySql($date);
                $t->PPTermine_IsMPlan = 0;
                if ($t->PPTermine_SimDate == $t->PPTermine_DatumStart){
                    $t->PPTermine_IsMPlan = 1;
                }
                $t->save();
            }
        }
    }
    private function getAusm($ppid){
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            return substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        }
        return '2201';
    }   
    private function recalc($ppid, $id)
    {
        //cpcDebug::cpc_debug("recalc aufgerufen für PPID: $ppid mit BSID: $id", '@SimMplan');
        $kms = PPBoardSpalteData::where('PPBoardSpalte_Id', $id)->get()->first();
        $kmsT = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $id)->get()->first();
        if($kmsT){
            $kmsDate = $kmsT->PPTermine_SimDate;
        } else {
            return;
        }
        $validMS = $this->getValidMileStones($this->getAusm($ppid), 0);
        $mss = PPBoardSpalteData::whereIn('PPBoardSpalte_Id', $validMS)->where('PPBoardSpalteData_KMS', $kms->PPBoardSpalte_Id)->get();
        $mssarray=array();
        $mssIn = array();
        foreach ($mss as $ms) {
            $mssIn[] = $ms->PPBoardSpalte_Id; 
            $mssarray[$ms->PPBoardSpalte_Id] = $ms->PPBoardSpalteData_W2KMS;
        }
        //cpcDebug::cpc_debug(" recalc: Gefundene Meilensteine für KMSID: $id -> ".implode(',', $mssIn), '@SimMplan');
        $ts = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->whereIn('PPTermine_PPBoardSpalte_id', $mssIn)->get();
        if ($ts) {
            foreach ($ts as $t) {
                //cpcDebug::cpc_debug(" recalc: Berechne SimDate : ".$kmsDate." mit W2KMS: ".$mssarray[$t->PPTermine_PPBoardSpalte_id] , '@SimMplan');
                $t->PPTermine_SimDate = MasterplanController::dadd($kmsDate, $mssarray[$t->PPTermine_PPBoardSpalte_id]);
                //cpcDebug::cpc_debug(" recalc: Setze SimDate für TerminID: ".$t->PPTermine_Id." auf ".$t->PPTermine_SimDate , '@SimMplan');
                $t->save();
            }
        }
    }
    private function setFirstSollDate($ppid, $termin, $msDate)
    {
        return false;
        //cpcDebug::cpc_debug("setFirstSollDate aufgerufen für PPID: $ppid mit TerminID: ".$termin->PPTermine_Id." und Datum: $msDate", '@SimMplan');
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
    private function updateBudget($ppid, $bsid, $date){
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
        $dateSimMSCalc = Input::get('dateSimMSCalc');
        $pp = tPPProduktpass::where ('PPProduktpass_Id',$ppid)->get()->first();;
        if ($type == 'Download Soll') {
            return $this->writeMasterplan($ppid, 1);
        }
        if ($type == 'Download Ist') {
            return $this->writeMasterplan($ppid,0);
        }
        if ($type == 'Berechnung KMS') {
            $pp->PPProduktpass_SimNeu = 0;
            $pp->save();
            foreach ($dateSimKMS as $id => $kms) {
                $this->update('sim', $ppid, $id, $kms);
                $this->recalc($ppid, $id, $kms);
            }
        }
        if ($type == 'Budget speichern') {
            $budget_KMS = Input::get('budget_KMS');
            $budget_MS = Input::get('budget_MS');
            $pp->PPProduktpass_SimNeu = 0;
            $pp->save();
            foreach ($budget_KMS as $id => $kms) {
                $this->_saveBudget($ppid, $id, $kms);
            }  
            foreach ($budget_MS as $id => $ms) {
                $this->_saveBudget($ppid, $id, $ms);
            }
        }
        if ($type == 'Budget übernehmen') {
            $budget_KMS = Input::get('budget_KMS');
            $budget_MS = Input::get('budget_MS');
            $pp->PPProduktpass_SimNeu = 0;
            $pp->PPProduktpass_BudgetFix = 1;
            $pp->save();
            foreach ($budget_KMS as $id => $kms) {
                //cpcDebug::cpc_debug("setKeyMilestones: Übernehme Budget für PPID: $ppid mit BSID: $id und Datum: $kms ", '-simNeu');
                $this->_saveBudget($ppid, $id, $kms);
            }
            foreach ($budget_MS as $id => $ms) {
                //cpcDebug::cpc_debug("setKeyMilestones: Übernehme Budget für PPID: $ppid mit BSID: $id und Datum: $ms ", '-simNeu');
                $this->_saveBudget($ppid, $id, $ms);
            }  
            foreach ($budget_KMS as $id => $kms) {
                //cpcDebug::cpc_debug("setKeyMilestones: Übernehme Budget Datum als SimDate für PPID: $ppid mit BSID: $id und Datum: $kms ", '-simNeu');
                $this->update('sim', $ppid, $id, $kms);
                $this->update('date', $ppid, $id, $kms);
            }
            foreach ($budget_MS as $id => $ms) {
                //cpcDebug::cpc_debug("setKeyMilestones: Übernehme Budget Datum als SimDate für PPID: $ppid mit BSID: $id und Datum: $ms ", '-simNeu');
                $this->update('sim', $ppid, $id, $ms);
                $this->update('date', $ppid, $id, $ms);
            }
        }
        if ($type == 'Soll speichern') {
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
        }  if ($type == 'Aktuelle Übernehmen') {
            foreach ($dateKMS as $id => $kms) {
                $this->update('sim', $ppid, $id, $kms);
            }
            foreach ($dateMS as $id => $ms) {
                $this->update('sim', $ppid, $id, $ms);
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
            //cpcDebug::cpc_debug("setKeyMilestones: Zurücksetzen Budget für PPID: $ppid mit BSID: $id ", '-ResetBudget');
            foreach ($dateSimKMS as $id => $kms) {
                $this->_resetBudget($ppid, $id);
            }
            //cpcDebug::cpc_debug("setMilestones: Zurücksetzen Budget für PPID: $ppid mit BSID: $id ", '-ResetBudget');
            foreach ($dateSimMS as $id => $ms) {
                $this->_resetBudget($ppid, $id);
            }
            $pp->PPProduktpass_SimNeu = 1;
            $pp->PPProduktpass_BudgetFix = 0;
            $pp->save();
        }
        //cpcDebug::cpc_debug("setKeyMilestones: Fertig für PPID: $ppid mit Typ: $type  SimNeu: ".$pp->PPProduktpass_SimNeu , '@SimMplan');
        return $this->GetMpForm($ppid);
    }
    private function _getMilestones()
    {
        $mss = PPBoardSpalteData::where('PPBoardSpalteData_IsKMS', 0)->orderBy('PPBoardSpalteData_Gruppe')->orderByRaw('PPBoardSpalteData_W2KMS')->get();
        $milestones = array();
        foreach ($mss as $ms) {
            $milestones[$ms->PPBoardSpalteData_KMS][] = $ms;
        }
        //echo('<pre>');        print_r($milestones);        exit;
        return $milestones;
    }
    /**
     * Gibt die gültigen Meilensteine für eine gegebene Ausmusterungsnummer zurück. Optional kann gefiltert werden, ob nur Key Milestones (KMS) oder nur Nicht-Key Milestones zurückgegeben werden sollen.
      * @param string $ausm Die Ausmusterungsnummer, für die die Meilensteine abgerufen werden sollen (z.B. '2201').
      * @param integer $isKeyMS Optionaler Filterparameter:
     * - 0: Nur Meilensteine zurückgeben (Standard)
     * - 1: Nur Key Milestones (KMS)
     * - 2: Alle Meilensteine zurückgeben, ohne Filterung nach KMS-Status
      * @return array Ein Array von Meilenstein-IDs, die für die angegebene Ausmusterungsnummer gültig sind und den optionalen KMS-Filterkriterien entsprechen.
      * @throws Exception Wenn ein Fehler bei der Datenbankabfrage auftritt.
     */
    private function getValidMileStones($ausm, $isKeyMS = 0 ){
        $query = DB::table('MPPlan');
        $query->where('MPPlan_ValidFromAusm', '<=', $ausm );
        $query->where('MPPlan_ValidToAusm', '>=', $ausm );
        if ($isKeyMS < 2){
            $query->where('MPPlan_IsKMS','=', $isKeyMS);
        }
        $milestoneIds = $query->get();
        $msids = array();
        foreach ($milestoneIds as $mid) {
            $msids[] = $mid->MPPlan_PPBoardSpalte_Id;
        }   
        return $msids;
    }
     private function getMilestones($ausm = '2201')
    {
        $msids = $this->getValidMileStones($ausm,0);
        $milestones = PPBoardSpalteData::whereIn('PPBoardSpalte_Id', $msids)
        ->orderBy('PPBoardSpalteData_Gruppe')->get();
        $msarray = array();
        if ($milestones) {
             foreach ($milestones as $ms) {
            $msarray[$ms->PPBoardSpalteData_KMS][] = $ms;
            //$debArray[$ms->PPBoardSpalteData_KMS][$ms->PPBoardSpalte_Id] = $ms->PPBoardSpalte_Bezeichnung;
        }
            return $msarray;
        }
        return null;
    }
    private function isMilestone($id, $ausm = '2201')
    {
        $vbs = $this->getValidMileStones($ausm,2);
        //echo("Realy isMilestone? Id: $id Ausm: ".$ausm.' <pre>');        print_r($vbs);        echo('</pre>');        exit;
        $bs = PPBoardSpalteData::whereIn('PPBoardSpalte_Id', $vbs)-> where('PPBoardSpalte_Id', $id)->get()->first();
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
                if ($this->isMilestone($t->PPTermine_PPBoardSpalte_id, $this->getAusm($ppid))) {
                    $ta[$t->PPTermine_PPBoardSpalte_id] = $t;
                }
            }
        }
        return $ta;
    }
    public static function germanToMySqlDate(string $date): ?string
    {
        $format =  'd.m.Y'; 
        $dt = DateTime::createFromFormat($format, $date);
        if (!$dt) {
            return null; // ungültiges Datum
        }
        return $dt->format('Y-m-d H:i:s');
    }
    public static function dadd($date, $w2kms)
    {
        if ($date == '') {
            return '';
        }
        if (strpos($date, '.') !== false) {
            $date = MasterplanController::germanToMySqlDate($date);
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
        //cpcDebug::cpc_debug(" dadd: Datum: $date mit W2KMS: $w2kms ergibt neues Datum: $res", '@SimMplan2');
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
    public static function sgetCRD($pp)
    {
        if ($pp->PPProduktpass_CRDWoche > 0) {
            $week = $pp->PPProduktpass_CRDWoche;
            $year = $pp->PPProduktpass_CRDJahr;
            $crd = self::getDateFromWeek($year, $week, 5);
        } else {
            $year = $pp->PPProduktpass_LieferterminJahr;
            $week = $pp->PPProduktpass_Liefertermin;
            $crd = self::getCRDFromDDP($year, $week);
        }
        return $crd;
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
    private static function getCRDFromDDP($year, $week)
    {
        $ddp = self::getDateFromWeek($year, $week, 5);
        $ddp->modify('-9 Weeks');
        return ($ddp);
    }
    private static   function getDateFromWeek($year, $week, $day = 1)
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
    public static function f($ppid, $bsid, $date)
    {
        //cpcDebug::cpc_debug(" testRulesDateCommenSoll: Aufruf für PPID: $ppid mit BSID: $bsid und Datum: $date", '@SimMplan7');
        $date = self::germanToMySqlDate($date);
        //Sollte hier evtl auf das CRD datum aus dem Produktpass zurückgegriffen werden?
        $crdTermin = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', 1059)->get()->first();
        if ($crdTermin) {
            $crddate = isset($crdTermin->PPTermine_SimDate)? $crdTermin->PPTermine_SimDate : '0000-00-00 00:00:00';
        } else {
            $crddate = '0000-00-00 00:00:00';
        }   
        $pstartTermin = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', 1136)->get()->first();
        if( $pstartTermin) {
            $pstart = isset($pstartTermin->PPTermine_SimDate)? $pstartTermin->PPTermine_SimDate : '0000-00-00 00:00:00';
        } else {
            $pstart = '0000-00-00 00:00:00';
        }
        $mpStart = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', 1037)->get()->first();
        $mpStartDate = '0000-00-00 00:00:00';
        if ($mpStart) {
                $mpStartDate = isset($mpStart->PPTermine_SimDate)? $mpStart->PPTermine_SimDate : '0000-00-00 00:00:00';
        }
        //Regel 1: Nach MPStart
        /*
            1045	SER1 0-5% - Megastep
            1047	SER2 20-35% - Megastep
            1049	20% PSI TARGA
            1050	SER3 35-90% - Megastep
            1055	SER4 90-100% - Megastep
            1057	100% PSI
            1121	30% Sample picking
        */
        $mustBeLaterMPStart = array(
                                1045,
                                1046,
                                1047,
                                1048,
                                1049,
                                1050,
                                1051,
                                1052,
                                1053,
                                1055,
                                1056,
                                1057,
                                1121,
                                1122,
                                1127,
                                1133,
                                1134,
                                1155,   
                                1153,
                                1152,
                                1150,
                                1149    
                );
        $beforAfterMPFail = true;
        if (in_array($bsid, $mustBeLaterMPStart)) {
            if ($date < $mpStartDate){
                //cpcDebug::cpc_debug("    KMS (Before MP Start, mustbe later)", '@SimMplan7');
                $beforAfterMPFail = true;
                //return false;
            }
            //self::compareDatesTermine( $ppid, $bsid, $mpStartDate, 'after');
        }
        //Regel 2: Vor MPStart
        /*
            1016	Prototypen Freigabe
            1022	Trial run PSI
            1039	EUG Sample picking / PSI (bei TÜV Mark)
            1040	EUG-VER Megastep
        */
        $mustBeBeforeMPStart = array(
                                    1008,
                                    1013,
                                    1014,
                                    1015,
                                    1016,
                                    1020,
                                    1021,
                                    1022,
                                    1023,
                                    1024,
                                    1026,
                                    1027,
                                    1028,
                                    1034,
                                    1035,
                                    1038,
                                    1039,
                                    1040,
                                    1042,
                                    1043,
                                    1044,
                                    1124,
                                    1148,
                                    1147,
                                    1143
                               );
        if (in_array($bsid, $mustBeBeforeMPStart)) {
            if ($date > $mpStartDate){
                //cpcDebug::cpc_debug("    (After MP Start, must be earlier) Return false", '@SimMplan7');
                $beforAfterMPFail = true;
                //return false;
            }
        }    
        $col = self::testDate2AfterCRD($bsid, $date, $crddate);
        ////cpcDebug::cpc_debug("    (Before MP Start) Return false", '@SimMplan7');
        if ($col){
            return true;
        } else {
            $col =  self::testDate2BeforProjectStart($bsid, $date, $pstart);
            ////cpcDebug::cpc_debug(" Project start testDate: Prüfung BeforProjectStart für BSID: $bsid mit Datum: $date PStart: $pstart => ".$col, '@SimMplan7');
        }
        ////cpcDebug::cpc_debug(" testDate: Ergebnis für BSID: $bsid mit Datum: $date CRD: $crddate PStart: $pstart => ".(($col) ? $col : 'OK'), '@SimMplan7');
        return $col && $beforAfterMPFail;
    }
    private static function compareDatesTermine ($ppid, $bsid, $cmpDatedate,    $beforAfter = 'after'){
        ////cpcDebug::cpc_debug(" compareDatesTermine: Aufruf für PPID: $ppid mit BSID: $bsid und CMPDate: $cmpDatedate Regel: $beforAfter", '@SimMplan6');
        $termine = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalteData_KMS', $bsid)->get();
        if ($termine) {
            foreach ($termine as $t) {
                $sollDate = isset($t->PPTermine_SimDate)? $t->PPTermine_SimDate : '0000-00-00 00:00:00';
                if ($beforAfter == 'after'){
                    if ($sollDate > $cmpDatedate){
                        //cpcDebug::cpc_debug(" testDate: Regel After verletzt für BSID: $bsid mit altem Datum: $sollDate CMPDate: $cmpDatedate => false", '@SimMplan6');
                        return false;
                    }
                } else {
                    if ($sollDate < $cmpDatedate){
                        //cpcDebug::cpc_debug(" testDate: Regel Befor verletzt für BSID: $bsid mit altem Datum: $sollDate CMPDate: $cmpDatedate => false", '@SimMplan6');
                        return false;
                    }
                }
            }
        }
    }
    public static function testRulesDate($bsid, $date, $crddate, $pstart)
    {
        if (strpos($crddate, '.') !== false) {
            $crddate = MasterplanController::germanToMySqlDate($crddate);
        }
        if (strpos($pstart, '.') !== false) {
            $pstart = MasterplanController::germanToMySqlDate($pstart);
        }
        if (strpos($date, '.') !== false) {
            $date = MasterplanController::germanToMySqlDate($date);
        }       
        $fail = self::testDate2AfterCRD($bsid, $date, $crddate);
        if ($fail){
            //cpcDebug::cpc_debug(" CRD testDate:( $bsid) AFTER ( $crddate) ", '-SimMplanC');
            return true;
        } else {
            $fail =  self::testDate2BeforProjectStart($bsid, $date, $pstart);
            if ($fail){
                //cpcDebug::cpc_debug(" Projectstart testDate: ( $bsid)  BEFORE ( $pstart ) ", '-SimMplanC');
                return true;
            }
        }
        ////cpcDebug::cpc_debug("testDate: INBETWEEN OK  $pstart < $date < $crddate ", '-SimMplanB');
        return $fail;
    }
    private function testDate2AfterCRD($bsid, $date, $crdDate)
    {
        $ignore = array(
            1059,    //CRD
            1060,    //ETD
            1061,    //DDP
            1062,    //Werbefreigabe
            1063,    //LT Land
        );
        if (in_array($bsid, $ignore)) {
            return false;
        }
        if ($date == '' or is_null($date) or $date == '0000-00-00 00:00:00'){
            return false;
        }
        try {
            $d = new DateTimeImmutable($date);
            $crd = new DateTimeImmutable($crdDate);
            if ($d > $crd){
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return true;
        }
    }
    public static  function testDateLidlDeadlines($ppid, $bsid, $date)
    {
        //cpcDebug::cpc_debug(" testDateLidlDeadlines: Aufruf für BSID: $bsid mit Datum: $date", '-SimMplanFKE');
        //cpcDebug::cpc_debug(" testDateLidlDeadlines: Aufruf für BSID: $bsid mit Datum: $date", '-SimMplanFKE');
        $dl = array();
        $dl[] = array('ALT' => array('w2lt' => '13', 'MSs' =>array(1127,1152)));
        $dl[] = array('30Prz' => array('w2lt' => '16', 'MSs' =>array(1121,1122)));
        $dl[] = array('EUG' => array('w2lt' => '17', 'MSs' =>array(1039,1147)));
        $dl[] = array('100Prz' => array('w2lt' => '11', 'MSs' =>array(1057)));
        foreach ($dl as $d) {
            foreach ($d as $key => $val) {
                if (in_array($bsid, $val['MSs'])) {
                    //cpcDebug::cpc_debug("          Gefunden: $key BSID: $bsid mit Datum: $date", '-SimMplanFKE3');
                    $ret = self::testDate2LT($ppid, $bsid, $date, $val['w2lt']);
                    //cpcDebug::cpc_debug("          testDateLidlDeadlines: Rückgabe für BSID: $bsid mit Datum: $date => ". $ret ? 'true' : 'false', '-SimMplanFKE3');
                    return $ret;
                }
            }
        }
        //cpcDebug::cpc_debug("          testDateLidlDeadlines: Rückgabe für BSID: $bsid mit Datum: $date => true", '-SimMplanFKE3');
        return true;   
    }
    private function testDate2LT($ppid, $bsid, $date, $diff)
    {
        if ($date == '' or is_null($date)){
            return false;
        }
        try {
            $d = new DateTimeImmutable($date);
            $dl = self::getLT($ppid);
            $dl->modify('-' . $diff . ' weeks');
            //cpcDebug::cpc_debug("             testDate2LT: Prüfung BSID: $bsid mit Datum: ".$d->format('d.m.Y')." und LT: ".$dl->format('d.m.Y')." mit Diff: $diff ", '-SimMplanFKE3');
            if ($d > $dl){
                //cpcDebug::cpc_debug("             testDate2LT: Datum liegt nach DEADline", '-SimMplanFKE3');
                return false;
            }
            return true;
        } catch (Exception $ex) {
            return true;
        }
    }
    private function testDate2BeforProjectStart($bsid, $date, $pstart)
    {
        if ($date == '' or is_null($date) or $date == '0000-00-00 00:00:00'){
            return true;
        }
        try {
            $d = new DateTimeImmutable($date);
            $start = new DateTimeImmutable($pstart);
            if ($d < $start){
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return true;
        }
    }
    private function getLT($ppid)
    {
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
            if ($pp) {
                $year = $pp->PPProduktpass_LieferterminJahr;
                $week = $pp->PPProduktpass_Liefertermin;
                $ret = self::getDateFromWeek($year, $week, 5);
                ////cpcDebug::cpc_debug(" getLT: Gefundener LT Termin für PPID: $ppid ist DDP am: ".$ret->format('d.m.Y'), '-SimMplanX');
                return $ret;
            }
            else {
                return new DateTimeImmutable('0000-00-00 00:00:00');
            }
    }
    private function setTopLeftCell($col, $row){
        $cell = $this->getCell($col, $row);
        $value =  $this->worksheet->getCell($cell)->getCalculatedValue();
        $this->setCellValueKeep($cell, $value.'!');
    }
    public static function checkDateDiff(string $date1, string $date2): string {
        return ($date1 !== $date2) ? 'color:red;' : '';
    }
    public static function testMilestoneIsInBudget($t): bool
    {
        $date   = $t->PPTermine_DatumStart;
        $budget = $t->PPTermine_ManSollDate;
        if (
            empty($date) ||
            empty($budget) ||
            $date === '0000-00-00 00:00:00'
        ) {
            return false;
        }
        try {
            $d  = new DateTimeImmutable($date);
            $db = new DateTimeImmutable($budget);
            return $db >= $d;
        } 
        catch (Exception $ex) {
            return false;
        }
    }
    public static function testDateBefore($d1, $d2): bool
    {
        //cpcDebug::cpc_debug(" testDateBefore: Aufruf mit Datum1: $d1 und Datum2: $d2", '-IncTest');
        if (
            empty($d1) ||
            empty($d2) ||
            $d1 === '0000-00-00 00:00:00' ||
            $d2 === '0000-00-00 00:00:00'
        ) {
            return false;
        }
        try {
            $d  = new DateTimeImmutable($d1);
            $db = new DateTimeImmutable($d2);
            //cpcDebug::cpc_debug(" testDateBefore: Vergleich $d1 < $d2 => ".(($db < $d) ? 'true' : 'false'), '-IncTest');
            return $db >= $d;
        } 
        catch (Exception $ex) {
            return false;
        }
    }
    public function calcMS()    {
        $ppid = Input::get('ppid');
        $kmsId = Input::get('kmsid');
        $type = Input::get('type');
        //cpcDebug::cpc_debug("***** START calcMS: Aufruf für PPID: $ppid mit BSID: $kmsId ", '-calcMS');
        $ret = $this->_calcMS($ppid, $kmsId, $type);
        if ($ret === false){
            return Response::json([
                'ok'          => false,
                'message'     => 'keine Termine gefunden'
            ]);
        }
        return Response::json([
                'ok'          => true,
                'message'     => 'berechnet',
                'data'        => $ret
            ]);
    }
    private function getSubMs($kms, $ppid){
        //cpcDebug::cpc_debug("A_getSubMs: Aufruf für KMS BSID: $kms ", '-calcMS');
        $validMS = $this->getValidMileStones($this->getAusm($ppid),0);
        $mss = PPBoardSpalteData::whereIn('PPBoardSpalte_Id', $validMS)->where('PPBoardSpalteData_KMS', $kms)->where('PPBoardSpalteData_IsKMS', '!=',1)->get();
        $mssIn = array();
        $mssW2KMS = array();
        foreach ($mss as $ms) {
            $mssW2KMS[$ms->PPBoardSpalte_Id] =  $ms->PPBoardSpalteData_W2KMS; 
            $mssIn[] = $ms->PPBoardSpalte_Id;
        }
        $ret = array('BSId' => $mssIn, 'W2KMS' => $mssW2KMS);
        //cpcDebug::cpc_debug("B_getSubMs: Rückgabe für KMS BSID: $kms sind BSID: ".implode(',', $mssIn), '-calcMS');
        return $ret;
    }
    private function _calcMS($ppid, $id, $type)
    {
        $kmsT = PPTermine::where('PPTermine_Id', $id)->get()->first();
        if(!$kmsT){ return false;}
        if (!isset($kmsT->PPTermine_ManSollDate)){ return false;}
        $kmsDate = $kmsT->PPTermine_ManSollDate;
        if ($type != 'Budget'){
            $kmsDate = $kmsT->PPTermine_SimDate;
        }
        //cpcDebug::cpc_debug("1_calcMS: Gefundener KMS ( $kmsDate ) Termin für PPID: $ppid mit BSID: ".$kmsT->PPTermine_PPBoardSpalte_id, '-calcMS');
        $bs = $kmsT->PPTermine_PPBoardSpalte_id;
        $kms = PPBoardSpalteData::where('PPBoardSpalte_Id', $bs)->get()->first();
        if(!$kms){ return false;}
        //cpcDebug::cpc_debug(" 2_calcMS: Gefundener KMS BoardSpalteData für PPID: $ppid mit BSID: $bs", '-calcMS');
        if ($kms->PPBoardSpalteData_IsKMS == 0){ return false;}
        $bsps =$this->getSubMs($kms->PPBoardSpalte_Id, $kmsT->PPTermine_PPProduktpass_Id);
        //cpcDebug::cpc_debug(" 3_calcMS: Gefundene SubMS für KMS BoardSpalteData ID: ".$kms->PPBoardSpalte_id." sind: ".implode(',', $bsps['BSId']), '-calcMS');
        $ts = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->whereIn('PPTermine_PPBoardSpalte_id', $bsps['BSId'])->get();
        if ($ts) {
            //cpcDebug::cpc_debug("4_calcMS: Gefundene Termine für PPID: $ppid sind: ".count($ts), '-calcMS');
            //cpcDebug::cpc_debug($bsps, '-calcMS');
            $retArr = array();
            foreach ($ts as $t) {
                $dd = MasterplanController::dadd($kmsDate, $bsps['W2KMS'][$t->PPTermine_PPBoardSpalte_id]);
                //cpcDebug::cpc_debug("5_calcMS: ". $t->PPTermine_PPBoardSpalte_id." auf ". $dd, '-calcMS');
                $retArr[] = array('BSID' => $t->PPTermine_PPBoardSpalte_id, 'Date' => $dd);
                if($type == 'Budget'){
                $t->PPTermine_ManSollDate = $dd;
                }
                if ($type == 'Soll') {
                    $t->PPTermine_SimDate = $dd;
                }
                $t->save();
            }
            return $retArr;
        }
        //cpcDebug::cpc_debug("4_calcMS: Keine Termine für PPID: $ppid gefunden", '-calcMS');
        return false;
    }
    public function kmssave(){
        $ppid = Input::get('ppid');
        $bsid = Input::get('bsid');
        $value = Input::get('value');
        $type = Input::get('type');
        if ($type == 'budget_KMS'){
            $att = 'PPTermine_ManSollDate';
        } else{
            $att = 'PPTermine_SimDate';
        }
        //cpcDebug::cpc_debug("***** START kmssave: Aufruf für PPID: $ppid mit BSID: $bsid und Wert: $value Feld: $att", '-kmssave');
        $t = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $bsid)->get()->first();
        if(!$t){
            //cpcDebug::cpc_debug(" kmssave: Kein Termin für PPID: $ppid mit BSID: $bsid gefunden ", '-kmssave');
            return Response::json([
                'ok'          => false,
                'message'     => 'Kein Termin gefunden'
            ]);
        }
        $t->{$att} = $this->date2MySql($value);
        if ($type != 'budget_KMS'){
            //$t->PPTermine_DatumStart = $t->{$att};
        }
        $t->save();
        //cpcDebug::cpc_debug(" kmssave: Termin für PPID: $ppid mit BSID: $bsid gespeichert ", '-kmssave');
        return Response::json([
            'ok'          => true,
            'message'     => 'gespeichert'
        ]);
    }
    public static function testBudget($budget, $date){
        //cpcDebug::cpc_debug(" testBudget: Aufruf mit Budget: $budget und Datum: $date", '-IncTest');
        if (empty($budget) || $budget === '0000-00-00 00:00:00'){
            return true;
        }
        if (empty($date) || $date === '0000-00-00 00:00:00'){
            return false;
        }
        try {
            $b = new DateTimeImmutable($budget);
            $d = new DateTimeImmutable($date);
            //cpcDebug::cpc_debug(" testBudget: **************************", '-IncTest');
            //cpcDebug::cpc_debug($d, '-IncTest');
            //cpcDebug::cpc_debug($b, '-IncTest');
            if ($d <= $b){
                //cpcDebug::cpc_debug(" testBudget: true", '-IncTest');
                return true;
            }
            //cpcDebug::cpc_debug(" testBudget: false", '-IncTest');
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }
    public function debugTestAllDates($ppid){
        $result = $this->testAllDates($ppid);
        return Response::json( $result,
                                200,
                                [],
                                JSON_PRETTY_PRINT);
    }
   private function testAllDates(int $ppid): array
    {
        $violations = self::mplanTest($ppid);
        return [
            'ok' => empty($violations),
            'violations' => $violations,
            'count' => count($violations),
        ];
    }
    public static function testDate_Weeks2DDP($tDate, $weeks,  $lt){
            //cpcDebug::cpc_debug(" testDate_Weeks2DDP: Aufruf mit Datum: $tDate und Wochen: $weeks und LT: $lt", '-IncTest');
            if (empty($tDate) || $tDate === '0000-00-00 00:00:00'){
                return true;
            }
            if (empty($lt) || $lt === '0000-00-00 00:00:00'){
                return false;
            }
            try {
                $t = new DateTimeImmutable($tDate);
                $l = new DateTimeImmutable($lt);
                $l->modify("-$weeks week");
                //cpcDebug::cpc_debug(" testDate_Weeks2DDP: Vergleich $tDate < ". $l->format('Y-m-d'), '-IncTest');
                if ($t < $l){
                    //cpcDebug::cpc_debug(" testDate_Weeks2DDP: true", '-IncTest');
                    return true;
                }
                //cpcDebug::cpc_debug(" testDate_Weeks2DDP: false", '-IncTest');
                return false;
            } catch (Exception $ex) {
                return false;
            }
    }
    public static function mplanTest(int $ppid){
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->first();
        if (!$pp) {
            throw new \RuntimeException('Produktpass nicht gefunden');
        }
        $pstartTermin = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)
            ->where('PPTermine_PPBoardSpalte_id', 1136)
            ->first();
        $pstartBudget = $pstartTermin->PPTermine_ManSollDate ?? '0000-00-00 00:00:00';
        $crdStr = self::sgetCRD($pp)->format('Y-m-d H:i:s');
        $violations = [];
        foreach (PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get() as $t) {  
            if (self::isOKStatus($t->PPTermine_Status)){
                /* keine weiter Prüfung notwendig */
                //cpcDebug::cpc_debug(" mplanTest: Termin mit BSID: ".$t->PPTermine_PPBoardSpalte_id." hat OK Status: ".$t->PPTermine_Status." => keine Prüfung notwendig", '-SimMplanTest9');
                continue;
            }
            if($t->PPTermine_ManSollDate == '0000-00-00 00:00:00'){
                //cpcDebug::cpc_debug(" mplanTest: Termin mit BSID: ".$t->PPTermine_PPBoardSpalte_id." hat kein Budget Datum => keine Prüfung möglich", '-SimMplanTest9'); 
                continue;
            }
            if($t->PPTermine_DatumEnde !== '0000-00-00 00:00:00'){
                //cpcDebug::cpc_debug(" mplanTest: Termin mit BSID: ".$t->PPTermine_PPBoardSpalte_id." hat ein Ende Datum => keine Prüfung notwendig", '-SimMplanTest9');
                continue;
            }
            $spalte = PPBoardSpalteData::where('PPBoardSpalte_Id', $t->PPTermine_PPBoardSpalte_id)->first();
            if (!$spalte) {
                //cpcDebug::cpc_debug(" mplanTest: Keine Spalte gefunden für BSID: ".$t->PPTermine_PPBoardSpalte_id." => keine Prüfung möglich", '-SimMplanTest9');
                continue;
            }
            if ($spalte->PPBoardSpalteData_KMS === null or $spalte->PPBoardSpalteData_KMS === 0) {
                //cpcDebug::cpc_debug(" mplanTest: Termin mit BSID: ".$t->PPTermine_PPBoardSpalte_id." hat kein KMS => keine Prüfung notwendig", '-SimMplanTest9');
                continue;
            }
            $spalteBez = $spalte ? ($spalte->PPBoardSpalte_Bezeichnung ?? 'Unbekannte Spalte') : 'Unbekannte Spalte';
            $rulesBudgetFail = self::testRulesDate(
                $t->PPTermine_PPBoardSpalte_id,
                $t->PPTermine_ManSollDate,
                $crdStr,
                $pstartBudget
            );
            $rulesSimFail = self::testRulesDate(
                $t->PPTermine_PPBoardSpalte_id,
                $t->PPTermine_SimDate,
                $crdStr,
                $pstartBudget
            );
            $rulesAktFail = self::testRulesDate(
                $t->PPTermine_PPBoardSpalte_id,
                $t->PPTermine_DatumStart,
                $crdStr,
                $pstartBudget
            );
            $budgetSimOk = self::testBudget(
                $t->PPTermine_ManSollDate,
                $t->PPTermine_SimDate
            );
            $budgetAktOk = self::testBudget(
                $t->PPTermine_ManSollDate,
                $t->PPTermine_DatumStart
            );
            /*
                100% PSI            11 Wochen vor DDP
                    1057	100% PSI
                30% SPU             16 Wochen vor DDP
                    1121	30% SPU
                ALT Labor Prüfung   13 Wochen vor DDP
                    1127	ALT Labor Prüfung
                EUG SPU LIDL QS     17 Wochen vor DDP
                    1039	EUG SPU LIDL QS
            */
            $budgetDateLidlDeadlineOK = self::testDateLidlDeadlines($t->PPTermine_PPProduktpass_Id, $t->PPTermine_PPBoardSpalte_id, $t->PPTermine_ManSollDate);
            $simDateLidlDeadlineOK = self::testDateLidlDeadlines($t->PPTermine_PPProduktpass_Id, $t->PPTermine_PPBoardSpalte_id, $t->PPTermine_SimDate);
            $istDateLidlDeadlineOK = self::testDateLidlDeadlines($t->PPTermine_PPProduktpass_Id, $t->PPTermine_PPBoardSpalte_id, $t->PPTermine_DatumStart);
            $statArray['start2crd']['budget'] = 'ok';
            $statArray['start2crd']['sim'] = 'ok';
            $statArray['start2crd']['akt'] = 'ok';
            $statArray['overBudget']['sim'] = 'ok';
            $statArray['overBudget']['akt'] = 'ok';
            $statArray['lidlDeadline']['budget'] = 'ok';
            $statArray['lidlDeadline']['sim'] = 'ok';
            $statArray['lidlDeadline']['akt'] = 'ok';  
            unset($statArray['simAktDiff']['aktCol'] ); 
            if ($rulesBudgetFail) {
                $statArray['start2crd']['budget'] = 'fail';
            }
            if ($rulesSimFail) {
                $statArray['start2crd']['sim'] = 'fail';
            }
            if ($rulesAktFail) {
                $statArray['start2crd']['akt'] = 'fail';
            }
            if (!$budgetSimOk) {
                    $statArray['overBudget']['sim'] = 'fail';
            }   
            if (!$budgetAktOk) {
                    $statArray['overBudget']['akt'] = 'fail';
            } 
            if (!$budgetDateLidlDeadlineOK) {
                    $statArray['lidlDeadline']['budget'] = 'fail';
            }
            if (!$simDateLidlDeadlineOK) {
                    $statArray['lidlDeadline']['sim'] = 'fail';
            }            
            if (!$istDateLidlDeadlineOK) {
                    $statArray['lidlDeadline']['akt'] = 'fail';
            }
            if ($t->PPTermine_DatumStart != $t->PPTermine_SimDate) {
                //cpcDebug::cpc_debug(" mplanTest: Termin mit BSID: ".$t->PPTermine_PPBoardSpalte_id." hat unterschiedliche SimDate und AktDate => diff [" . $t->PPTermine_DatumStart . " - " . $t->PPTermine_SimDate . "]", '-SimMplanTest10');
                    $statArray['simAktDiff']['aktCol'] = 'diff';
            } 
                $violations[$ppid][$t->PPTermine_Id] = [
                            'isKMS' => $spalte->PPBoardSpalteData_IsKMS,
                            'kmsid' => $spalte->PPBoardSpalteData_KMS,
                            'bsid' => $t->PPTermine_PPBoardSpalte_id,
                            'spalte' => $spalteBez,
                            'budget' => $t->PPTermine_ManSollDate,
                            'plan' => $t->PPTermine_SimDate,
                            'aktuell' => $t->PPTermine_DatumStart,
                            'start' => $pstartBudget,
                            'crd' => $crdStr,
                            'stats' => $statArray
                        ];
            }  
        return $violations;
    }
    private static function isOKStatus($status){
        $stat = PPStati::where('PPStati_Status', $status)->first();
        if (! $stat){
            return false;
        }
        if($stat->PPStati_OKStatus === 1) {
            return true;
        }   
        return false;
     }
     public static function getColor($term, $kind){
        /*  $Kind in budget,sim,akt
            "term": {
                        "start2crd": {
                            "sim": "fail"
                        },
                        "overBudget": {
                            "akt": "fail"
                        },
                        "simAktDiff": {
                            "akt": "diff"
}
                    }
                }
        */
        //cpcDebug::cpc_debug(" getColor: Aufruf mit Kind: $kind und Term: ".json_encode($term,JSON_PRETTY_PRINT), '-SimPlanFKE');
        $ret['color']= '--color-ok';
        if ($kind == 'aktCol' ) {
            $ret['color']= '--color-diff-ok';
        }
        $ret['reason'] = 'OK';
        try{
            if (isset($term['stats']['overBudget']) && isset($term['stats']['overBudget'][$kind]) && $term['stats']['overBudget'][$kind] === 'fail') {
                $ret['color']  = '--color-ueber-budget';
                $ret['reason'] = 'Über Budget';
            }
            if (isset($term['stats']['lidlDeadline']) && isset($term['stats']['lidlDeadline'][$kind]) && $term['stats']['lidlDeadline'][$kind] === 'fail') {
                $ret['color']  = '--color-lidl-deadline';
                $ret['reason'] = 'Lidl Deadline nicht eingehalten';
            }
            if (isset($term['stats']['simAktDiff']) && isset($term['stats']['simAktDiff'][$kind])) {
                $ret['color']  = '--color-sim-akt-diff';
                $ret['reason'] = 'Anpassungen nicht aktuell';
            } 
            if (isset($term['stats']['start2crd']) && isset($term['stats']['start2crd'][$kind]) && $term['stats']['start2crd'][$kind] === 'fail') {
                $ret['color']  = '--color-start-2-crd';
                $ret['reason'] = 'Termin liegt nicht zwischen Projektstart und CRD';
            } 
        } catch (Exception $ex) {
            $ret['color'] = '--color-debug';
            $ret['reason'] = 'Fehler Exception: '.$ex->getMessage();
        }
        //cpcDebug::cpc_debug(" getColor: Rückgabe ".json_encode($ret,JSON_PRETTY_PRINT), '-SimPlanFKE');
        return $ret;
    }
}