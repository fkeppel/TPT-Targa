<?php
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Office365;
class UploadController extends BaseController {
    var $IsNewVersion;
    var $IsInquiry;
    var $IsBettwaesche;
    var $HasCharge;
    CONST  IMPORTART_PP             = 3;
    CONST  IMPORTART_MENGE          = 1;
    CONST  IMPORTART_QUALITAET      = 4;
    CONST  IMPORTART_SORTIERUNG     = 6;
    CONST  IMPORTART_STYLE          = 9;
    CONST  IMPORTART_UEBERSICHT     = 34;
    CONST  IMPORTART_PP_NEU         = 30;
    CONST  IMPORTART_MENGE_NEU      = 33;
    CONST  IMPORTART_SORTIERUNG_NEU = 32;
    function writeExcel($id) {
//$db = new cpcDB();
//$pp = $db->getRow("select * from PPPoduktpass where PPProduktpass_Id = ".$id);
        $pp = PPProduktpass::find($id);
//$pp = getPPProduktpass($id);
//var_dump($pp);exit;
        $objPHPExcel = new PHPExcel();
//$worksheet->getStyle('A1')->getFont()->setBold(true);
//$worksheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
//$writer->save('16-digit-string.xlsx');
        $worksheet = $objPHPExcel->getActiveSheet();
        $worksheet->getColumndimension('A')->setWidth(36);
        $worksheet->getColumndimension('B')->setWidth(36);
        $worksheet->getColumndimension('C')->setWidth(36);
        $worksheet->getColumndimension('D')->setWidth(36);
        $worksheet->setCellValue('A3', 'IAN');
        $worksheet->getStyle('A3')->getFont()->setBold(true);
        $worksheet->setCellValue('B3', $pp->PPProduktpass_IAN);
        $worksheet->getStyle('B3')->getFont()->setBold(true);
        $worksheet->setCellValue('C3', 'Artikelbezeichnung');
        $worksheet->getStyle('C3')->getFont()->setBold(true);
        $worksheet->setCellValue('D3', $pp->PPProduktpass_Artikelbezeichnung);
        $worksheet->getStyle('D3')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', '1. Artikelstammdaten');
        $worksheet->getStyle('A5')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Ausmusterung');
        $worksheet->setCellValue('A7', 'Ausm. Nummer (YYMM_XXXX)');
        $worksheet->setCellValue('B7', $pp->PPProduktpass_Ausmusterungnummer);
        $dl_file   = $pp->PPProduktpass_IAN . "_NEU_III.xls";
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save($dl_file);
        $this->makeDownload($dl_file, '', 'application/vnd.ms-excel');
//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="'.$pp['PPProduktpass_IAN']."_NEUII.xlsx".'"');
//header('Cache-Control: max-age=0');
    }
    function putDownload($id) {
        $types_array = array(
            '.au'     => 'audio/basic',
            '.avi'    => 'video/msvideo, video/avi, video/x-msvideo',
            '.bmp'    => 'image/bmp',
            '.bz2'    => 'application/x-bzip2',
            '.css'    => 'text/css',
            '.dtd'    => 'application/xml-dtd',
            '.doc'    => 'application/msword',
            '.docx'   => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            '.dotx'   => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            '.es'     => 'application/ecmascript',
            '.exe'    => 'application/octet-stream',
            '.gif'    => 'image/gif',
            '.gz'     => 'application/x-gzip',
            '.hqx'    => 'application/mac-binhex40',
            '.html'   => 'text/html',
            '.jar'    => 'application/java-archive',
            '.jpg'    => 'image/jpeg',
            '.js'     => 'application/x-javascript',
            '.midi'   => 'audio/x-midi',
            '.mp3'    => 'audio/mpeg',
            '.mpeg'   => 'video/mpeg',
            '.ogg'    => 'audio/vorbis, application/ogg',
            '.pdf'    => 'application/pdf',
            '.pl'     => 'application/x-perl',
            '.png'    => 'image/png',
            '.potx'   => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            '.ppsx'   => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            '.ppt'    => 'application/vnd.ms-powerpointtd>',
            '.pptx'   => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            '.ps'     => 'application/postscript',
            '.qt'     => 'video/quicktime',
            '.ra'     => 'audio/x-pn-realaudio, audio/vnd.rn-realaudio',
            '.ram'    => 'audio/x-pn-realaudio, audio/vnd.rn-realaudio',
            '.rdf'    => 'application/rdf, application/rdf+xml',
            '.rtf'    => 'application/rtf',
            '.sgml'   => 'text/sgml',
            '.sit'    => 'application/x-stuffit',
            '.sldx'   => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
            '.svg'    => 'image/svg+xml',
            '.swf'    => 'application/x-shockwave-flash',
            '.tar.gz' => 'application/x-tar',
            '.tgz'    => 'application/x-tar',
            '.tiff'   => 'image/tiff',
            '.tsv'    => 'text/tab-separated-values',
            '.txt'    => 'text/plain',
            '.wav'    => 'audio/wav, audio/x-wav',
            '.xlam'   => 'application/vnd.ms-excel.addin.macroEnabled.12',
            '.xls'    => 'application/vnd.ms-excel',
            '.xlsb'   => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            '.xlsx'   => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            '.xltx'   => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            '.xml'    => 'application/xml',
            '.zip'    => 'application/zip, application/x-compressed-zip');
        $files        = PPPPFiles::find($id);
        $fileexp      = explode('.', $files->PPPPFiles_Name);
        $ext          = "." . $fileexp[count($fileexp) - 1];
//echo($ext);exit;
        $content_type = isset($types_array[$ext]) ? array('Content-Type: ' . $types_array[$ext])
                    : NUll;
        return Response::download(public_path() . '/data/' . $files->PPPPFiles_Pfad . '/' . $files->PPPPFiles_Name, $files->PPPPFiles_Name, $content_type); // $name, $headers);
    }
    function makeDownload($file, $dir, $type) {
//echo($dir.$file); exit;
        header("Content-Type: $type");
        header("Content-Disposition: attachment; filename=\"$file\"");
        readfile($dir . $file);
    }
    function getExcelimages($id, $file, $sheetname = 'Style & Foto') {
        /*
         *
         * $objReader = PHPExcel_IOFactory::createReader('Excel2007');
         *
          $objReader -> setReadDataOnly(false);
         *
          $objPHPExcel = $objReader -> load($inputFileName = storage_path()."/data/import/zp1lUj_Produktpass 199108_FKE.xlsx");
          $sheetNames = $objPHPExcel->getSheetNames();
          $sheet = $objPHPExcel->getSheetByName('Style & Foto (DE)');
          $drawings = $sheet->getDrawingCollection();
          dd($drawings);
         */
        $objReader     = PHPExcel_IOFactory::createReader('Excel2007');
        $inputFileName = public_path() . "/data/" . $file;
        $objPHPExcel   = $objReader->load($inputFileName);
//var_dump($inputFileName);var_dump($sheetname); exit;
        $i = 0;
        foreach ($objPHPExcel->getSheetByName($sheetname)->getDrawingCollection() as $drawing) {
            if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
//echo("Mime: ".$drawing->getMimeType()."<br>");
                ob_start();
                call_user_func(
                        $drawing->getRenderingFunction(), $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG :
                        $extension = 'png';
                        break;
                    case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :
                        $extension = 'jpg';
                        break;
                }
            }
            else {
//echo("No Memory Drawing: <br>");
                $zipReader     = fopen($drawing->getPath(), 'r');
                $imageContents = '';
                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }
//echo ($extension);
            $prefix = '';
            if ($sheetname != 'Style & Foto') {
                $prefix = 'PFLEGESYM_';
            }
            if (strtoupper($extension) == 'TMP')
                $extension                         = 'png';
            $myFileName                        = $prefix . $id . "_" . str_random(6) . "_" . 'Image_' . ++$i . '.' . $extension;
            file_put_contents(public_path() . "/data/uploads/" . $myFileName, $imageContents);
            $files                             = new PPPPFiles();
            $files->PPPPFiles_Name             = $myFileName;
            $files->PPPPFiles_PPProduktpass_Id = $id;
            $files->PPPPFiles_Type             = 'PPUpload';
            $files->PPPPFiles_SubKat           = "Styles";
            if (substr($sheetname, 0, 5) == "Quali") {
                $files->PPPPFiles_SubKat = "Carelabel";
            }
            $files->PPPPFiles_Date        = date("Y-m-d H:i:s");
            $files->PPPPFiles_Description = 'Import aus Produktpass';
            $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
            $files->save();
        }
    }
    public function newFilesEntry($filen, $ppid, $type, $sdescr, $spath, $subtype = "Diverses", $ordnung='Sonstiges') {
        $files                             = new PPPPFiles();
        $files->PPPPFiles_Name             = $filen;
        $files->PPPPFiles_PPProduktpass_Id = $ppid;
        $files->PPPPFiles_Type             = $type;
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description      = $sdescr;
        $files->PPPPFiles_Pfad             = $spath;
        $files->PPPPFiles_SubKat           = $subtype;
        $files->PPPPFiles_Ordnung          = $ordnung;
        $files->PPPPFiles_LocalUpload      = 1;
        $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
        $files->save();
//echo("<pre>");var_dump($files);echo("</pre><br>");
    }
    function moveFilesToArchive($ppid, $subkat) {
//strUpdate = " UPDATE  PPPPFiles SET PPPPFiles_SubKat = 'Archiv' where  PPPPFiles_Description like '".$subkat."' and PPPPFiles_PPProduktpass_Id = " + $ppid;
        $files = PPPPFiles::where('PPPPFiles_SubKat', 'like', $subkat)
                        ->where('PPPPFiles_PPProduktpass_Id', '=', $ppid)->get();
        foreach ($files as $file) {
            $file->PPPPFiles_SubKat = "Archiv";
            $file->save();
        }
    }
    private
            function _getLaenderblock($land) {
//cpcDebug::cpc_debug("  _getLaenderblock: ".$land,"FKE44");
        $ret = "NN";
        if (PPLaenderbloecke::where('PPLaenderbloecke_Land', '=', trim($land))->count() > 0) {
            $l   = PPLaenderbloecke::where('PPLaenderbloecke_Land', '=', trim($land))->first();
            $ret = $l->PPLaenderbloecke_Block;
        }
        return $ret;
    }
    private
            function _UpdateLaenderbloecke($id) {
        $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)
                ->whereNull('PPProduktpass_Menge_CountryBlock')
                ->get();
