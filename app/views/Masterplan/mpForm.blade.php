<style>
   :root {
        --color-rosa: rgb(255, 199, 206);
        --color-darkrosa: rgb(255, 199, 206);
        --color-hellgruen: rgb(198, 254, 206);
        --color-dunkelblau: #003D7C;
        --color-hellblau: rgb(189, 215, 238);
        --color-dunkelgruen: rgb(25, 157, 45);
        --color-red: rgb(255, 0, 0);
        --color-gray:rgb(147,219,231,1);
        --color-edit:#E8E8E8;
        --color-darkedit:#C8C8C8;
        --color-abweichungMPlan:#fcbe77;
        --color-NoSimDate:#e298ff;
        --color-lightPatrol:rgb(147, 219, 231);
        --color-debug: rgb(0, 255, 34);
        --color-DeadlineFailLidl: rgb(255, 199, 206);
        --color-ueber-budget: #fcbe77;
        --color-lidl-deadline: rgb(255, 199, 206);
        --color-sim-akt-diff: rgb(255, 0, 0);
        --color-start-2-crd: rgb(255, 199, 206);
        --color-ok: rgb(198, 254, 206);
        --color-diff-ok: #696969;
        --color-ExceptionOrange: transparent;
        --color-ExceptionMagenta: transparent;
        --color-ExceptionTurquoise: transparent;
        --color-ExceptionCyan: transparent;
    }
    .gridContainer {
        display: grid;
        grid-template-columns: 5% 35% 12% 12% 12% 12% 12%;
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        text-align: left;
        margin: 0 auto;
        border-radius: 0px;
        border: 1px solid gray;
        overflow: auto;
        height: 90%;
        border:none;
        font-size: 0.8em;
    }
    .gridHeader {
        background-color: rgb(37, 150, 190);
        color: white;
        font-weight: bold;
        font-size: 1.2em;
        border-radius: 0px;
        border: 1px solid dimgray;
        padding: 10px;
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .gridKMS {
        background-color: var(--color-lightPatrol);
        color: black;
        font-weight: bold;
        font-size: 1.2em;
        border-radius: 0px;
        border: 1px solid dimgray;
        padding: 10px;
        display: flex;
    }
    .gridRow {
        background-color: white;
        color: rgba(13, 5, 2, 255);
        font-size: 1em;
        border-radius: 0px;
        border: 1px solid dimgray;
        padding: 10px;
        border-radius: 0px;
        display: none;
        --opacity: 0;
        --transition: opacity .8s ease, display 0.5s ease allow-discrete;
    }
    .dateBudgetKMS {
        display: inline;
        width: 100%;
        height: 100%;
        font-size: 1em;
        font-weight: bold;
        border: none;
        padding: 10px;
        background-color: var(--color-edit);
        --rgba(147, 219, 231, 255);
        color: rgba(13, 5, 2, 255);
        text-align: right;
    }
    .dateKMS {
        display: inline;
        width: 100%;
        height: 100%;
        font-size: 1em;
        font-weight: bold;
        border: none;
        padding: 10px;
        background-color: rgba(147, 219, 231, 255);
        color: rgba(13, 5, 2, 255);
        text-align: right;
    }
    .dateKMSOhne {
        display: inline;
        width: 100%;
        height: 100%;
        font-size: 1em;
        font-weight: bold;
        border: none;
        padding: 10px;
        background-color: rgba(147, 219, 231, 255);
        color: rgba(13, 5, 2, 255);
        text-align: right;
    }
    .dateKMSRO {
        display: inline;
        width: 100%;
        height: 100%;
        font-size: 1em;
        font-weight: bold;
        border: none;
        padding: 10px;
        background-color: rgba(147, 219, 231, 255);
        color: rgba(13, 5, 2, 255);
        text-align: right;
    }
    .dateBudgetKMSRO {
        display: inline;
        width: 100%;
        height: 100%;
        font-size: 1em;
        font-weight: bold;
        border: none;
        padding: 10px;
        background-color: rgba(147, 219, 231, 255);
        color: rgba(13, 5, 2, 255);
        text-align: right;
    }
    .dateMS {
        display: inline;
        text-align: right;
        width: 100%;
        height: 100%;
        font-size: 1em;
        color: dimgray;
        font-weight: bold;
        border: none;
        padding: 10px;
    }
    .dateBudgetMS{
        display: inline;
        text-align: right;
        width: 100%;
        height: 100%;
        font-size: 1em;
        color: dimgray;
        font-weight: bold;
        border: none;
        padding: 10px;
        background-color: var(--color-edit);
    }
    .dateMSRO {
        display: inline;
        text-align: right;
        width: 100%;
        height: 100%;
        font-size: 1em;
        color: dimgray;
        font-weight: bold;
        border: none;
        padding: 10px;
    }
    .mpSubmit {
        width:12%;
        height: 50px;
        margin-left:20px;
        margin-top:20px;
        margin-bottom:20px;        
        border: 1px solid darkblue;
        font-size: 0.7vw;
        font-weight: bolder;
        padding: 10px;
        position:relative;
    }
    .mpSubmitZuruecksetzen {
        width:220px;
        height: 50px;
        margin-left:20px;
        margin-top:20px;
        margin-bottom:20px;        
        border: 1px solid darkblue;
        font-size: 0.7vw;
        font-weight: bolder;
        padding: 10px;
    }
    #left {
        float: left;
        border: 1px solid gray;
        width: 20%;
        height: 98%;
        border-radius: 0px;
        margin-right: 10px;
    }
    #right {
        float: left;
        border: 1px solid gray;
        text-align:left;
        width: 65%;
        height: 98%;
        border-radius: 0px;
        min-width:900px;
    }
    #PPData {
        border-collapse: collapse;
        margin-left: 0px;
    }
    .tbLabel {
        background-color: rgba(147, 219, 231, 255);
        font-weight: bold;
        color: black;
        padding: 10px;
        font-size: 1em;
        border: 1px solid dimgray;
        width: 40%;
    }
    .tbValue {
        background-color: white;
        color: DimGray;
        padding: 10px;
        font-size: 1em;
        border: 1px solid dimgray;
        width: 75%;
    }
    .gridscroller {
        border: 1px solid var( --color-red);
        overflow: scroll;
        height: 80vh;
    }
    #hrefNoDeco  {
        color:darkblue;
        text-decoration: none;
    }
    .box-left {
        width: 10%;
        border: 4px solid red;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .box-right {
        width: 90%;
        box-sizing: border-box;
        /* verhindert Überlauf wegen padding/border */
    }
    .two-col {
        width:90%;
        border: 1px solid gray;
        border-radius: 0px;
        display: grid;
        grid-template-columns: 1fr 3fr;
        /* links/rechts */
        gap: 0;
        align-items: left;
        /* vertikal mittig */
        margin-top:10%;
        margin-left:1%;
        padding: 8px;
    }
    .two-col .image {
        display: grid;
        place-items: left;  
    }
    .two-col .image img {
        display: block;
        border-radius: 0px;
        width: 150px;
        height: 38px;   
    }
    .two-col .text {
        line-height: 1;
        padding-top:5px;
        padding-left:5px;
        text-align: left;
        vertical-align: top;
        font-size: 0.8rem;
        border-bottom: 1px solid gray;
        border-radius: 0px;
    }
    .btn_href {
        display: inline-block;
        padding: 10px 18px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
    }
    .btn_href:hover {
        background-color: #0056b3;
    }
    .btn-calcMS {
        margin-left: 4px;
        padding: 2px 6px;
        font-size: 11px;
        cursor: pointer;
    }
    .kmsBudgetCell{
        display: flex;
        align-items: stretch;
    }
    .kmsBudgetCell > .dateKMS{
        flex: 1 1 auto;
        width: auto;
        /* überschreibt width:100% */
        min-width: 0;
        /* wichtig, damit es wirklich schrumpfen darf */
    }
    .kmsBudgetCell > .btn-calcMS{
        flex: 0 0 auto;
        white-space: nowrap;
        margin: 0;
        border: 1px solid dimgray;
        background: white;
    }
    .gridSpacerCell{
        background: transparent;
        border: none;
        /* oder 1px solid dimgray, wenn du Linien willst */
        padding: 10px;
        min-height: 18px;
        /* Höhe der Leerzeile */
        display: block;
        /* wichtig, weil .gridRow bei dir display:none hat */
        opacity: 1;
    }
    .gridKMS {
    display: flex;
    align-items: stretch;
    text-align: left;
    padding: 0;
    }
    .gridKMS .arrowBox {
        width: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: transparent;
        border: none;
    }
    .gridKMS .colorBar {
        width: 10px;
            background: transparent;
        margin-right: 20px;
        border-radius: 0px;
        display: flex;
        flex-direction: column;
    }
    .colorPart {
        flex: 1;
        border-radius: 0px;
    }
    .colorBarRow {
        width: 10px;
        height:100%;
        background: red;
        margin-left: 10px;
        margin-right: 20px;
        border-radius: 0px;
        border:none;
    }
    /* === MPLAN responsive/stabil ohne Layout-Umbau === */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }
    html,
    body {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    form#frmMP {
        width: 100%;
    }
    form#frmMP > div {
        padding-top: 50px !important;
        padding-left: clamp(10px, 4vw, 100px) !important;
        width: 100% !important;
        height: auto !important;
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }
    /* linke Infobox bleibt links, schrumpft aber kontrolliert */
    #left {
        float: none !important;
        flex: 0 0 clamp(260px, 22vw, 380px);
        width: auto !important;
        min-width: 240px;
        max-width: 420px;
        height: auto !important;
        overflow: auto;
    }
    /* rechter Bereich nimmt Rest ein */
    #right {
        float: none !important;
        flex: 1 1 auto;
        width: auto !important;
        min-width: 0 !important;
        height: auto !important;
        overflow: hidden !important;
    }
    /* Grid darf intern breit bleiben, Seite bricht nicht mehr */
    .gridContainer {
        width: 100%;
        min-width: 980px;
        height: 80vh;
        overflow: auto;
        grid-template-columns:
            minmax(48px, 5%)
            minmax(260px, 35%)
            minmax(120px, 12%)
            minmax(120px, 12%)
            minmax(120px, 12%)
            minmax(120px, 12%)
            minmax(120px, 12%);
    }
    /* ungültige / fragile Stellen neutralisieren */
    .gridContainer {
        grid-template-rows: none;
    }
    .gridHeader,
    .gridKMS,
    .gridRow {
        min-width: 0;
        overflow: hidden;
    }
    .gridKMS input,
    .gridRow input {
        min-width: 0;
        max-width: 100%;
    }
    /* Inputs robuster */
    .dateBudgetKMS,
    .dateKMS,
    .dateKMSOhne,
    .dateKMSRO,
    .dateBudgetKMSRO,
    .dateMS,
    .dateBudgetMS,
    .dateMSRO,
    .dateBudgetMSRO {
        min-width: 0;
        max-width: 100%;
        padding: 8px;
    }
    /* Buttons skalieren besser */
    .mpSubmit {
        width: auto !important;
        min-width: 120px;
        max-width: 100%;
        font-size: clamp(11px, 0.7vw, 14px);
        white-space: nowrap;
    }
    .mpSubmitZuruecksetzen {
        width: 100%;
        max-width: 220px;
        font-size: clamp(11px, 0.7vw, 14px);
    }
    /* Legende links robuster */
    .two-col {
        width: 96%;
        margin-top: 30px;
        grid-template-columns: minmax(90px, 150px) 1fr;
    }
    .two-col .image img {
        max-width: 100%;
        height: auto;
    }
    /* Tabellen links nicht sprengen lassen */
    #PPData {
        width: 100%;
        table-layout: fixed;
    }
    .tbLabel,
    .tbValue {
        overflow-wrap: anywhere;
    }
    /* mittlere Breite: links/rechts bleiben, aber kompakter */
    @media (max-width: 1300px) {
        form#frmMP > div {
            padding-left: 20px !important;
        }
        #left {
            flex-basis: 280px;
        }
        .gridContainer {
            min-width: 920px;
        }
    }
    /* kleine Screens: Bereiche untereinander, Grid horizontal scrollbar */
    @media (max-width: 1000px) {
        form#frmMP > div {
            flex-direction: column;
            padding-left: 10px !important;
            padding-right: 10px;
        }
        #left,
        #right {
            width: 100% !important;
            max-width: none;
            min-width: 0 !important;
        }
        #right {
            overflow: hidden !important;
        }
        .gridContainer {
            min-width: 900px;
            height: 70vh;
        }
        .mpSubmit {
            margin-left: 8px;
            margin-top: 8px;
            margin-bottom: 8px;
        }
    }
    /* sehr kleine Screens */
    @media (max-width: 600px) {
        .gridHeader,
        .gridKMS,
        .gridRow {
            font-size: 0.85em;
        }
        .gridContainer {
            min-width: 860px;
        }
        .two-col {
            grid-template-columns: 1fr;
        }
        .two-col .image {
            margin-top: 8px;
        }
    }
    #right {
        overflow: hidden !important;
    }
    .gridContainer {
        max-width: 100%;
        overflow-x: auto;
        overflow-y: auto;
        height: 80vh;
    }
    .pruefphasen-table {
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    .pruefphasen-table th,
    .pruefphasen-table td {
        padding: 6px 20px;
        text-align: left;
        white-space: nowrap;
    }
    .pruefphasen-table th {
        font-weight: bold;
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
    }
    .pruefphasen-table th + th,
    .pruefphasen-table td + td {
        border-left: 1px solid #000;
        text-align: center;
    }
    /* Mindesthöhe für lesbare Grid-Zeilen */
.gridContainer {
    grid-auto-rows: minmax(34px, auto);
    align-items: stretch;
}
/* Alle Grid-Zellen mindestens hoch genug machen */
.gridHeader,
.gridKMS,
.gridRow {
    min-height: 34px;
    line-height: 1.25;
    font-size: max(10px, 1em);
}
/* Inputs in den Zellen lesbar halten */
.gridKMS input,
.gridRow input,
.dateBudgetKMS,
.dateKMS,
.dateKMSOhne,
.dateKMSRO,
.dateBudgetKMSRO,
.dateMS,
.dateBudgetMS,
.dateMSRO,
.dateBudgetMSRO {
    min-height: 32px;
    line-height: 1.25;
    font-size: max(10px, 1em);
    padding-top: 6px;
    padding-bottom: 6px;
}
/* Beim Aufklappen nicht inline verwenden, sondern grid-kompatibel */
.gridRow.is-visible {
    display: block;
}
</style>
<?php  
    function calcDeadLine ($d, $w){
        $aDDPDate = explode('/', $d);
        //return(print_r($aDDPDate,1));
        $ddpWeek =  $aDDPDate[0];
        $ddpYear =  $aDDPDate[1];
        $deadline = '';
        try{
            $date = new DateTime();
            $date->setISODate($ddpYear, $ddpWeek);
            $date->sub(new DateInterval("P".$w."W"));
            // Ergebnis
            $deadline = $date->format('W/Y'); 
        } catch (Exception $ex){
            $deadline = '';
        }
        return $deadline;
    }
    $h = $data['HeaderData'];  
    $qm = '';
    if ($data['SimNeu']){
        $qm = '?';
    }
    $CRDDate = $h['CRD Datum'];    
    $overdue = [];
    $markManEdit = [];
    $projectStartIndex = 0;
    $projectStartSpalteId = $data['KeyMilestones'][$projectStartIndex]->PPBoardSpalte_Id;
    $projectStart = $data['Termine'][$projectStartSpalteId]->PPTermine_SimDate; 
    if ($projectStart == '0000-00-00 00:00:00'){
        $projectStart = MasterPlanController::dadd($CRDDate, $data['KeyMilestones'][$projectStartIndex]->PPBoardSpalte_Rot + 10);
    } 
    $farbe1 = 'transparent';
    $farbe2 = 'transparent';
    $farbe3 = 'transparent';
    $bid = 1011;
    if ($h['Charge'] < '2510'){
        $bid = 1000;
    }
    $eugDeadline = calcDeadLine($h['DDP'], 17);
    $spuDeadline = calcDeadLine($h['DDP'], 16);
    $altDeadline = calcDeadLine($h['DDP'], 13);
    $psiDeadline = calcDeadLine($h['DDP'], 11);
?>
<form action='/setKeyMilestones' method='POST' id='frmMP' onsubmit="return confirmX();">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div style="padding-top:50px;padding-left:100px;width:90%;height:90%;">
        <div id='left' style='position: relative;'>
            <div class='gridHeader'>{{ $data['Header'] }}</div>
            <table id='PPData'>
                @foreach ($h as $label => $value)
                    <tr>
                        <td class='tbLabel'>{{ $label }}</td>
                        <td class='tbValue'>{{ $value }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class='tbLabel'>Link zum Produktpass</td>
                    <td class='tbValue'><a href="{{ url('/show/' . $data['ppid']) }}"
                            target='_blank'>{{ $h['IAN'] }}_{{ $h['Charge'] }}</a></td>
                </tr>
                <tr>
                    <td>Projekt zurücksetzen</td>
                    <td>
                        <input  class='mpSubmitZuruecksetzen' type='submit'    value='Zurücksetzen' onclick="setReset('recalc');" name='submit' title='Setzt alle Termine der Meilensteine zurück auf 0 und berechnet die Soll Termine neu Aufgrund der Stammdaten' />
                    </td>
                </tr>
            </table>
            <div class="two-col">
                <div class="col image">
                    <img src="{{ asset('/images/MPlan/MPlan_Pfeil.png') }}" alt="Milestone Abweichung MPLan">
                </div>
                <div class="col text">
                    Milestone(s) in diesem Bereich weichen vom Budget ab oder haben eine Regel verletzt
                </div>
                <div class="col image">
                    <img src="{{ asset('/images/MPlan/MPlan_NoMPlan.png') }}" alt="Regelbruch">
                </div>
                <div class="col text">
                    Milestone weicht vom Budget ab
                </div>  
                <div class="col image">
                    <img src="{{ asset('/images/MPlan/MPlan_MS_RegelBruch.png') }}" alt="Regelbruch">
                </div>
                <div class="col text">
                    Termin entspricht nicht den Regeln (Vor Projektstart oder nach CRD)
                </div>  
                <div class="col image">
                    <img src="{{ asset('/images/MPlan/MPlan_MS_Regelkonform.png') }}" alt="RegelKonform">
                </div>
                <div class="col text">
                    Termin OK
                </div>
                <div class="col image">
                    <img src="{{ asset('/images/MPlan/MPlan_MS_SollNochNichtGespeichert.png') }}"
                        alt="Solltermin noch nicht gespeichert">
                </div>
                <div class="col text">
                    Die Solltermine wurden noch nicht gespeichert
                </div> 
                <div class="col image" style="padding:5px;border:1px solid gray;border-radius:0px;padding-left:45px;">
                    <span style="color:red;font-weight:bold;font-size:14px;"> {{date('d.m.Y')}}<span>
                </div>      
                <div class="col text">Datum weicht von Solltermin ab.</div>
            </div>
            <div>
                <table class="pruefphasen-table">
                    <thead>
                        <tr>
                            <td colspan="3">LIDL Deadline</td>
                        </tr>
                        <tr>
                            <th>Prüfphase</th>
                            <th>OWIM</th>
                            <th>KW</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>EUG</td>
                            <td>17 Wochen vor LT</td>
                            <td>{{$eugDeadline}}</td>
                        </tr>
                        <tr>
                            <td>30% SPU</td>
                            <td>16 Wochen vor LT</td>
                            <td>{{$spuDeadline}}</td>
                        </tr>
                        <tr>
                            <td>ALT</td>
                            <td>13 Wochen vor LT</td>
                            <td>{{$altDeadline}}</td>                            
                        </tr>
                        <tr>
                            <td>100% PSI</td>
                            <td>11 Wochen vor LT</td>
                            <td>{{$psiDeadline}}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
        </div>
        <div id='right' style='width:75%;'>
            <input type="hidden" name ='ppid' value='{{ $data['ppid'] }}'>
            <div class="gridContainer">
                    <div class="gridHeader" style='text-align:center;'>
                        <div style='background-color:transparent;'>
                        </div>
                    </div>
                <!-- div class="gridHeader">Klasse</div -->
                <div class="gridHeader">Milestone</div>
                    <div class="gridHeader" style='text-align:right;'>Termine CRD Basiert</div>
                    <div class="gridHeader" style='text-align:right;'>Budget Termine</div>
                    <div class="gridHeader" style='text-align:right;'>Termine erledigt</div>
                    <div class="gridHeader" style='text-align:right;'>Termine Anpassungen</div>
                    <div class="gridHeader" style='text-align:right;'>Termine Aktuell</div>
                <?php  $test =  MasterPlanController::mplanTest($data['ppid']); 
                       cpcDebug::cpc_debug(" TSET: ".json_encode($test,JSON_PRETTY_PRINT), '-SimMplanColor6');
                       $violations = isset($test[$data['ppid']]) ? $test[$data['ppid']] : [];
                ?>
                @foreach ($data['KeyMilestones'] as $kms)
                    <?php
                            // CRD Basiert KMS
                        $simDfBasisCRD = MasterPlanController::dadd($CRDDate, $kms->PPBoardSpalte_Rot + 10);
                            // Budget KMS
                            $s_budgetKMS = '';
                            if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_ManSollDate, 0, 4) != '0000') {
                                $d_budgetKMS = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_ManSollDate);
                                $s_budgetKMS = $d_budgetKMS->format('d.m.Y');
                            }
                            // Soll KMS
                            $simDfMaster = '';
                            if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_SimDate, 0, 4) != '0000') {
                                $dmaster = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_SimDate);
                                $simDfMaster = $dmaster->format('d.m.Y');
                                $isSimDate = false;
                            } else {
                                // Berechne 1. Sim datum auf Basis CRD
                            $simDfMaster = MasterPlanController::dadd($CRDDate, $kms->PPBoardSpalte_Rot + 10);
                                $isSimDate = true;
                            }
                            // StartDateum KMS
                    $df = '';
                    if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 4) != '0000') {
                        $d = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumStart);
                        $df = $d->format('d.m.Y');
                    }
                        $BGTestDate = 'background-color:var(--color-lightPatrol);';
                            if ($isSimDate){
                            $BGTestDate = 'background-color:var(--color-NoSimDate);';
                    }
                    $color = 'color:black;';
                        if (isset($violations[$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id]['stats']['simAktDiff']) && $violations[$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id]['stats']['simAktDiff'] == 'diff') {
                            $color = 'color:lime;';
                    }
                            if ($data['BudgetFix'] == 0){
                                $simDfMaster ='';
                                $isSimDate = false;
                            }
                            if ($isSimDate){
                            $BGTestDate = 'background-color:var(--color-NoSimDate);';
                            }
                            $sRdyDateKMS = '';
                        if (!is_null($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumEnde) and $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumEnde != '0000-00-00 00:00:00') {
                                $dRdyDateKMS = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumEnde);
                                $sRdyDateKMS = $dRdyDateKMS->format('d.m.Y');
                            }
                        $BGTestDateSoll = 'background-color:transparent;';
                        if ($s_budgetKMS != '') {
                            if (MasterPlanController::testRulesDate($kms->PPBoardSpalte_Id, $s_budgetKMS, $CRDDate, $projectStart)) {
                                $BGTestDateSoll = 'background-color:var(--color-rosa);';
                            } else {
                                $BGTestDateSoll = 'background-color:var(--color-hellgruen);';
                            }
                        }
                        if ($s_budgetKMS != $simDfMaster) {
                            $BGTestDateSoll = 'background-color:var(--color-abweichungMPlan);';
                        } 
                        if ($simDfMaster == '') {
                            $BGTestDateSoll = 'background-color:transparent';
                        } 
                        $BGTestDateIs = 'background-color:transparent;';
                         if (MasterPlanController::testRulesDate($kms->PPBoardSpalte_Id, $s_budgetKMS, $CRDDate, $projectStart)) {
                                $BGTestDateIs = 'background-color:var(--color-rosa);';
                            } else {
                                $BGTestDateIs = 'background-color:var(--color-hellgruen);';
                            }
                            $farbe['budget'] = 'lime' ;
                            $farbe['sim'] = 'blue';
                            $farbe['akt'] = 'red';
                            $farbe['aktCol'] = 'cyan';
                            $col1 = array();
                            try {
                                $col1['budget'] = MasterPlanController::getColor($violations[$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id], 'budget' );
                                $col1['sim'] = MasterPlanController::getColor($violations[$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id], 'sim' );
                                $col1['akt'] = MasterPlanController::getColor($violations[$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id], 'akt' );
                                $col1['aktCol'] = MasterPlanController::getColor($violations[$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id], 'aktCol');
                                $farbe['budget'] = $col1['budget']['color'] ;
                                $farbe['sim'] = $col1['sim']['color'];
                                $farbe['akt'] = $col1['akt']['color']; 
                                $farbe['aktCol'] = $col1['aktCol']['color']; 
                                $reason['budget'] = $col1['budget']['reason'] ;
                                $reason['sim'] = $col1['sim']['reason'] ;   
                                $reason['akt'] = $col1['akt']['reason'] ;
                                $reason['aktCol'] = $col1['aktCol']['reason'] ;
                                cpcDebug::cpc_debug("getColor in Blade KMS: " .json_encode($col1, JSON_PRETTY_PRINT), '-SimMplanFKE');
                            }
                            catch (Exception $e) {
                                    cpcDebug::cpc_debug("Exception in getColor: ", '-SimMplanFKE');
                                    cpcDebug::cpc_debug("Exception in getColor: " . $e->getMessage(), '-SimMplanFKE');
                                    cpcDebug::cpc_debug("Violations Array: " . json_encode($violations, JSON_PRETTY_PRINT), '-SimMplanFKE');
                                    $farbe['budget'] = '--color-ExceptionOrange' ;
                                    $farbe['sim'] = '--color-ExceptionMagenta';
                                    $farbe['akt'] = '--color-ExceptionTurquoise';
                                    $farbe['aktCol'] = '--color-ExceptionCyan';
                                    $reason['budget'] = 'ExceptionOKB';  
                                    $reason['sim'] = 'ExceptionOKSIM';
                                    $reason['akt'] = 'ExceptionOKAkt';
                                    $reason['aktCol'] = 'ExceptionOKCol';
                            }   
                            cpcDebug::cpc_debug("COL1: ".json_encode($col1,JSON_PRETTY_PRINT), '-SimMplanFKE');
                            cpcDebug::cpc_debug("FARBE: ".json_encode($farbe,JSON_PRETTY_PRINT), '-SimMplanFKE');
                    ?>
                       <div class="gridKMS" id="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" onclick="openSub('KMS_{{ $kms->PPBoardSpalteData_Gruppe }}');">
                    <div id="SubError_{{ $kms->PPBoardSpalteData_Gruppe .'_'.$kms->PPBoardSpalte_Id}}" style='width:20%;border-radius:0px;background-color:transparent;' >&nbsp;</div>
                        <div class="colorBar" style="display:none;">
                            <div id="KMSValid_{{ $kms->PPBoardSpalteData_Gruppe .'_'.$kms->PPBoardSpalte_Id}}"  class="colorPart" style="background-color: {{ $farbe['budget'] }}"></div>
                            <div class="colorPart" style="background-color: {{ $farbe['sim'] }}"></div>
                            <div class="colorPart" style="background-color: {{ $farbe['akt'] }}"></div>
                            <div class="colorPart" style="background-color: {{ $farbe['aktCol'] }}"></div>
                            </div>
                            <div class="arrowBox">
                    @if (isset($data['Milestones'][$kms->PPBoardSpalte_Id]))
                                    <span id="AOKMS_{{ $kms->PPBoardSpalteData_Gruppe }}">&#11166;</span>
                                    <span id="ACKMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style="display:none;">&#11167;</span>
                    @endif
                    </div>
                        </div>
                    <div class="gridKMS" style="align-items:center;padding:8px;" title="[CRD {{ $kms->PPBoardSpalte_Rot }}  Wochen] {{ $kms->PPBoardSpalte_Id }}">
                        <a id='hrefNoDeco'
                            href='/getTerminFromId/{{ $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id }}/{{ $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id }}/{{ $bid }}'
                            target='_blank'>{{ $kms->PPBoardSpalte_Bezeichnung }}</a>
                    </div>
                    <div class="gridKMS" style='padding:0px;' title='Start: {{ $projectStart }}  CRD: {{ $CRDDate }}'>
                        <input class="dateKMSOhne" readonly name="dateCRDKMS[{{ $kms->PPBoardSpalte_Id }}]" value='{{ $simDfBasisCRD }}' />
                    </div>
                    <div class="gridKMS kmsBudgetCell" style='padding:0px;'>
                        <div id="KMSSOLLValid_{{ $kms->PPBoardSpalteData_Gruppe.'_'.$kms->PPBoardSpalte_Id }}"  style="background-color: var({{ $farbe['budget'] }}); 
                            width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;" title="{{  $reason['budget'] }}"></div>
                        <input @if ($data['BudgetFix'] == 0) onchange="saveKmsDate(this, {{ $data['ppid'] }})" class="dateBudgetKMS" @else class="dateBudgetKMSRO" readonly @endif name='budget_KMS[{{ $kms->PPBoardSpalte_Id }}]'
                            id='budget_KMS[{{ $kms->PPBoardSpalte_Id }}]' value='{{ $s_budgetKMS }}' autocomplete="off" @if ($s_budgetKMS == '') data-defaultdate="{{ $simDfBasisCRD }}" @endif />
                             @if ($data['BudgetFix'] == 0)
                                <button type="button" class="btn-calcMS"
                                    onclick="calcMS({{ $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id }}, 'Budget', {{ $data['ppid'] }})">
                                recalc 
                            </button>
                            @endif
                        </div>
                    <div class="gridKMS" style='padding:0px;'><input class="dateKMSOhne" readonly value='{{ $sRdyDateKMS }}' style='width:100%;' /></div>
                    <div class="gridKMS kmsBudgetCell" style='padding:0px;background-color:var(--color-edit);'>
                        <div id="KMSISTValid_{{ $kms->PPBoardSpalteData_Gruppe.'_'.$kms->PPBoardSpalte_Id }}"  style="background-color: var({{ $farbe['sim'] }}); 
                            width:20%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;" title="{{  $reason['sim'] }}"></div>
                        <input class="dateKMS"
                            @if ($data['BudgetFix'] != 0) onchange="saveSollDate(this, {{ $data['ppid'] }})" @else class="dateKMSRO" readonly @endif id='KMSBGI_{{ $kms->PPBoardSpalte_Id }}' name="dateSimKMS[{{ $kms->PPBoardSpalte_Id }}]"
                            value='{{ $simDfMaster }}'style='background-color:var(--color-edit);height:100%;float:left; box-sizing:border-box; margin:0;' />
                            @if ($data['BudgetFix'] != 0)
                            <button type="button" class="btn-calcMS"
                                onclick="calcMS({{ $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id }}, 'Soll', {{ $data['ppid'] }})">
                                recalc
                            </button>
                            @endif
                        </div>
                    <div class="gridKMS" style='padding:0px;'>
                        <div id="KMSAKTValid_{{ $kms->PPBoardSpalteData_Gruppe.'_'.$kms->PPBoardSpalte_Id }}"  style="background-color: var({{ $farbe['akt'] }}); 
                        width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;" title="{{  $reason['akt'] }}"></div>
                        <input class="dateKMSOhne" readonly id='KMSBG_{{ $kms->PPBoardSpalte_Id }}' name="dateKMS[{{ $kms->PPBoardSpalte_Id }}]" style='color:var({{ $farbe['aktCol'] }});' value='{{ $df }}' />
                    </div>
                    {{-- Ab hier werden die Milestones aufgelistet, die zu diesem KMS gehören --}}
                    @if (isset($data['Milestones'][$kms->PPBoardSpalte_Id]))
                        @foreach ($data['Milestones'][$kms->PPBoardSpalte_Id] as $ms)
                            @if (strpos($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Status, 'nicht benötigt') === false )
                                    <?php
                                        $_crd = '';
                                        $s_budgetMS = '';
                                        if (substr($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_ManSollDate, 0, 4) != '0000') {
                                            $d_budgetMS = new DateTime($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_ManSollDate);
                                            $s_budgetMS = $d_budgetMS->format('d.m.Y');
                                        } else {
                                            // Berechne 1. Sim datum auf Basis CRD
                                        $s_budgetMS = MasterplanController::dadd($s_budgetKMS, $ms->PPBoardSpalteData_W2KMS);
                                        }
                                        $colorMPlan  = '';
                                        $colorSim2 = '';
                                        $BGSimDate = '';
                                        $sollDf = '';
                                        $color2 = '';
                                        $bg_budgetTest = 'background-color:var(--color-hellgruen);';
                                        if ( MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $s_budgetMS, $CRDDate, $projectStart)){
                                            $bg_budgetTest = 'background-color:var(--color-rosa);';
                                        }
                                        if (substr($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_SimDate, 0, 4) != '0000') {
                                            $d = new DateTime($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_SimDate);
                                            $sollDf = $d->format('d.m.Y');
                                            $isSimDate = false;
                                        } else {
                                            $sollDf = MasterplanController::dadd($simDfMaster, $ms->PPBoardSpalteData_W2KMS);
                                            $isSimDate = true;
                                        }
                                        $bg_SollTest = 'background-color:var(--color-hellgruen);';
                                    $title = '';
                                        if (!MasterplanController::testBudget($s_budgetMS, $sollDf)){
                                            $bg_SollTest = 'background-color:var(--color-abweichungMPlan);';
                                        }
                                        //if(!MasterplanController::testRulesDateCommenSoll($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id,$ms->PPBoardSpalte_Id,  $sollDf)){    
                                        if ( MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $sollDf, $CRDDate, $projectStart)){
                                        $title = 'Regel verletzt: Vor Projektstart oder nach CRD';
                                            $bg_SollTest = 'background-color:var(--color-rosa);';
                                        }
                                        if ($data['BudgetFix'] == 0){
                                            $sollDf ='';
                                            $bg_SollTest = 'background-color:var(--color-NoSimDate)';
                                            $isSimDate = false;
                                        }
                                        $df = '';
                                        if (substr($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 4) != '0000') {
                                            $d = new DateTime($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumStart);
                                            $df = $d->format('d.m.Y');
                                            //$sollDf = $df;
                                        }
                                        $bg_IstTest = 'background-color:var(--color-hellgruen);';
                                        if(MasterplanController::testBudget($s_budgetMS, $df) == false){
                                            $bg_IstTest = 'background-color:var(--color-abweichungMPlan);';
                                        }
                                        if ( MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $df, $CRDDate, $projectStart)){
                                                $bg_IstTest = 'background-color:var(--color-rosa);';
                                        }
                                        //if ($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_IsMPlan != 1){
                                    if (MasterplanController::testBudget($s_budgetMS, $sollDf) === false or MasterplanController::testBudget($s_budgetMS, $df) === false) {
                                            //$color2 = $colorMPlan;
                                            $markManEdit[] = $kms->PPBoardSpalteData_Gruppe;
                                        }
                                        if ( MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $sollDf, $CRDDate, $projectStart) or  MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $df, $CRDDate, $projectStart) ){
                                            $markManEdit[] = $kms->PPBoardSpalteData_Gruppe;
                                        }
                                        $sRdyDate = '';
                                    if (!is_null($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumEnde) and $data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumEnde != '0000-00-00 00:00:00') {
                                            $dRdyDate = new DateTime($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumEnde);
                                            $sRdyDate = $dRdyDate->format('d.m.Y');
                                        }
                                        $colorMS = 'color:gray;';
                                    if (isset($violations[$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id]['stats']['simAktDiff']) && $violations[$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id]['stats']['simAktDiff'] == 'diff') {
                                            $colorMS = 'color:var(--color-red);';
                                        }
                                    $bg_budgetTestDL_Lidl  =  $bg_budgetTest;
                                    if (MasterPlanController::testDateLidlDeadlines($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id , $ms->PPBoardSpalte_Id, $s_budgetMS) === false) {
                                        $title = 'Lidl Deadline Regel verletzt: ';
                                        $bg_budgetTestDL_Lidl  = 'background-color:var(--color-DeadlineFailLidl);';
                                    }
                                    if ($sollDf == '') {
                                        $bg_SollTest = 'background-color:transparent;';
                                    }
                                    if ($df == '') {
                                         $bg_IstTest = 'background-color:transparent;';
                                    }
                                    $farbe['budget'] = 'lime' ;
                                    $farbe['sim'] = 'blue';
                                    $farbe['akt'] = 'red';
                                    $farbe['aktCol'] = 'dotterblue';
                                    $reason ['budget'] = 'OK' ;
                                    $reason ['sim'] = 'OK';
                                    $reason ['akt'] = 'OK';
                                    $reason ['aktCol'] = 'OK';
                                    try {
                                        cpcDebug::cpc_debug("getColor in Blade MS: " . json_encode($data['Termine'][$ms->PPBoardSpalte_Id], JSON_PRETTY_PRINT), '-SimMplanFKE');
                                        $colMS1['budget'] = MasterPlanController::getColor($violations[$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id], 'budget');
                                        $colMS1['sim'] = MasterPlanController::getColor($violations[$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id], 'sim');
                                        $colMS1['akt'] = MasterPlanController::getColor($violations[$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id], 'akt');
                                        $colMS1['aktCol'] = MasterPlanController::getColor($violations[$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id], 'aktCol');
                                        foreach($colMS1 as $key => $value) {
                                            $farbe[$key] = $value['color'];
                                            $reason[$key] = $value['reason'];
                                        }
                                    }
                                    catch (Exception $e) {
                                            $farbe['budget'] = '--color-ExceptionOrange' ;
                                            $farbe['sim'] = '--color-ExceptionMagenta';
                                            $farbe['akt'] = '--color-ExceptionTurquoise';
                                            $farbe['aktCol'] = '--color-ExceptionCyan';  
                                            $reason ['budget'] = 'OK Exception';    
                                            $reason ['sim'] = 'OK Exception';
                                            $reason ['akt'] = 'OK Exception';
                                            $reason ['aktCol'] = 'OK Exception';
                                            cpcDebug::cpc_debug("Exception in getColor MS: ".$ms->PPBoardSpalte_Id, '-SimMplanFKE');
                                            cpcDebug::cpc_debug("Exception in getColor MS: " . $e->getMessage(), '-SimMplanFKE');
                                            cpcDebug::cpc_debug("Failed Array: " . json_encode($farbe, JSON_PRETTY_PRINT), '-SimMplanFKE');
                                            cpcDebug::cpc_debug("Failed Array: " . json_encode($reason, JSON_PRETTY_PRINT), '-SimMplanFKE');
                                    }
                                    ?>
                                    <div style="padding:0px;" class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='{{$colorMPlan}}'>
                                    <div class="colorBarRow" style="display:none;">
                                        <div style="background-color: {{ $farbe['budget'] }};" title="{{ $reason['budget'] }}">{{ $reason['budget'] }}</div>
                                        <div style="background-color: {{ $farbe['sim'] }};" title="{{ $reason['sim'] }}">{{ $reason['sim'] }}</div>
                                        <div style="background-color: {{ $farbe['akt'] }};" title="{{ $reason['akt'] }}">{{ $reason['akt'] }}</div>
                                        <div style="background-color: {{ $farbe['aktCol'] }};" title="{{ $reason['aktCol'] }}">{{ $reason['aktCol'] }}</div>
                                    </div>
                                    </div>
                                <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style="padding:0px;position:relative;">
                                    <div style="width:75%;float:left;padding:10px;" title="BSID: {{ $kms->PPBoardSpalte_Id }}">
                                        <a id='hrefNoDeco' href='/getTerminFromId/{{ $data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id }}/{{ $data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id }}/{{ $bid }}' target='_blank'>
                                        {{ $ms->PPBoardSpalte_Bezeichnung }}
                                        </a>
                                    </div>
                                    <div style="padding:10px;padding-right:0px;position:absolute:right:0px;width:15%;float:left;text-align:right;border-radius:0px;">[{{ $ms->PPBoardSpalteData_W2KMS }}]</div>
                                </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;'><!-- input class="dateMSRO" name="budget_MS[{{ $ms->PPBoardSpalte_Id }}]" value='{{ $s_budgetMS }}' style='{{  $colorSim2  }}' / --></div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;text-align:right;'>
                                    <div id='MSValid_{{ $kms->PPBoardSpalteData_Gruppe.'_'.$ms->PPBoardSpalte_Id }}' style="{{$bg_budgetTestDL_Lidl}} 
                                        width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;" title="{{$reason['budget']}}"></div>
                                    <input
                                        @if ($data['BudgetFix'] == 0) class="dateBudgetMS" @else class="dateBudgetMSRO" readonly @endif
                                        id="budget_MS[{{ $ms->PPBoardSpalte_Id }}]"
                                        name="budget_MS[{{ $ms->PPBoardSpalte_Id }}]" value="{{ $s_budgetMS }}"
                                        style='height:100%;float:left; width:90%; box-sizing:border-box; margin:0;text-align:right;' />
                                    </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;text-align:right;'>
                                    <div style="width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;"></div>
                                    <input readonly class="dateKMSOhne" value="{{ $sRdyDate }}"
                                        style='height:100%;float:left;  box-sizing:border-box; margin:0;' />
                                    </div>
                                <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='background-color:var(--color-edit);padding:0px;text-align:right;poition:relative;'>
                                    <div id="MSSOLLValid_{{ $kms->PPBoardSpalteData_Gruppe.'_'.$ms->PPBoardSpalte_Id }}" style="background-color:var({{ $farbe['sim'] }}); width:10%; height:100%; box-sizing:border-box; 
                                    float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;" title="{{$reason['sim']}}"></div>
                                    <input class="dateMS" name="dateSimMS[{{ $ms->PPBoardSpalte_Id }}]"
                                        id="dateSimMS[{{ $ms->PPBoardSpalte_Id }}]" value="{{ $sollDf }}"
                                        style="background-color:var(--color-edit); height:100%;float:left; width:90%; box-sizing:border-box; margin:0;" />
                                    </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;'>
                                    <div  id="MSISTValid_{{ $kms->PPBoardSpalteData_Gruppe.'_'.$ms->PPBoardSpalte_Id }}" style="background-color:var({{ $farbe['akt'] }}); width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;" title="{{$reason['akt']}} & {{$reason['aktCol']}}">
                                    </div>
                                    <input class="dateKMSOhne" readonly name="dateMS[{{ $ms->PPBoardSpalte_Id }}]"
                                        value='{{ $df }}'
                                        style='height:100%;float:left; width:90%; box-sizing:border-box; margin:0;color:var({{ $farbe['aktCol'] }}); background-color:white;' />
                                    </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            <div style='padding:0px;border:none;position:relative;border-radius:0px;text-align:left;'>
                <button class="mpSubmit" style='min-width:140px;' value='Download Soll' type='submit'
                    name='submit' title='Download der Excel-Tabelle "MP Plan" mit Soll Daten'>Download Soll</button>
                <button class="mpSubmit" style='' type='submit' value='Download Ist' name='submit'
                    title='Download der Excel-Tabelle "MP Plan" mit den IST-Daten'>Download Ist</button>
                <a href="{{url('/getMpForm/'.$data['ppid']) }}" class="mpSubmit"
                    style="display:inline-flex; align-items:center; justify-content:center; gap:6px; min-width:140px;"
                    title="Formular neu laden">
                    <img src="{{ asset('data/Icons/refresh_Transparent.png') }}" alt="refresh"
                        style="width:16px; height:16px;"> Neu laden {{ Auth::user()->PPMitarbeiter_Taetigkeit  }}</a>
                        <?php 
                            $canChange = ( ServiceProvider::AuthUserHasTaetigkeit('PM') || ServiceProvider::AuthUserHasTaetigkeit('PJM') || ServiceProvider::AuthUserIsAdmin() );
                        ?>
                    @if ($data['BudgetFix'] == 0)
                        @if ($canChange)
                        <button class="mpSubmit" style='' type='submit' value='Budget speichern'
                            onclick="setReset('budget');" name='submit'
                            title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'>Budget speichern</button>
                        <button id='ApplyBudget' class="mpSubmit" style='' type='submit' value='Budget übernehmen' onclick="setReset('budgetuebernehmen');" name='submit'title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'>Budget übernehmen</button>
                        @endif
                    @else 
                        @if ($canChange)
                            <!-- input class="mpSubmit" style='' type='submit'    value='Berechnung KMS' onclick="setReset('save');" name='submit' title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'  / -->
                        <button class="mpSubmit" style='width:400px;' type='submit' value='Soll speichern' name='submit'
                            title='Speichert alle Angepassten Termine'>Anpassungen speichern</button>
                        <button class="mpSubmit" style='position: absolute;right:175px;width:120px;' type='submit'
                            value='Übernehmen' name='submit'
                            title='Übernimmt die Daten aus der Simulation (Anpassung) in die Termine der Meilensteine'>
                            =></button>
                        <button class="mpSubmit" style='position: absolute;right:10px;width:120px;' type='submit'
                            value='Aktuelle Übernehmen' name='submit'
                            title='Aktuelle Daten in Termine Anpassunung übernehmen.'>
                            <= </button>
                        @endif
                @endif
                </div>
        </div>
    </div>
