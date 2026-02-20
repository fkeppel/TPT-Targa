<style>
    .dtk_container {

        border: 1px  solid lightgray;
        border-radius: 0px;
        display: table;
        font-size: 12px;

    }
    .dtk_row {
        display:table-row;
        border:1px solid lightgray;
        margin-top:5px;
    }
    .dtk_cell,  .dtk_cellr, .dtk_cellh{
        border: 1px solid lightgray;
        height: 20px;
        display: table-cell;
        width:120px;
        border-radius:0px;
        padding:4px;
    }

    .dtk_cellr {
        text-align: right;
    }
    .dtk_cellh {
        background-color: orange;
    }
    .dtk_labelcell {

        border: none;
        border-radius: 0px;
        width: 100px;
        display: table-cell;
        padding-left: 5px;
        background-color: orange;
        font-weight: bold;
    }
    .dtk_container input {
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

    .dtk_container select {
        border: none;
        height: 24px;
        width: 110px;

    }
    .dtk_submit {
        border: 1px solid blueviolet;
        display: table-cell;
    }
</style>



<div style = "width:1610px;padding:20px;text-align:left;margin:0 auto;border:1px solid lightgray; height: 900px;">

    <h3>Devisen-Termin-Käufe</h3>

    <div style="width: 1420px;float: left; border:1px solid lightgray;height:800px;padding:10px;">
        <div class="dtk_container">
            <div class="dtk_row">
                <div class="dtk_cellh" style="">Bank</div>
                <div class="dtk_cellh" style="">Referenz</div>
                <div class="dtk_cellr, dtk_cellh" style="">Betrag</div>
                <div class="dtk_cellr, dtk_cellh" style="">Offen</div>
                <div class="dtk_cellr, dtk_cellh" style="">Kurs</div>
                <div class="dtk_cellr, dtk_cellh" style="">Termin</div>
                <div class="dtk_cellh" style="">Status</div>
                <div class="dtk_cellh" style="">Aktion</div>
            </div>
            @foreach ($data['dtks'] as $dtk)
            <div class="dtk_row">
                <div class="dtk_cell" style="">
                    {{$dtk->PPDevisenTerminKaeufe_Bank}}
                </div>
                <div class="dtk_cell" style="">
                    {{$dtk->PPDevisenTerminKaeufe_Referenz}}
                </div>
                <div class="dtk_cellr" style="">
                    {{ number_format($dtk->PPDevisenTerminKaeufe_Betrag,2,',','.') }}
                </div>
                <div class="dtk_cellr" style="">
                    {{ number_format($dtk->Offen,2,',','.') }}
                </div>
                <div class="dtk_cellr" style="">
                    {{ number_format($dtk->PPDevisenTerminKaeufe_Kurs,4,',','.')}}
                </div>
                <div class="dtk_cellr" style="">
                    {{ date_format(date_create($dtk->PPDevisenTerminKaeufe_Termin),'d.m.Y')}}
                </div>
                <div class="dtk_cell" style="">
                    {{$dtk->PPDevisenTerminKaeufe_Status}}
                </div>
                <div class="dtk_cell" style="">
                    {{Form::open(array('url' => '/showDTK', 'method' => 'POST'))}}﻿
                    {{Form::hidden('id',$dtk->PPDevisenTerminKaeufe_Id)}}
                    {{ Form::submit('anzeigen', array('style'=>'height:20px;width:100px;'))}}
                    {{ Form::close()}}
                </div>
            </div>
            @endforeach
        </div>
        {{Form::open(array('url' => '/showDTK', 'method' => 'POST'))}}﻿
        {{Form::hidden('id',-1)}}
        {{ Form::submit('Neuer Devisenterminkauf', array('style'=>'height:20px;width:200px;'))}}
        {{ Form::close()}}

    </div>
</div>