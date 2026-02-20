<style>
    .schedule {
        border:none;
        overflow: auto;
        border-radius: 0px;
    }
    .terminHist td {
        border: 1px solid lightskyblue;
        height:25px; padding:5px;text-align: left;
    }
    .terminHist th {
        border: 1px solid lightskyblue;
        background-color: lightgray;
        height:25px;
        font-weight: bold;
        padding: 5px;
        text-align: left;
    }
    .overlay {
        background-color: #c0c0c0;
        border-radius:0px;
        z-index: 99;
        display: none;
        width:1575px;
        position:fixed;
        top:83px;
        left:20%;
        border:3px solid darkgray;
        height:1000px;
        overflow: auto;
    }
    .schedule table {
        margin:0px;
        font-family: Tahoma;
        font-size: 11px;
        border-collapse: collapse;
        table-layout: fixed;
        border:none;
        font-family: tahoma;
    }
    .tdHeader {
        height: 80px;
        width:20px;
        padding: 0px;
    }
    .tdRow {
        height: 20px;
        padding: 0px;
        width:20px;
    }
    .rotateX {
        font-family: Tahoma;
        font-size: 8px;
        background-color: lightskyblue;
        border-radius: 0px;
        height:20px;
        width:120px;
        padding:6px;
        /* FF3.5+ */
        -moz-transform: rotate(-90.0deg);
        /* Opera 10.5 */
        -o-transform: rotate(-90.0deg);
        /* Saf3.1+, Chrome */
        -webkit-transform: rotate(-90.0deg);
        /* IE6,IE7 */
        filter: "progid DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
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
        padding: 0px;
        border-collapse: separate;
        border-spacing: 0;
    }
   .table thead {
        position: sticky;
        position: -webkit-sticky; 
        border:none;
        z-index:11200;
        top:0;
   }
   .table thead::after,
   .table thead::before {
  content: '';
  position: absolute;
  left: 0;
  width: 100%;
}
.table thead::before {
  top: 0;
  border-top: 1px solid gray;
  margin-top: -0.5px;
}
.table thead::after {
  bottom: 0;
  border-bottom: 1px solid gray;
}
    .table-row {
        display: table-row; 
    }
    .table-row-header {
        display: table-row; 
    }
    .table-cell {
        display: table-cell;
                 vertical-align: top;
                 border:1px solid #003D7C;
                 min-width: 10px;
                 max-width: 20px;
                 overflow: hidden;
                 border-radius:0px;
                 padding: 3px;
    }
    .table-cell_value {
        display: table-cell;
                       border:1px solid lightgray;
                       min-width: 10px;
                       max-width: 20px;
                       border-radius:0px;
                       padding: 0px;
    }
    .table-cell-header-rotate1 {
        display: table-cell;
        border:1px solid gray;
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
        filter: "progid DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
        /* IE8 */
        -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0.083)";
        /* Standard */
        transform: rotate(-90.0deg);
    }
    .table-cell-header-rotate{
        display: table-cell;
        border:1px solid #003D7C;
        background-color: white;
        border-radius: 0px;
        padding:3px;
        position:relative;
    }
    .table-cell-header {
        display: table-cell;
        border:1px solid lightgray;
        min-width: 10px;
        max-width: 10px;
        min-height: 40px;
        max-height: 40px;
        height: 40px;
        overflow: hidden;
    }
    .termin_cell{
        width:18px;
        height:20px;
        border:none;
        padding:0px;
        overflow:hidden;
        font-size:8px;
        border-radius: 0px;
    }
    .rotate {
        transform: rotate(-90deg);
        transform-origin: left top;
        position: absolute;
        bottom: 0;
        left:5%;
        white-space: nowrap;
        font-family: Tahoma;
        font-size: 12px;
        margin-left:3px;
    }
    #cFormHeader input {
        padding:6px;
    }
    .termineHeader {
        border-collapse: collapse;
        font-family: tahoma;font-size: 12px;
        display: table
    }
    .termineHeader .row {
        display: table-row;
    }
    .termineHeader .cell {
        border: 1px solid #003D7C;
        padding:6px;
        width:120px;
        display: table-cell;
        vertical-align: top;
    }
    .termineHeader .label {
        border: 1px solid #003D7C;
        vertical-align: top;
        padding:6px;
        background-color: white;
        border-radius: 0px;
        width:120px;
        display: table-cell;
    }
    .termineHeader .trenner {
        width: 8px;
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
        background-color: white;
        font-weight: bold;
        color:#003D7C;
        border: 1px solid #003D7C;
    }
    .terminHist .thHeader2 {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        background-color: #c0c0c0;
        font-weight: bold;
        color:#003D7C;
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
        border:1px solid lightgray;
    }
    .terminHist .thCellNew {
        border-radius: 0px;
        display: table-cell;
        padding: 8px;
        padding-top: 4px;
        padding-bottom: 4px;
        vertical-align: top;
        border:1px solid #003D7C;
        background-color: #cccccc;
        color: #003D7C;
        font-weight: bold;
    }
    .bold {
        font-weight: bold;
        padding-left:4px;
    }
    .searchTab td {
        padding-left:5px;
        padding-right:5px;
    }
    .cpcStickycol {
        border:none;
        position: sticky;
        position: -webkit-sticky;
        left:0px;
        z-index: 11100;
        width:80px;
        min-width:80px;
        max-width:800px;
    }
    .cpccol2 {
        min-width:50px;
    }
    .cpccol3 {
        min-width:120px;
    }
    .cpccol4 {
        min-width:100px;
    }
    .cpccol5 {
        min-width:130px;
    }
    .cpccol6 {
        min-width:60px;
    }
    .cpccol7 {
        min-width:70px;
    }
    .cpccol8 {
        min-width:100px;
    }
    .cpccol9 {
        min-width:100px;
    }
    .cpccolAll {
        width:auto;
    }
    .searchTab label {
    color:red;text-align:left;
}
.stLabel {
    font-size: 0.7rem;
    padding:4px;
    padding-left: 8px;
    color:darkblue;
    font-weight: bold;
    background-color: #efefef;
    border-radius:0px;
    border:1px solid darkblue;
    text-align: left;
}
.stValue {
    border:1px solid darkblue;
    border-radius:0px;
    text-align: left;
} 
.stValue select {
    width:100%;
    height:100%;
    border:none;
    font-size:0.7rem;
    padding:4px;
}
.stValue input {
    width:100%;
    height:100%;
    border: none;
    font-size:0.7rem;
    padding:4px;
}
</style>
<?PHP
if ($kalender['HasData']) {
    $headers          = $kalender['Termine']['Header'];
    $values           = $kalender['Termine']['Values'];
    $termineMusterung = $kalender['TermineMusterung'];
    $statiAll         = $kalender['Termine']['StatiAll'];
}
$board     = $kalender['Board'];
$PMs       = $kalender['PMs'];
$TCs       = $kalender['TCs'];
$mitarbeiterliste   = $kalender['mitarbeiterliste'];
$mitarbeiterNamen   = $kalender['mitarbeiterNamen'];
$lproject  = "";
$lcolor    = 0;
?>
<div style="text-align: left;border-radius: 0px;margin-top:15px;">
    @foreach ($SALs as $sal)
    @if ($board == $sal->PPBoard_Id)
    <div style="position:relative;padding:10px;font-weight: bold;font-size:24px;background-color:#003D7C; color:white;width:98%;vertical-align: middle; border-radius:0px;margin:0px;">{{ $sal->PPBoard_Bezeichnung }}<img src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" style="position:absolute;top:0px;right:0px;height:52px;"/></div>
    @endif
    @endforeach
    @if ($board ==  2000)
            <div style="position:relative;padding:10px;font-weight: bold;font-size:24px;background-color:#003D7C; color:white;width:98%;vertical-align: middle; border-radius:0px;margin:0px;">Dashboard Archiv (GELIEFERT)<img src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" style="position:absolute;top:0px;right:0px;height:52px;"/></div>
    @endif
    @if ($board ==  2002)
            <div style="position:relative;padding:10px;font-weight: bold;font-size:24px;background-color:#003D7C; color:white;width:98%;vertical-align: middle; border-radius:0px;margin:0px;">Dashboard Archiv (ABSAGE)<img src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" style="position:absolute;top:0px;right:0px;height:52px;"/></div>
    @endif
