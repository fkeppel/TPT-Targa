<style>
    .yourBtn {
        width: 350px;
        padding: 25px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border: 1px solid darkblue;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        background-color: #DDD;
        cursor: pointer;
        color: darkblue;
    }

    .cell table {
        border-collapse: collapse;
        width: 300px;
        font-size: 12px;
    }

    .cell td {
        width: 150px;
        background-color: none;
        padding: 4 4 4 8;
        border: 1px solid darkblue;
    }

    .trenner {
        border: none;
    }

    .cell {
        border: none;
    }

    .schedule {
        border: none;
        width: 1900px;
        overflow: auto;
        --height: 800px;
        border-radius: 0px;


    }

    .terminHist td {
        border: 1px solid lightgray;
        height: 25px;
        padding: 5px;
        text-align: left;
    }

    .terminHist th {
        border: 1px solid lightskyblue;
        background-color: lightgray;
        height: 25px;
        font-weight: bold;
        padding: 5px;
        text-align: left;
    }

    .overlay {
        background-color: white;
        font-family: tahoma;
        font-size: 10px;
        border-radius: 0px;


        z-index: 99;
        --xdisplay: none;


        width: calc(100% - 36px);
        --position: fixed;
        --top: 83px;
        --left: 20%;
        border: none;
        height: calc(100% - 11px);
        overflow: auto;
    }

    .schedule table {
        margin-left: 10px;
        font-family: Tahoma;
        font-size: 11px;
        border-collapse: collapse;
        table-layout: fixed;

        border: none;
        font-family: tahoma;
        font-size: 12px;
    }

    .tdHeader {
        border: 1px solid lightgray;
        height: 80px;
        width: 20px;
        padding: 0px;
    }

    .tdRow {
        border: 1px solid red;
        height: 20px;
        padding: 0px;
        width: 20px;
    }

    .schedule td {}

    .rotateX {
        font-family: Tahoma;
        font-size: 8px;
        background-color: lightskyblue;
        border-radius: 0px;
        height: 20px;
        width: 120px;
        padding: 6px;

        /* FF3.5+ */
        -moz-transform: rotate(-90.0deg);
        /* Opera 10.5 */
        -o-transform: rotate(-90.0deg);
        /* Saf3.1+, Chrome */
        -webkit-transform: rotate(-90.0deg);
        /* IE6,IE7 */
        filter: progid DXImageTransform.Microsoft.BasicImage(rotation=0.083);
        /* IE8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
        /* Standard */
        transform: rotate(-90.0deg);
    }

    .table {
        margin-left: 10px;

        display: table;
        text-align: left;

        font-size: 8px;
        border-collapse: collapse;
    }

    .table-row {
        display: table-row;
    }

    .table-cell {
        display: table-cell;
        vertical-align: top;
        border: 1px solid darkblue;
        min-width: 10px;
        max-width: 20px;
        overflow: hidden;
        border-radius: 0px;
        padding: 3px;
    }

    .table-cell_value {
        display: table-cell;
        border: 1px solid red;
        min-width: 10px;
        max-width: 20px;
        border-radius: 0px;
        padding: 0px;
    }

    .table-cell-header-rotate1 {
        display: table-cell;
        border: 1px solid orange;
        min-width: 10px;
        max-width: 10px;
        min-height: 40px;
        max-height: 40px;
        height: 40px;
        overflow: hidden;
        /* FF3.5+ */
        -moz-transform: rotate(-90.0deg);
        /* Opera 10.5 */
        -o-transform: rotate(-90.0deg);
        /* Saf3.1+, Chrome */
        -webkit-transform: rotate(-90.0deg);
        /* IE6,IE7 */
        filter: progid DXImageTransform.Microsoft.BasicImage(rotation=0.083);
        /* IE8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
        /* Standard */
        transform: rotate(-90.0deg);
        border-width: 1px solid blueviolet;
    }

    .table-cell-header-rotate {

        display: table-cell;
        border: 1px solid darkblue;

        background-color: orange;
        border-radius: 0px;
        padding: 3px;
        position: relative;
    }

    .table-cell-header {
        display: table-cell;
        border: 1px solid red;
        min-width: 10px;
        max-width: 10px;
        min-height: 40px;
        max-height: 40px;
        height: 40px;
        overflow: hidden;
    }

    .termin_cell {
        width: 18px;
        height: 20px;
        border: none;
        padding: 0px;
        overflow: hidden;
        font-size: 8px;
        border-radius: 0px;
    }

    .rotate {


        transform: rotate(-90deg);
        transform-origin: left top;
        position: absolute;
        bottom: 0;
        left: 5%;
        white-space: nowrap;
        font-family: Tahoma;
        font-size: 12px;
        margin-left: 3px;
    }

    #cFormHeader input {
        padding: 6px;
    }



    .termineHeader {
        border-collapse: collapse;
        font-family: tahoma;
        font-size: 12px;
        display: table
    }

    .termineHeader .row {
        display: table-row;
    }

    .termineHeader .cell {
        border: 1px solid darkblue;
        padding: 6px;
        width: 120px;
        display: table-cell;
        vertical-align: top;
    }

    .termineHeader .label {
        border: 1px solid darkblue;
        vertical-align: top;
        padding: 6px;
        background-color: orange;
        border-radius: 0px;
        width: 120px;
        display: table-cell;
    }

    .termineHeader .trenner {
        width: 4px;
        display: table-cell;
    }

    .terminHist {

        border-radius: 0px;
        display: table;
        border-collapse: collapse;
        font-family: tahoma;
        font-size: 12px;
        border: 1px solid darkblue;

    }

    .terminHist .thHeader {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        background-color: orange;
        font-weight: bold;
        color: darkblue;
        border: 1px solid darkblue;
    }

    .terminHist .thHeader2 {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        background-color: #c0c0c0;
        font-weight: bold;
        color: darkblue;
        border: 1px solid darkblue;
    }

    .terminHist .thRow {
        display: table-row;
    }

    .terminHist .thCell {
        display: table-cell;
        padding: 8px;
        padding-top: 4px;
        padding-bottom: 4px;
        vertical-align: top;
        border: 1px solid lightgray;
    }

    .terminHist .thCellNew {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        padding-top: 4px;
        padding-bottom: 4px;
        vertical-align: top;
        border: 1px solid darkblue;
        background-color: #cccccc;
        color: darkblue;
        font-weight: bold;
    }

    .bold {
        font-weight: bold;
        padding-left: 4px;
    }

    .infoHeader {
        border-radius: 0px;
        border-collapse: collapse;
        font-family: tahoma;
        font-size: 12px;
        border: none;
        table-layout: fixed;

    }

    .infoHeader td {
        width: 180px;
        padding: 6px;
        border: 1px solid darkblue;
    }


    .infoHeader .iHLabel {

        font-weight: bold;
        min-width: 300px;
        border: 1px solid darkblue;
        background-color: white;
        color: darkblue;
    }

    .infoHeader .iHValue {

        font-weight: bold;

        border: 1px solid darkblue;

    }

    .infoHeader .trenner {
        max-width: 10px;
        border-top: none;
        border-bottom: none;

    }


    .hist .iHLabel {
        font-weight: bold;
        border: 1px solid #b89c50;
        background-color: white;
        color: #b89c50;
    }

    .hist .iHValue {
        font-weight: bold;
        border: 1px solid #b89c50;
        color: #b89c50;
        vertical-align: top;
    }

    .hist .trenner {
        width: 4px;
        border-top: none;
        border-bottom: none;
    }

    .tabSim {
        float: left;
        width: 100px;
        height: 30px;
        font-family: tahoma;
        font-size: 12px;
        color: white;
        border: 1px solid lightblue;
        border-radius: 10px;
        padding-left: 2px;
        padding-right: 2px;
        padding-top: 4px;
        padding-bottom: 4px;
        text-align: center;
        vertical-align: middle;

        background-color: darkblue;
        margin-left: 2px;
        margin-bottom: 2px;

    }


    #data1 {
        border-collapse: collapse;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        color: darkblue;
        padding:8px;
    }


    #data1 .label {
        font-weight: bold;
        padding:8px;
        border:none;

    }
    #data1 .value {

        padding: 8px;
        border:none;
    }

    #data2 {
        margin-top: 15px;
        border-collapse: collapse;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        color: darkblue;
        padding:8px;
    }


    #data2 .iHlabel {
        font-weight: bold;
        padding:8px;
        border:1px solid darkblue;

    }
    #data2 .iHvalue {
        padding:8px;
        border:1px solid darkblue;
        vertical-align: top;
    }
    #data2 .iHvalue .text1 {
        border:none;
        width:100%;
        height: 74px;
        padding:8px;
        color: darkblue;
    }


    #data3 {
        margin-top: 15px;
        border-collapse: collapse;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        color: #b89c50;
        padding:8px;
    }


    #data3 .iHlabel {
        font-weight: bold;
        padding:8px;
        border:1px solid #b89c50;

    }
    #data3 .iHvalue {
        padding:8px;
        border:1px solid #b89c50;
    }
    #data3 .iHvalue .text1 {
        border:none;
        width:200px;
        height: 50px;
        padding:8px;
        color: #b89c50;
    }



    .answer .thCellNew {
        background-color: white;
        padding:0px;
        border:none;
    }

