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
    }
    .gridContainer {
        display: grid;
        grid-template-columns: 5% 35% 12% 12% 12% 12% 12%;
        grid-template-rows: ;
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
        background-color: rgba(147, 219, 231, 255);
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
        position:absolute;
        bottom: 0px;
        left: 0px
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
        width: 20%;
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
        box-sizing: border-box;   /* verhindert Überlauf wegen padding/border */
    }
    .two-col {
        width:90%;
        border: 1px solid gray;
        border-radius: 0px;
        display: grid;
        grid-template-columns: 1fr 3fr;  /* links/rechts */
        gap: 0;
        align-items: left;               /* vertikal mittig */
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
        width: auto;      /* überschreibt width:100% */
        min-width: 0;     /* wichtig, damit es wirklich schrumpfen darf */
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
        border: none;              /* oder 1px solid dimgray, wenn du Linien willst */
        padding: 10px;
        min-height: 18px;          /* Höhe der Leerzeile */
        display: block;            /* wichtig, weil .gridRow bei dir display:none hat */
        opacity: 1;
    }
</style>
<?php  
    $h = $data['HeaderData'];  
    $qm = '';
    if ($data['SimNeu']){
        $qm = '?';
    };
    $CRDDate = $h['CRD Datum'];    
    $overdue = array();
    $markManEdit = array();
    $projectStartIndex = 0;
    $projectStartSpalteId = $data['KeyMilestones'][$projectStartIndex]->PPBoardSpalte_Id;
    $projectStart = $data['Termine'][$projectStartSpalteId]->PPTermine_SimDate; 
    if ($projectStart == '0000-00-00 00:00:00'){
        $projectStart = MasterPlanController::dadd($CRDDate, ($data['KeyMilestones'][$projectStartIndex]->PPBoardSpalte_Rot + 10) );
    } 
