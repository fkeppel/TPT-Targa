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
        height:855px;
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
        width:180px;
        height:30px;
        font-size:11px;
        font-family:Arial;
        border:1px solid lightgray;
        font-size:1.2em;
    }
    #tn {
        font-size:12px;
        font-family:Arial;
        border-collapse:collapse;
    }
    #tn td {
        padding:8px;
        height:25px;
        vertical-align: top!important;
        border:none;
        padding-left:18px;
    }
    .tdp0 {
        padding:0px!important;
        width:100px;
    }
    .tdp0 select {
        margin:0px;
    }
    #meeting h3 {
        color: #1C73C5;
        font-size:2em;
        margin-bottom:0px;
    }
    #meeting h4 {
        color: #1C73C5;
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
            <input id='meetId' type="hidden" name="Protokoll[PPMeetingprotokoll_Id]" value="{{$meeting->PPMeetingprotokoll_Id}}" />
            <input id='ppid'  type="hidden" name="Protokoll[PPMeetingprotokoll_PPProduktpass_Id]" value="{{$data['pp']->PPProduktpass_Id}}" />
            <input id='meetUser' type='hidden' name="user" value="{{Auth::user()->PPMitarbeiter_Kuerzel}}"/> <br>
            <h5 style='font-size:1.5em;'>{{ ServiceProvider::tl($data['lang'],'Meeting Protokoll') }}</h5>
            <br>
            <table id='tn'>
                <tr>
                    <td>{{ ServiceProvider::tl($data['lang'],'Protokollführer')}}</td>
                    <td class='tdp0'>
                        <select id='meetSchriftfuehrer' class='dropDownMitarbeiter'  name="Protokoll[PPMeetingprotokoll_Schriftfuehrer]"> 
                            <option value=''></option>
                            @foreach($mas as $id => $m)
                            <option value='{{$id}}' @if($meeting->PPMeetingprotokoll_Schriftfuehrer == $id or (is_null($meeting->PPMeetingprotokoll_Schriftfuehrer) and $maid == $id) ) selected @endif >{{$m['Name']}} {{$m['Kuerzel']}}</option>
                            @endforeach  
                        </select>
                    </td>
                    <!-- td>Art</td>
                    <td class='tdp0'><select id='meetArt' class='dropDownMitarbeiter'  style='width:200px;' name="Protokoll[PPMeetingprotokoll_Art]"> 
                            <option value='Kickoff' @if($meeting->PPMeetingprotokoll_Art == 'Kickoff' ) selected @endif >Kick-Off-Meeting</option>
                            <option value='Review' @if($meeting->PPMeetingprotokoll_Art == 'Review' ) selected @endif >Review-Meeting</option>
                        </select>
                    </td -->
                    <td colspan='8'>
                    </td>
                </tr>
                <tr>
                @for ($i =1 ; $i<=5 ; $i++)
                    <td>{{ ServiceProvider::tl($data['lang'],'Teilnehmer')}} {{$i}}</td>
                    <td class='tdp0'>   
                        <select class='dropDownMitarbeiter'  name="Teilnehmer[{{$i}}]"  id="meetTeilnehmer_{{$i}}"> 
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
                    <td>{{ ServiceProvider::tl($data['lang'],'Teilnehmer')}} {{$i}}</td>
                    <td class='tdp0'>   
                        <select class='dropDownMitarbeiter'  name="Teilnehmer[{{$i}}]"  id="meetTeilnehmer_{{$i}}" > 
                            <option value=''></option>
                            @foreach($mas as $id => $m)
                            <option value='{{$id}}' @if(isset($tns[$i]) and $tns[$i] == $id) selected @endif>{{$m['Name']}} [{{$m['Kuerzel']}}] </option>
                            @endforeach  
                        </select>
                    </td>
                @endfor
                </tr>
            </table>
            <h5 onclick='testText();'>{{ ServiceProvider::tl($data['lang'],'Thema')}}</h5><br>
            <input style='width:50%;' id='meetThema' name="Protokoll[PPMeetingprotokoll_Thema]" value="{{$meeting->PPMeetingprotokoll_Thema}}"/> <br>
            <h5>{{ ServiceProvider::tl($data['lang'],'Agenda')}}</h5><br>
            <textarea   id='meetAgenda'   name="Protokoll[PPMeetingprotokoll_Agenda]" style="padding:10px;width:80%;height:100px;overflow:auto; margin:1px solid lightgray; border-radius:0px;">{{$meeting->PPMeetingprotokoll_Agenda}}</textarea><br>
            <h5>{{ ServiceProvider::tl($data['lang'],'Protokoll')}}</h5><br>
            <textarea  id='meetText'   name="Protokoll[PPMeetingprotokoll_Text]" style="padding:10px;width:80%;height:200px;overflow:auto; margin:1px solid lightgray; border-radius:0px;">{{$meeting->PPMeetingprotokoll_Text}}</textarea>
            <br>
            <button onclick="sendMeeting('speichern');" type='button' name='submit' class='tgButton' style='width:200px;' value='speichern'>{{ ServiceProvider::tl($data['lang'],'speichern')}}</button>
            <button onclick="sendMeeting('ablegen');"   type='button' name='submit' class='tgButton' style='width:200px;' value='ablegen'>{{ ServiceProvider::tl($data['lang'],'ablegen')}}</button>
        </form>
    </div>
</div>
<script>
    var t1 = '{{ ServiceProvider::tl($data['lang'],'Protokoll gespeichert!')}}';
    var t2 = '{{ ServiceProvider::tl($data['lang'],'Protokoll wurde abgelegt!')}}';
    function testText (){
        alert (t1);
    }
    function sendMeeting (speichernOderAblegen) {
        var url = '/updateMeetingAjax';
        var meetId             = $('#meetId').val();
        var ppid               = $('#ppid').val();
        var meetUser           = $('#meetUser').val();
        var meetSchriftfuehrer = $('#meetSchriftfuehrer').val();
        var meetThema          = $('#meetThema').val();
        var meetAgenda         = $('#meetAgenda').val();
        var meetText           = $('#meetText').val();
        var meetArt           = $('#meetArt').val();
        const tn = new Array();
        for (i=0;i<10;i++){
            j=i+1;
            var tnId = '#meetTeilnehmer_' + j;
            //console.log (tnId);
            tn[i] = $(tnId ).val();
        }
        var data = {ppid:ppid, meetId:meetId, ppid:ppid, meetUser:meetUser, meetSchriftfuehrer:meetSchriftfuehrer, meetThema:meetThema, meetAgenda:meetAgenda, meetText:meetText, tn:tn, speichernOderAblegen:speichernOderAblegen, meetArt:meetArt};
        console.log (data);
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: data,
            success:function(data){
                console.log(data);
                if (speichernOderAblegen == 'ablegen'){
                    alert(t2);
                    //$('#meetId').val();
                    $('#meetThema').val('');
                    $('#meetAgenda').val('');
                    $('#meetText').val('');
                     for (i=1;i<=10;i++){
                        var att = 'meetTeilnehmer_' + i;
                        var elem = document.getElementById(att);
                        if (elem){
                            elem.selectedIndex = "-1";
                        }
                    }
                } else {
                    alert(t1);
                }
               console.log(data);
            }
        });
    }
</script>