</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>


<?php
$t                = $Daten['t'];
$pp               = $Daten['pp'];
$mitarbeiterliste = $Daten['mitarbeiterliste'];
$termineMusterung = $Daten['termineMusterung'];
$termineLinks     = $Daten['termineLinks'];

$select   = $Daten['select'];
$onlyOpen = $Daten['onlyOpen'];

$board = $Daten['board'];

$dt = new DateTime();
$dt = $dt->add(new DateInterval('P7D'));

$sDP7 = $dt->format('d.m.Y');
?>

<div style="text-align:left;border:1px solid lightgray; width:1670px;height:1260px;text-align: center;">

    <div style="height:85px;border:none;padding:10px;">
        <?php $i    = 1; ?>
        @foreach ($termineLinks as $tm)
        <div class="tabSim" onclick="ajax_getTerminTab({{$pp['id']}}, {{$tm->PPTermine_Id}}, {{$board}}, 'All', 1)" @if($tm->PPBoardSpalte_Bezeichnung == $t['terminart'])style="background-color:#7089e1;color:black;"@endif>
            {{$tm->PPBoardSpalte_Bezeichnung}}
        </div>
        <?php
        if (($i % 15) == 0) {
            echo("<div style='clear:both;'></div>");
        } $i++;
        ?>
        @endforeach
    </div>
    <div class="overlay" id="div_{{$t['id']}}" style="padding:0px;overflow: auto;z-index:10000;height:1035px; border:none; margin-left:0px;">


        <div style="position:relative; margin: 0 auto;border:none;border-radius: 0px;height: 1018px; padding:8px; text-align: center;">
            <div style="margin:0 auto;border:none;border-radius: 0px;">
                <div style="border: 1px solid darkblue;border-radius: 0px;  ">
                    <form id="frm{{$t['id']}}" Method="post" action="#" enctype="multipart/form-data">
                        <input type="hidden" name="Termine_Id{{$t['id']}}" value="{{$t['id']}}">
                        <fieldset style="border:none;">
                            <div style="padding-top: 8px; padding-bottom: 8px;text-align: left;">
                                <span style="font-size: 18px; font-weight: bold;padding: 5px; padding-top:8px; padding-bottom: 8px;color:darkblue;">Hauptaufgabe</span>
                            </div>
                            <div style="border:1px solid lightgray;height:276px;">
                                <div style="border: none; margin-bottom: 20px;">
                                    <div style="border: none;float: left;">
                                        <table id="data1">
                                            <tr>
                                                <td class="label" style="width:80px;">Terminart:</td>
                                                <td  class="value"  style="width:800px;">{{$t['terminart']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">IAN:</td>
                                                <td class="value" ><a href="/showAfterUpload/{{$pp['id']}}/1"
                                                                      target="_blank">{{$pp['ian']}}</a></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Lieferant:</td>
                                                <td class="value" >@if (isset($po['supplierid']))
                                                    <a href="adressen/show/{{$po['supplierid']}}"
                                                       target="_blank">{{$po['supplier']}}</a>
                                                    @if ($t['terminart'] == 'BSCI' and isset($po['bsci']))<br>BSCI
                                                    gültig bis: {{$po['bsci']}}@endif
                                                    @endif
                                                </td>
                                            <tr>
                                                <td class="label">Liefertermin:</td>
                                                <td class="value" > @if ($t['rot'] != '')Soll: LT{{$t['rot']}} Wochen  @endif
                                                    KW @if ($pp['ltw']+$t['rot'] <=
                                                    0){{$pp['lty']-1}}/{{$pp['ltw']+$t['rot']+52}} @else
                                                    {{$pp['lty']}}/{{$pp['ltw']+$t['rot']}}@endif</td>
                                            </tr>
                                            
                                        </table>
                                        <table id="data2">
                                            <tr>
                                                <td class="iHLabel" style="width:132px;">Status</td>
                                                <td class="iHLabel">Zuständig</td>
                                                <td class="iHLabel">erledigen bis</td>
                                                <td class="iHLabel">erledigt am</td>
                                                <td class="iHLabel">Anzeigetext</td>
                                                <td class="iHLabel">Bemerkung</td>
                                                <td class="iHLabel" style="width:68px;">store</td>
                                            </tr>

                                            <tr>
                                                <td class="iHValue">{{
                                                    Form::select('Termine_Status',$t['stati'],$t['status'],array('id'=>'Termine_Status'.$t['id'],'style'=>"width:120px;padding:5px;"))
                                                    }}</td>
                                                <td class="iHValue">{{
                                                    Form::select('Termine_Mitarbeiter',$mitarbeiterliste,$t['ma'],array('id'=>'Termine_Mitarbeiter'.$t['id'],'style'=>"width:100px;padding:5px;"))
                                                    }}</td>
                                                <td class="iHValue">{{
                                                    Form::text('Termine_Datum',substr($t['start'],0,10), array('style'
                                                    => 'width:100px;' ,
                                                    'id'=>'Termine_Datum'.$t['id'],'class'=>'datepicker'))}}</td>
                                                <td class="iHValue">{{
                                                    Form::text('Termine_Datum_Ende',substr($t['ende'],0,10),
                                                    array('style' => 'width:100px;'
                                                    ,'id'=>'Termine_Datum_Ende'.$t['id'],'class'=>'datepicker'))}}</td>
                                                <td class="iHValue" style="padding:0px;">
                                                    <textarea class="text1" name="Termine_Label{{$t['id']}}" id="Termine_Label{{$t['id']}}">{{$t['label']}}</textarea>
                                                </td>
                                                <td class="iHValue" style="padding:0px;">
                                                    <textarea class="text1" name="Termine_Bemerkung{{$t['id']}}" id="Termine_Bemerkung{{$t['id']}}" >{{$t['bemerkung']}}</textarea>
                                                </td>
                                                <td class="iHValue" style="text-align:center;padding:0px;"> @if (Auth::User()->PPMitarbeiter_Gruppe == 'user' or
                                                    Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                                    <button type="button" id="ajaxCall_SaveDateX"
                                                            onclick="saveTermin('{{$t['id']}}');"> <img src="/data/Icons/speichern.png" style="width:68px;" /></button>
                                                    @endif
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                    <div id="buttonHistory" style="border:none;width:645px;overflow:auto;height:274px;position: relative;right: 0px;"><div style="position: absolute; bottom:10px; left:10px;border: 1px solid gold;"><button type="button"   onclick="History(0);">History</button></div></div>
                                    <div id="boxHistory" style="border:1px solid lightgray;width:645px;overflow:auto;height:274px;text-align: left;display:none;">
                                        <textarea style="width:100%;height:240px;padding:5px;">{{ str_replace('*','',str_replace('* ', '', $t['history'])) }}</textarea>
                                        <button type="button" style="margin-top:5px;margin-left: 5px;"  onclick="History(1);">Close</button>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;">&nbsp;</div>
                        </fieldset>
                    </form>
                </div>

                @if ($t['terminart'] == "Nacharbeit")
                <div style="border-top:1px solid darkblue;border-bottom:1px solid darkblue; padding:4 0 4 10; border-radius:0px;height:58px;">
                        <?php $i = 1; ?>
                    @foreach ($termineMusterung as $tm)
                    <div style="float:left;width:150px;">
                        <input type="checkbox" id="{{$tm->PPBoardSpalte_Bezeichnung}}_{{$t['id']}}"
                                name="{{$tm->PPBoardSpalte_Bezeichnung}}"><span
                                style="color:darkblue;font-size: 11px;">{{$tm->PPBoardSpalte_Bezeichnung}}</span>
                    </div>
                    <?php
                    if (($i % 9) == 0) {
                        echo("<div style='clear:both;'></div>");
                    } $i++;
                    ?>
                    @endforeach
                </div>
                @endif
                <div style="padding: 0px; border: 1px solid darkblue; border-radius: 0px;  padding:10px; margin-top: 8px;">
                    <div style="padding-top: 4px; padding-bottom: 4px;text-align: left;">
                        <span style="font-size:18px; font-weight: bold;padding: 5px; padding-top:8px; padding-bottom: 8px;color:#b89c50;">Zwischenstatus</span>
                    </div>
                    <div style="border:none;">
                        <div style="border:none;">
                            <form id="frmTheme{{$t['id']}}" Method="post" action="#" enctype="multipart/form-data">
                                <input type="hidden" id="Theme_PPId_{{$t['id']}}" value="{{$pp['id']}}" />
                                <div class="hist" style="border:none;">
                                    <table id="data3" style="margin-top:10px;table-layout: fixed;border-radius: 10px;border-collapse: collapse;">

                                        <tr>
                                            <td class="iHLabel" style="width:100px;">Kategorie</td>
                                            <td class="iHLabel" style="width:100px;">Zuständig</td>
                                            <td class="iHLabel" style="width:100px;">erledigen bis</td>
                                            <td class="iHLabel" style="width:338px;">Bemerkung</td>
                                            <td class="iHLabel" style="width:100px;">Upload</td>
                                            <td class="iHLabel" style="width:68px;">store</span></td>
                                        </tr>
                                        <tr>
                                            <td class="iHValue">
                                                <select id="Theme_Categorie_{{$t['id']}}" style="padding: 5px;">
                                                    <option>Sonstige</option>
                                                    <option>Mengendifferenz</option>
                                                    <option>Qualität</option>
                                                    <option>Farbe</option>
                                                </select>
                                            </td>

                                            <td class="iHValue"><select id="Theme_Bearbeiter_{{$t['id']}}"
                                                                        style="padding: 5px;">
                                                    @foreach ($mitarbeiterliste as $mid => $ma)
                                                    <option value="{{$mid}}">{{$ma}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="iHValue"><input class="datepicker" style='width:90px;' id="Theme_DoUntil_{{$t['id']}}" class="datepicker" value="{{$sDP7}}" /></td>
                                            <td class="iHValue" style="padding:0px;"><textarea id="Theme_Remark_{{$t['id']}}" placeholder="Bemerkung" style="width:100%;height:74px; border:none;padding:4px;"></textarea></td>
                                            <td class="iHValue" style="padding:0px;">
                                                <div style="padding: 0px;">
                                                    <div class="dropCTheme" id="dropContainer_{{$t['id']}}"
                                                            style="border-radius: 0px;border:none;height:50px; padding:4px;vertical-align:central; text-align:center;color:white;width:100px;">
                                                        <img src="/data/Icons/upload.png"  style="width:100px;"/>
                                                    </div>
                                                    <input type="file" id="Theme_File_{{$t['id']}}" style="display: none;" />
                                                </div>
                                            </td>
                                            <td class="iHValue" style="padding:0px;"><div id="ani_{{$t['id']}}" style="display: none;">
                                                    <img src="/data/uploads/BilderTextbausteine/animated_upload.gif" />
                                                </div>
                                                <div id="btn_{{$t['id']}}">
                                                    @if (Auth::User()->PPMitarbeiter_Gruppe == 'user' or
                                                    Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                                    <button type="button" id="ajaxCall_SaveDateX"
                                                            onclick="cpc_newTheme('{{$t['id']}}')"
                                                            >
                                                        <img src="/data/Icons/speichern.png" style="width:68px;" />
                                                    </button><br>

                                                    @endif
                                                </div></td>
                                        </tr>

                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                
                <div style="border:none;height:434px; overflow: auto;padding:0px;margin-top:8px;">
                    <div class="terminHist" style="margin:0px auto;width:100%;padding: 0px;">
                        <div class="thRow" style="display:none;">
                            <div class="thHeader">Status</div>
                            <div class="thHeader">Kategorie</div>
                            <div class="thHeader">Erledigen durch</div>
                            <div class="thHeader">Erledigen bis</div>
                            <div class="thHeader">Bemerkung</div>
                            <div class="thHeader">Upload</div>
                            <div class="thHeader"></div>
                        </div>
                    </div>

                    <div style='border:1px solid darkblue;overflow: auto;height:418px;margin-top:8px;border-radius: 0px;'>

                        @include('termine.thist')

                    </div>

                </div>

                
                
            </div>

        </div>
    </div>

    <script>


        function History(show) {
            var hist = document.getElementById('boxHistory');
            var btn = document.getElementById('buttonHistory');
            if (show){
                btn.style.display= '';
                hist.style.display = 'none';
            } else {
                btn.style.display= 'none';
                hist.style.display = '';
            }
            
        }

        function ajax_getTerminTab(ppid, tid, board, select, openOnly) {
        //alert ('Open Window:  ' + ppid + ' ' + tid + ' ' + board + ' ' + select + ' ' + openOnly);
        window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board + "/" + select + "/" + openOnly, "_self", "toolbar=yes, scrollbars=yes, resizable=yes, top=100,left=100,width=1680, height=1162");
        }
        function readValue(elem) {



        if (elem != null) {
        console.log(elem);
        console.log(elem.value);
        return elem.value;
        }
        console.log(elem + " is NULL");
        return '';
        }


        function cpc_newTheme(id) {
        console.log('cpc_newTheme');
        btnElem = document.getElementById('btn_' + id);
        if (btnElem) {
        btnElem.style.display = "none";
        }

        aniElem = document.getElementById('ani_' + id);
        if (aniElem) {
        aniElem.style.display = "block";
        }



        try {
        var values = {

        "Theme_Categorie": readValueFromId("Theme_Categorie_" + id),
                "Theme_Remark": readValueFromId("Theme_Remark_" + id),
                //"Theme_File":        readValueFromId("Theme_File_"+id),
                "Theme_Bearbeiter": readValueFromId("Theme_Bearbeiter_" + id),
                "Theme_DoUntil": readValueFromId("Theme_DoUntil_" + id),
                "Theme_PPId": readValueFromId("Theme_PPId_" + id),
                "Theme_TId": id,
        }
        var jsonString = JSON.stringify(values);
        console.log(jsonString);
        var fileData = $("#Theme_File_" + id);
        var fFile;
        if (typeof fileData.prop('files') !== 'undefined') {
        fFile = fileData.prop('files')[0]
        }

        } catch (e) {
        console.log(e.message);
        }

        cpc_SendAjaxJsonRequestM("/newTheme", jsonString, fFile);
        }

        function saveTermin(id) {


        try {
        var values = {
        "Termine_Id": id,
                "Termine_Datum": readValue($("#Termine_Datum" + id)[0]),
                "Termine_Status": readValue($("#Termine_Status" + id)[0]),
                "Termine_Datum_Ende": readValue($("#Termine_Datum_Ende" + id)[0]),
                "Termine_Label": readValue($("#Termine_Label" + id)[0]),
                "Termine_Bemerkung": readValue($("#Termine_Bemerkung" + id)[0]),
                "Termine_Mitarbeiter": readValue($("#Termine_Mitarbeiter" + id)[0]),
                "StatChange_Categorie": readValue(document.getElementById("StatChange_CategorieM_" + id)),
                "StatusRemark": readValue(document.getElementById("StatChange_Remark_" + id)),
                "StatusPPId": readValue(document.getElementById("StatChange_PPId_" + id))

        };
        } catch (e) {

        console.log(e.message);
        }
        console.log('saveTermin id:' + id);
        var jsonString = JSON.stringify(values);
        console.log(jsonString);
        var fileData = $('#yFile' + id);
        var xFile;
        if (typeof fileData.prop('files') !== 'undefined') {
        xFile = fileData.prop('files')[0]
        }

        console.log(fileData[0]);
        cpc_SendAjaxJsonRequestM("/termineupdatejsonM", jsonString, xFile);
        return;
        }

        function cpc_onSuccess(jsonResult) {
        console.log("Func OK");
        //console.log(jsonResult);
        /*
         var id = jsonResult.id;
         var messageResult = document.getElementById("jsonSpace" + jsonResult.id);
         messageResult.style.display = "block";
         messageResult.innerHTML = jsonResult.view;
         var fileInput = document.getElementById("xFile" + id);
         fileInput.value = '';
         var dc = document.getElementById("dropContainer_" + id);
         dc.innerHTML = "Drag & Drop";
         dc.style.backgroundColor = "";
         var rem = document.getElementById("StatChange_Remark_" + id);
         rem.value = '';
         var doUntil = document.getElementById("StatChange_DoUntil_" + id);
         doUntil.value = '';
         var cat = document.getElementById("StatChange_Categorie_" + id);
         cat.value = '';
         var rec = document.getElementById("StatChange_Receiver_" + id);
         rec.value = '';*/
        location.reload();
        }


        function xDelete(id) {

        var answer = window.confirm("Datensatz wirklich löschen?");
        if (! answer) {
        return;
        }

        console.log("delete " + id);
        var frmData = new FormData();
        frmData.append("PPChanges_Id", id);
        $.ajax({
        type: "POST",
                url: "/deletePPChanges",
                data: frmData,
                processData: false,
                contentType: false,
                success: xDeleteSuccess,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }


        function xDeleteSuccess() {
        location.reload();
        }


        $(function () {
        $(function () {
        $(".datepicker").datepicker(
        {
        numberOfMonths: 1,
                showButtonPanel: true,
                showWeek: true,
                firstDay: 1,
                dateFormat: "dd.mm.yy",
                monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
                dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
                dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        });
        });
        });
        $(function () {
        var elements = document.getElementsByClassName("dropCTheme");
        for (var i = 0; i < elements.length; i++) {

        elements[i].ondragover = function (evt) { evt.preventDefault(); };
        elements[i].ondragenter = function (evt) { evt.preventDefault(); };
        elements[i].ondrop = function (evt) {
        var id = this.id.split("_")[1];
        var fileInput = document.getElementById("Theme_File_" + id);
        fileInput.files = evt.dataTransfer.files;
        if (true) {

        this.innerHTML = "Datei bereit";
        this.style.backgroundColor = "#249f35";
        }
        evt.preventDefault();
        };
        }

        })

                $(function () {
                var elements = document.getElementsByClassName("dropC");
                for (var i = 0; i < elements.length; i++) {

                elements[i].ondragover = function (evt) { evt.preventDefault(); };
                elements[i].ondragenter = function (evt) { evt.preventDefault(); };
                elements[i].ondrop = function (evt) {
                var id = this.id.split("_")[1];
                var fileInput = document.getElementById("xFile" + id);
                fileInput.files = evt.dataTransfer.files;
                if (true) {

                this.innerHTML = "Datei bereit3";
                this.style.backgroundColor = "#249f35";
                this.style.Color = "white";
                }
                evt.preventDefault();
                };
                }

                })

                $(function () {
                var elements = document.getElementsByClassName("xdropC");
                for (var i = 0; i < elements.length; i++) {

                elements[i].ondragover = function (evt) { evt.preventDefault(); };
                elements[i].ondragenter = function (evt) { evt.preventDefault(); };
                elements[i].ondrop = function (evt) {
                var id = this.id.split("_")[1];
                var fileInput = document.getElementById("xxFile" + id);
                fileInput.files = evt.dataTransfer.files;
                if (true) {

                this.innerHTML = "Datei bereit2";
                this.style.backgroundColor = "#249f35";
                this.style.Color = "white";
                }
                evt.preventDefault();
                };
                }

                })

                function cpc_onSuccessM(jsonResult) {

                console.log("Success" + jsonResult.id);
                //alert(jsonResult );
                id = jsonResult.id;
                //console.log(jsonResult);

                //var id = jsonResult.id;
                ani = document.getElementById("ani_" + id);
                if (ani) {
                ani.style.display = "none";
                }
                btn = document.getElementById("btn_" + id);
                if (btn) {
                btn.style.display = "block";
                }
                location.reload();
                }


        function cpc_SendAjaxJsonRequestM(url, jsonObject, file) {

        console.log("Start: " + url);
        var frmData = new FormData();
        frmData.append("jsonObject", jsonObject);
        if (file) {
        frmData.append("file", file);
        }

        $.ajax({
        type: "POST",
                url: url,
                data: frmData,
                processData: false,
                contentType: false,
                success: cpc_onSuccessM,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }




        function getFile(id) {
        document.getElementById("file_" + id).click();
        }

        function sub(obj, id) {
        var file = obj.value;
        var fileName = file.split("\\");
        //document.getElementById("yourBtn_" + id).innerHTML = fileName[fileName.length - 1];
        document.getElementById("yourBtn_" + id).style.color = "limegreen";
        document.getElementById("yourBtn_" + id).style.backgroundColor = "limegreen";
        frm = document.getElementById("form_" + id);
        console.log(frm);
        frm.submit();
        event.preventDefault();
        }

        function sendAjax(tid) {


        $.ajax({
        type: 'POST',
                url: 'testAjax',
                data: {
                _token: "{{ csrf_token() }}"
                },
                success: function (msg) {
                //alert ("Bis hier immer noch  OK" + tid);
                console.log(msg);
                document.getElementById("Res" + tid).innerHTML = msg.wasanders;
                }
        });
        }

        function cpc_tsavePopUp(id) {

        try {
        var values = {
        "Termine_Id": id,
                "Termine_Datum": readValuePopUp($("#Termine_Datum" + id)[0]),
                "Termine_Datum_Ende": readValuePopUp($("#Termine_Datum_Ende" + id)[0]),
                "Termine_Label": readValuePopUp($("#Termine_Label" + id)[0]),
                "Termine_Bemerkung": readValuePopUp($("#Termine_Bemerkung" + id)[0]),
                "Termine_Mitarbeiter": readValuePopUp($("#Termine_Mitarbeiter" + id)[0]),
                "StatusCategorie": readValuePopUp(document.getElementById("StatChange_Categorie_" + id)),
                "StatusRemark": readValuePopUp(document.getElementById("StatChange_Remark_" + id)),
                "StatusPPId": readValuePopUp(document.getElementById("StatChange_PPId_" + id))

        };
        } catch (e) {

        console.log(e.message);
        }
        console.log('Save3:');
        var jsonString = JSON.stringify(values);
        cpc_SendAjaxJsonRequestPopUp("termineupdatejsonPopUp", jsonString);
        return;
        }


        function cpc_onSuccessPopUp(jsonResult) {

        var id = jsonResult.id;
        document.getElementById("messagebox" + id).innerHTML = jsonResult.cont;
        }


        function cpc_SendAjaxJsonRequestPopUp(url, jsonObject) {

        console.log("Start");
        var frmData = new FormData();
        frmData.append("jsonObject", jsonObject);
        $.ajax({
        type: "GET",
                url: url,
                data: frmData,
                processData: false,
                contentType: false,
                success: cpc_onSuccessPopUp,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }


        function readValueFromId(name) {
        elem = document.getElementById(name);
        if (elem != null) {
        console.log(elem);
        console.log(elem.value);
        return elem.value;
        }
        console.log(elem + " is NULL");
        return '';
        }

        function readValuePopUp(elem) {



        if (elem != null) {
        console.log(elem);
        console.log(elem.value);
        return elem.value;
        }
        console.log(elem + " is NULL");
        return '';
        }


        $(function () {
        var elements = document.getElementsByClassName("dropCPopUp");
        for (var i = 0; i < elements.length; i++) {

        elements[i].ondragover = function (evt) { evt.preventDefault(); };
        elements[i].ondragenter = function (evt) { evt.preventDefault(); };
        elements[i].ondrop = function (evt) {
        var id = this.id.split("_")[1];
        var fileInput = document.getElementById("yFile" + id);
        fileInput.files = evt.dataTransfer.files;
        if (true) {

        this.innerHTML = "Datei bereit OK";
        this.style.backgroundColor = "lime";
        }
        evt.preventDefault();
        };
        }

        })


                function readValueFromId(elemName) {
                //console.log (elemName + " TEST");
                elem = document.getElementById(elemName);
                if (elem != null) {
                return elem.value;
                }
                console.log(elemName + " is NULL");
                return null;
                }



        function answer(id) {

        //alert ("U:" + id);

        console.log("cpc_save_stateChangeU: " + id);
        try {
        var values = {
        "PPTermineChanges_PPTermine_Id": readValueFromId("xStatChange_TermineId_" + id),
                "PPTermineChanges_Id": readValueFromId("xStatChange_Id_" + id),
                "PPTermineChanges_Mitarbeiter_Id": readValueFromId("xStatChange_Sender_" + id),
                "PPTermineChanges_Categorie": readValueFromId("xStatChange_Categorie_" + id),
                "PPTermineChanges_DoUntil": readValueFromId("xStatChange_DoUntil_" + id),
                "PPTermineChanges_DoneAt": readValueFromId("xStatChange_DoneAt_" + id),
                "PPTermineChanges_Receiver": readValueFromId("xStatChange_Receiver_" + id),
                "PPTermineChanges_Remark": readValueFromId("xStatChange_Remark_" + id),
                "PPTermineChanges_PPProduktpass_Id": readValueFromId("xStatChange_PPId_" + id),
                "PPTermineChanges_oldStatus": readValueFromId("xStatChange_StatusAlt_" + id),
                "PPTermineChanges_newStatus": readValueFromId("xTermine_Status" + id),
                "PPTermineChanges_PPPPFilesId": ""

        }
        console.log(values);
        var fileData = $('#xxFile' + id);
        var xFile;
        if (typeof fileData.prop('files') !== 'undefined') {
        xFile = fileData.prop('files')[0]
        }
        var jsonString = JSON.stringify(values);
        type = "POST";
        cpc_SendAjaxJsonRequest("/termineChangeStateAnswer", jsonString, xFile, id, type);
        }
        catch (e) {

        console.log(e.message);
        }

        console.log(values);
        }



        function cpc_save_stateChangeX(id) {


        console.log("cpc_save_stateChange: " + id);
        try {
        var values = {
        "PPTermineChanges_PPTermine_Id": id,
                "PPTermineChanges_Mitarbeiter_Id": readValueFromId("StatChange_Sender_" + id),
                "PPTermineChanges_Categorie": readValueFromId("StatChange_Categorie_" + id),
                "PPTermineChanges_DoUntil": readValueFromId("StatChange_DoUntil_" + id),
                "PPTermineChanges_DoneAt": readValueFromId("StatChange_DoneAt_" + id),
                "PPTermineChanges_Receiver": readValueFromId("StatChange_Receiver_" + id),
                "PPTermineChanges_Remark": readValueFromId("StatChange_Remark_" + id),
                "PPTermineChanges_PPProduktpass_Id": readValueFromId("StatChange_PPId_" + id),
                "PPTermineChanges_oldStatus": readValueFromId("StatChange_StatusAlt_" + id),
                "PPTermineChanges_newStatus": readValueFromId("Termine_Status" + id),
                "PPTermineChanges_PPPPFilesId": ""

        }

        var fileData = $('#xFile' + id);
        var xFile;
        if (typeof fileData.prop('files') !== 'undefined') {
        xFile = fileData.prop('files')[0]
        }
        var jsonString = JSON.stringify(values);
        type = "POST";
        cpc_SendAjaxJsonRequest("/termineChangeState", jsonString, xFile, id, type);
        }
        catch (e) {

        console.log(e.message);
        }

        console.log(values);
        }

        function cpc_SendAjaxJsonRequest(url, jsonObject, fileData, id, type) {

        console.log("cpc_SendAjaxJsonRequest: " + url + " Id: " + id + " Type: " + type);
        var frmData = new FormData();
        frmData.append("jsonObject", jsonObject);
        if (fileData) {
        frmData.append("file", fileData);
        console.log("Mit Datei");
        }
        $.ajax({
        type: type,
                url: url,
                data: frmData,
                processData: false,
                contentType: false,
                success: cpc_onSuccess,
                error: function (xhr, ajaxOptions, thrownError) {
                //alert("Fehler: " + url);
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }


        function setErledigt(tid, id) {
        //alert(tid + " - " + id);
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('tid', tid);
        $.ajax({
        type: "POST",
                url: "/setChangeErledigt",
                data: frmData,
                processData: false,
                contentType: false,
                success: onSuccessSetErledigt,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }

        function onSuccessSetErledigt(jsonResult) {

        console.log(onSuccessSetErledigt);
        /*var messageResult = document.getElementById("jsonSpace" + jsonResult.tid);
         messageResult.style.display = "block";
         messageResult.innerHTML = jsonResult.view;*/

        location.reload();
        }


        function setAnswer(tid, id) {

        //alert(tid);
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('tid', tid);
        $.ajax({
        type: "POST",
                url: "/setChangeAnswer",
                data: frmData,
                processData: false,
                contentType: false,
                success: onSuccessSetErledigt,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }
        function showAnswer(id) {

        var elem = document.getElementById("Answer1" + id);
        if (elem) {
        elem.style.display = 'block';
        }

        var elem = document.getElementById("Answer2" + id);
        if (elem) {
        elem.style.display = 'block';
        }

        var elem = document.getElementById("Answer" + id);
        if (elem) {
        elem.style.display = 'block';
        }

        var elem = document.getElementById("btn_answer" + id);
        if (elem) {
        elem.style.display = 'block';
        }

        }
        function hideAnswer(id) {

        var elem = document.getElementById("Answer1" + id);
        if (elem) {
        elem.style.display = 'none';
        }

        var elem = document.getElementById("Answer" + id);
        if (elem) {
        elem.style.display = 'none';
        }

        var elem = document.getElementById("btn_answer" + id);
        if (elem) {
        elem.style.display = 'none';
        }

        }


        $(function () {
        $(function () {
        $(".datepicker").datepicker(
        {
        locale: 'de',
                numberOfMonths: 1,
                showButtonPanel: true,
                showWeek: true,
                firstDay: 1,
                dateFormat: "dd.mm.yy",
                monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
                dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
                dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        });
        });
        });



    </script>