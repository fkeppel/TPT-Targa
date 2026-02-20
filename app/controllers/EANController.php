<?php

class EANController extends \BaseController {

    private function basisnummern() {

        $bn = EAN_Basisnummern::get();

        $abn = array();


        $abn[0] = "Bitte wählen...";
        foreach ($bn as $value) {
            //echo("<pre>");var_dump($value);echo('<br><br><br>');

            $abn[$value->EAN_Basisnummern_Id] = $value->EAN_Basisnummern_Kd . " - " . $value->EAN_Basisnummern_Nummer;
        }


        return $abn;
    }

    private function getBasisnummern() {

        $bn = EAN_Basisnummern::get();

        $abn = array();


        foreach ($bn as $value) {
            //echo("<pre>");var_dump($value);echo('<br><br><br>');
            $abn[$value->EAN_Basisnummern_Id] = $value;

            $abn[$value->EAN_Basisnummern_Id]['candelete'] = false;
            if (EAN_Nummern::where("EAN_Nummern_EAN_Basisnummern_Id", "=", $value->EAN_Basisnummern_Id)->
                            where("EAN_Nummern_Status", "not like", "Gelöscht")->count() <= 0) {
                $abn[$value->EAN_Basisnummern_Id]['candelete'] = true;
            }
        }
        return $abn;
    }

    public function anyChangemax() {

        $id = Input::get("id");
        $max = Input::get("newMax");

        cpcDebug::cpc_debug("anyChangebasisnummern @id:$id @max:$max");
        $bn = EAN_Basisnummern::where("EAN_Basisnummern_Id", "=", $id)->first();
        $bn->EAN_Basisnummern_Max = $max;

        $bn->save();

        $response = array("status" => "OK");
        return Response::json($response);
    }

    public function anyDeletebasisnummer() {

        $id = Input::get("id");

        cpcDebug::cpc_debug("anyDeletebasisnummern $id");
        cpcDebug::cpc_debug("all " . print_r(Input::all(), true));
        $bn = EAN_Basisnummern::where("EAN_Basisnummern_Id", "=", $id)->first();
        $bn->delete();

        //Lösche alle EAN_Nummern zu Basisnummer

        $eans = EAN_Nummern::where("EAN_Nummern_EAN_Basisnummern_Id", "=", $id)->get();

        foreach ($eans as $ean) {
            $ean->delete();
        }



        $response = array("status" => "OK");
        return Response::json($response);
    }

    public function anyNewbasisnummer() {




        $bez = Input::get("newBezeichnung");
        $basis = Input::get("newBasis");
        $max = Input::get("newMax");

        cpcDebug::cpc_debug("anyNewbasisnummer @bez:$bez @basis:$basis @max:$max");
        $bn = new EAN_Basisnummern;

        $bn->EAN_Basisnummern_Kd = $bez;
        $bn->EAN_Basisnummern_Nummer = $basis;
        $bn->EAN_Basisnummern_Max = $max;

        $bn->save();

        $response = array("status" => "OK");
        return Response::json($response);
    }

    private function eannummern($id = 0, $status = "", $search = "") {


        //echo($id);

        $stati = explode(",", $status);


        if ($id > 0) {
            $eans = EAN_Nummern::where('EAN_Nummern_EAN_Basisnummern_Id', "=", $id)
                    ->whereIn("EAN_Nummern_Status", $stati)
                    ->orderBy("EAN_Nummern_EAN_Basisnummern_id")
                    ->orderBy("EAN_Nummern_IAN")
                    ->get();
        } else {
            if ($status == "") {
                $eans = EAN_Nummern::get();
            } else {
                if ($search != "") {
                    $eans = EAN_Nummern::where("EAN_Nummern_EAN", "like", "%" . $search . "%")
                            ->orWhere("EAN_Nummern_IAN", "like", "%" . $search . "%")
                            ->orderBy("EAN_Nummern_EAN_Basisnummern_id")
                            ->orderBy("EAN_Nummern_IAN")
                            ->get();
                } else {
                    $eans = EAN_Nummern::whereIn("EAN_Nummern_Status", $stati)
                            ->orderBy("EAN_Nummern_EAN_Basisnummern_id")
                            ->orderBy("EAN_Nummern_IAN")
                            ->get();
                }
            }
        }

        //cpcDebug::cpc_debug("eannummern #$id# #$status#",print_r($eans,true));
        return $eans;
    }

