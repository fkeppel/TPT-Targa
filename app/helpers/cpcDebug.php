<?php
class cpcDebug {
    static function cpc_debug( $str, $ext = "Commen") {
        if (!isset(Auth::user()->PPMitarbeiter_Kuerzel) or Auth::user()->PPMitarbeiter_Kuerzel != 'FKE') {
            return;
        }
        $important = substr($ext,0,1);
        if ($important != '-'){
            return;
        } else {
            $ext = substr($ext,1);
        }
        if (is_null($str) or!isset($str)) {
            $str = "No Value";
        }
        $strsize = strlen(serialize($str));
        if ($strsize > 1024 * 1024) {
            $str = substr($str, 0, 1024) . "... (truncated)";
        }
        $jetzt = date("Ymd");
        $path  = storage_path() . "/logs/" . date("Y_m_d") . "/$ext";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        //$jetzt = "heute";
        $datei = fopen($path . "/debug_" . $jetzt . ".txt", "a+");
        $jetzt = date("Y-m-d H:i:s");
        fwrite($datei, $jetzt . " [" . Auth::user()->PPMitarbeiter_Kuerzel . "]" . "#  ");
        fwrite($datei, print_r($str, true) . "\n");
        fclose($datei);
    }
    static function cpc_debugFile($str, $ext = "Commen") {
        $path  = storage_path() . "/logs/" . date("Y_m_d") . "/$ext";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $datei = fopen($path . "/debugFile.txt", "a+");
        fwrite($datei, print_r($str, true) . "\n");
        fclose($datei);
    }
    static function dd($var, $exit = false, $desc = "Ausgabe dd:") {
        return;
        echo("<br><b> $desc </b>:<br>");
        echo("<pre>");
        print_r($var);
        echo("</pre>");
        if ($exit) {
            exit;
        }
    }
    static function pe($obj, $exit = false) {
        //return;
        if (Auth::user()->PPMitarbeiter_Kuerzel != 'FKE'){
            return;
        }
        echo(date("Y-m-d H:i:s") . "<br>");
        echo("<pre>");
        print_r($obj);
        echo("</pre>");
        if ($exit){
            exit;
        }
    }
    static function p($obj) {
        return;
        echo(date("Y-m-d H:i:s") . "<br>");
        echo("<pre>");
        print_r($obj);
        echo("</pre>");
    }
}
class cpcHelp {
    static function array_orderby() {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp       = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n]  = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
    static public function logCPC($user, $typ, $old, $new){
        $log = new PPLog();
        $log->PPLog_User = $user;
        $log->PPLog_Typ = $typ;
        $log->PPLog_Date = date('Y.m.d H:i:s');
        $log->PPLog_Old = $old;
        $log->PPLog_New = $new;
        $log->save();
    }
    static function Dec2MySql($value) {
        if (is_null($value) or!isset($value) or $value == "0")
            $value = 0.0;
        //echo("      ATTR: ". $attr." VAL: " . $value."<br>");
        if (isset($defval[$attr])) {
            $value = str_replace('.', 'X', $value);
            $value = str_replace(',', '.', $value);
            $value = str_replace('X', '', $value);
        }
        return $value;
    }
    static public function Date2MySql($termin) {
        if (strlen($termin) == 10) {
            $datum   = explode('.', $termin);
            $retdate = $datum[2] . '-' . $datum[1] . '-' . $datum[0];
            //cpcDebug::dd($retdate,true);
            return $retdate;
        }
        return '1900-01-01';
    }
    static public function cpcStringDateDiff($d1, $d2 = null) {
        if (is_null($d2)) {
            $d2 = date('Y-m-d');
        }
        try {
            $dtDate1      = new DateTime($d1);
            $dtDate2      = new DateTime($d2);
            $diff         = date_diff($dtDate2, $dtDate1);
            $ret['valid'] = true;
            $ret['diff']  = intval($diff->format('%r%a'));
        }
        catch (Exception $ex) {
            $ret['valid'] = false;
        }
        return $ret;
    }
    static public function MySqlDate2String($termin) {
        $sdate = '0000-00-00';
        try {
            $date  = new DateTime($termin);
            $sdate = $date->format('d.m.Y');
        }
        catch (Exception $ex) {
            $sdate = '0000-00-00';
        }
        return $sdate;
    }
    static public function loginAttempt($user) {
        $la = login_attempt::where('login_attempt_user', $user)->get()->first();
        if (is_null($la)) {
            $la                   = new login_attempt();
            $la->login_attempt_id = null;
            $la->login_attempt_user = $user;
            $la->login_attempt_count = 1;
            $la->save();
            return 1;
        } else {
                $la->login_attempt_count = $la->login_attempt_count + 1;
                $la->save();
        }
    }
     public static  function loginAttemptCount($user) {
        $la = login_attempt::where('login_attempt_user', $user)->get()->first();
        if ($la) {
            return $la->login_attempt_count;
        } 
        return 0;
    }
}