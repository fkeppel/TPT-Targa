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
        vertical-align: top;
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
    <div style="border:none; height: 40px;">
        {{Form::open(array('url' => '/showOrderAll', 'method' => 'POST'))}}
        {{Form::hidden('IsPost', 1)}}
        <div style="float: left;width:300px;">
            Ausmusterung: <input type="text" name="search_ausmusterung" value="{{ $data['inp']['search_ausmusterung'] }}" > 
        </div>
        <div style="float: left;width:300px;">
            Suchbegriff: <input type="text" name="search" value="{{ $data['inp']['search'] }}" > 
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
        <div style = "width: 1595px;float: left; border:none;height:850px;padding:0px;overflow: auto;">
            <div class = "liq_container" style="width:1575px;border:1px solid lightgray;padding: 40px;overflow: auto;">
                <div class = "liq_row">
                    <!-- div class = "liq_cellh" style = "width:30px;">Mark</div -->
                    <div class = "liq_cellh" style = "width:30px;">AM</div>
                    <div class = "liq_cellh" style = "width:80px;">TOP</div>
                    <div class = "liq_cellh" style = "width:90px;">IAN</div>
                    <div class = "liq_cellh" style = "width:200px;">Artikelbezeichnung</div>
                    <div class = "liq_cellh" style = "width:200px;">Produzent</div>
                    <div class = "liq_cellh" style = "">Land</div>
                    <div class = "liq_cellh" style = "">FOB</div>
                    <div class = "liq_cellh" style = "">ZZ-Tage</div>
                    <div class = "liq_cellh" style = "">EK Waehrung</div>
                    <div class = "liq_cellh liq_cellr" style = "">EK-Gesamt</div>
                    <div class = "liq_cellh liq_cellr" style = "">Kurs Kalkuliert</div>
                    <div class = "liq_cellh" style = "">sichern zum</div>
                    <div class = "liq_cellh liq_cellr" style = "">Kurs gesichert</div>
                    <div class = "liq_cellh" style = "">Bild</div>
                </div>
                <?php $pos = 0; ?>
                @foreach ($data['liqs'] as $liq)
                <?php
                $colFW = "background-color:" . $colgreen . ";";
                if ($liq->EKWaehrung != 'EUR') {
                    $colFW = "background-color:white;";
                }
                $pos++;
                ?>
                <div class = "liq_row" id="row_{{$pos}}"  style="">
                    <!--div  class = "liq_cell" style = "width:30px;">
                        <button type="button" id="btnM_{{$pos}}" style="" onclick="mark_row({{$pos}});">M</button>
                        <button type="button"  id="btnU_{{$pos}}" style="display: none;" onclick="unmark_row({{$pos}});">U</button>
                    </div -->
                    <div class = "liq_cell" style = "{{$colFW}}width:60px;">{{substr($liq->Ausmusterung,0,4)}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}width:80px;">{{$liq->TOP}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}width:60px;"> <a href="show/{{$liq->PPId}}" target="_blank"><b>[{{$liq->IAN}}]</b> </a></div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Artikelbezeichnung}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Produzent}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Land}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->LT}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->Zahlungsziel}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{$liq->EKWaehrung}}</div>
                    <div class = "liq_cell  liq_cellr" style = "{{$colFW}}">{{number_format($liq->EKGesamt,2,",",".")}}</div>
                    <div class = "liq_cell  liq_cellr" style = "{{$colFW}}">{{$liq->KursKalkuliert}}</div>
                    <div class = "liq_cell" style = "{{$colFW}}">{{substr($liq->KursGesichertAm,0,10)}}</div>
                    <div class = "liq_cell   liq_cellr" style = "{{$colFW}}">{{$liq->KursGesichert}}</div>
                    <div class = "liq_celli" style = ""><a href="/data/uploads/{{$liq->Projektbild}}" target="_blank"><img src="/data/uploads/{{$liq->Projektbild}}"  style="width:80px;height:50px;"/></a></div>
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