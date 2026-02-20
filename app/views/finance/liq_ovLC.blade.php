<style>
    .liq_container {
        color:black;
        font-family: tahoma, arial, sans-serif;
        border: 1px solid lightgray;
        border-radius: 0px;
        display: table;
        font-size: 12px;
        width:100%;

    }
    .liq_row {
        display:table-row;
        border:1px solid lightgray;
        margin-top:5px;
    }
    .liq_rowh {
        display:table-row;
        border:10px solid lightgray;
        margin-top:5px;
        background-color: orange;
    }
    .liq_cell, .liq_cellr, .liq_cellh, .liq_celli{
        border: 1px solid lightgray;
        height: 20px;
        display: table-cell;
        width:80px;
        padding:4px;
        border-radius: 0px;
        background-color: transparent;
    }

    .liq_cellr {
        text-align: right;
    }

    .liq_celli {
        padding:0px;
        background-color: #FFF;

    }

    .liq_cellh{
        background-color: orange;
    }

    .liq_labelcell {

        border: none;
        border-radius: 0px;
        width: 100px;
        display: table-cell;
        padding-left: 5px;
        background-color: orange;
        font-weight: bold;
    }
    .liq_container input {
        color:black;
        font-size: 12px;
        border:none;
        width: 80px;
        height:100%;
        height: 24px;
        padding-left:4px;
    }

    .inputr{

        text-align: right;
        padding-right:5px;
    }

    .liq_container select {
        border: none;
        height: 24px;
        width: 110px;

    }
    .liq_submit {
        border: 1px solid blueviolet;
        display: table-cell;
    }

    .liq_row input{
        background-color: #FFF;


    }
</style>

<?php
$colgreen = '#66cc00';
$colorBlue = "lightblue";
?>

