<style>
    .yourBtn {
        width: 350px;
        padding: 25px;
        border-radius: 2px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border: 1px solid #003D7C;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        background-color: #DDD;
        cursor: pointer;
        color: #003D7C;
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
        border: 1px solid #003D7C;
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
    .rotateX {
        font-family: Tahoma;
        font-size: 8px;
        background-color: lightskyblue;
        border-radius: 0px;
        height: 20px;
        width: 120px;
        padding: 6px;
        transform: rotate(-90.0deg);
        /* FF3.5+ */
        -moz-transform: rotate(-90.0deg);
        /* Opera 10.5 */
        -o-transform: rotate(-90.0deg);
        /* Saf3.1+, Chrome */
        -webkit-transform: rotate(-90.0deg);
        /* IE6,IE7 */
        filter: progid DXImageTransform.Microsoft.BasicImage(rotation=0.083);
        /* IE8 */
        -ms-filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083);
        /* Standard */
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
        border: 1px solid #003D7C;
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
        transform: rotate(-90.0deg);
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
        border: 1px solid #003D7C;
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
        border: 1px solid #003D7C;
        padding: 6px;
        width: 120px;
        display: table-cell;
        vertical-align: top;
    }
    .termineHeader .label {
        border: 1px solid #003D7C;
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
        border: 1px solid #003D7C;
    }
    .terminHist .thHeader {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        background-color: orange;
        font-weight: bold;
        color: #003D7C;
        border: 1px solid #003D7C;
    }
    .terminHist .thHeader2 {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        background-color: #c0c0c0;
        font-weight: bold;
        color: #003D7C;
        border: 1px solid #003D7C;
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
        border: 1px solid #003D7C;
        background-color: #cccccc;
        color: #003D7C;
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
        border: 1px solid #003D7C;
    }
    .infoHeader .iHLabel {
        font-weight: bold;
        min-width: 300px;
        border: 1px solid #003D7C;
        background-color: white;
        color: #003D7C;
    }
    .infoHeader .iHValue {
        font-weight: bold;
        border: 1px solid #003D7C;
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
        border-radius: 5px;
        padding-left: 2px;
        padding-right: 2px;
        padding-top: 4px;
        padding-bottom: 4px;
        text-align: center;
        vertical-align: middle;
        background-color: #003D7C;
        margin-left: 2px;
        margin-bottom: 2px;
    }
    #data1 {
        border-collapse: collapse;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        color: #003D7C;
        padding: 8px;
    }
    #data1 .label {
        font-weight: bold;
        padding: 8px;
        border: none;
        vertical-align: top;
    }
    #data1 .value {
        padding: 8px;
        border: none;
    }
    #data2 {
        margin-top: 15px;
        border-collapse: collapse;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        color: #003D7C;
        padding: 8px;
    }
    #data2 .iHlabel {
        font-weight: bold;
        padding: 8px;
        border: 1px solid #003D7C;
    }
    #data2 .iHvalue {
        padding: 8px;
        border: 1px solid #003D7C;
        vertical-align: top;
    }
    #data2 .iHvalue .text1 {
        border: none;
        width: 100%;
        height: 74px;
        padding: 8px;
        color: #003D7C;
    }
    #data3 {
        margin-top: 15px;
        border-collapse: collapse;
        border: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        color: #b89c50;
        padding: 8px;
    }
    #data3 .iHlabel {
        font-weight: bold;
        padding: 8px;
        border: 1px solid #b89c50;
    }
    #data3 .iHvalue {
        padding: 8px;
        border: 1px solid #b89c50;
    }
    #data3 .iHvalue .text1 {
        border: none;
        width: 200px;
        height: 50px;
        padding: 8px;
        color: #b89c50;
    }
    .answer .thCellNew {
        background-color: white;
        padding: 0px;
        border: none;
    }
    .msContainer {
        grid-template-columns:  repeat(15, auto);
    }
    .msCell {
        border: 1px solid red;
    }
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<?php
$t                = $Daten['t'];
$pp               = $Daten['pp'];
$iconInfo = "/data/Icons/Info.jpg";
$ppall            = $Daten['value']['PP'];
$mitarbeiterliste = $Daten['mitarbeiterliste'];
$mitarbeiterNamen = $Daten['mitarbeiterNamen'];
if (!isset($mitarbeiterliste[$t['ma']])) {
    $mitarbeiterliste[$t['ma']] = $Daten['DelMa'][$t['ma']];
}
$termineMusterung = $Daten['termineMusterung'];
$termineLinks     = $Daten['termineLinks'];
$select   = $Daten['select'];
$onlyOpen = $Daten['onlyOpen'];
$board = $Daten['board'];
$dt = new DateTime();
$dt = $dt->add(new DateInterval('P7D'));
$sDP7 = $dt->format('d.m.Y');
$crd = new DateTime();
if ($ppall->PPProduktpass_CRDJahr > 0){
    $crd->setISODate( $ppall->PPProduktpass_CRDJahr, $ppall->PPProduktpass_CRDWoche,5);
} else {
    $W10 = new DateInterval('P10W');
    $crd->setISODate($ppall->PPProduktpass_LieferterminJahr, $ppall->PPProduktpass_Liefertermin );
    $crd->sub($W10);
 }
 $_st = '';
 if (Config::get('app.cEnv') == 'development' ){
    $_st='Border:4px solid red;';
 }
 if (! isset($_COOKIE['TPTLanguage'])){
            $_COOKIE['TPTLanguage'] =  Auth::user()->PPMitarbeiter_Language; //'DE';
        } 