?>
<form action='/setKeyMilestones' method='POST' id='frmMP' onsubmit="return confirmX();">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div style="padding-top:50px;padding-left:100px;width:90%;height:90%;">
        <div id='left' style='position: relative;'>
            <div class='gridheader'>{{ $data['Header'] }}!</div>
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
                    <img src="{{ asset('/images/MPlan/MPlan_MS_SollNochNichtGespeichert.png') }}" alt="Solltermin noch nicht gespeichert">
                </div>
                <div class="col text">
                    Die Solltermine wurden noch nicht gespeichert
                </div> 
                <div class="col image" style="padding:5px;border:1px solid gray;border-radius:0px;padding-left:45px;">
                    <span style="color:red;font-weight:bold;font-size:14px;"> {{date('d.m.Y')}}<span>
                </div>      
                <div class="col text">
                    Datum weicht von Solltermin ab.
                </div>
                </div>
                <input  class='mpSubmitZuruecksetzen' type='submit'    value='Zurücksetzen' onclick="setReset('recalc');" name='submit' title='Setzt alle Termine der Meilensteine zurück auf 0 und berechnet die Soll Termine neu Aufgrund der Stammdaten' />
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
                    @foreach ($data['KeyMilestones'] as $kms)
                        <?php
                            // CRD Basiert KMS
                            $simDfBasisCRD = MasterPlanController::dadd($CRDDate, ($kms->PPBoardSpalte_Rot +  10) );
                            // Budget KMS
                            $s_budgetKMS = '';
                            if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_ManSollDate, 0, 4) != '0000') {
                                $d_budgetKMS = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_ManSollDate);
                                $s_budgetKMS = $d_budgetKMS->format('d.m.Y');
                            } else {
                                // Berechne 1. Sim datum auf Basis CRD
                                //$s_budgetKMS = $simDfBasisCRD;
                            }
                            // Soll KMS
                            $simDfMaster = '';
                            if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_SimDate, 0, 4) != '0000') {
                                $dmaster = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_SimDate);
                                $simDfMaster = $dmaster->format('d.m.Y');
                                $isSimDate = false;
                            } else {
                                // Berechne 1. Sim datum auf Basis CRD
                                $simDfMaster = MasterPlanController::dadd($CRDDate,  ($kms->PPBoardSpalte_Rot +  10) );
                                $isSimDate = true;
                            }
                            // StartDateum KMS
                            $df = '';
                            if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 4) != '0000') {
                                $d = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumStart);
                                $df = $d->format('d.m.Y');
                                //$simDfMaster = $df;
                            }
                            $BGTestDate = 'background-color:var(--color-lightPatrol)';
                            if ($isSimDate){
                                $BGTestDate = 'background-color:var(--color-NoSimDate)';
                            }
                            $color = 'color:black;';
                            if ($df != $simDfMaster) {
                                $color = 'color:var(--color-red);';
                            }
                            if ($data['BudgetFix'] == 0){
                                $simDfMaster ='';
                                $isSimDate = false;
                            }
                            if ($isSimDate){
                                $BGTestDate = 'background-color:var(--color-NoSimDate)';
                            }
                            $sRdyDateKMS = '';
                            if (!is_null($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumEnde) and ($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumEnde != '0000-00-00 00:00:00')){
                                $dRdyDateKMS = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumEnde);
                                $sRdyDateKMS = $dRdyDateKMS->format('d.m.Y');
                            }
                        ?>
                        <div class="gridKMS" id='KMS_{{ $kms->PPBoardSpalteData_Gruppe }}' style='text-align:center;'  onclick="openSub('KMS_{{ $kms->PPBoardSpalteData_Gruppe }}');">
                            @if (isset($data['Milestones'][$kms->PPBoardSpalte_Id]))
                                <span id='AOKMS_{{ $kms->PPBoardSpalteData_Gruppe }}'>&#11166;</span><span id='ACKMS_{{ $kms->PPBoardSpalteData_Gruppe }}' style='display:none;'>&#11167;</span>
                            @endif
                        </div>
                        <!-- div class="gridKMS">{{ $kms->PPBoardSpalte_Oberbez }}</div -->
                        <div class="gridKMS" title="[CRD {{$kms->PPBoardSpalte_Rot }}  Wochen] {{ $kms->PPBoardSpalte_Id }}">
                            <a id='hrefNoDeco' href='/getTerminFromId/{{$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id}}/{{$data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id}}/1000' target='_blank'>
                                {{ $kms->PPBoardSpalte_Bezeichnung }}
                            </a>
                        </div>
                        <div class="gridKMS" style='padding:0px;' title='Start: {{  $projectStart }}  CRD: {{ $CRDDate }}'><input class="dateKMS" readonly name="dateCRDKMS[{{ $kms->PPBoardSpalte_Id }}]" value='{{ $simDfBasisCRD }}' /></div>
                        <div   class="gridKMS kmsBudgetCell" style='padding:0px;'><input @if ($data['BudgetFix'] == 0)  onchange="saveKmsDate(this)" class="dateBudgetKMS" @else class="dateBudgetKMSRO" readonly @endif  name='budget_KMS[{{$kms->PPBoardSpalte_Id}}]' id='budget_KMS[{{$kms->PPBoardSpalte_Id}}]' value='{{ $s_budgetKMS }}' autocomplete="off" @if ($s_budgetKMS == '') data-defaultdate="{{ $simDfBasisCRD }}" @endif />
                             @if ($data['BudgetFix'] == 0)
                            <button
                                type="button"
                                class="btn-calcMS"
                                onclick="calcMS({{ $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id }} , 'Budget')">
                                recalc 
                            </button>
                            @endif
                        </div>
                        <div class="gridKMS" style='padding:0px;'><input class="dateKMS" readonly value='{{ $sRdyDateKMS }}' /></div>
                        <div class="gridKMS kmsBudgetCell" style='padding:0px;'>
                            <div style="{{ $BGTestDate}}; width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;"></div>
                            <input class="dateKMS" @if ($data['BudgetFix'] != 0)  onchange="saveSollDate(this)" @else class="dateKMSRO" readonly @endif  id='KMSBGI_{{$kms->PPBoardSpalte_Id}}' name="dateSimKMS[{{ $kms->PPBoardSpalte_Id }}]"  value='{{ $simDfMaster }}' style='background-color:var(--color-edit);height:100%;float:left; box-sizing:border-box; margin:0;'/>
                            @if ($data['BudgetFix'] != 0)
                            <button
                                type="button"
                                class="btn-calcMS"
                                onclick="calcMS({{ $data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_Id }}, 'Soll')">
                                recalc
                            </button>
                            @endif
                        </div>
                        <div class="gridKMS" style='padding:0px;'><input class="dateKMS" readonly  id='KMSBG_{{$kms->PPBoardSpalte_Id}}' name="dateKMS[{{ $kms->PPBoardSpalte_Id }}]" style='{{ $color }}' value='{{ $df }}' /></div>
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
                                            $s_budgetMS = MasterplanController::dadd($s_budgetKMS, $ms->PPBoardSpalteData_W2KMS);;
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
                                        if (!MasterplanController::testBudget($s_budgetMS, $sollDf)){
                                            $bg_SollTest = 'background-color:var(--color-abweichungMPlan);';
                                        }
                                        //if(!MasterplanController::testRulesDateCommenSoll($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id,$ms->PPBoardSpalte_Id,  $sollDf)){    
                                        if ( MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $sollDf, $CRDDate, $projectStart)){
                                            $bg_SollTest = 'background-color:var(--color-rosa);';
                                        }
                                        if ($data['BudgetFix'] == 0){
                                            $sollDf ='';
                                            $bg_SollTest = 'background-color:var(--color-NoSimDate)';
                                            $isSimDate = false;
                                        }
                                        $df = '';
                                        if (substr($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 4) != '0000') {
                                            // IST Termin
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
                                        if ( ( MasterplanController::testBudget($s_budgetMS, $sollDf) === false ) or ( MasterplanController::testBudget($s_budgetMS, $df) === false)){
                                            //$color2 = $colorMPlan;
                                            $markManEdit[] = $kms->PPBoardSpalteData_Gruppe;
                                        }
                                        if ( MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $sollDf, $CRDDate, $projectStart) or  MasterplanController::testRulesDate($ms->PPBoardSpalte_Id, $df, $CRDDate, $projectStart) ){
                                            $markManEdit[] = $kms->PPBoardSpalteData_Gruppe;
                                        }
                                        $sRdyDate = '';
                                        if (!is_null($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumEnde) and ( $data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumEnde != '0000-00-00 00:00:00')){
                                            $dRdyDate = new DateTime($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumEnde);
                                            $sRdyDate = $dRdyDate->format('d.m.Y');
                                        }
                                        $colorMS = 'color:gray;';
                                        if ($sollDf !== $df){
                                            $colorMS = 'color:var(--color-red);';
                                        }
                                    ?>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='{{$colorMPlan}}'></div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style="padding:0px;position:relative;">
                                        <div style="width:75%;float:left;padding:10px;" title="BSID: {{ $kms->PPBoardSpalte_Id }}">
                                            <a  id='hrefNoDeco' href='/getTerminFromId/{{$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id}}/{{$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id}}/1000' target='_blank'>
                                            {{ $ms->PPBoardSpalte_Bezeichnung }} 
                                            </a>
                                        </div>
                                        <div style="padding:10px;padding-right:0px;position:absolute:right:0px;width:15%;float:left;text-align:right;border-radius:0px;">[{{ $ms->PPBoardSpalteData_W2KMS }}]</div>
                                    </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;'><!-- input class="dateMSRO" name="budget_MS[{{ $ms->PPBoardSpalte_Id }}]" value='{{ $s_budgetMS }}' style='{{  $colorSim2  }}' / --></div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;text-align:right;'>
                                        <div style="{{ $bg_budgetTest }} width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;"></div>
                                        <input  @if ($data['BudgetFix'] == 0) class="dateBudgetMS" @else class="dateBudgetMSRO" readonly @endif    id="budget_MS[{{ $ms->PPBoardSpalte_Id }}]" name="budget_MS[{{ $ms->PPBoardSpalte_Id }}]" value="{{ $s_budgetMS }}" style='height:100%;float:left; width:90%; box-sizing:border-box; margin:0;'/>
                                    </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;text-align:right;'>
                                        <div style="{{ $bg_budgetTest }} width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;"></div>
                                        <input class="dateMSRO" readonly value="{{ $sRdyDate }}" style='height:100%;float:left; width:90%; box-sizing:border-box; margin:0;'/>
                                    </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;text-align:right;poition:relative;'>
                                        <div style="{{ $bg_SollTest }}; width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;"></div>
                                        <input class="dateMS" name="dateSimMS[{{ $ms->PPBoardSpalte_Id }}]" id="dateSimMS[{{ $ms->PPBoardSpalte_Id }}]" value="{{ $sollDf }}" style="background-color:var(--color-edit); height:100%;float:left; width:90%; box-sizing:border-box; margin:0;"/>
                                    </div>
                                    <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;'>
                                        <div style="{{ $bg_IstTest }} width:10%; height:100%; box-sizing:border-box; float:left; display:flex; align-items:center; justify-content:center;border-radius:0px;"></div>
                                        <input class="dateMSRO" readonly name="dateMS[{{ $ms->PPBoardSpalte_Id }}]" value='{{ $df }}' style='height:100%;float:left; width:90%; box-sizing:border-box; margin:0;{{ $colorMS}}' />
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <!-- div class="gridSpacerCell"></div>
                    <div class="gridSpacerCell"></div>
                    <div class="gridSpacerCell"></div>
                    <div class="gridSpacerCell"></div>
                    <div class="gridSpacerCell"></div>
                    <div class="gridSpacerCell"></div>
                    <div class="gridSpacerCell"></div -->
                </div>
                <div style='padding:0px;border:none;position:relative;border-radius:0px;text-align:left;'>
                    <button class="mpSubmit" style='min-width:140px;'  value='Download Soll' type='submit' name='submit' title='Download der Excel-Tabelle "MP Plan" mit Soll Daten'>Download Soll</button>
                    <button class="mpSubmit" style='' type='submit'    value='Download Ist' name='submit' title='Download der Excel-Tabelle "MP Plan" mit den IST-Daten'>Download Ist</button>
                    <a href="http://dev.ad.targa.de/getMpForm/{{ $data['ppid'] }}"   class="mpSubmit"   style="display:inline-flex; align-items:center; justify-content:center; gap:6px; min-width:140px;"   title="Formular neu laden">
                        <img src="{{ asset('data/Icons/refresh_Transparent.png') }}"         alt="refresh"         style="width:16px; height:16px;">    Neu laden</a>
                    @if ($data['BudgetFix'] == 0)
                        <button class="mpSubmit" style='' type='submit'    value='Budget speichern' onclick="setReset('budget');" name='submit' title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'>Budget speichern</button>
                        <button class="mpSubmit" style='' type='submit'    value='Budget übernehmen' onclick="setReset('budgetuebernehmen');" name='submit' title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'>Budget übernehmen</button>
                    @else 
                        <!-- input class="mpSubmit" style='' type='submit'    value='Berechnung KMS' onclick="setReset('save');" name='submit' title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'  / -->
                        <button class="mpSubmit" style='' type='submit'    value='Soll speichern' name='submit' title='Speichert alle Soll Termine'>Soll speichern</button>
                        <button class="mpSubmit" style='position: absolute;right:175px;width:120px;' type='submit'    value='Übernehmen' name='submit' title='Übernimmt die Daten aus der Simulation (Anpassung) in die Termine der Meilensteine'> =></button>
                        <button class="mpSubmit" style='position: absolute;right:10px;width:120px;' type='submit'    value='Aktuelle Übernehmen' name='submit' title='Aktuelle Daten in Termine Anpassunung übernehmen.'><= </button>
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
            monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
            monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
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
            monthNames: ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
            monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'],
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
        elem.style.transition = 'opacity .8s ease,display  0.5s ease allow-discrete';
        elem.style.display = 'inline';
        elem.style.opacity = 1;
    }
    function transHide(elem) {
        elem.style.opacity = 0;
        elem.style.display = 'none';
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
                if (elems[i].style.display == 'inline') {
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
                el.style.color = 'red';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', highlightManEditElements);
    function calcMS(kmsid, type) {
        var preId = 'budget_MS[';
        if (type != 'Budget'  ){
            preId = 'dateSimMS[';
        }
        const ppid = '{{$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id}}';
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
    function saveKmsDate(el) {
        console.log('saveKmsDate aufgerufen für Element:', el);
        return saveDate(el, 'budget_KMS');
    }
    function saveSollDate(el) {
        console.log('saveSollDate aufgerufen für Element:', el);
        return saveDate(el, 'dateSimKMS');
    }
    async function saveDate(el, type) {
        const regex = new RegExp(`^${type}\\[(\\d+)\\]$`);
        const ppid = '{{$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id}}';
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
                ...(csrf ? { "X-CSRF-TOKEN": csrf } : {})
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
</script>
