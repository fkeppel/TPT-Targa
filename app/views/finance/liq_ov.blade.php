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
        border: 2px solid lightgray;
        height: 20px;
        display: table-cell;
        width:100px;
        padding:4px;
        border-radius: 0px;
        vertical-align: top;
    }

    .liq_cellr {
        text-align: right;
        padding-right:4px;
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
        width: 110px;
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

<div style = "width:1610px;padding:0 20 0 20 px;text-align:left;margin:0 auto;border:1px solid lightgray; height: 970px;">
    <h3>{{$data['Header']}}</h3>
    <div style="border:none; height: 40px;">
        {{Form::open(array('url' => '/showLiq', 'method' => 'POST'))}}﻿
        {{Form::hidden('IsPost', 1)}}
        <div style="float: left;width:300px;">
            Ausmusterung: {{Form::text('search_ausmusterung', $data['inp']['search_ausmusterung'])}}
        </div>
        <div style="float: left;width:300px;">

            Suchbegriff: {{Form::text('search', $data['inp']['search'],array('id'=>'iSearch'))}}

        </div>
        <div style="float: left;width:100px;">
            {{ Form::submit('select', array('class'=>'liq_submit'))}}
        </div>
        <div style="float: left;width:100px;">

            {{Form::button('clear',array('class'=>'liq_submit', 'onclick'=>"clear_search('iSearch');"))}}
        </div>
        <div style="clear:both;">&nbsp;</div>
        {{ Form::close()}}
    </div>
    <div style="border:none;width:1600px;height:850px;">
        <div style="border:none; height: 30px;padding:0;margin:0 auto;">
            {{Form::open(array('url' => '/saveLiq', 'method' => 'POST'))}}﻿
            {{Form::hidden('IsPost', 1)}}
            {{Form::hidden('search_ausmusterung', $data['inp']['search_ausmusterung'])}}
            {{Form::hidden('search', $data['inp']['search'])}}
            {{ Form::submit('speichern', array('style'=>'border:1px solid gray;',' class'=>'liq_submit'))}}
        </div>
        <div style = "width: 1600px;float: left; border:none;height:830px;padding:0px;overflow: auto;">



            <div class = "liq_container" style="width:3500px;border:1px solid lightgray;padding: 10px;overflow: auto;">
                <div class = "liq_row">
                    <div class = "liq_cellh" style = "width:20px;">Mark</div>
                    <div class = "liq_cellh" style = "width:40px;">AM</div>
                    <div class = "liq_cellh" style = "width:60px;">TOP</div>
                    <div class = "liq_cellh" style = "">LC</div>
                    <div class = "liq_cellh" style = "">Bemerkung</div>
                    <div class = "liq_cellh lic_cellr" style = "width:85px;">Betrag bezahlt</div>
                    <div class = "liq_cellh" style = "width:85px;">Bezahlt am</div>
                    <div class = "liq_cellh" style = "width:40px;">L/C-Nr.</div>
                    <div class = "liq_cellh" style = "width:200px;">Produzent</div>
                    <div class = "liq_cellh" style = "">Land</div>
                    <div class = "liq_cellh" style = "width:40px;">IAN</div>
                    <div class = "liq_cellh" style = "width:300px;">Artikelbezeichnung</div>
                    <div class = "liq_cellh" style = "width:20px;">EK </div>
                    <div class = "liq_cellh" style = "">Währung</div>
                    <div class = "liq_cellh" style = "">Menge-Gesamt</div>
                    <div class = "liq_cellh" style = "">EK-Gesamt</div>
                    <div class = "liq_cellh liq_cellr" style = "width:40px;">FOB</div>
                    <div class = "liq_cellh" style = "">ZZ-Tage</div>
                    <div class = "liq_cellh" style = "">Bemerkung</div>
                    <div class = "liq_cellh" style = "">L/C Eröffnung Monat</div>
                    <div class = "liq_cellh" style = "">L/C Eröffnung Alternativ</div>
                    <div class = "liq_cellh" style = "">Kurs Kalkuliert</div>
                    <div class = "liq_cellh" style = "">sichern zum</div>
                    <div class = "liq_cellh" style = "">Kurs gesichert</div>
                    <div class = "liq_cellh" style = "">Andienung Dokumente</div>
                    <div class = "liq_cellh" style = "width:70px;">Fälligkeit</div>
                    <div class = "liq_cellh" style = "width:70px;">Zahlung Kunde</div>
                    <div class = "liq_cellh liq_cellr" style = "width:50px;">VK in EUR</div>
                    <div class = "liq_cellh liq_cellr" style = "width:50px;">VK-Gesamt</div>
                    <div class = "liq_cellh liq_cellr" style = "width:50px;">DB-I (Wert)</div>
                    <div class = "liq_cellh liq_cellr" style = "width:40px;">DB-I (%)</div>
                    <div class = "liq_cellh liq_cellr" style = "width:20px;">Mark</div>
                </div>
                <?php $pos = 0; ?>
                @foreach ($data['liqs'] as $liq)
                <?php $pos++; ?>
                <div class = "liq_row" id="row_{{$pos}}"  style="">
                    <div class = "liq_cell" style = "width:20px;">
                        <button type="button" id="btnM_{{$pos}}" style="" onclick="mark_row({{$pos}});">M</button>
                        <button type="button"  id="btnU_{{$pos}}" style="display: none;" onclick="unmark_row({{$pos}});">U</button>
                    </div>
                    <div class = "liq_cell" style = "width:40px;">{{substr($liq->Ausmusterung,0,4)}}</div>
                    <div class = "liq_cell" style = "width:60px;">{{$liq->TOP}}</div>
                    <div class = "liq_celli" style = "">
                        {{Form::text('Liq['.$pos.'][LC]',$liq->LC)}}
                        {{Form::hidden('LiqIds['.$pos.'][ZId]',$liq->ZId)}}
                        {{Form::hidden('MaxPos', $pos)}}
                        {{Form::hidden('Liq['.$pos.'][PPProduktpass_Id]',$liq->PPProduktpass_Id)}}
                    </div>
                    <?php
                    $colBez = "";
                    if (isset($liq->BezahltAm))
                        $colBez = "background-color:" . $colorBlue . ";";
                    $kurs = 1;
                    $kurs_error = false;
                    $col = "";
                    if ($liq->EKWaehrung != 'EUR') {
                        $kurs = $liq->KursGesichert != 0 ? $liq->KursGesichert : $liq->KursKalkuliert;
                        if ($kurs == 0) {
                            $kurs = 1;
                            $kurs_error = true;
                            $col = "background-color:#33ffff;color:black;";
                        }
                    }
                    $EKinEUR = $liq->EKGesamt * $kurs;
                    ?>
                    <div class = "liq_celli" style = "width:250px;"><textarea name="Liq['.$pos.'][BezahltBemerkung]" style="width:250px;height:44px;border:none;">{{$liq->BezahltBemerkung}}</textarea></div>
                    <div class = "liq_celli liq_cellr" style = "{{$colBez}}width:85px;">
                        <?php $val = $liq->Betrag == 0 ? $val = '' : number_format($liq->Betrag, 2, ',', '.'); ?>
                        {{Form::text('Liq['.$pos.'][Betrag]',$val, array('style'=>'text-align:right;padding-right:4px;width:80px;'.$colBez))}}</div>
                    <div class = "liq_celli" style = "{{$colBez}}width:85px;">
                        {{Form::text('Liq['.$pos.'][BezahltAm]',$liq->BezahltAm, array('style'=>'width:80px;'.$colBez))}}</div>
                    <div class = "liq_celli" style = "width:40px;">{{Form::text('Liq['.$pos.'][Nummer]',$liq->Nummer,array("style" => "width:40px;text-align:right;padding-right:4px;"))}}</div>
                    <?php
                    $colFW = "background-color:" . $colgreen . ";";
                    if ($liq->EKWaehrung != 'EUR')
                        $colFW = "background-color:yellow;";
                    ?>
                    <div class = "liq_cell" style = "{{$colFW}}">{{substr($liq->Produzent,0,30)}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Land}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}width:40px;"><a href="show/{{$liq->PPId}}" target="_blank"><b>[{{$liq->IAN}}]</b> </a> </div>
                    <div class = "liq_cell" style = "{{$colFW}}width:300px;">{{substr($liq->Artikelbezeichnung,0,70)}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->EK}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->EKWaehrung}}</div>
                    <div class = "liq_cell liq_cellr" style = "{{$colFW}}">{{number_format($liq->MengeGesamt,0,",",".")}}</div>
                    <div class = "liq_cell liq_cellr" style = "{{$colFW}}{{$col}}">{{number_format($EKinEUR,2,",",".")}}</div>
                    <div class = "liq_cell liq_cellr" style = "width:40px;">{{$liq->LT}}</div>
                    <div class = "liq_cell" style = "">{{$liq->Zahlungsziel}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][Bemerkung]',$liq->Bemerkung)}}</div>
                    <?php if ($liq->LCEroeffnung = '000-00-00') $liq->LCEroeffnung = ''; ?>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][LCEroeffnung]',$liq->LCEroeffnung)}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][LCEroeffnungAlternativ]',$liq->LCEroeffnungAlternativ)}}</div>
                    <div class = "liq_cell liq_cellr" style = "">{{number_format($liq->KursKalkuliert,4,',','.')}}</div>

                    <div class = "liq_cell liq_cellr" style = "">{{substr($liq->KursGesichertAm,0,10)}}</div>
                    <div class = "liq_cell liq_cellr" style = "">{{number_format($liq->KursGesichert,4,',','.')}}</div>
                    <div class = "liq_celli" style = "">{{Form::text('Liq['.$pos.'][Andienung]',$liq->Andienung)}}</div>
                    <div class = "liq_cell" style = "">{{$liq->Faelligkeit}}</div>
                    <div class = "liq_cell" style = "width:50px;">{{$liq->ZahlungKunde}}</div>
                    <div class = "liq_cell liq_cellr" style = "width:50px;">{{number_format($liq->VKinEUR,2,',','.')}}</div>
                    <div class = "liq_cell liq_cellr" style = "width:50px;">{{number_format(($liq->VKGesamt),2,',','.')}}</div>
                    <div class = "liq_cell liq_cellr" style = "width:50px;">{{number_format(($liq->VKGesamt-$EKinEUR),2,',','.')}}</div>
                    <?php
                    if ($liq->VKGesamt == 0) {
                        $dbProz = 0;
                    } else {
                        $dbProz = $liq->VKGesamt - $liq->EKGesamt > 0 ? ($liq->VKGesamt - $liq->EKGesamt) * 100 / $liq->VKGesamt : 0;
                    }
                    If ($dbProz < 8)
                        $col = "background-color:red;color:white;";
                    If ($dbProz >= 8 and $dbProz < 30)
                        $col = "background-color:green;color:white;";
                    If ($dbProz > 30)
                        $col = "background-color:orange;color:black;";
                    If ($kurs_error)
                        $col = "background-color:#33ffff;color:black;"
                        ?>

                    <div class = "liq_cellr" style = "{{$col}} width:40px;">{{number_format($dbProz,1,",",".")}}</div>
                    <div class = "liq_cell" style = "width:20px;">
                        <button type="button" id="btn2M_{{$pos}}" style="" onclick="mark_row({{$pos}});">M</button>
                        <button type="button"  id="btn2U_{{$pos}}" style="display: none;" onclick="unmark_row({{$pos}});">U</button>
                    </div>
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
    btnId = "#btn2M_" + row;
    $(btnId).css({display:'none'});
    btnId = "#btn2U_" + row;
    $(btnId).css({display:'inline'});
    $(elemId).css({border:'3px solid blue'});
    }

    function unmark_row(row) {

    elemId = "#row_" + row;
    btnId = "#btnU_" + row;
    $(btnId).css({display:'none'});
    btnId = "#btnM_" + row;
    $(btnId).css({display:'inline'});
    btnId = "#btn2U_" + row;
    $(btnId).css({display:'none'});
    btnId = "#btn2M_" + row;
    $(btnId).css({display:'inline'});
    $(elemId).css({border:'0px'});
    }

</script>