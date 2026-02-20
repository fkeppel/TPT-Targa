<?php
define('STATUS_GREEN', '25,157,45');
define('STATUS_ORANGE', '255,255,153');
define('STATUS_RED', '255, 199, 206');
define('STATUS_UNDEF', '210,210,210');
define('STATUS_BLUE', '189,215,238');
define('STATUS_GRAY', '180,180,180');
define('STATUS_LIGHTGRAY', '240,240,240');
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
class TermineController extends BaseController
{
    /**
     * Display a listing of the resource.
     * GET /projects
     *
     * @return Response
     */
    private $sortTree = array();
    private $start_time;
    private $end_time;
    private $mailer_config;
    private $mail;
    public function getTest($id)
    {
        return View::make('test' . $id);
    }
    public function testConfig()
    {
        /* $mailer_config = Config::get('app.mailer');
        print_r($mailer_config);
        exit; */
        echo ('No Test availabel');
        exit;
    }
    private function ddfk($var, $exit = true)
    {
        if (strtoupper(Auth::user()->PPMitarbeiter_Kuerzel) == 'FKE') {
            echo ('<pre>');
            print_r($var, false);
            echo ('<pre>');
            if ($exit) {
                exit;
            }
        }
    }
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     * GET /projects/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     * POST /projects
     *
     * @return Response
     */
    public function store()
    {
        //
    }
    private function _log($str)
    {
        $fh = fopen(storage_path() . '/logs/tmp_log_fke.log', 'a+');
        fwrite($fh, print_r($str, true));
        fwrite($fh, '#################\n');
        fclose($fh);
    }
    public function getAusblenden($id)
    {
        $col = Session::get('cpcCOLS');
        if (!isset($col)) {
            $col = array();
        }
        $col[$id] = 1;
        //cpcDebug::cpc_debug("Ausblenden: " . print_r($col, true), "FKE2");
        Session::put('cpcCOLS', $col);
        return 1;
        //cpcDebug::cpc_debug("Ausblenden: ".print_r($col,true),"FKE");
    }
    public function saveColStatus()
    {
        $col = Session::get('cpcCOLS');
        //cpcDebug::cpc_debug("saveColStatus: " . print_r($col, true), "FKECOL");
        var_dump($col);
        exit;
        return Response::json(array('result' => 'OK', 'cont' => 'Daten gesichert'));
    }
    public function getEinblenden($id)
    {
        $col = Session::get('cpcCOLS');
        if (!isset($col)) {
            $col = array();
        }
        $col[$id] = 0;
        //cpcDebug::cpc_debug("Ausblenden: " . print_r($col, true), "FKE2");
        Session::put('cpcCOLS', $col);
        return 1;
        //cpcDebug::cpc_debug("Ausblenden: ".print_r($col,true),"FKE");
    }
    public function getMarkRow($id)
    {
        Session::put('cpcMarkRow', $id);
        return 1;
        //cpcDebug::cpc_debug("Ausblenden: ".print_r($col,true),"FKE");
    }
    public function getEinblendenAlle()
    {
        $col = Session::forget('cpcCOLS');
        return 1;
        //cpcDebug::cpc_debug("Ausblenden: ".print_r($col,true),"FKE");
    }
    private function getStati($pstati)
    {
        $qstati = array();
        if (strlen($pstati) > 0) {
            $qstati = explode('x', $pstati);
        }
        //var_dump($pstati); echo("<br>");exit;
        $stati = PPStati::whereIn("PPStati_Id", $qstati)->get();
        $ret = array();
        $ret['Neu'] = 'Neu';
        foreach ($stati as $status) {
            $ret[$status->PPStati_Status] = $status->PPStati_Status;
        }
        return $ret;
    }
    private function deleteTermine($tid)
    {
        foreach ($tid as $t) {
            echo ("       Termin: " . $t['id'] . " " . $t['spalteid'] . "  Status: " . $t['status']);
            if ($t["delete"] == 1) {
                $tdel = PPTermine::find($t['id']);
                $tdel->delete();
                echo ("<b> wird gelöscht! </b><br>");
            } else {
                echo (" bleibt! <br>");
            }
        }
    }
    private function getPO($ppid)
    {
        $ret = array('PO' => false, 'Lief' => false);
        $po = DB::table('PPPurchase')->where('PPPurchase_PPProduktpass_id', '=', $ppid)->orderBy('PPPurchase_Id', 'desc')->first();
        if ($po) {
            $lief = DB::table('PPAdressen')->where('Matchcode', '=', $po->PPPurchase_Supplier)->first();
            $ret['PO'] = $po;
        }
        if ($lief) {
            $ret['Lief'] = $lief;
        }
        //dd($ret);
        return $ret;
    }
    private function getAB($ppid)
    {
        $ab = DB::table('PPAB')->where('PPAB_PPProduktpass_id', '=', $ppid)->orderBy('PPAB_Id')->first();
        return $ab;
    }
    private function getProject($ppid)
    {
        $pp = DB::table('PPProduktpass')->where('PPProduktpass_Id', '=', $ppid)->first();
        if ($pp) {
            return $pp->PPProduktpass_PPProjekte_Projekt;
        }
        return "";
    }
    private function getLC($ppid)
    {
        $pps = DB::table('PPProduktpass')->where('PPProduktpass_PPProjekte_Projekt', '=', $this->getProject($ppid))->get();
        if ($pps) {
            foreach ($pps as $pp) {
                $lc = DB::table('PPLC')->where('PPLC_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->first();
                if ($lc and !is_null($lc->PPLC_FinalDate) and strlen($lc->PPLC_FinalDate) > 0) {
                    return $lc;
                }
            }
        }
        return null;
    }
    private function getPOStatus($statusid)
    {
        $sts = DB::table('PPStatiX')->where('PPStati_Id', '=', $statusid)->first();
        if ($sts) {
            return $sts->PPStati_Status;
        }
        return 'N.N.';
    }
    private function getMengenSplit($ppid)
    {
        $ms = DB::table('PPProduktpass_Menge')->where('PPProduktpass_Menge_PPProduktpass_id', '=', $ppid)->orderBy('PPProduktpass_Menge_Id')->get();
        $res = "";
        foreach ($ms as $m) {
            if ($m->PPProduktpass_Menge_Country == "IT" or $m->PPProduktpass_Menge_Country == "FR" or $m->PPProduktpass_Menge_Country == "CH") {
                if (!is_null($m->PPProduktpass_Menge_TotalSalePerUnit) and $m->PPProduktpass_Menge_Quantity > 0) {
                    $res = $res . $m->PPProduktpass_Menge_Country . " ";
                }
            }
        }
        if (strlen(trim($res)) == 0) {
            $res = "-/-";
        }
        return trim($res);
    }
    private function getTermineMusterung($boardid)
    {
        $tm = PPBoardSpalte::where('PPBoardSpalte_PPBoard_Id', $boardid)->orderBy('PPBoardSpalteX_Sort')->get();
        if ($tm) {
            return $tm;
        }
        return null;
    }
    private function getTerminePopUp($ppid, $board)
    {
        //echo('Hier');exit;
        $tm = $termines = DB::table('v_PPTerminePopUp')->where('PPBoardSpalte_PPBoard_Id', '=', $board)->where('PPTermine_PPProduktpass_Id', '=', $ppid)->orderBy ('PPBoardSpalteX_Sort')->get();
        if ($tm) {
            return $tm;
        }
        return null;
    }
    private function IsValid_OldIAN($alt_IAN, $ausm)
    {
        cpcDebug::cpc_debug("XIsValid_OldIAN: ".$alt_IAN.'_'.$ausm, "@FKE");
        if (strlen(trim($ausm)) != 4 ){
            cpcDebug::cpc_debug("XIsValid_OldIAN: Nein ausm ", "@FKE");
            return false; 
        }
        $pp = tPPProduktpass::where('PPProduktpass_IAN', '=', $alt_IAN)->where('PPProduktpass_Ausmusterungnummer','like',$ausm.'%')->get()->first();
        if ($pp) {
            cpcDebug::cpc_debug("XIsValid_OldIAN: Ja", "@FKE");
            return true;
        }
        cpcDebug::cpc_debug("XIsValid_OldIAN: Nein", "@FKE");
        return false;
    }
    public function changeManSollonChangeCRD(){
        $ppid = 2507;
        $terminLeer = '0000-00-00 00:00:00';
        $pp = tPPProduktpass::find($ppid);
        $crd = $this->calcCRD($ppid);
        $termine = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
        foreach($termine as $termin){
            $thisFriday = new DateTime();
            $thisFriday->setIsoDate($thisFriday->format('Y'), $thisFriday->format('W'),5);
            $manSollDate = new DateTime($termin->PPTermine_ManSollDate);
            $diffManSoll =  $thisFriday->diff($manSollDate, true);
            $w2ManSoll = floor($diffManSoll->format('%R%a')/7); 
            $manSollDate = new DateTime();
            $manSollDate = clone $crd;
            $interval = 'P'.$termin->PPTermine_ManSoll.'W';
            $manSollDate = $manSollDate->sub(new DateInterval($interval));
            echo($termin->PPTermine_ManSoll."  ".$termin->PPTermine_ManSollDate." Interval:  $interval  ".$manSollDate->format('W/y'). " ".$manSollDate->format('Y-m-d')." W2MS: ".$w2ManSoll."  <br>");
            $termin->PPTermine_ManSollDateX = $terminLeer;
            if ($termin->PPTermine_ManSollDate == $terminLeer){
                $termin->PPTermine_ManSollDate = $manSollDate->format('Y-m-d');
            }
            $termin->save();
        }
    }
    public function  changeManSoll($internerStatus='PLAN'){
        $pps = tPPProduktpass::where('InternerStatus', $internerStatus)->where('PPProduktpass_IAN', 'not like', '%rev%')->get();
        $i=0;
        foreach($pps as $pp){
            $i++;
            echo($i.'.  Bearbeite: ');
            $this->_changeManSoll($pp->PPProduktpass_Id);
            echo("  OK<br>");
        }
        echo('FERTIG');
    }
    private function _changeManSoll($ppid){
        //$ppid = 2507;
        $terminLeer = '0000-00-00 00:00:00';
        $pp = tPPProduktpass::find($ppid);
        $crd = new DateTime();
        $crd->setIsoDate($pp->PPProduktpass_LieferterminJahr, $pp->PPProduktpass_Liefertermin,5);
        $crd = $crd->sub(new DateInterval('P10W'));
        echo($pp->PPProduktpass_IAN ."  ". $pp->PPProduktpass_Artikelbezeichnung. "    LT: ". $pp->PPProduktpass_Liefertermin."/".$pp->PPProduktpass_LieferterminJahr ."  CRD:". $crd->format('W/y'));
        $termine = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_ManSoll','>', 0)->get();
        foreach($termine as $termin){
            $manSollDate = new DateTime();
            $manSollDate = clone $crd;
            $interval = 'P'.$termin->PPTermine_ManSoll.'W';
            $manSollDate = $manSollDate->sub(new DateInterval($interval));
            echo('  Man Soll: '.$termin->PPTermine_ManSoll."  ".$termin->PPTermine_ManSollDate." Interval:  $interval  ".$manSollDate->format('W/y'). " ".$manSollDate->format('Y-m-d')."<br>");
            $termin->PPTermine_ManSollDate = $terminLeer;
            if ($termin->PPTermine_ManSollDate == $terminLeer){ 
                $termin->PPTermine_ManSollDate = $manSollDate->format('Y-m-d');
            }
            $termin->save();
        }
    }
    public function getSchedule($searchparams, $board, $xRows = 100, $xPage = 1)
    {
        $lang = $this->getUserLanguage();
        $t = array();
        $internerStatusArray = array('FIX');
        $isMusterung = 'FIX';
        $isInquiry = 0;
        if ($board == 1001) {
            $isMusterung = 'PLAN';
            $isMusterung2 = 'MUSTERUNG';
            $isMusterung3 = '';
            $internerStatusArray = array('PLAN', 'MUSTERUNG');
        }
        if ($board == 2000) {
            $board = 1000;
            $isMusterung = 'GELIEFERT';
            $isMusterung2 = '';
            $isMusterung3 = '';
            $internerStatusArray = array('GELIEFERT');
        }
        if ($board == 2002) {
            $board = 1000;
            $isMusterung = 'ABSAGE';
            $isMusterung2 = '';
            $isMusterung3 = '';
            $internerStatusArray = array('ABSAGE');
        }      
        if ($board == 1010) {
            $isMusterung = 'ABSAGE';
            $isMusterung2 = '';
            $isMusterung3 = '';
            $internerStatusArray = array('ABSAGE');
        }
        $bss = PPBoardSpalte::where("PPBoardSpalte_PPBoard_Id", "=", $board)->orderBy('PPBoardSpalteX_Sort')->get();
        /* echo("<pre>");
        foreach($bss as $bs){
            echo($bs->PPBoardSpalteX_Sort."  ".$bs->PPBoardSpalte_Bezeichnung."  DF:".$bs->PPBoardSpalte_DFField."  Rot:".$bs->PPBoardSpalte_Rot."<br>");
        }
        exit; */
        if (!$bss){
            echo("Fehler bei der Auswahl! Dashboard: ".$board);
            exit;
        }
        $bspids = array();
        foreach ($bss as $bs) {
            $t["Header"][$bs->PPBoardSpalteX_Sort] = $bs;
            $t["Header2"][$bs->PPBoardSpalte_Id] = $bs;
            $bspids[] = $bs->PPBoardSpalte_Id;
        }
        $t['StatiAll'] = $this->getTerminStati(1);
        $s = array();
        $_table = 'v_PPProduktpass_PPTermineZ1';
        if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
            //$_table = 'v_PPProduktpass_PPTermineZ1';
        }
        $termines = DB::table($_table)
            ->whereIn('PPTermine_PPBoardSpalte_id', $bspids)
            ->where('PPBoardSpalte_PPBoard_Id', $board)
            ->where('PPProduktpass_IsInquiry', $isInquiry)
            ->whereIn('InternerStatus', $internerStatusArray);
        $s['PPProduktpass_IsInquiry'] = $isInquiry;
        $s['PPProduktpass_IsMusterung'] = $isMusterung;
        $s['PPBoardSpalte_PPBoard_Id'] = $board;
        $s['BSPID'] = $bspids;
        if (isset($searchparams) and count($searchparams) > 0) {
            $ml = array();
            if (isset($searchparams['PMler']) or isset($searchparams['TCler']) or isset($searchparams['PJMler'])) {
                $mitarbeiters = PPMitarbeiter::where('PPMitarbeiter_Id', '>', 0)->get();
                if ($mitarbeiters) {
                    foreach ($mitarbeiters as $mitarbeiter) {
                        $ml[$mitarbeiter->PPMitarbeiter_Kuerzel] = $mitarbeiter->PPMitarbeiter_Id;
                    }
                }
            }
            $action = Input::get('action');
            $onlyMy = false;
            if (strpos($action, '+') !== false) {
                $onlyMy = true;
            } 
            foreach ($searchparams as $att => $val) {
                $val = trim($val);
                if (strlen($val) > 0 and $val != "%") {
                    $regular = true;
                    if ($att == 'PMler') {
                        $regular = false;
                        $att = 'PPProduktpass_PMAdmin';
                        $val = $ml[$val];
                        if ($onlyMy) {
                            $termines = $termines->where('PPProduktpass_PMAdmin', '=', $val);
                        } else {
                            $termines = $termines->where(function ($query) use ($val) {
                                $query->where('PPProduktpass_PMAdmin', '=', $val)
                                      ->orWhere('PPProduktpass_PMAdminVTR', '=', $val);
                            });
                        }
                    }
                      if ($att == 'PJMler') {
                        $regular = false;
                        $att = 'PPProduktpass_PJMAdmin';
                        $val = $ml[$val];
                        if ($onlyMy) {
                            $termines = $termines->where('PPProduktpass_PJMAdmin', '=', $val);
                        } else {
                            $termines = $termines->where(function ($query) use ($val) {
                                $query->where('PPProduktpass_PJMAdmin', '=', $val)
                                      ->orWhere('PPProduktpass_PJMAdminVTR', '=', $val);
                            });
                        }
                    }
                    if ($att == 'TCler') {
                        $regular = false;
                        $att = 'PPProduktpass_TCAdmin';
                        $val = $ml[$val];
                        if ($onlyMy) {
                            $termines = $termines->where('PPProduktpass_TCAdmin', '=', $val);
                        } else {
                            $termines = $termines->where(function ($query) use ($val) {
                                $query->where('PPProduktpass_TCAdmin', '=', $val)
                                      ->orWhere('PPProduktpass_TCAdminVTR', '=', $val);
                            });
                        }
                    }
                    if ($att == 'PPProduktpass_IAN') {
                        $regular = false;
                        $projekte = DB::table('v_ProjekteIan')->where('PPProduktpass_IAN', 'like', "%$val%")->where('PPProduktpass_IAN', 'not like', "%rev%")->get();
                        $pa = array();
                        foreach ($projekte as $projekt) {
                            $pa[] = $projekt->PPProduktpass_PPProjekte_Projekt;
                        }
                        $termines = $termines->whereIn('PPProduktpass_PPProjekte_Projekt', $pa);
                    }
                    if ($att == 'PPProduktpass_Artikelbezeichnung') {
                        $regular = false;
                        $termines = $termines->where(function ($query) use ($val) {
                            $query->where('PPProduktpass_Artikelbezeichnung', 'like', $val.'%')
                                  ->orWhere('PPProduktpass_ArtikelTarga', 'like', $val.'%');
                        });
                    } 
                    if ($att == 'PPProduktpass_Ausmusterungnummer') {
                        if (strlen(trim($val)) >= 2){
                            $regular = false;
                            $qrySet = false;
                            if (substr($val,0,1) == '>'){
                                $ausm = trim(substr($val,1,5));
                                $termines = $termines->where('PPProduktpass_Ausmusterungnummer', '>=', "$ausm");
                                $qrySet = true; 
                            } 
                            if (substr($val,0,1) == '<'){
                                $ausm = trim(substr($val,1,5));
                                $termines = $termines->where('PPProduktpass_Ausmusterungnummer', '<=', "$ausm");
                                $qrySet = true;
                            }
                            if(!$qrySet){
                                $termines = $termines->where('PPProduktpass_Ausmusterungnummer', 'like', $val.'%');
                            }
                        } 
                    } 
                    if ($att == 'PPProduktpass_IsCriticalProject') {
                        $regular = false;
                        if ($val == 1){
                            $termines = $termines->where('PPProduktpass_IsCriticalProject', '=', $val);
                        } 
                    } 
                    if($regular) {
                        //cpcDebug::pe($att);
                        $termines = $termines->where($att, 'like', "$val%");
                    }
                    $s[$att] = $val;
                    $t['sp'][$att] = $val;
                }
            }
        }
        $t['Board'] = $board;
        try{
            $termines = $termines->orderBy('PPProduktpass_isCriticalProject','desc')->orderBy('PPProduktpass_PPProjekte_Projekt')->orderBy('PPProduktpass_IsUSA')->orderBy('PPProduktpass_IsParent', 'desc')->orderBy('PPProduktpass_IsKaufland')->orderBy('PPProduktpass_IAN')->orderBy('PPProduktpass_Ausmusterungnummer')->get();
        }
        catch(Exception $ex){
            //cpcDebug::pe($ex->getMessage());
        }
        $hasData = 0;
        $start = microtime(true);
        $countRows = $xRows;
        $countPages = $xPage;
        $countElems = count($bspids);
        $pStart = ($countPages -1) * $countRows * $countElems +1;
        $pEnde = $countPages * $countRows * $countElems;
        $count =0;
        $t['totalRows'] = count($termines) / $countElems;
        foreach ($termines as $termin) {
            $count++;
            if ($count < $pStart ){
                continue;
            } else {
                if ($count > $pEnde ){
                    break;
                }
            }
            $hasData = 1;
            if (!isset($t["Values"][$termin->PPTermine_PPProduktpass_Id]['Init'])) {
                $LTorCRDWoche = $termin->PPProduktpass_Liefertermin;
                $LTorCRDJahr = $termin->PPProduktpass_LieferterminJahr;
                if ($termin->PPProduktpass_CRDJahr != 0) {
                    $LTorCRDJahr =  $termin->PPProduktpass_CRDJahr;
                    $LTorCRDWoche = $termin->PPProduktpass_CRDWoche;
                }
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['CRDChanged'] = $this->getCRDChanged($termin->PPTermine_PPProduktpass_Id);
                $diff = microtime(true) - $start;
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['AB'] = null;
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['IsValid_OldIAN'] = $this->IsValid_OldIAN($termin->PPProduktpass_AltIAN, $termin->PPProduktpass_AltCharge);
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['MengenSplit'] = "-/-";
                $polief = $this->getPO($termin->PPTermine_PPProduktpass_Id);
                $po = $polief['PO'];
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['PO'] = $polief['PO'];
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Lief'] = $polief['Lief'];
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['W2FOBPO'] = $this->getW2FOB($po->PPPurchase_FOBWeek, $po->PPPurchase_FOBYear);
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['W2FOB'] = $this->getW2FOB($LTorCRDWoche, $LTorCRDJahr);
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['POStatus'] = ""; 
                if ($board == 6) {
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['AB'] = $this->getAB($termin->PPTermine_PPProduktpass_Id);
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['MengenSplit'] = $this->getMengenSplit($termin->PPTermine_PPProduktpass_Id);
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['LC'] = $this->getLC($termin->PPTermine_PPProduktpass_Id);
                }
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['PP'] = $termin;
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['8WMuster'] = null; 
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Mitarbeiter'] = null; 
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Init'] = 1;
            }
            $diff = microtime(true) - $start;
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Termin'][$termin->PPTermine_PPBoardSpalte_id] = $termin;
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Log'][$termin->PPTermine_PPBoardSpalte_id] = null; 
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['BG'][$termin->PPTermine_PPBoardSpalte_id] = STATUS_UNDEF;
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['WERLSET'][$termin->PPTermine_PPBoardSpalte_id] = "NO";
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['OKSTATUS'][$termin->PPTermine_PPBoardSpalte_id] = "NO";
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['WERLY'][$termin->PPTermine_PPBoardSpalte_id] = '';
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['WERLW'][$termin->PPTermine_PPBoardSpalte_id] = '';
            if ($termin->PPStati_OKStatus) {
                $erlDate = $termin->PPTermine_DatumEnde;
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['OKSTATUS'][$termin->PPTermine_PPBoardSpalte_id] = "YES";
                if (strpos($erlDate, '0000') === false) {
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['WERLSET'][$termin->PPTermine_PPBoardSpalte_id] = "YES";
                    $erl = new Datetime($erlDate);
                    $erlw = $erl->format('W');
                    $erly = $erl->format('Y');
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['WERLY'][$termin->PPTermine_PPBoardSpalte_id] = $erly;
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['WERLW'][$termin->PPTermine_PPBoardSpalte_id] = $erlw;
                }
            }
            if (isset($t["Header2"][$termin->PPTermine_PPBoardSpalte_id]->PPBoardSpalte_Rot)) {
                $rot = $t["Header2"][$termin->PPTermine_PPBoardSpalte_id]->PPBoardSpalte_Rot;
                if ($termin->PPTermine_ManSoll != 0) {
                    $rot = -1 * $termin->PPTermine_ManSoll - 10; 
                } 
                $tempCol = $this->getBGStatusColorDashboard($LTorCRDWoche, $LTorCRDJahr, $termin->PPTermine_Status, $rot, $rot - 2);
                $tempCol = substr($tempCol, 1);
                $t["Values"][$termin->PPTermine_PPProduktpass_Id]['BG'][$termin->PPTermine_PPBoardSpalte_id] = $tempCol;
            }
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Datafield'][$termin->PPTermine_PPBoardSpalte_id] = "";
            if (isset($t["Header2"][$termin->PPTermine_PPBoardSpalte_id]->PPBoardSpalte_DFField) and !is_null($t["Header2"][$termin->PPTermine_PPBoardSpalte_id]->PPBoardSpalte_DFField)) {
                $att = $t["Header2"][$termin->PPTermine_PPBoardSpalte_id]->PPBoardSpalte_DFField;
                $val = $termin->$att;
                if (strlen($termin->$att) > 0) {
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Datafield'][$termin->PPTermine_PPBoardSpalte_id] = "(" . $termin->$att . ")";
                } else {
                    $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Datafield'][$termin->PPTermine_PPBoardSpalte_id] = "(N.N.)";
                }
            }
            $t["Values"][$termin->PPTermine_PPProduktpass_Id]['Dashboard'][$termin->PPTermine_PPBoardSpalte_id] = $this->getDashboardValue($termin);
            $diff = microtime(true) - $start;
        }
        $diff = microtime(true) - $start;
        $t['DelMa'] = $this->getMitarbeiterListe('', 'DEL');
        if ($hasData) {
            return $t;
        } else {
            return false;
        }
    }
    public function getSchedulePopUp($board, $ppid, $tid)
    {
        //echo('Schedule');exit;
        //$board       = 10;
        $isMusterung = 0;
        $isInquiry = 0;
        if ($board == 1001) {
            $isMusterung = 1;
        }
        if ($board == 2002) {
            $board = 1000;
        }
        //echo ($board);exit;
        $bss = PPBoardSpalte::where("PPBoardSpalte_PPBoard_Id", "=", $board)->orderBy('PPBoardSpalteX_Sort')->get();
        $t = array();
        $bspids = array();
        //$bspids = array(65, 66, 67, 68, 69, 70);
        foreach ($bss as $bs) {
            //echo("BS:" . $bs->PPBoardSpalte_Id . "<br>");
            // if (in_array($bs->PPBoardSpalte_Id, $bspids)) {
            $t["Header"][$bs->PPBoardSpalteX_Sort] = $bs;
            $t["Header2"][$bs->PPBoardSpalte_Id] = $bs;
            //}
            $bspids[] = $bs->PPBoardSpalte_Id;
        }
        //dd($t["Header2"]);
        $value['StatiAll'] = $this->getTerminStati(1);
        $s = array();
        $s['PPProduktpass_IsInquiry'] = $isInquiry;
        $s['PPProduktpass_IsMusterung'] = $isMusterung;
        $s['PPBoardSpalte_PPBoard_Id'] = $board;
        $s['BSPID'] = $bspids;
        $termin = DB::table('v_PPProduktpass_PPTermine')->where('PPTermine_Id', "=", $tid)->first();
        if (!$termin) {
            $termin = DB::table('v_PPProduktpass_PPTermine')->where('PPBoardSpalte_PPBoard_Id', "=", $board)->where('PPTermine_PPProduktpass_Id', "=", $ppid)->first();
            if (!$termin){
                echo('NOK : PPId: '. $ppid.'  Board: '.$board );
            }
        }
        $value['Board'] = $board;
        $value['AB'] = null;
        $value['MengenSplit'] = "-/-";
        $polief = $this->getPO($termin->PPTermine_PPProduktpass_Id);
        $po = $polief['PO'];
        $value['PO'] = $polief['PO'];
        $value['Lief'] = $polief['Lief'];
        $value['W2FOB'] = $this->getW2FOB($po->PPPurchase_FOBWeek, $po->PPPurchase_FOBYear);
        $value['POStatus'] = $this->getPOStatus($value['PO']->PPPurchase_Status);
        if ($board == 6) {
            $value['AB'] = $this->getAB($termin->PPTermine_PPProduktpass_Id);
            $value['MengenSplit'] = $this->getMengenSplit($termin->PPTermine_PPProduktpass_Id);
            $value['LC'] = $this->getLC($termin->PPTermine_PPProduktpass_Id);
        }
        $value['PP'] = $termin;
        //   if ($termin->PPTermine_PPBoardSpalte_id == 31) {
        $value['8WMuster'] = $this->get8WMuster($termin->PPTermine_PPProduktpass_Id);
        //   }
        $value['Init'] = 1;
        $value['Termin'] = $termin;
        $value['Log'] = $this->getTermineLog($termin->PPTermine_Id);
        //cpcDebug::cpc_debug($value['Log'][$termin->PPTermine_PPBoardSpalte_id] ,"XXNEU");
        $value['BG'] = STATUS_UNDEF;
        $LTorCRDWoche = $termin->PPProduktpass_Liefertermin - 10;
        $LTorCRDJahr = $termin->PPProduktpass_LieferterminJahr;
        if ($LTorCRDWoche <= 0) {
            $LTorCRDWoche += 52;
            $LTorCRDJahr--;
        }
        if ($termin->PPProduktpass_CRDJahr > 0) {
            $LTorCRDWoche = $termin->PPProduktpass_CRDWoche;
            $LTorCRDJahr = $termin->PPProduktpass_CRDJahr;
        }
        $pbsh = (object) $t["Header2"];
        if (isset($pbsh->PPBoardSpalte_Rot)) {
            $rot = $pbsh->PPBoardSpalte_Rot;
            if ($termin->PPTermine_ManSoll != 0) {
                $rot = -1 * $termin->PPTermine_ManSoll;
            }
            $tempCol = $this->getBGStatusColorDashboard($LTorCRDWoche, $LTorCRDJahr, $termin->PPTermine_Status, $rot, $rot - 2);
            $tempCol = substr($tempCol, 1);
            $value['BG'] = $tempCol;
        }
        $value['Datafield'] = "";
        if (isset($pbsh->PPBoardSpalte_DFField) and !is_null($pbsh->PPBoardSpalte_DFField)) {
            $att = $pbsh->PPBoardSpalte_DFField;
            $val = $termin->$att;
            if (strlen($termin->$att) > 0) {
                $value['Datafield'] = "(" . $termin->$att . ")";
            } else {
                $value['Datafield'] = "(N.N.)";
            }
        }
        $po = array();
        $first = false;
        $po['ltw'] = '';
        $po['ltj'] = '';
        $po['supplier'] = '';
        $po['ek'] = 0;
        $po['status'] = 'N.N.';
        $po['w2fob'] = "";
        $po['bsci'] = "";
        $lccol = "";
        $lcdate = "";
        if (!is_null($value['PO'])) {
            $po['ltw'] = $value['PO']->PPPurchase_FOBWeek;
            $po['ltj'] = $value['PO']->PPPurchase_FOBYear;
            if ($value['PO']->PPPurchase_FOBYear > 2000) {
                $po['ltj'] = $value['PO']->PPPurchase_FOBYear - 2000;
            }
            $po['supplier'] = $value['PO']->PPPurchase_Supplier;
            if ($value['Lief']) {
                $po['supplierid'] = $value['Lief']->Id;
                if (strlen($value['Lief']->PPAdressen_ZertBSCIValid) >= 10) {
                    $po['bsci'] = date('d.m.Y', strtotime($value['Lief']->PPAdressen_ZertBSCIValid));
                }
            }
            $po['ek'] = $value['PO']->PPPurchase_EK != 0 ? $value['PO']->PPPurchase_EK
                : $value['PO']->PPPurchase_FOBQm;
            $po['ekwsym'] = $value['PO']->PPPurchase_Currency;
            $po['status'] = $value['POStatus'];
            $po['w2fob'] = $value['W2FOB'];
            try {
                $lccol = " background-color:rgb(255,255,255); ";
                if (isset($value['LC']) and !is_null($value['LC'])) {
                    if (strlen($value['LC']->PPLC_FinalDate) >= 10) {
                        $lcdate = date('d.m.Y', strtotime($value['LC']->PPLC_FinalDate));
                        $lcdt = new DateTime($value['LC']->PPLC_FinalDate);
                        if (strlen($value['PO']->PPPurchase_OrderDate) >= 10) {
                            $od = new DateTime($value['PO']->PPPurchase_OrderDate);
                            $diff = date_diff($od, $lcdt);
                            $x = intval($diff->format('%r%a'));
                            if ($x >= 0) {
                                $lccol = " background-color:rgb(0,255,0); ";
                            } else {
                                $lccol = " background-color:rgb(255,0,0); ";
                            }
                        }
                    }
                }
            } catch (Exception $ex) {
                $lcdate = "Error";
            }
            try {
                $orderdate = "";
                $od = new DateTime($value['PO']->PPPurchase_OrderDate);
                if (strlen($value['PO']->PPPurchase_OrderDate) >= 10) {
                    $od = new DateTime($value['PO']->PPPurchase_OrderDate);
                    $orderdate = date_format($od, "d.m.y");
                }
                $di = new DateTime($value['PP']->PPProduktpass_RevisionDatum);
                $diff = date_diff($od, $di);
                $x = intval($diff->format('%r%a'));
                if ($x <= 0) {
                    $orderFormatColor = "color:green;";
                } else {
                    $orderFormatColor = "color:red;";
                }
            } catch (Exception $ex) {
                $orderFormatColor = "color:pink;";
                $orderdate = 'N.N.';
            }
            $po['date'] = $orderdate;
        }
        $ab = array();
        $ab['vk'] = 0;
        $ab['chq'] = 0;
        $ab['c40'] = 0;
        $ab['c20'] = 0;
        $ab['mengensplit'] = '-/-';
        if (!is_null($value['AB'])) {
            $ab['vk'] = $value['AB']->PPAB_VKEUR > 0 ? $value['AB']->PPAB_VKEUR
                : $value['AB']->PPAB_VKQMEUR;
            /*  $ab['chq'] = $value['AB']->PPAB_CD11 + $value['AB']->PPAB_CD12 + $value['AB']->PPAB_CD13;
            $ab['c40'] = $value['AB']->PPAB_CD21 + $value['AB']->PPAB_CD22 + $value['AB']->PPAB_CD23;
            $ab['c20'] = $value['AB']->PPAB_CD31 + $value['AB']->PPAB_CD32 + $value['AB']->PPAB_CD33; */
            $ab['chq'] = $value['AB']->PPAB_CD11 + $value['AB']->PPAB_CD21 + $value['AB']->PPAB_CD31 + $value['AB']->PPAB_CD41;
            $ab['c40'] = $value['AB']->PPAB_CD12 + $value['AB']->PPAB_CD22 + $value['AB']->PPAB_CD32 + $value['AB']->PPAB_CD42;
            $ab['c20'] = $value['AB']->PPAB_CD13 + $value['AB']->PPAB_CD23 + $value['AB']->PPAB_CD33 + $value['AB']->PPAB_CD43;
            $ab['mengensplit'] = $value['MengenSplit'];
        }
        $pp = array();
        $pp['id'] = $value['PP']->PPProduktpass_Id;
        $pp['PM'] = $value['PP']->PPProduktpass_PMAdmin;
        $pp['PJM'] = $value['PP']->PPProduktpass_PJMAdmin;
        $pp['TC'] = $value['PP']->PPProduktpass_TCAdmin;
        $pp['InternerStatus'] = $value['PP']->InternerStatus;
        $pp['ian'] = $value['PP']->PPProduktpass_IAN;
        $pp['projekt'] = $value['PP']->PPProduktpass_PPProjekte_Projekt;
        $pp['artikel'] = $value['PP']->PPProduktpass_Artikelbezeichnung;
        $pp['ltw'] = $LTorCRDWoche;
        $pp['lty'] = $LTorCRDJahr - 2000;
        $pp['crdltw'] = $LTorCRDWoche;
        $pp['crdlty'] = $LTorCRDJahr - 2000;
        $pp['ddpltw'] = $value['PP']->PPProduktpass_Liefertermin;
        $pp['ddplty'] = $value['PP']->PPProduktpass_LieferterminJahr - 2000;
        $pp['PPstatus'] = $value['PP']->PPProduktpass_Status;
        $pp['Gesamtmenge'] = $value['PP']->PPProduktpass_Gesamtmenge;
        $pp['ZertStep'] = 'Nein';
        if ($value['PP']->PPProduktpass_StepNeeded) {
            $pp['ZertStep'] = 'Ja';
        }
        $pp['ZertBSCI'] = 'Nein';
        if ($value['PP']->PPProduktpass_BSCINeeded) {
            $pp['ZertBSCI'] = 'Ja';
        }
        $pp['DatumImport'] = "Error";
        if (strlen($value['PP']->PPProduktpass_RevisionDatum) >= 10) {
            $pp['DatumImport'] = date_format(date_create($value['PP']->PPProduktpass_RevisionDatum), "d.m.y");
        }
        $pp['artikel'] = substr($value['PP']->PPProduktpass_Artikelbezeichnung, 0, 80);
        if (strlen($value['PP']->PPProduktpass_Artikelbezeichnung) > 80) {
            $pp['artikel'] .= "+";
        }
        $pp['artikelVoll'] = $value['PP']->PPProduktpass_Artikelbezeichnung;
        $pp['8WMuster'] = "";
        if (isset($value['8WMuster'])) {
            $pp['8WMuster'] = $value['8WMuster'];
        }
        $pp['Musterung'] = substr($value['PP']->PPProduktpass_Ausmusterungnummer, 0, 4);
        $pp['AltIAN'] = $value['PP']->PPProduktpass_AltIAN;
        $pp['AltCharge'] = $value['PP']->PPProduktpass_AltCharge;
        $pp['ThemaLang'] = $value['PP']->PPProduktpass_Thema;
        $pp['Thema'] = substr($value['PP']->PPProduktpass_Thema, 0, 80);
        if (strlen($value['PP']->PPProduktpass_Thema) > 80) {
            $pp['Thema'] .= "+";
        }
        $pp['WGRP'] = $value['PP']->PPProduktpass_Warengruppe;
        $pp['W2FOB'] = $this->getW2FOB($pp['ltw'], $pp['lty']);
        //echo($pp['W2FOB']);
        $dto = new DateTime();
        $pp['lt'] = $dto->setISODate($pp['lty'], $pp['ltw'])->format("d.m.Y");
        $pbgcolor[0] = "#FFFF00";
        $pbgcolor[1] = "#FFBF00";
        $lproject = $value['PP']->PPProduktpass_PPProjekte_Projekt;
        $bgProject = $pbgcolor[1];
        $t['id'] = $value['Termin']->PPTermine_Id;
        $t['bgcolor'] = $value['Termin']->PPStati_Background;
        $t['ManSoll'] = $value['Termin']->PPTermine_ManSoll;
        $t['ManSollDate'] = $value['Termin']->PPTermine_ManSollDate;
        $t['spalteId']  = $value['Termin']->PPBoardSpalte_Id;
        $t['terminart'] = $value['Termin']->PPBoardSpalte_Bezeichnung;  
        $t['PMPJMTC'] = $value['Termin']->PPBoardspalteData_Kind;
        $t['status'] = $value['Termin']->PPTermine_Status;
        $t['ma'] = $value['Termin']->PPTermine_MAZustaendigkeit;
        $t['history'] = $value['Termin']->PPTermine_History;
        if ($this->getUserLanguage() == "EN") {
            $t['history'] = $value['Termin']->PPTermine_HistoryEN;
        }
        $t['log'] = $value['Log'];
        $t['rot'] = $value['Termin']->PPBoardSpalte_Rot;
        $t['orange'] = $value['Termin']->PPBoardSpalte_Orange;
        $t['start'] = '0000-00-00';
        $t['ende'] = '0000-00-00';
        try {
            if (substr($value['Termin']->PPTermine_DatumStart, 0, 10) != "0000-00-00") {
                $ds = new DateTime($value['Termin']->PPTermine_DatumStart);
                $t['start'] = $ds->format("d.m.Y");
            }
        } catch (Exception $ex) {
        }
        try {
            if (substr($value['Termin']->PPTermine_DatumEnde, 0, 10) != "0000-00-00") {
                $de = new DateTime($value['Termin']->PPTermine_DatumEnde);
                $t['ende'] = $de->format("d.m.Y");
            }
        } catch (Exception $ex) {
        }
        $t['label'] = $value['Termin']->PPTermine_Label;
        $t['bemerkung'] = $value['Termin']->PPTermine_Bemerkungen;
        $t['labelEN'] = $value['Termin']->PPTermine_LabelEN;
        $t['bemerkungEN'] = $value['Termin']->PPTermine_BemerkungenEN;
        $t['datafield'] = $value['Datafield'];
        $t['bg'] = $value['BG'];
        $t['PPTermine_IsMPlan'] = $value['Termin']->PPTermine_IsMPlan;
        //print_r($value['Termin']->PPTermine_PPBoardSpalte_id);exit;
        if (isset($t['Header2'][$value['Termin']->PPTermine_PPBoardSpalte_id])){
            $as = explode("x", $t['Header2'][$value['Termin']->PPTermine_PPBoardSpalte_id]->PPBoardSpalte_Stati);
        } else {
           echo($value['Termin']->PPTermine_PPBoardSpalte_id);
           exit;
        }
        $xs = array();
        $xs["Neu"] = "Neu";
        foreach ($as as $s) {
            //echo($s);
            if (isset($value['StatiAll'][$s])) {
                $xs[$value['StatiAll'][$s]] = $value['StatiAll'][$s];
            }
        }
        $t['stati'] = $xs;
        $allData = array();
        $allData['value'] = $value;
        $allData['board'] = $board;
        $allData['t'] = $t;
        $allData['pp'] = $pp;
        $allData['ab'] = $ab;
        $allData['po'] = $po;
        $allData['pbgcolor'] = $pbgcolor;
        $allData['bgProject'] = $bgProject;
        $allData['TerminGruende'] = $this->getTerminGruende();
        $allData['mitarbeiterNamen'] = $this->getMitarbeiterListe('', '', true);
        $allData['mitarbeiterliste'] = $this->getMitarbeiterListe();
        $allData['DelMa'] = $this->getMitarbeiterListe('', 'DEL');
        //print_r($allData['mitarbeiterliste']);exit;
        $allData['termineMusterung'] = $this->getTermineMusterung($board);
        $allData['termineLinks'] = $this->getTerminePopUp($ppid, $board);
        //dd($allData['DelMa']);exit;
        return $allData;
    }
    private function getTerminGruende()
    {
        $stati = PPStatiX::where('PPStati_Art', "=", "TerminGruende")->get();
        if ($stati) {
            return $stati;
        }
        return null;
    }
    private function getW2FOB($ltw, $lty)
    {
        //echo($lty . "/" . $ltw . " => ");
        $ret = 0;
        try {
            if (is_null($ltw) or trim($ltw) == "") {
                return 0;
            }
            $aktkw = date('W');
            $aktjahr = date('Y');
            //echo ($aktjahr." / ". $aktkw."  ---> ");
            if (!is_numeric($lty)){
                return 0;
            }
            if (!is_numeric($ltw)){
              return 0;
            }
            if ($lty == $aktjahr) {
                return $ltw - $aktkw;
            }
            if ($lty < $aktjahr) {
                $ret = (-1) * (52 - $ltw + $aktkw + (($aktjahr - $lty) - 1) * 52);
            }
            if ($lty > $aktjahr) {
                $ret = $ltw + 52 * ($lty - $aktjahr) - $aktkw;
            }
            return $ret;
        } catch (Exception $e) {
            //echo("EXCEPTION  $ltw $lty <br>");
            return 0;
        }
    }
    public function loescheDoppelteTermineAusDatenbankAdminfuerId($id)
    {
        $termine = PPTermine::where("PPTermine_PPProduktpass_id", "=", $id)->orderBy("PPTermine_PPBoardSpalte_id")->orderBy("PPTermine_id", "desc")->get();
        //var_dump($termine);
        echo ("<br>    Termine<br>");
        $tid = array();
        $j = 0;
        foreach ($termine as $t) {
            $j++;
            //echo("    Spalte: " . $t->PPTermine_PPBoardSpalte_id . "    Termin:" . $t->PPTermine_Id . "    Status:" . $t->PPTermine_Status . "<br>");
            //echo("$j => ");
            if ($j <= 1) {
                $tid[$j] = array(
                    "delete"   => 0, "spalteid" => $t->PPTermine_PPBoardSpalte_id,
                    "id"       => $t->PPTermine_Id, "status"   => $t->PPTermine_Status
                );
                echo ("Erster Datensatz:  " . $t->PPTermine_PPBoardSpalte_id . "   Id: " . $t->PPTermine_Id . " <br>");
            } else {
                if ($tid[$j - 1]['spalteid'] == $t->PPTermine_PPBoardSpalte_id) {
                    echo ("  --Datensatz markieren:  " . $t->PPTermine_PPBoardSpalte_id . "  Id: " . $t->PPTermine_Id . " <br>");
                    $tid[$j] = array(
                        "delete"   => 1, "spalteid" => $t->PPTermine_PPBoardSpalte_id,
                        "id"       => $t->PPTermine_Id, "status"   => $t->PPTermine_Status
                    );
                } else {
                    if ($j > 2) {
                        $this->deleteTermine($tid);
                    }
                    $j = 1;
                    $tid = array();
                    $tid[$j] = array(
                        "delete"   => 0, "spalteid" => $t->PPTermine_PPBoardSpalte_id,
                        "id"       => $t->PPTermine_Id, "status"   => $t->PPTermine_Status
                    );
                    echo ("Erster DatensatzN:  " . $t->PPTermine_PPBoardSpalte_id . "   Id: " . $t->PPTermine_Id . " <br>");
                }
            }
        }
    }
    public function loescheDoppelteTermineAusDatenbankAdmin()
    {
        $ppids = DB::table('PPTermine')
            ->select(DB::raw('count(*) as anz,  PPTermine_PPProduktpass_Id '))->having("anz", ">", "38")->groupBy('PPTermine_PPProduktpass_Id')->get();
        //var_dump($ppids); exit;
        foreach ($ppids as $id) {
            echo ("Neu Id: " . $id->PPTermine_PPProduktpass_Id . "  Anzahl: " . $id->anz . " <br>");
            $this->loescheDoppelteTermineAusDatenbankAdminfuerId($id->PPTermine_PPProduktpass_Id);
        }
        exit;
    }
    public function setDefaultMA_Termine()
    {
        $termine = PPTermine::all();
        foreach ($termine as $termin) {
            $t = PPTermine::find($termin->PPTermine_Id);
            if ($t->PPTermine_MAZustaendigkeit == 0) {
                $b = PPBoardSpalte::find($t->PPTermine_PPBoardSpalte_id);
                $t->PPTermine_MAZustaendigkeit = $b->PPBoardSpalte_DefaultMA;
                $t->save();
            }
        }
        //echo('<pre>');var_dump($ret);echo('</pre><br>');
    }
    private function getStatiColors()
    {
        $stati = PPStati::all();
        $ret = array();
        foreach ($stati as $status) {
            $ret[$status->PPStati_Status]['bg'] = $status->PPStati_Background;
            $ret[$status->PPStati_Status]['color'] = $status->PPStati_Color;
            $ret[$status->PPStati_Status]['isOKStatus'] = $status->PPStati_OKStatus;
        }
        //echo('<pre>');var_dump($ret);echo('</pre><br>');
        return $ret;
    }
    /**
     * Display the specified resource.
     * GET /projects/{id}
     *
     * @param  int  $id
     * @return Response
     */
    private function getStatusBG($status)
    {
        if (PPStati::where('PPStati_Status', '=', $status)->count() <= 0) {
            return array('OKStatus' => 0, 'bg' => STATUS_UNDEF);
        }
        $s = PPStati::where('PPStati_Status', '=', $status)->first();
        //echo($s->PPStatus_OKStatus $s->PPStatus_KStatus);
        if ($s->PPStati_OKStatus != 1) {
            return array('OKStatus' => 0, 'bg' => STATUS_LIGHTGRAY); //$s->PPStati_Background);
        }
        return array('OKStatus' => 1, 'bg' => STATUS_GREEN);
    }
    private function getBGStatusColor($kw, $jahr, $status, $rot, $orange)
    {
        $statusbg = $this->getStatusBG($status);
        if ($statusbg['OKStatus'] == 1) {
            return STATUS_GREEN;
        }
        if (is_null($rot) or is_null($orange) or strlen($rot) <= 0 or strlen($orange) <= 0) {
            return STATUS_UNDEF;
        }
        $aktkw = date('W');
        $aktjahr = date('Y');
        $w2lt = $this->getW2FOB($kw, $jahr);
        if ($rot <= 0) {
            $W2Rot = (($rot + $w2lt));
        } else {
            $W2Rot = (($w2lt + $rot));
        }
        if ($orange <= 0) {
            $W2Orange = (($orange + $w2lt));
        } else {
            $W2Orange = (($w2lt + $orange));
        }
        if ($W2Rot < 0) {
            return STATUS_RED;
        }
        if ($W2Orange < 0) {
            return STATUS_ORANGE;
        }
        return $statusbg['bg'];
    }
    public function getLaenderLT($id)
    {
        $pp = PPProduktpass::find($id);
        $mengen = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $pp->PPProduktpass_Id)->get();
        $aLT = array();
        //cpcDebug::dd($mengen, False);
        foreach ($mengen as $menge) {
            if ($menge->PPProduktpass_Menge_DeliveryWeek != null) {
                if (isset($aLT[$menge->PPProduktpass_Menge_DeliveryWeek])) {
                    if (strpos($aLT[$menge->PPProduktpass_Menge_DeliveryWeek], $menge->PPProduktpass_Menge_Country) === false) {
                        $aLT[$menge->PPProduktpass_Menge_DeliveryWeek] = $aLT[$menge->PPProduktpass_Menge_DeliveryWeek] . " " . $menge->PPProduktpass_Menge_Country;
                    }
                } else {
                    $aLT[$menge->PPProduktpass_Menge_DeliveryWeek] = $menge->PPProduktpass_Menge_Country;
                }
            }
            if ($menge->PPProduktpass_Menge_LT1 != null) {
                if (isset($aLT[$menge->PPProduktpass_Menge_LT1]) and $menge->PPProduktpass_Menge_LT1 != null) {
                    if (strpos($aLT[$menge->PPProduktpass_Menge_LT1], $menge->PPProduktpass_Menge_Country) === false) {
                        $aLT[$menge->PPProduktpass_Menge_LT1] = $aLT[$menge->PPProduktpass_Menge_LT1] . " " . $menge->PPProduktpass_Menge_Country;
                    }
                } else {
                    $aLT[$menge->PPProduktpass_Menge_LT1] = $menge->PPProduktpass_Menge_Country;
                }
            }
            if ($menge->PPProduktpass_Menge_LT2 != null) {
                if (isset($aLT[$menge->PPProduktpass_Menge_LT2])) {
                    if (strpos($aLT[$menge->PPProduktpass_Menge_LT2], $menge->PPProduktpass_Menge_Country) === false) {
                        $aLT[$menge->PPProduktpass_Menge_LT2] = $aLT[$menge->PPProduktpass_Menge_LT2] . " " . $menge->PPProduktpass_Menge_Country;
                    }
                } else {
                    $aLT[$menge->PPProduktpass_Menge_LT2] = $menge->PPProduktpass_Menge_Country;
                }
            }
            if ($menge->PPProduktpass_Menge_LT3 != null) {
                if (isset($aLT[$menge->PPProduktpass_Menge_LT3])) {
                    if (strpos($aLT[$menge->PPProduktpass_Menge_LT3], $menge->PPProduktpass_Menge_Country) === false) {
                        $aLT[$menge->PPProduktpass_Menge_LT3] = $aLT[$menge->PPProduktpass_Menge_LT3] . " " . $menge->PPProduktpass_Menge_Country;
                    }
                } else {
                    $aLT[$menge->PPProduktpass_Menge_LT3] = $menge->PPProduktpass_Menge_Country;
                }
            }
        }
        asort($aLT);
        return $aLT;
        //cpcDebug::dd($aLT, False);
    }
    private function getBoard_del($id, $sort, $sortart, $wheres = false)
    {
        $all = $this->getBoardArray($id, $sort, $sortart, $wheres);
        /*  echo("<pre>");
        foreach ($all as $key => $value) {
        //print_r($value);
        //exit;
        echo("</pre>$key => " . $value['PP']->PPProduktpass_IAN . " <br>");
        foreach ($value['Termine'] as $tid => $termin) {
        echo($tid);
        echo(" -- ");
        echo($termin['Termin']->PPTermine_Id);
        echo(" -- ");
        echo($termin['Termin']->PPTermine_Status);
        }
        echo("<br>");
        }
        exit; */
        //cpcDebug::cpc_debug("getBoard: $id Start", "PERF2");
        //echo("<pre>");var_dump($all);exit;
        $bs = PPBoardSpalte::where("PPBoardSpalte_PPBoard_Id", "=", $id)->get();
        $ids = array();
        foreach ($bs as $col) {
            $prevobez = $col->PPBoardSpalte_Oberbez;
            break;
        }
        $kw = date('W');
        $jahr = date('Y');
        $colspan = 0;
        $j = 0;
        $row = array();
        $aBs = array();
        foreach ($bs as $col) {
            //$aBs[$col->PPBoardSpalte_Id] = $col;
            if ($prevobez == $col->PPBoardSpalte_Oberbez) {
                $colspan++;
            } else {
                $colspan = 1;
                $prevobez = $col->PPBoardSpalte_Oberbez;
            }
            $id = $col->PPBoardSpalte_Id;
            $ids[$id] = array(
                'bez'     => $col->PPBoardSpalte_Bezeichnung, 'obez'    => $col->PPBoardSpalte_Oberbez,
                'id' => $id, 'colspan' => $colspan, 'rot' => $col->PPBoardSpalte_Rot,
                'orange'  => $col->PPBoardSpalte_Orange, 'stati'   => $col->PPBoardSpalte_Stati
            );
        }
        //echo("<pre>");var_dump($aBs);exit;
        //foreach ($bs as $col) {
        //cpcDebug::cpc_debug("PERF OUTER Start ", "PERF2");
        $i = 0;
        foreach ($all as $produktpass) {
            $i++;
            $termine = $produktpass['Termine'];
            //cpcDebug::cpc_debug("PERF Inner1 Start ", "PERF2");
            //echo("<pre>");var_dump($produktpass['Termine']);exit;
            //$pp = $produktpass['PP'];
            //$termineAnzeigen = $produktpass['TermineAnzeigen'];
            //$termine = PPTermine::where("PPTermine_PPBoardSpalte_Id","=",$col->PPBoardSpalte_Id)->get();
            $j = 0;
            //cpcDebug::cpc_debug("     PERF OUTER $i ","PERF");
            foreach ($termine as $ta) {
                $j++;
                //$pp = PPProduktpass::find($t->PPTermine_PPProduktpass_Id);
                //var_dump($produktpass['PP']);exit;
                //cpcDebug::cpc_debug("     INNER2 $j ", "PERF2");
                $t = $ta['Termin'];
                //echo("<pre>");var_dump($t);
                $tanz = $ta['anzeigen'];
                $id = $t->PPTermine_PPBoardSpalte_id;
                $pp = $produktpass['PP'];
                if (isset($pp) && !is_null($pp)) {
                    if (!$pp->PPProduktpass_IsRevision && $tanz/* TermineAnzeigen */) {
                        $dstart = (substr($t->PPTermine_DatumStart, 0, 4) != "0000")
                            ? DateTime::createFromFormat("Y-m-d H:i:s", $t->PPTermine_DatumStart)->format('d.m.Y')
                            : '';
                        $dende = (substr($t->PPTermine_DatumEnde, 0, 4) != "0000")
                            ? DateTime::createFromFormat("Y-m-d H:i:s", $t->PPTermine_DatumEnde)->format('d.m.Y')
                            : '';
                        //$dende = (DateTime::createFromFormat("Y-m-d H:i:s",$t->PPTermine_DatumEnde ) ) ? DateTime::createFromFormat("Y-m-d H:i:s",$t->PPTermine_DatumEnde )->format('d.m.Y'):'';
                        //cpcDebug::cpc_debug("Start:".$dstart." DB: ".$t->PPTermine_DatumStart,"FKE_99");
                        //cpcDebug::cpc_debug("Ende:".$dende,"FKE_99");
                        //cpcDebug::cpc_debug("Ende:".$t->PPTermine_PPProduktpass_Id." .... ".$pp->PPProduktpass_IAN,"FKE_99");
                        $row[$t->PPTermine_PPProduktpass_Id][$id] = array(
                            'bgcolor' => $this->getBGStatusColor($pp->PPProduktpass_Liefertermin, $pp->PPProduktpass_LieferterminJahr, $t->PPTermine_Status, $ids[$id]['rot'], $ids[$id]['rot']),
                            'status' => $t->PPTermine_Status,
                            'bemerkung' => $t->PPTermine_Bemerkungen,
                            'start' => $dstart,
                            'ende' => $dende,
                            'id' => $t->PPTermine_Id,
                            'history' => $t->PPTermine_History,
                            'mitarbeiter' => $t->PPTermine_MAZustaendigkeit,
                            'label' => $t->PPTermine_Label,
                            'stati' => $this->getStati($col->PPBoardSpalte_Stati),
                            'ian' => $pp->PPProduktpass_IAN,
                            '8WMuster'    => $produktpass['8WMuster']
                        );
                        $row[$t->PPTermine_PPProduktpass_Id]['ppid'] = $t->PPTermine_PPProduktpass_Id;
                        //cpcDebug::cpc_debug("ID: $t->PPTermine_PPProduktpass_Id <br>","FKE");
                        $row[$t->PPTermine_PPProduktpass_Id]['ppian'] = $pp->PPProduktpass_IAN;
                        $row[$t->PPTermine_PPProduktpass_Id]['herkunft'] = $pp->PPHerkunftslaender_Land;
                        $row[$t->PPTermine_PPProduktpass_Id]['produktionsstaette'] = $pp->PPAB_Produktionsstaette;
                        $row[$t->PPTermine_PPProduktpass_Id]['lt'] = $pp->PPProduktpass_Liefertermin;
                        $row[$t->PPTermine_PPProduktpass_Id]['ltJahr'] = $pp->PPProduktpass_LieferterminJahr;
                        //FOB Rückrechnung nach Ländern
                        $lj = $pp->PPProduktpass_LieferterminJahr;
                        $lz = 6;
                        if ($pp->PPHerkunftslaender_Land == "Türkei") {
                            $lz = 3;
                        }
                        if ($pp->PPHerkunftslaender_Land == "Ägypten") {
                            $lz = 3;
                        }
                        if ($pp->PPHerkunftslaender_Land == "Äthiopien") {
                            $lz = 4;
                        }
                        $lw = $pp->PPProduktpass_Liefertermin - $lz;
                        if ($lw < 0) {
                            $lj--;
                            $lw += 52;
                        }
                        $row[$t->PPTermine_PPProduktpass_Id]['FOB'] = $lw . "/" . $lj;
                        $row[$t->PPTermine_PPProduktpass_Id]['FOBsort'] = $lj . $lw;
                        $row[$t->PPTermine_PPProduktpass_Id]['ltJahr2'] = $pp->PPProduktpass_LieferterminJahr - 2000;
                        $row[$t->PPTermine_PPProduktpass_Id]['wbislt'] = $pp->PPProduktpass_Liefertermin + ($pp->PPProduktpass_LieferterminJahr - $jahr) * 52 - $kw;
                        $row[$t->PPTermine_PPProduktpass_Id]['artikelbez'] = $pp->PPProduktpass_Artikelbezeichnung;
                        $row[$t->PPTermine_PPProduktpass_Id]['projekt'] = $pp->PPProduktpass_PPProjekte_Projekt;
                        $row[$t->PPTermine_PPProduktpass_Id]['status'] = $pp->PPProduktpass_Status;
                        $ppmitarbeiter_import = PPMitarbeiter::find($pp->PPProduktpass_Import_BISUser_Id);
                        if (is_null($ppmitarbeiter_import)) {
                            $import_ma = 'N.N';
                        } else {
                            $import_ma = $ppmitarbeiter_import->PPMitarbeiter_Kuerzel;
                        }
                        $row[$t->PPTermine_PPProduktpass_Id]['liefertermine'] = $this->getLaenderLT($t->PPTermine_PPProduktpass_Id);
                        $row[$t->PPTermine_PPProduktpass_Id]['import_ma'] = $import_ma;
                        if (is_null($pp->PPProduktpass_Import_Datum)) {
                            $import_datum = "--";
                        } else {
                            $import_datum = DateTime::createFromFormat("Y-m-d H:i:s", $pp->PPProduktpass_Import_Datum)->format('d.m.Y');
                        }
                        $row[$t->PPTermine_PPProduktpass_Id]['import_datum'] = $import_datum;
                        //echo("<pre>");var_dump($row); exit;
                    }
                }
            }
        }
        //}
        //cpcDebug::cpc_debug("getBoard: $id INTERIM", "PERF2");
        if (count($row) <= 0) {
            return false;
        }
        $row = $this->array_orderby($row, $sort, $sortart);
        $colspanmaxid = 0;
        foreach ($ids as $h) {
            if ($h['colspan'] == 1) {
                $colspan = 1;
                $colspanmaxid = $h['id'];
            } else {
                $ids[$colspanmaxid]['colspan']++;
                $ids[$h['id']]['colspan'] = 0;
            }
        }
        $data['header'] = $ids;
        $data['termine'] = $row;
        $data['kw'] = $kw;
        $data['jahr'] = $jahr;
        $data['colors'] = $this->getStatiColors();
        //cpcDebug::cpc_debug("getBoard: $id Ende", "PERF2");
        //exit;
        //echo('<pre>');var_dump ($data);echo('</pre>');exit;
        return $data;
    }
    private function getBoardArray($id, $sort, $sortart, $wheres = null)
    {
        //echo("<pre>");var_dump($where); exit;
        $sqlProduktpass = "";
        $sqlTermine = "";
        //cpcDebug::cpc_debug("getBoardArray: $id Start", "PERF1");
        if ($wheres) {
            $sqlWhere = array();
            foreach ($wheres as $where) {
                $sqlWhere[$where['art']][] = $where['attr'] . " like '" . $where['value'] . "%'";
            }
            if (isset($sqlWhere['T'])) {
                foreach ($sqlWhere['T'] as $sql) {
                    $sqlTermine .= $sql . " and ";
                }
                $sqlTermine = substr($sqlTermine, 0, strlen($sqlTermine) - 5);
            }
            if (isset($sqlWhere['P'])) {
                foreach ($sqlWhere['P'] as $sql) {
                    $sqlProduktpass .= $sql . " and ";
                }
                $sqlProduktpass = substr($sqlProduktpass, 0, strlen($sqlProduktpass) - 5);
            }
            $sqlProduktpassF = "";
            if (isset($sqlWhere['F'])) {
                $sqlProduktpassF .= " (";
                foreach ($sqlWhere['F'] as $sql) {
                    $sqlProduktpassF .= $sql . " or ";
                }
                $sqlProduktpassF = substr($sqlProduktpassF, 0, strlen($sqlProduktpassF) - 4) . " )";
            }
            if (strlen($sqlProduktpassF) > 1) {
                $sqlProduktpass = $sqlProduktpass . $sqlProduktpassF;
            }
        }
        //echo("<pre>");
        //var_dump($sqlProduktpass);
        //exit;
        // $select = "SELECT * from PPProduktpass left join PPHerkunftslaenderPPAB on PPProduktpass_Id = PPAB_PPProduktpass_Id where PPProduktpass_IAN not like '%Re%'";
        $select = "SELECT * from PPProduktpass left join PPHerkunftslaenderPPAB on PPProduktpass_Id = PPAB_PPProduktpass_Id where PPProduktpass_IAN  like '919%'";
        if (strlen($sqlProduktpass) > 0) {
            //        $select = "SELECT * from PPProduktpass left join PPHerkunftslaenderPPAB on PPProduktpass_Id = PPAB_PPProduktpass_Id where PPProduktpass_RevisionVon_PPProduktpass_Id is NULL and " . $sqlProduktpass;
            $select = "SELECT * from PPProduktpass left join PPHerkunftslaenderPPAB on PPProduktpass_Id = PPAB_PPProduktpass_Id where PPProduktpass_IAN not like '%Re%' and " . $sqlProduktpass;
        }
        $pps = DB::select(DB::raw($select));
        /* echo("$select <br> <pre> ");
        var_dump($pps);
        exit;
         */
        $aPPs = array();
        foreach ($pps as $pp) {
            //echo($pp->PPProduktpass_IAN . "<br>");
            //continue;
            //$muster =
            $aPPs[$pp->PPProduktpass_Id]['PP'] = $pp;
            $select = "SELECT * from PPTermine where PPTermine_PPProduktpass_Id = " . $pp->PPProduktpass_Id;
            $termine = DB::select(DB::raw($select));
            $aTermine = array();
            foreach ($termine as $termin) {
                $aTermine[$termin->PPTermine_PPBoardSpalte_id]['Termin'] = $termin;
                $aTermine[$termin->PPTermine_PPBoardSpalte_id]['anzeigen'] = 0;
            }
            $select = "SELECT * from PPTermine where PPTermine_PPProduktpass_Id = " . $pp->PPProduktpass_Id;
            if (strlen($sqlTermine) > 0) {
                $select = "SELECT * from PPTermine where PPTermine_PPProduktpass_Id = " . $pp->PPProduktpass_Id . " and " . $sqlTermine;
            }
            $termine = DB::select(DB::raw($select));
            $aTermineAnzeigen = array();
            foreach ($termine as $termin) {
                $aTermine[$termin->PPTermine_PPBoardSpalte_id]['anzeigen'] = 1;
            }
            $aPPs[$pp->PPProduktpass_Id]['Termine'] = $aTermine;
            $aPPs[$pp->PPProduktpass_Id]['8WMuster'] = $this->get8WMuster($pp->PPProduktpass_Id);
        }
        //cpcDebug::dd($aTermine,1);
        //cpcDebug::cpc_debug("getBoardArray: $id Ende", "PERF");
        return $aPPs;
    }
    private function get8WMuster($id)
    {
        return false;
        $select = " SELECT * FROM 8WMuster where PPProduktpass_Menge_PPProduktpass_Id = $id ";
        $ms = DB::select(DB::raw($select));
        if ($ms) {
            return $ms;
        }
        return false;
    }
    private function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
    public function filterTermine($afterupdate = false)
    {
        //var_dump(Input::all());exit;
        if ($afterupdate) {
            $qQry = Session::get('cpcqQry');
        } else {
            $qQry = Input::get('qQry');
            Session::forget('cpcMarkRow');
        }
        //var_dump(Input::all()); exit;
        if (Input::get('UserSettings_Save') != null) {
            if (Input::get('UserSettings_Name') != null) {
                $us = new PPUserSettings();
                $us->save();
                $us->PPUserSettings_Setting = Input::get('UserSettings_Name'); //Input::get('UserSettings_Name');
                $us->PPUserSettings_Type = 1;
                $colstates = SESSION::get('cpcCOLS');
                //var_dump($colstates);exit;
                $settings = "";
                foreach ($colstates as $key => $colstate) {
                    if ($colstate == "1") {
                        $settings .= $key . "#";
                    }
                }
                $us->PPUserSettings_Value = $settings;
                $us->save();
            }
        }
        if (Input::get('UserSettings_Delete') !== null) {
            if (Input::get('UserSettings_Setting') != null) {
                $us = PPUserSettings::where("PPUserSettings_Setting", "=", Input::get('UserSettings_Setting'))->first();
                $us->delete();
            }
        }
        if (Input::get('UserSettings_Setting') != null) {
            if (strlen(Input::get('UserSettings_Setting')) > 0) {
                if (PPUserSettings::where("PPUserSettings_Setting", "=", Input::get('UserSettings_Setting'))->count()) {
                    $us = PPUserSettings::where("PPUserSettings_Setting", "=", Input::get('UserSettings_Setting'))->first();
                    $acols = explode('#', $us->PPUserSettings_Value);
                    $COLS = array();
                    for ($i = 31; $i <= 65; $i++) {
                        $COLS[$i] = 0;
                    }
                    foreach ($acols as $key => $value) {
                        $COLS[$value] = 1;
                    }
                    Session::put('cpcCOLS', $COLS);
                }
            }
            //echo("<br><br><pre>");var_dump($COLS); echo("</pre>");exit;
        }
        $where = array();
        $strFilterWerte = "";
        //
        if (strlen($qQry[0]) > 0) {
            if ($qQry[0] != "0") {
                $where[]        = array(
                    'art'   => 'T', 'attr'  => 'PPTermine_Status',
                    'value' => $qQry[0]
                );
                $strFilterWerte .= "Termin Status = " . $qQry[0] . " - ";
            }
        }
        if (strlen($qQry[1]) > 0) {
            $where[]        = array(
                'art'   => 'P', 'attr'  => 'PPProduktpass_Status',
                'value' => $qQry[1]
            );
            $strFilterWerte .= "PP Status = gesetzt" . " - ";
        }
        if (strlen($qQry[2]) > 0) {
            if ($qQry[2] != 0) {
                $where[]        = array(
                    'art'   => 'T', 'attr'  => 'PPTermine_MAZustaendigkeit',
                    'value' => $qQry[2]
                );
                $strFilterWerte .= "Termin Verantwortlicher gesetzt" . " - ";
            }
        }
        if (strlen($qQry[3]) > 0) {
            $where[]        = array(
                'art'   => 'T', 'attr'  => 'PPTermine_Bemerkungen',
                'value' => $qQry[3]
            );
            $strFilterWerte .= "Termin Bemerkung " . $qQry[3] . " - ";
        }
        if (strlen($qQry[4]) > 0) {
            $where[] = array('art' => 'T', 'attr' => 'PPTermine_Label', 'value' => $qQry[4]);
            $strFilterWerte .= "Termin Label " . $qQry[4] . " - ";
        }
        if (strlen($qQry[5]) > 0) {
            $where[]        = array(
                'art'   => 'P', 'attr'  => 'PPProduktpass_IAN',
                'value' => $qQry[5]
            );
            $strFilterWerte .= "IAN " . $qQry[5] . " - ";
        }
        if (strlen($qQry[6]) > 0) {
            $where[]        = array(
                'art'   => 'P', 'attr'  => 'PPProduktpass_Artikelbezeichnung',
                'value' => $qQry[6]
            );
            $strFilterWerte .= "Artikel " . $qQry[6] . " - ";
        }
        if (strlen($qQry[7]) > 0) {
            $where[]        = array(
                'art'   => 'P', 'attr'  => 'PPProduktpass_PPProjekte_Projekt',
                'value' => $qQry[7]
            );
            $strFilterWerte .= "Projekt " . $qQry[7] . " - ";
        }
        if (isset($qQry[8])) {
            $where[]        = array(
                'art'   => 'X', 'attr'  => 'PPProduktpass_Status',
                'value' => $qQry[8]
            );
            $strFilterWerte .= "Mit Vorversionen - ";
        }
        if (strlen($qQry[9]) > 0) {
            if ($qQry[9] != 0) {
                $where[]        = array(
                    'art'   => 'P', 'attr'  => 'PPProduktpass_Ausmusterungnummer',
                    'value' => $qQry[9]
                );
                $strFilterWerte .= "Ausmusterung " . $qQry[9] . " - ";
            }
        }
        if (strlen($qQry[10]) > 0) {
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_Warengruppe',
                'value' => $qQry[10]
            );
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_AltIAN',
                'value' => $qQry[10]
            );
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_Marke',
                'value' => $qQry[10]
            );
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_WAWIArtikelnummer',
                'value' => $qQry[10]
            );
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_Material',
                'value' => $qQry[10]
            );
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_Thema',
                'value' => $qQry[10]
            );
            $where[]        = array(
                'art'   => 'F', 'attr'  => 'PPProduktpass_Artikelbezeichnung',
                'value' => $qQry[10]
            );
            $strFilterWerte .= "Freitext " . $qQry[10] . " - ";
        }
        if (strlen($qQry[30]) > 0) {
            if ($qQry[30] != 0) {
                $where[]        = array(
                    'art'   => 'P', 'attr'  => 'PPProduktpass_Import_BISUser_Id',
                    'value' => $qQry[30]
                );
                $strFilterWerte .= "MA Import " . $qQry[30] . " - ";
            }
        }
        if (strlen($qQry[31]) > 0) {
            if ($qQry[31] != 0) {
                $where[]        = array(
                    'art'   => 'P', 'attr'  => 'PPProduktpass_Import_Datum',
                    'value' => cpcHelp::Date2MySql($qQry[31])
                );
                $strFilterWerte .= "Datum Import " . $qQry[31] . " - ";
            }
        }
        if (strlen($qQry[32]) > 0) {
            $us = PPUserSettings::where("PPUserSettings_Setting", "=", "Ausmusterung_aktuell")->first();
            $us->PPUserSettings_Value = $qQry[32];
            $us->save();
        }
        if (strlen($qQry[42]) > 0) {
            $where[]        = array(
                'art'   => 'P', 'attr'  => 'PPAB_Produktionsstaette',
                'value' => $qQry[42]
            );
            $strFilterWerte .= "Produktionstätte " . $qQry[42] . " - ";
        }
        //
        if (strlen($qQry[43]) > 0) {
            $where[]        = array(
                'art'   => 'P', 'attr'  => 'PPHerkunftslaender_Land',
                'value' => $qQry[43]
            );
            $strFilterWerte .= "Land " . $qQry[43] . " - ";
        }
        if (count($where) > 0) {
            Session::set('cpcFilter_Where', $where);
            Session::set('cpcqQry', $qQry);
            Session::set('cpcFilterWerte', "Filter aktiv: " . $strFilterWerte);
        } else {
            $where = false;
            Session::set('cpcFilterWerte', 'Keine Filter aktiv!');
            Session::set('cpcFilter_Where', $where);
            Session::forget('cpcqQry');
        }
        //echo('<pre>');var_dump($where);echo('</pre>'); exit;
        return $this->showlist('wbislt', 'D', 2);
    }
    public function showlist_ohneSession()
    {
        $data['Ausmusterung_aktuell'] = $this->getUserSettings(2)['Ausmusterung_aktuell'];
        $where[]                      = array(
            'art'   => 'P', 'attr'  => 'PPProduktpass_Ausmusterungnummer',
            'value' => $data['Ausmusterung_aktuell']
        );
        Session::set('cpcFilter_Where', $where);
        Session::set('cpcFilterWerte', 'Aktuelle Ausmusterung');
        Session::set('cpcqQry', null);
        return $this->showlist('wbislt', 'D', 2);
    }
    public function getMitarbeiterListe($first = "Bitte auswählen...", $part = '', $mitNamen = false)
    {
        $status = 1;
        if ($part == 'DEL') {
            $art = '%';
            $status = -1;
        } else {
            $art = "%" . $part . "%";
        }
        $mas = PPMitarbeiter::where('PPMitarbeiter_Status', '>=', $status)->where('PPMitarbeiter_Taetigkeit', 'like', $art)->get();
        $mitarbeiterliste = array();
        foreach ($mas as $ma) {
            if ($mitNamen) {
                $mitarbeiterliste[$ma->PPMitarbeiter_Id] = $ma;
            } else {
                $mitarbeiterliste[$ma->PPMitarbeiter_Id] = $ma->PPMitarbeiter_Kuerzel;
            }
        }
        if(!$mitNamen){
            asort($mitarbeiterliste);
        }
        //echo('<pre>');
        //print_r($mitarbeiterliste);exit;
        return $mitarbeiterliste;
    }
    public function getTerminStati($art = 1)
    {
        $stati = PPStati::all();
        $statiliste = array('');
        foreach ($stati as $status) {
            if ($art == 1) {
                $statiliste[$status->PPStati_Id] = $status->PPStati_Status;
            } else {
                $statiliste[$status->PPStati_Status] = $status->PPStati_Status;
            }
        }
        asort($statiliste);
        return $statiliste;
    }
    public function getTerminStatiAll()
    {
        $stati = PPStati::all();
        $statiliste = array('');
        foreach ($stati as $status) {
            $statiliste[$status->PPStati_Id] = $status->PPStati_Status;
        }
        asort($statiliste);
        return $statiliste;
    }
    public function getUserSettings($type = '1')
    {
        $Usersettings = PPUserSettings::where('PPUserSettings_Type', "=", $type)->get();
        $aUsersettings = array('');
        switch ($type) {
            case '1':
                foreach ($Usersettings as $Usersetting) {
                    $aUsersettings[$Usersetting->PPUserSettings_Setting] = $Usersetting->PPUserSettings_Setting;
                }
                break;
            case '2':
                foreach ($Usersettings as $Usersetting) {
                    $aUsersettings[$Usersetting->PPUserSettings_Setting] = $Usersetting->PPUserSettings_Value;
                }
                break;
            default:
                break;
        }
        asort($aUsersettings);
        return $aUsersettings;
    }
    public function getAusmusterungen()
    {
        $select = " SELECT distinct(Left(PPProduktpass_Ausmusterungnummer,4)) as Ausmusterungnummer  FROM PPProduktpass ";
        $ausmusterungen = DB::select(DB::raw($select));
        $ausmusterungsliste = array(' ');
        foreach ($ausmusterungen as $ausmusterung) {
            $ausmusterungsliste[$ausmusterung->Ausmusterungnummer] = $ausmusterung->Ausmusterungnummer;
        }
        asort($ausmusterungsliste);
        return $ausmusterungsliste;
    }
    private function getUserSearch ($id, $board){
        if ($id == 1){
            $sp = PPUserSettings::where('PPUserSettings_UserId', $id)->where('PPUserSettings_Setting', 'like', "DashboardFilter$board" )->get()->first();
            if($sp){
                return (array) json_decode($sp->PPUserSettings_Value);
            } else {
                return array('PPProduktpass_Ausmusterungnummer' => "%", 'PPProduktpass_IAN' => "%");
            }
        }
        return array('PPProduktpass_Ausmusterungnummer' => "%", 'PPProduktpass_IAN' => "%");
    }
    public function showlist($sort = 'projekt', $psortart = 'U', $boardid = 1000, $getData = 0)
    {
        $kuerzel = Auth::user()->PPMitarbeiter_Kuerzel;
        $userTaetigkeit = Auth::user()->PPMitarbeiter_Taetigkeit;
        $searchParams = array(
            'PPProduktpass_Ausmusterungnummer' => "%",
            'PPProduktpass_IAN' => "%",
            'PPProduktpass_Artikelbezeichnung' => "%",
            'PPProduktpass_Ausmusterungnummer' => "%",
            'PPProduktpass_PPProjekte_Projekt' => "%",
            'PPPurchase_Supplier' => "%",
            'PPProduktpass_Warengruppe' => "%",
            'PPProduktpass_Thema' => "%",
            'PPProduktpass_ImportDatum' => "%"
        );
        if ($userTaetigkeit == 'PM'){
            $searchParams['PMler'] = $kuerzel;
        }
        if ($userTaetigkeit == 'TC'){
            $searchParams['TCler'] = $kuerzel;
        }
        if ($userTaetigkeit == 'PJM'){
            $searchParams['PJMler'] = $kuerzel;
        }
        $rows = 50;
        $page = 1;
        if (Request::isMethod('post')) {
            $searchParams = Input::get("sQry");
            $boardid = Input::get('inp_board');
            $rows = Input::get('rows');
            $page = Input::get('page');
        } else {
            $getData = 0;
        }
        cpcDebug::cpc_debug("Showlist Board: $boardid Sort: $sort $psortart Seite: $page Zeilen: $rows ", "@SHOWLIST");
        $sl = $this->showlistNeu($sort, $psortart, $boardid, $getData, $searchParams, $rows, $page);
        return $sl;
    }
    public function showlistPowerBI($pjn, $sort = 'projekt', $psortart = 'U', $boardid = 5, $getData = 0)
    {
        $searchParams = array('PPProduktpass_PPProjekte_Projekt' => $pjn);
        $sl = $this->showlistNeu($sort, $psortart, $boardid, $getData, $searchParams);
        return $sl;
        //return $this->showlistAlt($sort, $psortart, $boardid, $getData);
    }
    private function issetAndGetVTR($art, $ppid)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            if ($art == 'PM') {
                if ($pp->PPProduktpass_PMAdminVTR !== null and $pp->PPProduktpass_PMAdminVTR > 0) {
                    return $pp->PPProduktpass_PMAdminVTR;
                }
            }
            if ($art == 'TC') {
                if ($pp->PPProduktpass_TCAdminVTR !== null and $pp->PPProduktpass_TCAdminVTR > 0) {
                    return $pp->PPProduktpass_TCAdminVTR;
                }
            }
        }
        return null;
    }
    public function setMATermine($ppid, $art, $maid, $board)
    {
        //cpcDebug::cpc_debug("setMATermine ( $ppid, $art, $maid , $board ) ");
        $spalten = PPBoardSpalte::where('PPBoardSpalteData_Kind', 'like', $art . '%')->get();
        if (!$spalten) {
            return -1;
        }
        $atid = array();
        foreach ($spalten as $spalte) {
            $termin = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)
                ->where('PPTermine_PPBoardSpalte_id', $spalte->PPBoardSpalte_Id)
                ->where('PPTermine_Status', 'Neu')
                ->get()->first();
            if ($termin) {
                $termin->PPTermine_MAZustaendigkeit = $maid;
                $atid[] = $termin->PPTermine_Id;
                $termin->save();
            }
        }
        //cpcDebug::cpc_debug("setMATermine nach Schleife ");
        $ret = $this->systemMailTermine('TUEBERGABE', $atid, $maid, null, $board);
        $PMAdminVTR = $this->issetAndGetVTR('PM', $ppid);
        $TCAdminVTR = $this->issetAndGetVTR('TC', $ppid);
        if ($PMAdminVTR  !== null) {
            $ret = $this->systemMailTermine('TUEBERGABE', $atid, $PMAdminVTR, null, $board);
        }
        if ($TCAdminVTR !== null) {
            $ret = $this->systemMailTermine('TUEBERGABE', $atid, $TCAdminVTR, null, $board);
        }
        return 1;
    }
    public function setMATermine_Fault($ppid, $art, $maid, $board)
    {
        //cpcDebug::cpc_debug("setMATermine ( $ppid, $art, $maid , $board ) ",'!SetMA');
        //$spalten = PPBoardSpalte::where('PPBoardSpalteData_Kind', 'like', '%' . $art . '%')->where('PPBoard_Id', $board)->get();
        // Doch über Dashboard Grenzen hinweg die PM/TC setzten
        $spalten = PPBoardSpalteData::where('PPBoardSpalteData_Kind', 'like', $art.'%' )->get();
        if (!$spalten) {
            //cpcDebug::cpc_debug("setMATermine Return -1",'!SetMA');
            return -1;
        }
        //$atid = array();
        foreach ($spalten as $spalte) {
            //cpcDebug::cpc_debug("setMATermine Termin: ".$spalte->PPBoardSpalte_PPBoardSpalte_Bezeichnung,'!SetMA');
            $termin = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)
                ->where('PPTermine_PPBoardSpalte_id', $spalte->PPBoardSpalte_Id)
                ->where('PPTermine_Status', 'Neu')
                ->get()->first();
            if ($termin) {
                //cpcDebug::cpc_debug("setMATermine: ".$termin->PPTermine_PPBoardSpalte_id.'  '.$spalte->PPBoardSpalte_Id.' '.$spalte->PPBoardSpalte_PPBoardSpalte_Bezeichnung ,'!SetMA');
                $termin->PPTermine_MAZustaendigkeit = $maid;
                //$atid[] = $termin->PPTermine_Id;
                $termin->save();
            } else {
                //cpcDebug::cpc_debug("setMATermine:  Skip: ".$spalte->PPBoardSpalte_Id.' '.$spalte->PPBoardSpalte_PPBoardSpalte_Bezeichnung ,'!SetMA');
            }
        }
        //cpcDebug::cpc_debug("setMATermine Return 1",'!SetMA');
        //cpcDebug::cpc_debug("setMATermine nach Schleife ");
        return 1;
    }
    private function getEMailAdmin($art)
    {
        $ma = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', $art)->where('PPMitarbeiter_isDefault',1)->get()->first();
        if (!$ma) {
            return '';
        }
        return $ma->PPMitarbeiter_email;
    }   
    private function getEMail($maid)
    {
        $ma = PPMitarbeiter::where('PPMitarbeiter_Id', '=', $maid)->get()->first();
        if (!$ma) {
            return '';
        }
        $taetigkeit = $this->getMaTaetigkeit($maid);
        if (substr($ma->PPMitarbeiter_Kuerzel,0,1) == '@'){
            $em = $this->getEMailAdmin($taetigkeit);
            //cpcDebug::cpc_debug("getEMail @: ".$em,'!SetMA');
            return $em;
        }
        //cpcDebug::cpc_debug("getEMail: ".$ma->PPMitarbeiter_email,'!SetMA');
        return $ma->PPMitarbeiter_email;
    }   
    private function getMaTaetigkeit($maid)
    {
        $ma = PPMitarbeiter::where('PPMitarbeiter_Id', '=', $maid)->get()->first();
        if (!$ma) {
            return '';
        }
        return $ma->PPMitarbeiter_Taetigkeit;
    }
    public function systemMailTermine($art, $tid, $maid, $chid = null, $board = null, $isChange = false)
    {
        $email = $this->getEMail($maid);
        $gruppe = $this->getMaTaetigkeit($maid);
        //$email  = 'f.keppel@compecon.de';
        if (is_null($email) or strlen($email) < 3) {
            return 0;
        }
        //cpcdebug::cpc_debug("e-mail to: $email");
        switch ($art) {
            case 'TCHANGE':
                if (is_null($chid)) {
                    $tmail = DB::table('v_PPProduktpass_PPTermine')->where('PPTermine_Id', '=', $tid)->first();
                    if ($tmail) {
                        $PMAdminVtrEmail = '';
                        $TCAdminVtrEmail = '';
                        if ($tmail->PPProduktpass_PMAdminVTR !== null  and $tmail->PPProduktpass_PMAdmin == $maid) {
                            $PMAdminVtrEmail = $this->getEMail($tmail->PPProduktpass_PMAdminVTR);
                        }
                        if ($tmail->PPProduktpass_TCAdminVTR !== null and $tmail->PPProduktpass_TCAdmin == $maid) {
                            $TCAdminVtrEmail = $this->getEMail($tmail->PPProduktpass_TCAdminVTR );
                        }
                        $ian = $tmail->PPProduktpass_IAN;
                        //$ms     =  mb_convert_encoding($tmail->PPBoardSpalte_Bezeichnung, 'UTF-8');
                        $ms = $tmail->PPBoardSpalte_Bezeichnung;
                        $todo = 'Hauptaufgabe';
                        $bemerkung = '';
                        $bemerkungReceiver = '';
                        $start = $tmail->PPTermine_DatumStart;
                        $ppid = $tmail->PPProduktpass_Id;
                        $tid = $tmail->PPTermine_Id;
                        $bsid = $tmail->PPBoardSpalte_Id;
                    }
                } else {
                    $tmail = DB::table('v_TerminlistePP_2')->where('PPTermineChanges_Id', '=', $chid)->first();
                    if ($tmail) {
                        $PMAdminVtrEmail = '';
                        $TCAdminVtrEmail = '';
                        if ($tmail->PPProduktpass_PMAdminVTR !== null  and $tmail->PPProduktpass_PMAdmin == $maid) {
                            $PMAdminVtrEmail = $this->getEMail($tmail->PPProduktpass_PMAdminVTR);
                        }
                        if ($tmail->PPProduktpass_TCAdminVTR !== null and $tmail->PPProduktpass_TCAdmin == $maid) {
                            $TCAdminVtrEmail = $this->getEMail($tmail->PPProduktpass_TCAdminVTR );
                        }
                        //$ms     = mb_convert_encoding($tmail->PPBoardSpalte_Bezeichnung,'UTF-8');
                        $todo = $tmail->PPTermineChanges_Categorie;
                        $bemerkung = $tmail->Bemerkung;
                        $bemerkungReceiver = $tmail->PPTermineChanges_RemarkReceiver;
                        $ms = $tmail->PPBoardSpalte_Bezeichnung;
                        $start = $tmail->PPTermineChanges_DoUntil;
                        $ppid = $tmail->PPProduktpass_Id;
                        $tid = $tmail->PPTermine_Id;
                        $bsid = $tmail->PPTermine_PPBoardSpalte_id;
                    }
                }
                if ($tmail) {
                    $ian = $tmail->PPProduktpass_IAN;
                    $ausm =  $tmail->PPProduktpass_Ausmusterungnummer;
                    $ian_ausm = $ian.'_'.$ausm;
                    //cpcDebug::cpc_debug("e-mail to: $email Message: IAN: $ian MS: $ms Start: $start PPID: $ppid bsid: $bsid Tid: $tid  Start: $start ",'!systemMail');
                    $link = "https://" . $_SERVER['SERVER_NAME'] . "/getTerminFromIAN/" . $ian_ausm . "/" . $tid . "/1000/All/1";
                    //http://targa.twoffice.de/getTerminFromId/2133/287096/1000
                    $df = '';
                    if (strpos($start, '0000') === false) {
                        try {
                            $d = new Datetime($start);
                            $df = $d->format('d.m.Y');
                        } catch (Exception $ex) {
                        }
                    }
                    $body = "Ihnen wurde &uuml;ber das TPT eine Aufgabe zugewiesen.<br>";
                    if ($isChange){
                        $body = "Im TPT wurde eine Aufgabe geändert.<br>";
                    }
                    $body .= "<table>";
                    $body .= "<tr><td>IAN:</td><td><b>$ian</b></td></tr>";
                    $body .= "<tr><td>Meilenstein:</td><td><a href='$link'><b>$ms</b></a></td></tr>";
                    $body .= "<tr><td>ToDo:</td><td><b>$todo</b></td></tr>";
                    $body .= "<tr><td>Bemerkung:</td><td><b>$bemerkung</b></td></tr>";
                    $body .= "<tr><td>Bemerkung Zuständiger:</td><td><b>$bemerkungReceiver</b></td></tr>";
                    $body .= "<tr><td>Termin:</td><td><b>$df</b></td></tr>";
                    $body .= "</table><br>";
                    $body .= "********* ENDE ********";
                    //cpcDebug::cpc_debug("Body");
                    $subject = "[TPT]  $ian ($ms)";
                    //cpcDebug::cpc_debug("subject");
                    //cpcDebug::cpc_debug("send Message: email: $email Body: $body Betreff: $subject OK ");
                    //cpcDebug::cpc_debug("Before send");
                    $this->cpc_sendMail($email, $subject, $body);
                    if (strlen($TCAdminVtrEmail) > 4 and $gruppe =='TC' ) {
                        $this->cpc_sendMail($TCAdminVtrEmail, '[TC-VTR-email]' . $subject, $body);
                    }
                    if (strlen($PMAdminVtrEmail) > 4 and $gruppe =='PM') {
                        $this->cpc_sendMail($PMAdminVtrEmail, '[PM-VTR-email]' . $subject, $body);
                    }
                    //$this->testmail ("f.keppel@compecon.de", "TEST", "body Message"  );
                    //cpcDebug::cpc_debug("Message: $subject send!");
                } else {
                    //cpcDebug::cpc_debug("Message: No Result!");
                }
                //cpcDebug::cpc_debug("Break");
                break;
            case 'TUEBERGABE':
                $board_Bez = '[Projekte]';
                if ($board != 1000) {
                    $board_Bez = '[Musterung]';
                }
                $body = "<h3>Ihnen wurden &uuml;ber das TPT Aufgabe(n) zugewiesen</h3>";
                $body .= "<table cellspacing='0' celldadding='0'>
                    <tr>
                    <th style='padding:5px;border:1px solid gray;background-color:lightgray;'>IAN</th>
                    <th style='padding:5px;border:1px solid gray;background-color:lightgray;'>Meilenstein</th>
                    <th style='padding:5px;border:1px solid gray;background-color:lightgray;'>Termin</th>
                    </tr>";
                //DB::enableQueryLog();
                $tmail = DB::table('v_PPProduktpass_PPTermine')->whereIn('PPTermine_Id', $tid)->where('PPBoardSpalte_PPBoard_Id', $board)->get();
                //cpcdebug::cpc_debug (DB::getQueryLog());
                if (! $tmail ){
                    break;
                }
                foreach ($tmail as $m) {
                    $PMAdminVtrEmail = '';
                    $TCAdminVtrEmail = '';
                    if ($m->PPProduktpass_PMAdminVTR !== null) {
                        $PMAdminVtrEmail = $this->getEMail($m->PPProduktpass_PMAdminVTR);
                    }
                    if ($m->PPProduktpass_TCAdminVTR !== null) {
                        $TCAdminVtrEmail = $this->getEMail($m->PPProduktpass_TCAdminVTR);
                    }
                    $ian = $m->PPProduktpass_IAN;
                    $ms = $m->PPBoardSpalte_Bezeichnung;
                    $start = $m->PPTermine_DatumStart;
                    $artbez = $m->PPProduktpass_Artikelbezeichnung;
                    //cpcdebug::cpc_debug("TUEBERGABE: $ian $ms $start");
                    $subject = "[TPT]  Übergabe Projekt $ian Dashboard $board_Bez $artbez";
                    if ($m->PPStati_OKStatus == 0 and $m->PPTermine_DatumStart = '0000-00-00') {
                        $body .= "<tr><td style='border:1px solid gray;padding:5px;'><b>$ian</b></td>";
                        $body .= "<td style='border:1px solid gray;padding:5px;'>$ms</td>";
                        $df = "";
                        if (strpos($start, '0000') === false) {
                            $d = new Datetime($start);
                            $df = $d->format('d.m.Y');
                        }
                        $body .= "<td style='border:1px solid gray;padding:5px;'>" . $df . "</td></tr>";
                    }
                }
                $body .= "</table><br>";
                $body .= "********* ENDE ********";
                $x = $this->cpc_sendMail($email, $subject, $body);
                if (strlen($PMAdminVtrEmail) > 4 and $gruppe =='PM') {
                    $x = $this->cpc_sendMail($PMAdminVtrEmail, '[PM VTR-email]' . $subject, $body);
                }
                if (strlen($TCAdminVtrEmail) > 4 and $gruppe =='TC') {
                    $x = $this->cpc_sendMail($TCAdminVtrEmail, '[TC VTR-email]' . $subject, $body);
                }
                break;
            default:
                $i = 1;
                break;
        }
        //cpcdebug::cpc_debug("Am Ende");
        return TRUE;
    }
    private function bsIsInBoard($bs, $board)
    {
        $spalten = PPBoardSpalte::where('PPBoardSpalte_Id', $bs)->where('PPBoard_Id', $board)->count();
        if ($spalten > 0) {
            return true;
        }
        return false;
    }
    public function setMA_PM_TC()
    {
        $ppid = Input::get('id');
        $art = Input::get('art');
        $maid = Input::get('maid');
        $board = Input::get('board');
        cpcDebug::cpc_debug("setMA_PM_TC:  PPId: $ppid Art: $art MAId: $maid Board: $board",'@SetMA1');
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        $subject = 'Projekt IAN: '.$pp->PPProduktpass_IAN.' ['.substr($pp->PPProduktpass_Ausmusterungnummer,0,4).'] wurde ihnen als ';
        $body = '';
        if ($pp) {
            if ($art == 'PM') {
                $pp->PPProduktpass_PMAdmin = $maid;
                $subject .= ' PM zugeordnet!';
                $body = 'Viele Grüsse';
                    }
            if ($art == 'PJM') {
                $pp->PPProduktpass_PJMAdmin = $maid;
                $subject .= ' PJM zugeordnet!';
                $body = 'Viele Grüsse';
                    }
            if ($art == 'TC') {
                $pp->PPProduktpass_TCAdmin = $maid;
                $subject .= ' TC zugeordnet!';
                $body = 'Viele Grüsse';
            }
            cpcDebug::cpc_debug("setMA_PM_TC: " . $pp->PPProduktpass_TCAdmin ,'@SetMA1');
            $pp->save();
        }
        //return json_encode( array("success"=>1, "Data"=>array ('id' => $ppid, 'art' => $art, 'maid' => $maid)) );
        $result = $this->setMATermine($ppid, $art, $maid, $board);
        //$this->sendMail($maid, $subject, $body);
        //cpcDebug::cpc_debug("setMA_PM_TC:  Result: $result",'!SetMA');
        $return_data = array('id' => $ppid, 'art' => $art, 'maid' => $maid, 'func' => 'setMA_PM_TC');
        return json_encode(array("success" => $result, "Data" => $return_data));
    }
    private function sendMail ($maid, $subject, $body){
        if ($maid != 0){
            $to = $this->getEMail($maid);
            $this->cpc_sendMail($to,$subject, $body);
        }
    }
    public function setVTR()
    {
        $ppid = Input::get('id');
        $art = Input::get('art');
        if (Input::has('maid')){
            $maid = Input::get('maid');
        } else {
            $maid = null;
            //cpcDebug::cpc_debug("setVTR Art: $art MAId:NULL PPId: $ppid", "SetMAVTR");
        }
        //cpcDebug::cpc_debug("setVTR Art: $art MAId: $maid PPId: $ppid", "@SetMAVTR");
        $ian = '';
        $artikel = '';
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        $to = '';
        if ($pp) {
            //cpcDebug::cpc_debug("setVTR Art: Produktpass gefunden", "@SetMAVTR");
            $ian = $pp->PPProduktpass_IAN;
            $artikel = $pp->PPProduktpass_Artikelbezeichnung;
            if ($art == 'PM') {
                $pp->PPProduktpass_PMAdminVTR = $maid;
            }
            if ($art == 'PJM') {
                $pp->PPProduktpass_PJMAdminVTR = $maid;
                //cpcDebug::cpc_debug("setVTR PJM Vtr gesetzt", "@SetMAVTR");
            }
            if ($art == 'TC') {
                $pp->PPProduktpass_TCAdminVTR = $maid;
            }
            //cpcDebug::cpc_debug("setVTR PJM Vtr gesetzt und gesaved", "@SetMAVTR");
            $pp->save();
            $ma = PPMitarbeiter::where('PPMitarbeiter_Id', $maid)->get()->first();
            if ($ma){
                //$to = $ma->PPMitarbeiter_email;
                //cpcDebug::cpc_debug("setVTR Art: MAId: $maid gefunden", "@SetMAVTR");
                $to = $this->getEMail($maid);
            }
        }
        $msg = 'Vertretung aufgelöst!';
        $subject = "[TPT] Vertretung für IAN: $ian eingerichtet";
        $body = "Guten Tag, <br><br> sie wurden als Vertretung für das Projekt: <br><br><b><a href='http://".$_SERVER['SERVER_NAME']."/show/$pp->PPProduktpass_Id' >$ian</a>        $artikel</b><br><br> eingetragen.";
        if ($maid != 0){
            $msg = 'Vertretung wurde eingerichtet!';
            $this->cpc_sendMail($to,$subject, $body);
        }
        //return json_encode( array("success"=>1, "Data"=>array ('id' => $ppid, 'art' => $art, 'maid' => $maid)) );
        $return_data = array('id' => $ppid, 'art' => $art, 'maid' => $maid, 'func' => 'setVTR', 'message' => $msg, 'mailto' => $to);
        //cpcDebug::cpc_debug("setVTR:  Result: $msg to: $to MAID: " .$ma->PPMitarbeiter_Id,'@SetMAVTR');
        //cpcDebug::cpc_debug($return_data,'@SetMAVTR');
        return json_encode(array("success" => 'OK', "Data" => $return_data));
    }
    public function updateStatus()
    {
        $ppid = Input::get('id');
        $state = Input::get('state');
        $grund = Input::get('absageGrund');
        //cpcDebug::cpc_debug("Update Status $ppid $state ",'!1234');
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            $oldState = $pp->InternerStatus;
            $pp->InternerStatus = $state;
            $pp->PPProduktpass_Absagegrund = $grund;
            $pp->save();
            $this->setMATermineStatusChange($ppid, $pp->PPProduktpass_PMAdmin, $pp->PPProduktpass_TCAdmin);
            if ($state == 'GELIEFERT' or $state == 'ABSAGE'){
                $this->freezeMilestones($ppid);
            }
            //cpcDebug::cpc_debug("Alter Status: $oldState Neuer Status:  $state ",'!1234');
            if (($oldState == 'GELIEFERT' or $oldState == 'ABSAGE') and ($state == 'MUSTERUNG' or $state == 'PLAN' or $state == 'FIX')){
                //cpcDebug::cpc_debug("freeMS ",'!1234');
                $this->freeMilestones($ppid);
            }
            $result = 'OK';
            //cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'Status Änderung IAN: '.$pp->PPProduktpass_IAN, $oldState, $state );
            cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'Status Änderung IAN: ['.$pp->PPProduktpass_Ausmusterungnummer.'] '.$pp->PPProduktpass_IAN, $oldState, $state );
        } else {
            //cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'Fehler Status Änderung IAN: '.$pp->PPProduktpass_IAN, '', $state );
            cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'Fehler Status Änderung IAN: ['.$pp->PPProduktpass_Ausmusterungnummer.'] '.$pp->PPProduktpass_IAN, '', $state );
            $result = 'Error';
        }
        $return_data = array('id' => $ppid, 'state' => $state, 'func' => 'updateStatus');
        return json_encode(array("success" => $result, "Data" => $return_data));
    }
    private function _logCPC($user, $typ, $old, $new){
        $log = new PPLog();
        $log->PPLog_User = $user;
        $log->PPLog_Typ = $typ;
        $log->PPLog_Date = date('Y.m.d H:i:s');
        $log->PPLog_Old = $old;
        $log->PPLog_New = $new;
        $log->save();
    }
    private function stopWatch($switch = 1, $echo = 0, $exit = 0)
    {
        //echo("Stopwatch:  $switch , $echo , $exit <br>");
        if ($switch == 1) {
            $this->start_time = microtime(true);
            //echo("Start: <br>");
        } else {
            $this->end_time = microtime(true);
            $d = $this->end_time - $this->start_time;
            if ($echo == 1) {
                //echo("Ende: <br>");
                echo ("Start: " . $this->start_time . " Ende: " . $this->end_time . " Duration: " . $d . "<br>");
            }
            if ($exit == 1) {
                exit;
            }
        }
    }
    public function showlistNeu($sort = 'projekt', $psortart = 'U', $boardid = 1000, $getData = 0, $searchParams = null, $xRows = 100, $xPage = 1)
    {
        //print_r('###'); exit;
        //$data['EXEC_START'] = date('h:m:s');
        //echo("Sort: $sort art: $psortart board: $boardid   getdata: $getData<br>"); exit;
        $data['STARTTIME'] = microtime(true);
        //dd($searchParams);
        $data['Termine'] = array();
        $data['page'] = $xPage;
        $data['rows'] = $xRows;
        $data['totalRows'] = 0;
        //$sp = array("PPProduktpass_Ausmusterungnummer" => "1910");
        $data['HasData'] = 0;
        if ($getData == 0) {
            //print_r($boardid); exit;
            $data['Termine'] = $this->getSchedule($searchParams, $boardid, $xRows, $xPage);
            //echo('<pre>');
            //print_r($data['Termine']);
            //exit;
            $data['totalRows']  = 0;
            if ($data['Termine']){
                $data['totalRows'] = $data['Termine']['totalRows'];
                if ($data['totalRows'] / $xRows < $xPage){
                    //$data['page'] = 1;
                }
            }
            //cpcDebug::pe(count(   $data['Termine']['Values']),1);
            //$data['TermineMusterung'] = $this->getTermineMusterung($boardid);
            $data['TermineMusterung'] = null; //$this->getTermineMusterung($boardid);
            $data['HasData'] = 0;
            $data['SP'] = $searchParams;
            if ($data['Termine']) {
                $data['HasData'] = 1;
            }
        }
        $data['searchValues'] = $this->getDistinctSearchValues();
        $data['mitarbeiterliste'] = $this->getMitarbeiterListe('Bitte auswählen...','DEL');
        $data['mitarbeiterNamen'] = $this->getMitarbeiterListe('', '', true);
        //dd($data['mitarbeiterliste']);
        $data['PMs'] = $this->getMitarbeiterListe('X', 'PM');
        $data['PJMs'] = $this->getMitarbeiterListe('X', 'PJM');
        $data['TCs'] = $this->getMitarbeiterListe('X', 'TC');
        //$data['Kategorien'] = $this->getKategorien();
        $data['Board'] = $boardid;
        $data['EXEC_END'] = date('h:m:s');
        $data['scopes'] = $this->getScopes();
        $view1 = 'termine.termine_neu';
        $data['content'] = View::make($view1)->with('kalender', $data);
        switch ($boardid) {
            case 1000:
                $boardname = 'Projekte';
                break;
            case 1001:
                $boardname = 'Musterung';
                break;
            case 2000:
                $boardname = 'Geliefert';
                break;
            case 2002:
                $boardname = 'Absage';
                break;
            default:
                $boardname = 'N.N.';
                break;
        }
        $data['title'] = "TPT DB " . $boardname;
        return View::make('main', $data);
    }
    public function showlistAlt($sort = 'projekt', $psortart = 'U', $boardid = 2, $getData = 1)
    {
        $where = Session::get('cpcFilter_Where');
        if (!$where or is_null($where)) {
            $data['Ausmusterung_aktuell'] = $this->getUserSettings(2)['Ausmusterung_aktuell'];
            $where[]                      = array(
                'art'   => 'P', 'attr'  => 'PPProduktpass_Ausmusterungnummer',
                'value' => $data['Ausmusterung_aktuell']
            );
            for ($i = 0; $i < 44; $i++) {
                $xqry[$i] = Null;
            }
            $xqry[32] = $data['Ausmusterung_aktuell'];
            Session::set('cpcqQry', $xqry);
        }
        //$where[] = array('art' => 'P', 'attr' => 'PPProduktpass_IAN', 'value' => '325793');
        //set_time_limit(120);
        //echo('<pre>');var_dump ($where);echo('</pre>');exit;
        if ($psortart == 'U')
            $sortart = SORT_ASC;
        if ($psortart == 'D')
            $sortart = SORT_DESC;
        $data = array();
        if ($getData == 1) {
            $data = $this->getBoard($boardid, $sort, $sortart, $where);
            if ($data) {
                $data['hasData'] = 1;
            } else {
                $data['hasData'] = 0;
            }
        } else {
            $data['hasData'] = 0;
        }
        //echo("<pre>");var_dump($data);echo("</pre>");exit;
        $data['userSettings'] = $this->getUserSettings();
        $data['verantwortlicher'] = $this->getMitarbeiterListe();
        $data['mitarbeiterliste'] = $this->getMitarbeiterListe();
        $data['termin_stati'] = $this->getTerminStati();
        $data['ausmusterungen'] = $this->getAusmusterungen();
        //var_dump($this->getAusmusterungen());exit;
        $data['kw'] = date('W');
        $data['jahr'] = date('Y');
        $data['stati_all'] = $this->getTerminStatiAll();
        //var_dump($data['stati_all']);exit;
        $data['content'] = View::make('termine.termine_overview')->with('kalender', $data);
        //echo($data['content']);exit;
        //echo("OK");exit;
        //$stati = PPStati::all();
        //$data['stati'] = $stati;
        $data['footer']['KW'] = date('W');
        $data['footer']['Status'] = 'OK';
        $data['cols'] = Session::get('cpcCOLS');
        //echo("OK");exit;
        return View::make('main', $data);
    }
    public function show($id)
    {
        //
        $data['termin'] = $id;
        $data['info'] = "das ist ein Termin für alle";
        $data['datei'] = "file1";
        return View::make('termine.termine_details')->with("data", $data);
    }
    /**
     * Show the form for editing the specified resource.
     * GET /projects/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     * PUT /projects/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function newProjekt($id, $boardid = 2)
    {
        $spalten = PPBoardSpalte::where("PPBoardSpalte_PPBoard_Id", "=", $boardid)->get();
        foreach ($spalten as $spalte) {
            $termin = new PPTermine();
            $termin->PPTermine_PPProduktpass_Id = $id;
            //$termin->PPTermine_Header = "H".$i;
            $termin->PPTermine_Status = "Neu";
            $termin->PPTermine_PPBoardSpalte_id = $spalte->PPBoardSpalte_Id;
            $termin->save();
        }
        return Redirect::to('search');
    }
    private function _dateLocal2MySql($termin)
    {
        if (strlen($termin) > 4) {
            $datum = explode('.', $termin);
            return $datum[2] . '-' . $datum[1] . '-' . $datum[0];
        }
        return '3000-01-01';
    }
    function edittermin($id)
    {
        $data['termin'] = PPTermine::find($id);
        $pp = PPProduktpass::find($data['termin']->PPTermine_PPProduktpass_Id);
        //var_dump($pp);exit;
        $data['IAN'] = $pp->PPProduktpass_IAN;
        //Spalte auslesen
        $bs = PPBoardSpalte::find($data['termin']->PPTermine_PPBoardSpalte_id);
        $data['stati'] = $this->getStati($bs->PPBoardSpalte_Stati);
        $data['ma'] = $this->getMitarbeiterListe();
        $data['header'] = $bs;
        //echo("<pre>");var_dump($bs->PPBoardSpalte_Stati); echo("<br>################<br>");     echo("<pre>");var_dump($data['stati']); exit;
        return View::make('termine.termin_form')->with('data', $data);
    }
    function getBGStatusColorDashboard($kw, $jahr, $status, $rot, $orange)
    {
        $col = $this->getBGStatusColor($kw, $jahr, $status, $rot, $orange);
        //echo("  KW: $kw Jahr: $jahr Status: $status Rot: $rot Orange: $orange Col: $col  <br>  ");
        switch ($col) {
            case '180,180,180':
                $ret = 5;
                break;
            case '83,142,213':
                $ret = 4;
                break;
            case '82,142,213':
                $ret = 4;
                break;
            case '0,255,0':
                $ret = 5;
                break;
            case '255,0,0':
                $ret = 1;
                break;
            case '255,180,0':
                $ret = 2;
                break;
            default:
                $ret = 0;
                break;
        }
        //echo("<b>" . $ret . "$col </b> <br>");
        return $ret . "$col";
    }
    function postTerminlisteFilterM($sortierung = '8U', $puser = '', $init = 0)
    {
        return $this->postTerminlisteFilter($sortierung, $puser, $init, 'MU');
    }
    function postTerminlisteFilterI($sortierung = '8U', $puser = '', $init = 0)
    {
        return $this->postTerminlisteFilter($sortierung, $puser, $init, 'Inq');
    }
    function postTerminlisteFilter($sortierung = '8U', $puser = '', $init = 0, $_art = 'PP')
    {
        //echo("Sortierung: $sortierung <br>");exit;
        //echo("Method: " . Request::method() . "<br>");
        if (Request::method() == "GET") {
            // Variablen durch SESSION setzten
            //$ma = Input::get('qVerantwortlicher');
            if (Session::get('qMA')) {
                $ma = Session::get('qMA');
            } else {
                $ma = Auth::user()->PPMitarbeiter_Kuerzel;
            }
            //echo("GET: $ma ");
            //$ma               = Session::get('qMA');
            $ta = (Session::get('qTerminart') !== null) ? Session::get('qTerminart') : '';
            $ian = (Session::get('qIAN') !== null) ? Session::get('qIAN') : '';
            $ausm = (Session::get('qAusm') !== null) ? Session::get('qAusm') : '';
            $status = (Session::get('qStatus') !== null) ? Session::get('qStatus') : '';
            $statusTermin = (Session::get('qStatusTermin') !== null) ? Session::get('qStatusTermin') : '';
            $int_status = (Session::get('qintStatus') !== null) ? Session::get('qintStatus') : '';
            $solltermin_local = (Session::get('qSollTermin') !== null) ? Session::get('qSollTermin') : '';
            $solltermin = $this->_dateLocal2MySql($solltermin_local);
            $fcol = (Session::get('qfcol') !== null) ? Session::get('qfcol') : '';
            $terminBez = (Session::get('qfcol') !== null) ? Session::get('qfcol') : '';
            $art = $_art;
            if ($sortierung == "X") {
                $ma = Auth::user()->PPMitarbeiter_Kuerzel;
                $ta = "";
                $ian = "";
                $ausm = "";
                $status = "";
                $statusTermin = "";
                $int_status = "";
                $solltermin_local = "";
                $solltermin = "";
                $fcol = "";
                $terminBez = "";
            }
        } else {
            $fcol = Input::get('fcol');
            $ma = Input::get('qVerantwortlicher');
            $ta = Input::get('qTerminart');
            $ian = Input::get('qIAN');
            $int_status = Input::get('qintStatus');
            $status = Input::get('qStatus');
            $statusTermin = Input::get('qStatusTermin');
            $ausm = Input::get('qAusm');
            $solltermin_local = Input::get('qSollTermin');
            $_art = Input::get('art');
        }
        $art = 'PP';
        //$termine = PPTermine::all();
        //
        set_time_limit(120);
        /* 0,255,0 gruen
        255,192,0 orange
        83,142,213 blau
        255,0,0 rot
        180,180,180 grau */
        $scol = "";
        $selectErledigte = " and PPStati_OKStatus != 1 ";
        if (isset($fcol['all'])) {
            $scol .= "all";
            $selectErledigte = "";
            unset($fcol['gruen']);
            unset($fcol['orange']);
            unset($fcol['blau']);
            unset($fcol['rot']);
            unset($fcol['grau']);
        } else {
            if (isset($fcol['gruen'])) {
                $scol .= " #0,255,0# ";
            }
            if (isset($fcol['orange'])) {
                $scol .= " #255,180,0# ";
            }
            if (isset($fcol['blau'])) {
                $scol .= " #83,142,213# ";
            }
            if (isset($fcol['rot'])) {
                $scol .= " #255,0,0# ";
            }
            if (isset($fcol['grau'])) {
                $scol .= " #180,180,180# ";
            }
        }
        if ($init) {
            $scol = "all";
        }
        if (strlen($puser) >= 2) {
            //$ma     = $puser;
            $ta = '';
            $ian = '';
            $status = '';
            $int_status = '';
            $ausm = '';
            $solltermin = date("Y-m-d", strtotime("31 December 2099"));
            //echo($solltermin);exit;
            $solltermin_local =  date('d.m.Y', strtotime("31 December 2099"));
        } else {
            if ($ma == "") {
                $ma = '%';
            }
            if ($solltermin_local == "") {
                $solltermin_local = date('d.m.Y', strtotime("31 December 2099"));
            }
            $solltermin = $this->_dateLocal2MySql($solltermin_local);
        }
        $mitarbeiters = DB::select(DB::raw("select * from PPMitarbeiter where PPMitarbeiter_Status = 1 order by PPMitarbeiter_Kuerzel"));
        $ama = array();
        $maName = array();
        foreach ($mitarbeiters as $mitarbeiter) {
            $ama[] = $mitarbeiter->PPMitarbeiter_Kuerzel;
            $maName[$mitarbeiter->PPMitarbeiter_Kuerzel]  = $mitarbeiter->PPMitarbeiter_Name . ', ' . $mitarbeiter->PPMitarbeiter_Vorname;
        }
        $data['mitarbeiter'] = $ama;
        $data['mitarbeiterNamen'] = $maName;
        //echo ("$scol <br>" );var_dump(Input::get('fcol'));exit;
        Session::set('qMA', $ma);
        Session::set('qTerminart', $ta);
        Session::set('qIAN', $ian);
        Session::set('qAusm', $ausm);
        Session::set('qStatus', $status);
        Session::set('qStatusTermin', $statusTermin);
        Session::set('qintStatus', $int_status);
        Session::set('qSollTermin', $solltermin_local);
        Session::set('qfcol', $fcol);
        Session::set('art', $_art);
        $SP['qMA'] = $ma;
        $SP['qTerminart'] = $ta;
        $SP['qIAN'] = $ian;
        $SP['qAusm'] = $ausm;
        $SP['qStatus'] = $status;
        $SP['qintStatus'] = $int_status;
        $SP['qStatusTermin'] = $statusTermin;
        $SP['qSollTermin'] = $solltermin_local;
        $SP['qfcol'] = $fcol;
        $ma = strtoupper($ma);
        $maselect = "";
        //$maselect = " and  (PPMitarbeiter_Kuerzel = '$ma' or (PPMitarbeiter_Taetigkeit = 'TC' and  TC_Vtr = '$ma') or( PPMitarbeiter_Taetigkeit = 'PM' and PM_Vtr = '$ma'))  ";
        $maselect = " and  ((PPMitarbeiter_Kuerzel like '$ma') or (PPMitarbeiter_Taetigkeit = 'TC' and  TC_Vtr like '$ma') or ( PPMitarbeiter_Taetigkeit = 'PM' and PM_Vtr like '$ma') or ( PPMitarbeiter_Taetigkeit = 'PJM' and PJM_Vtr like '$ma'))  ";
        if (isset($fcol['onlyMy']) ){
            $maselect = " and  (PPMitarbeiter_Kuerzel like '$ma') ";
        }
        $selectAusm = "";
        if (strlen($ausm) > 0) {
            //echo($ausm); exit;
            $selectAusm .= " and PPProduktpass_Ausmusterungnummer like '" . $ausm . "%'";
        }
        $selectIAN = "";
        if (strlen($ian) > 0) {
            $selectAusm .= " and ( PPProduktpass_IAN like '" . $ian . "%' or PPProduktpass_PPProjekte_Projekt like '" . $ian . "%')  ";
        }
        if (strlen($status) > 0) {
            $selectAusm .= " and  PPProduktpass_Status like '%" . $status . "%' ";
        }
        if (strlen($statusTermin) > 0) {
            $selectAusm .= " and  PPTermine_Status like '" . $statusTermin . "' ";
        }
        $boardid = 1000;
        $tablePostfix = '';
        if ($_art == 'PP') {
            //echo("A");
            $title = 'TPT Termine Projekte';
            $boardid = 1000;
            $tablePostfix = 'FIX';
        }
        if ($_art == 'MU') {
            //echo("A");
            $title = 'TPT Termine Musterung';
            $boardid = 1001;
            $tablePostfix = 'PLAN';
        }
        if (strlen($int_status) > 0 and ($int_status != '%')) {
            //echo("1");
            $iStat_array = explode(',', $int_status);
            $inISt = "";
            foreach ($iStat_array as $istat) {
                $inISt .= "'$istat',";
            }
            $inISt = substr($inISt, 0, strlen($inISt) - 1);
            $selectAusm .= " and  InternerStatus in  (" . $inISt . ") ";
        } else {
            if ($_art == 'PP') {
                //echo("A");
                $selectAusm .= " and  InternerStatus in  ('FIX') ";
            }
            if ($_art == 'MU') {
                //echo("B");
                $selectAusm .= " and  InternerStatus in  ('PLAN', 'MUSTERUNG') ";
            }
        }
        if (strlen($ta) > 0) {
            $selectAusm .= " and  PPBoardSpalte_Bezeichnung like '%" . $ta . "%' ";
        }
        $select_spalten = " select PPBoardSpalteX_PPBoardSpalte_Id from PPBoardSpalteX where  PPBoardSpalte_PPBoard_Id = $boardid ";
        $spalten = DB::select(DB::raw($select_spalten));
        $spalten_string = '';
        foreach ($spalten as $spalte) {
            $spalten_string .= $spalte->PPBoardSpalteX_PPBoardSpalte_Id . ',';
        }
        $spalten_string = substr($spalten_string, 0, -1);
        $selct_Attribute = " select * ";
        //$select_cmd = "  from v_Terminliste$art where PPProduktpass_IAN not like '999%' and PPTermine_PPBoardSpalte_id in ( $spalten_string ) and     DateMilestone <= '$solltermin' " . $maselect . " " . $selectIAN . " " . $selectAusm . " " . $selectErledigte;
        $qryDev = " and  PPProduktpass_IAN not like '999%'";
        if (Config::get('app.cEnv') == 'development'){
            $qryDev = '';
        }
        $table = 'v_Terminliste'.$art.'_2'.$tablePostfix;
        //echo($table);exit;
        $select_cmd = "  from $table where  PPTermineChanges_Categorie not like 'leer' $qryDev and PPTermine_PPBoardSpalte_id in ( $spalten_string ) and     DateMilestone <= '$solltermin' " . $maselect . " " . $selectIAN . " " . $selectAusm . " " . $selectErledigte;
        //echo($select);
        if (strlen($ian) > 0 and strpos(substr($ian, 0, 3), '999') !== false) {
            $select_cmd = "  from $table where PPTermine_PPBoardSpalte_id in ( $spalten_string ) and     DateMilestone <= '$solltermin' " . $maselect . " " . $selectIAN . " " . $selectAusm . " " . $selectErledigte;
        }
        $select = $selct_Attribute . $select_cmd;
        //echo("BBBBBBBBBBBBBBBBBBBBBBBBBBBBBB<br>");
        //if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
        //    echo($select_cmd." ##### ". $sortierung); exit;
        //}
        $sort = substr($sortierung, 0, 1);
        $dir = " asc ";
        if (substr($sortierung, 1, 1) == 'D') {
            $dir = " desc ";
        }
        if ($sort == '1') {
            $select .= " order by PPMitarbeiter_Kuerzel " . $dir;
        }
        if ($sort == 'X') {
            $select .= " order by DateMilestone " . $dir;
        }
        if ($sort == '6') {
            $select .= " order by DateMilestone " . $dir;
        }
        if ($sort == '8') {
            $select .= " order by DateMilestone " . $dir;
        }
        if ($sort == '10') {
            $select .= " order by PPTermineChanges_DoneAt " . $dir;
        }
        if ($sort == '7') {
            $select .= " order by PPProduktpass_Status " . $dir;
        }
        if ($sort == '5') {
            $select .= " order by PPTermine_Status" . $dir;
        }
        if ($sort == '4') {
            $select .= " order by PPBoardSpalte_Bezeichnung" . $dir;
        }
        if ($sort == '2') {
            $select .= " order by PPProduktpass_PPProjekte_Projekt $dir, PPProduktpass_IAN $dir ";
        }
        //echo('Start: '. date('i:s.u')."<br>".$select.'<br>');
        $termine = DB::select(DB::raw($select));
        //echo('Ende: '.date('i:s.u')."<br>");
        //exit;
        //var_dump($termine);exit;
        //cpcDebug::pe($select);
        $data['bg'] = array();
        $ndx = 0;
        foreach ($termine as $termin) {
            //$pp = PPProduktpass::find($termin->PPTermine_PPProduktpass_Id);
            //$col = PPBoardSpalte::find($termin->PPTermine_PPBoardSpalte_id);
            $error = false;
            $LTorCRDWoche = $termin->PPProduktpass_Liefertermin;
            $LTorCRDJahr = $termin->PPProduktpass_LieferterminJahr;
            if ($termin->PPProduktpass_CRDJahr > 0) {
                $LTorCRDWoche = $termin->PPProduktpass_CRDWoche;
                $LTorCRDJahr = $termin->PPProduktpass_CRDJahr;
            }
            //$this->ddfk("$LTorCRDWoche $LTorCRDJahr <br>",0);
            try {
                $crd = new DateTime();
                $crd->setISODate($LTorCRDJahr, $LTorCRDWoche);
                //echo("ID:".$termin->PPTermine_Id." MA:" .$termin->PPMitarbeiter_Kuerzel."");
                $rot = $termin->PPBoardSpalte_Rot;
                $data['manSoll'][$termin->PPTermine_Id . '_' . $termin->PPTermineChanges_Id] = '';
                if ($termin->PPTermine_ManSoll != 0) {
                    $rot = -1 * $termin->PPTermine_ManSoll;
                    $subKW = 10 + $termin->PPTermine_ManSoll - 1;
                    $crd = $crd->sub(new DateInterval('P' . $subKW . 'W'));
                    $tag = $crd->format('w');
                    if ($tag < 5) {
                        $tag = 5 - $tag - 1;
                    }
                    if ($tag > 6) {
                        $tag = 5;
                    }
                    //echo($termin->PPTermine_Id. " " .$crd->format("W") ."  @". $termin->PPTermine_ManSoll ."@<br>");
                    //$crd->setISODate($termin->PPProduktpass_LieferterminJahr, $startKWNeu);
                    $crd->sub(new DateInterval('P' . $tag . 'D'));
                    $data['manSoll'][$termin->PPTermine_Id . '_' . $termin->PPTermineChanges_Id] = $crd->format('d.m.Y');
                }
                $data['bg'][$termin->PPTermine_Id.'_'.$termin->PPTermineChanges_Id] = "";//array($termin->DateMilestone, $termin->PPTermine_Id . '_' . $termin->PPTermineChanges_Id, $this->getBGStatusColorDashboard($LTorCRDWoche, $LTorCRDJahr,  $termin->PPTermine_Status, $rot, $rot - 2));
                $ndx++;
                //echo('OK <br>');
            } catch (Exception $ex) {
                $error = true;
                $data['bg'][] = array('', [$termin->PPTermine_Id . '_' . $termin->PPTermineChanges_Id]);
            }
            if (!$error) {
                $data['aTermine'][$termin->PPTermine_Id . '_' . $termin->PPTermineChanges_Id] = $termin;
            }
        }
        //echo('<br><pre>');      print_r($data['bg']); exit;
        /* if ($sort == '5') {
        if ($dir == " asc ")
        asort($data['bg']);
        else
        arsort($data['bg']);
        }*/
        //Farben aussortieren
        if (false) {
            foreach ($data['bg'] as $key => $value) {
                //echo("<br>$key -> $value <br>");
                /* 0,255,0 gruen
                255,192,0 orange
                83,142,213 blau
                255,0,0 rot
                180,180,180 grau */
                if (strpos($scol, "all") !== false) {
                    $data['bg'][$key] = substr($value, 1);
                } else {
                    if (strpos($scol, substr($value, 1)) !== false) {
                        $data['bg'][$key] = substr($value, 1);
                    } else {
                        echo ("unset: $key <br>");
                        unset($data['bg'][$key]);
                    }
                }
                //cpcDebug::dd($data['bg'], True);
                /* if (isset ($scol['rot']) && $scol['rot'] == substr($value,1)) $data['bg'][$key] = substr($value, 1);
            if (isset ($scol['gruen']) && $scol['gruen'] == substr($value,1)) $data['bg'][$key] = substr($value, 1);
            if (isset ($scol['orange']) && $scol['orange'] == substr($value,1)) $data['bg'][$key] = substr($value, 1);
            if (isset ($scol['rot']) && $scol['rot'] == substr($value,1)) $data['bg'][$key] = substr($value, 1);
            if (isset ($scol['blau']) && $scol['blau'] == substr($value,1)) $data['bg'][$key] = substr($value, 1); */
            }
        }
        //cpcDebug::dd($data['bg']);
        //print_r($data['aTermine']); exit;
        $selectStati = "select distinct PPTermine_Status as TerminStatus from v_Terminliste$art where PPStati_OKStatus != 1";
        $statiTerminResult = DB::select(DB::raw($selectStati));
        $data['statiTermin'] = array();
        foreach ($statiTerminResult as $st) {
            $data['statiTermin'][] = $st->TerminStatus;
        }
        //dd( $data['statiTermin']);
        $data['colors'] = $this->getStatiColors();
        $data['art'] = $art;
        $data['termine'] = $termine;
        $data['error'] = "Keine Termine vorhanden!";
        $data['searchValues'] = $this->getDistinctSearchValues($_art);
        $data['SP'] = $SP;
        $data['title'] = $title;
        $data['content'] = View::make('listen.terminliste')->with('data', $data);
        return View::make('main', $data);
    }
    public function getTermineDashboard()
    {
        $kuerzel = Auth::user()->PPMitarbeiter_Kuerzel;
        return $this->postTerminlisteFilter('6U', $kuerzel, 1);
    }
    private function getFileUrl($id)
    {
        $files = PPPPFiles::where('PPPPFiles_Id', $id)->get()->first();
        if ($files) {
            if (strlen($files->PPPPFiles_Name) > 3) {
                return url("/data/" . $files->PPPPFiles_Pfad . "/" . $files->PPPPFiles_Name);
            }
        }
        return "";
    }
    function getTermineLog_alt($id)
    {
        $logs = PPTermineChanges::where("PPTermineChanges_PPTermine_Id", "=", $id)->orderBy('PPTermineChanges_Date', 'DESC')->get();
        if ($logs) {
            foreach ($logs as $log) {
                $log->URL = $this->getFileUrl($log->PPTermineChanges_PPPPFilesId);
                //print_r ($log);
            }
            //exit;
            return $logs;
        }
        return null;
    }
    private function buildTree($l, $sub, $start)
    {
        if (isset($l[$start])) {
            $tree = $l[$start];
        } else {
            return array($start, -1);
        }
        foreach ($tree as $k => $subtree) {
            $resTree[$start] = [$k];
            $resTree = $this->buildTree($l, $subtree, $k);
        }
        return $resTree;
    }
    private function addKnoten_DEL($l, $knoten)
    {
        //echo('</pre>'.$knoten.'<br>---------------------------------------<br><pre>');
        //var_dump($l);
        $res = array();
        if (!is_array($l)) {
            $res[$knoten] = -1;
            return $res;
        }
        foreach ($l as $nf => $subtree) {
            $res[$knoten] = $nf;
            $res = array_merge($res, $this->addKnoten($subtree, $nf));
        }
        return $res;
    }
    private function addKnoten($l, $knoten)
    {
        //  echo ("<br><br><br>START----------------------------- $knoten <br>");
        $this->sortTree = array();
        return $this->visit($l, 0);
    }
    private function visit($all, $k = 0, $ebene = 0)
    {
        //echo('</pre><br>VISITVISITVISITVISITVISITVISITVISIT '. $k.'<br><pre>');var_dump ($all);
        //echo('</pre><br>***************************************************<br>');
        if (isset($all[$k])) {
            $result = array();
            foreach ($all[$k] as $k1 => $valx) {
                //echo("Ebene: $ebene Konten: $k1 <br>");
                $this->sortTree[] = array('Ebene' => $ebene, 'Knoten' => $k1);
                $this->visit($all, $k1, $ebene + 1);
            }
        }
        return $this->sortTree;
    }
    function getTermineLog($id)
    {
        $logsSortTree = array();
        $logsValues = array();
        //$logrows = PPTermineChanges::where("PPTermineChanges_PPTermine_Id", "=", $id)->where('PPTermineChanges_IsActive', '=', 1)->orderBy('PPTermineChanges_Id', 'desc')->get();
        $logrows = PPTermineChanges::where("PPTermineChanges_PPTermine_Id", "=", $id)->where('PPTermineChanges_Categorie', '!=', '')->whereNull("PPTermineChanges_oldStatus")->orderBy('PPTermineChanges_Id', 'desc')->get();
        $logs = array();
        if ($logrows) {
            foreach ($logrows as $log) {
                $log->URL = $this->getFileUrl($log->PPTermineChanges_PPPPFilesId);
                $knoten = $log->PPTermineChanges_Id;
                $VG = 0;
                if (!is_null($log->PPTermineChanges_ParentId)) {
                    $VG = $log->PPTermineChanges_ParentId;
                }
                $logs[$VG][$knoten] = 1;
                $logsValues[$knoten] = $log;
            }
            //echo('</pre><br>LOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOGGGGGSS<pre>');var_dump ($logs);
            //echo('</pre><br>***************************************************<br>');
            $logSortTree = $this->addKnoten($logs, 0);
            //echo('<pre>');var_dump($logSortTree);
            //echo('</pre><br>-------------------------------------------------------<br>');
            //exit;
            /* foreach ($logs as $iVG => $logx){
            foreach ($logx as $knt => $log){
            echo("<pre>");print_r ($log['LogEintrag']);
            }
            }
            exit; */
            $res = array('log' => $logsValues, 'sort' => $logSortTree);
            //print_r ($res);
            return $res;
        }
        return null;
    }
    /*
    function getTermineLog_neu($id) {
    $logrows = PPTermineChanges::where("PPTermineChanges_PPTermine_Id", "=", $id)->orderBy('PPTermineChanges_Id')->get();
    $logs = array();
    if ($logrows) {
    foreach ($logrows as $log) {
    $log->URL = $this->getFileUrl($log->PPTermineChanges_PPPPFilesId);
    $knoten   = $log->PPTermineChanges_Id;
    $VG       = 0;
    if (!is_null($log->PPTermineChanges_ParentId)) {
    $VG = $log->PPTermineChanges_ParentId;
    }
    $logs[$VG][] = array("Knoten" => $knoten, "LogEintrag" => $log);
    }
    $logTree = $this->buildTree($logs, 0,0);
    return $logTree;
    }
    return null;
    }
     */
    /*
    public function testMail (){
    $to = 'f.keppel@compecon.de';
    $subject = "Betreff Test";
    $body = "Hallo Test";
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'sslout.de';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'tpt@twoffice.de';             // SMTP username
    $mail->Password = 'Hallo12345#';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom('tpt@twoffice.de', 'Targa Projekt Tool');          //This is the email your form sends From
    $mail->addAddress($to); // Add a recipient address
    //$mail->addAddress('contact@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Message has been sent';
    } catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
    }
     */
    public function cpc_sendMail($to, $subject, $body)
    {
        $this->mailer_config = Config::get('app.mailer');
        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            // ...
            //Server settings
            //$mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            //$mail->Host = 'sslout.de';                  // Specify main and backup SMTP servers
            //$mail->SMTPAuth = true;                               // Enable SMTP authentication
            //$mail->Username = 'tpt@twoffice.de';             // SMTP username
            //$mail->Password = 'Hallo12345#';                           // SMTP password
            //$mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
            //$mail->Port = 465;                                    // TCP port to connect to
            $mail->Host = $this->mailer_config['mailer_Host']; // Specify main and backup SMTP servers
            $mail->SMTPAuth = $this->mailer_config['mailer_SMTPAuth']; // Enable SMTP authentication
            $mail->Username = $this->mailer_config['mailer_Username']; // SMTP username
            $mail->Password = $this->mailer_config['mailer_Password']; // SMTP password
            $mail->SMTPSecure = $this->mailer_config['mailer_SMTPSecure']; // Enable SSL encryption, TLS also accepted with port 465
            $mail->Port = $this->mailer_config['mailer_Port']; // TCP port to connect to
            $mail->Port = 465;                                    // TCP port to connect to
            $mail->SMTPSecure  = 'tsl'; //tls or ssl
            $mail->SMTPOptions = array('ssl' => array(
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ));
            //Recipients
            //$mail->setFrom('tpt@twoffice.de', 'Targa Projekt Tool');
            //$mail->SMTPOptions = array('ssl' => array('verify_peer'       => false,
            //                                          'verify_peer_name'  => false,
            //                                          'allow_self_signed' => true));
            //Recipients
            $mail->setFrom($this->mailer_config['mailer_FromEMail'], $this->mailer_config['mailer_FromName']); //This is the email your form sends From
            $mail->addAddress($to); // Add a recipient address
            //$mail->addAddress('contact@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body."<br><br><br><span style='color:lightgray; font-size:10px;'>Mail ging an: $to</span>";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
        } catch (Exception $ex) {
            //cpcdebug::cpc_debug('Exception mailer: ' . $ex->getMessage());
        }
        return true;
    }
    public function update($id, $form = false)
    {
        //echo($id."<br>");
        //var_dump(Input::all());exit;
        //echo(Input::get('PPTermine_Id'));exit;
        $lang = $this->getUserLanguage();
        cpcdebug::cpc_debug("Update Termin $id Sprache: $lang", "@updateTermine");
        $termin = PPTermine::find($id);
        $ppid = $termin->PPtermine_PPProduktpass_Id;
        $oDatumStart = date("Y-m-d", strtotime($termin->PPTermine_DatumStart));
        $oDatumEnde = date("Y-m-d", strtotime($termin->PPTermine_DatumEnde));
        $oBemerkungen = $termin->PPTermine_Bemerkungen;
        $oLabel = $termin->PPTermine_label;
        if ($lang == 'EN'){
            $oBemerkungen = $termin->PPTermine_BemerkungenEN;
            $oLabel = $termin->PPTermine_labelEN;
        }   
        $oMAZustaendigkeit = $termin->PPTermine_MAZustaendigkeit;
        $oStatus = $termin->PPTermine_Status;
        $nStart = null !== Input::get('Termine_Datum') && strlen(trim(Input::get('Termine_Datum'))) > 8
            ? date("Y-m-d", strtotime(Input::get('Termine_Datum'))) : '0000-00-00';
        $nEnde = null !== Input::get('Termine_Datum_Ende') && strlen(trim(Input::get('Termine_Datum_Ende'))) > 8
            ? date("Y-m-d", strtotime(Input::get('Termine_Datum_Ende')))
            : '0000-00-00';
        $nBemerkungen = Input::get('Termine_Bemerkung');
        $nMAZustaendigkeit = Input::get('Termine_Mitarbeiter');
        $nStatus = Input::get('Termine_Status');
        $nLabel = Input::get('Termine_Label');
        $setManSoll = false;
        if (Input::has('Termine_ManSoll')) {
            $nManSoll = Input::get('Termine_ManSoll');
            $setManSoll = true;
        }
        //echo("  Status - nStatus  ");    exit;
        $termin->PPTermine_DatumStart = $nStart;
        $termin->PPTermine_DatumEnde = $nEnde;
        $termin->PPTermine_Bemerkungen = $this->change2Translated($nBemerkungen);
        $termin->PPTermine_MAZustaendigkeit = $nMAZustaendigkeit;
        $termin->PPTermine_Status = $nStatus;
        $termin->PPTermine_Label = $this->change2Translated($nLabel);
        if ($setManSoll) {
            $termin->PPTermine_ManSoll = $nManSoll;
        }
        $termin->save();
        if ($nStart != $oDatumStart) {
            cpcDebug::cpc_debug("Termin Datum Start geändert von $oDatumStart zu $nStart", "@updateTermine");
            $this->changeStatusMasterplan($ppid);
        }
        $bchange = false;
        $change = "\n--- " . Auth::user()->PPMitarbeiter_Kuerzel . " - " . date('d.m.Y') . " --- ";
        if ($oDatumStart != $termin->PPTermine_DatumStart) {
            $bchange = true;
            $change = $change . "\nTermin: " . date("d.m.Y", strtotime($oDatumStart)) . " -> " . date("d.m.Y", strtotime($termin->PPTermine_DatumStart));
        }
        if ($oDatumEnde != $termin->PPTermine_DatumEnde) {
            //$bchange = true; $change = $change . "\nEnde: ".date("d.m.Y", strtotime($oDatumEnde))." -> ". date("d.m.Y", strtotime($termin->PPTermine_DatumEnde));
        }
        if ($oBemerkungen != $termin->PPTermine_Bemerkungen) {
            $bchange = true;
            $change = $change . "\nBemerkungen: " . $oBemerkungen . " -> " . $termin->PPTermine_Bemerkungen;
        }
        if ($oMAZustaendigkeit != $termin->PPTermine_MAZustaendigkeit) {
            if (isset($oMAZustaendigkeit) && $oMAZustaendigkeit != 0) {
                $mkuerzel1 = PPMitarbeiter::find($oMAZustaendigkeit)->PPMitarbeiter_Kuerzel;
            } else {
                $mkuerzel1 = 'NN';
            }
            $mkuerzel2 = PPMitarbeiter::find($termin->PPTermine_MAZustaendigkeit)->PPMitarbeiter_Kuerzel;
            $bchange = true;
            $change = $change . "\nVerantwortlicher: " . $mkuerzel1 . " -> " . $mkuerzel2;
        }
        if ($oStatus != $termin->PPTermine_Status) {
            $bchange = true;
            $change = $change . "\nStatus: " . $oStatus . " -> " . $termin->PPTermine_Status;
        }
        if ($oLabel != $termin->PPTermine_Label) {
            $bchange = true;
            $change = $change . "\nAnzeigetext: " . $oLabel . " -> " . $termin->PPTermine_Label;
        }
        //$change = $change. "\n******************";
        if ($bchange) {
            if ($this->getUserLanguage() == 'EN'){
                $termin->PPTermine_HistoryEN = $change . $termin->PPTermine_HistoryEN;
                $termin->PPTermine_History =  $this->translateContent($change, 'DE', 'EN') .  $termin->PPTermine_History;
            } 
            if ($this->getUserLanguage() == 'DE'){
                $termin->PPTermine_History = $change . $termin->PPTermine_History;
                $termin->PPTermine_HistoryEN = $this->translateHistory($termin);
                $termin->PPTermine_HistoryEN =  $this->translateContent($change, 'DE', 'EN') .  $termin->PPTermine_HistoryEN;
            }
            $termin->save();
        }
        try {
            $statusChange['PPTermineChanges_Date'] = date('Y-m-d H:i:s');
            $statusChange['PPTermineChanges_PPProduktpass_id'] = $ppid;
            $statusChange['PPTermineChanges_oldStatus'] = $oStatus;
            $statusChange['PPTermineChanges_newStatus'] = $nStatus;
            $statusChange['PPTermineChanges_Remark'] = $nBemerkungen;
            $statusChange['PPTermineChanges_PPTermine_Id'] = $id;
            $statusChange['PPTermineChanges_Mitarbeiter_Id'] = $oMAZustaendigkeit;
            $statusChange['PPTermineChanges_Mitarbeiter_Id_Old'] = $termin->PPTermine_MAZustaendigkeit;
            $statusChange['PPTermineChanges_Reporter'] = Auth::getUser()->id;
            $this->updateTermineLog($statusChange);
        } catch (exception $e) {
            //cpcDebug::cpc_debug("Message: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine());
        }
        /*
        $data = $this->getBoard(2,'wbislt', SORT_ASC);
        $mas = PPMitarbeiter::all();
        foreach($mas as $ma){
        $mitarbeiterliste[$ma->PPMitarbeiter_Id]=$ma->PPMitarbeiter_Kuerzel;
        }
        $mitarbeiterliste[0]="Bitte auswählen...";
        $data['mitarbeiterliste']=$mitarbeiterliste;
        $mitarbeiterliste[0]="";
        asort($mitarbeiterliste);
        $data['verantwortlicher']=$mitarbeiterliste;
        $data['content'] = View::make('termine.termine_overview')->with ('kalender',$data);
        return View::make('main',$data);
         */
        if ($form) {
            //return $this->getTermineDashboard();
            //return
            //header('Content-type: application/json');
            //return json_encode( array("success"=>1, "Data"=>"bbb") );
            return $this->postTerminlisteFilter();
            //var_dump(Response::json(array('result' => 'OK', 'cont' => 'Daten gesichert')));exit;;
        }
        return $this->postTerminlisteFilter();
    }
    private function countTermine($ppid)
    {
        $termCount = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->count();
        return $termCount;
    }
    public function ergaenzeNeueTerminspalten()
    {
        /*$ppids = array (1369, 1353, 1352,1350,1349,1348,1345,1344,1342,1341,1338,
                        1337,1335,1329,1328,1326,1325,1324,1322,1319,1318,1317,
                        1316,1315,1170,1162,1093,1092,1091,1084,1077,1070,1069,
                        1068,1067,1060,1058,1056);*/
        //$ppids = array (1377, 1389);
        //$pps = tPPProduktpass::where('PPProduktpass_IAN', 'not like', '%rev%')->get();
        $pps = tPPProduktpass::where('PPProduktpass_IAN', 'not like', '%ev%')->get();
        foreach ($pps as $pp) {
            //$c = 0;
            //$c = $this->countTermine($pp->PPProduktpass_Id);
            //echo($pp->PPProduktpass_IAN." Anzahl: $c <br>");
            $this->_ergaenzeNeueTerminspalten($pp->PPProduktpass_Id);
        }
    }
    private function _ergaenzeNeueTerminspalten($ppid)
    {
        echo ("Start<br>");
        //        $PPs = DB::table('v_IANReal')->where("PPProduktpass_Id", ">=", "5481")->where("PPProduktpass_Id", "<=", "5488")->get();
        //$maxId = PPTermine::max('PPTermine_PPBoardSpalte_id');
        $PPs = DB::table('tPPProduktpass')->where("PPProduktpass_Id", "=", "$ppid")->get();
        foreach ($PPs as $pp) {
            if (strlen($pp->PPProduktpass_IAN) == 6) {
                $maxId = 999; //PPTermine::where('PPTermine_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->max('PPTermine_PPBoardSpalte_id');
                echo ("Ergänze neue Termine für PP: " . $pp->PPProduktpass_IAN . " [$pp->PPProduktpass_Id] $maxId <br>");
                $this->ergaenzeNeueTerminspaltenFuer($pp->PPProduktpass_Id, $maxId);
            }
        }
        $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', $ppid)->get()->first();
        if (!$purchase) {
            $po = new PPPurchase();
            $po->PPPurchase_PPProduktpass_Id = $ppid;
            $po->save();
            echo ('Neue PO<br>');
        } else {
            echo ('PO OK<br>');
        }
        echo ("<br>FERTIG!<br>");
    }
    public function ergaenzeNeueTerminspaltenTest()
    {
        echo ("Start All2<br>");
        $i = 1;
        //        $PPs = DB::table('v_IANReal')->where("PPProduktpass_Id", ">=", "5481")->where("PPProduktpass_Id", "<=", "5488")->get();
        //$maxId = PPTermine::max('PPTermine_PPBoardSpalte_id');
        //$PPs = DB::table('tPPProduktpass')->where("PPProduktpass_Id", "=", "2840")->get();
        $PPs = DB::table('tPPProduktpass')->where("InternerStatus", "like", "%")->get();
        foreach ($PPs as $pp) {
            if (strlen($pp->PPProduktpass_IAN) == 6) {
                //$maxId = PPTermine::where('PPTermine_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->max('PPTermine_PPBoardSpalte_id');
                $termins = PPTermine::where('PPTermine_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->where('PPTermine_PPBoardSpalte_id', '=', 1055)->get()->first();
                if ($termins) {
                    //echo (" OK<br>");
                } else {
                    echo ("$i .) PP: " . $pp->PPProduktpass_IAN . " [$pp->PPProduktpass_Id]  => ");
                    $i++;
                    echo (" ***** NOK<br>");
                }
                //$this->ergaenzeNeueTerminspaltenFuer($pp->PPProduktpass_Id, $maxId);
            }
        }
        echo ("<br>FERTIG!<br>");
    }
    private function hasTerminId($ppid, $bspid)
    {
        $t = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardspalte_Id', $bspid)->get()->first();
        if ($t) {
            return true;
        }
        return false;
    }
    public function ergaenzeNeueTerminspaltenFuer($id, $maxId = 0)
    {
        //$spalten = DB::table('PPBoardSpalte')->where('PPBoardSpalte_Id', '>', $maxId)->get();
        echo ("Ergänze: $id <br>");
        //$spalten = DB::table('PPBoardSpalteData')->where('PPBoardSpalte_Id', '>=', $maxId)->get();
        $sps = PPTermine::where('PPTermine_PPProduktpass_Id', '=', $id)->orderBy('PPTermine_PPBoardSpalte_id')->get();
        $asp=array();
        foreach ($sps as $sp) {
            $asp[] = $sp->PPTermine_PPBoardSpalte_id;
        }
        //print_r($asp);
        /*$po = PPPurchase::where('PPPurchase_PPProduktpass_Id', $id)->get()->first();
        if (is_null($po)) {
            $po = new PPPurchase();
            //echo('    Neue PO angelegt!<br>');
            $po->save();
        }*/
        $spalten = DB::table('PPBoardSpalteData')->whereNotIn('PPBoardSpalte_Id', $asp)->where('PPBoardSpalte_Id', '>', 999)->get();
        //dd($spalten);
        $done = false;
        foreach ($spalten as $spalte) {
            if (!$this->hasTerminId($id, $spalte->PPBoardSpalte_Id)) {
                //echo($spalte->PPBoardSpalte_Id."<br>");
                echo (" NEU ID: $id $spalte->PPBoardSpalte_Id $spalte->PPBoardSpalte_Bezeichnung <br>");
                $termin = new PPTermine();
                $termin->PPTermine_PPProduktpass_Id = $id;
                //$termin->PPTermine_Header = "H".$i;
                $termin->PPTermine_Status = "Neu";
                $termin->PPTermine_PPBoardSpalte_id = $spalte->PPBoardSpalte_Id;
                $termin->PPTermine_MAZustaendigkeit = $spalte->PPBoardSpalte_DefaultMA;
                $termin->save();
            } else {
                //echo( '   '.$spalte->PPBoardSpalte_Bezeichnung . 'OK <br>');
            }
        }
    }
    private function getGermanDate($date)
    {
        try {
            $d = new DateTime($date);
            $ret = $d->format('d.m.Y');
        } catch (Exception $ex) {
            $ret = $date;
        }
        return $ret;
    }
    private function getSqlDate($sdate)
    {
        $nullDate = "0000-00-00";
        if (is_null($sdate) or strlen($sdate) < 10) {
            return $nullDate;
        } else {
            try {
                $d = substr($sdate, 0, 10);
                if ($sdate == $nullDate) {
                    return $nullDate;
                }
                $xd = explode(".", $d);
                $dd = $xd[2] . "-" . $xd[1] . "-" . $xd[0];
            } catch (exception $e) {
                //cpcDebug::cpc_debug($e->getMessage() . " d: " . $d);
                return $nullDate;
            }
            return $dd;
        }
    }
    public function insertNewTheme($sChgs)
    {
        //cpcDebug::cpc_debug("New Theme");
        //cpcDebug::cpc_debug($sChgs);
        //exit;
        $receiver = $sChgs['PPTermineChanges_Receiver'];
        $newLog = new PPTermineChanges();
        foreach ($sChgs as $key => $sChg) {
            //cpcDebug::cpc_debug($key . " .=>. " . $sChg);
            $newLog->$key = $sChg;
        }
        $newLog->save();
        if (Auth::getUser()->PPMitarbeiter_Id != $receiver) {
            $this->systemMailTermine('TCHANGE', $sChgs['PPTermineChanges_PPTermine_Id'], $receiver, $newLog->PPTermineChanges_Id);
        }
        //cpcDebug::cpc_debug("newTheme -> inserted");
    }
    public function updateTermineLog($sChgs)
    {
        cpcDebug::cpc_debug("Update Termin Log","@History");
        cpcDebug::cpc_debug($sChgs,"@History");
        $bProtokoll = false;
        if ($sChgs['PPTermineChanges_oldStatus'] == $sChgs['PPTermineChanges_newStatus']) {
            //Status ist gleich geblieben: Kommentar oder Categorie?
            if (isset($sChgs['PPTermineChanges_Categorie']) and $sChgs['PPTermineChanges_Categorie'] != "") {
                $bProtokoll = true;
            }
            if (isset($sChgs['PPTermineChanges_Remark']) and strlen($sChgs['PPTermineChanges_Remark']) > 1) {
                $bProtokoll = true;
            }   
            if (isset($sChgs['PPTermineChanges_RemarkReceiver']) and strlen($sChgs['PPTermineChanges_RemarkReceiver']) > 1) {
                $bProtokoll = true;
            }
            if ($sChgs['PPTermineChanges_Mitarbeiter_Id_Old'] != $sChgs['PPTermineChanges_Mitarbeiter_Id']) {
                $bProtokoll = true;
            }
            if (substr($sChgs['PPTermineChanges_DoUntilOld'], 0, 10) != substr($sChgs['PPTermineChanges_DoUntil'], 0, 10)) {
                $bProtokoll = true;
            }
        } else {
            //Status Ämderung => auf jeden fall Protokollieren
            $bProtokoll = true;
        }
        cpcDebug::cpc_debug("nach test","@History");
        if ($bProtokoll) {
            cpcDebug::cpc_debug('Neuer Change Eintrag',"@History");
            $newLog = new PPTermineChanges();
            foreach ($sChgs as $key => $sChg) {
                //cpcDebug::cpc_debug($key . " => " . $sChg);
                $newLog->$key = $sChg;
            }
            cpcDebug::cpc_debug("PPTermineChanges -> Vor saved", "@History");
            $newLog->save();
            cpcDebug::cpc_debug("PPTermineChanges -> saved", "@History");
        }
        cpcDebug::cpc_debug('Return updateTermineLog',"@History");
    }
    private function uploadFilesTermine($id, $bemerkung = "", $fileType = "Musterung", $skat = "Techpack")
    {
        /*
        echo('<pre>');
        var_dump(Input::all());
        echo('</pre>');
        exit; */
        $destinationPath = public_path() . '/data/uploads/';
        $file = Input::file('file');
        $filename = str_random(6) . "_" . $file->getClientOriginalName();
        $upload_success = $file->move($destinationPath, $filename);
        $files = new PPPPFiles();
        $files->PPPPFiles_Name = $filename;
        $files->PPPPFiles_PPProduktpass_Id = $id;
        $files->PPPPFiles_Type = $fileType;
        $files->PPPPFiles_Date = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description = $bemerkung;
        $files->PPPPFiles_SubKat = $skat;
        $files->save();
        //cpcDebug::cpc_debug("filesId: " . $files->PPPPFiles_Id, "Files");
        return $files->PPPPFiles_Id;
    }
    private function FilesTermine($file, $id, $bemerkung = "", $fileType = "Musterung", $skat = "Techpack")
    {
        $destinationPath = public_path() . '/data/uploads/';
        $filename = str_random(6) . "_" . $file->getClientOriginalName();
        $upload_success = $file->move($destinationPath, $filename);
        $files = new PPPPFiles();
        $files->PPPPFiles_Name = $filename;
        $files->PPPPFiles_PPProduktpass_Id = $id;
        $files->PPPPFiles_Type = $fileType;
        $files->PPPPFiles_Date = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description = $bemerkung;
        $files->PPPPFiles_SubKat = $skat;
        $files->save();
        //cpcDebug::cpc_debug("filesId: " . $files->PPPPFiles_Id, "Files");
        return $files->PPPPFiles_Id;
    }
    private function uploadFilesTermineX($file, $id, $bemerkung = "", $fileType = "Dateien-Unteraufgaben", $skat = "Upload")
    {
        //cpcDebug::cpc_debug("Start");
        //cpcDebug::cpc_debug($file);
        /*
        echo('<pre>');
        var_dump(Input::all());
        echo('</pre>');
        exit; */
        //$file = Input::file('file');
        $filename = str_random(6) . "_" . $file->getClientOriginalName();
        //cpcDebug::cpc_debug("Filename");
        //cpcDebug::cpc_debug($filename);
        $destinationPath = public_path() . '/data/uploads/';
        $filename = str_random(6) . "_" . $file->getClientOriginalName();
        $upload_success = $file->move($destinationPath, $filename);
        $files = new PPPPFiles();
        $files->PPPPFiles_Name = $filename;
        $files->PPPPFiles_PPProduktpass_Id = $id;
        $files->PPPPFiles_Type = $fileType;
        $files->PPPPFiles_Date = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description = $bemerkung;
        $files->PPPPFiles_UserCreate = Auth::getUser()->id;
        $files->PPPPFiles_SubKat = $skat;
        $files->save();
        //cpcDebug::cpc_debug("filesId: " . $files->PPPPFiles_Id, "Files");
        return $files->PPPPFiles_Id;
    }
    private function getDatefromjson($d)
    {
        //cpcDebug::cpc_debug("DateConvert: $d ");
        $dc = null;
        if (isset($d) and strlen($d) >= 10) {
            $da = substr($d, 0, 10);
            //cpcDebug::cpc_debug("DateConvert da: $da ");
            $db = explode('.', $da);
            //cpcDebug::cpc_debug($db);
            //cpcDebug::cpc_debug("DateConvert OK");
            $dc = $db[2] . "-" . $db[1] . "-" . $db[0];
        }
        //cpcDebug::cpc_debug($dc);
        return $dc;
    }
    public function setChangeErledigt()
    {
        $id = Input::get('id');
        $tid = Input::get('tid');
        //cpcDebug::cpc_debug("ID: $id TID: $tid", "ChangeErledigt2");
        $chng = PPTermineChanges::where("PPTermineChanges_Id", $id)->get()->first();
        if ($chng) {
            $chng->PPTermineChanges_DoneAt = date("Y-m-d H:i:s");
            $chng->save();
        }
        $chngLogs = $this->getTermineLog($tid);
        $ma = $this->getMitarbeiterListe();
        //cpcDebug::cpc_debug($chngLogs, "FFF");
        $view = View::make('termine.termineResultHistory')->with('params', array(
            "logs"        => $chngLogs, "Mitarbeiter" => $ma
        ));
        return Response::json(array(
            'result' => 'OK', 'tid'    => $tid, 'id'     => $id,
            'view'   => $view->render()
        ));
    }
    public function setChangeErledigtM()
    {
        $id = Input::get('id');
        $tid = Input::get('tid');
        $board = Input::get('board');
        //cpcDebug::cpc_debug("ID: $id TID: $tid", "ChangeErledigt2");
        $chng = PPTermineChanges::where("PPTermineChanges_Id", $id)->get()->first();
        if ($chng) {
            $chng->PPTermineChanges_DoneAt = date("Y-m-d H:i:s");
            $chng->save();
            //Mail an Initiator der Aufgabe
            $toId = $chng->PPTermineChanges_Mitarbeiter_Id;
            $toMA = PPMitarbeiter::where('PPMitarbeiter_Id',$toId)->get()->first();
            if ($toMA){
                $to = $this->getEMail($toId);//$toMA->PPMitarbeiter_email;
                $pp = tPPProduktpass::where('PPProduktpass_Id', $chng->PPTermineChanges_PPProduktpass_Id)->get()->first();
                if ($pp){
                    $link = "http://" . $_SERVER['SERVER_NAME'] . "/getTerminFromId/" . $pp->PPProduktpass_Id . "/" . $tid . "/$board/All/1";
                    $ian = $pp->PPProduktpass_IAN;
                    $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
                }
                $subject = "TPT-Aufgabe erledigt: ".$chng->PPTermineChanges_Categorie;
                $body = 'Im TPT wurde die Aufgabe '.$chng->PPTermineChanges_Categorie.' für die IAN: '.$ian.' Ausmusterung: '.$ausm.' als erledigt markiert!<br>';
                $body .= "<a href='$link' target='_blank'>Link zur Aufgabe</a>";
                $this->cpc_sendMail($to,$subject, $body);
                return Response::json(array('result' => 'OK Mail Send'));
            }
        }
        return Response::json(array('result' => 'NO Mail'));
    }
    public function modifyState()
    {
        //cpcDebug::cpc_debug("modifyState 2022");
        $jsonInput = Input::get('jsonObject');
        $json = json_decode($jsonInput);
        //cpcDebug::cpc_debug("JSON: ");
        //cpcDebug::cpc_debug($json);
        $uid = Auth::getUser()->PPMitarbeiter_Id;
        //cpcDebug::cpc_debug("Start");
        //cpcDebug::cpc_debug("ChId: " . $json->PPTermineChanges_Id);
        //cpcDebug::cpc_debug("UID: " . $uid);
        //cpcDebug::cpc_debug("New Receiver: " . $json->PPTermineChanges_NewReceiver);
        //cpcDebug::cpc_debug("Remark: " . $json->PPTermineChanges_NewRemark);
        //cpcDebug::cpc_debug("Remark Receiver: " . $json->PPTermineChanges_NewRemarkReceiver);
        //cpcDebug::cpc_debug("DoUntil: " . $json->PPTermineChanges_NewDoUntil);
        $chng = PPTermineChanges::where('PPTermineChanges_Id', $json->PPTermineChanges_Id)->get()->first();
        $isChange = false;
        if ($chng->PPTermineChanges_Receiver != $json->PPTermineChanges_NewReceiver) {
            $ma = $this->getMitarbeiterListe();
            $this->addHistory($chng->PPTermineChanges_PPTermine_Id, $ma[$chng->PPTermineChanges_Receiver], $ma[$json->PPTermineChanges_NewReceiver]);
        }
        $chng->PPTermineChanges_Receiver = $json->PPTermineChanges_NewReceiver;
        // mail an $json->PPTermineChanges_NewReceiver
        if ($chng->PPTermineChanges_DoUntil != $this->getSqlDate($json->PPTermineChanges_NewDoUntil)) {
            $this->addHistory($chng->PPTermineChanges_PPTermine_Id, $this->getGermanDate($chng->PPTermineChanges_DoUntil), $json->PPTermineChanges_NewDoUntil);
            $isChange = true;
        }
        $chng->PPTermineChanges_DoUntil = $this->getSqlDate($json->PPTermineChanges_NewDoUntil);
        // mail an $json->PPTermineChanges_NewReceiver
        if ($chng->PPTermineChanges_Remark != $json->PPTermineChanges_NewRemark) {
            $this->addHistory($chng->PPTermineChanges_PPTermine_Id, $chng->PPTermineChanges_Remark, $json->PPTermineChanges_NewRemark);
            $isChange = true;
        }
        $this->saveTranslationTermineChanges( $chng, 'PPTermineChanges_Remark', $json->PPTermineChanges_NewRemark ); //$chng->PPTermineChanges_Remark = $json->PPTermineChanges_NewRemark;
        //mail an $json->PPTermineChanges_NewReceiver
        if ($chng->PPTermineChanges_RemarkReceiver != $json->PPTermineChanges_NewRemarkReceiver) {
            $this->addHistory($chng->PPTermineChanges_PPTermine_Id, $chng->PPTermineChanges_RemarkReceiver, $json->PPTermineChanges_NewRemarkReceiver);
            $isChange = true;
            $this->saveTranslationTermineChanges( $chng, 'PPTermineChanges_RemarkReceiver', $json->PPTermineChanges_NewRemarkReceiver ); //$chng->PPTermineChanges_RemarkReceiver = $json->PPTermineChanges_NewRemarkReceiver;
            $chng->save();
            $this->sendChangeMail($chng->PPTermineChanges_PPTermine_Id, $chng->PPTermineChanges_Mitarbeiter_Id, $chng->PPTermineChanges_Id, $isChange);
        }
        //mail an $chng->PPTermineChanges_Mitarbeiter_Id
        $chng->save();
        $this->sendChangeMail($chng->PPTermineChanges_PPTermine_Id, $json->PPTermineChanges_NewReceiver, $chng->PPTermineChanges_Id, $isChange);
        /*
        if (Auth::getUser()->PPMitarbeiter_Id != $json->PPTermineChanges_NewReceiver) {
            $this->systemMailTermine('TCHANGE', $chng->PPTermineChanges_PPTermine_Id, $json->PPTermineChanges_NewReceiver, $chng->PPTermineChanges_Id, $isChange);
            //cpcdebug::cpc_debug("Mail send!");
        } else {
            //cpcdebug::cpc_debug("No Mail");
        }*/
        return Response::json(array('result' => 'OK', 'History' => $chng));
    }
    private function sendChangeMail ($pctid, $to, $pcid, $isChange){
        if (Auth::getUser()->PPMitarbeiter_Id != $to) {
            $this->systemMailTermine( 'TCHANGE', $pctid, $to, $pcid, null ,$isChange);
            //cpcdebug::cpc_debug("Mail send! $pcid");
        } else {
            //cpcdebug::cpc_debug("No Mail");
        }
    }
    private function getMilestone($tid)
    {
        $t = PPTermine::find($tid);
        if ($t) {
            $bs = PPBoardSpalteData::where('PPBoardSpalte_Id', $t->PPTermine_PPBoardSpalte_id)->get()->first();
            if ($bs) {
                return $bs->PPBoardSpalte_Bezeichnung;
            }
        }
        return '';
    }
    public function setChangeAnswerM()
    {
        //cpcDebug::cpc_debug("setChangeAnswer 2022");
        $jsonInput = Input::get('jsonObject');
        $json = json_decode($jsonInput);
        //cpcDebug::cpc_debug("JSON: ");
        //cpcDebug::cpc_debug($json);
        $id = Input::get('id');
        $tid = Input::get('tid');
        $uid = Auth::getUser()->PPMitarbeiter_Id;
        //cpcDebug::cpc_debug("Start");
        //cpcDebug::cpc_debug("ChId: " . $json->PPTermineChanges_Id);
        //cpcDebug::cpc_debug("UID: " . $uid);
        //cpcDebug::cpc_debug("TId: " . $json->PPTermineChanges_PPTermine_Id);
        //cpcDebug::cpc_debug("Receiver: " . $json->PPTermineChanges_Receiver);
        //cpcDebug::cpc_debug("DoUntil: " . $json->PPTermineChanges_DoUntil);
        // //cpcDebug::cpc_debug("New Receiver: " . $json->PPTermineChanges_NewReceiver);
        //cpcDebug::cpc_debug("Remark: " . $json->PPTermineChanges_Remark);
        //cpcDebug::cpc_debug("PPId: " . $json->PPTermineChanges_PPProduktpass_Id);
        $cat = $json->PPTermineChanges_Categorie;
        $parentChange = PPTermineChanges::where('PPTermineChanges_Id', '=', $json->PPTermineChanges_Id)->get()->first();
        if ($parentChange) {
            $cat = $parentChange->PPTermineChanges_Categorie;
        }
        $chng = new PPTermineChanges();
        $chng->PPTermineChanges_Date = date('Y-m-d H:i:s');
        $chng->PPTermineChanges_ParentId = $json->PPTermineChanges_Id;
        $chng->PPTermineChanges_Mitarbeiter_Id = $uid;
        $chng->PPTermineChanges_DoUntil = $this->getSqlDate($json->PPTermineChanges_DoUntil);
        $chng->PPTermineChanges_PPTermine_Id = $json->PPTermineChanges_PPTermine_Id;
        //$chng->PPTermineChanges_Receiver = $json->PPTermineChanges_Receiver;
        //$chng->PPTermineChanges_Remark = $json->PPTermineChanges_Remark;
        $this->saveTranslationTermineChanges($chng, 'PPTermineChanges_Receiver', $json->PPTermineChanges_Receiver);
        $this->saveTranslationTermineChanges($chng, 'PPTermineChanges_Remark', $json->PPTermineChanges_Receiver);
        $this->saveTranslationTermineChanges($chng, 'PPTermineChanges_Categorie', $json->PPTermineChanges_Categorie);
        //$chng->PPTermineChanges_Categorie = $json->PPTermineChanges_Categorie;
        $chng->PPTermineChanges_PPProduktpass_Id = $json->PPTermineChanges_PPProduktpass_Id;
        $chng->save();
        //cpcDebug::cpc_debug("setChangeAnswer Insert OK Next cpc_Sendmail From: " . Auth::getUser()->PPMitarbeiter_Id . " To: " . $json->PPTermineChanges_Receiver . " Tchid: " . $chng->PPTermineChanges_Id);
        if (Auth::getUser()->PPMitarbeiter_Id != $json->PPTermineChanges_Receiver) {
            //cpcDebug::cpc_debug("Mail Send $tid $uid $id Emfaenger: " . $json->PPTermineChanges_Receiver);
            $this->systemMailTermine('TCHANGE', $tid, $json->PPTermineChanges_Receiver, $chng->PPTermineChanges_Id);
            //cpcdebug::cpc_debug("Mail send!");
        } else {
            //cpcdebug::cpc_debug("No Mail");
        }
        //$chngLogs = $this->getTermineLog($tid);
        //$ma       = $this->getMitarbeiterListe();
        $fileId = 0;
        if (Input::hasFile('file')) {
            $file = Input::file('file');
            $fileId = $this->uploadFilesTermineX($file, $json->PPTermineChanges_PPProduktpass_Id, $json->PPTermineChanges_Remark);
            //cpcDebug::cpc_debug($fileId);
        }
        $chng->PPTermineChanges_PPPPFilesId = $fileId;
        $chng->save();
        /* $view = View::make('termine.termineResultHistory')->with('params', array(
        "logs"        => $chngLogs, "Mitarbeiter" => $ma));
        return Response::json(array('result' => 'OK', 'tid'    => $tid, 'id'     => $id,
        'view'   => $view->render())); */
        return Response::json(array('result' => 'OK'));
    }
    public function setChangeAnswer()
    {
        //cpcDebug::cpc_debug("setChangeAnswer", "setChangeAnswer");
        $id = Input::get('id');
        $tid = Input::get('tid');
        $uid = Auth::getUser()->PPMitarbeiter_Id;
        $chng = new PPTermineChanges();
        $chng->PPTermineChanges_ParentId = $id;
        $chng->PPTermineChanges_Mitarbeiter_Id = $uid;
        $chng->PPTermineChanges_PPTermine_Id = $tid;
        $chng->save();
        //cpcDebug::cpc_debug("Insert OK");
        $chngLogs = $this->getTermineLog($tid);
        $ma = $this->getMitarbeiterListe();
        $view = View::make('termine.termineResultHistory')->with('params', array(
            "logs"        => $chngLogs, "Mitarbeiter" => $ma
        ));
        return Response::json(array(
            'result' => 'OK', 'tid'    => $tid, 'id'     => $id,
            'view'   => $view->render()
        ));
    }
    public function updatejsonChangeState()
    {
        //cpcDebug::cpc_debug("Start updatejsonChangeState");
        $jsonObject = json_decode($_POST['jsonObject']);
        //cpcDebug::cpc_debug($jsonObject);
        $tid = $jsonObject->PPTermineChanges_PPTermine_Id;
        $ppid = $jsonObject->PPTermineChanges_PPProduktpass_Id;
        $fileId = 0;
        if (Input::hasFile('file')) {
            //cpcDebug::cpc_debug("Hat Datei....");
            $file = Input::files('file');
            if ($file) {
                $fileId = $this->uploadFilesTermineX($file, $ppid, $jsonObject->PPTermineChanges_Remark);
            }
        }
        $ret = array();
        foreach ($jsonObject as $att => $val) {
            //cpcDebug::cpc_debug("$att -> $val", "X99");
            $ret[$att] = $val;
        }
        if (strpos($jsonObject->PPTermineChanges_Categorie, "Bitte") !== false) {
            $jsonObject->PPTermineChanges_Categorie = "";
        }
        $oldStatus = $jsonObject->PPTermineChanges_oldStatus;
        $newStatus = $jsonObject->PPTermineChanges_newStatus;
        //cpcDebug::cpc_debug("$oldStatus => $newStatus", "Observe");
        if ($oldStatus != $newStatus) {
            $termin = PPTermine::where('PPTermine_Id', $tid)->get()->first();
            if ($termin) {
                if (!isset($newStatus) or strlen($newStatus) < 1) {
                    $newStatus = "Neu";
                }
                $termin->PPTermine_Status = $newStatus;
                $termin->save();
            }
        }
        $newLog = new PPTermineChanges();
        $newLog->PPTermineChanges_Mitarbeiter_Id = Auth::getUser()->PPMitarbeiter_Id;
        $newLog->PPTermineChanges_PPTermine_Id = $jsonObject->PPTermineChanges_PPTermine_Id;
        $newLog->PPTermineChanges_Receiver = $jsonObject->PPTermineChanges_Receiver;
        //$newLog->PPTermineChanges_Remark = $jsonObject->PPTermineChanges_Remark;
        //$newLog->PPTermineChanges_Categorie = $jsonObject->PPTermineChanges_Categorie;
        $this->saveTranslationTermineChanges($newLog, 'PPTermineChanges_Categorie', $jsonObject->PPTermineChanges_Categorie);
        $this->saveTranslationTermineChanges($newLog, 'PPTermineChanges_Remark', $jsonObject->PPTermineChanges_Remark);
        $newLog->PPTermineChanges_oldStatus = $jsonObject->PPTermineChanges_oldStatus;
        $newLog->PPTermineChanges_newStatus = $jsonObject->PPTermineChanges_newStatus;
        $newLog->PPTermineChanges_PPProduktpass_Id = $jsonObject->PPTermineChanges_PPProduktpass_Id;
        $newLog->PPTermineChanges_DoUntil = $this->getDatefromjson($jsonObject->PPTermineChanges_DoUntil);
        $newLog->PPTermineChanges_DoneAt = $this->getDatefromjson($jsonObject->PPTermineChanges_DoneAt);
        //cpcDebug::cpc_debug("DoUntil" . $newLog->PPTermineChanges_DoUntil);
        /* foreach ($attributes as $att) {
        //cpcDebug::cpc_debug($att . "  =>  " . $jsonObject->{$att}, $ext);
        try {
        $newLog->{$att} = $jsonObject->{$att};
        }
        catch (Exception $ex) {
        //cpcDebug::cpc_debug("Fehler bei: $att", $ext);
        }
        } */
        $newLog->PPTermineChanges_Date = date('Y-m-d H:i:s');
        $newLog->PPTermineChanges_PPPPFilesId = $fileId;
        $newLog->save();
        $chngLogs = $this->getTermineLog($tid);
        $ma = $this->getMitarbeiterListe();
        //cpcDebug::cpc_debug($chngLogs);
        $view = View::make('termine.termineResultHistory')->with('params', array(
            "logs" => $chngLogs, "Mitarbeiter" => $ma, "termin" => $termin
        ));
        //$view     = View::make('termine.termineResultHistory');
        //cpcDebug::cpc_debug("result www:", "X99");
        $result = array(
            'result' => 'OK',
            'id' => $jsonObject->PPTermineChanges_PPTermine_Id,
            'cont' => "cont",
            'view' => $view->render(),
            'json'   => "json"
        );
        /* $result = array('result' => 'OK', 'id'     => $jsonObject->PPTermineChanges_PPTermine_Id,
        'cont'   => $ret,
        'view'   => $view->render(),
        'json'   => $jsonObject); */
        //cpcDebug::cpc_debug($result);
        return Response::json($result);
    }
    private function getPPTermineChanges($tid)
    {
        $terminChanges = PPTermineChanges::where("PPTermineChanges_PPTermine_Id", $tid)->get();
        if ($terminChanges) {
            return $terminChanges;
        }
        return null;
    }
    public function updatejson()
    {
        try {
            $jsonObject = json_decode($_POST['jsonObject']);
            //cpcDebug::cpc_debug($jsonObject);
            //cpcDebug::cpc_debug("Object ausgegeben");
            $termin = PPTermine::find($jsonObject->{'Termine_Id'});
            $ppid = $termin->PPTermine_PPProduktpass_Id;
            $oDatumStart = date("Y-m-d", strtotime($termin->PPTermine_DatumStart));
            $oDatumEnde = date("Y-m-d", strtotime($termin->PPTermine_DatumEnde));
            $oBemerkungen = $termin->PPTermine_Bemerkungen;
            $oMAZustaendigkeit = $termin->PPTermine_MAZustaendigkeit;
            $oStatus = $termin->PPTermine_Status;
            $oLabel = $termin->PPTermine_Label;
            $iStart = $this->getSqlDate($jsonObject->{'Termine_Datum'});
            $iEnde = $this->getSqlDate($jsonObject->{'Termine_Datum_Ende'});
            //cpcDebug::cpc_debug("Start:" . $jsonObject->{'Termine_Datum'});
            //cpcDebug::cpc_debug("Ende:" . $jsonObject->{'Termine_Datum_Ende'});
            //cpcDebug::cpc_debug("iStart:" . $iStart);
            //cpcDebug::cpc_debug("iEnde:" . $iEnde);
            $termin->PPTermine_DatumStart = $iStart;
            $termin->PPTermine_DatumEnde = $iEnde;
            $termin->PPTermine_Bemerkungen = $this->change2Translated($jsonObject->{'Termine_Bemerkung'});
            $termin->PPTermine_MAZustaendigkeit = $jsonObject->{'Termine_Mitarbeiter'};
            $termin->PPTermine_Status = $jsonObject->{'Termine_Status'};
            $termin->PPTermine_Label = $this->change2Translated($jsonObject->{'Termine_Label'});
            $termin->save();
        } catch (exception $e) {
            //cpcDebug::cpc_debug("Exception raised:");
            //cpcDebug::cpc_debug("Message: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine());
        }
        if (isset($jsonObject->{'AWMOn'})) {
            $oAWMs = $jsonObject->{'AWMOn'};
            foreach ($oAWMs as $awm) {
                $awmCountry = explode("_", $awm)[2];
                $ppm = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $ppid)->where("PPProduktpass_Menge_Country", "=", $awmCountry)->first();
                $ppm->PPProduktpass_Menge_8WMuster = 1;
                $ppm->save();
            }
            $oAWMs = $jsonObject->{'AWMOff'};
            foreach ($oAWMs as $awm) {
                $awmCountry = explode("_", $awm)[2];
                $ppm = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $ppid)->where("PPProduktpass_Menge_Country", "=", $awmCountry)->first();
                $ppm->PPProduktpass_Menge_8WMuster = 0;
                $ppm->save();
            }
        }
        try {
            $statusChange['PPTermineChanges_Produktpass_Id'] = $ppid;
            $statusChange['PPTermineChanges_Date'] = date('Y-m-d H:i:s');
            $statusChange['PPTermineChanges_PPProduktpass_id'] = $jsonObject->{'StatusPPId'};
            $statusChange['PPTermineChanges_oldStatus'] = $jsonObject->{'StatusAlt'};
            $statusChange['PPTermineChanges_newStatus'] = $jsonObject->{'Termine_Status'};
            if (substr($jsonObject->{'StatusCategorie'}, 0, 5) == 'Bitte') {
                $statusChange['PPTermineChanges_Categorie'] = "";
            } else {
                $statusChange['PPTermineChanges_Categorie'] = $jsonObject->{'StatusCategorie'};
            }
            $statusChange['PPTermineChanges_Remark'] = $jsonObject->{'StatusRemark'};
            $statusChange['PPTermineChanges_PPTermine_Id'] = $jsonObject->{'Termine_Id'};
            $statusChange['PPTermineChanges_Mitarbeiter_Id'] = Auth::getUser()->id;
            $this->updateTermineLog($statusChange);
        } catch (exception $e) {
            //cpcDebug::cpc_debug("Message: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine());
        }
        try {
            $bchange = false;
            $change = "\n--- " . Auth::user()->PPMitarbeiter_Kuerzel . " - " . date('d.m.Y') . " ---";
            if ($oDatumStart != $termin->PPTermine_DatumStart) {
                $bchange = true;
                $change = $change . "\nTermin: " . date("d.m.Y", strtotime($oDatumStart)) . " -> " . date("d.m.Y", strtotime($termin->PPTermine_DatumStart));
            }
            if ($oDatumEnde != $termin->PPTermine_DatumEnde) {
                //$bchange = true; $change = $change . "\nEnde: ".date("d.m.Y", strtotime($oDatumEnde))." -> ". date("d.m.Y", strtotime($termin->PPTermine_DatumEnde));
            }
            if ($oBemerkungen != $termin->PPTermine_Bemerkungen) {
                $bchange = true;
                $change = $change . "\nBemerkungen: " . $oBemerkungen . " -> " . $termin->PPTermine_Bemerkungen;
            }
            if ($oMAZustaendigkeit != $termin->PPTermine_MAZustaendigkeit) {
                if (isset($oMAZustaendigkeit) && $oMAZustaendigkeit != 0) {
                    $mkuerzel1 = PPMitarbeiter::find($oMAZustaendigkeit)->PPMitarbeiter_Kuerzel;
                } else {
                    $mkuerzel1 = 'NN';
                }
                $mkuerzel2 = PPMitarbeiter::find($termin->PPTermine_MAZustaendigkeit)->PPMitarbeiter_Kuerzel;
                $bchange = true;
                $change = $change . "\nVerantwortlicher: " . $mkuerzel1 . " -> " . $mkuerzel2;
            }
            if ($oStatus != $termin->PPTermine_Status) {
                $bchange = true;
                $change = $change . "\nStatus: " . $oStatus . " -> " . $termin->PPTermine_Status;
            }
            if ($oLabel != $termin->PPTermine_Label) {
                $bchange = true;
                $change = $change . "\nAnzeigetext: " . $oLabel . " -> " . $termin->PPTermine_Label;
            }
            //$change = $change. "\n******************";
            if ($bchange) {
                $termin->PPTermine_History = $change . $termin->PPTermine_History;
                $termin->save();
            }
        } catch (exception $e) {
            //cpcDebug::cpc_debug("Exception raised:");
            //cpcDebug::cpc_debug("Message: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine());
        }
        return Response::json(array(
            'result' => 'OK', 'cont'   => 'Daten gesichert',
            'id'     => $jsonObject->{'Termine_Id'}
        ));
    }
    private function addHistory($tid, $old, $new)
    {
        $t = PPTermine::where('PPTermine_Id', $tid)->get()->first();
        if ($t) {
            $change = "\n--- " . Auth::user()->PPMitarbeiter_Kuerzel . " - " . date('d.m.Y') . " ---";
            $change .= "\nUnteraufgabe: $old => $new";
            $change .= $t->PPTermine_History;
            $t->PPTermine_History = $change;
            $t->save();
        }
    }
    public function deletePPChanges()
    {
        $id = Input::get('PPChanges_Id');
        //cpcDebug::cpc_debug("Changes delete $id");
        $ppc = PPTermineChanges::where("PPTermineChanges_Id", "=", $id)->orderBy('PPTermineChanges_Date', 'DESC')->get()->first();
        if ($ppc) {
            //cpcDebug::cpc_debug("Changes $id deleted!");
            $ppc->PPTermineChanges_IsActive = 0;
            $ppc->save();
        }
    }
    public function deletePPChangesReverse()
    {
        $id = Input::get('PPChanges_Id');
        //cpcDebug::cpc_debug("Changes deleteReverse $id");
        $ppc = PPTermineChanges::where("PPTermineChanges_Id", "=", $id)->orderBy('PPTermineChanges_Date', 'DESC')->get()->first();
        if ($ppc) {
            //cpcDebug::cpc_debug("Changes $id resotred!");
            $ppc->PPTermineChanges_IsActive = 1;
            $ppc->save();
        }
    }
    public function newTheme()
    {
        //cpcDebug::cpc_debug("Enter: newTheme");
        if (!Input::has('jsonObject')) {
            //cpcDebug::cpc_debug("No Json");
            $json = array('result' => 'Nicht OK', 'message' => 'Daten gesichert', 'id' => 0);
            return Response::json($json);
        }
        $jsonObject = json_decode(Input::get('jsonObject'));
        //cpcDebug::cpc_debug($jsonObject);
        $fileId = 0;
        if (Input::hasFile('file')) {
            $file = Input::file('file');
            $rem = $this->getMilestone($jsonObject->{'Theme_TId'}) . ": [" . $jsonObject->{'Theme_Categorie'} . "]\n" . $jsonObject->{'Theme_Remark'};
            $fileId = $this->uploadFilesTermineX($file, $jsonObject->{'Theme_PPId'}, $rem);
            //cpcDebug::cpc_debug("FileID: " . $fileId);
        }
        //cpcDebug::cpc_debug("Aufbau Array");
        $statusChange['PPTermineChanges_Date'] = date('Y-m-d H:i:s');
        $statusChange['PPTermineChanges_DoUntil'] = $this->getSqlDate($jsonObject->{'Theme_DoUntil'});
        $statusChange['PPTermineChanges_PPProduktpass_id'] = $jsonObject->{'Theme_PPId'};
        $statusChange['PPTermineChanges_Remark'] = $jsonObject->{'Theme_Remark'};
        $statusChange['PPTermineChanges_PPTermine_Id'] = $jsonObject->{'Theme_TId'};
        $statusChange['PPTermineChanges_Categorie'] = $jsonObject->{'Theme_Categorie'};
        $statusChange['PPTermineChanges_Receiver'] = $jsonObject->{'Theme_Bearbeiter'};
        $statusChange['PPTermineChanges_Mitarbeiter_Id'] = Auth::getUser()->id;
        $statusChange['PPTermineChanges_Reporter'] = Auth::getUser()->id;
        $statusChange['PPTermineChanges_PPPPFilesId'] = $fileId;
        //cpcDebug::cpc_debug("Save: newTheme");
        //cpcDebug::cpc_debug($statusChange);
        $this->insertNewTheme($statusChange);
        $termin = PPTermine::where('PPTermine_Id', $statusChange['PPTermineChanges_PPTermine_Id'])->get()->first();
        if ($termin) {
            if ($termin->PPTermine_Status == 'Neu') {
                $termin->PPTermine_Status = 'in Arbeit';
                $termin->save();
                $this->addHistory($termin->PPTermine_Id, 'Neu', 'in Arbeit');
            }
        }
        $json = array('result' => 'OK', 'message' => 'Daten gesichert', 'id' => $jsonObject->{'Theme_TId'}, 'func' => 'newTheme');
        //cpcDebug::cpc_debug($json);
        return Response::json($json);
    }
    private function getWeeksToCRD($ppid, $solld)
    {
        //cpcDebug::cpc_debug('getWeeksToCRD');
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            $LTorCRDWoche = $pp->PPProduktpass_Liefertermin;
            $LTorCRDJahr = $pp->PPProduktpass_LieferterminJahr;
            if ($pp->PPProduktpass_CRDJahr > 0) {
                $LTorCRDWoche = $pp->PPProduktpass_CRDWoche;
                $LTorCRDJahr = $pp->PPProduktpass_CRDJahr;
            }
            $dto = new DateTime();
            $dto->setISODate($LTorCRDJahr, $LTorCRDWoche);
            //Freitag der KW
            $dto->modify('+6 days');
            if ($pp->PPProduktpass_CRDJahr == 0) {
                $dto->modify('-10 weeks');
            }
            $dtoSoll = new dateTime(cpcHelp::Date2MySql($solld));
            $diff = $dto->diff($dtoSoll);
            $week_total = $diff->format('%a') / 7;
            return floor($week_total);
        } else {
            return 0;
        }
    }
    private function getPPValues($ppid, $attribute)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            if (isset($pp->{$attribute}) and $pp->{$attribute} !== null) {
                return $pp->{$attribute};
            }
        }
        return '';
    }
    private function getDateWeekFriday($jahr, $woche):DateTime {
        $d = new DateTime();
        try{
            $d->setISODate($jahr, $woche,5);
        } 
        catch (Exception $ex){
            $d->setISODate(2019,1,5);
        }
        return $d;
    }
    private function calcCRD ($ppid):DateTime {
        $pp = tPPProduktpass::find($ppid);
        $crd = $this->getDateWeekFriday(2019,1);
        if ($pp){
            if ($pp->PPProduktpass_CRDJahr > 0){
                $crd = $this->getDateWeekFriday($pp->PPProduktpass_CRDJahr, $pp->PPProduktpass_CRDWoche);
            } else {
                $crd = $this->getDateWeekFriday($pp->PPProduktpass_LieferterminJahr, $pp->PPProduktpass_Liefertermin);
            }
        }
        return $crd;
    }
    private function saveTranslationTermin($termin, $pAtt, $newText){
        $userLang = $this->getUserLanguage();
        if($userLang == 'DE'){
            $destLang = 'EN';
        } else {
            $destLang = 'DE';
        }
        cpcDebug::cpc_debug("saveTranslationTermin $pAtt  $newText  $userLang -> $destLang", "@Translate");
        $deepl = '[DeepL] ';
        $newText = str_replace($deepl,'', trim($newText));
        if (!$termin ){
            return;
        }
        if ($userLang == 'EN'){
            $att = $pAtt . "EN";
            $attTranslation = $pAtt;
        } else {
            $att = $pAtt ;
            $attTranslation = $pAtt . "EN";
        } 
        $oldText = str_replace($deepl, '', $termin->{$att});
        if ($oldText == $newText){
            cpcDebug::cpc_debug("No Translation $userLang to $destLang : newText  ==  oldText", "@Translate");
            return; 
        }
        $translatedText = $this->translateContent($newText, $userLang, $destLang);
        cpcDebug::cpc_debug("Translate from $userLang to $destLang : $newText  => $translatedText", "@Translate");
        if ($translatedText != ''){
            cpcDebug::cpc_debug("Save Translation Übersetzung => $attTranslation  Text =>  $att", "@Translate");
            $termin->{$attTranslation} = $deepl.$translatedText;
            $termin->{$att} = $newText;
            $termin->save();    
        }
    }
    private function saveTranslationTermineChanges($termineChanges, $pAtt, $newText){
        $userLang = $this->getUserLanguage();
        if($userLang == 'DE'){
            $destLang = 'EN';
        } else {
            $destLang = 'DE';
        }
        cpcDebug::cpc_debug("saveTranslationTermineChanges $pAtt  $newText  $userLang -> $destLang", "@Translate");
        $deepl = '[DeepL] ';
        $newText = str_replace($deepl,'', trim($newText));
        if (!$termineChanges){
            return;
        }
        if ($userLang == 'EN'){
            $att = $pAtt . "EN";
            $attTranslation = $pAtt;
        } else {
            $att = $pAtt ;
            $attTranslation = $pAtt . "EN";
        } 
        $oldText = str_replace($deepl, '', $termineChanges->{$att});
        if ($oldText == $newText){
            cpcDebug::cpc_debug("No Translation $userLang to $destLang : newText  ==  oldText", "@Translate");
            return; 
        }
        $translatedText = $this->translateContent($newText, $userLang, $destLang);
        cpcDebug::cpc_debug("Translate from $userLang to $destLang : $newText  => $translatedText", "@Translate");
        if ($translatedText != ''){
            cpcDebug::cpc_debug("Save Translation Übersetzung => $attTranslation  Text =>  $att", "@Translate");
            $termineChanges->{$attTranslation} = $deepl.$translatedText;
            $termineChanges->{$att} = $newText;
            $termineChanges->save();    
        }
    }
    public function updatejsonMusterung()
    {
        //cpcDebug::cpc_debug("Start updatejsonMusterung");
        //cpcDebug::cpc_debug($_FILES);
        cpcDebug::cpc_debug("Enter updatejsonMusterung", "@History");
        try {
            $jsonObject = json_decode($_POST['jsonObject']);
            //$file = $_FILES['file'];
            $id = $jsonObject->{'Termine_Id'};
            $termin = PPTermine::find($id);
            $ppid = $termin->PPTermine_PPProduktpass_Id;
            $oMAZustaendigkeit = $termin->PPTermine_MAZustaendigkeit;
            $oStatus = $termin->PPTermine_Status;
            $oLabel = $termin->PPTermine_Label;
            $oBemerkungen = $termin->PPTermine_Bemerkungen;
            $lang=$this->getUserLanguage();
            if ($lang =='EN'){
                $oLabel = $termin->PPTermine_LabelEN;
                $oBemerkungen = $termin->PPTermine_BemerkungenEN;
            }   
            //$oManSoll = $termin->PPTermine_ManSoll;
            $nStatus = $jsonObject->{'Termine_Status'};
            //$nManSoll = $jsonObject->{'Termine_ManSoll'};
            $oDatumStart = $termin->PPTermine_DatumStart;
            $oDatumEnde = date("Y-m-d", strtotime($termin->PPTermine_DatumEnde));
            $iStart = $this->getSqlDate($jsonObject->{'Termine_Datum'});
            $iEnde = $this->getSqlDate($jsonObject->{'Termine_Datum_Ende'});
            $termin->PPTermine_DatumStart = $iStart;
            $stat = PPStati::where('PPStati_Status', '=', $nStatus)->get()->first();
            if ($stat) {
                if ($stat->PPStati_OKStatus == 1) {
                    if (strpos($iEnde, '0000') !== false) {
                        $iEnde = date('Y-m-d');
                    }
                } else {
                    $iEnde = '0000-00-00';
                }
            }
            $cw2crd = null;
            $oManSollDate = $termin->PPTermine_ManSollDate;
            if ($jsonObject->{'Termine_ManSollD'} and strlen($jsonObject->{'Termine_ManSollD'}) == 10) {
                //$cw2crd = $this->getWeeksToCRD($ppid, $jsonObject->{'Termine_ManSollD'});
                $termin->PPTermine_ManSollDate = $this->_dateLocal2MySql($jsonObject->{'Termine_ManSollD'});
            }
            $termin->PPTermine_DatumEnde = $iEnde;
            //$termin->PPTermine_ManSoll = $cw2crd;
            $termin->PPTermine_Status = $nStatus;
            $this->saveTranslationTermin( $termin,  'PPTermine_Label',  $jsonObject->{'Termine_Label'});
            $this->saveTranslationTermin( $termin,  'PPTermine_Bemerkungen',  $jsonObject->{'Termine_Bemerkung'});
            //$termin->PPTermine_Bemerkungen =  $jsonObject->{'Termine_Bemerkung'};
            $nMAZustaendigkeit = $jsonObject->{'Termine_Mitarbeiter'};
            $termin->PPTermine_MAZustaendigkeit = $nMAZustaendigkeit;
            if ($iStart != $oDatumStart) {
                cpcDebug::cpc_debug("Termin Datum Start geändert von $oDatumStart zu $iStart", "@updateTermine");
                $this->changeStatusMasterplan($ppid);
                $termin->PPTermine_IsMPlan = 0;
            }
            $termin->save();
            //cpcDebug::cpc_debug("Termin saved! OK. $nMAZustaendigkeit  " . Auth::getUser()->PPMitarbeiter_Id);
            if (Auth::getUser()->PPMitarbeiter_Id != $nMAZustaendigkeit) {
                if ($oMAZustaendigkeit != $nMAZustaendigkeit) {
                    $this->systemMailTermine('TCHANGE', $id, $nMAZustaendigkeit);
                    //cpcDebug::cpc_debug("Mail Zuständigkeit geändert: $oMAZustaendigkeit ----- $nMAZustaendigkeit ");
                }
                //cpcDebug::cpc_debug("Keine Mail aber Änderungen");
            } else {
                //cpcDebug::cpc_debug("Keine Mail weil MA selber geändert hat Änderungen");
            }
        } catch (exception $e) {
            //cpcDebug::cpc_debug("Exception raised:");
            cpcDebug::cpc_debug("Message: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine(), "@History");
        }
        $fileId = 0;
        /* if (Input::hasFile('file')){
        $file = Input::file('file');
        $fileId = $this->uploadFilesTermineX($file, $ppid);
        } */
        // //cpcDebug::cpc_debug("Save Changes TARGA:");
        // //cpcDebug::cpc_debug($oDatumStart);
        cpcDebug::cpc_debug("Prepare Save Changes TARGA:", "@History");
        try {
            $save = true;
            $save = $save || ($oDatumStart != $iStart);
            $save = $save || ($oDatumEnde != $termin->PPTermine_DatumEnde);
            $save = $save || ($oMAZustaendigkeit != $termin->PPTermine_MAZustaendigkeit);
            $save = $save || ($oStatus != $termin->PPTermine_Status);
            $save = $save || (substr($oManSollDate,0,10) !=  substr($termin->PPTermine_ManSollDate,0,10));
            //$save = $save || ($oManSoll != $termin->PPTermine_ManSoll);
            $statusChange['PPTermineChanges_PPProduktpass_Id'] = $ppid;
            $statusChange['PPTermineChanges_oldStatus'] = $oStatus;
            $statusChange['PPTermineChanges_Date'] = date('Y-m-d H:i:s');
            $statusChange['PPTermineChanges_DoUntil'] = $iStart;
            $statusChange['PPTermineChanges_DoUntilOld'] = $oDatumStart;
            $statusChange['PPTermineChanges_newStatus'] = $jsonObject->{'Termine_Status'};
            //$statusChange['PPTermineChanges_PPProduktpass_id'] = $jsonObject->{'StatusPPId'};
            $statusChange['PPTermineChanges_Categorie'] = $jsonObject->{'StatChange_Categorie'};
            $statusChange['PPTermineChanges_Remark'] = $jsonObject->{'StatusRemark'};
            $statusChange['PPTermineChanges_PPTermine_Id'] = $jsonObject->{'Termine_Id'};
            $statusChange['PPTermineChanges_Receiver'] = $jsonObject->{'Termine_Mitarbeiter'};
            $statusChange['PPTermineChanges_Reporter'] = Auth::getUser()->id;
            $statusChange['PPTermineChanges_Mitarbeiter_Id_Old'] = $termin->PPTermine_MAZustaendigkeit;
            $statusChange['PPTermineChanges_Mitarbeiter_Id'] = $oMAZustaendigkeit;
            $statusChange['PPTermineChanges_PPPPFilesId'] = $fileId;
            if ($save) {
                cpcDebug::cpc_debug("Save: statusChange TARGA", "@History");
                $this->updateTermineLog($statusChange);
            }
        } catch (Exception $e) {
            cpcDebug::cpc_debug("Message: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine(), "@History");
        }
        cpcDebug::cpc_debug("Prepare Save Changes History:", "@History");
        try {
            $labels = array (
                'Leer' => array('DE' => 'leer', 'EN' => 'empty'),
                'Anzeigetext' => array('DE' => 'Anzeigetext', 'EN' => 'Displaytext'),
                'Bemerkungen' => array('DE' => 'Bemerkungen', 'EN' => 'Remark'),
                'Verantwortlicher' => array('DE' => 'Verantwortlicher', 'EN' => 'Responsible'),
                'Status' => array('DE' => 'Status', 'EN' => 'Status'),
                'Manuell soll' => array('DE'    => 'Manuell SOLL', 'EN' => 'Manual TARGET'),
                'Termin' => array('DE' => 'Termin', 'EN' => 'Date')  
            );  
            cpcDebug::cpc_debug("Check History Change detected", "@History");
            $bchange = false;
            $change = "\n\n---" . Auth::user()->PPMitarbeiter_Kuerzel . " - " . date('d.m.Y') . " ---";
            if ($oDatumStart != $termin->PPTermine_DatumStart) {
                $strDateStart = date("d.m.Y", strtotime($oDatumStart));
                if ($oDatumStart == '0000-00-00 00:00:00') {
                    $strDateStart = $labels['Leer'][$lang];
                }
                $striStart = date("d.m.Y", strtotime($termin->PPTermine_DatumStart));
                if ($termin->PPTermine_DatumStart == '0000-00-00') {
                    $striStart = $labels['Leer'][$lang];;
                }
                if ($strDateStart != $striStart) {
                    //date("d.m.Y", strtotime($termin->PPTermine_DatumStart))
                    $bchange = true;
                    $change = $change . "\n" . $labels['Termin'][$lang] .  ": " . $strDateStart . " -> " . $striStart;
                }
            }
            if ($oDatumEnde != $termin->PPTermine_DatumEnde) {
                //$bchange = true; $change = $change . "\nEnde: ".date("d.m.Y", strtotime($oDatumEnde))." -> ". date("d.m.Y", strtotime($termin->PPTermine_DatumEnde));
            }
            if ($lang == 'DE'){
                if ($oBemerkungen != $termin->PPTermine_Bemerkungen) {
                    $bchange = true;
                    $change = $change . "\n" . $labels['Bemerkungen']['DE'] . ": " . $oBemerkungen . " -> " . $termin->PPTermine_Bemerkungen;
                }
                if ($oLabel != $termin->PPTermine_Label) {
                    $bchange = true;
                    $change = $change . "\n" . $labels['Anzeigetext'][$lang] . ": " . $oLabel . " -> " . $termin->PPTermine_Label;
                }
            }
            if ($lang == 'EN'){
                if ($oBemerkungen != $termin->PPTermine_BemerkungenEN) {
                    $bchange = true;
                    $change = $change . "\n"  .$labels['Bemerkungen'][$lang]. ": " . $oBemerkungen . " -> " . $termin->PPTermine_BemerkungenEN;
                }
                if ($oLabel != $termin->PPTermine_LabelEN) {
                    $bchange = true;
                    $change = $change . "\n"  . $labels['Bemerkungen'][$lang] .  ": " . $oLabel . " -> " . $termin->PPTermine_LabelEN;
                }
            }
            if ($oMAZustaendigkeit != $termin->PPTermine_MAZustaendigkeit) {
                if (isset($oMAZustaendigkeit) && $oMAZustaendigkeit != 0) {
                    $mkuerzel1 = PPMitarbeiter::find($oMAZustaendigkeit)->PPMitarbeiter_Kuerzel;
                } else {
                    $mkuerzel1 = 'NN';
                }
                $mkuerzel2 = PPMitarbeiter::find($termin->PPTermine_MAZustaendigkeit)->PPMitarbeiter_Kuerzel;
                $bchange = true;
                $change = $change . "\n"  . $labels['Verantwortlicher'][$lang]  .  ": " . $mkuerzel1 . " -> " . $mkuerzel2;
            }
            if ($oStatus != $termin->PPTermine_Status) {
                $bchange = true;
                $change = $change . "\n"  . $labels['Status'][$lang]   .     ": " . $oStatus . " -> " . $termin->PPTermine_Status;
            }
            if (substr($oManSollDate,0,10) != substr($termin->PPTermine_ManSollDate,0,10)) {
                $bchange = true;
                $change = $change . "\n" . $labels['Manuell soll'][$lang] .  ": " . substr($oManSollDate,0,10) . " -> " . substr($termin->PPTermine_ManSollDate,0,10);
            }
            //$change = $change. "\n******************";
            if ($bchange) {
                if ($this->getUserLanguage() == 'DE'){
                    cpcDebug::cpc_debug("History Change detected DE ".$change, "@History");
                    $termin->PPTermine_History = $change . $termin->PPTermine_History;
                    //$termin->PPTermine_HistoryEN = $this->translateHistory($termin);
                    $termin->PPTermine_HistoryEN =  $this->translateContent($change, 'DE', 'EN') .  $termin->PPTermine_HistoryEN;
                }
                if ($this->getUserLanguage() == 'EN'){
                    cpcDebug::cpc_debug("History Change detected EN ".$change, "@History");
                    $termin->PPTermine_HistoryEN = $change . $termin->PPTermine_HistoryEN;
                    $termin->PPTermine_History =  $this->translateContent($change, 'EN', 'DE') .  $termin->PPTermine_History;
                } 
                $termin->save();
            } else {
                cpcDebug::cpc_debug("No History Change detected", "@History");
            }
        } catch (exception $e) {
            //cpcDebug::cpc_debug("Exception raised:");
            //cpcDebug::cpc_debug("Message Save: " . $e->getMessage() . "  Code: " . $e->getCode() . "    Line:" . $e->getLine());
        }
        //cpcDebug::cpc_debug("Leave Function updatejsonMusterung.");
        return Response::json(array('result' => 'OK', 'message' => 'Daten gesichert'));
    }
    /**
     * Remove the specified resource from storage.
     * DELETE /projects/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    public function testAjax()
    {
        return Response::json(array('message' => "OK", "wasanders" => 'aucj O.K'));
    }
    public function getDistinctSearchValues($art = 'PP')
    {
        //echo($art);exit;
        if ($art == "PP") {
            //$internerStatusArray = array('FIX', 'ABSAGE', 'GELIEFERT');
            $internerStatusArray = array('FIX');
        }
        if ($art == "MU") {
            //$internerStatusArray = array('PLAN', 'MUSTERUNG', 'ABSAGE');
            $internerStatusArray = array('PLAN', 'MUSTERUNG');
        }
        $pps = DB::table('v_IANReal')->whereIn('InternerStatus', $internerStatusArray)->orderBy('PPProduktpass_IAN')->get();
        $ret['PPs'] = null;
        if ($pps) {
            $ret['PPs'] = $pps;
        }
        //if($art == 'PP'){
        $ausm = DB::table('v_IANReal')->select(DB::raw('distinct(PPProduktpass_Ausmusterungnummer)'))->orderBy('PPProduktpass_Ausmusterungnummer', 'desc')->get();
        //}
        $ret['AUSM'] = null;
        if ($ausm) {
            $ret['AUSM'] = $ausm;
        }
        $terminarten = DB::table('PPBoardSpalteData')->select(DB::raw('distinct(PPBoardSpalte_Bezeichnung)'))->where('PPBoardSpalte_Id', '>', 999)->orderBy('PPBoardSpalte_Bezeichnung')->get();
        $ret['tas'] = null;
        if ($terminarten) {
            $ret['tas'] = $terminarten;
        }
        return $ret;
    }
    public function getTerminFromId($ppid, $tid, $board = 10, $select = "All", $onlyOpen = 1)
    {
        $data = array();
        //echo(" $ppid $tid $board <br>");exit;
        if ($board == 2000) {
            $board = 1000;
        }
        $x = $this->getSchedulePopUp($board, $ppid, $tid);
        //echo ('Hallo<br><pre>');
        //print_r($x);
        //exit;
        $x['select'] = $select;
        $x['onlyOpen'] = $onlyOpen;
        if (false) {
            cpcDebug::cpc_debug("getTerminefromId: $ppid  TId: $tid Ver II",'@PopUp');
            cpcDebug::cpc_debug("getTerminefromId: " . Auth::getUser()->PPMitarbeiter_Kuerzel,'@PopUp');
            return View::make('termine.inc_terminePopUp_II')->with("Daten", $x);
        }
        cpcDebug::cpc_debug("getTerminefromId: $ppid  TId: $tid Ver I",'@PopUp');
        cpcDebug::cpc_debug("getTerminefromId: " . Auth::getUser()->PPMitarbeiter_Kuerzel,'@PopUp');
        return View::make('termine.inc_terminePopUp')->with("Daten", $x);
    }
    public function DEVgetTerminFromId($ppid, $tid, $board = 10, $select = "All", $onlyOpen = 1)
    {
        $data = array();
        //echo(" $ppid $tid $board <br>");exit;
        //cpcDebug::cpc_debug("PPId: $ppid  TId: $tid");
        if ($board == 2000) {
            $board = 1000;
        }
        $x = $this->getSchedulePopUp($board, $ppid, $tid);
        //echo ('Hallo<br><pre>');
        //print_r($x);
        //exit;
        $x['select'] = $select;
        $x['onlyOpen'] = $onlyOpen;
        return View::make('termine.inc_terminePopUpDEV')->with("Daten", $x);
    }
    public function ajax_getTermin()
    {
        //cpcDebug::cpc_debug($_POST, "AJAX");
        $ppid = $_POST['ppid'];
        $tid = $_POST['tid'];
        return Response::json(array("Result" => "OK", "ppid" => $ppid, "tid" => $tid));
    }
    private function getMitarbeiterProjekt($ppid, $board = 1000)
    {
        $ma_array = array();
        return $ma_array;
        $mPs = DB::table('v_MitarbeiterProjekt')->where('PPBoardSpalte_PPBoard_Id', '=', $board)->where('PPTermine_PPProduktpass_Id', '=', $ppid)->get();
        $ma_array = array();
        $i = 0;
        if ($mPs) {
            foreach ($mPs as $mp) {
                $art = $mp->PPMitarbeiter_Taetigkeit;
                if (is_null($art) || strlen($art) < 1) {
                    $art = 'N.N.';
                }
                if (isset($ma_array[$art])) {
                    $ma_array[$art] .= ", " . $mp->PPMitarbeiter_Kuerzel;
                } else {
                    $ma_array[$art] = $mp->PPMitarbeiter_Kuerzel;
                }
            }
        }
        //var_dump($ma_array);
        return ($ma_array);
    }
    public function saveFilter()
    {
        $input = Input::all();
        $qryFilter = $input['qryFilter'];
        $board = $input['board'];
        $userid = Auth::getUser()->PPMitarbeiter_Id;
        cpcDebug::cpc_debug($qryFilter, "@saveFilter");
        try {   
            $usersettings = PPUserSettings::where('PPUserSettings_Setting','like', "DashboardFilter$board")->where('PPUserSettings_Userid', $userid)->get()->first();
            if ($usersettings) { 
                $usersettings->delete();
            }
        } catch (Exception $ex) {
            //cpcDebug::cpc_debug($ex, "saveFilter");
        }
        $usersettings = new PPUserSettings();
        $usersettings->PPUserSettings_UserId = $userid;
        $usersettings->PPUserSettings_Type = 0;
        $usersettings->PPUserSettings_Setting = "DashboardFilter$board";
        $usersettings->PPUserSettings_Value = $qryFilter;
        $usersettings->save();
        //cpcDebug::cpc_debug(print_r($qryFilter, true), "saveFilter");
        return $qryFilter;
    }
    public function getFilter()
    {
        $userid = Auth::getUser()->id;
        $board=Input::get('board');
        $usersettings = PPUserSettings::where('PPUserSettings_Setting', "DashboardFilter$board")->where('PPUserSettings_UserId', $userid)->get()->first();
        if (!$usersettings) {
            return '';
        }
        //cpcDebug::cpc_debug($usersettings->PPUserSettings_Value, "getFilter");
        return $usersettings->PPUserSettings_Value;
    }
    public function updateTermineMusterung($ausm)
    {
        $pps = tPPProduktpass::where('PPProduktpass_Ausmusterungnummer', 'like', $ausm)->where('InternerStatus', 'MUSTERUNG')->where('PPProduktpass_IAN', 'not like', '%Rev%')->get();
        $ppids = array();
        if ($pps) {
            foreach ($pps as $pp) {
                $ppids[] = $pp->PPProduktpass_Id;
            }
        }
        $termineMusterung = PPTermineMusterung::where('PPTermineMusterung_Ausmusterung', $ausm)->get();
        $termineIds = array();
        if ($termineMusterung) {
            foreach ($termineMusterung as $terminMusterung) {
                $termineIds[$terminMusterung->PPTermineMusterung_PPBoardSpalte_Id] = $terminMusterung->PPTermineMusterung_DateTime;
            }
        }
        foreach ($ppids as $ppid) {
            echo ("<br>$ppid <br>");
            $ts = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
            if ($ts) {
                $i = 0;
                foreach ($ts as $t) {
                    if (isset($termineIds[$t->PPTermine_PPBoardSpalte_id])) {
                        $i++;
                        echo ("<br> $i .) " . $t->PPTermine_PPProduktpass_Id . " [" . $t->PPTermine_Id . "]" . " -> " . $t->PPTermine_DatumStart . " Neu => " . $termineIds[$t->PPTermine_PPBoardSpalte_id]);
                        //$t->PPTermine_DatumStart = $termineIds[$t->PPTermine_PPBoardSpalte_id];
                        //$t->save();
                    }
                }
            }
        }
        //echo("<br>----------------------------------------<br><pre>");
        //print_r($termineIds);
        exit;
    }
    private function getCRDChanged($ppid){
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp){  
            	if ($pp->PPProduktpass_CRDJahr == 0){
                    return false;
                }
        }
        $prot = PPProtokoll::where('PPProtokoll_Feld','like','%CRD%')->where('PPProtokoll_PPProduktpass_Id', $ppid)->where('PPProtokoll_isActive', 1)->exists();
        if ($prot){
            return true;
        }
        return false;
    }
    public function dbIANdirect ($p){
        //cpcDebug::pe($ian,1);
        $ex = explode('_',$p);
        $ian = $ex[0];
        $ausm = $ex[1];
        $search['PPProduktpass_IAN'] = $ian;
        $pp = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer', 'like', $ausm.'%' )->get()->first();
        if ($pp){
        $status = strtoupper($pp->InternerStatus);
        switch ($status) {
            case 'FIX':
                $board = 1000;# code...
                break;
            case 'MUSTERUNG':
                $board = 1001;# code...
                break;                
            case 'PLAN':
                $board = 1001;# code...
                break;                
            case 'GELIEFERT':
                $board = 2000;# code...
                break;                
            case 'ABSAGE':
                $board = 2002;# code...
                break;                
            default: 
                # code...
                $board = 1001;
                break;
        }
        $search['PPProduktpass_Ausmusterungnummer'] = $ausm;
        return $this->showlistNeu('projekt', 'U', $board, 0, $search);}
    }
    private function setMATermineStatusChange($ppid, $pm, $tc)
    {
        //cpcDebug::cpc_debug("setMATermineStatusChange ( $ppid, $pm, $tc ) ",'!123');
        $termine = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_Status', 'Neu')->get();
        if ($termine){
            //cpcDebug::cpc_debug("setMATermineStatusChange Termine OK ",'!123');
            $spalten = $this->getTerminArten();
            //cpcDebug::cpc_debug($spalten,'!123');
            foreach ($termine as $termin) {
                //cpcDebug::cpc_debug("Termin Id: ". $termin->PPTermine_Id. "  Spalte: ".$termin->PPTermine_PPBoardSpalte_id,'!123');
                if (isset($spalten[$termin->PPTermine_PPBoardSpalte_id])){
                    if ($spalten[$termin->PPTermine_PPBoardSpalte_id] == 'PM'){
                        $termin->PPTermine_MAZustaendigkeit = $pm;
                    }
                    if ($spalten[$termin->PPTermine_PPBoardSpalte_id] == 'TC'){
                        $termin->PPTermine_MAZustaendigkeit = $tc;
                    }
                } else {
                    //cpcDebug::cpc_debug("Keine Spalte ".$termin->PPTermine_PPBoardSpalte_id,'!123');
                }
                $termin->save();
            }
        }
        return 1;
    }
    private function getTerminArten(){
        $bss = PPBoardSpalteData::where('PPBoardSpalte_Id','>=', 1000 )->get();
        $spalten = array();
        foreach($bss as $bs){
            if (strlen($bs->PPBoardSpalteData_Kind) >= 2){
                $spalten[$bs->PPBoardSpalte_Id] = substr($bs->PPBoardSpalteData_Kind,0,2);
            } else {
                $spalten[$bs->PPBoardSpalte_Id] = '';
            }
        }
        return $spalten;
    }
    private function getSchedulePopUp_IANAUSM ($board, $ian_ausm, $tid){
        $x = null;
        $ex = explode('_', $ian_ausm);
        $ian = $ex[0];
        $ausm = $ex[1];
        $pp = tPPProduktpass::where ('PPProduktpass_IAN', $ian)->where ('PPProduktpass_Ausmusterungnummer', 'like', $ausm.'%')->get()->first();
        if ($pp){
            $x = $this->getSchedulePopUp($board, $pp->PPProduktpass_Id, $tid);
        }
        return $x;
    }
    public function getTerminFromIAN_AUSM($ian_ausm, $tid=-1, $board = 1000, $select = "All", $onlyOpen = 1){
        $data = array();
        //echo(" $ian_ausm $tid $board <br>");exit;
        //cpcDebug::cpc_debug("PPId: $ppid  TId: $tid");
        if ($board == 2000) {
            $board = 1000;
        }
        $x = $this->getSchedulePopUp_IANAUSM($board, $ian_ausm, $tid);
        if (is_null($x)){
            $message['Message'] = 'Die IAN wurde nicht gefunden!';
            $message['BackLink'] = "https://" . $_SERVER['SERVER_NAME'] . "/termine/projekt/U/1000/1";
            return View::make('message')->with('Message', $message);
        }
        //echo ('Hallo<br><pre>');
        //print_r($x);
        //exit;
        $x['select'] = $select;
        $x['onlyOpen'] = $onlyOpen;
         if (Auth::getUser()->PPMitarbeiter_Kuerzel == 'FKE' or strpos(Auth::getUser()->PPMitarbeiter_Kuerzel, 'admin') !== false) {
            return View::make('termine.inc_terminePopUp_II')->with("Daten", $x);
        }
        return View::make('termine.inc_terminePopUp')->with("Daten", $x);
    }
    private function freeMilestones ($ppid){
        //cpcDebug::cpc_debug("freeMilestones ".$ppid,'!1234');
        $milestones = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
        if ($milestones){
            foreach($milestones as $m){
                if (strpos($m->PPTermine_Status,'FREEZE_IA') !== false){
                    $m->PPTermine_Status = 'in Arbeit';
                    $m->PPTermine_DatumEnde = '0000-00-00 00:00:00';
                    $m->save();
                }
                if (strpos($m->PPTermine_Status,'FREEZE') !== false){
                    $m->PPTermine_Status = 'Neu';
                    $m->PPTermine_DatumEnde = '0000-00-00 00:00:00';
                    $m->save();    
                }
            }
        }
    }
    private function freezeMilestones ($ppid){
        //cpcDebug::cpc_debug("freezeMilestones ".$ppid,'1234');
        $stati  = $this->getStatiColors();
        $milestones = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
        if ($milestones){
            foreach($milestones as $m){
                $newStatus = $m->PPTermine_Status;
                if ($m->PPTermine_DatumEnde == '0000-00-00 00:00:00'){
                    $m->PPTermine_DatumEnde = date('Y-m-d H:i:s');
                    if (isset($stati[$m->PPTermine_Status]['isOKStatus']) and $stati[$m->PPTermine_Status]['isOKStatus'] == 0){
                        $newStatus = 'FREEZE';
                        if (strpos($m->PPTermine_Status,'in Arbeit') !== false){
                            $newStatus = 'FREEZE_IA';
                        }
                        $m->PPTermine_History .= ' Status: '.$m->PPTermine_Status. " => $newStatus "; 
                        $m->PPTermine_Status = $newStatus;
                    } 
                    $m->save();
                }
            }
        }
    }
    private function getDashboardValue($termin){
        //print_r ($termin);
        //exit;
        //Berechnung CRD
        $xArt = 'UNDEF'; 
        $CRDDate = new DateTimeImmutable(); 
        if ($termin->PPProduktpass_CRDJahr != '0'){
            $w =  $termin->PPProduktpass_CRDWoche;
            $y = $termin->PPProduktpass_CRDJahr;
            $CRDDate = $CRDDate->setISODate($y, $w, 6);
        } else {
            $w = $termin->PPProduktpass_Liefertermin;
            $y = $termin->PPProduktpass_LieferterminJahr;
            $CRDDate = $CRDDate->setISODate($y, $w, 6);
            $CRDDate =  $CRDDate->sub(new DateInterval('P9W'));
        }
        //Berechnug SollDate
        if ($termin->PPTermine_DatumStart != '0000-00-00 00:00:00'){
            //INdividuels Erl. Bis gesetzt.
            $sollDate = new DateTimeImmutable($termin->PPTermine_DatumStart); 
            $sollDate = $sollDate->modify("friday this week");
            $xArt = 'Startdatum'; 
        } else {
            if ($termin->PPTermine_ManSoll != 0){
                // man Soll
                $xArt = 'man. SOll';
                $sollWeeks = $termin->PPTermine_ManSoll;
            } else {
                //Berechnung nach Board Stammdaten
                $sollWeeks = $termin->PPBoardSpalte_Rot;
                $xArt = 'MS Stamm';
                if ($termin->PPBoardSpalte_Rot != 0){
                    $sollWeeks = $termin->PPBoardSpalte_Rot + 10;
                }
            }
            $sollDate = clone $CRDDate;
            if ($sollWeeks < 0){
                $sollWeeks *= -1;
                $sollDate = $sollDate->sub(new DateInterval('P'.$sollWeeks.'W'));
            } else {
                $sollDate = $sollDate->add(new DateInterval('P'.$sollWeeks.'W'));
            }
        }
        if ($termin->PPTermine_DatumEnde != '0000-00-00 00:00:00'){
            $readyDate = new DateTimeImmutable($termin->PPTermine_DatumEnde); 
        }
        //Berechnung Differenz
        // Diff wenn erledigt
        if ($termin->PPTermine_DatumEnde != '0000-00-00 00:00:00'){
            $xArt = 'Fertig';
            $dateEnd = new DateTimeImmutable($termin->PPTermine_DatumEnde);
        } else {
            $dateEnd = new DateTimeImmutable(date('Y-m-d H:i:s'));
        }
        $interval = $dateEnd->diff($sollDate);
        $weeksDiff = $interval->format('%r%a')/7;
        $diff =  floor($weeksDiff) ;
        return array('CRDDate' => $CRDDate->format('d.m.Y'), 'W2CRD' => $diff, 'SollDate' => $sollDate->format('d.m.Y'), 'Art' => $xArt);
/*        PPProduktpass_Liefertermin
        PPProduktpass_LieferterminJahr
        PPProduktpass_CRDWoche
        PPProduktpass_CRDJahr
        PPTermine_ManSoll
        PPBoardSpalte_Rot
        heute
        PPTermine_Status
        PPTermine_DatumEnde
*/
        //return array('PPTermine_Id' => $termin->PPTermine_Id);
    }
    private function getScopes (){
        $scopes = PPListBoxes::where('PPListBoxes_Type', 'ThemnplanungType')->get();
        $ret = false;
        if ($scopes){
            $ret = array();
            foreach ( $scopes as $scope) {
                $ret[$scope->PPListBoxes_Ident] = $scope->PPListBoxes_Value;
            }
        }
        return $ret;
    }
    private function change2Translated ($text){
        $lang = $this->getUserLanguage();
        if ($lang != 'DE'){
            $text = "[ORG $lang] ".$text;
        } 
        return $text;
    }
    private function getUserLanguage(){
        if (isset($_COOKIE['TPTLanguage'])){
            $lang = $_COOKIE['TPTLanguage'];
        } else {
            $lang =  Auth::user()->PPMitarbeiter_Language; 
        }  
        return $lang;
    }
    private function translateContent($text, $sourceLang, $targetLang)
    {
        if ($text == null or (trim($text) == '')) {
            $text = '-';
        }
        $api_Key = '10ee3599-028f-961f-ca7e-8c941bfaac5a';
        $deeplURL = "https://api.deepl.com/v2/translate";
        $lang = $targetLang;
        $vars = http_build_query([
            // wenn du lieber Header-Auth nutzt, lässt du 'auth_key' weg – Header unten bleibt.
            'text'        => $text,
            'source_lang' => $sourceLang,
            'target_lang' => $targetLang,
        ]);
        //mb_convert_encoding($text, 'UTF8');
        //$vars = array("text" => $text, "target_lang" => $lang);
        $ch = curl_init();
        $proxy = 'http://10.254.0.1';
        $proxy_port = 8080;
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
        curl_setopt($ch, CURLOPT_URL, $deeplURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars); //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $headers = array('Authorization: DeepL-Auth-Key ' . $api_Key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $translation = curl_exec($ch);
        $info = curl_getinfo($ch);
        cpcDebug::cpc_debug($info, '@translateDeepl');
        cpcDebug::cpc_debug($translation, '@translateDeepl');
        curl_close($ch);
        $trans = json_decode($translation, true);
        try {
            $ret = $trans['translations'][0]['text'];
        } catch (Exception $e) {
            //echo("Fehler beim übersetzen: $ptext <br>");
            //print_r($vars);
            $ret = "Not Translated [Qutoa?]:" . $text;
            //exit;
        }
        return $ret;
    }
    private function translateHistory($t){
        cpcDebug::cpc_debug("Translate History for Termin Id: ".$t->PPTermine_Id,'@translateHistory');
        if (is_null($t->PPTermine_HistoryEN) or (trim($t->PPTermine_HistoryEN) == '')){
            $text = $this->translateContent($t->PPTermine_History, 'DE', 'EN') ;
            cpcDebug::cpc_debug('Leer: '.$text,'@translateHistory');
            return ($text);            
        }
        cpcDebug::cpc_debug('Ohne Änderung '.$t->PPTermine_HistoryEN,'@translateHistory');
        return $t->PPTermine_HistoryEN;   
    }
    private function changeStatusMasterplan($ppid, $newStatus = -1){
        $masterplan = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($masterplan){
            $masterplan->PPProduktpass_SimNeu = $newStatus;
            $masterplan->save();
            cpcDebug::cpc_debug("Masterplan Status changed to $newStatus for PPId: $ppid",'@Masterplan');
        } else {
            cpcDebug::cpc_debug("No Masterplan found for PPId: $ppid",'@Masterplan');
        }
    }
}