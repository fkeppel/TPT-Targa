<?php
require_once __DIR__ . '/../../vendor/autoload.php';
//use Office365\Runtime\Auth\ClientCredential;
//use Office365\Runtime\Http\RequestException;
//use Office365\SharePoint\File;
//use Office365\Runtime\ClientResult;
//use Office365\Runtime\Actions\InvokePostMethodQuery;
//use Office365\Runtime\Http\RequestOptions;
//use Office365\SharePoint\SPResourcePath;
//use Office365\Web;
//use Office365\Runtime\Paths\ResourcePathUrl;
//use Office365\Runtime\Auth\UserCredentials;
use Office365\Runtime\Auth\ClientCredential;
use Office365\Runtime\Auth\UserCredentials;
use Office365\SharePoint\ClientContext;
use Office365\SharePoint\FileCreationInformation;
use Office365\SharePoint\DocumentManagement\DocumentSet\DocumentSet;
use Office365\SharePoint\RoleType;
use Illuminate\Support\Facades\Log;
use Office365\Runtime\Http\RequestOptions;
use Illuminate\Support\Facades\File;
use Office365\SharePoint\File as SPFile;
//use Office365\SharePoint\File;
class Office365Controller extends BaseController
{
    private $user;
    private $passwd;
    private $targaUrl;
    private $settings_Url;         
    private $settings_ClientId;    
    private $settings_ClientSecret;
    private $AZURE_TENANT_ID;
    private $AZURE_CLIENT_ID;
    private $AZURE_CLIENT_SECRET;  
    private $SPO_SITE_URL;
    public function __construct()
    {
        $this->user     = Config::get('targa.user');
        $this->passwd   = Config::get('targa.passwd');
        $this->targaUrl = Config::get('targa.url');
        $this->AZURE_TENANT_ID     = Config::get('office365.tenant_id');
        $this->AZURE_CLIENT_ID     = Config::get('office365.client_id');
        $this->AZURE_CLIENT_SECRET = Config::get('office365.client_secret'); 
        $this->SPO_SITE_URL = Config::get('office365.site_url');
        $this->settings_ClientId = $this->AZURE_CLIENT_ID;
        $this->settings_ClientSecret = $this->AZURE_CLIENT_SECRET;
        $this->settings_Url = $this->SPO_SITE_URL;
        /* cpcDebug::cpc_debug('Office365Controller constructed','-SharePoint_secrets');
        cpcDebug::cpc_debug('User: '.$this->user,'-SharePoint_secrets');  
        cpcDebug::cpc_debug('Passwd: '.$this->passwd,'-SharePoint_secrets');
        cpcDebug::cpc_debug('TargaUrl: '.$this->targaUrl,'-SharePoint_secrets');
        cpcDebug::cpc_debug('Tenant: '.$this->AZURE_TENANT_ID,'-SharePoint_secrets');
        cpcDebug::cpc_debug('ClientId: '.$this->AZURE_CLIENT_ID,'-SharePoint_secrets');
        cpcDebug::cpc_debug('ClientSecret: '.$this->AZURE_CLIENT_SECRET,'-SharePoint_secrets');
        cpcDebug::cpc_debug('SiteUrl: '.$this->SPO_SITE_URL,'-SharePoint_secrets'); */
    } 
    private function c($msg,  $exit = false, $var='')
    {
        return;
        cpcDebug::cpc_debug($msg,'!SharePoint99');
        //if ($this->debug){
            echo (date('d.m.Y H:i:s')." $var<br><pre>");
            print_r($msg);
            echo ('</pre>');
            if ($exit) {
                exit;
            }
        //}
    }
    private function c2($msg,  $exit = false, $var='')
    {
        return;
        cpcDebug::cpc_debug($msg,'!SharePoint99');
    }
    private function _convertId($id)
    {
        return str_replace('-', '', $id);
    }
    private function _createLink($file)
    {
        $fileUrl = 'https://' . $this->targaUrl . '/' . $file['Path'] . '?d=w' . $this->_convertId($file['ID']);
        return $fileUrl;
    }
    private function createLink($ctx, $file)
    {
        $linkInfo = array('Path' => $file->getServerRelativeUrl(), 'ID' => $file->getUniqueId(), 'Name' => $file->getName());
        $link = $this->_createLink($linkInfo);
        return "<a href='$link' target='_blank'>" . $linkInfo['Name'] . "</a><br>";
    }
    private function createTPTLink($ctx, $file)
    {
        $linkInfo = array('Path' => $file->getServerRelativeUrl(), 'ID' => $file->getUniqueId(), 'Name' => $file->getName());
        $link = $file->getName().'?d=w' .$file->getUniqueId();
        return $link;
    }
    private function  getFileInfo($ctx, $dir, $filename)
    {
        $spoDir = "Freigegebene Dokumente/" . $dir;
        try{
            $rootFolder = $ctx->getWeb()->getFolderByServerRelativeUrl($spoDir );
        }
        catch (Exception $ex){
            echo("getFileInfo rootFolder: ".$ex->getCode()."  Message:".$ex->getMessage());
            exit;
        }
        try{
            $files = $rootFolder->getFiles()->get()->executeQuery();
        }
        catch (Exception $ex){
            echo("getFileInfo Files: ".$ex->getCode()."  Message:".$ex->getMessage());
            exit;
        }
        foreach ($files as $file) {
            if ($file->getName() == $filename) {
                return $file;
            }
        }
        return false;
    }
    private function createDir($ctx, $base, $dir)
    {   $docSetName = $base . '/' . $dir;
        $lib = $ctx->getWeb()->defaultDocumentLibrary();
        try{
            $docSet = DocumentSet::create($ctx, $lib->getRootFolder(), $docSetName)->executeQuery();
        } catch(Exception $ex){
            //$this->c("createDir 0 C:".$ex->getCode()."  "."M: ".$ex->getMessage(),1);
            return 0;
        }
        try{
            $folder = $this->getFolder($ctx,$base, $dir);
            //$this->c($folder,0,'Folder');
            $group = $ctx->getWeb()->getAssociatedVisitorGroup();
            $this->setPermission($ctx,$folder,$group, RoleType::Reader);
            $group = $ctx->getWeb()->getAssociatedMemberGroup();
            $this->setPermission($ctx,$folder,$group, RoleType::Reader);
        } catch(Exception $ex){
            //$this->c("createDir 1 C:".$ex->getCode()."  M: ".$ex->getMessage(),1);
            return -1;
        }
        return $docSet;
    }
    private function getContext($isExtern = 0)
    {
        return $this->getContext_ClientCredentialCert($isExtern);
        //cd /return $this->getContext_UserCredentials();
    }
    private function getContext_UserCredentials()
    {
        try {
            //$credentials = new UserCredentials($this->settings_ClientId, $this->settings_ClientSecret);
            $credentials = new UserCredentials($this->user, $this->passwd);
            $ctx = (new ClientContext($this->settings_Url))->withCredentials($credentials);
            echo('UC Success');
            return $ctx;
        } catch (Exception $ex) {
            echo('UC Exception');
            echo("CPC_UserCredentials: ".$ex->getCode()."  Message:".$ex->getMessage());
            return null;
        }
    }
    private function getContext_ClientCredentialCert($isExtern)
    {
        $siteUrl        = Config::get('app.SPO_siteUrl'); 
        if ($isExtern){
            $siteUrl        = Config::get('app.SPO_siteUrlChina'); 
        }
        $tenant         =  Config::get('app.SPO_tenant');
        $thumbprint     = Config::get('app.SPO_thumbprint');
        $clientId       = Config::get('app.SPO_clientId');
        $privateKeyPath =  Config::get('app.SPO_privateKeyPath'); 
        $privateKeyPwd  = Config::get('app.SPO_privateKeyPwd'); 
        $privateKey     = file_get_contents($privateKeyPath);
        $key            = openssl_pkey_get_private($privateKey, $privateKeyPwd);
        $ctx = (new ClientContext($siteUrl))->withClientCertificate($tenant, $clientId, $key, $thumbprint);
        return $ctx;
    }
    public function testSharepoint()
    {
       $this->testgetRoleDefinitions();
    }
    private function testgetRoleDefinitions(){
        try {
            $credentials = new UserCredentials($this->settings_ClientId, $this->settings_ClientSecret);
            $ctx = (new ClientContext($this->settings_Url))->withCredentials($credentials);
            $roleDef = $ctx->getWeb()->getRoleDefinitions()->getByName('TPTSpecialRights');
            $this->c($roleDef);
        } catch (Exception $ex) {
            echo($ex->getMessage());
        }
        echo("Ende<br>");
    }
    public function testSharepoint1()
    {
        echo("Test Sharepoint II<br>");
        try {
            //$credentials = new ClientCredential($this->settings_ClientId, $this->settings_ClientSecret);
            $ctx = $this->getContext();
            $file = $this->getFileInfo($ctx, '/IANs/T10054_2507', 'T10054_1_Zusatzfoto.jpg');
            exit;
            $link = $this->createLink($ctx, $file);
            echo ($link);
        } catch (Exception $ex) {
            echo("Fehler: " . $ex->getMessage());
            echo("Fehler: " . $ex->getCode());
            echo("Fehler: " . $ex->getTraceAsString());
        }
    }
    private function dirIANExists($ctx, $base, $dir){
        try{
            $rootFolder = $ctx->getWeb()->getFolderByServerRelativeUrl("Freigegebene Dokumente/$base/");
            $folders = $rootFolder->getFolders();
            $ctx->load($folders);
            $ctx->executeQuery();
        } catch (Exception $ex){
            echo("Dir IAN ex: ".$ex->getCode()."  Message:".$ex->getMessage());
            return false;
        }
        foreach($folders->getData() as $folder){
            if($folder->getName() === $dir){
                return true;
            }
        }
        return false;
    } 
    private function getFolder($ctx, $parent, $pFolder){
        $foldername = "Freigegebene Dokumente/$parent/";
        //$this->c("P: $parent F: $pFolder, T: $foldername");
        $rootFolder = $ctx->getWeb()->getFolderByServerRelativeUrl($foldername);
        $folders = $rootFolder->getFolders();
        $ctx->load($folders);
        $ctx->executeQuery();
        foreach($folders->getData() as $folder){
            //$this->c($folder->getName());
            if($folder->getName() === $pFolder){
                //$this->c('Found');
                return $folder;
            }
        }
        //$this->c('Not Found');
        return false;
    }
    /*
            $folder = $context->getWeb()->getFolderByServerRelativeUrl($folderUrl);
            $folderItem = $folder->getListItemAllFields();
            //1. create unique perms
            $folderItem->breakRoleInheritance(true);
            $context->executeQuery();
            //2. grant read permissions for a group
            $visitorGroup = $context->getWeb()->getAssociatedVisitorGroup();
            $roleDef = $context->getWeb()->getRoleDefinitions()->getByType(RoleType::Reader);
            $context->load($roleDef);
            $context->load($visitorGroup);
            $context->executeQuery();
            $folderItem->getRoleAssignments()->addRoleAssignment($visitorGroup->getId(),$roleDef->getId());
            $context->executeQuery();
    */ 
    private function setPermission($ctx, $folder, $group, $perm=RoleType::Reader){
        $folderItem = null;
        //echo('Y1#');
        try{
            cpcDebug::cpc_debug('setPermission: ','@T6');
            $folderItem = $folder->getListItemAllFields();
            cpcDebug::cpc_debug($folderItem,'@T6');
            $folderItem->breakRoleInheritance(true);
            $ctx->executeQuery();
        } catch (Exception $ex){
            //echo('Y1Fail#');
            return;
            $this->c($ex->getCode(),1);
            $this->c($ex->getMessage(),1);
        }
        try
        {
            //echo('Y3#');
            /*$group = $ctx->getWeb()->getAssociatedVisitorGroup();
            $memberGroup = $ctx->getWeb()->getAssociatedMemberGroup();;
            $ownerGroup = $ctx->getWeb()->getAssociatedOwnerGroup();;*/
            $roleDef = $ctx->getWeb()->getRoleDefinitions()->getByType($perm);
            if ($perm == RoleType::Contributor){
                $roleDef = $ctx->getWeb()->getRoleDefinitions()->getByName('TPTSpecialRights');
                //$ctx->load($roleDef);
                //$ctx->executeQuery();
                ////echo('TESTSP:<br>');
                //$this->c($roleDef->getDescription(),1);
            }
            $ctx->load($group);
            $ctx->executeQuery();
            $ctx->load($roleDef);
            $ctx->executeQuery();
            $folderItem->getRoleAssignments()->addRoleAssignment($group->getId(),$roleDef->getId());
            $ctx->executeQuery();
        } catch (Exception $ex){
            //echo('Y3Fail#');
            $this->c("CPC_Ex3: ".$ex->getCode()."  Message:".$ex->getMessage(),1);
        }
    }
    /* Permissions
        const None = 0;
        const Guest = 1;
        const Reader = 2;
        const Contributor = 3;
        const WebDesigner = 4;
        const Administrator = 5;
    */
    public function UploadSharePoint()
    {
        $dir = 'DEFAULT';
        if (Input::has('ian')){
            $dir = Input::get('ian');
        }
        $perm = RoleType::Reader;
        if (Input::has('permission')){
            $perm = Input::get('permission');
        }
        if (Input::hasFile('uplSharepoint')) {
            $file = Input::file('uplSharepoint');
            $ctx = $this->getContext();
            //$file = $file->getPathname();
            $base = 'IANs';
            $error = false;
            if (!$this->dirIANExists($ctx, $base, $dir)){
                $perm= RoleType::Reader;
                $a = $this->createDir($ctx, $base, $dir, $perm);
                //$this->c($a);
            }
            try{
                $this->c('Upload');
                $fn = $this->upload($ctx, "$base/$dir", $file);
            }
            catch (Exception $ex){
                echo("Upload fehlgeschlagen!<br>");
                print($ex->getMessage());
                $error = true;
            }
            if (!$error){
                $file = $this->getFileInfo($ctx, "$base/$dir", $fn);
                $link = $this->createLink($ctx, $file);
                $group = $ctx->getWeb()->getAssociatedVisitorGroup();
                $this->setPermission($ctx,$file,$group, RoleType::Reader);
                $group = $ctx->getWeb()->getAssociatedMemberGroup();
                $this->setPermission($ctx,$file,$group, RoleType::Contributor);
                echo($link);
            }
        } else {
            echo ("No Go");
        }
        echo ("Datei hochgeladen");
    }   
    public function Upload2SharePoint($dir, $uplFile)
    {
        $ctx = $this->getContext();
        $base = 'IANs';
        if (!$this->dirIANExists($ctx, $base, $dir)){
            $perm= RoleType::Reader;
            $a = $this->createDir($ctx, $base, $dir, $perm);
        }
        try{
            $fn = $this->upload($ctx, "$base/$dir", $uplFile);
        }
        catch (Exception $ex){
            echo("Upload fehlgeschlagen!<br>");
            print($ex->getMessage());
            return null;
        }
        $file = $this->getFileInfo($ctx, "$base/$dir", $fn);
        $link = $this->createTPTLink($ctx, $file);
        $group = $ctx->getWeb()->getAssociatedVisitorGroup();
        $this->setPermission($ctx,$file,$group, RoleType::Reader);
        $group = $ctx->getWeb()->getAssociatedMemberGroup();
        $this->setPermission($ctx,$file,$group, RoleType::Contributor);
        return ($link);
    }
    public function formUploadSharepoint()
    {
        return View::make('Sharepoint.formDateiauswahl');
    }
    private function getFilename ($name){
        $ret = str_replace('#','_', $name);
        $ret = str_replace('%','_', $ret);
        $ret = str_replace("'",'_', $ret);
        return $ret;
    }
    private function upload($ctx, $targetFolder, $file)
    {
        $orgFilename = $this->getFilename($file->getClientOriginalName());
        $targetFolderUrl = 'Freigegebene Dokumente/' . $targetFolder.'/';
        $localPath = $file->getPathname();
        $fileName = basename($localPath);
        $fileCreationInformation = new FileCreationInformation();
        $fileCreationInformation->Content = file_get_contents($localPath);
        $fileCreationInformation->Url = $orgFilename;
        //$this->c("O: $orgFilename L: $localPath  T:$targetFolderUrl ", 1);
        $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl)->getFiles()->add($fileCreationInformation)->executeQuery();
        return $orgFilename;
    }
