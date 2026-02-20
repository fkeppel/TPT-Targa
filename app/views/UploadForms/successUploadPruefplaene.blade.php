<div style='padding:10px;'>
    <a href='http://{{$_SERVER['SERVER_NAME']}}/home' style='text-decoration:none;padding:10px;font-family:Tahoma;'>
        <div style='color:white;background-color:dodgerblue;width:175px;height:25px;padding:10px;border:1px solid darkblue;text-align:center;'>Zurück zum Menu</div>
    </a>
<div>
<div style="border-top:40px;background-color: #FFF; border:1px solid gray;border-radius: 5px; width:90%;height:90%;text-align: left;padding:30px; font-family: Tahoma; font-size: 14px;">
    <h1>Ergebnis Massen Upload von Prüfplänen </h1>
    <div style="float: left;width:85%; border:4px solid lightgray; margin-left: 20px;padding:20px; height:80%;overflow:auto;">
        <table style="width:95%;border-collapse:collapse;">
            <tr>
                <th style='padding:8px;width:60%;background-color:dodgerblue;color:white;border:1px solid gray;'>Datei</th>
                <th style='padding:8px;width:18%;background-color:dodgerblue;color:white;border:1px solid gray;'>Bereich-Link</th>
                <th style='padding:8px;width:18%;background-color:dodgerblue;color:white;border:1px solid gray;'>Status</th>
            </tr>
        @foreach ($result as $r)
            <tr>
                <td style='padding:8px;border:1px solid gray;'>{{$r['Filename']}}</td>
                <td style='padding:8px;border:1px solid gray;'>@if($r['Link'] !== false)<a href="{{url($r['Link'])}}" target='_blank'>PPUpload/PDFs</a>@endif</td>
                <td style="padding:8px;border:1px solid gray;color:{{$r['Color']}};">{{$r['Status']}}</td>
            </tr>
        @endforeach
        </table>
    </div>
</div>
