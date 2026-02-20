<?php

class TextbausteineController extends \BaseController {
    

    private $_TBS = null;


    function __construct($id = 0 ) {
        
        //echo("Also:  $id");
        
        $this->_TBS = $this->_InitProject($id);
        

    }


    public function anyIndex($id = 0) {
        //
        $tb['Text']       = "";
        $tb['Art']        = "";
        $tb['Picture']    = "";
        $tb['PicturePos'] = 0;

        if ($id != 0) {
            //echo("Art oder Id?:$id");exit;
            $tbs              = PPTextbausteine::where('PPTextbausteine_Id', '=', $id)->first();
            $tb['Text']       = $tbs->PPTextbausteine_Text;
            $tb['Art']        = $tbs->PPTextbausteine_Id;
            $tb['Picture']    = $tbs->PPTextbausteine_Picture;
            $tb['PicturePos'] = 2;
            if ($tbs->PPTextbausteine_PicturePos == 1) {
                $tb['PicturePos'] = 1;
            }
        }

        $txtbss = PPTextbausteine::orderBy('PPTextbausteine_Art')->get();

        $a_txtbs_art          = array();
        $a_txtbs_art[0]       = "";
        $tb['PicturePoss']    = array();
        $tb['PicturePoss'][0] = "Bitte wählen...";
        $tb['PicturePoss'][1] = "Vor dem Text";
        $tb['PicturePoss'][2] = "Nach dem Text";

        foreach ($txtbss as $txtbs) {
            $a_txtbs_art[$txtbs->PPTextbausteine_Id] = $txtbs->PPTextbausteine_Art;

            //echo(" $txtbs->PPTextbausteine_Art <br>");
        }

        $tb['Arten'] = $a_txtbs_art;

        //echo("<pre>"); var_dump($tb); exit;

        
        $data['content'] = View::make('textbausteine.form')->with('txtbss', $tb);



        cpcDebug::cpc_debug("anyIndex", "Ende");
        return View::make('main', $data);
    }

    public function anyDelete() {

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


        if (Input::get('submit_button') == "speichern") {
            //echo("<br><pre>");var_dump(Input::all());exit;

            $tbs                             = PPTextbausteine::where('PPTextbausteine_Id', '=', Input::get('PPTextbausteine_Art'))->first();
            $tbs->PPTextbausteine_Text       = Input::get('PPTextbausteine_Text');
            $tbs->PPTextbausteine_Picture    = Input::get('PPTextbausteine_Picture');
            $tbs->PPTextbausteine_PicturePos = 0;
            if (Input::get('PPTextbausteine_PicturePos') == 1) {
                $tbs->PPTextbausteine_PicturePos = 1;
            }

            //echo("<pre>");var_dump($tbs);exit;
            $tbs->save();

            return ($this->anyIndex());
            //echo('speichern');
        }
        if (Input::get('submit_button') == "anzeigen") {
            return ($this->anyIndex(Input::get('PPTextbausteine_Art')));
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


    public function getTBUserDefined($ppid, $tbid)
    {
        $_tb = PPTextbausteineProjekte::where('PPTextbausteineProjekte_PPID', $ppid)->where('PPTextbausteineProjekte_Textbausteine_Id', $tbid)->get()->first();
        if ($_tb){
            return $_tb->PPTextbausteineProjekte_Text;
        }
        return '';

    }

    public function getTBUserDefinedRecord($ppid, $tbid)
    {
        $_tb = PPTextbausteineProjekte::where('PPTextbausteineProjekte_PPID', $ppid)->where('PPTextbausteineProjekte_Textbausteine_Id', $tbid)->get()->first();
        if ($_tb){

            
            return $_tb;
        }
        return null;

    }


    public function isDiffrentFromTB ($id, $tb){
        if (isset($this->_TBS[$id]['text'])){
           
            if (!strcmp($this->_TBS[$id]['text'], $tb)){
                return true;
            }
        }
        return false;
    }

    public function getTBS (){
        return $this->_TBS;
    }

    public  function _InitProject($ppid) {
       
        //dd("Hier $ppid CXXXX");

/*        if (class_exists('PPTextBausteine')){
            echo('Existiert<br>');
        } else {
            echo('Existiert NICHT!!<br>');
        } */
       
        $_tbs =  PPTextbausteine::where('PPTextbausteine_Verwendung', "=", 'PO')->orderBy('PPTextbausteine_SortOrder')->get();
       
        //dd($_tbs);
        $tbs = array();
        foreach ($_tbs as $tb ){
            $tbs[$tb->PPTextbausteine_Id]['id'] = $tb->PPTextbausteine_Id;
            $tbs[$tb->PPTextbausteine_Id]['art'] = $tb->PPTextbausteine_Art;
            $tbs[$tb->PPTextbausteine_Id]['text'] =  $tb->PPTextbausteine_Text;
            $tbs[$tb->PPTextbausteine_Id]['userdefined'] = $this->getTBUserDefined($ppid, $tb->PPTextbausteine_Id);
            
        }

        //$tbsOrg = PPTextbausteineProjekte::where('PPTextbausteineProjekte_PPID' , $id)->orderBy('PPTextbausteineProjekte_Textbausteine_Id')->get();
        
      return $tbs ;
    }

}