    private function generateEAN($basisid, $ian) {

        //Liefere Freie oder Neue EANS
        //cpcDebug::cpc_debug("generateEAN");
        //cpcDebug::cpc_debug("Baisid: ".$basisid." IAN: ".$ian);
        //echo("<pre>");var_dump($_SESSION);exit;
        $eans = $this->eannummern($basisid, "Frei");

        if (count($eans) > 0) {
            $ean = EAN_Nummern::find($eans[0]->EAN_Nummern_Id);
            $ean->EAN_Nummern_Status = "Gültig";
            $ean->EAN_Nummern_MA = Auth::getUser()->id;
            $ean->EAN_Nummern_IAN = $ian;
            $ean->EAN_Nummern_LetzteAenderung = date('Y-m-d H:i:s');
            $ean->save();
            return $ean->EAN_Nummern_EAN;
        }


        $basis = EAN_Basisnummern::find($basisid);

        if (count($basis) <= 0) {
            return "Error 1     Basisid = " . $basisid;
        }
        $ean = EAN_Nummern::where("EAN_Nummern_EAN_Basisnummern_Id", "=", $basisid)->orderBy("EAN_Nummern_lfd_EAN", "desc")->first();

        if (count($ean) <= 0) {

            $lfd = 0;
        } else {
            $lfd = $ean->EAN_Nummern_lfd_EAN;
        }

        $lfd++;

        $l_lfd = strlen($lfd);
        $basisean = $basis->EAN_Basisnummern_Nummer;
        $l_basisean = strlen($basisean);
        $l_null = 12 - $l_basisean - $l_lfd;

        //echo("Längen: $l_basisean  $l_lfd");
        if ($l_null < 0) {
            echo("Fehler: EAN Überlauf");
            return "ERROR 2";
        }

        $null = "";
        for ($nc = 1; $nc <= $l_null; $nc++) {

            $null .= "0";
        }


        $strean = $basisean . $null . $lfd;

        if (strlen($strean) != 12) {
            cpcDebug::cpc_debug("Fehler in der Berechnung der EAN: $strean $l_null $null <br>");
            return "ERROR 3";
        }

        $qs = 0;

        for ($i = 0; $i < 12; $i++) {
            if ($i % 2) {
                $qs = $qs + $strean[$i];
            } else {
                $qs = $qs + (3 * $strean[$i]);
            }
        }

        $pz = $qs % 10;


        //echo("QS: ".$qs." EAN: ". $strean.$pz);

        $ean = new EAN_Nummern;
        $ean->EAN_Nummern_Status = "Gültig";
        $ean->EAN_Nummern_EAN_Basisnummern_Id = $basisid;
        $ean->EAN_Nummern_lfd_EAN = $lfd;
        $ean->EAN_Nummern_MA = Auth::getUser()->id;
        $ean->EAN_Nummern_IAN = $ian;
        $ean->EAN_Nummern_LetzteAenderung = date('Y-m-d');
        $ean->EAN_Nummern_EAN = $strean . $pz;

        $ean->save();


        return $ean->EAN_Nummern_EAN;
    }

    public function anyManage() {

        $manage_eans = $this->eannummern(3, "Gelöscht,Frei");

        if (Input::has('action') && Input::get('action') == 'manage') {
            $ret_template = 'EAN.manage';
            $data['inpBasis'] = Input::get('inpBasis');
            $data['inpAnzahl'] = Input::get('inpAnzahl');
            $data['inpArtikel'] = Input::get('inpArtikel');
            $view = View::make('EAN.manageEANR', $data)->render();
            $response = array("status" => "OK", "view" => $view);
            //cpcDebug::cpc_debug("postCreate", print_r($response,true));
            return Response::json($response);
        }

        $response = array("status" => "55", "view" => "keine Aktion definiert");
        return Response::json($response);
    }

