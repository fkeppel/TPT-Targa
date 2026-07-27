<?php
class ServiceProviderAAA extends \BaseController {
    public  function tl ($lang, $text){
        $t = PPTranslateGUI::where('PPTranslateGUI_TextDE',$text)->get()->first();
        if(! $t){
            $t = new PPTranslateGUI();
            $txt = self::_replace0d($text);
            $t->PPTranslateGUI_TextDE = $txt;
            $t->save();
        }
        $att = 'PPTranslateGUI_Text'.$lang;
        if (is_null($t->{$att}) or strlen($t->{$att}) == 0){
            $t->{$att} = self::_translateLabel($text, $lang);
            //$t->{$att} = "$lang:$text";
            $t->save();
        }
        return $t->{$att};
    }
    private  function _replace0d($text){
        $ret = str_replace("\r\n", "\n", $text);
        return $ret;
    }
    private  function _translateLabel($text = null, $lang = 'EN'){
        if ($text == null or (trim($text) == '')) {
            $text = '-';
        }
        $api_Key = '10ee3599-028f-961f-ca7e-8c941bfaac5a';
        $deeplURL = "https://api.deepl.com/v2/translate";
        $ptext = mb_convert_encoding($text, 'UTF8');
        $ptext = $text;
        $vars = (array("text" => $ptext, "target_lang" => $lang));
        $ch = curl_init();
        $proxy = 'http://10.254.0.1';
        $proxy_port = 8080;
        //curl_setopt($ch, CURLOPT_PROXY, $proxy);
        //curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
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
    private function prna ($a, $exit=false){
        echo('<pre>');
        print_r($a);
        echo('<pre>');
        if ($exit){
            exit;
        }
    }
    private function markHTMLDiff($s){
        $replaceMinus = '<span style="background-color:red;color:white;"> Alt:';
        $replacePlus = '<span style="background-color:blue;color:white;"> Neu:';
        $t = str_replace('«-',$replaceMinus, $s);
        $v = str_replace('«+',$replacePlus, $t);
        $u = str_replace('»', '</span>', $v);
        return $u;
    }
    public static function diff ($b, $a){
        $diff=new NewDiffController();
        $diff->setMarkers("«","»");
        $ax=htmlspecialchars($a, ENT_QUOTES, 'UTF-8');
        $bx=htmlspecialchars($b, ENT_QUOTES, 'UTF-8');
        $diffTx = $diff->getDiff($ax, $bx, false, false); // Text output
        return self::markHTMLDiff($diffTx);
/*******************************************************/
    }
}