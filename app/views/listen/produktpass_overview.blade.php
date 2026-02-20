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
        padding:8px;
        border-radius: 0px;
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
<div style = "width:100%;padding:20px;text-align:left;margin:0 auto;border:1px solid lightgray; height: 935px;">
    <h3>Produktpass Übersicht</h3>
    <div style="border:none;">
        {{Form::open(array('url' => '/ppOverviewStart', 'method' => 'POST'))}}
        {{Form::hidden('IsPost', 1)}}
        Ausmusterung: <input type="text" name="search_ausmusterung" value="{{ $data['inp']['search_ausmusterung'] }}" />
        Suchkriterium: {{Form::text('search', $data['inp']['search'],array('id'=>'iSearch'))}}
        {{ Form::submit('select', array('class'=>'liq_submit'))}}
        {{Form::button('clear',array('onclick'=>"clear_search('iSearch');"))}}
        {{ Form::close()}}
    </div>
    <div style="border:1px solid orange;width:100%;height:840px;overflow: auto;">
        <div class = "liq_container" style="border:1px solid lightgray;padding: 40px;width:100%;">
            <div class = "liq_row">
                <!--div class = "liq_cellh" style = "width:60px;">Mark</div-->
                <div class = "liq_cellh" style = "">Ausmusterung</div>
                <div class = "liq_cellh" style = "">IAN</div>
                <div class = "liq_cellh" style = "">Liefertermin</div>
                <div class = "liq_cellh" style = "">EK-Wert</div>
                <div class = "liq_cellh" style = "">Artikel</div>
                <div class = "liq_cellh" style = "">Lieferant</div>
                <div class = "liq_cellh" style = "">Produktbild</div>
            </div>
            <?php $pos = 0; ?>
            @foreach ($data['pps'] as $pp)
            <?php $pos++; ?>
            <!--div class = "liq_row" id="row_{{$pos}}"  style="">
                <div class = "liq_cell" style = "width:60px;">
                    <button type="button" id="btnM_{{$pos}}" style="" onclick="mark_row({{$pos}});">M</button>
                    <button type="button"  id="btnU_{{$pos}}" style="display: none;" onclick="unmark_row({{$pos}});">U</button>
                </div-->
            <div class = "liq_row">
                <div class = "liq_cell" style = "">{{$pp->Ausmusterungnummer}}</div>
                <div class = "liq_cell" style = "">      <a href="/show/{{$pp->PPProduktpass_Id}}" target="_blank" style="text-decoration: none;color:#000;">
                        @if (strlen($pp->IAN)>6)
                        {{substr($pp->IAN,0,10)}}X
                        @else
                        <span style="font-size:12px; "><b>{{$pp->IAN}}</b></span>
                        @endif
                    </a></div>
                <div class = "liq_cell" style = "">{{$pp->LieferterminWoche}}/{{$pp->LieferterminJahr}}</div>
                <div class = "liq_cell" style = "type">{{number_format($pp->PO_Wert,0,',','.')}}</div>
                <div class = "liq_cell" style = "">{{$pp->Artikelbezeichnung}}</div>
                <div class = "liq_cell" style = "">{{$pp->Supplier}}</div>
                <div class = "liq_cell" style = ""><a href="/data/uploads/{{$pp->ProjektBild}}" target="_blank"><img src="/data/uploads/{{$pp->ProjektBild}}"  style="height:40px;"/></a></div>
            </div>
            @endforeach
        </div>
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
        $(btnId).css({display: 'none'});
        btnId = "#btnU_" + row;
        $(btnId).css({display: 'inline'});
        $(elemId).css({border: '3px solid blue'});
    }
    function unmark_row(row) {
        elemId = "#row_" + row;
        btnId = "#btnU_" + row;
        $(btnId).css({display: 'none'});
        btnId = "#btnM_" + row;
        $(btnId).css({display: 'inline'});
        $(elemId).css({border: '0px'});
    }
</script>