    public function anyChangehauptbenutzer() {




        $nhb = Input::get("neuerHauptbenutzer");
        if (PPMitarbeiter::where("PPMitarbeiter_Kuerzel", "=", $nhb)->count() <= 0) {

            $response = array('status' => "ERROR", "neuerHauptbenutzer" => $nhb, "message" => "Neuer Hauptbenutzer nicht vorhanden!");
            return Response::json($response);
        }

        cpcDebug::cpc_debug("changeHauptbenutzer: $nhb");




        $hb = PPUserSettings::where("PPUserSettings_Setting", "=", "EAN_Hauptbenutzer")->first();
        cpcDebug::cpc_debug("changeHauptbenutzer ID: $hb->PPUserSettings_Id");

        $hb->PPUserSettings_Value = $nhb;

        $hb->save();

        $response = array('status' => "OK", "neuerHauptbenutzer" => "X" . $nhb, "message" => "Hauptbenutzer wurde geändert!");

        return Response::json($response);
    }

    public function anyIndex($basisid = 0) {
        //





        $bn = $this->basisnummern();


        $hauptbenutzer = "PHE";

        if (PPUserSettings::where("PPUserSettings_Setting", "=", "EAN_Hauptbenutzer")->count() > 0) {
            $hauptbenutzer_row = PPUserSettings::where("PPUserSettings_Setting", "=", "EAN_Hauptbenutzer")->first();
            $hauptbenutzer = $hauptbenutzer_row->PPUserSettings_Value;
        }



        $basisname = "Alle";

        $basisid = 0;

        //echo("<pre>");var_dump($_POST);echo("</pre>");

        if (Input::has('EAN_Nummern_EAN_Basisnummer_Id')) {
            $basisid = Input::get('EAN_Nummern_EAN_Basisnummer_Id');
            $basisname = $bn[$basisid];
        }





        $eans = $this->eannummern($basisid, "Gültig");
        $manage_eans = $this->eannummern($basisid, "Gelöscht,Frei");
        cpcDebug::cpc_debug("anyIndex", "basisid: => $basisid");
        foreach ($manage_eans as $manage) {
            cpcDebug::cpc_debug("anyIndex EAN", " $manage->EAN_Nummern_EAN");
        }




        $data['bn'] = $bn;
        $data['eans'] = $eans;
        $data['manage_eans'] = $manage_eans;
        $data['basisname'] = $basisname;
        $data['user'] = $this->getuser();
        $data['basisnummern'] = $this->getBasisnummern();
        $data['hauptbenutzer'] = $hauptbenutzer;
        $data['aktbenutzer'] = Auth::User()->PPMitarbeiter_Kuerzel;

        $data['content'] = View::make('EAN.uebersicht')->with('data', $data);

        cpcDebug::cpc_debug("anyIndex", "Ende");
        return View::make('main', $data);
    }

    public function postJson() {


        $all = Input::all();

        $view = View::make('EAN.jsonanswer');

        $response = array('status' => "OK", 'params' => $all, "view" => $view->render());

        return Response::json($response);
    }

    public function anyDelete() {



        $all = Input::all();
        $eanid = Input::get("eanid");
        $ian = Input::get("IAN");
        $action = Input::get('action');

        cpcDebug::cpc_debug("postDelete", "EAN_id:" . $eanid);
        $eancount = EAN_Nummern::find($eanid)->count();

        if ($eancount > 0) {
            $ean = EAN_Nummern::find($eanid);

            switch ($ean->EAN_Nummern_Status) {
                case 'Gelöscht':
                    if ($action == "Löschen rückgängig") {
                        $ean->EAN_Nummern_Status = "Gültig";
                    }
                    if ($action == "Freigeben") {
                        $ean->EAN_Nummern_Status = "Frei";
                        $ean->EAN_Nummern_IAN = "";
                    }
                    break;
                case 'Frei':
                    $ean->EAN_Nummern_Status = "Gültig";
                    $ean->EAN_Nummern_IAN = $ian;
                    break;
                case 'Gültig':
                    $ean->EAN_Nummern_Status = "Gelöscht";
                    break;

                default:

                    break;
            }

            $ean->EAN_Nummern_LetzteAenderung = date("Y-m-d H:i:s");
            $ean->EAN_Nummern_MA = Auth::getUser()->id;
            $ean->save();
            $response = array('status' => "OK", 'params' => "TEST");
        } else {
            $response = array('status' => "NOK", 'params' => "Nicht gefunden");
        }

        //var_dump($response); exit;


        return Response::json($response);
    }

