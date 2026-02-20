<div>



    <iframe src="https://forms.office.com/r/8VaFdzG26a" width="900" height="600" name="Rechnungsprüfung">

        @if (count($data['revisionen'])>0)
        <table style="font-size:11px;margin:30px;border:1px solid gray;">
            <tr>
                <td style="border:1px solid gray;padding:5px;width:60px;background-color:lightgray;text-align: center;">Revision</td>
                <td style="border:1px solid gray;padding:5px;width:80px;background-color:lightgray;text-align: center;">Datum</td>
                <td style="border:1px solid gray;padding:5px;width:80px;background-color:lightgray;text-align: center;">Aktion</td>
                <td style="border:1px solid gray;padding:5px;width:80px;background-color:lightgray;text-align: center;">Aktion</td>
            </tr>

            @foreach ($data['revisionen'] as $rev)

            <tr>
                <td style="border:1px solid gray;padding:5px;text-align: center;">{{$rev['PPProduktpass_Revisionsnummer']}}</td>
                <td style="border:1px solid gray;padding:5px;text-align: center;">@if (!is_null($rev['PPProduktpass_RevisionDatum'])){{date_format(date_create($rev['PPProduktpass_RevisionDatum']),'d.m.Y')}}@endif</td>
                <td style="border:1px solid gray;padding:5px;text-align: center;background-color:#e78f08;"><a href="/show/{{$rev['PPProduktpass_Id']}}" target="_blank" style="text-decoration: none;color:#000;">Anzeigen</a>
                <td style="border:1px solid gray;padding:5px;text-align: center;background-color:#e78f08;"><a href="/diffRevision/{{$rev['PPProduktpass_RevisionVon_PPProduktpass_Id']}}" target="_blank" style="text-decoration: none;color:#000;">Änderungen</a>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        Keine Revisionen
        @endif


</div>