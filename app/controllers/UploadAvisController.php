<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadAvisController extends BaseController {
    function importAvis($file) {


        //dd($file);
        $inputFileName = $file;

        if (!file_exists($inputFileName)) {
            echo($inputFileName . " existiert nicht auf dem Server!<br>");
            cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
        }

        $dataHeader = array(
            'IAN'             => 'C1',
            'Date'            => 'C3',
            'Voyage'          => 'C8',
            'OceanVessel'     => 'C3',
            'POL'             => 'C11',
            'ATD'             => 'C12',
            'POD'             => 'C13',
            'ETA'             => 'C14',
            'CountryOfOrigin' => 'I6',
            'ShippingWeek'    => 'G12',
            'TarifCode'       => 'L5',
            'Remarks'         => 'L8'
        );

        $dataPosition = array(
            'ContainerSize'   => 'A',
            'ContainerNo'     => 'B',
            'ContainerSealNo' => 'C',
            'CB'              => 'D',
            'SubInfo'         => 'E',
            'ParcelCount'     => 'F',
            'VE'              => 'G',
            'ParcelGross'     => 'I',
            'ParcelNet'       => 'J',
            'ParcelDepth'     => 'K',
            'ParcelWidth'     => 'L',
            'ParcelHeight'    => 'M'
        );

        $posStart = 18;

        $spreadSheet = IOFactory::load($inputFileName);
        $workSheet   = $spreadSheet->getActiveSheet();

        $testIAN = $workSheet->getCell("C1")->getCalculatedValue();
        if (!is_numeric($testIAN)) {
            echo("$inputFileName nicht importiert!");
            return;
        }

        if ($testIAN < 100000 or $testIAN > 1000000) {
            echo("$inputFileName nicht importiert!<br>");
            return;
        }

        $avisKopf = new AvisKopf();

        foreach ($dataHeader as $attr => $cell) {
            $attribute = 'AvisKopf_' . $attr;

            $dVal = $workSheet->getCell($cell)->getCalculatedValue();
            //if (PHPExcel_Shared_Date::isDateTime($workSheet->getCell($cell))) {

            if (is_numeric($dVal)) {
                if ($dVal > 40000 and $dVal < 100000) {
                    $dVal = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($dVal));
                }
            }


//}
            //$avisKopf->{$attribute} = $workSheet->getCell($cell)->getCalculatedValue();
            $avisKopf->{$attribute} = $dVal;
            //echo("$attr   =>  " . $dVal . " <br> ");
        }

        $avisKopf->AvisKopf_IstAktiv   = 1;
        $avisKopf->AvisKopf_ImportDate = date('Y-m-d H:i:s');
        $avisKopf->AvisKopf_File       = $file;
        $avisKopf->save();

        $id = $avisKopf->AvisKopf_Id;
        $pp = PPProduktpass::where('PPProduktpass_IAN', $avisKopf->AvisKopf_IAN)->get()->first();

        $row = $posStart - 1;
        while (true) {
            $row++;
            $contNo = $workSheet->getCell($dataPosition['ContainerNo'] . $row)->getCalculatedValue();
            if (trim($contNo) == "") {
                break;
            }
            $avisPos                            = new AvisPositionen();
            $avisPos->AvisPositionen_AvisKopfId = $id;

            foreach ($dataPosition as $attr => $cell) {

                $attribute             = 'AvisPositionen_' . $attr;
                $avisPos->{$attribute} = $workSheet->getCell($cell . $row)->getCalculatedValue();
                //echo("$attr   =>  ".$workSheet->getCell($cell.$row)->getValue()."     ");
            }

            $avisPos->save();

            //echo("<br>");
        }


        if ($pp) {
            return $pp->PPProduktpass_Id;
        }
        return false;
    }

    private function newFilesEntryAvis($filename, $ppid) {

        $files                             = new PPPPFiles();
        $files->PPPPFiles_Name             = $filename;
        $files->PPPPFiles_PPProduktpass_Id = $ppid;
        $files->PPPPFiles_Type             = "PPUpload";
        $files->PPPPFiles_Date             = date("Y-m-d H:i:s");
        $files->PPPPFiles_Description      = "Shipping Avis";
        $files->PPPPFiles_Pfad             = 'Avis';
        $files->PPPPFiles_SubKat           = 'Avis';
        $files->save();
//echo("<pre>");var_dump($files);echo("</pre><br>");
    }

    public function uploadAvisCLI() {

        $ts     = new DateTime();
        $prefix = $ts->getTimestamp();

        $uploaddir = public_path() . "/data/Avis/";
        /* $filename   = $prefix . basename($_FILES['file']['name']);
          $uploadfile = $uploaddir . $filename;
          if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
          $id = $this->importAvis($uploadfile);

          if ($id) {
          $this->newFilesEntryAvis($filename, $id);
          $data['message'] = "<b>Die Datei wurde erfolgreich importiert!<b><br><br><a href='showAfterUpload/" . $id . "/14'>Link zum Produktpass</a><br><br>";
          }
          else {
          $data['message'] = "<b>Die Datei wurde importiert!<b><br>IAN Konnte aber nicht zugeordnet werden!!<br><br>";
          }
          $data['content'] = View::make('UploadAvis')->with('data', $data);
          return View::make('main', $data);
          }
          else {
          echo("Nicht hochgeladen!");
          }
         */


        $AvisDir = storage_path("data/AvisImport/Income/2022/");
        $SaveDir = storage_path("data/AvisImport/Income/2022/Save/");

        $files = scandir($AvisDir);
        foreach ($files as $file) {

            //if ($file != "." and $file != ".." and $file != "Save") {
            if (strpos($file, "xls") !== false) {
                $fullFileName = $AvisDir . $file;
                $id           = $this->importAvis($fullFileName);

                if ($id) {
                    $this->newFilesEntryAvis($file, $id);
                }
            }
        }
    }

    public function uploadAvis() {

        $ts     = new DateTime();
        $prefix = $ts->getTimestamp();

        $uploaddir  = public_path() . "/data/Avis/";
        $filename   = $prefix . basename($_FILES['file']['name']);
        $uploadfile = $uploaddir . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $id = $this->importAvis($uploadfile);

            if ($id) {
                $this->newFilesEntryAvis($filename, $id);
                $data['message'] = "<b>Die Datei wurde erfolgreich importiert!<b><br><br><a href='showAfterUpload/" . $id . "/14'>Link zum Produktpass</a><br><br>";
            }
            else {
                $data['message'] = "<b>Die Datei wurde importiert!<b><br>IAN Konnte aber nicht zugeordnet werden!!<br><br>";
            }
            $data['content'] = View::make('UploadAvis')->with('data', $data);
            return View::make('main', $data);
        }
        else {
            echo("Nicht hochgeladen!");
        }
    }

    public function getUploadAvisForm() {
//

        $data['message'] = "Start";

        $data['content'] = View::make('UploadAvis')->with('data', $data);

        return View::make('main', $data);
    }

}