    public function anySearch() {


        $search = Input::get("searchstr");
        cpcDebug::cpc_debug("anySerach search: $search");

        $eans = $this->eannummern(0, "Gelöscht,Frei,Gültig", $search);
        $data["searchean"] = $eans;

        $data['search_bn'] = $this->getBasisnummern();

        $data["stati"] = array("Gelöscht" => "Freigeben", "Frei" => "Zuordnen", "Gültig" => "Löschen");
        $data["staticolor"] = array("Gelöscht" => "red", "Frei" => "lightgreen", "Gültig" => "lightblue");

        $view = View::make('EAN.manage', $data)->render();
        $response = array("status" => "OK", "view" => $view);


        return Response::json($response);
    }

    private function getuser() {
        $users = PPMitarbeiter::get();

        $u = array();
        foreach ($users as $user) {
            $u[$user->id] = $user->PPMitarbeiter_Kuerzel;
        }
        return $u;
    }

    public function postCreate() {

        //Hole Liste ungenutzer EANS (Status = FREI)
        //cpcDebug::cpc_debug("postCreate");
        //cpcDebug::cpc_debug(print_r(Input::all(),true));

        $basisid = Input::get('inpBasis');
        $anzahl = Input::get('inpAnzahl');
        $ian = Input::get('inpArtikel');
        $ean_add = Input::get('inpAdd');

        cpcDebug::cpc_debug("EAN_ADD: " . print_r(Input::all(), true));

        $max = 20;
        if (EAN_Basisnummern::where("EAN_Basisnummern_Id", "=", $basisid)->count() > 0) {
            $row_bn = EAN_Basisnummern::where("EAN_Basisnummern_Id", "=", $basisid)->first();
            $max = $row_bn->EAN_Basisnummern_Max;
        }

        $new_ean = array();



        $error = false;
        $data['anz_eans'] = 0;
        $data['anz_max'] = 0;
        $strean = "";

        //Überprüfe ob es schon EAN gibt
        $c = EAN_Nummern::where("EAN_Nummern_IAN", "=", $ian)->
                        where("EAN_Nummern_EAN_Basisnummern_Id", "=", $basisid)->count();
        if ($c > 0 and $ean_add == 0) {
            $error = true;
            $strean = "Es gibt bereits $c EAN-Nummer für diese Basisnummer!";
        }

        if ($anzahl > $max) {

            $error = true;
            $strean = "Maximale Anzahl von $max EAN-Nummern überschritten!";
            //$anzahl = $max;
        }

        if (strlen($ian) <= 0) {

            $error = true;
            $strean = "Keine IAN/Artikelnummer angegeben";
        }


        if (!$error) {



            //cpcDebug::cpc_debug("Basis: ".$basisid." Artikel: ".$ian." Anzahl: ".$anzahl);



            $strean = "";
            for ($i = 0; $i < $anzahl; $i++) {
                $new_ean[$i] = $this->generateEAN($basisid, $ian);
                $strean .= $new_ean[$i] . "\n";
            }

            $data['anz_eans'] = $anzahl;
            $data['anz_max'] = $max;
        }


        $data['new_eans'] = $strean;

        //$data['new_eans'] = "ERROR 55";

        $view = View::make('EAN.jnewEANs', $data)->render();

        //$data['content'] = View::make('EAN.show')->with('data',$data);
        $response = array("status" => "OK", "view" => $view);


        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     * POST /mitarbeiter
     *
     * @return Response
     */
    public function postStore($id) {
        //
        //var_dump(Input::all());echo("<br>$id<br>");exit;
        //http://belo.tex/adressen/show/264
        //return Redirect::to('adressen/show/'.$id);
        return Redirect::to('EAN');
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
    public function edit($id) {
        //
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

}