//cpcDebug::cpc_debug("_UpdateLaenderblock: Select->".var_dump($mengen,TRUE),"TMPN");
        foreach ($mengen as $menge) {
//cpcDebug::cpc_debug("_UpdateLaenderblock: Land->".$menge->PPProduktpass_Menge_Country,"TMPN");
            $m                                   = PPProduktpass_Menge::find($menge->PPProduktpass_Menge_Id);
            $m->PPProduktpass_Menge_CountryBlock = $this->_getLaenderblock($m->PPProduktpass_Menge_Country);
            $m->save();
        }
    }
    private
            function _getMinLT($lt, $testlt) {
//1. testlt leer  => keine Änderung
        if (strlen(trim($testlt)) != 5) {
            return $lt;
        }
        $tkw   = substr($testlt, 0, 2);
        $tjahr = substr($testlt, 3, 2);
//2. lt leer  => testlt = neuer LT
        if (strlen(trim($lt)) != 5) {
            return $tkw . "/" . $tjahr;
        }
        $kw   = substr($lt, 0, 2);
        $jahr = substr($lt, 3, 2);
        if ($tjahr < $jahr) {
            return $tkw . "/" . $tjahr;
        }
        if ($tjahr == $jahr) {
            if ($tkw < $kw) {
                return $tkw . "/" . $tjahr;
            }
        }
        return $lt;
    }
    private function _UpdatePPTotalMenge($id) {
        $mengen = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)
                ->get();
        //cpcDebug::cpc_debug("_UpdateLaenderblock: Select->".var_dump($mengen,TRUE),"TMPN");
        cpcDebug::cpc_debug("_UpdatePPTotal:  $id ");
        $minlt = "99/99";
        $total = 0.0;
        $kolli = 1;
        foreach ($mengen as $menge) {
//cpcDebug::cpc_debug("_UpdateLaenderblock: Land->".$menge->PPProduktpass_Menge_Country,"TMPN");
            //cpcDebug::cpc_debug(" Country: " . $menge->PPProduktpass_Menge_Country . " Kollie: " . $menge->PPProduktpass_Menge_Kolli);
            $total += $menge->PPProduktpass_Menge_Quantity;
            $minlt = $this->_getMinLT($minlt, $menge->PPProduktpass_Menge_DeliveryWeek);
            $minlt = $this->_getMinLT($minlt, $menge->PPProduktpass_Menge_LT1);
            $minlt = $this->_getMinLT($minlt, $menge->PPProduktpass_Menge_LT2);
            $minlt = $this->_getMinLT($minlt, $menge->PPProduktpass_Menge_LT3);
            //cpcDebug::cpc_debug(" Country: " . $menge->PPProduktpass_Menge_Country . " Kollie: " . $menge->PPProduktpass_Menge_Kolli);
            if (!is_null($menge->PPProduktpass_Menge_Kolli) and $menge->PPProduktpass_Menge_Kolli > 0) {
                $kolli = $menge->PPProduktpass_Menge_Kolli;
                cpcDebug::cpc_debug(" XXXXX: " . $menge->PPProduktpass_Menge_Country . " Kollie: " . $menge->PPProduktpass_Menge_Kolli);
            }
        }
        $pp = PPProduktpass::find($id);
        if (is_null($pp) and $this->IsInquiry) {
            $pp = PPInquiry::find($id);
        }
        // cpcDebug::cpc_debug("UpdatePPTotal: ID => $id");
        // cpcDebug::cpc_debug("   IAN: $pp->PProduktpass_IAN");
        cpcDebug::cpc_debug(" Update  Kollie: $kolli");
        $pp->PPProduktpass_Gesamtmenge        = $total;
        $pp->PPProduktpass_Liefertermin       = substr($minlt, 0, 2);
        $pp->PPProduktpass_LieferterminJahr   = substr($minlt, 3, 2) + 2000;
        $pp->PPProduktpass_Verpackungseinheit = $kolli;
        $pp->save();
    }
    private
            function isLandMitBestellmenge($id, $land) {
        $mx = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get();
        foreach ($mx as $m) {
            if ($m->PPProduktpass_Menge_TotalSalePerUnit > 0 and strpos($land, $m->PPProduktpass_Menge_Country) !== false) {
                return true;
            }
        }
        return false;
    }
    function check_Sortierung($id) {
        //return;
        cpcDebug::cpc_debug("Start check_Sortierung $id");
        //Lösche zuerst alls Leeren Header
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->whereNull('PPProduktpass_Sortierung_Header')->get();
        foreach ($s as $row) {
            //cpcDebug::cpc_debug("Delete NULL $row->PPProduktpass_Sortierung_Id", "Sort");
            $row->delete();
        }
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Header', 'like', '%Sortierung Station%')->get();
        foreach ($s as $row) {
            //cpcDebug::cpc_debug("Delete NULL $row->PPProduktpass_Sortierung_Id", "Sort");
            $row->delete();
        }
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '1')
                        ->orderBY('PPProduktpass_Sortierung_Id')->get();
        cpcDebug::cpc_debug("Loop PPProduktpass_Sortierung");
        $lb = "";
        $sx = array();
        foreach ($s as $row) {
            //cpcDebug::cpc_debug("Found $row->PPProduktpass_Sortierung_Header", "Sort");
            if (substr($row->PPProduktpass_Sortierung_Header, 0, 2) == 'CB') {
                //cpcDebug::cpc_debug("        CB => DELETE", "Sort");
                $lb = $row->PPProduktpass_Sortierung_Header;
                for ($i = 2; $i <= 10; $i++) {
                    cpcDebug::cpc_debug("Set ATT $i");
                    $att        = "PPProduktpass_Sortierung_Value0" . $i;
                    $sx[$i - 1] = $row->$att;
                }
                cpcDebug::cpc_debug("row Delete");
                $row->delete();
            }
            else {
                if (trim($row->PPProduktpass_Sortierung_Header) == 'Länderblock') {
                    cpcDebug::cpc_debug("delete II");
                    $row->delete();
                }
                else {
                    cpcDebug::cpc_debug("ROW: " . print_r($row, true));
                    $row->PPProduktpass_Sortierung_Laenderblock = $lb;
                    for ($i = 1; $i <= 9; $i++) {
                        cpcDebug::cpc_debug("Save $i");
                        if (isset($sx[$i])) {
                            $att       = "PPProduktpass_Sortierung_Size0" . $i;
                            $row->$att = $sx[$i];
                        }
                    }
                    $row->save();
                }
            }
        }
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '1')
                        ->orderBY('PPProduktpass_Sortierung_Id')->get();
        cpcDebug::cpc_debug("Loop PPProduktpass_Sortierung Version =  1");
        foreach ($s as $newrow) {
            //Finde Sortierung mit gleichem Header und gleichem LB PPProduktpass_Sortierung_Header PPProduktpass_Sortierung_Laenderblock
            $oldrowcount = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                    ->where('PPProduktpass_Sortierung_Version', '=', '0')
                    ->where('PPProduktpass_Sortierung_Header', '=', $newrow->PPProduktpass_Sortierung_Header)
                    ->where('PPProduktpass_Sortierung_Laenderblock', '=', $newrow->PPProduktpass_Sortierung_Laenderblock)
                    ->count();
            if ($oldrowcount > 0) {
                $oldrow                                            = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '0')
                        ->where('PPProduktpass_Sortierung_Header', '=', $newrow->PPProduktpass_Sortierung_Header)
                        ->where('PPProduktpass_Sortierung_Laenderblock', '=', $newrow->PPProduktpass_Sortierung_Laenderblock)
                        ->first();
                $newrow->PPProduktpass_Sortierung_EAN              = $oldrow->PPProduktpass_Sortierung_EAN;
                $newrow->PPProduktpass_Sortierung_EANOS            = $oldrow->PPProduktpass_Sortierung_EANOS;
                $newrow->PPProduktpass_Sortierung_Translate_Design = $oldrow->PPProduktpass_Sortierung_Translate_Design;
                $newrow->save();
            }
        }
        cpcDebug::cpc_debug("Loop PPProduktpass_Sortierung Ready");
        DB::delete("delete from PPProduktpass_Sortierung where PPProduktpass_Sortierung_PPProduktpass_Id = " . $id . " and PPProduktpass_Sortierung_Version = 0");
        DB::update("update PPProduktpass_Sortierung set PPProduktpass_Sortierung_Version = 0 where PPProduktpass_Sortierung_PPProduktpass_Id = " . $id);
        cpcDebug::cpc_debug("check_Sortierung Ready");
    }
    function check_SortierungUebersicht($id) {
        cpcDebug::cpc_debug("check_sortierung ENTER");
//Lösche zuerst alls Leeren Header
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->whereNull('PPProduktpass_Sortierung_Header')->get();
        foreach ($s as $row) {
            $row->delete();
        }
        cpcDebug::cpc_debug("check_sortierung After delete1");
        /*
         * $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
          ->where('PPProduktpass_Sortierung_Version', '=', '1')
          ->orderBY('PPProduktpass_Sortierung_Id')->get();
          $lb = "";
          foreach ($s as $row) {
          cpcDebug::cpc_debug("check_sortierung Loop: " . $row->PPProduktpass_Sortierung_Header);
          if (substr($row->PPProduktpass_Sortierung_Header, 0, 2) == 'CB') {
          $lb = $row->PPProduktpass_Sortierung_Header;
          cpcDebug::cpc_debug("check_sortierung Loop CB: ");
          for ($i = 2; $i <= 10; $i++) {
          $att = "PPProduktpass_Sortierung_Value0" . $i;
          $s[$i - 1] = $row->$att;
          }
          $row->delete();
          } else {
          cpcDebug::cpc_debug("check_sortierung Loop LB: ");
          if (trim($row->PPProduktpass_Sortierung_Header) == 'Länderblock') {
          $row->delete();
          } else {
          $row->PPProduktpass_Sortierung_Laenderblock = $lb;
          for ($i = 1; $i <= 9; $i++) {
          cpcDebug::cpc_debug("check_sortierung Loop LB: $i ");
          $att = "PPProduktpass_Sortierung_Size0" . $i;
          $row->$att = $s[$i];
          }
          $row->save();
          }
          }
          } */
        cpcDebug::cpc_debug("check_sortierung After delete2");
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '1')
                        ->orderBY('PPProduktpass_Sortierung_Id')->get();
        foreach ($s as $newrow) {
            cpcDebug::cpc_debug("check_sortierung in Loop:  " . $newrow->PPProduktpass_Sortierung_Header);
            cpcDebug::cpc_debug("       LB:  " . $newrow->PPProduktpass_Sortierung_Laenderblock);
            //Finde Sortierung mit gleichem Header und gleichem LB PPProduktpass_Sortierung_Header PPProduktpass_Sortierung_Laenderblock
            $oldrowcount = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                    ->where('PPProduktpass_Sortierung_Version', '=', '0')
                    ->where('PPProduktpass_Sortierung_Header', '=', $newrow->PPProduktpass_Sortierung_Header)
                    //->where('PPProduktpass_Sortierung_Laenderblock', '=', $newrow->PPProduktpass_Sortierung_Laenderblock)
                    ->where('PPProduktpass_Sortierung_Value01', '=', $newrow->PPProduktpass_Sortierung_Value01)
                    ->count();
            if ($oldrowcount > 0) {
                $oldrow                                            = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '0')
                        ->where('PPProduktpass_Sortierung_Header', '=', $newrow->PPProduktpass_Sortierung_Header)
                        ->where('PPProduktpass_Sortierung_Value01', '=', $newrow->PPProduktpass_Sortierung_Value01)
                        //->where('PPProduktpass_Sortierung_Laenderblock', '=', $newrow->PPProduktpass_Sortierung_Laenderblock)
                        ->first();
                cpcDebug::cpc_debug("Update ROW: $oldrow->PPProduktpass_Sortierung_Header ");
                cpcDebug::cpc_debug("Update ROW: $oldrow->PPProduktpass_Sortierung_EAN ");
                //$newrow->PPProduktpass_Sortierung_EAN = $oldrow->PPProduktpass_Sortierung_EAN;
                //$newrow->PPProduktpass_Sortierung_EANOS = $oldrow->PPProduktpass_Sortierung_EANOS;
                $newrow->PPProduktpass_Sortierung_Translate_Design = $oldrow->PPProduktpass_Sortierung_Translate_Design;
                $newrow->save();
            }
        }
        DB::delete("delete from PPProduktpass_Sortierung where PPProduktpass_Sortierung_PPProduktpass_Id = " . $id . " and PPProduktpass_Sortierung_Version = 0 and  PPProduktpass_Sortierung_Laenderblock not like  '%OS%' ");
        DB::update("update PPProduktpass_Sortierung set PPProduktpass_Sortierung_Version = 0 where PPProduktpass_Sortierung_PPProduktpass_Id = " . $id);
    }
    function check_SortierungUebersichtOS($id) {
        cpcDebug::cpc_debug("check_sortierungOS ENTER");
//Lösche zuerst alls Leeren Header
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->whereNull('PPProduktpass_Sortierung_Header')->get();
        foreach ($s as $row) {
            $row->delete();
        }
        cpcDebug::cpc_debug("check_sortierung After delete1");
        /*
         * $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
          ->where('PPProduktpass_Sortierung_Version', '=', '1')
          ->orderBY('PPProduktpass_Sortierung_Id')->get();
          $lb = "";
          foreach ($s as $row) {
          cpcDebug::cpc_debug("check_sortierung Loop: " . $row->PPProduktpass_Sortierung_Header);
          if (substr($row->PPProduktpass_Sortierung_Header, 0, 2) == 'CB') {
          $lb = $row->PPProduktpass_Sortierung_Header;
          cpcDebug::cpc_debug("check_sortierung Loop CB: ");
          for ($i = 2; $i <= 10; $i++) {
          $att = "PPProduktpass_Sortierung_Value0" . $i;
          $s[$i - 1] = $row->$att;
          }
          $row->delete();
          } else {
          cpcDebug::cpc_debug("check_sortierung Loop LB: ");
          if (trim($row->PPProduktpass_Sortierung_Header) == 'Länderblock') {
          $row->delete();
          } else {
          $row->PPProduktpass_Sortierung_Laenderblock = $lb;
          for ($i = 1; $i <= 9; $i++) {
          cpcDebug::cpc_debug("check_sortierung Loop LB: $i ");
          $att = "PPProduktpass_Sortierung_Size0" . $i;
          $row->$att = $s[$i];
          }
          $row->save();
          }
          }
          } */
        cpcDebug::cpc_debug("check_sortierung After delete2");
        $s = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '1')
                        ->orderBY('PPProduktpass_Sortierung_Id')->get();
        foreach ($s as $newrow) {
            cpcDebug::cpc_debug("check_sortierung in Loop:  " . $newrow->PPProduktpass_Sortierung_Header);
            cpcDebug::cpc_debug("       LB:  " . $newrow->PPProduktpass_Sortierung_Laenderblock);
            //Finde Sortierung mit gleichem Header und gleichem LB PPProduktpass_Sortierung_Header PPProduktpass_Sortierung_Laenderblock
            $oldrowcount = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                    ->where('PPProduktpass_Sortierung_Version', '=', '0')
                    ->where('PPProduktpass_Sortierung_Header', '=', $newrow->PPProduktpass_Sortierung_Header)
                    ->where('PPProduktpass_Sortierung_Laenderblock', 'like', '%OS%')
                    ->where('PPProduktpass_Sortierung_Value01', '=', $newrow->PPProduktpass_Sortierung_Value01)
                    ->count();
            if ($oldrowcount > 0) {
                $oldrow                                            = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                        ->where('PPProduktpass_Sortierung_Version', '=', '0')
                        ->where('PPProduktpass_Sortierung_Header', '=', $newrow->PPProduktpass_Sortierung_Header)
                        ->where('PPProduktpass_Sortierung_Value01', '=', $newrow->PPProduktpass_Sortierung_Value01)
                        ->where('PPProduktpass_Sortierung_Laenderblock', 'like', '%OS%')
                        ->first();
                cpcDebug::cpc_debug("Update ROW: $oldrow->PPProduktpass_Sortierung_Header ");
                cpcDebug::cpc_debug("Update ROW: $oldrow->PPProduktpass_Sortierung_EAN ");
                //$newrow->PPProduktpass_Sortierung_EAN = $oldrow->PPProduktpass_Sortierung_EAN;
                //$newrow->PPProduktpass_Sortierung_EANOS = $oldrow->PPProduktpass_Sortierung_EANOS;
                $newrow->PPProduktpass_Sortierung_Translate_Design = $oldrow->PPProduktpass_Sortierung_Translate_Design;
                $newrow->save();
            }
        }
        DB::delete("delete from PPProduktpass_Sortierung where PPProduktpass_Sortierung_PPProduktpass_Id = " . $id . " and PPProduktpass_Sortierung_Version = 0 and  PPProduktpass_Sortierung_Laenderblock like  '%OS%' ");
        DB::update("update PPProduktpass_Sortierung set PPProduktpass_Sortierung_Version = 0 where PPProduktpass_Sortierung_PPProduktpass_Id = " . $id);
    }
    function cpc_diff_equal($a, $b) {
//
//echo('cpc_diff_equal:<br> '); //var_dump($akkk); var_dump($b);
        $ret_val = true;
        if (count($a) != count($b))
            $ret[] = 1;
        foreach ($a as $key => $value) {
            $ret = 0;
            if (!isset($b[$key]))
                $ret = 1;
//if (is_null($b[$key])  and  is_null($a[$key])) return true;
            if (is_null($b[$key]) and!is_null($a[$key]))
                $ret = 2;
            if (!is_null($b[$key]) and is_null($a[$key]))
                $ret = 3;
            if ($b[$key] !== $a[$key])
                $ret = 4;
            if (is_null($b[$key]) and is_null($a[$key]))
                $ret = 0;
            if ($ret > 0) {
//echo($key.":  ". $a[$key]."  ?=  ".$b[$key]."   <b>NO</b><br>");
                $ret_val = false;
            }
            else {
//echo($key.":  ".$a[$key]."  ?=  ".$b[$key]."   <b>YES</b> <br>");
            }
        }
        return $ret_val;
    }
    function diff_Sort($ls, $a) {
//echo("diff_sort<br><pre>");var_dump($a); echo("</pre> <br>");
        $asame = array();
        $adiff = array();
        $first = true;
        foreach ($ls as $land) {
//echo(" $land <br>");
            if (isset($a[$land])) {
                if ($first) {
                    $first  = false;
                    $sameas = $a[$land];
                    $sl     = $land;
                }
                if ($this->cpc_diff_equal($sameas, $a[$land])) {
                    $asame[$sl][] = $land;
                }
                else {
                    $adiff[$sl][] = $land;
                }
            }
        }
//echo("diff_sort Result:<br><pre>");
//var_dump($asame);
//var_dump($adiff);
        return (array('same' => $asame, 'diff' => $adiff));
    }
    function insert_sortierung($id, $s, $GTIN, $force) {
        if ($force) {
            cpcDebug::cpc_debug("Insert_sortierung Force");
            $version = 1;
        }
        else {
            cpcDebug::cpc_debug("Insert_sortierung normal");
            $version = 0;
        }
        $cmd = array();
        foreach ($s as $sort) {
            foreach ($sort as $a) {
                $cmd = array('PPProduktpass_Sortierung_PPProduktpass_Id' => $id,
                    'PPProduktpass_Sortierung_Laenderblock'     => $a['Countries'],
                    'PPProduktpass_Sortierung_Value01'          => $a['Quantities']['Bez'],
                    'PPProduktpass_Sortierung_Value02'          => $a['Quantities']['Menge'],
                    'PPProduktpass_Sortierung_Version'          => $version,
                    'PPProduktpass_Sortierung_EAN'              => $a['Quantities']['GTIN'],
                    'PPProduktpass_Sortierung_Header'           => $a['Description']);
                if ($this->isLandMitBestellmenge($id, $a['Countries'])) {
                    $ppsort = PPProduktpass_Sortierung::create($cmd);
                }
            }
        }
    }
    function getOSMenge($l, $a, $KI) {
        if (isset($a[$l])) {
            return $a[$l] / $KI;
        }
        return 0;
    }
    function getKI($id, $land = "") {
        if ($land != "") {
            $sort = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)
                            ->where('PPProduktpass_Menge_Country', '=', $land)->get()->first();
            if ($sort) {
                return $sort->PPProduktpass_Menge_Kolli;
            }
        }
        $pp = PPProduktpass::where("PPProduktpass_Id", "=", $id)->get()->first();
        $KI = 1;
        if ($pp) {
            $KI = is_null($pp->PPProduktpass_Verpackungseinheit) ? 1 : $pp->PPProduktpass_Verpackungseinheit;
        }
        return $KI;
    }
    function getEANOS($GTIN, $header, $land) {
        if (isset($GTIN[$header][$land])) {
            return $GTIN[$header][$land];
        }
        return "";
    }
    function insert_sortierungOS($id, $a, $GTIN, $force) {
        cpcDebug::cpc_debug("insert SortierungOS: ");
        cpcDebug::cpc_debug(print_r($GTIN, true));
        $cmd = array();
        $version = 0;
        if ($force) {
            $version = 1;
        }
        foreach ($a as $style => $bezs) {
            foreach ($bezs as $bez => $sizes) {
                foreach ($sizes as $size => $lsvs) {
                    foreach ($lsvs as $lsv => $mengen) {
                        //echo("S: $style  B: $bez SI: $size LSV: $lsv LM:  = ");
                        $OSMengen  = array();
                        $OSLaender = "";
                        $colon     = '';
                        foreach ($mengen as $l => $m) {
                            if (isset($m) and $m > 0) {
                                $OSMengen[$l] = $m;
                                $OSLaender    = $OSLaender . $colon . $l;
                                $colon        = ", ";
                            }
                        }
                        $header = $style; //. " (" . $size . ")" . $lsv;
                        $ean = $this->getEANOS($GTIN, $header, $OSLaender);
                        if ($force) {
                            cpcDebug::cpc_debug("FORCE -> ID:  $id Header: $header Value01: $bez");
//->where('PPProduktpass_Sortierung_Value01', '=', $bez)
                            $ppsc = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                                    ->where('PPProduktpass_Sortierung_Laenderblock', 'like', $OSLaender)
                                    ->where('PPProduktpass_Sortierung_Header', '=', $header)
                                    ->exists();
                            if ($ppsc) {
//->where('PPProduktpass_Sortierung_Value01', '=', $bez)
                                $pps                                        = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)->where('PPProduktpass_Sortierung_Laenderblock', 'like', $OSLaender)->where('PPProduktpass_Sortierung_Header', '=', $header)->get()->first();
                                cpcDebug::cpc_debug("Update: " . $bez . "Header: " . $header);
                                $pps->PPProduktpass_Sortierung_Laenderblock = $OSLaender;
                                $pps->PPProduktpass_Sortierung_Value01      = $bez;
                                $pps->PPProduktpass_Sortierung_Version      = $version;
                                $pps->PPProduktpass_Sortierung_OSMengeES = $this->getOSMenge('OSES', $OSMengen, $this->getKI($id, 'OSES'));
                                $pps->PPProduktpass_Sortierung_OSMengeDE = $this->getOSMenge('OSDE', $OSMengen, $this->getKI($id, 'OSDE'));
                                $pps->PPProduktpass_Sortierung_OSMengeBE = $this->getOSMenge('OSBE', $OSMengen, $this->getKI($id, 'OSBE'));
                                $pps->PPProduktpass_Sortierung_OSMengeGB = $this->getOSMenge('OSGB', $OSMengen, $this->getKI($id, 'OSGB'));
                                $pps->PPProduktpass_Sortierung_OSMengePL = $this->getOSMenge('OSPL', $OSMengen, $this->getKI($id, 'OSPL'));
                                $pps->PPProduktpass_Sortierung_OSMengeCZ = $this->getOSMenge('OSCZ', $OSMengen, $this->getKI($id, 'OSCZ'));
                                $pps->PPProduktpass_Sortierung_OSMengeNL = $this->getOSMenge('OSNL', $OSMengen, $this->getKI($id, 'OSNL'));
                                $pps->PPProduktpass_Sortierung_OSMengeFR = $this->getOSMenge('OSFR', $OSMengen, $this->getKI($id, 'OSFR'));
                                $pps->PPProduktpass_Sortierung_OSMengeSK = $this->getOSMenge('OSSK', $OSMengen, $this->getKI($id, 'OSSK'));
                                $pps->PPProduktpass_Sortierung_EAN       = $ean;
                                $pps->update();
                            }
                            else {
                                cpcDebug::cpc_debug("Insert: " . $bez);
                                cpcDebug::cpc_debug("Hier:3");
                                $cmd    = array('PPProduktpass_Sortierung_PPProduktpass_Id' => $id,
                                    'PPProduktpass_Sortierung_Laenderblock'     => $OSLaender,
                                    'PPProduktpass_Sortierung_Value01'          => $bez,
                                    'PPProduktpass_Sortierung_Version'          => $version,
                                    'PPProduktpass_Sortierung_OSMengeES'        => $this->getOSMenge('OSES', $OSMengen, $this->getKI($id, 'OSES')),
                                    'PPProduktpass_Sortierung_OSMengeDE'        => $this->getOSMenge('OSDE', $OSMengen, $this->getKI($id, 'OSDE')),
                                    'PPProduktpass_Sortierung_OSMengeBE'        => $this->getOSMenge('OSBE', $OSMengen, $this->getKI($id, 'OSBE')),
                                    'PPProduktpass_Sortierung_OSMengeGB'        => $this->getOSMenge('OSGB', $OSMengen, $this->getKI($id, 'OSGB')),
                                    'PPProduktpass_Sortierung_OSMengePL'        => $this->getOSMenge('OSPL', $OSMengen, $this->getKI($id, 'OSPL')),
                                    'PPProduktpass_Sortierung_OSMengeCZ'        => $this->getOSMenge('OSCZ', $OSMengen, $this->getKI($id, 'OSCZ')),
                                    'PPProduktpass_Sortierung_OSMengeNL'        => $this->getOSMenge('OSNL', $OSMengen, $this->getKI($id, 'OSNL')),
                                    'PPProduktpass_Sortierung_OSMengeFR'        => $this->getOSMenge('OSFR', $OSMengen, $this->getKI($id, 'OSFR')),
                                    'PPProduktpass_Sortierung_OSMengeSK'        => $this->getOSMenge('OSSK', $OSMengen, $this->getKI($id, 'OSSK')),
                                    'PPProduktpass_Sortierung_EAN'              => $ean,
                                    'PPProduktpass_Sortierung_Header'           => $header);
                                cpcDebug::cpc_debug("Hier:4");
                                $ppsort = PPProduktpass_Sortierung::create($cmd);
                            }
                        }
                        else {
                            cpcDebug::cpc_debug("Insert-New: " . $bez . "-" . $header . "-" . $OSLaender);
                            $cmd    = array('PPProduktpass_Sortierung_PPProduktpass_Id' => $id,
                                'PPProduktpass_Sortierung_Laenderblock'     => $OSLaender,
                                'PPProduktpass_Sortierung_Value01'          => $bez,
                                'PPProduktpass_Sortierung_Version'          => $version,
                                'PPProduktpass_Sortierung_OSMengeES'        => $this->getOSMenge('OSES', $OSMengen, $this->getKI($id, 'OSES')),
                                'PPProduktpass_Sortierung_OSMengeDE'        => $this->getOSMenge('OSDE', $OSMengen, $this->getKI($id, 'OSDE')),
                                'PPProduktpass_Sortierung_OSMengeBE'        => $this->getOSMenge('OSBE', $OSMengen, $this->getKI($id, 'OSBE')),
                                'PPProduktpass_Sortierung_OSMengeGB'        => $this->getOSMenge('OSGB', $OSMengen, $this->getKI($id, 'OSGB')),
                                'PPProduktpass_Sortierung_OSMengePL'        => $this->getOSMenge('OSPL', $OSMengen, $this->getKI($id, 'OSPL')),
                                'PPProduktpass_Sortierung_OSMengeCZ'        => $this->getOSMenge('OSCZ', $OSMengen, $this->getKI($id, 'OSCZ')),
                                'PPProduktpass_Sortierung_OSMengeNL'        => $this->getOSMenge('OSNL', $OSMengen, $this->getKI($id, 'OSNL')),
                                'PPProduktpass_Sortierung_OSMengeFR'        => $this->getOSMenge('OSFR', $OSMengen, $this->getKI($id, 'OSFR')),
                                'PPProduktpass_Sortierung_OSMengeSK'        => $this->getOSMenge('OSSK', $OSMengen, $this->getKI($id, 'OSSK')),
                                'PPProduktpass_Sortierung_EAN'              => $ean,
                                'PPProduktpass_Sortierung_Header'           => $header);
                            $ppsort = PPProduktpass_Sortierung::create($cmd);
                        }
                    }
                }
            }
        }
    }
    function isOSLand($l) {
        return true;
        if (strpos("OSDE OSBE OSNL OSCZ OSES OSGB OSFR OSPL OSSK", $l) !== false) {
            return true;
        }
        return false;
    }
    function importExcel($file, $idef = 1, $id, $pforce = false) {
        $force = $pforce;
        if ($this->IsNewVersion) {
            DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Endrow`='39' WHERE `PPImport_Definition_Id`='1'");
            DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Endrow`='39' WHERE `PPImport_Definition_Id`='33'");
            DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Startrow`='3' WHERE `PPImport_Definition_Id`='1'");
            DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Startrow`='3' WHERE `PPImport_Definition_Id`='33'");
            $cmd = " DELETE from PPImport_Definition_Fields where  PPImport_Definition_Fields_Field = 'PPProduktpass_Charge' ";
            DB::delete($cmd);
            if ($this->HasCharge) {
                $cmd = "INSERT INTO PPImport_Definition_Fields (PPImport_Definition_Id2,PPImport_Definition_Fields_Field,PPImport_Definition_Fields_Sheet,PPImport_Definition_Fields_Row, PPImport_Definition_Fields_Col,PPImport_Definition_Fields_Id) VALUES (30,'PPProduktpass_Charge','Produktpass',3,'D',NULL)";
                DB::insert($cmd);
                $cmd = "INSERT INTO PPImport_Definition_Fields (PPImport_Definition_Id2,PPImport_Definition_Fields_Field,PPImport_Definition_Fields_Sheet,PPImport_Definition_Fields_Row, PPImport_Definition_Fields_Col,PPImport_Definition_Fields_Id) VALUES (3,'PPProduktpass_Charge','Produktpass',3,'D',NULL)";
                DB::insert($cmd);
                DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Endrow`='40' WHERE `PPImport_Definition_Id`='1'");
                DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Endrow`='40' WHERE `PPImport_Definition_Id`='33'");
                DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Startrow`='4' WHERE `PPImport_Definition_Id`='1'");
                DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Startrow`='4' WHERE `PPImport_Definition_Id`='33'");
            }
        }
        else {
            $cmd = " DELETE from PPImport_Definition_Fields where  PPImport_Definition_Fields_Field = 'PPProduktpass_Charge' ";
            DB::delete($cmd);
            DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Endrow`='37' WHERE `PPImport_Definition_Id`='1'");
            DB::update("UPDATE `BelotexMain`.`PPImport_Definitions` SET `PPImport_Definition_Endrow`='37' WHERE `PPImport_Definition_Id`='33'");
        }
        cpcDebug::cpc_debug("importExcel: $file $idef " . print_r($id, true));
        $message = "OK";
        if ($idef == 0) {
            return (array("id" => 0, "msg" => "Falsches Importformat!"));
        }
        ini_set('memory_limit', '-1');
        $inputFileName = public_path() . "/data/" . $file;
        if (!file_exists($inputFileName)) {
            cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
            return (array("id" => 0, "msg" => $inputFileName . " existiert nicht!"));
        }
        $inputFileType = 'Excel2007';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(false);
        $objPHPExcel = $objReader->load($inputFileName);
        PHPExcel_Calculation::getInstance($objPHPExcel)->cyclicFormulaCount = 1;
//TEST ob IAN schon vorhanden
        $tsheet  = $objPHPExcel->getSheetByName('Produktpass');
        $tcellxy = 'B3';
        $tvalue  = $tsheet->getCell($tcellxy)->getCalculatedValue();
        $inqForce = false;
        if (($idef == self::IMPORTART_PP or $idef == 14) && !$force) {
            cpcDebug::cpc_debug(" Start PP!  ");
            if ($this->IsInquiry) {
                cpcDebug::cpc_debug(" IsInquiry  ");
                $inqForce = false;
                $iValue   = "I-" . rtrim(ltrim($tvalue));
                cpcDebug::cpc_debug(" Inquiry für IAN  einlesen!  " . $iValue);
                $ppi = PPInquiry::where('PPProduktpass_IAN', '=', $iValue)->get()->first();
                if ($ppi) {
                    cpcDebug::cpc_debug(" PPI  ID:" . $ppi->PPProduktpass_Id);
                    cpcDebug::cpc_debug(" Inquiry für IAN bereits eingelsen!  I-" . $tvalue);
                    cpcDebug::cpc_debug("Inquiry vorhanden setze force");
                    $force    = true;
                    $inqForce = true;
                    //return (array("id" => 0, "msg" => "  Inquiry für IAN bereits eingelsen!"));
                }
                else {
                    cpcDebug::cpc_debug("Kein IAN gefunden!");
                }
            }
            else {
                if (PPProduktpass::where('PPProduktpass_IAN', '=', $tvalue)->exists()) {
                    cpcDebug::cpc_debug("IAN bereits vorhanden! (" . $tvalue . ")");
                    return (array("id" => 0, "msg" => "Inquiry für IAN bereits eingelsen!"));
                }
            }
        }
        $old_ian = 0;
        if ($force) {
            if ($this->IsInquiry) {
                $ppf = PPInquiry::where('PPProduktpass_IAN', '=', "I-" . $tvalue)->first();
            }
            else {
                $ppf = PPProduktpass::where('PPProduktpass_IAN', '=', $tvalue)->first();
            }
            if ($idef == self::IMPORTART_PP or $idef == 14) {
                $pc = new ProjectsController();
                $pc->copyPP($ppf->PPProduktpass_Id, "Import", $this->IsInquiry);
                cpcDebug::cpc_debug("IAN kopiert");
            }
        }
        $sheetNames = $objPHPExcel->getSheetNames();
        $def        = new ExcelDefinitions($idef);
        $def->doPrint();
        //cpcDebug::cpc_debug($def, "IMPORT");
        $sheetName = $def->getSheetname();
        $table     = $def->getTable();
        $startrow  = $def->getStartrow();
        $endrow    = $def->getEndrow();
        $sheet  = $objPHPExcel->getSheetByName($sheetName);
        $sheeta = $sheet->toArray(null, true, true, true);
        if ($idef == self::IMPORTART_UEBERSICHT) {
            cpcDebug::cpc_debug("Import: Bestellübersicht");
            $KI = $sheeta[3]['B'];
            if (is_null($KI))
                $KI = 1;
            if (!isset($KI))
                $KI = 1;
            $laender = "G.H.I.J.K.L.M.N.O.P.Q.R.S.T.U.V.W.X.Y.Z.AA.AB.AC.AD.AE.AF.AG.AH"; //.AI.AJ.AK.AL.AM.AN.AO.AP.AQ.AR.AS.AZ.AU.AV.AW.AX.AY.AZ";
            $la_col  = explode('.', $laender);
            $res  = array();
            $a    = array();
            $diff = array();
            $ls   = array();
            $maxland = 0;
            foreach ($la_col as $col_land) {
                $la[$sheeta[6][$col_land]] = $la_col[$maxland];
                $ls[]                      = $sheeta[6][$col_land];
                $maxland++;
                if (strlen(trim($sheeta[6][$col_land])) != 2) {
                    break;
                }
            }
//$ls = Array über alle Länder aus Zeile 6 Bestellübersicht
            $row = 7;
            $GTIN = array();
            do {
                $style = $sheeta[$row]["C"];
                $bez  = $sheeta[$row]["D"];
                $size = $sheeta[$row]["E"];
                $lsv  = $sheeta[$row]["F"];
                if (strlen($size) >= 1) {
                    if (strpos(strtoupper($size), "BREAKDOWN") === false) {
                        $style = $style . " (" . $size . ")";
                    }
                }
                $GTIN[$style][$lsv] = $sheeta[$row]["B"];
                if (strlen($style) > 1) {
                    $first = true;
                    foreach ($la as $col_land) {
                        $a[$sheeta[6][$col_land]] = $sheeta[$row][$col_land];
// echo( $sheeta[6][$col_land] . ":  $styleGtin $gtin  $row <br>");
                    }
//$res[] = array('Style' => $style, 'Bez' => $bez, 'Size' => $size, 'LSV' => $lsv, 'SortMengen' => $a);
                    $res[$style][$bez][$size][$lsv] = $a;
                }
                $row++;
            }
            while (strlen($style) > 1);
            /* echo("<table>");
              foreach ($res as $r) {
              echo("<tr>");
              echo("<td>");
              echo($r['Style']);
              echo("</td>");
              echo("<td>");
              echo($r['LSV']);
              echo("</td>");
              foreach ($r['SortMengen'] as $l => $sm) {
              echo("<td>");
              echo($l . ": " . $sm);
              echo("</td>");
              }
              echo("</tr>");
              }
              echo("</table>");
              exit;
             */
            foreach ($res as $style => $styles) {
                foreach ($styles as $bez => $sizes) {
                    foreach ($sizes as $lsvs) {
                        foreach ($lsvs as $klsv => $lsv) {
                            foreach ($lsv as $land => $menge) {
                                if (isset($menge) and $menge > 0) {
                                    $kum[$land][$style] = array("Bez"   => $bez,
                                        "Menge" => $menge,
                                        "LSV"   => $klsv, "GTIN"  => $GTIN[$style][$klsv]);
                                }
                            }
                        }
                    }
                }
            }
            if (isset($kum) and count($kum) > 0) {
                $first                     = true;
                $pos                       = 0;
                $sort1[$pos]['Sortierung'] = Array();
                $sort1[$pos]['Laender']    = '';
                foreach ($kum as $land => $sort) {
                    if ($sort1[$pos]['Sortierung'] != $sort) {
//Suche im Ergebnis ob schon gleiche Sortierung vorhanden
                        $found = false;
                        foreach ($sort1 as $pos1 => $s) {
                            if ($s['Sortierung'] == $sort) {
//Gleiche Sortierung gefunden
                                $sort1[$pos1]['Laender'] .= $land . ", ";
                                $found                   = true;
                                break;
                            }
                        }
                        if (!$found) {
//Neue Sortierung anlegen
                            $pos++;
                            $sort1[$pos]['Sortierung'] = $sort;
                            $sort1[$pos]['Laender']    = $land . ", ";
                        }
                    }
                    else {
                        $sort1[$pos]['Laender'] .= $land . ", ";
                    }
                }
                $sort = Array();
                foreach ($sort1 as $pos2 => $sorts) {
                    if (isset($sorts)) {
                        foreach ($sorts['Sortierung'] as $style => $menge) {
                            $sort[$pos2][] = array('Description' => $style, 'Countries'   => substr($sort1[$pos2]['Laender'], 0, -2),
                                'Quantities'  => $menge);
                        }
                    }
                }
                $this->insert_sortierung($id, $sort, $GTIN, $force);
                if ($force) {
                    $this->check_SortierungUebersicht($id);
                }
            }
//OS Mengen und Sortierung
            $header_row = $row;
            while ($sheeta[$header_row]["D"] != "Style_Bezeichnung") {
                $header_row++;
            }
            $row = $header_row + 1;
            $a   = array();
            $res = array();
            $GTIN = array();
            do {
                $style = $sheeta[$row]["C"];
                $bez   = $sheeta[$row]["D"];
                $size  = $sheeta[$row]["E"];
                $lsv   = $sheeta[$row]["F"];
                if (strlen($size) > 0) {
                    if (strpos(strtoupper($size), "BREAKDOWN") === false) {
                        $style .= " (" . $size . ")";
                    }
                }
                $oslaender = "";
                foreach ($la_col as $col_land) {
                    if (isset($sheeta[$row][$col_land]) and $sheeta[$row][$col_land] > 0) {
                        $oslaender                .= $sheeta[$header_row][$col_land];
                        $GTIN[$style][$oslaender] = $sheeta[$row]["B"];
                        $oslaender                .= ", ";
                        cpcDebug::cpc_debug("OS Sortierung GTIN");
                        cpcDebug::cpc_debug("    ADD: " . $sheeta[$header_row][$col_land] . " => " . $sheeta[$row]["B"]);
                    }
                }
                $header = $style;
                if (strlen($style) > 1) {
                    $first = true;
                    foreach ($la_col as $col_land) {
                        if ($this->isOSLand($sheeta[$header_row][$col_land])) {
                            $a[$style][$bez][$size][$lsv][$sheeta[$header_row][$col_land]] = $sheeta[$row][$col_land];
                        }
                    }
//$res[] = array('Style' => $style, 'Bez' => $bez, 'Size' => $size, 'LVS' => $lsv);
                }
                $row++;
            }
            while (strlen($style) > 1);
            /*  foreach ($a as $style => $bezs) {
              foreach ($bezs as $bez => $sizes) {
              foreach ($sizes as $size => $lsvs) {
              foreach ($lsvs as $lsv => $mengen) {
              echo("S: $style  B: $bez SI: $size LSV: $lsv LM:  = ");
              foreach ($mengen as $l => $m) {
              echo(" $l => $m ;");
              }
              echo("<br>");
              }
              }
              }
              }
              exit;
             */
            /* foreach ($cb as $lsort) {
              foreach ($lsort as $land => $laender) {
              $sortbez = $land;
              //Key = land
              $sortcont = "";
              foreach ($laender as $land) {
              $sortcont .= $land . ", ";
              }
              if (strlen($sortcont) > 2) {
              $sortcont = substr($sortcont, 0, strlen($sortcont) - 2);
              }
              $all = array();
              foreach ($res as $re) {
              //var_dump($re);
              $all[$re['Style']] = array ('Description' => $re['Bez'] . " (" . $re['Size'] . ")", 'Quantity' => $a[$land][$re['Style']]);
              }
              }
              $sort[] = array('Description' => $sortbez, 'Countries' => $sortcont, 'Quantities' => $all);
              }
             */
            cpcDebug::cpc_debug("GTIN: " . print_r($GTIN, true));
            cpcDebug::cpc_debug("SortierungOS: " . print_r($a, true));
            $this->insert_sortierungOS($id, $a, $GTIN, $force);
            if ($force) {
                $this->check_SortierungUebersichtOS($id);
            }
            cpcDebug::cpc_debug("Import-Ende: Bestellübersicht");
//echo("<pre>"); var_dump($asame);echo("<pre>");  var_dump($adiff);  echo("<pre>");  var_dump($ls);  echo("</pre><br><pre>");  var_dump($res);         exit;
        }
        else {
            if ($def->isRowMode()) {
                cpcDebug::cpc_debug("Start: $startrow   End: $endrow Sheet: " . $def->getSheetname());
                $cmds = array();
                foreach ($sheeta as $row => $cols) {
                    $sql       = array();
                    $hasValues = false;
                    foreach ($cols as $col => $value1) {
                        if ($row >= $startrow && $row <= $endrow) {
                            $cellxy = $col . $row;
                            $cell  = $sheet->getCell($cellxy);
                            $value = $sheet->getCell($cellxy)->getCalculatedValue();
                            $attr  = $def->getField($col);
                            if ($attr) {
                                if (!isset($value)) {
                                    $value = $def->getMergedCellValue($cell, $sheet, $cellxy);
                                }
                                if ($cell->getDataType() == "n" or $cell->getDataType() == "f")
                                    $value = str_replace(",", "", $value);
                                if ($value != '') {
                                    $sql[$attr] = $value;
                                }
                            }
                            if (isset($value)) {
                                $hasValues = True;
                            }
                        }
                    }
                    if ($hasValues)
                        $cmds [] = $sql;
                }
                $ci = 1;
                cpcDebug::cpc_debug("idef: $idef");
                foreach ($cmds as $cmd) {
                    if ($idef == 1 or $idef == 33) {
                        if (!isset($cmd['PPProduktpass_Menge_Country']) or $cmd['PPProduktpass_Menge_Country'] == "Land") {
                            continue;
                        }
                    }
//echo("ooooooooooooooooooooooooooo<br><pre>"); print_r($cmd);echo("<pre>______________________________<br><br>");
                    if ($idef == 1 or $idef == 33) {
                        if ($id != 0)
                            $cmd['PPProduktpass_Menge_PPProduktpass_Id'] = $id;
                        if ($force) {
                            if (!isset($cmd['PPProduktpass_Menge_TotalSalePerUnit']) or $cmd['PPProduktpass_Menge_TotalSalePerUnit'] == '') {
                                $cmd['PPProduktpass_Menge_TotalSalePerUnit'] = 0;
                            }
                            if (!isset($cmd['PPProduktpass_Menge_Quantity']) or $cmd['PPProduktpass_Menge_Quantity'] == '') {
                                $cmd['PPProduktpass_Menge_Quantity'] = 0;
                                $cmd['PPProduktpass_Menge_LT1Menge'] = 0;
                                $cmd['PPProduktpass_Menge_LT2Menge'] = 0;
                                $cmd['PPProduktpass_Menge_LT3Menge'] = 0;
                            }
                            $count = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)
                                            ->where('PPProduktpass_Menge_Country', '=', $cmd['PPProduktpass_Menge_Country'])->count();
                            if ($count > 0) {
                                $ppf_m = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)
                                                ->where('PPProduktpass_Menge_Country', '=', $cmd['PPProduktpass_Menge_Country'])->first();
//echo($ppf_m->PPProduktpass_Menge_Id."  ".$ppf_m->PPProduktpass_Menge_Country."<br>");
                                $ppf_m->update($cmd);
                            }
                            else {
                                $ppf_m = PPProduktpass_Menge::create($cmd);
                            }
                        }
                        else {
                            $pp_sub = PPProduktpass_Menge::create($cmd);
                        }
                        $this->_UpdateLaenderbloecke($id);
                        $this->_UpdatePPTotalMenge($id);
                    }
                    if ($idef == 4 || $idef == 5) {
                        //Import Qualitäten
                        if ($id != 0) {
                            $cmd['PPProduktpass_Qualitaet_PPProduktpass_Id'] = $id;
                        }
                        if ($force) {
                            $count = 0;
                            if (isset($cmd['PPProduktpass_Qualitaet_Header'])) {
                                $count = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)
                                        ->where('PPProduktpass_Qualitaet_Header', 'like', trim($cmd['PPProduktpass_Qualitaet_Header']))
                                        ->count();
                            }
                            if ($count > 0) {
                                $ppf_m = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)
                                                ->where('PPProduktpass_Qualitaet_Header', '=', $cmd['PPProduktpass_Qualitaet_Header'])->first();
//echo($ppf_m->PPProduktpass_Menge_Id."  ".$ppf_m->PPProduktpass_Menge_Country."<br>");
                                $ppf_m->update($cmd);
                                cpcDebug::cpc_debug("Update  Qualität II");
//cpcDebug::cpc_debug("Update1 CMD:".print_r($cmd,true),"Qual3");
                            }
                            else {
//Leerer Header für Überschriften
                                $count = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)
                                                ->whereNull('PPProduktpass_Qualitaet_Header')->orderBy("PPProduktpass_Qualitaet_Id")->count();
                                if ($count > 0 and $ci < 3) {
                                    $ppf_m = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)
                                            ->whereNull('PPProduktpass_Qualitaet_Header')
                                            ->whereNotNull('PPProduktpass_Qualitaet_Value01')
                                            ->orderBy("PPProduktpass_Qualitaet_Id")
                                            ->get();
                                    $i = 1;
                                    foreach ($ppf_m as $row) {
                                        if ($ci == $i) {
                                            $row->update($cmd);
                                            cpcDebug::cpc_debug("Update Qualität I");
                                        }
                                        $i++;
                                    }
                                    $ci++;
                                }
                                else {
                                }
                            }
                        }
                        else {
                            $pp_sub = PPProduktpass_Qualitaet::create($cmd);
                            cpcDebug::cpc_debug("Create Qualität");
                        }
                    }
                    if ($idef == 6 || $idef == 32) {
                        cpcDebug::cpc_debug("6/32: Sortierung");
                        cpcDebug::cpc_debug(print_r($cmds, true));
                        if ($id != 0) {
                            $cmd['PPProduktpass_Sortierung_PPProduktpass_Id'] = $id;
                        }
                        if ($force) {
                            if (isset($cmd['PPProduktpass_Sortierung_Header'])) {
                                $count = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                                                ->where('PPProduktpass_Sortierung_Header', '=', $cmd['PPProduktpass_Sortierung_Header'])->count();
                                if ($count > 0) {
                                    $ppf_m = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)
                                                    ->where('PPProduktpass_Sortierung_Header', '=', $cmd['PPProduktpass_Sortierung_Header'])->first();
                                    cpcDebug::cpc_debug("Lösche Sortierung!", "TMP3");
                                    //$ppf_m->delete();
                                }
                            }
                        }
                        $cmd['PPProduktpass_Sortierung_Version'] = 1;
                        try {
                            cpcDebug::cpc_debug("Insert Sortierung");
                            cpcDebug::cpc_debug($cmd);
                            $pp_sub = PPProduktpass_Sortierung::create($cmd);
                        }
                        catch (\Exception $e) {
                            var_dump($e);
                            exit;
                        }
                    }
                    if ($idef == 9) {
                        if ($id != 0) {
                            $cmd['PPProduktpass_Style_PPProduktpass_Id'] = $id;
                        }
                        cpcDebug::cpc_debug("Insert Style");
                        cpcDebug::cpc_debug($cmd);
                        try {
                            $pp_sub = PPProduktpass_Style::create($cmd);
                        }
                        catch (\Exception $e) {
                            var_dump($e);
                            exit;
                        }
                    }
                }
                if ($idef == 6 || $idef == 32) {
                    //Aufbereitung Sortierung mit mehereren Länderblöcken
                    cpcDebug::cpc_debug("Check Sortierung!", "TMP3");
                    $this->check_Sortierung($id);
                }
                cpcDebug::cpc_debug("Import-Row-ModeEnde: " . $def->getSheetname());
            }
            if ($def->isFieldsMode()) {
                $table = $def->getTable();
                cpcDebug::cpc_debug("Field-Mode Sheet: " . $def->getSheetname());
                $cmd = array();
                $offset = 0;
                $fd0    = $def->getFieldDef()[0];
                $sheet  = $objPHPExcel->getSheetByName($fd0['sheet']);
                $sheeta = $sheet->toArray(null, true, true, true);
                foreach ($def->getFieldDef() as $fielddef) {
//echo("<br>*************************<br>");print_r($def);echo("<br>*************************<br>");
                    if (trim($fielddef['field']) == 'PPProduktpass_AltCharge') {
                        if ($this->HasCharge <> 1) {
                            $offset = $offset - 1;
                        }
                    }
                    $rowindex = $fielddef['row'] + $offset;
                    $cellxy = $fielddef['col'] . $rowindex;
                    $cell = $sheet->getCell($cellxy)->getCalculatedValue();
//echo("Type: ".$cell->getDataType()."<br>");
                    //cpcDebug::cpc_debug("  Field:" . $fielddef['field'], "FKE44");
                    //cpcDebug::cpc_debug("  Cellxy:" . $cellxy, "FKE44");
                    //cpcDebug::cpc_debug("  Cell:" . $cell, "FKE44");
                    if ($cell != '')
                        $cmd[trim($fielddef['field'])] = "$cell";
                    if (trim($fielddef['field']) == 'PPProduktpass_Verkaufsverpackung') {
//$ListBoxId = DB::table('PPListBoxes')
//-> select(DB::raw(''))
//-> where ('PPListBoxes_Value', '=',$cell)
//->first();
//if ($ListBoxId){
//  $cmd[trim($fielddef['field'])] = $cell;
// }
                    }
                    if (trim($fielddef['field']) == 'PPProduktpass_Warengruppe') {
                        $wgrp   = substr(trim($cell), 0, 7);
                        if ($notice = PPWarengruppeNotice::where('PPWarengruppeNotice_WGRP', "=", $wgrp)->first()) {
                            $message = "<b>" . $wgrp . "<b><br>" . $notice->PPWarengruppeNotice_Notice;
                        }
                    }
                    if (trim($fielddef['field']) == 'PPProduktpass_IAN') {
                        $cmd[trim($fielddef['field'])] = "$tvalue";
                    }
                    if (trim($fielddef['field']) == 'PPProduktpass_Zertifizierungen') {
//testet ob nächstesFeld auch Zertifikat
//cpcDebug::cpc_debug("  zert","FKE44");
                        $loffset = $offset;
                        for ($i = 1; $i <= 4; $i++) {
                            $trow         = $fielddef['row'] + $i + $loffset;
                            $tcol         = $fielddef['col'];
                            $theadercol   = 'A';
                            $headercellxy = $theadercol . $trow;
                            $headercell   = $sheet->getCell($headercellxy)->getCalculatedValue();
//cpcDebug::cpc_debug(" $i  ZERT Hcell:".$headercell,"FKE44");
//cpcDebug::cpc_debug(" $i  ZERT xy:".$headercellxy,"FKE44");
                            $cellxy = $tcol . $trow;
                            $cell   = $sheet->getCell($cellxy)->getCalculatedValue();
//cpcDebug::cpc_debug("  $i ZERT cell:".$cell,"FKE44");
                            if (strlen(trim($headercell)) < 2) {
                                $offset++;
                                $lndx         = $i + 1;
                                $xfield       = 'PPProduktpass_ZertifizierungEigenschaften' . $lndx;
                                $cmd[$xfield] = "$cell";
//cpcDebug::cpc_debug(" CMD: $xfield $i $cell ","FKE44");
                            }
                            else {
                                break;
                            }
                        }
                    }
                    if (trim($fielddef['field']) == 'PPProduktpass_Logos') {
//testet ob nächstesFeld auch Logo
//cpcDebug::cpc_debug("  Logos","FKE44");
                        $loffset = $offset;
                        for ($i = 1; $i <= 4; $i++) {
                            $trow       = $fielddef['row'] + $i + $loffset;
                            $tcol       = $fielddef['col'];
                            $theadercol = 'A';
                            $headercellxy = $theadercol . $trow;
                            $headercell   = $sheet->getCell($headercellxy)->getCalculatedValue();
//cpcDebug::cpc_debug("  $i Logo Hcell:".$headercell,"FKE44");
//cpcDebug::cpc_debug("  $i Logo Hxy:".$headercellxy,"FKE44");
                            $cellxy = $tcol . $trow;
                            $cell   = $sheet->getCell($cellxy)->getCalculatedValue();
//cpcDebug::cpc_debug("  $i Logocell:".$cell,"FKE44");
                            if (strlen(trim($headercell)) < 2) {
                                $offset++;
                                $lndx         = $i + 1;
                                $xfield       = 'PPProduktpass_Logos' . $lndx;
                                $cmd[$xfield] = "$cell";
//
                            }
                            else {
                                break;
                            }
                        }
                    }
                }
                $s = "";
                if ($force) {
                    $ppf->update($cmd);
                    $ppid = $ppf->PPProduktpass_Id;
                }
                else {
                    $pp   = PPProduktpass::create($cmd);
                    $ppid = $pp->PPProduktpass_Id;
                }
                //cpcDebug::cpc_debug("return $message", "FKE44");
                if ($inqForce) {
                    $message .= "INQFORCE";
                }
                cpcDebug::cpc_debug("Import-Field-ModeEnde: " . $def->getSheetname() . " Message:" . $message);
                return (array("id" => $ppid, "msg" => $message));
            }
        }
        cpcDebug::cpc_debug("Import-Ende: " . $def->getSheetname());
    }
    function addEmptyQualitaet($id) {
        $q = new PPProduktpass_Qualitaet();
        $q->PPProduktpass_Qualitaet_Header           = "";
        $q->PPProduktpass_Qualitaet_Value01          = "Sytle A";
        $q->PPProduktpass_Qualitaet_PPProduktpass_id = $id;
        $q->PPProduktpass_Qualitaet_Value02          = "Sytle B";
        $q->PPProduktpass_Qualitaet_Value03          = "Sytle C";
        $q->PPProduktpass_Qualitaet_Value04          = "Sytle D";
        $q->PPProduktpass_Qualitaet_Value05          = "Sytle E";
        $q->PPProduktpass_Qualitaet_Value06          = "Sytle F";
        $q->PPProduktpass_Qualitaet_Value07          = "Sytle G";
        $q->save();
        $q = new PPProduktpass_Qualitaet();
        $q->PPProduktpass_Qualitaet_Header           = "";
        $q->PPProduktpass_Qualitaet_Value01          = "Design/Farbe Sytle A";
        $q->PPProduktpass_Qualitaet_PPProduktpass_id = $id;
        $q->PPProduktpass_Qualitaet_Value02          = "Design/Farbe Sytle B";
        $q->PPProduktpass_Qualitaet_Value03          = "Design/Farbe Sytle C";
        $q->PPProduktpass_Qualitaet_Value04          = "Design/Farbe Sytle D";
        $q->PPProduktpass_Qualitaet_Value05          = "Design/Farbe Sytle E";
        $q->PPProduktpass_Qualitaet_Value06          = "Design/Farbe Sytle F";
        $q->PPProduktpass_Qualitaet_Value07          = "Design/Farbe Sytle G";
        $q->save();
        $q = new PPProduktpass_Qualitaet();
        $q->PPProduktpass_Qualitaet_Header           = "Beschreibung Qualität";
        $q->PPProduktpass_Qualitaet_Value01          = "";
        $q->PPProduktpass_Qualitaet_PPProduktpass_id = $id;
        $q->PPProduktpass_Qualitaet_Value02          = "";
        $q->PPProduktpass_Qualitaet_Value03          = "";
        $q->PPProduktpass_Qualitaet_Value04          = "";
        $q->PPProduktpass_Qualitaet_Value05          = "";
        $q->PPProduktpass_Qualitaet_Value06          = "";
        $q->PPProduktpass_Qualitaet_Value07          = "";
        $q->save();
    }
    function addEmptyStyle($id) {
        $styles = array("A", "B", "C", "D", "E", "F");
        $c = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $id)->get()->count();
        for ($i = 0; $i < $c; $i++) {
            $style                                       = new PPProduktpass_Style();
            $style->PPProduktpass_Style_PPProduktpass_id = $id;
            $style->PPProduktpass_Style_Header           = "Style " . $styles[$i];
            $style->PPProduktpass_Style_Value01          = "Design/Farbe Style" . $styles[$i];
            $style->PPProduktpass_Style_Value02          = "Eigenschaft Style" . $styles[$i];
            $style->save();
        }
    }
    function exportAB($id) {
        $this->exportAB_Anlage($id, 'AB');
    }
    function exportAnlage($id) {
        $this->exportAB_Anlage($id, 'Anlage');
    }
    function exportAB_Final($id) {
        $this->exportAB_Anlage($id, 'AB', True);
    }
    function exportAnlage_Final($id) {
        $this->exportAB_Anlage($id, 'Anlage', True);
    }
    function exportAB_Anlage($id, $type, $final = false) {
        $pp = PPProduktpass::find($id);
        if ($type == 'AB') {
            $inputFileName  = storage_path() . "/data/templates/Vorlage_AB.xlsx";
            $outputFileName = public_path() . "/data/tmp/AB_" . $pp->PPProduktpass_IAN . ".xlsx";
            if ($final) {
                $fn             = "AB_" . $pp->PPProduktpass_IAN . "_" . date('Ymd_His') . ".xlsx";
                $outputFileName = public_path() . "/data/Dokumente/" . $fn;
                $this->newFilesEntry($fn, $pp->PPProduktpass_Id, 'Dokumente', 'AB vom ' . date('d.m.Y'), 'Dokumente');
            }
            if (!file_exists($inputFileName))
                cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
            $inputFileType = 'Excel2007';
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(false);
            $objPHPExcel = $objReader->load($inputFileName);
            $sheet       = $objPHPExcel->getSheetByName('AB - LieferantTemp');
            $def = new ExcelDefinitions(7);
            $dcell = $def->getCell('IAN');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Einkauefer . " " . $pp->PPProduktpass_IAN);
            $dcell = $def->getCell('Datum');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], date('d.m.Y'));
            $dcell = $def->getCell('Firma');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], 'Miro Radici Hometextile GmbH');
            $dcell = $def->getCell('Strasse');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], 'Seligenstädter Grund 5');
            $dcell = $def->getCell('PlzOrt');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], '63150 Heusenstamm');
            $ab = PPAB::where('PPAB_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->first();
            if ($ab->PPAB_VKEUR > 0) {
                $dcell = $def->getCell('FOB');
                $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_VKEUR);
            }
            else {
//Länderspezifische Preise
                $ms = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->get();
                foreach ($ms as $m) {
                    $l     = trim($m->PPProduktpass_Menge_Country);
                    $dcell = $def->getCell($l . '_LVK');
                    $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $m->PPProduktpass_Menge_VKFOBEUR);
                }
            }
            $dcell = $def->getCell('CD11');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD11);
            $dcell = $def->getCell('CD12');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD12);
            $dcell = $def->getCell('CD13');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD13);
            $dcell = $def->getCell('CD21');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD21);
            $dcell = $def->getCell('CD22');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD22);
            $dcell = $def->getCell('CD23');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD23);
            $dcell = $def->getCell('CD31');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD31);
            $dcell = $def->getCell('CD32');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD32);
            $dcell = $def->getCell('CD33');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_CD33);
            $dcell = $def->getCell('Article');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Artikelbezeichnung);
            $dcell = $def->getCell('Marke');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Marke);
            $dcell = $def->getCell('UZ');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_UZ);
            $dcell = $def->getCell('Produktionsstaette_Id');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_Produktionsstaette_Id);
            $dcell = $def->getCell('Produktionsstaette');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ab->PPAB_Produktionsstaette);
            $hl    = PPHerkunftslaender::find($ab->PPAB_Herkunftsland);
            $dcell = $def->getCell('Herkunftsland');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $hl->PPHerkunftslaender_Land);
            $dcell = $def->getCell('VerwendbareLogos');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Logos);
            $dcell = $def->getCell('Zertifizierung');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Zertifizierungen);
            $dcell = $def->getCell('Verpackung');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Verkaufsverpackung);
            $dcell = $def->getCell('Verpackungzusatz');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Materialstaerke_der_Verkaufsverpackung);
            $dcell = $def->getCell('Agentur');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Agentur);
            $dcell = $def->getCell('LT_KW1');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Liefertermin);
            $ah    = PPAbgangshafen::find($ab->PPAB_Abgangshafen);
            $dcell = $def->getCell('Abgangshafen');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $ah->PPAbgangshafen_Hafen);
            $ms = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $pp->PPProduktpass_Id)->get();
            foreach ($ms as $m) {
                $l = trim($m->PPProduktpass_Menge_Country);
                if ($m->PPProduktpass_Menge_Quantity > 0) {
                    $dcell = $def->getCell($l . '_Menge');
                    $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $m->PPProduktpass_Menge_Quantity);
                    $dcell = $def->getCell($l . '_Kolli');
                    $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Verpackungseinheit);
                    $dcell = $def->getCell($l . '_LT');
                    $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $m->PPProduktpass_Menge_DeliveryWeek);
                }
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
            $objWriter->save($outputFileName);
            $this->makeDownload($outputFileName, '', 'application/vnd.ms-excel');
        }
        if ($type == 'Anlage') {
///Ab Hier Anlage
            $def = new ExcelDefinitions(8);
            $inputFileName  = storage_path() . "/data/templates/Anlage_ohne_Blattschutz.xls";
            $outputFileName = public_path() . "/uploads/Anlage_" . $pp->PPProduktpass_IAN . "_" . date('Ymd_His') . ".xls";
            if ($final) {
                $fn             = "Anlage_" . $pp->PPProduktpass_IAN . "_" . date('Ymd_His') . ".xlsx";
                $outputFileName = public_path() . "/data/Dokumente/" . $fn;
                $this->newFilesEntry($fn, $pp->PPProduktpass_Id, 'Dokumente', 'Anlage vom ' . date('d.m.Y'), 'Dokumente');
            }
            $inputFileType = 'Excel5';
//	$inputFileType = 'Excel2007';
//  $inputFileType = 'Excel5';
//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(false);
            $objPHPExcel = $objReader->load($inputFileName);
            $sheet       = $objPHPExcel->getSheetByName('Anlage AB'); // eigentlich $def->getSheetname()
            $dcell = $def->getCell('IAN');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_IAN);
            $dcell = $def->getCell('Einkaeufer');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Einkaeufer);
            $dcell = $def->getCell('Lieferant');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], 'Miro Radici Hometextile GmbH  /  Seligenstädter Grund 5  /  63150 Heusenstamm');
            $dcell = $def->getCell('Artikel');
            $sheet->setCellValueByColumnAndRow($dcell['col'], $dcell['row'], $pp->PPProduktpass_Artikelbezeichnung);
//array(5) { [4379]=> array(6) { ["id"]=> int(4379) ["design"]=> string(14) "weiss: 11-0601" ["translate_design"]=> string(5) "white" ["menge"]=> string(1) "3" ["EAN"]=> string(5) "EAN 1" ["OSMenge"]=> string(7) "38.0000" } [
            $pc    = new ProjectsController ();
            $sorts = $pc->getSortierung($pp->PPProduktpass_Id);
            $dcell = $def->getCell('EAN_START');
            $row = $dcell['row'];
            $col = $dcell['col'];
//design [col, row]
//Menge  [col+1, row]
//EAN    [col+1, row+1]
            $os = false;
            $vp = 0;
            foreach ($sorts as $sort) {
                $sheet->setCellValueByColumnAndRow($col, $row, $sort['design']);
                $sheet->setCellValueByColumnAndRow($col + 1, $row, $sort['menge']);
                $sheet->setCellValueByColumnAndRow($col + 1, $row + 1, $sort['EAN']);
                $row += 2;
                if ($sort['OSMenge'] > 0)
                    $os  = true;
                $vp  += $sort['menge'];
            }
            if ($os) {
                $dcell = $def->getCell('EAN_START_OS');
                $row   = $dcell['row'];
                $col   = $dcell['col'];
                foreach ($sorts as $sort) {
                    $sheet->setCellValueByColumnAndRow($col, $row, $sort['design']);
                    $sheet->setCellValueByColumnAndRow($col + 1, $row + 1, $sort['OSMenge']); // Kartonanzahl
                    $sheet->setCellValueByColumnAndRow($col + 1, $row + 2, $sort['OSMenge'] * $vp);
                    $sheet->setCellValueByColumnAndRow($col + 1, $row + 3, $sort['EAN']);
                    $row += 4;
                }
            }
            $quals = $pc->getQualitaet($pp->PPProduktpass_Id);
            if ($pp->PPProduktpass_Importart <= 3) {
                $dcell = $def->getCell('StartHeimtex3');
            }
            else {
                $dcell = $def->getCell('StartBekleidung');
            }
            $row = $dcell['row'];
            $col = $dcell['col'];
//var_dump($dcell);
            foreach ($quals as $qual) {
//if (strlen($qual->PPProduktpass_Qualitaet_Value01) >0) {
                $sheet->setCellValueByColumnAndRow($col, $row, $qual->PPProduktpass_Qualitaet_Value01);
//echo ($qual->PPProduktpass_Qualitaet_Value01."<br>");
//}
                $row = $row + 1;
            }
//exit;
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $inputFileType);
            $objWriter->save($outputFileName);
            $this->makeDownload($outputFileName, '', 'application/vnd.ms-excel');
        }
//echo ($def->getcell('CD33'));exit;
    }
    function exportPP($id) {
        $this->_exportPP($id, false);
    }
    function exportPP_Final($id) {
        $pc = new ProjectsController();
        $pc->copyPP($id);
//$this->_exportPP($id, True);
    }
    function _exportPP($id, $final = false) {
        $pp = PPProduktpass::find($id);
        $file = $pp->PPProduktpass_AktExcel;
//cpcDebug::cpc_debug("Start Export");
//cpcDebug::cpc_debug("	file: ".$file);
//cpcDebug::cpc_debug("	def: ".$idef);
//cpcDebug::cpc_debug("	id: ".$id);
        $filename      = explode('/', $file);
        $inputFileName = public_path() . "/data/" . $file;
        if (!file_exists($inputFileName)) {
            cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
        }
//var_dump($inputFileName);echo("<br>");
        $inputFileType = 'Excel2007';
//$inputFileType = 'Excel5';
//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(false);
        $objPHPExcel = $objReader->load($inputFileName);
        $def = new ExcelDefinitions(3); //Produktpass
        $sheetName = $def->getSheetname();
        $table     = $def->getTable();
        $startrow  = $def->getStartrow();
        $endrow    = $def->getEndrow();
        $sheet = $objPHPExcel->getSheetByName($sheetName);
//var_dump($sheetName);echo("<br>");exit;
        $sheeta = $sheet->toArray(null, true, true, true);
        $table = $def->getTable();
//cpcDebug::cpc_debug("  Produktpass");
        $cmd = array();
        foreach ($def->getFieldDef() as $fielddef) {
            $sheet     = $objPHPExcel->getSheetByName($fielddef['sheet']);
            $colNumber = PHPExcel_Cell::columnIndexFromString($fielddef['col']) - 1;
            $sheet->setCellValueByColumnAndRow($colNumber, $fielddef['row'], $pp->{trim($fielddef['field'])});
        }
//Qualität
        $def   = new ExcelDefinitions(5);
        $sheet = $objPHPExcel->getSheetByName($def->getSheetname());
        $ppq      = PPProduktpass_Qualitaet::where('PPProduktpass_Qualitaet_PPProduktpass_Id', '=', $id)->get()->toArray();
        $rowcount = $def->getStartrow();
        foreach ($ppq as $row) {
            foreach ($row as $attr => $value) {
                if ($col = $def->getCol($attr)) {
                    $colNumber = PHPExcel_Cell::columnIndexFromString($col) - 1;
                    if ($colNumber != 0)
                        $sheet->setCellValueByColumnAndRow($colNumber, $rowcount, $value);  // 1. Splate nicht verändern!!
//echo($def->getSheetname()." ".$rowcount." ".$colNumber." ".$attr." ".$value."<br> ");
                }
            }
            $rowcount++;
        }
        /* $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id','=', $id)
          ->where('PPPPFiles_Name', 'like', 'PFLEGE%')
          ->orderBy('PPPPFiles_Type', 'DESC')->first();
          $objDrawing = new PHPExcel_Worksheet_Drawing();
          $objDrawing->setWorksheet($sheet);
          $objDrawing->setName("PSYM");
          //$objDrawing->setDescription("Description");
          $objDrawing->setPath(public_path()."/uploads/".$files->PPPPFiles_Name);
          $objDrawing->setCoordinates('B39');
          $objDrawing->setHeight(10); $objDrawing->setWidth(10);
          $objDrawing->setOffsetX(50);
          $objDrawing->setOffsetY(5);
         */
//Sortierung
        $def   = new ExcelDefinitions(6);
        $sheet = $objPHPExcel->getSheetByName($def->getSheetname());
        $pps      = PPProduktpass_Sortierung::where('PPProduktpass_Sortierung_PPProduktpass_Id', '=', $id)->get()->toArray();
        $rowcount = $def->getStartrow();
        foreach ($pps as $row) {
            foreach ($row as $attr => $value) {
                if ($col = $def->getCol($attr)) {
                    $colNumber = PHPExcel_Cell::columnIndexFromString($col) - 1;
                    if ($colNumber != 0)
                        $sheet->setCellValueByColumnAndRow($colNumber, $rowcount, $value);  // 1. Splate nicht verändern!!
//echo($def->getSheetname()." ".$rowcount." ".$colNumber." ".$attr." ".$value."<br> ");
                }
            }
            $rowcount++;
        }
//Menge
        $def   = new ExcelDefinitions(1);
        $sheet = $objPHPExcel->getSheetByName($def->getSheetname());
        $ppm      = PPProduktpass_Menge::where('PPProduktpass_Menge_PPProduktpass_Id', '=', $id)->get()->toArray();
        $rowcount = $def->getStartrow();
        foreach ($ppm as $row) {
            foreach ($row as $attr => $value) {
                if ($col = $def->getCol($attr)) {
                    $colNumber = PHPExcel_Cell::columnIndexFromString($col) - 1;
                    $sp        = array(0, 1, 5, 8); //Nur Spalten 0 1 5 6
                    if (in_array($colNumber, $sp)) {
                        $sheet->setCellValueByColumnAndRow($colNumber, $rowcount, $value);  // 1. Splate nicht verändern!!
//echo($def->getSheetname()." ".$rowcount." ".$colNumber." ".$attr." ".$value."<br> ");
                    }
                }
                $sheet->setCellValueByColumnAndRow(4, $rowcount, $pp->PPProduktpass_Verpackungseinheit);  // Anz/Kollie aus PP
                $sheet->setCellValueByColumnAndRow(4, $rowcount, $pp->PPProduktpass_Verpackungseinheit);  // Anz/Kollie aus PP
            }
            $rowcount++;
        }
        if ($final) {
            $xfilename      = date('Y-m-d') . '_' . $pp->PPProduktpass_IAN . ".xlsm";
            $outputFileName = public_path() . "/data/Dokumente/" . $xfilename; //.$filename[1];
            $this->newFilesEntry($xfilename, $pp->PPProduktpass_Id, 'Dokumente', 'PP Final vom ' . date('d.m.Y'), 'Dokumente');
        }
        else {
            $outputFileName = public_path() . "/data/tmp/" . $pp->PPProduktpass_IAN . ".xlsm"; //.$filename[1];
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($outputFileName);
//echo($outputFileName); exit;
        $this->makeDownload($outputFileName, '', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //vnd.openxmlformats-officedocument.spreadsheetml.sheet  oder vnd.ms-excel
    }
    public
            function newProjekt($id, $boardid = 2) {
        /* $projekt = new PPProjekte();
          $projekt->PPProjekte_Bezeichnung = "Lidl 3 Tiere";
          $projekt->PPProjekte_Verantwortlich = "Frank Keppel";
          $projekt->PPProjekte_AnlageDatum = date("Y-m-d H:i:s");
          $projekt->save();
          exit; */
        $spalten = PPBoardSpalte::where("PPBoardSpalte_PPBoard_Id", "=", $boardid)->get();
//dd($spalten);
        foreach ($spalten as $spalte) {
            $termin                             = new PPTermine();
            $termin->PPTermine_PPProduktpass_Id = $id;
//$termin->PPTermine_Header = "H".$i;
            $termin->PPTermine_Status           = "Neu";
            $termin->PPTermine_PPBoardSpalte_id = $spalte->PPBoardSpalte_Id;
            $termin->PPTermine_MAZustaendigkeit = $spalte->PPBoardSpalte_DefaultMA;
            $termin->save();
        }
        return Redirect::to('search');
    }
    public
            function getLidlQualitaeten() {
        $qs = DB::table('PPLidlQualitaetsarten')->where('PPLidlQualitaetsarten_Id', '>=', '12')->orderBy('PPLidlQualitaetsarten_Id', 'ASC')->get();
        foreach ($qs as $q) {
            $ret[$q->PPLidlQualitaetsarten_Id]['id']  = $q->PPLidlQualitaetsarten_Id;
            $ret[$q->PPLidlQualitaetsarten_Id]['art'] = $q->PPLidlQualitaetsarten_Art;
        }
        return $ret;
    }
    public
            function testImportart($file, $idef) {
        $inputFileName = public_path() . "/data/" . $file;
        if (!file_exists($inputFileName))
            cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
        $inputFileType = 'Excel2007';
//$inputFileType = 'Excel5';
//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($inputFileName);
        $def       = new ExcelDefinitions($idef);
        $sheetname = $def->getSheetname();
        return $objPHPExcel->sheetNameExists($sheetname);
    }
    function fromXLS($file, $importart) {
        if ($importart > 3) {
            if (!$this->testImportart($file, 4)) {
                $data['content'] = "Datei passt nicht zu Importart!";
                return View::make('main', $data);
            }
        }
        else {
            if (!$this->testImportart($file, 5)) {
                $data['content'] = "Datei passt nicht zu Importart!";
                return View::make('main', $data);
            }
        }
        $import_pp         = self::IMPORTART_PP;
        $import_menge      = self::IMPORTART_MENGE;
        $import_qualitaet  = self::IMPORTART_QUALITAET;
        $import_sortierung = self::IMPORTART_SORTIERUNG;
        $import_style      = self::IMPORTART_STYLE;
        $import_uebersicht = self::IMPORTART_UEBERSICHT;
        if ($importart == 14) {
            $import_pp         = self::IMPORTART_PP_NEU;
            $import_menge      = self::IMPORTART_MENGE_NEU;
            $import_qualitaet  = 0;
            $import_sortierung = self::IMPORTART_SORTIERUNG_NEU;
            $import_style      = 0;
        }
        $id       = 0;
        $inqForce = false;
        $message            = "";
        $return_importExcel = $this->importExcel($file, $import_pp, 0);
        cpcDebug::cpc_debug("PP Produktpass eingelesen: " . print_r($return_importExcel, true));
        if ($return_importExcel) {
            $id      = $return_importExcel['id'];
            $message = $return_importExcel['msg'];
            if (strpos($message, "INQFORCE") !== false) {
                cpcDebug::cpc_debug("INQFORCE gesetzt");
                $inqForce = true;
            }
        }
        if ($id) {
            if (PPProduktpass::find($id)) {
                $pp = PPProduktpass::find($id);
            }
            else {
                $pp = PPInquiry::find($id);
            }
            $pp->PPProduktpass_Importart         = $importart;
            $pp->PPProduktpass_AktExcel          = $file;
            $pp->PPProduktpass_Import_BISUser_Id = Auth::getUser()->id;
            $pp->PPProduktpass_Import_Datum      = date('Y-m-d');
            $pp->PPProduktpass_IsInquiry         = 0;
            $pp->PPProduktpass_InquiryArt        = 0;
            if ($this->IsInquiry == 1) {
                $pp->PPProduktpass_IAN = "I-" . $pp->PPProduktpass_IAN;
                if ($this->IsBettwaesche) {
                    $pp->PPProduktpass_InquiryArt = 1;
                }
            }
            $pp->save();
            $this->importExcel($file, $import_menge, $id);
            if ($this->HasCharge) {
                if ($this->IsInquiry) {
                    $this->importExcel($file, $import_sortierung, $id, $inqForce);
                }
                else {
                    $this->importExcel($file, $import_uebersicht, $id);
                }
                $sortcount = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $id)->count();
                if ($sortcount == 0) {
                    $this->importExcel($file, $import_sortierung, $id, $inqForce);
                }
            }
            else {
                $this->importExcel($file, $import_sortierung, $id, $inqForce);
            }
            if ($importart > 3) {
                $this->importExcel($file, $import_qualitaet, $id, $inqForce);
            }
            else {
                $this->importExcel($file, 5, $id, $inqForce);
            }
            if ($inqForce) {
                DB::delete("Delete from PPProduktpass_Style where PPProduktpass_Style_PPProduktpass_Id = " . $id);
                cpcDebug::cpc_debug("Style-Datensätze für ID: " . $id . " wurden gelöscht!");
            }
            $this->importExcel($file, $import_style, $id, $inqForce);
            if ($importart != 14) {
                $this->getExcelimages($id, $file);
                $this->getExcelimages($id, $file, "Qualität");
            }
            else {
                $this->addEmptyQualitaet($id);
                $this->addEmptyStyle($id);
            }
//$this->getExcelimages($id,$file,'Qualität Heimtex 3 (DE)');
            $ppp                              = new PPPurchase();
            $ppp->PPPurchase_PPProduktpass_Id = $id;
            $ppp->save();
            $this->newProjekt($id);
            $fn                                = explode("/", $file);
            $i                                 = count($fn) - 1;
            $file                              = $fn[$i];
            $files                             = new PPPPFiles();
            $files->PPPPFiles_Name             = $file;
            $files->PPPPFiles_PPProduktpass_Id = $id;
            $files->PPPPFiles_Type             = "Dokumente";
            $files->PPPPFiles_Pfad             = "import";
            $files->PPPPFiles_SubKat           = "Produktpass";
            $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
            $files->PPPPFiles_Description      = "Original Excel-PP";
            $files->PPPPFiles_UserCreate      = Auth::getUser()->id;
            $files->save();
            $pp                           = PPProduktpass::find($id);
            $pp->PPProduktpass_IsInquiry  = $this->IsInquiry;
            $pp->PPProduktpass_InquiryArt = $this->IsBettwaesche;
            $pp->save();
            $data['content']     = "<b>Datei $file erfolgreich importiert!<b><br><br><a href='show/$id/$this->IsInquiry'>Link zum Produktpass</a>";
            $data['bordercolor'] = "green";
            $data['msg']         = $message;
        }
        else {
//echo("EXIT3: $message");
//$data['content'] = 'Daten nicht importiert! IAN mit neuer version einlesen?<a href="fromXLS/'.urlencode($file).'/'.$bekleidung.'/true">Neue Version';
            $data['content']     = "Datei $file nicht importiert! <br><br> IAN mit neuer Version einlesen?<br><br><br>" .
                    '<form action="forceXLS" method="post">
						<input type="hidden" name="file" value="' . $file . '" />
						<input type="hidden" name="Importart" value="' . $importart . '" />
						<input type="hidden" name="force" value="true" />
                                                                                                                                      <input type="hidden" name="IsNewVersion" value="' . $this->IsNewVersion . '" />
                                                                                                                                      <input type="hidden" name="HasCharge" value="' . $this->HasCharge . '" />
						<input type="submit" value="Neue Version anlegen!" />
					</form>';
            $data['bordercolor'] = "red";
            $data['msg']         = "";
//$data['content'] = 'Daten nicht importiert! <br><br> IAN mit neuer Version einlesen?<br>';
        }
        $data['content'] = View::make('helpers.message')->with("data", $data);
//	echo("EXIT4:". $data['content']); exit;
        $res['view'] = View::make('main', $data);
        $ian         = "";
        if (isset($pp)) {
            $ian = $pp->PPProduktpass_IAN;
        }
        $res['ian'] = $ian;
        return $res;
    }
    function fromXLSMultiple($file, $importart) {
        if ($importart > 3) {
            if (!$this->testImportart($file, 4)) {
                $return = "E: Datei passt nicht zu Importart!";
                return $return;
            }
        }
        else {
            if (!$this->testImportart($file, 5)) {
                $return = "E: Datei passt nicht zu Importart!";
                return $return;
            }
        }
        $import_pp         = self::IMPORTART_PP;
        $import_menge      = self::IMPORTART_MENGE;
        $import_qualitaet  = self::IMPORTART_QUALITAET;
        $import_sortierung = self::IMPORTART_SORTIERUNG;
        $import_style      = self::IMPORTART_STYLE;
        $import_uebersicht = self::IMPORTART_UEBERSICHT;
        if ($importart == 14) {
            $import_pp         = self::IMPORTART_PP_NEU;
            $import_menge      = self::IMPORTART_MENGE_NEU;
            $import_qualitaet  = 0;
            $import_sortierung = self::IMPORTART_SORTIERUNG_NEU;
            $import_style      = 0;
        }
        $id                 = 0;
        $message            = "";
        $return_importExcel = $this->importExcel($file, $import_pp, 0);
        $inqForce = false;
        if ($return_importExcel) {
            $id      = $return_importExcel['id'];
            $message = $return_importExcel['msg'];
            if (strpos($message, "INQFORCE") !== false) {
                $inqForce = true;
            }
        }
        if ($id != 0) {
            $pp = PPProduktpass::find($id);
            if (is_null($pp) and $this->IsInquiry) {
                $pp = PPInquiry::find($id);
            }
            $pp->PPProduktpass_Importart         = $importart;
            $pp->PPProduktpass_AktExcel          = $file;
            $pp->PPProduktpass_Import_BISUser_Id = Auth::getUser()->id;
            $pp->PPProduktpass_Import_Datum      = date('Y-m-d');
            //$pp->PPProduktpass_IsInquiry = 0;
            /* if ($this->IsInquiry == 1) {
              $pp->PPProduktpass_IAN = "I-" . $pp->PPProduktpass_IAN;
              $pp->PPProduktpass_IsInquiry = "1";
              } */
            $pp->save();
            $this->importExcel($file, $import_menge, $id, $inqForce);
            if ($this->HasCharge) {
                //$this->importExcel($file, $import_uebersicht, $id);
                //$sortcount = PPProduktpass_Sortierung::where("PPProduktpass_Sortierung_PPProduktpass_Id", "=", $id)->count();
                //if ($sortcount == 0) {
                // Herr Eirich: 2019-04-10: Inquiry-Sheet Nur Sortierung übernehmen
                $this->importExcel($file, $import_sortierung, $id, $inqForce);
                //}
            }
            else {
                $this->importExcel($file, $import_sortierung, $id, $inqForce);
            }
            if ($importart > 3) {
                $this->importExcel($file, $import_qualitaet, $id, $inqForce);
            }
            else {
                $this->importExcel($file, 5, $id, $inqForce);
            }
            $this->importExcel($file, $import_style, $id, $inqForce);
            if ($importart != 14) {
                $this->getExcelimages($id, $file);
                $this->getExcelimages($id, $file, "Qualität");
            }
            else {
                $this->addEmptyQualitaet($id);
                $this->addEmptyStyle($id);
            }
//$this->getExcelimages($id,$file,'Qualität Heimtex 3 (DE)');
            $ppp                              = new PPPurchase();
            $ppp->PPPurchase_PPProduktpass_Id = $id;
            $ppp->save();
            $this->newProjekt($id);
            $fn                                = explode("/", $file);
            $i                                 = count($fn) - 1;
            $file                              = $fn[$i];
            $files                             = new PPPPFiles();
            $files->PPPPFiles_Name             = $file;
            $files->PPPPFiles_PPProduktpass_Id = $id;
            $files->PPPPFiles_Type             = "Dokumente";
            $files->PPPPFiles_Pfad             = "import";
            $files->PPPPFiles_SubKat           = "Produktpass";
            $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
            $files->PPPPFiles_Description      = "Original Excel-PP";
            $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
            $files->save();
            $pp = PPProduktpass::find($id);
            if (is_null($pp) and $this->IsInquiry) {
                $pp = PPInquiry::find($id);
            }
            if ($this->IsInquiry) {
                $pp->PPProduktpass_IsInquiry  = 1;
                $pp->PPProduktpass_IAN        = "I-" . $pp->PPProduktpass_IAN;
                $pp->PPProduktpass_InquiryArt = $this->IsBettwaesche ? 1 : 0;
            }
            else {
                $pp->PPProduktpass_IsInquiry  = 0;
                $pp->PPProduktpass_InquiryArt = 0;
            }
            $pp->save();
            cpcDebug::cpc_debug("IAN: $pp->PPProduktpass_IAN wurde eingelesen!");
            // Erzeuge Inquiry File
            if ($this->IsInquiry) {
                $eic = new ExcelInquiryController();
                cpcDebug::cpc_debug("Erzeuge Inquiry für: $pp->PPProduktpass_IAN !");
                $fn = $eic->getExcelInquiry($pp->PPProduktpass_IAN, $this->IsBettwaesche);
                cpcDebug::cpc_debug("Inquiry für: $pp->PPProduktpass_IAN erzeugt!");
            }
            $return = "S: <b>Datei erfolgreich importiert!<b> <a href='show/$id/$this->IsInquiry' target='_blank'>Link zum Inquiry</a>";
        }
        else {
            $return = "E: <b>Datei nicht importiert!<b>" . $message;
        }
        return $return;
    }
    function forceXLS() {
//$file = Session::get('xFile');
//echo('<pre>');var_dump(Session::all());echo('</pre>'); exit;
        $this->HasCharge    = $_POST['HasCharge'];
        $this->IsNewVersion = $_POST['IsNewVersion'];
        $file      = Input::get('file');
        $importart = Input::get('Importart');
        $import_pp         = self::IMPORTART_PP;
        $import_menge      = self::IMPORTART_MENGE;
        $import_qualitaet  = self::IMPORTART_QUALITAET;
        $import_sortierung = self::IMPORTART_SORTIERUNG;
        $import_style      = self::IMPORTART_STYLE;
        $import_uebersicht = self::IMPORTART_UEBERSICHT;
        if ($importart == 14) {
            $import_pp         = self::IMPORTART_PP_NEU;
            $import_menge      = self::IMPORTART_MENGE_NEU;
            $import_qualitaet  = 0;
            $import_sortierung = self::IMPORTART_SORTIERUNG_NEU;
            $import_style      = 0;
        }
        if ($importart > 3) {
            if (!$this->testImportart($file, 4)) {
                $data['content'] = "Datei passt nicht zu Importart!";
                return View::make('main', $data);
            }
        }
        else {
            if (!$this->testImportart($file, 5)) {
                $data['content'] = "Datei passt nicht zu Importart!";
                return View::make('main', $data);
            }
        }
        $message = "";
        $id      = 0;
        if ($return_importExcel = $this->importExcel($file, $import_pp, 0, true)) {
            $id      = $return_importExcel['id'];
            $message = $return_importExcel['msg'];
        }
        if ($id) {
            $this->importExcel($file, $import_menge, $id, true);
            if ($importart > 3)
                $this->importExcel($file, $import_qualitaet, $id, true);
            else
                $this->importExcel($file, 5, $id, true);
//exit;
            if ($this->HasCharge) {
                $this->importExcel($file, $import_uebersicht, $id, true);
            }
            else {
                $this->importExcel($file, $import_sortierung, $id, true);
            }
            DB::delete("delete from PPProduktpass_Style where PPProduktpass_Style_PPProduktpass_Id = " . $id);
            cpcDebug::cpc_debug("Style Datensätze gelöscht für ID:" . $id);
            // exit;
            $this->importExcel($file, $import_style, $id, true);
            $this->getExcelimages($id, $file);
            $this->getExcelimages($id, $file, "Qualität");
            /* $ppp = new PPPurchase();
              $ppp->PPPurchase_PPProduktpass_Id = $id;
              $ppp->save();
             */
//$this->newProjekt($id);
            $fn                                = explode("/", $file);
            $i                                 = count($fn) - 1;
            $file                              = $fn[$i];
            $files                             = new PPPPFiles();
            $files->PPPPFiles_Name             = $file;
            $files->PPPPFiles_PPProduktpass_Id = $id;
            $files->PPPPFiles_Type             = "Dokumente";
            $files->PPPPFiles_Pfad             = "import";
            $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
            $files->PPPPFiles_Description      = "Revision Excel-PP";
            $files->PPPPFiles_SubKat           = "Produktpass";
            $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
            $files->save();
            //$data['content'] = "Datei $file erfolgreich importiert!";
            $data['content']     = "<b>Datei $file erfolgreich importiert!<b><br><br><a href='show/$id'>Link zum Produktpass</a>";
            $data['msg']         = $message;
            $data['bordercolor'] = "green";
        }
        else {
//$data['content'] = 'Daten nicht importiert! IAN mit neuer version einlesen?<a href="fromXLS/'.urlencode($file).'/'.$bekleidung.'/true">Neue Version';
            $data['content']     = "Datei $file nicht importiert! <br><br> IAN mit neuer Version einlesen?<br><br><br>" .
                    '<form action="forceXLS">
						<input type="hidden" name="file" value="' . $file . '" />
						<input type="hidden" name="bekleidung" value="' . $importart . '" />
						<input type="hidden" name="force" value="true" />
                                                                                                                                      <input type="hidden" name="IsNewVersion" value="' . $this->IsNewVersion . '" />
                                                                                                                                      <input type="hidden" name="HasCharge" value="' . $this->HasCharge . '" />
                                                                        			<input type="submit" value="Neue Version anlegen!" />
					</form>';
            $data['msg']         = "";
            $data['bordercolor'] = "red";
        }
        $data['content'] = View::make('helpers.message')->with("data", $data);
        return View::make('main', $data);
    }
    function upload() {
        if (isset($_FILES['dirupload']) and strlen($_FILES['dirupload']['name'][0]) > 3) {
            $logI = $this->_uploadDir();
            cpcDebug::cpc_debug("Reslult Mutltiple Upload:");
            cpcDebug::cpc_debug(print_r($logI, true));
            $message = "<table style='border-collapse:collapse;'>";
            foreach ($logI as $fn => $l) {
                if (substr($l, 0, 2) == "E:") {
                    $col = "style='border:1px solid lightgray;width:60px;background-color:orange;padding:6px;'";
                    $res = "Fehler";
                }
                else {
                    $col = "style='border:1px solid lightgray;width:60px;background-color:lime;padding:6px;'";
                    $res = "OK";
                }
                $l       = substr($l, 2);
                $message .= '<tr><td style="border:1px solid lightgray;width:200px;padding:6px;">' . $fn . '</td>  <td style="border:1px solid lightgray;width:400px;padding:6px;">' . $l . '</td><td ' . $col . '>' . $res . '</td><tr>';
            }
            $message .= "</table>";
            $data['content']     = "<h3>Bulk-Import Ergebnis<h3><br>";
            $data['bordercolor'] = "green";
            $data['msg']         = $message;
            $data['content']     = View::make('helpers.message')->with("data", $data);
            return View::make('main', $data);
        }
        else {
            return $this->_upload();
        }
    }
    function _uploadDir() {
        $implog = array();
        $this->IsInquiry = 0;
        if (Input::has('IsInquiry')) {
            $this->IsInquiry = Input::get('IsInquiry');
        }
        if (Input::has('IsBW')) {
            $this->IsBettwaesche = Input::get('IsBW');
        }
        $this->IsNewVersion = Input::get('IsNewVersion');
        $this->HasCharge    = Input::get('IsNewVersionCharge');
        $importart = Input::get('Importart');
        switch ($importart) {
            case '1':
                break;
            case '2':
                break;
            case '3':
                break;
            case '9':
                break;
            case '12':
                break;
            case '14':
                break;
            default:
                $implog[$file['name']] = "Falsche Importart für Datei:  " . $file['name'] . "! <br>";
                return $implog;
        }
        $fileArr = $_FILES['dirupload'];
        $upload  = array();
        foreach ($fileArr['name'] as $keyee => $info) {
            $uploads[$keyee]['name']     = $fileArr['name'][$keyee];
            $uploads[$keyee]['type']     = $fileArr['type'][$keyee];
            $uploads[$keyee]['tmp_name'] = $fileArr['tmp_name'][$keyee];
            $uploads[$keyee]['error']    = $fileArr['error'][$keyee];
        }
        //$implog[] = "Bericht über Bulk Import Inquries<br>";
        foreach ($uploads as $file) {
            $newname               = str_random(6) . "_" . $file['name'];
            move_uploaded_file($file['tmp_name'], "data/import/" . $newname);
            $implog[$file['name']] = $this->fromXLSMultiple('import/' . $newname, $importart);
        }
        return $implog;
        //return $this->fromXLS('import/' . $filename, $importart);
    }
    function _upload() {
        $this->IsInquiry = 0;
        if (Input::has('IsInquiry')) {
            $this->IsInquiry = Input::get('IsInquiry');
        }
        if (Input::has('IsBW')) {
            $this->IsBettwaesche = Input::get('IsBW');
        }
        $this->IsNewVersion = Input::get('IsNewVersion');
        $this->HasCharge    = Input::get('IsNewVersionCharge');
        $importart = Input::get('Importart');
        switch ($importart) {
            case '1':
                break;
            case '2':
                break;
            case '3':
                break;
            case '9':
                break;
            case '12':
                break;
            case '14':
                break;
            default:
                $data['content'] = "Diese Importart wird noch nicht unterstützt.";
                return View::make('main', $data);
                break;
        }
        $destinationPath = public_path() . '/data/import/';
        $file            = Input::file('file');
        $filename        = str_random(6) . "_" . $file->getClientOriginalName();
        $upload_success  = Input::file('file')->move($destinationPath, $filename);
        $res = $this->fromXLS('import/' . $filename, $importart);
        if ($this->IsInquiry) {
            $eic = new ExcelInquiryController();
            $art = $this->IsBettwaesche ? 1 : 0;
            cpcDebug::cpc_debug("_upload art:" . $art);
            $fn  = $eic->getExcelInquiry($res['ian'], $art);
        }
        Return $res['view'];
    }
    function importAvis($file) {
        //READER
        $inputFileName = $file;
        if (!file_exists($inputFileName)) {
            cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
        }
        echo("OK1 $inputFileName <br>");
        $spreadsheet = PhpSpreadsheet\IOFactory::load($inputFileName);
        $inputFileType = 'Excel2007';
        //$inputFileType = 'Excel5';
        //	$inputFileType = 'Excel2003XML';
        //	$inputFileType = 'OOCalc';
        //	$inputFileType = 'Gnumeric';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(false);
        echo("OK2<br>");
        $objPHPExcel = $objReader->load($inputFileName);
        echo("OK3<br>");
        $sheetNames = $objPHPExcel->getSheetNames();
        echo("OK4<br>");
        foreach ($sheetNames as $sheetName) {
            print_r($sheetName);
        }
        exit;
    }
    public
            function uploadAvis() {
        $ts     = new DateTime();
        $prefix = $ts->getTimestamp();
        $uploaddir  = public_path() . "/data/Avis/";
        $uploadfile = $uploaddir . $prefix . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $this->importAvis($uploadfile);
        }
        else {
            echo("Nicht hochgeladen!");
        }
        exit;
    }
    public
            function getUploadAvisForm() {
//
        $data['content'] = View::make('UploadAvis');
        return View::make('main', $data);
    }
    public function getUploadForm($IsInquiry = 0) {
//
        $data['importarten'] = $this->getLidlQualitaeten();
        if ($IsInquiry == 1) {
            $data['content'] = View::make('UploadInquiry')->with('data', $data);
        }
        else {
            $data['content'] = View::make('Upload')->with('data', $data);
        }
        $status['anab'] = 'login';
        $status['link'] = 'users/login';
        $status['user'] = 'nn';
        $data['name']       = "Franky";
        $data['userstatus'] = "Happy";
        $data['status']     = $status;
        return View::make('main', $data);
    }
    public function iFrameUpload() {
        return View::make('iframeTermineUpload');
    }
    /*public function uploadFilesTPT() {
        echo('Klappt!');
    }*/
    public function uploadFiles() {
          /*echo('<pre>');
          var_dump(Input::all());
          echo('</pre>');
          exit; */
        $inputall = Input::all();
        $id = Input::get('ppid');
        $subTabName     = Input::get('hiddenActivsubTabName');
        if (isset($inputall['link']) and $inputall['link'] != ""){
            $skat = Input::get('Kategorie');
            //str_replace('_',' ',$skat);
            $bemerkung = Input::get('bemerkung');
            $files                             = new PPPPFiles();
            $files->PPPPFiles_Name             = 'Link';
            $files->PPPPFiles_PPProduktpass_Id = $id;
            $files->PPPPFiles_Type             = Input::get('filetype');
            $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
            $files->PPPPFiles_Description      = $bemerkung;
            $files->PPPPFiles_SubKat           = $skat;
            $files->PPPPFiles_Ordnung          = Input::get('Ordnung');
            $files->PPPPFiles_Link             = $inputall['link'];
            $files->PPPPFiles_LinkName         = $inputall['linkName'];
            $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
            $files->save();
            return Redirect::to($this->getActiveTab() );
        }
        cpcDebug::cpc_debug($inputall);
        if (Input::get('filetype') == 'Bilder Textbausteine') {
            $destinationPath = public_path() . '/data/uploads/BilderTextbausteine/';
            $file            = Input::file('file');
            $filename        = $file->getClientOriginalName();
            $upload_success  = Input::file('file')->move($destinationPath, $filename);
            return Redirect::to($this->getActiveTab());
        }
        //return Response::json(array('success' => true, 'error' => $inputall));
        //cpcDebug::cpc_debug("  Upload Files: ".print_r($inputall,true),"FKEUPL99");
        $destinationPath = public_path() . '/data/uploads/';
        $file            = Input::file('file');
        $ordnung         = Input::get('file');
        $orgFilename     = $file->getClientOriginalName();
        $filename        = str_random(6) . "_" . $orgFilename;
        $filename        = str_replace('#','_', $filename);
        $upload_success  = Input::file('file')->move($destinationPath, $filename);
        $skat = "Allgemein";
        if (Input::has('Kategorie')) {
            if (strlen($skat) > 2) {
                $skat = str_replace(" ", "_", Input::get('Kategorie'));
            }
        }
        $skat = Input::get('Kategorie');
        $bemerkung = Input::get('bemerkung');
        /* if (strlen(trim($bemerkung)) <= 0){
            $bemerkung = $orgFilename;*/
        } 
    private function newFilesEntrySPLocal ($ppid, $name, $type, $bemerkung, $skat, $ordnung, $splink = null, $link='', $linkName='', $versioning, $isExtern = 0 ){
        $fileEntry  = $this->newFilesEntrySP($ppid, $name, $type, $bemerkung, $skat, $ordnung, $splink, $link, $linkName, $versioning, $isExtern);
        $prefix = str_pad($fileEntry->PPPPFiles_Id, 6, 0, STR_PAD_LEFT);
        $fileEntry->PPPPFiles_Name = $fileEntry->PPPPFiles_Id.'_'.$name;;
        $fileEntry->PPPPFiles_LocalUpload = 1;
        $fileEntry->save();
        return $prefix;
    }
    private function newFilesEntrySP ($ppid, $name, $type, $bemerkung, $skat, $ordnung, $splink = null, $link='', $linkName='', $ver=false, $isExtern = 0 ){
        //cpcDebug::cpc_debug("ppid: $ppid, name: $name, type: $type, bemerkung: $bemerkung, skat: $skat, ordnung: $ordnung, splink: $splink, link: $link, linkName: $linkName, ver: $ver", '!uploadFile');
        if ($ver){
            $this->versioningSPO($ppid, $name);
        }
        $skat = str_replace('_',' ',$skat);
        $files                             = new PPPPFiles();
        $files->PPPPFiles_PPProduktpass_Id = $ppid;
        $files->PPPPFiles_Name             = $name;
        $files->PPPPFiles_Type             = $type;
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description      = $bemerkung;
        $files->PPPPFiles_SubKat           = $skat;
        $files->PPPPFiles_Ordnung          = $ordnung;
        $files->PPPPFiles_Link             = $link;
        $files->PPPPFiles_LinkName         = $linkName;
        $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
        $files->PPPPFiles_IsExtern         = $isExtern;
        if (!$ver){
            $files->PPPPFiles_SharePointLink   = $splink;
        }
        $files->save();
        return $files;
    }
    private function getFilename ($name){
        $ret = str_replace('#','_', $name);
        $ret = str_replace('%','_', $ret);
        $ret = str_replace("'",'_', $ret);
        return $ret;
    }
    private function getIAN_Index($ppid){
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if ($pp){
                $ian = $pp->PPProduktpass_IAN;
                $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            return $ian.'_'.$ausm;
            }
        return '';
    }
    private function _uploadSPOAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern = 0){
        foreach($allfiles as $file){
            $fs = round($file->getSize()/1024/1024,2);
            if ($fs <= 1){
                //echo($file->getClientOriginalName()." Size: $fs Mb SPO<br>");
                //exit;
                $this->_uploadSPO($file, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern);
            } else {
                //echo($file->getClientOriginalName()." Size: $fs Mb Local<br>");
                $this->_uploadLocal($file, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern);
            }
        }
    }
    private function _uploadSPO ($file, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern){
                $filename = $this->getFilename($file->getClientOriginalName());
                $ianIndex = $this->getIAN_Index($ppid);
                $splink = null;
                $f = $this->newFilesEntrySP($ppid, $filename, $type, $bemerkung, $skat, $ordnung, $splink,'','', $versioning );
                $spo = new Office365Controller();
                $splink = $spo->Upload2SharePoint($ianIndex, $file);
                $f->PPPPFiles_SharePointLink = $splink;
                $f->save();
    }
    private function _uploadLocalAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern){
        foreach($allfiles as $file){
            $this->_uploadLocal ($file, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern);
        }
    }    
    private function _uploadLocal ($file, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern){
            $filename = $this->getFilename($file->getClientOriginalName());
            $ianIndex = $this->getIAN_Index($ppid);
            //$prefix = '-4711-';
            //$spo = new Office365Controller();
            //$splink = $spo->Upload2SharePoint($ianIndex, $file);
            $fid = $this->newFilesEntrySPLocal($ppid, $filename, $type, $bemerkung, $skat, $ordnung,'','','', $versioning, $isExtern );
            $destinationPath = public_path() . '/data/uploads/';
            //$destinationPath = '/var/www/targa/public/data/tmp/test/';
            $upload_success  = $file->move($destinationPath, $fid.'_'.$filename);
    }    
    public function existFilesSharepoint() {
        $val = false;
        $fns = Input::get('files');
        $ppid = Input::get('ppid');
        $allfiles = $fns;
        $ret = array();
        $ret2 = array();
        $i = 0;
        foreach($allfiles as $fn){
            $f_exists = PPPPFiles::where('PPPPFiles_Name', $fn)->where('PPPPFiles_PPProduktpass_Id', $ppid)->get()->first();
            if ($f_exists){
                $val = true;
                $ret[$i] = $fn;
                $ret2[$i] = array('Kat'=> $f_exists->PPPPFiles_Type, 'SubKat' => $f_exists->PPPPFiles_SubKat);
                $i++;
            }
        }
        return json_encode(array('ReturnValue'=> $val, "FilesExists" => $ret, 'Kats' => $ret2));
    }
    public function uploadFilesSharepoint() {
        //echo('<pre>');print_r(Input::all());exit;
            $skat = "Allgemein";
            if (Input::has('Kategorie')) {
                if (strlen($skat) > 2) {
                    $skat = str_replace(" ", "_", Input::get('Kategorie'));
                }
            }
            $ordnung   = Input::get('Ordnung');
            $type   = Input::get('filetype');
            $bemerkung = Input::get('bemerkung');
            $_ppid = Input::get('ppid');
            $pp = $this->getAktPP($_ppid);
            $ppid = $pp->PPProduktpass_Id;
            $_ver = Input::get('versioning');
            $versioning = false;
            if ($_ver == 2){
                $versioning = true;
            }
            cpcDebug::cpc_debug("O: $ordnung T: $type B: $bemerkung PPID: $ppid  V: $versioning",'!uploadFile');
            $link = '';
            $linkname = '';
            if (Input::has('link') and Input::get('link') != ""){
                $link = Input::get('link');
                $linkname = Input::get('linkName');
                $this->newFilesEntrySP ($ppid, 'Link', $type, $bemerkung, $skat, $ordnung, null, $link, $linkname, $versioning );
                return Redirect::to($this->getActiveTab() );
            }
            $allfiles            = Input::file('file');
            //cpcDebug::cpc_debug($allfiles,'@T18');
            $isExtern = 0;
            if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
                $isExtern = 1;
            }
            if (count($allfiles) < 10){
                $this->_uploadSPOAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern);
            } else {
                $this->_uploadLocalAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern);
            }
        return Redirect::to($this->getActiveTab() );
    }
    public function uploadFilesTermine() {
        /*
          echo('<pre>');
          var_dump(Input::all());
          echo('</pre>');
          exit; */
        $inputall = Input::all();
        foreach ($inputall as $key => $inp) {
            $len = strlen($key);
            if ($len > 4 and substr($key, 0, 4) == "ppid") {
                $tid = substr($key, 5, $len - 1);
            }
        }
        cpcDebug::cpc_debug($inputall);
        $id = Input::get("ppid_$tid");
        $filetype       = Input::get("filetype_$tid");
        $file           = Input::file("file_$tid");
        $skat           = Input::get("Kategorie_$tid");
        $bemerkung      = Input::get("bemerkung_$tid");
        $subTabName     = Input::get('hiddenActivsubTabName_' . $tid);
        $subTabIndex    = Input::get('hiddenActivsubTabIndex_' . $tid);
        $subsubTabIndex = Input::get('hiddenActivsubsubTabIndex_' . $tid);
        /*
          echo($id . "<br>");
          echo($filetype . "<br>");
          echo($file . "<br>");
          echo($skat . "<br>");
          echo($bemerkung . "<br>");
          echo($subTabName . "<br>");
          echo($subTabIndex . "<br>");
          echo($subsubTabIndex . "<br>");
          exit;
         */
        if ($filetype == 'Bilder Textbausteine') {
            $destinationPath = public_path() . '/data/uploads/BilderTextbausteine/';
            $filename       = $file->getClientOriginalName();
            $upload_success = $file->move($destinationPath, $filename);
            return Redirect::to('/show/' . $id . '#tabs-6');
        }
        //return Response::json(array('success' => true, 'error' => $inputall));
        //cpcDebug::cpc_debug("  Upload Files: ".print_r($inputall,true),"FKEUPL99");
        $destinationPath = public_path() . '/data/uploads/';
        $filename        = str_random(6) . "_" . $file->getClientOriginalName();
        $upload_success  = $file->move($destinationPath, $filename);
        $files                             = new PPPPFiles();
        $files->PPPPFiles_Name             = $filename;
        $files->PPPPFiles_PPProduktpass_Id = $id;
        $files->PPPPFiles_Type             = $filetype;
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description      = $bemerkung;
        $files->PPPPFiles_SubKat           = $skat;
        $files->PPPPFiles_UserCreate       = Auth::getUser()->id;
        $files->save();
        $tabs = json_encode(array("ppid"           => $id, "mainTab"        => '6',
            "subTabName"     => $subTabName,
            "subTabIndex"    => $subTabIndex, "subsubTabIndex" => $subsubTabIndex));
        //$link = "/showAfterUpload/$id/2/$subTabName/$subTabIndex/$subsubTabIndex";
        $link = "/show/$id";
        return Redirect::to($link);
    }
    public function deleteFiles($id) {
        $file = PPPPFiles::find($id);
        //File::delete(public_path() . '/data/' . $file->PPPPFiles_Pfad . '/' . $file->PPPPFiles_Name);
        $file->PPPPFiles_Status = 0;
        $file->PPPPFiles_UserDelete = Auth::getUser()->id;        
        $file->save();
        return Redirect::to($this->getActiveTab());
    }
    public function setProjectPic() {
        $ppid                            = Input::get('ppid');
        $pic                           = Input::get('pppic');
        $pp                            = tPPProduktpass::find($ppid);
        $pp->PPProduktpass_ProjektBild = $pic;
        $pp->save();
        return Redirect::to($this->getActiveTab());
    }
    public function updateRemarkFiles() {
        $fileid                        = Input::get('fileid');
        $newRemark                     = Input::get('TA');
        $ordnung                       = Input::get('OrdnungSub');
        $ppfile                        = PPPPFiles::find($fileid);
        $ppfile->PPPPFiles_Description = $newRemark;
        $ppfile->PPPPFiles_Ordnung = $ordnung; 
        $ppfile->save();
        return Redirect::to($this->getActiveTab());
    }
    function getActiveTab ($compactView=false){
        $ppid           = Input::get('ppid');  
        $subTabName     = Input::get('ActivsubTabName');
        if (strlen(trim($subTabName)) == 0){
            $subTabName = 0;
        }
        $subTabIndex    = Input::get('ActivsubTabIndex');
        $subsubTabIndex = Input::get('ActivsubsubTabIndex');
        //echo("ID: $ppid SubTabName: $subTabName  SubTabIndex: $subTabIndex SubsubTabIndex: $subsubTabIndex");
        //exit;
        //http://targa.twoffice.de/showAfterUpload/2115/6/TC/4/5
        if ($compactView){
            return '/showAfterUpload/' . $ppid . '/6/'.$subTabName.'/'.$subTabIndex .'/'.$subsubTabIndex."/1" ;
        }
     return '/showAfterUpload/' . $ppid . '/6/'.$subTabName.'/'.$subTabIndex .'/'.$subsubTabIndex ;
    }
    public function UpdateFilesCompact (){
        $action                        = Input::get('btn'); 
        $fileid                        = Input::get('fileid');
        $newRemark                     = Input::get('TA');
        $ordnung                       = Input::get('OrdnungSub');
        switch ($action) {
            case 'speichern':
                $file                        = PPPPFiles::find($fileid);
                $file->PPPPFiles_Description = $newRemark;
                $file->PPPPFiles_Ordnung     = $ordnung; 
                $file->save();
                break;
            case 'löschen':
                $file                       = PPPPFiles::find($fileid);
                $file->PPPPFiles_Status     = 0;
                $file->PPPPFiles_UserDelete = Auth::getUser()->id;        
                $file->save();
                break;
            default:
                # code...
                break;
        }
        return Redirect::to($this->getActiveTab(true));
    }
    private function filesCount($ppid){
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Status', 1)->whereNull('PPPPFiles_SharePointLink')->count();
        if ($files){
            return $files;
        }
        return 0;
    }
    public function upload2Sharepoint (){
        $ppid = Input::get('ppid');
        //echo("PPId: $ppid"); exit;
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Status', 1)->whereNull('PPPPFiles_SharePointLink')->orderBy('PPPPFiles_Date')->get();
        if ($files){
            foreach ($files as $file){
                //echo("PPId:". $file->PPPPFiles_PPProduktpass_Id ."<br>Id: ". $file->PPPPFiles_Id."<br>Date: ". $file->PPPPFiles_Date."<br>Type: ". $file->PPPPFiles_Type ."<br>SubKat: ". $file->PPPPFiles_SubKat ."<br>Ordnung: ". $file->PPPPFiles_Ordnung ."<br>Filename: " . $file->PPPPFiles_Name . '<br>---------------------------------------------<br>');
                $this->_upload2Sharepoint($file);
            }
            $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
            if ($pp){
                if ($this->filesCount($ppid) == 0){
                    $pp->PPProduktpass_Transferd2Sharepoint = 1;
                    $pp->save();
                }
            }
        } else {
            //echo('No files');
        }
        //return Redirect::to('/showAfterUpload/' . $ppid . "/2");
        return Redirect::to('/show/' . $ppid );
    }
    private  function _upload2Sharepoint ($file){
        //echo($ppid);exit;
        $ppid   = $file->PPPPFiles_PPProduktpass_Id;
        $isExtern = $file->PPPPFiles_IsExtern;
        //echo(PHP_EOL.'1#');
        //$fn     = $file->PPPPFiles_Name;
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (!$pp){
            //echo('XX1# (kein PP):'.$ppid.PHP_EOL);
            $file->PPPPFiles_Status = 999;
            $file->save();
            return false;
        }
        //echo('2#');
        $ian = $pp->PPProduktpass_IAN;
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $path = public_path('data/'.$file->PPPPFiles_Pfad.'/');
        //$path='/var/www/targa/public/data/'.$file->PPPPFiles_Pfad.'/';
        $filename = trim($file->PPPPFiles_Name);
        $fullFilepath = $path.$filename;
        $link = null;
        //echo('3#');
        if (file_exists($fullFilepath)){
            //echo('4#');
            $oc = new Office365Controller;
            try{
                //echo('5#');
                $link = $oc->uploadFromTPT($ian.'_'.$ausm, $fullFilepath, $isExtern);
                //echo('5succ#'.$link.PHP_EOL);
            }
            catch (Exception $ex){
                 //echo('5# Fail#');
                $file->PPPPFiles_Status = 3;
                $file->PPPPFiles_SharePointLink = null;
                $file->PPPPFiles_LocalUpload = 0;
                $file->PPPPFiles_Size = filesize( $fullFilepath );
                $file->PPPPFiles_UploadException =  $ex->getMessage();
                $file->save();
                //exit;
                $link = null;
                return;
            }
            //echo('6#');
            if(!is_null($link) and substr($link,0,1)!='@'){
                //echo('7#');
                $file->PPPPFiles_SharePointLink = $link;
                $file->PPPPFiles_Size = filesize( $fullFilepath );
                $newFilename = $filename; 
                if (strlen($filename)> 6){
                    if (substr($filename,6,1) == '_' ){
                        $newFilename = substr($filename,7);
                    }
                }
                $file->PPPPFiles_TPTFilenameOld = $filename;
                $file->PPPPFiles_Name = $newFilename; 
                $file->PPPPFiles_LocalUpload = 0;
                $file->save();
            } else {
                //echo('8#');
                //$file->PPPPFiles_LocalUpload = 0;
                //$file->PPPPFiles_Name = $filename;
                $file->PPPPFiles_Status = 5;
                $file->PPPPFiles_UploadException =  'Exc: '.$link;
                $file->PPPPFiles_SharePointLink = null;
                $file->PPPPFiles_Size = filesize( $fullFilepath );
                $file->PPPPFiles_LocalUpload = 1;
                $file->save();
            }
        } else {
            //echo('9#');
            $file->PPPPFiles_Status = 99;
            $file->save();
        }
        //echo('10#'.PHP_EOL);
        //return Redirect::to('/showAfterUpload/' . $ppid . "/2");        
    }
    private function marcLocal (){
        $max = 12;
        $filesFound = false;
        while (!$filesFound){
            $pp = tPPProduktpass::where('PPProduktpass_IAN','not like', '%rev%')->whereNull('PPProduktpass_Transferd2Sharepoint')->orderBy('PPProduktpass_IAN')->get()->first();
            if ($pp){
                echo("   marcLocal IAN: ".$pp->PPProduktpass_IAN.'  #'.$pp->PPProduktpass_Id.PHP_EOL);
                $ppid = $pp->PPProduktpass_Id;
                if ($this->filesCount($ppid) > 0){
                    $filesFound = true;
                } else {
                    $pp->PPProduktpass_Transferd2Sharepoint = 1;
                    $pp->save();
                    echo("   Is on SPO".PHP_EOL);
                }
            } else {
                exit;
            }
        }
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id',$ppid)->whereNull('PPPPFiles_SharePointLink')->where('PPPPFiles_Status', '1')->orderBy('PPPPFiles_PPProduktpass_Id')->orderBy('PPPPFiles_Date')->get();
        if ($files){
            $i =0;
            foreach ($files as $file){
                $i++;
                if ($i <= $max){
                    $file->PPPPFiles_LocalUpload = 1;
                    echo("  $i .) marcLocal File# ".$file->PPPPFiles_Id.": "  . $file->PPPPFiles_Name . PHP_EOL);
                    $file->save();
                }
            }
        }
    }
    public function moveLocal2Spo(){
        ini_set('max_execution_time', 0);
        echo("Start der Übertragung: "  . date('d.m.Y H:i:s') . PHP_EOL);
        //echo("Pause".PHP_EOL);
        //exit;
        //$this->marcLocal();
        $files = PPPPFiles::where('PPPPFiles_LocalUpload',1)->where('PPPPFiles_Status',1)->orderBy('PPPPFiles_Date')->get();
        //$srcdir = public_path('data/uploads/');
        foreach($files as $file){
            $devSrc =  public_path('data/');
            //$prodSrc =  '/var/www/targa/public/data';
            $srcdir=$devSrc.$file->PPPPFiles_Pfad.'/';
            $fn = $srcdir.$file->PPPPFiles_Name;
            echo("    ".$srcdir.$file->PPPPFiles_Name ." [] ");
            if (file_exists($fn)){
                $fs = round(filesize($fn) /1024/1024,0).'MB';
                echo( ' [Filesize] : '.$fs.' => ');
                $this->_upload2Sharepoint($file);
                $ppid = $file->PPPPFiles_PPProduktpass_Id;
                echo('['.$file->PPPPFiles_Type.' / '. $file->PPPPFiles_SubKat.' Id:'. $file->PPPPFiles_Id.'] OK'.PHP_EOL);
                $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
                if ($pp){
                    if ($this->filesCount($ppid) == 0){
                        $pp->PPProduktpass_Transferd2Sharepoint = 1;
                        echo('    '.$pp->PPProduktpass_IAN.' ready'.PHP_EOL);
                        $pp->save();
                    }
                }
            } else {
                $file->PPPPFiles_Status = 3;
                $file->save();
                echo('File not Found'.PHP_EOL);
            } 
        }
        /*echo("<div style='border:2px solid orange;padding:10px;width:50%;'>");
        //$link = 'https://targagmbh.sharepoint.com/:i:/s/TPTStorage/EYyho3zUVrNLp6_VLIs1FnQBAzvuuB9F-sXW7gc_wg1S6w?e=XDDUc5';
        $link = 'https://targagmbh.sharepoint.com/sites/TPTStorage/Freigegebene%20Dokumente/IANs/999999_9901/2013-01-25T20-36-08.jpg';
        echo("<a href='$link'>");
        echo("<img src='$link' style='width:80%;'>");
        echo('</a>');
        echo('</div>');*/
        echo("Übertragung fertig:  " . date('d.m.Y H:i:s') . PHP_EOL);
        //echo("<div style='border:2px solid orange;padding:10px;width:50%;'>Übertragung fertig!</div>");
        exit;
    }
    private function getNewFileVersion($ppid, $fn){
        $newFile = $fn;
        $name = pathinfo($fn, PATHINFO_FILENAME);
        $_ext = pathinfo($fn,PATHINFO_EXTENSION);
        cpcDebug::cpc_debug("getNewFileVersion: $fn $name $_ext  ", '!uploadFile');
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Name','like', $name.'_Vx%')->orderBy('PPPPFiles_Date', 'DESC')->get()->first();
        if ($files){
            $_f = $files->PPPPFiles_Name;
            $_fn = pathinfo($_f,PATHINFO_FILENAME);
            $v = substr($_fn, -3);
            $v +=0;
            $v++;
            $version = str_pad($v, 3, 0, STR_PAD_LEFT);
            $newFile = $name.'_Vx'.$version.'.'.$_ext;
        } else {
            $newFile = $name.'_Vx001.'.$_ext;
        }
        return $newFile;
    }
    private function versioningSPO($ppid, $fn){
        $pp = tPPProduktpass::find($ppid);
        if (!$pp){
            die("Versionierungsfehler bei Produktpass Id: $ppid");
        }
        $file = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Name','like', $fn)->orderBy('PPPPFiles_Name', 'DESC')->orderBy('PPPPFiles_Date', 'DESC')->get()->first();
        if ($file){
            $newName = $this->getNewFileVersion($ppid,$fn);
            $file->PPPPFiles_Name = $newName;
            $spoLink = $file->PPPPFiles_SharePointLink;
            $expl = explode('?',$spoLink);
            $newLink = $newName.'?'.$expl[1];
            $file->PPPPFiles_SharePointLink = $newLink;
            $file->save(); 
            $oc = new Office365Controller();
            $ian = $pp->PPProduktpass_IAN;
            $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            $oc->versioningFile($ian, $ausm, $fn, $newName);
            cpcDebug::cpc_debug($file->PPPPFiles_Id."NewName = $newName PPId: $ppid File: $fn", '!uploadFile');
        }
    }
    public function getFormUploadPruefplaene()
    {
        $data['content'] = View::make('UploadForms.UploadPruefplaene');
        return View::make('main', $data);
    }
    public function uploadMassenPruefplaene (){
        $pruefplaene = Input::file('MultiPdf');
        $destinationPath = public_path() . '/data/uploads/';
        $result = array();
        if (Auth::user()->PPMitarbeiter_Kuerzel == 'FKE'){
        dd(
            ini_get('upload_max_filesize'),
                ini_get('post_max_size'),
                ini_get('max_file_uploads'),
                count(Input::file('MultiPdf'))
            );
            exit;
        }
        foreach ($pruefplaene as $file){
            $fn = $file->getClientOriginalName();
            $ian = substr($fn,0,6);
            $ausm = substr($fn,7,4);
            //echo("$ian $ausm");
            $pp = tPPProduktpass::where('PPProduktpass_IAN', $ian)->where('PPProduktpass_Ausmusterungnummer','like', $ausm.'%')->get()->first();
            if ($pp){
                $ppid = $pp->PPProduktpass_Id;
                $result[] = array('Link' => ViewController::getFileTabLink($ppid, 'PPUpload', 'PDFs'),'Filename' => $fn,'Status' => 'OK', 'Color' => 'black');
                $filename        = str_random(6) . "_" . $file->getClientOriginalName();
                $upload_success  = $file->move($destinationPath, $filename);
                $this->newFilesEntry($filename, $pp->PPProduktpass_Id, 'PPUpload', 'Massenupload', 'uploads', 'PDFs');
            } else {
                $result[] = array('Link' => false,'Filename' => $fn,'Status' => 'Produktpass nicht gefunden!', 'Color' => 'red');
            }
        }
        $data['content'] = View::make('UploadForms.successUploadPruefplaene')->with('result',$result);
        return View::make('main', $data);
    }
    private function getAktPP($ppid){
        $pp = tPPProduktpass::where('PPProduktpass_Id', $ppid)->get()->first();
        if (!$pp){
            echo('Kein Produktpass gefunden');
            exit;
        }
        if (strpos($pp->PPProduktpass_IAN,'ev') === false){
            return $pp;
        }
        //das ist nicht der aktuelle pp
        $ian = substr($pp->PPProduktpass_IAN,0,6);
        $ausm = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
        $pp =  tPPProduktpass::where('PPProduktpass_IAN','=', $ian)->where('PPProduktpass_Ausmusterungnummer','like', "$ausm%")->get()->first();
        if ($pp){
            return $pp;
        }
        exit;
    }
    public function uploadFilesNew(){
        cpcDebug::cpc_debug('uploadFilesNew', '@ExUTFProd8');
        $arrayFiles = $_FILES;
         $skat = "Allgemein";
         if (Input::has('kat')) {
             if (strlen($skat) > 2) {
                 $skat = str_replace(" ", "_", Input::get('kat'));
             }
         }
         $isExtern = Input::get('isExtern');;
         if (strpos(Auth::user()->PPMitarbeiter_Role,'INTERN') === false ){
             $isExtern = 1;
         }
         $ordnung   = Input::get('ord');
         $type   = Input::get('type');
         $bemerkung = Input::get('bemerkung');
         $_ppid = Input::get('ppid');
         $pp = $this->getAktPP($_ppid);
         $ppid = $pp->PPProduktpass_Id;
         $_ver = Input::get('versioning');
         $versioning = false;
         if ($_ver == 2){
             $versioning = true;
         }
         $allfiles = array();
         $i=0;
         foreach($arrayFiles  as $fname => $uplFile){
            $f = Input::file($fname);
            $allfiles[$i++] = $f;
            cpcDebug::cpc_debug($f->getClientOriginalName(), '@ExUTFProd8');
         }
         /* if (count($allfiles) < 10){
            $this->_uploadSPOAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning);
         } else {
            $this->_uploadLocalAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning);
         } */
        $this->_uploadLocalAll ($allfiles, $ppid, $type, $bemerkung, $skat, $ordnung, $versioning, $isExtern);
        $ian = new IANController();
        $view =  $ian->getDataDateien($ppid,true, $skat); 
        $link = '';
        $linkname = '';
        if (Input::has('link') and Input::get('link') != ""){
            $link = Input::get('link');
            $linkname = Input::get('linkName');
            $this->newFilesEntrySP ($ppid, 'Link', $type, $bemerkung, $skat, $ordnung, null, $link, $linkname, $versioning, $isExtern );
            return Response::json(['view' => $view['view'], 'kat' => $view['kat']]);
        }
        try{
            //$v = mb_convert_encoding($view['view'], 'UTF-8', 'auto');
            //$v = json_encode($view['view'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            //cpcDebug::cpc_debugFile($view['view'] , '@ViewFile');
            $v = $view['view'];
            if (!mb_check_encoding($v, 'UTF-8')) {
               cpcDebug::cpc_debug('Fehler in uploadFilesNew: NICHT UTF8', '@ExUTFProd8');
               $v =  mb_convert_encoding($view['view'], 'UTF-8', 'Windows-1252');
            } else {
                cpcDebug::cpc_debug('uploadFilesNew: UTF8-codiert', '@ExUTFProd8');
            }
            $response =  Response::json(['view' =>  $v, 'kat' => $view['kat']]);
            if ($response instanceof \Illuminate\Http\JsonResponse) {
               return $response; 
            } 
        }
        catch (\Exception $e) {
            cpcDebug::cpc_debug('Fehler in uploadFilesNew: '.$e->getMessage(), '@ExUTFProd8');
            cpcDebug::cpc_debugFile($view['view'] , 'ViewFile');
            return Response::json(['view' => '<div style="padding:20px;"><h3>Warnung beim Upload. Ich arbeite mit Hochdruck daran<br> Die Datei(en) wurde(n) korrekt hochgeladen, die Aktualisierung der Seite schlägt jedoch leider fehl.</h3></div>', 'kat' => $view['kat']]);
        }
        cpcDebug::cpc_debug('?. uploadFilesNew: NO Response' , '@ExUTFProd8');
        return Response::json(['view' => '<h3>FEHLER</h3>', 'kat' => $view['kat']]);
    }
    public function refreshFileTab (){
        $ppid = Input::get('ppid');
        $skat = Input::get('kat');
        $ian = new IANController();
        $view =  $ian->getDataDateien($ppid,true, $skat); 
        //cpcDebug::cpc_debug($view, '@AAAA');        
        return Response::json( array('view' => $view['view'], 'kat' => $view['kat']));
    }
    public function updateRemarkFilesAjax() {
        $fileid                        = Input::get('fileid');
        $newRemark                     = Input::get('remark');
        $ordnung                       = Input::get('OrdnungSub');
        $ppfile                        = PPPPFiles::find($fileid);
        $ppfile->PPPPFiles_Description = $newRemark;
        $ppfile->PPPPFiles_Ordnung = $ordnung; 
        $ppfile->save();
        return json_encode(array('Result' => 'OK', 'message' => 'Daten in Ordnung!'));
    }
    public function deleteFileNeu() {
        $fileid = Input::get('fileid');
        $file = PPPPFiles::find($fileid);
        $this->deleteFilesSameName ($file->PPPPFiles_PPProduktpass_Id, $file->PPPPFiles_Name);
        //return Redirect::to('/showNeu/'.$ppid);
        return json_encode(array('result' => 'OK', 'message' => 'file deleted'));
    }
    public function updateProjektPicAjax() {
        $fileid   = Input::get('fileid');
        $ppid     = Input::get('ppid');
        $pp = tPPProduktpass::find($ppid);
        if (!$pp){
            return json_encode(array('Result' => 'ERROR', 'message' => 'Kein Produktpass gefunden!'));
}
        $file = PPPPFiles::find($fileid);
        if (!$file){
            return json_encode(array('Result' => 'ERROR', 'message' => 'Keine Datei gefunden!'));
        }
        $pp->PPProduktpass_ProjektBild = $file->PPPPFiles_TPTFilenameOld;
        $pp->save();  
        cpcDebug::cpc_debug("updateProjektPicAjax FileId: $fileid PPId: $ppid", '@AjaxCalls');
        return json_encode(array('Result' => 'OK', 'message' => 'Projektbild getauscht!'));
    }
    private function deleteFilesSameName ($ppid, $fn){
        $files = PPPPFiles::where('PPPPFiles_PPProduktpass_Id', $ppid)->where('PPPPFiles_Name','like', trim($fn))->get();
        if ($files){
            foreach ($files as $file){
                cpcDebug::cpc_debug("   deleteFilesSameName Deleting FileId: ".$file->PPPPFiles_Id." Name: ".$file->PPPPFiles_Name, '@uploadFile');
                $file->PPPPFiles_Status = 0;
                $file->PPPPFiles_UserDelete = Auth::getUser()->PPMitarbeiter_Id;
                $file->save();
            }
        }   
    }
    public function uploadMassenPruefplaeneBatch()
    {
        // Erwartet MultiPdf[] (Batch kommt vom JS)
        $pruefplaene = Input::file('MultiPdf');
        // Normalisieren (manchmal kommt eine einzelne Datei nicht als Array)
        if (!$pruefplaene) {
            return Response::json([
                'ok' => false,
                'message' => 'Keine Dateien empfangen.',
                'result' => [],
            ], 400);
        }
        if (!is_array($pruefplaene)) {
            $pruefplaene = [$pruefplaene];
        }
        $destinationPath = public_path() . '/data/uploads/';
        $result = [];
        foreach ($pruefplaene as $file) {
            if (!$file || !$file->isValid()) {
                $result[] = [
                    'Link' => false,
                    'Filename' => $file ? $file->getClientOriginalName() : '(unbekannt)',
                    'Status' => 'Upload fehlerhaft/abgebrochen',
                    'Color' => 'red',
                ];
                continue;
            }
            $fn = $file->getClientOriginalName();
            // Optional: nur PDFs zulassen (bei Ordnerauswahl kommen sonst auch andere Dateien)
            if (strtolower(substr($fn, -4)) !== '.pdf') {
                $result[] = [
                    'Link' => false,
                    'Filename' => $fn,
                    'Status' => 'Übersprungen (keine PDF)',
                    'Color' => 'red',
                ];
                continue;
            }
            $ian  = substr($fn, 0, 6);
            $ausm = substr($fn, 7, 4);
            $pp = tPPProduktpass::where('PPProduktpass_IAN', $ian)
                ->where('PPProduktpass_Ausmusterungnummer', 'like', $ausm . '%')
                ->first();
            if (!$pp) {
                $result[] = [
                    'Link' => false,
                    'Filename' => $fn,
                    'Status' => 'Produktpass nicht gefunden!',
                    'Color' => 'red',
                ];
                continue;
            }
            $ppid = $pp->PPProduktpass_Id;
            $storedName = str_random(6) . "_" . $fn;
            try {
                $file->move($destinationPath, $storedName);
                $this->newFilesEntry(
                    $storedName,
                    $ppid,
                    'PPUpload',
                    'Massenupload',
                    'uploads',
                    'PDFs'
                );
                $result[] = [
                    'Link' => ViewController::getFileTabLink($ppid, 'PPUpload', 'PDFs'),
                    'Filename' => $fn,
                    'Status' => 'OK',
                    'Color' => 'black',
                ];
            } catch (\Exception $e) {
                $result[] = [
                    'Link' => false,
                    'Filename' => $fn,
                    'Status' => 'Speichern fehlgeschlagen: ' . $e->getMessage(),
                    'Color' => 'red',
                ];
            }
        }
        // Variante 3: IMMER JSON zurückgeben
        return Response::json([
            'ok' => true,
            'result' => $result,
        ]);
    }
}