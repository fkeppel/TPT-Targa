<?php
class ServiceProvider extends \BaseController {
    public static function tl ($lang, $text){
        if ($lang == 'DE'){
            //cpcDebug::cpc_debug("Translate no Translation: $text",'@T4711');
            return $text;
        }
        cpcDebug::cpc_debug("Translate: $lang / $text",'@T4712');
        $text = trim($text);
        $att = 'PPTranslateGUI_Text'.$lang;
        $ret = '';
        $t = PPTranslateGUI::where('PPTranslateGUI_TextDE','like',$text)->get()->first();
        if(! $t ){
            //cpcDebug::cpc_debug('Insert: '.$text,'@T18');
            $ret = self::newTranslation($lang, $text);
            cpcDebug::cpc_debug("Translate New Translation: $text $ret",'@T4712');
        } else {
            $ret = $t->{$att};
            if ($t->{$att} == null or strlen(trim($t->{$att})) == 0){
                $ret = self::newTranslation($lang, $text);
            }
            //cpcDebug::cpc_debug("Translate Translation: $ret",'@T4711');
        }
        return $ret;
    }
    public static function tlFromTo ( $fromLang, $toLang, $text){
        $qryAtt = 'PPTranslateGUI_Text'.$fromLang;
        $retAtt = 'PPTranslateGUI_Text'.$toLang;
        $t = PPTranslateGUI::where($qryAtt,'like',$text)->get()->first();
        if(! $t ){
            return self::_translateLabel($text, $toLang);
        } 
        return $t->{$retAtt};
    }
    private function  newTranslation($lang, $text){
        $att = 'PPTranslateGUI_Text'.$lang;
        $t = new PPTranslateGUI();
        $txt = self::_replace0d($text);
        $t->PPTranslateGUI_TextDE = $txt;
        $t->save();
        if (is_null($t->{$att}) or strlen(trim($t->{$att})) == 0){
            $textLang = self::_translateLabel($text, $lang);
            $t->{$att} = $textLang;
            //$t->{$att} = "$lang:$text";
            $t->save();
            //cpcDebug::cpc_debug('Translated: '.$textLang,'@T18');
        }
        return $t->{$att};
    }
    private  function _replace0d($text){
        $ret = str_replace("\r\n", "\n", $text);
        return $ret;
    }
    public static function translateDirect ($text){
        return self::_translateLabel($text);
    }
    private function _translateLabel($text = null, $lang = 'EN') {
        cpcDebug::cpc_debug("Translate $text", '-Translate');
        if ($text === null || trim($text) === '') {
            $text = '-';
        }
        $api_Key  = '10ee3599-028f-961f-ca7e-8c941bfaac5a';
        $deeplURL = 'https://api.deepl.com/v2/translate';
        $payload = http_build_query([
            // wenn du lieber Header-Auth nutzt, lässt du 'auth_key' weg – Header unten bleibt.
            'text'        => $text,
            'target_lang' => $lang,
        ]);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $deeplURL,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload, // <— URL-encoded String, kein Array!
            CURLOPT_HTTPHEADER     => [
                'Authorization: DeepL-Auth-Key ' . $api_Key,
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_VERBOSE        => true,
            CURLOPT_PROXY          => 'http://10.254.0.1',
            CURLOPT_PROXYPORT      => 8080,
            CURLOPT_HTTPPROXYTUNNEL=> true, // HTTPS durch HTTP-Proxy sauber tunneln
        ]);
        $translation = curl_exec($ch);
        if ($translation === false) {
            throw new \RuntimeException('cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        $data = json_decode($translation, true);
        return $data['translations'][0]['text'] ?? "Not Translated: " . $text;
    }
    private  function _translateLabel_Fehler($text = null, $lang = 'EN'){
        if ($text == null or (trim($text) == '')) {
            $text = '-';
        }
        $api_Key = '10ee3599-028f-961f-ca7e-8c941bfaac5a';
        $deeplURL = "https://api.deepl.com/v2/translate";
        //$ptext = mb_convert_encoding($text, 'UTF8');
        $ptext = $text;
        $vars = (array("text" => $ptext, "target_lang" => $lang));
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
        // grab URL and pass it to the browser
        $translation = curl_exec($ch);
        $info = curl_getinfo($ch);
        cpcDebug::cpc_debug($info, '@translateDeepl');
        cpcDebug::cpc_debug($translation, '@translateDeepl');
        curl_close($ch);
        $trans = json_decode($translation, true);
        try {
            $ret = $trans['translations'][0]['text'];
        } catch (Exception $e) {
            //echo("Fehler beim übersetzen: $ptext <br>");
            //print_r($vars);
            $ret = "Not Translated [Qutoa?]:" . $text;
            //exit;
        }
        return $ret;
    }
    private function markHTMLDiff($s){
        //cpcDebug::cpc_debug($s,'@HTMLDIFF');
        $replaceMinus = '<span style="background-color:red;color:white;"> Alt:';
        $replacePlus = '<span style="background-color:green;color:white;"> Neu:';
        $t = str_replace('«-',$replaceMinus, $s);
        $v = str_replace('«+',$replacePlus, $t);
        $x = str_replace('«1:+',$replacePlus, $v);
        $u = str_replace('»', '</span>', $x);
        return $u; 
    }
    private function markHTMLDiffJson($s){
        cpcDebug::cpc_debug("Start",'@markdiffJson_0310_1');
        $replaceMinus = "<span style='background-color:red;'>Alt";
        $replacePlus = "<span style='background-color:green;'>Neu";
        $a1 = str_replace(',"»','»,"', $s);
        $a2 = str_replace(',»','»,', $a1);
        $a3 = str_replace('Alt«-','«-Alt', $a2);
        $a4 = str_replace('Neu«-','«-Neu', $a3);
        cpcDebug::cpc_debug('##############   Test #'.date('H:i:s'),'@markdiffJson_0310_1b');
        cpcDebug::cpc_debug($s,'@markdiffJson_0310_1b');
        cpcDebug::cpc_debug($a4,'@markdiffJson_0310_1b  ');
        $t = str_replace('«-',$replaceMinus, $a1);
        $v = str_replace('«+',$replacePlus, $t);
        $x = str_replace('«1:+',$replacePlus, $v);
        $u = str_replace('»', '</span>', $x);
        $k = str_replace($replacePlus.'&quot;','&quot;'.$replacePlus, $u);
        $l = str_replace($replaceMinus.'&quot;','&quot;'.$replaceMinus, $k);
        $y = str_replace(',&quot;</span>','</span>,&quot;', $l);
        $z = str_replace('&quote;Neu','Neu', $y);
        $a = str_replace('&quot;</span>','</span>', $y);
        cpcDebug::cpc_debug($y,'@markdiffJson_0310_1');
        cpcDebug::cpc_debug("Ende",'@markdiffJson_0310_1'); // ,&quot;</span> =>  </span>&quot;,
        return $a; 
    }
    public static function diff ($b, $a){
        $diff=new NewDiffController();
        $diff->setMarkers("«","»");
        $ax=htmlspecialchars($a, ENT_QUOTES, 'UTF-8');
        $bx=htmlspecialchars($b, ENT_QUOTES, 'UTF-8');
        $diffTx = $diff->getDiff($ax, $bx, false, false); // Text output
        cpcDebug::cpc_debug($diffTx,'@HTMLDIFF');
        //return self::markHTMLDiff($diffTx);
        return self::markHTMLDiff($diffTx);
    }
    public static function diffString ($b, $a){
        $diff=new NewDiffController();
        $diff->setMarkers("«","»");
        /*$ax=htmlspecialchars($a, ENT_QUOTES, 'UTF-8');
        $bx=htmlspecialchars($b, ENT_QUOTES, 'UTF-8');*/
        if (is_null($a) or is_null($b)){
            return '';
        }
        if (is_array($a) or is_array($b)){
            return '';
        }
        $diffTx = $diff->getDiff($a, $b, false, false); 
        return self::markHTMLDiff($diffTx);
    }
    public static function diffJson ($b, $a){
        $ret = self::diffArray($a, $b);
        cpcDebug::cpc_debug('DiffArray','@diffJson_0310C');
        cpcDebug::cpc_debug($ret,'@diffJson_0310C');
        echo('Fertig!');
        exit;
        $diff=new NewDiffController();
        $diff->setMarkers("«","»");
        //$ax=htmlspecialchars($a, ENT_QUOTES, 'UTF-8');
        //$bx=htmlspecialchars($b, ENT_QUOTES, 'UTF-8');
        $ax=$a;
        $bx=$b;
        $diffTx = $diff->getDiff($ax, $bx, false, false); // Text output
        cpcDebug::cpc_debug('a','@diffJson_0310B');
        cpcDebug::cpc_debug($a,'@diffJson_0310B');
        cpcDebug::cpc_debug('b','@diffJson_0310B');
        cpcDebug::cpc_debug($b,'@diffJson_0310B');
        cpcDebug::cpc_debug($diffTx,'@diffJson_0310B');
        $str = self::rearange($diffTx);
        return self::markHTMLDiffJson($diffTx);
    }
    public static function XdiffArray ($a, $b){
        cpcDebug::cpc_debug('diffArray','@diffArray_0310A');
        cpcDebug::cpc_debug($a,'@diffArray_0310A');
        cpcDebug::cpc_debug($b,'@diffArray_0310A');
        $ret = array();
        $ret[] = array('old' => '', 'new' => '', 'diff' => '-1');
        try {
            foreach ($a as $key => $val){
                if (!is_array($val)){
                    $ret[][$key]['old'] = $val;
                    if (isset($b[$key])){
                        $ret[][$key]['new'] = $b[$key];
                        if ($b[$key] == $a[$key]){
                            $ret[][$key]['diff'] = 0; 
                        } else {
                            $ret[][$key]['diff'] = 1; 
                        }
                    } else {
                        $ret[][$key]['new'] = 'NDNew';
                        $ret[][$key]['diff'] = 1; 
                    }
                } else {
                    if (isset($b[$key])){
                        $ret = self::diffArray($a[$key], $b[$key]);
                    } else {
                        $ret[][$key]['old'] = $val;
                        $ret[][$key]['new'] = 'NDNew';
                        $ret[][$key]['diff'] = 1; 
                    }
                }
            }
        } catch (Exception $ex){
            cpcDebug::cpc_debug('Exception','@diffArray_0310A');
            cpcDebug::cpc_debug($a,'@diffArray_0310A');
        }
        cpcDebug::cpc_debug('Result','@diffArray_0310A');
        cpcDebug::cpc_debug($ret,'@diffArray_0310A');
        return $ret;
    }
    private function p ($var, $m =''){
        echo($m);
        echo('<pre>');
        print_r($var);
        echo('</pre>');
    }
    public static function diffArray1 ($a, $b){
        $ret = array();
        try {
            $i = 1;
            foreach ($a as $key => $val){
                self::p($key, 'FOREACH Key');
                $ret[$i][$key] = array();
                //self::p($val, 'Value' );
                if (!is_array($val)){
                    self::p('VAl 1');
                    $ret[$i][$key]['old'] = $val;
                    if (isset($b[$key])){
                        self::p('VAl 2');
                        $ret[$i][$key]['new'] = $b[$key];
                        if ($b[$key] == $a[$key]){
                            self::p('VAl 3');
                            $ret[$i][$key]['diff'] = 0; 
                        } else {
                            self::p('VAl 4');
                            $ret[$i][$key]['diff'] = 1; 
                        }
                    } else {
                        self::p('VAl 5');
                        $ret[$i][$key]['new'] = 'NDNew';
                        $ret[$i][$key]['diff'] = 1; 
                    }
                } else {
                    self::p('VAl 6');
                    if (isset($b[$key])){
                        self::p('VAl 7');
                        $ret = self::diffArray($a[$key], $b[$key]);
                    } else {
                        self::p('VAl 8');
                        $ret[$i][$key]['old'] =  $val;
                        $ret[$i][$key]['new'] = 'NDNew';
                        $ret[$i][$key]['diff'] = 1; 
                    }
                }
                self::p('Zwischen');
                self::p($ret[$i]);
                self::p('Next Loop');
                $i++;
            }
        } catch (Exception $ex){
            self::p('Exception1');
            self::p($ex->getMessage());
        }
        self::p('Result');
        self::p($ret);
        return $ret;
    }
    public static function diffArray ($a, $b){
        $ret = array();
        try {
            $i = 1;
            foreach ($a as $key => $val){
                //self::p($key, 'LoopA');
                $ret[$i][$key] = array();
                ////self::p($val, 'Value' );
                if (!is_array($val)){
                    //self::p('VAl 1');
                    $ret[$i][$key]['old'] = $val;
                    if (isset($b[$key])){
                        //self::p('VAl 2');
                        $ret[$i][$key]['new'] = $b[$key];
                        if ($b[$key] == $a[$key]){
                            //self::p('VAl 3');
                            $ret[$i][$key]['diff'] = 0; 
                        } else {
                            //self::p('VAl 4');
                            $ret[$i][$key]['diff'] = 1; 
                        }
                    } else {
                        //self::p('VAl 5');
                        $ret[$i][$key]['new'] = 'NDNew';
                        $ret[$i][$key]['diff'] = 1; 
                    }
                } else {
                    //self::p('VAl 6');
                    if (isset($b[$key])){
                        //self::p('VAl 7');
                        $ret = self::diffArray($a[$key], $b[$key]);
                        //self::p($ret, 'RFR');
                    } else {
                        //self::p('VAl 8');
                        $ret[$i][$key]['old'] =  $val;
                        $ret[$i][$key]['new'] = 'NDNew';
                        $ret[$i][$key]['diff'] = 1; 
                    }
                }
                //self::p('Zwischen');
                //self::p($ret[$i]);
                //self::p('Next Loop');
                $i++;
            }
        } catch (Exception $ex){
            //self::p('Exception1');
            //self::p($ex->getMessage());
        }
        //self::p($ret,'EndeB');
        //self::p($ret);
        return $ret;
    }
    private function rearange($str){
        cpcDebug::cpc_debug('rea1','@diffJson_0310B');
        $str1 = str_replace(',»', '»,', $str);
        cpcDebug::cpc_debug($str1,'@diffJson_0310B');
    }
    public static function getCustomNameXMLNode($key){
        $node = PPXMLNodes::where('PPXMLNodes_Node', $key)->get()->first();
        if ($node){
            return $node->PPXMLNodes_Customname;
        }
        return $key;
    }
    public static function noBlanks($text){
        $ret = str_replace(' ','_', $text);
        //cpcDebug::cpc_debug($ret,'@T0403_1');
        return $ret;
    }
    public static function changePath($path){
        $str = str_replace('item/assortments/assortment','Sortierung', $path);
        $str = str_replace('item/quantities/quantity','Menge', $str);
        $str = str_replace('item/onlineQuantities/onlineQuantity','Online-Menge',$str);
        $str = str_replace('item/attachments/document','Dokumente',$str);
        $str = str_replace('item/certifications/certificationHG','Zertifikate',$str);
        $str = str_replace('item/certifications/certificationHG','Zertifikate',$str);
        $str = str_replace('item/','',$str);
        $astr2 = explode('/',$str);
        $ret=self::getCustomNameXMLNode($astr2[0]).'<br>';
        $first = true;
        $divide = '';
        foreach($astr2 as $str2){
            if ($first){
                $first = false;
            } else {
                $ret = "$ret$divide".self::getCustomNameXMLNode($str2);
                $divide = ':';
            }
        }
        return $ret;
    }
    public static function printArrayEmail ($a, $sub = true){
        //return print_r($a,1);
        if (!is_array($a)){
            if ( strtoupper($a) == 'FALSE'){
                return 'Nein';
            }
            if (strtoupper($a) == 'TRUE'){
                return 'Ja';
            }
            return $a;
        }
        //cpcDebug::cpc_debug('-----  Count ------','@DiffArray');
        //cpcDebug::cpc_debug(count($a),'@DiffArray');
        if (count($a) == 0){
            //cpcDebug::cpc_debug($a,'@DiffArray');
            return 'Keine Daten';
        }
        $mt = microtime(true);
        $mt = $mt*10000;
        $id = '"'. $mt .'"';
        if ($sub){
            $ret = "<div class='diff-container'><div class='diff-hide' style='border:none;display:block;color:green;font-size:1.1em;'><b>Knoten +</b></div>
            <div class='diff-show' id='diffShow_".$mt."' style='border:none;'><table class='diffArray' style='border-collapse:collapse;'>";
            foreach($a as $key => $item){
                //cpcDebug::cpc_debug($key,'@DiffArray');
                //cpcDebug::cpc_debug($item, '@DiffArray');
                //cpcDebug::cpc_debug('-----------------','@DiffArray');
                $ret .= '<tr>';
                $ret .= "<td style='text-align:top;'>".self::getCustomNameXMLNode($key)."</td>";
                if (is_array($item)){
                    $ret .="<td style='padding:0px;'>". self::printArray($item, false). '</td>'; 
                } else {
                    $ret .= "<td>".$item."</td>";
                }
                $ret .= '</tr>';
            }
            $ret .= "</table></div>
            </div>";
        } else {
            $ret = "<div><table class='diffArray' style='border-collapse:collapse;'>";
            foreach($a as $key => $item){
                $ret .= '<tr>';
                $ret .= "<td style='text-align:top;'>$key</td>";
                if (is_array($item)){
                    $ret .="<td style='padding:0px;'>". self::printArrayEmail($item, false). '</td>'; 
                } else {
                    $ret .= "<td>$item</td>";
                }
                $ret .= '</tr>';
            }
            $ret .= "</table></div>";
        }
        return $ret;
    }
    public static function printArray ($a, $sub = true){
        //return print_r($a,1);
        if (!is_array($a)){
            if ( strtoupper($a) == 'FALSE'){
                return 'Nein';
            }
            if (strtoupper($a) == 'TRUE'){
                return 'Ja';
            }
            return $a;
        }
        //cpcDebug::cpc_debug('-----  Count ------','@DiffArray');
        //cpcDebug::cpc_debug(count($a),'@DiffArray');
        if (count($a) == 0){
            //cpcDebug::cpc_debug($a,'@DiffArray');
            return 'Keine Daten';
        }
        $mt = microtime(true);
        $mt = $mt*10000;
        $id = '"'. $mt .'"';
        if ($sub){
            $ret = "<div id='diffShow_".$mt."' style='border:none;display:none;'><div style='border:none;' onclick='hideDiffrence(".$id.");'>Knoten -</div><table class='diffArray' style='border-collapse:collapse;'>";
            foreach($a as $key => $item){
                //cpcDebug::cpc_debug($key,'@DiffArray');
                //cpcDebug::cpc_debug($item, '@DiffArray');
                //cpcDebug::cpc_debug('-----------------','@DiffArray');
                $ret .= '<tr>';
                $ret .= "<td style='text-align:top;'>".self::getCustomNameXMLNode($key)."</td>";
                if (is_array($item)){
                    $ret .="<td style='padding:0px;'>". self::printArray($item, false). '</td>'; 
                } else {
                    $ret .= "<td>$item</td>";
                }
                $ret .= '</tr>';
            }
            $ret .= "</table></div><div style='color:green;' id='diffHide_".$mt."' onclick='showDiffrence(".$id.")'>Knoten +</div>";
        } else {
            $ret = "<div><table class='diffArray' style='border-collapse:collapse;'>";
            foreach($a as $key => $item){
                $ret .= '<tr>';
                $ret .= "<td style='text-align:top;'>$key</td>";
                if (is_array($item)){
                    $ret .="<td style='padding:0px;'>". self::printArray($item, false). '</td>'; 
                } else {
                    $ret .= "<td>$item</td>";
                }
                $ret .= '</tr>';
            }
            $ret .= "</table></div>";
        }
        return $ret;
    }
    public static function printDiffs ($a, $b, $diff){
        if (strpos($diff,'ur') === false){
            if (is_null($a)){
                return '';
            }
            if (is_null($b)){
                return '';
            }
            return self::diffString($a, $b);
        }
    }
    public static function _transContent($lang, $val,  $table, $field, $rowid){
        if ($lang == 'DE'){
            return $val;
        }
        $trans = Translations::where('Translations_Table','=',$table)
            ->where('Translations_Column','=',$field)
            ->where('Translations_TableId','=',$rowid)
            ->get()->first();
        if ($trans){
            	return $trans->{'Translations_'.$lang};
        }
        return $val;
    }
    public static function transContent($lang, $table, $field, $rowid, $row){
        if ($lang == 'DE'){
            return $row->{$field};
        }
        $trans = Translations::where('Translations_Table','=',$table)
            ->where('Translations_Column','=',$field)
            ->where('Translations_TableId','=',$rowid)
            ->get()->first();
        if ($trans){
            	return $trans->{'Translations_'.$lang};
        } else {
           /* $t = new Translations();
            $t->Translations_Table = $table;
            $t->Translations_Column = $field;
            $t->Translations_TableId = $rowid;
            $t->Translations_TextDE = $row->{$field};
            $t->Translations_TextEN = ServiceProvider::tl($lang, $row->{$field});
            $t->save(); */
        }
        return $row->{$field};
    }
    public static function isDateGreater(string $date1, string $date2): bool
        {
            // Versuche, DateTime-Objekte zu erstellen
            try {
                $d1 = new DateTime($date1);
                $d2 = new DateTime($date2);
            } catch (Exception $e) {
                // Wenn eines der Datumsformate ungültig ist, false zurückgeben
                return false;
            }
            return $d1 > $d2;
        }
    public static function AuthUserHasRole($role){
        $roleUser = Auth::user()->PPMitarbeiter_Role;
        if (strpos($roleUser, $role) !== false){
            return true;
        }
        return false;
    }
    public static function AuthUserHasTaetigkeit($taetigkeit){
        $taetigkeit = Auth::user()->PPMitarbeiter_Taetigkeit;
        if (strpos($taetigkeit, $taetigkeit) !== false){
            return true;
        }
        return false;
    } 
    public static function AuthUserIsAdmin(){
        if (Auth::user()->PPMitarbeiter_isAdmin){
            return true;
        }
        return false;
    }
    public static function getMitarbeiterLanguageFromId($id){
        $lang = 'DE';
        $m = PPMitarbeiter::where('PPMitarbeiter_Id', $id)->get()->first();
        if ($m) {
            $lang = $m->PPMitarbeiter_Language;
        }
        return $lang;
    }
    public static function getMitarbeiterLanguageFromEmail($email){
        $lang = 'DE';
        $m = PPMitarbeiter::where('PPMitarbeiter_email', $email)->get()->first();
        if ($m) {
            $lang = $m->PPMitarbeiter_Language;
        }
        return $lang;
    }
     public static function canMoveSPO(){
        if (strpos(Auth::user()->PPMitarbeiter_Role,'EXTERN') !== false){
             return false;
        }
        if (strpos(Auth::user()->PPMitarbeiter_Role,'INTERN') !== false){
            if (Auth::user()->PPMitarbeiter_Gruppe === 'admin'){
                return true;    
            }
            if(Auth::user()->PPMitarbeiter_Taetigkeit === 'PM'){
                return true;
            }
            if(Auth::user()->PPMitarbeiter_Taetigkeit === 'PJM'){
                return true;
            }
            if(Auth::user()->PPMitarbeiter_Taetigkeit === 'TC'){
                return true;
            }
            if (Auth::user()->PPMitarbeiter_Kuerzel === 'FKE'){
                return true;
            }
        }
        return false;
    }
}