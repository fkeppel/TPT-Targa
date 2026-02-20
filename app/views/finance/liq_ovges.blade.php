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
$dataAll = array();
?>

<div style = "width:1610px;padding:20px;text-align:left;margin:0 auto;border:1px solid blue; height: 940px;">


    <div style="overflow: auto; height:890px;border:1px solid red;padding:10px;">

        <div style="float:left;">
            <h3>{{$data['HeaderDTK']}}</h3>
            <div class = "liq_container" style="width:400px;border:1px solid lightgray;padding: 40px;;">
                <div class = "liq_row">
                    <div class = "liq_cellh" style = "">Periode</div>
                    <div class = "liq_cellh" style = "">Abgang DTK [EUR]</div>
                    <div class = "liq_cellh" style = "">Zugang DTK [USD]</div>
                </div>
                <?php $pos = 0; ?>
                @foreach ($data['dtks'] as $dtk)
                <?php
                $pos++;
                $dataAll[$dtk->Jahr . '/' . str_pad($dtk->Monat, 2, '0', STR_PAD_LEFT)]['Z_DTK_USD'] = $dtk->ZugangUSD;
                $dataAll[$dtk->Jahr . '/' . str_pad($dtk->Monat, 2, '0', STR_PAD_LEFT)]['A_DTK_EUR'] = $dtk->AbgangEUR;
                ?>
                <div class = "liq_row" id="row_{{$pos}}"  style="">
                    <?php ?>
                    <div class = "liq_cell" style = "width:60px;">{{$dtk->Jahr}}/{{str_pad($dtk->Monat, 2 ,'0', STR_PAD_LEFT)}}</div>
                    <div class = "liq_cellr" style = "width:60px;">{{number_format($dtk->ZugangUSD,2,',','.')}}</div>
                    <div class = "liq_cellr" style = "width:60px;">{{number_format($dtk->AbgangEUR,2,',','.')}}</div>
                </div>
                @endforeach
            </div>
        </div>
        <div style="float:left;margin-left:20px;">
            <h3>{{$data['HeaderZufluss']}}</h3>

            <div class = "liq_container" style="width:400px;border:1px solid lightgray;padding: 40px;overflow: auto;">
                <div class = "liq_row">
                    <div class = "liq_cellh" style = "">Periode</div>
                    <div class = "liq_cellh" style = "">Zufluss Zahlung Kunde [EUR]</div>

                </div>
                <?php $pos = 0; ?>
                @foreach ($data['zus'] as $zu)
                <?php
                $pos++;
                $dataAll[$zu->PJahr . '/' . str_pad($zu->PMonat, 2, '0', STR_PAD_LEFT)]['Z_KD_EUR'] = $zu->Zufluss;
                ?>
                <div class = "liq_row" id="row_{{$pos}}"  style="">
                    <div class = "liq_cell" style = "width:60px;">{{$zu->PJahr}}/{{str_pad($zu->PMonat, 2 ,'0', STR_PAD_LEFT)}}</div>
                    <div class = "liq_cellr" style = "width:60px;">{{number_format($zu->Zufluss,2,',','.')}}</div>
                </div>
                @endforeach
            </div>
        </div>


        <div style="float:left; margin-left:20px;">

            <h3>{{$data['HeaderAbfluss']}}</h3>

            <div class = "liq_container" style="width:600px;border:1px solid lightgray;padding: 40px;overflow: auto;">
                <div class = "liq_row">
                    <div class = "liq_cellh" style = "">Periode</div>
                    <div class = "liq_cellh" style = "">Abfluss Zahlung Lieferant [EUR]</div>
                    <div class = "liq_cellh" style = "">Abfluss Zahlung Lieferant [USD]</div>

                </div>
                <?php $pos = 0; ?>
                @foreach ($data['abs'] as $ab)
                <?php
                $pos++;
                $dataAll[$ab->Jahr . '/' . str_pad($ab->Monat, 2, '0', STR_PAD_LEFT)]['A_LIEF_EUR'] = $ab->EUR;
                $dataAll[$ab->Jahr . '/' . str_pad($ab->Monat, 2, '0', STR_PAD_LEFT)]['A_LIEF_USD'] = $ab->USD;
                ?>
                <div class = "liq_row" id="row_{{$pos}}"  style="">
                    <div class = "liq_cell" style = "width:60px;">{{$ab->Jahr}}/{{str_pad($ab->Monat, 2 ,'0', STR_PAD_LEFT)}}</div>
                    <div class = "liq_cellr" style = "width:60px;">{{number_format($ab->EUR,2,',','.')}}</div>
                    <div class = "liq_cellr" style = "width:60px;">{{number_format($ab->USD,2,',','.')}}</div>
                </div>
                @endforeach
            </div>
        </div>
        <div style="clear:both;"></div>
        <h3>Gesamtübersicht</h3>
        <div class = "liq_container" style="width:1500px;border:1px solid lightgray;padding: 40px;overflow: auto;">
            <div class = "liq_row">
                <div class = "liq_cellh" style = "">Periode</div>
                <div class = "liq_cellh" style = "">Zufluss DTK [USD]</div>
                <div class = "liq_cellh" style = "">Abfluss DTK [EUR]</div>
                <div class = "liq_cellh" style = "">Zufluss Zahlung Kunde [EUR]</div>
                <div class = "liq_cellh" style = "">Abfluss Zahlung Lieferant [USD]</div>
                <div class = "liq_cellh" style = "">Abfluss Zahlung Lieferant [EUR]</div>
                <div class = "liq_cellh" style = "">Summe [USD]</div>
                <div class = "liq_cellh" style = "">Summe [EUR]</div>
            </div>


            <?php
            $pos = 0;
            $sumUSD = 0;
            $sumEUR = 0;
            $sumTotalUSD = 0;
            $sumTotalEUR = 0;
            ?>

            @foreach ($dataAll as $periode => $da)

            <?php
            $pos++;
            $Z_DTK_USD = !isset($da['Z_DTK_USD']) ? 0 : $da['Z_DTK_USD'];
            $A_DTK_EUR = !isset($da['A_DTK_EUR']) ? 0 : $da['A_DTK_EUR'];
            $A_LIEF_USD = !isset($da['A_LIEF_USD']) ? 0 : $da['A_LIEF_USD'];
            $A_LIEF_EUR = !isset($da['A_LIEF_EUR']) ? 0 : $da['A_LIEF_EUR'];
            $Z_KD_EUR = !isset($da['Z_KD_EUR']) ? 0 : $da['Z_KD_EUR'];

            $sumUSD += $Z_DTK_USD;
            $sumUSD -= $A_LIEF_USD;
            $sumEUR -= $A_DTK_EUR;
            $sumEUR += $Z_KD_EUR;
            $sumEUR -= $A_LIEF_EUR;
            $sumTotalUSD += $sumUSD;
            $sumTotalEUR += $sumEUR;
            ?>

            <div class = "liq_row" id="row_{{$pos}}"  style="">
                <div class = "liq_cell" style = "width:60px;">{{$periode}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($Z_DTK_USD,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($A_DTK_EUR,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($Z_KD_EUR,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($A_LIEF_EUR,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($A_LIEF_USD,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($sumUSD,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($sumEUR,2,',','.')}}</div>
            </div>

            <?php
            $sumUSD = 0;
            $sumEUR = 0;
            ?>

            @endforeach
            <div class = "liq_row" id="row_{{$pos}}"  style="">
                <div class = "liq_cell" style = "width:60px;">Summe</div>
                <div class = "liq_cellr" style = "width:60px;"></div>
                <div class = "liq_cellr" style = "width:60px;"></div>
                <div class = "liq_cellr" style = "width:60px;"></div>
                <div class = "liq_cellr" style = "width:60px;"></div>
                <div class = "liq_cellr" style = "width:60px;"></div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($sumTotalUSD,2,',','.')}}</div>
                <div class = "liq_cellr" style = "width:60px;">{{number_format($sumTotalEUR,2,',','.')}}</div>
            </div>
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