/*    private function remove_prefix($file){  
        $ctx = $this->getContext();
        $url = $file->getServerRelativeUrl();
        $filename = $file->getName();
        $sourceFile = $ctx->getWeb()->getFileByServerRelativeUrl("$url/$filename");
        $ctx->load($sourceFile);
        $targetFile = $sourceFile->moveTo("/sites/team/Shared Documents/sample_renamed.docx", MoveOperations::Overwrite);
        $ctx->executeQuery();
    }
    */
    public function uploadFromTPT($ian, $pFile, $isExtern = 0)
    {
        //cpcDebug::cpc_debug('Point4A: '.$ian.'_'.$file,'log500');
        //$this->c2("Upload local file: $pFile");
        $localPath = $pFile;
        $orgFilename = basename($localPath);
        $fileCreationInformation = new FileCreationInformation();
        //ini_set ('memory_limit', filesize ($localPath) + 4000000);
        echo('X1#');
        try{
            echo('X2#');
            if (filesize($localPath) > 1000*1024*1024){
                //echo('Datei zu Gross!');
                //return null;
            }
            $fileCreationInformation->Content = file_get_contents($localPath);
        } 
        catch (Exception $ex)
        {   echo('X3#');
            //$this->c2("Exception1");
            //echo($ex->getMessage());
            //exit;
            return '@1';
        }
        $spFilename = $orgFilename; 
        if (strlen($orgFilename) > 6){
            if(substr($orgFilename,6,1) == '_'){
                $spFilename = substr($orgFilename,7);
            }
        }
        echo('X4#');
        $spFilename = $this->fileNameSharpointConform($spFilename);
        //cpcDebug::cpc_debug('Point4B','log500');
        //return null;
        //$this->c("Upload local file: $file"); 
        echo('X555#');
        try{
            $ctx = $this->getContext($isExtern);
        }
        catch (Exception $ex)
        {
            //$this->c2("Exception2");
            return '@0:' . $ex->getMessage();
        }
        $base = 'IANs';
        $error = false;
        echo('X5A#');
        if (!$this->dirIANExists($ctx, $base, $ian)){
             echo('X5B#');
            $perm= RoleType::Reader;
            $a = $this->createDir($ctx, $base, $ian);
            //$this->c("Dir: $base $ian erzeugt",1);
        }
        echo('X6#');
        //cpcDebug::cpc_debug('Point4C','log500');
        $targetFolderUrl = "Freigegebene Dokumente/$base/$ian/";
        //echo($targetFolderUrl);
        $fileCreationInformation->Url = $spFilename;
        //$this->c("O: $orgFilename L: $localPath  T:$targetFolderUrl ",1);
        echo('X7#');
        if (file_exists($pFile)){
            //$this->c("$file existiert",1);
            echo('X8#');
            $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl)->getFiles()->add($fileCreationInformation)->executeQuery();
        } else {
            return '@2';
        }
        //cpcDebug::cpc_debug('Point4D','log500');
        //$this->c("Upload", 1);
        echo('X9#');
        try{
            //cpcDebug::cpc_debug('Point4T1','log500');
            $file = $this->getFileInfo($ctx, "$base/$ian", $spFilename);
            if ($file === false){
                return '@3';
            }
            //cpcDebug::cpc_debug('Point4T2','log500');
            $group = $ctx->getWeb()->getAssociatedVisitorGroup();
            //cpcDebug::cpc_debug('Point4T3','log500');
        } catch(Exception $ex){
            //$this->c2('Exception2');
            //cpcDebug::cpc_debug('Point4Ex: ','log500');
            //cpcDebug::cpc_debug($ex ,'log500');
            return '@4';
        }
        try{
            echo('X10#');
            $this->setPermission($ctx, $file, $group, RoleType::Reader);
        } catch(Exception $ex){
            echo('X10 fail#');
           // $this->c2('Exception3');
            //cpcDebug::cpc_debug('Point4Ex: ','log500');
            //cpcDebug::cpc_debug($ex ,'log500');
            return '@5';
        }
        try{
            echo('X12#');
            //echo('OK3');exit;
            //cpcDebug::cpc_debug('Point4T4','log500');
            $group = $ctx->getWeb()->getAssociatedMemberGroup();
            $this->setPermission($ctx,$file,$group, RoleType::Contributor);
            $link = $this->createTPTLink($ctx, $file);
            //cpcDebug::cpc_debug('Point4T5','log500');
            //$this->c2($link. "  => transferd");
        } catch(Exception $ex){
            echo('X12Fail#');
            //$this->c2('Exception4');
            //cpcDebug::cpc_debug('Point4Ex: ','log500');
            //cpcDebug::cpc_debug($ex ,'log500');
            return '@6';
        }//$this->c('OK Return');
        //$this->c2('Point4Ende');
        return $link;
    }
    private function fileNameSharpointConform($fn){
        $ret = str_replace('%','_',$fn);
        $ret = str_replace('#','_',$ret);
        //$ret = str_replace('(','_',$ret);
        //$ret = str_replace(')','_',$ret);
        //$ret = urlencode($fn);
        return $ret;
    }
    private function insertPPPPFiles (){
    }
    public function testBG ($param){
        $file = '/var/www/targa/public/data/XML/Demo2.xml';
        if (file_exists($file)){
            echo('Datei bereit!<br>');
            echo(__DIR__ . '/../../');
            echo('<br>OKssss<br>');
        } else {
            echo('Datei nicht gefunden!');
        }
        $baseDir = '/var/www/targa/public/data/tmp/test/'; 
        $arcDir = '/var/www/targa/public/data/tmp/test/success/'; 
        for ($i=1; $i<10; $i++){
            $file = 'IMG_'.$i.'.jpg';
            $fn = $baseDir.$file;
            $this->uploadFromTPT('XXXABC_2299', $fn);
            $fnsuccess = $arcDir.$file;
            rename($fn, $fnsuccess);
        }
        echo('So geht es:<br>');
        echo($param);
        return 'OK';
    }
    public function SPOFileInfo (){
        $ctx = $this->getContext();
        $base = 'IANs';
        $ian = $base.'/99999A_9901';
        $spFilename = 'XXXFRTZRFHygrometer quotation 6.19.xls';
        $spFilename = 'ServiceAnfrage_IAN_999999.xlsx';
        //ServiceAnfrage_IAN_999999
        //        $ian = '434272_2501';
        //        $spFilename = 'TechPack_4.1-ReisenthelxxxEinkaufskorbmitAlurahmenfaltbar2-fachsortiert.xlsx';
        $targetFolderUrl = "Freigegebene Dokumente/$base/$ian/";
        $file = $this->getFileInfo2($ctx, $ian, $spFilename);
        exit;
        //print_r($file);        exit;
        if ($file !== false){
            echo("$ian $spFilename <br>");
            print_r($file->getProperty('TimeCreated').'<br>');
            print_r($file->getProperty('TimeLastModified'.'<br><pre>'));
            print_r($file);
        } else {
            echo("$ian $spFilename => Keine Infos <br>");
        }
        exit;
    }
    public function renameFolder($oldFoldername, $newFoldername){
        $targetFolderUrl = "Freigegebene Dokumente/IANs/$oldFoldername/";
        $ctx = $this->getContext();
        $folder = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl); 
        cpcDebug::cpc_debug("Rename: $oldFoldername to $newFoldername",'@T6');
        $folderExists = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl)->select(["Exists"])->get()->executeQuery()->getExists();
        if ($folderExists != ''){
            cpcDebug::cpc_debug('Folder exists','@T6');
            $folder->rename($newFoldername);
            $ctx->executeQuery();
        }
    }
    private function getInfo($file, $info){
        switch ($info) {
            case 'Name':
                return $file->getName();
                break;
            case 'Author':
                return $file->getAuthor();
                break;
            case 'TimeLastModified':
                return $file->getTimeLastModified();
                break;
            case 'ModifiedBy':
                $user = $file->getModifiedBy();
                var_dump($user->getHexCid());
                exit;
                $id = $user->getUserId();
                $id = $user->getGroups();
                $pn = $user->getUserPrincipalName();
                echo("Id: $id PN: $pn<br>");
                exit;
                break;
            default:
                return 'N.N.';
                break;
        }
    }
    private function _2Date($d){
        $raw = $d;
        //cpcDebug::cpc_debug($raw,'-T6');
        $utc = new DateTime($raw, new DateTimeZone('UTC'));
        $utc->setTimezone(new DateTimeZone('Europe/Berlin'));
        return $utc->format('Y-m-d H:i:s');
        //$_d = new DateTime($d);
        //$_d->add(new DateInterval('PT1H'));
        //return $_d->format('d.m.Y H:i:s');
    }
    public  function  getLastChanged( $ian, $ausm)
    {
        //return array();
        $ctx = $this->getContext();
        $dir =  'IANs/'.$ian.'_'.$ausm;
        $rootFolder = $ctx->getWeb()->getFolderByServerRelativeUrl("Freigegebene Dokumente/" . $dir);
        $files = $rootFolder->getFiles()->get()->executeQuery();
        $alc = array();
        foreach ($files as $file) {
            $fn =  $file->getName();
            $lc =  $this->_2Date($file->getTimeLastModified());
            $alc[$fn] = $lc;
        }
        return $alc;
    }
    public function renameSPO(){
        $ian = '999999';
        $ausm = '9901';
        $fn = 'MegaStep Betrachtungsprotokoll_V2.xlsx'; 
        $ver= '001';
        $this->versioningFile($ian, $ausm,$fn, $ver);
    }
    public function versioningFile ($ian, $ausm, $fn, $fnver){
        $dir = 'IANs/'.$ian.'_'.$ausm; 
        $ctx = $this->getContext();
        $file = $this->getFileInfo($ctx,$dir, $fn);
        $this->_versioningFile($dir, $file, $fnver);
    }
    private  function _setDateModified($dir,$fnver, $dateLastModified){
        //cpcDebug::cpc_debug($dir, '!uploadFile');
        //cpcDebug::cpc_debug($fnver, '!uploadFile');
        //cpcDebug::cpc_debug($dateLastModified, '!uploadFile');
        $ctx = $this->getContext();
        $file = $this->getFileInfo($ctx,$dir, $fnver);
        //cpcDebug::cpc_debug($file, '!uploadFile');
        $file->setTimeLastModified($dateLastModified);
    }
    private function _versioningFile($dir, $file, $fnver){  
        $ctx = $this->getContext();
        $url = $file->getServerRelativeUrl();
        $dirUrl = "Freigegebene Dokumente/" . $dir;
        $filename = $file->getName();
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $subFn = pathinfo($filename, PATHINFO_FILENAME);
        $sourceFile = $ctx->getWeb()->getFileByServerRelativeUrl($url);
        $ctx->load($sourceFile);
        //$newFilename = $dirUrl.'/'.$subFn.'_Vx'.$ver.'.'.$ext;
        $newFilename = $dirUrl.'/'.$fnver;
        //echo($newFilename);
        //exit;
        $dateLastModified = $file->getTimeLastModified();
        cpcDebug::cpc_debug($dateLastModified, '!uploadFile');
        $targetFile = $sourceFile->moveTo($newFilename, 1);
        $ctx->executeQuery();
        $this->_setDateModified($dir, $fnver, $dateLastModified);
    }
    public function changeFileInfo(){
        $ctx = $this->getContext();
        $file = $this->getFileInfo($ctx, 'IANs/999999_9901', 'TestDateiTarga.png');
        print_r('TTT:' . $file->getTimeLastModified().'<br>');
        //echo("XX:".$file->getListItemAllFields()->getProperty('Last_x0020_Modified')); 
        //exit;
        $itemMeta = $file->getListItemAllFields(); 
        //echo('<pre>');        print_r($itemMeta->toJson());        exit;
        //$itemMeta->setProperty('Title', '456 TestMal sehen: 2000-01-01'); 
        //$itemMeta->setProperty('Last_x0020_Modified', '2000-01-01'); 
        //exit;
        //$file->setTimeLastModified('2000-01-01');
        //$itemMeta->setProperty('ClientNumber', $file['id']); 
        //$itemMeta->setProperty('ClientName', $file['venue']); 
        //$file->update();
        //$itemMeta->update()->executeQuery(); 
        echo('123:'.$itemMeta->getProperty('Title').'<br>');
        $ctx->executeQuery();
        exit;
        //$inums = $file->getVersions();
        //foreach($inums as $inum){
            echo('<pre>');
            print_r('TTT:' . $file->getTimeLastModified());
            $props = $file->getListItemAllFields();
            $props->setProperty('Title','So wird ein Schuh daraus!');
            //$file->setTitle('So wird ein Schuh daraus!');
            $props->update()->executeQuery();
            //$ctx->executeQuery();
            try{
                //$file->setTimeLastModified('2020-10-01');
                echo($file->getTitle());
            } catch (Exception $ex){
                print_r ($ex);
            }
            echo('</pre>');
        //}
        /*echo('<pre>');
        print_r($file->getVersions());
        echo('</pre>');*/
        //$file->setF
        exit;
    }
    public function testMFA (){
        /*  $siteUrl  = "https://<tenant>.sharepoint.com/sites/<site>";
            $username = "user@tenant.onmicrosoft.com";   // oder user@firma.tld
            $password = "PlainTextPasswort";             // nur zum Test!*/
        try {
            $ctx  = (new ClientContext($this->settings_Url))
                ->withCredentials(new UserCredentials($this->user, $this->passwd));
            // Minimaler Call: Web-Titel laden
            $web = $ctx->getWeb();
            $ctx->load($web);
            $ctx->executeQuery();
            echo "Login OK. Web Title: " . $web->getTitle() . PHP_EOL;
            echo "=> MFA ist für dieses Konto/Flow vermutlich NICHT erzwungen." . PHP_EOL;
        } catch (\Throwable $ex) {
            $msg = $ex->getMessage();
            // AADSTS-Code herausziehen (falls vorhanden)
            $code = null;
            if (preg_match('/AADSTS\d{5}/', $msg, $m)) {
                $code = $m[0];
            }
            echo "Fehler beim Login:\n$msg\n\n";
            if ($code === 'AADSTS50076' || $code === 'AADSTS50079') {
                echo "=> Hinweis: MFA erforderlich/erzwingt Zweitfaktor. "
                . "UserCredentials/ROPC sind damit blockiert.\n";
                echo "Lösung: App-Only mit ClientCredential/Zertifikat ODER interaktiver Flow.\n";
            } elseif ($code === 'AADSTS700016' || $code === 'AADSTS7000215' || $code === 'AADSTS70002') {
                echo "=> Client/App-Konfiguration prüfen (ClientId/Secret, falscher Flow, o.ä.).\n";
            } elseif ($code) {
                echo "=> AADSTS-Code erkannt: $code (bitte gegen Microsoft-Doku prüfen).\n";
            } else {
                echo "=> Kein AADSTS-Code erkannt. Möglicherweise reines SharePoint-403 "
                . "('Access denied') oder Netzwerk/URL-Problem.\n";
            }
        }
    }
    public function testSPOAppOnly()
    {
        $siteUrl = $this->settings_Url;
        $clientId = $this->settings_ClientId;
        $clientSecret = $this->settings_ClientSecret;
        return $this->spoAppOnlyTest($siteUrl, $clientId, $clientSecret);
    }
    function spoAppOnlyTest(string $siteUrl, string $clientId, string $clientSecret): bool
    {   
        echo('Targa SPO AppOnly Test 1 <br>');
        try {
            $ctx = (new ClientContext($siteUrl))->withCredentials(new ClientCredential(trim($clientId), trim($clientSecret)));
            // Minimaler Call: Web-Titel laden
            echo( 'Context OK <br>');
        } catch (\Throwable $e) {
            $msg  = $e->getMessage();
            $code = (int)$e->getCode();
            echo "FAIL Context 1 – ".get_class($e)." ({$code}) ".($msg ?: '(kein Exception-Text)')."\n";
            // Schnelle Einordnung
            if (stripos($msg, 'AADSTS') !== false) {
                echo "Hinweis: AADSTS ⇒ ClientId/Secret/Tenant oder Consent falsch.\n";
            } elseif ($code === 403 || stripos($msg, 'Access denied') !== false) {
                echo "Hinweis: 403 ⇒ App hat kein SharePoint-Recht (Sites.Read.All/ReadWrite.All) oder Admin-Consent fehlt.\n";
            }
            return false;
        }
        try {
            echo('<br>Targa SPO AppOnly Test 3 : WEB <br>');
            // Minimaler Call: Web-Titel laden
            $web = $ctx->getWeb();
            $ctx->load($web);
            echo "<br>WEBLoad3 OK<br><br><pre>";
            //print_r($ctx);
             $ctx->getPendingRequest()->beforeExecuteRequest(function (RequestOptions $r) {
                $auth = $r->Headers['Authorization'] ?? '';
                $jwt = substr($auth, 7);
                $parts = explode('.', $jwt);
                $p   = json_decode(base64_decode(strtr(explode('.', $jwt)[1], '-_', '+/')), true);
                $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
                echo('<br>JWT<br>');
                print_r($jwt);
                echo('<br>P<br>');
                print_r($p);
                echo('<br>payload<br>');
                print_r($payload);
                print_r("<br><br>Request: {$r->Method} {$r->Url} (Auth: $auth)\n");
            });
            $ctx->executeQuery();
            echo "</pre><br><br>Query OK<br>";
            //echo "OK2 – verbunden. Site: {$web->getTitle()}\n";
            return true;
        } catch (\Throwable $e) {
            $msg  = $e->getMessage();
            $code = (int)$e->getCode();
            echo "<br>FAIL Web 8 – <br><br> ".get_class($e)." ({$code}) ".($msg ?: '(kein Exception-Text)')."\n";
            // Schnelle Einordnung
            if (stripos($msg, 'AADSTS') !== false) {
                echo "Hinweis: AADSTS ⇒ ClientId/Secret/Tenant oder Consent falsch.\n";
            } elseif ($code === 403 || stripos($msg, 'Access denied') !== false) {
                echo "Hinweis: 403 ⇒ App hat kein SharePoint-Recht (Sites.Read.All/ReadWrite.All) oder Admin-Consent fehlt.\n";
            }
            return false;
        }
    }
   public function spoAppOnlyTestA( $siteUrl, $clientId, $clientSecret,  $doWrite      = true ): \Illuminate\Http\JsonResponse
    {
        /*$siteUrl      = "https://XXX.sharepoint.com/sites/TPTStorage";
        $clientId     = trim(env('SPO_CLIENT_ID'));
        $clientSecret = trim(env('SPO_CLIENT_SECRET'));*/
        // zum Start nur lesen
        $out = ['steps' => []];
        $lastReq = ['url'=>null,'method'=>null];
        try {
            if (!preg_match('/^[0-9a-fA-F-]{36}$/', $clientId)) {
                throw new \RuntimeException("ClientId ist keine GUID.");
            }
            if ($clientSecret === '') {
                throw new \RuntimeException("ClientSecret ist leer.");
            }
            $ctx = (new ClientContext($siteUrl))
                ->withCredentials(new ClientCredential($clientId, $clientSecret));
            // 👉 logge ausgehende Requests (URL/Method)
            $ctx->getPendingRequest()->beforeExecuteRequest(function (RequestOptions $r) use (&$lastReq) {
                $lastReq['url']    = $r->Url;
                $lastReq['method'] = $r->Method;
                Log::info('phpSPO request', $lastReq);
            });
            $out['steps'][] = 'CTX ok';
            $web = $ctx->getWeb();
            $ctx->load($web);
            $out['steps'][] = 'load(web)';
            $ctx->executeQuery();
            $out['steps'][]   = 'query ok';
            $out['siteTitle'] = $web->getTitle();
            if (!$doWrite) {
                $out['lastRequest'] = $lastReq;
                return new \Illuminate\Http\JsonResponse($out);
            }
            // (optional) Schreibtest …
            // $p = parse_url($siteUrl); $sitePath = rtrim($p['path'] ?? '', '/');
            // $folder = $ctx->getWeb()->getFolderByServerRelativeUrl($sitePath.'/Shared Documents');
            // $ctx->load($folder); $ctx->executeQuery();
            // $file = 'app-only-'.time().'.txt';
            // File::saveBinary($ctx, $folder->getServerRelativeUrl()."/$file", "test ".now());
            // $out['upload'] = $file;
            $out['lastRequest'] = $lastReq;
            return new \Illuminate\Http\JsonResponse($out);
        } catch (\Throwable $ex) {
            // 💡 maximal hilfreiche Diagnose ins Log
            Log::error('phpSPO exception', [
                'class'    => get_class($ex),
                'message'  => $ex->getMessage(),
                'code'     => $ex->getCode(),
                'file'     => $ex->getFile(),
                'line'     => $ex->getLine(),
                'trace'    => $ex->getTraceAsString(),
                'previous' => $ex->getPrevious() ? [
                    'class'   => get_class($ex->getPrevious()),
                    'message' => $ex->getPrevious()->getMessage(),
                ] : null,
                'lastReq'  => $lastReq,
            ]);
            $payload = [
                'error'       => $ex->getMessage() ?: '(kein Exception-Text)',
                'class'       => get_class($ex),
                'code'        => $ex->getCode(),
                'lastRequest' => $lastReq,
            ];
            // Häufige Hinweise
            if (stripos($ex->getMessage(), '403') !== false || stripos($ex->getMessage(), 'access denied') !== false) {
                $payload['hint'] = '403: Prüfe Application-Permissions (Sites.ReadWrite.All) + Admin-Consent; Site-URL exakt; evtl. Access Controls (Unmanaged devices/IP).';
            }
            return new \Illuminate\Http\JsonResponse($payload, 500);
        }
    }
    public function cDir (){
        try{
            $credentials = new ClientCredential($this->settings_ClientId, $this->settings_ClientSecret);
            $ctx = (new ClientContext($this->settings_Url))->withCredentials($credentials);
            $folderName = "Test_" . rand(1, 100000);
            $rootFolder = $ctx->getWeb()->getFolderByServerRelativeUrl("Shared Documents");
            $newFolder = $rootFolder->getFolders()->add($folderName)->executeQuery();
        } catch (Exception $ex){
            echo("Fehler: " . $ex->getMessage());
            echo("Fehler: " . $ex->getCode());
            echo("Fehler: " . $ex->getTraceAsString());
        }
        //print($newFolder->getServerRelativeUrl());
    }
    public function testx (){
        //echo('Test12<br>'.date('Y-m-d H:i:s').'<br>');
        $tenantId     = $this->AZURE_TENANT_ID;             // z.B. GUID oder contoso.onmicrosoft.com
        $clientId     = trim($this->AZURE_CLIENT_ID);       // nur GUID, kein @, keine Spaces
        $clientSecret = $this->AZURE_CLIENT_SECRET;
        $siteUrl      = $this->SPO_SITE_URL;                // https://<tenant>.sharepoint.com/sites/<Site>
        $ctx = (new ClientContext($siteUrl))->withCredentials(new ClientCredential($clientId, $clientSecret));
        //$ctx = (new ClientContext($siteUrl))->withCredentials(new UserCredentials($this->user, $this->passwd));
        try{
            $cu = $ctx->getWeb()->getCurrentUser();
            $ctx->load($cu);
            echo('Login12: <br><pre>');
            //print_r($cu->getLoginName());
            print_r($ctx);
            echo('</pre>');
            exit;
        }
        catch (\Throwable $e) {
            $msg = $e->getMessage();
            $code = (int)$e->getCode();
            echo "FAIL whoami <br>".get_class($e)." ({$code}) ".($msg ?: '(kein Exception-Text)')."\n";
            exit;
        }
        $ctx->executeQuery();
        echo('Durch: <br><pre>');
        echo('</pre>');
        exit;
        // ab hier normal weiter:
        $web = $ctx->getWeb();
        $ctx->load($web);
        try{
            $ctx->executeQuery();
            echo $web->getTitle();
        }
        catch (\Throwable $e) {
            $msg = $e->getMessage();
            $code = (int)$e->getCode();
            echo "FAIL <br>".get_class($e)." ({$code}) ".($msg ?: '(kein Exception-Text)')."\n";
        }
    }
    /////////////////////////////////////////
    private function http_post_form($url, array $params, array $headers = []) {
        $ch = curl_init($url);
        $body = http_build_query($params, '', '&');
        $headers = array_merge(['Content-Type: application/x-www-form-urlencoded','Accept: application/json'], $headers);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $res = curl_exec($ch);
        if ($res === false) throw new \RuntimeException('cURL error: '.curl_error($ch));
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$status, $res];
    }
    private function http_get_json($url, $bearer) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer '.$bearer, 'Accept: application/json;odata=nometadata'],
            CURLOPT_TIMEOUT        => 10,
        ]);
        $res = curl_exec($ch);
        if ($res === false) throw new \RuntimeException('cURL error: '.curl_error($ch));
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$status, $res];
    }
    public function test5(){
        echo('12Beispiel: Token + Web-Title<br>');
        $tenant = $this->AZURE_TENANT_ID;
        $clientId = trim($this->AZURE_CLIENT_ID);
        $clientSecret = $this->AZURE_CLIENT_SECRET;
        $siteUrl = $this->SPO_SITE_URL;
        $host = 'https://'.parse_url($siteUrl, PHP_URL_HOST);
        $vars = get_defined_vars();
        echo "12<pre>";
        print_r($vars);          // oder var_dump($vars);
        echo "</pre>";
        /* list($st,$body) = $this->http_post_form("https://login.microsoftonline.com/{$tenant}/oauth2/v2.0/token", [
          'client_id'=>$clientId,'client_secret'=>$clientSecret,'grant_type'=>'client_credentials','scope'=>$host.'/.default'
        ]); */
        list($st,$body) = $this->http_post_form("https://login.microsoftonline.com/{$tenant}/oauth2/v2.0/token", [
          'client_id'=>$clientId,'client_secret'=>$clientSecret,'grant_type'=>'client_credentials','scope'=>$host.'/sites/TPTStorage/.default'
        ]); 
        echo('Nach list');
          exit;
        $data = json_decode($body,true);
        $token = $data['access_token'] ?? null;
        list($st2,$webJson) = $this->http_get_json(rtrim($siteUrl,'/').'/_api/web?$select=Title', $token); 
    }
    //////////////////////////////////////////
    public function loginTest()
    {
        $ctx = $this->getContext();
        $cu = $ctx->getWeb()->getCurrentUser();
        $ctx->load($cu);
        try{
            $ctx->executeQuery();
            echo('Login OK Ja: <br><pre>');
            print_r($cu->getLoginName());
            echo('</pre>');
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            $code = (int)$e->getCode();
            echo "FAIL whoami <br>".get_class($e)." ({$code}) ".($msg ?: '(kein Exception-Text)')."\n";
        }
        $lists = $ctx->getWeb()->getLists();
        $ctx->load($lists);
        $ctx->executeQuery();
        echo('Listen XI:<br>');
        foreach ($lists as $list) {
            // 101 = Document Library
            if ($list->getBaseTemplate() === 101) {
                $ctx->load($list, ['Title', 'RootFolder']);
                $ctx->executeQuery();
                // z.B. "/sites/TPTStorage/Shared Documents"
                echo $list->getTitle().": ".$list->getRootFolder()->getServerRelativeUrl()."<br>";
            }
        }
        $exists = false;
        echo('Dateien XV:<br>');
        $web = $ctx->getWeb();
        $ctx->load($web, ['ServerRelativeUrl']);
        try{
            $ctx->executeQuery();
        } catch (\Throwable $e) {
            echo "Fehler beim Laden der Web-Informationen: " . $e->getMessage() . "\n";
            exit;
        }
        //$siteRoot = rtrim($web->getServerRelativeUrl(), '/');
        echo('Path:<br>');
        print_r($web->getServerRelativePath());
        $siteRoot = rtrim($web->getServerRelativeUrl());
        echo('SiteRoot: '.$siteRoot . "<br>");
        // Segmente sicher zusammensetzen (Leerzeichen, Umlaute etc.)
        $join = function(string $base, array $segments){
                return $base.'/'.implode('/', array_map('rawurlencode', $segments));
        };
        $serverRelativeUrl = $join($siteRoot, [
                                    'Freigegebene Dokumente',      // interner Name!
                                    'IANs',
                                    '425178_2301',
                                    '27050156_1.pdf'
                                    ]);
        try {
            $f = $ctx->getWeb()->getFileByServerRelativeUrl($serverRelativeUrl);
            $ctx->load($f, ['Length']);   // kleines Feld, genügt zum Testen
            $ctx->executeQuery();
            $exists = true;
        } catch (\Throwable $e) {
            // 404 -> existiert nicht, andere Fehler -> Auth/Path prüfen
            echo "Fehler beim Laden der Datei: " . $e->getMessage() . "\n";
            exit;
        }
        echo $exists ? "✅ Datei existiert\n" : "❌ Datei nicht gefunden\n"; 
    }
  /** Korrektur ********************************************************* */