</div>
<div style="padding:4px;border: none; border-radius:0px;">
    {{ Form::open(array('url' => 'termine','style'=>'color:darkblue;margin:5px;', 'id'=>'formgetTermine','onkeypress' => 'submitFormX(event);')) }}
    <input type="hidden" name="inp_board" value="{{$board}}">
    <!-- select name="inp_board">
        <option value="5" @if ($board == 5) selected @endif>SAL</option>
        <option value="6" @if ($board == 6) selected @endif>BWE</option>
        <option value="10" @if ($board == 10) selected @endif>Musterung</option>
    </select-->
    <!-- input type="hidden" name="inp_board" value="{{$board}}" -->
    <div id="cFormHeader" style="border:none;" >
        <div class="searchTab"  style="display:grid;grid-template-columns: repeat(auto-fit, 120px 200px);grid-gap:10px; font-family:tahoma; font-size:14px;border:none;border-radius:0px;max-height:110px;overflow:auto;">
                <div class='stLabel'>IAN</div>
                <div class='stValue'>
                    <input id="inpFormIAN" name="sQry[PPProduktpass_IAN]" placeholder="IAN"  @if (isset($kalender['SP'])) value="{{$kalender['SP']['PPProduktpass_IAN']}}" @endif />
                </div>
                <div class='stLabel'>Artikel</div>
                <div class='stValue'><input id="inpFormArtikel" name="sQry[PPProduktpass_Artikelbezeichnung]" placeholder="Article" @if (isset($kalender['SP'])) value="{{isset($kalender['SP']['PPProduktpass_Artikelbezeichnung'])?$kalender['SP']['PPProduktpass_Artikelbezeichnung']:''}}" @endif/></div>
                <div class='stLabel'>Musterung</div>
                <div class='stValue'><input  id="inpFormMusterung"  name="sQry[PPProduktpass_Ausmusterungnummer]" placeholder="Musterung" @if (isset($kalender['SP'])) value="{{$kalender['SP']['PPProduktpass_Ausmusterungnummer']}}" @endif /></div>
                <div class='stLabel'>PM</div>
                <div class='stValue'>                    
                    <select  id="inpFormPM"  name="sQry[PMler]" >
                        @foreach ($PMs as $id => $mx5)
                        <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}'  value="{{ $mx5}}" @if(isset($kalender['SP']['PMler']) && $kalender['SP']['PMler']  == $mx5 ) selected @endif >{{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- 
                <div class='stLabel'>Warengruppe</div>
                <div class='stValue'><input  id="inpFormwarengruppe"  name="sQry[PPProduktpass_Warengruppe]" placeholder="Warengruppe" @if (isset($kalender['SP'])) value="{{isset($kalender['SP']['PPProduktpass_Warengruppe'])?$kalender['SP']['PPProduktpass_Warengruppe']:''}}" @endif/></div>
                <div class='stLabel'>Thema</div>
                <div class='stValue'><input  id="inpFormThema" name="sQry[PPProduktpass_Thema]" placeholder="Thema" @if (isset($kalender['SP'])) value="{{isset($kalender['SP']['PPProduktpass_Thema'])?$kalender['SP']['PPProduktpass_Thema']:''}}" @endif /></div>
                --}}
                <div class='stLabel'>Lidl Status</div>
                <div class='stValue'><select  id="inpFormLidlStatus" name="sQry[statusDoc]">
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == '%' ) selected @endif  value="%">Alle</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'submit' ) selected @endif value="submit">submit</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'open' ) selected @endif value="open">open</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'declined' ) selected @endif value="declined">declined</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'PPCHANGEHG' ) selected @endif value="PPCHANGEHG">PPCHANGEHG</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'TEMPPPHG' ) selected @endif value="TEMPPPHG">TEMPPPHG</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'RFQHG' ) selected @endif value="RFQHG">RFQHG</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'PPCHANGEHG' ) selected @endif value="PPCHANGEHG">PPCHANGEHG</option>
                        <option @if ( isset($kalender['SP']['statusDoc']) && $kalender['SP']['statusDoc']  == 'RFSHG' ) selected @endif value="RFSHG">RFSHG</option>
                    </select>
                </div>
                <div class='stLabel'>Interner Status</div>
                <div class='stValue'><select  id="inpFormInternerStatus"  name="sQry[InternerStatus]">
                        <option @if ( isset($kalender['SP']['InternerStatus']) && $kalender['SP']['InternerStatus']  == '%">' ) selected @endif  value="%">Alle</option>
                        <option @if ( isset($kalender['SP']['InternerStatus']) && $kalender['SP']['InternerStatus']  == 'MUSTERUNG' ) selected @endif  value="MUSTERUNG" >MUSTERUNG</option>
                        <option @if ( isset($kalender['SP']['InternerStatus']) && $kalender['SP']['InternerStatus']  == 'PLAN' ) selected @endif  value="PLAN" >PLAN</option>
                        <option @if ( isset($kalender['SP']['InternerStatus']) && $kalender['SP']['InternerStatus']  == 'FIX' ) selected @endif  value="FIX" >FIX</option>
                        <option @if ( isset($kalender['SP']['InternerStatus']) && $kalender['SP']['InternerStatus']  == 'GELIEFERT' ) selected @endif  value="GELIEFERT" >GELIEFERT</option>
                        <option @if ( isset($kalender['SP']['InternerStatus']) && $kalender['SP']['InternerStatus']  == 'ABSAGE' ) selected @endif  value="ABSAGE" >ABSAGE</option>
                    </select>
                </div>
                <div class='stLabel'>TC</div>
                <div class='stValue'>
                    <select  id="inpFormTC" name="sQry[TCler]">
                        {{isset($kalender['SP']['PPProduktpass_Thema'])?$kalender['SP']['PPProduktpass_Thema']:''}}
                        @foreach ($TCs as $id => $mx5)
                          <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{ $mx5}}" @if(isset($kalender['SP']['TCler']) && $kalender['SP']['TCler']  == $mx5 ) selected @endif >{{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='stValue'><input  id="inpFormPPProduktpass_RevisionDatum"  name="sQry[PPProduktpass_RevisionDatum]" placeholder="Import: 2023-10-24" @if (isset($kalender['SP'])) value="{{isset($kalender['SP']['PPProduktpass_RevisionDatum'])?$kalender['SP']['PPProduktpass_RevisionDatum']:''}}" @endif/></div>
                <div class='stValue'><button id="submitFormBtn" type="submit" value="anzeigen" style="width:100%;height:30px;"><b>Anzeigen</b></button></div>
                <div></div>
                <div class='stValue'><button id="submitFormBtn" type="button" style="width:100%;height:30px;" onclick="rstForm();"><b>Zurücksetzen</b></button></div>
                <div class='stValue'><button id="submitFormBtn" type="button" style="width:100%;height:30px;" onclick="saveFilter();"><b>Filter speichern</b></button></div>
                <div class='stValue'><button id="submitFormBtn" type="button" style="width:100%;height:30px;" onclick="getFilter();"><b>Filter laden</b></button></div>
        </div>
    </div>
    {{Form::close()}}
