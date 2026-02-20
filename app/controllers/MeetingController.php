<?php
class MeetingController extends \BaseController {
    public function getOrNewMeeting($ppid){
        $m = PPMeetingprotokoll::where ('PPMeetingprotokoll_PPProduktpass_Id', $ppid)->where('PPMeetingprotokoll_Mode','E')->where('PPMeetingprotokoll_Status',0)->orderBy('PPMeetingprotokoll_Id','DESC')->get()->first();
        if (!$m ){
            $m = $this->newMeeting($ppid);
            $m->PPMeetingprotokoll_Schriftfuehrer = Auth::user()->PPMitarbeiter_Id;
            $m->save();
        }
        if ( $m->PPMeetingprotokoll_Thema == 'Neues Meeting'){
            $m->PPMeetingprotokoll_Schriftfuehrer = Auth::user()->PPMitarbeiter_Id;
            $m->save();
        }
        $ma = $this->getMitarbeiter();
        $t = $this->getTeilnehmer($m->PPMeetingprotokoll_Id);
        $ret = array('Meeting' => $m, 'Mitarbeiter' => $ma, 'Teilnehmer' => $t);
        //print_r($ret);
        //exit;
        return $ret;
    }
    private function getMeeting($mid){
        $m = PPMeetingprotokoll::where ('PPMeetingprotokoll_Id', $mid)->where ('PPMeetingprotokoll_Status', 0)->get()->first();
        $ma = $this->getMitarbeiter();
        $t = $this->getTeilnehmer($m->PPMeetingprotokoll_Id);
        $pp = tPPProduktpass::where ('PPProduktpass_ID', $m->PPMeetingprotokoll_PPProduktpass_Id)->get()->first();
        $ret = array('Meeting' => $m, 'Mitarbeiter' => $ma, 'Teilnehmer' => $t, 'Produktpass' => $pp);
        return $ret;
    }
    public function newMeeting ($ppid){
        $m = new PPMeetingprotokoll();
        $m->PPMeetingprotokoll_PPProduktpass_Id = $ppid;
        $m->PPMeetingprotokoll_Mode = 'E';
        $m->PPMeetingprotokoll_Date = date('Y-m-d H:i:s');
        $m->save();
        return $m;
    }
    private function getMitarbeiter()
    {
        $mas = PPMitarbeiter::where('PPMitarbeiter_Status', 1)->orderBy('PPMitarbeiter_Name')->orderBy('PPMitarbeiter_Vorname')->get();
        $ret = array();
        foreach ($mas as $ma) {
            $ret[$ma->PPMitarbeiter_Id] = array('Kuerzel' => $ma->PPMitarbeiter_Kuerzel, 'Name' => $ma->PPMitarbeiter_Name.', '.$ma->PPMitarbeiter_Vorname, 'email' => $ma->PPMitarbeiter_email);
        }
        return $ret;
    }
    private function updateMeeting ($p){
      $m = PPMeetingprotokoll::find($p['PPMeetingprotokoll_Id']);
        if ($m){
            foreach($p as $att => $val){
                $m->{$att} = $val;
            }
            $m->PPMeetingprotokoll_Date = date('Y-m-d H:i:s');
            $m->save();
        }
    }
    public function update (){
        $mode = Input::get('submit');
        $p = Input::get('Protokoll');
        $this->updateMeeting($p); 
        $t = Input::get('Teilnehmer');
        $this->updateTeilnehmer($p['PPMeetingprotokoll_Id'],$t); 
        //$this->printMeetingProtokoll($p['PPMeetingprotokoll_Id']);
        if ($mode == 'ablegen'){
            return $this->printMeetingProtokoll($p['PPMeetingprotokoll_Id']);
        }
        return Redirect::to('/show/' . $p['PPMeetingprotokoll_PPProduktpass_Id'] . "#tabs-45");
    }
    private function deleteTeilnehmer ($mid){
        $tns = PPMeetingprotokollTeilnehmer::where('PPMeetingprotokollTeilnehmer_Meetingprotokoll_Id', $mid)->get();
        if ($tns){
            foreach($tns as $t){
                $t->delete();
            }
        }
    }
    private function updateTeilnehmer($mid, $t){
        $this->deleteTeilnehmer($mid);
        $this->insertTeilnehmer($mid,$t); 
    }
    private function insertTeilnehmer($mid, $tns){
            foreach($tns as $t){
                if (strlen($t) >= 1 ){
                    $tdb = new PPMeetingprotokollTeilnehmer();
                    $tdb->PPMeetingprotokollTeilnehmer_Meetingprotokoll_Id = $mid;
                    $tdb->PPMeetingprotokollTeilnehmer_PPMitarbeiter_Id = $t;
                    $tdb->save();
                }
            }
    }
    private function getTeilnehmer ($mid){
        $tns = PPMeetingprotokollTeilnehmer::where('PPMeetingprotokollTeilnehmer_Meetingprotokoll_Id', $mid)->get();
        $ret = array();
        if ($tns){
            $i=1;
            foreach($tns as $t){
                $ret[$i++] = $t->PPMeetingprotokollTeilnehmer_PPMitarbeiter_Id;
            }
        }
        return $ret;
    }
    private function printMeetingProtokoll($mid){
        $pdf = new PDFController();
        $this->updateFinal($mid);
        $meeting = $this->getMeeting($mid);
        $pdf->ablageMeetigProtokoll($meeting);
        $this->clearMeeting($mid);
        return Redirect::to('/showAfterUpload/' . $meeting['Produktpass']['PPProduktpass_Id'] . "/6/EKPM/0/0");
    }
    private function clearMeeting ($mid){
        $m = PPMeetingprotokoll::find($mid);
        if ($m){
            $m->PPMeetingprotokoll_Status = 1;
            $m->save();
        }
    }
    private function updateFinal ($mid){
        $m = PPMeetingprotokoll::find($mid);
        if ($m){
            $m->PPMeetingprotokoll_DateFinal = date('Y-m-d H:i:s');
            $m->save();
        }
      }
      public function updateMeetingAjax (){
        //cpcDebug::cpc_debug($_POST,'@T14');
        $ppid = Input::get('ppid');
        $meetId = Input::get('meetId');
        $meetUser = Input::get('meetUser');
        $meetSchriftfuehrer = Input::get('meetSchriftfuehrer');
        $meetThema = Input::get('meetThema');
        $meetAgenda = Input::get('meetAgenda');
        $meetText = Input::get('meetText');
        $meetArt = Input::get('meetArt');
        $tn = Input::get('tn');
        $mode = Input::get('speichernOderAblegen');
        /* cpcDebug::cpc_debug($ppid,'@T14');
        cpcDebug::cpc_debug($meetId,'@T14');
        cpcDebug::cpc_debug($meetUser,'@T14');
        cpcDebug::cpc_debug($meetSchriftfuehrer,'@T14');
        cpcDebug::cpc_debug($meetThema,'@T14');
        cpcDebug::cpc_debug($meetProtokoll,'@T14');
        cpcDebug::cpc_debug($tn,'@T14');
        cpcDebug::cpc_debug($speichernOderAblegen,'@T14'); */
        $p = array();
        $p['PPMeetingprotokoll_Id'] = $meetId;
        $p['PPMeetingprotokoll_PPProduktpass_Id'] = $ppid;
        $p['PPMeetingprotokoll_Schriftfuehrer'] = $meetSchriftfuehrer;
        $p['PPMeetingprotokoll_Thema'] = $meetThema;
        $p['PPMeetingprotokoll_Agenda'] = $meetAgenda;
        $p['PPMeetingprotokoll_Text'] = $meetText;
        $p['PPMeetingprotokoll_Art'] = $meetArt;
        $this->updateMeeting($p); 
        $this->updateTeilnehmer($p['PPMeetingprotokoll_Id'],$tn); 
        //$this->printMeetingProtokoll($p['PPMeetingprotokoll_Id']);
        //cpcDebug::cpc_debug("Mode:  $mode",'@T14');
        if ($mode == 'ablegen'){
            $this->printMeetingProtokoll($p['PPMeetingprotokoll_Id']);
            return json_encode(array('Result' => 'OK'));
        }
        return json_encode(array('Result' => 'OK'));
    }
}
