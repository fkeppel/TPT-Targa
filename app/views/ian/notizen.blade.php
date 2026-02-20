<?php $lang = $data['lang']; ?>
<div style="border:none; border-radius: 0px; height:820px;overflow: auto;">
    <div style="padding: 10px;">
        <form action="#" method="POST">
            <h5 style='font-size:1.5em;'>{{ ServiceProvider::tl($lang,'Projektnotizen') }}</h5>
            <input disabled value="{{date('d.m.Y')}}"/> <input disabled value="{{Auth::user()->PPMitarbeiter_Kuerzel}}"/> <br>
            <textarea id='newPX' name="PPProduktpass_AdminRemarkNeu" style="padding:10px;width:80%;min-width:388px;max-width:1400px;height:120px;overflow:auto; border:1px solid lightgray; border-radius:0px;"> </textarea><br>
            <button   type='button'   onclick="projectNote({{$data['pp']->PPProduktpass_Id}}, 'NEW');" class='tgButton'>{{ ServiceProvider::tl($lang,'Neue Notiz erfassen') }}</button><br>
        </form>
        <form action="#" method="POST">
            <textarea  id='updatePX'  name="PPProduktpass_AdminRemark" style="padding:10px;width:80%;min-width:388px;max-width:1400px;height:400px;overflow:auto; border:1px solid lightgray; border-radius:0px;">{{ $data['pp']->PPProduktpass_AdminRemark }}</textarea><br>
            <button type='button' onclick="projectNote({{$data['pp']->PPProduktpass_Id}}, 'UPDATE');" class='tgButton'>{{ ServiceProvider::tl($lang,'Notizen ändern') }}</button>
        </form>
    </div>
</div>
<script>
    function projectNote (ppid, type) {
        //alert (ppid + ': ' + type);
        var noteElem;
        var url;
        if (type == 'NEW') {
            noteElem = document.getElementById('newPX');
            url = '/newProjectNotes';
        } else {
            noteElem = document.getElementById('updatePX');
            url = '/updateProjectNotes';
        }
        $.ajax({
            url:url,    //the page containing php script
            type: "post",    //request type,
            dataType: 'json',
            data: {ppid: ppid, text: noteElem.value},
            success:function(data){
                if (type == 'NEW'){
                    alert('Notiz erfaßt!');
                } else {
                    alert('Notiz(en) gespeichert!');
                }
                if (type == 'NEW'){
                    $('#newPX').val('');
                    $('#updatePX').val(data);
                } else {
                    $('#updatePX').val(data);
                }
            }
        });
    }
</script>