private function spEncodePath(string $path): string
{
    // Verhindert Double-Encoding: erst decodieren, dann segmentweise encoden
    $path = rawurldecode($path);
    $leadingSlash = (isset($path[0]) && $path[0] === '/'); // PHP 7.4 kompatibel
    $segments = explode('/', ltrim($path, '/'));
    // rawurlencode: Space => %20, '+' => %2B
    $segments = array_map('rawurlencode', $segments);
    return ($leadingSlash ? '/' : '') . implode('/', $segments);
}
private function joinServerRelative(string $webRoot, string $rel): string
{
    $webRoot = rtrim($webRoot, '/');
    $rel = '/' . ltrim($rel, '/');
    return $webRoot . $rel;
}
/**
 * Robust gegen unterschiedliche vgrem-Versionen:
 * - manche liefern direkt string
 * - manche liefern ClientResult mit getValue()
 * - manche führen executeQuery intern aus, manche nicht
 */
private function openBinaryValue(ClientContext $ctx, string $serverRelativeUrl): string
{
    $result = SPFile::openBinary($ctx, $serverRelativeUrl);
    // sicherheitshalber ausführen (idempotent genug)
    try {
        $ctx->executeQuery();
    } catch (\Throwable $e) {
        // Falls openBinary intern schon executed hat, kann es je nach Implementierung
        // trotzdem ok sein. Wenn hier ein Fehler kommt, werfen wir ihn weiter.
        throw $e;
    }
    if (is_string($result)) {
        return $result;
    }
    if (is_object($result) && method_exists($result, 'getValue')) {
        return (string)$result->getValue();
    }
    throw new \RuntimeException('openBinary: Unbekannter Rückgabetyp: ' . gettype($result));
}
private function spHistoryIdFromVersionLabel(string $label): int
{
    // "1.0" oder "12.3" oder "7"
    $label = trim($label);
    $major = 0;
    $minor = 0;
    if (strpos($label, '.') !== false) {
        list($maj, $min) = explode('.', $label, 2);
        $major = (int)$maj;
        $minor = (int)$min;
    } else {
        $major = (int)$label;
        $minor = 0;
    }
    return ($major * 512) + $minor;
}
private function copyFileWithVersions(
    ClientContext $srcCtx,
    ClientContext $dstCtx,
    string $srcRelUrl,
    string $dstFolderRelUrl
) {
    // Eingaben normalisieren: manchmal kommen %20/%2B schon encoded rein
    $srcRelUrl       = rawurldecode($srcRelUrl);
    $dstFolderRelUrl = rawurldecode($dstFolderRelUrl);
    cpcDebug::cpc_debug("copyFileWithVersion: $srcRelUrl $dstFolderRelUrl", '-NWE1');
    //
    // 1) Quelle: Web holen
    //
    try {
        $webSrc = $srcCtx->getWeb();
        $srcCtx->load($webSrc);
        $srcCtx->executeQuery();
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER load/executeQuery(WebSrc): " . $ex->getMessage(), '-NWE1');
        return;
    }
    $webRootSrc = $webSrc->getServerRelativeUrl(); // z.B. "/sites/TPTStorage"
    //
    // 2) Quelle: Datei + Versionen laden
    //
    $srcServerRelUrl = $this->joinServerRelative($webRootSrc, $srcRelUrl);
    $srcServerRelUrl = $this->spEncodePath($srcServerRelUrl);
    cpcDebug::cpc_debug("SRC ServerRelUrl (encoded): $srcServerRelUrl", '-NWE1');
    try {
        $srcFile  = $webSrc->getFileByServerRelativeUrl($srcServerRelUrl);
        $versions = $srcFile->getVersions();
        // ---- Änderung: select() als STRING (kein Array!), und niemals abbrechen wenn es fehlschlägt
        try {
            if (method_exists($versions, 'select')) {
                // Wichtig: STRING, sonst kann "Serialization of 'Closure'" auftreten
                $versions->select('VersionLabel,Url,Created,CheckInComment');
            } elseif (method_exists($versions, 'getQueryOptions') && $versions->getQueryOptions()) {
                // ebenfalls STRING
                $versions->getQueryOptions()->Select = 'VersionLabel,Url,Created,CheckInComment';
            }
        } catch (\Throwable $e) {
            cpcDebug::cpc_debug("WARN select(Url) nicht verfügbar: " . $e->getMessage(), '-NWE1');
            // NICHT return; -> wir versuchen trotzdem, die Collection zu laden
        }
        // ---- Ende Änderung
        $srcCtx->load($srcFile);
        $srcCtx->load($versions);
        $srcCtx->executeQuery();
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER load file/versions: " . $ex->getMessage(), '-NWE1');
        return;
    }
    // Kanonische URL vom Server (SharePoint normalisiert intern häufig)
    $srcServerRelUrlExact = $srcFile->getServerRelativeUrl();
    cpcDebug::cpc_debug("SRC ServerRelUrl (exact): $srcServerRelUrlExact", '-NWE1');
    //
    // 3) Aktuellen Inhalt holen
    //
    try {
        $fileContent = $this->openBinaryValue($srcCtx, $srcServerRelUrlExact);
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER openBinary (aktuell): " . $ex->getMessage(), '-NWE1');
        cpcDebug::cpc_debug("openBinary URL used: " . $srcServerRelUrlExact, '-NWE1');
        return;
    }
    //
    // 4) Ziel: Web + Zielordner holen
    //
    cpcDebug::cpc_debug("2. Ziel: Web + Zielordner holen", '-NWE1');
    try {
        $webDst = $dstCtx->getWeb();
        $dstCtx->load($webDst);
        $dstCtx->executeQuery();
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER load/executeQuery(WebDst): " . $ex->getMessage(), '-NWE1');
        return;
    }
    $webRootDst = $webDst->getServerRelativeUrl();
    $dstFolderServerRelUrl = $this->joinServerRelative($webRootDst, $dstFolderRelUrl);
    $dstFolderServerRelUrl = $this->spEncodePath($dstFolderServerRelUrl);
    cpcDebug::cpc_debug("DST Folder ServerRelUrl: $dstFolderServerRelUrl", '-NWE1');
    try {
        $dstFolder = $webDst->getFolderByServerRelativeUrl($dstFolderServerRelUrl);
        $dstCtx->load($dstFolder);
        $dstCtx->executeQuery();
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER load dst folder: " . $ex->getMessage(), '-NWE1');
        return;
    }
    //
    // 5) Datei im Ziel anlegen (aktuelle Version)
    //
    $fileName = basename($srcRelUrl); // decoded => echter Name mit +/Spaces
    $fileCreationInfo = new FileCreationInformation();
    $fileCreationInfo->Url       = $fileName;   // NICHT encoded speichern!
    $fileCreationInfo->Content   = $fileContent;
    $fileCreationInfo->Overwrite = true;
    try {
        $dstFile = $dstFolder->getFiles()->add($fileCreationInfo);
        $dstCtx->executeQuery();
        $dstCtx->load($dstFile);
        $dstCtx->executeQuery();
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER create dst file: " . $ex->getMessage(), '-NWE1');
        return;
    }
    cpcDebug::cpc_debug("3. Datei im Ziel angelegt: $fileName", '-NWE1');
    //
    // 6) Historische Versionen (nur wenn Url vorhanden & in SPO abrufbar)
    //
    foreach ($versions->getData() as $version) {
        $label = $version->getVersionLabel();
        cpcDebug::cpc_debug("VersionLabel: $label", '-NWE1');
        try {
            // KEIN $srcCtx->load($version) -> führt bei deiner Lib zu "toUrl() on null"
            $versionUrl = null;
            if (method_exists($version, 'getUrl')) {
                $versionUrl = $version->getUrl();
            } elseif (method_exists($version, 'getProperty')) {
                $versionUrl = $version->getProperty('Url');
            }
            if (!$versionUrl) {
                throw new \RuntimeException("FileVersion.Url nicht verfügbar (nicht geladen oder Lib unterstützt es nicht).");
            }
            // Wenn relativ, WebRoot davor
            if ($versionUrl[0] !== '/') {
                $versionUrl = rtrim($webRootSrc, '/') . '/' . ltrim($versionUrl, '/');
            }
            $versionUrlEncoded = $this->spEncodePath($versionUrl);
            cpcDebug::cpc_debug("VersionUrl: $versionUrlEncoded", '-NWE1');
            $binary = $this->openBinaryValue($srcCtx, $versionUrlEncoded);
            $this->uploadVersion(
                $dstCtx,
                $dstFile,
                $binary,
                $version->getCreated(),
                $version->getCheckInComment()
            );
        } catch (\Throwable $ex) {
            // In SPO ist _vti_history häufig nicht abrufbar -> dann bleibt’s bei "Latest" kopiert.
            cpcDebug::cpc_debug("FEHLER Version $label: " . $ex->getMessage(), '-NWE1');
        }
    }
    //
    // 7) Optional: Quelle in Papierkorb
    //
    try {
        $srcFile->recycle();
        $srcCtx->executeQuery();
    } catch (\Throwable $ex) {
        cpcDebug::cpc_debug("FEHLER recycle: " . $ex->getMessage(), '-NWE1');
    }
    cpcDebug::cpc_debug("********** Ende ******", '-NWE1');
}
  /************************************************************ */
    private function uploadVersion(ClientContext $ctx, File $dstFile, string $binary, string $modified, string $comment = "")
    {
        // Datei ersetzen
        $dstFile->saveBinary($binary);
        $ctx->executeQuery();
        // Metadaten anpassen
        $item = $dstFile->getListItemAllFields();
        $ctx->load($item);
        $ctx->executeQuery();
        $item->setProperty("Modified", $modified);
        $item->update();
        $ctx->executeQuery();
        if ($comment) {
            // Minor CheckIn
            $dstFile->checkIn($comment, 1);
            $ctx->executeQuery();
        }
    }
    public function moveFilesSPO(){
        //testId = https://https://tpt-dev.ad.targa.de/move2TPT/540669
        /*if (Auth::user()->PPMitarbeiter_Id != 1){
            return;
        }*/
        $ppfileId = Input::get('ppfileId'); 
        $fromSPO =Input::get('from');
        cpcDebug::cpc_debug("File: $ppfileId  From: $fromSPO", '-NWE1');
        $from = 1;
        $to = 0;
        if ($fromSPO != 'CHN'){
            $from = 0;
            $to = 1;
        }
        $file = PPPPFiles::where ('PPPPFiles_Id', $ppfileId)->where('PPPPFiles_IsExtern', $from)->get()->first();
        if ($file){
            $pp = tPPProduktpass::find($file->PPPPFiles_PPProduktpass_Id);
            if (!$pp){
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => "Fehler beim Verschieben Kein PP",
                    ]);
                exit;
            }
            $ian = $pp->PPProduktpass_IAN;
            $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            $spoFileName = $file->PPPPFiles_SharePointLink;
            //ClientContext $srcCtx, ClientContext $dstCtx, string $srcRelUrl, string $dstFolderRelUrl
            $srcCtx = $this->getContext($from);
            $dstCtx = $this->getContext($to);
            $srcRelUrl = "/Freigegebene Dokumente/IANs/$ian".'_'."$ausm/";
            $dstFolderRelUrl = $srcRelUrl;
            $this->ensureFolderExists($dstCtx, $dstFolderRelUrl);
            $db_Filename = strtok($file->PPPPFiles_SharePointLink, '?');
            $encodedFileName = rawurlencode(rawurldecode($db_Filename));
            $srcRelUrl .=  $encodedFileName;
            cpcDebug::cpc_debug("Start Copy: $fromSPO, $ian, $ausm, $db_Filename" , '-NWE1');
            //$this->copyFileWithVersions($srcCtx, $dstCtx, $srcRelUrl, $dstFolderRelUrl);
            if (is_null($db_Filename) || strlen($db_Filename) < 3 ){
                cpcDebug::cpc_debug("WARN: Dateiname kleiner als 128 Zeichen, könnte in SPO Probleme machen: $db_Filename", '-NWE1');
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => "Datei wurde NICHT verschoben $db_Filename, da der Name zu kurz ist und in SPO Probleme machen könnte.",
                    ]);
                exit;
            }
            $result = $this->move2($fromSPO, $ian, $ausm, $db_Filename);
            cpcDebug::cpc_debug("Ready Copy", '-NWE1');
            cpcDebug::cpc_debug($result, '-NWE1');
            $file->PPPPFiles_IsExtern = 0;
            $msg = " China => Soest";
            if ($fromSPO != 'CHN'){
                $file->PPPPFiles_IsExtern = 1;
                $msg = "Soest => China";
            }
            cpcDebug::cpc_debug("New IsExtern Status: $msg ".$file->PPPPFiles_IsExtern , '-NWE1');
            $file->save();
            cpcDebug::cpc_debug("From: $fromSPO verschoben! $msg ", '-NWE1');
            header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => "Datei wurde verschoben $msg",
                    ]);
            exit;
            //$ret = 'OK Moved File: '.$file->PPPPFiles_Name." from $msg ";
            //return $ret;
        } else {
            cpcDebug::cpc_debug("File $ppfileId in der Datenbank nicht gefunden! ", '-NWE1');
        }
    }
    public function moveFileFromTPTCina2TPT(){
        if (Auth::user()->PPMitarbeiter_Id != 1){
            return;
        }
    }
    private function FolderExists(ClientContext $ctx, string $folderRelUrl): bool
    {
        try {
            cpcDebug::cpc_debug("AXY2 enter FolderExists: $folderRelUrl", '-NWE1');
            // WebRel laden
            $web = $ctx->getWeb();
            //cpcDebug::cpc_debug("A2 before load(web)", '-NWE1');
            $ctx->load($web);
            //cpcDebug::cpc_debug("A3 before executeQuery(web)", '-NWE1');
            $ctx->executeQuery();
            //cpcDebug::cpc_debug("A4 after executeQuery(web)", '-NWE1');
            $webRel = rtrim((string)$web->getServerRelativeUrl(), '/'); // "" oder "/subsite"
            $folderRelUrl = '/' . ltrim($folderRelUrl, '/');
            $folderRelUrl = rtrim($folderRelUrl, '/');
            if ($webRel !== '' && strpos($folderRelUrl, $webRel . '/') !== 0 && $folderRelUrl !== $webRel) {
                $folderRelUrl = $webRel . $folderRelUrl;
            }
            //cpcDebug::cpc_debug("A5 lookup folder: $folderRelUrl", '-NWE1');
            try {
                $folder = $ctx->getWeb()->getFolderByServerRelativeUrl($folderRelUrl);
                //cpcDebug::cpc_debug("A6 before load(folder)", '-NWE1');
                $ctx->load($folder);
                //cpcDebug::cpc_debug("A7 before executeQuery(folder)", '-NWE1');
                $ctx->executeQuery();
                cpcDebug::cpc_debug("FolderExists: True", '-NWE1');
                return true;
            } catch (\Throwable $e) {
                  cpcDebug::cpc_debug("FolderExists: False", '-NWE1');
                return false;
            }
        } catch (\Throwable $t) {
            cpcDebug::cpc_debug(
                "Z1 FolderExists crashed: " . get_class($t) . " code=" . $t->getCode() . " msg=" . $t->getMessage(),
                '-NWE1'
            );
            return false;
        }
    }
    private function ensureFolderExists(ClientContext $ctx, string $folderRelUrl): bool
    {
        try {
            cpcDebug::cpc_debug("AXY2 enter ensureFolderExists: $folderRelUrl", '-NWE1');
            // WebRel laden
            $web = $ctx->getWeb();
            //cpcDebug::cpc_debug("A2 before load(web)", '-NWE1');
            $ctx->load($web);
            //cpcDebug::cpc_debug("A3 before executeQuery(web)", '-NWE1');
            $ctx->executeQuery();
            //cpcDebug::cpc_debug("A4 after executeQuery(web)", '-NWE1');
            $webRel = rtrim((string)$web->getServerRelativeUrl(), '/'); // "" oder "/subsite"
            $folderRelUrl = '/' . ltrim($folderRelUrl, '/');
            $folderRelUrl = rtrim($folderRelUrl, '/');
            if ($webRel !== '' && strpos($folderRelUrl, $webRel . '/') !== 0 && $folderRelUrl !== $webRel) {
                $folderRelUrl = $webRel . $folderRelUrl;
            }
            //cpcDebug::cpc_debug("A5 lookup folder: $folderRelUrl", '-NWE1');
            try {
                $folder = $ctx->getWeb()->getFolderByServerRelativeUrl($folderRelUrl);
                //cpcDebug::cpc_debug("A6 before load(folder)", '-NWE1');
                $ctx->load($folder);
                //cpcDebug::cpc_debug("A7 before executeQuery(folder)", '-NWE1');
                $ctx->executeQuery();
                cpcDebug::cpc_debug("A8 folder exists", '-NWE1');
                return true;
            } catch (\Throwable $e) {
                //cpcDebug::cpc_debug("B1 folder missing, create. err=" . get_class($e) . " msg=" . $e->getMessage(), '-NWE1');
                $parts = array_values(array_filter(explode('/', $folderRelUrl), 'strlen'));
                $name  = $parts[count($parts) - 1];
                // Parent ebenfalls WebRel-korrekt
                $parentRel = rtrim($webRel . '/Freigegebene Dokumente/IANs', '/');
                //cpcDebug::cpc_debug("B2 parentRel=$parentRel childName=$name", '-NWE1');
                // Marker direkt am Anfang des Create-Try
                //cpcDebug::cpc_debug("B3 before getFolderByServerRelativeUrl(parent)", '-NWE1');
                $parent = $ctx->getWeb()->getFolderByServerRelativeUrl($parentRel);
                // WICHTIG: Erst anlegen (executeQuery), dann laden (zweiter executeQuery)
                //cpcDebug::cpc_debug("B4 before add(child)", '-NWE1');
                $child = $parent->getFolders()->add($name);
                //cpcDebug::cpc_debug("B5 before executeQuery(create)", '-NWE1');
                $ctx->executeQuery();  // legt an
                //cpcDebug::cpc_debug("B6 after executeQuery(create)", '-NWE1');
                //cpcDebug::cpc_debug("B7 before load(child)", '-NWE1');
                $ctx->load($child);
                //cpcDebug::cpc_debug("B8 before executeQuery(load child)", '-NWE1');
                $ctx->executeQuery();
                cpcDebug::cpc_debug("B9 created child url=" . $child->getProperty('ServerRelativeUrl'), '-NWE1');
                return true;
            }
        } catch (\Throwable $t) {
            cpcDebug::cpc_debug(
                "Z1 ensureFolderExists crashed: " . get_class($t) . " code=" . $t->getCode() . " msg=" . $t->getMessage(),
                '-NWE1'
            );
            return false;
        }
    }
    public function checkSPO_Rev_Error (){
        $pps = tPPProduktpass::where('PPProduktpass_IAN', 'like', '536163%ev%')->where('PPProduktpass_Ausmusterungnummer', 'like', '2604%')->where('InternerStatus', 'FIX' )->get();
        foreach ($pps as $pp){
            echo('aDir: '.$pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4).'<br>');
            $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        }
        exit;
        /*    $spoDir = "/Freigegebene Dokumente/IANs/$pp->PPProduktpass_IAN".'_'."$ausm/";
            if(!$this->FolderExists($this->getContext(0), $spoDir)){
                    echo(" existiert nicht! => OK<br>");
                    continue;
            } else {
                    echo(" existiert! => FEHLER<br>");
                echo("      Prüfe SPO-Dir: $spoDir ");
                if(!$this->FolderExists($this->getContext(0), $spoDir)){
                    echo(" existiert nicht Fehler!<br>");
                    continue;
                } else {
                    echo(" existiert!<br>");
                }
                $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $orgPP->PPProduktpass_Id)->get();
                foreach ($files as $file){
                    echo("Prüfe Datei: ".$file->PPPPFiles_Name." in $spoDir <br>");
                    $filename = $file->PPPPFiles_Name;
                    //$this->_fileExistCheck($spoDir, $filename, 0);
                }   
            }
        }*/
    }
    public function fileExistCheck(){
        //$files = PPPPFiles::where('PPPPFiles_IsExtern', 1)->orderBy('PPPPFiles_Id')->get();
        $files = PPPPFiles::where('PPPPFiles_IsExtern', 0)->where('PPPPFiles_Status', 1)->where('PPPPFiles_PPProduktpass_Id', 15858)->orderBy('PPPPFiles_Id')->get();
        $count = count($files);
        if ($count == 0){
            echo('Keine  Dateien gefunden!<br>');
            return;
        }
        $i = 1;
        //echo("Es wurden $count externe Dateien gefunden!<br>");
        echo '
<style>
    table.file-check {
        border-collapse: collapse;
        width: 100%;
        font-family: Arial, sans-serif;
        font-size: 14px;
    }
    table.file-check th,
    table.file-check td {
        border: 1px solid #ccc;
        padding: 6px 10px;
        vertical-align: top;
    }
    table.file-check th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }
    table.file-check tr:nth-child(even) {
        background-color: #fafafa;
    }
    table.file-check tr:hover {
        background-color: #eef6ff;
    }