$lang = $_COOKIE['TPTLanguage'];
?>
<div style="text-align:left;border:1px solid gray; width:1877px;height:95%;text-align: center; {{ $_st }}">
    <div style="border:none;padding:10px;">
        <?php $i    = 1; 
        ?>
        @foreach ($termineLinks as $tm)
        <?php 
            $pmCol      = '#003D7C';
            $pmColActiv = '#3399FF';
            $tcCol      = $pmCol;  //'#009900'; Test Green
            $tcColActiv = $pmColActiv; //'#33FF33'; Test light Green
            $fontCol = 'white';
            if($tm->PPBoardSpalte_Bezeichnung != $t['terminart']) {
                $col = $pmCol;
                if(strpos($tm->PPBoardSpalteData_Kind ,'PM') === false) {
                    $col = $tcCol;
                }
            } else {
                $fontCol = 'black';
                $col = $pmColActiv;
                if(strpos($tm->PPBoardSpalteData_Kind ,'PM') === false) {
                    $col = $tcColActiv;
                }
            }
            ?>
        <div class="tabSim" onclick="ajax_getTerminTab({{$pp['id']}}, {{$tm->PPTermine_Id}}, {{$board}}, 'All', 1)"  style="background-color:{{$col}};color:{{$fontCol}};" >
            <span style='font-size:0.85em;'>{{$tm->PPBoardSpalte_Bezeichnung}}</span>
        </div>
        <?php
        if (($i % 15) == 0) {
            echo ("<div style='clear:both;'></div>");
        }
        $i++;
        ?>
        @endforeach
        @if ($board == 1000)
        <div class="tabSim" onclick="ajax_getTerminTab({{$pp['id']}}, 0, 1001, 'All', 1)" style="background-color:rgb(98, 210, 210);color:rgb(16, 104, 48);">
            {{ ServiceProvider::tl($lang, 'Termine Musterung') }}
        </div>
        @else
        <div class="tabSim" onclick="ajax_getTerminTab({{$pp['id']}}, 0, 1000, 'All', 1)" style="background-color:rgb(98, 210, 210);color:rgb(16, 104, 48);">
             {{ ServiceProvider::tl($lang, 'Termine Projekte') }}
        </div>
        @endif
    </div>
    <div class="overlay" id="div_{{$t['id']}}" style="padding:0px;overflow: auto;z-index:10000;height:980px; border:none; margin-left:0px;">
        <div style="position:relative; margin: 0 auto;border:none;border-radius: 0px;height: 950px; padding:8px; text-align: center;">
            <div style="margin:0 auto;border:none;border-radius: 0px;">
                <div style="border: 1px solid #003D7C;border-radius: 0px;  ">
                    <form id="frm{{$t['id']}}" Method="post" action="#" enctype="multipart/form-data">
                        <input type="hidden" name="Termine_Id{{$t['id']}}" value="{{$t['id']}}">
                        <fieldset style="border:none; padding-bottom:0px;">
                            <div style="padding-top: 8px; padding-bottom: 8px;text-align: left;">
                                <span style="font-size: 18px; font-weight: bold;padding: 5px; padding-top:8px; padding-bottom: 8px;color:#003D7C;">Hauptaufgabe</span>
                            </div>
                            <div style="border:none;height:284px;">
                                <div style="border: none; margin-bottom: 0px;">
                                    <div style="border: none;float: left; padding-bottom:0px;">
                                        <table id="data1">
                                            <tr>
                                                <td class="label" style="width:100px;">Terminart: <span style="color:green; font-weight:bold; font-size:1.2rem;"></span><img src="{{url($iconInfo)}}"  style="width:16px;float:right;" title="Status: In Arbeit: {{$t['Header2'][$t['spalteId']]->PPBoardSpalteData_HifeStatusInArbeit}}
