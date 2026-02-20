<div>
    
    @if($anz_eans > 0)
    {{$anz_eans}} EAN erfolgreich angelegt. (Maximal Anzahl: {{$anz_max}} ) <br>
    Bitte unten auswählen zum Kopieren<br>
    <br>
    @endif
    <textarea style="width:500px;height:350px;font-size: 12px;color:gray;">{{$new_eans}}</textarea>
</div>