<style>
    .dtk_container {

        border: none;
        border-radius: 0px;
        display: table;
        font-size: 14px;

    }
    .dtk_row {
        display:table-row;
        border-radius: 0px;
        border:none;

    }
    .dtk_cell {
        border: 1px solid #e76b1f;
        border-radius: 0px;
        display: table-cell;
        padding: 0px;
        background-color: #99cc00;
    }


    .dtk_cellr {
        border: 1px solid #e76b1f;
        border-radius: 0px;
        display: table-cell;
        text-align: right;
        padding: 2px;
    }

    .dtk_cellNoInp {
        border: 1px solid #e76b1f;
        border-radius: 0px;
        display: table-cell;
        padding: 2px;

    }
    .dtk_cellNoInpr {
        border: 1px solid #e76b1f;
        display: table-cell;
        border-radius: 0px;
        padding: 2px;
        text-align: right;

    }
    .dtk_labelcell {

        border: 1px solid #e76b1f;
        border-radius: 0px;
        width: 100px;
        display: table-cell;
        padding-left: 5px;
        background-color: orange;
        font-weight: bold;
        vertical-align: top;
    }

    .dtk_container input, textarea{
        border:none;
        border-radius: 0px;
        width: 110px;
        height: 22px;
        padding-left:2px;
        background-color: #99cc00;
        font-size: 12px;
        margin:0;
        font-family: Tahoma, Arial, sans-serif;
        font-size: 12px;

    }

    .inputr{
        border:1px solid red;
        border-radius: 0px;
        text-align: right;
        padding-right:5px;
        border-radius: 0px;

    }

    .dtk_container select {
        border: none;
        height: 22px;
        width: 110px;
        background-color: #99cc00;
        margin:0px ;

    }
    .dtk_container input[Type='submit']  {
        border:1 px solid red;
        border-radius: 0px;
        width: 100px;
        display: table-cell;
        background-color: lightgrey;
    }

    .dtk_container form {
        border: none;
        margin:0px ;
    }

</style>