Status OK: {{$t['Header2'][$t['spalteId']]->PPBoardSpalteData_HilfeStatusOK}}
Status Nicht OK: {{$t['Header2'][$t['spalteId']]->PPBoardSpalteData_HilfeStatusNOK}}"/></td>
                                                <td class="value" style="width:400px;">{{$t['terminart']}}  {{$t['spalteId']}}</td>
                                                <td class="label" style="width:150px;">Meilenstein: {{$crd->format('W')}}</td>
                                                <td class="value" style="width:300px;"> @if ($t['rot'] != '' or $t['rot'] == 0 )Soll: CRD {{$t['rot'] +10}} Wochen @endif
                                                    KW @if ($crd->format('W')+$t['rot']+10 <  0){{$crd->format('W')+$t['rot']+62}}/{{$crd->format('y')-1}} @else @if ($crd->format('W')+$t['rot']+10 > 52 )  {{$crd->format('W')+$t['rot']-42}}/{{$crd->format('y')+1}} @else  {{$crd->format('W')+$t['rot']+10}}/{{$crd->format('y')}}@endif @endif</td>
                                            </tr>
                                            <tr>
                                                <td class="label">IAN:</td>
                                                <!-- td class="value"><a href="/showAfterUpload/{{$pp['id']}}/1" target="_blank">{{$pp['ian']}}</a></td -->
                                                <td class="value"><a href="/show/{{$pp['id']}}" target="_blank">{{$pp['ian']}}</a></td>
                                                <td class="label">@CRD:</td>
                                                <td class="value">{{ $crd->format('W/y') }} <input type="hidden" id="CRD_Date" value="{{  $crd->format('Y-m-d') }}" /></td>
                                            </tr>
                                            <!-- tr>
                                                <td class="label">Lieferant:</td>
                                                <td class="value">@if (isset($po['supplierid']))
                                                    <a href="adressen/show/{{$po['supplierid']}}" target="_blank">{{$po['supplier']}}</a>
                                                    @if ($t['terminart'] == 'BSCI' and isset($po['bsci']))<br>BSCI
                                                    gültig bis: {{$po['bsci']}}@endif
                                                    @endif
                                                </td>
                                                <td class="label">DDP:</td>
                                                <td class="value">{{$pp['ddpltw']}}/{{$pp['ddplty']}}</td>
                                            </tr -->
                                            <tr>
                                                <td class="label">Status:</td>
                                                <td class="value">{{$pp['InternerStatus']}}</td>
                                                <td class="label">DDP:</td>
                                                <td class="value">{{$pp['ddpltw']}}/{{$pp['ddplty']}}</td>
                                            </tr>
                                            <tr>
                                                <td class="label">PM/TC</td>
                                                <td class="value" style='vertical-align:top;'><b>PM:</b> {{ isset($mitarbeiterNamen[$pp['PM']]->PPMitarbeiter_Kuerzel)?$mitarbeiterNamen[$pp['PM']]->PPMitarbeiter_Kuerzel:"N.N.";  }}   <b>TC:</b> {{ isset($mitarbeiterNamen[$pp['TC']]->PPMitarbeiter_Kuerzel)?$mitarbeiterNamen[$pp['TC']]->PPMitarbeiter_Kuerzel:"N.N.";  }}</td>
                                                <td class="label" title="In der Terminliste mit '*' gekennzeichnet">man. Soll: <span style="color:darkblue;font-weight:bold;">(*)</span></td>
                                                <td class="value" style="vertical-align:top;">
                                                    <?php
                                                    $dx = null;
                                                    $dx2 = null;
                                                    $wochen=null;
                                                    $ms = $t['ManSoll'];
                                                    $t['ManSoll']=null;
                                                    if ($t['ManSoll'] != 0) {
                                                        $crd->modify('-' . $t['ManSoll'] . ' week');
                                                        $dx = $crd->modify('next friday')->format('d.m.Y');
                                                    }
                                                    if ($t['ManSollDate'] != '0000-00-00 00:00:00'){
                                                        $msd = new DateTime($t['ManSollDate']);
                                                        $dx2 = $msd->format('d.m.Y');
                                                        $diff = $msd->diff($crd,1);
                                                        $tage = $diff->format('%R%a');
                                                        $wochen = floor($tage/7)+1;   
                                                    }
                                                    ?>
                                                    @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                                        <input class="datepickerAll" name="Termine_ManSollD{{$t['id']}}" id="Termine_ManSollD{{$t['id']}}" value='{{$dx2}}' />
                                                    @else 
                                                        <input type="hidden" class="datepickerAll" name="Termine_ManSollD{{$t['id']}}" id="Termine_ManSollD{{$t['id']}}" value='{{$dx2}}' />   
                                                    @endif
                                                    <!-- div>{{$t['id']}} ExW: {{ $ms }} Datum: {{$t['ManSollDate']}}  DX: {{$dx}} DX2: {{$dx2}} </div -->
                                                    <div style="margin-top:8px;">CRD - <input disabled style="padding:5px; width:60px;" name="Termine_ManSoll{{$t['id']}}" id="Termine_ManSoll{{$t['id']}}" value="{{ $wochen??''}}" /> Wochen 
                                                    @if ($t['ManSoll'] != 0) => KW
                                                    @if ($pp['crdltw']-$t['ManSoll'] <= 0) 
                                                        {{$pp['crdltw']-$t['ManSoll']+52}}/{{$pp['crdlty']-1}} 
                                                    @else 
                                                        {{$pp['crdltw']-$t['ManSoll']}}/{{$pp['crdlty']}}
                                                    @endif 
                                                    @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table id="data2">
                                            <tr>
                                                <td class="iHLabel" style="width:132px;">Status</td>
                                                <td class="iHLabel" style="width:270px;">Zuständig</td>
                                                <td class="iHLabel"  title="In der Terminliste mit '.' gekennzeichnet">erledigen bis <span style="color:darkblue;font-weight:bold;">(.)</span></td>
                                                <td class="iHLabel">erledigt am</td>
                                                <td class="iHLabel">Anzeigetext</td>
                                                <td class="iHLabel">Bemerkung</td>
                                                <td class="iHLabel" style="width:68px;">store</td>
                                            </tr>
                                            <tr>
                                                <td class="iHValue">@if (strpos($t['status'],'FREEZE') !== false )
                                                                        <!-- span>{{$t['status']}}</span -->
                                                                        <select id='Termine_Status' name='Termine_Status' style='width:120px;padding:5px;'>
                                                                        <option selected >FREEZE</option>
                                                                        @foreach ($t['stati'] as $st1)
                                                                            <option >{{$st1}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    @else 
                                                                          {{Form::select('Termine_Status',$t['stati'],$t['status'],array('id'=>'Termine_Status'.$t['id'],'style'=>"width:120px;padding:5px;"))}}
                                                                    @endif
                                                </td>
                                                <td class="iHValue">{{--
                                                    Form::select('Termine_Mitarbeiter',$mitarbeiterliste,$t['ma'],array('id'=>'Termine_Mitarbeiter'.$t['id'],'style'=>"width:100px;padding:5px;"))
                                                    --}}
                                                    <select id="Termine_Mitarbeiter{{$t['id']}}" style="width:250px;padding:5px;">
                                                        @foreach($mitarbeiterliste as $maid => $ma)
                                                        <option  title='{{ isset($mitarbeiterNamen[$maid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$maid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$maid]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{$maid}}" @if($t['ma'] == $maid) selected @endif  >{{$ma}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="iHValue">{{
                                                    Form::text('Termine_Datum',substr($t['start'],0,10), array('style'
                                                    => 'width:100px;' ,
                                                    'id'=>'Termine_Datum'.$t['id'],'class'=>'datepickerZukunft'))}}</td>
                                                <td class="iHValue">{{
                                                    Form::text('Termine_Datum_Ende',substr($t['ende'],0,10),
                                                    array('style' => 'width:100px;'
                                                    ,'id'=>'Termine_Datum_Ende'.$t['id'],'class'=>'datepicker'))}}</td>
                                                <td class="iHValue" style="padding:0px;">
                                                    <textarea class="text1" name="Termine_Label{{$t['id']}}" id="Termine_Label{{$t['id']}}">{{$t['label']}}</textarea>
                                                </td>
                                                <td class="iHValue" style="padding:0px;">
                                                    <textarea class="text1" name="Termine_Bemerkung{{$t['id']}}" id="Termine_Bemerkung{{$t['id']}}">{{$t['bemerkung']}}</textarea>
                                                </td>
                                                <td class="iHValue" style="text-align:center;padding:0px;"> @if (Auth::User()->PPMitarbeiter_Gruppe == 'user' or
                                                    Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                                        <button type="button" id="ajaxCall_SaveDateX" onclick="saveTermin('{{$t['id']}}');" style="padding:0px;"><img src="/data/Icons/speichern.png" style="width:68px;" /></button>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="7">
                                                    <table style="font-size:0.7rem;font-weight: bold;color:gray;">
                                                        <tr>
                                                            <td style="width:100px;padding:0px;">In Arbeit:</td>
                                                            <td style="padding:0px;">{{$t['Header2'][$t['spalteId']]->PPBoardSpalteData_HifeStatusInArbeit}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0px;">Status OK:</td>
                                                            <td style="padding:0px;">{{$t['Header2'][$t['spalteId']]->PPBoardSpalteData_HilfeStatusOK}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding:0px;">Status Nicht OK:</td>
                                                            <td style="padding:0px;">{{$t['Header2'][$t['spalteId']]->PPBoardSpalteData_HilfeStatusNOK}}</td>
                                                        </tr>
                                                    </table>  
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="buttonHistory" style="float:left;border:none;width:520px;overflow:auto;height:281px;position: relative;right: 0px;">
                                        <div style="position: absolute; bottom:10px; left:10px;border: 1px solid gold;"><button type="button" onclick="History(0);">History</button></div>
                                    </div>
                                    <div id="boxHistory" style="margin-left:5px;border:1px solid lightgray;width:520px;overflow:auto;height:281px;text-align: left;display:none;">
                                        <textarea style="width:100%;height:240px;padding:5px;">{{ str_replace('*','',str_replace('* ', '', $t['history'])) }}</textarea>
                                        <button type="button" style="margin-top:5px;margin-left: 5px;" onclick="History(1);">Close</button>
                                    </div>
                                </div>
                            </div>
                            <div style="clear:both;height:0px;">&nbsp;</div>
                        </fieldset>
                    </form>
                </div>
                @if ($t['terminart'] == "Nacharbeit")
                <div style="border-top:1px solid #003D7C;border-bottom:1px solid #003D7C; padding:4 0 4 10; border-radius:0px;height:58px;">
                    <?php $i = 1; ?>
                    @foreach ($termineMusterung as $tm)
                    <div style="float:left;width:150px;">
                        <input type="checkbox" id="{{$tm->PPBoardSpalte_Bezeichnung}}_{{$t['id']}}" name="{{$tm->PPBoardSpalte_Bezeichnung}}"><span style="color:#003D7C;font-size: 11px;">{{$tm->PPBoardSpalte_Bezeichnung}}</span>
                    </div>
                    <?php
                    if (($i % 9) == 0) {
                        echo ("<div style='clear:both;'></div>");
                    }
                    $i++;
                    ?>
                    @endforeach
                </div>
                @endif
                <div style="padding: 0px; border: 1px solid #003D7C; border-radius: 0px;  padding:10px; margin-top: 8px;">
                    <div style="padding-top: 4px; padding-bottom: 4px;text-align: left;">
                        <span style="font-size:18px; font-weight: bold;padding: 5px; padding-top:8px; padding-bottom: 8px;color:#b89c50;">Unteraufgabe</span>
                    </div>
                    <div style="border:none;">
                        <div style="border:none;">
                            <form id="frmTheme{{$t['id']}}" Method="post" action="#" enctype="multipart/form-data">
                                <input type="hidden" id="Theme_PPId_{{$t['id']}}" value="{{$pp['id']}}" />
                                <div class="hist" style="border:none;">
                                    <table id="data3" style="margin-top:10px;table-layout: fixed;border-radius: 10px;border-collapse: collapse;">
                                        <tr>
                                            <td class="iHLabel" style="width:250px;">Todo</td>
                                            <td class="iHLabel" style="width:70px;">Zuständig</td>
                                            <td class="iHLabel" style="width:100px;">erledigen bis</td>
                                            <td class="iHLabel" style="width:338px;">Bemerkung</td>
                                            <td class="iHLabel" style="width:100px;">Upload</td>
                                            <td class="iHLabel" style="width:68px;">store</span></td>
                                        </tr>
                                        <tr>
                                            <td class="iHValue">
                                                <input id="Theme_Categorie_{{$t['id']}}" style="padding: 5px;width:250px" />
                                                <!-- <select id="Theme_Categorie_{{$t['id']}}" style="padding: 5px;">
                                                    <option>Sonstige</option>
                                                    <option>Mengendifferenz</option>
                                                    <option>Qualität</option>
                                                    <option>Farbe</option>
                                                </select> -->
                                            </td>
                                            <td class="iHValue"><select id="Theme_Bearbeiter_{{$t['id']}}" style="padding: 5px;">
                                                    <option title='' value="0">Bitte auswählen...</option>
                                                    @foreach ($mitarbeiterliste as $mid => $ma)
                                                    <option title='{{ isset($mitarbeiterNamen[$mid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$mid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$mid]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{$mid}}">{{$ma}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="iHValue"><input class="datepickerZukunft" style='width:90px;' id="Theme_DoUntil_{{$t['id']}}" value="{{$sDP7}}" /></td>
                                            <td class="iHValue" style="padding:0px;"><textarea id="Theme_Remark_{{$t['id']}}" placeholder="Bemerkung" style="width:100%;height:74px; border:none;padding:4px;"></textarea></td>
                                            <td class="iHValue" style="padding:0px;">
                                                <div style="padding: 0px;">
                                                    <div class="dropCTheme" id="dropContainer_{{$t['id']}}" style="border-radius: 0px;border:none;height:50px; padding:4px;vertical-align:central; text-align:center;color:white;width:100px;">
                                                        <img src="/data/Icons/upload.png" style="width:100px;" />
                                                    </div>
                                                    <input type="file" id="Theme_File_{{$t['id']}}" style="display: none;" />
                                                </div>
                                            </td>
                                            <td class="iHValue" style="padding:0px;">
                                                <div id="ani_{{$t['id']}}" style="display: none;">
                                                    <img src="/data/uploads/BilderTextbausteine/animated_upload.gif" />
                                                </div>
                                                <div id="btn_{{$t['id']}}">
                                                    @if (Auth::User()->PPMitarbeiter_Gruppe == 'user' or
                                                    Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                                    <button type="button" id="ajaxCall_SaveDateX" onclick="cpc_newTheme('{{$t['id']}}')" style="padding:0px;">
                                                        <img src="/data/Icons/speichern.png" style="width:68px;" />
                                                    </button><br>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div style="border:none;height:340px; overflow: auto;padding:0px;margin-top:8px;">
                    <div class="terminHist" style="margin:0px auto;width:100%;padding: 0px;">
                        <div class="thRow" style="display:none;">
                            <div class="thHeader">Status</div>
                            <div class="thHeader">ToDo</div>
                            <div class="thHeader">Erledigen durch</div>
                            <div class="thHeader">Erledigen bis</div>
                            <div class="thHeader">Bemerkung</div>
                            <div class="thHeader">Upload</div>
                            <div class="thHeader"></div>
                        </div>
                    </div>
                    <div style='border:1px solid #003D7C;overflow: auto;height:300px;margin-top:8px;border-radius: 0px;'>
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
            if (show) {
                btn.style.display = '';
                hist.style.display = 'none';
            } else {
                btn.style.display = 'none';
                hist.style.display = '';
            }
        }
        function ajax_getTerminTab(ppid, tid, board, select, openOnly) {
            //alert ('Open Window:  ' + ppid + ' ' + tid + ' ' + board + ' ' + select + ' ' + openOnly);
            window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board + "/" + select + "/" + openOnly, "_self", "toolbar=yes, scrollbars=yes, resizable=yes, top=10,left=10,width=1697, height=1255");
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
            if (readValue($("#Theme_Bearbeiter_" + id)[0]) == 0) {
                alert("Bitte zuständigen Mitarbeiter angeben!");
                return;
            }  
            cat = readValueFromId("Theme_Categorie_" + id);
            if (cat != null && cat.length < 2 ){
                alert("Bitte ToDo angeben!");
                return;
            }
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
        function parseDate(input,fmt='') {
            var parts = input.match(/(\d+)/g);
            console.log (parts);
            // note parts[1]-1
            ret = '';
            try{
                if (fmt == 'de'){
                    ret = new Date(parts[2], parts[1]-1, parts[0]);
                } else {
                    ret = new Date(parts[0], parts[1]-1, parts[2]);
                }
            }
            catch (err){
            }
            return ret;
        }
        function saveTermin(id) {
            crd = document.getElementById('CRD_Date').value;
            crdD = parseDate(crd);
            manSoll = document.getElementById('Termine_ManSollD' + id).value;
            manSollD = parseDate(manSoll,'de');
            erlBis = document.getElementById('Termine_Datum' + id).value;
            erlBisD = parseDate(erlBis,'de');
            if(manSoll != '' && manSollD  >= crdD){
                //alert("Man. Soll kann nicht später als CRD liegen!");
                //return;
            }
            if (manSollD != '' && erlBisD != '' && erlBisD > manSollD ){
                        //alert("Erledigen bis kann nicht später als man Soll liegen!");
                        //return;
             }
             if (manSollD == '' && erlBisD != '' && erlBisD > crdD ){
                        //alert("Erledigen bis kann nicht später als CRD liegen!");
                        //return;
             }
            if (readValue($("#Termine_Mitarbeiter" + id)[0]) == 0) {
                alert("Bitte zuständigen Mitarbeiter angeben!");
                return;
            }
            l = readValue($("#Termine_Label" + id)[0])
            s = readValue($("#Termine_Status" + id)[0])
            //if (s == 'OK' and  l.trim.lenghth < 1 ){
              //alert("Bitte Anzeigetext eintragen!");
             //return;
            //}
            if (s === 'OK' && l.length < 1){
                //alert("Bitte Anzeigetext eingeben, wenn Status auf OK gesetzt wird! Datensatz wurde noch nicht gespeichert!");
                //return;
            }
            console.log('STATUS:' + readValue($("#Termine_Status" + id)[0]));
            try {
                var values = {
                    "Termine_Id": id,
                    "Termine_Datum": readValue($("#Termine_Datum" + id)[0]),
                    "Termine_Status": readValue($("#Termine_Status" + id)[0]),
                    "Termine_Datum_Ende": readValue($("#Termine_Datum_Ende" + id)[0]),
                    "Termine_Label": readValue($("#Termine_Label" + id)[0]),
                    "Termine_Bemerkung": readValue($("#Termine_Bemerkung" + id)[0]),
                    "Termine_ManSoll": readValue($("#Termine_ManSoll" + id)[0]),
                    "Termine_ManSollD": readValue($("#Termine_ManSollD" + id)[0]),
                    "Termine_Mitarbeiter": readValue($("#Termine_Mitarbeiter" + id)[0]),
                    "StatChange_Categorie": readValue(document.getElementById("StatChange_CategorieM_" + id)),
                    "StatusRemark": readValue(document.getElementById("StatChange_Remark_" + id)),
                    "StatusPPId": readValue(document.getElementById("StatChange_PPId_" + id))
                };
                //console.log(values);
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
            console.log(jsonResult);
            location.reload();
        }
        function xDelete(id) {
            var answer = window.confirm("Datensatz wirklich löschen?");
            if (!answer) {
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
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
        function xRestore(id) {
            var frmData = new FormData();
            frmData.append("PPChanges_Id", id);
            $.ajax({
                type: "POST",
                url: "/deletePPChangesReverse",
                data: frmData,
                processData: false,
                contentType: false,
                success: xDeleteSuccess,
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
        function xDeleteSuccess() {
            location.reload();
        }
        $(function() {
            var elements = document.getElementsByClassName("dropCTheme");
            for (var i = 0; i < elements.length; i++) {
                elements[i].ondragover = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondragenter = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondrop = function(evt) {
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
        $(function() {
            var elements = document.getElementsByClassName("dropC");
            for (var i = 0; i < elements.length; i++) {
                elements[i].ondragover = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondragenter = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondrop = function(evt) {
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
        $(function() {
            var elements = document.getElementsByClassName("xdropC");
            for (var i = 0; i < elements.length; i++) {
                elements[i].ondragover = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondragenter = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondrop = function(evt) {
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
            if (jsonResult.func == 'newTheme'){
                //alert ("zurück aus der Zukunft");
                window.location.href = window.location.href;
                return;
            }
            msg = document.getElementById("ajaxCall_SaveDateX");
            if (msg){
                msg.innerHTML = "<div style='background-color:lime;width:100%; height:40px;padding:0px;vertical-align:middle;'>gespeichert</div>";
            }
            console.log("Success: OK ");
            console.log(jsonResult);
            //alert(jsonResult );
            id = 0;
            try {
                id = jsonResult.id;
            }
            catch(err) {
                console.log (err);
            }
            //console.log(jsonResult.Theme_TId);
            //var id = jsonResult.id;
            ani = document.getElementById("ani_" + id);
            if (ani) {
                ani.style.display = "none";
            }
            btn = document.getElementById("btn_" + id);
            if (btn) {
                btn.style.display = "block";
            }
            remark = document.getElementById("Theme_Remark_" + id);
            if (remark){
                remark.value = "";
            }
            bearbeiter = document.getElementById("Theme_Bearbeiter_" + id);
            if (bearbeiter){
                bearbeiter.value = "";
            }
            todo = document.getElementById("Theme_Categorie_" + id);
            if (todo){
                todo.value = "";
            }
            console.log ("Reload Window");
            window.location.reload();
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
                error: function(xhr, ajaxOptions, thrownError) {
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
                success: function(msg) {
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
                error: function(xhr, ajaxOptions, thrownError) {
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
        $(function() {
            var elements = document.getElementsByClassName("dropCPopUp");
            for (var i = 0; i < elements.length; i++) {
                elements[i].ondragover = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondragenter = function(evt) {
                    evt.preventDefault();
                };
                elements[i].ondrop = function(evt) {
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
        /*function readValueFromId(elemName) {
            //console.log (elemName + " TEST");
            elem = document.getElementById(elemName);
            if (elem != null) {
                return elem.value;
            }
            console.log(elemName + " is NULL");
            return null;
        }*/
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
            } catch (e) {
                console.log(e.message);
            }
            console.log(values);
        }
        function xStore(id) {
            console.log("xStore: " + id);
            try {
                var values = {
                    "PPTermineChanges_Id": id,
                    "PPTermineChanges_NewReceiver": readValueFromId("StatChange_NewReceiver_" + id),
                    "PPTermineChanges_NewRemark": readValueFromId("StatChange_NewRemark_" + id),
                    "PPTermineChanges_NewRemarkReceiver": readValueFromId("StatChange_NewRemarkReceiver_" + id),
                    "PPTermineChanges_NewDoUntil": readValueFromId("StatChange_DoUntil_" + id),
                }
                var jsonString = JSON.stringify(values);
                type = "POST";
                cpc_SendAjaxJsonRequest("/termineModifyState", jsonString, null, id, type);
            } catch (e) {
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
                    "PPTermineChanges_NewReceiver": readValueFromId("StatChange_NewReceiver_" + id),
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
            } catch (e) {
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
                error: function(xhr, ajaxOptions, thrownError) {
                    //alert("Fehler: " + url);
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
        function setErledigt(tid, id, board) {
            //alert(tid + " - " + id);
            var frmData = new FormData();
            frmData.append('id', id);
            frmData.append('tid', tid);
            frmData.append('board', board);
            $.ajax({
                type: "POST",
                url: "/setChangeErledigt",
                data: frmData,
                processData: false,
                contentType: false,
                success: onSuccessSetErledigt,
                error: function(xhr, ajaxOptions, thrownError) {
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
                error: function(xhr, ajaxOptions, thrownError) {
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
        $(".datepickerAll").datepicker({
            locale: 'de',
            numberOfMonths: 1,
            showButtonPanel: false,
            showWeek: true,
            firstDay: 1,
            dateFormat: "dd.mm.yy",
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        });
        $(".datepicker").datepicker({
            locale: 'de',
            maxDate: '0d',
            numberOfMonths: 1,
            showButtonPanel: false,
            showWeek: true,
            firstDay: 1,
            dateFormat: "dd.mm.yy",
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        });
        $(".datepickerZukunft").datepicker({
            locale: 'de',
            minDate: '0d',            
            numberOfMonths: 1,
            showButtonPanel: false,
            showWeek: true,
            firstDay: 1,
            dateFormat: "dd.mm.yy",
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
            dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
            dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
            dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        });
    </script>