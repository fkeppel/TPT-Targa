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
    .stValue button {
        border-radius:0px;
        border: 1px solid darkblue;
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
    .PM  {
        border: 0px solid red;
    }
    .PM td {
        width:80px; 
        overflow: hidden;
        border-bottom: 1px solid gray;
        padding-top:5px;
        padding-bottom:5px;
    }
    #submitFormBtn {
       font-size:80%;
    }
    .VTRINPHide {
        position:absolute;
        top:0;
        display:none;
        background-color:transparent;
        height:30px; 
        border-radius: 0px;
    }
    .VTRINPShow {
        position:absolute;
        top:0;
        display:block;
        background-color:orange;
        height:40px; 
        width:60px;
        border-radius: 0px;
    }
    .divSelectTaetHide {
        display: none;
    }   
    .divSelectTaetShow {
        display: block;
        border-radius:0px;
        width:100%;
        height:73px;
        padding:0px;
    }
    .selectUebergabe {
        width:90px;
        height:26px;
        border:1px solid gray;
        font-size:0.7rem;
        padding:1px;
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
    $PJMs      = $kalender['PJMs'];
    $TCs       = $kalender['TCs'];
    $mitarbeiterliste   = $kalender['mitarbeiterliste'];
    $mitarbeiterNamen   = $kalender['mitarbeiterNamen'];
    $lproject  = "";
    $lcolor    = 0;
    $isFKE =  Auth::user()->PPMitarbeiter_Kuerzel === 'FKE';
    $lang = isset($_COOKIE['TPTLanguage'])?$_COOKIE['TPTLanguage']:Auth::user()->PPMitarbeiter_Language;
?>
<div style="text-align: left;border-radius: 0px;margin-top:15px;">VII
    @foreach ($SALs as $sal)
    @if ($board == $sal->PPBoard_Id)
    <div style="position:relative;padding:10px;font-weight: bold;font-size:24px;background-color:#003D7C; color:white;width:98%;vertical-align: middle; border-radius:0px;margin:0px;height:36px;">{{ ServiceProvider::tl($lang, $sal->PPBoard_Bezeichnung) }}<img src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" style="position:absolute;top:8px;right:2px;height:43px;"/></div>
    @endif
    @endforeach
    @if ($board ==  2000)
            <div style="position:relative;padding:10px;font-weight: bold;font-size:24px;background-color:#003D7C; color:white;width:98%;vertical-align: middle; border-radius:0px;margin:0px;">Dashboard {{ ServiceProvider::tl($lang, 'Archiv (GELIEFERT)') }}<img src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" style="position:absolute;top:0px;right:0px;height:52px;"/></div>
    @endif
    @if ($board ==  2002)
            <div style="position:relative;padding:10px;font-weight: bold;font-size:24px;background-color:#003D7C; color:white;width:98%;vertical-align: middle; border-radius:0px;margin:0px;">Dashboard {{ ServiceProvider::tl($lang, ' Archiv (ABSAGE)') }}<img src="/css/images/TARGA_Logo_Basis_weiss_RGB.png" style="position:absolute;top:0px;right:0px;height:52px;"/></div>
    @endif
</div>
<div style="padding:4px; border-radius:0px; border:1px solid darkblue; min-height:100px!important;max-height:115px!important;overflow:hidden;width:calc(100% - 23px)">
    {{ Form::open(array('url' => 'termine','style'=>'color:darkblue;margin:5px;', 'id'=>'formgetTermine','onkeypress' => 'submitFormX(event);')) }}
    <input type="hidden" name="inp_board" value="{{$board}}">
    <div id="cFormHeader" style="border:none;" >
        <div class="searchTab"  style="display:grid;grid-template-columns: repeat(auto-fit, 120px 200px);grid-gap:10px; font-family:tahoma; font-size:14px;border:none;border-radius:0px;overflow:hidden;">
                <div class='stLabel'>IAN</div>
                <div class='stValue'>
                    <input id="inpFormIAN" name="sQry[PPProduktpass_IAN]" placeholder="IAN"  @if (isset($kalender['SP'])) value="{{$kalender['SP']['PPProduktpass_IAN']}}" @endif />
                </div>
                <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Artikel') }}</div>
                <div class='stValue'><input id="inpFormArtikel" name="sQry[PPProduktpass_Artikelbezeichnung]" placeholder="Article" @if (isset($kalender['SP'])) value="{{isset($kalender['SP']['PPProduktpass_Artikelbezeichnung'])?$kalender['SP']['PPProduktpass_Artikelbezeichnung']:''}}" @endif/></div>
                <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Bereich') }}</div>
                <div class='stValue'>
                <select id="inpFormBereich" name="sQry[PPProduktpass_ThemaScope]" titel="Bereich"  >
                        <option></option>
                        @foreach($kalender['scopes'] as $scope)
                            <option @if (isset($kalender['SP']['PPProduktpass_ThemaScope'])) @if ($kalender['SP']['PPProduktpass_ThemaScope'] == $scope) selected @endif @endif  >{{ $scope }}</option>
                        @endforeach
                    </select>            
                </div>
                <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Musterung') }}</div>
                <div class='stValue'><input  id="inpFormMusterung"  name="sQry[PPProduktpass_Ausmusterungnummer]" placeholder="Musterung" @if (isset($kalender['SP'])) value="{{$kalender['SP']['PPProduktpass_Ausmusterungnummer']}}" @endif /></div>
                <div class='stLabel'>PM</div>
                <div class='stValue'>                    
                    <select  id="inpFormPM"  name="sQry[PMler]" >
                        <option></option>
                        @foreach ($PMs as $id => $mx5)
                        <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}'  value="{{ $mx5}}" @if(isset($kalender['SP']['PMler']) && $kalender['SP']['PMler']  == $mx5 ) selected @endif >{{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='stLabel'>TC</div>
                <div class='stValue'>
                    <select  id="inpFormTC" name="sQry[TCler]">
                        <option></option>
                        @foreach ($TCs as $id => $mx5)
                          <option title='{{ isset($mitarbeiterNamen[$id]->PPMitarbeiter_Name)?$mitarbeiterNamen[$id]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$id]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{ $mx5}}" @if(isset($kalender['SP']['TCler']) && $kalender['SP']['TCler']  == $mx5 ) selected @endif >{{ $mx5 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Lidl Status') }}</div>
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
                <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Import') }}</div>
                <div class='stValue'><input  id="inpFormPPProduktpass_RevisionDatum"  name="sQry[PPProduktpass_RevisionDatum]" placeholder="Import: 2024-10-24" @if (isset($kalender['SP'])) value="{{isset($kalender['SP']['PPProduktpass_RevisionDatum'])?$kalender['SP']['PPProduktpass_RevisionDatum']:''}}" @endif/></div>
                    <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Seite') }}</div>
                    <div class='stValue' style='padding-left:38px;padding-top:5px;'>
                        <div style="width:156px;">
                            <button type='button' style='float:left;' onclick="prevPage();">-</button>
                            <input style='width:35px;float:left;text-align:right;border:none;' id="page"  name="page" placeholder="1" value="{{$kalender['page']}}" />
                            <input type='hidden' id="pages" value="{{ceil($kalender['totalRows']/$kalender['rows'])}}" />
                            <div style='display:inline;float:left;width:60px;border:none;font-size:0.8em;color:black;padding-top:5px;'>von {{ceil($kalender['totalRows']/$kalender['rows'])}}</div>
                            <button type='button'   onclick="nextPage();">+</button>
                        </div>
                    </div>
                <div class='stLabel'>{{ ServiceProvider::tl($lang, 'Nur kritische') }}</div>
                <div class='stValue' style='border:none;padding:0px;'><input type='hidden' id="inpPPProduktpass_IsCriticalProject"  name="sQry[PPProduktpass_IsCriticalProject]"  value="0"/>
                <input type='checkbox' style="width:30px;margin:0px;" id="inpPPProduktpass_IsCriticalProject"  name="sQry[PPProduktpass_IsCriticalProject]"  @if(@isset($kalender['SP']['PPProduktpass_IsCriticalProject']) and $kalender['SP']['PPProduktpass_IsCriticalProject'] == 1 ) checked=checked @endif value='1'/></div>
                    <div class='stLabel'>{{ ServiceProvider::tl($lang, '#Zeilen') }}</div>
                    <div class='stValue'><input  style="width:100px;" id="rows"  name="rows"  value="{{$kalender['rows']}}"/> <span style="display:inline;">{{ ServiceProvider::tl($lang, 'Gesamt')}}: {{$kalender['totalRows']}}</span></div>
                <div class='stValue'><button id="submitFormBtn" type="submit" name='action' value="anzeigen" style="width:100%;height:30px;"><b>{{ ServiceProvider::tl($lang, 'Anzeigen') }}</b></button></div>
                <div class='stValue'><button id="submitFormBtn" type="button" style="width:100%;height:30px;" onclick="rstForm();"><b>{{ ServiceProvider::tl($lang, 'Zurücksetzen')}}</b></button></div>
                <div class='stValue'><button id="submitFormBtn" type="button" style="width:100%;height:30px;" onclick="saveFilter({{$board}});"  title="Filter für das {{$sal->PPBoard_Bezeichnung}} speichern."><b>{{ ServiceProvider::tl($lang, 'Filter speichern *')}}</b></button></div>
                <div class='stValue'><button id="submitFormBtn" type="button" style="width:100%;height:30px;" onclick="getFilter({{$board}});" title="Gespeicherten Filter für das {{$sal->PPBoard_Bezeichnung}} laden." ><b>{{ ServiceProvider::tl($lang,'Filter laden *')}}</b></button></div>
                <div class='stValue'><button id="submitFormBtn" type="submit" name='action' value="anzeigen+" style="width:100%;height:30px;" title="Projekte der ausgewählten Person ohne Vertretungsprojekte" ><b>{{ ServiceProvider::tl($lang,'ohne Vertretung')}}</b></button></div>
        </div>
    </div>
    <div style="text-align:left;font-size:0.7em;padding-top:8px;color:#E74C3C;">{{ ServiceProvider::tl($lang,'*) Beim ersten Aufruf wird jetzt der Filter auf die eigenen Projekte gesetzt (PM = [USER] oder TC = [USER]) Mit dem Buttons [Zurücksetzen] + [Anzeigen] erhält man wieder die gesamte Liste')}}</div>
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
            <th class="table-cell-header-rotate cpcStickycol" style="background-clip: padding-box;border-bottom:none;">X</th>
            <!-- Spalte 1-->
            <th class="table-cell-header-rotate cpccol2" style="background-clip: padding-box;border-bottom:none; width:50px;">YX</th>
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
            <th class="table-cell-header-rotate cpccol7" style="background-clip: padding-box;border-bottom:none; width:70px;">Y</th>
            @if(Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <!-- Spalte 11-->
            <th class="table-cell-header-rotate cpccol8" style="background-clip: padding-box;border-bottom:none; width:100px;"></th>
            @endif
            <!-- Spalte 12-->
            <th class="table-cell-header-rotate cpccol9" style="background-clip: padding-box;border-bottom:none;width:110px;">YS</th>
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
                $colors = array("white", "lightgray", "white",
                    "lightgray", "white",
                    "lightgray", "white", "lightgray", "white",
                    "lightgray", "white", "lightgray",
                    "white", "lightgray", "white", "lightgray",
                    "white", "lightgray", "white",
                    "lightgray", "white", "lightgray", "white",
                    "lightgray", "white", "lightgray",
                    "white", "lightgray");
                foreach ($headers as $header) {
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
            <th class="table-cell-header-rotate cpccolAll" style="background-clip: padding-box; font-size:10px;padding:0px;background-color:<?php $obez['bg'] ?>;" colspan="{{$obez['colspan']}}"><div style="@if($obez['colspan'] == 1)width:22px;@else width:auto; @endif overflow:hidden;border-radius: 0px;border:none;background-color: transparent;padding-left:8px;"><span><b>{{substr(ServiceProvider::tl($lang,$obez['bez']),0,10)}}</b></span></div></th>
            @endforeach
        </tr>
        <tr class="table-row-header">
            <!-- Spalte 10 -->
            <td class="table-cell-header-rotate cpcStickycol" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;background-color:transparent;height:41px;padding:4px;border:1px solid darkgray;border-top:1px solid #003D7C;">{{ServiceProvider::tl($lang,'IAN')}}</div></td>
            <!-- Spalte 1 -->
            <td class="table-cell-header-rotate bold" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Phase')}} / {{ServiceProvider::tl($lang,'Ausmust.')}}</div></td>
             <!-- Spalte 6 -->
             <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Artikel')}}</div></td>
            <!-- Spalte 2 -->
            <td class="table-cell-header-rotate bold" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Interner Status')}}<br>{{ServiceProvider::tl($lang,'Lidl Status')}}</div></td>
            @if($board == 10)
            <!-- Spalte 3 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Thema')}}</div></td>
            @endif
            <!-- Spalte 4 -->
            <!-- td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Projekt</div></td -->
            <!-- Spalte 5 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'PP Status')}}<br>I-{{ServiceProvider::tl($lang,'Datum')}}<br>L-{{ServiceProvider::tl($lang,'Datum')}}</div></td>
            @if($board == 6)
            <!-- Spalte 7 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Zert.')}}</div></td>
            @endif
            @if($board < 1000)
            <!-- Spalte 8 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">Herkunft</div></td>
            @endif
            <!-- Spalte 8 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">CRD<br>DDP</div></td>
            @if(Auth::User()->PPMitarbeiter_Gruppe == 'admin')
            <!-- Spalte 11 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Übergabe an')}}<br><select style='margin-top:5px;width:90px;padding:3px;border-radius:0px;font-size:1em;' id='selectTaetigkeit' onchange="fillSelect(this);"><option value=''></option><option value='PM'>PM</option><option value='PJM'>PJM</option><option  value='TC'>TC</option></select></div></td>
            @endif
            <!-- Spalte 12 -->
            <td class="table-cell-header-rotate" style="background-clip: padding-box;padding:0px;border-top:none;vertical-align: bottom;"><div style="border-radius:0px;border-top:1px solid #003D7C;background-color:transparent;height:45px;padding:2px;">{{ServiceProvider::tl($lang,'Mitarbeiter')}}</div></td>
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
            <td class="table-cell-header-rotate" style="padding:0px;background-clip: padding-box;" ><div class="termin_cell" style="height:150px; overflow: hidden;width:30px;" title="{{  ServiceProvider::tl($lang,$header->PPBoardSpalte_Bezeichnung) }}"><div>{{ $header->PPBoardSpalteData_Kind }}</div><div class="rotate" style="overflow: hidden;width: 110px; @if($header->PPBoardSpalte_IsUSA) font-weight:bold; @endif">{{substr(ServiceProvider::tl($lang,$header->PPBoardSpalte_Bezeichnung),0,20)}}</div></div></td>
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
                $styleCRD = 'color:black;';
                if ($value['CRDChanged']){
                    $styleCRD = 'color:dodgerblue;';
                }
                $isFirstRev = '';
                if ($value['PP']->PPProduktpass_RevisionVon_PPProduktpass_Id == 0){
                    $isFirstRev = '*';
                }
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
                $colArtikelBez = 'black';
                $alternativArtikel = $value['PP']->PPProduktpass_Artikelbezeichnung;
                if (!is_null($value['PP']->PPProduktpass_ArtikelTarga) and strlen($value['PP']->PPProduktpass_ArtikelTarga) > 2){
                    $alternativArtikel = $value['PP']->PPProduktpass_ArtikelTarga;
                    $colArtikelBez = 'red';
                }
                $pp['artikel'] = substr($alternativArtikel, 0, 80);
                if (strlen($alternativArtikel) > 80) {
                    $pp['artikel'] .= "+";
                }
                $pp['artikelVoll'] = $alternativArtikel;
                $pp['8WMuster']    = "";
                if (isset($value['8WMuster'])) {
                    $pp['8WMuster'] = $value['8WMuster'];
                }
                $pp['Musterung'] = substr($value['PP']->PPProduktpass_Ausmusterungnummer, 0, 4);
                $simInitColor = 'lightgray';
                if ($value['PP']->PPProduktpass_SimNeu == 0){
                    $simInitColor = 'lightgreen';
                }
                $pp['AltCharge'] = $value['PP']->PPProduktpass_AltCharge;
                $pp['LinkAltIAN']    = $value['PP']->PPProduktpass_AltIAN.'_'.$pp['AltCharge'];
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
                $pp['PJMler'] = '';
                if (!is_null($value['PP']->PPProduktpass_PJMAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdmin]) ){
                    $pp['PJMler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdmin];
                }
                $pp['TCler'] = 'N.N.';
                if (!is_null($value['PP']->PPProduktpass_TCAdmin) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_TCAdmin]) ){
                    $pp['TCler'] = $mitarbeiterliste[$value['PP']->PPProduktpass_TCAdmin];
                }
                $pp['PMlerVTR'] ='';
                if (!is_null($value['PP']->PPProduktpass_PMAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PMAdminVTR]) ){
                    $pp['PMlerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PMAdminVTR];
                }
                $pp['PJMlerVTR'] ='';
                if (!is_null($value['PP']->PPProduktpass_PJMAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdminVTR]) ){
                    $pp['PMlerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_PJMAdminVTR];
                }
                $pp['TClerVTR'] ='';
                if (!is_null($value['PP']->PPProduktpass_TCAdminVTR) and isset($mitarbeiterliste[$value['PP']->PPProduktpass_TCAdminVTR]) ){
                    $pp['TClerVTR'] = $mitarbeiterliste[$value['PP']->PPProduktpass_TCAdminVTR];
                }
                $dto         = new DateTime();
                $pp['lt']    = $dto->setISODate($pp['lty']+2000, $pp['ltw'])->format("d.m.Y");
                $W10 = new DateInterval('P9W');
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
                $cpbgcolor[1] = "rgb(255, 199, 206)"; //"rgb(255, 99, 71)";
                $cpbgcolor[0] = "rgb(255, 199, 206)";                      
                if ($lproject != $value['PP']->PPProduktpass_PPProjekte_Projekt or $lproject == "") {
                    $lcolor++;
                    $lcolor   = $lcolor % 2;
                    $lproject = $value['PP']->PPProduktpass_PPProjekte_Projekt;
                }
                $bgProject      = $pbgcolor[$lcolor];
                $bgCritProject  = $pbgcolor[$lcolor];
                if ($value['PP']->PPProduktpass_IsCriticalProject == 1){
                    $bgCritProject  = $cpbgcolor[$lcolor];
                } 
                $t2SPO = !is_null($value['PP']->PPProduktpass_Transferd2Sharepoint);
            ?>
            <!-- Spalte 10 -->
            <td class="table-cell cpcStickycol" style="background-color: {{$bgCritProject}};width:80px;padding:0px;">
                <div style="border:1px solid darkgray;border-radius:0px;height:56px;padding:8px; background-color:transparent;">
                    <a href="/show/{{$pp['id']}}" target="_blank" style="text-decoration: none;color:#000;">
                        <div style="border:none;    background-color: transparent;    border-radius: 0px;    width: 88px;    padding: 4px;    margin: -9px;">
                            @if (strlen($pp['ian'])>10)
                                {{substr($pp['ian'],0,10)}}X
                            @else
                                <span style="font-size:12px; color:{{ $pp['color_isRFQ'] }}"><b>{{$pp['ian']}}</b>   {{ $isFirstRev }}</span>
                            @endif
                        </div>
                    </a>
                    <br>
                    {{$pp['ParentChild']}}
                    <br>    
                    <div style="padding-top:0px; background-color: transparent; border-radius: 0px;">
                        @if (strlen($pp['AltIAN']) > 0)
                            @if ($pp['IsValid_OldIAN'])
                                <a href="/showAlt/{{$pp['id']}}" target="_blank" style="text-decoration: none;color:#003D7C;"><b>{{$pp['AltIAN']}}_{{$pp['AltCharge']}}</b></a>
                            @else 
                                {{$pp['AltIAN']}}_{{$pp['AltCharge']}}
                            @endif
                        @endif
                    </div>
                </div>
            </td>
            <!-- Spalte 1 -->
                    <td class="table-cell" style="background-color: {{$bgProject}};word-wrap: break-word;">{{$pp['Musterung']}}<br>
                        <a href='/showAlt/{{$value['PP']->PPProduktpass_Id}}/ALt'  target="_blank" style="font-size:0.8em;color:lightgray;text-decoration: none;">
                            <div style='border:1px solid gray;background-color:transparent;border-radius:0px;color:gray;padding:5px;margin-top:5px;font-weight:bold;'>Alt</div>
                        </a>
                        <a href="/getMpForm/{{$pp['id']}}" style="text-decoration:none;" target='_blank'><div style="border:1px solid darkblue;background-color:{{$simInitColor}};font-weight:bold;border-radius:0px;margin-top:5px;">MPlan</div></a> 
                    </td>
            <!-- Spalte 6 -->
            <td class="table-cell" style="background-color: {{$bgProject}};color:{{$colArtikelBez}};" title="{{$value['PP']->PPProduktpass_Artikelbezeichnung}}">{{$pp['artikel']}}</td>
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
                    <button style="width:92px;" type="button" onclick="setzeStatus({{$pp['id']}});">{{ ServiceProvider::tl($lang, 'setzen') }}</button>
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
                        <td style="{{ $styleCRD }}"><b>CRD:</b> </td>
                        <td><b>{{$crd->format('W/y')}}</b></td>
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
            <td class="table-cell" style="background-color: {{$bgProject}}; padding:0px;">
                @if (Auth::User()->PPMitarbeiter_Taetigkeit == 'PM' and Auth::User()->isMaster)
                <div name='divSelectTaet_TC' class='divSelectTaetHide' > 
                    TCler<br>
                    <select id="uebergabe_TC_{{$pp['id']}}" class='selectUebergabe'>
                        <option></option>
                    </select>
                    <button type="button" style="width:90px;margin-top:8px;" onclick="uebergabe({{$pp['id']}},'TC', {{$board}});">{{ ServiceProvider::tl($lang, 'übergeben') }}</button>
                </div>
                @endif    
                @if (Auth::User()->PPMitarbeiter_Taetigkeit == 'PM'  and Auth::User()->isMaster)
                <div  name='divSelectTaet_PM'  class='divSelectTaetHide'>
                    PMler<br>
                    <select id="uebergabe_PM_{{$pp['id']}}" class='selectUebergabe'>
                        <option></option>
                    </select>
                    <button type="button" style="width:90px;margin-top:8px;" onclick="uebergabe({{$pp['id']}},'PM', {{$board}});">{{ ServiceProvider::tl($lang, 'übergeben') }}</button>
                </div>
                @endif  
                 @if (Auth::User()->PPMitarbeiter_Taetigkeit == 'PM'  and Auth::User()->isMaster)
                 <div  name='divSelectTaet_PJM'  class='divSelectTaetHide'>
                    PJMler<br>
                    <select id="uebergabe_PJM_{{$pp['id']}}" class='selectUebergabe'>
                        <option></option>
                    </select>
                    <button type="button" style="width:90px;margin-top:8px;" onclick="uebergabe({{$pp['id']}},'PJM', {{$board}});">{{ ServiceProvider::tl($lang, 'übergeben') }}</button>
                 </div>
                @endif      
            </td>
            @endif
             <!-- Spalte 12 -->
            <td class="table-cell"  style="text-align:center; background-color: {{$bgProject}}; padding:0px; ">
            <?php 
                $user = Auth::user();
                $kuerzel = $user->PPMitarbeiter_Kuerzel;
                $maid = $user->id;
                $isAdmin = $user->PPMitarbeiter_Gruppe == 'admin';
                $isMaster =  $user->isMaster;
                $taetigkeit = $user->PPMitarbeiter_Taetigkeit;
                $allowVTRTC = false;
                $allowVTRPM = false;
                $allowVTRPJM = false;
                if ($kuerzel == $pp['PMler']){
                    $allowVTRPM = true;
                }
                if ($kuerzel == $pp['TCler']){
                    $allowVTRTC = true;
                }
                if ($taetigkeit == 'PM' and $isAdmin){
                    $allowVTRPM = true; 
                    $allowVTRPJM = true;
                }
                if ($taetigkeit == 'TC' and $isAdmin){
                    $allowVTRTC = true;
                }
            ?>
            <div style='border:none;position: relative;'>
                <div  style='position:absolute;top:0;' id="VTRTable{{$pp['id']}}">
                    <table class='PM'>
                    <tr>
                        @if($allowVTRPM)
                            <td onclick="VertretungShow('PM', {{$pp['id']}} );" title='{{ ServiceProvider::tl($lang, 'Vertreter PM setzen') }}' style='cursor:pointer;color:darkgreen;'><b>PM</b></td>
                        @else
                            <td><b>PM</b></td>                        
                        @endif
                            <td>{{$pp['PMler']}}
                            <td><span id="VTRDISPM{{$pp['id']}}">@if($pp['PMlerVTR'] != '')<b style="color:orangered;">{{$pp['PMlerVTR']}}</b> @endif</span></td>
                    </tr>
                    <tr>
                        @if($allowVTRPJM)
                            <td onclick="VertretungShow('PJM', {{$pp['id']}} );" title='{{ ServiceProvider::tl($lang, 'Vertreter PJM setzen') }}' style='cursor:pointer;color:darkgreen;'><b>PJM</b></td>
                        @else
                            <td><b>PJM</b></td>                        
                        @endif
                            <td>{{$pp['PJMler']}}
                            <td><span id="VTRDISPJM{{$pp['id']}}">@if($pp['PJMlerVTR'] != '')<b style="color:orangered;">{{$pp['PJMlerVTR']}}</b> @endif</span>
                            </td>
                    </tr>
                    <tr>
                        @if($allowVTRTC)
                            <td  onclick="VertretungShow('TC', {{$pp['id']}});" title='{{ ServiceProvider::tl($lang, 'Vertreter TC setzen') }}' style='cursor:pointer;color:darkgreen;'><b>TC</b></td>
                        @else
                            <td><b>TC</b></td>
                        @endif 
                            <td>{{$pp['TCler']}}
                            <td><span id="VTRDISTC{{$pp['id']}}">@if($pp['TClerVTR'] != '')<b  style="color:orangered;">{{$pp['TClerVTR']}}</b> @endif</span></td>
                    </tr>
                    </table>
                </div>
                <div id="VTRINPPM{{$pp['id']}}"  class='VTRINPHide'>   
                    <select id="vertretungPM{{$pp['id']}}" style="font-size:0.7rem;padding:5px;" onchange="VTRADD('PM', {{$pp['id']}});">
                        <option></option>
                        @foreach ($PMs as $vid => $vtr)
                        <option title='{{ isset($mitarbeiterNamen[$vid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$vid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$vid]->PPMitarbeiter_Vorname:"NNN";  }}' @if($pp['PMlerVTR'] == $vtr) selected @endif  value="{{$vid}}">{{ $vtr }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="VTRINPPJM{{$pp['id']}}" class='VTRINPHide'>   
                    <select id="vertretungPJM{{$pp['id']}}" style="font-size:0.7rem;padding:5px;" onchange="VTRADD('PJM', {{$pp['id']}});">
                        <option></option>
                        @foreach ($PJMs as $vid => $vtr)
                        <option title='{{ isset($mitarbeiterNamen[$vid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$vid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$vid]->PPMitarbeiter_Vorname:"NNN";  }}' @if($pp['PJMlerVTR'] == $vtr) selected @endif  value="{{$vid}}">{{ $vtr }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="VTRINPTC{{$pp['id']}}"  class='VTRINPHide'>   
                    <select id="vertretungTC{{$pp['id']}}" style="font-size:0.7rem;padding:5px;" onchange="VTRADD('TC',{{$pp['id']}});">
                    <option></option>
                        @foreach ($TCs as $vid => $vtr)
                        <option title='{{ isset($mitarbeiterNamen[$vid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$vid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$vid]->PPMitarbeiter_Vorname:"NNN";  }}'  @if($pp['TClerVTR'] == $vtr) selected @endif value="{{$vid}}">{{ $vtr }}</option>
                        @endforeach
                    </select>
                </div>
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
                if (isset($value['Termin'][$header->PPBoardSpalte_Id])){
                    $t['id']        = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Id;
                } else {
                    cpcDebug::cpc_debug('Fehler beim Aufbau des Dasboards','@ERROR');
                    cpcDebug::cpc_debug($header->PPBoardSpalte_Id,'@ERROR');
                    cpcDebug::cpc_debug($value['PP']->PPProduktpass_Id,'@ERROR');
                    //cpcDebug::cpc_debug('Termin:','@ERROR');
                    //cpcDebug::cpc_debug($value['Termin'],'@ERROR');
                }
                $t['bgcolor']   = null;
                if (isset($value['Termin'][$header->PPBoardSpalte_Id])){
                    $t['bgcolor']   = $value['Termin'][$header->PPBoardSpalte_Id]->PPStati_Background;
                }
                $t['bemerkung'] = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Bemerkungen;
                $t['terminart'] = $header->PPBoardSpalte_Bezeichnung;
                $t['status']    = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_Status;
                $t['ma']        = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_MAZustaendigkeit;
                $t['history']   = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_History;
                $t['log']       = $t['log'] = $value['Log'][$header->PPBoardSpalte_Id] ?? null;
                $dbV = $value['Dashboard'][$header->PPBoardSpalte_Id] ?? null;
                if ( isset($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate) and   $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate == '0000-00-00 00:00:00') {
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
                /****Neu Berechnung ************************************************************* */
                // 1. CRD
                // 2. Heute
                // 3. SpaltenTermin
                // 4. ManSollTerim
                // 5. Individueller Termin
                // CRD
                $newcrd = new DateTime();
                $newcrdw = $value['PP']->PPProduktpass_CRDWoche;
                $newcrdy = $value['PP']->PPProduktpass_CRDJahr;
                if ($value['PP']->PPProduktpass_CRDJahr ==0){
                    $newcrdw = $value['PP']->PPProduktpass_Liefertermin;
                    $newcrdy = $value['PP']->PPProduktpass_LieferterminJahr;
                }
                $crd->setISODate($crdy, $crdw, 5);
                if ($value['PP']->PPProduktpass_CRDJahr == 0){
                    $interval = new DateInterval('P10W');
                    $crd->sub($interval);
                }
                // Heute
                $newToday = new DateTime();
                // Spaltentermin
                $newstdPeriode = ($t['rot'] +10 );
                if ($newstdPeriode < 0 ){
                    $newstdPeriode *= -1 ;
                }
                /*****************************************************************144 */
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
                    if ($value['PP']->PPProduktpass_CRDJahr == 0){
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
                    if ($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate != '0000-00-00 00:00:00'){
                        $per1 = $value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSoll;
                        $perI = new DateInterval("P".$per1."W");
                        //$startDateNeu = clone $crd;
                        //$startDateNeu->sub($perI);
                        $startDateNeu = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate);
                        $rwi = $datenow->diff($startDateNeu);
                        $rw = $rwi->format("%R%a")/7;
                        $w2startNeu = floor($rw); 
                        $pre="MAN";
                    }
                    $startKWNeuDisplay = "";
                    $dOw = '';
                    if (substr($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 10) != "0000-00-00") {
                        $startDateNeu = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumStart);
                        // Freitag der Woche DatumStart
                        $dayOfWeek = $startDateNeu->format('w');
                        $d2friday = 5- $dayOfWeek;
                        $d2FridayInterval = new DateInterval('P'.$d2friday.'D'); 
                        $startDateNeu = $startDateNeu->add($d2FridayInterval);
                        $datenow = new DateTime(date('Y-m-d'));
                        $dayOfWeek = $datenow->format('w');
                        $d2friday = 5- $dayOfWeek;
                        $d2FridayInterval = new DateInterval('P'.$d2friday.'D'); 
                        $datenow = $datenow->add($d2FridayInterval);
                        $diffI = $datenow->diff($startDateNeu,1);
                        $diffTage = $diffI->format("%R%a");
                        if ($startDateNeu < $datenow ){
                            $pre="I1"; 
                            $startKWNeu = floor($diffTage/7) * -1;
                            //$startKWNeuDisplay =  $diffTage;
                        } else {
                            $pre="I2";
                            $startKWNeu = ceil($diffTage/7);
                            //$startKWNeuDisplay = $diffTage;
                        }
                        $w2startNeu = $startKWNeu;
                        $startKWNeuDisplay = 'x';
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
                    //$startKWNeuDisplay = $pre;
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
                    $newErlDate = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_DatumEnde);
                    if ($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate != '0000-00-00 00:00:00'){
                        $newSollDate = new DateTime($value['Termin'][$header->PPBoardSpalte_Id]->PPTermine_ManSollDate);
                    } else {
                            $nnewcrd = new DateTime();
                            $nnewcrdw = $value['PP']->PPProduktpass_CRDWoche;
                            $nnewcrdy = $value['PP']->PPProduktpass_CRDJahr;
                            if ($value['PP']->PPProduktpass_CRDJahr == 0){
                                $nnewcrdw = $value['PP']->PPProduktpass_Liefertermin;
                                $nnewcrdy = $value['PP']->PPProduktpass_LieferterminJahr;
                            }
                            $nnewcrd->setISODate($nnewcrdy, $nnewcrdw, 5);
                            if ($value['PP']->PPProduktpass_CRDJahr == 0){
                                $interval = new DateInterval('P10W');
                                $nnewcrd->sub($interval);
                            }
                            //$interval = new DateInterval('P4D');
                            //$nnewcrd->sub($interval);
                            $nstdPeriode = ($t['rot'] +10 );
                            if ($nstdPeriode < 0 ){
                                $nstdPeriode *= -1 ;
                            }
                            $nstdPeriodeInterval = new DateInterval('P'.$nstdPeriode.'W'); 
                            $newSollDate = clone $nnewcrd;
                            if ($t['rot'] +10  < 0 ){
                                $newSollDate->sub($nstdPeriodeInterval);
                            } else {
                                $newSollDate->add($nstdPeriodeInterval); 
                            }
                    }
                    $ndiff = $newSollDate->diff($newErlDate,1);
                    $newW2Erl =  $ndiff->format('%R%a')/7;
                    $newW2Erl = floor($newW2Erl);
                    if ($newErlDate > $newSollDate  ){
                        $t['WERL'] = 0;
                        if ($newW2Erl > 0){
                            $t['WERL'] = -1 * $newW2Erl; 
                        }
                    } else {
                        $t['WERL'] = $newW2Erl; 
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
                $newBG = $bgNeu;
                $empty = false;
                if ($t['status'] == 'nicht benötigt'){
                    $empty = true;
                    $newBG = '255, 199, 206';
                }
            ?>
            <td class="table-cell_value" style="border:1px solid #003D7C; overflow: hidden; padding:0px;vertical-align: top;">
                @if($t['OKSTATUS'] == 'NO') 
                        <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color: rgb({{$newBG}});text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2startNeu }}W 
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @else
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @endif">
                            <span style="font-size:8px;font-weight: bolder;color:#003D7C;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2startNeu }}W 
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @else
Deadline (berechnet): {{ $po['w2fob'] + $t['rot']}}W @endif">{{ $w2startNeu }}</span>
                        </div>
                @else
                    @if ($t['WERL'] < 0 )
                    <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color: @if ($t['status'] != 'nicht benötigt') rgb(255, 199, 206) @else rgb(25,157,45) @endif ;text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2startNeu }}W 
