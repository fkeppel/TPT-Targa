<?php
use Illuminate\Support\Facades\View;
class IANController extends \BaseController {
    var $init = 0;
    var $ppid;
    var $lang;
    var $pc;
    public function __construct() {
        //
        $this->init = 1;
        $this->ppid = 0;
        if (! isset($_COOKIE['TPTLanguage'])){
            $_COOKIE['TPTLanguage'] =  Auth::user()->PPMitarbeiter_Language; //'DE';
        } 
        $this->lang = $_COOKIE['TPTLanguage'];     
        $this->pc = new ProjectsController();
    }
    public function aGetPP ($ian, $charge, $lang){
        $this->ppid = $this->getPPId($ian, $charge );
        //$this->lang = $lang;
        $style = $this->getStyle($this->ppid);
        $kllink = $this->pc->getKLLinkedItems($this->ppid);
        $pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $this->ppid);
        if (strpos(Auth::user()->PPMitarbeiter_Role,'INTERN') === false ){
           return View::make('ian.indexLidl_extern.blade')->with('data', array('style' => $style,'lang' => $this->lang, 'name' => 'Frank', 'pp' => $pp, 'KLLink' => $kllink ));
        }
        return View::make('ian.indexLidl')->with('data', array('style' => $style,'lang' => $this->lang, 'name' => 'Frank', 'pp' => $pp, 'KLLink' => $kllink ));
    }
    public function aGetPPId ($ppid, $lang){
        $this->ppid = $ppid;
        //$this->lang = $lang;
        $pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $this->ppid);
        return View::make('ian.index')->with('data', array('lang' => $this->lang,  'pp' => $pp, 'deepLink' => 'ServiceAnfrage' ));
    }
    public function aGetPPIdDeepLink ($ppid, $lang, $tab, $subtab){
        $this->ppid = $ppid;
        //$this->lang = $lang;
        $pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $this->ppid);
        return View::make('ian.index')->with('data', array('lang' => $this->lang,  'pp' => $pp, 'deepLink' => 'Dateien' ));
    }
    public function aGetPPIdLidl ($ppid, $deepLink =''){
        $this->ppid = $ppid;
        //cpcDebug::cpc_debug($deepLink, '@T5');
        //$this->lang = $lang;
        $kllink = $this->pc->getKLLinkedItems($ppid);
        $style = $this->getStyle($ppid);
        //$pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $this->ppid);
        $pp = $this->pc->getPP($ppid);
        $attachments = $this->pc->getAttachments_Targaview($ppid);
        $ec = new EmbargoController();
        $embargo = $ec->getEmbargo($ppid);
        if (strpos(Auth::user()->PPMitarbeiter_Role,'INTERN') === false ){      
            return View::make('ian.indexLidl_extern')->with('data', array('style' => $style,'lang' => $this->lang, 'pp' => $pp , 'KLLink' => $kllink, 'Attachments' => $attachments, 'deepLink' => $deepLink, 'embargo' => $embargo ));
        }
        return View::make('ian.indexLidl')->with('data', array('style' => $style,'lang' => $this->lang, 'pp' => $pp , 'KLLink' => $kllink, 'Attachments' => $attachments, 'deepLink' => $deepLink, 'embargo' => $embargo ));
    }
    public function content () {
        $tab = Input::get('tabid');
        ////cpcDebug::cpc_debug('content(' . $tab .')','@T0403_1');
        $this->ppid = Input::get('ppid');
        $this->lang = Input::get('lang');
        switch ($tab) {
            case 'Allgemein':   
                return $this->getDataAllgemein($this->ppid);
                break;
            case 'InfoLidl':
                return $this->getDataInfoLidl($this->ppid);
                break;
            case 'ProduktpassEdit':
                ////cpcDebug::cpc_debug('Produktpass gefunden: '.$this->ppid.'#' ,'@T0403_1');
                if (Auth::user()->PPMitarbeiter_Gruppe != 'admin'){
                    return"<div style='height:80%;'><div style='border:2px solid lightgray; padding:30px;' ><b>". ServiceProvider::tl($this->lang, 'Kein Zugriff auf geschützten Bereich!') . "</b></div></div>";
                }
                return $this->getDataProduktpass($this->ppid);
                break;
            case 'Dateien':
                return $this->getDataDateien($this->ppid);
                break;
            case 'MeetingProtokoll':
                return $this->getDataMeeting($this->ppid);
                break;
            case 'Notizen':
                return $this->getDataNotizen($this->ppid);
                break;
            case 'RFQ':
                return $this->getDataRFQ($this->ppid);
                break;
            case 'ServiceAnfrage':
                return $this->getDataService($this->ppid);
                break;
            case 'StammdatenLidl':
                return $this->getDataStammdaten($this->ppid);
                break;
            case 'QualitaetLidl':
                return $this->getDataQualitaet($this->ppid);
                break;
            case 'SortierungLidl':
                return $this->getDataSortierung($this->ppid);
                break;
            case 'MengeLidl':
                return $this->getDataMenge($this->ppid);
                break;
            case 'BestelluebersichtLidl':
                return $this->getDataBestelluebersicht($this->ppid);
                break;
            case 'AuftragsabwicklungLidl':
                return $this->getDataAuftragsabwicklung($this->ppid);
                break;
            case 'Themenplanung' :
                return $this->getDataThemenplanung($this->ppid);
                break;
            default:
                # code...
                break;
        }
    }
    private function getDataOne ($table, $keycol, $id){
        $res = $table::where($keycol,$id)->get()->first();
        if ($res){
            return $res;
        }
        return false;
    }
    private function getDataAll ($table, $qrycol, $qry, $order = 1){
        $res = $table::where($qrycol,$qry)->orderBy($order)->get();
        if ($res){
            return $res;
        }
        return false;
    }
    private function getPP ($id ){
        return $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $id);
    }
    private function getFiles ($id ){
        return $this->getDataAll('PPPPFiles', 'PPPPFiles_PPProduktpass_Id', $id, 'PPPPFiles_Name');
    }
    private function getDataAllgemein($ppid){
        $pp = $this->getPP($ppid);
        $ec = new EmbargoController();
        $embargo = $ec->getEmbargo($ppid);
        cpcDebug::cpc_debug($embargo, '@Embargo');
        return  View::make('ian.auftragsinfo')->with('data', array('pp' => $pp, 'lang' => $this->lang, 'embargo' => $embargo));
    }
    private function getDataInfoLidl($ppid){
        $kllink = $this->pc->getKLLinkedItems($ppid);
        $style = $this->getStyle($ppid);
        $pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $this->ppid);
        $ec = new EmbargoController();
        $embargo = $ec->getEmbargo($ppid);
        $attachments = $this->pc->getAttachments_Targaview($ppid);
        return View::make('ian.infoLidl')->with('data', array('style' => $style,'lang' => $this->lang, 'name' => 'Frank', 'pp' => $pp , 'KLLink' => $kllink, 'Attachments' => $attachments, 'embargo' => $embargo ));
    }
    public Function getDataDateien ($ppid, $return =false,  $kat = 'LEER'){
        //return '<span>Ohalalaa</span>';
        $role = Auth::user()->PPMitarbeiter_Role;
        $_files      = $this->getFilesDistinct($ppid, $role);
        //cpcDebug::cpc_debug('Dateien Distinct','@T25');
        //cpcDebug::cpc_debug($_files,'@T25');
        $files['files']     = $_files['files'];
        $files['TOTAL']     = $_files['TOTAL'];
        $files['TRANSFERD'] = $_files['TRANSFERD'];
        $files['typesLB'] = $this->getUploadTypes($role, True);
        $files['subtypesLB'] = $this->getUploadSubTypes($role, True);
        $files['types'] = $this->getUploadTypes($role, );
        $files['subtypes'] = $this->getUploadSubTypes($role, );
        $filesLastChange = $this->getSPOFilesLastChange($ppid);
        $FileProtokoll = $this->pc->getFileProtokoll($ppid);
        $Kategorien = $this->pc->getKategorien();
        //cpcDebug::cpc_debug($Kategorien,'@1');
        $pp         = $this->getPP($ppid);
        $tabs       = $data['tabs'] = array( 'mainTab' => '0', 'mainTabIndex' => 0, 'subTabName' => '', 'subTabIndex' => 0, 'subsubTabIndex' => 0, 'compactView' => 0);
        $params = array(      
                        'pp' => $pp, 
                        'tabs' => $tabs, 
                        'Kategorien' => $Kategorien, 
                        'files' => $files,
                        'FileProtokoll' => $FileProtokoll,
                        'lang' => $this->lang,
                        'FilesLastChange' => $filesLastChange);
        if ( $return ){
            $lang = $params['lang'];
            $ord = $params['Kategorien'];
            $ordText = array();
            foreach ($ord as $ok => $ot){
                foreach($ot as $oo){
                    $ordText [$ok][] = ServiceProvider::tl($lang, $oo ) ;
                }
            }
            $img = "\\data\\Icons\\download.png";
            $dlSymbol = '<div style="float:left; border: none;margin-right:5px;"><img style="height:18px;" src="'.$img.'" /></div>';
            $isSharepoint = $params['pp']['PPProduktpass_Transferd2Sharepoint'] > 0;
            $countFiles = $params['files']['TOTAL'];
            $transferdFiles = $params['files']['TRANSFERD'];
            $server = "https://tpt-dev.ad.targa.de";
            $showEdit2 = true;
            $view = View::make('ian.newFileAfterUpload')->with('data', $params) ->with( 'lang' , $lang)->with( 'ord' , $ord)->with('ordText' , $ordText)->with('img' , $img)->with('dlSymbol' , $dlSymbol)->with('isSharepoint' , $isSharepoint)->with('countFiles' , $countFiles)->with('transferdFiles' , $transferdFiles)->with('server' , $server)->with('showEdit2' , $showEdit2)->render(); 
            //cpcDebug::cpc_debug('Rückgabe','@VIEW1');
            //cpcDebug::cpc_debug($params['pp'],'@VIEW1');
            return array( 'view' => $view, 'kat' => $kat);
        }
        $view = 'ian.filesCompact';
        return  View::make($view)->with('data',   $params);
    } 
    private Function getDataMeeting ($ppid){
        //$pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $ppid);
        $pp = $this->getPP($this->ppid);
        $mc = new MeetingController();
        $mp = $mc->getOrNewMeeting($this->ppid);
        if ($mp){
            return View::make('ian.meeting')->with('data', array('pp' => $pp, 'MeetingProtokoll' => $mp, 'lang' => $this->lang));
        } else {
            return 'Meeting NOK';
        }
    } 
    private Function getDataProduktpass ($id){
        $pp = $this->getDataOne('tPPProduktpass', 'PPProduktpass_Id', $id);
        //cpcDebug::cpc_debug('getDataProduktpass: '.$pp->PPProduktpass_Id.' DB IsCritical '.$pp->PPProduktpass_IsCriticalProject, '@Child');
        $Protokoll['tPPProduktpass']['PPProduktpass_CRDWoche'] = $this->pc->getProtokoll('tPPProduktpass',$id, 'PPProduktpass_CRDWoche');
        $Protokoll['tPPProduktpass']['PPProduktpass_CRDJahr'] = $this->pc->getProtokoll('tPPProduktpass',$id, 'PPProduktpass_CRDJahr');
        $Protokoll['tPPProduktpass']['PPProduktpass_ArtikelTarga'] = $this->pc->getProtokoll('tPPProduktpass',$id, 'PPProduktpass_ArtikelTarga');
        $ProjektIANs = $this->pc->getProjektIANs($pp->PPProduktpass_PPProjekte_Projekt);
        $greenlevel = $this->pc->getGreenLevel();
        $scopes = $this->getScopes();
        return  View::make('ian.ppedit')->with('data', array('Protokoll' => $Protokoll, 'pp' => $pp, 'lang' => $this->lang, 'ProjektIANs' => $ProjektIANs, 'greenlevel' => $greenlevel, 'scopes' => $scopes ));
    } 
    public Function storePP (){
        $data = json_decode(Input::get('params'),true); 
        $key = $data['Key'];
        unset($data['Key']);
        $this->store('tPPProduktpass','PPProduktpass_Id', $key, $data);   
        return array('result' => 'OK', 'msg' => 'Hallo Welt OK!');
    } 
    private function store ($table,$keyAtt, $key, $data){
        $upd = $table::where($keyAtt, $key)->get()->first();
        if ($upd){
            foreach($data as $attribute => $value){
                $upd->{$attribute} = $value;
            }
            $upd->save();
        }
    }
    private function getPPId ($ian, $charge){
        $pp = tPPProduktpass::where('PPProduktpass_IAN','=', $ian )->where('PPProduktpass_Ausmusterungnummer', 'like', $charge.'%')->get()->first();
        if ($pp){
            return $pp->PPProduktpass_Id;
        }
        echo("Not found!   $ian $charge !");
        exit;
        return 0;
    }
    private function getDataStammdaten($ppid){
        $pp = $this->getPP($ppid);
        $kllink = $this->pc->getKLLinkedItems($ppid);
        $style=$this->getStyle($ppid);
        $attachments = $this->pc->getAttachments_Targaview($ppid);
        //cpcDebug::cpc_debug($attachments,'@T0503_1');
        return  View::make('ian.artikelstamm')->with('data', array('style' => $style, 'pp' => $pp, 'lang' => $this->lang, 'KLLink' => $kllink, 'Attachments' => $attachments ));
    }
    private function getStyle($ppid){
        $style = PPProduktpass_Style::where("PPProduktpass_Style_PPProduktpass_Id", "=", $ppid)->get()->sortBy('PPProduktpass_Style_Id');
        if ($style){
            return $style;
        }
        return false;
    }
    private function getDataService($ppid){
        $pp = $this->getPP($ppid);
        $InpMan1 = $this->pc->getInputManuell($ppid);
        $InpMan = null;
        $InpManVersions = null;
        $InpManVersionsRemark = null;
        $InpManCompare = null;
        $InpContainer = null;
        $FileProtokoll = $this->pc->getFileProtokoll($ppid);
        if (!is_null($InpMan1)) {
            ////cpcDebug::cpc_debug($InpMan,'@T03');
            $InpMan = $InpMan1['InpMan'];
            $InpManVersions = $InpMan1['Versions'];
            $InpManVersionsRemark = $InpMan1['VersionsRemark'];
            $InpManCompare = $InpMan1['Compare'];
            $InpContainer = $InpMan1['Container'];
        } else {
            //cpcDebug::cpc_debug("InpMan == NULL",'@T03');
        }
        $MengeMenge = $this->pc->getMengeMenge($ppid);
        $data = array(  
                        'pp'              => $pp, 
                        'lang'            => $this->lang,
                        'InpMan'          => $InpMan,
                        'InpManVersions'  => $InpManVersions,
                        'InpManVersionsRemark'  => $InpManVersionsRemark,
                        'InpManCompare'   => $InpManCompare,
                        'InpContainer'    => $InpContainer,
                        'FileProtokoll'   => $FileProtokoll,
                        'MengeMenge'      => $MengeMenge
        );
        return  View::make('ian.service')->with('data', $data);
    }
    private function getDataRFQ($ppid){
        $pp = $this->getPP($ppid);
        $translation = $this->pc->getTranslation($ppid);
        //print_r($translation);
        //exit;
        $kllink = null;//$this->pc->getKLLinkedItems($ppid);
        $style =null; //$this->getStyle($ppid);
        return  View::make('ian.RFQ')->with('data', array('style' => $style, 'pp' => $pp, 'lang' => $this->lang, 'KLLink' => $kllink, 'translation' => $translation ));
    }
    private function getDataQualitaet($ppid){
        $pp = $this->getPP($ppid);
        $style=$this->getStyle($ppid);
        return  View::make('ian.qualitaet')->with('data', array( 'style' => $style, 'pp' => $pp, 'lang' => $this->lang));
    }
    private function getDataMenge($ppid){
        $pp    = $this->getPP($ppid);
        $style = $this->getStyle($ppid);
        $m = $this->pc->getMenge($ppid);
        $menge = $m['Menge'];
        return  View::make('ian.menge')->with('data', array('mengeAlt' => $m['MengeAlt'], 'importDatum' => $m['Import'], 'menge' =>  $m['Menge'],'mengeAlt' =>  $m['MengeAlt'], 'style' => $style, 'pp' => $pp, 'lang' => $this->lang));
    }
    private function getDataSortierung($ppid){
        $pp = $this->getPP($ppid);
        $style=$this->getStyle($ppid);
        $tAssortment = $this->pc->getAssortmentTPT_Targaview($ppid);
        return  View::make('ian.sortierung')->with('data', array( 'tAssortment' => $tAssortment, 'style' => $style, 'pp' => $pp, 'lang' => $this->lang));
    }
    private function getDataBestelluebersicht($ppid){
        $pp = $this->getPP($ppid);
        $style=$this->getStyle($ppid);
        $assort = $this->pc->getAssortmentTPT_Targaview($ppid);
        return  View::make('ian.bestelluebersicht')->with('data', array( 'tAssortment' => $assort, 'style' => $style, 'pp' => $pp, 'lang' => $this->lang));
    }
    private function getDataNotizen($ppid){
        $pp = $this->getPP($ppid);
        return  View::make('ian.notizen')->with('data', array('lang' => $this->lang, 'pp' => $pp));
    }
    private function getDataAuftragsabwicklung($ppid){
        //$pp = $this->getPP($ppid);
        //$style=$this->getStyle($ppid);
        $tOrder = $this->pc->getOrder_Targaview($ppid);
        $tLsv = $this->pc->getLsv_Targaview($ppid);
        return  View::make('ian.auftragsabwicklung')->with('data', array( 'tLsv' => $tLsv, 'tOrder' => $tOrder, 'lang' => $this->lang));
    }
    private function getDataThemenplanung($ppid){
        $pp = $this->getPP($ppid);
        return  View::make('ian.themenplanung')->with('data', array('lang' => $this->lang, 'pp' => $pp));
    }
    private function pr($x)  {
        if (Auth::user()->PPMitarbeiter_Id == 1){
            $y = '<pre>';
            $y .= print_r($x,1);
            $y .= '</pre>';
            echo($y);
            exit;
        }
    }
    public function newProjectNotes()
    {
        $ppid = Input::get('ppid');
        $Bemerkung = Input::get('text');
        //cpcDebug::cpc_debug("Angekommen:", '@TEST44');
        //cpcDebug::cpc_debug("$ppid $Bemerkung", '@TEST44');
        $pp = tPPProduktpass::find($ppid);
        if ($pp) {
            $t = $pp->PPProduktpass_AdminRemark;
            $t = date('d.m.Y') . "   [" . Auth::user()->PPMitarbeiter_Kuerzel . "]
" . $Bemerkung . "
" . $t;
            $pp->PPProduktpass_AdminRemark = $t;
            $pp->save();
        }
        //cpcDebug::cpc_debug('OK New', '@T1');
        return json_encode(array(  $t ));
    }
    public function updateProjectNotes()
    {
        $ppid = Input::get('ppid');
        $Bemerkung = Input::get('text');
        $pp = tPPProduktpass::find($ppid);
        if ($pp) {
            $pp->PPProduktpass_AdminRemark = $Bemerkung;
            $pp->save();
        }
        //cpcDebug::cpc_debug('OK', '@T1');
        return json_encode(array( $Bemerkung  ));
    }
    public function updatePPAjax()
    {
        //cpcDebug::cpc_debug('updatePPAjax', '@T18A');
        $input = Input::all();
        $id = $input['PPProduktpass_Id']; 
        $pp = tPPProduktpass::find($id);
        $oldWeek = $pp->PPProduktpass_CRDWoche;
        $oldYear = $pp->PPProduktpass_CRDJahr;
        //cpcDebug::cpc_debug('updatePPAjax 0', '@T18A');
        if ($oldWeek !=  $input['PPProduktpass_CRDWoche']   or $oldYear != $input['PPProduktpass_CRDJahr'] ){
            if ($input['PPProduktpass_CRDWoche'] == 0){
                // Alle Änderungen am CRD rückgängig machen 
                //cpcDebug::cpc_debug('updatePPAjax Rückgängig', '@T18A');
                $this->pc->removeProtokollAll($pp->PPProduktpass_Id,'tPPProduktpass','PPProduktpass_CRDWoche');
            } else {
                //cpcDebug::cpc_debug('updatePPAjax Protokoll', '@T18A');
                $this->pc->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_CRDWoche', $oldWeek."/".$oldYear, $input['PPProduktpass_CRDWoche'].'/'.$input['PPProduktpass_CRDJahr'] );
            }
        }
        $oldIAN = $pp->PPProduktpass_IAN;
        $oldCharge = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        //cpcDebug::cpc_debug('updatePPAjax 0AA', '@T18A');
        if ($oldIAN !=  $input['PPProduktpass_IAN']   or $oldCharge != substr($input['PPProduktpass_Ausmusterungnummer'],0,4) ){
            //cpcDebug::cpc_debug('updatePPAjax 0B', '@T18A');
            $this->pc->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_IAN', $oldIAN.' ['.$oldCharge.']', $input['PPProduktpass_IAN'].' ['.$input['PPProduktpass_Ausmusterungnummer'].']' );
            $this->pc->renameIAN_SPO($oldIAN, $oldCharge, $input['PPProduktpass_IAN'],substr($input['PPProduktpass_Ausmusterungnummer'],0,4) );
        } 
        $oldArtikel = $pp->PPProduktpass_ArtikelTarga;
        //cpcDebug::cpc_debug('updatePPAjax: '.$pp->PPProduktpass_Id.' DB IsUSA '.$pp->PPProduktpass_IsUSA.' Input IsUSA: '.$input['PPProduktpass_IsUSA'], '@Child');
        if($input['PPProduktpass_ArtikelTarga'] != $pp->PPProduktpass_ArtikelTarga and $pp->PPProduktpass_Artikelbezeichung != $pp->PPProduktpass_ArtikelTarga){
            $this->pc->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_ArtikelTarga', $oldArtikel, $input['PPProduktpass_ArtikelTarga']);
        }
        if ($pp->PPProduktpass_IsChild == 0 and $input['PPProduktpass_IsChild'] == 1) {
            $this->pc->updateTermineChild($pp->PPProduktpass_Id);
        }
        if ($pp->PPProduktpass_IsChild == 1 and $input['PPProduktpass_IsChild'] == 0) {
            $this->pc->updateTermineChild($pp->PPProduktpass_Id,'backChild');
        }
        if ($pp->PPProduktpass_IsKaufland == 0 and $input['PPProduktpass_IsKaufland'] == 1) {
            $this->pc->updateTermineChild($pp->PPProduktpass_Id, 'Nachbestellung');
        }
        if ($pp->PPProduktpass_IsKaufland == 1 and $input['PPProduktpass_IsKaufland'] == 0) {
            $this->pc->updateTermineChild($pp->PPProduktpass_Id, 'backNachbestellung');
        }
        //$isUSOrderC = DB::table('v_IsUSOrder')->where("PPProduktpass_Menge_PPProduktpass_Id", "=", $pp->PPProduktpass_Id)->count();
        //$input['PPProduktpass_IsUSA'] = ($isUSOrderC > 0)? 1 : 0;
        if ($pp->PPProduktpass_IsUSA == 0 and $input['PPProduktpass_IsUSA'] == 1) {
            //cpcDebug::cpc_debug('updatePPAjax: SetUSA', '@Child');
            $this->pc->updateTermineChild($pp->PPProduktpass_Id, 'USA');
        }
        if ($pp->PPProduktpass_IsUSA == 1 and $input['PPProduktpass_IsUSA'] == 0) {
            //cpcDebug::cpc_debug('updatePPAjax: ResetUSA', '@Child');
            $this->pc->updateTermineChild($pp->PPProduktpass_Id, 'backUSA');
        }
        if (!isset($input['PPProduktpass_LieferterminJahr']) || $input['PPProduktpass_LieferterminJahr'] == '') {
            $input['PPProduktpass_LieferterminJahr'] = date('Y');
        }
        //cpcDebug::cpc_debug('updatePPAjax 2', '@T18A');
        foreach ($input as $att => $val) {
            if (strpos($att, 'PPProd') !== false) $pp->{$att} = $val;
        }
        $pp->PPProduktpass_ThemaScope = $input['PPProduktpass_ThemaScope'];
        $pp->PPProduktpass_IsCriticalProject = $input['PPProduktpass_IsCriticalProject'];
        $this->setCriticalProject($pp->PPProduktpass_PPProjekte_Projekt, $input['PPProduktpass_IsCriticalProject']);
        $pp->save();
        //cpcDebug::cpc_debug('updatePPAjax Save Ende', '@T18A');
        return json_encode(array('Result' => 'OK'));
    }
    public function mailCompare($ppid, $fid,  $pmailto = ''){
        //exit;
        //$mailto = 'f.keppel@compeocn.de';
        if ($pmailto == ''){
            $mailto = Auth::user()->PPMitarbeiter_email;
        } else {
            $mailto = $pmailto;
        }
        //cpcDebug::cpc_debug("Info:  PPId: $ppid FId: $fid MailTo Parameter: $pmailto MailTo: $mailto #", '@T4');
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            $message = '';
            $server = 'https://' . $_SERVER['SERVER_NAME'];
            $ian = $pp->PPProduktpass_IAN;
            if ($pp->PPProduktpass_RevisionVon_PPProduktpass_Id !== 0) {
                $xmlc = new XMLController();
                $data['content'] = $xmlc->diffXML($ppid, $fid);
                $subject         = "[TPT] Produktpass IAN $ian Vergleichsbericht";
                $message         = "<b>Vergleichsbericht<b><br><br><a href='" . "$server/show/$ppid" . "'>Link zum Produktpass.</a><br><br>" . "<h3>Änderungen zur Vorversion</h3><br><br>";
                $body =  $message .'<br><br>'.$data['content']; //$this->compareXML($ppid, "LATEST", $message);
                if (strlen($mailto) > 3) {
                    $mail = new MailController();
                    $cc1 = array();
                    //$pm = PPMitarbeiter::find($pp->PPProduktpass_PMAdmin);
                    //echo('<br>PM: '.$pp->PPProduktpass_PMAdmin);
                    //Bei Absage oder Geliefert keine mail an PM oder TC
                    //cpcDebug::cpc_debug("Gesendet!", '@T4');
                    $mail->sendMail($mailto, $cc1, $subject, $body);
                    return json_encode(array('Result' => 'Send'));
                }
            }
        } 
        //cpcDebug::cpc_debug("Nicht gesendet!", '@T4');
        return json_encode(array('Result' => 'Not Send, really?'));
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
    public function setLanguage(){
        $lang = Input::get('lang'); 
        //cpcDebug::cpc_debug('setLanguage Neu: '.$lang,'@T4');
        //cpcDebug::cpc_debug($_COOKIE['TPTLanguage'],'@T4');
        setcookie("TPTLanguage", '', time() - 3600);
        setcookie("TPTLanguage", $lang, time() + 3600);
        return;
    }
    private function getSPOFilesLastChange( $ppid ) {
        $pp = $this->getPP($ppid);
        $oc = new Office365Controller ();
        $filesLastChange = $oc->getLastChanged($pp->PPProduktpass_IAN, substr($pp->PPProduktpass_Ausmusterungnummer,0,4));
        return $filesLastChange;
    }
    private function getFilesDistinct($ppid, $role){
        try{
            if (strpos($role,'INTERN') !== false){
                cpcDebug::cpc_debug('getFileDistinct: INTERN ','@T4');
                $tmp_files =   v_FilesDistinct::where('PPPPFiles_PPProduktpass_Id', '=', $ppid)->where('PPPPFiles_Status', '>=', 1)->orderBy('PPPPFiles_Type')->orderBy('PPPPFiles_SubKat')->orderBy('PPPPFiles_Date', 'DESC')->get();
            } else {
                cpcDebug::cpc_debug('getFileDistinct: NICHT INTERN ','@T4');
                $tmp_files =   v_FilesDistinct::where('PPPPFiles_PPProduktpass_Id', '=', $ppid)->where('PPPPFiles_Status', '>=', 1)->where('PPPPFiles_IsExtern', 1)->orderBy('PPPPFiles_Type')->orderBy('PPPPFiles_SubKat')->orderBy('PPPPFiles_Date', 'DESC')->get();
            }
        }
        catch(Exception $e){
            //cpcDebug::cpc_debug('getFilesDistinct 1'.$e->getMessage(), '@T25');
            return false;
        }
        $distinct_files = array();
        $total = 0;
        $transferd = 0;
        $filearray = array();
        foreach ($tmp_files as $tfile) {
            //cpcDebug::cpc_debug('getFilesDistinct 2 '.$tfile->PPPPFiles_Name, '@T25');
            if (is_null($tfile->PPPPFiles_SubKat)) {
                $tfile->PPPPFiles_SubKat = "Dateien";
            }
            if (!isset($distinct_files[$tfile->PPPPFiles_Name.$tfile->PPPPFiles_SubKat])){
                $distinct_files[$tfile->PPPPFiles_Name.$tfile->PPPPFiles_SubKat] = $tfile;
            }
            ///var/www/html/lis/public/data/import/XML/
            //$tfile->PPPPFiles_Name = str_replace("/var/www/html/lis/public/data/import/XML/", "", $tfile->PPPPFiles_Name);
            //$tfile->PPPPFiles_Name = str_replace("/var/www/lis/public/data/import/XML/", "", $tfile->PPPPFiles_Name);
            //$tfile->save();
            $total ++;
            if ( !is_null($tfile->PPPPFiles_SharePointLink)){
                $transferd++;
            }
        }
        $ret = array('files' => $distinct_files, 'TOTAL' => $total, 'TRANSFERD' => $transferd);
        //cpcDebug::cpc_debug( $ret, '@T14');
        return $ret;
    }
    public function updateZoll(){
        //cpcDebug::cpc_debug("TEST_A", '@T1X');
        $input = Input::all();
        $id = $input['PPProduktpass_Id']; 
        $pp = tPPProduktpass::find($id);
        //cpcDebug::cpc_debug("TEST_B $id ", '@T1X');
        if ($pp) {
            //cpcDebug::cpc_debug("TEST_1: ".$input['PPProduktpass_Zolltarif'], '@T1X');
            //cpcDebug::cpc_debug("TEST_2: ".$input['PPProduktpass_Zollsatz'], '@T1X');
            $pc = new ProjectsController();
            $pc->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_Zolltarif', $pp->PPProduktpass_Zolltarif, $input['PPProduktpass_Zolltarif']);
            $pc->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_Zollsatz', $pp->PPProduktpass_Zollsatz, $input['PPProduktpass_Zollsatz']);
            $pp->PPProduktpass_Zolltarif = $input['PPProduktpass_Zolltarif'];
            $pp->PPProduktpass_Zollsatz = $input['PPProduktpass_Zollsatz'];
            //cpcDebug::cpc_debug('PP vorhanden und gesichert', '@T1X');
            $pp->save();
        } else {
            //cpcDebug::cpc_debug('PP vorhanden und gesichert', '@T1X');
            return json_encode(array('Result' => 'FAIL') );            
        }
        return json_encode(array('Result' => 'OK') );
    }
    public function getZollHistory(){
        $input = Input::all();
        $id = $input['PPProduktpass_Id']; 
        $pc = new ProjectsController();
        $protZT = $pc->getProtokoll('tPPProduktpass', $id, 'PPProduktpass_Zolltarif');
        $protZT = str_replace('\n', '<br>', $protZT);
        $protZS = $pc->getProtokoll('tPPProduktpass', $id, 'PPProduktpass_Zollsatz');
        $protZS = str_replace('\n', '<br>', $protZS);
        $hist = '<b>Zolltarifänderungen:</b><br>'. $protZT.'<br><b>Zollsatzänderungen:</b><br>'.$protZS;
        //cpcDebug::cpc_debug($protZT, '@T1');
        //cpcDebug::cpc_debug($protZS, '@T1');
        return json_encode(array('Result' => 'OK', 'History' => $hist) );
    }
    private function setCriticalProject($projectId, $isCritical){
        $pp = tPPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', $projectId)->get();
        if ($pp){
            foreach($pp as $p){
                $p->PPProduktpass_IsCriticalProject = $isCritical;
                $p->save();
            }
        }
    }
    private function getUploadTypes($role, $lb = false)
    {
        $fts = PPFileTypes::where('PPFileTypes_Type', 'like', '%')->where('PPFileTypes_ParentId', '=', 0)->orderBy('PPFileTypes_sort')->get();
        $ret = array();
        //$ret[''] = 'Bitte auswählen...';
        foreach ($fts as $ft) {
            if ($lb) {
                $ret[$ft->PPFileTypes_Type] = $ft->PPFileTypes_Type;
            } else {
                $ret[$ft->PPFileTypes_Type] = array("Id" => $ft->PPFileTypes_Id, "Type" => $ft->PPFileTypes_Type, 'Safety' => $ft->PPFileTypes_Safety);
            }
        }
        /* $ret['AB'] = 'AB';
          $ret['Artwork'] = 'Artwork';
          $ret['Designs'] = 'Designs';
          $ret['Agentur'] = 'Agentur';
          $ret['PO'] = 'PO';
          //$ret['PP']='PP';
          $ret['QS'] = 'QS';
          $ret['Labor'] = 'Labor';
          $ret['Kalkulation'] = 'Kalkulation';
          $ret['Diverse'] = 'Diverse';
          $ret['Disposition'] = 'Disposition';
          $ret['Buchhaltung'] = 'Buchhaltung';
          $ret['Bilder Textbausteine'] = 'Bilder Textbausteine';
        */
        //   ksort($ret);
        return $ret;
    }
    private function getUploadSubTypes($role, $lb = false)
    {
        $fts = PPFileTypes::where('PPFileTypes_Type', 'like', '%')->where('PPFileTypes_ParentId', '!=', 0)->orderBy('PPFileTypes_sort')->get();
        $ret = array();
        //$ret[''] = 'Bitte auswählen...';
        foreach ($fts as $ft) {
            if ($lb) {
                $ret[$ft->PPFileTypes_Id] = $ft->PPFileTypes_Type;
            } else {
                $ret[$ft->PPFileTypes_Id] = array("Id" => $ft->PPFileTypes_Id, "Kategorie" => $ft->PPFileTypes_Type, "ParentId" => $ft->PPFileTypes_ParentId, "iframe" => $ft->PPFileTypes_iframe, 'Safety' => $ft->PPFileTypes_Safety);
            }
        }
        return $ret;
    }
}