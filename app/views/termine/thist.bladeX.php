<table class="terminHist" style="border-collapse:collapse;font-size:12px;font-family:tahoma;">
    <tr>
        <td  class="thHeader2" style="min-width:60px; border:none;" colspan="4">

            <?php
            $sSelect = 'Hauptaufgabe';
            if ($select == 'Hauptaufgabe') {
                $sSelect = 'All';
            }

            $sSelect2 = 'Zwischenstatus';
            if ($select == 'Zwischenstatus') {
                $sSelect2 = 'All';
            }
            ?>
            <div style="float:left; width:15px;height:15px;background-color:darkblue;padding:3px;"><input type="checkbox" style="margin:0px;width:15px; height:15px;" @if($select == 'Hauptaufgabe') checked @endif   onclick="ajax_getTerminTab({{$pp['id']}}, {{$t['id']}}, {{$board}}, '{{$sSelect}}', {{ $onlyOpen }})"/></div>
            <div style="margin-left: 8px;float:left; width:15px;height:15px;background-color:#383018;padding:3px;"><input type="checkbox" style="margin:0px;width:15px; height:15px; " @if($select == 'Zwischenstatus') checked @endif onclick="ajax_getTerminTab({{$pp['id']}}, {{$t['id']}}, {{$board}}, '{{$sSelect2}}', {{ $onlyOpen }})"/></div>
        </td>
        <!-- td class="thHeader2" style="width:5px; border:none;"></td>
        <td class="thHeader2" style="width:5px; border:none;"></td>
        <td class="thHeader2" style="width:5px; border:none;"></td-->

        <td class="thHeader2" style="width:40px;">Zuständig</td>

        <!-- td class="thHeader" style="width:40px;">Receiver</td -->

        <td class="thHeader2" style="width:150px;">Status</td>
        <td class="thHeader2" style="width:120px;">Datum</td>
        <td  class="thHeader2" style="width:100px;">Kategorie</td>
        <td class="thHeader2" style="width:120px;">erledigen bis</td>
        <td class="thHeader2" style="width:40px;">Ma</td>
        <td class="thHeader2" style="width:120px;">erledigt am</td>
        <td class="thHeader2" style="width:550px;">Bemerkung</td>
        <td class="thHeader2" style="width:100px;">Download</td>
        <td class="thHeader2" style="width:140px;">
            <?php
            $bOnlyOpen = 1;
            if ($onlyOpen) {
                $bOnlyOpen = 0;
            }
            ?>
            <div style="float:left;">Aktionen</div> <div style="margin-left: 8px;float:left; width:15px;height:15px;background-color:lime;padding:3px;"><input type="checkbox" style="margin:0px;width:15px; height:15px; " @if($onlyOpen) checked @endif onclick="ajax_getTerminTab({{$pp['id']}}, {{$t['id']}}, {{$board}}, '{{ $select }}', {{$bOnlyOpen}});"/></div></td>
    </tr>


    @foreach($t['log']['sort'] as $logBuch)

    <?php
    $bg[0] = 'white';
    $bg[1] = 'white';
    $bg[2] = 'white';
    $bg[3] = 'white';
    $bg[4] = 'white';
    $bg[5] = 'white';

    /* $bgLevel[1] = '#857039';
      $bgLevel[2] = '#B89C50';
      $bgLevel[3] = '#C3B58F';
      $bgLevel[0] = '#383018';
      $bgLevel[4] = 'black';
      $bgLevel[5] = 'lime'; */

    $bgLevel[0] = '#663300';
    $bgLevel[1] = '#996600';
    $bgLevel[2] = '#cc9900';
    $bgLevel[3] = '#ffcc33';
    $bgLevel[4] = 'black';
    $bgLevel[5] = 'lime';

    $log        = $t['log']['log'][$logBuch['Knoten']];
    $statusInfo = "Zwischenstatus";

    if (trim($log->PPTermineChanges_Categorie) == "") {
        //Bedeutet => Hauptaufgabe
        $bgLevel[0] = '#061D75';
        $bgLevel[1] = '#092ECC';
        $bgLevel[2] = '#5878FF';
        $bgLevel[3] = '#98A8FF';
        $bgLevel[4] = 'black';
        $bgLevel[5] = 'lime';
        $statusInfo = "Hauptaufgabe";
    }

    for ($i = $logBuch['Ebene']; $i <= 5; $i++) {
        $bg[$i] = $bgLevel[$logBuch['Ebene']];
    }
    ?>

    @if ((!$onlyOpen and strlen($log->PPTermineChanges_DoneAt) < 10) or ($onlyOpen))
    @if ($select == "All" or $select == $statusInfo )
    <tr class="thRow" style="border:1px solid white;">
        <td class="thCell" style="width:3px;background-color:{{$bg[0]}};border-radius:0px;  border:1px solid {{$bg[0]}}; border-bottom:1px solid #FFF;"></td>
        <td class="thCell" style="width:3px;background-color:{{$bg[1]}};border-radius:0px;  border:1px solid {{$bg[1]}}; border-bottom:1px solid #FFF;"></td>
        <td class="thCell" style="width:3px;background-color:{{$bg[2]}};border-radius:0px;  border:1px solid {{$bg[2]}}; border-bottom:1px solid #FFF;"></td>
        <td class="thCell" style="width:3px;background-color:{{$bg[3]}};border-radius:0px;  border:1px solid {{$bg[3]}}; border-bottom:1px solid #FFF;"></td>

        <td  class="thCell" >
            @if (isset($mitarbeiterliste[$log->PPTermineChanges_Receiver])){{$mitarbeiterliste[$log->PPTermineChanges_Receiver]}}@endif
        </td>
        <td class="thCell" >@if($log->PPTermineChanges_oldStatus != $log->PPTermineChanges_newStatus){{$log->PPTermineChanges_oldStatus}} => {{$log->PPTermineChanges_newStatus}} @else {{ $statusInfo }} @endif</td>
        <td class="thCell" >{{\Carbon\Carbon::parse($log->PPTermineChanges_Date)->format('d.m.Y')}}</td>
        <td class="thCell">{{$log->PPTermineChanges_Categorie}}</td>
        <td class="thCell">{{\Carbon\Carbon::parse($log->PPTermineChanges_DoUntil)->format('d.m.Y')}}</td>
        <td  class="thCell" >@if (isset($log->PPTermineChanges_Mitarbeiter_Id)){{$mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id]}} @endif</td>
        <td class="thCell"'>@if (!is_null($log->PPTermineChanges_DoneAt)){{\Carbon\Carbon::parse($log->PPTermineChanges_DoneAt)->format('d.m.Y')}}@endif</td>
        <td class="thCell">{{$log->PPTermineChanges_Remark}} </td>
        <td class="thCell" style="text-align:center;padding:0px;">@if(strlen($log->URL) > 0)<a href="{{$log->URL}}" target="_blank"><img src="/data/Icons/download.png" style="height:30px;"/></a>@endif</td>
        <td class="thCell" @if(strlen($log->PPTermineChanges_DoneAt) >= 10) style="background-color:lime;" @endif> @if(strlen($log->PPTermineChanges_DoneAt) < 10)
            @if($log->PPTermineChanges_oldStatus == $log->PPTermineChanges_newStatus)<button id="btnErledig{{$t['id']}}" onclick="setErledigt({{$t['id']}},{{$log->PPTermineChanges_Id}});"><img src="/data/Icons/fertig.png" style="height:20px;"></button>@endif
            <button id="btnAnswer{{$t['id']}}" onclick="showAnswer({{$log->PPTermineChanges_Id}});" ><img src="/data/Icons/antworten.png" style="height:20px;"></button>
            @if($log->PPTermineChanges_oldStatus == $log->PPTermineChanges_newStatus)
            <button id="btnDelete{{$t['id']}}" onclick="xDelete({{$log->PPTermineChanges_Id}});" ><img src="/data/Icons/loeschen.png" style="height:20px;"></button>
            @endif
            @endif

        </td>
    </tr>
    <tr style="height:0px;" >
        <td colspan="14"  style="height:0px;">
            <div class="answer" id="Answer{{$log->PPTermineChanges_Id}}" style="display:none;height:85px;width:100%;padding-left:485px;border:1px solid grey; ">
                <!---------------- START ----------------->

                <input type="hidden" id="xStatChange_TermineId_{{$log->PPTermineChanges_Id}}" value = "{{$t['id']}}" />
                <input type="hidden" id="xStatChange_Categorie_{{$log->PPTermineChanges_Id}}" value = "{{$log->PPTermineChanges_Categorie}}" />
                <input type="hidden" id="xStatChange_PPId_{{$log->PPTermineChanges_Id}}" value = "{{$pp['id']}}" />
                <input type="hidden" id="xStatChange_StatusAlt_{{$log->PPTermineChanges_Id}}" value="{{$t['status']}}" />
                <input type="hidden" id="xStatChange_Id_{{$log->PPTermineChanges_Id}}" value="{{$log->PPTermineChanges_Id}}" />
                <div class="thCellNew" style="width:100px;">
                    <div style="border:1px solid darkblue;padding:4px;">zuständig</div>
                    <div style="padding:4px;">
                        <select id="xStatChange_Receiver_{{$log->PPTermineChanges_Id}}" style="width:100px;padding: 5px;">
                            @foreach ($mitarbeiterliste as $mid => $ma)
                            <option value="{{$mid}}">{{$ma}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="thCellNew" style="width: 90px;">
                    <div style="border:1px solid darkblue;padding:4px;">erledigen bis</div>
                    <div style="padding:4px;">
                        <input style="width:100px;padding: 5px;" id="xStatChange_DoUntil_{{$log->PPTermineChanges_Id}}" class="datepicker" value="{{\Carbon\Carbon::parse($log->PPTermineChanges_DoneAt)->addDays(7)->format('d.m.Y')}}"/>

                    </div>
                </div>

                <div class="thCellNew">
                    <div style="border:1px solid darkblue;padding:4px;">Bemerkung</div>
                    <div style="padding:4px;">
                        <input type="text" style="width:380px;padding: 5px;" id="xStatChange_Remark_{{$log->PPTermineChanges_Id}}" placeholder="Bemerkung" />
                    </div>
                </div>
                <div class="thCellNew">
                    <div id="retMes{{$log->PPTermineChanges_Id}}" style="float:left;width:150px;height:50px;border:1px solid red;display:none;">

                    </div>

                    <div class="xdropC" id="xdropContainer_{{$log->PPTermineChanges_Id}}" style="border-radius: 0px;border:none;height:50px; width:150px;padding:0px;vertical-align:central; text-align:center;">
                        <div style="border:1px solid darkblue;padding:4px;">Upload</div>
                        <div style="padding:4px;border:none;">
                            <img src="/data/Icons/upload.png" style="width:80px;" />

                        </div>
                    </div>

                    <input type="file" id="xxFile{{$log->PPTermineChanges_Id}}" style="display: none;" />
                </div>
                <div class="thCellNew">
                    <div style="border:1px solid darkblue;padding:4px;">store</div>
                    <div style="padding:0px;border:none;">
                        <button id="button{{$log->PPTermineChanges_Id}}" style="width:80px;height:60px;font-weight: bold;color:darkblue;"  onclick="answer({{$log->PPTermineChanges_Id}});" >
                            <img src="/data/Icons/speichern.png" style="width:40px;"/>
                        </button>
                    </div>

                </div>
                <div class="thCellNew" style="padding-left: 5px;">
                    <button id="btn_answer{{$log->PPTermineChanges_Id}}" onclick="hideAnswer({{$log->PPTermineChanges_Id}});" style="display:none;"><img src="/data/Icons/schliessen.png" style="width:12px;"/></button>
                </div>
            </div>

        </td>
    </tr>
    @endif
    @endif
    @endforeach
</table>