</style>
';
        echo('<table  class="file-check">');
        echo '
<tr>
    <th>#</th>
    <th>PPFid</th>
    <th>IAN-Verzeichnis</th>
    <th>Dateiname</th>
    <th>Status</th>
</tr>';
        foreach ($files as $file){
            echo("<tr>");
            $filename = $file->PPPPFiles_Name;
            //echo("<br>------------ $filename ------------------------<br>");
            $pp = tPPProduktpass::where( 'PPProduktpass_Id', $file->PPPPFiles_PPProduktpass_Id)->where('PPProduktpass_IAN', 'not like', '%ev%')->where('PPProduktpass_IAN', 'not like', '99%')->get()->first();
            if ($pp){
                $ian = $pp->PPProduktpass_IAN;
                $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
                //echo("PP gefunden: IAN: $ian Ausmusterung: $ausm <br>");
                //$filename = "/Freigegebene Dokumente/IANs/$ian".'_'."$ausm/".$filename1; 
                $ianDir = $ian.'_'.$ausm;
                //echo("$i.) Prüfe Datei: <b>$ianDir</b>   [$filename] ");
                $i++;
                echo("<td>$i</td><td>".$file->PPPPFiles_Id."</td><td>".$file->PPPPFiles_Type.' - '.$file->PPPPFiles_SubKat.' - '.$file->PPPPFiles_Ordnung."</td><td>$ianDir</td><td>$filename</td><td>"); 
                $this->_fileExistCheck($ianDir,$filename);
                echo("</td>");
            } else {
                echo("<td>$i</td><td></td><td>$filename</td><td>✅</td><td>❌ Kein PP mit gültiger IAN gefunden</td>"); 
                $i++;
            }
            //echo("<br>---------------------- ENDE ------------------------<br>");
            echo("</tr>");
        }
        echo('</table>');
    }
    private function _fileExistCheck($ian, $filename, $context = 1 )
    {
        $ctx = $this->getContext($context);
        //echo("  => Ergbnis: ");
        $web = $ctx->getWeb();
        $ctx->load($web, ['ServerRelativeUrl']);
        try{
            $ctx->executeQuery();
        } catch (\Throwable $e) {
            echo "Fehler beim Laden der Web-Informationen: " . $e->getMessage() . "\n";
            exit;
        }
        $siteRoot = rtrim($web->getServerRelativeUrl(), '/');
        //echo('Path:<br>');
        //print_r($web->getServerRelativePath());
        //$siteRoot = rtrim($web->getServerRelativeUrl());
        //echo('SiteRoot: '.$siteRoot . "<br>");
        // Segmente sicher zusammensetzen (Leerzeichen, Umlaute etc.)
        $join = function(string $base, array $segments){
                return $base.'/'.implode('/', array_map('rawurlencode', $segments));
        };
        $serverRelativeUrl = $join($siteRoot, [
                                    'Freigegebene Dokumente',      // interner Name!
                                    'IANs',
                                    $ian,
                                    $filename
                                    ]);
        $exists = false;
        try {
            $f = $ctx->getWeb()->getFileByServerRelativeUrl($serverRelativeUrl);
            $ctx->load($f, ['Length']);   // kleines Feld, genügt zum Testen
            $ctx->executeQuery();
            $exists = true;
             echo(" $ian $filename ✅ Datei gefunden") ; 
        } catch (\Throwable $e) {
            // 404 -> existiert nicht, andere Fehler -> Auth/Path prüfen
            //echo "Fehler beim Laden der Datei: " . $e->getMessage() . "\n";
            $exists = false;
            //exit;
            echo(" $ian $filename ❌ Datei nicht gefunden") ; 
        }
    }
   // Laravel 4: AJAX/JSON-Version von projektbildCheck (keine echo/exit, gleiche Struktur wie Repair)
    public function projektbildCheck($ausmusterung = '2404')
    {
        // Optional: aus Request übernehmen (FormData POST)
        $in = \Input::get('ausmusterung');
        if (!empty($in)) {
            $ausmusterung = $in;
        }
        if (strlen($ausmusterung) < 2) {
            return \Response::json(array(
                'ok' => false,
                'message' => 'Ungültige Ausmusterung.',
            ), 422);
        }
        $pps = tPPProduktpass::where('PPProduktpass_Ausmusterungnummer', 'like', $ausmusterung . '%')
            ->where('PPProduktpass_IAN', 'not like', '%ev%')
            ->orderBy('PPProduktpass_Id')
            ->get();
        $count = count($pps);
        if ($count === 0) {
            return \Response::json(array(
                'ok' => true,
                'message' => 'Keine Projektbilder gefunden!',
                'ausmusterung' => $ausmusterung,
                'count' => 0,
                'ok_count' => 0,
                'missing_local' => 0,
                'no_bildname' => 0,
                'items' => array(),
            ), 200);
        }
        $items = array();
        $okCount = 0;
        $missingLocal = 0;
        $noBildname = 0;
        foreach ($pps as $pp) {
            $ian = (string) $pp->PPProduktpass_IAN;
            $ausm = substr((string) $pp->PPProduktpass_Ausmusterungnummer, 0, 4);
            $bildname = $pp->PPProduktpass_ProjektBild;
            $bildname = is_null($bildname) ? '' : (string) $bildname;
            $entry = array(
                'pp_id' => $pp->PPProduktpass_Id,
                'ian' => $ian,
                'ausm' => $ausm,
                'bildname' => $bildname,
                'status' => null,
                'details' => array(),
            );
            if (!empty($bildname) && strlen($bildname) > 3) {
                $exists = (bool) $this->fileExistLocal($bildname);
                if ($exists) {
                    $entry['status'] = 'ok';
                    $entry['details'][] = 'Datei existiert (local).';
                    $okCount++;
                } else {
                    $entry['status'] = 'missing_local';
                    $entry['details'][] = 'Datei nicht gefunden (local).';
                    $missingLocal++;
                }
            } else {
                // Bugfix: strlen($ausm) > 4 ist unmöglich (ausm ist max 4 Zeichen)
                $entry['status'] = 'no_bildname';
                $entry['details'][] = 'Kein Bildname angegeben.';
                $noBildname++;
            }
            $items[] = $entry;
        }
        return \Response::json(array(
            'ok' => true,
            'message' => 'Check abgeschlossen.',
            'ausmusterung' => $ausmusterung,
            'count' => $count,
            'ok_count' => $okCount,
            'missing_local' => $missingLocal,
            'no_bildname' => $noBildname,
            'items' => $items,
        ), 200);
    }
    private function fileExistLocal($filename)
    {
        $path = '/var/www/targa/public/data/uploads/'.$filename;
        if (file_exists($path)){
            return true;
        }
        return false;
    }
    /**
     * Lädt eine Datei aus SharePoint Online via Microsoft Graph herunter und speichert sie lokal.
     *
     * Benötigt: tenantId, clientId, clientSecret (App-Only / Client Credentials).
     *
     * @param string $tenantId       Azure/Entra Tenant ID (GUID)
     * @param string $clientId       App (Client) ID
     * @param string $clientSecret   Client Secret
     * @param string $siteId         Graph siteId (z.B. "contoso.sharepoint.com,xxxx,yyyy")
     * @param string $driveId        Drive ID der Dokumentbibliothek
     * @param string $sharepointPath Pfad innerhalb der Bibliothek, z.B. "Ordner1/Report.pdf"
     * @param string $destDir        Zielverzeichnis auf dem Webserver
     * @param string|null $destName  Optionaler Dateiname im Ziel (sonst basename aus sharepointPath)
     * @return string               Voller Pfad zur gespeicherten Datei
     * @throws RuntimeException
     */
    /*************************************************************** */
    private function applyProxyOptions($ch): void
{
    // Exakt wie dein funktionierender CLI-test:
    $proxyUrl = 'http://10.254.0.1:8080';
    curl_setopt_array($ch, [
        CURLOPT_PROXY => $proxyUrl,
        // HTTPS via HTTP Proxy => CONNECT Tunnel
        CURLOPT_HTTPPROXYTUNNEL => true,
        // Viele Umgebungen profitieren davon, HTTP/2 auszuschalten
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // Stabilere Timeouts
        CURLOPT_CONNECTTIMEOUT => 20,
        // Optional: falls euer Proxy Auth braucht
        // CURLOPT_PROXYUSERPWD => 'username:password',
        // Optional Debug:
        // CURLOPT_VERBOSE => true,
    ]);
}
private function getGraphAppToken(string $tenantId, string $clientId, string $clientSecret): string
{
    $cacheFile = sys_get_temp_dir() . "/graph_token_{$tenantId}_{$clientId}.json";
    if (is_file($cacheFile)) {
        $cached = json_decode((string)file_get_contents($cacheFile), true);
        if (
            is_array($cached)
            && !empty($cached['access_token'])
            && !empty($cached['expires_at'])
            && time() < ((int)$cached['expires_at'] - 60)
        ) {
            return $cached['access_token'];
        }
    }
    $tokenUrl = "https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/token";
    $postFields = http_build_query([
        'client_id'     => $clientId,
        'client_secret' => $clientSecret,
        'scope'         => 'https://graph.microsoft.com/.default',
        'grant_type'    => 'client_credentials',
    ]);
    $ch = curl_init($tokenUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $postFields,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_TIMEOUT        => 60,
    ]);
    //$this->applyProxyOptions($ch);
    $resp = curl_exec($ch);
    $http = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $errno = curl_errno($ch);
    $err   = curl_error($ch);
    curl_close($ch);
    if ($resp === false) {
        throw new RuntimeException("Token-Request fehlgeschlagen (curl errno {$errno}): {$err}");
    }
    if ($http >= 400) {
        throw new RuntimeException("Token-Request HTTP {$http}: {$resp}");
    }
    $data = json_decode($resp, true);
    if (!is_array($data) || empty($data['access_token']) || empty($data['expires_in'])) {
        throw new RuntimeException("Ungültige Token-Antwort: {$resp}");
    }
    @file_put_contents($cacheFile, json_encode([
        'access_token' => $data['access_token'],
        'expires_at'   => time() + (int)$data['expires_in'],
    ]));
    return $data['access_token'];
}
private function downloadSharepointFileToServer(
                        string $tenantId,
                        string $clientId,
                        string $clientSecret,
                        string $siteId,
                        string $driveId,
                        string $sharepointPath,
                        string $destDir,
                        ?string $destName = null
                    ): string 
    {
        $token = $this->getGraphAppToken($tenantId, $clientId, $clientSecret);
        if (!is_dir($destDir)) {
            if (!mkdir($destDir, 0775, true) && !is_dir($destDir)) {
                throw new RuntimeException("Zielverzeichnis konnte nicht erstellt werden: {$destDir}");
            }
        }
        if (!is_writable($destDir)) {
            throw new RuntimeException("Zielverzeichnis ist nicht beschreibbar: {$destDir}");
        }
        $destName = $destName ?: basename($sharepointPath);
        $destPath = rtrim($destDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $destName;
        $encodedPath = implode('/', array_map('rawurlencode', explode('/', ltrim($sharepointPath, '/'))));
        $url = "https://graph.microsoft.com/v1.0/sites/{$siteId}/drives/{$driveId}/root:/{$encodedPath}:/content";
        $fp = fopen($destPath, 'wb');
        if ($fp === false) {
            throw new RuntimeException("Konnte Zieldatei nicht öffnen: {$destPath}");
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER     => ["Authorization: Bearer {$token}"],
            CURLOPT_FILE           => $fp,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FAILONERROR    => false,
            CURLOPT_TIMEOUT        => 300,
        ]);
        $this->applyProxyOptions($ch);
        $ok    = curl_exec($ch);
        $http  = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $errno = curl_errno($ch);
        $err   = curl_error($ch);
        curl_close($ch);
        fclose($fp);
        if ($ok === false || $http >= 400) {
            @unlink($destPath);
            $details = $ok === false ? "curl errno {$errno}: {$err}" : "HTTP {$http}";
            throw new RuntimeException("Download fehlgeschlagen: {$details}");
        }
        return $destName;
    }
    /*************************************************************** */
    private function downlaodSPOFile($ian, $ausm, $filename)
    {
        // SiteId (wie bei dir)
        $siteId = 'targagmbh.onmicrosoft.com.com,23966438-0a68-4376-826c-0201232095c7,65a144d7-8f07-4558-86de-f091cdef5c6d';
        // DriveId der Dokumentbibliothek "Dokumente" (aus Get-MgSiteDrive)
        // ==> HIER deine echte Drive-ID einsetzen (nicht b!AbCd...)
        $driveId = 'b!OGSWI2gKdkOCbAIBIyCVx9dEoWUHj1hFht7wkc3vXG1frqDnDnS5R48uV-GbzZzC';
        // Pfad IN der Bibliothek (root:/{path}:)
        // Normalerweise ist "Freigegebene Dokumente" NICHT Teil des Graph-Pfads,
        // weil die Library selbst schon der Drive ist.
        // Daher: IANs/...
        $remotePath = 'IANs/' . $ian . '_' . $ausm . '/' . $filename;
        $localFile = $this->downloadSharepointFileToServer(
            'targagmbh.onmicrosoft.com',
            trim($this->AZURE_CLIENT_ID),
            $this->AZURE_CLIENT_SECRET,
            $siteId,
            $driveId,
            $remotePath,
            '/var/www/targa/public/data/uploads',
            str_random(6) . "_" .$filename
        );
        return $localFile;
    }
    public function dlSPO (){
        $filename = $this->downlaodSPOFile('999990', '2410', '999990.xml');
     }
