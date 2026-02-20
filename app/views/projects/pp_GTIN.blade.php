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


    .cpcLocalQuant {
        width:1530px;
        border:1px solid lightgray;
        border-radius: 0px;
        padding:10px;
        overflow: auto;
        height:760px;
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
<div>{{$data['message']}}</div>
<div style="border:none; border-radius: 0px; height:840px;overflow: hidden;padding-left:10px;">

    <p><b>Lokale Mengen</b></p>

    @if (isset($data['XML_lQ']['countries']))

    <div class="cpcLocalQuant">
        <table>
            <tr>
                <th>GTIN</th>
                <th>Style-No.</th>
                <th>Style</th>
                <th>Size</th>
                @foreach ($data['XML_lQ']['countries'] as $c => $lq)
                <th style="width: 50px;text-align: center;">{{$c}}</th>
                @endforeach
            </tr>
            @foreach ($data['XML_lQ']['values'] as $lq)
            <tr>
                <td>{{$lq['Style']['gtin']}}</td>
                <td>{{$lq['Style']['styleNo']}}</td>
                <td>{{$lq['Style']['style']}}</td>
                <td>{{$lq['Style']['size']}}</td>
                @foreach ($data['XML_lQ']['countries'] as $c => $country)
                <?php
                $bglq = "";
                if ($lq[$c] > 0) {
                    $bglq = "background-color: lightblue;";
                }
                ?>
                <td style="text-align: center; {{$bglq}}">{{$lq[$c]}}</td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>

    @endif

</div>