</div>
<?php 
$browser = 'ALL';
if (strpos($_SERVER['HTTP_USER_AGENT'],'Fire') !==false){
    $browser = 'FF';
}
?>
@if ( $kalender['HasData'])
<!-- geht in Chrome und Edge div class="schedule" style="text-align:left;width:calc(100% - 5px);height:calc(100% - 190px);overflow: auto;border:1px solid darkblue;margin:0px;padding:0px;position:relative;" -->
@if ($browser !== 'FF')
<div class="schedule" style="text-align:left;width:calc(100% - 15px);height:calc(100% - 200px);overflow: auto;border:1px solid darkblue;margin:0px;padding:0px;position:relative;">
@else
<div class="schedule" style="text-align:left;width:calc(100vw - 20px);height:calc(100vh - 270px);overflow: auto;border:1px solid darkblue;margin:0px;padding:0px;position:relative;">
@endif
    <table class="table">
        <thead>
        <tr class="table-row-header">
            <!-- Spalte 10-->
            <th class="table-cell-header-rotate cpcStickycol" style="background-clip: padding-box;border-bottom:none;"></th>
            <!-- Spalte 1-->
            <th class="table-cell-header-rotate cpccol2" style="background-clip: padding-box;border-bottom:none; width:50px;"></th>
            <!-- Spalte 6-->
            <th class="table-cell-header-rotate cpccol3" style="background-clip: padding-box;border-bottom:none; width:120px;"></th>
            <!-- Spalte 2-->
            <th class="table-cell-header-rotate cpccol4" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            @if($board == 10)
            <!-- Spalte 3-->
            <th class="table-cell-header-rotate cpccol5" style="background-clip: padding-box;border-bottom:none; width:130px;"></th>
            @endif
            <!-- Spalte 4-->
            <!-- td class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:100px;"></td -->
            <!-- Spalte 5-->
            <th class="table-cell-header-rotate cpccol6" style="background-clip: padding-box;border-bottom:none; width:60px;"></th>
            @if($board == 6)
            <!-- Spalte 7-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:50px;"></th>
            @endif
            @if($board < 1000)
            <!-- Spalte 8-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:80px;"></th>
            @endif
            <!-- Spalte 9-->
            <th class="table-cell-header-rotate cpccol7" style="background-clip: padding-box;border-bottom:none; width:70px;"></th>
            @if(Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <!-- Spalte 11-->
            <th class="table-cell-header-rotate cpccol8" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            @endif
            <!-- Spalte 12-->
            <th class="table-cell-header-rotate cpccol9" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            @if($board == 6)
            <!-- Spalte 12-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            <!-- Spalte 13-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:80px;"></th>
            <!-- Spalte 14-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:80px;"></th>
            <!-- Spalte 15-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:80px;"></th>
            <!-- Spalte 16-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:80px;"></th>
            <!-- Spalte 17-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:80px;"></th>
            <!-- Spalte 18-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            <!-- Spalte 19-->
            <th class="table-cell-header-rotate" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            @endif
            <?php
            $i         = 0;
            $a_oberbez = array();
            $temp_h    = "X";
            $colndx    = 0;
            foreach ($headers as $header) {
                $colors = array("white", "lightgray", "white",
                    "lightgray", "white",
                    "lightgray", "white", "lightgray", "white",
                    "lightgray", "white", "lightgray",
                    "white", "lightgray", "white", "lightgray",
                    "white", "lightgray", "white",
                    "lightgray", "white", "lightgray", "white",
                    "lightgray", "white", "lightgray",
                    "white", "lightgray");
                if ($temp_h !== $header->PPBoardSpalte_Oberbez) {
                    $i++;
                    $a_oberbez[$i]['bg']      = $colors[$colndx++];
                    $temp_h                   = $header->PPBoardSpalte_Oberbez;
                    $a_oberbez[$i]['bez']     = $header->PPBoardSpalte_Oberbez;
                    $a_oberbez[$i]['colspan'] = 1;
                }
                else {
                    $a_oberbez[$i]['colspan']++;
                }
            }
            ?>
            @foreach ($a_oberbez as $obez)
            <th class="table-cell-header-rotate cpccolAll" style="background-clip: padding-box; font-size:10px;padding:0px;background-color:<?php $obez['bg'] ?>;" colspan="{{$obez['colspan']}}"><div style="@if($obez['colspan'] == 1)width:22px;@else width:auto; @endif overflow:hidden;border-radius: 0px;border:none;background-color: transparent;padding-left:8px;"><span><b>{{substr($obez['bez'],0,10)}}</b></span></div></th>
            @endforeach
        </tr>
        <tr class="table-row-header">
            <!-- Spalte 10 -->
            <td class="table-cell-header-rotate cpcStickycol" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;background-color:transparent;height:41px;padding:4px;border:1px solid darkgray;border-top:1px solid #003D7C;">IAN</div></td>
            <!-- Spalte 1 -->
            <td class="table-cell-header-rotate bold" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Phase / Ausmust.</div></td>
             <!-- Spalte 6 -->
             <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Artikel</div></td>
            <!-- Spalte 2 -->
            <td class="table-cell-header-rotate bold" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Interner Status<br>Lidl-Status</div></td>
            @if($board == 10)
            <!-- Spalte 3 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Thema</div></td>
            @endif
            <!-- Spalte 4 -->
            <!-- td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Projekt</div></td -->
            <!-- Spalte 5 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">PP-Status<br>I-Datum<br>L-Datum</div></td>
            @if($board == 6)
            <!-- Spalte 7 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Zert.</div></td>
            @endif
            @if($board < 1000)
            <!-- Spalte 8 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Herkunft</div></td>
            @endif
            <!-- Spalte 8 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">CRD<br>DDP</div></td>
            @if(Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <!-- Spalte 11 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Übergabe {{Auth::User()->PPMitarbeiter_Taetigkeit}}</div></td>
            @endif
            <!-- Spalte 12 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Mitarbeiter</div></td>
            @if($board == 6)
            <!-- Spalte 12 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Gesamtmenge<br>Mengensplit</div></td>
            <!-- Spalte 13 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">EK</div></td>
            <!-- Spalte 14 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">VK</div></td>
            <!-- Spalte 15 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">HQ</div></td>
            <!-- Spalte 16 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">40'</div></td>
            <!-- Spalte 17 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">20'</div></td>
            <!-- Spalte 18 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Status PO</div></td>
            <!-- Spalte 19 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;text-align:center;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Status LC</div></td>
            @endif
            <?php $i              = 0; ?>
            @foreach ($headers as $header)
            <?php $i++; ?>
            <td class="table-cell-header-rotate" style="padding:0px;background-clip: padding-box;" ><div class="termin_cell" style="height:150px; overflow: hidden;width:30px;" title="{{ $header->PPBoardSpalte_Bezeichnung }}"><div>{{$header->PPBoardSpalteData_Kind}}</div><div class="rotate" style="overflow: hidden;width: 110px; @if($header->PPBoardSpalte_IsUSA) font-weight:bold; @endif">{{substr($header->PPBoardSpalte_Bezeichnung,0,20)}}</div></div></td>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <?php $poscount = 0; ?>
        @foreach ($values as $value)
            <?php $poscount++; ?>
        <tr class="table-row">
            <?php
            $first          = true;
            $j              = 0;
            ?>
            @foreach ($headers as $header)
            <?php $j++; ?>
            @if ($first)
            <?php
            $first          = false;
            $po['ltw']      = '';
            $po['ltj']      = '';
            $po['supplier'] = '';
            $po['ek']       = 0;
            $po['status']   = 'N.N.';
            $po['w2fob']    = "";
            $po['bsci']     = "";
            $lccol          = "";
            $lcdate         = "";
            if (!is_null($value['PO'])) {
                $po['ltw'] = $value['PO']->PPPurchase_FOBWeek;
                $po['ltj'] = $value['PO']->PPPurchase_FOBYear;
                if ($value['PO']->PPPurchase_FOBYear > 2000) {
                    $po['ltj'] = $value['PO']->PPPurchase_FOBYear - 2000;
                }
                $po['supplier'] = $value['PO']->PPPurchase_Supplier;
                if ($value['Lief']) {
                    $po['supplierid'] = $value['Lief']->Id;
                    if (strlen($value['Lief']->PPAdressen_ZertBSCIValid) >= 10) {
                        $po['bsci'] = date('d.m.Y', strtotime($value['Lief']->PPAdressen_ZertBSCIValid));
                    }
                }
                $po['ek']     = $value['PO']->PPPurchase_EK != 0
                            ? $value['PO']->PPPurchase_EK
                            : $value['PO']->PPPurchase_FOBQm;
                $po['ekwsym'] = $value['PO']->PPPurchase_Currency;
                $po['status'] = $value['POStatus'];
                $po['w2fob']  = $value['W2FOB'];
                try {
                    $lccol = " background-color:rgb(255,255,255); ";
                    if (isset($value['LC']) and!is_null($value['LC'])) {
                        if (strlen($value['LC']->PPLC_FinalDate) >= 10) {
                            $lcdate = date('d.m.Y', strtotime($value['LC']->PPLC_FinalDate));
                            $lcdt   = new DateTime($value['LC']->PPLC_FinalDate);
                            if (strlen($value['PO']->PPPurchase_OrderDate) >= 10) {
                                $od   = new DateTime($value['PO']->PPPurchase_OrderDate);
                                $diff = date_diff($od, $lcdt);
                                $x    = intval($diff->format('%r%a'));
                                if ($x >= 0) {
                                    $lccol = " background-color:rgb(0,255,0); ";
                                }
                                else {
                                    $lccol = " background-color:rgb(255,0,0); ";
                                }
                            }
                        }
                    }
                }
                catch (Exception $ex) {
                    $lcdate = "Error";
                }
                try {
                    $orderdate = "";
                    if (strlen($value['PO']->PPPurchase_OrderDate) >= 10) {
                        $od        = new DateTime($value['PO']->PPPurchase_OrderDate);
                        $orderdate = date_format($od, "d.m.y");
                    }
                    $di   = new DateTime($value['PP']->PPProduktpass_RevisionDatum);
                    $diff = date_diff($od, $di);
                    $x    = intval($diff->format('%r%a'));
                    if ($x <= 0) {
                        $orderFormatColor = "color:green;";
                    }
                    else {
                        $orderFormatColor = "color:red;";
                        if ($value['PO']->PPPurchase_ManCheckOK == 1) {
                            $orderFormatColor = "color:green;";
                        }
                    }
                }
                catch (Exception $ex) {
                    $orderFormatColor = "color:pink;";
                    $orderdate        = 'N.N.';
                }
                $po['date'] = $orderdate;
            }
            $ab['vk']          = 0;
            $ab['chq']         = 0;
            $ab['c40']         = 0;
            $ab['c20']         = 0;
            $ab['mengensplit'] = '-/-';
            if (!is_null($value['AB'])) {
                $ab['vk']          = $value['AB']->PPAB_VKEUR > 0
                            ? $value['AB']->PPAB_VKEUR
                            : $value['AB']->PPAB_VKQMEUR;
                /*  $ab['chq'] = $value['AB']->PPAB_CD11 + $value['AB']->PPAB_CD12 + $value['AB']->PPAB_CD13;
                    $ab['c40'] = $value['AB']->PPAB_CD21 + $value['AB']->PPAB_CD22 + $value['AB']->PPAB_CD23;
                    $ab['c20'] = $value['AB']->PPAB_CD31 + $value['AB']->PPAB_CD32 + $value['AB']->PPAB_CD33; */
                $ab['chq']         = $value['AB']->PPAB_CD11 + $value['AB']->PPAB_CD21 + $value['AB']->PPAB_CD31 + $value['AB']->PPAB_CD41;
                $ab['c40']         = $value['AB']->PPAB_CD12 + $value['AB']->PPAB_CD22 + $value['AB']->PPAB_CD32 + $value['AB']->PPAB_CD42;
                $ab['c20']         = $value['AB']->PPAB_CD13 + $value['AB']->PPAB_CD23 + $value['AB']->PPAB_CD33 + $value['AB']->PPAB_CD43;
                $ab['mengensplit'] = $value['MengenSplit'];
            } 
            $pp['id']          = $value['PP']->PPProduktpass_Id;
            $pp['ian']         = $value['PP']->PPProduktpass_IAN;
            $pp['projekt']     = $value['PP']->PPProduktpass_PPProjekte_Projekt;
            $pp['artikel']     = $value['PP']->PPProduktpass_Artikelbezeichnung;
            $pp['ddpltw']         = $value['PP']->PPProduktpass_Liefertermin;
            $pp['ddplty']         = $value['PP']->PPProduktpass_LieferterminJahr - 2000;
            $pp['ltw']         = $value['PP']->PPProduktpass_Liefertermin;
            $pp['lty']         = $value['PP']->PPProduktpass_LieferterminJahr - 2000;
            $pp['crdltw']         = $value['PP']->PPProduktpass_CRDWoche;
            $pp['crdlty']         = $value['PP']->PPProduktpass_CRDJahr - 2000;
            $pp['PPstatus']    = $value['PP']->PPProduktpass_Status;
            $pp['Gesamtmenge'] = $value['PP']->PPProduktpass_Gesamtmenge;
            $pp['ParentChild'] = '';
            $pc_color = 'white';
            if ($value['PP']->PPProduktpass_IsParent){
                $pp['ParentChild'] = 'Parent';
                $pc_color = 'dodgerblue';
            }
            if ($value['PP']->PPProduktpass_IsChild){
                $pp['ParentChild'] = 'Child';
                $pc_color = '#FFC133';
            }
            if ($value['PP']->PPProduktpass_IsKaufland){
                $pp['ParentChild'] = 'Nachbestellung';
                $pc_color = '#F0FF33';
            }
            $pp['category'] = $value['PP']->category;
            $pp['statusDoc'] = $value['PP']->statusDoc;
            $pp['InternerStatus'] = $value['PP']->InternerStatus;
            $pp['color_isRFQ'] = (strpos($value['PP']->category,'RFQ')!==false)?'black':'black';
            $pp['IsValid_OldIAN'] =  $value['IsValid_OldIAN'];
            $pp['Mitarbeiter']    = $value['Mitarbeiter'];
            $pp['LidlUpdateDate'] = 'N.N.';
            //$pp['LidlUpdateDate'] = $value['PP']->updatedOn;
            if ((strlen($value['PP']->updatedOn) >= 10) and (strpos($value['PP']->updatedOn,'0000')  === false) ){
                $pp['LidlUpdateDate'] = date_format(date_create($value['PP']->updatedOn), "d.m.y");
            }
            $pp['ZertStep'] = 'Nein';
            if ($value['PP']->PPProduktpass_StepNeeded) {
                $pp['ZertStep'] = 'Ja';
            }
            $pp['ZertBSCI'] = 'Nein';
            if ($value['PP']->PPProduktpass_BSCINeeded) {
                $pp['ZertBSCI'] = 'Ja';
            }
            $pp['DatumImport'] = "Error";
            if (strlen($value['PP']->PPProduktpass_RevisionDatum) >= 10) {
                $pp['DatumImport'] = date_format(date_create($value['PP']->PPProduktpass_RevisionDatum), "d.m.y");
            }
            $pp['artikel'] = substr($value['PP']->PPProduktpass_Artikelbezeichnung, 0, 80);
            if (strlen($value['PP']->PPProduktpass_Artikelbezeichnung) > 80) {
                $pp['artikel'] .= "+";
            }
            $pp['artikelVoll'] = $value['PP']->PPProduktpass_Artikelbezeichnung;
            $pp['8WMuster']    = "";
            if (isset($value['8WMuster'])) {
                $pp['8WMuster'] = $value['8WMuster'];
            }
            $pp['Musterung'] = substr($value['PP']->PPProduktpass_Ausmusterungnummer, 0, 4);
            $pp['AltIAN']    = $value['PP']->PPProduktpass_AltIAN;
            $pp['ThemaLang'] = $value['PP']->PPProduktpass_Thema;
            $pp['Thema']     = substr($value['PP']->PPProduktpass_Thema, 0, 80);
            if (strlen($value['PP']->PPProduktpass_Thema) > 80) { 
                $pp['Thema'] .= "+";
            }
            $pp['WGRP'] = $value['PP']->PPProduktpass_Warengruppe;
            $pp['PMler'] = '';
            if (!is_null($value['PP']->PPProduktpass_PMAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PMAdmin]) ){
                $pp['PMler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PMAdmin];
            }
            $pp['TCler'] = '';
            if (!is_null($value['PP']->PPProduktpass_TCAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_TCAdmin]) ){
                $pp['TCler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_TCAdmin];
            }
            $pp['PMlerVTR'] ='';
            if (!is_null($value['PP']->PPProduktpass_PMAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PMAdminVTR]) ){
                $pp['PMlerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PMAdminVTR];
            }
            $pp['TClerVTR'] ='';
            if (!is_null($value['PP']->PPProduktpass_TCAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_TCAdminVTR]) ){
                $pp['TClerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_TCAdminVTR];
            }
            $dto         = new DateTime();
            $pp['lt']    = $dto->setISODate($pp['lty']+2000, $pp['ltw'])->format("d.m.Y");
            $W10 = new DateInterval('P10W');
            $now = new DateTime();
            $crd = new DateTime();
            $crdw = $value['PP']->PPProduktpass_CRDWoche;
            $crdy = $value['PP']->PPProduktpass_CRDJahr;
            if ($value['PP']->PPProduktpass_CRDJahr == 0){
                $crdw = $value['PP']->PPProduktpass_Liefertermin;
                $crdy = $value['PP']->PPProduktpass_LieferterminJahr;
            }
            $crd->setISODate($crdy, $crdw,5);
            if ($value['PP']->PPProduktpass_CRDJahr == 0){
                $crd->sub($W10);
            }
            $inw2ddp = $now->diff($crd);
            $week_total = $inw2ddp->format('%R%a')/7;
            $pp['w2crd']    = floor($week_total) + 1;
            $isProject = false;
            $pbgcolor[0] = "white";
            $pbgcolor[1] = "lightgray";    
            if (strlen($value['PP']->PPProduktpass_PPProjekte_Projekt) > 6){
                //$pbgcolor[0] = "#f9faac";
                //$pbgcolor[1] = "#fad4ac";                      
            } 
            if ($lproject != $value['PP']->PPProduktpass_PPProjekte_Projekt or $lproject == "") {
                $lcolor++;
                $lcolor   = $lcolor % 2;
                $lproject = $value['PP']->PPProduktpass_PPProjekte_Projekt;
            }
            $bgProject      = $pbgcolor[$lcolor];
            ?>
            <!-- Spalte 10 -->
            <td class="table-cell cpcStickycol" style="background-color: {{$bgProject}};width:80px;padding:0px;">
                <div style="border:1px solid darkgray;border-radius:0px;height:56px;padding:8px; background-color:transparent;">
                    <a href="/show/{{$pp['id']}}" target="_blank" style="text-decoration: none;color:#000;">
                    <div style="border:none;    background-color: transparent;    border-radius: 0px;    width: 88px;    padding: 4px;    margin: -9px;">
                    @if (strlen($pp['ian'])>10)
                        {{substr($pp['ian'],0,10)}}X
                    @else
                        <span style="font-size:12px; color:{{ $pp['color_isRFQ'] }}"><b>{{$pp['ian']}}</b></span>
                    @endif
                    </div>
                    </a>
                    <br>
                    {{$pp['ParentChild']}}
                    <br>    
                    <div style="padding-top:0px; background-color: transparent; border-radius: 0px;">
                        @if ($pp['IsValid_OldIAN'])
                            <a href="/show/{{$pp['AltIAN']}}" target="_blank" style="text-decoration: none;color:#003D7C;"><b>{{$pp['AltIAN']}}</b></a>
                        @else 
                            <b>{{$pp['AltIAN']}}</b>
                        @endif
                    </div>
                </div>
            </td>
            <!-- Spalte 1 -->
                    <td class="table-cell" style="background-color: {{$bgProject}};word-wrap: break-word;">{{$pp['Musterung']}}</span></td>
            <!-- Spalte 6 -->
            <td class="table-cell" style="background-color: {{$bgProject}};" title="{{$pp['artikelVoll']}}">{{$pp['artikel']}}</td>
            <!-- Spalte 2 -->
            <td class="table-cell" style="background-color: {{$bgProject}};word-wrap: break-word;">
                 @if (Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                 <div style="border-radius:0px; background-color:transparent;padding:0px;">
                    <select id="setzeStatus_{{$pp['id']}}" style="font-size:0.7rem;width:70px;box-sizing: content-box; padding:5px;width:80px;">
                        <option @if($pp['InternerStatus']=='MUSTERUNG') selected @endif>MUSTERUNG</option>
                        <option @if($pp['InternerStatus']=='PLAN') selected @endif>PLAN</option>
                        <option @if($pp['InternerStatus']=='FIX') selected @endif>FIX</option>
                        <option @if($pp['InternerStatus']=='GELIEFERT') selected @endif>GELIEFERT</option>
                        <option @if($pp['InternerStatus']=='ABSAGE') selected @endif>ABSAGE</option>
                    </select>
                    <button style="width:92px;" type="button" onclick="setzeStatus({{$pp['id']}});">setzen</button>
                </div>
                @else 
                        <div style="border-radius:0px; background-color:transparent;padding:0px;padding-left: 4px;">{{$pp['InternerStatus']}}</div>
                @endif    
                <div style="border-radius:0px; background-color:transparent;padding:0px;padding-left: 4px;">{{$pp['statusDoc']}}</div>
            </td>
            @if($board == 10)
            <!-- Spalte 3 -->
            <td class="table-cell" style="background-color: {{$bgProject}};word-wrap: break-word;" title="{{$pp['ThemaLang']}}">{{$pp['Thema']}}</td>
            @endif
            <!-- Spalte 4 -->
            <!-- td class="table-cell" style="background-color: {{$bgProject}};word-wrap: break-word;">{{$pp['projekt']}}</td -->
            <!-- Spalte 5 -->
            <td class="table-cell" style="background-color: {{$bgProject}};"><b>{{$pp['PPstatus']}}</b><br>{{$pp['DatumImport']}}<br>{{$pp['LidlUpdateDate']}}</td>
            @if($board == 6)
            <!-- Spalte 7 -->
            <td class="table-cell" style="background-color: {{$bgProject}};"><table><tr><td>STeP:</td><td>{{$pp['ZertStep']}}</td></tr><tr><td>BSCI:</td><td>{{$pp['ZertBSCI']}}</td></tr></table></td>
            @endif
            @if($board < 1000)
            <!-- Spalte 8 -->
            <td class="table-cell" style="background-color: {{$bgProject}};">{{$po['supplier']}}</td>
            @endif
            <!-- Spalte 9 -->
                    <td class="table-cell" style="background-color: {{$bgProject}};">
                        <table style="margin-left:0px;font-size:10px;">
                    <tr>
                        <td><b>CRD:</b> </td>
                        <td><b>{{$crd->format('W/y')}}</b><br></td>
                    </tr>
                    <tr >
                        <td @if($pp['ddpltw'] > 54) style="color:red;"" @endif>DDP: </td>
                        <td>{{$pp['ddpltw']}}/{{$pp['ddplty']}}</td>
                    </tr>
                    <tr>
                        <td><span style="font-size:8px;">W2CRD:</span> </td>
                        <td><b>{{$pp['w2crd']}}</b></td>
                    </tr>
                </table>
            </td>
            @if(Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <!-- Spalte 11 -->
            <td class="table-cell" style="background-color: {{$bgProject}};">
                @if (Auth::User()->PPMitarbeiter_Taetigkeit == 'TC' and Auth::User()->isMaster)
                    <select id="uebergabe_{{$pp['id']}}" style="font-size:0.7rem;padding:5px;width:70px;">
                        @foreach ($TCs as $id => $mx5)
                        <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{$id}}">{{ $mx5 }}</option>
                        @endforeach
                    </select>
                    <button type="button" style="width:90px;margin-top:8px;" onclick="uebergabe({{$pp['id']}},'TC');">übergeben</button>
                @endif    
                @if (Auth::User()->PPMitarbeiter_Taetigkeit == 'PM'  and Auth::User()->isMaster)
                    <select id="uebergabe_{{$pp['id']}}" style="font-size:0.7rem;padding:5px;">
                        @foreach ($PMs as $id => $mx5)
                        <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{$id}}">{{ $mx5 }}</option>
                        @endforeach
                    </select>
                    <button type="button" style="width:90px;margin-top:8px;" onclick="uebergabe({{$pp['id']}},'PM');">übergeben</button>
                @endif    
            </td>
            @endif
             <!-- Spalte 12 -->
            <td class="table-cell"  style="text-align:center; background-color: {{$bgProject}};">
                <table>
                <tr>
                        <td onclick="VertretungShow('PM', {{$pp['id']}});"><b>PM</b></td>
                        <td>{{$pp['PMler']}}
                        <td><span id="VTRDISPM{{$pp['id']}}">@if($pp['PMlerVTR'] != '')<b style="color:orangered;">VTR: </b> {{$pp['PMlerVTR']}} @endif</span></td>
                    </tr>
                    <tr>
                        <td  onclick="VertretungShow('TC', {{$pp['id']}});"><b>TC</b></td>
                        <td>{{$pp['TCler']}}
                        <td><span id="VTRDISTC{{$pp['id']}}">@if($pp['TClerVTR'] != '')<b  style="color:orangered;">VTR: </b> {{$pp['TClerVTR']}} @endif</span></td>
                    </tr>
                </table>
                <div id="VTRINPPM{{$pp['id']}}"  style="display:none;background-color:transparent;border: none; height:30px; border-radius: 0px;">   
                    <select id="vertretungPM{{$pp['id']}}" style="font-size:0.7rem;padding:5px;" onchange="VTRADD('PM', {{$pp['id']}});">
                        @foreach ($PMs as $vid => $vtr)
                        <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}' @if($pp['PMlerVTR'] == $vid) selected @endif  value="{{$vid}}">{{ $vtr }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="VTRINPTC{{$pp['id']}}"  style="display:none;background-color:transparent;border: none; height:30px; border-radius: 0px;">   
                    <select id="vertretungTC{{$pp['id']}}" style="font-size:0.7rem;padding:5px;" onchange="VTRADD('TC',{{$pp['id']}});">
                        @foreach ($TCs as $vid => $vtr)
                        <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{$vid}}">{{ $vtr }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            @if($board == 6)
            <!-- Spalte 12 -->
            <td class="table-cell" style="text-align:center;">Total: {{number_format($pp['Gesamtmenge'],0,',','.')}}<br>{{$ab['mengensplit']}}</td>
            <!-- Spalte 13 -->
            <td class="table-cell" style="text-align:right;padding-right:4px;">{{number_format($po['ek'],2)." ".$po['ekwsym']}}</td>
            <!-- Spalte 14 -->
            <td class="table-cell" style="text-align:right;padding-right:4px;">{{number_format($ab['vk'],2)}}</td>
            <!-- Spalte 15 -->
            <td class="table-cell" style="text-align:center;padding-right:4px;">{{$ab['chq']}}</td>
            <!-- Spalte 16 -->
            <td class="table-cell" style="text-align:center;padding-right:4px;">{{$ab['c40']}}</td>
            <!-- Spalte 17 -->
            <td class="table-cell" style="text-align:center;padding-right:4px;">{{$ab['c20']}}</td>
            <!-- Spalte 18 -->
            <td class="table-cell" style="text-align:center;">{{$po['status']}}<br><span style="{{$orderFormatColor}}">{{$orderdate}}</span></td>
            <!-- Spalte 19 -->
            <td class="table-cell" style="text-align:center;">{{$lcdate}}</td>
            @endif
            @endif
            <?php
            $EndeW2LT = $po['w2fob'];
            $dto = new DateTime();
            $dto->setISODate($pp['lty'], $pp['ltw'],5);
            $t['id']        = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Id;
            $t['bgcolor']   = $value['Termin'][$header->PPBoardSpalte_Id]->PPStati_Background;
            $t['bemerkung'] = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Bemerkungen;
            $t['terminart'] = $header->PPBoardSpalte_Bezeichnung;
            $t['status']    = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Status;
            $t['ma']        = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_MAZustaendigkeit;
            $t['history']   = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_History;
            $t['log']       = $value['Log'][$header->PPBoardSpalte_Id];
            if ($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate == '0000-00-00 00:00:00') {
                $t['rot']       = $header->PPBoardSpalte_Rot;
                $t['orange']    = $header->PPBoardSpalte_Orange;
                $t['IsMileStone']  = $value['Termin'][$header->PPBoardSpalte_Id]->PPBoardSpalte_IsMilestone;
            } else {
                $thisFriday = new DateTime();
                $thisFriday->setIsoDate($thisFriday->format('Y'), $thisFriday->format('W'),5);
                $manSollDate = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate);
                $diffManSoll =  $thisFriday->diff($manSollDate, true);
                $w2ManSoll = floor($diffManSoll->format('%R%a')/7); 
                $t['rot']       = -1 * $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSoll -10;
                $t['orange']    = $t['rot'] + 2;
                $t['IsMileStone']  = true;
            }
            $t['start']     = '0000-00-00';
            $t['ende']      = '0000-00-00';
            $t['IsUSA']  = $value['Termin'][$header->PPBoardSpalte_Id]->PPBoardSpalte_IsUSA;
            $t['Mitarbeiter']  = $value['Termin'][$header->PPBoardSpalte_Id]->PPMitarbeiter_Kuerzel;
            $t['bg']        =  $value['BG'][$header->PPBoardSpalte_Id];
            $w2start_undef = -100000;
            $w2start =  $w2start_undef;
                    /*********************NEU **********************/
                    $datenow = new DateTime();
                    $weekNow = $datenow->format("W");
                    $w2startNeu = $w2start_undef;
                    //$startDateNeu = new DateTime();
                    $startDateNeu = date("Y-m-d", strtotime('friday this week'));
                    $bgNeu ="240,240,240";
                    $startKWNeu =  0;
                    $pre = 'XXX';
                    $startdate = null;
                    $diff = null;
                    $diffTage = 0;
                    $msg = "";
                    try{
                        $crd = new DateTime();
                        $crdw = $value['PP']->PPProduktpass_CRDWoche;
                        $crdy = $value['PP']->PPProduktpass_CRDJahr;
                        if ($value['PP']->PPProduktpass_CRDJahr ==0){
                            $crdw = $value['PP']->PPProduktpass_Liefertermin;
                            $crdy = $value['PP']->PPProduktpass_LieferterminJahr;
                        }
                        $crd->setISODate($crdy, $crdw, 5);
                        if ($value['PP']->PPProduktpass_CRDJahr == 0){
                            $interval = new DateInterval('P10W');
                            $crd->sub($interval);
                        }
                        //$interval = new DateInterval('P4D');
                        //$crd->sub($interval);
                        $stdPeriode = ($t['rot'] +10 );
                        if ($stdPeriode < 0 ){
                            $stdPeriode *= -1 ;
                        }
                        $stdPeriodeInterval = new DateInterval('P'.$stdPeriode.'W'); 
                        $startDateNeu = clone $crd;
                        if ($t['rot'] +10  < 0 ){
                            $startDateNeu->sub($stdPeriodeInterval);
                        } else {
                            $startDateNeu->add($stdPeriodeInterval); 
                        }
                        $dayOfWeek = $startDateNeu->format('w');
                        $d2friday = 5- $dayOfWeek;
                        $d2FridayInterval = new DateInterval('P'.$d2friday.'D'); 
                        $startDateNeu = $startDateNeu->add($d2FridayInterval);
                        $rwi = $datenow->diff($startDateNeu);
                        $rw = $rwi->format("%a")/7;
                        if ($datenow > $startDateNeu){
                            $rw *= -1;
                        }
                        $w2startNeu = round( $rw,0); 
                        $pre="STD";
                        if ($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSoll != 0){
                            $per1 = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSoll;
                            $perI = new DateInterval("P".$per1."W");
                            $startDateNeu = clone $crd;
                            $startDateNeu->sub($perI);
                            $rwi = $datenow->diff($startDateNeu);
                            $rw = $rwi->format("%R%a")/7;
                            $w2startNeu = round( $rw,0); 
                            $pre="MAN";
                        }
                        if (substr($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 10) != "0000-00-00") {
                            $startDateNeu = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumStart);
                            $_dn = date('Y-m-d');
                            $_dn = $_dn .'00:00:00';
                            $diff = new DateTime($_dn);
                            $diffI = $diff->diff($startDateNeu);
                            $diffTage = $diffI->format("%a");
                            if ($startDateNeu < $datenow ){
                                $pre="I1"; $w2startNeu = -1 * floor($diffTage/7);
                            } else {
                                $pre="I2";$w2startNeu = ceil($diffTage/7);
                            }
                            //$w2startNeu = $startKWNeu - $weekNow;
                        }
                        if ($w2startNeu == -0){
                            $w2startNeu = 0;
                        }
                        if ($w2startNeu > 2){
                            //grau
                            $bgNeu ="240,240,240";
                        }
                        if ($w2startNeu <= 2 and $w2startNeu >= 0 ){
                            // gelb
                            $bgNeu ="255,255,153";
                        }
                        if ($w2startNeu < 0  ){
                            // Rosa 
                            $bgNeu ="255, 199, 206";
                        }
                          //$w2startNeu = $pre.$w2startNeu;
                    }
                    catch (Exception $ex) {
                        $t['start'] = '0000-00-00';
                       $msg = $ex->getMessage();
                    }
                /*********************ENDE NEU *********************/
            try {
                if (substr($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 10) != "0000-00-00") {
                    $ds         = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumStart);
                    $weekday =  $ds->format("N");
                    $days2add =  5 - $weekday;
                    $day2AddInterval = new DateInterval('P'.$days2add.'D');
                    $t['start'] = $ds->format("d.m.Y");
                    $dateStart = new DateTime($t['start']);
                    $weekStart = $dateStart->format('W');
                    $datenow = new DateTime();
                    $weekNow = $datenow->format("W");
                    $w2start = $weekNow - $weekStart +1; 
                    if ($w2start == -0){
                        $w2start = 0;
                    }
                    if ($w2start > 2){
                        //grau
                        $t['bg'] ="240,240,240";
                    }
                    if ($w2start <= 2 and $w2start >= 0 ){
                        // gelb
                        $t['bg'] ="255,255,153";
                    }
                    if ($w2start < 0  ){
                        // Rosa 
                        $t['bg'] ="255, 199, 206";
                    }
                } else {
                  //  $t['bg'] ="5, 99, 206"; 
                }
            }
            catch (Exception $ex) {
                $t['start'] = '1900-01-11';
            }
            $_weeks = 0;
            if ($w2start == $w2start_undef){
                $_weeks = $po['w2fob'] + $t['rot'];
                if ($_weeks == -0){
                    $_weeks = 0;
                }
                if ($_weeks > 2){
                    //grau
                    $t['bg'] ="240,240,240";
                }
                        if ($_weeks <= 2 and $_weeks > 0 ){
                    // gelb
                    $t['bg'] ="255,255,153";
                }
                        if ($_weeks <= 0  ){
                    // Rosa 
                    $t['bg'] ="255, 199, 206";
                }
            }
            try {
                if (substr($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumEnde, 0, 10) != "0000-00-00") {
                    $de        = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumEnde);
                    $t['ende'] = $de->format("d.m.Y");
                }
            }
                    catch (Exception $ex) {}
            $t['label'] = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Label;
            $t['datafield'] = $value['Datafield'][$header->PPBoardSpalte_Id];
            if ($pp['ltw'] + $t['rot'] <= 0){
                $t['SOLLW'] = $pp['ltw'] + $t['rot'] + 52;
                $t['SOLLY'] = $pp['lty']-1;
            } else{
                $t['SOLLW'] = $pp['ltw'] + $t['rot'];
                $t['SOLLY'] = $pp['lty'];
            }
            $t['WERL']       = '';
            $t['OKSTATUS'] = $value['OKSTATUS'][$header->PPBoardSpalte_Id];
            $t['WERLSET'] = $value['WERLSET'][$header->PPBoardSpalte_Id];
            $t['WERLW'] = $value['WERLW'][$header->PPBoardSpalte_Id];
            $t['WERLY'] = $value['WERLY'][$header->PPBoardSpalte_Id];
            if ( $t['OKSTATUS'] == 'YES'){
                if ($t['WERLSET'] == 'YES'){
                    $t['WERLY'] = $t['WERLY'] -2000;
                    if( $t['SOLLY'] ==  $t['WERLY']){
                        $t['WERL'] = $t['SOLLW'] - $t['WERLW'];
                    } else {
                        $suby = -52;
                        if( $t['SOLLY'] >  $t['WERLY']){
                            $suby = +52;
                        }
                        $t['WERL'] = $t['SOLLW'] + $suby - $t['WERLW'];
                    }
                }
            }
            $as        = explode("x", $header->PPBoardSpalte_Stati);
            $xs        = array();
            $xs["Neu"] = "Neu";
            foreach ($as as $s) {
                if (isset($statiAll[$s])) {
                    $xs[$statiAll[$s]] = $statiAll[$s];
                }
            }
            $t['stati'] = $xs;
            ?>
            <td class="table-cell_value" style="border:1px solid #003D7C; overflow: hidden; padding:0px;vertical-align: top;">
                @if($t['OKSTATUS'] == 'NO') 
                    @if ($t['start'] == '0000-00-00' and $t['IsMileStone'] == 0)
                    <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color:rgb({{$bgNeu}});text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell):  {{ $w2start }}