// Laravel 4 Controller-Methode (AJAX/JSON), ohne response() Helper, ohne Typehints
// Voraussetzung: use Response; use Auth; (oder Facades voll qualifizieren)
    public function projektbildRepair($ausmusterung = '2404')
    {
        // Optional: Wenn du per AJAX POST sendest (FormData), soll das Request-Input den Default überschreiben
        $in = \Input::get('ausmusterung');
        if (!empty($in)) {
            $ausmusterung = $in;
        }
        // Access Check (kein echo/exit)
        $user = \Auth::user();
        $role = $user ? (string) $user->PPMitarbeiter_Role : '';
        if (stripos($role, 'SYSADMIN') === false) {
            return \Response::json(array(
                'ok' => false,
                'message' => 'Access denied!',
            ), 403);
        }
        // Primitive Validation
        if (strlen($ausmusterung) < 2) {
            return \Response::json(array(
                'ok' => false,
                'message' => 'Ungültige Ausmusterung.',
            ), 422);
        }
        $pps = tPPProduktpass::where('PPProduktpass_Ausmusterungnummer', 'like', $ausmusterung . '%')
            ->where('PPProduktpass_IAN', 'not like', '%ev%')
            ->orderBy('PPProduktpass_Id')
            ->get();
        $count = count($pps);
        if ($count === 0) {
            return \Response::json(array(
                'ok' => true,
                'message' => 'Keine Projektbilder gefunden!',
                'ausmusterung' => $ausmusterung,
                'count' => 0,
                'updated' => 0,
                'missing_local' => 0,
                'no_bildname' => 0,
                'items' => array(),
            ), 200);
        }
        $items = array();
        $updated = 0;
        $missingLocal = 0;
        $noBildname = 0;
        foreach ($pps as $pp) {
            $ian = (string) $pp->PPProduktpass_IAN;
            $ausm = substr((string) $pp->PPProduktpass_Ausmusterungnummer, 0, 4);
            // ACHTUNG: In deinem Original wird einmal ProjektBild und einmal Projektbild verwendet.
            // Hier lesen wir "ProjektBild", weil du es so oben ausliest.
            $bildname = $pp->PPProduktpass_ProjektBild;
            $bildname = is_null($bildname) ? '' : (string) $bildname;
            $entry = array(
                'pp_id' => $pp->PPProduktpass_Id,
                'ian' => $ian,
                'ausm' => $ausm,
                'bildname' => $bildname,
                'status' => null,
                'details' => array(),
                'newFile' => null,
            );
            if (!empty($bildname) && strlen($bildname) > 3) {
                $exists = (bool) $this->fileExistLocal($bildname);
                if ($exists) {
                    $entry['status'] = 'ok';
                    $entry['details'][] = 'Bild vorhanden (local).';
                } else {
                    $missingLocal++;
                    $entry['status'] = 'missing_local';
                    $entry['details'][] = 'Bild nicht vorhanden (local).';
                    // Dein Funktionsname: downlaodSPOFile (Typo) - bleibt wie bei dir
                    $newFile = (string) $this->downlaodSPOFile($ian, $ausm, $ian . '.JPG');
                    if (strlen($newFile) > 4) {
                        $entry['status'] = 'repaired';
                        $entry['newFile'] = $newFile;
                        $entry['details'][] = 'Neue Datei eingetragen: ' . $newFile;
                        // HIER ist der zweite Bug aus deinem Original:
                        // Du speicherst "PPProduktpass_Projektbild" (kleines b).
                        // Das kann korrekt sein, oder ein Tippfehler. Ich lasse es identisch zu deinem Original.
                        $pp->PPProduktpass_Projektbild = $newFile;
                        $pp->save();
                        $updated++;
                    } else {
                        $entry['status'] = 'download_failed';
                        $entry['details'][] = 'Download hat keine Datei geliefert.';
                    }
                }
            } else {
                $noBildname++;
                $entry['status'] = 'no_bildname';
                $entry['details'][] = 'Kein Bildname angegeben.';
            }
            $items[] = $entry;
        }
        return \Response::json(array(
            'ok' => true,
            'message' => 'Repair-Lauf abgeschlossen.',
            'ausmusterung' => $ausmusterung,
            'count' => $count,
            'updated' => $updated,
            'missing_local' => $missingLocal,
            'no_bildname' => $noBildname,
            'items' => $items,
        ), 200);
    }
    public function testMove(){
        return;
        //$result = $this->move2('CHN', '99PJM1', '2410', 'Versionen_Test.txt');
        $result = $this->moveBackError2();
        echo('<pre>');
        print_r($result);
        echo('</pre>');
    }
    private function moveBackError2(){
        $fromSPO = 'CHN'; 
        $ian = '560005' ; 
        $ausm  ='2601'; 
        $filename = '';
        //echo('HALLO');
        //exit;
        cpcDebug::cpc_debug("Start move2: $fromSPO, $ian, $ausm, $filename" , '-NWE1');
        $src  = 'IANs/' . $ian.'_'.$ausm.'/' .  $ian.'_'.$ausm;
        $destFolder = 'IANs/';// . $ian.'_'.$ausm.'/';
        $cmd = sprintf(
            'php %s %s %s %s 2>&1',
            escapeshellarg('/var/www/spo_graph/cli.php'),
            escapeshellarg($fromSPO),
            escapeshellarg($src),
            escapeshellarg($destFolder)
        );
        $output = shell_exec($cmd);
        if ($output === null) {
            return [
            'mode' => 'ERROR',
            'status' => 'E1',
            'name' => '',
            'async' => '',
        ];
            //print_r("CLI Aufruf fehlgeschlagen");
            //exit;
            //throw new RuntimeException('CLI Aufruf fehlgeschlagen');
        }
        $result = json_decode($output, true);
        if (!is_array($result) || ($result['status'] ?? '') !== 'ok') {
            return [
               'mode' => 'ERROR',
                'status' => 'E2',
                'name' => '',
                'async' => $result,
            ];
            //print_r("Move fehlgeschlagen: " . $output);
            //exit;   
            //throw new RuntimeException('Move fehlgeschlagen: ' . $output);
        }
       return($result);
       //exit;
    }
    private function move2($fromSPO = 'DE', $ian, $ausm, $filename){
        //echo('HALLO');
        //exit;
        cpcDebug::cpc_debug("Start move2: $fromSPO, $ian, $ausm, $filename" , '-NWE1');
        if (is_null($filename) || strlen($filename) < 3){
            return [
                'mode' => 'ERROR',
                'status' => 'E0',
                'name' => '',
                'async' => '',
            ];
        }
        $src  = 'IANs/' . $ian.'_'.$ausm.'/' . $filename;
        $destFolder = 'IANs/' . $ian.'_'.$ausm.'/';
        $cmd = sprintf(
            'php %s %s %s %s 2>&1',
            escapeshellarg('/var/www/spo_graph/cli.php'),
            escapeshellarg($fromSPO),
            escapeshellarg($src),
            escapeshellarg($destFolder)
        );
        $output = shell_exec($cmd);
        if ($output === null) {
            return [
            'mode' => 'ERROR',
            'status' => 'E1',
            'name' => '',
            'async' => '',
        ];
            //print_r("CLI Aufruf fehlgeschlagen");
            //exit;
            //throw new RuntimeException('CLI Aufruf fehlgeschlagen');
        }
        $result = json_decode($output, true);
        if (!is_array($result) || ($result['status'] ?? '') !== 'ok') {
            return [
               'mode' => 'ERROR',
                'status' => 'E2',
                'name' => '',
                'async' => $result,
            ];
            //print_r("Move fehlgeschlagen: " . $output);
            //exit;   
            //throw new RuntimeException('Move fehlgeschlagen: ' . $output);
        }
       return($result);
       //exit;
    }
    private function FolderExists_(ClientContext $ctx, string $folderRelUrl): bool
    {
        try {
            cpcDebug::cpc_debug("AXY2 enter FolderExists: $folderRelUrl", '-NWE1');
            // WebRel laden
            $web = $ctx->getWeb();
            //cpcDebug::cpc_debug("A2 before load(web)", '-NWE1');
            $ctx->load($web);
            //cpcDebug::cpc_debug("A3 before executeQuery(web)", '-NWE1');
            $ctx->executeQuery();
            //cpcDebug::cpc_debug("A4 after executeQuery(web)", '-NWE1');
            $webRel = rtrim((string)$web->getServerRelativeUrl(), '/'); // "" oder "/subsite"
            $folderRelUrl = '/' . ltrim($folderRelUrl, '/');
            $folderRelUrl = rtrim($folderRelUrl, '/');
            if ($webRel !== '' && strpos($folderRelUrl, $webRel . '/') !== 0 && $folderRelUrl !== $webRel) {
                $folderRelUrl = $webRel . $folderRelUrl;
            }
            //cpcDebug::cpc_debug("A5 lookup folder: $folderRelUrl", '-NWE1');
            try {
                $folder = $ctx->getWeb()->getFolderByServerRelativeUrl($folderRelUrl);
                //cpcDebug::cpc_debug("A6 before load(folder)", '-NWE1');
                $ctx->load($folder);
                //cpcDebug::cpc_debug("A7 before executeQuery(folder)", '-NWE1');
                $ctx->executeQuery();
                cpcDebug::cpc_debug("FolderExists: True", '-NWE1');
                return true;
            } catch (\Throwable $e) {
                  cpcDebug::cpc_debug("FolderExists: False", '-NWE1');
                return false;
            }
        } catch (\Throwable $t) {
            cpcDebug::cpc_debug(
                "Z1 FolderExists crashed: " . get_class($t) . " code=" . $t->getCode() . " msg=" . $t->getMessage(),
                '-NWE1'
            );
            return false;
        }
    }
    public function _checkSPO_Rev_Error_ALT (){
        echo('Starte Prüfung auf SPO-Rev-Fehler...AM26% [PLAN]<br>');
        //phpinfo();
        //exit;
        $pps = tPPProduktpass::where('PPProduktpass_Status', 'like', 'Neu')->where('PPProduktpass_IAN', 'like', '%ev%')->where('PPProduktpass_Ausmusterungnummer', 'like', '26%')->whereIn('InternerStatus', ['PLAN'])->get();
        foreach ($pps as $pp){
            //echo('Dir: '.$pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4));
            $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
           $spoDir = "/Freigegebene Dokumente/IANs/$pp->PPProduktpass_IAN".'_'."$ausm/";
            if(!$this->FolderExists($this->getContext(0), $spoDir)){
                    //echo("  ✅ existiert nicht! => OK<br>");
                    $pp->PPProduktpass_Status = 'OK';
                    $pp->save();
                    continue;
            } else {
                    //pcDebug::cpc_debug($pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4)."  ❌ existiert! => FEHLER", '-REVTEST');
            }
            $ian = substr($pp->PPProduktpass_IAN, 0, 6);
            $orgPP = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer', $pp->PPProduktpass_Ausmusterungnummer)->get()->first();
            if ($orgPP){
                $spoDir = "/Freigegebene Dokumente/IANs/$ian".'_'."$ausm/";
                //echo("      Prüfe SPO-Dir: $spoDir ");
                if(!$this->FolderExists($this->getContext(0), $spoDir)){
                    echo(" ❌ existiert nicht Fehler!<br>");
                    continue;
                } else {
                    //echo(" ✅ existiert!<br>");
                }
                $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $orgPP->PPProduktpass_Id)->get(); 
                foreach ($files as $file){
                    //echo("Prüfe Datei: ".$file->PPPPFiles_Name." in $spoDir ");
                    if ($file->PPPPFiles_IsExtern == 1){
                        echo("Prüfe Datei: ".$file->PPPPFiles_Name." Id: ".$file->PPPPFiles_Id." in $spoDir ");
                        echo("  ✅ Extern <br>");
                        continue;
                    } 
                    $filename = $file->PPPPFiles_Name;
                    if (! $this->_fileExistCheck($ian."_".$ausm, $filename, 0)){
                        $pp->PPProduktpass_Status = 'ERROR';
                        $pp->save();  
                    } 
            }
        }
        echo('<br> Fertig! <br>');
        }
    }
    //progress
    public function showCheckPage()
    {
        return View::make('spo.check_progress');
    }
    public function getCheckSPORevErrorProgress()
    {
        $jobKey = 'spo_rev_error_check';
        $progress = JobProgress::where('job_key', $jobKey)->first();
        if (!$progress) {
            return Response::json(array(
                'status' => 'idle',
                'current_step' => 0,
                'total_steps' => 0,
                'percent' => 0,
                'message' => 'Kein Lauf vorhanden'
            ));
        }
        return Response::json(array(
            'status' => $progress->status,
            'current_step' => (int) $progress->current_step,
            'total_steps' => (int) $progress->total_steps,
            'percent' => (float) $progress->percent,
            'message' => $progress->message
        ));
    }
    protected function updateProgress($jobKey, $current, $total, $message, $status = 'running')
    {
        $percent = $total > 0 ? round(($current / $total) * 100, 2) : 0;
        JobProgress::where('job_key', $jobKey)->update(array(
            'status' => $status,
            'current_step' => $current,
            'total_steps' => $total,
            'message' => $message,
            'percent' => $percent,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }
    protected function finishProgress($jobKey, $message)
    {
        JobProgress::where('job_key', $jobKey)->update(array(
            'status' => 'finished',
            'message' => $message,
            'percent' => 100,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }
    protected function failProgress($jobKey, $message)
    {
        JobProgress::where('job_key', $jobKey)->update(array(
            'status' => 'failed',
            'message' => $message,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }
  public function runCheckSPORevErrorFromCommand($jobKey, $status, $ausmFilter)
    {
        $statusArray = array_values(array_filter(array_map('trim', explode('@', $status))));
        try {
            $pps = tPPProduktpass::where('PPProduktpass_Status', 'like', 'Neu')
                ->where('PPProduktpass_IAN', 'like', '%ev%')
                ->where('PPProduktpass_Ausmusterungnummer', 'like', $ausmFilter . "%")
                ->whereIn('InternerStatus', $statusArray)
                ->get();
            $gesamt = $pps->count();
            if ($gesamt === 0) {
                $this->finishProgress(
                    $jobKey,
                    'Keine passenden Datensätze gefunden für Status: ' . $status . ' Ausm: ' . $ausmFilter
                );
                return;
            }
            $this->updateProgress(
                $jobKey,
                0,
                $gesamt,
                'Datensätze geladen. Status: ' . $status . ' Ausm: ' . $ausmFilter,
                'running'
            );
            $aktuell = 0;
            $msg = '';
            $error = false;
            foreach ($pps as $pp) {
                $pp->PPProduktpass_Status = 'TESTING';
                $pp->save();
                $aktuell++;
                $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
                $spoDir = "/Freigegebene Dokumente/IANs/" . $pp->PPProduktpass_IAN . "_" . $ausm . "/";
                $this->updateProgress(
                    $jobKey,
                    $aktuell,
                    $gesamt,
                    'Prüfe ' . $pp->PPProduktpass_IAN . ' / ' . $pp->PPProduktpass_Ausmusterungnummer,
                    'running'
                );
                if (!$this->FolderExists($this->getContext(0), $spoDir)) {
                    $pp->PPProduktpass_Status = 'OK';
                    $pp->save();
                    continue;
                }
                $ian = substr($pp->PPProduktpass_IAN, 0, 6);
                $orgPP = tPPProduktpass::where('PPProduktpass_IAN', $ian)
                    ->where('PPProduktpass_Ausmusterungnummer', $pp->PPProduktpass_Ausmusterungnummer)
                    ->first();
                if (!$orgPP) {
                    $pp->PPProduktpass_Status = 'No Org';
                    $pp->save();
                    continue;
                }
                $spoDir = "/Freigegebene Dokumente/IANs/" . $ian . "_" . $ausm . "/";
                if (!$this->FolderExists($this->getContext(0), $spoDir)) {
                    $pp->PPProduktpass_Status = 'No Org Dir';
                    $pp->save();
                    continue;
                }
                $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $orgPP->PPProduktpass_Id)->get();
                if ($files->count() === 0) {
                    $pp->PPProduktpass_Status = 'No Files';
                    $pp->save();
                    continue;
                }
                foreach ($files as $file) {
                    if ($file->PPPPFiles_IsExtern == 1) {
                        $pp->PPProduktpass_Status = 'Extern Files';
                        $pp->save();
                        continue;
                    }
                    $filename = $file->PPPPFiles_Name;
                    if (!$this->_fileExistCheck($ian . "_" . $ausm, $filename, 0)) {
                        $error = true;
                        $msg .= "Fehlende Datei: " . $filename . " im SPO-Verzeichnis " . $spoDir . '<br>';
                        $pp->PPProduktpass_Status = 'ERROR';
                        $pp->save();
                    }
                }
            }
            if ($error) {
                $msg = 'Prüfung abgeschlossen mit Fehlern:<br>' . $msg;
            } else {
                $msg = 'Prüfung erfolgreich abgeschlossen. Alle Dateien vorhanden.';
            }
            $this->finishProgress($jobKey, $msg);
        } catch (\Throwable $e) {
            $this->failProgress($jobKey, 'Fehler: ' . $e->getMessage());
            Log::error('runCheckSPORevErrorFromCommand Fehler: ' . $e->getMessage());
        }
    }
    public function startCheckSPORevError()
    {
        $jobKey = 'spo_rev_error_check';
        $status = trim(Input::get('status', 'PLAN'));
        $ausm = trim(Input::get('ausm', '26'));
        Log::info('Start mit Parametern', array(
            'status' => $status,
            'ausm' => $ausm
        ));
        $existing = JobProgress::where('job_key', $jobKey)->first();
        if ($existing && in_array($existing->status, array('starting', 'running'))) {
            return Response::json(array(
                'success' => false,
                'message' => 'Prüfung läuft bereits'
            ));
        }
        $progress = JobProgress::firstOrNew(array('job_key' => $jobKey));
        $progress->status = 'starting';
        $progress->current_step = 0;
        $progress->total_steps = 0;
        $progress->message = 'Start mit Status=' . $status . ', Ausm=' . $ausm;
        $progress->percent = 0;
        $progress->save();
        $php = '/usr/bin/php';
        $artisan = base_path() . '/artisan';
        $command = $php . ' ' . escapeshellarg($artisan)
            . ' spo:check-rev-error'
            . ' --status=' . escapeshellarg($status)
            . ' --ausm=' . escapeshellarg($ausm)
            . ' > /dev/null 2>&1 &';
        exec($command);
        return Response::json(array(
            'success' => true,
            'message' => 'Prüfung wurde gestartet'
        ));
    }
    public function resetCheckSPORevError()
    {
        $jobKey = 'spo_rev_error_check';
        JobProgress::where('job_key', $jobKey)->update(array(
            'status' => 'idle',
            'current_step' => 0,
            'total_steps' => 0,
            'percent' => 0,
            'message' => 'Zurückgesetzt',
            'updated_at' => date('Y-m-d H:i:s')
        ));
        return Response::json(array(
            'success' => true,
            'message' => 'Job zurückgesetzt'
        ));
    }
}