<?php

class WarengruppenController extends \BaseController {



    public function anyIndex($id=0)
    {
        //

        $notice = array ("PPWarengruppeNotice_Id" => 0, "PPWarengruppeNotice_WGRP" => "", "PPWarengruppeNotice_Notice" => "");

        if ($id != 0){
            //echo("Art oder Id?:$id");exit;
            $notice = PPWarengruppeNotice::where('PPWarengruppeNotice_WGRP','=',$id)->first();
            //$notice['WGRP'] = $tbs->PPWarengruppeNotice_WGRP;
            //$notice['Notice'] = $tbs->PPWarengruppeNotice_Notice;
        }

        $notices = PPWarengruppeNotice::all();

        //var_dump($tb); exit;

        $lb_notices  = array();

        foreach ($notices as $note) {
            $lb_notices[$note->PPWarengruppeNotice_WGRP] = $note->PPWarengruppeNotice_WGRP;
            //echo(" $txtbs->PPTextbausteine_Art <br>");
        }

        $notes['notice'] = $notice;
        $notes['lb'] = $lb_notices;

		//echo("<pre>");var_dump($notes);exit;


        $data['content'] = View::make('stammdaten.formWGRPNotice')->with('notes',$notes);

        cpcDebug::cpc_debug("anyIndex", "Ende");
        return View::make('main', $data);

    }





    public function anyDelete (){





    }







    /**
     * Store a newly created resource in storage.
     * POST /mitarbeiter
     *
     * @return Response
     */
    public function postStore($id)
    {
        //
        var_dump(Input::all());echo("<br>$id<br>");exit;

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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /adressen/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /adressen
     *
     * @return Response
     */
    public function store()
    {
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
    public function anyShow()
    {

    }

    public function anyDeleteX($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     * GET /adressen/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function anyEdit()
    {


		//echo("TEST");exit;

        if (Input::get('submit_button') == "speichern"){


            $notice = PPWarengruppeNotice::where('PPWarengruppeNotice_WGRP','=',Input::get('PPWarengruppeNotice_WGRP'))->first();
            $notice->PPWarengruppeNotice_Notice = Input::get('PPWarengruppeNotice_Notice');
            $notice->save();

            return ($this->anyIndex());
            //echo('speichern');
        }
        if (Input::get('submit_button') == "anzeigen"){
            return ($this->anyIndex(Input::get('PPWarengruppeNotice_WGRP')));
            //echo("ID:".Input::get('PPTextbausteine_Art'));

        }

        if (Input::get('submit_button') == "neu"){

			$pnotice = new PPWarengruppeNotice;

			//echo('<pre>');var_dump($pnotice);exit;
			$pnotice->PPWarengruppeNotice_WGRP = Input::get('PPWarengruppeNotice_WGRP_Neu');
			$pnotice->PPWarengruppeNotice_Notice = "Bitte Anmerkung eingeben!";
			$pnotice->save();

            $notice = PPWarengruppeNotice::where('PPWarengruppeNotice_WGRP','=',Input::get('PPWarengruppeNotice_WGRP_Neu'))->first();


            return ($this->anyIndex($notice->PPWarengruppeNotice_WGRP));
            //echo("ID:".Input::get('PPTextbausteine_Art'));

        }


    }

    /**
     * Update the specified resource in storage.
     * PUT /adressen/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /adressen/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}