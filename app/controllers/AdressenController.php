<?php

class AdressenController extends \BaseController {

    private function getAbgangshaefen() {
        $haefen = DB::table('PPAbgangshafen')->get();
        //var_dump($haefen); exit;
        foreach ($haefen as $hafen) {
            $ret[$hafen->PPAbgangshafen_Id] = $hafen->PPAbgangshafen_Hafen;
        }

        ksort($ret, SORT_ASC);
        return $ret;
    }


    public function suche()
    {

        $search = Input::get('searchAddress');
        $art = Input::get('art');       
        return $this->getListe($art, $search);
    }

    public function getIndex() {
        //


        

        $adr = PPAdressen::join('PPAdressarten', 'Art', '=', 'PPAdressarten_Id')
                ->orderBy('Matchcode')
                ->get();

        if (!$adr)
            $data['content'] = 'Empty';
        else {

            $data['content'] = View::make('adressen.list')->with('adressen', $adr);
        }
        return View::make('main', $data);
    }



    public function getListe($art = 3, $suche="%") {
        //

      

        $view = 'adressen.adresse_suche';
       
            if (Auth::User()->username == 'fkeppel'){
                $view = 'adressen.adresse_suche';
            };
       

        
        
        if ($art == 0) {
            $adr = PPAdressen::join('PPAdressarten', 'Art', '=', 'PPAdressarten_Id')
                ->where(function($query) use ($suche) {
                $query->where('Matchcode', 'like', "%$suche%")
                ->orWhere('Firma1', 'like', "%$suche%")
                ->orWhere('Adresse1', 'like', "%$suche%")
                ->orWhere('PPAdressen_LidlId', 'like', "%$suche%")
                ->orWhere('Ort', 'like', "%$suche%")
                ->orWhere('Plz', 'like', "%$suche%")
                ->orWhere('Land', 'like', "%$suche%");
            })
            ->orderBy('Matchcode')
            ->get();
        } else {

           
            $adr = PPAdressen::join('PPAdressarten', 'Art', '=', 'PPAdressarten_Id')
                    ->where('Art', "=", $art)
                    ->where(function($query) use ($suche) {
                        $query->where('Matchcode', 'like', "%$suche%")
                        ->orWhere('Firma1', 'like', "%$suche%")
                        ->orWhere('Adresse1', 'like', "%$suche%")
                        ->orWhere('PPAdressen_LidlId', 'like', "%$suche%")
                        ->orWhere('Plz', 'like', "%$suche%")
                        ->orWhere('Ort', 'like', "%$suche%")
                        ->orWhere('Land', 'like', "%$suche%");
                    })
                    ->orderBy('Matchcode')
                    ->get();
        }


        if (!$adr)
            $data['content'] = 'Empty';
        else {
            $params['adr'] = $adr;
            $params['art'] = $art;
            
            $data['content'] = View::make($view)->with('params', $params);
        }
        return View::make('main', $data);
    }

    public function postCreate() {
        //
        //$data['content'] = View::make('adressen.form') -> with('adresse',array('Id'=>"Neu"));
        //return View::make('main', $data);


        $adr = new PPAdressen;
        $adr->Matchcode = "NEU";
        $adr->save();

        return Redirect::to('/adressen/show/' . $adr->Id);


        /* var_dump($adr);exit;
          $adresse['adr']=$adr;
          $adressarten = PPAdressarten::all();
          foreach($adressarten as $adressart){
          $arten[$adressart->PPAdressarten_Id]=$adressart->PPAdressarten_Art;
          }

          $adresse['arten']=$arten;

          $data['content'] = View::make('adressen.form') -> with('adresse',$adresse);
         */
    }