</form>
<script>
    var button = false;
    var btnart = '';
    $(".dateMS").datepicker({
        locale: 'de',
        numberOfMonths: 1,
        showButtonPanel: false,
        showWeek: true,
        firstDay: 1,
        dateFormat: "dd.mm.yy",
        monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September',
            'Oktober', 'November', 'Dezember'
        ],
        monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
    });
    $(".dateKMS").each(function () {
        const $el = $(this);
        const defStr = $el.data("defaultdate");       // z.B. "24.12.2025"
        const defDate = parseDEDate(defStr) || new Date();
        $el.datepicker({
            numberOfMonths: 1,
            showButtonPanel: false,
            showWeek: true,
            firstDay: 1,
            dateFormat: "dd.mm.yy",
            defaultDate: defDate,
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August',
                'September', 'Oktober', 'November', 'Dezember'
            ],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt',
                'Nov', 'Dez'
            ],
            dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
            dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        });
        // Input bleibt leer: defaultDate beeinflusst nur die Anzeige beim Öffnen
    });
  $(".dateBudgetMS").datepicker({
        locale: 'de',
        numberOfMonths: 1,
        showButtonPanel: false,
        showWeek: true,
        firstDay: 1,
        dateFormat: "dd.mm.yy",
        monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September',
            'Oktober', 'November', 'Dezember'
        ],
        monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
    });
    $(".dateBudgetKMS").each(function () {
        const $el = $(this);
        const defStr = $el.data("defaultdate");       // z.B. "24.12.2025"
        const defDate = parseDEDate(defStr) || new Date();
        $el.datepicker({
            numberOfMonths: 1,
            showButtonPanel: false,
            showWeek: true,
            firstDay: 1,
            dateFormat: "dd.mm.yy",
            defaultDate: defDate,
            monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August',
                'September', 'Oktober', 'November', 'Dezember'
            ],
            monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt',
                'Nov', 'Dez'
            ],
            dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
            dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
            dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
        });
        // Input bleibt leer: defaultDate beeinflusst nur die Anzeige beim Öffnen
    });
    function parseDEDate(str) {
        // erwartet "dd.mm.yyyy" oder "dd.mm.yy"
        const m = /^(\d{1,2})\.(\d{1,2})\.(\d{2}|\d{4})$/.exec(str || "");
        if (!m) return null;
        let d = parseInt(m[1], 10);
        let mo = parseInt(m[2], 10) - 1;
        let y = parseInt(m[3], 10);
        if (y < 100) y += 2000; // falls "yy" genutzt wird
        return new Date(y, mo, d);
    }
    function hideSub() {
        var elems = document.getElementsByClassName('gridRow');
        for (var i = 0; i < elems.length; i++) {
            //elems[i].style.display = '';
            elems[i].style.display = 'none';
            //console.log (i);
        }
    }
    function transShow(elem) {
        elem.style.transition = 'opacity .8s ease';
        elem.style.display = 'block';
        elem.style.opacity = 1;
    }
    function transHide(elem) {
        elem.style.transition = 'opacity .3s ease';
        elem.style.opacity = 0;
        setTimeout(() => {
            elem.style.display = 'none';
        }, 300);
    }
    function colorBlack() {
        for (var i = 0; i < 200; i++) {
            var vid = 'KMS_' + i;
            var elem = document.getElementById(vid);
            if (elem){
                elem.style.backgroundColor = 'var(--color-gray)';
            }
        }
    }
    function colorRed(id) {
        var elem = document.getElementById(id);
        elem.style.backgroundColor = 'var(--color-rosa)';
    }
    function switchArrow(id){
        var arrowC = document.getElementById('AO' + id);
        if (arrowC){
            if (arrowC.style.display == 'none'){
                arrowClose(id);
            } else {
                arrowOpen(id);
            }
        }
    }
    function arrowOpen (id){
        var arrowC = document.getElementById('AO' + id);
        if (arrowC){
            arrowC.style.display = 'none';
        }
        var arrowO = document.getElementById('AC' + id);
        if (arrowO){
            arrowO.style.display = 'inline';
        }
    }
    function arrowClose (id){
        var arrowC = document.getElementById('AO' + id);
        if (arrowC){
            arrowC.style.display = 'inline';
        }
        var arrowO = document.getElementById('AC' + id);
        if (arrowO){
            arrowO.style.display = 'none';
        }
    }
    function openSub(id) {
        colorBlack();
        //colorRed(id);
        switchArrow(id);
        var elems = document.getElementsByName(id);
        var other = false;
        if (elems.length == 0) {
            hideSub();
        }
        if (elems[0].style.display == 'none') { 
            hideSub();
            other = true;
        }
        for (var i = 0; i < elems.length; i++) {
            if (other) {
                //elems[i].style.display = 'inline';
                transShow(elems[i]);
            } else {
                if (elems[i].style.display == 'block') {
                    //elems[i].style.display = 'none';
                    transHide(elems[i]);
                } else {
                    //elems[i].style.display = 'inline';
                    transShow(elems[i]);
                }
            }
            //console.log (i);
            //console.log (elems[i].style);
        }
    }
    function setReset (part){
        console.log('Set Reset Art:', btnart);
        button = true;
        btnart = part;
    }
    function confirmX (){
        console.log('Confirm Art:', btnart);
        var msg = 'Wirklich alle Termine zurücksetzen?';
        if (btnart == 'save'){
            msg = 'Wirklich alle Soll-Termine speichern?';
        } 
        if (btnart == 'recalc'){
            msg = 'Wirklich alle Soll-Termine auf Basis KMS neu berechnen?';
        }
        if (btnart == 'budget'){
            msg = 'Wirklich alle Budget-Termine speichern?';
        }
        if (btnart == 'budgetuebernehmen'){
            msg = 'Wirklich alle Budget-Termine übernehmen?';
        }
        if (button){
            if (window.confirm(msg) ){
                return true;
            } 
            return false;
        }
        return true;
    }
    const overdue = {{ json_encode($overdue) }};
    var ids = Object.values(overdue);
    console.log(typeof ids, ids, Array.isArray(ids));
    function highlightOverdueElements() {
        ids.forEach(function(id) {
            var el = document.getElementById('KMSBGI_' + id);
            if (el) {
                el.style.backgroundColor = 'var(--color-rosa)';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', highlightOverdueElements);
    const markManEdit = {{ json_encode($markManEdit) }};
    var ids2 = Object.values(markManEdit);
    console.log(typeof ids2, ids2, Array.isArray(ids2));
    function highlightManEditElements() {
        console.log('Highlighting ManEdit Elements:', ids2);
        ids2.forEach(function(id) {
            var el = document.getElementById('ACKMS_' + id);
            if (el) {
                console.log('Highlighting element with ID:', 'ACKMS_' +id, el);
                el.style.color = 'red';
            } 
            var el = document.getElementById('AOKMS_' + id);
            if (el) {
                console.log('Highlighting element with ID:', 'AOKMS_' +id, el); 
                el.style.color = 'black';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', highlightManEditElements);
    function calcMS(kmsid, type, ppid) {
        console.log('calcMS aufgerufen mit KMSID:', kmsid, 'Type:', type, 'PPID:', ppid);
        var preId = 'budget_MS[';
        if (type != 'Budget'  ){
            preId = 'dateSimMS[';
        }
        console.log("PPID:", ppid, "KMSID:", kmsid);
        console.log("calcMS für ID:", kmsid);
        $.ajax({
            url: "/calcMS",          // <-- Route/URL anpassen
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            },
            data: {
                ppid: ppid,
                kmsid: kmsid,
                type: type
            },
            success: function (res) {
                // Erwartung: res = { ok:true, budget_date:"...", sim_date:"...", message:"..." } o.ä.
                if (res && res.ok) {
                    // Beispiel: Budget-Datum ggf. ersetzen
                    if (res.budget_date !== undefined) {
                        //$input.val(res.budget_date);
                    }
                    // Beispiel: Sim-Feld (KMSBGI_{id}) aktualisieren
                    if (res.sim_date !== undefined) {
                    //$("#KMSBGI_" + spalteId).val(res.sim_date);
                    }
                    console.log("calcMS OK:", res.data);
                    res.data.forEach(item => {
                        const el = document.getElementById(preId + item.BSID + ']');
                        if (el) {
                            el.value = item.Date;
                        }
                        });
                } else {
                    alert((res && res.message) ? res.message : "calcMS: keine gültige Antwort");
                }
            },
            error: function (xhr) {
                console.error("calcMS AJAX error", xhr.status, xhr.responseText);
                alert("calcMS fehlgeschlagen (" + xhr.status + "). Details in Console.");
            }
        });
    }
    function saveKmsDate(el, ppid) {
        console.log('saveKmsDate aufgerufen für Element:', el);
        return saveDate(el, 'budget_KMS', ppid);
    }
    function saveSollDate(el, ppid) {
        console.log('saveSollDate aufgerufen für Element:', el);
        return saveDate(el, 'dateSimKMS', ppid  );
    }
    async function saveDate(el, type, ppid) {
        const regex = new RegExp(`^${type}\\[(\\d+)\\]$`);
        let value = (el.value || "").trim();
        const defaultDate = el.dataset.defaultdate;
        if (!value && defaultDate) value = defaultDate;
        const m = (el.name || "").match(regex);
        const ppBoardSpalteId = m ? m[1] : null;
        if (!ppBoardSpalteId) {
            console.warn("Konnte PPBoardSpalte_Id nicht aus name lesen:", el.name);
            return;
        }
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        el.dataset.saving = "1";
        try {
            const res = await fetch("/kmssave", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                    ...(csrf ? {
                        "X-CSRF-TOKEN": csrf
                    } : {})
            },
            body: JSON.stringify({
                ppid: ppid,
                bsid: ppBoardSpalteId,
                value: value,
                type: type
            })
            });
            if (!res.ok) {
            const text = await res.text();
            throw new Error(`HTTP ${res.status}: ${text}`);
            }
            const data = await res.json();
            el.dataset.saved = "1";
            return data;
        } catch (err) {
            console.error("Speichern fehlgeschlagen:", err);
            el.dataset.saved = "0";
            throw err;
        } finally {
            delete el.dataset.saving;
        }
    }
    function checkAllKMSValid() {
        const allMsElements = document.querySelectorAll('[id^="MSValid_"]');
        const hellgruen = getComputedStyle(document.documentElement)
            .getPropertyValue('--color-hellgruen')
            .trim();
        // Gruppen sammeln
        const gruppenStatus = {};
        const hellgruenRGB = cssVarToRGB('--color-hellgruen');
        allMsElements.forEach(function (el) {
            const id = el.id; // z.B. MSValid_123_456
            const parts = id.split('_');
            if (parts.length < 3) return;
            const gruppe = parts[1];
            if (!(gruppe in gruppenStatus)) {
                gruppenStatus[gruppe] = false;
            }
            const bgColor = window.getComputedStyle(el).backgroundColor;
            if (
                bgColor !== 'transparent' &&
                bgColor !== 'rgba(0, 0, 0, 0)' &&
                bgColor !== hellgruenRGB
            ) {
                gruppenStatus[gruppe] = true;
            }
        });
        // KMS setzen
        Object.keys(gruppenStatus).forEach(function (gruppe) {
            const kmsElement = document.getElementById('KMSValid_' + gruppe);
            if (!kmsElement) return;
            kmsElement.style.backgroundColor = gruppenStatus[gruppe]
                ? 'red'
                : 'transparent';
            if(gruppenStatus[gruppe]){
                updateApplyButton(false);
            }
        });
    } 
    function checkAllKMSValidKMS() {
        const allMsElements = document.querySelectorAll('[id^="KMSValid_"]');
        const hellgruen = getComputedStyle(document.documentElement)
            .getPropertyValue('--color-hellgruen')
            .trim();
        // Gruppen sammeln
        const gruppenStatus = {};
        const hellgruenRGB = cssVarToRGB('--color-hellgruen');
        allMsElements.forEach(function (el) {
            const id = el.id; // z.B. MSValid_123_456
            const parts = id.split('_');
            if (parts.length < 3) return;
            const gruppe = parts[1];
            if (!(gruppe in gruppenStatus)) {
                gruppenStatus[gruppe] = false;
            }
            const bgColor = window.getComputedStyle(el).backgroundColor;
            if (
                bgColor !== 'transparent' &&
                bgColor !== 'rgba(0, 0, 0, 0)' &&
                bgColor !== hellgruenRGB
            ) {
                gruppenStatus[gruppe] = true;
            }
        });
        // KMS setzen
        Object.keys(gruppenStatus).forEach(function (gruppe) {
            const kmsElement = document.getElementById('KMSValid_' + gruppe);
            if (!kmsElement) return;
            kmsElement.style.backgroundColor = gruppenStatus[gruppe]
                ? 'red'
                : 'transparent';
            if(gruppenStatus[gruppe]){
                updateApplyButton(false);
            }
        });
    }
    function checkAllKMSValidSoll() {
        const allMsElements = document.querySelectorAll('[id^="MSSOLLValid_"]');
        const hellgruen = getComputedStyle(document.documentElement)
            .getPropertyValue('--color-hellgruen')
            .trim();
        // Gruppen sammeln
        const gruppenStatus = {};
        const hellgruenRGB = cssVarToRGB('--color-hellgruen');
        allMsElements.forEach(function (el) {
            const id = el.id; // z.B. MSValid_123_456
            const parts = id.split('_');
            if (parts.length < 3) return;
            const gruppe = parts[1];
            if (!(gruppe in gruppenStatus)) {
                gruppenStatus[gruppe] = false;
            }
            const bgColor = window.getComputedStyle(el).backgroundColor;
            if (
                bgColor !== 'transparent' &&
                bgColor !== 'rgba(0, 0, 0, 0)' &&
                bgColor !== hellgruenRGB
            ) {
                gruppenStatus[gruppe] = true;
            }
        });
        // KMS setzen
        Object.keys(gruppenStatus).forEach(function (gruppe) {
            const kmsElement = document.getElementById('KMSValid_' + gruppe);
            if (!kmsElement) return;
            kmsElement.style.backgroundColor = gruppenStatus[gruppe]
                ? 'dodgerblue'
                : 'transparent';
            if(gruppenStatus[gruppe]){
                updateApplyButton(false);
            }
        });
    }
    function cssVarToRGB(varName) {
        const value = getComputedStyle(document.documentElement)
            .getPropertyValue(varName)
            .trim();
        // temporäres Element zum Umrechnen
        const temp = document.createElement('div');
        temp.style.color = value;
        document.body.appendChild(temp);
        const rgb = getComputedStyle(temp).color;
        document.body.removeChild(temp);
        return rgb;
    }
    document.addEventListener('DOMContentLoaded', function () {updateApplyButton(true);   });
    //document.addEventListener('DOMContentLoaded', function () {checkAllKMSValid();    });
    //document.addEventListener('DOMContentLoaded', function () {checkAllKMSValidSoll();    });
    function updateApplyButton(isValid) {
        const btn = document.getElementById('ApplyBudget');
        //if (!btn) return;
        //btn.disabled = !isValid;
    }
 var globalInvalid = false;
    function checkGroupedValid(sourcePrefix, targetPrefix, targetColor) {
        const elements = document.querySelectorAll('[id^="' + sourcePrefix + '"]');
        const hellgruenRGB = cssVarToRGB('--color-hellgruen');
        const gruppenStatus = {};
        elements.forEach(el => {
            const parts = el.id.split('_');
            if (parts.length < 3) return;
            const gruppe = parts[1];
            if (!(gruppe in gruppenStatus)) {
                gruppenStatus[gruppe] = false;
            }
            const cell = el.closest('.gridRow, .gridKMS');
            const input = cell ? cell.querySelector('input') : null;
            if (input && input.value.trim() === '') {
                return;
            }
            const bgColor = window.getComputedStyle(el).backgroundColor;
            const isTransparent =
                bgColor === 'transparent' ||
                bgColor === 'rgba(0, 0, 0, 0)';
            const isHellgruen = bgColor === hellgruenRGB;
            if (!isTransparent && !isHellgruen) {
                gruppenStatus[gruppe] = true;
            }
        });
        Object.keys(gruppenStatus).forEach(gruppe => {
            const targets = document.querySelectorAll('[id^="' + targetPrefix + gruppe + '_"]');
            targets.forEach(targetEl => {
                targetEl.style.backgroundColor = gruppenStatus[gruppe]
                    ? targetColor
                    : 'transparent';
            });
            if (gruppenStatus[gruppe]) {
                globalInvalid = true;
            }
        });
    }
    function runAllChecks() {
        globalInvalid = false;
        const prefixes = [
            'MSValid_',
            'MSSOLLValid_',
            'MSISTValid_',
            'KMSValid_',
            'KMSSOLLValid_',
            'KMSISTValid_'
        ];
        const hellgruenRGB = cssVarToRGB('--color-hellgruen');
        const gruppenStatus = {};
        prefixes.forEach(prefix => {
            document.querySelectorAll('[id^="' + prefix + '"]').forEach(el => {
                const parts = el.id.split('_');
                if (parts.length < 3) return;
                const gruppe = parts[1];
                if (!(gruppe in gruppenStatus)) {
                    gruppenStatus[gruppe] = false;
                }
                const cell = el.closest('.gridRow, .gridKMS');
                const input = cell ? cell.querySelector('input') : null;
                // Ohne Input oder mit leerem Input: NICHT berücksichtigen
                if (!input || input.value.trim() === '') {
                    return;
                }
                const bgColor = window.getComputedStyle(el).backgroundColor;
                const isTransparent =
                    bgColor === 'transparent' ||
                    bgColor === 'rgba(0, 0, 0, 0)';
                const isHellgruen = bgColor === hellgruenRGB;
                if (!isTransparent && !isHellgruen) {
                    gruppenStatus[gruppe] = true;
                }
            });
        });
        Object.keys(gruppenStatus).forEach(gruppe => {
            const targets = document.querySelectorAll('[id^="SubError_' + gruppe + '_"]');
            targets.forEach(el => {
                el.style.backgroundColor = gruppenStatus[gruppe]
                    ? 'rgb(255, 199, 206)'
                    : 'transparent';
            });
            if (gruppenStatus[gruppe]) {
                globalInvalid = true;
            }
        });
        updateApplyButton(!globalInvalid);
    }
    document.addEventListener('DOMContentLoaded', runAllChecks);
    //Automatische öffnnen der fehler KMS
    var autoOpenGroups = {{ json_encode(array_values(array_unique($markManEdit))) }};
document.addEventListener('DOMContentLoaded', function () {
    autoOpenGroups.forEach(function(groupId) {
        const rows = document.getElementsByName('KMS_' + groupId);
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = 'block';
            rows[i].style.opacity = 1;
        }
        const elOpen = document.getElementById('AOKMS_' + groupId);
        const elClose = document.getElementById('ACKMS_' + groupId);
        if (elOpen) {
            elOpen.style.display = 'none';
            elOpen.style.color = 'black';
        }
        if (elClose) {
            elClose.style.display = 'inline';
            elClose.style.color = 'red';
        }
    });
});
</script>