Deadline (berechnet): keine @else 
Deadline (berechnet): keine @endif">
                        <span  style="font-size:8px;font-weight: bolder;color:darkblue;"  > ? / @if( $w2start != $w2start_undef )  {{ $w2start }}  @else  {{ $pp['w2crd'] + $t['rot'] +10 }}  @endif       </span> 
                    </div>
                    @else 
                        <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color: rgb({{$bgNeu}});text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2startNeu }}W 
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @else
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @endif">
                            <span style="font-size:8px;font-weight: bolder;color:#003D7C;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2startNeu }}W 
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @else
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @endif">{{ $w2startNeu }}</span>
                        </div>
                    @endif
                @else
                    @if ($t['WERL'] < 0 )
                    <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color: rgb(255, 199, 206);text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2startNeu }}W 
Deadline (berechnet): {{ $pp['w2crd'] + $t['rot'] + 10}}W @else 
Deadline (berechnet): {{ $pp['w2crd'] + $t['rot'] + 10}}W @endif">
                        <span  style="font-size:8px;font-weight: bolder;color:darkblue;"  >{{ $t['WERL'] }}</span> 
                    </div>
                    @else 
                    <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color: rgb(25,157,45);text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2start }}W 
Deadline (berechnet): {{  $pp['w2crd'] + $t['rot'] + 10}}W @else
Deadline (berechnet): {{  $pp['w2crd'] + $t['rot'] + 10}}W @endif ">
                        <span  style="font-size:8px;font-weight: bolder;color:white;"  >{{ $t['WERL'] }}</span> 
                    </div>
                    @endif 
                @endif 
                <div title="
{{$msg}}            
{{ $pp['ian'] }} 
{{ $t['terminart'] }}
MA: {{ $t['Mitarbeiter'] }}  Status: {{$t['status']}}  
@if (!is_null($diff)){{$startDateNeu->format('d.m.Y')}}@endif
@if (strlen($t['label']) > 0) Label:{{$t['label']}} @endif" style="position:relative;width:30px;height:60px;background-color:rgb({{isset($t['bgcolor'])?$t['bgcolor']:'255,0,0'}});border-radius:0px;" onclick="ajax_getTermin({{$pp['id']}},{{$t['id']}},{{$board}})">
                    <!--div style="font-size:4px;">{{$t['ende']}}<br>{{$t['rot']}}</div -->
                    @if ($t['status'] == 'nicht benötigt')
                    <span style="font-size: 8px;">nicht benötigt</span>
                    @endif 
                    @if(strlen(trim($t['bemerkung']))>0)
                    <div style='position:absolute; bottom:0px; right:0px; width:100%;height:8px;width:8px;background-color: rgb(119, 119, 119); border:none;border-radius: 0px;margin:0px;' title="   {{ trim($t['bemerkung']) }} ">&nbsp;</div>
                    @endif
                    <span style='font-size: 8px;font-family: Arial, Helvetica, sans-serif;color:rgb(9, 41, 146);'>{{$t['label']}}</span>
                </div>
            </td>
            @endforeach
        </tr>
        @endforeach
