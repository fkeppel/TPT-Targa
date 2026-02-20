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

        {{ Form::close()}}
    </div>

    <div style="border:1px solid orange;width:1600px;height:850px;padding:0px;overflow:auto; text-align:left;padding-left:10px;">





        <div class = "liq_container" style="width:1570px;border:0px solid red;padding: 0px;overflow: auto; ">
            <div class = "liq_row" style="border:none;">
                <div class = "liq_cellh" style = "width:40px;"><b>Header</b></div>
                <!--div class = "liq_cellh" style = "width:60px;">Inquiry Neu</div-->
                <div class = "liq_cellh" style = "width:150px;"><b>Value1</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value2</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value3</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value4</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value5</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value6</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value7</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value8</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value9</b></div>
                <div class = "liq_cellh" style = "width:150px;"><b>Value10</b></div>
            </div>
            @foreach ($data['Diffs'] as $d)
            <div class = "liq_row" style="border:none;">
                <div class = "liq_cell" style = "width:40px;"><b>{{$d['PPInquiryDiff_Header']}}</b></div>
                <!--div class = "liq_cellh" style = "width:60px;">Inquiry Neu</div-->
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_1']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_2']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_3']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_4']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_5']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_6']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_7']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_8']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_9']}}</div>
                <div class = "liq_cell" style = "width:150px;">{{$d['VA_10']}}</div>
            </div>
            <div class = "liq_row" style="border:none;">
                <div class = "liq_cell" style = "width:40px;"></div>
                <!--div class = "liq_cellh" style = "width:60px;">Inquiry Neu</div-->
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    $col[$i] = "black";
                    if ($d['VA_' . $i] != $d['VB_' . $i]) {
                        $col[$i] = "red";
                    }
                }
                ?>
                @foreach($col as $cnt => $val)
                <div class = "liq_cell" style = "width:150px;color: {{$col[$cnt]}}">{{$d['VB_'.$cnt]}}</div>
                @endforeach
            </div>
            @endforeach
        </div>


    </div>
</div>

<script>
</script>