    /**
     * Store a newly created resource in storage.
     * POST /mitarbeiter
     *
     * @return Response
     */
    public function postStore($id) {
        //
        //echo("<pre>"); var_dump(Input::all());echo("<br>$id<br>");exit;

        if ($id != "Neu") {
            $adr = PPAdressen::find($id);
        } else {
            $adr = new PPAdressen();
        }
        //var_dump($adr);echo("<br>$id<br>");exit;

        $adr->Art = Input::get('Art');
        $adr->Firma1 = Input::get('Firma1');
        $adr->Firma2 = Input::get('Firma2');
        $adr->Ansprechpartner = Input::get('Ansprechpartner');
        $adr->Adresse1 = Input::get('Adresse1');
        $adr->Adresse2 = Input::get('Adresse2');
        $adr->Matchcode = Input::get('Matchcode');
        $adr->PLZ = Input::get('PLZ');
        $adr->Ort = Input::get('Ort');
        $adr->Postfach = Input::get('Postfach');
        $adr->Land = Input::get('Land');
        $adr->Telefon = Input::get('Telefon');
        $adr->Fax = Input::get('Fax');
        $adr->email = Input::get('email');
        $adr->web = Input::get('web');
        $adr->PPAdressen_ZertStep = Input::get('PPAdressen_ZertStep');
        if (Input::get('PPAdressen_ZertStep') == 1) {
            $adrMySql = cpcHelp::Date2MySql(Input::get('PPAdressen_ZertStepValid'));
            $adr->PPAdressen_ZertStepValid = $adrMySql;
        } else {
            $adr->PPAdressen_ZertStepValid = null;
        }
        $adr->PPAdressen_ZertBSCI = Input::get('PPAdressen_ZertBSCI');
        if (Input::get('PPAdressen_ZertBSCI') == 1) {
            $adrMySql = cpcHelp::Date2MySql(Input::get('PPAdressen_ZertBSCIValid'));
            $adr->PPAdressen_ZertBSCIValid = $adrMySql;
        } else {
            $adr->PPAdressen_ZertBSCIValid = null;
        }
        $adr->web = Input::get('web');
        $lidlid = Input::get('PPAdressen_LidlId');
        if (!isset($lidlid) || strlen(trim($lidlid)) < 1 || !is_numeric($lidlid))
            $lidlid = 0;

        $adr->PPAdressen_LidlId = $lidlid;
        $adr->PPAdressen_Agent = Input::get('PPAdressen_Agent');
        $adr->PPAdressen_Mobil = Input::get('PPAdressen_Mobil');
        $adr->PPAdressen_Abgangshafen = Input::get('PPAdressen_Abgangshafen');
        $adr->PPAdressen_DefaultWsym = Input::get('PPAdressen_DefaultWsym');
        $adr->PPAdressen_DefaultProvision = Input::get('PPAdressen_DefaultProvision');
        $adr->PPAdressen_AgentId = Input::get('PPAdressen_AgentId');
        $LTMinus = 9;
        if (strlen(Input::get('PPAdressen_LT')) > 0 and is_numeric(Input::get('PPAdressen_LT')))
            $LTMinus = Input::get('PPAdressen_LT');
        $adr->PPAdressen_LT = $LTMinus;

        $adr->save();
        //http://belo.tex/adressen/show/264
        //return Redirect::to('adressen/show/'.$id);
        return $this->getListe($adr->Art);
        //return Redirect::to('adressen');
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
    }


    public function getAgents() {


        $ffs = PPAdressen::where("Art", "=", 8)->get();
        //cpcDebug::dd($ffs,true);
        $aff = array();

        foreach ($ffs as $ff) {
            $aff[$ff->Id] = $ff->Matchcode;
        }

        //cpcDebug::dd($aff,true);
        return $aff;
    }

    /**
     * Display the specified resource.
     * GET /adressen/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function anyShow($id) {
        //
      
        $view = 'adressen.adresse';
       
            if (Auth::User()->username == 'fkeppel'){
                $view = 'adressen.adresse';
            };
       

        $adr = PPAdressen::find($id);
        $adresse['adr'] = $adr;
        $adressarten = PPAdressarten::all();
        foreach ($adressarten as $adressart) {
            $arten[$adressart->PPAdressarten_Id] = $adressart->PPAdressarten_Art;
        }

        $adresse['arten'] = $arten;
        $adresse['haefen'] = $this->getAbgangshaefen();
        $adresse['agents'] = $this->getAgents();

        
        $data['content'] = View::make($view)->with('adresse', $adresse);

        return View::make('main', $data);
    }

    public function anyDelete($id) {
        //
        //var_dump($id); exit;
        $adr = PPAdressen::find($id);
        $adr->delete();

        return Redirect::to('adressen');
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