<div style = "width:1610px;padding:20px;text-align:left;margin:0 auto;border:1px solid blueviolet; height:930px;">


    {{Form::open(array('url' => '/saveDTK', 'method' => 'POST'))}}﻿
    {{Form::hidden('id',$data['dtk']['PPDevisenTerminKaeufe_Id'])}}

    <div style="width: 1420px;float: left; border:none;padding:10px;">

        <h3>Devisenterminkauf</h3>

        <div class="dtk_container" style="border:1px solid green; ">

            <div class="dtk_row">

                <div class="dtk_labelcell" style="">
                    Referenz:
                </div>
                <div class="dtk_cell" style="">
                    {{Form::text('DTK[Referenz]',$data['dtk']['PPDevisenTerminKaeufe_Referenz'],array('style' => 'width:240px;'))}}
                </div>
                <div class="dtk_labelcell" style="">
                    Bank:
                </div>
                <div class="dtk_cell" style="">
                    {{Form::select('DTK[Bank]',array("Bitte wählen..."=>"Bitte wählen...","Coba"=>"Coba", "NordLB"=>"NordLB","RealKurs"=>"RealKurs"),$data['dtk']['PPDevisenTerminKaeufe_Bank'])}}
                </div>
                <div class="dtk_labelcell" style="">
                    Wert:
                </div><div class="dtk_cell" style="">
                    {{Form::text('DTK[Betrag]',number_format($data['dtk']['PPDevisenTerminKaeufe_Betrag'],2,',','.'),array('class'=>'inputr'))}}
                </div>
                <div class="dtk_labelcell" style="">
                    Kurs:
                </div>
                <div class="dtk_cell" style="">
                    {{Form::text('DTK[Kurs]',number_format($data['dtk']['PPDevisenTerminKaeufe_Kurs'],4,',','.'),array('class'=>'inputr'))}}
                </div>
                <div class="dtk_labelcell" style="">
                    Termin:
                </div><div class="dtk_cell" style="">
                    {{Form::text('DTK[Termin]',date_format(date_create($data['dtk']['PPDevisenTerminKaeufe_Termin']),'d.m.Y'),array('class'=>'inputr'))}}
                </div>
            </div>
            <div class="dtk_row">
                <div class="dtk_labelcell" style="">
                    Bemerkung:
                </div>
                <div class="dtk_cell" style="height:60px;">
                    <textarea name='DTK[Bemerkung]' style="width:240px;height:60px;">{{$data['dtk']['PPDevisenTerminKaeufe_Bemerkung']}}</textarea>
                </div>
                <div class="dtk_labelcell" style="">

                </div>
                <div class="dtk_cell" style="">
                </div>
                <div class="dtk_labelcell" style="">
                </div><div class="dtk_cell" style="">
                </div>
                <div class="dtk_labelcell" style="">
                </div>
                <div class="dtk_cell" style="">
                </div>
                <div class="dtk_labelcell" style="">
                </div>
                <div class="dtk_cell" style="vertical-align:middle; text-align: center;">
                    {{ Form::submit('speichern', array('class'=>'dtk_submit'))}}
                </div>

            </div>
        </div>

        {{ Form::close()}}
        <div style="clear: both;">&nbsp;</div>

        <h3>Zuteilungen</h3>

        <div class="dtk_container" style="margin-top:20px;">

            <div class="dtk_row">

                <div class="dtk_labelcell" style="width:70px;">
                    IAN
                </div>
                <div class="dtk_labelcell" style="width:120px;">
                    Lieferant
                </div>
                <div class="dtk_labelcell" style="width:120px;">
                    Liefertermin
                </div>
                <div class="dtk_labelcell" style="width:120px;">
                    Kurs
                </div>
                <div class="dtk_labelcell" style="width:120px;">
                    Ungedeckter EK-Wert
                </div>
                <div class="dtk_labelcell" style="width:400px;">
                    Zugeteilter-Wert      Aktion
                </div>
            </div>
            <?php
            $summe = 0;
            $pos = 0;
            ?>
            @foreach($data['assigns'] as $assign)
            <?php $pos++; ?>

            <div class="dtk_row">
                <div class="dtk_cellNoInp" style="">@if ($assign->PPPurchaseDTK_PPProduktpass_id != -1 )
                    <div>  <a href="show/{{$assign->PPPurchaseDTK_PPProduktpass_id}}" target="_blank"><b> {{$assign->PPProduktpass_IAN}}</b> </a> </div>
                    @else
                    <button onclick="showSelectPO({{$pos}});">Zuweisen</button>
                    @endif
                </div>
                <div class="dtk_cellNoInp" style=""> {{$assign->PPPurchase_Supplier}}</div>
                <div class="dtk_cellNoInp" style=""> {{$assign->PPProduktpass_LieferterminJahr}}/{{$assign->PPProduktpass_Liefertermin}}</div>
                <div class="dtk_cellNoInpr" style=""> {{number_format($assign->KursKalk,4,',','.')}}</div>
                <div class="dtk_cellNoInpr" style=""> {{number_format($assign->PO_Wert,2,',','.')}}</div>
                <div class="dtk_cellNoInp" style='width:300px;'>{{Form::open(array('url' => '/saveDTKAssign', 'method' => 'POST','style'=>'border:none;margin:0px;padding:0px;'))}}﻿
                    {{Form::hidden('ASS[dtkid]',$data['dtk']['PPDevisenTerminKaeufe_Id'])}}
                    {{Form::hidden('ASS[pdtkid]',$assign->PPPurchaseDTK_Id)}}
                    <div style='float: left;'>{{Form::text('ASS[Betrag]',number_format($assign->PPPurchaseDTK_Betrag,2,',','.'),array('class'=>'inputr'))}}</div>
                    <div style='float: left;margin-left: 10px;'>{{ Form::submit('speichern', array('class'=>'dtk_submit', 'name'=>'sbut', 'value' => '1'))}}</div>
                    <div style='float: left;margin-left: 5px;'>  {{ Form::submit('löschen', array('class'=>'dtk_submit', 'name'=>'sbut', 'value'=>'0'))}}</div>
                    {{ Form::close()}}</div>
            </div>

            <?php $summe += $assign->PPPurchaseDTK_Betrag; ?>
            <div id="POSelect{{$pos}}" class="dtk_container" style="width:800px;height:150px;overflow: auto;display:none;padding:20px;">
                @foreach ($data['ungedeckt'] as $un)
                <div class="dtk_row">
                    <div class="dtk_cell" style="width:60px;padding:4px;"> {{$un->PPProduktpass_IAN}}</div>
                    <div class="dtk_cell" style="width:250px;padding:4px;"> {{$un->PPPurchase_Supplier}}</div>
                    <div class="dtk_cell" style="width:60px;padding:4px;"> {{$un->LT}}</div>
                    <div class="dtk_cellr" style="width:120px;padding:4px;"> {{number_format($un->PO_Wert,2,',','.')}}</div>
                    <div class="dtk_cellr" style="width:120px;padding:4px;"> {{number_format($un->Ungedeckt,2,',','.')}}</div>
                    <div class="dtk_cell" style="width:105px;padding:0px;">
                        <div style="border:none;border-radius: 0px;width:100px;padding:0px;height:24px;background-color: lightgray;">

                            {{Form::open(array('url' => '/assignDTKAssign', 'method' => 'POST'))}}﻿{{Form::hidden('ASS[dtkid]',$data['dtk']['PPDevisenTerminKaeufe_Id'])}}{{Form::hidden('ASS[pdtkid]',$assign->PPPurchaseDTK_Id)}}{{Form::hidden('ASS[ppid]',$un->PPProduktpass_Id,array('class'=>'inputr'))}}
                            <div style="border:none;border-radius: 0px;width:100px;margin-top:-22px;"> {{ Form::submit('zuordnen', array('class'=>'dtk_submit'))}}</div>
                            {{ Form::close()}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @endforeach
            <div class="dtk_row">
                <div class="dtk_cellNoInp" style=""></div>
                <div class="dtk_cellNoInp" style=""></div>
                <div class="dtk_cellNoInp" style=""> </div>
                <div class="dtk_cellNoInp" style=""> </div>
                <div class="dtk_cellNoInpr" style=""><b>Summe:</b></div>
                <div class="dtk_cellNoInp" style="vertical-align:top; text-align:center;"> <div style="width:110px;text-align: right;"> <b>{{number_format($summe,2,',','.')}}</b></div></div>

            </div>
            <?php
            $offen = $data['dtk']['PPDevisenTerminKaeufe_Betrag'] - $summe;
            $color = $offen >= 0 ? "green" : "red";
            ?>
            <div class="dtk_row">
                <div class="dtk_cellNoInp" style=""></div>
                <div class="dtk_cellNoInp" style=""></div>
                <div class="dtk_cellNoInp" style=""> </div>
                <div class="dtk_cellNoInp" style=""> </div>
                <div class="dtk_cellNoInpr" style=""><b>Offen:</b></div>
                <div class="dtk_cellNoInp" style=""> <div style="width:110px;text-align: right;color:{{$color}}"><b>{{number_format($offen,2,",",".")}}</b></div><br>
                    <div style="width:550px;border: none; border-radius: 0px;text-align: right;">
                        <div style="float:left;width:120px;overflow:hidden; border-radius: 0px;margin:2px;border:none; text-align: center;background-color: lightgray; ">
                            {{Form::open(array('url' => '/newDTKAssign', 'method' => 'POST', 'style' => 'margin:0px; border:none;'))}}﻿
                            {{Form::hidden('dtkid',$data['dtk']['PPDevisenTerminKaeufe_Id'])}}
                            {{Form::hidden('ppid',-1)}}
                            {{ Form::submit('Neue Zuteilung', array('class'=>'dtk_submit', 'style'=>'width:110px;'))}}
                            {{ Form::close()}}
                        </div>
                        <div  style="float:left;width:120px;overflow:hidden;border-radius: 0px;margin:2px;border:none;text-align: center;background-color: lightgray;">
                            {{Form::open(array('url' => '/finance', 'method' => 'GET', 'style' => 'margin:0px; border:none;'))}}﻿
                            {{ Form::submit('Fertig', array('class'=>'dtk_submit'))}}
                            {{ Form::close()}}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<script>
    function showSelectPO(id) {
    event.preventDefault();
    document.getElementById("POSelect" + id).style.display = 'inline-block';
    }
</script>