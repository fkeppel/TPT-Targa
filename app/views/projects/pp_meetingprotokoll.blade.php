<?php 
    if (isset($data['MeetingProtokoll'])){
        $meeting = $data['MeetingProtokoll']['Meeting'];
        $mas = $data['MeetingProtokoll']['Mitarbeiter'];
        $tns = $data['MeetingProtokoll']['Teilnehmer'];
    } else {
        $meeting = array();
        $mas = array();
        $tns = array();
    }
    $maid = Auth::user()->PPMitarbeiter_Id;
?>
<style>
    #meeting {
        border:1px solid lightgray; 
        border-radius: 0px;
        height:840px;
        overflow: hidden;
        padding-left:30px;
    }
    #meeting input {
        border:1px solid lightgray;
        border-radius:0px;
        padding:10px;
    }
    #meeting textarea {
        border:1px solid lightgray;
        border-radius:0px;
    }
    #meeting select {
        width:100px;
        height:30px;
        font-size:11px;
        font-family:Arial;
        border:1px solid lightgray;
    }
    #tn {
        font-size:12px;
        font-family:Arial;
        border-collapse:collapse;
    }
    #tn td {
        padding:8px;
        height:25px;
        vertical-align:top;
    }
    .tdp0 {
        padding:0px!important;
        width:100px;
    }
    .tdp0 select {
        margin:0px;
        margin-top:-14px;
    }
    #meeting h3 {
        color: darkblue;
        font-size:2em;
        margin-bottom:0px;
    }
    #meeting h4 {
        color: darkblue;
        font-size:1.5em;
        margin-bottom: -10px;
        margin-top: 15px;
    }
    .dropDownMitarbeiter {
        width:200px;
        border:3px solid gray;
    }
</style>
<div id='meeting'>
    <div style="padding: 10px;">
        <form action="/updateMeeting" method="POST">
            <input type="hidden" name="Protokoll[PPMeetingprotokoll_Id]" value="{{$meeting->PPMeetingprotokoll_Id}}" />
            <input type="hidden" name="Protokoll[PPMeetingprotokoll_PPProduktpass_Id]" value="{{$data['pp']->PPProduktpass_Id}}" />
            <input type='hidden' name="user" value="{{Auth::user()->PPMitarbeiter_Kuerzel}}"/> <br>
            <input type='hidden' name="Protokoll[PPMeetingprotokoll_Art]" value="Kickoff"/> <br>
            <h3>Meeting Protokoll</h4>
            <br>
            <table id='tn'>
                <tr>
                    <td>Protokollführer</td>
                    <td class='tdp0'>
                        <select class='dropDownMitarbeiter'  style='margin:0px;margin-top:-14px;width:200px;' name="Protokoll[PPMeetingprotokoll_Schriftfuehrer]"> 
                            <option value=''></option>
                            @foreach($mas as $id => $m)
                            <option value='{{$id}}' @if($meeting->PPMeetingprotokoll_Schriftfuehrer == $id or (is_null($meeting->PPMeetingprotokoll_Schriftfuehrer) and $maid == $id) ) selected @endif >{{$m['Name']}} {{$m['Kuerzel']}}</option>
                            @endforeach  
                        </select>
                    </td>
                    <!--td>Art</td>
                    <td class='tdp0'><select id='meetArt' class='dropDownMitarbeiter'  style='margin:0px;width:200px;' name="Protokoll[PPMeetingprotokoll_Art]"> 
                            <option value='Kickoff' @if($meeting->PPMeetingprotokoll_Art == 'Kickoff' ) selected @endif >Kick-Off-Meeting</option>
                            <option value='Review' @if($meeting->PPMeetingprotokoll_Art == 'Review' ) selected @endif >Review-Meeting</option>
                        </select>
                    </td>
                    <td colspan='6'>
                    </td-->
                </tr>
                <tr>
                @for ($i =1 ; $i<=5 ; $i++)
                    <td>Teilnehmer {{$i}}</td>
                    <td class='tdp0'>   
                        <select class='dropDownMitarbeiter'  name="Teilnehmer[{{$i}}]" > 
                            <option value=''></option>
                            @foreach($mas as $id => $m)
                            <option value='{{$id}}' @if(isset($tns[$i]) and $tns[$i] == $id) selected @endif>{{$m['Name']}} [{{$m['Kuerzel']}}]</option>
                            @endforeach  
                        </select>
                    </td>
                @endfor
                </tr>
                <tr>
                @for ($i =6 ; $i<=10 ; $i++)
                    <td>Teilnehmer {{$i}}</td>
                    <td class='tdp0'>   
                        <select class='dropDownMitarbeiter' name="Teilnehmer[{{$i}}]" > 
                            <option value=''></option>
                            @foreach($mas as $id => $m)
                            <option value='{{$id}}' @if(isset($tns[$i]) and $tns[$i] == $id) selected @endif>{{$m['Name']}} [{{$m['Kuerzel']}}] </option>
                            @endforeach  
                        </select>
                    </td>
                @endfor
                </tr>
            </table>
            <h4>Thema</h4><br>
            <input name="Protokoll[PPMeetingprotokoll_Thema]" value="{{$meeting->PPMeetingprotokoll_Thema}}"/> <br>
            <h4>Agenda</h4><br>
            <textarea   name="Protokoll[PPMeetingprotokoll_Agenda]" style="padding:10px;font-size:1.2em;width:1400px;height:100px;overflow:auto; margin:1px solid lightgray; border-radius:0px;">{{$meeting->PPMeetingprotokoll_Agenda}}</textarea><br>
            <h4>Protokoll</h4><br>
            <textarea   name="Protokoll[PPMeetingprotokoll_Text]" style="padding:10px;font-size:1.2em;width:1400px;height:200px;overflow:auto; margin:1px solid lightgray; border-radius:0px;">{{$meeting->PPMeetingprotokoll_Text}}</textarea>
            <br>
            <div><button type='submit' name='submit' style="width:200px;padding:10px;margin-top:10px;" value='speichern'>speichern</button><button  type='submit' name='submit' value='ablegen' style="width:200px;padding:10px;margin:10px;">ablegen</button></div>
        </form>
    </div>
</div>