</tbody>
    </table>
    <?php $_SESSION['TPT_Message']= " $poscount Datensätze in ".number_format((microtime(true) - $kalender['STARTTIME']),'1', ',','.'). " Sekunden."  ?>
</div>
@else
<div><h1>Keine Daten gefunden!</h1></div>
@endif
<script>
$( document ).ready(function() {
    firstInput = document.getElementById('inpIAN');
    firstInput.focus();
});
    function submitFormX(event){
        if (event.keyCode == 13) {
            frm = document.getElementById('formgetTermine');
            frm.submit();
            return false;
        }
    }
    function uebergabe (ppid, art){
       elem = document.getElementById('uebergabe_' + ppid);
       maid = elem.value;
       if (maid != 0){
           setMA_PM_TC(ppid, art, maid );
       }
   }
   function setzeStatus (ppid){
       elem = document.getElementById('setzeStatus_' + ppid);
       state = elem.value;
       console.log("Status: " + state + " ID: " +ppid);
       if (state != 0){
           updateStatus(ppid, state );
       }
    }
    /* Save Filter Start */
    function saveFilter() {
        const filters = document.querySelectorAll('[name*="sQry"]');
        var qryFilter  = {};
        for (let index = 0; index < filters.length; index++) {
            const elem = filters[index];
            var att = elem.name.replace('sQry[','').replace(']','');
            var val = elem.value;
            qryFilter[att]=  val;//console.log (elem.name);
        }
        var json_qryFilter = JSON.stringify(qryFilter);
        var frmData = new FormData();
        frmData.append('qryFilter', json_qryFilter);
        $.ajax({
        type: "POST",
            url: "/saveFilter",
            data: frmData,
            processData: false,
            contentType: false,
            success: onSuccess_saveFilter,
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_saveFilter(jsonResult) {
        alert( 'Filter gespeichert!' );
    }
    function getFilter() {
        $.ajax({
            type: "POST",
            url: "/getFilter",
            processData: false,
            contentType: false,
            success: onSuccess_getFilter,
            error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
    function onSuccess_getFilter(jsonResult) {
        var qryFilter = JSON.parse(jsonResult);
        const filters = document.querySelectorAll('[name*="sQry"]');
        for (let index = 0; index < filters.length; index++) {
            var elem = filters[index];
            var att = elem.name.replace('sQry[','').replace(']','');
            elem.value = qryFilter[att];
        }
        var frm = document.getElementById('formgetTermine');
        frm.submit();
   }
    /* Save Filter Ende */
   function updateStatus(id, state) {
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('state', state);
        $.ajax({
        type: "POST",
                url: "/updateStatus",
                data: frmData,
                processData: false,
                contentType: false,
                success: onSuccess_updateStatus,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
        }
        function onSuccess_updateStatus(jsonResult) {
            data = JSON.parse(jsonResult).Data;
            alert( 'Status gesetzt!' );
            window.location.reload();
            }
    function setMA_PM_TC(id, art, maid) {
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('art', art);
        frmData.append('maid', maid);
        $.ajax({
        type: "POST",
                url: "/setMA_PM_TC",
                data: frmData,
                processData: false,
                contentType: false,
                success: onSuccess_setMA_PM_TC,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
    }
        function onSuccess_setMA_PM_TC(jsonResult) {
        data = JSON.parse(jsonResult).Data;
        console.log("data2:");
        console.log(data);
        elem = document.getElementById('uebergabe_' + data.id);
        elem.value = '';
        alert( '[' + data.art + '] Mitarbeiter gesetzt!' );
            window.location.reload();
        }
        function rstForm(){
            var elements = document.querySelectorAll('[id^=inpForm]');
            for (var i=0; i<elements.length; i++) {
                if (elements[i].nodeName == 'INPUT'){
                    elements[i].value = "";
                    if (elements[i].id == 'inpFormMusterung' || elements[i].id == 'inpFormIAN' ){
                        elements[i].value = "%";
                    }
                }  else {
                    if (elements[i].nodeName == 'SELECT'){
                        elements[i].selectedIndex = 0;
                    }
                }
            }
            var frm = document.getElementById('formgetTermine');
            frm.submit();
        }
    function ajax_getTermin(ppid, tid, board) {
        window.open("/getTerminFromId/" + ppid + "/" + tid + "/" + board, "Termindetails", "toolbar=no, scrollbars=no, resizable=no, top=10, left=10, width=1910, height=1265");
    }
    function VertretungShow (art, ppid){
        inp = document.getElementById ('VTRINP'+art+ppid);
        if (inp){
            inp.style.display = '';
        }
    }
    function VertretungHide (art, ppid){
        inp = document.getElementById ('VTRINP'+art+ppid);
        if (inp){
            inp.style.display = 'none';
        }
    }
    function VTRADD (art, ppid){
        vtr = document.getElementById ('vertretung'+art+ppid);
        dis = document.getElementById ('VTRDIS'+art+ +ppid);
        if (vtr){
            if (vtr.value == 0){
                dis.innerHTML = '';
            } else {
                dis.innerHTML = '<b style="color:orangered;">VTR</b>  ' + vtr.options[vtr.selectedIndex].text;
            }
            //console.log("id: " + ppid + " art: " + art +"  maid: " + vtr.value);
            setVTR(ppid, art, vtr.value );
        }
        VertretungHide (art, ppid);
    }
    function setVTR(id, art, maid) {
        console.log("id: " + id + " art: " + art +"  maid: " + maid);
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('art', art);
        frmData.append('maid', maid);
        $.ajax({
        type: "POST",
                url: "/setVTR",
                data: frmData,
                processData: false,
                contentType: false,
                success: onSuccess_setVTR,
                error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
    }
    function onSuccess_setVTR(jsonResult) {
        data = JSON.parse(jsonResult).Data;
        //elem = document.getElementById('uebergabe_' + data.id);
        //elem.value = '';
        alert( 'Vetreter [' + data.art + '] gesetzt!' );
        //window.location.reload();
        }
</script>