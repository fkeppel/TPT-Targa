<?php

class InquiryController extends \BaseController {

    function readInquiry() {


        ini_set('memory_limit', '-1');

        $file = "InquirysheetTEST.xlsx";

        $inputFileName = public_path() . "/data/import/" . $file;

        if (!file_exists($inputFileName)) {
            cpcDebug::cpc_debug("	ERROR: " . $inputFileName . " existiert nicht!");
        }

        $inputFileType = 'Excel2007';

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(false);

        $objPHPExcel = $objReader->load($inputFileName);

        PHPExcel_Calculation::getInstance($objPHPExcel)->cyclicFormulaCount = 1;

        $sheet = $objPHPExcel->getSheetByName('322586');
        $cellxy = 'A5';
        $value = $sheet->getCell($cellxy)->getCalculatedValue();

        echo("Value: $value");
        exit;
    }

    private function getDownloadFilename($ian, $bez) {

        return $ian . "_" . preg_replace('/[^a-z0-9A-Z]+/', '-', $bez) . ".xlsx";
    }

    private function GetMaxDiffVersion($id) {

        //cpcDebug::dd("getMaxDiffVersion Id: $id");
        $dVersion = PPInquiryDiff::where("PPInquiryDiff_PPProduktpass_Id", "=", $id)
                ->orderBy('PPInquiryDiff_Version', 'DESC')
                ->get()
                ->first();


        // cpcDebug::cpc_debug(print_r($dVersion, true));

        if ($dVersion) {
            cpcDebug::cpc_debug("getDiffVersion: >" . $dVersion->PPInquiryDiff_Version . "<");
            return $dVersion->PPInquiryDiff_Version;
        }
        return 0;
    }

    private function getDiffData($ppid, $v1, $v2) {


        // cpcDebug::dd("getDiffData id: $ppid V1: $v1 V2:$v2");

        $xdiffs = DB::table('v_InquiryDiffs')
                ->where('PPInquiryDiff_PPProduktpass_Id', '=', $ppid)
                ->where('V1', '=', $v1)
                ->where('V2', '=', $v2)
                ->get();


        $diffs = array();
        foreach ($xdiffs as $value) {
            $diffs[] = ($value);
        }
        $diffx = array();

        foreach ($diffs as $value) {
            $diffx[] = (array) $value;
        }

        return $diffx;
    }

    public function getDiff($ppid) {

        $subData['Header'] = "DIFF Inquiries";
        $maxVersion = $this->GetMaxDiffVersion($ppid);

        $subData['Diffs'] = $this->getDiffData($ppid, $maxVersion - 1, $maxVersion);
        //cpcDebug::dd($diffx);
        $data['content'] = View::make('listen.inquiry_diff')->with('data', $subData);
        return View::make('main', $data);
    }

