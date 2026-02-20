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
        width:120px;
        padding:4px;
        border-radius: 0px;
        vertical-align:top;
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

<div style = "width:1610px;padding:20px;text-align:left;margin:0 auto;border:none; height: 935px;">

    <h3>{{$data['Header']}}</h3>

    <div style="border:none;">
        {{Form::open(array('url' => '/showInquiryAll', 'method' => 'POST', 'id' => 'InqForm'))}}﻿
        {{Form::hidden('IsPost', 1,array('id' => 'IsPost'))}}
        {{Form::hidden('sortButton', 'IAN')}}
        {{Form::hidden('sortDir', 'U')}}
        {{Form::hidden('sortChoise',"Datum.D",array('id' => 'sortChoise'))}}
        <div style="float:left;width:300px;">
            Ausmusterung: {{Form::text('search_ausmusterung', $data['inp']['search_ausmusterung'],array('id' => 'search_ausmusterung'))}}
        </div>
        <div style="float:left;width:250px;">
            Suche: {{Form::text('search', $data['inp']['search'],array('id'=>'iSearch'))}}
        </div>

        <div style="float:left;width:150px; height:35px; vertical-align: middle;">

            {{Form::hidden ("iIsBettwaesche",0)}}
            {{Form::label('iIsBettwaesche', 'Bettwäsche:')}}
            {{ Form::checkbox( 'iIsBettwaesche',1,$data['inp']['search_isbettwaesche'] ,array('id'=>'iIsBettwaesche', 'style'=>'width:25px;height:25px;'))  }}
        </div>
        <div style="float:left;width:120px; height:35px; ">
            {{Form::hidden ("iIsAndere",0)}}
            Andere:  {{ Form::checkbox( 'iIsAndere',1,$data['inp']['search_isandere'] ,array('id'=>'iIsAndere', 'style'=>'width:25px;height:25px;'))  }}
        </div>
        <div style="float:left;width:140px;">
            {{ Form::submit('select', array('class'=>'liq_submit','style' => 'width:120px; height:30px;'))}}
        </div>
        <div style="float:left;width:140px;">
            {{Form::button('clear',array('onclick'=>"clear_search('iSearch');",'style' => 'width:120px; height:30px;'))}}
        </div>
        {{ Form::close()}}
    </div>
    <div style="border:1px solid orange;width:1600px;height:850px;padding:0px;overflow:auto; text-align:left;padding-left:10px;">



        <div style="padding: 15px; margin-left:100px; ">
            <button onclick="js_checkAll();"  >Mark all</button>
            <button onclick="js_uncheckAll();"  >Unmark all</button>
            <button onclick="js_download();"  >Download marked Items</button>
        </div>


        <div class = "liq_container" style="width:1570px;border:0px solid red;padding: 0px;overflow: auto; ">
            <div class = "liq_row" style="border:none;">
                <div class = "liq_cellh" style = "width:40px;"><b>Mark</b></div>
                <!--div class = "liq_cellh" style = "width:60px;">Inquiry Neu</div-->
                <div class = "liq_cellh" style = "width:150px;"><b>Inquiry-Sheet erzeugen</b></div>
                <div class = "liq_cellh" style = "width:50px;"><b>Bettwäsche?</b></div>
                <div class = "liq_cellh" style = "width:50px;"><b>Projekt</b> {{$data['sort']['Projekt']}}</div>
                <!-- div class = "liq_cellh" style = "width:50px;"><b>Diff</b></div -->
                <div class = "liq_cellh" style = "width:200px;"><b>Produktpass ansehen</b>  {{$data['sort']['IAN']}}</div>
                <div class = "liq_cellh" style = "width:150px;"><b>QM-Sheet Download</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Inquiry-Sheet Download</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Inquiry-Sheet Datum</b></div>
                <div class = "liq_cellh" style = "width:70px;"><b>Ausmusterung</b>   {{$data['sort']['Ausmusterung']}}</div>
                <div class = "liq_cellh" style = "width:700px;"><b>Artikel</b>   {{$data['sort']['Artikel']}}</div>
                <div class = "liq_cellh" style = "width:100px;"><b>Datum</b> Upload   {{$data['sort']['Datum']}}</div>

            </div>
            <?php $pos = 0; ?>
            @foreach ($data['inqs'] as $pp)
            <?php $pos++; ?>

            <div class = "liq_row" id="row_{{$pos}}"  style="width:900px;border:none;">
                <div class = "liq_cell" >

                    <div style="float:left;width:35px;">
                        @if($data['display'][$pp['IAN']] == "")
                        <input style="width:25px;" type="checkbox" class="row_class" name="{{$pp['name']}}" id="{{$pp['file']}}" />
                        @endif
                    </div>
                </div>
                <div class = "liq_cell" style = "">
                    <div style="{{$data['display'][$pp['IAN']]}}">
                        <a href="/getExcelInquiry/{{$pp['IAN']}}/{{$pp['IsBett']}}"><div style="width:70px;height:20px;padding:4px;background-color:lightgrey;border:1px solid gray;text-align: center;vertical-align: middle;border-radius: 0px;">{{$pp['IAN']}}</div></a>
                    </div>
                </div>

                <div class = "liq_cell" style = "text-align:center;">
                    @if($pp['IsBett']) X @endif
                </div>
                <div class = "liq_cell" style = "text-align:center;">
                    {{$pp['Projekt']}}
                </div>

                <!-- div class = "liq_cell" style = "">
                    <a href="/getInquiryDiff/{{$pp['ppid']}}" target="_blank"><div style="width:50px;height:20px;padding:4px;background-color:lightgrey;border:1px solid gray;text-align: center;vertical-align: middle;border-radius: 0px;">{{$pp['MaxVersion']}}</div></a>
                </div -->
                <div class = "liq_cell" >
                    <a href="show/{{$pp['ppid']}}#tabs-9" target="_blank">{{$pp['IAN']}}</a>
                </div>
                <div class = "liq_cell" style = "">
                    <div style="{{$data['display'][$pp['IAN']]}}">
                        @if($pp['IsBett'])
                        <a href="/getExcelQM/{{$pp['IAN']}}/2"><div style="width:70px;height:20px;padding:4px;background-color:lightgrey;border:1px solid gray;text-align: center;vertical-align: middle;border-radius: 0px;">QM-Kalk</div></a>
                        @endif
                    </div>
                </div>
                <div class = "liq_cell"  >
                    <div style="{{$data['display'][$pp['IAN']]}}">
                        @if (strlen($pp['file'])>1)
                        <a href="/data/Inquiries/downloads/{{$pp['name']}}" target="_blank"><div style="width:70px;height:20px;padding:4px;background-color:lightgrey;border:1px solid gray;text-align: center;vertical-align: middle;border-radius: 0px;">Download</div></a>
                        @endif
                    </div>
                </div>
                <div class = "liq_cell"  >@if (strlen($pp['file'])>1){{$pp['FileDatum']}} @endif</div>
                <div class = "liq_cell" >{{$pp['Ausmusterung']}}</div>
                <div class = "liq_cell" >{{$pp['Bez']}}</div>
                <div class = "liq_cell" >{{substr($pp['Datum'],0,10)}}</div>

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

    function js_checkAll() {

        var rows = document.getElementsByClassName("row_class");
        for (var i = rows.length - 1; i >= 0; i--)
        {
            rows[i].checked = true;
        }

    }

    function js_uncheckAll() {

        var rows = document.getElementsByClassName("row_class");
        for (var i = rows.length - 1; i >= 0; i--)
        {
            rows[i].checked = false;
        }

    }

    function js_submit(att, ausm, search) {

        //alert(att);

        document.getElementById('IsPost').value = 1;
        document.getElementById('search_ausmusterung').value = ausm;
        document.getElementById('iSearch').value = search;
        document.getElementById('sortChoise').value = att;
        document.getElementById('InqForm').submit();

    }

    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds) {
                break;
            }
        }
    }

    function js_download(file, name) {
        var rows = document.getElementsByClassName("row_class");

        for (var i = rows.length - 1; i >= 0; i--)
        {
            if (i % 10 == 0) {
                alert("Weiter herunterladen?");
            }

            if (rows[i].id.length > 1) {
                if (rows[i].checked) {

                    var temporaryDownloadLink = document.createElement("a");
                    temporaryDownloadLink.style.display = 'none';
                    document.body.appendChild(temporaryDownloadLink);
                    temporaryDownloadLink.setAttribute('href', rows[i].id);
                    temporaryDownloadLink.setAttribute('download', rows[i].name);
                    temporaryDownloadLink.click();
                    document.body.removeChild(temporaryDownloadLink);
                }
            }
        }
    }


</script>