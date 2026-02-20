<?php
/* use DeepL\DeepLClient;
   use DeepL\Translator; 
   Bei Nutzung muss 
   use GuzzleHttp\Client as GuzzleClient;
   use Nyholm\Psr7\Factory\Psr17Factory;
   use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
   noch installiert werden
*/
use Normalizer;
class ProjectsController extends BaseController
{
    var $message = "";
    var $msgFile = null;
    var $msgFileName = null;
    var $msgFileBody = '';
    var $msgFileError = false;
    var $msgFilePPError = false;
    var $sxg = array();
    var $index = 0;
    private function writeMsgFile ( $line, $pureLine = '_' ){
        if (is_null($this->msgFile)){
            $this->newMsgFile();
        }
        //ob_end_flush();
        echo($line);
        //ob_start();
        //ob_flush();
        //flush();
        cpcDebug::cpc_debug($line,'!T2SPO2');
        $this->msgFileBody .= $line;
        fwrite($this->msgFile, $line); 
    }
    private function newMsgFile ( ){
        $this->msgFileError = false;
        $this->msgFileName = storage_path('/data/tmp/'). Auth::user()->PPMitarbeiter_Kuerzel."_".date('Ymd_His').'_TransferLog.html';
        $this->msgFile = fopen($this->msgFileName, "w+");
    }
    private function getMsgFileBody( ){
        return $this->msgFileBody;
    }
    private function getMsgFileName( ){
        return $this->msgFileName;
    }
    private function _dateLocal2MySql($termin)
    {
        //cpcDebug::dd($termin,false);
        if (strlen($termin) == 10) {
            $datum = explode('.', $termin);
            $retdate = $datum[2] . '-' . $datum[1] . '-' . $datum[0];
            //cpcDebug::dd($retdate,true);
            return $retdate;
        }
        return '1900-01-01';
    }
    private function getOrderOverview($ppid)
    {
        $sorts = PPXML_Mengen::where('PPXML_Mengen_PPProduktpass_Id', $ppid)->orderBy('PPXML_Mengen_styleNo')->orderBy('PPXML_Mengen_lsv')->orderBy('PPXML_Mengen_country')->get();
        $overview = array();
        $countries = array();
        if ($sorts) {
            foreach ($sorts as $sort) {
                if (strpos($sort->PPXML_Mengen_country, 'OS') === false) {
                    $overview[$sort->PPXML_Mengen_GTIN][$sort->PPXML_Mengen_styleNo][$sort->PPXML_Mengen_productName][$sort->PPXML_Mengen_sizeCode][$sort->PPXML_Mengen_lsv][$sort->PPXML_Mengen_country] = $sort->PPXML_Mengen_value;
                    $countries[$sort->PPXML_Mengen_country] = $sort->PPXML_Mengen_country;
                }
            }
            //PXML_Mengen_GTIN, PPXML_Mengen_styleNo, PPXML_Mengen_productName, PPXML_Mengen_sizeCode, PPXML_Mengen_country, PPXML_Mengen_lsv, PPXML_Mengen_value
            /*
            foreach ($overview as $gtin => $style){ 
                echo("$gtin -> ");
                foreach ($style as $style => $colors){
                    echo("$style -> ");
                    foreach ($colors as $color => $sorts){
                        echo("$color -> ");
                        foreach ($sorts as $sort => $sizes){
                            echo("$sort -> ");
                            foreach ($sizes as $size => $countries){
                                echo("$size -> ");
                                foreach ($countries as $country => $qty){
                                    echo(" [ $country ]  $qty ");
                                }
                                echo("<br>");
                            }
                        }
                    }
                }
            }
            echo("<br><pre>");
            print_r($overview);
            */
            return array('overview' => $overview, 'countries' => $countries);
        }
        return null;
    }
    private function getOrderOverviewOS($ppid)
    {
        $sorts = PPXML_OSMengen::where('PPXML_OSMengen_PPProduktpass_Id', $ppid)->orderBy('PPXML_OSMengen_styleNo')->orderBy('PPXML_OSMengen_lsv')->orderBy('PPXML_OSMengen_country')->get();
        $overview = array();
        $countries = array();
        if ($sorts) {
            foreach ($sorts as $sort) {
                if (strpos($sort->PPXML_OSMengen_country, 'OS') !== false) {
                    $overview[$sort->PPXML_OSMengen_GTIN][$sort->PPXML_OSMengen_styleNo][$sort->PPXML_OSMengen_productName][$sort->PPXML_OSMengen_sizeName][$sort->PPXML_OSMengen_lsv][$sort->PPXML_OSMengen_country] = $sort->PPXML_OSMengen_value;
                    $countries[$sort->PPXML_OSMengen_country] = $sort->PPXML_OSMengen_country;
                }
            }
            //PXML_Mengen_GTIN, PPXML_OSMengen_styleNo, PPXML_OSMengen_productName, PPXML_OSMengen_sizeCode, PPXML_OSMengen_country, PPXML_OSMengen_lsv, PPXML_OSMengen_value
            /*foreach ($overview as $gtin => $style){
                echo("$gtin -> ");
                foreach ($style as $style => $colors){
                    echo("$style -> ");
                    foreach ($colors as $color => $sorts){
                        echo("$color -> ");
                        foreach ($sorts as $sort => $sizes){
                            echo("$sort -> ");
                            foreach ($sizes as $size => $countries){
                                echo("$size -> ");
                                foreach ($countries as $country => $qty){
                                    echo(" [ $country ]  $qty ");
                                }
                                echo("<br>");
                            }
                        }
                    }
                }
            }
            exit;*/
            /* echo("<br><pre>");      print_r($overview); */
            return array('overview' => $overview, 'countries' => $countries);
        }
        return null;
    }
    public function getKategorien()
    {
        $kategorien = PPKategorien::where('PPKategorien_Id', '>', 0)->orderBy('PPKategorien_Parent')->orderBy('PPKategorien_Sort')->orderBy('PPKategorien_Kategorie')->get();
        $kats = array();
        foreach ($kategorien as $kategorie) {
            $kats[$kategorie->PPKategorien_Parent][] = $kategorie->PPKategorien_Kategorie;
        }
        //echo("<pre>");print_r($kats);        exit;
        return $kats;
    }
    private function val2num($value)
    {
        $value = str_replace('.', 'X', $value);
        $value = str_replace(',', '.', $value);
        $value = str_replace('X', '', $value);
        return $value;
    }
    public function round_half_down($num, $places)
    {
        return round($num, $places, PHP_ROUND_HALF_DOWN);
    }
    private function _dateMySql2Local($termin)
    {
        //cpcDebug::dd($termin,false);
        $termin = substr($termin, 0, 10);
        if (strlen($termin) == 10) {
            $datum = explode('-', $termin);
            $retdate = $datum[2] . '.' . $datum[1] . '.' . $datum[0];
            //cpcDebug::dd($retdate,false);
            return $retdate;
        }
        return '01.01.1900';
    }
    private function getStyleTranslation($id)
    {
        $trans = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $id)->get();
        if ($trans) {
            $ret = array();
            foreach ($trans as $row) {
                $ret[$row->PPProduktpass_Style_Header]['Value01'] = $row->PPProduktpass_Style_Value01_Translation;
                $ret[$row->PPProduktpass_Style_Header]['Value02'] = $row->PPProduktpass_Style_Value02_Translation;
                $ret[$row->PPProduktpass_Style_Header]['Value03'] = $row->PPProduktpass_Style_Value03_Translation;
                $ret[$row->PPProduktpass_Style_Header]['Value04'] = $row->PPProduktpass_Style_Value04_Translation;
                $ret[$row->PPProduktpass_Style_Header]['Value05'] = $row->PPProduktpass_Style_Value05_Translation;
            }
            //print_r($ret);
            return $ret;
        }
        return null;
    }
    public function getUploadTypes($lb = false)
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
    public function getUploadSubTypes($lb = false)
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
        //cpcDebug::pe($ret,1);
        return $ret;
    }
    /**
     * Display a listing of the resource.
     * GET /projects
     *
     * @return Response
     */
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
    public function getLidlId($art)
    {
        $ffs = PPAdressen::where("Art", "=", $art)->get();
        //cpcDebug::dd($ffs,true);
        $aff = array();
        foreach ($ffs as $ff) {
            $aff[$ff->PPAdressen_LidlId] = $ff->Matchcode;
        }
        //cpcDebug::dd($aff,true);
        return $aff;
    }
    public function getFrachtfuehrer()
    {
        return $this->getLidlId(9);
    }
    public function getSpediteure()
    {
        return $this->getLidlId(3);
    }
    public function getEmpfaenger8W()
    {
        return $this->getLidlId(8);
    }
    public function ppOverview()
    {
        $ov = Input::all();
        //var_dump($ov); exit;
        $data['content'] = View::make('listen.produktpass_overview')->with('data', $ov);
        return View::make('main', $data);
    }
    public function ppOverviewStart()
    {
        $subData["Header"] = "Produktpass Übersicht";
        $inp = Input::all();
        if (isset($inp['IsPost'])) {
            $search = trim($inp['search']);
            $search_ausmusterung = $inp['search_ausmusterung'];
            $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
            $subData['inp']['search'] = $search;
            $subData['pps'] = DB::table('v_PPUebersicht')->where('Ausmusterungnummer', 'like', "%$search_ausmusterung%")->where(function ($query) use ($search) {
                $query->where('IAN', 'like', "%$search%")->orwhere('Supplier', 'like', "%$search%")->orwhere('Artikelbezeichnung', 'like', "%$search%");
            })->orderBy('IAN', 'DESC')->get();
        } else {
            $subData['inp']['search_ausmusterung'] = date('y');
            $subData['inp']['search'] = '';
            $search = '';
            $search_ausmusterung = date('y');
            $subData['pps'] = DB::table('v_PPUebersicht')->where('IAN', 'like', "%$search%")->where('Ausmusterungnummer', 'like', "%$search_ausmusterung%")->orderBy('IAN', 'DESC')->get();
        }
        $data['content'] = View::make('listen.produktpass_overview')->with('data', $subData);
        return View::make('main', $data);
    }
    public function getHafenMengen($id)
    {
        $m = DB::table('PPProduktpass_Menge')->select(DB::raw('sum(PPProduktpass_Menge_Koper) as sumKoper, sum(PPProduktpass_Menge_Barcelona) as sumBarcelona, sum(PPProduktpass_Menge_Rotterdam) as sumRotterdam'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->groupBy('PPProduktpass_Menge_PPProduktpass_Id')->first();
        //var_dump($m); exit;
        return array('sumBarcelona' => $m->sumBarcelona, 'sumRotterdam' => $m->sumRotterdam, 'sumKoper' => $m->sumKoper);
    }
    private function getHaefen()
    {
        $haefen = PPLaenderbloecke::all();
        $ret = array();
        foreach ($haefen as $hafen) {
            $ret[$hafen->PPLaenderbloecke_Land]["Hafen1"] = $hafen->PPLaenderbloecke_Hafen1;
            $ret[$hafen->PPLaenderbloecke_Land]["Hafen2"] = $hafen->PPLaenderbloecke_Hafen2;
        }
        //var_dump($ret);
        return $ret;
    }
    public function getAbgangshafenText($id)
    {
        $hafen = PPAbgangshafen::where("PPAbgangshafen_Id", "=", $id)->get()->first();
        if ($hafen) {
            return $hafen->PPAbgangshafen_Hafen;
        }
        return "N.N.";
    }
    private function getPurchasesForPP($ppid)
    {
        $poid = DB::table('v_PurchaseLast')->select(DB::raw('PPPurchase_Id'))->where('PPPurchase_PPProduktpass_Id', '=', $ppid)->first();
        if (!$poid) {
            return false;
        }
        $po = PPPurchase::where("PPPurchase_Id", "=", $poid->PPPurchase_Id)->get()->first();
        return $po;
    }
    private function getRechnungspruefung($ian)
    {
        //return false;
        $rps = Rechnungsprufung::where('aktiv', 1)->where('IAN', $ian)->get();
        if (!$rps) {
            return false;
        }
        return $rps;
    }
    public function setRPinaktiv()
    {
        $Nummer_id = Input::get('Nummer_id');
        $ppid = Input::get('rp_ppid');
        //return false;
        $rp = Rechnungsprufung::where('Nummer_id', $Nummer_id)->get()->first();
        if (!$rp) {
            echo ("Fehler beim löschen!");
            exit;
            return false;
        }
        $rp->aktiv = 0;
        $rp->save();
        return Redirect::to('/showAfterUpload/' . $ppid . "/2/13");
    }
    private function getPurchasesForProjekt($projekt)
    {
        $pps = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', $projekt)->where('PPProduktpass_IAN', 'NOT LIKE', "%REV%")->get();
        // echo("<pre>");
        // print_r($pps);
        // exit;
        $pos = array();
        $i = 0;
        foreach ($pps as $pp) {
            //echo("$projekt $pp->PPProduktpass_IAN <br>");
            $pos[$i]['PP'] = $pp;
            $pos[$i]['PO'] = $this->getPurchasesForPP($pp->PPProduktpass_Id);
            $i++;
        }
        //exit;
        return $pos;
    }
    private function getProjectSupplier($ppid)
    {
        $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $ppid)->get()->first();
        if (!$purchase) {
            return false;
        }
        $supplier = PPAdressen::where('Matchcode', "=", $purchase->PPPurchase_Supplier)->get()->first();
        $adr = "N.N.";
        if ($supplier) {
            $adr = $supplier->Firma1 . PHP_EOL;
            $adr .= $supplier->Adresse1 . PHP_EOL;
            $adr .= strlen($supplier->PLZ) > 0 ? $supplier->PLZ . " " : "";
            $adr .= $supplier->Ort . PHP_EOL;
            $adr .= $supplier->Land . PHP_EOL;
        }
        return $adr;
    }
    private function getProjectDesc($ppid)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', '=', $ppid)->get()->first();
        if (strpos($pp->PPProduktpass_IAN, 'I-') !== false) {
            $desc = array("Amount" => array("Value" => 0, "Currency" => ''), "Description" => "Only Inquiery");
            return $desc;
        }
        if (!$pp) {
            return false;
        }
        $project = $pp->PPProduktpass_PPProjekte_Projekt;
        if (strlen(trim($project)) < 1 or is_null($project)) {
            $pps = PPProduktpass::where('PPProduktpass_Id', '=', $ppid)->where('PPProduktpass_IAN', 'not like', '%ev%')->get();
        } else {
            $pps = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', $project)->where('PPProduktpass_IAN', 'not like', '%ev%')->get();
        }
        $c = 1;
        $descGoods = "";
        $amountTotal = 0;
        $currency = "";
        foreach ($pps as $pp1) {
            $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $pp1->PPProduktpass_Id)->get()->first();
            if (!$purchase) {
                continue;
            }
            $amount = $pp1->PPProduktpass_Gesamtmenge * $purchase->PPPurchase_EK;
            $amountTotal += $amount;
            $currency = $purchase->PPPurchase_Currency;
            $descGoods .= $c . ".";
            $descGoods .= $purchase->PPPurchase_Translate_Quality;
            $descGoods .= "
Quantity: " . number_format($pp1->PPProduktpass_Gesamtmenge, 0, ',', '.');
            $descGoods .= "
FOB-Price per Unit: " . $purchase->PPPurchase_Currency . " " . number_format($purchase->PPPurchase_EK, 2, ',', '.');
            $descGoods .= "
Total:    " . $purchase->PPPurchase_Currency . " " . number_format($amount, 2, ',', '.') . "
";
            $c++;
        }
        $desc = array("Amount" => array("Value" => $amountTotal, "Currency" => $currency), "Description" => $descGoods);
        return $desc;
    }
    public function getLC($ppid)
    {
        $project = PPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
        $appians = "";
        //$appians[] = $project->PPProduktpass_IAN;
        $plus = "";
        if ($project) {
            $projectIds = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', "=", $project->PPProduktpass_PPProjekte_Projekt)->get();
            foreach ($projectIds as $projectId) {
                if (strlen($projectId->PPProduktpass_IAN) == 6) {
                    $appians .= $plus . $projectId->PPProduktpass_IAN;
                    $plus = " + ";
                }
            }
        }
        $LC = PPLC::where('PPLC_PPProduktpass_Id', "=", $ppid)->get()->first();
        $aLC = array();
        if (!$LC) {
            $LC = new PPLC();
            $LC->PPLC_PPProduktpass_Id = $ppid;
            $LC->save();
            return $this->getLC($ppid);
        }
        $landDocReq = "";
        if ($LC->PPLC_TextPort == "USA") {
            $landDocReq = "USA";
        }
        $LC = $LC->toArray();
        foreach ($LC as $key => $value) {
            if (!is_null($value) and strlen($value) > 0) {
                $aLC[$key] = $value;
            } else {
                if ($key != 'PPLC_PPProduktpass_Id' and $key != 'PPLC_Id') {
                    $att = substr($key, 5);
                    if ($key == "DocumentsRequired") {
                        $key = $key . $landDocReq;
                    }
                    $aLC[$key] = $this->getTextbaustein($att);
                } else {
                    $aLC[$key] = $value;
                }
            }
        }
        $atexte = PPTextbausteine::where('PPTextbausteine_Art', 'like', 'LC%')->get();
        foreach ($atexte as $txt) {
            $texte[$txt->PPTextbausteine_Art] = $txt->PPTextbausteine_Text;
        }
        $LC1['Texte'] = $texte;
        $LC1['LC'] = $aLC;
        $desc = $this->getProjectDesc($ppid);
        $LC1['DescGoods'] = $desc['Description'];
        $LC1['Amount'] = $desc['Amount'];
        $LC1['Supplier'] = $this->getProjectSupplier($ppid);
        $LC1['ProjektIANS'] = $appians;
        return $LC1;
    }
    private function getTextbaustein($art)
    {
        $tb = PPTextbausteine::where('PPTextbausteine_Art', "=", $art)->get()->first();
        if ($tb) {
            return utf8_encode($tb->PPTextbausteine_Text);
        }
        return "N.N.";
    }
    public function getZielhafen($land, $id)
    {
        //echo("Land: $land  Id: $id <br><pre>");
        $ret = array('Hafen1' => 'XX', 'Hafen2' => '', 'ProzH1' => 100, 'ProzH2' => 0);
        $aufteilung = $this->gethafenAufteilung($id);
        $m = DB::table('PPLaenderbloecke')->select(DB::raw('PPLaenderbloecke_Hafen1, PPLaenderbloecke_Hafen2, PPLaenderbloecke_Land'))->where('PPLaenderbloecke_Land', '=', $land)->first();
        if (!isset($m)) {
            return $ret;
        }
        $aufteilung = $this->gethafenAufteilung($id);
        $prozh1 = 1;
        $prozh2 = 0;
        if ($m->PPLaenderbloecke_Land == 'FR') {
            $prozh1 = $aufteilung['FRRTD'] / 100;
            $prozh2 = $aufteilung['FRBAR'] / 100;
        }
        if ($m->PPLaenderbloecke_Land == 'IT') {
            $prozh1 = $aufteilung['ITBAR'] / 100;
            $prozh2 = $aufteilung['ITKOP'] / 100;
        }
        $ret = array('Hafen1' => $m->PPLaenderbloecke_Hafen1, 'Hafen2' => $m->PPLaenderbloecke_Hafen2, 'ProzH1' => $prozh1, 'ProzH2' => $prozh2);
        return $ret;
    }
    public function getHafenMengenLB($id)
    {
        $aufteilung = $this->gethafenAufteilung($id);
        $haefen = $this->getHaefen();
        $m = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_CountryBlock, PPProduktpass_Menge_Kolli, PPProduktpass_Menge_Country, PPProduktpass_Menge_Quantity'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get();
        $ret = array();
        foreach ($m as $menge) {
            $zahl = substr(trim($menge->PPProduktpass_Menge_CountryBlock), -1, 1);
            if ($zahl == 0) {
                $zahl = 10;
            }
            $MengeKoper = 0;
            $MengeBarcelona = 0;
            $MengeRotterdam = 0;
            $MengeUSA = 0;
            $mengeLand = $menge->PPProduktpass_Menge_Quantity;
            //echo("<br>  $zahl ".$mengeLand." <br>");
            if (($menge->PPProduktpass_Menge_Country == "IT" or $menge->PPProduktpass_Menge_Country == "FR")) {
                //echo("Menge:".$mengeLand."<br>");
                if ($menge->PPProduktpass_Menge_Country == "IT") {
                    $MengeKoper = round($aufteilung["ITKOP"] / 100 * $mengeLand);
                    $MengeBarcelona = $mengeLand - $MengeKoper;
                    //echo("IT Kop:".$MengeKoper."<br>");echo("IT Bar:".$MengeBarcelona."<br>");
                    $kolli = $menge->PPProduktpass_Menge_Kolli;
                    if ($kolli > 0 and $MengeKoper % $kolli) {
                        $rest = $MengeKoper % $kolli;
                        $diff = $kolli - $rest;
                        //$diff = $rest;
                        $MengeKoper = $MengeKoper + $diff;
                        $MengeBarcelona = $MengeBarcelona - $diff;
                    }
                    //echo("IT Kop:".$MengeKoper."<br>");echo("IT Bar:".$MengeBarcelona."<br>");
                    $ret[$zahl]["Barcelona"] = isset($ret[$zahl]["Barcelona"]) ? $ret[$zahl]["Barcelona"] + $MengeBarcelona : $MengeBarcelona;
                    $ret[$zahl]["Koper"] = isset($ret[$zahl]["Koper"]) ? $ret[$zahl]["Koper"] + $MengeKoper : $MengeKoper;
                }
                if ($menge->PPProduktpass_Menge_Country == "FR") {
                    $MengeRotterdam = round($aufteilung["FRRTD"] / 100 * $mengeLand);
                    $MengeBarcelona = $mengeLand - $MengeRotterdam;
                    //echo("FR Rot:".$MengeRotterdam."<br>");echo("FR Bar:".$MengeBarcelona."<br>");
                    $kolli = $menge->PPProduktpass_Menge_Kolli;
                    if ($kolli > 0 and $MengeRotterdam % $kolli) {
                        $rest = $MengeRotterdam % $kolli;
                        $diff = $kolli - $rest;
                        //$diff = $rest;
                        $MengeRotterdam = $MengeRotterdam + $diff;
                        $MengeBarcelona = $MengeBarcelona - $diff;
                    }
                    $ret[$zahl]["Barcelona"] = isset($ret[$zahl]["Barcelona"]) ? $ret[$zahl]["Barcelona"] + $MengeBarcelona : $MengeBarcelona;
                    $ret[$zahl]["Rotterdam"] = isset($ret[$zahl]["Rotterdam"]) ? $ret[$zahl]["Rotterdam"] + $MengeRotterdam : $MengeRotterdam;
                    //echo("<br>  FR  ".$MengeRotterdam." -> ".$MengeBarcelona."  -> ".$ret[$zahl]['Barcelona'] ." -> ". $ret[$zahl]['Rotterdam']." <br>");
                }
            } else {
                $ret[$zahl][$haefen[$menge->PPProduktpass_Menge_Country]["Hafen1"]] = isset($ret[$zahl][$haefen[$menge->PPProduktpass_Menge_Country]["Hafen1"]]) ? $ret[$zahl][$haefen[$menge->PPProduktpass_Menge_Country]["Hafen1"]] + $mengeLand : $mengeLand;
            }
            $ret[$zahl]['Kolli'] = $menge->PPProduktpass_Menge_Kolli;
            $ret[$zahl]['LB'] = $zahl;
        }
        //echo("<pre>");var_dump($ret); exit;
        if (count($ret) > 0) return $ret;
        return false;
    }
    public function getAbgangshaefen()
    {
        $haefen = DB::table('PPAbgangshafen')->get();
        //var_dump($haefen); exit;
        foreach ($haefen as $hafen) {
            $ret[$hafen->PPAbgangshafen_Id] = $hafen->PPAbgangshafen_Hafen;
        }
        ksort($ret, SORT_ASC);
        return $ret;
    }
    public function getLidlhaefen()
    {
        $haefen = DB::table('PPHaefen')->get();
        //var_dump($haefen); exit;
        foreach ($haefen as $hafen) {
            $ret[$hafen->PPHaefen_Nr] = $hafen->PPHaefen_Name;
        }
        $ret[" "] = "   ";
        ksort($ret, SORT_ASC);
        return $ret;
    }
    public function getHerkunftslaender()
    {
        $laender = DB::table('PPHerkunftslaender')->orderby('PPHerkunftslaender_Id')->get();
        //var_dump($haefen); exit;
        foreach ($laender as $land) {
            $ret[$land->PPHerkunftslaender_Id] = $land->PPHerkunftslaender_Land;
        }
        //ksort($ret,SORT_ASC);
        return $ret;
    }
    public function getMengeMenge($ppid)
    {
        $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)->get();
        if ($mengen) {
            $total = 0;
            foreach ($mengen as $menge) {
                $total += $menge->PPProduktpass_Menge_Quantity;
            }
            return $total;
        }
        return 0;
    }
    public function getLieferlaender($id)
    {
        $ret = array();
        $cmengen = DB::table('PPProduktpass_Menge')->select(DB::raw('	PPProduktpass_Menge_Quantity as sumCountry, PPProduktpass_Menge_Country as Country, PPProduktpass_Menge_Id as Id,
							PPProduktpass_Menge_DeliveryWeek as Lt,
							PPProduktpass_Menge_VKFOBEUR as VK,
							PPProduktpass_Menge_CBVK as CBVK ,
							PPProduktpass_Menge_Countrysizes as Size,
                            PPProduktpass_Menge_CountryGSM as gsm,
							PPProduktpass_Menge_CountryBlock as CB,
							PPProduktpass_Menge_LT1 as LT1,
							PPProduktpass_Menge_LT2 as LT2,
							PPProduktpass_Menge_LT3 as LT3,
							PPProduktpass_Menge_LT1Menge as LT1Menge,
							PPProduktpass_Menge_LT2Menge as LT2Menge,
							PPProduktpass_Menge_LT3Menge as LT3Menge,
							PPProduktpass_Menge_Kolli as Kolli,
							PPProduktpass_Menge_CBEK as CBEK,
							PPProduktpass_Menge_EKUSD as EK,
							PPProduktpass_Menge_CartonSize as CartonSize,
							PPProduktpass_Menge_PcsPerCarton as PcsPerCarton,
							PPProduktpass_Menge_CartonPerPal as CartonPerPal,
							PPProduktpass_Menge_Trucks as Trucks
							'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->orderBy('PPProduktpass_Menge_Id', 'ASC')->get();
        foreach ($cmengen as $menge) {
            $ret[] = array('Country' => $menge->Country, 'sumCountry' => $menge->sumCountry, 'id' => $menge->Id, 'Lt' => $menge->Lt, 'VK' => $menge->VK, 'CBVK' => $menge->CBVK, 'Size' => $menge->Size, 'gsm' => $menge->gsm, 'CB' => $menge->CB, 'LT1' => $menge->LT1, 'LT2' => $menge->LT2, 'LT3' => $menge->LT3, 'LT1Menge' => $menge->LT1Menge, 'LT2Menge' => $menge->LT2Menge, 'LT3Menge' => $menge->LT3Menge, 'Kolli' => $menge->Kolli, 'CBEK' => $menge->CBEK, 'EK' => $menge->EK, 'CartonSize' => $menge->CartonSize, 'PcsPerCarton' => $menge->PcsPerCarton, 'CartonPerPal' => $menge->CartonPerPal, 'Trucks' => $menge->Trucks);
        }
        //var_dump($ret);
        //exit;
        return $ret;
    }
    public function getLaenderBloecke($id)
    {
        $ret = array();
        $cmengen = DB::table('PPProduktpass_Menge')->select(DB::raw('sum(PPProduktpass_Menge_Quantity) as sumCountryBlock, PPProduktpass_Menge_CountryBlock as CountryBlock, PPProduktpass_Menge_CBEK as CBEK'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->groupBy('PPProduktpass_Menge_CountryBlock', 'PPProduktpass_Menge_CBEK')->get();
        foreach ($cmengen as $menge) {
            $ret[$menge->CountryBlock] = array('CountryBlock' => $menge->CountryBlock, 'sumCountryBlock' => $menge->sumCountryBlock, 'CBEK' => $menge->CBEK);
        }
        //var_dump($ret); exit;
        return $ret;
    }
    public function getCountryblockSizes($id)
    {
        $ret = array();
        $csizes = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_CountryBlock, PPProduktpass_Menge_Countrysizes, PPProduktpass_Menge_Country'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get();
        foreach ($csizes as $size) {
            $ret[$size->PPProduktpass_Menge_CountryBlock] = array('CountryBlock' => $size->PPProduktpass_Menge_CountryBlock, 'Size' => $size->PPProduktpass_Menge_Countrysizes);
        }
        //var_dump($ret); exit;
        return $ret;
    }
    public function getProjectPacking($projekt)
    {
        $projekt1 = DB::table('PPProduktpass')->select(DB::raw('PPProduktpass_Id'))->where('PPProduktpass_PPProjekte_Projekt', '=', $projekt)->where('PPProduktpass_IAN', 'not like', "%Rev%")->orderBy('PPProduktpass_IAN')->first();
        if ($projekt1) {
            $po = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $projekt1->PPProduktpass_Id)->first();
            if ($po) return $po->PPPurchase_Translate_Packaging;
        }
        return "";
    }
    /*    public function getProjectPacking($projekt) {
      $projekt = DB::table('PPProduktpass')
      ->select(DB::raw('PPProduktpass_Id'))
      ->where('PPProduktpass_PPProjekte_Projekt', '=', $projekt)
      ->orderBy('PPProduktpass_Id')->first();
      if (count($projekt) > 0) {
      $po = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $projekt->PPProduktpass_Id)->first();
      if (count($po) > 0)
      return $po->PPPurchase_Translate_Packaging;
      }
      return "";
      }
    */
    public function createArtikelERP()
    {
        $ppid = Input::get('createArtikelPPID');
        return $this->getArtikelVorlage($ppid);
    }
    public function getMengeLand($id, $land)
    {
        $lmenge = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Quantity, PPProduktpass_Menge_Kolli, PPProduktpass_Menge_Country'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->where('PPProduktpass_Menge_Country', 'like', $land)->first();
        //$aLB = array();
        if ($lmenge) {
            $aLB = array('Menge' => $lmenge->PPProduktpass_Menge_Quantity, 'VE' => $lmenge->PPProduktpass_Menge_Kolli, 'Country' => $lmenge->PPProduktpass_Menge_Country);
            //var_dump($aLB); exit;
            return $aLB;
        }
        return array('Menge' => 0, 'VE' => 0, 'Country' => '');
    }
    public function getMengeEU($id)
    {
        $EUMengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get();
        //$aLB = array();
        $de  = $this->getMengeDE($id);
        $mtotal = 0;
        if ($EUMengen) {
            foreach($EUMengen as $m){
                $mtotal = $mtotal + $m->PPProduktpass_Menge_Quantity;
            }
            $aLB = array('Menge' => $mtotal - $de['Menge'], 'VE' => $m->PPProduktpass_Menge_Kolli, 'Country' => 'EU');
            //var_dump($aLB); exit;
            return $aLB;
        }
        return array('Menge' => 0, 'VE' => 0, 'Country' => 'EU');
    }
    public function getMengeDE($id)
    {
        $EUMengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->where('PPProduktpass_Menge_Country', 'like', 'DE')->get();
        //$aLB = array();
        $mtotal = 0;
        $ve = '';
        if ($EUMengen) {
            foreach($EUMengen as $m){
                $mtotal = $mtotal + $m->PPProduktpass_Menge_Quantity;
                $ve = $m->PPProduktpass_Menge_Kolli;
            }
            $aLB = array('Menge' => $mtotal, 'VE' => $ve, 'Country' => 'DE');
            //var_dump($aLB); exit;
            return $aLB;
        }
        return array('Menge' => 0, 'VE' => 0, 'Country' => 'DE');
    }
    public function getMengeOS($id, $lb = "%")
    {
        //echo("ID: $id , LB: $lb <br>");
        if ($lb != "%") {
            $posOS = strpos($lb, "OS");
            if ($posOS !== false) {
                $lb = substr($lb, $posOS + 2, 2);
            }
        }
        $osmengen = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Quantity, PPProduktpass_Menge_Kolli, PPProduktpass_Menge_Country'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->where('PPProduktpass_Menge_Country', 'like', '' . 'OS' . $lb)->get();
        $aLB = array();
        //var_dump($osmengen);
        cpcDebug::cpc_debug("ID: $id , LB: $lb ", "TESTOS");
        if (count($osmengen) > 0) {
            $osGB_found = false;
            $osFR_found = false;
            foreach ($osmengen as $osmenge) {
                if ($osmenge->PPProduktpass_Menge_Country == "OSGB") $osGB_found = true;
                if ($osmenge->PPProduktpass_Menge_Country == "OSFR") $osFR_found = true;
                if ($osmenge->PPProduktpass_Menge_Quantity > 0) {
                    if ($osmenge->PPProduktpass_Menge_Quantity > 0) {
                        $aLB[] = array('Menge' => $osmenge->PPProduktpass_Menge_Quantity, 'VE' => $osmenge->PPProduktpass_Menge_Kolli, 'Country' => $osmenge->PPProduktpass_Menge_Country, 'Status' => '1');
                    }
                }
            }
            //if (!$osGB_found)
            //$aLB[] = array('Menge' => 0, 'VE' => 0, 'Country' => 'OSGB', 'Status' => '0');
            //if (!$osFR_found)
            //$aLB[] = array('Menge' => 0, 'VE' => 0, 'Country' => 'OSFR', 'Status' => '0');
        }
        if (count($aLB) > 0) {
            return $aLB;
        }
        return array(0 => array('Menge' => 0, 'VE' => 0, 'Country' => '', 'Status' => '0'));
    }
    private function getMengeFinal($id)
    {
        $mengeFinal = PPProduktpass_Menge_Final::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get();
        $ret = array();
        if ($mengeFinal) {
            foreach ($mengeFinal as $mf) {
                $ret[$mf->PPProduktpass_Menge_Country] = $mf;
            }
            return $ret;
        }
        return false;
    }
    public function getMengeOSProLand($id)
    {
        $osmengen = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Quantity, PPProduktpass_Menge_Kolli, PPProduktpass_Menge_Country'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->where('PPProduktpass_Menge_Country', 'like', 'OS%')->get();
        $aLB = array();
        if (count($osmengen) > 0) {
            foreach ($osmengen as $osmenge) {
                $aLB[$osmenge->PPProduktpass_Menge_Country] = array('Menge' => $osmenge->PPProduktpass_Menge_Quantity, 'VE' => $osmenge->PPProduktpass_Menge_Kolli);
            }
            return $aLB;
        }
        return array('Menge' => 0, 'VE' => 0, 'Country' => '');
    }
    public function gethafenAufteilung($id)
    {
        //echo("hafenAufeilung: $id ");
        $aufteilung = array("FRRTD" => 60, "FRBAR" => 40, "ITBAR" => 45, "ITKOP" => 55);
        $ab = PPAB::where("PPAB_PPProduktpass_Id", $id)->get()->first();
        if ($ab) {
            if (isset($ab->PPAB_Aufteilung_Rotterdam_FR) && $ab->PPAB_Aufteilung_Rotterdam_FR > 0) {
                $aufteilung["FRRTD"] = $ab->PPAB_Aufteilung_Rotterdam_FR;
                $aufteilung["FRBAR"] = 100 - $ab->PPAB_Aufteilung_Rotterdam_FR;
            }
            if (isset($ab->PPAB_Aufteilung_Barcelona_IT) && $ab->PPAB_Aufteilung_Barcelona_IT > 0) {
                $aufteilung["ITBAR"] = $ab->PPAB_Aufteilung_Barcelona_IT;
                $aufteilung["ITKOP"] = 100 - $ab->PPAB_Aufteilung_Barcelona_IT;
            }
        }
        /* var_dump($aufteilung);echo("<br>HIER: $ab->PPAB_Aufteilung_Rotterdam_FR <br>
          $ab->PPAB_Aufteilung_Barcelona_FR <br>
          $ab->PPAB_Aufteilung_Barcelona_IT <br>
          $ab->PPAB_Aufteilung_Koper_IT <br>
          ############<br>"); */
        return $aufteilung;
    }
    public function _getMengeHafen($mng, $hafen, $aufteilung2)
    {
        //echo("Start <b>$hafen</b> Land: $mng->PPProduktpass_Menge_Country Menge: $mng->PPProduktpass_Menge_Quantity  Karton: $mng->PPProduktpass_Menge_Kolli $hafen <br> <pre>");
        //echo("<pre>");var_dump($mng); echo("<br>");exit;
        $aufteilung = $this->gethafenAufteilung($mng->PPProduktpass_Menge_PPProduktpass_Id);
        $ret_menge = $mng->PPProduktpass_Menge_Quantity;
        $ret_kolli = ($mng->PPProduktpass_Menge_Kolli == 0) ? 0 : $ret_kolli = $mng->PPProduktpass_Menge_Quantity / $mng->PPProduktpass_Menge_Kolli;
        if ($mng->PPProduktpass_Menge_Country == "FR" && $hafen == "Rotterdam") {
            $ret_menge = ceil($mng->PPProduktpass_Menge_Quantity * $aufteilung["FRRTD"] / 100);
            $ret_kolli = $ret_kolli * $aufteilung["FRRTD"] / 100;
        }
        if ($mng->PPProduktpass_Menge_Country == "FR" && $hafen == "Barcelona") {
            $ret_menge = ceil($mng->PPProduktpass_Menge_Quantity * $aufteilung["FRBAR"] / 100);
            $ret_kolli = $ret_kolli * $aufteilung["FRBAR"] / 100;
        }
        if ($mng->PPProduktpass_Menge_Country == "IT" && $hafen == "Barcelona") {
            ceil($ret_menge = $mng->PPProduktpass_Menge_Quantity * $aufteilung["ITBAR"] / 100);
            $ret_kolli = $ret_kolli * $aufteilung["ITBAR"] / 100;
        }
        if ($mng->PPProduktpass_Menge_Country == "IT" && $hafen == "Koper") {
            ceil($ret_menge = $mng->PPProduktpass_Menge_Quantity * $aufteilung["ITKOP"] / 100);
            $ret_kolli = $ret_kolli * $aufteilung["ITKOP"] / 100;
        }
        //echo("ERG: $ret_menge $ret_kolli <br>................................<br>");
        return array("Menge" => $ret_menge, "Kolli" => $ret_kolli);
    }
    public function getMengeHafen($id, $hafen)
    {
        // Rotterdam: DE OS NL BE FI SE DK GB IE FR LT
        // Barcelona: ES PT IT FR
        // Koper: AT GR PL CZ SK HU SI CY BG RO IT HR CH
        if ($hafen == "Rotterdam") {
            $sql = 'PPProduktpass_Menge_PPProduktpass_Id = ' . $id;
            $sql .= ' and ( PPProduktpass_Menge_Country = "DE" or (PPProduktpass_Menge_Country like "OS%" and PPProduktpass_Menge_Country not like "OSES") ';
            $sql .= ' or PPProduktpass_Menge_Country = "NL" ';
            $sql .= ' or PPProduktpass_Menge_Country = "BE" ';
            $sql .= ' or PPProduktpass_Menge_Country = "FI" ';
            $sql .= ' or PPProduktpass_Menge_Country = "SE" ';
            $sql .= ' or PPProduktpass_Menge_Country = "IE" ';
            $sql .= ' or PPProduktpass_Menge_Country = "DK" ';
            $sql .= ' or PPProduktpass_Menge_Country = "GB" ';
            $sql .= ' or PPProduktpass_Menge_Country = "IE" ';
            $sql .= ' or PPProduktpass_Menge_Country = "FR" ';
            $sql .= ' or PPProduktpass_Menge_Country = "LT" ';
            $sql .= ' or PPProduktpass_Menge_Country = "NI" ';
            $sql .= ' or PPProduktpass_Menge_Country = "EE" ';
            $sql .= ' or PPProduktpass_Menge_Country = "LV"  ';
            // CB10 Kaufland
            $sql .= ' or PPProduktpass_Menge_Country = "KODE" ';
            $sql .= ' or PPProduktpass_Menge_Country = "KDE" )';
            $mengen = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Country, PPProduktpass_Menge_Quantity, PPProduktpass_Menge_PPProduktpass_Id, PPProduktpass_Menge_Kolli'))->whereRaw($sql)->get();
        }
        if ($hafen == "Koper") {
            $sql = 'PPProduktpass_Menge_PPProduktpass_Id = ' . $id;
            $sql .= ' and ( PPProduktpass_Menge_Country = "AT" ';
            $sql .= ' or PPProduktpass_Menge_Country = "GR" ';
            $sql .= ' or PPProduktpass_Menge_Country = "PL" ';
            $sql .= ' or PPProduktpass_Menge_Country = "CZ"';
            $sql .= ' or PPProduktpass_Menge_Country = "SK" ';
            $sql .= ' or PPProduktpass_Menge_Country = "HU"';
            $sql .= ' or PPProduktpass_Menge_Country = "SI" ';
            $sql .= ' or PPProduktpass_Menge_Country = "CY"';
            $sql .= ' or PPProduktpass_Menge_Country = "BG" ';
            $sql .= ' or PPProduktpass_Menge_Country = "RO" ';
            $sql .= ' or PPProduktpass_Menge_Country = "IT"  ';
            $sql .= ' or PPProduktpass_Menge_Country = "RS" ';
            $sql .= ' or PPProduktpass_Menge_Country = "HR" ';
            $sql .= ' or PPProduktpass_Menge_Country = "CH" ';
            //CB10 Kaufland
            $sql .= ' or PPProduktpass_Menge_Country = "KCZ" ';
            $sql .= ' or PPProduktpass_Menge_Country = "KPL" ';
            $sql .= ' or PPProduktpass_Menge_Country = "KRO" ';
            $sql .= ' or PPProduktpass_Menge_Country = "KSK" ';
            $sql .= ' or PPProduktpass_Menge_Country = "KHR" ';
            $sql .= ' or PPProduktpass_Menge_Country = "KBG" )';
            $mengen = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Country, PPProduktpass_Menge_Quantity, PPProduktpass_Menge_PPProduktpass_Id, PPProduktpass_Menge_Kolli'))->whereRaw($sql)->get();
        }
        if ($hafen == "Barcelona") {
            $sql = 'PPProduktpass_Menge_PPProduktpass_Id = ' . $id;
            $sql .= ' and ( PPProduktpass_Menge_Country = "ES" or PPProduktpass_Menge_Country = "OSES" ';
            $sql .= ' or PPProduktpass_Menge_Country = "PT"';
            $sql .= ' or PPProduktpass_Menge_Country = "IT"';
            $sql .= ' or PPProduktpass_Menge_Country = "FR" ';
            $sql .= ' or PPProduktpass_Menge_Country = "MT" )';
            $mengen = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Country, PPProduktpass_Menge_Quantity, PPProduktpass_Menge_PPProduktpass_Id, PPProduktpass_Menge_Kolli'))->whereRaw($sql)->get();
        }
        if ($hafen == "Richmond") {
            $sql = 'PPProduktpass_Menge_PPProduktpass_Id = ' . $id;
            $sql .= ' and ( PPProduktpass_Menge_Country = "US" )';
            $mengen = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Country, PPProduktpass_Menge_Quantity, PPProduktpass_Menge_PPProduktpass_Id, PPProduktpass_Menge_Kolli'))->whereRaw($sql)->get();
        }
        $aufteilung = $this->gethafenAufteilung($id);
        $res_menge = 0;
        $res_kolli = 0;
        if (count($mengen) > 0) {
            foreach ($mengen as $menge) {
                $_mengen = $this->_getMengeHafen($menge, $hafen, $aufteilung);
                $res_menge += $_mengen["Menge"];
                $res_kolli += $_mengen["Kolli"];
            }
        }
        $ret_arr = array('Menge' => $res_menge, 'VE' => $res_kolli);
        //echo("<pre>");var_dump($ret); exit;
        return $ret_arr;
    }
    public function getMengeTotal($id)
    {
        $tmenge = DB::table('PPProduktpass_Menge')->select(DB::raw('sum(PPProduktpass_Menge_Quantity) as total'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->first();
        if ($tmenge) {
            return $tmenge->total;
        }
        //var_dump($ret); exit;
        return 0;
    }
    public function getPrices($id)
    {
        $ret = array();
        $rows = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Country as Country, PPProduktpass_Menge_CountryBlock as CountryBlock,
		PPProduktpass_Menge_Quantity as Menge,
		PPProduktpass_Menge_CBEK as CBEK,
		PPProduktpass_Menge_EKUSD as EK,
		PPProduktpass_Menge_CBVK as CBVK,
		PPProduktpass_Menge_VKFOBEUR as VK'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Menge_CountryBlock')->get();
        //var_dump($rows); exit;
        $lek = array();
        foreach ($rows as $row) {
            if ($row->Menge > 0) {
                $lek[] = array('Country' => $row->Country, 'Menge' => $row->Menge, 'CBEK' => $row->CBEK, 'EK' => $row->EK, 'CBVK' => $row->CBVK, 'VK' => $row->VK);
            }
        }
        $purchase = DB::table('PPPurchase')->select(DB::raw('PPPurchase_EK as EK'))->where('PPPurchase_PPProduktpass_Id', '=', $id)->first();
        $ret['EK'] = $purchase->EK;
        $ret['LaenderEK'] = $lek;
        return $ret;
    }
    public function getLaenderProBlock($id)
    {
        $ret = array();
        $rows = DB::table('PPProduktpass_Menge')->select(DB::raw('PPProduktpass_Menge_Country as Country, PPProduktpass_Menge_CountryBlock as CountryBlock,PPProduktpass_Menge_Quantity as Menge, PPProduktpass_Menge_CBEK as CBEK, PPProduktpass_Menge_EKUSD as EK'))->where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Menge_CountryBlock')->get();
        //var_dump($rows); exit;
        $ret = array();
        foreach ($rows as $row) {
            if (isset($ret[$row->CountryBlock])) {
                if ($row->Menge > 0) {
                    $ret[$row->CountryBlock] = $ret[$row->CountryBlock] . ", " . $row->Country;
                }
            } else {
                if ($row->Menge > 0) {
                    $ret[$row->CountryBlock] = $row->Country;
                }
            }
        }
        //var_dump($ret); exit;
        return $ret;
    }
    public function getQualitaetPO($id)
    {
        $ret = array();
        $rows = DB::table('PPProduktpass_Qualitaet')->select(DB::raw('*'))->where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Qualitaet_Id')->get();
        //var_dump($rows); exit;
        $str = " ";
        foreach ($rows as $row) {
            $value = "";
            for ($i = 1; $i <= 15; $i++) {
                $ndx = "PPProduktpass_Qualitaet_Value" . $i;
                if ($i < 10) {
                    $ndx = "PPProduktpass_Qualitaet_Value0" . $i;
                }
                if (strlen($row->$ndx) > 0) {
                    if (strpos($value, $row->$ndx) === false) {
                        $str .= $row->PPProduktpass_Qualitaet_Header . " " . $row->$ndx . "<br>";
                        $value .= $row->$ndx;
                    }
                }
            }
        }
        //var_dump($ret); exit;
        return $str;
    }
    public function getQualitaet($id)
    {
        $rows = DB::table('PPProduktpass_Qualitaet')->select(DB::raw('PPProduktpass_Qualitaet_Header, PPProduktpass_Qualitaet_Value01'))->where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Qualitaet_Id')->get();
        //var_dump($rows); exit;
        return $rows;
    }
    function getSummeValue($row)
    {
        $att = "PPProduktpass_Sortierung_Value0";
        $sum = 0;
        for ($i = 2; $i < 10; $i++) {
            $field = $att . $i;
            if (!is_null($row->$field)) {
                try {
                    $sum += $row->$field;
                } catch (Exception $e) {
                    //echo($field . " " . $row->$field . "<br>");
                }
            }
        }
        return $sum;
    }
    public function getSortierung($id)
    {
        $trans = $this->getStyleTranslation($id);
        $rows = DB::table('PPProduktpass_Sortierung')->select(DB::raw('PPProduktpass_Sortierung_Header,  PPProduktpass_Sortierung_Value01,
		PPProduktpass_Sortierung_Value02, PPProduktpass_Sortierung_Value03, PPProduktpass_Sortierung_Value04, PPProduktpass_Sortierung_Value05, PPProduktpass_Sortierung_Value06,
        PPProduktpass_Sortierung_Value07, PPProduktpass_Sortierung_Value08, PPProduktpass_Sortierung_Value09, PPProduktpass_Sortierung_Value10,
        PPProduktpass_Sortierung_Size01, PPProduktpass_Sortierung_Size02, PPProduktpass_Sortierung_Size03, PPProduktpass_Sortierung_Size04, PPProduktpass_Sortierung_Size05,
        PPProduktpass_Sortierung_Size06, PPProduktpass_Sortierung_Size07, PPProduktpass_Sortierung_Size08, PPProduktpass_Sortierung_Size08,  PPProduktpass_Sortierung_Size09,
		PPProduktpass_Sortierung_EAN, PPProduktpass_Sortierung_EAN02, PPProduktpass_Sortierung_EAN03, PPProduktpass_Sortierung_EAN04, PPProduktpass_Sortierung_EAN05, PPProduktpass_Sortierung_EAN06, PPProduktpass_Sortierung_EAN07, PPProduktpass_Sortierung_EAN08, PPProduktpass_Sortierung_EAN09, PPProduktpass_Sortierung_EAN10,
		PPProduktpass_Sortierung_EANOS, PPProduktpass_Sortierung_OSMengeDE,PPProduktpass_Sortierung_OSMengePL,PPProduktpass_Sortierung_OSMengeSK, PPProduktpass_Sortierung_OSMengeGB,PPProduktpass_Sortierung_OSMengeFR, PPProduktpass_Sortierung_OSMengeBE, PPProduktpass_Sortierung_OSMengeNL,PPProduktpass_Sortierung_OSMengeCZ,PPProduktpass_Sortierung_OSMengeES,
                                     PPProduktpass_Sortierung_Id, PPProduktpass_Sortierung_Translate_Design, PPProduktpass_Sortierung_Laenderblock, instr(PPProduktpass_Sortierung_Laenderblock, "OS") AS SortOrder'))->where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)->orderBy("SortOrder")->orderby('PPProduktpass_Sortierung_Laenderblock')->orderby('PPProduktpass_Sortierung_Header')->get();
        //echo("<pre>");var_dump($rows); echo("</pre>");exit;
        $ret = array();
        $oslaender = $this->getOSLaender();
        foreach ($oslaender as $land) {
            $aOSTotal[$land] = 0;
        }
        foreach ($rows as $row) {
            $sumVal = $this->getSummeValue($row);
            // if (floatval($row->PPProduktpass_Sortierung_Value02)  >= 0) {
            if (floatval($sumVal) >= 0) {
                $ret[$row->PPProduktpass_Sortierung_Id]['max'] = -1;
                $ret[$row->PPProduktpass_Sortierung_Id]['id'] = $row->PPProduktpass_Sortierung_Id;
                $ret[$row->PPProduktpass_Sortierung_Id]['header'] = $row->PPProduktpass_Sortierung_Header;
                $ret[$row->PPProduktpass_Sortierung_Id]['design'] = $row->PPProduktpass_Sortierung_Value01;
                $design = "";
                if ($trans) {
                    if (strpos($row->PPProduktpass_Sortierung_Header, "/") === false) {
                        //echo("1:" . $row->PPProduktpass_Sortierung_Header);
                        if (isset($trans[$row->PPProduktpass_Sortierung_Header]['Value01']) and strlen($trans[$row->PPProduktpass_Sortierung_Header]['Value01']) > 0) {
                            $design = $trans[$row->PPProduktpass_Sortierung_Header]['Value01'];
                        }
                    } else {
                        $setArray = explode("/", $row->PPProduktpass_Sortierung_Header);
                        //echo(">1:" . $row->PPProduktpass_Sortierung_Header);
                        $trenner = "";
                        foreach ($setArray as $valH) {
                            if (strlen($design) > 2) {
                                $trenner = "/";
                            }
                            $design .= $trenner . $trans[$valH]['Value01'];
                        }
                    }
                }
                $ret[$row->PPProduktpass_Sortierung_Id]['translate_design'] = $design;
                $xMenge = 0;
                if ($row->PPProduktpass_Sortierung_Value02 != 0) {
                    $xMenge = $row->PPProduktpass_Sortierung_Value02;
                }
                if ($row->PPProduktpass_Sortierung_Value03 != 0) {
                    $xMenge = $row->PPProduktpass_Sortierung_Value03;
                }
                $ret[$row->PPProduktpass_Sortierung_Id]['menge'] = $xMenge;
                //echo("<br>".$ret[$row->PPProduktpass_Sortierung_Id]['header']." -- ".$ret[$row->PPProduktpass_Sortierung_Id]['menge']."<br>");
                $ret[$row->PPProduktpass_Sortierung_Id]['amenge'] = array();
                $imax = -1;
                $amenge = array();
                for ($k = 2; $k < 10; $k++) {
                    $att = "PPProduktpass_Sortierung_Value0" . $k;
                    $amenge[$k - 2] = $row->$att;
                    if (isset($amenge[$k - 2]) and $amenge[$k - 2] > 0) {
                        $imax = $k - 2;
                    }
                }
                for ($k = 2; $k < 10; $k++) {
                    $att = "PPProduktpass_Sortierung_Size0" . $k;
                    if (strlen(trim($row->$att)) > 1) {
                        $imax = $k;
                    }
                }
                if ($imax == 1) $imax = -1;
                $ret[$row->PPProduktpass_Sortierung_Id]['amenge'] = $amenge;
                if ($ret[$row->PPProduktpass_Sortierung_Id]['max'] < $imax) {
                    $ret[$row->PPProduktpass_Sortierung_Id]['max'] = $imax;
                }
                $ret[$row->PPProduktpass_Sortierung_Id]['EAN'] = $row->PPProduktpass_Sortierung_EAN;
                $aean = array();
                $aean[1] = $row->PPProduktpass_Sortierung_EAN;
                for ($k = 2; $k < 10; $k++) {
                    $att = "PPProduktpass_Sortierung_EAN0" . $k;
                    $aean[$k] = $row->$att;
                }
                //echo('<pre>');var_dump($aean);exit;
                $hasSizeSort = false;
                $size = array();
                for ($k = 1; $k < 9; $k++) {
                    $att = "PPProduktpass_Sortierung_Size0" . $k;
                    $attribute = $row->$att;
                    if (strlen(trim($row->$att)) > 0 and (strpos($attribute, "Style Breakdown") === false)) {
                        $hasSizeSort = true;
                        //echo("in der tat");exit;
                        $ret[$row->PPProduktpass_Sortierung_Id]['max'] = $k;
                    }
                    $size[$k] = $row->$att;
                }
                // Hole Grössen/Mengen Tabelle (OS) zur Sortierung
                $sortId = $row->PPProduktpass_Sortierung_Id;
                $oslaender = $this->getOSLaender(); //array('DE', 'BE', 'NL', 'CZ', 'ES', 'GB', 'FR', 'PL', 'SK', 'AT');
                $OSMengenSizeLaender = array();
                $hasOSSizeSort = $hasSizeSort;
                foreach ($oslaender as $land) {
                    //echo("$land <br>");
                    $OSMengen = array();
                    $OSTotal = 0;
                    if ((PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $sortId)->count() > 0)) {
                        //$hasOSSizeSort = True;
                        $lm = PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $sortId)->first();
                        $xMenge = 0;
                        for ($k = 1; $k <= 9; $k++) {
                            $att = "PPProduktpass_OSSortMengen_OSMengeSize0" . $k;
                            $OSMengen[$k] = $lm->$att;
                            $OSTotal += $lm->$att;
                            $xMenge += $lm->$att;
                            // echo("$k : $xMenge <br>");
                        }
                        $OSMengenLaender[$land] = $OSMengen;
                        if ($xMenge > 0) {
                            $hasOSSizeSort = True;
                        }
                    } else {
                        for ($k = 1; $k <= 9; $k++) {
                            $OSMengen[$k] = 0;
                        }
                        $OSMengenLaender[$land] = $OSMengen;
                        // print_r($OSMengen);
                    }
                    $aOSTotal[$land] += $OSTotal;
                    // print_r($OSMengen);
                }
                //echo("<pre>");var_dump($aOSTotal);
                //echo('<pre>');var_dump($OSMengenLaender);exit;
                $ret[$row->PPProduktpass_Sortierung_Id]['Id'] = $row->PPProduktpass_Sortierung_Id;
                $ret[$row->PPProduktpass_Sortierung_Id]['hasOSSizeSort'] = $hasOSSizeSort;
                $ret[$row->PPProduktpass_Sortierung_Id]['aOSMenge'] = $OSMengenLaender;
                $ret[$row->PPProduktpass_Sortierung_Id]['aOSLaender'] = $this->getOSLaender();
                $ret[$row->PPProduktpass_Sortierung_Id]['aOSTotal'] = $aOSTotal;
                $ret[$row->PPProduktpass_Sortierung_Id]['AEAN'] = $aean;
                $ret[$row->PPProduktpass_Sortierung_Id]['SIZE'] = $size;
                $ret[$row->PPProduktpass_Sortierung_Id]['EANOS'] = $row->PPProduktpass_Sortierung_EAN;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeDE'] = $row->PPProduktpass_Sortierung_OSMengeDE;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeBE'] = $row->PPProduktpass_Sortierung_OSMengeBE;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeNL'] = $row->PPProduktpass_Sortierung_OSMengeNL;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeCZ'] = $row->PPProduktpass_Sortierung_OSMengeCZ;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeES'] = $row->PPProduktpass_Sortierung_OSMengeES;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeGB'] = $row->PPProduktpass_Sortierung_OSMengeGB;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeFR'] = $row->PPProduktpass_Sortierung_OSMengeFR;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengePL'] = $row->PPProduktpass_Sortierung_OSMengePL;
                $ret[$row->PPProduktpass_Sortierung_Id]['OSMengeSK'] = $row->PPProduktpass_Sortierung_OSMengeSK;
                $ret[$row->PPProduktpass_Sortierung_Id]['Laenderblock'] = $row->PPProduktpass_Sortierung_Laenderblock;
            }
        }
        /* echo("<pre>");
          print_r($ret);
          echo("</pre>");
          exit; */
        return $ret;
    }
    private function _getStatiX($art)
    {
        $stati = PPStatiX::where('PPStati_Art', '=', $art)->get();
        $ret = array();
        foreach ($stati as $status) {
            $ret[$status->PPStati_Id] = $status->PPStati_Status;
        }
        return $ret;
    }
    public function getGreenLevel()
    {
        $ret = $this->getListboxwithId('GreenLevel', False);
        //var_dump($ret);
        return $ret;
    }
    private function getUmverpackungen()
    {
        $ret = $this->getListboxSimple('LidlVerpackungen', True);
        return $ret;
    }
    private function getListboxSimple($type, $sort = false)
    {
        if ($sort) {
            $uvs = PPListBoxes::where('PPListBoxes_Type', '=', $type)->orderBy('PPListBoxes_Value')->get();
        } else {
            $uvs = PPListBoxes::where('PPListBoxes_Type', '=', $type)->orderBy('PPListBoxes_Ident')->get();
        }
        $ret = array("Bitte auswählen..." => "Bitte auswählen...");
        foreach ($uvs as $uv) {
            if (strpos($uv->PPListBoxes_Value, "***") === False) {
                $ret[$uv->PPListBoxes_Value] = $uv->PPListBoxes_Value;
            }
        }
        return $ret;
    }
    private function getListboxwithId($type, $sort = false)
    {
        if ($sort) {
            $uvs = PPListBoxes::where('PPListBoxes_Type', '=', $type)->orderBy('PPListBoxes_Value')->get();
        } else {
            $uvs = PPListBoxes::where('PPListBoxes_Type', '=', $type)->orderBy('PPListBoxes_Ident')->get();
        }
        $ret = array(0 => "Bitte auswählen...");
        foreach ($uvs as $uv) {
            if (strpos($uv->PPListBoxes_Value, "***") === False) {
                $ret[$uv->PPListBoxes_Ident] = $uv->PPListBoxes_Value;
            }
        }
        return $ret;
    }
    private function getBWGroessen()
    {
        $bwgs = DB::table('PPBW_Laendergroessen')->select(DB::raw('distinct PPBW_Laendergroessen_Groesse'))
            //-> groupBy('PPProduktpass_Menge_CountryBlock')
            ->get();
        $ret = array("Bitte auswählen..." => "Bitte auswählen...");
        $ret["Andere als BW"] = "Andere als BW";
        foreach ($bwgs as $bg) {
            $ret[$bg->PPBW_Laendergroessen_Groesse] = $bg->PPBW_Laendergroessen_Groesse;
        }
        return $ret;
    }
    private function get8WPositionen($id)
    {
        $poss = DB::table('v_8WPositionen')->where("PPProduktpass_Id", "=", $id)->get();
        foreach ($poss as $pos) {
            $ret[$pos->PPProduktpass_Id]['Description']['IAN'] = $pos->PPProduktpass_IAN;
            $ret[$pos->PPProduktpass_Id]['Description']['Bezeichnung'] = $pos->PPProduktpass_Artikelbezeichnung;
            $ret[$pos->PPProduktpass_Id]['IAN'] = $pos->PPProduktpass_IAN;
            $ret[$pos->PPProduktpass_Id][$pos->PPProduktpass_Style_Header] = $pos;
            $ret[$pos->PPProduktpass_Style_Header] = $pos;
        }
        return $ret;
    }
    private function getStyleImages($id)
    {
        $imgs = PPPPFiles::where('PPPPFiles_Type', '=', "Designs")->where('PPPPFiles_PPProduktpass_Id', '=', $id)->orderBy('PPPPFiles_Name')->get();
        $ret = array("0" => "Bitte auswählen...");
        foreach ($imgs as $img) {
            $ret[$img->PPPPFiles_Id] = substr($img->PPPPFiles_Name, 7, strlen($img->PPPPFiles_Name));
        }
        return $ret;
    }
    public function getStyles($id)
    {
        $si = $this->getStyleImagesArray($id);
        //var_dump($si);exit;
        $imgs = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', '=', $id)->orderBy('PPProduktpass_Style_Header')->get();
        $ret = array();
        foreach ($imgs as $img) {
            if (strlen($img->PPProduktpass_Style_Header) > 1 and $img->PPProduktpass_Style_PPPPFiles_Id != 0) {
                $ret[$img->PPProduktpass_Style_Id]['Style'] = $img->PPProduktpass_Style_Header;
                $ret[$img->PPProduktpass_Style_Id]['Image'] = "";
                if ($img->PPProduktpass_Style_PPPPFiles_Id != 0) $ret[$img->PPProduktpass_Style_Id]['Image'] = $si[$img->PPProduktpass_Style_PPPPFiles_Id];
            }
        }
        return $ret;
    }
    private function getStyleImagesArray($id)
    {
        $imgs = PPPPFiles::where('PPPPFiles_Type', '=', "Designs")->where('PPPPFiles_PPProduktpass_Id', '=', $id)->orderBy('PPPPFiles_Name')->get();
        $ret = array("0" => "Bitte auswählen...");
        foreach ($imgs as $img) {
            $ret[$img->PPPPFiles_Id] = $img->PPPPFiles_Name;
        }
        return $ret;
    }
    private function getCertsofProducer($prod_id)
    {
        $ret = array('BSCI' => '', 'Step' => '', 'BSCIValid' => '', 'StepValid' => '', 'BSCIColor' => 'red', 'StepColor' => 'red');
        if (is_null($prod_id)) {
            return $ret;
        }
        $prod = PPAdressen::where('Id', "=", $prod_id)->get()->first();
        //cpcDebug::dd($prod, 1);
        if ($prod) {
            $bsci = "Nein";
            $bsciValid = "";
            $bsciColor = 'red';
            if ($prod->PPAdressen_ZertBSCI == 1) {
                $bsci = "Ja";
                $bsciValid = cpcHelp::MySqlDate2String($prod->PPAdressen_ZertBSCIValid);
                $dv = cpcHelp::cpcStringDateDiff($prod->PPAdressen_ZertBSCIValid);
                if ($dv['valid']) {
                    if ($dv['diff'] > 0) {
                        $bsciColor = 'green';
                    }
                }
            }
            $step = "Nein";
            $stepValid = "";
            $stepColor = "red";
            if ($prod->PPAdressen_ZertStep == 1) {
                $step = "Ja";
                $stepValid = cpcHelp::MySqlDate2String($prod->PPAdressen_ZertStepValid);
                $dv = cpcHelp::cpcStringDateDiff($prod->PPAdressen_ZertStepValid);
                if ($dv['valid']) {
                    if ($dv['diff'] > 0) {
                        $stepColor = 'green';
                    }
                }
            }
            $ret = array('BSCI' => $bsci, 'Step' => $step, 'BSCIValid' => $bsciValid, 'StepValid' => $stepValid, 'BSCIColor' => $bsciColor, 'StepColor' => $stepColor);
        }
        return $ret;
    }
    private function getRetail()
    {
        $pprs = PPRetail::orderBy('PPRetail_Code')->get();
        $ret = array();
        foreach ($pprs as $ppr) {
            $ret[$ppr->PPRetail_Code] = $ppr->PPRetail_Name;
        }
        return $ret;
    }
    function getGTINForCountry($ppid, $country, $style)
    {
        if (strlen($country) == 4) {
            $country = substr($country, 2, 2);
        }
        $lcs = PPXML_Mengen::where("PPXML_Mengen_PPProduktpass_Id", "=", $ppid)->where('PPXML_Mengen_styleNo', $style)->where('PPXML_Mengen_country', $country)->get()->first();
        if ($lcs) {
            return $lcs->PPXML_Mengen_GTIN;
        }
        return "N.N.";
    }
    function getLocalQuantities($id)
    {
        $lcs = PPXML_Mengen::where("PPXML_Mengen_PPProduktpass_Id", "=", $id)->orderBy("PPXML_Mengen_styleNo")->orderBy("PPXML_Mengen_country")->get();
        $ret = array();
        foreach ($lcs as $lc) {
            if (is_null($lc->PPXML_Mengen_lsv)) {
                $ret['countries']["All"] = 1;
            } else {
                $ret['countries'][$lc->PPXML_Mengen_country] = 1;
            }
        }
        foreach ($lcs as $lc) {
            foreach ($ret['countries'] as $c => $country) {
                $ret['values'][$lc->PPXML_Mengen_Id][$c] = 0;
            }
            if (is_null($lc->PPXML_Mengen_lsv)) {
                $ret['values'][$lc->PPXML_Mengen_Id]["All"] = $lc->PPXML_Mengen_value;
            } else {
                $ret['values'][$lc->PPXML_Mengen_Id][$lc->PPXML_Mengen_country] = $lc->PPXML_Mengen_value;
            }
            $ret['values'][$lc->PPXML_Mengen_Id]['Style'] = array('gtin' => $lc->PPXML_Mengen_GTIN, 'styleNo' => $lc->PPXML_Mengen_styleNo, 'style' => $lc->PPXML_Mengen_productName, 'size' => $lc->PPXML_Mengen_sizeCode);
        }
        return $ret;
    }
    private function getMaxSizePad($styles)
    {
        $max = 10;
        $maxf = 10;
        foreach ($styles as $style => $fbs) {
            foreach ($fbs as $fb => $value) {
                if (mb_strlen($fb, "utf8") > $maxf) {
                    $maxf = mb_strlen($fb, "utf8");
                    // echo("$fb $maxf <br>");
                }
            }
            if (strlen($style) > $max) {
                $max = strlen($style);
            }
        }
        $ret = array($max + 5, $maxf + 5);
        return $ret;
    }
    private function getArtikelText($id)
    {
        $nl = "
";
        $pp = PPProduktpass::find($id);
        $qualitaeten = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)->get();
        $ab = PPAB::where('PPAB_PPProduktpass_Id', '=', $id)->get()->first();
        $herkunftslaender = $this->getHerkunftslaender();
        $VEProLand = $this->VEProLand($id);
        $sizeSort = $this->SizeSort($id);
        $Zolltarife = $this->Zolltarife($id);
        //print_r($Zolltarife);
        $GTIN = $this->GTIN($id);
        $lieferlaender = $this->getLieferlaender($id);
        if (!$pp) {
            return;
        }
        $sText = '"' . $pp->PPProduktpass_Marke . '"  - ' . $pp->PPProduktpass_IAN . " " . $pp->PPProduktpass_Artikelbezeichnung . $nl;
        foreach ($qualitaeten as $qual) {
            if (strlen(trim($qual->PPProduktpass_Qualitaet_Value01) > 0)) {
                if (strpos($qual->PPProduktpass_Qualitaet_Header, "Oberstoff") !== false) {
                    $sText = $sText . 'Oberstoff: ' . trim($qual->PPProduktpass_Qualitaet_Value01);
                }
                if (strpos($qual->PPProduktpass_Qualitaet_Header, "chengew") !== false) {
                    $sText .= "  Flächengewicht: " . trim($qual->PPProduktpass_Qualitaet_Value01) . "g/m²";
                }
            }
        }
        $sText .= $nl;
        $sText .= "Verkaufsverpackung: " . $pp->PPProduktpass_Verkaufsverpackung;
        $sText .= $nl;
        if ($ab) {
            $sText .= isset($herkunftslaender[$ab->PPAB_Herkunftsland]) ? "Herkunft: " . $herkunftslaender[$ab->PPAB_Herkunftsland] : "Herkunft: ";
            $sText .= $nl;
        }
        $start = "<textarea style='width:1500px;height:200px;border: 2px solid lightgray; padding:10px; font-family:monospace;font-size:12px;margin:5px;text-align:left;'>";
        $sWidth = array(10, 10, 10, 20, 10);
        if ($this->IsBWOrder($id)) {
            $posnum = 1;
            foreach ($lieferlaender as $lLand) {
                if ($lLand['LT1Menge'] > 0) {
                    $lbMenge[$lLand['Country']] = array('Menge' => $lLand['LT1Menge'], 'Groesse' => $lLand['Size']);
                }
            }
            $line = "";
            foreach ($sizeSort['SizeSort'] as $lb => $styles) {
                $sWidth[0] = $this->getMaxSizePad($styles)[0];
                $sWidth[1] = $this->getMaxSizePad($styles)[1];
                foreach ($lbMenge as $l => $ma) {
                    if (strpos($lb, '-' . $l) !== false) {
                        $line .= $start;
                        $line .= $sText . $nl;
                        $line .= 'Land: ' . $l . "   Menge: " . number_format($ma['Menge'], 0, ",", ".") . "   Grösse: " . $ma['Groesse'] . $nl;
                        $land1 = substr($lb, 4, 2);
                        if ($land1 == 'OS') {
                            $land1 = substr($lb, 4, 4);
                        }
                        $VEProL = isset($VEProLand[$land1]['VE']) ? $VEProLand[$land1]['VE'] : -1;
                        try {
                            $line .= "VE: " . number_format($VEProL, 0) . " Stk im Karton" . $nl;
                        } catch (Exception $ex) {
                            $VEProL = -1;
                            $line .= "VE: " . number_format($VEProL, 0) . " Stk im Karton" . $nl;
                        }
                        $line .= str_pad('Style', $sWidth[0], " ");
                        $line .= str_pad('Farbe', $sWidth[1]);
                        if (substr($land1, 0, 2) != "OS") {
                            foreach ($sizeSort['Index'] as $size => $val) {
                                $line .= str_pad($size, $sWidth[2]);
                            }
                        }
                        $line .= str_pad('Zolltarif', $sWidth[3]);
                        $line .= str_pad('GTIN', $sWidth[4]);
                        $line .= $nl;
                        $line .= "---------------------------------------------------------------------------------------------------------------------------------" . $nl;
                        foreach ($styles as $style => $fbs) {
                            $line .= str_pad($style, $sWidth[0]);
                            foreach ($fbs as $fb => $menge) {
                                $line .= str_pad($fb, $sWidth[1]);
                                if (substr($land1, 0, 2) != "OS") {
                                    foreach ($sizeSort['Index'] as $size => $val) {
                                        if ($VEProL > 0 and isset($menge[$size]) and $menge[$size] > $VEProL) {
                                            $xline = $menge[$size] . " Stk => " . $menge[$size] / $VEProL . " Krt ";
                                            $line .= str_pad($xline, $sWidth[2]);
                                        } else {
                                            $xline = isset($menge[$size]) ? $menge[$size] : 0 . "Stk. ";
                                            $line .= str_pad($xline, $sWidth[2]);
                                        }
                                    }
                                }
                            }
                            //                            $xline = isset($Zolltarife[$style][$fb]) ? $Zolltarife[$style][$fb] : '';
                            $xline = $this->getZolltarifFromStyle($pp->PPProduktpass_Id, $style);
                            $line .= str_pad($xline, $sWidth[3]);
                            $xline = isset($GTIN[$lb][$style][$fb]) ? $GTIN[$lb][$style][$fb] : '';
                            $line .= str_pad($xline, $sWidth[4]);
                            $line .= $nl;
                        }
                        $line .= '***********************************************************</textarea><br>';
                    }
                }
            }
        } else {
            //keine Bettwäsche => OS alle zusammen
            $posnum = 1;
            $line = "";
            $firstOS = true;
            if (!is_null($sizeSort['SizeSort'])) {
                foreach ($sizeSort['SizeSort'] as $lb => $styles) {
                    $sWidth[0] = $this->getMaxSizePad($styles)[0];
                    $sWidth[1] = $this->getMaxSizePad($styles)[1];
                    // echo("sw: " . $sWidth[0]);
                    //exit;
                    $first = true;
                    $land1 = substr($lb, 4, 2);
                    if ($land1 != 'OS' or ($land1 == 'OS' and $firstOS)) {
                        if ($first) {
                            $first = false;
                            $line .= $start;
                        }
                        $line .= $sText . $nl;
                        if ($land1 == 'OS') {
                            $firstOS = false;
                            $line .= 'Land: OS' . $nl;
                        } else {
                            $line .= 'Land: ' . $lb . $nl;
                        }
                        $VEProL = isset($VEProLand[$land1]['VE']) ? $VEProLand[$land1]['VE'] : -1;
                        try {
                            $line .= "VE: " . number_format($VEProL, 0) . " Stk im Karton" . $nl;
                        } catch (Exception $ex) {
                            $line .= "VE: N.N. Stk im Karton" . $nl;
                        }
                        $line .= str_pad('Style', $sWidth[0], " ");
                        $line .= str_pad('Farbe', $sWidth[1], " ");
                        if ($land1 != 'OS') {
                            foreach ($sizeSort['Index'] as $size => $val) {
                                $line .= str_pad($size, $sWidth[2], " ");
                            }
                        }
                        $line .= str_pad('Zolltarif', $sWidth[3], " ");
                        $line .= str_pad('GTIN', $sWidth[4], " ");
                        $line .= $nl;
                        $line .= "----------------------------------------------------------------------------------------------------------------------" . $nl;
                        foreach ($styles as $style => $fbs) {
                            $line .= str_pad($style, $sWidth[0], " ");
                            foreach ($fbs as $fb => $menge) {
                                $line .= str_pad($fb, $sWidth[1], " ");
                                foreach ($sizeSort['Index'] as $size => $val) {
                                    if ($land1 != 'OS') {
                                        if (isset($menge[$size]) and $menge[$size] > $VEProL) {
                                            $m1 = "##";
                                            try {
                                                if ($VEProL != 0) {
                                                    $m1 = $menge[$size] / $VEProL;
                                                }
                                            } catch (Exception $ex) {
                                                $m1 = 0;
                                            }
                                            $xline = $menge[$size] . " Stk => " . $m1 . " Krt ";
                                            $line .= str_pad($xline, $sWidth[2], " ");
                                        } else {
                                            $xline = isset($menge[$size]) ? $menge[$size] : 0 . "Stk. ";
                                            $line .= str_pad($xline, $sWidth[2], " ");
                                        }
                                    }
                                }
                            }
                            //echo("$style => $fb NBW <br>");
                            //  $xline = isset($Zolltarife[$style][$fb]) ? $Zolltarife[$style][$fb] : '';
                            $xline = $this->getZolltarifFromStyle($pp->PPProduktpass_Id, $style);
                            $line .= str_pad($xline, $sWidth[3], " ");
                            $xline = isset($GTIN[$lb][$style][$fb]) ? $GTIN[$lb][$style][$fb] : '';
                            $line .= str_pad($xline, $sWidth[4], " ");
                            $line .= $nl;
                        }
                        $line .= '***********************************************************</textarea><br>';
                    }
                }
            }
        }
        return $line;
    }
    /*     * **********************************START *************** */
    private function getLaenderMitLiefermengen($lieferlaender)
    {
        foreach ($lieferlaender as $lLand) {
            if ($lLand['LT1Menge'] > 0) {
                $lbMenge[$lLand['Country']] = array('Menge' => $lLand['LT1Menge'], 'Groesse' => $lLand['Size']);
            }
        }
        return $lbMenge;
    }
    private function getOberstoff($qualitaeten)
    {
        $OS = "";
        $Gewicht = "";
        foreach ($qualitaeten as $qual) {
            if (strlen(trim($qual->PPProduktpass_Qualitaet_Value01) > 0)) {
                if (strpos($qual->PPProduktpass_Qualitaet_Header, "Oberstoff") !== false) {
                    $OS = trim($qual->PPProduktpass_Qualitaet_Value01);
                }
                if (strpos($qual->PPProduktpass_Qualitaet_Header, "chengew") !== false) {
                    $Gewicht = trim($qual->PPProduktpass_Qualitaet_Value01);
                }
            }
        }
        return array("Oberstoff" => $OS, "Gewicht" => $Gewicht);
    }
    private function makeMessage($msg, $color)
    {
        $ret = array("message" => $msg, "color" => $color);
        return $ret;
    }
    private function getZolltarifFromStyle($ppid, $style)
    {
        $ZT = $this->Zolltarife($ppid);
        $s = $style;
        try {
            $ret = reset($ZT[$s]);
        } catch (Exception $ex) {
            if (strlen($s) > 8) {
                $s = substr($s, 0, 8);
            }
            try {
                $ret = reset($ZT[$s]);
            } catch (Exception $ex) {
                $ret = 'N.N.';
            }
        }
        return $ret;
    }
    private function getMaxStringsize($str, $size)
    {
        $maxf = $size;
        if (mb_strlen($str, "utf8") > $size) {
            $maxf = mb_strlen($str, "utf8");
        }
        return $maxf;
    }
    private function getArtikelVorlage($id)
    {
        $pp = PPProduktpass::find($id);
        $po = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $id)->get()->first();
        $ab = PPAB::where("PPAB_PPProduktpass_Id", "=", $id)->get()->first();
        $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get();
        $artCheck = artikelstamm::where('artikelnummer', 'like', "%" . $pp->PPProduktpass_IAN . "%")->where("IstAktiv", "=", 1)->get()->first();
        if ($artCheck) {
            return Redirect::to('/show/' . $id . "#tabs-50")->with('message', $this->makeMessage(" Artikel nicht angelegt! Es gibt bereits Artikel.", "red"));
        }
        $qualitaeten = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)->get();
        $herkunftslaender = $this->getHerkunftslaender();
        $VEProLand = $this->VEProLand($id);
        $sizeSort = $this->SizeSort($id);
        $Zolltarife = $this->Zolltarife($id);
        $GTIN = $this->GTIN($id);
        $lieferlaender = $this->getLieferlaender($id);
        if (!$pp) {
            return Redirect::to('/show/' . $id . "#tabs-50")->with('message', $this->makeMessage(" Artikel nicht angelegt! PP?", "red"));
        }
        // Artikelanlage HR GB NI CH
        // BW: VK um Zoll rduzeieren EK um Zoll reduzieren
        // andere  Extra DAT Artikel anlegen. VK und EK um Zoll reduzieren
        $header['IAN'] = $pp->PPProduktpass_IAN;
        $header['Marke'] = $pp->PPProduktpass_Marke;
        $header['Artikel'] = $pp->PPProduktpass_Artikelbezeichnung;
        $header['Stoff'] = $this->getOberstoff($qualitaeten);
        $header['Verpackung'] = $pp->PPProduktpass_Verkaufsverpackung;
        $header['Herkunft'] = isset($herkunftslaender[$ab->PPAB_Herkunftsland]) ? $herkunftslaender[$ab->PPAB_Herkunftsland] : "";
        $header['VK'] = $ab->PPAB_VKEUR;
        //** Berechnung EK  **//
        $isSaveExcR = $po->PPPurchase_ExcR_Save <> 0 ? 1 : 0;
        // VK bei nicht Bettwäsche Aufträgen
        $kalk['VKP'] = $ab->PPAB_VKEUR;
        $kalk['VKP3'] = $kalk['VKP'] - ($kalk['VKP'] * 0.3 / 100);
        //Berechnung VK Bettwäsche
        $vkbw = array();
        if ($mengen) {
            foreach ($mengen as $m) {
                try {
                    $vkbw[$m->PPProduktpass_Menge_Country] = $m->PPProduktpass_Menge_VKFOBEUR;
                } catch (Exception $ex) {
                    $vkbw[$m->PPProduktpass_Menge_Country] = 0;
                }
            }
        }
        $header['VKBW'] = $vkbw;
        $kalk['Menge'] = $pp->PPProduktpass_Gesamtmenge;
        $kalk['EK_FW'] = $po->PPPurchase_EK_Calc;
        $kalk['EK_EURC'] = $po->PPPurchase_ExcR_Calc <> 0 ? $po->PPPurchase_EK_Calc / $po->PPPurchase_ExcR_Calc : 0;
        $kalk['EK_EURS'] = $po->PPPurchase_ExcR_Save <> 0 ? $po->PPPurchase_EK_Calc / $po->PPPurchase_ExcR_Save : 0;
        $kalk['Fracht_Stk'] = $po->PPPurchase_Fracht;
        $kalk['ZollC'] = ($kalk['EK_EURC'] + $kalk['Fracht_Stk']) * $po->PPPurchase_Zoll / 100;
        $kalk['ZollS'] = ($kalk['EK_EURS'] + $kalk['Fracht_Stk']) * $po->PPPurchase_Zoll / 100;
        $kalk['EKProvisionC'] = $kalk['EK_EURC'] * $po->PPPurchase_EKProvision / 100;
        $kalk['EKProvisionS'] = $kalk['EK_EURS'] * $po->PPPurchase_EKProvision / 100;
        $kalk['ESPC'] = $kalk['EK_EURC'] + $kalk['Fracht_Stk'] + $kalk['ZollC'] + $kalk['EKProvisionC'];
        $kalk['ESPS'] = $kalk['EK_EURS'] + $kalk['Fracht_Stk'] + $kalk['ZollS'] + $kalk['EKProvisionS'];
        $kalk['Ausgangsfrachten'] = $po->PPPurchase_Ausgangsfrachten;
        $kalk['Pruefkosten'] = $po->PPPurchase_Pruefkosten;
        $kalk['FinanzierungC'] = $kalk['ESPC'] * $po->PPPurchase_Finanzierungskosten / 100;
        $kalk['FinanzierungS'] = $kalk['ESPS'] * $po->PPPurchase_Finanzierungskosten / 100;
        $kalk['Lizenz'] = $kalk['VKP'] * $po->PPPurchase_Lizenzgebuehren / 100;
        $kalk['Kosten'] = $po->PPPurchase_Kosten;
        $kalk['SonstKostenProz'] = $kalk['VKP'] * $po->PPPurchase_SonstKostenProz / 100;
        $kalk['SKPC'] = $kalk['ESPC'] + $kalk['Ausgangsfrachten'] + $kalk['FinanzierungC'] + $kalk['Pruefkosten'] + $kalk['Lizenz'] + $kalk['Kosten'] + $kalk['SonstKostenProz'];
        $kalk['SKPS'] = $kalk['ESPS'] + $kalk['Ausgangsfrachten'] + $kalk['FinanzierungS'] + $kalk['Pruefkosten'] + $kalk['Lizenz'] + $kalk['Kosten'] + $kalk['SonstKostenProz'];
        //** Ende Berechnung EK **//
        $header['LEK'] = $po->PPPurchase_EK_Calc;
        $header['LEKWSYM'] = $po->PPPurchase_Currency;
        $header['PreisEinstand'] = $isSaveExcR ? $kalk['ESPS'] : $kalk['ESPC'];
        $header['PreisSK'] = $isSaveExcR ? $kalk['SKPS'] : $kalk['SKPC'];
        $isFirstOS = true;
        $ll = $this->getLaenderMitLiefermengen($lieferlaender);
        $art = array();
        $padSizes = array('Style' => 0, 'Farbe' => 0, 'VE' => 0, 'Groesse' => 0, 'Menge' => 0, 'Zolltarif' => 15, 'EAN' => 15);
        foreach ($sizeSort['SizeSort'] as $lb => $styles) {
            $isFirstOS = true;
            if ($this->IsBWOrder($id)) {
                // Bestimme Länder die bestellt haben
                foreach ($ll as $land => $mengeGroesse) {
                    //Für jedes Land einen Artikel
                    if (strpos($lb, "-" . $land) !== false) {
                        //Neuer Artikel
                        $art[$land]['Groesse'] = $mengeGroesse['Groesse'];
                        $padSizes['Groesse'] = 8;
                        $art[$land]['VE'] = $VEProLand[$land]['VE'];
                        $padSizes['VE'] = $this->getMaxStringsize($VEProLand[$land]['VE'], $padSizes['VE']);
                        foreach ($styles as $key => $value) {
                            /*    echo("BW Styles: $land <br><pre>");
                              print_r($key);
                              echo("<br>vvvvvvvvvv<br>");
                              print_r($value);
                              echo("<br>GGGGGGGGGGGG<br>");
                              print_r($GTIN);
                              echo("</pre><br>#-#-#-#-#-#-#-#-#-#-#-<br>"); */
                            $art[$land]['Styles'][$key] = $value;
                            //
                            foreach ($value as $fb => $menge) {
                                $padSizes['Farbe'] = $this->getMaxStringsize($fb, $padSizes['Farbe']);
                                $gt = $this->getGTINForCountry($id, $land, $key);
                                $zt = $this->getZolltarifFromStyle($id, $key);
                                $art[$land]['GTIN'][$key] = $gt;
                                $art[$land]['Zolltarif'][$key] = $zt;
                            }
                            $padSizes['Style'] = $this->getMaxStringsize($key, $padSizes['Style']);
                        }
                    }
                }
            } else {
                $land = substr($lb, 4, 2);
                if (substr($land, 0, 2) == "OS") {
                    $land = substr($lb, 4, 4);
                }
                if ($this->isOSLand($lb)) {
                    if ($isFirstOS) {
                        $isFirstOS = false;
                        //echo("OS Artikel: $lb <br>");
                        $art['OS']['VE'] = $VEProLand[$land]['VE'];
                        $padSizes['VE'] = $this->getMaxStringsize($VEProLand[$land]['VE'], $padSizes['VE']);
                        $art['OS']['Groesse'] = "";
                        $padSizes['Groesse'] = 0;
                        foreach ($styles as $style => $styleval) {
                            $art['OS']['Styles'][$style] = $styleval;
                            $padSizes['Style'] = $this->getMaxStringsize($style, $padSizes['Style']);
                            $fb = key($styleval);
                            $padSizes['Farbe'] = $this->getMaxStringsize($fb, $padSizes['Farbe']);
                            $art['OS']['Zolltarif'][$style] = $this->getZolltarifFromStyle($pp->PPProduktpass_Id, $style);
                            //echo( $art['OS']['Zolltarif'][$style]);
                            $art['OS']['GTIN'][$style] = isset($GTIN[$lb][$style][$fb]) ? $GTIN[$lb][$style][$fb] : '';
                        }
                    } else {
                        // echo("Hidden OS Artikel: $lb <br>");
                    }
                } else {
                    $l = "";
                    foreach ($ll as $land => $mengeGroesse) {
                        if (strpos($land, "OS") === false) {
                            $l .= $land . " ";
                        }
                    }
                    //  if ($l != "") {
                    //echo("LB Artikel: $l <br>");
                    //$VEProL = isset($VEProLand[$land1]['VE']) ? $VEProLand[$land1]['VE'] : -1;
                    $art[trim($l)]['VE'] = $VEProLand[$land]['VE'];
                    $padSizes['VE'] = $this->getMaxStringsize($VEProLand[$land]['VE'], $padSizes['VE']);
                    $art[trim($l)]['Groesse'] = "";
                    $padSizes['Groesse'] = 0;
                    foreach ($styles as $style => $styleval) {
                        $art[trim($l)]['Styles'][$style] = $styleval;
                        $padSizes['Style'] = $this->getMaxStringsize($style, $padSizes['Style']);
                        $fb = key($styleval);
                        $padSizes['Farbe'] = $this->getMaxStringsize($fb, $padSizes['Farbe']);
                        //$art[trim($l)]['Zolltarif'][$style] = isset($Zolltarife[$style][$fb]) ? $Zolltarife[$style][$fb] : '';
                        $art['OS']['Zolltarif'][$style] = $this->getZolltarifFromStyle($pp->PPProduktpass_Id, $style);
                        $art[trim($l)]['Zolltarif'][$style] = $this->getZolltarifFromStyle($pp->PPProduktpass_Id, $style);
                        $art[trim($l)]['GTIN'][$style] = isset($GTIN[$lb][$style][$fb]) ? $GTIN[$lb][$style][$fb] : '';
                        //$art[trim($l)]['Styles'][$style]['Zolltarif'] =  isset($Zolltarife[$style][$fb]) ? $Zolltarife[$style][$fb] : '';
                    }
                    //}
                }
            }
        }
        $padSizes['Style'] += 4;
        $padSizes['Groesse'] = $padSizes['Groesse'] > 0 ? $padSizes['Groesse'] + 4 : 0;
        $padSizes['Farbe'] += 4;
        $padSizes['Menge'] += 8;
        $artikel['Header'] = $header;
        $artikel['Artikel'] = $art;
        $artikel['padSize'] = $padSizes;
        $this->createArtikel($artikel);
        return Redirect::to('/show/' . $id . "#tabs-50")->with('message', $this->makeMessage(" Artikel [" . $header['IAN'] . "] ff wurden angelegt! ", "green"));
    }
    private function getGTINforLand($gtins, $land, $style, $fb)
    {
        if (strpos($land, "OS") === false) {
            $land = '-' . $land;
        }
        $ret = 'X.X';
        foreach ($gtins as $l => $gtin) {
            if (strpos($l, $land) !== false) {
                try {
                    $ret = $gtin[$style][$fb];
                } catch (Exception $ex) {
                }
                return $ret;
            }
        }
        return $ret;
    }
    public function getMitarbeiter()
    {
        $mas = PPMitarbeiter::where('PPMitarbeiter_Status', 1)->get();
        $ret = array();
        foreach ($mas as $ma) {
            $ret[$ma->PPMitarbeiter_Id] = array('Kuerzel' => $ma->PPMitarbeiter_Kuerzel, 'Name' => $ma->PPMitarbeiter_Name, 'email' => $ma->PPMitarbeiter_email);
        }
        return $ret;
    }
    private function ddfk($var, $exit = false)
    {
        if (Auth::getUser()->id == 1) {
            echo ("<br>" . Auth::getUser()->username . "<pre>");
            print_r($var);
            echo ("</pre><br>");
            if ($exit) {
                exit;
            }
        }
    }
    /* private function round_half_down($num, $places) {
      $ret = round($num, $places, PHP_ROUND_HALF_DOWN);
      return $ret;
      }
    */
    private function createArtikel($artikel)
    {
        //$this->ddfk($artikel);
        $ci = 1;
        $CodeVE = '2';
        $padSize = $artikel['padSize'];
        $header = $artikel['Header'];
        foreach ($artikel['Artikel'] as $k => $a) {
            $artERP = new artikelstamm();
            $artERP->artikelnummer = $header['IAN'] . "00$CodeVE" . "0100";
            $artERP->Matchcode = $header['IAN'] . " - " . $header['Artikel'];
            $artERP->Bezeichnung1 = '"' . trim($header['Marke']) . '" ' . $header['Artikel'];
            $artERP->Bezeichnung2 = "Länder: $k";
            $artERP->MengeneinheitVK = "Stk";
            $artERP->MengeneinheitEK = "Stk";
            $artERP->MengeneinheitLager = "Stk";
            $artERP->Qual_Qualitaet = $header['Stoff']['Oberstoff'];
            $artERP->Qual_gsm = $header['Stoff']['Gewicht'] . " g/m²";
            $artERP->PreisEinstand = $header['PreisEinstand'];
            $artERP->PreisEKStandard = $header['PreisEinstand'];
            $artERP->PreisDurchschnittEK = $header['PreisEinstand'];
            $artERP->PreisLEK = $header['LEK'];
            $artERP->PreisSK = $header['PreisSK'];
            $artERP->PreisLEK_Wsym = $header['LEKWSYM'];
            $artERP->LagerartikelArt = "Streckenartikel";
            if (isset($header['VKBW'][$k]) and $header['VKBW'][$k] != 0) {
                $artERP->PreisVK = $this->round_half_down($header['VKBW'][$k] - ($header['VKBW'][$k] * 0.3 / 100), 3);
                $artERP->PreisVKAlt = $this->round_half_down($header['VKBW'][$k], 3);
            } else {
                $artERP->PreisVK = $this->round_half_down($header['VK'] - ($header['VK'] * 0.3 / 100), 3);
                $artERP->PreisVKAlt = $this->round_half_down($header['VK'], 3);
            }
            $artERP->IstBestandsgefuehrt = 1;
            $nl = "
";
            $text = "Artikel: IAN" . $header['IAN'] . $nl;
            $text .= '"' . $header['Marke'] . '"' . " " . $header['IAN'] . " " . $header['Artikel'] . $nl;
            $text .= "Oberstoff:  " . $header['Stoff']['Oberstoff'] . "  Flächengewicht: " . $header['Stoff']['Gewicht'] . " g/m² " . $nl;
            $text .= "Verkaufsverpackung: " . $header['Verpackung'] . $nl;
            $text .= "Herkunft: " . $header['Herkunft'] . $nl;
            $text .= "Lieferländer: " . $k . $nl;
            $text .= "VE: " . $a['VE'] . $nl;
            $text .= "Gösse: " . $a['Groesse'] . $nl;
            //$maxs = $this->getMaxSizePad($a['Styles']);
            //$maxs = $padSize[$style];
            $design = str_pad('Design', $padSize['Style']);
            $farbe = str_pad('Farbe', $padSize['Farbe']);
            $groesse = $padSize['Groesse'] > 0 ? str_pad('Groesse', $padSize['Groesse']) : "";
            $menge = str_pad('Menge', $padSize['Menge']);
            $zolltarif = str_pad('Zolltarif', $padSize['Zolltarif']);
            $ean = str_pad('EAN', $padSize['EAN']);
            $ueberschrift = $design . $farbe . $groesse . $menge . $zolltarif . $ean;
            $i = strlen($ueberschrift);
            $text .= $ueberschrift . $nl;
            $line = '-';
            $line = str_pad($line, $i, "-");
            $text .= $line . $nl;
            foreach ($a['Styles'] as $s => $sv) {
                $text .= str_pad(trim($s), $padSize['Style']);
                foreach ($sv as $fb => $sizes) {
                    $text .= str_pad(trim($fb), $padSize['Farbe']);
                    foreach ($sizes as $size => $sizeval) {
                        try {
                            $gtin = $a['GTIN'][$s];
                        } catch (Exception $ex) {
                            $gtin = "N.N.";
                        }
                        try {
                            $zt = $a['Zolltarif'][$s];
                        } catch (Exception $ex) {
                            $zt = "N.N.";
                        }
                        $text .= str_pad(trim(str_replace("Style Breakdown", "", $size)), $padSize['Groesse']) . str_pad("[" . $sizeval . "]", $padSize['Menge']) . str_pad(trim($zt), $padSize['Zolltarif']) . $gtin;
                    }
                }
                $text .= $nl;
            }
            $artERP->TextUebernahme = $text;
            $ci++;
            $artERP->save();
        }
    }
    private function isOSLand($lb)
    {
        /* if (strpos($lb, 'OS') === false) {
          return false;
          } else {
          return true;
          } */
        $land1 = substr($lb, 4, 2);
        if ($land1 == 'OS') {
            return true;
        }
        return false;
    }
    private function getAktVersion ($ppid){
        $pp = tPPProduktpass::find($ppid);
        if ($pp){
            $ian = substr($pp->PPProduktpass_IAN,0,6);
            $ausmusterung = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            $aktpp = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer', 'like', $ausmusterung.'%')->get()->first();
            if ($aktpp){
                return $aktpp;
            }
        }
        return false;
    }
    public function getPP($ppid)
    {
        $pp = tPPProduktpass::find($ppid);
        if (strpos($pp->PPProduktpass_IAN, 'ev') ===  false){
            return $pp;
        } else {
            return $this->getAktVersion($ppid);
        }
        return false;
    }
    /**
     * Display the specified resource.
     * GET /projects/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function showAfterUpload($id, $mainTab, $subTabName = "", $subTabIndex = 0, $subsubTabIndex = 0, $compactView = 0)
    {
        $mainTabIndex = 0;
        if ($mainTab == 6) {
            $mainTabIndex = 1;
        }
        $tabs = array('mainTab' => $mainTab, 'mainTabIndex' => $mainTabIndex, 'subTabName' => $subTabName, 'subTabIndex' => $subTabIndex, 'subsubTabIndex' => $subsubTabIndex, 'compactView' => $compactView);
        //cpcDebug::pe($tabs);
        return $this->show($id, "0", "", "", $tabs);
    }
    public function getProjektIANs($project)
    {
        $IAN_Ids = array();
        $pps = PPProduktpass::where('PPProduktpass_PPProjekte_Projekt', '=', $project)->orderBy('PPProduktpass_IAN')->get();
        if ($pps) {
            foreach ($pps as $pp) {
                if (strlen($pp->PPProduktpass_IAN) == 6) {
                    $IAN_Ids[$pp->PPProduktpass_Id] = $pp->PPProduktpass_IAN;
                }
            }
        } else {
            $INA_Ids = null;
        }
        return $IAN_Ids;
    }
    public function updateRemark()
    {
        //print_r ($_POST);exit;
        $ppid = Input::get('ppid');
        $Bemerkung = Input::get('PPProduktpass_AdminRemark');
        $pp = tPPProduktpass::find($ppid);
        if ($pp) {
            $pp->PPProduktpass_AdminRemark = $Bemerkung;
            $pp->save();
        }
        return Redirect::to('/show/' . $ppid . "#tabs-89");
    }
    public function newRemark()
    {
        //print_r ($_POST);exit;
        $ppid = Input::get('ppid');
        $Bemerkung = Input::get('PPProduktpass_AdminRemarkNeu');
        $pp = tPPProduktpass::find($ppid);
        if ($pp) {
            $t = $pp->PPProduktpass_AdminRemark;
            $t = date('d.m.Y') . "   [" . Auth::user()->PPMitarbeiter_Kuerzel . "]
" . $Bemerkung . "
" . $t;
            $pp->PPProduktpass_AdminRemark = $t;
            $pp->save();
        }
        return Redirect::to('/show/' . $ppid . "#tabs-89");
    }
    public function showIAN($ian, $ausm = null)
    {
        $pp = tPPProduktpass::where('PPProduktpass_IAN', "=", $ian);
        if (!is_null($ausm)) {
            $pp = $pp->where('PPProduktpass_Ausmusterungnummer', 'like', "$ausm%");
        }
        $pp = $pp->get()->first();
        if ($pp) {
            return $this->show($pp->PPProduktpass_Id);
        }
        echo ('IAN nicht gefunden!');
        exit;
    }
    public function getOrder_Targaview($ppid)
    {
        $order = null;
        $weights = null;
        $orders = PPOrder::where('PPOrder_PPProduktpass_Id', $ppid)->get()->first();
        if ($orders) {
            $order = $orders;
        }
        $weightsDb = PPOrderWeights::where('PPOrderWeights_PPProduktpass_Id', $ppid)->get();
        if ($weightsDb) {
            $weights = $weightsDb;
        }
        $ret = array('order' => $order, 'weights' => $weights);
        //$this->prncpc($ret);
        return $ret;
    }
    public function getLsv_Targaview($ppid)
    {
        $lsva = array();
        $lsvb = array();
        $lsvs = PPLsv::where('PPLsv_PPProduktpass_Id', $ppid)->get();
        if ($lsvs) {
            foreach ($lsvs as $lsv) {
                $lsva[$lsv->PPLsv_code] = array('name' => $lsv->PPLsv_name, 'countryCodes' => $lsv->PPLsv_countryCodes, 'countryNames' => $lsv->PPLsv_countryNames);
                $lsvb[$lsv->PPLsv_name] = array('code' => $lsv->PPLsv_code, 'countryCodes' => $lsv->PPLsv_countryCodes, 'countryNames' => $lsv->PPLsv_countryNames);
            }
        }
        //$this->prncpc($lsvb);
        return array('names' => $lsva, 'codes' => $lsvb);
    }
    private function getAttachments_TargaviewOld($ppid)
    {
        //$this->prncpc($ppid);
        //$ppfiles = PPPPFiles::where('PPPPFiles_Description', 'like', '%Import%')->where('PPPPFiles_Status', 1)->where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Type', 'PPUpload')->where('PPPPFiles_Pfad', 'uploads')->orderBy('PPPPFiles_Date', 'DESC')->get();
        $ppfiles = PPPPFiles::where('PPPPFiles_Description', 'like', '%Import%')->where('PPPPFiles_Status', 1)->where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Type', 'PPUpload')->where('PPPPFiles_Pfad', 'uploads')->orderBy('PPPPFiles_Date', 'DESC')->get();
        $files = null;
        if ($ppfiles) {
            $files = array();
            $first = true;
            foreach ($ppfiles as $f) {
                if ($first) {
                    $d = new DateTime($f->created_at);
                    $firstdate = $d->format('Y-m-d H:i');
                    $first = false;
                }
                $comp = new DateTime($f->created_at);
                $compdate = $comp->format('Y-m-d H:i');
                if (strcmp($firstdate, $compdate) === 0) {
                    if (is_null($f->PPPPFiles_SharepointLink)){
                        $files[] = array('Link' =>'https://tpt-dev.ad.targa.de/data/'. $f->PPPPFiles_Pfad . '/' . $f->PPPPFiles_Name, 'FilenameLidl' => mb_substr($f->PPPPFiles_Name, 7));
                    } else {
                        // https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/474733_2407/474733_2407_Pruefplan_9-in-1HeiluftfritteuseSHF1800B1_SLG.pdf?csf=1&web=1 
                        // https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/474733_2407/474733_2407_Pruefplan_9-in-1HeiluftfritteuseSHF1800B1_SLG.pdf?csf=1&web=1
                        // https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/474733_2407/474733_2407_Pruefplan_9-in-1HeiluftfritteuseSHF1800B1_SLG.pdf?csf=1&web=1
                        $files[] = array('Link' =>$f->PPPPFiles_SharepointLink,  'FilenameLidl' => $f->PPPPFiles_Name);
                    }
                }
            }
        }
        //$this->prncpc($files, 1);
        return $files;
    }
    public function getAttachments_Targaview($ppid)
    {
        //$this->prncpc($ppid);
        //$ppfiles = PPPPFiles::where('PPPPFiles_Description', 'like', '%Import%')->where('PPPPFiles_Status', 1)->where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Type', 'PPUpload')->where('PPPPFiles_Pfad', 'uploads')->orderBy('PPPPFiles_Date', 'DESC')->get();
        $files = null;
        $ppfiles = PPPPFiles::/*where('PPPPFiles_Description', 'like', '%Import%')->*/where('PPPPFiles_NoPPID', 0)->where('PPPPFiles_Status', 1)->where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Type', 'PPUpload')->where('PPPPFiles_Pfad', 'uploads')->orderBy('PPPPFiles_Date', 'DESC')->get();
        $pp = tPPProduktpass::find ($ppid);
        if ($pp){
            $files = null;
            if ($ppfiles) {
                $files = array();
                $first = true;
                foreach ($ppfiles as $f) {
                    if ($first) {
                        $d = new DateTime($f->created_at);
                        $firstdate = $d->format('Y-m-d H:i');
                        $first = false;
                    }
                    $comp = new DateTime($f->created_at);
                    $compdate = $comp->format('Y-m-d H:i');
                    //if (strcmp($firstdate, $compdate) === 0) {
                    $fid = mb_substr($f->PPPPFiles_Name, 7);
                    if (is_null($f->PPPPFiles_SharePointLink)){
                        $files[$fid] = array('Link' =>'https://tpt-dev.ad.targa.de/data/'. $f->PPPPFiles_Pfad . '/' . $f->PPPPFiles_Name, 'FilenameLidl' => mb_substr($f->PPPPFiles_Name, 7));
                    } else {
                        $ian = $pp->PPProduktpass_IAN;
                        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
                        $link = "https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/".$ian.'_'.$ausm.'/'. $f->PPPPFiles_SharePointLink;
                        // https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/474733_2407/474733_2407_Pruefplan_9-in-1HeiluftfritteuseSHF1800B1_SLG.pdf?csf=1&web=1 
                        // https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/474733_2407/474733_2407_Pruefplan_9-in-1HeiluftfritteuseSHF1800B1_SLG.pdf?csf=1&web=1
                        // https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/474733_2407/474733_2407_Pruefplan_9-in-1HeiluftfritteuseSHF1800B1_SLG.pdf?csf=1&web=1
                        $files[$fid] = array('Link' =>$link,  'FilenameLidl' => $f->PPPPFiles_Name);
                    }
                    //}
                }
            }
        }
        //$this->prncpc($files, 1);
        return $files;
    }
    private function getVorgaenger_IAN($param){
        if (strlen($param) != 13){
            return 0;
        }
        $ian = substr($param,2,6);
        $akt_ausm =substr($param,9,4); 
        $pp = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer', '<', $akt_ausm)->orderBy('PPProduktpass_Ausmusterungnummer','DESC')->get()->first();
        if ($pp){
            return $pp->PPProduktpass_Id;
        }
        return 0;
    }
    public function showNeu ($param_ppid, $deepLink =''){
        $ppid = $this->getPpidFromURL($param_ppid);
        $ianC = new IANController();
        $data['content'] = $ianC->aGetPPIdLidl($ppid, $deepLink);
        return View::make('main', $data);
    }
    private function getPpidFromURL($param_ppid){
        $ppid = $param_ppid;
        if(strlen($param_ppid) == 13){
            $ppid = $this->getVorgaenger_IAN($param_ppid);
            if ($ppid == 0){
                echo("<div style='padding:20px;font-family:arial;font-size:14px;'>Für IAN <b>$param_ppid</b> wurde keine Vorgänger gefunden! </div>");
                exit;
            }
        }
        if(strlen($param_ppid)==11){
            $ian = substr($param_ppid,0,6);
            $ausmusterung = substr($param_ppid,7,4);
            //echo("IAN: $ian Ausmusterung: $ausmusterung");
            $pp = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer', 'like', $ausmusterung.'%')->get()->first();
            if ($pp){
                $ppid =  $pp->PPProduktpass_Id;
            } else {
                echo("<div style='padding:20px;font-family:arial;font-size:14px;'>IAN <b>".$ian."_".$ausmusterung."</b> ist im TPT nicht vorhanden! </div>");
                exit;
            }
        }
        if (strlen($param_ppid)==6){
            echo("<div style='padding:20px;font-family:arial;font-size:14px;'>Für IAN <b>$ppid</b> wurde keine Ausmusterung angegeben! </div>");
            exit;
        }
        $maxId = tPPProduktpass::max('PPProduktpass_Id');
        if ($ppid > $maxId){
            echo("<div style='padding:20px;font-family:arial;font-size:14px;'>Produktpass-Id <b>$ppid</b> ausserhalb des Bereichs! Max($maxId) </div>");
            exit;
        }
        return $ppid;
    }
    public function showAlt($param_ppid){
        $pp = tPPProduktpass::find($param_ppid);
        if ($pp){
            if (!is_null($pp->PPProduktpass_AltIAN) && strlen($pp->PPProduktpass_AltIAN) > 0 && !is_null($pp->PPProduktpass_AltCharge) && strlen($pp->PPProduktpass_AltCharge) > 0){
                $ian = $pp->PPProduktpass_AltIAN;
                $lot = $pp->PPProduktpass_AltCharge;
                return Redirect::to('/show/'.$ian.'_'.$lot);
            }
        }
        return Redirect::to('/show/'.$param_ppid);
    }
    public function show($param_ppid, $IsInquiry = "0", $avisNr = "", $showdiff = "", $tabs = ""){
        $ppid = $param_ppid;
        if(strlen($param_ppid) == 13){
            $ppid = $this->getVorgaenger_IAN($param_ppid);
            if ($ppid == 0){
                echo("<div style='padding:20px;font-family:arial;font-size:14px;'>Für IAN <b>$param_ppid</b> wurde keine Vorgänger gefunden! </div>");
                exit;
            }
        }
        if(strlen($param_ppid)==11){
            $ian = substr($param_ppid,0,6);
            $ausmusterung = substr($param_ppid,7,4);
            //echo("IAN: $ian Ausmusterung: $ausmusterung");
            $pp = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer', 'like', $ausmusterung.'%')->get()->first();
            if ($pp){
                $ppid =  $pp->PPProduktpass_Id;
            } else {
                echo("<div style='padding:20px;font-family:arial;font-size:14px;'>IAN <b>$ian</b> in der Ausmusterung: <b>$ausmusterung</b> nicht vorhanden! </div>");
                exit;
            }
        }
        if (strlen($param_ppid)==6){
            echo("<div style='padding:20px;font-family:arial;font-size:14px;'>Für IAN <b>$ppid</b> wurde keine Ausmusterung angegeben! </div>");
            exit;
        }
        $maxId = tPPProduktpass::max('PPProduktpass_Id');
        if ($ppid > $maxId){
            echo("<div style='padding:20px;font-family:arial;font-size:14px;'>Produktpass-Id <b>$ppid</b> ausserhalb des Bereichs! Max($maxId) </div>");
            exit;
        }
        return $this->_show($ppid, $IsInquiry , $avisNr , $showdiff , $tabs);
    }
    private function echoFKE ($label){
        if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
            $tDauer = date('U');
            echo("$label: $tDauer <br>");
        }
    }
    public function _show($param_ppid, $IsInquiry = "0", $avisNr = "", $showdiff = "", $tabs = "")
    {
        $tDauer = date('s');
        cpcDebug::cpc_debug("Show: Start ID =>  $param_ppid");
        $data['pp'] = $this->getPP($param_ppid);
        if (is_null($data['pp'])){  
            echo('Ungültiger Link');
            exit;
        }
        $id = $data['pp']->PPProduktpass_Id;
        $firstLetter = substr($id, 0, 1);
        if ($id > 100000) {
            $pptemp = PPProduktpass::where('PPProduktpass_IAN', "=", $id)->get()->first();
            if ($pptemp) {
                $id = $pptemp->PPProduktpass_Id;
            } else {
                echo ("IAN nicht vorhanden!");
                exit;
            }
        }
        if ($avisNr == 0) {
            $avisNr = "";
        }
        if (is_array($tabs)) {
            $data['tabs'] = $tabs;
        } else {
            $data['tabs'] = array('mainTab' => '0', 'mainTabIndex' => 0, 'subTabName' => '', 'subTabIndex' => 0, 'subsubTabIndex' => 0, 'compactView' => 0);
        }
        $data['MengeFinal'] = $this->getMengeFinal($id);
        $data['Zolltarife'] = $this->Zolltarife($id);
        $data['SizeSort'] = $this->SizeSort($id);
        $data['VEProLand'] = $this->VEProLand($id);
        $data['GTIN'] = $this->GTIN($id);
        $data['IsBwOrder'] = $this->IsBWOrder($id);
        $data['ArtikelText'] = $this->getArtikelText($id);
        $data['bwg'] = $this->getBWGroessen();
        $data['haefen'] = $this->getAbgangshaefen();
        $data['lidlhaefen'] = $this->getLidlhaefen();
        $data['frachtfuehrer'] = $this->getFrachtfuehrer();
        $data['spediteure'] = $this->getSpediteure();
        $data['herkunftslaender'] = $this->getHerkunftslaender();
        $data['lieferlaender'] = $this->getLieferlaender($id);
        $data['laenderBloecke'] = $this->getLaenderBloecke($id);
        $data['laenderproblock'] = $this->getLaenderProBlock($id);
        $data['umverpackung'] = $this->getUmverpackungen();
        $data['greenlevel'] = $this->getGreenLevel();
        $data['transportdokch'] = $this->getListboxSimple('TransportDokCH');
        $data['transportdokrs'] = $this->getListboxSimple('TransportDokRS');
        $data['transportdok1'] = $this->getListboxSimple('TransportDok1');
        $data['transportdok2'] = $this->getListboxSimple('TransportDok2');
        $data['LWHD'] = $this->getWarehouseLaenderaufteilung($id);
        $data['LCStati'] = $this->getListboxwithId('LCStatus');
        $data['Lieferbedingungen'] = $this->getListboxwithId('Lieferbedingung');
        $data['StyleTranslation'] = $this->getStyleTranslation($id);
        $data["Retail"] = $this->getRetail();
        $data['Kategorien'] = $this->getKategorien();
        $data['Protokoll']['tPPProduktpass']['PPProduktpass_CRDWoche'] = $this->getProtokoll('tPPProduktpass',$id, 'PPProduktpass_CRDWoche');
        $data['Protokoll']['tPPProduktpass']['PPProduktpass_CRDJahr'] = $this->getProtokoll('tPPProduktpass',$id, 'PPProduktpass_CRDJahr');
        $data['Protokoll']['tPPProduktpass']['PPProduktpass_ArtikelTarga'] = $this->getProtokoll('tPPProduktpass',$id, 'PPProduktpass_ArtikelTarga');
        /*
          if (!$this->IsInquiry($id)) {
          $data['pp'] = PPProduktpass::find($id);
          cpcDebug::cpc_debug("Show: IsPP =>  $id");
          }
          else {
          $data['pp'] = PPInquiry::find($id);
          cpcDebug::cpc_debug("Show: IsInquiry =>  $id");
          }
        */
        $data['ProjektIANs'] = $this->getProjektIANs($data['pp']->PPProduktpass_PPProjekte_Projekt);
        $rev = $data['pp']->PPProduktpass_RevisionAktuell;
        $data['ShowDiff'] = false;
        $ppid_rev = 0;
        //if ($rev > 0) {
        if ($rev == -200) {
                $data['ShowDiff'] = True;
            $rev--;
            if ($this->IsInquiry($id)) {
                $data['pprev'] = PPInquiry::where('PPProduktpass_Id', "=", $data['pp']->PPProduktpass_RevisionVon_PPProduktpass_Id)->first();
            } else {
                $data['pprev'] = PPProduktpass::where('PPProduktpass_RevisionVon_PPProduktpass_Id', "=", $data['pp']->PPProduktpass_RevisionVon_PPProduktpass_Id)->first();
            }
            //cpcDebug::dd($data['pp'], false);
            //cpcDebug::dd($data['pprev']);
            if ($data['pprev']) {
                $ppid_rev = $data['pprev']->PPProduktpass_Id;
            } else {
                $ppid_rev = 0;
            }
        }
        if ($showdiff != "1") {
            $data['ShowDiff'] = False;
        }
        $data['qualitypo'] = $this->getQualitaetPO($id);
        $data['designSort'] = $this->getSortierung($id);
        /*   echo("<pre>");
          foreach ($data['designSort'] as $key => $value) {
          echo("<br>********** $key <br>");
          print_r($value);
          }
          exit; */
        //Berechen gesamtmenge OS ProLand
        $LC = $this->getLC($id);
        $data['LC'] = $LC['LC'];
        $data['LCALL'] = $LC;
        $data['LCTexte'] = $LC['Texte'];
        $data['LCDescGoods'] = $LC['DescGoods'];
        $data['Supplier'] = $LC['Supplier'];
        $data['POS'] = $this->getPurchasesForProjekt($data['pp']->PPProduktpass_PPProjekte_Projekt);
        //var_dump($data['POS']);
        $data['mengeos'] = $this->getMengeOS($id);
        $data['mengeosproland'] = $this->getMengeOSProland($id);
        //cpcDebug::dd($data['mengeos'], true);
        $data['sizes'] = $this->getCountryblockSizes($id);
        $data['tod'] = PPTerms::where('PPTerms_Art', "=", "D")->lists('PPTerms_MC', 'PPTerms_Id');
        $data['top'] = PPTerms::where('PPTerms_Art', "=", "P")->lists('PPTerms_MC', 'PPTerms_Id');
        $data['revisionen'] = PPProduktpass::where('PPProduktpass_RevisionVon_PPProduktpass_Id', "=", $id)->select('PPProduktpass_Id', 'PPProduktpass_RevisionVon_PPProduktpass_Id', 'PPProduktpass_Revisionsnummer', 'PPProduktpass_RevisionDatum')->orderby('PPProduktpass_Revisionsnummer', 'DESC')->get();
        $data['statipo'] = $this->_getStatiX('PO');
        $data['tod'][0] = 'Bitte auswählen...';
        ksort($data['tod']);
        $data['top'][0] = 'Bitte auswählen...';
        ksort($data['top']);
        //DB::select( DB::raw(" Select PPTerms_Id, PPTerms_MC  from PPTerms where PPTerms_Art = 'D'"))->toArray();
        //dd($data['tod']);
        //echo("<pre>");var_dump($data['tod']); echo("</pre>");exit;
        //instr(`PPProduktpass_Sortierung_Laenderblock`, 'OS')
        $qualitaet = PPProduktpass_Qualitaet::where("PPProduktpass_Qualitaet_PPProduktpass_Id", "=", $id)->get()->sortBy('PPProduktpass_Qualitaet_Id');
        $sortierung = PPProduktpass_Sortierung::select(['*', DB::raw('instr(PPProduktpass_Sortierung_Laenderblock,"OS") as SortOrder')])->where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $id)->orderBy('SortOrder')->orderBy('PPProduktpass_Sortierung_Laenderblock')->orderBy('PPProduktpass_Sortierung_Header')->get();
        $style = PPProduktpass_Style::where("PPProduktpass_Style_PPProduktpass_Id", "=", $id)->get()->sortBy('PPProduktpass_Style_Id');
        $styleimages = $this->getStyleImages($id);
        $styleimagesArray = $this->getStyleImagesArray($id);
        //echo("<pre>");var_dump($styleimages);exit;
        $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $id)->get()->first();
        if ($purchase) {
            if (strlen($purchase->PPPurchase_EK_Calc) < 1 or $this->val2num($purchase->PPPurchase_EK_Calc) == 0) {
                $purchase->PPPurchase_EK_Calc = $purchase->PPPurchase_EK;
            }
        } else {
            $purchase = new PPPurchase();
            $purchase->PPPurchase_PPProduktpass_Id = $id;
            if (strlen($purchase->PPPurchase_EK_Calc) < 1 or $this->val2num($purchase->PPPurchase_EK_Calc) == 0) {
                $purchase->PPPurchase_EK_Calc = $purchase->PPPurchase_EK;
            }
            $purchase->save();
        }
        //if ($ppid_rev != 0) {
        /* if (false) {
            $data['mengen_rev'] = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $ppid_rev)->orderBy('PPProduktpass_Menge_CountryBlock')->orderBy('PPProduktpass_Menge_Country')->get();
            $data['qualitaet_rev'] = PPProduktpass_Qualitaet::where("PPProduktpass_Qualitaet_PPProduktpass_Id", "=", $ppid_rev)->get()->sortBy('PPProduktpass_Qualitaet_Id');
            $data['sortierung_rev'] = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $ppid_rev)->get()->sortBy('PPProduktpass_Sortierung_Id');
            $data['style_rev'] = PPProduktpass_Style::where("PPProduktpass_Style_PPProduktpass_Id", "=", $ppid_rev)->get()->sortBy('PPProduktpass_Style_Id');
            $data['purchase_rev'] = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $ppid_rev)->get()->first();
        } */
        if (PPAB::where('PPAB_PPProduktpass_Id', '=', $id)->exists()) {
            $ab = PPAB::where('PPAB_PPProduktpass_Id', '=', $id)->get()->first();
        } else {
            $ab = new PPAB();
            $ab->PPAB_PPProduktpass_Id = $id;
            $ab->save();
        }
        //** Mengen Rottedam, Koper, Barcelona
        $hafenMengen = $this->getHafenMengen($id);
        $ahafenmengen = array();
        /* if (false){
            $ahafenmengen["Rotterdam"] = $this->getMengeHafen($id, "Rotterdam");
            $ahafenmengen["Barcelona"] = $this->getMengeHafen($id, "Barcelona");
            $ahafenmengen["Koper"] = $this->getMengeHafen($id, "Koper");
            $ahafenmengen["Richmond"] = $this->getMengeHafen($id, "Richmond");
        }*/
        $data["hm"] = $ahafenmengen;
        $select = " SELECT SUM(PPProduktpass_Menge_Quantity) As Menge, PPProduktpass_Menge_CountryBlock As CB, PPProduktpass_Menge_PPProduktpass_Id ";
        $select .= " FROM PPProduktpass_Menge ";
        $select .= " group by PPProduktpass_Menge_CountryBlock , ";
        $select .= " PPProduktpass_Menge_PPProduktpass_Id ";
        $select .= " having PPProduktpass_Menge_PPProduktpass_Id= " . $id . " and PPProduktpass_Menge_CountryBlock is not NULL ";
        $cbMengen = DB::select(DB::raw($select));
        //echo("<pre>");var_dump($cbMengen);echo("</pre>");exit;
        $exdate = new DateTime($purchase->PPPurchase_ExcR_Save_Date);
        $purchase->PPPurchase_ExcR_Save_Date = $exdate->format('Y-m-d');
        //var_dump($purchase); exit;
        $suppliers = PPAdressen::where('Art', "=", "8")->orWhere('Art', "=", "7")->orderBy('Matchcode')->lists('Matchcode');
        $adrart = PPAdressarten::all();
        $data['adrart'] = $adrart;
        $ret[' '] = 'Bitte auswählen....';
        foreach ($suppliers as $supplier) {
            $ret[$supplier] = $supplier;
        }
        $data['suppliers'] = $ret;
        $calcSuppliers = PPAdressen::where('Art', "=", "8")->orWhere('Art', "=", "7")->orderBy('Matchcode')->get();
        $ret = array();
        foreach ($calcSuppliers as $supplier) {
            $ret[$supplier->Id] = $supplier;
        }
        $data['calcSuppliers'] = $ret;
        $ausm = substr($data['pp']->PPProduktpass_Ausmusterungnummer, 0, 4);
        $data['AusmusterungStamm'] = AusmusterungStamm::where('AusmusterungStamm_ausmusterung', "=", $ausm)->get()->first();
        $plants = PPAdressen::where('Art', "=", "7")->orderBy('Matchcode')->get();
        $aplant[0] = 'Bitte auswählen....';
        foreach ($plants as $plant) {
            $aplant[$plant->Id] = $plant->Matchcode;
        }
        $data['plants'] = $aplant;
        $data['CertsOfProducer'] = $this->getCertsofProducer($ab->PPAB_Produktionsstaette_Id);
        $m = $this->getMenge($id);
        //$data['menge'] = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $id)->orderBy('PPProduktpass_Menge_Id')->orderBy('PPProduktpass_Menge_Country')->get();
        $data['menge'] = $m['Menge'];
        $data['mengeAlt'] = $m['MengeAlt'];
        $data['importDatum'] = $m['Import'];
        $data['qualitaet'] = $qualitaet;
        $data['sortierung'] = $sortierung;
        $data['style'] = $style;
        $data['styleimages'] = $styleimages;
        $data['styleimagesarray'] = $styleimagesArray;
        $data['files']['typesLB'] = $this->getUploadTypes(True);
        $data['files']['subtypesLB'] = $this->getUploadSubTypes(True);
        $data['files']['types'] = $this->getUploadTypes();
        $data['files']['subtypes'] = $this->getUploadSubTypes();
        $files = $this->getFiles($param_ppid);
        $data['files']['files'] = $files['files'];
        $data['files']['TOTAL'] = $files['TOTAL'];
        $data['files']['TRANSFERD'] = $files['TRANSFERD'];
        $data['purchase'] = $purchase;
        $data['ab'] = $ab;
        $data['hafenMengen'] = $hafenMengen;
        $data['cbmengen'] = $cbMengen;
        $data["XML_lQ"] = $this->getLocalQuantities($id);
        $data['lieferavis_has_data'] = false;
        /*if (false) {
            $data['lieferavis'] = $this->getAvis(14);
            $data['lieferavis_has_data'] = true;
        }*/
        //$data['Lieferavise'] = PPLieferavis::where('PPLieferavis_PPProduktpass_Id', "=", $id)->orderBy('PPLieferavis_AvisNr', 'ASC')->lists('PPLieferavis_Id', 'PPLieferavis_AvisNr'); //->get();
        $data['lieferavisid'] = 0;
        $data['AvisImport'] = null;//$this->getAvisFromIAN($data['pp']->PPProduktpass_IAN);
        $data['message'] = $this->message;
        $data['rp'] = null; //$this->getRechnungspruefung($data['pp']->PPProduktpass_IAN);
        $tbc = new TextbausteineController($id);
        $data['tbs'] = $tbc->getTBS();
        $data['calcs'] = null;// $this->getCalcs($data['pp']->PPProduktpass_Id);
        $data['tAssortment'] = $this->getAssortmentTPT_Targaview($data['pp']->PPProduktpass_Id);
        //cpcDebug::pe($data['tAssortment']['Local']['values'],1);
        $data['Attachments'] = $this->getAttachments_Targaview($data['pp']->PPProduktpass_Id);
        $data['tOrder'] = $this->getOrder_Targaview($data['pp']->PPProduktpass_Id);
        $data['tLsv'] = $this->getLsv_Targaview($data['pp']->PPProduktpass_Id);
        $data['Mitarbeiter'] = $this->getMitarbeiter();
        $InpMan = $this->getInputManuell($data['pp']->PPProduktpass_Id);
        $data['InpMan'] = null;
        $data['InpManVersions'] = null;
        $data['InpManVersionsIsFinal'] = null;
        $data['InpManCompare'] = null;
        if (!is_null($InpMan)) {
            $data['InpMan'] = $InpMan['InpMan'];
            $data['InpManVersions'] = $InpMan['Versions'];
            $data['InpManVersionsIsFinal'] = $InpMan['VersionsIsFinal'];
            $data['InpManCompare'] = $InpMan['Compare'];
            $data['InpContainer'] = $InpMan['Container'];
        }
        $data['FileProtokoll'] = $this->getFileProtokoll($data['pp']->PPProduktpass_Id);
        $data['OrderOverview'] = $this->getOrderOverview($id);
        $data['OrderOverviewOS'] = $this->getOrderOverviewOS($id);
        $data['MengeMenge'] = $this->getMengeMenge($data['pp']->PPProduktpass_Id);
        $data['translation'] = $this->getTranslation($data['pp']->PPProduktpass_Id);
        $data['KLLink'] = $this->getKLLinkedItems($data['pp']->PPProduktpass_Id);
        $oc = new Office365Controller();
        $_ian = $data['pp']->PPProduktpass_IAN;
        $_ausm =  substr($data['pp']->PPProduktpass_Ausmusterungnummer,0,4);
        $data['FilesLastChange'] = $oc->getLastChanged($_ian, $_ausm);
        $mc = new MeetingController();
        $data['MeetingProtokoll'] = $mc->getOrNewMeeting($data['pp']->PPProduktpass_Id);        
        $data['content'] = View::make('projects.main')->with('data', $data);
        $status['anab'] = 'login';
        $status['link'] = 'users/login';
        $status['user'] = 'nn';
        $data['name'] = "Franky";
        $data['userstatus'] = "Happy";
        $data['status'] = $status;
        $data['title'] = 'TPT IAN: ' . $data['pp']->PPProduktpass_IAN;
        $data['DAUER'] = $tDauer;
        return View::make('main', $data);
    }
    public function getKLLinkedItems($ppid)
    {
        $items = PPProduktpass_KLLink::where('PPProduktpass_KLLink_PPProduktpass_Id', $ppid)->get();
        if ($items) {
            return $items;
        }
        return null;
    }
    private function replace0d($text)
    {
        $ret = str_replace("\r\n", "\n", $text);
        return $ret;
    }
    private function getDBTranslation($table, $tableId, $col, $textDE, $reset)
    {
        $prnReset = $reset ? "RESET" : "";
        //cpcDebug::cpc_debug("getDBTranslation: Tabelle: $table   TId: $tableId Column: $col  Reset: $prnReset", "@Trans3");
        $transPP = Translations::where('Translations_Table', $table)->where('Translations_TableId', $tableId)->where('Translations_Column', $col)->get()->first();
        if ($transPP) {
            if ($reset) {
                $transPP->Translations_DE = $textDE;
                $transPP->Translations_EN = $this->translateDeepl($textDE);
                $transPP->save();
                //cpcDebug::cpc_debug("Reset Translation: " . $transPP->Translations_Id ."\nNeue Übersetzung: \n". $transPP->Translations_EN,  "@Trans3");
                return array('Status' => 'Reset', 'DE' => $textDE, 'EN' => $transPP->Translations_EN, 'ID' => $transPP->Translations_Id, 'OLDDE' => '', 'RowCount' => substr_count($textDE, "\n") + 1);
            } else {
                if (!is_null($transPP->Translations_DE) or $this->strcmp_normalized($textDE, $transPP->Translations_DE) === 0) {
                    //cpcDebug::cpc_debug("No Change Translation: " . $transPP->Translations_Id, "@Trans3");
                    return array('Status' => 'OK', 'DE' => trim($textDE), 'EN' => trim($transPP->Translations_EN), 'ID' => $transPP->Translations_Id, 'OLDDE' => '', 'RowCount' => substr_count($textDE, "\n") + 1);
                } else {
                    //cpcDebug::cpc_debug("Change Translation: " . $transPP->Translations_Id, "@Trans3");
                    return array('Status' => 'Change', 'DE' => trim($textDE), 'EN' => trim($transPP->Translations_EN), 'ID' => $transPP->Translations_Id, 'OLDDE' => $transPP->Translations_DE, 'RowCount' => substr_count($textDE, "\n") + 1);
                }
            }
        } else {
            $transPP = new Translations();
            $transPP->Translations_DE = trim($textDE);
            $transPP->Translations_EN = $this->translateDeepl($textDE);
            $transPP->Translations_Table = $table;
            $transPP->Translations_TableId = $tableId;
            $transPP->Translations_Column = $col;
            $transPP->save();
            //cpcDebug::cpc_debug("New Translation: " . $transPP->Translations_Id, "@Trans1");
            $ret = array('Status' => 'New', 'DE' => $textDE, 'EN' => $transPP->Translations_EN, 'ID' => $transPP->Translations_Id, 'OLDDE' => '', 'RowCount' => substr_count($textDE, "\n") + 1);
            return $ret;
        }
        return array('Status' => 'Error', 'DE' => 'Fehler', 'EN' => 'Error', 'ID' => 0, 'OLDDE' => 'FehlerAlt', 'RowCount' => 1);;
    }
    public function getTranslation($ppid, $reset = false)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        $ppId = $pp->PPProduktpass_Id;
        $translation = array();
        $translationWebTab = array();
        $translationStyles = array();
        $IAN = $pp->PPProduktpass_IAN; // . "_" . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        $translation['PPProduktpass_IAN'] = array('Status' => '', 'DE' => $IAN, "EN" => $IAN, 'ID' => 0, 'OLDDE' => '', 'RowCount' => 1);
        $translation['PPProduktpass_Artikelbezeichnung'] = $this->getDBTranslation('PPProduktpass', $ppId, 'PPProduktpass_Artikelbezeichnung', $pp->PPProduktpass_Artikelbezeichnung, $reset);
        $translation['retailPackagingComment'] = $this->getDBTranslation('PPProduktpass', $ppId, 'retailPackagingComment', $pp->retailPackagingComment, $reset);
        $translation['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'] = $this->getDBTranslation('PPProduktpass', $ppId, 'PPProduktpass_Materialstaerke_der_Verkaufsverpackung', $pp->PPProduktpass_Materialstaerke_der_Verkaufsverpackung, $reset);
        $translationWebTab['PPProduktpass_IAN']  = $translation['PPProduktpass_IAN'];
        $translationWebTab['PPProduktpass_Artikelbezeichnung']  = $translation['PPProduktpass_Artikelbezeichnung'];
        $translationWebTab['retailPackagingComment']  = $translation['retailPackagingComment'];
        $translationWebTab['PPProduktpass_Materialstaerke_der_Verkaufsverpackung']  = $translation['PPProduktpass_Materialstaerke_der_Verkaufsverpackung'];
        //PPProduktpass_Ausmusterungnummer
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Style_Id')->get();
        $first = true;
        foreach($styles as $style){
            $styleId = $style->PPProduktpass_Style_Id;
            if ($first){
                $first = false;
                $translation['weightWithoutPackaging'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'weightWithoutPackaging', $style->weightWithoutPackaging, $reset);
                $translation['sizeWithoutPackaging'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'sizeWithoutPackaging', $style->sizeWithoutPackaging, $reset);
                $translation['qualityTechnicalData'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'qualityTechnicalData', $style->qualityTechnicalData, $reset);
                $translation['additionalQualityInformation'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'additionalQualityInformation', $style->additionalQualityInformation, $reset);
                $translation['changesFromPredecessor'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'changesFromPredecessor', $style->changesFromPredecessor, $reset);
                $translation['brandReference'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'brandReference', $style->brandReference, $reset);
                $translation['material'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'material', $style->material, $reset);
                $translation['materialThickness'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'materialThickness', $style->materialThickness, $reset);
                $translation['color'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'color', $style->color, $reset);
                // $translation => $translationStyles 
                $translationStyles[$style->PPProduktpass_Style_Header]['weightWithoutPackaging'] = $translation['weightWithoutPackaging']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'weightWithoutPackaging', $style->weightWithoutPackaging, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['sizeWithoutPackaging'] = $translation['sizeWithoutPackaging']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'sizeWithoutPackaging', $style->sizeWithoutPackaging, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['qualityTechnicalData'] = $translation['qualityTechnicalData']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'qualityTechnicalData', $style->qualityTechnicalData, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['additionalQualityInformation'] = $translation['additionalQualityInformation']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'additionalQualityInformation', $style->additionalQualityInformation, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['changesFromPredecessor'] = $translation['changesFromPredecessor']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'changesFromPredecessor', $style->changesFromPredecessor, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['brandReference'] = $translation['brandReference']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'brandReference', $style->brandReference, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['material'] = $translation['material']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'material', $style->material, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['materialThickness'] = $translation['materialThickness']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'materialThickness', $style->materialThickness, $reset);
                $translationStyles[$style->PPProduktpass_Style_Header]['color'] = $translation['color']; //$this->getDBTranslation('PPProduktpass_Style', $styleId, 'color', $style->color, $reset);
            } else {
            $translationStyles[$style->PPProduktpass_Style_Header]['weightWithoutPackaging'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'weightWithoutPackaging', $style->weightWithoutPackaging, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['sizeWithoutPackaging'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'sizeWithoutPackaging', $style->sizeWithoutPackaging, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['qualityTechnicalData'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'qualityTechnicalData', $style->qualityTechnicalData, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['additionalQualityInformation'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'additionalQualityInformation', $style->additionalQualityInformation, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['changesFromPredecessor'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'changesFromPredecessor', $style->changesFromPredecessor, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['brandReference'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'brandReference', $style->brandReference, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['material'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'material', $style->material, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['materialThickness'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'materialThickness', $style->materialThickness, $reset);
            $translationStyles[$style->PPProduktpass_Style_Header]['color'] = $this->getDBTranslation('PPProduktpass_Style', $styleId, 'color', $style->color, $reset);
        }
        }
        //echo('<pre>');
        //print_r($translation);
        //echo('</pre><pre>');
        //print_r($translationStyles);
        //echo('</pre>');
        //exit;
        //cpcDebug::cpc_debug("getTranslation: " . $ppid . " => " . count($translation) . " Main, " . count($translationStyles) . " Styles",'@TEST');
        //cpcDebug::cpc_debug($translation,'@TEST');
        //cpcDebug::cpc_debug($translationStyles,'@TEST');
        $ret = array('Main'=>  $translation, 'Styles' => $translationStyles, 'WebTab' => $translationWebTab);
        //cpcDebug::cpc_debug("getTranslation: Ende",'@Trans4');
        //cpcDebug::cpc_debug($ret,'@Trans4');
        return $ret;
    }
    public function getFileProtokoll($ppid)
    {
        $ppfiles = DB::table('v_FileProtokoll')->where('PPPPfiles_PPProduktpass_Id', $ppid)->orderBy('updated_at', 'desc')->get();
        if ($ppfiles) {
            return $ppfiles;
        }
        return null;
    }
    public function compareManuellInput($idlast)
    {
        $last = PPInputManuell::where('PPInputManuell_Id', $idlast)->get()->first();
        if (!$last) {
            // echo('A');exit;
            return null;
        }
        $pre = PPInputManuell::where('PPInputManuell_Date', '<', $last->PPInputManuell_Date)->where('PPInputManuell_IsLatest', '0')->where('PPInputManuell_PPProduktpass_Id', $last->PPInputManuell_PPProduktpass_Id)->orderBy('PPInputManuell_date', 'DESC')->get()->first();
        if (!$pre) {
            $pre = $last;
        }
        $numfields = $this->getNumFields();
        $decFields = $numfields['DEC'];
        $intFields = $numfields['INT'];
        $attributes = $last->getAttributes();
        //dd($attributes);
        $compare = array();
        foreach ($attributes as $attribute => $value) {
            $valLast = $last->{$attribute};
            $valPre = $pre->{$attribute};
            if (strpos($decFields, $attribute) !== false) {
                $valLast = number_format($last->{$attribute}, 4, ',', '.');
                $valPre = number_format($pre->{$attribute}, 4, ',', '.');
            }
            if (strpos($intFields, $attribute) !== false) {
                $valLast = number_format($last->{$attribute}, 0, ',', '.');
                $valPre = number_format($pre->{$attribute}, 0, ',', '.');
            }
            $compare[$attribute]['Diff'] = false;
            $compare[$attribute]['Style'] = "color:darkblue;";
            $compare[$attribute]['OldValue'] = $valLast;
            if ($last->{$attribute} != $pre->{$attribute}) {
                $compare[$attribute]['Diff'] = true;
                $compare[$attribute]['Style'] = "color:dodgerblue;";
                $compare[$attribute]['OldValue'] = $valPre;
            }
        }
        //echo('<pre>');print_r($compare);exit;
        return $compare;
    }
    private function newInputManuell($id)
    {
        $man = PPInputManuell::where('PPInputManuell_Id', $id)->get()->first();
        //echo('<br>Start<br>');
        if ($man) {
            $man->PPInputManuell_IsLatest = '0';
            $man->PPInputManuell_StatusPM = '0';
            $man->PPInputManuell_StatusMaWi = '0';
            $man->save();
            $new = new PPInputManuell();
            $attributes = $man->getAttributes();
            foreach ($attributes as $attribute => $value) {
                if ($attribute != 'PPInputManuell_Id') {
                    $new->{$attribute} = $value;
                }
            }
            $new->PPInputManuell_IsLatest = '1';
            //Daten werden NICHT übernommen:
            $new->PPInputManuell_Ausfallrate = 0;
            $new->PPInputManuell_ZukaufServiceWare = 0;
            $new->PPInputManuell_Servicekostensatz = 0;
            $new->PPInputManuell_Preisblatt = '';
            $new->PPInputManuell_EingangsfrachtZFRD = 0;
            $new->PPInputManuell_LogistikZLGK = 0;
            $new->PPInputManuell_AusgangsfrachtZRF2 = 0;
            $new->PPInputManuell_ContHCStk = 0;
            $new->PPInputManuell_ContHCRot = 0;
            $new->PPInputManuell_ContHCBar = 0;
            $new->PPInputManuell_ContHCKop = 0;
            $new->PPInputManuell_ContHCUSA = 0;
            $new->PPInputManuell_Cont40Stk = 0;
            $new->PPInputManuell_Cont40Rot = 0;
            $new->PPInputManuell_Cont40Bar = 0;
            $new->PPInputManuell_Cont40Kop = 0;
            $new->PPInputManuell_Cont40USA = 0;
            $new->PPInputManuell_Cont20Stk = 0;
            $new->PPInputManuell_Cont20Rot = 0;
            $new->PPInputManuell_Cont20Bar = 0;
            $new->PPInputManuell_Cont20Kop = 0;
            $new->PPInputManuell_Cont20USA = 0;
            /*$new->PPInputManuell_ContPlan20 = 0;
            $new->PPInputManuell_ContPlan40 = 0;
            $new->PPInputManuell_ContPlan40HC = 0;
            $new->PPInputManuell_Exportkarton_VE = 0;
            $new->PPInputManuell_Exportkarton_Masse = 0;
            $new->PPInputManuell_Exportkarton_Laenge = 0;
            $new->PPInputManuell_Exportkarton_Breite = 0;
            $new->PPInputManuell_Exportkarton_Hoehe = 0;*/
            $new->PPInputManuell_GutschriftenbetragKunde = 0;
            $new->PPInputManuell_StkProPalette = 0;
            $new->PPInputManuell_DeckelAusfallrate = 0;
            $new->PPInputManuell_IsLatest = '1';
            $new->PPInputManuell_Bemerkungen = '';
            $new->PPInputManuell_Date = date('Y-m-d H:i:s');
            $new->PPInputManuell_UAWGB = '0000-00-00';
            $de = $this->getMengeDE($new->PPInputManuell_PPProduktpass_Id);
            $eu = $this->getMengeEU($new->PPInputManuell_PPProduktpass_Id);
            $new->PPInputManuell_MengeDE = $de['Menge'];
            $new->PPInputManuell_MengeEU = $eu['Menge'];
            $new->save();
        }
        //echo('<br>Ende<br>');
    }
    public function updateInputThema()
    {
        $ppid = Input::get('ppid');
        return Redirect::to('/show/' . $ppid . "#tabs-98");
    }
    private function getNumFields()
    {
        $decFields = "PPInputManuell_GeplanterEKUSD, PPInputManuell_GeplanterVK, PPInputManuell_DeckelAusfallrate, PPInputManuell_Ausfallrate, PPInputManuell_GutschriftenbetragKunde, PPInputManuell_ZukaufServiceWare, PPInputManuell_Servicekostensatz";
        $decFields .= "PPInputManuell_EingangsfrachtZFRD, PPInputManuell_LogistikZLGK, PPInputManuell_AusgangsfrachtZRF2, PPInputManuell_GutschriftenbetragKunde, ";
        $intFields = "PPInputManuell_StkProPalette, PPInputManuell_ContPlan20, PPInputManuell_ContPlan40, PPInputManuell_ContPlan40HC, ";
        $intFields .= "PPInputManuell_Exportkarton_Masse, PPInputManuell_Exportkarton_Laenge, PPInputManuell_Exportkarton_Breite, PPInputManuell_Exportkarton_Hoehe, ";
        $intFields .= "PPInputManuell_Exportkarton_Masse_V2, PPInputManuell_Exportkarton_Laenge_V2, PPInputManuell_Exportkarton_Breite_V2, PPInputManuell_Exportkarton_Hoehe_V2, ";
        $intFields .= "PPInputManuell_KLExportkarton_Masse, PPInputManuell_KLExportkarton_Laenge, PPInputManuell_KLExportkarton_Breite, PPInputManuell_KLExportkarton_Hoehe, ";
        $intFields .= "PPInputManuell_KLExportkarton_Masse_V2, PPInputManuell_KLExportkarton_Laenge_V2, PPInputManuell_KLExportkarton_Breite_V2, PPInputManuell_KLExportkarton_Hoehe_V2, ";
        $intFields .= "PPInputManuell_OSExportkarton_Masse, PPInputManuell_OSExportkarton_Laenge, PPInputManuell_OSExportkarton_Breite, PPInputManuell_OSExportkarton_Hoehe, ";
        $intFields .= "PPInputManuell_OSExportkarton_Masse_V2, PPInputManuell_OSExportkarton_Laenge_V2, PPInputManuell_OSExportkarton_Breite_V2, PPInputManuell_OSExportkarton_Hoehe_V2, ";
        $intFields .= "PPInputManuell_Exportkarton_VE, PPInputManuell_Exportkarton_VE_V2,";
        $intFields .= "PPInputManuell_KLExportkarton_VE, PPInputManuell_KLExportkarton_VE_V2,";
        $intFields .= "PPInputManuell_OSExportkarton_VE, PPInputManuell_OSExportkarton_VE_V2,";
        $intFields .= "PPInputManuell_Masse, PPInputManuell_Laenge, PPInputManuell_Breite, PPInputManuell_Hoehe, PPInputManuell_MengeDE, PPInputManuell_VE, PPInputManuell_MengeEU";
        $intFields .= "PPInputManuell_ContHCRot, PPInputManuell_ContHCBar, PPInputManuell_ContHCKop, PPInputManuell_ContHCUSA, PPInputManuell_ContHCStk, ";
        $intFields .= "PPInputManuell_Cont40Rot, PPInputManuell_Cont40Bar, PPInputManuell_Cont40Kop, PPInputManuell_Cont40USA, PPInputManuell_Cont40Stk, ";
        $intFields .= "PPInputManuell_Cont20Rot, PPInputManuell_Cont20Bar, PPInputManuell_Cont20Kop, PPInputManuell_Cont20USA, PPInputManuell_Cont20Stk,  ";
        $intFields .= "PPInputManuell_KLContPlan20, PPInputManuell_KLContPlan40, PPInputManuell_KLContPlan40HC, PPInputManuell_StkProPalette";
        return array('DEC' => $decFields, 'INT' => $intFields);
    }
    public function updateInputManuellNeu()
    {
        return $this->updateInputManuell(true);
    }
    public function updateInputManuell($neu = false)
    {
        cpcDebug::cpc_debug("updateInputManuell - Start", "@ServiceAnfrage");
        cpcDebug::cpc_debug(Input::all(), "@ServiceAnfrage");
        $ppid = Input::get('ppid');
        //$redirectLink = '/show/' . $ppid . "#tabs-99";
        //if ($neu){
        $redirectLink ='/show/' . $ppid . "/ServiceAnfrage";
        //}
        /* if(Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
            echo('Input<br><pre>');
        var_dump(Input::all());
        echo('</pre>');
            exit;
        } */
        $ppdaten = $this->getPPDatenService($ppid);
        $values = Input::get('man');
        $container = Input::get('container');
        //dd($values);
        $submit = Input::get('submit');
        $id = Input::get('id');
        $cc = Input::get('mailcc');
        $cc2 = Input::get('mailcc2');
        $cc3 = Input::get('mailcc3');
        $isFinale = 0;
        if(Input::has('isFinal')){
            $isFinal = 1;
        } 
        $ccError = false;
        if (strlen($cc) > 3) {
            //Überprüfe ob gültige e-mail Adresse
            if (!filter_var($cc, FILTER_VALIDATE_EMAIL)) {
                $oldCC = $cc;
                $cc = "";
                $ccError = true;
            }
        }
        if (strlen($cc2) > 3) {
            //Überprüfe ob gültige e-mail Adresse
            if (!filter_var($cc2, FILTER_VALIDATE_EMAIL)) {
                $oldCC = $cc2;
                $cc2 = "";
                $ccError = true;
            }
        } 
        if (strlen($cc3) > 3) {
            //Überprüfe ob gültige e-mail Adresse
            if (!filter_var($cc3, FILTER_VALIDATE_EMAIL)) {
                $oldCC = $cc3;
                $cc3 = "";
                $ccError = true;
            }
        }
        if ($submit == 'Neu') {
            //echo ('NEU'); exit;
            $this->newInputManuell($id);
        }
        $man = PPInputManuell::where('PPInputManuell_IsLatest', 1)->where('PPInputManuell_PPProduktpass_Id', $ppid)->orderBy('PPInputManuell_Date', 'desc')->get()->first();
        if (!$man) {
            $man = new PPInputManuell();
            $man->PPInputManuell_PPProduktpass_Id = $ppid;
            $man->PPInputManuell_IsLatest = 1;
            $man->PPInputManuell_Projektname = $ppdaten['Projektname'];
            $man->save();
        }
        if ($submit == 'Uebernahme') {
            $src = PPInputManuell::where('PPInputManuell_IsLatest', 0)->where('PPInputManuell_PPProduktpass_Id', $ppid)->orderBy('PPInputManuell_Date', 'desc')->get()->first();
            if ($src) {
                foreach ($values as $att => $val) {
                    $man->{$att} = $src->{$att};
                }
            }
            $man->save();
            return Redirect::to($redirectLink);
        }
        $numfields = $this->getNumFields();
        $decFields = $numfields['DEC'];
        $intFields = $numfields['INT'];
        if ($man) {
            foreach ($values as $key => $val) {
                if (strpos($decFields, $key) !== false) {
                    $val = $this->Dec2MySql($val);
                }
                if (strpos($intFields, $key) !== false) {
                    $val = $this->Int2MySql($val);
                }
                if ($key == 'PPInputManuell_Projektname' and $val == '') {
                    $val = $ppdaten['Projektname'];
                }
                $man->{$key} = $val;
            }
            $man->PPInputManuell_IsFinal = $isFinale;
            $this->saveContainerVerschiffung($container, $man->PPInputManuell_Id);
            $man->PPInputmanuell_MengeIAN = $ppdaten['Gesamtmenge'];
            $man->save();
            if ($submit == 'Fertig') {
                $man->PPInputManuell_StatusMaWi = 1;
                $man->save();
                cpcDebug::cpc_debug('updateInputManuell - PPID:'.$man->PPInputManuell_PPProduktpass_Id. ' MAId: '.$man->PPInputManuell_Id.' Status switch MaWi 0 => 1' );
                $pp = tPPProduktpass::where('PPProduktpass_Id', $man->PPInputManuell_PPProduktpass_Id)->get()->first();
                $ma = PPMitarbeiter::where('PPMitarbeiter_Id', $pp->PPProduktpass_PMAdmin)->get()->first();
                $id = $pp->PPProduktpass_Id;
                $ian = $pp->PPProduktpass_IAN;
                $to = $ma->PPMitarbeiter_email;
                //$to = 'f.keppel@compecon.de';
                $mail = new MailController();
                $emaillang = ServiceProvider::getMitarbeiterLanguageFromEmail($to);
                $server = "https://" . $_SERVER['SERVER_NAME'];
                $body = "<div style='padding:30px;border:1px solid gray; width:300px;height:150px;'>";
                $body .= "Guten Tag, <br> <br> Für die IAN $ian liegen neue MaWi-Daten zur Service Anfrage vor. <br>";
                $body .= "<a href='" . $server . "/show/" . $ppid . "#tabs-99'>Link zur Serviceanfrage IAN-" . $ian . "</a>";
                $body .= "<div><textarea style='padding:10px;'>" . $man->PPInputManuell_Bemerkungen . "</textarea></div></div>";
                $subject = $pp->PPProduktpass_IAN . "_" . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4) . "_" . $pp->PPProduktpass_Artikelbezeichnung . "_neue MaWi-Daten zur Service Anfrage";
                if ($emaillang != 'DE'){
                    $body = "<div style='padding:30px;border:1px solid gray; width:300px;height:150px;'>";
                    $body .= "Hello, <br> <br> for IAN $ian exist new MaWi-Aata depending Service-Request. <br>";
                    $body .= "<a href='" . $server . "/show/" . $ppid . "#tabs-99'>Link to Servicerequest IAN-" . $ian . "</a>";
                    $body .= "<div><textarea style='padding:10px;'>" . ServiceProvider::translateDirect( $man->PPInputManuell_Bemerkungen ) . "</textarea></div></div>";
                    $subject = $pp->PPProduktpass_IAN . "_" . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4) . "_" . ServiceProvider::translateDirect($pp->PPProduktpass_Artikelbezeichnung) . "_neue MaWi-Daten zur Service Anfrage";
                }
                //459973_2401_Küchenwaage_ neue MaWi-Daten zur Service Anfrage
                $cca = $cc;
                if (strlen($cc2) > 3) {
                    $cca = array($cc, $cc2);
                }
                if (strlen($cc3) > 3) {
                    $cca = array($cc, $cc2, $cc3);
                }
                $mail->sendMail($to, $cca, $subject, $body);
                if ($ccError) {
                    $_subject = 'Mail-Fehler: ' . $pp->PPProduktpass_IAN . "_" . substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4) . "_" . $pp->PPProduktpass_Artikelbezeichnung . "_neue MaWi-Daten zur Service Anfrage";
                    $_body = "Mail enthielt falsches Format im CC: $oldCC";
                    $mail->sendMail($to, $cca, $_subject, $_body);
                }
                //$mail->sendMail($to, $cc, "Neue Daten für die Serviceanfrage zu IAN $ian liegen vor.", $body);
                //$mail->sendMail($to, $cc, $subject, $body, $file );
            }
            return Redirect::to($redirectLink);
        }
        return Redirect::to($redirectLink);
    }
    private function getPPDatenService($ppid)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        $ret['Projektname'] = '';
        $ret['Ausmusterung'] = '';
        $ret['Gesamtmenge'] = 0;
        if ($pp) {
            $ret['Projektname'] = $pp->PPProduktpass_Artikelbezeichnung;
            $ret['Gesamtmenge'] = $pp->PPProduktpass_Gesamtmenge;
            $ret['Ausmusterung'] = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
        }
        //echo("<pre>"); print_r($ret);exit;
        return $ret;
    }
    public function InputManuellInitNeu()
    {
        cpcDebug::cpc_debug('InputNeu', '@T03_1');
        return ($this->InputManuellInit(true));
    }
    public function InputManuellInit($neu = false)
    {
        $ppid = Input::get('ppid');
        $man = new PPInputManuell();
        $man->PPInputManuell_PPProduktpass_Id = $ppid;
        $ppdaten = $this->getPPDatenService($ppid);
        $man->PPInputManuell_Projektname = $ppdaten['Projektname'];
        $man->PPInputManuell_IsLatest = 1;
        $de = $this->getMengeDE($ppid);
        $eu = $this->getMengeEU($ppid);
        $man->PPInputManuell_MengeDE = $de['Menge'];
        $man->PPInputManuell_MengeEU = $eu['Menge'];
        $man->save();
        if ($neu){
            return Redirect::to('/show/'.$ppid.'/ServiceAnfrage');
        }
        return Redirect::to('/show/' . $ppid . '/ServiceAnfrage');
    }
    public function getInputManuell($ppid, $miid = null)
    {
        $ret = array();
        if (!is_null($miid)) {
            $man = PPInputManuell::where('PPInputManuell_Id', $miid)->get()->first();
        } else {
            $man = PPInputManuell::where('PPInputManuell_PPProduktpass_Id', $ppid)->orderBy('PPInputManuell_Date', 'desc')->get()->first();
            if($man){
                $man->PPInputManuell_IsLatest = 1;
                $man->save();
            }
        }
        if ($man) {
            //cpcDebug::cpc_debug('getInputManuell: '.$ppid.' Status PM: '.$man->PPInputManuell_StatusPM.' Status MaWi: '.$man->PPInputManuell_StatusMaWi,'!Service');
            $ret['InpMan'] = $man;
            $mans = PPInputManuell::where('PPInputManuell_PPProduktpass_Id', $ppid)->orderBy('PPInputManuell_Date', 'desc')->get();
            $ret['Versions'] = array();
            $ret['VersionsRemark'] = array();
            $ret['VersionsIsFinal'] = array();
            foreach ($mans as $version) {
                $ret['Versions'][$version->PPInputManuell_Id] = $version->PPInputManuell_Date;
                $ret['VersionsRemark'][$version->PPInputManuell_Id] = $version->PPInputManuell_VersionRemark;
                $ret['VersionsIsFinal'][$version->PPInputManuell_Id] = $version->PPInputManuell_IsFinal;
            }
            //echo($man->PPInputManuell_Id ."<br>");
            $ret['Compare'] = $this->compareManuellInput($man->PPInputManuell_Id);
            $ret['Container'] = $this->getContainerVerschiffungen($man->PPInputManuell_Id);
            //cpcDebug::cpc_debug('getInputManuell - Ende', '-Service1');
            //cpcDebug::cpc_debug($ret, '-Service1');
            return $ret;
        }
        return null;
    }
    private function calculate($calc, $qty, $pvk)
    {
        $calculation['ESP'] = 0;
        $calculation['SKP'] = 0;
        $calculation['VK'] = 0;
        $calculation['VK03'] = 0;
        $calculation['VKVol'] = 0;
        /********************************************************************* */
        $vk = $calc->PPCalculation_VK;
        $kalk['VKP'] = $vk;
        $kalk['VKP3'] = $kalk['VKP'] - ($kalk['VKP'] * 0.3 / 100);
        $kalk['Menge'] = $qty;
        $kalk['EK_FW'] = $calc->PPCalculation_EK;
        $kalk['EK_EUR'] = $calc->PPCalculation_EK * $calc->PPCalculation_ExcR_Calc;
        $kalk['Fracht_Stk'] = 0;
        if ($qty != 0) {
            $kalk['Fracht_Stk'] = $calc->PPCalculation_Ausgangsfrachten / $qty;
        }
        $kalk['Zoll'] = ($kalk['EK_EUR'] + $kalk['Fracht_Stk']) * $calc->PPCalculation_Zoll / 100;
        $kalk['EKProvision'] = $kalk['EK_EUR'] * $calc->PPCalculation_EKProvision / 100;
        $kalk['ESP'] = $kalk['EK_EUR'] + $kalk['Fracht_Stk'] + $kalk['Zoll'] + $kalk['EKProvision'];
        $kalk['Ausgangsfrachten'] = $kalk['Fracht_Stk'];
        $kalk['Pruefkosten'] = $calc->PPCalculation_Pruefkosten;
        $kalk['Finanzierung'] = $kalk['ESP'] * $calc->PPCalculation_Finanzierungskosten / 100;
        $kalk['Lizenz'] = $kalk['VKP'] * $calc->PPCalculation_Lizenzgebuehren / 100;
        $kalk['Kosten'] = 0; //$data['purchase']->PPPurchase_Kosten;
        $kalk['SonstKostenProz'] = 0; //$kalk['VKP'] * $data['purchase']->PPPurchase_SonstKostenProz / 100;
        $kalk['SKP'] = $kalk['ESP'] + $kalk['Ausgangsfrachten'] + $kalk['Finanzierung'] + $kalk['Pruefkosten'] + $kalk['Lizenz'] + $kalk['Kosten'] + $kalk['SonstKostenProz'];
        $calculation['ESP'] = $kalk['ESP'];
        $calculation['EKVol'] = $qty * $kalk['ESP'];
        $calculation['SKP'] = $kalk['SKP'];
        $calculation['VK'] = $kalk['VKP'];
        $calculation['VK03'] = $kalk['VKP3'];
        $calculation['VKVol'] = 0;
        /***************************************************** */
        return $calculation;
        //$esp = $this
    }
    public function postServiceAnfrage()
    {
        $version = Input::get('miid');
        $ppid = Input::get('ppid');
        $inp = $this->getInputManuell($ppid, $version);
        return Response::json(array('message' => "OK", "inp" => $inp));
    }
    private function getCalcs($id)
    {
        $calcs = PPCalculation::where('PPCalculation_PPProduktpass_Id', $id)->orderBy('PPCalculation_Id')->get();
        if ($calcs) {
            $ret['calc'] = null;
            $ret['values'] = null;
            $ret['containers'] = null;
            $pp = tPPProduktpass::where('PPProduktpass_Id', $id)->get()->first();
            $ab = PPAB::where('PPAB_PPProduktpass_Id', $id)->get()->first();
            $totalQty = 0;
            if ($pp) {
                $totalQty = $pp->PPProduktpass_Gesamtmenge;
            }
            foreach ($calcs as $calc) {
                $ret['calc'][$calc->PPCalculation_Id] = $calc;
                $ret['values'][$calc->PPCalculation_Id] = $this->calculate($calc, $totalQty, $ab->PPAB_VKEUR);
                $conts = $this->container($id, $calc->PPCalculation_SupplierLoadHQ);
                $text = "";
                foreach ($conts as $hafen => $cont) {
                    foreach ($cont['Anzahl'] as $art => $menge) {
                        if ($menge > 0) {
                            $text .= "$hafen: $art = $menge<br>";
                        }
                    }
                }
                $ret['containers'][$calc->PPCalculation_Id] = $text;
            }
            return $ret;
        } else {
            $ret['calc'][0] = null;
            $ret['values'][0] = null;
            $ret['containers'][0] = '';
            return $ret;
        }
        return null;
    }
    public function saveTBProject()
    {
        $tbs = Input::get('tbs');
        $ppid = Input::get('ppid');
        //var_dump($tbs); exit;
        $tbc = new TextbausteineController($ppid);
        $tbsOrg = $tbc->getTBS();
        foreach ($tbs as $tbid => $tb) {
            if (strlen(trim($tb)) == 0) {
                $tb = $tbsOrg[$tbid]['text'];
            }
            $tbp = $tbc->getTBUserDefinedRecord($ppid, $tbid);
            if ($tbp) {
                $tbp->PPTextbausteineProjekte_Text = $tb;
                $tbp->save();
            } else {
                $tbp = new PPTextbausteineProjekte();
                $tbp->PPTextbausteineProjekte_PPID = $ppid;
                $tbp->PPTextbausteineProjekte_Textbausteine_Id = $tbid;
                $tbp->PPTextbausteineProjekte_IsActive = 1;
                $tbp->PPTextbausteineProjekte_Text = $tb;
                $tbp->save();
            }
        }
        return $this->show($ppid);
    }
    public function getAvisFromIAN($ian)
    {
        $aviss = AvisKopf::where('AvisKopf_IAN', $ian)->get();
        $k = 0;
        $avisReturn = false;
        foreach ($aviss as $avis) {
            if ($avis) {
                $avisReturn[$k]['Kopf'] = $avis;
                $avisReturn[$k]['Position'] = AvisPositionen::where('AvisPositionen_AvisKopfId', $avis->AvisKopf_Id)->get();
            }
            $k++;
        }
        return $avisReturn;
    }
    public function showp($id)
    {
        //
        //echo($id);
        $pp = PPProduktpass::find($id);
        $data['content'] = View::make('projects.main')->with('pp', $pp);
        //var_dump($data); exit;
        $status['anab'] = 'login';
        $status['link'] = 'users/login';
        $status['user'] = 'nn';
        $data['name'] = "Franky";
        $data['userstatus'] = "Happy";
        $data['status'] = $status;
        return View::make('main', $data);
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
    public function search()
    {
        //phpinfo();exit;
        $status['anab'] = 'login';
        $status['link'] = 'users/login';
        $status['user'] = 'nn';
        $data['name'] = "Franky";
        $data['userstatus'] = "Happy";
        $data['status'] = $status;
        $data['content'] = View::make("projects.search");
        return View::make('main', $data);
    }
    public function setSearch()
    {
        $queryies = Input::get('queries');
        $action = Input::get('action');
        //if (strtoupper($action) === 'OHNE FILTER') echo ('OK<br>'); else echo('nichtOK<br>');
        //var_dump($action);exit;
        Session::pull('queries', 'default');
        foreach ($queryies as $key => $value) {
            $value = str_replace('%', '', $value);
            if (strlen($value) > 0) $value = '%' . $value;
            if (strtoupper($action) === 'OHNE FILTER') $value = '';
            Session::push('queries.' . $key, $value . '%');
        }
        //var_dump($q); exit;
        return $this->showlist($sortierung = "1U");
    }
    public function showlist($sortierung = "1U")
    {
        $status['anab'] = 'login';
        $status['link'] = 'users/login';
        $status['user'] = 'nn';
        $data['name'] = "Franky";
        $data['userstatus'] = "Happy";
        $data['status'] = $status;
        $sortarray = array('PPProduktpass_PPProjekte_Projekt', 'PPProduktpass_IAN', 'PPProduktpass_Status', 'PPProduktpass_Artikelbezeichnung', 'PPProduktpass_Ausmusterung', 'PPProduktpass_Warengruppe', 'PPProduktpass_WAWIArtikelnummer');
        //Suchvariablen Session setzen
        if (Session::has('queries')) {
            $q = Session::get('queries');
            $queries = array();
            foreach ($q as $key => $value) {
                $queries[$key] = $value[0];
            }
        } else {
            foreach ($sortarray as $value) {
                $queries[$value] = '%';
            }
        }
        $sort = substr($sortierung, 0, 1);
        $dir = "asc";
        if (substr($sortierung, 1, 1) == 'D') $dir = "desc";
        //echo($dir."  ".$sort);
        /*
         * $projects = PPProduktpass::where('PPProduktpass_IAN', 'like', $queries['PPProduktpass_IAN'])
          ->where('PPProduktpass_Artikelbezeichnung', 'like', $queries['PPProduktpass_Artikelbezeichnung'])
          ->where('PPProduktpass_Ausmusterung', 'like', $queries['PPProduktpass_Ausmusterung'])
          ->where('PPProduktpass_WAWIArtikelnummer', 'like', $queries['PPProduktpass_WAWIArtikelnummer'])
          ->where("IFNULL(PPProduktpass_PPProjekte_Projekt,'')", 'like', $queries['PPProduktpass_PPProjekte_Projekt'])
          ->where('PPProduktpass_Warengruppe', 'like', $queries['PPProduktpass_Warengruppe'])
          ->where('PPProduktpass_Status', 'like', $queries['PPProduktpass_Status'])
          ->orderBy ($sortarray[$sort-1],$dir)
          ->orderBy ('PPProduktpass_IAN','asc')
          ->get();
        */
        $projects = DB::table('PPProduktpass')
            /* ->where('PPProduktpass_IAN', 'like', $queries['PPProduktpass_IAN'])
                  ->where('PPProduktpass_Artikelbezeichnung', 'like', $queries['PPProduktpass_Artikelbezeichnung'])
                  ->where('PPProduktpass_Ausmusterung', 'like', $queries['PPProduktpass_Ausmusterung'])
                  ->where('PPProduktpass_WAWIArtikelnummer', 'like', $queries['PPProduktpass_WAWIArtikelnummer'])
                  ->whereRaw("IFNULL(PPProduktpass_PPProjekte_Projekt,'') like '".$queries['PPProduktpass_PPProjekte_Projekt']."'")
                  ->where('PPProduktpass_Warengruppe', 'like', $queries['PPProduktpass_Warengruppe'])
                  ->where('PPProduktpass_Status', 'like', $queries['PPProduktpass_Status']) */->orderBy($sortarray[$sort - 1], $dir)->orderBy('PPProduktpass_IAN', 'asc')->get(); //$qqueries = DB::getQueryLog();
        //$last_query = end($qqueries);
        //var_dump($last_query);
        $data['projects'] = $projects;
        $data['queries'] = $queries;
        $data['content'] = View::make("projects.showlist")->with('data', $data);
        return View::make('main', $data);
    }
    public function updateTermineChild($ppid, $type = 'child')
    {
        cpcDebug::cpc_debug("updateTermineChild $ppid $type ", '@Child');
        $ts = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
        if ($ts) {
            foreach ($ts as $t) {
                $sid = $t->PPTermine_PPBoardSpalte_id;
                $s = PPBoardSpalteData::where('PPBoardSpalte_Id', $sid)->get()->first();
                if ($s) {
                    if (strpos($type,'back') !== false) {
                        if (strpos($type,'Child') !== false) {
                            if ($s->PPBoardSpalteData_Child_nB == 0 and $t->PPTermine_Status == 'nicht benötigt'){
                                $t->PPTermine_Status = 'Neu';
                                $t->save();
                            }
                        }
                        if (strpos($type,'Nachbestellung') !== false) {
                            if ($s->PPBoardSpalteData_Nachbestellung == 0 and $t->PPTermine_Status == 'nicht benötigt'){
                                $t->PPTermine_Status = 'Neu';
                                $t->save();
                            }
                        }
                        if (strpos($type,'USA') !== false) {
                            cpcDebug::cpc_debug($s->PPBoardSpalte_Bezeichnung.' => Reset' ,'@Child');
                            if ($s->PPBoardSpalteData_IsUSA == 0 and $t->PPTermine_Status == 'nicht benötigt'){
                                $t->PPTermine_Status = 'Neu';
                                $t->save();
                            }
                        }
                    } else {
                        if ($t->PPTermine_Status == 'Neu') {
                            if ($type == 'child') {
                                if ($s->PPBoardSpalteData_Child_nB == 0) {
                                    $t->PPTermine_Status = 'nicht benötigt';
                                    $t->save();
                                }
                            }
                            if ($type == 'USA') {
                                //if ($isUSOrder) {
                                if ($s->PPBoardSpalte_IsUSA == 0) {
                                    cpcDebug::cpc_debug($s->PPBoardSpalte_Bezeichnung.' => Set' ,'@Child');
                                    $t->PPTermine_Status = 'nicht benötigt';
                                    $t->save();
                                } else {
                                    cpcDebug::cpc_debug($s->PPBoardSpalte_Bezeichnung.' => Not Set' ,'@Child');
                                }
                                //} 
                            }
                        }
                        if ($type == 'Nachbestellung') {
                            if ($s->PPBoardSpalteData_Nachbestellung == 0) {
                                $t->PPTermine_Status = 'nicht benötigt';
                                $t->save();
                            }
                        }
                    }
                }
            }
        }
    }
    public function protokoll($ppid, $table, $id, $att, $oldVal, $newVal ){
        //cpcDebug::cpc_debug("Protokoll: $ppid $att ", '@T1');
        if (is_null($oldVal) and is_null($newVal)){
            return;
        }
        if (is_null($oldVal)){
            if ($newVal == ''){
                return; 
            }
            return;
        }
        if (is_null($newVal)){
            if ($oldVal == ''){
                return; 
            }
            return;
        }
        if ($newVal === $oldVal){
            return;
        }
        $prot = new PPProtokoll();
        $prot->PPProtokoll_Table = $table;
        $prot->PPProtokoll_TableId = $id;
        $prot->PPProtokoll_PPProduktpass_Id = $ppid;
        $prot->PPProtokoll_Benutzer = Auth::user()->PPMitarbeiter_Id;
        $prot->PPProtokoll_Feld = $att; 
        $prot->PPProtokoll_OldContent = $oldVal; 
        $prot->PPProtokoll_NewContent = $newVal; 
        $prot->PPProtokoll_DateTime = date('Y-m-d H:i:s'); 
        $prot->save();
    }
    public  function removeProtokollAll($ppid, $table, $att){
        $ps = PPProtokoll::where('PPProtokoll_Table',$table)->where('PPProtokoll_Feld', $att)->get();
        if ($ps){
            foreach($ps as $p){
                $p->PPProtokoll_isActive = 0;
                $p->save();
            }
        }
    }
    public   function getProtokoll ($table, $id, $field ) {
        $prots = PPProtokoll::where('PPProtokoll_Table', $table)->where('PPProtokoll_PPProduktpass_Id', $id)->where('PPProtokoll_isActive', 1)->where('PPProtokoll_Feld', $field)->orderBy('PPProtokoll_DateTime','DESC')->get();
        $ret = '';
        if ($prots){
            foreach ($prots as $p){
                $user = PPMitarbeiter::find($p->PPProtokoll_Benutzer);
                $date = new DateTime($p->PPProtokoll_DateTime);
                $ret .= $date->format('d.m.Y H:i:s'). ' '. strtoupper($user->PPMitarbeiter_Kuerzel). '  Alt: '. $p->PPProtokoll_OldContent .'  Neu: '. $p->PPProtokoll_NewContent . '<br>';
            }
            return $ret;
        } 
        return null;
    }
    public function update($id)
    {
        //
        //dd(Input::all());
        //echo ("ID $id <br>");
        $input = Input::all();
        cpcDebug::cpc_debug($input, '@T03_2');
        //$input['PPProduktpass_Lizenz']=	$input['PPProduktpass_Lizenz'][0];
        //echo('<pre>');
        //var_dump(Input::all());
        //echo('</pre>');
        //exit;
        /* if (PPProduktpass::find($id)) {
          $pp = PPProduktpass::find($id);
          }
          else {
          $pp = PPInquiry::find($id);
          } */
        $pp = tPPProduktpass::find($id);
        $oldWeek = $pp->PPProduktpass_CRDWoche;
        $oldYear = $pp->PPProduktpass_CRDJahr;
        if ($oldWeek !=  $input['PPProduktpass_CRDWoche']   or $oldYear != $input['PPProduktpass_CRDJahr'] ){
            if ($input['PPProduktpass_CRDWoche'] == 0){
                // Alle Änderungen am CRD rückgängig machen 
                $this->removeProtokollAll($pp->PPProduktpass_Id,'tPPProduktpass','PPProduktpass_CRDWoche');
            } else {
                $this->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_CRDWoche', $oldWeek."/".$oldYear, $input['PPProduktpass_CRDWoche'].'/'.$input['PPProduktpass_CRDJahr'] );
            }
        }
        $oldIAN = $pp->PPProduktpass_IAN;
        $oldCharge = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        if ($oldIAN !=  $input['PPProduktpass_IAN']   or $oldCharge != substr($input['PPProduktpass_Ausmusterungnummer'],0,4) ){
            $this->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_IAN', $oldIAN.' ['.$oldCharge.']', $input['PPProduktpass_IAN'].' ['.$input['PPProduktpass_Ausmusterungnummer'].']' );
            $this->renameIAN_SPO($oldIAN, $oldCharge, $input['PPProduktpass_IAN'],substr($input['PPProduktpass_Ausmusterungnummer'],0,4) );
        }
        $oldArtikel = $pp->PPProduktpass_ArtikelTarga;
        if($input['PPProduktpass_ArtikelTarga'] != $pp->PPProduktpass_ArtikelTarga and $pp->PPProduktpass_Artikelbezeichung != $pp->PPProduktpass_ArtikelTarga){
            $this->protokoll($id, 'tPPProduktpass', $id, 'PPProduktpass_ArtikelTarga', $oldArtikel, $input['PPProduktpass_ArtikelTarga']);
        }
        if ($pp->PPProduktpass_IsChild == 0 and $input['PPProduktpass_IsChild'] == 1) {
            $this->updateTermineChild($pp->PPProduktpass_Id);
        }
        if ($pp->PPProduktpass_IsChild == 1 and $input['PPProduktpass_IsChild'] == 0) {
            $this->updateTermineChild($pp->PPProduktpass_Id,'backChild');
        }
        if ($pp->PPProduktpass_IsKaufland == 0 and $input['PPProduktpass_IsKaufland'] == 1) {
            $this->updateTermineChild($pp->PPProduktpass_Id, 'Nachbestellung');
        }
        if ($pp->PPProduktpass_IsKaufland == 1 and $input['PPProduktpass_IsKaufland'] == 0) {
            $this->updateTermineChild($pp->PPProduktpass_Id, 'backNachbestellung');
        }
        if ($pp->PPProduktpass_IsUSA == 1 and $input['PPProduktpass_IsUSA'] == 0) {
            $this->updateTermineChild($pp->PPProduktpass_Id, 'backUSA');
        }
        if (!isset($input['PPProduktpass_LieferterminJahr']) || $input['PPProduktpass_LieferterminJahr'] == '') {
            $input['PPProduktpass_LieferterminJahr'] = date('Y');
        }
        $input['PPProduktpass_Gesamtmenge'] = $this->Dec2MySql($input['PPProduktpass_Gesamtmenge']);
        $input['PPProduktpass_Produkt_ZusatzGSM'] = $this->Dec2MySql($input['PPProduktpass_Produkt_ZusatzGSM']);
        $input['PPProduktpass_Produkt_GSM'] = $this->Dec2MySql($input['PPProduktpass_Produkt_GSM']);
        $input['PPProduktpass_Produkt_Laenge'] = $this->Dec2MySql($input['PPProduktpass_Produkt_Laenge']);
        $input['PPProduktpass_Produkt_Breite'] = $this->Dec2MySql($input['PPProduktpass_Produkt_Breite']);
        $input['PPProduktpass_Produkt_Hoehe'] = $this->Dec2MySql($input['PPProduktpass_Produkt_Hoehe']);
        foreach ($input as $att => $val) {
            if (strpos($att, 'PPProd') !== false) $pp->{$att} = $val;
        }
        $pp->save();
        //$this->show();
        return Redirect::to('/show/' . $id)->with('message', 'Update!');
    }
    public function updateQualitaet()
    {
        //$input = Input::except('_token');
        $input = Input::get('inp');
        $id = Input::get('ppqid');
        foreach ($input as $key => $row) {
            $ppq = PPProduktpass_Qualitaet::find($key);
            //echo($ppq->PPProduktpass_Qualitaet_Value01."<br>");
            //echo($key." ___<br>");
            foreach ($row as $attr => $value) {
                //echo("      ATTR: ". $attr." VAL: " . $value."<br>");
                if (is_null($value) or !isset($value) or $value == "0") $value = "";
                //if ($attr == 'PPProduktpass_Menge_Quantity') $value = number_format(value,0,'.',',');
                $ppq->{trim($attr)} = $value;
            }
            $ppq->save();
            //echo('<br>');
        }
        //return Redirect::to('/show/' . $id . "#tabs-2")->with('message', 'Update!');
        return Redirect::to('/showAfterUpload/' . $id . "/2");
    }
    private function Int2Mysql($value)
    {
        if (is_null($value) or !isset($value) or $value == "0") {
            return 0;
        }
        $value = str_replace('.', '', $value);
        if (is_numeric($value)) {
            return $value;
        }
        return 0;
    }
    public function Dec2MySql($value)
    {
        if (is_null($value) or !isset($value) or $value == "0") $value = 0.0;
        $value = str_replace('.', 'X', $value);
        $value = str_replace(',', '.', $value);
        $value = str_replace('X', '', $value);
        if (is_numeric($value)) {
            return $value;
        }
        return 0;
    }
    public function getMinLT($lt, $testlt)
    {
        //1. testlt leer  => keine Änderung
        if (strlen(trim($testlt)) != 5) {
            return $lt;
        }
        $tkw = substr($testlt, 0, 2);
        $tjahr = substr($testlt, 3, 2);
        //2. lt leer  => testlt = neuer LT
        if (strlen(trim($lt)) != 5) {
            return $tkw . "/" . $tjahr;
        }
        $kw = substr($lt, 0, 2);
        $jahr = substr($lt, 3, 2);
        if ($tjahr < $jahr) {
            return $tkw . "/" . $tjahr;
        }
        if ($tjahr == $jahr) {
            if ($tkw < $kw) {
                return $tkw . "/" . $tjahr;
            }
        }
        return $lt;
    }
    public function IsInquiry($id)
    {
        $pp = PPProduktpass::find($id);
        if ($pp) {
            return false;
        } else {
            return true;
        }
    }
    public function updateMenge()
    {
        $defval['PPProduktpass_Menge_Quantity'] = 0.0;
        $defval['PPProduktpass_Menge_Rotterdam'] = 0.0;
        $defval['PPProduktpass_Menge_Barcelona'] = 0.0;
        $defval['PPProduktpass_Menge_Koper'] = 0.0;
        $defval['PPProduktpass_Menge_EKUSD'] = 0.0;
        $defval['PPProduktpass_Menge_CBEK'] = 0.0;
        $defval['PPProduktpass_Menge_LT1Menge'] = 0.0;
        $defval['PPProduktpass_Menge_LT2Menge'] = 0.0;
        $defval['PPProduktpass_Menge_LT3Menge'] = 0.0;
        $defval['PPProduktpass_Menge_Kolli'] = 0.0;
        $defval['PPProduktpass_Menge_CountryGSM'] = 0;
        $defval['PPProduktpass_Menge_Trucks'] = 0;
        $defval['PPProduktpass_Menge_CartonsPerPal'] = 0;
        $defval['PPProduktpass_Menge_PcsPerCarton'] = 0;
        $input = Input::get('inp');
        $cbek = Input::get('cbek');
        $id = Input::get('ppqid');
        $minlt = "99/99";
        $kolli = 0;
        foreach ($input as $key => $row) {
            $ppm = PPProduktpass_Menge::find($key);
            if ($ppm) {
                $ppid = $ppm->PPProduktpass_Menge_PPProduktpass_Id;
                //$kolli = 0;
                if ($ppm->PPProduktpass_Menge_Kolli != 0) {
                    $kolli = $ppm->PPProduktpass_Menge_Kolli;
                }
                $minlt = $this->getMinLT($minlt, $row['PPProduktpass_Menge_DeliveryWeek']);
                $minlt = $this->getMinLT($minlt, $row['PPProduktpass_Menge_LT1']);
                $minlt = $this->getMinLT($minlt, $row['PPProduktpass_Menge_LT2']);
                $minlt = $this->getMinLT($minlt, $row['PPProduktpass_Menge_LT3']);
                //echo("    MinLT: ".$minlt."<br>");
                foreach ($row as $attr => $value) {
                    if (isset($defval[$attr])) {
                        if (is_null($value) or !isset($value) or $value == "0" or $value == "") {
                            $value = $defval[$attr];
                        }
                        $value = str_replace('.', 'X', $value);
                        $value = str_replace(',', '.', $value);
                        $value = str_replace('X', '', $value);
                    }
                    //echo("ATT: $attr  VAL: $value <br>");
                    //Update OSMengen
                    $ppm->{trim($attr)} = $value;
                }
                try {
                    $ppm->PPProduktpass_Menge_CBEK = $this->Dec2MySql($cbek[$ppm->PPProduktpass_Menge_CountryBlock]);
                } catch (Exception $ex) {
                }
                $ppm->PPProduktpass_Menge_TotalSalePerUnit = ($ppm->PPProduktpass_Menge_Kolli == 0) ? 0 : $ppm->PPProduktpass_Menge_Quantity / $ppm->PPProduktpass_Menge_Kolli;
                $ppm->save();
            }
        }
        $minltkw = substr($minlt, 0, 2);
        $minltjahr = substr($minlt, 3, 2);
        // echo($ppid);
        if ($this->IsInquiry($ppid)) {
            $pp = PPInquiry::find($ppid);
        } else {
            $pp = PPProduktpass::find($ppid);
        }
        $pp->PPProduktpass_Gesamtmenge = $this->getMengeTotal($ppid);
        $pp->PPProduktpass_Verpackungseinheit = $kolli;
        if ($minltjahr != 99 or $minltkw != 99) {
            $pp->PPProduktpass_Liefertermin = $minltkw;
            $pp->PPProduktpass_LieferterminJahr = $minltjahr + 2000;
        }
        $pp->save();
        //return Redirect::to('/show/' . $id . "#tabs-5")->with('message', 'Update!');
        return Redirect::to('/showAfterUpload/' . $id . "/4");
    }
    public function updatepurchase($id)
    {
        //
        $inp = Input::except('_token');
        $error = false;
        $input = array();
        foreach ($inp as $att => $val) {
            //echo("AT: $att   Val: $val  <br>");
            if (strpos($att, "PPPurchase_") !== false) {
                $input[$att] = $val;
            }
        }
        //var_dump($input);        var_dump($inp);        exit;
        $input['PPPurchase_ExcR_Calc'] = $this->Dec2MySql($input['PPPurchase_ExcR_Calc']);
        $input['PPPurchase_ExcR_Save'] = $this->Dec2MySql($input['PPPurchase_ExcR_Save']);
        $input['PPPurchase_EK_Calc'] = $this->Dec2MySql($input['PPPurchase_EK_Calc']);
        $input['PPPurchase_Fracht'] = $this->Dec2MySql($input['PPPurchase_Fracht']);
        $input['PPPurchase_Zoll'] = $this->Dec2MySql($input['PPPurchase_Zoll']);
        $input['PPPurchase_EKProvision'] = $this->Dec2MySql($input['PPPurchase_EKProvision']);
        $input['PPPurchase_Ausgangsfrachten'] = $this->Dec2MySql($input['PPPurchase_Ausgangsfrachten']);
        $input['PPPurchase_Finanzierungskosten'] = $this->Dec2MySql($input['PPPurchase_Finanzierungskosten']);
        $input['PPPurchase_Pruefkosten'] = $this->Dec2MySql($input['PPPurchase_Pruefkosten']);
        $input['PPPurchase_Lizenzgebuehren'] = $this->Dec2MySql($input['PPPurchase_Lizenzgebuehren']);
        $input['PPPurchase_Kosten'] = $this->Dec2MySql($input['PPPurchase_Kosten']);
        $input['PPPurchase_SonstKostenProz'] = $this->Dec2MySql($input['PPPurchase_SonstKostenProz']);
        $ppp = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $id);
        $ppp->update($input);
        //$this->show();
        //echo('<pre>');var_dump(Input::all());echo('</pre>');
        //return Redirect::to('/show/' . $id . "#tabs-7")->with('message', 'Update!');
        return Redirect::to('/showAfterUpload/' . $id . "/7");
    }
    public function updateSort_Alt()
    {
        //
        //echo ("ID $id <br>");
        if (Input::has('ppid')) $ppid = Input::get('ppid');
        if (Input::has('sort')) $sort_input = Input::get('sort');
        //echo('<pre>');var_dump($sort);echo('</pre>');exit;
        foreach ($sort_input as $sortid => $values) {
            $sort = PPProduktpass_Sortierung::find($sortid);
            foreach ($values as $attr => $value) {
                $sort->{$attr} = $value;
                //echo( " $attr => $value <br>");
            }
            $sort->save();
        }
        //exit;
        //$this->show();
        return Redirect::to('/show/' . $ppid . "#tabs-4");
    }
    public function updateOSSort($sortid, $s, $ve)
    {
        /*  echo("</pre> updateOSSort: $sortid   VE: $ve<pre>");
          print_r($s);
          echo("</pre>"); */
        if (!is_numeric($ve) or $ve == 0) {
            echo ("<br>Fehler<br>");
            return;
        }
        $ossort = PPProduktpass_OSSortMengen::where("PPProduktpass_OSSortMengen_Sortierung_id", "=", $sortid)->get()->first();
        if ($ossort) {
            for ($i = 2; $i <= 7; $i++) {
                $ct = $i - 1;
                if (isset($s["Value0" . $i])) {
                    $att = "PPProduktpass_OSSortMengen_OSMengeSize0" . $ct;
                    try {
                        $newval = floatval($s["Value0" . $i]); // / $ve;
                    } catch (Exception $ex) {
                        $newval = -1;
                    }
                    //echo("OLDValue => " . $ossort->{$att} . " New Value => " . $newval . "<br>");
                    $ossort->{$att} = $newval;
                } else {
                    //echo("Fehler: $ct<br>");
                }
            }
            $ossort->save();
        } else {
            //echo("$sortid nicht gefunden!<br>");
        }
    }
    public function updateSort()
    {
        //
        //echo ("ID $id <br>");
        $ppid = 0;
        $sort = "A";
        if (Input::has('ppid')) $ppid = Input::get('ppid');
        if (Input::has('sort')) $sort_input = Input::get('sort');
        /* echo('<pre>');
          var_dump($sort_input);
          var_dump($ppid);
          echo('</pre>');
          exit; */
        $lb = "X";
        foreach ($sort_input as $sortid => $values) {
            if ($lb != $values['LB']) {
                $lb = $values['LB'];
                $size01 = $values['PPProduktpass_Sortierung_Size01'];
                $size02 = $values['PPProduktpass_Sortierung_Size02'];
                $size03 = $values['PPProduktpass_Sortierung_Size03'];
                $size04 = $values['PPProduktpass_Sortierung_Size04'];
                $size05 = $values['PPProduktpass_Sortierung_Size05'];
                $size06 = $values['PPProduktpass_Sortierung_Size06'];
            }
            $sort = PPProduktpass_Sortierung::find($sortid);
            foreach ($values as $attr => $value) {
                if ($attr == "LB") {
                    continue;
                }
                $sort->{$attr} = $value;
            }
            $sort->PPProduktpass_Sortierung_Size01 = $size01;
            $sort->PPProduktpass_Sortierung_Size02 = $size02;
            $sort->PPProduktpass_Sortierung_Size03 = $size03;
            $sort->PPProduktpass_Sortierung_Size04 = $size04;
            $sort->PPProduktpass_Sortierung_Size05 = $size05;
            $sort->PPProduktpass_Sortierung_Size06 = $size06;
            $sort->save();
            if (strlen($lb) < 9 and strpos($lb, 'OS') !== false) {
                $osl = substr($lb, 4);
                $ossort = array();
                for ($g = 2; $g <= 7; $g++) {
                    $attsrc = "PPProduktpass_Sortierung_Value0" . $g;
                    $attdest = "Value0" . $g;
                    $ossort[$attdest] = $sort->{$attsrc};
                }
                try {
                    $OSVE = $this->getVEProLand($ppid, $osl);
                } catch (Exception $ex) {
                    // echo("Fehler bei $osl <br>");
                    $OSVE = 0;
                }
                $this->updateOSSort($sort->PPProduktpass_Sortierung_Id, $ossort, $OSVE);
            }
            // $OSVE_L = $VEOsSort[$lb]['VE'];
            /*
              if ($ossort) {
              for ($g = 1; $g <= 6; $g++) {
              $attsrc = "PPProduktpass_Sortierung_Size0" . $g;
              $attdest = "PPProduktpass_OSSortMengen_OSMengeSize0" . $g;
              $ossort->{$attdest} = $sort->{$attsrc};
              }
              $ossort->save();
              }
             *
            */
        }
        //$this->show();
        return Redirect::to('/showAfterUpload/' . $ppid . "/3");
        //return Redirect::to('/show/' . $ppid . "#tabs-4");
    }
    public function updateStyle()
    {
        //
        //echo ("ID $id <br>");
        if (Input::has('ppid')) $ppid = Input::get('ppid');
        if (Input::has('style')) $style_input = Input::get('style');
        //echo('<pre>');var_dump($style_input);echo('</pre>');exit;
        foreach ($style_input as $styleid => $values) {
            $style = PPProduktpass_Style::find($styleid);
            foreach ($values as $attr => $value) {
                $style->{$attr} = $value;
                //echo( " $attr => $value <br>");
            }
            $style->save();
        }
        //exit;
        //$this->show();
        return Redirect::to('/showAfterUpload/' . $ppid . "/1");
        //return Redirect::to('/show/' . $ppid . "#tabs-11");
    }
    public function deleteIANSave()
    {
        $startId = 885;
        $pps = tPPProduktpass::where('PPProduktpass_Id', '>', $startId)->get();
        foreach ($pps as $pp) {
            $this->_deleteIANSave($pp->PPProduktpass_IAN);
        }
    }
    private function _deleteIANSave($ian)
    {
        echo ("Lösche <b>$ian</b> <br>");
        $pps = tPPProduktpass::where('PPProduktpass_IAN', 'like', $ian . "%")->get();
        foreach ($pps as $pp) {
            echo ($pp->PPProduktpass_IAN . " ");
            $m = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $q = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $style = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $t = PPTermine::where('PPTermine_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $ab = PPAB::where('PPAB_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $f = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', '=', $pp->PPProduktpass_id);
            $ab->delete();
            $t->delete();
            $s->delete();
            $style->delete();
            $q->delete();
            $m->delete();
            $f->delete();
            $purchase->delete();
            $pp->delete();
            echo (" gelöscht!<br>");
        }
    }
    public function deletePP($id)
    {
        $pp = tPPProduktpass::where('PPProduktpass_Id', '=', $id)->get()->first();
        $m = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id);
        $q = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id);
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id);
        $style = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', '=', $id);
        $t = PPTermine::where('PPTermine_PPProduktpass_Id', '=', $id);
        $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $id);
        $ab = PPAB::where('PPAB_PPProduktpass_Id', '=', $id);
        $f = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', '=', $id);
        if ($ab){$ab->delete();}
        if ($t){$t->delete();}
        if ($s){$s->delete();}
        if ($style){$style->delete();}
        if ($q){$q->delete();}
        if ($m){$m->delete();}
        if ($f){$f->delete();}
        if ($purchase){$purchase->delete();}
        if ($pp){$pp->delete();}
        //$data['content'] = "PP gelöscht!";
        //return View::make('main', $data);
        return $this->showlist();
    }
    public function showDeleteIAN()
    {
        $data['content'] = View::make("helpers.DeletePP");
        return View::make('main', $data);
    }
    public function deleteIAN()
    {
        $noGo = false;
        if (Input::has('delete_ian_confirm')) {
            $this->deletePP(Input::get('delete_ian_id'), Input::get('delete_ian_ian'));
            $data['content'] = "<div style='padding:100px;color:red;'><h3>Produktpass vollständig gelöscht!<h3></div>";
            return View::make('main', $data);
        }
        $ian = Input::get('delete_ian');
        $ausm = Input::get('delete_ausm');
        if (strlen($ausm)!= 4){
            $noGo = true;
        }   
        if (strlen($ian)!= 6){
            $noGo = true;
        }   
        if (!$noGo){
            $pp = tPPProduktpass::where('PPProduktpass_IAN', '=', $ian)->where('PPProduktpass_Ausmusterungnummer', 'like', $ausm.'%')->get()->first();
            if ($pp){
                $data['content'] = View::make("helpers.DeletePPConfirm")->with('pp', $pp);
                return View::make('main', $data);
            }
        }
        echo('IAN nicht vorhanden');
        $server = 'http://'.$_SERVER['SERVER_NAME'].'/formDeleteIAN';
        echo("<a href='".$server."'>zurück</a>");
    }
    public function postdeletep()
    {
        $id = Input::get('id');
        $pp = PPProduktpass::find($id);
        $m = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id);
        $q = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id);
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id);
        $t = PPTermine::where('PPTermine_PPProduktpass_Id', '=', $id);
        $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $id);
        $ab = PPAB::where('PPAB_PPProduktpass_Id', '=', $id);
        $f = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', '=', $id);
        $ab->delete();
        $t->delete();
        $s->delete();
        $q->delete();
        $m->delete();
        $f->delete();
        $purchase->delete();
        $pp->delete();
        //cpcDebug::cpc_debug("postdeletep: $id gelöscht", "FKE2");
        $data['content'] = "PP gelöscht!";
        return View::make('main', $data);
    }
    public function get_phpinfo()
    {
        phpinfo();
        exit;
    }
    public function copyPP($id, $art = "", $Inq = false, $XMLUpload = false)
    {
        if ($Inq) {
            $pp = PPInquiry::find($id);
        } else {
            $pp = PPProduktpass::find($id);
        }
        $ms = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Menge_Id')->get();
        $qs = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Qualitaet_Id')->get();
        $ss = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Sortierung_Id')->get();
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', '=', $id)->orderby('PPProduktpass_Style_Id')->get();
        //$t = PPTermine::where('PPTermine_PPProduktpass_Id','=', $id)->get();
        $purchases = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $id)->get();
        $abs = PPAB::where('PPAB_PPProduktpass_Id', '=', $id)->get();
        //$fs = PPPPFiles::where('PPPPFiles_PPProduktpass_Id','=', $id)->get();
        // evtl.Zugriff über OLDID ???
        if (!isset($pp['PPProduktpass_RevisionAktuell'])) $rev = 0;
        else $rev = $pp['PPProduktpass_RevisionAktuell'];
        //echo("REV: $rev  ".$pp['PPProduktpass_RevisionAktuell']);exit;
        if ($Inq) {
            $ppnew = new PPInquiry();
        } else {
            $ppnew = new PPProduktpass();
        }
        foreach ($pp->toArray() as $key => $value) {
            if ($key != 'PPProduktpass_Id') $ppnew->{$key} = $value;
        }
        $rev_bez = " (Rev." . $rev . ")";
        if ($art == "Import") $rev_bez = " (Import-Rev." . $rev . ")";
        $ppnew->PPProduktpass_Revisionsnummer = $rev;
        $ppnew->PPProduktpass_IAN = $ppnew->PPProduktpass_IAN . $rev_bez;
        //$ppnew->PPProduktpass_IsRevision = 1;
        $ppnew->PPProduktpass_RevisionVon_PPProduktpass_Id = $pp->PPProduktpass_Id;
        $ppnew->PPProduktpass_RevisionDatum = date('Y-m-d');
        $ppnew->save();
        $newid = $ppnew->PPProduktpass_Id;
        $pp->PPProduktpass_RevisionAktuell = $rev + 1;
        $pp->save();
        //Menge kopieren
        foreach ($ms as $m) {
            $mnew = new PPProduktpass_Menge();
            foreach ($m->toArray() as $key => $value) {
                if ($key != 'PPProduktpass_Menge_Id') {
                    $mnew->{$key} = $value;
                    //echo(" $key  => $value <br>");
                }
            }
            $mnew->PPProduktpass_Menge_PPProduktpass_Id = $newid;
            $mnew->save();
        }
        //Qualtitaet kopieren
        foreach ($qs as $q) {
            $qnew = new PPProduktpass_Qualitaet();
            foreach ($q->toArray() as $key => $value) {
                if ($key != 'PPProduktpass_Qualitaet_Id') {
                    $qnew->{$key} = $value;
                    //echo(" $key  => $value <br>");
                }
            }
            $qnew->PPProduktpass_Qualitaet_PPProduktpass_Id = $newid;
            $qnew->save();
        }
        //Sortierung kopieren
        foreach ($ss as $s) {
            $snew = new PPProduktpass_Sortierung();
            foreach ($s->toArray() as $key => $value) {
                if ($key != 'PPProduktpass_Sortierung_Id') {
                    $snew->{$key} = $value;
                    //echo(" $key  => $value <br>");
                }
            }
            $snew->PPProduktpass_Sortierung_PPProduktpass_Id = $newid;
            $snew->save();
        }
        //Style kopieren
        foreach ($styles as $s) {
            $snew = new PPProduktpass_Style();
            foreach ($s->toArray() as $key => $value) {
                if ($key != 'PPProduktpass_Style_Id') {
                    $snew->{$key} = $value;
                    //echo(" $key  => $value <br>");
                }
            }
            $snew->PPProduktpass_Style_PPProduktpass_Id = $newid;
            $snew->save();
        }
        //Purchase kopieren
        foreach ($purchases as $purchase) {
            $purchasenew = new PPPurchase();
            foreach ($purchasenew->toArray() as $key => $value) {
                if ($key != 'PPPurchase_Id') {
                    $purchasenew->{$key} = $value;
                    //echo(" $key  => $value <br>");
                }
            }
            $purchasenew->PPPurchase_PPProduktpass_Id = $newid;
            $purchasenew->save();
        }
        //AB kopieren
        foreach ($abs as $ab) {
            $abnew = new PPAB();
            foreach ($abnew->toArray() as $key => $value) {
                if ($key != 'PPAB_Id') {
                    $abnew->{$key} = $value;
                    //echo(" $key  => $value <br>");
                }
            }
            $abnew->PPAB_PPProduktpass_Id = $newid;
            $abnew->save();
        }
        if ($XMLUpload) {
            return $newid;
        } else {
            $data['content'] = "PP Revision erstellt!";
            return View::make('main', $data);
        }
    }
    public function Delete_getAssortmentTPT_Targaview($ppid)
    {
        $assortments = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', $ppid)->get();
        $a_assortment = array();
        foreach ($assortments as $assortment) {
            $packcount = 0;
            $lbs = $assortment->PPProduktpass_Sortierung_Laenderblock;
            /* if (!isset($a_assortment[$lbs]['pack'])){
                $a_assortment[$lbs]['pack'] = 0;
            }*/
            //$a_assortment[$lbs]['pack'] += $assortment->PPProduktpass_Sortierung_Value02;
            $style = $assortment->PPProduktpass_Sortierung_Header;
            $a_assortment[$lbs]['style'][$style] = array("description" => $assortment->PPProduktpass_Sortierung_Value01, "quantity" => $assortment->PPProduktpass_Sortierung_Value02);
            $packcount += $assortment->PPProduktpass_Sortierung_Value02;
            //$a_assortment[$lbs]['bezeichnung'] = $assortment->PPProduktpass_Sortierung_value1;
            //$a_assortment[$lbs][$style]['menge'] = $assortment->PPProduktpass_Sortierung_value2;
            $laender = explode(',', $lbs);
            $a_laender = array();
            foreach ($laender as $land) {
                $tmp = explode('-', $land);
                if (!isset($a_laender[$tmp[0]])) {
                    $a_laender[$tmp[0]] = "";
                    $komma = '';
                }
                $a_laender[$tmp[0]] = $a_laender[$tmp[0]] . $komma . isset($tmp[1]) ? $tmp[1] : '';
                $komma = ', ';
            }
            $a_assortment[$lbs]['laenderbloecke'] = $a_laender;
            $l = reset($a_laender);
            if (!isset($a_assortment[$lbs]['pack'])) {
                $a_assortment[$lbs]['pack'] = 0;
            }
            $a_assortment[$lbs]['pack'] += $packcount;
            /*
            $pack = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)->where('PPProduktpass_Menge_Country', $l)->get()->first();
            $a_assortment[$lbs]['pack'] = 0;
            if ($pack){
                $a_assortment[$lbs]['pack'] = $pack->PPProduktpass_Menge_TotalSalePerUnit;
            }*/
        }
        //return $a_assortment;
        echo ("<pre>");
        print_r($a_assortment);
        echo("</pre>");
        exit;
    }
    public function getAssortmentTPT_Targaview($ppid)
    {
        $sorts = PPXML_Mengen::where('PPXML_Mengen_PPProduktpass_Id', $ppid)->get();
        $msort = null;
        if ($sorts) {
            $msort = array();
            $mcountries = array();
            $i=1;
            foreach ($sorts as $sort) {
                //echo ($sort->PPXML_Mengen_country . "<br>");
                if (strpos($sort->PPXML_Mengen_country, 'OS') === false) {
                    $gtin = 'NoGTIN';//.$i;
                    if (!is_null($sort->PPXML_Mengen_GTIN) and strlen($sort->PPXML_Mengen_GTIN) > 0) {
                        $gtin = $sort->PPXML_Mengen_GTIN;
                    }
                    $gtinkl = 'NoGTINKL';//.$i;
                    //cpcDebug::pe($sort->PPXML_Mengen_GTINKL);
                    if (!is_null($sort->PPXML_Mengen_GTINKL) and strlen($sort->PPXML_Mengen_GTINKL) > 0) {
                        $gtinkl = $sort->PPXML_Mengen_GTINKL;
                    }
                    $styleNo = 'NoStyleNo'.$i;
                    if (!is_null($sort->PPXML_Mengen_styleNo) and strlen($sort->PPXML_Mengen_styleNo) > 0) {
                        $styleNo = $sort->PPXML_Mengen_styleNo;
                    }
                    $productName = 'NoProductName'.$i;
                    if (!is_null($sort->PPXML_Mengen_productName) and strlen($sort->PPXML_Mengen_productName) > 0) {
                        $productName = $sort->PPXML_Mengen_productName;
                    }
                    $sizeCode = 'NoSizeCode'.$i;
                    if (!is_null($sort->PPXML_Mengen_sizeCode) and strlen($sort->PPXML_Mengen_sizeCode) > 0) {
                        $sizeCode = $sort->PPXML_Mengen_sizeCode;
                    }
                    $lsv = 'NoLSV';//.$i;
                    if (!is_null($sort->PPXML_Mengen_lsv) and strlen($sort->PPXML_Mengen_lsv) > 0) {
                        $lsv = $sort->PPXML_Mengen_lsv;
                    }
                    $country = 'NoCountry'.$i;
                    if (!is_null($sort->PPXML_Mengen_country) and strlen($sort->PPXML_Mengen_country) > 0) {
                        $country = $sort->PPXML_Mengen_country;
                    }
                    $msort[$gtin][$gtinkl][$styleNo][$productName][$sizeCode][$lsv][$country] = $sort->PPXML_Mengen_value;
                    if (isset($mcountries[$country])) {
                        $mcountries[$country] += $sort->PPXML_Mengen_value;
                    } else {
                        $mcountries[$country] = $sort->PPXML_Mengen_value;
                    }
                }
                $i++;
            }
        }
        $sorts = PPXML_OSMengen::where('PPXML_OSMengen_PPProduktpass_Id', $ppid)->get();
        $omsort = null;
        if ($sorts) {
            $omsort = array();
            $lcountries = array();
            $ndxNoGtin = 1;
            $_style = "X";
            foreach ($sorts as $sort) {
                if ($_style != $sort->PPXML_OSMengen_styleNo){
                    $_style = $sort->PPXML_OSMengen_styleNo;
                    $ndxNoGtin ++;
                }
                //echo ($sort->PPXML_Mengen_country . "<br>");
                $lsv = $sort->PPXML_OSMengen_lsv;
                if (is_null($sort->PPXML_OSMengen_lsv)) {
                    $lsv = 'lsv';
                }
                $ndxGTIN = $sort->PPXML_OSMengen_GTIN;
                if (is_null($sort->PPXML_OSMengen_GTIN) or strlen($sort->PPXML_OSMengen_GTIN) <=0){
                    $ndxGTIN = 'NoGTIN';//.$ndxNoGtin;
                }
                $ndxGTINKL = $sort->PPXML_OSMengen_GTINKL;
                if (is_null($sort->PPXML_OSMengen_GTINKL) or strlen($sort->PPXML_OSMengen_GTINKL) <=0){
                    $ndxGTINKL = 'NoGTINKL';//.$ndxNoGtin;
                }
                $omsort[$sort->PPXML_OSMengen_DeliveryNo][$ndxGTIN][$ndxGTINKL][$sort->PPXML_OSMengen_styleNo][$sort->PPXML_OSMengen_productName][$sort->PPXML_OSMengen_sizeName][$lsv][substr($sort->PPXML_OSMengen_country, 4, 4)] = $sort->PPXML_OSMengen_value;
                if (isset($lcountries[$sort->PPXML_OSMengen_country])) {
                    $lcountries[$sort->PPXML_OSMengen_DeliveryNo][$sort->PPXML_OSMengen_country] += $sort->PPXML_OSMengen_value;
                } else {
                    $lcountries[$sort->PPXML_OSMengen_DeliveryNo][$sort->PPXML_OSMengen_country] = $sort->PPXML_OSMengen_value;
                }
            }
        }
        $assorts = DB::table('v_Assortment')->where('PPAssortments_PPProduktpass_Id', $ppid)->get();
        $ass = array();
        $totalPackRatio = array();
        if ($assorts) {
            foreach ($assorts as  $assort) {
                $totalPackRatio[$assort->PPAssortments_countryCodes] = $assort->PPAssortments_totalPackRatio;
                $ass[$assort->PPProduktpass_Artikelbezeichnung][$assort->PPAssortments_countryCodes][$assort->PPAssortments_styleNo][$assort->PPAssortments_productName][$assort->PPAssortments_sizecode] = $assort->PPAssortments_sizevalue;
            }
        }
        $ret = array('Local' => array('values' => $msort, 'countries' => $mcountries), 'Online' => array('values' => $omsort, 'countries' => $lcountries), 'Assortment' => $ass, 'TotalPack' => $totalPackRatio);
        return $ret;
    }
    public function getOSLaender()
    {
        return $laender = array('DE', 'BE', 'NL', 'CZ', 'ES', 'GB', 'FR', 'PL', 'SK', 'AT', 'DK', 'HU', 'IT', 'SI', 'KODE');
    }
    private function prncpc($var, $exit = false)
    {
        if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
            echo ('<pre>');
            print_r($var);
            echo ('</pre>');
            if ($exit) {
                exit;
            }
        }
    }
    public function updateAB($pid)
    {
        $input = Input::except('_token');
        $error = false;
        //echo('<pre>');var_dump($input);echo('</pre>');exit;
        //$iLt = Input::get('LT');
        $iPPAB = Input::get('PPAB');
        $iPPSort = Input::get('PPM');
        $iPPEAN = Input::get('PPMA');
        $iVK = Input::get('VK');
        $iPO = Input::get('PO');
        $isSizeSort = Input::get('bIsSizeSort');
        //echo ('bIsSizeSort: '.$isSizeSort);exit;
        //$ppid = Input::get('ppid');
        //echo('iPPSort##############<br><pre>');var_dump($iPPSort);echo('</pre><br>##############<br>');
        //echo('<pre>');var_dump($iPPEAN);echo('</pre>');exit;
        //echo('<pre>');var_dump($iPPSort);echo('</pre>');exit;
        $ppab = PPAB::find($input['qPPAB_Id']);
        $lidlid_old = $ppab->PPAB_Produktionsstaette_LidlId;
        foreach ($iPPAB as $inp => $value) {
            if ($inp == 'PPAB_VKDAT' or $inp == 'PPAB_VKEUR' or $inp == 'PPAB_VKQMEUR') {
                $value = $this->Dec2MySql($value);
            }
            $ppab->{$inp} = $value;
            //echo(" $inp $value <br>");
        }
        $adr = PPAdressen::find($ppab->PPAB_Produktionsstaette_Id);
        if (!is_null($adr)) {
            if ($adr->PPAdressen_LidlId != $lidlid_old) {
                $ppab->PPAB_Produktionsstaette_LidlId = $adr->PPAdressen_LidlId;
                $ppab->PPAB_Produktionsstaette = $adr->Firma1 . " " . $adr->Adresse1;
                $ppab->PPAB_Abgangshafen = $adr->PPAdressen_Abgangshafen;
                $hkl = PPHerkunftslaender::where("PPHerkunftslaender_Land", "=", $adr->Land)->first();
                //var_dump($hkl->PPHerkunftslaender_Id); exit;
                if ($hkl) {
                    $ppab->PPAB_Herkunftsland = $hkl->PPHerkunftslaender_Id;
                } else {
                    $ppab->PPAB_Herkunftsland = 1;
                }
            }
        }
        $ppab->save();
        //echo("<pre>");var_dump($iPPSort);exit;
        /* if (isset($iPPSort)) {
          foreach ($iPPSort as $kid => $value) {
          //echo("<pre>");var_dump($value);
          if ($isSizeSort) {
          $pps = PPProduktpass_Sortierung::find($kid);
          $pps->PPProduktpass_Sortierung_EAN = $iPPEAN[$kid]['EAN'][1];
          $pps->PPProduktpass_Sortierung_EANOS = $iPPEAN[$kid]['EAN'][1];
          for ($ij = 2; $ij <= count($iPPEAN[$kid]['EAN']); $ij++) {
          $attOSM = 'PPProduktpass_Sortierung_EAN0' . $ij;
          $pps->$attOSM = $iPPEAN[$kid]['EAN'][$ij];
          }
          if (isset($value['aOSMenge'])) {
          $OSSortMengen = $value['aOSMenge'];
          $lm = array();
          foreach ($OSSortMengen as $land => $laenderMenge) {
          //echo('<br><pre>');print_r($land);echo('</pre><br>');
          //echo('<br><pre>');print_r($laenderMenge);echo('</pre><br>');
          if ((PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $kid)
          ->where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->count()) == 0) {
          $OSSortMenge = new PPProduktpass_OSSortMengen();
          //echo ("Neue Länder Sortierung!<br>");
          } else {
          $OSSortMenge = PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $kid)
          ->where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->first();
          //echo ("Länder Sortierung Update!<br>");
          }
          $OSSortMenge->PPProduktpass_OSSortMengen_OSLand = $land;
          for ($ij = 1; $ij <= count($value['aOSMenge'][$land]); $ij++) {
          //echo ("$land<br> $ij .) $laenderMenge[$ij] <br>");
          $attOSM = 'PPProduktpass_OSSortMengen_OSMengeSize0' . $ij;
          $OSSortMenge->$attOSM = $laenderMenge[$ij];
          }
          $OSSortMenge->PPProduktpass_OSSortMengen_Sortierung_id = $kid;
          $OSSortMenge->save();
          }
          }
          } else {
          $pps = PPProduktpass_Sortierung::find($kid);
          $pps->PPProduktpass_Sortierung_EAN = $value["EAN"];
          $pps->PPProduktpass_Sortierung_EANOS = $value["EAN"];
          $oslaender = $this->getOSLaender();
          foreach ($oslaender as $osland) {
          $mBez = "OSMenge" . $osland;
          $mAttrib = 'PPProduktpass_Sortierung_' . $mBez;
          if (isset($value[$mBez])) {
          $pps->$mAttrib = $this->val2num($value[$mBez]);
          }
          }
          //echo(" $kid -> $value <br>");
          }
          $pps->save();
          }
          } */
        //Kopie aus UpdatePo
        $eanOK = "";
        //echo("<pre>");var_dump($iPPSort);exit;
        if (isset($iPPSort)) {
            foreach ($iPPSort as $kid => $value) {
                if ($isSizeSort) {
                    $pps = PPProduktpass_Sortierung::find($kid);
                    $eantest = "OK"; //$this->testEAN($iPPEAN[$kid]['EAN'][1], $kid);
                    if (isset($iPPEAN[$kid]['EAN'])) {
                        if (strpos($eantest, "OK") !== false) {
                            $pps->PPProduktpass_Sortierung_EAN = trim($iPPEAN[$kid]['EAN'][1]);
                            $pps->PPProduktpass_Sortierung_EANOS = trim($iPPEAN[$kid]['EAN'][1]);
                        } else {
                            $pps->PPProduktpass_Sortierung_EAN = '#' . trim($iPPEAN[$kid]['EAN'][1]) . ' (' . $eantest . ')';
                            $pps->PPProduktpass_Sortierung_EANOS = '#' . trim($iPPEAN[$kid]['EAN'][1]) . ' (' . $eantest . ')';
                            $this->message .= " EAN DOPPELT in $eantest";
                        }
                        for ($ij = 2; $ij <= count($iPPEAN[$kid]['EAN']); $ij++) {
                            $eantest = "OK"; //$this->testEAN($iPPEAN[$kid]['EAN'][$ij], $kid);
                            $attOSM = 'PPProduktpass_Sortierung_EAN0' . $ij;
                            if (strpos($eantest, "OK") !== false) {
                                $pps->$attOSM = trim($iPPEAN[$kid]['EAN'][$ij]);
                            } else {
                                $pps->$attOSM = '#' . trim($iPPEAN[$kid]['EAN'][$ij]) . ' (' . $eantest . ')';
                            }
                        }
                    }
                    if (isset($value['aOSMenge'])) {
                        $OSSortMengen = $value['aOSMenge'];
                        $lm = array();
                        foreach ($OSSortMengen as $land => $laenderMenge) {
                            //echo('<br><pre>');print_r($land);echo('</pre><br>');
                            //echo('<br><pre>');print_r($laenderMenge);echo('</pre><br>');
                            if ((PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $kid)->where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->count()) == 0) {
                                $OSSortMenge = new PPProduktpass_OSSortMengen();
                                //echo ("Neue Länder Sortierung!<br>");
                            } else {
                                $OSSortMenge = PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $kid)->where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->first();
                                //echo ("Länder Sortierung Update!<br>");
                            }
                            $OSSortMenge->PPProduktpass_OSSortMengen_OSLand = $land;
                            for ($ij = 1; $ij <= count($value['aOSMenge'][$land]); $ij++) {
                                //echo ("$land<br> $ij .) $laenderMenge[$ij] <br>");
                                $attOSM = 'PPProduktpass_OSSortMengen_OSMengeSize0' . $ij;
                                $OSSortMenge->$attOSM = $this->val2num($laenderMenge[$ij]);
                            }
                            $OSSortMenge->PPProduktpass_OSSortMengen_Sortierung_id = $kid;
                            $OSSortMenge->save();
                        }
                    }
                } else {
                    $pps = PPProduktpass_Sortierung::find($kid);
                    $eantest = "OK"; // $this->testEAN($value["EAN"], $kid);
                    if (strpos($eantest, "OK") !== false) {
                        $pps->PPProduktpass_Sortierung_EAN = ""; //trim($value["EAN"]);
                        $pps->PPProduktpass_Sortierung_EANOS = ""; //                        trim($value["EAN"]);
                    } else {
                        $pps->PPProduktpass_Sortierung_EAN = ""; //'#' . $value["EAN"] . ' (' . $eantest . ')';
                        $pps->PPProduktpass_Sortierung_EANOS; // = '#' . $value["EAN"] . ' (' . $eantest . ')';
                        $this->message .= " EAN DOPPELT in $eantest";
                    }
                    $oslaender = $this->getOSLaender();
                    foreach ($oslaender as $osland) {
                        $mBez = "OSMenge" . $osland;
                        $mAttrib = 'PPProduktpass_Sortierung_' . $mBez;
                        if (isset($value[$mBez])) {
                            $pps->$mAttrib = $this->val2num($value[$mBez]);
                        }
                    }
                    //echo(" $kid -> $value <br>");
                }
                $pps->save();
            }
        }
        //Ende Kopie
        /* foreach ($iLt as $kid => $value) {
          $ppm = PPProduktpass_Menge::find($kid);
          $ppm->PPProduktpass_Menge_DeliveryWeek = $value;
          $ppm->save();
          } */
        foreach ($iVK as $kid => $value) {
            $ppm = PPProduktpass_Menge::find($kid);
            $ppm->PPProduktpass_Menge_VKFOBEUR = $this->Dec2MySql($value);
            $ppm->save();
        }
        if ($iPO['PPPurchase_BWGroesse'] != "Bitte auswählen...") {
            //cpcDebug::dd($ppab->PPAB_PPProduktpass_Id,0);
            //$po = PPPurchase::where("PPPurchase_PPProduktpass_Id","=",$ppab->PPAB_PPProduktpass_Id)->first();
            $this->saveBWLaendergroessen($ppab->PPAB_PPProduktpass_Id, $iPO['PPPurchase_BWGroesse']);
            //$po->PPPurchase_BWGroesse = $iPO['PPPurchase_BWGroesse'];
            //$po->save();
        }
        //echo('<pre>');var_dump($ppab);echo('</pre>');exit;
        //$ppab->update($input);
        //$this->show();
        return Redirect::to('/showAfterUpload/' . $pid . "/8");
        //return Redirect::to('/show/' . $pid . "#tabs-8")->with('message', 'Update!');
    }
    public function testEAN($EAN, $sortid)
    {
        return "OK";
        //Wenn 1 zeichen == Feherzeichen nichts mehr machen
        if (substr($EAN, 0, 1) == "#") return "OK";
        if (trim($EAN) == "") return "OK";
        $eantest = DB::table('v_EANTest')->where('PPProduktpass_Sortierung_EAN', 'like', $EAN)->where('PPProduktpass_Sortierung_Id', '!=', $sortid)->first();
        if (isset($eantest) and count($eantest) == 1) {
            //var_dump($eantest->PPProduktpass_IAN);exit;
            return $eantest->PPProduktpass_IAN;
        }
        if (strlen($EAN) != 13) {
            return ("ERR-LENGHT");
        }
        $code = substr($EAN, 0, 12);
        $key_test = substr($EAN, -1);
        $key = 0;
        $mult = array(1, 3);
        for ($i = 0; $i < strlen($code); $i++) $key += substr($code, $i, 1) * $mult[$i % 2];
        $key = 10 - ($key % 10);
        if ($key == 10) $key = 0;
        // in key steht die prüfziffer - an den code anhängen
        if ($key == $key_test) {
            return "OK";
        }
        return "ERR-PZ $key";
    }
    public function val2date($val)
    {
        if (strlen($val) != 10) {
            return null;
        } else {
            if (strpos($val, ".")) {
                $d = explode(".", $val);
                return $d[2] . "-" . $d[1] . "-" . $d[0];
            } else {
                return $val;
            }
        }
    }
    public function updateLC()
    {
        $lcid = Input::get('PPLC_Id');
        $ppid = Input::get('Produktpass_Id');
        $inp_LC = Input::get('LC');
        $lc = PPLC::where("PPLC_Id", "=", $lcid)->get()->first();
        if ($inp_LC['PPLC_TextPort'] != $lc->PPLC_TextPort) {
            $inp_LC['PPLC_DocumentsRequired'] = "";
            $inp_LC['PPLC_ForTransportationTo'] = "";
        }
        foreach ($inp_LC as $key => $value) {
            if ($key == 'PPLC_Andienung' or $key == 'PPLC_Eroeffnung') {
                $value = $this->val2date($value);
            }
            $lc->$key = $value;
            //echo("$key => $value <br>");
        }
        $lc->save();
        //return Redirect::to('/show/' . $ppid . "#tabs-30")->with('message', " LC Updated! ");
        return Redirect::to('/F/' . $ppid . "/10");
    }
    public function VEProLand($ppid)
    {
        $menges = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $ppid)->get();
        $ret = array();
        foreach ($menges as $menge) {
            $ret[$menge->PPProduktpass_Menge_Country] = array('VE' => number_format($menge->PPProduktpass_Menge_TotalSalePerUnit, 0), 'Menge' => $menge->PPProduktpass_Menge_Quantity);
        }
        return $ret;
    }
    public function getVEProLand($ppid, $l)
    {
        // echo("getVEProLand: $ppid => $l <br>");
        $menge = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $ppid)->where('PPProduktpass_Menge_Country', "=", $l)->get()->first();
        if ($menge) {
            return $menge->PPProduktpass_Menge_Kolli;
        }
        return 0;
    }
    public function SizeSort($ppid)
    {
        $ret = null;
        $sizeindex = null;
        $sortes = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $ppid)->get();
        foreach ($sortes as $sort) {
            for ($i = 1; $i < 10; $i++) {
                $size = "PPProduktpass_Sortierung_Size0" . $i;
                $value = "PPProduktpass_Sortierung_Value0" . ($i + 1);
                if (!is_null($sort->$value) and strlen(trim($sort->$value) > 0)) {
                    //echo("X  ".$sort->{$size}. "Y  ".$sort->{$value}. " <br>");
                    $ndxSize = strlen(trim($sort->{$size})) > 0 ? $sort->{$size} : "S1";
                    $ret[$sort->PPProduktpass_Sortierung_Laenderblock][$sort->PPProduktpass_Sortierung_Header][$sort->PPProduktpass_Sortierung_Value01][$ndxSize] = $sort->$value;
                    //$ret[$sort->PPProduktpass_Sortierung_Laenderblock][$sort->PPProduktpass_Sortierung_Header]["Size$i"][$sort->$size] = $sort->$value;
                    $sizeindex[$ndxSize] = 1;
                } else {
                    //echo("Y $value <br>");
                }
            }
        }
        $retval = array('SizeSort' => $ret, 'Index' => $sizeindex);
        //$this->ddfk ($retval);
        return $retval;
    }
    public function GTINNeu($ppid)
    {
        $gitins = $this->getLocalQuantities($ppid);
        print_r($gitins);
        exit;
    }
    public function GTIN($ppid)
    {
        $ret = array();
        $sortes = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $ppid)->get();
        foreach ($sortes as $sort) {
            $ret[$sort->PPProduktpass_Sortierung_Laenderblock][$sort->PPProduktpass_Sortierung_Header][$sort->PPProduktpass_Sortierung_Value01] = $sort->PPProduktpass_Sortierung_EAN;
        }
        //print_r($ret);
        return $ret;
    }
    public function Zolltarife($ppid)
    {
        $styles = PPProduktpass_Style::where('PPProduktpass_Style_PPProduktpass_Id', '=', $ppid)->get();
        $zolltarife = array();
        foreach ($styles as $style) {
            $zolltarife[$style->PPProduktpass_Style_Header][$style->PPProduktpass_Style_Value01] = $style->PPProduktpass_Style_Zolltarifnummer;
        }
        return $zolltarife;
    }
    public function updatePO()
    {
        /* echo("<pre>");
         dd(Input::all()); */
        $pid = Input::get('Purchase_Id');
        $ppid = Input::get('Produktpass_Id');
        $input = Input::except('_token');
        $inp_po = Input::get('PO');
        //phpinfo();exit;
        //var_dump($inp_po);exit;
        $error = false;
        $inp_qs = Input::get('Q');
        $inp_ppm = Input::get('PPM');
        $inp_ek = Input::get('inp');
        $inp_cbek = Input::get('cb_ek_inp');
        //land-warehouse-distibution: Länderaufteilung (Land, Warehouse, Menge)
        $inp_lwhd = Input::get('LWHD');
        //echo('<pre>');        var_dump($inp_lwhd);        echo('</pre>');        exit;
        $gsm = input::get('GSM');
        if (isset($gsm)) {
            if (strlen(trim($gsm)) <= 0) {
                $gsm = 0;
            }
            $pp = PPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
            if ($pp) {
                $pp->PPProduktpass_Produkt_GSM = $gsm;
                $pp->save();
            }
        }
        if (!is_null($inp_lwhd)) {
            foreach ($inp_lwhd as $key => $value) {
                $this->setWarehouseLaenderaufteilung($value['Id'], $ppid, $value['Land'], $value['Warehouse'], $value['Qty']);
            }
        }
        if (!is_null($inp_cbek)) {
            foreach ($inp_cbek as $key => $value) {
                DB::table('PPProduktpass_Menge')->where('PPProduktpass_Menge_CountryBlock', '=', $key)->update(['PPProduktpass_Menge_CBEK' => $this->Dec2MySql($value)]);
            }
        }
        if (!is_null($inp_ek)) {
            foreach ($inp_ek as $key => $value) {
                DB::table('PPProduktpass_Menge')->where('PPProduktpass_Menge_Id', '=', $key)->update(array('PPProduktpass_Menge_EKUSD' => $this->Dec2MySql($value['PPProduktpass_Menge_EKUSD'])));
            }
        }
        //echo("<pre>");var_dump($inp_ppm);exit;
        foreach ($inp_ppm as $sid => $q) {
            $s = PPProduktpass_Sortierung::find($sid);
            $osland = "";
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeDE) and $s->PPProduktpass_Sortierung_OSMengeDE != 0) {
                    $osland += "OSDE ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeBE) and $s->PPProduktpass_Sortierung_OSMengeBE != 0) {
                    $osland += "OSBE ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeNL) and $s->PPProduktpass_Sortierung_OSMengeNL != 0) {
                    $osland += "OSNL ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeCZ) and $s->PPProduktpass_Sortierung_OSMengeCZ != 0) {
                    $osland += "OSCZ ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeES) and $s->PPProduktpass_Sortierung_OSMengeES != 0) {
                    $osland += "OSES ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeGB) and $s->PPProduktpass_Sortierung_OSMengeGB != 0) {
                    $osland += "OSGB ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeFR) and $s->PPProduktpass_Sortierung_OSMengeFR != 0) {
                    $osland += "OSFR ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengePL) and $s->PPProduktpass_Sortierung_OSMengePL != 0) {
                    $osland += "OSPL ";
                }
            } catch (Exception $e) {
            }
            try {
                if (!is_null($s->PPProduktpass_Sortierung_OSMengeSK) and $s->PPProduktpass_Sortierung_OSMengeSK != 0) {
                    $osland += "OSSK ";
                }
            } catch (Exception $e) {
            }
            //echo("<pre>");var_dump($s);exit;
            if (isset($q['PPProduktpass_Sortierung_Translate_Design'])) $s->PPProduktpass_Sortierung_Translate_Design = $q['PPProduktpass_Sortierung_Translate_Design'];
            if (isset($q['OSMengeDE'])) $s->PPProduktpass_Sortierung_OSMengeDE = $this->Dec2MySql($q['OSMengeDE']);
            if (isset($q['OSMengeBE'])) $s->PPProduktpass_Sortierung_OSMengeBE = $this->Dec2MySql($q['OSMengeBE']);
            if (isset($q['OSMengeNL'])) $s->PPProduktpass_Sortierung_OSMengeNL = $this->Dec2MySql($q['OSMengeNL']);
            if (isset($q['OSMengeCZ'])) $s->PPProduktpass_Sortierung_OSMengeCZ = $this->Dec2MySql($q['OSMengeCZ']);
            if (isset($q['OSMengeES'])) $s->PPProduktpass_Sortierung_OSMengeES = $this->Dec2MySql($q['OSMengeES']);
            if (isset($q['OSMengeGB'])) $s->PPProduktpass_Sortierung_OSMengeGB = $this->Dec2MySql($q['OSMengeGB']);
            if (isset($q['OSMengeFR'])) $s->PPProduktpass_Sortierung_OSMengeFR = $this->Dec2MySql($q['OSMengeFR']);
            if (isset($q['OSMengePL'])) $s->PPProduktpass_Sortierung_OSMengePL = $this->Dec2MySql($q['OSMengePL']);
            if (isset($q['OSMengeSK'])) $s->PPProduktpass_Sortierung_OSMengeSK = $this->Dec2MySql($q['OSMengeSK']);
            if (isset($q['EAN'])) $s->PPProduktpass_Sortierung_EAN = $q['EAN'];
            if (isset($q['EANOS'])) $s->PPProduktpass_Sortierung_EANOS = $q['EANOS'];
            //echo("SID:". $sid." Design:".  $q['PPProduktpass_Sortierung_Translate_Design']." Menge: ".$q['PPProduktpass_Sortierung_OSMenge']."<br>");
            $s->save();
        }
        $po = PPPurchase::find($pid);
        $this->saveBWLaendergroessen($po->PPPurchase_PPProduktpass_Id, $inp_po['PPPurchase_BWGroesse']);
        foreach ($inp_po as $key => $value) {
            switch ($key) {
                case 'PPPurchase_EK':
                    $po->{$key} = $this->Dec2MySql($value);
                    break;
                case 'PPPurchase_FOBQm':
                    $po->{$key} = $this->Dec2MySql($value);
                    break;
                case 'PPPurchase_DeliveryDate':
                    $po->{$key} = $value;
                    if (strlen(trim($value)) < 5) {
                        $po->{$key} = null;
                        if (!is_null($po->PPPurchase_FOBWeek) and strlen(trim($po->PPPurchase_FOBWeek)) > 0) {
                            $dt = new DateTime();
                            $dt->setISODate($po->PPPurchase_FOBYear, $po->PPPurchase_FOBWeek);
                            $po->PPPurchase_DeliveryDate = $dt->format("Y-m-d");
                        }
                    } else {
                        $dt = new DateTime($value);
                        $po->PPPurchase_FOBWeek = $dt->format("W");
                        $po->PPPurchase_FOBYear = $dt->format("Y");
                    }
                    break;
                case 'PPPurchase_FirstSampling':
                    $po->{$key} = $value;
                    if (strlen(trim($value)) < 5) {
                        $po->{$key} = null;
                    }
                    break;
                case 'PPPurchase_SecondSampling':
                    $po->{$key} = $value;
                    if (strlen(trim($value)) < 5) {
                        $po->{$key} = null;
                    }
                    break;
                default:
                    $po->{$key} = addslashes($value);
                    break;
            }
            /* if ($key == 'PPPurchase_EK' or $key == 'PPPurchase_FOBQm') {
              $po->{$key} = $this->Dec2MySql($value);
              } else {
              $po->{$key} = addslashes($value);
              } */
        }
        if (strtoupper($po->PPPurchase_Currency) == "EUR") {
            $po->PPPurchase_ExcR_Save = 1;
            $po->PPPurchase_ExcR_Calc = 1;
        }
        $po->save();
        $iPPSort = Input::get('PPM');
        $isSizeSort = Input::get('bIsSizeSort');
        $iPPEAN = Input::get('PPMA');
        $eanOK = "";
        if (isset($iPPSort)) {
            foreach ($iPPSort as $kid => $value) {
                if ($isSizeSort) {
                    $pps = PPProduktpass_Sortierung::find($kid);
                    $eantest = "OK"; //= $this->testEAN($iPPEAN[$kid]['EAN'][1], $kid);
                    if (strpos($eantest, "OK") !== false) {
                        //     $pps->PPProduktpass_Sortierung_EAN = trim($iPPEAN[$kid]['EAN'][1]);
                        //     $pps->PPProduktpass_Sortierung_EANOS = trim($iPPEAN[$kid]['EAN'][1]);
                    } else {
                        //$pps->PPProduktpass_Sortierung_EAN = '#' . trim($iPPEAN[$kid]['EAN'][1]) . ' (' . $eantest . ')';
                        //$pps->PPProduktpass_Sortierung_EANOS = '#' . trim($iPPEAN[$kid]['EAN'][1]) . ' (' . $eantest . ')';
                        //$this->message .= " EAN DOPPELT in $eantest";
                    }
                    /*
                      for ($ij = 2; $ij <= count($iPPEAN[$kid]['EAN']); $ij++) {
                      //$eantest = $this->testEAN($iPPEAN[$kid]['EAN'][$ij], $kid);
                      $attOSM = 'PPProduktpass_Sortierung_EAN0' . $ij;
                      if (strpos($eantest, "OK") !== false) {
                      //$pps->$attOSM = trim($iPPEAN[$kid]['EAN'][$ij]);
                      } else {
                      //$pps->$attOSM = '#' . trim($iPPEAN[$kid]['EAN'][$ij]) . ' (' . $eantest . ')';
                      }
                      }
                    */
                    if (isset($value['aOSMenge'])) {
                        $OSSortMengen = $value['aOSMenge'];
                        $lm = array();
                        foreach ($OSSortMengen as $land => $laenderMenge) {
                            //echo('<br><pre>');print_r($land);echo('</pre><br>');
                            //echo('<br><pre>');print_r($laenderMenge);echo('</pre><br>');
                            if ((PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $kid)->where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->count()) == 0) {
                                $OSSortMenge = new PPProduktpass_OSSortMengen();
                                //echo ("Neue Länder Sortierung!<br>");
                            } else {
                                $OSSortMenge = PPProduktpass_OSSortMengen::where('PPProduktpass_OSSortMengen_Sortierung_id', '=', $kid)->where('PPProduktpass_OSSortMengen_OSLand', '=', $land)->first();
                                //echo ("Länder Sortierung Update!<br>");
                            }
                            $OSSortMenge->PPProduktpass_OSSortMengen_OSLand = $land;
                            for ($ij = 1; $ij <= count($value['aOSMenge'][$land]); $ij++) {
                                //echo ("$land<br> $ij .) $laenderMenge[$ij] <br>");
                                $attOSM = 'PPProduktpass_OSSortMengen_OSMengeSize0' . $ij;
                                $OSSortMenge->$attOSM = $this->val2num($laenderMenge[$ij]);
                            }
                            $OSSortMenge->PPProduktpass_OSSortMengen_Sortierung_id = $kid;
                            $OSSortMenge->save();
                        }
                    }
                } else {
                    $pps = PPProduktpass_Sortierung::find($kid);
                    if (isset($value["EAN"])) {
                        $eantest = $this->testEAN($value["EAN"], $kid);
                        if (strpos($eantest, "OK") !== false) {
                            $pps->PPProduktpass_Sortierung_EAN = trim($value["EAN"]);
                            $pps->PPProduktpass_Sortierung_EANOS = trim($value["EAN"]);
                        } else {
                            $pps->PPProduktpass_Sortierung_EAN = '#' . $value["EAN"] . ' (' . $eantest . ')';
                            $pps->PPProduktpass_Sortierung_EANOS = '#' . $value["EAN"] . ' (' . $eantest . ')';
                            $this->message .= " EAN DOPPELT in $eantest";
                        }
                    }
                    $oslaender = $this->getOSLaender();
                    foreach ($oslaender as $osland) {
                        $mBez = "OSMenge" . $osland;
                        $mAttrib = 'PPProduktpass_Sortierung_' . $mBez;
                        if (isset($value[$mBez])) {
                            $pps->$mAttrib = $this->val2num($value[$mBez]);
                        }
                    }
                    //echo(" $kid -> $value <br>");
                }
                $pps->save();
            }
        }
        return Redirect::to('/showAfterUpload/' . $ppid . "/9");
        //return Redirect::to('/show/' . $ppid . "#tabs-9")->with('message', " PO Updated! ");
    }
    private function getMasse($m)
    {
        //echo("Getmasse: $m<br>");
        if (isset($m)) {
            if (!is_null($m)) {
                if (strlen(trim($m)) > 0) {
                    if (is_numeric($m)) {
                        //echo("$m is OK! <br>");
                        return $m;
                    }
                }
            }
        }
        //echo($m . " not OK! <br>");
        return 0;
    }
    public function saveBWLaendergroessen($ppid, $bwg)
    {
        $po = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $ppid)->first();
        //$bwg = $po->PPPurchase_BWGroesse;
        /*     if ($bwg != $po->PPPurchase_BWGroesse) { */
        if (true) {
            //$bwg = $po->PPPurchase_BWGroesse;
            $po->PPPurchase_BWGroesse = $bwg;
            $po->save();
            switch ($bwg) {
                case 'Kinder':
                    break;
                case 'Babybettwäsche':
                    break;
                case 'Einzelbett':
                    break;
                case 'Doppelbett':
                    break;
                case 'King Size':
                    break;
                case 'Sondergrösse Kissen':
                    break;
                case 'Seitenschläfer Kissen':
                    break;
                case 'Kissen komplett':
                    break;
                case 'Kissen Sondergrösse komplett':
                    break;
                default:
                    $bwg = "";
                    break;
            }
            //echo("BWG: $bwg <br>");
            if (strlen($bwg) > 1) {
                $gsm = 0;
                $pp = tPPProduktpass::where("PPProduktpass_id", "=", $ppid)->get()->first();
                if ($pp) {
                    $gsm = $pp->PPProduktpass_Produkt_GSM;
                }
                //cpcDebug::dd($pp,1);
                $bwmengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $ppid)->get();
                // echo("Start<br>");
                foreach ($bwmengen as $bwmenge) {
                    //echo( $bwmenge->PPProduktpass_Menge_PPProduktpass_Id . "<br>");
                    //PPProduktpass_Menge_Countrysizes
                    //PPProduktpass_Menge_CountryGSM
                    //PPProduktpass_Menge_Country
                    if ($bwmenge->PPProduktpass_Menge_Quantity > 0) {
                        $land = (strlen($bwmenge->PPProduktpass_Menge_Country) == 4) ? substr($bwmenge->PPProduktpass_Menge_Country, 2, 2) : $bwmenge->PPProduktpass_Menge_Country;
                        $lg = PPBW_Laendergroessen::where('PPBW_Laendergroessen_Land', '=', $land)->where('PPBW_Laendergroessen_Groesse', '=', $bwg)->first();
                        //echo("<pre>");
                        //var_dump($lg);
                        //echo("<br>--------------------------<br>");
                        if ($lg) {
                            // echo("BWL: " . $lg->PPBW_Laendergroessen_Bett_Laenge . "<br>");
                            $f = 1;
                            if ($lg->PPBW_Laendergroessen_Einheit == 'inch') {
                                $f = 2.54;
                            }
                            $bwlaenge = $this->getMasse($lg->PPBW_Laendergroessen_Bett_Laenge);
                            $bwbreite = $this->getMasse($lg->PPBW_Laendergroessen_Bett_Breite);
                            $bwsaumlaenge = $this->getMasse($lg->PPBW_Laendergroessen_Bett_SaumLaenge);
                            $bwsaumbreite = $this->getMasse($lg->PPBW_Laendergroessen_Bett_SaumBreite);
                            $kilaenge = $this->getMasse($lg->PPBW_Laendergroessen_Kissen_Laenge);
                            $kibreite = $this->getMasse($lg->PPBW_Laendergroessen_Kissen_Breite);
                            $kisaumlaenge = $this->getMasse($lg->PPBW_Laendergroessen_Kissen_SaumLaenge);
                            $kisaumbreite = $this->getMasse($lg->PPBW_Laendergroessen_Kissen_SaumBreite);
                            $kianz = $this->getMasse($lg->PPBW_Laendergroessen_Anz_Kissen);
                            $dulaenge = $this->getMasse($lg->PPBW_Laendergroessen_Duvet_Laenge);
                            $dubreite = $this->getMasse($lg->PPBW_Laendergroessen_Duvet_Breite);
                            $dusaumlaenge = $this->getMasse($lg->PPBW_Laendergroessen_Duvet_SaumLaenge);
                            $dusaumbreite = $this->getMasse($lg->PPBW_Laendergroessen_Duvet_SaumBreite);
                            $bbv = $lg->PPBW_Laendergroessen_Bett_Verdoppeln == 'B' ? 2 : 1;
                            $blv = $lg->PPBW_Laendergroessen_Bett_Verdoppeln == 'L' ? 2 : 1;
                            $kbv = $lg->PPBW_Laendergroessen_Kissen_Verdoppeln == 'B' ? 2 : 1;
                            $klv = $lg->PPBW_Laendergroessen_Kissen_Verdoppeln == 'L' ? 2 : 1;
                            $dbv = $lg->PPBW_Laendergroessen_Duvet_Verdoppeln == 'B' ? 2 : 1;
                            $dlv = $lg->PPBW_Laendergroessen_Duvet_Verdoppeln == 'L' ? 2 : 1;
                            $bl = $blv * $bwlaenge * $f + $bwsaumlaenge;
                            $bb = $bbv * $bwbreite * $f + $bwsaumbreite;
                            $kl = $klv * $kilaenge * $f + $kisaumlaenge;
                            $kb = $kbv * $kibreite * $f + $kisaumbreite;
                            $dl = $dlv * $dulaenge * $f + $dusaumlaenge;
                            $db = $dbv * $dubreite * $f + $dusaumbreite;
                            $bqm = $bl * $bb;
                            $kqm = $kianz * $kb * $kl;
                            $dqm = $db * $dl;
                            $qm = ($bqm + $kqm + $dqm) / 10000;
                            $gewicht = round($qm * $gsm, 0);
                            //echo("QM: $qm Gweicht: $gewicht <br>");
                            $bwmenge->PPProduktpass_Menge_Countrysizes = $bwbreite . "x" . $bwlaenge . " + " . $kianz . "* " . $kibreite . "x" . $kilaenge . " " . $lg->PPBW_Laendergroessen_Einheit;
                            $bwmenge->PPProduktpass_Menge_CountryGSM = $gewicht;
                            $bwmenge->save();
                        }
                    }
                }
            } else {
                $bwmengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $ppid)->get();
                foreach ($bwmengen as $bwmenge) {
                    //echo($bwmenge->PPProduktpass_Menge_Country);
                    $bwmenge->PPProduktpass_Menge_Countrysizes = "";
                    $bwmenge->PPProduktpass_Menge_CountryGSM = 0;
                    $bwmenge->save();
                }
            }
        }
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
    public function getAvis($avisnr)
    {
        //$avis = PPLieferavis::where('PPLieferavis_AvisNr', '=', $avisnr)->first();
        $avisnr = 14;
        $avis = PPLieferavis::find($avisnr);
        $avis_id = $avis->PPLieferavis_Id;
        //var_dump($avis_id); exit;
        $avis->PPLieferavis_ETA = $this->_dateMySql2Local($avis->PPLieferavis_ETA);
        $avis->PPLieferavis_ETD = $this->_dateMySql2Local($avis->PPLieferavis_ETD);
        $avis_MARM = PPLieferavis_MARM::where('PPLieferavis_MARM_PPLieferavis_Id', '=', $avis_id)->get();
        $avis_Material = PPLieferavis_Material::where('PPLieferavis_Material_PPLieferavis_Id', '=', $avis_id)->get();
        $avis_BOL = PPLieferavis_BOL::where('PPLieferavis_BOL_PPLieferavis_Id', '=', $avis_id)->get();
        /* echo("AVIS<br><pre>");var_dump($avis);echo("##########################################<br>");
          echo("MARM<br><pre>");var_dump($avis_MARM);echo("##########################################<br>");
          echo("Material<br><pre>");var_dump($avis_Material);exit; */
        $abol = array();
        $j = 0;
        foreach ($avis_BOL as $bol) {
            $abol[$j]['BOL'] = $bol;
            //echo($j."<br>________________________________<br>");
            $avis_Container = PPLieferavis_Container::where('PPLieferavis_Container_PPLieferavis_BOL_Id', '=', $bol->PPLieferavis_BOL_Id)->get();
            $abol[$j]['Container'] = array();
            $i = 0;
            foreach ($avis_Container as $container) {
                $Cid = $container->PPLieferavis_Container_Id;
                //echo($Cid."<br>");
                $abol[$j]['Container'][$i] = $container;
                $contents = PPLieferavis_Container_Content::where('PPLieferavis_Container_Content_PPLieferavis_Container_Id', '=', $Cid)->get();
                $aCont = array();
                foreach ($contents as $content) {
                    $aCont[] = $content;
                }
                $abol[$j]['Container'][$i]['CONTENT'] = $aCont;
                $i++;
            }
            $j++;
        }
        //echo("<pre>");var_dump($abol);exit;
        //return array("AVIS"=>$avis, "BOL" => $avis_BOL, "MATERIAL"=>$avis_Material, "CONTAINER" => $aContainer, "MARM" => $avis_MARM);
        $la = array("AVIS" => $avis, "BOL" => $abol, "MATERIAL" => $avis_Material, "CONTAINER" => array(), "MARM" => $avis_MARM);
        //echo("<pre>");var_dump($la);exit;
        return $la;
        //cpcDebug::dd("Avis", $avis);
        //cpcDebug::dd("BOL", $avis_BOL);
        //cpcDebug::dd("Material", $avis_Material);
        //cpcDebug::dd("Container", $avis_Material);
        //cpcDebug::dd("aContaier", $aContainer, true);
    }
    public function setDefault($field, $value)
    {
        $default['PPLieferavis_Material_Menge'] = 0.0;
        $default['PPLieferavis_BOL_Brutto'] = 0.0;
        $default['PPLieferavis_BOL_Netto'] = 0.0;
        $default['PPLieferavis_Container_Content_Menge'] = 0.0;
        $default['PPLieferavis_Container_Content_Menge'] = 0.0;
        $default['PPLieferavis_MARM_Laenge'] = 0.0;
        $default['PPLieferavis_MARM_Breite'] = 0.0;
        $default['PPLieferavis_MARM_Hoehe'] = 0.0;
        $default['PPLieferavis_MARM_Netto'] = 0.0;
        $default['PPLieferavis_MARM_Brutto'] = 0.0;
        if ($value == "") {
            if (isset($default[$field])) {
                return $default[$field];
            }
        } else {
            if (is_numeric($value)) {
                $value = $this->Dec2MySql($value);
            }
        }
        return $value;
    }
    public function updateAvis()
    {
        //echo("<pre>");var_dump($_POST);echo("</pre><br>");exit;
        //if ($_POST['submit'] != "Go") exit;
        //$this->getAvis("206778");
        $ppid = $_POST['ppid'];
        if ($_POST['SELECT'] == 'NEU') {
            $avisnr = "";
            if (isset($_POST['AVISNR_NEU']) and strlen($_POST['AVISNR_NEU']) > 2) {
                $la = new PPLieferavis();
                $la->PPLieferavis_PPProduktpass_Id = $ppid;
                $la->PPLieferavis_AvisNr = $_POST['AVISNR_NEU'];
                $la->save();
                $avisid = "/" . $la->PPLieferavis_Id;
                //echo("Neues LA<br>");
            } else {
                return Redirect::to('/show/' . $ppid . "#tabs-20")->with('messages', ' Avis Updated!');
            }
            //echo("JA");exit;
            $link = '/show/' . $ppid . $avisid . "#tabs-20";
            //echo($link);exit;
            return Redirect::to($link)->with('messages', ' Avis Neu!');
        } else {
            if ($_POST['SELECT'] != 'Bitte wählen...') {
                return Redirect::to('/show/' . $ppid . '/' . $_POST['SELECT'] . "#tabs-20")->with('messages', ' Avis Updated!');
            }
        }
        //cpcDebug::dd("POST:",$_POST,true);
        //echo("<pre>");var_dump($_POST);echo("</pre><br>");exit;
        $header = $_POST['H'];
        //cpcDebug::dd($header,false);
        if (strlen(trim($header['ETA']) < 10)) {
            $header['ETA'] = null;
        } else {
            $header['ETA'] = $this->_dateLocal2MySql($header['ETA']);
        }
        if (strlen(trim($header['ETD']) < 10)) {
            $header['ETD'] = null;
        } else {
            $header['ETD'] = $this->_dateLocal2MySql($header['ETD']);
        }
        if ($_POST['LierferavisID'] == 0) {
            $la = new PPLieferavis();
            $la->PPLieferavis_PPProduktpass_Id = $ppid;
        } else {
            $la = PPLieferavis::find($_POST['LierferavisID']);
        }
        foreach ($header as $key => $value) {
            //echo ("$key = $value <br>");
            $field = 'PPLieferavis_' . $key;
            $la->{$field} = $value;
        }
        $la->save();
        //cpcDebug::dd($la);
        //exit;
        $laid = $la->PPLieferavis_Id;
        //Materialdaten
        $materialien = $_POST['MD'];
        $matdel = isset($_POST['MDDEL']) ? $_POST['MDDEL'] : array();
        $ndx = $_POST["MD_NDX"];
        //var_dump($matdel); exit;
        //cpcDebug::dd("material:",$materialien,false);
        //cpcDebug::dd("Index:",$_POST["MD_NDX"],true);
        foreach ($materialien as $index => $material) {
            $savema = false;
            if ($ndx[$index] == 0) {
                //cpcDebug::dd("Material",$material,true);
                $material['PPLieferavis_Id'] = $laid;
                if (strlen($material['Materialnr']) > 1) {
                    $ma = new PPLieferavis_Material();
                    //echo("$count_marm  $mat9 ".$material['Materialnr']);exit;
                    // wenn neue 9.Stelleige Nummer => Eintrag in MARM
                    if (strlen($material['Materialnr']) >= 9) {
                        $mat9 = substr($material['Materialnr'], 0, 9);
                        $count_marm = PPLieferavis_MARM::where('PPLieferavis_MARM_SATNR', "=", $mat9)->count();
                        //echo("$count_marm  $mat9 ".$material['Materialnr']);exit;
                        if ($count_marm == 0) {
                            $lmarm = new PPLieferavis_MARM();
                            $lmarm->PPLieferavis_MARM_SATNR = $mat9;
                            $lmarm->PPLieferavis_MARM_PPLieferavis_Id = $laid;
                            $lmarm->save();
                        }
                    }
                    $savema = True;
                }
            } else {
                //echo("Index: $index ");
                if (PPLieferavis_Material::find($ndx[$index])->exists()) {
                    $ma = PPLieferavis_Material::find($ndx[$index]);
                } else {
                    echo (" $ndx[$index] $index  Nicht gefunden!");
                    exit;
                }
                $savema = True;
                if (isset($matdel[$index])) {
                    PPLieferavis_Material::find($ndx[$index])->delete();
                    //echo(" $ndx[$index] $index  gelöscht!");exit;
                    $savema = false;
                }
            }
            if ($savema) {
                foreach ($material as $key => $value) {
                    //echo ("$key = $value <br>");
                    $field = 'PPLieferavis_Material_' . $key;
                    $ma->{$field} = $this->setDefault($field, $value);
                }
                $ma->save();
            }
        }
        $marms = $_POST['MARM'];
        $ndx = $_POST['MARM_NDX'];
        $marmdel = isset($_POST['MARMDEL']) ? $_POST['MARMDEL'] : array();
        foreach ($marms as $index => $marm) {
            $marmsave = false;
            if ($ndx[$index] == 0) {
                if (strlen($marm['SATNR'] > 0)) {
                    $marmd = new PPLieferavis_MARM();
                    $marmd->PPLieferavis_MARM_PPLieferavis_Id = $laid;
                    $marmsave = true;
                }
            } else {
                if (PPLieferavis_MARM::find($ndx[$index])->exists()) {
                    $marmd = PPLieferavis_MARM::find($ndx[$index]);
                } else {
                    echo ("MARAM nicht gefunden");
                    exit;
                }
                if (isset($marmdel[$index])) {
                    PPLieferavis_MARM::find($ndx[$index])->delete();
                    //echo(" $ndx[$index] $index  gelöscht!");exit;
                    $marmsave = false;
                }
                $marmsave = true;
            }
            if ($marmsave) {
                foreach ($marm as $key => $value) {
                    //echo ("$key = $value <br>");
                    $field = 'PPLieferavis_MARM_' . $key;
                    $marmd->{$field} = $this->setDefault($field, $value);
                }
                $marmd->save();
            }
        }
        //exit;
        //Bill of lading
        $bols = isset($_POST['BOL']) ? $_POST['BOL'] : array();
        $bndx = isset($_POST["BOL_NDX"]) ? $_POST["BOL_NDX"] : array();
        $boldel = isset($_POST['BOLDEL']) ? $_POST['BOLDEL'] : array();
        //var_dump($boldel);exit;
        $bolid = 0;
        foreach ($bols as $index => $bol) {
            $savebol = false;
            $bolid = $bndx[$index];
            if ($bndx[$index] == 0) {
                if (strlen($bol['BOLNr']) > 0) {
                    $bold = new PPLieferavis_BOL();
                    $bold->PPLieferavis_BOL_PPLieferavis_Id = $laid;
                    $bolid = $bold->PPLieferavis_BOL_Id;
                    $savebol = true;
                }
            } else {
                if (!is_null(PPLieferavis_BOL::find($bndx[$index]))) {
                    $bold = PPLieferavis_BOL::find($bndx[$index]);
                    $bolid = $bold->PPLieferavis_BOL_Id;
                } else {
                    echo ("BILnicht gefunden!");
                    exit;
                }
                $savebol = true;
                if (isset($boldel[$bolid])) {
                    PPLieferavis_BOL::find($bndx[$index])->delete();
                    //Aufräumen
                    $del_conts = PPLieferavis_Container::where("PPLieferavis_Container_PPLieferavis_BOL_Id", "=", $bolid)->get();
                    foreach ($del_conts as $del_cont) {
                        PPLieferavis_Container_Content::where("PPLieferavis_Container_Content_PPLieferavis_Container_Id", "=", $del_cont->PPLieferavis_Container_Id)->delete();
                    }
                    PPLieferavis_Container::where("PPLieferavis_Container_PPLieferavis_BOL_Id", "=", $bolid)->delete();
                    $savebol = false;
                }
            }
            if ($savebol) {
                foreach ($bol as $key => $value) {
                    //echo ("$key = $value <br>");
                    $field = 'PPLieferavis_BOL_' . $key;
                    $bold->{$field} = $this->setDefault($field, $value);
                }
                $bold->save();
            }
            $ndx = isset($_POST["CON_NDX[" . $bolid . "]"]) ? $_POST["CON_NDX[" . $bolid . "]"] : array();
            $ndx1 = isset($_POST["CONT_NDX"]) ? $_POST["CONT_NDX"] : array();
            $tcons = isset($_POST['CON']) ? $_POST['CON'] : array();
            $containers = array();
            if ($bolid != 0) {
                if (isset($tcons[$bolid])) {
                    $containers = $tcons[$bolid];
                }
            }
            //echo("<br><pre>");var_dump($containers); echo("<br>________________________________________<br>");
            foreach ($containers as $tcid => $container) {
                //echo("<br><pre>");var_dump($container); echo("<br>________________________________________<br>");
                $consave = false;
                if ($tcid == 0) {
                    if (strlen($container['ContainerId']) > 0) {
                        $con = new PPLieferavis_Container();
                        $con->PPLieferavis_Container_PPLieferavis_Id = $laid;
                        //$con ->PPLieferavis_Container_BOL_Id = $container[]
                        $consave = true;
                    }
                } else {
                    //echo("LA_Container Suche: $tcid   <br>-------------------<br>");
                    if (!is_null(PPLieferavis_Container::find($tcid))) {
                        $con = PPLieferavis_Container::find($tcid);
                        $consave = true;
                    }
                }
                if ($consave) {
                    foreach ($container as $key => $value) {
                        //echo("Index: $index  Key: $key => Value: ");var_dump($value); echo("<br>----------------------------------<br>");
                        $field = 'PPLieferavis_Container_' . $key;
                        if (!is_array($value)) {
                            $con->{$field} = $value;
                        } else {
                            $con->save();
                            foreach ($value as $index1 => $content) {
                                $contsave = false;
                                //echo("INDEX $index $index1   <br>");
                                //cpcDebug::dd("ndx1",$ndx1[$index][$index1]);cpcDebug::dd("VEPOS",$content['VEPos']);
                                if ($index1 == 0) {
                                    if (strlen($content['VEPos']) > 0) {
                                        //echo("Neu<br> $con->PPLieferavis_Container_Id <br>");
                                        //$con_cont = new PPLieferavis_Container_Content ();
                                        //$con_cont->PPLieferavis_Container_Content_PPLieferavis_Container_Id = $con->PPLieferavis_Container_Id;
                                        $contsave = true;
                                        //echo("Cont new:   $con->PPLieferavis_Container_Id <br>");
                                    }
                                } else {
                                    $con_cont = PPLieferavis_Container_Content::find($index1);
                                    //echo("Cont gefunden:   $con_cont->PPLieferavis_Container_Content_VEPos <br>");
                                    $contsave = true;
                                }
                                if ($contsave) {
                                    //echo(" <b>$con_cont->PPLieferavis_Container_Content_Id </b><br>");
                                    foreach ($content as $id => $val) {
                                        $field1 = 'PPLieferavis_Container_Content_' . $id;
                                        //echo(" $field1 $val <br>");
                                        $con_cont->{$field1} = $this->setDefault($field1, $val);
                                    }
                                    //echo(" ____________  <br>");
                                    $con_cont->save();
                                }
                            }
                        }
                    }
                    $con->save();
                }
            }
        }
        //exit;
        //Container löschen
        $condel = isset($_POST['CONDEL']) ? $_POST['CONDEL'] : array();
        foreach ($condel as $cid => $value) {
            if (!is_null(PPLieferavis_Container::find($cid))) {
                PPLieferavis_Container::find($cid)->delete();
                PPLieferavis_Container_Content::where("PPlieferavis_Container_Content_PPlieferavis_Container_Id", "=", $cid)->delete();
            }
        }
        $contdel = isset($_POST['CONTDEL']) ? $_POST['CONTDEL'] : array();
        foreach ($contdel as $ctid => $value) {
            if (!is_null(PPLieferavis_Container_Content::find($ctid))) {
                PPLieferavis_Container_Content::find($ctid)->delete();
            }
        }
        //exit;
        if (isset($_POST['submit']) and $_POST['submit'] == "NewBOL") {
            if (isset($_POST['BOLNRNEW']) and strlen($_POST['BOLNRNEW']) > 0) {
                //echo("JA"); exit;
                $newbol = new PPLieferavis_BOL();
                $newbol->PPLieferavis_BOL_PPLieferavis_Id = $la->PPLieferavis_Id;
                $newbol->PPLieferavis_BOL_BOLNr = $_POST['BOLNRNEW'];
                $newbol->save();
            }
        }
        if (isset($_POST['submit']) and $_POST['submit'] == "NewContainer") {
            if (isset($_POST['CONTAINERIDNEW'])) {
                foreach ($_POST['CONTAINERIDNEW'] as $bolid => $cid) {
                    if ($bolid != 0 and strlen($cid) > 0) {
                        $newct = new PPLieferavis_Container();
                        $newct->PPLieferavis_Container_PPlieferavis_Id = $la->PPLieferavis_Id;
                        $newct->PPLieferavis_Container_PPLieferavis_BOL_Id = $bolid;
                        $newct->PPLieferavis_Container_ContainerId = $cid;
                        $newct->save();
                    }
                }
            }
        }
        if (isset($_POST['submit']) and $_POST['submit'] == "NewContainerPos") {
            //var_dump($_POST['POSNEW']); exit;
            if (isset($_POST['POSNEW'])) {
                foreach ($_POST['POSNEW'] as $laid => $acid) {
                    if ($laid != 0) {
                        foreach ($acid as $cid => $posnr) {
                            //echo(" $laid  $cid $posnr <br>");
                            if (strlen($posnr) > 0) {
                                $maxpos = PPLieferavis_Container_Content::where("PPLieferavis_Container_Content_PPLieferavis_Container_Id", "=", $cid)->max('PPLieferavis_Container_Content_VEPos');
                                //$max->PPLieferavis_Container_Content_VEPos;
                                //Position aus material suchen
                                $mat13 = "";
                                $mat_count = PPLieferavis_Material::where("PPLieferavis_Material_AvisPosNr", "=", $posnr)->count();
                                if ($mat_count > 0) {
                                    $mat = PPLieferavis_Material::where("PPLieferavis_Material_PPLieferavis_id", "=", $laid)->where("PPLieferavis_Material_AvisPosNr", "=", $posnr)->first();
                                    $mat13 = $mat->PPLieferavis_Material_Materialnr;
                                }
                                //echo($maxpos); exit;
                                $newcti = new PPLieferavis_Container_Content();
                                $newcti->PPLieferavis_Container_Content_VEPos = $maxpos + 1;
                                $newcti->PPLieferavis_Container_Content_PPLieferavis_Container_Id = $cid;
                                $newcti->PPLieferavis_Container_Content_POSNr = $posnr;
                                $newcti->PPLieferavis_Container_Content_Materialnr = $mat13;
                                $newcti->save();
                            }
                        }
                    }
                }
            }
        }
        return Redirect::to('/show/' . $ppid . '/' . $la->PPLieferavis_Id . "#tabs-20")->with('messages', ' Avis Updated!');
    }
    private function getXMLLieferAvis($headerdata, $positions, $billdata, $packingdata, $marms, $IAN = "")
    {
        $xml = new SimpleXMLElement('<ZLEX_AVI/>');
        // Header area, all general information here
        // for a detailed description of the fields see Excel document
        foreach ($headerdata as $node => $value) {
            $xml->addChild($node, $value);
        }
        // for each article a position with article information,
        // quantities and a reference to a order position needs to
        // be supplied in an ITEM structure
        foreach ($positions as $position) {
            $pos = $xml->addChild('ZLEX_AVIS_DELIVERY_ITEM');
            foreach ($position as $node => $value) {
                $pos->addChild($node, $value);
            }
        }
        foreach ($billdata as $arrbill) {
            $bill = $xml->addChild("ZLEX_AVIS_BILL");
            foreach ($arrbill as $node => $value) {
                $bill->addChild($node, $value);
            }
        }
        //Packing
        //echo("<pre>");var_dump($packingdata);echo("</pre>");exit;
        foreach ($packingdata as $container) {
            $packing = $xml->addChild("ZLEX_AVIS_VEKP");
            foreach ($container as $node => $value) {
                //echo("<pre>______  $node : ");var_dump($value);echo("</pre><br><br>");
                if (!is_array($value)) {
                    $packing->addChild($node, $value);
                } else {
                    foreach ($value as $arr) {
                        $vepos = $packing->addChild($node);
                        //echo( "HHHH<br><pre>");var_dump($arr);echo("</pre>");
                        foreach ($arr as $node2 => $value2) {
                            //echo("     iiii<br><pre>");var_dump($value2);echo("</pre>");
                            $vepos->addChild($node2, $value2);
                        }
                    }
                }
            }
        }
        foreach ($marms as $marm) {
            $mmarm = $xml->addChild('ZLEX_AVIS_MARM');
            foreach ($marm as $node => $value) {
                $mmarm->addChild($node, $value);
            }
        }
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="Lieferavis_' . $headerdata['LIFEX'] . '_zu_' . $IAN . '.xml"');
        print($xml->asXML());
        exit();
    }
    public function Avis2XML($laid)
    {
        //$laid = 31;
        $avis_header = PPLieferavis::findOrFail($laid);
        $avis_produktpass = PPProduktpass::find($avis_header->PPLieferavis_PPProduktpass_Id);
        $avis_materialien = PPLieferavis_Material::where('PPLieferavis_Material_PPLieferavis_Id', "=", $laid)->get();
        $aMaterials = array();
        foreach ($avis_materialien as $material) {
            $aMaterials[] = $material->toArray();
        }
        $aBols = array();
        $avis_bols = PPLieferavis_BOL::where('PPLieferavis_BOL_PPLieferavis_Id', "=", $laid)->get();
        foreach ($avis_bols as $bol) {
            $aBols[] = $bol->toArray();
        }
        $aContainers = array();
        $avis_containers = PPLieferavis_Container::where('PPLieferavis_Container_PPLieferavis_Id', "=", $laid)->get();
        foreach ($avis_containers as $container) {
            $aContainers[] = $container->toArray();
        }
        for ($i = 0; $i < count($aContainers); $i++) {
            $contents = PPLieferavis_Container_Content::where('PPLieferavis_Container_Content_PPLieferavis_Container_Id', "=", $aContainers[$i]['PPLieferavis_Container_Id'])->get();
            $aContainers[$i]['CONTENT'] = array();
            foreach ($contents as $content) {
                $aContainers[$i]['CONTENT'][] = $content->toArray();
            }
        }
        $aMarms = array();
        $avis_marms = PPLieferavis_MARM::where('PPLieferavis_MARM_PPLieferavis_Id', "=", $laid)->get();
        foreach ($avis_marms as $marm) {
            $aMarms[] = $marm->toArray();
        }
        $headerdata = array(
            "LFART" => "YEL", //Immer YEL
            "TDDAT" => $avis_header->PPLieferavis_ETD, //ETD
            "LFDAT" => $avis_header->PPLieferavis_ETA, //ETA
            "ROUTE" => "", "Z_DEP_KNOTE" => $avis_header->PPLieferavis_POL, //POL
            "Z_END_KNOTE" => $avis_header->PPLieferavis_POD, //POD
            "LIFNR" => $avis_header->PPLieferavis_SupplierId, //Belotex LieferantenNummer
            "Z_FRACHT_LIFNR" => $avis_header->PPLieferavis_FrachtfuehrerId, //Frachtführer Nummer
            "Z_SPEDI_LIFNR" => $avis_header->PPLieferavis_SpediteurId, //Speidietzr Nummer
            "TRATY" => $avis_header->PPLieferavis_SeaAir, //SEA Y030 AIR Y060
            "TRAID" => $avis_header->PPLieferavis_IMO, //ShipIMO Nummer ID Frachtschiff
            "LIFEX" => $avis_header->PPLieferavis_AvisNr, //Lieferavis Nummer
            "Z_FREIE_STANDZ" => "", //FOB => Leer
            "Z_DETENTION" => "", //FOB Leer
            "INCO1" => $avis_header->PPLieferavis_Incoterm, //INCOTERM
            "INCO2" => $avis_header->PPLieferavis_Incoterm2, //ORT aus INCOTERM
            "VERLD" => $avis_header->PPLieferavis_Abgangsland, //Start des Transports Land
            "VERB-TXT" => $avis_header->PPLieferavis_Remark
            //Bemerkung (varchar500)
        );
        $materialdata = array();
        $i = 0;
        foreach ($aMaterials as $aMaterial) {
            $materialdata[$i] = array(
                "Z_POSNR" => $aMaterial['PPLieferavis_Material_AvisPosNr'], //Posnummer
                "MATNR" => $aMaterial['PPLieferavis_Material_Materialnr'], //Order Articlenumber
                "LFIMG" => $aMaterial['PPLieferavis_Material_Menge'], //Menge (Kartons)
                "VRKME" => "CT", //Immer CT
                "VGTYP" => "V", //Immer V
                "VGBEL" => $aMaterial['PPLieferavis_Material_OrderNr'], //Order ID
                "VGPOS" => $aMaterial['PPLieferavis_Material_OrderPosNr'], //Order PosNR
                "EAN11" => $aMaterial['PPLieferavis_Material_OrderGTIN'], //GTIN aus order
                "UECHA" => ""
                //Non-Food empty
            );
            $i++;
        }
        $billdata = array();
        $i = 0;
        foreach ($aBols as $aBol) {
            $billdata[$i] = array(
                "GUID_HU" => $aBol['PPLieferavis_BOL_BOLNr'], //BOL
                "BRGEW" => $aBol['PPLieferavis_BOL_Brutto'], //Brutto-Gewicht
                "GEWEI_MAX" => "KG"
                //Einheit immer  KG
            );
            $i++;
        }
        $containerdata = array();
        $i = 0;
        foreach ($aContainers as $aContainer) {
            $containerdata[$i]['GUID_HU'] = $aContainer['PPLieferavis_Container_ContainerId']; //Container ID
            $containerdata[$i]['VHILM'] = $aContainer['PPLieferavis_Container_Art']; //Werte 10010 = 20" Container  10011 = 40" Container  10012 = 40" HC Container
            $containerdata[$i]['VHART'] = $aContainer['PPLieferavis_Container_PalCon']; //Y010 - pallet   Y020 - container
            $containerdata[$i]['BILL'] = $aContainer['PPLieferavis_Container_BOLNr'];
            $containerdata[$i]['ZLEX_AVIS_VEPO'] = array();
            $j = 0;
            foreach ($aContainer['CONTENT'] as $cont) {
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['VEPOS'] = $cont['PPLieferavis_Container_Content_VEPos'];
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['Z_POSNR'] = $cont['PPLieferavis_Container_Content_POSNr'];
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['Z_STUELI_ZAEHLER'] = "";
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['VEMNG'] = $cont['PPLieferavis_Container_Content_Menge'];
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['ALTME'] = "CT";
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['MATNR'] = $cont['PPLieferavis_Container_Content_MaterialNr'];
                $containerdata[$i]['ZLEX_AVIS_VEPO'][$j]['P_POSNR'] = $cont['PPLieferavis_Container_Content_PPOSNr'];
                $j++;
            }
            $i++;
        }
        //echo("<pre>");var_dump($containerdata);echo("</pre>");exit;
        $marmdata = array();
        $i = 0;
        foreach ($aMarms as $aMarm) {
            $marmdata[$i] = array(
                "SATNR" => $aMarm['PPLieferavis_MARM_SATNR'], // Links(MATNR-4)
                "LAENG" => $aMarm['PPLieferavis_MARM_Laenge'], // Kartonmasse L B H Brutto/Netto
                "BREIT" => $aMarm['PPLieferavis_MARM_Breite'], "HOEHE" => $aMarm['PPLieferavis_MARM_Hoehe'], "BRGEW" => $aMarm['PPLieferavis_MARM_Brutto'], "NTGEW" => $aMarm['PPLieferavis_MARM_Netto']
            );
            $i++;
        }
        /*
          echo("<pre>");
          var_dump($headerdata);
          echo("Material<br>");
          var_dump($materialdata);
          echo("BILL<br>");
          var_dump($billdata);
          echo("Container<br>");
          var_dump($containerdata);
          echo("Marm<br>");
          var_dump($marmdata);
          exit;
        */
        $this->getXMLLieferAvis($headerdata, $materialdata, $billdata, $containerdata, $marmdata, $avis_produktpass->PPProduktpass_IAN);
    }
    public function getWarehouseLaenderaufteilung($ppid)
    {
        $ret = array();
        $whc = PPLaenderaufteilung::where('PPLaenderaufteilung_PPProduktpass_Id', '=', $ppid)->count();
        if ($whc) {
            $wha = PPLaenderaufteilung::where('PPLaenderaufteilung_PPProduktpass_Id', '=', $ppid)->get();
            $ret = $wha; //[PPLaenderaufteilung_Land][$wh->PPLaenderaufteilung_Warehouse] = $wh->PPLaenderaufteilung_Menge_Kollies;
        } else {
            //„Weinfelden2 und „Sevaz“
            $this->setWarehouseLaenderaufteilung(0, $ppid, 'CH', 'Sevaz', 0);
            $this->setWarehouseLaenderaufteilung(0, $ppid, 'CH', 'Weinfelden2', 0);
            $ret = $this->getWarehouseLaenderaufteilung($ppid);
        }
        return $ret;
    }
    public function setWarehouseLaenderaufteilung($id, $ppid, $land, $wh, $qty)
    {
        if ($id == 0) {
            $whrow = new PPLaenderaufteilung();
        } else {
            $whrow = PPLaenderaufteilung::where('PPLaenderaufteilung_Id', '=', $id)->first();
        }
        $whrow->PPLaenderaufteilung_Land = $land;
        $whrow->PPLaenderaufteilung_PPProduktpass_Id = $ppid;
        $whrow->PPLaenderaufteilung_Warehouse = $wh;
        $whrow->PPLaenderaufteilung_Menge_Kollies = $qty;
        $whrow->save();
        return $whrow->PPLaenderaufteilung_Id;
    }
    function IsBWOrder($id)
    {
        $purchase = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $id)->get()->first();
        if ($purchase) {
            if (is_null($purchase->PPPurchase_BWGroesse) or $purchase->PPPurchase_BWGroesse == 'Andere als BW') {
                return false;
            }
            return true;
        }
        return false;
    }
    function get8W($ppid)
    {
        $ret = array();
        $musters = PP8WMuster::where("PP8WMuster_PPProduktpass_Id", "=", $ppid)->get();
        // cpcDebug::dd("1. Runde" . $musters->count());
        if ($musters->count() > 0) {
            foreach ($musters as $muster) {
                $ret[] = $muster;
            }
            return $ret;
        }
        $muster = new PP8WMuster();
        $muster->PP8WMuster_PPProduktpass_Id = $ppid;
        $muster->PP8WMuster_Art = 1;
        $muster->PP8WMuster_Remark = "Neuer Eintrag TEST ART:1";
        $muster->save();
        $muster = new PP8WMuster();
        $muster->PP8WMuster_PPProduktpass_Id = $ppid;
        $muster->PP8WMuster_Art = 2;
        $muster->PP8WMuster_Remark = "Neuer Eintrag TEST ART:2";
        $muster->save();
        $ret = array();
        $musters = PP8WMuster::where("PP8WMuster_PPProduktpass_Id", "=", $ppid)->get();
        //cpcDebug::dd("2 Runde:" . $musters->count());
        if ($musters->count() > 0) {
            foreach ($musters as $muster) {
                $ret[] = $muster;
            }
            return $ret;
        }
        return false;
    }
    public function newProdCalc()
    {
        $ppid = Input::get('ppid');
        $prodid = Input::get('calcProd');
        $calc = new PPCalculation();
        $calc->PPCalculation_PPProduktpass_Id = $ppid;
        $calc->PPCalculation_SupplierId = $prodid;
        $calc->PPCalculation_SupplierLoadHQ = 0;
        $calc->PPCalculation_Currency = '';
        $calc->PPCalculation_ExcR_Calc = 0;
        $calc->PPCalculation_DutyPercentage = 0;
        $calc->PPCalculation_EK = 0;
        $calc->PPCalculation_Fracht = 0;
        $calc->PPCalculation_Zoll = 0;
        $calc->PPCalculation_EKProvision = 0;
        $calc->PPCalculation_Ausgangsfrachten = 0;
        $calc->PPCalculation_Finanzierungskosten = 0;
        $calc->PPCalculation_Pruefkosten = 0;
        $calc->PPCalculation_Lizenzgebuehren = 0;
        $calc->PPCalculation_Kosten = 0;
        $calc->PPCalculation_KostenProz = 0;
        $calc->PPCalculation_VK = 0;
        $calc->PPCalculation_Remark = '';
        $calc->save();
        return $this->showAfterUpload($ppid, 7);
    }
    public function updateProdCalc($id, $calc, $allval, $total, $ausst)
    {
        /*echo("Update: $id <br>");
        echo("<pre>");
        var_dump($calc);
        echo("</pre>");
        echo("<pre>");
        var_dump($allval);
        echo("</pre>");*/
        $_calc = PPCalculation::where('PPCalculation_Id', $id)->get()->first();
        if ($_calc) {
            $calcSupplier = PPAdressen::where('Id', "=", $_calc->PPCalculation_SupplierId)->get()->first();
            //echo($calc['PPCalculation_ExcR_Calc']."<br>");
            //$calc->PPCalculation_PPProduktpass_Id = $ppid ;
            //$calc->PPCalculation_SupplierId = '';
            $_calc->PPCalculation_SupplierLoadHQ = $this->Dec2MySql($calc['PPCalculation_SupplierLoadHQ']);
            $wsym = "XXXX";
            if (strlen($calc['PPCalculation_Currency']) < 2) {
                $calcSupplier = PPAdressen::where('Id', "=", $_calc->PPCalculation_SupplierId)->get()->first();
                if ($calcSupplier) {
                    $wsym = $calcSupplier->PPCalculation_Currency;
                }
            } else {
                $wsym = $calc['PPCalculation_Currency'];
            }
            $_calc->PPCalculation_Currency = $wsym;
            $kursFrm = $this->Dec2MySql($calc['PPCalculation_ExcR_Calc']);
            if ($kursFrm == 0) {
                $kursFrm = $ausst->AusmusterungStamm_kurs;
            }
            $_calc->PPCalculation_ExcR_Calc = $kursFrm;
            if ($wsym == "EUR") {
                $_calc->PPCalculation_ExcR_Calc = 1;
            }
            $_calc->PPCalculation_EK = $this->Dec2MySql($calc['PPCalculation_EK']);
            $_calc->PPCalculation_EKProvision = $this->Dec2MySql($calc['PPCalculation_EKProvision']);
            //$_calc->PPCalculation_Fracht  = 0;
            $_calc->PPCalculation_Zoll = $this->checkAllVal($allval, $calc, 'PPCalculation_Zoll');
            //Fracht neu kalkulieren
            $abgangshafen = $calcSupplier->PPAdressen_Abgangshafen;
            $_calc->PPCalculation_Ausgangsfrachten = $this->calcFracht($_calc->PPCalculation_PPProduktpass_Id, $this->Dec2MySql($calc['PPCalculation_SupplierLoadHQ']), $abgangshafen);
            if (isset($allval['PPCalculation_Pruefkosten']) and strlen($allval['PPCalculation_Pruefkosten'] > 0)) {
                $_calc->PPCalculation_Pruefkosten = $this->checkAllVal($allval, $calc, 'PPCalculation_Pruefkosten') / $total;
            }
            $_calc->PPCalculation_Finanzierungskosten = $this->Dec2MySql($calc['PPCalculation_Finanzierungskosten']);
            $_calc->PPCalculation_Lizenzgebuehren = $this->checkAllVal($allval, $calc, 'PPCalculation_Lizenzgebuehren');
            $_calc->PPCalculation_KostenProz = $this->Dec2MySql($calc['PPCalculation_KostenProz']);
            $_calc->PPCalculation_Kosten = $this->checkAllVal($allval, $calc, 'PPCalculation_Kosten');
            $_calc->PPCalculation_Fracht = $this->calcEingangsFracht($_calc->PPCalculation_PPProduktpass_Id, $this->Dec2MySql($calc['PPCalculation_SupplierLoadHQ']));
            if (strlen($allval['PPCalculation_VK'] > 0)) {
                $_calc->PPCalculation_VK = $this->Dec2MySql($allval['PPCalculation_VK']);
            }
            $_calc->PPCalculation_Remark = $calc['PPCalculation_Remark'];
            $_calc->save();
        }
    }
    public function checkAllVal($allval, $calc, $att)
    {
        if (isset($calc[$att])) {
            if (isset($allval[$att]) and strlen($allval[$att]) > 0) {
                return $this->Dec2MySql($allval[$att]);
            }
            return $this->Dec2MySql($calc[$att]);
        }
        return 0;
    }
    private function container($ppid, $load)
    {
        $mngs = $this->_berechneHafenMengen($ppid);
        $containers = array();
        foreach ($mngs as $hafen => $mng) {
            $containers[$hafen] = $this->_calcContainer($mng, $load);
        }
        return $containers;
    }
    public function calcEingangsFracht($ppid, $load)
    {
        $ausm = $this->getAusmusterung($ppid);
        //echo("$ausm <br>");
        $ausmstamm = AusmusterungStamm::where('AusmusterungStamm_ausmusterung', '=', $ausm)->get()->first();
        if ($ausmstamm) {
            $containers = $this->container($ppid, $load);
            $total = 0;
            foreach ($containers as $hafen => $container) {
                foreach ($container['Anzahl'] as $art => $menge) {
                    $total += $menge;
                }
            }
            $kosten = $total * ($ausmstamm->AusmusterungStamm_kosten_nachlauf + $ausmstamm->AusmusterungStamm_kosten_entladung);
            return $kosten;
        }
        return 0;
    }
    public function getAusmusterung($ppid)
    {
        $pp = DB::table('tPPProduktpass')->where("PPProduktpass_Id", $ppid)->first();
        if (!$pp) {
            return 0;
        }
        return substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
    }
    public function calcFracht($ppid, $load, $abgangshafen)
    {
        $containers = $this->container($ppid, $load);
        $ausm = $this->getAusmusterung($ppid);
        $preisgr = DB::table('v_PreisgruppenHafen')->where('PPAbgangshafen_Id', $abgangshafen)->first();
        if (!$preisgr) {
            return 0;
        }
        $pg = $preisgr->PPHaefen_PreisGruppe;
        if (is_null($pg)) {
            return 0;
        }
        $kostenContainers = KostenContainer::where('KostenContainer_Ausmusterung', "=", $ausm)->where('KostenContainer_Gruppe', $pg)->get();
        if (!$kostenContainers) {
            return 0;
        }
        $kosten = array();
        foreach ($kostenContainers as $kostCont) {
            $kosten[$kostCont->KostenContainer_Art] = $kostCont->KostenContainer_Preis;
        }
        $totalfracht = 0;
        foreach ($containers as $hafen => $container) {
            //echo("<br>Hafen: $hafen <br>");
            $fracht[$hafen] = $container['Anzahl']['HQ'] * $kosten['HQ'];
            //echo("Anzahl HQ: ".$container['Anzahl']['HQ']. " Kosten: " . $kosten['HQ']." Fracht:".$fracht[$hafen] );
            $fracht[$hafen] += $container['Anzahl']['40'] * $kosten['40'];
            //echo("<br>Anzahl 40: ".$container['Anzahl']['40']. " Kosten: " . $kosten['40']." Fracht:".$fracht[$hafen] );
            $fracht[$hafen] += $container['Anzahl']['20'] * $kosten['20'];
            //echo("<br>Anzahl 20: ".$container['Anzahl']['20']. " Kosten: " . $kosten['20']." Fracht:".$fracht[$hafen] );
            $totalfracht += $container['Anzahl']['HQ'] * $kosten['HQ'];
            $totalfracht += $container['Anzahl']['40'] * $kosten['40'];
            $totalfracht += $container['Anzahl']['20'] * $kosten['20'];
            //echo("<br>Total $hafen:  $fracht[$hafen]  <br>----------------------------------<br>");
        }
        return $totalfracht;
        /*foreach($containers as $hafen => $container){
        echo($hafen."<br><pre>");
        print_r($container);
        echo("</pre><br>");
        }*/
    }
    public function calcContainer($menge, $load)
    {
        echo ('<pre>');
        var_dump($this->_calcContainer($menge, $load));
        echo ('</pre>');
    }
    private function _calcContainer($totalmenge, $load)
    {
        // $menge => Gesamtmenge
        // $load => Menge in 1 40' HQ Container
        // 40'HQ Container = 100%
        // 40'   Container = 88% von  40'HQ
        // 20'   Container = 43% von  40'HQ
        $loadHQ = $load;
        $load40 = $load * 0.88;
        $load20 = $load * 0.43;
        $container['HQ'] = 0;
        $container['40'] = 0;
        $container['20'] = 0;
        $menge['HQ'] = 0;
        $menge['40'] = 0;
        $menge['20'] = 0;
        if ($load == 0) {
            return (array('Anzahl' => $container, 'Menge' => $menge));
        }
        $container['HQ'] = floor($totalmenge / $loadHQ);
        $menge['HQ'] = $container['HQ'] * $loadHQ;
        $rest = $totalmenge % $loadHQ;
        //echo("1. Rest $rest <br>");
        if ($rest > $load40) {
            $container['HQ']++;
            $menge['HQ'] = $container['HQ'] * $loadHQ;
            return (array('Anzahl' => $container, 'Menge' => $menge));
        } else {
            $container['40'] = floor($rest / $load40);
            $menge['40'] = $container['40'] * $load40;
            $rest40 = $rest % $load40;
            //echo("2. Rest $rest40 <br>");
            if ($rest40 > $load20) {
                $container['40']++;
                return (array('Anzahl' => $container, 'Menge' => $menge));
            } else {
                $container['20'] = ceil($rest40 / $load20);
                $menge['20'] = $rest40;
                return (array('Anzahl' => $container, 'Menge' => $menge));
            }
        }
    }
    public function berechneHafenMengen($ppid)
    {
        $mngs = $this->_berechneHafenMengen($ppid);
        foreach ($mngs as $hafen => $mng) {
            echo ("$hafen: => $mng Stk.<br>");
        }
    }
    public function _berechneHafenMengen($ppid)
    {
        //$mengen = v_LTMengenJeHafen::where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)->get();
        $mengen = DB::table('v_LTMengenJeHafen')->where('PPProduktpass_Menge_PPProduktpass_Id', $ppid)->get();
        if ($mengen) {
            foreach ($mengen as $menge) {
                if (is_null($menge->PPLaenderbloecke_Hafen2)) {
                    if (!isset($mng[$menge->PPLaenderbloecke_Hafen1])) {
                        $mng[$menge->PPLaenderbloecke_Hafen1] = 0;
                    }
                    $mng[$menge->PPLaenderbloecke_Hafen1] += $menge->MengeLT1;
                    //echo($menge->PPLaenderbloecke_Hafen1.": ". $menge->MengeLT1."<br>");
                } else {
                    if ($menge->PPLaenderbloecke_Hafen1 == 'Rotterdam') {
                        //echo("Rotterdam Start:" . $menge->MengeLT1.": ". $menge->PPAB_Aufteilung_Rotterdam_FR."<br>");
                        if (!isset($mng[$menge->PPLaenderbloecke_Hafen1])) {
                            $mng[$menge->PPLaenderbloecke_Hafen1] = 0;
                        }
                        $add1 = ceil($menge->MengeLT1 * $menge->PPAB_Aufteilung_Rotterdam_FR / 100);
                        $add2 = $menge->MengeLT1 - $add1;
                        $mng[$menge->PPLaenderbloecke_Hafen1] += $add1;
                        if (!isset($mng[$menge->PPLaenderbloecke_Hafen2])) {
                            $mng[$menge->PPLaenderbloecke_Hafen2] = 0;
                        }
                        $mng[$menge->PPLaenderbloecke_Hafen2] += $add2;
                        //echo("Rotterdam:" . $menge->PPLaenderbloecke_Hafen1.": ". $add1."<br>");
                        //echo("Rotterdam:" . $menge->PPLaenderbloecke_Hafen2.": ". $add2."<br>");
                    }
                    if ($menge->PPLaenderbloecke_Hafen1 == 'Barcelona') {
                        //echo("Barcelona Start:" . $menge->MengeLT1.": ". $menge->PPAB_Aufteilung_Barcelona_IT."<br>");
                        if (!isset($mng[$menge->PPLaenderbloecke_Hafen1])) {
                            $mng[$menge->PPLaenderbloecke_Hafen1] = 0;
                        }
                        $add1 = ceil($menge->MengeLT1 * $menge->PPAB_Aufteilung_Barcelona_IT / 100);
                        $add2 = $menge->MengeLT1 - $add1;
                        $mng[$menge->PPLaenderbloecke_Hafen1] += $add1;
                        if (!isset($mng[$menge->PPLaenderbloecke_Hafen2])) {
                            $mng[$menge->PPLaenderbloecke_Hafen2] = 0;
                        }
                        $mng[$menge->PPLaenderbloecke_Hafen2] += $add2;
                        //echo("Barcelona:" . $menge->PPLaenderbloecke_Hafen1.": ". $add1."<br>");
                        //echo("Barcelona:" . $menge->PPLaenderbloecke_Hafen2.": ". $add2."<br>");
                    }
                }
            }
        }
        return ($mng);
    }
    public function updateCalc()
    {
        //echo("<pre>");
        //print_r(Input::get('calc'));
        $calcs = Input::get('calc');
        $ppid = Input::get('ppid');
        $allval = Input::get('allval');
        $total = Input::get('totalQty');
        $ausm = $this->getAusmusterung($ppid);
        $ausst = AusmusterungStamm::where('AusmusterungStamm_ausmusterung', '=', $ausm)->get()->first();
        foreach ($calcs as $id => $calc) {
            //echo("$id  $ppid ".$calc['PPCalculation_ExcR_Calc']."<br>");
            //var_dump($calc);
            $this->updateProdCalc($id, $calc, $allval, $total, $ausst);
        }
        return $this->showAfterUpload($ppid, 7);
    }
    public function deleteCalc()
    {
        $calcId = Input::get('delCalcId');
        $ppid = Input::get('delppid');
        $calc = PPCalculation::find($calcId);
        if ($calc) {
            $calc->delete();
        }
        return $this->showAfterUpload($ppid, 7);
    }
    public function selectCalcSupplier()
    {
        $calcId = Input::get('id');
        $ppid = Input::get('ppid');
        $calcPPID = PPCalculation::find($calcId);
        if (!$calcPPID) {
            return "NO CALC $calcId";
        }
        $ppid = $calcPPID->PPCalculation_PPProduktpass_Id;
        $calcs = PPCalculation::where('PPCalculation_PPProduktpass_Id', '=', $ppid)->get();
        foreach ($calcs as $calc) {
            $calc->PPCalculation_selected = 0;
            $calc->save();
        }
        $calc = PPCalculation::find($calcId);
        if ($calc) {
            $calc->PPCalculation_selected = 1;
            $calc->save();
        }
        return "OK";
    }
    public function handleFiles()
    {
        $inp = Input::get('fileIds');
        $mailto = Input::get('mailto');
        $zip = Input::get('zip');
        $download = Input::get('download');
        $files = PPPPFiles::whereIn('PPPPFiles_Id', $inp)->get();
        $result = '';
        $filesForDownload = array();
        $filesForMail = array();
        $zipFiles = array();
        if ($files) {
            foreach ($files as $file) {
                $zipFiles[] = array('path' => public_path() . '/data/' . $file->PPPPFiles_Pfad . '/', 'file' => $file->PPPPFiles_Name, 'zipname' => substr($file->PPPPFiles_Name, 7));
                if (!$zip) {
                    $filesForDownload[] = '/data/' . $file->PPPPFiles_Pfad . '/' . $file->PPPPFiles_Name;
                    $filesForMail[] = public_path() . '/data/' . $file->PPPPFiles_Pfad . '/' . $file->PPPPFiles_Name;
                }
                $result .= public_path() . '/data/' . $file->PPPPFiles_Pfad . '/' . $file->PPPPFiles_Name . "   ";
            }
        }
        $zipPath = '/data/tmp/zipped/';
        if ($zip) {
            $filesForDownload[] = $zipPath . $this->zipFiles($zipFiles, 'TPT_FileDownload_' . date('ymdhis') . '.zip', public_path() . $zipPath);
            $filesForMail[0] = public_path() . $filesForDownload[0];
        }
        if (strlen($mailto) > 5) {
            $mail = new MailController();
            $mail->sendMail($mailto, '', "TPT Dateien Auswahl", 'Anbei ein ZIP-Archive mit den Dateien aus dem TPT Dateibereich, die sie ausgewählt haben.', $filesForMail);
        }
        $ret = array('download' => $download, 'filesForDownload' => $filesForDownload);
        $retJson = json_encode($ret);
        return $ret;
    }
    private function zipFiles($file_names, $archive_file_name, $file_path)
    {
        cpcDebug::cpc_debug('Zip Start: ' . $file_path, "TESThandleFiles");
        $archiveFile = $file_path . $archive_file_name;
        $zip = new ZipArchive();
        // WE REUSED THE $file_path VARIABLE HERE THEN ADDED zipped FOLDER
        if (!$zip->open($archiveFile, ZIPARCHIVE::CREATE)) {
            cpcDebug::cpc_debug('Zip abbruch', "TESThandleFiles");
            exit('cannot open <' . $archive_file_name . '>');
        }
        ///kunden/387316_50679/webseiten/targa/tis-test/public/tmp/zipped
        //add each files of $file_name array to archive
        foreach ($file_names as $key => $zipfile) {
            cpcDebug::cpc_debug('Zip Add => ' . $zipfile['path'] . '#' . $zipfile['file'] . '#' . $zipfile['zipname'], "TESThandleFiles");
            if (file_exists($zipfile['path'] . $zipfile['file'])) {
                $zip->addFile($zipfile['path'] . $zipfile['file'], $zipfile['file']);
            } else {
                cpcDebug::cpc_debug('Zip Error in File: ' . $zipfile['path'] . $zipfile['file'], "TESThandleFiles");
            }
        }
        if ($zip->close() !== true) {
            cpcDebug::cpc_debug('Zip not save!', "TESThandleFiles");
            exit;
        }
        cpcDebug::cpc_debug('Zip OK', "TESThandleFiles");
        return $archive_file_name;
        //then send the headers to force download the zip file
        /*header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header('Content-length: '.filesize($archiveFile));
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$archiveFile");
        exit;*/
    }
    public function updateThema()
    {
        //echo('<h1>update Thema</h1><br>');
        //cpcDebug::cpc_debug($_FILES,'updateThema');
        //cpcDebug::cpc_debug($_POST,'updateThema');
        $files = Input::file('file');
        cpcDebug::cpc_debug($files, 'updateThema');
        $i = Input::all();
        cpcDebug::cpc_debug($i, 'updateThema');
        if ($files) {
            foreach ($files as $id => $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/data/uploads/Thema/', $name);
                cpcDebug::cpc_debug("Single File ($id)", 'updateThema');
                cpcDebug::cpc_debug($file, 'updateThema');
            }
        } else {
        }
        $ppid = Input::get('ppid');
        return Redirect::to('/show/' . $ppid . "/#tabs-98");
    }
    public function translateDeepl($text = null)
    {
        if ($text == null or (trim($text) == '')) {
            $text = '-';
        }
        $api_Key = '10ee3599-028f-961f-ca7e-8c941bfaac5a';
        $deeplURL = "https://api.deepl.com/v2/translate";
        $lang = 'EN-US';
        $protected = $this->deeplProtectLinebreaks($text);
        $protected = $this->deeplTextToHtml($protected);
        $vars = http_build_query([
            'text'                => $protected,
            'target_lang'         => $lang,
            'preserve_formatting' => 1,              // oder 'true'
            'tag_handling'        => 'html',
            // optional, oft sinnvoll gegen "Umbruch-Verschlucken"
            'split_sentences'     => 'nonewlines',    // DeepL API: keine Satztrennung an Zeilenumbrüchen
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
        $data = json_decode($translation, true);
        $translated = $data['translations'][0]['text'] ?? 'Not Translated [Qutoa?]';
        $translated = $this->deeplRestoreLinebreaks($translated);
        return $translated;
    }
    private function _saveTranslation($id, $EN, $DE)
    {
        //cpcDebug::pe("ID $id $EN <br> ");
        $trans = Translations::where('Translations_Id', $id)->get()->first();
        if ($trans) {
            //cpcDebug::pe("ID $id gefunden! <br> ");
            $trans->Translations_DE = $this->replace0d(trim($DE));
            $trans->Translations_EN = trim($EN);
            $trans->save();
        }
    }
    public function saveTranslation()
    {
       /* echo("<pre>");
        print_r($_POST);
        echo("</pre>");
        exit; */
        $all = Input::all();
        $submit = Input::get('submitType');
        $ppid = Input::get('ppid');
        $DE = Input::get('DE');
        $EN = Input::get('EN');
        //cpcDebug::pe($EN,1);
        if ($submit == 'reset') {
            $this->getTranslation($ppid, true);
        } else {
            foreach ($EN as $id => $value) {
                cpcDebug::cpc_debug("ID $id => $value", '@saveTranslation');
                $this->_saveTranslation($id, $value, $DE[$id]);
            }
        }
        //cpcDebug::pe('ENDE',1);
        return Redirect::to('/show/' . $ppid . "/RFQ");
    }
    private function updateManSollCRD($ppid, $crds)
    {
        return;
        //$this->prncpc($crds, 1);
        $new = $crds['New'];
        $old = $crds['Old'];
        $oldDate = new DateTime();
        $oldDate->setIsoDate($old['Jahr'], $old['Woche'], 5);
        $newDate = new DateTime();
        $newDate->setIsoDate($new['Jahr'], $new['Woche'], 5);
        //$this->prncpc($oldDate);
        //$this->prncpc($oldDate->format('W/Y'));
        //$this->prncpc($newDate);
        //$this->prncpc($newDate->format('W/Y'));
        $diff = $newDate->diff($oldDate);
        $diffWeeks = floor($diff->format('%a') / 7);
        $sign = 1;
        if ($newDate > $oldDate) {
            $sign = -1;
        }
        $diffWeeks *= $sign;
        //$this->prncpc($diffWeeks, 1);
        $termines = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->get();
        foreach ($termines as $t) {
            if ($t->PPTermine_ManSoll != 0) {
                $t->PPTermine_ManSoll =  $t->PPTermine_ManSoll - $diffWeeks;
                $t->save();
            }
        }
    }
    public function directAccess (){
        $ian = Input::get('ian');
        $ausm = Input::get('ausmusterung');
        //echo("IAN: $ian  Ausmusterung: $ausm");exit;
        return $this->show($ian.'_'.$ausm);
    }
    public function showOrderAll() {
        $role = Auth::user()->PPMitarbeiter_Role;
         if (! isset($_COOKIE['TPTLanguage'])){
            $_COOKIE['TPTLanguage'] =  Auth::user()->PPMitarbeiter_Language; //'DE';
        } 
        $lang = $_COOKIE['TPTLanguage'];   
        $restrictedStatus = array('PLAN','MUSTERUNG','FIX','ABSAGE','GELIEFERT');
        if (strpos($role,'INTERN') === false ){
            //$restrictedStatus = array('FIX');
        }
        $inp = Input::all();
        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $search_ausmusterung = '';
        $search = '';
        if (isset($inp['IsPost'])) {
            $search = trim($inp['search']);
            $searchArt = $search;
            if ($lang == 'EN'){
                $searchArt = ServiceProvider::tlFromTo('EN','DE', $search);
            }
            cpcDebug::cpc_debug("Suchbegriff Art (EN->DE): $lang $search => $searchArt", '-showOrderAll1');
            $search_ausmusterung = $inp['search_ausmusterung'];
            $subData['liqs'] = DB::table('v_AuftragsUebersicht')->where('PPProduktpass_Ausmusterungnummer', 'like', $search_ausmusterung . '%')
                    ->where('PPProduktpass_IAN', 'not like', "%rev%")
                    ->whereIn('InternerStatus', $restrictedStatus)
                    ->where(function($query) use ($search, $searchArt) {
                        $query->where('PPProduktpass_PPProjekte_Projekt', 'like', '%' . $search . '%')
                        ->orwhere('PPProduktpass_IAN', 'like', "%$search%")
                        ->orwhere('PPProduktpass_Artikelbezeichnung', 'like', "%$searchArt%")
                        ->orwhere('PPProduktpass_ArtikelTarga', 'like', "%$searchArt%");
                    })
                    ->orderBy('SORTSTATUS')
                    ->orderBy('PPProduktpass_PPProjekte_Projekt')
                    ->orderBy('PPProduktpass_IAN')
                    ->orderBy('PPProduktpass_Ausmusterungnummer')
                    ->get();
        } else {
            $subData['liqs'] = DB::table('v_Liquiditaet')->where('PPProduktpass_Id', -12)
                    ->orderBy('Projekt', 'DESC')
                    ->orderBy('IAN')
                    ->get();
            $search_ausmusterung = "";
        }
        cpcDebug::cpc_debug(DB::getQueryLog(), '-showOrderAll1');
        $subData['Header'] = "Dashboard übergreifende IAN-Suche";
        $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
        $subData['inp']['search'] = $search;
        $subData['lang'] = $lang;
        $data['content'] = View::make('projects.AuftragsUebersicht')->with('data', $subData);
        return View::make('main', $data);
    }  
    public function upload2Sharepoint (){
        $ppid = Input::get('ppid');
        $this->_upload2Sharepoint($ppid);
    }
    private function getAktPP($ppid){
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (!$pp){
            echo('Kein Produktpass gefunden');
            exit;
        }
        if (strpos($pp->PPProduktpass_IAN,'ev') === false){
            return $pp;
        }
        //das ist nicht der aktuelle pp
        $ian = substr($pp->PPProduktpass_IAN,0,6);
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $pp =  tPPProduktpass::where('PPProduktpass_IAN','=', $ian)->where('PPProduktpass_Ausmusterungnummer','like', "$ausm%")->get()->first();
        if ($pp){
            return $pp;
        }
        exit;
    }
    private  function _upload2Sharepoint ($_ppid){
        //echo($ppid);exit;
        $pp = $this->getAktPP($_ppid);
        $ppid = $pp->PPProduktpass_Id;
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Status','1')->whereNull('PPPPFiles_SharePointLink')->orderBy('PPPPFiles_Date')->get();
        if (! $files){
            cpcDebug::cpc_debug('Keine Dateien für Tarnsfer gefunden','SharePoint1'); 
            echo('Keine Dateien gefunden');
            exit;
            return false;
        }
        $i = 1;
        foreach($files as $file){
            $path = public_path('data/'.$file->PPPPFiles_Pfad.'/');
            $path = str_replace('Dev','', $path);
            //echo($path.'<br>');
            $filename = trim($file->PPPPFiles_Name);
            //cpcDebug::cpc_debug('Start:'.$path.$filename, 'SharePoint1'); 
            $fullFilepath = $path.$filename;
            //echo("$i.) Untersuche: $fullFilepath");
            //$i++; 
            $link = null;
            if (file_exists($fullFilepath)){
                //echo(' OK <br>');
                $oc = new Office365Controller;
                try{
                    $link = $oc->uploadFromTPT($ian.'_'.$ausm, $fullFilepath);
                }
                catch (Exception $ex){
                    $link = null;
                }
                if(!is_null($link)){
                    $file->PPPPFiles_SharePointLink = $link;
                    $newFilename = $filename; 
                    if (strlen($filename)> 6){
                        if (substr($filename,6,1) == '_' ){
                            $newFilename = substr($filename,7);
                        }
                    }
                    $file->PPPPFiles_TPTFilenameOld = $filename;
                    $file->PPPPFiles_Name = $newFilename;
                    $file->save();
                }
            } else {
                //cpcDebug::cpc_debug('Fehler:'.$file->PPPPFiles_Name.' nicht vorhanden', 'SharePoint1'); 
            }
        }
        $filesExists = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Status','1')->whereNull('PPPPFiles_SharePointLink')->exists();
        if (!$filesExists){
            $pp->PPProduktpass_Transferd2Sharepoint = 1;
        }
        $pp->save();
        return Redirect::to('/showAfterUpload/' . $ppid . "/2");        
    }
    private function uploadFile2Sharepoint($file, $ian, $ausm){
        //cpcDebug::cpc_debug('Point3: '.$file.'___'.$ian.'_'.$ausm,'log500');
        $ppath = $file->PPPPFiles_Pfad;
        if ($file->PPPPFiles_Type == 'PPUpload' and $file->PPPPFiles_SubKat == 'Produktpass' and strtoupper(substr($file->PPPPFiles_Name,-3) == 'XML')){
            $ppath = 'import/XML';
        } 
        //$path = public_path('data/'.$ppath.'/');
        $path = '/var/www/targa/public/data/'.$ppath.'/';
        $filename = trim($file->PPPPFiles_Name);
        $fullFilepath = $path.$filename;
        if (!file_exists($fullFilepath)){
            $path = str_replace('Dev','', $path);
            $fullFilepath = $path.$filename;
        }
        //echo($path.'<br>');
        //cpcDebug::cpc_debug('Start:'.$path.$filename, 'SharePoint1'); 
        //echo("$i.) Untersuche: $fullFilepath");
        //$i++; 
        $link = null;
        $this->writeMsgFile("<div style='padding-left:20px;padding-top:10px;'><b> [".$file->PPPPFiles_Type.'/'.$file->PPPPFiles_SubKat."]</b> Datei: $fullFilepath ");
        if (file_exists($fullFilepath)){
            //echo(' OK <br>');
            $oc = new Office365Controller;
            try{
                $link = $oc->uploadFromTPT($ian.'_'.$ausm, $fullFilepath);
            }
            catch (Exception $ex){
                $link = false;
            }
            if($link !== false ){
                $file->PPPPFiles_SharePointLink = $link;
                $newFilename = $filename; 
                $pre = '';
                if (strlen($filename)> 6){
                    if (substr($filename,6,1) == '_' ){
                        $newFilename = substr($filename,7);
                        $pre = substr($filename,0,7);
                    }
                }
                $file->PPPPFiles_TPTFilenameOld = $filename;
                $file->PPPPFiles_Name = $newFilename;
                $file->save();
                $this->writeMsgFile( "<span style='color:green;'>OK</span> <span style='color:black;'>.</span><br>","OK");
                $this->writeMsgFile("<div style='padding-left:80px;padding-top:0px;'><span style='color:green;margin-right:15px;'><b>$pre</b></span> <span style='color:black;'>$newFilename</span></div>", $newFilename);
                cpcDebug::cpc_debug('Point5A','log500');
            } else {
                $this->writeMsgFile( "<span style='color:red;'>FAILED</span><span style='color:black;'>.</span><br>","FAILED");
                $this->msgFileError = true;
                $this->msgFilePPError = true;
                //cpcDebug::cpc_debug('Point5B','log500');
            }
            $this->writeMsgFile('</div>');
            cpcDebug::cpc_debug('Point5C','log500');
        } else {
            $this->writeMsgFile("<span style='color:red;'>FAILED No File</span><span style='color:black;'>.</span><br></div>");
            $this->msgFileError = true;
            $this->msgFilePPError = true;
        }
    }
    public  function upload2SharepointBulkP (){
        ini_set('max_execution_time', 0);
        //ob_start();
        //ob_implicit_flush(true);
        //header('Content-Type: text/event-stream; charset=utf-8');
        //header('Cache-Control: no-cache');
        $max = Input::get('maxIAN');
        $this->upload2SharepointBulk($max);
        $mail = new MailController();
        $to = Auth::user()->PPMitarbeiter_email;
        $cca = null;
        $subject = 'Protokoll Dateitransfer TPT => Sharepoint';
        if ($this->msgFileError){
            $subject = 'Protokoll Dateitransfer TPT => Sharepoint [mit Fehlern]';
        }
        $body = $this->getMsgFileBody();
        $mail->sendMail($to, $cca, $subject, $body);
    }
    public  function upload2SharepointBulk ($max = 5){
        $openTransfers = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->whereNotNull('PPProduktpass_Transferd2Sharepoint')->count();
        //$errorTransfers = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->where('PPProduktpass_Transferd2Sharepoint',0)->count();
        //$successTransfers = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->where('PPProduktpass_Transferd2Sharepoint',1)->count();
        $pps = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->where('PPProduktpass_IAN','not like', '99%')->where('InternerStatus', 'FIX')->whereNull('PPProduktpass_Transferd2Sharepoint')->orderBy('PPProduktpass_Id')->get();
        $i = 0;
        $this->writeMsgFile("<div style='padding:30px;font-family:arial;font-size:1em;' ><div><b>Protokoll zur Übertragung von $max/ $openTransfers IANs nach Sharepoint</b><br><br><span style='color:green;'>Start: ".date('d.m.Y H:i:s')."</span></div><br>","Protokoll zur Übertragung von $max/ $openTransfers IANs nach Sharepoint");
        if ($pps){
            foreach($pps as $pp){
                $i++;
                if ($i > $max){
                    //echo('      Max erreicht<br>');
                    if ($this->msgFileError){
                        $this->writeMsgFile("<br><div style='padding-top:25px;color:red;'><b>Ende mit Fehlern: </b>".date('d.m.Y H:i:s')."</div>","Ende mit Fehlern: ".date('d.m.Y H:i:s'));
                    } else {
                        $this->writeMsgFile("<br><div style='padding-top:25px;color:green;'>Ende ohne Fehler: ".date('d.m.Y H:i:s')."</div>","Ende ohne Fehler: ".date('d.m.Y H:i:s'));
                    }
                    return;
                }
                $server = $_SERVER['SERVER_NAME']."/show/".$pp->PPProduktpass_Id."/2";
                 $this->writeMsgFile("<div style='padding-left:20px;padding-top:10px;'> $i.) IAN: <a href='http://$server' target='_blank'>". $pp->PPProduktpass_IAN."_". substr($pp->PPProduktpass_Ausmusterungnummer,0,4)."</a>
                <a target='_blank' href='https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/Forms/AllItems.aspx?id=%2Fsites%2FTPTStorage%2FFreigegebene%20Dokumente%2FIANs%2F".$pp->PPProduktpass_IAN."%5F". substr($pp->PPProduktpass_Ausmusterungnummer,0,4)."'>[SPO]</a>",'$pp->PPProduktpass_IAN."_". substr($pp->PPProduktpass_Ausmusterungnummer,0,4)');
                //cpcDebug::cpc_debug('Point1','log500');
                $this->_upload2SharepointBulk ($pp);
                $this->writeMsgFile("</div>");
            }
        } else {
             $this->writeMsgFile('Keine IAN zur Übertragung gefunden!<br>',"Keine IAN zur Übertragung gefunden!");
        }
         $this->writeMsgFile("<br><a href='http://dev.ad.targa.de/upl2spo'>Zurück</a></div>");
    }
    public function setFileSizes (){
        $files = PPPPFiles::where('PPPPFiles_Status','1')->whereNull('PPPPFiles_SharePointLink')->orderBy('PPPPFiles_Date')->get();
        if (! $files){
            //cpcDebug::cpc_debug('Keine Dateien für Tarnsfer gefunden','SharePoint1'); 
             $this->writeMsgFile('Keine Dateien gefunden');
            exit;
            return false;
        }
        $i = 1;
        foreach($files as $file){
            $path = public_path('data/'.$file->PPPPFiles_Pfad.'/');
            $path = str_replace('Dev','', $path);
            //echo($path.'<br>');
            $filename = trim($file->PPPPFiles_Name);
            //cpcDebug::cpc_debug('Start:'.$path.$filename, 'SharePoint1'); 
            $fullFilepath = $path.$filename;
            if (file_exists($fullFilepath)){
                $size = filesize($fullFilepath);
            } else {
                $size = -1;
            }
            $file->PPPPFiles_Size = $size;
            $file->save();
        }
    }
    private  function _upload2SharepointBulk ($pp){
        // $this->writeMsgFile($ppid);exit;
        ini_set('max_execution_time', 0);
        $this->msgFilePPError = false;
        if (!$pp){
             $this->writeMsgFile('Kein Produktpass gefunden');
            exit;
            return false;
        }
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $ppid = $pp->PPProduktpass_Id;
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Status','1')->whereNull('PPPPFiles_SharePointLink')->orderBy('PPPPFiles_Date')->get();
        if (! $files){
            //cpcDebug::cpc_debug('Keine Dateien für Tarnsfer gefunden','SharePoint1'); 
             $this->writeMsgFile('Keine Dateien gefunden');
            exit;
            return false;
        }
        $i = 1;
        foreach($files as $file){
            //cpcDebug::cpc_debug('Point2: '.$ian.'_'.$ausm.' File:'.$file->PPPPFiles_Name,'log500');
            $this->uploadFile2Sharepoint($file, $ian, $ausm);
        }
        $filesExists = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Status','1')->whereNull('PPPPFiles_SharePointLink')->exists();
        if (!$filesExists){
            $pp->PPProduktpass_Transferd2Sharepoint = 1;
        } else {
            $pp->PPProduktpass_Transferd2Sharepoint = 0;
        }
        $pp->save();
        if ($this->msgFilePPError){
            $this->writeMsgFile("<div style='padding-top:20px;color:red;'><b>Übertragung mit Fehler(n)!</b></div>", "Übertragung mit Fehler(n)!");
        } else {
            $this->writeMsgFile("<div style='padding-top:20px;color:green;'>Übertragung OK!</div>". "Übertragung OK!");
        }
        $openTransfers = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->whereNull('PPProduktpass_Transferd2Sharepoint')->count();
        $errorTransfers = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->where('PPProduktpass_Transferd2Sharepoint',0)->count();
        $this->writeMsgFile("<div>Dateien aus $openTransfers IANs müssen noch übertragen werden.</div>","Dateien aus $openTransfers IANs müssen noch übertragen werden.");
        $this->writeMsgFile("<div>Bei $errorTransfers IANs liegen Übetragungsfehler vor.</div>","Bei $errorTransfers IANs liegen Übetragungsfehler vor.");
    }
    public function getFiles($ppid){
        $tmp_files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', '=', $ppid)->where('PPPPFiles_Status', '>=', 1)->orderBy('PPPPFiles_Type')->orderBy('PPPPFiles_SubKat')->orderBy('PPPPFiles_Date', 'DESC')->get();
        $distinct_files = array();
        $total = 0;
        $transferd = 0;
        $filearray = array();
        foreach ($tmp_files as $tfile) {
            if (!isset($distinct_files[$tfile->PPPPFiles_Name])){
                $distinct_files[$tfile->PPPPFiles_Name.$tfile->PPPPFiles_Type.$tfile->PPPPFiles_SubKat] = $tfile;
            }
            if (!isset($tfile->PPPPFiles_SubKat)) {
                $tfile->PPPPFiles_SubKat = "Dateien";
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
        //cpcDebug::pe( $ret);
        return $ret;
    }
    public function renameIAN_SPO ($old_IAN, $old_Charge, $new_IAN, $new_Charge ){
        $oc = new Office365Controller();
        $old = $old_IAN .'_'.$old_Charge;
        $new = $new_IAN .'_'.$new_Charge;
        $oc->renameFolder($old, $new);
    }
    public function showFilesAll() {
        cpcDebug::cpc_debug('showFilesAll','@DB');
        $role = Auth::user()->PPMitarbeiter_Role;
        if (! isset($_COOKIE['TPTLanguage'])){
            $_COOKIE['TPTLanguage'] =  Auth::user()->PPMitarbeiter_Language; //'DE';
        } 
        $lang = $_COOKIE['TPTLanguage'];   
        $isExtern = 0;
        if (strpos($role,'INTERN') === false ){
            $isExtern = 1;
        }
        $inp = Input::all();
        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $subData['inp']['search_date'] = '';
        $subData['inp']['search_status'] = '';
        $subData['inp']['search_subkat'] = '';
        $subData['inp']['search_type'] = '';
        $subData['inp']['search_ord'] = '';
        $subData['inp']['search_ian'] = '';
        $search_ausmusterung = '';
        $search_date = '';
        $search_status = '';
        $search_type = '';
        $search_subkat = '';
        $search_ord = '';
        $search_ian = '';
        $search = '';
        $sx = array();
        $sx[] = $search;
        if (isset($inp['IsPost'])) {
            $search = $inp['search'];
            $sx[] = '%'.$search.'%';
            if (strpos($search,'%')!== false){
                $sx = explode('%',$search);
                /*
                for($i=0; $i<count($sx); $i++){
                    $sx[$i] = '%'.$sx[$i].'%';
                }
                for($i=count($sx); $i<5; $i++){
                    $sx[$i] = '';
                }*/
                $this->index = 0;
                $this->sxg = array();
                $n = count($sx);
                $this->heapPermutation($sx,$n,$n);
                foreach($this->sxg as $key=> $perm){
                    $sx[$key] = '%';
                    foreach($perm as $s1){
                        $sx[$key] .= $s1.'%';
                    }
                }
            }  
            for($i=count($sx); $i<=23;$i++){
                $sx[$i] = '';
            }              
            $search_ausmusterung = $inp['search_ausmusterung'];
            $search_date = $inp['search_date'];
            $search_status = $inp['search_status'];
            $search_type = $inp['search_type'];
            $search_subkat = $inp['search_subkat'];
            $search_ord = $inp['search_ord'];
            $search_ian = $inp['search_ian'];
            DB::enableQueryLog();
            $subData['files'] = DB::table('v_FilesAll')
            ->where('PPProduktpass_Ausmusterungnummer', 'like', $search_ausmusterung . '%')
            ->where('PPProduktpass_IAN', 'like', $search_ian . '%')
            ->where('FileDate', 'like', $search_date . '%')
            ->where('InternerStatus', 'like', $search_status . '%')
            ->where('PPPPFiles_Type', 'like', $search_type . '%')
            ->where('PPPPFiles_IsExtern', '>=', $isExtern)
            ->where('PPPPFiles_SubKat', 'like', $search_subkat . '%')
            ->where('PPPPFiles_Ordnung', 'like', $search_ord . '%')
            ->where(function($query) use ($search, $sx) {
                        $query->where('PPProduktpass_Artikelbezeichnung', 'like', "$search%")
                        ->orwhere('PPProduktpass_ArtikelTarga', 'like', "$search%")
                        ->orwhere('PPPPFiles_Name', 'like', $sx[0] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[1] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[2] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[3] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[4] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[5] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[6] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[7] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[8] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[9] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[10] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[11] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[12] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[13] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[14] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[15] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[16] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[17] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[18] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[19] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[20] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[21] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[22] )
                        ->orwhere('PPPPFiles_Name', 'like', $sx[23] )
                        ;
                    })
                    ->orderBy('PPProduktpass_PPProjekte_Projekt')
                    ->orderBy('PPProduktpass_IAN')
                    ->orderBy('PPProduktpass_Ausmusterungnummer')
                    ->orderBy('PPPPFiles_Name')
                    ->get();
                    cpcDebug::cpc_debug(DB::getQueryLog(),'@DB');
        } else {
            $subData['files'] = null;
            $search_ausmusterung = "";
        }
        $subData['Header'] = "Datei Suche";
        $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
        $subData['inp']['search'] = $search;
        $subData['inp']['search_date'] = $search_date;
        $subData['inp']['search_status'] = $search_status;
        $subData['inp']['search_type'] = $search_type;
        $subData['inp']['search_subkat'] = $search_subkat;
        $subData['inp']['search_ord'] = $search_ord;
        $subData['inp']['search_ian'] = $search_ian;
        $data['content'] = View::make('projects.DateiUebersicht')->with('data', $subData);
        return View::make('main', $data);
    }
    private function heapPermutation($sx, $size, $n)
    {
        // if size becomes 1 then prints the obtained
        // permutation
        if ($size == 1) {
            $this->sxg[$this->index] = $sx;
            $this->index ++;
            return;
        }
        for ($i = 0; $i < $size; $i++) {
            $this->heapPermutation($sx, $size - 1, $n);
            // if size is odd, swap 0th i.e (first) and 
            // (size-1)th i.e (last) element
            if ($size % 2 == 1){
                $a = $sx[0];
                $b = $sx[$size -1];
                $sx[0] = $b;
                $sx[$size -1] = $a;
            }
            // If size is even, swap ith and 
            // (size-1)th i.e (last) element
            else {
                $a = $sx[$i];
                $b = $sx[$size -1];
                $sx[$i] = $b;
                $sx[$size -1] = $a;
            }
        }
    }
    private function getContainerVerschiffungen($miid){
        $cs = PPContainerVerschiffungen::where('PPContainerVerschiffungen_PPInputManuell_Id', $miid)->get();
        $ret = false;
        if ($cs){
            $ret = array();
            $i=0;
            foreach($cs as $c){
                $ret[$i++] = $c;
            }
        }
        return $ret;
    }
    private function saveContainerVerschiffung($cs, $miid){
        if (is_null($cs) or !isset ($cs)){
            return;
        }
        foreach($cs as $key => $c){
            if (substr($key,0,3) == 'New'){
                $this->newContainerVerschiffung($c, $miid);
            } else {
                $cv = PPContainerVerschiffungen::where('PPContainerVerschiffungen_Id', $key)->get()->first();
                if ($cv){
                    $cv->PPContainerVerschiffungen_Hafen = $c['Hafen'];
                    $cv->PPContainerVerschiffungen_Menge =  $this->Int2MySql($c['Menge']);
                    $cv->PPContainerVerschiffungen_40 = $this->Dec2MySql($c['C40']);
                    $cv->PPContainerVerschiffungen_20 = $this->Dec2MySql($c['C20']);
                    $cv->save();
                }
            }
        }
    }
    private function newContainerVerschiffung($c, $miid){
        if ($c['Hafen'] == ''){
            return;
        }
        $cv = new PPContainerVerschiffungen();
        $cv->PPContainerVerschiffungen_Hafen = $c['Hafen'];
        $cv->PPContainerVerschiffungen_Menge = $this->Int2MySql($c['Menge']);
        $cv->PPContainerVerschiffungen_40 = $this->Dec2MySql($c['C40']);
        $cv->PPContainerVerschiffungen_20 = $this->Dec2MySql($c['C20']);
        $cv->PPContainerVerschiffungen_PPInputManuell_Id = $miid;
        $cv->save();
    }
    public function getMenge($ppid){
        $menge = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $ppid)->orderBy('PPProduktpass_Menge_Id')->orderBy('PPProduktpass_Menge_Country')->get();
        if ($menge){
           // $mneu = array();
           // foreach($menge as $mx){
           //     $mneu[$mx->PPProduktpass_Menge_Country] = $mx;
           // }
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
            if ($pp){
                $altPPId = $pp->PPProduktpass_RevisionVon_PPProduktpass_Id;
                if ($altPPId != 0){
                    $ppAlt = tPPProduktpass::where('PPProduktpass_Id', $altPPId)->get()->first();
                    $mengenAlt  = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $altPPId)->orderBy('PPProduktpass_Menge_Id')->orderBy('PPProduktpass_Menge_Country')->get();
                    if ($mengenAlt){
                        $ma = array();
                        foreach($mengenAlt as $m){
                            $ma[$m->PPProduktpass_Menge_Country] = $m;
                        }
                        $importDatum = new DateTime($ppAlt->PPProduktpass_RevisionDatum);
                        return array('Menge' => $menge, 'MengeAlt' => $ma, 'Import' => $importDatum->format('d.m.Y'));
                    }
                }
            }
            return array('Menge' => $menge, 'MengeAlt' => null, 'Import' => '');
        }        
        return array('Menge' => null, 'MengeAlt' => null);
    }
    private function setDiff ($m, $malt, $att){
        $color = 'black';
        $title = '';
        if (!is_null($malt)){
             if ($m->{$att} != $malt->{$att}){
                  $col = 'dodgerblue';
                  $title = $malt->{$att};
             }
        }
        return array('Color' => $color, 'Title' => $title);
    }
    public function xFiles(){
        $ppid = 13;
        $data['Kategorien'] = $this->getKategorien();
        $data['pp'] = $this->getPP($ppid);
        if (is_null($data['pp'])){
            echo('Ungültiger Link');
            exit;
        }
        $id = $data['pp']->PPProduktpass_Id;
        $firstLetter = substr($id, 0, 1);
        if ($id > 100000) {
            $pptemp = PPProduktpass::where('PPProduktpass_IAN', "=", $id)->get()->first();
            if ($pptemp) {
                $id = $pptemp->PPProduktpass_Id;
            } else {
                echo ("IAN nicht vorhanden!");
                exit;
            }
        } 
        $data['tabs'] = array('mainTab' => '0', 'mainTabIndex' => 0, 'subTabName' => '', 'subTabIndex' => 0, 'subsubTabIndex' => 0, 'compactView' => 0);
        $data['files'] = $this->getFiles($ppid);
        $data['files']['typesLB'] = $this->getUploadTypes(True);
        $data['files']['subtypesLB'] = $this->getUploadSubTypes(True);
        $data['files']['types'] = $this->getUploadTypes();
        $data['files']['subtypes'] = $this->getUploadSubTypes();
        //$this->prncpc($data,1);
        //$data['content'] = View::make('projects.pp_files')->with('data', $data);
        $data['content'] =  View::make('projects.pp_files_StandAlone')->with('data', $data);
        return View::make('main', $data);
    }
    private function normalizeText($text) {
        $text = trim($text);
        $text = preg_replace('/\x{00A0}|\x{200B}/u', '', $text); // NBSP, Zero-width
        if (class_exists('Normalizer')) {
            $text = Normalizer::normalize($text, Normalizer::FORM_C);
        }
        return $text;
    }
    private function strcmp_normalized(string $a, string $b): int {
        $normalize = function (string $s): string {
            // Entferne BOM
            $s = preg_replace('/^\xEF\xBB\xBF/', '', $s);
            // Vereinheitliche Zeilenumbrüche (alle auf \n)
            $s = str_replace(["\r\n", "\r"], "\n", $s);
            // Entferne Zero-width und NBSP
            $s = preg_replace('/[\x{200B}\x{FEFF}\x{00A0}]/u', '', $s);
            // Trimmen
            $s = trim($s);
            // Unicode normalisieren (wenn intl verfügbar)
            if (class_exists('Normalizer')) {
                $s = Normalizer::normalize($s, Normalizer::FORM_C);
            }
            return $s;
        };
        return strcmp($normalize($a), $normalize($b));
    }
    private function deeplProtectLinebreaks(string $s): string {
        // Einheitliche Line Endings
        $s = str_replace(["\r\n", "\r"], "\n", $s);
        // Absätze zuerst (doppelte Umbrüche)
        $s = str_replace("\n\n", "<P/>", $s);
        // Einzelne Umbrüche
        $s = str_replace("\n", "<LB/>", $s);
        return $s;
    }
    private function deeplRestoreLinebreaks(string $s): string {
        $s = str_replace("<LB/>", "\n", $s);
        $s = str_replace("<P/>", "\n\n", $s);
        return $s;
    }
    private function deeplTextToHtml(string $input): string {
        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $input);
        $text = trim($text);
        if ($text === '') {
            return '<p></p>';
        }
        // Escape ALL user text so it can't break HTML
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        // Paragraph split: one or more blank lines => new paragraph
        $paragraphs = preg_split("/\n\s*\n+/u", $text);
        // Within a paragraph: single newline => <br>
        $paragraphs = array_map(function ($p) {
            $p = preg_replace("/\n/u", "<br>\n", $p);
            return "<p>{$p}</p>";
        }, $paragraphs);
        return implode("\n", $paragraphs);
    }
}