Deadline (berechnet): {{ $pp['w2crd'] + $t['rot'] + 9 }}W @else 
Deadline (berechnet): {{ $pp['w2crd'] + $t['rot'] + 9 }}W @endif">
                        <span  style="font-size:8px;font-weight: bolder;color:darkblue;"   > @if ($t['status'] != 'nicht benötigt'){{ $t['WERL'] }} @endif</span> 
                    </div>
                    @else 
                    <div style="text-align:left;padding-left:0px;width:30px;height:12px;border-radius: 0px;background-color: rgb(25,157,45);text-align:center;" title="@if ($w2start != $w2start_undef) Deadline (manuell): {{ $w2start }}W 
Deadline (berechnet): {{  $pp['w2crd'] + $t['rot'] + 9 }}W @else
Deadline (berechnet): {{  $pp['w2crd'] + $t['rot'] + 9 }}W @endif ">
                        <span  style="font-size:8px;font-weight: bolder;color:white;"    >@if ($t['status'] != 'nicht benötigt'){{ $t['WERL'] }} @endif</span> 
                    </div>
                    @endif 
                @endif 
                <div title="{{$dbV['Art']}} 
CRD:{{$dbV['CRDDate']}} 
W2Soll:{{$dbV['W2CRD']}}  
Soll:{{$dbV['SollDate']}} 
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
                    <div style='position:absolute; bottom:0px; right:0px; width:100%;height:8px;width:8px;background-color: rgb(119, 119, 119); border:none;border-radius: 0px;margin:0px;' title="{{ trim(ServiceProvider::tl($lang, $t['bemerkung'])) }} ">&nbsp;</div>
                    @endif
                    <span style='font-size: 8px;font-family: Arial, Helvetica, sans-serif;color:rgb(9, 41, 146);'>{{ ServiceProvider::tl($lang, $t['label'])}}</span>
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
<div style="font-family:'Open Sans', Tahoma,  Arial,  sans-serif;padding:20px;"><h1>Keine Daten gefunden!</h1></div>
@endif
<script>
    $( document ).ready(function() {
        firstInput = document.getElementById('inpFormIAN');
        firstInput.focus();
    });
    function submitFormX(event){
        if (event.keyCode == 13) {
            frm = document.getElementById('formgetTermine');
            frm.submit();
            return false;
        }
    }
    function uebergabe (ppid, art, board){
        const elem = document.getElementById('uebergabe_' + art + '_' + ppid);
        var maid = elem.value;
        var art1 = document.getElementById('selectTaetigkeit');
        if (maid != 0){
           console.log(ppid + '#'+art+'#'+maid+'#'+board+'#'+art1.value);
           setMA_PM_TC(ppid, art1.value, maid, board );
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
    function saveFilter(board) {
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
        frmData.append('board', board);
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
    function getFilter(board) {
        var frmData = new FormData();
        frmData.append('board', board);
        $.ajax({
            type: "POST",
            url: "/getFilter",
            data: frmData,
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
            alert( '{{ ServiceProvider::tl($lang, "Status gesetzt!") }}' );
            window.location.reload();
            }
    function setMA_PM_TC(id, art, maid, board) {
        console.log("set MA id: " + id + " art: " + art +"  maid: " + maid + " board: " + board);
        var frmData = new FormData();
        frmData.append('id', id);
        frmData.append('art', art);
        frmData.append('maid', maid);
        frmData.append('board', board);
        console.log(frmData);
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
        console.log("onSuccess_setMA_PM_TC");
        console.log(jsonResult);
        data = JSON.parse(jsonResult).Data;
        console.log("data2:");
        console.log(data);
        elem = document.getElementById('uebergabe_' + data.art + '_' + data.id);
        if (elem){
            elem.value = '';
        }
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
                    if (elements[i].name == 'sQry[PPProduktpass_Ausmusterungnummer]'){
                        elements[i].value = "%";
                    }
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
    function vtrTableShow (art, ppid){
        table1 = document.getElementById ('VTRTAB'+art+ppid);
        if (table1){
            table1.style.display = '';
        }
    }
     function vtrTableHide (art, ppid){
        table1 = document.getElementById ('VTRTAB'+art+ppid);
        if (table1){
            table1.style.display = 'none';
        }
    }
    function VertretungShow (art, ppid){
        console.log("VertretungShow: " + art + ppid);
        vtrTableHide (art, ppid);
        const inp = document.getElementById ('VTRINP'+art+ppid);
        if (inp.classList.contains('VTRINPHide')) {
            console.log("VertretungHide: Hide gefunden");
            inp.classList.replace('VTRINPHide', 'VTRINPShow');
        }
    }
    function VertretungHide (art, ppid){
        console.log("VertretungHide: " + art + ppid);
        vtrTableShow (art, ppid);
        const inp = document.getElementById ('VTRINP'+art+ppid);
        if (inp.classList.contains('VTRINPShow')) {
            console.log("VertretungHide: Show gefunden");
            inp.classList.replace('VTRINPShow', 'VTRINPHide');
        }
    }
    function VTRADD (art, ppid){
        const vtr = document.getElementById ('vertretung'+art+ppid);
        const dis = document.getElementById ('VTRDIS'+art+ +ppid);
        if (vtr){
            if (vtr.value == 0){
                dis.innerHTML = '';
            } else {
                dis.innerHTML = '<b style="color:orangered;">' + vtr.options[vtr.selectedIndex].text +'</b>';
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
        console.log(data);
        //elem = document.getElementById('uebergabe_' + data.id);
        //elem.value = '';
        alert( data['message'] );
        //window.location.reload();
        }
    function prevPage(){
        var elemInp = document.getElementById('page');
        var page = elemInp.value;
        if (page -1 > 0){
               page = page -1;
                elemInp.value = page;
                subm();
        } else {
            alert('Erste Seite erreicht!');
        }
    }
    function nextPage(){
        var elemInp = document.getElementById('page');
        var elemPages = document.getElementById('pages');
        var page = elemInp.value * 1;
        if (page < elemPages.value){
            page = page + 1;
            elemInp.value = page;
            subm();
        } else {
            alert('Letzte Seite erreicht!');
        }
    }
    function subm (){
        var frm = document.getElementById('formgetTermine');
        frm.submit();
    }
    function _hideDivSelect(art){
        console.log("hideDivSelect: " + art);
        const strdivselect = '[name="divSelectTaet_' + art + '"]';
        const divselect = document.querySelectorAll(strdivselect);
        for (let index = 0; index < divselect.length; index++) {
            const div = divselect[index];
            console.log(div);
            if (div){
                div.classList.replace('divSelectTaetShow', 'divSelectTaetHide');
            }
        }
    }
    function hideDivSelect(){
        _hideDivSelect('PM');
        _hideDivSelect('TC');
        _hideDivSelect('PJM');
    }
    function fillSelect( selector1 ){
        console.log("fillSelect: " + selector1.value);
        const art = selector1.value;
        hideDivSelect();
        //console.log('Name:' + selects1.name);
        const strdivselect = '[name="divSelectTaet_' + art + '"]';
        console.log("strdivselect: " + strdivselect);
        const divselect = document.querySelectorAll(strdivselect);
        for (let index = 0; index < divselect.length; index++) {
            const div = divselect[index];
            console.log(div.classList);
            if (div){
                div.classList.replace('divSelectTaetHide', 'divSelectTaetShow');
            }
        }
        const strselect = '[id^="uebergabe_' + art + '_"]';
        console.log("strselect: " + strselect);
        const selects1 = document.querySelectorAll(strselect);
        for (let index = 0; index < selects1.length; index++) {
            const select = selects1[index];
            const ppid = select.id.replace('uebergabe_' + art + '_', '');
            console.log("select ppid: " + ppid);
            select.innerHTML = '';
            _fillSelectPM(ppid, select, art);
        }
    }
    function _fillSelectPM(  ppid, select, art ){
        var pms = [];
        if (art == 'PM'){
            pms = <?php echo json_encode($PMs); ?>;
        } else if (art == 'TC'){
            pms = <?php echo json_encode($TCs); ?>;
        } else if (art == 'PJM'){
            pms = <?php echo json_encode($PJMs); ?>;
        }
        console.log(pms);
        const select2 = document.getElementById("uebergabe_" + art + "_" + ppid);
        select.options[0] = new Option("", "", true, true);
        select.options[0].disabled = true;
        for( const id in pms ){
            const option = document.createElement("option");
            option.value = id;
            option.textContent = pms[id];
            select.appendChild(option);
        }
    }
</script>