    public function listInquiry() {

        $inp = Input::all();



        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $subData['inp']['search_isbettwaesche'] = 0;
        $subData['inp']['search_isandere'] = 0;

        $search_ausmusterung = '';
        $search = '';
        $search_isbettwaesche = 0;
        $search_isandere = 0;
        $sortChoise = "Datum.D";
        if (isset($inp['IsPost'])) {


            $search = $inp['search'];
            $search_ausmusterung = $inp['search_ausmusterung'];

            if (isset($inp['sortChoise']) and ! is_null($inp['sortChoise'])) {
                //echo($inp['sortChoise']);exit;
                $sortChoise = $inp['sortChoise'];
            }

            $search_isbettwaesche = $inp['iIsBettwaesche'];
            $search_isandere = $inp['iIsAndere'];




            $sc = explode('.', $sortChoise);
            $attribute = $sc[0];
            $dir = "X";
            $sortatt = 'PPProduktpass_Import_Datum';
            $sortdir = 'desc';

            if (isset($sc[1])) {
                $dir = $sc[1];
            }
            if ($dir == "X" or $dir == "D") {
                $sortdir = 'asc';
            } else {
                $sortdir = 'desc';
            }
            if ($attribute == 'IAN') {
                $sortatt = 'PPProduktpass_IAN';
            }
            if ($attribute == 'Projekt') {
                $sortatt = 'PPProduktpass_PPProjekte_Projekt';
            }
            if ($attribute == 'Artikel') {
                $sortatt = 'PPProduktpass_Artikelbezeichnung';
            }
            if ($attribute == 'Ausmusterung') {
                $sortatt = 'PPProduktpass_Ausmusterungnummer';
            }
            if ($attribute == 'Datum') {
                $sortatt = 'PPProduktpass_Import_Datum';
            }
            if (($search_isandere and $search_isbettwaesche) or ( !$search_isandere and ! $search_isbettwaesche)) {
                $subData['Test'] = 1;
                $subData['inq'] = DB::table('PPInquiry')
                        ->where('PPProduktpass_Ausmusterungnummer', 'like', trim($search_ausmusterung) . "%")
                        ->where(function($query1) {
                            $query1->where('PPProduktpass_RevisionAktuell', "=", 0)
                            ->orwhereNull('PPProduktpass_RevisionVon_PPProduktpass_Id');
                        })
                        ->where(function($query) use ($search) {
                            $query->where('PPProduktpass_PPProjekte_Projekt', 'like', "%" . trim($search) . "%")
                            ->orwhere('PPProduktpass_IAN', '=', "" . trim($search) . "")
                            ->orwhere('PPProduktpass_Import_Datum', '=', trim($search))
                            ->orwhere('PPProduktpass_Artikelbezeichnung', 'like', "%" . trim($search) . "%");
                        })
                        ->orderBy($sortatt, $sortdir)
                        ->orderBy('PPProduktpass_IAN')
                        ->get();
            } else {
                if ($search_isandere) {
                    $subData['Test'] = 2;
                    $subData['inq'] = DB::table('PPInquiry')
                            ->where('PPProduktpass_InquiryArt', '=', "0")
                            ->where('PPProduktpass_Ausmusterungnummer', 'like', trim($search_ausmusterung) . "%")
                            ->where(function($query1) {
                                $query1->where('PPProduktpass_RevisionAktuell', "=", 0)
                                ->orwhereNull('PPProduktpass_RevisionVon_PPProduktpass_Id');
                            })
                            ->where(function($query) use ($search) {
                                $query->where('PPProduktpass_PPProjekte_Projekt', 'like', "%" . trim($search) . "%")
                                ->orwhere('PPProduktpass_IAN', 'like', "%" . trim($search) . "%")
                                ->orwhere('PPProduktpass_Import_Datum', '=', trim($search))
                                ->orwhere('PPProduktpass_Artikelbezeichnung', 'like', "%" . trim($search) . "%");
                            })
                            ->orderBy($sortatt, $sortdir)
                            ->orderBy('PPProduktpass_IAN')
                            ->get();
                } else {
                    $subData['Test'] = 3;
                    $subData['inq'] = DB::table('PPInquiry')
                            ->where('PPProduktpass_InquiryArt', 'like', "1")
                            ->where('PPProduktpass_Ausmusterungnummer', 'like', trim($search_ausmusterung) . "%")
                            ->where(function($query1) {
                                $query1->where('PPProduktpass_RevisionAktuell', "=", 0)
                                ->orwhereNull('PPProduktpass_RevisionVon_PPProduktpass_Id');
                            })
                            ->where(function($query) use ($search) {
                                $query->where('PPProduktpass_PPProjekte_Projekt', 'like', "%" . trim($search) . "%")
                                ->orwhere('PPProduktpass_IAN', 'like', "%" . trim($search) . "%")
                                ->orwhere('PPProduktpass_Import_Datum', '=', trim($search))
                                ->orwhere('PPProduktpass_Artikelbezeichnung', 'like', "%" . trim($search) . "%");
                            })
                            ->orderBy($sortatt, $sortdir)
                            ->orderBy('PPProduktpass_IAN')
                            ->get();
                }
            }
        } else {
            $subData['Test'] = 4;
            $subData['inq'] = DB::table('PPInquiry')
                    ->where('PPProduktpass_RevisionAktuell', "=", 0)
                    ->orwhereNull('PPProduktpass_RevisionVon_PPProduktpass_Id')
                    ->orderBy('PPProduktpass_Import_Datum', 'DESC')
                    ->orderBy('PPProduktpass_PPProjekte_Projekt', 'DESC')
                    ->get();
        }

        //echo("TEST: " . $subData['Test'] . "<br>"); // $sortatt $sortdir $search  $search_ausmusterung $search_isandere $search_isbettwaesche");



        $i = 0;
        $sInqs = array();

        $prj_minian = array();

        foreach ($subData['inq'] as $inq) {
            $sInqs[$i]['ppid'] = $inq->PPProduktpass_Id;
            $sInqs[$i]['IAN'] = $inq->PPProduktpass_IAN;
            $sInqs[$i]['Projekt'] = $inq->PPProduktpass_PPProjekte_Projekt;

            cpcDebug::cpc_debug("Projekt: " . $inq->PPProduktpass_PPProjekte_Projekt);
            if (strlen(trim($inq->PPProduktpass_PPProjekte_Projekt)) > 0) {
                if (!isset($prj_minian[$inq->PPProduktpass_PPProjekte_Projekt])) {
                    $prj_minian[$inq->PPProduktpass_PPProjekte_Projekt] = $inq->PPProduktpass_IAN;
                    cpcDebug::cpc_debug("eingetragen!");
                } else {
                    if ($prj_minian[$inq->PPProduktpass_PPProjekte_Projekt] > $inq->PPProduktpass_IAN) {
                        $prj_minian[$inq->PPProduktpass_PPProjekte_Projekt] = $inq->PPProduktpass_IAN;
                        cpcDebug::cpc_debug("überschrieben!");
                    }
                }
            }

            $sInqs[$i]['Bez'] = $inq->PPProduktpass_Artikelbezeichnung;
            $sInqs[$i]['IsBett'] = $inq->PPProduktpass_InquiryArt == 1 ? 1 : 0;
            $sInqs[$i]['Datum'] = $inq->PPProduktpass_Import_Datum;
            $sInqs[$i]['Ausmusterung'] = $inq->PPProduktpass_Ausmusterungnummer;
            $sInqs[$i]['MaxVersion'] = $this->GetMaxDiffVersion($inq->PPProduktpass_Id);


            $fn = "data/Inquiries/Inquiry_" . $inq->PPProduktpass_IAN . ".xlsx";
            if ($inq->PPProduktpass_InquiryArt == 1) {

                $fn = "data/Inquiries/InquiryBW_" . $inq->PPProduktpass_IAN . ".xlsx";
            }


            if (file_exists($fn)) {
                $dlfn = $fn;
                $name = $this->getDownloadFilename($sInqs[$i]['IAN'], $sInqs[$i]['Bez']);
                if ($inq->PPProduktpass_InquiryArt == 1) {
                    $name = $this->getDownloadFilename("BW_" . $sInqs[$i]['IAN'], $sInqs[$i]['Bez']);
                }
                $sInqs[$i]['file'] = $dlfn;
                $sInqs[$i]['name'] = $name;
                $sInqs[$i]['FileDatum'] = date("Y-m-d H:i:s", filemtime($fn));
            } else {
                $sInqs[$i]['file'] = "";
                $sInqs[$i]['name'] = "";
            }
            //exit;
            $i++;
        }


        //cpcDebug::cpc_debug(print_r($prj_minian, true));

        $display_array = array();
        foreach ($subData['inq'] as $inq) {
            $display_array[$inq->PPProduktpass_IAN] = "";
            if (isset($prj_minian[$inq->PPProduktpass_PPProjekte_Projekt]) and $prj_minian[$inq->PPProduktpass_PPProjekte_Projekt] != $inq->PPProduktpass_IAN) {
                $display_array[$inq->PPProduktpass_IAN] = "display:none;";
            }
        }

        $subData['display'] = $display_array;

        cpcDebug::cpc_debug(print_r($display_array, true));

        $sortAtt = Array('Ausmusterung', 'Datum', 'Artikel', 'IAN', 'Projekt');
        foreach ($sortAtt as $att) {
            $subData['sort'][$att] = $this->getSortSymbol($att, $search_ausmusterung, $search);

            if ($att . ".X" == $sortChoise) {

                $subData['sort'][$att] = $this->getSortSymbol($att, $search_ausmusterung, $search, "U");
            }
            if ($att . ".U" == $sortChoise) {

                $subData['sort'][$att] = $this->getSortSymbol($att, $search_ausmusterung, $search, "D");
            }
            if ($att . ".D" == $sortChoise) {

                $subData['sort'][$att] = $this->getSortSymbol($att, $search_ausmusterung, $search, "U");
            }
        }



        $subData['Header'] = "&Uuml;bersicht Inquiries";
        $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
        $subData['inp']['search'] = $search;
        $subData['inp']['search_isbettwaesche'] = $search_isbettwaesche;
        $subData['inp']['search_isandere'] = $search_isandere;
        $subData['inp']['sortChoise'] = "";

        $subData['inqs'] = $sInqs;

        $data['content'] = View::make('listen.inquiry_overview')->with('data', $subData);
        return View::make('main', $data);
    }

    private function getSortSymbol($att, $search_ausmusterung, $search, $dir = "") {


        if ($dir == "") {
            return "<button onclick='js_submit(\"$att" . ".X" . "\", \"" . $search_ausmusterung . "\", \"" . $search . "\");' style='float:right; width:15px;height:15px;text-align: center; vertical-align: middle;border: 1px solid gray; border-radius:0px; background-color:lightslategray; '></buton>";
        }

        if ($dir == "U") {
            return "<button onclick='js_submit(\"$att" . ".U" . "\", \"" . $search_ausmusterung . "\", \"" . $search . "\");' style='float:right; width:22px;height:22px;text-align: center; vertical-align: middle;border: none; border-radius:0px; background-color:transparent; color: lightslategray;'>▲</buton> ";
        }
        if ($dir == "D") {
            return "<button onclick='js_submit(\"$att" . ".D" . "\", \"" . $search_ausmusterung . "\", \"" . $search . "\");' style='float:right; width:22px;height:22px;text-align: center; vertical-align: middle;border: none; border-radius:0px; background-color:transparent; color: lightslategray;'>▼</buton> ";
        }
    }

}
