<?php
class BISUserController extends BaseController {
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getDashboard')));
    }
    public function home() {
        $data['content'] = View::make('layouts.home');
        return View::make('main', $data)->with('SALs', $this->getSALs());
    }
    private function getUserLanguage() {
        $lang = 'de';
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if (count($langs) > 0) {
                $lang = substr($langs[0], 0, 2);
            }
        }
        return $lang;
    }
    public function postSignin() {
        //if(Input::get('email') != 'fkeppel'){
        //    echo('<h1>Testsystem steht heute nicht zur Verfügung!</h1>');
        //    exit;
        //}
        $msgTooMany = 'Zuviele Anmeldeversuche. Bitte setzen sie sich mit dem Administrator in Verbindung!  ';
        $msgWrong = 'Benutzername oder Passwort sind falsch! Max: 10. Bislang '.cpcHelp::loginAttemptCount(Input::get('email')).' Fehlversuche.';
        if ($this->getUserLanguage() != 'de'){
            App::setLocale('en');
            $msgTooMany = ServiceProvider::tl('EN', $msgTooMany );
            $msgWrong = ServiceProvider::tl('EN', $msgWrong );
        }
        if (cpcHelp::loginAttemptCount(Input::get('email')) > 100){
            return Redirect::to('login')
                            ->with('message', $msgTooMany)
                            ->withInput();
        }
        if (Auth::attempt(array('username' => Input::get('email'), 'password' => Input::get('password')))) {
            //echo('Drinnen');exit;
            cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'Login', '', '' );
            cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'IP: '.$_SERVER['REMOTE_ADDR'], '', '' );
            //cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'GEO IP: '.$this->geoRegion($_SERVER['REMOTE_ADDR']), '', '' );
            cpcHelp::logCPC(Auth::user()->PPMitarbeiter_Kuerzel, 'User Agent: '.$_SERVER['HTTP_USER_AGENT'], '', '' );
            Session::forget('qfcol');
            Session::forget('qSollTermin');
            Session::forget('qintStatus');
            Session::forget('qStatus');
            Session::forget('qAusm');
            Session::forget('qart');
            Session::forget('qMA');
            Session::forget('qIAN');
            return Redirect::to('home');
            $data['content'] = View::make('layouts.home');
            return View::make('main', $data)->with('SALs', $this->getSALs());
        }
        else {
            //echo('Draussen');exit;
            cpcHelp::logCPC(Input::get('email'), 'Login failed', '', '' );
            cpcHelp::logCPC(Input::get('email'), 'FAIL IP: '.$_SERVER['REMOTE_ADDR'], '', '' );
            cpcHelp::logCPC(Input::get('email'), 'FAIL User Agent: '.$_SERVER['HTTP_USER_AGENT'], '', '' );
            cpcHelp::loginAttempt(Input::get('email'));
            return Redirect::to('login')
                            ->with('message', $msgWrong)
                            ->withInput();
        }
    }
    public function getSignin() {
        echo('Permision denied');
        exit;
        if (Auth::attempt(array('username' => Input::get('email'), 'password' => Input::get('password')))) {
            //echo('Drinnen');exit;
            //return Redirect::to('terminDashboard');
            Session::forget('qfcol');
            Session::forget('qSollTermin');
            Session::forget('qintStatus');
            Session::forget('qStatus');
            Session::forget('qAusm');
            Session::forget('qart');
            Session::forget('qMA');
            Session::forget('qIAN');
            return Redirect::to('home');
        }
        else {
            //echo('Draussen');exit;
            return Redirect::to('login')
                            ->with('message', 'Your username/password combination was incorrect')
                            ->withInput();
        }
    }
    public function getLogout() {
        Session::forget('qfcol');
        Session::forget('qSollTermin');
        Session::forget('qintStatus');
        Session::forget('qStatus');
        Session::forget('qAusm');
        Session::forget('qart');
        Session::forget('qMA');
        Session::forget('qIAN');
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
    public function getShowUsersList() {
        $id   = Auth::getUser()->id;
        $user = BisUser::find($id);
        $params['content'] = View::make('users.user')->with('user', $user);
        return View::make('main', $params);
    }
    private function fetchJson(string $url, int $timeout=3): ?array {
        $ctx = stream_context_create(['http' => ['timeout' => $timeout]]);
        $json = @file_get_contents($url, false, $ctx);
        return $json ? json_decode($json, true) : null;
    }
    function geoRegion(string $ip): ?string {
        // 1) ip-api.com (Achtung: HTTP only im Free-Plan)
       // if ($r = $this->fetchJson("http://ip-api.com/json/$ip?fields=status,regionName")) {
       //     if (($r['status'] ?? '') === 'success' && !empty($r['regionName'])) return $r['regionName'];
       // }
        // 2) ipapi.co (HTTPS, Free-Plan 1k/Tag)
        if ($r = $this->fetchJson("https://ipapi.co/$ip/json/")) {
            if (!empty($r['region'])) return $r['region'];
        }
        // 3) ipwhois.io (Free 10k/Monat, non-commercial)
        //if ($r = $this->fetchJson("https://ipwhois.app/json/$ip")) {
        //    if (!empty($r['region'])) return $r['region'];
        //}
        return null;
    }
}
