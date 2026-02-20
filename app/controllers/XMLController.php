<?php
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
class XMLController extends BaseController
{
    private $xml_item      = "";
    private $xml_diff      = "";
    private $xmlArray      = array();
    private $ppid;
    private $XMLPath       = "";
    private $countCalls;
    private $XMLUploadFile = "";
    private $revision;
    private $pre_revision;
    private $revision_von  = 0;
    private $debug         = false;
    private $UPLOAD_Path   = "";
    private $IsBWInquiry   = "1";
    private $schemaVersion;
    private $forceZipFile;
    private $xml = null;
    private $LTWoche = 99;
    private $LTJahr = 9999;
    private $columns2translate;
    private function p($s, $exit = true){
        if (!$this->debug) {
            return;
        }
        echo ("<br><pre>");
        print_r($s);
        echo ("</pre>");
        if ($exit) {
            // exit;
        }
    }
    public function __construct(){
        $this->XMLPath     = public_path() . "/data/import/XML/";
        $this->UPLOAD_Path = public_path() . "/data/uploads/";
        $this->countCalls  = 1;
        $this->revision    = 0;
    }
    private function readXML($inputFileName, $all = false){
        //echo($inputFileName);
        $pathParts = pathinfo($inputFileName);
        try{
            $dir = $pathParts['dirname'];
        } catch (Exception $e) {
           return FALSE;
        }
        $_filename = $pathParts['filename'] . "." . $pathParts['extension'];
        $path = "";
        if (strpos($inputFileName, "data/import") === false) {
            $path = public_path() . '/data/import/XML/';
        }
        $xmlFile = $path . $inputFileName;
        if (!file_exists($xmlFile)) {
            die("$inputFileName  Datei $xmlFile nicht gefunden (Dateiname?) !");
        }
        $this->schemaVersion = $this->getSchemaVersion($xmlFile);
        if ($all) {
            $ret = simplexml_load_file($xmlFile);
        } else {
            $ret = simplexml_load_file($xmlFile)->item;
        }
        return $ret;
    }
    private function getXMLDiff($tree1, $tree2, $result = array(), $parent = ""){
        $json   = json_encode($tree1);
        $nodes1 = json_decode($json, TRUE);
        $json   = json_encode($tree2);
        $nodes2 = json_decode($json, TRUE);
        if (Auth::User()->PMMitarbeiter_Kuerzel == 'FKE') {
            echo ("<pre>");
            print_r($nodes1);
            echo ("</pre>
              <pre>");
            print_r($nodes2);
            echo ('</pre>');
        }
        $callparent = $parent;
        $ret        = $result;
        //Haben die Bäume gleiche Anzahl Knoten
        $orgnode = $nodes1;
        $cmpnode = $nodes2;
        try {
            $c1 = count($orgnode);
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $c1 = 0;
        }
        try {
            $c2 = count($cmpnode);
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $c2 = 0;
        }
        $nodeOldName = "OLD";
        $nodeNewName = "NEW";
        $nmax        = $orgnode;
        $nmin        = $cmpnode;
        if ($c1 < $c2) {
            //Neu hat mehr Konten
            $nmax        = $cmpnode;
            $nmin        = $orgnode;
            $nodeOldName = "OLD";
            $nodeNewName = "NEW";
        }
        $i = 0;
        if (is_array($nmax)) {
            foreach ($nmax as $key => $child) {
                $childname = $key;
                $child2    = "";
                if (isset($nmin[$key]) and is_array($nmin)) {
                    $child2 = $nmin[$key];
                    //$child2 = $nmin;
                } else {
                    $child2 = $nmin;
                    if ($i > 0) {
                        $child2 = "Empty";
                    }
                }
                if (!is_array($child)) {
                    //echo("<p style='color:darkturquoise;'> Leaf gefunden: $childname  <br>$child  </p><br>");
                    //echo("<p style='color:darkturquoise;'> Vergleichmit :  $child2  </p><br>");
                    if (isset($child2)) {
                        if ($child !== $child2) {
                            //echo("<p style='color:red;'> <b>DIFF :  $child2  </b></p><br>");
                            $ret[$callparent][$key][$nodeOldName] = htmlentities($child);
                            if (!is_array($child2)) {
                                $ret[$callparent][$key][$nodeNewName] = html_entity_decode($child2);
                            } else {
                                $ret[$callparent][$key][$nodeNewName] = $child2;
                            }
                        }
                    } else {
                        //echo("<p style='color:red;'> <b>DIFF :  $key  </b> Empty $nodeOldName </p><br>");
                        $ret[$callparent][$key][$nodeOldName] = htmlentities($child);
                        $ret[$callparent][$key][$nodeNewName] = "CC";
                    }
                } else {
                    if (isset($child2)) {
                        $newparent = $callparent . " = = > " . $childname;
                        //echo("<p style='color:mediumorchid;'> Subtree gefunden: $childname<br>$newparent </p><br>");
                        $ret       = $this->getXMLDiff($child, $child2, $ret, $newparent);
                    } else {
                        //echo("<p style='color:red;'> <b>DIFF :  $key  </b> Empty $nodeOldName </p><br>");
                        $ret[$callparent][$key][$nodeOldName] = $child;
                        $ret[$callparent][$key][$nodeNewName] = "Empty";
                    }
                    //echo("<p style='color:mediumorchid;'> Zurück von Subtree: $childname<br>$newparent </p><br>");
                }
                $i++;
            }
        }
        return $ret;
    }
    private function debugTree($str){
        if (0) {
            print_r($str);
            echo ("<br>");
        }
    }
    private function getXMLDiffNew($tree1, $tree2, $result = array(), $parent = ""){
        //$this->debugTree("<b>CALL: " . $parent . "</b>");
        $callparent = $parent;
        $ret        = $result;
        $json    = json_encode($tree1);
        $orgtree = json_decode($json, TRUE);
        $json2   = json_encode($tree2);
        $cmptree = json_decode($json2, TRUE);
        /* echo("<br>----------------------------------------------------------<br><pre>");
          print_r($tree2);
          echo("</pre> <br>----------------------------------------------------------<br>");
          exit; */
        if (!is_array($orgtree)) {
            //echo("No Array Orgtree".$orgtree ."<br>");
            $ret[$callparent]['NOARR']['OLD'] = $orgtree;
            $ret[$callparent]['NOARR']['NEW'] = '??';
            $ret[$callparent]['NOARR']['DIFF'] = '??';
            $ret[$callparent]['NOARR']['PARENT'] = $callparent;
            $ret[$callparent]['NOARR']['CUSTOMNAME'] = '';
            return $ret;
        }
        foreach ($orgtree as $key => $subtree) {
            //echo("<b>$key </b> <br>-----------------------------<br>");
            //print_r($subtree[0]);
            //echo("</pre><br>############################################################<br>"); 
            if (!isset( $ret[$callparent][$key]['OLD'])){
                if (!isset($cmptree[$key])) {
                    if (is_array($subtree)) {
                        $ret[$callparent][$key]['OLD'] = $key;
                        $ret[$callparent][$key]['NEW'] = 'NODATA';
                        $ret[$callparent][$key]['DIFF'] = 'NODATA';
                        $ret[$callparent][$key]['PARENT'] = $callparent;
                        $ret[$callparent][$key]['CUSTOMNAME'] = ServiceProvider::getCustomNameXMLNode($key);
                        //return $ret;
                    } else {
                        $ret[$callparent][$key]['OLD'] = $subtree;
                        $ret[$callparent][$key]['NEW'] = 'NODATA';
                        $ret[$callparent][$key]['DIFF'] = 'NODATA';
                        $ret[$callparent][$key]['PARENT'] = $callparent;
                        $ret[$callparent][$key]['CUSTOMNAME'] =  ServiceProvider::getCustomNameXMLNode($key);
                    }
                } else {
                    if (is_array($subtree) and is_array($cmptree[$key])) {
                        $newparent = "$callparent->$key";
                        $ret = $this->getXMLDiffNew($subtree, $cmptree[$key], $ret, $newparent);
                    }
                    if (is_array($subtree) and !is_array($cmptree[$key])) {
                        $ret[$callparent][$key]['OLD'] = "Struktur Differenz: " . $key;
                        $ret[$callparent][$key]['NEW'] = $cmptree[$key];
                        $ret[$callparent][$key]['DIFF'] = $cmptree[$key];
                        $ret[$callparent][$key]['PARENT'] = $callparent;
                        $ret[$callparent][$key]['CUSTOMNAME']   =  ServiceProvider::getCustomNameXMLNode($key);
                    }
                    if (!is_array($subtree) and is_array($cmptree[$key])) {
                        $ret[$callparent][$key]['OLD'] = $subtree;
                        $ret[$callparent][$key]['NEW'] = "Struktur Differenz: " . $key;
                        $ret[$callparent][$key]['DIFF'] = "Struktur Differenz: " . $key;
                        $ret[$callparent][$key]['PARENT'] = $callparent;
                        $ret[$callparent][$key]['CUSTOMNAME']  =  ServiceProvider::getCustomNameXMLNode($key);
                    }
                    if (!is_array($subtree) and !is_array($cmptree[$key])) {
                        if (strpos($subtree, $cmptree[$key]) === false) {
                            $ret[$callparent][$key]['OLD'] =  $subtree;
                            $ret[$callparent][$key]['NEW'] =  $cmptree[$key];
                            $ret[$callparent][$key]['DIFF'] =  ServiceProvider::diff($subtree, $cmptree[$key]);
                            $ret[$callparent][$key]['PARENT'] = $callparent;
                            $ret[$callparent][$key]['CUSTOMNAME'] = ServiceProvider::getCustomNameXMLNode($key);
                        } else {
                            // $this->debugTree("Gleich: $key => $subtree  != $cmptree[$key] ");
                        }
                    }
                }
            }
        }
        //$this->debugTree(print_r($ret, true));
        return $ret;
    }
    private function getXMLNodeId(){
        $ret = array('quantity' => array('country', 'code'));
        return $ret;
    }
    private function getXMLaDiff($tree1, $parent = ""){
        echo ("<b>CALL: " . $parent . "</b><br>");
        $json       = json_encode($tree1);
        $array_json = json_decode($json, TRUE);
        //var_dump($array_json);
        $callparent = $parent;
        $nodes1 = $tree1->children();
        $i = 0;
        foreach ($nodes1 as $child) {
            $childname = $child->getName();
            if ($child->count() === 0) {
                echo ("<p style = 'color:darkturquoise;'> Leaf gefunden: $childname <br>$child </p><br>");
            } else {
                $newparent = $callparent . "->" . $childname;
                echo ("<p style = 'color:mediumorchid;'> Subtree gefunden: $childname<br>$newparent </p><br>");
                $ret       = $this->getXMLDiff($child, $newparent);
                echo ("<p style = 'color:mediumorchid;'> Zurück von Subtree: $childname<br>$newparent </p><br>");
            }
        }
        return true;
    }
    private function getXMLDiff1($tree1, $tree2){
        echo ("$this->countCalls . Aufruf<br>");
        $this->countCalls++;
        $nodes1 = $tree1->children();
        $nodes2 = $tree2->children();
        //echo("T1: #Kinder => " . $nodes1->count() . "<br>");
        $ret = array();
        foreach ($nodes1 as $child) {
            $subnodes = $child->children();
            $name     = $child->getName();
            echo ("Node: $name <br>");
            if ($subnodes->count() === 0) {
                echo ("<p style='color:lime;'> Leaf gefunden: $name </p><br>");
                //Blatt
                //Vergleiche mit tree2;
                $v1 = (string) $nodes1->$name;
                $v2 = (string) $nodes2->$name;
                if ($v1 !== $v2) {
                    echo ("<p style='color:red;'> <b>Diff: $name " . $nodes1->$name . " != " . $nodes2->$name . "</b></p>");
                    $ret[$name]["T1"] = $nodes1->$name;
                    $ret[$name]["T2"] = $nodes2->$name;
                }
            } else {
                $t1 = $tree1->$name;
                $c = $t1->count();
                echo ("<p style='color:blue;'> Subtree gefunden: $name   $c Kinder </p><br>");
                var_dump($t1);
                $t2 = $tree2->$name;
                var_dump($t2);
                for ($i = 0; $i < $c; $i++) {
                    $ret = $this->getXMLDiff($t1[$i], $t2[$i]);
                }
            }
        }
        return $ret;
    }
    private function isNewVersionPP($ian){
        $count    = PPProduktpass::Where('PPProduktpass_IAN', "=", $ian)->count();
        if ($count >= 1) {
            return false;
        }
        return true;
    }
    private function getID($ian, $ausm = ''){
        if (strlen($ausm) > 4) {
            $ausm = substr($ausm, 0, 4);
        }
        if ($ausm == '') {
            $pp = PPProduktpass::Where('PPProduktpass_IAN', "=", $ian)->get()->first();
        } else {
            $pp = PPProduktpass::Where('PPProduktpass_IAN', "=", $ian)->Where('PPProduktpass_Ausmusterungnummer', "like", "$ausm%")->get()->first();
        }
        //var_dump($pp);
        if ($pp) {
            return $pp->PPProduktpass_Id;
        }
        return 0;
    }
    private function getIDInq($ian){
        $pp = tPPProduktpass::Where('PPProduktpass_IAN', "=", "I-" . $ian)->get()->first();
        //var_dump($pp);
        if ($pp) {
            return $pp->PPProduktpass_Id;
        }
        return 0;
    }
    private function copyPP($ian){
        $id = $this->getID($ian);
        $pc = new ProjectsController();
        $pc->copyPP($id, "Import", 0);
    }
    private function copyPPInq($ian){
        $id = $this->getIDInq($ian);
        $pc = new ProjectsController();
        $pc->copyPP($id, "Import", true, true);
    }
    private function getXMLValues($xml, $path, $node) {}
    private function getXMLVarValues($table){
        $version = "X";
        if ($this->schemaVersion == "1.0" or $this->schemaVersion == "1.24" or $this->schemaVersion == "8.7.4" or $this->schemaVersion == "8.10.1") {
            $version = "2022.01";
        }
        if (substr($this->schemaVersion, 0, 1) == "3") {
            $version = "2021.01";
        }
        if ($version == "X") {
            echo ("Unbekannte XML Version!");
            exit;
        }
        $xmlnodes = DB::table('XMLConverterMitVersion')->where("XMLConverter_DBTable", "=", $table)->where('XMLConverter_Version', '=', $version)->whereNotNull("XMLConverter_XMLNode")->get();
        if (!$xmlnodes) {
            return false;
        }
        $all = array();
        $elemNdx = 0;
        foreach ($xmlnodes as $node) {
            $elems[$elemNdx++] = array("field" => $node->XMLConverter_DBColumn, "XMLElem" => $this->parseXMLElem($node->XMLConverter_XMLNode));
            $this->p($elems[$elemNdx - 1], false);
        }
        $cElem = $this->findElemType($elems, "*");
        $c     = 0;
        if ($cElem) {
            $this->p("COUNT", false);
            $this->p($elems[0]['XMLElem'], false);
            $c = $this->countStarElems($elems[0]['XMLElem']);
        }
        if ($c == 0) {
            $this->p("C==0", false);
            foreach ($elems as $elem) {
                $eX = $this->getXMLValue($elem['XMLElem'], -1, -1);
                $this->setAll($all, 0, 0, $elem['field'], $eX);
            }
        } else {
            foreach ($elems as $elem) {
                $this->p("ELEM C: $c", false);
                $this->p($elem, false);
                for ($i = 0; $i < $c; $i++) {
                    $cElem = $this->findElemType($elems, "!");
                    $c2    = 0;
                    if ($cElem) {
                        $c2 = $this->countExmarkElems($cElem['XMLElem'], $i);
                    }
                    if ($c2 == 0) {
                        $this->p("C2==0", false);
                        foreach ($elems as $elem) {
                            $this->setAll($all, $i, 0, $elem['field'], $this->getXMLValue($elem['XMLElem'], $i, -1));
                        }
                    } else {
                        for ($j = 0; $j < $c2; $j++) {
                            $this->setAll($all, $i, $j, $elem['field'], $this->getXMLValue($elem['XMLElem'], $i, $j));
                        }
                    }
                }
            }
        }
        //cpcDebug::dd($all);
        return $all;
    }
    private function setAll(&$all, $i, $j, $field, $val){
        $all[$i][$j][$field] = $val;
        if (isset($all[$i][$j][$field]) and strlen($all[$i][$j][$field]) > 0) {
            //$all[$i][$j][$field] = "X" . $val;
        } else {
            //$all[$i][$j][$field] = "Y" . $val;
        }
    }
    private function getXMLVarValues_ORG($table){
        $xmlnodes = XMLConverter::where("XMLConverter_DBTable", "=", $table)->whereNotNull("XMLConverter_XMLNode")->get();
        if (!$xmlnodes) {
            return false;
        }
        $all = array();
        $elemNdx = 0;
        foreach ($xmlnodes as $node) {
            $elems[$elemNdx++] = array("field" => $node->XMLConverter_DBColumn, "XMLElem" => $this->parseXMLElem($node->XMLConverter_XMLNode));
        }
        $cElem = $this->findElemType($elems, "*");
        $c     = 0;
        if ($cElem) {
            $this->p("COUNT", false);
            $this->p($elems[0]['XMLElem'], false);
            $c = $this->countStarElems($elems[0]['XMLElem']);
        }
        if ($c == 0) {
            $this->p("C==0", false);
            foreach ($elems as $elem) {
                $this->setAll($all, 0, 0, $elem['field'], $this->getXMLValue($elem['XMLElem'], -1, -1));
            }
        } else {
            foreach ($elems as $elem) {
                $this->p("ELEM C: $c", false);
                $this->p($elem, false);
                for ($i = 0; $i < $c; $i++) {
                    $cElem = $this->findElemType($elems, "!");
                    $c2    = 0;
                    if ($cElem) {
                        $c2 = $this->countExmarkElems($cElem['XMLElem'], $i);
                    }
                    if ($c2 == 0) {
                        $this->p("C2==0", false);
                        foreach ($elems as $elem) {
                            $this->setAll($all, $i, 0, $elem['field'], $this->getXMLValue($elem['XMLElem'], $i, -1));
                        }
                    } else {
                        for ($j = 0; $j < $c2; $j++) {
                            $this->setAll($all, $i, $j, $elem['field'], $this->getXMLValue($elem['XMLElem'], $i, $j));
                        }
                    }
                }
            }
        }
        return $all;
    }
    private function getXMLValue($aNode, $ndx1, $ndx2){
        $elem = $this->xmlArray;
        $path = "";
        foreach ($aNode as $n) {
            $path .= $n['elem'] . "->";
            if (!isset($elem[$n['elem']])) {
                //echo("Ret Fehler 1 $path <br>XXXXXXXXXXXXXXXXXXXX<br>");
                return false;
            }
            switch ($n['ndx']) {
                case "*":
                    if (isset($elem[$n['elem']][$ndx1])) {
                        $elem = $elem[$n['elem']][$ndx1];
                    } else {
                        $elem = $elem[$n['elem']];
                        //echo("Ret Fehler 4  $path  <br>XXXXXXXXXXXXXXXXXXXXXXXX<br>");
                        //return false;
                    }
                    break;
                case "!":
                    if (isset($elem[$n['elem']][$ndx2])) {
                        $elem = $elem[$n['elem']][$ndx2];
                    } else {
                        $elem = $elem[$n['elem']];
                    }
                    break;
                case -1:
                    $elem = $elem[$n['elem']];
                    break;
                default:
                    if (isset($elem[$n['elem']][$n['ndx']])) {
                        if (is_array($elem[$n['elem']])) {
                            $elem = $elem[$n['elem']][$n['ndx']];
                        } else {
                            $elem = $elem[$n['elem']];
                        }
                    } else {
                        if (isset($elem[$n['elem']])) {
                            if ($n['ndx'] == 0) {
                                $elem = $elem[$n['elem']];
                            } else {
                                // echo("Ret Fehler 12 $path  :  (" . $n['elem'] . " ndx: " . $n['ndx']) . " ) <br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>";
                                return false;
                            }
                        } else {
                            //echo("Ret Fehler 7  $path  : (" . $n['elem'] . " ndx: " . $n['ndx']) . " ) <br>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX<br>";
                            return false;
                        }
                    }
                    break;
            }
        }
        if (isset($elem)) {
            if (is_array($elem)) {
                //echo("Ret  Fehler 99 $path  <br>XXXXXXXXXXXXXXXXXXXX<br>");
                return false;
            }
            $sReturn = (string) $elem;
            //echo("Ret ErgOK" . $sReturn . "<br>$path <br>------------------------------------<br>");
            return (string) $sReturn;
        } else {
            //echo("Ret  Fehler 8 $path <br>XXXXXXXXXXXXXXXXXXXX<br>");
            return false;
        }
    }
    private function countStarElems($aNode){
        //cpcDebug::dd("countStar");
        //cpcDebug::dd($aNode);
        $elem = $this->xmlArray;
        foreach ($aNode as $n) {
            //echo($n['elem'] . " -> " . $n['ndx'] . "<br>");
            if (!isset($elem[$n['elem']])) {
                //echo("Return bei 1<br>");
                return 0;
            }
            switch ($n['ndx']) {
                case "*":
                    $elem = $elem[$n['elem']];
                    //echo("Return bei 2 Erg: " . (count($elem)) . "<br>");
                    $this->p(array_keys($elem), false);
                    $keys = array_keys($elem);
                    if (is_int($keys[0]) and $keys[0] == 0) {
                        return (count($elem));
                    }
                    return 1;
                case -1:
                    $elem = $elem[$n['elem']];
                    break;
                default:
                    $elem = $elem[$n['elem']][$n['ndx']];
                    break;
            }
        }
        //echo("Return bei 3<br>");
        return 0;
    }
    private function countExmarkElems($aNode, $i){
        $elem = $this->xmlArray;
        $bc = "";
        foreach ($aNode as $n) {
            $bc .= $n['elem'];
            if (!isset($elem[$n['elem']])) {
                return 0;
            }
            switch ($n['ndx']) {
                case "*":
                    if (isset($elem[$n['elem']][$i])) {
                        $elem = $elem[$n['elem']][$i];
                    } else {
                        $elem = $elem[$n['elem']];
                    }
                    break;
                case "!":
                    $elem = $elem[$n['elem']];
                    return (count($elem));
                case -1:
                    $elem = $elem[$n['elem']];
                    break;
                default:
                    $elem = $elem[$n['elem']][$n['ndx']];
                    break;
            }
        }
        return 0;
    }
    private function findElemType($elems, $type){
        $t = 1;
        if ($type == "!") {
            $t = 2;
        }
        foreach ($elems as $elem) {
            if ($this->getTypeOfElem($elem) >= $t) {
                return $elem;
            }
        }
        return false;
    }
    private function getTypeOfElem($elem){
        $type = 0;
        foreach ($elem['XMLElem'] as $x) {
            if ($x['ndx'] === "*" and $type <= 1) {
                $type = 1;
            }
            if ($x['ndx'] == "!") {
                $type = 2;
            }
        }
        return $type;
    }
    private function parseXMLElem($node){
        $tmpNode = $node;
        //echo("#####Node: $node<br>");
        $aNodes = explode("@", $tmpNode);
        //var_dump($aNodes);
        $ret = array();
        foreach ($aNodes as $n) {
            $aPos = strpos($n, "[");
            if ($aPos !== false) {
                $elem = substr($n, 0, $aPos);
                $ndx  = substr($n, $aPos, strlen($n) - 1);
                $ndx  = str_replace("[", "", $ndx);
                $ndx  = str_replace("]", "", $ndx);
            } else {
                $elem = $n;
                $ndx  = -1;
            }
            $ret[] = array("elem" => $elem, "ndx" => $ndx);
        }
        return $ret;
    }
    public function compareXMLExt($ppid, $compareFileId){
        $pp     = PPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
        $file1  = $pp->PPProduktpass_AktExcel;
        $ppf    = PPPPFiles::where("PPPPFiles_Id", "=", $compareFileId)->get()->first();
        $file2  =  $ppf->PPPPFiles_Name;
        $subdata['diffs'] = null;
        $subdata['message'] = "";
        $file1 = public_path() . "/data/import/XML/" . $file1;
        $file2 = public_path() . "/data/import/XML/" . $file2;
        if (file_exists($file2) and !is_dir($file2) and file_exists($file1) and !is_dir($file1)) {
            $xml_item = $this->readXML($file2);
            $xml_diff = $this->readXML($file1);
            try {
                $subdata['diffs'] = $this->getXMLDiffNew($xml_item, $xml_diff, array(), "item");
            } catch (Exception $e) {
                echo ($e->getMessage());
                echo ("<br>Fehler beim Vergleich!<br>");
                exit;
            }
            $subdata['message'] = "";
        } else {
            $subdata['message'] = "Produktpass IAN: " . $pp->PPProduktpass_IAN . " eingelesen. <br> Keine XML-Vorversion vorhanden.<br><br> <a href='http://" . $_SERVER['SERVER_NAME'] . "/show/" . $ppid . "'>Link zum Produktpass</a>";
        }
        $xml  = new XMLController;
        $Sals = $xml->getSALs();
        View::share('SALs', $Sals);
        $data['content'] = View::make('helpers.printDiffs')->with('diffs', $subdata);
        //return $data['content'];
        return View::make('main', $data);
    }
    public function compareXMLFiles($fileId1, $fileId2){
        $ppf1    = PPPPFiles::where("PPPPFiles_Id", "=", $fileId1)->get()->first();
        $file1  =  $ppf1->PPPPFiles_Name;
        $ppf2    = PPPPFiles::where("PPPPFiles_Id", "=", $fileId2)->get()->first();
        $file2  =  $ppf2->PPPPFiles_Name;
        $subdata['diffs'] = null;
        $subdata['message'] = "";
        $file1 = public_path() . "/data/import/XML/" . $file1;
        $file2 = public_path() . "/data/import/XML/" . $file2;
        if (file_exists($file2) and !is_dir($file2) and file_exists($file1) and !is_dir($file1)) {
            $xml_item = $this->readXML($file2);
            $xml_diff = $this->readXML($file1);
            try {
                $v1 = $this->getXMLDiffNew2X($xml_item, $xml_diff, array(), "item");
                //$v2 = $this->getXMLDiffNew2($xml_item, $xml_diff, array(), "item");
                //$v2 = $this->getXMLDiffNew($xml_diff,$xml_item, array(), "item");
                $subdata['diffs'] = $v1;
                //$subdata['diffs'] = $this->getXMLDiffNew($xml_item, $xml_diff, array(), "item");
            } catch (Exception $e) {
                echo ($e->getMessage());
                echo ("<br>Fehler beim Vergleich!<br>");
                exit;
            }
            $subdata['message'] = "";
        } else {
            $subdata['message'] = "Produktpass IAN: " . $ppf1->PPPPFiles_PPProduktpass_Id . " eingelesen. <br> Keine XML-Vorversion vorhanden.<br><br> <a href='http://" . $_SERVER['SERVER_NAME'] . "/show/" . $ppf1->PPPPFiles_PPProduktpass_Id . "'>Link zum Produktpass</a>";
        }
        $xml  = new XMLController;
        $Sals = $xml->getSALs();
        View::share('SALs', $Sals);
        $data['content'] = View::make('helpers.printDiffs')->with('diffs', $subdata);
        //return $data['content'];
        return View::make('main', $data);
    }
    private function getFIdFromFilename($path, $ppid){
        cpcDebug::cpc_debug($path,'@Files');
        $path_parts = pathinfo($path);
        $filename = $path_parts['basename'];
        $f = PPPPFiles::where('PPPPFiles_Name', $filename)->where('PPPPFiles_PPProduktpass_Id', $ppid)->get()->first();
        if ($f){
            return $f->PPPPFiles_Id;
        }
        return 0;
    }
    public function compareXML($ppid = 0, $file2 = "", $message = "", $retDiff = false, $email = false){
        if ($ppid === 0) {
            $ppid   = Input::get('ppid');
            $pp     = PPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
            $file1  = $pp->PPProduktpass_AktExcel;
            $fileId = Input::get('filecompare');
            $ppf    = PPPPFiles::where("PPPPFiles_Id", "=", $fileId)->get()->first();
            $file2  = $ppf->PPPPFiles_TPTFilenameOld;
            $ppf->save();
        } else {
            $pp = tPPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
            $file1 =  $pp->PPProduktpass_AktExcel;
            $ppvor = tPPProduktpass::where("PPProduktpass_Id", "=", $pp->PPProduktpass_RevisionVon_PPProduktpass_Id)->get()->first();
            $file2 = $ppvor->PPProduktpass_AktExcel;
        }
        //($ppid, $ian, $file1, $file2, $message, $retDiff)
        return $this->_diffXML ($ppid, $pp->PPProduktpass_IAN, $file1, $file2, $message, $retDiff, true, $email);
        //return View::make('main', $data);
    }
    private function doInserts($ins){
        $this->setTranslateColumns();
        $tab  = 'tPPProduktpass';
        $ppid = $this->insert($tab, $ins[$tab]);
        $aTables = array('PPProduktpass_Qualitaet', 'PPProduktpass_Style', 'PPProduktpass_Sortierung', 'PPProduktpass_Menge', 'PPXML_OSMengen', 'PPXML_Mengen', 'PPProduktpass_KLLink', 'PPOrder', 'PPOrderWeights', 'PPLsv', 'PPAssortments', 'retailPackaging');
        foreach ($aTables as $tab) {
            //var_dump($ins[$tab]); echo("<br>--------------------------------<br>");
            try {
                $this->insert($tab, $ins[$tab], $ppid);
            } catch (Exception $ex) {
                echo ("Fehler beim einlesen der Tabelle $tab <br>");
                exit;
            }
            //
        }
        return $ppid;
    }
    private function _minLt($lt1, $lt2){
        //echo(" _minLT ( $lt1 , $lt2) => $lt2 ");
        $ltret = '88/8888';
        if (strlen($lt1) != 7) {
            //echo("$lt2");
            //echo('1 #');
            return $lt2;
        }
        if (strlen($lt2) != 7) {
            //echo("$lt1 #");
            //echo('2 #');
            return $lt1;
        }
        if (strpos($lt1, '/') === false) {
            //echo("$lt2 #");
            //echo('3 #');
            return $lt2;
        }
        if (strpos($lt2, '/') === false) {
            //echo("$lt1 #");
            //echo('4 #');
            return $lt1;
        }
        $lt1a = explode('/', $lt1);
        $lt2a = explode('/', $lt2);
        if (count($lt1a) != 2) {
            //echo('5 #');
            return $lt2;
        }
        if (count($lt2a) != 2) {
            //echo('6 #');
            return $lt1;
        }
        if ($lt1a[1] > $lt2a[1]) {
            //echo('7 #');
            return $lt2;
        }
        if ($lt2a[1] > $lt1a[1]) {
            //echo("$lt1 #");
            //echo('8 #');
            return $lt1;
        }
        if ($lt1a[0] <= $lt2a[0]) {
            //echo("$lt1 #");
            //echo('9 #');
            return $lt1;
        } else {
            //echo("$lt2 #");
            //echo('10 #');
            return $lt2;
        }
        //echo("HMMM: $ltret #");
        //echo('11 #');
        return $ltret;
    }
    private function getMinLiefertermin($ppid, $ltPlan = null){
        $m = $this->LTWoche;
        $y = $this->LTJahr;
        $ret = array($m, $y);
        $minlt = $m . "/" . $y;
        if ($ltPlan !== null) {
            if (!is_null($ltPlan)) {
                //cpcDebug::cpc_debug("LTPP: $ltPlan");
                $a_lt = explode('/', $ltPlan);
                //cpcDebug::cpc_debug($a_lt);
                if (count($a_lt) == 2) {
                    $m = $a_lt[0];
                    $y =  "20" . $a_lt[1];
                    $minlt = "$m/$y";
                }
            }
        } else {
            cpcDebug::cpc_debug("PP zu $ppid nicht gefunden!");
        }
        cpcDebug::cpc_debug("w: $m Y: $y PPID: $ppid MinLT: $minlt", "-MinLT");
        $mengen_count = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', "=", $ppid)->whereNotNull('PPProduktpass_Menge_DeliveryWeek')->count();
        if ($mengen_count ==  0) {
            $pp = tPPProduktpass::where("PPProduktpass_Id", $ppid)->get()->first();
            $ltThema = $this->calcTempLT($pp, false);
            if (!is_null($ltThema) ){
                $m = $ltThema['Woche'];
                $y = $ltThema['Jahr'];
            }
             cpcDebug::cpc_debug("LT aus Thema  w: $m Y: $y PPID: $ppid ", "-MinLT");
            return array($m, $y);
        }
        $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', "=", $ppid)->get();
        foreach ($mengen as $menge) {
            $lt = $menge->PPProduktpass_Menge_DeliveryWeek;
            //echo("$ppid  => $menge->PPProduktpass_Menge_Id  => ");
            if (!is_null($lt)) {
                //echo(" [ $lt ] >>>>");
                if (strlen($lt) == 5) {
                    if (strpos($lt, '/') !== false) {
                        $lta = explode("/", $lt);
                        try {
                            $ltw = $lta[0];
                            $lty = 2000 + intval($lta[1]);
                            //echo("Berechne ( $minlt ,  ". $ltw."/".$lty.") =>" );
                            $minlt = $this->_minLt($minlt, $ltw . "/" . $lty);
                            //echo(" $minlt OK<br>");
                        } catch (ErrorException $e) {
                            //echo("$lt Catch<br>");
                            //print("Caught the error: ".$e->getMessage."<br />\r\n" );
                        }
                        //echo("OK<br>");
                    } else {
                        //echo('NI / <br>');
                    }
                } else {
                    //echo("not 5<br>");
                }
            } else {
                //echo("NULL<br>");
            }
            /*if (!is_null($lt)){
                if (strlen(trim($lt)) == 5){
                    $lta = explode($lt,'/');
                    $ltw = $lta[0];
                    $lty = $lta[1]+2000;
                    //echo('Good ====');
                } 
                //echo("$minlt -> $ltw $lty  => ");
                $minlt = $this->_minLt($minlt, "$ltw/$lty");
                //echo($minlt."<br>");
            } else {
                //echo("Null<br>");
            }*/
        }
        //echo("Return: $minlt<br>");
        //return "20/2023";
        $ret = explode("/", $minlt);
        if (count($ret) != 2) {
            return array('99', "9999");
        }
        return $ret;
    }
    private function getLaenderblock($land){
        $lb = PPLaenderbloecke::where('PPLaenderbloecke_Land', '=', $land)->get()
            ->first();
        if ($lb) {
            return $lb->PPLaenderbloecke_Block;
        }
        return "N.N.";
    }
    private function getMinVerpackungseinheit($ppid){
        $menge = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $ppid)->where("PPProduktpass_Menge_Country", "not like", "OS%")->get()->first();
        if ($menge) {
            return $menge->PPProduktpass_Menge_TotalSalePerUnit;
        }
        return 0;
    }
    private function handlePP($ppid){
        $pc    = new ProjectsController();
        $total = $pc->getMengeTotal($ppid);
        $pp = tPPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
        $pp_vorgaenger = tPPProduktpass::where("PPProduktpass_Id", "=", $this->revision_von)->get()->first();
        if ($pp_vorgaenger) {
            $pp->PPProduktpass_PPProjekte_Projekt = $pp_vorgaenger->PPProduktpass_PPProjekte_Projekt;
        } else {
            $pp->PPProduktpass_PPProjekte_Projekt = $pp->PPProduktpass_IAN;
        }
        $pp->PPProduktpass_Verpackungseinheit = $this->getMinVerpackungseinheit($ppid);
        $pp->PPProduktpass_GesamtMenge        = $total;
        //$ltXML                                = $pp->PPProduktpass_Liefertermin;
        //XML Import Fehlr bei Logs und Zertifikaten
        for ($cLogo = 2; $cLogo <= 5; $cLogo++) {
            $attr = "PPProduktpass_Logos" . $cLogo;
            if ($pp->PPProduktpass_Logos == $pp->$attr) {
                $pp->{$attr} = "";
            }
        }
        for ($cLogo = 2; $cLogo <= 5; $cLogo++) {
            $attr = "PPProduktpass_ZertifizierungEigenschaften" . $cLogo;
            if ($pp->PPProduktpass_Zertifizierungen == $pp->$attr) {
                $pp->$attr = "";
            }
        }
        $ltXML = $this->getMinLiefertermin($ppid);
        cpcDebug::cpc_debug("Liefertermin2: " . $ltXML[0] . "/" . $ltXML[1], '@CalcLT');
        $pp->PPProduktpass_Liefertermin     = $ltXML[0];
        $pp->PPProduktpass_LieferterminJahr = $ltXML[1];
        if ((int)$ltXML[0] === 99 or (int)$ltXML[1] === 9999) {
            cpcDebug::cpc_debug('LT == 99', '@CalcLT');
            $ltThema = $this->calcTempLT($pp);
            if (!is_null($ltThema) ){
                $pp->PPProduktpass_Liefertermin     = $ltThema['Woche'];
                $pp->PPProduktpass_LieferterminJahr = $ltThema['Jahr'];
                cpcDebug::cpc_debug("Temp Liefertermin: " . $ltThema['Woche'] . "/" . $ltThema['Jahr'], '@CalcLT');
            } else{
                cpcDebug::cpc_debug("Kein Temp LT gefunden!", '@CalcLT');
            }
        } 
        cpcDebug::cpc_debug("Result1 Liefertermin: " .  $pp->PPProduktpass_Liefertermin . "/" .$pp->PPProduktpass_LieferterminJahr, '@CalcLT');
        //cpcDebug::dd($lt, false)
        $pp->PPProduktpass_RevisionVon_PPProduktpass_Id = $this->revision_von;
        $isUsa = $this->isUSProject($pp, $pp_vorgaenger);
        if ($this->revision_von === 0) {
            $pp->PPProduktpass_PPProjekte_Projekt = $pp->PPProduktpass_IAN;
            if ($isUsa) {
                $pp->PPProduktpass_PPProjekte_Projekt =   $pp->PPProduktpass_linkedItemIan . '+' . $pp->PPProduktpass_IAN;
            } else {
                if (!is_null($pp->PPProduktpass_linkedItemIan)){
                    $pp->PPProduktpass_PPProjekte_Projekt =   $pp->PPProduktpass_IAN . '+' . $pp->PPProduktpass_linkedItemIan;
                }
            }
            $pp->PPProduktpass_IsParent = $this->isParent($pp);
            $pp->PPProduktpass_IsChild  = $this->isChild($pp);
        } else {
            $projektData =  $this->getProjectData($this->revision_von, $pp->PPProduktpass_IAN);
            $pp->PPProduktpass_PPProjekte_Projekt = $projektData['Project'];
            $pp->PPProduktpass_IsParent = $projektData['IsParent'];
            $pp->PPProduktpass_IsChild = $projektData['IsChild'];
            $pp->PPProduktpass_IsKaufland = $projektData['IsKaufland'];
            $pp->PPProduktpass_TCAdmin = $projektData['TCAdmin'];
            $pp->PPProduktpass_PMAdmin = $projektData['PMAdmin'];
            $pp->PPProduktpass_TCAdminVTR = $projektData['TCAdminVTR'];
            $pp->PPProduktpass_PMAdminVTR = $projektData['PMAdminVTR'];
        }
        $pp->PPProduktpass_RevisionAktuell              = 0;
        $pp->PPProduktpass_Revisionsnummer              = $this->revision + 1;
        $pp->PPProduktpass_RevisionDatum                = date("Y-m-d H:i:s");
        $pp->PPProduktpass_Import_Datum                 = date("Y-m-d H:i:s");
        $pp->PPProduktpass_Import_BISUser_Id            = Auth::getUser()->id;
        $pp->PPProduktpass_AktExcel                     = $this->XMLUploadFile;
        $pp->PPProduktpass_IsUSA                        = $isUsa;
        $pp->save();
        $this->setProjectFromLinkedItems ($ppid);
        $this->calcCRD($ppid);
    }
    private function getProjectData($oldppid, $ian){
        $pp = tPPProduktpass::where("PPProduktpass_Id", "=", $oldppid)->get()->first();
        $data = array();
        if ($pp) {
            $data = array(
                'Project' => $pp->PPProduktpass_PPProjekte_Projekt,
                'IsParent' => $pp->PPProduktpass_IsParent,
                'IsChild' => $pp->PPProduktpass_IsChild,
                'IsUSA'   => $pp->PPProduktpass_IsUSA,
                'IsKaufland' => $pp->PPProduktpass_IsKaufland,
                'TCAdmin' => $pp->PPProduktpass_TCAdmin,
                'PMAdmin' => $pp->PPProduktpass_PMAdmin,
                'TCAdminVTR' => $pp->PPProduktpass_TCAdminVTR,
                'PMAdminVTR' => $pp->PPProduktpass_PMAdminVTR
            );
            return $data;
        }
        return array(
            'Project' => $ian,
            'IsParent' => 0,
            'IsChild' => 0,
            'IsUSA'   => 0,
            'IsKaufland' => 0,
            'TCAdmin' => 0,
            'PMAdmin' => 0,
            'TCAdminVTR' => 0,
            'PMAdminVTR' => 0
        );
    }
    private function hasSpalte($ppid, $sid){
        $pptermine = PPTermine::where('PPTermine_PPProduktpass_Id', $ppid)->where('PPTermine_PPBoardSpalte_id', $sid)->get()->first();
        if ($pptermine) {
            return true;
        }
        return false;
    }
    public function newTermine($id){
        cpcDebug::cpc_debug("New Termine für PPId: $id", '-NewTermine');
        $spalten = DB::table('PPBoardSpalteData')->where("PPBoardSpalte_Id", ">=", 1000)->get();
        $pp = tPPProduktpass::where('PPProduktpass_Id', $id)->get()->first();
        $pm = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'PM')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
        $pjm = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'PJM')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
        $tc = PPMitarbeiter::where('PPMitarbeiter_Taetigkeit', '=', 'TC')->where('PPMitarbeiter_isDefault', '=', 1)->get()->first();
        if ($pp) {
            $isUSOrder = $pp->PPProduktpass_continentType == 'US' ? true : false;
            $isParent = $pp->itemTypeKL == 'Parent' ? true : false;
            $isChild = $pp->itemTypeKL == 'Child' ? true : false;
            $pp->PPProduktpass_PMAdmin = $pm->PPMitarbeiter_Id;
            $pp->PPProduktpass_TCAdmin = $tc->PPMitarbeiter_Id;
            if ($pjm){
                $pp->PPProduktpass_PJMAdmin = $pjm->PPMitarbeiter_Id;
            } else {
                $pp->PPProduktpass_PMAdmin = $pm->PPMitarbeiter_Id;
            }
            if ($isUSOrder){
                $pp->PPProduktpass_IsUSA     = 1;
            } 
            if ($isParent){
                $pp->PPProduktpass_IsParent     = 1;
            } 
            if ($isChild){
                $pp->PPProduktpass_IsChild     = 1;
            } 
            $pp->save();
        }
        foreach ($spalten as $spalte) {
            if (!$this->hasSpalte($id, $spalte->PPBoardSpalte_Id)) {
                $termin                             = new PPTermine();
                $termin->PPTermine_PPProduktpass_Id = $id;
                //$termin->PPTermine_Header = "H".$i;
                $termin->PPTermine_Status           = "Neu";
                if ($isUSOrder and $spalte->PPBoardSpalte_IsUSA == 0) {
                    $termin->PPTermine_Status = "nicht benötigt";
                }
                if ($isChild and $spalte->PPBoardSpalteData_Child_nB == 1) {
                    $termin->PPTermine_Status = "nicht benötigt";
                }
                $termin->PPTermine_PPBoardSpalte_id = $spalte->PPBoardSpalte_Id;
                $termin->PPTermine_MAZustaendigkeit = $spalte->PPBoardSpalte_DefaultMA;
                //cpcDebug::cpc_debug("Eingetragen für PPId $id: Spalte: ".$spalte->PPBoardSpalte_Bezeichnung. " Art: ". $spalte->PPBoardSpalteData_Kind. " MA: " . $termin->PPTermine_MAZustaendigkeit, '-NewTermine');
                $termin->save();
            }
        }
    }
    private function handlePurchase($ppid){
        //purchase einfügen
        $pppurchase                              = new PPPurchase();
        $pppurchase->PPPurchase_PPProduktpass_Id = $ppid;
        $pppurchase->save();
    }
    private function handleMenge($ppid){
        $ms = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', "=", $ppid)->get();
        foreach ($ms as $m) {
            $m->PPProduktpass_Menge_CountryBlock = $this->getLaenderblock($m->PPProduktpass_Menge_Country);
            $m->save();
        }
    }
    private function handlePPInputManuell($ppid){
        $exits = PPInputManuell::where('PPInputManuell_PPProduktpass_Id', "=", $ppid)->exists();
        if ($exits) {
            $rows = PPInputManuell::where('PPInputManuell_PPProduktpass_Id', "=", $ppid)->get();
            foreach ($rows as $row) {
                $row->PPInputManuell_IsLatest = 0;
                $row->save();
            }
        }
    }
    private function handlePurchaseCopy($ppid){
        $po = PPPurchase::where('PPPurchase_PPProduktpass_Id', "=", $ppid)->get()->first();
        if ($po) {
            $po->PPPurchase_ManCheckOK = 0;
            $po->save();
        }
    }
    private function copyPPPPFiles($von, $nach){
        $ppfs = PPPPFiles::where("PPPPFiles_PPProduktpass_id", "=", $von)->get();
        $i = 0;
        foreach ($ppfs as $ppf) {
            $newppf = new PPPPFiles();
            foreach ($ppf->toArray() as $att => $value) {
                if ($att != "PPPPFiles_Id") {
                    $newppf->{$att} = $value;
                }
                $newppf->PPPPFiles_PPProduktpass_Id = $nach;
            }
            $newppf->save();
        }
    }
    private function handleUploadFile($ppid, $inq = false){
        $path = "";
        if ($inq) {
            $path = "/Inquiries/";
        }
        $filename = $path . basename($this->XMLUploadFile);
        //echo($filename."<br>");
        if (strpos($filename, 'Vorlage_Musterung_PPImport.xml') !== false) {
            echo ('Keine Speicherung!<br>');
            return;
        }
        $files                             = new PPPPFiles();
        $files->PPPPFiles_Name             = $path . $filename;
        $files->PPPPFiles_PPProduktpass_Id = $ppid;
        $files->PPPPFiles_Type             = "PPUpload";
        $files->PPPPFiles_Pfad             = "import/XML";
        $files->PPPPFiles_SubKat           = "Produktpass";
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
        $files->PPPPFiles_Description      = "Original PP (XML) Import: " . date("Y-m-d H:i:s");
        $files->PPPPFiles_LocalUpload      = 1;
        $files->save();
        if (!$inq) {
            $this->copyPPPPFiles($this->revision_von, $ppid);
        }
    }
    private function uploadFile($ppid, $f, $subcat){
        $files                             = new PPPPFiles();
        $files->PPPPFiles_Name             = $f;
        $fn_remark = $f;
        if (strlen($f) > 7){
            $fn_remark = substr($f,7 );
        }
        $files->PPPPFiles_PPProduktpass_Id = $ppid;
        $files->PPPPFiles_Type             = "PPUpload";
        $files->PPPPFiles_Pfad             = "uploads";
        $files->PPPPFiles_SubKat           = $subcat;
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
        $files->PPPPFiles_LocalUpload      = 1;
        $files->PPPPFiles_Description      = "$fn_remark".PHP_EOL."Import: " . date("Y-m-d H:i:s");
        $files->save();
        if ($subcat == 'Projektbild') {
            $pp  = tPPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
            if ($pp) {
                $pp->PPProduktpass_ProjektBild = $f;
                $pp->save();
            }
        }
    }
    private function handleFilesforPP($ppid, $files){
        foreach ($files as $art => $file) {
            if ($art == 'Bilder') {
                foreach ($file as $f) {
                    $new = $this->moveFile($f, "UPLOAD");
                    $this->uploadFile($ppid, $new, "Styles");
                }
            }
            if ($art == 'Projektbild') {
                $new = $this->moveFile($file, "UPLOAD");
                $this->uploadFile($ppid, $new, "Projektbild");
                $pp  = tPPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
                if ($pp) {
                    $pp->PPProduktpass_ProjektBild = $new;
                    $pp->save();
                }
            }
            if ($art == 'PDFs') {
                foreach ($file as $f) {
                    $new = $this->moveFile($f, "UPLOAD");
                    $this->uploadFile($ppid, $new, "PDFs");
                }
            }
            if ($art == 'Pflegesymbole') {
                $new = $this->moveFile($file, "UPLOAD");
                $this->uploadFile($ppid, $new, "Carelabel");
            }
        }
    }
    private function uebernehmeDatenSort($von_id, $nach_id){
        $vons = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $von_id)->get();
        foreach ($vons as $von) {
            $nach = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $nach_id)->where("PPProduktpass_Sortierung_Header", "=", $von->PPProduktpass_Sortierung_Header)->where("PPProduktpass_Sortierung_Laenderblock", "=", $von->PPProduktpass_Sortierung_Laenderblock)->get()->first();
            if ($nach) {
                $nach->PPProduktpass_Sortierung_Translate_Design = $von->PPProduktpass_Sortierung_Translate_Design;
                $nach->save();
            }
        }
    }
    private function uebernehmeDatenStyle($von_id, $nach_id){
        $vons = PPProduktpass_Style::where("PPProduktpass_Style_PPProduktpass_Id", "=", $von_id)->get();
        foreach ($vons as $von) {
            $nach = PPProduktpass_Style::where("PPProduktpass_Style_PPProduktpass_Id", "=", $nach_id)->where("PPProduktpass_Style_Header", "=", $von->PPProduktpass_Style_Header)->get()->first();
            if ($nach) {
                $nach->PPProduktpass_Style_Zolltarifnummer     = $von->PPProduktpass_Style_Zolltarifnummer;
                $nach->PPProduktpass_Style_Value01_Translation = $von->PPProduktpass_Style_Value01_Translation;
                $nach->PPProduktpass_Style_Value02_Translation = $von->PPProduktpass_Style_Value02_Translation;
                $nach->PPProduktpass_Style_Value03_Translation = $von->PPProduktpass_Style_Value03_Translation;
                $nach->PPProduktpass_Style_Value04_Translation = $von->PPProduktpass_Style_Value04_Translation;
                $nach->PPProduktpass_Style_Value05_Translation = $von->PPProduktpass_Style_Value05_Translation;
                $nach->save();
            }
        }
    }
    private function uebernehmeDatenMenge($von_id, $nach_id){
        $vons = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $von_id)->get();
        foreach ($vons as $von) {
            $nach = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $nach_id)->where("PPProduktpass_Menge_Country", "=", $von->PPProduktpass_Menge_Country)->get()->first();
            if ($nach) {
                $nach->PPProduktpass_Menge_EKUSD        = $von->PPProduktpass_Menge_EKUSD;
                $nach->PPProduktpass_Menge_VKFOBEUR     = $von->PPProduktpass_Menge_VKFOBEUR;
                $nach->PPProduktpass_Menge_CBEK         = $von->PPProduktpass_Menge_CBEK;
                $nach->PPProduktpass_Menge_Countrysizes = $von->PPProduktpass_Menge_Countrysizes;
                $nach->PPProduktpass_Menge_CBVK         = $von->PPProduktpass_Menge_CBVK;
                $nach->save();
            }
        }
    }
    private function uebernehmeDatenPP($von_id, $nach_id){
        $von  = tPPProduktpass::where("PPProduktpass_Id", "=", $von_id)->get()->first();
        $nach = tPPProduktpass::where("PPProduktpass_Id", "=", $nach_id)->get()->first();
        foreach ($von->getAttributes() as $key => $value) {
            if (is_null($nach->{$key}) or $nach->{$key} == ""  or $key == 'PPProduktpass_PPProjekte_Projekt') {
                $nach->{$key} = $von->{$key};
            }
        }
        /* if (is_null($von->PPProduktpass_ArtikelTarga) or strlen(trim($von->PPProduktpass_ArtikelTarga)) == 0) {
            $nach->PPProduktpass_ArtikelTarga = $nach->PPProduktpass_Artikelbezeichnung;
        } */
        $nach->save();
    }
    private function uebernehmeDaten($von_id, $nach_id){
        if ($von_id === 0) {
            return;
        }
        $tables = array('PPPurchase', 'PPPurchaseDTK', 'PPTermine', 'PPTermineChanges', 'PPLC', 'PPLaenderaufteilung', 'PPAB', 'PPInputManuell', 'PPProtokoll');
        foreach ($tables as $table) {
            $exists = $table::where($table . "_PPProduktpass_Id", "=", $von_id)->exists();
            if ($exists) {
                $elems = $table::where($table . "_PPProduktpass_Id", "=", $von_id)->get();
                foreach ($elems as $elem) {
                    $ppatt        = $table . "_PPProduktpass_Id";
                    $elem->$ppatt = $nach_id;
                    $elem->save();
                }
            }
        }
    }
    private function getVEfromMengen($ppid, $land){
        $menge = PPProduktpass_Menge::where("PPProduktpass_Menge_PPProduktpass_Id", "=", $ppid)->where("PPProduktpass_Menge_Country", "=", $land)->get()->first();
        if ($menge) {
            if ($menge->PPProduktpass_Menge_TotalSalePerUnit != 0) {
                return $menge->PPProduktpass_Menge_TotalSalePerUnit;
            }
        }
        return 1;
    }
    private function insertSortierung($osm, $ppid){
        foreach ($osm as $land => $laender) {
            foreach ($laender as $style => $styles) {
                $VE = $this->getVEfromMengen($ppid, $land);
                foreach ($styles as $size => $sizes) {
                    $sizekeys = array_keys($sizes);
                    $productName = $sizes[$sizekeys[0]]['Productname'];
                    $osland      = substr($land, 6, 2);
                    $qryLand     = $osland;
                    if ($osland == "ES") {
                        $qryLand = "XX";
                    }
                    $sort = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $ppid)->where("PPProduktpass_Sortierung_Laenderblock", "like", "%OS" . $qryLand . "%")
                        ->where("PPProduktpass_Sortierung_Header", "=", $style)->get()->first();
                    if ($sort) {
                        //$sort->delete();
                    }
                    $sort                                  = new PPProduktpass_Sortierung();
                    $sort->PPProduktpass_Sortierung_Header = $style;
                    $sort->PPProduktpass_Sortierung_Laenderblock = "CB8-OS" . $osland;
                    if ($qryLand == "XX") {
                        $sort->PPProduktpass_Sortierung_Laenderblock = "CB5-OSES";
                    }
                    $sort->PPProduktpass_Sortierung_Value01          = $productName;
                    $sort->PPProduktpass_Sortierung_PPProduktpass_Id = $ppid;
                    $sort->PPProduktpass_Sortierung_EAN     = $sizes[$sizekeys[0]]['EAN'];
                    $sort->PPProduktpass_Sortierung_Value02 = $sizes[$sizekeys[0]]['Menge'];
                    $sort->PPProduktpass_Sortierung_Size01  = $sizekeys[0];
                    $c = count($sizes);
                    if ($c >= 1) {
                        $osmenge = new PPProduktpass_OSSortMengen();
                        $osmenge->PPProduktpass_OSSortMengen_OSLand = $osland;
                        $ossizeatt                                  = "PPProduktpass_OSSortMengen_OSMengeSize01";
                        $osmenge->$ossizeatt                        = $sizes[$sizekeys[0]]['Menge'] / $VE;
                        for ($i = 1; $i < $c; $i++) {
                            $ndx = $i + 1;
                            $eanatt        = "PPProduktpass_Sortierung_EAN0" . $ndx;
                            $sort->$eanatt = $sizes[$sizekeys[$i]]['EAN'];
                            $sizeatt        = "PPProduktpass_Sortierung_Size0" . $ndx;
                            $sort->$sizeatt = $sizekeys[$i];
                            $menge           = $sizes[$sizekeys[$i]]['Menge'] / $VE;
                            $mengeatt        = "PPProduktpass_Sortierung_OSMenge" . $osland;
                            $sort->$mengeatt = $menge;
                            $vndx            = $ndx + 1;
                            $valueatt        = "PPProduktpass_Sortierung_Value0" . $vndx;
                            $sort->$valueatt = $sizes[$sizekeys[$i]]['Menge'];
                            $osmenge->PPProduktpass_OSSortMengen_OSLand = $osland;
                            $ossizeatt                                  = "PPProduktpass_OSSortMengen_OSMengeSize0" . $ndx;
                            $osmenge->$ossizeatt                        = $menge;
                        }
                    }
                    $sort->save();
                    if ($c >= 1) {
                        $osmenge->PPProduktpass_OSSortMengen_Sortierung_id = $sort->PPProduktpass_Sortierung_Id;
                        $osmenge->save();
                    }
                }
            }
        }
    }
    private function updateSortierung($osm, $ppid){
        $osland = substr($osm->PPXML_OSMengen_country, 2, 2);
        $sort   = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $ppid)->where("PPProduktpass_Sortierung_Laenderblock", "like", "%OS" . $osland . "%")
            ->where("PPProduktpass_Sortierung_Header", "=", $osm->PPXML_OSMengen_styleNo)->get()->first();
        if ($sort) {
            $sort->PPProduktpass_Sortierung_Header  = $osm->PPXML_OSMengen_styleNo;
            $sort->PPProduktpass_Sortierung_Value01 = $osm->PPXML_OSMengen_productName;
            $sort->PPProduktpass_Sortierung_EAN     = $osm->PPXML_OSMengen_gtin;
            $att                                    = "PPProduktpass_Sortierung_OSMenge" . $osland;
            $VE                                     = $this->getVEfromMengen($ppid, $osland);
            $menge                                  = $osm->PPXML_OSMengen_value / $VE;
            $sort->$att                             = $menge;
            $sort->save();
        }
    }
    private function handleOSMengen($ppid){
        $osms = PPXML_OSMengen::where("PPXML_OSMengen_PPProduktpass_Id", "=", $ppid)->where("PPXML_OSMengen_value", "!=", 0)->get();
        $insert = array();
        foreach ($osms as $osm) {
            //echo("<br>---------------------------<br>".$osm->PPXML_OSMengen_country."<br>".$osm->PPXML_OSMengen_styleNo."<br>".$osm->PPXML_OSMengen_lsv."<br>".$osm->PPXML_OSMengen_sizeName."<br>");
            $country                                                    = $osm->PPXML_OSMengen_country;
            $styleNo                                                    = $osm->PPXML_OSMengen_styleNo;
            $lsv                                                        = strlen($osm->PPXML_OSMengen_lsv) > 0
                ? $osm->PPXML_OSMengen_lsv : 1;
            $sizeName                                                   = strlen($osm->PPXML_OSMengen_sizeName) > 0
                ? $osm->PPXML_OSMengen_sizeName : "Size";
            $insert[$country][$styleNo][$lsv][$sizeName]['Menge']       = $osm->PPXML_OSMengen_value;
            $insert[$country][$styleNo][$lsv][$sizeName]['EAN']         = $osm->PPXML_OSMengen_GTIN;
            $insert[$country][$styleNo][$lsv][$sizeName]['Productname'] = $osm->PPXML_OSMengen_productName;
            $insert[$country][$styleNo][$lsv][$sizeName]['Country']     = substr($osm->PPXML_OSMengen_country, 4, 4);
            //echo("<pre>");var_dump($osm); //[$osm->PPXML_OSMengen_sizeName]
        }
        //$this->p($insert,true);
        $this->insertSortierung($insert, $ppid);
    }
    private function handlelocalGTIN($ppid){
        $ms = PPXML_Mengen::where("PPXML_Mengen_PPProduktpass_Id", "=", $ppid)->get();
        $insert = array();
        foreach ($ms as $m) {
            // echo( $m->PPXML_Mengen_styleNo . " - " . $m->PPXML_Mengen_productName . " - " . $m->PPXML_Mengen_sizeCode . " - " . $m->PPXML_Mengen_GTIN . "<br>");
            $ss = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $ppid)
                ->where("PPProduktpass_Sortierung_Header", "=", $m->PPXML_Mengen_styleNo)
                ->where("PPProduktpass_Sortierung_Value01", "=", $m->PPXML_Mengen_productName)
                ->where("PPProduktpass_Sortierung_Laenderblock", "not like", "%CB8%")
                ->get();
            foreach ($ss as $s) {
                //echo($s->PPProduktpass_Sortierung_Id . " - " . $s->PPProduktpass_Sortierung_Laenderblock . " - " . $m->PPXML_Mengen_country . " OK <br>");
                if (strpos($s->PPProduktpass_Sortierung_Laenderblock, $m->PPXML_Mengen_country) !== false) {
                    if ($s->PPProduktpass_Sortierung_Size01 == $m->PPXML_Mengen_sizeCode) {
                        $s->PPProduktpass_Sortierung_EAN = $m->PPXML_Mengen_GTIN;
                    }
                    for ($y = 2; $y < 10; $y++) {
                        $sizeX = "PPProduktpass_Sortierung_Size0" . $y;
                        $eanX  = "PPProduktpass_Sortierung_EAN0" . $y;
                        if ($s->$sizeX == $m->PPXML_Mengen_sizeCode) {
                            $s->$eanX = $m->PPXML_Mengen_GTIN;
                        }
                    }
                    $s->save();
                }
            }
        }
    }
    private function delAssort($ppid, $assids){
        foreach ($assids as $assort) {
            $delassorts = PPAssortments::where('PPAssortments_PPProduktpass_Id', $ppid)->where('PPAssortments_countryCodes', '=', $assort['country'])->where('PPAssortments_styleNo', '=', $assort['style'])->get();
            if ($delassorts) {
                $first = true;
                foreach ($delassorts as $del) {
                    if (!$first) {
                        //$del->PPAssortments_delMarker = 1;
                        $del->delete();
                    }
                    $first = false;
                }
            }
        }
    }
    private function handleAssortment($ppid){
        $assorts = PPAssortments::select('PPAssortments_countryCodes', 'PPAssortments_styleNo')->where('PPAssortments_PPProduktpass_Id', $ppid)->distinct()->get();
        $assids = array();
        if ($assorts) {
            foreach ($assorts as $assort) {
                $assids[] = array('country' => $assort->PPAssortments_countryCodes, 'style' => $assort->PPAssortments_styleNo);;
            }
        }
        $this->delAssort($ppid, $assids);
    }
    private function postInsert($ppid, $isInq = false){
        if ($this->revision_von == 0) {
            $this->newTermine($ppid);
        } else {
            //$this->newTermine($this->revision_von);
        }
        $this->handlePP($ppid);
        $this->handleAssortment($ppid);
        $this->handleMenge($ppid);
        $this->handleUploadFile($ppid, $isInq);
        $this->handleOSMengen($ppid);
        $this->handlelocalGTIN($ppid);
        if ($this->revision_von === 0) {
            $this->handlePurchase($ppid);
        } else {
            $this->uebernehmeDaten($this->revision_von, $ppid);
            $this->handlePurchaseCopy($ppid);
            //$this->handlePPInputManuell($ppid);
            $this->uebernehmeDatenPP($this->revision_von, $ppid);
            $this->uebernehmeDatenSort($this->revision_von, $ppid);
            $this->uebernehmeDatenMenge($this->revision_von, $ppid);
            $this->uebernehmeDatenStyle($this->revision_von, $ppid);
        }
        if (!$this->test_purchase($ppid) and $isInq) {
            $this->handlePurchase($ppid);
        }
        if (!$this->tryChange2Musterung($ppid)) {
            if ($isInq) {
                $this->change2Inq($ppid);
            }
        }
    }
    private function test_purchase($ppid){
        $purchase = PPPurchase::where("PPPurchase_PPProduktpass_Id", "=", $ppid)->get()->first();
        //dd($purchase);
        if ($purchase) {
            return true;
        }
        return false;
    }
    private function getRandom(){
        return mt_rand(100, 999);
    }
    private function tryChange2Musterung($ppid){
        $pp = tPPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
        //dd($pp);
        if ($pp->PPProduktpass_IAN == "000000") {
            $pp->PPProduktpass_IAN         = "M-NEU" . $this->getRandom();
            $pp->PPProduktpass_IsMusterung = 1;
            $pp->save();
            return true;
        }
        return false;
    }
    private function change2Inq($ppid){
        $inq = tPPProduktpass::where("PPProduktpass_Id", "=", $ppid)->get()->first();
        $now = date("Y-m-d");
        if ($inq) {
            $inq->PPProduktpass_IsInquiry       = 1;
            $inq->PPProduktpass_Import_Datum    = $now;
            $inq->PPProduktpass_InquiryArt      = $this->IsBWInquiry;
            $inq->PPProduktpass_RevisionAktuell = 0;
            //$inq->PPProduktpass_RevisionVon_PPProduktpass_Id = null;
            $inq->PPProduktpass_RevisionAktuell = 0;
            $inq->PPProduktpass_IAN             = "I-" . $inq->PPProduktpass_IAN;
            $inq->save();
        }
    }
    private function setTranslateColumns (){
        /*if (Auth::user()->PPMitarbeiter_Kuerzel != 'FKE'){
            return; 
        }*/
        $cols = DB::table('XMLConverterMitVersion')->where("XMLConverter_Translate", 1)->where('XMLConverter_Version', '2022.01')->get();
        $this->columns2translate = array();
        foreach ($cols as  $col) {
            $this->columns2translate[] = $col->XMLConverter_DBColumn;
        }
        //cpcDebug::cpc_debug($this->columns2translate, '@T261');
    }
    private function translateColumn ($colname, $text){
       /* if (Auth::user()->PPMitarbeiter_Kuerzel != 'FKE'){
            return; 
        }*/
        $key = array_search($colname, $this->columns2translate, true);
        //cpcDebug::cpc_debug("Key: ".$key, '@T261');
        if ($key !== false){
        // Übersezuung anfertigen
            $translation = ServiceProvider::tl('EN',$text );
            //cpcDebug::cpc_debug("Translate: $colname", '@T261');
        } else {
            //cpcDebug::cpc_debug("No Translation: $colname", '@T261');
        }
        return;
    }
    private function insert($table, $values, $ppid = 0){
        if ($table == "PPProduktpass_Menge_Final") {
            DB::delete("Delete from PPProduktpass_Menge_Final where PPProduktpass_Menge_PPProduktpass_Id = $ppid ");
        }
        $i = 1;
        foreach ($values as $vals) {
            foreach ($vals as $val) {
                try {
                    //echo("New $table: $i <br>");
                    $dbElem = new $table();
                } catch (Exception $e) {
                    echo ("FEHLER bei Tabelle: $table <br> ");
                    echo ($e->getMessage());
                    exit;
                }
                foreach ($val as $key => $v) {
                    if (isset($v) and strlen($v) > 0) {
                        $dbElem->$key = $v;
                        $this->translateColumn($key, $v);
                        //echo("$key = > " . print_r($v, true) . "<br>");
                    }
                }
                if ($table != "tPPProduktpass") {
                    $dbForignKey = $table . "_PPProduktpass_Id";
                    if ($table == 'PPProduktpass_Menge_Final') {
                        $dbForignKey = "PPProduktpass_Menge_PPProduktpass_Id";
                    }
                    $dbElem->$dbForignKey = $ppid;
                }
                //echo("Save $table Row: $i <br>");
                try {
                    //echo("Save: $i <br>");
                    $dbElem->save();
                } catch (Exception $e) {
                    echo ("FEHLER bei Tabelle: $table <br> ");
                    echo ($e->getMessage());
                    exit;
                }
                $i++;
                if ($table == "tPPProduktpass") {
                    return $dbElem->PPProduktpass_Id;
                }
            }
        }
    }
    private function viewForceImport($file, $mailto, $zipArray){
        $json =  htmlspecialchars(json_encode($zipArray));
        $data['SALs'] = $this->getSALs();
        $data['content'] = "<div style='border:1px solid lightgray;text-align:left;padding:30px;'> <h3 style='color:red;'>Doppelte IAN!</h3><br>Datei " . $this->XMLUploadFile . " wurde nicht importiert! <br><br> IAN mit neuer Version einlesen?<br><br><br>" .
            '<form action="importXML" method="post">
                        <input type="hidden" name="ZIPArray" value="' . $json . '" />
                        <input type="hidden" name="fileAll" value="' . $file . '" />
                        <input type="hidden" name="force" value="true" />
                        <input type="hidden" name="mailto" value="' . $mailto . '" />
						<input type="hidden" name="filenameForce" value="' . $this->XMLUploadFile . '" />
                        <input style="height:35px;font-size:18px;" type="submit" value="Neue Version anlegen!" />
					</form></div>';
        $data['bordercolor'] = "red";
        $data['msg']         = "";
        return View::make('main', $data);
    }
    private function viewSuccessImportInq($newppids){
        $message = "<div style='width:1200px;padding:50px;'>"
            . "Datum: " . date("d-m-Y H:i:s") . "<br><br><b>Die Dateien wurde erfolgreich importiert!<b><br><br><a href='showInquiryAll'>Link zu den Inquiries</a></b><br><br>";
        $message .= "<br><h1>DETAILS</h1><br> <table cellspacing='5'>";
        $i = 1;
        foreach ($newppids as $pp) {
            $message = $message . "<tr><td>$i</td><td>" . substr($pp['file'], 7, strlen($pp['file'])) . "</td><td> <span style='color:lime;'> " . $pp['Msg'] . "</span></td>";
            $i++;
        }
        $message = $message . "</table></div>";
        $data['content'] = $message;
        return View::make('main', $data);
    }
    private function getMitarbeiterEmail($mid){
        $email = '';
        if ($mid != null) {
            $m = PPMitarbeiter::where('PPMitarbeiter_Id', $mid)->get()->first();
            if ($m) {
                if (substr($m->PPMitarbeiter_Kuerzel, 0, 1) == '@') {
                    if ($m->PPMitarbeiter_Taetigkeit == 'TC') {
                        return 'christian.stamen@targa.de';
                    }
                    if ($m->PPMitarbeiter_Taetigkeit == 'PJM') {
                        return 'sophia.schewalje@targa.de';
                    } 
                    if ($m->PPMitarbeiter_Taetigkeit == 'PM') {
                        return 'andreas.claus@targa.de';
                    }
                    return 'markus.midderhoff@targa.de';
                }
                $email = $m->PPMitarbeiter_email;
            }
        }
        return $email;
    }
    private function viewSuccessImport($ppid, $mailto = '' ){
        if ($ppid) {
            $pp = tPPProduktpass::find($ppid);
            $emailLang = $this->getMitarbeiterLanguageFromEmail($mailto);
            $message = '';
            $server = 'https://' . $_SERVER['SERVER_NAME'];
            $ian = $pp->PPProduktpass_IAN;
            $status = $pp->InternerStatus;
            $ausm = substr($pp->PPProduktpass_Ausmusterungnummer, 0, 4);
            $bez = $pp->PPProduktpass_Artikelbezeichnung;
            $changeQty = false;
            if ($pp->PPProduktpass_RevisionVon_PPProduktpass_Id !== 0) {
                $message         = "<b>Die Datei wurde erfolgreich importiert!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link zum Produktpass.</a><br><br>" . "<h3>Änderungen zur Vorversion</h3><br><br>";
                if ($emailLang != 'DE'){
                    $message         = "<b>File imported succsessfully!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link to Productpass.</a><br><br>" . "<h3>Changes to prvious Version</h3><br><br>";
                }
                $data['content'] = '';
                if (strlen($pp->PPProduktpass_Ausmusterungnummer) > 4) {
                    $data['content'] = $this->compareXML($ppid, "LATEST", $message, false, true);
                } 
                $subject         = "[TPT] Produktpass IAN $ian $ausm $bez wurde neu eingelesen";
                $message         = "<b>Die Datei wurde erfolgreich importiert!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link zum Produktpass....</a><br><br>";
                if ($emailLang != 'DE'){
                    $subject         = "[TPT] Productpass IAN $ian $ausm ". ServiceProvider::translateDirect($bez) . " imported new ";
                    $message         = "<b>File imported succsessfully!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link to Productpass....</a><br><br>";
                }
                $body =  $data['content']; //$this->compareXML($ppid, "LATEST", $message);
                $_diffs= '';
                if (strlen($pp->PPProduktpass_Ausmusterungnummer) > 4){
                    $_diffs = $this->compareXML($ppid, "LATEST", $message, true);
                }
                $changeQty = $this->hasQuantityChange($_diffs);
            } else {
                $data['content'] = "<b>Die Datei wurde erfolgreich importiert!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link zum Produktpass...</a><br><br>";
                $subject = "[TPT] Produktpass IAN $ian $ausm $bez wurde eingelesen";
                $body = "<b>Die Datei wurde erfolgreich importiert!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link zum Produktpass....</a><br><br>";
                if ($emailLang != 'DE'){
                    $data['content'] = "<b>File imported succsessfully!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link to Productpass....</a><br><br>";
                    $subject = "[TPT] Productpass IAN $ian $ausm ". ServiceProvider::translateDirect( $bez )." improted!";
                    $body = "<b>File imported succsessfully!<b><br><br><a href='" . "$server/show/$ppid" . "'>Link to Productpass....</a><br><br>";
                }
            }
            //cpcDebug::cpc_debug('Sollte Importeur sein: '.$mailto, '!FKE');
            if (strlen($mailto) > 3) {
                $mail = new MailController();
                $cc1 = array();
                //$pm = PPMitarbeiter::find($pp->PPProduktpass_PMAdmin);
                //echo('<br>PM: '.$pp->PPProduktpass_PMAdmin);
                //Bei Absage oder Geliefert keine mail an PM oder TC
                if ($status != 'GELIEFERT' and $status != 'ABSAGE') {
                    $pmmail = $this->getMitarbeiterEmail($pp->PPProduktpass_PMAdmin);
                    if ($pmmail != '') {
                        $cc1[] = $pmmail;
                    }
                    $pmmailVTR = $this->getMitarbeiterEmail($pp->PPProduktpass_PMAdminVTR);
                    if ($pmmailVTR != '') {
                        $cc1[] = $pmmailVTR;
                    }
                    $tcmail = $this->getMitarbeiterEmail($pp->PPProduktpass_TCAdmin);
                    if ($tcmail != '') {
                        $cc1[] = $tcmail;
                    }
                    $tcmailVTR = $this->getMitarbeiterEmail($pp->PPProduktpass_TCAdminVTR);
                    if ($tcmailVTR != '') {
                        $cc1[] = $tcmailVTR;
                    }
                    $pjmmail = $this->getMitarbeiterEmail($pp->PPProduktpass_PJMAdmin);
                    if ($pjmmail != '') {
                        $cc1[] = $pjmmail;
                    }
                    $pjmmailVTR = $this->getMitarbeiterEmail($pp->PPProduktpass_PJMAdminVTR);
                    if ($pjmmailVTR != '') {
                        $cc1[] = $pjmmailVTR;
                    }                    
                    if ($changeQty) {
                        $cc1[] = 'dagmar.pink@targa.de';
                        $cc1[] =  'jannis.adams@targa.de';
                        //$cc1[] = 'k.keppel@compecon.de';
                        //$cc1[] = 'info@compecon.de';
                    }
                     if ($status == 'FIX') {
                        $cc1[] = 'stefan.hinzmann@targa.de';
                     }
                }
                if ($mailto == 'f.keppel@compecon.de') {
                    $cc1 = array();
                }
                //$mailLang 
                $sendtMailSuppress = false;
                $value = Input::get('mailSuppress');
                if (is_string($value)) {
                    $value = strtolower(trim($value));
                    if (in_array($value, array('on', '1', 'true', 'yes'), true)) {
                        $sendtMailSuppress = true;
                    }
                }
                if (! $sendtMailSuppress){
                    $mail->sendMail($mailto, $cc1, $subject, $body);
                } 
            }
        } else {
            $message         = "<b>Fehler beim einlesen der Datei!!<b><br><br><a href='/uploadForm/0'>Neu einlesen</a>";
            $data['content'] = $message;
        }
        if (! $sendtMailSuppress){
            $data['content'] .=  "<div style='text-align:left;padding:10px;'>Mails an: $mailto <br>";
            foreach ($cc1 as $m) {
                $data['content'] .= "   + $m <br>";
            }
            $data['content'] .=  "</div>";
        } else {
            $data['content'] .=  "<div style='text-align:left;padding:10px;'><b>Hinweis:</b> Der Import wurde mit Mailversand unterdrückt.<br>Wenn Sie eine Mail erhalten möchten, bitte den Haken bei 'Mailsenden' setzen.<br></div>";
        }
        return View::make('main', $data);
    }
    private function savePrevPP($ppid_alt){
        //sichert die Version
        //echo("savePrevPP PID: $ppid_alt<br>");
        cpcDebug::cpc_debug("savePrevPP PID: $ppid_alt", '-T261');
        $pp = tPPProduktpass::Where('PPProduktpass_Id', "=", $ppid_alt)->orderBy("PPProduktpass_Id", "desc")->get()->first();
        if (!$pp) {
            echo ("Fehler beim Importieren <br>");
            //return array('Result' => false, 'InternerStatus' =>  '');
            exit;
        }
        $this->revision = 1;
        //echo("savePrevPP Rev_von PID: " . $pp->PPProduktpass_RevisionVon_PPProduktpass_Id . "<br>");
        if ($pp->PPProduktpass_RevisionVon_PPProduktpass_Id != 0) {
            $ppvorrevision = tPPProduktpass::Where('PPProduktpass_Id', "=", $pp->PPProduktpass_RevisionVon_PPProduktpass_Id)->orderBy("PPProduktpass_Id", "desc")->get()->first();
            if ($ppvorrevision) {
                $this->revision                               = $ppvorrevision->PPProduktpass_RevisionAktuell + 1;
                //echo("savePrevPP Revision: " . $this->revision . "<br>");
                $ppvorrevision->PPProduktpass_RevisionAktuell = $this->revision;
            } else {
                echo ("savePrevPP ID nicht gefunden: " . $pp->PPProduktpass_RevisionVon_PPProduktpass_Id . "<br>");
                exit;
            }
        }
        $this->revision_von = $pp->PPProduktpass_Id;
        try{
            $pp->PPProduktpass_IAN             = $pp->PPProduktpass_IAN . " (Rev. " . $this->revision . " ) ";
            $pp->PPProduktpass_RevisionAktuell = $this->revision;
            $pp->save();
        }     
        catch (Exception  $ex){
            $pp->PPProduktpass_IAN             = $pp->PPProduktpass_IAN . " (RevError. " . $this->revision . " ) ";
            $errRev = $this->revision + 1000;
            $pp->PPProduktpass_RevisionAktuell = $errRev;
            $pp->save();
        }
        $res = array('Result' => true, 'InternerStatus' =>  $pp->InternerStatus);
        cpcDebug::cpc_debug($res, '-T261');
        cpcDebug::cpc_debug("savePrevPP Ende", '-T261');
        return $res;
    }
    private function moveFile($file, $dest){
        if ($dest == "UPLOAD") {
            $destination = $this->UPLOAD_Path;
        }
        if ($dest == "IMPORTINQ") {
            $destination = $this->XMLPath . "Inquiries/";
        }
        //$newFile = str_random(6) . "_" . pathinfo($file, PATHINFO_BASENAME);
        try {
            rename($file, $destination . $file);
        } catch (Exception $exc) {
            echo ("<pre>Newfile:  $file   Destinatioen:  $destination <br>");
            echo ("File: $file <br>");
            echo $exc->getMessage();
            exit;
        }
        return true;
    }
    public function importXMLInq(){
        $inp = Input::all();
        $file = Input::file('file');
        $dir  = Input::file('dirupload');
        //cpcDebug::dd($file);
        $this->IsBWInquiry = Input::get('IsBW');
        $files = array();
        if ($file) {
            $uplFilename = $file->getClientOriginalName();
            if (strpos($uplFilename, ".zip") !== false) {
                $files = $this->uploadAndunzip($file);
                foreach ($files as $dirf) {
                    $newppids[] = $this->import($dirf);
                }
            } else {
                $files['IAN']['XML'] = $this->upload($file, True);
                foreach ($files as $dirf) {
                    $newppids[] = $this->import($dirf);
                }
            }
        } else {
            $i         = 0;
            $newpppids = array();
            foreach ($dir as $tmpFile) {
                $uplFile    = $tmpFile->getClientOriginalName();
                $path_parts = pathinfo($uplFile);
                $files      = array();
                if (strtoupper($path_parts['extension']) == 'ZIP') {
                    $files = $this->uploadAndunzip($tmpFile);
                } else {
                    $files['IAN']['XML'] = $this->upload($tmpFile, True);
                }
                //cpcDebug::dd($files, 1);
                foreach ($files as $dirf) {
                    $newppids[] = $this->import($dirf);
                }
            }
        }
        //cpcDebug::dd($files, 1);
        return $this->viewSuccessImportInq($newppids);
    }
    function import($dir){
        $this->XMLUploadFile = $dir['XML'];
        $this->xml_item      = $this->readXML($this->XMLPath . "Inquiries/" . $this->XMLUploadFile);
        $ian = $this->xml_item->ian;
        $this->revision = 0;
        $result = array();
        $ppid   = $this->getIDInq($ian);
        $isRevision = false;
        if ($ppid != 0) {
            $this->savePrevPP($ppid);
            $isRevision = true;
        }
        $json           = json_encode($this->xml_item);
        $this->xmlArray = json_decode($json, TRUE);
        $import = array();
        $import['tPPProduktpass']          = $this->getXMLVarValues("tPPProduktpass");
        $import['PPProduktpass_Qualitaet'] = $this->getXMLVarValues("PPProduktpass_Qualitaet");
        $import['PPProduktpass_Style']      = $this->getXMLVarValues("PPProduktpass_Style");
        $import['PPProduktpass_Sortierung'] = $this->getXMLVarValues("PPProduktpass_Sortierung");
        //echo('<pre>');var_dump($import['PPProduktpass_Sortierung']);exit;
        if (!$import['PPProduktpass_Sortierung'][0][0]['PPProduktpass_Sortierung_Header']) {
            $import['PPProduktpass_Sortierung'][0][0]['PPProduktpass_Sortierung_Header'] = 'NOSORT';
            $import['PPProduktpass_Sortierung'][0][0]['PPProduktpass_Sortierung_Value01'] = 'NOSORT';
            $import['PPProduktpass_Sortierung'][0][0]['PPProduktpass_Sortierung_Value02'] = 1;
        }
        $import['PPProduktpass_Menge']      = $this->getXMLVarValues("PPProduktpass_Menge");
        $import['PPXML_Mengen']             = $this->getXMLVarValues("PPXML_Mengen");
        $import['PPXML_OSMengen']           = $this->getXMLVarValues("PPXML_OSMengen");
        $new_ppid = $this->doInserts($import);
        $this->postInsert($new_ppid, 1);
        $this->handleFilesforPP($new_ppid, $dir);
        if ($isRevision) {
            $res = array(
                "file" => $this->XMLUploadFile,
                "Msg"  => "Inquiry bereits eingelesen. Wird mit neuer Version überschrieben",
                "ppid" => $new_ppid
            );
        } else {
            $res = array(
                "file" => $this->XMLUploadFile,
                "Msg"  => "Inquiry eingelesen OK",
                "ppid" => $new_ppid
            );
        }
        return $res;
    }
    private function isEqArray($a, $b){
        $ret_arr  = array();
        $ret_isEq = true;
        foreach ($a as $key => $value) {
            $ret_arr[$key] = $b[$key];
            if ($a[$key] !== $b[$key]) {
                $ret_isEq = false;
            }
        }
        return array("Array" => $ret_arr, "Result" => $ret_isEq);
    }
    private function check_sort($sorts){
        $xsorts = array();
        $i      = 0;
        $j      = 0;
        foreach ($sorts as $sort) {
            $test = array(
                "PPProduktpass_Sortierung_Header"       => "",
                "PPProduktpass_Sortierung_Value01"      => "",
                "PPProduktpass_Sortierung_Value02"      => "",
                "PPProduktpass_Sortierung_Laenderblock" => ""
            );
            foreach ($sort as $att) {
                $cmp = $this->isEqArray($test, $att);
                if ($cmp['Result']) {
                    //echo("Delete<br>");
                    //cpcDebug::dd($att);
                } else {
                    $test           = $cmp['Array'];
                    //echo("Keep<br>");
                    $xsorts[$i][$j] = $att;
                    //cpcDebug::dd($att);
                }
                $j++;
            }
            $i++;
        }
        //cpcDebug::dd($xsorts);
        return $xsorts;
    }
    public function newXMLMusterung(){
        $input_file = storage_path() . '/data/templates/Vorlage_Musterung_PPImport.xml';
        return $this->_importXML($input_file, false, false, null, 'MUSTERUNG');
    }
    public function importXML(){
        $force = Input::get("force");
        $final = Input::get("final");
        $mailto = Input::get("mailto");
        $InternerStatus = Input::get("InternerStatus");
        if (Input::has('ZIPArray')) {
            try {
                $json = json_decode(Input::get('ZIPArray'));
            } catch (Exception $e) {
                print_r($e);
                exit;
            }
        } else {
            $json = 'Fehler';
        }
        if ($final) {
            $force = false;
        }
        $zipPath = null;
        if ($force) {
            $inp_file = Input::get('filenameForce');
            $this->XMLUploadFile = $inp_file;
            $zipInfos = null;
            if (isset($json->infos)) {
                $zipInfos = $json->infos;
            }
        } else {
            $inp_file            = Input::file('file');
            if (strpos(strtoupper($inp_file->getClientOriginalName()), 'QTE_EXPORT') !== false) {
                echo ('<div style="border:4px solid red;width:600px;height 150px;padding:50px;font-family:arial;color:darkblue;"><h3>QTE_Export Dateien können nicht eingelsen werden! </h3> <br /> <button onclick="history.back();" style="padding:8px;width:100px;"><b>Zurück</b></button></div>');
                exit;
            }
            if (strpos(strtoupper($inp_file->getClientOriginalName()), ".ZIP") !== false) {
                $this->forceZipFile = $this->uploadAndUnpackZip($inp_file);
                //dd($zipFiles);exit;
                $this->XMLUploadFile = $this->forceZipFile['xml']['filename'];
                $zipInfos = $this->forceZipFile['infos'];
            } else {
                $zipInfos = null;
                $this->XMLUploadFile = $this->upload($inp_file);
            }
        }
        return $this->_importXML($this->XMLUploadFile, $force, $final, $zipInfos, $InternerStatus, $mailto);
    }
    private function getSchemaVersion($xmlFile){
        cpcDebug::cpc_debug('xmlFile getSchemaversion:' . $xmlFile, 'XML');
        $schemaVersion = '';
        if (!file_exists($xmlFile)) {
            echo ("Schemasuche: $xmlFile nicht gefunden!");
        }
        $xmlHeader = simplexml_load_file($xmlFile);
        foreach ($xmlHeader->attributes() as $att => $val) {
            //echo("$att => $val <br>");
            if ($att == "schemaVersion") {
                $schemaVersion = $val;
            }
        }
        return $schemaVersion;
    }
    private function getValuesXML($node, $values){
        $ret = array();
    }
    private function getSubTree($xml){
        $ret = array();
        $c = 0;
        $att = '';
        foreach ($xml->children() as $x) {
            //echo($x->getName().": ");
            if ($att == $x->getName()) {
                $c++;
            }
            $att = $x->getName();
            if (count($x) == 0) {
                $ret[$att] = (string)$x;
                //  echo((string)$x);
            } else {
                $ret[$att][$c] = $this->getSubTree($x);
            }
        }
        $ret['count'] = $c + 1;
        return $ret;
    }
    function pp($header, $var, $exit = true){
        echo ($header . '<br><pre>');
        print_r($var);
        echo ('</pre><br>');
        if ($exit) {
            exit;
        }
    }
    private function getValues($tree, $elems){
        /* 
        $this->pp('',$tree['assortments'][0]['count']);
        $this->pp('',$tree['assortments'][0]['assortment'][0]['styles'][0]['count']);
        $this->pp('',$tree['assortments'][0]['assortment'][0]['styles'][0]['style'][0]['sizes'][0]['count']);
        */
        $xmlNodes = $tree;
        foreach ($elems['path'] as $path) {
            if ($path['key'] = "") {
                $xmlNodes = $xmlNodes[$path['elem']];
            } else {
                $count[$path['key']] = 0;
            }
        }
        //$this->pp('',$elems);exit;
        //$elems=array('assortments','assortment','countryCodes');
        $xmlNode = $tree;
        $this->pp('', count($tree['assortments'][0]['assortment']));
        foreach ($tree['assortments'][0]['assortment'] as $assortment) {
            $x[$assortment['countryCode']] = 1;
        }
        $this->pp('', $x);
        $ret = '';
        foreach ($elems['path'] as $path) {
            if ($path['key'] == '') {
                $ret .=  $path['elem'] . "->";
            } else {
                $ret .= $path['elem'] . "[" . $path['key'] . "]->";
            }
        }
        $ret .= $elems['value'];
        $this->pp('', $ret);
        exit;
        $xmlNode = $xmlNode[$path['elem']];
        echo ($path['elem'] . "  " . $path['key'] . "<br>");
    }
    private function examin_Table($tree, $elems){
        $ret = array();
        if (count($elems['path']) == 0) {
            $ret = array();
            foreach ($elems['value'] as $yKey) {
                if (strpos($yKey, '@') !== false) {
                    $expl = explode('@', $yKey);
                    $expl1 = $expl[0];
                    $expl2 = $expl[1];
                    if (isset($tree[$expl1][0][$expl2])) {
                        $ret[$expl1 . '_' . $expl2] = $tree[$expl1][0][$expl2];
                    } else {
                        $ret[$expl1 . '_' . $expl2] = 'X';
                    }
                } else {
                    if (isset($tree[$yKey])) {
                        $ret[$yKey] = $tree[$yKey];
                    } else {
                        $ret[$yKey] = 'X';
                    }
                }
            }
        } else {
            //echo('Knoten<br>');
            $elem = reset($elems['path']);
            try {
                $key = $elem['key'];
            } catch (Exception $ex) {
                $this->pp('', $elems);
                exit;
                return ($ret);
            }
            $index = key($elems['path']);
            //$this->pp('A', $elem);
            //$this->pp('B', $key);
            //$this->pp('C', $index);
            unset($elems['path'][$index]);
            if ($key == '') {
                //echo('Mehrzahl<br>');
                $tree = $tree[$elem['elem']][0];
                $ret = $this->examin($tree, $elems);
            } else {
                $i = 1;
                foreach ($tree[$elem['elem']] as $subtree) {
                    $i++;
                    //$this->pp('Abstieg Sub: ', $subtree);
                    //$this->pp('Abstieg ele    ms: ', $elems);
                    $keyField = array();
                    $keyNeu = $key;
                    if (strpos($key, '@') !== false) {
                        $k = 1;
                        if (strpos($key, '+') !== false) {
                            $xPath = explode('+', $key);
                            $keyField[$k++] = $xPath[0];
                            $keyNeu = $xPath[1];
                        }
                        $xPath = explode('@', $keyNeu);
                        $keyField[$k++] = $xPath[0];
                        $keyField[$k] = $xPath[1];
                        //$this->pp($keyField1, $subtree[$keyField1]);exit;
                        if ($k > 2) {
                            $keyValue = $subtree[$keyField[1]] . "@" . $subtree[$keyField[2]][0][$keyField[3]];
                        } else {
                            try {
                                $keyValue = $subtree[$keyField[1]][0][$keyField[2]];
                            } catch (Exception $e) {
                                /*echo($keyField[1].'<br>');
                                echo($keyField[2].'<br>');
                                print_r($subtree[$keyField[1]]  );*/
                                $this->pp('Mist', '');
                                exit;
                            }
                        }
                    } else {
                        $keyValue = $subtree[$key];
                    }
                    $ret[$elem['elem']][$keyValue] = $this->examin($subtree, $elems);
                }
            }
        }
        return $ret;
    }
    private function xmlGetInserts($xml, $xmlelem, $table, $attribs){
        //$this->pp('',$xmlelem);        $this->pp('',$table);        $this->pp('',$attribs);        exit;
        $insert = "INSERT INTO $table ( ";
        $attributes = '';
        $values = '';
        //echo ("<br>Start:<br>");
        //$this->pp('XML:',$xml);
        $node = $this->getNode($xmlelem, $xml);
        if (true) {
            foreach ($attribs as $att) {
                if (strpos($att, '+') === false) {
                    if (strlen($attributes) > 0) {
                        $attributes .= ',' . $this->getPlainAttrib($att);
                    } else {
                        $attributes .= $this->getPlainAttrib($att);
                    }
                    if (strlen($values) > 0) {
                        $values .= ",'" . $this->getPlainValue($node[0], $att) . "' ";
                    } else {
                        $values .= " '" . $this->getPlainValue($node[0], $att) . "' ";
                    }
                }
            }
            $insert .= $attributes . ' ) VALUES ( ' . $values . ')';
        }
        return ($insert);
    }
    private function getPlainAttrib($attrib){
        if (strpos($attrib, '@') === false) {
            return $attrib;
        } else {
            $attribs = explode('@', $attrib);
            return $attribs[0];
        }
    }
    private function getPlainValue($node, $attrib){
        return '?x?';
        $ret = null;
        if (strpos($attrib, '@') === false) {
            try {
                $ret = $node[$attrib];
            } catch (Exception $ex) {
                echo ($attrib . "<br>");
                $this->pp('EX1:', $node);
            }
        } else {
            $attribs = explode('@', $attrib);
            try {
                $ret =  $node[$attribs[0]][0][$attribs[1]];
            } catch (Exception $ex) {
                echo ($attrib . "<br>");
                $this->pp('EX2:', $node);
            }
        }
        return $ret;
    }
    private function getNode($xmlelem, $xml){
        if (strpos($xmlelem, '@') !== false) {
            $subtree = explode('@', $xmlelem);
            foreach ($subtree as $n1) {
                if (!isset($node)) {
                    //echo("Init: $n1 <br>");
                    //$node = 1;
                    $node = $xml[$n1];
                } else {
                    //echo("  Node: $n1 <br>");
                    try {
                        $node = $node[0][$n1];
                    } catch (Exception $ex) {
                        $this->pp('Exception', $node, false);
                    }
                }
            }
        } else {
            $node = $xml[$xmlelem];
        }
        return $node;
    }
    private function examin($tree, $elems){
        /*$this->pp('', $tree);
        $this->pp('', $elems);exit;*/
        $inserts = array();
        foreach ($elems as $key => $elem) {
            $inserts[$elem['elem']] = $this->xmlGetInserts($tree, $elem['elem'], $elem['table'], $elem['attribs']);
        }
        foreach ($inserts as $att => $insert) {
            $node = $this->getNode($att, $tree);
            $this->pp("<br>XXXXXXXXXXXXXXXXXXX<br>$att<br>", $node, false);
        }
        $this->pp('Inserts', $inserts);
        exit;
        $ret = array();
        if (count($elems['path']) == 0) {
            $ret = array();
            foreach ($elems['value'] as $yKey) {
                if (strpos($yKey, '@') !== false) {
                    $expl = explode('@', $yKey);
                    $expl1 = $expl[0];
                    $expl2 = $expl[1];
                    if (isset($tree[$expl1][0][$expl2])) {
                        $ret[$expl1 . '_' . $expl2] = $tree[$expl1][0][$expl2];
                    } else {
                        $ret[$expl1 . '_' . $expl2] = 'X';
                    }
                } else {
                    if (isset($tree[$yKey])) {
                        $ret[$yKey] = $tree[$yKey];
                    } else {
                        $ret[$yKey] = 'X';
                    }
                }
            }
        } else {
            //echo('Knoten<br>');
            $elem = reset($elems['path']);
            try {
                $key = $elem['key'];
            } catch (Exception $ex) {
                $this->pp('', $elems);
                exit;
                return ($ret);
            }
            $index = key($elems['path']);
            //$this->pp('A', $elem);
            //$this->pp('B', $key);
            //$this->pp('C', $index);
            unset($elems['path'][$index]);
            if ($key == '') {
                //echo('Mehrzahl<br>');
                $tree = $tree[$elem['elem']][0];
                $ret = $this->examin($tree, $elems);
            } else {
                $i = 1;
                foreach ($tree[$elem['elem']] as $subtree) {
                    $i++;
                    //$this->pp('Abstieg Sub: ', $subtree);
                    //$this->pp('Abstieg ele    ms: ', $elems);
                    $keyField = array();
                    $keyNeu = $key;
                    if (strpos($key, '@') !== false) {
                        $k = 1;
                        if (strpos($key, '+') !== false) {
                            $xPath = explode('+', $key);
                            $keyField[$k++] = $xPath[0];
                            $keyNeu = $xPath[1];
                        }
                        $xPath = explode('@', $keyNeu);
                        $keyField[$k++] = $xPath[0];
                        $keyField[$k] = $xPath[1];
                        //$this->pp($keyField1, $subtree[$keyField1]);exit;
                        if ($k > 2) {
                            $keyValue = $subtree[$keyField[1]] . "@" . $subtree[$keyField[2]][0][$keyField[3]];
                        } else {
                            try {
                                $keyValue = $subtree[$keyField[1]][0][$keyField[2]];
                            } catch (Exception $e) {
                                /*echo($keyField[1].'<br>');
                                echo($keyField[2].'<br>');
                                print_r($subtree[$keyField[1]]  );*/
                                $this->pp('Mist', '');
                                exit;
                            }
                        }
                    } else {
                        $keyValue = $subtree[$key];
                    }
                    $ret[$elem['elem']][$keyValue] = $this->examin($subtree, $elems);
                }
            }
        }
        return $ret;
    }
    private function parseXML($xml){
        $root = 'item';
        $result = array();
        $rootXML = $xml->{$root};
        $tree = $this->getSubTree($rootXML);
        $ret1 = array();
        $ret2 = array();
        $elems = array();
        $elems[] = array('elem' => 'assortments', 'table' => 'PPProdutpass_Assortments', 'attribs' => array('code', 'name', 'version', 'numberOfUnits', '+assortment'));
        $elems[] = array('elem' => 'assortments@assortment', 'table' => 'PPProdutpass_Assortment', 'attribs' => array('countryCodes', 'totalPackRatio', 'packingMethod@code', '+styles'));
        //$elems[] = array('elem' => 'assortments@assortment@styles','table' => 'none');
        $elems[] = array('elem' => 'assortments@assortment@styles@style', 'table' => 'PPProdutpass_AssortmentStyle', 'attribs' => array('productName', 'styleNo', 'vendorUniqueId', '+sizes'));
        //$elems[] = array('elem' => 'assortments@assortment@styles@style@sizes','table' => 'none');
        $elems[] = array('elem' => 'assortments@assortment@styles@style@sizes@size', 'table' => 'PPProdutpass_AssortmentStyleSize', 'attribs' => array('code', 'internalSeqNo', 'value'));
        $ret1 = $this->examin($tree, $elems);
        $insert = $this->XML2DB($ret1, 'assortments');
        exit;
    }
    private function XML2DB($values, $key){
        /*echo("Start XML2DB => <pre>");
        print_r($values);
        echo("</pre>");
        exit;*/
        foreach ($values as $key1 => $values1) {
            //echo("A: $key1 => <pre>");
            //print_r($values1);
            //echo("</pre>");
            echo ('<br>Anzahl1:' . count($values1));
            foreach ($values1 as $key2 => $values2) {
                //echo("B: $key2 => <pre>");
                //print_r($values2);
                //echo("</pre>");
                echo ('<br>Anzahl2:' . count($values2));
                foreach ($values2 as $key3 => $values3) {
                    //echo("C: $key3 => <pre>");
                    //print_r($values3);
                    //echo("</pre>");
                    echo ('<br>Anzahl3:' . count($values3));
                    foreach ($values3 as $key4 => $values4) {
                        //echo("D: $key4 => <pre>");
                        //print_r($values4);
                        //echo("</pre>");
                        echo ('<br>Anzahl4:' . count($values4));
                        foreach ($values4 as $key5 => $values5) {
                            //echo("E: $key5 => <pre>");
                            //print_r($values5);
                            //echo("</pre>");
                            echo ('<br>Anzahl5:' . count($values5));
                            foreach ($values5 as $key6 => $values6) {
                                //echo("F: $key6 => <pre>");
                                //print_r($values6);
                                //echo("</pre>");
                                echo ('<br>Anzahl6:' . count($values6));
                                foreach ($values6 as $key7 => $values7) {
                                    echo ("<br>Ergebnis: Key1: $key1 Key2: <b>$key2</b> Key3: $key3 Key4: <b>$key4</b> Key5: $key5 Key6: <b>$key6</b> Key7: $key7 => <b>$values7</b>< <br>");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    private function _XML2DB($values, $key){
        /*echo("Start XML2DB => <pre>");
          print_r($values);
        echo("</pre>");
        exit;*/
        foreach ($values as $table1 => $values1) {
            //echo("A: $table1 => <pre>");
            //echo("<br>assotrtment");
            foreach ($values1 as $key1 => $values2) {
                echo ("<br>Key1:  $key1 ");
                /*echo("</pre>");
            $table2 = $values[$key1];*/
                foreach ($values2 as $key2 => $values3) {
                    //echo("C:  $key2 => <pre>");
                    //echo("</pre>");
                    $table2 = $values2[$key2];
                    foreach ($table2 as $key3 => $values3) {
                        echo ("<br>Key3: $key3 ");
                        foreach ($values3 as $key4 => $values4) {
                            //echo("E:  $key4 => <pre>");
                            $table3 = $values3[$key4];
                            foreach ($table3 as $key5 => $values5) {
                                echo ("<br>Key5: $key5 ");
                                $table4 = $table3[$key5];
                                foreach ($table4 as $key6 => $values6) {
                                    echo ("$key1 <br>     $key3 <br>        $key5  = $values6 <br>");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    private function _importXML($input_file, $bForce = false, $bfinal = false, $zipInfos = null, $pInternerStatus = 'PLAN', $mailto = 'f.keppel@compecon.de', $returnPPId = false){
        /*echo ("File: $input_file Force: $bForce, Final: $final, Mailto: $mailto Interner Status: $InternerStatus <br><pre>");
        print_r($zipInfos);
        exit;*/
        $this->revision_von  = 0;
        $this->XMLUploadFile = $input_file;
        $force               = $bForce;
        $final               = $bfinal;
        $this->xml = $this->readXML($this->XMLUploadFile, true);
        $this->xml_item = $this->xml->item;
        $ian = $this->xml_item->ian;
        $ausm = $this->xml_item->selectionNo;
        $testFile = $this->XMLUploadFile;
        if (strpos($this->XMLUploadFile, "storage") === false) {
            $testFile = $path     = public_path() . '/data/import/XML/' . $this->XMLUploadFile;
        }
        $this->schemaVersion = $this->getSchemaVersion($testFile);
        //cpcDebug::cpc_debug('TESTFile in _import:' . $testFile, 'XML');
        $this->revision = 0;
        $ppid = $this->getID($ian, $ausm);
        /*if (strtoupper(Auth::user()->PPMitarbeiter_Kuerzel) == 'FKE') {
            $this->parseXML($this->xml);
            exit;
        }*/
        $InternerStatus = $pInternerStatus;
        cpcdebug::cpc_debug("Vorhandener PPID: $ppid Final: $final Force: $force", '-T261');
        if ($ppid != 0 ) {
            if ($force) {
                $result = $this->savePrevPP($ppid);
                cpcDebug::cpc_debug("Force Import for PPID: $ppid", '-T261');
                cpcDebug::cpc_debug($result, '-T261');
                if ($result['Result']) {
                    cpcDebug::cpc_debug('Result', '-T261');
                    if (in_array($result['InternerStatus'], array('ABSAGE', 'GELIEFERT', 'FIX'), true)) {
                        $InternerStatus = $result['InternerStatus'];
                        cpcDebug::cpc_debug("Interner Status preserved: $InternerStatus", '-T261');
                    }
                }
            } else {
                return $this->viewForceImport($this->XMLUploadFile, $mailto, $this->forceZipFile);
            }
        }
        cpcDebug::cpc_debug("PrevPPId berücksichtigt: $ppid InternerStatus: $InternerStatus", '-T261');
        $json           = json_encode($this->xml);
        $this->xmlArray = json_decode($json, TRUE);
        $import = array();
        if ($final) {
            $import_Final = $this->getXMLVarValues("PPProduktpass_Menge");
            if ($ppid != 0) {
                $this->insert('PPProduktpass_Menge_Final', $import_Final, $ppid);
            }
            return $this->viewSuccessImport($ppid, $mailto);
        } else {
            $import['tPPProduktpass']          = $this->getXMLVarValues("tPPProduktpass");
            $import['PPProduktpass_Qualitaet'] = $this->getXMLVarValues("PPProduktpass_Qualitaet");
            $import['PPProduktpass_Qualitaet'] = $this->handleQuality($import['PPProduktpass_Qualitaet']);
            $import['PPProduktpass_Style']      = $this->getXMLVarValues("PPProduktpass_Style");
            $import['PPProduktpass_KLLink']      = $this->getXMLVarValues("PPProduktpass_KLLink");
            //echo('<pre>'); print_r($import['PPProduktpass_KLLink']); echo('</pre>'); exit;
            $import['PPProduktpass_Sortierung'] = $this->getXMLVarValues("PPProduktpass_Sortierung");
            $import['PPProduktpass_Sortierung'] = $this->check_sort($import['PPProduktpass_Sortierung']);
            //echo('<pre>'); print_r($import['PPProduktpass_Sortierung']); echo('</pre>'); exit;
            $import['PPProduktpass_Menge'] = $this->getXMLVarValues("PPProduktpass_Menge");
            $import['PPXML_OSMengen']      = $this->getXMLVarValues("PPXML_OSMengen");
            $import['PPXML_Mengen']        = $this->getXMLVarValues("PPXML_Mengen");
            //$this->prncpc($import['PPXML_OSMengen']);
            $import['PPAssortments']        = $this->getXMLVarValues("PPAssortments");
            $import['PPAssortmentStyles']        = $this->getXMLVarValues("PPAssortmentStyles");
            $import['PPOrder']        = $this->getXMLVarValues("PPOrder");
            $import['PPOrderWeights']        = $this->getXMLVarValues("PPOrderWeights");
            $import['PPLsv']        = $this->getXMLVarValues("PPLsv");
            $import['PPAssortments']        = $this->getXMLVarValues("PPAssortments");
            $import['retailPackaging']        = $this->getXMLVarValues("retailPackaging");
            //$import['tPPProduktpass'][0][0]['InternerStatus'] = $InternerStatus;
            $new_ppid = $this->doInserts($import);
            $this->postInsert($new_ppid);
            $this->handleZipImport($new_ppid, $zipInfos);
            $this->preserveInternerStatus($new_ppid, $InternerStatus);
            if ($returnPPId) {
                $this->viewSuccessImport($new_ppid, $mailto);
                return $new_ppid;
            } else {
                return $this->viewSuccessImport($new_ppid, $mailto);
            }
        }
    }
    private function preserveInternerStatus($ppid, $status){
        cpcDebug::cpc_debug("Preserve Interner Status: $status for PPID: $ppid", '-T261');
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp) {
            $pp->InternerStatus = $status;
            $pp->save();
        }
    }
    private function prncpc($var){
        echo (date('d.m.Y H:i:s') . ':<br><pre>');
        print_r($var);
        echo ('</pre>');
        exit;
    }
    public function handleZipImport($ppid, $zipInfos){
        if (is_null($zipInfos)) {
            return;
        }
        if (!is_array($zipInfos)) {
            return;
        }
        if (count($zipInfos) < 1) {
            return;
        }
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        $IAN = '';
        if ($pp) {
            $IAN = $pp->PPProduktpass_IAN;
        }
        foreach ($zipInfos as $info1) {
            $info = json_decode(json_encode($info1), true);
            //echo($info['path'].$info['filename']."<br>");
            $newFile = str_random(6) . "_" . $info['filename'];
            try {
                rename($info['path'] . $info['filename'], $this->UPLOAD_Path . $newFile);
            } catch (Exception $e) {
                echo ("<br>" . $info['path'] . $info['filename'] . "<b> ->  </b>" . $this->UPLOAD_Path . $newFile . "<br>");
            }
            $pathInfo = pathinfo($info['filename']);
            $ext = $pathInfo['extension'];
            $fn = $pathInfo['filename'];
            $tempsubcat = 'Diverses';
            if ($fn == $IAN) {
                $tempsubcat = 'Projektbild';
            }
            switch (strtoupper($ext)) {
                case 'PNG':
                    $subcat = $tempsubcat;
                    break;
                case 'JPG':
                    $subcat = $tempsubcat;
                    break;
                case 'JEPG':
                    $subcat = $tempsubcat;
                    break;
                case 'GIF':
                    $subcat = $tempsubcat;
                    break;
                case 'PDF':
                    $subcat = 'PDFs';
                    break;
                default:
                    $subcat = 'Diverses';
                    break;
            }
            $this->uploadFile($ppid, $newFile, $subcat);
        }
    }
    private function handleQuality($q){
        /* Umwandlung der eingelesenen Qualitäten:
         * Zuordnung der Merkmale zu dem jeweiligen Styles
         */
        $qres    = array();
        $qkeys   = array();
        $qvalues = array();
        $styleNdxs = array();
        $disjunktArray = array();
        $i = 0;
        $k = 1;
        foreach ($q as $q1) {
            foreach ($q1 as $q2) {
                foreach ($q2 as $key => $value) {
                    //echo("$key => $value ");
                    if (strpos($key, "Header") !== false) {
                        if (in_array($value, $disjunktArray)) {
                            $hndx = $value . "@" . mt_rand(100, 999);
                        } else {
                            $hndx = $value;
                        }
                        $disjunktArray[] = $hndx;
                        $i++;
                    }
                    if (strpos($key, "StyleNo") !== false) {
                        $index                        = substr($key, strlen($key) - 2, 2);
                        $qres[$hndx][$index]['Style'] = "";
                        if (gettype($value) != 'boolean' and !is_array($value)) {
                            try {
                                if (!array_key_exists($value, $styleNdxs)) {
                                    $styleNdxs[$value] = $k;
                                    $k++;
                                }
                                $qres[$hndx][$index]['Style'] = $value;
                            } catch (Exception $e) {
                                echo ($e->getMessage());
                                echo ("CATCH");
                                var_dump(gettype($value));
                                exit;
                            }
                        }
                    }
                    if (strpos($key, "Value") !== false) {
                        $index                        = substr($key, strlen($key) - 2, 2);
                        $qres[$hndx][$index]['Value'] = $value;
                    }
                }
            }
        }
        $i = 0;
        $qres2 = array();
        foreach ($qres as $header => $qqual) {
            // echo("Header: $header: <br>");
            //cpcDebug::dd($qqual, 0);
            $aHeader                                        = explode("@", $header);
            $qres3[$i][0]['PPProduktpass_Qualitaet_Header'] = $aHeader[0];
            foreach ($qqual as $style) {
                //print_r($style);
                $ndx = "";
                if (array_key_exists($style['Style'], $styleNdxs)) {
                    $ndx = $styleNdxs[$style['Style']];
                }
                if ($ndx != "") {
                    $sndx = $ndx;
                    if ($ndx < 10) {
                        $sndx = "0" . $ndx;
                    }
                    $qres3[$i][0]['PPProduktpass_Qualitaet_Value' . $sndx] = $style['Value'];;
                }
            }
            $i++;
        }
        return ($qres3);
    }
    private function uploadAndUnpackZip($file, $IsInq = false){
        $destinationPath = public_path() . "/data/import/XML/Zip";
        //echo("<pre>");print_r($file->getPathName());exit;
        $filename = str_random(6) . "_" . $file->getClientOriginalName();
        /*echo("$destinationPath => $filename <br></pre><pre>");
          print_r($file);
          echo("</pre>");
          exit; */
        try {
            $file->move($destinationPath, $filename);
        } catch (Exception $e) {
            echo ($e->getMessage());
            exit;
        }
        $zip = new ZipArchive;
        if ($zip->open($destinationPath . "/" . $filename) === TRUE) {
            $zipPath = $destinationPath . "/" . basename($filename, '.zip');
            mkdir($zipPath);
            $zip->extractTo($zipPath);
            $zip->close();
            $dir = new DirectoryIterator($zipPath);
            $unpackedFiles = array();
            $unpackedFiles['infos'] = null;
            $unpackedFiles['xml'] = null;
            foreach ($dir as $fileinfo) {
                //echo("Dir: ". $fileinfo->getFilename())."<br>";
                //echo("  Tape: ". $fileinfo->getType())."<br>";
                if ($fileinfo->getType()  ==  'dir' and strlen($fileinfo->getFilename()) > 2) {
                    $subdir = new DirectoryIterator($zipPath . "/" . $fileinfo->getFilename());
                    foreach ($subdir as $subfileinfo) {
                        if ($subfileinfo->getType()  !=  'dir') {
                            if (strpos(strtoupper($subfileinfo->getFilename()), '.XML') === false) {
                                $info = array('path' =>  $zipPath . "/" . $fileinfo->getFilename() . "/", 'filename' => $subfileinfo->getFilename());
                                $unpackedFiles['infos'][] = $info;
                            } else {
                                $unpackedFiles['xml']['path'] = $zipPath . "/" . $fileinfo->getFilename() . "/";
                                $unpackedFiles['xml']['filename'] = $subfileinfo->getFilename();
                            }
                        }
                    }
                }
            }
            $orgFile = $unpackedFiles['xml']['filename'];
            $this->XMLPath . $unpackedFiles['xml']['filename'] = str_random(6) . "_" . $unpackedFiles['xml']['filename'];
            rename($unpackedFiles['xml']['path'] . $orgFile, $this->XMLPath . $unpackedFiles['xml']['filename']);
            return $unpackedFiles;
        }
        return false;
    }
    private function upload($file, $IsInq = false){
        $destinationPath = $this->XMLPath;
        if ($IsInq) {
            $destinationPath .= "Inquiries/";
        }
        $filename = str_random(6) . "_" . $file->getClientOriginalName();
        /* echo("$destinationPath => $filename <br></pre><pre>");
          print_r($file);
          echo("</pre>");
          exit; */
        try {
            $file->move($destinationPath, $filename);
        } catch (Exception $e) {
            echo ($e->getMessage());
            exit;
        }
        return $filename;
    }
    private function importDir($dir){
        $handle = opendir($dir);
        //echo("importDir dir: $dir <br>");
        $dirsplit = explode("_", basename($dir));
        //print_r($dirsplit);
        $ian = $dirsplit[2];
        $files = array();
        while (($fileEntry = readdir($handle)) !== false) {
            $file = $dir . "/" . $fileEntry;
            if (is_dir($file)) {
                //echo("Updir $fileEntry <br>");
                continue;
            }
            if (strpos($fileEntry, ".xml") !== false) {
                $files['XML'] = $file;
                //echo("XML-Datei: $fileEntry <br>");
                continue;
            }
            $projektpic = $ian . ".";
            if (strpos($fileEntry, $projektpic) !== false) {
                $files['Projektbild'] = $file;
                //echo("Projekt-Bild: $fileEntry <br>");
                continue;
            }
            if (strpos($fileEntry, "ExcelImportImg") !== false) {
                //echo("Pflegesymbole: $fileEntry <br>");
                $files['Pflegesymbole'] = $file;
                continue;
            }
            $pi = pathinfo($file);
            if (strtoupper($pi['extension']) == "PDF") {
                //echo("PDF-Datei: $fileEntry <br>");
                $files['PDFs'][] = $file;
                continue;
            }
            if (strpos("PNG BMP JPEG JPG GIF", strtoupper($pi['extension'])) !== false) {
                //echo("PDF-Datei: $fileEntry <br>");
                $files['Bilder'][] = $file;
                continue;
            }
            //echo("Sonstige-Datei: $fileEntry <br>");
            $files['Sonstige'][] = $file;
        }
        $ret = array("IAN" => $ian, "Files" => $files);
        return $ret;
    }
    private function handleZip($zipPath){
        //echo("Import Dir: $zipPath <br>");
        $importDirs = array();
        $handle1    = opendir($zipPath);
        while (($dirEntry   = readdir($handle1)) !== false) {
            $dir = $zipPath . "/" . $dirEntry;
            //echo("XXXEnter Dir: $dir <br>");
            if (is_dir($dir) and strpos($dir, ".") === false) {
                $importDir                     = $this->importDir($dir);
                $importDirs[$importDir['IAN']] = $importDir['Files'];
            }
        }
        return $importDirs;
    }
    private function uploadAndunzip($file){
        $destinationPath = $this->XMLPath . "Zip";
        $zipPath         = $this->XMLPath . "Zip/" . str_random(6);
        $filename       = str_random(6) . "_" . $file->getClientOriginalName();
        $upload_success = $file->move($destinationPath, $filename);
        echo ("$destinationPath <br> $zipPath <br> $filename<br>");
        exit;
        $zip = new ZipArchive;
        if ($zip->open($destinationPath . "/" . $filename) === TRUE) {
            //echo("Importiere ZIP: " . $destinationPath . "/" . $filename . "<br>");
            $zip->extractTo($zipPath);
            $zip->close();
            $dirs = $this->handleZip($zipPath);
            return $dirs;
        } else {
            return false;
        }
    }
    private function _makeDirs(){
        $dir = storage_path() . "/data/Import/tmp/" . date('Ymdhis');
        $dir2 = $dir . "/UnZip";
        //echo($dir);exit;
        if (!file_exists($dir)) {
            try {
                mkdir($dir);
                chmod($dir, 0777);
            } catch (Exception $ex) {
                echo ("<br> <b>$dir konnte nicht angelegt werden!</b><br>");
                print_r($ex->getMessage());
                exit;
            }
        }
        try {
            mkdir($dir2);
            chmod($dir2, 0777);
        } catch (Exception $ex) {
            echo ("<br>UnzipDir <b>$dir2 konnte nicht angelegt werden!</b><br>");
            print_r($ex->getMessage());
            exit;
        }
        return $dir;
    }
    public function uploadMultiZipForm(){
        return View::make('UploadMassen');
    }
    private function importDirMass($dir){
        $handle = opendir($dir);
        //echo("importDir dir: $dir <br>");exit;
        $dirsplit = explode("_", basename($dir));
        //print_r($dirsplit);
        $ian = $dirsplit[2];
        //echo("<br>IAN: $ian <br>");
        $files = array();
        while (($fileEntry = readdir($handle)) !== false) {
            $file = $dir . "/" . $fileEntry;
            if (is_dir($file)) {
                //echo("Updir $fileEntry <br>");
                continue;
            }
            if (strpos($fileEntry, ".xml") !== false) {
                $xmlfile = str_random(6) . "_" . $fileEntry;
                $xmlpath = public_path() . "/data/import/XML/";
                $oldfile = $file;
                $newfile = $xmlpath . $xmlfile;
                rename($oldfile, $newfile);
                $files['XML'] = $xmlfile;
                //echo("XML-Datei: $fileEntry <br>");
                continue;
            } else {
                $pathParts = pathinfo($file);
                $files['Files'][] = array('path' => $pathParts['dirname'] . "/", 'filename' => $pathParts['filename'] . '.' . $pathParts['extension']);
            }
        }
        if (count($files) == 0) {
            $files = null;
        }
        return array('IAN' => $ian, 'Files' => $files);
    }
    private function massenImport($zipFile, $InternerStatus, $mailto){
        //umask(0);
        $filename = $zipFile->getClientOriginalName();
        $destinationPath = $this->_makeDirs();
        $zipPath = $destinationPath . "/UnZip";
        try {
            //chmod($destinationPath, '0777');
            //chmod($zipPath, '0777');
            $zipFile->move($destinationPath, $filename);
            $zip = new ZipArchive;
            if ($zip->open($destinationPath . "/" . $filename) === TRUE) {
                $zip->extractTo($zipPath);
                $zip->close();
                //$dirs = $this->handleZip($zipPath);
                //return $dirs;
            }
        } catch (Exception $e) {
            echo ("Exception: " . $destinationPath . "  Zip: $zipPath  <br>");
            echo ($e->getMessage());
            exit;
        }
        $importDirs = scandir($zipPath);
        $FilesImport = array();
        foreach ($importDirs as $importDir) {
            if (strlen($importDir) > 3) {
                $fileImport                     = $this->importDirMass($zipPath . "/" . $importDir);
                if (count($fileImport['Files']) > 0) {
                    if (isset($FilesImport[$fileImport['IAN']]) and count($FilesImport[$fileImport['IAN']]) > 0) {
                        $FilesImport[$fileImport['IAN'] . "_" . str_random(6)] = $fileImport['Files'];
                    } else {
                        $FilesImport[$fileImport['IAN']] = $fileImport['Files'];
                    }
                    //$FilesImport[$fileImport['IAN']] = $fileImport['Files'];
                } else {
                    $FilesImport[$fileImport['IAN']] = null;
                }
            }
        }
        echo ("<div style='margin:20px;padding:20px;font-family:Tahoma,Geneva,Verdana,sans-serif;font-size:12px;border:2px solid darkblue;'> ");
        echo ("<div style='padding:10px;'><a href='http://" . $_SERVER['SERVER_NAME'] . "/home' style='text-decoration:none;'><div style='color:white;background-color:dodgerblue;width:112px;height:15px;padding:10px;'><b>Zurück zum Menu</b></div></a><div>");
        foreach ($FilesImport as $keyIAN => $fileImport) {
            $key = substr($keyIAN, 0, 6);
            $xml = $fileImport['XML'];
            $zipInfo = null;
            if (isset($fileImport['Files'])) {
                $zipInfo = $fileImport['Files'];
            }
            // hier REturn ppid einbauen
            $ppid = $this->_importXML($xml, true, false, $zipInfo, $InternerStatus, $mailto, true);
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->orderBy('PPProduktpass_Id', 'DESC')->get()->first();
            echo ("<div style='font-family:Tahoma,Geneva,Verdana,sans-serif;font-size:12px;width:800px;padding:5px;'><a href='http://" . $_SERVER['SERVER_NAME'] . "/show/" . $pp->PPProduktpass_Id . "' target='_BLANK' style='text-decoration:none;'><b>IAN: $key</b>");
            $article = 'NN';
            $ausm = '';
            if ($pp) {
                $article  = $pp->PPProduktpass_Artikelbezeichnung;
                $ausm =     $pp->PPProduktpass_Ausmusterungnummer;
            }
            echo (" $ausm  $article </a>  eingelesen!</div>");
        }
        echo ("</div>");
    }
    public function uploadMassenImport(){
        $internerStatus = Input::get('InternerStatus');
        $this->LTWoche = Input::get('LTWoche');
        $this->LTJahr = Input::get('LTJahr');
        $mailto = Input::get('mailto');
        if (Input::hasFile('MultiZip')) {
            $zip = Input::file('MultiZip');
            $this->massenImport($zip,  $internerStatus, $mailto);
        } else {
            echo ("No Go");
        }
    }
    private function calcCRD($ppid){
        $pp = tPPProduktpass::find($ppid);
        if (!$pp) {
            return;
        }
        $w = $pp->PPProduktpass_Liefertermin;
        $y = $pp->PPProduktpass_LieferterminJahr;
        if ($y == 9999) {
            //CRD bleibt unverändert
            return;
        }
        // Überprüfe ob CRD manuell geändert wurde.
        $pro = PPProtokoll::where('PPProtokoll_PPProduktpass_Id', $pp->PPProduktpass_Id)->where('PPProtokoll_Feld', 'PPProduktpass_CRDWoche')->get()->first();
        if ($pro) {
            //wurde manuell geäöndert => keine Änderung des CRD
            //cpcDebug::pe("Protokoll gefunden!", 1);
            return;
        }
        $pro = PPProtokoll::where('PPProtokoll_PPProduktpass_Id', $pp->PPProduktpass_RevisionVon_PPProduktpass_Id)->where('PPProtokoll_Feld', 'PPProduktpass_CRDWoche')->get()->first();
        if ($pro) {
            //wurde manuell geäöndert => keine Änderung des CRD
            //cpcDebug::pe("Protokoll gefunden!", 1);
            return;
        }
        //cpcDebug::pe("Protokoll nicht gefunden!", 1);
        //Berechne CRD 8 Wochen vor DDP
        $crd = new DateTime();
        try {
            $crd->setISODate($y, $w, 5);
            $weeks = new DateInterval("P9W");
            $crd = $crd->sub($weeks);
            $wCRD = $crd->format('W');
            $yCRD = $crd->format('Y');
        } catch (Exception $ex) {
            return;
        }
        //cpcDebug::pe("Y: $yCRD W: $wCRD", 1);
        $pp->PPProduktpass_CRDJahr = $yCRD;
        $pp->PPProduktpass_CRDWoche = $wCRD;
        $pp->save();
    }
    private function setKeyIds($xml, $diff){
        //echo('<pre>');print_r($diff);echo('</pre>');
        $ret = array();
        foreach ($diff as $key => $value) {
            //echo("$key <br>  <pre> ");print_r($this->getXMLValueFromIndex($xml, $this->splitKey($key)));echo('</pre><br>');
            $ret[$key] = $this->getXMLValueFromIndex($xml, $this->splitKey($key));
        }
        return ($ret);
    }
    private function splitKey($key){
        $keya = explode('->', $key);
        $count = count($keya);
        $index = 0;
        $indexkey = '';
        $parent = array();
        if ($count > 1) {
            $indexkey = $keya[$count - 2];
            $index = $keya[$count - 1];
            for ($i = 1; $i < $count - 2; $i++) {
                $parent[] = $keya[$i];
            }
        }
        $ret = array('Path' => $parent, 'Key' => $indexkey, 'Index' => $index);
        //echo('splitKey:<br><pre>');
        //print_r($ret);
        //echo('</pre>Ende splitKey<br>');
        return ($ret);
    }
    private function getXMLValueFromIndex($xml, $pathinfo){
        $ps = $pathinfo['Path'];
        $key = $pathinfo['Key'];
        $index = $pathinfo['Index'];
        $count = count($ps);
        if ($key == 'quantity') {
            try {
                $z = (string) $xml->item->quantities->quantity[intval($index)]->country->code;
                return $z;
            } catch (Exception $ex) {
                echo ("NN<br>");
            }
        }
        if ($key == 'styles') {
            try {
                $ndx = intval($index);
                $z = 'Style: ' . (string) $xml->item->styles->style[intval($index)]->styleNo;
                if ($ndx == 0) {
                    $z = 'Style: ' . (string) $xml->item->styles->style->styleNo;
                }
                return $z;
            } catch (Exception $ex) {
                echo ("NN<br>");
            }
        }
        return null;
    }
    private function hasQuantityChange($diff){
        $ret = array();
        foreach ($diff as $key => $value) {
            //echo($key . '<br>');
            if (strpos($key, 'quantity') !== false) {
                return true;
            }
        }
        return false;
    }
    public function diffXML ($ppid, $fid, $email = false){
        $pp = tPPProduktpass::find($ppid);
        $file1  =  $pp->PPProduktpass_AktExcel;
        if ($fid > 0){
            $ppf    = PPPPFiles::where("PPPPFiles_Id", "=", $fid)->get()->first();
            $file2  = $ppf->PPPPFiles_TPTFilenameOld;
            return $this->_diffXML ($ppid, $pp->PPProduktpass_IAN, $file1, $file2, '', false, $email, $fid);
        }
    }
    private function _diffXML ($ppid, $ian, $file1, $file2, $message, $retDiff, $neu = false , $email = false, $fid = 0){
        $subdata['diffs'] = null;
        $subdata['message'] = "";
        cpcDebug::cpc_debug("_diffXML: $ppid, $ian, $file1, $file2", '@DiffXML');
        if (!is_null($file1) and !is_null($file2) and strlen($file1) > 0 and strlen($file2) > 0) {
            $_file1 = public_path() . "/data/import/XML/" . $file1;
            $_file2 = public_path() . "/data/import/XML/" . $file2;
            $fehler = false;
            if (is_dir($_file1)){
                echo("$ppid : $file1  ist Directoty<br>");
                $fehler = True;
            }
            if (is_dir($_file2)){
                echo("$ppid : $file2  ist Directoty<br>");
                $fehler = True;
            }
            if (! file_exists($_file1)){
                echo("$ppid : $file1  existiert nicht<br>");
                $fehler = True;
            }
            if (! file_exists($_file2)){
                echo("$ppid : $file2  existiert nicht<br>");
                $fehler = True;
            }
            if ($fehler){
                echo("Fehler bei der Verarbeitung<br>");
                exit;
            }
            /*if (file_exists($_file2) and !is_dir($_file2) and file_exists($_file1) and !is_dir($_file1)) {*/
            if (!$fehler){
                $xml_item = $this->readXML($_file2, true);
                $xml_diff = $this->readXML($_file1, true);
                //$this->prepareArray($file2);
                if ($xml_diff and $xml_item){
                    try {
                        $v1 = $this->getXMLDiffNew($xml_item, $xml_diff, array(), "item");
                        cpcDebug::cpc_debug($v1,'@Diff0306_1');
                        $subdata['diffs'] = $this->getXMLDiffNew($xml_diff, $xml_item, $v1, "item");
                        cpcDebug::cpc_debug($subdata['diffs'],'@Diff0306_2');
                        if ($retDiff) {
                            return $subdata['diffs'];
                        }
                        $subdata['keys'] = $this->setKeyIds($xml_diff, $subdata['diffs']);
                    } catch (Exception $e) {
                        echo ($e->getMessage());
                        echo ("<br>Fehler beim Vergleich!<br>");
                        exit;
                    }
                    $subdata['message'] = $message;
                } else {
                    $subdata['message'] = "Produktpass IAN: " . $ian . " eingelesen. <br> Keine XML-Vorversion vorhanden.<br><br> <a href='http://" . $_SERVER['SERVER_NAME'] . "/show/" . $ppid . "'>Link zum Produktpass</a>";
                }
            } else {
                $subdata['message'] = "Produktpass IAN: " . $ian . " eingelesen. <br> Keine XML-Vorversion vorhanden.<br><br> <a href='http://" . $_SERVER['SERVER_NAME'] . "/show/" . $ppid . "'>Link zum Produktpass</a>";
            }
        } else {
            $subdata['message'] = "Produktpass IAN: " . $ian . " eingelesen. <br> Keine XML-Vorversion vorhanden.<br><br> <a href='http://" . $_SERVER['SERVER_NAME'] . "/show/" . $ppid . "'>Link zum Produktpass</a>";
        }
        //echo('<pre>');        print_r($subdata['diffs']);        echo('</pre>');        exit;
        $xml  = new XMLController;
        $Sals = $xml->getSALs();
        View::share('SALs', $Sals);
        //if ($neu){
            $diff['diffs'] = $this->prepareArray($file1, $file2);
            //$this->px($diff['diffs']);
            $diff['message'] = ServiceProvider::tl('EN','Unterschiede in den XML-Dateien' ); ;
            $diff['pp']  = array('ppid' => $ppid, 'ian' => $ian);
            $fileid = $fid;
            if ($fid == 0){
                $fileid = $this->getFIdFromFilename($file2, $ppid);
            }
            $diff['fileId']  = $fileid;
            $view = 'helpers.printDiffsNeu';
            if ($email){
                cpcDebug::cpc_debug('EMAIL', '@Files');
                $view = 'helpers.printDiffs_email';
            }
            cpcDebug::cpc_debug($view, '@printDiffs');
            $data['content'] = View::make($view)->with('diffs', $diff);
        //} else {
        //    $data['content'] = View::make('helpers.printDiffs')->with('diffs', $subdata);
        //}
        return $data['content'];
    }
    private function prepareArray($fileNew, $fileOld){
        $xmlNew = $this->readXML($fileNew, true);
        $xmlOld = $this->readXML($fileOld, true);
        $je = json_encode($xmlNew);
        $xmlaNew  = json_decode($je,TRUE);
        $je = json_encode($xmlOld);
        $xmlaOld  = json_decode($je,TRUE);
        $ret = $this->compare($xmlaOld, $xmlaNew);
        //$this->px($ret);
        return $ret;
    }
    private function compareSubTreeX ($new, $old){
        echo('########' . date('His') . '##################################<br><pre>');
        $ret = ServiceProvider::diffArray( $old, $new);
        echo('++++++++++++++++++++++++++++++++++++++++<br><pre>');
        print_r($ret);
        echo('</pre>------------------------------------------<br>');
        $retArray = array();
        foreach($new as $key => $val){
            if (isset($old[$key])){
                //echo('<br>IS Array NEW<br>');
                //$retArray[$key] = array_diff($new[$key], $old[$key]);
                $oldString = json_encode($old[$key]);
                $newString = json_encode($new[$key]);
                $retArray[$key]['Old'] =  $oldString; 
                $retArray[$key]['New'] =  $newString; 
                if (strcmp($oldString, $newString) == 0){
                    $retArray[$key]['Diff'] = 'EQUEL';
                } else {
                    //$retArray[$key]['Diff'] = ServiceProvider::diffJson( json_encode($new[$key]), json_encode($old[$key])); 
                    $retArray[$key]['Diff'] = ServiceProvider::diffArray( $new[$key], $old[$key]); 
            }
            } else {
                $retArray[$key] = 'No Old Value';
            }
        }
        return $retArray;
    }
    private function compareSubTreeX2 ($new, $old){
        $retArray['Old'] = $old;
        $retArray['New'] = $new;
        $retArray['Diff'] = ServiceProvider::diffArray( $new, $old); 
        echo('Alt1:##############################################<br><pre>');        
        print_r($retArray['Old']);
        echo('</pre>');      
        echo('Neu:<pre>');        
        print_r($retArray['New']);
        echo('</pre>');        
        echo('Ergebnis:<pre>');        
        print_r($retArray['Diff']);
        echo('</pre>');      
        return $retArray;
    }
    private function compareSubTree ($old, $new){
        /*echo('Alt:##############################################<br><pre>');        
        print_r($old);
        echo('</pre>');      
        echo('Neu:<pre>');        
        print_r($new);
        echo('</pre>');        */
        $retarray = array();
        if (is_array($old)){
            foreach($old as $key => $val){
                if (is_array($val)){
                    if (isset($new[$key])){
                        $retarray[$key] =  $this->compareSubTree($new[$key], $old[$key]);
                    } else {
                        $retarray[$key]['Diff'] = 1;
                        $valnew = isset($new[$key])?$new[$key]:'NODATA';
                        $retarray[$key]['Val'] = array('Old' => $val, 'New' => $valnew);
                    }
                } else {
                    $retarray[$key]['Diff'] = 0;
                    $valnew = isset($new[$key])?$new[$key]:'NODATA';
                    if ($val != $valnew ){
                        $retarray[$key]['Diff'] = 1;
                        $retarray[$key]['Val'] = array('Old' => $val, 'New' => $valnew);
                    }  else {
                        $retarray[$key]['Val'] = $val;
                    }
                } 
            }
        } else {
            //$retarray = $old;
        }
        if (is_array($new)){
            foreach($new as $key => $val){
                if (is_array($val)){
                    if (isset($old[$key])){
                        $retarray[$key] =  $this->compareSubTree($old[$key], $new[$key]);
                    } else {
                        $retarray[$key]['Diff'] = 1;
                        $valold = isset($old[$key])?$old[$key]:'NODATA';
                        $retarray[$key]['Val'] = array('Old' => $valold, 'New' => $new);
                    }
                } else {
                    $retarray[$key]['Diff'] = 0;
                    $valold = isset($old[$key])?$old[$key]:'NODATA';
                    if ($val != $valold ){
                        $retarray[$key]['Diff'] = 1;
                        $retarray[$key]['Val'] = array('Old' => $valold, 'New' => $val);
                    }  else {
                        $retarray[$key]['Val'] = $val;
                    }
                } 
            }
        } else {
            //$retarray = $old;
        }
        //echo('Return:<pre>');        
        //print_r($retarray);
        //echo('</pre>');       
        return $retarray;
    }
    private function getsubArray($a, $keys){
        $ret = $a;
        echo('<br>keys:<br><pre>');
        print_r($keys);
        echo('</pre>');
        if (!is_array($keys)){
            if (isset($ret[$keys])){
                echo('1:'.$ret[$keys]);
                return $ret[$keys];
            } else {
                echo('<br>2:<br><pre>');
                print_r($a);
                echo('</pre>');
                return $a;
            }
        }
        foreach($keys as $key){
            if (is_array($key)){
                echo('<br>3a:<br><pre>');
                print_r($key);
                echo('</pre>');
            } else {
                echo('<br>3:<br>'.$key);
            }
            if (isset($ret[$key])){
                $ret = $ret[$key];
            } 
        }
        if (is_array($ret)){
            echo('<br>4a:<br><pre>');
            print_r($ret);
            echo('</pre>');
        } else {
            echo('<br>4:<br>'.$ret);
        }
        return $ret;
    }
    private function prepareTree (&$xml){
        //echo('Start<br>');
        //print_r($xml);
        if (!is_array($xml)){
            return $xml;
        }
        foreach($xml as $key => $item){
            if (!is_array($item)){
                //echo("$key => $item <br>");
            } else {
                //echo("Analysiere: $key<br>");
                switch (true) {
                    case (strcmp('localQuantity', $key) === 0):
                        foreach($xml['localQuantity'] as $k1 => $arr1){
                            //echo($k1.' = Key <br>');
                            if (isset($arr1['styleNo'])){
                                $newKey = $arr1['styleNo'];
                                if(isset($arr1['lsv']['code'])){
                                    $newKey .= $arr1['lsv']['code'];
                                }
                                $xml['localQuantity'][$newKey] = $arr1; 
                                unset($xml['localQuantity'][$k1]);
                            }
                        }
                        $this->prepareTree($xml['localQuantity']);
                        break;
                    case (strcmp('onlineQuantity', $key) === 0):
                        foreach($xml['onlineQuantity'] as $k1 => $arr1){
                            //echo($k1.' = Key <br>');
                            if (isset($arr1['styleNo'])){
                                $newKey = $arr1['styleNo'];
                                if(isset($arr1['lsv']['code'])){
                                    $newKey .= $arr1['lsv']['code'];
                                }
                                $xml['onlineQuantity'][$newKey] = $arr1; 
                                unset($xml['onlineQuantity'][$k1]);
                            }
                        }
                        $this->prepareTree($xml['localQuantity']);
                        break;
                        case (strcmp('quantity', $key) === 0):
                            foreach($xml['quantity'] as $k1 => $arr1){
                                //echo($k1.' = Key <br>');
                                if (isset($arr1['country']['code'])){
                                    $newKey = $arr1['country']['code'];
                                    $xml['quantity'][$newKey] = $arr1; 
                                    unset($xml['quantity'][$k1]);
                                }
                            }
                            $this->prepareTree($xml['quantity']);
                            break;
                        case (strcmp('quantityPerCountry', $key) === 0):
                            foreach($xml['quantityPerCountry'] as $k1 => $arr1){
                                //echo($k1.' = Key <br>');
                                if (isset($arr1['country']['code'])){
                                    $newKey = $arr1['country']['code'];
                                    $xml['quantityPerCountry'][$newKey] = $arr1; 
                                    unset($xml['quantityPerCountry'][$k1]);
                                }
                            }
                            $this->prepareTree($xml['quantityPerCountry']);
                            break;
                        case (strcmp('onlineQuantity', $key) === 0):
                            foreach($xml['onlineQuantity'] as $k1 => $arr1){
                                //echo($k1.' = Key <br>');
                                if(isset($arr1['styleNo'])){
                                    $newKey = $arr1['styleNo'];
                                    $xml['onlineQuantity'][$newKey] = $arr1; 
                                    unset($xml['onlineQuantity'][$k1]);
                                }
                            }
                            $this->prepareTree($xml['onlineQuantity']);
                            break;
                        case (strcmp('assortment', $key) === 0):
                            if(isset($xml['assortment'])){
                               foreach($xml['assortment'] as $k1 => $arr1){
                                   //echo($k1.' = Key <br>');
                                   if(isset($arr1['countryCodes'])){
                                       $newKey = $arr1['countryCodes'];
                                       $xml['assortment'][$newKey] = $arr1; 
                                       unset($xml['assortment'][$k1]);
                                   }
                               }
                            }
                            $this->prepareTree($xml['assortment']);
                            break;
                            case (strcmp('style', $key) === 0):
                                if(isset($xml['style'])){
                                   foreach($xml['style'] as $k1 => $arr1){
                                       //echo($k1.' = Key <br>');
                                       if(isset($arr1['styleNo'])){
                                           $newKey = $arr1['styleNo'];
                                           $xml['style'][$newKey] = $arr1; 
                                           unset($xml['style'][$k1]);
                                       }
                                   }
                                }
                                $this->prepareTree($xml['style']);
                                break;
                            case (strcmp('lsv', $key) === 0):
                            if(isset($xml['lsv'])){
                                foreach($xml['lsv'] as $k1 => $arr1){
                                    //echo($k1.' = Key <br>');
                                    if(isset($arr1['code'])){
                                        $newKey = $arr1['code'];
                                        $xml['lsv'][$newKey] = $arr1; 
                                        unset($xml['lsv'][$k1]);
                                    }
                                }
                            }
                            $this->prepareTree($xml['lsv']);
                            break;
                        case (strcmp('articleEan',$key) === 0):
                            if (isset($xml['articleEan'])){
                                foreach($xml['articleEan'] as $k1 => $arr1){
                                    //echo($k1.' = Key <br>');
                                    $key1 = '';
                                    $key2 = '';
                                    if(isset($arr1['stylNos'])){
                                        $key1 = $arr1['stylNos'];
                                    }
                                    if(isset($arr1['lsv']['code'])){
                                        $key2 = $arr1['lsv']['code'];
                                    }
                                    $newKey = $key1 . $key2;
                                    $xml['articleEan'][$newKey] = $arr1; 
                                    unset($xml['articleEan'][$k1]);
                                }
                                $this->prepareTree($xml['articleEan']);
                                }
                            break;
                        default:
                            $this->prepareTree($xml[$key]);
                        break;
                }
            }
        }
        return $xml;
    }  
    private function compare($new, $old) {
        $aCmpNew = $this->prepareTree($new);
        $aCmpOld = $this->prepareTree($old);
        //$this->px($aCmpNew, 'Ergebniss New',0);
        //$this->px($aCmpOld, 'Ergebniss Old');
        //$ret1 = $this->compareSubTree($aCmpNew, $aCmpOld);
        $diff['diffs'] = $this->compareArrays($aCmpNew, $aCmpOld);
        $diff['message'] = 'Unterschiede';
        return $diff;
        //return $data['content'];
        //return View::make('main', $data);
        //$this->px($ret1, 'Ergebnis');
        //echo('<table>');
        //$this->output($ret1['item']);
        //echo('</table>');
        //return $ret;
    }
    private function px($var,$msg='',$exit=true){
        if (strlen($msg) > 0){
            echo("<br>$msg<br>");
        }
        echo('<pre>');
        print_r($var);
        echo('</pre>');
        if ($exit){
            exit;
        }
    }
    function compareArrays($array1, $array2, $path = '') {
        $differences = [];
        // Alle Keys der Arrays sammeln
        try{
            $keys1 = array_keys($array1);
            $keys2 = array_keys($array2);
            $allKeys = array_unique(array_merge($keys1, $keys2));
        } catch (Exception $e){
          //echo($e->getMessage());
            return $differences;
        }
        foreach ($allKeys as $key) {
            $newPath = $path ? "$path/$key" : $key;
            if (!array_key_exists($key, $array1)) {
                $differences[] = ["Pfad" => $newPath, "Unterschied" => "Nur in Datei 2", "Wert in Datei 1" => null, "Wert in Datei 2" => $array2[$key]];
            } elseif (!array_key_exists($key, $array2)) {
                $differences[] = ["Pfad" => $newPath, "Unterschied" => "Nur in Datei 1", "Wert in Datei 1" => $array1[$key], "Wert in Datei 2" => null];
            } else {
                // Wenn es sich um Arrays handelt, rekursiver Vergleich
                if (is_array($array1[$key]) && is_array($array2[$key])) {
                    $differences = array_merge($differences, $this->compareArrays($array1[$key], $array2[$key], $newPath));
                } elseif ($array1[$key] !== $array2[$key]) {
                    $differences[] = ["Pfad" => $newPath, "Unterschied" => "Unterschiedliche Werte", "Wert in Datei 1" => $array1[$key], "Wert in Datei 2" => $array2[$key]];
                }
            }
        }
        return $differences;
    }
    private function calcTempLT ($pp, $restrictDocType = true){
        $statusDoc = $pp->statusDoc;
        if ($restrictDocType){
            if (strpos($statusDoc, 'TEMPPP') === false && strpos($statusDoc, 'RFQHG') === false) {
                return null;
            }
        }
        try{
            $sectionNo = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            $themeNo = $pp->themeNo;
            $y = (int) substr($sectionNo,0,2);
            $cwD = explode('.', $themeNo);
            $w = (int) $cwD[0];
            $musNo = (int) substr($sectionNo,2,2);
            //echo("Sec: $sectionNo");
            //echo("theme: $themeNo");
            cpcDebug::cpc_debug("calcTempLT: $sectionNo, $themeNo, $y, $w, $musNo", '-MinLT');
            //calcTempLT: 2604, 4.1, 26, 4, 4
            if ($musNo  == 7){
                if ($w < 46){
                    $y = $y + 1;
                }
            }
            if ($musNo  == 10){
                $y = $y +1;
            }
            $w = $w -6 ;
            if ($w < 1){
                $w = $w + 52;   
                //$y = $y -1;
            }
            $y = 2000 + $y;
        }
        catch(Exception $e){
            return null;    
        }
        //$y -=2000;
        cpcDebug::cpc_debug("calcTempLT: Ergebnis $w, $y", '-MinLT');
        return array('Woche' => $w,'Jahr'=> $y);
    }
    private function isUSProject($pp, $ppv){
        $isUsa = 0;
        if ($pp->PPProduktpass_continentType == 'US'){
            $isUsa = 1;
        } else {
            if ($ppv){
                $isUsa = $ppv->PPProduktpass_isUSA;
            }
        }
        return $isUsa;
    }
    private function isParent($pp){
        if ($pp->itemTypeKL == 'Parent'){
            return 1;
        } 
        return 0;
    }
    private function isChild($pp){
        if ($pp->itemTypeKL == 'Child'){
            return 1;
        } 
        return 0;
    }
    private function getProjectFromLinkedItems ($ppid){
        $prj = '';
        $pp = tPPProduktpass::find($ppid);
        if (!$pp){
            return '';
        }
        if (is_null($pp->itemTypeKL) and is_null($pp->PPProduktpass_linkedItemIan)){
           $prj = $pp->PPProduktpass_IAN;        
        } else {
            if (!is_null($pp->itemTypeKL)){
                if ($pp->itemTypeKL == 'Parent'){
                    $pp->PPProduktpass_IsParent = 1;
                    $pp->save();
                    $prj = $pp->PPProduktpass_IAN . '+' .$this->getChildItems($pp->PPProduktpass_IAN, $pp->PPProduktpass_Ausmusterungnummer);
                } else {
                    $pp->PPProduktpass_IsChild = 1;
                    $pp->save();
                    $prj =  $this->getParentItem($pp->PPProduktpass_IAN, $pp->PPProduktpass_Ausmusterungnummer);
                }
                $prj .= $this->getUSProject($pp->PPProduktpass_IAN, $pp->PPProduktpass_Ausmusterungnummer);
            } else {
                if (!is_null($pp->PPProduktpass_linkedItemIan)){
                    if ($pp->PPProduktpass_continentType == 'US'){
                        $pp->PPProduktpass_IsUSA = 1;
                        $pp->save();
                        $childItems = $this->getChildItems($pp->PPProduktpass_linkedItemIan, $pp->PPProduktpass_linkedItemLotNo);
                        if ($childItems != ''){
                            $childItems = '+' .$childItems;
                        } 
                        $prj = $pp->PPProduktpass_linkedItemIan  . $childItems . '+' .  $pp->PPProduktpass_IAN;
                    } else {
                        $prj = $pp->PPProduktpass_IAN .  '+' . $pp->PPProduktpass_linkedItemIan;
                    }
                } else {
                    $prj = $pp->PPProduktpass_IAN;
                }
            }
        }
        return $prj;
    }
    private function getUSProject($ian, $lotno){
        $prj= '';	
        $linkedItem  = DB::table('v_LinkedItems')->where('PPProduktpass_IAN', '=', $ian)->where('PPProduktpass_Ausmusterungnummer','like', $lotno.'%')->first();
        if ($linkedItem){
            if ($linkedItem->itemTypeKL == 'Child'){
                $parentIAN = $linkedItem->PPProduktpass_KLLink_IAN;
                $parentLotNo = $linkedItem->PPProduktpass_KLLink_lotNo;
            } else {
                $parentIAN = $linkedItem->PPProduktpass_IAN;
                $parentLotNo = substr($linkedItem->PPProduktpass_Ausmusterungnummer,0,4);
            }
            $UsItem  = DB::table('v_LinkedItems')->where('PPProduktpass_continentType', '=', 'US')->where('PPProduktpass_linkedItemIan', 'like', $parentIAN)->where('PPProduktpass_linkedItemLotNo','like', $parentLotNo)->first();
            if ($UsItem){
                $prj = '+'.$UsItem->PPProduktpass_IAN;
            }       
        } 
        return $prj;
    }
    private function getParentItem ($ian, $lotno){
        $prj= $ian;
        $linkedItem  = DB::table('v_LinkedItems')->where('itemTypeKL', '=', 'Child')->where('PPProduktpass_IAN', '=', $ian)->where('PPProduktpass_Ausmusterungnummer','like', $lotno)->first();
        if ($linkedItem){
            $prj = $linkedItem->PPProduktpass_KLLink_IAN;
            $prj .= '+'. $this->getChildItems($linkedItem->PPProduktpass_KLLink_IAN, $linkedItem->PPProduktpass_KLLink_lotNo);
        }
        return $prj;
    }
    private function getChildItems ($ian, $lotno){
        $linkedItems  = DB::table('v_LinkedItems')->where('itemTypeKL', '=', 'Parent')->where('PPProduktpass_IAN', '=', $ian)->where('PPProduktpass_Ausmusterungnummer','like', $lotno.'%')->orderBy('PPProduktpass_KLLink_IAN')->get();
        $prj = '';
        if ($linkedItems){
            $first = true;
            foreach($linkedItems as $item){
                if ($first){
                    $prj = $item->PPProduktpass_KLLink_IAN;
                    $first = false;
                } else {
                    $prj .= '+' . $item->PPProduktpass_KLLink_IAN;
                }
            }
        }
        return $prj;
    }
    private function getProjectIdsFromLinkedItems($ppid){
        $pp1 = tPPProduktpass::find($ppid);
        if ($pp1){
            $prj = $this->getProjectFromLinkedItems($ppid);
            $ians = explode('+', $prj);
            $ausm = substr($pp1->PPProduktpass_Ausmusterungnummer,0,4);
            $prjIds = array();
            foreach($ians as $ian){
                $pp = tPPProduktpass::where('PPProduktpass_IAN', '=', $ian)->where('PPProduktpass_Ausmusterungnummer','like', $ausm.'%')->get()->first();
                if ($pp){
                    $prjIds[] = $pp->PPProduktpass_Id;
                }
            } 
            return $prjIds;
        } 
        return false;
    }
    private function setProjectFromLinkedItems ($ppid){
        $prj = $this->getProjectFromLinkedItems($ppid);
        $prjIds = $this->getProjectIdsFromLinkedItems($ppid);
        foreach($prjIds as $id){
            $pp = tPPProduktpass::find($id);
            if ($pp){
                $pp->PPProduktpass_PPProjekte_Projekt = $prj;
                $pp->save();
            }
        }
    }
    public function getProject ($ppid){
        $pp = tPPProduktpass::find($ppid);
        if ($pp){
            echo('Projekt (DB) : ' . $pp->PPProduktpass_PPProjekte_Projekt);
            echo('<br>Projekt (Neu): ' . $this->getProjectFromLinkedItems($ppid));
        } else {
            echo('Produktpass nicht gefunden!<br>');
        }
    }
    private function getMitarbeiterLanguageFromId($id){
        $lang = 'DE';
        $m = PPMitarbeiter::where('PPMitarbeiter_Id', $id)->get()->first();
        if ($m) {
            $lang = $m->PPMitarbeiter_Language;
        }
        return $lang;
    }
    private function getMitarbeiterLanguageFromEmail($email){
        $lang = 'DE';
        $m = PPMitarbeiter::where('PPMitarbeiter_email', $email)->get()->first();
        if ($m) {
            $lang = $m->PPMitarbeiter_Language;
        }
        return $lang;
    }
    public function uploadZipProgressForm(){
        $data['content'] = View::make('UploadForms.UploadZipProgress');
        $xml  = new XMLController;
        $Sals = $xml->getSALs();
        View::share('SALs', $Sals);
        return View::make('main', $data);
    }
}
