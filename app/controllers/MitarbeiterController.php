<?php
class MitarbeiterController extends BaseController {
    /**
     * Display a listing of the resource.
     * GET /mitarbeiter
     *
     * @return Response
     */
    public function getIndex() {
        //
        $mas = PPMitarbeiter::where('PPMitarbeiter_Status', '=', 1)->orderBy('PPMitarbeiter_Name')->get();
        if (!$mas) {
            $data['content'] = 'Empty';
        }
        else {
            $data['content'] = View::make('mitarbeiter.list')->with('mas', $mas);
        }
        return View::make('main', $data);
    }
    /**
     * Show the form for creating a new resource.
     * GET /mitarbeiter/create
     *
     * @return Response
     */
    public function postCreate() {
        //
        $data['content'] = View::make('mitarbeiter.form')->with('ma', array('PPMitarbeiter_Id' => "Neu", 'PPMitarbeiter_Gruppe' => '', 'isMaster' => 0))->with('login_attempts', 0);
        return View::make('main', $data);
    }
    public function frmChangePassword() {
        //
        $message         = "";
        $data['content'] = View::make('mitarbeiter.changePassword')->with('message', $message);
        return View::make('main', $data);
    }
    private function MitarbeiterKuerzelExists($kuerzel){
        return PPMitarbeiter::where('PPMitarbeiter_Kuerzel', '=', $kuerzel)->exists() ;
    }
    private function deleteMitarbeiter ($delid)
    {
        //** ersetze $delid  durch Admin TM/TC */
        $PMid = 0;
        $admin_PM = PPMitarbeiter::where('PPMitarbeiter_Gruppe', 'admin')->where('PPMitarbeiter_Taetigkeit','like', '%PM%')->get()->first();
        if ($admin_PM){
            $PMid = $admin_PM->PPMitarbeiter_Id;
        }
        $TCid = 0;
        $admin_TC = PPMitarbeiter::where('PPMitarbeiter_Gruppe', 'admin')->where('PPMitarbeiter_Taetigkeit','like', '%TC%')->get()->first();
        if ($admin_TC){
            $TCid = $admin_TC->PPMitarbeiter_Id;
        }
        $terms = DB::table('v_offeneTermineMitMa')->where('PPTermine_MAZustaendigkeit', $delid)->get();
        if ($terms){
            foreach ($terms as $term){
                $changeTermin = PPTermine::where('PPTermine_Id', $term->PPTermine_Id)->get()->first();
                if ($term->PPBoardSpalteData_Kind == 'TC'){
                    $changeTermin->PPTermine_MAZustaendigkeit = $TCid;
                } else {
                    $changeTermin->PPTermine_MAZustaendigkeit = $PMid;
                }
                $changeTermin->save();
            }
        } 
         //Ändere bestehenden Benutzer
         $delma = PPMitarbeiter::where('PPMitarbeiter_Id', $delid)->get()->first();
         if ($delma){
             for($i=1; $i<=100;$i++){
                 $kuerzel = '@' . $delma->PPMitarbeiter_Kuerzel.'_'.$i;
                 if (!$this->MitarbeiterKuerzelExists($kuerzel)){
                     break;
                 } 
             }
             $delma->PPMitarbeiter_Kuerzel = $kuerzel;
             $delma->username = $kuerzel;
             $delma->PPMitarbeiter_Status = 0;
             $delma->password = 'GELÖSCHT';
             $delma->save();
         }
        //return $this->getIndex();
    }
    private function generatePassword ($length){
        $Sonderzeichen = array();
        for($i=33;$i<=47;$i++){
            if ($i != 34 and $i != 39){
                $Sonderzeichen[] = chr($i);
            }
        } 
        $GrossBuchstaben = array();
        for($i=65;$i<=90;$i++){
            $GrossBuchstaben[] = chr($i);
        } 
        $KleinBuchstaben = array();
        for($i=97;$i<=122;$i++){
            $KleinBuchstaben[] = chr($i);
        } 
        $Ziffern = array();
        for($i=48;$i<=57;$i++){
            $Ziffern[] = chr($i);
        } 
        $symbols = array($Sonderzeichen, $GrossBuchstaben, $KleinBuchstaben, $Ziffern);
        $pwgen =  $GrossBuchstaben[rand(0,count($GrossBuchstaben) -1 )];
        $pwgen .= $KleinBuchstaben[rand(0,count($KleinBuchstaben) -1 )];
        $pwgen .= $GrossBuchstaben[rand(0,count($GrossBuchstaben) -1 )];
        $pwgen .= $KleinBuchstaben[rand(0,count($KleinBuchstaben) -1 )];
        for ($j=0; $j < $length-4 ; $j++) { 
            $ran1 = rand(0, 3);
            $ran2 = rand(0, count($symbols[$ran1])-1);
            $pwgen .= $symbols[$ran1][$ran2];
        }
        return $pwgen;
    }
    public function bulkPwChange (){
        $mas  = PPMitarbeiter::where('PPMitarbeiter_Id', '>', 1225)->whereNull('id')->orderBy('PPMitarbeiter_Name')->get();
        echo("<table>");
        foreach ($mas as $ma) {
            $pw = $this->generatePassword(8);
            $hashpw = Hash::make($pw);
            $ma->password = $hashpw;
            $ma->id = $ma->PPMitarbeiter_Id ;
            $ma->Bemerkung = "XXXXXXXX  ".$hashpw ;
            $ma->save();
            echo("<tr>");
            echo("<td>$ma->PPMitarbeiter_Name</td>");
            echo("<td>$ma->PPMitarbeiter_Vorname</td>");
            echo("<td>$ma->username</td>");
            echo("<td>$pw</td>");
            echo("</tr>");
           // $message = " ID: $ma->PPMitarbeiter_Id Id:  $ma->id  User: ".$ma->username."  Passwort: ".$pw."<br>";
            //echo($message);
        }
        echo("</table>");
        exit;
    }
    private function changePassword($pwalt, $pwneu) {
        $uid = Auth::User()->PPMitarbeiter_Id;
        $ma  = PPMitarbeiter::where('PPMitarbeiter_Id', '=', $uid)->get()->first();
        $ma2 = DB::table('users')->where('PPMitarbeiter_Id', '=', $uid)->first();
        //var_dump($ma2->password);
        //exit;
        if ($ma) {
            if (Hash::check($pwalt, $ma->password)) {
                $hashpw       = Hash::make($pwneu);
                $ma->password = $hashpw;
                $ma->save();
                $message      = "Passwort geändert!";
                if ($ma2) {
                    DB::table('users')->where('PPMitarbeiter_Id', '=', $uid)->update([
                        'password' => $hashpw]);
                    $message .= "";
                }
                return $message;
            }
            return "Altes Password stimmt nicht!";
        }
        return $ma->PPMitarbeiter_Name . " nicht gefunden!";
    }
    public function postChangePassword() {
        //
        //$this->bulkPwChange();
        $pw   = Input::get('pwalt');
        $pwn  = Input::get('pwneu');
        $pwn2 = Input::get('pwneu2');
        $message = "";
        if ($pw == '') {
            $message = "Altes passwort eingeben!";
        }
        if ($pwn == '') {
            $message = "kein neues Passwort eingeben!";
        }
        if ($pwn2 != $pwn) {
            $message = "Passwörter stimmen nicht überein!";
        }
        if ($message == "") {
            $message = $this->changePassword($pw, $pwn);
        }
        $data['content'] = View::make('mitarbeiter.changePassword')->with('message', $message);
        return View::make('main', $data);
    }
    /**
     * Store a newly created resource in storage.
     * POST /mitarbeiter
     *
     * @return Response
     */
    public function postStore($id) {
        //
        //dd(Input::all());exit;
        $submit = Input::get('submit');
        $delid = Input::get('delid');
        if ($submit == 'löschen'){
            $this->deleteMitarbeiter($delid);
            return Redirect::to('mitarbeiter');    
        } 
        if ($submit == 'unlock'){
            $this->unlockUser($delid);
            return $this->postShow($delid);   
        }
        if ($id != "Neu") {
            $ma = PPMitarbeiter::find($id);
        }
        else {
            $msg = ""; 
            $ma = PPMitarbeiter::where( 'username', Input::get('username'))->get()->first();
            if ($ma){
                $msg .= ' Kürzel ';
            }
            $ma1 = PPMitarbeiter::Where('PPMitarbeiter_Kuerzel' ,Input::get('PPMitarbeiter_Kuerzel'))->get()->first();
            if ($ma1){
                $msg .= ' Anmeldename ';
            }
            if ($msg != ''){
                echo("<div style='margin:50px;width:300px;height:100px;padding:30px;border:3px solid red;text-align:center;font-weight:bold; font-family:arial;'>$msg existiert bereits!");
                echo("<br><button style='margin:25px;' onclick='javascript:history.back()'>Zurück zur Eingabe</button></div>");
                exit;
                //return Redirect::to('mitarbeiter');
            }
            //Benutzer vorhanden
            $ma = new PPMitarbeiter();
            $ma->PPMitarbeiter_Role = 'PUB';
            $ma->save();
        }
        $ma->PPMitarbeiter_Name    = Input::get('PPMitarbeiter_Name');
        $ma->PPMitarbeiter_Vorname = Input::get('PPMitarbeiter_Vorname');
        $ma->PPMitarbeiter_Kuerzel = Input::get('PPMitarbeiter_Kuerzel');
        $ma->PPMitarbeiter_email = Input::get('PPMitarbeiter_email');
        $ma->PPMitarbeiter_Gruppe  = Input::get('PPMitarbeiter_Gruppe');
        $ma->PPMitarbeiter_Language  = Input::get('PPMitarbeiter_Language');
        $ma->PPMitarbeiter_Role  = Input::get('PPMitarbeiter_Role');
        $taetigkeit = Input::get('PPMitarbeiter_Taetigkeit');
        $ma->PPMitarbeiter_Taetigkeit  = $taetigkeit;
        $isMaster = 0;
        if ($taetigkeit == 'PM' or $taetigkeit = 'TC'){
            $isMaster  = Input::get('isMaster');
        }
        $ma->ismaster = $isMaster;
        $ma->username              = Input::get('username');
        $passwd = trim(Input::get('1password'));
        if (strlen($passwd) > 3) {
            $ma->password = Hash::make($passwd);
        }
        $ma->id = $ma->PPMitarbeiter_Id;
        $ma->save();
        return Redirect::to('mitarbeiter');
    }
    /**
     * Display the specified resource.
     * GET /mitarbeiter/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function postShow($id) {
        //
        $ma = PPMitarbeiter::find($id);
        if (!$ma)
            $data['content'] = 'Empty';
        else
            $data['content'] = View::make('mitarbeiter.form')->with('ma', $ma)->with('login_attempts', cpcHelp::loginAttemptCount($ma->username));
        return View::make('main', $data);
    }
    /**
     * Show the form for editing the specified resource.
     * GET /mitarbeiter/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }
    /**
     * Update the specified resource in storage.
     * PUT /mitarbeiter/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }
    /**
     * Remove the specified resource from storage.
     * DELETE /mitarbeiter/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
    public function setLanguage (){
        $id = Input::get('id');
        $lang = Input::get('lang');
        $ma = PPMitarbeiter::where('PPMitarbeiter_Id', $id)->get()->first();
        if ($ma){
            $ma->PPMitarbeiter_Language = $lang;
            $ma->save();
        }       
        $ret = array('status' => 'OK', 'Lang' => $lang ); 
        return json_encode($ret);
    }
    private function unlockUser($user) {
        $ma = PPMitarbeiter::find($user);
        if ($ma){
            echo('username: '.$ma->username);
            $la = login_attempt::where('login_attempt_user', $ma->username)->get()->first();
            if ($la) {
                echo( '    Fails: '.$la->login_attempt_count);
                $la->login_attempt_count = 0;
                $la->save();
            } 
        }
    }
}
