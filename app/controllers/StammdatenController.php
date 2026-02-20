<?php
class StammdatenController extends \BaseController {
    public function anyIndex($art = "cs") {
        $msg = "";
        switch ($art) {
            case 'cs':
                $id = 0;
                if (Input::get('submit_button') == "anzeigen") {
                    $id = Input::get("PPBW_Laendergroesse_Id");
                }
                if (Input::get('submit_button') == "speichern") {
                    $this->cs_save();
                }
                if (Input::get('submit_button') == "Neues Land anlegen / Grösse ergänzen") {
                    $msg = $this->cs_new(Input::get('NeuesLand'));
                }
                return $this->countrysize($id, $msg);
            case 'ausmusterung':
                return $this->StammdatenAusmusterung('');
            default:
                break;
        }
    }
    private function existiertLandGroesse($land, $groesse) {
        $test = PPBW_Laendergroessen::where('PPBW_Laendergroessen_Land', "=", $land)->where('PPBW_Laendergroessen_Groesse', "=", $groesse)->get()->first();
        if ($test) {
            return true;
        }
        return false;
    }
    public function cs_new($pland) {
        $land = trim(strtoupper($pland));
        $len  = strlen($land);
        if ($len < 2 and $len > 4) {
            return "Bitte 2,3,4-stelligen Ländercode benutzen";
        }
        /* if (count($test) >= 1) {
          return " $land  existiert bereits";
          } */
        $groessen = PPBW_Laendergroessen::select('PPBW_Laendergroessen_Groesse')->groupBy('PPBW_Laendergroessen_Groesse')->get()->toArray();
        //var_dump($groessen);exit;
        $message = "Alle Grössen für Land $land vorhanden!";
        foreach ($groessen as $groesse) {
            if (!$this->existiertLandGroesse($land, $groesse['PPBW_Laendergroessen_Groesse'])) {
                $message = "Grösse " . $groesse['PPBW_Laendergroessen_Groesse'] . " für $land angelegt<br>";
                $cs = new PPBW_Laendergroessen;
                $cs->PPBW_Laendergroessen_Land          = $land;
                $cs->PPBW_Laendergroessen_Groesse       = $groesse['PPBW_Laendergroessen_Groesse'];
                $cs->PPBW_Laendergroessen_Bett_Laenge   = '0';
                $cs->PPBW_Laendergroessen_Bett_Breite   = '0';
                $cs->PPBW_Laendergroessen_Kissen_Laenge = '0';
                $cs->PPBW_Laendergroessen_Kissen_Breite = '0';
                $cs->PPBW_Laendergroessen_Anz_Kissen    = '0';
                $cs->PPBW_Laendergroessen_Einheit       = 'cm';
                $cs->save();
            }
        }
        return $message;
    }
    private function inp2Int($val) {
        $int = 0;
        if (strlen(trim($val)) > 0) {
            try {
                $int = (int) $val;
            }
            catch (Exception $ex) {
                $int = 0;
            }
        }
        return $int;
    }
    public function cs_save() {
        $csinp = Input::get('CS');
        //var_dump($csinp);        exit;
        $cs = PPBW_Laendergroessen::where('PPBW_Laendergroessen_Id', '=', $csinp['Id'])->first();
        $cs->PPBW_Laendergroessen_Bett_Laenge       = $this->inp2Int($csinp['Bett_Laenge']);
        $cs->PPBW_Laendergroessen_Bett_Breite       = $this->inp2Int($csinp['Bett_Breite']);
        $cs->PPBW_Laendergroessen_Kissen_Laenge     = $this->inp2Int($csinp['Kissen_Laenge']);
        $cs->PPBW_Laendergroessen_Kissen_Breite     = $this->inp2Int($csinp['Kissen_Breite']);
        $cs->PPBW_Laendergroessen_Anz_Kissen        = $this->inp2Int($csinp['Anz_Kissen']);
        $cs->PPBW_Laendergroessen_Einheit           = $csinp['Einheit'];
        $cs->PPBW_Laendergroessen_Bett_SaumLaenge   = $this->inp2Int($csinp['Bett_SaumLaenge']);
        $cs->PPBW_Laendergroessen_Bett_SaumBreite   = $this->inp2Int($csinp['Bett_SaumBreite']);
        $cs->PPBW_Laendergroessen_Kissen_SaumLaenge = $this->inp2Int($csinp['Kissen_SaumLaenge']);
        $cs->PPBW_Laendergroessen_Kissen_SaumBreite = $this->inp2Int($csinp['Kissen_SaumBreite']);
        $cs->PPBW_Laendergroessen_Duvet_Laenge = strlen(trim($csinp['Duvet_Laenge'])) > 0
                    ? $this->inp2Int($csinp['Duvet_Laenge']) : 0;
        $cs->PPBW_Laendergroessen_Duvet_Breite     = strlen(trim($csinp['Duvet_Breite'])) > 0
                    ? $this->inp2Int($csinp['Duvet_Breite']) : 0;
        $cs->PPBW_Laendergroessen_Duvet_SaumLaenge = strlen(trim($csinp['Duvet_SaumLaenge'])) > 0
                    ? $this->inp2Int($csinp['Duvet_SaumLaenge']) : 0;
        $cs->PPBW_Laendergroessen_Duvet_SaumBreite = strlen(trim($csinp['Duvet_SaumBreite'])) > 0
                    ? $this->inp2Int($csinp['Duvet_SaumBreite']) : 0;
        $cs->PPBW_Laendergroessen_Bett_Verdoppeln   = $csinp['Bett_Verdoppeln'];
        $cs->PPBW_Laendergroessen_Kissen_Verdoppeln = $csinp['Kissen_Verdoppeln'];
        $cs->PPBW_Laendergroessen_Duvet_Verdoppeln  = $csinp['Duvet_Verdoppeln'];
        $cs->update();
    }
    public function countrysize($id = 0, $msg = "") {
        //
        $cs_tab = false;
        $cs_id = 0;
        if ($id != 0) {
            $cs_tab = PPBW_Laendergroessen::where('PPBW_Laendergroessen_Id', '=', $id)
                    ->first();
            $cs_id  = $cs_tab->PPBW_Laendergroessen_Id;
        }
        $css = PPBW_Laendergroessen::where('PPBW_Laendergroessen_Id', '>=', 0)
                ->orderBy('PPBW_Laendergroessen_Land', 'asc')
                ->orderBy('PPBW_Laendergroessen_Groesse', 'asc')
                ->get();
        $a_CS    = array();
        $a_CS[0] = "Bitte wählen...";
        foreach ($css as $cs) {
            $a_CS[$cs->PPBW_Laendergroessen_Id] = "" . $cs->PPBW_Laendergroessen_Land . "  [" . $cs->PPBW_Laendergroessen_Groesse . "]";
            //echo($cs->PPBW_Laendergroessen_Id ."<br>");
        }
        //asort($a_CS);
        //echo("<pre>");var_dump($a_CS); exit;
        $csa['cbCont'] = $a_CS;
        $csa['cs']     = $cs_tab;
        $csa['cs_id']  = $cs_id;
        $csa['msg']    = $msg;
        $data['content'] = View::make('stammdaten.formCountrySize')->with('csa', $csa);
        cpcDebug::cpc_debug("anyIndex", "Ende");
        return View::make('main', $data);
    }
    public function anyDelete() {
    }
    public function StammdatenAusmusterung($pausmusterung = '0000')
    {
        $ausmusterung = $pausmusterung;
        $preise = array();
        $kostcont = KostenContainer::where('KostenContainer_ausmusterung', '=', $ausmusterung)->count();
        if ($kostcont == 0){
            $ausmusterung = '9999';
        } 
        $kostcont = KostenContainer::where('KostenContainer_ausmusterung', '=', $ausmusterung)->get();
        foreach($kostcont as $cost){
            $preise[$cost->KostenContainer_Gruppe][$cost->KostenContainer_Art] = $cost->KostenContainer_Preis;
        }
        $stamm['preise'] = $preise;
/*        foreach ($preise as $grp => $arts) {
            foreach ($arts as $art => $preis) {
                $kostenContainer = new KostenContainer();
                $kostenContainer->KostenContainer_Ausmusterung ="2201";
                $kostenContainer->KostenContainer_Art = $art;
                $kostenContainer->KostenContainer_Gruppe = $grp;
                $kostenContainer->KostenContainer_Preis = $preis;
                $kostenContainer->save();
            }
        }
*/
        $stamms = AusmusterungStamm::where('AusmusterungStamm_ausmusterung', '=',$pausmusterung)->get()->first();
        $stamm['kosten_nachlauf'] = 0;
        $stamm['kosten_entladung'] = 0;
        $stamm['kosten_finanzierung'] = 0;
        $stamm['kosten_sonstigeVK'] = 0;
        $stamm['kurs'] = 0;
        $stamm['ausmusterung'] = $pausmusterung;
        if ($stamms){
            $stamm['kosten_nachlauf'] = $stamms->AusmusterungStamm_kosten_nachlauf;
            $stamm['kosten_entladung'] = $stamms->AusmusterungStamm_kosten_entladung;
            $stamm['kosten_finanzierung'] = $stamms->AusmusterungStamm_kosten_finanzierung;
            $stamm['kosten_sonstigeVK'] = $stamms->AusmusterungStamm_kosten_sonstigeVK;
            $stamm['kurs'] = $stamms->AusmusterungStamm_kurs;
            $stamm['ausmusterung'] = $stamms->AusmusterungStamm_ausmusterung;;
        }
        $data['content'] = View::make('stammdaten.Ausmusterungsstamm')->with('stamm', $stamm);
        return View::make('main', $data);
    }
    private function dec2Sql($dec) {
        $x = str_replace('.','', $dec);
        $y = str_replace(',','.', $x);
        return $y;
    }
    public function saveStammaus()
    {
        $ausmusterung  = Input::get('ausmusterung');
        if (Input::get('submitArt') == 'show'){
            return $this->StammdatenAusmusterung($ausmusterung);
        }
        $preise  = Input::get('preise');
        foreach ($preise as $grp => $arts) {
            foreach ($arts as $art => $preis) {
                $kostenContainer = KostenContainer::where('KostenContainer_Ausmusterung', $ausmusterung)->where('KostenContainer_Art',$art)->where('KostenContainer_Gruppe',$grp)->get()->first();
                if ($kostenContainer){
                    $kostenContainer->KostenContainer_Preis =$this->dec2Sql($preis);
                    $kostenContainer->save();
                } else {
                    $kostenContainer = new KostenContainer();
                    $kostenContainer->KostenContainer_Ausmusterung = $ausmusterung;
                    $kostenContainer->KostenContainer_Art = $art;
                    $kostenContainer->KostenContainer_Gruppe = $grp;
                    $kostenContainer->KostenContainer_Preis = $this->dec2Sql($preis);
                    $kostenContainer->save();    
                }
            }
        }
        $kosten_nachlauf = $this->dec2Sql(Input::get('kosten_nachlauf'));
        $kosten_entladung = $this->dec2Sql(Input::get('kosten_entladung'));
        $kosten_finanzierung = $this->dec2Sql(Input::get('kosten_finanzierung'));
        $kosten_sonstigeVK = $this->dec2Sql(Input::get('kosten_sonstigeVK'));
        $kurs = $this->dec2Sql(Input::get('kurs'));
        $stamm = AusmusterungStamm::where('AusmusterungStamm_ausmusterung', '=',$ausmusterung)->get()->first();
        if (!$stamm){
            $stamm = new AusmusterungStamm();
            $stamm->AusmusterungStamm_ausmusterung = Input::get('ausmusterung');
        }
        $stamm->AusmusterungStamm_kurs = $kurs;
        $stamm->AusmusterungStamm_kosten_nachlauf = $kosten_nachlauf;
        $stamm->AusmusterungStamm_kosten_entladung = $kosten_entladung;
        $stamm->AusmusterungStamm_kosten_finanzierung = $kosten_finanzierung;
        $stamm->AusmusterungStamm_kosten_sonstigeVK = $kosten_sonstigeVK;
        $stamm->save();
        return $this->StammdatenAusmusterung($ausmusterung);
    }
    /**
     * Store a newly created resource in storage.
     * POST /mitarbeiter
     *
     * @return Response
     */
    public function postStore($id) {
        //
        var_dump(Input::all());
        echo("<br>$id<br>");
        exit;
        //http://belo.tex/adressen/show/264
        //return Redirect::to('adressen/show/'.$id);
        return Redirect::to('Textbausteine');
    }
    /**
     * Display a listing of the resource.
     * GET /adressen
     *
     * @return Response
     */
    public function index() {
        //
    }
    /**
     * Show the form for creating a new resource.
     * GET /adressen/create
     *
     * @return Response
     */
    public function create() {
        //
    }
    /**
     * Store a newly created resource in storage.
     * POST /adressen
     *
     * @return Response
     */
    public function store() {
        //
        //var_dump($_POST);exit;
    }
    /**
     * Display the specified resource.
     * GET /adressen/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function anyShow() {
    }
    public function anyDeleteX($id) {
    }
    /**
     * Show the form for editing the specified resource.
     * GET /adressen/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function anyEdit() {
        var_dump(Input::get('all'));
        exit;
        if (Input::get('submit_button') == "speichern") {
            $tbs                       = PPTextbausteine::where('PPTextbausteine_Id', '=', Input::get('PPTextbausteine_Art'))->first();
            $tbs->PPtextbausteine_Text = Input::get('PPTextbausteine_Text');
            $tbs->save();
            return ($this->anyIndex());
            //echo('speichern');
        }
        if (Input::get('submit_button') == "anzeigen") {
            return ($this->anyIndex(Input::get('PPTextbausteine_Art')));
            //echo("ID:".Input::get('PPTextbausteine_Art'));
        }
        if (Input::get('submit_button') == "Neues Land anlegen / Grösse hinzufügen") {
            //return ($this->anyIndex(Input::get('PPTextbausteine_Art')));
            //echo("ID:".Input::get('PPTextbausteine_Art'));
            echo("neues land");
            exit;
        }
        //echo("<br><pre>");var_dump(Input::all());
    }
    /**
     * Update the specified resource in storage.
     * PUT /adressen/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }
    /**
     * Remove the specified resource from storage.
     * DELETE /adressen/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
public function getFormZoll() {
        //
        if (Auth::user()->PPMitarbeiter_Role === null || (strpos(Auth::user()->PPMitarbeiter_Role,'ZOLL') === false and Auth::user()->PPMitarbeiter_Gruppe != 'admin')) {
            echo( 'Keine Berechtigung!');
            exit;
        }
        $zr = RestrictedZolltarif::where('RestrictedZolltarif_Id', '>=', 0)
                ->where('RestrictedZolltarif_IsActiv', '=', 1)
                ->orderBy('RestrictedZolltarif_Zolltarifnummer', 'asc')
                ->get();
        $data['content'] = View::make('stammdaten.ZollRestriktionen')->with('zoll', $zr);
        return View::make('main', $data);
    }
    public function updateZoll($id){
        // Model anpassen
        cpcDebug::cpc_debug("updateZoll". "Start id=$id","@Zoll");
        $z = RestrictedZolltarif::findOrFail($id);
        // Erlaubte Felder weißlisten!
        $allowed = array(
            'RestrictedZolltarif_Zolltarifnummer',
            'RestrictedZolltarif_Bezeichnug',
            'RestrictedZolltarif_Restriction',
        );
        $input = Input::all(); // enthält _method=PUT + Feld
        // nur erlaubtes Einzelfeld akzeptieren
        $payload = array_except($input, array('_token','_method'));
        if (count($payload) !== 1) {
            return Response::json(array('ok' => false, 'error' => 'Ungültige Nutzlast'), 422);
        }
        $field = key($payload);
        $value = $payload[$field];
        if (!in_array($field, $allowed, true)) {
            return Response::json(array('ok' => false, 'error' => 'Feld nicht erlaubt'), 422);
        }
        // einfache Validierung (Beispiel)
        // if ($field === 'RestrictedZolltarif_Zolltarifnummer' && !preg_match('/^[0-9]+$/', $value)) {
        //     return Response::json(array('ok' => false, 'error' => 'Ungültige Nummer'), 422);
        // }
        $z->$field = $value;
        $z->save();
        return Response::json(array('ok' => true));
    }
     public function createZoll()
    {
        cpcDebug::cpc_debug("createZoll". "Start","@Zoll");
        // ggf. Defaults aus Input lesen
        // $data = array_only(Input::all(), ['RestrictedZolltarif_Zolltarifnummer','RestrictedZolltarif_Bezeichnug','RestrictedZolltarif_Restriction']);
        $z = new RestrictedZolltarif();
        // ggf. Defaults setzen:
        // $z->RestrictedZolltarif_Zolltarifnummer = array_get($data,'RestrictedZolltarif_Zolltarifnummer','');
        // $z->RestrictedZolltarif_Bezeichnug     = array_get($data,'RestrictedZolltarif_Bezeichnug','');
        // $z->RestrictedZolltarif_Restriction   = array_get($data,'RestrictedZolltarif_Restriction','');
        $z->save();
        return Response::json(array('ok' => true, 'id' => $z->RestrictedZolltarif_Id));
    }
    public function deleteZoll($id)
    {
        cpcDebug::cpc_debug("deleteZoll". "Start id=$id","@Zoll");
        $z = RestrictedZolltarif::findOrFail($id);
        if($z){
            $z->RestrictedZolltarif_IsActiv = 0;
            $z->save();
            return Response::json(array('ok' => true));
        }
        return Response::json(array('ok' => false, 'error' => 'Datensatz nicht gefunden'), 422);
    }
}