<div style = "width:1610px;padding:20px;text-align:left;margin:0 auto;border:1px solid lightgray; height: 935px;">

    <h3>{{$data['Header']}}</h3>

    <div style="border:none;">
        {{Form::open(array('url' => '/showLC', 'method' => 'POST'))}}﻿
        {{Form::hidden('IsPost', 1)}}
        Ausmusterung: {{Form::text('search_ausmusterung', $data['inp']['search_ausmusterung'])}}
        Suche: {{Form::text('search', $data['inp']['search'],array('id'=>'iSearch'))}}
        Nur noch nicht eröffnete LC <input type="checkbox" name="LCAll" value="{{$data['inp']['LCAll']}}" @if ($data['inp']['LCAll'])checked='checked'@endif />
                                           {{ Form::submit('select', array('class'=>'liq_submit'))}}
                                           {{Form::button('clear',array('onclick'=>"clear_search('iSearch');"))}}
                                           {{ Form::close()}}
    </div>
    <div style="border:1px solid orange;width:1600px;height:850px;">
        <div style="border:1px solid red;">
            {{Form::open(array('url' => '/saveLiq', 'method' => 'POST'))}}﻿
            {{Form::hidden('IsPost', 1)}}
            {{Form::hidden('IsLC', 1)}}
            {{Form::hidden('search_ausmusterung', $data['inp']['search_ausmusterung'])}}
            {{Form::hidden('search', $data['inp']['search'])}}
            {{ Form::submit('speichern', array('class'=>'liq_submit'))}}
        </div>
        <div style = "width: 1575px;float: left; border:1px solid blue;height:805px;padding:0px;overflow: auto;">



            <div class = "liq_container" style="width:2400px;border:1px solid lightgray;padding: 40px;overflow: auto;">
                <div class = "liq_row">
                    <div class = "liq_cellh" style = "width:30px;">Mark</div>
                    <div class = "liq_cellh" style = "width:60px;">AM</div>
                    <div class = "liq_cellh" style = "width:120px;">Projekt</div>
                    <div class = "liq_cellh" style = "width:300px;">Artikelbezeichnung</div>
                    <div class = "liq_cellh" style = "width:200px;">Produzent</div>
                    <div class = "liq_cellh" style = "">Land</div>
                    <div class = "liq_cellh" style = "">FOB</div>
                    <div class = "liq_cellh" style = "">ZZ-Tage</div>
                    <div class = "liq_cellh" style = "">EK Waehrung</div>
                    <div class = "liq_cellh liq_cellr" style = "">EK-Gesamt</div>
                    <div class = "liq_cellh liq_cellr" style = "">Kurs Kalkuliert</div>
                    <div class = "liq_cellh" style = "">sichern zum</div>
                    <div class = "liq_cellh liq_cellr" style = "">Kurs gesichert</div>
                    <div class = "liq_cellh" style = "">LC</div>
                    <div class = "liq_cellh" style = "width:40px;">L/C-Nr.</div>
                    <div class = "liq_cellh" style = "">Bemerkung</div>
                    <div class = "liq_cellh" style = "">L/C Eröffnung Monat</div>
                    <div class = "liq_cellh" style = "">L/C Eröffnung Alternativ</div>
                    <div class = "liq_cellh" style = "">Andienung Dokumente</div>
                    <div class = "liq_cellh" style = "">Fälligkeit</div>
                    <div class = "liq_cellh" style = "">Zahlung Kunde</div>

                </div>
                <?php $pos = 0; ?>
                @foreach ($data['liqs'] as $liq)
                <?php
                $colFW = "background-color:" . $colgreen . ";";
                if ($liq->EKWaehrung != 'EUR') {
                    $colFW = "background-color:yellow;";
                }
                $pos++;
                ?>
                {{Form::hidden('LiqIds['.$pos.'][ZId]',$liq->ZId)}}
                {{Form::hidden('MaxPos', $pos)}}
                {{Form::hidden('Liq['.$pos.'][PPProduktpass_Id]',$liq->PPProduktpass_Id)}}

                <div class = "liq_row" id="row_{{$pos}}"  style="">
                    <div class = "liq_cell" style = "width:30px;">
                        <button type="button" id="btnM_{{$pos}}" style="" onclick="mark_row({{$pos}});">M</button>
                        <button type="button"  id="btnU_{{$pos}}" style="display: none;" onclick="unmark_row({{$pos}});">U</button>
                    </div>
                    <div class = "liq_cell" style = "{{$colFW}}width:60px;">{{substr($liq->Ausmusterung,0,4)}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}width:60px;"> <a href="show/{{$liq->PPId}}" target="_blank"><b>[{{$liq->IAN}}]</b> </a> {{$liq->Projekt}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{substr($liq->Artikelbezeichnung,0,50)}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{substr($liq->Produzent,0,30)}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Land}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->LT}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Zahlungsziel}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->EKWaehrung}}</div>
                    <div class = "liq_cell  liq_cellr" style = "{{$colFW}}">{{number_format($liq->EKGesamt,2,",",".")}}</div>
                    <div class = "liq_cell  liq_cellr" style = "{{$colFW}}">{{$liq->KursKalkuliert}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->KursGesichertAm}}</div>
                    <div class = "liq_cell   liq_cellr" style = "{{$colFW}}">{{$liq->KursGesichert}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][LC]',$liq->LC,array('style'=>'width:150px;'))}}</div>
                    <div class = "liq_celli" style = "width:40px;">{{Form::text('Liq['.$pos.'][Nummer]',$liq->Nummer,array("style" => "width:50px;text-align:right;padding-right:4px;"))}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][Bemerkung]',$liq->Bemerkung)}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][LCEroeffnung]',$liq->LCEroeffnung)}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][LCEroeffnungAlternativ]',$liq->LCEroeffnungAlternativ)}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][Andienung]',$liq->Andienung)}}</div>
                    <div class = "liq_cell" style = "">{{$liq->Faelligkeit}}</div>
                    <div class = "liq_cell" style = "width:50px;">{{$liq->ZahlungKunde}}</div>

                </div>
                @endforeach
            </div>
        </div>
        {{Form::close()}}
    </div>
</div>

<script>
    function clear_search(elem) {

    $('#' + elem).val('');
    return false;
    }

    function mark_row(row) {
    elemId = "#row_" + row;
    btnId = "#btnM_" + row;
    $(btnId).css({display:'none'});
    btnId = "#btnU_" + row;
    $(btnId).css({display:'inline'});
    $(elemId).css({border:'3px solid blue'});
    }

    function unmark_row(row) {

    elemId = "#row_" + row;
    btnId = "#btnU_" + row;
    $(btnId).css({display:'none'});
    btnId = "#btnM_" + row;
    $(btnId).css({display:'inline'});
    $(elemId).css({border:'0px'});
    }

</script>