<style>
     .trDelete {
        display: none!important;
    }
</style>
<table class="terminHist" style="border-collapse:collapse;font-size:12px;font-family:tahoma;">
    <tr>
        <td  class="thHeader2" style="min-width:60px; border:none;" colspan="4">
            <?php
            $sSelect = 'Hauptaufgabe';
            if ($select == 'Hauptaufgabe') {
                $sSelect = 'All';
            }
            $sSelect2 = 'Unteraufgabe';
            if ($select == 'Unteraufgabe') {
                $sSelect2 = 'All';
            }
            ?>
        </td>
        <td class="thHeader2" style="width:40px;">{{ ServiceProvider::tl($lang, 'Zuständig') }}</td>
        <td class="thHeader2" style="width:150px;">{{ ServiceProvider::tl($lang, 'Status') }}</td>
        <td class="thHeader2" style="width:70px;">{{ ServiceProvider::tl($lang, 'Datum') }}</td>
        <td class="thHeader2" style="width:250px;">{{ ServiceProvider::tl($lang, 'ToDo') }}</td>
        <td class="thHeader2" style="width:120px;">{{ ServiceProvider::tl($lang, 'erledigen bis') }}</td>
        <td class="thHeader2" style="width:40px;">{{ ServiceProvider::tl($lang, 'Ersteller') }}</td>
        <td class="thHeader2" style="width:120px;">{{ ServiceProvider::tl($lang, 'erledigt am') }}</td>
        <td class="thHeader2" style="width:400px;">{{ ServiceProvider::tl($lang, 'Bemerkungen') }}</td>
        <td class="thHeader2" style="width:100px;">Download</td>
        <td class="thHeader2" style="width:165px;">
            <?php
            $bOnlyOpen = 1;
            if ($onlyOpen) {
                $bOnlyOpen = 0;
            }
            ?>
            <div style="height:35px;padding:5px;border: none;width:90%;">
                <div style="padding-bottom:5px;">{{ ServiceProvider::tl($lang, 'Fertige anzeigen')}}</div>
                <div style="float:left;"><input type="checkbox" style="margin:0px;width:20px; height:20px;border:2px solid lime; " @if($onlyOpen) checked @endif onclick="ajax_getTerminTab({{$pp['id']}}, {{$t['id']}}, {{$board}}, '{{ $select }}', {{$bOnlyOpen}});"/></div>
                <div style="float:left;padding-left: 20px;;"><button type="button" onclick="showDeleted();">Restore</button></div>
            </div>
        </td>
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
                $statusInfo = "Unteraufgabe";
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
                $class = $log->PPTermineChanges_IsActive==0?'trDelete':'';
                $write = false;
                $wx  = 'LogedIn: '.Auth::User()->id.' PM: '.  $ppall->PPProduktpass_PMAdmin.' PM VTR: '.  $ppall->PPProduktpass_PMAdminVTR.' TC: '.  $ppall->PPProduktpass_TCAdmin.' TC VTR: '.  $ppall->PPProduktpass_TCAdminVTR;
                if (Auth::User()->PPMitarbeiter_Gruppe == 'admin'){
                    $write = true;
                    $wx = 'wg. Admin';
                }
                $RemarkDisabled ='DISABLED';
                if (Auth::User()->id == $log->PPTermineChanges_Mitarbeiter_Id){
                    $write = true; 
                    $wx = 'wg. Self';
                    $RemarkDisabled ='';
                }
                $RemarkRecDisabled ='DISABLED';
                if (Auth::User()->id == $log->PPTermineChanges_Receiver){
                    $write = true; 
                    $wx = 'wg. Empfänger';
                    $RemarkRecDisabled ='';
                }
                if ($log->PPTermineChanges_Receiver == $ppall->PPProduktpass_PMAdmin and Auth::User()->id == $ppall->PPProduktpass_PMAdminVTR ){
                    $wx = 'wg. PM VTR';
                    $write = true;
                }
                if ($log->PPTermineChanges_Receiver == $ppall->PPProduktpass_TCAdmin and Auth::User()->id == $ppall->PPProduktpass_TCAdminVTR ){
                    $wx = 'wg. TC VTR';
                    $write = true;
                }
                $wx = '';
                if($lang == 'DE'){
                    $transLang = 'EN';
                    $orgLang = '';
                } else {
                    $transLang = '';
                    $orgLang = 'EN';  
                }
                $att_PPTermineChanges_Remark = 'PPTermineChanges_Remark'.$orgLang; 
                $att_PPTermineChanges_RemarkReceiver = 'PPTermineChanges_RemarkReceiver'.$orgLang; 
                $att_PPTermineChanges_Categorie = 'PPTermineChanges_Categorie'.$orgLang; 
                $att_PPTermineChanges_RemarkTranslate = 'PPTermineChanges_Remark'.$transLang; 
                $att_PPTermineChanges_RemarkReceiverTranslate = 'PPTermineChanges_RemarkReceiver'.$transLang; 
                $att_PPTermineChanges_CategorieTranslate = 'PPTermineChanges_Categorie'.$transLang; 
        ?>
        @if ((!$onlyOpen and strlen($log->PPTermineChanges_DoneAt) < 10) or ($onlyOpen))
            @if ($select == "All" or $select == $statusInfo )
                <tr class="thRow {{$class}}" name="{{$class}}" >
                    <td class="thCell" style="width:3px;background-color:{{$bg[0]}};border-radius:0px;  border:1px solid {{$bg[0]}}; border-bottom:1px solid #FFF;"></td>
                    <td class="thCell" style="width:3px;background-color:{{$bg[1]}};border-radius:0px;  border:1px solid {{$bg[1]}}; border-bottom:1px solid #FFF;"></td>
                    <td class="thCell" style="width:3px;background-color:{{$bg[2]}};border-radius:0px;  border:1px solid {{$bg[2]}}; border-bottom:1px solid #FFF;"></td>
                    <td class="thCell" style="width:3px;background-color:{{$bg[3]}};border-radius:0px;  border:1px solid {{$bg[3]}}; border-bottom:1px solid #FFF;"></td>
                    <td  class="thCell" >
                        <select name="StatChange_NewReceiver_{{$log->PPTermineChanges_Id}}" id="StatChange_NewReceiver_{{$log->PPTermineChanges_Id}}">
                            @foreach($mitarbeiterliste as $maid => $ma)
                            @if (isset($mitarbeiterNamen[$maid]) and isset($mitarbeiterliste[$log->PPTermineChanges_Receiver]))
                            <option   title='{{ isset($mitarbeiterNamen[$maid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$maid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$maid]->PPMitarbeiter_Vorname:"NNN";  }}'  @if($mitarbeiterliste[$log->PPTermineChanges_Receiver] == $ma) selected @endif value="{{$maid}}">{{$ma}}</option>
                            @else
                            <option selected >{{ ServiceProvider::tl($lang, 'gelöscht')}}</option> 
                            @endif
                            @endforeach
                        </select>
                    </td>
                    <td class="thCell" >
                        @if($log->PPTermineChanges_oldStatus != $log->PPTermineChanges_newStatus){{$log->PPTermineChanges_oldStatus}} => {{$log->PPTermineChanges_newStatus}} 
                        @else  
                            @if ( $statusInfo != 'Unteraufgabe') 
                                @if ($log->PPTermineChanges_DoUntil != $log->PPTermineChanges_DoUntilOld)
                                {{ substr($log->PPTermineChanges_DoUntilOld,0,10) }} => {{ substr($log->PPTermineChanges_DoUntil,0,10) }}
                                @endif
                                @if ($log->PPTermineChanges_Receiver != $log->PPTermineChanges_Mitarbeiter_Id) {{$mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id]}} => {{$mitarbeiterliste[$log->PPTermineChanges_Receiver]}} 
                                @else   {{ ServiceProvider::tl($lang, $statusInfo) }} 
                                @endif 
                            @else  {{ ServiceProvider::tl($lang, $statusInfo ) }} 
                            @endif 
                        @endif</td>
                    <td class="thCell" >{{\Carbon\Carbon::parse($log->PPTermineChanges_Date)->format('d.m.Y')}}</td>
                    <td class="thCell" title="{{ $log->{$att_PPTermineChanges_CategorieTranslate} }}" >{{ $log->{$att_PPTermineChanges_Categorie} }}</td>
                    <td class="thCell"><input name="StatChange_DoUntil_{{$log->PPTermineChanges_Id}}"  class="datepickerZukunft" id="StatChange_DoUntil_{{$log->PPTermineChanges_Id}}" value="{{\Carbon\Carbon::parse($log->PPTermineChanges_DoUntil)->format('d.m.Y')}}" /></td>
                    <td  class="thCell" >
                        @if (isset($mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id])){{$mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id]}} @else {{ ServiceProvider::tl($lang, 'gelöscht')}} @endif
                    </td>
                    <td class="thCell"'>@if (!is_null($log->PPTermineChanges_DoneAt)){{\Carbon\Carbon::parse($log->PPTermineChanges_DoneAt)->format('d.m.Y')}}@endif</td>
                    <td class="thCell" style="padding:0px;">
                        <div style='background-color:#c0c0c0;padding:4px;color:#003D7C;border: 1px solid #003D7C;'>{{ ServiceProvider::tl($lang, 'Bemerkung Ersteller')}}</div>
                        <div title='{{ $log->{$att_PPTermineChanges_RemarkTranslate} }}' style="border:none;"><textarea {{$RemarkDisabled}} id="StatChange_NewRemark_{{$log->PPTermineChanges_Id}}" style="width:100%; height:60px;border:none;" >{{ $log->{$att_PPTermineChanges_Remark} }}</textarea></div>
                        <div  style='background-color:#c0c0c0;padding:4px;color:#003D7C;border: 1px solid #003D7C;'>{{ ServiceProvider::tl($lang, 'Bemerkung Zuständig')}}</div>
                        <div title='{{ $log->{$att_PPTermineChanges_RemarkReceiverTranslate} }}' style="border:none;">
                        <textarea {{$RemarkRecDisabled}} id="StatChange_NewRemarkReceiver_{{$log->PPTermineChanges_Id}}" style="width:100%; height:60px;border:none;">{{ $log->{$att_PPTermineChanges_RemarkReceiver} }}</textarea>
                        </div>
                    </td>
                    <td class="thCell" style="text-align:center;padding:0px;">@if(strlen($log->URL) > 0)<a href="{{$log->URL}}" target="_blank"><img src="/data/Icons/download.png" style="height:30px;"/></a>@endif</td>
                    <td class="thCell" @if(strlen($log->PPTermineChanges_DoneAt) >= 10) style="background-color:lime;" @endif> 
                        @if(strlen($log->PPTermineChanges_DoneAt) < 10)
                            @if ($log->PPTermineChanges_IsActive == 1) 
                                @if($log->PPTermineChanges_oldStatus == $log->PPTermineChanges_newStatus and $statusInfo == 'Unteraufgabe')
                                    @if ($write)
                                        <button id="btnErledig{{$t['id']}}" onclick="setErledigt({{$t['id']}},{{$log->PPTermineChanges_Id}}, {{$board}});"><img src="/data/Icons/fertig.png" style="height:20px;"></button>
                                    @endif
                                @endif
                                <button id="btnAnswer{{$t['id']}}" onclick="showAnswer({{$log->PPTermineChanges_Id}});" ><img src="/data/Icons/antworten.png" style="height:20px;"></button>
                            @endif
                            @if($statusInfo == 'Unteraufgabe' )
                                @if ($log->PPTermineChanges_IsActive == 0 and (Auth::User()->PPMitarbeiter_Gruppe == 'admin' or Auth::User()->PPMitarbeiter_Kuerzel == $mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id]) )
                                    <button id="btnDelete{{$t['id']}}" onclick="xRestore({{$log->PPTermineChanges_Id}});" ><b>RESTORE</b></button>
                                @else
                                    <?php  
                                    $receiver = '';
                                    if(isset($mitarbeiterliste[$log->PPTermineChanges_Receiver])){
                                        $receiver = $mitarbeiterliste[$log->PPTermineChanges_Receiver];
                                    }
                                    ?>
                                    @if (Auth::User()->PPMitarbeiter_Kuerzel == $mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id] or Auth::User()->PPMitarbeiter_Kuerzel == $receiver or Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                        <button id="btnStore{{$t['id']}}" onclick="xStore({{$log->PPTermineChanges_Id}});" ><img src="/data/Icons/speichern.png" style="height:20px;"></button>
                                    @endif 
                                    @if (Auth::User()->PPMitarbeiter_Kuerzel == $mitarbeiterliste[$log->PPTermineChanges_Mitarbeiter_Id] or Auth::User()->PPMitarbeiter_Gruppe == 'admin')
                                        <button id="btnDelete{{$t['id']}}" onclick="xDelete({{$log->PPTermineChanges_Id}});" ><img src="/data/Icons/loeschen.png" style="height:20px;"></button>
                                    @endif
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
                <tr style="height:0px;" >
                    <td colspan="14"  style="height:0px;">
                        <div class="answer" id="Answer{{$log->PPTermineChanges_Id}}" style="display:none;height:85px;width:100%;padding-left:485px;border:1px solid grey; ">
                            <!---------------- START ----------------->
                            <input type="hidden" id="xStatChange_TermineId_{{$log->PPTermineChanges_Id}}" value = "{{$t['id']}}" />
                            <input type="hidden" id="xStatChange_Categorie_{{$log->PPTermineChanges_Id}}" value = "{{ ServiceProvider::tl($lang, $log->PPTermineChanges_Categorie)}}" />
                            <input type="hidden" id="xStatChange_PPId_{{$log->PPTermineChanges_Id}}" value = "{{$pp['id']}}" />
                            <input type="hidden" id="xStatChange_StatusAlt_{{$log->PPTermineChanges_Id}}" value="{{ ServiceProvider::tl($lang, $t['status'])}}" />
                            <input type="hidden" id="xStatChange_Id_{{$log->PPTermineChanges_Id}}" value="{{$log->PPTermineChanges_Id}}" />
                            <div class="thCellNew" style="width:100px;">
                                <div style="border:1px solid darkblue;padding:4px;">{{ ServiceProvider::tl($lang, 'zuständig')}}</div>
                                <div style="padding:4px;">
                                    <select id="xStatChange_Receiver_{{$log->PPTermineChanges_Id}}" style="width:100px;padding: 5px;">
                                        @foreach ($mitarbeiterliste as $mid => $ma)
                                        <option  title='{{ isset($mitarbeiterNamen[$mid]->PPMitarbeiter_Name)?$mitarbeiterNamen[$mid]->PPMitarbeiter_Name.", ".$mitarbeiterNamen[$mid]->PPMitarbeiter_Vorname:"NNN";  }}' value="{{$mid}}">{{$ma}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="thCellNew" style="width: 90px;">
                                <div style="border:1px solid darkblue;padding:4px;">{{ ServiceProvider::tl($lang, 'erledigen bis') }}</div>
                                <div style="padding:4px;">
                                    <input style="width:100px;padding: 5px;" id="xStatChange_DoUntil_{{$log->PPTermineChanges_Id}}" class="datepickerZukunft" value="{{\Carbon\Carbon::parse($log->PPTermineChanges_DoneAt)->addDays(7)->format('d.m.Y')}}"/>
                                </div>
                            </div>
                            <div class="thCellNew">
                                <div style="border:1px solid darkblue;padding:4px;">{{ ServiceProvider::tl($lang, 'Bemerkung') }}</div>
                                <div style="padding:4px;">
                                    <input type="text" style="width:380px;padding: 5px;" id="xStatChange_Remark_{{$log->PPTermineChanges_Id}}" placeholder="{{ ServiceProvider::tl($lang, 'Bemerkung') }}" />
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
                                <div style="border:1px solid darkblue;padding:4px;">Store</div>
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
<script>
    function showDeleted (){
        //alert('showDeleted');
        var elems = document.getElementsByName("trDelete");
        for (var i=0; i <= elems.length; i++) {
            console.log("Pos: " + i + " L:" + elems.length);
            elems[i].className = "throw";
        }
    }
</script>