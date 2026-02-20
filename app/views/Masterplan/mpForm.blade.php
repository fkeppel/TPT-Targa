<style>
    .gridContainer {
        display: grid;
        grid-template-columns: 5% 40% 15% 15%;
        grid-template-rows: ;
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        text-align: left;
        margin: 0 auto;
        border-radius: 0px;
        border: 1px solid darkgray;
        overflow: auto;
        height: 90%;
        width: calc(100% -4px);
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
        background-color: rgba(147, 219, 231, 255);
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
    .mpSubmit {
        width:15%;
        height: 50px;
        margin-left:20px;
        margin-top:20px;
        margin-bottom:20px;        
        border: 1px solid darkblue;
        font-size: 0.9vw;
        font-weight: bolder;
        padding: 10px;
        position:relative;
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
        border: 1px solid red;
        overflow: scroll;
        height: 80vh;
    }
    #hrefNoDeco  {
        color:darkblue;
        text-decoration: none;
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
?>
<div style="padding-top:50px;padding-left:100px;width:90%;height:90%;">
    <div id='left'>
        <div class='gridheader'>{{ $data['Header'] }}</div>
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
    </div>
    <div id='right'>
        <form action='/setKeyMilestones' method='POST' id='frmMP' onsubmit="return confirmX();">
            <input type="hidden" name ='ppid' value='{{ $data['ppid'] }}'>
            <div class="gridContainer">
                <div class="gridHeader" style='text-align:center;'></div>
                <!-- div class="gridHeader">Klasse</div -->
                <div class="gridHeader">Milestone</div>
                <div class="gridHeader" style='text-align:right;'>Termine Soll</div>
                <div class="gridHeader" style='text-align:right;'>Termine Ist</div>
                @foreach ($data['KeyMilestones'] as $kms)
                    <?php
                    $df = '';
                    if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 4) != '0000') {
                        $d = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_DatumStart);
                        $df = $d->format('d.m.Y');
                    }
                    $simDfMaster = '';
                    if (substr($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_SimDate, 0, 4) != '0000') {
                        $dmaster = new DateTime($data['Termine'][$kms->PPBoardSpalte_Id]->PPTermine_SimDate);
                        $simDfMaster = $dmaster->format('d.m.Y');
                    }
                    $color = 'color:black;';
                    if ($df != $simDfMaster) {
                        $color = 'color:red;';
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
                    <div class="gridKMS" style='padding:0px;'><input class="dateKMS" name="dateSimKMS[{{ $kms->PPBoardSpalte_Id }}]" value='{{ $simDfMaster }}' /></div>
                    <div class="gridKMS" style='padding:0px;'><input class="dateKMS" disabled  id='KMSBG_{{$kms->PPBoardSpalte_Id}}' name="dateKMS[{{ $kms->PPBoardSpalte_Id }}]" style='{{ $color }}' value='{{ $df }}' /></div>
                    @if (isset($data['Milestones'][$kms->PPBoardSpalte_Id]))
                        @foreach ($data['Milestones'][$kms->PPBoardSpalte_Id] as $ms)
                            @if (strpos($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Status, 'nicht benötigt') === false )
                                <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}">&nbsp;</div>
                                <!-- div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}"></div -->
                                <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style="padding:0px;position:relative;">
                                    <div style="width:75%;float:left;padding:10px;" title="BSID: {{ $kms->PPBoardSpalte_Id }}">
                                        <a  id='hrefNoDeco' href='/getTerminFromId/{{$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_PPProduktpass_Id}}/{{$data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_Id}}/1000' target='_blank'>
                                        {{ $ms->PPBoardSpalte_Bezeichnung }}
                                        </a>
                                    </div>
                                    <div style="padding:10px;padding-right:0px;position:absolute:right:0px;width:15%;float:left;text-align:right;border-radius:0px;">[{{ $ms->PPBoardSpalteData_W2KMS }}]</div>
                                </div>
                                <?php
                                    $df = '';
                                    if (substr($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumStart, 0, 4) != '0000') {
                                        $d = new DateTime($data['Termine'][$ms->PPBoardSpalte_Id]->PPTermine_DatumStart);
                                        $df = $d->format('d.m.Y');
                                    }
                                    $simDf = MasterplanController::dadd($simDfMaster, $ms->PPBoardSpalteData_W2KMS);
                                    $color2 = 'color:dimgray;';
                                    if ($df != $simDf) {
                                        $color2 = 'color:red;';
                                    }
                                    $colAfterCRD = MasterplanController::testDate2CRD($simDf, $CRDDate);
                                    if ($colAfterCRD != '') {
                                        $colAfterCRD = MasterplanController::testDate2CRD($df, $CRDDate);
                                    }
                                    if ($colAfterCRD != 'background-color:transparent;') {
                                       $overdue[$kms->PPBoardSpalte_Id] = $kms->PPBoardSpalte_Id;
                                    }
                                ?>
                                <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;'><input class="dateMS" name="dateSimMS[{{ $ms->PPBoardSpalte_Id }}]" value='{{ $simDf }}' /></div>
                                <div class="gridRow" name="KMS_{{ $kms->PPBoardSpalteData_Gruppe }}" style='padding:0px;'><input class="dateMS" disabled name="dateMS[{{ $ms->PPBoardSpalte_Id }}]" value='{{ $df }}' style='{{$colAfterCRD}} {{ $color2 }}' /></div>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
            <div style='padding:0px;border:none;position:relative;border-radius:0px;text-align:left;'>
                <input class="mpSubmit" style='min-width:200px;'  value='Download Soll' type='submit' name='submit' title='Download sder Excel-Tabelle "MP Plan" mit simulierten Daten'  />
                <input class="mpSubmit" style='' type='submit'    value='Download Ist' name='submit' title='Download sder Excel-Tabelle "MP Plan" mit den IST-Daten'  />
                <input class="mpSubmit" style='' type='submit'    value='Zurücksetzen' onclick='setReset();' name='submit' title='Setzt alle Termine der Meilensteine zurück auf 0 und berechnet die Soll Termine neu Aufgrund der Stammdaten' />
                <input class="mpSubmit" style='' type='submit'    value='Simulieren' name='submit' title='Berechnet die Termine der abhängigen Meielnsteine neu (Soll-Spalte)'  />
                <input class="mpSubmit" style='margin-left:5%;' type='submit'    value='Übernehmen' name='submit' title='Übernimmt die Daten aus der Simulation (SOLL) in die Termine der Meilensteine'  />
            </div>
        </form>
    </div>
</div>
<script>
    var button = false;
    $(".dateKMS").datepicker({
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
                elem.style.backgroundColor = 'rgba(147,219,231,255)';
            }
        }
    }
    function colorRed(id) {
        var elem = document.getElementById(id);
        elem.style.backgroundColor = 'rgba(147,219,231,15)';
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
        colorRed(id);
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
    function setReset (){
        button = true;
    }
    function confirmX (){
        if (button){
            if (window.confirm('Wirklich alle Termine zurücksetzen?') ){
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
            var el = document.getElementById('KMSBG_' + id);
            if (el) {
                //console.log('Highlighting element with ID:', 'KMSBG_' +id, el);
                el.style.backgroundColor = 'red';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', highlightOverdueElements);
</script>
