<?php $bgcolor1 = "#f6a828"; ?>

<style>
    .poth1, .poth2, .poth3{
        background-color:#d9d9d9;
        border: 1px solid lightgrey;
        padding:4px;
    }
    .poth1 {
        width:100px;
    }
    .poth2 {
        width:150px;
    }
    .poth3{
        width:100px;text-align:right;
    }
    .potdl, .potdr {
        border:1px solid lightgrey;
        padding:4px;
    }
    .potdr {
        text-align:right;
    }
    li{
        margin-bottom:10px;
    }
    #cmds #frm_button{
        width:135px;
        margin:0px;
        height: 28px;
        float: left;
        border:none;
        padding:0px;
    }


    .cpcLocalQuant div {
        width:100%;
        border:1px solid orange;
        padding:15px;
    }
    .cpcLocalQuant table{
        padding: 0px;
        border-collapse: collapse;
        font-family: tahoma;
        font-size: 11px;

        table-layout: fixed;

    }

    .cpcLocalQuant tr:hover{
        background-color: lightskyblue;
    }
    .cpcLocalQuant td{
        padding: 6px;
        border:1px solid lightgray;
        text-align: left;
    }
    .cpcLocalQuant th{
        padding: 6px;
        border:1px solid darkgray;
        font-weight: bold;
        background-color: lightgray;
        text-align: left;
        width:120px;
    }
</style>


<div style="border:none; border-radius: 0px; height:840px;overflow: hidden;">
 
    <div  style="border:1px solid lightgray;padding:5px;height:828px; overflow:auto;width:fit-content;">

        <h1>Textdefault Overview </h1>
        <div style="padding:8px;">
            <b>Kurzanleitung</b><br>
            Die Textbausteine können in der rechten Spalte für den ausgewählten Auftrag abgeändert werden.<br>
            Löscht man den ganzen Text aus den Textbaustein und speichert dann, wird der Default-Text (der in der Datenbank hinterlegt ist) wieder angezeigt.
            Möchte man einen Textbaustein im ausgewählten Auftrag ganz löschen, schreibt man ein <b>@</b> in das Feld.<br> Nach dem speichern wird dieser Textbaustein dann nicht mehr angezeigt.
     
        </div>
        <form action="/saveTBProject" method="post">
            <input type="hidden" name="ppid" value="{{ $data['pp']->PPProduktpass_Id }}">
            <button type="submit">Speichern</button>
        <div style="display:grid;  grid-auto-rows: 200px; grid-template-columns:200px 600px; grid-gap: 4px; border: 1px solid darkblue; border-radius: 0px; height:660px; overflow: auto;">
            @foreach ($data['tbs'] as $tb)
            <div style="border:1px solid gray; padding:8px; border-radius: 0px;">{{ $tb['art'] }}</div> 
            <div  style="@if (strlen($tb['userdefined']) > 0 ) border:1px solid gray; @else border:1px solid gray; @endif padding:8px; border-radius: 0px;padding: 0px;">
                <textarea name="tbs[{{ $tb['id'] }}]" style="resize: none; border:none;padding:8px;margin: 0px; width:100%;height:100%;">@if (strlen($tb['userdefined']) > 0 ){{  $tb['userdefined'] }} @else{{  $tb['text'] }}@endif</textarea>
            </div> 
            @endforeach
        </div>
    </form>
    </div>

</div>

