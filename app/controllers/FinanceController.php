<?php
class FinanceController extends \BaseController {
    public function create() {
        //
    }
    public function Index() {
        $data = array();
        //$dtks = PPDevisenTerminKaeufe::where('PPDevisenTerminKaeufe_Status', "=", 'offen')->get()->toArray();
        $dtks = DB::table('v_DTKmitWerten')->where('PPDevisenTerminKaeufe_Status', "=", 'offen')->get();
        $data['dtks'] = $dtks;
        $data['content'] = View::make('finance.dtk_ov')->with('data', $data);
        return View::make('main', $data);
    }
    public function ShowDTK() {
        return $this->ShowDTKId($_POST['id']);
    }
    public function NewDTKAssign() {
        $dtkid = $_POST['dtkid'];
        $ppid = $_POST['ppid'];
        $assign = new PPPurchaseDTK;
        $assign->PPPurchaseDTK_PPDevisenTerminKaeufe_Id = $dtkid;
        $assign->PPPurchaseDTK_PPProduktpass_id = $ppid;
        $assign->save();
        return $this->ShowDTKId($dtkid);
    }
    public function AssignDTKAssign() {
        $assign = Input::get('ASS');
        $pdtkid = $assign['pdtkid'];
        $dtkid = $assign['dtkid'];
        $ppid = $assign['ppid'];
        $assign = PPPurchaseDTK::where('PPPurchaseDTK_Id', '=', $pdtkid)->get()->first();
        $assign->PPPurchaseDTK_PPProduktpass_id = $ppid;
        $assign->save();
        $dtk = PPDevisenTerminKaeufe::where('PPDevisenTerminKaeufe_Id', '=', $assign->PPPurchaseDTK_PPDevisenTerminKaeufe_Id)->get()->first();
        $pps = PPPurchase::where('PPPurchase_PPProduktpass_Id', '=', $assign->PPPurchaseDTK_PPProduktpass_id)->get();
        foreach ($pps as $pp) {
            $pp->PPPurchase_ExcR_Save = $dtk->PPDevisenTerminKaeufe_Kurs;
            $pp->PPPurchase_ExcR_Save_Date = $dtk->PPDevisenTerminKaeufe_Termin;
            $pp->save();
        }
        return $this->ShowDTKId($dtkid);
    }
    public function SaveDTKAssign() {
        $assign = $_POST['ASS'];
        $pdtkid = $assign['pdtkid'];
        $betrag = $this->Num2Sql($assign['Betrag']);
        $dtkid = $assign['dtkid'];
        if ($_POST['sbut'] == 'löschen') {
            $del = PPPurchaseDTK::find($pdtkid);
            $del->delete();
        } else {
            $assign = PPPurchaseDTK::where('PPPurchaseDTK_Id', '=', $pdtkid)->get()->first();
            $assign->PPPurchaseDTK_Betrag = $betrag;
            $assign->save();
        }
        return $this->ShowDTKId($dtkid);
    }
    public function ShowUngedeckt() {
        $data = array();
        $sort_key = Input::get('sort_key');
        $sort_order = Input::get('sort_dir');
        $dir = 'ASC';
        $sort = 'PPProduktpass_IAN';
        $data['inp']['search'] = Input::get('search');
        $search = Input::get('search');
        $data['inp']['search_ausmusterung'] = Input::get('search_ausmusterung');
        $search_ausmusterung = trim(Input::get('search_ausmusterung'));
        if ($search_ausmusterung == "") {
            $search_ausmusterung = "1901";
        }
        if ($sort_key == 'ian') {
            $sort = 'PPProduktpass_IAN';
        }
        if ($sort_key == 'ausmustrung') {
            $sort = 'PPProduktpass_Ausmusterungnummer';
        }
        if ($sort_key == 'supplier') {
            $sort = 'PPPurchase_Supplier';
        }
        if ($sort_key == 'article') {
            $sort = 'PPProduktpass_Artikelbezeichnung';
        }
        if ($sort_key == 'lt') {
            $sort = 'PPProduktpass_LieferterminJahr';
        }
        if ($sort_order == 'desc') {
            $dir = 'DESC';
        }
        $dtk_ass = array();
        $assigns = DB::table('v_DTKmitZuordung')->get();
        foreach ($assigns as $ass) {
            $dtk_ass[$ass->PPPurchaseDTK_PPProduktpass_id][] = array('ref' => $ass->PPDevisenTerminKaeufe_Referenz, 'id' => $ass->PPDevisenTerminKaeufe_Id);
        }
        //var_dump($dtk_ass);        exit;
        $data['assigns'] = $dtk_ass;
        $data['overview'] = DB::table('v_DTKUebersicht')
                        ->where('PPProduktpass_Ausmusterungnummer', 'like', "$search_ausmusterung%")
                        ->where(function($query) use (&$search) {
                            $query->where('PPPurchase_Supplier', 'like', "%$search%")
                            ->orWhere('PPProduktpass_Artikelbezeichnung', 'like', "%$search%");
                        })
                        ->orderBy($sort, $dir)->orderBy('PPProduktpass_Liefertermin', $dir)
                        ->orderBy('PPPurchase_Supplier', $dir)->get();
        $data['content'] = View::make('finance.dtk_ovPP')->with('data', $data);
        return View::make('main', $data);
    }
    private function saveLiq($l, $Id) {
        if ($Id == -1) {
            $liq = new PPZahlungen ();
            // echo("Neue Zahlung<br>");
        } else {
            $liq = PPZahlungen::where("PPZahlungen_Id", "=", $Id)->get()->first();
            /* var_dump($liq);
              echo("<br><br>");
              echo("<br><b>Update:</b> " . $liq['PPZahlungen_PPProduktpass_Id'] . "->" . $l['PPProduktpass_Id'] . "<br>");
              echo("       " . $liq['PPZahungen_Bemerkung'] . "->" . $l['Bemerkung'] . "<br>");
              echo("       " . $liq['PPZahungen_BezahltBemerkung'] . "->" . $l['BezahltBemerkung'] . "<br>---------------<br>");
             *
             */
        }
        foreach ($l as $at => $val) {
            $attr = 'PPZahlungen_' . $at;
            if ($at == 'BezahltAm') {
                if (trim($val) == '') {
                    $val = '0000-00-00';
                }
            }
            if ($at == 'Betrag') {
                if ($val == '') {
                    $val = 0;
                } else {
                    $val = $this->Num2Sql($val);
                }
            }
            $liq->$attr = $val;
            //echo("Attr: $attr  Val: $val  <br>");
        }
        $liq->save();
    }
    public function saveLiquiditaet() {
        $liqs = Input::get('Liq');
        $liqIds = Input::get('LiqIds');
        $maxpos = Input::get('MaxPos');
        for ($i = 1; $i <= $maxpos; $i++) {
            /* echo("POS: " . $i . "<br>");
              echo("ZId: " . $liqIds[$i]['ZId'] . "<BR>");
              echo("PPId: " . $liqs[$i]['PPProduktpass_Id'] . "<BR>");
             *
             */
            $this->saveLiq($liqs[$i], $liqIds[$i]['ZId']);
        }
        if (Input::has('IsLC')) {
            return $this->showLCOv();
        }
        return $this->ShowLiquiditaet();
    }
    public function showLCOv() {
        $inp = Input::all();
        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $subData['inp']['LCAll'] = '';
        $search_ausmusterung = '';
        $search = '';
        $LCAll = 0;
        if (isset($inp['IsPost'])) {
            $search = $inp['search'];
            $search_ausmusterung = $inp['search_ausmusterung'];
            if (Input::has('LCAll')) {
                $LCAll = 1;
                $subData['liqs'] = DB::table('v_Liquiditaet')
                        ->where('Ausmusterung', 'like', '%' . $search_ausmusterung . '%')
                        ->where('TOP', '=', 'L/C')
                        ->where(function($query) use($search) {
                            $query->whereNull('LC')
                            ->orwhere('LC', '=', "");
                        })
                        ->where(function($query) use ($search) {
                            $query->where('LC', 'like', '%' . $search . '%')
                            ->orwhere('Projekt', 'like', "%$search%")
                            ->orwhere('Nummer', 'like', "%$search%")
                            ->orwhere('IAN', 'like', "%$search%")
                            ->orwhere('Artikelbezeichnung', 'like', "%$search%");
                        })
                        ->orderBy('Projekt', 'DESC')
                        ->orderBy('IAN')
                        ->get();
            } else {
                $subData['liqs'] = DB::table('v_Liquiditaet')
                        ->where('Ausmusterung', 'like', '%' . $search_ausmusterung . '%')
                        ->where('TOP', '=', 'L/C')
                        ->where(function($query) use ($search) {
                            $query->where('LC', 'like', '%' . $search . '%')
                            ->orwhere('Projekt', 'like', "%$search%")
                            ->orwhere('Nummer', 'like', "%$search%")
                            ->orwhere('IAN', 'like', "%$search%")
                            ->orwhere('Artikelbezeichnung', 'like', "%$search%");
                        })
                        ->orderBy('Projekt', 'DESC')
                        ->orderBy('IAN')
                        ->get();
            }
        } else {
            $subData['liqs'] = DB::table('v_Liquiditaet')
                    ->where('TOP', '=', 'L/C')
                    ->orderBy('Projekt', 'DESC')
                    ->orderBy('IAN')
                    ->get(); 
        }
        $subData['Header'] = "Übersicht L/C";
        $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
        $subData['inp']['search'] = $search;
        $subData['inp']['LCAll'] = $LCAll;
        $data['content'] = View::make('finance.liq_ovLC')->with('data', $subData);
        return View::make('main', $data);
    }
    public function showOrderOv() {
        $inp = Input::all();
        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $search_ausmusterung = '';
        $search = '';
        if (isset($inp['IsPost'])) {
            $search = $inp['search'];
            $search_ausmusterung = $inp['search_ausmusterung'];
            $subData['liqs'] = DB::table('v_Liquiditaet')
                    ->where('Ausmusterung', 'like', $search_ausmusterung . '%')
                    ->where(function($query) use ($search) {
                        $query->where('Projekt', 'like', '%' . $search . '%')
                        ->orwhere('Produzent', 'like', "%$search%")
                        ->orwhere('IAN', 'like', "%$search%")
                        ->orwhere('Artikelbezeichnung', 'like', "%$search%");
                    })
                    ->orderBy('Projekt', 'DESC')
                    ->orderBy('IAN')
                    ->get();
        } else {
            $subData['liqs'] = DB::table('v_Liquiditaet')
                    ->orderBy('Projekt', 'DESC')
                    ->orderBy('IAN')
                    ->get();
            $search_ausmusterung = "1901";
        }
        $subData['Header'] = "Dashboard übergreifende IAN-Suche";
        $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
        $subData['inp']['search'] = $search;
        $data['content'] = View::make('finance.liq_ovOrder')->with('data', $subData);
        return View::make('main', $data);
    }
    public function ShowLiquiditaet() {
        $inp = Input::all();
        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $search_ausmusterung = '';
        $search = '';
        if (isset($inp['IsPost'])) {
            $search = $inp['search'];
            $search_ausmusterung = $inp['search_ausmusterung'];
            $subData['liqs'] = DB::table('v_Liquiditaet')
                            ->where('Ausmusterung', 'like', '%' . $search_ausmusterung . '%')
                            ->where(function($query) use ($search) {
                                $query->where('LC', 'like', '%' . $search . '%')
                                ->orwhere('BezahltBemerkung', 'like', "%$search%")
                                ->orwhere('IAN', 'like', "%$search%")
                                ->orwhere('Artikelbezeichnung', 'like', "%$search%");
                            })
                            ->orderBy('IAN', 'DESC')->get();
            $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
            $subData['inp']['search'] = $search;
        } else {
            $subData['liqs'] = DB::table('v_Liquiditaet')
                            ->orderBy('IAN', 'DESC')->get();
        }
        $subData['Header'] = "Übersicht Liquidität";
        $data['content'] = View::make('finance.liq_ov')->with('data', $subData);
        return View::make('main', $data);
    }
    public function showLiqAll() {
        $inp = Input::all();
        $subData['inp']['search_ausmusterung'] = '';
        $subData['inp']['search'] = '';
        $search_ausmusterung = '';
        $search = '';
        if (isset($inp['IsPost'])) {
            $search = $inp['search'];
            $search_ausmusterung = $inp['search_ausmusterung'];
            $subData['liqs'] = DB::table('v_Liquiditaet')
                            ->where('Ausmusterung', 'like', '%' . $search_ausmusterung . '%')
                            ->where(function($query) use ($search) {
                                $query->where('LC', 'like', '%' . $search . '%')
                                ->orwhere('BezahltBemerkung', 'like', "%$search%")
                                ->orwhere('IAN', 'like', "%$search%")
                                ->orwhere('Artikelbezeichnung', 'like', "%$search%");
                            })
                            ->orderBy('IAN', 'DESC')->get();
            $subData['inp']['search_ausmusterung'] = $search_ausmusterung;
            $subData['inp']['search'] = $search;
        } else {
            $subData['liqs'] = DB::table('v_Liquiditaet')
                            ->orderBy('IAN', 'DESC')->get();
        }
        $subData['HeaderDTK'] = "Übersicht DTK nach Perioden";
        $subData['dtks'] = DB::table('v_ZuAbgangDTK')
                ->where('Jahr', '=', '2019')
                ->orderBy('Jahr', 'ASC')
                ->orderBy('Monat', 'ASC')
                ->get();
        $subData['HeaderZufluss'] = "Zufluss [EUR] (Zahlung Kunde) nach Perioden";
        $subData['zus'] = DB::table('v_LiqZuflussPeriodeEUR')
                ->where('PJahr', '=', '2019')
                ->orderBy('PJahr', 'ASC')
                ->orderBy('PMonat', 'ASC')
                ->get();
        $subData['HeaderAbfluss'] = "Abfluss (Zahlung Lieferanten) nach Perioden";
        $subData['abs'] = DB::table('v_LiqAbflussPeriode')
                ->where('Jahr', '=', '2019')
                ->orderBy('Jahr', 'ASC')
                ->orderBy('Monat', 'ASC')
                ->get();
        $data['content'] = View::make('finance.liq_ovges')->with('data', $subData);
        return View::make('main', $data);
    }
    public function ShowDTKId($id) {
        if ($id == -1) {
            $id = $this->NewDTK();
        }
        $data = array();
        $dtk = PPDevisenTerminKaeufe::where('PPDevisenTerminKaeufe_Id', "=", $id)->get()->toArray();
        $data['dtk'] = $dtk[0];
        $assigns = DB::table('v_DTKAssign')->where('PPPurchaseDTK_PPDevisenTerminKaeufe_Id', "=", $id)->get();
        $data['assigns'] = $assigns;
        $ungedeckt = DB::table('v_DTKUngedeckt')->orderBy('PPProduktpass_IAN', 'DESC')->get();
        $data['ungedeckt'] = $ungedeckt;
        $data['content'] = View::make('finance.dtk')->with('data', $data);
        return View::make('main', $data);
    }
    private function Num2Sql($num) {
        $ret = str_replace('.', 'X', $num);
        $ret = str_replace(',', 'Y', $ret);
        $ret = str_replace('X', '', $ret);
        $ret = str_replace('Y', '.', $ret);
        return $ret;
    }
    public function NewDTK() {
        $dtk = new PPDevisenTerminKaeufe;
        $dtk->PPDevisenTerminKaeufe_Referenz = "Neuer Terminkauf";
        $dtk->save();
        return $dtk->PPDevisenTerminKaeufe_Id;
    }
    public function SaveDTK() {
        $a_dtk = $_POST['DTK'];
        $dtk = PPDevisenTerminKaeufe::where('PPDevisenTerminKaeufe_Id', "=", $_POST['id'])->get()->first();
        //Datum konvertieren
        try {
            $a_dtk['Termin'] = date_format(date_create($a_dtk['Termin']), 'Y-m-d');
        } catch (Exception $e) {
            unset($a_dtk['Termin']);
        }
        //Zahlen konvertieren
        $a_dtk['Betrag'] = $this->Num2Sql($a_dtk['Betrag']);
        $a_dtk['Kurs'] = $this->Num2Sql($a_dtk['Kurs']);
        foreach ($a_dtk as $att => $val) {
            //echo "$att => $val <br>";
            $attribute = "PPDevisenTerminKaeufe_" . $att;
            $dtk->$attribute = $val;
        }
        $dtk->save();
        return $this->Index();
    }
}
