<?php  
class ViewController extends BaseController {
    var $pp = null;
    var $files = null;
    var $message = 'DEFAULT';
    var $pc = null;
    var $fileTabs = array();
    var $filesNachKat = null;
    public function init($view = 'pp_files', $param = null){
        return $this->$view($param);
    }
    private function pp_files($param){
    }
    private function formDateiauswahl($param){
        $this->message = 'Hallo Leute';
        $this->selectPP($param['ppid']);
        $this->selectFiles($param['ppid']);
        $this->selectFileTabs();
        return true;
    }
    private function c($var, $exit=true){
        echo('<br><pre>');
        print_r($var);
        echo('</pre>');
        if ($exit){
            exit;
        }
    }
    public function getFileTabs($knoten){
        if (isset($this->fileTabs[$knoten])){
            return $this->fileTabs[$knoten];
        }
        return false;
    }
    public function getMainFileTabs(){
        return $this->getFileTabs(0);
    }
    private function selectFileTabs(){
        $fts = PPFileTypes::where('PPFileTypes_Type', 'like', '%')->orderBy('PPFileTypes_sort')->get();
        $this->fileTabs = array();
        //$this->fileTabs[''] = 'Bitte auswählen...';
        foreach ($fts as $ft) {
            if (!isset($this->fileTabs[$ft->PPFileTypes_ParentId])){
                $this->fileTabs[$ft->PPFileTypes_ParentId] = array();
            }
            $this->fileTabs[$ft->PPFileTypes_ParentId][$ft->PPFileTypes_Id] = $ft->PPFileTypes_Type;
        }
        //echo('<pre>');        print_r($this->fileTabs);        exit;
    }
    public function fileSubTabs(){
        print_r($this->pc->getUploadSubTypes());exit;
        return $this->pc->getUploadSubTypes();
    }
    private function selectPP($ppid){
        $this->pp = tPPProduktpass::where('PPProduktpass_Id',$ppid)->get()->first();
    }
    private function selectFiles($ppid){
        $_files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id',$ppid)->where('PPPPFiles_Status',1)->orderBy('PPPPFiles_Date')->get();
        $this->files = array();
        foreach ($_files as $file) {
            $this->files[$file->PPPPFiles_Id]= $file;
            $this->filesNachKat[$file->PPPPFiles_Type][$file->PPPPFiles_SubKat] []= $file;
        }
        //$this->c($this->filesNachKat);
    }
    public function pp($att){
        //return $this->message.$att;
        return $this->pp->{$att};
    }
    public function files (){
        return $this->files;
    }
    public function file($fileId , $att = null){
        if (is_null($att)){
            return $this->files[$fileId];
        }
        return $this->files[$fileId]->{$att};
    }
    public function getFileNachKat($kat, $subkat){
        //$this->c("Kat: $kat Sub: $subkat");
        if (isset($this->filesNachKat[$kat][$subkat])){
            return $this->filesNachKat[$kat][$subkat];
        }
        return array();
    }
    public static function sayHello($hello){
        return $hello;
    }
    public static function getSpoEditLink ($fileId, $v=2){
        $file = PPPPFiles::find($fileId);
        if(!$file){
            return '';
        }
        $pp=tPPProduktpass::find($file->PPPPFiles_PPProduktpass_Id);
        if (! $pp ){
            return '';
        }
        $ian = $pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $spLink = $file->PPPPFiles_SharePointLink;
        $editLink = '';
        if (!is_null($spLink) and strlen($spLink) > 3 and strpos($spLink,'d=w') !== false){
            $fileAndId = explode('?d=w', $file->PPPPFiles_SharePointLink);
            $spId = $fileAndId[1];
            $spFile = $fileAndId[0];
            //$editLink = "https://targagmbh.sharepoint.com/:x:/r/sites/TPTStorage/_layouts/15/Doc.aspx?sourcedoc=%7B".$spId."%7D&file=".$spFile."&action=default&mobileredirect=true";
            //https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/450069_2304/SQL%20Server%202019%20Editions%20Datasheet.pdf?csf=1&web=1&e=Evgy5K
            $editLink = "https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ian/$spFile";
            if ($v == 1){
                $editLink = "https://targagmbh.sharepoint.com/:x:/r/sites/TPTStorage/_layouts/15/Doc.aspx?sourcedoc=%7B".$spId."%7D&file=".$spFile."&action=interactivepreview";
            }
        }
        return $editLink;
    }
    private static function getPreFix($filename){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $ext = strtoupper($ext);
        $prefix = '';
        if ($ext == 'DOCX'){
            $prefix = 'ms-word:ofe|u|';
        }   
        if ($ext == 'XLSX'){
            $prefix = 'ms-excel:ofe|u|';
        }   
        if ($ext == 'XLSM'){
            $prefix = 'ms-excel:ofe|u|';
        }   
        if ($ext == 'PPTX'){
            $prefix = 'ms-powerpoint:ofe|u|';
        } 
        return $prefix;
    }
    public static function getSpoFilename ($fileId){
        $file = PPPPFiles::find($fileId);
        if(!$file){
            return '';
        }
        return 'data/uploads/'.$file->PPPPFiles_Name;
    }
    public static function getSpoDLName ($fileId){
        $file = PPPPFiles::find($fileId);
        if(!$file){
            return '';
        }
        if ($file->PPPPFiles_LocalUpload){
            return substr($file->PPPPFiles_Name,7);
        }
        return $file->PPPPFiles_Name;
    }
    public static function getSpoLink ($fileId, $type=99){
        $file = PPPPFiles::find($fileId);
        if(!$file){
            return '';
        }
        $extern = '';
        if ($file->PPPPFiles_IsExtern == 1){
            $extern= 'China';
        }
        if ($file->PPPPFiles_LocalUpload){
            return '/data/'.$file->PPPPFiles_Pfad.'/'.$file->PPPPFiles_Name;
        }
        $pp = tPPProduktpass::find($file->PPPPFiles_PPProduktpass_Id);
        if (! $pp ){
            return '';
        }
        $ian = $pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $spLink = $file->PPPPFiles_SharePointLink;
        $link='';
        if (!is_null($spLink) and strlen($spLink) > 3 and strpos($spLink,'d=w') !== false){
            $fileAndId = explode('?d=w', $file->PPPPFiles_SharePointLink);
            $spId = $fileAndId[1];
            $spFile = $fileAndId[0];
            $prefix = self::getPrefix($file->PPPPFiles_Name);
            //$prefix = "AABBBbvvvvFFgHiiii";
            switch ($type) {
                case 1:
                    $link = "https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage".$extern."/Freigegebene%20Dokumente/IANs/$ian/".$spFile."?csf=1&web=1";
                    break;
                case 2:
                    //$link = "https://targagmbh.sharepoint.com/sites/TPTStorage".$extern."/_layouts/15/download.aspx?UniqueId=$spId";
                    //$link = "https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage".$extern."/Freigegebene%20Dokumente/IANs/$ian/".$spFile."?csf=1&download=1";
                    $link = "https://targagmbh.sharepoint.com/sites/TPTStorage".$extern."/_layouts/15/download.aspx?SourceUrl=".rawurlencode("Freigegebene Dokumente/IANs/$ian/$spFile");
                    break;
                case 3:
                    //$link = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ian/$spLink";
                    $link = $prefix."https://targagmbh.sharepoint.com/:b:/r/sites/TPTStorage".$extern."/Freigegebene%20Dokumente/IANs/$ian/".$spFile."?csf=1&web=1";
                    break;
                default:
                    # code...
                    $link="";
                    break;
            }
            //$link = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ian/$spLink";
            //$link = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ian/$spLink";
            // Sharepoint Link: Targa
            //https://targagmbh.sharepoint.com/sites/TPTStorage/_layouts/15/download.aspx?UniqueId=57740cf7%2D99c6%2D4b0a%2D9fbd%2D5247c347a702
            //$link = "https://targagmbh.sharepoint.com/sites/TPTStorage/_layouts/15/download.aspx?UniqueId=".urlencode($spId);
        }
        return $link;
     }
     public static function getSpoImageLink ($fileId){
        $file = PPPPFiles::find($fileId);
        if(!$file){
            return '';
        }
        $pp=tPPProduktpass::find($file->PPPPFiles_PPProduktpass_Id);
        if (! $pp ){
            return '';
        }
        $ian = $pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $spLink = $file->PPPPFiles_Name;
        $link='';
        if (!is_null($spLink) and strlen($spLink) > 3 and strpos($spLink,'d=w') !== false){
            $fileAndId = explode('?d=w', $file->PPPPFiles_SharePointLink);
            $spId = $fileAndId[1];
            $spFile = $fileAndId[0];
            $link = "https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/$ian/$spLink";
        }
        return $link;
     }
    public static function getFileTabLink($ppid, $tabName, $subTabName=''){
        $tabs = array('EKPM', 'Sales', 'Logistik', 'Service', 'TC', 'Artwork', 'Musterung','CSR', 'PPUpload', 'Dateien-Unteraufgaben');
        $subTabs = array();
        $subTabs['EKPM'] = array('Protokoll', 'Produktdetails', 'Verträge', 'Projektplan', 'Rechnungen', 'Kalkulation', 'Patente'); 
        $subTabs['Sales'] = array('Stellungnahmen', 'Angebote');
        $subTabs['Logistik'] = array('Verschiffungsplan','Verschiffungsdokumente');
        $subTabs['Service'] = array('Haupt');
        $subTabs['TC'] = array('LIDL Labor', 'TARGA Labor', 'Dokumente', 'Megastep', 'TC intern', 'TARGA QC');
        $subTabs['Artwork'] = array('Handbuch', 'Verpackung', 'Transportkarton', 'Label', 'CGI');
        $subTabs['Musterung'] = array('Techpack', 'Diverses');
        $subTabs['CSR'] = array('CSR-Dokumente');
        $subTabs['PPUpload'] = array('Produktpass', 'PDFs','Projektbild', 'Diverses');
        $subTabs['Dateien-Unteraufgaben'] =array('Upload');
        $tabPos1 = array_search($tabName, $tabs);
        $tabPos2 = 0;
        if ($subTabName != ''){
            $tabPos2 = array_search($subTabName, $subTabs[$tabName]);
        }
        //$url ="/showAfterUpload/$ppid/6/$tabName/$tabPos1/$tabPos2";
        $url ="/show/$ppid/Dateien";
        return $url;
    }
    public static function getBrowser() { 
        $u_agent = $_SERVER['HTTP_USER_AGENT']; 
        //return $u_agent;
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Internet Explorer'; 
            $ub = "MSIE"; 
        } 
        elseif(preg_match('/Edg/i',$u_agent)) 
        { 
            $bname = 'Edge'; 
            $ub = "Edg"; 
        } 
        elseif(preg_match('/Firefox/i',$u_agent)) 
        { 
            $bname = 'Mozilla Firefox'; 
            $ub = "Firefox"; 
        } 
        elseif(preg_match('/Chrome/i',$u_agent)) 
        { 
            $bname = 'Google Chrome'; 
            $ub = "Chrome"; 
        } 
        elseif(preg_match('/Safari/i',$u_agent)) 
        { 
            $bname = 'Apple Safari'; 
            $ub = "Safari"; 
        } 
        elseif(preg_match('/Opera/i',$u_agent)) 
        { 
            $bname = 'Opera'; 
            $ub = "Opera"; 
        } 
        elseif(preg_match('/Netscape/i',$u_agent)) 
        { 
            $bname = 'Netscape'; 
            $ub = "Netscape"; 
        }  
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        return $bname;
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern
        );
    } 
    public function getScrollbarWidth (){
        $bname = self::getBrowser();
        if ($bname == 'Google Chrome'){
            return 'calc(100% + 10px)';
        }   
        if ($bname == 'Edge'){
            return 'calc(100% + 10px)';
        }
        return '100%';
    }
    public static function getMengeServiceAnfrage($sid){
        $serviceAnfrage = PPInputManuell::find($sid);
        if (!$serviceAnfrage){
            return 0;
        }
        if ($serviceAnfrage->PPInputManuell_MengeIAN == 0) {
            $pp = tPPProduktpass::find($serviceAnfrage->PPInputManuell_PPProduktpass_Id);
            if ($pp){
                return  number_format($pp->PPProduktpass_Gesamtmenge, 0, ',', '.');
            }
        }
        return  number_format( $serviceAnfrage->PPInputManuell_MengeIAN, 0, ',', '.');
    }
    public static function getTaetigkeiten(){
        $taettigkeiten = PPTaetigkeiten::orderBy('PPTaetigkeiten_Description')->get();
        $ret = array();
        foreach ($taettigkeiten as $taet) {
            $ret[$taet->PPTaetigkeiten_Id] = $taet->PPTaetigkeiten_Taetigkeit;
        }
        return $ret;
    }
    static public function UserHasRole ( $id, $pRole ){
        //cpcDebug::cpc_debug("Check User $id for Role $pRole", '@ViewController');
        $ma = PPMitarbeiter::where('PPMitarbeiter_Id', $id)->get()->first();
        if ($ma->PPMitarbeiter_Gruppe == 'admin'){
            return true;
        }
        $role = '';	
        if ($ma){
            $role = $ma->PPMitarbeiter_Role;
            //cpcDebug::cpc_debug("Role DB $role", '@ViewController');
        }
        if (strpos($role, $pRole) !== false){
            return true;
        }       
        return false;
    }
}