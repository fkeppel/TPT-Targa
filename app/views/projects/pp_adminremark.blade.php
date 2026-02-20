<div style="border:none; border-radius: 0px; height:840px;overflow: hidden;">
    <div style="padding: 10px;">
        <form action="/newRemark" method="POST">
            <input type="hidden" name="ppid" value="{{$data['pp']->PPProduktpass_Id}}" />
            <h3>Projektnotizen</h3>
            <input disabled value="{{date('d.m.Y')}}"/> <input disabled value="{{Auth::user()->PPMitarbeiter_Kuerzel}}"/> <br>
            <textarea name="PPProduktpass_AdminRemarkNeu" style="padding:10px;font-size:1.2em;width:1400px;height:200px;overflow:auto; margin:1px solid lightgray; border-radius:0px;"></textarea><br>
            <button style="width:200px;padding:10px;margin-top:10px;">Neue Notiz erfassen</button><br>
        </form>
        
        <form action="/updateRemark" method="POST">
            <input type="hidden" name="ppid" value="{{$data['pp']->PPProduktpass_Id}}" />
            <textarea name="PPProduktpass_AdminRemark" style="padding:10px;font-size:1.2em;width:1400px;height:450px;overflow:auto; margin:1px solid lightgray; border-radius:0px;">{{ $data['pp']->PPProduktpass_AdminRemark }}</textarea>
            <br>
            <button style="width:200px;padding:10px;margin-top:10px;">Notizen ändern</button>
        </form>
    </div>
</div>